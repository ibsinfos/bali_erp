<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class Crud_model extends CI_Model
    {
        var $column_order = array(null, 'stu.name', 'stu.email', 'bd.phone', 'bd.sex', 'b.name', 't.route_name'); //set column field database for datatable orderable
        var $column_search = array('b.name', 'bd.email', 'bd.phone', 'bd.sex', 'b.name', 't.route_name'); //set column field database for datatable searchable 
        var $order = array('stu.student_id' => 'desc'); // default order 

        function __construct()
        {
            parent::__construct();
        }

        function clear_cache()
        {
            $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
            $this->output->set_header('Pragma: no-cache');
        }

        function get_type_name_by_id($type, $type_id = '', $field = 'name')
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            return $this->db->get_where($type, array($type . '_id' => $type_id))->row()->$field;
        }
   //*******************************************Student Transaction Functions **************************/     
        function getStudentTransaction($student_id)
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            
            $transaction = 0;
            $count = 0;
            $current_date = date("Y-m-d");
            // book issue table
            $result_array =  $this->db->get_where("circulation", array("is_returned" =>"0", "member_id" => $student_id))->result_array();
            $count =  count($result_array);
            if($count > 0)
            {    
                $transaction = 1;
                 return $transaction;
            }
            $result_array =  $this->db->get_where("student_bus_allocation", array("student_id" =>$student_id, "end_date >=" => $current_date))->result_array();
            $count =  count($result_array);
            if($count)
            {    
                $transaction = 1;
                 return $transaction;
            }    
            $result_array =  $this->db->get_where("hostel_registration", array("student_id" =>$student_id, "vacating_date >=" => $current_date))->result_array();
            $count =  count($result_array);
            if($count)
            {    
                $transaction = 1;
                 return $transaction;
            }
            return $transaction;
        }
        
        
        
        
        
    ///***************************************************Student Transaction Fuctions end*************************    

         //*******************************************Subject Transaction Functions **************************/     
        function getSubjectTransaction($subject_id)
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            
            $transaction = 0;
            $count = 0;
            $current_date = date("Y-m-d");
            // book issue table
            $result_array =  $this->db->get_where("exam_routine", array("subject_id" => $subject_id))->result_array();
            $count =  count($result_array);
            if($count)
            {    
                $transaction = 1;
                 return $transaction;
            }
            // 
            
            $result_array =  $this->db->get_where("mark", array("subject_id" =>$subject_id))->result_array();
            $count =  count($result_array);
            if($count)
            {    
                $transaction = 1;
                 return $transaction;
            }
            
            
            return $transaction;
        }
        
        
        
        
        
    ///***************************************************Subject Transaction Fuctions end*************************    
    //*******************************************Class Transaction Functions **************************/     
    function getClassTransaction($class_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        }
        $transaction = 0;
        $count = 0;
         
        //Subject table
        $result_array = $this->db->get_where("subject", array("class_id" => $class_id))->result_array();
        $count = count($result_array);
        if($count)
            $transaction = 1;
        //Attendance table
        $result_array = $this->db->get_where("attendance", array("class_id" => $class_id))->result_array();
        $count = count($result_array);
        if($count)
            {    
                $transaction = 1;
                 return $transaction;
            }

        //Section table
        $result_array = $this->db->get_where("section", array("class_id" => $class_id))->result_array();
        $count = count($result_array);
        if($count)
            {    
                $transaction = 1;
                 return $transaction;
            }
        //Bus Attendance table
        $result_array = $this->db->get_where("bus_attendence", array("class_id" => $class_id))->result_array();
        $count = count($result_array);
        if($count)
            {    
                $transaction = 1;
                 return $transaction;
            }
        //Student Assignment table
        $result_array = $this->db->get_where("student_assignments", array("class_id" => $class_id))->result_array();
        $count = count($result_array);
        if($count)
            {    
                $transaction = 1;
                 return $transaction;
            }
        //echo $transaction."<br>"; 
        
        return $transaction;
    }
    //*******************************************Class Transaction Functions **************************/     
    //*******************************************Section Transaction Functions **************************/     
    function getSectionTransaction($section_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        }
        $transaction = 0;
        $count = 0;
        
        
        //Subject table
        $result_array = $this->db->get_where("subject", array("section_id" => $section_id))->result_array();
        $count = count($result_array);
            if($count)
            {    
                $transaction = 1;
                 return $transaction;
            }       //Attendance table
        $result_array = $this->db->get_where("attendance", array("section_id" => $section_id))->result_array();
        $count = count($result_array);
         if($count)
            {    
                $transaction = 1;
                 return $transaction;
            }       //Exam Routine table
        $result_array = $this->db->get_where("exam_routine", array("section_id" => $section_id))->result_array();
        $count = count($result_array);
        if($count)
            {    
                $transaction = 1;
                 return $transaction;
            }  
   
        
        return $transaction;
    }
     //*******************************************Section Transaction Functions **************************/     
     //*******************************************VehicleDetails Transaction Functions **************************/     
    function getVehicleTransaction($bus_id,$bus_driver_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        }
        $transaction = 0;
        $count = 0;
         
        
        //Bus table
        $result_array = $this->db->get_where("bus", array("bus_driver_id" => $bus_driver_id))->result_array();
        $count = count($result_array);
            if($count)
            {    
                $transaction = 1;
                 return $transaction;
            }  
        //Busdriver table
        $result_array = $this->db->get_where("bus_driver", array("bus_driver_id" => $bus_driver_id, "bus_id"=>$bus_id))->result_array();
        $count = count($result_array);
        
            if($count)
            {    
                $transaction = 1;
                 return $transaction;
            }  
        
        return $transaction;
    }
     //*******************************************VehicleDetails Transaction Functions **************************/           
     //*******************************************Grade Transaction Functions **************************/     
    function getGradeTransaction($grade_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        }
        $transaction = 0;
        $count = 0;
         
        
        //Grade Evaluation table
        $result_array = $this->db->get_where("grading_evaluation", array("grade_id" => $grade_id))->result_array();
        $count = count($result_array);
        
        if($count)
            {    
                $transaction = 1;
                 return $transaction;
            }  
        
        return $transaction;
    }
     //*******************************************Grade Transaction Functions **************************/           
     ////*******************************************Exam Transaction Functions **************************/     
    function getExamTransaction($exam_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        }
        $transaction = 0;
        $count = 0;
         
       //Exam_routine table
        $result_array = $this->db->get_where("exam_routine", array("exam_id" => $exam_id))->result_array();
        $count = count($result_array);
        
        if($count)
            {    
                $transaction = 1;
                 return $transaction;
            }  
        
        return $transaction;
    }
     //*******************************************Exam Transaction Functions **************************/          
     //*******************************************Bus Transaction Functions **************************/     
    function getBusTransaction($bus_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        }
        $transaction = 0;
        $count = 0;
         
        //Bus Attendance
        $result_array = $this->db->get_where("bus_attendence", array("bus_id" => $bus_id))->result_array();
        $count = count($result_array);
        if($count)
            {    
                $transaction = 1;
                 return $transaction;
            }  
        //echo $this->db->last_query()."<hr>";exit;
        //Bus Driver table
        $result_array = $this->db->get_where("bus_driver", array("bus_id" => $bus_id, "bus_id"=>$bus_id))->result_array();
        $count = count($result_array);
        if($count)
            {    
                $transaction = 1;
                 return $transaction;
            }  
        // echo $this->db->last_query()."<hr>";
         //Bus Driver Attendance
        $result_array = $this->db->get_where("bus_driver_attendence", array("bus_id" => $bus_id))->result_array();
        $count = count($result_array);
         //echo $this->db->last_query()."<hr>";
        if($count)
            {    
                $transaction = 1;
                 return $transaction;
            }  
        
        return $transaction;
    }
     //*******************************************Bus Transaction Functions **************************/           
    //*******************************************BusDriver Transaction Functions **************************/     
