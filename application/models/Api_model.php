<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class Api_model extends CI_Model
    {

        function __construct()
        {
            parent::__construct();
        }

        function save_parents_token($dataValues)
        {
            $return = false;
            if (!empty($dataValues))
            {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                    $this->db->where("school_id",$school_id);
                } 
                $this->db->select("*");
                $this->db->from("parent");
                $this->db->where("email", $dataValues['email']);
                $rows = $this->db->get()->num_rows();
                if (empty($rows))
                {
                    if($school_id > 0){
                        $dataValues['school_id'] = $school_id;
                    } 
                    $this->db->insert("parent", $dataValues);
                }
                else
                {
                    $this->db->where('email', $dataValues['email']);
                    $this->db->update('parent', $dataValues);
                }
                $return = true;
            }
            return $return;
        }

        function get_parents_token($parent_id)
        {
            $return = false;
            if (!empty($parent_id))
            {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                    $this->db->where("school_id",$school_id);
                } 
                $this->db->select("*");
                $this->db->from("parent");
                $this->db->where("parent_id", $parent_id);
                $rows = $this->db->get()->row();
                if (!empty($rows))
                {
                    $return = $rows->api_token;
                }
            }
            return $return;
        }
        // get student id
        public function get_student_detail( $student_id ) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where("std.school_id",$school_id);
            } 
            //$running_year = $this->get_setting_record(array('type' => 'running_year'), 'description');
            $this->db->select("std.* , par.email as par_email , par.father_name, par.father_mname, par.father_profession, par.father_qualification, par.father_passport_number, par.mother_name, par.mother_mname, par.mother_lname, par.mother_profession, par.mother_quaification, par.mother_passport_number, par.father_icard_no, par.father_icard_type, par.mother_icard_no, par.mother_icard_type, par.father_school, par.father_department, par.father_income, par.father_designation, par.mother_school, par.mother_department, par.mother_income, par.mother_designation, par.home_phone, par.work_phone, par.mother_email, par.mother_mobile, par.zip_code, par.cell_phone, par.father_lname, par.state, std.password as student_pass" );
            $this->db->from("student AS std");            
            //$this->db->join( 'enroll AS enr' , 'std.student_id = enr.student_id' );
            $this->db->join( 'parent AS par' , 'std.parent_id = par.parent_id' );
           // $this->db->join( 'class AS cls' , 'enr.class_id = cls.class_id' );
            
            //$this->db->where( 'enr.year' , $running_year );
            
            
                $this->db->where( 'std.student_id' , $student_id );
               // echo $this->db->last_query(); 
                $result  = $this->db->get()->row();
                     
           return $result;
        }

        // get all present students

        function get_all_present_student($date)
        {
            $where = "";
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $where = " AND school_id = '".$school_id."'";
            } 
           
           $query = "Select attn.attendance_id, attn.student_id, attn.status, 
                    stu.student_id, stu.name AS student_name, stu.lname as lname from attendance as attn
                    inner join student as stu on attn.student_id  =   stu.student_id where
                     DATE_FORMAT(FROM_UNIXTIME(TIMESTAMP), '%d-%m-%Y') = '$date'".$where;
            $rs = $this->db->query($query)->result_array();
            return $rs;
            //echo $this->db->last_query();
        
        }

        function get_teacher_info($teacher_id)
        {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where("school_id",$school_id);
            } 
            $query = $this->db->get_where('teacher', array('teacher_id' => $teacher_id));
            return $query->result_array();
        }

        function get_fee_detail($date, $class_id)
        {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $where = " AND school_id = '".$school_id."'";
            } 
          if(!empty($class_id))
            $condition = "AND `crm_accounts`.`gid` = '$class_id'";
           $query =  "SELECT `sys_invoices`.* FROM `sys_invoices` left JOIN `crm_accounts` ON `sys_invoices`.`userid` = `crm_accounts`.`id` WHERE `sys_invoices`.`status` != 'paid' ".$where."  HAVING `sys_invoices`.`duedate` <= '$date' ORDER BY `sys_invoices`.`duedate` DESC";
            $rsStudent=$this->db->query($sql)->result_array();
            return $rsStudent; 
        }

    }
    