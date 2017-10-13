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
    
    function __construct() {
        parent::__construct();
        //pre($this->session->userdata); die;
        $this->load->model(array('Setting_model','Fees/Fees_model','Class_model'));
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

        //echo $this->session->userdata('school_id');exit;
        //echo '<pre>';print_r($this->session->all_userdata());exit;
        if ($this->session->userdata('school_admin_login') != 1 && $this->session->userdata('accountant_login' != 1))
            redirect(base_url(), 'refresh');
    }
    /***default functin, redirects to login page if no admin logged in yet** */

    function index() {
        //redirect(base_url() . 'index.php?fees/list', 'refresh');
    }

    /************************Fee Categories*******************************/
    /* function categories(){
        $page_data = $this->get_page_data_var();
        $running_year = $page_data['running_year'];
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->form_validation->set_rules('running_year', 'Current running year', 'trim|required');
            $this->form_validation->set_rules('cat_name', 'Category Name', 'trim|required|_unique_field_sch[fee_categories.cat_name#running_year.'.$running_year.']');
            $this->form_validation->set_rules('cat_desc', 'Category Description', 'trim');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() == TRUE) {
                $save_data['cat_name'] = $this->input->post('cat_name');
                $save_data['cat_desc'] = $this->input->post('cat_desc');
                $save_data['running_year'] = $this->input->post('running_year');
                $save_data['school_id'] = $this->session->userdata('school_id')?$this->session->userdata('school_id'):0;
                $save_data['created'] = date('Y-m-d H:i:s');
                $save_data['updated'] = date('Y-m-d H:i:s');
                //echo '<pre>';print_r($save_data);exit;
                $return = $this->Fees_model->save_fee_category($save_data);
                    
                if($return){
                    $this->session->set_flashdata('flash_message', get_phrase('fee_category_has_been_saved_successfully.'));
                    redirect(base_url() . 'index.php?fees/fees/categories/', 'refresh');
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('invalid_details.'));
                }
            }else{
                $this->session->set_flashdata('flash_message_error', validation_errors());
            }
        } 
        
        $page_data['page_name'] = 'fees/fee_categories';
        $page_data['page_title'] = get_phrase('fee_categories');
        $page_data['account_type'] = $this->session->userdata('login_type');
        $page_data['fee_categories'] = $this->Fees_model->get_fee_categories();
        $this->load->view('backend/index', $page_data);
    }
    
    function category_edit($cat_id=false){
        $page_data = $this->get_page_data_var();
        $running_year = $page_data['running_year'];
        $page_data['cat_record'] = $cat_rec = $this->Fees_model->get_category_record($cat_id);
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $is_unique_name = $this->input->post('cat_name')==$cat_rec->cat_name?'':'|_unique_field_sch[fee_categories.cat_name#running_year.'.$running_year.']';
            //echo $is_unique_name;exit;
            $this->form_validation->set_rules('running_year', 'Current running year', 'trim|required'); 
            $this->form_validation->set_rules('cat_name', 'Category Name', 'trim|required'.$is_unique_name);
            $this->form_validation->set_rules('cat_desc', 'Category Description', 'trim');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() !== FALSE) {
                $save_data['cat_id'] = $cat_id;
                $save_data['cat_name'] = $this->input->post('cat_name');
                $save_data['cat_desc'] = $this->input->post('cat_desc');
                $save_data['running_year'] = $this->input->post('running_year');
                $save_data['updated'] = date('Y-m-d H:i:s');
                $return = $this->Fees_model->save_fee_category($save_data);
                    
                if($return){
                    $this->session->set_flashdata('flash_message', get_phrase('fee_category_has_been_updated_successfully.'));
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('invalid_details.'));
                }
            }else {
                $this->session->set_flashdata('flash_message_error', validation_errors());
            }
            redirect(base_url() . 'index.php?fees/fees/categories/', 'refresh');
        } 
        $this->load->view('backend/school_admin/fees/modal_edit_category',$page_data);
    }

    function category_delete($id=false){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->Fees_model->category_delete(array('cat_id'=>$id));
            echo json_encode(array('status'=>'success','msg'=>'Category Deleted!'));exit;
        }
    } */

    /************************Fee Particulars*******************************/
    /* function particulars(){
        $page_data = $this->get_page_data_var();
        $running_year = $page_data['running_year'];
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->form_validation->set_rules('running_year', 'Current running year', 'trim|required');
            $this->form_validation->set_rules('fee_category_id', 'Fee Category', 'trim|required');
            $this->form_validation->set_rules('name', 'Particular Name', 'trim|required|_unique_field_sch[fee_particulars.name#running_year.'.$running_year.']');
            $this->form_validation->set_rules('description', 'Particular Description', 'trim');
            //$this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() == TRUE) {
                $save_data['name'] = $this->input->post('name');
                $save_data['description'] = $this->input->post('description');
                $save_data['fee_category_id'] = $this->input->post('fee_category_id');
                //$save_data['amount'] = $this->input->post('amount');
                $save_data['running_year'] = $this->input->post('running_year');
                $save_data['school_id'] = $this->session->userdata('school_id')?$this->session->userdata('school_id'):0;
                $save_data['created'] = date('Y-m-d H:i:s');
                $save_data['updated'] = date('Y-m-d H:i:s');
                $return = $this->Fees_model->save_fee_particular($save_data);
                    
                if($return){
                    $this->session->set_flashdata('flash_message', get_phrase('fee_particular_has_been_saved_successfully.'));
                    redirect(base_url() . 'index.php?fees/fees/particulars/', 'refresh');
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('invalid_details.'));
                }
            }else{
                $this->session->set_flashdata('flash_message_error', validation_errors());
            }
        } 
        
        $page_data['page_name'] = 'fees/fee_particulars';
        $page_data['page_title'] = get_phrase('fee_particulars');
        $page_data['records'] = $this->Fees_model->get_fee_particulars();
        $page_data['fee_categories'] = $this->Fees_model->get_fee_categories();
        //echo '<pre>';print_r($page_data['records'] );exit;
        $this->load->view('backend/index', $page_data);
    }
    
    function particular_edit($id=false){
        $page_data = $this->get_page_data_var();
        $running_year = $page_data['running_year'];
        $page_data['record'] = $rec = $this->Fees_model->get_particular_record($id);
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $is_unique_name = $this->input->post('name')==$rec->name?'':'|_unique_field_sch[fee_particulars.name#running_year.'.$running_year.']';
            //echo  $is_unique_name ;exit;
            $this->form_validation->set_rules('running_year', 'Current running year', 'trim|required');
            $this->form_validation->set_rules('fee_category_id', 'Fee Category', 'trim|required');
            $this->form_validation->set_rules('name', 'Particular Name', 'trim|required'.$is_unique_name);
            $this->form_validation->set_rules('description', 'Particular Description', 'trim');
            //$this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() !== FALSE) {
                $save_data['id'] = $id;
                $save_data['name'] = $this->input->post('name');
                $save_data['description'] = $this->input->post('description');
                $save_data['fee_category_id'] = $this->input->post('fee_category_id');
                //$save_data['amount'] = $this->input->post('amount');
                $save_data['running_year'] = $this->input->post('running_year');
                $save_data['school_id'] = $this->session->userdata('school_id')?$this->session->userdata('school_id'):0;
                $save_data['updated'] = date('Y-m-d H:i:s');
                $return = $this->Fees_model->save_fee_particular($save_data);
                    
                if($return){
                    $this->session->set_flashdata('flash_message', get_phrase('fee_particular_has_been_updated_successfully.'));
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('invalid_details.'));
                }
            }else {
                $this->session->set_flashdata('flash_message_error', validation_errors());
            }
            redirect(base_url() . 'index.php?fees/fees/particulars/', 'refresh');
        } 
        $page_data['fee_categories'] = $this->Fees_model->get_fee_categories();
        $this->load->view('backend/school_admin/fees/modal_edit_particular',$page_data);
    }

    function particular_delete($id=false){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->Fees_model->particular_delete(array('id'=>$id));
            echo json_encode(array('status'=>'success','msg'=>'Fee Particular Deleted!'));exit;
        }
    }*/

    /************************Fee Particulars*******************************/
    function heads(){
        $page_data = $this->get_page_data_var();
        $running_year = $page_data['running_year'];
        if($this->input->server('REQUEST_METHOD')=='POST'){
            //$this->form_validation->set_rules('running_year', 'Current running year', 'trim|required');
            $this->form_validation->set_rules('name', 'Particular Name', 'trim|required|_unique_field_sch[fee_heads.name#running_year.'.$running_year.']');
            $this->form_validation->set_rules('description', 'Particular Description', 'trim');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() == TRUE) {
                $save_data['name'] = $this->input->post('name');
                $save_data['description'] = $this->input->post('description');
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
            $is_unique_name = $this->input->post('name')==$rec->name?'':'|_unique_field_sch[fee_heads.name#running_year.'.$running_year.']';
            //$this->form_validation->set_rules('running_year', 'Current running year', 'trim|required');
            $this->form_validation->set_rules('name', 'Particular Name', 'trim|required'.$is_unique_name);
            $this->form_validation->set_rules('description', 'Particular Description', 'trim');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() !== FALSE) {
                $save_data['id'] = $id;
                $save_data['name'] = $this->input->post('name');
                $save_data['description'] = $this->input->post('description');
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
            //$this->form_validation->set_rules('running_year', 'Current running year', 'trim|required');
            $this->form_validation->set_rules('name', 'Group Name', 'trim|required|_unique_field_sch[fee_groups.name#running_year.'.$running_year.']');
            $this->form_validation->set_rules('description', 'Group Description', 'trim');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() == TRUE) {
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
        $page_data['heads'] = $this->Fees_model->get_fee_heads();
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
            $this->form_validation->set_rules('description', 'Group Description', 'trim');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() !== FALSE) {
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
        $page_data['heads'] = $this->Fees_model->get_fee_heads();
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
            $this->Fees_model->category_delete(array('cat_id'=>$id));
            echo json_encode(array('status'=>'success','msg'=>'Category Deleted!'));exit;
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
            $this->form_validation->set_rules('fee_category_id', 'Fee Category', 'trim|required');
            $this->form_validation->set_rules('amt_type', 'Amount Type', 'trim|required');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            $this->form_validation->set_rules('running_year', 'Current running year', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() == TRUE) {
                $save_data['type'] = $this->input->post('type');
                $save_data['name'] = $this->input->post('name');
                $save_data['description'] = $this->input->post('description');
                $save_data['fee_category_id'] = $this->input->post('fee_category_id');
                $save_data['amt_type'] = $this->input->post('amt_type');
                $save_data['amount'] = $this->input->post('amount');
                $save_data['running_year'] = $this->input->post('running_year');
                $save_data['school_id'] = $this->session->userdata('school_id')?$this->session->userdata('school_id'):0;
                $save_data['created'] = date('Y-m-d H:i:s');
                $save_data['updated'] = date('Y-m-d H:i:s');
                $return = $this->Fees_model->save_fee_concession($save_data);
                    
                if($return){
                    $this->session->set_flashdata('flash_message', get_phrase('fee_concession_has_been_saved_successfully.'));
                    redirect(base_url() . 'index.php?fees/fees/concessions/', 'refresh');
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
        $page_data['fee_categories'] = $this->Fees_model->get_fee_categories();
        //echo '<pre>';print_r($page_data['records'] );exit;
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
            $this->form_validation->set_rules('fee_category_id', 'Fee Category', 'trim|required');
            $this->form_validation->set_rules('amt_type', 'Amount Type', 'trim|required');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            $this->form_validation->set_rules('running_year', 'Current running year', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() !== FALSE) {
                $save_data['id'] = $id;
                $save_data['type'] = $this->input->post('type');
                $save_data['name'] = $this->input->post('name');
                $save_data['description'] = $this->input->post('description');
                $save_data['fee_category_id'] = $this->input->post('fee_category_id');
                $save_data['amt_type'] = $this->input->post('amt_type');
                $save_data['amount'] = $this->input->post('amount');
                $save_data['running_year'] = $this->input->post('running_year');
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
            redirect(base_url() . 'index.php?fees/fees/concessions/', 'refresh');
        } 
        $page_data['fee_categories'] = $this->Fees_model->get_fee_categories();
        $this->load->view('backend/school_admin/fees/modal_edit_concession',$page_data);
    }

    function concession_assign($id=false){
        $page_data = $this->get_page_data_var();
        $running_year = $page_data['running_year'];
        $page_data['record'] = $rec = $this->Fees_model->get_concession_record($id);
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $flag = $this->Fees_model->save_concession_rel($id,$this->input->post('items'));
            $this->session->set_flashdata('flash_message', get_phrase('concession_has_been_assigned_successfully.'));
            redirect(base_url() . 'index.php?fees/fees/concessions/', 'refresh');
        } 
        if($rec->type==1)
            $page_data['classes'] = $this->Fees_model->get_classes();
        else
            $page_data['students'] = $this->Fees_model->get_students();
        $this->load->view('backend/school_admin/fees/modal_assign_concession',$page_data);
    }

    function concession_delete($id=false){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->Fees_model->concession_delete(array('id'=>$id));
            echo json_encode(array('status'=>'success','msg'=>'Fee Concession Deleted!'));exit;
        }
    }
    
    /************************Fee Collections*******************************/
    function collection_groups(){
        $page_data = $this->get_page_data_var();
        $running_year = $page_data['running_year'];
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->form_validation->set_rules('name', 'Group Name', 'trim|required|_unique_field_sch[fee_collection_groups.name#running_year.'.$running_year.']');
            $this->form_validation->set_rules('description', 'Group Description', 'trim');
            $this->form_validation->set_rules('fee_group_id', 'Fee Group', 'trim|required');
            $this->form_validation->set_rules('running_year', 'Current running year', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() == TRUE) {
                //echo '<pre>';print_r($_POST);exit;
                $save_data['name'] = $this->input->post('name');
                $save_data['description'] = $this->input->post('description');
                $save_data['fee_group_id'] = $this->input->post('fee_group_id');
                $save_data['running_year'] = $this->input->post('running_year');
                $save_data['school_id'] = $this->session->userdata('school_id')?$this->session->userdata('school_id'):0;
                $save_data['created'] = date('Y-m-d H:i:s');
                $save_data['updated'] = date('Y-m-d H:i:s');
                $group_id = $this->Fees_model->save_collection_group($save_data);
                $collections_data = $this->input->post('collections');
                $flag = $this->Fees_model->save_collection_group_collections($group_id,$collections_data);
                //$flag = $this->Fees_model->save_group_relation($group_id,$this->input->post('particulars'),$this->input->post('classes'));

                if($group_id){
                    $this->session->set_flashdata('flash_message', get_phrase('collection_group_has_created_successfully.'));
                    redirect(base_url() . 'index.php?fees/fees/collection_groups/', 'refresh');
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('invalid_details.'));
                }
            }else{
                $this->session->set_flashdata('flash_message_error', validation_errors());
            }
        } 
        
        $page_data['page_name'] = 'fees/collection_groups';
        $page_data['page_title'] = get_phrase('fee_collection_groups');
        $page_data['account_type'] = $this->session->userdata('login_type');
        $page_data['fee_groups'] = $this->Fees_model->get_fee_groups();
        $page_data['records'] = $this->Fees_model->get_collection_groups();
        $this->load->view('backend/index', $page_data);
    }
    
    function collection_group_edit($_id=false){
        $page_data = $this->get_page_data_var();
        $running_year = $page_data['running_year'];
        $page_data['record'] = $rec = $this->Fees_model->get_collection_group_record(array('id'=>$_id));
        if(!$rec){
            redirect('index.php?fees/fees/collection_groups');
        }
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $is_unique_name = $this->input->post('name')==$rec->name?'':'|_unique_field_sch[fee_collection_groups.name#running_year.'.$running_year.']';
            $this->form_validation->set_rules('name', 'Group Name', 'trim|required'.$is_unique_name);
            $this->form_validation->set_rules('description', 'Group Description', 'trim');
            $this->form_validation->set_rules('fee_group_id', 'Fee Group', 'trim|required');
            $this->form_validation->set_rules('running_year', 'Current running year', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() !== FALSE) {
                $save_data['id'] = $_id;
                $save_data['name'] = $this->input->post('name');
                $save_data['description'] = $this->input->post('description');
                $save_data['fee_group_id'] = $this->input->post('fee_group_id');
                $save_data['running_year'] = $this->input->post('running_year');
                $save_data['school_id'] = $this->session->userdata('school_id')?$this->session->userdata('school_id'):0;
                $save_data['updated'] = date('Y-m-d H:i:s');
                $group_id = $this->Fees_model->save_collection_group($save_data);
                $collections_data = $this->input->post('collections');
                $flag = $this->Fees_model->save_collection_group_collections($group_id,$collections_data);

                if($group_id){
                    $this->session->set_flashdata('flash_message', get_phrase('collection_group_has_updated_successfully.'));
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('invalid_details.'));
                }
            }else {
                $this->session->set_flashdata('flash_message_error', validation_errors());
            }
            redirect(base_url() . 'index.php?fees/fees/collection_groups/', 'refresh');
        } 
        $page_data['page_name'] = 'fees/collection_group_edit';
        $page_data['page_title'] = get_phrase('edit_collection_group');
        $page_data['account_type'] = $this->session->userdata('login_type');
        $page_data['fee_groups'] = $this->Fees_model->get_fee_groups();
        $page_data['collections'] = $this->Fees_model->get_collection_group_rel($_id);
        $page_data['particulars'] = $this->Fees_model->get_group_particulars($rec->fee_group_id);
        //echo '<pre>';print_r($page_data['collections']);exit;
        $this->load->view('backend/index', $page_data);
    }

    function collection_group_delete($_id=false){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->Fees_model->collection_group_delete(array('id'=>$_id));
            echo json_encode(array('status'=>'success','msg'=>'Collection Group Deleted!'));exit;
        }
    }
    
    function ajax_get_fee_group_detail(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            //echo '<pre>';print_r($_POST);exit;
            $return = array('status'=>'error','msg'=>'Error try again!');

            $running_year = $this->input->post('running_year');
            $group_id = $this->input->post('fee_group_id');
            _school_cond();
            _year_cond('running_year',$running_year);
            $whr = array('fee_group_id'=>$this->input->post('fee_group_id'));
            $collection_group_record= $this->Fees_model->get_collection_group_record($whr);
            if($collection_group_record){
                $return['msg'] = 'Collections already created for this fee group';
                echo json_encode($return);exit;
            }else{
                $return['status'] = 'success';
                $particulars= $this->Fees_model->get_group_particulars($group_id);
                $classes= $this->Fees_model->get_group_classes($group_id);
                $return['particulars_select'] = '';
                foreach($particulars as $par){
                    $return['particulars_select'] .= '<option value="'.$par->id.'">'.$par->name.'</option>';
                }

                //echo '<pre>';print_r($particulars);print_r($groups);exit;
            }
            echo json_encode($return);exit;
            echo '<pre>';print_r($collection_group_record);exit;
        }
    }
    
    function collection_delete($_id=false){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->Fees_model->collection_delete(array('id'=>$_id));
            echo json_encode(array('status'=>'success','msg'=>'Collection Deleted!'));exit;
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
            $this->form_validation->set_rules('running_year', 'Current running year', 'trim|required');
            //$this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() == TRUE) {
                $save_data['name'] = $this->input->post('name');
                $save_data['grace_period'] = $this->input->post('grace_period');
                $save_data['value_type'] = $this->input->post('value_type');
                $save_data['value'] = $this->input->post('value');
                $save_data['description'] = $this->input->post('description');
                $save_data['running_year'] = $this->input->post('running_year');
                $save_data['school_id'] = $this->session->userdata('school_id')?$this->session->userdata('school_id'):0;
                $save_data['created'] = date('Y-m-d H:i:s');
                $save_data['updated'] = date('Y-m-d H:i:s');
                $return = $this->Fees_model->save_fine($save_data);
                    
                if($return){
                    $this->session->set_flashdata('flash_message', get_phrase('fee_fine_has_been_saved_successfully.'));
                    redirect(base_url() . 'index.php?fees/fees/fines/', 'refresh');
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
            $this->form_validation->set_rules('running_year', 'Current running year', 'trim|required');
            //$this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() !== FALSE) {
                $save_data['id'] = $id;
                $save_data['name'] = $this->input->post('name');
                $save_data['grace_period'] = $this->input->post('grace_period');
                $save_data['value_type'] = $this->input->post('value_type');
                $save_data['value'] = $this->input->post('value');
                $save_data['description'] = $this->input->post('description');
                $save_data['running_year'] = $this->input->post('running_year');
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
            redirect(base_url() . 'index.php?fees/fees/fines/', 'refresh');
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

    /************************Other Functions*******************************/
    public function collection(){
        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'fees/fee_collection';
        $page_data['page_title'] = get_phrase('fee_collection');
        $page_data['classes'] = $this->Class_model->get_class_array();
        $page_data['students'] = $this->db->order_by('name','asc')->get_where('student')->result();
        $this->load->view('backend/index', $page_data);
    }

    function ajax_get_student_collections(){
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
    }
    
    public function day_end(){
        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'fees/day_end';
        $page_data['page_title'] = get_phrase('day_end');
        $page_data['classes'] = $this->Class_model->get_class_array();
        $this->load->view('backend/index', $page_data);
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


    
