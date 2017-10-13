<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class Admin_api_model extends CI_Model
    {

        function __construct()
        {
            parent::__construct();
        }


        function get_subjects_by_class($class_id , $section_id)
        {
            $query = $this->db->get_where('subject', array('class_id' => $class_id, 'section_id' => $section_id));

            return $query->result_array();
        }  

        function get_top_students($exam_id, $class_id, $section_id, $ranking_id)
        {

           
          
           $this->db->where( 'ranking_id' , $ranking_id );
            $this->db->from("cwa_ranking");
          
           $result  = $this->db->get()->row();
          $subject_limit = '';
          
           if($result)
           {
              $percent = $result->percent;
              $percent_limit = $result->percent_limit;
              $number_subjects = $result->number_subjects;
              $subject_limit  = $result->subject_limit;
           }
           
           //echo "<br>here percent is $percent and percent limit is $percent_limit";
          $percent_value = '';
          
           
           switch($percent_limit)
           {
              case 'greater':
                $percent_value = " > ";
              break;
              case 'equal':
                $percent_value = " = ";
              break;  
           }
           
           
           switch($subject_limit)
           {
              case 'greater':
                $subject_limit = " >";
              break;
              case 'equal':
                $subject_limit = " >= ";
              break;  
           }            
           $rs =  $this->get_subjects_by_class($class_id, $section_id);
           $arrSubject = array();
           $subject_string = "";
           foreach ($rs as $row)
           { 
                $arrSubject[] =  $row['subject_id'];
           }
           
           if(count($arrSubject))
           {
                $subject_string = "'".implode(",", $arrSubject)."'";
           }  
           
              $query = "SELECT `mark_obtained`,student_id,count(student_id) ,  (`mark_obtained` /`mark_total`)*100 AS percentage  FROM `mark` WHERE `exam_id`= $exam_id  and class_id = '$class_id' and section_id = '$section_id' AND  ((`mark_obtained` /`mark_total`)*100) $percent_value $percent and FIND_IN_SET(subject_id,$subject_string)  GROUP BY student_id,subject_id";
           
           $rs = $this->db->query($query)->result_array();
           
           $stuArray = array();
          // echo "<br>here subject limit is ".htmlentities($subject_limit);
           foreach($rs as $row_value)
           {
              
              //print_r($row_value);
              $student_id = $row_value['student_id'];
              if(isset($stuArray[$student_id]))
                $stuArray[$student_id] +=1;
              else
                $stuArray[$student_id] = 0 ;
              //$stuArray[$row_value['student_id']] +=1;
           }
          
           $topStudents = array();
           print_r($stuArray);
           foreach($stuArray as $arr => $value)
           {
              $str = $value.$subject_limit.$number_subjects;
              echo "<br>here str is $str";
              if(!empty($value))
              {
                if($str)
                    $topStudents[] = $arr;
                 else
                    $topStudents[] = '';
             }        

           }
          
           $stu_string = '';
           $stu_string = "'".implode("','", $topStudents)."'";
           $query = "select * from student where student_id in (".$stu_string.")";
           $rs = $this->db->query($query)->result_array();
         return $rs;
            
             //     return $rs;
            
    
        }
    
        // get student id
        public function get_student_detail( $student_id ) {
            
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

        function get_teachers()
        {
            $query = $this->db->get('teacher');
            return $query->result_array();
        }
        
        function get_classes()
        {
            $query = $this->db->get('class');
            return $query->result_array();
        }

        function get_all_present_student($date)
        {

       
           
           $query = "Select attn.attendance_id, attn.student_id, attn.status, 
                    stu.student_id, stu.name AS student_name, stu.lname as lname from attendance as attn
                    inner join student as stu on attn.student_id  =   stu.student_id where
                     DATE_FORMAT(FROM_UNIXTIME(TIMESTAMP), '%d-%m-%Y') = '$date'";
            $rs = $this->db->query($query)->result_array();
            return $rs;
            //echo $this->db->last_query();
        
        }

        function get_teacher_info($teacher_id)
        {
            $query = $this->db->get_where('teacher', array('teacher_id' => $teacher_id));
            return $query->result_array();
        }

        function get_fee_detail($date, $class_id)
        {
          if(!empty($class_id))
            $condition = "AND `crm_accounts`.`gid` = '$class_id'";
           $query =  "SELECT `sys_invoices`.* FROM `sys_invoices` left JOIN `crm_accounts` ON `sys_invoices`.`userid` = `crm_accounts`.`id` WHERE `sys_invoices`.`status` != 'paid'  HAVING `sys_invoices`.`duedate` <= '$date' ORDER BY `sys_invoices`.`duedate` DESC";
            $rsStudent=$this->db->query($sql)->result_array();
            return $rsStudent; 
        }

       

    }
    