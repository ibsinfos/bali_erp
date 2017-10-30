<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Refund_model extends CI_Model {

    private $_table_refund_request = "refund_request";
    private $_table_refund_types = "refund_types";
    private $_table_refund_rules = "refund_rules";
    private $_table_fee_collections = "fee_collections";
    private $_table_class = "class";
    private $_table_accountant = "accountant";
    private $_table_enroll = "enroll";

    public function __construct() {
        parent::__construct();
    }
    
    public function get_refund_types($running_year=false) {
        $running_year = $running_year?$running_year:$this->session->userdata('running_year');
        _school_cond();
        
        return $this->db->get_where($this->_table_refund_types,array('running_year'=>$running_year))->result_array(); 
    }

    public function save_refund_type($data) {
        $this->db->insert($this->_table_refund_types, $data);
        return $this->db->insert_id();
    }
    
    public function update_refund_type($data,$type_id) { 
        $chkExist = $this->db->where("id != '".$type_id."'")->get_where($this->_table_refund_types,array('name'=>$data['name']))->result_array(); 
        if(count($chkExist)>0) {
            return 0;
        } else {
            $this->db->where('id',$type_id);
            $this->db->update($this->_table_refund_types,$data);
            return 1;
        }
    }
    
    public function deleteRefundType($data) {
        return $this->db->delete($this->_table_refund_types,$data);
    }
    
    public function get_single_refund_type($type_id) {
        _school_cond();
        return $this->db->get_where($this->_table_refund_types,array('id' => $type_id))->result_array(); 
    }

    public function save_refund_request($data) {
        $this->db->insert($this->_table_refund_request, $data);
        return $this->db->insert_id();
    }
    
    public function update_refund_rule($data,$rule_id){
        $this->db->where('id',$rule_id);
        return $this->db->update($this->_table_refund_rules,$data);
    }
    
    public function deleteRefundRule($data) {
        return $this->db->delete($this->_table_refund_rules,$data);
    }
    
    public function get_single_refund_rule($rule_id) {
        _school_cond();
        return $this->db->get_where($this->_table_refund_rules,array('id' => $rule_id))->result_array(); 
    }
    
    public function get_refund_rules() {
        _school_cond('RR.school_id');
        _year_cond('RR.running_year');
        $this->db->select('RR.*,FG.name fee_group_name,FT.name term_name,FST.name setup_term_name');
        $this->db->from($this->_table_refund_rules.' RR');
        $this->db->join('fee_groups FG','FG.id=RR.fee_group_id','LEFT');
        $this->db->join('fee_terms FT','FT.id=RR.term_type_id','LEFT');
        $this->db->join('fee_setup_terms FST','FST.id=RR.setup_term_id','LEFT');
        return $this->db->get()->result_array(); 
    }


    public function get_non_approve_refund_list($accountant_id) {
        $this->db->select('req.refund_request_id, req.refund_amount, fc.name collection_name, rr.name refund_rule_name, en.enroll_code, acc.name requester_name');
        $this->db->from($this->_table_refund_request.' req');
        $this->db->join($this->_table_fee_collections.' fc', 'fc.id = req.collection_id');
        $this->db->join($this->_table_refund_rules.' rr', 'rr.id = req.refund_rule_id');
        $this->db->join($this->_table_enroll.' en', 'en.enroll_id = req.enroll_id');
        $this->db->join($this->_table_accountant.' acc', 'acc.accountant_id = req.requester_cashier_id');        
        $this->db->where(array('req.request_to_id'=>$accountant_id, 'req.school_id'=>$this->session->userdata('school_id')));
        $this->db->where('req.request_status !=', '1');

        $this->db->order_by('req.refund_request_id', 'desc');

        return $this->db->get()->result_array();
    }

    public function get_approve_refund_list($accountant_id) {
        $this->db->select('req.refund_request_id, req.refund_amount, fc.name collection_name, rr.name refund_rule_name, en.enroll_code, acc.name requester_name');
        $this->db->from($this->_table_refund_request.' req');
        $this->db->join($this->_table_fee_collections.' fc', 'fc.id = req.collection_id');
        $this->db->join($this->_table_refund_rules.' rr', 'rr.id = req.refund_rule_id');
        $this->db->join($this->_table_enroll.' en', 'en.enroll_id = req.enroll_id');
        $this->db->join($this->_table_accountant.' acc', 'acc.accountant_id = req.requester_cashier_id');        
        $this->db->where(array('req.request_to_id'=>$accountant_id, 'req.request_status' => '1', 'req.school_id'=>$this->session->userdata('school_id')));

        $this->db->order_by('req.refund_request_id', 'desc');

        return $this->db->get()->result_array();
    }

    public function save_refund_rule($data) {
        $this->db->insert($this->_table_refund_rules, $data);
        return $this->db->insert_id();
    }

    public function approve_reject_refund_request($id, $data) {
        $this->db->where('refund_request_id',$id);
        $this->db->update($this->_table_refund_request,$data);
    }

    function get_refund_rule(){        
        $this->db->select('rr.id, rr.name rule_name');
        $this->db->from($this->_table_refund_rules.' rr');
        $this->db->order_by('rr.name', 'asc');
        return $this->db->get()->result_array();
    }

    function get_refund_amount($CollectionId, $RuleId){
        $CollectionAmount = $this->db->get_where($this->_table_fee_collections, array('id'=>$CollectionId))->row()->amount;

        $this->db->select('rr.amount_type, rr.amount');
        $this->db->from($this->_table_refund_rules.' rr');
        $this->db->where('rr.id', $RuleId);
        $RuleData = $this->db->get()->result_array();
        if($RuleData[0]['amount_type']==1){
            $RefundAmount = ((($CollectionAmount)*($RuleData[0]['amount']))/100);
            return round($RefundAmount, 2);
        }else if($RuleData[0]['amount_type']==2){
            $RefundAmount = ($CollectionAmount - $RuleData[0]['amount']);
            return round($RefundAmount, 2);
        }else{
            return false;
        }
    }

    //Pradeep Worked
    function get_rule_rec($whr=array()){
        _school_cond();
        _year_cond();
        $this->db->where($whr);
        return $this->db->get('refund_rules')->row();
    }

    function get_refund_record($whr=array()){
        _school_cond();
        _year_cond();
        return $this->db->get_where('refund_request',$whr)->row();
    }

    function save_refund($data){
        return $this->db->insert('refund_request',$data);
    }

    function get_refund_list($whr=array()){
        _school_cond('RR.school_id');
        _year_cond('RR.running_year');
        $this->db->select('RR.*,FST.name term_name,CONCAT(ST.name,ST.lname) student_name',false);
        $this->db->from('refund_request RR');
        $this->db->join('student ST','ST.student_id=RR.student_id','LEFT');
        $this->db->join('fee_pay_collection_records PCR','PCR.id=RR.pay_collection_id','LEFT');
        $this->db->join('fee_setup_terms FST','FST.id=PCR.fee_id','LEFT');
        $this->db->where($whr);
        $this->db->group_by('RR.refund_request_id');
        return $this->db->get('refund_request')->result();
    }
}
