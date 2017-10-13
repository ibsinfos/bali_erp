<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dynamic_field_model extends CI_Model {

    private $_table         =   "student";
    private $_table_dynamic_field="dynamic_fields";
    function __construct() {
        parent::__construct();
    }
    
    public function getDynamicGroup($form_id = null)
    {
        if(!empty($form_id))
            $this->db->where('form_id', $form_id);
        $result = $this->db->get("dynamic_group")->result_array();
        return $result;
    }
    
    public function getDynamicFields($group_id)
    {
     $arrFields = $this->db->from('dynamic_fields')->where(array("group_id" => $group_id, "enable!=" => "N"))->order_by('order_id',"ASC")->get()->result_array();
     return $arrFields;
    }
    function getDynamicQuery($table, $fields, $where)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                if(strtolower($table) != 'country')
                $where.=" AND school_id = '".$school_id."'";
            } 
        }
        if(strtolower($table) == 'dormitory') {
            $where.=" AND dormitory.status = 'Active'";
        }
        $query = "Select $fields from $table where $where";
        
        return $this->db->query($query)->result_array();        
    }

    public function getRFID($RFID)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $where = " AND school_id = '".$school_id."'";
            } 
        }
        $sql = "SELECT `enroll`.`student_id`, `student`.`name` ,`parent`.`cell_phone`, `parent`.`gender`,`parent`.`email`,`parent`.`parent_id`,`class_id`, `section_id`, `year`
                        FROM `student` ,`parent`,`enroll` WHERE `student`.`parent_id`=`parent`.`parent_id` AND `enroll`.`student_id`=`student`.`student_id` AND `card_id`=$RFID".$where;
            return $this->db->query($sql)->result();
    }

    public function student_attendance($class_id, $year, $timestamp)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->query("SELECT * FROM `enroll` WHERE `class_id`= " . $class_id . " AND `year`='" . $year . "' AND `student_id` not in (SELECT `student_id` FROM `attendance` WHERE class_id=$class_id AND school_id = '".$school_id."' AND `status`=1 OR `status`=0 AND `timestamp`=?)", $timestamp)->result_array();
            } 
        } else {
            $this->db->query("SELECT * FROM `enroll` WHERE `class_id`= " . $class_id . " AND `year`='" . $year . "' AND `student_id` not in (SELECT `student_id` FROM `attendance` WHERE class_id=$class_id AND `status`=1 OR `status`=0 AND `timestamp`=?)", $timestamp)->result_array();
        }
    }

    public function update_applied_student($stud_id, $data)
    {
        $this->db->where('student_id', $stud_id);
        $this->db->update('applied_students', $data);
    }

    public function get_students_records($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $student_array = $this->db->get_where('student', $dataArray)->result_array();
        return $student_array;
    }

    public function get_enroll_records($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $enroll_records = $this->db->get_where('enroll', $dataArray)->result_array();
        return $enroll_records;
    }

    public function get_student_name($student_id)
    {
        $n = "";
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $res =  $this->db->get_where($this->_table, array('student_id' => $student_id,'school_id' => $school_id));
            } 
        } else {
            $res =  $this->db->get_where($this->_table, array('student_id' => $student_id));
        }
        if($res->num_rows()){
                $n = $res->row()->name;
        }
       return $n; 
       
    }
    
    function get_student_bulk_upload(){
        $rs=$this->db->select('GROUP_CONCAT(db_field) AS tableCol')->from($this->_table_dynamic_field)->where('form_id',"1")->where('bulk_upload',"1")->get()->result_array();
        //echo $this->db->last_query();
        return $rs;
    }
    
    function get_student_bulk_upload_label(){
        $rs=$this->db->select('GROUP_CONCAT(label) AS tableCol')->from($this->_table_dynamic_field)->where('form_id',"1")->where('bulk_upload',"1")->get()->result_array();
        //echo $this->db->last_query();
        return $rs;
    }
    
    function get_student_bulk_upload_mandatory(){
        $rs=$this->db->select('GROUP_CONCAT(db_field) AS tableCol')->from($this->_table_dynamic_field)->where('form_id',"1")->where('bulk_upload',"1")->where('validation','m')->get()->result_array();
        return $rs;
    }
    
    function get_parent_bulk_upload(){
        $rs=$this->db->select('GROUP_CONCAT(db_field) AS tableCol')->from($this->_table_dynamic_field)->where('form_id',"2")->where('bulk_upload',"1")->get()->result_array();
        return $rs;
    }
    
    function get_parent_bulk_upload_label(){
        $rs=$this->db->select('GROUP_CONCAT(label) AS tableCol')->from($this->_table_dynamic_field)->where('form_id',"2")->where('bulk_upload',"1")->get()->result_array();
        //echo $this->db->last_query();
        return $rs;
    }
    
    function get_parent_bulk_upload_mandatory(){
        $rs=$this->db->select('GROUP_CONCAT(db_field) AS tableCol')->from($this->_table_dynamic_field)->where('form_id',"2")->where('bulk_upload',"1")->where('validation','m')->get()->result_array();
        return $rs;
    }
    
    function get_field_type($db_field){
        $rs= $this->db->select('validation_type')->from($this->_table_dynamic_field)->where('db_field',$db_field)->where('form_id','2')->get()->result_array();
        if(!empty($rs)){
            return $rs[0]['validation_type'];
        }else{
            return FALSE;
        }
    }
    
}