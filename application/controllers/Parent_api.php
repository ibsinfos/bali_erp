<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';
class parent_api extends REST_Controller{
    function __construct($config = 'rest1') {
        parent::__construct($config);
        $this->globalSettingsSMSDataArr=get_data_generic_fun('settings','description',array('condition_type'=>'in','condition_in_col'=>'type','condition_in_data'=>'location,app_package_name,running_year,system_name,system_email'));
        //pre($this->globalSettingsSMSDataArr);
        $this->globalSettingsLocation=$this->globalSettingsSMSDataArr[3]->description;
        $this->globalSettingsAppPackageName=$this->globalSettingsSMSDataArr[4]->description;
        $this->globalSettingsRunningYear=$this->globalSettingsSMSDataArr[2]->description;
        $this->globalSettingsSystemName=$this->globalSettingsSMSDataArr[0]->description;
        $this->globalSettingsSystemEmail=$this->globalSettingsSMSDataArr[1]->description;
    }
    
   /********getting child information*****/ 
    
    function my_child_post(){
       $userId= $this->post("user_id");
       if($userId==""){
            $data['action']="fail";
            $data['message']="Please provide user id";
            success_response_after_post_get($data);
        }else{
            $data['studentDataArr']= get_data_generic_fun("student","student_id,name",array("parent_id"=>$userId),'array');
            success_response_after_post_get($data);
        }
    }
    
    /********getting student list by section id *****/ 
    
    function student_list_post(){
        $this->load->model("Parent_model");
        $sectionId=$this->post("section_id");
        if($sectionId==""){
            $data['action']="fail";
            $data['message']="Please provide section id";
            success_response_after_post_get($data);
        }else{
            $data['studentDataArr'] = $this->Parent_model->get_student_list($sectionId);
            //echo $this->db->last_query();
            //exit();
            success_response_after_post_get($data);
        }
    }
    
    /********getting student information*****/ 
    
    function student_post(){
        $this->load->model("Student_model");
        $this->load->model("Setting_model");
        $studentId              =   $this->post("student_id");
        
        if($studentId==""){
            $data['action']     =   "fail";
            $data['message']    =   "Please provide student id";
            success_response_after_post_get($data);
        }else{
            $data['studentArray'] = $this->Student_model->get_student_details($studentId);
//            pre($data['studentArray']);
//            die;
            //$this->db->last_query();
            success_response_after_post_get($data);            
        }
    }
    
   /********get the attendance report of a student*****/
    
    function attendance_month_report_post(){
        $this->load->model("Student_model");
        $this->load->model("Setting_model");
        $studentId      = $this->post("student_id");
        //echo $studentId; exit;
        if($studentId == ''){
            $data['action']     =   "fail";
            $data['message']    =   "Please provide student id";
            success_response_after_post_get($data);            
        }else{
            $month_val      = $this->post("month_val");
            if($month_val == ''){
                $data['action']     =   "fail";
                $data['message']    =   "Please select month";
                success_response_after_post_get($data);
            }else{
                $studentDataArr                 =   $this->Student_model->get_student_class_section($studentId);
                if(!empty($studentDataArr)){
                    $data['class_id']           =   $studentDataArr['class_id'];
                    $data['month']              =   $month_val;
                    $data['student_id']         =   $studentId;
                    $section_name               =   $studentDataArr['section_name'];
                    $class_name                 =   $studentDataArr['class_name'];
                    $data['section_id']         =   $studentDataArr['section_id'];
                    $data['class_name']         =   $class_name;
                    $data['section_name']       =   $section_name;
                    $running_year               =   $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
                    $year                       =   explode('-', $running_year); 
                    $days                       =   cal_days_in_month(CAL_GREGORIAN, $month_val, $year[0]);
                    $attendance=array();
                    for ($i = 1; $i <= $days; $i++) {
                       $date_data=$i . '-' . $month_val . '-' . $year[0];
                       $timestamp = strtotime($date_data);
                       $tempdata      =   get_data_generic_fun('attendance', '*',array('section_id' => $data['section_id'], 'class_id' => $data['class_id'], 'year' => $running_year, 'timestamp' => $timestamp, 'student_id' => $data['student_id']), 'result_arr', array('timestamp'=>'GROUP BY'));
                        if(empty($tempdata))
                            $attendance[$i] =$tempdata;
                        else
                            $attendance[$i] =$tempdata[0];
                        $data['attenadanceArr']=$attendance;
                        //pre($data);
                        //echo $this->db->last_query();
                        //exit;
                    }
                    success_response_after_post_get($data);
                }
            }
        }        
    }
    
