<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Certificate extends CI_Controller {
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
        $this->load->model("Discussion_category_model");
        $this->load->model("Discussion_thread_model");
        $this->load->model("Discussion_post_model");
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

      /*
     * Total number of notification for today
     * 
     */
    public function get_no_of_notication() {
        $page_data= $this->get_page_data_var();
        $this->load->model("Notification_model");
        $user_notif_user        =   $this->Notification_model->get_notifications( 'push_notifications' , 'admin' );
        $user_notif_common      =   $this->Notification_model->get_notifications( 'push_notifications' );
        $total_count            =   count($user_notif_user)+count($user_notif_common);
        return $total_count;
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
    
    function template1($param1 = '', $param2 = '', $param3 = '', $param4 = ''){

    $page_data = $this->get_page_data_var();
    $page_data['certificate_design'] = "";
    if($param1 == 'download'){
    $this->load->model('Student_certificate_model');
    $this->load->model('Certificate_authorities_model');
    $page_data['certificate_detail'] = $this->Student_certificate_model->get_certificate_record($param2,$param3);
//    pre($page_data['certificate_detail']); die;
//    $authorities_id = $page_data['certificate_detail']->certificate_authorities; 
//    $data = array();
//            if (!empty($authorities_id)) {
//                $valu = explode(",", $authorities_id);
//                $count = count($valu);
//                for($i=0; $i<$count; $i++){
//                $data[] = $this->Certificate_authorities_model->get_data_by_id($valu[$i]);
//                }
//              $page_data['authorities'] = $data;
//            } else {
//                $page_data['authorities'] = '';
//            }
//    } else {
//        $page_data['certificate_design'] = "true";
//    }
//    
    }
    if("template1" == strtolower($page_data['certificate_detail']->template_type)){
      $page_data['page_name'] = "template1/".strtolower($page_data['certificate_detail']->template_type).'-'.$page_data['certificate_detail']->page_orientation.'-'.$page_data['certificate_detail']->page_size;    
    }
    $page_data['page_title'] = get_phrase($page_data['certificate_detail']->template_type.'-'.$page_data['certificate_detail']->page_orientation.'-'.$page_data['certificate_detail']->page_size);
    
    $page_data['design_certificate'] = "design_for_certificate";
//    echo $page_data['page_name']; die;
    $this->load->view('backend/index', $page_data);       
    }
    
    function teacher_template1($param1 = '', $param2 = '', $param3 = '', $param4 = ''){
    $page_data = $this->get_page_data_var();
    $page_data['certificate_design'] = "";
    if($param1 == 'download'){
    $this->load->model('Teacher_certificate_model');
    $this->load->model('Certificate_authorities_model');
    $page_data['certificate_detail'] = $this->Teacher_certificate_model->get_certificate_record($param2,$param3);
//    pre($page_data['certificate_detail']); die;
//    $authorities_id = $page_data['certificate_detail']->certificate_authorities; 
//    $data = array();
//            if (!empty($authorities_id)) {
//                $valu = explode(",", $authorities_id);
//                $count = count($valu);
//                for($i=0; $i<$count; $i++){
//                $data[] = $this->Certificate_authorities_model->get_data_by_id($valu[$i]);
//                }
//              $page_data['authorities'] = $data;
//            } else {
//                $page_data['authorities'] = '';
//            }
//    } else {
//        $page_data['certificate_design'] = "true";
//    }
//    
    }
    $page_data['page_title'] = get_phrase($page_data['certificate_detail']->template_type.'-'.$page_data['certificate_detail']->page_orientation.'-'.$page_data['certificate_detail']->page_size);
    $page_data['page_name'] = strtolower($page_data['certificate_detail']->template_type).'-'.$page_data['certificate_detail']->page_orientation.'-'.$page_data['certificate_detail']->page_size;
    $page_data['design_certificate'] = "design_for_certificate";
//    echo $page_data['page_name']; die;
    $this->load->view('backend/index', $page_data);
    }
}