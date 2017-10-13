<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Accountant extends CI_Controller {

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

    /*     * *default functin, redirects to login page if no logged in yet** */

    public function index() {
        if ($this->session->userdata('accountant_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($this->session->userdata('accountant_login') == 1)
            redirect(base_url() . 'index.php?fees/accountant/dashboard', 'refresh');
    }

    function dashboard() {
        if ($this->session->userdata('accountant_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'fees/accountant/dashboard';
        $page_data['page_title'] = get_phrase('accountant_dashboard');

        $page_data['arrAllLinks'] = $this->session->userdata('arrAllLinks');

        $this->load->view('backend/index', $page_data);
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
    
  }