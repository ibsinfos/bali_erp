<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Experience_certificate_model extends CI_Model {

    private $_table = "experience_certificate";
    private $_internship_certificate_table = "internship_certificate";
    
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
    
    function add_internship_certificate($dataArr){
          $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $dataArr['school_id'] = $school_id;
            } 
        }
        $this->db->insert($this->_internship_certificate_table, $dataArr);
        return $this->db->insert_id();
    }
   
            
    function get_data_by_id($id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        }
       return $this->db->get_where($this->_table, array('teacher_id' => $id))->row();
    }
    
                
    function get_internship_certificate_by_id($id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        }
       return $this->db->get_where($this->_internship_certificate_table, array('teacher_id' => $id))->row();
    }
       
}