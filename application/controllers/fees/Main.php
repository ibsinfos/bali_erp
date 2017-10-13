<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends CI_Controller {

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
        //pre($this->session->userdata); die;
        $this->load->model(array('Setting_model','Class_model','fees/Fees_model','fees/Ajax_model','fees/Refund_model'));
        $this->load->helper('functions');
        //$this->globalSettingsSMSDataArr = get_data_generic_fun('settings', 'description', array('condition_type' => 'in', 'condition_in_col' => 'type',
        // 'condition_in_data' => 'location,app_package_name,running_year,system_name,system_email,fcm_server_key,system_title,text_align,skin_colour,
        //active_sms_service'));
        
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

    /************************Fee Particulars*******************************/
    function terms(){
        $page_data = $this->get_page_data_var();
        $running_year = $page_data['running_year'];
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->form_validation->set_rules('name', 'Term Name', 'trim|required|_unique_field_sch[fee_terms.name#running_year.'.$running_year.']');
            $this->form_validation->set_rules('term_num', 'Number of terms', 'trim|required|numeric|greater_than[0]|_unique_field_sch[fee_terms.term_num#running_year.'.$running_year.']');
            $this->form_validation->set_rules('description', 'Term Description', 'trim');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() == TRUE) {
                $save_data['name'] = $this->input->post('name');
                $save_data['term_num'] = $this->input->post('term_num');
                $save_data['running_year'] = $running_year;
                $save_data['school_id'] = $this->session->userdata('school_id')?$this->session->userdata('school_id'):0;
                $save_data['created'] = date('Y-m-d H:i:s');
                $save_data['updated'] = date('Y-m-d H:i:s');
                $return = $this->Fees_model->save_fee_term($save_data);
                    
                if($return){
                    $this->session->set_flashdata('flash_message', get_phrase('fee_term_has_been_saved_successfully.'));
                    redirect(base_url() . 'index.php?fees/main/terms', 'refresh');
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('invalid_details.'));
                }
            }else{
                $this->session->set_flashdata('flash_message_error', validation_errors());
            }
        } 
        
        $page_data['page_name'] = 'fees/fee_terms';
        $page_data['page_title'] = get_phrase('fee_terms');
        $page_data['records'] = $this->Fees_model->get_fee_terms();
        $this->load->view('backend/index', $page_data);
    }
    
    function term_edit($id=false){
        $page_data = $this->get_page_data_var();
        $running_year = $page_data['running_year'];
        $page_data['record'] = $rec = $this->Fees_model->get_term_record($id);
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $is_unique_name = strtolower($_POST['name'])==strtolower($rec->name)?'':'|_unique_field_sch[fee_terms.name#running_year.'.$running_year.']';
            $is_unique_num = $this->input->post('term_num')==$rec->term_num?'':'|_unique_field_sch[fee_terms.term_num#running_year.'.$running_year.']';
            //echo  $is_unique_name ;exit;
            $this->form_validation->set_rules('name', 'Term Name', 'trim|required'.$is_unique_name);
            $this->form_validation->set_rules('term_num', 'Number of terms', 'trim|required|numeric|greater_than[0]'.$is_unique_num);
            $this->form_validation->set_rules('description', 'Term Description', 'trim');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() !== FALSE) {
                $save_data['id'] = $id;
                $save_data['name'] = $this->input->post('name');
                $save_data['term_num'] = $this->input->post('term_num');
                $save_data['updated'] = date('Y-m-d H:i:s');
                $return = $this->Fees_model->save_fee_term($save_data);
                    
                if($return){
                    $this->session->set_flashdata('flash_message', get_phrase('fee_term_has_been_updated_successfully.'));
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('invalid_details.'));
                }
            }else {
                $this->session->set_flashdata('flash_message_error', validation_errors());
            }
            redirect(base_url() . 'index.php?fees/main/terms/', 'refresh');
        } 
        $this->load->view('backend/school_admin/fees/modal_edit_term',$page_data);
    }

    function term_delete($id=false){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->Fees_model->term_delete(array('id'=>$id));
            echo json_encode(array('status'=>'success','msg'=>'Fee Term Deleted!'));exit;
        }
    }

    function term_setting(){
        $page_data = $this->get_page_data_var();
        $running_year = $page_data['running_year'];
        //$page_data['record'] = $rec = $this->Fees_model->get_term_record($id);
        
        if($this->input->server('REQUEST_METHOD')=='POST'){
            //echo implode(',',$_POST['school_fee_terms']);
            //echo '<pre>';print_r($_POST);exit;
            $save_data['school_term_setting'] = $this->input->post('school_fee_terms')?implode(',',$_POST['school_fee_terms']):'';
            $save_data['hostel_term_setting'] = $this->input->post('hostel_fee_terms')?implode(',',$_POST['hostel_fee_terms']):'';
            $save_data['transport_term_setting'] = $this->input->post('transport_fee_terms')?implode(',',$_POST['transport_fee_terms']):'';
            $save_data['running_year'] = $this->session->userdata('running_year');
            $save_data['school_id'] = $this->session->userdata('school_id');
            $return = $this->Fees_model->save_term_setting($save_data);
            
            $this->session->set_flashdata('flash_message', get_phrase('term_setting_has_updated_successfully.'));
            redirect(base_url() . 'index.php?fees/main/term_setting', 'refresh');
        } 
        
        $page_data['page_name'] = 'fees/fee_insta_settings';
        $page_data['page_title'] = get_phrase('fee_term_settings');
        $page_data['terms'] = $this->Fees_model->get_fee_terms();
        $page_data['term_setting'] = $term_setting = $this->Fees_model->get_term_setting();
        $page_data['school_term_setting'] = $term_setting?explode(',',$term_setting->school_term_setting):array();
        $page_data['hostel_term_setting'] = $term_setting?explode(',',$term_setting->hostel_term_setting):array();
        $page_data['transport_term_setting'] = $term_setting?explode(',',$term_setting->transport_term_setting):array();
        //echo '<pre>';print_r($page_data['term_setting']);exit;
        $this->load->view('backend/index', $page_data);
    }

    /************************Fee Particulars*******************************/
    function heads(){
        //echo sett('new_fi');exit;
        $page_data = $this->get_page_data_var();
        $running_year = $page_data['running_year'];
        if($this->input->server('REQUEST_METHOD')=='POST'){
            //$this->form_validation->set_rules('running_year', 'Current running year', 'trim|required');
            $this->form_validation->set_rules('name', 'Head Name', 'trim|required|_unique_field_sch[fee_heads.name#running_year.'.$running_year.']');
            $this->form_validation->set_rules('description', 'Head Description', 'trim');
            $this->form_validation->set_rules('non_enroll', 'Non Enroll', 'trim');
            if($this->input->post('non_enroll'))
                $this->form_validation->set_rules('amount', 'Head Amount', 'trim|required|numeric|greater_than[0]');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() == TRUE) {
                $save_data['name'] = $this->input->post('name');
                $save_data['description'] = $this->input->post('description');
                $save_data['non_enroll'] =  $this->input->post('non_enroll')?1:0;
                $save_data['amount'] = $this->input->post('amount');
                $save_data['running_year'] = $running_year;
                $save_data['school_id'] = $this->session->userdata('school_id')?$this->session->userdata('school_id'):0;
                $save_data['created'] = date('Y-m-d H:i:s');
                $save_data['updated'] = date('Y-m-d H:i:s');
                $return = $this->Fees_model->save_fee_head($save_data);
                    
                if($return){
                    $this->session->set_flashdata('flash_message', get_phrase('fee_head_has_been_saved_successfully.'));
                    redirect(base_url() . 'index.php?fees/main/heads/', 'refresh');
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('invalid_details.'));
                }
            }else{
                $this->session->set_flashdata('flash_message_error', validation_errors());
            }
        } 
        
        $page_data['page_name'] = 'fees/fee_heads';
        $page_data['page_title'] = get_phrase('fee_heads');
        $page_data['records'] = $this->Fees_model->get_fee_heads();
        //$page_data['fee_categories'] = $this->Fees_model->get_fee_categories();
        //echo '<pre>';print_r($page_data['records'] );exit;
        $this->load->view('backend/index', $page_data);
    }
    
    function head_edit($id=false){
        $page_data = $this->get_page_data_var();
        $running_year = $page_data['running_year'];
        $page_data['record'] = $rec = $this->Fees_model->get_head_record($id);
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $is_unique_name = strtolower($_POST['name'])==strtolower($rec->name)?'':'|_unique_field_sch[fee_heads.name#running_year.'.$running_year.']';
            //$this->form_validation->set_rules('running_year', 'Current running year', 'trim|required');
            $this->form_validation->set_rules('name', 'Head Name', 'trim|required'.$is_unique_name);
            $this->form_validation->set_rules('description', 'Head Description', 'trim');
            if($this->input->post('non_enroll'))
                $this->form_validation->set_rules('amount', 'Head Amount', 'trim');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() !== FALSE) {
                $save_data['id'] = $id;
                $save_data['name'] = $this->input->post('name');
                $save_data['description'] = $this->input->post('description');
                $save_data['non_enroll'] =  $this->input->post('non_enroll')?1:0;
                $save_data['amount'] = $this->input->post('amount');
                $save_data['updated'] = date('Y-m-d H:i:s');
                $return = $this->Fees_model->save_fee_head($save_data);
                    
                if($return){
                    $this->session->set_flashdata('flash_message', get_phrase('fee_head_has_been_updated_successfully.'));
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('invalid_details.'));
                }
            }else {
                $this->session->set_flashdata('flash_message_error', validation_errors());
            }
            redirect(base_url() . 'index.php?fees/main/heads/', 'refresh');
        } 
        $this->load->view('backend/school_admin/fees/modal_edit_head',$page_data);
    }

    function head_delete($id=false){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->Fees_model->head_delete(array('id'=>$id));
            echo json_encode(array('status'=>'success','msg'=>'Fee Head Deleted!'));exit;
        }
    }

    /************************Fee Groups*******************************/
    function groups(){
        $page_data = $this->get_page_data_var();
        $running_year = $page_data['running_year'];
        if($this->input->server('REQUEST_METHOD')=='POST'){
            //echo '<pre>121';print_r($_POST);exit;
            //$this->form_validation->set_rules('running_year', 'Current running year', 'trim|required');
            $this->form_validation->set_rules('name', 'Group Name', 'trim|required|_unique_field_sch[fee_groups.name#running_year.'.$running_year.']');
            //if(!isset($_POST['heads']))
                $this->form_validation->set_rules('heads[]', 'Fee Heads', 'required', array('required'=>'Select %s!'));
            //if(!isset($_POST['classes']))  
                $this->form_validation->set_rules('classes[]', 'Classes', 'required', array('required'=>'Select %s!'));
            
            $this->form_validation->set_rules('description', 'Group Description', 'trim');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() == TRUE) {
                _school_cond();
                _year_cond();
                $rel_rec = $this->db->where_in('class_id',$_POST['classes'])->get('fee_rel_group_class')->row();    
                if($rel_rec){
                    $this->session->set_flashdata('flash_message_error', get_phrase('selected_class_already_assigned_to_group!.'));
                    redirect(base_url() . 'index.php?fees/main/groups/', 'refresh');
                }
                
                //echo '<pre>';print_r($_POST);exit;

                $save_data['name'] = $this->input->post('name');
                $save_data['description'] = $this->input->post('description');
                $save_data['running_year'] = $running_year;
                $save_data['school_id'] = $this->session->userdata('school_id')?$this->session->userdata('school_id'):0;
                $save_data['created'] = date('Y-m-d H:i:s');
                $save_data['updated'] = date('Y-m-d H:i:s');
                $group_id = $this->Fees_model->save_fee_group($save_data);
                $flag = $this->Fees_model->save_group_relation($group_id,$_POST);

                if($group_id && $flag){
                    $this->session->set_flashdata('flash_message', get_phrase('fee_group_has_been_saved_successfully.'));
                    redirect(base_url() . 'index.php?fees/main/groups/', 'refresh');
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('invalid_details.'));
                }
            }else{
                $this->session->set_flashdata('flash_message_error', validation_errors());
            }
        } 
        
        $page_data['page_name'] = 'fees/fee_groups';
        $page_data['page_title'] = get_phrase('fee_groups');
        $page_data['account_type'] = $this->session->userdata('login_type');
        $page_data['classes'] = $this->Fees_model->get_classes();
        $page_data['heads'] = $this->Fees_model->get_fee_heads(array('non_enroll'=>0));
        $page_data['records'] = $this->Fees_model->get_fee_groups();
        $this->load->view('backend/index', $page_data);
    }
    
    function group_edit($group_id=false){
        $page_data = $this->get_page_data_var();
        $running_year = $page_data['running_year'];
        $page_data['record'] = $rec = $this->Fees_model->get_group_record($group_id);
        if(!$rec){
            redirect('index.php?fees/main/groups');
        }
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $is_unique_name = $this->input->post('name')==$rec->name?'':'|_unique_field_sch[fee_groups.name#running_year.'.$running_year.']';
            $this->form_validation->set_rules('name', 'Group Name', 'trim|required'.$is_unique_name);
            //if(!isset($_POST['heads']))
                $this->form_validation->set_rules('heads[]', 'Fee Heads', 'required', array('required'=>'Select %s!'));
            //if(!isset($_POST['classes']))  
                $this->form_validation->set_rules('classes[]', 'Classes', 'required', array('required'=>'Select %s!'));
            $this->form_validation->set_rules('description', 'Group Description', 'trim');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() !== FALSE) {
                _school_cond();
                _year_cond();
                $rel_rec = $this->db->where('group_id !=',$group_id)->where_in('class_id',$_POST['classes'])->get('fee_rel_group_class')->row();    
                if($rel_rec){
                    $this->session->set_flashdata('flash_message_error', get_phrase('selected_class_already_assigned_to_group!.'));
                    redirect(base_url() . 'index.php?fees/main/groups/', 'refresh');
                }
                
                $save_data['id'] = $group_id;
                $save_data['name'] = $this->input->post('name');
                $save_data['description'] = $this->input->post('description');
                $save_data['updated'] = date('Y-m-d H:i:s');
                $group_id = $this->Fees_model->save_fee_group($save_data);
                $flag = $this->Fees_model->save_group_relation($group_id,$_POST);

                if($group_id){
                    $this->session->set_flashdata('flash_message', get_phrase('fee_group_has_been_updated_successfully.'));
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('invalid_details.'));
                }
            }else {
                $this->session->set_flashdata('flash_message_error', validation_errors());
            }
            redirect(base_url() . 'index.php?fees/main/groups/', 'refresh');
        } 
        $page_data['page_name'] = 'fees/fee_group_edit';
        $page_data['page_title'] = get_phrase('edit_fee_group');
        $page_data['account_type'] = $this->session->userdata('login_type');
        $page_data['classes'] = $this->Fees_model->get_classes();
        $page_data['heads'] = $this->Fees_model->get_fee_heads(array('non_enroll'=>0));
        $page_data['rel_heads'] = $this->Fees_model->get_group_heads($group_id);

        $rels = $this->Fees_model->get_group_rel($group_id);
        $page_data['rel_hs'] = array();
        foreach($rels['rel_heads'] as $rel){
            $page_data['rel_hs'][] = $rel->head_id;
        }
        $page_data['rel_cls'] = array();
        foreach($rels['rel_classes'] as $rel){
            $page_data['rel_cls'][] = $rel->class_id;
        }
        //echo '<pre>';print_r($data['rel_pars']);exit;
        $this->load->view('backend/index', $page_data);
    }

    function group_delete($id=false){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->Fees_model->group_delete(array('id'=>$id));
            echo json_encode(array('status'=>'success','msg'=>'Group Deleted!'));exit;
        }
    }

    /************************Fee Concessions*******************************/
    function concessions(){
        $page_data = $this->get_page_data_var();
        $running_year = $page_data['running_year'];
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->form_validation->set_rules('type', 'Concession type', 'trim|required');
            $this->form_validation->set_rules('name', 'Name', 'trim|required|_unique_field_sch[fee_concessions.name#running_year.'.$running_year.']');
            $this->form_validation->set_rules('description', 'Description', 'trim');
            //$this->form_validation->set_rules('fee_category_id', 'Fee Category', 'trim|required');
            $this->form_validation->set_rules('amt_type', 'Amount Type', 'trim|required');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            //$this->form_validation->set_rules('running_year', 'Current running year', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() == TRUE) {
                $save_data['type'] = $this->input->post('type');
                $save_data['name'] = $this->input->post('name');
                $save_data['description'] = $this->input->post('description');
                //$save_data['fee_category_id'] = $this->input->post('fee_category_id');
                $save_data['amt_type'] = $this->input->post('amt_type');
                $save_data['amount'] = $this->input->post('amount');
                $save_data['running_year'] = $running_year;
                $save_data['school_id'] = $this->session->userdata('school_id')?$this->session->userdata('school_id'):0;
                $save_data['created'] = date('Y-m-d H:i:s');
                $save_data['updated'] = date('Y-m-d H:i:s');
                $return = $this->Fees_model->save_fee_concession($save_data);
                    
                if($return){
                    $this->session->set_flashdata('flash_message', get_phrase('fee_concession_has_been_saved_successfully.'));
                    redirect(base_url() . 'index.php?fees/main/concessions/', 'refresh');
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('invalid_details.'));
                }
            }else{
                $this->session->set_flashdata('flash_message_error', validation_errors());
            }
        } 
        
        $page_data['page_name'] = 'fees/fee_concessions';
        $page_data['page_title'] = get_phrase('fee_concessions');
        $page_data['account_type'] = $this->session->userdata('login_type');
        $page_data['records'] = $this->Fees_model->get_fee_concessions();
        //$page_data['fee_categories'] = $this->Fees_model->get_fee_categories();
        $this->load->view('backend/index', $page_data);
    }

    function concession_edit($id=false){
        $page_data = $this->get_page_data_var();
        $running_year = $page_data['running_year'];
        $page_data['record'] = $rec = $this->Fees_model->get_concession_record($id);
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $is_unique_name = $this->input->post('name')==$rec->name?'':'|_unique_field_sch[fee_concessions.name#running_year.'.$running_year.']';
            //echo  $is_unique_name ;exit;
            $this->form_validation->set_rules('type', 'Concession type', 'trim|required');
            $this->form_validation->set_rules('name', 'Name', 'trim|required'.$is_unique_name);
            $this->form_validation->set_rules('description', 'Description', 'trim');
            //$this->form_validation->set_rules('fee_category_id', 'Fee Category', 'trim|required');
            $this->form_validation->set_rules('amt_type', 'Amount Type', 'trim|required');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            //$this->form_validation->set_rules('running_year', 'Current running year', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() !== FALSE) {
                $save_data['id'] = $id;
                $save_data['type'] = $this->input->post('type');
                $save_data['name'] = $this->input->post('name');
                $save_data['description'] = $this->input->post('description');
                //$save_data['fee_category_id'] = $this->input->post('fee_category_id');
                $save_data['amt_type'] = $this->input->post('amt_type');
                $save_data['amount'] = $this->input->post('amount');
                $save_data['updated'] = date('Y-m-d H:i:s');
                $return = $this->Fees_model->save_fee_concession($save_data);
                    
                if($return){
                    $this->session->set_flashdata('flash_message', get_phrase('fee_concession_has_been_updated_successfully.'));
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('invalid_details.'));
                }
            }else {
                $this->session->set_flashdata('flash_message_error', validation_errors());
            }
            redirect(base_url() . 'index.php?fees/main/concessions/', 'refresh');
        } 
        //$page_data['fee_categories'] = $this->Fees_model->get_fee_categories();
        $this->load->view('backend/school_admin/fees/modal_edit_concession',$page_data);
    }

    function concession_delete($id=false){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->Fees_model->concession_delete(array('id'=>$id));
            echo json_encode(array('status'=>'success','msg'=>'Fee Concession Deleted!'));exit;
        }
    }
    
    function concession_assign($id=false){
        $page_data = $this->get_page_data_var();
        $running_year = $page_data['running_year'];
        $page_data['record'] = $rec = $this->Fees_model->get_concession_record($id);
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $flag = $this->Fees_model->save_concession_rel($id,$this->input->post('items'));
            $this->session->set_flashdata('flash_message', get_phrase('concession_has_been_assigned_successfully.'));
            redirect(base_url() . 'index.php?fees/main/concessions/', 'refresh');
        } 
        if($rec->type==1){
            $page_data['sel_records'] = $this->Fees_model->get_concess_rel_fee_groups($id,1);
            $page_data['rem_records'] = $this->Fees_model->get_concess_rel_fee_groups($id,2);
        } else if($rec->type==2){
            $page_data['sel_records'] = $this->Fees_model->get_concess_rel_classes($id,1);
            $page_data['rem_records'] = $this->Fees_model->get_concess_rel_classes($id,2);
        } else if($rec->type==3){
            $page_data['sel_records'] = $this->Fees_model->get_concess_rel_students($id,1);
            $page_data['rem_records'] = $this->Fees_model->get_concess_rel_students($id,2);
        }
        $this->load->view('backend/school_admin/fees/modal_assign_concession',$page_data);
    }

    function concession_rel_del($rel_id=false,$concess_id=false){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $flag = $this->Fees_model->del_concess_rel(array('concession_id'=>$concess_id,'rel_id'=>$rel_id));
            echo json_encode(array('status'=>'success','msg'=>'Record deleted successfully!'));exit;
        } 
    }
    
    /************************Fee Collections*******************************/
    function charge_setup(){
        $page_data = $this->get_page_data_var();
        $running_year = $page_data['running_year'];
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->form_validation->set_rules('name', 'Setup Name', 'trim|required|_unique_field_sch[fee_charge_setups.name#running_year.'.$running_year.']');
            //$this->form_validation->set_rules('description', 'Group Description', 'trim');
            $this->form_validation->set_rules('fee_group_id', 'Fee Group', 'trim|required');
            $this->form_validation->set_rules('fee_term_id', 'Fee Term', 'trim|required');
            //$this->form_validation->set_rules('terms[]', 'Terms', 'required', array('required'=>'Add %s!'));
            //$this->form_validation->set_rules('running_year', 'Current running year', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() == TRUE) {
                $whr = array('fee_group_id'=>$this->input->post('fee_group_id'),
                             'fee_term_id'=>$this->input->post('fee_term_id'));
                $has_rec = $this->Fees_model->get_charge_setup_record($whr);    
                if($rel_rec){
                    $this->session->set_flashdata('flash_message_error', get_phrase('setup_already_created_for_this_group_and_term.'));
                    redirect(base_url() . 'index.php?fees/main/charge_setup/', 'refresh');
                }    


                $save_data['name'] = $this->input->post('name');
                //$save_data['description'] = $this->input->post('description');
                $save_data['fee_group_id'] = $this->input->post('fee_group_id');
                $save_data['fee_term_id'] = $this->input->post('fee_term_id');
                $save_data['amount'] = $this->input->post('amount');
                $save_data['running_year'] = $running_year;
                $save_data['school_id'] = $this->session->userdata('school_id')?$this->session->userdata('school_id'):0;
                $save_data['created'] = date('Y-m-d H:i:s');
                $save_data['updated'] = date('Y-m-d H:i:s');
                $setup_id = $this->Fees_model->save_charge_setup($save_data);
                $terms_data = $this->input->post('terms');
                $flag = $this->Fees_model->save_charge_setup_terms($setup_id,$terms_data);
                //$flag = $this->Fees_model->save_group_relation($group_id,$this->input->post('particulars'),$this->input->post('classes'));

                if($setup_id){
                    $this->session->set_flashdata('flash_message', get_phrase('fee_charge_setup_has_created_successfully.'));
                    redirect(base_url() . 'index.php?fees/main/charge_setup/', 'refresh');
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('invalid_details.'));
                }
            }else{
                $this->session->set_flashdata('flash_message_error', validation_errors());
            }
        } 
        
        $page_data['page_name'] = 'fees/fee_setup';
        $page_data['page_title'] = get_phrase('fee_charge_setups');
        $page_data['account_type'] = $this->session->userdata('login_type');
        $page_data['fee_groups'] = $this->Fees_model->get_fee_groups();
        $page_data['fee_terms'] = $this->Fees_model->get_fee_terms();
        $page_data['fines'] = $this->Fees_model->get_fee_fines();
        $page_data['records'] = $this->Fees_model->get_charge_setups();
        $page_data['term_setting'] = $term_setting = $this->Fees_model->get_term_setting();
        $page_data['school_term_setting'] = $term_setting?explode(',',$term_setting->school_term_setting):array();
        $this->load->view('backend/index', $page_data);
    }
    
    function charge_setup_edit($_id=false){
        $page_data = $this->get_page_data_var();
        $running_year = $page_data['running_year'];
        $page_data['record'] = $rec = $this->Fees_model->get_charge_setup_record(array('id'=>$_id));
        if(!$rec){
            redirect('index.php?fees/main/charge_setup');
        }
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $is_unique_name = $this->input->post('name')==$rec->name?'':'|_unique_field_sch[fee_charge_setups.name#running_year.'.$running_year.']';
            $this->form_validation->set_rules('name', 'Setup Name', 'trim|required'.$is_unique_name);
            $this->form_validation->set_rules('fee_group_id', 'Fee Group', 'trim|required');
            $this->form_validation->set_rules('fee_term_id', 'Fee Term', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() !== FALSE) {
                $save_data['id'] = $_id;
                $save_data['name'] = $this->input->post('name');
                $save_data['fee_group_id'] = $this->input->post('fee_group_id');
                $save_data['fee_term_id'] = $this->input->post('fee_term_id');
                $save_data['amount'] = $this->input->post('amount');
                $save_data['updated'] = date('Y-m-d H:i:s');
                $setup_id = $this->Fees_model->save_charge_setup($save_data);
                $terms_data = $this->input->post('terms');
                $flag = $this->Fees_model->save_charge_setup_terms($setup_id,$terms_data);

                if($setup_id){
                    $this->session->set_flashdata('flash_message', get_phrase('fee_charge_setup_has_updated_successfully.'));
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('invalid_details.'));
                }
            }else {
                $this->session->set_flashdata('flash_message_error', validation_errors());
            }
            redirect(base_url() . 'index.php?fees/main/charge_setup/', 'refresh');
        } 
        $page_data['page_name'] = 'fees/fee_setup_edit';
        $page_data['page_title'] = get_phrase('edit_charge_setup');
        $page_data['account_type'] = $this->session->userdata('login_type');
        $page_data['fee_groups'] = $this->Fees_model->get_fee_groups();
        $page_data['fee_terms'] = $this->Fees_model->get_fee_terms();
        $page_data['terms'] = $this->Fees_model->get_charge_setup_rel($_id);
        $page_data['fee_grp_heads'] = $this->Fees_model->get_group_heads($rec->fee_group_id);
        $page_data['fines'] = $this->Fees_model->get_fee_fines();
        $page_data['term_setting'] = $term_setting = $this->Fees_model->get_term_setting();
        $page_data['school_term_setting'] = $term_setting?explode(',',$term_setting->school_term_setting):array();
        //echo '<pre>';print_r($page_data['terms']);exit;
        $this->load->view('backend/index', $page_data);
    }

    function charge_setup_delete($_id=false){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->Fees_model->charge_setup_delete(array('id'=>$_id));
            echo json_encode(array('status'=>'success','msg'=>'Fee Setup Deleted!'));exit;
        }
    }
    
    function ajax_get_fee_group_detail(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $return = array('status'=>'error','msg'=>'Error try again!');

            $fee_group_id = $this->input->post('fee_group_id');
            $fee_term_id = $this->input->post('fee_term_id');
            _school_cond();
            _year_cond();
            $fee_grp_record = $this->Fees_model->get_group_record($fee_group_id);
            _school_cond();
            _year_cond();
            $fee_term_record = $this->Fees_model->get_term_record($fee_term_id);
            $fee_grp_heads = $this->Fees_model->get_group_heads($fee_group_id);
            $fines = $this->Fees_model->get_fee_fines();

            $whr = array('fee_group_id'=>$fee_group_id,'fee_term_id'=>$fee_term_id);
            $setup_record= $this->Fees_model->get_charge_setup_record($whr);
            if($setup_record){
                $return['msg'] = 'Terms already created for this fee group';
                echo json_encode($return);exit;
            }else{
                $return['status'] = 'success';
                //$particulars= $this->Fees_model->get_group_particulars($group_id);
                //$classes= $this->Fees_model->get_group_classes($group_id);
                $head_total = 0;
                $return['head_total'] = '<div class="row">
                                            <div class="col-md-6"><strong>Fees Summary</strong></div>
                                          </div>';
                foreach($fee_grp_heads as $gr_head){
                    $head_total += $gr_head->head_amount;
                    $return['head_total'] .= '<div class="row">
                                                <div class="col-md-6"><strong>'.$gr_head->name.'</strong></div>
                                                <div class="col-md-6">'.$gr_head->head_amount.'</div>
                                              </div>';
                }                              
                $return['head_total'] .= '<div class="row">
                                            <div class="col-md-6"><strong>Total</strong></div>
                                            <div class="col-md-6 summary-total">'.$head_total.'</div>
                                          </div>';

                $return['net_amt'] = 0;
                $return['html'] = '';
                $term_head_total = array();
                for($i=0;$i<$fee_term_record->term_num;$i++){
                    $return['html'] .= '<div class="term-item" data-term-num="'.$i.'">
                                            <input type="hidden" name="terms['.$i.'][id]" value=""/>
                                            <div class="row">
                                                <div class="col-md-6"><h3>Term '.($i+1).'</h3></div>
                                            </div>
                                            <div class="row mt5">
                                                <div class="col-md-3"><label><strong>Term Name</strong></label></div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control input-sm" name="terms['.$i.'][name]" value="Term '.($i+1).'"
                                                     placeholder="Term Name"/>
                                                </div>
                                            </div>
                                            <div class="row mt5">
                                                <div class="col-md-3"><strong>Start Date</strong></div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control input-sm dtp" name="terms['.$i.'][start_date]" placeholder="Start Date" autocomplete="off" required/>
                                                </div>
                                            </div>
                                            <div class="row mt5">
                                                <div class="col-md-3"><strong>End Date</strong></div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control input-sm dtp" name="terms['.$i.'][end_date]" placeholder="End Date" autocomplete="off" required/>
                                                </div>
                                            </div>
                                            <div class="row mt5">
                                                <div class="col-md-3"><label><strong>Fine</strong></label></div>
                                                <div class="col-md-9">
                                                    <select class="form-control input-sm" name="terms['.$i.'][fine_id]">
                                                        <option value="">Select Fine</option>';
                                                        foreach($fines as $fine){
                                                            $return['html'] .= '<option value="'.$fine->id.'">'.$fine->name.' -- '.$fine->value.($fine->value_type==2?'%':'').'</option>';
                                                        }
                                $return['html'] .= '</select>
                                                </div>
                                            </div>';
                                            $term_total = 0;
                                            foreach($fee_grp_heads as $gr_head){
                                                if(!isset($term_head_total[$gr_head->id])){
                                                    $term_head_total[$gr_head->id] = 0;
                                                }
                                                if(($i+1)==$fee_term_record->term_num){
                                                    $hd_sep_amt = $gr_head->head_amount-$term_head_total[$gr_head->id];
                                                }else{
                                                    $hd_sep_amt = round($gr_head->head_amount/$fee_term_record->term_num);//,2);
                                                }
                                                $term_head_total[$gr_head->id] += $hd_sep_amt;
                                                $term_total += $hd_sep_amt;
                                                $return['html'] .= '<div class="row mt5 head-row">
                                                                        <div class="col-md-3"><strong>'.$gr_head->name.'</strong></div>
                                                                        <div class="col-md-9">
                                                                            <div class="input-group input-group-sm">
                                                                                <input type="number" class="form-control input-sm head-amt" name="terms['.$i.'][heads]['.$gr_head->id.']" 
                                                                                placeholder="Head Amount" value="'.$hd_sep_amt.'"/>
                                                                                <span class="input-group-btn input-group-sm">
                                                                                    <a class="btn btn-danger btn-xs remove-term"
                                                                                        onclick="confirm_act(false,false,true,this,\'.head-row\',termUP)">
                                                                                        <i class="fa fa-trash"></i>
                                                                                    </a>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>';
                                            }
                                            $return['net_amt'] += $term_total;

                        $return['html'] .= '<div class="row mt5 total-row">
                                                <div class="col-md-3"><strong>Total</strong> </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control input-sm total-term-amt" name="terms['.$i.'][amount]" 
                                                    placeholder="Total Amount" value="'.$term_total.'" readonly/>
                                                </div>
                                            </div>
                                        </div><br/>';
                }
            }
            echo json_encode($return);exit;
            //echo '<pre>';print_r($collection_group_record);exit;
        }
    }
    
    function setup_term_delete($_id=false){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->Fees_model->setup_term_delete(array('id'=>$_id));
            echo json_encode(array('status'=>'success','msg'=>'Term Deleted!'));exit;
        }
    }

    //Hostel Fee setup
    function hostel_fee_setup($_id=false){
        $page_data = $this->get_page_data_var();
        $running_year = $page_data['running_year'];
        $page_data['fee_terms'] = $this->Fees_model->get_fee_terms();
        $whr = array();
        if($_id)
            $whr['HCS.id'] = $_id;
        $page_data['record'] = $record = $this->Fees_model->get_hostel_fee_setup($whr);
        //echo '<pre>';print_r($record);exit;
        
        if($this->input->server('REQUEST_METHOD')=='POST'){
            //echo '<pre>';print_r($_POST);exit;
            $this->form_validation->set_rules('fee_term_id', 'Fee Term', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() !== FALSE) {
                $save_data['fee_term_id'] = $this->input->post('fee_term_id');
                $setup_id = $this->Fees_model->save_hostel_fee_setup($save_data);
                $terms_data = $this->input->post('terms');
                $flag = $this->Fees_model->save_hostel_setup_terms($setup_id,$terms_data);

                if($setup_id){
                    $this->session->set_flashdata('flash_message', get_phrase('hostel_fee_setup_has_updated_successfully.'));
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('invalid_details.'));
                }
            }else {
                $this->session->set_flashdata('flash_message_error', validation_errors());
            }
            redirect(base_url() . 'index.php?fees/main/hostel_fee_setup/'.$setup_id, 'refresh');
        } 
        $page_data['page_name'] = 'fees/hostel_fee_setup';
        $page_data['page_title'] = get_phrase('hostel_fee_setup');
        $page_data['account_type'] = $this->session->userdata('login_type');
        //$page_data['fee_groups'] = $this->Fees_model->get_fee_groups();
        $page_data['setup_terms'] = $record?$this->Fees_model->get_hotel_setup_rel($record->id):array();
        $page_data['fee_terms'] = $this->Fees_model->get_fee_terms();
        $page_data['fines'] = $this->Fees_model->get_fee_fines();
        $page_data['term_setting'] = $term_setting = $this->Fees_model->get_term_setting();
        $page_data['hostel_term_setting'] = $term_setting?explode(',',$term_setting->hostel_term_setting):array();
        //echo '<pre>';print_r($page_data['terms']);exit;
        $this->load->view('backend/index', $page_data);
    }

    function ajax_get_hostel_fee_detail(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $return = array('status'=>'error','msg'=>'Error try again!');

            $fee_term_id = $this->input->post('fee_term_id');
            $fee_term_record = $this->Fees_model->get_term_record($fee_term_id);
            $fines = $this->Fees_model->get_fee_fines();

            $whr = array('HCS.fee_term_id'=>$fee_term_id);
            $record = $this->Fees_model->get_hostel_fee_setup($whr);
            if($record){
                $setup_terms = $record?$this->Fees_model->get_hotel_setup_rel($record->id):array();
                //$return['msg'] = 'Terms already created for this fee group';

                $return['status'] = 'success';
                $return['html'] = '';
                foreach($setup_terms as $i=>$term){
                    $return['html'] .= '<div class="term-item" data-term-num="'.$i.'">
                                            <input type="hidden" name="terms['.$i.'][id]" value="'.$term->id.'"/>
                                            <div class="row">
                                                <div class="col-md-6"><h3>Term '.($i+1).'</h3></div>
                                            </div>
                                            <div class="row mt5">
                                                <div class="col-md-3"><label><strong>Term Name</strong></label></div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control input-sm" name="terms['.$i.'][name]" placeholder="Term Name" 
                                                    value="'.$term->name.'"/>
                                                </div>
                                            </div>
                                            <div class="row mt5">
                                                <div class="col-md-3"><strong>Start Date</strong></div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control input-sm dtp" name="terms['.$i.'][start_date]" 
                                                    placeholder="Start Date" autocomplete="off" required value="'.date('Y-m-d',strtotime($term->start_date)).'"/>
                                                </div>
                                            </div>
                                            <div class="row mt5">
                                                <div class="col-md-3"><strong>End Date</strong></div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control input-sm dtp" name="terms['.$i.'][end_date]" 
                                                    placeholder="End Date" autocomplete="off" required value="'.date('Y-m-d',strtotime($term->end_date)).'"/>
                                                </div>
                                            </div>
                                            <div class="row mt5">
                                                <div class="col-md-3"><label><strong>Fine</strong></label></div>
                                                <div class="col-md-9">
                                                    <select data-style="form-control input-sm" class="selectpicker" name="terms['.$i.'][fine_id]">
                                                        <option value="">Select Fine</option>';
                                                        foreach($fines as $fine){
                                                            $return['html'] .= '<option value="'.$fine->id.'" '.($term->fine_id==$fine->id?'selected':'').'>
                                                                                '.$fine->name.' -- '.$fine->value.($fine->value_type==2?'%':'').'
                                                                                </option>';
                                                        }
                                $return['html'] .= '</select>
                                                </div>
                                            </div>

                                            <div class="row mt5">
                                                <div class="col-md-3"><label><strong>'.get_phrase('Amt/Percentage').'</strong></label></div>
                                                <div class="col-md-9">
                                                    <input type="hidden" name="terms['.$i.'][amt_type]" value="'.$term->amt_type.'"/>
                                                    <input type="text" class="form-control input-sm" name="terms['.$i.'][amount]" placeholder="Amt/Percentage" 
                                                    value="'.$term->amount.'"/>
                                                </div>
                                            </div>
                                        </div><br/>';
                }                        
                echo json_encode($return);exit;
            }else{
                $return['status'] = 'success';
                //$particulars= $this->Fees_model->get_group_particulars($group_id);
                //$classes= $this->Fees_model->get_group_classes($group_id);
                /* $head_total = 0;
                $return['head_total'] = '<div class="row">
                                            <div class="col-md-6"><strong>Fees Summary</strong></div>
                                          </div>';
                foreach($fee_grp_heads as $gr_head){
                    $head_total += $gr_head->head_amount;
                    $return['head_total'] .= '<div class="row">
                                                <div class="col-md-6"><strong>'.$gr_head->name.'</strong></div>
                                                <div class="col-md-6">'.$gr_head->head_amount.'</div>
                                              </div>';
                }                              
                $return['head_total'] .= '<div class="row">
                                            <div class="col-md-6"><strong>Total</strong></div>
                                            <div class="col-md-6 summary-total">'.$head_total.'</div>
                                          </div>'; */

                $return['net_amt'] = 0;
                $return['html'] = '';
                for($i=0;$i<$fee_term_record->term_num;$i++){
                    $return['html'] .= '<div class="term-item" data-term-num="'.$i.'">
                                            <input type="hidden" name="terms['.$i.'][id]" value=""/>
                                            <div class="row">
                                                <div class="col-md-6"><h3>Term '.($i+1).'</h3></div>
                                                <!--<div class="col-md-6">
                                                    <a class="btn btn-danger btn-sm pull-right remove-term"
                                                        onclick="confirm_act(false,false,true,this,\'.term-item\')">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </div>-->
                                            </div>
                                            <div class="row mt5">
                                                <div class="col-md-3"><label><strong>Term Name</strong></label></div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control input-sm" name="terms['.$i.'][name]" value="Term '.($i+1).'"
                                                     placeholder="Term Name"/>
                                                </div>
                                            </div>
                                            <div class="row mt5">
                                                <div class="col-md-3"><strong>Start Date</strong></div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control input-sm dtp" name="terms['.$i.'][start_date]" placeholder="Start Date" autocomplete="off" required/>
                                                </div>
                                            </div>
                                            <div class="row mt5">
                                                <div class="col-md-3"><strong>End Date</strong></div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control input-sm dtp" name="terms['.$i.'][end_date]" placeholder="End Date" autocomplete="off" required/>
                                                </div>
                                            </div>
                                            <div class="row mt5">
                                                <div class="col-md-3"><label><strong>Fine</strong></label></div>
                                                <div class="col-md-9">
                                                    <select data-style="form-control input-sm" class="selectpicker" name="terms['.$i.'][fine_id]">
                                                        <option value="">Select Fine</option>';
                                                        foreach($fines as $fine){
                                                            $return['html'] .= '<option value="'.$fine->id.'">'.$fine->name.' -- '.$fine->value.($fine->value_type==2?'%':'').'</option>';
                                                        }
                                $return['html'] .= '</select>
                                                </div>
                                            </div>

                                            <div class="row mt5">
                                                <div class="col-md-3"><label><strong>'.get_phrase('Amt/Percentage').'</strong></label></div>
                                                <div class="col-md-9">
                                                    <input type="hidden" name="terms['.$i.'][amt_type]" value="2"/>
                                                    <input type="text" class="form-control input-sm" name="terms['.$i.'][amount]" placeholder="Amt/Percentage"/>
                                                </div>
                                            </div>
                                        </div><br/>';
                }
            }
            echo json_encode($return);exit;
            //echo '<pre>';print_r($collection_group_record);exit;
        }
    }
    
    //Transport Fee setup
    function transport_fee_setup($_id=false){
        $page_data = $this->get_page_data_var();
        $running_year = $page_data['running_year'];
        $page_data['fee_terms'] = $this->Fees_model->get_fee_terms();
        $whr = array();
        if($_id)
            $whr['TCS.id'] = $_id;
        $page_data['record'] = $record = $this->Fees_model->get_transport_fee_setup(false,false,$whr);
        
        if($this->input->server('REQUEST_METHOD')=='POST'){
            //echo '<pre>';print_r($_POST);exit;
            $this->form_validation->set_rules('fee_term_id', 'Fee Term', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() !== FALSE) {
                $save_data['fee_term_id'] = $this->input->post('fee_term_id');
                $setup_id = $this->Fees_model->save_transport_fee_setup($save_data);
                $terms_data = $this->input->post('terms');
                $flag = $this->Fees_model->save_transport_setup_terms($setup_id,$terms_data);

                if($setup_id){
                    $this->session->set_flashdata('flash_message', get_phrase('transport_fee_setup_has_updated_successfully.'));
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('invalid_details.'));
                }
            }else {
                $this->session->set_flashdata('flash_message_error', validation_errors());
            }
            redirect(base_url() . 'index.php?fees/main/transport_fee_setup/'.$setup_id, 'refresh');
        } 
        $page_data['page_name'] = 'fees/transport_fee_setup';
        $page_data['page_title'] = get_phrase('transport_fee_setup');
        $page_data['account_type'] = $this->session->userdata('login_type');
        //$page_data['fee_groups'] = $this->Fees_model->get_fee_groups();
        $page_data['setup_terms'] = $record?$this->Fees_model->get_transport_setup_rel($record->id):array();
        $page_data['fee_terms'] = $this->Fees_model->get_fee_terms();
        $page_data['fines'] = $this->Fees_model->get_fee_fines();
        $page_data['term_setting'] = $term_setting = $this->Fees_model->get_term_setting();
        $page_data['transport_term_setting'] = $term_setting?explode(',',$term_setting->transport_term_setting):array();
        //echo '<pre>';print_r($page_data['terms']);exit;
        $this->load->view('backend/index', $page_data);
    }

    function ajax_get_transport_fee_detail(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $return = array('status'=>'error','msg'=>'Error try again!');

            $fee_term_id = $this->input->post('fee_term_id');
            $fee_term_record = $this->Fees_model->get_term_record($fee_term_id);
            $fines = $this->Fees_model->get_fee_fines();

            $whr = array('fee_term_id'=>$fee_term_id);
            $record = $this->Fees_model->get_transport_fee_setup(false,false,$whr);
            if($record){
                $setup_terms = $record?$this->Fees_model->get_transport_setup_rel($record->id):array();
                //$return['msg'] = 'Terms already created for this fee group';

                $return['status'] = 'success';
                $return['html'] = '';
                foreach($setup_terms as $i=>$term){
                    $return['html'] .= '<div class="term-item" data-term-num="'.$i.'">
                                            <input type="hidden" name="terms['.$i.'][id]" value="'.$term->id.'"/>
                                            <div class="row">
                                                <div class="col-md-6"><h3>Term '.($i+1).'</h3></div>
                                            </div>
                                            <div class="row mt5">
                                                <div class="col-md-3"><label><strong>Term Name</strong></label></div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control input-sm" name="terms['.$i.'][name]" placeholder="Term Name" 
                                                    value="'.$term->name.'"/>
                                                </div>
                                            </div>
                                            <div class="row mt5">
                                                <div class="col-md-3"><strong>Start Date</strong></div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control input-sm dtp" name="terms['.$i.'][start_date]" 
                                                    placeholder="Start Date" autocomplete="off" required value="'.date('Y-m-d',strtotime($term->start_date)).'"/>
                                                </div>
                                            </div>
                                            <div class="row mt5">
                                                <div class="col-md-3"><strong>End Date</strong></div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control input-sm dtp" name="terms['.$i.'][end_date]" 
                                                    placeholder="End Date" autocomplete="off" required value="'.date('Y-m-d',strtotime($term->end_date)).'"/>
                                                </div>
                                            </div>
                                            <div class="row mt5">
                                                <div class="col-md-3"><label><strong>Fine</strong></label></div>
                                                <div class="col-md-9">
                                                    <select data-style="form-control input-sm" class="selectpicker" name="terms['.$i.'][fine_id]">
                                                        <option value="">Select Fine</option>';
                                                        foreach($fines as $fine){
                                                            $return['html'] .= '<option value="'.$fine->id.'" '.($term->fine_id==$fine->id?'selected':'').'>
                                                                                '.$fine->name.' -- '.$fine->value.($fine->value_type==2?'%':'').'
                                                                                </option>';
                                                        }
                                $return['html'] .= '</select>
                                                </div>
                                            </div>

                                            <div class="row mt5">
                                                <div class="col-md-3"><label><strong>'.get_phrase('Amt/Percentage').'</strong></label></div>
                                                <div class="col-md-9">
                                                    <input type="hidden" name="terms['.$i.'][amt_type]" value="2"/>
                                                    <input type="text" class="form-control input-sm" name="terms['.$i.'][amount]" placeholder="Amt/Percentage"/>
                                                </div>
                                            </div>
                                        </div><br/>';
                }                        
                echo json_encode($return);exit;
            }else{
                $return['status'] = 'success';
                //$particulars= $this->Fees_model->get_group_particulars($group_id);
                //$classes= $this->Fees_model->get_group_classes($group_id);
                /* $head_total = 0;
                $return['head_total'] = '<div class="row">
                                            <div class="col-md-6"><strong>Fees Summary</strong></div>
                                          </div>';
                foreach($fee_grp_heads as $gr_head){
                    $head_total += $gr_head->head_amount;
                    $return['head_total'] .= '<div class="row">
                                                <div class="col-md-6"><strong>'.$gr_head->name.'</strong></div>
                                                <div class="col-md-6">'.$gr_head->head_amount.'</div>
                                              </div>';
                }                              
                $return['head_total'] .= '<div class="row">
                                            <div class="col-md-6"><strong>Total</strong></div>
                                            <div class="col-md-6 summary-total">'.$head_total.'</div>
                                          </div>'; */

                $return['net_amt'] = 0;
                $return['html'] = '';
                for($i=0;$i<$fee_term_record->term_num;$i++){
                    $return['html'] .= '<div class="term-item" data-term-num="'.$i.'">
                                            <input type="hidden" name="terms['.$i.'][id]" value=""/>
                                            <div class="row">
                                                <div class="col-md-6"><h3>Term '.($i+1).'</h3></div>
                                                <!--<div class="col-md-6">
                                                    <a class="btn btn-danger btn-sm pull-right remove-term"
                                                        onclick="confirm_act(false,false,true,this,\'.term-item\')">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </div>-->
                                            </div>
                                            <div class="row mt5">
                                                <div class="col-md-3"><label><strong>Term Name</strong></label></div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control input-sm" name="terms['.$i.'][name]" value="Term '.($i+1).'"
                                                     placeholder="Term Name"/>
                                                </div>
                                            </div>
                                            <div class="row mt5">
                                                <div class="col-md-3"><strong>Start Date</strong></div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control input-sm dtp" name="terms['.$i.'][start_date]" placeholder="Start Date" autocomplete="off" required/>
                                                </div>
                                            </div>
                                            <div class="row mt5">
                                                <div class="col-md-3"><strong>End Date</strong></div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control input-sm dtp" name="terms['.$i.'][end_date]" placeholder="End Date" autocomplete="off" required/>
                                                </div>
                                            </div>
                                            <div class="row mt5">
                                                <div class="col-md-3"><label><strong>Fine</strong></label></div>
                                                <div class="col-md-9">
                                                    <select data-style="form-control input-sm" class="selectpicker" name="terms['.$i.'][fine_id]">
                                                        <option value="">Select Fine</option>';
                                                        foreach($fines as $fine){
                                                            $return['html'] .= '<option value="'.$fine->id.'">'.$fine->name.' -- '.$fine->value.($fine->value_type==2?'%':'').'</option>';
                                                        }
                                $return['html'] .= '</select>
                                                </div>
                                            </div>

                                            <div class="row mt5">
                                                <div class="col-md-3"><label><strong>'.get_phrase('Amt/Percentage').'</strong></label></div>
                                                <div class="col-md-9">
                                                    <input type="hidden" name="terms['.$i.'][amt_type]" value="2"/>
                                                    <input type="text" class="form-control input-sm" name="terms['.$i.'][amount]" placeholder="Amt/Percentage"/>
                                                </div>
                                            </div>
                                        </div><br/>';
                }
            }
            echo json_encode($return);exit;
            //echo '<pre>';print_r($collection_group_record);exit;
        }
    }


    /************************Fee Fines*******************************/
    function fines(){
        $page_data = $this->get_page_data_var();
        $running_year = $page_data['running_year'];
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->form_validation->set_rules('name', 'Fine Name', 'trim|required|_unique_field_sch[fee_fines.name#running_year.'.$running_year.']');
            $this->form_validation->set_rules('grace_period', 'Grace Period', 'trim|required');
            $this->form_validation->set_rules('value_type', 'Value type', 'trim|required');
            $this->form_validation->set_rules('value', 'Fine Value', 'trim|required');
            $this->form_validation->set_rules('description', 'Fine Description', 'trim');
            //$this->form_validation->set_rules('running_year', 'Current running year', 'trim|required');
            //$this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() == TRUE) {
                $save_data['name'] = $this->input->post('name');
                $save_data['grace_period'] = $this->input->post('grace_period');
                $save_data['value_type'] = $this->input->post('value_type');
                $save_data['value'] = $this->input->post('value');
                $save_data['description'] = $this->input->post('description');
                $save_data['running_year'] = $running_year;
                $save_data['school_id'] = $this->session->userdata('school_id')?$this->session->userdata('school_id'):0;
                $save_data['created'] = date('Y-m-d H:i:s');
                $save_data['updated'] = date('Y-m-d H:i:s');
                $return = $this->Fees_model->save_fine($save_data);
                    
                if($return){
                    $this->session->set_flashdata('flash_message', get_phrase('fee_fine_has_been_saved_successfully.'));
                    redirect(base_url() . 'index.php?fees/main/fines/', 'refresh');
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('invalid_details.'));
                }
            }else{
                $this->session->set_flashdata('flash_message_error', validation_errors());
            }
        } 
        
        $page_data['page_name'] = 'fees/fines';
        $page_data['page_title'] = get_phrase('fee_fines');
        $page_data['records'] = $this->Fees_model->get_fee_fines();
        //$page_data['fee_categories'] = $this->Fees_model->get_fee_categories();
        //echo '<pre>';print_r($page_data['records'] );exit;
        $this->load->view('backend/index', $page_data);
    }
    
    function fine_edit($id=false){
        $page_data = $this->get_page_data_var();
        $running_year = $page_data['running_year'];
        $page_data['record'] = $rec = $this->Fees_model->get_fine_record($id);
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $is_unique_name = $this->input->post('name')==$rec->name?'':'|_unique_field_sch[fee_fines.name#running_year.'.$running_year.']';
            $this->form_validation->set_rules('name', 'Fine Name', 'trim|required'.$is_unique_name);
            $this->form_validation->set_rules('grace_period', 'Grace Period', 'trim|required');
            $this->form_validation->set_rules('value_type', 'Value type', 'trim|required');
            $this->form_validation->set_rules('value', 'Fine Value', 'trim|required');
            $this->form_validation->set_rules('description', 'Fine Description', 'trim');
            //$this->form_validation->set_rules('running_year', 'Current running year', 'trim|required');
            //$this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() !== FALSE) {
                $save_data['id'] = $id;
                $save_data['name'] = $this->input->post('name');
                $save_data['grace_period'] = $this->input->post('grace_period');
                $save_data['value_type'] = $this->input->post('value_type');
                $save_data['value'] = $this->input->post('value');
                $save_data['description'] = $this->input->post('description');
                $save_data['updated'] = date('Y-m-d H:i:s');
                $return = $this->Fees_model->save_fine($save_data);
                    
                if($return){
                    $this->session->set_flashdata('flash_message', get_phrase('fee_fine_has_updated_successfully.'));
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('invalid_details.'));
                }
            }else {
                $this->session->set_flashdata('flash_message_error', validation_errors());
            }
            redirect(base_url() . 'index.php?fees/main/fines/', 'refresh');
        } 
        $page_data['page_name'] = 'fees/fine_edit';
        $page_data['page_title'] = get_phrase('edit_collection_group');
        $page_data['account_type'] = $this->session->userdata('login_type');
        $this->load->view('backend/index', $page_data);
    }

    function fine_delete($id=false){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->Fees_model->fine_delete(array('id'=>$id));
            echo json_encode(array('status'=>'success','msg'=>'Fee Fine Deleted!'));exit;
        }
    }

    /************************Fee Concessions*******************************/
    function scholarships(){
        $page_data = $this->get_page_data_var();
        $running_year = $page_data['running_year'];
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->form_validation->set_rules('name', 'Name', 'trim|required|_unique_field_sch[fee_scholarships.name#running_year.'.$running_year.']');
            //$this->form_validation->set_rules('description', 'Description', 'trim');
            //$this->form_validation->set_rules('fee_category_id', 'Fee Category', 'trim|required');
            $this->form_validation->set_rules('amt_type', 'Amount Type', 'trim|required');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            //$this->form_validation->set_rules('running_year', 'Current running year', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() == TRUE) {
                $save_data['name'] = $this->input->post('name');
                //$save_data['description'] = $this->input->post('description');
                //$save_data['fee_category_id'] = $this->input->post('fee_category_id');
                $save_data['amt_type'] = $this->input->post('amt_type');
                $save_data['amount'] = $this->input->post('amount');
                $save_data['running_year'] = $running_year;
                $save_data['school_id'] = $this->session->userdata('school_id')?$this->session->userdata('school_id'):0;
                $save_data['created'] = date('Y-m-d H:i:s');
                $save_data['updated'] = date('Y-m-d H:i:s');
                $return = $this->Fees_model->save_fee_scholarhship($save_data);
                    
                if($return){
                    $this->session->set_flashdata('flash_message', get_phrase('fee_concession_has_been_saved_successfully.'));
                    redirect(base_url() . 'index.php?fees/main/scholarships/', 'refresh');
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('invalid_details.'));
                }
            }else{
                $this->session->set_flashdata('flash_message_error', validation_errors());
            }
        } 
        
        $page_data['page_name'] = 'fees/fee_scholarships';
        $page_data['page_title'] = get_phrase('fee_scholarships');
        $page_data['account_type'] = $this->session->userdata('login_type');
        $page_data['records'] = $this->Fees_model->get_fee_scholarships();
        //$page_data['fee_categories'] = $this->Fees_model->get_fee_categories();
        $this->load->view('backend/index', $page_data);
    }

    function scholarship_edit($id=false){
        $page_data = $this->get_page_data_var();
        $running_year = $page_data['running_year'];
        $page_data['record'] = $rec = $this->Fees_model->get_scholarship_record($id);
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $is_unique_name = $this->input->post('name')==$rec->name?'':'|_unique_field_sch[fee_scholarships.name#running_year.'.$running_year.']';
            //echo  $is_unique_name ;exit;
            $this->form_validation->set_rules('name', 'Name', 'trim|required'.$is_unique_name);
            //$this->form_validation->set_rules('description', 'Description', 'trim');
            //$this->form_validation->set_rules('fee_category_id', 'Fee Category', 'trim|required');
            $this->form_validation->set_rules('amt_type', 'Amount Type', 'trim|required');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            //$this->form_validation->set_rules('running_year', 'Current running year', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() !== FALSE) {
                $save_data['id'] = $id;
                $save_data['name'] = $this->input->post('name');
                //$save_data['description'] = $this->input->post('description');
                //$save_data['fee_category_id'] = $this->input->post('fee_category_id');
                $save_data['amt_type'] = $this->input->post('amt_type');
                $save_data['amount'] = $this->input->post('amount');
                $save_data['updated'] = date('Y-m-d H:i:s');
                $return = $this->Fees_model->save_fee_scholarhship($save_data);
                    
                if($return){
                    $this->session->set_flashdata('flash_message', get_phrase('fee_scholarship_has_been_updated_successfully.'));
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('invalid_details.'));
                }
            }else {
                $this->session->set_flashdata('flash_message_error', validation_errors());
            }
            redirect(base_url() . 'index.php?fees/main/scholarships/', 'refresh');
        } 
        //$page_data['fee_categories'] = $this->Fees_model->get_fee_categories();
        $this->load->view('backend/school_admin/fees/modal_edit_scholarship',$page_data);
    }

    function scholarship_delete($id=false){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->Fees_model->scholarship_delete(array('id'=>$id));
            echo json_encode(array('status'=>'success','msg'=>'Fee Scholarship Deleted!'));exit;
        }
    }

    /************************Other Functions*******************************/
    public function collection(){
        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'fees/fee_collection';
        $page_data['page_title'] = get_phrase('fee_collection');
        $page_data['account_type'] = $this->session->userdata('login_type');
        $page_data['classes'] = $this->Fees_model->get_classes();
        $this->load->view('backend/index', $page_data);
    }

    function generate_invoice($year=false,$stu_status=false,$stu_id=false,$fee_type=false,$fee_id=false){
        $page_data = $this->get_page_data_var();
       
        $total_fees = 0;
        if($stu_status==1){
            $stu_rec = $this->Ajax_model->get_student(array('S.student_id'=>$stu_id));
            $group_rec = $this->Ajax_model->get_fee_group(array('FRGC.class_id'=>$stu_rec->class_id));
            $stu_config = $this->Ajax_model->get_stu_config_rec(array('student_id'=>$stu_id));

            $whr_col = array('student_status'=>$stu_status,
                             'student_id'=>$stu_id,
                             'class_id'=>$stu_rec->class_id,
                             'fee_type'=>$fee_type,
                             'fee_id'=>$fee_id);
            $hav_collrec = $this->Ajax_model->get_fee_collection_record($whr_col);
            
            _school_cond();
            _year_cond();
            $whr_cond = array('student_id'=>$stu_id,'stu_status'=>$stu_status,'fee_type'=>$fee_type,'fee_id'=>$fee_id);
            $has_record = $this->db->get_where('fee_invoices',$whr_cond)->row();
            if($has_record){
                if($hav_collrec){
                    $this->db->update('fee_invoices',array('is_paid'=>$hav_collrec->is_paid),array('id'=>$has_record->id));
                }
                redirect('index.php?fees/prints/invoice/'.$has_record->id);
            }

            //Last Record
            _school_cond();
            _year_cond();
            $last_inv_rec = $this->db->order_by('id','DESC')->get('fee_invoices')->row();
            $save_invoice = array('student_id'=>$stu_id,
                                  'stu_status'=>$stu_status,
                                  'fee_type'=>$fee_type,
                                  'fee_id'=>$fee_id,
                                  'number'=>($last_inv_rec?($last_inv_rec->number+1):1));

            
            $save_invoice_items = array();
            if($fee_type==1){ 
                $school_term = $this->db->get_where('fee_setup_terms',array('id'=>$fee_id))->row();
                $due_date = date('Y-m-d',strtotime($school_term->start_date));
                $fee_heads = $this->Ajax_model->get_stu_fee_detail($fee_id);
                
                foreach($fee_heads as $ik=>$hd){
                    $total_fees += $hd->amount;
                    $save_invoice_items[] = array('item_type'=>$fee_type,
                                                  'item_id'=>$hd->id,
                                                  'item_name'=>$hd->name,
                                                  'item_amt'=>$hd->amount,
                                                  'added'=>date('Y-m-d H:i:s'));
                }
            }else if($fee_type==2){
                $hostel_terms = $this->db->get_where('fee_hotel_setup_terms',array('id'=>$fee_id))->result();
                $due_date = date('Y-m-d',strtotime($hostel_terms[0]->start_date));
                $room_rec = $this->db->get_where('hostel_room',array('hostel_room_id'=>$stu_config->room_id))->row();
                foreach($hostel_terms as $ik=>$rec){
                    $hostel_fee_setup = $this->db->get_where('fee_hostel_charge_setups',array('id'=>$rec->setup_id))->row();
                    $sterm_rec = $this->db->get_where('fee_terms',array('id'=>$hostel_fee_setup->fee_term_id))->row();
                    $fee_amt = $rec->amt_type==1?$rec->amount:round(($room_rec->room_fare*$rec->amount)/100,2);
                    $total_fees += $fee_amt;
                    
                    $save_invoice_items[] = array('item_type'=>$fee_type,
                                                  'item_id'=>$rec->id,
                                                  'item_name'=>$rec->name,
                                                  'item_amt'=>$fee_amt,
                                                  'added'=>date('Y-m-d H:i:s'));
                }                    
    
            }else if($fee_type==3){
                $transport_terms = $this->db->get_where('fee_transport_setup_terms',array('id'=>$fee_id))->result();
                $due_date = date('Y-m-d',strtotime($transport_terms[0]->start_date));
                $stop_rec = $this->db->get_where('route_bus_stop',array('route_bus_stop_id'=>$stu_config->route_stop_id))->row();
                foreach($transport_terms as $ik=>$rec){
                    $transport_fee_setup = $this->db->get_where('fee_transport_charge_setups',array('fee_term_id'=>$rec->setup_id))->row();
                    $sterm_rec = $this->db->get_where('fee_terms',array('id'=>$transport_fee_setup->fee_term_id))->row();
                    $fee_amt = $rec->amt_type==1?$rec->amount:round(($stop_rec->route_fare*$rec->amount)/100,2);
                    $total_fees += $fee_amt;
    
                    $save_invoice_items[] = array('item_type'=>$fee_type,
                                                  'item_id'=>$rec->id,
                                                  'item_name'=>$rec->name,
                                                  'item_amt'=>$fee_amt,
                                                  'added'=>date('Y-m-d H:i:s'));
                }
            }
        }else{
            redirect('/');
           /*  $page_data['student'] = $this->Ajax_model->get_non_enroll_student(array('enquired_student_id'=>$stu_id));
            $page_data['page_name'] = 'fees/print/invoice-non-enroll';
            $page_data['inv_date'] = date('Y-m-d');

            $fee_heads = $this->Ajax_model->get_non_enroll_heads(array('id'=>$fee_id)); 
            foreach($fee_heads as $ik=>$hd){
                $total_fees += $hd->amount;
                $page_data['fee_detail_body'] .= '<tr class="item-row">
                                                    <td class="description">'.$hd->name.'</td>
                                                    <td colspan="2" align="right"><span class="price">'.sett('currency').' '.$hd->amount.'</span></td>
                                                  </tr>';
            } */
        }
        $save_invoice['total_amt'] = $total_fees;
        $save_invoice['due_date'] = $due_date;
        if($hav_collrec){
            $save_invoice['is_paid'] = $hav_collrec->is_paid;
        }
        
        $save_invoice['running_year'] = _getYear();
        $save_invoice['school_id'] = _getSchoolid();
        $save_invoice['created'] = date('Y-m-d H:i:s');
        $inv_flag = $this->db->insert('fee_invoices',$save_invoice);
        $invoice_id = $this->db->insert_id();


        foreach($save_invoice_items as $item){
            $item['invoice_id'] = $invoice_id;
            $flag = $this->db->insert('fee_invoice_items',$item);
        }

        redirect('index.php?fees/prints/invoice/'.$invoice_id);
    }

    public function structure(){
        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'fees/fee_structure';
        $page_data['page_title'] = get_phrase('fee_structure');
        $page_data['account_type'] = $this->session->userdata('login_type');
        $page_data['classes'] = $this->Fees_model->get_classes();
        $this->load->view('backend/index', $page_data);
    }

    function dues(){
        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'fees/fee_dues_report';
        $page_data['page_title'] = get_phrase('fee_dues');
        $page_data['account_type'] = $this->session->userdata('login_type');
        $page_data['classes'] = $this->Fees_model->get_classes();
        $this->load->view('backend/index', $page_data);
    }

    //Employee Payslip
    function generated_payslips(){
        $page_data = $this->get_page_data_var();
        $page_data['role_id'] = false;
        $page_data['month'] = $month = date('m-Y');
        $whr = array();
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $page_data['role_id'] = $this->input->post('role_id');
            $page_data['month'] = $month = $this->input->post('month');
            $whr['ES.emprole'] = $this->input->post('role_id');
        }

        $page_data['page_name'] = 'fees/employee/generated_payslips';
        $page_data['page_title'] = get_phrase('generated_payslips');
        $page_data['account_type'] = $this->session->userdata('login_type');
        $page_data['roles'] = $this->Fees_model->get_employee_roles($month);
        $page_data['generated_payslips'] = $this->Fees_model->generated_employe_payslips($month);
        //echo '<pre>';print_r($page_data['generated_payslips'] );exit;
        $this->load->view('backend/index', $page_data);
    }

    function approved_payslips(){
        $page_data = $this->get_page_data_var();
        $page_data['role_id'] = false;
        $page_data['month'] = $month = date('m-Y');
        $whr = array('PP.is_paid'=> 1);
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $page_data['role_id'] = $this->input->post('role_id');
            $page_data['month'] = $month = $this->input->post('month');
            $whr['ES.emprole'] = $this->input->post('role_id');
        }

        $page_data['page_name'] = 'fees/employee/approved_payslips';
        $page_data['page_title'] = get_phrase('approved_payslips');
        $page_data['account_type'] = $this->session->userdata('login_type');
        $page_data['roles'] = $this->Fees_model->get_employee_roles($month);
        $page_data['approved_payslips'] = $this->Fees_model->generated_employe_payslips($month);
        $this->load->view('backend/index', $page_data);
    }

    function paynow(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $payslip_id = $this->input->post('payslip_id');
        
            //Update Payslip
            $this->db->update('payroll_payslip',array('is_paid'=>1),array('id'=>$payslip_id));
            echo 'success';exit;
        }
    }
    
    /* function ajax_get_student_collections(){
       if($this->input->server('REQUEST_METHOD')=='POST'){
           $stu_id = $this->input->post('student_id');
           $enroll = $this->db->get_where('enroll',array('student_id'=>$stu_id))->row();
           $group_rel = $this->db->get_where('fee_rel_group_class',array('class_id'=>$enroll->class_id))->row();  
           $col_group = $this->db->get_where('fee_collection_groups',array('fee_group_id'=>$group_rel->group_id))->row();
           $collections = $this->db->get_where('fee_collections',array('collection_group_id'=>$col_group->id))->result();
           $return = array('html'=>'<option value="">Select Collection</option>');
           foreach($collections as $coll){
               $return['html'] .= '<option value="'.$coll->id.'">'.$coll->name.' -- '.$coll->amount.'</option>';
           }
           echo json_encode($return);exit;
       }
    }

    function ajax_get_collection_particulars(){
       if($this->input->server('REQUEST_METHOD')=='POST'){
           $col_id = $this->input->post('collection_id');
           $parti = $this->db->get_where('fee_collection_particulars',array('collection_id'=>$col_id))->result();
           $return = array('html'=>'');
           foreach($parti as $part){
               $return['html'] .= '<tr>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td><input type="text" class="form-control input-sm" value="'.$part->amount.'"/></td>
                                    <td>0.00</td>
                                    <td><input type="text" class="form-control input-sm" value="'.$part->amount.'"/></td>
                                  </tr>';
           }
           echo json_encode($return);exit;
       }
    } */
    
    public function day_end(){
        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'fees/day_end';
        $page_data['page_title'] = get_phrase('day_end');
        $page_data['total_collection'] = 0;
        $page_data['collecs'] = array('cash'=>0,'cheque'=>0,'card'=>0,'online'=>0); 
        _school_cond();
        _year_cond();
        $close_rec = $this->db->get_where('fi_day_end_process',array('DATE(date)'=>date('Y-m-d')))->row();
        $page_data['closed'] = $close_rec?1:0;
        

        _school_cond();
        _year_cond();
        $pay_transactions = $this->db->get_where('fee_pay_transactions',array('DATE(created)'=>date('Y-m-d')))->result();
        foreach($pay_transactions as $trn){
            $page_data['total_collection'] += $trn->paid_amount;
            $page_data['collecs'][$trn->pay_method] += $trn->paid_amount;
        }
        $this->load->view('backend/index', $page_data);
    }

    function do_day_end(){
        $save_data = array('date'=>date('Y-m-d H:i:S'),
                           'closed'=>1,
                           'running_year'=>_getYear(),
                           'school_id'=>_getSchoolid());
        $this->db->insert('fi_day_end_process',$save_data);
        
        $this->session->set_flashdata('flash_message', get_phrase('fee_collection_closed_for_today.'));
        redirect(base_url() . 'index.php?fees/main/day_end/', 'refresh');
    }
    
    public function approvals(){
        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'fees/approvals';
        $page_data['page_title'] = get_phrase('approvals');
        $this->load->view('backend/index', $page_data);
    }
    
    function get_sections_by_class($class_id) {
        $page_data = $this->get_page_data_var();
        $this->load->model("Section_model");
        $sections = $this->Section_model->get_section_by_classid($class_id);
        $options = '';
        $options = '<option value="">Select Section</option>';
        
        foreach($sections as $key=>$section) {
            $options .= '<option value="'.$section['section_id'].'">'.$section['name'].'</option>';
        }
        echo $options;
        exit;
    }

    public function fi_category($param1='', $param2=''){
        if(($this->session->userdata('school_admin_login') == 1) || ($this->session->userdata('accountant_login') == 1)){
            $page_data = $this->get_page_data_var();

            if($param1=='add'){
                $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');                
                $this->form_validation->set_rules('category_type', 'Category Type', 'trim|required');
                $this->form_validation->set_rules('description', 'Description', 'trim|required');

                 if ($this->form_validation->run() == FALSE){
                    $this->session->set_flashdata('flash_message_error',validation_errors());
                 }else {
                    $data = $this->input->post();
                    $data['school_id'] = $this->session->userdata('school_id');            
                    $id = $this->Fees_model->add_fi_category($data);
                    if($id){
                        $this->session->set_flashdata('flash_message','Category has been added successfully');
                    }else{
                        $this->session->set_flashdata('flash_message_error', get_phrase('something_went_wrong.'));
                    }
                 }
                 redirect(base_url() . 'index.php?fees/main/fi_category', 'refresh');    
            }else if(($param1=='update') &&($param2!='')){
                $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');                
                $this->form_validation->set_rules('category_type', 'Category Type', 'trim|required');
                $this->form_validation->set_rules('description', 'Description', 'trim|required');

                if ($this->form_validation->run() == FALSE){
                    $this->session->set_flashdata('flash_message_error',validation_errors());
                }else {
                    $data = $this->input->post();            
                    $this->Fees_model->update_fi_category($data, $param2);
                    $this->session->set_flashdata('flash_message','Category has been updated successfully');
                }                    
            }else if(($param1=='delete') &&($param2!='')){
                $this->Fees_model->delete_fi_category($param2);
                $this->session->set_flashdata('flash_message','Category has been deleted successfully');
                redirect(base_url() . 'index.php?fees/main/fi_category', 'refresh');
            }
            
            $page_data['page_name'] = 'fees/fi_category';
            $page_data['page_title'] = 'finance categoty';
            $page_data['data'] = $this->Fees_model->get_all_fi_category();        
            $page_data['arrAllLinks'] = $this->session->userdata('arrAllLinks');
            $this->load->view('backend/index', $page_data);    
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


    
