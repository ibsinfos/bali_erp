<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_report extends CI_Controller{
    
    public $globalSettingsSMSDataArr = array();
    public $globalSettingsLocation = "";
    public $globalSettingsAppPackageName = "";
    public $globalSettingsRunningYear = "";
    public $globalSettingsSystemName = "";
    public $globalSettingsSystemEamil = "";
    public $globalSettingsSystemFCMServerrKey = "";
    public $globalSettingsTextAlign = "";
    public $globalSettingsActiveSmsService = "";
    public $globalSettingsSkinColour = "";
    public $globalSettingsSystemTitle = "";

    
    function __construct() {
        parent::__construct();
        $this->globalSettingsSMSDataArr = get_data_generic_fun('settings', 'description', array('condition_type' => 'in', 'condition_in_col' => 'type', 'condition_in_data' => 'location,app_package_name,running_year,system_name,system_email,fcm_server_key,system_title,text_align,skin_colour,active_sms_service'));
        $this->globalSettingsLocation = $this->globalSettingsSMSDataArr[7]->description;
        $this->globalSettingsAppPackageName = $this->globalSettingsSMSDataArr[8]->description;
        $this->globalSettingsRunningYear = $this->globalSettingsSMSDataArr[6]->description;
        $this->globalSettingsSystemTitle = $this->globalSettingsSMSDataArr[1]->description;
        $this->globalSettingsSystemName = $this->globalSettingsSMSDataArr[0]->description;
        $this->globalSettingsSystemEmail = $this->globalSettingsSMSDataArr[2]->description;
        $this->globalSettingsSystemFCMServerrKey = $this->globalSettingsSMSDataArr[9]->description;
        $this->globalSettingsSkinColour = $this->globalSettingsSMSDataArr[5]->description;
        $this->globalSettingsTextAlign = $this->globalSettingsSMSDataArr[4]->description;
        $this->globalSettingsActiveSmsService = $this->globalSettingsSMSDataArr[3]->description;
        $this->load->helper("graphical_report");
    }
    
    function index(){
        $this->over_view();
    }
    
    function over_view(){
        $page_data= $this->get_page_data_var();
        $year = explode('-', $this->globalSettingsRunningYear);
        $timeStamp=strtotime(date('j') . '-' . date('n') . '-' . $year[0]);
        //echo $timeStamp;die($timeStamp);
        $this->load->helper("graphical_report_helper");
        $this->load->helper("send_notifications_helper");
        
        $page_data['page_name'] = 'misc_report_overview';
        $page_data['page_title'] = get_phrase('misc_report_overview');
        $reportDataArr=array();
        $teacherData= get_data_generic_fun("teacher","*",array("isActive"=>"1"));
        $parentData= get_data_generic_fun("parent","*",array("isActive"=>"1"));
        $studentData= get_data_generic_fun("student","*",array("isActive"=>"1"));
        $busDriverData= get_data_generic_fun("bus_driver");
        $reportDataArr[]=array("Teacher",count($teacherData));
        $reportDataArr[]=array("Parent",count($parentData));
        $reportDataArr[]=array("Student",count($studentData));
        $reportDataArr[]=array("Bus Driver",count($busDriverData));
        //pre($reportDataArr);die;
        $dataProviderBarChart=get_data_provider_for_bar_chart($reportDataArr,"staff","current_numbers");
        //pre($dataProviderBarChart);die;
        $finaleReportDataArr=array("data_provider"=>$dataProviderBarChart,"category"=>"staff","data"=>"current_numbers");
//        pre($finaleReportDataArr);die;
        $overview_barchart=generate_bar_chart($finaleReportDataArr);
//        echo $overview_barchart;die;
        $page_data['overview_barchart']=$overview_barchart;
//        pre($page_data['overview_barchart']);die;
        /// student by class
        $this->load->model("Enroll_model");
        $rs= $this->Enroll_model->get_all_enroll_student_report();
        if(!empty($rs)){
            $reportPaiDataArr=array();
            foreach ($rs AS $k){
                $rawArr=array($k['name'],$k['TotalStudent']);
                $reportPaiDataArr[]=$rawArr;
            }
            $dataProviderPaiChart=get_data_provider_for_pai_chart($reportPaiDataArr,"Class","current_numbers");
            $finaleReportPaiDataArr=array("data_provider"=>$dataProviderPaiChart,"category"=>"Class","data"=>"current_numbers","paiChartTitle"=>'Total number of Students in each class(percent)');
            $page_data['overview_paichart']=generate_pai_chart($finaleReportPaiDataArr);
        }else{
            $page_data['overview_paichart']="";
        }
        
        ///present and absent data.
        $this->load->model("Attendance_model");
        $attendanceReport= $this->Attendance_model->get_present_absent_report($timeStamp);
        if(!empty($attendanceReport)){
            //pre($attendanceReport);die;
            $attendanceReport1=array();
            foreach($rs as $key=>$val){
                if($val['name']==""){
                    unset($rs[$key]);
                }
            }
            foreach($rs AS $key){ //pre($key);die;
                $tempArr=array();
                $existData=array();
                $existData=$this->search_class_data($attendanceReport, $key["class_id"], "class_id");
                if(!empty($existData)){
                    $tempArr=array();
                    $tempArr['baseDataValue']=$existData['name'];
                    $tempArr['baseRelatedData1Value']=$existData['total_student'];
                    $tempArr['baseRelatedData2Value']=$existData['present'];
                    $attendanceReport1[]=$tempArr;
                }else{
                    $tempArr=array();
                    $tempArr['baseDataValue']=$key['name'];
                    $tempArr['baseRelatedData1Value']=$key['TotalStudent'];
                    $tempArr['baseRelatedData2Value']=0;
                    $attendanceReport1[]=$tempArr;
                }
            }
            //pre($attendanceReport1);die;
            $dataProviderColumnLiner= get_data_provider_for_column_line_mix_linner_chart($attendanceReport1, "class", "total_student", "present");
            $finaleReportColumnLineMixDataArr=array("dataProvider"=>$dataProviderColumnLiner,"baseData"=>"Class","baseRelatedData1"=>"Total_student","baseRelatedData2"=>"Present","chartTitle"=>'Attendance Report for Today');
            $page_data['overview_column_line_mix_linner_chart']=get_column_line_mix_linner_chart_report($finaleReportColumnLineMixDataArr);
        }else{
            $page_data['overview_column_line_mix_linner_chart']="";
        }
        
        
        $this->load->view('backend/index', $page_data);
    }
    
    function student_information_misc_report($class_id=0,$student_running_year=""){
        $page_data= $this->get_page_data_var();
        $page_data['search_text'] = '';

        if($class_id==0 && $student_running_year==""){
            $class_id='all';
            
            $cYear=date('Y')+1;
            $student_running_year=($cYear-1).'-'. ($cYear);            
        }

        if(($class_id=='search')&&($student_running_year!='')){
            $page_data['search_text'] = $student_running_year;

            $class_id='all';
            
            $cYear=date('Y')+1;
            $student_running_year=($cYear-1).'-'. ($cYear);

            $page_data['page_title']            = get_phrase('student_misc_report') . " - " . get_phrase('class') . " : All";


        }else if($class_id==0 || $class_id=='all'){
            $page_data['page_title']            = get_phrase('student_misc_report') . " - " . get_phrase('class') . " : All";
        }else{
            $page_data['page_title']            = get_phrase('student_misc_report') . " - " . get_phrase('class') . " : " . $this->crud_model->get_class_name($class_id);
        }
        
        $this->load->model("Student_model");
        $class_array                        = array('class_id' => $class_id);
        $this->load->model("Class_model");
        $page_data['sections']              = $this->Class_model->get_section_array($class_array);      
        $page_data['page_name']             = 'student_information_misc_report';        
        $page_data['class_id']              = $class_id;
        if($student_running_year=="")
            $student_running_year           = $this->globalSettingsRunningYear;
        //$page_data['students']              =  $this->Student_model->getallstudents($class_id,$student_running_year);
        //$page_data['classes']               =  get_data_generic_fun('class','*',array(),'result_arr');

        $page_data['classes']               =  $this->Class_model->get_class_array();

       /* $i=0;
        $NewArray                           =   array();
        $studentss                           =   array();
        $NewArray = array();
        $all_section_student_array = array();
        foreach($page_data['sections'] as $section){
            $selected_section_student = $this->Student_model->getstudents_section_for_report($class_id, $student_running_year, $section['section_id']);
            $studentss[]['student_all'] = $selected_section_student;
            foreach ($selected_section_student as $key => $value) {
                $all_section_student_array[] = $value;
            }
            // pre($all_section_student_array);
            $NewArray[$i] = array_merge($section, $studentss[$i]);
            $i++; //die;
        }
        $page_data['students'] = $all_section_student_array;
        $page_data['all_records'] = $NewArray;*/
        $page_data['student_running_year'] = $student_running_year;

        $this->load->view('backend/index', $page_data);
    }
    
    function gender_report(){
        $page_data= $this->get_page_data_var();
        $this->load->model("Student_model");
        $page_data['page_name'] = 'student_gender_report';
        $page_data['page_title'] = get_phrase('section_wise_student_count/_gender_report<br>_as_on:'.date('d-M-Y'));
        $AllStudents = $this->Student_model->getstudents_by_gender();
        $AllSection = $this->Student_model->get_all_sections();
        //pre($AllSection);die;
        $SecResult=array();
        $new_stu=array();
        $data=array();
        if(count($AllSection)){            
            foreach($AllSection as $section){
                $SecResult[$section['class_id']][$section['section_name']] = $section['class_name'];
            }
        }
        
        if(count($AllStudents)){
            foreach($AllStudents as $row){
                $new_stu[$row['class_id']][$row['section_name']]['class_name']=$row['class_name'];
                $new_stu[$row['class_id']][$row['section_name']]['section_name']=$row['section_name'];
                $new_stu[$row['class_id']][$row['section_name']]['male_count']=$row['male_count'];
                $new_stu[$row['class_id']][$row['section_name']]['female_count']=$row['female_count'];
            }
        }
        
        if(count($SecResult)){                
            foreach($SecResult as $k => $row){
                foreach($row as $k2 => $sec){
                    if(!isset($new_stu[$k][$k2])){
                        $new_stu[$k][$k2]['class_name']=$sec;
                        $new_stu[$k][$k2]['section_name']=$k2;
                        $new_stu[$k][$k2]['male_count']=0;
                        $new_stu[$k][$k2]['female_count']=0;	
                    }
                }
            }
        }
        
        if(count($new_stu)){
            foreach($new_stu as $res){
                ksort($res);
                foreach($res as $result){
                    $data[]=$result;
                }
            }
        }
        
        $page_data['all_students'] = $data;
        //pre($page_data['all_students']);die;        
        $this->load->view('backend/index', $page_data);
    }
    
    function custom_report($id = null)
    {
        
        if(empty($id))
        {    
            $id = (isset($_POST['id'])) ? $_POST['id'] : '' ;
        }
        if(empty($id))
            return;
        $this->load->model("Dynamic_report_model");
        $this->load->model("Dynamic_field_model");
        $this->load->model("School_model");
        $report_row                 = $this->Dynamic_report_model->getReport($id);
        $page_data['page_title']    = get_phrase($report_row->report_caption);
        $arrFields                  = $this->Dynamic_report_model->getFields($report_row->id);
        $query                      = $report_row->query;
        $report_condition           = $report_row->condition;
        $arrCaption                 = array();
        $caption                    = $report_row->field_caption;
        $static_condition           = $report_row->static_condition;
        $group_by                   = $report_row->group_by;
        $order_by                   = $report_row->order_by;
        if(!empty($report_row->parent_id))
             $id  = $report_row->parent_id;
        
        
        if(!empty($caption))
        {
            $arrCaption = explode(",", $caption);
        }    
        if($_POST)
        {    
            
            $school_id  = ''; 
            $class_id   = '';
            $section_id = '';
            $rte = "";
            $where      = " 1 = 1 ";
            $report_row                 = $this->Dynamic_report_model->getReport($id);
            $page_data['page_title']    = get_phrase($report_row->report_caption);

            $query                      = $report_row->query;
            $report_condition           = $report_row->condition;
            $arrCaption                 = array();
            $caption                    = $report_row->field_caption;
            $static_condition           = $report_row->static_condition;
            $group_by                   = $report_row->group_by;
            $order_by                   = $report_row->order_by;
                if(!empty($caption))
                {
                    $arrCaption = explode(",", $caption);
                }
                $class_id = (!empty($_POST['class_id'])) ? trim($_POST['class_id']) : '';
                $section_id = (!empty($_POST['section_id'])) ? trim($_POST['section_id']) : '';
                $rte = (!empty($_POST['rte'])) ? trim($_POST['rte']) : '';
                $nationality = (!empty($_POST['nationality'])) ? trim($_POST['nationality']) : '';
                $session_id = (!empty($_POST['session_id'])) ? trim($_POST['session_id']) : '';
                $subcategory_id = (!empty($_POST['subcategory_id'])) ? trim($_POST['subcategory_id']) : '';
                $category_id = (!empty($_POST['category_id'])) ? trim($_POST['category_id']) : '';
                $exam_session_id = (!empty($_POST['exam_session_id'])) ? trim($_POST['exam_session_id']) : '';
                $dormitory_id = (!empty($_POST['dormitory_id'])) ? trim($_POST['dormitory_id']) : '';
            
            if(!empty($class_id))
            {    
                
                $where      .= " AND class.class_id = $class_id";
            }
             if(!empty($exam_session_id))
            {    
                
                $where      .= " AND exam.year = '$exam_session_id'";
            }
            if(!empty($section_id))
            {    
                
               
                $where      .= " AND section.section_id = $section_id";
            }
            if(!empty($category_id))
            {    
                
                $where      .= " AND book_category.category_id = $category_id";
            }
            if(!empty($subcategory_id))
            {    
                
                $where      .= " AND books.subcategory_id = $subcategory_id";
            }
            if(!empty($rte))
            {    
                $rte   = $_POST['rte'];
                $where      .= " AND student.rte = '$rte'";
            }
            if(!empty($_POST['session_id']))
            {
                $where      .= " AND enroll.year = '".$_POST['session_id']."'";
            }    
            if(!empty($nationality))
            {    
               
                $where      .= " AND student.nationality = '$nationality'";
            }
            if(!empty($dormitory_id))
            {    
                
                $where      .= " AND dormitory.dormitory_id = '$dormitory_id'";
            }
            if(!empty(($caste_id)))
            {    
                $where      .= " AND caste_category = '$caste_id'";
            }
            if(!empty($_POST['join_date_from']))
            {
                $join_date_from     = $_POST['join_date_from'];
                $join_date_to       = $_POST['join_date_to'];
                $where .="date_of_joining BETWEEN '$join_date_from' AND '$join_date_to'";
            }    
             if(!empty($_POST['from_join_date']))
            {
                $join_date_from     = $_POST['from_att_date'];
                $join_date_to       = $_POST['to_att_date'];
                $page_data['from_att_date'] = $_POST['from_att_date'];
                 $page_data['to_att_date'] = $_POST['to_att_date'];
                $join_date_from = date("Y-m-d", strtotime($join_date_from));
                
                $join_date_to = date("Y-m-d", strtotime($join_date_to));
                $where .=" and timestamp BETWEEN '$join_date_from' AND '$join_date_to'";
            }    
           // pre($_SESSION);
            if(!empty($static_condition))
            {
               if(strstr($static_condition, "?"))
                {
                    $static_condition = str_replace("?", $_SESSION['school_id'] , $static_condition);
                }
                if(strstr($static_condition, "run"))
                {
                    $static_condition = str_replace("run", "'".$this->globalSettingsRunningYear."'" , $static_condition);
                }
                
                $where .= " AND $static_condition";
            }
            
            $query = str_replace("str_replace", $where, $query);
            //echo $query;
            if(!empty($group_by))
            {
                $query .= $group_by;
            }
            if(!empty($order_by))
            {
                $query .= $order_by;
            }
         //echo "<br>here query is $query";    
            $result = $this->Dynamic_report_model->runDynamicQuery($query);
            $arrPost = array();
            foreach($_POST as $key => $value)
            {
                $arrPost[$key] = $value;
            }
            //$page_data['school_name'] =  $school_name;
            $page_data['arrPost'] =     $arrPost;
            $page_data['result'] =      $result;
            $page_data['arrCaption'] =  $arrCaption;
        }
        else
        {
            $where      = " 1 = 1 ";
            if(!empty($static_condition))
            {
                if(strstr($static_condition, "?"))
                {
                    $static_condition = str_replace("?", $_SESSION['school_id'] , $static_condition);
                }
                if(strstr($static_condition, "run"))
                {
                   
                    $static_condition = str_replace("run", "'".$this->globalSettingsRunningYear."'" , $static_condition);
                }
                
                $where .= " AND $static_condition";
            }
              
            $query = str_replace("str_replace", $where, $query);
           // echo "<br>here query is $query";
            if(!empty($group_by))
            {
                $query .= $group_by;
            }
            if(!empty($order_by))
            {
                $query .= $order_by;
            }
            //echo "<br>query is $query"; die;
            $result = $this->Dynamic_report_model->runDynamicQuery($query);
            foreach($_POST as $key => $value)
            {
                $page_data[$key] = $value;
            }
            $page_data["id"] = $id;
            $page_data['result'] =      $result;
            $page_data['arrCaption'] =  $arrCaption;
        }    
       if(!empty($id))
        {    
            
            $arrField = array();
            $arrDynamic = array();
            if(count($arrFields) >0){
                foreach($arrFields as $field)
                {
                   
                    $db_field                               = $field['db_field'];
                    $arrDbField[]                           = $db_field;
                    $arrFieldValue[$db_field]               = $field['field_type']."?".$field['field_values'];
                    $arrLabel[$db_field]                    = $field['label'];
                    $arrFieldValue[$db_field]               = $field['field_type']."?".$field['field_values'];
                    $arrAjaxEvent[$db_field]                = $field['ajax_event'];
                    if(strtolower($field['field_values']) == "query")
                      {
                          if(empty($field['field_where']))
                              $field['field_where'] = " 1 = 1 and school_id = ".$_SESSION['school_id'];
                          $result =  $this->Dynamic_field_model->getDynamicQuery($field['field_table'],$field['field_select'],$field['field_where']);
                          $field_split = explode("," ,$field['field_select']); 

                         foreach($result as $row)
                          {
                             if(isset($field_split[0]) && isset($field_split[1]))
                                 $arrDynamic[$db_field][$row[$field_split[0]]] = $row[$field_split[1]];
                          }    
                       }    
                  }
                        
                $page_data['arrFields'] =       $arrFields;
                $page_data['arrDynamic'] =      $arrDynamic;  
                $page_data['arrLabel'] =        $arrLabel;
                $page_data['arrFieldValue'] =   $arrFieldValue;
                $page_data['arrDbField'] =      $arrDbField;
                $page_data['arrAjaxEvent'] =    $arrAjaxEvent;
            }    

            $page_data['id']            =               $report_row->id;
            $page_data['page_title']    =               $report_row->report_caption;
            $page_data['caption']       =               $report_row->report_caption;
            $page_data['page_name']     =               'custom_report';
            $this->load->view('backend/index', $page_data);

        }
    }
    
    function student_custom_report(){
        $page_data= $this->get_page_data_var();
        $this->load->model("Student_model");
        $page_data['filter_keys']=array();
        $page_data['custom_report_data']=array();
        
        $AllFields= $this->Student_model->get_all_fields();
        $FlipFields = array_flip($AllFields); 
        
        $AllowedFields = array('student_code' => get_phrase('student_code'), 'name' => get_phrase('first_name'), 'mname' => get_phrase('middle_name'), 'lname' => get_phrase('last_name'), 'birthday' => get_phrase('date_of_birth'), 'sex' => get_phrase('gender'), 'religion' => get_phrase('religion'), 'caste_category' => get_phrase('category'), 'blood_group' => get_phrase('blood_group'), 'address' => get_phrase('address'), 'city' => get_phrase('city'), 'country' => get_phrase('country'), 'nationality' => get_phrase('nationality'), 'phone' => get_phrase('phone'), 'emergency_contact_number' => get_phrase('emergency_contact_number'), 'email' => get_phrase('email'), 'dormitory_room_number' => get_phrase('dormitory_room_number'), 'passport_no' => get_phrase('passport_no'), 'icard_no' => get_phrase('icard_no'), 'type' => get_phrase('icard_type'), 'place_of_birth' => get_phrase('place_of_birth'), 'previous_school' => get_phrase('previous_school'), 'course' => get_phrase('course'), 'location' => get_phrase('location'), 'performance' => get_phrase('performance'), 'transport' => get_phrase('transport'), 'medical_pblm' => get_phrase('medical_problem'), 'medical_pblm_reason' => get_phrase('medical_problem_reason'), 'family_type' => get_phrase('family_type'), 'interest_one' => get_phrase('interest_one'), 'interest_two' => get_phrase('interest_two'), 'interest_three' => get_phrase('interest_three'), 'mother_tounge' => get_phrase('mother_tounge'), 'passcode' => get_phrase('passcode'));
        
        $Fields = array_intersect_key($FlipFields, $AllowedFields);
        //pre($Fields);die;
        $ResultFields = array_replace($Fields, $AllowedFields);
        //pre($ResultFields);die;
        $page_data['filter_fields'] = $ResultFields;
        $page_data['page_name'] = 'student_custom_report';
        $page_data['page_title'] = get_phrase('student_custom_report');
        
        if($this->input->post()){
            $filter = $this->input->post();
            if(count($filter)){        
                $page_data['custom_report_data'] = $this->Student_model->get_custom_report_data($filter);
                $page_data['filter_keys']=array_keys($filter);
            }
            //pre($filter);die;
        }
        $this->load->view('backend/index', $page_data);
    }
    
    function student_custom_report_submit(){
        $page_data= $this->get_page_data_var();
        $filter = $this->input->post();
        $this->load->model("Student_model");
        $page_data['filter_fields']=array();
        $page_data['filter_keys']=array();
        $page_data['custom_report_data']=array();
        if(count($filter)){        
            $page_data['custom_report_data'] = $this->Student_model->get_custom_report_data($filter);
            $page_data['filter_keys']=array_keys($filter);
        }        
        //pre($page_data['filter_keys']);die;
        
        $page_data['page_name'] = 'student_custom_report';
        $page_data['page_title'] = get_phrase('student_custom_report');
        $this->load->view('backend/index', $page_data);
    }
    
    
    
    
    function get_all_by_year($running_year=""){
        $page_data= $this->get_page_data_var();
        if($running_year=="")
            $running_year= $this->globalSettingsRunningYear;
        
        $yearArr= explode('-', $running_year);
        
        $this->load->model("Parent_model");
        $rs= $this->Parent_model->get_all_by_year($yearArr[0],$yearArr[1]);
        $page_data['page_title']       =  get_phrase('all_parents');
        $page_data['page_name']        = 'parent_misc_report';
        $page_data["parents"]=$rs;
	
		$page_data["running_yr"]=$running_year;
		
		$this->load->view('backend/index', $page_data);
    }
    
    /*function parent_misc_report($running_year=""){
        if($running_year=="")
            $running_year= $this->globalSettingsRunningYear;
        
        $yearArr= explode('-', $running_year);
        
        $this->load->model("Parent_model");
        $rs= $this->Parent_model->get_all_by_year($yearArr[0],$yearArr[1]);
        $page_data['page_title']       =  get_phrase('all_parents');
        $page_data['page_name']        = 'parent_misc_report';
        $page_data["parents"]=$rs;
        
		$page_data["running_yr"]=$running_year;
		
		$this->load->view('backend/index', $page_data);
    
     * }*/
    
    function parent_misc_report($class_id=0,$student_running_year=""){
        $page_data= $this->get_page_data_var();
        $this->load->model("Parent_model");
        $class_array = array('class_id' => $class_id);
        $this->load->model("Class_model");
        $page_data['sections']              = $this->Class_model->get_section_array($class_array);      
        $page_data['page_name']             = 'parent_misc_report';
        $page_data['page_title']            = get_phrase('parent_misc_report') . " - " . get_phrase('class') . " : " . $this->crud_model->get_class_name($class_id);
        $page_data['class_id']              = $class_id;
        if($student_running_year=="")
            $student_running_year           = $this->globalSettingsRunningYear;
        $page_data['parents']              =  $this->Parent_model->getallparents($class_id,$student_running_year);
        $page_data['classes']               =  get_data_generic_fun('class','*',array(),'result_arr');
        $i=0;
        $NewArray                           =   array();
        $parentss                           =   array();
        foreach($page_data['sections'] as $section){
            $parentss[]['parent_all']      = $this->Parent_model->getstudents_section($class_id,$student_running_year,$section['section_id']);
            $NewArray[$i]                     = array_merge($section,$parentss[$i]);
            $i++;
        }
        $page_data['all_records'] = $NewArray;
        $page_data['student_running_year'] = $student_running_year;

        $this->load->view('backend/index', $page_data);
    }
    
    
    function teacher_misc_report($class_id=0,$subject_id=0){
        $page_data= $this->get_page_data_var();
        if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
        $techerArr=array();
        $this->load->model("Teacher_model");
        if($subject_id>0 && $class_id>0){
            $techerArr= $this->Teacher_model->get_teacher_by_subject_class($subject_id,$class_id);
        }else if($class_id>0){
            $techerArr= $this->Teacher_model->get_teacher_by_class_for_report($class_id);
        }
        
        $page_data['page_title']       =  get_phrase('all_teachers');
        $page_data['page_name']        = 'teacher_misc_report';
        $page_data['class_arr']        = get_data_generic_fun("class","*");
        if($class_id>0){
            $page_data['subject_arr']        = get_data_generic_fun("subject","*",array('class_id'=>$class_id));
        }else{
            $page_data['subject_arr']        = array();
        }
        $page_data["teachers"]=$techerArr;
        $page_data["class_id"]=$class_id;
        $page_data["subject_id"]=$subject_id;
        $this->load->view('backend/index', $page_data);
    }
    
    function testing(){
        $page_data= $this->get_page_data_var();
        $page_data['page_title']       =  get_phrase('all_teachers');
        $page_data['page_name']        = 'testing';
        $this->load->view('backend/index', $page_data);
    }


    /**
     * 
     * @param type $dataArr
     * @param type $id
     * @param type $seach_column
     */
    function search_class_data($dataArr,$val,$seach_column){
        $page_data= $this->get_page_data_var();
        foreach($dataArr As $k){
            if($k[$seach_column]==$val){
                return $k;
            }
        }
        return  FALSE;
    }
    
    function selected_student_profile_details($student_id){
        $page_data= $this->get_page_data_var();
        $this->load->model("Student_model");
        $rs=$this->Student_model->get_student_details($student_id);
       // pre($rs); die();
        $page_data['page_title']       =  get_phrase('selected_student_profile_details');
        $page_data['page_name']        = 'selected_student_profile_details';
        $page_data["student_details"]=$rs;
        $this->load->view('backend/index', $page_data);
         
    }
    
    function student_misc_report_advance_filter(){
        $page_data= $this->get_page_data_var();
        $page_data['page_title']       =  get_phrase('student_misc_report_advance_filter');
        $page_data['page_name']        = 'student_misc_report_advance_filter';
         $page_data['student_all']        = array();
        $this->load->view('backend/index', $page_data);
       
    }
    
    function parent_misc_report_advance_filter(){
        $page_data= $this->get_page_data_var();
        $page_data['page_title']       =  get_phrase('parent_misc_report_advance_filter');
        $page_data['page_name']        = 'parent_misc_report_advance_filter';
         $page_data['parent_all']        = array();
        $this->load->view('backend/index', $page_data);
       
    }
    
    /**
     * 
     */
    function student_misc_report_advance_filter_submit(){
        $page_data= $this->get_page_data_var();
        //pre($_POST);
        //part//
        // SEECT name,addrss FROM student WHERE
        $DOB= $this->input->post("DOB",TRUE);
         $where="";
        if($DOB!=""){
            $DOB=date("Y-m-d", strtotime($DOB));
            $where=" WHERE DATE(s.birthday)='".$DOB."'";
        }
        $guardian= $this->input->post("guardian",TRUE);
        //if()
        $card_no= trim($this->input->post("card_no",TRUE));
        if($card_no!=""){
           if($where!=""){
               $where.=" AND (s.`card_id`='".$card_no."' OR s.`card_id`='".$card_no."')";
           } else{
               $where.=" WHERE (s.`card_id`='".$card_no."' OR s.`card_id`='".$card_no."')";
           }
        }
        $admission_date= $this->input->post("admission_date",TRUE);
        if($admission_date!=""){
            $admission_date=date("Y-m-d", strtotime($admission_date));
            if($where!=""){
                $where.=" AND DATE(e.date_added)='".$admission_date."'";
            }else{
                $where.=" WHERE DATE(e.date_added)='".$admission_date."'";
            }
        }
        $city= $this->input->post("city",TRUE);
        if($city!=""){
            if($where!=""){
                $where.=" AND s.`city`='".$city."'";
            }else{
                $where.=" WHERE s.`city`='".$city."'";
            }
        }
        
        $category= $this->input->post("category",TRUE);
        if($category!=""){
            if($where!=""){
                $where.=" AND s.`caste_category`='".$category."'";
            }else{
                $where.=" WHERE s.`caste_category`='".$category."'";
            }
        }
        
        /*$blood_group= $this->input->post("blood_group",TRUE);
        if($blood_group!=""){
            if($where!=""){
                $where.=" AND s.`blood_group`='".$blood_group."'";
            }else{
                $where.=" WHERE s.`blood_group`='".$blood_group."'";
            }
        }*/
        $cell_phone= $this->input->post("cell_phone",TRUE);
        if($cell_phone!=""){
            if($where!=""){
                $where.=" AND s.`phone`='".$cell_phone."'";
            }else{
                $where.=" WHERE s.`phone`='".$cell_phone."'";
            }
        }
        /*$zip= $this->input->post("zip",TRUE);
        if($zip!=""){
            if($where!=""){
                $where.=" AND s.`cell_phone`='".$zip."'"
            }else{
                $where.=" WHERE s.`cell_phone`='".$zip."'"
            }
        }*/
        $religion= $this->input->post("religion",TRUE);
        if($religion!=""){
            if($where!=""){
                $where.=" AND s.`religion`='".$religion."'";
            }else{
                $where.=" WHERE s.`religion`='".$religion."'";
            }
        }
        $father_name= $this->input->post("father_name",TRUE);
        if($father_name!=""){
            if($where!=""){
                $where.=" AND p.`father_name` LIKE('%".$father_name."%')";
            }else{
                $where.=" WHERE p.`father_name` LIKE('%".$father_name."%')";
            }
        }
        $gender= $this->input->post("sex",TRUE);
        if($gender!=""){
            if($where!=""){
                $where.=" AND s.`sex`='".$gender."'";
            }else{
                $where.=" WHERE s.`sex`='".$gender."'";
            }
        }
        $first_name= $this->input->post("first_name",TRUE);
        if($first_name!=""){
            if($where!=""){
                $where.=" AND s.`name` LIKE('%".$first_name."%')";
            }else{
                $where.=" WHERE s.`name` LIKE('%".$first_name."%')";
            }
        }
        $last_name= $this->input->post("last_name",TRUE);
        if($last_name!=""){
            if($where!=""){
                $where.=" AND s.`lname` LIKE('%".$last_name."%')";
            }else{
                $where.=" WHERE s.`lname` LIKE('%".$last_name."%')";
            }
        }
        $passport= $this->input->post("passport",TRUE);
        
        if($passport!=""){
            if($where!=""){
                $where.=" AND s.`passport_no` LIKE('%".$passport."%')";
            }else{
                $where.=" WHERE s.`passport_no` LIKE('%".$passport."%')";
            }
        }

        $status = '1';

        $where.=" AND s.`student_status` = '".$status."' AND s.`isActive` = '".$status."'";
        
        $this->load->model("Student_model");
        $dataArr=array();
        if($where!=""):
            $dataArr=$this->Student_model->student_list_with_advance_filter($where); 
        endif;
        
        $page_data['page_title']       =  get_phrase('student_misc_report_advance_filter');
        $page_data['page_name']        = 'student_misc_report_advance_filter';
        //pre("pp");pre($dataArr);die;
        $page_data['student_all']        = $dataArr;
        $this->load->view('backend/index', $page_data);
    }

    
    function parent_misc_report_advance_filter_submit(){
        $page_data= $this->get_page_data_var();
        $where="";        
        $first_name= $this->input->post("first_name",TRUE);
        if($first_name!=""){
            $where.=" WHERE p.`father_name`LIKE('%".$first_name."%')";
        }
        
        $middle_name= $this->input->post("middle_name",TRUE);
        if($middle_name!=""){
            if($where!=""){
                $where.=" AND p.`father_mname` LIKE('%".$middle_name."%')";
            }else{
                $where.=" WHERE p.`father_mname`LIKE('%".$middle_name."%')";
            }
        }
        
        $last_name= $this->input->post("last_name",TRUE);
        if($last_name!=""){
            if($where!=""){
                $where.=" AND p.`father_lname` LIKE('%".$last_name."%')";
            }else{
                $where.=" WHERE p.`father_lname`LIKE('%".$last_name."%')";
            }
        }
        
        $profession= $this->input->post("profession",TRUE);
        if($profession!=""){
            if($where!=""){
                $where.=" AND p.`father_profession` LIKE('%".$profession."%')";
            }else{
                $where.=" WHERE p.`father_profession`LIKE('%".$profession."%')";
            }
        }       
            
        $gender= $this->input->post("sex",TRUE);
        if($gender!=""){
            if($where!=""){
                $where.=" AND p.`gender`='".$gender."'";
            }else{
                $where.=" WHERE p.`gender`='".$gender."'";
            }
        }         
        
        $email= $this->input->post("email",TRUE);
        if($email!=""){
            if($where!=""){
                $where.=" AND p.`email`='".$email."'";
            }else{
                $where.=" WHERE p.`email`='".$email."'";
            }
        }
        
        $cell_phone= $this->input->post("cell_phone",TRUE);
        if($cell_phone!=""){
            if($where!=""){
                $where.=" AND p.`cell_phone`='".$cell_phone."'";
            }else{
                $where.=" WHERE p.`cell_phone`='".$cell_phone."'";
            }
        }
        
        $city= $this->input->post("city",TRUE);
        if($city!=""){
            if($where!=""){
                $where.=" AND p.`city`='".$city."'";
            }else{
                $where.=" WHERE p.`city`='".$city."'";
            }
        }
        
        $state= trim($this->input->post("state",TRUE));
        if($state!=""){
           if($where!=""){
                $where.=" AND p.`state`='".$state."'";
            }else{
                $where.=" WHERE p.`state`='".$state."'";
            }
        }       
        
        $country= $this->input->post("country",TRUE);
        if($country!=""){
            if($where!=""){
                $where.=" AND p.`country`='".$country."'";
            }else{
                $where.=" WHERE p.`country`='".$country."'";
            }
        }

        $enroll_code= $this->input->post("enroll_code",TRUE);
        if($enroll_code!=""){
            if($where!=""){
                $where.=" AND e.`enroll_code`='".$enroll_code."'";
            }else{
                $where.=" WHERE e.`enroll_code`='".$enroll_code."'";
            }
        }
        
        $this->load->model("Parent_model");
        $dataArr=array();
        if($where!=""):
            $dataArr=$this->Parent_model->parent_list_with_advance_filter($where); 
        endif;
        
        $page_data['page_title']       =  get_phrase('parent_misc_report_advance_filter');
        $page_data['page_name']        = 'parent_misc_report_advance_filter';
        //pre("pp");pre($dataArr);die;
        $page_data['parent_all']        = $dataArr;
        
        $page_data['search_condition'] = $this->input->post();
        
        $this->load->view('backend/index', $page_data);
    }


    
    /**
     * 
     */
    
    function misc_report_library(){
        $page_data= $this->get_page_data_var();
        error_reporting(E_ALL);
        @ini_set("display_errors", 1);
        $year = explode('-', $this->globalSettingsRunningYear);
        $this->load->helper("graphical_report_helper");
        //Start of Section(total_book): For calculation Total number of Books.
        $table_total_book = 'book_info';
        $where_total_book['where'] = array('deleted'=>'0');
        $info_total_book = get_data_generic_fun($table_total_book,'*', array('deleted'=>'0'));
        $reportDataArr[] = array('num_of_book',count($info_total_book));

           //End of Section(total_book).

           //Start of Section(circulation): For calculation Total number of Issued Books.

        $table_circulation = 'circulation';
        $info_ciculation = get_data_generic_fun($table_circulation);
        $num_issue_book = count($info_ciculation);

             //echo "num_issue_book: ".$num_issue_book."<br/>";die;
        $reportDataArr[] = array('num_issue_book',$num_issue_book);

           //End of Section(circulation).

           //Start of Section(num_member): For calculation Total number of Members.
        $table_num_member = 'member';
        $where_num_member = array('status'=>'1');
        $info_num_member = get_data_generic_fun($table_num_member,'*', $where_num_member);
        $num_member = count($info_num_member);
            // echo "num_member: ".$num_member."<br/>";
        $reportDataArr[]=array("num_member",$num_member);


           //End of Section(num_member).

           //Start of Section(add_book today).

        $table_add_book_today = 'book_info';
        $today_date = date('Y-m-d');
        $where_add_book_today['where'] = array('deleted'=>'0',"Date_Format(add_date,'%Y-%m-%d')"=>$today_date);
        $info_add_book_today = get_data_generic_fun($table_add_book_today,'*' ,array('deleted'=>'0',"Date_Format(add_date,'%Y-%m-%d')"=>$today_date));
        $num_add_book_today = count($info_add_book_today);
            // echo "num_add_book_today: ".$num_add_book_today."<br/>";
        $reportDataArr[]= array('num_add_book_today',$num_add_book_today);
           //End of Section(add_book today).



        //Start Section(today_issue & today_return).
        $table_today_issue_return = 'circulation';
        $where_today_issue['where'] = array('issue_date'=>$today_date);
        $where_today_return['where'] = array('return_date'=>$today_date);

        $info_today_issue = get_data_generic_fun($table_today_issue_return,'*', array('issue_date'=>$today_date));
        $info_today_return = get_data_generic_fun($table_today_issue_return, '*',array('return_date'=>$today_date));

        $num_today_issue_book = count($info_today_issue);
            // echo "num_today_issue_book: ".$num_today_issue_book."<br/>";
        $reportDataArr[] = array('num_today_issue_book',$num_today_issue_book);


        $num_today_return_book = count($info_today_return);
            // echo "num_today_return_book: ".$num_today_return_book."<br/>";
        $reportDataArr[] = array('num_today_return_book',$num_today_return_book);
           //End Section(today_issue & today_return).

           //Start of Section(today_add_member).
        $table_today_add_member = 'member';
        $where_today_add_member['where'] = array('add_date'=>$today_date);
        $info_today_add_member = get_data_generic_fun($table_today_add_member,'*', array('add_date'=>$today_date));
        $num_today_add_member = count($info_today_add_member);
            // echo "num_today_add_member: ".$num_today_add_member."<br/>";
        $reportDataArr[] = array('num_today_add_member',$num_today_add_member);
           //End of Section(today_add_member).

            //Start of Section(add_book this_month).

        $table_add_book_this_month = 'book_info';
        $first_day_this_month = date('Y-m-01');
        $num_days_this_month = date('t');
        $last_day_this_month  = date("Y-m-$num_days_this_month");
        $where_add_book_this_month['where'] = array('deleted'=>'0',"Date_Format(add_date,'%Y-%m-%d') >="=>$first_day_this_month,"Date_Format(add_date,'%Y-%m-%d') <= "=>$last_day_this_month);
        $info_add_book_this_month = get_data_generic_fun($table_add_book_this_month, '*',array('deleted'=>'0',"Date_Format(add_date,'%Y-%m-%d') >="=>$first_day_this_month,"Date_Format(add_date,'%Y-%m-%d') <= "=>$last_day_this_month));
        $num_add_book_this_month = count($info_add_book_this_month);
            //echo "num_add_book_this_month: ".$num_add_book_this_month."<br/>";die;
        $reportDataArr[] = array('num_add_book_this_month',$num_add_book_this_month);

           //End of Section(add_book this_month).

           //Start of Section(issue_book_this_month).

        $table_issue_return_book_this_month = 'circulation';
        $first_day_this_month = date('Y-m-01');
        $num_days_this_month = date('t');
        $last_day_this_month  = date("Y-m-$num_days_this_month");

        $where_issue_book_this_month['where'] = array("issue_date >="=>$first_day_this_month,"issue_date <= "=>$last_day_this_month);
        $info_issue_book_this_month = get_data_generic_fun($table_issue_return_book_this_month,'*', array("issue_date >="=>$first_day_this_month,"issue_date <= "=>$last_day_this_month));
        $num_issue_book_this_month = count($info_issue_book_this_month);
             //echo "num_issue_book_this_month: ".$num_issue_book_this_month."<br/>";die;
        $reportDataArr[] = array('num_issue_book_this_month',$num_issue_book_this_month);

        $where_return_book_this_month['where'] = array("return_date >="=>$first_day_this_month,"return_date <= "=>$last_day_this_month,'is_returned'=>'1');
        $info_return_book_this_month = get_data_generic_fun($table_issue_return_book_this_month, '*',array("return_date >="=>$first_day_this_month,"return_date <= "=>$last_day_this_month,'is_returned'=>'1'));
        $num_return_book_this_month = count($info_return_book_this_month);
             //echo "num_return_book_this_month: ".$num_return_book_this_month."<br/>";die;
        $reportDataArr[] = array('num_return_book_this_month',$num_return_book_this_month);

           //Start of Section(issue_book_this_month).

           //Start of Section(add_member_this_month).

        $table_add_member_this_month = 'member';
        $first_day_this_month = date('Y-m-01');
        $num_days_this_month = date('t');
        $last_day_this_month  = date("Y-m-$num_days_this_month");
        $where_add_member_this_month = array('add_date >='=>$first_day_this_month,'add_date <='=>$last_day_this_month);
        $info_add_member_this_month = get_data_generic_fun($table_add_member_this_month,'*', $where_add_member_this_month);
        $num_add_member_this_month = count($info_add_member_this_month);
             //echo "num_add_member_this_month: ".$num_add_member_this_month."<br/>";die;
        $reportDataArr[] = array('num_add_member_this_month',$num_add_member_this_month);

        $dataProviderBarChart=get_data_provider_for_bar_chart($reportDataArr,"books","current_numbers");
        
        $finaleReportDataArr=array("data_provider"=>$dataProviderBarChart,"category"=>"books","data"=>"current_numbers");
        $overview_barchart=generate_bar_chart($finaleReportDataArr);
        $page_data['overview_barchart']=$overview_barchart;
        

            // bar chart
        $year = date('Y')-1;
        $last_issue_year = date("$year-m-d");

        $where['where'] = array('issue_date >=' => $last_issue_year);
        $order_by = "issue_date ASC";
        $results = get_data_generic_fun('circulation', '*',array('issue_date >=' => $last_issue_year), 'arr',  array('issue_date'=>'ASC'));

        $issued = 0;
        $returned = 0;

        $month_year_array=array();

        foreach ($results as $result) {
            $issue_month = date('M', strtotime($result['issue_date']));
            $issue_year = date('Y', strtotime($result['issue_date']));

            $return_month = date('M', strtotime($result['return_date']));
            $return_year = date('Y', strtotime($result['return_date']));

            if (isset($issue[$issue_month][$issue_year])) {
                $issue[$issue_month][$issue_year] += 1;
            } else {
                $issue[$issue_month][$issue_year]=1;
            }



            if ($result['is_returned']==1) {
                if (isset($return[$return_month][$return_year])) {
                    $return[$return_month][$return_year] += 1;
                } else {
                    $return[$return_month][$return_year]=1;
                }

                if (isset($issue[$return_month][$return_year])) {
                    $issue[$return_month][$return_year] += 0;
                } else {
                    $issue[$return_month][$return_year]=0;
                }
            } else {
                if (isset($return[$return_month][$return_year])) {
                    $return[$return_month][$return_year] += 0;
                } else {
                    $return[$return_month][$return_year]=0;
                }
            }
        }

        $chart_array=array();

        $cur_year=date('Y');
        $cur_month=date('m');
        $cur_month=(int)$cur_month;
        $months_name = array(1=>'Jan', 2=>'Feb', 3=>'Mar', 4=>'Apr', 5=>'May', 6=>'Jun', 7=>'Jul', 8=>'Aug', 9=>'Sep', 10=>'Oct', 11=>'Nov', 12=>'Dec');
        $months_name_full = array(1=>'January', 2=>'February', 3=>'March', 4=>'April', 5=>'May', 6=>'June', 7=>'July', 8=>'August', 9=>'September', 10=>'October', 11=>'November', 12=>'December');

        for ($i=0;$i<=11;$i++) {
            $m=$months_name[$cur_month];
            $m_dis=$this->lang->line("cal_".strtolower($months_name_full[$cur_month]));
            //$chart_array[$i]['year']=$m_dis."-".$cur_year;
            $chart_array[$i]['year']=$cur_year;

            if (isset($issue[$m][$cur_year])) {
                $chart_array[$i]['total_issue']=$issue[$m][$cur_year];
            } else {
                $chart_array[$i]['total_issue']=0;
            }
            if (isset($return[$m][$cur_year])) {
                $chart_array[$i]['total_return']=$return[$m][$cur_year];
            } else {
                $chart_array[$i]['total_return']=0;
            }

            $cur_month=$cur_month-1;
            if ($cur_month==0) {
                $cur_month=12;
                $cur_year=$cur_year-1;
            }
        }

        $chart_array=array_reverse($chart_array);


            //data for circle chart
        $totalIssuedBooksArr=get_data_generic_fun('circulation','count(id) as total_issued');
        $reportPaiDataArr[] = array('total_issued',$totalIssuedBooksArr[0]->total_issued);
        $notReturnedArr=get_data_generic_fun('circulation', 'count(id) as not_returned',array('is_expired'=>'1'));
        $reportPaiDataArr[] = array('not_returned',$notReturnedArr[0]->not_returned);
        //pre($reportPaiDataArr);
        $dataProviderPaiChart=get_data_provider_for_pai_chart($reportPaiDataArr,"Books","current_numbers");
        //pre($dataProviderBarChart);
        $finaleReportPaiDataArr=array("data_provider"=>$dataProviderPaiChart,"category"=>"Books","data"=>"current_numbers","paiChartTitle"=>'Books Status in percentage');
        //pre($finaleReportPaiDataArr); 
        $overview_paichart=generate_pai_chart($finaleReportPaiDataArr);
        //pre($overview_paichart);die;
        $page_data['overview_paichart']=$overview_paichart;
        
        $page_data['page_title']       =  get_phrase('library_misc_report');
        $page_data['page_name']        = 'library_misc_report';
        $page_data['allBooks']        = array();
        $this->load->view('backend/index', $page_data);
        
    }
    
    function under_construction(){
        $page_data= $this->get_page_data_var();
        $page_data['page_title']  =  get_phrase('under_construction');
        $page_data['page_name']    = 'under_construction';
        $this->load->view('backend/index', $page_data);
    }
    
    public function studentsfee_report() {
        $page_data= $this->get_page_data_var();
        $this->load->model('Student_model');
        $this->load->model('Invoice_model');
        $all_student_fee        =   $this->Invoice_model->get_all_student_finance_transaction();
        $total_income           =   0;
        $total_invoice          =   0;
        $student_status_array   =   array();
        foreach( $all_student_fee as $key=>$val ) {
            $stud_id        =   ( $val['payerid'] != 0 ?$val['payerid']:$val['payeeid'] );
            if($val['type'] == 'Income') {
                if(isset($student_status_array[$stud_id]['income'])) {
                    $student_status_array[$stud_id]['income']           =   $student_status_array[$stud_id]['income']+$val['amount'];
                } else {
                    $student_status_array[$stud_id]['income']           =   $val['amount'];
                }
                $total_income       =   $total_income+$val['amount'];
            } else {
                if(isset($student_status_array[$stud_id]['invoice'])) {
                    $student_status_array[$stud_id]['invoice']           =   $student_status_array[$stud_id]['invoice']+$val['amount'];
                } else {
                    $student_status_array[$stud_id]['invoice']           =   $val['amount'];
                }
                $total_invoice      =   $total_invoice+$val['amount'];
            }
            
            $stud_det       =   $this->Student_model->get_data_generic_fun();
            $stud_det       =   array_shift($stud_det);
            $student_fee[$key]              =   $val; 
            $student_fee[$key]['name']      =   $stud_det->name;   
            
        }
        
        pre('Total Income:'.$total_income.'<br>Total Invoice: '.$total_invoice);
        pre($student_status_array);
        pre($student_fee);die;
        $page_data['student_transaction']       =   $all_student_fee;
        $page_data['total_notif_num']           =   $this->get_no_of_notication();
        $page_data['page_title']                =   get_phrase('student_fee_report');
        $page_data['page_name']                 =   'student_fee_report';
        
    }

    function dynamic_report_name($param1="", $param2="")
    {
        $page_data = $this->get_page_data_var();
        $this->load->model("Dynamic_report_model");
        if($param1 == 'create'){
        $data['report_caption']=$this->input->post("name");
        $data['report_table']=$this->input->post("report_table");       
        $this->Dynamic_report_model->add($data);
        $this->session->set_flashdata("flash_message", get_phrase("data_added_successfully"));
            redirect(base_url().'index.php?admin_report/dynamic_report_name', 'refresh');
        }
        if($param1=='update'){      
           $data['report_caption']  = $this->input->post('report_name'); 
            $data['report_table']  = $this->input->post('report_table'); 
            if($param2!=''){
            $this->Dynamic_report_model->update_report_name($data, array("id" => $param2));
            $this->session->set_flashdata("flash_message", get_phrase("data_updated"));
            redirect(base_url().'index.php?admin_report/dynamic_report_name', 'refresh');
            }
        }
        if($param1=='delete'){       
            $this->Dynamic_report_model->delete_report_name($param2);
            $this->session->set_flashdata("flash_message", get_phrase("data_deleted"));
            redirect(base_url().'index.php?admin_report/dynamic_report_name', 'refresh');
        }
        $page_data['dynamic_report_name']=$this->Dynamic_report_model->get_group_array();
        $page_data['page_name']         =   'dynamic_name';
        $page_data['page_title']        =   get_phrase('dynamic_name');
        $this->load->view('backend/index', $page_data);
    }
    
    function dynamic_report($param1="", $param2="")
    { 
        $page_data = $this->get_page_data_var();
        $this->load->model("Dynamic_report_model");
         if($param1!=''){
            $page_data['report_name_id'] = $param1;
        }else{
            $page_data['report_name_id'] = '1';
            $param1 = '1';
        }
        $dynamic_report_list = $this->Dynamic_report_model->get_report($param1);
        $data = array();

         

  
 
         
            if($param1 == 'create'){ 
   
            $arrCheck           = array();
            $arrCaption         = array();
            $arrCondition       = array();
            $arrFieldValue      = array();
            $arrType            = array();
            $arrComplexFields   = array();
            
            
            
             $report_name         = $this->input->post('report_name');
             $arrCheck          = $this->input->post('check');
             $arrCaption        = $this->input->post('caption');    
             $arrCondition      = $this->input->post('condtion');
             $arrFieldValue     = $this->input->post('field_value');
             $arrType           = $this->input->post('type');
              
             $this->load->model("Dynamic_report_model");
             
             $arrField = $this->input->post('field');
             $arrCaption = $this->input->post('caption');
             $arrCondition = $this->input->post('condition');
             $arrFieldValue = $this->input->post('field_value');
             $arrAll = $this->Dynamic_report_model->getJoinField($arrField);
             pre($arrAll);
            
             $arrJoinTable =    $arrAll['arrJoinTable'];
             $arrJoinField =    $arrAll['arrJoinField'];
             $arrJoinType =     $arrAll['arrJoinType'];
             $arrComplexFields = $arrAll['arrComplexFields'];
             
             $captionString = "";
             $queryString = "Select " ;
             $condtionString = " where 1 = 1";
             $joinString  = "";
             
             $arrJoinTable = array_unique($arrJoinTable); 
             pre($arrCondition);
             foreach($arrField as $key => $value)
             {
                 if(in_array($key, array_keys($arrComplexFields)))
                 {       
                     $complex_key  =  str_replace("'", "", $arrComplexFields[$key]);    
                     $queryString.= " $complex_key,";
                 }
                 else
                        $queryString .= " $key,";
                 if(in_array($key, array_keys($arrCaption)))
                 {
                     $captionString .= "$arrCaption[$key] ,";
                 }
                 if(in_array($key, array_keys($arrCondition)))
                 {
                    
                     if(!empty($arrCondition[$key]) && !empty($arrFieldValue[$key]))
                        $condtionString .= " and $key  = '".$arrFieldValue[$key]."'";
                 }
                 if(in_array($key, array_keys($arrJoinTable)))
                 {
                     if(!empty($arrJoinTable[$key]))
                     {    
                         if(strstr($arrJoinTable[$key], ","))
                         {
                            $arrType = explode(",", $arrJoinType[$key]);
                            $arrTable = explode(",", $arrJoinTable[$key]);
                            $arrNeweField = explode(",", $arrJoinField[$key]);
                            foreach($arrType as $innerKey => $value)
                            {
                                $joinString     .= $arrType[$innerKey]." JOIN ";
                                $joinString     .= " $arrTable[$innerKey] ON ";
                                $joinString     .= " $arrNeweField[$innerKey] ";
                            }    
                        }        
                        else
                        {    
                            $joinString     .= $arrJoinType[$key]." JOIN ";
                            $joinString     .= " $arrJoinTable[$key] ON ";
                            $joinString     .= " $arrJoinField[$key] ";
                        }
                        
                     }   
                  }
               } 
               $captionString  = rtrim($captionString,',');
               $queryString    = rtrim($queryString,',');
               $queryString .= " from $table ";
               $queryString .= $joinString;
               $queryString .= $condtionString;
               
               $arrSave = array();
               $arrSave['caption'] = $captionString;
               $arrSave['query'] = $queryString;
               $arrSave['name'] = "dynamic report"; 
                     
               $arrLink = array();
               $insertReportId = $this->Dynamic_report_model->saveReport($arrSave);     
               $name = "save_report";
               $link =  $this->Dynamic_report_model->getReportLink($name);
               $arrSaveReport = array();
               $report_parent_id = '';
               $report_image = '';
               $report_user_type = '';
               //$report_name = "test";
               if(count($link))
               {
                   
                   foreach($link as $row)
                   {
                       $report_parent_id = $row['id'];
                       $report_user_type = $row['user_type'];
                       $report_image = $row['image'];
                       $report_link = $row['link'];
                       
                   }
                   $report_link = "admin_report/save_report";
                   $arrLink['name'] =       $report_name;
                   $arrLink['parent_id'] =  $report_parent_id;
                   $arrLink['image'] =      $report_image;
                   $arrLink['user_type'] =  $report_user_type;
                   $arrLink['link'] =  $report_link."/".$insertReportId;
                   $arrLink['orders'] = 1;
                   $this->Dynamic_report_model->dynamicLinkSave($arrLink);
               }    
       

        }
        $page_data['dynamic_report_name']=$this->Dynamic_report_model->get_group_array();
        $page_data['dynamic_report_list'] = $dynamic_report_list;
        $page_data['page_name']         =   'dynamic_report';
        $page_data['page_title']        =   get_phrase('dynamic_report');
        $this->load->view('backend/index', $page_data);
    }
    
    function save_report($param)
    {
       // echo "<br>here param is $param";
        
        
    }
    
    function get_page_data_var(){
        $this->load->model('Crud_model');
        $page_data=array();
        $page_data['system_name']=$this->globalSettingsSystemName;
        $page_data['system_title']=$this->globalSettingsSystemTitle;
        $page_data['text_align']=$this->globalSettingsTextAlign;
        $page_data['skin_colour']=$this->globalSettingsSkinColour;
        $page_data['active_sms_service']=$this->globalSettingsActiveSmsService;
        $page_data['running_year']=$this->globalSettingsRunningYear;
        $page_data['location']=$this->globalSettingsLocation;
        $page_data['app_package_name']=$this->globalSettingsAppPackageName;
        $page_data['system_email']=$this->globalSettingsSystemEamil;
        $page_data['system_fcm_server_key']=$this->globalSettingsSystemFCMServerrKey;
        $page_data['account_type'] = $this->session->userdata('login_type');
        $user_type=$this->session->userdata('login_type');
        $page_data['filename'] = $this->Crud_model->getSpecificRecord($this->session->userdata('table'),$this->session->userdata($user_type.'_id'));
        return $page_data;
    }
}