//    function getBusDriverTransaction($bus_id){
//        $transaction = 0;
//        $count = 0;
//         
//        //BusDriver Table
//        $result_array = $this->db->get_where("bus_driver", array("bus_id" => $bus_id))->result_array();
//        $count = count($result_array);
//        
//        
//        
//        if($count)
//            $transaction = 1;
//        
//        return $transaction;
//    }
     //*******************************************BusDriver Transaction Functions **************************/
    //*******************************************Transport Transaction Functions **************************/     
    function getTransportTransaction($route_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        }
        $transaction = 0;
        $count = 0;
         
        //Rout Bus Stop table
        $result_array = $this->db->get_where("route_bus_stop", array("route_id" => $route_id))->result_array();
        $count = count($result_array);
          if($count)
            {    
                $transaction = 1;
                 return $transaction;
            }         
        //Bus Attendance table
        $result_array = $this->db->get_where("bus_attendence", array("route_id" => $route_id))->result_array();
        $count = count($result_array);
        if($count)
            {    
                $transaction = 1;
                 return $transaction;
            }  
        
         //Bus  Table
        $result_array = $this->db->get_where("bus", array("route_id" => $route_id))->result_array();
        $count = count($result_array);
        if($count)
            {    
                $transaction = 1;
                 return $transaction;
            }  
        
        
        return $transaction;
    }
     //*******************************************Transport Transaction Functions **************************/           

    /*************************************Roles and Rights Fucntions****************************************/
    function getStructure($form_id)
    {
        // 1 for student
        switch($form_id)
        {
            case '1':
                $query = "SHOW COLUMNS FROM student";
                $result = $this->db->query($query)->result();
                $arrFields = array();
                foreach($result as $row)
                {
                    $arrFields[] = $row->Field;
                }
                $query = "SHOW COLUMNS FROM sys_stud_feeconfig";
                $result = $this->db->query($query)->result();
                
                foreach($result as $row)
                {
                    $arrFields[] = $row->Field;
                }
                $query = "SHOW COLUMNS FROM enroll";
                $result = $this->db->query($query)->result();
                
                foreach($result as $row)
                {
                    $arrFields[] = $row->Field;
                }
            break;
            case '2':
                $query = "SHOW COLUMNS FROM parent";
                $result = $this->db->query($query)->result();
                $arrFields = array();
                foreach($result as $row)
                {
                    $arrFields[] = $row->Field;
                }
                $query = "SHOW COLUMNS FROM guardian;";
                $result = $this->db->query($query)->result();
                
                foreach($result as $row)
                {
                    $arrFields[] = $row->Field;
                }
            break;
            case '3':
                $query = "SHOW COLUMNS FROM enquired_students;";
                $result = $this->db->query($query)->result();
                $arrFields = array();
                foreach($result as $row)
                {
                    $arrFields[] = $row->Field;
                }
                $query = "SHOW COLUMNS FROM guardian;";
                $result = $this->db->query($query)->result();
                
                foreach($result as $row)
                {
                    $arrFields[] = $row->Field;
                }
               
            break;
        } 
      
        return $arrFields;
    }
    
    function alter_table_varchar($table_name, $field)
    {
        $query = "ALTER TABLE $table_name ADD $field VARCHAR(50);"; 
        $result = $this->db->query($query);
    }
    function alter_table_enum($table_name, $field, $arr_values)
    {
     
        $arr_values = array_unique($arr_values);
        $string =  "'" . implode("','", $arr_values) . "'";
        $query = "ALTER TABLE $table_name ADD $field  enum($string);"; 
        $result = $this->db->query($query);
    }
    
    function getUserRole($user_id, $user_type)
     {
        if($user_type != 'A')
        {    
            $school_id = (!empty($_SESSION['school_id'])) ? $_SESSION['school_id'] : 0 ;
            $query = $this->db->get_where('user_role_transaction', array('main_user_id' => $user_id, 
             'original_user_type' => $user_type, "school_id" => $school_id))->row();
        }
        else
        {    
            $query = $this->db->get_where('user_role_transaction', array('main_user_id' => $user_id, 
             'original_user_type' => $user_type))->row();
        }
        $arr = array();
         if(empty($query->role_id))
         {
             echo "<br>No Role Selected";
             die();
         }
         $arr['role_id'] = $query->role_id;
         $arr['user_id'] = $query->main_user_id;
         $arr['original_user_type'] = $query->original_user_type;
         $arr['user_type'] = $query->user_type;
         $query = $this->db->get_where('role_link_transaction', array('role_id' => $arr['role_id']))->row();
         if(empty($query->role_id))
         {
             echo "<br>No links are   Selected";
             die();
         }
         if($query->user_type == "SA")
         {
             if($arr['user_type'] == "T")
                 $arr['user_type']  = "SA";
         }    
        
        //echo "<br>here role id is :".$query->role_id." and user type is :".$arr['user_type'];
         return $arr;
     }
     
    function get_all_links($role_id=false)
    {
       $school_id = (!empty($_SESSION['school_id'])) ? $_SESSION['school_id'] : 0 ;
       $sql = "SELECT LM.* FROM role_link_transaction
                INNER JOIN link_modules LM ON LM.`id` = role_link_transaction.`link_id`
                WHERE role_link_transaction.role_id = '".$role_id."' and LM.school_id = '".$school_id."'  ORDER BY LM.orders";

                  
        return $this->db->query($sql)->result_array();
    }

    function getModuleLinks($role_id)
    {
        $school_id = (!empty($_SESSION['school_id'])) ? $_SESSION['school_id'] : 0 ;
        if($school_id > 0)
        {    
        $sql = "
        SELECT name, link_modules.id AS link_id, image as image1
        FROM 
        role_link_transaction
        INNER JOIN link_modules ON link_modules.`id` = role_link_transaction.`link_id`
        WHERE role_id = $role_id AND parent_id = 0 and link_modules.school_id = '$school_id' order by link_modules.orders";
        }
        else
        {
                    $sql = "
        SELECT name, link_modules.id AS link_id, image as image1
        FROM 
        role_link_transaction
        INNER JOIN link_modules ON link_modules.`id` = role_link_transaction.`link_id`
        WHERE role_id = $role_id AND parent_id = 0  order by link_modules.orders";
        }    
        $query = $this->db->query($sql);
       
        return $query->result_array();
    }

    function getSubLinks($link, $user_type)
    {
        $query = "SET SESSION group_concat_max_len = 1000000;";
        $this->db->query($query);
        $query = $this->db->get_where("link_modules", array("parent_id"=>$link))->result_array();
        if(strtolower($user_type) == "p")
        {
            $join = "left join";
        }
        else
            $join = "inner join";
        $arr = array();
        if(count($query)>0)
        {
            
                $sql = "SELECT GROUP_CONCAT('', NAME) AS link_name, 
                    GROUP_CONCAT('', link) AS links,GROUP_CONCAT('', image) AS image FROM link_modules
                    $join role_link_transaction on role_link_transaction.link_id = link_modules.id
                    WHERE parent_id = $link order by link_modules.orders";
            $query_group = $this->db->query($sql);
            $arr['flag'] = 1;
            $arr['query'] = $query_group->result_array();
            return $arr;
        }
        else 
        {
            //$this->db->where("(link_modules.is_paid_addon = 0 or (link_modules.is_paid_addon = 1 and link_modules.is_paid = 1))");
            $query_row = $this->db->get_where("link_modules", array("id"=>$link));
            $arr['flag'] = 0;
            $arr['query'] = $query_row->result_array();
            return $arr; 
            
        }
      }
      
      function getSubLinksAdmin($link, $user_type)
       {
           $query = "SET SESSION group_concat_max_len = 1000000;";
           $this->db->query($query);
           $query = $this->db->get_where("link_modules", array("parent_id"=>$link))->result_array();
           if(strtolower($user_type) == "p")
           {
               $join = "left join";
           }
           else
               $join = "inner join";
           $arr = array();
           if(count($query)>0)
           {
              
                 $sql = "SELECT GROUP_CONCAT('', NAME) AS link_name, 
                        GROUP_CONCAT('', link) AS links,GROUP_CONCAT('', image) AS image FROM link_modules
                        $join role_link_transaction on role_link_transaction.link_id = link_modules.id
                        WHERE parent_id = $link order by link_modules.orders";
                $query_group = $this->db->query($sql);
                $arr['flag'] = 1;
                $arr['query'] = $query_group->result_array();
                return $arr;
           }
           else 
           {
              $query_row = $this->db->get_where("link_modules", array("id"=>$link));
              $arr['flag'] = 0;
              $arr['query'] = $query_row->result_array();
              return $arr; 
               
           }
      }
         
     function getRecursiveLoop($link)
     {
           $query = $this->db->get_where("link_modules", array("parent_id" => $link))->result_array();
           
           $arr = array();
           if(count($query)>0)
           {
               foreach($query as $row)
               {
                   $next_link = $row->id;
                   $query_next = $this->db->get_where("link_modules", array("parent_id" => $next_link))->result_array();
                   if(count($query_next))
                   {
                       
                   }    
                   
               }    
                 $sql =   "SELECT GROUP_CONCAT('', NAME) AS link_name, 
                        GROUP_CONCAT('', link) AS links,GROUP_CONCAT('', image) AS image FROM link_modules
                        inner join role_link_transaction on role_link_transaction.link_id = link_modules.id
                        WHERE parent_id = $link order by link_modules.orders";
                $query_group = $this->db->query($sql);
                $arr['flag'] = 1;
                $arr['query'] = $query_group->result_array();
                return $arr;
           }
     }
     function fire_query($link)
     {
         $sql =   "SELECT GROUP_CONCAT('', NAME) AS link_name, 
                        GROUP_CONCAT('', link) AS links,GROUP_CONCAT('', image) AS image FROM link_modules
                        inner join role_link_transaction on role_link_transaction.link_id = link_modules.id
                        WHERE parent_id = $link order by link_modules.orders";
         $query_group = $this->db->query($sql);
         $result = $query_group->result_array();
         $arrLinkName = array();
         
         foreach($result as $row)
         {
             
         }    
     }

    /*******************************************************************************************************/
