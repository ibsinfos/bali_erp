<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Disciplinary extends CI_Controller {
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
      
    }
     public function index() {
        if ($this->session->userdata('school_admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($this->session->userdata('school_admin_login') == 1)
            redirect(base_url() . 'index.php?school_admin/dashboard', 'refresh');
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
    public function manage_violation_types() {
        if ($this->session->userdata('school_admin_login') != 1)
            redirect(base_url(), 'refresh');
        $this->load->model('Violation_types_model');
        $page_data                  =   array();
        $page_data                  =   $this->get_page_data_var();
        $page_data['page_title']    =   get_phrase('manage_violation_types');
        $page_data['page_name']     =   'manage_violation_types';
        $page_data['details']       =   $this->Violation_types_model->get_data_by_cols('*', array('status'=>'Active'), 'result_array');
        $this->load->view('backend/index', $page_data);
    }
    public function add_violation_types($param1='',$param2='') {
        if ($this->session->userdata('school_admin_login') != 1)
            redirect(base_url(), 'refresh');
        $this->load->model('Violation_types_model');
        if($param1  ==  "create"){
            $this->form_validation->set_rules('type', 'Type', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('flash_message_error', validation_errors());
            } 
            else {
                $data['type']       =   $this->input->post('type');
                $data['description']=   $this->input->post('description');
                $data['status']     =   "Active";
                $this->Violation_types_model->add_data($data);
                $this->session->set_flashdata('flash_message', get_phrase('violation_type_added_successfully'));
                redirect(base_url() . 'index.php?disciplinary/manage_violation_types', 'refresh');
            }
        }
        if ($param1 == 'delete') {
            $delete = $this->Violation_types_model->delete($param2);
            if ($delete == true) {
                $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('data_not_deleted'));
            }
            redirect(base_url() . 'index.php?disciplinary/manage_violation_types/', 'refresh');
        }
        $page_data                  =   array();
        $page_data                  =   $this->get_page_data_var();
        $page_data['page_title']    =   get_phrase('add_violation_types');
        $page_data['page_name']     =   'add_violation_types';
        $this->load->view('backend/index', $page_data);
        
    }
    public function edit_violation_types($param1=""){
        if ($this->session->userdata('school_admin_login') != 1)
            redirect(base_url(), 'refresh');
        $this->load->model('Violation_types_model');
        $this->form_validation->set_rules('type', 'Type', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_error_delimiters('', '');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_message_error', validation_errors());
            redirect(base_url() . 'index.php?disciplinary/manage_violation_types', 'refresh');
        } 
        else { 
            $data['type']       =   $this->input->post('type');
            $data['description']=   $this->input->post('description');
            $this->Violation_types_model->update_data($data,$param1);
            $this->session->set_flashdata('flash_message', get_phrase('violation_type_updated_successfully'));
            redirect(base_url() . 'index.php?disciplinary/manage_violation_types', 'refresh');
        }
    } 
    public function manage_incident() {
        $this->load->model('Incident_model');
        $page_data                  =   array();
        $page_data                  =   $this->get_page_data_var();
        $page_data['page_title']    =   get_phrase('manage_incident');
        $page_data['page_name']     =   'manage_incident';
        $page_data['details']       =   $this->Incident_model->get_details();
//        pre($page_data['details']);exit;
        $this->load->view('backend/index', $page_data);
    }
    public function add_incident($param1='',$param2='') {
        $this->load->model('Incident_model');
        $this->load->model('Section_model');
        if($param1  ==  "create"){
            $this->form_validation->set_rules('violation_type', 'Violation Type', 'trim|required');
            $this->form_validation->set_rules('class_id', 'Class', 'trim|required');
            $this->form_validation->set_rules('section', 'Section', 'trim|required');
            $this->form_validation->set_rules('student_id', 'Student', 'trim|required');
            $this->form_validation->set_rules('parent_appeal', 'Parent Appeal', 'trim|required');
            if($this->input->post('parent_appeal')=="yes"){
                $this->form_validation->set_rules('parent_statement', 'Parent Statement', 'trim|required');
            }
            $this->form_validation->set_rules('verdict', 'Verdict', 'trim|required');
            $this->form_validation->set_rules('reporting_teacher', 'Reporting Teacher', 'trim|required');
            $this->form_validation->set_rules('corrective_action', 'Corrective Action', 'trim|required');
            $this->form_validation->set_rules('date_of_occurrence', 'Date of Occurrence', 'trim|required');
            $this->form_validation->set_rules('expiry_date', 'Expiry Date', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('flash_message_error', validation_errors());
                redirect(base_url() . 'index.php?disciplinary/add_incident', 'refresh');
            } 
            else {
                $data['violation_type_id']      =   $this->input->post('violation_type');
                $data['class_id']               =   $this->input->post('class_id');
                $data['section_id']             =   $this->input->post('section');
                $data['student_id']             =   $this->input->post('student_id');
                $data['parent_appeal']          =   $this->input->post('parent_appeal');
                if($this->input->post('parent_appeal')=="yes"){
                    $data['parent_statement']   =   $this->input->post('parent_statement');
                }
                else{
                    $data['parent_statement']   =   "";
                }
                $data['verdict']                =   $this->input->post('verdict');
                $data['reporting_teacher_id']   =   $this->input->post('reporting_teacher');
                $data['corrective_action']      =   $this->input->post('corrective_action');
                $data['date_of_occurrence']     =   date('Y-m-d', strtotime($this->input->post('date_of_occurrence')));
                $data['expiry_date']            =   date('Y-m-d', strtotime($this->input->post('expiry_date')));
                //pre($data);exit;
                $teacher                        =   $this->Section_model->get_teachername_by_class_section($data['class_id'],$data['section_id']);                    
                if(!empty($teacher)){
                     $data['raised_by_teacher_id']   =   $teacher[0]['teacher_id'];
                }
                if($this->session->userdata('school_admin_login')){
                    $data['added_by']               =   "admin_".$this->session->userdata('school_admin_id');
                }
                else if($this->session->userdata('teacher_login')){
                    $data['added_by']               =   "teacher_".$this->session->userdata('teacher_id');
                }
                $data['status']                 =   "Active";
                $this->Incident_model->add_data($data);
                $this->session->set_flashdata('flash_message', get_phrase('incident_added_successfully'));
                redirect(base_url() . 'index.php?disciplinary/manage_incident', 'refresh');
            }
        }
            if($param1  ==  "edit"){
            $this->form_validation->set_rules('violation_type', 'Violation Type', 'trim|required');
            $this->form_validation->set_rules('parent_appeal', 'Parent Appeal', 'trim|required');
            if($this->input->post('parent_appeal')=="yes"){
                $this->form_validation->set_rules('parent_statement', 'Parent Statement', 'trim|required');
            }
            $this->form_validation->set_rules('verdict', 'Verdict', 'trim|required');
            $this->form_validation->set_rules('reporting_teacher', 'Reporting Teacher', 'trim|required');
            $this->form_validation->set_rules('corrective_action', 'Corrective Action', 'trim|required');
            $this->form_validation->set_rules('date_of_occurrence', 'Date of Occurrence', 'trim|required');
            $this->form_validation->set_rules('expiry_date', 'Expiry Date', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('flash_message_error', validation_errors());
                redirect(base_url() . 'index.php?disciplinary/edit_incident/'.$param2, 'refresh');
            } 
            else {
                $data['violation_type_id']      =   $this->input->post('violation_type');
                $data['parent_appeal']          =   $this->input->post('parent_appeal');
                if($this->input->post('parent_appeal')=="yes"){
                    $data['parent_statement']   =   $this->input->post('parent_statement');
                }
                $data['verdict']                =   $this->input->post('verdict');
                $data['reporting_teacher_id']   =   $this->input->post('reporting_teacher');
                $data['corrective_action']      =   $this->input->post('corrective_action');
                $data['date_of_occurrence']     =   date('Y-m-d', strtotime($this->input->post('date_of_occurrence')));
                $data['expiry_date']            =   date('Y-m-d', strtotime($this->input->post('expiry_date')));
                
                if($this->session->userdata('school_admin_login')){
                    $data['added_by']               =   "admin_".$this->session->userdata('school_admin_id');
                }
                else if($this->session->userdata('teacher_login')){
                    $data['added_by']               =   "teacher_".$this->session->userdata('teacher_id');
                }
                $this->Incident_model->update_data($data,$param2);
                $this->session->set_flashdata('flash_message', get_phrase('incident_edited_successfully'));
                redirect(base_url() . 'index.php?disciplinary/manage_incident', 'refresh');
            }
        }
        if ($param1 == 'delete') {
            $delete = $this->Incident_model->delete($param2);
            if ($delete == true) {
                $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('data_not_deleted'));
            }
            redirect(base_url() . 'index.php?disciplinary/manage_incident/', 'refresh');
        }
        $page_data                  =   array();
        $page_data                  =   $this->get_page_data_var();
        $this->load->model('Violation_types_model');
        $page_data['violation']     =   $this->Violation_types_model->get_data_by_cols('*', array('status'=>'Active'), 'result_array');
        $this->load->model('Class_model');
        $page_data['classes']       =   $this->Class_model->get_data_by_cols('*', array(), 'result_array',array('name_numeric'=>'asc'));
        $this->load->model('Teacher_model');
        $page_data['teachers']      =   $this->Teacher_model->get_data_by_cols('*', array(), 'result_array',array('name'=>'asc'));
        $page_data['page_title']    =   get_phrase('add_incident');
        $page_data['page_name']     =   'add_incident';
        $this->load->view('backend/index', $page_data);
        
    }
    public function edit_incident($incident_id=""){
        $this->load->model('Incident_model');
        $page_data                  =   array();
        $page_data                  =   $this->get_page_data_var();
        $page_data['page_title']    =   get_phrase('edit_incident');
        $page_data['page_name']     =   'edit_incident';
        $page_data['details']       =   $this->Incident_model->get_details_by_id($incident_id);
        $this->load->model('Violation_types_model');
        $page_data['violation']     =   $this->Violation_types_model->get_data_by_cols('*', array('status'=>'Active'), 'result_array');
        $this->load->model('Teacher_model');
        $page_data['teachers']      =   $this->Teacher_model->get_data_by_cols('*', array(), 'result_array',array('name'=>'asc'));
//        pre($page_data['details']);exit;
        $this->load->view('backend/index', $page_data);
    }
    function my_incident(){
        if($this->session->userdata('school_admin_login')){
            $this->load->model('Incident_model');
            $page_data                  =   array();
            $page_data                  =   $this->get_page_data_var();
            $page_data['page_title']    =   get_phrase('my_incident');
            $page_data['page_name']     =   'my_incident';
            $added_by                   =   "admin_".$this->session->userdata('school_admin_id');
            $page_data['details']       =   $this->Incident_model->get_details_added_by($added_by);
    //        pre($page_data['details']);exit;
            $this->load->view('backend/index', $page_data);
        }
        elseif($this->session->userdata('teacher_login')) {
            $this->load->model('Incident_model');
            $page_data                  =   array();
            $page_data                  =   $this->get_page_data_var();
            $page_data['page_title']    =   get_phrase('my_incident');
            $page_data['page_name']     =   'my_incident';
            $added_by                   =   "teacher_".$this->session->userdata('teacher_id');
            $page_data['details']       =   $this->Incident_model->get_details_added_by($added_by);
    //        pre($page_data['details']);exit;
            $this->load->view('backend/index', $page_data);
        }
    }
}