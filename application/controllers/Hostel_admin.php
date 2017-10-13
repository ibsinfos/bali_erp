<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Hostel_admin extends CI_Controller{
    
    
    function __construct(){
        parent::__construct();
		$this->load->database();
                $this->load->model("Setting_model");
                $this->load->library('session');
        /*cache control*/
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        //$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        //$this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        $this->globalSettingsSMSDataArr=get_data_generic_fun('settings','description',array('condition_type'=>'in','condition_in_col'=>'type','condition_in_data'=>'location,app_package_name,running_year,system_name'));
    }
    
    /***default functin, redirects to login page if no admin logged in yet***/
    public function index(){
        if ($this->session->userdata('hostel_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($this->session->userdata('hostel_login') == 1)
            redirect(base_url() . 'index.php?hostel_admin/dashboard', 'refresh');
    }
    
    /***ADMIN DASHBOARD***/
    function dashboard(){
        if ($this->session->userdata('hostel_login') != 1)
            redirect(base_url(), 'refresh'); 
        $page_data['page_name']  = 'dashboard';
        $page_data['page_title'] = get_phrase('hostel_dashboard');
        $page_data['account_type'] = $this->session->userdata('login_type');
         //Get Setting Records
        $page_data['system_name'] = $this->Setting_model->get_setting_record(array('type' => 'system_name'), 'description');
        $page_data['system_title'] = $this->Setting_model->get_setting_record(array('type' => 'system_title'), 'description');
        $page_data['text_align'] = $this->Setting_model->get_setting_record(array('type' => 'text_align'), 'description');
        $page_data['skin_colour'] = $this->Setting_model->get_setting_record(array('type' => 'skin_colour'), 'description');
        $page_data['active_sms_service'] = $this->Setting_model->get_setting_record(array('type' => 'active_sms_service'), 'description');
        $page_data['running_year'] = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
        $this->load->view('backend/index_new', $page_data);
    }
    
     function student_list($param1='',$param2='',$param3=''){
        if ($this->session->userdata('hostel_login') != 1)
            redirect(base_url(), 'refresh');      
        $page_data['page_title']            =   get_phrase('student_list');
        $page_data['page_name']             =   'student_list';
        $this->load->view('backend/index', $page_data); 
    }
    
    /* * ****MANAGE OWN PROFILE AND CHANGE PASSWORD** */

    function manage_profile($param1 = '', $param2 = '', $param3 = '') {
        $this->load->model('Hostel_admin_model');
        if ($this->session->userdata('hostel_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        if ($param1 == 'update_profile_info') {
            $data['name'] = $this->input->post('name');
            $data['email'] = $this->input->post('email');       
            $file_name          =   $_FILES['userfile']['name'];        
            $ext                =   explode( ".", $file_name );
            $user_id            =   $this->session->userdata('hostel_admin_id');
            $data['image']      =   $user_id.".".end($ext);

            if($this->Hostel_admin_model->update_profile($data, $user_id)){
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/hostel_admin_image/' . $data['image']);
                $this->session->set_flashdata('flash_message', get_phrase('account_details_updated'));
                 redirect(base_url() . 'index.php?hostel_admin/manage_profile/', 'refresh'); 

            }else{
                $this->session->set_flashdata('flash_message_error', get_phrase('account_details_not!!'));
                redirect(base_url() . 'index.php?hostel_admin/manage_profile/', 'refresh'); 
            }
        }

        if ($param1 == 'change_password') {
            $data['password'] = sha1($this->input->post('password'));
            $data['new_password'] = sha1($this->input->post('new_password'));
            $data['confirm_new_password'] = sha1($this->input->post('confirm_new_password'));        
            $current_password = get_data_generic_fun('hostel_admin', 'password',array('hostel_admin_id' => $this->session->userdata('hostel_admin_id')),'result_arr');        
            $curr_pwsd = $current_password[0]['password'];        

            if ($curr_pwsd == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {
                $this->Hostel_admin_model->updatehosteladmin_password($data['new_password'], $this->session->userdata('hostel_admin_id'));
                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
            } else {
                $this->session->set_flashdata('flash_message', get_phrase('password_mismatch'));
            }
            redirect(base_url() . 'index.php?hostel_admin/manage_profile/', 'refresh');
        }

//        $page_data['total_notif_num']  =   $this->get_no_of_notication();
        $page_data['page_name'] = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data']  = get_data_generic_fun('hostel_admin', '*',array('hostel_admin_id' => $this->session->userdata('hostel_admin_id')),'result_arr');  
        $this->load->view('backend/index', $page_data);
    }

}