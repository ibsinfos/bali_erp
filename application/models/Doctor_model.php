<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Doctor_model extends CI_Model {

    private $_table = "doctors";
 
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
    
   
     function delete_doctor($where){
            $this->db->where('doctor_id',$where);
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
     return $this->db->get_where($this->_table, array('doctor_id' => $id,'isActive' => '1'))->row();
         }
         
    function update_doctor($dataArray, $condition){
        $this->db->where($condition);
        $this->db->update($this->_table, $dataArray);
//        echo $this->db->last_query(); die;
//        return;
    }
    
    function get_doctor_array($dataArray = "") {
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
        $this->db->order_by("doctor_id", "desc");
        if (!empty($dataArray)) {
            $this->db->where($dataArray);
        }       
        return $this->db->get()->result_array();
    }   
         
    function update_status($dataArray, $condition){
        $this->db->where($condition);
        $this->db->update($this->_table, $dataArray);
        echo $this->db->last_query(); die;
    }
}