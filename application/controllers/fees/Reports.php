<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reports extends CI_Controller {

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
    public $school_id;
    public $running_year;
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('Setting_model','Class_model','fees/Fees_model','fees/Ajax_model','fees/Refund_model'));
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
        $this->running_year = $this->session->userdata('running_year');
        $this->school_id = $this->session->userdata('school_id');

        if ($this->session->userdata('school_admin_login') != 1 && $this->session->userdata('accountant_login') != 1 && $this->session->userdata('cashier_login') != 1){
            redirect(base_url(), 'refresh');
        }  
    }

    function index() {
        
    }

    /************************Other Functions*******************************/
    public function class_wise_dues(){
        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'fees/reports/class-wise-fee-report';
        $page_data['page_title'] = get_phrase('class_wise_fee_report');
        $page_data['account_type'] = $this->session->userdata('login_type');
        $page_data['classes'] = $this->Fees_model->get_classes();
        $this->load->view('backend/index', $page_data);
    }

    public function term_wise_dues(){
        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'fees/reports/term-wise-fee-report';
        $page_data['page_title'] = get_phrase('term_wise_fee_report');
        $page_data['account_type'] = $this->session->userdata('login_type');
        $page_data['classes'] = $this->Fees_model->get_classes();
        $this->load->view('backend/index', $page_data);
    }

    public function student_wise_dues(){
        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'fees/reports/student-wise-fee-report';
        $page_data['page_title'] = get_phrase('student_wise_fee_report');
        $page_data['account_type'] = $this->session->userdata('login_type');
        $page_data['classes'] = $this->Fees_model->get_classes();
        $this->load->view('backend/index', $page_data);
    }

    function transaction(){
        $page_data = $this->get_page_data_var();
        $page_data['report_generated'] = false;
        $page_data['from_date'] = date('Y-m-d');
        $page_data['to_date'] = date('Y-m-d');
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $page_data['report_generated'] = true;
            $page_data['donations'] = 0;
            $page_data['school_fee'] = 0;
            $page_data['salary'] = 0;

            $page_data['from_date'] = $from_date = $this->input->post('from_date');
            $page_data['to_date'] = $to_date = $this->input->post('to_date');
            $donations = $this->db->get_where('donation',array('donation_date >='=>date('m/d/Y',strtotime($from_date)),
                                                                'donation_date <='=>date('m/d/Y',strtotime($to_date))))->result();
            foreach($donations as $donate){
                $page_data['donations'] += $donate->amount;
            }
            
            $payments = $this->db->get_where('fee_pay_transactions',array('DATE(created) >='=>$from_date,'DATE(created) <='=>$to_date))->result();
            foreach($payments as $pay){
                $page_data['school_fee'] += $pay->paid_amount;
            }
            
        }

        $page_data['page_name'] = 'fees/reports/transaction-report';
        $page_data['page_title'] = get_phrase('transaction_report');
        $page_data['account_type'] = $this->session->userdata('login_type');
        $this->load->view('backend/index', $page_data);
    }

    function compare_transaction(){
        $page_data = $this->get_page_data_var();
        $page_data['report_generated'] = false;
        $page_data['from_date'] = date('Y-m-d');
        $page_data['to_date'] = date('Y-m-d');
        $page_data['from_date2'] = date('Y-m-d');
        $page_data['to_date2'] = date('Y-m-d');
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $page_data['report_generated'] = true;
            $page_data['from_date'] = $from_date = $this->input->post('from_date');
            $page_data['to_date'] = $to_date = $this->input->post('to_date');
            $page_data['from_date2'] = $from_date2 = $this->input->post('from_date2');
            $page_data['to_date2'] = $to_date2 = $this->input->post('to_date2');

            $page_data['donations'] = 0;
            $page_data['school_fee'] = 0;
            $page_data['salary'] = 0;
            $page_data['donations2'] = 0;
            $page_data['school_fee2'] = 0;
            $page_data['salary2'] = 0;

            //First Date
            $donations = $this->db->get_where('donation',array('donation_date >='=>date('m/d/Y',strtotime($from_date)),
                                                                'donation_date <='=>date('m/d/Y',strtotime($to_date))))->result();
            foreach($donations as $donate){
                $page_data['donations'] += $donate->amount;
            }
            
            $payments = $this->db->get_where('fee_pay_transactions',array('DATE(created) >='=>$from_date,'DATE(created) <='=>$to_date))->result();
            foreach($payments as $pay){
                $page_data['school_fee'] += $pay->paid_amount;
            }
            
            
            $donations = $this->db->get_where('donation',array('donation_date >='=>date('m/d/Y',strtotime($from_date2)),
                                                            'donation_date <='=>date('m/d/Y',strtotime($to_date2))))->result();
            foreach($donations as $donate){
                $page_data['donations2'] += $donate->amount;
            }

            $payments = $this->db->get_where('fee_pay_transactions',array('DATE(created) >='=>$from_date2,'DATE(created) <='=>$to_date2))->result();
            foreach($payments as $pay){
                $page_data['school_fee2'] += $pay->paid_amount;
            }

        }

        $page_data['page_name'] = 'fees/reports/compare-transaction-report';
        $page_data['page_title'] = get_phrase('compare_transaction_report');
        $page_data['account_type'] = $this->session->userdata('login_type');
        $this->load->view('backend/index', $page_data);
    }

    function fee_receipts(){
        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'fees/reports/transaction-report';
        $page_data['page_title'] = get_phrase('transaction_report');
        $page_data['account_type'] = $this->session->userdata('login_type');
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

// --------------------------------------------------------------------------
/* End of file Admin.php */
/* Location: ./application/controllers/Fees.php */


    