////////STUDENT/////////////
        function get_students($class_id)
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $query = $this->db->get_where('student', array('class_id' => $class_id));
            return $query->result_array();
        }

        function get_student_info($student_id)
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $query = $this->db->get_where('student', array('student_id' => $student_id));
            return $query->result_array();
        }

        /////////TEACHER/////////////
        function get_teachers()
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $query = $this->db->get('teacher');
            return $query->result_array();
        }

        function get_teacher_name($teacher_id)
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $query = $this->db->get_where('teacher', array('teacher_id' => $teacher_id));
            $res = $query->result_array();
            foreach ($res as $row)
                return $row['name'];
        }

        function get_teacher_info($teacher_id)
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $query = $this->db->get_where('teacher', array('teacher_id' => $teacher_id));
            return $query->result_array();
        }

        function get_teacher_id($teacher_email)
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $query = $this->db->get_where('teacher', array('email' => $teacher_email));
            $res = $query->result_array();
            foreach ($res as $row)
                return $row['teacher_id'];
        }

        //////////SUBJECT/////////////
        function get_subjects()
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $query = $this->db->get('subject');
            return $query->result_array();
        }

        function get_subject_info($subject_id)
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $query = $this->db->get_where('subject', array('subject_id' => $subject_id));
            return $query->result_array();
        }

        function get_subjects_by_class($class_id)
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $query = $this->db->get_where('subject', array('class_id' => $class_id));
            return $query->result_array();
        }

        function get_subject_name_by_id($subject_id)
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $query = $this->db->get_where('subject', array('subject_id' => $subject_id))->row();
            if($query!=''){
                return $query->name;
            }
            else{
                return; 
            }
            
        }
        function get_teacher_name_by_subject_id($subject_id){
            $school_id = ''; $where = ''; 
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $where = " AND s.school_id = '".$school_id."'";
                } 
            }
            $query = "SELECT t.name as teacher_name  FROM teacher as t join subject as s on(t.teacher_id=s.teacher_id) where s.subject_id='".$subject_id."'".$where;
            $result=$this->db->query($query)->row();
            if($result!=''){
                return $result->teacher_name;
            }
            else{
                return; 
            }
        }
        function get_teacher_name_by_id($teacher_id)
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $query = $this->db->get_where('teacher', array('teacher_id' => $teacher_id))->row();
            return $query->name;
        }
        
       function get_subjects_by_teacher($teacher_id)
       {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $query = $this->db->get_where('subject', array('teacher_id' => $teacher_id));
            return $query->result_array();
       }
       
        function get_classes_by_teacher($teacher_id){
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $this->db->select('*');
            $this->db->group_by('class_id');
             $this->db->from('class');
            $this->db->where(array('teacher_id' => $teacher_id));
             return $this->db->get()->result_array();
        }
 

        ////////////CLASS///////////
        function get_class_name($class_id)
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $query = $this->db->get_where('class', array('class_id' => $class_id));
            $res = $query->result_array();
            foreach ($res as $row)
                return $row['name'];
        }

        function get_class_name_numeric($class_id)
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $query = $this->db->get_where('class', array('class_id' => $class_id));
            $res = $query->result_array();
            foreach ($res as $row)
                return $row['name_numeric'];
        }

        function get_classes()
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $query = $this->db->get('class');
            return $query->result_array();
        }

        function get_class_info($class_id)
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $query = $this->db->get_where('class', array('class_id' => $class_id));
            return $query->result_array();
        }

        //////////EXAMS/////////////
        function get_exams()
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
//            $query = $this->db->get_where('exam', array(
//                'year' => $this->db->get_where('settings', array('type' => 'running_year'))->row()->description
//            ))->order_by('exam_id', 'desc');           
            
            $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
