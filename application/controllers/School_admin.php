<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class School_admin extends CI_Controller {

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
        $this->load->model("Setting_model");
        $this->load->model("Crud_model");
        $this->load->model("Email_model");
        $this->load->model("Bus_model");
        $this->load->model("Hostel_registration_model");
        $this->load->model("Student_bus_allocation_model");
        $this->load->model("Hostel_room_model");
        $this->load->model("Transport_model");
        $this->load->model("Parent_teacher_meeting_date_model");
        $this->load->model("Inventory_category_model");
        $this->load->model("Seller_model");
        $this->load->model("Inventory_product_model");
        $this->load->model("Inventory_product_service_model");
        $this->load->model("Parent_model");
        $this->load->model("Student_model");
        $this->load->model("Enquired_students_model");
        $this->load->model("Class_model");
        $this->load->model("Teacher_model");
        $this->load->model("Inventory_allotment_model");
        $this->load->model("Inventory_product_history_model");
        $this->load->model("Exam_model");
        $this->load->helper("email_helper");
        $this->load->helper("send_notifications");
        $this->load->library('session');
        $this->load->model("Class_routine_model");
        $this->load->model("Section_model");
        $this->load->model("Notice_board_model");
        $this->load->model("Attendance_model");
        $this->load->model('Dormitory_model');
        $this->load->model("Evaluation_model");
        $this->load->model("Enroll_model");
        $this->load->model('Cce_model');
        $this->load->model('Subject_model');
        $this->load->model('School_Admin_model');
        $this->load->helper('functions');

        $this->globalSettingsSMSDataArr = get_data_generic_fun('settings', 'description', array('condition_type' => 'in', 'condition_in_col' => 'type', 'condition_in_data' => 'location,app_package_name,running_year,system_name,system_email,fcm_server_key,system_title,text_align,skin_colour,active_sms_service'));
        
        $setting_records = $this->Setting_model->get_data_by_cols('*', array(), 'result_array');
        $this->globalSettingsRunningYear = fetch_parl_key_rec($setting_records, 'running_year');
        $this->globalSettingsLocation = fetch_parl_key_rec($setting_records, 'location');
        $this->globalSettingsAppPackageName = fetch_parl_key_rec($setting_records, 'app_package_name');
        $this->globalSettingsSystemTitle = fetch_parl_key_rec($setting_records, 'system_title');
        $this->globalSettingsSystemName = fetch_parl_key_rec($setting_records, 'system_name');
        $this->globalSettingsSystemEmail = fetch_parl_key_rec($setting_records, 'system_email');
        $this->globalSettingsSystemFCMServerrKey = fetch_parl_key_rec($setting_records, 'fcm_server_key');
        $this->globalSettingsSkinColour = fetch_parl_key_rec($setting_records, 'skin_colour');
        $this->globalSettingsTextAlign = fetch_parl_key_rec($setting_records, 'text_align');
        $this->globalSettingsActiveSmsService = fetch_parl_key_rec($setting_records, 'active_sms_service');
        $this->new_fi = fetch_parl_key_rec($setting_records, 'new_fi');
        $this->globalSettingsActiveSms = $this->globalSettingsActiveSmsService;
        //$this->Setting_model->get_setting_record(array('type' => 'active_sms_service'), 'description');

        $this->session->set_userdata(array(
            'running_year' => $this->globalSettingsRunningYear,
        ));
        
        if ($this->session->userdata('school_admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        /*if ($this->session->userdata('school_admin_login') == 1)
            redirect(base_url() . 'index.php?school_admin/dashboard', 'refresh');*/
    }

    /***default functin, redirects to login page if no admin logged in yet***/
    public function index() {
        if ($this->session->userdata('school_admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($this->session->userdata('school_admin_login') == 1)
            redirect(base_url() . 'index.php?school_admin/dashboard', 'refresh');
    }
    
    function school_admin_message($param1 = 'message_home', $param2 = '', $param3 = '') 
    {
        $this->load->model("School_Admin_model");
        $this->load->model("crud_model"); 
        if ($param1 == 'send_new') {
            $message_thread_code = $this->crud_model->send_new_private_message_admin_main();
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?school_admin/school_admin_message/school_admin_message_read/'.$message_thread_code, 'refresh');
        }

        if ($param1 == 'send_reply') {
            $this->crud_model->send_reply_message_main($param2);  //$param2 = message_thread_code
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?school_admin/school_admin_message/school_admin_message_read/' . $param2, 'refresh');
        }

        if ($param1 == 'school_admin_message_read') {
            $this->load->model("crud_model");
            $page_data['current_message_thread_code'] = $param2;  // $param2 = message_thread_code
            $this->Crud_model->mark_thread_messages_read_main($param2);
            $this->load->model("Admin_Message_model"); 
            // $data = $this->Admin_Message_model->get_data_by_cols('*', array('message_thread_code' => $param2), 'result_array');
        
            $page_data['messages'] = $message =  $this->Admin_Message_model->get_data_by_cols('*', array('message_thread_code' => $param2), 'result_array');
            
            $parent = array();
            $parent_all = array();
        
            $i = 0;
            $NewArray = array();
            $img_user = array();
            
            foreach ($page_data['messages'] as $message) {
                $sender = explode('-', $message['sender']);
                
                $sender_account_type = $sender[0];
                $sender_id = $sender[1];
                $img_user[]['image'] = $this->crud_model->get_image_url($sender_account_type, $sender_id);
            
                $model_name = $sender_account_type.'_model';
            // echo "<br>her emodel name is $model_name";
                $this->load->model($model_name);
                //echo "<br>we are here"; die();   
                if ($sender_account_type == 'admin') {
                    $parent = $this->$model_name->get_data_by_cols('name', array($sender_account_type . '_id' => $sender_id), 'result_array');
                
                    if (!empty($parent)) {
                        $parent_all[]['name'] = $parent[0]['name'];
                    } else {
                        $parent_all[]['name'] = "";
                    }
                
                } 
                else {
                    $parent = $this->$model_name->get_data_by_cols('first_name', array($sender_account_type . '_id' => $sender_id), 'result_array');
                    if (!empty($parent)) {
                        $parent_all[]['name'] = $parent[0]['first_name'];
                    } else {
                        $parent_all[]['name'] = "";
                    }
                }
                if(empty($img_user[$i]))
                    $img_user[$i] = '';
                
                $NewArray[$i] = array_merge($message, $parent_all[$i], $img_user[$i]);
                $i++;
            }
        
            $page_data['message'] = $NewArray;
        }

        if ($param1 == 'school_admin_message_new') {
            $this->load->model('Admin_Message_model');
            $this->load->model("Admin_model");
            $all_participent['admin']  = $admin =   $this->Admin_model->get_data_by_cols('*', array(), 'result_array', array('name' => 'asc'));

            //pre($admin); die;
            $page_data['all_participent'] = $all_participent;
        }
        
        if($param1 == 'delete'){
            $this->load->model('Admin_Message_model');
            $delete_message = $this->Admin_Message_model->delete_msg_thread($param2);
            if($delete_message){
                $this->session->set_flashdata('flash_message', get_phrase('message_deleted!'));
                redirect(base_url() . 'index.php?school_admin/school_admin_message/school_admin_message_read/'.$param2, 'refresh');
            }else{
                $this->session->set_flashdata('flash_message_error', get_phrase('could_not_delete!'));
                redirect(base_url() . 'index.php?school_admin/school_admin_message/school_admin_message_read/' . $param2, 'refresh');
            }
        }
    
        $page_data['message_inner_page_name'] = $param1;
        $page_data['page_name'] = 'school_admin_message';
        $page_data['page_title'] = get_phrase('Message_board');
        //pre($page_data); die();
        $this->load->view('backend/index', $page_data);
    }

    function db_error() {
        $page_data['page_name'] = 'db_error_page';
        $page_data['error_type'] = 'db_error';
        $page_data['page_title'] = get_phrase('admin_dashboard');
        $this->load->view('backend/index', $page_data);
    }

    /*     * *ADMIN DASHBOARD** */

    function dashboard() {
        if ($this->session->userdata('school_admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        //pre($page_data);die;

        $page_data['page_name'] = 'dashboard';
        $page_data['page_title'] = get_phrase('admin_dashboard');
        $this->load->model("Attendance_model");

        //Get Setting Records
        /* $page_data['system_name'] = $this->Setting_model->get_setting_record(array('type' => 'system_name'), 'description');
          $page_data['system_title'] = $this->Setting_model->get_setting_record(array('type' => 'system_title'), 'description');
          $page_data['text_align'] = $this->Setting_model->get_setting_record(array('type' => 'text_align'), 'description');
          $page_data['skin_colour'] = $this->Setting_model->get_setting_record(array('type' => 'skin_colour'), 'description');
          $page_data['active_sms_service'] = $this->Setting_model->get_setting_record(array('type' => 'active_sms_service'), 'description');
          $page_data['running_year'] = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
          $page_data['account_type'] = $this->session->userdata('login_type'); */

        $check1 = array('counselling' => '1');
        $query1 = $this->Enquired_students_model->get_data_by_cols('*', $check1, 'result_type');
        $page_data['tot_admission'] = count($query1);
        $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
        $page_data['count'] = $this->Student_model->get_count_curent_year($running_year);
        $page_data['tot_teacher'] = $this->Teacher_model->count_all();
        $page_data['tot_parent'] = $this->Parent_model->count_all();

        $page_data['sections'] = $this->Class_model->get_section_array(array('class_id' => 'all'));
        $all_section_student_array = array();
        $no_student = 0;
        foreach ($page_data['sections'] as $section) {
            $selected_section_student = $this->Student_model->getstudents_section_for_report('all', $page_data['running_year'], $section['section_id']);
            $no_student = count($selected_section_student) + $no_student;
        }
        $page_data['tot_student'] = $no_student;

        $check2 = array('timestamp' => strtotime(date('Y-m-d')), 'status' => '1');
        $query2 = $this->Attendance_model->get_data_by_cols('*', $check2, 'result_type');
        $page_data['tot_student_present'] = count($query2);
        //Graphical Attendance Report - Added By Meera - July 1st 2017
        $page_data['currentMonth'] = date('F');

        $page_data['attendance_percentage'] = $this->Attendance_model->get_attendence_class_month($page_data['currentMonth']);
        //        echo '<pre>'; print_r($page_data['attendance_percentage']);die();

        $this->load->model("Holiday_model");
        $page_data['holidays'] = $this->Holiday_model->get_holiday_active_list();

        $this->load->model("Admission_settings_model");
        //pre($page_data['holidays']);die;
        $page_data['arrAllLinks'] = $this->session->userdata('arrAllLinks');
        $this->save_report_link();
        $this->load->view('backend/index', $page_data);
    }

    function save_report_link() {
        $this->load->model("Dynamic_report_model");
        $section_id = 1;
        $result = $this->Dynamic_report_model->getCustomReportLink($section_id);
        $arrLink = array();
        $report_data = $this->Dynamic_report_model->getReportLink("report_section", "SA");

        foreach ($report_data as $report)
            $parent_id = $report['id'];

        if (count($result)) {
            $order = 0;
            foreach ($result as $key => $value) {
                $order++;
                $arrLink['link'] = "admin_report/custom_report/" . $value['id'];
                $arrLink['name'] = $caption = $value['report_caption'];

                $result = $this->Dynamic_report_model->checkCaptionExist($caption);
                $count = count($result);

                if ($count) { // find duplicate
                    
                } else {
                    //get school_admin role id
                    $school_id = '';
                    if (isset($_SESSION['school_id']))
                        $school_id = $_SESSION['school_id'];
                    $role_id = 6;
                    $type = "SA";
                    $arrLink['user_type'] = "SA";
                    $arrLink['image'] = "icon-size fa fa-book";
                    $arrLink['orders'] = $order;
                    $arrLink['parent_id'] = $parent_id;
                    $arrLink['school_id'] = $school_id;
                    $this->Dynamic_report_model->dynamicLinkSave($arrLink, $role_id, $type);
                }
            }
        }
    }

    function sendemail() {
        $data['imei'] = $this->input->post('imei');
        $data['date'] = $this->input->post('date');
        $data['time'] = $this->input->post('time');
        $data['card_id'] = $this->input->post('rfid');
        $data['message'] = $this->input->post('message');
        $data['email'] = $this->input->post('email');
        if ($data['date'] == '')
            $data['date'] = $data['time'];
        $this->Email_model->do_email($data['message'], 'Attendence', $data['email']);
        echo "success";
    }

    /*     * **MANAGE STUDENTS CLASSWISE**** */

    function student_add() {
        if ($this->session->userdata('school_admin_login') != 1)
            redirect(base_url(), 'refresh');

        $this->config->load('country_list', true);
        $country_name = $this->config->item('countries', 'country_list');
        $nationalities = $this->Student_model->get_nationality_array();
        $this->load->model("Parent_model");
        $this->load->model("Class_model");
        $this->load->model("Dormitory_model");
        $this->load->model("Transport_model");

        $parents_array = $this->Parent_model->get_parents_array();
        $class_array = $this->Class_model->get_class_array();
        $dormitory_array = $this->Dormitory_model->get_dormitory_array((array("status" => "Active")));
        $transport_array = $this->Transport_model->get_transport_array();
        $this->load->library('Fi_functions');
        $running_year = $this->globalSettingsRunningYear;
        $scholarships = $this->fi_functions->getScholarships($running_year);
        $page_data = $this->get_page_data_var();
        if ($scholarships) {
            $page_data['scholarships'] = $scholarships;
        }
        $active_installments = $this->fi_functions->getActiveInstallments($running_year);

        $school_fee_inst = array();
        $transp_fee_inst = array();
        $hostel_fee_inst = array();
        if ($active_installments) {
            $val = $active_installments[0];
            $school_fee_installment_ids = explode(',', $val['schoolfee_inst_types']);
            $transp_fee_installment_ids = explode(',', $val['transfee_inst_types']);
            $hostel_fee_installment_ids = explode(',', $val['hostelfee_inst_types']);

            foreach ($school_fee_installment_ids as $school_fee_inst_id) {
                $result = $this->fi_functions->get_installments($school_fee_inst_id);
                $school_fee_inst[] = $result[0];
            }

            foreach ($transp_fee_installment_ids as $transp_fee_inst_id) {
                $result = $this->fi_functions->get_installments($transp_fee_inst_id);
                $transp_fee_inst[] = $result[0];
            }

            foreach ($hostel_fee_installment_ids as $hostel_fee_inst_id) {
                $result = $this->fi_functions->get_installments($hostel_fee_inst_id);
                $hostel_fee_inst[] = $result[0];
            }
        }

        $arrInstallment = array('school_fee_inst' => $school_fee_inst, 'transp_fee_inst' => $transp_fee_inst, 'hostel_fee_inst' => $hostel_fee_inst);
        $page_data['fee_installment'] = $arrInstallment;
        $page_data['parents'] = $parents_array;
        $page_data['classes'] = $class_array;
        $page_data['dormitories'] = $dormitory_array;
        $page_data['transports'] = $transport_array;
        $page_data['page_name'] = 'student_add';
        $page_data['countries'] = $country_name;
        $page_data['nationality'] = $nationalities;
        $this->load->model("Dynamic_field_model");
        $groups = array();
        $arrFields = array();
        $form_id = 1;
        $groups = $this->Dynamic_field_model->getDynamicGroup($form_id);
        $arrGroups = array();
        $arrDbField = array();
        $arrDynamic = array();
        $arrLabel = array();
        $arrValidation = array();
        $arrFieldValue = array();
        $arrFieldQuery = array();
        $arrAjaxEvent = array();
        $arrClass = array();
        $arrPlaceHolder = array();
        foreach ($groups as $row) {
            $i = 0;
            $group_id = $row['id'];
            $group_name = $row['name'];
            $group_image = $row['image'];
            $group_intro = $row['intro'];
            $section_name = $row['section_name'];
            $is_active = $row['is_active'];
            $arrGroups[$group_id] = $group_name . "||||" . $group_image . "||||" . $group_intro . "||||" . $section_name . "||||" . $is_active;
            $arrFields = $this->Dynamic_field_model->getDynamicFields($group_id);


            foreach ($arrFields as $field) {

                $db_field = $field['db_field'];
                $arrDbField[$group_id . "_" . $i] = $db_field;
                $arrLabel[$group_id][$db_field] = $field['label'];
                $arrClass[$group_id][$db_field] = $field['image'];
                $arrPlaceHolder[$group_id][$db_field] = $field['place_holder'];
                $arrLabel[$group_id][$db_field] = $field['label'];
                $arrAjaxEvent[$group_id][$db_field] = $field['ajax_event'];
                $arrValidation[$group_id][$db_field] = $field['validation'] . "?" . $field['validation_type'];
                $arrFieldValue[$group_id][$db_field] = $field['field_type'] . "?" . $field['field_values'];
                $i++;
                if (strtolower($field['field_values']) == "query") {
                    if (empty($field['field_where']))
                        $field['field_where'] = " 1 = 1";
                    $result = $this->Dynamic_field_model->getDynamicQuery($field['field_table'], $field['field_select'], $field['field_where']);

                    $field_split = explode(",", $field['field_select']);

                    foreach ($result as $row) {
                        if (isset($field_split[0]) && isset($field_split[1]))
                            $arrDynamic[$group_id][$db_field][$row[$field_split[0]]] = $row[$field_split[1]];
                    }
                    //$arrFieldQuery[$group_id][$db_field] = $field['field_table']."||".$field['field_select']."||".$field['field_where'];
                }
            }
        }

        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['arrDynamic'] = $arrDynamic;
        $page_data['arrGroups'] = $arrGroups;
        $page_data['arrLabel'] = $arrLabel;
        $page_data['arrAjaxEvent'] = $arrAjaxEvent;
        $page_data['arrValidation'] = $arrValidation;
        $page_data['arrFieldValue'] = $arrFieldValue;
        $page_data['arrFieldQuery'] = $arrFieldQuery;
        $page_data['arrDbField'] = $arrDbField;
        $page_data['arrClass'] = $arrClass;
        $page_data['arrPlaceHolder'] = $arrPlaceHolder;
        $page_data['arrInstallment'] = $arrInstallment;

        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['page_title'] = get_phrase('add_student');
        $this->load->view('backend/index', $page_data);
    }

    function student_bulk_add($param1 = '') {
        if ($this->session->userdata('school_admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model("Class_model");
        $class_array = $this->Class_model->get_class_array();
        if ($param1 == 'add_bulk_student') {
            $names = $this->input->post('name');
            $rolls = $this->input->post('roll');
            $emails = $this->input->post('email');
            $passwords = $this->input->post('password');
            $phones = $this->input->post('phone');
            $addresses = $this->input->post('address');
            $cities = $this->input->post('city');
            $genders = $this->input->post('sex');
            $cardids = $this->input->post('card_id');

            $student_entries = sizeof($names);
            for ($i = 0; $i < $student_entries; $i++) {
                $data['name'] = $names[$i];
                $data['email'] = $emails[$i];
                $data['password'] = sha1($passwords[$i]);

                $data['phone'] = $phones[$i];
                $data['address'] = $addresses[$i];
                $data['city'] = $cities[$i];

                $data['sex'] = $genders[$i];
                $data['card_id'] = $cardids[$i];
                //validate here, if the row(name, email, password) is empty or not
                if ($data['name'] == '' || $data['email'] == '' || $data['password'] == '')
                    continue;

                $student_id = $this->Student_model->save_student($data);
                $data2['enroll_code'] = substr(md5(rand(0, 1000000)), 0, 7);
                $data2['student_id'] = $student_id;
                $data2['class_id'] = $this->input->post('class_id');
                if ($this->input->post('section_id') != '') {
                    $data2['section_id'] = $this->input->post('section_id');
                }
                $data2['roll'] = $rolls[$i];
                $data2['date_added'] = strtotime(date("Y-m-d H:i:s"));
                $data2['year'] = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');

                $enroll_id = $this->Student_model->enroll_student($data2);
            }
            $this->session->set_flashdata('flash_message', get_phrase('students_added'));
            redirect(base_url() . 'index.php?school_admin/student_information/' . $this->input->post('class_id'), 'refresh');
        }

        if ($param1 == 'import_excel') {
            $this->load->helper('general_used');
            @unlink('uploads/student_import.xlsx');
            @unlink('uploads/student_bulk_upload_error_details.log');
            //pre($_FILES);die;
            if($_FILES['userfile']['error']==0){
                //pre($_FILES);
                if(move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_import.xlsx')){
                    @ini_set('memory_limit', '-1');
                    @set_time_limit(0);
                    // Importing excel sheet for bulk student uploads
                    include 'Simplexlsx.class.php';
                    $xlsx = new SimpleXLSX('uploads/student_import.xlsx');
                    //pre($_FILES);die;

                    //pre($xlsx);die;
                    list($num_cols, $num_rows) = $xlsx->dimension();
                    $f = 0;
                    $this->load->model("Dynamic_field_model");
                    $rs_student_bulk_upload_fields= $this->Dynamic_field_model->get_student_bulk_upload();
                    $rs_student_bulk_upload_mandatory_fields= $this->Dynamic_field_model->get_student_bulk_upload_mandatory();
                    $rs_student_bulk_upload_label_fields= $this->Dynamic_field_model->get_student_bulk_upload_label();

                    //$fielsdStringForAdmin="Student Name,Middle Name,Last Name,Gender,Date Of Birth,Caste Category, Class Name,Section,Roll,Course,Previous School,Parent EmailId,Address,Location,Phone,Email,Passport No,Card,Identity Card Type,Identity Card,Dormitory,Transport,Place of Birth,Country,Nationality";
                    //$fielsdStringForAdmin = "Student Name,Middle Name,Last Name,Gender,Date Of Birth,Caste Category, Class Name,Section,Roll,Course,Previous School,Parent EmailId,Address,Location,Phone,Email,Passport No,Card,Identity Card Type,Identity Card,Place of Birth,Country,Nationality";
                    $fielsdStringForAdmin = $rs_student_bulk_upload_label_fields[0]['tableCol'];
                    //$fielsdString="name,mname,lname,sex,birthday,caste_category,class_id,section_id,roll,course,previous_school,parent_id,address,location,phone,email,passport_no,card_id,type,icard_no,dormitory_id,transport_id,place_of_birth,country,nationality";
                    //$fielsdString = "name,mname,lname,sex,birthday,caste_category,class_id,section_id,roll,course,previous_school,parent_id,address,location,phone,email,passport_no,card_id,type,icard_no,place_of_birth,country,nationality";
                    $fielsdString = $rs_student_bulk_upload_fields[0]['tableCol'];
                    //$fielsdStringMandotary = "name,sex,birthday,class_id,section_id,parent_id,address,location,email,country,nationality";
                    $fielsdStringMandotary = $rs_student_bulk_upload_mandatory_fields[0]['tableCol'];

                    $fielsdArr = explode(',', $fielsdString);
                    $fielsdStringForAdminArr = explode(',', $fielsdStringForAdmin);
                    $fielsdStringMandotaryArr = explode(',', $fielsdStringMandotary);

                    $someRowError = FALSE;
                    $errorMsgArr = array();
                    $errorExcelArr = array();
                    $errorExcelArr[] = $fielsdStringForAdminArr;
                    $errorRowNo = 2;
                    //pre($xlsx->rows());die;
                    foreach ($xlsx->rows() as $r) {
                        $data = array();
                        $dataStudent = array();
                        $error = FALSE;
                        // Ignore the inital name row of excel file
                        if ($f == 0) {
                            $f++;
                            continue;
                        } $f++;
                        //pre($r); die('here');
                        //pre($r);pre('above are $r data');
                        if ($num_cols > count($fielsdArr)) {
                            $num_cols = count($fielsdArr);
                        }
                        $blankErrorMsgArr = array();
                        $errorRowIncrease = FALSE;
                        for ($i = 0; $i < $num_cols; $i++) {    // checking is filds is mandetory or not
                            //pre($fielsdArr); echo $i;
                            if (in_array($fielsdArr[$i], $fielsdStringMandotaryArr)) {
                                //pre($fielsdArr[$i]);
                                //now validating mandetory fiels
                                //generate_log("Field ".$fielsdArr[$i]." value ".$r[$i]."\n",'student_bulk_upload_'.date('d-m-Y-H').'.log');

                                if (trim($r[$i]) == "") {
                                    $error = TRUE;
                                    $blankErrorMsgArr[] = $fielsdStringForAdminArr[$i] . " should not be blank at row no " . $errorRowNo;
                                    //pre($blankErrorMsgArr);
                                } else {
                                    $validPhoneEmailCheck = "";
                                    $rsEmailPhoneUnique = array();
                                    // now check teh uniques for email then phone

                                    $fieldType= $this->Dynamic_field_model->get_field_type($fielsdArr[$i],'1');

                                    if($fieldType=='email'){
                                        $rsEmailPhoneUnique = $this->Student_model->get_data_by_cols('student_id', array($fielsdArr[$i] => trim($r[$i])));
                                        $validPhoneEmailCheck = $this->checkValidPhoneEmail(trim($r[$i]), 'email');
                                    }

                                    if($fieldType=='tel'){
                                        $rsEmailPhoneUnique = $this->Student_model->get_data_by_cols('student_id', array($fielsdArr[$i] => trim($r[$i])));
                                        $validPhoneEmailCheck = $this->checkValidPhoneEmail(trim($r[$i]), 'phone');
                                    }

                                    /*if ($fielsdArr[$i] == 'email') {
                                        $rsEmailPhoneUnique = $this->Student_model->get_data_by_cols('student_id', array('email' => trim($r[$i])));
                                        $validPhoneEmailCheck = $this->checkValidPhoneEmail(trim($r[$i]), 'email');
                                    } elseif ($fielsdArr[$i] == 'phone') {
                                        $rsEmailPhoneUnique = $this->Student_model->get_data_by_cols('student_id', array('phone' => trim($r[$i])));
                                        $validPhoneEmailCheck = $this->checkValidPhoneEmail(trim($r[$i]), 'phone');
                                    }*/

                                    if (count($rsEmailPhoneUnique) > 0) {
                                        $error = TRUE;
                                        $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " is already entered.Should be unique information at row no -" . $errorRowNo;
                                        //echo '<br>';
                                    }

                                    if ($validPhoneEmailCheck != 'ok' && ($fieldType == 'email' || $fieldType == 'tel')) {
                                        $error = TRUE;
                                        $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " Should be " . $validPhoneEmailCheck . " at row no -" . $errorRowNo;
                                    }

                                    //if ($fielsdArr[$i] == 'birthday') {
                                    if ($fieldType == 'date') {
                                        $excelDOB = trim($r[$i]);
                                        //$unixTimestamp = ($excelDOB - 25569) * 86400;
                                        //$rawDOB= date('d.m.Y',$unixTimestamp);
                                        $rawDOB = $excelDOB;
                                        //generate_log("Harvinder ".date('Y-m-d', $ts),'student_bulk_upload_'.date('d-m-Y-H').'.log');
                                        $newDOB = $this->get_mysql_date_formate_from_raw($rawDOB);
                                        if ($newDOB != "") {
                                            $data[$fielsdArr[$i]] = $newDOB; //date('Y-m-d', $ts);
                                        } else {
                                            $error = TRUE;
                                            $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " content invalid data at row no -" . $errorRowNo;
                                        }
                                    }

                                    /*if ($fielsdArr[$i] == 'date_time') {
                                        $excelDOB = trim($r[$i]);
                                        $unixTimestamp = ($excelDOB - 25569) * 86400;
                                        $rawDOB = date('d.m.Y', $unixTimestamp);

                                        $newDOB = $this->get_mysql_date_formate_from_raw($rawDOB);
                                        if ($newDOB != "") {
                                            $data[$fielsdArr[$i]] = $newDOB;
                                        } else {
                                            $error = TRUE;
                                            $errorMsgArr[] .= $fielsdStringForAdminArr[$i] . " content invalid data at row no -" . $errorRowNo;
                                        }
                                    }*/

                                    if ($fielsdArr[$i] == 'parent_id') { //echo "parent_id ";
                                        $rsParent = $this->Parent_model->get_data_by_cols('*', array('email' => trim($r[$i])));
                                        //echo $this->db->last_query();
                                        //pre($rsParent);die;
                                        if (count($rsParent) > 0) {
                                            $data['parent_id'] = $rsParent[0]->parent_id;
                                        } else {
                                            $error = TRUE;
                                            $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " content invalid data at row no -" . $errorRowNo;
                                        }
                                    }

                                    $stu_password = create_passcode('student');
                                    $data['password'] = ($stu_password != 'invalid') ? sha1($stu_password) : '';
                                    $data['passcode'] = ($stu_password != 'invalid') ? $stu_password : '';
                                    $data['student_status'] = '1';

                                    if ($fielsdArr[$i] == 'class_id') {
                                        $rsClass = $this->Class_model->get_name($r[$i]);
                                        if (count($rsClass) > 0) {
                                            $dataStudent['class_id'] = $rsClass[0]->class_id;
                                        } else {
                                            $dataStudent['class_id'] = "";
                                            $error = TRUE;
                                            $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " content invalid data at row no -" . $errorRowNo;
                                        }
                                    }

                                    if ($fielsdArr[$i] == 'section_id') {
                                        if ($dataStudent['class_id'] == "") {
                                            $error = TRUE;
                                            $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " content invalid data at row no -" . $errorRowNo;
                                        } else {
                                            $rsClassSection = $this->Section_model->get_name($dataStudent['class_id'], $r[$i]);

                                            if (count($rsClassSection) > 0) {
                                                $dataStudent['section_id'] = $rsClassSection[0]->section_id;
                                            } else {
                                                $error = TRUE;
                                                $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " content invalid data at row no -" . $errorRowNo;
                                            }
                                        }
                                    }
                                }
                                //pre($blankErrorMsgArr);
                                if ($fielsdArr[$i] != 'section_id' && $fielsdArr[$i] != 'class_id' && $fielsdArr[$i] != 'birthday' && $fielsdArr[$i] != 'date_time' && $fielsdArr[$i] != 'parent_id') {
                                    //echo '$i : '.$i.' ==== $fielsdArr[$i] :'.$fielsdArr[$i].' ==== $r[$i] : '.$r[$i].'<br>';
                                    $data[$fielsdArr[$i]] = trim($r[$i]);
                                }
                            } else {
                                if ($fielsdArr[$i] == 'roll' && trim($r[$i]) == "") {
                                    $data['roll'] = ""; //substr(uniqid(),0,8);
                                }
                                if ($fielsdArr[$i] == 'dormitory_id' && trim($r[$i]) != "") {
                                    $rsDormitory = array();
                                    $rsDormitory = $this->Dormitory_model->get_name($r[$i]);

                                    if (count($rsDormitory) > 0) {
                                        $data['dormitory_id'] = $rsDormitory[0]->dormitory_id;
                                    } else {
                                        $error = TRUE;
                                        $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " content invalid data at row no -" . $errorRowNo;
                                    }
                                } else {
                                    $data['dormitory_id'] = 0;
                                }

                                if ($fielsdArr[$i] == 'transport_id' && trim($r[$i]) != "") {
                                    $rsTransport = $this->Transport_model->get_name($r[$i]);

                                    if (count($rsTransport) > 0) {
                                        //pre($rsTransport);die($rsTransport[0]->transport_id);
                                        $transport_id = $rsTransport[0]->transport_id;
                                        $rsTransport = array();
                                        $data['transport_id'] = $transport_id;
                                    } else {
                                        $error = TRUE;
                                        $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " content invalid data at row no -" . $errorRowNo;
                                    }
                                } else {
                                    $data['transport_id'] = 0;
                                }

                                //echo '$i++ : '.$i.' ==== $fielsdArr[$i]++ :'.$fielsdArr[$i].' ==== $r[$i]++ : '.$r[$i].'<br>';
                                //if($fielsdArr[$i]=='roll' && trim($r[$i])!="")
                                $data[$fielsdArr[$i]] = trim($r[$i]);
                            }
                        }
                        if (count($blankErrorMsgArr) > 0) {
                            $error = TRUE;
                            if (count($blankErrorMsgArr) < 20) {
                                foreach ($blankErrorMsgArr AS $errorKey => $errorVal) {
                                    $errorMsgArr[] = $errorVal;
                                }
                            }
                        }
                        //pre('$error');
                        if ($error === FALSE) {
                            //pre('comming to add data');
                            //pre($data);
                            //$data['date_time']=strtotime(date("Y-m-d H:i:s"));
                            if(!array_key_exists('roll', $data)){
                                $data['roll']="";
                            }
                            $dataStudent['roll'] = $data['roll'];

                            unset($data['roll']);
                            unset($data['class_id']);
                            unset($data['section_id']);

                            //$dataStudent['date_added'] = strtotime(date("Y-m-d H:i:s"));
                            $dataStudent['enroll_code'] = substr(md5(rand(0, 1000000)), 0, 7);
                            $dataStudent['year'] = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
                            $data = array_filter($data, create_function('$a', 'return $a!=="";'));
                            //pre('final student data');
                            //pre($data); //die;
                            //pre($dataStudent);die;
                            $student_id = $this->Student_model->save_student($data);
                            $dataStudent['student_id'] = $student_id;

                            $dataStudent['roll'] = generate_roll_no($dataStudent['class_id'], $dataStudent['section_id']);
                            generate_log(serialize($dataStudent));
                            $enroll_id = $this->Student_model->enroll_student($dataStudent);
                        } else {
                            $errorExcelArr[] = $r;
                            $someRowError = TRUE;
                        }
                        $errorRowNo++;
                    }
                    //pre($errorExcelArr);die();

                    if ($someRowError == FALSE) {
                        //$this->generate_cv($error_msg);
                        generate_log("No error for this upload at - " . time(), 'student_bulk_upload_' . date('d-m-Y-H') . '.log');
                        $this->session->set_flashdata('flash_message', get_phrase('students_details_added'));
                        redirect(base_url() . 'index.php?school_admin/bulk_upload/' . $this->input->post('class_id'), 'refresh');
                    } else {
                        //pre($errorMsgArr);die;
                        generate_log(json_encode($errorMsgArr), 'student_bulk_upload_error_details.log', TRUE);
                        $file_name_with_path = 'uploads/student_bulk_upload_error_details_for_excel_file.xlsx';
                        @unlink($file_name_with_path);
                        create_excel_file($file_name_with_path, $errorExcelArr);
                        $this->session->set_flashdata('flash_message_error', "Some rows are not uploaded,due to invalid data.");
                        redirect(base_url() . 'index.php?school_admin/student_bulk_upload_error' . $this->input->post('class_id'), 'refresh');
                    }
                }else{
                    generate_log("Unknown error while uploading file.", 'student_bulk_upload_' . date('d-m-Y-H') . '.log');
                    $this->session->set_flashdata('flash_message', 'Unknown error while uploading file.please contact with support@rarome.com');
                    redirect(base_url() . 'index.php?school_admin/bulk_upload' , 'refresh');
                }
            }else{
                generate_log("Unknown error while uploading file as ", 'student_bulk_upload_' . date('d-m-Y-H') . '.log');
                $this->session->set_flashdata('flash_message', 'File upload error no '.$_FILES['userfile']['error'].'.please contact with support@rarome.com');
                redirect(base_url() . 'index.php?school_admin/bulk_upload', 'refresh');
            }
        }//ends import excel
        //} 
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['page_name'] = 'student_bulk_add';
        $page_data['page_title'] = get_phrase('add_bulk_student');
        $page_data['classes'] = $class_array;
        $this->load->view('backend/index', $page_data);
    }

    function get_sections($class_id) {
        $page_data = $this->get_page_data_var();
        $this->load->model("Class_model");
        $sections_arr = $this->Class_model->get_section_array(array("class_id" => $class_id));
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['class_id'] = $class_id;
        $page_data['sections'] = $sections_arr;
        $this->load->view('backend/school_admin/student_bulk_add_sections', $page_data);
    }

    /*
     * Get all student information
     * @param int $class_id class to be shown
     * @return result array to view page "student_information"
     */

    function student_information($class_id = '') {

        if ($this->session->userdata('school_admin_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model("Class_model");
        if ($class_id == "") {
            $class_id = $this->Class_model->get_first_class_id();
        }
        $class_array = array('class_id' => $class_id);

        $page_data['sections'] = $this->Class_model->get_section_array($class_array);
        $page_data['page_name'] = 'student_information';
        $page_data['page_title'] = get_phrase('student_information') . " - " . get_phrase('class') . " : " . $this->crud_model->get_class_name($class_id);
        $page_data['class_id'] = $class_id;
        $this->load->model("Class_model");
        $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
        /* $students = array();
          $students = $this->Student_model->getallstudents($class_id, $running_year);


          $page_data['students'] = $students; */
        $page_data['classes'] = $this->Class_model->get_data_by_cols('*', array(), 'result_array');
        $i = 0;
        /* $NewArray = array();
          $all_section_student_array = array();
          foreach ($page_data['sections'] as $section) {
          $selected_section_student = $this->Student_model->getstudents_section($class_id, $running_year, $section['section_id']);
          $studentss[]['student_all'] = $selected_section_student;
          foreach ($selected_section_student as $key => $value) {
          $all_section_student_array[] = $value;
          }
          // pre($all_section_student_array);
          $NewArray[$i] = array_merge($section, $studentss[$i]);
          $i++; //die;
          }

          foreach ($all_section_student_array as $key => $row) {
          $all_section_student_array[$key]['transaction'] = $this->Crud_model->getStudentTransaction($row['student_id']);
          } */

        //pre($all_section_student_array);die;
        // $page_data['students'] = $all_section_student_array;
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        //$page_data['all_records'] = $NewArray;

        $this->load->view('backend/index', $page_data);
    }

    /*     * ************-------------COMPLETE STUDENT PROFILE ------------------***** */

    function student_profile($student_id = '') {
        if ($this->session->userdata('school_admin_login') != 1)
            redirect('login', 'refresh');
        $this->load->model("Dormitory_model");
        $this->load->model("Transport_model");
        $this->load->model("Section_model");
        $this->load->model("Student_model");
        $this->load->model("Book_model");
        $this->load->model("Progress_model");
        $this->load->model("Mark_model");
        $page_data = $this->get_page_data_var();
        $section_id = '';
        $page_data['student_id'] = $student_id;
        $page_data['student_personal_info'] = $this->Student_model->get_student_details($student_id);
        if (!empty($page_data['student_personal_info'])) {
            $page_data['photo_url'] = $this->crud_model->get_image_url('student', $page_data['student_personal_info']->student_id);
            $class_id = $page_data['student_personal_info']->class_id;
            $section_id = $page_data['student_personal_info']->section_id;
        }
        $page_data['parents'] = $this->Parent_model->get_parents_array();

        $this->config->load('country_list', true);
        $country_name = $this->config->item('countries', 'country_list');
        $page_data['countries'] = $country_name;
        $page_data['dormitories'] = $this->Dormitory_model->get_dormitory_array();
        //*********** progress report ************
        $year = $this->globalSettingsSMSDataArr[1]->description;
        $runningYr = $this->Setting_model->get_year();
        if (!empty($section_id)) {
            $this->load->model("Subject_model");

            $page_data['subjects'] = $this->Subject_model->get_subject_array(array('section_id' => $section_id));
        } else {
            $page_data['subjects'] = "";
        }
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['student_id'] = $student_id;

        /*         * ******** MANAGE TRANSPORT / VEHICLES / ROUTES******************* */
        $page_data['transports'] = $this->Transport_model->get_transport_details($student_id);
        /*         * ********* VIEW Dormitory Information ********* */
        $this->load->model('hostel_registration_model');
        $page_data['student_infoh'] = $this->hostel_registration_model->get_student_info_parents($student_id);

        /*         * ******** MEDICAL RECORD ****** */
        $this->load->model("Medical_events_model");
        $student_allergy = $this->Medical_events_model->student_allergy($student_id);
//        pre($student_allergy); die;
        $student_medical_history = $this->Medical_events_model->get_data_by_cols('*', array('user_id' => $student_id), 'result_array');
        $count_arr = count($student_medical_history);
        $page_data['count_arr'] = $count_arr;
        $page_data['student_allergy'] = $student_allergy;
        $page_data['medical_records'] = $student_medical_history;

        /*         * ***** LIBARARY INFORMATION ************* */
        $this->load->model("crud_model");
        //$data['user_type'] = "Student";
        $data['member_id'] = $page_data['student_personal_info']->card_id;
        $page_data['issue_log'] = $this->Book_model->get_books_issue_records_from_circulation("circulation", $data, "*");


        /*         * ************ATENDANCE RECORD INFORMATION ************ */


        $date = date('m');
        $month = explode("0", $date);
        $page_data['month'] = $month[1];
        $page_data['section_id'] = $page_data['student_personal_info']->section_id;
        $page_data['class_id'] = $page_data['student_personal_info']->class_id;
        $page_data['class_name'] = $page_data['student_personal_info']->class_name;
        $page_data['section_name'] = $page_data['student_personal_info']->section_name;

        /*         * ********************  STUDENT MARKSHEET **************** */
        /* $this->load->model("Class_model");
          $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
          $class_id = $this->Student_model->get_enroll_record(array('student_id' => $student_id, 'year' => $running_year), "class_id");
          $student_name = $this->Student_model->get_student_record(array('student_id' => $student_id), "name");
          $class_name = $this->Class_model->get_class_record(array('class_id' => $class_id), "name");
         */

        $class_name_data = $this->Class_model->get_data_by_id($page_data['class_id'], 'name');
        $page_data['class_name'] = $class_name_data[0]->name;

        $section_name_data = $this->Section_model->get_data_by_id($page_data['section_id'], 'name');
        $page_data['section_name'] = $section_name_data[0]->name;

        $rData = '';

        for ($d = 1; $d <= 7; $d++) {
            if ($d == 1)
                $day = 'sunday';
            else if ($d == 2)
                $day = 'monday';
            else if ($d == 3)
                $day = 'tuesday';
            else if ($d == 4)
                $day = 'wednesday';
            else if ($d == 5)
                $day = 'thursday';
            else if ($d == 6)
                $day = 'friday';
            else if ($d == 7)
                $day = 'saturday';

            $rData .= '<tr class="gradeA"><td width="100">' . strtoupper($day) . '</td><td>';

            $sortArr = array('time_start' => 'asc');
            $routines = $this->Class_routine_model->get_data_by_cols('', array('day' => $day, 'class_id' => $page_data['class_id'], 'section_id' => $page_data['section_id'], 'year' => $runningYr), 'result_array', $sortArr);
            //pre($routines);
            foreach ($routines as $row2) {
                //$rData.='<div class="btn-group btn-bottom"><button class="btn btn-default dropdown-toggle" data-toggle="dropdown">'.$this->crud_model->get_subject_name_by_id($row2['subject_id']).'('.$this->crud_model->get_teacher_name_by_subject_id($row2['subject_id']).')';

                if ($row2['time_start_min'] == 0 && $row2['time_end_min'] == 0)
                    $timeStr = '(' . $row2['time_start'] . '-' . $row2['time_end'] . ')';
                if ($row2['time_start_min'] != 0 || $row2['time_end_min'] != 0)
                    $timeStr = '(' . $row2['time_start'] . ':' . $row2['time_start_min'] . '-' . $row2['time_end'] . ':' . $row2['time_end_min'] . ')';
                $subName = $this->crud_model->get_subject_name_by_id($row2['subject_id']);
                $teacher = $this->Subject_model->get_data_by_cols('teacher_id', array('subject_id' => $row2['subject_id']), 'result_array');

                $rData .= '<div class="btn-group"><button class="btn btn-default dropdown-toggle" data-toggle="dropdown">' . $subName . ' ';

                foreach ($teacher as $value) {
                    $teacher_name = $this->Teacher_model->get_data_by_cols('name', array('teacher_id' => $value['teacher_id']), 'result_array');
                    $name = array_shift($teacher_name);
                    $rData .= array_shift($name);
                }

                $rData .= $timeStr;
                $rData .= '</button></div>';
            }
        }

        $reportData = '';
        foreach ($page_data['subjects'] as $subject) {
            $reports = $this->Progress_model->get_progress_report_data(array('subject_id' => $subject['subject_id'], 'student_id' => $student_id), 'progress_id', 'DESC');

            $reportData .= '<section id="subject_' . $subject['subject_id'] . '">';
            if (!empty($reports)) {
                $reportData .= '<table class="custom_table table display" cellspacing="0" width="100%" id="example23">
                           <thead>
                               <tr>
                                   <th width="15%"><div>' . get_phrase('teacher') . '</div></th>
                                   <th><div>' . get_phrase('rating') . '</div></th>
                                   <th><div>' . get_phrase('comments') . '</div></th>
                                   <th><div>' . get_phrase('date') . '</div></th>
                               </tr>
                           </thead>
                           <tbody>';
                foreach ($reports as $report):
                    $teacher_data = $this->Teacher_model->get_data_by_cols('name', array('teacher_id' => $report['teacher_id']), 'result_array');
                    $reportData .= '<tr><td>' . $teacher_data[0]['name'] . '</td><td>';
                    for ($i = 0; $i <= $report['rate']; $i++) {
                        $reportData .= '<img onclick="javascript:rating(' . $i . ',\'student' . $student_id . '\')" name="student' . $student_id . '-' . $i . '" src=" ' . base_url() . 'uploads/rate' . $i . '.png" alt="Mountain View" >';
                    }
                    for ($i = $report['rate'] + 1; $i < 5; $i++) {
                        $reportData .= '<img onclick="javascript:rating(' . $i . ',\'student' . $student_id . '\')" name="student' . $student_id . '-' . $i . '" src=" ' . base_url() . 'assets/images/Blank_star.png" alt="star View" >';
                    }
                    $reportData .= '</td>';
                    $reportData .= '<td>' . $report['comment'] . '</td><td>' . $report['timestamp'] . '</td></tr>';
                endforeach;
                $reportData .= '</tbody></table>';
            } else {
                $reportData .= '<table class="custom_table table display" cellspacing="0" width="100%">
                         <tbody>
                             <tr>No Data Available</tr>
                         </tbody>
                         </table>';
            }
            $reportData .= '</section>';
        }

        // Attendance Data
        $attData = '';
        $adata = array();
        $status = 0;
        $year1 = explode('-', $runningYr);

        $total_days = 0;
        for ($k = 1; $k <= $page_data['month']; $k++) {
            $present = 0;
            $days = cal_days_in_month(CAL_GREGORIAN, $k, $year1[0]);
            $total_days = $days;
            for ($i = 1; $i <= $days; $i++) {
                $timestamp = strtotime($i . '-' . $k . '-' . $year1[0]);
                $attendance = $this->Attendance_model->get_data_by_cols_groupby('', array('section_id' => $page_data['section_id'], 'class_id' => $page_data['class_id'], 'year' => $year, 'timestamp' => $timestamp, 'student_id' => $student_id), 'result_array', '', '', 'timestamp');

                $status = "";
                foreach ($attendance as $row1):
                    $month_dummy = date('j', $row1['timestamp']);
                    if ($i == $month_dummy) {
                        $status = $row1['status'];
                    }
                    if ($status == 1) {
                        $present = $present + 1;
                    } else if ($status == 2) {
                        
                    } else {
                        
                    }
                endforeach;
            }
            $attData .= '<tr>';
            $attendance_percentege = $present / $total_days * 100;
            $attData .= '<td><b>';
            $attData .= date("F", mktime(0, 0, 0, $k, 1)) . '</b></td><td>' . $total_days . '</td><td>' . round($attendance_percentege, 2) . '%</td></tr>';
        }

        $exams = $this->crud_model->get_exams();
        $marks = '';
        $exam_types = array("FA1", "FA2", "SA1", "FA3", "FA4", "SA2");
        $m = 0;
        $marksData = array();
        foreach ($exams as $row2) {
            $marksData[$m]['marks'] = $row2;
            $subjects = $this->Subject_model->get_data_by_cols('', array('class_id' => $page_data['class_id'], 'year' => $runningYr), 'result_array');

            $k = 0;
            foreach ($subjects as $row3) {
                if (!in_array(strtoupper($row2['name']), $exam_types)) {
                    $obtained_mark_query = $this->Mark_model->get_c_year_mark_obtained_by_subject_exam_class($row3['subject_id'], $row2['exam_id'], $page_data['class_id'], $student_id, $runningYr);

                    $marksData[$m]['marks']['subject'][$k] = $row3;
                    $s = 0;
                    if ($obtained_mark_query > 0) {
                        foreach ($obtained_mark_query as $row4) {
                            $marksData[$m]['marks']['subject'][$k]['obtained'][$s] = $row4;

                            if ($row4['mark_obtained'] >= 0 || $row4['mark_obtained'] != '') {
                                $marksData[$m]['marks']['subject'][$k]['obtained'][$s]['grade'] = $this->crud_model->get_grade($row4['mark_obtained']);
                            }
                            $s++;
                        }
                    }

                    /* $highestMark = $this->crud_model->get_highest_marks($row2['exam_id'], $page_data['class_id'], $row3['subject_id']); */
                    $highestMark = $this->crud_model->get_max_marks($row2['exam_id'], $page_data['class_id'], $row3['subject_id']);
                    $marksData[$m]['marks']['subject'][$k]['mark_total'] = $highestMark;

                    $tot_subjects_data = $this->Subject_model->get_data_by_cols('', array('class_id' => $page_data['class_id'], 'year' => $runningYr), 'result_array');
                    $marksData[$m]['marks']['subject'][$k]['tot_subjects'] = count($tot_subjects_data);
                }

                if (in_array(strtoupper($row2['name']), $exam_types)) {
                    foreach ($exam_types as $examType) {
                        if ($examType == 'FA1' || $examType == 'FA2' || $examType == 'FA3' || $examType == 'FA4') {
                            $examType1 = 'FA';
                        } else {
                            $examType1 = 'SA';
                        }
                        $examData = $this->Exam_model->get_data_by_cols('', array('UPPER(name)' => $examType), 'result_array');
                        if (count($examData) > 0) {
                            $exam_id = $examData->row()->exam_id;
                            $obtained_mark_query = $this->Mark_model->get_c_year_mark_obtained_by_subject_exam_class($row3['subject_id'], $exam_id, $page_data['class_id'], $student_id, $runningYr);

                            $marksData[$m]['marks']['subject'][$k] = $row3;
                            $s = 0;
                            if ($obtained_mark_query > 0) {
                                foreach ($obtained_mark_query as $row4) {
                                    $marksData[$m]['marks']['subject'][$k]['obtained'][$s] = $row4;

                                    if ($row4['mark_obtained'] >= 0 || $row4['mark_obtained'] != '') {
                                        $marksData[$m]['marks']['subject'][$k]['obtained'][$s]['grade'] = $this->crud_model->get_grade_new($row5['mark_obtained'], $examType1);
                                    }
                                    $s++;
                                }
                            }
                            /* $highestMark = $this->crud_model->get_highest_marks($row2['exam_id'], $page_data['class_id'], $row3['subject_id']); */
                            $highestMark = $this->crud_model->get_max_marks($row2['exam_id'], $page_data['class_id'], $row3['subject_id']);
                            //echo $this->db->last_query(); die();
                            $marksData[$m]['marks']['subject'][$k]['mark_total'] = $highestMark;

                            $tot_subjects_data = $this->Subject_model->get_data_by_cols('', array('class_id' => $page_data['class_id'], 'year' => $runningYr), 'result_array');
                            $marksData[$m]['marks']['subject'][$k]['tot_subjects'] = count($tot_subjects_data);
                        }
                    }
                }

                $k++;
            }
            $m++;
        }

        $page_data['student_info'] = $this->crud_model->get_student_info($student_id);

        $page_data['marks_data'] = $marksData;
        //pre($page_data['marks_data']); die();
        $page_data['attendance_report'] = $attData;
        $page_data['report_data'] = $reportData;
        $page_data['routine_data'] = $rData;
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['page_name'] = 'student_profile';
        $page_data['page_title'] = get_phrase('student_profile');
        //pre($page_data); die();
        $this->load->view('backend/index', $page_data);
    }

    function student_export($student_id = '') {
        if ($this->session->userdata('school_admin_login') != 1)
            redirect('login', 'refresh');

        $this->load->model("Dormitory_model");
        $this->load->model("Transport_model");
        $this->load->model("Section_model");
        $this->load->model("Student_model");
        $this->load->model("Book_model");
        $this->load->model("Progress_model");
        $this->load->model("Mark_model");
        $page_data = $this->get_page_data_var();
        $section_id = '';
        $student_personal_info = $this->Student_model->get_student_details_for_excel($student_id);
        //pre($student_personal_info); die;
        $filename = 'uploads/' . time();
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=$filename.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo implode("\t", array_keys((array) $student_personal_info)) . "\r\n";
        echo implode("\t", array_values((array) $student_personal_info)) . "\r\n";

        exit();
    }

    function student_marksheet($student_id = '') {
        if ($this->session->userdata('school_admin_login') != 1)
            redirect('login', 'refresh');

        $this->load->model("Enroll_model");
        $this->load->model("Subject_model");
        $this->load->model("Mark_model");
        $page_data = array();
        $page_data = $this->get_page_data_var();
        $runningYr = $this->globalSettingsRunningYear;
        $classData = $this->Enroll_model->get_data_by_cols('', array('student_id' => $student_id, 'year' => $runningYr));

        $class_id = @$classData[0]->class_id;
        $studentData = $this->Student_model->get_data_by_id($student_id, 'name');
        $student_name = @$studentData[0]->name;

        $classData1 = $this->Class_model->get_data_by_id($class_id, 'name');
        $class_name = @$classData1[0]->name;

        $exams = $this->crud_model->get_exams();
        $marks = '';
        $m = 0;
        $marksData = array();
        foreach ($exams as $row2) {
            $marksData[$m]['marks'] = $row2;
            $subjects = $this->Subject_model->get_data_by_cols('', array('class_id' => $class_id, 'year' => $runningYr), 'result_array');
            $exam_types = array("FA1", "FA2", "SA1", "FA3", "FA4", "SA2");
            $k = 0;
            foreach ($subjects as $row3) {
                if (!in_array(strtoupper($row2['name']), $exam_types)) {
                    $obtained_mark_query = $this->Mark_model->get_c_year_mark_obtained_by_subject_exam_class($row3['subject_id'], $row2['exam_id'], $class_id, $student_id, $runningYr);

                    $marksData[$m]['marks']['subject'][$k] = $row3;
                    $s = 0;
                    if ($obtained_mark_query > 0) {
                        foreach ($obtained_mark_query as $row4) {
                            $marksData[$m]['marks']['subject'][$k]['obtained'][$s] = $row4;

                            if ($row4['mark_obtained'] >= 0 || $row4['mark_obtained'] != '') {
                                $marksData[$m]['marks']['subject'][$k]['obtained'][$s]['grade'] = $this->crud_model->get_grade($row4['mark_obtained']);
                            }
                            $s++;
                        }
                    }

                    $highestMark = $this->crud_model->get_highest_marks($row2['exam_id'], $class_id, $row3['subject_id']);
                    $marksData[$m]['marks']['subject'][$k]['highest_mark'] = $highestMark;

                    $tot_subjects_data = $this->Subject_model->get_data_by_cols('', array('class_id' => $class_id, 'year' => $runningYr), 'result_array');
                    $marksData[$m]['marks']['subject'][$k]['tot_subjects'] = count($tot_subjects_data);
                }

                if (in_array(strtoupper($row2['name']), $exam_types)) {
                    $examData = $this->Exam_model->get_data_by_cols('', array('UPPER(name)' => "FA1"), 'result_array');
                    if (count($examData) > 0) {
                        $exam_id = $examData->row()->exam_id;
                        $obtained_mark_query = $this->Mark_model->get_c_year_mark_obtained_by_subject_exam_class($row3['subject_id'], $exam_id, $class_id, $student_id, $runningYr);

                        $marksData[$m]['marks']['subject'][$k] = $row3;
                        $s = 0;
                        if ($obtained_mark_query > 0) {
                            foreach ($obtained_mark_query as $row4) {
                                $marksData[$m]['marks']['subject'][$k]['obtained'][$s] = $row4;

                                if ($row4['mark_obtained'] >= 0 || $row4['mark_obtained'] != '') {
                                    $marksData[$m]['marks']['subject'][$k]['obtained'][$s]['grade'] = $this->crud_model->get_grade($row4['mark_obtained']);
                                }
                                $s++;
                            }
                        }

                        $highestMark = $this->crud_model->get_highest_marks($row2['exam_id'], $class_id, $row3['subject_id']);
                        $marksData[$m]['marks']['subject'][$k]['highest_mark'] = $highestMark;

                        $tot_subjects_data = $this->Subject_model->get_data_by_cols('', array('class_id' => $class_id, 'year' => $runningYr), 'result_array');
                        $marksData[$m]['marks']['subject'][$k]['tot_subjects'] = count($tot_subjects_data);
                    }
                }

                $k++;
            }
            $m++;
        }

        //pre($marksData); die;
        $page_data['marks_data'] = $marksData;
        $page_data['student_info'] = $this->crud_model->get_student_info($student_id);

        $page_data['page_name'] = 'student_marksheet';
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['page_title'] = get_phrase('marksheet_for') . ' ' . $student_name . ' (' . get_phrase('class') . ' ' . $class_name . ')';
        $page_data['student_id'] = $student_id;
        $page_data['class_id'] = $class_id;
        $page_data['subjects'] = $this->Subject_model->get_data_by_cols("*", array('class_id' => $page_data['class_id'], 'year' => $runningYr), "result_array");
        $page_data['exam_id'] = $this->Exam_model->get_data_by_cols('*', array('UPPER(name)' => "FA1"));

        $this->load->view('backend/index', $page_data);
    }

    function student_marksheet_print_view($student_id, $exam_id) {
        if ($this->session->userdata('school_admin_login') != 1)
            redirect('login', 'refresh');

        $this->load->model("Student_model");
        $this->load->model("Exam_model");
        $this->load->model("Setting_model");
        $this->load->model("Student_model");
        $this->load->model("Subject_model");
        $this->load->model("Mark_model");
        $page_data = $this->get_page_data_var();
        $running_year = $this->globalSettingsRunningYear;
        $class_id = $this->Student_model->get_enroll_record(array('student_id' => $student_id, 'year' => $running_year), "class_id");
        $class_name = $this->Class_model->get_class_record(array('class_id' => $class_id), "name");

        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['student_id'] = $student_id;
        $page_data['class_id'] = $class_id;
        $page_data['exam_id'] = $exam_id;

        $page_data['class_name'] = $this->Class_model->get_name_by_id($class_id);
        $page_data['exam_name'] = $this->Exam_model->get_name_by_id($exam_id);
        //$page_data['system_name'] =  $this->Setting_model->get_setting_record(array('type'=>'system_name'), 'description');
        //$page_data['running_year'] =  $this->Setting_model->get_setting_record(array('type'=>'running_year'), 'description');
        $page_data['student_name'] = $this->Student_model->get_student_name($student_id);

        $page_data['subjects'] = $this->Subject_model->get_subject_array(array(
            'class_id' => $class_id, 'year' => $page_data['running_year']));
        //pre($page_data['subjects']);
        $total_grade_point = 0;

        if (count($page_data['subjects'])) {
            foreach ($page_data['subjects'] as $k => $subject):
                $marks = $this->Mark_model->get_c_year_mark_obtained_by_subject_exam_class($subject['subject_id'], $exam_id, $class_id, $student_id, $page_data['running_year']);
                if (count($marks)) {
                    $page_data['subjects'][$k]['marks'] = $marks;
                    //pre($marks); 
                    foreach ($marks as $mark) {
                        $grade = $this->crud_model->get_grade($mark['mark_obtained']);
                        //pre($grade); //die();
                        $page_data['subjects'][$k]['marks'] = $marks;

                        $page_data['subjects'][$k]['grade_name'] = $grade['name'];
                        $total_grade_point = $grade['grade_point'];
                        if ($mark['comment'] == '') {
                            $page_data['subjects'][$k]['comment'] = 'No Comment';
                        } else {
                            $page_data['subjects'][$k]['comment'] = $mark['comment'];
                        }
                        /* $page_data['subjects'][$k]['comment'] = $mark['comment']; */
                    }
                }

                $page_data['subjects'][$k]['highest_mark'] = $this->crud_model->get_highest_marks($exam_id, $class_id, $subject['subject_id']);

            endforeach; 
        }

        $number_of_subjects = $this->Subject_model->get_average_grade_point($class_id, $page_data['running_year']);

        $page_data['average_grade_point'] = ($total_grade_point / $number_of_subjects);
        //pre($page_data);
        $this->load->view('backend/school_admin/student_marksheet_print_view', $page_data);
    }

    function student($param1 = '', $param2 = '', $param3 = '') {

        if ($this->session->userdata('school_admin_login') != 1)
            redirect('login', 'refresh');
        $this->config->load('country_list', true);
        $page_data = $this->get_page_data_var();
        $country_name = $this->config->item('countries', 'country_list');
        $running_year = $this->globalSettingsRunningYear;
        $page_data['countries'] = $country_name;

        $this->load->model("Parent_model");
        $this->load->model("Class_model");
        $this->load->model("Dormitory_model");
        $this->load->model("Transport_model");
        $parents_array = $this->Parent_model->get_parents_array();
        $class_array = $this->Class_model->get_class_array();
        $dormitory_array = $this->Dormitory_model->get_dormitory_array();
        $transport_array = $this->Transport_model->get_transport_array();

        if ($param1 == 'create') {
            $form_id = 1;
            $this->validate_dynamic($form_id);
            if ($this->form_validation->run() == FALSE) {// print_r(validation_errors());die("cp1");
                $this->session->set_flashdata('flash_validation_error', validation_errors());

                $this->load->library('Fi_functions');
                $running_year = $this->globalSettingsRunningYear;
                $scholarships = $this->fi_functions->getScholarships($running_year);
                if ($scholarships) {
                    $page_data['scholarships'] = $scholarships;
                }
                $active_installments = $this->fi_functions->getActiveInstallments($running_year);

                $school_fee_inst = array();
                $transp_fee_inst = array();
                $hostel_fee_inst = array();
                if ($active_installments) {
                    $val = $active_installments[0];
                    $school_fee_installment_ids = explode(',', $val['schoolfee_inst_types']);
                    $transp_fee_installment_ids = explode(',', $val['transfee_inst_types']);
                    $hostel_fee_installment_ids = explode(',', $val['hostelfee_inst_types']);

                    foreach ($school_fee_installment_ids as $school_fee_inst_id) {
                        $result = $this->fi_functions->get_installments($school_fee_inst_id);
                        $school_fee_inst[] = $result[0];
                    }

                    foreach ($transp_fee_installment_ids as $transp_fee_inst_id) {
                        $result = $this->fi_functions->get_installments($transp_fee_inst_id);
                        $transp_fee_inst[] = $result[0];
                    }

                    foreach ($hostel_fee_installment_ids as $hostel_fee_inst_id) {
                        $result = $this->fi_functions->get_installments($hostel_fee_inst_id);
                        $hostel_fee_inst[] = $result[0];
                    }
                }
                $fee_installment = array('school_fee_inst' => $school_fee_inst, 'transp_fee_inst' => $transp_fee_inst, 'hostel_fee_inst' => $hostel_fee_inst);
                $page_data['fee_installment'] = $fee_installment;
                $page_data['parents'] = $parents_array;
                $page_data['classes'] = $class_array;
                $page_data['dormitories'] = $dormitory_array;
                $page_data['transports'] = $transport_array;
                $arr = array();
                $form_id = 1;
                $arr = $this->set_dynamic_form($form_id);
                foreach ($arr as $key => $value) {
                    $page_data[$key] = $value;
                }
                $page_data['page_name'] = 'student_add';
                $page_data['page_title'] = get_phrase('add_student');
                $this->load->view('backend/index', $page_data);
            } else { //echo "here";die("cp2");
                $data['name'] = $this->input->post('name');
                $bday = $this->input->post('birthday');
                $data['birthday'] = date('d-m-Y', strtotime($bday));
                $data['sex'] = $this->input->post('sex');
                $data['address'] = $this->input->post('address');
                $data['city'] = $this->input->post('city');
                $data['caste_category'] = $this->input->post('category');
                $data['phone'] = $this->input->post('phone');
                $data['card_id'] = $this->input->post('card_id');
                $data['email'] = $this->input->post('email');
                $data['blood_group'] = $this->input->post('blood_group');
                $data['emirates_id'] = $this->input->post('emirates_id');
                $data['visa_no'] = $this->input->post('visa_no');
                $data['visa_expiry_date'] = $this->input->post('visa_expiry_date');
                $data['passport_expiry_date'] = $this->input->post('passport_expiry_date');
                $data['allergies'] = $this->input->post('allergies');
                $password = $this->input->post('password');
                $data['password'] = sha1($password);
                $parent_email = $this->input->post('parent');

                $stu_password = create_passcode('student');
                $data['password'] = ($stu_password != 'invalid') ? sha1($stu_password) : '';
                $data['passcode'] = ($stu_password != 'invalid') ? $stu_password : '';

                $parent_email = $this->input->post('parent'); //echo $parent_email; exit;

                $data['parent_id'] = $this->Parent_model->get_parent_id($parent_email);
                if ($this->input->post('dormitory_id') != "")
                    $data['dormitory_id'] = $this->input->post('dormitory_id');
                if ($this->input->post('transport_id') != "")
                    $data['transport_id'] = $this->input->post('transport_id');
                $data['mname'] = $this->input->post('mname');
                $data['lname'] = $this->input->post('lname');
                $data['passport_no'] = $this->input->post('passport_no');
                $data['country'] = $this->input->post('country');
                $data['nationality'] = $this->input->post('nationality');
                $data['type'] = $this->input->post('type');
                $data['icard_no'] = $this->input->post('icard_no');
                $data['place_of_birth'] = $this->input->post('place_of_birth');
                //$data['previous_class'] = $this->input->post('previous_class');
                $data['previous_school'] = $this->input->post('previous_school');
                $data['course'] = $this->input->post('course');
                $data['media_consent'] = $this->input->post('media_consent');
                $data['location'] = $this->input->post('searchLocation');
                $latitude = $this->input->post('searchLat');
                $longitude = $this->input->post('searchLong');
                $data['loc_cords'] = $latitude . "," . $longitude;
                $data['isActive'] = '1';
                $data['date_time'] = date("Y-m-d H:i:s");
                $page_data['added_data'] = $this->input->post('name');
                if (is_section_available_for_admission($this->input->post('class_id'), $this->input->post('section_id'), $running_year) == 0) {
                    $page_data['parents'] = $parents_array;
                    $page_data['classes'] = $class_array;
                    $page_data['dormitories'] = $dormitory_array;
                    $page_data['transports'] = $transport_array;
                    $page_data['page_name'] = 'student_add';

                    $page_data['page_title'] = get_phrase('add_student');
                    $this->load->view('backend/index', $page_data);
                } else if (is_section_available_for_admission($this->input->post('class_id'), $this->input->post('section_id'), $running_year) == 1) {
                    $this->session->set_flashdata('flash_message', get_phrase('student_admitted'));
                }

                if(($data['email'] == "") && ($data['name']!='')){
                    //$email = $parant_email;
                    $email = strtolower($data['name'].'@'.CURRENT_INSTANCE.'.com');
                    $data['email'] = $email; 
                }else{
                    $email = $data['email'];
                }

                $student_id = $this->Student_model->save_student($data);

                $stud_image = '';
                if ($_FILES['userfile']['name'] != '') {
                    $img = $_FILES['userfile']['name'];
                    $img = explode(".", $img);
                    $stud_image = $student_id . "." . end($img);
                    move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $stud_image);
                    copy('uploads/student_image/' . $stud_image, 'fi/sysfrm/uploads/user-pics/' . $stud_image);
                }

                $this->Student_model->update_student(array('stud_image' => $stud_image), array("student_id" => $student_id));
                /* finance module account creation start for student start */

                $class_id = $this->input->post('class_id');
                $this->load->library('Fi_functions');
                $tution_fee_det = $this->fi_functions->get_fee_detailsbygroup($class_id);
                if ($tution_fee_det)
                    $tution_fee_id = $tution_fee_det['id'];
                else
                    $tution_fee_id = 0;
                $scholarship_id = $this->input->post('scholarship_id');
                $hostfee_inst_type = $this->input->post('hostfee_inst_type');
                $transpfee_inst_type = $this->input->post('transpfee_inst_type');
                $tutionfee_inst_type = $this->input->post('tutionfee_inst_type');
                $dormitory_fee_id = $this->input->post('dormitory_fee_id');
                $transport_fee_id = $this->input->post('transport_fee_id');

                $parentname = $this->Parent_model->get_data_by_cols('*', array('parent_id' => $data['parent_id']));
                $sname = $parentname[0]->father_name . " " . $parentname[0]->father_lname;
                $parant_email = $parentname[0]->email;                

                $data3['id'] = $student_id;
                $data3['account'] = $data['name'];
                $data3['fname'] = '';
                $data3['company'] = $sname;
                $data3['lname'] = $data['lname'];
                $data3['gid'] = $this->input->post('class_id');
                $data3['email'] = $email;
                $data3['second_email'] = $parant_email;
                $data3['address'] = $data['address'];
                $data3['phone'] = $data['phone'];
                $data3['img'] = $stud_image;
                $data3['city'] = $data['location'];
                $data3['country'] = $data['nationality'];
                $data3['dob'] = date("Y-m-d", strtotime($data['birthday']));
                //$data3['password']          =  sha1( $password );
                $data3['password'] = ($stu_password != 'invalid') ? sha1($stu_password) : '';

                $message = array();
                $message['sms_message'] = "Welcome To " . $this->globalSettingsSystemName . " " . $sname . ", Your admission procedure is started. Your passcode for app is " . $data['passcode'] . " and email id is ".$data['email']." download app here https://play.google.com/store/apps/details?id=" . $this->globalSettingsAppPackageName . "&hl=en";
                ;
                $message['subject'] = "Admission has been started to the " . $this->globalSettingsSystemName;
                $message['messagge_body'] = "<br><br>Welcome To " . $this->globalSettingsSystemName . " " . $sname . " Your Child's admission procedure is started.<br><br><br><br><br>With regards";
                $message['to_name'] = $sname;
                if ($parant_email != '')
                    $email = array($parant_email);
                else
                    $email = '';
                send_school_notification('new_user', $message, array($data['phone']), $email);

                $finance_det = array(
                    'student_id' => $student_id,
                    'academic_year' => $running_year,
                    'tution_fee_id' => ($tution_fee_id != '' ? $tution_fee_id : 0),
                    'trans_fee_id' => ($transport_fee_id != '' ? $transport_fee_id : 0),
                    'hostel_fee_id' => ($dormitory_fee_id != '' ? $dormitory_fee_id : 0),
                    'scholarship_id' => ($scholarship_id != '' ? $scholarship_id : 0),
                    'tutionfee_inst_type' => ($tutionfee_inst_type != '' ? $tutionfee_inst_type : 0),
                    'transpfee_inst_type' => ($transpfee_inst_type != '' ? $transpfee_inst_type : 0),
                    'hostfee_inst_type' => ($hostfee_inst_type != '' ? $hostfee_inst_type : 0),
                    'created_by' => $this->session->userdata('user_id')
                );
                $finance_stud_config = $this->Student_model->add_student_fee_det($finance_det);

                $this->load->model("Enroll_model");
                $last_roll_no = $this->Enroll_model->get_latest_roll_no($this->input->post('class_id'), $this->input->post('section_id'));

                //die($last_roll_no);
                $last_roll_no++;

                $finance = $this->Student_model->create_finance_customer_account($data3);
                /* finance module account creation start for student end */
                $data2['student_id'] = $student_id;

                $data2['roll'] = $last_roll_no; //substr(md5(rand(0, 1000000)), 0, 7);
                $data2['class_id'] = $this->input->post('class_id');
                if ($this->input->post('section_id') != '') {
                    $data2['section_id'] = $this->input->post('section_id');
                }

                $data2['enroll_code'] = $this->input->post('roll');
                $data2['date_added'] = strtotime(date("Y-m-d H:i:s"));
                $data2['year'] = $running_year;
                $enroll_id = $this->Student_model->enroll_student($data2);

                $this->generate_admission_invoice($student_id);
                $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
                $this->Email_model->account_opening_email('student', $data['email'], $this->input->post('password')); //SEND EMAIL ACCOUNT OPENING EMAIL
                //echo "here";die('cp3');
                redirect(base_url() . 'index.php?school_admin/student_add/', 'refresh');
            }
        }

        if ($param1 == 'do_update') {
            $is_admission_unq = $this->input->post('admission_no') != $this->input->post('old_admission_no') ? '|is_unique[student.admission_no]' : '';
            $this->form_validation->set_rules('admission_no', 'Admission No.', 'trim' . $is_admission_unq);
            if ($this->form_validation->run() == FALSE) {// print_r(validation_errors());die("cp1");
                $this->session->set_flashdata('flash_message_error', validation_errors());
                redirect(base_url('index.php?school_admin/student_information'));
            }

            $data['admission_no'] = $this->input->post('admission_no');
            $data['name'] = $this->input->post('name');
            $bday = $this->input->post('birthday');
            $data['birthday'] = date('d-m-Y', strtotime($bday));
            $data['sex'] = $this->input->post('sex');
            $data['address'] = $this->input->post('address');
            $data['phone'] = $this->input->post('phone');
            //$data['email'] = $this->input->post('email');
            $data['card_id'] = $this->input->post('card_id');
            $data['parent_id'] = $this->input->post('parent_id');
            if ($this->input->post('dormitory_id') != "")
                $data['dormitory_id'] = $this->input->post('dormitory_id');
            if ($this->input->post('transport_id') != "")
                $data['transport_id'] = $this->input->post('transport_id');
            $data['mname'] = $this->input->post('mname');
            $data['lname'] = $this->input->post('lname');
            $data['passport_no'] = $this->input->post('passport_no');
            $data['country'] = $this->input->post('country');
            $data['nationality'] = $this->input->post('nationality');
            $data['type'] = $this->input->post('type');
            $data['icard_no'] = $this->input->post('icard_no');
            $data['place_of_birth'] = $this->input->post('place_of_birth');
            $data['previous_school'] = $this->input->post('previous_school');
            $data['media_consent'] = $this->input->post('media_consent');
            $data['course'] = $this->input->post('course');
            $data['emirates_id'] = $this->input->post('emirates_id');
            $data['visa_no'] = $this->input->post('visa_no');
            $data['visa_expiry_date'] = $this->input->post('visa_expiry_date');
            $data['passport_expiry_date'] = $this->input->post('passport_expiry_date');
            $data['allergies'] = $this->input->post('allergies');
            $data['change_time'] = date("Y-m-d H:i:s");


            $types = array('image/jpeg', 'image/gif', 'image/png');
            if ($_FILES['userfile']['name'] != '') {
                if (in_array($_FILES['userfile']['type'], $types)) {
                    $img = $_FILES['userfile']['name'];
                    $img = explode(".", $img);
                    $data['stud_image'] = $param2 . "." . end($img);
                    if ($this->Student_model->update_student($data, array("student_id" => $param2))) {
                        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $data['stud_image']);
                        copy('uploads/student_image/' . $data['stud_image'], 'fi/sysfrm/uploads/user-pics/' . $data['stud_image']);
                        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
                    }
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('It may be the wrong filetype. We only allow JPG, GIF, and PNG filetypes!!'));
                    //redirect(base_url() . 'index.php?school_admin/student_information/' , 'refresh');
                }
            } else {
                //$data['stud_image'] = $this->input->post('image');
                $this->Student_model->update_student($data, array("student_id" => $param2));
                //echo $data['image']; exit;
                $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
                // redirect(base_url() . 'index.php?school_admin/student_information/' , 'refresh');
            }
//                $config['upload_path']      =   'uploads/student_image';
//                    $config['max_size']         =   1024 * 10;
//                    $config['allowed_types']    =    'gif|png|jpg|jpeg';
//                    $config['encrypt_name']     = TRUE;
//
//                    $this->load->library('upload', $config);



            /*             * ************update fi data start************* */

            $parentname = $this->Parent_model->get_data_by_cols('*', array('parent_id' => $data['parent_id']));
            $sname = $parentname[0]->father_name . " " . $parentname[0]->father_lname;
            $parant_email = $parentname[0]->email;
            $data3['account'] = $data['name'];
            $data3['company'] = $sname;
            $data3['fname'] = '';
            $data3['lname'] = $data['lname'];
            $data3['address'] = $data['address'];
            $data3['phone'] = $data['phone'];
            $data3['img'] = (isset($data['stud_image']) ? $data['stud_image'] : '');
            $data3['country'] = $data['nationality'];
            $data3['second_email'] = $parant_email;
            $data3['dob'] = date("Y-m-d", strtotime($data['birthday']));
            $this->Student_model->update_finance_customer_account($data3, array("id" => $param2));
            /*             * ************update fi data end************* */

            $data2['section_id'] = $this->input->post('section_id');
            $data2['enroll_code'] = $this->input->post('roll');


            $enroll_data = array(
                'section_id' => $data2['section_id'],
            );
            $classArr = $this->Section_model->get_data_by_cols("class_id", $enroll_data);

            $enroll_cond = array(
                "student_id" => $param2,
                "year" => $this->globalSettingsRunningYear
            );
            $this->Student_model->update_enroll($enroll_data, $enroll_cond);


            //$this->crud_model->clear_cache();

            if (empty($classArr[0])) {

                $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
                redirect(base_url() . 'index.php?school_admin/student_information/', 'refresh');
            } else {
                $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
                redirect(base_url() . 'index.php?school_admin/student_information/' . $classArr[0]->class_id, 'refresh');
            }
        }

        if ($param1 == 'delete') {
            $class_id = $this->uri->segment(5);
            $dataArray = array('student_id' => $param2);
            if ($this->Student_model->delete_student($dataArray)) {

                $this->session->set_flashdata('flash_message', get_phrase('data_successfully_deleted'));
                redirect(base_url() . 'index.php?school_admin/student_information/' . $class_id, 'refresh');
            }

            // $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
            // redirect(base_url() . 'index.php?school_admin/student_information/' . $param1, 'refresh');
        }

        if (($param1 == 'ToggleEnable') && ($param3 != '')) {
            $dataArray = array('student_id' => $param2, 'status' => $param3);
            if ($this->Student_model->do_toggle_enable_student($dataArray)) {
                if ($param3 == 1) {
                    $this->session->set_flashdata('flash_message', get_phrase('student_disabled_successfully'));
                    echo 'Disabled';
                } else {
                    $this->session->set_flashdata('flash_message', get_phrase('student_enabled_successfully'));
                    echo 'Enabled';
                }
            }
        }
    }

    /**
     * 
     * @param type $param1
     * @param type $param2
     */
    function student_promotion($param1 = '', $param2 = '') {
        if ($this->session->userdata('school_admin_login') != 1)
            redirect('login', 'refresh');
        $this->load->model("Class_model");
        $page_data = $this->get_page_data_var();
        $class_array = $this->Class_model->get_class_array();
        if ($param1 == 'promote') {
            $running_year = $this->input->post('running_year');
            $from_class_id = $this->input->post('promotion_from_class_id');
            $from_section_id = $this->input->post('from_section_id');
            $to_section_id = $this->input->post('to_section_id');
            $student_id_s = $this->input->post('student_ids');

            $route_id = $this->input->post('route_id');
            $room_id = $this->input->post('room_id');
            $transp_fee_ids = $this->input->post('transp_fee_id');
            $hostel_fee_ids = $this->input->post('hostel_fee_id');
            $hostel_fee_insts = $this->input->post('hostel_fee_inst');
            $transp_fee_insts = $this->input->post('transp_fee_inst');
            $school_fee_insts = $this->input->post('school_fee_inst');
            $scholarship_ids = $this->input->post('scholarship_id');

            if (!$student_id_s) {
                $this->session->set_flashdata('flash_message_error', get_phrase('please_select_atleast_one_student'));
                redirect(base_url() . 'index.php?school_admin/student_promotion', 'refresh');
            }

            $dataArray = array(
                'class_id' => $from_class_id,
                'year' => $running_year,
                'section_id' => $from_section_id
            );

            $students_of_promotion_class = $this->Student_model->get_enroll_records($dataArray);

            $i = 0;
            foreach ($students_of_promotion_class as $row) {
                $i++;
                if (count($student_id_s) > 0) {
                    if (in_array($row['student_id'], $student_id_s)) {
                        $key = array_search($row['student_id'], $student_id_s);
                        $enroll_data['student_id'] = $student_id_s[$key];
                    } else {
                        continue;
                    }
                } else {
                    $enroll_data['student_id'] = $row['student_id'];
                }
                $enroll_data['enroll_code'] = substr(md5(rand(0, 1000000)), 0, 7);
                $count_enrolled = '';

                $promotion_year = $this->input->post('promotion_year');
                $already_enrolled = $this->Enroll_model->get_data_by_cols('*', array('student_id' => $row['student_id'], 'year' => $promotion_year, 'result_array'));
                $count_enrolled = count($already_enrolled);
                if ($count_enrolled == 0) {
                    $enroll_data['class_id'] = $this->input->post('promotion_status_' . $row['student_id']);
                    if ($enroll_data['class_id'] == $from_class_id) {
                        $enroll_data['section_id'] = $from_section_id;
                    } else {
                        $enroll_data['section_id'] = $to_section_id;
                    }
                    $enroll_data['year'] = $this->input->post('promotion_year');
                    $enroll_data['date_added'] = strtotime(date("Y-m-d H:i:s"));
                    $enroll_id = $this->Student_model->enroll_student($enroll_data);

                    /* enroll student fee config for finance settings */
                    $this->load->library('Fi_functions');
                    $tution_fee_det = $this->fi_functions->get_fee_detailsbygroup($enroll_data['class_id']);
                    if ($tution_fee_det)
                        $tution_fee_id = $tution_fee_det['id'];
                    else
                        $tution_fee_id = 0;

                    $transport_fee_id = ($transp_fee_ids[$row['student_id']] != '' ? $transp_fee_ids[$row['student_id']] : 0);
                    $dormitory_fee_id = ($hostel_fee_ids[$row['student_id']] != '' ? $hostel_fee_ids[$row['student_id']] : 0);
                    $scholarship_id = ($scholarship_ids[$row['student_id']] != '' ? $scholarship_ids[$row['student_id']] : 0);
                    $tutionfee_inst_type = ($school_fee_insts[$row['student_id']] != '' ? $school_fee_insts[$row['student_id']] : 0);
                    $transpfee_inst_type = ($transp_fee_insts[$row['student_id']] != '' ? $transp_fee_insts[$row['student_id']] : 0);
                    $hostfee_inst_type = ($hostel_fee_insts[$row['student_id']] != '' ? $hostel_fee_insts[$row['student_id']] : 0);

                    $finance_det = array(
                        'student_id' => $row['student_id'],
                        'academic_year' => $promotion_year,
                        'tution_fee_id' => $tution_fee_id,
                        'trans_fee_id' => $transport_fee_id,
                        'hostel_fee_id' => $dormitory_fee_id,
                        'scholarship_id' => $scholarship_id,
                        'tutionfee_inst_type' => $tutionfee_inst_type,
                        'transpfee_inst_type' => $transpfee_inst_type,
                        'hostfee_inst_type' => $hostfee_inst_type,
                        'created_by' => $this->session->userdata('user_id')
                    );

                    $student_det = $this->Student_model->get_student_details($row['student_id']);

                    $stud_det['gid'] = $student_det->class_id;
                    $stud_det['section_id'] = $student_det->section_id;
                    $this->fi_functions->updateStudent_inFinance($row['student_id'], $stud_det);

                    $finance_stud_config = $this->Student_model->add_student_fee_det($finance_det);
                    $this->generate_admission_invoice($row['student_id'], $promotion_year);
                }
            }
            $this->session->set_flashdata('flash_message', get_phrase('new_enrollment_successfull'));
            redirect(base_url() . 'index.php?school_admin/student_promotion', 'refresh');
        }
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['classes'] = $class_array;
        $page_data['page_title'] = get_phrase('student_promotion');
        $page_data['page_name'] = 'student_promotion';
        $page_data['class_array'] = $this->Class_model->get_class_array();
        $this->load->view('backend/index', $page_data);
    }

    /*
     * student fee configration
     */

    public function student_fee_configuration($action = '') {
        if ($this->session->userdata('school_admin_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();

        //echo '<pre>';print_r($page_data);exit;
        if ($action == 'add_student_det') {
            if (!$this->new_fi) {
                $route_id = $this->input->post('route_id');
                $room_id = $this->input->post('room_id');
                $transp_fee_ids = $this->input->post('transp_fee_id');
                $hostel_fee_ids = $this->input->post('hostel_fee_id');
                $hostel_fee_insts = $this->input->post('hostel_fee_inst');
                $transp_fee_insts = $this->input->post('transp_fee_inst');
                $school_fee_insts = $this->input->post('school_fee_inst');
                $scholarship_ids = $this->input->post('scholarship_id');

                $class_id = $this->input->post('class_id');
                $section_id = $this->input->post('section_id');
                $student_ids = $this->input->post('student_ids');

                $this->load->library('Fi_functions');
                $tution_fee_det = $this->fi_functions->get_fee_detailsbygroup($class_id);
                if ($tution_fee_det)
                    $tution_fee_id = $tution_fee_det['id'];
                else
                    $tution_fee_id = 0;
                foreach ($student_ids as $student_id) {
                    /* enroll student fee config for finance settings */
                    $transport_fee_id = ($transp_fee_ids[$student_id] != '' ? $transp_fee_ids[$student_id] : 0);
                    $dormitory_fee_id = ($hostel_fee_ids[$student_id] != '' ? $hostel_fee_ids[$student_id] : 0);
                    $scholarship_id = ($scholarship_ids[$student_id] != '' ? $scholarship_ids[$student_id] : 0);
                    $tutionfee_inst_type = ($school_fee_insts[$student_id] != '' ? $school_fee_insts[$student_id] : 0);
                    $transpfee_inst_type = ($transp_fee_insts[$student_id] != '' ? $transp_fee_insts[$student_id] : 0);
                    $hostfee_inst_type = ($hostel_fee_insts[$student_id] != '' ? $hostel_fee_insts[$student_id] : 0);

                    $running_year = $this->globalSettingsRunningYear;

                    $finance_det = array(
                        'student_id' => $student_id,
                        'academic_year' => $running_year,
                        'tution_fee_id' => $tution_fee_id,
                        'trans_fee_id' => $transport_fee_id,
                        'hostel_fee_id' => $dormitory_fee_id,
                        'scholarship_id' => $scholarship_id,
                        'tutionfee_inst_type' => $tutionfee_inst_type,
                        'transpfee_inst_type' => $transpfee_inst_type,
                        'hostfee_inst_type' => $hostfee_inst_type,
                        'created_by' => $this->session->userdata('user_id')
                    );

                    $finance_stud_config = $this->Student_model->add_student_fee_det($finance_det);
                    $this->generate_admission_invoice($student_id, $running_year);
                }
                $this->session->set_flashdata('flash_message', get_phrase('fee_configured_successfully'));
            } else {
                //echo '<pre>';print_r($_POST);exit;

                $this->load->model('fees/Fees_model');
                $class_id = $this->input->post('class_id');
                $section_id = $this->input->post('section_id');
                $student_ids = $this->input->post('student_ids') ? $this->input->post('student_ids') : array();

                $hostel_ids = $this->input->post('hostel_ids');
                $room_ids = $this->input->post('room_ids');
                $hostel_term_selected = $this->input->post('hostel_term_selected');

                $route_ids = $this->input->post('route_ids');
                $route_stop_ids = $this->input->post('route_stop_ids');
                $transport_term_selected = $this->input->post('transport_term_selected');

                $school_term_selected = $this->input->post('school_term_selected');
                $scholarship_ids = $this->input->post('scholarship_ids');

                foreach ($student_ids as $student_id) {
                    $fee_stu_config = array(
                        'student_id' => $student_id,
                        'running_year' => $_SESSION['running_year'],
                        'school_term_id' => (isset($school_term_selected[$student_id]) ? $school_term_selected[$student_id] : 0),
                        'room_id' => (isset($room_ids[$student_id]) ? $room_ids[$student_id] : 0),
                        'hostel_term_id' => (isset($hostel_term_selected[$student_id]) ? $hostel_term_selected[$student_id] : 0),
                        'route_stop_id' => (isset($route_stop_ids[$student_id]) ? $route_stop_ids[$student_id] : 0),
                        'transport_term_id' => (isset($transport_term_selected[$student_id]) ? $transport_term_selected[$student_id] : 0),
                        'scholarship_id' => (isset($scholarship_ids[$student_id]) ? $scholarship_ids[$student_id] : 0),
                        'school_id' => $_SESSION['school_id'],
                        'created' => date('Y-m-d H:i:s')
                    );

                    $this->Fees_model->save_stu_config($fee_stu_config);
                    //$this->generate_admission_invoice($student_id, $running_year);
                }
                $this->session->set_flashdata('flash_message', get_phrase('fee_configured_successfully'));
            }

            redirect(base_url() . 'index.php?school_admin/student_fee_configuration');
        }
        $class_array = $this->Class_model->get_class_array();
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['classes'] = $class_array;
        $page_data['page_title'] = get_phrase('student_fee_configuration');
        $page_data['page_name'] = 'student_fee_configuration';
        $this->load->view('backend/index', $page_data);
    }

    public function get_students_setfee($class_id, $section_id, $running_year) {
        $page_data = array();
        $page_data = $this->get_page_data_var();
        $page_data['class_id'] = $class_id;
        $page_data['section_id'] = $section_id;
        $page_data['running_year'] = $running_year;

        $this->load->library('Fi_functions');
        $scholarships = $this->fi_functions->getScholarships($running_year);
        if ($scholarships) {
            $page_data['scholarships'] = $scholarships;
        }
        $active_installments = $this->fi_functions->getActiveInstallments($running_year);

        $this->load->model("Dormitory_model");
        $this->load->model("Transport_model");
        $this->load->model("Student_model");
        $this->load->model("Class_model");

        $dormitory_array = $this->Dormitory_model->get_dormitory_array();
        $transport_array = $this->Transport_model->get_transport_array();

        $school_fee_inst = array();
        $transp_fee_inst = array();
        $hostel_fee_inst = array();
        if ($active_installments) {
            $val = $active_installments[0];
            $school_fee_installment_ids = explode(',', $val['schoolfee_inst_types']);
            $transp_fee_installment_ids = explode(',', $val['transfee_inst_types']);
            $hostel_fee_installment_ids = explode(',', $val['hostelfee_inst_types']);

            foreach ($school_fee_installment_ids as $school_fee_inst_id) {
                $result = $this->fi_functions->get_installments($school_fee_inst_id);
                $school_fee_inst[] = $result[0];
            }

            foreach ($transp_fee_installment_ids as $transp_fee_inst_id) {
                $result = $this->fi_functions->get_installments($transp_fee_inst_id);
                $transp_fee_inst[] = $result[0];
            }

            foreach ($hostel_fee_installment_ids as $hostel_fee_inst_id) {
                $result = $this->fi_functions->get_installments($hostel_fee_inst_id);
                $hostel_fee_inst[] = $result[0];
            }
        }

        $stud_fee_installment = array('school_fee_inst' => $school_fee_inst, 'transp_fee_inst' => $transp_fee_inst, 'hostel_fee_inst' => $hostel_fee_inst);
        $page_data['fee_installment'] = $stud_fee_installment;

        $page_data['dormitories'] = $dormitory_array;
        $page_data['transports'] = $transport_array;

        $page_data['students'] = $this->Student_model->get_student_details('', $section_id);
        $student_fee_configure = $this->fi_functions->get_feeconfigured_studentlist($section_id, $running_year);
        $students_configured = array();
        foreach ($student_fee_configure as $value) {
            $students_configured[] = $value->student_id;
        }
        $page_data['configured_stud_list'] = $students_configured;

        $class_name = $this->Class_model->get_name_by_id($class_id);
        $page_data['class_name'] = $class_name[0]->name;

        $this->load->view('backend/school_admin/student_fee_config', $page_data);
    }

    function fi_get_setudent_new_setfee($class_id, $section_id, $running_year) {
        $page_data = array();
        $page_data = $this->get_page_data_var();
        $page_data['class_id'] = $class_id;
        $page_data['section_id'] = $section_id;
        $page_data['running_year'] = $running_year;
        $cls_rec = $this->Class_model->get_name_by_id($class_id);
        $page_data['class_name'] = $cls_rec[0]->name;

        $this->load->model('fees/Fees_model');
        $this->load->model("Dormitory_model");
        $this->load->model("Transport_model");
        $this->load->model("Student_model");
        $this->load->model("Class_model");

        //$this->load->library('Fi_functions');
        $term_setting = $this->Fees_model->get_term_setting();
        $term_config = array();
        $term_config['school_term_setting'] = $term_setting ? explode(',', $term_setting->school_term_setting) : array();
        $term_config['hostel_term_setting'] = $term_setting ? explode(',', $term_setting->hostel_term_setting) : array();
        $term_config['transport_term_setting'] = $term_setting ? explode(',', $term_setting->transport_term_setting) : array();
        $page_data['term_config'] = $term_config;


        $page_data['fee_terms'] = $this->Fees_model->get_fee_terms();
        $page_data['dormitories'] = $this->Dormitory_model->get_dormitory_array();
        $page_data['transports'] = $this->Transport_model->get_transport_array();
        $page_data['students'] = $this->Fees_model->get_students(array('E.class_id' => $class_id, 'E.section_id' => $section_id), array('has_config' => 0));
        $page_data['scholarships'] = $this->Fees_model->get_fee_scholarships();
        //echo '<pre>';print_r($students);exit;

        $this->load->view('backend/school_admin/new_student_fee_config', $page_data);
    }

    function get_students_to_promote($class_id_from, $section_id_from, $class_id_to, $section_id_to, $running_year, $promotion_year) {
        $page_data = array();
        $page_data = $this->get_page_data_var();
        $page_data['class_id_from'] = $class_id_from;
        $page_data['section_id_from'] = $section_id_from;
        $page_data['class_id_to'] = $class_id_to;
        $page_data['section_id_to'] = $section_id_to;
        $page_data['running_year'] = $running_year;
        $page_data['promotion_year'] = $promotion_year;
        $page_data['total_notif_num'] = $this->get_no_of_notication();

        $this->load->model("Class_model");
        $class_name = $this->Class_model->get_name_by_id($class_id_from);
        $page_data['from_class_name'] = $class_name[0]->name;
        $class_name = $this->Class_model->get_name_by_id($class_id_to);
        $page_data['to_class_name'] = $class_name[0]->name;


        $this->load->library('Fi_functions');
        $running_year = $promotion_year;
        $scholarships = $this->fi_functions->getScholarships($running_year);
        if ($scholarships) {
            $page_data['scholarships'] = $scholarships;
        }
        $active_installments = $this->fi_functions->getActiveInstallments($running_year);

        $this->load->model("Dormitory_model");
        $this->load->model("Transport_model");
        $this->load->model("Student_model");

        $dormitory_array = $this->Dormitory_model->get_dormitory_array();
        $transport_array = $this->Transport_model->get_transport_array();

        $school_fee_inst = array();
        $transp_fee_inst = array();
        $hostel_fee_inst = array();
        if ($active_installments) {
            $val = $active_installments[0];
            $school_fee_installment_ids = explode(',', $val['schoolfee_inst_types']);
            $transp_fee_installment_ids = explode(',', $val['transfee_inst_types']);
            $hostel_fee_installment_ids = explode(',', $val['hostelfee_inst_types']);

            foreach ($school_fee_installment_ids as $school_fee_inst_id) {
                $result = $this->fi_functions->get_installments($school_fee_inst_id);
                $school_fee_inst[] = $result[0];
            }

            foreach ($transp_fee_installment_ids as $transp_fee_inst_id) {
                $result = $this->fi_functions->get_installments($transp_fee_inst_id);
                $transp_fee_inst[] = $result[0];
            }

            foreach ($hostel_fee_installment_ids as $hostel_fee_inst_id) {
                $result = $this->fi_functions->get_installments($hostel_fee_inst_id);
                $hostel_fee_inst[] = $result[0];
            }
        }

        $stud_fee_installment = array('school_fee_inst' => $school_fee_inst, 'transp_fee_inst' => $transp_fee_inst, 'hostel_fee_inst' => $hostel_fee_inst);
        $page_data['fee_installment'] = $stud_fee_installment;
        $page_data['dormitories'] = $dormitory_array;
        $page_data['transports'] = $transport_array;
        $page_data['students'] = $this->Student_model->get_student_details('', $section_id_from);
        foreach ($page_data['students'] as $key => $stud) {
            $student_enrolled = get_data_generic_fun('enroll', '*', array('student_id' => $stud['student_id'], 'year' => $promotion_year));
            //echo '<pre>';print_r($student_enrolled);exit;
            if (count($student_enrolled) > 0) {
                $page_data['students'][$key]['enroll_status'] = $promotion_year;
            } else {
                $page_data['students'][$key]['enroll_status'] = '';
            }
        }
        $this->load->view('backend/school_admin/student_promotion_selector', $page_data);
    }

    /*     * **MANAGE PARENTS CLASSWISE**** */

    function parent($param1 = '', $param2 = '', $param3 = ''){
    if($this->  session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $this->load->model("Parent_model");
    $page_data = $this->get_page_data_var();
    $page_data['search_text'] = '';

    if ($param1 == 'edit') {
        $this->form_validation->set_rules('fname', 'Father Name', 'trim|required');
        $this->form_validation->set_rules('flname', 'Father Last Name', 'trim|required');
        $this->form_validation->set_rules('mname', 'Mother Name', 'trim|required');
        $this->form_validation->set_rules('mlname', 'Mother Lastname', 'trim|required');
        $this->form_validation->set_rules('fprof', 'Father Profession', 'trim|required');
        $this->form_validation->set_rules('fqual', 'father Qualification', 'trim|required');
        $this->form_validation->set_rules('mqual', 'Mother Qualification', 'trim|required');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('state', 'State', 'trim|required');
        $this->form_validation->set_rules('country', 'Country', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required|numeric|max_length[12]');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_validation_error', validation_errors());
            redirect(base_url() . 'index.php?school_admin/parent/');
        } else {
            $data['father_name'] = $this->input->post('fname');
            $data['father_mname'] = $this->input->post('fmname');
            $data['father_lname'] = $this->input->post('flname');
            $data['mother_name'] = $this->input->post('mname');
            $data['mother_mname'] = $this->input->post('mmname');
            $data['mother_lname'] = $this->input->post('mlname');
            //$data['email'] = $this->input->post('email');
            $data['father_profession'] = $this->input->post('fprof');
            $data['mother_profession'] = $this->input->post('mprof');
            $data['father_qualification'] = $this->input->post('fqual');
            $data['mother_quaification'] = $this->input->post('mqual');
            $data['father_passport_number'] = $this->input->post('fpass_no');
            $data['mother_passport_number'] = $this->input->post('mpass_no');
            $data['father_icard_no'] = $this->input->post('ficard_no');
            $data['father_icard_type'] = $this->input->post('ficard_type');
            $data['mother_icard_no'] = $this->input->post('micard_no');
            $data['mother_icard_type'] = $this->input->post('micard_type');
            $data['address'] = $this->input->post('address');
            $data['city'] = $this->input->post('city');
            $data['state'] = $this->input->post('state');
            $data['country'] = $this->input->post('country');
            $data['zip_code'] = $this->input->post('zip_code');
            $data['cell_phone'] = $this->input->post('phone');
            $data['home_phone'] = $this->input->post('home_phone');
            $data['work_phone'] = $this->input->post('work_phone');
            $data['change_time'] = date('Y-m-d H:i:s');
            $data['isActive'] = '1';
            $this->Parent_model->update_parent($data, array('parent_id' => $param2));
            $this->session->set_flashdata('flash_message', get_phrase('changes_saved_successfully'));
            redirect(base_url() . 'index.php?school_admin/parent/', 'refresh');
            //$this->Email_model->account_opening_email('parent', $data['email'], $this->input->post('password')); //SEND EMAIL ACCOUNT OPENING EMAIL       
        }
    } else if ($param1 == 'enable_disable') {
        $dataArray = array('parent_id' => $param2);
        $status = $this->Parent_model->enable_disable_parent($dataArray);
        $this->session->set_flashdata('flash_message', get_phrase(($status == '1') ? 'enabled_successfully' : 'disabled_successfully'));
//            redirect(base_url() . 'index.php?school_admin/parent/', 'refresh');
    }



    /*     * ***Parent Bulk Upload Function****** */ else if ($param1 == 'import_excel') {
        //pre($_FILES);die;
        if (empty($_FILES['userfile']['name'])) {
            $this->form_validation->set_rules('userfile', 'Document', 'required');
            $this->session->set_flashdata('flash_message_error', 'Please select a document to upload!!');
            redirect(base_url() . 'index.php?school_admin/bulk_upload');
        } else {
            $allowed_types = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip');
            if (in_array($_FILES['userfile']['type'], $allowed_types)) {
                $path = "uploads/parent_import.xlsx";
                //@unlink('uploads/Parent_Upload_Template.xlsx');
                @unlink($path);
                @unlink('uploads/parent_bulk_upload_error_details.log');

                if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $path)) {
                    die('not moving');
                }
                @ini_set('memory_limit', '-1');
                @set_time_limit(0);
                include 'Simplexlsx.class.php';
                $bulk_upload_strt_time = microtime(true);
                generate_log("bulk_upload_start at " . $bulk_upload_strt_time, "parent_bulk_upload_time_checker_" . date('d_m_Y') . '.log');
                $xlsx = new SimpleXLSX($path);
                list($num_cols, $num_rows) = $xlsx->dimension();
                $end_time = microtime(TRUE);
                generate_log("time take till 1847 at " . ($end_time - $bulk_upload_strt_time), "parent_bulk_upload_time_checker_" . date('d_m_Y') . '.log');
                $f = 0;
                $this->load->model("Dynamic_field_model");
                $rs_parent_bulk_upload_fields= $this->Dynamic_field_model->get_parent_bulk_upload();
                $rs_parent_bulk_upload_mandatory_fields= $this->Dynamic_field_model->get_parent_bulk_upload_mandatory();
                $rs_parent_bulk_upload_label_fields= $this->Dynamic_field_model->get_parent_bulk_upload_label();

                //$fielsdStringForAdmin = "Father's First Name,Father's Last Name,Mother's First Name,Mother's Last Name,Father's Profession,Mother's Profession,Email Id,Identity Card #,Identity Card Type,Address,City,State,Country,ZIP Code,Mobile,Home Phone,Work Phone";
                $fielsdStringForAdmin = $rs_parent_bulk_upload_label_fields[0]['tableCol'];
                //$fielsdString = "father_name,father_lname,mother_name,mother_lname,father_profession,mother_profession,email,father_icard_no,father_icard_type,address, city,state,country,zip_code,cell_phone,home_phone,work_phone";
                $fielsdString = $rs_parent_bulk_upload_fields[0]['tableCol'];
                //$fielsdStringMandotary = "father_name,mother_name,email,cell_phone";
                $fielsdStringMandotary = $rs_parent_bulk_upload_mandatory_fields[0]['tableCol'];
                
                $fielsdArr = explode(',', $fielsdString);
                $fielsdStringForAdminArr = explode(',', $fielsdStringForAdmin);
                $fielsdStringMandotaryArr = explode(',', $fielsdStringMandotary);
                $someRowError = FALSE;
                $errorMsgArr = array();
                $errorExcelArr = array();
                $errorExcelArr[] = $fielsdStringForAdminArr;
                $errorRowNo = 2;
                //pre($xlsx->rows());die;
                $time_start_foreach = microtime(TRUE);
                foreach ($xlsx->rows() as $r) {
                    $time_start_row_foreach = microtime(TRUE);
                    //echo '<pre>'; //print_r($r);die;
                    $data = array();
                    $dataParent = array();
                    $error = FALSE;
                    // Ignore the inital name row of excel file
                    if ($f == 0) {
                        $f++;
                        continue;
                    } $f++;
                    //pre($r); //die('here');
                    //pre($r);pre('above are $r data');
                    if ($num_cols > count($fielsdArr)) {
                        $num_cols = count($fielsdArr);
                    }
                    $blankErrorMsgArr = array();
                    $errorRowIncrease = FALSE;
                    $time_before_for_loop = microtime(TRUE);
                    //generate_log("time takeing for each row in excel data ".($time_start_foreach-$time_end_foreach)." sec","parent_bulk_upload_time_checker_".date("d_m_Y").".log");
                    for ($i = 0; $i < $num_cols; $i++) {    // checking is filds is mandetory or not
                        //echo $fielsdArr[$i].'<br>';
                        $time_start_col_validate = microtime(true);
                        if (in_array($fielsdArr[$i], $fielsdStringMandotaryArr)) {
                            //now validating mandetory fiels

                            generate_log("Field " . $fielsdArr[$i] . " value " . $r[$i] . "\n", 'parent_bulk_upload_' . date('d-m-Y-H') . '.log');
                            if (trim($r[$i]) == "") {
                                //echo "here"; //die();
                                $error = TRUE;
                                $blankErrorMsgArr[] = $fielsdStringForAdminArr[$i] . " should not be blank at row no " . $errorRowNo;
                            } else {
                                $time_cal_start_email_phone = microtime(TRUE);
                                //pre($i);
                                $validPhoneEmailCheck = "ok";
                                $rsEmailPhoneUnique = array();
                                // now check teh uniques for email then phone
                                $fieldType= $this->Dynamic_field_model->get_field_type($fielsdArr[$i],'2');
                                
                                if($fieldType=='email'){
                                    $rsEmailPhoneUnique = $this->Parent_model->get_data_by_cols('parent_id', array($fielsdArr[$i] => trim($r[$i])));
                                    $validPhoneEmailCheck = $this->checkValidPhoneEmail(trim($r[$i]), 'email');
                                }
                                
                                if($fieldType=='tel'){
                                    $rsEmailPhoneUnique = $this->Parent_model->get_data_by_cols('parent_id', array($fielsdArr[$i] => trim($r[$i])));
                                    $validPhoneEmailCheck = $this->checkValidPhoneEmail(trim($r[$i]), 'phone');
                                }
                                
                                /*if ($fielsdArr[$i] == 'email') {
                                    $rsEmailPhoneUnique = $this->Parent_model->get_data_by_cols('parent_id', array('email' => trim($r[$i])));
                                    $validPhoneEmailCheck = $this->checkValidPhoneEmail(trim($r[$i]), 'email');
                                } elseif ($fielsdArr[$i] == 'cell_phone') {
                                    $rsEmailPhoneUnique = $this->Parent_model->get_data_by_cols('parent_id', array('cell_phone' => trim($r[$i])));
                                    $validPhoneEmailCheck = $this->checkValidPhoneEmail(trim($r[$i]), 'phone');
                                }*/

                                if (count($rsEmailPhoneUnique) > 0) {
                                    $error = TRUE;
                                    $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " is already entered.Should be unique information at row no -" . $errorRowNo;
                                    //echo '<br>';
                                }

                                if ($validPhoneEmailCheck != 'ok' && ($fieldType == 'email' || $fieldType == 'tel')) {
                                    $error = TRUE;
                                    $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " Should be " . $validPhoneEmailCheck . " at row no -" . $errorRowNo;
                                }
                                
                                $time_cal_end_email_phone = microtime(TRUE);
                                generate_log("time take to validate for emial or phone : " . trim($fielsdArr[$i]) . " with " . ($time_cal_end_email_phone - $time_cal_start_email_phone) . " sec", "parent_bulk_upload_time_checker_" . date("d_m_Y") . ".log");
                            }
                            //pre($errorMsgArr);//die;
                            //pre(trim($fielsdArr[$i]));pre('$error');pre($error);
                        } else {
                            /* if($fielsdArr[$i]=='date_time'){
                              $rawDOB=trim($r[$i]);
                              $newDOB=$this->get_mysql_date_formate_from_raw($rawDOB);
                              if($newDOB!=""){
                              $data[$fielsdArr[$i]]=$newDOB;
                              }else{
                              $data[$fielsdArr[$i]]=date('Y-m-d H:i:s');
                              }
                              } */
                        }
                        if ($fielsdArr[$i] != 'date_time') {
                            $data[trim($fielsdArr[$i])] = trim($r[$i]);
                        }
                        $time_end_col_validate = microtime(TRUE);
                        generate_log("time take to validate for column : " . trim($fielsdArr[$i]) . " with " . ($time_end_col_validate - $time_start_col_validate) . " sec", "parent_bulk_upload_time_checker_" . date("d_m_Y") . ".log");
                    }
                    if (count($blankErrorMsgArr) > 0) {
                        $error = TRUE;
                        if (count($blankErrorMsgArr) <= count($fielsdArr)) {
                            foreach ($blankErrorMsgArr AS $errorKey => $errorVal) {
                                $errorMsgArr[] = $errorVal;
                            }
                        }
                    }
                    //pre($data); //die('//hii');
                    //pre('$error');pre($error); //die();
                    if ($error === FALSE) {
                        //$data['date_time']=strtotime(date("Y-m-d H:i:s")); 
                        //$data['parent_id'] = $parent_id;
                        $passcode = "spa" . mt_rand(10000000, 99999999);
                        $data['password'] = sha1($passcode);
                        $data['passcode'] = $passcode;
                        $data['isActive'] = "1";
                        //pre($data);
                        //pre('kkkkkkkkkkkkk');die;
                        //pre($data);die;

                        $parent_id = $this->Parent_model->save_parent($data);
                        $time_end_row_foreach_just_before_insert = microtime(TRUE);
                        generate_log("time take to insrt row no : " . $f . " just before save in parent table " . ($time_end_row_foreach_just_before_insert - $time_start_row_foreach) . " sec", "parent_bulk_upload_time_checker_" . date("d_m_Y") . ".log");
                        generate_log("Parent uploaded done for " . $data['father_name']);
                        if ($parent_id > 0) {
                            /* $post = [
                              'location' => $this->globalSettingsLocation,
                              'cell_phone' => $data['cell_phone'],
                              'message' => "Welcome Mr " . $data['father_name'] . " your passcode for app is " . $passcode . "   download app here https://play.google.com/store/apps/details?id=".$this->globalSettingsAppPackageName."&hl=en",
                              ];
                              //echo print_r($post);exit;
                              $url = "http://".SMS_IP_ADDR."/School/index.php/?admin/send_common_sms/";
                              fire_api_by_curl($url,$post); */
                            $message = array();
                            $activity = "new_user";
                            $message['messagge_body'] = "Welcome Mr " . $data['father_name'] . " your passcode for app is " . $passcode . "   download app here https://play.google.com/store/apps/details?id=" . $this->globalSettingsAppPackageName . "&hl=en";
                            $message['subject'] = "Your login details for " . CURRENT_INSTANCE . " School";
                            $message['to_name'] = $data['father_name'];
                            $phone = array($data['cell_phone']);
                            $email = array($data['email']);
                            $user_details = array('user_id' => $parent_id, 'user_type' => 'parent');
                            //send_school_notification($activity, $message, $phone, $email, $user_details);
                        }
                    } else {
                        $time_end_row_foreach_just_before_final_error_handle = microtime(TRUE);
                        generate_log("time take to insrt row no : " . $f . " just before final error array handle " . ($time_end_row_foreach_just_before_final_error_handle - $time_start_row_foreach) . " sec", "parent_bulk_upload_time_checker_" . date("d_m_Y") . ".log");
                        //pre($errorMsgArr);//die;

                        $errorExcelArr[] = $r;
                        $someRowError = TRUE;
                    }
                    $errorRowNo++;
                    $time_end_row_foreach = microtime(TRUE);
                    generate_log("time take to insrt row no : " . $f . " with " . ($time_end_row_foreach - $time_start_row_foreach) . " sec", "parent_bulk_upload_time_checker_" . date("d_m_Y") . ".log");
                } //ends foreach
                //pre($errorMsgArr); exit;
                if ($someRowError == FALSE) {
                    //$this->generate_cv$error_msg);
                    generate_log("No error for this upload at - " . time(), 'parent_bulk_upload' . date('d-m-Y-H') . '.log');
                    $this->session->set_flashdata('flash_message', get_phrase('parent_details_added'));
                    redirect(base_url() . 'index.php?school_admin/bulk_upload/', 'refresh');
                } else {
                    //pre($errorMsgArr); die('here');
                    generate_log(json_encode($errorMsgArr), 'parent_bulk_upload_error_details.log', TRUE);
                    $file_name_with_path = 'uploads/parent_bulk_upload_error_details_for_excel_file.xlsx';
                    @unlink($file_name_with_path);
                    create_excel_file($file_name_with_path, $errorExcelArr, 'Parent Upload Data');
                    $this->session->set_flashdata('flash_message_error', "Some rows are not uploaded,due to invalid data.");
                    redirect(base_url() . 'index.php?school_admin/parent_bulk_upload_error', 'refresh');
                }
            }//ends allowed type code
            else {
                $this->session->set_flashdata('flash_message_error', 'Sorry, File extension is not supported, Please enter data in Excel Spread Sheet!!');
                redirect(base_url() . 'index.php?school_admin/bulk_upload');
            }
        }
    } else if (($param1 == 'search') && ($param2 != '')) {
        $page_data['search_text'] = $param2;
    } //ends impport excel
    /*     * ******Ends Here******* */

    /*     * *******************View Parent************************* */
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['parents'] = $this->Parent_model->get_data_by_cols('*', array(), 'result_array', array('father_name' => 'asc'));
    $page_data['page_title'] = get_phrase('all_parents');
    $page_data['page_name'] = 'parent';
    $this->load->view('backend/index', $page_data);

    /*     * *********************End of Function*********************************** */
}

/* * **MANAGE TEACHERS**** */

function teacher($param1 = '', $param2 = '', $param3 = '') {
    $this->load->model("Teacher_model");
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['search_text'] = '';
    if ($param1 == 'create') {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[teacher.email]');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_message_error', get_phrase('Email already taken please enter other email'));
            redirect(base_url() . 'index.php?school_admin/teacher/', 'refresh');
        } else {
            $data['emp_id'] = $this->input->post('emp_id');
            $data['name'] = $this->input->post('first_name');
            $data['middle_name'] = $this->input->post('middle_name');
            $data['last_name'] = $this->input->post('last_name');
            $data['email'] = $this->input->post('email');
            $data['password'] = sha1($this->input->post('password'));
            $bday = $this->input->post('birthday');
            $data['date_of_birth'] = date('Y-m-d', strtotime($bday));
            //echo $data['date_of_birth'];exit;
            $data['gender'] = $this->input->post('gender');
            $data['religion'] = $this->input->post('religion');
            $data['nationality'] = $this->input->post('nationality');
            $data['blood_group'] = $this->input->post('blood_group');
            $data['address'] = $this->input->post('present_address');
            $data['country'] = $this->input->post('country');
            $data['state'] = $this->input->post('state');
            $data['city'] = $this->input->post('city');
            $data['zip_code'] = $this->input->post('zip_code');
            $data['cell_phone'] = $this->input->post('mobile_phone');
            $data['home_phone'] = $this->input->post('home_phone');
            $data['work_phone'] = $this->input->post('work_phone');
            $data['job_title'] = $this->input->post('job_title');
            $data['qualification'] = $this->input->post('qualification');
            $data['specialisation'] = $this->input->post('stream');
            $data['experience'] = $this->input->post('expereince');
            $data['summary'] = $this->input->post('summary');
            $data['awards'] = $this->input->post('awards');
            $data['card_id'] = $this->input->post('card_id');
            $data['passport_number'] = $this->input->post('passport_no');
            $data['idcard_number'] = $this->input->post('icard_no');
            $data['idcard_type'] = $this->input->post('type');
            $data['teacher_image'] = $_FILES['userfile']['name'];

            $data['isActive'] = '1';
            $data['date_time'] = date('Y-m-d H:i:s');
            $teacher_id = $this->Teacher_model->save_teacher($data);
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/teacher_image/' . $teacher_id . '.jpg');
            $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
            $this->Email_model->account_opening_email('teacher', $data['email'], $this->input->post('password')); //SEND EMAIL ACCOUNT OPENING EMAIL
            redirect(base_url() . 'index.php?school_admin/teacher_information/', 'refresh');
        }
    } else if ($param1 == 'do_update') {
        //$data['emp_id'] = $this->input->post('emp_id');
        $data['name'] = $this->input->post('first_name');
        $data['middle_name'] = $this->input->post('middle_name');
        $data['last_name'] = $this->input->post('last_name');
        $bday = $this->input->post('birthday');
        $data['date_of_birth'] = date('Y-m-d', strtotime($bday));
        $data['gender'] = $this->input->post('gender');
        $data['religion'] = $this->input->post('religion');
        $data['nationality'] = $this->input->post('nationality');
        $data['blood_group'] = $this->input->post('blood_group');
        $data['address'] = $this->input->post('present_address');
        $data['country'] = $this->input->post('country');
        $data['state'] = $this->input->post('state');
        $data['city'] = $this->input->post('city');
        $data['zip_code'] = $this->input->post('zip_code');
        $data['cell_phone'] = $this->input->post('cell_phone');
        $data['home_phone'] = $this->input->post('home_phone');
        $data['work_phone'] = $this->input->post('work_phone');
        $data['job_title'] = $this->input->post('job_title');
        $data['qualification'] = $this->input->post('qualification');
        $data['specialisation'] = $this->input->post('stream');
        $data['experience'] = $this->input->post('expereince');
        $data['summary'] = $this->input->post('summary');
        $data['awards'] = $this->input->post('awards');
        $data['card_id'] = $this->input->post('card_id');
        $data['passport_number'] = $this->input->post('passport_no');
        $data['idcard_number'] = $this->input->post('icard_no');
        $data['idcard_type'] = $this->input->post('type');
        $data['teacher_image'] = $_FILES['userfile']['name'];
        $data['isActive'] = '1';
        $data['change_time'] = date('Y-m-d H:i:s');
        $this->Teacher_model->update_teacher($data, $param2);
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/teacher_image/' . $param2 . '.jpg');
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?school_admin/teacher_information/', 'refresh');
    } else if ($param1 == 'personal_profile') {
        $page_data['personal_profile'] = true;
        $page_data['current_teacher_id'] = $param2;
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->Teacher_model->get_data_by_cols('*', array('teacher_id' => $param2), 'result_array');
    } else if ($param1 == 'delete') {
        unlink('uploads/teacher_image/' . $param2 . '.jpg');
        $dataArray = array('teacher_id' => $param2);
        $this->Teacher_model->delete_teacher($dataArray);
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?school_admin/teacher_information/', 'refresh');
    } else if ($param1 == 'update_passcode') {
        $rsTeacherData = $this->Teacher_model->get_data_by_cols('passcode,name,cell_phone,email', array('teacher_id' => $param2));

        if (count($rsTeacherData) > 0) {
            $phoneNumber = $rsTeacherData[0]->cell_phone;

            if ($phoneNumber != "") {
                $passcode = create_passcode('teacher');
                $data['passcode'] = ($passcode != 'invalid') ? $passcode : '';
                $data['password'] = ($passcode != 'invalid') ? md5($passcode) : '';
                $this->Teacher_model->update_teacher($data, $param2);

                $msg = "Welcome to Sharad School Mr. " . $rsTeacherData[0]->name . " your passcode for app is  " . $passcode . "   download app here https://play.google.com/store/apps/details?id=" . $this->globalSettingsAppPackageName . "&hl=en";
                $phone = $phoneNumber;
                $message = array();
                $message_body = $msg;
                $message['sms_message'] = $msg;
                $message['subject'] = 'Password Reset ' . $this->globalSettingsSystemName;
                $message['messagge_body'] = $message_body;
                $message['to_name'] = $rsTeacherData[0]->name;
                send_school_notification('update_passcode', $message, array($phone), array($rsTeacherData[0]->email));
                $this->session->set_flashdata('flash_message', get_phrase('Passcode_is_sent_successfully_to_registered_number'));
            } else {
                $this->session->set_flashdata('flash_message_error', "Phone no is not found.");
            }

            /* if ($rsTeacherData[0]->passcode == "") {
              $passcode = 'sta' . mt_rand(10000000, 99999999);
              $this->Teacher_model->update_teacher(array('passcode' => $passcode), $param2);
              if ($phoneNumber != "" || $rsTeacherData[0]->email != "") {

              $phone = $phoneNumber;
              $message = array();
              $msg = "Welcome to " . $this->globalSettingsSystemName . " Mr. " . $rsTeacherData[0]->name . " " . $rsTeacherData[0]->name . " your passcode for app is  " . $passcode . "   download app here https://play.google.com/store/apps/details?id=" . $this->globalSettingsAppPackageName . "&hl=en";
              $message_body = $msg;

              $message['sms_message'] = $msg;
              $message['subject'] = 'Password Reset ' . $this->globalSettingsSystemName;
              $message['messagge_body'] = $message_body;
              $message['to_name'] = $rsTeacherData[0]->name;
              send_school_notification('update_passcode', $message, array($phone), array($rsTeacherData[0]->email));
              }
              } else {
              if ($phoneNumber != "" || $rsTeacherData[0]->email != "") {
              $passcode = $rsTeacherData[0]->passcode;
              $msg = "Welcome to Sharad School Mr. " . $rsTeacherData[0]->name . " your passcode for app is  " . $rsTeacherData[0]->passcode . "   download app here https://play.google.com/store/apps/details?id=" . $this->globalSettingsAppPackageName . "&hl=en";
              $phone = $phoneNumber;
              $message = array();
              $message_body = $msg;
              $message['sms_message'] = $msg;
              $message['subject'] = 'Password Reset ' . $this->globalSettingsSystemName;
              $message['messagge_body'] = $message_body;
              $message['to_name'] = $rsTeacherData[0]->name;
              send_school_notification('update_passcode', $message, array($phone), array($rsTeacherData[0]->email));
              }
              } */
        } else {
            $this->session->set_flashdata('flash_message_error', "Unknown error arises to update the passcode");
        }
        redirect(base_url() . 'index.php?school_admin/teacher_information/', 'refresh');
    } else if (($param1 == 'search') && ($param2 != '')) {
        $page_data['search_text'] = $param2;
    }

    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['teachers_id'] = $this->Teacher_model->get_teacher_record(array('teacher_id' => $param2));
    //$page_data['teachers'] = $this->Teacher_model->get_teacher_array();
    $page_data['page_name'] = 'teacher';
    $page_data['page_title'] = get_phrase('manage_teacher');
    $this->load->view('backend/index', $page_data);
}

function teacher_information() {
    $this->load->model("Teacher_model");
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['teachers'] = $this->Teacher_model->get_teacher_array();
    $page_data['page_name'] = 'teacher';
    $page_data['page_title'] = get_phrase('manage_teacher');
    $this->load->view('backend/index', $page_data);
}

function generate_invoice() {
    $student_id = $this->input->post('student_id');
    $this->load->library('Fi_functions');
    $this->fi_functions->save_invoice($student_id);
}

/* add subject */

function add_subject() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['teachers'] = $this->Teacher_model->get_data_by_cols("*", array(), "result_array", array('name' => 'asc'));
    $page_data['classes'] = $this->Class_model->get_class_array();
    $page_data['total_notif_num'] = $this->get_no_of_notication();


    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_name'] = 'add_subject';
    $page_data['page_title'] = get_phrase('add_subject');
    $this->load->view('backend/index', $page_data);
}

/* * **MANAGE SUBJECTS**** */

function subject($param1 = '', $param2 = '', $param3 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Subject_model');
    $page_data = $this->get_page_data_var();
    if ($param1 == 'create') {
        $data['class_id'] = $this->input->post('class_id');
        $this->form_validation->set_rules('name', 'Subject Name', 'trim|required');
        $this->form_validation->set_rules('class_id', 'Class', 'required');
        $this->form_validation->set_rules('section_id', 'Section', 'required');
        $this->form_validation->set_rules('teacher_id', 'Teacher', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_message_error', validation_errors());
            redirect(base_url() . 'index.php?school_admin/subject/' . $data['class_id'], 'refresh');
        } else {
            $data['name'] = $this->input->post('name');
            $data['class_id'] = $this->input->post('class_id');
            $data['section_id'] = $this->input->post('section_id');
            $data['teacher_id'] = $this->input->post('teacher_id');
            $data['year'] = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
            $count = $this->Subject_model->get_data_by_cols('count(name)as count', array('class_id' => $data['class_id'], 'name' => $data['name'], 'section_id' => $data['section_id']), 'result_array');
            if ($count[0]['count'] < 1) {
                $new_subject_id = $this->Subject_model->save_subject($data);
                $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
                redirect(base_url() . 'index.php?school_admin/subject/' . $data['class_id'], 'refresh');
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('duplicate_entry'));
                redirect(base_url() . 'index.php?school_admin/subject/' . $data['class_id'], 'refresh');
            }
//            $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
//            redirect(base_url() . 'index.php?school_admin/subject/' . $data['class_id'], 'refresh');
        }
    }
    if ($param1 == 'do_update') {
        $data['name'] = $this->input->post('name');
        $data['class_id'] = $this->input->post('class_id');
        $data['teacher_id'] = $this->input->post('teacher_id');
        $data['section_id'] = $this->input->post('section_id');
        $data['year'] = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
        $subject_id = $this->Subject_model->update_subject($data, array("subject_id" => $param2));
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        //$data['class_id'] = $this->input->post('class_id');
        redirect(base_url() . 'index.php?school_admin/subject/' . $data['class_id'], 'refresh');
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->Subject_model->get_subject_array(array("subject_id" => $param2));
    }
    if ($param1 == 'delete') {
        $this->Subject_model->delete_subject(array("subject_id" => $param2));
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?school_admin/subject/' . $param3, 'refresh');
    }

    if ($param1 == 'import_excel') {
        if (empty($_FILES['userfile']['name'])) {
            $this->form_validation->set_rules('userfile', 'Document', 'required');
            $this->session->set_flashdata('flash_message_error', 'Please select a document to upload!!');
            redirect(base_url() . 'index.php?school_admin/bulk_upload');
        } else {
            $allowed_types = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip');
            if (in_array($_FILES['userfile']['type'], $allowed_types)) {
                $path = "uploads/subject_import.xlsx";
                //@unlink('uploads/subject_import.xlsx');
                @unlink($path);
                @unlink('uploads/subject_bulk_upload_error_details.log');

                if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $path)) {
                    die('not moving');
                }
                @ini_set('memory_limit', '-1');
                @set_time_limit(0);
                include 'Simplexlsx.class.php';
                $xlsx = new SimpleXLSX($path);
                list($num_cols, $num_rows) = $xlsx->dimension();
                $f = 0;
                $fielsdStringForAdmin = "Class Name,Section Name,Subject Name,Teacher Email Id";
                $fielsdString = "class_id,section_id,name,email";
                $fielsdStringMandotary = "class_id,section_id,name,email";
                $fielsdArr = explode(',', $fielsdString);
                $fielsdStringForAdminArr = explode(',', $fielsdStringForAdmin);
                $fielsdStringMandotaryArr = explode(',', $fielsdStringMandotary);
                $someRowError = FALSE;
                $errorMsgArr = array();
                $errorExcelArr = array();
                $errorExcelArr[] = $fielsdStringForAdminArr;
                $errorRowNo = 2;
                //pre($xlsx->rows());die;
                foreach ($xlsx->rows() as $r) {
                    //echo '<pre>'; //print_r($r);die;
                    $data = array();
                    $dataParent = array();
                    $error = FALSE;
                    // Ignore the inital name row of excel file
                    if ($f == 0) {
                        $f++;
                        continue;
                    } $f++;
                    //pre($r); //die('here');
                    //pre($r);
                    //pre('above are $r data');
                    if ($num_cols > count($fielsdArr)) {
                        $num_cols = count($fielsdArr);
                    }
                    $blankErrorMsgArr = array();
                    $errorRowIncrease = FALSE;
                    for ($i = 0; $i < $num_cols; $i++) {    // checking is filds is mandetory or not
                        //echo $fielsdArr[$i].'<br>';
                        if (in_array($fielsdArr[$i], $fielsdStringMandotaryArr)) {
                            //now validating mandetory fiels
                            generate_log("Field " . $fielsdArr[$i] . " value " . $r[$i] . "\n", 'subject_bulk_upload_' . date('d-m-Y-H') . '.log');
                            if (trim($r[$i]) == "") {
                                //echo "here"; //die();
                                $error = TRUE;
                                $blankErrorMsgArr[] = $fielsdStringForAdminArr[$i] . " should not be blank at row no " . $errorRowNo;
                            } else {
                                //pre($i);
                                $validPhoneEmailCheck = "ok";
                                $rsEmailPhoneUnique = array();
                                // now check teh uniques for email then phone
                                if ($fielsdArr[$i] == 'email') {
                                    //echo 'Meera';die();
                                    $rsEmailPhoneUnique = $this->Teacher_model->get_data_by_cols('teacher_id', array('email' => trim($r[$i])));
                                    if (count($rsEmailPhoneUnique) == 0) {
                                        $error = TRUE;
                                        $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " is not exists at row no -" . $errorRowNo;
                                        //echo '<br>';
                                    } else {
                                        $data['teacher_id'] = $rsEmailPhoneUnique[0]->teacher_id;
                                    }
                                    $validPhoneEmailCheck = $this->checkValidPhoneEmail(trim($r[$i]), 'email');
                                }


                                if ($validPhoneEmailCheck != 'ok' && $fielsdArr[$i] == 'email') {
                                    $error = TRUE;
                                    $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " Should be " . $validPhoneEmailCheck . " at row no -" . $errorRowNo;
                                }
                            }

                            if ($fielsdArr[$i] == 'class_id') {
                                $rsClass = $this->Class_model->get_name($r[$i]);

                                if (count($rsClass) > 0) {
                                    $data['class_id'] = $rsClass[0]->class_id;
                                } else {
                                    $data['class_id'] = "";
                                    $error = TRUE;
                                    $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " content invalid data at row no -" . $errorRowNo;
                                }
                            }

                            if ($fielsdArr[$i] == 'section_id') {
                                if ($data['class_id'] == "") {
                                    $error = TRUE;
                                    $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " content invalid data at row no -" . $errorRowNo;
                                } else {
                                    $rsClassSection = $this->Section_model->get_name($data['class_id'], $r[$i]);

                                    if (count($rsClassSection) > 0) {
                                        $data['section_id'] = $rsClassSection[0]->section_id;
                                    } else {
                                        $error = TRUE;
                                        $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " content invalid data at row no -" . $errorRowNo;
                                    }
                                }
                            }

                            if ($fielsdArr[$i] == 'name') {
                                $data['name'] = trim($r[$i]);
                            }
                            //pre($errorMsgArr);//die;
                            //pre(trim($fielsdArr[$i]));pre('$error');pre($error);
                        } else {
                            /* if($fielsdArr[$i]=='date_time'){
                              $rawDOB=trim($r[$i]);
                              $newDOB=$this->get_mysql_date_formate_from_raw($rawDOB);
                              if($newDOB!=""){
                              $data[$fielsdArr[$i]]=$newDOB;
                              }else{
                              $data[$fielsdArr[$i]]=date('Y-m-d H:i:s');
                              }
                              } */
                        }
                    }
                    if (count($blankErrorMsgArr) > 0) {
                        $error = TRUE;
                        if (count($blankErrorMsgArr) <= count($fielsdArr)) {
                            foreach ($blankErrorMsgArr AS $errorKey => $errorVal) {
                                $errorMsgArr[] = $errorVal;
                            }
                        }
                    }
                    //pre($data); //die('//hii');
                    //pre('$error');pre($error); //die();
                    if ($error === FALSE) {
                        //$data['date_time']=strtotime(date("Y-m-d H:i:s")); 
                        //$data['parent_id'] = $parent_id;
                        $data['year'] = $this->globalSettingsRunningYear;
                        //pre($data);
                        //pre('kkkkkkkkkkkkk');die;
                        //pre($data);die;
                        $subject_id = $this->Subject_model->save_subject($data);
                    } else {
                        //pre($errorMsgArr);//die;
                        $errorExcelArr[] = $r;
                        $someRowError = TRUE;
                    }
                    $errorRowNo++;
                } //ends foreach
                //pre($errorMsgArr); exit;

                if ($someRowError == FALSE) {
                    //$this->generate_cv$error_msg);
                    generate_log("No error for this upload at - " . time(), 'subject_bulk_upload' . date('d-m-Y-H') . '.log');
                    $this->session->set_flashdata('flash_message', get_phrase('subject_details_added'));
                    redirect(base_url() . 'index.php?school_admin/bulk_upload/', 'refresh');
                } else {
                    //pre($errorMsgArr); die('here');
                    generate_log(json_encode($errorMsgArr), 'subject_bulk_upload_error_details.log', TRUE);
                    $file_name_with_path = 'uploads/subject_bulk_upload_error_details_for_excel_file.xlsx';
                    @unlink($file_name_with_path);
                    create_excel_file($file_name_with_path, $errorExcelArr, 'subject Upload Data');
                    $this->session->set_flashdata('flash_message_error', "Some rows are not uploaded,due to invalid data.");
                    redirect(base_url() . 'index.php?school_admin/subject_bulk_upload_error', 'refresh');
                }
            }//ends allowed type code
            else {
                $this->session->set_flashdata('flash_message_error', 'Sorry, File extension is not supported, Please enter data in Excel Spread Sheet!!');
                redirect(base_url() . 'index.php?school_admin/bulk_upload');
            }
        }
        $this->session->set_flashdata('flash_message', get_phrase('subjects_added'));
        redirect(base_url() . 'index.php?school_admin/bulk_upload', 'refresh');
    }

    $page_data['teachers'] = $this->Teacher_model->get_data_by_cols("*", array(), "result_array", array('name' => 'asc'));
    $page_data['classes'] = $this->Class_model->get_class_array();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    if ($param1 == '') {
        $this->load->model("Class_model");

        $page_data['class_id'] = $this->Class_model->get_first_class_id();
        //$subjects = $this->Subject_model->get_subject_array(array('class_id' => $page_data['class_id']));
        $subjects = $this->Subject_model->get_all_subjects(array('sub.class_id' => $page_data['class_id']));

        if (count($subjects)) {
            foreach ($subjects as $key => $row) {
                $subjects[$key]['transaction'] = $this->Crud_model->getSubjectTransaction($row['subject_id']);
            }
        }

        $page_data['subjects'] = $subjects;
    } else {
        $page_data['class_id'] = $param1;
        //'$subjects = $this->Subject_model->get_subject_array(array('class_id' => $param1));
        $subjects = $this->Subject_model->get_all_subjects(array('sub.class_id' => $page_data['class_id']));

        if (count($subjects)) {
            foreach ($subjects as $key => $row) {
                $subjects[$key]['transaction'] = $this->Crud_model->getSubjectTransaction($row['subject_id']);
            }
        }
        $page_data['subjects'] = $subjects;
    }

    $page_data['page_name'] = 'subject';
    $page_data['page_title'] = get_phrase('manage_subject');
    $this->load->view('backend/index', $page_data);
}

/* * **MANAGE CLASSES**** */

function classes($param1 = '', $param2 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model("Class_model");
    $this->load->model("Teacher_model");
    $page_data = $this->get_page_data_var();
    if ($param1 == 'create') {
        $this->form_validation->set_rules('name', 'Class name', 'trim|required');
        $this->form_validation->set_rules('name_numeric', 'Class numeric name', 'numeric|trim|required|_unique_sch[class.name_numeric]');
        $this->form_validation->set_message('is_unique', 'Name Numeric ' . $this->input->post('name_numeric') . " is already used by other class, please enter other Name Numeric");
        $this->form_validation->set_rules('teacher_id', 'Teacher name', 'trim|required');
        $this->form_validation->set_error_delimiters('', '');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_message_error', validation_errors());
        } else {
            $name = $this->input->post('name');
            $data['name'] = $this->input->post('name');
            $data['name_numeric'] = $this->input->post('name_numeric');
            $data['teacher_id'] = $this->input->post('teacher_id');
            $class_id = $this->Class_model->save_class($data, $name);
            if ($class_id == '' || $class_id == NULL) {
                $this->session->set_flashdata('flash_message_error', get_phrase('duplicate_entry'));
                redirect(base_url() . 'index.php?school_admin/classes/', 'refresh');
            } else {
                //create a section by default
                $data2['class_id'] = $class_id;
                $data2['name'] = 'A';
                $data2['nick_name'] = 'Section A';
                $data2['teacher_id'] = $data['teacher_id'];
                $data2['max_capacity'] = 20;
                // echo '<pre>'; print_r($data2); exit;
                $section_id = $this->Class_model->save_section($data2);

                /* Create Group in fincance system start here */
                $group_data = array('id' => $class_id, 'gname' => $name, 'sorder' => $class_id);
                $group_id = $this->Class_model->add_group_finance($group_data);
                /* Create Group in finance system end here */

                $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
                redirect(base_url() . 'index.php?school_admin/classes/', 'refresh');
            }
        }
    }
    if ($param1 == 'do_update') {

        $this->form_validation->set_rules('name', 'Class name', 'trim|required');
        $this->form_validation->set_rules('name_numeric', 'Class numeric name', 'trim|required');
        //$this->form_validation->set_rules('teacher_id', 'Teacher name', 'trim|required');
        $this->form_validation->set_error_delimiters('', '');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_message_error', validation_errors());
            //redirect(base_url() . 'index.php?school_admin/classes/', 'refresh');
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $data['name'] = $this->input->post('name');
            $data['name_numeric'] = $this->input->post('name_numeric');
            //$data['teacher_id'] = $this->input->post('teacher_id');
            //$data['number_of_seat'] = $this->input->post('number_of_seat');
            $count = $this->Class_model->get_data_by_cols('count(name) as count', array('name' => $data['name'], 'class_id' . '!=' => $param2), 'result_array');
            if ($count[0]['count'] == 0) {
                $class_id = $this->Class_model->update_class($data, array("class_id" => $param2));
                $count_numeric = $this->Class_model->get_data_by_cols('count(name_numeric) as count_numeric', array('name_numeric' => $data['name_numeric'], 'class_id' . '!=' => $param2), 'result_array');
                if ($count_numeric[0]['count_numeric'] == 0) {
                    $class_id = $this->Class_model->update_class($data, array("class_id" => $param2));
                    $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
                    // redirect(base_url() . 'index.php?school_admin/classes/', 'refresh');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('duplicate_entry_of_name_numeric_,so_could_not_edit'));
                    //redirect(base_url() . 'index.php?school_admin/classes/', 'refresh');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('duplicate_entry'));
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->Class_model->get_data_by_cols('*', array(
            'class_id' => $param2), 'result_type');
    }
    if ($param1 == 'delete') {
        $year = $this->globalSettingsRunningYear;
        $this->load->model('Enroll_model');
        $students = $this->Enroll_model->check_student_before_delete_class($param2, $year);
        if (!empty($students)) {
            $this->session->set_flashdata('flash_message', get_phrase('Could not delete the class because, Students are present in this class'));
            redirect(base_url() . 'index.php?school_admin/classes/', 'refresh');
        } else {
            $this->load->library("fi_functions");
            $this->fi_functions->delete_group($param2);
            $this->Class_model->delete_class(array("class_id" => $param2));
            $this->session->set_flashdata('flash_message', get_phrase('data_deleted_successfully'));
            redirect(base_url() . 'index.php?school_admin/classes/', 'refresh');
        }
    }
    if ($param1 == 'import_excel') {
        if (empty($_FILES['userfile']['name'])) {
            $this->form_validation->set_rules('userfile', 'Document', 'required');
            $this->session->set_flashdata('flash_message_error', 'Please select a document to upload!!');
        } else {
            $allowed_types = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip');
            if (in_array($_FILES['userfile']['type'], $allowed_types)) {
                $path = 'uploads/class_details.xlsx';
                $file_name_with_path = 'uploads/class_bulk_upload_error_details_for_excel_file.xlsx';
                @unlink($path);
                @unlink($file_name_with_path);
                @ini_set('memory_limit', '-1');
                @set_time_limit(0);
                move_uploaded_file($_FILES['userfile']['tmp_name'], $path);
                // Importing excel sheet for bulk class & sections uploads
                include 'Simplexlsx.class.php';

                $xlsx = new SimpleXLSX($path);

                list($num_cols, $num_rows) = $xlsx->dimension();
                $f = 0;
                $fielsdStringForAdmin = "Class Name,Class Numeric Name,Section Name,Seection Nick Name,Teacher Email Id,Room No,Max Capacity";
                $fielsdString = "class_name,name_numeric,section_name,nick_name,email,room_no,max_capacity";
                $fielsdStringMandotary = $fielsdString; //"class_name,name_numeric,section_name,email";
                $fielsdArr = explode(',', $fielsdString);
                $fielsdStringForAdminArr = explode(',', $fielsdStringForAdmin);
                $fielsdStringMandotaryArr = explode(',', $fielsdStringMandotary);
                $someRowError = FALSE;
                $errorMsgArr = array();
                $errorExcelArr = array();
                $errorExcelArr[] = $fielsdStringForAdminArr;
                $errorRowNo = 2;
                foreach ($xlsx->rows() as $r) {
                    // Ignore the inital name row of excel file
                    $data = array();
                    $dataClass = array();
                    $error = FALSE;
                    // Ignore the inital name row of excel file
                    if ($f == 0) {
                        $f++;
                        continue;
                    } $f++;
                    if ($num_cols > count($fielsdArr)) {
                        $num_cols = count($fielsdArr);
                    }
                    $blankErrorMsgArr = array();
                    $rsTeacher = array();
                    $rsSectionClassTeacherExist = array();
                    $rsSectionClassBothExist = array();
                    $errorRowIncrease = FALSE;
                    for ($i = 0; $i < $num_cols; $i++) {
                        // checking is filds is mandetory or not
                        if (in_array($fielsdArr[$i], $fielsdStringMandotaryArr)) {
                            if (trim($r[$i]) == "") {
                                //echo "here"; //die();
                                $error = TRUE;
                                $blankErrorMsgArr[] = $fielsdStringForAdminArr[$i] . " should not be blank at row no " . $errorRowNo;
                            } else {
                                // now check teh uniques for email then phone
                                if ($fielsdArr[$i] == 'email') {

                                    $rsTeacher = $this->Teacher_model->get_data_by_cols('teacher_id', array('email' => trim($r[$i])));
                                    $validPhoneEmailCheck = $this->checkValidPhoneEmail(trim($r[$i]), 'email');
                                    if ($validPhoneEmailCheck != "ok") {
                                        $error = TRUE;
                                        $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " Should be " . $validPhoneEmailCheck . " at row no -" . $errorRowNo;
                                    }

                                    if (count($rsTeacher) == 0) {
                                        $error = TRUE;
                                        $errorMsgArr[] = "Teacher email id not exists at row no " . $errorRowNo;
                                    }
                                }
                            }
                        }
                        $data[trim($fielsdArr[$i])] = trim($r[$i]);
                    }
                    $this->load->model('Class_model');
                    //pre($data);die;
                    $rsSectionClassTeacherExist = $this->Class_model->check_section_exist_with_class_and_teacher($data['section_name'], $data['class_name'], $data['email']);
                    if (count($rsSectionClassBothExist) > 0) {
                        $error = TRUE;
                        $errorMsgArr[] = "section,class name and teacher are already exists at row no - " . $errorRowNo;
                    }

                    $rsSectionClassBothExist = $this->Class_model->check_section_exist_with_class($data['section_name'], $data['class_name']);

                    if (count($blankErrorMsgArr) > 0) {
                        $error = TRUE;
                        if (count($blankErrorMsgArr) <= count($fielsdArr)) {
                            foreach ($blankErrorMsgArr AS $errorKey => $errorVal) {
                                $errorMsgArr[] = $errorVal;
                            }
                        }
                    }

                    if ($error === FALSE) {
                        $classDataArr = $this->Class_model->get_data_by_cols('class_id', array('name' => $data['class_name']));
                        if (count($classDataArr) > 0) {
                            $class_id = $classDataArr[0]->class_id;
                        } else {
                            $class_id = $this->Class_model->add(array('name' => $data['class_name'], 'name_numeric' => $data['name_numeric'], 'teacher_id' => $rsTeacher[0]->teacher_id, 'isActive' => '1'));
                        }
                        $rsCheckSectionArr = array('name' => $data['section_name'], 'class_id' => $class_id, 'teacher_id' => $rsTeacher[0]->teacher_id);
                        $rsCheckSectionDataArr = $this->Section_model->get_data_by_cols('section_id', $rsCheckSectionArr);
                        if (count($rsCheckSectionDataArr) == 0) {
                            $sectionArr = array('name' => $data['section_name'], 'class_id' => $class_id, 'teacher_id' => $rsTeacher[0]->teacher_id, 'nick_name' => $data['nick_name'], 'room_no' => $data['room_no'], 'max_capacity' => $data['max_capacity']);
                            $this->Class_model->save_section($sectionArr);
                        }
                    } else {
                        $errorExcelArr[] = $r;
                        $someRowError = TRUE;
                    }
                    $errorRowNo++;
                }

                //pre($errorMsgArr); exit;
                if ($someRowError == FALSE) {
                    //$this->generate_cv($error_msg);
                    generate_log("No error for this upload at - " . time(), 'class_bulk_upload' . date('d-m-Y-H') . '.log');
                    $this->session->set_flashdata('flash_message', get_phrase('classes_added'));
                    redirect(base_url() . 'index.php?school_admin/bulk_upload/', 'refresh');
                } else {
                    //pre($errorMsgArr); die('here');
                    generate_log(json_encode($errorMsgArr), 'class_bulk_upload_error_details.log', TRUE);
                    @unlink($file_name_with_path);
                    create_excel_file($file_name_with_path, $errorExcelArr, 'Class Upload Data');
                    $this->session->set_flashdata('flash_message_error', "Some rows are not uploaded,due to invalid data.");
                    redirect(base_url() . 'index.php?school_admin/class_bulk_upload_error', 'refresh');
                }
            } else {
                $this->session->set_flashdata('flash_message', "Invalid class bulk upload file.");
            }
        }
        redirect(base_url() . 'index.php?school_admin/bulk_upload', 'refresh');
    }

    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['classes_record'] = $this->Class_model->get_class_teacher_detail_array();
    $page_data['teachers'] = $this->Teacher_model->get_teacher_array();
    $page_data['page_name'] = 'class';
    $page_data['page_title'] = get_phrase('manage_class');
    $this->load->view('backend/index', $page_data);
}

// ACADEMIC SYLLABUS
function academic_syllabus($class_id = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model("Class_model");
    $this->load->model("Academic_syllabus_model");
    $page_data = $this->get_page_data_var();
    if ($class_id == '') {
        $this->load->model("Class_model");
        $class_id = $this->Class_model->get_first_class_id();
    }
    if ($class_id != '') {
        $rs_academic_syllabus = $this->Academic_syllabus_model->get_all(array('class_id' => $class_id, 'year' => $this->globalSettingsRunningYear));
        $page_data['syllabus'] = $rs_academic_syllabus;
    }
    /* foreach ($page_data['syllabus'] as $k => $v) {
      $page_data['syllabus'][$k]['uploader_name'] = $this->Academic_syllabus_model->get_uploader_name($v['uploader_type'], $v['uploader_id']);
      } */

    $page_data['class_name'] = $this->Class_model->get_data_by_cols('name', array('class_id' => $class_id), 'result_array');
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_name'] = 'academic_syllabus';
    $page_data['page_title'] = get_phrase('academic_syllabus');
    $page_data['class_id'] = $class_id;
//    $page_data['syllabus'] = $rs_academic_syllabus;
    $page_data['classes'] = $this->Class_model->get_class_array();
    $this->load->view('backend/index', $page_data);
}

function upload_academic_syllabus() {
    $this->load->model("Class_model");
    $data['academic_syllabus_code'] = substr(md5(rand(0, 1000000)), 0, 7);
    $data['title'] = $this->input->post('title');
    $data['description'] = $this->input->post('description');
    $data['class_id'] = $this->input->post('class_id');
    $data['uploader_type'] = $this->session->userdata('login_type');
    $data['uploader_id'] = $this->session->userdata('login_user_id');
    $data['year'] = $this->globalSettingsRunningYear;
    $data['timestamp'] = strtotime(date("Y-m-d H:i:s"));
    $files = $_FILES['file_name'];
    $this->load->library('upload');
    $config['upload_path'] = 'uploads/syllabus/';
    $config['allowed_types'] = 'txt|doc|docx|jpg|png|gif|xls|pdf|jpeg|csv|xlsx|xlx';
    $config['remove_spaces'] = FALSE;
    $_FILES['file_name']['name'] = $files['name'];
    $_FILES['file_name']['type'] = $files['type'];
    $_FILES['file_name']['tmp_name'] = $files['tmp_name'];
    $_FILES['file_name']['size'] = $files['size'];
    $this->upload->initialize($config);
    if ($this->upload->do_upload('file_name')) {
        $data['file_name'] = $_FILES['file_name']['name'];
        $this->Class_model->upload_academic_syllabus($data);
        $this->session->set_flashdata('flash_message', get_phrase('syllabus_uploaded'));
        redirect(base_url() . 'index.php?school_admin/academic_syllabus/' . $data['class_id'], 'refresh');
    } else {
        $this->session->set_flashdata('flash_message', get_phrase('Sorry, File extension is not supported, please upload only txt,.doc,.docx, .xls, .pdf, .images'));
        redirect(base_url() . 'index.php?school_admin/academic_syllabus/' . $data['class_id'], 'refresh');
    }
}

function download_academic_syllabus($academic_syllabus_code) {
    $this->load->model("Class_model");
    $file_name = $this->Class_model->get_academic_syllabus_name($academic_syllabus_code);
    $this->load->helper('download');
    $data = file_get_contents("uploads/syllabus/" . $file_name);
    $name = $file_name;
    force_download($name, $data);
}

function delete_academic_syllabus($academic_syllabus_code, $class_id) {
    $this->load->model("Class_model");
    $file_name = $this->Class_model->get_academic_syllabus_name($academic_syllabus_code);
    unlink("uploads/syllabus/" . $file_name);
    $this->Class_model->delete_academic_syllabus($academic_syllabus_code);
    $this->session->set_flashdata('flash_message', get_phrase('syllabus_deleted'));
    redirect(base_url() . 'index.php?school_admin/academic_syllabus/' . $class_id, 'refresh');
}

function edit_academic_syllabus($academic_syllabus_code) {
    $this->load->model("Class_model");
    $data['title'] = $this->input->post('title');
    $data['description'] = $this->input->post('description');
    $data['class_id'] = $this->input->post('class_id');
    $data['uploader_type'] = $this->session->userdata('login_type');
    $data['uploader_id'] = $this->session->userdata('login_user_id');
    $data['year'] = $this->Class_model->get_year_academic_syllabus();
    $data['timestamp'] = strtotime(date("Y-m-d H:i:s"));
    if (!empty($_FILES['file_name']['name'])) {
        $file_name = $this->Class_model->get_academic_syllabus_name($academic_syllabus_code);
        unlink("uploads/syllabus/" . $file_name);
        $files = $_FILES['file_name'];
        $this->load->library('upload');
        $config['upload_path'] = 'uploads/syllabus/';
        $config['allowed_types'] = '*';
        $_FILES['file_name']['name'] = $files['name'];
        $_FILES['file_name']['type'] = $files['type'];
        $_FILES['file_name']['tmp_name'] = $files['tmp_name'];
        $_FILES['file_name']['size'] = $files['size'];
        $this->upload->initialize($config);
        $this->upload->do_upload('file_name');
        $data['file_name'] = $_FILES['file_name']['name'];
    }
    $this->Class_model->update_academic_syllabus($data, $academic_syllabus_code);
    $this->session->set_flashdata('flash_message', get_phrase('syllabus_updated'));
    redirect(base_url() . 'index.php?school_admin/academic_syllabus/' . $data['class_id'], 'refresh');
}

/* * **MANAGE SECTIONS**** */

function section($class_id = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model("Class_model");
    $this->load->model("Section_model");
    $this->load->model("Enroll_model");
    $year = $this->globalSettingsRunningYear;
    // detect the first class
    $page_data = $this->get_page_data_var();
    if ($class_id == '') {
        $this->load->model("Class_model");
        $class_id = $this->Class_model->get_first_class_id();
    }
    $page_data['classes'] = $this->Class_model->get_class_array();
    $section = $this->Class_model->get_section_teacher_detail_array(array('class_id' => $class_id));
    $max_students = $this->Section_model->get_max_capacity($class_id);
    $students_allotted = $this->Enroll_model->get_alloted_students_count($class_id, $year);
    if (!empty($max_students)) {
        $page_data['capacity'] = $max_students[0]['capacity'];
    } else {
        $page_data['capacity'] = '';
    }
    if (!empty($students_allotted)) {
        $page_data['student_alloted'] = $students_allotted['0']['count'];
    } else {
        $page_data['student_alloted'] = '';
    }

    $param2 = array('section.class_id' => $class_id);
    $count = array();
    $count_all = array();
    foreach ($section as $row) {
        $param2 = array('enroll.section_id' => $row['section_id']);
        $count = $this->Class_model->get_count_students($param2, $year);
        if (!empty($count)) {
            $count_all[]['count'] = $count[0]['count'];
        } else {
            $count_all[]['count'] = "0";
        }
    }

    $i = 0;
    $NewArray = array();
    foreach ($section as $value) {
        $NewArray[$i] = array_merge($value, $count_all[$i]);
        $i++;
    }

    foreach ($section as $k => $value) {
        $NewArray[$k] = array_merge($value, $count_all[$k]);
        $NewArray[$k]['transaction'] = $this->Crud_model->getSectionTransaction($value['section_id']);
    }
    $page_data['class_name'] = $this->Class_model->single_name($class_id);

    //$page_data['stud_count']    =  $this->Enroll_model->get_alloted_students_count($section_id, $year); 
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['sections'] = $NewArray;
    $page_data['page_name'] = 'section';
    $page_data['page_title'] = get_phrase('manage_sections');
    $page_data['class_id'] = $class_id;
    $this->load->view('backend/index', $page_data);
}

function sections($param1 = '', $param2 = '', $param3 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model("Class_model");
    $page_data = $this->get_page_data_var();
    if ($param1 == 'create') {
        $this->form_validation->set_rules('name', 'section name', 'trim|required');
        $this->form_validation->set_rules('nick_name', 'section nick name', 'trim|required');
        $this->form_validation->set_rules('class_id', 'class name', 'trim|required');
        $this->form_validation->set_rules('teacher_id', 'Teacher_id', 'trim|required');
        $this->form_validation->set_rules('room_no', 'room number', 'trim|required|is_unique[section.room_no]');
        $this->form_validation->set_message('is_unique', 'Could not add section because Room Number ' . $this->input->post('room_no') . " is already allocated by other section");
        $this->form_validation->set_rules('max_capacity', 'maximum capicity', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $class_id = $this->input->post('class_id');
            $this->session->set_flashdata('flash_message_error', validation_errors());
            redirect(base_url() . 'index.php?school_admin/section/' . $class_id, 'refresh');
        } else {
            $data['name'] = $this->input->post('name');
            $data['nick_name'] = $this->input->post('nick_name');
            $data['class_id'] = $this->input->post('class_id');
            $data['teacher_id'] = $this->input->post('teacher_id');
            $data['room_no'] = $this->input->post('room_no');
            $data['max_capacity'] = $this->input->post('max_capacity');

            $count = $this->Section_model->get_name($data['class_id'], $data['name']);

            if (count($count) < 1) {
                $this->Class_model->save_section($data);
                $this->session->set_flashdata('flash_message', get_phrase('section_added_successfully'));
                redirect(base_url() . 'index.php?school_admin/section/' . $data['class_id'], 'refresh');
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('duplicate_entry'));
                redirect(base_url() . 'index.php?school_admin/section/' . $data['class_id'], 'refresh');
            }
        }
    }
    if ($param1 == 'edit') {
        $class_id = $this->uri->segment(5);
        $this->form_validation->set_rules('name', 'section name', 'trim|required');
        $this->form_validation->set_rules('nick_name', 'section nick name', 'trim|required');
//        $this->form_validation->set_rules('class_id', 'class name', 'trim|required');
        $this->form_validation->set_rules('teacher_id', 'Teacher_id', 'trim|required');
        $this->form_validation->set_rules('room_no', 'room number', 'trim|required');
        $this->form_validation->set_rules('max_capacity', 'maximum capicity', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_message_error', validation_errors());
            redirect(base_url() . 'index.php?school_admin/section/' . $class_id, 'refresh');
        } else {
            $data['name'] = $this->input->post('name');
            $data['nick_name'] = $this->input->post('nick_name');
//            $data['class_id'] = $this->input->post('class_id');
            $data['teacher_id'] = $this->input->post('teacher_id');
            $data['room_no'] = $this->input->post('room_no');
            $data['max_capacity'] = $this->input->post('max_capacity');

            $count = $this->Section_model->check_section($class_id, $data['name'], $param2);

//            echo $count[0]['count'];exit;
            if ($count == 0) {

                $count_room = $this->Section_model->check_room_no($data['room_no'], $param2);
//                echo $count_room[0]['count_room'];exit;    
                if ($count_room == 0) {
                    $year = $this->globalSettingsSMSDataArr[2]->description;
                    $count_students = $this->Class_model->get_count_students(array('section.section_id' => $param2), $year);
                    if (!empty($count_students)) {
                        $student = $count_students[0]['count'];
                    } else {
                        $count_students[0]['count'] = 0;
                        $student = $count_students[0]['count'];
                    }
                    if ($data['max_capacity'] >= $student) {
                        $this->Class_model->update_section($data, array("section_id" => $param2));
                        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
                        redirect(base_url() . 'index.php?school_admin/section/' . $class_id, 'refresh');
                    } else {
                        $this->session->set_flashdata('flash_message_error', get_phrase('Could not edit because, maximum_capacity_should_be greater_than_no .of_students'));
                        redirect(base_url() . 'index.php?school_admin/section/' . $class_id, 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('Could not edit because, Duplicate Entry of Room Number'));
                    redirect(base_url() . 'index.php?school_admin/section/' . $class_id, 'refresh');
                }
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('Could not edit because, Duplicate Entry'));
                redirect(base_url() . 'index.php?school_admin/section/' . $class_id, 'refresh');
            }
        }
    }

    if ($param1 == 'delete') {
        $year = $this->globalSettingsRunningYear;
        $this->load->model('Enroll_model');
        $students = $this->Enroll_model->check_student_before_delete_section($param2, $param3, $year);
        if (!empty($students)) {
            $this->session->set_flashdata('flash_message', get_phrase('Could not delete the section because students are present in this class and section'));
            redirect(base_url() . 'index.php?school_admin/section/' . $param3, 'refresh');
        } else {
            $this->Class_model->delete_section(array("section_id" => $param2));
            $this->session->set_flashdata('flash_message', get_phrase('data_deleted_successfully'));
            redirect(base_url() . 'index.php?school_admin/section/' . $param3, 'refresh');
        }
    }
}

function get_class_section($class_id) {
    $this->load->model("Class_model");
    $page_data = $this->get_page_data_var();
    $sections = $this->Class_model->get_section_array(array("class_id" => $class_id));
    $response_html = ' ';
    $response_html .= '<option value=" ">' . "Select Section" . '</option>';
    foreach ($sections as $row) {
        $response_html .= '<option value="' . $row['section_id'] . '">' . $row['name'] . '</option>';
    }
    echo $response_html;
    exit;
}

function get_class_subject($class_id) {
    $this->load->model("Subject_model");
    $subjects = $this->Subject_model->get_subject_array(array("class_id" => $class_id));
    $page_data = $this->get_page_data_var();
    foreach ($subjects as $row) {
        echo '<option value="' . $row['subject_id'] . '">' . $row['name'] . '</option>';
    }
}

function get_class_students($class_id) {
    $students = $this->Enroll_model->get_data_by_cols('*', array(
        'class_id' => $class_id, 'year' => $this->globalSettingsRunningYear), 'result_type');
    $page_data = $this->get_page_data_var();
    echo '<option value=" ">' . "Select Student" . '</option>';
    foreach ($students as $row) {
        $name = $this->Student_model->get_student_name($row['student_id']);
        echo '<option value="' . $row['student_id'] . '">' . $name . '</option>';
    }
}

/* * **EXAM ROUTINE**** */

function exam_routine($exam_id = '', $class_id = '', $section_id = '') {
    $this->load->model('Exam_model');
    $this->load->model("Section_model");

    $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
    $page_data = $this->get_page_data_var();
    $page_data['section_id'] = "";
    $page_data['exams'] = $this->Exam_model->get_data_by_cols('*', array('year' => $running_year), 'result_array');
    $grading_method = $this->Exam_model->get_exam_grading($exam_id);

    if ($exam_id == '') {
        //$page_data['exam_id'] = $page_data['exams'][0]['exam_id'];
        $page_data['grading'] = $page_data['exams'][0]['grading'];
    } else {
        $page_data['exam_id'] = $exam_id;
        $page_data['grading'] = $grading_method;
    }
    if ($class_id != '') {
        $page_data['class_id'] = $class_id;
        $page_data['sections'] = $this->Section_model->get_data_by_cols('*', array('class_id' => $class_id), 'result_array');
    }
    if ($section_id != '') {
        $page_data['section_id'] = $section_id;
    }
    

    if ($page_data['grading'] == 2) {
        $page_data['classes'] = $this->Cce_model->get_cce_classes();
    } else if ($page_data['grading'] == 3) {
        $page_data['classes'] = $this->Class_model->get_cwa_classes();
    } else if ($page_data['grading'] == 4) {
        $page_data['classes'] = $this->Class_model->get_gpa_classes();
    } else if ($page_data['grading'] == 5) {
        $page_data['classes'] = $this->Cce_model->get_icse_classes();
    } else if ($page_data['grading'] == 6) {
        $page_data['classes'] = $this->Class_model->get_ibo_classes();
    } else if ($page_data['grading'] == 7) {
        $page_data['classes'] = $this->Cce_model->get_igcse_classes();
    } else {
        $page_data['classes'] = $this->Class_model->get_data_by_cols('*', array(), 'result_array');
    }

    $page_data['sections'] = $this->Section_model->get_data_by_cols("*", array('class_id' => $class_id), "result_array");
    $page_data['page_name'] = 'exam_routine';
    $page_data['page_title'] = get_phrase('exam_routine');
    $this->load->view('backend/index', $page_data);
}

function get_exam_subject($param1 = '') {
    $this->load->model('Exam_model');
    $this->load->model('Event_model');
    $page_data = $this->get_page_data_var();
    if ($param1 == 'save_subjects') {
        $subjects = $this->input->post('subject_id');
        $start_time = $this->input->post('start_time');
        $duration = $this->input->post('duration');
        $room_no = $this->input->post('room_no');
        $teachers = $this->input->post('teacher');
        $data['exam_id'] = $this->input->post('exam_id');
        $data['class_id'] = $this->input->post('class_id');
        $data['section_id'] = $this->input->post('section_id');
        $count = 0;
        $exam_name = $this->Exam_model->get_exam_name($data['exam_id']);

        $sec = $this->Section_model->get_data_by_cols('name', array('section_id' => $data['section_id']), 'result');
        $section_name = $sec[0]->name;

        $cls = $this->Class_model->get_data_by_cols('name', array('class_id' => $data['class_id']), 'result');
        $class_name = $cls[0]->name;

        $message = $exam_name . " of Class:" . $class_name . " section:" . $section_name . " schedule announced.";
        foreach ($subjects as $subject) {
            $data['subject_id'] = $subject;
            $data['start_datetime'] = date('Y-m-d H:i:s', strtotime($start_time[$count]));
            $data['duration'] = $duration[$count];
            $data['room_no'] = $room_no[$count];
            $data['invigilator'] = $teachers[$count];
            $this->Exam_model->save_exam_routine($data);
            $count++;
        }
        $notice['notice_title'] = $exam_name;
        $notice['notice'] = $message;
        $notice['create_timestamp'] = time();
        $this->Event_model->save_notice($notice);
        $this->session->set_flashdata('flash_message', get_phrase('exam_routine_added'));
        redirect(base_url() . 'index.php?school_admin/exam_routine/');
    }
    $exam_id = $this->input->post('exam_id');
    $class_id = $this->input->post('class_id');
    $section_id = $this->input->post('section_id');
    $page_data['exam_routine'] = $this->Exam_model->get_exam_routine(array('exam_id' => $exam_id, 'class_id' => $class_id, 'section_id' => $section_id));

    $this->load->model('Subject_model');

    $grading_method = $this->Exam_model->get_exam_grading($exam_id);

    $page_data['subjects'] = $this->Subject_model->get_exam_subject_array(array("class_id" => $class_id, 'section_id' => $section_id), array('grading_method' => $grading_method));
    //pre($page_data['subjects']); die();
    $page_data['exam_id'] = $exam_id;
    $page_data['class_id'] = $class_id;
    $page_data['section_id'] = $section_id;
    $page_data['grading_method'] = $grading_method;
    $page_data['page_title'] = get_phrase('manage_exam_routine');
    $page_data['teachers'] = $this->Teacher_model->get_data_by_cols('*', array(), 'result_array');
    if (!empty($section_id)) {
        $exam_routine = $this->Exam_model->get_exam_routine(array('exam_id' => $exam_id, 'class_id' => $class_id, 'section_id' => $section_id));
    }

    $this->load->view('backend/school_admin/exam_routine_subjects.php', $page_data);
}

/* * **MANAGE EXAMS**** */

function exam($param1 = '', $param2 = '', $param3 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');

    $this->load->model("Exam_model");
    $page_data = $this->get_page_data_var();
    if (isset($param1) && $param1 == 'create') {

        $data['name'] = $this->input->post('name');
        $data['date'] = $this->input->post('date');
        $data['comment'] = $this->input->post('comment');
        $data['year'] = $this->globalSettingsRunningYear;
        $data['grading'] = $this->input->post('grade_id');
        $rs = $this->Exam_model->create_exam($data);
        if ($rs) {
            $response_array = array('status' => "success", 'message' => "Exam Has been Created");
        }
        $this->session->set_flashdata('flash_message', get_phrase('exam_added'));
        redirect(base_url() . 'index.php?school_admin/exam/', 'refresh');
    }
    if ($param1 == 'edit' && $param2 == 'do_update') {
        $data['name'] = $this->input->post('name');
        $data['date'] = $this->input->post('date');
        $data['comment'] = $this->input->post('comment');
        $data['year'] = $this->globalSettingsRunningYear;

        $rs = $this->Exam_model->update_data($data, array('exam_id' => $param3));
        if ($rs) {
            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        }
        redirect(base_url() . 'index.php?school_admin/exam/', 'refresh');
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->Exam_model->get_data_by_cols('*', array(
            'exam_id' => $param2
                ), 'result_type');
    }
    if ($param1 == 'delete') {
        $this->Exam_model->remove_exam($param2);
        redirect(base_url() . 'index.php?school_admin/exam/', 'refresh');
    }

    if ($param1 == 'import_excel') {
        $path = "uploads/exam_import.xlsx";
        //@unlink('uploads/subject_import.xlsx');
        @unlink($path);
        @unlink('uploads/exam_bulk_upload_error_details.log');

        if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $path)) {
            die('not moving');
        }
        @ini_set('memory_limit', '-1');
        @set_time_limit(0);
        include 'Simplexlsx.class.php';
        $xlsx = new SimpleXLSX($path);
        list($num_cols, $num_rows) = $xlsx->dimension();
        $f = 0;
        $fielsdStringForAdmin = "Exam Name,Commencing Date,Academic Year,Comment,Evaluatiion Method,CCE Exam Category,CCE Internal Exam Category,IBO Exam Category";
        $fielsdString = "name,date,year,comment,grading,id_cce_exam_category,assessment_id,ibo_exam_category";
        $fielsdStringMandotary = "name,date,year,grading";
        $fielsdArr = explode(',', $fielsdString);
        $fielsdStringForAdminArr = explode(',', $fielsdStringForAdmin);
        $fielsdStringMandotaryArr = explode(',', $fielsdStringMandotary);
        $someRowError = FALSE;
        $errorMsgArr = array();
        $errorExcelArr = array();
        $errorExcelArr[] = $fielsdStringForAdminArr;
        $errorRowNo = 2;
        //pre($xlsx->rows());die;
        foreach ($xlsx->rows() as $r) {
            //echo '<pre>'; //print_r($r);die;
            $data = array();
            $dataParent = array();
            $error = FALSE;
            // Ignore the inital name row of excel file
            if ($f == 0) {
                $f++;
                continue;
            } $f++;
            //pre($r);
            //pre('above are $r data');
            //if ($num_cols > count($fielsdArr)) {
            $num_cols = count($fielsdArr);
            //die($num_cols);
            //}
            $blankErrorMsgArr = array();
            $errorRowIncrease = FALSE;

            //echo $num_cols;die;
            for ($i = 0; $i < $num_cols; $i++) {    // checking is filds is mandetory or not
                //echo $fielsdArr[$i] . '<br>';
                if (in_array($fielsdArr[$i], $fielsdStringMandotaryArr)) {
                    //now validating mandetory fiels
                    //generate_log("Field " . $fielsdArr[$i] . " value \n", 'exam_bulk_upload_' . date('d-m-Y-H') . '.log');
                    //echo $r[$i].'<br>';
                    if (trim($r[$i]) == "") {
                        //echo "here"; //die();
                        $error = TRUE;
                        $blankErrorMsgArr[] = $fielsdStringForAdminArr[$i] . " should not be blank at row no " . $errorRowNo;
                    } else {
                        //pre($i);
                    }

                    if ($fielsdArr[$i] == 'name') {
                        $rsClass = $this->Exam_model->get_name_bulk_upload($r[$i]);
                        if (count($rsClass) == 0) {
                            $data['name'] = trim($r[$i]);
                        } else {
                            $data['name'] = "";
                            $error = TRUE;
                            $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " content invalid data at row no -" . $errorRowNo . ' is already exist.';
                        }
                    }

                    if ($fielsdArr[$i] == 'date') {
                        /* $excelDOB = trim($r[$i]);
                          $unixTimestamp = ($excelDOB - 25569) * 86400;
                          $rawDOB= date('d.m.Y',$unixTimestamp); */
                        $rawDOB = trim($r[$i]);
                        $newDOB = $this->get_mysql_date_formate_from_raw($rawDOB);
                        if ($newDOB != "") {
                            $data[$fielsdArr[$i]] = $newDOB;
                        } else {
                            $error = TRUE;
                            $errorMsgArr[] .= $fielsdStringForAdminArr[$i] . " content invalid data at row no -" . $errorRowNo;
                        }
                    }


                    if ($fielsdArr[$i] == 'year') {
                        $year_arr = explode('-', trim($r[$i]));
                        if (count($year_arr) == 2) {
                            if (strlen($year_arr[0]) == 4 && strlen($year_arr[1]) == 4) {
                                $data[$fielsdArr[$i]] = trim($r[$i]);
                            } else {
                                $error = TRUE;
                                $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " content invalid data at row no -" . $errorRowNo;
                            }
                        } else {
                            $error = TRUE;
                            $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " content invalid data at row no -" . $errorRowNo;
                        }
                    }

                    if ($fielsdArr[$i] == 'grading') {
                        if (strtolower($r[$i]) == 'general') {
                            $data['grading'] = 1;
                        } else {
                            $gradingArr = $this->Evaluation_model->get_name_bulk_upload($r[$i]);
                            if (!empty($gradingArr)) {
                                $data[$fielsdArr[$i]] = $gradingArr[0]->evaluation_id;
                            } else {
                                $error = TRUE;
                                $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " content invalid data at row no -" . $errorRowNo;
                            }
                        }
                        $data['grading_name'] = strtolower(trim($r[$i]));
                    }
                    if (!empty($errorMsgArr)) {
                        //pre($errorMsgArr);die;
                    }
                    //pre(trim($fielsdArr[$i]));pre('$error');pre($error);
                } else {
                    //pre($errorMsgArr);//die;
                    //pre(trim($fielsdArr[$i]));pre('$error');pre($error);
                    if ($fielsdArr[$i] == 'comment') {
                        $data[$fielsdArr[$i]] = trim($r[$i]);
                    }
                    if ($fielsdArr[$i] == 'id_cce_exam_category') {
                        $data['id_cce_exam_category'] = trim($r[$i]);
                    }

                    if ($fielsdArr[$i] == 'assessment_id') {
                        $data['assessment_id'] = trim($r[$i]);
                    }

                    if ($fielsdArr[$i] == 'ibo_exam_category') {
                        $data['ibo_exam_category'] = trim($r[$i]);
                    }
                }
            }
            //die;
            if (count($blankErrorMsgArr) > 0) {
                $error = TRUE;
                if (count($blankErrorMsgArr) <= count($fielsdArr)) {
                    foreach ($blankErrorMsgArr AS $errorKey => $errorVal) {
                        $errorMsgArr[] = $errorVal;
                    }
                }
            }
            //pre($errorRowNo);
            if (strtolower($data['grading_name']) == 'cce') {
                if ($data['id_cce_exam_category'] == "") { //pre("grading cce"); pre($data);die($errorRowNo.'error');
                    $error = TRUE;
                    $errorMsgArr[] = "CCE Exam Category content should no blank at row no - " . $errorRowNo;
                } else {
                    $cce_exam_category_sql = "SELECT * FROM `cce_exam_category` WHERE LOWER(cce_cat_name)='" . strtolower($data['id_cce_exam_category']) . "'";
                    //echo $cce_exam_category_sql.' = '.$errorRowNo; //die;
                    $rs_cce_exam_category = $this->db->query($cce_exam_category_sql)->result();
                    if (count($rs_cce_exam_category) == 0) { //pre("grading cce"); //pre($data);die($errorRowNo.'error');
                        $error = TRUE;
                        $errorMsgArr[] = "CCE Exam Category content invalid data at row no -" . $errorRowNo;
                    } else {
                        $data['exam_type'] = $rs_cce_exam_category[0]->id;
                    }
                    if (strtolower($data['id_cce_exam_category']) == 'internal exam') {
                        if ($data['assessment_id'] == "") {
                            $error = TRUE;
                            $errorMsgArr[] = "CCE Internal Exam Category content should not blank at row no " . $errorRowNo;
                        } else {
                            $cce_internal_assessments_sql = "SELECT * FROM `cce_internal_assessments` WHERE LOWER(assessment_name)='" . strtolower($data['assessment_id']) . "'";
                            //pre($cce_internal_assessments_sql." = ".$errorRowNo);
                            $rs_cce_internal_assessments = $this->db->query($cce_internal_assessments_sql)->result();
                            if (count($rs_cce_internal_assessments) == 0) {
                                $error = TRUE;
                                $errorMsgArr[] = "CCE Internal Exam Category content invalid data at row no " . $errorRowNo;
                            } else {
                                $data['internal_subcat'] = $rs_cce_internal_assessments[0]->assessment_id;
                            }
                        }
                    } else {
                        $data['internal_subcat'] = 0;
                    }
                }
                if (!array_key_exists('exam_category', $data)) {
                    $data['exam_category'] = "";
                }
            } else if (strtolower($data['grading_name']) == 'ibo') {
                if ($data['ibo_exam_category'] == "") {
                    $error = TRUE;
                    $errorMsgArr[] = "IBO Exam Category content should no blank at row no - " . $errorRowNo;
                } else {
                    if (strtolower($data['ibo_exam_category']) == strtolower('Formative Assessment')) {
                        $data['exam_category'] = 'Fa';
                    } else if (strtolower($data['ibo_exam_category']) == strtolower('Summative Assessment')) {
                        $data['exam_category'] = 'Sa';
                    } else {
                        $error = TRUE;
                        $errorMsgArr[] = "IBO Exam Category content invallid data at row no - " . $errorRowNo;
                    }
                }
                if (!array_key_exists('internal_subcat', $data)) {
                    $data['internal_subcat'] = "";
                }
                if (!array_key_exists('exam_type', $data)) {
                    $data['exam_type'] = "";
                }
            } else {
                $data['exam_type'] = "";
                $data['internal_subcat'] = "";
                $data['exam_category'] = "";
            }

            //pre($data);            continue;
            unset($data['grading_name']);
            unset($data['id_cce_exam_category']);
            unset($data['assessment_id']);
            unset($data['ibo_exam_category']);
            if ($error === FALSE) {
                $data['status'] = 1;
                //pre($data);die;
                $exam_id = $this->Exam_model->create_exam_by_bulk_upload($data);
                $data = array();
                $errorRowNo++;
            } else {
                //pre($errorMsgArr);//die;
                $errorRowNo++;
                $errorExcelArr[] = $r;
                $someRowError = TRUE;
            }
        } //ends foreach
        //pre($errorMsgArr); exit;

        if ($someRowError == FALSE) {
            //$this->generate_cv$error_msg);
            generate_log("No error for this upload at - " . time(), 'exam_bulk_upload' . date('d-m-Y-H') . '.log');
            $this->session->set_flashdata('flash_message', get_phrase('exam_details_added'));
            redirect(base_url() . 'index.php?school_admin/bulk_upload/', 'refresh');
        } else {
            //pre($errorMsgArr); die('here');
            generate_log(json_encode($errorMsgArr), 'exam_bulk_upload_error_details.log', TRUE);
            $file_name_with_path = 'uploads/exam_bulk_upload_error_details_for_excel_file.xlsx';
            @unlink($file_name_with_path);
            create_excel_file($file_name_with_path, $errorExcelArr, 'Exam Upload Data');
            $this->session->set_flashdata('flash_message_error', "Some rows are not uploaded,due to invalid data.");
            redirect(base_url() . 'index.php?school_admin/exam_bulk_upload_error', 'refresh');
        }
    }

    $this->load->model("Class_model");
    // $page_data['classes'] = $this->Class_model->get_class_array();
    $exams = array();
    $page_data['total_notif_num'] = $this->get_no_of_notication();

    $exams = $this->Exam_model->get_data_by_cols('*', array(), 'result_array', array('date' => 'ORDER BY', 'date' => 'DESC'));
    foreach ($exams as $key => $row) {
        $exams[$key]['transaction'] = $this->Crud_model->getExamTransaction($row['exam_id']);
    }

    $grading = $this->Evaluation_model->get_data_by_cols('*', array(), 'result_array', array('evaluation_id' => 'asc'));

    $page_data['gradings'] = $grading;
    $page_data['exams'] = $exams;

    $cce_exam_category = $this->Exam_model->cce_exam_category();
    $internal_category = $this->Exam_model->cce_internal_assessments();
    $page_data['cce_exam_category'] = $cce_exam_category;
    $page_data['cce_internal_category'] = $internal_category;
    $page_data['page_name'] = 'exam';
    $page_data['page_title'] = get_phrase('manage_exam');
    $this->load->view('backend/index', $page_data);
}

/* * ****** ONLINE EXAM **** */

function online_exam($param1 = '', $param2 = '', $param3 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    if (isset($param1) && $param1 == 'create') {
        $data['exam_name'] = $this->input->post('name');
        $data['comment'] = $this->input->post('comment');
        $data['passing_percent'] = $this->input->post('passing_percent');
        $data['instruction'] = $this->input->post('exam_instruction');
//        $data['attempt_count'] = $this->input->post('attempt_count');
        $data['duration'] = $this->input->post('exam_duration');
        $data['start_date'] = $this->input->post('start_date');
        $data['end_date'] = $this->input->post('end_date');
        $data['class_id'] = $this->input->post('class_id');
        $data['declare_result'] = $this->input->post('declare_result');
        $data['negative_marking'] = $this->input->post('negative_marking');
        $data['ques_random'] = $this->input->post('random_question');
        $data['finish_result'] = $this->input->post('result_after_finish');
//        $data['paid_exam'] = $this->input->post('paid_exam');
//        $data['amount'] = $this->input->post('amount');
        //$data['year'] = $this->globalSettingsRunningYear;
        // pre($data);
        //exit;
        $this->Exam_model->online_exam_save($data);
        $response_array = array('status' => "success", 'message' => "Exam Has been Created");

        //pre($data);
        //exit;
        $this->session->set_flashdata('flash_message', get_phrase('exam_added'));
        redirect(base_url() . 'index.php?school_admin/online_exam/', 'refresh');
        // print_r(json_encode($response_array));//exit;
    }
    if ($param1 == 'edit' && $param2 == 'do_update') {
        $data['exam_name'] = $this->input->post('name');
        $data['comment'] = $this->input->post('comment');
        $data['passing_percent'] = $this->input->post('passing_percent');
        $data['instruction'] = $this->input->post('exam_instruction');
//        $data['attempt_count'] = $this->input->post('attempt_count');
        $data['duration'] = $this->input->post('exam_duration');
        $data['start_date'] = $this->input->post('start_date');
        $data['end_date'] = $this->input->post('end_date');
        $data['class_id'] = $this->input->post('class_id');
        $data['declare_result'] = $this->input->post('declare_result');
        $data['negative_marking'] = $this->input->post('negative_marking');
        $data['ques_random'] = $this->input->post('random_question');
        $data['finish_result'] = $this->input->post('result_after_finish');
//        $data['paid_exam'] = $this->input->post('paid_exam');
//        $data['amount'] = $this->input->post('amount');

        $this->Exam_model->update_online_exam($param3, $data);

        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?school_admin/online_exam/', 'refresh');
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->Exam_model->get_online_data($param2);
    }
    if ($param1 == 'delete') {
        $this->Exam_model->online_exam_delete($param1);
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?school_admin/online_exam/', 'refresh');
    }
    if ($param1 == 'status') {
        if ($param2 == 'active') {
            $data = array('status' => 'inactive');
            $this->Exam_model->online_exam_status($param3, $data);

            $this->session->set_flashdata('flash_message', get_phrase('exam_inactive'));
        } else {
            $data = array('status' => 'active');
            $this->Exam_model->online_exam_status($param3, $data);

            $this->session->set_flashdata('flash_message', get_phrase('exam_active'));
        }
        redirect(base_url() . 'index.php?school_admin/online_exam/', 'refresh');
    }

    $this->load->model("Class_model");
    $page_data['classes'] = $this->Class_model->get_class_array();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['exams'] = $this->Exam_model->get_all_online_data();
    $page_data['page_name'] = 'online_exam';
    $page_data['page_title'] = get_phrase('manage_online_exam');
    $this->load->view('backend/index', $page_data);
}

/* * **************ADD QUESTION IN ONLINE EXAM  ******************* */

function add_question_online($param1 = '', $param2 = '', $param3 = '', $param4 = '') {

    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model("Subject_model");
    $this->load->model("Question_model");
    $page_data = $this->get_page_data_var();
    if (isset($param1) && $param1 == 'create') {
        $ques_type = $this->input->post('question_type');
        if ($ques_type == 1) {
            $correct_answer = array('type' => $this->input->post('correct_answer[]'));
            // pre();
            $valu = implode(",", $correct_answer['type']);
            $data['answer'] = $valu;
        }

        $param1 = $this->input->post('class_id');
        $param3 = $this->input->post('subject_id');
        $subject = $this->Subject_model->get_data_by_cols('*', array('class_id' => $param1, 'subject_id' => $param3), 'result_type');
        $section_id = $subject[0]['section_id'];
        $data['exam_id'] = $param2;
        $data['qtype_id'] = $this->input->post('question_type');
        if ($data['qtype_id'] == 1) {
            $this->form_validation->set_rules('answer1', 'Answer 1', 'trim|required');
            $this->form_validation->set_rules('answer2', 'Answer 2', 'trim|required');
            $this->form_validation->set_rules('answer3', 'Answer 3', 'trim|required');
            $this->form_validation->set_rules('answer4', 'Answer 4', 'trim|required');
            $this->form_validation->set_rules('subject_id', 'Subject', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_validation_error', validation_errors());

                redirect(base_url() . 'index.php?school_admin/add_question_online/' . $this->input->post('class_id') . '/' . $param2, 'refresh');
            } else {
                $data['subject_id'] = $this->input->post('subject_id');
                $data['class_id'] = $this->input->post('class_id');
                $data['section_id'] = $section_id;
                $data['question'] = $this->input->post('question');
                $data['true_false'] = $this->input->post('true_false_ques');
                $data['fill_blank'] = $this->input->post('blank_space');
                $data['option1'] = $this->input->post('answer1');
                $data['option2'] = $this->input->post('answer2');
                $data['option3'] = $this->input->post('answer3');
                $data['option4'] = $this->input->post('answer4');
                $data['option5'] = $this->input->post('answer5');
                $data['option6'] = $this->input->post('answer6');

                $data['explanation'] = $this->input->post('explanation');
                $data['hint'] = $this->input->post('hint');
                if (!empty($this->input->post('negative_marks'))) {
                    $data['negative_marks'] = $this->input->post('negative_marks');
                } else {
                    $data['negative_marks'] = 0;
                }
                $data['marks'] = $this->input->post('marks');
                $data['diff_id'] = $this->input->post('difficulty_level');
                $data['order'] = $this->input->post('order');
                //$data['year'] = $this->globalSettingsRunningYear;
                // pre($data);
                //exit;
                $this->load->model("Question_model");
                $this->Question_model->question_save($data);

                $response_array = array('status' => "success", 'message' => "Question Has been Created");
                //pre($data);
                //exit;           
                $this->session->set_flashdata('flash_message', get_phrase('question_added'));
                redirect(base_url() . 'index.php?school_admin/add_subject_online_exam/' . $param1 . '/' . $param2 . '/' . $data['subject_id'], 'refresh');
                // print_r(json_encode($response_array));//exit;
            }
        } else if ($data['qtype_id'] == 3) {
            $this->form_validation->set_rules('blank_space', 'Blank space', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('flash_message_error', "For Question Fill in the blank, Blank space cannot be empty please fill blank space");
                redirect(base_url() . 'index.php?school_admin/add_question/' . $param1 . '/' . $param2, 'refresh');
            } else {
                $data['subject_id'] = $this->input->post('subject_id');
                $data['class_id'] = $this->input->post('class_id');
                $data['section_id'] = $section_id;
                $data['question'] = $this->input->post('question');
                $data['true_false'] = $this->input->post('true_false_ques');
                $data['fill_blank'] = $this->input->post('blank_space');
                $data['option1'] = $this->input->post('answer1');
                $data['option2'] = $this->input->post('answer2');
                $data['option3'] = $this->input->post('answer3');
                $data['option4'] = $this->input->post('answer4');
                $data['option5'] = $this->input->post('answer5');
                $data['option6'] = $this->input->post('answer6');

                $data['explanation'] = $this->input->post('explanation');
                $data['hint'] = $this->input->post('hint');
                if (!empty($this->input->post('negative_marks'))) {
                    $data['negative_marks'] = $this->input->post('negative_marks');
                } else {
                    $data['negative_marks'] = 0;
                }
                $data['marks'] = $this->input->post('marks');
                $data['diff_id'] = $this->input->post('difficulty_level');
                $data['order'] = $this->input->post('order');
                //$data['year'] = $this->globalSettingsRunningYear;
                // pre($data);
                //exit;
                $this->load->model("Question_model");
                $this->Question_model->question_save($data);

                $response_array = array('status' => "success", 'message' => "Question Has been Created");
                //pre($data);
                //exit;           
                $this->session->set_flashdata('flash_message', get_phrase('question_added'));
                redirect(base_url() . 'index.php?school_admin/add_subject_online_exam/' . $param1 . '/' . $param2 . '/' . $data['subject_id'], 'refresh');
                // print_r(json_encode($response_array));//exit;
            }
        } else {
            $data['subject_id'] = $this->input->post('subject_id');
            $data['class_id'] = $this->input->post('class_id');
            $data['section_id'] = $section_id;
            $data['question'] = $this->input->post('question');
            $data['true_false'] = $this->input->post('true_false_ques');
            $data['fill_blank'] = $this->input->post('blank_space');
            $data['option1'] = $this->input->post('answer1');
            $data['option2'] = $this->input->post('answer2');
            $data['option3'] = $this->input->post('answer3');
            $data['option4'] = $this->input->post('answer4');
            $data['option5'] = $this->input->post('answer5');
            $data['option6'] = $this->input->post('answer6');

            $data['explanation'] = $this->input->post('explanation');
            $data['hint'] = $this->input->post('hint');
            if (!empty($this->input->post('negative_marks'))) {
                $data['negative_marks'] = $this->input->post('negative_marks');
            } else {
                $data['negative_marks'] = 0;
            }
            $data['marks'] = $this->input->post('marks');
            $data['diff_id'] = $this->input->post('difficulty_level');
            $data['order'] = $this->input->post('order');
            //$data['year'] = $this->globalSettingsRunningYear;
            // pre($data);
            //exit;
            $this->load->model("Question_model");
            $this->Question_model->question_save($data);

            $response_array = array('status' => "success", 'message' => "Question Has been Created");
            //pre($data);
            //exit;           
            $this->session->set_flashdata('flash_message', get_phrase('question_added'));
            redirect(base_url() . 'index.php?school_admin/add_subject_online_exam/' . $param1 . '/' . $param2 . '/' . $data['subject_id'], 'refresh');
            // print_r(json_encode($response_array));//exit;
        }
    }

    if ($param1 == 'edit' && $param2 == 'do_update') {
        $ques_type = $this->input->post('question_type');
        if ($ques_type == 1) {
            $correct_answer = array('type' => $this->input->post('correct_answer[]'));
            // pre();
            $valu = implode(",", $correct_answer['type']);
            $data['answer'] = $valu;
        }
        $param1 = $this->input->post('class_id');
        $param2 = $this->input->post('subject_id');
        $subject = $this->Subject_model->get_data_by_cols('*', array('class_id' => $param1, 'subject_id' => $param2), 'result_type');
        $section_id = $subject[0]['section_id'];

        $data['qtype_id'] = $this->input->post('question_type');
        $data['subject_id'] = $this->input->post('subject_id');
        $data['class_id'] = $this->input->post('class_id');
        $data['section_id'] = $section_id;
        $data['question'] = $this->input->post('question');
        $data['option1'] = $this->input->post('answer1');
        $data['option2'] = $this->input->post('answer2');
        $data['option3'] = $this->input->post('answer3');
        $data['option4'] = $this->input->post('answer4');
        $data['option5'] = $this->input->post('answer5');
        $data['option6'] = $this->input->post('answer6');

        $data['explanation'] = $this->input->post('explanation');
        $data['true_false'] = $this->input->post('true_false_ques');
        $data['fill_blank'] = $this->input->post('blank_space');
        $data['hint'] = $this->input->post('hint');
        $data['negative_marks'] = $this->input->post('negative_marks');
        $data['marks'] = $this->input->post('marks');
        $data['diff_id'] = $this->input->post('difficulty_level');
        $data['order'] = $this->input->post('order');
        $data1['exam_id'] = $this->input->post('exam_id');
        $this->Question_model->update_question($param3, $data);

        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?school_admin/add_subject_online_exam/' . $data['class_id'] . '/' . $data1['exam_id'] . '/' . $data['subject_id'], 'refresh');
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->Exam_model->get_online_data($param2);
    }
    if ($param1 == 'delete') {
        $this->Question_model->question_delete($param2);
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?school_admin/add_subject_online_exam/' . $param4 . '/' . $param3, 'refresh');
    }

    $subject = $this->Subject_model->get_data_by_cols('*', array('class_id' => $param1), 'result_type');

    $page_data['class_id'] = $param1;
    $page_data['exam_id'] = $param2;
    $page_data['subject'] = $subject;
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['exams'] = $this->Exam_model->get_all_online_data();
    $page_data['page_name'] = 'add_question_online';
    $page_data['page_title'] = get_phrase('add_questions');
    $this->load->view('backend/index', $page_data);
}

/* * ******************** Edit Question ***************** */

function edit_question($param1 = '', $param2 = '', $param3 = '') {
    //echo $param1.$param2.$param3;
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model("Subject_model");
    $this->load->model("Question_model");
    $subject = $this->Subject_model->get_data_by_cols('*', array('class_id' => $param2), 'result_type');
    $question = $this->Question_model->get_data_by_cols('*', array('id' => $param1), 'result_type');

    $page_data = $this->get_page_data_var();

    $page_data['question_id'] = $param1;
    $page_data['class_id'] = $param2;
    $page_data['question'] = $question;
    //print_r($page_data['question']);
    //exit;
    $page_data['class_id'] = $param2;
    $page_data['subject'] = $subject;
    $page_data['subject_id'] = $param3;
    if (!empty($question))
        $page_data['exam_id'] = $question[0]['exam_id'];
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_name'] = 'edit_question';
    $page_data['page_title'] = get_phrase('add_question');
    $this->load->view('backend/index', $page_data);
}

/* * ********************Question View ***************** */

function add_subject_online_exam($param1 = '', $param2 = '', $param3 = '') {
    //echo $param1.$param2.$param3;
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Subject_model');
    $this->load->model('Question_model');
    $page_data = $this->get_page_data_var();
    $subject = $this->Subject_model->get_data_by_cols('*', array('class_id' => $param1), 'result_type');
    //$question = $this->Question_model->get_data_by_cols('*', array('class_id' => $param1, 'subject_id' => $param2), 'result_type');
    $question = $this->Question_model->get_details_ById($param1, $param2, $param3);
    $page_data['exam_id'] = $param2;
    $page_data['class_id'] = $param1;
    $page_data['subject_id'] = $param3;
    $page_data['question'] = $question;
    //print_r($page_data['question']);
    //exit;
    $page_data['subject'] = $subject;
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_name'] = 'add_question_online_exam';
    $page_data['page_title'] = get_phrase('add_question');
    $this->load->view('backend/index', $page_data);
}

/* * **** SEND EXAM MARKS VIA SMS ******* */

function exam_marks_sms($param1 = '', $param2 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $this->load->model("Exam_model");
    $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
    $page_data['exams'] = $this->Exam_model->get_data_by_cols("*", array('year' => $running_year), "result_array");
    $page_data['classes'] = $this->Class_model->get_data_generic_fun("*", array(), "result_array");

    if ($param1 == 'send_sms') {
        $exam_id = $this->input->post('exam_id');
        $class_id = $this->input->post('class_id');
        $receiver = $this->input->post('receiver');
        $section_id = $this->input->post('section_id');
        $exam_name = $this->Exam_model->get_single_name($exam_id);
        $students = $this->input->post('selected');
        /*
          echo  '<pre>';
          echo 'exam id :'.$exam_id.'<br>';
          echo 'class_id :'.$class_id.'<br>';
          echo 'receiver :'.$receiver.'<br>';
          echo 'exam_name :'.$exam_name.'<br>';
          print_r($students);
          echo ' section_id :'.$section_id.'<br>';
          die();
         */
        // get the marks of the student for selected exam
        foreach ($students as $row) {
            $student_detail = $this->Student_model->get_data_by_cols('*', array('student_id' => $row), 'result_type');

            if (count($student_detail) > 0) {
                $student_name = $student_detail->row()->name;
                if ($receiver == 'student') {
                    $receiver_phone = $student_detail->row()->phone;
                }
                if ($receiver == 'parent') {
                    $parent_id = $student_detail->row()->parent_id;
                    if ($parent_id != '') {
                        $receiver_phone = $this->Parent_model->get_data_by_cols('cell_phone', array('parent_id' => $parent_id), 'result_type');
                    }
                }
            } else {
                continue;
            }
            $marks = $this->Mark_model->get_data_by_cols('*', array('year' => $this->globalSettingsRunningYear, 'exam_id' => $exam_id, 'student_id' => $row), 'result_type');
            if (!empty($marks)) {
                $message = $exam_name . ' ' . $student_name . ' ';
                foreach ($marks as $row2) {
                    $subject = '';
                    $subject_names = $this->Subject_model->get_data_by_cols('name', array('subject_id' => $row2['subject_id']), 'result_array');
                    if (isset($subject_names[0]['name'])) {
                        $subject = $subject_names[0]['name'];
                    }
                    $mark_obtained = $row2['mark_obtained'];
                    $message .= $subject . ' : ' . $mark_obtained . ' , ';
                }
                // send sms

                send_school_notification('send_mark', $message, array($receiver_phone));
            }
        }
        //die();
        $this->session->set_flashdata('flash_message', get_phrase('message_sent'));
        redirect(base_url() . 'index.php?school_admin/exam_marks_sms', 'refresh');
    }
    if ($param1 == 'get_list') {
        $exam_id = $this->input->post('exam_id');
        $class_id = $this->input->post('class_id');
        $receiver = $this->input->post('receiver');
        $section_id = $this->input->post('section_id');
        $details_array = array();
        $students = $this->Enroll_model->get_data_by_cols('*', array(
            'class_id' => $class_id,
            'section_id' => $section_id,
            'year' => $this->globalSettingsRunningYear), 'result_type');


        // get the marks of the student for selected exam
        foreach ($students as $row) {
            $student_detail = $this->Student_model->get_data_by_cols('*', array('student_id' => $row['student_id']), 'result_type');
            //pre($student_detail); die();
            if ($student_detail) {
                $student_name = $student_detail[0]['name'] . ' ' . $student_detail[0]['lname'];
                //echo $student_name; die();
                if ($receiver == 'student') {

                    $details_array[] = $student_detail[0];
                }


                if ($receiver == 'parent') {
                    $parent_id = $student_detail[0]['parent_id'];
                    if ($parent_id != '') {
                        $parent_details = $this->Parent_model->get_data_by_cols('*', array('parent_id' => $parent_id), 'result_type');
                        $details_array[] = $parent_details[0];
                    }
                }
            } else {
                continue;
            }
        }
        $page_data['class_id'] = $class_id;
        $page_data['section_id'] = $section_id;
        $page_data['exam_id'] = $exam_id;
        $page_data['user'] = $receiver;
        $page_data['details'] = $details_array;
        $page_data['student'] = $students;

        //pre($page_data); die();
        $this->load->view('backend/school_admin/ajax_exam_sms_users', $page_data);
    }
    if ($param1 == '') {
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['page_name'] = 'exam_marks_sms';
        $page_data['page_title'] = get_phrase('send_marks_by_sms');
        $this->load->view('backend/index', $page_data);
    }
}

/* * **MANAGE EXAM MARKS**** */

function marks2($exam_id = '', $class_id = '', $subject_id = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    if ($this->input->post('operation') == 'selection') {
        $page_data['exam_id'] = $this->input->post('exam_id');
        $page_data['class_id'] = $this->input->post('class_id');
        $page_data['subject_id'] = $this->input->post('subject_id');

        // get the marks of the student for selected exam
        foreach ($students as $row) {

            if ($page_data['exam_id'] > 0 && $page_data['class_id'] > 0 && $page_data['subject_id'] > 0) {
                redirect(base_url() . 'index.php?school_admin/marks2/' . $page_data['exam_id'] . '/' . $page_data['class_id'] . '/' . $page_data['subject_id'], 'refresh');
            } else {
                $this->session->set_flashdata('mark_message', 'Choose exam, class and subject');
                redirect(base_url() . 'index.php?school_admin/marks2/', 'refresh');
            }
        }
        if ($this->input->post('operation') == 'update') {
            $students = $this->Enroll_model->get_data_by_cols('*', array('class_id' => $class_id, 'year' => $running_year), 'result_type');
            foreach ($students as $row) {
                $data['mark_obtained'] = $this->input->post('mark_obtained_' . $row['student_id']);
                $data['comment'] = $this->input->post('comment_' . $row['student_id']);
                $mark_id = $this->input->post('mark_id_' . $row['student_id']);
                $this->Mark_model->update_mark(
                        array('mark_obtained' => $data['mark_obtained'], 'comment' => $data['comment'], 'mark_id' => $mark_id));
            }
            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
            redirect(base_url() . 'index.php?school_admin/marks2/' . $this->input->post('exam_id') . '/' . $this->input->post('class_id') . '/' . $this->input->post('subject_id'), 'refresh');
        }

        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['exam_id'] = $exam_id;
        $page_data['class_id'] = $class_id;
        $page_data['subject_id'] = $subject_id;
        $year = $this->globalSettingsRunningYear;
        $page_data['exams'] = $this->Exam_model->get_data_by_cols('*', array('year' => $year), "res_arr");
        $page_data['page_info'] = 'Exam marks';

        $page_data['page_name'] = 'marks2';
        $page_data['page_title'] = get_phrase('manage_exam_marks');
        $this->load->view('backend/index', $page_data);
    }
}

function marks_manage() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Exam_model');
    $page_data = $this->get_page_data_var();
    $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
    // for normal grading method only
    $page_data['exams'] = $this->Exam_model->get_data_by_cols('*', array('year' => $running_year, 'grading'=>1), 'result_array');
    //pre($page_data['exams']);
    $page_data['classes'] = $this->Class_model->get_data_by_cols('*', array(), 'result_array');
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_name'] = 'marks_manage';
    $page_data['page_title'] = get_phrase('manage_exam_marks');
    $this->load->view('backend/index', $page_data);
}

function marks_manage_view($exam_id = '', $class_id = '', $section_id = '', $subject_id = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Section_model');
    $this->load->model('Subject_model');
    $this->load->model('Exam_model');
    $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['exam_id'] = $exam_id;
    $page_data['class_id'] = $class_id;
    $page_data['subject_id'] = $subject_id;
    $page_data['section_id'] = $section_id;
    $grading_method = $this->Exam_model->get_exam_grading($exam_id);
    if ($grading_method == 6) {
        $page_data['page_name'] = 'ibo_marks_manage_view';
    } else {
        $page_data['page_name'] = 'marks_manage_view';
    }
    $page_data['page_title'] = get_phrase('manage_exam_marks');
    if($grading_method == 1){
        $page_data['exams'] = $this->Exam_model->get_data_by_cols('*', array('year' => $running_year, 'grading'=>1), 'result_array');
    }else {
        $page_data['exams'] = $this->Exam_model->get_data_by_cols('*', array(), 'result_array');
    }
    
    $page_data['classes'] = $this->Class_model->get_data_by_cols('*', array(), 'result_array');
    $page_data['sections'] = $this->Section_model->get_data_by_cols('*', array(
        'class_id' => $class_id
            ), 'result_type');
    $page_data['running_year'] = $running_year;
    if ($grading_method == 3) { //CWA Exam
        $page_data['subjects'] = $this->Subject_model->marks_get_cwa_subject($class_id, $section_id);
    } else if ($grading_method == 4) { // GPA EXAM
        $page_data['subjects'] = $this->Subject_model->marks_get_gpa_subject($class_id, $section_id);
    } else if ($grading_method == 5) { // ICSE EXAM
        $page_data['subjects'] = $this->Subject_model->marks_get_icse_subject($class_id, $section_id);
    } else { //CCE EXAM
        $page_data['subjects'] = $this->Subject_model->marks_get_subject($class_id, $section_id);
    }
    $page_data['exam_name'] = $this->Exam_model->get_single_name($exam_id);
    $page_data['class_name'] = $this->Class_model->single_name($class_id);
    $page_data['section_name'] = $this->Section_model->single_name($section_id);
    $page_data['subject_name'] = $this->Subject_model->single_name($subject_id);
    //$running_year = $this->globalSettingsRunningYear;
    if ($grading_method == 6) {
        $page_data['marks_of_students'] = $this->Exam_model->ibo_get_marks_of_students($exam_id, $class_id, $section_id, $subject_id, $page_data['running_year']);
        //pre($page_data['marks_of_students']);
    } else {
        $page_data['marks_of_students'] = $this->Exam_model->get_marks_of_students($exam_id, $class_id, $section_id, $subject_id, $page_data['running_year']);
    }
    //pre($page_data); die();
    $this->load->view('backend/index', $page_data);
}

function marks_selector() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Mark_model');
    $this->load->model('Enroll_model');
    $data['exam_id'] = $this->input->post('exam_id');
    $data['class_id'] = $this->input->post('class_id');
    $data['section_id'] = $this->input->post('section_id');
    $data['subject_id'] = $this->input->post('subject_id');
    //$data['year'] = $this->globalSettingsRunningYear;
    $data['year'] = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
    $query = $this->Mark_model->get_data_by_cols('*', array(
        'exam_id' => $data['exam_id'],
        'class_id' => $data['class_id'],
        'section_id' => $data['section_id'],
        'subject_id' => $data['subject_id'],
        'year' => $data['year']
            ), 'result_type');
    if (count($query) < 1) {
        $students = $this->Enroll_model->get_data_by_cols('*', array(
            'class_id' => $data['class_id'], 'section_id' => $data['section_id'], 'year' => $data['year']
                ), 'result_type');
        foreach ($students as $row) {
            $data['student_id'] = $row['student_id'];
            $this->Mark_model->save($data);
        }
    }
    redirect(base_url() . 'index.php?school_admin/marks_manage_view/' . $data['exam_id'] . '/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['subject_id'], 'refresh');
}

function marks_update($exam_id = '', $class_id = '', $section_id = '', $subject_id = '') {
    $this->load->model('Mark_model');
    $running_year = $this->globalSettingsRunningYear;
    $marks_of_students = $this->Mark_model->get_data_by_cols('*', array('exam_id' => $exam_id, 'class_id' => $class_id, 'section_id' => $section_id,
        'year' => $running_year,
        'subject_id' => $subject_id
            ), 'result_type');
    $maximum_marks = $this->input->post('maximum_marks');
    foreach ($marks_of_students as $row) {
        $obtained_marks = $this->input->post('marks_obtained_' . $row['mark_id']);
        $comment = $this->input->post('comment_' . $row['mark_id']);

        $this->Mark_model->update_marks($row['mark_id'], array('mark_obtained' => $obtained_marks, 'comment' => $comment, 'mark_total' => $maximum_marks));
    }
    $this->session->set_flashdata('flash_message', get_phrase('marks_updated'));
    redirect(base_url() . 'index.php?school_admin/marks_manage_view/' . $exam_id . '/' . $class_id . '/' . $section_id . '/' . $subject_id, 'refresh');
}

function marks_get_subject($class_id = '', $subject_id = '') {
    $this->load->model("Subject_model");
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['class_id'] = $class_id;

    $page_data['sections'] = $this->Section_model->get_data_by_cols('*', array('class_id' => $class_id), 'result_type');
    $page_data['subjects'] = $this->Subject_model->get_data_by_cols('subject', array('class_id' => $class_id, 'subject_id' => $subject_id, 'year' => $this->globalSettingsRunningYear), 'result_type');
    $this->load->view('backend/school_admin/marks_get_subject', $page_data);
}

// TABULATION SHEET
function tabulation_sheet($class_id = '', $section_id = '', $exam_id = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model("Exam_model");
    $this->load->model("Subject_model");
    $this->load->model("Enroll_model");
    $this->load->model("Mark_model");
    $page_data = $this->get_page_data_var();

    $page_data['exams'] = $this->Exam_model->get_all_exam($this->globalSettingsRunningYear);
    $page_data['classes'] = $this->Class_model->get_data_by_cols('*', array(), 'result_type');
    $page_data['sections'] = $this->Section_model->get_data_by_cols('*', array('class_id' => $class_id), 'result_type');
    if (isset($_POST['operation'])) {
        $page_data['exam_id'] = $this->input->post('exam_id');
        $page_data['class_id'] = $this->input->post('class_id');
        $page_data['section_id'] = $this->input->post('section_id');
        $page_data['operation'] = $this->input->post('operation');
        $page_data['page_info'] = 'Exam marks';

        if ($page_data['exam_id'] > 0 && $page_data['class_id'] > 0) {
            /* echo $page_data['class_id']. '<br/>'. $page_data['section_id'].'<br/>'.$page_data['exam_id'];
              echo 'here'; exit; */
            redirect(base_url() . 'index.php?school_admin/tabulation_sheet/' . $page_data['class_id'] . '/' . $page_data['section_id'] . '/' . $page_data['exam_id'], 'refresh');
        } else {
            $this->session->set_flashdata('mark_message', 'Choose class,section and exam');
            redirect(base_url() . 'index.php?school_admin/tabulation_sheet/', 'refresh');
        }
    } else {
        //echo $exam_id; exit;
        $page_data['exam_name'] = "";
        if (!empty($exam_id))
            $page_data['exam_name'] = $this->Exam_model->get_name_by_id($exam_id);
        if (!empty($class_id))
            $page_data['class_name'] = $this->Class_model->get_name_by_id($class_id);
        if (!empty($section_id))
            $page_data['section_name'] = $this->Section_model->get_name_by_id($section_id);
        $arr = array('class_id' => $class_id, 'section_id' => $section_id, 'year' => $this->globalSettingsRunningYear);

        $subjects = $this->Subject_model->get_data_by_cols('*', $arr, 'result_type');
        $year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
        /*$students = $this->Enroll_model->get_data_by_cols('*', $arr, 'result_type');*/
        $students = $this->Enroll_model->get_students($class_id, $section_id, $year);
        $page_data['subjects'] = $subjects;
        $page_data['students'] = $students;
        $page_data['section_id'] = $section_id;
        $page_data['exam_id'] = $exam_id;
        $arrStudentMarks = array();
        $arrStudentName = array();
        $arrSubjectName = array();
        $arrStudentGrade = array(); //cho 'HERE';exit;
        foreach ($students as $row) {

            $arrStudentName[$row['student_id']] = $this->Student_model->get_student_name($row['student_id']);
            foreach ($subjects as $row2) {
                $arrStudentMarks[$row['student_id']][$row2['subject_id']] = $this->Mark_model->get_c_year_mark_obtained_by_subject_exam_class($row2['subject_id'], $exam_id, $class_id, $row['student_id'], $this->globalSettingsRunningYear);
                $arrSubjectName = $row2['name'];
            }
        }
        $page_data['class_id'] = $class_id;
        $page_data['arrStudentMarks'] = $arrStudentMarks;
        $page_data['arrStudentName'] = $arrStudentName;
        $page_data['arrSubjectName'] = $arrSubjectName;
    }

    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_name'] = 'tabulation_sheet';
    $page_data['page_title'] = get_phrase('tabulation_sheet');
    
    $this->load->view('backend/index', $page_data);
}

public function tabulation_sheet_print_view($class_id = '', $section_id = '', $exam_id = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model("Subject_model");
    $this->load->model("Exam_model");
    $this->load->model("Class_model");

    $this->load->model("Mark_model");
    $this->load->model("Crud_model");

    $page_data = $this->get_page_data_var();

    $page_data['class_id'] = $class_id;
    $page_data['exam_id'] = $exam_id;
    $page_data['section_id'] = $section_id;

    $page_data['class_name'] = $this->Class_model->get_name_by_id($class_id);
    $page_data['exam_name'] = $this->Exam_model->get_name_by_id($exam_id);
    $page_data['system_name'] = $this->globalSettingsSystemName;
    $page_data['running_year'] = $this->globalSettingsRunningYear;
    $page_data['subjects'] = $this->Subject_model->get_data_by_cols('*', array('class_id' => $class_id, 'section_id' => $section_id, 'year' => $page_data['running_year']), 'result_array');
    $page_data['students'] = $this->Enroll_model->get_data_generic_fun('*', array('class_id' => $class_id, 'year' => $page_data['running_year']), 'result_array');
    //pre($page_data['students']);echo "<hr>";
    $total_marks = 0;
    $total_grade_point = 0;
    foreach ($page_data['subjects'] as $row) {
        foreach ($page_data['students'] as $k => $value) {
            $page_data['students'][$k]['student_name'] = $this->Student_model->get_student_name($value['student_id']);
            $data_arr = array('class_id' => $class_id,
                'exam_id' => $exam_id,
                'subject_id' => $row['subject_id'],
                'student_id' => $value['student_id'],
                'year' => $page_data["running_year"]);
            $page_data['students'][$k]["obtained_mark_query"] = $this->Mark_model->get_data_by_cols('*', $data_arr, "result");
            $obtained_mark_query = $page_data['students'][$k]['obtained_mark_query'];
            $page_data['students'][$k]['total_marks'] = 0;
            $page_data['students'][$k]["total_grade_point"] = 0;
            if (count($obtained_mark_query) > 0) {
                $obtained_marks = $obtained_mark_query[0]->mark_obtained;
                if ($obtained_marks >= 0 && $obtained_marks != '') {
                    $grade = $this->crud_model->get_grade($obtained_marks);
                    $total_grade_point += $grade['grade_point'];
                    $page_data['students'][$k]["total_grade_point"] = $total_grade_point;
                }
                $total_marks += $obtained_marks;
                $page_data['students'][$k]['total_marks'] = $total_marks;
                //echo $page_data['students'][$k]['total_marks']."<br>";
            }
            //pre($page_data['students'][$k]["obtained_mark_query"]);echo "<hr>";
        }
    }
    $arr = array('class_id' => $class_id, 'year' => $page_data['running_year']);
    $page_data['number_of_subjects'] = count($this->Subject_model->get_data_by_cols("*", $arr, "result_array"));

    $this->load->view('backend/school_admin/tabulation_sheet_print_view', $page_data);
}

/* * **MANAGE GRADES**** */

function grade($param1 = '', $param2 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model("Cce_model");
    $this->load->model("Evaluation_model");
    $page_data = $this->get_page_data_var();
    if ($param1 == 'create') {
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('grade_point', 'Grade Point', 'trim|required');
        $this->form_validation->set_rules('mark_from', 'Mark Form', 'trim|required');
        $this->form_validation->set_rules('mark_upto', 'Mark Upto', 'required|trim');
        $this->form_validation->set_rules('comment', 'Comment', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_validation_error', validation_errors());
            redirect(base_url() . 'index.php?school_admin/grade');
        } else {
            $data['name'] = $this->input->post('name');
            $data['grade_point'] = $this->input->post('grade_point');
            $data['mark_from'] = $this->input->post('mark_from');
            $data['mark_upto'] = $this->input->post('mark_upto');
            $data['comment'] = $this->input->post('comment');
            $evaluation_id = $this->input->post('grade_id');
            $grade_group = $this->input->post('grade_group');
            $data['evaluation_id'] = $evaluation_id;
            $result = $this->Exam_model->get_data_by_cols_table('grade', "*", array('name' => $data['name']), "result_array");
            if (empty($result)) {
                $grade_id = $this->Cce_model->save_grade($data);
                /*if ($grade_group != '') {
                    $this->Cce_model->save_cce_grade(array('grade_id' => $grade_id, 'grade_set' => $grade_group, 'evaluation_id' => $evaluation_id));
                }*/
                $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
            } else {
                $grade_id = $result[0]['grade_id'];

                /*$grading = $this->Evaluation_model->get_data_by_cols_table('grading_evaluation', "*", array('grade_id' => $grade_id, 'evaluation_id' => $evaluation_id), "result_array");*/
                $grading = $this->Evaluation_model->get_data_by_cols_table('grade', "*", array('grade_id' => $grade_id, 'evaluation_id' => $evaluation_id), "result_array");
                if (!empty($grading)) {
                    /*$this->Cce_model->save_cce_grade(array('grade_id' => $grade_id, 'grade_set' => $grade_group, 'evaluation_id' => $evaluation_id));
                    $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
                } else {*/
                    $this->session->set_flashdata('flash_message', get_phrase('duplicate_name_for_grade'));
                }
            }
            redirect(base_url() . 'index.php?school_admin/grade/', 'refresh');
        }
    }

    if ($param1 == 'do_update') {
        $data['name'] = $this->input->post('name');
        $data['grade_point'] = $this->input->post('grade_point');
        $data['mark_from'] = $this->input->post('mark_from');
        $data['mark_upto'] = $this->input->post('mark_upto');
        $data['comment'] = $this->input->post('comment');
        $rs = $this->Cce_model->update_data(array('grade_id' => $param2), $data);
        if ($rs) {
            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        }
        redirect(base_url() . 'index.php?school_admin/grade/', 'refresh');
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->Evaluation_model->get_all_grade($param2);
    }
    if ($param1 == 'delete') {
        $this->Cce_model->delete_grade($param2);
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?school_admin/grade/', 'refresh');
    }
    if ($param1 == 'import_excel') {
        $path = "uploads/grade_import.xlsx";
        //@unlink('uploads/subject_import.xlsx');
        @unlink($path);
        @unlink('uploads/grade_bulk_upload_error_details.log');

        if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $path)) {
            die('not moving');
        }
        @ini_set('memory_limit', '-1');
        @set_time_limit(0);
        include 'Simplexlsx.class.php';
        $xlsx = new SimpleXLSX($path);
        list($num_cols, $num_rows) = $xlsx->dimension();
        $f = 0;
        $fielsdStringForAdmin = "Grade Name,Grade Point,Min Mark,Max Mark,Comment,Evaluation Method";
        $fielsdString = "name,grade_point,mark_from,mark_upto,comment,evaluation_id";
        $fielsdStringMandotary = "name,grade_point,mark_from,mark_upto,evaluation_id";
        $fielsdArr = explode(',', $fielsdString);
        $fielsdStringForAdminArr = explode(',', $fielsdStringForAdmin);
        $fielsdStringMandotaryArr = explode(',', $fielsdStringMandotary);
        $someRowError = FALSE;
        $errorMsgArr = array();
        $errorExcelArr = array();
        $errorExcelArr[] = $fielsdStringForAdminArr;
        $errorRowNo = 2;
        //pre($xlsx->rows());die;
        foreach ($xlsx->rows() as $r) {
            //echo '<pre>'; //print_r($r);die;
            $data = array();
            $dataParent = array();
            $error = FALSE;
            // Ignore the inital name row of excel file
            if ($f == 0) {
                $f++;
                continue;
            } $f++;
            //pre($fielsdStringForAdminArr);
            //pre($r); //die('here');
            //pre($r);
            //pre('above are $r data');
            //if ($num_cols > count($fielsdArr)) {
            $num_cols = count($fielsdArr);
            //die($num_cols);
            //}
            $blankErrorMsgArr = array();
            $errorRowIncrease = FALSE;

            //echo $num_cols;die;
            for ($i = 0; $i < $num_cols; $i++) {    // checking is filds is mandetory or not
                //echo $fielsdArr[$i] . '<br>';
                if (in_array($fielsdArr[$i], $fielsdStringMandotaryArr)) {
                    //now validating mandetory fiels
                    //generate_log("Field " . $fielsdArr[$i] . " value \n", 'grade_bulk_upload_' . date('d-m-Y-H') . '.log');
                    //echo $r[$i].'<br>';
                    if (trim($r[$i]) == "") {
                        //echo "here"; //die();
                        $error = TRUE;
                        $blankErrorMsgArr[] = $fielsdStringForAdminArr[$i] . " should not be blank at row no " . $errorRowNo;
                    } else {
                        //pre($i);
                    }

                    if ($fielsdArr[$i] == 'name') {
                        $data['name'] = trim($r[$i]);
                    }

                    if ($fielsdArr[$i] == 'evaluation_id') {
                        $gradingArr = $this->Evaluation_model->get_name($r[$i]);
                        if (!empty($gradingArr)) {
                            $evaluation_id = $gradingArr[0]->evaluation_id;
                        } else {
                            $error = TRUE;
                            $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " content invalid data at row no -" . $errorRowNo;
                        }
                    }
                    $data[$fielsdArr[$i]] = trim($r[$i]);
                    if (!empty($errorMsgArr)) {
                        //pre($errorMsgArr);die;
                    }
                    //pre(trim($fielsdArr[$i]));pre('$error');pre($error);
                } else {
                    //pre($errorMsgArr);//die;
                    //pre(trim($fielsdArr[$i]));pre('$error');pre($error);
                }
            }
            //die;
            if (count($blankErrorMsgArr) > 0) {
                $error = TRUE;
                if (count($blankErrorMsgArr) <= count($fielsdArr)) {
                    foreach ($blankErrorMsgArr AS $errorKey => $errorVal) {
                        $errorMsgArr[] = $errorVal;
                    }
                }
            }
            //pre($data); //die('//hii');
            //pre('$error');pre($error); //die();
            if ($error === FALSE) {
                unset($data['evaluation_id']);
                //pre($data);die;
                $grade_id = "";
                $grade_id = $this->Cce_model->save_grade($data);
                if ($grade_id != "") {
                    $grading_evaluation_data_array = array('grade_id' => $grade_id, 'evaluation_id' => $evaluation_id);
                    $this->Cce_model->save_cce_grade($grading_evaluation_data_array);
                }
            } else {
                //pre($errorMsgArr);//die;
                $errorRowNo++;
                $errorExcelArr[] = $r;
                $someRowError = TRUE;
            }
        } //ends foreach
        //pre($errorMsgArr); exit;

        if ($someRowError == FALSE) {
            //$this->generate_cv$error_msg);
            generate_log("No error for this upload at - " . time(), 'grade_bulk_upload' . date('d-m-Y-H') . '.log');
            $this->session->set_flashdata('flash_message', get_phrase('grade_details_added'));
            redirect(base_url() . 'index.php?school_admin/bulk_upload/', 'refresh');
        } else {
            //pre($errorMsgArr); die('here');
            generate_log(json_encode($errorMsgArr), 'grade_bulk_upload_error_details.log', TRUE);
            $file_name_with_path = 'uploads/grade_bulk_upload_error_details_for_excel_file.xlsx';
            @unlink($file_name_with_path);
            create_excel_file($file_name_with_path, $errorExcelArr, 'Exam Upload Data');
            $this->session->set_flashdata('flash_message_error', "Some rows are not uploaded,due to invalid data.");
            redirect(base_url() . 'index.php?school_admin/grade_bulk_upload_error', 'refresh');
        }
    }

    $page_data['gradings'] = $this->Evaluation_model->get_data_by_cols('*', array(), 'result_array', array('evaluation_id' => 'asc'));
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['grades'] = $this->Evaluation_model->get_grade_value();
    foreach ($page_data['grades'] as $k => $v) {
        $page_data['grades'][$k]['transaction'] = $this->Crud_model->getGradeTransaction($v['grade_id']);
    } //pre($page_data['grades']);exit;
    /*$cce_exam_category = $this->Exam_model->cce_exam_category();
    $internal_category = $this->Exam_model->cce_internal_assessments();
    $page_data['cce_exam_category'] = $cce_exam_category;
    $page_data['cce_internal_category'] = $internal_category;*/
    $page_data['page_name'] = 'grade';
    $page_data['page_title'] = get_phrase('manage_grade');
    $this->load->view('backend/index', $page_data);
}

/* * ********MANAGING EXAM SETTINGS***************** */

function exam_settings($param1 = '') {

    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $this->load->model("Cce_model");
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['pt_max'] = $this->Cce_model->get_cce_setting('pt_max');
    $page_data['notebook_max'] = $this->Cce_model->get_cce_setting('notebook_max');
    $page_data['se_max'] = $this->Cce_model->get_cce_setting('se_max');
    $page_data['page_name'] = 'exam_settings';
    $page_data['page_title'] = get_phrase('exam_settings');
    $page_data['SelectedTab'] = 'cce';
    $this->load->view('backend/index', $page_data);
}

function classes_evaluation($param1 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    if ($param1 == 'cce') {
        $classes[] = $this->input->post('selected_class');
        if (count($classes[0])) {
            foreach ($classes[0] as $row) {
                $dataArray = array('class_id' => $row);
                $this->Class_model->add_cce_classes($dataArray, $row);
            }
            $this->session->set_flashdata('flash_message', get_phrase('Classes_added_to_CCE_evaluation'));
        }
        $this->load->model("Cce_model");
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['fa_max'] = $this->Cce_model->get_cce_setting('fa_max');
        $page_data['sa_max'] = $this->Cce_model->get_cce_setting('sa_max');
        $page_data['page_name'] = 'exam_settings';
        $page_data['page_title'] = get_phrase('exam_settings');
        //$this->load->view('backend/index', $page_data);
        redirect($_SERVER['HTTP_REFERER']);
    }
    if ($param1 == 'cwa') {
        $classes[] = $this->input->post('selected_class');
        if (count($classes[0])) {
            foreach ($classes[0] as $row) {
                $dataArray = array('class_id' => $row);
                $this->Class_model->add_cwa_classes($dataArray, $row);
            }
            $this->session->set_flashdata('flash_message', get_phrase('Classes_added_to_CWA_evaluation'));
        }
        $this->load->model("Cce_model");
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['fa_max'] = $this->Cce_model->get_cce_setting('fa_max');
        $page_data['sa_max'] = $this->Cce_model->get_cce_setting('sa_max');
        $page_data['page_name'] = 'exam_settings';
        $page_data['page_title'] = get_phrase('exam_settings');
        //$this->load->view('backend/index', $page_data);
        redirect($_SERVER['HTTP_REFERER']);
    }
    if ($param1 == 'gpa') {
        $classes[] = $this->input->post('selected_class');
        if (count($classes[0])) {
            foreach ($classes[0] as $row) {
                $dataArray = array('class_id' => $row);
                $this->Class_model->add_gpa_classes($dataArray, $row);
            }
            $this->session->set_flashdata('flash_message', get_phrase('Classes_added_to_GPA_evaluation'));
        }
        $this->load->model("Cce_model");
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['page_name'] = 'exam_settings';
        $page_data['page_title'] = get_phrase('exam_settings');
        //$this->load->view('backend/index', $page_data);
        redirect($_SERVER['HTTP_REFERER']);
    }

    if ($param1 == 'ibo') {
        $classes[] = $this->input->post('selected_class');
        if (count($classes[0])) {
            foreach ($classes[0] as $row) {
                $dataArray = array('class_id' => $row);
                $this->Class_model->add_ibo_classes($dataArray, $row);
            }
            $this->session->set_flashdata('flash_message', get_phrase('Classes_added_to_IBO_evaluation'));
        }
        $this->load->model("Cce_model");
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['page_name'] = 'exam_settings';
        $page_data['page_title'] = get_phrase('exam_settings');
        //$this->load->view('backend/index', $page_data);
        redirect($_SERVER['HTTP_REFERER']);
    }

    if ($param1 == 'icse') {
        $classes[] = $this->input->post('selected_class');
        if (count($classes[0])) {
            foreach ($classes[0] as $row) {
                $dataArray = array('class_id' => $row);
                $this->Class_model->add_icse_classes($dataArray, $row);
            }
            $this->session->set_flashdata('flash_message', get_phrase('Classes_added_to_ICSE_evaluation'));
        }
        $this->load->model("Cce_model");
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['page_name'] = 'exam_settings';
        $page_data['page_title'] = get_phrase('exam_settings');
        //$this->load->view('backend/index', $page_data);
        redirect($_SERVER['HTTP_REFERER']);
    }

    if ($param1 == 'igcse') {
        $classes[] = $this->input->post('selected_class');
        if (count($classes[0])) {
            foreach ($classes[0] as $row) {
                $dataArray = array('class_id' => $row);
                $this->Class_model->add_igcse_classes($dataArray, $row);
            }
            $this->session->set_flashdata('flash_message', get_phrase('Classes_added_to_IGCSE_evaluation'));
        }
        $this->load->model("Cce_model");
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['page_name'] = 'exam_settings';
        $page_data['page_title'] = get_phrase('exam_settings');
        //$this->load->view('backend/index', $page_data);
        redirect($_SERVER['HTTP_REFERER']);
    }
}

function groups($param1 = "", $param2 = "", $param3 = "") {
    //$param1 -> Action like add, delete....$param2 ->value passed like id,name,... $param3 -> Exam Type   
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), "refresh");
    $this->form_validation->set_rules('group_name', 'Group Name', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
        $data['name'] = $this->input->post('group_name');
    } else {
        $this->session->set_flashdata('flash_message_error', validation_errors());
    }
    switch ($param1) {
        case 'add': $res = $this->Exam_model->group_add($data);
            if ($res) {
                $this->session->set_flashdata("flash_message", get_phrase("Successfully created group."));
            } else {
                $this->session->set_flashdata("flash_message_error", get_phrase("Error on creating group."));
            }
            redirect(base_url() . "index.php?school_admin/exam_settings");
            break;

        case 'delete':
            $id = ($param2 != "") ? $param2 : "0";
            $data = array("id" => $id);
            $res = $this->Exam_model->group_delete($data);
            if ($res) {
                $this->session->set_flashdata("flash_message", get_phrase("Successfully deleted group."));
            } else {
                $this->session->set_flashdata("flash_message_error", get_phrase("Error on deleting group."));
            }
            redirect(base_url . "index.php?school_admin/exam_settings");
    }
}

//function group_add($param1= ""){
//    if($this->session->userdata('school_admin_login') != 1)
//        redirect(base_url(), "refresh");
//    $this->form_validation->set_rules('group_name', 'Group Name', 'trim|required');
//    //$this->form_validation->set_rules('group_numeric_name', 'Numeric Name', 'trim|required');
//    if($this->form_validation->run()== TRUE){
//        $data['name'] = $this->input->post('group_name');
//       // $data['numeric_name'] = $this->input->post('group_numeric_name');
//    } else{ 
//        $this->session->set_flashdata("flash_message_error", validation_errors());
//        //redirect(base_url()."/index.php?school_admin/exam_settings/igcse");
//    }
//    switch($param1){
//        case 'igcse': //
//            $res = $this->Exam_model->group_add($data);
//            if(!$res){
//                $this->session->set_flashdata("flash_message_error", "Error on creating group.");
//            }else {
//                $this->session->set_flashdata("flash_message", "Successfully created group.");
//            }
//            redirect(base_url()."/index.php?school_admin/exam_settings");
//            break;
//    }
//}
function cce_subjects($param1 = '', $param2 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Subject_model');
    $this->load->model('Cce_model');
    $page_data = $this->get_page_data_var();
    if ($param1 == 'delete') {
        $this->Cce_model->delete_subject($param2);
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect($_SERVER['HTTP_REFERER']);
    }

    if ($param2 == 'add') {
        // pre($this->input->post());
        //exit;
        $selected_subject = $this->input->post('selected_subject');
        $selected_weekly_classes = $this->input->post('selected_weekly_classes');
        $selected_sixth_subject = $this->input->post('selected_sixth_subject');
        $selected_asl = $this->input->post('selected_asl');
        $selected_no_exam = $this->input->post('selected_no_exam');
        $i = 0;
        if(!isset($selected_sixth_subject) || !isset($selected_asl) || !isset($selected_no_exam)){
            $dataArray['sixth_subject'] = 0;
            $dataArray['asl'] = 0;
            $dataArray['no_exam'] = 0;
        }
        foreach ($selected_subject as $row) {
            $dataArray['subject_id'] = $row;
            $dataArray['weekly_classes'] = $selected_weekly_classes[$i];
            if ($selected_asl != NULL) {
                if (in_array($row, $selected_asl)) {
                    $dataArray['asl'] = 1;
                } else {
                    $dataArray['asl'] = 0;
                }
            }
            if ($selected_sixth_subject != NULL) {
                if (in_array($row, $selected_sixth_subject)) {
                    $dataArray['sixth_subject'] = 1;
                } else {
                    $dataArray['sixth_subject'] = 0;
                }
            }
            if ($selected_no_exam != NULL) {
                if (in_array($row, $selected_no_exam)) {
                    $dataArray['no_exam'] = 1;
                } else {
                    $dataArray['no_exam'] = 0;
                }
            }
            $this->Cce_model->save_cce_subject($dataArray);
            $i++;
        }
        $this->session->set_flashdata('flash_message', get_phrase('subjects_added_to_CCE_evaluation'));
        $page_data['page_name'] = 'exam_settings';
        $page_data['page_title'] = get_phrase('exam_settings');
        redirect($_SERVER['HTTP_REFERER']);
    }

    if ($param1 == 'do_update') {
        $data['subject_id'] = $this->input->post('selected_subject');
        $data['weekly_classes'] = $this->input->post('selected_weekly_classes');
        $data['sixth_subject'] = ($this->input->post('selected_sixth_subject')) ? 1 : 0;
        $data['asl'] = ($this->input->post('selected_asl')) ? 1 : 0;
        $data['no_exam'] = ($this->input->post('selected_no_exam')) ? 1 : 0;

        $rs = $this->Cce_model->update_cce_subject($data, array('id' => $param2));

        if ($rs) {
            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        }
        /* redirect(base_url() . 'index.php?school_admin/exam_settings/', 'refresh'); */
        redirect($_SERVER['HTTP_REFERER']);
    }


    $subjects = $this->Cce_model->get_cce_subjects(array('class_id' => $param1));
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['cce_class_id'] = $param1;
    $page_data['subjects'] = $subjects;
    $page_data['page_name'] = 'ajax_cce_subjects';
    $page_data['page_title'] = get_phrase('cce_subjects');

    $page_data['class_subjects'] = $this->Subject_model->get_subject_array(array('class_id' => $param1));

    $this->load->view('backend/school_admin/ajax_cce_subjects.php', $page_data);
}

function cwa_subjects($param1 = '', $param2 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Cce_model');
    $this->load->model('Subject_model');

    if ($param1 == 'delete') {
        $this->Cce_model->delete_cwa_subject($param2);
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect($_SERVER['HTTP_REFERER']);
    }
    $page_data = $this->get_page_data_var();
    if ($param2 == 'add') {
        // pre($this->input->post());
        //exit;
        $selected_subject = $this->input->post('selected_subject');
        $selected_weekly_classes = $this->input->post('selected_weekly_classes');
        $selected_credit_hours = $this->input->post('selected_credit_hours');
        $selected_no_exam = $this->input->post('selected_no_exam');
        $i = 0;

        foreach ($selected_subject as $row) {
            $dataArray['subject_id'] = $row;
            $dataArray['weekly_classes'] = $selected_weekly_classes[$i];
            $dataArray['credit_hours'] = $selected_credit_hours[$i];
            if ($selected_no_exam != NULL) {
                if (in_array($row, $selected_no_exam)) {
                    $dataArray['no_exam'] = 1;
                } else {
                    $dataArray['no_exam'] = 0;
                }
            }
            $this->Cce_model->save_cwa_subject($dataArray);
            $i++;
        }
        $this->session->set_flashdata('flash_message', get_phrase('subjects_added_to_CWA_evaluation'));
        /* $page_data['fa_max'] = $this->Cce_model->get_cce_setting('fa_max');
          $page_data['sa_max'] = $this->Cce_model->get_cce_setting('sa_max'); */
        $page_data['page_name'] = 'exam_settings';
        $page_data['page_title'] = get_phrase('exam_settings');
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['SelectedTab'] = 'cwa';
        /* $this->load->view('backend/index', $page_data); */
        redirect($_SERVER['HTTP_REFERER']);
    }
    if ($param1 == 'do_update') {
        $data['subject_id'] = $this->input->post('selected_subject');
        $data['weekly_classes'] = $this->input->post('selected_weekly_classes');
        $data['credit_hours'] = ($this->input->post('selected_credit_hours'));
        $data['no_exam'] = ($this->input->post('selected_no_exam')) ? 1 : 0;

        $rs = $this->Cce_model->update_cwa_subject($data, array('cwa_subject_id' => $param2));

        if ($rs) {
            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        }
        /* redirect(base_url() . 'index.php?school_admin/exam_settings/', 'refresh'); */
        redirect($_SERVER['HTTP_REFERER']);
    }

    $subjects = $this->Cce_model->get_cwa_subjects(array('class_id' => $param1));
    $page_data['class_id'] = $param1;
    $page_data['subjects'] = $subjects;
    $page_data['page_name'] = 'ajax_cwa_subjects';
    $page_data['page_title'] = get_phrase('cce_subjects');
    $page_data['total_notif_num'] = $this->get_no_of_notication();

    $page_data['class_subjects'] = $this->Subject_model->get_subject_array(array('class_id' => $param1));

    $this->load->view('backend/school_admin/ajax_cwa_subjects.php', $page_data);
}

function gpa_subjects($param1 = '', $param2 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Cce_model');
    $this->load->model('Subject_model');
    $page_data = $this->get_page_data_var();
    if ($param2 == 'add') {
        // pre($this->input->post());
        //exit;
        $selected_subject = $this->input->post('selected_subject');
        $selected_weekly_classes = $this->input->post('selected_weekly_classes');
        $selected_credit_hours = $this->input->post('selected_credit_hours');
        $selected_no_exam = $this->input->post('selected_no_exam');
        $i = 0;

        foreach ($selected_subject as $row) {
            $dataArray['subject_id'] = $row;
            $dataArray['weekly_classes'] = $selected_weekly_classes[$i];
            $dataArray['credit_hours'] = $selected_credit_hours[$i];
            if ($selected_no_exam != NULL) {
                if (in_array($row, $selected_no_exam)) {
                    $dataArray['no_exam'] = 1;
                } else {
                    $dataArray['no_exam'] = 0;
                }
            }
            $this->Cce_model->save_gpa_subject($dataArray);
            $i++;
        }
        $this->session->set_flashdata('flash_message', get_phrase('subjects_added_to_GPA_evaluation'));
        $page_data['fa_max'] = $this->Cce_model->get_cce_setting('fa_max');
        $page_data['sa_max'] = $this->Cce_model->get_cce_setting('sa_max');
        $page_data['page_name'] = 'exam_settings';
        $page_data['page_title'] = get_phrase('exam_settings');
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        /* $this->load->view('backend/index', $page_data); */
        redirect($_SERVER['HTTP_REFERER']);
    }

    if ($param1 == 'do_update') {
        $data['subject_id'] = $this->input->post('selected_subject');
        $data['weekly_classes'] = $this->input->post('selected_weekly_classes');
        $data['credit_hours'] = ($this->input->post('selected_credit_hours'));
        $data['no_exam'] = ($this->input->post('selected_no_exam')) ? 1 : 0;
        $rs = $this->Cce_model->update_gpa_subject($data, array('gpa_subject_id' => $param2));

        if ($rs) {
            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        }
        /* redirect(base_url() . 'index.php?school_admin/exam_settings/', 'refresh'); */
        redirect($_SERVER['HTTP_REFERER']);
    }

    if ($param1 == 'delete') {
        $this->Cce_model->delete_gpa_subject($param2);
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect($_SERVER['HTTP_REFERER']);
    }
    $subjects = $this->Cce_model->get_gpa_subjects(array('class_id' => $param1));
    $page_data['class_id'] = $param1;
    $page_data['subjects'] = $subjects;
    $page_data['page_name'] = 'ajax_gpa_subjects';
    $page_data['page_title'] = get_phrase('cce_subjects');
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['class_subjects'] = $this->Subject_model->get_subject_array(array('class_id' => $page_data['class_id']));
    $this->load->view('backend/school_admin/ajax_gpa_subjects.php', $page_data);
}

function icse_subjects($param1 = '', $param2 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Subject_model');
    $this->load->model('Cce_model');
    $page_data = $this->get_page_data_var();
    if ($param1 == 'delete') {
        $this->Cce_model->delete_icse_subject($param2);
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect($_SERVER['HTTP_REFERER']);
    }

    if ($param2 == 'add') {
        // pre($this->input->post());
        //exit;
        $selected_subject = $this->input->post('selected_subject');
        $selected_weekly_classes = $this->input->post('selected_weekly_classes');
        $selected_sixth_subject = $this->input->post('selected_sixth_subject');
        $selected_compulsory_subject = $this->input->post('selected_compulsory_subject');
        $selected_optional_subject = $this->input->post('selected_optional_subject');
        $i = 0;

        foreach ($selected_subject as $row) {
            $dataArray['subject_id'] = $row;
            $dataArray['weekly_classes'] = $selected_weekly_classes[$i];
            if ($selected_compulsory_subject != NULL) {
                if (in_array($row, $selected_compulsory_subject)) {
                    $dataArray['compulsory_subject'] = 1;
                } else {
                    $dataArray['compulsory_subject'] = 0;
                }
            }
            if ($selected_sixth_subject != NULL) {
                if (in_array($row, $selected_sixth_subject)) {
                    $dataArray['sixth_subject'] = 1;
                } else {
                    $dataArray['sixth_subject'] = 0;
                }
            }
            if ($selected_optional_subject != NULL) {
                if (in_array($row, $selected_optional_subject)) {
                    $dataArray['optional_subject'] = 1;
                } else {
                    $dataArray['optional_subject'] = 0;
                }
            }
            $this->Cce_model->save_icse_subject($dataArray);
            $i++;
        }
        $this->session->set_flashdata('flash_message', get_phrase('subjects_added_to_ICSE_evaluation'));
        $page_data['page_name'] = 'exam_settings';
        $page_data['page_title'] = get_phrase('exam_settings');
        redirect($_SERVER['HTTP_REFERER']);
    }

    if ($param1 == 'do_update') {
        $data['subject_id'] = $this->input->post('selected_subject');
        $data['weekly_classes'] = $this->input->post('selected_weekly_classes');
        $data['sixth_subject'] = ($this->input->post('selected_sixth_subject')) ? 1 : 0;
        $data['compulsory_subject'] = ($this->input->post('selected_compulsory_subject')) ? 1 : 0;
        $data['optional_subject'] = ($this->input->post('selected_optional_subject')) ? 1 : 0;

        $rs = $this->Cce_model->update_icse_subjects($data, array('id' => $param2));

        if ($rs) {
            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        }
        /* redirect(base_url() . 'index.php?school_admin/exam_settings/', 'refresh'); */
        redirect($_SERVER['HTTP_REFERER']);
    }


    $subjects = $this->Cce_model->get_icse_subjects(array('class_id' => $param1));
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['icse_class_id'] = $param1;
    $page_data['subjects'] = $subjects;
    $page_data['page_name'] = 'ajax_icse_subjects';
    $page_data['page_title'] = get_phrase('icse_subjects');

    $page_data['class_subjects'] = $this->Subject_model->get_subject_array(array('class_id' => $param1));

    $this->load->view('backend/school_admin/ajax_icse_subjects.php', $page_data);
}

/* * ********MANAGING CLASS ROUTINE***************** */

function cce_settings($param1 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Cce_model');
    $page_data = $this->get_page_data_var();
    if ($param1 == 'pt_max') {
        $pt_max = $this->input->post('maxmarks');
        $data['pt_max'] = $pt_max;
        //$where['id']
        //pre($pt_max); die();
        $this->Cce_model->update_cce_setting($data);
        $this->session->set_flashdata('flash_message', get_phrase('PT_settings_saved'));
    }
    if ($param1 == 'notebook_max') {
        $notebook_max = $this->input->post('maxmarks');
        //pre($notebook_max); die();
        $data['notebook_max'] = $notebook_max;
        $this->Cce_model->update_cce_setting($data);
        $this->session->set_flashdata('flash_message', get_phrase('Notebook_settings_saved'));
    }
    if ($param1 == 'se_max') {
        $se_max = $this->input->post('maxmarks');
        //pre($se_max); die();
        $data['se_max'] = $se_max;
        $this->Cce_model->update_cce_setting($data);
        $this->session->set_flashdata('flash_message', get_phrase('SE_settings_saved'));
    }
    $page_data['page_name'] = 'exam_settings';
    $page_data['page_title'] = get_phrase('exam_settings');
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    redirect($_SERVER['HTTP_REFERER']);
}

function gpa_settings($param1 = '', $param2 = '') {
    $this->load->model('Cce_model');
    $this->load->model("Ranking_model");
    $page_data = $this->get_page_data_var();
    if ($param1 == 'gpa_preference') {
        $preference = $this->input->post('pref');
        $id = $this->Ranking_model->update('', array('gpa_preference' => $preference));

        $this->session->set_flashdata('flash_message', get_phrase('gpa_preference_saved'));
    }
    if ($param1 == 'ranking_level') {
        $data['name'] = $this->input->post('name');
        $data['percent'] = $this->input->post('marks');
        $data['percent_limit'] = $this->input->post('limit');
        $data['number_subjects'] = $this->input->post('subjects');
        $data['subject_limit'] = $this->input->post('subject_limit');
        $result_query = $this->Ranking_model->get_ranking_row($data['name']);
        if (!$result_query) {
            $this->Ranking_model->add($data);
            $this->session->set_flashdata('flash_message', get_phrase('ranking_settings_saved'));
        } else {
            $this->session->set_flashdata('flash_message', get_phrase('duplicate_value_for_ranking'));
        }
    }
    if ($param1 == 'connect_exams') {
        $weightages = $this->input->post('weightage');
        $exam_id = $this->input->post('selected_exam');

        $group = mt_rand(10000000, 99999999);
        $i = 0;
        if (!empty($weightages)) {
            foreach ($weightages as $weightage) {
                $data['percent'] = $weightage;
                $data['exam_id'] = $exam_id[$i];
                $data['group_id'] = $group;
                //pre($data);
                $this->Cce_model->connect_gpa_exam($data);
                $i++;
            }
            //exit;
            $this->session->set_flashdata('flash_message', get_phrase('weightage_percentages_added'));
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    if ($param1 == 'delete') {
        $this->Exam_model->delete_gpa_connect_exam($param2);
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect($_SERVER['HTTP_REFERER']);
    }
    /* $page_data['fa_max'] = $this->Cce_model->get_cce_setting('fa_max');
      $page_data['sa_max'] = $this->Cce_model->get_cce_setting('sa_max'); */
    $page_data['page_name'] = 'exam_settings';
    $page_data['page_title'] = get_phrase('exam_settings');
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $this->load->view('backend/index', $page_data);
}

function cwa_settings($param1 = '', $param2 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Cce_model');
    $page_data = $this->get_page_data_var();
    if ($param1 == 'connect_exams') {
        $weightages = $this->input->post('weightage');
        $exam_id = $this->input->post('selected_exam');

        $group = mt_rand(10000000, 99999999);
        $i = 0;
        if (!empty($weightages)) {
            foreach ($weightages as $weightage) {
                $data['percent'] = $weightage;
                $data['exam_id'] = $exam_id[$i];
                $data['group_id'] = $group;
                //pre($data);
                $this->Cce_model->connect_cwa_exam($data);
                $i++;
            }
            //exit;
            $this->session->set_flashdata('flash_message', get_phrase('weightage_percentages_added'));
        }
        $page_data['page_name'] = 'exam_settings';
        $page_data['page_title'] = get_phrase('exam_settings');
        /* $this->load->view('backend/index', $page_data); */
        redirect($_SERVER['HTTP_REFERER']);
    }
    if ($param1 == 'ranking_level') {
        $data['name'] = $this->input->post('name');
        $data['percent'] = $this->input->post('marks');
        $data['percent_limit'] = $this->input->post('limit');
        $data['number_subjects'] = $this->input->post('subjects');
        $data['subject_limit'] = $this->input->post('subject_limit');
        $result_query = $this->Ranking_model->get_cwa_row($data['name']);
        if (!$result_query) {
            $this->Ranking_model->cwa_add($data);
            $this->session->set_flashdata('flash_message', get_phrase('ranking_settings_saved'));
        } else {
            $this->session->set_flashdata('flash_message', get_phrase('duplicate_value_for_name'));
        }
        $page_data['page_name'] = 'exam_settings';
        $page_data['page_title'] = get_phrase('exam_settings');
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        /* $this->load->view('backend/index', $page_data); */
        redirect($_SERVER['HTTP_REFERER']);
    }
    if ($param1 == 'delete') {
        $this->Exam_model->delete_cwa_connect_exam($param2);
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        /* redirect(base_url() . 'index.php?school_admin/exam_settings/', 'refresh'); */
        redirect($_SERVER['HTTP_REFERER']);
    }
}

function cce_classes($param1 = '', $param2 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Cce_model');
    $page_data = $this->get_page_data_var();
    if ($param1 == 'delete') {
        $this->Cce_model->delete_class($param2);
    }
    $this->session->set_flashdata('flash_message', get_phrase('class_deleted'));
    $page_data['fa_max'] = $this->Cce_model->get_cce_setting('fa_max');
    $page_data['sa_max'] = $this->Cce_model->get_cce_setting('sa_max');
    $page_data['page_name'] = 'exam_settings';
    $page_data['page_title'] = get_phrase('exam_settings');
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    //$this->load->view('backend/index', $page_data);
    redirect($_SERVER['HTTP_REFERER']);
}

function class_routine($param1 = '', $param2 = '', $param3 = '') {
    $this->load->model('Class_routine_model');
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    if ($param1 == 'create') {
        $this->form_validation->set_rules('class_id', 'Class Name', 'required');
        $this->form_validation->set_rules('section_id', 'Section', 'required');
        $this->form_validation->set_rules('subject_id', 'Subject', 'required');
        $this->form_validation->set_rules('day', 'Day', 'required');
        $this->form_validation->set_rules('time_start', 'Start time', 'required');
        $this->form_validation->set_rules('time_end', 'End time', 'required');
        $this->form_validation->set_rules('day', 'Day', 'required');
        if ($this->form_validation->run() == TRUE) {
            $data['class_id'] = $this->input->post('class_id');
            if ($this->input->post('section_id') != '') {
                $data['section_id'] = $this->input->post('section_id');
            }
            $data['subject_id'] = $this->input->post('subject_id');
            if ($this->input->post('time_start') == 12) {
                $data['time_start'] = ($this->input->post('time_start') * ($this->input->post('starting_ampm')) - (12));
            } else {
                $data['time_start'] = $this->input->post('time_start') + (12 * ($this->input->post('starting_ampm') - 1));
            }
            if ($this->input->post('time_end') == 12) {
                $data['time_end'] = ($this->input->post('time_end') * ($this->input->post('ending_ampm')) - (12));
            } else {
                $data['time_end'] = $this->input->post('time_end') + (12 * ($this->input->post('ending_ampm') - 1));
            }
            if (($this->input->post('time_start_min') == "5") || ($this->input->post('time_start_min') == "0")) {
                $data['time_start_min'] = "0" . $this->input->post('time_start_min');
            } else {
                $data['time_start_min'] = $this->input->post('time_start_min');
            }
            if (($this->input->post('time_end_min') == "5") || ($this->input->post('time_end_min') == "0")) {
                $data['time_end_min'] = "0" . $this->input->post('time_end_min');
            } else {
                $data['time_end_min'] = $this->input->post('time_end_min');
            }
            $data['time_end_min'] = $this->input->post('time_end_min');
            $data['day'] = $this->input->post('day');
            $data['year'] = $this->globalSettingsRunningYear;
            $class_routine = $this->Class_routine_model->get_data_by_cols('*', array('class_id' => $data['class_id'], 'section_id' => $data['section_id'], 'time_start' => $data['time_start'], 'time_end' => $data['time_end'], 'day' => $data['day'], 'year' => $data['year']), 'result_array');

            if (!empty($class_routine)) {
                $this->session->set_flashdata('flash_message_error', get_phrase('duplicate_entry_because_' . $class_routine[0]['time_start'] . ':' . $class_routine[0]['time_start_min'] . '-' . $class_routine[0]['time_end'] . ':' . $class_routine[0]['time_end_min'] . '_subject_is_already_alloted'));
                redirect(base_url() . 'index.php?school_admin/class_routine_add/', 'refresh');
            } else {
                $this->Class_routine_model->add($data);
                $this->session->set_flashdata('flash_message', get_phrase('class_routine_added_successfully'));
                redirect(base_url() . 'index.php?school_admin/class_routine_view/' . $data['class_id'], 'refresh');
            }
        } else {
            $this->session->set_flashdata('flash_message_error', validation_errors());
            redirect(base_url() . 'index.php?school_admin/class_routine_add/', 'refresh');
        }
    }

    if ($param1 == 'do_update') {
        $data['class_id'] = $this->input->post('class_id');
        if ($this->input->post('section_id') != '') {
            $data['section_id'] = $this->input->post('section_id');
        }
        $data['subject_id'] = $this->input->post('subject_id');
        if ($this->input->post('time_start') == 12) {
            $data['time_start'] = ($this->input->post('time_start') * ($this->input->post('starting_ampm')) - (12));
        } else {
            $data['time_start'] = $this->input->post('time_start') + (12 * ($this->input->post('starting_ampm') - 1));
        }
        if ($this->input->post('time_end') == 12) {
            $data['time_end'] = ($this->input->post('time_end') * ($this->input->post('ending_ampm')) - (12));
        } else {
            $data['time_end'] = $this->input->post('time_end') + (12 * ($this->input->post('ending_ampm') - 1));
        }

        if (($this->input->post('time_start_min') == "5") || ($this->input->post('time_start_min') == "0")) {
            $data['time_start_min'] = "0" . $this->input->post('time_start_min');
        } else {
            $data['time_start_min'] = $this->input->post('time_start_min');
        }
        if (($this->input->post('time_end_min') == "5") || ($this->input->post('time_end_min') == "0")) {
            $data['time_end_min'] = "0" . $this->input->post('time_end_min');
        } else {
            $data['time_end_min'] = $this->input->post('time_end_min');
        }
        $data['day'] = $this->input->post('day');
        $data['year'] = $this->globalSettingsRunningYear;
        $class_routine = $this->Class_routine_model->get_data_by_cols('count(class_routine_id)as count', array('class_id' => $data['class_id'], 'section_id' => $data['section_id']
            , 'time_start' => $data['time_start'], 'time_end' => $data['time_end'],
            'day' => $data['day'], 'year' => $data['year'], 'class_routine_id' . '!=' => $param2), 'result_array');
//            pre($class_routine);exit;
        if ($class_routine[0]['count'] != 0) {
            $this->session->set_flashdata('flash_message_error', get_phrase('couldnot_edit_because_of_duplicate_entry_subject_is_already_alloted_at_this_time'));
            redirect(base_url() . 'index.php?school_admin/class_routine_view/' . $data['class_id'], 'refresh');
        } else {
            $this->Class_routine_model->update($param2, $data);

            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
            redirect(base_url() . 'index.php?school_admin/class_routine_view/' . $data['class_id'], 'refresh');
        }
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->Class_routine_model->get_data_by_cols('*', array(
            'class_routine_id' => $param2
                ), 'result_type');
    }
    if ($param1 == 'delete') {
        $class_id = $this->Class_routine_model->get_class_row($param2);
        $this->Class_routine_model->delete($param2);
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?school_admin/class_routine_view/' . $class_id, 'refresh');
    }
}

function class_routine_add() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['classes'] = $this->Class_model->get_data_by_cols("*", array(), "result_array");
    $page_data['page_name'] = 'class_routine_add';
    $page_data['page_title'] = get_phrase('add_class_timetable');
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $this->load->view('backend/index', $page_data);
}

function class_routine_views() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model("Subject_model");
    $page_data = $this->get_page_data_var();
    $page_data['page_name'] = 'class_routine_view';
    $page_data['class_id'] = $this->Class_model->get_first_class_id();
    $page_data['classes'] = $this->Class_model->get_data_by_cols('*', array(), 'result_array', array('name_numeric' => 'asc'));
    $page_data['page_title'] = get_phrase('class_timetable');
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $return_class_data = $this->Class_model->get_data_by_cols('*', array(), 'result_array', array('name_numeric' => 'asc'));

    $page_data['classes_array'] = $return_class_data;
    $class = $this->Class_model->get_data_by_cols('name', array('class_id' => $page_data['class_id']), 'result_array');
    if (!empty($class)) {
        $class_names = array_shift($class);
        $page_data['class_name'] = array_shift($class_names);
    }
    $year = $this->globalSettingsRunningYear;
    $class_routine = array();
    $sections = $this->Section_model->get_data_by_cols('*', array('class_id' => $page_data['class_id']), 'result_array');
    foreach ($sections as $section) {
        $routine = array();
        for ($d = 1; $d <= 7; $d++) {
            if ($d == 1)
                $day = 'sunday';
            else if ($d == 2)
                $day = 'monday';
            else if ($d == 3)
                $day = 'tuesday';
            else if ($d == 4)
                $day = 'wednesday';
            else if ($d == 5)
                $day = 'thursday';
            else if ($d == 6)
                $day = 'friday';
            else if ($d == 7)
                $day = 'saturday';
            $routiness = $this->Class_routine_model->get_data_by_cols('*', array('day' => $day, 'class_id' => $page_data['class_id'], 'section_id' => $section['section_id'], 'year' => $year), 'result_array', array('time_start' => 'asc'));
            $i = 0;
            $routine_det = array();
            foreach ($routiness as $value) {

                $subject = $this->Subject_model->get_data_by_cols('name as subject_name,teacher_id', array('subject_id' => $value['subject_id']), 'result_array');
                $subject_name = array_shift($subject);


                $teachers_name = $this->Teacher_model->get_data_by_cols('name as teacher_name', array('teacher_id' => $subject_name['teacher_id']), 'result_array');
                $teacher_name = array_shift($teachers_name);
                $teacher_name = $teacher_name['teacher_name'];
                $subject_name = $subject_name['subject_name'];

                $routine_det[$i]['subject_name'] = $subject_name;
                $routine_det[$i]['teacher_name'] = $teacher_name;
                $routine_det[$i]['time_start'] = $value['time_start'];
                $routine_det[$i]['time_end'] = $value['time_end'];
                $routine_det[$i]['time_start_min'] = $value['time_start_min'];
                $routine_det[$i]['time_end_min'] = $value['time_end_min'];
                $routine_det[$i]['isActive'] = $value['isActive'];
                $routine_det[$i]['class_routine_id'] = $value['class_routine_id'];
                $i++;
            }
            $routine[$day] = $routine_det;
        }

        $class_routine[$section['name']][$section['section_id']] = $routine;
    }
    $page_data['routines'] = $class_routine;
    $this->load->view('backend/index', $page_data);
}

function class_routine_view($class_id = "") {
    $this->load->model("Class_routine_model");
    $this->load->model("Subject_model");
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['page_name'] = 'class_routine_view';
    $page_data['class_id'] = $class_id;
    $page_data['page_title'] = get_phrase('class_timetable');
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['classes'] = $this->Class_model->get_data_by_cols('*', array(), 'result_array', array('name_numeric' => 'asc'));
    $class = $this->Class_model->get_data_by_cols('name', array('class_id' => $class_id), 'result_array');
    $class_names = array_shift($class);
    if (!empty($class_names)) {
        $page_data['class_name'] = array_shift($class_names);
    } else {
        $page_data['class_name'] = "";
    }
    $year = $this->globalSettingsRunningYear;
    $class_routine = array();
    $sections = $this->Section_model->get_data_by_cols('*', array('class_id' => $class_id), 'result_array');
    foreach ($sections as $section) {
        $routine = array();
        for ($d = 1; $d <= 7; $d++) {
            if ($d == 1)
                $day = 'sunday';
            else if ($d == 2)
                $day = 'monday';
            else if ($d == 3)
                $day = 'tuesday';
            else if ($d == 4)
                $day = 'wednesday';
            else if ($d == 5)
                $day = 'thursday';
            else if ($d == 6)
                $day = 'friday';
            else if ($d == 7)
                $day = 'saturday';
            $routiness = $this->Class_routine_model->get_data_by_cols('*', array('day' => $day, 'class_id' => $class_id, 'section_id' => $section['section_id'], 'year' => $year), 'result_array', array('time_start' => 'asc'));
            $i = 0;
            $routine_det = array();
            foreach ($routiness as $value) {
                $subject = $this->Subject_model->get_data_by_cols('name as subject_name,teacher_id', array('subject_id' => $value['subject_id']), 'result_array');
                $subject_name = array_shift($subject);

                $teachers_name = $this->Teacher_model->get_data_by_cols('name as teacher_name', array('teacher_id' => $subject_name['teacher_id']), 'result_array');
                $teacher_name = array_shift($teachers_name);
                $teacher_name = $teacher_name['teacher_name'];
                $subject_name = $subject_name['subject_name'];

                $routine_det[$i]['subject_name'] = $subject_name;
                $routine_det[$i]['teacher_name'] = $teacher_name;
                $routine_det[$i]['time_start'] = $value['time_start'];
                $routine_det[$i]['time_end'] = $value['time_end'];
                $routine_det[$i]['time_start_min'] = $value['time_start_min'];
                $routine_det[$i]['time_end_min'] = $value['time_end_min'];
                $routine_det[$i]['isActive'] = $value['isActive'];
                $routine_det[$i]['class_routine_id'] = $value['class_routine_id'];
                $i++;
            }
            $routine[$day] = $routine_det;
        }

        $class_routine[$section['name']][$section['section_id']] = $routine;
    }
    $page_data['routines'] = $class_routine;
    $page_data['classes_array'] = $this->Class_model->get_data_by_cols('*', array(), 'result_array');
    $this->load->view('backend/index', $page_data);
}

function class_routine_print_view($class_id, $section_id) {
    $this->load->model("Class_routine_model");
    $this->load->model("Section_model");
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['class_id'] = $class_id;
    $page_data['section_id'] = $section_id;
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['class_name'] = $this->Class_model->single_name($class_id);
    $page_data['section_name'] = $this->Section_model->single_name($section_id);
    $page_data['system_name'] = $this->Setting_model->settings(array('type' => 'system_name'));
    $page_data['running_year'] = $this->Setting_model->settings(array('type' => 'running_year'));
    $page_data['day_arr'] = array("1" => "sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday");

    for ($d = 1; $d <= 7; $d++) {
        $sort_array = array("time_start");
        $where_array = array('day' => $page_data['day_arr'][$d], "class_id" => $class_id, "section_id" => $section_id, "year" => $page_data['running_year']);
        $page_data['routines'][$d] = $this->Class_routine_model->get_data_by_cols("*", $where_array, "result_array", $sort_array);
        foreach ($page_data['routines'][$d] as $k => $v) {
            $page_data['routines'][$d][$k]['subject_name'] = $this->crud_model->get_subject_name_by_id($v['subject_id']);
        }
    } //pre($page_data['routines']);
    //pre($page_data['routines']); 
    //exit;
    $this->load->view('backend/school_admin/class_routine_print_view', $page_data);
}

function get_class_section_subject($class_id) {
    $page_data = $this->get_page_data_var();
    $this->load->model("Section_model");
    $page_data['section'] = $this->Section_model->get_data_by_cols('*', array('class_id' => $class_id), 'result_type');
    $this->load->model("Section_model");
    $page_data['sections'] = $this->Section_model->get_data_by_cols('*', array('class_id' => $class_id), 'result_type');
    $page_data['class_id'] = $class_id;
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $this->load->view('backend/school_admin/class_routine_section_subject_selector', $page_data);
}

function section_subject_edit($class_id, $class_routine_id) {
    $page_data = $this->get_page_data_var();
    $page_data['class_id'] = $class_id;
    $page_data['class_routine_id'] = $class_routine_id;
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['subject_id'] = $this->Class_routine_model->get_subject_id(array('class_routine_id' => $class_routine_id));
    $this->load->model("Section_model");
    $this->load->model("Class_routine_model");
    $this->load->model("Subject_model");
    $page_data['sections'] = $this->Section_model->get_data_by_cols("*", array('class_id' => $page_data['class_id']), "result_arr");

    if (count($page_data['sections']) > 0):
        $section_arr = $this->Class_routine_model->get_data_by_cols('section_id', array('class_routine_id' => $page_data['class_routine_id']), "result_arr");
        $page_data['section_id'] = $section_arr[0]['section_id'];
    endif;
    $page_data['subjects'] = $this->Subject_model->get_data_by_cols("*", array('class_id' => $page_data['section_id'], 'class_id' => $page_data['class_id']), "result_arr");

    $this->load->view('backend/school_admin/class_routine_section_subject_edit', $page_data);
}

function manage_attendance() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['classes'] = $this->Class_model->get_class_array();
    $this->load->model("Holiday_model");
    $holidays = $this->Holiday_model->get_holiday_list_attendance();
    $holiday_dates = array();
    foreach ($holidays as $holiday) {
        $holiday_dates[] = $holiday['date_start'];
        for ($i = 0; $i < ($holiday['number_of_days'] - 1); $i++) {
            $holiday_dates[] = date('Y-m-d', strtotime($holiday['date_start'] . ' + ' . $i . ' days'));
        }
    }
    $page_data['holidays'] = $holiday_dates;
    $page_data['page_name'] = 'manage_attendance';
    $page_data['page_title'] = get_phrase('manage_attendance_of_class');
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $this->load->view('backend/index', $page_data);
}

function save_class_order() {
    $class_id_string = $this->input->post("order");
    $class_ids = explode(",", $class_id_string);
    $this->load->model("Class_model");
    $this->Class_model->save_class_in_order($class_ids);
    echo "success";
}

function manage_attendance_view($class_id = '', $section_id = '', $timestamp = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Attendance_model');
    $this->load->model("Section_model");
    $this->load->model("Holiday_model");

    $page_data = $this->get_page_data_var();
    $page_data['class_name'] = $this->Class_model->get_class_record(array('class_id' => $class_id), "name");
    $page_data['section_name'] = $this->Class_model->get_section_record(array('section_id' => $section_id), "name");
    $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
    $page_data['class_id'] = $class_id;
    $page_data['status']    =   array(['status_value'=>'0','status_name'=>'undefined'],['status_value'=>'1','status_name'=>'present'],['status_value'=>'2','status_name'=>'absent']);
    $page_data['timestamp'] = $timestamp;
    $page_data['section_id'] = $section_id;
    $page_data['page_title'] = get_phrase('manage_attendance_of_class') . ' ' . $page_data['class_name'] . ' : ' . get_phrase('section') . ' ' . $page_data['section_name'];
    $page_data['att_of_students'] = $this->Attendance_model->getstudents_attendence($page_data['class_id'], $page_data['section_id'], $running_year, $page_data['timestamp']);
    //pre($page_data['att_of_students']); die();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['classes'] = $this->Class_model->get_data_by_cols('*', array(), 'result_type');
    $page_data['sections'] = $this->Section_model->get_data_by_cols('*', array("class_id" => $class_id));
    $holidays = $this->Holiday_model->get_holiday_list_attendance();
    $holiday_dates = array();
    foreach ($holidays as $holiday) {
        $holiday_dates[] = $holiday['date_start'];
        for ($i = 0; $i < ($holiday['number_of_days'] - 1); $i++) {
            $holiday_dates[] = date('Y-m-d', strtotime($holiday['date_start'] . ' + ' . $i . ' days'));
        }
    }
    $page_data['holidays'] = $holiday_dates;
    $page_data['page_name'] = 'manage_attendance_view';
    $this->load->view('backend/index', $page_data);
}

function get_section($class_id) {
    $page_data = $this->get_page_data_var();
    $page_data['class_id'] = $class_id;
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $this->load->view('backend/school_admin/manage_attendance_section_holder', $page_data);
}

function attendance_selector() {
    $this->form_validation->set_rules('class_id', 'Class', 'required');
    $this->form_validation->set_rules('section_id', 'Section', 'required');
    $this->form_validation->set_rules('timestamp', 'Date', 'required');
    $page_data = $this->get_page_data_var();
    if ($this->form_validation->run() == TRUE) {
        $data['class_id'] = $this->input->post('class_id');
        $data['year'] = $this->input->post('year');
        $data['timestamp'] = strtotime($this->input->post('timestamp'));
        $data['section_id'] = $this->input->post('section_id');
        $this->load->model("Holiday_model");
        $holidays = $this->Holiday_model->get_holiday_list_attendance();
        $holiday_dates = array();
        foreach ($holidays as $holiday) {
            $holiday_dates[] = $holiday['date_start'];
            for ($i = 0; $i < ($holiday['number_of_days'] - 1); $i++) {
                $holiday_dates[] = date('Y-m-d', strtotime($holiday['date_start'] . ' + ' . $i . ' days'));
            }
        }
        $page_data['holidays'] = $holiday_dates;
        $page_data['query'] = $this->Attendance_model->get_data_by_cols("*", array('class_id' => $data['class_id'], 'section_id' => $data['section_id'], 'year' => $data['year'], 'timestamp' => $data['timestamp']), "result_array");

        if (count($page_data['query']) < 1) {
            $students = $this->Enroll_model->get_data_by_cols("*", array('class_id' => $data['class_id'], 'section_id' => $data['section_id'], 'year' => $data['year']), "result_array");
        } else {
            $class_id = $data['class_id'];
            $students = $this->Student_model->student_attendance($data['class_id'], $data['year'], $data['timestamp']);
            //echo $this->db->last_query();
            //die;
            //pre($students); die();
            if (empty($students)) {
                redirect(base_url() . 'index.php?school_admin/manage_attendance_view/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['timestamp'], 'refresh');
            }
        }
        //echo count($students);
        $count_student=0;
        foreach ($students as $row) {

            $attn_data['class_id'] = $data['class_id'];
            $attn_data['year'] = $data['year'];
            $attn_data['timestamp'] = $data['timestamp'];
            $attn_data['section_id'] = $data['section_id'];
            $attn_data['student_id'] = $row['student_id'];
            //pre($attn_data); 
            $rs = $this->Attendance_model->get_data_by_cols("*", array("year" => $data['year'], "timestamp" => $data['timestamp'], "student_id" => $row['student_id']), 'result_type');
            
            $count_student+= count($rs);
           
        }//echo $count_student;
            //echo $this->db->last_query();
            /*echo count($count_student).'<br/>';
            echo count($students).'<br/>';*/ //die();
            if($count_student < count($students)){
                $class_id = $data['class_id'];
                $year = $data['year'];
                $timestamp = $data['timestamp'];

                $query = $this->Student_model->get_data_not_in_attendance($class_id, $year, $timestamp);
                //pre($query); 
                $attn_data = array();
                foreach($query as $key => $dataadd){
                    $attn_data['class_id'] = $dataadd['class_id'];
                    $attn_data['year'] = $dataadd['year'];
                    $attn_data['timestamp'] = $data['timestamp'];
                    $attn_data['section_id'] = $dataadd['section_id'];
                    $attn_data['student_id'] = $dataadd['student_id'];
                    $this->Attendance_model->add($attn_data);
                    /*echo $this->db->last_query();*/
                }
                
        } //die();
        $page_data['attendance_of_students'] = $this->Attendance_model->get_data_by_cols('*', array('class_id' => $data['class_id'], 'section_id' => $data['section_id'], 'year' => $data['year'], 'timestamp' => $data['timestamp']), 'result_type');
        /*pre($page_data['attendance_of_students']);
        echo $this->db->last_query(); die();*/
        redirect(base_url() . 'index.php?school_admin/manage_attendance_view/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['timestamp'], 'refresh');
    } else {
        $page_data['classes'] = $this->Class_model->get_class_array();
        $page_data['page_name'] = 'manage_attendance';
        $page_data['page_title'] = get_phrase('manage_attendance_of_class');
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }
}

function attendance_update($class_id = '', $section_id = '', $timestamp = '') {
    $running_year = $this->globalSettingsRunningYear;
    $active_sms_service = $this->globalSettingsActiveSms;
    $locationData = $this->globalSettingsLocation;
    $page_data = $this->get_page_data_var();
    if (empty($locationData)) {
        $this->session->set_flashdata('flash_message', "Set locataion country name in setting  for notification use.");
        rediect(base_url() . 'index.php?school_admin/attendance_report');
    } else {
        $location = $this->globalSettingsLocation;
    }

    $attendance_of_students = $this->Attendance_model->get_data_by_cols('*', array('class_id' => $class_id, 'section_id' => $section_id, 'year' => $running_year, 'timestamp' => $timestamp), 'result_type');
    foreach ($attendance_of_students as $row) {
        $attendance_status = $this->input->post('update_attendance_' . $row['attendance_id']);
        //$attendance_status = $this->input->post('status_' . $row['attendance_id']);
        if ($attendance_status != '') {

            $this->Attendance_model->update($row['attendance_id'], array('status' => $attendance_status));

            //$this->Attendance_model->get_other_data($row['student_id']);
            $rsParentStudent = $this->Attendance_model->get_other_data($row['student_id']);
            if (!empty($rsParentStudent)) {
                $student_name = $rsParentStudent[0]['name'];
                $receiver_phone = $rsParentStudent[0]['cell_phone'];
                $device_token = $rsParentStudent[0]['device_token'];
                $parent_email = $rsParentStudent[0]['parent_email'];
                $parent_id = $rsParentStudent[0]['parent_id'];
                $parent_name = $rsParentStudent[0]['father_name'] . " " . $rsParentStudent[0]['father_lname'];
            }

            $fcm_server_key = $this->globalSettingsSystemFCMServerrKey;

            if ($attendance_status == 2) {
                $message = 'Your child' . ' ' . ucfirst($student_name) . ' is absent today.';
                $activity = 'child_out';
            } else {
                $message = 'Your child' . ' ' . ucfirst($student_name) . ' is present today.';
                $activity = 'child_in';
            }

            $msg = $message;
            $message = array();
            $message_body = $msg;
            $message['sms_message'] = $msg;
            $message['subject'] = $this->globalSettingsSystemName . " Student Attendance";
            $message['messagge_body'] = $message_body;
            $message['to_name'] = $parent_name;

            $phone = array($receiver_phone);
            $email = array($parent_email);

            $user_details = array();
            $user_details = array('user_id' => $parent_id, 'user_type' => 'parent');

            if ($device_token != "") {
                $user_details['device_details'] = array(
                    'token' => $device_token,
                    'server_key' => $fcm_server_key,
                    'instance' => CURRENT_INSTANCE);
            }
            send_school_notification($activity, $message, $phone, $email, $user_details);

            $this->session->set_flashdata('flash_message', get_phrase('attendance_updated'));
        }
    }

    redirect(base_url() . 'index.php?school_admin/manage_attendance_view/' . $class_id . '/' . $section_id . '/' . $timestamp, 'refresh');
}

/* * **** DAILY ATTENDANCE **************** */

function manage_attendance2($date = '', $month = '', $year = '', $class_id = '', $section_id = '', $session = '') {
    //echo "Jesus"; exit;  
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');

    $active_sms_service = $this->globalSettingsActiveSms;
    $running_year = $this->globalSettingsRunningYear;


    if ($_POST) {
        // Loop all the students of $class_id
        $classArr = array('class_id' => $class_id);
        $sectionArr = array('section_id' => $section_id);
        $this->Class_model->get_data_by_cols('*', $classArr, 'result_type');
        if ($section_id != '') {
            $this->Section_model->get_data_by_cols('*', $sectionArr, 'result_type');
        }
        //$session = base64_decode( urldecode( $session ) );

        $arr = array("year" => $session);
        $students = $this->Enroll_model->get_data_by_cols('*', $arr, 'result_type');
        foreach ($students as $row) {
            $attendance_status = $this->input->post('status_' . $row['student_id']);


            $this->Attendance_model->update_status($row['student_id'], $date, $year, $row['class_id'], $row['section_id'], $attendance_status);
            if ($attendance_status == 2) {

                if ($active_sms_service != '' || $active_sms_service != 'disabled') {
                    $student_name = $this->Student_model->get_student_name($row['student_id']);
                    $parent_id = $this->Student_model->get_parent_id($row['student_id']);
                    $receiver_phone = $this->Student_model->get_parent_phone($row['student_id']);
                    $message = 'Your child' . ' ' . $student_name . 'is absent today.';
                    send_school_notification('stud_absence', $message, array($receiver_phone));
                }
            }
        }

        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?school_admin/manage_attendance/' . $date . '/' . $month . '/' . $year . '/' . $class_id . '/' . $section_id . '/' . $session, 'refresh');
    }
    $page_data['date'] = $date;
    $page_data['month'] = $month;
    $page_data['year'] = $year;
    $page_data['class_id'] = $class_id;
    $page_data['section_id'] = $section_id;
    $page_data['session'] = $session;

    $page_data['page_name'] = 'manage_attendance';
    $page_data['page_title'] = get_phrase('manage_daily_attendance');
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $this->load->view('backend/index', $page_data);
}

function attendance_selector2() {
    //$session = $this->input->post('session');
    //$encoded_session = urlencode( base64_encode( $session ) );
    redirect(base_url() . 'index.php?school_admin/manage_attendance/' . $this->input->post('date') . '/' .
            $this->input->post('month') . '/' .
            $this->input->post('year') . '/' .
            $this->input->post('class_id') . '/' .
            $this->input->post('section_id') . '/' .
            $this->input->post('session'), 'refresh');
}

///////ATTENDANCE REPORT /////
function attendance_report() {
    $page_data = $this->get_page_data_var();
    $page_data['page_name'] = 'attendance_report';
    $page_data['page_title'] = get_phrase('attendance_report');
    $page_data['classes'] = $this->Class_model->get_class_array();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $this->load->view('backend/index', $page_data);
}

function attendance_report_selector() {
    $this->form_validation->set_rules('class_id', 'Class', 'required');
    $this->form_validation->set_rules('section_id', 'Section', 'required');
    $this->form_validation->set_rules('month', 'Month', 'required');
    $page_data = $this->get_page_data_var();
    if ($this->form_validation->run() == TRUE) {
        $data['class_id'] = $this->input->post('class_id');
        $data['year'] = $this->input->post('year');
        $data['month'] = $this->input->post('month');
        $data['section_id'] = $this->input->post('section_id');
        redirect(base_url() . 'index.php?school_admin/attendance_report_view/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['month'], 'refresh');
    } else {
        $page_data['classes'] = $this->Class_model->get_data_by_cols('class_id, name', array(), 'result_array');
        $page_data['page_name'] = 'attendance_report';
        $page_data['page_title'] = get_phrase('attendance_report');
        //$page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }
}

function attendance_report_view($class_id = '', $section_id = '', $month = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();

    $this->load->model('Student_model');
    $this->load->model("Holiday_model");
    $holidays = $this->Holiday_model->get_holiday_list_attendance();
    $holiday_dates = array();
    foreach ($holidays as $holiday) {
        $holiday_dates[] = $holiday['date_start'];
        for ($i = 0; $i < ($holiday['number_of_days'] - 1); $i++) {
            $holiday_dates[] = date('Y-m-d', strtotime($holiday['date_start'] . ' + ' . $i . ' days'));
        }
    }
    $page_data['holidays'] = $holiday_dates;
    $setting_records = $this->Setting_model->get_data_by_cols('*', array(), 'result_array');
    $page_data['minimum_attendance'] = fetch_parl_key_rec($setting_records, 'minimum_attendance');
    $page_data['class_name'] = $this->Class_model->get_class_record(array('class_id' => $class_id), "name");
    $page_data['section_name'] = $this->Class_model->get_section_record(array('section_id' => $section_id), "name");
    $page_data['class_id'] = $class_id;
    $page_data['section_id'] = $section_id;
    $page_data['month'] = $month;
    $page_data['page_name'] = 'attendance_report_view';
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['classes'] = $this->Class_model->get_data_by_cols("*", array(), "arrr");
    $page_data['sections'] = $this->Section_model->get_data_by_cols("*", array('class_id' => $class_id), "result_array");
    $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
    $page_data['students'] = $this->Student_model->get_students_attendance($class_id, $section_id, $running_year);
    $page_data['year'] = explode('-', $running_year);
    $page_data['days'] = cal_days_in_month(CAL_GREGORIAN, $month, $page_data['year'][0]);
    $page_data['page_title'] = get_phrase('attendance_report_of_class') . ' ' . $page_data['class_name'] . ' : ' . get_phrase('section') . ' ' . $page_data['section_name'];
    //Add Attendance array to student array


    foreach ($page_data['students'] as $k => $v) {
        $p = 0;
        for ($i = 1; $i <= $page_data['days']; $i++) {
            $timestamp = strtotime($i . '-' . $month . '-' . $page_data['year'][0]);
            $data = array('section_id' => $page_data['section_id'], 'class_id' => $page_data['class_id'], "year" => $running_year, "timestamp" => $timestamp, 'student_id' => $v['student_id']);
            $atten = $this->Student_model->get_attendance($data);

            if (!empty($atten) && count($atten) > 0)

            //pre($atten); die();
                if (isset($atten) && !empty($atten) && count($atten) > 0)
                    $page_data['students'][$k]['atten'][$p] = $atten[0];
            $p++;
        }
    }//pre($page_data); die();
    //echo "<pre>";print_r( $page_data['students']);exit;
    $this->load->view('backend/index', $page_data);
}

function attendance_report_print_view($class_id = '', $section_id = '', $month = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    //
    $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
    //
    $page_data['class_id'] = $class_id;
    $page_data['section_id'] = $section_id;
    $page_data['month'] = $month;

    $page_data['class_name'] = $this->Class_model->get_class_record(array('class_id' => $class_id), "name");
    $page_data['section_name'] = $this->Class_model->get_section_record(array('section_id' => $section_id), "name");
    $page_data['running_year'] = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
    $page_data['system_name'] = $this->Setting_model->get_setting_record(array('type' => 'system_name'), 'description');
    $page_data['students'] = $this->Student_model->get_students_attendance($class_id, $section_id, $page_data['running_year']);
    $page_data['year'] = explode('-', $page_data['running_year']);
    $days = cal_days_in_month(CAL_GREGORIAN, $page_data['month'], $page_data['year'][0]);
    $this->load->model("Holiday_model");
    $holidays = $this->Holiday_model->get_holiday_list_attendance();
    $holiday_dates = array();
    foreach ($holidays as $holiday) {
        $holiday_dates[] = $holiday['date_start'];
        for ($i = 0; $i < ($holiday['number_of_days'] - 1); $i++) {
            $holiday_dates[] = date('Y-m-d', strtotime($holiday['date_start'] . ' + ' . $i . ' days'));
        }
    }
    $page_data['holidays'] = $holiday_dates;
    $setting_records = $this->Setting_model->get_data_by_cols('*', array(), 'result_array');
    $page_data['minimum_attendance'] = fetch_parl_key_rec($setting_records, 'minimum_attendance');
    foreach ($page_data['students'] as $k => $v) {
        $p = 0;
        for ($i = 1; $i <= $days; $i++) {
            $timestamp = strtotime($i . '-' . $month . '-' . $page_data['year'][0]);
            $tempArr = array('section_id' => $page_data['section_id'], 'class_id' => $page_data['class_id'], "year" => $running_year, "timestamp" => $timestamp, 'student_id' => $v['student_id']);
            $attendance = $this->Student_model->get_attendance($tempArr);
            $page_data['attendance'] = $attendance;
            //pre($attendance); die();
            if (!empty($attendance) && count($attendance) > 0)
                $page_data['students'][$k]['attendance'][$p] = $attendance[0];
            //pre($page_data['students'][$k]['attendance'][$p]);
            $p++;
        }
    }
    $page_data['days'] = $days;
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $this->load->view('backend/school_admin/attendance_report_print_view', $page_data);
}

/* * ****MANAGE BILLING / INVOICES WITH STATUS**** */

function invoice($param1 = '', $param2 = '', $param3 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');

    $this->load->model("Invoice_model");
    $this->load->model("Payment_model");
    $page_data = $this->get_page_data_var();
    if ($param1 == 'create') {
        $data['student_id'] = $this->input->post('student_id');
        $data['title'] = $this->input->post('title');
        $data['description'] = $this->input->post('description');
        $data['amount'] = $this->input->post('amount');
        $data['amount_paid'] = $this->input->post('amount_paid');
        $data['due'] = $data['amount'] - $data['amount_paid'];
        $data['status'] = $this->input->post('status');
        //$data['creation_timestamp'] = trtotime($this->input->post('date'));
        $running_year = $this->globalSettingsRunningYear;
        $data['year'] = $running_year[0]->description;
        $invoice_id = $this->Invoice_model->add($data);

        $data2['invoice_id'] = $invoice_id;
        $data2['student_id'] = $this->input->post('student_id');
        $data2['title'] = $this->input->post('title');
        $data2['description'] = $this->input->post('description');
        $data2['payment_type'] = 'income';
        $data2['method'] = $this->input->post('method');
        $data2['amount'] = $this->input->post('amount_paid');
        //$data2['timestamp'] = strtotime($this->input->post('date'));
        $running_year = $this->globalSettingsRunningYear;
        $data['year'] = $running_year[0]->description;

        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?school_admin/student_payment', 'refresh');
    }

    if ($param1 == 'create_mass_invoice') {
        foreach ($this->input->post('student_id') as $id) {

            $data['student_id'] = $id;
            $data['title'] = $this->input->post('title');
            $data['description'] = $this->input->post('description');
            $data['amount'] = $this->input->post('amount');
            $data['amount_paid'] = $this->input->post('amount_paid');
            $data['due'] = $data['amount'] - $data['amount_paid'];
            $data['status'] = $this->input->post('status');
            //$data['creation_timestamp'] = strtotime($this->input->post('date'));
            $data['year'] = $this->globalSettingsRunningYear;

            $invoice_id = $this->Invoice_model->add($data);


            $data2['invoice_id'] = $invoice_id;
            $data2['student_id'] = $id;
            $data2['title'] = $this->input->post('title');
            $data2['description'] = $this->input->post('description');
            $data2['payment_type'] = 'income';
            $data2['method'] = $this->input->post('method');
            $data2['amount'] = $this->input->post('amount_paid');
            //$data2['timestamp'] = strtotime($this->input->post('date'));
            $data2['year'] = $this->globalSettingsRunningYear;

            $this->Payment_model->add($data2);
        }

        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?school_admin/student_payment', 'refresh');
    }

    if ($param1 == 'do_update') {
        $data['student_id'] = $this->input->post('student_id');
        $data['title'] = $this->input->post('title');
        $data['description'] = $this->input->post('description');
        $data['amount'] = $this->input->post('amount');
        $data['status'] = $this->input->post('status');
        $data['creation_timestamp'] = strtotime($this->input->post('date'));
        $this->Invoice_model->update_invoice($param2, $data);

        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?school_admin/invoice', 'refresh');
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->Invoice_model->get_data_by_cols('*', array(
            'invoice_id' => $param2
                ), 'result_type');
    }
    if ($param1 == 'take_payment') {
        $data['invoice_id'] = $this->input->post('invoice_id');
        $data['student_id'] = $this->input->post('student_id');
        $data['title'] = $this->input->post('title');
        $data['description'] = $this->input->post('description');
        $data['payment_type'] = 'income';
        $data['method'] = $this->input->post('method');
        $data['amount'] = $this->input->post('amount');
        //$data['timestamp'] = strtotime($this->input->post('timestamp'));
        $data['year'] = $this->globalSettingsRunningYear;
        $this->Payment_model->add($data);

        $status['status'] = $this->input->post('status');

        $this->Invoice_model->update_status($param2, $status['status']);

        $data2['amount_paid'] = $this->input->post('amount');
        $data2['status'] = $this->input->post('status');

        $this->Invoice_model->update_invoice_amount($param2, $data2['amount_paid']);

        $this->session->set_flashdata('flash_message', get_phrase('payment_successfull'));
        redirect(base_url() . 'index.php?school_admin/income/', 'refresh');
    }

    if ($param1 == 'delete') {
        $this->Invoice_model->delete_invoice($param2);

        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?school_admin/income', 'refresh');
    }
    $page_data['page_name'] = 'invoice';
    $page_data['page_title'] = get_phrase('manage_invoice/payment');

    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['invoices'] = $this->Invoice_model->get_all_invoice();
    $this->load->view('backend/index', $page_data);
}

/* * ******************STUDENT CREDIT****************** */

function get_student_balance($param1 = '', $param2 = '') {
    //echo "Hello";
    $result = $this->Student_account_model->get_data_by_cols('*', array(
        'studentid' => $param1
            ), 'result_type');
    foreach ($result as $row) {

        echo $row["balance"];
    }
}

function dotransaction($param1 = '', $param2 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $page_data = $this->get_page_data_var();
    $data['studentid'] = $this->input->post('studentid');
    $data['amount'] = $this->input->post('amount');
    $data['type'] = $this->input->post('type');
    $data['description'] = $this->input->post('desc');
    $data['timestamp'] = strtotime($this->input->post('timestamp'));
    $this->Student_account_model->add_transaction($data);
    $account = $this->Student_account_model->get_balance($data['studentid']);

    if ($data['type'] == "credit") {
        $result["balance"] = (int) $account + (int) $data['amount'];
    } elseif ($data['type'] == "debit") {
        $result["balance"] = (int) $account - (int) $data['amount'];
    }
    $this->Student_account_model->update_student_account($data['studentid'], $result);


    $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
    redirect(base_url() . 'index.php?school_admin/student_payment', 'refresh');
}

/**
 * 
 * @param type $param1
 * @param type $param2s
 */
function income($param1 = '', $param2 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $this->load->model("Invoice_model");
    $page_data = $this->get_page_data_var();
    $page_data['page_name'] = 'income';
    $page_data['page_title'] = get_phrase('student_payments');
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['invoices'] = $this->Invoice_model->get_all_invoice();
    $this->load->view('backend/index', $page_data);
}

function student_payment($param1 = '', $param2 = '', $param3 = '') {

    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['page_name'] = 'student_payment';
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_title'] = get_phrase('create_student_payment');

    $this->load->model("Class_model");
    $page_data['classes'] = $this->Class_model->get_class_array();

    $this->load->view('backend/index', $page_data);
}

function expense($param1 = '', $param2 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $page_data = $this->get_page_data_var();
    if ($param1 == 'create') {
        $data['title'] = $this->input->post('title');
        $data['expense_category_id'] = $this->input->post('expense_category_id');
        $data['description'] = $this->input->post('description');
        $data['payment_type'] = 'expense';
        $data['method'] = $this->input->post('method');
        $data['amount'] = $this->input->post('amount');
        //$data['timestamp'] = strtotime($this->input->post('timestamp'));
        $data['year'] = $this->globalSettingsRunningYear;
        $this->Payment_model->add($data);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?school_admin/expense', 'refresh');
    }

    if ($param1 == 'edit') {
        $data['title'] = $this->input->post('title');
        $data['expense_category_id'] = $this->input->post('expense_category_id');
        $data['description'] = $this->input->post('description');
        $data['payment_type'] = 'expense';
        $data['method'] = $this->input->post('method');
        $data['amount'] = $this->input->post('amount');
        //$data['timestamp'] = strtotime($this->input->post('timestamp'));
        $data['year'] = $this->globalSettingsRunningYear;
        $this->Payment_model->update_payment($param2, $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?school_admin/expense', 'refresh');
    }

    if ($param1 == 'delete') {
        $this->Payment_model->payment_delete($param2);

        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?school_admin/expense', 'refresh');
    }

    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_name'] = 'expense';
    $page_data['page_title'] = get_phrase('expenses');
    $this->load->view('backend/index', $page_data);
}

function expense_category($param1 = '', $param2 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $page_data = $this->get_page_data_var();
    if ($param1 == 'create') {
        $data['name'] = $this->input->post('name');
        $this->Expense_category_model->add($data);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?school_admin/expense_category');
    }
    if ($param1 == 'edit') {
        $data['name'] = $this->input->post('name');
        $this->Expense_category_model->update_payment($param2, $data);

        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?school_admin/expense_category');
    }
    if ($param1 == 'delete') {
        $this->Expense_category_model->payment_delete($param2);

        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?school_admin/expense_category');
    }

    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_name'] = 'expense_category';
    $page_data['page_title'] = get_phrase('expense_category');
    $this->load->view('backend/index', $page_data);
}

function balance_sheet($param1 = '', $param2 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_name'] = 'balance_sheet';
    $page_data['page_title'] = get_phrase('balance_sheet');
    $page_data['payments'] = $this->Payment_model->get_data_by_cols('*', array(), 'result_type');

    $this->load->view('backend/index', $page_data);
}

/* * ********MANAGE LIBRARY / BOOKS******************* */

function book($param1 = '', $param2 = '', $param3 = '') {

    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $page_data = $this->get_page_data_var();
    if ($param1 == 'create') {
        $data['name'] = $this->input->post('name');
        $data['description'] = $this->input->post('description');
        $data['price'] = $this->input->post('price');
        $data['currency'] = $this->input->post('currency');
        $data['author'] = $this->input->post('author');
        $data['class_id'] = $this->input->post('class_id');
        $data['status'] = $this->input->post('status');
        $data['date_time'] = date("Y-m-d H:i:s");
        $data['isActive'] = '1';
        $this->Book_model->add($data);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?school_admin/book', 'refresh');
    }
    if ($param1 == 'do_update') {
        $data['name'] = $this->input->post('name');
        $data['description'] = $this->input->post('description');
        $data['price'] = $this->input->post('price');
        $data['currency'] = $this->input->post('currency');
        $data['author'] = $this->input->post('author');
        $data['class_id'] = $this->input->post('class_id');
        $data['status'] = $this->input->post('status');
        $data['change_time'] = date("Y-m-d H:i:s");
        $this->Book_model->update($param2, $data);

        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?school_admin/book', 'refresh');
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->Book_model->get_data_by_cols('*', array(
            'book_id' => $param2
                ), 'result_type');
    }

    if ($param1 == 'delete') {
        $this->Book_model->delete($param2);

        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?school_admin/book', 'refresh');
    }

    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['books'] = $this->Book_model->get_data_by_cols('*', array(), 'result_type');
    foreach ($page_data['books'] as $k => $v) {
        $page_data['books'][$k]['class_name'] = $this->crud_model->get_type_name_by_id('class', $v['class_id']);
    }
    $page_data['page_name'] = 'book';
    $page_data['page_title'] = get_phrase('manage_library_books');
    $this->load->view('backend/index', $page_data);
}

/* * 
 * 
 * * 
 * 
 * ********MANAGE TRANSPORT / VEHICLES / ROUTES******************* */

function transport($param1 = '', $param2 = '', $param3 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
//    $this->load->library("fi_functions");
//    $charges=$this->fi_functions->get_charges();
    $page_data = $this->get_page_data_var();
    if ($param1 == 'create') {
        $data['route_name'] = $this->input->post('route_name');
        //$data['number_of_vehicle'] = $this->input->post('number_of_vehicle');
        $data['description'] = $this->input->post('description');
//        $data['route_fare']     =   $this->input->post('route_fare');    
//        $charges_deatils        =   $this->input->post('route_fare');
//        $pieces                 =   explode("|", $charges_deatils);
//        $charges_amount         =   $pieces[0];
//        $charges_id             =   $pieces[1];
//        $data['route_fare']     =   $charges_amount;
        $this->load->model('Transport_model');
        $this->Transport_model->add($data);
//        $data2['fees_name']     =   "Transport_Fees-".$this->input->post('route_name');
//        $data2['fi_id']         =   $charges_id;
//        $data2['amount']        =   $charges_amount;
//        $data2['route_id']      =   $route_id;
//        $this->load->model('fee_fi_model');
//        $this->fee_fi_model->add($data2);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?school_admin/transport', 'refresh');
    }
    if ($param1 == 'do_update') {
        $data['route_name'] = $this->input->post('route_name');
        //$data['number_of_vehicle'] = $this->input->post('number_of_vehicle');
        $data['description'] = $this->input->post('description');
//        $data['route_fare'] = $this->input->post('route_fare');        
        $this->Transport_model->update($param2, $data);

        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?school_admin/transport', 'refresh');
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->Transport_model->get_data_by_cols('*', array(
            'transport_id' => $param2
                ), 'result_type');
    }
    if ($param1 == 'delete') {
        $this->Transport_model->delete($param2);

        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?school_admin/transport', 'refresh');
    }
    if ($param1 == 'import_excel') {

        $path = "uploads/routes_import.xlsx";
        //@unlink('uploads/routes_import.xlsx');
        @unlink($path);
        @unlink('uploads/routes_bulk_upload_error_details.log');

        if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $path)) {
            die('not moving');
        }
        @ini_set('memory_limit', '-1');
        @set_time_limit(0);
        include 'Simplexlsx.class.php';
        $xlsx = new SimpleXLSX($path);
        list($num_cols, $num_rows) = $xlsx->dimension();
        $f = 0;
        $fielsdStringForAdmin = "Route Name,Route From,Route To,Route Fare Name";
        $fielsdString = "route_id,route_from,route_to,route_fare";
        $fielsdStringMandotary = $fielsdString;
        $fielsdArr = explode(',', $fielsdString);
        $fielsdStringForAdminArr = explode(',', $fielsdStringForAdmin);
        $fielsdStringMandotaryArr = explode(',', $fielsdStringMandotary);
        $someRowError = FALSE;
        $errorMsgArr = array();
        $errorExcelArr = array();
        $errorExcelArr[] = $fielsdStringForAdminArr;
        $errorRowNo = 2;
        //pre($xlsx->rows());die;
        foreach ($xlsx->rows() as $r) {
            //echo '<pre>'; //print_r($r);die;
            $data = array();
            $dataParent = array();
            $error = FALSE;
            // Ignore the inital name row of excel file
            if ($f == 0) {
                $f++;
                continue;
            } $f++;
            //pre($fielsdArr);
            //pre($r);
            //if ($num_cols > count($fielsdArr)) {
            $num_cols = count($fielsdArr);
            //die($num_cols);
            //}
            $blankErrorMsgArr = array();
            $errorRowIncrease = FALSE;

            //echo $num_cols;die;
            for ($i = 0; $i < $num_cols; $i++) {    // checking is filds is mandetory or not
                //echo $fielsdArr[$i] . '<br>';
                if (in_array($fielsdArr[$i], $fielsdStringMandotaryArr)) {
                    //now validating mandetory fiels
                    //generate_log("Field " . $fielsdArr[$i] . " value \n", 'exam_bulk_upload_' . date('d-m-Y-H') . '.log');
                    //echo $r[$i].'<br>';
                    if (trim($r[$i]) == "") {
                        //echo "here"; //die();
                        $error = TRUE;
                        $blankErrorMsgArr[] = $fielsdStringForAdminArr[$i] . " should not be blank at row no " . $errorRowNo;
                    } else {
                        //pre($i);
                    }

                    if ($fielsdArr[$i] == 'route_id') {
                        $rsTransportRoute = $this->Transport_model->get_name($r[$i]);
                        if (count($rsTransportRoute) > 0) {
                            $data['route_id'] = $rsTransportRoute[0]->transport_id;
                            $route_name = trim($r[$i]);
                        } else {
                            $data['route_id'] = "";
                            $error = TRUE;
                            $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " content invalid data at row no -" . $errorRowNo . ' is not exist.';
                        }
                    }


                    if ($fielsdArr[$i] == 'route_fare') {
                        $routeFareArr = $this->Transport_model->get_route_fare(6, $this->globalSettingsRunningYear, trim($r[$i]));
                        if (!empty($routeFareArr)) {
                            $data[$fielsdArr[$i]] = $routeFareArr[0]->sales_price;
                        } else {
                            $error = TRUE;
                            $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " content invalid data at row no -" . $errorRowNo . ".Check in FI about transport data in charges list.";
                        }
                    }
                    if ($fielsdArr[$i] != 'route_id' && $fielsdArr[$i] != 'route_fare') {
                        $data[$fielsdArr[$i]] = trim($r[$i]);
                    }
                    //pre($data);
                    if (!empty($errorMsgArr)) {
                        //pre($errorMsgArr);die;
                    }
                    //pre(trim($fielsdArr[$i]));pre('$error');pre($error);
                } else {
                    //pre($errorMsgArr);//die;
                    //pre(trim($fielsdArr[$i]));pre('$error');pre($error);
                }
            }
            //die;
            if (count($blankErrorMsgArr) > 0) {
                $error = TRUE;
                if (count($blankErrorMsgArr) <= count($fielsdArr)) {
                    foreach ($blankErrorMsgArr AS $errorKey => $errorVal) {
                        $errorMsgArr[] = $errorVal;
                    }
                }
            }
            //pre($data); //die('//hii');
            //pre('$error');pre($error); //die();
            if ($error === FALSE) {
                $this->load->model('Route_bus_stop_model');
                $this->load->model('Fee_fi_model');
                //pre("before add");
                //pre($data);continue;
                $route_bus_stop_id = $this->Route_bus_stop_model->add($data);
                if ($route_bus_stop_id > 0) {
                    $data1 = array();
                    $data1['fees_name'] = 'Transport_Fees-' . $route_name;
                    $data1['fi_id'] = $route_bus_stop_id;
                    $data1['amount'] = $data['route_fare'];
                    $data1['route_id'] = $data['route_id'];
                    $this->Fee_fi_model->add($data1);
                }
            } else {
                //pre($errorMsgArr);//die;
                $errorRowNo++;
                $errorExcelArr[] = $r;
                $someRowError = TRUE;
            }
        } //ends foreach
        //pre($errorMsgArr); exit;

        if ($someRowError == FALSE) {
            //$this->generate_cv$error_msg);
            generate_log("No error for this upload at - " . time(), 'routes_bulk_upload' . date('d-m-Y-H') . '.log');
            $this->session->set_flashdata('flash_message', get_phrase('routes_details_added'));
            redirect(base_url() . 'index.php?school_admin/bulk_upload/', 'refresh');
        } else {
            //pre($errorMsgArr); die('here');
            generate_log(json_encode($errorMsgArr), 'routes_bulk_upload_error_details.log', TRUE);
            $file_name_with_path = 'uploads/routes_bulk_upload_error_details_for_excel_file.xlsx';
            @unlink($file_name_with_path);
            create_excel_file($file_name_with_path, $errorExcelArr, 'Exam Upload Data');
            $this->session->set_flashdata('flash_message_error', "Some rows are not uploaded,due to invalid data.");
            redirect(base_url() . 'index.php?school_admin/routes_bulk_upload_error', 'refresh');
        }
    }
//    $page_data['charges']=$charges;
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['transports'] = $this->Transport_model->get_data_by_cols('*', array(), 'result_array', array('transport_id' => 'desc'));
    foreach ($page_data['transports'] as $k => $v) {
        $page_data['transports'][$k]['transaction'] = $this->Crud_model->getTransportTransaction($v['transport_id']);
    }
    $page_data['page_name'] = 'transport';
    $page_data['page_title'] = get_phrase('manage_transport');
    $this->load->view('backend/index', $page_data);
}

/* * ********MANAGE DORMITORY / HOSTELS / ROOMS ******************* */

function dormitory($param1 = '', $param2 = '', $param3 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $page_data = $this->get_page_data_var();
    $hostel_details = $this->Dormitory_model->get_data_by_cols('*', array(), 'result_array');
    $warden_id_arr = array();
    foreach ($hostel_details as $key => $value) {
        $warden_ids = explode(',', $value['warden_id']);
        $warden_id_arr[$value['dormitory_id']]['warden'] = array();
        $warden_id_arr[$value['dormitory_id']]['id'] = $value['dormitory_id'];
        $warden_id_arr[$value['dormitory_id']]['name'] = $value['name'];
        $warden_id_arr[$value['dormitory_id']]['phone'] = $value['phone_number'];
        $warden_id_arr[$value['dormitory_id']]['type'] = $value['hostel_type'];
        $warden_id_arr[$value['dormitory_id']]['address'] = $value['hostel_address'];
        foreach ($warden_ids as $ward_key => $warden_id) {

            $name = $this->Hostel_warden_model->get_data_by_cols('name,warden_id', array('warden_id' => $warden_id), 'result_arr');
            $warden_id_arr[$value['dormitory_id']]['warden'][] = $name[0]['name'];
        }
        $dormitory_id = $value['dormitory_id'];
        $this->load->model('Hostel_room_model');
        $occupied = $this->Hostel_room_model->get_occupied_beds($dormitory_id);
        $occupied_beds[]['occupied_beds'] = $occupied[0]['occupied'];
        $available = $this->Hostel_room_model->get_available_beds($dormitory_id);
        $available_beds[]['available_beds'] = $available[0]['available'];
        $no_of_room = $this->Hostel_room_model->get_no_of_rooms($dormitory_id);
        $no_of_rooms[]['no_of_rooms'] = $no_of_room[0]['no_of_rooms'];
    }
    $i = 0;
    $new = array();
    foreach ($warden_id_arr as $value) {
        $new[$i] = array_merge($value, $occupied_beds[$i], $available_beds[$i], $no_of_rooms[$i]);
        $i++;
    }
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['details'] = $new;
    $page_data['page_name'] = 'dormitory';
    $page_data['page_title'] = get_phrase('manage_dormitory');
    $this->load->view('backend/index', $page_data);
}

/* * *MANAGE EVENT / NOTICEBOARD, WILL BE SEEN BY ALL ACCOUNTS DASHBOARD* */

function noticeboard($param1 = '', $param2 = '', $param3 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model("Notification_model");
    $page_data = $this->get_page_data_var();
    if ($param1 == 'create') {
        $this->form_validation->set_rules('notice_title', 'Notice Title', 'required');
        $this->form_validation->set_rules('notice', 'Description', 'required');
        if ($this->form_validation->run() == TRUE) {
            $data['notice_title'] = $this->input->post('notice_title');
            $data['notice'] = $this->input->post('notice');
            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
            $data['sender_type'] = 'Admin';
            $data['sender_id'] = $this->session->userdata('school_admin_id');
            $class_id = $this->input->post('class_id');
            if ($class_id == ' ') {
                $date = $this->input->post('create_timestamp');
                $data['class_id'] = '0';
                $classId = 'all';
                $running_year = $this->globalSettingsRunningYear;
                $student_details = $this->Student_model->getallstudents($classId, $running_year);
                foreach ($student_details as $row):
                    $ReceiverPhone = $row['cell_phone'];
                    $ReceiverEmail = $row['email'];
                    $msg = $data['notice_title'] . " ";
                    $msg .= get_phrase('on') . ' ' . $date;
                    $message = array();
                    $message_body = $msg . "<br><br>" . $data['notice'];
                    $message['sms_message'] = $msg;
                    $message['subject'] = $this->globalSettingsSystemName . " Notice.";
                    $message['messagge_body'] = $message_body;
                    $create_notif_queue = $this->Notification_model->create_notification_queue('event_notice', $message);
                    $user_details['user_type'] = array('parent');
                    send_school_notification('event_notice', $message, $ReceiverPhone, $ReceiverEmail, $user_details);
                endforeach;
            } else {
                $date = $this->input->post('create_timestamp');
                $data['class_id'] = $class_id;
                $running_year = $this->globalSettingsRunningYear;
                $student_details = $this->Student_model->getallstudents($class_id, $running_year);
                foreach ($student_details as $row):
                    $ReceiverPhone = $row['cell_phone'];
                    $ReceiverEmail = $row['email'];
                    $msg = $data['notice_title'] . " ";
                    $msg .= get_phrase('on') . ' ' . $date;
                    $message = array();
                    $message_body = $msg . "<br><br>" . $data['notice'];
                    $message['sms_message'] = $msg;
                    $message['subject'] = $this->globalSettingsSystemName . " Notice.";
                    $message['messagge_body'] = $message_body;
                    $create_notif_queue = $this->Notification_model->create_notification_queue('event_notice', $message);
                    $user_details = array('user_id' => $row['parent_id'], 'user_type' => 'parent');
                    send_school_notification('event_notice', $message, $ReceiverPhone, $ReceiverEmail, $user_details);
                endforeach;
            }
            $this->Notice_board_model->add($data);
            $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?school_admin/noticeboard/', 'refresh');
        } else {
            $page_data['page_name'] = 'noticeboard';
            $page_data['page_title'] = get_phrase('manage_noticeboard');
            $page_data['notices'] = $this->Notification_model->getNotices();
            $this->load->view('backend/index', $page_data);
        }
    }
    if ($param1 == 'do_update') {
        $this->form_validation->set_rules('notice_title', 'Notice Title', 'required');
        $this->form_validation->set_rules('notice', 'Notice', 'required');
        if ($this->form_validation->run() == TRUE) {
            $data['notice_title'] = $this->input->post('notice_title');
            $data['notice'] = $this->input->post('notice');
            $class_id = $this->input->post('class_id');
            if ($class_id == '') {
                $data['class_id'] = '0';
            } else {
                $data['class_id'] = $class_id;
            }
            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));

            $this->Notice_board_model->update($param2, $data);


            $msg = $data['notice_title'] . " on " . $this->input->post('create_timestamp');
            $msg .= get_phrase('on') . ' ' . $this->input->post('create_timestamp');

            $message = array();
            $message_body = $msg . "<br><br>" . $data['notice'];
            $message['sms_message'] = $msg;
            $message['subject'] = $this->globalSettingsSystemName . " Notice.";
            $message['messagge_body'] = $message_body;

            $this->load->model("Notification_model");
            $create_notif_queue = $this->Notification_model->create_notification_queue('event_notice', $message);
            $user_details['user_type'] = array('teacher', 'parent', 'student');
            send_school_notification('event_notice', $message, '', '', $user_details);

            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
            redirect(base_url() . 'index.php?school_admin/noticeboard/', 'refresh');
        }
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->Notice_board_model->get_data_by_cols('*', array(
            'notice_id' => $param2
                ), 'result_type');
    }
    if ($param1 == 'delete') {
        $this->Notice_board_model->delete($param2);
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?school_admin/noticeboard/', 'refresh');
    }
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    if ($param1 == '') {
        $page_data['page_name'] = 'noticeboard';
        $page_data['page_title'] = get_phrase('manage_noticeboard');
        $page_data['notices'] = $this->Notification_model->getNotices();
        $class_array = $this->Class_model->get_class_array();
        $page_data['classes'] = $class_array;
        $this->load->view('backend/index', $page_data);
    }
}

/* private messaging */

function message($param1 = 'message_home', $param2 = '', $param3 = '') {
    $this->load->model('Admin_model');
    $this->load->model('School_Admin_model');
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Message_model');
    $this->load->model("Message_thread_model");
    $this->load->model("Parent_model");
    $page_data = $this->get_page_data_var();

    $school_id = '';
    if(($this->session->userdata('school_id'))) {
        $school_id = $this->session->userdata('school_id');
    }

    if ($param1 == 'send_new') {
        $message_thread_code = $this->crud_model->send_new_private_message_admin();
        //$this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
        redirect(base_url() . 'index.php?school_admin/message/message_read/' . $message_thread_code, 'refresh');
    }

    if ($param1 == 'send_reply') {
        $this->crud_model->send_reply_message($param2);
        //$this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
        redirect(base_url() . 'index.php?school_admin/message/message_read/' . $param2, 'refresh');
    }

    if ($param1 == 'message_read') {
        $page_data['current_message_thread_code'] = $param2;
        $this->crud_model->mark_thread_messages_read($param2, $school_id);
        $page_data['messages'] = $this->Message_model->get_data_by_cols('*', array('message_thread_code' => $param2, 'message_status' => 'All', 'school_id' => $school_id), 'result_array');
        //echo $this->db->last_query();die;
        $parent = array();
        $parent_all = array();
        $i = 0;
        $NewArray = array();
        $img_user = array();
        $sender_account_type ='';
        foreach ($page_data['messages'] as $message) {
            $sender = explode('-', $message['sender']);
            $sender_account_type = $sender[0];
            $sender_id = $sender[1];
//            $img_user[]['image'] = $this->crud_model->get_image_url($sender_account_type, $sender_id);

            $model_name = ucfirst($sender_account_type . '_model');
            if ($sender_account_type == 'parent') {
                $parent = $this->Parent_model->get_data_by_cols('father_name,parent_image', array($sender_account_type . '_id' => $sender_id), 'result_array');
                if (!empty($parent)) {
                    $parent_all[]['name'] = $parent[0]['father_name'];

                    if($parent[0]["parent_image"]!=''){
                        $image[]['image'] = "parent_image/" . $parent[0]["parent_image"];
                    }else{
                        $image[]['image'] = "user.png";
                    }
                } else {
                    $parent_all[]['name'] = "";
                    $image[]['image'] = "user.png";
                }
            } else {
                $this->load->model('Teacher_model');
                $this->load->model('Admin_model');
                $this->load->model('Student_model');
                //echo $model_name;
                if ($model_name == "Teacher_model") {
                    $parent = $this->$model_name->get_data_by_cols("name,teacher_image", array($sender_account_type . '_id' => $sender_id), 'result_array');
                    if (!empty($parent)) {
                        $parent_all[]['name'] = $parent[0]['name'];
                        if($parent[0]["teacher_image"]!=''){
                            $image[]['image'] = "teacher_image/" . $parent[0]["teacher_image"];
                        }else{
                            $image[]['image'] = "user.png";
                        }
                    } else {
                        $parent_all[]['name'] = "";
                        $image[]['image'] = "user.png";
                    }
                } else if ($model_name == "Student_model") {
                    $parent = $this->$model_name->get_data_by_cols("name,stud_image", array($sender_account_type . '_id' => $sender_id), 'result_array');
                    if (!empty($parent)) {
                        $parent_all[]['name'] = $parent[0]['name'];

                        if($parent[0]["stud_image"]!=''){
                            $image[]['image'] = "student_image/" . $parent[0]["stud_image"];
                        }else{
                            $image[]['image'] = "user.png";     
                        }
                    } else {
                        $parent_all[]['name'] = "";
                        $image[]['image'] = "user.png";
                    }
                } else {
                    //$parent = $this->$model_name->get_data_by_cols("name,image", array($sender_account_type . '_id' => $sender_id), 'result_array');
                    $parent = $this->School_Admin_model->get_data_by_cols("name,profile_pic", array($sender_account_type . '_id' => $sender_id), 'result_array');

                    if (!empty($parent)) {
                        $parent_all[]['name'] = $parent[0]['name'];
                        
                        if($parent[0]["profile_pic"]!=''){
                            $image[]['image'] = "sc_admin_images/" . $parent[0]["profile_pic"];
                        }else{
                            $image[]['image'] = "user.png";    
                        }
                    } else {
                        $parent_all[]['name'] = "";
                        $image[]['image'] = "user.png";
                    }
                }
            }

            $NewArray[$i] = array_merge($message, $parent_all[$i], $image[$i]);
            $i++;
        }
        $page_data['message'] = $NewArray;
        //pre($page_data['messages']);die;
        $page_data['user_image'] = $sender_account_type;
    }

    if ($param1 == 'message_new') {

        $all_participent['teacher'] = $this->Teacher_model->get_data_by_cols('*', array('isActive' => '1', 'teacher_status' => '1', 'school_id' => $school_id), 'result_array', array('name' => 'asc'));

        $all_participent['student'] = $this->Student_model->get_data_by_cols('*', array('isActive' => '1', 'student_status' => '1', 'school_id' => $school_id), 'result_array', array('name' => 'asc'));

        $all_participent['parent'] = $this->Parent_model->get_data_by_cols('*', array('isActive' => '1', 'parent_status' => '1', 'school_id' => $school_id), 'result_array', array('father_name' => 'asc'));
        $page_data['all_participent'] = $all_participent;
    }

    if ($param1 == 'delete') {
        $this->load->model('Message_model');
        $admin_deleted = "admin_deleted";
        $delete_message = $this->Message_model->delete_msg_thread($param2, $admin_deleted);
        $thread_code = $this->Message_model->get_data_by_cols("*", array('message_id' => $param2), "res_arr");
        if (!empty($thread_code)) {
            $thread_code = $thread_code[0]['message_thread_code'];
        } else {
            $thread_code = "";
        }
        if ($delete_message) {
            //$this->session->set_flashdata('flash_message', get_phrase('message_deleted!'));
            redirect(base_url() . 'index.php?school_admin/message/message_read/' . $thread_code, 'refresh');
        } else {
            //$this->session->set_flashdata('flash_message_error', get_phrase('could_not_delete!'));
            redirect(base_url() . 'index.php?school_admin/message/message_read/' . $thread_code, 'refresh');
        }
    }
    $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
    $this->db->where('sender', $current_user);
    $this->db->or_where('reciever', $current_user);
    $data_array = array('sender' => $current_user, 'reciever' => $current_user, 'condition_type' => 'or');

    $page_data['message_threads'] = $this->Message_thread_model->get_data_by_cols("*", $data_array, "res_arr", array('message_thread_id' => 'desc'));
    foreach ($page_data['message_threads'] as $k => $v) {
        if ($v['sender'] == $current_user) {
            $user_to_show = explode('-', $v['reciever']);
        }
        if ($v['reciever'] == $current_user) {
            $user_to_show = explode('-', $v['sender']);
        }
        if (!empty($user_to_show[0])) {
            $user_to_show_type = $user_to_show[0];
        } else {
            $user_to_show_type = "";
        }
        if (!empty($user_to_show[1])) {
            $user_to_show_id = $user_to_show[1];
        } else {
            $user_to_show_id = "";
        }

        $page_data['message_threads'][$k]['user_to_show_type'] = $user_to_show_type;
        $page_data['message_threads'][$k]['user_to_show_id'] = $user_to_show_id;

        if ($user_to_show_type == "student") {
            $page_data['message_threads'][$k]['unread_message_number_student'] = $this->crud_model->count_unread_message_of_thread($v['message_thread_code'], $school_id);
            $page_data['message_threads'][$k]['nameDataArr_student'] = $this->crud_model->get_user($user_to_show_type, array($user_to_show_type . '_id' => $user_to_show_id)); //$this->db->get_where($user_to_show_type, array($user_to_show_type . '_id' => $user_to_show_id))->row();
        }
        if ($user_to_show_type == "teacher") {
            $page_data['message_threads'][$k]['unread_message_number_teacher'] = $this->crud_model->count_unread_message_of_thread($v['message_thread_code'], $school_id);
            $page_data['message_threads'][$k]['nameDataArr_teacher'] = $this->crud_model->get_user($user_to_show_type, array($user_to_show_type . '_id' => $user_to_show_id)); //$this->db->get_where($user_to_show_type, array($user_to_show_type . '_id' => $user_to_show_id))->row();
        }
        if ($user_to_show_type == "parent") {
            $page_data['message_threads'][$k]['unread_message_number_parent'] = $this->crud_model->count_unread_message_of_thread($v['message_thread_code'], $school_id);
            $page_data['message_threads'][$k]['nameDataArr_parent'] = $this->crud_model->get_user($user_to_show_type, array($user_to_show_type . '_id' => $user_to_show_id)); //$this->db->get_where($user_to_show_type, array($user_to_show_type . '_id' => $user_to_show_id))->row();
        }
    }

    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['message_inner_page_name'] = $param1;
    $page_data['page_name'] = 'message';
    $page_data['page_title'] = get_phrase('Message_board');

    $page_data['current_thread'] = $param2;

    if(($param1=='message_read') && ($param2!='') && ($param3=='ajax')){
        $this->load->view('backend/school_admin/message_ajax', $page_data);
    }else{
        $this->load->view('backend/index', $page_data);
    }
}

/* * ***SITE/SYSTEM SETTINGS******** */

function system_settings($param1 = '', $param2 = '', $param3 = '') {
    $this->load->helper('functions');
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url() . 'index.php?login', 'refresh');
    $page_data = $this->get_page_data_var();

    if ($param1 == 'do_update') {
        $data['description'] = $this->input->post('system_name');
        $this->Setting_model->update('system_name', $data);

        $data['description'] = $this->input->post('system_title');
        $this->Setting_model->update('system_title', $data);

        $data['description'] = $this->input->post('address');
        $this->Setting_model->update('address', $data);

        $data['description'] = $this->input->post('phone');
        $this->Setting_model->update('phone', $data);

        $data['description'] = $this->input->post('paypal_email');
        $this->Setting_model->update('paypal_email', $data);

        $data['description'] = $this->input->post('currency');
        $this->Setting_model->update('currency', $data);

        $data['description'] = $this->input->post('system_email');
        $this->Setting_model->update('system_email', $data);

        $data['description'] = $this->input->post('system_name');
        $this->Setting_model->update('system_name', $data);

        $data['description'] = $this->input->post('language');
        $this->Setting_model->update('language', $data);

        $data['description'] = $this->input->post('location');
        $this->Setting_model->update('location', $data);

        $data['description'] = $this->input->post('text_align');
        $this->Setting_model->update('text_align', $data);

        $data['description'] = $this->input->post('running_year');
        $this->Setting_model->update('running_year', $data);

        $data['description'] = $this->input->post('startfrom');
        $this->Setting_model->update('startfrom', $data);

        $data['description'] = $this->input->post('startto');
        $this->Setting_model->update('startto', $data);

        $data['description'] = $this->input->post('endfrom');
        $this->Setting_model->update('endfrom', $data);

        $data['description'] = $this->input->post('endto');
        $this->Setting_model->update('endto', $data);

        $data['description'] = $this->input->post('facebook_page');
        $this->Setting_model->update('facebook_page', $data);

        $data['description'] = $this->input->post('linkedin_page');
        $this->Setting_model->update('linkedin', $data);

        $data['description'] = $this->input->post('twitter_page');
        $this->Setting_model->update('twitter_page', $data);

        $data['description'] = $this->input->post('pinterest');
        $this->Setting_model->update('pinterest', $data);

        $data['description'] = $this->input->post('google_drive_mail_address');
        $this->Setting_model->update('google_drive_mail_id', $data);

        $data['description'] = $this->input->post('minimum_attendance');
        $this->Setting_model->update('minimum_attendance', $data);

        $data['description'] = $this->input->post('enroll_code_prefix');
        $this->Setting_model->update('enroll_code_prefix', $data);

        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?school_admin/system_settings/', 'refresh');
    }

    if ($param1 == 'upload_logo') {
        $uploads_dir = 'uploads';
        $tmp_name = $_FILES["logo_image"]["tmp_name"];
        $name = $_FILES["logo_image"]["name"];

        $ext = explode(".", $name);
        // $image = 'logo' . "." . "png";   //echo $image; exit;      
        $image = 'logo_' . time() . "." . end($ext);
        move_uploaded_file($tmp_name, "$uploads_dir/$image");
        $ldata['description'] = $image;
        $this->Setting_model->update('system_logo', $ldata);
        $this->session->set_flashdata('flash_message', get_phrase('logo_updated'));
        redirect(base_url() . 'index.php?school_admin/system_settings', 'refresh');
    }

    if ($param1 == 'change_skin') {
        $data['description'] = $param2;
        $this->Setting_model->update('skin_colour', $data);

        $this->session->set_flashdata('flash_message', get_phrase('theme_selected'));
        redirect(base_url() . 'index.php?school_admin/system_settings/', 'refresh');
    }

    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_name'] = 'system_settings';
    $page_data['page_title'] = get_phrase('system_settings');
    $page_data['settings'] = $this->Setting_model->get_data_by_cols('*', array(), 'result_array');
    $page_data['fields'] = $this->Setting_model->list_language();
    $page_data['text_align'] = $this->globalSettingsTextAlign;
    $this->load->view('backend/index', $page_data);
}

function get_session_changer() {
    $page_data = $this->get_page_data_var();
    $page_data['running_year'] = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
    $this->load->view('backend/school_admin/change_session', $page_data);
}

function change_session() {
    $page_data = $this->get_page_data_var();
    $page_data['running_year'] = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');

    $data['description'] = $this->input->post('running_year');
    $this->Setting_model->update('running_year', $data);

    $this->session->set_flashdata('flash_message', get_phrase('session_changed'));
    redirect(base_url() . 'index.php?school_admin/dashboard/', 'refresh');
}

/* * *** UPDATE PRODUCT **** */

function update($task = '', $purchase_code = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    // Create update directory.
    $dir = 'update';
    if (!is_dir($dir))
        mkdir($dir, 0777, true);

    $zipped_file_name = $_FILES["file_name"]["name"];
    $path = 'update/' . $zipped_file_name;

    move_uploaded_file($_FILES["file_name"]["tmp_name"], $path);

    // Unzip uploaded update file and remove zip file.
    $zip = new ZipArchive;
    $res = $zip->open($path);
    if ($res === TRUE) {
        $zip->extractTo('update');
        $zip->close();
        unlink($path);
    }

    $unzipped_file_name = substr($zipped_file_name, 0, -4);
    $str = file_get_contents('./update/' . $unzipped_file_name . '/update_config.json');
    $json = json_decode($str, true);



    // Run php modifications
    require './update/' . $unzipped_file_name . '/update_script.php';

    // Create new directories.
    if (!empty($json['directory'])) {
        foreach ($json['directory'] as $directory) {
            if (!is_dir($directory['name']))
                mkdir($directory['name'], 0777, true);
        }
    }

    // Create/Replace new files.
    if (!empty($json['files'])) {
        foreach ($json['files'] as $file)
            copy($file['root_directory'], $file['update_directory']);
    }

    $this->session->set_flashdata('flash_message', get_phrase('product_updated_successfully'));
    redirect(base_url() . 'index.php?school_admin/system_settings');
}

/* * ***SMS SETTINGS******** */

function sms_settings($param1 = '', $param2 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url() . 'index.php?login', 'refresh');
    $page_data = $this->get_page_data_var();
    if ($param1 == 'clickatell') {

        $data['description'] = $this->input->post('clickatell_user');
        $this->Setting_model->update('clickatell_user', $data);


        $data['description'] = $this->input->post('clickatell_password');
        $this->Setting_model->update('clickatell_password', $data);


        $data['description'] = $this->input->post('clickatell_api_id');
        $this->Setting_model->update('clickatell_api_id', $data);


        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?school_admin/sms_settings/', 'refresh');
    }

    if ($param1 == 'twilio') {

        $data['description'] = $this->input->post('twilio_account_sid');
        $this->Setting_model->update('twilio_account_sid', $data);


        $data['description'] = $this->input->post('twilio_auth_token');
        $this->Setting_model->update('twilio_auth_token', $data);

        $data['description'] = $this->input->post('twilio_sender_phone_number');
        $this->Setting_model->update('twilio_sender_phone_number', $data);

        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?school_admin/sms_settings/', 'refresh');
    }

    if ($param1 == 'active_service') {

        $data['description'] = $this->input->post('active_sms_service');
        $this->Setting_model->update('active_sms_service', $data);


        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?school_admin/sms_settings/', 'refresh');
    }

    $page_data['active_sms_service'] = $this->Setting_model->get_setting_record(array('type' => 'active_sms_service'), 'description');
    $page_data['clickatell_user_name'] = $this->Setting_model->get_setting_record(array('type' => 'clickatell_user'), 'description');
    $page_data['clickatell_user_pwd'] = $this->Setting_model->get_setting_record(array('type' => 'clickatell_password'), 'description');
    $page_data['clickatell_api_id'] = $this->Setting_model->get_setting_record(array('type' => 'clickatell_api_id'), 'description');

    $page_data['twilio_account_sid'] = $this->Setting_model->get_setting_record(array('type' => 'twilio_account_sid'), 'description');
    $page_data['twilio_auth_token'] = $this->Setting_model->get_setting_record(array('type' => 'twilio_auth_token'), 'description');
    $page_data['twilio_sender_phone_number'] = $this->Setting_model->get_setting_record(array('type' => 'twilio_sender_phone_number'), 'description');

    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_name'] = 'sms_settings';
    $page_data['page_title'] = get_phrase('sms_settings');
    $page_data['settings'] = $this->Setting_model->get_data_by_cols('*', array(), 'result_type');
    $this->load->view('backend/index', $page_data);
}

/* * ***LANGUAGE SETTINGS******** */

function manage_language($param1 = '', $param2 = '', $param3 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url() . 'index.php?login', 'refresh');
    $this->load->model("Language_model");
    $page_data = $this->get_page_data_var();
    if ($param1 == 'edit_phrase') {
        $page_data['edit_profile'] = $param2;

        $page_data['language_phrases'] = $this->Language_model->get_data_by_cols("phrase_id, phrase, " . $page_data['edit_profile'], array(), "result_arr");
    }

    if ($param1 == 'update_phrase') {
        $language = $param2;
        $total_phrase = $this->input->post('total_phrase');
        $phrases = $this->input->post('phrase');
        $ids = $this->input->post('id');
        //pre($total_phrase);
        //pre($this->input->post());
        for ($i = 0; $i < $total_phrase - 1; $i++) {
            // $data[$language]  =   $this->input->post('phrase').$i;
            $where_array = array("phrase_id" => $ids[$i]);
            $phrase_array = array($language => $phrases[$i]);
            $this->Language_model->update_phrase($where_array, $phrase_array);
        }
        //exit;
        $this->session->set_flashdata('flash_message', get_phrase('phrases_updated'));
        redirect(base_url() . 'index.php?school_admin/manage_language/edit_phrase/' . $language, 'refresh');
    }
    if ($param1 == 'do_update') {
        $language = $this->input->post('language');
        $data[$language] = $this->input->post('phrase');
        $where_array = array("phrase_id" => $param2);
        $this->Language_model->update_phrase($where_array, $data);


        $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
        redirect(base_url() . 'index.php?school_admin/manage_language/', 'refresh');
    }
    if ($param1 == 'add_phrase') {
        $data['phrase'] = $this->input->post('phrase');
        $this->Language_model->add_phrase($data);
        $this->session->set_flashdata('flash_message', get_phrase('phrase_added'));
        redirect(base_url() . 'index.php?school_admin/manage_language/', 'refresh');
    }
    if ($param1 == 'add_language') {
        $language = $this->input->post('language');
        $this->load->dbforge();
        $fields = array(
            $language => array(
                'type' => 'LONGTEXT'
            )
        );
        $this->Language_model->add_field($fields);
        $this->session->set_flashdata('flash_message', get_phrase('language_added'));
        redirect(base_url() . 'index.php?school_admin/manage_language/', 'refresh');
    }
    if ($param1 == 'delete_language') {
        $language = $param2;
        $this->load->dbforge();
        $this->Language_model->drop_field($language);
        $this->session->set_flashdata('flash_message', get_phrase('language_deleted'));
        redirect(base_url() . 'index.php?school_admin/manage_language/', 'refresh');
    }
    $page_data['fields'] = $this->Language_model->get_fields('language');
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_name'] = 'manage_language';
    $page_data['page_title'] = get_phrase('manage_language');
    $this->load->view('backend/index', $page_data);
}

/* * ***BULK UPLOAD DATABASE********* */

function bulk_upload($param1 = '', $param2 = '', $param3 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    //$page_data['parents'] = $this->Parent_model->get_data_generic_fun("*", array(),"res_array");//$this->db->get('parent')->result_array();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_info'] = 'Bulk data upload';
    $page_data['page_name'] = 'bulk_upload';
    $page_data['page_title'] = get_phrase('bulk_data_upload');
    $this->load->view('backend/index', $page_data);
}

/* * ***BACKUP / RESTORE / DELETE DATA PAGE********* */

function backup_restore($operation = '', $type = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    if ($operation == 'create') {

        $query = $this->crud_model->create_backup();
    }
    if ($operation == 'restore') {
        $this->crud_model->restore_backup();
        $this->session->set_flashdata('backup_message', 'Backup Restored');
        redirect(base_url() . 'index.php?school_admin/backup_restore/', 'refresh');
    }
    if ($operation == 'delete') {
        $this->crud_model->truncate($type);
        $this->session->set_flashdata('backup_message', 'Data removed');
        redirect(base_url() . 'index.php?school_admin/backup_restore/', 'refresh');
    }

    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_info'] = 'Create backup / restore from backup';
    $page_data['page_name'] = 'backup';
    $page_data['page_title'] = get_phrase('manage_backup_restore');
    $this->load->view('backend/index', $page_data);
}

/* * ****MANAGE OWN PROFILE AND CHANGE PASSWORD** */

function manage_profile($param1 = '', $param2 = '', $param3 = '') {
    $this->load->model('Admin_model');
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url() . 'index.php?login', 'refresh');
    $page_data = $this->get_page_data_var();
    if ($param1 == 'update_profile_info') {
        $data['name'] = $this->input->post('name');
        $data['email'] = $this->input->post('email');
        $file_name = $_FILES['userfile']['name'];

        $types = array('image/jpeg', 'image/gif', 'image/png');
        if ($file_name != '') {

            if (in_array($_FILES['userfile']['type'], $types)) {

                $ext = explode(".", $file_name);
                $user_id = $this->session->userdata('school_admin_id');
                $data['profile_pic'] = $user_id . "." . end($ext);
                if ($this->School_Admin_model->update_profile($data, $user_id)) {
                    move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/sc_admin_images/' . $data['profile_pic']);
                    $this->session->set_flashdata('flash_message', get_phrase('account_details_updated'));
                }
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('It may be the wrong filetype. We only allow JPG, GIF, and PNG filetypes!!'));
                redirect(base_url() . 'index.php?school_admin/manage_profile/', 'refresh');
            }
        } else {
            $data['profile_pic'] = $this->input->post('image');
            $user_id = $this->session->userdata('school_admin_id');
            $this->School_Admin_model->update_profile($data, $user_id);
            redirect(base_url() . 'index.php?school_admin/manage_profile/', 'refresh');
        }
    }

    if ($param1 == 'change_password') {
        $data['password'] = sha1($this->input->post('password'));
        $data['new_password'] = sha1($this->input->post('new_password'));
        $data['confirm_new_password'] = sha1($this->input->post('confirm_new_password'));
        $current_password = $this->School_Admin_model->get_data_by_cols('password', array('school_admin_id' => $this->session->userdata('school_admin_id')), 'result_array');
        $curr_pwsd = $current_password[0]['password'];

        if ($curr_pwsd == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {
            $dataArray = array('password' => $data['new_password'], 'original_pass' => 'sad' . $this->input->post('new_password'));
            $this->School_Admin_model->updateadmin_password($dataArray, $this->session->userdata('school_admin_id'));
            $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('password_mismatch'));
        }
        redirect(base_url() . 'index.php?school_admin/manage_profile/', 'refresh');
    }

    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_name'] = 'manage_profile';
    $page_data['page_title'] = get_phrase('manage_profile');

    $this->load->model('School_Admin_model');
    $page_data['edit_data'] = $this->School_Admin_model->get_data_by_cols('*', array('school_admin_id' => $this->session->userdata('school_admin_id')), 'result_array');
    $this->load->view('backend/index', $page_data);
}

/* * ***Display Device PAGE********* */

function manage_device() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $admin_id = $this->session->userdata('school_admin_id');

    $page_data = $this->get_page_data_var();
    $this->Setting_model->update_device($admin_id);

    $this->load->model("Device_model");



    $page_data['devices'] = $this->Device_model->get_data_by_cols('*', array(), 'result_array');
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_info'] = 'View Device List';
    $page_data['page_name'] = 'manage_device';
    $page_data['page_title'] = 'Manage Devices';
    $page_data['edit_data'] = $this->Device_model->get_data_by_cols('*', array(), 'result_type');
    $this->load->view('backend/index', $page_data);
}

function device($param1 = '', $param2 = '', $param3 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $this->load->model("Device_model");
    if ($param1 == 'create') {
        $data['Name'] = $this->input->post('Name');
        $data['Imei'] = $this->input->post('Imei');
        $data['SIM'] = $this->input->post('SIM');
        $data['Location'] = $this->input->post('Location');
        $Device_id = $this->Device_model->add($data);


        $admindevice['imei'] = $this->input->post('Imei');
        $admindevice['Admin_id'] = $this->session->userdata('admin_id');

        $this->Device_model->add_admin_device($admindevice);


        $this->session->set_flashdata('flash_message', get_phrase('device_added_successfully'));
        //$this->Email_model->account_opening_email('teacher', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
        redirect(base_url() . 'index.php?school_admin/manage_device/', 'refresh');
    }
    if ($param1 == 'do_update') {
        $data['Name'] = $this->input->post('Name');
        $data['Imei'] = $this->input->post('Imei');
        $data['SIM'] = $this->input->post('SIM');
        $data['Location'] = $this->input->post('Location');
        $this->Device_model->update($param2, $data);

        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?school_admin/manage_device/', 'refresh');
    }

    if ($param1 == 'delete') {
        $this->Device_model->delete($param2);

        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?school_admin/manage_device/', 'refresh');
    }
    $page_data['device'] = $this->Device_model->get_data_by_cols('*', array(), 'result_type');
    $page_data['page_name'] = 'Device';
    $page_data['page_title'] = get_phrase('manage_devices');
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $this->load->view('backend/index', $page_data);
}

/* * ***Track buses PAGE********* */

function livetrack() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    //$admin_id=$this->session->userdata('admin_id');
    $page_data['page_info'] = 'Track buses';
    $page_data['page_name'] = 'live_track';
    $page_data['page_title'] = 'Track Buses';
    $this->load->view('backend/index', $page_data);
}

/**
 * 
 * @param type $param1
 * @param type $param2
 * fun for bus management
 */
function bus($param1 = '', $param2 = '') {

    $this->load->model('Bus_driver_modal');
    $this->load->model("Bus_model");
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $page_data = $this->get_page_data_var();
    if ($param1 == 'create') {
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('key', 'Bus Unique Key', 'trim|required|is_unique[bus.bus_unique_key]');
        $this->form_validation->set_rules('imei', 'IMEI', 'trim|required|is_unique[bus.device_imei]');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_rules('route', 'Route Id', 'trim|required');
        $this->form_validation->set_rules('no_of_seat', 'Number of Seats', 'trim|required');
        if ($this->form_validation->run() == TRUE) {

            $data['name'] = $this->input->post('name');
            $data['bus_unique_key'] = $this->input->post('key');
            $data['device_imei'] = $this->input->post('imei');
            $data['description'] = $this->input->post('description');
            $data['route_id'] = $this->input->post('route');
            $data['number_of_seat'] = $this->input->post('no_of_seat');
            //pre($data);
            //die;
            $id = $this->Bus_driver_modal->save_bus($data); //echo $id; exit;
            $count_buses = $this->Bus_model->get_data_by_cols('count(route_id) as count', array('route_id' => $data['route_id']), 'result_array');

            if (!empty($count_buses)) {
                if ($count_buses >= 1)
                    $this->Bus_driver_modal->update_no_of_buses($data['route_id'], $count_buses[0]['count']);
            }
            $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?school_admin/bus/', 'refresh');
        }else {
//            $page_data['buses'] = $this->Bus_driver_modal->get_bus_with_route1();
//            $page_data['page_title'] = get_phrase('manage_bus');
//            $page_data['page_name'] = 'bus_manage';
//            $this->load->view('backend/index', $page_data);
            $this->session->set_flashdata('flash_message_error', "Could not add because " . validation_errors());
            redirect(base_url() . 'index.php?school_admin/bus/', 'refresh');
        }
    }
    if ($param1 == 'edit') {
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('key', 'Bus Unique Key', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_rules('no_of_seats', 'Number of Seats', 'trim|required');
        $this->form_validation->set_rules('route', 'Route', 'required');
        if ($this->form_validation->run() == TRUE) {
            $data['name'] = $this->input->post('name');
            $data['bus_unique_key'] = $this->input->post('key');
            $data['description'] = $this->input->post('description');
            $data['number_of_seat'] = $this->input->post('no_of_seats');
            $data['route_id'] = $this->input->post('route');
            $this->Bus_driver_modal->update_bus($data, $param2);
            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
            redirect(base_url() . 'index.php?school_admin/bus/', 'refresh');
        } else {
            $this->session->set_flashdata('flash_message_error', validation_errors());
            redirect(base_url() . 'index.php?school_admin/bus/', 'refresh');
        }
    }
    if ($param1 == 'delete') {
        $data = array('bus_id' => $param2);
        $this->Bus_driver_modal->delete_bus($data);
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?school_admin/bus/', 'refresh');
    }

    if ($param1 == 'import_excel') {
        //error_reporting(E_ALL);
        //ini_set('display_errors', 1);
        $path = "uploads/bus_details_import.xlsx";
        //@unlink('uploads/subject_import.xlsx');
        @unlink($path);
        @unlink('uploads/bus_details_bulk_upload_error_details.log');

        if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $path)) {
            die('not moving');
        }
        @ini_set('memory_limit', '-1');
        @set_time_limit(0);
        include 'Simplexlsx.class.php';
        $xlsx = new SimpleXLSX($path);
        list($num_cols, $num_rows) = $xlsx->dimension();
        $f = 0;
        $fielsdStringForAdmin = "Bus Id(Unique),Bus Name,Route Name,Description";
        $fielsdString = "bus_unique_key,name,route_id,description";
        $fielsdStringMandotary = "bus_unique_key,name,route_id,description";
        $fielsdArr = explode(',', $fielsdString);
        $fielsdStringForAdminArr = explode(',', $fielsdStringForAdmin);
        $fielsdStringMandotaryArr = explode(',', $fielsdStringMandotary);
        $someRowError = FALSE;
        $errorMsgArr = array();
        $errorExcelArr = array();
        $errorExcelArr[] = $fielsdStringForAdminArr;
        $errorRowNo = 2;
        //pre($xlsx->rows());die;
        foreach ($xlsx->rows() as $r) {
            //echo '<pre>'; //print_r($r);die;
            $data = array();
            $dataParent = array();
            $error = FALSE;
            // Ignore the inital name row of excel file
            if ($f == 0) {
                $f++;
                continue;
            } $f++;
            //pre($fielsdStringForAdminArr);
            //pre($r);
            //pre('above are $r data');
            //if ($num_cols > count($fielsdArr)) {
            $num_cols = count($fielsdArr);
            //die($num_cols);
            //}
            $blankErrorMsgArr = array();
            $errorRowIncrease = FALSE;

            //echo $num_cols;die;
            for ($i = 0; $i < $num_cols; $i++) {    // checking is filds is mandetory or not
                //echo $fielsdArr[$i] . '<br>';
                if (in_array($fielsdArr[$i], $fielsdStringMandotaryArr)) {
                    //now validating mandetory fiels
                    //generate_log("Field " . $fielsdArr[$i] . " value \n", 'bus_details_bulk_upload_' . date('d-m-Y-H') . '.log');
                    //echo $r[$i].'<br>';
                    if (trim($r[$i]) == "") {
                        //echo "here"; //die();
                        $error = TRUE;
                        $blankErrorMsgArr[] = $fielsdStringForAdminArr[$i] . " should not be blank at row no " . $errorRowNo;
                    } else {
                        //pre($i);
                    }

                    if ($fielsdArr[$i] == 'bus_unique_key') {
                        $rsClass = $this->Bus_model->get_bus_name($r[$i]);

                        if (count($rsClass) == 0) {
                            $data['bus_unique_key'] = trim($r[$i]);
                        } else {
                            $data['bus_unique_key'] = "";
                            $error = TRUE;
                            $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " content invalid data at row no -" . $errorRowNo . ' is already exist.';
                        }
                    }

                    if ($fielsdArr[$i] == 'route_id') {
                        $transportArr = $this->Transport_model->get_name($r[$i]);

                        if (!empty($transportArr)) {
                            $data[$fielsdArr[$i]] = $transportArr[0]->transport_id;
                        } else {
                            //pre($data);die();
                            $error = TRUE;
                            $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " content invalid data at row no -" . $errorRowNo;
                        }
                    }

                    if ($fielsdArr[$i] == 'name' || $fielsdArr[$i] == 'description') {
                        $data[$fielsdArr[$i]] = trim($r[$i]);
                    }
                    if (!empty($errorMsgArr)) {
                        //pre($errorMsgArr);die;
                    }
                    //pre(trim($fielsdArr[$i]));pre('$error');pre($error);
                } else {
                    //pre($errorMsgArr);//die;
                    //pre(trim($fielsdArr[$i]));pre('$error');pre($error);
                }
            }
            //die;
            if (count($blankErrorMsgArr) > 0) {
                $error = TRUE;
                if (count($blankErrorMsgArr) <= count($fielsdArr)) {
                    if (count($blankErrorMsgArr) == count($fielsdArr)) {
                        ///
                    } else {
                        foreach ($blankErrorMsgArr AS $errorKey => $errorVal) {
                            $errorMsgArr[] = $errorVal;
                        }
                    }
                }
            }
            //pre($data); //die('//hii');
            //pre('$error');pre($error); //die();
            if ($error === FALSE) {
                //pre("comking for data insert");
                //$data['status']=1;
                //pre($data);die;
                $bus_details_id = $this->Bus_driver_modal->save_bus($data);
            } else {
                //pre($errorMsgArr);//die;
                $errorRowNo++;
                $errorExcelArr[] = $r;
                $someRowError = TRUE;
            }
        } //ends foreach
        //pre($errorMsgArr); exit;

        if ($someRowError == FALSE) {
            //$this->generate_cv$error_msg);
            generate_log("No error for this upload at - " . time(), 'bus_details_bulk_upload' . date('d-m-Y-H') . '.log');
            $this->session->set_flashdata('flash_message', get_phrase('bus_details_details_added'));
            redirect(base_url() . 'index.php?school_admin/bulk_upload/', 'refresh');
        } else {
            //pre($errorMsgArr); die('here');
            generate_log(json_encode($errorMsgArr), 'bus_details_bulk_upload_error_details.log', TRUE);
            $file_name_with_path = 'uploads/bus_details_bulk_upload_error_details_for_excel_file.xlsx';
            @unlink($file_name_with_path);
            create_excel_file($file_name_with_path, $errorExcelArr, 'Exam Upload Data');
            $this->session->set_flashdata('flash_message_error', "Some rows are not uploaded,due to invalid data.");
            redirect(base_url() . 'index.php?school_admin/bus_details_bulk_upload_error', 'refresh');
        }
    }
    if ($param1 == '') {
//        $page_data['buses'] = $this->Bus_driver_modal->get_bus_with_route1();
        //print_r($page_data['buses']);exit;
        $page_data['page_title'] = get_phrase('manage_bus');
        $page_data['page_name'] = 'bus_manage';
        $this->load->view('backend/index', $page_data);
    }
}

function bus_admin($param1 = '', $param2 = '') {
    $this->load->model('Bus_driver_modal');
    //$this->load->model('Email_model');
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $page_data = $this->get_page_data_var();
    if ($param1 == 'create') {
        $data['name'] = $this->input->post('name');
        $data['email'] = $this->input->post('email');
        $data['password'] = sha1($this->input->post('password'));
        $data['phone'] = $this->input->post('phone');
        $data['sex'] = $this->input->post('gender');
        $this->Bus_driver_modal->save_bus_admin($data);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        //$this->Email_model->account_opening_email('parent', $data['email'], $this->input->post('password')); //SEND EMAIL ACCOUNT OPENING EMAIL
        redirect(base_url() . 'index.php?school_admin/bus_admin/', 'refresh');
    }
    if ($param1 == 'edit') {
        $data['name'] = $this->input->post('name');
        $data['email'] = $this->input->post('email');
        $data['phone'] = $this->input->post('phone');
        $data['sex'] = $this->input->post('gender');
        $this->Bus_driver_modal->update_bus_admin($data, $param2);
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?school_admin/bus_admin/', 'refresh');
    }
    if ($param1 == 'delete') {
        $data = array('bus_administrator_id' => $param2);
        $this->Bus_driver_modal->delete_bus_admin($data);
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?school_admin/bus_admin/', 'refresh');
    }
    $page_data['bus_admins'] = $this->Bus_driver_modal->get_bus_admins();
    $page_data['page_title'] = get_phrase('Bus_Administrator');
    $page_data['page_name'] = 'bus_admin';
    $this->load->view('backend/index', $page_data);
}

function bus_driver($param1 = '', $param2 = '', $param3 = '') {
    $this->load->model('Bus_driver_modal');
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['search_text'] = '';

    if ($param1 == 'create') {

        $this->form_validation->set_rules('name', 'Driver Name', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        //$this->form_validation->set_rules('password', 'Password', 'trim|required');

        $this->form_validation->set_rules('phone', 'Phone Number', 'required|trim');
        $this->form_validation->set_rules('bus_id', 'Bus', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[bus_driver.email]');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_message_error', validation_errors());
            redirect(base_url() . 'index.php?school_admin/bus_driver/');
        } else {
            $data['name'] = $this->input->post('name');
            $data['email'] = $this->input->post('email');
            //$data['password']   =   sha1($this->input->post('password'));
            $passcode = create_passcode('bus_driver');
            $data['passcode'] = ($passcode != 'invalid') ? $passcode : '';
            $data['password'] = ($passcode != 'invalid') ? sha1($passcode) : '';
            $data['phone'] = $this->input->post('phone');
            $data['sex'] = $this->input->post('gender');
            $data['bus_id'] = $this->input->post('bus_id');
            $this->Bus_driver_modal->save_bus_driver($data);

            $message = array();
            $message['messagge_body'] = "Welcome Mr " . $data['name'] . " <br>Your passcode for app is " . $passcode . "   <br>Download app here https://play.google.com/store/apps/details?id=" . $this->globalSettingsAppPackageName . "&hl=en";
            $message['subject'] = "Your login details for " . CURRENT_INSTANCE . " School";
            $message['to_name'] = $data['name'];
            send_school_notification('new_user', $message, array($data['phone']), array($data['email']));


            $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
            //$this->Email_model->account_opening_email('parent', $data['email'], $this->input->post('password')); //SEND EMAIL ACCOUNT OPENING EMAIL
            redirect(base_url() . 'index.php?school_admin/bus_driver/', 'refresh');
        }
    } else if ($param1 == 'edit') {

        $data['name'] = $this->input->post('name');
        $data['email'] = $this->input->post('email');
        $data['phone'] = $this->input->post('phone');
        $data['sex'] = $this->input->post('gender');
        $this->Bus_driver_modal->update_bus_driver($data, $param2);
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?school_admin/bus_driver/', 'refresh');
    } else if ($param1 == 'delete') {
        $data = array('bus_driver_id' => $param2);
        $this->Bus_driver_modal->delete_bus_driver($data);
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?school_admin/bus_driver/', 'refresh');
    } else if (($param1 == 'toggle_enable') && ($param3 != '')) {
        $dataArray = array('bus_driver_id' => $param2, 'bus_driver_status' => $param3);
        if ($this->Bus_driver_modal->do_toggle_enable_bus_driver($dataArray)) {
            $this->session->set_flashdata('flash_message', get_phrase(($param3 == 1) ? 'disabled_successfully' : 'enabled_successfully'));
            redirect(base_url() . 'index.php?school_admin/bus_driver/', 'refresh');
        }
    } else if ($param1 == 'import_excel') {
        $this->load->model('Bus_driver_modal');
        //pre($_FILES);die;
        if (empty($_FILES['userfile']['name'])) {
            $this->form_validation->set_rules('userfile', 'Document', 'required');
            $this->session->set_flashdata('flash_message_error', 'Please select a document to upload!!');
            redirect(base_url() . 'index.php?school_admin/bulk_upload');
        } else {
            $allowed_types = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip');
            if (in_array($_FILES['userfile']['type'], $allowed_types)) {
                $path = "uploads/bus_driver_import.xlsx";
                //@unlink('uploads/Parent_Upload_Template.xlsx');
                @unlink($path);
                @unlink('uploads/bus_driver_bulk_upload_error_details.log');

                if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $path)) {
                    die('not moving');
                }
                @ini_set('memory_limit', '-1');
                @set_time_limit(0);
                include 'Simplexlsx.class.php';
                $xlsx = new SimpleXLSX($path);
                list($num_cols, $num_rows) = $xlsx->dimension();
                $f = 0;
                $fielsdStringForAdmin = "Bus Driver Name,Gender,Mobile,Email Id,Bus Name";
                $fielsdString = "name,sex,phone,email,bus_id";
                $fielsdStringMandotary = "name,sex,phone,email,bus_id";
                $fielsdArr = explode(',', $fielsdString);
                $fielsdStringForAdminArr = explode(',', $fielsdStringForAdmin);
                $fielsdStringMandotaryArr = explode(',', $fielsdStringMandotary);
                $someRowError = FALSE;
                $errorMsgArr = array();
                $errorExcelArr = array();
                $errorExcelArr[] = $fielsdStringForAdminArr;
                $errorRowNo = 2;
                //pre($xlsx->rows());die;
                foreach ($xlsx->rows() as $r) {
                    //echo '<pre>'; //print_r($r);die;
                    $data = array();
                    $dataParent = array();
                    $error = FALSE;
                    // Ignore the inital name row of excel file
                    if ($f == 0) {
                        $f++;
                        continue;
                    } $f++;
                    //pre($r); //die('here');
                    //pre($r);pre('above are $r data');
                    if ($num_cols > count($fielsdArr)) {
                        $num_cols = count($fielsdArr);
                    }
                    $blankErrorMsgArr = array();
                    $errorRowIncrease = FALSE;
                    for ($i = 0; $i < $num_cols; $i++) {    // checking is filds is mandetory or not
                        //echo $fielsdArr[$i].'<br>';
                        if (in_array($fielsdArr[$i], $fielsdStringMandotaryArr)) {
                            //now validating mandetory fiels
                            generate_log("Field " . $fielsdArr[$i] . " value " . $r[$i] . "\n", 'bus_driver_bulk_upload_' . date('d-m-Y-H') . '.log');
                            if (trim($r[$i]) == "") {
                                //echo "here"; //die();
                                $error = TRUE;
                                $blankErrorMsgArr[] = $fielsdStringForAdminArr[$i] . " should not be blank at row no " . $errorRowNo;
                            } else {
                                //pre($i);
                                $validPhoneEmailCheck = "ok";
                                $rsEmailPhoneUnique = array();
                                // now check teh uniques for email then phone
                                if ($fielsdArr[$i] == 'email') {
                                    //echo 'Meera';die();
                                    $rsEmailPhoneUnique = $this->Bus_driver_modal->get_data_by_cols('bus_driver_id', array('email' => trim($r[$i])));
                                    $validPhoneEmailCheck = $this->checkValidPhoneEmail(trim($r[$i]), 'email');
                                } elseif ($fielsdArr[$i] == 'phono') {
                                    $rsEmailPhoneUnique = $this->Bus_driver_modal->get_data_by_cols('bus_driver_id', array('phone' => trim($r[$i])));
                                    $validPhoneEmailCheck = $this->checkValidPhoneEmail(trim($r[$i]), 'phone');
                                }

                                if (count($rsEmailPhoneUnique) > 0) {
                                    $error = TRUE;
                                    $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " is already entered.Should be unique information at row no -" . $errorRowNo;
                                    //echo '<br>';
                                }

                                if ($validPhoneEmailCheck != 'ok' && ($fielsdArr[$i] == 'email' || $fielsdArr[$i] == 'phone')) {
                                    $error = TRUE;
                                    $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " Should be " . $validPhoneEmailCheck . " at row no -" . $errorRowNo;
                                }

                                if ($fielsdArr[$i] == 'bus_id') {
                                    $this->load->model('Bus_model');
                                    $routeArr = $this->Bus_model->get_bus_name($r[$i]);
                                    if (empty($routeArr)) {
                                        $error = TRUE;
                                        $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " is not exists at row no -" . $errorRowNo;
                                    } else {
                                        $data['bus_id'] = $routeArr[0]->bus_id;
                                    }
                                }

                                if ($fielsdArr[$i] == 'name' || $fielsdArr[$i] == 'sex' || $fielsdArr[$i] == 'phone' || $fielsdArr[$i] == 'email') {
                                    $data[$fielsdArr[$i]] = trim($r[$i]);
                                }
                            }
                            //pre($errorMsgArr);//die;
                            //pre(trim($fielsdArr[$i]));pre('$error');pre($error);
                        } else {
                            /* if($fielsdArr[$i]=='date_time'){
                              $rawDOB=trim($r[$i]);
                              $newDOB=$this->get_mysql_date_formate_from_raw($rawDOB);
                              if($newDOB!=""){
                              $data[$fielsdArr[$i]]=$newDOB;
                              }else{
                              $data[$fielsdArr[$i]]=date('Y-m-d H:i:s');
                              }
                              } */
                        }
                    }
                    if (count($blankErrorMsgArr) > 0) {
                        $error = TRUE;
                        if (count($blankErrorMsgArr) <= count($fielsdArr)) {
                            foreach ($blankErrorMsgArr AS $errorKey => $errorVal) {
                                $errorMsgArr[] = $errorVal;
                            }
                        }
                    }
                    //pre($data); //die('//hii');
                    //pre('$error');pre($error); //die();
                    if ($error === FALSE) {
                        //$data['date_time']=strtotime(date("Y-m-d H:i:s")); 
                        //$data['bus_driver_id'] = $bus_driver_id;
                        $passcode = "dri" . mt_rand(10000000, 99999999);
                        $data['password'] = sha1($passcode);
                        $data['passcode'] = $passcode;
                        //$data['isActive'] = 1;
                        //pre($data);
                        //pre('kkkkkkkkkkkkk');die;
                        //pre($data);die;
                        $bus_driver_id = $this->Bus_driver_modal->save_bus_driver($data);
                        if ($bus_driver_id > 0) {
                            /* $post = [
                              'location' => $this->globalSettingsLocation,
                              'cell_phone' => $data['cell_phone'],
                              'message' => "Welcome Mr " . $data['father_name'] . " your passcode for app is " . $passcode . "   download app here https://play.google.com/store/apps/details?id=".$this->globalSettingsAppPackageName."&hl=en",
                              ];
                              //echo print_r($post);exit;
                              $url = "http://".SMS_IP_ADDR."/School/index.php/?admin/send_common_sms/";
                              fire_api_by_curl($url,$post); */
                            $message = array();
                            $activity = "new_user";
                            $message['messagge_body'] = "Welcome Mr " . $data['name'] . " your passcode for app is " . $passcode . "   download app here https://play.google.com/store/apps/details?id=" . $this->globalSettingsAppPackageName . "&hl=en";
                            $message['subject'] = "Your login details for " . CURRENT_INSTANCE . " School";
                            $message['to_name'] = $data['name'];
                            $phone = array($data['phone']);
                            $email = array($data['email']);
                            $user_details = array('user_id' => $bus_driver_id, 'user_type' => 'bus_driver');
                            send_school_notification($activity, $message, $phone, $email, $user_details);
                        }
                    } else {
                        //pre($errorMsgArr);//die;
                        $errorRowNo++;
                        $errorExcelArr[] = $r;
                        $someRowError = TRUE;
                    }
                } //ends foreach
                //pre($errorMsgArr); exit;
                if ($someRowError == FALSE) {
                    //$this->generate_cv$error_msg);
                    generate_log("No error for this upload at - " . time(), 'bus_driver_bulk_upload' . date('d-m-Y-H') . '.log');
                    $this->session->set_flashdata('flash_message', get_phrase('bus_driver_details_added'));
                    redirect(base_url() . 'index.php?school_admin/bulk_upload/', 'refresh');
                } else {
                    //pre($errorMsgArr); die('here');
                    generate_log(json_encode($errorMsgArr), 'bus_driver_bulk_upload_error_details.log', TRUE);
                    $file_name_with_path = 'uploads/bus_driver_bulk_upload_error_details_for_excel_file.xlsx';
                    @unlink($file_name_with_path);
                    create_excel_file($file_name_with_path, $errorExcelArr, 'Bus Driver Upload Data');
                    $this->session->set_flashdata('flash_message_error', "Some rows are not uploaded,due to invalid data.");
                    redirect(base_url() . 'index.php?school_admin/bus_driver_bulk_upload_error', 'refresh');
                }
            }//ends allowed type code
            else {
                $this->session->set_flashdata('flash_message_error', 'Sorry, File extension is not supported, Please enter data in Excel Spread Sheet!!');
                redirect(base_url() . 'index.php?school_admin/bulk_upload');
            }
        }
    } else if (($param1 == 'search') && ($param2 != '')) {
        $page_data['search_text'] = $param2;
    }

//    $page_data['bus_drivers'] = $this->Bus_driver_modal->get_bus_drivers();
    $page_data['page_title'] = get_phrase('Bus_Drivers');
    $page_data['page_name'] = 'bus_driver';
    $this->load->view('backend/index', $page_data);
}

function marks_bulk_upload($param = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    if ($param = 'import_excel') {
        $path = "uploads/mark_import.xlsx";
        //@unlink('uploads/subject_import.xlsx');
        @unlink($path);
        @unlink('uploads/mark_bulk_upload_error_details.log');

        if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $path)) {
            die('not moving');
        }
        @ini_set('memory_limit', '-1');
        @set_time_limit(0);
        include 'Simplexlsx.class.php';
        $xlsx = new SimpleXLSX($path);
        list($num_cols, $num_rows) = $xlsx->dimension();
        $f = 0;
        $fielsdStringForAdmin = "Class Name,Section Name,Roll No,Exam Name,Subject Name,Marks Obtained,Maximum Marks,Comment";
        $fielsdString = "class_id,section_id,roll,exam_id,subject_id,mark_obtained,mark_total,comment";
        $fielsdStringMandotary = "class_id,section_id,roll,exam_id,subject_id,mark_obtained,mark_total";
        $fielsdArr = explode(',', $fielsdString);
        $fielsdStringForAdminArr = explode(',', $fielsdStringForAdmin);
        $fielsdStringMandotaryArr = explode(',', $fielsdStringMandotary);
        $someRowError = FALSE;
        $errorMsgArr = array();
        $errorExcelArr = array();
        $errorExcelArr[] = $fielsdStringForAdminArr;
        $errorRowNo = 2;
        //pre($xlsx->rows());die;
        foreach ($xlsx->rows() as $r) {
            //echo '<pre>'; //print_r($r);die;
            $data = array();
            $dataParent = array();
            $error = FALSE;
            // Ignore the inital name row of excel file
            if ($f == 0) {
                $f++;
                continue;
            } $f++;
            //pre($fielsdStringForAdminArr);
            //pre($r); //die('here');
            //pre($r);
            //pre('above are $r data');
            //if ($num_cols > count($fielsdArr)) {
            $num_cols = count($fielsdArr);
            //die($num_cols);
            //}
            $blankErrorMsgArr = array();
            $errorRowIncrease = FALSE;

            //echo $num_cols;die;
            for ($i = 0; $i < $num_cols; $i++) {    // checking is filds is mandetory or not
                //echo $fielsdArr[$i] . '<br>';
                if (in_array($fielsdArr[$i], $fielsdStringMandotaryArr)) {
                    //now validating mandetory fiels
                    //generate_log("Field " . $fielsdArr[$i] . " value \n", 'mark_bulk_upload_' . date('d-m-Y-H') . '.log');
                    //echo $r[$i].'<br>';
                    if (trim($r[$i]) == "") {
                        //echo "here"; //die();
                        $error = TRUE;
                        $blankErrorMsgArr[] = $fielsdStringForAdminArr[$i] . " should not be blank at row no " . $errorRowNo;
                    } else {
                        //pre($i);
                    }

                    if ($fielsdArr[$i] == 'class_id') {
                        $rsClass = $this->Class_model->get_name($r[$i]);

                        if (count($rsClass) > 0) {
                            $data['class_id'] = $rsClass[0]->class_id;
                        } else {
                            $data['class_id'] = "";
                            $error = TRUE;
                            $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " content invalid data at row no -" . $errorRowNo . ' is already exist.';
                        }
                    }

                    if ($fielsdArr[$i] == 'section_id') {
                        if ($data['class_id'] != "") {
                            $rsSection = $this->Section_model->get_name($data['class_id'], $r[$i]);

                            if (count($rsSection) > 0) {
                                $data['section_id'] = $rsSection[0]->section_id;
                            } else {
                                $data['class_id'] = "";
                                $error = TRUE;
                                $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " content invalid data at row no -" . $errorRowNo . ' is already exist.';
                            }
                        } else {
                            $data['class_id'] = "";
                            $error = TRUE;
                            $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " content invalid data compare with class name at row no -" . $errorRowNo . ' is already exist.';
                        }
                    }



                    if ($fielsdArr[$i] == 'exam_id') {
                        $examArr = $this->Exam_model->get_name($r[$i]);
                        if (!empty($examArr)) {
                            $data['exam_id'] = $examArr[0]->exam_id;
                        } else {
                            $error = TRUE;
                            $errorMsgArr[] = $fielsdStringForAdminArr[$i] . " content invalid data at row no -" . $errorRowNo;
                        }
                    }

                    if ($fielsdArr[$i] != 'class_id' && $fielsdArr[$i] != 'section_id' && $fielsdArr[$i] != 'exam_id') {
                        $data[$fielsdArr[$i]] = trim($r[$i]);
                    }
                    if (!empty($errorMsgArr)) {
                        //pre($errorMsgArr);die;
                    }
                    //pre(trim($fielsdArr[$i]));pre('$error');pre($error);
                } else {
                    if ($fielsdArr[$i] == 'comment') {
                        $data['comment'] = trim($r[$i]);
                    }
                }
            }
            //die;
            //pre($data);
            if (count($blankErrorMsgArr) > 0) {
                $error = TRUE;
                if (count($blankErrorMsgArr) <= count($fielsdArr)) {
                    foreach ($blankErrorMsgArr AS $errorKey => $errorVal) {
                        $errorMsgArr[] = $errorVal;
                    }
                }
            }

            $arr = array(
                'class_id' => $data['class_id'],
                'section_id' => $data['section_id'],
                'roll' => $data['roll']
            );
            $rsStudentData = $this->Enroll_model->get_data_by_cols('*', $arr, 'result_type');
            if (!empty($rsStudentData)) {
                $data['student_id'] = $rsStudentData[0]->student_id;
                unset($data['roll']);
            } else {
                $error = TRUE;
                $errorMsgArr[] = " Roll no content invalid data at row no -" . $errorRowNo;
            }


            $subjectArr = $this->Subject_model->get_subject_name($data['subject_id'], $data['class_id'], $data['section_id']);
            if (!empty($subjectArr)) {
                $data['subject_id'] = $subjectArr[0]->subject_id;
            } else {

                $error = TRUE;
                $errorMsgArr[] = "Subject content invalid data at row no -" . $errorRowNo;
            }
            //pre($data); //die;
            //pre('$error');pre($error); //die();
            if ($error === FALSE) {
                $data['year'] = $this->globalSettingsRunningYear;
                //pre($data);die;
                $this->load->model('Mark_model');
                $mark_id = "";
                $mark_id = $this->Mark_model->add($data);
            } else {
                //pre($errorMsgArr);//die;
                $errorRowNo++;
                $errorExcelArr[] = $r;
                $someRowError = TRUE;
            }
        } //ends foreach
        //pre($errorMsgArr); exit;

        if ($someRowError == FALSE) {
            //$this->generate_cv$error_msg);
            generate_log("No error for this upload at - " . time(), 'mark_bulk_upload' . date('d-m-Y-H') . '.log');
            $this->session->set_flashdata('flash_message', get_phrase('mark_details_added'));
            redirect(base_url() . 'index.php?school_admin/bulk_upload/', 'refresh');
        } else {
            //pre($errorMsgArr); die('here');
            generate_log(json_encode($errorMsgArr), 'mark_bulk_upload_error_details.log', TRUE);
            $file_name_with_path = 'uploads/mark_bulk_upload_error_details_for_excel_file.xlsx';
            @unlink($file_name_with_path);
            create_excel_file($file_name_with_path, $errorExcelArr, 'Exam Upload Data');
            $this->session->set_flashdata('flash_message_error', "Some rows are not uploaded,due to invalid data.");
            redirect(base_url() . 'index.php?school_admin/mark_bulk_upload_error', 'refresh');
        }
    }
}

function add_employee_from_hrm() {
    generate_log("calling url through CURL");
    //generate_log(json_encode($_POST));
    //generate_log(json_encode($this->input->post()));
    $table = $this->input->post("table", TRUE);
    $dataError = array();
    $dataArr = array();
    $isError = FALSE;
    if ($table == "") {
        $dataError[] = "table name is required";
        $isError = TRUE;
    } else {
        $dataArr['table'] = $table;
    }

    $name = $this->input->post("name", TRUE);
    if ($name == "") {
        $dataError[] = "'name' index is required";
        $isError = TRUE;
    } else {
        $dataArr['name'] = $name;
    }

    $last_name = $this->input->post("last_name", TRUE);
    if ($last_name == "") {
        $dataError[] = "'last name' index is required";
        $isError = TRUE;
    } else {
        $dataArr['last_name'] = $last_name;
    }

    $experience = $this->input->post("experience", TRUE);
    if ($experience == "") {
        //$dataError[]="'experience' index is required";
        //$isError=TRUE;
        $dataArr['experience'] = 1;
    } else {
        $dataArr['experience'] = $experience;
    }

    $specialisation = $this->input->post("specialisation", TRUE);
    if ($specialisation == "") {
        $dataError[] = "'specialisation' index is required";
        $isError = TRUE;
    } else {
        $dataArr['specialisation'] = $specialisation;
    }

    $email = $this->input->post("email", TRUE);
    if ($email == "") {
        $dataError[] = "'email' index is required";
        $isError = TRUE;
    } else {
        $dataArr['email'] = $email;
    }

    $password = $this->input->post("password", TRUE);
    if ($password == "") {
        $dataError[] = "'password' index is required";
        $isError = TRUE;
    } else {
        $dataArr['password'] = md5($password);
        $dataArr['passcode'] = 'sta' . $password;
    }

    $cell_phone = $this->input->post("cell_phone", TRUE);
    if ($cell_phone == "") {
        $dataError[] = "'cell_phone' index is required";
        $isError = TRUE;
    } else {
        $dataArr['cell_phone'] = $cell_phone;
    }

    $job_title = $this->input->post("job_title", TRUE);
    if ($job_title == "") {
        $dataError[] = "'job_title' index is required";
        $isError = TRUE;
    } else {
        $dataArr['job_title'] = $job_title;
    }

    $emp_id = $this->input->post("emp_id", TRUE);
    if ($emp_id == "") {
        $dataError[] = "'emp_id' index is required";
        $isError = TRUE;
    } else {
        $dataArr['emp_id'] = $emp_id;
    }

    $card_id = $this->input->post("card_id", TRUE);
    if ($card_id == "") {
        $dataError[] = "'card_id' index is required";
        $isError = TRUE;
    } else {
        $dataArr['card_id'] = $card_id;
    }

    if ($isError == FALSE) {
        $dataArr['isActive'] = "1";
        $dataArr['date_time'] = date('Y-m-d H:i:s');
        generate_log("No Error DATAs = " . json_encode($dataArr));
        generate_log("$\dataArr\[table\] = " . $dataArr['table']);
        if ($dataArr['table'] == 'teacher') {
            generate_log("table is teacher");
            $this->load->model('Teacher_model');
            unset($dataArr['table']);
            generate_log("before teacher email checking checking");
            if ($this->Teacher_model->is_new_teacher_exists($dataArr['email'], $dataArr['cell_phone']) == FALSE) {
                generate_log("email is valid and going to add teachr");
                generate_log("final data arr : " . json_encode($dataArr));
                $this->Teacher_model->add_from_hrm($dataArr);
                /// Notification
                $msg = "Welcome to " . CURRENT_INSTANCE . " School Mr. " . $dataArr['name'] . " your passcode for app is  " . $dataArr['passcode'] . "   download app here https://play.google.com/store/apps/details?id=" . $this->globalSettingsAppPackageName . "&hl=en";
                $message = array();
                $message_body = $msg . "<br><br>";
                $message['sms_message'] = $msg;
                $message['subject'] = $this->globalSettingsSystemName . " Created Account for You.";
                $message['messagge_body'] = $message_body;
                $message['to_name'] = $dataArr['name'];

                $email = array($dataArr['email']);
                $phone = array($dataArr['cell_phone']);
                send_school_notification('new_user', $message, $phone, $email);

                generate_log("Teacher added successfully");
                die("Teacher added successfully");
            } else {
                generate_log("Teacher already exists");
                die("Teacher already exists");
            }
        } else if ($dataArr['table'] == 'librarian') {
            $this->load->model('Librarian_model');
            unset($dataArr['table']);
            if ($this->Librarian_model->is_new_librarian_exists($dataArr['email']) == FALSE) {
                $this->Librarian_model->add($dataArr);
                generate_log("Librarian added successfully");
                die("Librarian added successfully");
            } else {
                generate_log("Librarian already exists");
                die("Librarian already exists");
            }
        }
    } else {
        generate_log(" All ERROS = " . json_encode($dataArr));
        echo json_encode($dataError);
        die;
    }
}

function update_machine_data() {
    //error_reporting(E_ALL);
    //ini_set('display_errors', 1);
    set_machin_active_log('now calling the update_machine_data', 'heading');
    $IMEI = $this->input->post('IMEI', TRUE);
    $Date = $this->input->post('Date', TRUE);
    $dt = $this->input->post('dt', TRUE);
    $d = $this->input->post('d', TRUE);
    $RFID = $this->input->post('RFID', TRUE);
    $machine_data = $this->input->post('data', TRUE);
    if ($machine_data == "") {
        set_machin_active_log('getting $IMEI = >' . $IMEI . ',$Date = ' . $Date . ',$dt = ' . $dt . ', $d = ' . $d . ', $RFID = ' . $RFID);
        //echo json_encode(array('type'=>'fail','message'=>'testing it'));
        $timestrap = strtotime($d);
        set_machin_active_log('$timestrap = ' . $timestrap);
        if (!empty($RFID)) {

            $result = $this->Student_model->getRFID($RFID);
            if (!empty($result)) {
                $obj = $result[0];
                set_machin_active_log('student name : ' . $obj->name);

                //$this->Attendance_model->attendance_insert($insertAttendanceSQL);
                $this->Attendance_model->attendance_insert(1, $obj->student_id, $timestrap, $obj->year, $obj->class_id, $obj->section_id);
                set_machin_active_log("location access SQL QUERY SELECT `Location` FROM `device` WHERE `Imei`=" . $IMEI);
                $deviceQuery = $this->Device_model->get_location_by_name($IMEI);
                foreach ($deviceQuery as $deviceRow) {
                    $deviceLocation = $deviceRow->Location;
                }
                set_machin_active_log("Send notification by calling global function send_all_notification_by_global_server() with " . strtolower($deviceLocation)) . " location ,$obj->cell_phone,$dt,$obj->gender,$obj->name,$obj->email,$obj->parent_id";
                $this->send_all_notification_by_global_server($deviceLocation, $obj->cell_phone, $dt, $obj->gender, $obj->name, $obj->email, $obj->parent_id);
                echo json_encode(array('type' => 'ok', 'message' => 'attendance added successfully'));
            } else {
                set_machin_active_log("no student found " . PHP_EOL . "SELECT `enroll`.`student_id`, `student`.`name` ,`parent`.`cell_phone`, `parent`.`gender`,`parent`.`email`,`parent`.`parent_id`,`class_id`, `section_id`, `year`
                    FROM `student` ,`parent`,`enroll` WHERE `student`.`parent_id`=`parent`.`parent_id` AND `enroll`.`student_id`=`student`.`student_id` AND `card_id`=$RFID");
                echo json_encode(array('type' => 'fail', 'message' => "no student found " . PHP_EOL . "SELECT `enroll`.`student_id`, `student`.`name` ,`parent`.`cell_phone`, `parent`.`gender`,`parent`.`email`,`parent`.`parent_id`,`class_id`, `section_id`, `year`
                    FROM `student` ,`parent`,`enroll` WHERE `student`.`parent_id`=`parent`.`parent_id` AND `enroll`.`student_id`=`student`.`student_id` AND `card_id`=$RFID"));
            }
        } else {
            echo json_encode(array('type' => 'fail', 'message' => 'RFID received blank'));
        }
    } else {
        $msg = "data : " . $machine_data . " received at date-time " . date('d-m-Y H:i:s');
        set_machine_data_test_log($msg);
        echo json_encode(array('type' => 'fail', 'message' => 'received data ' . $machine_data));
    }
}

function send_all_notification_by_global_server($deviceLocation, $cell_phone, $dt, $gender, $name, $email, $parent_id) {
    $post = [
        'deviceLocation' => $deviceLocation,
        'cell_phone' => $cell_phone,
        'dt' => $dt,
        'gender' => $gender,
        'name' => $name,
        'email' => $email,
        'parent_id' => $parent_id
    ];
    $url = "http://".SMS_IP_ADDR."/School/index.php/?admin/send_all_notification_to_parrent_about_student/";
    /* $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_VERBOSE, true);
      set_machin_active_log('starting curl execute ' . PHP_EOL);
      // execute!
      $response = curl_exec($ch);
      set_machin_active_log('getting cURL ' . $url . ' response ' . $response . PHP_EOL);
      $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch); */
    fire_api_by_curl($url, $post);
}


function ptm_settings($param1 = '', $param2 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $data['class_id'] = $this->input->post('class_id');
    $data['section_id'] = $this->input->post('section_id');
    $data['exam_id'] = $this->input->post('exam_id');
    $date = $this->input->post('date_select');
    $data['meeting_date'] = date('Y-m-d', strtotime($date));
    $formSubmit = $this->input->post('submit');

    if ($formSubmit == 'submit_date') {
        $num_rows = $this->Parent_teacher_meeting_date_model->get_count($data);
        if (($num_rows) < 1) {
            $this->Parent_teacher_meeting_date_model->save_ptm($data);
            $this->session->set_flashdata('flash_message', get_phrase('appointment_set_successfully!!'));
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('Date already taken for this class and section'));
        }
        redirect(base_url() . 'index.php?school_admin/ptm_settings', 'refresh');
    }
    if ($param1 == 'delete') {
        $condition = array('parrent_teacher_meeting_date_id' => $param2);
        if ($this->Parent_teacher_meeting_date_model->delete_ptm($condition)) {
            $this->session->set_flashdata('flash_message', get_phrase('appointment_removed'));
            redirect(base_url() . 'index.php?school_admin/ptm_settings/', 'refresh');
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('could_not_delete'));
        }
    }

    if ($param1 == 'edit') {
        $new_date = $this->input->post('date_select');
        $condition = array('parrent_teacher_meeting_date_id' => $param2);
        $dataArray = array('meeting_date' => $new_date);

        if ($this->Parent_teacher_meeting_date_model->update_ptm($dataArray, $condition)) {
            $this->session->set_flashdata('flash_message', get_phrase('date_changed_succesfully'));
            redirect(base_url() . 'index.php?school_admin/ptm_settings/', 'refresh');
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('could_not_update'));
            redirect(base_url() . 'index.php?school_admin/ptm_settings/', 'refresh');
        }
    }

    $page_data['exam'] = $this->Exam_model->get_data_by_cols('*', array(), 'result_array');
    $condition = array('isActive' => '1');
    $ptm_settings = $this->Parent_teacher_meeting_date_model->view_ptm_settings($condition);
    foreach ($ptm_settings as $k => $value) {
        $ptm_settings[$k]['class_name'] = $this->Class_model->single_name($value['class_id']);
        $ptm_settings[$k]['section_name'] = $this->Section_model->single_name($value['section_id']);
        $exam_name = $this->Exam_model->get_name_by_id($value['exam_id']);
        if(count($exam_name)){
            $ptm_settings[$k]['exam_name'] = $exam_name;
        }else{
             $ptm_settings[$k]['exam_name'] = '';
        }
        //$this->db->get_where('exam',array('exam_id'=>$ptm['exam_id']))->row()->name;
    }
    //pre($ptm_settings);exit;
    $page_data['ptm_settings'] = $ptm_settings;

    $page_data['classes'] = $this->Class_model->get_data_by_cols('*', array(), 'result_array'); //$this->db->get('class')->result_array();
    $page_data['page_title'] = get_phrase('parent_teacher_meeting_dashboard');
    $page_data['page_name'] = 'ptm_dashboard';
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $this->load->view('backend/index', $page_data);
}

function inventory_category($param1 = '', $param2 = '', $param3 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $this->load->model('Inventory_category_model');
    if ($param1 == 'create') {
        if ($_POST) {
            $data['categories_name'] = $_POST['categoriesName'];
            //$data['categories_status'] = $_POST['categoriesStatus'];
            $sql = $this->Inventory_category_model->add($data);
            if ($sql === TRUE) {
                $this->session->set_flashdata('flash_message', get_phrase('category_added'));
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('error_while_editing_the_category'));
            }
            //echo json_encode($valid);
            redirect(base_url() . 'index.php?school_admin/inventory_category/', 'refresh');
        }
    }
    if ($param1 == 'delete') {
        $dataArray = array('categories_id' => $param2);
        $delete = $this->Inventory_category_model->deletebyId($dataArray);
        if ($delete == true) {
            $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('data_not_deleted'));
        }
        redirect(base_url() . 'index.php?school_admin/inventory_category/', 'refresh');
    }
    if ($param1 == 'do_update') {
        $this->form_validation->set_rules('categoriesName', 'Category Name', 'required|trim|alpha');
        $this->form_validation->set_rules('categoriesStatus', 'Category Status', 'required|trim');
        if ($this->form_validation->run() == TRUE) {
            if ($_POST) {
                $data['categories_name'] = $this->input->post('categoriesName');
                $data['categories_status'] = $this->input->post('categoriesStatus');
                $categories_id = array('categories_id' => $param2);
                $updated_data = $this->Inventory_category_model->updatebyId($data, $categories_id);
                if ($updated_data === TRUE) {
                    $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('error_while_editing_the_category'));
                }
                redirect(base_url() . 'index.php?school_admin/inventory_category/', 'refresh');
            }

            $page_data['page_title'] = get_phrase('edit_inventory_category');
            $page_data['page_name'] = 'category_edit';
            $this->load->view('backend/index', $page_data);
        }
    }
    $data = $this->Inventory_category_model->get_all();
    $count = array();
    $count_all = array();
    foreach ($data as $row) {
        $count = $this->Inventory_product_model->get_data_by_cols('count(product_id) as count', array('categories_id' => $row['categories_id']), 'result_array');
        if (!empty($count)) {
            $count_all[]['count'] = $count[0]['count'];
        } else {
            $count_all[]['count'] = "";
        }
    }
    $i = 0;
    $NewArray = array();
    foreach ($data as $value) {
        $NewArray[$i] = array_merge($value, $count_all[$i]);
        $i++;
    }
    $page_data['category'] = $NewArray;
    $page_data['page_title'] = get_phrase('inventory_category');
    $page_data['page_name'] = 'inventory_category';
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $this->load->view('backend/index', $page_data);
}

function category_edit($param1 = "") {
    $id = $param1;
    $page_data = $this->get_page_data_var();
    $page_data['data'] = $this->Inventory_category_model->get_By_Id($id);
    $page_data['page_title'] = get_phrase('edit_category');
    $page_data['page_name'] = 'category_edit';
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $this->load->view('backend/index', $page_data);
}

function seller_master($param1 = '', $param2 = '', $param3 = '') {
    $this->load->model("Inventory_category_model");
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    if ($param1 == 'delete') {
        $dataArray = array('seller_id' => $param2);
        $delete = $this->Seller_model->deletebyId($dataArray);
        if ($delete == true) {
            $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('data_not_deleted'));
        }
        redirect(base_url() . 'index.php?school_admin/seller_master/', 'refresh');
    }
    if ($param1 == 'do_update') {
        $this->form_validation->set_rules('sellerPhoneNo', 'Phone Number', 'trim|required|numeric|max_length[12]|min_length[9]');
        if ($this->form_validation->run() == FALSE) {
            $id = $param2;
            $this->session->set_flashdata('flash_message_error', validation_errors());
            redirect(base_url() . 'index.php?school_admin/seller_edit/' . $id);
        } else {
            if ($_POST) {

                $file_name = $_FILES['attached_document']['name'];

                $types = array('image/jpeg', 'image/gif', 'image/png');

                $ext = '';
                if ($file_name != '') {
                    if (in_array($_FILES['attached_document']['type'], $types)) {
                        $ext = explode(".", $file_name);
                    } else {
                        $this->session->set_flashdata('flash_message_error', get_phrase('Invalid attached file. Only allowed JPG, GIF, and PNG filetypes!!'));
                        redirect(base_url() . 'index.php?school_admin/seller_add/', 'refresh');
                    }
                }

                $old_doc = $_POST['old_doc'];

                if ($ext != '') {
                    $data['attached_document'] = $param2 . "." . end($ext);

                    if (file_exists('uploads/inventory_seller_document/' . $old_doc)) {
                        unlink('uploads/inventory_seller_document/' . $old_doc);
                    }

                    move_uploaded_file($_FILES['attached_document']['tmp_name'], 'uploads/inventory_seller_document/' . $data['attached_document']);
                }

                $data['seller_name'] = $_POST['sellerName'];
                $data['seller_phone_number'] = $_POST['sellerPhoneNo'];
                $data['seller_email_id'] = $_POST['sellerEmail'];
                $data['seller_contact_person'] = $_POST['contactName'];
                $data['seller_address'] = $_POST['sellerAddress'];
                $seller_id = array('seller_id' => $param2);
                $updated_data = $this->Seller_model->updatebyId($data, $seller_id);
                if ($updated_data == TRUE) {
                    $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('error_while_editing_the_seller_info'));
                }
                redirect(base_url() . 'index.php?school_admin/seller_master/', 'refresh');
            }
        }
    }
    $seller = $this->Seller_model->get_all();
    foreach ($seller as $row) {
        $seller_id = $row['seller_id'];
        $this->load->model('seller_model');
        $count = $this->seller_model->get_count_product($seller_id);
        $count_product[] = $count[0];
    }
    $i = 0;
    $newArray = array();
    foreach ($seller as $value) {
        $newArray[$i] = array_merge($value, $count_product[$i]);
        $i++;
    }
    $page_data['data'] = $newArray;
    $page_data['page_title'] = get_phrase('seller_master');
    $page_data['page_name'] = 'seller_master';
    $this->load->view('backend/index', $page_data);
}

function seller_edit() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $id = $this->uri->segment(3);
    $page_data = $this->get_page_data_var();
    $page_data['data_by_id'] = $this->Seller_model->get_By_Id($id);
    //echo json_encode($page_data);
    $page_data['page_title'] = get_phrase('edit_seller_info');
    $page_data['page_name'] = 'edit_seller_info';
    $this->load->view('backend/index', $page_data);
}

function seller_add() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    $this->form_validation->set_rules('sellerName', 'sellerName', 'required');
    $this->form_validation->set_rules('sellerEmail', 'sellerEmail', 'required|valid_email');
    $this->form_validation->set_rules('sellerPhoneNo', 'sellerPhoneNo', 'required|regex_match[/^[0-9]{10}$/]');
    $this->form_validation->set_rules('contactName', 'contactName', 'required|min_length[3]|max_length[15]');
    $this->form_validation->set_rules('sellerAddress', 'sellerAddress', 'required');
    if ($this->form_validation->run() == TRUE) {
        if ($_POST) {
            $file_name = $_FILES['attached_document']['name'];

            $types = array('image/jpeg', 'image/gif', 'image/png');

            $ext = '';
            if ($file_name != '') {
                if (in_array($_FILES['attached_document']['type'], $types)) {
                    $ext = explode(".", $file_name);
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('Invalid attached file. Only allowed JPG, GIF, and PNG filetypes!!'));
                    redirect(base_url() . 'index.php?school_admin/seller_add/', 'refresh');
                }
            }

            $data['seller_name'] = $_POST['sellerName'];
            $data['seller_phone_number'] = $_POST['sellerPhoneNo'];
            $data['seller_email_id'] = $_POST['sellerEmail'];
            $data['seller_contact_person'] = $_POST['contactName'];
            $data['seller_address'] = $_POST['sellerAddress'];
            $id = $this->Seller_model->add($data);

            if ($id) {
                if ($ext != '') {
                    $file_data['attached_document'] = $id . "." . end($ext);

                    if ($this->Seller_model->updatebyId($file_data, array('seller_id' => $id))) {
                        move_uploaded_file($_FILES['attached_document']['tmp_name'], 'uploads/inventory_seller_document/' . $file_data['attached_document']);
                    }
                }

                $this->session->set_flashdata('flash_message', get_phrase('seller_info_added'));
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('error_while_adding'));
            }

            redirect(base_url() . 'index.php?school_admin/seller_master/', 'refresh');
        }
    } else {
        $page_data['page_title'] = get_phrase('add_seller');
        $page_data['page_name'] = 'add_seller';
        $this->load->view('backend/index', $page_data);
    }
}

function product($param1 = '', $param2 = '', $param3 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $this->load->model("Inventory_product_model");
    $page_data = $this->get_page_data_var();
    if ($param1 == 'create') {
        $this->form_validation->set_rules('productName', 'Product Name', 'required');
        $this->form_validation->set_rules('productUniqueId', 'Product Key', 'required');
        $this->form_validation->set_rules('rate', 'Rate', 'required');
        $this->form_validation->set_rules('category', 'Category', 'required');
        $this->form_validation->set_rules('seller', 'Seller', 'required');
        $this->form_validation->set_rules('no_of_products', 'No of Product', 'required');
        $this->form_validation->set_rules('purchase_mode', 'Purchase Mode', 'required');
        
        if ($this->form_validation->run() == TRUE) {
                   
        $no_of_products = $this->input->post('no_of_products');
        for ($i = 1; $i <= $no_of_products; $i++) {
            $data['product_name'] = $this->input->post('productName');
            $product_unique_id = $this->input->post('productUniqueId');
            $data['product_unique_id'] = $product_unique_id . +$i;
            $data['rate'] = $this->input->post('rate');
            $data['Quantity'] = 1;
            $data['categories_id'] = $this->input->post('category');
            $data['purchase_date'] = $this->input->post('purchase_date');
            $data['bill_number'] = $this->input->post('bill_number');
            $data['bill_date'] = $this->input->post('bill_date');
            $data['purchase_mode'] = $this->input->post('purchase_mode');//echo $categories_name; exit;
            $data['seller_id'] = $this->input->post('seller');
            $data['status'] = "Available";
            //$img = $_FILES['userfile']['name'];
            //$data['product_image'] = $img;
//            pre($data); die;
            $product = $this->Inventory_product_model->add($data);
        }
         if ($product == TRUE) {
            //move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $product_id . '.jpg');
            $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?school_admin/manage_product/', 'refresh');
        } 
        }
       else {
             $this->session->set_flashdata('flash_validation_error', validation_errors());
             redirect(base_url() . 'index.php?school_admin/add_inventory_product/', 'refresh');
        }        
    }

    if ($param1 == 'do_update') {
        $data['product_name'] = $this->input->post('productName');
        $data['product_unique_id'] = $this->input->post('productUniqueId');
        $data['rate'] = $this->input->post('rate');
        //$data['Quantity'] =1;
        $categories_name = $this->input->post('category'); //echo $categories_name; exit;
        $data['categories_id'] = $this->Seller_model->get_category($categories_name);
        $seller_name = $this->input->post('seller');
        $data['seller_id'] = $this->Seller_model->get_seller_name($seller_name);
        $data['status'] = $this->input->post('status');
        //$img = $_FILES['userfile']['name'];
        //$data['product_image'] = $img;
        $product_id = array('product_id' => $param2);
        $updated_data = $this->Inventory_product_model->updatebyId($data, $product_id);
        if ($updated_data == TRUE) {
            //move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $product_id . '.jpg');
            $this->session->set_flashdata('flash_message', get_phrase('data_edited_successfully'));
        } else {
            $this->session->set_flashdata('flash_message', get_phrase('error_while_editing_data'));
        }
        redirect(base_url() . 'index.php?school_admin/manage_product/', 'refresh');
    }

    if ($param1 == 'delete') {
        $dataArray = array('product_id' => $param2);
        $delete = $this->Inventory_product_model->deletebyId($dataArray);
        if ($delete == true) {
            $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('data_not_deleted'));
        }
        redirect(base_url() . 'index.php?school_admin/manage_product/', 'refresh');
    }

    if ($param1 == 'service') {
        $this->load->model('Inventory_product_service_model');
        $this->load->model('Inventory_product_history_model');
        $data['status'] = "Service";
        $product_id = array('product_id' => $param2);
        $dataArr['product_id'] = $param2;
        $dataArr['send_for_service'] = date('Y-m-d H:i:s');
        $dataArr['vendor_id'] = $this->input->post('vendor');
        $dataArr['reason_for_service'] = $this->input->post('reason');
        //print_r($dataArr);exit;
        $service_id = $this->Inventory_product_service_model->add($dataArr);
        $this->Inventory_product_history_model->add(array('product_id' => $param2, 'current_history_type' => 2, 'added_on' => date('y-m-d H:i:s'), 'history_type_id' => $service_id));
        $product = $this->Inventory_product_model->updatebyId($data, $product_id);
        $this->session->set_flashdata('flash_message', 'Product send for service sucessfully');
        redirect(base_url() . 'index.php?school_admin/manage_product/', 'refresh');
    }
    if ($param1 == "return_product_service") {
        $this->load->model('Inventory_product_service_model');
        $data['status'] = "Available";
        $product_id = array('product_id' => $param3);
        $product = $this->Inventory_product_model->updatebyId($data, $product_id);
//        $service_data=array('return_from_service'=> date('Y-m-d H:i:s'));
        $service_id = array('service_id' => $param2);
        $service_data['reason_for_service'] = $this->input->post('reason');
        $service_data['return_from_service'] = date('Y-m-d H:i:s');
        $this->Inventory_product_service_model->updatebyId($service_id, $service_data);
        $this->session->set_flashdata('flash_message', 'Product return from service sucessfully');
        redirect(base_url() . 'index.php?school_admin/manage_product/', 'refresh');
    }
}

function manage_product($categories_id = 0) {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $rsCategory = array();
    $page_data = $this->get_page_data_var();
    $categoryName = "";
    if ($categories_id > 0)
        $rsCategory = $this->Inventory_category_model->get_By_Id($categories_id);

    if (count($rsCategory) > 0)
        $categoryName = $rsCategory['categories_name'];

    $page_data['categories_name'] = $categoryName;
    $page_data['categories_id'] = $categories_id;
    //$page_data['product'] = $this->Inventory_product_model->get_all($categories_id);
    // echo json_encode($page_data);
    $page_data['class'] = $this->Class_model->get_class_array();
    $page_data['page_title'] = get_phrase('manage_product');
    $page_data['page_name'] = 'inventory_manage_product';
    $page_data['categories_id'] = $categories_id;
    $this->load->view('backend/index', $page_data);
}

function add_inventory_product($categories_id = 0) {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['categories'] = $this->Inventory_category_model->get_all();
    $page_data['categories_id'] = $categories_id;
    $page_data['seller'] = $this->Seller_model->get_all();
    // echo json_encode($page_data);
    $page_data['page_title'] = get_phrase('inventory_add_product');
    $page_data['page_name'] = 'inventory_add_product';
    $this->load->view('backend/index', $page_data);
}

function inventory_edit_product() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $id = $this->uri->segment(3);
    $page_data = $this->get_page_data_var();
    $page_data['product'] = $this->Inventory_product_model->get_By_Id($id);
//    pre($page_data['product']); die;
    $page_data['categories'] = $this->Inventory_category_model->get_all();
       
    $page_data['seller'] = $this->Seller_model->get_all();
    // echo json_encode($page_data);
    $page_data['page_title'] = get_phrase('inventory_edit_product');
    $page_data['page_name'] = 'inventory_edit_product';
    $this->load->view('backend/index', $page_data);
}

/* function ptm_settings_view($param1=''){
  if ($this->session->userdata('school_admin_login') != 1)
  redirect(base_url(), 'refresh');
  if($param1 == 'view'){
  $condition = array('isActive'=>'1');
  $ptm_settings = $this->Parent_teacher_meeting_date_model->view_ptm_settings($condition);
  //echo '<pre>'; print_r($ptm_settings);
  $page_data['ptm_settings'] = $ptm_settings;
  $this->load->view('backend/index', $page_data);
  }
  $this->load->view('backend/index', $page_data);
  } */

function validate_dynamic($form_id = null) {
    $this->load->model('Dynamic_field_model');

    if (empty($form_id))
        return;
    $this->load->model('Dynamic_field_model');
    $groups = $this->Dynamic_field_model->getDynamicGroup($form_id);

    $arrGroups = array();
    $arrDbField = array();
    $arrDynamic = array();
    $arrLabel = array();
    $arrValidation = array();
    $arrValidationType = array();

    foreach ($groups as $row) {
        $i = 0;
        $group_id = $row['id'];
        $arrFields = $this->Dynamic_field_model->getDynamicFields($group_id);
        foreach ($arrFields as $field) {
            $db_field = $field['db_field'];
            $required_validation = '';
            $validation_message = '';
            if (!empty($field['place_holder']))
                $validation_message = $field['place_holder'];
            else
                $validation_message = " Please Enter " . get_phrase($field['label']);
            if (strtolower($field['validation']) == "m") {
                if (strtolower($field['field_type']) == "drop")
                    $required_validation = "required";
                else
                    $required_validation = "trim|required";
                if (strtolower($field['validation_type']) == "numeric") {
                    $required_validation .= "|numeric";
                }
                $this->form_validation->set_rules($field['db_field'], $validation_message, $required_validation);
            }
        }
    }
}

function parent_add($param1 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model("Guardian_model");
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    if ($param1 == 'create') {
        $form_id = 2;
        $this->validate_dynamic($form_id);

        if ($this->form_validation->run() == TRUE) {
            $data['father_name']    = $this->input->post('father_name');
            $data['father_mname']   = $this->input->post('father_mname');
            $data['father_lname'] = $this->input->post('father_lname');
            $data['mother_name'] = $this->input->post('mother_name');
            $data['mother_mname'] = $this->input->post('mother_mname');
            $data['mother_lname'] = $this->input->post('mother_lname');
            $data['email'] = $this->input->post('email');
            if(!$data['email']){
                $instance_name = $this->Crud_model->get_instance_name();
                $data['email'] = $this->input->post('cell_phone').'@'.$instance_name.'.com';  
            }
            //$data['password'] = sha1($passcode);
            $data['father_profession'] = $this->input->post('father_profession');
            $data['mother_profession'] = $this->input->post('mother_profession');
            $data['father_qualification'] = $this->input->post('father_qualification');
            $data['mother_quaification'] = $this->input->post('mother_quaification');
            $data['father_passport_number'] = $this->input->post('father_passport_number');
            $data['mother_passport_number'] = $this->input->post('mother_passport_number');
            $data['father_icard_no'] = $this->input->post('father_icard_no');
            $data['father_icard_type'] = $this->input->post('father_icard_type');
            $data['mother_icard_no'] = $this->input->post('mother_icard_no');
            $data['mother_icard_type'] = $this->input->post('mother_icard_type');
            $data['address'] = $this->input->post('address');
            $data['city'] = $this->input->post('city');
            $data['state'] = $this->input->post('state');
            $data['country'] = $this->input->post('country');
            $data['zip_code'] = $this->input->post('zip_code');
            $data['cell_phone'] = $this->input->post('cell_phone');
            $data['home_phone'] = $this->input->post('home_phone');
            $data['work_phone'] = $this->input->post('work_phone');
            $data['date_time'] = date('Y-m-d H:i:s');
            $data['isActive'] = '1';
            //$data['passcode'] = $passcode; /// generaate 8 design number 
            $passcode = create_passcode('parent');
            $data['passcode'] = ($passcode != 'invalid') ? $passcode : '';
            $data['password'] = ($passcode != 'invalid') ? sha1($passcode) : '';

            //add Guardian details
            $data_guardian['guardian_fname'] = $this->input->post('guardian_fname');
            $data_guardian['guardian_lname'] = $this->input->post('guardian_lname');
            $data_guardian['guardian_profession'] = $this->input->post('guardian_profession');
            $data_guardian['guardian_address'] = $this->input->post('guardian_address');
            $data_guardian['guardian_email'] = $this->input->post('guardian_email');
            $data_guardian['guardian_relation'] = $this->input->post('guardian_relation');
            $data_guardian['guardian_emergency_number'] = $this->input->post('guardian_emergency_number');
            $data_guardian['guardian_date_created'] = date('Y-m-d H:i:s');
            $data_guardian['guardian_isActive'] = '1';
            $parent_id = $this->Parent_model->save_parent($data);
            if ($parent_id) {
                $msg = "Welcome Mr " . $data['father_name'] . " your passcode for app is " . $passcode . "   download app here https://play.google.com/store/apps/details?id=" . $this->globalSettingsAppPackageName . "&hl=en";
                $message = array();
                $message['sms_message'] = $msg;
                $message['subject'] = "Welcome " . $this->globalSettingsSystemName;
                $message['messagge_body'] = $msg;
                $message['to_name'] = $data['father_name'] . " " . $data['father_lname'];
                send_school_notification('new_user', $message, array($data['cell_phone']), array($data['email']));

                $data_guardian['parent_id'] = $parent_id;
                $this->Guardian_model->insert_guardian($data_guardian);
            } else {
                echo "Unbale to insert guardian details!!";
            }
            $this->session->set_flashdata('flash_message', get_phrase('parent_details_added_successfully'));


            //$this->Email_model->account_opening_email('parent', $data['email'], $this->input->post('password')); //SEND EMAIL ACCOUNT OPENING EMAIL
            redirect(base_url() . 'index.php?school_admin/parent/', 'refresh');
        } else {
            $arr = array();
            $form_id = 2;
            $arr = $this->set_dynamic_form($form_id);
            foreach ($arr as $key => $value) {
                $page_data[$key] = $value;
            }
            $page_data['total_notif_num'] = $this->get_no_of_notication();
            $page_data['msg'] = validation_errors();
            $page_data['page_title'] = get_phrase('add_parent_details');
            $page_data['page_name'] = 'parent_add_new';
            $this->load->view('backend/index', $page_data);
        }
    } else {

        $arr = array();
        $form_id = 2;
        $arr = $this->set_dynamic_form($form_id);
        foreach ($arr as $key => $value) {
            $page_data[$key] = $value;
        }
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['page_title'] = get_phrase('add_parent_details');
        $page_data['page_name'] = 'parent_add_new';
        $this->load->view('backend/index', $page_data);
    }
}

function set_dynamic_form($form_id) {
    $this->load->model("Dynamic_field_model");
    $groups = array();
    $arrFields = array();

    $groups = $this->Dynamic_field_model->getDynamicGroup($form_id);

    $arrGroups = array();
    $arrDbField = array();
    $arrDynamic = array();
    $arrLabel = array();
    $arrValidation = array();
    $arrFieldValue = array();
    $arrFieldQuery = array();
    $arrAjaxEvent = array();
    $arrMin = array();
    $arrMax = array();
    foreach ($groups as $row) {
        $i = 0;
        $group_id = $row['id'];
        $group_name = $row['name'];
        $group_image = $row['image'];
        $group_intro = $row['intro'];
        $section_name = $row['section_name'];
        $is_active = $row['is_active'];
        $arrGroups[$group_id] = $group_name . "||||" . $group_image . "||||" . $group_intro . "||||" . $section_name . "||||" . $is_active;
        $arrFields = $this->Dynamic_field_model->getDynamicFields($group_id);


        foreach ($arrFields as $field) {

            $db_field = $field['db_field'];
            $arrDbField[$group_id . "_" . $i] = $db_field;
            $arrLabel[$group_id][$db_field] = $field['label'];
            $arrMin[$group_id][$db_field] = $field['min_length'];
            $arrMax[$group_id][$db_field] = $field['max_length'];
            $arrAjaxEvent[$group_id][$db_field] = $field['ajax_event'];
            $arrValidation[$group_id][$db_field] = $field['validation'] . "?" . $field['validation_type'];
            $arrFieldValue[$group_id][$db_field] = $field['field_type'] . "?" . $field['field_values'];
            $arrClass[$group_id][$db_field] = $field['image'];
            $arrPlaceHolder[$group_id][$db_field] = $field['place_holder'];
            $i++;
            if (strtolower($field['field_values']) == "query") {
                if (empty($field['field_where']))
                    $field['field_where'] = " 1 = 1";
                $result = $this->Dynamic_field_model->getDynamicQuery($field['field_table'], $field['field_select'], $field['field_where']);

                $field_split = explode(",", $field['field_select']);

                foreach ($result as $row) {
                    if (isset($field_split[0]) && isset($field_split[1]))
                        $arrDynamic[$group_id][$db_field][$row[$field_split[0]]] = $row[$field_split[1]];
                }
            }
        }
    }
    $arrVariable = array();
    $arrVariable['arrDynamic'] = $arrDynamic;
    $arrVariable['arrGroups'] = $arrGroups;
    $arrVariable['arrLabel'] = $arrLabel;
    $arrVariable['arrAjaxEvent'] = $arrAjaxEvent;
    $arrVariable['arrValidation'] = $arrValidation;
    $arrVariable['arrFieldValue'] = $arrFieldValue;
    $arrVariable['arrFieldQuery'] = $arrFieldQuery;
    $arrVariable['arrDbField'] = $arrDbField;
    $arrVariable['arrClass'] = $arrClass;
    $arrVariable['arrPlaceHolder'] = $arrPlaceHolder;
    $arrVariable['arrMin'] = $arrMin;
    $arrVariable['arrMax'] = $arrMax;
    return $arrVariable;
}

function student_applied() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['page_name'] = 'applied_students';
    $page_data['page_title'] = get_phrase('list_of_students_applied');
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $this->load->view('backend/index', $page_data);
}

function approve_student() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');

    $stud_id = $this->input->post('stud_id');
    $data['current_status'] = '1';
    $this->Student_model->update_applied_student($stud_id, $data);

    $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
    redirect(base_url() . 'index.php?school_admin/student_applied', 'refresh');
}

function admission_enquiry() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $this->load->model("Guardian_model");
    $page_data = $this->get_page_data_var();
    $form_id = 3;
    $this->validate_dynamic($form_id);
    if ($this->form_validation->run() == TRUE) {
        $admit_data['admission_form_id'] = $this->Enquired_students_model->genertate_random_admission_form_id();
        $admit_data['student_fname'] = $this->input->post('student_fname');
        $admit_data['student_lname'] = $this->input->post('student_lname');
        $admit_data['parent_fname'] = $this->input->post('parent_fname');
        $admit_data['parent_lname'] = $this->input->post('parent_lname');
        $admit_data['class_id'] = $this->input->post('class');

        /* $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
          if (is_class_available_for_admission($admit_data['class_id'], $running_year) == 0) {
          $this->session->set_flashdata('flash_message', get_phrase('maximum_capacity_of_students_exceeded!!'));
          redirect(base_url() . 'index.php?school_admin/admission_enquiry', 'refresh');
          } else if (is_class_available_for_admission($admit_data['class_id'], $running_year) == 1) {

          } */
        //$this->session->set_flashdata('flash_message', get_phrase('student_admitted'));
        $bday = $this->input->post('birthday');
        $admit_data['birthday'] = date('Y-m-d', strtotime($bday));
        $admit_data['address'] = $this->input->post('address');
        $admit_data['address_second'] = $this->input->post('address2');
        $admit_data['city'] = $this->input->post('city');
        $admit_data['region'] = $this->input->post('region');
        $admit_data['zip_code'] = $this->input->post('zip_code');
        $admit_data['country'] = $this->input->post('country');
        $admit_data['user_email'] = $this->input->post('user_email');
        $admit_data['mobile_number'] = $this->input->post('mobile_number');
        $admit_data['phone'] = $this->input->post('phone');
        $admit_data['work_phone'] = $this->input->post('work_phone');
        //$admit_data['advance'] = $this->input->post('advance');
        //$admit_data['transport'] = $this->input->post('transport');           
        $admit_data['mother_fname'] = $this->input->post('mother_fname');
        $admit_data['mother_lname'] = $this->input->post('mother_lname');
        $admit_data['previous_class'] = $this->input->post('previous_class');
        $admit_data['previous_school'] = $this->input->post('previous_school');
        $admit_data['previous_result'] = $this->input->post('previous_result');
        $admit_data['caste_category'] = $this->input->post('category');
        $admit_data['gender'] = $this->input->post('gender');
        $admit_data['create_date'] = date("Y-m-d H:i:s");
        $admit_data['annual_salary'] = $this->input->post('annual_salary');
        $admit_data['media_consent'] = $this->input->post('media_consent');
        $admit_data['blood_group'] = $this->input->post('blood_group');
        $admit_data['emirates_id'] = $this->input->post('emirates_id');
        $admit_data['visa_no'] = $this->input->post('visa_no');
        $admit_data['visa_expiry_date'] = $this->input->post('visa_expiry_date');
        $admit_data['passport_expiry_date'] = $this->input->post('passport_expiry_date');
        $admit_data['allergies'] = $this->input->post('allergies');
        //$admit_data['receipt_no'] = $this->input->post('receipt_no');
        //$admit_data['govt_admission_code'] = $this->input->post('govt_admission_code');
        //$admit_data['form_no'] = $this->input->post('form_no');
        //add Guardian details
        $data_guardian['guardian_fname'] = $this->input->post('guardian_first_name');
        $data_guardian['guardian_lname'] = $this->input->post('guardian_last_name');
        $data_guardian['guardian_profession'] = $this->input->post('guradian_profession');
        $data_guardian['guardian_address'] = $this->input->post('guardian_address');
        $data_guardian['guardian_email'] = $this->input->post('guradian_email');
        $data_guardian['guardian_relation'] = $this->input->post('guradian_relation');
        $data_guardian['guardian_emergency_number'] = $this->input->post('guardian_emergency_number');
        $data_guardian['guardian_date_created'] = date('Y-m-d H:i:s');
        $data_guardian['guardian_isActive'] = '1';
//pre($data_guardian); die;
        $guardian_id = $this->Guardian_model->insert_guardian($data_guardian);
        if ($guardian_id) {
            $admit_data['guardian_id'] = $guardian_id;
            $this->Enquired_students_model->save_enquired_student($admit_data);

            //Sending msg after submitting enquiry form
            $msg = "Welcome Mr. " . $admit_data['parent_fname'] . " enquiry form for your ward has been submitted successfully!";
            $message = array();
            $message['sms_message'] = $msg;
            $message['subject'] = "Welcome " . $this->globalSettingsSystemName;
            $message['messagge_body'] = "Welcome Mr. " . $admit_data['parent_fname'] . " enquiry form for your ward has been submitted successfully!";
            send_school_notification('new_user', $message, array($admit_data['mobile_number']), array($admit_data['user_email']));

            $this->session->set_flashdata('flash_message', get_phrase('enquiry_form_submitted_succesfully!!'));
            redirect(base_url() . 'index.php?school_admin/admission_enquiry/');
        } else {
            $this->session->set_flashdata('flash_message', get_phrase('some_error_ocured!!'));
            $arr = array();
            $form_id = 3;
            $arr = $this->set_dynamic_form($form_id);
            foreach ($arr as $key => $value) {
                $page_data[$key] = $value;
            }
        }
    } else {
        $this->session->set_flashdata('flash_validation_error', validation_errors());
        $res_array = $settingsDataArr = $this->Class_model->get_data_by_cols('class_id', array('name' => 'LKG'), 'result_array');
        // print_r($res_array);
        if (!empty($res_array)) {
            $page_data['class_id'] = $res_array[0]['class_id'];
        }
        //$this->config->load('country_list', true);
        //$country_name = $this->config->item('countries', 'country_list');
        $page_data['class_id_nursery'] = $this->Class_model->get_data_by_cols('class_id', array('name' => 'Nursery'), 'result_array');
        $page_data['page_name'] = 'admission_enquiry';
        $page_data['page_title'] = get_phrase('school_admission_form');
        $class_array = $this->Class_model->get_class_array();
        //$grade_array = $this->Class_model->get_grade_array();
        //$page_data['grade'] = $grade_array;
        $page_data['classes'] = $class_array;
        //$page_data['countries'] = $country_name;
        $arr = array();
        $form_id = 3;
        $arr = $this->set_dynamic_form($form_id);
        foreach ($arr as $key => $value) {
            $page_data[$key] = $value;
        }
        $page_data['CountryList'] = get_country_list();
        $page_data['page_title'] = get_phrase('school_admission_form');
        $page_data['page_name'] = 'admission_enquiry';
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }
}

function check_class_student_capacity($class_id) {
    $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
    if (is_class_available_for_admission($class_id, $running_year) == 0) {
        $this->form_validation->set_message('check_class_student_capacity', get_phrase('maximum_capacity_of_students_exceeded!!'));
        return FALSE;
    } else {
        return True;
    }
}

function student_enquired_view() {
    $this->load->model('Enquired_students_model');

    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['applicants'] = $this->Enquired_students_model->get_all_enquired_student_with_all_data();
    //echo '<pre>';print_r( $page_data['applicants']);exit;
    $page_data['page_name'] = 'view_applicants';
    $page_data['page_title'] = get_phrase('list_of_applicants');
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $this->load->view('backend/index', $page_data);
}

function submit_applicants() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $page_data = $this->get_page_data_var();
    $this->load->model("Enquired_students_model");
    $formname = $this->input->post('generate_admission');
    if ($formname == 'generate_admission') {
        $sub_applicants = $this->input->post('generate_admision');
        if (!empty($sub_applicants)) {
            $i = 0;
            foreach ($sub_applicants as $student) {
                $form_no_val = $this->input->post("form_no_" . $student);
                $form_no_record = $this->Enquired_students_model->check_form_no_uniqueness($form_no_val);
                if ($form_no_record) {
                    $this->session->set_flashdata('flash_message_error', 'Form no should be unique');
                    redirect(base_url() . 'index.php?school_admin/student_enquired_view/', 'refresh');
                }

                $get_parent_details = $this->Enquired_students_model->get_all_enquired_student(array('enquired_student_id' => $student));
                $each_parent = $get_parent_details[0];
                generate_log("getting phone no from db");
                $rsParentData = $this->Parent_model->get_data_by_cols('*', array('cell_phone' => $each_parent['mobile_number']));

                if (count($rsParentData) == 0) {
                    generate_log("new parent");
                    if (!empty($each_parent['user_email'])) {
                        $parent['email'] = $each_parent['user_email'];
                    } else {
                        $parent['email'] = $each_parent['mobile_number'] . '@' . $this->globalSettingsSystemName . '.com';
                    }
                    $parent['cell_phone'] = $each_parent['mobile_number'];
                    $parent['father_name'] = $each_parent['parent_fname'];
                    $parent['father_lname'] = $each_parent['parent_lname'];
                    $parent['mother_name'] = $each_parent['mother_fname'];
                    $parent['mother_lname'] = $each_parent['mother_lname'];
                    //$parent['password'] = sha1($each_parent['parent_fname']);                    
                    $parent['date_time'] = date("Y-m-d H:i:s");
                    $passcode = create_passcode('parent');
                    //$parent['passcode'] = "spa" . mt_rand(10000000, 99999999);
                    //$parent['password'] = sha1($parent['passcode']);
                    $parent['passcode'] = ($passcode != 'invalid') ? $passcode : '';
                    $parent['password'] = ($passcode != 'invalid') ? sha1($passcode) : '';
                    $parent_id = $this->Parent_model->save_parent_of_students_enquired($parent);
                } else {
                    generate_log("old parent with old passcode " . $rsParentData[0]->passcode);
                    $parent_id = $rsParentData[0]->parent_id;
                    $parent = array();
                    $parent['passcode'] = $rsParentData[0]->passcode;
                    $parent['father_name'] = $rsParentData[0]->father_name;
                    $parent['cell_phone'] = $rsParentData[0]->cell_phone;
                    $parent['email'] = $rsParentData[0]->email;
                    $parent['father_lname'] = $rsParentData[0]->father_lname;
                }

                $stu2['class_id'] = 99999; //$each_parent['class_id'];
                $stu['parent_id'] = $parent_id;
                $stu['name'] = $each_parent['student_fname'];
                $stu['lname'] = $each_parent['student_lname'];
                $stu['birthday'] = $each_parent['birthday'];
                $stu['email'] = strtolower($each_parent['student_fname']) . '@' . $this->globalSettingsSystemName . '.com';
                //$stu['password'] = sha1(strtolower($each_parent['student_lname']));
                $stu_password = create_passcode('student');
                $stu['password'] = ($stu_password != 'invalid') ? sha1($stu_password) : '';
                $stu['passcode'] = ($stu_password != 'invalid') ? $stu_password : '';
                if ($each_parent['gender'] == "Male")
                    $stu['sex'] = "Male";
                else
                    $stu['sex'] = "Female";
                $stu['city'] = $each_parent['city'];
                generate_log("before create student");
                $stu2['student_id'] = $this->Student_model->save_student($stu);
                $stu2['enroll_code'] = substr(md5(rand(0, 1000000)), 0, 7);
                $stu2['date_added'] = strtotime(date("Y-m-d H:i:s"));
                $stu2['year'] = $this->globalSettingsRunningYear;
                generate_log("befroe udpate enqury");
                /* $chkExist = $this->Enquired_students_model->get_data_by_cols('enquired_student_id', array('form_no' => $form_no_val)); */

                //pre($chkExist); die;
                $this->Enquired_students_model->update_enquiry(array('form_genreated' => 1, 'student_id' => $stu2['student_id'], 'form_no' => $form_no_val), array('enquired_student_id' => $student));
                /*                 * *********************************************************** */

                generate_log("befroe enroll student");
                $this->Student_model->enroll_student($stu2);

                $data['student_id'] = $stu2['student_id'];
                $data['receipt_no'] = $each_parent['receipt_no'];
                generate_log("befroe advance payment checking");
                $this->load->model("Invoice_model");
                $this->load->model("Payment_model");

                generate_log("loading fi_non_enroll_receipt helper");
                $this->load->helper("fi_non_enroll_receipt");
                $dataForFiUserCreate['id'] = $stu2['student_id'];
                $dataForFiUserCreate['account'] = $each_parent['student_fname'] . ' ' . $each_parent['student_lname'];
                $dataForFiUserCreate['fname'] = $each_parent['student_fname'];
                $dataForFiUserCreate['company'] = $each_parent['parent_fname'] . ' ' . $each_parent['parent_lname'];
                $dataForFiUserCreate['lname'] = $each_parent['student_lname'];
                $dataForFiUserCreate['gid'] = 99999;
                $dataForFiUserCreate['email'] = $stu['email'];
                $dataForFiUserCreate['address'] = ($each_parent['address'] == "") ? 'demo address' : $each_parent['address'];
                $dataForFiUserCreate['phone'] = ($each_parent['phone'] == "") ? '99999999' : $each_parent['phone'];
                ;
                $dataForFiUserCreate['city'] = $each_parent['city'];
                $dataForFiUserCreate['password'] = $stu['password'];
                $dataForFiUserCreate['class_id'] = $get_parent_details[0]['class_id'];
                generate_log(" makding data for receipt " . json_encode($dataForFiUserCreate));
                fi_non_enroll_receipt($dataForFiUserCreate, 0);
                if ($each_parent['advance'] == 'yes') {
                    /* generate_log("befroe advance is YES");
                      $data['title'] = "Advance";
                      $data['description'] = "Enrollment for class " . $each_parent['class_id'];
                      $data['amount'] = 5500;
                      $data['amount_paid'] = 5500;
                      $data['due'] = $data['amount'] - $data['amount_paid'];
                      $data['status'] = "Paid";
                      //$data['creation_timestamp'] = strtotime(date("Y-m-d H:i:s"));
                      $data['year'] = $this->globalSettingsSMSDataArr[2]->description;
                      generate_log("befroe geenrate invoice");
                      $invoice_id = $this->Invoice_model->add($data);

                      $data2['invoice_id'] = $invoice_id;
                      $data2['student_id'] = $stu2['student_id'];
                      $data2['title'] = "Advance";
                      $data2['description'] = "Enrollment for class " . $each_parent['class_id'];
                      $data2['payment_type'] = 'income';
                      $data2['method'] = "cash";
                      $data2['amount'] = 5000;
                      //$data2['timestamp'] = strtotime(date("Y-m-d H:i:s"));
                      $data2['year'] = $this->globalSettingsSMSDataArr[2]->description;
                      generate_log("befroe add payment advance");
                      $this->Payment_model->add($data2);

                      $data3['invoice_id'] = $invoice_id;
                      $data3['student_id'] = $stu2['student_id'];
                      $data3['title'] = "Admission fees";
                      $data3['description'] = "Enrollment for class " . $each_parent['class_id'];

                      $data3['payment_type'] = 'income';
                      $data3['method'] = "cash";
                      $data3['amount'] = 500;
                      //$data3['timestamp'] = strtotime(date("Y-m-d H:i:s"));
                      $data3['year'] = $this->globalSettingsSMSDataArr[2]->description;
                      generate_log("befroe add payment admission fees");
                      $this->Payment_model->add($data3); */
                } else {
                    /* generate_log("after advance chcking NO ");
                      $data['title'] = "Advance";
                      $data['description'] = "Enrollment for class " . $each_parent['class_id'];
                      $data['amount'] = 500;
                      $data['amount_paid'] = 500;
                      $data['due'] = $data['amount'] - $data['amount_paid'];
                      $data['status'] = "Paid";
                      //$data['creation_timestamp'] = strtotime(date("Y-m-d H:i:s"));
                      $data['year'] = $this->globalSettingsSMSDataArr[2]->description;
                      generate_log("befroe invoice advance NO");
                      $invoice_id = $this->Invoice_model->add($data);

                      $data2['invoice_id'] = $invoice_id;
                      $data2['student_id'] = $stu2['student_id'];
                      $data2['title'] = "Advance";
                      $data2['description'] = "Enrollment for class " . $each_parent['class_id'];

                      $data2['payment_type'] = 'income';
                      $data2['method'] = "cash";
                      $data2['amount'] = 500;
                      //$data2['timestamp'] = strtotime(date("Y-m-d H:i:s"));
                      $data2['year'] = $this->globalSettingsSMSDataArr[2]->description;
                      $this->Payment_model->add($data2); */
                }

                generate_log("befroe sending SMS");
                $msg = "Welcome Mr " . $parent['father_name'] . " your passcode for app is " . $parent['passcode'] . "   download app here https://play.google.com/store/apps/details?id=" . $this->globalSettingsAppPackageName . "&hl=en";
                $message = array();
                $message['sms_message'] = $msg;
                $message['subject'] = "Welcome " . $this->globalSettingsSystemName;
                $message['messagge_body'] = "Welcome to " . $this->globalSettingsSystemName . " Mr." . " " . $parent['father_name'] . " " . $parent['father_lname'] .
                        "<br><br> Your passcode for app is  " . $parent['passcode'] . "   download app here https://play.google.com/store/apps/details?id=" . $this->globalSettingsAppPackageName . '&hl=en';
                $message['to_name'] = $parent['father_name'] . " " . $parent['father_lname'];
                send_school_notification('new_user', $message, array($parent['cell_phone']), array($parent['email']));
            }
        } else {
            //
        }
    }

    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_name'] = 'view_applicants';
    $page_data['applicants'] = $this->Enquired_students_model->get_all_enquired_student_with_all_data();
    $page_data['page_title'] = get_phrase('list_of_applicants');
    $this->load->view('backend/index', $page_data);
}

function inventory_allotment($param1 = '', $param2 = '', $param3 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    if ($param1 == 'create') {
        $this->form_validation->set_rules('teacher', 'Teacher', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $data['class_id'] = $this->input->post('class'); // echo $data['class_id']; exit;

            $data['section_id'] = $this->input->post('section'); //echo $data['section_id']; exit;

            $teacher_id = $this->input->post('teacher');
            $teacherID = $this->Teacher_model->get_teacher_by_name($teacher_id);

            if ($teacher_id != '') {
                $data['teacher_id'] = $teacher_id;
            } else {
                $data['teacher_id'] = '';
            }
            $data['product_id'] = $param2; //echo $data['product_id']; exit;
            $allotment_id = $this->Inventory_allotment_model->add($data);
            //echo $allotment_id; exit;
            if ($allotment_id == TRUE) {
                $data1['status'] = "Alloted";
                $product_id = array('product_id' => $param2);
                $product = $this->Inventory_product_model->updatebyId($data1, $product_id);
                $this->Inventory_product_history_model->add(array('product_id' => $param2, 'current_history_type' => 1, 'added_on' => date('y-m-d H:i:s'), 'history_type_id' => $allotment_id));
                if ($product == TRUE) {
                    $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
                } else {
                    $this->session->set_flashdata('flash_message', get_phrase('error_while_adding_data'));
                }
            } else {
                $this->session->set_flashdata('flash_message', get_phrase('error_while_adding_data'));
            }
            //echo json_encode($valid);
            redirect(base_url() . 'index.php?school_admin/manage_product/', 'refresh');
        } else {
            $this->session->set_flashdata('flash_message_error', validation_errors());
            redirect(base_url() . 'index.php?school_admin/inventory_add_allotment/' . $param2, 'refresh');
        }
    }
}

function inventory_add_allotment() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $id = $this->uri->segment(3);
    $page_data = $this->get_page_data_var();
    $page_data['product'] = $this->Inventory_product_model->get_By_Id($id);
    $page_data['classes'] = $this->Class_model->get_data_by_cols('*', array(), 'result_array', array('name_numeric' => 'asc'));

    $page_data['page_name'] = 'inventory_add_allotment';
    $page_data['page_title'] = get_phrase('add_on_priority');
    $this->load->view('backend/index', $page_data, $id);
}

function admission_form() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_name'] = 'admission_form';
    $page_data['page_title'] = get_phrase('admission_form');
    $this->load->view('backend/index', $page_data);
}

function get_mysql_date_formate_from_raw($data) {
    $dateDataArr = explode('.', $data);
    //echo count($dateDataArr);
    if (count($dateDataArr) != 3) {
        return '';
    } elseif (strlen($dateDataArr[2]) != 4) {
        return '';
    } elseif (strlen($dateDataArr[1]) != 2) {
        return '';
    } elseif (strlen($dateDataArr[0]) != 2) {
        return '';
    } elseif ($dateDataArr[0] < 0 || $dateDataArr[0] > 31) {
        return '';
    } elseif ($dateDataArr[1] < 0 || $dateDataArr[1] > 12) {
        return '';
        //} elseif ($dateDataArr[2] > (date('Y') - 1)) { echo $dateDataArr[2].'<br>'; echo date('Y') - 1;echo '<br>';die('G');
        // return '';
    } else {
        return $dateDataArr[2] . '-' . $dateDataArr[1] . '-' . $dateDataArr[0];
    }
}

function manage_admission($param1 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $class_array = $this->Class_model->get_class_array();
    $page_data = $this->get_page_data_var();
    if ($param1 == 'enroll_students') {
        //pre($this->input->post());die;    
        $this->load->library('Fi_functions');
        $student_id = $this->input->post('student_id');
        $class_id = $this->input->post('enroll_class');
        $section_id = $this->input->post('section_id');
        $grade = $this->input->post('grade');
        $transport = $this->input->post('transport');
        $route_id = $this->input->post('route_id');
        if (!empty($student_id)) {
            //echo '<pre>--';print_r($_POST);exit;
            $condition = array('student_id' => $student_id);
            $data_array = array('class_id' => $class_id, 'section_id' => $section_id);
            $this->Student_model->update_enroll($data_array, $condition);
            $data_array1 = array('performance' => $grade);

            $stud_image = false;
            if ($_FILES['userfile']['name'] != '') {
                $img = $_FILES['userfile']['name'];
                $img = explode(".", $img);
                $stud_image = $student_id . "." . end($img);
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $stud_image);
                copy('uploads/student_image/' . $stud_image, 'fi/sysfrm/uploads/user-pics/' . $stud_image);
                $data_array1 = array('stud_image' => $stud_image);
            }

            $this->Student_model->update_student($data_array1, $condition);
            /*             * ********************************student add start in fi ******************************** */
            $student_det = $this->Student_model->get_student_details($student_id);
            if (!empty($student_det)) {
                if ($stud_image)
                    $data3['img'] = $stud_image;

                $data3['id'] = $student_det->student_id;
                $data3['account'] = $student_det->name;
                $data3['fname'] = '';
                $data3['company'] = $student_det->father_name . " " . $student_det->father_lname;
                $data3['lname'] = $student_det->lname;
                $data3['gid'] = $student_det->class_id;
                $data3['section_id'] = $section_id;
                $data3['email'] = $student_det->email;
                $data3['address'] = ($student_det->address == "") ? "dummy addrress" : $student_det->address;
                $data3['phone'] = ($student_det->phone == "") ? 'dummy phone' : $student_det->phone;
                $data3['city'] = ($student_det->location == "") ? 'dummy city' : $student_det->location;
                $data3['password'] = $student_det->student_pass;
                $this->Student_model->create_finance_customer_account($data3);
            } else {
                $finance_error_msg = get_phrase('student_details_not_found');
            }

            /*             * ********************************student add end in fi******************************** */
            //$this->fi_functions->save_invoice($student_id[$i]);
            $running_year = $this->globalSettingsRunningYear;
            $tution_fee_det = $this->fi_functions->get_fee_detailsbygroup($class_id);
            if ($tution_fee_det)
                $tution_fee_id = $tution_fee_det['id'];
            else
                $tution_fee_id = 0;

            $scholarship_id = $this->input->post('scholarship_id');
            $hostfee_inst_type = $this->input->post('hostfee_inst_type');
            $transpfee_inst_type = $this->input->post('transpfee_inst_type');
            $tutionfee_inst_type = $this->input->post('tutionfee_inst_type');
            $dormitory_fee_id = $this->input->post('dormitory_fee_id');
            $transport_fee_id = $this->input->post('transport_fee_id');
            
            if(!sett('new_fi')){
                $finance_det = array(
                    'student_id' => $student_id,
                    'academic_year' => $running_year,
                    'tution_fee_id' => ($tution_fee_id != '' ? $tution_fee_id : 0),
                    'trans_fee_id' => ($transport_fee_id != '' ? $transport_fee_id : 0),
                    'hostel_fee_id' => ($dormitory_fee_id != '' ? $dormitory_fee_id : 0),
                    'scholarship_id' => ($scholarship_id != '' ? $scholarship_id : 0),
                    'tutionfee_inst_type' => ($tutionfee_inst_type != '' ? $tutionfee_inst_type : 0),
                    'transpfee_inst_type' => ($transpfee_inst_type != '' ? $transpfee_inst_type : 0),
                    'hostfee_inst_type' => ($hostfee_inst_type != '' ? $hostfee_inst_type : 0),
                    'created_by' => $this->session->userdata('login_user_id')
                );

                $finance_stud_config = $this->Student_model->add_student_fee_det($finance_det);
            }else{
                $this->load->model('fees/Fees_model');
                $fee_stu_config = array(
                    'student_id' => $student_id,
                    'running_year' => _getYear(),
                    'school_term_id' => $tutionfee_inst_type,
                    'room_id' => $dormitory_fee_id,
                    'hostel_term_id' => $hostfee_inst_type,
                    'route_stop_id' => $transport_fee_id,
                    'transport_term_id' => $transpfee_inst_type,
                    'scholarship_id' => $scholarship_id,
                    'school_id' => _getSchoolid(),
                    'created' => date('Y-m-d H:i:s')
                );
                $this->Fees_model->save_stu_config($fee_stu_config);
            }

            
            $this->Enquired_students_model->update_enquiry(array('counselling' => '1'), $condition);

            //creating invoice for student tution fee,hostel fee,hostelfee
            $this->generate_admission_invoice($student_id);
            //Sending message after student submission
            $parentDetail = $this->Student_model->getParentOfStudent($student_id);
            //echo '<pre>';print_r($parentDetail);exit;
            $msg = "Congratulations Mr. " . $parentDetail[0]['father_name'] . " admission process for your ward " . $student_det->name . " has been completed successfully!";
            $message = array();
            $message['sms_message'] = $msg;
            $message['subject'] = "Welcome " . $this->globalSettingsSystemName;
            $message['messagge_body'] = $msg = "Congratulations Mr. " . $parentDetail[0]['father_name'] . " admission process for your ward " . $student_det->name . " has been completed successfully!";
            send_school_notification('new_user', $message, array($parentDetail[0]['cell_phone']), array($parentDetail[0]['parent_email']));

            $this->session->set_flashdata('flash_message', get_phrase('changes_saved_successfully'));
        } else {
            $this->session->set_flashdata('flash_message', "There is not student for enrolement");
        }
        redirect(base_url('index.php?school_admin/manage_admission/'));
    }
    $page_data['class_array'] = $class_array;
    $page_data['page_name'] = 'manage_admission';
    $page_data['page_title'] = get_phrase('manage_admission');
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $this->load->view('backend/index', $page_data);
}

function get_students_for_admission($class_id_from, $section_id_from = "", $class_id_to = "", $section_id_to = "", $running_year = "", $promotion_year = "") {
    $page_data = $this->get_page_data_var();
    $page_data['class_id_from'] = $class_id_from;
    $page_data['section_id_from'] = $section_id_from;
    $page_data['class_id_to'] = $class_id_to;
    $page_data['section_id_to'] = $section_id_to;
    $page_data['running_year'] = $running_year;
    $page_data['promotion_year'] = $promotion_year;
    $appliedStudentsList = $this->Enquired_students_model->get_data_by_cols("*", array('class_id' => $class_id_from, 'form_submitted' => "1", 'counselling' => "0"), "result_array");

    $hostelArr = $this->Dormitory_model->get_data_by_cols('*', array(), 'result_array');
    $classDataArr = $this->Class_model->get_data_by_cols("*", array('class_id' => $class_id_from));
    $allClassDataArr = $this->Class_model->get_data_by_cols("*", array(), "result_array");
    $page_data["class_name"] = $classDataArr[0]->name;
    $page_data["classes_list"] = $allClassDataArr;
    $page_data['hostels'] = $hostelArr;
    $page_data['total_notif_num'] = $this->get_no_of_notication();

    $page_data['applied_students_list'] = $appliedStudentsList;

    $this->load->view('backend/school_admin/admission_selector', $page_data);
}

/**
 * 
 * @param type $param1
 */
function view_admission_form($param1 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $this->load->model("Student_model");
    $this->load->model("Subject_model");
    $this->load->model("Guardian_model");
    //echo '<pre>';print_r($_POST);exit;

    $enquiredStudentsArr = $this->Enquired_students_model->get_data_by_cols('*', array("enquired_student_id" => $param1));
    $page_data['student_data'] = $enquiredStudentsArr[0];
    $studentId = $enquiredStudentsArr[0]->student_id;
    $form_name = $this->input->post('admit_student');
    if ($form_name == 'admit_student1') {

        $this->form_validation->set_rules('student_fname', 'Student First Name', 'required');
        //$this->form_validation->set_rules('student_lname', 'Student  Last Name', 'required');
        $this->form_validation->set_rules('father_fname', 'Father First Name', 'required');
        //$this->form_validation->set_rules('father_lname', 'Father Last Name', 'required');
        $this->form_validation->set_rules('mother_fname', 'Mother First Name', 'required');
        //$this->form_validation->set_rules('mother_lname', 'Mother Last Name', 'required');
        $this->form_validation->set_rules('class', 'Class', 'required|callback_class_max_capacity');
        $this->form_validation->set_rules('previous_class', 'Previous Class', 'required');
        if ($this->input->post('previous_class') > 0)
            $this->form_validation->set_rules('previous_school', 'Previous School', 'required');
        //$this->form_validation->set_rules('previous_result', 'Previous Result', 'required');
//        $this->form_validation->set_rules('category', 'Category', 'required');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('birthday', 'Date of Birth', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('email_id', 'User Email', 'trim|valid_email');
        $this->form_validation->set_rules('user_mobile', 'Phone Number', 'required|numeric|max_length[11]');
        $this->form_validation->set_rules('emergency_contact_number', 'Emeregency Contact Number', 'required|numeric|max_length[11]');
        //$this->form_validation->set_rules('advance', 'Advance payed or not', 'required');
        //$this->form_validation->set_rules('annual_income', 'Annual_salary', 'required');

        if ($this->input->post('medical'))
            $this->form_validation->set_rules('disease', 'Disease', 'required');
        if ($this->input->post('disease') == 'Other')
            $this->form_validation->set_rules('reason', 'Disease Specify', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_message', validation_errors());
            redirect(base_url() . 'index.php?school_admin/view_admission_form/' . $param1);
        } else {
            $parentIdArray = array();
            $parentIdArray = $this->Student_model->get_data_by_cols('*', array('student_id' => $studentId), 'result_type');
            if (empty($parentIdArray)) {
                $this->session->set_flashdata('flash_message', "Invalid parent data or garbage data for update.");
                redirect(base_url() . 'index.php?school_admin/student_enquired_view/');
            }
            $stud_details['student_fname'] = $this->input->post('student_fname');
            $stud_details['student_lname'] = $this->input->post('student_lname');
            $stud_details['previous_class'] = $this->input->post('previous_class');
            $stud_details['previous_school'] = $this->input->post('previous_school');
            $stud_details['caste_category'] = $this->input->post('category');
            $stud_details['class_id'] = $this->input->post('class');
            $bday = $this->input->post('birthday');
            $stud_details['birthday'] = date('Y-m-d', strtotime($bday));
            $stud_details['gender'] = $this->input->post('gender');
            $stud_details['address'] = $this->input->post('address');
            $stud_details['parent_fname'] = $this->input->post('father_fname');
            $stud_details['parent_lname'] = $this->input->post('father_lname');
            $stud_details['mother_fname'] = $this->input->post('mother_fname');
            $stud_details['mother_lname'] = $this->input->post('mother_lname');
            $stud_details['user_email'] = $this->input->post('email_id');
            $stud_details['mobile_number'] = $this->input->post('user_mobile');
            $stud_details['transport'] = $this->input->post('transport');
            $stud_details['form_submitted'] = "1";
            $stud_details['student_id'] = $studentId;
            $stud_details['create_date'] = date('Y-m-d H:i:s');
            //print_r($stud_details); 
            //Med Details
            $stud_details_med['medical_pblm'] = $this->input->post('medical');
            $stud_details_med['medical_pblm_reason'] = $this->input->post('reason');
            $stud_details_med['name'] = $this->input->post('student_fname');
            $stud_details_med['mname'] = $this->input->post('student_lname');
            $stud_details_med['interest_one'] = $this->input->post('interest_one');
            $stud_details_med['interest_two'] = $this->input->post('interest_two');
            $stud_details_med['interest_three'] = $this->input->post('interest_three');
            $stud_details_med['emergency_contact_number'] = $this->input->post('emergency_contact_number');
            $stud_details_med['family_type'] = $this->input->post('family');
            $stud_details_med['mother_tounge'] = $this->input->post('language');
            $stud_details_med['city'] = $this->input->post('city');
            $stud_details_med['caste_category'] = $this->input->post('category');

            $parent_details['father_qualification'] = $this->input->post('education');
            $parent_details['father_school'] = $this->input->post('school');
            $parent_details['father_profession'] = $this->input->post('occupation');
            $parent_details['father_department'] = $this->input->post('department');
            $parent_details['father_designation'] = $this->input->post('designation');
            $parent_details['father_income'] = $this->input->post('annual_income');
            //$parent_details['emergency_contact_number']=$this->input->post('emergency');
            $parent_details['mother_quaification'] = $this->input->post('mother_education');
            $parent_details['mother_school'] = $this->input->post('mother_school');
            $parent_details['mother_profession'] = $this->input->post('mother_occupation');
            $parent_details['mother_department'] = $this->input->post('mother_department');
            $parent_details['mother_designation'] = $this->input->post('mother_designation');
            $parent_details['mother_income'] = $this->input->post('mother_annual_income');
            $parent_details['mother_email'] = $this->input->post('mother_email_id');
            $parent_details['mother_mobile'] = $this->input->post('mother_user_mobile');
            $parent_details['address'] = $this->input->post('address');
            $parent_details['father_name'] = $this->input->post('father_fname');
            $parent_details['father_lname'] = $this->input->post('father_lname');
            $parent_details['mother_name'] = $this->input->post('mother_fname');
            $parent_details['mother_lname'] = $this->input->post('mother_lname');
            $parent_details['email'] = $this->input->post('email_id');
            //for ($i = 0; $i < count($student_id); $i++) {
            $siblings_details['student_id'] = $studentId;
            $siblings_name = $this->input->post('siblings_name');
            $siblings_age = $this->input->post('siblings_age');
            $siblings_school_name = $this->input->post('siblings_school_name');
            $siblings_class = $this->input->post('siblings_class');
            $siblings_realtion = $this->input->post('siblings_realtion');
            $siblingsDetailsArr = array();
            for ($s = 0; $s < 2; $s++) {
                $siblings_details = array();
                if ($siblings_age[$s] != "" && $siblings_name[$s] != "" && $siblings_realtion[$s] != "") {
                    $siblings_details['name'] = $siblings_name[$s];
                    $siblings_details['student_id'] = $studentId;
                    $siblings_details['age'] = $siblings_age[$s];
                    $siblings_details['school'] = $siblings_school_name[$s];
                    $siblings_details['class'] = $siblings_class[$s];
                    $siblings_details['relation_ship'] = $siblings_realtion[$s];
                    //$siblings_details['create_time'] = date('Y-m-d H:i:s');
                    $siblingsDetailsArr[] = $siblings_details;
                }
            }

            //add Guardian details
            $parent_id = $parentIdArray[0]['parent_id'];
            $data_guardian['guardian_fname'] = $this->input->post('guardian_fname');
            $data_guardian['guardian_lname'] = $this->input->post('guardian_lname');
            //$data_guardian['guardian_profession'] = $this->input->post('guardian_profession');
            $data_guardian['guardian_address'] = $this->input->post('guardian_address');
            $data_guardian['guardian_email'] = $this->input->post('guardian_email');
            $data_guardian['guardian_relation'] = $this->input->post('guardian_relation');
            $data_guardian['guardian_emergency_number'] = $this->input->post('guardian_emergency_number');
            $data_guardian['guardian_isActive'] = '1';
            $data_guardian['student_id'] = $studentId;
            $data_guardian['parent_id'] = $parent_id;
            $data_guardian['guardian_change_date'] = date('Y-m-d H:i:s');
//pre($data_guardian); die;
            if (!empty($siblings_details))
                $this->Enquired_students_model->save_siblings_batch($siblingsDetailsArr, $studentId);

            $this->Enquired_students_model->update_enquiry($stud_details, array('student_id' => $studentId));
            $enroll_data = $this->Enquired_students_model->get_data_by_cols('guardian_id', array('student_id' => $studentId), 'result_type');
//            pre($guardian_id); die;
            $guardian_id = $enroll_data[0]['guardian_id'];
            $condition = array('parent_id' => $parent_id);
            $condition1 = array('guardian_id' => $guardian_id);
//            pre($condition);
//            pre($condition1);die;
            if ($this->Parent_model->update_parent_of_students_enquired($parent_details, $condition)) {
                $this->Guardian_model->update_guardian($data_guardian, $condition1);
                $this->Student_model->update_student($stud_details_med, array("student_id" => $studentId));

                //Add Clinical Record
                if ($this->input->post('medical')) {
                    $clinical_record = array('user_id' => $studentId,
                        'desease_title' => $this->input->post('disease'),
                        'description' => $this->input->post('reason'),
                        'status' => 1);
                    $this->Student_model->add_clinical_record($clinical_record);
                }
                //move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/admitted_students/' . $studentId . '.jpg');
                $this->session->set_flashdata('flash_message', get_phrase('changes_saved_successfully'));
                redirect(base_url() . 'index.php?school_admin/student_enquired_view/');
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('changes_are_not_saved'));
            }
        }
    }

    $this->load->model("Language_model");
    $languages = $this->Language_model->get_language();
    $NewArray = array();
    for ($i = 2; $i < 23; $i++) {
        $NewArray[$i] = array_merge($languages[$i]);
    }
    $page_data['language'] = $NewArray;

    $guardian_details = array();
    $guardian_details = $this->Guardian_model->get_data_by_cols('*', array('guardian_id' => $enquiredStudentsArr[0]->guardian_id), 'result_array');

    $studentDetailsArr = array();
    $parrentDetailsArr = array();
    $siblingsDetailsArr = array();
    if ($studentId != "") {
        $studentDetailsArr = $this->Student_model->get_data_by_cols('*', array('student_id' => $enquiredStudentsArr[0]->student_id), 'result_array');
        if (empty($studentDetailsArr)) {
            $page_data['studentDetailsArr'] = $studentDetailsArr;
        } else {
            $page_data['studentDetailsArr'] = $studentDetailsArr[0];
        }
        $parrentDetailsArr = $this->Student_model->get_parrent_detais($enquiredStudentsArr[0]->student_id);
        if (empty($studentDetailsArr)) {
            $page_data['parrentDetailsArr'] = $parrentDetailsArr;
        } else {
            $page_data['parrentDetailsArr'] = $parrentDetailsArr[0];
        }
        $siblingsDetailsArr = $this->Student_model->get_data_by_cols_table("siblings", "*", array("student_id" => $studentId), "result_array");
        if (empty($siblingsDetailsArr)) {
            $page_data['siblingsDetailsArr'] = $siblingsDetailsArr;
        } else {
            $page_data['siblingsDetailsArr'] = $siblingsDetailsArr;
        }
    } else {
        $page_data['studentDetailsArr'] = $studentDetailsArr;
        $page_data['parrentDetailsArr'] = $parrentDetailsArr;
        $page_data['siblingsDetailsArr'] = $siblingsDetailsArr;
    }

    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['inquery_student_id'] = $param1;
    $page_data['guardian_details'] = $guardian_details[0];
    $page_data['classes'] = $this->Class_model->get_data_by_cols("*", array(), "result_array");
    $page_data['page_name'] = 'view_admission_form';
    $page_data['page_title'] = get_phrase('view_admission_form');
    $this->load->view('backend/index', $page_data);
}

function class_max_capacity($class_id) {
    $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
    if (is_class_available_for_admission($class_id, $running_year) == 0) {
        $this->form_validation->set_message('class_max_capacity', get_phrase('maximum_capacity_of_students_exceeded!!'));
        return FALSE;
    } else {
        return TRUE;
    }
}

function counselling($param1 = '') {
    $dataArray = array('student_id' => $param1);
    //        $fees_type_amount= $this->input->post('fees_type');
    //        if ($fees_type_amount == 2000) {
    //            $fees_type = 'monthly';
    //        } else if ($fees_type_amount == 6000) {
    //            $fees_type = 'quarterly';
    //        } else if ($fees_type_amount == 12000) {
    //            $fees_type= 'halfyearly';
    //        } else if ($fees_type_amount == 24000){
    //            $fees_type = 'yearly';
    //        }
    /* $page_data = $this->get_page_data_var();
      $this->load->model('Invoice_model');
      $this->load->model('Enquired_students_model');
      $studentInvoiceDataArr = $this->Invoice_model->get_data_by_cols("*", $dataArray);
      //pre($studentInvoiceDataArr);die;
      if (empty($studentInvoiceDataArr)) {
      $this->Invoice_model->add_fees_type($dataArray, array('fees_type' => $fees_type_amount));
      } */
    //$type['type'] = $this->Invoice_model->get_typeById($dataArray);
    /* if ($fees_type == 'monthly') {
      $msg = "Your fees type is Monthly so you need to pay 2000rs monthly";
      } else if ($fees_type == 'quarterly') {
      $msg = "Your fees type is Quarterly so you need to pay 6000rs quarterly";
      } else if ($fees_type == 'halfyearly') {
      $msg = "Your fees type is Halfyearly so you need to pay 12000rs halfyearly";
      } else if ($fees_type == 'yearly'){
      $msg = "Your fees type is Yearly so you need to pay 24000rs yearly";
      } */
    //die($msg);die;
    $row = $this->Student_model->get_parent_id_by_student($param1);
    $student = $this->Student_model->get_students_records($dataArray);
    $main_date = $this->input->post('date');
    $date = date('Y-m-d', strtotime($main_date));
    $time = date('H:i', strtotime($main_date)); //$this->input->post('time');
    $documents = unserialize(DOCUMENTS);
    $parent = $this->Parent_model->get_parent_record(array('parent_id' => $row[0]['parent_id']));
    if (str_word_count($student[0]['name']) > 1) {
        $studentName = $student[0]['name'];
    } else {
        $studentName = $student[0]['name'] . " " . $student[0]['lname'];
    }
    $msg = "To know more about fees, please follow the link." . base_url() . "uploads/fees.pdf";
    $message = array();
    $message['sms_message'] = "Congratulations Mr. " . $parent->father_name . " your child " . $studentName . "'s admission form is processed. Kindly report at " . $date . ' ' . $time . " for counselling.";
    $message['subject'] = "Welcome " . $this->globalSettingsSystemName;
    $message['messagge_body'] = "Congratulations Mr. " . $parent->father_name .
            " your child " . $studentName . "'s admission form is processed. Please bring your child with all necessary documents like 
            " . implode(' , ', $documents) . " for counselling session on " .
            $date . " at " . $time . " " . "and " . $msg;
    $message['to_name'] = $parent->father_name . " " . $parent->father_lname;
    send_school_notification('new_user', $message, array($parent->cell_phone), array($parent->email));

    $this->session->set_flashdata('flash_message', get_phrase('message_sent_successfully'));
    redirect(base_url() . 'index.php?school_admin/student_enquired_view/');
}

function student_overview() {
    $this->load->model("Invoice_model");
    $page_data = $this->get_page_data_var();
    $page_data['count_enquire_students'] = $this->Enquired_students_model->get_count();
    $page_data['enquired_students'] = $this->Enquired_students_model->get_all();
    $page_data['count_enquire_students'] = $this->Enquired_students_model->get_count();
    $page_data['count_enroll_students'] = $this->Student_model->get_count_enroll();
    if(!sett('new_fi')){
        $this->load->model('fees_model');

    }else{
        $page_data['count_amount_collected'] = $this->Student_model->get_count_amount();
        //echo'<pre>';print_r($page_data['count_enroll_students']);exit;
        //echo json_encode($count_amount_collected);exit;

        $page_data['total_notif_num'] = $this->get_no_of_notication();
        //echo '<pre>';print_r($page_data['total_notif_num'] );exit;
        $page_data['page_name'] = 'student_overview';
        $page_data['page_title'] = get_phrase('student_enquiry_and_enroll_overview');

        if (count($page_data['enquired_students'])) {
            foreach ($page_data['enquired_students'] as $k => $enquired):
                if (!empty($enquired->student_id)) {
                    $amountArr = $this->Invoice_model->get_student_invoice_details($enquired->student_id);

                    if (empty($amountArr)) {
                        $page_data['enquired_students'][$k]->amount = 0;
                        $page_data['enquired_students'][$k]->amount_paid = 0;
                        $page_data['enquired_students'][$k]->diff_amount = 0;
                    } else {
                        $page_data['enquired_students'][$k]->amount = $amountArr->amount;
                        $page_data['enquired_students'][$k]->amount_paid = $amountArr->amount_paid;
                        $page_data['enquired_students'][$k]->diff_amount = ($amountArr->amount - $amountArr->amount_paid);
                    }
                }
            endforeach;
        }
    }
    $this->load->view('backend/index', $page_data);
}

function regenerate_passcode_parent($param1 = '') {
    //$passcode = "spa" . mt_rand(10000000, 99999999);
    $passcode = create_passcode('parent');
    $data['passcode'] = ($passcode != 'invalid') ? $passcode : '';
    $data['password'] = ($passcode != 'invalid') ? sha1($passcode) : '';
    $dataArray = array('parent_id' => (int) $param1);
    $this->Parent_model->update_parent(array('passcode' => $data['passcode'], 'password' => $data['password']), $dataArray);
    $parentDataArr = $this->Parent_model->get_data_by_cols('cell_phone,father_name,passcode,email', $dataArray);
    $parent = $parentDataArr[0];
    $message = "Welcome Mr " . $parent->father_name . " your passcode for app is " . $data['passcode'] . "   download app here https://play.google.com/store/apps/details?id=" . $this->globalSettingsAppPackageName . "&hl=en";
    $phone_number = array($parent->cell_phone);
     if ($phone_number != "") {
         echo 
        send_school_notification('update_passcode', $message, $phone_number);
    }
    if ($parent->email != "") {
        $subject = "Passcode Updated for " . $this->globalSettingsSystemName;
        $body = $message;
        $to_name = $parent->father_name . "(" . $parent->email . ")";

        $message = array(
            'subject' => $subject,
            'messagge_body' => $body,
            'to_name' => $to_name
        );
        $email = array($parent->email);
        send_school_notification('update_passcode', $message, '', $email);
    }

    $this->session->set_flashdata('flash_message', get_phrase('message_sent_successfully'));
    redirect(base_url() . 'index.php?school_admin/parent/', 'refresh');
}

function student_upload() {
    $this->load->library('PHPExcel');
    $this->load->library('PHPExcel/IOFactory');
    $config['upload_path'] = './csv_uploads/';
    $config['allowed_types'] = 'xlsx|csv|xls';
    $config['max_size'] = '10000';
    $config['overwrite'] = true;
    $config['encrypt_name'] = FALSE;
    $config['remove_spaces'] = TRUE;
    $this->load->library('upload', $config);
    $this->upload->initialize($config);

    if (!is_dir('csv_uploads')) {
        mkdir('./csv_uploads', 0777, true);
    }
}

function student_bulk_upload_error() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_title'] = get_phrase('student_bulk_upload_error');
    $page_data['page_name'] = 'student_bulk_upload_error';
    $this->load->view('backend/index', $page_data);
}

/* function display_bulk_upload_errors() {
  $error = TRUE;
  if ($error) {
  $file_name = 'uploads/student_bulk_upload_error_details.log';
  $error_messages = file_get_contents($file_name);
  $messages = json_decode($error_messages, true);
  }
  } */

function display_bulk_upload_errors() {
    $error = TRUE;
    if ($error) {
        $file_name = 'uploads/student_bulk_upload_error_details.log';
        $error_messages = file_get_contents($file_name);
        $messages = json_decode($error_messages);
    }
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['messages'] = $messages;
    $page_data['page_title'] = get_phrase('display_upload_errors');
    $page_data['page_name'] = 'display_bulk_upload_errors';
    $this->load->view('backend/index', $page_data);
}

/* * *****************NOTIFICATION DASHBOARD******************************** */

function notification_dashboard() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');

    /*     * *******************loading models********************************** */
    $this->load->model("Notification_model");
    $records = array();
    $records = $this->Notification_model->get_data_by_cols("*", array(), 'result_array');
    /*     * *******************inserting to db********************************* */
    $submit = $this->input->post('submit');
    $input_values = $this->input->post();
    $page_data = $this->get_page_data_var();
    if ($submit == 'submit') {
        foreach ($records as $key => $value) {
            $activity = $value['activity'];

            $sms = (isset($input_values['sms_' . $activity]) ? $input_values['sms_' . $activity] : 0);
            $email = (isset($input_values['email_' . $activity]) ? $input_values['email_' . $activity] : 0);
            $push = (isset($input_values['push_' . $activity]) ? $input_values['push_' . $activity] : 0);
            $link = ($input_values['link_' . $activity] != '' ? $input_values['link_' . $activity] : 'view_notifications');
            $data = array('sms' => $sms, 'push_notify' => $push, 'email' => $email, 'notification_link' => $link);
            $update_result = $this->Notification_model->update_data($data, array('activity' => $activity));
        }
    }
    /*     * **************end of inserting to db******************************* */

    if (isset($update_result)) {
        $this->session->set_flashdata('flash_message', get_phrase('notification_dashboard_updated'));
        redirect(base_url() . 'index.php?school_admin/notification_dashboard', 'refresh');
    }
    $messages = array('class' => 1);

    $records = $this->Notification_model->get_data_by_cols("*", array(), 'result_array');
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['messages'] = $messages;
    $page_data['page_title'] = get_phrase('notification_dashboard');
    $page_data['page_name'] = 'notification_dashboard';

    $page_data['records'] = $records;
    $this->load->view('backend/index', $page_data);
}

function checkValidPhoneEmail($data, $type) {
    if ($type == 'email') {
        if (filter_var($data, FILTER_VALIDATE_EMAIL)) {
            return 'ok';
        } else {
            return ' an email address like name@doamin.tld. ';
        }
    } else if ($type == 'phone') {
        if (!ctype_digit($data)) {
            return ' a phone number only content 0 to 9 digit';
        } else {
            if (strlen($data) < 11 && strlen($data) > 6) {
                return 'ok';
            } else {
                return ' a phone number only content 7 to 10 chaacters';
            }
        }
    }
}

function download_student_bulk_upload_error_file() {
    $this->load->helper('download');
    $data = file_get_contents('uploads/student_bulk_upload_error_details_for_excel_file.xlsx');
    $name = 'student_bulk_upload_error_details_for_excel_file.xlsx';
    force_download($name, $data);
}

function ajax_check_unread_message() {
    $cUserId = $this->input->post('cUserId', TRUE);
    $content = get_unread_message($cUserId, 'admin');
    echo $content;
    die;
}

function guardian_details($param1 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $this->load->model("Guardian_model");
    $this->load->model("Enroll_model");
    $this->load->model("Guardian_model");
    $page_data['class_id'] = $param1;
    $page_data['classes'] = $this->Class_model->get_class_array();
    $page_data['sections'] = $this->Class_model->get_section_array(array('class_id' => $param1));
    $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
    $students_class = $this->Enroll_model->get_data_by_cols('student_id', array('class_id' => $param1, 'year' => $running_year, 'condition_type' => 'and'));
    //print_r($students_class);
    $array = json_decode(json_encode($students_class), True);

    foreach ($students_class as $value) {
        $array[] = $value->$students_class;
        //print_r($array);
    }
    $guardian_details = $this->Guardian_model->get_data_by_cols('*', array('student_id' => $array['student_id'], 'condition_type' => 'in'));

    $page_data['guardian_details'] = $guardian_details;
    //endforeach;
    //print_r($guardian_details);
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['students'] = $students_class;
    $page_data['page_title'] = get_phrase('guardian_details');
    $page_data['page_name'] = 'guardian_details';
    $this->load->view('backend/index', $page_data);
}

/* * *****************Send push notification******************************* */

function send_push_notification() {

    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    /*     * *******************loading models********************************** */
    $this->load->model("Notification_model");
    $this->load->model("Exam_model");

    $records = $this->Exam_model->get_data_by_cols('*', array('status' => '1'), 'result_array');
    $event = $this->input->post('event');
    $results = $this->Notification_model->get_data_by_cols('push_notify', array('activity' => $event), 'result_array');

    /*     * *********************if push notification set********************** */
    foreach ($results as $res) {
        if ($res['push_notify'] == 1) {
            $count_rows = count($records);
            if (($count_rows > 0)) {
                echo "OK";
            }
        }
    }
}

/* * *****************Ajax fun for updating table ****************************** */

function update_table_after_push() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model("Exam_model");
    $records = $this->Exam_model->get_data_by_cols('*', array('status' => '1'), 'result_array');
    $data = array();
    $data['status'] = -1;
    $this->Exam_model->update_data($data, array('exam_id' => $records[0]['exam_id']));
}

/* * ************************Ajax func sending notification***************** */

function send_exam_notification() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    /*     * *******************loading models************************************ */
    $this->load->model("Notification_model");
    $this->load->model("Parent_model");
    $this->load->model("Setting_model");

    $exam_name = $this->input->post('exam_name');
    $exam_date = $this->input->post('exam_date');
    $comment = $this->input->post('comment');
    $event_name = $this->input->post('event');

    /*     * ***********************if email set******************************** */
    $settingsDataArr = $this->Setting_model->get_data_by_cols('description', array('condition_type' => 'in', 'condition_in_col' => 'type', 'condition_in_data' => 'system_name,system_email,address,system_title,facebook_page,twitter_page,linkedin,pininterest'));

    $system_name = $settingsDataArr[0]->description;
    $from = $settingsDataArr[3]->description;
    $address = $settingsDataArr[2]->description;
    $system_title = $settingsDataArr[1]->description;
    $facebook_page = $settingsDataArr[4]->description;
    $twitter_page = $settingsDataArr[5]->description;
    $linkedin = $settingsDataArr[6]->description;
    $pininterest = $settingsDataArr[7]->description;
    // print_r($settingsDataArr );

    $logo_path = base_url() . "/uploads/logo.png";
    $parents_details = $this->Parent_model->get_data_by_cols('parent_id,email,cell_phone', array('isActive' => '1'), 'result_array');
    /*     * ***************************Notification for exam starts here************************** */
    $data['values'] = array('exam_name' => $exam_name,
        'exam_date' => $exam_date,
        'comment' => $comment,
        'system_name' => $system_name,
        'from' => $from,
        'address' => $address,
        'logo_path' => $logo_path,
        'system_title' => $system_title,
        'facebook_page' => $facebook_page,
        'twitter_page' => $twitter_page,
        'linkedin' => $linkedin,
        'pininterest' => $pininterest);
    $system_name = $this->globalSettingsSystemName;

    $from = $this->globalSettingsSystemEmail;
    $sub = "Exam date declared";
    $body = $this->load->view('backend/school_admin/emails/exam_mail', $data, TRUE);
    $sms_message = $message = "Your childs exam date has been declared for " . $exam_date;
    $message = array('subject' => $sub, 'messagge_body' => $body, 'sms_message' => $sms_message);

    foreach ($parents_details as $parent_details) {
        $phone = array($parent_details['cell_phone']);
        $email = array($parent_details['email']);
        send_school_notification('exam_date', $message, $phone, $email);
    }
    $user_details['user_type'] = array('parent', 'teacher');
    send_school_notification('exam_date', $message, '', '', $user_details);


    /*     * ***************************Notification for exam ends************************** */
    echo "OK";
}

/* * *********************Ajax func for sending invoice email******************* */

function sendEmailInvoice() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    /*     * ***************************loading models************************** */
    $this->load->model("Parent_model");
    $this->load->model("Student_model");
    $data = $this->input->post('email_data');
    $student_id = $this->input->post('student_id');

    $parent_details = $this->Student_model->get_data_by_cols('parent_id', array('student_id' => $student_id), 'result_array');

    $parent_name = $this->Parent_model->get_data_by_cols('email', array('parent_id' => $parent_details[0]['parent_id']), 'result_array');
    $sub = "Fees Invoice";
    $res = send_common_mail($parent_name[0]['email'], $sub, $data, '');

    if ($res == 1) {
        echo "OK";
    } else {
        echo "NOTOK";
    }
}

function test() {
    //$fielsdString = explode(',', "name,mname,lname,sex,birthday,caste_category,class_id,section_id,roll,course,previous_school,parent_id,address,location,phone,email,passport_no,card_id,type,icard_no,place_of_birth,country,nationality");
    //pre($fielsdString);die;
    $this->load->model("Dynamic_field_model");
    $rs= $this->Dynamic_field_model->get_parent_bulk_upload();
    pre($rs);die;
    echo date('j');
    die;
    echo crypt('1234', 'ib_salt');
    die();

    $post = [
        'location' => "india",
        'cell_phone' => '7008570274',
        'message' => "testing message from api == api and final",
    ];
    // echo print_r($post);exit;
    $url = "http://".SMS_IP_ADDR."/School/index.php/?admin/send_common_sms/";

    fire_api_by_curl($url, $post);
    /* $system_name=$this->globalSettingsSMSDataArr[3]->description;
      $this->load->helper("email_helper");
      $address['email'] = "sujana@sharadtechnologies.com";
      $data             =  array();
      $body             =  $this->load->view('backend/school_admin/emails/exam_mail',$data,TRUE);
      $system_name      =  'sys';
      $from ="sharatechnologies.dubai@gmail.com";
      $sub="Test";
      $res= send_common_mail($address['email'],$from,$system_name,$sub,$body); */
    //print_r($res);
}

function clinical_records($param1 = '', $class_id = '', $section_id = '', $action = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model("Section_model");
    $this->load->model("Medical_events_model");
    $formSubmit = $this->input->post('get_list');
    $page_data = $this->get_page_data_var();
    if ($formSubmit == '') {
        $formSubmit = $action;
    }
    if ($formSubmit == 'get_list') {
        $class_idpost = $this->input->post('class_id');
        if ($class_idpost == '') {
            $class_id = $class_id;
        } else {
            $class_id = $class_idpost;
        }

        $section_idpost = $this->input->post('from_section_id');

        if ($section_idpost == '') {
            $section_id = $section_id;
        } else {
            $section_id = $section_idpost;
        }

        $student_details = array();
        $dataArray = array(
            'class_id' => $class_id,
            'section_id' => $section_id
        );
        $student_details = $this->Student_model->get_student_details('', $section_id);

        $student_record = array();

        foreach ($student_details as $key => $det):
            $student_record[$det['student_id']] = array();
            $student_record[$det['student_id']]['details'] = $det;
            $student_record[$det['student_id']]['medical_records'] = $this->Medical_events_model->get_data_by_cols('*', array('user_id' => $det['student_id'], 'status' => 1));
        endforeach;
        $page_data['student_details'] = $student_record;
        $page_data['class_id'] = $class_id;
        $page_data['section_id'] = $section_id;
        $page_data['sections'] = $this->Section_model->get_data_by_cols('*', array("class_id" => $class_id));
    }
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['formSubmit'] = $formSubmit;
    $page_data['classes'] = $this->Class_model->get_class_array();
    $page_data['page_title'] = get_phrase('clinical_records');
    $page_data['page_name'] = 'view_medical_records';
//        print_r($page_data);die();

    if ($param1 == 'add') {
        $this->session->set_flashdata('flash_message', get_phrase('medical_record_added_successfully!!'));
    } else if ($param1 == 'deleted') {
        $this->session->set_flashdata('flash_message_error', get_phrase('medical_record_deleted_successfully!!'));
    }
//    else {
//        $this->session->set_flashdata('flash_message_error', '');
//    }
    $this->load->view('backend/index', $page_data);
}

function clinical_histroy($student_id = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model("Patient_model");
    $this->load->model("Medical_events_model");
    $clinic_history = $this->Patient_model->get_data_by_cols('*', array('student_id' => $student_id), 'result_array');
    $student_medical_history = $this->Medical_events_model->get_data_by_cols('*', array('student_id' => $student_id), 'result_array');
    $count_arr = count($student_medical_history);
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['count_arr'] = $count_arr;
    $page_data['student_medical_history'] = $student_medical_history;
    $page_data['clinic_history'] = $clinic_history;
    $page_data['page_title'] = get_phrase('clinical_histroy');
    $page_data['page_name'] = 'clinical_histroy';
    $this->load->view('backend/index', $page_data);
}

function fix_clinical_appointment($param1 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model("Medical_events_model");
    $formSubmit = $this->input->post('save_details');
    $page_data = $this->get_page_data_var();
    if ($formSubmit == 'save_details') {
        $apppointment['title'] = $this->input->post('appointment_type');
        $date = date('Y-m-d', strtotime($this->input->post('date')));
        $apppointment['date'] = date('Y-m-d', strtotime($date));
        $apppointment['time'] = $this->input->post('time');
        $apppointment['prescription'] = $this->input->post('prescription');
        $apppointment['diagnosis'] = $this->input->post('diagnosis');
        $apppointment['comments'] = $this->input->post('comments');
        $apppointment['student_id'] = $param1;
        if ($this->Medical_events_model->save_appointment($apppointment)) {
            $this->session->set_flashdata('flash_message', get_phrase('appointment_fixed_succesfully!!'));
            redirect(base_url() . 'index.php?school_admin/clinical_histroy/' . $param1, 'refresh');
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('appointment_not_fixed_succesfully!!'));
            redirect(base_url() . 'index.php?school_admin/fix_clinical_appointment/' . $param1, 'refresh');
        }
    }
    $page_data['page_title'] = get_phrase('fix_appointment');
    $page_data['page_name'] = 'fix_appointment';
    $this->load->view('backend/index', $page_data);
}

/* * *************************function for adding fee*************************** */

public function add_fee_settings() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    /*     * ************************loading model and controllers************** */
    $this->load->model("Class_model");
    $class_array = $this->Class_model->get_data_by_cols("class_id,name", array('isActive' => '1'), 'result_array');
    $page_data = $this->get_page_data_var();
    $page_data['class_values'] = $class_array;
    $page_data['page_title'] = get_phrase('fix_appointment');
    $page_data['page_name'] = 'add_fee';
    $this->load->view('backend/index', $page_data);
}

/**
 * 
 * @param type $param1
 * @param type $param2
 * @param type $param3
 */
function manage_nursery_chat_group($param1 = '', $param2 = '', $param3 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');

    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $this->load->model("Nursery_chat_group_model");
    $page_data = $this->get_page_data_var();
    if ($param1 == 'create') {
        $this->form_validation->set_rules('group_name', 'Chat Group Name', 'trim|required|is_unique[nursery_chat_group.group_name]');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_message_error', validation_errors());
        } else {
            $data['group_name'] = $this->input->post('group_name');
            $data['status'] = "1";
            //$img = $_FILES['userfile']['name'];
            //$data['product_image'] = $img;
            $Nursery_chat_group = $this->Nursery_chat_group_model->add($data);
            if ($Nursery_chat_group == TRUE) {
                //move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $product_id . '.jpg');
                $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
            } else {
                $this->session->set_flashdata('flash_message', get_phrase('error_while_adding_data'));
            }
        }
        redirect(base_url() . 'index.php?school_admin/manage_nursery_chat_group/', 'refresh');
    }

    if ($param1 == 'do_update') {
        $this->form_validation->set_rules('group_name', 'Chat Group Name', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_message_error', validation_errors());
        } else {
            $groupName = $this->input->post('group_name', TRUE);
            $groupNameArr = $this->Nursery_chat_group_model->get_data_by_cols('*', array('group_name' => $groupName, 'group_id !=' => $param2));
            if (count($groupNameArr) == 0) {
                $data['group_name'] = $groupName;
                $whereDataArr = array('group_id' => $param2);
                $updated_data = $this->Nursery_chat_group_model->update($data, $whereDataArr);
                if ($updated_data == TRUE) {
                    //move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $product_id . '.jpg');
                    $this->session->set_flashdata('flash_message', get_phrase('data_edited_successfully'));
                } else {
                    $this->session->set_flashdata('flash_message', get_phrase('error_while_editing_data'));
                }
            } else {
                $this->session->set_flashdata('flash_message', $groupName . ' already entered,Please enter new one.');
            }
        }
        redirect(base_url() . 'index.php?school_admin/manage_nursery_chat_group/', 'refresh');
    }

    if ($param1 == 'delete') {
        $delete = $this->Nursery_chat_group_model->delete($param2);
        if ($delete == true) {
            $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('data_not_deleted'));
        }
        redirect(base_url() . 'index.php?school_admin/manage_nursery_chat_group/', 'refresh');
    }

    $page_data['nursery_chat_group'] = $this->Nursery_chat_group_model->get_data_by_cols('*');
    $page_data['page_title'] = get_phrase('manage_nursery_chat_group');
    $page_data['page_name'] = 'manage_nursery_chat_group';
    $this->load->view('backend/index', $page_data);
}

function connect_user_to_chat_group($group_id = "", $param1 = "", $action_id = "") {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');

    if ($group_id == "") {
        redirect(base_url() . 'index.php/?admin/manage_nursery_chat_group', 'refresh');
    }

    $this->load->model("Nursery_chat_group_user_model");
    $page_data = $this->get_page_data_var();
    if ($param1 == 'create') {
        $this->form_validation->set_rules('user_id', 'Chat User Name', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_message_error', "Chat username should not be blank");
        } else {
            $userData = $this->input->post('user_id');
            $userDataArr = explode('-', $userData);
            if (count($userDataArr) == 2) {
                $data['user_id'] = $userDataArr[1];
                $data['user_type'] = $userDataArr[0];
                $userDataArr = $this->Nursery_chat_group_user_model->get_data_by_cols('*', array('user_id' => $data['user_id'], 'user_type' => $data['user_type']));
                if (count($userDataArr) == 0) {
                    $Nursery_chat_group = $this->Nursery_chat_group_user_model->add($data);
                    if ($Nursery_chat_group == TRUE) {
                        //move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $product_id . '.jpg');
                        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
                    } else {
                        $this->session->set_flashdata('flash_message', get_phrase('error_while_adding_data'));
                    }
                } else {
                    $this->session->set_flashdata('flash_message', 'Selected user already added in the group.');
                }
            } else {
                $this->session->set_flashdata('flash_message', get_phrase('error_while_adding_data'));
            }
        }
        redirect(base_url() . 'index.php?school_admin/connect_user_to_chat_group/' . $group_id, 'refresh');
    }



    if ($param1 == 'delete') {
        $delete = $this->Nursery_chat_group_user_model->delete($action_id);
        if ($delete == true) {
            $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('data_not_deleted'));
        }
        redirect(base_url() . 'index.php?school_admin/connect_user_to_chat_group/' . $group_id, 'refresh');
    }


    $page_data['nursery_chat_group_user'] = $this->Nursery_chat_group_user_model->get_all();
    $page_data['page_title'] = get_phrase('manage_nursery_chat_group_user');
    $page_data['group_id'] = $group_id;
    $page_data['page_name'] = 'manage_nursery_chat_group_user';
    $this->load->view('backend/index', $page_data);
}

function email_test() {
    $this->load->helper('email');
    $email = $this->input->post('email', TRUE);
    $subject = $this->input->post('subject', TRUE);
    $message = $this->input->post('message', TRUE);
    $to_name = $this->input->post('to_name', TRUE);
    $ret_msg = send_common_mail($email, $subject, $message, $to_name);
    pre($ret_msg);
}

function callig_view() {
    $page_data = $this->get_page_data_var();
    $data['exam_name'] = "test";
    $data['exam_date'] = "test date";
    $data['comment'] = "test comment";
    //$data['page_name'] = 'exam_mail';
    $data['page_name'] = 'exam_mail';
    $data['ss'] = array('foo' => 'Hello', 'bar' => 'world');
    $this->load->view('backend/school_admin/emails/exam_mail', $data);
}

/* * ******DISCUSSION FORUM******** */
function discussion_forum($param1 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model("Discussion_model");
    $formname = $this->input->post('add_discussion');
    $page_data = $this->get_page_data_var();
    if ($formname == 'add_discussion') {
        if ($param1 == 'create') {
            $data['discussion_title'] = $this->input->post('discussion_title');
            $data['disucssion_body'] = $this->input->post('description');
            $data['user_id'] = $this->session->userdata('admin_id');
            $data['discussion_created'] = date('Y-m-d H:i:s');
            $data['discussion_isActive'] = '1';

            if ($this->Discussion_model->insert_discussion($data)) {
                $this->session->set_flashdata('flash_message', get_phrase('new_discussion_added!!'));
                redirect(base_url() . 'index.php?school_admin/discussion_forum/', 'refresh');
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('new_discussion_not_added!!'));
                redirect(base_url() . 'index.php?school_admin/discussion_forum/', 'refresh');
            }
        }
    }
    $discussion_titles = $this->Discussion_model->get_data_by_cols('*', array('discussion_isActive' => '1'), 'result_array');

    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['discussion_titles'] = $discussion_titles;
    $page_data['page_title'] = get_phrase('discussion_forum');
    $page_data['page_name'] = 'discussion_forum';
    $this->load->view('backend/index', $page_data);
}

function add_comment() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model("Discussion_model");
    $this->load->model("Comment_model");
    $page_data = $this->get_page_data_var();
    $comment_body = $this->input->post('comment_body');
    $comment['comment_body'] = $comment_body;
    $comment['discussion_id'] = $this->input->post('discussion_id');
    $comment['comment_created'] = date('Y-m-d H:i:s');
    $comment['comment_user_id'] = $this->session->userdata('admin_id');
    $comment['comment_isActive'] = '1';
    if ($this->Comment_model->insert_comment($comment)) {
        echo "comment added";
    } else {
        echo "comment not added";
    }
}

function average() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $id = $this->uri->segment(3);
    $this->load->model('Mark_model');
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['average'] = $this->Mark_model->get_average($id);
    $page_data['page_title'] = get_phrase('average_of_each_exam');
    $page_data['page_name'] = 'student_average';
    $this->load->view('backend/index', $page_data);
}

function documents($param1 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');

    $id = $this->uri->segment(3);
    $this->load->model('S3_model');
    $page_data = $this->get_page_data_var();
    $page_data['files'] = $this->S3_model->get_all_files();

    $instance = $this->Crud_model->get_instance_name();
    $page_data['subfiles'] = $this->S3_model->get_file($page_data['files'][1], $instance . '/student/' . $param1 . '/');
    $page_data['instance'] = $instance . '/student/' . $param1 . '/';
    $page_data['student_id'] = $param1;
    $page_data['page_title'] = get_phrase('student_documents');
    $page_data['page_name'] = 'student_documents';
    $this->load->view('backend/index', $page_data);
}

function download_document($param1 = '', $param2 = '', $param3 = '', $param4 = '') {
    $this->load->helper('download');
    //$data =  file_get_contents('uploads/parent_bulk_upload_error_details_for_excel_file.xlsx');
    //$name = 'parent_bulk_upload_error_details_for_excel_file.xlsx';
    //$name = 'parent_bulk_upload_error_details_for_excel_file.xlsx';

    $param4 = str_replace('%20', ' ', $param4);
    $file_path = implode('/', array($param1, $param2, $param3, $param4));

    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('S3_model');
    $list = explode('/', $param1);
    //echo $file_path;
    //exit;
    $file_path = $this->S3_model->download($file_path);
    $data = file_get_contents($file_path);
    //echo $data;
    //exit;
    force_download($file_path, $data);
}

function delete_document($param1 = '', $param2 = '', $param3 = '', $param4 = '') {
    $this->load->helper('download');
    $param4 = str_replace('%20', ' ', $param4);
    $file_path = implode('/', array($param1, $param2, $param3, $param4));
//    echo $file_path; die;
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('S3_model');
    $list = explode('/', $param1);

    $file_path = $this->S3_model->delfile($file_path);
    $this->session->set_flashdata('flash_message', get_phrase('document_deleted_successfully'));
    redirect(base_url() . 'index.php?school_admin/documents/' . $param3, 'refresh');
}

function upload_document($param1 = '') {
    $this->load->model('S3_model');
    $config['upload_path'] = './uploads/';
    $config['allowed_types'] = 'pdf|docx|doc|txt|jpg|jpeg|png';
    $config['max_size'] = 100000;
    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    if (!$this->upload->do_upload('userfile')) {
        $this->session->set_flashdata('flash_message_error', $this->upload->display_errors());
        redirect(base_url() . 'index.php?school_admin/documents/' . $param1, 'refresh');
    } else {
        $data = $this->upload->data();
        $instance = $this->Crud_model->get_instance_name();
        $filepath = $instance . '/student/' . $param1 . '/' . $data['file_name'];
        $this->S3_model->upload($this->upload->data()['full_path'], $filepath);
        unlink($this->upload->data()['full_path']);
        //exit;
        $this->session->set_flashdata('flash_message', get_phrase('document_uploaded_successfully'));
        redirect(base_url() . 'index.php?school_admin/documents/' . $param1, 'refresh');
    }   
}

/**
 * 
 * @param type $class_id
 * @param type $section_id using these parameter fetching students 
 */

function get_students($class_id, $section_id) {
    $this->load->model('Enroll_model');
    $year = $this->globalSettingsRunningYear;
    $student = $this->Enroll_model->get_student($class_id, $section_id, $year);
    $response_html = '<option value="">Select Student</option>';
    foreach ($student as $row) {
        $response_html .= '<option value="' . $row->student_id . '">' . $row->name . '</option>';
    }
    echo $response_html;
}

function get_description($class_id) {
    $description = $this->Invoice_category_model->get_data_by_cols('*', array('class_id' => $class_id));
    foreach ($description as $row) {
        echo '<option value="' . $row->description . '">' . $row->description . '</option>';
    }
}

function get_amount($class_id, $description) {
    $amount = $this->Invoice_category_model->get_data_by_cols('*', array('class_id' => $class_id, 'description' => $description, 'and'));
    foreach ($amount as $row) {
        echo '<option value="' . $row->amount . '">' . $row->amount . '</option>';
    }
}

function parent_bulk_upload_error() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_title'] = get_phrase('parent_bulk_upload_error');
    $page_data['page_name'] = 'parent_bulk_upload_error';
    $this->load->view('backend/index', $page_data);
}

function parent_display_bulk_upload_errors() {
    $error = TRUE;
    if ($error) {
        $file_name = 'uploads/parent_bulk_upload_error_details.log';
        $error_messages = file_get_contents($file_name);
        $messages = json_decode($error_messages);
    }
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['messages'] = $messages;
    $page_data['page_title'] = get_phrase('display_upload_errors');
    $page_data['page_name'] = 'parent_display_bulk_upload_errors';
    $this->load->view('backend/index', $page_data);
}

function download_parent_bulk_upload_error_file() {
    $this->load->helper('download');
    $data = file_get_contents('uploads/parent_bulk_upload_error_details_for_excel_file.xlsx');
    //$name = 'parent_bulk_upload_error_details_for_excel_file.xlsx';
    $name = 'parent_bulk_upload_error_details_for_excel_file.xlsx';
    force_download($name, $data);
}

function class_bulk_upload_error() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['page_title'] = get_phrase('class_bulk_upload_error');
    $page_data['page_name'] = 'class_bulk_upload_error';
    $this->load->view('backend/index', $page_data);
}

function class_display_bulk_upload_errors() {
    $error = TRUE;
    if ($error) {
        $file_name = 'uploads/class_bulk_upload_error_details.log';
        $error_messages = file_get_contents($file_name);
        $messages = json_decode($error_messages);
    }
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['messages'] = $messages;
    $page_data['page_title'] = get_phrase('display_upload_errors');
    $page_data['page_name'] = 'class_display_bulk_upload_errors';
    $this->load->view('backend/index', $page_data);
}

function download_class_bulk_upload_error_file() {
    $this->load->helper('download');
    $data = file_get_contents('uploads/class_bulk_upload_error_details_for_excel_file.xlsx');
    //$name = 'parent_bulk_upload_error_details_for_excel_file.xlsx';
    $name = 'class_bulk_upload_error_details_for_excel_file.xlsx';
    force_download($name, $data);
}

/**
 * 
 */
function validate_student_image() {
    $config['upload_path'] = './uploads/student_image';
    $config['allowed_types'] = 'gif|jpg|png';
    //$config['max_size']    = '100';
    //$config['max_width']  = '1024';
    // $config['max_height']  = '768';

    $this->upload->initialize($config);
    if (!$this->upload->do_upload('userfile')) {
        $this->form_validation->set_message('validate_student_image', $this->upload->display_errors());
        return false;
    } else {
        return true;
    }
}

function event_management($param1 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Event_model');
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    if ($param1 == 'create') {
        $this->form_validation->set_rules('notice_title', 'Notice Title', 'required');
        $this->form_validation->set_rules('notice', 'Notice', 'required');
        $this->form_validation->set_rules('create_timestamp', 'Event Date', 'required');
        if ($this->form_validation->run() == TRUE) {
            $data['notice_title'] = $this->input->post('notice_title');
            $data['notice'] = $this->input->post('notice');
            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
            $this->Notice_board_model->add($data);
            $this->session->set_flashdata('flash_message', get_phrase('event_added_successfully'));
            redirect(base_url() . 'index.php?school_admin/event_management/', 'refresh');
        } else {
            $page_data['page_name'] = 'noticeboard';
            $page_data['page_title'] = get_phrase('manage_noticeboard');
            $page_data['notices'] = $this->Notice_board_model->get_data_by_cols('*', array(), 'result_type');
            $this->load->view('backend/index', $page_data);
        }
    }
    $page_data['types'] = $this->Event_model->getEventTypes();
    $page_data['page_title'] = get_phrase('event_management');
    $page_data['page_name'] = 'event_management';
    $page_data['recent_events'] = $this->Event_model->getRecentEvents();

    $this->load->view('backend/index', $page_data);
}

function event($param1 = '', $param2 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Event_model');
    $page_data = $this->get_page_data_var();
    if ($param1 == 'create') {
        $data['title'] = $this->input->post('eventType');
        $data['color'] = $this->input->post('colorPicker');
        $data['start'] = date('Y-m-d H:i:s', strtotime($this->input->post('startTime')));
        $data['end'] = date('Y-m-d H:i:s', strtotime($this->input->post('endTime')));
        $data['description'] = $this->input->post('description');
        $add_event = $this->Event_model->add_event($data);
        $notice['notice_title'] = $data['title'];
        $notice['notice'] = $data['description'];
        $notice['create_timestamp'] = time();
        $this->Event_model->save_notice($notice);
        $data['url'] = '';
        if ($add_event) {
            $msg = $data['title'] . " Event from " . $data['start'] . " To " . $data['end'];
            $message = array();
            $message_body = $msg . "<br><br>" . $data['description'] . ($data['url'] != "" ? "For more information :" . $data['url'] : "");
            $message['sms_message'] = $msg;
            $message['subject'] = $this->globalSettingsSystemName . " " . $data['title'] . "Event Created";
            $message['messagge_body'] = $message_body;

            $this->load->model("Notification_model");
            $create_notif_queue = $this->Notification_model->create_notification_queue('event_notice', $message);
            $user_details['user_type'] = array('teacher', 'parent', 'student');
            send_school_notification('event_notice', $message, '', '', $user_details);
        }
        $this->session->set_flashdata('flash_message', get_phrase('event_added_successfully'));
    }
    if ($param1 == 'update') {
        $data['start'] = date('Y-m-d H:i:s', strtotime($this->input->post('startTime')));
        $data['end'] = date('Y-m-d H:i:s', strtotime($this->input->post('endTime')));
        $edit_event = $this->Event_model->update_event($data,$param2);

        $this->session->set_flashdata('flash_message', get_phrase('event_date_updated_successfully'));
    }
    if ($param1 == 'delete') {
        $this->Event_model->delete_event(array('id' => $param2));
        $this->session->set_flashdata('flash_message', get_phrase('event_deleted_successfully'));
    }
    if ($param1 == 'delete_event') {
        $this->Event_model->delete_event(array('id' => $param2));
        $this->session->set_flashdata('flash_message', get_phrase('event_deleted_successfully'));
    }
    
    redirect(base_url() . 'index.php?school_admin/event_management/', 'refresh');
}

/*
 * Map student's RFID by class and sections
 * @param $class_id in Class id
 * @return Students list with class and section by class
 */

public function map_students_id($class_id = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $this->load->model("Class_model");
    if ($class_id == '') {
        $class_id = $this->Class_model->get_first_class_id();
    }
    $class_array = array('class_id' => $class_id);
    $page_data = $this->get_page_data_var();
    $page_data['sections'] = $this->Class_model->get_section_array($class_array);
    $page_data['page_name'] = 'map_students_id';
    $page_data['page_title'] = get_phrase('student_i_d') . " - " . get_phrase('class') . " : " . $this->crud_model->get_class_name($class_id);
    $page_data['class_id'] = $class_id;
    $this->load->model("Class_model");
    $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
    $page_data['students'] = $this->Student_model->getallstudents($class_id, $running_year);
    $page_data['classes'] = $this->Class_model->get_data_by_cols('*', array(), 'result_array');
    $i = 0;
    $NewArray = array();
    foreach ($page_data['sections'] as $section) {
        $studentss[]['student_all'] = $this->Student_model->getstudents_section($class_id, $running_year, $section['section_id']);
        $NewArray[$i] = array_merge($section, $studentss[$i]);
        $i++;
    }

    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['all_records'] = $NewArray;

    $this->load->view('backend/index', $page_data);
}

public function map_students_id_after_referesh($class_id = '') {
    $this->session->set_flashdata('flash_message', get_phrase('successfully_rfied_updated'));
    redirect(base_url() . 'index.php?school_admin/map_students_id/' . $class_id, 'refresh');
}

/**/

function manage_gallery() {
    if ($this->session->userdata('school_admin_login') != 1) {
        redirect(base_url(), 'refresh');
    }
    /*     * ************Loading helpers and models **************************** */
    $this->load->model("Class_model");
    /*     * **********************Getting sections and classes***************** */
    $class_array = $this->Class_model->get_class_array();
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['classes'] = $class_array;
    $page_data['page_title'] = get_phrase('manage_gallery');
    $page_data['page_name'] = 'manage_gallery';
    $this->load->view('backend/index', $page_data);
}

public function payment_config($param1 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');

    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $this->load->model("Payment_gateway_model");
    $this->config->load('payment_config', true);
    $payment_options = $this->config->item('payment_options', 'payment_config');
    $this->form_validation->set_rules('payment_gateway', 'Select Payment Gateway', 'required');
    $this->form_validation->set_rules('type_of_gateway', 'Select Payment Type', 'required');
    $this->form_validation->set_rules('endpoints', 'Endpoints', 'required');
    $this->form_validation->set_rules('username', 'Username', 'required');
    $page_data = $this->get_page_data_var();
    if ($this->form_validation->run() == TRUE) {
        $payment_options = array();
        $payment_options['name'] = $this->input->post('payment_gateway');
        $payment_options['type'] = $this->input->post('type_of_gateway');
        $payment_options['endpoints'] = $this->input->post('endpoints');
        $payment_options['username'] = $this->input->post('username');
        $payment_options['password'] = $this->input->post('password');
        $payment_options['hostname'] = $this->input->post('hostname');
        $payment_options['signature'] = $this->input->post('signature');
        $payment_options['isActive'] = '1';
        if ($this->Payment_gateway_model->save_payment_options($payment_options)) {
            $this->session->set_flashdata('flash_message', get_phrase('details_added_successfully!!'));
            redirect(base_url() . 'index.php?school_admin/view_payment_details');
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('details_not_added!!'));
            redirect(base_url() . 'index.php?school_admin/payment_config');
        }
    } else {
        $this->session->set_flashdata('flash_message_error', validation_errors());
        $page_data['payment_options'] = $payment_options;
        $page_data['page_title'] = get_phrase('payment_configuration');
        $page_data['page_name'] = 'payment_config';
        $this->load->view('backend/index', $page_data);
    }
}

public function view_payment_details($param1 = '', $param2 = '') {
    $this->load->model("Payment_gateway_model");
    if ($this->session->userdata('school_admin_login') != 1) {
        redirect(base_url(), 'refresh');
    }
    $page_data = $this->get_page_data_var();
    if ($param1 == 'edit') {
        $payment_options = array();
        $payment_options['name'] = $this->input->post('gateway_names');
        $payment_options['type'] = $this->input->post('type_of_gateway');
        $payment_options['endpoints'] = $this->input->post('endpoints');
        $payment_options['username'] = $this->input->post('username');
        $payment_options['password'] = $this->input->post('password');
        $payment_options['hostname'] = $this->input->post('hostname');
        $payment_options['signature'] = $this->input->post('signature');
        $condition = array('gateway_id' => $param2);

        if ($this->Payment_gateway_model->update_payment_options($payment_options, $condition)) {
            $this->session->set_flashdata('flash_message', get_phrase('details_updated_successfully!!'));
            redirect(base_url() . 'index.php?school_admin/view_payment_details');
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('details_not_updated!!'));
            redirect(base_url() . 'index.php?school_admin/view_payment_details');
        }
    }

    if ($param1 == 'delete') {
        $condition = array('gateway_id' => $param2);
        if ($this->Payment_gateway_model->delete_payment_options($condition)) {
            $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?school_admin/view_payment_details', 'refresh');
        } else {
            $this->session->set_flashdata('flash_message', get_phrase('data_not_deleted'));
            redirect(base_url() . 'index.php?school_admin/view_payment_details', 'refresh');
        }
    }

    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $get_details = $this->Payment_gateway_model->get_data_by_cols('*', array('isActive' => '1'), 'result_array', array('time_created' => 'DESC'));
    $page_data['get_details'] = $get_details;
    $page_data['page_title'] = get_phrase('view_payment_configuration');
    $page_data['page_name'] = 'view_payment_details';
    $this->load->view('backend/index', $page_data);
}

function send_push_notification_message() {
    $token = $this->input->post("token");
    $message = $this->input->post("message");
    $result = $this->send_notification(array($token), $message);
    echo '<pre>';
    print_r($result);
    die;
}

function send_notification($tokenArr, $message) {
    $url = 'https://fcm.googleapis.com/fcm/send';
    $messageData = array("message" => " FCM PUSH NOTIFICATION TEST MESSAGE");
    $fields = array('registration_ids' => $tokenArr, 'data' => $messageData);
    $serverKey = "AAAAutbZmbQ:APA91bFIOP-D3b0YsR3hyq8kwZHjlsGtYwFaN1yWxOQbbuN0a9QNEeih509u69h3ypGgDUPuhyfqYoCIHOed7lFm7ZjzS_oq5TJXXwuVNLyarFdeBYsnhqsRIItzIgL1ERksvu5q7arH5B8krn5gQrbta71-0OznCQ";
    $headers = array('Authorization:key =  ' . $serverKey, 'Content-Type: application/json');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }
    curl_close($ch);
    return $result;
}

/* * ***********************HOSTEL MANAGEMENT****************************** */

function add_warden() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('hostel_warden_model');
    $page_data = $this->get_page_data_var();
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    $this->form_validation->set_rules('warden_name', 'Name', 'trim|required');
    $this->form_validation->set_rules('warden_phone_number', 'Phone Number', 'trim|required|is_unique[hostel_warden.phone_number]');
    //$this->form_validation->set_rules('warden_address', 'Address', 'trim|required');
    $this->form_validation->set_rules('warden_email', 'Email', 'trim|required|valid_email');
    if ($this->form_validation->run() == TRUE) {
        $data['name'] = $this->input->post('warden_name');
        $data['phone_number'] = $this->input->post('warden_phone_number');
        //$data['address'] = $this->input->post('warden_address');
        $data['email'] = $this->input->post('warden_email');
        $data['status'] = "Active";
        $sql = $this->hostel_warden_model->add($data);
        if ($sql == true) {
            $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?school_admin/manage_hostel_warden', 'refresh');
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('something_went_wrong'));
            redirect(base_url() . 'index.php?school_admin/add_warden', 'refresh');
        }
    }

    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_title'] = get_phrase('hostel_warden');
    $page_data['page_name'] = 'add_hostel_warden';
    $this->load->view('backend/index', $page_data);
}

function add_hostel() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    $this->form_validation->set_rules('hostel_name', 'hostel_name', 'trim|required');
    $this->form_validation->set_rules('hostel_type', 'hostel_type', 'trim|required');
    $this->form_validation->set_rules('hostel_phone_number', 'hostel_phone_number', 'trim|required');
    $this->form_validation->set_rules('hostel_address', 'hostel_address', 'trim|required');
    $this->form_validation->set_rules('warden_name[]', 'Warden Name', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
        $data['name'] = $this->input->post('hostel_name');
        $data['hostel_type'] = $this->input->post('hostel_type');
        $data['phone_number'] = $this->input->post('hostel_phone_number');
        $data['hostel_address'] = $this->input->post('hostel_address');
        $data1['warden'] = $this->input->post('warden_name');
        $data['warden_id'] = implode(',', $data1['warden']);
        $data['status'] = "Active";
        $this->load->model('Dormitory_model');
        $this->Dormitory_model->add($data);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?school_admin/manage_hostel', 'refresh');
    }
    $this->load->model("Hostel_warden_model");
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['warden'] = $this->Hostel_warden_model->get_data_by_cols('*', array('status' => "Active"), 'result_array');
    if (!empty($page_data['warden'])) {
        $page_data['count_rows'] = $this->Hostel_warden_model->warden_count();
    }
    $page_data['page_title'] = get_phrase('add_hostel');
    $page_data['page_name'] = 'add_hostel';
    $this->load->view('backend/index', $page_data);
}

function add_hostel_room() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->library("fi_functions");
    $page_data = $this->get_page_data_var();
    //echo $this->globalSettingsRunningYear;exit;
    $charges = $this->fi_functions->get_hostelcharges($this->globalSettingsRunningYear);
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    $this->form_validation->set_rules('hostel_type', 'Hostel Type', 'trim|required');
    $this->form_validation->set_rules('hostel_name', 'Hostel Name', 'trim|required');
    $this->form_validation->set_rules('floor_name', 'Floor Name', 'trim|required');
    $this->form_validation->set_rules('room_number', 'Room Number', 'trim|required');
    $this->form_validation->set_rules('number_of_beds', 'Number of Beds', 'trim|required|numeric');
    $this->form_validation->set_rules('room_description', 'Room Description', 'trim|required');
    $this->form_validation->set_rules('room_fare', 'Room Fare', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
        $data['hostel_type'] = $this->input->post('hostel_type');
        $data['hostel_id'] = $this->input->post('hostel_name');
        $data['floor_name'] = $this->input->post('floor_name');
        $data['room_number'] = $this->input->post('room_number');
        $data['no_of_beds'] = $this->input->post('number_of_beds');
        $data['room_description'] = $this->input->post('room_description');
        if(sett('new_fi')){
            $data['room_fare'] = $this->input->post('room_fare');
            $data['available_beds'] = $data['no_of_beds'];
            $data['occupied_beds'] = 0;
            $hostel_room_id = $this->Hostel_room_model->add($data);
        }else{
            $charges_deatils = $this->input->post('room_fare');
            $pieces = explode('|', $charges_deatils);
            $charges_amount = $pieces[0];
            $charges_id = $pieces[1];
            $data['room_fare'] = $charges_amount;
            $data['available_beds'] = $data['no_of_beds'];
            $data['occupied_beds'] = 0;
            $this->load->model("Hostel_room_model");
            $hostel_name = $this->Dormitory_model->get_data_by_cols('name', array('dormitory_id' => $data['hostel_id']), 'result_array');
            $name = $hostel_name[0]['name'];
            $hostel_room_id = $this->Hostel_room_model->add($data);
            $data2['fees_name'] = "Hostel_Fees-" . "$name-" . $this->input->post('room_number');
            $data2['fi_id'] = $charges_id;
            $data2['amount'] = $charges_amount;
            $data2['room_id'] = $hostel_room_id;
            $this->load->model('fee_fi_model');
            $this->fee_fi_model->add($data2);
        }
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?school_admin/manage_hostel_room', 'refresh');
    }
    $this->load->model("Dormitory_model");
    $page_data['charges'] = $charges;
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['dormitory_details'] = $this->Dormitory_model->getAll();
    $page_data['page_title'] = get_phrase('add_hostel_room');
    $page_data['page_name'] = 'add_hostel_room';
    $this->load->view('backend/index', $page_data);
}

function manage_hostel($param1 = '', $dormitory_id = '', $param3 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $this->load->model("Dormitory_model");
    $this->load->model('Hostel_room_model');
    $this->load->model('Hostel_warden_model');
    $page_data['hostel_details'] = $this->Dormitory_model->get_data_by_cols('*', array('status' => 'Active'), 'result_array', array('created_time' => 'ORDER BY', 'created_time' => 'DESC'));
    $warden_id_arr = array();
    foreach ($page_data['hostel_details'] as $key => $value) {
        $count_stud = 0;
        $warden_ids = explode(',', $value['warden_id']);
        $count_stud = $this->Hostel_room_model->get_count_of_students($dormitory_id);
        $warden_id_arr[$value['dormitory_id']]['warden'] = array();
        $warden_id_arr[$value['dormitory_id']]['id'] = $value['dormitory_id'];
        $warden_id_arr[$value['dormitory_id']]['name'] = $value['name'];
        $warden_id_arr[$value['dormitory_id']]['transaction'] = $count_stud;
        $warden_id_arr[$value['dormitory_id']]['phone'] = $value['phone_number'];
        $warden_id_arr[$value['dormitory_id']]['type'] = $value['hostel_type'];
        $warden_id_arr[$value['dormitory_id']]['address'] = $value['hostel_address'];
        foreach ($warden_ids as $ward_key => $warden_id) {
            $name = $this->Hostel_warden_model->get_data_by_cols('name,warden_id', array('warden_id' => $warden_id), 'result_array');
            $warden_id_arr[$value['dormitory_id']]['warden'][] = $name[0]['name'];
        }
    }

    $page_data['details'] = $warden_id_arr;
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['details'] = $warden_id_arr;
    $page_data['page_title'] = get_phrase('manage_hostel');
    $page_data['page_name'] = 'manage_hostel';
    $this->load->view('backend/index', $page_data);
    if ($param1 == 'delete') {
        $this->load->model('Dormitory_model');
        $count_stud = $this->Hostel_room_model->get_count_of_students($dormitory_id);
        if (!empty($count_stud)) {
            if ($count_stud[0]['occupied'] <= '0') {
                $data['status'] = "Inactive";
                $this->Dormitory_model->update($dormitory_id, $data);
                $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
                redirect(base_url() . 'index.php?school_admin/manage_hostel', 'refresh');
            } else {
                $this->session->set_flashdata('flash_message', get_phrase('Cannot_delete!! As_students_are_occupied!!'));
                redirect(base_url() . 'index.php?school_admin/manage_hostel', 'refresh');
            }
        }
    }
}

function hostel_registration($param1 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    if($param1 == 'create'){        
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    // $this->form_validation->set_rules('class_id', 'Class', 'trim|required');
    // $this->form_validation->set_rules('section', 'Section', 'trim|required');
    $this->form_validation->set_rules('student_id', 'Student_id', 'trim|required');
    $this->form_validation->set_rules('type', 'Hostel Type', 'trim|required');
    $this->form_validation->set_rules('hostel_name', 'Hostel Name', 'trim|required');
    $this->form_validation->set_rules('floor', 'Floor', 'trim|required');
    $this->form_validation->set_rules('hostel_room', 'Hostel Room', 'trim|required');
    $this->form_validation->set_rules('food', 'Food', 'trim|required');
//    $this->form_validation->set_rules('register_date', 'Registration Date', 'trim|required');
//    $this->form_validation->set_rules('vacating_date', 'Vacating Date', 'trim|required');

    if ($this->form_validation->run() == TRUE) {//pre($_POST); die;
        // $data['class_id']       =   $this->input->post('class_id');
        // $data['section_id']     =   $this->input->post('section');
        $data['student_id'] = $this->input->post('student_id');
        $data['hostel_type'] = $this->input->post('type');
        $data['hostel_id'] = $this->input->post('hostel_name');
        $data['floor_name'] = $this->input->post('floor');
        $data['room_no'] = $this->input->post('hostel_room');
        $data['food'] = $this->input->post('food');
        $data['register_date'] = date('Y-m-d', strtotime($this->input->post('register_date')));
        $data['vacating_date'] = date('Y-m-d', strtotime($this->input->post('vacating_date')));
        $data['status'] = "present";
        $data['active_status'] = "active";
        $this->load->model('Hostel_registration_model');
        $this->Hostel_registration_model->add($data);
        $stu_update_data = array('dormitory_id' => $data['hostel_id']);
        $this->Student_model->update_student($stu_update_data, array('student_id' => $data['student_id']));
        $data2['room_number'] = $this->input->post('hostel_room');
        $this->load->model('Hostel_room_model');
        $this->Hostel_room_model->update_available($data2);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?school_admin/manage_allocation', 'refresh');
    }else{
        $this->session->set_flashdata('flash_validation_error', validation_errors());
        redirect(base_url() . 'index.php?school_admin/hostel_registration', 'refresh');
    }
    }
    $this->load->model("Class_model");
    $class_array = $this->Class_model->get_class_array();
    $page_data['classes'] = $class_array;
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_title'] = get_phrase('hostel_allocation');
    $page_data['page_name'] = 'hostel_allocation';
    $this->load->view('backend/index', $page_data);
}

function get_hostel_name($param1 = "") {
    $student_gender = $this->Student_model->get_data_by_cols('sex', array('student_id' => $param1), 'result_array');
    if (!empty($student_gender)) {
        $gender = $student_gender[0]['sex'];
    } else {
        $gender = "";
    }
    if ($gender == "Male" || $gender == "male") {
        $name = $this->Dormitory_model->get_data_by_cols('dormitory_id,name', array('hostel_type' => "Boys", 'status' => "Active"));
        $response_html = '<option value="">Select Hostel</option>';
        foreach ($name as $row) {
            $response_html .= '<option value="' . $row->dormitory_id . '">' . $row->name . '</option>';
        }
        echo $response_html;
    } else {
        $name = $this->Dormitory_model->get_data_by_cols('dormitory_id,name', array('hostel_type' => $param1, 'status' => "Active"));
        $response_html = '<option value="">Select Hostel</option>';
        foreach ($name as $row) {
            $response_html .= '<option value="' . $row->dormitory_id . '">' . $row->name . '</option>';
        }
        echo $response_html;
    }
}

function get_hostel_name_by_student($param1 = "") {
    $student_gender = $this->Student_model->get_data_by_cols('sex', array('student_id' => $param1), 'result_array');
    if (!empty($student_gender)) {
        $gender = $student_gender[0]['sex'];
    } else {
        $gender = "";
    }
    if ($gender == "Male" || $gender == "male") {
        $name = $this->Dormitory_model->get_data_by_cols('dormitory_id,name', array('hostel_type' => "Boys", 'status' => "Active"));
        $response_html = '<option value="">Select Hostel</option>';
        foreach ($name as $row) {
            $response_html .= '<option value="' . $row->dormitory_id . '">' . $row->name . '</option>';
        }
        echo "Boys||||" . $response_html;
    } else if ($gender == "Female" || $gender == "female") {
        $name = $this->Dormitory_model->get_data_by_cols('dormitory_id,name', array('hostel_type' => "Girls", 'status' => "Active"));
        $response_html = '<option value="">Select Hostel</option>';
        foreach ($name as $row) {
            $response_html .= '<option value="' . $row->dormitory_id . '">' . $row->name . '</option>';
        }
        echo "Girls||||" . $response_html;
    } else {
        $name = $this->Dormitory_model->get_data_by_cols('dormitory_id,name', array('hostel_type' => "Girls", 'status' => "Active"));
        $response_html = '<option value="">Hostels not configured yet.</option>';

        echo "Girls||||" . $response_html;
    }
}

function get_floor_name($hostel_id = "") {
    $name = $this->Hostel_room_model->get_data_by_cols('DISTINCT(floor_name)', array('hostel_id' => $hostel_id));
    $response_html = '<option value="">Select Floor</option>';
    foreach ($name as $row) {
        $response_html .= '<option value="' . $row->floor_name . '">' . $row->floor_name . '</option>';
    }
    echo $response_html;
}

function get_hostel_room($floor_name = "", $hostel_id = "") {
    $name = $this->Hostel_room_model->get_data_by_cols('room_number', array('floor_name' => $floor_name, 'available_beds >' => 0, 'condition_type' => 'and', 'hostel_id' => $hostel_id));
    if(count($name) > 0) {
        $response_html = '<option value="">Select Room</option>';
        foreach ($name as $row) {
            $response_html .= '<option value="' . $row->room_number . '">' . $row->room_number . '</option>';
        }
        $error = 0;
    } else {
        $error = 1;
        $response_html = '<option value="">Beds not available</option>';
    }
    echo $error.'||**||'.$response_html;
}

function get_details($room_no = "") {
    $details = $this->Hostel_room_model->get_data_by_cols('*', array('room_number' => $room_no), 'result_array');
    foreach ($details as $value) {
        $hostel_name = $this->Dormitory_model->get_data_by_cols('name', array('dormitory_id' => $value['hostel_id']), 'result_array');
    }
    $i = 0;
    $new = array();
    foreach ($details as $value) {
        $new[$i] = array_merge($value, $hostel_name[$i]);
    }
    $name = $new;
    foreach ($name as $row) {
        echo '<span>' . '<ul class="list-unstyled badge-danger badgget_hostel_roome_style_over list-inline p-10" >' .
        '<li>' . '<b>' . "Hostel Name : " . '</b>' . $row['name'] . '</li>' . ' ' .
        '<li>' . '<b>' . "Hostel Type : " . '</b>' . $row['hostel_type'] . '</li>' . ' ' .
        '<li>' . '<b>' . "Floor Name : " . '</b>' . $row['floor_name'] . '</li>' . ' ' .
        '<li>' . '<b>' . "Room Number : " . '</b>' . $row['room_number'] . '</li>' . ' ' .
        '<li>' . '<b>' . "No.of Beds : " . '</b>' . $row['no_of_beds'] . '</li>' . ' ' .
        '<li>' . '<b>' . "Available Beds : " . '</b>' . $row['available_beds'] . '</li>' . ' ' .
        '<li>' . '<b>' . "Occupied Beds : " . '</b>' . $row['occupied_beds'] . '</li>' . '</ul>' . '</span>';
    }
}

function manage_allocation($param1 = "", $param2 = "", $param3 = "") {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();

    $page_data['search_text'] = '';

    if (($param1 == 'search') && ($param2 != '')) {
        $page_data['search_text'] = $param2;
    }

    $page_data['page_title'] = get_phrase('list_allocation');
    $page_data['page_name'] = 'manage_allocation';
    $this->load->view('backend/index', $page_data);
    if ($param1 == 'vacate') {
        $data['status'] = "vacated";
        $data['vacating_date'] = date('Y-m-d');
        $this->load->model('Hostel_registration_model');
        $this->Hostel_registration_model->update_status($param2, $data);
        $this->load->model('Hostel_room_model');
        $this->Hostel_room_model->update_occupied($param3);
        $this->session->set_flashdata('flash_message', 'student is sucessfully vacated');
        redirect(base_url() . 'index.php?school_admin/manage_allocation/', 'refresh');
    }
}

function edit_hostel_allocation($param1 = "") {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $this->form_validation->set_rules('food', 'Food', 'trim|required');
    $this->form_validation->set_rules('register_date', 'Registration Date', 'trim|required');
    $this->form_validation->set_rules('vacating_date', 'Vacating Date', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
        $data['food'] = $this->input->post('food');
        $data['register_date'] = date('Y/m/d', (strtotime($this->input->post('register_date'))));
        $data['vacating_date'] = date('Y/m/d', (strtotime($this->input->post('vacating_date'))));
        $this->load->model('Hostel_registration_model');
        $this->Hostel_registration_model->update($data, $param1);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?school_admin/manage_allocation', 'refresh');
    }
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_title'] = get_phrase('hostel_allocation');
    $page_data['page_name'] = 'hostel_allocation';
    $this->load->view('backend/index', $page_data);
}

function hostel_transfer($student_id = "", $exsiting_room_no = "", $hostel_reg_id = "") {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
//    $this->form_validation->set_rules('type', 'Hostel Type', 'trim|required');
    $this->form_validation->set_rules('hostel_name', 'Hostel Name', 'trim|required');
    $this->form_validation->set_rules('floor', 'Floor', 'trim|required');
    $this->form_validation->set_rules('hostel_room', 'Hostel Room', 'trim|required');
    $this->form_validation->set_rules('food', 'Food', 'trim|required');
    //$this->form_validation->set_rules('register_date', 'Registration Date', 'trim|required');
    $this->form_validation->set_rules('vacating_date', 'Vacating Date', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
        $data['student_id'] = $student_id;
        $data['hostel_type'] = $this->input->post('type');
        $data['hostel_id'] = $this->input->post('hostel_name');
        $data['floor_name'] = $this->input->post('floor');
        $data['room_no'] = $this->input->post('hostel_room');
        $data['food'] = $this->input->post('food');
        $data['register_date'] = date('Y-m-d');
        $data['vacating_date'] = date('Y-m-d');
        $data['status'] = "present";
        $data['active_status'] = "active";
        $this->load->model('Hostel_registration_model');
        $this->Hostel_registration_model->add($data);
        $data2['room_number'] = $this->input->post('hostel_room');
        $data3['status'] = "transfer";
        $data3['transfer_date'] = date('Y-m-d', (strtotime($this->input->post('transfer_date'))));
        $this->Hostel_registration_model->update_status($hostel_reg_id, $data3);
        $this->load->model('Hostel_room_model');
        $this->Hostel_room_model->update_available($data2);
        $this->Hostel_room_model->update_occupied($exsiting_room_no);
        $this->session->set_flashdata('flash_message', get_phrase('student_successfully_transfered'));
        redirect(base_url() . 'index.php?school_admin/manage_allocation', 'refresh');
    } else {
        $this->session->set_flashdata('flash_validation_error', validation_errors());
        //redirect(base_url() . 'index.php?school_admin/hostel_transfer');
        $this->load->model("Dormitory_model");
   
        if ($student_id != '') {
        $data = $this->Dormitory_model->get_Student_dormatory($student_id);
//        pre($data); die;
        if (count($data)) {
            $hostel_type = $data[0]['hostel_type'];
            $hostel_type_data = $this->Dormitory_model->get_data_by_cols('dormitory_id, name, hostel_type', array('hostel_type' => $hostel_type, 'status' => 'Active'), 'result_array');
//            $result['hostel_type_data'] = $hostel_type_data;
//            $result['dormitory_id'] = $data[0]['dormitory_id'];
        } 
    }
        $page_data['hostel_list'] = $hostel_type_data;
        $page_data['student_name'] = $this->Student_model->get_data_by_cols('name', array('student_id' => $student_id), 'result_array');
        $page_data['student_id'] = $student_id;
        $page_data['exsiting_room_no'] = $exsiting_room_no;
        $page_data['hostel_reg_id'] = $hostel_reg_id;
        $page_data['page_title'] = get_phrase('hostel_transfer');
        $page_data['page_name'] = 'hostel_transfer';
        $this->load->view('backend/index', $page_data);
    }
}

function manage_hostel_warden($param1 = "", $warden_id = "") {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $this->load->model('Hostel_warden_model');
    $this->load->model("Dormitory_model");
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $warden_details = array();
    $warden_details =  $this->Hostel_warden_model->get_data_by_cols('*', array('status' => "Active"), 'result_array', array('created_date' => 'ORDER BY', 'created_date' => 'DESC'));
    
    foreach($warden_details as $key=>$warden)
    {    
        $warden_id = $warden['warden_id'];
        $warden_count = $this->Dormitory_model->get_data_generic_fun('*', array('warden_id' => $warden_id, 'status'=>'Active'), "result_array");
        $warden_details[$key]['transaction'] = count($warden_count);
        
    }
    $page_data['warden_details'] = $warden_details;
    $page_data['page_title'] = get_phrase('manage_warden');
    $page_data['page_name'] = 'manage_warden';
    $this->load->view('backend/index', $page_data);
    if ($param1 == 'delete') {

//        $this->hostel_warden_model->delete($warden_id);
        $data['status'] = "Inactive";
        $data['deleted_time'] = date('Y/m/d H:i:s');
        $this->Hostel_warden_model->update($warden_id, $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?school_admin/manage_hostel_warden', 'refresh');
    }
}

function edit_warden($warden_id = "") {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $this->load->model('hostel_warden_model');
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    $this->form_validation->set_rules('warden_name', 'Name', 'trim|required');
    $this->form_validation->set_rules('warden_phone_number', 'Phone Number', 'trim|required');
    $this->form_validation->set_rules('warden_email', 'Eamil', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
        $data['name'] = $this->input->post('warden_name');
        $data['phone_number'] = $this->input->post('warden_phone_number');
        $data['email'] = $this->input->post('warden_email');
        $sql = $this->hostel_warden_model->update($warden_id, $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_updated_successfully'));
        redirect(base_url() . 'index.php?school_admin/manage_hostel_warden', 'refresh');
    } else {
        $this->session->set_flashdata('flash_message_error', validation_errors());
        $page_data['warden_details'] = $this->Hostel_warden_model->get_data_by_cols('*', array(), 'result_array');
        $page_data['page_title'] = get_phrase('manage_warden');
        $page_data['page_name'] = 'manage_warden';
        $this->load->view('backend/index', $page_data);
    }
}

function manage_hostel_room($param1 = "", $hostel_room_id = "") {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Dormitory_model');
    $page_data = $this->get_page_data_var();
    $hostel_room = $this->Hostel_room_model->get_data_by_cols('*', array(), 'result_array', array('hostel_room_id', 'desc'));
    foreach ($hostel_room as $key=>$row) {
        $hostel = $this->Dormitory_model->get_data_by_cols('name', array('dormitory_id' => $row['hostel_id']), 'result_array');
        $hostel_name[]['hostel_name'] = $hostel[0]['name'];
        $stu_count = $this->Hostel_room_model->get_count_of_students_room($row['hostel_id'], $row['room_number']);
        $hostel_room[$key]['transaction'] = $stu_count;    
        
    }
    $i = 0;
    $newArray = array();
    foreach ($hostel_room as $value) {
        $newArray[$i] = array_merge($value, $hostel_name[$i]);
        $i++;
    }
    
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['room_details'] = $newArray;
    $page_data['page_title'] = get_phrase('manage_hostel_room');
    $page_data['page_name'] = 'manage_hostel_room';
    $this->load->view('backend/index', $page_data);
    if ($param1 == 'delete') {
        $this->load->model('Hostel_room_model');
        $this->load->model('Fee_fi_model');
        $this->Hostel_room_model->delete($hostel_room_id);
        $this->Fee_fi_model->delete($hostel_room_id);
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?school_admin/manage_hostel_room', 'refresh');
    }
}

function edit_hostel_room($hostel_room_id = "") {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->library("fi_functions");
    $page_data = $this->get_page_data_var();
    $charges = $this->fi_functions->get_charges();
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    $this->form_validation->set_rules('hostel_type', 'hostel_type', 'trim|required');
    $this->form_validation->set_rules('hostel_name', 'hostel_name', 'trim|required');
    $this->form_validation->set_rules('floor_name', 'floor_name', 'trim|required');
    $this->form_validation->set_rules('room_number', 'room_number', 'trim|required');
    $this->form_validation->set_rules('number_of_beds', 'number_of_beds', 'trim|required|numeric');
    $this->form_validation->set_rules('room_description', 'room_description', 'trim|required');
    $this->form_validation->set_rules('room_fare', 'room_fare', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
        $data['hostel_type'] = $this->input->post('hostel_type');
        $data['hostel_id'] = $this->input->post('hostel_name');
        $data['floor_name'] = $this->input->post('floor_name');
        $data['room_number'] = $this->input->post('room_number');
        $data['no_of_beds'] = $this->input->post('number_of_beds');
        $data['room_description'] = $this->input->post('room_description');

        if(sett('new_fi')){
            $data['room_fare'] = $this->input->post('room_fare');
            $data['available_beds'] = $data['no_of_beds'];
            $data['occupied_beds'] = 0;
            $this->Hostel_room_model->update_hostel_room($hostel_room_id,$data);
        }else{  
            $charges_deatils = $this->input->post('room_fare');
            $pieces = explode("|", $charges_deatils);
            $charges_amount = $pieces[0];
            $charges_id = $pieces[1];
            $data['room_fare'] = $charges_amount;
            $data['available_beds'] = $data['no_of_beds'];
            $this->load->model("Hostel_room_model");
            $sql = $this->Hostel_room_model->update_hostel_room($hostel_room_id, $data);
            $hostel_name = $this->Dormitory_model->get_data_by_cols('name', array('dormitory_id' => $data['hostel_id']), 'result_array');
            $name = $hostel_name[0]['name'];
            $data2['fees_name'] = "Hostel_Fees-" . "$name-" . $this->input->post('room_number');
            $data2['fi_id'] = $charges_id;
            $data2['amount'] = $charges_amount;
            $this->load->model('fee_fi_model');
            $this->fee_fi_model->update($hostel_room_id, $data2);
        }

        $this->session->set_flashdata('flash_message', get_phrase('data_updated_successfully'));
        redirect(base_url() . 'index.php?school_admin/manage_hostel_room', 'refresh');
    } else {
        $this->session->set_flashdata('flash_message_error', validation_errors());
        $hostel_room = $this->Hostel_room_model->get_data_by_cols('*', array(), 'result_array');
        foreach ($hostel_room as $row) {
            $hostel = $this->Dormitory_model->get_data_by_cols('name', array('dormitory_id' => $row['hostel_id']), 'result_array');
            $hostel_name[]['hostel_name'] = $hostel[0]['name'];
        }
        $i = 0;
        $newArray = array();
        foreach ($hostel_room as $value) {
            $newArray[$i] = array_merge($value, $hostel_name[$i]);
            $i++;
        }
        $page_data['room_details'] = $newArray;
        $page_data['page_title'] = get_phrase('manage_hostel_room');
        $page_data['page_name'] = 'manage_hostel_room';
        $this->load->view('backend/index', $page_data);
    }
}

function dormitory_students($param1 = "") {
    $students = $this->Hostel_registration_model->get_data_by_cols('distinct(student_id)', array('hostel_id' => $param1), 'result_array');
    $page_data = $this->get_page_data_var();
    foreach ($students as $row) {
        $student_name = $this->Student_model->get_data_by_cols('name', array('student_id' => $row['student_id']), 'result_array');
        $students_name[$row['student_id']]['name'] = $student_name[0]['name'];
        $hostel = $this->Hostel_registration_model->get_data_by_cols('*', array('student_id' => $row['student_id']), 'result_array');
        $year = $this->globalSettingsSMSDataArr[2]->description;
        $class = $this->Enroll_model->get_data_by_cols('class_id,section_id', array('student_id' => $row['student_id'], 'year' => $year), 'result_array');
        $classes[]['class_id'] = $class[0]['class_id'];
        $section[]['section_id'] = $class[0]['section_id'];
        foreach ($classes as $value) {
            $class_name = $this->Class_model->get_data_by_cols('name', array('class_id' => $value['class_id']), 'result_array');
            $students_name[$row['student_id']]['classname'] = $class_name[0]['name'];
        }
        foreach ($section as $rows) {
            $section_name = $this->Section_model->get_data_by_cols('name', array('section_id' => $rows['section_id']), 'result_array');
            $students_name[$row['student_id']]['section_name'] = $section_name[0]['name'];
        }
        foreach ($hostel as $hostels) {
            $i = 0;
            $newArray = array();
            $hostel_name = $this->Dormitory_model->get_data_by_cols('name', array('dormitory_id' => $hostels['hostel_id']), 'result_array');
            $newArray = array_merge($hostels, $hostel_name[$i]);
            $i++;
            $students_name[$row['student_id']]['hostel_details'][] = $newArray;
        }
    }

    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['students_name'] = $students_name;
    $page_data['page_title'] = get_phrase('list_of_dormitory_students');
    $page_data['page_name'] = 'modal_dormitory_student';
    $this->load->view('backend/index', $page_data);
}

function edit_manage_hostel($dormitory_id = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    $this->form_validation->set_rules('hostel_name', 'hostel_name', 'trim|required');
    $this->form_validation->set_rules('hostel_type', 'hostel_type', 'trim|required');
    $this->form_validation->set_rules('hostel_phone_number', 'hostel_phone_number', 'trim|required');
    $this->form_validation->set_rules('hostel_address', 'hostel_address', 'trim|required');
    $this->form_validation->set_rules('warden_name[]', 'Warden Name', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
        $data['name'] = $this->input->post('hostel_name');
        $data['hostel_type'] = $this->input->post('hostel_type');
        $data['phone_number'] = $this->input->post('hostel_phone_number');
        $data['hostel_address'] = $this->input->post('hostel_address');
        $data1['warden'] = $this->input->post('warden_name');
        $data['warden_id'] = implode(',', $data1['warden']);
        $this->load->model('Dormitory_model');
        $this->Dormitory_model->update($dormitory_id, $data);
        $this->session->set_flashdata('flash_message', get_phrase('updated_successfully'));
        redirect(base_url() . 'index.php?school_admin/manage_hostel', 'refresh');
    } else {
        $this->session->set_flashdata('flash_message_error', get_phrase('something_wrong_happened'));
        redirect(base_url() . 'index.php?school_admin/manage_hostel', 'refresh');
    }
}

/* * ******************************End of Hostel************************************************************* */





/*
 * Send sms from the School ERP System
 * @param $phone_number array() array of phone number or comma seperated string
 * @param string $message  Message to be sent
 */

public function send_sms($phone_number, $message) {
    if (is_array($phone_number)) {
        $phone_number = implode(",", $phone_number);
    }
    $post = [
        'location' => $this->globalSettingsLocation,
        'cell_phone' => $phone_number,
        'message' => $message
    ];

    $url = "http://".SMS_IP_ADDR."/School/index.php/?admin/send_common_sms/"; // url for sms configured

    if (fire_api_by_curl($url, $post))
        return TRUE;
    else
        return FALSE;
}

/* * *******************Document Manager****************************** */

public function campus_updates_management($param1 = '', $param2 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model("Notification_model");
    $page_data = $this->get_page_data_var();
    if ($param1 == 'create') {
        $campus_update = array();
        $campus_update['notification'] = trim($this->input->post('notification'));
        $campus_update['notification_type'] = 'push_notifications';
        $campus_update['user_type'] = '';
        if ($this->Notification_model->save_notifications($campus_update)) {
            $this->session->set_flashdata('flash_message', get_phrase('notification_added_successfully!!'));
            redirect(base_url() . 'index.php?school_admin/campus_updates_management');
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('notification_not_added!!'));
            redirect(base_url() . 'index.php?school_admin/campus_updates_management');
        }
    }

    if ($param1 == 'edit') {
        $campus_update = array();
        $campus_update['notification'] = trim($this->input->post('notification'));
        $campus_update['notification_type'] = 'push_notifications';
        $campus_update['user_type'] = '';
        $condition = array('notification_id' => $param2);
        if ($this->Notification_model->edit_updates($campus_update, $condition)) {
            $this->session->set_flashdata('flash_message', get_phrase('updated_successfully!'));
            redirect(base_url() . 'index.php?school_admin/campus_updates_management');
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('update_not_edited_successfully!!'));
            redirect(base_url() . 'index.php?school_admin/campus_updates_management');
        }
    }
    if ($param1 == 'delete') {
        $condition = array('notification_id' => $param2);
        if ($this->Notification_model->delete_updates($condition)) {
            $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?school_admin/campus_updates_management', 'refresh');
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('data_not_deleted'));
            redirect(base_url() . 'index.php?school_admin/campus_updates_management', 'refresh');
        }
    }

    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['get_updates'] = $this->Notification_model->get_todays_notifcations('push_notifications');
    $page_data['page_title'] = get_phrase('view_campus_updates');
    $page_data['page_name'] = 'campus_updates_management';
    $this->load->view('backend/index', $page_data);
}

function document() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_title'] = get_phrase('document_manager');
    $page_data['page_name'] = 'document_manager';
    $this->load->view('backend/index', $page_data);
}

function print_transfer_certificate($param1 = '', $param2 = '', $param3 = '', $param4 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');

    if ($this->input->post('student_id')) {
        $param1 = $this->input->post('student_id');
    }
    if ($param1 == 'create') {
        $param1 = $param2;
        $this->load->model("Transfer_certificate_model");
        $this->load->model("Parent_model");
        $this->load->model("Email_model");
        $parent_id = $this->input->post('parent_id');
        $data['student_id'] = $param1;
        $data['tc_id'] = $this->input->post('certificate_no1');
        $data['date'] = date('Y-m-d H:i:s');
        $data['addmitted_class_year'] = $this->input->post('admitted_year');
        $data['promote_class'] = $this->input->post('promoted_class');
        $data['promote_class_year'] = $this->input->post('promoted_year');
        $data['detained_class'] = $this->input->post('detained_class');
        $data['detained_class_year'] = $this->input->post('detained_class_year');
        $data['observation'] = $this->input->post('observation');
        $data['certificate_date'] = $this->input->post('app_certificate');
        $data['headmaster_name'] = $this->input->post('headmaster_name');
        $data['is_approve'] = 1;
//        pre($data); die;
        $this->Transfer_certificate_model->save_tc_no($data);
        $parent_info = $this->Parent_model->get_email_id($parent_id);
        $email = $parent_info[0]['email'];
        $message = "Your Child's Transfer Certificate is ready now. You can Download it from your panel";
        $this->Email_model->email_sendToParent($message, 'Transfer Certificate', $email);
        $this->session->set_flashdata('flash_message', get_phrase('Transfer_certificate_approve_successfully'));
        redirect(base_url() . 'index.php?school_admin/print_transfer_certificate/' . $param1, 'refresh');
    }
    $this->load->model("Email_model");
    $page_data = $this->get_page_data_var();
    $this->load->model("Parent_model");
    $this->load->model("Enroll_model");
    $this->load->model("Transfer_certificate_model");
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['student'] = $this->Student_model->get_student_record(array('student_id' => $param1));
    $classes = $this->Student_model->get_class_id_by_student($param1);
    //$classes=$classes[0];
    //exit;
    $class_admitted = reset($classes);
    $present_class = end($classes);
    $page_data['class_aresetdmitted'] = $this->Class_model->get_class_record(array('class_id' => ($class_admitted['class_id'])), 'class_name');
    $page_data['present_class'] = $this->Class_model->get_class_record(array('class_id' => ($present_class['class_id'])), 'class_name');
    $page_data['running_year'] = $this->globalSettingsRunningYear;
//echo $param1; die;
    $student = $this->Student_model->get_student_record(array('student_id' => $param1));
    $enroll_no = $this->Enroll_model->get_enrollid_by_student($param1, $page_data['running_year']);
    
    $tc_no = $this->Transfer_certificate_model->get_tc_no($param1);
//   pre($tc_no); die;
    $page_data['parent_name'] = $this->Parent_model->get_parent_name($student->parent_id);
    $page_data['certificate_detail'] = $this->Transfer_certificate_model->get_details($param1);
    $page_data['tc_number'] = $tc_no;
    $page_data['print'] = $param2;
    $page_data['enroll_no'] = $enroll_no;
    $page_data['crnt_date'] = date('d-m-Y');
    $page_data['student'] = $student;
    $page_data['page_title'] = get_phrase('transfer_certificate');
    $page_data['page_name'] = 'transfer_certificate';
    $this->load->view('backend/index', $page_data);
}

function print_merit_certificate($param1 = '', $param2 = '', $param3 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');

    if ($this->input->post('student_id')) {
        $param1 = $this->input->post('student_id');
    }
    $this->load->model("Email_model");
    $this->load->model("Transfer_certificate_model");

    $page_data = $this->get_page_data_var();
    if ($param1 == 'create') {
        $param1 = $param2;
        $param2 = $param3;
        $data['student_id'] = $this->input->post('studentId');
        $data['merit_certificate_for'] = $this->input->post('for_merit');
        $data['date'] = date('Y-m-d H:i:s');
        $data['is_approve'] = 1;
        $this->Transfer_certificate_model->save_merit_cerificate($data);
        $this->session->set_flashdata('flash_message', get_phrase('Merit_certificate_approve_successfully'));
        redirect(base_url() . 'index.php?school_admin/print_merit_certificate/' . $param1, 'refresh');
    }
    if ($param3 != '') {
        $parent_id = $param3;
        $parent_info = $this->Parent_model->get_email_id($parent_id);
        $email = $parent_info[0]['email'];
        $message = "Your Child's Merit Certificate is ready now. You can Download it from your panel";
        $this->Email_model->email_sendToParent($message, 'Merit Certificate', $email);
    }

    if ($this->input->post('class_id')) {
        $class_id = $this->input->post('class_id');
        $class_name = $this->Class_model->get_name_by_id($class_id);
        $page_data['merit_certificate_for'] = $class_name[0]->name;
    } else {
        $class_id = $this->Student_model->get_class_id_by_student($param1);
        $class_name = $this->Class_model->get_name_by_id($class_id[0]['class_id']);
        $page_data['merit_certificate_for'] = $class_name[0]->name;
    }

    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['student'] = $this->Student_model->get_student_record(array('student_id' => $param1));
    $classes = $this->Student_model->get_class_id_by_student($param1);

    //$classes=$classes[0];
    //exit;
    $class_admitted = reset($classes);
    $present_class = end($classes);
    $page_data['certificate_detail'] = $this->Transfer_certificate_model->get_merit_certificate($param1);
    $page_data['class_admitted'] = $this->Class_model->get_class_record(array('class_id' => ($class_admitted['class_id'])), 'class_name');
    $page_data['present_class'] = $this->Class_model->get_class_record(array('class_id' => ($present_class['class_id'])), 'class_name');
    $page_data['running_year'] = $this->globalSettingsRunningYear;
    $page_data['print'] = $param2;
    $page_data['student'] = $this->Student_model->get_student_record(array('student_id' => $param1));
    $page_data['student_id'] = $param1;
    $page_data['page_title'] = get_phrase('merit_certificate');
    $page_data['page_name'] = 'merit_certificate';

    $this->load->view('backend/index', $page_data);
}

function view_faculty_feedback() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['teacher_details'] = $this->Teacher_model->get_data_by_cols('*', array('isActive' => '1'), 'result_array', array('name' => 'ASC'));
    $page_data['page_title'] = get_phrase('view_feed_back');
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_name'] = 'view_feed_back';
    $this->load->view('backend/index', $page_data);
}

function faculty_feedback($param1 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $this->load->model('Faculty_feedback_model');
    $year = $this->globalSettingsRunningYear;
    $this->load->model("Teacher_model");
    $teacher_list = $this->Teacher_model->get_teacher_forFeedback();
    if ($param1 == 'create') {
        $this->form_validation->set_rules('teacher_id', 'Teacher', 'required');
        $this->form_validation->set_rules('rating', 'Rating', 'required');
        $this->form_validation->set_rules('feed_back', 'Feed Back', 'required');
        $this->form_validation->set_error_delimiters('', '');
        if ($this->form_validation->run() == TRUE) {
            $feed_back['teacher_id'] = $this->input->post('teacher_id');
            $feed_back['rating'] = $this->input->post('rating');
            $feed_back['feedback_content'] = $this->input->post('feed_back');
            if ($this->Faculty_feedback_model->save_feed_back($feed_back)) {
                $this->session->set_flashdata('flash_message', get_phrase('feedback_added_successfully!!'));
            } else {
                $this->session->set_flashdata('flash_message', get_phrase('feedback_not_added!!'));
            }
            redirect(base_url() . 'index.php?school_admin/view_faculty_feedback');
        } else {
            $this->session->set_flashdata('flash_message_error', validation_errors());
            redirect(base_url() . 'index.php?school_admin/faculty_feedback');
        }
    }
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    //$page_data['teacher_list']              =   $teacher_det;        
    //$page_data['children_of_parent']        =   $children_of_parent;
    $page_data['teacher_list'] = $teacher_list;
    $page_data['page_name'] = 'faculty_feedback';
    $page_data['page_title'] = get_phrase('faculty_feedback');
    $this->load->view('backend/index', $page_data);
}

/*
 * Total number of notification for today
 * 
 */

public function get_no_of_notication() {
    $this->load->model("Notification_model");
    $user_notif_user = $this->Notification_model->get_notifications('push_notifications', 'admin');
    $user_notif_common = $this->Notification_model->get_notifications('push_notifications');
    $total_count = count($user_notif_user) + count($user_notif_common);
    return $total_count;
}

/* * **************************************Transport***************************************************** */

function student_bus_allocation() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['classes'] = $this->Class_model->get_data_by_cols("*", array(), "result_array");
    $page_data['bus'] = $this->Transport_model->get_data_by_cols('*', array(), 'result_array');
    $page_data['page_title'] = get_phrase('student_bus_allocation');
    $page_data['page_name'] = 'student_bus_allocation';
    $this->load->view('backend/index', $page_data);
}

function get_bus($route = "") {
    $name = $this->Bus_model->get_data_by_cols('bus_id,name', array('route_id' => $route));
    echo '<option value="">' . "Select Bus" . '</option>';
    foreach ($name as $row) {
        echo '<option value="' . $row->bus_id . '">' . $row->name . '</option>';
    }
}

function get_route_fare($route=""){
        $name                                              =    get_data_generic_fun('transport','route_fare',array('transport_id'=>$route));
        foreach ($name as $row) {
        echo '<span>' .'Amount for this route is:' .$row->route_fare  . '</span>';
        }
    }

function add_student_bus() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Enroll_model');
    $page_data = $this->get_page_data_var();
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    $this->form_validation->set_rules('student_id', 'Student_id', 'trim|required');
    $this->form_validation->set_rules('route', 'Route', 'trim|required');
    $this->form_validation->set_rules('bus', 'Bus Name', 'trim|required');
//    $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
//    $this->form_validation->set_rules('end_date', 'End Date', 'trim|required');
    if ($this->form_validation->run() == TRUE) {

        $student_id = $this->input->post('student_id');
        $data['student_id'] = $this->input->post('student_id');
        $year = $this->globalSettingsRunningYear;
        $roll_number = $this->Enroll_model->get_enrollid_by_student($student_id, $year);

        $enroll_code = $roll_number->enroll_code;
        $data['enroll_code'] = $enroll_code;
        $data['route_id'] = $this->input->post('route');
        $data['bus_stop_id'] = $this->input->post('bustop_id');
        $data['bus_id'] = $this->input->post('bus');
        $data['start_date'] = date('Y/m/d', (strtotime($this->input->post('start_date'))));
        $data['end_date'] = date('Y/m/d', (strtotime($this->input->post('end_date'))));
        $count = $this->Student_bus_allocation_model->get_data_by_cols('count(student_id) as count', array('student_id' => $data['student_id']), 'res_arr');
        if ($count[0]['count'] <= 0) {
            $this->load->model('Transport_model');
            $this->Transport_model->add_student($data);
            $this->update_student_transport($student_id, $data['bus_stop_id']);
            $data2['transport_id'] = $data['bus_stop_id'];
            $this->load->model('Student_model');
            $this->Student_model->update_student($data2, array("student_id" => $student_id));
            $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?school_admin/manage_student_bus', 'refresh');
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('this_student_is_already_using_bus_facility'));
            redirect(base_url() . 'index.php?school_admin/student_bus_allocation', 'refresh');
        }
    } else {
        $this->session->set_flashdata('flash_message_error', validation_errors());
        redirect(base_url() . 'index.php?school_admin/student_bus_allocation', 'refresh');
    }
    $page_data['page_title'] = get_phrase('student_bus_allocation');
    $page_data['page_name'] = 'student_bus_allocation';
    $this->load->view('backend/index', $page_data);
}

/*
 * Update student transport invoice 
 */

function update_student_transport($student_id, $transport_data) {
    $this->load->library('Fi_functions');
    $page_data = $this->get_page_data_var();
    $academic_year = $this->globalSettingsRunningYear;
    $student_fee_det = $this->fi_functions->getStudentFeeSettings($student_id, $academic_year);
    if ($student_fee_det) {
        $transport_fee = $student_fee_det[0]->trans_fee_id;
        if ($transport_fee != 0) {
            $fee_det = get_data_generic_fun('fees_fi', '*', array('route_id' => $transport_data['bus_stop_id']));
            $fee_id = $fee_det[0]['fi_id'];
            if ($transport_fee != 0 && $transport_fee != $fee_id) {
                $data = array('trans_fee_id' => $fee_id);
                $update_transport_fee = $this->fi_functions->update_student_fee_det(array('student_id' => $student_id, 'academic_year' => $academic_year), $data);
                $update_invoice = $this->fi_functions->update_transport_invoice($student_id, $old_fee_id, $fee_id);
            }
        } else {
            $update_transport_fee = $this->fi_functions->add_transport_fee($student_id, $fee_id, $academic_year);
        }
    } else {
        $add_student_fee_config = $this->add_student_fee_config($student_id, $transport_data);
    }
}

/*
 * Update student transport invoice 
 */

function update_student_dormitory($student_id, $dormitory_data) {
    $this->load->library('Fi_functions');
    $page_data = $this->get_page_data_var();
    $academic_year = $this->globalSettingsRunningYear;
    $student_fee_det = $this->fi_functions->getStudentFeeSettings($student_id, $academic_year);
    if ($student_fee_det) {
        $hostel_fee = $student_fee_det[0]->hostel_fee_id;
        if ($hostel_fee != 0) {
            $fee_det = get_data_generic_fun('fees_fi', '*', array('room_id' => $dormitory_data['room_id']));
            $fee_id = $fee_det[0]['fi_id'];
            if ($hostel_fee != 0 && $hostel_fee != $fee_id) {
                $data = array('hostel_fee_id' => $fee_id);
                $update_hostel_fee = $this->fi_functions->update_student_fee_det(array('student_id' => $student_id, 'academic_year' => $academic_year), $data);
                $update_invoice = $this->fi_functions->update_transport_invoice($student_id, $old_fee_id, $fee_id);
            }
        } else {
            $update_transport_fee = $this->fi_functions->add_transport_fee($student_id, $fee_id, $academic_year);
        }
    } else {
        return true;
        $add_student_fee_config = $this->add_student_fee_config($student_id, $dormitory_data);
    }
}

function manage_student_bus() {
    $page_data = $this->get_page_data_var();
    $this->load->model("Student_model");
    $this->load->model("Transport_model");
    $students = $this->Student_bus_allocation_model->get_data_by_cols('*', array(), 'result_array');
    foreach ($students as $value) {
        $student_name = $this->Student_model->get_data_by_cols('name', array('student_id' => $value['student_id']), 'result_array');
        //$student_name = $student1[0]['name'];
        $year = $this->globalSettingsSMSDataArr[6]->description;
        $class_section = $this->Enroll_model->get_class_section_by_student($value['student_id'], $year);
        if (!empty($class_section)) {
            $class_name[]['class_name'] = $class_section->class_name;
            $section_name[]['section_name'] = $class_section->section_name;
        } else {
            $class_name[]['class_name'] = "";
            $section_name[]['section_name'] = "";
        }
        if (!empty($student_name)) {
            $students_name[]['student_name'] = $student_name[0]['name'];
        } else {
            $students_name[]['student_name'] = '';
        }
        $route_name = $this->Transport_model->get_data_by_cols('route_name', array('transport_id' => $value['route_id']), 'result_array');
        if (!empty($route_name)) {
            $routes_name[]['route_name'] = $route_name[0]['route_name'];
        } else {
            $routes_name[]['route_name'] = '';
        }
        $bus = $this->Bus_model->get_data_by_cols('name', array('bus_id' => $value['bus_id']), 'result_array');
        if (!empty($bus)) {
            $bus_name[]['bus_name'] = $bus[0]['name'];
        } else {
            $bus_name[]['bus_name'] = '';
        }
    }
    $i = 0;
    $newArray = array();
    foreach ($students as $row) {
        $newArray[$i] = array_merge($row, $students_name[$i], $routes_name[$i], $bus_name[$i], $class_name[$i], $section_name[$i]);
        $i++;
    }
    $page_data['student_details'] = $newArray;
    $page_data['page_title'] = get_phrase('manage_student');
    $page_data['page_name'] = 'manage_student_bus';
    //pre($page_data); die;
    $this->load->view('backend/index', $page_data);
}

function report_product_service() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $service = $this->Inventory_product_service_model->get_data_by_cols('*', array(), 'result_array', array('service_id' => 'DESC'));
    $vendor_details = array();
    $vendor = array();
    foreach ($service as $row) {
        $product = $this->Inventory_product_model->get_data_by_cols('product_name', array('product_id' => $row['product_id']), 'result_array');
        if (!empty($product)) {
            $product_name[]['product_name'] = $product[0]['product_name'];
        } else {
            $product_name[]['product_name'] = "";
        }
        $vendor = $this->Seller_model->get_data_by_cols('*', array('seller_id' => $row['vendor_id']), 'result_array');
        if (!empty($vendor)) {
            $vendor_details[] = $vendor[0];
        } else {
            $vendor_details[] = $vendor_details;
        }
    }
    $i = 0;
    $newArray = array();
    foreach ($service as $value) {
        $newArray[$i] = array_merge($value, $product_name[$i], $vendor_details[$i]);
        $i++;
    }
    $page_data['service_details'] = $newArray;
    $page_data['page_title'] = get_phrase('report_product_service');
    $page_data['page_name'] = 'product_report';
    $this->load->view('backend/index', $page_data);
}

function get_promote_to_class($class_id = "") {
    $class_details = $this->Class_model->get_data_by_cols('*', array('class_id' => $class_id), 'result_array');
    foreach ($class_details as $class) {

        $name = $this->Class_model->get_data_by_cols('class_id,name', array('name_numeric >' => $class['name_numeric']), 'result_array', array('name_numeric' => 'asc'));
    }
    $response_html = '<option value="">Select Class</option>';
    foreach ($name as $row) {
        $response_html .= '<option value="' . $row['class_id'] . '">' . $row['name'] . '</option>';
    }
    echo $response_html;
}

/* For disciplinary menu */
/*
  function disipline(){
  $page_data['page_title']                =   get_phrase('report_incident');
  $page_data['page_name']                 =   'report_incident';
  $this->load->view('backend/index', $page_data);
  }
  function disipline_incident(){
  $page_data['page_title']                =   get_phrase('action_incident');
  $page_data['page_name']                 =   'action_incident';
  $this->load->view('backend/index', $page_data);
  }
 */

// --------------------------------------------------------------------------
/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */

function bus_details($param1 = "") {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');    

    if ($param1 == 'create') {
        $this->load->model('vehicle_details');
        //echo '<pre>';print_r($_POST);exit;
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('bus', 'Bus', 'trim|required');
        $this->form_validation->set_rules('purchase_date', 'Purchase Date', 'trim|required');
        $this->form_validation->set_rules('service_date', 'Service Date', 'trim|required');
        $this->form_validation->set_rules('vendor_company', 'Vendor Company', 'trim|required');
        $this->form_validation->set_rules('vendor_name', 'Vendor Name', 'trim|required');
        $this->form_validation->set_rules('vendor_contact', 'Vendor Contact', 'trim|required');
        $this->form_validation->set_rules('cost', 'Cost', 'trim|required');
        $this->form_validation->set_rules('credit_facility', 'Credit Facility', 'trim|required');
        $this->form_validation->set_rules('insurance_expiry_date', 'insurance expiry date', 'trim|required');
        //$this->form_validation->set_rules('route_id', 'Route', 'trim|required');
        //$this->form_validation->set_rules('driver_id', 'Driver', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $data['bus_id'] = $this->input->post('bus');
            //$data['route_id'] = $this->input->post('route_id');
            //$data['driver_id'] = $this->input->post('driver_id');
            $data['purchase_date'] = date('Y/m/d', (strtotime($this->input->post('purchase_date'))));
            $data['service_date'] = date('Y/m/d', (strtotime($this->input->post('service_date'))));
            $data['vendor_company'] = $this->input->post('vendor_company');
            $data['vendor_name'] = $this->input->post('vendor_name');
            $data['vendor_contact'] = $this->input->post('vendor_contact');
            $data['vehicle_cost'] = $this->input->post('cost');
            $data['credit_facility_from_vendor'] = $this->input->post('credit_facility');
            $data['insurance_expiry_date'] = date('Y/m/d', (strtotime($this->input->post('insurance_expiry_date'))));
            $data['status'] = "Active";

            if($data['bus_id']!=''){
                $rs = $this->vehicle_details->get_bus_driver_with_route_data($data['bus_id']);
                $data['route_id'] = @$rs->route_id; 
                $data['driver_id'] = @$rs->bus_driver_id;
            }else{
                $this->session->set_flashdata('flash_message_error', get_phrase('bus_is_not_selected'));
                redirect(base_url() . 'index.php?school_admin/bus_details', 'refresh');
            }

            if ($data['route_id'] && $data['driver_id']) {
                $this->vehicle_details->add_vehicel_details($data);
                $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
                redirect(base_url() . 'index.php?school_admin/manage_vehicle_details', 'refresh');
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('error_route_or_bus_drive_is_not_alloted_to_this_bus'));
                redirect(base_url() . 'index.php?school_admin/bus_details', 'refresh');
            }
        } else {
            $this->session->set_flashdata('flash_message_error', validation_errors());
            redirect(base_url() . 'index.php?school_admin/bus_details', 'refresh');
        }
    }
    $page_data = $this->get_page_data_var();
    $page_data['bus'] = $this->Bus_model->get_data_by_cols('*', array(), 'result_array');
    $page_data['page_title'] = get_phrase('vehicle_service_maintenance');
    $page_data['page_name'] = 'bus_details';
    $this->load->view('backend/index', $page_data);
}

/* for Merit Certificate   */

function merit_certificate() {
    $page_data = $this->get_page_data_var();
    $page_data['merit_certificate_details'] = $newArray;
    $page_data['page_title'] = get_phrase('merit_certificate');
    $page_data['page_name'] = 'merit_certificate';
    $this->load->view('backend/index', $page_data);
}

public function overall_class_details($class_id = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    if ($class_id == '') {
        $page_data['class_id'] = $this->Class_model->get_first_class_id();
    } else {
        $page_data['class_id'] = $class_id;
    }
    $page_data['teachers'] = $this->Class_model->get_teachers_by_class($page_data['class_id']);
    $page_data['class_name'] = get_data_generic_fun('class', 'name', array('class_id' => $page_data['class_id']), 'result_arr');
    $running_year = $this->Setting_model->get_year();
    $page_data['syllabus'] = get_data_generic_fun('academic_syllabus', '*', array('class_id' => $page_data['class_id'], 'year' => $running_year));
    $page_data['books'] = get_data_generic_fun('book', '*', array('class_id' => $page_data['class_id']));
    $page_data['study_info'] = get_data_generic_fun('document', '*', array('class_id' => $page_data['class_id']));
    $page_data['classes'] = $this->Class_model->get_data_by_cols('*', array(), 'result_array', array('name_numeric' => 'ORDER BY', 'name' => 'ASC'));
    $page_data['page_title'] = get_phrase('overall_details');
    $page_data['page_name'] = 'class_details';
    $this->load->view('backend/index', $page_data);
}

function get_exams($param1 = '') {

    $this->load->model('Evaluation_model');
    $exams = $this->Evaluation_model->get_exams(strtoupper($param1));
    echo '<option value="">Select Exams</option>';

    foreach ($exams as $row) {

        echo '<option value="' . $row['exam_id'] . '">' . $row['name'] . '</option>';
    }
}

function cwa_marks($param1 = '') {
    $data['student_id'] = $this->input->post('student_id');
    $data['exam.exam_id'] = $this->input->post('exam_id');
    $this->load->model('Evaluation_model');
    $page_data = $this->get_page_data_var();
    $marks = $this->Evaluation_model->get_cwa_marks($data);
    foreach ($marks as $k => $row):
        $markSubject = $this->Subject_model->get_data_by_cols("name", array('subject_id' => $row['subject_id']), "result_array");
        $marks[$k]['subject_name'] = $markSubject[0]['name'];
    endforeach;
    $page_data['marks'] = $marks;
    $page_data['page_title'] = get_phrase('cwa_marksheet');
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $this->load->view('backend/school_admin/cwa_marksheet', $page_data);
}

function gpa_marks($param1 = '') {
    $page_data = $this->get_page_data_var();
    $data['student_id'] = $this->input->post('student_id');
    $data['exam.exam_id'] = $this->input->post('exam_id');
    $this->load->model('Evaluation_model');
    $marks = $this->Evaluation_model->get_gpa_marks($data);
    $page_data['marks'] = $marks;
    $total_credit = 0;
    $total_weightage = 0;

    foreach ($marks as $k => $v):
        $total_credit = $total_credit + $v['credit_hours'];
        $gpa = $this->Evaluation_model->get_grade($v['mark_obtained'], "GPA")[0];
        $weightage = $gpa['grade_point'] * $v['credit_hours'];
        $total_weightage = $total_weightage + $weightage;
        $marks[$k]['total_weightage'] = $total_weightage;
        $marks[$k]['subject_name'] = $this->subject_model->single_name($row['subject_id']);
    endforeach;

    $page_data['page_title'] = get_phrase('gpa_marksheet');
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $this->load->view('backend/school_admin/gpa_marksheet', $page_data);
}

function manage_vehicle_details($param1 = '', $param2 = '', $param3 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $this->load->model('Vehicle_details');
    $page_data['details'] = $this->Vehicle_details->get_all_details();
    $page_data['page_title'] = get_phrase('manage_vehicle_details');
    $page_data['page_name'] = 'manage_vehicle_details';
    $this->load->view('backend/index', $page_data);

    if ($param1 == 'service') {
        $data['status'] = "service";
        $dataArr['vehicle_details_id'] = $param2;
        $dataArr['date_of_service'] = date('Y-m-d H:i:s');
        $dataArr['reason_for_service'] = $this->input->post('reason');
        $dataArr['vendor_name'] = $this->input->post('vendor_name');
        $dataArr['vendor_phone_no'] = $this->input->post('vendor_phone_no');
        $dataArr['vendor_address'] = $this->input->post('vendor_address');
        $this->load->model('vehicle_service_maintenance_model');
        $this->load->model('vehicle_details');
        $this->vehicle_service_maintenance_model->add($dataArr);
        $this->vehicle_details->updatebyId($param2, $data);
        $this->session->set_flashdata('flash_message', get_phrase('vehicle is_sent for_service_sucessfully'));
        redirect(base_url() . 'index.php?school_admin/manage_vehicle_details/', 'refresh');
    }
    if ($param1 == "return_from_service") {
        $data['status'] = "Return From Service";
        $dataArr['return_date_from_service'] = date('Y-m-d H:i:s');
        $dataArr['reason_for_service'] = $this->input->post('reason');
        $dataArr['vendor_name'] = $this->input->post('vendor_name');
        $dataArr['vendor_phone_no'] = $this->input->post('vendor_phone_no');
        $dataArr['vendor_address'] = $this->input->post('vendor_address');
        $dataArr['payment_type'] = $this->input->post('payment_type');
        $dataArr['cost_for_service'] = $this->input->post('cost_for_service');
        $this->load->model('vehicle_service_maintenance_model');
        $this->load->model('vehicle_details');
        $this->vehicle_service_maintenance_model->updatebyId($param2, $dataArr);
        $this->vehicle_details->updatebyId($param3, $data);
        $this->session->set_flashdata('flash_message', get_phrase('vehicle return from_service_sucessfully'));
        redirect(base_url() . 'index.php?school_admin/manage_vehicle_details/', 'refresh');
    }
}

function delete_ranking($param1 = '', $param2 = '') {
    if ($param1 != '') {
        $evaluation_method = $param1;
    }
    if ($param2 != '') {
        $id = $param2;
    }
    $this->load->model('Evaluation_model');
    if (!empty($id) && !empty($evaluation_method)) {
        $this->Evaluation_model->delete_ranking($id, $evaluation_method);
        $this->session->set_flashdata('flash_message', get_phrase('ranking_deleted_successfully'));
    }
    redirect(base_url() . 'index.php?school_admin/exam_settings', 'refresh');
}

/* * *******MANAGE STUDY MATERIAL*********** */

function study_material($class_id = '', $param1 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model("Class_model");
    $this->load->model("Crud_model");
    $page_data = $this->get_page_data_var();
    $data = $page_data;
    if ($class_id == '') {
        $data['class_id'] = $this->Class_model->get_first_class_id();
    } else {
        $data['class_id'] = $class_id;
    }
    $data['study_material_info'] = $this->Crud_model->get_study_material($data['class_id']);
    $data['classes'] = $this->Class_model->get_data_by_cols('*', array(), 'result_array', array('name_numeric' => 'asc'));
    $data['page_name'] = 'study_material';
    $data['page_title'] = get_phrase('study_material');
    $this->load->view('backend/index', $data);
}

function check_availabiltiy_routes($route_id = '') {
    $this->load->model("Section_model");
    $this->load->model("Enroll_model");
    $max_capacity = $this->Bus_model->get_data_by_cols('sum(number_of_seat) as max', array('route_id' => $route_id), 'result_array');
    $students_allotted = $this->Student_bus_allocation_model->get_data_by_cols('count(student_id) as count', array('route_id' => $route_id), 'result_array');
    if (!empty($max_capacity)) {
        $page_data['capacity'] = $max_capacity[0]['max'];
    } else {
        $page_data['capacity'] = '';
    }
    if (!empty($students_allotted)) {
        $page_data['student_alloted'] = $students_allotted['0']['count'];
    } else {
        $page_data['student_alloted'] = 0;
    }
    if (!empty($max_capacity)) {
        $avaiablity = $this->Bus_model->get_data_by_cols('sum(number_of_seat)-' . $students_allotted['0']['count'] . ' as available', array('route_id' => $route_id), 'result_array');
    } else {
        $avaiablity = "";
    }
    echo "Maximum no: of seats: " . $page_data['capacity'];
    echo "<br>";
    echo "Total no: of students alloted: " . $page_data['student_alloted'] . '<br>';
    echo "Availablity: " . $avaiablity[0]['available'];
}

function add_student_hostel_enquiry($hostel_id = '', $student_id = '', $hostel_room_id = '') {

    //$data=$page_data;
    $data['$page_datastudent_id'] = $student_id;
    $type = $this->Dormitory_model->get_data_by_cols('hostel_type', array('dormitory_id' => $hostel_id), 'result_array');
    $data['hostel_type'] = $type[0]['hostel_type'];
    $data['hostel_id'] = $hostel_id;

    $details = $this->Hostel_room_model->get_data_by_cols('floor_name,room_number', array('hostel_room_id' => $hostel_room_id), 'result_array');
    $data['floor_name'] = $details[0]['floor_name'];
    $data['room_no'] = $details[0]['room_number'];
    $data['food'] = "No";
    $data['register_date'] = date('Y/m/d');
    $data['status'] = "present";
    $data['active_status'] = "active";
    $count = $this->Hostel_registration_model->get_data_by_cols('count(student_id) as count', array('student_id' => $student_id), 'result_array');
    if ($count[0]['count'] <= 0) {
        $this->load->model('Hostel_registration_model');
        $this->Hostel_registration_model->add($data);
        $data2['hostel_room_id'] = $hostel_room_id;
        $this->load->model('Hostel_room_model');
        $this->Hostel_room_model->update_available($data2);
        $data3['dormitory_id'] = $hostel_id;
        $data3['dormitory_room_number'] = $hostel_room_id;
        $this->load->model('Student_model');
        $this->Student_model->update_student($data3, array("student_id" => $student_id));
        echo get_phrase("successfully_student is_added to_dormitory");
    } else {
        echo get_phrase("this_student is_already_present in_dormitory");
    }
}

function add_student_bus_enquiry($student_id = '', $route_bus_stop_id = '') {
    $data['student_id'] = $student_id;
    $year = $this->globalSettingsSMSDataArr[2]->description;
    $roll_number = $this->Enroll_model->get_data_by_cols('enroll_code', array('student_id' => $student_id, 'year' => $year), 'result_array');
    $data['enroll_code'] = $roll_number[0]['enroll_code'];
    $data['route_id'] = $route_bus_stop_id;

    $data['start_date'] = date('Y/m/d');

    $count = $this->Student_bus_allocation_model->get_data_by_cols('count(student_id) as count', array('student_id' => $student_id), 'result_array');
    if ($count[0]['count'] <= 0) {
        $this->load->model('Transport_model');
        $this->Transport_model->add_student($data);
        $data2['transport_id'] = $route_bus_stop_id;
        $this->load->model('Student_model');
        $this->Student_model->update_student($data2, array("student_id" => $student_id));
        echo get_phrase("successfully_student is_added to_transport");
    } else {
        echo get_phrase("this_student is_already_present in_transport");
    }
}

public function save_fees_settings() {
    $feeData = array();
    $fees_name = $this->input->post('fees_name');
    $fees_amount = explode('-', $this->input->post('fees_amount'));
    if (!empty($fees_amount)) {
        $feeData['fi_id'] = $fees_amount[0];
        $feeData['amount'] = $fees_amount[1];
        $feeData['fees_name'] = $fees_name;
        $this->load->model('Fee_fi_model');
        if ($this->Fee_fi_model->add($feeData)) {
            $this->session->set_flashdata('flash_message', get_phrase('fees_details_added!!'));
            redirect(base_url() . 'index.php?school_admin/student_enquired_view', 'refresh');
        } else {
            $this->session->set_flashdata('flash_message', get_phrase('fees_details_not_added!!'));
            redirect(base_url() . 'index.php?school_admin/student_enquired_view', 'refresh');
        }
    }
    redirect(base_url() . 'index.php?school_admin/student_enquired_view', 'refresh');
}

public function notifications() {
    $page_data = $this->get_page_data_var();
    $this->load->model("Notification_model");
    $user_id = $this->session->userdata('login_user_id');
    $user_notif_user = $this->Notification_model->get_notifications('push_notifications', 'admin', $user_id);
    $user_notif_user_type = $this->Notification_model->get_notifications('push_notifications', 'admin');
    $user_notif_common = $this->Notification_model->get_notifications('push_notifications');

    $admin_notifications = array_merge($user_notif_user, $user_notif_user_type);

    $page_data['user_notifications'] = $admin_notifications;
    $page_data['common_notifications'] = $user_notif_common;

    $page_data['page_name'] = 'notifications';
    $page_data['page_title'] = get_phrase('manage_notifications');
    $this->load->view('backend/index', $page_data);
}

function route_bus_stop($param1 = '', $param2 = '', $param3 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $page_data = $this->get_page_data_var();
    $this->load->model('Route_bus_stop_model');
    $this->load->model('Fee_fi_model');
    if ($param1 == 'create') {
        $this->form_validation->set_rules('route_id', 'Route Name', 'trim|required');
//        $this->form_validation->set_rules('number_of_stops', 'Number of Stops', 'trim|required');
        $this->form_validation->set_rules('route_from', 'Route From', 'trim|required');
        $this->form_validation->set_rules('route_to', 'Route To', 'trim|required');
        $this->form_validation->set_rules('route_fare', 'Route Fare', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_message_error', validation_errors());
            redirect(base_url() . 'index.php?school_admin/parent/');
        } else {
            $data['route_id'] = $this->input->post('route_id');
            //$data['no_of_stops'] = $this->input->post('number_of_stops');
            $data['route_from'] = $this->input->post('route_from');
            $data['route_to'] = $this->input->post('route_to');
            if(sett('new_fi')){
                $data['route_fare'] = $this->input->post('route_fare');
                $route_bus_stop_id = $this->Route_bus_stop_model->add($data);
            }else{
                $charges_deatils = $this->input->post('route_fare');
                $pieces = explode("|", $charges_deatils);
                $charges_amount = $pieces[0];
                $charges_id = $pieces[1];
                $data['route_fare'] = $charges_amount;
                $route_bus_stop_id = $this->Route_bus_stop_model->add($data);
                $route = $this->Transport_model->get_data_by_cols('route_name', array('transport_id' => $data['route_id']), 'result_array');
                if (!empty($route)) {
                    $route_name = $route[0]['route_name'];
                }
                $data2['fees_name'] = "Transport_Fees-" . $route_name;
                $data2['fi_id'] = $charges_id;
                $data2['amount'] = $charges_amount;
                $data2['route_id'] = $route_bus_stop_id;
                $this->Fee_fi_model->add($data2);
            }
            $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?school_admin/route_bus_stop', 'refresh');
        }
    }
    if ($param1 == 'edit') {
        $this->form_validation->set_rules('route_id', 'Route Name', 'trim|required');
        //$this->form_validation->set_rules('number_of_stops', 'Number of Stops', 'trim|required');
        $this->form_validation->set_rules('route_from', 'Route From', 'trim|required');
        $this->form_validation->set_rules('route_to', 'Route To', 'trim|required');
        $this->form_validation->set_rules('route_fare', 'Route Fare', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_message_error', validation_errors());
            //redirect(base_url() . 'index.php?school_admin/parent/');
        } else {
            $data['route_id'] = $this->input->post('route_id');
            //$data['no_of_stops'] = $this->input->post('number_of_stops');
            $data['route_from'] = $this->input->post('route_from');
            $data['route_to'] = $this->input->post('route_to');
            if(sett('new_fi')){
                $data['route_fare'] = $this->input->post('route_fare');
                $route_bus_stop_id = $this->Route_bus_stop_model->update_routes($data, $condition);
            }else{
                $charges_deatils = $this->input->post('route_fare');
                $pieces = explode("|", $charges_deatils);
                $charges_amount = $pieces[0];
                $charges_id = $pieces[1];
                $data['route_fare'] = $charges_amount;
                $condition = $param2;
                $route_bus_stop_id = $this->Route_bus_stop_model->update_routes($data, $condition);
                $route = $this->Transport_model->get_data_by_cols('route_name', array('transport_id' => $data['route_id']), 'result_array');
                if (!empty($route)) {
                    $route_name = $route[0]['route_name'];
                }
                $data2['fees_name'] = "Transport_Fees-" . $route_name;
                $data2['fi_id'] = $charges_id;
                $data2['amount'] = $charges_amount;
                $data2['route_id'] = $route_bus_stop_id;
                $this->load->model('fee_fi_model');
                $this->fee_fi_model->update_transport_charge($data2, $route_bus_stop_id);
            }
            $this->session->set_flashdata('flash_message', get_phrase('data_updated_successfully'));
            redirect(base_url() . 'index.php?school_admin/route_bus_stop', 'refresh');
        }
    }
    if ($param1 == 'delete') {
        if ($this->Route_bus_stop_model->delete_route($param2)) {
            $this->Fee_fi_model->delete_route($param2);
            $this->session->set_flashdata('flash_message', get_phrase('bus stop_deleted_successfully!!'));
            redirect(base_url() . 'index.php?school_admin/route_bus_stop', 'refresh');
        }
    }
    $this->load->library("fi_functions");
    $this->load->model('Route_bus_stop_model');
    $page_data['details'] = $this->Route_bus_stop_model->get_details();
    $running_year = $this->globalSettingsRunningYear;
    $charges = $this->fi_functions->get_routecharges($running_year);
    $page_data['charges'] = $charges;
    //echo '<pre>';print_r($page_data['charges']);exit;
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['routes'] = $this->Transport_model->get_data_by_cols('*', array(), 'result_array');
    $page_data['page_name'] = 'route_bus_stop';
    $page_data['page_title'] = get_phrase('manage_bus_stop');
    $this->load->view('backend/index', $page_data);
}

function fee_structure($param1 = '', $param2 = '', $param3 = '') {
    $this->load->model("Admin_model");
    $page_data = $this->get_page_data_var();
    if ($param1 == 'create') {

        $data['title'] = $this->input->post('title');
        $data['effected_from'] = $this->input->post('effected_from');

        $files = $_FILES['fee_structure'];
        $file_name = strtotime(date("Y-m-d H:i:s"));
        $this->load->library('upload');
        $config['upload_path'] = 'uploads/FeeStructure/';
        $config['allowed_types'] = 'jpg|pdf|jpeg|doc|docx';
        $config['remove_spaces'] = FALSE;
        $config['file_name'] = $file_name . '_' . $files['name'];

        $_FILES['file_name']['name'] = $files['name'];
        $_FILES['file_name']['type'] = $files['type'];
        $_FILES['file_name']['tmp_name'] = $files['tmp_name'];
        $_FILES['file_name']['size'] = $files['size'];
        $this->upload->initialize($config);
        if ($this->upload->do_upload('fee_structure')) {
            $data['fee_structure'] = $file_name . '_' . $files['name'];
            if ($this->Admin_model->upload_fee_structure($data)) {
                $this->session->set_flashdata('flash_message', get_phrase('fee_structure_uploaded'));
            }
            redirect(base_url() . 'index.php?school_admin/fee_structure', 'refresh');
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('Sorry, File extension is not supported, please upload only .jpg, .jpeg, .pdf, .doc, .docx'));
            redirect(base_url() . 'index.php?school_admin/fee_structure', 'refresh');
        }
    } else if (($param1 == 'ToggleEnable') && ($param3 != '')) {
        $dataArray = array('fee_structure_id' => $param2, 'status' => $param3);
        if ($this->Admin_model->do_toggle_enable_fee_structure($dataArray)) {
            if ($param3 == 1) {
                echo 'Disabled';
            } else {
                echo 'Enabled';
            }
        }
    } else {
        $page_data['page_name'] = 'fee_structure';
        $page_data['page_title'] = get_phrase('fee_structure');
        $condition = array();
        $page_data['all_fee_structure'] = $this->crud_model->get_records("fee_structure", $condition, "*", "fee_structure_id", "desc");
        $this->load->view('backend/index', $page_data);
    }
}

function delete_fee_structure($fee_structure_id) {
    $this->load->model("Admin_model");
    $file_name = $this->crud_model->get_record('fee_structure', $condition = array('fee_structure_id' => $fee_structure_id), $field = "fee_structure");
    if (count($file_name)) {
        $fee_file_name = $file_name['fee_structure'];
        if (file_exists("uploads/FeeStructure/" . $fee_file_name)) {
            $this->Admin_model->do_delete_fee_structure($fee_structure_id);
            $this->session->set_flashdata('flash_message', get_phrase('fee_structure_deleted'));
            unlink("uploads/FeeStructure/" . $fee_file_name);
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('Sorry, unable to delete !'));
        }
    } else {
        $this->session->set_flashdata('flash_message_error', get_phrase('Sorry, unable to delete !'));
    }
    redirect(base_url() . 'index.php?school_admin/fee_structure/', 'refresh');
}

function download_fee_structure($fee_structure_id = '') {
    if ($fee_structure_id != '') {
        $file_name = $this->crud_model->get_record('fee_structure', $condition = array('fee_structure_id' => $fee_structure_id), $field = "fee_structure");
        if (count($file_name)) {
            $fee_file_name = $file_name['fee_structure'];
            if (file_exists("uploads/FeeStructure/" . $fee_file_name)) {
                $this->load->helper('download');
                $data = file_get_contents("uploads/FeeStructure/" . $fee_file_name);
                force_download($fee_file_name, $data);
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('Sorry, failed to download !'));
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('Sorry, failed to download !'));
            redirect($_SERVER['HTTP_REFERER']);
        }
    } else {
        $this->session->set_flashdata('flash_message_error', get_phrase('Sorry, failed to download !'));
        redirect($_SERVER['HTTP_REFERER']);
    }
}

function subject_bulk_upload_error() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_title'] = get_phrase('subject_bulk_upload_error');
    $page_data['page_name'] = 'subject_bulk_upload_error';
    $this->load->view('backend/index', $page_data);
}

function subject_display_bulk_upload_errors() {
    $error = TRUE;
    if ($error) {
        $file_name = 'uploads/subject_bulk_upload_error_details.log';
        $error_messages = file_get_contents($file_name);
        $messages = json_decode($error_messages);
    }
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['messages'] = $messages;
    $page_data['page_title'] = get_phrase('display_upload_errors');
    $page_data['page_name'] = 'subject_display_bulk_upload_errors';
    $this->load->view('backend/index', $page_data);
}

function download_subject_bulk_upload_error_file() {
    $this->load->helper('download');
    $data = file_get_contents('uploads/subject_bulk_upload_error_details_for_excel_file.xlsx');
    //$name = 'parent_bulk_upload_error_details_for_excel_file.xlsx';
    $name = 'subject_bulk_upload_error_details_for_excel_file.xlsx';
    force_download($name, $data);
}

function admission_settings() {
    $this->load->model("Admission_settings_model");
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_title'] = get_phrase('Admission_settings');
    $page_data['page_name'] = 'admission_settings';
    $cYear = date('Y') + 1;
    $student_running_year = ($cYear - 1) . '-' . ($cYear);
    $rsCSetting = $this->Admission_settings_model->get_admission_settings_by_running_year($student_running_year);
    if (empty($rsCSetting)) {
        $page_data['admission_settings_state'] = 1;
        /// set as open state
        $this->Admission_settings_model->add(array('running_year' => $student_running_year, 'isActive' => 1, 'off_date' => date('Y-m-d')));
    } else {
        $page_data['admission_settings_state'] = $rsCSetting[count($rsCSetting) - 1]->isActive;
    }

    $page_data['cYear'] = $cYear;
    $page_data['student_running_year'] = $student_running_year;

    $this->load->view('backend/index', $page_data);
}

function admission_settings_update() {
    $this->load->model("Admission_settings_model");
    $this->form_validation->set_rules('running_year', 'Running Year', 'trim|required');
    if ($this->form_validation->run() == false) {
        $error = validation_errors();
        $this->session->flashdata('flash_message_error', $error);
        redirect(base_url() . 'index.php?school_admin/admission_settings', 'refresh');
    } else {
        $admission_settings_state = $this->input->post("admission_settings_state", TRUE);
        $running_year = $this->input->post("running_year", TRUE);
        if ($admission_settings_state == 'on')
            $admission_settings_state = 1;
        else
            $admission_settings_state = 0;

        if ($admission_settings_state == 1) {
            $this->session->flashdata('flash_message_error', "You can't re-open the admission process,Better go by Direct Admission Process");
        } else {
            $this->Admission_settings_model->delete_all_incatiive($running_year);
            $this->Admission_settings_model->add(array('running_year' => $running_year, 'isActive' => $admission_settings_state, 'off_date' => date('Y-m-d')));
            /// now do the generate the roll no for all student for all class and sectiion.
            $rsStudent = $this->Student_model->get_all_student_for_roll_no_set($running_year);
            //pre($rsStudent); die;
            $start = 1;
            $section_id = 0;
            $roll_no = 1;
            $this->load->model('Enroll_model');
            foreach ($rsStudent as $key => $value) {
                if ($start == 1) {
                    $section_id = $value->section_id;
                    $start = 0;
                    $this->Enroll_model->enroll_update(array('roll' => $roll_no), array('student_id' => $value->student_id));
                    $roll_no++;
                } else {
                    if ($section_id == $value->section_id) {
                        $this->Enroll_model->enroll_update(array('roll' => $roll_no), array('student_id' => $value->student_id));
                        $roll_no++;
                    } else {
                        $roll_no = 1;
                        $this->Enroll_model->enroll_update(array('roll' => $roll_no), array('student_id' => $value->student_id));
                        $roll_no++;
                        $section_id = $value->section_id;
                    }
                }
            }
            $this->session->flashdata('flash_message_error', "Roll no updated succuess fully for " . $running_year . " session.");
        }
        redirect(base_url() . 'index.php?school_admin/admission_settings', 'refresh');
    }
}

function exam_bulk_upload_error() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_title'] = get_phrase('exam_bulk_upload_error');
    $page_data['page_name'] = 'exam_bulk_upload_error';
    $this->load->view('backend/index', $page_data);
}

function exam_display_bulk_upload_errors() {
    $error = TRUE;
    if ($error) {
        $file_name = 'uploads/exam_bulk_upload_error_details.log';
        $error_messages = file_get_contents($file_name);
        $messages = json_decode($error_messages);
    }
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['messages'] = $messages;
    $page_data['page_title'] = get_phrase('display_upload_errors');
    $page_data['page_name'] = 'exam_display_bulk_upload_errors';
    $this->load->view('backend/index', $page_data);
}

function download_exam_bulk_upload_error_file() {
    $this->load->helper('download');
    $data = file_get_contents('uploads/exam_bulk_upload_error_details_for_excel_file.xlsx');
    //$name = 'exam_bulk_upload_error_details_for_excel_file.xlsx';
    $name = 'exam_bulk_upload_error_details_for_excel_file.xlsx';
    force_download($name, $data);
}

function bus_details_bulk_upload_error() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_title'] = get_phrase('bus_details_bulk_upload_error');
    $page_data['page_name'] = 'bus_details_bulk_upload_error';
    $this->load->view('backend/index', $page_data);
}

function bus_details_display_bulk_upload_errors() {
    $error = TRUE;
    if ($error) {
        $file_name = 'uploads/bus_details_bulk_upload_error_details.log';
        $error_messages = file_get_contents($file_name);
        $messages = json_decode($error_messages);
    }
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['messages'] = $messages;
    $page_data['page_title'] = get_phrase('display_upload_errors');
    $page_data['page_name'] = 'bus_details_display_bulk_upload_errors';
    $this->load->view('backend/index', $page_data);
}

function download_bus_details_bulk_upload_error_file() {
    $this->load->helper('download');
    $data = file_get_contents('uploads/bus_details_bulk_upload_error_details_for_excel_file.xlsx');
    //$name = 'bus_details_bulk_upload_error_details_for_excel_file.xlsx';
    $name = 'bus_details_bulk_upload_error_details_for_excel_file.xlsx';
    force_download($name, $data);
}

function my_profile() {
    $page_data = $this->get_page_data_var();
    $page_data['edit_data'] = $this->Admin_model->get_data_by_cols('*', array('admin_id' => $this->session->userdata('admin_id')), 'result_array');
    $page_data['page_title'] = get_phrase('my_profile');
    $page_data['page_name'] = 'my_profile';
    $this->load->view('backend/index', $page_data);
}

function bus_driver_bulk_upload_error() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_title'] = get_phrase('bus_driver_bulk_upload_error');
    $page_data['page_name'] = 'bus_driver_bulk_upload_error';
    $this->load->view('backend/index', $page_data);
}

function bus_driver_display_bulk_upload_errors() {
    $error = TRUE;
    if ($error) {
        $file_name = 'uploads/bus_driver_bulk_upload_error_details.log';
        $error_messages = file_get_contents($file_name);
        $messages = json_decode($error_messages);
    }
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['messages'] = $messages;
    $page_data['page_title'] = get_phrase('display_upload_errors');
    $page_data['page_name'] = 'bus_driver_display_bulk_upload_errors';
    $this->load->view('backend/index', $page_data);
}

function download_bus_driver_bulk_upload_error_file() {
    $this->load->helper('download');
    $data = file_get_contents('uploads/bus_driver_bulk_upload_error_details_for_excel_file.xlsx');
    //$name = 'bus_driver_bulk_upload_error_details_for_excel_file.xlsx';
    $name = 'bus_driver_bulk_upload_error_details_for_excel_file.xlsx';
    force_download($name, $data);
}

function grade_bulk_upload_error() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_title'] = get_phrase('grade_bulk_upload_error');
    $page_data['page_name'] = 'grade_bulk_upload_error';
    $this->load->view('backend/index', $page_data);
}

function grade_display_bulk_upload_errors() {
    $error = TRUE;
    if ($error) {
        $file_name = 'uploads/grade_bulk_upload_error_details.log';
        $error_messages = file_get_contents($file_name);
        $messages = json_decode($error_messages);
    }
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['messages'] = $messages;
    $page_data['page_title'] = get_phrase('display_upload_errors');
    $page_data['page_name'] = 'grade_display_bulk_upload_errors';
    $this->load->view('backend/index', $page_data);
}

function download_grade_bulk_upload_error_file() {
    $this->load->helper('download');
    $data = file_get_contents('uploads/grade_bulk_upload_error_details_for_excel_file.xlsx');
    //$name = 'grade_bulk_upload_error_details_for_excel_file.xlsx';
    $name = 'grade_bulk_upload_error_details_for_excel_file.xlsx';
    force_download($name, $data);
}

public function generate_admission_invoice($student_id, $academic_year = '') {
    $this->load->library('Fi_functions');
    $academic_year = $academic_year ? $academic_year : $this->globalSettingsRunningYear;
    $result = $this->fi_functions->create_admission_invoice($student_id, $academic_year);
    return $result;
}

/*
 * update transaction in invoice creation
 * @param int $invoice_id
 * @return int transaction id 
 */

//    public function updateTransaction($invoice_id) {
//        $this->load->library('Fi_functions');
//        $result             =   $this->fi_functions->updateTransaction( $invoice_id );
//        print_r($result);die();
//    }

function routes_bulk_upload_error() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_title'] = get_phrase('routes_bulk_upload_error');
    $page_data['page_name'] = 'routes_bulk_upload_error';
    $this->load->view('backend/index', $page_data);
}

function routes_display_bulk_upload_errors() {
    $error = TRUE;
    if ($error) {
        $file_name = 'uploads/routes_bulk_upload_error_details.log';
        $error_messages = file_get_contents($file_name);
        $messages = json_decode($error_messages);
    }
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['messages'] = $messages;
    $page_data['page_title'] = get_phrase('display_upload_errors');
    $page_data['page_name'] = 'routes_display_bulk_upload_errors';
    $this->load->view('backend/index', $page_data);
}

function download_routes_bulk_upload_error_file() {
    $this->load->helper('download');
    $data = file_get_contents('uploads/routes_bulk_upload_error_details_for_excel_file.xlsx');
    //$name = 'routes_bulk_upload_error_details_for_excel_file.xlsx';
    $name = 'routes_bulk_upload_error_details_for_excel_file.xlsx';
    force_download($name, $data);
}

function mark_bulk_upload_error() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_title'] = get_phrase('mark_bulk_upload_error');
    $page_data['page_name'] = 'mark_bulk_upload_error';
    $this->load->view('backend/index', $page_data);
}

function mark_display_bulk_upload_errors() {
    $error = TRUE;
    if ($error) {
        $file_name = 'uploads/mark_bulk_upload_error_details.log';
        $error_messages = file_get_contents($file_name);
        $messages = json_decode($error_messages);
    }
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['messages'] = $messages;
    $page_data['page_title'] = get_phrase('display_upload_errors');
    $page_data['page_name'] = 'mark_display_bulk_upload_errors';
    $this->load->view('backend/index', $page_data);
}

function download_mark_bulk_upload_error_file() {
    $this->load->helper('download');
    $data = file_get_contents('uploads/mark_bulk_upload_error_details_for_excel_file.xlsx');
    //$name = 'mark_bulk_upload_error_details_for_excel_file.xlsx';
    $name = 'mark_bulk_upload_error_details_for_excel_file.xlsx';
    force_download($name, $data);
}

function batch_summary($class_id = '', $student_running_year = "", $datetaken = "") {
    $this->load->model("Class_model");
    $this->load->model("Attendance_model");
    $this->load->model("Subject_model");
    $page_data = $this->get_page_data_var();
    if ($class_id == "") {
        $class_id = $this->Class_model->get_first_class_id();
    }
    if (!$student_running_year == "") {
        $student_running_year = $this->globalSettingsRunningYear;
    }
    if ($datetaken == "") {
        $date1 = new DateTime(date("Y-m-d"));
        $date = $date1->getTimestamp();
        $page_data['date'] = date("m-d-Y");
    } else {
        $month = $this->uri->segment(5);
        $date = $this->uri->segment(6);
        $year = $this->uri->segment(7);
        $date3 = "$month-$date-$year";
        $date2 = "$year-$month-$date";
        $date1 = new DateTime($date2);
        $date = $date1->getTimestamp();
        $page_data['date'] = $date3;
    }

    $page_data['class_id'] = $class_id;
    $page_data['classes'] = $this->Class_model->get_data_by_cols('*', array(), 'result_array', array('name_numeric' => 'asc'));
    $student_running_year = $this->globalSettingsRunningYear;
    $page_data['student_running_year'] = $student_running_year;
    /*     * ****************************start_student_tab************* */

    $page_data['student_details'] = $this->Student_model->get_batch_details($class_id, $student_running_year);
    $page_data['student_count'] = count($page_data['student_details']);

    /*     * ****************************end_student_tab************* */
    /*     * ****************************start_attendance_tab************* */

    $page_data['present'] = $this->Attendance_model->get_present_attendance($class_id, $student_running_year, $date);
    $page_data['absent'] = $this->Attendance_model->get_absentees_attendance($class_id, $student_running_year, $date);
    $page_data['undefinied'] = $this->Attendance_model->get_undefinied_students($class_id, $student_running_year, $date);
    $page_data['count_undefinied'] = count($page_data['undefinied']);
    $page_data['total_attendance'] = $this->Attendance_model->get_total_students($class_id, $student_running_year, $date);
    $page_data['count_attendance'] = count($page_data['total_attendance']);
    $page_data['count_present'] = count($page_data['present']);
    $page_data['count_absent'] = count($page_data['absent']);

    /*     * ****************************end_attendance_tab************* */
    /*     * ****************************start_subject_and_teacher_tab************* */

    $page_data['subject_details'] = $this->Subject_model->get_batch_subject_details($class_id, $student_running_year);
    $page_data['subject_teacher_count'] = $this->Subject_model->get_batch_subject_teacher_count($class_id, $student_running_year);

    /*     * ****************************end_subject_and_teacher_tab************* */

    $page_data['page_title'] = get_phrase('batch_summary');
    $page_data['page_name'] = "batch_summary";
    $this->load->view('backend/index', $page_data);
}

function send_sms_for_low_attendance($student_id = '', $percentage = '') {
    $student_name = $this->Student_model->get_student_name($student_id);
    $parent_id = $this->Student_model->get_parent_id($student_id);
    $receiver_phone = $this->Parent_model->get_phone($parent_id);
    $message = 'Your child' . ' ' . $student_name . 'has attendence percentage is' . $percentage . '% of this month';
    send_school_notification('stud_absence', $message, $receiver_phone, '', $student_name);
    $this->session->set_flashdata('flash_message', get_phrase('message_send_successfuly'));
    redirect($_SERVER['HTTP_REFERER']);
}

function download_study_material() {
    $this->load->helper('download');
    if ($this->uri->segment(3)) {
        $data = file_get_contents(base_url() . '/uploads/document/' . $this->uri->segment(3));
    }
    $name = $this->uri->segment(3);
    force_download($name, $data);
}

function update_study_material($param1 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $file_uploaded = $_FILES['file_name']['name'];
    $allowed_types = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'image/png',
        'image/jpg',
        'image/jpeg',
        'text/plain',
        'application/pdf',
        'application/msword');

    if (in_array($_FILES['file_name']['type'], $allowed_types)) {
        $this->crud_model->update_study_material_info($param1);
        $class_id = $this->input->post('class_id');
        $this->session->set_flashdata('flash_message', get_phrase('study_material_info_updated_successfuly'));
        redirect(base_url() . 'index.php?school_admin/study_material/' . $class_id, 'refresh');
    } else {
        $this->session->set_flashdata('flash_message_error', 'Sorry, File extension is not supported');
        redirect(base_url() . 'index.php?school_admin/study_material/' . $class_id, 'refresh');
    }
}

function get_student_dormatory($StudentId = '') {
    $this->load->model("Dormitory_model");
    if ($StudentId != '') {

        $data = $this->Dormitory_model->get_Student_dormatory($StudentId);

        if (count($data)) {
            $hostel_type = $data[0]['hostel_type'];
            $hostel_type_data = $this->Dormitory_model->get_data_by_cols('dormitory_id, name, hostel_type', array('hostel_type' => $hostel_type, 'status' => 'Active'), 'result_array');
            $result['hostel_type_data'] = $hostel_type_data;
            $result['dormitory_id'] = $data[0]['dormitory_id'];

            echo json_encode($result);
        } else {
            echo 'no';
        }
    }
}

//This is for help menu/page in navigation
function help() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['page_title'] = get_phrase('help');
    $page_data['page_name'] = 'help';
    $this->load->view('backend/index', $page_data);
}

//CREATE NEW CERTIFICATE by Beant Kaur
function create_ceritificate($student_id = '', $certificate_type = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $this->load->model("Student_certificate_model");
    $this->load->model("Student_model");
    $ceritificate_title = $this->input->post('ceritificate_title');
    $sub_title = $this->input->post('sub_title');
    $main_cantent = $this->input->post('main_cantent');
    $student_id = $this->input->post('student_id');
//    echo $student_id; die;
    $this->Student_certificate_model->save_certificate($ceritificate_title, $sub_title, $main_cantent, $student_id);
    $page_data['student'] = $this->Student_model->get_student_record(array('student_id' => $student_id));
    $page_data['ceritificate_title'] = $ceritificate_title;
    $page_data['sub_title'] = $sub_title;
    $page_data['main_cantent'] = $main_cantent;
    $page_data['page_title'] = get_phrase('student_certificate');
    $page_data['page_name'] = 'student_certificates';

    $this->load->view('backend/index', $page_data);
}

function experience_certificate($param1 = '', $param2='') {
    $page_data = $this->get_page_data_var();
    $this->load->model('Experience_certificate_model');
    if($param1==''){
        $teacher_id = $this->input->post('teacher_ids');
    }else{
        $teacher_id = $param1;
    }
    
    if($param2 == 'create'){
    $data['job_title'] = $this->input->post('job_title');
    $data['from_data'] = $this->input->post('join_date');
    $data['to_date'] = $this->input->post('end_date');
    $data['designation'] = $this->input->post('designation');
    $data['teacher_id'] = $teacher_id;
    $data['is_approve'] = "1";
    $this->Experience_certificate_model->add($data);
    $this->session->set_flashdata('flash_message', get_phrase('experience_certificate_approve_successfully'));
    redirect(base_url() . 'index.php?school_admin/experience_certificate/' . $teacher_id, 'refresh');
    }
    $page_data['certificate_detail'] = $this->Experience_certificate_model->get_data_by_id($param1);
    $rsTeacherData = $this->Teacher_model->get_teacher_name($teacher_id);
    $page_data['teacher_data'] = $rsTeacherData;
    $page_data['teacher_id'] = $teacher_id;
    $page_data['page_title'] = get_phrase('experience_certificate');
    $page_data['page_name'] = 'experience_certificate';
    $this->load->view('backend/index', $page_data);
}

function internship_certificate($param1 = '', $param2 = '') {
    $this->load->model('Experience_certificate_model');
    if($param1!=''){
    $teacher_id = $param1;    
    }else{
    $teacher_id = $this->input->post('teacher_ids');
    }
    if($param2 == 'create'){
    $data['certificate_create_date'] = date('d-m-Y');
    $data['from_Date'] = $this->input->post('from_Date');
    $data['to_date'] = $this->input->post('to_date');
    $data['teacher_id'] = $teacher_id;
    $data['is_approve'] = "1";
    $this->Experience_certificate_model->add_internship_certificate($data);
    $this->session->set_flashdata('flash_message', get_phrase('internship_certificate_approve_successfully'));
    redirect(base_url() . 'index.php?school_admin/internship_certificate/' . $teacher_id, 'refresh');
    }
    $rsTeacherData = $this->Teacher_model->get_teacher_name($teacher_id);
    $page_data = $this->get_page_data_var();
    $page_data['certificate_detail'] = $this->Experience_certificate_model->get_internship_certificate_by_id($teacher_id);
    $page_data['teacher_data'] = $rsTeacherData;
    $page_data['teacher_id'] = $teacher_id;
    $page_data['page_title'] = get_phrase('internship_certificate');
    $page_data['page_name'] = 'internship_certificate';
    $this->load->view('backend/index', $page_data);
}

function student_bus($param1, $student_bus_id) {
    $page_data = $this->get_page_data_var();
    if ($param1 == 'edit') {
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('route', 'Route', 'trim|required');
        $this->form_validation->set_rules('bus', 'Bus Name', 'trim|required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
        $this->form_validation->set_rules('end_date', 'End Date', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_message_error', validation_errors());
            redirect(base_url() . 'index.php?school_admin/manage_student_bus');
        } else {
            $data['route_id'] = $this->input->post('route');
            $data['bus_stop_id'] = $this->input->post('bustop_id');
            $data['bus_id'] = $this->input->post('bus');
            $data['start_date'] = date('Y/m/d', (strtotime($this->input->post('start_date'))));
            $data['end_date'] = date('Y/m/d', (strtotime($this->input->post('end_date'))));
            $this->load->model('Student_bus_allocation_model');
            $this->Student_bus_allocation_model->updatebyId($data, $student_bus_id);
            $this->session->set_flashdata('flash_message', get_phrase('data_updated_successfully'));
            redirect(base_url() . 'index.php?school_admin/manage_student_bus', 'refresh');
        }
    }
    if ($param1 == 'delete') {
        $this->load->model('Student_bus_allocation_model');
        $this->Student_bus_allocation_model->delete($student_bus_id);
        $this->session->set_flashdata('flash_message', get_phrase('data_sucessfully_deleted'));
        redirect(base_url() . 'index.php?school_admin/manage_student_bus/', 'refresh');
    }
}

/* IBO Programs assessments */

function ibo_program($param1 = '', $param2 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Class_model');
    $this->load->model('Cce_model');
    $page_data = $this->get_page_data_var();
    if ($param1 == 'add') {
        $program_name = $this->input->post('program_name');
        $ibo_data['program_name'] = $program_name;
        $this->Class_model->ibo_add_program($ibo_data);
        $this->session->set_flashdata('flash_message', get_phrase('IBO_program_added'));
        redirect(base_url() . 'index.php?school_admin/exam_settings/', 'refresh');
    }

    if ($param1 == 'delete') {
        $is_program_connect_to_class = $this->Cce_model->is_program_connect_to_class($param2);
        if (empty($is_program_connect_to_class)) {
            $this->Cce_model->delete_ibo_program($param2);
            $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('program_is_connected_with_class'));
        }
        redirect(base_url() . 'index.php?school_admin/exam_settings/', 'refresh');
    }
    if ($param1 == 'update') {
        $program_id = $param2;
        $data['program_name'] = $this->input->post('program_name');
        $update = $this->Cce_model->update_ibo_program($data, $program_id);

        if ($update) {
            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        }
        redirect(base_url() . 'index.php?school_admin/exam_settings/', 'refresh');
    }
}

function ibo_program_assign_class() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $this->load->model('Class_model');
    $class = $this->input->post('ibo_class');
    $program = $this->input->post('ibo_program');
    $save_data['class_id'] = $class;
    $save_data['program_id'] = $program;
    $this->Class_model->ibo_program_assign_class($save_data);
    $this->session->set_flashdata('flash_message', get_phrase('IBO_program_assigned_to_class'));
    redirect(base_url() . 'index.php?school_admin/exam_settings/', 'refresh');
}

function ibo_subjects($param1 = '', $param2 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Subject_model');
    $this->load->model('Cce_model');
    $page_data = $this->get_page_data_var();
    if ($param1 == 'delete') {
        $this->Cce_model->delete_subject($param2);
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?school_admin/exam_settings/', 'refresh');
    }

    if ($param2 == 'add') {
        // pre($this->input->post());
        //exit;
        $selected_subject = $this->input->post('selected_subject');
        $selected_weekly_classes = $this->input->post('selected_weekly_classes');
        $selected_sixth_subject = $this->input->post('selected_sixth_subject');
        $selected_asl = $this->input->post('selected_asl');
        $selected_no_exam = $this->input->post('selected_no_exam');
        $i = 0;

        foreach ($selected_subject as $row) {
            $dataArray['subject_id'] = $row;
            $dataArray['weekly_classes'] = $selected_weekly_classes[$i];
            if ($selected_asl != NULL) {
                if (in_array($row, $selected_asl)) {
                    $dataArray['asl'] = 1;
                } else {
                    $dataArray['asl'] = 0;
                }
            }
            if ($selected_sixth_subject != NULL) {
                if (in_array($row, $selected_sixth_subject)) {
                    $dataArray['sixth_subject'] = 1;
                } else {
                    $dataArray['sixth_subject'] = 0;
                }
            }
            if ($selected_no_exam != NULL) {
                if (in_array($row, $selected_no_exam)) {
                    $dataArray['no_exam'] = 1;
                } else {
                    $dataArray['no_exam'] = 0;
                }
            }
            $this->Cce_model->save_cce_subject($dataArray);
            $i++;
        }
        $this->session->set_flashdata('flash_message', get_phrase('subjects_added_to_IBO_evaluation'));
        $page_data['page_name'] = 'exam_settings';
        $page_data['page_title'] = get_phrase('exam_settings');
        //$this->load->view('backend/index', $page_data);
        redirect($_SERVER['HTTP_REFERER']);
    }

    if ($param1 == 'do_update') {
        $data['subject_id'] = $this->input->post('selected_subject');
        $data['weekly_classes'] = $this->input->post('selected_weekly_classes');
        $data['sixth_subject'] = ($this->input->post('selected_sixth_subject')) ? 1 : 0;
        $data['asl'] = ($this->input->post('selected_asl')) ? 1 : 0;
        $data['no_exam'] = ($this->input->post('selected_no_exam')) ? 1 : 0;

        $rs = $this->Cce_model->update_cce_subject($data, array('id' => $param2));

        if ($rs) {
            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        }
        redirect(base_url() . 'index.php?school_admin/exam_settings/', 'refresh');
    }


    $subjects = $this->Cce_model->get_cce_subjects(array('class_id' => $param1));
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['cce_class_id'] = $param1;
    $page_data['subjects'] = $subjects;
    $page_data['page_name'] = 'ajax_ibo_subjects';
    $page_data['page_title'] = get_phrase('ibo_subjects');

    $page_data['class_subjects'] = $this->Subject_model->get_subject_array(array('class_id' => $param1));

    $this->load->view('backend/school_admin/ajax_ibo_subjects.php', $page_data);
}

function ibo_programs_assessments($param1 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $this->load->model('Subject_model');
    $this->load->model('Cce_model');

    $subjects = $this->Cce_model->get_cce_subjects(array('class_id' => $param1));
    $page_data['selected_class'] = $param1;
    $page_data['subjects'] = $subjects;

    $page_data['class_id'] = $param1;
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_name'] = 'ajax_ibo_assessments';
    $page_data['page_title'] = get_phrase('ibo_assessments');
    //pre($page_data); die();
    $this->load->view('backend/school_admin/ajax_ibo_assessments.php', $page_data);
}

function ibo_add_assessments($param1 = '', $param2 = '') {
    $this->load->model('Cce_model');
    $page_data = $this->get_page_data_var();
    $save_data['assessment_name'] = $this->input->post('assessment');
    $save_data['class_id'] = $this->input->post('class_id');
    $save_data['subject_id'] = $this->input->post('subject_id');

    $this->Cce_model->ibo_add_assessments($save_data);
    $this->session->set_flashdata('flash_message', get_phrase('assessment_add_successfully'));
    redirect($_SERVER['HTTP_REFERER']);
}

function ibo_exam_connect($param1 = '', $param2 = '') {
    $page_data = $this->get_page_data_var();
    if ($param1 == 'connect') {
        $connect_exam[] = $this->input->post('selected_exam');

        $page_data['ibo_exam_id'] = $connect_exam;
        $save_data = array();
        if (count($connect_exam[0])) {
            foreach ($connect_exam[0] as $row) {
                $save_data['ibo_exam_id'] = $row;
                $save_data['ibo_connect_status'] = 1;
                $this->Exam_model->ibo_exam_connect($save_data);
            }
        }
        $this->session->set_flashdata('flash_message', get_phrase('exam_connected'));
        redirect($_SERVER['HTTP_REFERER']);
    }

    if ($param1 == 'delete') {
        $this->Exam_model->delete_ibo_connect_exam($param2);
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?school_admin/exam_settings/', 'refresh');
    }
}

function ibo_report_card() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['classes'] = $this->Class_model->get_ibo_classes();
    $page_data['page_name'] = 'ibo_report_card';
    $page_data['page_title'] = get_phrase('report_card');
    $this->load->view('backend/index', $page_data);
}

function ibo_manage_marks() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Exam_model');
    $page_data = $this->get_page_data_var();
    $page_data['exams'] = $this->Exam_model->ibo_exam();
    $page_data['classes'] = $this->Class_model->get_ibo_classes();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_name'] = 'ibo_manage_marks';
    $page_data['page_title'] = get_phrase('manage_ibo_exam_marks');
    $this->load->view('backend/index', $page_data);
}

function marks_update_ibo($exam_id = '', $class_id = '', $section_id = '', $subject_id = '') {
    $this->load->model('Mark_model');

    $running_year = $this->globalSettingsRunningYear;
    $maximum_marks = $this->input->post('maximum_marks');
    $marks_of_students = $this->Mark_model->get_data_by_cols_ibo('*', array('exam_id' => $exam_id, 'class_id' => $class_id, 'section_id' => $section_id,
        'year' => $running_year,
        'subject_id' => $subject_id
            ), 'result_type');

    $students = $this->Enroll_model->get_data_by_cols('*', array(
        'class_id' => $class_id, 'section_id' => $section_id, 'year' => $running_year
            ), 'result_type');

    $count_students = count($students);

    for ($k = 0; $k < $count_students; $k++) {

        $subjAssessData = $this->db->select()->from('ibo_subject_assessments')->where(array('class_id' => $class_id, 'subject_id' => $subject_id))->get()->result_array();

        $count_subjAssessData = count($subjAssessData);

        for ($i = 0; $i < $count_subjAssessData; $i++) {

            $assessment = $this->input->post('assessment_id_' . $k);
            $student = $this->input->post('student_id_' . $k);
            $mark_obtained1 = $this->input->post('marks_obtained_' . $k);
            $comment = $this->input->post('comment_' . $k);
            if ($comment == NULL) {
                $comment = '';
            }
            //echo $comment.'<br/>';
            //pre($_POST).'<br/>';
            //pre($comment);
            $this->db->select('*');
            $this->db->from('ibo_marks');
            $this->db->where(array('exam_id' => $exam_id, 'class_id' => $class_id, 'section_id' => $section_id, 'subject_id' => $subject_id, 'assessment_id' => $assessment[$i], 'student_uid' => $student[$i]));
            $get_data = $this->db->get()->result_array();
            /* echo $this->db->last_query();
              echo '<br/>';
              pre($get_data); */
            $count_get_data = count($get_data);
            //echo $this->db->last_query().'<br/>';
            if ($count_get_data > 0) {
                $this->Mark_model->ibo_update_marks(array('exam_id' => $exam_id, 'class_id' => $class_id, 'section_id' => $section_id, 'subject_id' => $subject_id, 'student_uid' => $student[$i], 'assessment_id' => $assessment[$i],), array('mark_obtained' => $mark_obtained1[$i], 'comment' => $comment, 'mark_total' => $maximum_marks));
                /* echo $this->db->last_query().'<br/>'; */
            }
        }
    }
    $this->session->set_flashdata('flash_message', get_phrase('marks_updated'));
    redirect(base_url() . 'index.php?school_admin/marks_manage_view/' . $exam_id . '/' . $class_id . '/' . $section_id . '/' . $subject_id, 'refresh');
}

function ibo_marks_selector() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Mark_model');
    $this->load->model('Enroll_model');

    $data['exam_id'] = $this->input->post('exam_id');
    $data['class_id'] = $this->input->post('class_id');
    $data['section_id'] = $this->input->post('section_id');
    $data['subject_id'] = $this->input->post('subject_id');
    $data['year'] = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');

    $query = $this->Mark_model->get_data_by_cols_ibo('*', array(
        'exam_id' => $data['exam_id'],
        'class_id' => $data['class_id'],
        'section_id' => $data['section_id'],
        'subject_id' => $data['subject_id'],
        'year' => $data['year']
            ), 'result_type');

    $subjAssessData = $this->db->select()->from('ibo_subject_assessments')->where(array('class_id' => $data['class_id'], 'subject_id' => $data['subject_id']))->get()->result_array();

    $count_subjAssessData = count($subjAssessData);

    if (count($query) < 1) {
        $students = $this->Enroll_model->get_data_by_cols('*', array(
            'class_id' => $data['class_id'], 'section_id' => $data['section_id'], 'year' => $data['year']
                ), 'result_type');

        foreach ($students as $row) {
            $data['student_uid'] = $row['student_id'];
            foreach ($subjAssessData as $Assessment) {
                $data['assessment_id'] = $Assessment['assessment_id'];
                $this->Mark_model->save_ibo($data);
            }
        }
    }
    redirect(base_url() . 'index.php?school_admin/marks_manage_view/' . $data['exam_id'] . '/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['subject_id'], 'refresh');
}

function ibo_marksheet_selector() {
    $data['class_id'] = $this->input->post('class_id');
    $data['section_id'] = $this->input->post('section_id');
    $data['year'] = $this->input->post('year');
    $data['timestamp'] = strtotime($this->input->post('timestamp'));
    $data['student_id'] = $this->input->post('student_id');

    $query = $this->db->get_where('enroll', array(
        'class_id' => $data['class_id'],
        'student_id' => $data['student_id'],
        'year' => $data['year']
    ));

    redirect(base_url() . 'index.php?school_admin/ibo_marksheet_view/' . $data['class_id'] . '/' . $data['student_id'], 'refresh');
}

function ibo_marksheet_view($class_id = '', $student_id = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $class_name = $this->db->get_where('class', array('class_id' => $class_id))->row()->name;
    
    $subjects = $this->Cce_model->get_cce_subjects(array('class_id' => $class_id));

    $subjAssessData = $this->Cce_model->get_ibo_assessment($class_id);

    $all_marks = $this->Cce_model->get_ibo_assessment_marks($student_id);

    $page_data['subjects'] = $subjects;
    
    foreach($subjects as $k => $sub){
        $sub_id = $sub['subject_id'];
        
        $page_data['subjects'][$k]['MarksData'] = array();
        foreach($all_marks as $k2=> $marks){
            if($marks['subject_id'] == $sub_id){
                $page_data['subjects'][$k]['MarksData'][] = $marks['mark_obtained'];
            }
        }

        $subjects[$k]['asses_name'] = array();

        foreach($subjAssessData as $AssData){
            if($AssData['subject_id'] == $sub_id){
                $page_data['subjects'][$k]['asses_name'][] = $AssData['assessment_name'];
            }    
        }
    }

    $page_data['class_id'] = $class_id;
    $page_data['page_name'] = 'ibo_marksheet_view';

    $student_name = $this->db->get_where('student', array('student_id' => $student_id))->row()->name;

    $page_data['student_id'] = $student_id;
    $page_data['page_title'] = get_phrase('marksheet_of') . ' ' . $student_name . ' : ' . get_phrase('class') . ' ' . $class_name;
    $page_data['class_name'] = $class_name;
    $page_data['total_notif_num'] = $this->get_no_of_notication();

    /* Student Details */
    $page_data['student_info'] = $this->Student_model->get_student_details($student_id);
    if (!empty($page_data['student_info'])) {
        $class_id = $page_data['student_info']->class_id;
        $section_id = $page_data['student_info']->section_id;
    }
    $page_data['parents'] = $this->Parent_model->get_parents_array();
    $this->load->view('backend/index', $page_data);
}

/* IBO Programs assessments */

function library($param1 = '', $param2 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect('login', 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['search_text'] = '';

    if (($param1 == 'search') && ($param2 != '')) {
        $page_data['search_text'] = $param2;
    }

    $page_data['page_title'] = get_phrase("student's library");
    $page_data['page_name'] = 'student_library';

    $this->load->view('backend/index', $page_data);
}

function mess_management($param1 = "") {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Mess_management_model');
    $page_data = $this->get_page_data_var();
    if ($param1 == "create") {
        $this->form_validation->set_rules('name', 'Mess Name', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_message_error', validation_errors());
        } else {
            $data['name'] = $this->input->post('name');
            $data['description'] = $this->input->post('description');
            $data['amount'] = $this->input->post('amount');
            $this->Mess_management_model->save_mess_details($data);
            $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?school_admin/mess_management/', 'refresh');
        }
    }
    $page_data['mess_fee_list'] = $this->Mess_management_model->get_mess_fees(array('FT.type_slug' => 'mess_fee'));
    //echo '<pre>';print_r($data['mess_fee_list']);exit;
    $page_data['page_title'] = get_phrase("mess_management");
    $page_data['page_name'] = 'mess_management';
    $this->load->view('backend/index', $page_data);
}

function mess_timetable($mess_id = "") {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Mess_management_model');
    $this->load->model('Mess_timetable_model');
    $page_data = $this->get_page_data_var();
    if ($mess_id == "") {
        $mess_id = $this->Mess_management_model->get_first_mess_id();
    }
    for ($d = 1; $d <= 7; $d++) {
        if ($d == 1)
            $day = 'sunday';
        else if ($d == 2)
            $day = 'monday';
        else if ($d == 3)
            $day = 'tuesday';
        else if ($d == 4)
            $day = 'wednesday';
        else if ($d == 5)
            $day = 'thursday';
        else if ($d == 6)
            $day = 'friday';
        else if ($d == 7)
            $day = 'saturday';
        $routiness[$day] = $this->Mess_timetable_model->get_data_by_cols('*', array('mess_management_id' => $mess_id, 'day' => $day), 'result_array');
    }
    $page_data['routines'] = $routiness;
    $page_data['mess_name'] = $this->Mess_management_model->get_data_by_cols('*', array(), 'result_array');
    $page_data['page_title'] = get_phrase("mess_timetable");
    $page_data['page_name'] = 'mess_time_table';
    $page_data['mess_id'] = $mess_id;
    $this->load->view('backend/index', $page_data);
}

function add_mess_time_table($param1 = "", $param2 = "") {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Mess_management_model');
    $this->load->model('Mess_timetable_model');
    $page_data = $this->get_page_data_var();
    if ($param1 == "create") {
        $this->form_validation->set_rules('mess_id', 'Mess Name', 'trim|required');
        $this->form_validation->set_rules('day', 'Day', 'trim|required');
        $this->form_validation->set_rules('type', 'Type', 'trim|required');
        $this->form_validation->set_rules('food', 'Food', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_message_error', validation_errors());
        } else {
            $data['mess_management_id'] = $this->input->post('mess_id');
            $data['day'] = $this->input->post('day');
            $data['type'] = $this->input->post('type');
            $data['food'] = $this->input->post('food');
            $count_day = $this->Mess_timetable_model->get_data_by_cols('count(day) as count_day', array('day' => $data['day'], 'type' => $data['type'], 'mess_management_id' => $data['mess_management_id']), 'result_array');

            if ($count_day[0]['count_day'] == 0) {
                $this->Mess_timetable_model->save_mess_timetable_details($data);
                $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
                redirect(base_url() . 'index.php?school_admin/mess_timetable/' . $data['mess_management_id'], 'refresh');
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('Could not add because we have food already in ' . $data['day'] . " " . $data['type']));
                redirect(base_url() . 'index.php?school_admin/add_mess_time_table/', 'refresh');
            }
        }
    }
    if ($param1 == "edit") {
        $mess_id = $this->input->post('mess_id');
        $this->form_validation->set_rules('food', 'Food', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_message_error', "could not edit because " . validation_errors());
            redirect(base_url() . 'index.php?school_admin/mess_timetable/' . $mess_id, 'refresh');
        } else {
            $data['food'] = $this->input->post('food');
            $this->Mess_timetable_model->update($data, $param2);
            $this->session->set_flashdata('flash_message', get_phrase('data_updated_successfully'));
            redirect(base_url() . 'index.php?school_admin/mess_timetable/' . $mess_id, 'refresh');
        }
    }
    $page_data['mess_name'] = $this->Mess_management_model->get_data_by_cols('*', array(), 'result_array');
    $page_data['page_title'] = get_phrase("add_mess_timetable");
    $page_data['page_name'] = 'add_mess_timetable';
    $this->load->view('backend/index', $page_data);
}

/* CCE Grading Method */

function cs_activities($param1 = "", $param2 = "") {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    if ($param1 == 'add') {
        $coscholastic_name = $this->input->post('csa_name');
        $class_id = $this->input->post('class_id');
        $year = $this->globalSettingsRunningYear;

        $data['csa_name'] = $coscholastic_name;
        $data['class_id'] = $class_id;
        $data['year'] = $year;
        //pre($data); die();
        $this->Cce_model->add_cs_activities($data);
        $this->session->set_flashdata('flash_message', get_phrase('Co-Scholastic_added'));
        redirect($_SERVER['HTTP_REFERER']);
    }

    if ($param1 == 'update') {
        /* echo 'param1 = '.$param1.'<br/>';
          echo 'param2 = '.$param2.'<br/>';
          die(); */
        $coscholastic_name = $this->input->post('csa_name');
        $coscholastic_id = $param2;

        $data['csa_name'] = $coscholastic_name;

        $this->Cce_model->update_cs_activities($data, $coscholastic_id);
        $this->session->set_flashdata('flash_message', get_phrase('Co-Scholastic_updated'));
        redirect($_SERVER['HTTP_REFERER']);
    }

    if ($param1 == 'delete') {
        $this->Cce_model->delete_cs_activities($param2);
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect($_SERVER['HTTP_REFERER']);
    }

    $page_data['cce_class_id'] = $param1;
    $cs_activities = $this->Cce_model->cce_coscholastic_activities('class_id', $page_data['cce_class_id']);

    $page_data['cs_activities'] = $cs_activities;

    $page_data['page_name'] = 'ajax_coscholastic_activities';
    $page_data['page_title'] = get_phrase('Co-Scholoastic_activities');
    //pre($page_data); die();
    $this->load->view('backend/school_admin/ajax_coscholastic_activities.php', $page_data);
}

function csa_marks_manage() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['classes'] = $this->Cce_model->get_cce_classes();
    $page_data['page_name'] = 'marks_cs_activities';
    $page_data['page_title'] = get_phrase('manage_co-Scholatic_activity_marks');
    $this->load->view('backend/index', $page_data);
}

function csa_marks_selector() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');

    $data['class_id'] = $this->input->post('class_id');
    /* $data['section_id'] = $this->input->post('section_id'); */
    $data['csa_id'] = $this->input->post('cs_activity');
    $data['term'] = $this->input->post('term');
    $data['year'] = $this->globalSettingsRunningYear;

    $query = $this->db->get_where('cce_coscholatic_activities', array(
        'class_id' => $data['class_id'],
        /* 'term' => $data['term'], */
        'csa_id' => $data['csa_id'],
        'year' => $data['year']
    ));

    //echo $query->num_rows(); die();
    if ($query->num_rows()) {
        $students = $this->db->get_where('enroll', array(
                    'class_id' => $data['class_id'], 'year' => $data['year']
                ))->result_array();
        foreach ($students as $row) {
            $chkExist = $this->Cce_model->is_student_exixts(array(
                        'class_id' => $data['class_id'], 'student_id' => $row['student_id'], 'csa_id' => $data['csa_id'], 'year' => $data['year'], 'term' => $data['term']
                    ));

            if (count($chkExist) == 0) {
                $data['student_id'] = $row['student_id'];
                $this->Cce_model->add_sudents_to_csa($data);
            }
        }
    }
    redirect(base_url() . 'index.php?school_admin/csa_marks_manage_view/' . $data['class_id'] . '/' . $data['csa_id'] . '/' . $data['term'], 'refresh');
}

function csa_marks_manage_view($class_id = '', $csa_id = '', $term = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $running_year = $this->globalSettingsRunningYear;
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['class_id'] = $class_id;
    $page_data['csa_id'] = $csa_id;
    $page_data['term'] = $term;
    $page_data['marks_of_students'] = $this->Cce_model->csa_marks_of_students(array('class_id' => $class_id, 'year' => $running_year, 'csa_id' => $csa_id, 'term' => $term));
    foreach ($page_data['marks_of_students'] as $k => $v) {
        $data_arr = array('student_id' => $v['student_id']);
        $page_data['marks_of_students'][$k]['result'] = $this->Enroll_model->get_data_by_cols("*", $data_arr, "result");
        $data_ar = array('student_id' => $v['student_id']);
        $page_data['marks_of_students'][$k]['result1'] = $this->Student_model->get_data_by_cols("*", $data_ar, "result");
    }
    $page_data['classes'] = $this->Class_model->get_cce_classes();
    $page_data['cs_activities'] = $this->Cce_model->cce_coscholastic_activities('class_id', $page_data['class_id']);
    $page_data['page_name'] = 'csa_marks_manage_view';
    $page_data['page_title'] = get_phrase('manage_csa_marks');
    $this->load->view('backend/index', $page_data);
}

function csa_marks_update($class_id = '', $csa_id = '', $term = '') {
    $running_year = $this->globalSettingsRunningYear;
    $marks_of_students = $this->db->get_where('cce_coscholatic_grades', array(
                'class_id' => $class_id,
                /* 'section_id' => $section_id, */
                'year' => $running_year,
                'term' => $term,
                'csa_id' => $csa_id
            ))->result_array();

    foreach ($marks_of_students as $row) {
        $obtained_marks = $this->input->post('csa_grade_' . $row['csa_grade_id']);
        $comment = $this->input->post('comment_' . $row['csa_grade_id']);
        $term = $this->input->post('term' . $row['term']);
        $this->db->where('csa_grade_id', $row['csa_grade_id']);
        $this->db->update('cce_coscholatic_grades', array('csa_grade' => $obtained_marks, 'comment' => $comment));
    }
    /* echo $this->db->last_query();
      die(); */
    $this->session->set_flashdata('flash_message', get_phrase('marks_updated'));
    redirect($_SERVER['HTTP_REFERER']);
}

function cce_exam_connect($param1 = '', $param2 = '') {
    $page_data = $this->get_page_data_var();
    if ($param1 == 'connect') {
        $connect_exam[] = $this->input->post('selected_exam');
        $term[] = $this->input->post('cce_exam_term');
        $page_data['cce_exam_id'] = $connect_exam;
        $page_data['term'] = $term;
        //pre($page_data); //die();
        $save_data = array();
        if (count($connect_exam[0])) {
            foreach ($connect_exam[0] as $k => $row) {
                $save_data['cce_exam_id'] = $row;
                $save_data['cce_connect_status'] = 1;
                if (isset($term[0][$k]))
                    $save_data['term'] = $term[0][$k];
                //pre($save_data); //die();
                $this->Exam_model->cce_exam_connect($save_data);
            }
        }//die;
        $this->session->set_flashdata('flash_message', get_phrase('exam_connected'));
        redirect(base_url() . 'index.php?school_admin/exam_settings/', 'refresh');
    }

    if ($param1 == 'delete') {
        $this->Exam_model->delete_cce_connect_exam($param2);
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?school_admin/exam_settings/', 'refresh');
    }
}

function cce_report_card() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['classes'] = $this->Cce_model->get_cce_classes();
    $page_data['page_name'] = 'cce_report_card';
    $page_data['page_title'] = get_phrase('report_card');
    $this->load->view('backend/index', $page_data);
}

function cce_marksheet_selector() {
    $data['class_id'] = $this->input->post('class_id');
    $data['section_id'] = $this->input->post('section_id');
    $data['year'] = $this->input->post('year');
    $data['timestamp'] = strtotime($this->input->post('timestamp'));
    $data['student_id'] = $this->input->post('student_id');

    $query = $this->db->get_where('enroll', array(
        'class_id' => $data['class_id'],
        'student_id' => $data['student_id'],
        'year' => $data['year']
    ));

    redirect(base_url() . 'index.php?school_admin/cce_marksheet_view/' . $data['class_id'] . '/' . $data['student_id'], 'refresh');
}

function cce_marksheet_view($class_id = '', $student_id = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Subject_model');

    $page_data = $this->get_page_data_var();
    $class_name = $this->db->get_where('class', array('class_id' => $class_id))->row()->name;
    
    $subjects = $this->Subject_model->marks_get_subject($class_id);
    $subjAssessData = $this->Cce_model->get_cce_assessment();

    $all_marks = $this->Cce_model->get_cce_marks($student_id);
    /*pre($all_marks); die();*/
    
    $page_data['subjects'] = $subjects;
    $page_data['subjAssessData'] = $subjAssessData;

    foreach($subjects as $k => $sub){
        $sub_id = $sub['subject_id'];

        /*$page_data['subjects'][$k]['MarksData'] = array();*/
        foreach($all_marks as $k2=> $marks){

            if($marks['subject_id'] == $sub_id){
                $page_data['subjects'][$k]['term'] = $marks['term'];
                
                $page_data['subjects'][$k]['internal_subcat'][] = $marks['internal_subcat'];
                $page_data['subjects'][$k]['mark_obtained'][] = $marks['mark_obtained'];

            }
        }
    }

    /*foreach($subjects as $k => $sub){
        $sub_id = $sub['subject_id'];
        
        $page_data['subjects'][$k]['MarksData'] = array();
        foreach($all_marks as $k2=> $marks){
            if($marks['subject_id'] == $sub_id){
                $page_data['subjects'][$k]['MarksData'][] = $marks['mark_obtained'];
            }
        }

        $subjects[$k]['asses_name'] = array();

        foreach($subjAssessData as $AssData){
            if($AssData['subject_id'] == $sub_id){
                $page_data['subjects'][$k]['asses_name'][] = $AssData['assessment_name'];
            }    
        }
    }*/

    /* $page_data['subjects'] = $this->Subject_model->get_subject_array(array('class_id' => $class_id)); */

    /**/

    

    $page_data['marks'] = $all_marks;
    $page_data['class_id'] = $class_id;
    $page_data['page_name'] = 'cce_marksheet_view';
    $student_name = $this->db->get_where('student', array('student_id' => $student_id))->row()->name;
    $page_data['student_id'] = $student_id;
    $page_data['page_title'] = get_phrase('marksheet_of') . ' ' . $student_name . ' : ' . get_phrase('class') . ' ' . $class_name;
    $page_data['class_name'] = $class_name;
    $page_data['total_notif_num'] = $this->get_no_of_notication();

    /* Student Details */
    $page_data['student_info'] = $this->Student_model->get_student_details($student_id);
    if (!empty($page_data['student_info'])) {
        $class_id = $page_data['student_info']->class_id;
        $section_id = $page_data['student_info']->section_id;
    }
    $page_data['parents'] = $this->Parent_model->get_parents_array();
    $this->load->view('backend/index', $page_data);
}

function cce_manage_marks() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Exam_model');
    $page_data = $this->get_page_data_var();
    $page_data['exams'] = $this->Exam_model->cce_exam();
    $page_data['classes'] = $this->Cce_model->get_cce_classes();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_name'] = 'marks_manage';
    $page_data['page_title'] = get_phrase('manage_exam_marks');
    $this->load->view('backend/index', $page_data);
}

/* CCE Grading Method */

function get_page_data_var() {
    $this->load->model('Crud_model');
    $school_id = '';
    if (($this->session->userdata('school_id'))) {
        $school_id = $this->session->userdata('school_id');
    }
    $page_data = array();
    $page_data['system_name'] = $this->globalSettingsSystemName;
    $page_data['system_title'] = $this->globalSettingsSystemTitle;
    $page_data['text_align'] = $this->globalSettingsTextAlign;
    $page_data['skin_colour'] = $this->globalSettingsSkinColour;
    $page_data['active_sms_service'] = $this->globalSettingsActiveSmsService;
    $page_data['running_year'] = $this->globalSettingsRunningYear;
    $page_data['location'] = $this->globalSettingsLocation;
    $page_data['app_package_name'] = $this->globalSettingsAppPackageName;
    $page_data['system_email'] = $this->globalSettingsSystemEamil;
    $page_data['system_fcm_server_key'] = $this->globalSettingsSystemFCMServerrKey;
    $page_data['account_type'] = $this->session->userdata('login_type');
    $page_data['filename'] = $this->Crud_model->getSpecificRecord($this->session->userdata('table'), $this->session->userdata('admin_id'));
    $page_data['system_logo'] = $this->Setting_model->get_setting_record(array('type' => 'system_logo', 'school_id' => $school_id), 'description');
    $page_data['new_fi'] = $this->new_fi;
    return $page_data;
}

function view_marks_bulk_upload() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model("Exam_model");
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['exams'] = $this->Exam_model->get_all_exam($this->globalSettingsRunningYear);
    $page_data['page_name'] = 'view_marks_bulk_upload';
    $page_data['page_title'] = get_phrase('mark_bulk_upload');
    $this->load->view('backend/index', $page_data);
}

function login_history() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $this->load->model("Admin_model");
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_name'] = 'login_history';
    $page_data['page_title'] = get_phrase('login_history');
    $this->load->view('backend/index', $page_data);
}

function mark_bulk_upload() {
    if ($this->session->userdata('school_admin_login') != 1)
        die("4");
    $this->load->helper('general_used');
    @unlink('uploads/mark_import.xlsx');
    @unlink('uploads/mark_bulk_upload_error_details.log');
    if (array_key_exists('userfile', $_FILES)) {
        if ($_FILES['userfile']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/mark_import.xlsx');
        } else {
            die("2");
        }
    } else {
        die("1");
    }
    @ini_set('memory_limit', '-1');
    @set_time_limit(0);
    $someRowError = FALSE;
    $errorMsgArr = array();

    //$path = "uploads/Marks_Upload_Template_For_95_9.xlsx";
    $path = "uploads/mark_import.xlsx";
    $allWorksheetDataArr = read_mark_data_from_excel_file($path);
    list($firstKey) = array_keys($allWorksheetDataArr);
    $section_id_arr1 = explode('=>', $firstKey);
    $section_id1 = end($section_id_arr1);
    $log_file_name = "bulk_mark_upload_" . date('d_m_Y') . ".log";
    if ($section_id1 == "") {
        $someRowError = TRUE; //pre("at 12979");
        $errorMsgArr[] = "Worksheet default data has changed for 1st row or first column i.e class data.So unable to process the whole file.";
        generate_log(current($errorMsgArr), $log_file_name);
    } else {
        $this->load->model('Section_model');
        $class_data = $this->Section_model->get_class_name_by_section_id($section_id1);
        if (!empty($class_data)) {
            $exam_data_str = $allWorksheetDataArr[$firstKey][1]['A'];
            //pre($exam_data_str);die;
            if ($exam_data_str != "") {
                //empty excel
                $exam_data_str_arr = explode('=>', $exam_data_str);
                if (count($exam_data_str_arr) > 1) {
                    //pre($exam_data_str);die;
                    $exam_id = $exam_data_str_arr[1];
                    //pre($allWorksheetDataArr);die;
                    //die;
                    
                    //pre(current($allWorksheetDataArr));die;
                    //pre($subjectIdArr);die;
                    $bulkMarkDataArr = array();
                    foreach ($allWorksheetDataArr AS $sheetName => $sheetDetails) {
                        if ($sheetName == 'Worksheet' || $sheetName == 'Worksheet 1' || $sheetName == 'Worksheet 2') {
                            continue;
                        }
                        //pre($sheetName);
                        //pre($sheetDetails);
                        //echo $firstKey;die;
                        $allSubjectArr = $allWorksheetDataArr[$sheetName][1];
                        unset($allSubjectArr['A']);
                        $subjectIdArr = array();
                        $allSubjectStr = '';
                        //pre($allSubjectArr);
                        foreach ($allSubjectArr AS $SubjectNameIdStr) {
                            $subject_id_arr = explode('=>', $SubjectNameIdStr);
                            //pre($subject_id_arr);
                            //pre($subject_id_arr);die;
                            if (count($subject_id_arr) == 2) {
                                $subject_id = end($subject_id_arr);
                                if ($subject_id == "") {
                                    if ($allSubjectStr == "")
                                        $allSubjectStr = $subject_id_arr[0];
                                    else
                                        $allSubjectStr .= ',' . $subject_id_arr[0];
                                    $subjectIdArr[] = array('subject_id' => 'invalid_subject_id', 'subejct_name' => $SubjectNameIdStr);
                                }else {
                                    $this->load->model('Subject_model');
                                    //$subjectRs = $this->Subject_model->get_data_by_cols('');
                                    if ($allSubjectStr == "")
                                        $allSubjectStr = $subject_id_arr[0];
                                    else
                                        $allSubjectStr .= ',' . $subject_id_arr[0];
                                    $subjectIdArr[] = array('subject_id' => $subject_id_arr[1], 'subejct_name' => $subject_id_arr[0]);
                                }
                            }else {
                                continue;
                            }
                        }
                        //pre($allSubjectStr);pre($subjectIdArr);die;
                        //$bulkMarkDataArr=array();
                        $section_str = explode('=>', $sheetName);
                        //pre($sheetDetails);die;
                        if (count($section_str) > 1) {
                            $section_id = $section_str[1];
                            generate_log('$sheetDetails : '.json_encode($sheetDetails));
                            if (count($sheetDetails) > 2) {
                                unset($sheetDetails[1]);
                                //pre($sheetDetails);die;
                                /// maximum mark process here subject wise.
                                foreach ($sheetDetails AS $sheetDetailsIndex => $maxMarkRow) {
                                    $index = 0;
                                    $index1 = 0;
                                    //pre($subjectIdArr);
                                    $SkipColArr = array("A", "C", "E", "G", "I", "K", "M", "O", "Q", "S");
                                    $newSubjectIdArr = array();
                                    foreach ($maxMarkRow AS $maxKey => $maxVal) {
                                        //pre($maxKey);pre($maxVal);
                                        if (in_array($maxKey, $SkipColArr)) {
                                            continue;
                                        } else {
                                            $rawData = array();
                                            $rawData = $subjectIdArr[$index];
                                            $rawData['maximum_mark'] = $maxVal;
                                            $newSubjectIdArr[] = $rawData;
                                            $index++;
                                        }
                                        //next();
                                    }
                                    break;
                                }
                                //pre($subjectIdArr);
                                // pre($newSubjectIdArr);
                                $subjectIdArr = $newSubjectIdArr;
                                //pre($subjectIdArr);die;
                                unset($sheetDetails[2]);
                                //pre($sheetDetails);die;
                                //$bulkMarkDataArr=array();
                                foreach ($sheetDetails AS $sheetDetailsIndex => $studentMarkRow) {
                                    //pre($studentMarkRow['A']);die;
                                    $studentNameIdArr = explode('=>', $studentMarkRow['A']);
                                    if (count($studentNameIdArr) > 1) {
                                        $student_id = $studentNameIdArr[1];
                                        if ($student_id != "") {
                                            unset($studentMarkRow['A']);
                                            $tempStudentMarkArr = array();
                                            $tempStudentMarkArr = array_values($studentMarkRow);
                                            //pre($tempStudentMarkArr);die;
                                            $mark_and_comment_collcted = FALSE;
                                            $mark_index = 0;
                                            $subjectMark = "";
                                            foreach ($tempStudentMarkArr AS $subjectIndex => $mark) {
                                                //pre($subjectIndex);die;
                                                if ($subjectIndex % 2 == 0) {
                                                    /// section collect mark
                                                    //pre($subjectIdArr[$subjectIndex]);die;
                                                    if ($mark == "") {
                                                        /// error process for specific subject due to invalida data
                                                        $someRowError = true; //pre("at 13084");
                                                        $errorMsgArr[] = "Please provide the mark for worksheet(" . $sheetName . ") for subject(" . $subjectIdArr[$mark_index]['subejct_name'] . ") for (" . $studentNameIdArr[0] . ")";
                                                        generate_log(current($errorMsgArr), $log_file_name);
                                                    } else {
                                                        if ($subjectIdArr[$mark_index]['subject_id'] == 'invalid_subject_id') {
                                                            ///error process for invalid subject
                                                            $someRowError = true; //pre("at 13091");
                                                            $errorMsgArr[] = "Unable to update mark for worksheet(" . $sheetName . ") for student (" . $studentNameIdArr[0] . ") for subject(" . $subjectIdArr[$mark_index]['subejct_name'] . ")";
                                                            generate_log(current($errorMsgArr), $log_file_name);
                                                        } else {
                                                            $subjectMark = $mark;
                                                            //$dataArr=array('exam_id'=>$exam_id,'class_id'=>$class_data[0]['class_id'],'section_id'=>$section_id,'subject_id'=>$subjectIdArr[$subjectIndex]['subject_id'],'student_id'=>$student_id,'mark_obtained'=>$mark,'mark_total'=>100,'year'=> $this->globalSettingsRunningYear);
                                                            //generate_log(json_encode($dataArr), $log_file_name);
                                                            generate_log('$subjectMark : ' . $subjectMark, $log_file_name);
                                                            //$bulkMarkDataArr[]=$dataArr;
                                                        }
                                                    }
                                                } else {
                                                    if ($subjectIdArr[$mark_index]['subject_id'] == 'invalid_subject_id') {
                                                        ///error process for invalid subject
                                                        $someRowError = true; //pre("at 13105");
                                                        $errorMsgArr[] = "Unable to update mark for worksheet(" . $sheetName . ") for student (" . $studentNameIdArr[0] . ") for subject(" . $subjectIdArr[$mark_index]['subejct_name'] . ")";
                                                        generate_log(current($errorMsgArr), $log_file_name);
                                                    } else {
                                                        if ($subjectMark != "") {
                                                            if ($subjectMark > $subjectIdArr[$mark_index]['maximum_mark']) {
                                                                /// error process
                                                                $someRowError = true; //pre("at 13105");
                                                                $errorMsgArr[] = "Worksheet(" . $sheetName . ") for student (" . $studentNameIdArr[0] . ") for subject(" . $subjectIdArr[$mark_index]['subejct_name'] . " Mark) greater than the maximum mark";
                                                                generate_log(current($errorMsgArr), $log_file_name);
                                                            } else {
                                                                $dataArr = array('exam_id' => $exam_id, 'class_id' => $class_data[0]['class_id'], 'section_id' => $section_id, 'subject_id' => $subjectIdArr[$mark_index]['subject_id'], 'student_id' => $student_id, 'mark_obtained' => $subjectMark, 'mark_total' => $subjectIdArr[$mark_index]['maximum_mark'], 'year' => $this->globalSettingsRunningYear, 'comment' => $mark);
                                                                generate_log(json_encode($dataArr), $log_file_name);
                                                                generate_log('$subjectMark : ' . $subjectMark, $log_file_name);
                                                                $bulkMarkDataArr[] = $dataArr;
                                                            }
                                                        }else{
                                                            $someRowError = true; //pre("at 13105");
                                                            $errorMsgArr[] = "Please provide the mark for worksheet(" . $sheetName . ") for student (" . $studentNameIdArr[0] . ") for subject(" . $subjectIdArr[$mark_index]['subejct_name'] . ").";
                                                            generate_log(current($errorMsgArr), $log_file_name);
                                                        }
                                                    }
                                                    $mark_index++;
                                                    $subjectMark = '';
                                                }
                                            }
                                        } else {
                                            $someRowError = TRUE; //pre("at 13122");
                                            $errorMsgArr[] = "Unabel to process mark for the subject(" . $allSubjectStr . ") for " . $studentNameIdArr[0] . " in worksheet(" . $sheetName . ") as defult structure has changed.";
                                            generate_log(current($errorMsgArr), $log_file_name);
                                        }
                                        //pre($student_id);die;
                                    } else {
                                        /// error student data
                                        $someRowError = TRUE; //pre("at 13129");
                                        $errorMsgArr[] = "Unabel to process mark for student(" . $studentMarkRow['A'] . ") for all subject(" . $allSubjectStr . ") in worksheet(" . $sheetName . ") as defult structure has changed.";
                                        generate_log(current($errorMsgArr), $log_file_name);
                                    }
                                }
                                ////save data
                                //pre($errorMsgArr);
                                //pre($bulkMarkDataArr); //die;
                            } else {
                                //worksheet has no data or defult structure has changed.
                                $someRowError = TRUE; //pre("at 13142");
                                $errorMsgArr[] = "Unable to process the data as defult structure has changed.";
                                generate_log(current($errorMsgArr), $log_file_name);
                            }
                        } else {
                            $someRowError = TRUE; //pre("at 13149");
                            $errorMsgArr[] = "Worksheet Name has changed to $sheetName show unable to update data for theh worksheet.";
                            generate_log(current($errorMsgArr), $log_file_name);
                            continue;
                        }
                    }
                    if ($someRowError == FALSE) {
                        generate_log('$someRowError is FALSE : going to add data to db', $log_file_name);
                        $this->load->model('Mark_model');
                        if (!empty($bulkMarkDataArr)) {
                            $this->Mark_model->add_mark_by_bulk_upload($bulkMarkDataArr);
                            generate_log('Data added to db success fully and going for sheet', $log_file_name);
                        } else {
                            generate_log('DB string error are  ' . $this->db->last_query(), $log_file_name);
                            generate_log('Error unable to added data to db : going for next sheet', $log_file_name);
                        }
                    }
                } else {
                    /// no exam id soo error
                    $someRowError = TRUE; //pre("at 13156");
                    $errorMsgArr[] = "Worksheet default data has changed for 1st row or first column i.e exam data.So unable to process the whole file.";
                    generate_log(current($errorMsgArr), $log_file_name);
                }
            } else {
                /// not empty excel
            }
        } else {
            //invalid class data 
            $someRowError = TRUE; //pre("at 13165");
            $errorMsgArr[] = "Worksheet default data has changed for 1st row or first column i.e class data.So unable to process the whole file.";
            generate_log(current($errorMsgArr), $log_file_name);
        }
    }

    //pre($errorMsgArr);
    //die("end");
    //pre($allWorksheetDataArr);die;
    if ($someRowError == FALSE) {
        //$this->generate_cv($error_msg);
        generate_log("No error for this upload at - " . time(), $log_file_name);
        die("0");
        //$this->session->set_flashdata('flash_message', get_phrase('mark_details_added'));
        //redirect(base_url() . 'index.php?school_admin/view_marks_bulk_upload/', 'refresh');
    } else {
        //pre($errorMsgArr);die;
        generate_log(json_encode($errorMsgArr), 'mark_bulk_upload_error_details.log', TRUE);
        /* $file_name_with_path = 'uploads/mark_bulk_upload_error_details_for_excel_file.xlsx';
          @unlink($file_name_with_path);
          create_excel_file($file_name_with_path, $errorExcelArr); */
        die("3");
        //$this->session->set_flashdata('flash_message_error', "Some rows are not uploaded,due to invalid data.");
        //redirect(base_url() . 'index.php?school_admin/mark_bulk_upload_error' . $this->input->post('class_id'), 'refresh');
    }
}

public function online_polls($action = '', $poll_id = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $this->load->model("Onlinepoll_model");
    $this->load->model("Class_model");
    if ($action == 'delete') {
        $delete_result = $this->Onlinepoll_model->updatePoll(array('poll_id' => $poll_id), array('status' => 3));
        if ($delete_result) {
            $this->session->set_flashdata('flash_message', get_phrase('poll_details_deleted_successfully'));
            redirect(base_url() . 'index.php?school_admin/online_polls/', 'refresh');
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('deletion_failed_try_again!!'));
        }
    } else if ($action == 'inactive') {
        
    } else if ($action == 'close') {
        $close_result = $this->Onlinepoll_model->updatePoll(array('poll_id' => $poll_id), array('status' => 2));
        if ($close_result) {
            $this->session->set_flashdata('flash_message', get_phrase('poll_closed_successfully'));
            redirect(base_url() . 'index.php?school_admin/online_polls/', 'refresh');
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('close_failed_try_again!!'));
        }
    }

    $page_data['page_name'] = 'online_polls';
    $page_data['page_title'] = get_phrase('online_polls');
    $online_polls = $this->Onlinepoll_model->getOninePolls();
    $online_poll_list = $online_polls;
    foreach ($online_polls as $key => $poll) {
        if ($poll['classes'] != 0) {
            $class_ids = explode(',', $poll['classes']);
            $class_name = '';
            foreach ($class_ids as $class_id) {
                $class = $this->Class_model->get_name_by_id((int) $class_id);
                $class_name = $class[0]->name . "," . $class_name;
            }
            $class_name = rtrim($class_name, ',');
            $online_polls[$key]['class_name'] = $class_name;
        } else {
            $online_polls[$key]['class_name'] = '';
        }
        $total_poll = $this->Onlinepoll_model->getPollCount($poll['poll_id']);
        $online_polls[$key]['total_poll'] = $total_poll[0]->total_poll;
    }
    $page_data['online_polls'] = $online_polls;
    $this->load->view('backend/index', $page_data);
}

public function generate_online_poll() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $this->load->model("Onlinepoll_model");
    if ($this->input->post('submit_poll')) {
        $poll_title = $this->input->post('poll_title');
        $poll_descreption = $this->input->post('poll_discription');
        $classes = $this->input->post('classes');

        $subject = $this->input->post('subjects');
        $post_date = $this->input->post('poll_date');
        $poll_answer = $this->input->post('poll_answer');
        $created_by = $this->session->userdata('admin_id');
        $poll_data = array(
            'poll_title' => $poll_title,
            'poll_descreption' => $poll_descreption,
            'classes' => implode(',', $classes),
            'subjects' => $subject,
            'post_date' => date('Y-m-d'),
            'created_by' => $created_by,
            'status' => 1
        );

        $poll_id = $this->Onlinepoll_model->addPoll($poll_data);
        if ($poll_id) {
            foreach ($poll_answer as $answer) {
                $answer_data = array(
                    'answer' => $answer,
                    'poll_id' => $poll_id
                );
                $this->Onlinepoll_model->addAnswer($answer_data);
            }
            $this->session->set_flashdata('flash_message', get_phrase('online_poll_posted_successfully'));
            redirect(base_url() . 'index.php?school_admin/online_polls/', 'refresh');
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('updation_failed_try_again!!'));
            $page_data['online_polls'] = $poll_data;
            $page_data['answers'] = $poll_answer;
        }
    }

    $this->load->model("Class_model");
    $page_data['classes'] = $this->Class_model->get_class_array();
    $page_data['account_type'] = $this->session->userdata('login_type');
    $page_data['page_name'] = 'generate_online_poll';
    $page_data['page_title'] = get_phrase('online_polls');
    $page_data['online_polls'] = $this->Onlinepoll_model->getOninePolls();
    $this->load->view('backend/index', $page_data);
}

public function add_student_fee_config($student_id, $fee_data) {
    
}

function cwa_manage_marks() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Exam_model');
    $page_data = $this->get_page_data_var();
    $page_data['exams'] = $this->Exam_model->cwa_exam();
    $page_data['classes'] = $this->Class_model->get_cwa_classes();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_name'] = 'cwa_manage_marks';
    $page_data['page_title'] = get_phrase('manage_cwa_exam_marks');
    $this->load->view('backend/index', $page_data);
}

function database_data_backup_list() {
    $fileInfoArr = array();
    $i = 0;
    foreach (new DirectoryIterator('database_data_backups/') as $fileInfo) {
        //pre($fileInfo);
        $fileData = array();
        if ($fileInfo->isDot()) {
            continue;
        } else {
            $i++;
        }
        //echo $fileInfo->getFilename() . "<br>\n";
        $fileData['SlNo'] = $i;
        $fileData['name'] = $fileInfo->getFilename();
        $fileData['size'] = round($fileInfo->getSize() / pow(1024, 2), 2);
        $fileData['create_time'] = $fileInfo->getCTime();
        $fileData['modified_time'] = $fileInfo->getMTime();
        $fileInfoArr[] = $fileData;
    }
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['data'] = $fileInfoArr;
    $page_data['page_name'] = 'database_backup';
    $page_data['page_title'] = get_phrase('manage_|_backup');
    $page_data['page_subtitle'] = get_phrase('database_backup');
    $this->load->view('backend/index', $page_data);
}

function create_database_data_backup() {
    $this->load->helper('general_used');
    $backupFilename = 'backup_' . date('d_m_Y') . '_' . time() . '.sql'; //die($backupFilename);
    create_school_data_backup($backupFilename, MY_SQLI_DB_MANUAL_BACKUP_FOLDER);
    $this->session->set_flashdata('flash_message', get_phrase('backup_created_successfully'));
    redirect(base_url() . 'index.php?school_admin/database_data_backup_list/', 'refresh');
}

function download_database_manual_backups($fileName) {
    $this->load->helper('download');
    //echo MY_SQLI_DB_MANUAL_BACKUP_FOLDER.$fileName;die;
    $data = file_get_contents(MY_SQLI_DB_MANUAL_BACKUP_FOLDER . $fileName);
    //$name = 'bus_driver_bulk_upload_error_details_for_excel_file.xlsx';
    $name = CURRENT_INSTANCE . '_database_backup_' . date('d_m_Y_H_i_s') . '.sql';
    force_download($name, $data);
}

function deleted_database_manual_backups($fileName) {
    //echo MY_SQLI_DB_MANUAL_BACKUP_FOLDER . $fileName;die;
    @unlink(MY_SQLI_DB_MANUAL_BACKUP_FOLDER . $fileName);
    $this->session->set_flashdata('flash_message', get_phrase('backup_deleted_successfully'));
    redirect(base_url() . 'index.php?school_admin/database_data_backup_list/', 'refresh');
}

/*
 * Student home works
 */

public function home_works($action = '', $home_work_id = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $this->load->model("Homeworks_model");
    $this->load->model("Class_model");
    //pre($this->session->userdata());
    if ($action == 'create') {
        $type_name = $this->input->post('name');
        $description = $this->input->post('description');
        $data = array(
            'type_name' => $type_name,
            'discriptions' => $description,
            'type' => 2,
            'created_by' => $this->session->userdata('school_admin_id')
        );
        $create = $this->Homeworks_model->add_data($data, 'home_work_types');
        if (isset($create)) {
            $this->session->set_flashdata('flash_message', get_phrase('home_work_type_added_successfully'));
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('deletion_failed_try_again!!'));
        }
        redirect(base_url() . 'index.php?school_admin/home_works/', 'refresh');
    } else if ($action == 'delete') {
        if ($home_work_id)
            $delete = $this->Homeworks_model->homework_delete((int) $home_work_id);
        if (isset($delete)) {
            $this->session->set_flashdata('flash_message', get_phrase('home_work_type_deleted_successfully'));
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('deletion_failed_try_again!!'));
        }
        redirect(base_url() . 'index.php?school_admin/home_works', 'refresh');
    }

    $page_data['page_name'] = 'home_work';
    $page_data['page_title'] = get_phrase('home_works');

    $home_work_types = $this->Homeworks_model->get_all_data('home_work_types', array());
    $page_data['homework_types'] = $home_work_types;

    $this->load->view('backend/index', $page_data);
}

function gpa_manage_marks() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Exam_model');
    $page_data = $this->get_page_data_var();
    $page_data['exams'] = $this->Exam_model->gpa_exam();
    $page_data['classes'] = $this->Class_model->get_gpa_classes();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_name'] = 'gpa_manage_marks';
    $page_data['page_title'] = get_phrase('manage_gpa_exam_marks');
    $this->load->view('backend/index', $page_data);
}

/* Holiday Settings */

function holiday_settings($param1 = '') {
    $page_data = $this->get_page_data_var();
    $location = $this->globalSettingsLocation;
    $this->load->model("Holiday_model");
    if (strtolower($location) == "india") {
        $page_data['location'] = "indian";
    }

    $page_data['holidays'] = $this->Holiday_model->get_holiday_list();
    $page_data['page_name'] = 'holiday_settings';
    $page_data['page_title'] = get_phrase('holiday_settings');
    $this->load->view('backend/index', $page_data);
    /* redirect($_SERVER['HTTP_REFERER']); */
}

function save_holiday_list($country = '') {
    $page_data = $this->get_page_data_var();
    $data['title'] = $this->input->post("title");
    $data['date_start'] = date('Y-m-d', strtotime($this->input->post("date")));
    if ($this->input->post("number_of_days")) {
        $data['number_of_days'] = $this->input->post("number_of_days");
    } else {
        $data['number_of_days'] = "1";
    }
    $data['is_active'] = "1";
    $data['running_year'] = $this->globalSettingsRunningYear;
    $data['country'] = $country;
    $this->load->model("Holiday_model");
    $this->Holiday_model->save_holiday_list($data);
    $page_data['holidays'] = $this->Holiday_model->get_holiday_list();
    $page_data['page_name'] = 'holiday_settings';
    $page_data['page_title'] = get_phrase('holiday_settings');
    /* $this->load->view('backend/index', $page_data); */
    redirect($_SERVER['HTTP_REFERER']);
}

function deactivate_holiday($param1 = "") {
    $page_data = $this->get_page_data_var();
    $id = $param1; //$this->input->post("id");
    $idArr = explode('_', $id);
    $id1 = $idArr[1];
    $this->load->model("Holiday_model");
    $this->Holiday_model->deactivate_holiday($id1);
    $page_data['holidays'] = $this->Holiday_model->get_holiday_list();
    $page_data['page_name'] = 'holiday_settings';
    $page_data['page_title'] = get_phrase('holiday_settings');
    $this->load->view('backend/index', $page_data);
}

function activate_holiday($param1 = "") {
    $page_data = $this->get_page_data_var();
    $id = $param1; //$this->input->post("id"); 
    $idArr = explode('_', $id);
    $id1 = $idArr[1];
    //die;
    $this->load->model("Holiday_model");
    $this->Holiday_model->activate_holiday($id1);
    $page_data['holidays'] = $this->Holiday_model->get_holiday_list();
    $page_data['page_name'] = 'holiday_settings';
    $page_data['page_title'] = get_phrase('holiday_settings');
    $this->load->view('backend/index', $page_data);
}

function delete_holiday($param1 = "") {
    $page_data = $this->get_page_data_var();
    $id = $param1;
    $this->load->model("Holiday_model");
    $delete = $this->Holiday_model->delete_holiday($id);
    if ($delete) {
        $this->session->set_flashdata('flash_message', get_phrase('holiday_deleted_successfully'));
        redirect($_SERVER['HTTP_REFERER']);
    } else {
        $this->session->set_flashdata('flash_message_error', get_phrase('deletion_failed_try_again!!'));
    }
    redirect($_SERVER['HTTP_REFERER']);
}

function edit_holiday($id) {
    $page_data = $this->get_page_data_var();
    $data['title'] = $this->input->post("title");
    $data['date_start'] = date('Y-m-d', strtotime($this->input->post("date_start")));
    if ($this->input->post("number_of_days")) {
        $data['number_of_days'] = $this->input->post("number_of_days");
    } else {
        $data['number_of_days'] = "1";
    }
    $data['is_active'] = "1";
    $data['running_year'] = $this->globalSettingsRunningYear;
    $country = '';
    $data['country'] = $country;
    $this->load->model("Holiday_model");
    $update = $this->Holiday_model->update_holiday($data, $id);
    $page_data['holidays'] = $this->Holiday_model->get_holiday_list();
    $page_data['page_name'] = 'holiday_settings';
    $page_data['page_title'] = get_phrase('holiday_settings');
    if ($update) {
        $this->session->set_flashdata('flash_message', get_phrase('holiday_update_successfully'));
        redirect($_SERVER['HTTP_REFERER']);
    } else {
        $this->session->set_flashdata('flash_message_error', get_phrase('updation_failed_try_again!!'));
    }
    redirect($_SERVER['HTTP_REFERER']);
}

/* Holiday Settings */

function dynamic_report_name($param1 = "", $param2 = "") {
    $page_data = $this->get_page_data_var();
    $this->load->model("Dynamic_report_model");
    if ($param1 == 'create') {
        $data['report_caption'] = $this->input->post("name");
        $data['report_table'] = $this->input->post("report_table");
        $this->Dynamic_report_model->add($data);
        $this->session->set_flashdata("flash_message", get_phrase("data_added_successfully"));
        redirect(base_url() . 'index.php?school_admin/dynamic_report_name', 'refresh');
    }
    if ($param1 == 'update') {
        $data['report_caption'] = $this->input->post('report_name');
        $data['report_table'] = $this->input->post('report_table');
        if ($param2 != '') {
            $this->Dynamic_report_model->update_report_name($data, array("id" => $param2));
            $this->session->set_flashdata("flash_message", get_phrase("data_updated"));
            redirect(base_url() . 'index.php?school_admin/dynamic_report_name', 'refresh');
        }
    }
    if ($param1 == 'delete') {
        $this->Dynamic_report_model->delete_report_name($param2);
        $this->session->set_flashdata("flash_message", get_phrase("data_deleted"));
        redirect(base_url() . 'index.php?school_admin/dynamic_report_name', 'refresh');
    }
    $page_data['dynamic_report_name'] = $this->Dynamic_report_model->get_group_array();
    $page_data['page_name'] = 'dynamic_name';
    $page_data['page_title'] = get_phrase('dynamic_name');
    $this->load->view('backend/index', $page_data);
}

function dynamic_report($param1 = "", $param2 = "") {
    $page_data = $this->get_page_data_var();
    $table = " student ";
    $this->load->model("Dynamic_report_model");
    $dynamic_report_list = $this->Dynamic_report_model->get_report();
    $data = array();
    $arrCheck = array();
    $arrCaption = array();
    $arrCondition = array();
    $arrFieldValue = array();
    $arrType = array();
    $report_id = '';

    if ($param1 == 'create') {

        $report_name = $this->input->post('report_name');
        $report_id = $this->input->post('report_id');
        $arrCheck = $this->input->post('check');
        $arrCaption = $this->input->post('caption');
        $arrCondition = $this->input->post('condtion');
        $arrFieldValue = $this->input->post('field_value');
        $arrType = $this->input->post('type');

        $this->load->model("Dynamic_report_model");

        $arrField = $this->input->post('field');
        $arrCaption = $this->input->post('caption');
        $arrCondition = $this->input->post('condition');
        $arrFieldValue = $this->input->post('field_value');
        $arrAll = $this->Dynamic_report_model->getJoinField($arrField);

        $arrJoinTable = $arrAll['arrJoinTable'];
        $arrJoinField = $arrAll['arrJoinField'];
        $arrJoinType = $arrAll['arrJoinType'];

        $captionString = "";
        $queryString = "Select ";
        $condtionString = " where 1 = 1";
        $joinString = "";

        $arrJoinTable = array_unique($arrJoinTable);
        foreach ($arrField as $key => $value) {
            $queryString .= "$key,";
            if (in_array($key, array_keys($arrCaption))) {
                $captionString .= "$arrCaption[$key] ,";
            }
            if (in_array($key, array_keys($arrCondition))) {

                if (!empty($arrCondition[$key]) && !empty($arrFieldValue[$key]))
                    $condtionString .= " and $key  = '" . $arrFieldValue[$key] . "'";
            }
            if (in_array($key, array_keys($arrJoinTable))) {
                if (!empty($arrJoinType[$key])) {
                    $joinString .= $arrJoinType[$key] . " JOIN ";
                    $joinString .= " $arrJoinTable[$key] ON ";
                    $joinString .= " $arrJoinField[$key] ";
                }
            }
        }
        $captionString = rtrim($captionString, ',');
        $queryString = rtrim($queryString, ',');
        $queryString .= " from $table ";
        $queryString .= $joinString;
        $queryString .= $condtionString;

        $arrSave = array();
        $arrSave['caption'] = $captionString;
        $arrSave['query'] = $queryString;
        $arrSave['name'] = $report_name;

        $arrLink = array();
        $insertReportId = $this->Dynamic_report_model->saveReport($arrSave);
        $name = "save_report";
        $link = $this->Dynamic_report_model->getReportLink($name);
        $arrSaveReport = array();
        $report_parent_id = '';
        $report_image = '';
        $report_user_type = '';
        $report_name = "test";
        if (count($link)) {

            foreach ($link as $row) {
                $report_parent_id = $row['id'];
                $report_user_type = $row['user_type'];
                $report_image = $row['image'];
                $report_link = $row['link'];
            }
            $arrLink['name'] = $report_name;
            $arrLink['parent_id'] = $report_parent_id;
            $arrLink['image'] = $report_image;
            $arrLink['user_type'] = $report_user_type;
            $arrLink['link'] = $report_link . "/" . $insertReportId;
            $arrLink['orders'] = 1;
            $this->Dynamic_report_model->dynamicLinkSave($arrLink);
        }
    }
    $page_data['dynamic_report_list'] = $dynamic_report_list;
    $page_data['page_name'] = 'dynamic_report';
    $page_data['page_title'] = get_phrase('dynamic_report');
    $this->load->view('backend/index', $page_data);
}

function automatic_timetable_teacher_priority($teacherId = "") {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');

    $page_data = $this->get_page_data_var();

    $this->load->model("Teacher_model");
    $page_data['teacher_array'] = $this->Teacher_model->get_data_by_cols("teacher_id, name, middle_name, last_name", array('teacher_status' => '1', 'isActive' => '1'), 'result', array('name' => 'asc'));
    $teacher_priority_list = $this->Teacher_model->show_teacher_priority($this->globalSettingsRunningYear, $teacherId);
    $teacher_missing_class_priority_list = $this->Teacher_model->show_missing_class_in_priority($this->globalSettingsRunningYear, $teacherId);
    $page_data['running_year'] = $this->globalSettingsRunningYear;
    $page_data['teacher_priority_list'] = $teacher_priority_list;
    $page_data['teacher_missing_class_priority_list'] = $teacher_missing_class_priority_list;
    $page_data['page_name'] = 'automatic_timetable_teacher_priority';
    $page_data['page_title'] = get_phrase('teacher_priority_setting');
    $option_str = "<option value=''>" . get_phrase('select') . "</option>";
    $page_data['class_option'] = $option_str;
    if ($teacherId != "") {
        $this->load->model("Subject_model");
        $teacherArr = $this->Subject_model->get_all_subjects_by_teacher($teacherId);
        foreach ($teacherArr AS $k) {
            //$subjectData = $this->Subject_model->get_data_by_cols('*', array('class_id' => $k['class_id'], 'teacher_id' => $teacherId), 'result_array');
//                $sectionData = $this->Section_model->get_section_by_class_teacher($k['class_id'],$teacherId); 
            $option_str .= '<option value="' . $k['class_id'] . '">' . $k['class_name'] . '</option>';
            /*if (count($subjectData) > 0) {
                $option_str .= '<option value="' . $k['class_id'] . '">' . $k['class_name'] . '</option>';
            }*/
        }
        //pre($option_str);
        $page_data['class_option'] = $option_str;
    }
    //die($teacherId);
    $page_data['teacherId'] = $teacherId;
    $this->load->view('backend/index', $page_data);
}

function automatic_timetable_create_week_structure() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');

    $page_data = $this->get_page_data_var();
    $page_data['running_year'] = $this->globalSettingsRunningYear;
    $schedules_year_data_arr = $this->automatic_timetable_get_schedules_year();
    //pre($schedules_year_data_arr);die;
    $page_data['schedules_year_data_arr'] = $schedules_year_data_arr;
    $page_data['page_name'] = 'automatic_timetable_create_week_structure';
    $page_data['page_title'] = get_phrase('timetable_week_structure');
    $this->load->view('backend/index', $page_data);
}

function automatic_timetable_get_schedules_year() {
    $year = $this->globalSettingsRunningYear;
    $sql = "SELECT subject_id FROM subject WHERE year = '$year'";
    $keys = $this->db->query($sql)->result_array();
    $result = array();
    foreach ($keys as $key) {
        $result[$key['subject_id']] = array();
    }

    $sql = "SELECT su.subject_id subject_id, c.name class_name, sec.name section_name, su.name subject_name, su.class_id class_id, su.section_id section_id FROM class c, section sec, subject su WHERE c.class_id = su.class_id AND sec.section_id = su.section_id AND year = '$year' AND c.school_id='".$this->session->userdata('school_id')."'";
    $data = $this->db->query($sql)->result_array();

    foreach ($data as $row) {
        $subject_id = $row['subject_id'];
        //$section_name = $row['section_name'];
        //$subject_name = $row['subject_name'];

        $result[$subject_id]['class_name'] = $row['class_name'];
        $result[$subject_id]['section_name'] = $row['section_name'];
        $result[$subject_id]['subject_name'] = $row['subject_name'];
        $result[$subject_id]['restriction_info_id'] = -1;
        $result[$subject_id]['section_id'] = $row['section_id'];
        $result[$subject_id]['class_id'] = $row['class_id'];
    }

    foreach ($result as $key => $row) {
        if (count($row) == 0)
            unset($result[$key]);
    }

    $sql = "SELECT schedule_id,subject_id FROM schedule_restriction_info WHERE year = '$year' AND school_id='".$this->session->userdata('school_id')."'";
    $data = $this->db->query($sql)->result_array();
    foreach ($data as $row) {
        $subject_id = $row['subject_id'];
        $result[$subject_id]['restriction_info_id'] = $row['schedule_id'];
    }

    $finalResult = array();
    foreach ($result as $key => $value) {
        $value['subject_id'] = $key;
        array_push($finalResult, $value);
    }

    //echo json_encode($finalResult);
    return $finalResult;
}

function automatic_timetable_add_class($subject_id = "", $section_id = "", $class_id = "", $action_type = "add") {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');

    if ($subject_id == "")
        $subject_id = -1;

    $page_data = $this->get_page_data_var();
    $page_data['action_type'] = $action_type;
    $page_data['running_year'] = $this->globalSettingsRunningYear;
    $page_data['class_data_arr'] = $this->Class_model->get_data_by_cols('class_id,name');
    $page_data['class_id'] = $class_id;
    $page_data['section_data_arr'] = $this->Section_model->get_data_by_cols('section_id,name');
    $page_data['section_id'] = $section_id;
    $page_data['subject_data_arr'] = $this->Subject_model->get_data_by_cols('subject_id,name');
    $page_data['subject_id'] = $subject_id;
    $this->load->model("Setting_model");
    $starttoData = $this->Setting_model->get_setting_record(array('type' => 'startto'));
    
    $endfromData = $this->Setting_model->get_setting_record(array('type' => 'endfrom'));

    if ($starttoData->description == "") {
        $this->session->set_flashdata('flash_message_error', get_phrase('school_started_time_to_not_defined_in_general_settings'));
        redirect(base_url() . 'index.php?school_admin/automatic_timetable_create_week_structure');
    } else {
        /*$starttoDataArr= explode(':', $starttoData->description);
        if($starttoDataArr[1]!='00'){
            $starttoData=$starttoDataArr[0]+1;
        }else{
            $starttoData=$starttoDataArr[0];
        }
        $page_data['starttoData'] = $starttoData;*/
        $page_data['starttoData'] = $starttoData->description;
    }

    if ($endfromData->description == "") {
        $this->session->set_flashdata('flash_message_error', get_phrase('school_end_time_from_not_defined_in_general_settings'));
        redirect(base_url() . 'index.php?school_admin/automatic_timetable_create_week_structure');
    } else {
        /*$endfromDataArr= explode(':', $endfromData->description);
        if($endfromDataArr[1]!='00'){
            $endfromData=$endfromDataArr[0]+1;
        }else{
            $endfromData=$endfromDataArr[0];
        }*/
        $page_data['starttoData'] = $starttoData;
        //$page_data['endfromData'] = $endfromData;
        $page_data['endfromData'] = $endfromData->description;
    }
    //pre($page_data);die;
    $page_data['page_name'] = 'automatic_timetable_add_class';
    $page_data['page_title'] = get_phrase('automatic_timetable_add_class');
    $this->load->view('backend/index', $page_data);
}

function automatic_timetable_add_teacher_priority() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $teacherId = $this->input->post('teacher_id', TRUE);
    $year = $this->globalSettingsRunningYear;
    $class_id = $this->input->post('class_id', TRUE);
    $section_id = $this->input->post('section_id', TRUE);
    $subject_id = $this->input->post('subject_id', TRUE);
    $priority = $this->input->post('subject_priority', TRUE);
    //pre($this->input->post());die;
    $sql = "SELECT COUNT(1) c FROM teacher_preference WHERE teacher_id=$teacherId AND class_id=$class_id and subject_id=$subject_id AND year='$year' AND section_id='$section_id' AND school_id='".$this->session->userdata('school_id')."'";
    //echo $sql;
    $query = $this->db->query($sql);

    $exists = $query->result_array()[0]['c'];
    //pre($exists);die;
    if ($exists == '0') { // it doesn't exist
        $sql = "INSERT INTO teacher_preference(teacher_id, class_id, subject_id, priority, year,section_id,school_id) VALUES ($teacherId, $class_id, $subject_id, $priority, '$year','$section_id','".$this->session->userdata('school_id')."')";
        $this->db->query($sql);
        //	echo "I";
    } else {
        	//echo $sql;
        $sql = "UPDATE teacher_preference SET priority = $priority WHERE teacher_id=$teacherId AND class_id=$class_id AND section_id=$section_id AND subject_id=$subject_id AND year='$year' AND school_id='".$this->session->userdata('school_id')."'";
        $this->db->query($sql);
        //	echo "U";
    }
    //$teacherId
    $this->session->set_flashdata('flash_message', get_phrase('teacher_priority_added_successfully'));
    redirect(base_url() . 'index.php?school_admin/automatic_timetable_teacher_priority/' . $teacherId, 'refresh');
}

function delete_automatic_timetable_add_teacher_priority($teacher_preference_id) {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Teacher_model');
    $teacher_preference_details = $this->Teacher_model->get_teacher_preference_details($teacher_preference_id);
    $this->Teacher_model->delete_class_in_priority($teacher_preference_id);
    $this->session->set_flashdata('flash_message', get_phrase('teacher_priority_deleted_successfully'));
    redirect(base_url() . 'index.php?school_admin/automatic_timetable_teacher_priority/' . $teacher_preference_details[0]['teacher_id'], 'refresh');
}

//student certificate

function student_certificates($param1 = '', $param2 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');

    $this->load->model("Student_certificate_model");
    $this->load->model("Student_model");
    if ($param1 == 'create') {
        $data['certificate_title'] = $this->input->post('ceritificate_title');
        $data['sub_title'] = $this->input->post('sub_title');
        $data['main_cantent'] = $this->input->post('main_cantent');
        $data['student_id'] = $this->input->post('student_id');
        $data['template_type'] = $this->input->post('template_type');
        $data['date'] = date('Y-m-d H:i:s');
//    pre($data); die;
        $this->Student_certificate_model->add($data);
        $this->session->set_flashdata('flash_message', get_phrase('certificate_create_successfully'));
        redirect(base_url() . 'index.php?school_admin/student_certificates/', 'refresh');
    }
    if ($param1 == 'download') {
        $student_id = $this->input->post('student_id');
        $template_type = $this->input->post('template_type');
        if ($template_type == '1') {
            $method = "template1/download/$student_id";
        } elseif ($template_type == '2') {
            $method = "template2/download/$student_id";
        } elseif ($template_type == '3') {
            $method = "template3/download/$student_id";
        } else {
            $method = "template4/download/$student_id";
        }
        redirect(base_url() . 'index.php?school_admin/' . $method, 'refresh');
    }
    $page_data = $this->get_page_data_var();
    $page_data['page_title'] = get_phrase('student_certificate');
    $page_data['page_name'] = 'student_certificate';
    $this->load->view('backend/index', $page_data);
}

function template1($param1='',$param2='',$param3=''){
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['certificate_design'] = "";
    if($param1=='download'){
    $this->load->model('Student_certificate_model');
    $page_data['certificate_detail'] = $this->Student_certificate_model->get_certificate_record($param2,$param3,'1');

//    pre($page_data['certificate_detail']); die;
    } else {
        $page_data['certificate_design'] = "true";
    }
    $page_data['page_title'] = get_phrase('template1');
    $page_data['page_name'] = 'certificate_template1';
    $this->load->view('backend/index', $page_data);
}

function template2($param1='',$param2='',$param3=''){
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['certificate_design'] = "";
    if($param1=='download'){
       $this->load->model('Student_certificate_model');
    $page_data['certificate_detail'] = $this->Student_certificate_model->get_certificate_record($param2,$param3,'2');
//    pre($page_data['certificate_detail']); die;
    } else {
        $page_data['certificate_design'] = "true";
    }
    $page_data['page_title'] = get_phrase('template2');
    $page_data['page_name'] = 'certificate_template2';
    $this->load->view('backend/index', $page_data);
}


function template3($param1='',$param2='',$param3=''){
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['certificate_design'] = "";
    if($param1=='download'){
     $this->load->model('Student_certificate_model');
    $page_data['certificate_detail'] = $this->Student_certificate_model->get_certificate_record($param2,$param3,'3');
//    pre($page_data['certificate_detail']); die;
    } else {
        $page_data['certificate_design'] = "true";
    }
    $page_data['page_title'] = get_phrase('template3');
    $page_data['page_name'] = 'certificate_template3';
    $this->load->view('backend/index', $page_data);
}

function template4($param1='',$param2='',$param3=''){
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['certificate_design'] = "";
    if($param1=='download'){
     $this->load->model('Student_certificate_model');
    $page_data['certificate_detail'] = $this->Student_certificate_model->get_certificate_record($param2,$param3,'4');
//    pre($page_data['certificate_detail']); die;
    } else {
        $page_data['certificate_design'] = "true";
    }
    $page_data['page_title'] = get_phrase('template4');
    $page_data['page_name'] = 'certificate_template4';
    $this->load->view('backend/index', $page_data);
}

function teacher_certificates($param1 = '', $param2 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');

    $this->load->model("Teacher_certificate_model");
    $this->load->model("Teacher_model");
    if ($param1 == 'create') {
        $data['certificate_title'] = $this->input->post('ceritificate_title');
        $data['sub_title'] = $this->input->post('sub_title');
        $data['main_content'] = $this->input->post('main_cantent');
        $data['teacher_id'] = $this->input->post('teacher_name');
        $data['template_type'] = $this->input->post('template_type');
        $data['date'] = date('Y-m-d H:i:s');
//    pre($data); die;
        $this->Teacher_certificate_model->add($data);
        $this->session->set_flashdata('flash_message', get_phrase('certificate_create_successfully'));
        redirect(base_url() . 'index.php?school_admin/teacher_certificates/', 'refresh');
    }
    if ($param1 == 'download') {
        $teacher_id = $this->input->post('teacher_id');
        $template_type = $this->input->post('template_type');
        if ($template_type == '1') {
            $method = "teacher_template1/download/$teacher_id";
        } elseif ($template_type == '2') {
            $method = "teacher_template2/download/$teacher_id";
        } elseif ($template_type == '3') {
            $method = "teacher_template3/download/$teacher_id";
        } else {
            $method = "teacher_template4/download/$teacher_id";
        }
        redirect(base_url() . 'index.php?school_admin/' . $method, 'refresh');
    }
    $page_data = $this->get_page_data_var();
    $page_data['page_title'] = get_phrase('teacher_certificate');
    $page_data['page_name'] = 'teacher_certificate';
    $this->load->view('backend/index', $page_data);
}

function teacher_template1($param1 = '', $param2 = '', $param3 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['certificate_design'] = "";
    if ($param1 == 'download') {
        $this->load->model('Teacher_certificate_model');
        $page_data['certificate_detail'] = $this->Teacher_certificate_model->get_certificate_record($param2,$param3,'1');
    } else {
        $page_data['certificate_design'] = "true";
    }
    $page_data['page_title'] = get_phrase('template1');
    $page_data['page_name'] = 'teacher_template1';
    $this->load->view('backend/index', $page_data);
}

function teacher_template2($param1 = '', $param2 = '', $param3 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['certificate_design'] = "";
    if ($param1 == 'download') {
        $this->load->model('Teacher_certificate_model');
        $page_data['certificate_detail'] = $this->Teacher_certificate_model->get_certificate_record($param2,$param3,'2');
    } else {
        $page_data['certificate_design'] = "true";
    }
    $page_data['page_title'] = get_phrase('template2');
    $page_data['page_name'] = 'teacher_template2';
    $this->load->view('backend/index', $page_data);
}

function teacher_template3($param1 = '', $param2 = '', $param3 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['certificate_design'] = "";
    if ($param1 == 'download') {
        $this->load->model('Teacher_certificate_model');
        $page_data['certificate_detail'] = $this->Teacher_certificate_model->get_certificate_record($param2,$param3,'3');
    } else {
        $page_data['certificate_design'] = "true";
    }
    $page_data['page_title'] = get_phrase('template3');
    $page_data['page_name'] = 'teacher_template3';
    $this->load->view('backend/index', $page_data);
}

function teacher_template4($param1 = '', $param2 = '', $param3 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['certificate_design'] = "";
    if ($param1 == 'download') {
        $this->load->model('Teacher_certificate_model');
        $page_data['certificate_detail'] = $this->Teacher_certificate_model->get_certificate_record($param2,$param3,'4');
    } else {
        $page_data['certificate_design'] = "true";
    }
    $page_data['page_title'] = get_phrase('template4');
    $page_data['page_name'] = 'teacher_template4';
    $this->load->view('backend/index', $page_data);
}

//Get Section by class
function get_section_by_class($class_id) {
    $page_data = $this->get_page_data_var();
    $this->load->model("Section_model");
    $sections = $this->Section_model->get_section_by_classid($class_id);
    foreach ($sections as $row) {
        echo '<option value="' . $row['section_id'] . '">' . $row['name'] . '</option>';
    }
}

//Get Student by section id and class id    
function get_student($section_id, $class_id) {
    $running_year = $this->Setting_model->get_year();
    $this->load->model("Enroll_model");
//        echo "year=".$running_year;
//        echo "class_id=".$class_id;
//        echo "section_id=".$section_id;
//        echo "success";

    $student_arr = $this->Enroll_model->get_student_array(array('section_id' => $section_id, 'class_id' => $class_id, 'year' => $running_year));
    foreach ($student_arr as $student) {
        $data = get_data_generic_fun('student', 'student_id, name, lname', array('student_id' => $student['student_id'], 'isActive' => '1', 'student_status' => '1', 'result_arr'));
        foreach ($data as $row) {
            echo '<option value="' . $row->student_id . '">' . $row->name . '</option>';
        }
    }
}

function teacher_attendance_report() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['month'] = date('m');
    $page_data['page_name'] = 'teacher_attendance_report';
    $page_data['page_title'] = get_phrase('teacher_attendance_report');
    $page_data['classes'] = $this->Class_model->get_class_array();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $this->load->view('backend/index', $page_data);
}

function teacher_attendance_report_selector() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->form_validation->set_rules('month', 'Month', 'required');
    if ($this->form_validation->run() == TRUE) {
        $data['year'] = $this->input->post('year');
        $data['month'] = $this->input->post('month');
        $data['section_id'] = $this->input->post('section_id');
        redirect(base_url() . 'index.php?school_admin/teacher_attendance_report_view/' . $data['month'], 'refresh');
    } else {
        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'teacher_attendance_report';
        $page_data['page_title'] = get_phrase('attendance_report');
        $page_data['classes'] = $this->Class_model->get_class_array();
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }
}

function teacher_attendance_report_view($month = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $this->load->model('Student_model');
    $page_data = $this->get_page_data_var();
    $page_data['month'] = $month;
    $page_data['page_name'] = 'teacher_attendance_report_view';
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $running_year = $this->globalSettingsRunningYear;
    $this->load->model("Teacher_model");
    $allTeachers = $this->Teacher_model->get_data_by_cols('*', array('isActive' => 1), 'result_arr');
    if (empty($allTeachers)) {
        redirect(base_url() . 'index.php?school_admin/teacher_attendance_report');
    }
    $page_data['teachers'] = $this->Teacher_model->get_data_by_cols('*', array('isActive' => 1), 'result_arr');

    $page_data['year'] = explode('-', $running_year);
    $page_data['days'] = cal_days_in_month(CAL_GREGORIAN, $month, $page_data['year'][0]);
    $page_data['page_title'] = get_phrase('attendance_report_of_teacher');
    //pre($page_data['teachers']);die;
    foreach ($page_data['teachers'] as $k => $row) { //pre($row);die;
        $p = 0;
        for ($i = 1; $i <= $page_data['days']; $i++) {
            $timestamp = strtotime($i . '-' . $month . '-' . $page_data['year'][0]);
            //$data = array('section_id' => $page_data['section_id'], 'class_id' => $page_data['class_id'], "year" => $running_year, "timestamp" => $timestamp, 'student_id' => $v['student_id']);
            //$atten = $this->Student_model->get_attendance($data);
            $atten = $this->db->get_where('attendance_teacher', array('year' => $running_year, 'timestamp' => $timestamp, 'teacher_id' => $row['teacher_id']))->result_array();
            //if(!empty($atten) && count($atten)>0)
            //pre($atten); //die();
            if (isset($atten) && !empty($atten) && count($atten) > 0) {
                $page_data['teachers'][$k]['atten'][$p] = $atten[0];
            }
            $p++;
        }
    }
    //die;
    //pre($page_data['teachers']); die();

    $this->load->view('backend/index', $page_data);
}

function teacher_attendance_report_print_view($month = "") {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Student_model');
    $page_data = $this->get_page_data_var();
    $page_data['month'] = $month;
    $page_data['page_name'] = 'teacher_attendance_report_print_view';
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $running_year = $this->globalSettingsRunningYear;
    $this->load->model("Teacher_model");
    $page_data['teachers'] = $this->Teacher_model->get_data_by_cols('*', array('isActive' => 1), 'result_arr');
    $page_data['year'] = explode('-', $running_year);
    $page_data['days'] = cal_days_in_month(CAL_GREGORIAN, $month, $page_data['year'][0]);
    $page_data['page_title'] = get_phrase('attendance_report_of_teacher');

    foreach ($page_data['teachers'] as $k => $row) { //pre($row);die;
        $p = 0;
        for ($i = 1; $i <= $page_data['days']; $i++) {
            $timestamp = strtotime($i . '-' . $month . '-' . $page_data['year'][0]);
            //$data = array('section_id' => $page_data['section_id'], 'class_id' => $page_data['class_id'], "year" => $running_year, "timestamp" => $timestamp, 'student_id' => $v['student_id']);
            //$atten = $this->Student_model->get_attendance($data);
            $atten = $this->db->get_where('attendance_teacher', array('year' => $running_year, 'timestamp' => $timestamp, 'teacher_id' => $row['teacher_id']))->result_array();
            if (!empty($atten) && count($atten) > 0)

            //pre($atten); die();
                if (isset($atten) && !empty($atten) && count($atten) > 0)
                    $page_data['teachers'][$k]['atten'][$p] = $atten[0];
            $p++;
        }
    }
    //pre($page_data['teachers']); die();

    $this->load->view('backend/index', $page_data);
}

function automatic_timetable_create_schedule() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Section_model');
    $this->load->model('Subject_model');
    $page_data = $this->get_page_data_var();
    $page_data['page_name'] = "automatic_timetable_create_schedule";
    $page_data['page_title'] = "automatic_timetable_create_schedule";
    $all_section = $this->Section_model->automatic_timetable_get_all_section();
    //pre($all_section);die;
    $page_data['all_section'] = $all_section;
    $all_subjects = $this->Subject_model->automatic_timetable_get_all_subjecs();
    //pre($all_subjects);die;
    $page_data['all_subjects'] = $all_subjects;
    $page_data['year'] = $this->globalSettingsRunningYear;
    $generate_schedule = $this->_automatic_timetable_generate_schedule();
    //pre($generate_schedule);die;
    $page_data['generate_schedule'] = $generate_schedule;
    $this->load->view('backend/index', $page_data);
}

//upload print receipt
function product_upload_receipt($param1 = '') {
    $page_data = $this->get_page_data_var();
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Inventory_allotment_model');
    $product_id = $param1;
    if ($param1 == 'create') {
        $product_id = $this->input->post('product_id');
        $data['product_id'] = $product_id;
        $data['product_id'] = $this->input->post('product_id');
        $data['teacher_id'] = $this->input->post('teacher_id');
        $data['date'] = date('Y-m-d H:i:s');
        $file_name = $_FILES['prodct_receipt']['name'];

        $types = array('image/jpeg', 'image/gif', 'image/png', 'application/pdf', 'application/doc', 'application/docx');
        if ($file_name != '') {
            if (in_array($_FILES['prodct_receipt']['type'], $types)) {

                $ext = explode(".", $file_name);
                $data['upload_file_name'] = "receipt_" . $file_name;
//                echo $data['image']; die;
                move_uploaded_file($_FILES['prodct_receipt']['tmp_name'], 'uploads/allot_product_receipt/' . $data['upload_file_name']);
                $product_receipt_id = $this->Inventory_allotment_model->save_product_allot_receipt($data);
                $this->session->set_flashdata('flash_message', get_phrase('upload_successfully'));
                redirect(base_url() . 'index.php?school_admin/product_upload_receipt/' . $product_id, 'refresh');
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('It may be the wrong filetype. We only allow JPG, GIF, and PNG, PDF, DOC filetypes!!'));
                redirect(base_url() . 'index.php?school_admin/product_upload_receipt/', 'refresh');
            }
        }
    }
    $page_data['allot_product_list'] = $this->Inventory_allotment_model->get_fields_array();
//            pre($allot_product_list); die;
    $page_data['product_id'] = $product_id;
    $page_data['page_name'] = 'product_upload_receipt';
    $page_data['page_title'] = get_phrase('allocation_product_receipt');
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $this->load->view('backend/index', $page_data);
}

function _automatic_timetable_generate_schedule() {
    $year = $this->globalSettingsRunningYear;
    // first we need to process every section
    $sql = "select s.subject_id,s.section_id from schedule_restriction_info sri, subject s where sri.subject_id = s.subject_id AND sri.year='$year'";
    $data = $this->db->query($sql)->result_array();

    $sections = array();
    $section_map = array();
    foreach ($data as $row) {
        $subject_id = $row['subject_id'];
        $section_id = $row['section_id'];
        $section_map[$subject_id] = $section_id;
        $sections[$section_id] = array();
    }

    $sql = "SELECT subject_id, time_step, nBlocks, block_size FROM schedule_restriction_info WHERE year='$year'";
    $data = $this->db->query($sql)->result_array();

    $subject = array();
    foreach ($data as $row) {
        $subject_id = $row['subject_id'];
        $time_step = $row['time_step'];
        $nBlocks = $row['nBlocks'];
        $block_size = $row['block_size'];
        $subject[$subject_id] = array('time_step' => $time_step, 'nBlocks' => $nBlocks, 'block_size' => $block_size, 'blocks' => array());
    }

    $sql = "SELECT subject_id, sum(sr.end_time-sr.start_time) time FROM schedule_restriction sr, schedule_restriction_info sri  WHERE sri.year='$year' AND sr.schedule_id = sri.schedule_id group by (subject_id) order by time";
    $data = $this->db->query($sql)->result_array();

    $order = array(); // processing order
    foreach ($data as $row) {
        array_push($order, $row['subject_id']);
    }

    $mintime = 60 * 24;
    $maxtime = 0;

    $sql = "SELECT sri.subject_id, day , sr.start_time, sr.end_time FROM schedule_restriction sr, schedule_restriction_info sri WHERE sri.year='$year' AND sr.schedule_id = sri.schedule_id";
    $data = $this->db->query($sql)->result_array();
    foreach ($data as $row) {
        $subject_id = $row['subject_id'];
        $day = $row['day'];
        $start_time = $row['start_time'];
        $end_time = $row['end_time'];
        if ($start_time < $mintime)
            $mintime = $start_time;
        if ($end_time > $maxtime)
            $maxtime = $end_time;
        array_push($subject[$subject_id]['blocks'], array('day' => $day, 'start_time' => $start_time, 'end_time' => $end_time)
        );
    }

    foreach ($order as $subject_id) {
        $section_id = $section_map[$subject_id];
        $days = array(array(), array(), array(), array(), array(), array(), array());
        foreach ($subject[$subject_id]['blocks'] as $entry) {
            array_push($days[$entry['day']], $entry);
        }
        //print_r($days);
        $data = array('subject_id' => $subject_id, 'data' => $days); //$subject[$subject_id]['blocks']);
        array_push($sections[$section_id], $data);
        //echo "$subject_id:  $section_id\n";
        //print_r();
    }

    $sql = "SELECT DISTINCT(time_step) FROM schedule_restriction_info WHERE year='$year'";
    $time_steps = $this->db->query($sql)->result_array();

    if (count($time_steps) == 1)
        $time_step = $time_steps[0]['time_step'];
    else
        $time_step = 30;  // TODO: compute GCD

    $totaltime = $maxtime - $mintime;
    $rows = $totaltime / $time_step;

    $tt = array();  // the time table
    for ($i = 0; $i < $rows; $i++) {
        $tt[$i] = array(array(), array(), array(), array(), array(), array(), array());
    }
    //pre($sections);die;
    foreach ($sections as $section_id => $section) {
        //pre($section);die;
        foreach ($section as $subject_row) {
            $subject_id = $subject_row['subject_id'];
            $blocks = $subject_row['data'];

            $nBlocks = $subject[$subject_id]['nBlocks'];
            $block_size = $subject[$subject_id]['block_size'];
            $time_step0 = $subject[$subject_id]['time_step'];

            $block_size0 = $nBlocks;

            $block_size *= $time_step0 / $time_step;

            //	echo "$subject_id $nBlocks $block_size $block_size0 $time_step $time_step0\n";
            //return;
            //print_r($blocks);
            // get a random permutation of days

            $day_perm = array(0, 1, 2, 3, 4, 5, 6);
            for ($i = 0; $i < 6; $i++) {
                $other = rand($i + 1, 6);
                $tmp = $day_perm[$other];
                $day_perm[$other] = $day_perm[$i];
                $day_perm[$i] = $tmp;
            }


            //pre($day_perm);die;
            //pre($subject_row); //die;
            foreach ($day_perm as $day) {
                if ($nBlocks == 0)
                    break;  // subject is done!
                    
//pre('$day'.$day); //die;
                $day_blocks = $subject_row['data'][$day];
                //pre($day_blocks); //die;
                foreach ($day_blocks as $block) {
                    //pre($day_blocks);
                    if ($nBlocks == 0)
                        break;
                    $start_time = $block['start_time'];
                    $end_time = $block['end_time'];
                    $i0 = ($start_time - $mintime) / $time_step;
                    $i1 = ($end_time - $mintime) / $time_step;
                    //pre("$subject_id $i0 $i1 $mintime $start_time $end_time\n");die;
                    $blockAssigned = false;
                    for ($i = $i0; $i < $i1; $i++) {
                        // find a free block
                        $subjects_in_slot = $tt[$i][$day];
                        if (!$this->automatic_timetable_subject_section_in($subjects_in_slot, $section_id)) {
                            $n = 0;
                            while ($i < $i1 && !$this->automatic_timetable_subject_section_in($subjects_in_slot, $section_id) && $n < $block_size) {
                                $i++;
                                $n++;

                                $subjects_in_slot = @$tt[$i][$day];
                            }
                            if ($n == $block_size) {
                                $init = $i - $n;
                                for ($j = 0; $j < $n; $j++)
                                    array_push($tt[$init + $j][$day], array('section_id' => $section_id, 'subject_id' => $subject_id));

                                //	echo "block found ($init) for $section_id $subject_id! Day: $day\n";
                                //print_r($tt);
                                $nBlocks--;
                                $i = $init;
                                $blockAssigned = true;
                                break;
                                //print_r($tt);
                                //return;
                            }
                        }
                    }
                    if ($blockAssigned)
                        break;  // next day!
                }
            }

            //print_r($block);
        }
    }
    $tt = array('min' => $mintime, 'max' => $maxtime, 'time_step' => $time_step, 'data' => $tt);
    //pre($tt); die;
    return $tt;
}

function automatic_timetable_subject_section_in($subjects_in_slot, $section_id) {
    //	print_r($subjects_in_slot);
    foreach ($subjects_in_slot as $info) {
        if ($info['section_id'] == $section_id)
            return true;
    }
    return false;
}

/* function show_automatic_timetable(){
  $this->load->model("Class_routine_model");
  $this->load->model("Subject_model");
  if ($this->session->userdata('school_admin_login') != 1)
  redirect(base_url(), 'refresh');
  $page_data = $this->get_page_data_var();
  $page_data['page_name'] = 'class_routine_view';
  $page_data['class_id'] = $class_id;
  $page_data['page_title'] = get_phrase('class_timetable');
  $page_data['total_notif_num'] = $this->get_no_of_notication();
  $page_data['classes'] = $this->Class_model->get_data_by_cols('*', array(), 'result_array', array('name_numeric' => 'asc'));
  $class = $this->Class_model->get_data_by_cols('name', array('class_id' => $class_id), 'result_array');
  $class_names = array_shift($class);
  if (!empty($class_names)) {
  $page_data['class_name'] = array_shift($class_names);
  } else {
  $page_data['class_name'] = "";
  }
  $year = $this->globalSettingsRunningYear;
  $class_routine = array();
  $sections = $this->Section_model->get_data_by_cols('*', array('class_id' => $class_id), 'result_array');
  foreach ($sections as $section) {
  $routine = array();
  for ($d = 1; $d <= 7; $d++) {
  if ($d == 1)
  $day = 'sunday';
  else if ($d == 2)
  $day = 'monday';
  else if ($d == 3)
  $day = 'tuesday';
  else if ($d == 4)
  $day = 'wednesday';
  else if ($d == 5)
  $day = 'thursday';
  else if ($d == 6)
  $day = 'friday';
  else if ($d == 7)
  $day = 'saturday';
  $routiness = $this->Class_routine_model->get_data_by_cols('*', array('day' => $day, 'class_id' => $class_id, 'section_id' => $section['section_id'], 'year' => $year), 'result_array', array('time_start' => 'asc'));
  $i = 0;
  $routine_det = array();
  foreach ($routiness as $value) {
  $subject = $this->Subject_model->get_data_by_cols('name as subject_name,teacher_id', array('subject_id' => $value['subject_id']), 'result_array');
  $subject_name = array_shift($subject);

  $teachers_name = $this->Teacher_model->get_data_by_cols('name as teacher_name', array('teacher_id' => $subject_name['teacher_id']), 'result_array');
  $teacher_name = array_shift($teachers_name);
  $teacher_name = $teacher_name['teacher_name'];
  $subject_name = $subject_name['subject_name'];

  $routine_det[$i]['subject_name'] = $subject_name;
  $routine_det[$i]['teacher_name'] = $teacher_name;
  $routine_det[$i]['time_start'] = $value['time_start'];
  $routine_det[$i]['time_end'] = $value['time_end'];
  $routine_det[$i]['time_start_min'] = $value['time_start_min'];
  $routine_det[$i]['time_end_min'] = $value['time_end_min'];
  $routine_det[$i]['isActive'] = $value['isActive'];
  $routine_det[$i]['class_routine_id'] = $value['class_routine_id'];
  $i++;
  }
  $routine[$day] = $routine_det;
  }

  $class_routine[$section['name']][$section['section_id']] = $routine;
  }
  $page_data['routines'] = $class_routine;
  $page_data['classes_array'] = $this->Class_model->get_data_by_cols('*', array(), 'result_array');
  $this->load->view('backend/index', $page_data);

  } */

function setting_feedback($param1 = '', $param2 = '', $param3 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');

    $page_data = $this->get_page_data_var();
    $this->load->model('Teacher_model', 'teachers');
    if ($param3 == '') {
        $page_data['status_check'] = '';
    }
    if ($param1 == 'status_change') {
        $data = array();
        if ($param2 == 'all') {
            $data['feedback_status'] = $param3;
            if ($param3 == 'Y') {
                $msg = "enable";
                $this->teachers->update_feedback_disableAll($data);
                $this->session->set_flashdata('flash_message', get_phrase('all_teacher_feedback_' . $msg . '_successfully'));
                $page_data['status_check'] = 'Y';
                //redirect(base_url() . 'index.php?school_admin/setting_feedback', 'refresh');
            } else {
                $msg = "disable";
                $this->teachers->update_feedback_disableAll($data);
                $this->session->set_flashdata('flash_message', get_phrase('all_teacher_feedback_' . $msg . '_successfully'));
                $page_data['status_check'] = 'N';
                //redirect(base_url() . 'index.php?school_admin/setting_feedback/', 'refresh');                
            }
        } else {
            if ($param3 == 'Y') {
                $page_data['status_check'] = 'N';
                $data['feedback_status'] = 'N';
                $msg = 'disable';
            } else {
                $page_data['status_check'] = 'Y';
                $data['feedback_status'] = 'Y';
                $msg = 'enable';
            }
            $this->teachers->update_feedback_status($data, array("teacher_id" => $param2));
            $this->session->set_flashdata('flash_message', get_phrase('feedback_' . $msg . '_successfully'));
            redirect(base_url() . 'index.php?school_admin/setting_feedback/', 'refresh');
        }
    }

    $page_data['list'] = $this->teachers->get_teacher_array();
    $page_data['page_name'] = 'feedback_setting';
    $page_data['page_title'] = get_phrase('feedback_setting');
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $this->load->view('backend/index', $page_data);
}

function icse_manage_marks() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Exam_model');
    $page_data = $this->get_page_data_var();
    $page_data['exams'] = $this->Exam_model->icse_exam();
    $page_data['classes'] = $this->Cce_model->get_icse_classes();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_name'] = 'icse_manage_marks';
    $page_data['page_title'] = get_phrase('manage_exam_marks');
    $this->load->view('backend/index', $page_data);
}

function icse_marksheet_view($class_id = '', $student_id = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $class_name = $this->db->get_where('class', array('class_id' => $class_id))->row()->name;
    $this->load->model('Subject_model');
    $page_data['subjects'] = $this->Subject_model->marks_get_icse_subject($class_id);
    /* $page_data['subjects'] = $this->Subject_model->get_subject_array(array('class_id' => $class_id)); */

    $all_marks = array();
    foreach ($page_data['subjects'] as $sub) {
        $sub_id = $sub['subject_id'];

        $this->db->select('*');
        $this->db->from('mark');
        $this->db->join('icse_exam', 'mark.exam_id = icse_exam.exam_id');
        $this->db->join('subject', 'mark.subject_id = subject.subject_id');
        $this->db->join('icse_exam_connect', 'icse_exam_connect.icse_exam_id = icse_exam.icse_exam_id');
        $this->db->where('mark.student_id', $student_id);
        $this->db->where('mark.subject_id', $sub_id);
        $this->db->where('icse_exam_connect.icse_connect_status', 1);
        $this->db->group_by('mark_id');

        $all_marks[$sub_id] = $this->db->get()->result_array();
    }

    $page_data['marks'] = $all_marks;
    //pre($page_data['marks']);
    $page_data['class_id'] = $class_id;
    $page_data['page_name'] = 'icse_marksheet_view';
    $student_name = $this->db->get_where('student', array('student_id' => $student_id))->row()->name;
    $page_data['student_id'] = $student_id;
    $page_data['page_title'] = get_phrase('marksheet_of') . ' ' . $student_name . ' : ' . get_phrase('class') . ' ' . $class_name;
    $page_data['class_name'] = $class_name;
    $page_data['total_notif_num'] = $this->get_no_of_notication();

    /* Student Details */
    $page_data['student_info'] = $this->Student_model->get_student_details($student_id);
    if (!empty($page_data['student_info'])) {
        $class_id = $page_data['student_info']->class_id;
        $section_id = $page_data['student_info']->section_id;
    }
    $page_data['parents'] = $this->Parent_model->get_parents_array();
    //pre($page_data);
    $this->load->view('backend/index', $page_data);
}



function cron_custom_message_scheduling() {
    $ScheduleTime = date('Y-m-d H:i');
    $this->Student_bus_allocation_model->get_data4_fill_student_bus_allocation_table();
}

/* IGCSE GRADING METHOD */

function igcse_subjects($param1 = '', $param2 = '') {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('Subject_model');
    $this->load->model('Cce_model');
    $page_data = $this->get_page_data_var();
    if ($param1 == 'delete') {
        $this->Cce_model->delete_igcse_subject($param2);
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect($_SERVER['HTTP_REFERER']);
    }

    if ($param2 == 'add') {
        // pre($this->input->post());
        //exit;
        $selected_subject = $this->input->post('selected_subject');
        $selected_weekly_classes = $this->input->post('selected_weekly_classes');
        $selected_sixth_subject = $this->input->post('selected_sixth_subject');
        $selected_compulsory_subject = $this->input->post('selected_compulsory_subject');
        $selected_optional_subject = $this->input->post('selected_optional_subject');
        $i = 0;

        foreach ($selected_subject as $row) {
            $dataArray['subject_id'] = $row;
            $dataArray['weekly_classes'] = $selected_weekly_classes[$i];
            if ($selected_compulsory_subject != NULL) {
                if (in_array($row, $selected_compulsory_subject)) {
                    $dataArray['compulsory_subject'] = 1;
                } else {
                    $dataArray['compulsory_subject'] = 0;
                }
            }
            if ($selected_sixth_subject != NULL) {
                if (in_array($row, $selected_sixth_subject)) {
                    $dataArray['sixth_subject'] = 1;
                } else {
                    $dataArray['sixth_subject'] = 0;
                }
            }
            if ($selected_optional_subject != NULL) {
                if (in_array($row, $selected_optional_subject)) {
                    $dataArray['optional_subject'] = 1;
                } else {
                    $dataArray['optional_subject'] = 0;
                }
            }
            $this->Cce_model->save_igcse_subject($dataArray);
            $i++;
        }
        $this->session->set_flashdata('flash_message', get_phrase('subjects_added_to_IGCSE_evaluation'));
        $page_data['page_name'] = 'exam_settings';
        $page_data['page_title'] = get_phrase('exam_settings');
        redirect($_SERVER['HTTP_REFERER']);
    }

    if ($param1 == 'do_update') {
        $data['subject_id'] = $this->input->post('selected_subject');
        $data['weekly_classes'] = $this->input->post('selected_weekly_classes');
        $data['sixth_subject'] = ($this->input->post('selected_sixth_subject')) ? 1 : 0;
        $data['compulsory_subject'] = ($this->input->post('selected_compulsory_subject')) ? 1 : 0;
        $data['optional_subject'] = ($this->input->post('selected_optional_subject')) ? 1 : 0;

        $rs = $this->Cce_model->update_igcse_subjects($data, array('id' => $param2));

        if ($rs) {
            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        }
        /* redirect(base_url() . 'index.php?school_admin/exam_settings/', 'refresh'); */
        redirect($_SERVER['HTTP_REFERER']);
    }


    $subjects = $this->Cce_model->get_igcse_subjects(array('class_id' => $param1));
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['icse_class_id'] = $param1;
    $page_data['subjects'] = $subjects;
    $page_data['page_name'] = 'ajax_igcse_subjects';
    $page_data['page_title'] = get_phrase('icse_subjects');

    $page_data['class_subjects'] = $this->Subject_model->get_subject_array(array('class_id' => $param1));

    $this->load->view('backend/school_admin/ajax_igcse_subjects.php', $page_data);
}

/* IGCSE GRADING METHOD */

function show_timetables() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model("Subject_model");
    $page_data = $this->get_page_data_var();
    $page_data['page_name'] = 'class_routine_view';
    $page_data['class_id'] = $this->Class_model->get_first_class_id();
    $page_data['classes'] = $this->Class_model->get_data_by_cols('*', array(), 'result_array', array('name_numeric' => 'asc'));
    $page_data['page_title'] = get_phrase('class_timetable');
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $return_class_data = $this->Class_model->get_data_by_cols('*', array(), 'result_array', array('name_numeric' => 'asc'));

    $page_data['classes_array'] = $return_class_data;
    $class = $this->Class_model->get_data_by_cols('name', array('class_id' => $page_data['class_id']), 'result_array');
    if (!empty($class)) {
        $class_names = array_shift($class);
        $page_data['class_name'] = array_shift($class_names);
    }
    $year = $this->globalSettingsRunningYear;
    $class_routine = array();
    $sections = $this->Section_model->get_data_by_cols('*', array('class_id' => $page_data['class_id']), 'result_array');
    foreach ($sections as $section) {
        $routine = array();
        for ($d = 1; $d <= 7; $d++) {
            if ($d == 1)
                $day = 'sunday';
            else if ($d == 2)
                $day = 'monday';
            else if ($d == 3)
                $day = 'tuesday';
            else if ($d == 4)
                $day = 'wednesday';
            else if ($d == 5)
                $day = 'thursday';
            else if ($d == 6)
                $day = 'friday';
            else if ($d == 7)
                $day = 'saturday';
            $routiness = $this->Class_routine_model->get_data_by_cols('*', array('day' => $day, 'class_id' => $page_data['class_id'], 'section_id' => $section['section_id'], 'year' => $year), 'result_array', array('time_start' => 'asc'));
            $i = 0;
            $routine_det = array();
            foreach ($routiness as $value) {

                $subject = $this->Subject_model->get_data_by_cols('name as subject_name,teacher_id', array('subject_id' => $value['subject_id']), 'result_array');
                $subject_name = array_shift($subject);


                $teachers_name = $this->Teacher_model->get_data_by_cols('name as teacher_name', array('teacher_id' => $subject_name['teacher_id']), 'result_array');
                $teacher_name = array_shift($teachers_name);
                $teacher_name = $teacher_name['teacher_name'];
                $subject_name = $subject_name['subject_name'];

                $routine_det[$i]['subject_name'] = $subject_name;
                $routine_det[$i]['teacher_name'] = $teacher_name;
                $routine_det[$i]['time_start'] = $value['time_start'];
                $routine_det[$i]['time_end'] = $value['time_end'];
                $routine_det[$i]['time_start_min'] = $value['time_start_min'];
                $routine_det[$i]['time_end_min'] = $value['time_end_min'];
                $routine_det[$i]['isActive'] = $value['isActive'];
                $routine_det[$i]['class_routine_id'] = $value['class_routine_id'];
                $i++;
            }
            $routine[$day] = $routine_det;
        }

        $class_routine[$section['name']][$section['section_id']] = $routine;
    }
    $page_data['routines'] = $class_routine;
    $this->load->view('backend/index', $page_data);
}

function show_timetable($class_id = "") {
    $this->load->model("Class_routine_model");
    $this->load->model("Subject_model");
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['page_name'] = 'class_routine_view';
    $page_data['class_id'] = $class_id;
    $page_data['page_title'] = get_phrase('class_timetable');
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['classes'] = $this->Class_model->get_data_by_cols('*', array(), 'result_array', array('name_numeric' => 'asc'));
    $class = $this->Class_model->get_data_by_cols('name', array('class_id' => $class_id), 'result_array');
    $class_names = array_shift($class);
    if (!empty($class_names)) {
        $page_data['class_name'] = array_shift($class_names);
    } else {
        $page_data['class_name'] = "";
    }
    $year = $this->globalSettingsRunningYear;
    $class_routine = array();
    $sections = $this->Section_model->get_data_by_cols('*', array('class_id' => $class_id), 'result_array');
    foreach ($sections as $section) {
        $routine = array();
        for ($d = 1; $d <= 7; $d++) {
            if ($d == 1)
                $day = 'sunday';
            else if ($d == 2)
                $day = 'monday';
            else if ($d == 3)
                $day = 'tuesday';
            else if ($d == 4)
                $day = 'wednesday';
            else if ($d == 5)
                $day = 'thursday';
            else if ($d == 6)
                $day = 'friday';
            else if ($d == 7)
                $day = 'saturday';
            $routiness = $this->Class_routine_model->get_data_by_cols('*', array('day' => $day, 'class_id' => $class_id, 'section_id' => $section['section_id'], 'year' => $year), 'result_array', array('time_start' => 'asc'));
            $i = 0;
            $routine_det = array();
            foreach ($routiness as $value) {
                $subject = $this->Subject_model->get_data_by_cols('name as subject_name,teacher_id', array('subject_id' => $value['subject_id']), 'result_array');
                $subject_name = array_shift($subject);

                $teachers_name = $this->Teacher_model->get_data_by_cols('name as teacher_name', array('teacher_id' => $subject_name['teacher_id']), 'result_array');
                $teacher_name = array_shift($teachers_name);
                $teacher_name = $teacher_name['teacher_name'];
                $subject_name = $subject_name['subject_name'];

                $routine_det[$i]['subject_name'] = $subject_name;
                $routine_det[$i]['teacher_name'] = $teacher_name;
                $routine_det[$i]['time_start'] = $value['time_start'];
                $routine_det[$i]['time_end'] = $value['time_end'];
                $routine_det[$i]['time_start_min'] = $value['time_start_min'];
                $routine_det[$i]['time_end_min'] = $value['time_end_min'];
                $routine_det[$i]['isActive'] = $value['isActive'];
                $routine_det[$i]['class_routine_id'] = $value['class_routine_id'];
                $i++;
            }
            $routine[$day] = $routine_det;
        }

        $class_routine[$section['name']][$section['section_id']] = $routine;
    }
    $page_data['routines'] = $class_routine;
    $page_data['classes_array'] = $this->Class_model->get_data_by_cols('*', array(), 'result_array');
    $this->load->view('backend/index', $page_data);
}
 
   function custom_message($param1 = '') {
        if ($this->session->userdata('school_admin_login') != 1)
            redirect(base_url(), 'refresh');

        $this->load->model('Message_model');

        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
        }

    if ($param1 == 'send') {
        //pre($this->input->post());die;
        $parent_reciever = $this->input->post('parent_reciever');
        $student_reciever = $this->input->post('student_reciever');
        $teacher_reciever = $this->input->post('teacher_reciever');

        if (count($parent_reciever)) {
            $ParentDetails = $this->Parent_model->get_parent_details($parent_reciever);
            if(count($ParentDetails)) {
                foreach ($ParentDetails as $parent) {
                    $data = array();
                    $ParentName = ucfirst($parent['father_name']) . ' ' . ucfirst($parent['father_mname']) . ' ' . ucfirst($parent['father_lname']);
                    $data['notice_title'] = 'Static Title';
                    $data['message'] = $this->input->post('parent_message');
                    $data['receiver_type'] = 'P';
                    //$data['class_id'] = '';
                    $data['receiver_id'] = $parent['parent_id'];
                    $data['receiver_full_name'] = $ParentName;
                    $data['receiver_mobile_no'] = $parent['cell_phone'];
                    $data['receiver_email'] = $parent['email'];
                    $data['sender_type'] = $this->session->userdata('u_type');
                    $data['sender_id'] = $this->session->userdata('login_user_id');
                    $data['later_schedule_time'] = $this->input->post('set_date_time');
                    $data['device_token'] = $parent['device_token'];
                    $data['school_id'] = $school_id;

                    if($data['later_schedule_time']==''){
                       $data['message_schedule_status'] = '1'; 
                    }

                    $message = array();
                    $message['sms_message'] = $data['message'];
                    $message['subject'] = 'title';
                    $message['messagge_body'] = $data['message'];
                    $message['to_name'] = ucwords($ParentName);
                    //$this->Message_model->add_custom_messsage_schudule($data);
                    $ReceiverPhone = ($parent['cell_phone'] != '') ? $parent['cell_phone'] : (($parent['mother_mobile'] != '') ? $parent['mother_mobile'] : (($parent['home_phone'] != '') ? $parent['home_phone'] : $parent['work_phone']));
                    $ReceiverEmail = ($parent['email'] != '') ? $parent['email'] : $parent['mother_email'] != '';
                    //$user_details = array('user_id' => $parent['parent_id'], 'user_type' => 'parent');
                    //$par_message = $this->input->post('parent_message');
                    //if ($data['later_schedule_time'] == '') {
                    send_school_notification_new('custom_message_admin', $message, $ReceiverPhone, $ReceiverEmail, $data);
                    /*} else {
                        echo "";
                    }*/
                }
            }
        }

        if (count($student_reciever)) {            
            $StudentDetails = $this->Student_model->get_student_details_by_id($student_reciever);
            if (count($StudentDetails)) {
                foreach ($StudentDetails as $student) {
                    $data1 = array();
                    $StudentName = ucfirst($student['name']) . ' ' . ucfirst($student['mname']) . ' ' . ucfirst($student['lname']);

                    $data1['notice_title'] = 'Static Title';
                    $data1['message'] = $this->input->post('student_message');
                    $data1['receiver_type'] = 'S';
                    $data1['class_id'] = $student['class_id'];
                    $data1['receiver_id'] = $student['student_id'];
                    $data1['receiver_full_name'] = $StudentName;
                    $data1['receiver_mobile_no'] = $student['phone'];
                    $data1['receiver_email'] = $student['email'];
                    $data1['sender_type'] = $this->session->userdata('u_type');
                    $data1['sender_id'] = $this->session->userdata('login_user_id');
                    $data1['later_schedule_time'] = $this->input->post('set_date_time1');
                    $data1['device_token'] = $student['device_token'];
                    $data1['school_id'] = $school_id;

                    if($data1['later_schedule_time']==''){
                       $data1['message_schedule_status'] = '1'; 
                    }

                    $message = array();
                    $message['sms_message'] = $data1['message'];
                    $message['subject'] = 'title';
                    $message['messagge_body'] = $data1['message'];
                    $message['to_name'] = ucwords($StudentName);
                    $ReceiverPhone = $student['phone'];
                    $ReceiverEmail = $student['email'];

                    send_school_notification_new('custom_message_admin', $message, $ReceiverPhone, $ReceiverEmail, $data1);
                    
                }
            }
        }

        if (count($teacher_reciever)) {           
            $TeacherDetails = $this->Teacher_model->get_teacher_details_by_id($teacher_reciever);
            if (count($TeacherDetails)) {
                foreach ($TeacherDetails as $teacher) {
                    $data2 = array();

                    $TeacherName = ucfirst($teacher['name']) . ' ' . ucfirst($teacher['middle_name']) . ' ' . ucfirst($teacher['last_name']);

                    $data2['notice_title'] = 'Static Title';
                    $data2['message'] = $this->input->post('teacher_message');
                    $data2['receiver_type'] = 'T';
                    $data2['class_id'] = $teacher['class_id'];
                    $data2['receiver_id'] = $teacher['teacher_id'];
                    $data2['receiver_full_name'] = $TeacherName;
                    $data2['receiver_mobile_no'] = $teacher['cell_phone'];
                    $data2['receiver_email'] = $teacher['email'];
                    $data2['sender_type'] = $this->session->userdata('u_type');
                    $data2['sender_id'] = $this->session->userdata('login_user_id');
                    $data2['later_schedule_time'] = $this->input->post('set_date_time2');
                    $data2['device_token'] = $teacher['device_token'];
                    $data2['school_id'] = $school_id;

                    if($data2['later_schedule_time']==''){
                       $data2['message_schedule_status'] = '1'; 
                    }

                    $message = array();
                    $message['sms_message'] = $data2['message'];
                    $message['subject'] = 'title';
                    $message['messagge_body'] = $data2['message'];
                    $message['to_name'] = ucwords($TeacherName);

                    $ReceiverPhone = ($teacher['cell_phone'] != '') ? $teacher['cell_phone'] : (($teacher['work_phone'] != '') ? $teacher['work_phone'] : $teacher['home_phone']);
                    $ReceiverEmail = $teacher['email'];

                    send_school_notification_new('custom_message_admin', $message, $ReceiverPhone, $ReceiverEmail, $data2);
                }
            }
        }
    } else {
        $this->load->model("Notification_model");
        $page_data['classes'] = $this->Class_model->get_class_array();
        $page_data['page_name'] = 'mobile_message';
        $page_data['page_title'] = get_phrase('custom_message');
        $page_data['notices'] = $this->Notification_model->getNotices();
        $this->load->view('backend/index', $page_data);
    }
}

    function unique_multidim_array($array, $key) { 
        $temp_array = array(); 
        $i = 0; 
        $key_array = array(); 
        
        foreach($array as $val) { 
            if (!in_array($val[$key], $key_array)) { 
                $key_array[$i] = $val[$key]; 
                $temp_array[$i] = $val; 
            } 
            $i++; 
        } 
        return $temp_array; 
    }


    function create_custom_message() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');

    $parents = array();
    $students = array();
    $teachers = array();
    $i = $j = $k = 0;

    $receiver = $this->input->post('receiver_type');
    $class_id = $this->input->post('class_id');
    $page_data['receiver_type'] = $receiver;
    $page_data['class_id'] = $class_id;

    if (count($class_id) && count($receiver)) {
        $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
        foreach ($class_id as $class) {
            $cls_id = $class;

            foreach ($receiver as $recv) {
                $ReceiverFlag = $recv;
                if ($ReceiverFlag == '1') {
                    $ReceiverDetails = $this->Parent_model->getall_active_parents($cls_id, $running_year);

                    if (count($ReceiverDetails)) {
                        foreach ($ReceiverDetails as $ReceivePerson) {
                            $ReceiverPhone = $ReceivePerson['cell_phone'];
                            $ReceiverEmail = $ReceivePerson['parent_email'];
                            $ReceiverId = $ReceivePerson['parent_id'];

                            $ReceiverFullname = ucfirst($ReceivePerson['father_name']) . ' ' . ucfirst($ReceivePerson['father_mname']) . ' ' . ucfirst($ReceivePerson['father_lname']);
                            if (($ReceiverPhone != '') && ($ReceiverEmail != '')) {
                                $parents[$i]['parent_phone'] = $ReceiverPhone;
                                $parents[$i]['parent_email'] = $ReceiverEmail;
                                $parents[$i]['parent_fullname'] = $ReceiverFullname;
                                $parents[$i]['parent_id'] = $ReceiverId;
                                $i++;
                            }
                        }
                    }
                } else if ($ReceiverFlag == '2') {
                    $ReceiverDetails = $this->Student_model->getall_active_students($cls_id, $running_year);

                    if (count($ReceiverDetails)) {
                        foreach ($ReceiverDetails as $ReceivePerson) {
                            $ReceiverPhone = $ReceivePerson['phone'];
                            $ReceiverEmail = $ReceivePerson['email'];
                            $ReceiverId = $ReceivePerson['student_id'];

                            $ReceiverFullname = ucfirst($ReceivePerson['stdent_fname']) . ' ' . ucfirst($ReceivePerson['mname']) . ' ' . ucfirst($ReceivePerson['lname']);

                            if (($ReceiverPhone != '') && ($ReceiverEmail != '')) {
                                $students[$j]['student_phone'] = $ReceiverPhone;
                                $students[$j]['student_email'] = $ReceiverEmail;
                                $students[$j]['student_fullname'] = $ReceiverFullname;
                                $students[$j]['student_id'] = $ReceiverId;
                                $j++;
                            }
                        }
                    }
                } else if ($ReceiverFlag == '3') {
                    $ReceiverDetails = $this->Teacher_model->getallteachers($cls_id);

                    if (count($ReceiverDetails)) {
                        foreach ($ReceiverDetails as $ReceivePerson) {
                            $ReceiverPhone = $ReceivePerson['cell_phone'];
                            $ReceiverEmail = $ReceivePerson['email'];
                            $ReceiverId = $ReceivePerson['teacher_id'];

                            $ReceiverFullname = ucwords($ReceivePerson['name']);
                            if (($ReceiverPhone != '') && ($ReceiverEmail != '')) {
                                $teachers[$k]['teacher_phone'] = $ReceiverPhone;
                                $teachers[$k]['teacher_email'] = $ReceiverEmail;
                                $teachers[$k]['teacher_fullname'] = $ReceiverFullname;
                                $teachers[$k]['teacher_id'] = $ReceiverId;
                                $k++;
                            }
                        }
                    }
                }
            }
        }
    }

    $page_data['parents'] = $parents;

    if(count($parents)){
        $AllParents = $this->unique_multidim_array($parents,'parent_id');
        $page_data['parents'] = $AllParents;       
    }

    $page_data['teachers'] = $teachers;

    if(count($teachers)){
        $AllTeachers = $this->unique_multidim_array($teachers,'teacher_id');
        $page_data['teachers'] = $AllTeachers;
    }

    $page_data['students'] = $students;
    
    $page_data['page_title'] = get_phrase('custom_message');
    $page_data['page_name'] = 'create_mobile_message';
    $this->load->view('backend/school_admin/create_mobile_message', $page_data);
    //$this->load->view('backend/index', $page_data);
}
    
    

    function fill_student_bus_allocation_table() {
    $this->Student_bus_allocation_model->get_data4_fill_student_bus_allocation_table();
}


   function icse_exam_connect($param1 = '', $param2 = '') {
    $page_data = $this->get_page_data_var();
    if ($param1 == 'connect') {
        $connect_exam[] = $this->input->post('selected_exam');
        $term[] = $this->input->post('icse_exam_term');
        $page_data['icse_exam_id'] = $connect_exam;
        $page_data['term'] = $term;
        //pre($page_data); //die();
        $save_data = array();
        if (count($connect_exam[0])) {
            foreach ($connect_exam[0] as $k => $row) {
                $save_data['icse_exam_id'] = $row;
                $save_data['icse_connect_status'] = 1;
                if (isset($term[0][$k]))
                    $save_data['term'] = $term[0][$k];
                //pre($save_data); //die();
                $this->Exam_model->icse_exam_connect($save_data);
            }
        }//die;
        $this->session->set_flashdata('flash_message', get_phrase('exam_connected'));
        redirect(base_url() . 'index.php?school_admin/exam_settings/', 'refresh');
    }

    if ($param1 == 'delete') {
        $this->Exam_model->delete_icse_connect_exam($param2);
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?school_admin/exam_settings/', 'refresh');
    }
}


   function icse_report_card() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['classes'] = $this->Cce_model->get_icse_classes();
    $page_data['page_name'] = 'icse_report_card';
    $page_data['page_title'] = get_phrase('report_card');
    $this->load->view('backend/index', $page_data);
}

   
function icse_marksheet_selector() {
    $data['class_id'] = $this->input->post('class_id');
    $data['section_id'] = $this->input->post('section_id');
    $data['year'] = $this->input->post('year');
    $data['timestamp'] = strtotime($this->input->post('timestamp'));
    $data['student_id'] = $this->input->post('student_id');

    $query = $this->db->get_where('enroll', array(
        'class_id' => $data['class_id'],
        'student_id' => $data['student_id'],
        'year' => $data['year']
    ));

    redirect(base_url() . 'index.php?school_admin/icse_marksheet_view/' . $data['class_id'] . '/' . $data['student_id'], 'refresh');
}

    //Student Certificate list
    function student_certificate_list($class_id='',$section_id='',$student_id=''){
         if ($this->session->userdata('school_admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model('Class_model');
        $this->load->model('Section_model');
        $this->load->model('Student_certificate_model');
        $year = $this->globalSettingsRunningYear;
         if ($class_id != '') {
             $sections = $this->Section_model->get_data_generic_fun('*',array('class_id'=>$class_id),'result_arr');
            $page_data['sections'] = $sections;
        }
        $data = array();
        if ($class_id != '' || $section_id != '') {
            $student_arr = $this->Enroll_model->get_student_array(array('section_id' => $section_id, 'class_id' => $class_id, 'year' => $year));
            foreach ($student_arr as $student):
                $stu_rs = get_data_generic_fun('student', 'student_id, name, lname', array('student_id' => $student['student_id'], 'isActive' => '1', 'student_status' => '1'), 'result_arr');

                if (isset($stu_rs[0])) {
                    $data[] = $stu_rs[0];
                }
            endforeach;
            $page_data['students'] = $data;
        }
        $page_data['class_id'] = $class_id;
        $page_data['section_id'] = $section_id;
        $page_data['student_id'] = $student_id;
        $page_data['classes'] = $this->Class_model->get_class_array();
        $page_data['page_name'] = 'student_certificate_list';
        $page_data['page_title'] = get_phrase('student_certificate_list');
        $condition = array('student_id' => $student_id);
        $sortArr = array('certificate_id' => 'desc');
        $page_data['certificate_list'] = $this->Student_certificate_model->get_data_by_cols('*', $condition, 'result_type', $sortArr);
        $this->load->view('backend/index', $page_data);
    }
    
     function get_student_by_section_class($section_id, $class_id) {
        $running_year = $this->Setting_model->get_year();
        $this->load->model("Enroll_model");
        $student_arr = $this->Enroll_model->get_student_array(array('section_id' => $section_id, 'class_id' => $class_id, 'year' => $running_year));
        foreach ($student_arr as $student) {
            $data = get_data_generic_fun('student', 'student_id, name, lname', array('student_id' => $student['student_id'], 'isActive' => '1', 'student_status' => '1', 'result_arr'));
            foreach ($data as $row) {
                echo '<option value="' . $row->student_id . '">' . $row->name . '</option>';
            }
        }
    }

    function test_test(){
        $daysArr = ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];
        pre(count($daysArr));
    }
    
    //Student Certificate list
    function teacher_certificate_list($teacher_id=''){
         if ($this->session->userdata('school_admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model('Teacher_model');
        $this->load->model('Teacher_certificate_model');
        $condition = array('teacher_id' => $teacher_id);
        $dataArr = array('certificate_id' => 'desc');
        $page_data['certificate_list'] = $this->Teacher_certificate_model->get_data_by_cols('*', $condition, 'result_type', $dataArr);
        $page_data['teachers'] = $this->Teacher_model->get_teacher_array(); 
        $page_data['teacher_id'] = $teacher_id;
        $page_data['page_name'] = 'teacher_certificate_list';
        $page_data['page_title'] = get_phrase('Teacher_certificate_list');
        $this->load->view('backend/index', $page_data);
    }
    
    function report_chart(){
          if ($this->session->userdata('school_admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'report_chart';
        $page_data['page_title'] = get_phrase('report_chart');
        $this->load->view('backend/index', $page_data);
    }
        
    function teacher_documents($param1 = '') {
        if ($this->session->userdata('school_admin_login') != 1)
            redirect(base_url(), 'refresh');
                $id = $this->uri->segment(3);
                $this->load->model('S3_model');
                $page_data = $this->get_page_data_var();
                $page_data['files'] = $this->S3_model->get_all_files();

                $instance = $this->Crud_model->get_instance_name();
                $page_data['subfiles'] = $this->S3_model->get_file($page_data['files'][1], $instance . '/teacher/' . $param1 . '/');
                $page_data['instance'] = $instance . '/teacher/' . $param1 . '/';
                $page_data['teacher_id'] = $param1;
                $page_data['page_title'] = get_phrase('teacher_documents');
                $page_data['page_name'] = 'teacher_documents';
                $this->load->view('backend/index', $page_data);
}

 function teacher_document_upload($param1 = '') {
    $this->load->model('S3_model');
    //$student_id=$param1;

    $config['upload_path'] = './uploads/';
    $config['allowed_types'] = 'pdf|docx|doc|txt|jpg|jpeg|png';
    $config['max_size'] = 100000;
    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    if (!$this->upload->do_upload('userfile')) {

        $this->session->set_flashdata('flash_message_error', $this->upload->display_errors());
        redirect(base_url() . 'index.php?school_admin/teacher_documents/' . $param1, 'refresh');
    } else {
        $data = $this->upload->data();
        // $this->Crud_model->get_instance();

        $instance = $this->Crud_model->get_instance_name();
        $filepath = $instance . '/teacher/' . $param1 . '/' . $data['file_name'];
        // pre($this->upload->data());
        //$this->load->view('upload_success', $data);
        $this->S3_model->upload($this->upload->data()['full_path'], $filepath);
        //exit;
        $this->session->set_flashdata('flash_message', get_phrase('document_uploaded_successfully'));
        redirect(base_url() . 'index.php?school_admin/teacher_documents/' . $param1, 'refresh');
    }

    //$file=$this->input->post();
    //pre($file);
    //$this->session->set_flashdata('flash_message', get_phrase('document_uploaded_successfully'));
    //redirect(base_url() . 'index.php?school_admin/documents/'.$param1, 'refresh');     
}

    function teacher_delete_document($param1 = '', $param2 = '', $param3 = '', $param4 = '') {
    $this->load->helper('download');
    //$data =  file_get_contents('uploads/parent_bulk_upload_error_details_for_excel_file.xlsx');
    //$name = 'parent_bulk_upload_error_details_for_excel_file.xlsx';
    //$name = 'parent_bulk_upload_error_details_for_excel_file.xlsx';
    $param4 = str_replace('%20', ' ', $param4);
    $file_path = implode('/', array($param1, $param2, $param3, $param4));
//    echo $file_path; die;
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->model('S3_model');
    $list = explode('/', $param1);

    $file_path = $this->S3_model->delfile($file_path);
    $this->session->set_flashdata('flash_message', get_phrase('document_deleted_successfully'));
    redirect(base_url() . 'index.php?school_admin/teacher_documents/' . $param3, 'refresh');
}


function student_bulk_photo_upload(){
    if ($this->session->userdata('school_admin_login') != 1)
            redirect(base_url(), 'refresh');
    
    $master_img_directory="uploads/master_student_images/";
    $this->load->helper('general_used');
    $path = "uploads/student_photo_update.xlsx";
    //@unlink('uploads/subject_import.xlsx');
    @unlink($path);
    @unlink('uploads/_error_details.log');

    if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $path)) {
        die('not moving');
    }
    @ini_set('memory_limit', '-1');
    @set_time_limit(0);
    include 'Simplexlsx.class.php';
    $xlsx = new SimpleXLSX($path);
    list($num_cols, $num_rows) = $xlsx->dimension();
    $f = 0;
    $fielsdStringForAdmin = "Student Index,Student Name,Student Class Name,Student Section Name,Photo File Name";
    $fielsdString = "student_id,name,name,name,stud_image";
    $fielsdStringMandotary = "student_id";
    $skipFielsdString="name,name,name";
    $fielsdArr = explode(',', $fielsdString);
    $fielsdStringForAdminArr = explode(',', $fielsdStringForAdmin);
    $fielsdStringMandotaryArr = explode(',', $fielsdStringMandotary);
    $skipFielsdStringArr = explode(',', $skipFielsdString);
    $someRowError = FALSE;
    $errorMsgArr = array();
    $errorExcelArr = array();
    $errorExcelArr[] = $fielsdStringForAdminArr;
    $errorRowNo = 2;
    //pre($xlsx->rows());die;
    foreach ($xlsx->rows() as $r) {
        //echo '<pre>'; //print_r($r);die;
        $data = array();
        $dataParent = array();
        $error = FALSE;
        // Ignore the inital name row of excel file
        if ($f == 0) {
            $f++;
            continue;
        } $f++;
        //pre($fielsdStringForAdminArr);
        //pre($r); //die('here');
        //pre($r);
        //pre('above are $r data');
        //if ($num_cols > count($fielsdArr)) {
        $num_cols = count($fielsdArr);
        //die($num_cols);
        //}
        $blankErrorMsgArr = array();
        $errorRowIncrease = FALSE;

        //echo $num_cols;die;
        for ($i = 0; $i < $num_cols; $i++) {    // checking is filds is mandetory or not
            //echo $fielsdArr[$i] . '<br>';
            if(in_array($fielsdArr[$i], $skipFielsdStringArr)){
                //pre("skip : ".$fielsdArr[$i]);
                continue;
            }
            if (in_array($fielsdArr[$i], $fielsdStringMandotaryArr)) {
                
                //now validating mandetory fiels
                //generate_log("Field " . $fielsdArr[$i] . " value \n", 'grade_bulk_upload_' . date('d-m-Y-H') . '.log');
                //echo $r[$i].'<br>';
                if (trim($r[$i]) == "") {
                    //echo "here"; //die();
                    $error = TRUE;
                    $blankErrorMsgArr[] = $fielsdStringForAdminArr[$i] . " should not be blank at row no " . $errorRowNo;
                } else {
                    //pre($i);
                }
                
                //pre(trim($fielsdArr[$i]));pre('$error');pre($error);
            } else {
                //pre($errorMsgArr);//die;
                //pre(trim($fielsdArr[$i]));pre('$error');pre($error);
            }
            $data[$fielsdArr[$i]] = trim($r[$i]);
        }
        //die;
        if (count($blankErrorMsgArr) > 0) {
            $error = TRUE;
            if (count($blankErrorMsgArr) <= count($fielsdArr)) {
                foreach ($blankErrorMsgArr AS $errorKey => $errorVal) {
                    $errorMsgArr[] = $errorVal;
                }
            }
        }
        $stud_img = explode(".", $data['stud_image']);
        if($stud_img[0]!=$data['student_id'] && $stud_img[0]!=""){
            //pre($stud_img[0]);
            //pre($data['student_id']);
            $errorMsgArr[]="Student image file name [".$data['stud_image']."] entered with student index are not matched.";
            $error = TRUE;
            //die("ZZZZ");
        }
        
        if(!file_exists($master_img_directory.$data['stud_image'])){
            $errorMsgArr[]="Student image file name [".$data['stud_image']."] entered  in the excel file not upload to master directory in the server.";
            $error = TRUE;
        }else{
            @unlink('uploads/student_image/' . $data['stud_image']);
            @unlink('fi/sysfrm/uploads/user-pics/' . $data['stud_image']);
            @copy($master_img_directory.$data['stud_image'], 'uploads/student_image/' . $data['stud_image']);
            @copy($master_img_directory.$data['stud_image'], 'fi/sysfrm/uploads/user-pics/' . $data['stud_image']);
        }
        
        
        //pre('$error');pre($error); //die();
        if ($error === FALSE) {
            //pre($data);die;
            $this->Student_model->update_student(array('stud_image'=>$data['stud_image']),array('student_id'=>$data['student_id']));
        } else {
            //pre($errorMsgArr);//die;
            $errorRowNo++;
            $errorExcelArr[] = $r;
            $someRowError = TRUE;
        }
    } //ends foreach
    //pre($errorMsgArr); exit;

    if ($someRowError == FALSE) {
        //$this->generate_cv$error_msg);
        generate_log("No error for this upload at - " . time(), 'student_photo_upload' . date('d-m-Y-H') . '.log');
        $this->session->set_flashdata('flash_message', get_phrase('student_photo_update_successfully'));
        redirect(base_url() . 'index.php?school_admin/bulk_upload/', 'refresh');
    } else {
        //pre($errorMsgArr); die('here');
        generate_log(json_encode($errorMsgArr), 'student_bulk_photo_upload_error_details.log', TRUE);
        $file_name_with_path = 'uploads/student_bulk_photo_upload_error_details_for_excel_file.xlsx';
        @unlink($file_name_with_path);
        create_excel_file($file_name_with_path, $errorExcelArr, 'student_bulk_photo_upload');
        $this->session->set_flashdata('flash_message_error', "Some rows are not uploaded,due to invalid data.");
        redirect(base_url() . 'index.php?school_admin/student_bulk_photo_upload_error', 'refresh');
    } 
}

function student_bulk_photo_upload_error() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_title'] = get_phrase('student_bulk_photo_error');
    $page_data['page_name'] = 'student_bulk_photo_error';
    $this->load->view('backend/index', $page_data);
}

function student_display_bulk_photo_upload_errors() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $error = TRUE;
    if ($error) {
        $file_name = 'uploads/student_bulk_photo_upload_error_details.log';
        $error_messages = file_get_contents($file_name);
        $messages = json_decode($error_messages);
    }
    $page_data = $this->get_page_data_var();
    $page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['messages'] = $messages;
    $page_data['page_title'] = get_phrase('student_display_bulk_photo_upload_errors');
    $page_data['page_name'] = 'student_display_bulk_photo_upload_errors';
    $this->load->view('backend/index', $page_data);
}

function download_student_bulk_photo_upload_error_file() {
    if ($this->session->userdata('school_admin_login') != 1)
        redirect(base_url(), 'refresh');
    $this->load->helper('download');
    $data = file_get_contents('uploads/student_bulk_photo_upload_error_details_for_excel_file.xlsx');
    //$name = 'grade_bulk_upload_error_details_for_excel_file.xlsx';
    $name = 'student_bulk_photo_upload_error_details_for_excel_file.xlsx';
    force_download($name, $data);
}

    function doctors($param1 = '', $param2 = '', $param3 = ''){
        if ($this->session->userdata('school_admin_login') != 1)
            redirect('login', 'refresh');
        
        $this->load->model('Doctor_model');
        if($param1 == 'create'){
//         pre($this->input->post()); die;
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email Address', 'xss_clean|trim|required|valid_email|is_unique[doctors.email]');
            $this->form_validation->set_rules('phone_no', 'Phone Number', 'required|regex_match[/^[0-9]{10}$/]');
            $this->form_validation->set_rules('address', 'Address', 'required');
            $this->form_validation->set_rules('year_of_exp', 'Year of Experience', 'required');
            $this->form_validation->set_rules('specialization', 'Specialization', 'required');
            $this->form_validation->set_rules('department', 'Department', 'required');
         if ($this->form_validation->run() == TRUE) {
                 $data['name'] = $this->input->post('name');
                 $data['email'] = $this->input->post('email');
                 $passcode = create_passcode('doctor');
                 $data['passcode'] = ($passcode != 'invalid') ? $passcode : '';
                 $data['password'] = ($passcode != 'invalid') ? sha1($passcode) : '';                 
                 $data['phone_no'] = $this->input->post('phone_no');
                 $data['address'] = $this->input->post('address');
                 $data['year_of_exp'] = $this->input->post('year_of_exp');
                 $data['specialization'] = $this->input->post('specialization');
                 $data['department'] = $this->input->post('department');
                 $data['qualification'] = $this->input->post('qualification');
                 $data['education_background'] = $this->input->post('education_background');
                 $data['before_place_work'] = $this->input->post('before_place_work');
                 $data['achivement_award'] = $this->input->post('achivement_award');

         if ($data['phone_no'] != "") {
//             echo $data['phone_no']; die;
                 $name = ucfirst($data['name']);
                 $msg = "Welcome! ".$name." in Sharad School. You are Registered Successfully with Login email:".$data['email']." and Password:" . $passcode;
                 $phone = $data['phone_no'];
                 $message = array();
                 $message_body = $msg;
                 $message['sms_message'] = $msg;
                 $message['subject'] = 'New Registartion ' . $this->globalSettingsSystemName;
                 $message['messagge_body'] = $message_body;
                 $message['to_name'] = $name;
                 send_school_notification('new_user', $message, array($phone), array($data['email']));
         } 
                 $this->Doctor_model->add($data);
                 $this->session->set_flashdata("flash_message", get_phrase("data_added_successfully"));
                 redirect(base_url() . 'index.php?school_admin/doctors/', 'refresh');
         } else{
                 $this->session->set_flashdata('flash_validation_error', validation_errors());
                 redirect(base_url() . 'index.php?school_admin/doctors/', 'refresh');
         }
 }
        if($param1 == 'edit'){
                       $data['name'] = $this->input->post('name');
                       $data['email'] = $this->input->post('email');
                       $data['phone_no'] = $this->input->post('phone_number');
                       $data['address'] = $this->input->post('address');
                       $data['year_of_exp'] = $this->input->post('year_of_exp');
                       $data['specialization'] = $this->input->post('specialization');
                       $data['department'] = $this->input->post('department');
                       $data['qualification'] = $this->input->post('qualification');
                       $data['education_background'] = $this->input->post('education_background');
                       $data['before_place_work'] = $this->input->post('before_place_work');
                       $data['achivement_award'] = $this->input->post('achivement_award');
      //                    pre($data); die;
                       $this->Doctor_model->update_doctor($data, array("doctor_id" => $param2));
                       $this->session->set_flashdata("flash_message", get_phrase("updated_successfully"));
                       redirect(base_url() . 'index.php?school_admin/doctors/', 'refresh');
        }
        if($param1 == 'delete'){
                       $data['isActive'] = '0';
                       $this->Doctor_model->update_doctor($data, array("doctor_id" => $param2));
//                       $this->Doctor_model->delete_doctor($param2);
                       $this->session->set_flashdata("flash_message", get_phrase("deleted_successfully"));
                       redirect(base_url() . 'index.php?school_admin/doctors/', 'refresh');
        }
        if($param1 == 'status_change'){
                       if($param3==1){
                           $status = "0";
                           $msg = "Disable";
                       }
                       else{
                           $status = "1";
                           $msg = "Enable";
                       }
      //                 echo $status; die;
                       $data['status'] = $status;
                       $this->Doctor_model->update_status($data, array("doctor_id" => $param2));
                       $this->session->set_flashdata("flash_message", get_phrase($msg."_successfully"));
                       redirect(base_url() . 'index.php?school_admin/doctors/', 'refresh');
        }
            $page_data = $this->get_page_data_var();  
            $page_data['doctor_list'] =   $this->Doctor_model->get_doctor_array(array("isActive" => '1'));   
            $page_data['page_name'] = 'doctors';
            $page_data['page_title'] = get_phrase('doctor_list');
            $page_data['total_notif_num'] = $this->get_no_of_notication();
            $this->load->view('backend/index', $page_data);    
    }
    
    function restor_google_backup(){
        if ($this->session->userdata('school_admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        //$page_data['messages'] = $messages;
        $page_data['page_title'] = get_phrase('restore_google_backup');
        $page_data['page_name'] = 'restor_google_backup';
        $this->load->view('backend/index', $page_data);
    }
    
    function restor_google_backup_action(){
        if ($this->session->userdata('school_admin_login') != 1)
            redirect(base_url(), 'refresh');
        $this->load->library('upload');
        $config['upload_path'] = './uploads/restore_google_back_sql/';
        $config['file_name'] = 'google_drive_restore_sqldump.sql';
        $config['overwrite'] = TRUE;
        $config['allowed_types'] = '*';
        //$config['remove_spaces'] = FALSE;
        @unlink($config['upload_path'].$config['file_name']);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('userfile')) {
            $data =$this->upload->data();
            if(strtolower($data['file_ext'])!='.sql'){
                @unlink($data['full_path']);
                $this->session->set_flashdata('flash_message_error', "Only sql dump file allow for restore.");
            }else{
                $RootDBUserPassword="";
                if(CURRENT_INSTANCE=='beta_ag'){
                    $dbName='beta_ag_test';
                }else{
                    $dbName=CURRENT_INSTANCE;
                }
                $shell_exec_command='/var/www/html/google_drive_backup_restore.sh '.$RootDBUserPassword.' '.$dbName.' '.$data['full_path'].' 2>&1 | tee -a /tmp/google_drive_backup_restore_log 2>/dev/null >/dev/null &';
                generate_log('Going to fire command for shell :::'.$shell_exec_command,'google_drive_restore_log_'.date('Y_m_d').'.log');
                $error_msg= shell_exec('sudo '.$shell_exec_command);
                generate_log('getting output from shell_exec() ::: '+$error_msg,'google_drive_restore_log_'.date('Y_m_d').'.log');
                sleep(200);
                $content    =   preg_replace('/\s+/','',trim(file_get_contents('/tmp/google_drive_backup_restore_log')));
                $content    =   preg_replace('/\t/','',$content);
                $content    =   preg_replace('~[\r\n]+~', '', $content);
                if($content=='Warning:Usingapasswordonthecommandlineinterfacecanbeinsecure.Warning:Usingapasswordonthecommandlineinterfacecanbeinsecure.'){
                    $this->session->set_flashdata('flash_message_error','Backup restored successfully');
                }else{
                    $this->session->set_flashdata('flash_message_error',"There is some error while restoring your backup,Please contact support@rarome.com.");
                }
            }
        }else{
            $this->session->set_flashdata('flash_message_error', $this->upload->display_errors());
        }
        redirect(base_url().'index.php?school_admin/database_data_backup_list');
    }

    /************************Fee Particulars*******************************/
    function photo_galleries(){
       if ($this->session->userdata('school_admin_login') != 1)
           redirect(base_url(), 'refresh');

       $this->load->model('Gallery_model');    
       $page_data = $this->get_page_data_var();
       if($this->input->server('REQUEST_METHOD')=='POST'){
           $this->form_validation->set_rules('title', 'Gallery Title', 'trim|required|_unique_field_sch[photo_galleries.title#running_year.'._getYear().']');
           $this->form_validation->set_rules('description', 'Gallery Description', 'trim');
           $this->form_validation->set_error_delimiters('', '');

           if ($this->form_validation->run() == TRUE) {
               $save_data['class_id'] = $this->input->post('class_id');
               $save_data['title'] = $this->input->post('title');
               $save_data['description'] = $this->input->post('description');
               $save_data['running_year'] = _getYear();
               $save_data['school_id'] = _getSchoolid();
               $save_data['created'] = date('Y-m-d H:i:s');
               $save_data['updated'] = date('Y-m-d H:i:s');
               $return = $this->Gallery_model->save_gallery($save_data);

               if($return){
                   $this->session->set_flashdata('flash_message', get_phrase('photo_gallery_successfully_created.'));
                   redirect(base_url() . 'index.php?school_admin/photo_galleries/', 'refresh');
               } else {
                   $this->session->set_flashdata('flash_message_error', get_phrase('invalid_details.'));
               }
           }else{
               $this->session->set_flashdata('flash_message_error', validation_errors());
           }
       } 

       $page_data['page_name'] = 'gallery/photo_galleries';
       $page_data['page_title'] = get_phrase('photo_galleries');
       $page_data['records'] = $this->Gallery_model->get_galleries();
       $page_data['classes'] = $this->Gallery_model->get_classes();
       //echo '<pre>';print_r($page_data['records'] );exit;
       $this->load->view('backend/index', $page_data);
   }
    

    function photo_gallery_edit($id=false){
        if ($this->session->userdata('school_admin_login') != 1)
            redirect(base_url(), 'refresh');

        $this->load->model('Gallery_model');    
        $page_data = $this->get_page_data_var();
        $page_data['record'] = $rec = $this->Gallery_model->get_gallery_record($id);
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $is_unique_title = strtolower($_POST['title'])==strtolower($rec->title)?'':'|_unique_field_sch[photo_galleries.title#running_year.'._getYear().']';
            $this->form_validation->set_rules('title', 'Gallery Title', 'trim|required'.$is_unique_title);
            $this->form_validation->set_rules('description', 'Gallery Description', 'trim');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() !== FALSE) {
                $save_data['id'] = $id;
                $save_data['class_id'] = $this->input->post('class_id');
                $save_data['title'] = $this->input->post('title');
                $save_data['description'] = $this->input->post('description');
                $save_data['updated'] = date('Y-m-d H:i:s');
                $return = $this->Gallery_model->save_gallery($save_data);
                    
                if($return){
                    $this->session->set_flashdata('flash_message', get_phrase('photo_gallery_successfully_updated.'));
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('invalid_details.'));
                }
            }else {
                $this->session->set_flashdata('flash_message_error', validation_errors());
            }
            redirect(base_url() . 'index.php?school_admin/photo_galleries/', 'refresh');
        } 
        $page_data['classes'] = $this->Gallery_model->get_classes();
        $this->load->view('backend/school_admin/gallery/modal_edit_gallery',$page_data);
    }

    function photo_gallery_delete($id=false){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->load->model('Gallery_model');    
            $this->Gallery_model->gallery_delete(array('id'=>$id));
            echo json_encode(array('status'=>'success','msg'=>'Photo Gallery Deleted!'));exit;
        }
    }

    //Gallery Images
    function photo_gallery_images($gallery_id=false){
        if ($this->session->userdata('school_admin_login') != 1)
            redirect(base_url(), 'refresh');

        $this->load->model(array('Gallery_model','S3_model'));
        $page_data = $this->get_page_data_var();
        $instance = $this->Crud_model->get_instance_name();
        $page_data['bucket'] = $bucket = 'https://'.S3_model::$bucket.'.s3.amazonaws.com/';
        $page_data['gallery'] = $rec = $this->Gallery_model->get_gallery_record($gallery_id);
        if($this->input->server('REQUEST_METHOD')=='POST'){
            //echo '<pre>';print_r($_FILES);exit; 
            $gallery_path = 'gallery/'.$instance.'/'.$gallery_id.'/';

            $post_images = $_FILES['images'];
            foreach($post_images['tmp_name'] as $i=>$img){
                $imgSize = getimagesize($img);
                $file = $post_images['name'][$i];
                $file_name = substr($file,0,strrpos($file, '.'));
                $img_ext = pathinfo($file, PATHINFO_EXTENSION);
                $img_nw = rand(1000,99999999999999999).time();
                
                //Original
                $m_img_path = $img_nw.'-M.'.$img_ext;
                $s3_m_path = $gallery_path.$m_img_path;
                $this->S3_model->upload($img,$s3_m_path);

                //Resized Image
                $s_img_path = $img_nw.'-S.'.$img_ext;
                $target_path = APPPATH.'../uploads/'.$s_img_path;
                //unlink($target_path);
                
                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = $img;
                $config['new_image'] = $target_path;
                //$config['create_thumb'] = TRUE;
                $config['maintain_ratio'] = TRUE;
                $config['width']         = 300;
                $config['height']       = 300;
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $s3_s_path = $gallery_path.$s_img_path;
                $this->S3_model->upload($target_path,$s3_s_path);
                unlink($target_path);

                $save_img = array('gallery_id'=>$gallery_id,
                                  'title'=>$file_name,
                                  'bucket'=>$bucket,
                                  'thumb'=>$s3_s_path,
                                  'main'=>$s3_m_path,
                                  'size'=>($imgSize[0].'x'.$imgSize[1]),
                                  'created'=>date('Y-m-d H:i:s'),
                                  'updated'=>date('Y-m-d H:i:s'));
                $this->Gallery_model->save_gallery_image($save_img);
            }

            $this->session->set_flashdata('flash_message', get_phrase('image_uploaded_successfully'));
            redirect('index.php?school_admin/photo_gallery_images/'.$gallery_id, 'refresh');
        }  
        $page_data['page_name'] = 'gallery/images';
        $page_data['page_title'] = get_phrase('photo_galleries_images');
        //$page_data['objects'] = $this->S3_model->get_objects('gallery/'.$instance.'/'.$gallery_id);
        $page_data['images'] = $this->Gallery_model->get_gallery_images(array('gallery_id'=>$gallery_id));  
        //echo '<pre>';print_r($page_data['objects']);exit;
        $this->load->view('backend/index', $page_data);
    }    

    function gallery_img_edit($img_id=false){
        if ($this->session->userdata('school_admin_login') != 1)
            redirect(base_url(), 'refresh');

        $this->load->model(array('Gallery_model','S3_model'));
        $page_data = $this->get_page_data_var();
        $instance = $this->Crud_model->get_instance_name();
        $page_data['bucket'] = $bucket = 'https://'.S3_model::$bucket.'.s3.amazonaws.com/';
        $page_data['img'] = $this->Gallery_model->get_gallery_img(array('PI.id'=>$img_id)); 
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $save_data['id'] = $img_id;
            $save_data['title'] = $this->input->post('title');
            $save_data['brief'] = $this->input->post('brief');
            $save_data['updated'] = date('Y-m-d H:i:s');
            $return = $this->Gallery_model->save_gallery_image($save_data);

            $this->session->set_flashdata('flash_message', get_phrase('image_updated_successfully'));
            redirect('index.php?school_admin/photo_gallery_images/'.$page_data['img']->gallery_id, 'refresh');
        } 
        $page_data['page_name'] = 'gallery/gallery_img_edit';
        $page_data['page_title'] = get_phrase('photo_galleries_images'); 
        $whr = array();
        if($page_data['img']->class_id!=0){
            $whr['E.class_id'] = $page_data['img']->class_id;
        }
        $page_data['students'] = $this->Gallery_model->get_students($whr);
        //echo '<pre>';print_r($page_data['objects']);exit;
        $this->load->view('backend/index', $page_data);
    }    

    function get_users_by_user_type(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->load->model(array('Gallery_model'));
            $return = array('status'=>'success','html'=>'');
            $type = $this->input->post('type');
            $class_id = $this->input->post('class_id');
            if($type==1){
                $whr = array();
                if($class_id!=0){
                    $whr['E.class_id'] = $class_id;
                }
                $records = $this->Gallery_model->get_students($whr);
                $return['html'] = '<option value="">Select Student</option>';
                foreach($records as $rec){
                    $return['html'] .= '<option value="'.$rec->student_id.'">'.$rec->name.' '.$rec->lname.'</option>';
                }
            }else if($type==2){
                $records = $this->Gallery_model->get_teachers();
                $return['html'] = '<option value="">Select Teacher</option>';
                foreach($records as $rec){
                    $return['html'] .= '<option value="'.$rec->teacher_id.'">'.$rec->name.' '.$rec->last_name.'</option>';
                }
            }else if($type==3){
                $records = $this->Gallery_model->get_parents();
                $return['html'] = '<option value="">Select Parent</option>';
                foreach($records as $rec){
                    $return['html'] .= '<option value="'.$rec->parent_id.'">'.$rec->father_name.' '.$rec->father_lname.'</option>';
                }
            }else if($type==4){
                $records = $this->Gallery_model->get_parents();
                $return['html'] = '<option value="">Select Parent</option>';
                foreach($records as $rec){
                    $return['html'] .= '<option value="'.$rec->parent_id.'">'.$rec->mother_name.' '.$rec->mother_lname.'</option>';
                }
            }
            echo json_encode($return);exit;
        }
    }
    
    function gallery_img_delete($img_id=false){
        if ($this->session->userdata('school_admin_login') != 1)
            redirect(base_url(), 'refresh');

        $this->load->model(array('Gallery_model','S3_model')); 
        $img = $this->Gallery_model->delete_gallery_img($img_id);
        echo json_encode(array('status'=>'success','msg'=>get_phrase('image_deleted!')));exit;  
        //redirect(base_url('index.php?school_admin/photo_gallery_images/'.$img->gallery_id), 'refresh');
    }

    function passport_expiry_reminder(){
        $running_year = $this->globalSettingsRunningYear;
        $student = $this->Student_model->passport_expiry_reminder($running_year);
        foreach($student as $row):
             $name = ucfirst($row['name']);
                 $msg = "Hi ". $name." your Passport(".$row['passport_no'].") is about to expire on ".$row['passport_expiry_date']." . Please renew it before time.";
                 $phone = $row['phone'];
                 $message = array();
                 $message_body = $msg;
                 $message['sms_message'] = $msg;
                 $message['subject'] = 'Renew Passsport ' . $this->globalSettingsSystemName;
                 $message['messagge_body'] = $message_body;
                 $message['to_name'] = $name;
                 send_school_notification('new_user', $message, array($phone), array($row['email']));
        endforeach;
    }
    
    function visa_expiry_reminder(){
        $running_year = $this->globalSettingsRunningYear;
        $student = $this->Student_model->visa_expiry_reminder($running_year);
        foreach($student as $row):
             $name = ucfirst($row['name']);
                 $msg = "Hi ". $name." your Visa(".$row['visa_no'].") is about to expire on ".$row['visa_expiry_date']." . Please renew it before time.";
                 $phone = $row['phone'];
                 $message = array();
                 $message_body = $msg;
                 $message['sms_message'] = $msg;
                 $message['subject'] = 'Renew Visa ' . $this->globalSettingsSystemName;
                 $message['messagge_body'] = $message_body;
                 $message['to_name'] = $name;
                 send_school_notification('new_user', $message, array($phone), array($row['email']));
        endforeach;
    }
}
// --------------------------------------------------------------------------
/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */


    