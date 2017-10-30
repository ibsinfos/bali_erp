<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Certificate_authorities_model extends CI_Model {

    private $_table = "certificate_authorities";
    
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
    
   
     function delete_authorities($where){
            $this->db->where('certificate_authorities_id',$where);
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
     return $this->db->get_where($this->_table, array('certificate_authorities_id' => $id))->row();
         }
         
    function update_authorities($dataArray, $condition){
        $this->db->where($condition);
        $this->db->update($this->_table, $dataArray);
//        echo $this->db->last_query(); die;
        return;
    }
    
    function get_authorities_array($dataArray = "") {
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
        $this->db->order_by("certificate_authorities_id", "desc");
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
    
    function get_camp_list($dataArray = "") {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('medical_comp.school_id',$school_id);
            } 
        }
        $return = array();
        $this->db->select("medical_comp.*, doctors.name, doctors.doctor_id, class.class_id, class.name as class_name");
        $this->db->from($this->_table);
        $this->db->join($this->_table_doctor, 'doctors.doctor_id = medical_comp.doctor_id','left');
        $this->db->join($this->_table_class, 'class.class_id  = medical_comp.class_id', 'left');
        $this->db->order_by("medical_camp_id", "desc");
        
        if (!empty($dataArray)) {
            $this->db->where($dataArray);
        }       
        return $this->db->get()->result_array();
    } 
}