//            echo $running_year; die;
            $query = $this->db->order_by('exam_id', 'desc')->get_where('exam',array('year' => $running_year)); 
            return $query->result_array();
        }

        function get_exam_info($exam_id)
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $query = $this->db->get_where('exam', array('exam_id' => $exam_id));
            return $query->result_array();
        }

        //////////GRADES/////////////
        function get_grades()
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $query = $this->db->get('grade');
            return $query->result_array();
        }

        function get_grade_info($grade_id)
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $query = $this->db->get_where('grade', array('grade_id' => $grade_id));
            return $query->result_array();
        }

        function get_obtained_marks($exam_id, $class_id, $subject_id, $student_id)
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $marks = $this->db->get_where('mark', array(
                        'subject_id' => $subject_id,
                        'exam_id' => $exam_id,
                        'class_id' => $class_id,
                        'student_id' => $student_id))->result_array();

            foreach ($marks as $row)
            {
                echo $row['mark_obtained'];
            }
        }

        function get_highest_marks($exam_id, $class_id, $subject_id) {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $this->db->where('exam_id', $exam_id);
            $this->db->where('class_id', $class_id);
            $this->db->where('subject_id', $subject_id);
            $this->db->select_max('mark_obtained');
            $highest_marks = $this->db->get('mark')->result_array();
            if (!empty($highest_marks)) {
                return $highest_marks[0]['mark_obtained'];
            } else {
                return 0;
            }
        }

        function get_grade($mark_obtained)
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $this->db->where('mark_from <=',$mark_obtained);
            $this->db->where('mark_upto >=',$mark_obtained);
            $query = $this->db->get('grade');
            $grades = $query->row_array();
            return $grades; 
        }
        
        function get_grade_new($mark_obtained,$group)
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('a.school_id',$school_id);
                } 
            }
            $this->db->select('*');
            $this->db->from('grade a'); 
            $this->db->join('grading_evaluation b', 'b.grade_id=a.grade_id', 'left');
            $this->db->where(array('a.mark_from <='=>$mark_obtained,'a.mark_upto >'=>$mark_obtained,'b.grade_set'=>$group ));
                     
            $query = $this->db->get();
           
            if($query->num_rows() != 0)
            {
                return $query->result_array();
            }
            else
            {
                return false;
            }
        }


        function create_log($data)
        {
            $data['timestamp'] = strtotime(date('Y-m-d') . ' ' . date('H:i:s'));
            $data['ip'] = $_SERVER["REMOTE_ADDR"];
            $location = new SimpleXMLElement(file_get_contents('http://freegeoip.net/xml/' . $_SERVER["REMOTE_ADDR"]));
            $data['location'] = $location->City . ' , ' . $location->CountryName;
            $this->db->insert('log', $data);
        }

        function get_system_settings()
        {
            $query = $this->db->get('settings');
            return $query->result_array();
        }
        ////////BACKUP RESTORE/////////
        function create_backup()
        {
        $this->load->dbutil();
        $tables         =       $this->db->list_tables(); 
        $statement_values   =   '';
        $statement_query    =   '';
        foreach ($tables as $table_names){   
                $statement =  get_data_generic_fun($table_names,'*',array(),'result_arr');
//                $statement_values = null;
//                $this->db->query("SELECT * FROM $table_names",array());
                
//                $config = array (
//                    'root'          => 'root',
//                    'element'       => 'element',
//                    'newline'       => "\n",
//                    'tab'           => "\t"
//                );
//                echo $this->dbutil->xml_from_result($query, $config);
                if($statement)
                foreach ($statement as $key => $post) {
                    if(isset($statement_values)) {
                        $statement_values .= "\n";
                    }
                    $values = array_values($post);
                    foreach($values as $index => $value) {
                        $quoted = str_replace("'","\'",str_replace('"','\"', $value));
                        $values[$index] = (!isset($value) ? 'NULL' : "'" . $quoted."'") ;
                    }
                $statement_values .="insert into ".$table_names." values "."(".implode(',',$values).");";
                }
                $statement = $statement_values . ";";     
        }
        $backup         =   $statement_values;
        $date = date('d-m-Y-H-i-s', time());
//        $this->load->helper('file');
//        write_file('mysql_backup/mybackup-'.$date.'.sql', $backup);
//
        // Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download("backup"."_".$date. '.sql', $backup);
        }

        /////////RESTORE TOTAL DB/ DB TABLE FROM UPLOADED BACKUP SQL FILE//////////
        function restore_backup()
        {
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/backup.sql');
            $this->load->dbutil();


            $prefs = array(
                'filepath' => 'uploads/backup.sql',
                'delete_after_upload' => TRUE,
                'delimiter' => ';'
            );
            $restore = & $this->dbutil->restore($prefs);
            unlink($prefs['filepath']);
        }

        /////////DELETE DATA FROM TABLES///////////////
        function truncate($type)
        {
            if ($type == 'all')
            {
                $this->db->truncate('student');
                $this->db->truncate('mark');
                $this->db->truncate('teacher');
                $this->db->truncate('subject');
                $this->db->truncate('class');
                $this->db->truncate('exam');
                $this->db->truncate('grade');
            }
            else
            {
                $this->db->truncate($type);
            }
        }

        ////////IMAGE URL//////////
        function get_image_url($type = '', $id = '')            
        {
            //echo $type.$id; exit;
            if (file_exists('uploads/' . $type . '_image/' . $id . '.jpg')){
                
                $image_url = base_url() . 'uploads/' . $type . '_image/' . $id . '.jpg';
                //echo $image_url; exit;
            }else
                $image_url = base_url() . 'uploads/user.png';
            //echo $image_url. "fgfg"; exit; http://localhost/beta_ag/uploads/admin_image/1.jpg
            return $image_url;
        }

        ////////STUDY MATERIAL//////////
        
        public function save_dynamic_data($table, $arrData)
        {
            
            $this->db->set($arrData);
            $insert_id = $this->db->insert($table);
            $last_id = $this->db->insert_id();
            return $last_id;
            
        }
        function save_study_material_info(){
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $data['school_id'] = $school_id;
                } 
            }
            //$data['timestamp']      = strtotime($this->input->post('timestamp'));
            $data['title']          = $this->input->post('title');
            $data['description']    = $this->input->post('description');
            $data['uploader_id']    = $this->session->userdata('login_user_id');
            $data['uploader_type']  = $this->session->userdata('u_type');
            $tempFile               = $_FILES['file_name']['tmp_name'];
            $data['file_name']      = $_FILES["file_name"]["name"];
            $data['file_type']      = $_FILES["file_name"]["type"];           
            $data['class_id']       = $this->input->post('class_id');           
            $this->db->insert('document', $data);
            $document_id = $this->db->insert_id();
            $targetPath = "uploads/document/";
            if (!file_exists($targetPath)) {
                mkdir($targetPath, 0777, true);
            }        
            move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/document/" .$data['file_name']);
        }

        function select_study_material_info(){ 
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('d.school_id',$school_id);
                } 
            }
            $teacher_id =   $this->session->userdata('teacher_id');
            $this->db->select("d.*,c.name as classname");
            $this->db->from("document as d");
            $this->db->join("class as c", "c.class_id = d.class_id"); 
            $this->db->where('d.teacher_id',$teacher_id);
            $this->db->order_by("document_id", "desc");
            return $this->db->get()->result_array();
        }

        function select_study_material_info_for_student()
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $student_id = $this->session->userdata('student_id');
            $class_id = $this->db->get_where('enroll', array(
                        'student_id' => $student_id,
                        'year' => $this->db->get_where('settings', array('type' => 'running_year'))->row()->description
                    ))->row()->class_id;
            $this->db->order_by("timestamp", "desc");
            return $this->db->get_where('document', array('class_id' => $class_id))->result_array();
        }

        function update_study_material_info($document_id) {
            $data['title'] = $this->input->post('title');
            $data['description'] = $this->input->post('description');
            $data['class_id'] = $this->input->post('class_id');            
            $data['file_type'] = $_FILES["file_name"]["type"];
            $data['file_name'] = $_FILES["file_name"]["name"];
            $data['uploader_id']    = $this->session->userdata('login_user_id');
            $data['uploader_type']  = $this->session->userdata('u_type');
            if($this->session->userdata('admin_login') == 1 ) {
                //$data['teacher_id'] = $this->input->post('teacher_id');
                $data['modified_by']    =    'school_admin';
            } else if($this->session->userdata('teacher_login') == 1 ) {
                //$data['teacher_id'] = $this->session->userdata('teacher_id');
                $data['modified_by']            =    'teacher';
            }
            $targetPath = "uploads/document/";
            if (!file_exists($targetPath)) {
                mkdir($targetPath, 0777, true);
            }        
            move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/document/" .$data['file_name']);             
            $this->db->where('document_id', $document_id);
            $this->db->update('document', $data);
        }

        function delete_study_material_info($document_id){
            $this->db->where('document_id', $document_id);
            $this->db->delete('document');
        }
        
           function send_new_private_message_admin_main()
        {
            $message = $this->input->post('message');
            $timestamp = strtotime(date("Y-m-d H:i:s"));

            $reciever = $this->input->post('reciever');
            $r        = implode(',',$reciever);
            $rs     =   explode(',',$r);
            foreach($rs as $value){
            $sender = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
            //check if the thread between those 2 users exists, if not create new thread
            $num1 = $this->db->get_where('admin_message_thread', array('sender' => $sender, 'reciever' => $value))->num_rows();
    
            $num2 = $this->db->get_where('admin_message_thread', array('sender' => $value, 'reciever' => $sender))->num_rows();
    
            
            if ($num1 == 0 && $num2 == 0)
            {
                $message_thread_code = md5(time() . rand());
                $data_message_thread['message_thread_code'] = $message_thread_code;
                $data_message_thread['sender'] = $sender;
                $data_message_thread['reciever'] = $value;
               
                $this->db->insert('admin_message_thread', $data_message_thread);
            }
            if ($num1 > 0)
                $message_thread_code = $this->db->get_where('admin_message_thread', array('sender' => $sender, 'reciever' => $value))->row()->message_thread_code;
            if ($num2 > 0)
                $message_thread_code = $this->db->get_where('admin_message_thread', array('sender' => $value, 'reciever' => $sender))->row()->message_thread_code;


            $data_message['message_thread_code'] = $message_thread_code;
            $data_message['message'] = $message;
            $data_message['sender'] = $sender;
            $data_message['timestamp'] = $timestamp;
            $this->db->insert('admin_message', $data_message);
            }
            // notify email to email reciever
            //$this->email_model->notify_email('new_message_notification', $this->db->insert_id());

            return $message_thread_code;
            
        }

        ////////private message//////
        function send_new_private_message_admin()
        {
            $message = $this->input->post('message');
            $timestamp = strtotime(date("Y-m-d H:i:s"));

            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
            }

            $data_message_thread['school_id'] = $school_id;

            $data_message['school_id'] = $school_id;

            $reciever = $this->input->post('reciever');
            //pre($reciever);
            //$rs     =   explode(',',$reciever[0]);            
            $r        = implode(',',$reciever);
            $rs     =   explode(',',$r);
            $message_thread_code = '';
            if(count($rs)){
                krsort($rs);
                foreach($rs as $value){
                $sender = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
                //check if the thread between those 2 users exists, if not create new thread
                $num1 = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $value))->num_rows();
                $num2 = $this->db->get_where('message_thread', array('sender' => $value, 'reciever' => $sender))->num_rows();

                if ($num1 == 0 && $num2 == 0)
                {
                    $message_thread_code = substr(md5(rand(100000000, 20000000000)), 0, 15);
                    $data_message_thread['message_thread_code'] = $message_thread_code;
                    $data_message_thread['sender'] = $sender;
                    $data_message_thread['reciever'] = $value;
                    $this->db->insert('message_thread', $data_message_thread);
                }
                if ($num1 > 0)
                    $message_thread_code = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $value))->row()->message_thread_code;
                if ($num2 > 0)
                    $message_thread_code = $this->db->get_where('message_thread', array('sender' => $value, 'reciever' => $sender))->row()->message_thread_code;


                $data_message['message_thread_code'] = $message_thread_code;
                $data_message['message'] = $message;
                $data_message['sender'] = $sender;
                $data_message['timestamp'] = $timestamp;
                $this->db->insert('message', $data_message);
                }
            }
            // notify email to email reciever
            //$this->email_model->notify_email('new_message_notification', $this->db->insert_id());

            return $message_thread_code;
            
        }
        function send_new_private_message()
        {
            $message = $this->input->post('message');
            $timestamp = strtotime(date("Y-m-d H:i:s"));

            $reciever = $this->input->post('reciever');
            $sender = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');

            //check if the thread between those 2 users exists, if not create new thread
            $num1 = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $reciever))->num_rows();
            $num2 = $this->db->get_where('message_thread', array('sender' => $reciever, 'reciever' => $sender))->num_rows();

            if ($num1 == 0 && $num2 == 0)
            {
                $message_thread_code = substr(md5(rand(100000000, 20000000000)), 0, 15);
                $data_message_thread['message_thread_code'] = $message_thread_code;
                $data_message_thread['sender'] = $sender;
                $data_message_thread['reciever'] = $reciever;
                $this->db->insert('message_thread', $data_message_thread);
            }
            if ($num1 > 0)
                $message_thread_code = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $reciever))->row()->message_thread_code;
            if ($num2 > 0)
                $message_thread_code = $this->db->get_where('message_thread', array('sender' => $reciever, 'reciever' => $sender))->row()->message_thread_code;


            $data_message['message_thread_code'] = $message_thread_code;
            $data_message['message'] = $message;
            $data_message['sender'] = $sender;
            $data_message['timestamp'] = $timestamp;
            $this->db->insert('message', $data_message);

            // notify email to email reciever
            //$this->email_model->notify_email('new_message_notification', $this->db->insert_id());

            return $message_thread_code;
        }

        
        
       
        function send_reply_message($message_thread_code)
        {
            $message = $this->input->post('message');
            $timestamp = strtotime(date("Y-m-d H:i:s"));
            $sender = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');

            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
            }

            $data_message['school_id'] = $school_id;

            $data_message['message_thread_code'] = $message_thread_code;
            $data_message['message'] = $message;
            $data_message['sender'] = $sender;
            $data_message['timestamp'] = $timestamp;

            $this->db->insert('message', $data_message);

            // notify email to email reciever
            //$this->email_model->notify_email('new_message_notification', $this->db->insert_id());
        }

        function mark_thread_messages_read($message_thread_code, $school_id)
        {
            // mark read only the oponnent messages of this thread, not currently logged in user's sent messages
            $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
            $this->db->where('sender !=', $current_user);
            $this->db->where('message_thread_code', $message_thread_code);
            $this->db->where('school_id', $school_id);
            $this->db->update('message', array('read_status' => 1));
        }
        function mark_thread_messages_read_main($message_thread_code)
        {
            // mark read only the oponnent messages of this thread, not currently logged in user's sent messages
            $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
            $this->db->where('sender !=', $current_user);
            $this->db->where('message_thread_code', $message_thread_code);
            $this->db->update('admin_message', array('read_status' => 1));
            //echo $this->db->last_query();die;
            
        }
        
         function send_reply_message_main($message_thread_code)
        {
            $message = $this->input->post('message');
            $timestamp = strtotime(date("Y-m-d H:i:s"));
            $sender = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');


            $data_message['message_thread_code'] = $message_thread_code;
            $data_message['message'] = $message;
            $data_message['sender'] = $sender;
            $data_message['timestamp'] = $timestamp;
            $this->db->insert('admin_message', $data_message);

            // notify email to email reciever
            //$this->email_model->notify_email('new_message_notification', $this->db->insert_id());
        }
        
        function count_unread_message_of_thread_main($message_thread_code)
        {
            $unread_message_counter = 0;
            $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
            $messages = $this->db->get_where('admin_message', array('message_thread_code' => $message_thread_code))->result_array();
            foreach ($messages as $row)
            {
                if ($row['sender'] != $current_user && $row['read_status'] == '0')
                    $unread_message_counter++;
            }
            return $unread_message_counter;
        }

        function count_unread_message_of_thread($message_thread_code, $school_id = '')
        {
            $unread_message_counter = 0;
            $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
            //$messages = $this->db->get_where('message', array('message_thread_code' => $message_thread_code))->result_array();

            $messages = $this->db->get_where('message', array('message_thread_code' => $message_thread_code, 'message_status!=' => 'admin_deleted', 'school_id' => $school_id))->result_array();
            
            foreach ($messages as $row)
            {
                if ($row['sender'] != $current_user && $row['read_status'] == '0')
                    $unread_message_counter++;
            }
            return $unread_message_counter;
        }

        /* function get_records($table_name, $data_array = array(), $fields = "*")
          {
          $result = array();
          $this->db->select($fields);
          $this->db->from($table_name);
          if (!empty($data_array))
          {
          $this->db->where($data_array);
          }
          $result = $this->db->get()->result_array();
          return $result;
          }

          function get_record($table_name, $data_array = array(), $fields = "*")
          {
          $result = array();
          $this->db->select($fields);
          $this->db->from($table_name);
          $this->db->where($data_array);
          $result = $this->db->get()->row();
          return $result;
          } */

        function get_added_section($class_id)
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('ct.school_id',$school_id);
                } 
            }
            $return = array();
            $this->db->select("ct.section_id,nick_name");
            $this->db->from("class_section_trans as ct");
            $this->db->join("section as s", "ct.section_id=s.section_id", "left");
            $this->db->where("ct.class_id", $class_id);
            $result = $this->db->get()->result_array();
            if (!empty($result))
            {
                foreach ($result as $record)
                {
                    $return[$record['section_id']] = $record['nick_name'];
                }
            }
            return $return;
        }

        function get_section_array()
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('section.school_id',$school_id);
                } 
            }
            $return = array();
            $this->db->select("section_id,nick_name");
            $this->db->from("section");
            $result = $this->db->get()->result_array();
            if (!empty($result))
            {
                foreach ($result as $record)
                {
                    $return[$record['section_id']] = $record['nick_name'];
                }
            }
            return $return;
        }
        function get_section_details($dataArray, $column = "")
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $return = "";
            $section_record = $this->db->get_where('section', $dataArray)->row();
            if (!empty($column) && !empty($section_record->$column)) {
                $return = $section_record->$column;
            } else {
                $return = $section_record;
            }
            return $return;
        }
        function get_section_name($sectionid)
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
             $return = "";
             $data['section_id']=$sectionid;
             $section_record = $this->db->get_where('section', $data)->row()->name;
             return $section_record;
        }
        
        function get_books_list()
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('b.school_id',$school_id);
                } 
            }
            $return = array();
            $this->db->select("b.*,(Select count(book_id) from books_list where book_id=b.book_id and book_status='Active') as total_books, (Select count(book_id) from books_list where book_id=b.book_id and book_issue_status='No' and book_status='Active') as available_books");
            $this->db->from("books as b");
            $this->db->order_by("b.book_title", "asc");
            $return = $this->db->get()->result_array();
            return $return;
        }

        function get_record($table_name, $condition = array(), $field = "*")
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $result = array();
            $this->db->select($field);
            $this->db->from($table_name);
            if (!empty($condition))
            {
                $this->db->where($condition);
            }
            $result = (array) $this->db->get()->row();
            return $result;
        }
        
        function getSpecificRecord($table_name, $admin_id)
        {
            $arrImage=array();
            $image = "";
            
            if(strstr($table_name, "||"))
            {
                $arrTable = explode("||", $table_name);
                $image_row =  $this->db->get_where($arrTable[0], array("teacher_id" => $admin_id))->row();
                $arrImage['image'] = $image_row->teacher_image;
                $arrImage['type'] = "T";
                if(empty($image_row->teacher_image))
                {
                    $arrImage['type'] = "A";
                    $image_row =  $this->db->get_where($arrTable[1], array("admin_id" => $admin_id))->row();
                    if(empty($image_row->image))
                    {
                        $arrImage['image'] = "";
                    }    
                    else
                        $arrImage['image'] = $image_row->image;
                    
                }    
                
            }
            return $arrImage;
        }

        function get_records($table_name, $condition = array(), $field = "*", $order_by = '', $order_dir = 'asc')
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0 && $table_name!='school_admin'){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $result = array();
            $this->db->select($field);
            $this->db->from($table_name);
            if (!empty($condition))
            {
                $this->db->where($condition);
            }
            if (!empty($order_by))
            {
                $this->db->order_by($order_by, $order_dir);
            }
            $result = $this->db->get()->result_array();
            
            return $result;
        }

        function get_book_detail_by_unique_id($unique_id)
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('bl.school_id',$school_id);
                } 
            }
            $result = array();
            $this->db->select("b.*");
            $this->db->from("books_list as bl");
            $this->db->join("books as b", "bl.book_id=b.book_id", "left");
            $this->db->where("bl.book_unique_id", $unique_id);
            $result = (array) $this->db->get()->row();
            return $result;
        }
        
       function get_book_detailby_bookid($unique_id)
        {
           $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $result = array();
            $this->db->select("*");
            $this->db->from("book_info");
            $this->db->where("id", $unique_id);
            $result = (array) $this->db->get()->row();
            return $result;
        }

        public function addsignal($IMEI, $Date, $dt, $RFID)
        {

           // echo "Insert into device_signal values ('$IMEI','$Date','$dt','$RFID')";
            /* $data_message['imei']    = $IMEI;
              $data_message['date']         = $Date;
              $data_message['time']         = $dt;
              $data_message['card_id']      = $RFID;
              $this->db->insert('device_signal', $data_message);
              echo $this->db->_error_message(); */

            $this->db->query("Insert into device_signal values ('125','2012-01-01','2012-01-01','1234')");
            //echo $this->db->_error_message();
            //echo $this->db->affected_rows();
            //echo $this->db->last_query();
        }
        
        function get_all_student_by_class_n_section($class_id,$section_id){
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
            
            $rs=$this->db->select('student_id')->get_where('enroll', array('class_id' => $class_id, 'year' => $running_year,'section_id'=>$section_id))->result();
            return $rs;
        }
        
        function update_before_attendance_taken($class_id,$section_id,$student_id,$timestamp){
            $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

            $this->db->group_by('timestamp');
            $attendanceData = $this->db->get_where('attendance', array('section_id' => $section_id, 'class_id' => $class_id, 'year' => $running_year, 'timestamp' => $timestamp, 'student_id' => $student_id))->result();

            if(empty($attendanceData)){
                $dataArr=array('timestamp'=>$timestamp,'year'=>$running_year,'class_id'=>$class_id,'section_id'=>$section_id,'student_id'=>$student_id,'status'=>0);
                $this->db->insert('attendance',$dataArr);
            }
            return TRUE;
        }
        function get_instance_name()
        {
            $url_arr=explode('/', $_SERVER['PHP_SELF']);
            $dir=$url_arr[1];
            return $dir;
        }

        function select_study_material_info_for_student_api($student_id =''){
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $class_id       =   $this->db->get_where('enroll', array(
                                    'student_id' => $student_id,
                                    'year' => $this->db->get_where('settings', array('type' => 'running_year'))->row()->description
                                ))->row()->class_id;
            $this->db->order_by("timestamp", "desc");
            return $this->db->get_where('document', array('class_id' => $class_id))->result_array();
        }
        
        function add_todaytopic($dataArray){
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $dataArray['school_id'] = $school_id;
                } 
            }
            $this->db->insert('today_topic', $dataArray);
            $id     =   $this->db->insert_id();
        }
        
        public function get_topics($class_id='', $section_id='') {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('top.school_id',$school_id);
                } 
            }
            $return             =   array();
            $today              =   date('Y-m-d');
            $this->db->select( 'top.*,te.name as teacher_name ,cls.class_id as cls_id, cls.name as class_name, sec.section_id as sec_id, sec.name as section_name, sub.name');
            $this->db->from( 'today_topic as top' );           
            $this->db->join( 'class as cls', ' cls.class_id = top.class_id ');
            $this->db->join( 'section as sec', ' sec.section_id = top.section_id' );
            $this->db->join( 'teacher as te', ' te.teacher_id = top.teacher_id' );
            $this->db->join( 'subject as sub', ' sub.subject_id = top.subject_id' );
            $this->db->where(array('top.class_id' => $class_id, 'top.section_id' => $section_id, 'DATE(top.created_date)'=> $today)); 
            $this->db->order_by("top.created_date", 'DESC'); 
            $return = $this->db->get()->result_array();
            return $return;
        }
        
        public function get_topics_by_date($class_id='', $section_id='', $date='') {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('top.school_id',$school_id);
                } 
            }
            $return             =   array();
            $today              =   date('Y-m-d');
            $this->db->select( 'top.*,te.name as teacher_name ,cls.class_id as cls_id, cls.name as class_name, sec.section_id as sec_id, sec.name as section_name, sub.name');
            $this->db->from( 'today_topic as top' );           
            $this->db->join( 'class as cls', ' cls.class_id = top.class_id ');
            $this->db->join( 'section as sec', ' sec.section_id = top.section_id' );
            $this->db->join( 'teacher as te', ' te.teacher_id = top.teacher_id' );
            $this->db->join( 'subject as sub', ' sub.subject_id = top.subject_id' );
            $this->db->where(array('top.class_id' => $class_id, 'top.section_id' => $section_id, 'DATE(top.created_date)'=> $date)); 
            $this->db->order_by("top.created_date", 'DESC'); 
            $return = $this->db->get()->result_array();
            return $return;
        }
        public function select_study_material_info_admin(){
            $school_id = ''; $where = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $where = " WHERE d.school_id = '".$school_id."'";
                } 
            }
            $sql="SELECT d.*,c.name as classname,t.name as teacher_name FROM document d join class c on(d.class_id=c.class_id) join teacher t on(d.teacher_id=t.teacher_id)".$where;
            $rs = $this->db->query($sql)->result_array();
            return $rs;
        }
        
        public function get_study_material($class_id ='') {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('d.school_id',$school_id);
                } 
            }
            $return             =   array();
            //$this->db->select( 'd.*,cls.name as classname, cls.class_id as class_id, t.name as teacher_name');
            $this->db->select( 'd.*,cls.name as classname, cls.class_id as class_id');
            $this->db->from( 'document as d' );           
            $this->db->join( 'class as cls', ' cls.class_id = d.class_id ');
            //$this->db->join( 'teacher as t', ' t.teacher_id = d.teacher_id' );
            $this->db->where(array('cls.class_id' => $class_id)); 
            $this->db->order_by("d.timestamp", 'DESC'); 
            $return = $this->db->get()->result_array();
            return $return;
        }
        
        public function get_document_by_id($document_id=''){
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('d.school_id',$school_id);
                } 
            }
            $return             =   array();
            $this->db->select( 'd.*,cls.name as classname, cls.class_id as class_id, t.name as teacher_name');
            $this->db->from( 'document as d' );           
            $this->db->join( 'class as cls', ' cls.class_id = d.class_id ');
            $this->db->join( 'teacher as t', ' t.teacher_id = d.teacher_id' );
            $this->db->where(array('d.document_id' => $document_id)); 
            $return = $this->db->get()->result_array();
            return $return;
        }