   /********getting class list*****/ 
    
   function class_list_post(){
        $classId=$this->post("class_id");
        if($classId==""){
            $data['classDataArr']= get_data_generic_fun("class","class_id,name",array(),'arr');
            success_response_after_post_get($data);
        }else{
            $data['classDataArr']= get_data_generic_fun("class","class_id,name",array("class_id"=>$classId),'array');
            success_response_after_post_get($data);
        }
    }
    
    /********getting section list*****/ 
    
    function section_list_post(){
        $classId=$this->post("class_id");
        if($classId==""){
            $data['sectionDataArr']= get_data_generic_fun("section","section_id,name,nick_name",array(),'arr');
            success_response_after_post_get($data);
        }else{
            $data['sectionDataArr']= get_data_generic_fun("section", "section_id,name,nick_name", array("class_id"=>$classId),'array');
            success_response_after_post_get($data);
        }   
    }
    
    /********getting teacher list*****/ 

    function teacher_list_post(){
        $userId= $this->post("user_id");
        if($userId==""){
            $data['action']="fail";
            $data['message']="Please provide user id";
            success_response_after_post_get($data);
        }else{
            $data['teacherDataArr']= get_data_generic_fun("teacher","*",array(),"arr");
            success_response_after_post_get($data);
        }
    }
    
    function admission_students_post(){
        $userId=$this->post("user_id");
        if($userId==""){
            $data['action']="fail";
            $data['message']="Please provide user id";
            success_response_after_post_get($data);
        }else{
            $this->load->model("Enquired_students_model");
            $data['enquiredStudentDataArr']= $this->Enquired_students_model->get_my_enquired_chield($userId);
            success_response_after_post_get($data);
        }
    }
    
    function admission_student_details_post(){
        $userId=$this->post("user_id");
        if($userId==""){
            $data['action']="fail";
            $data['message']="Please provide user id";
            success_response_after_post_get($data);
        }else{
            $student_id=$this->post("student_id");
            if($student_id==""){
                $data['action']="fail";
                $data['message']="Please provide student id";
                success_response_after_post_get($data);
            }else{
                $this->load->model("Enquired_students_model");
                $data['action']="success";
                $data["studentDetails"]= $this->Enquired_students_model->get_student_details($student_id);
                success_response_after_post_get($data);
            }
        }
    }
  function student_attendance_post(){
        $userId=$this->post("user_id");
        if($userId==""){
            $data['action']="fail";
            $data['message']="Please provide user id";
            success_response_after_post_get($data);
        }else{
            $student_id=$this->post("student_id");
            if($student_id==""){
                $data['action']="fail";
                $data['message']="Please provide student id";
                success_response_after_post_get($data);
            }else{
                $data['action']="success";
                $months = array(
                    '1'=>'January',
                    '2'=>'February',
                    '3'=>'March',
                    '4'=>'April',
                    '5'=>'May',
                    '6'=>'June',
                    '7'=>'July ',
                    '8'=>'August',
                    '9'=>'September',
                    '10'=>'October',
                    '11'=>'November',
                    '12'=>'December',
                );
                $data["monthData"]=$months;
                $data["student_id"]=$student_id;
                success_response_after_post_get($data);
            }
        }
    }
    
    function get_attendance_report_post(){
        $userId=$this->post("user_id");
        if($userId==""){
            $data['action']="fail";
            $data['message']="Please provide user id";
            success_response_after_post_get($data);
        }else{
            $student_id=$this->post("student_id");
            $month=$this->post("month");
            if($student_id=="" && $month==""){
                $data['action']="fail";
                $data['message']="Please select month for attendance report";
                success_response_after_post_get($data);
            }else{
                $studentDataArr= get_data_generic_fun("student","*",array("student_id"=>$student_id));
                if(!empty($studentDataArr)){
                    $data['action']="success";
                    $year = explode('-', $this->globalSettingsRunningYear);
                    $days = cal_days_in_month(CAL_GREGORIAN, $month, $year[0]);
                    success_response_after_post_get($data);
                }
                
            }
        }
    }
    
