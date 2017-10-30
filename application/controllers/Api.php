<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Api extends REST_Controller{
    function __construct($config = 'rest1') {
        parent::__construct($config);
        //$this->load->model('Master_data_model');
         $this->load->model("Api_model");
    }
    
    function registered_app_post(){
        $this->load->model("Admin_model");
        $this->load->model("School_Admin_model");
        //error_reporting(E_ALL);
        //@ini_set('display_errors', 1);
        $passcoad   =       $this->post('passcode');
        $UDID       =       trim($this->post('device_id'));
        $deviceToken    =   trim($this->post('deviceToken'));
        $deviceType     =   trim($this->post('deviceType'));
        $latitude       =   trim($this->post('latitude'));
        $longitude      =   trim($this->post('longitude'));
        
        if($passcoad==""){
            $parram=array('message'=>'Passcoad should not be blank','action'=>'fail');
            success_response_after_post_get($parram);return TRUE;
        }
        
        $defaultDataArr=array('UDID'=>$UDID,'deviceType'=>$deviceType,'deviceToken'=>$deviceToken,'latitude'=>$latitude,'longitude'=>$longitude);
        $isValideDefaultData=  $this->check_default_data($defaultDataArr);
        if($isValideDefaultData['type']=='fail'){
            $parram=array('message'=>$isValideDefaultData['message'],'action'=>'fail');
            success_response_after_post_get($parram);return TRUE;
        }
        
        $this->load->model('App_info_model');
        $userTypeIdArr=array('parent'=>1,'school_admin'=>2,'teacher'=>3,'bus_driver'=>4,'student'=>5);
        if(strtolower(substr($passcoad,0,3))=='spa'){
            $userType='parent';
            $this->load->model('Parent_model');
        }else if(strtolower(substr($passcoad,0,3))=='sad'){
            $userType='school_admin';
            $this->load->model('School_Admin_model');
        }else if(strtolower(substr($passcoad,0,3))=='sta'){
            $userType='teacher';
            $this->load->model('Teacher_model');
        }else if(strtolower(substr($passcoad,0,3))=='dri'){
            $userType='bus_driver';
            $this->load->model('Bus_driver_modal');
        }else if(strtolower(substr($passcoad,0,3))=='stu'){
            $userType='student';
            $this->load->model('Student_model');
        }else{
            $parram=array('message'=>"Invalid passcode entntered.Please try again.",'action'=>'fail');
            success_response_after_post_get($parram);return TRUE;
        }
        
        $table_col=$userType.'_id';
            $rs     =   get_data_generic_fun($userType,$userType.'_id,passcode,school_id',array('passcode'=>$passcoad));
            if(count($rs)>0){
                if($userType=='school_admin'){
                    $this->School_Admin_model->edit(array('device_token'=>$deviceToken),array($table_col=>$rs[0]->$table_col));
                }else if($userType=='parent'){
                    $this->Parent_model->update_parent(array('device_token'=>$deviceToken),array($table_col=>$rs[0]->$table_col));
                }else if($userType=='teacher'){
                    $this->Teacher_model->update_teacher(array('device_token'=>$deviceToken),   $rs[0]->$table_col);
                }else if($userType=='bus_driver'){
                    $this->Bus_driver_modal->update_bus_driver(array('device_token'=>$deviceToken),array($table_col=>$rs[0]->$table_col));
                }else if($userType=='student'){
                    $this->Student_model->update_student(array('device_token'=>$deviceToken),array($table_col=>$rs[0]->$table_col));
                }            
                $dataArray=array('device_type'=>$deviceType,'device_id'=>$UDID,'device_token'=>$deviceToken,
                'latitude'=>$latitude,'longitude'=>$longitude,'added_on'=>date('Y-m-d H:i:s'),$table_col=>$rs[0]->$table_col,'passcode'=>$passcoad,
                    'user_type'=>$userTypeIdArr[$userType],'school_id'=>$rs[0]->school_id);

                $result=$this->App_info_model->add($dataArray);
                if($result>0){
                    $parram=array('message'=>'1','action'=>'success','user_id'=>$rs[0]->$table_col,'user_type'=>$userType,'welcome_message'=>'Welcome to Sharad School');
                    success_response_after_post_get($parram);
                }else{
                    $parram=array('message'=>'Please try again.','action'=>'fail');
                    success_response_after_post_get($parram);
                }
            }else{
                $parram=array('message'=>'Your passcode "'.$passcoad.'" is not found,Please provide correct passcode.','action'=>'fail');
                success_response_after_post_get($parram);
            }        
    }
    
    function check_default_data($dataArr){
        $validateArr=array('type'=>'success');
        if($dataArr['UDID']==""){
            $validateArr['type']='fail';
            $validateArr['message']='Please provide device id.';
            return $validateArr;
        }
        
        /*if($dataArr['deviceToken']==""){
            $validateArr['type']='fail';
            $validateArr['message']='Please provide device token.';
            return $validateArr;
        }*/
        
        if($dataArr['deviceType']==""){
            $validateArr['type']='fail';
            $validateArr['message']='Please provide device type.';
            return $validateArr;
        }
        
        /*if($dataArr['latitude']==""){
            $validateArr['type']='fail';
            $validateArr['message']='Please provide latitude.';
            return $validateArr;
        }
        
        if($dataArr['longitude']==""){
            $validateArr['type']='fail';
            $validateArr['message']='Please provide longitude.';
            return $validateArr;
        }
        
        /*$countryShortName=  get_country_code_from_lat_long($dataArr['latitude'], $dataArr['longitude']);
        //die($countryShortName);
        if($countryShortName==FALSE){
            $validateArr['type']='fail';
            $validateArr['message']='Please provide valid latitude and longitude';
            return $validateArr;
        }*/
        return $validateArr;
    }
        
    function get_all_group(){
        $userId=$this->post('user_id');
        if($userId==""){
            $parram=array('message'=>'Invalid user index','action'=>'fail');
            success_response_after_post_get($parram);
        }else{
            $this->load->model('Nursery_chat_group_user_model');
            $kindergartenGroupArr=  $this->Nursery_chat_group_user_model->get_all_chat_group_by_user($userId);
            $parram=array('message'=>'1','action'=>'success','kindergartenGroupArr'=>$kindergartenGroupArr);
            success_response_after_post_get($parram);
        }
    }
    
    function send_message(){
        $deviceId=trim($this->post('deviceId'));
        $fromDeviceToken=trim($this->post('deviceToken'));
        $deviceType=trim($this->post('deviceType'));
        //$latitude=trim($this->post('latitude'));
        //$longitude=trim($this->post('longitude'));
        $message=trim($this->post('message'));
        $userId=trim($this->post('userId'));
        $userType=trim($this->post('userType'));
        $groupId=trim($this->post('groupId'));
        $message=trim($this->post('message'));
        $dataArr=array('message'=>$message,'user_id'=>$userId,'user_type'=>$userType,'group_id'=>$groupId,'from_device_token'=>$fromDeviceToken);
        $validateAction=$this->check_data_validation($dataArr);
        if($validateAction['retType']=='fail'){
            $parram=array('message'=>  json_encode($validateAction['msg']),'action'=>'fail');
            success_response_after_post_get($parram);
        }else{
            $this->load->model('Nursery_chat_message_model');
            $this->load->model('Nursery_chat_group_user_model');
            $this->Nursery_chat_message_model->add($dataArr);
            
            /// send message to all token here
            $tokenArr=array();
            $allUserArr=  get_data_generic_fun('nursery_chat_group_user','*',array('group_id'=>$groupId,'user_id !='=>$userId));
            foreach($allUserArr As $k){
                if($k->user_type==1){
                    $teacherDataArr=  get_data_generic_fun('teacher','device_token',array('teacher_id'=>$k->user_id));
                    if(!empty($teacherDataArr))
                        $tokenArr[]=$teacherDataArr[0]->device_token;
                }else if($k->user_type==2){
                    $parentDataArr=  get_data_generic_fun('parent','device_token',array('parent_id'=>$k->user_id));
                    if(!empty($parentDataArr))
                        $tokenArr[]=$parentDataArr[0]->device_token;
                }
            }
            
            
        }
    }
    
    function check_data_validation($dataArr){
        $errorMsg=array();
        foreach ($dataArr AS $k => $v){
            if(trim($v)==""){
                $errorMsg[]=$k.' is blank ';
            }
        }
        if(empty($errorMsg)){
            return array('retType'=>'success');
        }else{
            return array('retType'=>'fail','msg'=>$errorMsg);
        }
    }

    function getAllPresentStudent_post()
    {
       
        $dateValue = $this->post("date_value");
        if (empty($dateValue)) 
        {
            $data['action']  = "fail";
            $data['message'] = "please fill the date";
            success_response_after_post_get($data);
        }
            $data['studentPresentArr'] =  $this->Api_model->get_all_present_student($dateValue);
            success_response_after_post_get($data);

            

    }

    function getTeacherInfo_post()
    {
        
        $teacherId = $this->post("teacher_id");
        if (empty($teacherId)) 
        {
            $data['action']  = "fail";
            $data['message'] = "please fill the teacher Id";
            success_response_after_post_get($data);
        }
        else
        {
            $data['teacherDataArr'] =  $this->Api_model->get_teacher_info($teacherId);
            success_response_after_post_get($data);

        }    

    }
    
    function getFeeDetail_post()
    {

        
        $dateValue = $this->post("date_value");
        $classId = $this->post("class_id");
        if (empty($dateValue)) 
        {
            $data['action']  = "fail";
            $data['message'] = "please fill the Date";
            success_response_after_post_get($data);
        }
        if(empty($classId))
            $classId = '';
        else
        {
            $data['feeDataArr'] =  $this->Api_model->get_student_detail($dateValue, $classId);
            success_response_after_post_get($data);

        }  

    }

    function getStudentDetail_post()
    {
        $studentId = $this->post("student_id");
        if (empty($studentId)) 
        {
            $data['action']  = "fail";
            $data['message'] = "please fill the student Id";
            success_response_after_post_get($data);
        }
        else
        {
            $data['studentDataArr'] =  $this->Api_model->get_student_detail($studentId);
            success_response_after_post_get($data);

        }  

    }
    
    
    function test_ios_push_notification_post(){
        $this->load->library("Ios_push_notification");
        $fromDeviceToken=trim($this->post('deviceToken'));
        $message=trim($this->post('message'));
        $this->ios_push_notification->to($fromDeviceToken);
        $this->ios_push_notification->message($message);
        if($this->ios_push_notification->send()=="1"){
            echo "notification send to APN Server";
        }else{
            echo "error arrise for sending push notition to APN Server.Plz check mail by jsahoo@du.sharadtechnologies.com.";
        }
    }
    
    function dashboard_data_post(){
        $this->load->model('Enquired_students_model');
        $this->load->model('Setting_model');
        $this->load->model('Student_model');
        $this->load->model('Teacher_model');
        $this->load->model('Parent_model');
        $this->load->model('Class_model');
        $this->load->model('Attendance_model');
        $this->load->model('Subject_model');
        $this->load->model('Exam_model');
        $this->load->model('Event_model');
        $this->load->model("Crud_model");
        $this->load->model("Notice_board_model");        
        $this->load->model('Mark_model');
        $this->load->model('Notification_model');
        $user_id = $this->post("user_id");
        $user_type = $this->post("user_type");
         if ($user_id == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide user id";
            success_response_after_post_get($data);
         }
        if ($user_type == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide user type";
            success_response_after_post_get($data);
         }
       if($user_id!='' && $user_type=='school_admin'){           
            $check1 = array('counselling' => '1');
        $query1 = $this->Enquired_students_model->get_data_by_cols('*', $check1, 'result_type');
        $data['tot_admission'] = count($query1);
        $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
        $data['count'] = $this->Student_model->get_count_curent_year($running_year);
        $data['tot_teacher'] = $this->Teacher_model->count_all();
        $data['tot_parent'] = $this->Parent_model->count_all();
        $sectionsArr = $this->Class_model->get_section_array(array('class_id' => 'all'));
        $all_section_student_array = array();
        $no_student = 0;
        foreach ($sectionsArr as $section) {
            $selected_section_student = $this->Student_model->getstudents_section_for_report('all', $running_year, $section['section_id']);
            $no_student = count($selected_section_student) + $no_student;
        }
        $data['tot_student'] = $no_student;

        $check2 = array('timestamp' => strtotime(date('Y-m-d')), 'status' => '1');
        $query2 = $this->Attendance_model->get_data_by_cols('*', $check2, 'result_type');
        $data['tot_student_present'] = count($query2);
        //Graphical Attendance Report - Added By Meera - July 1st 2017
        $data['currentMonth'] = date('F');

        $data['attendance_percentage'] = $this->Attendance_model->get_attendence_class_month($data['currentMonth']);
        //        echo '<pre>'; print_r($page_data['attendance_percentage']);die();

        $this->load->model("Holiday_model");
        $data['holidays'] = $this->Holiday_model->get_holiday_active_list();
        success_response_after_post_get($data);
        }
        elseif($user_id!='' && $user_type=='teacher'){
         // Dynamic Links
        $teacher_id = $this->session->userdata('teacher_id');
        $exams = $this->Exam_model->get_exam_routine(array('invigilator' => $teacher_id));
        $data['teacher_count'] = $this->Teacher_model->count_all();
        $data['parent_count'] = $this->Parent_model->count_all();
        $data['present_today'] = $this->Attendance_model->get_today_attendance();

        $events = array();
        $event = array();
        foreach ($exams as $exam) {
            $exam_name = $this->Exam_model->get_exam_name($exam['exam_id']);
            $subject_name = $this->Subject_model->get_subject_record(array('subject_id' => $exam['subject_id']), "name");
            $event['id'] = $exam['exam_routine_id'];
            $event['title'] = $exam_name . ":" . $exam['room_no'] . ":" . $subject_name;
            $event['start'] = $exam['start_datetime'];
            $time = new DateTime($exam['start_datetime']);
            $time->add(new DateInterval('PT' . $exam['duration'] . 'M'));
            $stamp = $time->format('Y-m-d H:i');
            $event['end'] = $stamp;
            $event['description'] = "Exam Duty Room No: " . $exam['room_no'];
            array_push($events, $event);
        }

        $notices = $this->Notice_board_model->get_data_by_cols('', array(), 'result_array');

        foreach ($notices as $notice) {
            $event['id'] = $notice['notice_id'];
            $event['title'] = $notice['notice_title'];
            $event['start'] = date('Y-m-d H:i:s', strtotime($notice['create_timestamp']));
            $event['end'] = date('Y-m-d H:i:s', strtotime($notice['create_timestamp']));
            $event['description'] = $notice['notice'];
            array_push($events, $event);
        }
        $data['notice'] = $event;
        $data['types'] = $this->Event_model->getEventTypes();
        success_response_after_post_get($data);
        }
        elseif($user_id!='' && $user_type=='parent'){ 
        $fee_structure = $this->Crud_model->get_record('fee_structure', $condition = array('fee_structure_status' => '1'), $field = "fee_structure_id");
        $data['fee_structure_id'] = 0;
        if (count($fee_structure)) {
            $data['fee_structure_id'] = $fee_structure['fee_structure_id'];
        }
        
        $parent_id = $user_id;
        $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
        $childrens_of_parent = $this->Student_model->parent_login_child_dashboard($parent_id, $running_year);
        $month = 12;
        $this->load->model('Attendance_model');
        $child_sub = array();
        $attend = array();
        
        $data['arrAllLinks'] = $this->session->userdata('arrAllLinks');
        //$childrens_of_parent=$children_of_parent;
//        pre($childrens_of_parent);die;
        if (!empty($childrens_of_parent)) {
            foreach ($childrens_of_parent as $value) {
                $year = explode('-', $running_year);
                $total_days = 0;
                for ($k = 1; $k <= $month; $k++) {
                    //echo $year[0];die;
                    $days = cal_days_in_month(CAL_GREGORIAN, $k, $year[0]);
                    $total_days = $days;
                    $count = 0;
                    for ($i = 1; $i <= $days; $i++) {
                        $timestamp = strtotime($i . '-' . $k . '-' . $year[0]);
                        $attendance = $this->Attendance_model->get_student_attendance_dashboard($value['section_id'], $value['class_id'], $running_year, $timestamp, $value['student_id']);
                        if (!empty($attendance)) {
                            $count++;
                        }
                    }
                    $attendance_percentege = $count / $total_days * 100;
                    $attend[$value['name']][] = round($attendance_percentege, 2);
                }
                $childrens_subject = $this->Subject_model->get_subject_dashboard($value['class_id'], $value['section_id'], $running_year);
                //pre($childrens_subject);
                $child_sub[]['subject'] = $childrens_subject;
            }
        }
        //die;
        //pre($child_sub);die;
        $data['subject'] = $child_sub;
        $data['student_details'] = $childrens_of_parent;
        $i = 0;
        $NewArray = array();
        foreach ($page_data['student_details'] as $row) {
            $NewArray[$i] = array_merge($row, $page_data['subject'][$i]);
            $i++;
        }
        $data['details'] = $NewArray;
        $data['attend_percentage'] = $attend;
        success_response_after_post_get($data);
        }
        elseif($user_id!='' && $user_type=='student'){
        $student_id = $user_id;
        $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
        $data['attendance'] = $this->Attendance_model->get_attendence_student_month($student_id);
        foreach ($page_data['attendance'] as $value) {
            $data['percentage'] = $value['percent'];
        }
        $data['student_details'] = $this->Student_model->get_student_details($student_id);
        $class_id = $this->Student_model->get_class_id_by_student($student_id);
        $cls_id = '';
        $sec_id = '';
        if (!empty($class_id)) {
            $cls_id = $class_id[0]['class_id'];
        }
        $section_id = $this->Student_model->get_section_id_by_student($student_id);
        if (!empty($section_id)) {
            $sec_id = $section_id[0]['section_id'];
        }
        $data['student_subject_details'] = $this->Subject_model->get_subject_dashboard($cls_id, $sec_id, $running_year);
        $data['notifications'] = $this->Notification_model->get_last_threedays_notifcations('push_notifications');
        success_response_after_post_get($data);  
        }
    }
}