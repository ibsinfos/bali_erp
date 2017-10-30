<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Refund extends CI_Controller {

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
        $this->load->model(array('Setting_model','Class_model','fees/Refund_model','fees/Fees_model','fees/Ajax_model'));
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
        
    }
    /***default functin, redirects to login page if no admin logged in yet** */

    public function index() {
        //pre($this->session->userdata());die;
        //redirect(base_url() . 'index.php?fees/list', 'refresh');
        /* if ($this->session->userdata('cashier_login') != 1 && $this->session->userdata('accountant_login') != 1){
            redirect(base_url(), 'refresh');
        } */

        /* $page_data = $this->get_page_data_var();
        $page_data['NotApproveData'] = $this->Refund_model->get_non_approve_refund_list($this->session->userdata('login_user_id'));
        $page_data['ApproveData'] = $this->Refund_model->get_approve_refund_list($this->session->userdata('login_user_id'));
        $page_data['page_name'] = 'fees/refund_list';
        $page_data['page_title'] = 'refund_list';
                
        $page_data['arrAllLinks'] = $this->session->userdata('arrAllLinks');
        $this->load->view('backend/index', $page_data);  */

        
        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'fees/refund-list';
        $page_data['page_title'] = get_phrase('refund_list');
        $page_data['account_type'] = $this->session->userdata('login_type');
        $page_data['records'] = $this->Refund_model->get_refund_list();
        $this->load->view('backend/index', $page_data); 
    }


    public function request($param1='', $param2='') {
        //redirect(base_url() . 'index.php?fees/list', 'refresh');
        /* if (($this->session->userdata('cashier_login') == 1) || ($this->session->userdata('accountant_login') == 1))
            redirect('/', 'refresh');    */
            
        $page_data = $this->get_page_data_var();

        $page_data['data'] =array();
        if(($param1=='search')&&((trim($param2)!=''))){
            $this->load->model("Student_model");
            $this->load->model("Fees/Fees_model");
            $page_data['data'] = $this->Student_model->get_student4_fi(strtolower(trim($param2)));

            $page_data['CollectionData'] = $this->Fees_model->get_collection_data();
            $page_data['RefundRule'] = $this->Refund_model->get_refund_rule();
            //pre($page_data['RefundRule']);die;
        }else if($param1=='add'){
            //pre($this->input->post());die;
            $data = $this->input->post();
            
            if($this->session->userdata('login_type') == 'cashier'){
                $data['requester_type'] = '1' ;
            }else if($this->session->userdata('login_type') == 'accountant'){
                $data['requester_type'] = '2' ;
            }

            $data['requester_cashier_id'] = $this->session->userdata('login_user_id');
            $data['request_to_id'] = '1';
            $data['school_id'] = $this->session->userdata('school_id');

            $id = $this->Refund_model->save_refund_request($data);

            if($id){
                $this->session->set_flashdata('flash_message', get_phrase('request_has_been_sent_successfully.'));
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('something_went_wrong.'));
            }
            redirect(base_url() . 'index.php?fees/refund/request', 'refresh');

        }

        $page_data['page_name'] = 'fees/refund';
        $page_data['page_title'] = 'refund';
        $page_data['running_year'] = $this->globalSettingsRunningYear;
                
        $page_data['arrAllLinks'] = $this->session->userdata('arrAllLinks');
        $this->load->view('backend/index', $page_data);
    }

    public function refund_types(){
        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'fees/refund_types';
        $page_data['page_title'] = get_phrase('refund_types');

        $page_data['refund_types'] = $this->Refund_model->get_refund_types();
        $this->load->view('backend/index', $page_data);
    }

    public function refund_type_create(){
        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'fees/refund_types';
        $page_data['page_title'] = get_phrase('refund_types_create');
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
        $page_data['refund_types'] = $this->Refund_model->get_refund_types();
        $this->load->view('backend/index', $page_data);
    }
    
    public function refund_type_edit($type_id){        
        $page_data = $this->get_page_data_var();
        
        $page_data['page_name'] = 'fees/refund_type_edit';
        $page_data['page_title'] = get_phrase('refund_types');
        $page_data['type_id'] = $type_id;
        
        $this->form_validation->set_rules('running_year', 'Current running year', 'trim|required');
        $this->form_validation->set_rules('name', 'type Name', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_error_delimiters('', '');
        
        if ($this->form_validation->run() == TRUE) {
            $data['name'] = $this->input->post('name');
            $data['description'] = $this->input->post('description');
            $data['running_year'] = $this->input->post('running_year');
            
            $return = $this->Refund_model->update_refund_type($data,$type_id);
                
            if($return){
                $this->session->set_flashdata('flash_message', get_phrase('refund_type_has_been_updated_successfully.'));
                redirect(base_url() . 'index.php?fees/refund/refund_types/', 'refresh');
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('Invalid details'));
            }
        } else {
            $this->session->set_flashdata('flash_message_error', validation_errors());
        }
        $refund_type_data = $this->Refund_model->get_single_refund_type($type_id);
        $page_data['refund_type_data'] = @$refund_type_data[0];
        $this->load->view('backend/index', $page_data);
    }
    
    public function deleterefundtype($type_id){

        $page_data = $this->get_page_data_var();
        $return = $this->Refund_model->deleteRefundType(array('id'=>$type_id)); 
        if($return) {
            $this->session->set_flashdata('flash_message', get_phrase('refund_type_has_been_deleted_successfully.'));
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('Error in deletion.'));
        }
        
        redirect(base_url() . 'index.php?fees/refund/refund_types/', 'refresh');
    }
    
    public function refund_rules(){
        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'fees/refund_rules';
        $page_data['page_title'] = get_phrase('refund_rules');

        $page_data['fee_groups'] = $this->Fees_model->get_fee_groups();
        $page_data['term_types'] = $this->Fees_model->get_fee_terms();
        $page_data['refund_rules'] = $this->Refund_model->get_refund_rules();
        $this->load->view('backend/index', $page_data);
    }
    
    public function refund_rule_create(){        
        $page_data = $this->get_page_data_var();
        $this->form_validation->set_rules('running_year', 'Current running year', 'trim|required');
        $this->form_validation->set_rules('name', 'Type Name', 'trim|required|_unique_sch[refund_rules.name]');
        $this->form_validation->set_rules('fee_group_id', 'Fee Group', 'trim|required');
        $this->form_validation->set_rules('term_type_id', 'Term Type', 'trim|required');
        $this->form_validation->set_rules('term_type_id', 'Term Type', 'trim|required');
        $this->form_validation->set_rules('valid_from', 'Valid from', 'trim|required');
        $this->form_validation->set_rules('valid_to', 'Valid to', 'trim|required');
        $this->form_validation->set_rules('amount_type', 'Amount type', 'trim|required');
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
        $this->form_validation->set_error_delimiters('', '');
        
        if ($this->form_validation->run() == TRUE) {
            $data['name'] = $this->input->post('name');
            $data['fee_group_id'] = $this->input->post('fee_group_id');
            $data['term_type_id'] = $this->input->post('term_type_id');
            $data['setup_term_id'] = $this->input->post('setup_term_id');
            $data['valid_from'] = date('Y-m-d H:i:s',strtotime($_POST['valid_from']));
            $data['valid_to'] = date('Y-m-d H:i:s',strtotime($_POST['valid_to']));
            $data['amount_type'] = $this->input->post('amount_type');
            $data['amount'] = $this->input->post('amount');
            $data['running_year'] = _getYear();
            $data['school_id'] = _getSchoolid();
            $data['created'] = date('Y-m-d H:i:s');
            $data['updated'] = date('Y-m-d H:i:s');
            $return = $this->Refund_model->save_refund_rule($data);

            if($return){
                $this->session->set_flashdata('flash_message', get_phrase('refund_rule_has_been_saved_successfully.'));
                redirect(base_url() . 'index.php?fees/refund/refund_rules/', 'refresh');
            } else {
                $page_data['form_error'] = 1;
                $this->session->set_flashdata('flash_message_error', get_phrase('Invalid details.'));
            }
        } else {
            $page_data['form_error'] = 1;
            $this->session->set_flashdata('flash_message_error', validation_errors());
            redirect(base_url() . 'index.php?fees/refund/refund_rules/', 'refresh');
        }
    }
    
    public function refund_rule_edit($rule_id){        
        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'fees/refund_rule_edit';
        $page_data['page_title'] = get_phrase('edit_refund_rule');
        $page_data['rule_id'] = $rule_id;
        
        $this->form_validation->set_rules('running_year', 'Current running year', 'trim|required');
        $this->form_validation->set_rules('name', 'Type Name', 'trim|required');
        $this->form_validation->set_rules('fee_group_id', 'Fee Group', 'trim|required');
        $this->form_validation->set_rules('term_type_id', 'Term Type', 'trim|required');
        $this->form_validation->set_rules('term_type_id', 'Term Type', 'trim|required');
        $this->form_validation->set_rules('valid_from', 'Valid from', 'trim|required');
        $this->form_validation->set_rules('valid_to', 'Valid to', 'trim|required');
        $this->form_validation->set_rules('amount_type', 'Amount type', 'trim|required');
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
        $this->form_validation->set_error_delimiters('', '');
        
        if ($this->form_validation->run() == TRUE) {
            $data['name'] = $this->input->post('name');
            $data['fee_group_id'] = $this->input->post('fee_group_id');
            $data['term_type_id'] = $this->input->post('term_type_id');
            $data['setup_term_id'] = $this->input->post('setup_term_id');
            $data['valid_from'] = date('Y-m-d H:i:s',strtotime($_POST['valid_from']));
            $data['valid_to'] = date('Y-m-d H:i:s',strtotime($_POST['valid_to']));
            $data['amount_type'] = $this->input->post('amount_type');
            $data['amount'] = $this->input->post('amount');
            $data['updated'] = date('Y-m-d H:i:s');
            $return = $this->Refund_model->update_refund_rule($data,$rule_id);
                
            if($return){
                $this->session->set_flashdata('flash_message', get_phrase('refund_rule_has_been_updated_successfully.'));
                redirect(base_url() . 'index.php?fees/refund/refund_rules/', 'refresh');
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('Invalid details'));
            }
        } else {
            $this->session->set_flashdata('flash_message_error', validation_errors());
        }
        $refund_rule_data = $this->Refund_model->get_single_refund_rule($rule_id);
        
        $fee_group_id = $refund_rule_data[0]['fee_group_id'];  
        $term_type_id = $refund_rule_data[0]['term_type_id'];  
        $page_data['setup_terms'] = $this->Ajax_model->get_setup_terms(array('fee_group_id'=>$fee_group_id,'fee_term_id'=>$term_type_id));
        $page_data['fee_groups'] = $this->Fees_model->get_fee_groups();
        $page_data['term_types'] = $this->Fees_model->get_fee_terms();
        $page_data['refund_rule_data'] = @$refund_rule_data[0];
        $this->load->view('backend/index', $page_data);
    }
    
    public function deleterefundrule($rule_id){        
        $page_data = $this->get_page_data_var();
        $return = $this->Refund_model->deleteRefundRule(array('id'=>$rule_id)); 
        if($return) {
            $this->session->set_flashdata('flash_message', get_phrase('refund_rule_has_been_deleted_successfully.'));
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('Error in deletion.'));
        }
        
        redirect(base_url() . 'index.php?fees/refund/refund_rules/', 'refresh');
    }

    //Refund apply
    function apply(){
        $page_data = $this->get_page_data_var();
       
        $page_data['page_name'] = 'fees/refund_apply';
        $page_data['page_title'] = get_phrase('apply_refund');
        $page_data['account_type'] = $this->session->userdata('login_type');
        $page_data['classes'] = $this->Fees_model->get_classes();
        $this->load->view('backend/index', $page_data); 
    }

    //Get Fee Options
    function get_student_fees(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $student_id = $this->input->post('student_id');
            $this->_get_regular_student_fees($student_id);
        }
    }
    
    private function _get_regular_student_fees($student_id){
        $return = array('status'=>'error','msg'=>'Error try again!');
        $student_rec = $this->Ajax_model->get_student(array('S.student_id'=>$student_id));
        $return['stu_detail_html'] = '<tr>
                                        <td>'.$student_rec->enroll_code.'</td>
                                        <td>'.$student_rec->name.' '.$student_rec->lname.'</td>
                                        <td>'.$student_rec->class_name.'-'.$student_rec->section_name.'</td>
                                        <td class="text-right">'.date('d/m/Y',$student_rec->date_added).'</td>
                                      </tr>';
        
        $terms = $this->Ajax_model->get_setudent_fee_config($student_id);
        $return['html'] = '<option value="">'.get_phrase('select_fee').'</option>';
        if($terms){
            $return['status'] = 'success';
            if($terms['school_fee_terms']){
                $return['html'] .= '<optgroup label="School Fees">';
                foreach($terms['school_fee_terms'] as $term){
                    $return['html'] .= '<option data-type="1" value="'.$term->id.'">'.$term->name.' -- '.$term->amount.'</option>';
                }
                $return['html'] .= '</optgroup>';  
            }
        }else{
            $return['msg'] = 'Fees not assigned!';
        }  
        echo json_encode($return);exit;
    }

    //Get Fee Details
    function get_paid_fee_detail($fee_id=false){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $stu_status = $this->input->post('stu_status');   
            $student_id = $this->input->post('student_id'); 
            $fee_type = $this->input->post('fee_type'); 
            $fee_id = $this->input->post('fee_id');     
            $stu_rec = $this->Ajax_model->get_student(array('S.student_id'=>$student_id));
            $this->_get_regular_fee_detail($stu_status,$student_id,$stu_rec->class_id,$fee_type,$fee_id);  
        }   
    }

    private function _get_regular_fee_detail($stu_status,$student_id,$class_id,$fee_type,$fee_id){
        $return = array('status'=>'error','msg'=>'Error try again!','html'=>'','payment_trans_html'=>'');
        $stu_rec = $this->Ajax_model->get_student(array('S.student_id'=>$student_id));
        $stu_config = $this->Ajax_model->get_stu_config_rec(array('student_id'=>$student_id));
        $group_rec = $this->Ajax_model->get_fee_group(array('FRGC.class_id'=>$stu_rec->class_id));
        $refund_rule = $this->Refund_model->get_rule_rec(array('fee_group_id'=>$group_rec->id,'setup_term_id'=>$fee_id));
        //echo '<pre>';print_r($stu_config);exit;
        
        //Have Paid
        $whr_cond = array('student_status'=>$stu_status,'student_id'=>$student_id,'class_id'=>$class_id,'fee_type'=>$fee_type,'fee_id'=>$fee_id);
        $hv_collrec = $this->Ajax_model->get_fee_collection_record($whr_cond);
        //echo '<pre>';print_r($hv_collrec);exit;

        if(!$hv_collrec || $hv_collrec->is_paid!=1){
            $return['msg']= 'Fee not paid!';
            echo json_encode($return);exit;    
        }

        $cur_date = date('Y-m-d');
        $total_fees = 0;
        $total_concess = 0;
        $total_fine = 0;
        $net_amount = 0;
        $total_paid = 0;
        $total_due_amt = 0;
        $due_date = false;
        $fine_rec = false;
        //echo '<pre>--';print_r($hv_collrec);exit;
        
        $return['paid'] = 0; 
        $return['net_due'] = 0;  
        $trans_paid = 0;
        
        $return['payment_trans_html'] = '<tr><td colspan="6" class="text-center"><strong>'.get_phrase('no_payments_yet').'</strong></td></tr>';
        if($hv_collrec){
            foreach($hv_collrec->pay_trans as $ptran){
                $trans_paid += $ptran->paid_amount;
            }
            
            $total_paid += $trans_paid; 
            $total_due_amt += $hv_collrec->net_due;
            $return['paid'] = $hv_collrec->is_paid; 
            $return['net_due'] = $hv_collrec->net_due;  
        }
        $return['total_paid'] = $total_paid; 
        //echo '<pre>--';print_r($hv_collrec);exit;

        $fee_detail_body = '';
        if($fee_type==1){ 
            foreach($hv_collrec->item_trans as $i=>$rec){
                if($rec->item_type==1){
                    $total_fees += $rec->item_amt;
                    $fee_detail_body .= '<tr data-num="'.$i.'">
                                            <td class="slabel">'.($i+1).'</td>
                                            <td>'.$rec->item_name.($rec->is_custom?' <strong>['.get_phrase('custom').']</strong>':'').'</td>
                                            <td class="text-right amt-ele" data-amt="'.$rec->item_amt.'">
                                                <span>'.$rec->item_amt.'</span>
                                                <input type="hidden" name="heads['.$i.'][id]" value="'.$rec->item_id.'"/>
                                                <input type="hidden" name="heads['.$i.'][name]" value="'.$rec->item_name.'"/>
                                                <input type="hidden" name="heads['.$i.'][amt]" value="'.$rec->item_amt.'"/>
                                            </td>
                                        </tr>';
                }
            }
        
        }else if($fee_type==2 || $fee_type==3){
            foreach($hv_collrec->item_trans as $i=>$rec){
                if($rec->item_type==4){
                    $total_fees += $rec->item_amt;

                    $fee_detail_body .='<tr data-num="'.$i.'">
                                            <td>'.($i+1).'</td>
                                            <td>'.$rec->item_name.'</td>
                                            <td class="text-right amt-ele" data-amt="'.$rec->item_amt.'">
                                                '.$rec->item_amt.'
                                                <input type="hidden" name="terms['.$i.'][id]" value="'.$rec->item_id.'"/>
                                                <input type="hidden" name="terms['.$i.'][name]" value="'.$rec->item_name.'"/>
                                                <input type="hidden" name="terms['.$i.'][amt]" value="'.$rec->item_amt.'"/>
                                            </td>
                                        </tr>';
                }
            } 
        }
        $total_fees = sprintf('%0.2f',$total_fees);

        //Concession Part
        $concess_div_html = false;
        foreach($hv_collrec->item_trans as $i=>$rec){
            if($rec->item_type==2){
                $total_concess += $rec->item_amt;
                $concess_div_html .= '<tr data-num="'.$i.'">
                                        <td>'.($i+1).'</td>
                                        <td>'.$rec->item_name.'</td>
                                        <td class="text-right amt-ele">
                                            <span>'.$rec->item_amt.'</span>
                                            <input type="hidden" class="item-id" name="concessions['.$i.'][id]" value="'.$rec->item_id.'"/>
                                            <input type="hidden" class="item-name" name="concessions['.$i.'][name]" value="'.$rec->item_name.'"/>
                                            <input type="hidden" class="item-amt" name="concessions['.$i.'][amt]" value="'.$rec->item_amt.'"/>
                                        </td>
                                    </tr>';
            }
        }
        $total_concess = sprintf('%0.2f',$total_concess);
        //----Concession Part

        //Fine Part
        $fine_div_html = false;
        foreach($hv_collrec->item_trans as $i=>$rec){
            if($rec->item_type==3){
                $total_fine += $rec->item_amt;
                $fine_div_html = '<tr data-num="'.$i.'">
                                        <td>'.($i+1).'</td>
                                        <td>'.$rec->item_name.' </td>
                                        <td class="text-right amt-ele">
                                            <span>'.$rec->item_amt.'</span>
                                            <input type="hidden" class="item-id" name="fines['.$i.'][id]" value="'.$rec->item_id.'"/>
                                            <input type="hidden" class="item-name" name="fines['.$i.'][name]" value="'.$rec->item_name.'"/>
                                            <input type="hidden" class="item-amt" name="fines['.$i.'][amt]" value="'.$rec->item_amt.'"/>
                                        </td>
                                    </tr>';
            }
        }
        $total_fine = sprintf('%0.2f',$total_fine);
        //----Fine Part

        //Net Caluculation
        $net_amount = ($total_fees+$total_fine)-$total_concess;
        $net_amount = sprintf('%0.2f',$net_amount);
        $total_paid = sprintf('%0.2f',$total_paid);
        $total_due_amt = $net_amount-$total_paid;
        $total_due_amt = sprintf('%0.2f',$total_due_amt);

        $return['has_rule'] = 0;
        $return['ajax_html'] = '';
        if($refund_rule){
            $return['has_rule'] = 1;
            $refund_amt = $refund_rule->amount_type==2?$refund_rule->amount:round(($hv_collrec->net_amount*$refund_rule->amount)/100);
            $return['ajax_html'] = '<div class="row">
                                        <div class="col-md-12">
                                            <h4 class="text-right">
                                            Refund Amount : '.$refund_amt.'</h4>
                                        </div>          
                                    </div>
                                    <div class="row mt10">
                                        <div class="col-md-2 pull-right">
                                            <a class="fcbtn btn btn-danger btn-outline btn-1d pull-right"
                                                data-toggle="modal" data-target="#refund-modal">'.get_phrase('apply_refund').'
                                            </a>
                                        </div>          
                                    </div>';    


            $re_whr = array('student_id'=>$student_id,
                            'pay_collection_id'=>$hv_collrec->id,
                            'fee_type'=>$fee_type,
                            'fee_id'=>$fee_id,
                            'refund_rule_id'=>$refund_rule->id);
            $refund_record = $this->Refund_model->get_refund_record($re_whr);
            if($refund_record){
                $return['ajax_html'] = '<div class="row">
                                            <div class="col-md-12">
                                                <h3 class="text-center">
                                                '.get_phrase('refund_has_been_applied_on').date('d/m/Y',strtotime($refund_record->approve_date)).'</h3>
                                            </div>          
                                        </div>'; 
            }
        }else{
            $return['ajax_html'] = '<div class="row">
                                        <div class="col-md-12">
                                            <h3 class="text-center">'.get_phrase('refund_rule_not_exists!').'</h3>
                                        </div>          
                                    </div>  ';    
        }

        //Only View No Calculation
        $return['status'] = 'succcess';    
        $return['html'] = '<table class="table no-padding" id="head-fees">
                            <thead>
                                <tr>
                                    <th style="width:100px">'.get_phrase('no.').'</th>
                                    <th>'.get_phrase('Head').'</th>
                                    <th class="text-right">'.get_phrase('Amount').'</th>
                                </tr>
                            </thead>

                            <tbody>'.$fee_detail_body.'</tbody>
                            </table>
                            <table class="table no-padding '.(!$concess_div_html?'dis-none':'').'" id="fee-concessions">        
                                <thead>
                                    <tr>
                                        <th style="width:100px"></th>
                                        <th>'.get_phrase('Concession').'</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>'.$concess_div_html.'</tbody>
                            </table> 
                            
                            <table class="table no-padding '.(!$fine_div_html?'dis-none':'').'" id="fee-fines">        
                                <thead>
                                    <tr>
                                        <th style="width:100px"></th>
                                        <th>'.get_phrase('Fine').'</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>'.$fine_div_html.'</tbody>
                            </table>    

                            <table class="table no-padding" id="fee-summary">        
                                <thead>
                                    <tr>
                                        <th style="width:100px"></th>
                                        <th>'.get_phrase('summary').'</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Total Fees</td>
                                        <td class="text-right total-amt">'.$total_fees.'</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Total Concession</td>
                                        <td class="text-right total-concession">'.$total_concess.'</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Total Fine</td>
                                        <td class="text-right total-fine">'.$total_fine.'</td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <table class="table no-padding" id="fee-total">        
                                <thead>
                                    <tr>
                                        <th class="text-right">'.get_phrase('net_amount').'</th>
                                        <th class="text-right net-amt">'.$hv_collrec->net_amount.'</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right">'.get_phrase('total_paid').'</th>
                                        <th class="text-right net-paid">'.$total_paid.'</th>
                                    </tr>
                                </thead>
                            </table>
                            <input type="hidden" name="refund_rule_id" value="'.($refund_rule?$refund_rule->id:'').'"/>  
                            <input type="hidden" name="pay_collection_id" value="'.($hv_collrec?$hv_collrec->id:'').'"/> ';
        echo json_encode($return);exit;  
    }

    function apply_refund(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $student_id = $this->input->post('student_id');  
            $fee_type = $this->input->post('fee_type'); 
            $fee_id = $this->input->post('fee_id'); 
            $refund_rule_id = $this->input->post('refund_id'); 
            $refund_note = $this->input->post('refund_note');  

            $stu_rec = $this->Ajax_model->get_student(array('S.student_id'=>$student_id));
            $group_rec = $this->Ajax_model->get_fee_group(array('FRGC.class_id'=>$stu_rec->class_id));
            $refund_rule = $this->Refund_model->get_rule_rec(array('fee_group_id'=>$group_rec->id,'setup_term_id'=>$fee_id));
            
            $whr_cond = array('student_status'=>1,
                              'student_id'=>$student_id,
                              'fee_type'=>$fee_type,
                              'fee_id'=>$fee_id);
            $hv_collrec = $this->Ajax_model->get_fee_collection_record($whr_cond);

            $refund_amount =  $refund_rule->amount_type==2?$refund_rule->amount:round(($hv_collrec->net_amount*$refund_rule->amount)/100);

            $save_data = array('student_id'=>$student_id,
                                'pay_collection_id'=>$hv_collrec->id,
                                'fee_type'=>$fee_type,
                                'fee_id'=>$fee_id,
                                'refund_rule_id'=>$refund_rule_id,
                                'refund_amount'=>$refund_amount,
                                'request_comment'=>$refund_note,
                                'running_year'=>_getYear(),
                                'school_id'=>_getSchoolid(),
                                'request_status'=>1,
                                'approve_date'=>date('Y-m-d H:i:s'));
            $this->Refund_model->save_refund($save_data);
            echo json_encode(array('status'=>'success','msg'=>'Refund Created!'));            
        }    
    }
    
    /* public function approve($param1=''){
        if (($this->session->userdata('cashier_login') == 1) || ($this->session->userdata('accountant_login') == 1)){
            if($param1!=''){
                $UpdateData['approver_type'] = '0' ;
                if($this->session->userdata('login_type') == 'cashier'){
                    $UpdateData['approver_type'] = '1' ;
                }else if($this->session->userdata('login_type') == 'accountant'){
                    $UpdateData['approver_type'] = '2' ;
                }else if($this->session->userdata('login_type') == 'admin'){
                    $UpdateData['approver_type'] = '3' ;
                }
                $UpdateData['approver_type_id'] = $this->session->userdata('login_user_id');
                $UpdateData['request_status'] = '1';
                $UpdateData['approve_date'] = date('d-m-Y');

                $this->Refund_model->approve_reject_refund_request($param1, $UpdateData);
                $this->session->set_flashdata('flash_message', get_phrase('request_has_been_approved_successfully.'));
            }
            redirect(base_url() . 'index.php?fees/refund', 'refresh');
        }else{
            redirect(base_url(), 'refresh');
        }
    }

    public function reject($param1=''){
        if (($this->session->userdata('cashier_login') == 1) || ($this->session->userdata('accountant_login') == 1)){
            if($param1!=''){
                $UpdateData['approver_type'] = '0' ;
                if($this->session->userdata('login_type') == 'cashier'){
                    $UpdateData['approver_type'] = '1' ;
                }else if($this->session->userdata('login_type') == 'accountant'){
                    $UpdateData['approver_type'] = '2' ;
                }else if($this->session->userdata('login_type') == 'admin'){
                    $UpdateData['approver_type'] = '3' ;
                }
                $UpdateData['approver_type_id'] = $this->session->userdata('login_user_id');
                $UpdateData['request_status'] = '2';
                $UpdateData['reject_date'] = date('d-m-Y');

                $this->Refund_model->approve_reject_refund_request($param1, $UpdateData);
                $this->session->set_flashdata('flash_message', get_phrase('request_has_been_rejected_successfully.'));
            }
            redirect(base_url() . 'index.php?fees/refund', 'refresh');
        }else{
            redirect(base_url(), 'refresh');
        }
    } */
    
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


    
