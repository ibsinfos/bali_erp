<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Assets extends CI_Controller {

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
        $this->load->model(array('Setting_model'));
        $this->load->helper('functions');
        
        $setting_records = $this->Setting_model->get_data_by_cols('*', array(), 'result_array');      
        $this->globalSettingsRunningYear = fetch_parl_key_rec($setting_records,'running_year');
        $this->globalSettingsLocation = fetch_parl_key_rec($setting_records,'location');
        $this->globalSettingsAppPackageName = fetch_parl_key_rec($setting_records,'app_package_name');
        $this->globalSettingsSystemTitle = fetch_parl_key_rec($setting_records,'system_title');
        $this->globalSettingsSystemName = fetch_parl_key_rec($setting_records,'system_name');
        $this->globalSettingsSystemEmail = fetch_parl_key_rec($setting_records,'system_email');
        $this->globalSettingsSystemFCMServerrKey = fetch_parl_key_rec($setting_records,'fcm_server_key');
        $this->globalSettingsSkinColour = fetch_parl_key_rec($setting_records,'skin_colour');
        $this->globalSettingsTextAlign = fetch_parl_key_rec($setting_records,'text_align');
        $this->globalSettingsActiveSmsService = fetch_parl_key_rec($setting_records,'active_sms_service');
        $this->globalSettingsActiveSms = $this->globalSettingsActiveSmsService;
       
        $this->session->set_userdata(array(
            'running_year' => $this->globalSettingsRunningYear,
        ));

        $this->load->model("fees/Assets_model");
        
    }
    /***default functin, redirects to login page if no admin logged in yet** */

    public function index() {
        if(($this->session->userdata('school_admin_login') == 1) || ($this->session->userdata('accountant_login') == 1)){
            $page_data = $this->get_page_data_var();
            
            $page_data['page_name'] = 'fees/assets/index';
            $page_data['page_title'] = 'assets';
            $page_data['data'] = $this->Assets_model->get_assets();        
            $page_data['arrAllLinks'] = $this->session->userdata('arrAllLinks');
            $this->load->view('backend/index', $page_data);    
        }else{
            redirect(base_url(), 'refresh');
        }        
    }

    function add(){
        if(($this->session->userdata('school_admin_login') == 1) || ($this->session->userdata('accountant_login') == 1)){
            $this->form_validation->set_rules('title', 'Title', 'trim|required');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');

             if ($this->form_validation->run() == FALSE){
                $this->session->set_flashdata('flash_message_error',validation_errors());
             } 
             else {
                $data = $this->input->post();
                $data['school_id'] = $this->session->userdata('school_id');            
                $id = $this->Assets_model->add($data);
                if($id){
                    $this->session->set_flashdata('flash_message','Assets has been added successfully');
                }else{
                    $this->session->set_flashdata('flash_message_error', get_phrase('something_went_wrong.'));
                }
             }
             redirect(base_url() . 'index.php?fees/assets', 'refresh');
        }else{
            redirect(base_url(), 'refresh');
        } 
    }

    function update($param1=''){
        if(($this->session->userdata('school_admin_login') == 1) || ($this->session->userdata('accountant_login') == 1)){
            $this->form_validation->set_rules('title', 'Title', 'trim|required');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');

            if($param1!=''){
                if ($this->form_validation->run() == FALSE){
                    $this->session->set_flashdata('flash_message_error',validation_errors());
                }else {
                    $data = $this->input->post();            
                    $this->Assets_model->do_update($data, $param1);
                    $this->session->set_flashdata('flash_message','Assets has been updated successfully');
                }
                redirect(base_url() . 'index.php?fees/assets', 'refresh');
            }else{
                redirect(base_url() . 'index.php?fees/assets', 'refresh');    
            }
        }else{
            redirect(base_url(), 'refresh');
        }                    
    }

    public function delete($id=''){
        if(($this->session->userdata('school_admin_login') == 1) || ($this->session->userdata('accountant_login') == 1)){
            $this->Assets_model->do_update(array('fi_assets_status'=> '0'), $id); 
            $this->session->set_flashdata('flash_message', get_phrase('Assets_has_been_deleted_successfully.'));        
            redirect(base_url() . 'index.php?fees/assets', 'refresh');
        }else{
            redirect(base_url(), 'refresh');
        }
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

// --------------------------------------------------------------------------
/* End of file Admin.php */
/* Location: ./application/controllers/Fees.php */


    
