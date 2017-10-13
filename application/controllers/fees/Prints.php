<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prints extends CI_Controller {

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
    /***default functin, redirects to login page if no admin logged in yet** */

    function index() {
        //redirect(base_url() . 'index.php?fees/list', 'refresh');
    }

    /************************Print*******************************/
    function pay_receipt_setting(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $pay_receipt_print_type = $this->db->get_where('settings',array('type'=>'pay_receipt_print_type','school_id'=>_getSchoolid()))->row();   
            if($pay_receipt_print_type){
                $this->db->update('settings',array('description'=>$this->input->post('print_type')),array('settings_id'=>$pay_receipt_print_type->settings_id));    
            }else{
                $this->db->insert('settings',array('type'=>'pay_receipt_print_type',
                                                   'description'=>$this->input->post('print_type'),
                                                   'school_id'=>_getSchoolid())); 
            }

            $pay_receipt_print_size = $this->db->get_where('settings',array('type'=>'pay_receipt_print_size','school_id'=>_getSchoolid()))->row();   
            if($pay_receipt_print_size){    
                $this->db->update('settings',array('description'=>$this->input->post('print_size')),array('settings_id'=>$pay_receipt_print_size->settings_id));    
            }else{
                $this->db->insert('settings',array('type'=>'pay_receipt_print_size','description'=>$this->input->post('print_size'),'school_id'=>_getSchoolid())); 
            }
        }

        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'fees/print/pay-receipt-setting';
        $page_data['page_title'] = get_phrase('pay_receipt_setting');
        $page_data['account_type'] = $this->session->userdata('login_type');
        $this->load->view('backend/index', $page_data);
    }

    function invoice_setting(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $invoice_print_size = $this->db->get_where('settings',array('type'=>'invoice_print_size','school_id'=>_getSchoolid()))->row();   
            if($invoice_print_size){    
                $this->db->update('settings',array('description'=>$this->input->post('print_size')),array('settings_id'=>$invoice_print_size->settings_id));    
            }else{
                $this->db->insert('settings',array('type'=>'invoice_print_size','description'=>$this->input->post('print_size'),'school_id'=>_getSchoolid())); 
            }
        }

        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'fees/print/invoice-setting';
        $page_data['page_title'] = get_phrase('invoice_setting');
        $page_data['account_type'] = $this->session->userdata('login_type');
        $this->load->view('backend/index', $page_data);
    }
    
    function preview($type=false,$size='A4'){
        $page_data = array();
        if($type=='invoice'){
            $page_data['rcpt'] = $page_data['print_type'] = 'Invoice';
            $page_data['PAGE_SIZE'] = $size;
            $page_name = 'fees/print/preview-invoice'; 
        }else if($type=='thermal-pay-receipt'){
            $page_data['rcpt'] = $page_data['print_type'] = 'Receipt';
            $page_name = 'fees/print/preview-thermal-pay-receipt';
        }else{
            $page_data['rcpt'] = $page_data['print_type'] = 'Receipt';
            $page_data['PAGE_SIZE'] = $size;
            $page_name = 'fees/print/preview-pay-receipt'; 
        }

        $this->load->view('backend/school_admin/'.$page_name,$page_data);
    }

    function pay_receipt($receipt_id=false){
        $page_data = $this->get_page_data_var();
        $receipt = $this->Ajax_model->get_pay_trans(array('PT.id'=>$receipt_id));
        if(!$receipt){
            redirect('/');
        }
        //echo '<pre>';print_r( $receipt);exit;

        $page_data['receipt'] = $receipt;
        $collection_record = $this->Ajax_model->get_fee_collection_record(array('id'=>$receipt->pay_collection_record_id));
        //$page_data['trans_items'] = $this->Ajax_model->get_payment_item_trans(array('pay_trans_id'=>$receipt->id));
        $page_data['stu_status'] = $collection_record->student_status;
        if($collection_record->student_status==1){
            $page_data['student'] = $this->Ajax_model->get_student(array('S.student_id'=>$receipt->student_id));
            $page_data['page_name'] = 'fees/print/'.sett('pay_receipt_print_type');
        }else{
            $page_data['student'] = $this->Ajax_model->get_non_enroll_student(array('enquired_student_id'=>$receipt->student_id));
            $page_data['page_name'] = 'fees/print/'.sett('pay_receipt_print_type').'-non-enroll';
        }
        $page_data['page_title'] = get_phrase('print_pay_receipt'); 
        $page_data['print_type'] = 'Receipt';
        $page_data['account_type'] = $this->session->userdata('login_type');
        $this->load->view('backend/school_admin/'.$page_data['page_name'], $page_data);
    }

    function invoice($invoice_id=false){
        $page_data = $this->get_page_data_var();
        $page_data['invoice'] = $invoice = $this->db->get_where('fee_invoices',array('id'=>$invoice_id))->row();
        if(!$invoice){
            redirect('/');
        }
        $page_data['student'] = $this->Ajax_model->get_student(array('S.student_id'=>$invoice->student_id));
        $page_data['invoice_items'] = $this->db->get_where('fee_invoice_items',array('invoice_id'=>$invoice_id))->result();

        //$page_data['receipt'] = $receipt;
        //$collection_record = $this->Ajax_model->get_fee_collection_record(array('id'=>$receipt->pay_collection_record_id));
        //$page_data['trans_items'] = $this->Ajax_model->get_payment_item_trans(array('pay_trans_id'=>$receipt->id));
        
        $page_data['page_title'] = get_phrase('fee_invoice'); 
        $page_data['rcpt'] = $page_data['print_type'] =  'Invoice';
        $page_data['running_year'] = $invoice->running_year;
        $this->load->view('backend/school_admin/fees/print/invoice', $page_data);
    }


    function pdf_pay_receipt($receipt_id=false){
        $receipt = $this->Ajax_model->get_pay_trans(array('PT.id'=>$receipt_id));
        if(!$receipt){
            redirect('/');
        }

        $page_data = $this->get_page_data_var();
        $page_data['receipt'] = $receipt;
        $page_data['student'] = $this->Ajax_model->get_student(array('S.student_id'=>$receipt->student_id));
       
        $page_data['page_name'] = 'fees/print/pay-receipt';
        $page_data['page_title'] = get_phrase('print_pay_receipt');
        $page_data['rcpt'] = 'Receipt';
        $page_data['account_type'] = $this->session->userdata('login_type');
        $page_html = $this->load->view('backend/school_admin/'.$page_data['page_name'], $page_data,true);
        $this->print_pdf($page_html);
    }

    function pdf($html=false,$url=false){
        require_once(APPPATH.'/libraries/TCPDF/config/tcpdf_config.php');
        require_once(APPPATH.'/libraries/TCPDF/tcpdf.php');
        ob_start();
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        //$pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('Receipt');
        //$pdf->SetSubject('TCPDF Tutorial');
        //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        
        // set default header data
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);
        
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        
        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        
        
        // ---------------------------------------------------------
        
        // set font
        $pdf->SetFont('dejavusans', '', 10);
        
        // add a page
        $pdf->AddPage();
        
        // writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
        // writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
        
        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');
        
        //Close and output PDF document
        $pdf->Output('example_006.pdf', 'I');
    }
    
    
    function employee_payslip($payslip_id=false){
        $page_data = $this->get_page_data_var();
        $query = "SELECT ES.*,ESD.*,PP.id payslip_id,PP.generate_date,PP.net_pay FROM main_employees_summary ES 
        LEFT JOIN main_empsalarydetails AS ESD ON ESD.user_id = ES.user_id 
        LEFT JOIN payroll_payslip AS PP ON PP.emp_id=ES.user_id
        WHERE ES.school_id = '".$this->school_id."' AND PP.id IS NOT NULL AND PP.id = $payslip_id";
        $page_data['psrec'] = $psrec = $this->db->query($query)->row();


        $query = "SELECT PPD.*,PC.name FROM payroll_payslip_details PPD 
                LEFT JOIN payroll_category AS PC ON PC.payroll_category_id = PPD.payroll_category_id 
                WHERE PPD.school_id = '".$this->school_id."' AND PC.type=0 AND PPD.payroll_payslip_id=".$psrec->payslip_id;
        $page_data['earngs'] = $this->db->query($query)->result();

        $query = "SELECT PPD.*,PC.name FROM payroll_payslip_details PPD 
                LEFT JOIN payroll_category AS PC ON PC.payroll_category_id = PPD.payroll_category_id 
                WHERE PPD.school_id = '".$this->school_id."' AND PC.type=1 AND PPD.payroll_payslip_id=".$psrec->payslip_id;
        $page_data['dedcs'] = $this->db->query($query)->result();

        $query = "SELECT EL.emp_leave_limit,EL.used_leaves,EL.alloted_year FROM main_employeeleaves EL 
                WHERE EL.user_id ='".$psrec->user_id."' AND EL.school_id = '".$this->school_id."'";
        $page_data['empleave'] = $empleave =  $this->db->query($query)->row();
        //echo '<pre>';print_r($empleave);exit;

        if($empleave && ($empleave->emp_leave_limit >= $empleave->used_leaves)) { 
            $lop=0;
        }else{
            $lop = $empleave?($empleave->used_leaves-$empleave->emp_leave_limit):0;
        }
        $page_data['lop_days'] = $lop;

        $salaryPerDay=number_format(decrypt_salary($psrec->salary)/30,2);
        $lop_amt = $salaryPerDay*$lop;
        $page_data['lop_amt'] = $lop_amt;

        //$page_data['payslip'] = $receipt;
        $page_data['page_name'] = 'fees/print/payslip';
        $page_data['page_title'] = get_phrase('print_payslip');
        $page_data['rcpt'] = 'Receipt';
        $page_data['account_type'] = $this->session->userdata('login_type');
        $this->load->view('backend/school_admin/'.$page_data['page_name'], $page_data);
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


    
