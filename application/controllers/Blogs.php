<?php
/**
 * Author : Meera Nicholas
 * Date Created: January 2017
 * Purpose: All functionalities related to blogs for all logins
***/
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blogs extends CI_Controller {
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
        $this->load->model("Blog_model");
        $this->load->model("Blog_category_model");
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
    
    public function create_blog() {
        $page_data= $this->get_page_data_var();         
        $user_data                                            =    $this->get_user_type_id();
        $this->form_validation->set_rules('blog_title', 'Blog Title', 'required');
        $this->form_validation->set_rules('blog_content', 'Blog Content', 'required'); 
        if ($this->form_validation->run() == TRUE) {
            
            $user_data                                      =   $this->get_user_type_id(); 
            $create_blog['blog_title']                      =   $this->input->post('blog_title');
            $create_blog['blog_information']                =   $this->input->post('blog_content');
            $create_blog['blog_author_id']                  =   $user_data['user_id'];
            $create_blog['blog_user_type']                  =   $user_data['user_type'];
            $create_blog['blog_user_name']                  =   $user_data['user_name'];
            $create_blog['blog_resend_comment']             =   '';   
            $create_blog['blog_created_time']               =   date('Y-m-d H:i:s');
            $create_blog['blog_category_id']                =   $this->input->post('blog_category');
            $subcategory_id                                 =   $this->input->post('subcategory');
            if($subcategory_id == ''){
                $create_blog['blog_sub_category_id']        =   '0';
            }else{
                $create_blog['blog_sub_category_id']        =   $this->input->post('subcategory');
            }
            if($user_data['user_type'] == 'admin'){                
                $create_blog['blog_available']              =   '1';
                $this->Blog_model->save_blog($create_blog);               
                $this->session->set_flashdata('flash_message', get_phrase('blog_created')); 
                redirect(base_url() . 'index.php?blogs/view_all_blogs', 'refresh');
            }else{                
                $create_blog['blog_available']                  =   '2';
                if($this->Blog_model->save_blog($create_blog)){                
                    $this->session->set_flashdata('flash_message', get_phrase('blog_is_created')); 
                    redirect(base_url() . 'index.php?blogs/view_my_blogs', 'refresh');
                }else{
                    $this->session->set_flashdata('flash_message', get_phrase('blog_not_created'));
                    redirect(base_url() . 'index.php?blogs/view_my_blogs', 'refresh');
                }                
            }          
        }else{
            $this->load->model("Blog_category_model");
            $this->session->set_flashdata('flash_message_error', validation_errors());
            $page_data['blog_categories']                   = $this->Blog_category_model->get_data_by_cols('*',array('blog_category_parent_id'=>'0','blog_category_isActive'=>'1'), 'result_arr');
            $page_data['page_title']                        =   get_phrase('create_blog');
            $page_data['page_name']                         =   'create_blog';
            $this->load->view('backend/index', $page_data);        
        }
    }
    
    
    public function get_user_type_id(){  
        $page_data= $this->get_page_data_var();

        $data                                                        =   array();
        if($this->session->userdata('admin_login') == 1 ) {
            $data['user_type']                                       =    'admin';
            $data['user_id']                                         =    $this->session->userdata('admin_id');
            $data['user_name']                                       =    $this->session->userdata('name');
        }
        else if($this->session->userdata('teacher_login') == 1 ) {
            $data['user_type']                                       =    'teacher';
            $data['user_id']                                         =    $this->session->userdata('teacher_id');
            $data['user_name']                                       =    $this->session->userdata('name');
        }
        else if($this->session->userdata('parent_login') == 1 ) {
            $data['user_type']                                       =    'parent';
            $data['user_id']                                         =    $this->session->userdata('parent_id');
            $data['user_name']                                       =    $this->session->userdata('name');
        }
        else if($this->session->userdata('student_login') == 1 ) {
            $data['user_type']                                       =    'student';
            $data['user_id']                                         =    $this->session->userdata('student_id');
            $data['user_name']                                       =    $this->session->userdata('name');
        }
        else if($this->session->userdata('school_admin_login') == 1 ) {
            $data['user_type']                                       =    'school_admin';
            $data['user_id']                                         =    $this->session->userdata('school_admin_id');
            $data['user_name']                                       =    $this->session->userdata('name');
        }
        return $data;
    }
    
    public function  view_blogs(){
        if($this->session->userdata('school_admin_login') != 1){
            redirect(base_url(), 'refresh');
        }
        $page_data= $this->get_page_data_var();        
        //$page_data['view_blogs']                                      =   $this->Blog_model->getblog_status(); 
        $page_data['page_title']                                      =   get_phrase('view_all_blogs');
        $page_data['page_name']                                       =   'view_blogs';
        $this->load->view('backend/index', $page_data);         
    }
    
    public function blog_preview($param1='', $param2='') { 
        if($this->session->userdata('school_admin_login') != 1){
            redirect(base_url(), 'refresh');
        }
        $page_data= $this->get_page_data_var();
        if($param1 == "resend"){
           $admin_comments                                          =   $this->input->post('comments');
           $blog_comment['blog_resend_comment']                     =   $admin_comments;           
           if($this->Blog_model->resend_blogs($param2, $blog_comment['blog_resend_comment'])){
               $this->session->set_flashdata('flash_message', get_phrase('blog_has_been_resend_to_author')); 
               redirect(base_url() . 'index.php?blogs/view_blogs', 'refresh');
           }else{
               $this->session->set_flashdata('flash_message_error', get_phrase('blog_not_resend')); 
               redirect(base_url() . 'index.php?blogs/view_blogs', 'refresh');
           }
        }
        $page_data['blog_preview']                                  =   get_data_generic_fun('blog','*',array('blog_id'=>$param1), 'result_arr');
        $page_data['page_title']                                    =   get_phrase('preview_blogs');
        $page_data['page_name']                                     =   'preview_blogs';
        $this->load->view('backend/index', $page_data);
    }
    
    public function view_all_blogs($param1=''){
        $page_data= $this->get_page_data_var();
        $page_data['blog_categories']                               =   $this->Blog_category_model->get_data_by_cols('*',array('blog_category_parent_id'=>'0','blog_category_isActive'=>'1'), 'result_arr', array('blog_category_name'=>'ASC'));
        if(isset($param1) && $param1>0) {
            $page_data['blogs']                                         =   $this->Blog_model->get_data_by_cols('*', array('blog_available' =>'1','blog_author_id' => $param1), 'result_arr', array('blog_published_time' => 'ORDER BY','blog_published_time'=>'DESC'));
        } else {
            $page_data['blogs']                                         =   $this->Blog_model->get_data_by_cols('*', array('blog_available' =>'1'), 'result_arr', array('blog_published_time' => 'ORDER BY','blog_published_time'=>'DESC'));
        }
        $page_data['author_id']                                     =   $param1;
        $page_data['page_title']                                    =   get_phrase('view_published_blogs');
        $page_data['page_name']                                     =   'view_all_blogs';
        $this->load->view('backend/index', $page_data);
    }
    
    public function view_all_category_blogs($category_id=''){
        $page_data= $this->get_page_data_var();
        $page_data['blog_categories']                               =   $this->Blog_category_model->get_data_by_cols('*',array('blog_category_parent_id'=>'0','blog_category_isActive'=>'1'), 'result_arr', array('blog_category_name'=>'ASC'));
        $page_data['category_id']                                   =   $category_id;
        $page_data['page_title']                                    =   get_phrase('view_category_blogs');
        $page_data['page_name']                                     =   'view_blog_category';
        $this->load->view('backend/index', $page_data);
    }
    
    public function view_blogs_details($param1= '') {
        $page_data= $this->get_page_data_var();       
        $page_data['view_blogs']                                    =   $this->Blog_model->get_data_by_cols('*', array('blog_available' =>'1', 'blog_id'=>$param1), 'result_arr');
             
        if(!empty($page_data['view_blogs'])){
            $page_data['view_blogs_comments']                 =   $this->Blog_model->get_blogs_comments($page_data['view_blogs'][0]['blog_id']);   
        }
        $form_name                                            =    $this->input->post('reply_post');
        $user_data                                            =    $this->get_user_type_id();
        $form_name                                            =    $this->input->post('reply_post');
        if ($form_name == 'reply_post'){ 
            $save_blog_comment['blog_id']                     =    $param1;
            $save_blog_comment['blog_user_id']                =    $user_data['user_id'];
            $save_blog_comment['blog_usertype']               =    $user_data['user_type'];
            $save_blog_comment['blog_username']               =    $user_data['user_name'];
            $save_blog_comment['blog_comments']               =    trim($this->input->post('post_body'));
            $save_blog_comment['date_created']                =    date('Y-m-d H:i:s');
            
            if($this->Blog_model->save_blogs_comments($save_blog_comment)){
                $this->session->set_flashdata('flash_message', get_phrase('blog_comments_posted!!'));
               
                redirect(base_url() . 'index.php?blogs/view_blogs_details/'.$param1); 
            }else{
                $this->session->set_flashdata('flash_message_error', get_phrase('details_not_updated!!'));
                redirect(base_url() . 'index.php?blogs/view_blogs_details/'.$param1);
            }            
        }
            
        $page_data['page_title']                                    =   get_phrase('view_blogs_details');
        $page_data['page_name']                                     =   'view_blogs_details';
        $this->load->view('backend/index', $page_data);
    }
    
    public function view_my_blogs() {
        $page_data= $this->get_page_data_var();        
        $user_data                                                  =   $this->get_user_type_id();
        $user_data_array                                            =   array('blog_author_id'=>$user_data['user_id'],'blog_user_type' =>$user_data['user_type']);
        $page_data['my_blogs']                                      =   $this->Blog_model->get_my_blogs($user_data_array);
    
        $page_data['page_title']                                    =   get_phrase('view_my_blogs');
        $page_data['page_name']                                     =   'view_my_blogs';
        $this->load->view('backend/index', $page_data);        
    }
    
    public function view_category_subcategory($param1 = '', $param2= ''){
        if($this->session->userdata('school_admin_login') != 1){
            redirect(base_url(), 'refresh');
        }
        $page_data= $this->get_page_data_var();
        if($param1 == '1') { $page_data['tab'] = 'subcat'; }
        if($param1 == 'delete'){
            if($this->Blog_model->delete_category($param2)){
                $this->session->set_flashdata('flash_message', get_phrase('category_deleted'));
            }
        }
        if($param1 == 'edit'){
            $update['blog_category_name']       =   $this->input->post('category_name');
            $condition                          =   array('blog_category_id'=>$param2);
            $dataArray                          =   array('blog_category_name'=>$update['blog_category_name']);
            if($this->Blog_model->update_category($condition, $dataArray)){
                $this->session->set_flashdata('flash_message', get_phrase('category_updated'));
            }
            redirect(base_url() . 'index.php?blogs/view_category_subcategory', 'refresh');            
        }
        if($param1 == 'delete_sub'){
            if($this->Blog_model->delete_category($param2)){
                $this->session->set_flashdata('flash_message', get_phrase('subcategory_deleted'));
                redirect(base_url() . 'index.php?blogs/view_category_subcategory/1', 'refresh'); 
            }            
        }
        if($param1 == 'subedit'){
            $update['blog_category_name']       =   $this->input->post('subcategory_name');
            $update['blog_category_parent_id']  =   $this->input->post('blog_category_parent_id');
            $condition                          =   array('blog_category_id'=>$param2);
            $dataArray                          =   array('blog_category_name'=>$update['blog_category_name'], 'blog_category_parent_id' => $update['blog_category_parent_id']);
            if($this->Blog_model->update_category($condition, $dataArray)){
                $this->session->set_flashdata('flash_message', get_phrase('subcategory_updated'));
            }
            redirect(base_url() . 'index.php?blogs/view_category_subcategory/1', 'refresh');            
        }
        $page_data['sub_delete_token'] = 1;
        $page_data['blog_categories']                           =   $this->Blog_category_model->get_data_by_cols('*',array('blog_category_parent_id'=>'0','blog_category_isActive'=>'1'), 'result_arr', array('blog_category_id' => 'DESC'));
        $page_data['blog_subcategories']                        =   $this->Blog_model->get_subcategories();
        $page_data['page_title']                                =   get_phrase('view_category_/_subcategory');
        $page_data['page_name']                                 =   'view_category_subcategory';
        $this->load->view('backend/index', $page_data); 
    }
    
    public function blog_delete($param1='',$blog_id=''){
        $page_data= $this->get_page_data_var();
        if($param1 == 'delete'){
            $delete_blog = $this->Blog_model->blogdelete($blog_id);
            if($delete_blog){
                $this->session->set_flashdata('flash_message', get_phrase('blog_deleted'));
            }else{
                $this->session->set_flashdata('flash_message', get_phrase('not_deleted'));
            }
            redirect(base_url() . 'index.php?blogs/view_my_blogs', 'refresh');
        }
    }
    
    /*@param1 : action to be done
     *@param2: blog id to be taken
     * 
     */
    public function blog_edit($param1='', $param2=''){ 
    $page_data= $this->get_page_data_var();       
        if($param1 == 'edit'){
            $page_data['blog_data']                                 =   $this->Blog_model->get_data_by_cols('*',array('blog_id'=>$param2),'result_arr');
            $page_data['blog_category']                             =   $this->Blog_category_model->get_data_by_cols('*',array('blog_category_parent_id'=>'0','blog_category_isActive'=>'1'), 'result_arr');           
            $form_name                                              =   $this->input->post('resent_to_author');
            if($form_name == 'resent_to_author'){
                $user_data                                      =   $this->get_user_type_id(); 
                $create_blog['blog_title']                      =   $this->input->post('blog_title');
                $create_blog['blog_information']                =   $this->input->post('blog_info');
                $create_blog['blog_available']                  =   '2';
                //$create_blog['blog_participation']              =   $this->input->post('blog_type'); ;
                $create_blog['blog_author_id']                  =   $user_data['user_id'];
                $create_blog['blog_user_type']                  =   $user_data['user_type'];
                $create_blog['blog_user_name']                  =   $user_data['user_name'];
                $create_blog['blog_resend_comment']             =   '';   
                $create_blog['blog_created_time']               =   date('Y-m-d H:i:s');
                $create_blog['blog_category_id']                =   $this->input->post('blog_category');
                $subcategory_id                                 =   $this->input->post('subcategory');
                if($subcategory_id == ''){
                    $create_blog['blog_sub_category_id']        =   '0';
                }else{
                    $create_blog['blog_sub_category_id']            =   $this->input->post('subcategory');
                }
                if($this->Blog_model->update_blog($param2, $create_blog)){                
                    $this->session->set_flashdata('flash_message', get_phrase('blog_sent_to_publish')); 
                    redirect(base_url() . 'index.php?blogs/view_my_blogs', 'refresh');
                }else{
                    $this->session->set_flashdata('flash_message', get_phrase('blog_not_updated'));
                    redirect(base_url() . 'index.php?blogs/view_my_blogs', 'refresh');
                } 
            }
        }        
        $page_data['page_title']                                    =   get_phrase('edit_blogs');
        $page_data['page_name']                                     =   'edit_blogs';
        $this->load->view('backend/index', $page_data); 
    }
    
    public function blog_preview_for_user($param1='') {
        $page_data= $this->get_page_data_var();
        $page_data['blog_preview']                                  =   $this->Blog_model->get_data_by_cols('*',array('blog_id'=>$param1), 'result_arr');
        $page_data['page_title']                                    =   get_phrase('blog_preview');
        $page_data['page_name']                                     =   'blog_preview_by_user';
        $this->load->view('backend/index', $page_data);
    }
    
    public function addcategory($param1='') {
        if($this->session->userdata('school_admin_login') != 1){
            redirect(base_url(), 'refresh');
        } 
        $page_data= $this->get_page_data_var();
        if($param1 == 'create'){            
            $create_blog_category['blog_category_name']             =   $this->input->post('category_name'); 
            $create_blog_category['blog_category_parent_id']        =   '0';
            $num_rows = $this->Blog_model->get_count($create_blog_category);            
            if (($num_rows) < 1) {             
                $this->Blog_model->add_blog_category($create_blog_category);                
                $this->session->set_flashdata('flash_message', get_phrase('category_added'));
                redirect(base_url() . 'index.php?blogs/view_category_subcategory', 'refresh');  
            }else{
                $this->session->set_flashdata('flash_message_error', get_phrase('Category_already_exists!!'));
                redirect(base_url() . 'index.php?blogs/addcategory', 'refresh');                
            }                      
        }  
        if($param1 == 'subcreate'){
            $create_blog_category['blog_category_name']             =   $this->input->post('subcategory_name'); 
            $create_blog_category['blog_category_parent_id']        =   $this->input->post('blog_category_parent_id');
            $num_rows = $this->Blog_model->get_count_of_subcategory($create_blog_category);            
            if (($num_rows) < 1) {             
                $this->Blog_model->add_blog_category($create_blog_category);                
                $this->session->set_flashdata('flash_message', get_phrase('category_added'));                     
            }else{
                $this->session->set_flashdata('flash_message_error', get_phrase('subcategory_already_exists!!'));  
                redirect(base_url() . 'index.php?blogs/addcategory', 'refresh');
            }
            redirect(base_url() . 'index.php?blogs/view_category_subcategory', 'refresh');            
        }
        $page_data['blog_categories']                           =   $this->Blog_category_model->get_data_by_cols('*',array('blog_category_parent_id'=>'0','blog_category_isActive'=>'1'), 'result_arr', array('blog_category_name' => 'ASC'));
        $page_data['page_title']                                    =   get_phrase('manage_category_&_subcategory');
        $page_data['page_name']                                     =   'manage_category';
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