        /*
     * get Student Details
     * 
     */
    function getStudentDetials_post(){
        $student_id         =   $this->post("student_id");
        $this->load->model("Enquired_students_model");
        $student_det            = $this->Enquired_students_model->get_student_details($student_id);
        if($student_det) {
            success_response_after_post_get($data);
        } else {
            success_response_after_post_get(array('status'=>"fail",'message'=>'No data available'));
        }
    }
    
    /********getting report card of student*****/ 
    
    function manage_mark_post(){
        $this->load->model("Parent_model");
        $studentId=$this->post("student_id");
        if($studentId==""){
            $data['action']="fail";
            $data['message']="Please provide student id";
            success_response_after_post_get($data);
        }else{
            $examId=$this->post("exam_id");
            if($examId==""){
                $data['action']="fail";
                $data['message']="Please provide exam id";
                success_response_after_post_get($data);
            }else{ 
                $data['RecordDataArr']=$this->Parent_model->get_manage_mark($studentId,$examId);
                success_response_after_post_get($data); 
            }
        }
    }
    
    /********getting subject list*****/ 
    
    function subject_list_post(){
        $this->load->model("Parent_model");
        $studentId= $this->post("student_id");
        if($studentId==""){
            $data['action']="fail";
            $data['message']="please fill the student Id";
            success_response_after_post_get($data);
        }else{
            $data['subjectDataArr']=$this->Parent_model->get_subject_list($studentId);
            success_response_after_post_get($data);
            }
        }
        
        /********getting progress report of student*****/ 
        
    function progress_report_post(){
        $this->load->model("Parent_model");
        $studentId=$this->post("student_id");
        if($studentId==""){
            $data['action']="fail";
            $data['message']="Please provide student id";
            success_response_after_post_get($data);
        }else{
            $subjectId=$this->post("subject_id");
            if($subjectId==""){
                $data['action']="fail";
                $data['message']="Please provide subject id";
                success_response_after_post_get($data);
            }else{ 
            $data['ReportDataArr']=$this->Parent_model->get_progress_report($studentId,$subjectId);
            success_response_after_post_get($data);
            }
        }
    }
    
    /********getting class routine of student*****/ 
    
    function class_routine_post(){
        $this->load->model("Parent_model");
        $studentId=$this->post("student_id");
        if($studentId==""){
            $data['action']="fail";
            $data['message']="Please provide student id";
            success_response_after_post_get($data);
        }else{
            $data['routineDataArr']= $this->Parent_model->get_class_routine($studentId);
            success_response_after_post_get($data);
        } 
    }
    function exam_list_post(){
        $examId=$this->post("exam_id");
        if($examId==""){
            $data['examDataArr']= get_data_generic_fun("exam","exam_id,name,date",array(),'arr');
            success_response_after_post_get($data);
        }else{
            $data['examDataArr']= get_data_generic_fun("exam","exam_id,name,date",array("exam_id"=>$examId),'array');
            success_response_after_post_get($data);
            }
    }
    function student_invoice_post(){
        $this->load->model("Invoice_model");
        $studentId=$this->post("student_id");
        if($studentId==""){
            $data['action']="fail";
            $data['message']="Please provide student id";
            success_response_after_post_get($data);
        }else{
        $data['feesDataArr']= $this->Invoice_model->get_student_invoice($studentId);
            success_response_after_post_get($data);   
        }
    }
    function student_ptm_post(){
        $this->load->model("Parent_teacher_meeting_model");
        $parentId=$this->post("parent_id");
        if($parentId==""){
            $data['action']="fail";
            $data['message']="Please provide parent id";
            success_response_after_post_get($data);
        }else{
        $data['ptmDataArr']= $this->Parent_teacher_meeting_model->get_ptm_details($parentId);
            success_response_after_post_get($data);   
        }
    }
}

