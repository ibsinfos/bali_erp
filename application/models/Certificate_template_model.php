<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Certificate_template_model extends CI_Model {

    private $_table = "certificate_template_types";
    private $_table_certificate_template_merge = "certificate_template_merge";
    
    
    function __construct() {
        parent::__construct();
    }

    function add($dataArr){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $dataArr['school_id'] = $school_id;
            } 
        }
        $this->db->insert($this->_table, $dataArr);
        return $this->db->insert_id();
    }
    
    function add_certificate_template_merge($dataArr){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $dataArr['school_id'] = $school_id;
            } 
        }
        $this->db->insert($this->_table_certificate_template_merge, $dataArr);
        return $this->db->insert_id();
    }
    
    function get_template_certificate_merge_array($certificate_type_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('certificate_template_merge.school_id',$school_id);
            } 
        }
        $return = array();
        $this->db->select("certificate_template_merge.*,certificate_template_types.*");
        $this->db->from($this->_table_certificate_template_merge);
        $this->db->join($this->_table, 'certificate_template_types.certificate_template_type_id = certificate_template_merge.template_id');
        $this->db->where('certificate_template_merge.certificate_type_id =' .$certificate_type_id);
        $this->db->order_by("certificate_template_merge.certificate_template_merge_id", "desc");             
        return $this->db->get()->result_array();
    }
    
     function delete($where){
            $this->db->where('certificate_template_type_id',$where);
            $this->db->delete($this->_table);
    }  
            
    function get_data_by_id($id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        }
     return $this->db->get_where($this->_table, array('certificate_template_type_id' => $id))->row();
         }
         
    function update($dataArray, $condition){
        $this->db->where($condition);
        $this->db->update($this->_table, $dataArray);
//        echo $this->db->last_query(); die;
        return;
    }
    
    function get_template_array($dataArray = "") {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        }
        $return = array();
        $this->db->select("*");
        $this->db->from($this->_table);
        $this->db->order_by("certificate_template_type_id", "desc");
        if (!empty($dataArray)) {
            $this->db->where($dataArray);
        }       
        return $this->db->get()->result_array();
    }
    
                
    function update_status($dataArray, $condition){
        $this->db->where($condition);
        $this->db->update($this->_table, $dataArray);
//        echo $this->db->last_query(); die;
    }
    
    function delete_template_merge($where){
            $this->db->where('certificate_template_merge_id',$where);
            $this->db->delete($this->_table_certificate_template_merge);
            return;
    }      
}