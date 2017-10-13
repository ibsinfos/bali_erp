<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Gallery extends CI_Controller{
    
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
    
    function __construct(){
        parent::__construct();
		$this->load->database();
                $this->load->model("Setting_model");
                $this->load->library('session');
        /*cache control*/
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');

        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        $this->globalSettingsSMSDataArr=get_data_generic_fun('settings','description',array('condition_type'=>'in','condition_in_col'=>'type','condition_in_data'=>'location,app_package_name,running_year,system_name'));
    }
    
    /***default functin, redirects to login page if no admin logged in yet***/
    public function index(){
        if ($this->session->userdata('school_admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($this->session->userdata('school_admin_login') == 1)
            redirect(base_url() . 'index.php?school_admin/dashboard', 'refresh');
        
        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'Photo Gallery';
        $page_data['page_title'] = get_phrase('photo_gallery');

        $page_data['gallery_data'] = $this->Gallery_model->get_gallery_photos();
        $this->load->view('backend/index', $page_data);
    }
    
    public function add_photos(){
        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'gallery/add_photos';
        $page_data['page_title'] = get_phrase('add_photos');
        
        $this->form_validation->set_rules('running_year', 'Current running year', 'trim|required');
        $this->form_validation->set_rules('name', 'Type Name', 'trim|required|_unique_sch[refund_types.name]');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_error_delimiters('', '');
        
        if ($this->form_validation->run() == TRUE) {
            $data['name'] = $this->input->post('name');
            $data['description'] = $this->input->post('description');
            $data['running_year'] = $this->input->post('running_year');
            $data['school_id'] = ($this->session->userdata('school_id') && $this->session->userdata('school_id')>0)?$this->session->userdata('school_id'):0;
            $data['created'] = date('Y-m-d H:i:s');
            $data['updated'] = date('Y-m-d H:i:s');
            $return = $this->Refund_model->save_refund_type($data);
                
            if($return){
                $this->session->set_flashdata('flash_message', get_phrase('refund_type_has_been_saved_successfully.'));
                redirect(base_url() . 'index.php?fees/refund/refund_types/', 'refresh');
            } else {
                $page_data['form_error'] = 1;
                $this->session->set_flashdata('flash_message_error', get_phrase('Invalid details.'));
            }
        } else {
            $page_data['form_error'] = 1;
            $this->session->set_flashdata('flash_message_error', validation_errors());
        }
        $page_data['form_error'] = 1;
        //$page_data['refund_types'] = $this->Refund_model->get_refund_types();
        $this->load->view('backend/index', $page_data);
    }
    
    function get_page_data_var() {
        $this->load->model('Crud_model');
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
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
        $page_data['system_logo'] = $this->Setting_model->get_setting_record(array('type' => 'system_logo','school_id' => $school_id),'description');
        return $page_data;
    }
}