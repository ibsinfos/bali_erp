<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller {

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
        $this->load->library('Fi_functions');
        $this->load->model("Class_routine_model");
        $this->load->model("Section_model");
        $this->load->model("Notice_board_model");
        $this->load->model("Attendance_model");
        $this->load->model('Dormitory_model');
        $this->load->model("Evaluation_model");
        $this->load->model("Enroll_model");
        $this->load->model('Cce_model');
        $this->load->model('Subject_model');
        $this->load->model('School_model');
        $this->load->model('School_Admin_model');

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

        $this->globalSettingsActiveSms = $this->globalSettingsActiveSmsService; //$this->Setting_model->get_setting_record(array('type' => 'active_sms_service'), 'description');

        $this->session->set_userdata(array(
            'running_year' => $this->globalSettingsRunningYear,
        ));
    }

    /*     * *default functin, redirects to login page if no admin logged in yet** */
    
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
 
           
            $parent_id = $this->Parent_model->save_parent($data);
            if ($parent_id) {
          
            } else {
                echo "Unbale to insert guardian details!!";
            }
            $this->session->set_flashdata('flash_message', get_phrase('parent_details_added_successfully'));


            //$this->Email_model->account_opening_email('parent', $data['email'], $this->input->post('password')); //SEND EMAIL ACCOUNT OPENING EMAIL
            redirect(base_url() . 'index.php?school_admin/parent/', 'refresh');
        } else {
            $page_data['msg'] = validation_errors();
            $page_data['page_title'] = get_phrase('add_parent_details');
            $page_data['page_name'] = 'parent_add_new';
            $arr = array();
            $form_id = 2;
            $arr = $this->set_dynamic_form($form_id);
            foreach ($arr as $key => $value) {
                $page_data[$key] = $value;
            }
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
    public function index() {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($this->session->userdata('admin_login') == 1)
            redirect(base_url() . 'index.php?admin/dashboard', 'refresh');
    }

    /*     * *ADMIN DASHBOARD** */
    
    function dashboard() {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();

        $page_data['page_name'] = 'dashboard';
        $page_data['page_title'] = get_phrase('admin_dashboard');
        $this->load->model("Attendance_model");
        $this->load->model("Invoice_model");
        $this->load->model("Holiday_model");
        
        $page_data['new_admissions'] = $this->Student_model->count_new_admissions($page_data['running_year']);
        $page_data['total_students'] = $this->Student_model->count_total_students();
        $page_data['total_present_students'] = $this->Attendance_model->get_present_students();
        $page_data['total_absent_students'] = $this->Attendance_model->get_absent_students();
        $page_data['total_scholarship_students'] = $this->Invoice_model->count_scholarship_students();
        $page_data['total_teachers'] = $this->Teacher_model->count_all_teachers();
        $page_data['school_data'] = $this->School_model->getAllSchoolsData();
        $page_data['holidays'] = $this->Holiday_model->get_all_holidays($page_data['school_data'][0]['school_id']);

        $this->load->model("Admission_settings_model");
        $page_data['arrAllLinks'] = $this->session->userdata('arrAllLinks');
        $this->save_report_link();
        $this->load->view('backend/index', $page_data);
    }

    function dashboard_old() {
        //echo '<pre>';print_r($this->session->all_userdata());exit;
        error_reporting(E_ALL);
        if ($this->session->userdata('admin_login') != 1)
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

        $page_data['tot_students'] = $no_student;

        $check2 = array('timestamp' => strtotime(date('Y-m-d')), 'status' => '1');
        $query2 = $this->Attendance_model->get_data_by_cols('*', $check2, 'result_type');
        $page_data['tot_student_present'] = count($query2);
        //Graphical Attendance Report - Added By Meera - July 1st 2017
        $page_data['currentMonth'] = date('F');

        $page_data['attendance_percentage'] = $this->Attendance_model->get_attendence_class_month($page_data['currentMonth']);
        //        echo '<pre>'; print_r($page_data['attendance_percentage']);die();

        $this->load->model("Holiday_model");
        $page_data['holidays'] = $this->Holiday_model->get_holiday_list($page_data['running_year']);

        $this->load->model("Admission_settings_model");
        // pre($this->session->userdata('arrAllLinks'));
        $page_data['arrAllLinks'] = $this->session->userdata('arrAllLinks');
        $this->save_report_link();
        $this->load->view('backend/index', $page_data);
    }
     function save_report_link()
    {
        $this->load->model("Dynamic_report_model");
        $section_id = 2;
        $result = $this->Dynamic_report_model->getCustomReportLink($section_id);
        $arrLink = array();
        $report_data = $this->Dynamic_report_model->getReportLink("Reports", "A");
        
        foreach($report_data as $report)
            $parent_id = $report['id'];
        
        if(count($result))
        {
            $order = 0;
            foreach($result as $key => $value)
            { 
                $order++;
                $arrLink['link']     =   "admin/admin_custom_report/".$value['id'];
                $arrLink['name']     =   $caption = $value['report_caption'];
                
                $result = $this->Dynamic_report_model->checkCaptionExist($caption);
                $count = count($result);
                
                if($count) // find duplicate
                {
                    
                } 
                else
                {
                    //get school_admin role id
                    $school_id = '';
                    if(isset($_SESSION['school_id']))
                        $school_id = $_SESSION['school_id'];
                    $role_id = 1;
                    $type = "A";
                    $arrLink['user_type']       =   "A";
                    $arrLink['image']           =   "icon-size fa fa-book";
                    $arrLink['orders']          =   $order;
                    $arrLink['parent_id']       =   $parent_id;
                    $arrLink['school_id']       =   $school_id;
                    $this->Dynamic_report_model->dynamicLinkSave($arrLink,$role_id, $type);
                }    
                
            }    
        }    
     }
    
     
    public function add_school($param1='',$param2='') {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data=array();
        $page_data = $this->get_page_data_var();
        $page_data['page_title'] = get_phrase('Add School');
        
        if (@$param1 == 'create'){
            $page_data['page_title'] = get_phrase('Add School');
            $page_data['school_id1']  = $param2;
            $this->form_validation->set_rules('name', 'School Name', 'trim|required');
            $this->form_validation->set_rules('addr1', 'Address Line 1', 'trim|required');
            $this->form_validation->set_rules('addr2', 'Address Line 2', 'trim');
            $this->form_validation->set_rules('mobile', 'Mobile No.', 'trim|required|numeric|max_length[10]');
            $this->form_validation->set_rules('telephone', 'Telephone No.', 'trim|numeric|max_length[10]');
            $this->form_validation->set_rules('pin', 'Pincode', 'trim|required');
//            $this->form_validation->set_rules('fname', 'Employee First Name', 'trim|required');
//            $this->form_validation->set_rules('lname', 'Employee Last Name', 'trim|required');
//            $this->form_validation->set_rules('email', 'Employee Email', 'trim|required|valid_email');
            
            if ($this->form_validation->run() == TRUE) {
                $data['name'] = $this->input->post('name');
                $data['addr_line1'] = $this->input->post('addr1');
                $data['addr_line2'] = $this->input->post('addr2');
                $data['mobile'] = $this->input->post('mobile');
                $data['telephone'] = $this->input->post('telephone');
                $data['pin'] = $this->input->post('pin');
                $edata = $data;
//                $edata['firstname'] = $this->input->post('fname');
//                $edata['lastname'] = $this->input->post('lname');
//                $edata['emailaddress'] = $this->input->post('email');
                
                if ($_FILES['logo']['name'] != '') {
                    $img = $_FILES['logo']['name'];
                    $img = explode(".", $img);
                    $school_image = time() . "." . end($img);
                    move_uploaded_file($_FILES['logo']['tmp_name'], 'uploads/school_images/' . $school_image);
                    copy('uploads/school_images/' . $school_image, 'fi/sysfrm/uploads/school-pics/' . $school_image);
                    $data['logo'] = $school_image;
                }

                $school_id = $this->School_model->save_school($data,$edata);
                
                if($school_id){
                    $this->session->set_flashdata('flash_message', get_phrase('school_information_has_been_saved_successfully.'));
                    redirect(base_url() . 'index.php?admin/add_school/', 'refresh');
                }
            }
        }
        
        else if (@$param1 == 'update' && @$param2 > 0){
            $this->form_validation->set_rules('name', 'School Name', 'trim|required');
            $this->form_validation->set_rules('addr1', 'Address Line 1', 'trim|required');
            $this->form_validation->set_rules('addr2', 'Address Line 2', 'trim');
            $this->form_validation->set_rules('mobile', 'Mobile No.', 'trim|required|numeric|max_length[10]');
            $this->form_validation->set_rules('telephone', 'Telephone No.', 'trim|required|numeric|max_length[10]');
            $this->form_validation->set_rules('pin', 'Pincode', 'trim|required');
            
            if ($this->form_validation->run() == TRUE) {
                $data['name'] = $this->input->post('name');
                $data['addr_line1'] = $this->input->post('addr1');
                $data['addr_line2'] = $this->input->post('addr2');
                $data['mobile'] = $this->input->post('mobile');
                $data['telephone'] = $this->input->post('telephone');
                $data['pin'] = $this->input->post('pin');
                
                if ($_FILES['logo']['name'] != '') {
                    $img = $_FILES['logo']['name'];
                    $img = explode(".", $img);
                    $school_image = time() . "." . end($img);
                    move_uploaded_file($_FILES['logo']['tmp_name'], 'uploads/school_images/' . $school_image);
                    copy('uploads/school_images/' . $school_image, 'fi/sysfrm/uploads/school-pics/' . $school_image);
                    $data['logo'] = $school_image;
                } else {
                    $data['logo'] = $this->input->post('logo_old');
                }

                $upd_status = $this->School_model->update_school($data,$page_data['school_id']);
                
                if($upd_status){
                    $this->session->set_flashdata('flash_message', get_phrase('school_information_has_been_updated_successfully.'));
                    redirect(base_url() . 'index.php?admin/add_school/update/'.$page_data['school_id'], 'refresh');
                }
            }
            $page_data['page_title'] = get_phrase('Update School');
            $page_data['school_id1']  = $param2;
            $page_data['schoolData'] = $this->School_model->getSingleSchoolData($param2);
          
        }
        
        $page_data['page_name']  = 'add_school';
        
        $this->load->view('backend/index', $page_data);
    }    
    
    public function add_school_admin($param1='',$param2='',$param3='') {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data=array();
        $page_data = $this->get_page_data_var();
        $page_data['page_title'] = get_phrase('Add School Admin');
        $page_data['page_name']  = 'add_school_admin';
        $page_data['sc_admin_id']  = '';
        
        if ($param1 == 'create'){
            $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
            $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
            $this->form_validation->set_rules('email', 'Email address', 'trim|required');
            $this->form_validation->set_rules('mobile', 'Mobile No.', 'trim|required|numeric|max_length[10]');
            
            if ($this->form_validation->run() == TRUE) {
                $data['first_name'] = $this->input->post('fname');
                $data['last_name'] = $this->input->post('lname');
                $data['email'] = $this->input->post('email');
                $data['mobile'] = $this->input->post('mobile');
                $data['original_pass']=random_string('alnum','8');
                $data['password'] = sha1($data['original_pass']);
                
                if ($_FILES['profile_pic']['name'] != '') {
                    $img = $_FILES['profile_pic']['name'];
                    $img = explode(".", $img);
                    $admin_image = time() . "." . end($img);
                    move_uploaded_file($_FILES['profile_pic']['tmp_name'], 'uploads/sc_admin_images/' . $admin_image);
                    copy('uploads/sc_admin_images/' . $admin_image, 'fi/sysfrm/uploads/sc_admin_pics/' . $admin_image);
                    $data['profile_pic'] = $admin_image;
                }
                
                $admin_id = $this->School_Admin_model->save_admin($data);
                
                if($admin_id){
                    $sub = "You're now School Admin";
                    $message = "Hello, You are now a School Admin.";
                    //$res = send_emails($data['email'], $sub, $message);

                    $this->session->set_flashdata('flash_message', get_phrase('admin_information_has_been_saved_successfully.'));
                    redirect(base_url() . 'index.php?admin/add_school_admin/', 'refresh');
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('admin_with_this_email_id_already_exist.'));
                }
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('mobile_number_field_should_not_exceed_10_digits.'));
            }
        }
        
        if (@$param1 == 'update' && @$param2 > 0){
            $page_data['page_title'] = get_phrase('Update School Admin');
            $page_data['page_name']  = 'add_school_admin';
            $page_data['sc_admin_id']  = $param2;
            
            $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
            $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
            $this->form_validation->set_rules('email', 'Email address', 'trim|required');
            $this->form_validation->set_rules('mobile', 'Mobile No.', 'trim|required|numeric|max_length[10]');
            
            if ($this->form_validation->run() == TRUE) {
                $data['first_name'] = $this->input->post('fname');
                $data['last_name'] = $this->input->post('lname');
                $data['email'] = $this->input->post('email');
                $data['mobile'] = $this->input->post('mobile');
                
                if ($_FILES['profile_pic']['name'] != '') {
                    $img = $_FILES['profile_pic']['name'];
                    $img = explode(".", $img);
                    $admin_image = time() . "." . end($img);
                    move_uploaded_file($_FILES['profile_pic']['tmp_name'], 'uploads/sc_admin_images/' . $admin_image);
                    copy('uploads/sc_admin_images/' . $admin_image, 'fi/sysfrm/uploads/sc_admin_pics/' . $admin_image);
                    $data['profile_pic'] = $admin_image;
                } else {
                    $data['profile_pic'] = $this->input->post('profile_pic_old');
                } 

                $upd_status = $this->School_Admin_model->update_admin($data,$page_data['sc_admin_id']);

                if($upd_status){
                    $this->session->set_flashdata('flash_message', get_phrase('school_admin_information_has_been_updated_successfully.'));
                    redirect(base_url() . 'index.php?admin/add_school_admin/update/'.$page_data['sc_admin_id'], 'refresh');
                }
            }
            $page_data['adminData'] = $this->School_Admin_model->getSingleAdminData($param2);
        }
        
        $this->load->view('backend/index', $page_data);
    } 
    
    function schools($param1 = '') {
        $this->load->model("School_model");
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
      $page_data = $this->get_page_data_var();
        $page_data['schools'] = $this->School_model->get_school_array();
        $page_data['page_name'] = 'schools';
        $page_data['page_title'] = get_phrase('manage_schools');
        $this->load->view('backend/index', $page_data);
    }
    
    function manage_profile($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
    $this->load->model('Admin_model');
    $page_data = $this->get_page_data_var();
    if ($param1 == 'update_profile_info') {
        $data['name'] = $this->input->post('name');
        $data['email'] = $this->input->post('email');
        $file_name = $_FILES['userfile']['name'];

        $types = array('image/jpeg', 'image/gif', 'image/png');
        if ($file_name != '') {
           
            if (in_array($_FILES['userfile']['type'], $types)) {
                 
                $ext = explode(".", $file_name);
                $user_id = $this->session->userdata('admin_id');
                $data['image'] = $user_id . "." . end($ext);
                if ($this->Admin_model->update_profile($data, $user_id)) {
                    move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/admin_image/' . $data['image']);
                    $this->session->set_flashdata('flash_message', get_phrase('account_details_updated'));
                }
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('It may be the wrong filetype. We only allow JPG, GIF, and PNG filetypes!!'));
                redirect(base_url() . 'index.php?admin/manage_profile/', 'refresh');
            }
        } else {
            $data['image'] = $this->input->post('image');
            $user_id = $this->session->userdata('admin_id');
            $this->Admin_model->update_profile($data, $user_id);
            redirect(base_url() . 'index.php?admin/manage_profile/', 'refresh');
        }
    }

    if ($param1 == 'change_password') {
        $data['password'] = sha1($this->input->post('password'));
        $data['new_password'] = sha1($this->input->post('new_password'));
        $data['confirm_new_password'] = sha1($this->input->post('confirm_new_password')); 
        $current_password = get_data_generic_fun('admin', 'password',array('admin_id' => $this->session->userdata('admin_id')),'result_arr');  
        $curr_pwsd = $current_password[0]['password'];        
       
        if ($curr_pwsd == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {
            $dataArray = array('password' => $data['new_password'], 'passcode' => 'sad'.$this->input->post('new_password'));
            $this->Admin_model->updateadmin_password($dataArray, $this->session->userdata('admin_id'));
            $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('password_mismatch'));
        }
        redirect(base_url() . 'index.php?admin/manage_profile/', 'refresh');
    }
    
    //$page_data['total_notif_num'] = $this->get_no_of_notication();
    $page_data['page_name'] = 'manage_profile';
    
    $page_data['page_title'] = get_phrase('manage_profile');
    
    //exit;
    $page_data['edit_data'] = get_data_generic_fun('admin', '*', array('admin_id' => $this->session->userdata('admin_id')), 'result_arr');
   
    $this->load->view('backend/index', $page_data);
}
    
    function school_admin($param1 = '') {
        $this->load->model("School_Admin_model");
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $page_data['adminArray'] = $this->School_Admin_model->get_admin_array();
        $page_data['page_name'] = 'school_admin';
        $page_data['page_title'] = get_phrase('manage_school_admin');
        $this->load->view('backend/index', $page_data);
    }
    
    public function assign_admin_to_school($param1='') {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data=array();
        $page_data = $this->get_page_data_var();
        $page_data['page_title'] = get_phrase('Assign Admin To School');
        $page_data['page_name']  = 'assign_admin_to_school';
        
        if ($param1 == 'assign'){
            $this->form_validation->set_rules('admin_id', 'Admin Name', 'trim|required');
            $this->form_validation->set_rules('school_id', 'School Name', 'trim|required');
            
            if ($this->form_validation->run() == TRUE) {
                $data['admin_id'] = $this->input->post('admin_id');
                $data['school_id'] = $this->input->post('school_id');
                
                $res = $this->School_Admin_model->assign_school_admin($data);
                
                if($res){
                    $this->session->set_flashdata('flash_message', get_phrase('school_has_been_assigned_to_admin.'));
                    redirect(base_url() . 'index.php?admin/assign_admin_to_school/', 'refresh');
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('admin_is_already_managing_other_school.'));
                    redirect(base_url() . 'index.php?admin/assign_admin_to_school/', 'refresh');
                }
            }
        }
        
        $page_data['adminData'] = $this->School_Admin_model->get_admin_array();
        $page_data['schoolData'] = $this->School_model->get_school_array();
        $page_data['admin_school_data'] = $this->School_Admin_model->get_admin_schools();
        
        $this->load->view('backend/index', $page_data);
    } 
    
    public function delete_school_admin($param1='') {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data=array();
        $page_data = $this->get_page_data_var();
        
        $this->School_Admin_model->delete_school_admin($param1);
        $this->session->set_flashdata('flash_message', get_phrase('Record has been deleted successfully.'));
        redirect(base_url() . 'index.php?admin/assign_admin_to_school/', 'refresh');
        
    }
    
    public function student_attendance_report($school_id="")
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = array();
        $page_data = $this->get_page_data_var();
        $page_data['page_title'] = get_phrase('Student Attendance Report');
        $page_data['page_name'] = 'student_attendance_report';
        $page_data['school_id'] = $school_id;
        $page_data['account_type'] = $this->session->userdata('login_type');
        $school_id = $school_id;//list all schools
        //$class_id = ;//list all classes
        //$section_id =; //List all sections
        $this->load->model("School_model");
        $page_data['schools']   = $this->School_model->get_school_array($school_id);
        $this->load->view('backend/index', $page_data);
    }
    