// GET DATATABLE QUERY
        private function _get_datatables_query(){
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('cir.school_id',$school_id);
                } 
            }
            $this->db->select('*, stu.student_id, stu.name stu_fname, stu.email stu_email');
            $this->db->from('circulation cir');
            $this->db->join('student stu', 'stu.card_id = cir.member_id', 'left');
            $this->db->join('book_info book', 'book.id = cir.book_id', 'left');
            $this->db->where('stu.isActive', '1');

            $i = 0;

            foreach ($this->column_search as $item) { // loop column 
                if ($_POST['search']['value']) { // if datatable send POST for search

                    if ($i === 0) { // first loop
                        $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                        $this->db->like($item, $_POST['search']['value']);
                    } else {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }
                    
                    if (count($this->column_search) - 1 == $i) //last loop
                        $this->db->group_end(); //close bracket
                }
                $i++;
            }

            if (isset($_POST['order'])) { // here order processing
                $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } else if (isset($this->order)) {
                $order = $this->order;
                $this->db->order_by(key($order), $order[key($order)]);
            }
        }
        
        // GET DATATABLE 
        function get_datatables() {
            $list = $this->_get_datatables_query();
            if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            return $query->result();
        }
        
         function count_filtered() {
            $this->_get_datatables_query();
            $query = $this->db->get();
            return $query->num_rows();
        }
        
        public function count_all() {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $this->db->from('student');
            $this->db->where('isActive', '1');
            return $this->db->count_all_results();
        }
        
        public function get_user($table ='', $cond_array=array()){
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            if(!empty($cond_array)){
                $this->db->where($cond_array);
            }
            $query = $this->db->get($table);
            return $query->row();
        }

        function get_max_marks($exam_id, $class_id, $subject_id) {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $this->db->where('exam_id', $exam_id);
            $this->db->where('class_id', $class_id);
            $this->db->where('subject_id', $subject_id);
            $this->db->select('mark_total');
            $max_marks = $this->db->get('mark')->result_array();
            return $max_marks;
        }


    }
   
    
