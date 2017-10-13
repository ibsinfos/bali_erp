<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Student_online_exam_attempt_model extends CI_Model {
    
     private $_table =   "student_online_exam_attempt";

    function __construct() {
        parent::__construct();
    }
    
    function get_total_time($exam_id,$student_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql="SELECT TIMEDIFF(end_time,start_time)as time_taken FROM student_online_exam_attempt where exam_id='$exam_id' and student_id='$student_id' and school_id = '".$school_id."'";
            } 
        } else {
            $sql="SELECT TIMEDIFF(end_time,start_time)as time_taken FROM student_online_exam_attempt where exam_id='$exam_id' and student_id='$student_id'";
        }
        
        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }
    function get_total_time_teacher_login($exam_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql="SELECT TIMEDIFF(end_time,start_time)as time_taken FROM student_online_exam_attempt where exam_id='$exam_id' and school_id = '".$school_id."'";
            } 
        } else {
            $sql="SELECT TIMEDIFF(end_time,start_time)as time_taken FROM student_online_exam_attempt where exam_id='$exam_id'";
        }
        
        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }
}

