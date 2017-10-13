<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Alumni extends CI_Controller {
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
    public function __construct() {
        parent::__construct();

//        $this->load->model("Alumni_model");
        $this->load->model('Enroll_model');
        
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
    /* * ****MANAGE OWN PROFILE AND CHANGE PASSWORD** */
    
        public function register($param1 = '') {
//        pre($this->input->post()); die;
//        echo "sucess"; die;
//        $page_data= $this->get_page_data_var();
        if($param1=='create'){ 
            
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'Email Address', 'xss_clean|trim|required|valid_email|is_unique[alumni.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required');
        $this->form_validation->set_rules('enroll_no', 'Enroll Code', 'trim|required');
        $this->form_validation->set_rules('class_name', 'Class Name', 'trim|required');
        $this->form_validation->set_rules('year', 'Year', 'trim|required');
        if ($this->form_validation->run() == FALSE) {            
            $this->session->set_flashdata('flash_message', validation_errors());            
            redirect(base_url());
        } else {
            $data['name'] = $this->input->post('name');
            $data['last_name'] = $this->input->post('lname');
            $data['middle_name'] = $this->input->post('mname');
            $data['email'] = $this->input->post('email');
            $data['password'] = $this->input->post('password');
            $data['gender'] = $this->input->post('gender');
            $data['date_of_birth'] = $this->input->post('dob');
            $data['enroll_code'] = $this->input->post('enroll_no');
            $data['class'] = $this->input->post('class_name');
            pre($data); die;
            $this->Alumni_model->add($data);
        $this->session->set_flashdata('flash_message', "You Are Successfully Registered And Check Mail For Login.");
            redirect(base_url()); 
        }        
        }     
    }

       
}
