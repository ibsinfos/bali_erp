<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Fees_model extends CI_Model {

    private $_table_fee_collections = "fee_collections";

    public function __construct() {
        parent::__construct();
    }
   
    /********************Fee Category functions***************/
    public function get_fee_categories($running_year=false,$school_id=false) {
        $running_year = $running_year?$running_year:$this->session->userdata('running_year');
        $school_id = $school_id?$school_id:$this->session->userdata('school_id');
        //_school_cond();
        $this->db->select('FC.*,(SELECT COUNT(*) FROM fee_particulars WHERE fee_category_id=FC.cat_id) trans');
        $this->db->from('fee_categories FC');
        $this->db->where(array('FC.running_year'=>$running_year,'FC.school_id'=>$school_id));
        return $this->db->get()->result(); 
    }

    public function save_fee_category($data) {
        $flag = false;
        if(isset($data['cat_id']) && $data['cat_id']){
            $this->db->update('fee_categories', $data, array('cat_id'=>$data['cat_id']));
            $flag = $data['cat_id'];
        }else{
            $this->db->insert('fee_categories', $data);
            $flag = $this->db->insert_id();
        }
        return $flag;
    }

    function get_category_record($id){
        return $this->db->get_where('fee_categories',array('cat_id'=>$id))->row();
    }

    function category_delete($whr=array()){
        return $this->db->delete('fee_categories',$whr);
    }
    
    /********************Fee Particular functions***************/
    public function get_fee_heads($running_year=false) {
        _school_cond();
        $running_year = $running_year?$running_year:$this->session->userdata('running_year');
        return $this->db->get_where('fee_heads',array('running_year'=>$running_year))->result(); 
    }

    public function save_fee_head($data) {
        $flag = false;
        if(isset($data['id']) && $data['id']){
            $this->db->update('fee_heads', $data, array('id'=>$data['id']));
            $flag = $data['id'];
        }else{
            $this->db->insert('fee_heads', $data);
            $flag = $this->db->insert_id();
        }
        return $flag;
    }

    function get_head_record($id){
        return $this->db->get_where('fee_heads',array('id'=>$id))->row();
    }

    function head_delete($whr=array()){
        return $this->db->delete('fee_heads',$whr);
    }

    /********************Fee Group functions***************/
    public function get_fee_groups($running_year=false,$school_id=false) {
        _school_cond('FG.school_id',$school_id);
        _year_cond('FG.running_year',$running_year);
        $this->db->select('FG.*,(0) trans');
        $this->db->from('fee_groups FG');
        return $this->db->get()->result(); 
    }

    public function save_fee_group($data) {
        $flag = false;
        if(isset($data['id']) && $data['id']){
            $this->db->update('fee_groups', $data, array('id'=>$data['id']));
            $flag = $data['id'];
        }else{
            $this->db->insert('fee_groups', $data);
            $flag = $this->db->insert_id();
        }
        return $flag;
    }

    function save_group_relation($group_id,$post=array()){
        //save heads
        //echo '<pre>';print_r($post);exit;
        $heads = isset($post['heads'])?$post['heads']:array();
        $head_amts = isset($post['head_amount'])?$post['head_amount']:array();
        $head_taxes = isset($post['head_tax'])?$post['head_tax']:array();
        $classes = isset($post['classes'])?$post['classes']:array();
        $this->db->delete('fee_rel_group_heads',array('group_id'=>$group_id));
        $save_array = array();
        if($heads){
            foreach($heads as $h_id){
                $save_array[] = array('group_id'=>$group_id,
                                      'head_id'=>$h_id,
                                      'head_amount'=>(isset($head_amts[$h_id])?$head_amts[$h_id]:0),
                                      'head_tax'=>(isset($head_taxes[$h_id])?$head_taxes[$h_id]:0));
            }
            $this->db->insert_batch('fee_rel_group_heads', $save_array); 
        }

        //save classes
        $this->db->delete('fee_rel_group_class',array('group_id'=>$group_id));
        $save_array = array();
        if($classes){
            foreach($classes as $c_id){
                $save_array[] = array('group_id'=>$group_id,
                                      'class_id'=>$c_id);
            }
            $this->db->insert_batch('fee_rel_group_class', $save_array);
        }
        return true;
    }
 
    function get_group_record($id){
        return $this->db->get_where('fee_groups',array('id'=>$id))->row();
    }

    function group_delete($whr=array()){
        $this->db->delete('fee_rel_group_particular',array('group_id'=>$whr['id']));
        $this->db->delete('fee_rel_group_class',array('group_id'=>$whr['id']));
        return $this->db->delete('fee_groups',$whr);
    }
    
    function get_group_rel($group_id=false){
        $data['rel_heads'] = $this->db->get_where('fee_rel_group_heads',array('group_id'=>$group_id))->result();
        $data['rel_classes'] = $this->db->get_where('fee_rel_group_class',array('group_id'=>$group_id))->result();
        return $data;
    }

    function get_group_heads($group_id=false){
        $this->db->select('FH.*,FRGH.head_amount,FRGH.head_tax');
        $this->db->from('fee_heads FH');
        $this->db->join('fee_rel_group_heads FRGH','FRGH.head_id=FH.id','LEFT');
        $this->db->where('FRGH.group_id',$group_id);
        return $this->db->get()->result();
    }   
    
    function get_group_classes($group_id=false){
        $this->db->select('C.*');
        $this->db->from('class C');
        $this->db->join('fee_rel_group_class FRGC','FRGC.class_id=C.class_id','LEFT');
        $this->db->where('FRGC.group_id',$group_id);
        return $this->db->get()->result();
    }  

    /********************Fee Concessions functions***************/
    public function get_fee_concessions($running_year=false) {
        _school_cond();
        $running_year = $running_year?$running_year:$this->session->userdata('running_year');
        return $this->db->get_where('fee_concessions',array('running_year'=>$running_year))->result(); 
    }

    public function save_fee_concession($data) {
        $flag = false;
        if(isset($data['id']) && $data['id']){
            $this->db->update('fee_concessions', $data, array('id'=>$data['id']));
            return $data['id'];
        }else{
            $this->db->insert('fee_concessions', $data);
            $flag = $this->db->insert_id();
        }
        return $flag;
    }

    function get_concession_record($id){
        return $this->db->get_where('fee_concessions',array('id'=>$id))->row();
    }

    function save_concession_rel($concession_id,$items=array()){
        $this->db->delete('fee_rel_concession_trans',array('concession_id'=>$concession_id));
        $save_data = array();
        foreach($items as $itm){
            $save_data[] = array('concession_id'=>$concession_id,'item_id'=>$itm);
        }
        return $this->db->insert_batch('fee_rel_concession_trans', $save_data);
    }

    function concession_delete($whr=array()){
        $this->db->delete('fee_rel_concession_trans',array('concession_id'=>$whr['id']));
        return $this->db->delete('fee_concessions',$whr);
    }

    /********************Fee Collection_Group functions***************/
    public function get_collection_groups($running_year=false,$school_id=false) {
        _school_cond('FCG.school_id',$school_id);
        _year_cond('FCG.running_year',$running_year);
        $this->db->select('FCG.*,(0) trans');
        $this->db->from('fee_collection_groups FCG');
        return $this->db->get()->result(); 
    }

    public function save_collection_group($data) {
        $flag = false;
        if(isset($data['id']) && $data['id']){
            $this->db->update('fee_collection_groups', $data, array('id'=>$data['id']));
            $flag = $data['id'];
        }else{
            $this->db->insert('fee_collection_groups', $data);
            $flag = $this->db->insert_id();
        }
        return $flag;
    }

    function get_collection_group_record($whr=array()){
        return $this->db->get_where('fee_collection_groups',$whr)->row();
    }

    function collection_group_delete($whr=array()){
        $this->db->delete('fee_collections',array('collection_group_id'=>$whr['id']));
        $this->db->delete('fee_collection_particulars',array('collection_group_id'=>$whr['id']));
        return $this->db->delete('fee_collection_groups',$whr);
    }

    public function save_collection_group_collections($group_id=false,$collections=array()) {
        $flag = false;
        //$this->db->delete('fee_collections',array('collectin_group_id'=>$group_id));
        ///$this->db->delete('fee_collection_particulars',array('collectin_group_id'=>$group_id));
        $save_data = array();
        if($collections){
            foreach($collections as $ck=>$collect){
                $save_array = array('collection_group_id'=>$group_id,
                                    'name'=>$collect['name'],
                                    'start_date'=>$collect['start_date'],
                                    'end_date'=>$collect['end_date'],
                                    'amount'=>$collect['amount'],
                                    'order'=>$ck,
                                    'created'=>date('Y-m-d H:i:s'));
                if(isset($collect['id']) && $collect['id']){
                    $this->db->update('fee_collections', $save_array, array('id'=>$collect['id']));
                    $flag = $collect['id'];
                }else{
                    $this->db->insert('fee_collections', $save_array);
                    $flag = $this->db->insert_id();
                }

                $this->save_collection_particulars($group_id,$flag,$collect['particulars']);
            }
        }
        
        return $flag;
    }

    public function save_collection_particulars($group_id=false,$collection_id=false,$particulars=array()) {
        $flag = false;
        $this->db->delete('fee_collection_particulars',array('collection_id'=>$collection_id));
        $save_data = array();
        if($particulars){
            foreach($particulars as $pa_id=>$part_amt){
                $save_array = array('collection_group_id'=>$group_id,
                                    'collection_id'=>$collection_id,
                                    'particular_id'=>$pa_id,
                                    'amount'=>$part_amt,
                                    'created'=>date('Y-m-d H:i:s'));
               /*  if(isset($collect['id']) && $collect['id']){
                    $this->db->update('fee_collection_groups', $save_array, array('id'=>$data['id']));
                    $flag = $collect['id'];
                }else{ */
                    $this->db->insert('fee_collection_particulars', $save_array);
                    $flag = $this->db->insert_id();
                //}
            }
        }
        
        return $flag;
    }

    function get_collection_group_rel($collection_group_id=false){
        $return = array();
        $collections = $this->db->get_where('fee_collections',array('collection_group_id'=>$collection_group_id))->result();
        foreach($collections as $col){
            $this->db->select('FCP.*,FP.name');
            $this->db->from('fee_particulars FP');
            $this->db->join('fee_collection_particulars FCP','FCP.particular_id=FP.id','LEFT');
            $this->db->where('FCP.collection_id',$col->id);
            $col->particulars = $this->db->get()->result();
            $return[] = $col;
        }
        //$data['collection_particulars'] = $this->db->get_where('fee_collection_particulars',array('collection_group_id'=>$collection_group_id))->result();

        return $return;
    }

    function collection_delete($whr=array()){
        $this->db->delete('fee_collection_particulars',array('collection_id'=>$whr['id']));
        return $this->db->delete('fee_collections',$whr);
    }

    /********************Fee Fines functions***************/
    public function get_fee_fines($running_year=false) {
        _school_cond();
        _year_cond();
        return $this->db->get_where('fee_fines')->result(); 
    }

    public function save_fine($data) {
        $flag = false;
        if(isset($data['id']) && $data['id']){
            $this->db->update('fee_fines', $data, array('id'=>$data['id']));
            $flag = $data['id'];
        }else{
            $this->db->insert('fee_fines', $data);
            $flag = $this->db->insert_id();
        }
        return $flag;
    }

    function get_fine_record($id){
        return $this->db->get_where('fee_fines',array('id'=>$id))->row();
    }

    function fine_delete($whr=array()){
        return $this->db->delete('fee_fines',$whr);
    }

    /********************Other functions***************/
    function get_classes(){
        _school_cond();
        return $this->db->order_by('name_numeric','ASC')->get('class')->result(); 
    }

    function get_students(){
        _school_cond();
        return $this->db->order_by('name','ASC')->get('student')->result();
    }

    function get_collection_data(){        
        $this->db->select('fc.id, fc.name collection_name');
        $this->db->from($this->_table_fee_collections.' fc');
        $this->db->order_by('fc.name', 'asc');
        return $this->db->get()->result_array();
    }
}