//    public function student_attendance_report_selector()
//    {
//        if ($this->session->userdata('admin_login') != 1)
//            redirect(base_url(), 'refresh');
//        
//        if (!empty($_POST)) { 
//            $data['school_id'] = $this->input->post('school_id');
//           
//            $data['class_id'] = $this->input->post('class_id');
//            $data['from_date'] = $this->input->post('year');
//            $data['to_date'] = $this->input->post('month');
//            $data['section_id'] = $this->input->post('section_id');
//           
//           
//            $page_data['schools'] = get_data_generic_fun('schools', 'school_id, name', array(), 'result_arr');
//            $page_data['page_name'] = 'student_attendance_report';
//            $page_data['page_title'] = get_phrase('student_attendance_report');
//            //$page_data['total_notif_num'] = $this->get_no_of_notication();
//            $this->load->view('backend/index', $page_data);
//        }
//    }
    function student_attendance_report_view() {
        
        
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
       
        if (!empty($_POST)) 
        { 
          $str_from = '';
          $str_to = '';
          if(!empty($this->input->post('from_date')))
          {     
  
                $date = new DateTime($this->input->post('from_date'));
                echo $date->getTimestamp();
                $str_from = strtotime();
              
              
          }
              if(!empty($this->input->post('to_date')))
              {     
                $date = new DateTime($this->input->post('from_date'));
                $str_to = $date->getTimestamp();  
              }
           $school_id =  $data['c.school_id'] = $page_data['school_id'] = $this->input->post('school_id');
           $page_data['from_date'] = $this->input->post('from_date');
           $page_data['to_date'] = $this->input->post('to_date');
           $class_id  =  $data['c.class_id'] = $page_data['class_id'] = $this->input->post('class_id');
           $data['timestamp'] = $str_from;
           $data['timestamp'] = $str_to;
           $section_id =  $data['e.section_id'] = $page_data['section_id'] = $this->input->post('section_id');
           
        }
        $page_data = $this->get_page_data_var();
        
        $page_data['page_name'] = 'student_attendance_report_view';
        $this->load->model('Student_model');
        $page_data['school_name'] = $this->School_model->get_school_record(array('school_id' => $school_id), "name");
        $page_data['class_name'] = $this->Class_model->get_class_record(array('class_id' => $class_id), "name");
        $page_data['section_name'] = $this->Class_model->get_section_record(array('section_id' => $section_id), "name");
        $page_data['schools'] = get_data_generic_fun('schools', "*", array(), "arrr");
        $page_data['classes'] = get_data_generic_fun('class', "*", array(), "arrr");
        $page_data['sections'] = get_data_generic_fun('section', "*", array('class_id' => $class_id), "arrr");
        

       $data['timestamp'] = strtotime(date("Y-m-d H:i:s"));
       $page_data['res'] = $this->Student_model->get_students_attendance_report($data);
     
        $page_data['page_title'] = get_phrase('attendance_report_of_School') . ' ' . $page_data['school_name'] . ' : '.get_phrase('attendance_report_of_class') . ' ' . $page_data['class_name'] . ' : ' . get_phrase('section') . ' ' . $page_data['section_name'];
            
        
        $this->load->view('backend/index', $page_data);
    }
    
    public function student_scholarship_report($school_id="") {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = array();
        $page_data = $this->get_page_data_var();
        $page_data['page_title'] = get_phrase('Student Scholarship Report');
        $page_data['page_name'] = 'student_scholarship_report';
        $page_data['account_type'] = $this->session->userdata('login_type');
        $school_id = $school_id;//list all schools
        $this->load->model("School_model");
        $page_data['schools']   = $this->School_model->get_school_array($school_id);
        $this->load->view('backend/index', $page_data);
    }
    
     public function student_scholarship_report_selector()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
          $page_data = $this->get_page_data_var();
            $data['school_id'] = trim($this->input->post('school_id'));
            $data['class_id'] = trim($this->input->post('class_id'));
            $data['year'] = trim($this->input->post('year'));
            $data['section_id'] = trim($this->input->post('section_id'));
            $url = base_url() . 'index.php?admin/student_scholarship_report_view';
            if($data['school_id'] != "")
                $url .= '/'.$data['school_id'] ;
            if($data['class_id'] != "")
                $url .= '/'.$data['class_id'] ;
            if($data['section_id'] != "")
                $url .= '/'.$data['section_id'] ;
            redirect($url, 'refresh');

    }
    
    public function student_scholarship_report_view($school_id = '', $class_id = '', $section_id = '', $month = '') {
        
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'student_scholarship_report_view';
        $page_data['page_title'] = 'student_scholarship_report_view';
        $page_data['school_name'] = $this->School_model->get_school_record(array('school_id' => $school_id), "name");
        $page_data['class_name'] = $this->Class_model->get_class_record(array('class_id' => $class_id), "name");
        $page_data['section_name'] = $this->Class_model->get_section_record(array('section_id' => $section_id), "name");
        
        $page_data['class_id'] = $class_id;
        $page_data['section_id'] = $section_id;
        $page_data['month'] = $month;
        $page_data['schools'] = get_data_generic_fun('schools', "*", array(), "arrr");
        $page_data['classes'] = get_data_generic_fun('class', "*", array(), "arrr");
        if($class_id)
            $page_data['sections'] = get_data_generic_fun('section', "*", array('class_id' => $class_id), "arrr");
            
        $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
        $page_data['sholarship_records'] = $this->Student_model->get_scholarship_students($running_year,$school_id,$page_data['class_id'],$page_data['section_id']);
        $page_data['schools_id'] = $school_id;
        $this->load->view('backend/index', $page_data);
    }
    
    function admin_custom_report($id = null)
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
            if(!empty(trim($_POST['school_id'])))
            {    
                $school_id   = $_POST['school_id'];
                $school_name = $this->School_model->get_school_by_name($school_id);
                $where      .= " AND schools.school_id = $school_id";
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
            }
            if(!empty($class_id))
            {    
                
                $where      .= " AND class.class_id = $class_id";
            }
            if(!empty($section_id))
            {    
                
               
                $where      .= " AND section.section_id = $section_id";
            }
            if(!empty($rte))
            {    
                $rte   = $_POST['rte'];
                $where      .= " AND student.rte = '$rte'";
            }
            if(!empty($nationality))
            {    
               
                $where      .= " AND student.nationality = '$nationality'";
            }
            if(!empty($_POST['dormitory_id']))
            {    
                $dormitory   = $_POST['dormitory_id'];
                $where      .= " AND dormitory_id = '$dormitory'";
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
            
            if(!empty($static_condition))
            {
                $where .= " AND $static_condition";
            }    
            $query = str_replace("str_replace", $where, $query);
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
            $page_data['school_name'] =  $school_name;
            $page_data['arrPost'] =     $arrPost;
            $page_data['result'] =      $result;
            $page_data['arrCaption'] =  $arrCaption;
        }
        else
        {
            $where      = " 1 = 1 ";
            if(!empty($static_condition))
            {
                $where .= " AND $static_condition";
            }
            $query = str_replace("str_replace", $where, $query);
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
                              $field['field_where'] = " 1 = 1";
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
            $page_data['page_name']     =               'admin_custom_report';
            $this->load->view('backend/index', $page_data);
        }
    }
    public function student_gender_report(){
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = array();
        $page_data = $this->get_page_data_var();
        $page_data['page_title'] = get_phrase('Student Gender Report');
        $page_data['page_name'] = 'student_gender_report';
        $schools = $this->School_model->get_school_array();
        
        $page_data['schools']   = $this->School_model->get_school_array();
        $page_data['account_type'] = $this->session->userdata('login_type');
        $page_data['schools_id'] = '';
        $this->student_main_reports($page_data['page_name']);
        $this->load->view('backend/index', $page_data);
            
    }
    
    public function student_fee_due_report(){
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = array();
        $page_data = $this->get_page_data_var();
        $page_data['page_title'] = get_phrase('Student Fee Due Report');
        $page_data['page_name'] = 'student_fee_due_report';
        $page_data['schools']   = $this->School_model->get_school_array();
        $page_data['account_type'] = $this->session->userdata('login_type');
        $class_id = '';
        $section_id = '';
        if(!empty($_POST))
        {  
            $this->form_validation->set_rules('school_id','School', 'required');
            $this->form_validation->set_rules('class_id', 'Class', 'required');
            $this->form_validation->set_rules('section_id','Section','required');
            if ($this->form_validation->run() == TRUE) {  
                $data['s.school_id'] = $this->input->post('school_id');
               $section_id =  $data['sec.section_id'] = $this->input->post('section_id'); 
               $class_id =  $data['e.class_id'] = $this->input->post('class_id');
                $data['e.year'] = $this->input->post('year');
                $page_data['classes']   = $this->Class_model->get_data_generic_fun('*',array('school_id'=>$data['s.school_id']),'result_arr');
                $page_data['sections'] = get_data_generic_fun('section', "*", array('class_id' => $data['e.class_id']), "arrr");
                $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
                $page_data['sch_id'] = $this->input->post('school_id');
                $page_data['class_id'] = $this->input->post('class_id');
                $page_data['section_id'] = $this->input->post('section_id');
               // print_r($page_data['sections']);exit;
                $page_data['fee_due_records'] = $this->fi_functions->get_fee_due_list($data,$running_year, $data['e.class_id'], $data['sec.section_id']) ;
                //print_r( $page_data);exit;
            }    
        } 
        
        $this->load->view('backend/index', $page_data);
            
    }
    
    public function student_common_report($keyword){
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        //UNITED ARAB EMIRATES
        $page_data = array();
        
        $page_data = $this->get_page_data_var();
        $page_data['page_title'] = get_phrase("Student $keyword Report");
        $page_data['page_name'] = "student_common_report";
        $page_data['schools']   = $this->School_model->get_school_array();
        $page_data['account_type'] = $this->session->userdata('login_type');
        $page_data['search_type'] = $keyword;
        $page_data['page_name'] = "student_common_report";
        $page_data['page_type'] = $page_type = ($this->input->post('page_type')!= "") ? $this->input->post('page_type') : "emirati";
       //echo $page_type."Jesus";exit;
        switch($keyword){
            case 'emirati': 
                            if(!empty($_POST)){
                                    if(trim($this->input->post('school_id')) != "")
                                        $data['s.school_id'] = $this->input->post('school_id');
                                    if(trim($this->input->post('class_id')) != "")
                                        $data['c.class_id'] = $this->input->post('class_id');
                                    if(trim($this->input->post('section_id')) != "")
                                        $data['sec.section_id'] = $this->input->post('section_id');
                            }
                            if($page_type == "emirati"){
                                
                                $data['s.nationality'] = "UNITED ARAB EMIRATES";
                                $page_data['fields'][0] = "Emiratis";
                               
                            } else {
                                $data['s.nationality!='] = "UNITED ARAB EMIRATES";
                                $page_data['fields'][0] = "Expat";
                            } 
                            $page_data['res'] = $this->Student_model->get_students_common_report('s.school_id',$data);  
                            $path = "emirati";
                            //print_r($page_data['res']);exit;
                            break;
            case 'muslim': 
                            if(!empty($_POST)){
                                if(trim($this->input->post('school_id')) != "")
                                    $data['s.school_id'] = $this->input->post('school_id');
                                if(trim($this->input->post('class_id')) != "")
                                    $data['c.class_id'] = $this->input->post('class_id');
                                if(trim($this->input->post('section_id')) != "")
                                    $data['sec.section_id'] = $this->input->post('section_id');
                            }
                            $data['s.religion'] = "muslim";
                            $page_data['fields'][0] = "Total Muslim students";
                            
                            $page_data['res'] = $this->Student_model->get_students_common_report('religion',$data);
                            
                            break;
            case 'RTE': 
                            if(!empty($_POST)){
                                if(trim($this->input->post('class_id')) != "")
                                    $data['es.class_id'] = $this->input->post('class_id');
                                if(trim($this->input->post('school_id')) != "")
                                    $page_data['school_id'] = $data['class.school_id'] = $this->input->post('school_id');
//                                if(trim($this->input->post('section_id')) != "")
//                                    $data['sec.section_id'] = $this->input->post('section_id');
                               
                                $page_data['class_id'] = $data['class_id'];
                                $page_data['classes']   = $this->Class_model->get_data_generic_fun('*',array('school_id'=>$page_data['school_id']),'result_arr');
                                $data['govt_admission_code!='] = "";
                                $page_data['fields'][0] = "Government Admission Code";
                                if($page_data['school_id']=="")
                                        $group_by = 'class.school_id';
                                $page_data['rtes'] = $this->Student_model->get_rte_students($data, $group_by);
                            }
                            $path = "RTE";
                            $page_data['page_name'] = "student_rte_report";
                            
                           //print_r($page_data['res']);exit;
                            break;
            case 'section': 
                            $data = array();
                            $page_data['schools_id']="";
                            if(!empty($_POST)){
                                if(trim($this->input->post('class_id')) != "")
                                    $page_data['class_id'] = $data['sec.class_id'] = $this->input->post('class_id');
                                if(trim($this->input->post('school_id')) != "")
                                    $page_data['schools_id'] = $data['sec.school_id'] = $this->input->post('school_id');
                            } 
                            $page_data['page_name'] = "student_section_report";
                            //$data['s.school_id'] = 1;
                            //echo "Jesus";
                            $this->load->model("Section_model");
                            $page_data['res']   = $this->Section_model->get_section_report($data);
                            $page_data['schools']   = $this->School_model->get_school_array();
                            break;                
            
            case 'class': if(!empty($_POST)){
                            $data = array();
                            $page_data['schools_id']="";
                            if(trim($this->input->post('school_id')) != "")
                                $page_data['schools_id']=$data['s.school_id'] = $page_data['school_id'] = $this->input->post('school_id');
                            }
                            $page_data['page_name'] = "student_class_report";
                            //$data['s.school_id'] = 1;
                            $page_data['res']   = $this->Class_model->get_class_report($data);
                            $page_data['schools']   = $this->School_model->get_school_array();
                            break;                
            case 'school':            
                            $page_data['page_name'] = "school_report";
                            $page_data['res']   = $this->School_model->get_school_report();
                            //pre($page_data['res']);exit;
                            break;
            case 'bus': 
                            $data = array();
                            if(!empty($_POST)){
                                if(trim($this->input->post('school_id')) != "")
                                    $page_data['schools_id'] = $data['s.school_id'] = $this->input->post('school_id');
                            }
                            $page_data['page_name'] = "bus_report";
                            $this->load->model("Transport_model");
                            $page_data['res']   = $this->Transport_model->get_bus_report($data);
                            $page_data['schools']   = $this->School_model->get_school_array();
                            break;  
            case 'computer': 
                            $data = array();
                            if(!empty($_POST)){
                                if(trim($this->input->post('school_id')) != "")
                                    $page_data['schools_id'] = $data['s.school_id'] = $this->input->post('school_id');
                            }
                            
                            $page_data['page_name'] = "computer_report";
                            $this->load->model("Inventory_category_model");
                            $page_data['res']   = $this->Inventory_category_model->get_computer_report($data);
                            $page_data['schools']   = $this->School_model->get_school_array();
                            break; 
            case 'teacher': 
                            $data = array();
                            if(!empty($_POST)){
                                if(trim($this->input->post('school_id')) != "")
                                    $page_data['schools_id'] = $data['s.school_id'] = $this->input->post('school_id');
                                if(trim($this->input->post('class_id')) != "")
                                    $page_data['class_id'] = $data['c.class_id'] = $this->input->post('class_id');
                            }
                            
                            $page_data['page_name'] = "teacher_report";
                            $this->load->model("Teacher_model");
                            $page_data['res']   = $this->Teacher_model->get_teacher_report($data); 
                            $page_data['schools']   = $this->School_model->get_school_array();
                            break; 
            case 'expenses' :
                            $data = array();
                            if(!empty($_POST)){
                                if(trim($this->input->post('school_id')) != "")
                                    $page_data['schools_id'] = $data['school_id'] = $this->input->post('school_id');
                                if(trim($this->input->post('from_date')) != "")
                                    $page_data['from_date'] = $data['from_date'] = $this->input->post('from_date');
                                if(trim($this->input->post('to_date')) != "")
                                    $page_data['to_date'] = $data['to_date'] = $this->input->post('to_date');
                            }
                            $page_data['page_name'] = "expenses_report";
                            $data = array("type"=>"Expense");
                            $page_data['res']   = $this->fi_functions->get_school_income_report($data); 
                            
            break; 
            case 'revenue' :
                            $data = array();
                           $page_data['page_name'] = "revenues_report";
                            //$this->load->model("Teacher_model");
                            $data = array("type"=>"Income");
                            $page_data['res']   = $this->fi_functions->get_school_income_report($data); 
                             break;              
        }                  
        $page_data['fn_name'] = "student_common_report";    
        $page_data['params'] = $keyword;
        $page_data['schools_id'] = $this->input->post('school_id');
        $page_data['class_id'] = $this->input->post('class_id');
        $page_data['classes']   = $this->Class_model->get_data_generic_fun('*',array('school_id'=>$page_data['schools_id']),'result_arr');
        $this->load->view('backend/index', $page_data);
    }
    
    
    function student_main_reports($page)
    {
  
        if(empty($id))
        {    
            $id = (isset($_POST['id'])) ? $_POST['id'] : '' ;
        }
        if(empty($id))
            return;
        
        
        $this->load->model("Dynamic_report_model");
        $this->load->model("Dynamic_field_model");
        $report_row                     = $this->Dynamic_report_model->getReport($id);
        $page_data['page_title']        = get_phrase($report_row->report_caption);
        $arrFields                      = $this->Dynamic_report_model->getFields($report_row->id);
        $query                          = $report_row->query;
        $report_condition               = $report_row->condition;
        $arrCaption                     = array();
        $caption                        = $report_row->field_caption;
        $static_condition               = $report_row->static_condition;
        $group_by                       = $report_row->group_by;
        $order_by                       = $report_row->order_by;
        if(!empty($caption))
        {
            $arrCaption = explode(",", $caption);
        }    
        if($_POST)
        {    
           
            $school_id      = '';
            $class_id       = '';
            $section_id     = '';
            $rte            = "";
            $where          = " 1 = 1 ";
            if(!empty(trim($_POST['school_id'])))
            {    
                $parent_id      = $id;
                $school_id      = $_POST['school_id'];
                $where         .= " AND class.school_id = $school_id";
            }
            if(!empty(trim($_POST['class_id'])))
            {    
                $class_id   = $_POST['class_id'];
                $where      .= " AND class.class_id = $class_id";
            }
            if(!empty(trim($_POST['section_id'])))
            {    
                
                $section_id          = $_POST['section_id'];
                $where              .= " AND section.section_id = $section_id";
            }
            if(!empty($_POST['rte']))
            {    
                $rte             = $_POST['rte'];
                $where          .= " AND student.rte = '$rte'";
            }
            if(!empty($_POST['nationality']))
            {    
                $nationality        = $_POST['nationality'];
                $where             .= " AND student.nationality = '$nationality'";
            }
            if(!empty($_POST['dormitory_id']))
            {    
                $dormitory   = $_POST['dormitory_id'];
                $where      .= " AND dormitory_id = '$dormitory'";
            }
            if(!empty($_POST['join_date_from']))
            {
                $join_date_from     = $_POST['join_date_from'];
                $join_date_to       = $_POST['join_date_to'];
                $where             .="date_of_joining BETWEEN '$join_date_from' AND '$join_date_to'";
            }    
            
            if(!empty($static_condition))
            {
                $where .= " AND $static_condition";
            }    
            $query = str_replace("str_replace", $where, $query);
            if(!empty($group_by))
            {
                $query .= $group_by;
            }
            if(!empty($order_by))
            {
                $query .= $order_by;
            }
            
            $result = $this->Dynamic_report_model->runDynamicQuery($query);
            foreach($_POST as $key => $value)
            {
                $page_data[$key] = $value;
            }
            $page_data['result']        =      $result;
            $page_data['arrCaption']    =  $arrCaption;
        }
        else
        {
            $where      = " 1 = 1 ";
            if(!empty($static_condition))
            {
                $where .= " AND $static_condition";
            }
            $query = str_replace("str_replace", $where, $query);
            if(!empty($group_by))
            {
                $query .= $group_by;
            }
            if(!empty($order_by))
            {
                $query .= $order_by;
            }
            $result = $this->Dynamic_report_model->runDynamicQuery($query);
            foreach($_POST as $key => $value)
            {
                $page_data[$key] = $value;
            }
            $page_data['result'] =      $result;
            $page_data['arrCaption'] =  $arrCaption;
        }    
        $page_data['id']            =               $report_row->id;
        $page_data['caption']       =               $report_row->report_caption;
        $page_data['page_name']     =               $page;
        $this->load->view('backend/index', $page_data);
     }
     
     public function student_category_report($school_id="")
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = array();
        $page_data = $this->get_page_data_var();
        $page_data['page_title'] = get_phrase('Student Category Report');
        $page_data['page_name'] = 'student_category_report';
        $page_data['schools']   = $this->School_model->get_school_array();
        $page_data['categories'] = $this->Student_model->get_student_categories(); 
        $page_data['account_type'] = $this->session->userdata('login_type'); 
        foreach($page_data['categories'] as $k=>$v){
            $cats[$k] = $v['caste_category']; 
        }
        if(!empty($_POST)){
            $data = array();
            if(trim($this->input->post('class_id')) != "")
                $page_data['class_id'] = $data['c.class_id'] = $this->input->post('class_id');
            if(trim($this->input->post('school_id')) != "")
                $page_data['schools_id'] = $data['s.school_id'] = $this->input->post('school_id');
            if(trim($this->input->post('section_id')) != "")
                $page_data['section_id'] = $data['sec.section_id'] = $this->input->post('section_id');
            if(trim($this->input->post('caste_category')) != "")
                $page_data['caste_category'] = $data['s.caste_category'] = $this->input->post('caste_category'); 
            $res = $this->Student_model->get_students_category_report($data);
            $page_data['dat'] = array();
            
            $i = 0;
            foreach($res as $key=>$row){  
                $cnt = isset($page_data['dat']) ?   count($page_data['dat']) : 0;
                if(($cnt>0) && ($page_data['dat'][$cnt-1]['school_name'] != $row['school_name'])){
                    $i++;
                }    
                $page_data['dat'][$i]['school_name']=$row['school_name'];
                
                if(array_search($row['caste_category'], $cats)){ 
                    $page_data['dat'][$i][$row['caste_category']] = $row['total'];
                }else{ 
                    $page_data['dat'][$i][$row['caste_category']] = $row['total'];
                }
                
             }
        } 
        $page_data['caste_category'] = $data['s.caste_category'];
        $page_data['classes']   = $this->Class_model->get_data_generic_fun('*',array('school_id'=>$page_data['schools_id']),'result_arr');    
        $this->load->view('backend/index', $page_data);
    }
    
    public function student_leave_report($school_id="")
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = array();
        $page_data = $this->get_page_data_var();
        $page_data['page_title'] = get_phrase('Student Leave Report');
        $page_data['page_name'] = 'student_leave_report';
        $page_data['account_type'] = $this->session->userdata('login_type');
        $school_id = $school_id;//list all schools
        $this->load->model("School_model");
        $page_data['schools']   = $this->School_model->get_school_array($school_id);
        $this->load->view('backend/index', $page_data);
    }
    public function teacher_leave_report($school_id="")
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = array();
        $page_data = $this->get_page_data_var();
        $page_data['page_title'] = get_phrase('Teacher_Leave Report');
        $page_data['page_name'] = 'teacher_leave_report';
        $page_data['schools']   = $this->School_model->get_school_array();
        $page_data['account_type'] = $this->session->userdata('login_type');
        
