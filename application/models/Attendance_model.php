<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
        exit('No direct script access allowed');

class Attendance_model extends CI_Model{
    var $_table="attendance";
     private $_primary="attendance_id";

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
        $this->db->insert($this->_table,$dataArr);
        return $this->db->insert_id();
    }

    public function attendance_insert($val1, $student_id, $timestrap, $year,$class_id, $section_id)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
        }
        if(isset($school_id) && $school_id > 0){
            $insertAttendanceSQL = "INSERT INTO `attendance`(`status`, `student_id`, `timestamp`,`year`, `class_id`, `section_id`,`school_id`) 
                            VALUES ('$val1','$student_id','$timestrap','$year','$class_id','$section_id','$school_id') ON DUPLICATE KEY UPDATE    
                                    status=1 ";
        } else {
         $insertAttendanceSQL = "INSERT INTO `attendance`(`status`, `student_id`, `timestamp`,`year`, `class_id`, `section_id`) 
                            VALUES ('$val1','$student_id','$timestrap','$year','$class_id','$section_id') ON DUPLICATE KEY UPDATE    
                                    status=1 ";
        }
                $this->db->query($insertAttendanceSQL);
    }

    function get_other_data($student_id)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
        }
        if(isset($school_id) && $school_id > 0){
            return $this->db->select('s.name,p.parent_id,p.device_token,p.cell_phone,p.father_name,p.father_lname,p.email as parent_email,s.student_id')->from('student AS s')->join('parent AS p', 's.parent_id=p.parent_id')->where('s.student_id', $student_id)->where('s.school_id', $school_id)->get()->result_array();
        } else {
            return $this->db->select('s.name,p.parent_id,p.device_token,p.cell_phone,p.father_name,p.father_lname,p.email as parent_email,s.student_id')->from('student AS s')->join('parent AS p', 's.parent_id=p.parent_id')->where('s.student_id', $student_id)->get()->result_array();
        }
    }

    function update_status($student_id, $date, $year, $class_id, $session, $section_id, $attendance_status)
    {
        $this->db->where('student_id', $student_id);
        $this->db->where('date', $date);
        $this->db->where('year', $year);
        $this->db->where('class_id', $class_id);
         $this->db->where('session', $session);
         if (!empty($section_id)) {
            $this->db->where('section_id', $section_id);
        }
        $this->db->update($this->_table, array('status' => $attendance_status));
    }

    function update($id, $dataArr)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            $this->db->where('school_id',$school_id);
            $dataArr['school_id'] = $school_id;
        }
        $this->db->where('attendance_id', $id);
        $this->db->update($this->_table, $dataArr);
    }
    
    function get_present_absent_report($timeStamp){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
        }
        if(isset($school_id) && $school_id > 0){
            $sql="SELECT count(a.student_id) AS total_student,SUM(IF(a.status=0,1,0)) as absent,
  SUM(IF(a.status=1,1,0)) as present,a.class_id,c.name FROM `class` AS c  LEFT JOIN `attendance` AS a ON(a.class_id=c.class_id) WHERE a.date='$timeStamp' AND a.school_id = '".$school_id."' GROUP BY class_id";
        } else {
            $sql="SELECT count(a.student_id) AS total_student,SUM(IF(a.status=0,1,0)) as absent,
  SUM(IF(a.status=1,1,0)) as present,a.class_id,c.name FROM `class` AS c  LEFT JOIN `attendance` AS a ON(a.class_id=c.class_id) WHERE a.timestamp='$timeStamp' GROUP BY class_id";
        }
        //echo $sql;die;
        $rs= $this->db->query($sql)->result_array();
        return $rs;
    }
    
    function get_data_for_attendance_view($class_id,$section_id,$running_year,$timestamp){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
        }
        $school_id = $this->session->userdata('school_id');
        if(isset($school_id) && $school_id > 0){
            $where = " AND a.school_id = '".$school_id."'";
        } 
        $this->db->select("a.attendance_id,a.student_id,a.status,e.enroll_id,s.name AS student_name")->from($this->_table." a");
        $this->db->join("enroll e",'a.student_id=e.student_id')->join('student s','a.student_id=s.student_id');
        $this->db->where('a.class_id',$class_id)->where('a.section_id',$section_id)->where('a.year',$running_year);
        $rs=$this->db->where("a.timestamp",$timestamp)->get()->result_array();
        return $rs;
    }
    
    public function getstudents_attendence($class_id, $section_id, $running_year, $timestamp) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
        }
        if(isset($school_id) && $school_id > 0){
            $where = " AND attn.school_id = '".$school_id."'";
        } 
        $this->db->select('attn.attendance_id, attn.student_id, attn.status, en.roll, stu.student_id, stu.name AS student_name, stu.lname as lname');
        $this->db->from('attendance as attn');
        $this->db->join('enroll as en', 'attn.student_id = en.student_id');
        $this->db->join('student as stu',  'en.student_id  =   stu.student_id');
        $this->db->where('attn.class_id',$class_id)->where('attn.section_id',$section_id)->where('en.year', $running_year)->where('stu.isActive', '1')->where('stu.student_status', '1');
        $rs     =       $this->db->where("attn.timestamp",$timestamp)->get()->result_array();
        /*echo $this->db->last_query(); die();
        pre($rs); die();*/
        return $rs;        
    }
    function get_present_attendance($class_id="",$student_running_year="",$date=""){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
        }
        if(isset($school_id) && $school_id > 0){
            $sql="select a.*,s.name from attendance a left join student s on(a.student_id=s.student_id) where class_id='$class_id' and year = '$student_running_year' and timestamp = '$date' and status=1 and a.school_id = '".$school_id."'";
        } else {
            $sql="select a.*,s.name from attendance a left join student s on(a.student_id=s.student_id) where class_id='$class_id' and year = '$student_running_year' and timestamp = '$date' and status=1";
        }
            
            $rsStudent=$this->db->query($sql)->result_array();
            return $rsStudent; 
    }
    function get_absentees_attendance($class_id="",$student_running_year="",$date=""){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
        }
        if(isset($school_id) && $school_id > 0){
            $sql="select a.*,s.name,e.enroll_code from attendance a left join student s on(a.student_id=s.student_id) join enroll e on(a.student_id=e.student_id) where a.class_id='$class_id' and a.year = '$student_running_year' and a.timestamp = '$date' and a.status=2 and a.school_id = '".$school_id."'";
        } else {
            $sql="select a.*,s.name,e.enroll_code from attendance a left join student s on(a.student_id=s.student_id) join enroll e on(a.student_id=e.student_id) where a.class_id='$class_id' and a.year = '$student_running_year' and a.timestamp = '$date' and a.status=2";
        }
            
        $rsStudent=$this->db->query($sql)->result_array();
        return $rsStudent; 
    }
    function get_total_students($class_id="",$student_running_year="",$date=""){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
        }
        if(isset($school_id) && $school_id > 0){
             $sql="select a.*,s.name from attendance a left join student s on(a.student_id=s.student_id) where class_id='$class_id' and year = '$student_running_year' and timestamp = '$date' and a.school_id = '".$school_id."'";
        } else {
             $sql="select a.*,s.name from attendance a left join student s on(a.student_id=s.student_id) where class_id='$class_id' and year = '$student_running_year' and timestamp = '$date'";
        }
           
            $rsStudent=$this->db->query($sql)->result_array();
            return $rsStudent; 
    }
    function get_undefinied_students($class_id="",$student_running_year="",$date=""){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
        }
        if(isset($school_id) && $school_id > 0){
            $sql="select a.*,s.name from attendance a left join student s on(a.student_id=s.student_id) where class_id='$class_id' and year = '$student_running_year' and timestamp = '$date'and status=0 and a.school_id = '".$school_id."'";
        } else {
            $sql="select a.*,s.name from attendance a left join student s on(a.student_id=s.student_id) where class_id='$class_id' and year = '$student_running_year' and timestamp = '$date'and status=0";
        }
            
            $rsStudent=$this->db->query($sql)->result_array();
            return $rsStudent; 
    }
    
    function get_attendence_class_month(){  
        $school_id = '';
        $year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
        $running_year       =   date('Y');
        $num_month          =   date('m');
        $date               =   date('d-m-Y');
        $days               =   cal_days_in_month(CAL_GREGORIAN, $num_month, $running_year);
        $start_date         =   strtotime('01-' . $num_month . '-' . $running_year);

        $total_day_covered  =   date('d');
        $end_date           =   strtotime($total_day_covered+1 . '-' . $num_month . '-' . $running_year);

        if(($this->session->userdata('school_id')))
          $school_id = $this->session->userdata('school_id');
        if(isset($school_id) && $school_id > 0){
            $count_stud  =   "SELECT class_id,COUNT(student_id) as cnt FROM enroll WHERE year = '$year' and school_id = '".$school_id."' GROUP BY class_id ";
        } else {
            $count_stud  =   "SELECT class_id,COUNT(student_id) as cnt FROM enroll WHERE year = '$year' GROUP BY class_id ";
        }
            $count       =   $this->db->query($count_stud)->result_array();
            
            $attendance_perc    =   array();
            foreach($count as $val){
                if(isset($school_id) && $school_id > 0){
                    $attendance = "SELECT cls.name as class_name, cls.class_id as classId, (COUNT(student_id)/".($val['cnt']*$total_day_covered)."*100) as percent 
                FROM `attendance` as attn JOIN class as cls ON attn.class_id = cls.class_id WHERE timestamp > '".$start_date."' and timestamp < '".$end_date."' 
                AND cls.class_id = '".$val['class_id']."' AND cls.school_id = '".$school_id."' GROUP BY attn.class_id";
                } else {
                    $attendance = "SELECT cls.name as class_name, cls.class_id as classId, (COUNT(student_id)/".($val['cnt']*$total_day_covered)."*100) as percent 
                FROM `attendance` as attn JOIN class as cls ON attn.class_id = cls.class_id WHERE timestamp > '".$start_date."' and timestamp < '".$end_date."' 
                AND cls.class_id = '".$val['class_id']."' GROUP BY attn.class_id";
                }
                
                $rsStudent      =   $this->db->query($attendance)->result_array(); 
                if(!empty($rsStudent)) {
                    $rsStudent      =   array_shift($rsStudent);
                    $attendance_perc[]      =   $rsStudent;
                } else {
                    if(isset($school_id) && $school_id > 0){
                        $class_sql              =   "SELECT name as class_name FROM class WHERE class_id = '".$val['class_id']."' AND school_id = '".$school_id."'";
                    } else {
                        $class_sql              =   "SELECT name as class_name FROM class WHERE class_id = '".$val['class_id']."'";
                    }
                    
                    $res                    =   $this->db->query($class_sql)->result_array(); 
                    $class                  =   array_shift($res);
                    $attendance_perc[]      =   array('class_name'=>$class['class_name'],'percent'=>0);
                }
            }
            return $attendance_perc;   
    }
    function get_student_attendance_dashboard($section_id,$class_id,$running_year,$timestamp,$student_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
        }
        if(isset($school_id) && $school_id > 0){
            $this->db->where('school_id',$school_id);
        } 
        $this->db->group_by('timestamp');
        $this->db->select('status');
        $this->db->from('attendance');
        $this->db->where(array('section_id' => $section_id, 'status'=>1, 'class_id' => $class_id, 'year' => $running_year, 'timestamp' => $timestamp, 'student_id' => $student_id));
        $rsStudent = $this->db->get()->result_array();        
        return $rsStudent;
    }
    
    function get_attendence_student_month($student_id){     
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
        }
        $year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
        $running_year       =   date('Y');
        $num_month          =   date('m');
        $date               =   date('d-m-Y');
        $days               =   cal_days_in_month(CAL_GREGORIAN, $num_month, $running_year);
        $start_date         =   strtotime('01-' . $num_month . '-' . $running_year);
        $total_day_covered  =   date('d');
        $end_date           =   strtotime($total_day_covered+1 . '-' . $num_month . '-' . $running_year);
        
        if(isset($school_id) && $school_id > 0){
            $count_stud  =   "SELECT class_id,COUNT(student_id) as cnt FROM enroll WHERE year = '$year' AND school_id = '".$school_id."' GROUP BY class_id "; 
        } else {
            $count_stud  =   "SELECT class_id,COUNT(student_id) as cnt FROM enroll WHERE year = '$year' GROUP BY class_id "; 
        }
        
        $count       =   $this->db->query($count_stud)->result_array();

        $attendance_perc    =   array();
        $rsStudent = array();
        foreach($count as $val){
            if(isset($school_id) && $school_id > 0){
                $attendance = "SELECT round(COUNT(student_id)/".($val['cnt']*$total_day_covered)."*100) as percent FROM `attendance` WHERE timestamp > '".$start_date."' and timestamp < '".$end_date."' and student_id = ".$student_id." and school_id = '".$school_id."'";
            } else {
                $attendance = "SELECT round(COUNT(student_id)/".($val['cnt']*$total_day_covered)."*100) as percent FROM `attendance` WHERE timestamp > '".$start_date."' and timestamp < '".$end_date."' and student_id = ".$student_id." ";
            }
            
            $rsStudent      =   $this->db->query($attendance)->result_array(); 
        }
        return $rsStudent;   
    }
        
    /**
     * 
     * @param type $id
     * @return type
     */
    function get_data_by_id($id,$returnColsStr=""){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
        }
        if(isset($school_id) && $school_id > 0){
            $this->db->where('school_id',$school_id);
        } 
        if($returnColsStr==""){
            return $this->db->get_where($this->_table,array($this->_primary=>$id))->result();
        }else{
            return $this->db->select($returnColsStr)->from($this->_table)->where($this->_primary,$id)->get()->result();
        }
    }
        
        
        /**
    * 
    * @param type $columnName
    * @param type $conditionArr
    * @param type $return_type="result"
    * @return type
    * example it will use in controlelr
    * 
    * =====bellow is for * data without conditions======
    * get_data_generic_fun('parent','*');
    *  =====bellow is for * data witht conditions======
    * get_data_generic_fun('parent','*',array('column1'=>$column1Value,'column2'=>$column2Value));
    * 
    * =====bellow is for 1 or more column data without conditions======
    * get_data_generic_fun('parent','column1,column2,column3');
    *  =====bellow is for 1 or more column data with conditions======
    * get_data_generic_fun('parent','column1,column2,column3',array('column1'=>$column1Value,'column2'=>$column2Value));
    *  =====bellow is for 1 or more column data with conditions and return as result all======
    * get_data_generic_fun('parent','column1,column2,column3',array('column1'=>$column1Value,'column2'=>$column2Value),'result_arr');
    * 
    * ==== modification for  adding sortby and limit and add conditionArr for AND -- OR -- IN ---
    * get_data_generic_fun('parent','parent_id,passcode',array('passcode'=>$passcoad,'device_token'=>$deviceToken,'condition_type'=>'or'),array('parrent_id'=>'asc','date_time'=>'desc'),1);
    */
    function get_data_by_cols($columnName="*",$conditionArr=array(),$return_type="result",$sortByArr=array(),$limit=""){
        $school_id = '';
        if(($this->session->userdata('school_id')))
        $school_id = $this->session->userdata('school_id');
        if(isset($school_id) && $school_id > 0){
            $this->db->where('school_id',$school_id);
        } 
        $this->db->select($columnName);
        $condition_type='and';
        if(array_key_exists('condition_type', $conditionArr)){
            if($conditionArr['condition_type']!=""){
                $condition_type=$conditionArr['condition_type'];
            }
        }
        unset($conditionArr['condition_type']);
        $condition_in_data_arr=array();
        $startCounter=0;
        $condition_in_column="";
        foreach($conditionArr AS $k=>$v){
            if($condition_type=='in'){
                if(array_key_exists('condition_in_data', $conditionArr)){
                    $condition_in_data_arr=  explode(',', $conditionArr['condition_in_data']);
                    $condition_in_column=$conditionArr['condition_in_col'];
                }

            }elseif($condition_type=='or'){
                if($startCounter==0){
                    $this->db->where($k,$v);
                }else{
                    $this->db->or_where($k,$v);
                }
            }elseif($condition_type=='and'){
                $this->db->where($k,$v);
            }
            $startCounter++;
        }

         if($condition_type=='in'){
             if(!empty($condition_in_data_arr))
                 $this->db->where_in($condition_in_column,$condition_in_data_arr);
        }

        if($limit!=""){
            $this->db->limit($limit);
        }
        
        if(!empty($sortByArr)) {
            foreach($sortByArr AS $key=>$val){
                $this->db->order_by($key,$val);
            }
        }

        if($return_type=='result'){
            $rs=$this->db->get($this->_table)->result();
        }else{
            $rs=$this->db->get($this->_table)->result_array();
        }
        /*echo "Attendance_model".'<br/>';
        echo $this->db->last_query(); die();*/
        return $rs;
    }
    
    function get_data_by_cols_groupby($columnName="*",$conditionArr=array(),$return_type="result",$sortByArr=array(),$limit="",$group_by){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
        }
        if(isset($school_id) && $school_id > 0){
            $this->db->where('school_id',$school_id);
        } 
        $this->db->select($columnName);
        $condition_type='and';
        if(array_key_exists('condition_type', $conditionArr)){
            if($conditionArr['condition_type']!=""){
                $condition_type=$conditionArr['condition_type'];
            }
        }
        unset($conditionArr['condition_type']);
        $condition_in_data_arr=array();
        $startCounter=0;
        $condition_in_column="";
        foreach($conditionArr AS $k=>$v){
            if($condition_type=='in'){
                if(array_key_exists('condition_in_data', $conditionArr)){
                    $condition_in_data_arr=  explode(',', $conditionArr['condition_in_data']);
                    $condition_in_column=$conditionArr['condition_in_col'];
                }

            }elseif($condition_type=='or'){
                if($startCounter==0){
                    $this->db->where($k,$v);
                }else{
                    $this->db->or_where($k,$v);
                }
            }elseif($condition_type=='and'){
                $this->db->where($k,$v);
            }
            $startCounter++;
        }

         if($condition_type=='in'){
             if(!empty($condition_in_data_arr))
                 $this->db->where_in($condition_in_column,$condition_in_data_arr);
        }

        if($limit!=""){
            $this->db->limit($limit);
        }
        
        if($group_by!=""){
            $this->db->group_by($group_by);
        }
        
        if(!empty($sortByArr)) {
            foreach($sortByArr AS $key=>$val){
                $this->db->order_by($key,$val);
            }
        }

        if($return_type=='result'){
            $rs=$this->db->get($this->_table)->result();
        }else{
            $rs=$this->db->get($this->_table)->result_array();
        }

        return $rs;
    }
    
    function get_today_attendance(){        
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
        }
        if(isset($school_id) && $school_id > 0){
            $this->db->where('school_id',$school_id);
        } 
        $check = array('timestamp' => strtotime(date('Y-m-d')), 'status' => '1');
        $query = $this->db->get_where($this->_table, $check);
        $present_today = $query->num_rows();
        return $present_today;
    }
    
    function get_present_students(){        
        $check = array("DATE('timestamp')" => date('Y-m-d'), 'status' => '1');
        $query = $this->db->get_where($this->_table, $check);
        $present_today = $query->num_rows();
        return $present_today;
    }
    
    function get_absent_students(){        
        $check = array("DATE('timestamp')" => date('Y-m-d'), 'status' => '2');
        $query = $this->db->get_where($this->_table, $check);
        $present_today = $query->num_rows();
        return $present_today;
    }
    
    function getClassWiseAttendanceOfSchool($school_id){
        $running_year=  $this->session->userdata('running_year');
        $check = array($this->_table.'.school_id' => $school_id,'status' => '1');
        $this->db->where(array('year'=>$running_year,"timestamp" => strtotime(date('Y-m-d'))));
        $this->db->join( 'class as class' , $this->_table.".class_id = class.class_id",'LEFT');
        $query = $this->db->select("class.class_id,class.name,COUNT(attendance_id) as total_attendance")->group_by("class.class_id")->get_where($this->_table, $check);
        
        $attendance = $query->result_array();
        return $attendance;
    }


    //New functions
    function get_student($whr=array()){
        _school_cond('S.school_id');
        _year_cond('E.year');
        $this->db->select('S.*,E.roll,E.class_id,E.section_id,C.name class_name,SC.name section_name,E.enroll_code,E.date_added,P.father_name,P.father_lname,
                          P.mother_name,P.mother_lname,P.email parent_email,P.cell_phone parent_phone,P.device_token',FALSE);  
        $this->db->from('student S');
        $this->db->join('enroll E','E.student_id=S.student_id','LEFT'); 
        $this->db->join('class C','C.class_id=E.class_id','LEFT');  
        $this->db->join('section SC','SC.section_id=E.section_id','LEFT');  
        $this->db->join('parent P','P.parent_id=S.parent_id','LEFT');
        $this->db->where($whr);
        return $this->db->get()->row(); 
    }
    
    function get_student_attendance($whr=array(),$date=false,$order_by='S.name ASC',$having=array()){
        _school_cond('S.school_id');
        _year_cond('E.year');
        $this->db->select('S.*,E.roll,E.year running_year,E.class_id,E.section_id,C.name class_name,SC.name section_name,E.enroll_code,E.date_added,P.father_name,
                          P.father_lname,P.mother_name,P.mother_lname,P.email parent_email,P.cell_phone parent_phone,P.device_token,
                          (SELECT attendance_id FROM attendance AT WHERE AT.year=E.year AND AT.class_id=E.class_id AND AT.section_id=E.section_id 
                          AND AT.student_id=E.student_id 
                          AND (AT.date = "'.$date.'" OR DATE_FORMAT(FROM_UNIXTIME(AT.timestamp), "%Y-%m-%d") = "'.$date.'") LIMIT 1) attendance_id,
                          (SELECT timezone FROM attendance AT WHERE AT.year=E.year AND AT.class_id=E.class_id AND AT.section_id=E.section_id 
                          AND AT.student_id=E.student_id
                          AND (AT.date = "'.$date.'" OR DATE_FORMAT(FROM_UNIXTIME(AT.timestamp), "%Y-%m-%d") = "'.$date.'") LIMIT 1) timezone,
                          (SELECT date FROM attendance AT WHERE AT.year=E.year AND AT.class_id=E.class_id AND AT.section_id=E.section_id 
                          AND AT.student_id=E.student_id
                          AND (AT.date = "'.$date.'" OR DATE_FORMAT(FROM_UNIXTIME(AT.timestamp), "%Y-%m-%d") = "'.$date.'") LIMIT 1) at_date,
                          (SELECT DATE_FORMAT(FROM_UNIXTIME(AT.timestamp), "%Y-%m-%d") FROM attendance AT WHERE AT.year=E.year AND AT.class_id=E.class_id 
                          AND AT.section_id=E.section_id AND AT.student_id=E.student_id
                          AND (AT.date = "'.$date.'" OR DATE_FORMAT(FROM_UNIXTIME(AT.timestamp), "%Y-%m-%d") = "'.$date.'") LIMIT 1) tm_date,
                          (SELECT has_in FROM attendance AT WHERE AT.year=E.year AND AT.class_id=E.class_id AND AT.section_id=E.section_id 
                          AND AT.student_id=E.student_id
                          AND (AT.date = "'.$date.'" OR DATE_FORMAT(FROM_UNIXTIME(AT.timestamp), "%Y-%m-%d") = "'.$date.'") LIMIT 1) has_in,
                          (SELECT has_out FROM attendance AT WHERE AT.year=E.year AND AT.class_id=E.class_id AND AT.section_id=E.section_id 
                          AND AT.student_id=E.student_id
                          AND (AT.date = "'.$date.'" OR DATE_FORMAT(FROM_UNIXTIME(AT.timestamp), "%Y-%m-%d") = "'.$date.'") LIMIT 1) has_out,
                          (SELECT in_time FROM attendance AT WHERE AT.year=E.year AND AT.class_id=E.class_id AND AT.section_id=E.section_id 
                          AND AT.student_id=E.student_id
                          AND (AT.date = "'.$date.'" OR DATE_FORMAT(FROM_UNIXTIME(AT.timestamp), "%Y-%m-%d") = "'.$date.'") LIMIT 1) in_time,
                          (SELECT out_time FROM attendance AT WHERE AT.year=E.year AND AT.class_id=E.class_id AND AT.section_id=E.section_id 
                          AND AT.student_id=E.student_id
                          AND (AT.date = "'.$date.'" OR DATE_FORMAT(FROM_UNIXTIME(AT.timestamp), "%Y-%m-%d") = "'.$date.'") LIMIT 1) out_time,
                          (SELECT status FROM attendance AT WHERE AT.year=E.year AND AT.class_id=E.class_id AND AT.section_id=E.section_id 
                          AND AT.student_id=E.student_id
                          AND (AT.date = "'.$date.'" OR DATE_FORMAT(FROM_UNIXTIME(AT.timestamp), "%Y-%m-%d") = "'.$date.'") LIMIT 1) status,
                          (SELECT timing_status FROM attendance AT WHERE AT.year=E.year AND AT.class_id=E.class_id AND AT.section_id=E.section_id 
                          AND AT.student_id=E.student_id
                          AND (AT.date = "'.$date.'" OR DATE_FORMAT(FROM_UNIXTIME(AT.timestamp), "%Y-%m-%d") = "'.$date.'") LIMIT 1) timing_status,
                          (SELECT custom_updated FROM attendance AT WHERE AT.year=E.year AND AT.class_id=E.class_id AND AT.section_id=E.section_id 
                          AND AT.student_id=E.student_id
                          AND (AT.date = "'.$date.'" OR DATE_FORMAT(FROM_UNIXTIME(AT.timestamp), "%Y-%m-%d") = "'.$date.'") LIMIT 1) custom_updated,
                          (SELECT closed FROM attendance AT WHERE AT.year=E.year AND AT.class_id=E.class_id AND AT.section_id=E.section_id 
                          AND AT.student_id=E.student_id
                          AND (AT.date = "'.$date.'" OR DATE_FORMAT(FROM_UNIXTIME(AT.timestamp), "%Y-%m-%d") = "'.$date.'") LIMIT 1) closed',FALSE);   
        $this->db->from('student S');
        $this->db->join('enroll E','E.student_id=S.student_id','LEFT'); 
        $this->db->join('class C','C.class_id=E.class_id','LEFT');  
        $this->db->join('section SC','SC.section_id=E.section_id','LEFT');  
        $this->db->join('parent P','P.parent_id=S.parent_id','LEFT');
        foreach($whr as $wk=>$wv){
            if($wv)
                $this->db->where($wk,$wv);
            else
                $this->db->where($wk);
        } 
        $this->db->order_by($order_by);
        $this->db->where($having);
        return $this->db->get()->result(); 
    }

    function get_student_att($whr=array()){
        _school_cond('S.school_id');
        _year_cond('E.year');
        $this->db->select('S.*,',FALSE);   
        $this->db->from('student S');
        $this->db->join('enroll E','E.student_id=S.student_id','LEFT'); 
        $this->db->join('attendance AT','AT.year=E.year AND AT.class_id=E.class_id AND AT.section_id=E.section_id AND AT.student_id=E.student_id','INNER');
        foreach($whr as $wk=>$wv){
            if($wv)
                $this->db->where($wk,$wv);
            else
                $this->db->where($wk);
        } 
        return $this->db->get()->result(); 
    }

    function save_student_attendance($data){
        if(isset($data['attendance_id']) && $data['attendance_id']){
            $this->db->update('attendance',$data,array('attendance_id'=>$data['attendance_id']));
            $flag = $data['attendance_id'];
        }else{
            $this->db->insert('attendance',$data);
            $flag = $this->db->insert_id();
        }
        return $flag;
    }


    //subjetwise
    function get_student_subject_attendance($whr=array(),$subject_id=false,$date=false,$order_by='S.name ASC'){
        _school_cond('S.school_id');
        _year_cond('E.year');
        $this->db->select('S.*,E.roll,E.year running_year,E.class_id,E.section_id,C.name class_name,SC.name section_name,E.enroll_code,E.date_added,P.father_name,
                          P.father_lname,P.mother_name,P.mother_lname,P.email parent_email,P.cell_phone parent_phone,P.device_token,
                          (SELECT id FROM subject_attendance AT WHERE AT.year=E.year AND AT.class_id=E.class_id AND AT.section_id=E.section_id 
                          AND AT.student_id=E.student_id AND AT.subject_id="'.$subject_id.'" AND AT.date="'.$date.'" LIMIT 1) attendance_id,
                          (SELECT subject_id FROM subject_attendance AT WHERE AT.year=E.year AND AT.class_id=E.class_id AND AT.section_id=E.section_id 
                          AND AT.student_id=E.student_id AND AT.subject_id="'.$subject_id.'" AND AT.date="'.$date.'" LIMIT 1) subject_id,
                          (SELECT status FROM subject_attendance AT WHERE AT.year=E.year AND AT.class_id=E.class_id AND AT.section_id=E.section_id 
                          AND AT.student_id=E.student_id AND AT.subject_id="'.$subject_id.'" AND AT.date="'.$date.'" LIMIT 1) att_status,',FALSE);  
        $this->db->from('student S');
        $this->db->join('enroll E','E.student_id=S.student_id','LEFT'); 
        $this->db->join('class C','C.class_id=E.class_id','LEFT');  
        $this->db->join('section SC','SC.section_id=E.section_id','LEFT');  
        $this->db->join('parent P','P.parent_id=S.parent_id','LEFT');
        $this->db->where($whr);
        $this->db->order_by($order_by);
        return $this->db->get()->result(); 
    }

    //---Teacher
    function get_teacher($whr=array()){
        return $this->db->get_where('teacher',$whr)->row(); 
    }

    function get_teacher_attendance($whr=array(),$date=false,$order_by='T.name ASC'){
        _school_cond('T.school_id');
        $this->db->select('T.*,
                          (SELECT attendance_id FROM attendance_teacher AT WHERE AT.teacher_id=T.teacher_id AND AT.date="'.$date.'" LIMIT 1) attendance_id,
                          (SELECT has_in FROM attendance_teacher AT WHERE AT.teacher_id=T.teacher_id AND AT.date="'.$date.'" LIMIT 1) has_in,
                          (SELECT has_out FROM attendance_teacher AT WHERE AT.teacher_id=T.teacher_id AND AT.date="'.$date.'" LIMIT 1) has_out,
                          (SELECT in_time FROM attendance_teacher AT WHERE AT.teacher_id=T.teacher_id AND AT.date="'.$date.'" LIMIT 1) in_time,
                          (SELECT out_time FROM attendance_teacher AT WHERE AT.teacher_id=T.teacher_id AND AT.date="'.$date.'" LIMIT 1) out_time,
                          (SELECT status FROM attendance_teacher AT WHERE AT.teacher_id=T.teacher_id AND AT.date="'.$date.'" LIMIT 1) status,
                          (SELECT timing_status FROM attendance_teacher AT WHERE AT.teacher_id=T.teacher_id AND AT.date="'.$date.'" LIMIT 1) timing_status,
                          (SELECT custom_updated FROM attendance_teacher AT WHERE AT.teacher_id=T.teacher_id AND AT.date="'.$date.'" LIMIT 1) custom_updated,
                          (SELECT closed FROM attendance_teacher AT WHERE AT.teacher_id=T.teacher_id AND AT.date="'.$date.'" LIMIT 1) closed'); 
        $this->db->from('teacher T');
        $this->db->where($whr);
        $this->db->order_by($order_by);
        return $this->db->get()->result(); 
    }
}
