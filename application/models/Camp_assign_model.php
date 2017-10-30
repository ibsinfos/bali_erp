<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Camp_assign_model extends CI_Model {

    private $_table = "assign_camp";
    private $_table_medical_camp = "medical_comp";
    private $_table_section = "section";
    private $_table_class = "class";
    private $_table_student = "student";
 
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
    
   
     function delete_assigncamp($where){
            $this->db->where('medical_camp_id',$where);
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
     return $this->db->get_where($this->_table, array('assign_camp_id' => $id))->row();
       }
         
    function update_assigncamp($dataArray, $condition){
        $this->db->where($condition);
        $this->db->update($this->_table, $dataArray);
//        echo $this->db->last_query(); die;
        return;
    }
    
    function get_assigncamp_array($dataArray = "") {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('assign_camp.school_id',$school_id);
            } 
        }
        $return = array();
        $this->db->select("assign_camp.*, class.class_id, class.name as class_name, section.section_id, section.name as section_name, medical_comp.camp_name, student.name as student_name");
        $this->db->from($this->_table);
        $this->db->join($this->_table_medical_camp, 'medical_comp.medical_camp_id = assign_camp.medical_camp_id','left');
        $this->db->join($this->_table_class, 'class.class_id  = assign_camp.class_id', 'left');
        $this->db->join($this->_table_section, 'section.section_id  = assign_camp.section_id', 'left');
        $this->db->join($this->_table_student, 'student.student_id  = assign_camp.student_id', 'left');
        $this->db->order_by("assign_camp.assign_camp_id", "desc");       
        
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
    
    function get_assigncamp_list($dataArray = "") {
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