//        if(!empty($_POST))
//        {  
//           // $this->form_validation->set_rules('school_id','School', 'required');
//            //$this->form_validation->set_rules('Department_id', 'Department', 'required');
//            //$this->form_validation->set_rules('section_id','Section','required');
//            if ($this->form_validation->run() == TRUE) {  
//                $data['school_id'] = $this->input->post('school_id');
//                 
//                $data['department_id'] = $this->input->post('department_id');
//                $data['e.year'] = $this->input->post('year');
//                
//                $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
//                $page_data['school_id'] = $data['school_id'];
//                $page_data['department_id'] = $data['department_id'];
//               
//            }    
//               // $this->load->view('backend/index', $page_data);
//        } 
        $data['leavestatus'] = "Approved";
        $page_data['teacher_records'] = $this->Student_model->get_teacher_records($data); 
        
        $this->load->view('backend/index', $page_data);
    }
    
    public function student_leave_report_selector()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $this->form_validation->set_rules('school_id','Schools', 'required');
        $this->form_validation->set_rules('class_id', 'Class', 'required');
        $this->form_validation->set_rules('section_id','Section','required');
        $this->form_validation->set_rules('month','Month','required');
        
        if ($this->form_validation->run() == TRUE) { 
            $data['school_id'] = $this->input->post('school_id');
           
            $data['class_id'] = $this->input->post('class_id');
            $data['year'] = $this->input->post('year');
            $data['month'] = $this->input->post('month');
            $data['section_id'] = $this->input->post('section_id');
           
            redirect(base_url() . 'index.php?admin/student_leave_report_view/'. $data['school_id'] .'/'. $data['class_id'] . '/' . $data['section_id'] . '/' . $data['month'], 'refresh');
        } else {
            $page_data['schools'] = get_data_generic_fun('schools', 'school_id, name', array(), 'result_arr');
            $page_data['page_name'] = 'student_leave_report';
            $page_data['page_title'] = get_phrase('student_leave_report');
            //$page_data['total_notif_num'] = $this->get_no_of_notication();
            $this->load->view('backend/index', $page_data);
        }
        
    }
    
    public function class_topper_report()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        $ranking_id = "11";
        $page_data = array();
        $page_data = $this->get_page_data_var();
        $page_data['page_title'] = get_phrase('Class Topper Report');
        $page_data['page_name'] = 'class_topper_report';
        $page_data['account_type'] = $this->session->userdata('login_type');
        $page_data['schools']   = $this->School_model->get_school_array();
        
        //$rs = $this->Crud_model->get_top_students("69","1","14","11");
      //
        if(!empty($_POST))
        {  
            
            $this->form_validation->set_rules('school_id','School', 'required');
            $this->form_validation->set_rules('class_id', 'Class', 'required');
            $this->form_validation->set_rules('section_id', 'Section', 'required');
            $this->form_validation->set_rules('exam_id', 'Exam', 'required');
            
           //print_r($page_data);exit;
            if ($this->form_validation->run() == TRUE) {  
                $page_data['school_id'] = $this->input->post('school_id');
                $page_data['class_id'] = $this->input->post('class_id');
                $page_data['section_id'] = $this->input->post('section_id');
                $page_data['exam_id'] = $this->input->post('exam_id');
                $page_data['schools'] = get_data_generic_fun('schools', "*", array(), "arrr");
                $page_data['classes'] = get_data_generic_fun('class', "*", array(), "arrr");
                $page_data['sections'] = get_data_generic_fun('section', "*", array('class_id' => $page_data['class_id']), "arrr");
                $page_data['exams'] = $this->Exam_model->get_exam_by_section('DISTINCT(ex.exam_id),ex.name',array('section_id'=>$section_id,'class_id'=>$class_id),'result_arr');
                $page_data['rs'] = $this->Crud_model->get_top_students($page_data['exam_id'], $page_data['class_id'], $page_data['section_id'], $ranking_id);
            }
        }
        
        
        $this->load->view('backend/index', $page_data);
    }
    
    public function best_ranking_student_report()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        $ranking_id = "11";
        $page_data = array();
        $page_data = $this->get_page_data_var();
        $page_data['page_title'] = get_phrase('Best_Ranking_Students_Report');
        $page_data['page_name'] = 'best_ranking_student_report';
        $page_data['account_type'] = $this->session->userdata('login_type');
        $page_data['classes'] = get_data_generic_fun('class', "*", array(), "arrr");
            
        
        //$rs = $this->Crud_model->get_top_students("69","1","14","11");
      //
        if(!empty($_POST))
        {  
            //SELECT SUM(mark_obtained) , SUM(mark_total), student_id,exam_id FROM mark where exam_id = 3 GROUP by student_id,exam_id order by mark_obtained desc
            
            
            $this->form_validation->set_rules('class_id', 'Class', 'required');
            $this->form_validation->set_rules('section_id', 'Section', 'required');
            $this->form_validation->set_rules('exam_id', 'Exam', 'required');
            
          
            if ($this->form_validation->run() == TRUE) {  
                
                $page_data['class_id'] = $this->input->post('class_id');
                $page_data['section_id'] = $this->input->post('section_id');
                $page_data['exam_id'] = $this->input->post('exam_id');
                
                
                $page_data['sections'] = get_data_generic_fun('section', "*", array('class_id' => $page_data['class_id']), "arrr");
                $page_data['exams'] = $this->Exam_model->get_exam_by_section('DISTINCT(ex.exam_id),ex.name',array('section_id'=>$section_id,'class_id'=>$class_id),'result_arr');
                $page_data['rs'] = $this->Crud_model->get_top_students($page_data['exam_id'], $page_data['class_id'], $page_data['section_id'], $ranking_id);
            }
        }
        
        
        $this->load->view('backend/index', $page_data);
    }
    
    public function bus_detail_report()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = array();
        $page_data = $this->get_page_data_var();
        $page_data['page_title'] = get_phrase('Bus Details Report');
        $page_data['page_name'] = 'bus_detail_report';
        $page_data['account_type'] = $this->session->userdata('login_type');
        
        $page_data['routes'] = $this->Transport_model->get_all_routes();
        if(!empty($_POST))
        {
            $this->form_validation->set_rules('route_id','Routes', 'required');
            $page_data['route_id'] = $this->input->post('route_id');
            
            if ($this->form_validation->run() == TRUE) {
                $page_data['bus_details'] = $this->Transport_model->get_bus_details($page_data['route_id'] );
            }
        }
        $this->load->view('backend/index', $page_data);
    }
            
    function student_leave_report_view($school_id = '', $class_id = '', $section_id = '', $month = '') {
        
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'student_leave_report_view';
        $this->load->model('Student_model');
        $page_data['school_name'] = $this->School_model->get_school_record(array('school_id' => $school_id), "name");
        $page_data['class_name'] = $this->Class_model->get_class_record(array('class_id' => $class_id), "name");
        $page_data['section_name'] = $this->Class_model->get_section_record(array('section_id' => $section_id), "name");
        $page_data['school_id'] = $school_id;
        $page_data['class_id'] = $class_id;
        $page_data['section_id'] = $section_id;
        $page_data['month'] = $month;
       
        //$page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['schools'] = get_data_generic_fun('schools', "*", array(), "arrr");
        $page_data['classes'] = get_data_generic_fun('class', "*", array(), "arrr");
        $page_data['sections'] = get_data_generic_fun('section', "*", array('class_id' => $class_id), "arrr");
        
        $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
        $page_data['students'] = $this->Student_model->get_student_details('', $section_id);  
        $page_data['year'] = explode('-', $running_year);
        $page_data['days'] = cal_days_in_month(CAL_GREGORIAN, $month, $page_data['year'][0]);
        $page_data['page_title'] = get_phrase('leave_report_of_School') . ' ' . $page_data['school_name'] . ' : '.get_phrase('leave_report_of_class') . ' ' . $page_data['class_name'] . ' : ' . get_phrase('section') . ' ' . $page_data['section_name'];
        //print_r($page_data);exit;
        $this->load->view('backend/index', $page_data);
    }
    
    function message($param1 = 'message_home', $param2 = '', $param3 = '') 
    {
        
        $this->load->model("School_admin_model");
        $this->load->model("Crud_model");
        if ($this->session->userdata('admin_login') != 1)
        redirect(base_url(), 'refresh');
//$page_data = $this->get_page_data_var();
        if ($param1 == 'send_new') {
           
            $message_thread_code = $this->Crud_model->send_new_private_message_admin_main();
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?admin/message/message_read/' . $message_thread_code, 'refresh');
        }

        if ($param1 == 'send_reply') {
            $this->Crud_model->send_reply_message_main($param2);  //$param2 = message_thread_code
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?admin/message/message_read/' . $param2, 'refresh');
        }

    if ($param1 == 'message_read') {
        
        $this->load->model("Crud_model");
        $page_data['current_message_thread_code'] = $param2;  // $param2 = message_thread_code
        
        $this->Crud_model->mark_thread_messages_read_main($param2);
      
        $this->load->model("Admin_Message_model");
        //$data = $this->Admin_Message_model->get_data_by_cols('*', array('message_thread_code' => $param2), 'result_array');
        
        $page_data['messages'] = $this->Admin_Message_model->get_data_by_cols('*', array('message_thread_code' => $param2), 'result_array');
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
            $this->load->model($model_name);
            if ($sender_account_type == 'admin') {
               
                $parent = $this->$model_name->get_data_by_cols('name', array($sender_account_type . '_id' => $sender_id), 'result_array');
                
                if (!empty($parent)) {
                    $parent_all[]['name'] = $parent[0]['name'];
                } else {
                    $parent_all[]['name'] = "";
                }
            } else {
                $parent = $this->$model_name->get_data_by_cols('first_name', array($sender_account_type . '_id' => $sender_id), 'result_array');
                if (!empty($parent)) {
                    $parent_all[]['name'] = $parent[0]['first_name'];
                } else {
                    $parent_all[]['name'] = "";
                }
            }
            
            $NewArray[$i] = array_merge($message, $parent_all[$i], $img_user[$i]);
            $i++;
        }
        $page_data['message'] = $NewArray;
    }

    if ($param1 == 'message_new') {
        $this->load->model('School_Admin_model');
        //$all_participent['admin'] = $this->Admin_model->get_data_by_cols('*', array(), 'result_array', array('name' => 'asc'));
        
        $all_participent['school_admin'] = $this->School_Admin_model->get_data_by_cols('*', array(), 'result_array', array('first_name' => 'asc'));
            
        
        $page_data['all_participent'] = $all_participent;
    }
    
    if($param1 == 'delete'){
        $this->load->model('Admin_Message_model');
        $delete_message = $this->Admin_Message_model->delete_msg_thread($param2);
        if($delete_message){
            $this->session->set_flashdata('flash_message', get_phrase('message_deleted!'));
            redirect(base_url() . 'index.php?admin/message/message_read/'.$param2, 'refresh');
        }else{
            $this->session->set_flashdata('flash_message_error', get_phrase('could_not_delete!'));
            redirect(base_url() . 'index.php?admin/message/message_read/' . $param2, 'refresh');
        }
    }
    
       
        $page_data['message_inner_page_name'] = $param1;
        $page_data['page_name'] = 'message';
        $page_data['page_title'] = get_phrase('Message_board');
        //pre($page_data); die();
        $this->load->view('backend/index', $page_data);
    }
    
    function get_class_wise_school_attendance_data($school_id) {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model("Attendance_model");
        
        $school_data = $this->School_model->getSingleSchoolData($school_id);
        $attendance_data = $this->Attendance_model->getClassWiseAttendanceOfSchool($school_id);

        $return = array('name'=>$school_data['name'],'colorByPoint'=>true,'data'=>array());
        
        $data1 = array();
        foreach($attendance_data as $key=>$row)
        {
            $return['data'][] = array('name'=>$row['name'],'y'=>$row['total_attendance']);
            
        }
        echo json_encode($return);exit;
        
        $data.=implode(",",$data1).",";
        $data.= "]}]";
        echo $data;
        exit();
    }
    
    function get_holidays_by_month($month,$school_id) {
        if ($this->session->userdata('admin_login') != 1)
        redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model("Holiday_model");
        
        $holiday_data = $this->Holiday_model->getHolidaysByMonth($month,$school_id);
        if(count($holiday_data) > 0) {
            $data = '';
            $data = '<ul class="earning-box">';
                foreach($holiday_data as $holiday){ 
                    $data.='<li>
                        <div class="er-row">
                            <div class="er-text">
                                <h3>'.ucfirst($holiday['title']).'</h3>
                                <span class="text-muted">'.date('l', strtotime($holiday['date_start'])).'</span>
                            </div>
                            <div class="er-count ">'.date('d-m-Y', strtotime($holiday['date_start'])).'</div>
                        </div>
                    </li>';
                }
                    $data.='</ul>';
                }
        else {
            $data = 'No holidays in this month.';
        }
        
        echo $data;
        exit();
    }
    
    function get_page_data_var() {
        $this->load->model('Crud_model');
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
        $page_data['system_logo'] = $this->Setting_model->get_setting_record(array('type' => 'system_logo'),'description');
        return $page_data;
    }
     /*Holiday Settings*/
}

// --------------------------------------------------------------------------
/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */


    