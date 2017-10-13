<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 	
 * 
 *  Module : Bus Admin
 *  Details : Controller for Bus Admin
 * 
 */

class Bus_admin extends CI_Controller {
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
        $this->load->database();
        $this->load->library('session');
        $this->load->library('form_validation');
        /* cache control */
        //$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        //$this->output->set_header('Pragma: no-cache');

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

        $this->load->model('Bus_driver_modal');
        if ($this->session->userdata('bus_admin_login') != 1) {
            redirect(base_url(), 'refresh');
        }
        date_default_timezone_set('Asia/Dubai');
    }

    public function dashboard() {
        $page_data= $this->get_page_data_var();
        $page_data['page_name'] = 'dashboard';
        $page_data['page_title'] = get_phrase('bus_admin_dashboard');
        $page_data['account_type'] = $this->session->userdata('login_type');
        $this->load->view('backend/index_new', $page_data);
    }
    
    public function bus_drivers() {
        $page_data= $this->get_page_data_var();
        $page_data['page_name'] = 'bus_driver';
        $page_data['page_title'] = get_phrase('bus_driver');
        $page_data['list_drivers'] = get_data_generic_fun('bus_driver','*', array(), 'result_array');
        //$page_data['list_drivers'] = $this->Bus_driver_modal->list_drivers();
        $this->load->view('backend/index', $page_data);
    }
    
    public function driver_attendence() {
        $page_data= $this->get_page_data_var();
        $page_data['page_name'] = 'manage_attendence';
        $page_data['page_title'] = get_phrase('manage_attendence');
        //$page_data['list_drivers'] = $this->Bus_driver_modal->list_drivers();
        $page_data['list_drivers'] = get_data_generic_fun('bus_driver','*', array(), 'result_array');
        $this->load->view('backend/index', $page_data);
    }
    
    public function driver_attendence_view() {
        $page_data= $this->get_page_data_var();
        $driver_id = $this->input->post('driver_id');
        $month = $this->input->post('month');
        $date = $month.'/'.date('y');
        $page_data['attendence_morning'] = $this->Bus_driver_modal->get_driver_attendence_morning($driver_id, $date);
        $page_data['attendence_evening'] = $this->Bus_driver_modal->get_driver_attendence_evening($driver_id, $date);
        //$page_data['list_drivers'] = $this->Bus_driver_modal->list_drivers();
        $page_data['list_drivers'] = get_data_generic_fun('bus_driver','*', array(), 'result_array');
        $page_data['trips'] = $this->Bus_driver_modal->get_num_of_groups($driver_id);
        $page_data['month'] = $month;
        $page_data['driver_id'] = $driver_id;
        $page_data['page_name'] = 'manage_attendence_view';
        $page_data['page_title'] = get_phrase('manage_attendence');
        $this->load->view('backend/index', $page_data);
    }
    
    public function add_bus_driver($param1='') {
        $page_data= $this->get_page_data_var();
        if ($param1 == 'create') {
            $this->form_validation->set_rules('name', 'Driver Name', 'trim|required');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('phone', 'Phone Number', 'required|numeric|max_length[12]|min_length[10]');
            $this->form_validation->set_rules('bus_id', 'Bus', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[bus_driver.email]');   
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('flash_message_error', validation_errors());
                redirect(base_url() . 'index.php?bus_admin/bus_drivers');
            } else {
                $data['name']       =   $this->input->post('name');
                $data['email']      =   $this->input->post('email');
                $data['password']   =   sha1($this->input->post('password'));
                $data['phone']      =   $this->input->post('phone');
                $data['sex']        =   $this->input->post('gender');
                $data['bus_id']     =   $this->input->post('bus_id');
                //echo '<pre>'; print_r($data); exit;
                if($this->Bus_driver_modal->save_bus_driver($data)){
                    $this->session->set_flashdata('flash_message', get_phrase('bus_driver_added_successfully'));
                }else{
                    $this->session->set_flashdata('flash_message', get_phrase('data_not_added_successfully'));
                }
                //$this->Email_model->account_opening_email('parent', $data['email'], $this->input->post('password')); //SEND EMAIL ACCOUNT OPENING EMAIL
                redirect(base_url() . 'index.php?bus_admin/bus_drivers', 'refresh');
            }
        }        
    }
    
    function manage_profile($param1 = '', $param2 = '', $param3 = ''){
        $page_data= $this->get_page_data_var();        
        $bus_Admin_id             =   $this->session->userdata('login_user_id');
        if ($param1 == 'update_profile_info') { 
            $data['name']     = $this->input->post('name');
            $data['address']  = $this->input->post('address');
            $data['birthday'] = $this->input->post('birthday');
            $data['sex']      = $this->input->post('sex');
            $this->db->where('bus_administrator_id', $bus_Admin_id);
            $this->db->update('bus_administrator', $data);
            $this->session->set_flashdata('flash_message', get_phrase('account_updated'));
            redirect(base_url() . 'index.php?bus_admin/manage_profile/', 'refresh');
        }
        if ($param1 == 'change_password') {            
            $data['password']               =   sha1($this->input->post('password'));
            $data['new_password']           =   sha1('bus'.$this->input->post('new_password'));
            $data['confirm_new_password']   =   sha1('bus'.$this->input->post('confirm_new_password'));
            $current_password               =   $this->Student_model->get_student_record(
                    array('student_id' => $bus_Admin_id ) , 'password');
            if ($current_password == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {
                $this->Student_model->update_student(array('password' => $data['new_password'], 'passcode' => 'stu'.$this->input->post('new_password')), 
                        array('student_id'=>$bus_Admin_id));
                
                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('password_mismatch'));
            }
            redirect(base_url() . 'index.php?bus_admin/manage_profile/', 'refresh');
        }
        
        $page_data['page_name']  = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $bus_admin_details        =   $this->db->get_where('bus_administrator', array(
            'bus_administrator_id' => $this->session->userdata('login_user_id')
        ))->result_array();
        $page_data['edit_data']  = array_shift($bus_admin_details);
        //echo '<pre>'; print_r($page_data['edit_data']); exit;
        $this->load->view('backend/index', $page_data);
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
