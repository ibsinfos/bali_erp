<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Discussion_forum extends CI_Controller {
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

    public function create_category($param1 = '', $param2=''){ 
        if($this->session->userdata('school_admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data= $this->get_page_data_var();
        $form_name = $this->input->post('submit_cat');
        if ($form_name == 'submit_cat') { 
            $this->form_validation->set_rules('category_name', 'Category Name', 'required');  
            if ($this->form_validation->run() == TRUE) {                
                $category                           =   array();
                $category['name']                   =   trim($this->input->post('category_name'));
                $num_rows_cat                       =   $this->Discussion_category_model->get_count_category($category);
                if (($num_rows_cat) > 0) {
                    $this->session->set_flashdata('flash_message_error', get_phrase('category_already_present!!'));
                    redirect(base_url() . 'index.php?discussion_forum/create_category');
                } else{
                    $this->Discussion_category_model->add_category($category);
                    $this->session->set_flashdata('flash_message', get_phrase('category_added_successfully!!'));
                    redirect(base_url() . 'index.php?discussion_forum/create_category'); 
                }
            }else{
                $this->session->set_flashdata('flash_message_error', validation_errors());
                redirect(base_url() . 'index.php?discussion_forum/create_category', 'refresh');
            }
        }    
        $page_data['total_notif_num']                   =   $this->get_no_of_notication();
        $page_data['categories']                        =   $this->Discussion_category_model->get_data_by_cols('*', array('isActive'=>'1'), 'result_arr', array('date_created'=>'DESC'));
        //echo $this->db->last_query(); exit;
        $page_data['page_title']                        =   get_phrase('view_category');
        $page_data['page_name']                         =   'add_category';
        $this->load->view('backend/index', $page_data);
    }
    
    
    //Function to create  a new thread for admin
    public function create_thread($form_name='') {
        $page_data= $this->get_page_data_var();  
        $data                                            =    $this->get_user_type_id();
        if ($form_name == 'create') {
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('category', 'Category Name', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            if ($this->form_validation->run()  == TRUE) { 
                $thread_save                              =    array();
                $thread_save['title']                     =    $this->input->post('title');
                $thread_save['discussion_topic']          =    $this->input->post('description');
                $thread_save['category_id']               =    $this->input->post('category');
                $thread_save['discussion_userid']                   =    $data['user_id'];
                $thread_save['discussion_usertype']                 =    $data['user_type'];
                $thread_save['discussion_username']                 =    $data['user_name'];
                if($this->Discussion_category_model->save_thread($thread_save)){
                    $this->session->set_flashdata('flash_message', get_phrase('topic_added_successfully!!'));
                    redirect(base_url() . 'index.php?discussion_forum/view_all_threads'); 
                }else{
                    $this->session->set_flashdata('flash_message_error', get_phrase('details_not_updated!!'));
                    redirect(base_url() . 'index.php?discussion_forum/create_thread');
                }
            }else{
                $this->session->set_flashdata('flash_message_error', validation_errors());
                redirect(base_url() . 'index.php?discussion_forum/create_thread', 'refresh');
            }
        }
        $page_data['total_notif_num']  =   $this->get_no_of_notication();
        $page_data['categories']                         =   $this->Discussion_category_model->get_data_by_cols('*', array('isActive'=>'1'), 'result_arr');
        $page_data['page_title']                         =   get_phrase('create_new_thread');
        $page_data['page_name']                          =   'create_thread';
        $this->load->view('backend/index', $page_data);
    }
    
    public function view_all_threads(){
        $page_data= $this->get_page_data_var();
        $threads                                        =   $this->Discussion_category_model->get_all_thread();      
        $page_data['threads']                           =   $threads;
        $page_data['page_title']                        =   get_phrase('view_all_discussion_posts');
        $page_data['page_name']                         =   'view_all_threads';
        $this->load->view('backend/index', $page_data);
    }
    
    public function get_user_type_id(){
        $page_data= $this->get_page_data_var();      
        $data                                                        =    array();
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
    
    
    public function edit_category($param1 = '', $param2 = ''){
        $page_data= $this->get_page_data_var();
        if($param1 == 'delete'){             
            $delete = $this->Discussion_category_model->delete_category($param2);
            if ($delete == true) {
                $this->session->set_flashdata('flash_message', get_phrase('category_deleted'));
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('category_not_deleted'));
            }
            redirect(base_url() . 'index.php?discussion_forum/create_category/', 'refresh');
        }
        if($param1 == 'edit'){          
            $category['name']                   =   trim($this->input->post('category_name'));            
            $condition                          =   array('category_id'=>$param2);
            if ($this->Discussion_category_model->update_category($category, $condition)) {
                $this->session->set_flashdata('flash_message', get_phrase('category_updated'));
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('category_not_updated'));
            }
            redirect(base_url() . 'index.php?discussion_forum/create_category/', 'refresh');
        }
        $page_data['edit_data']                 =   $this->Discussion_category_model->get_data_by_cols('*', array('category_id' => $param1),'result_array');
        $page_data['page_title']                =   get_phrase('edit_category');
        $page_data['page_name']                 =   'edit_category';
        $this->load->view('backend/index', $page_data);
    }
    
    public function view_discussion_details($param1= '') {     error_reporting(0);
        $page_data= $this->get_page_data_var();
        $this->load->model("Crud_model");
        $this->load->model("Teacher_model");
        $this->load->model("Student_model");
        $this->load->model("Parent_model");
        $this->load->model("School_Admin_model");
        if($this->session->userdata('school_admin_login') == 1 ) {
            $adminDataArr=$this->School_Admin_model->get_data_by_cols('*', array('school_admin_id' => $this->session->userdata('school_admin_id')));
            $image          =      $adminDataArr[0]->profile_pic;
            if($image!='' && file_exists('uploads/sc_admin_images/'.$image))
            $page_data['image'] = 'uploads/sc_admin_images/'.$image;
            else 
            $page_data['image'] = '';    
            
        }else if($this->session->userdata('teacher_login') == 1){
            $image          =      $this->Teacher_model->get_teacher_record(array('teacher_id' => $this->session->userdata('teacher_id')));
            if($image->teacher_image!='' && file_exists('uploads/teacher_image/'.$image->teacher_image))
            $page_data['image'] = 'uploads/teacher_image/'.$image->teacher_image;
            else
                 $page_data['image'] = ''; 

        }else if($this->session->userdata('student_login') == 1) {
            $image =  $this->db->get_where('student', array('student_id' => $this->session->userdata('student_id')))->row()->stud_image;
            if($image!='' && file_exists('uploads/student_image/'.$image))
            $page_data['image'] = 'uploads/student_image/'.$image; 
            else 
                $page_data['image'] = ''; 
        }else if($this->session->userdata('parent_login') == 1) {
            $image =  $this->db->get_where('parent', array('parent_id' => $this->session->userdata('parent_id')))->row()->parent_image;
            if($image!='' && file_exists('uploads/parent_image/'.$image))
            $page_data['image'] = 'uploads/parent_image/'.$image; 
            else
            $page_data['image'] = ''; 
        }
        
        $form_name                                       =   $this->input->post('add_comment');
        $user_data                                       =   $this->get_user_type_id();     
        
        if($form_name == 'add_comment'){
            $comment_body                                 =    nl2br($this->input->post('post_body')); 
            $comment['comment_body']                      =    trim($comment_body);
            $comment['thread_id']                         =    $this->input->post('thread_id');
            $comment['parent_comment_id']                 =    0; 
            $comment['user_id']                           =    $user_data['user_id'];
            $comment['user_type']                         =    $user_data['user_type'];
            $comment['user_name']                         =    $user_data['user_name'];
            if(!empty($comment)){
                $this->Discussion_category_model->save_replies($comment);
                $this->session->set_flashdata('flash_message', get_phrase('your__comment_is_posted'));                
            }else{
                $this->session->set_flashdata('flash_message_error', get_phrase('error_in_posting'));
            }
            redirect(base_url(). 'index.php?discussion_forum/view_discussion_details/' . $param1, 'refresh');  
        }
        $this->load->model('Discussion_thread_model');
        $page_data['details']                           =   $this->Discussion_thread_model->get_data_by_cols('*', array('thread_id'=>$param1), 'result_arr');
        
        $count                                          =   $this->Discussion_category_model->get_count($param1);
        $page_data['comments']                          =   $this->Discussion_post_model->get_data_by_cols('*', array('thread_id' => $param1,'parent_comment_id'=>'0'),'result_arr', array('date_add' => 'desc')); 

        if(count($page_data['comments'])){
            foreach ($page_data['comments'] as $k => $post){
                if($post['user_type'] == 'teacher'){
                    $image =  $this->Teacher_model->get_teacher_record(array('teacher_id' => $post['user_id']));
                    $teacher_image = $image->teacher_image;
                    if($teacher_image!='' && file_exists('uploads/teacher_image/'.$teacher_image))
                    $page_data['comments'][$k]['image'] = @$teacher_image;
                    else
                        $page_data['comments'][$k]['image'] = '';
                }else if($post['user_type'] == 'school_admin'){
                    $image =  $this->School_Admin_model->get_school_admin_image($post['user_id']);
                    $admin_image =  @$image->profile_pic;
                    if($admin_image!='' && file_exists('uploads/sc_admin_images/'.$admin_image))
                    $page_data['comments'][$k]['image'] = @$admin_image;
                    else 
                        $page_data['comments'][$k]['image'] = '';
                }else if($post['user_type'] == 'student'){
                    $image =  $this->Student_model->get_student_image($post['user_id']);
                    if($image!='' && file_exists('uploads/student_image/'.$image))
                    $page_data['comments'][$k]['image'] = $image;
                    else 
                        $page_data['comments'][$k]['image'] = '';
                }else if($post['user_type'] == 'parent'){
                    $image =  $this->Parent_model->get_parent_image($post['user_id']);
                     if($image!='' && file_exists('uploads/parent_image/'.$image))
                    $page_data['comments'][$k]['image'] = $image;
                     else
                         $page_data['comments'][$k]['image'] = '';
                     
                }

                $sub_comments =   get_data_generic_fun('discussion_post','*', array('parent_comment_id'=>$post['comment_id']),'result_arr', array('date_add' => 'desc'));
                $page_data['comments'][$k]['sub_comments'] = $sub_comments;
                if(!empty($sub_comments)){
                    foreach ($sub_comments as $key=>$subcomment) {
                        if($subcomment['user_type'] == 'teacher'){
                            $image =  $this->Teacher_model->get_teacher_record(array('teacher_id' => $subcomment['user_id']));
                            $teacher_image = $image->teacher_image;
                            if($teacher_image!='' && file_exists('uploads/teacher_image/'.$teacher_image))
                            $page_data['comments'][$k]['sub_comments'][$key]['image'] = $teacher_image;
                            else
                                $page_data['comments'][$k]['sub_comments'][$key]['image'] = '';
                             $page_data['comments'][$k]['sub_comments'][$key]['user_type'] = 'teacher';
                        }
                        else if($subcomment['user_type'] == 'school_admin'){ 
                            $adminDataArr=$this->School_Admin_model->get_data_by_cols('*', array('school_admin_id' => $this->session->userdata('school_admin_id')));
                            $image  = $adminDataArr[0]->profile_pic;
                            if($image!='' && file_exists('uploads/sc_admin_images/'.$image))
                            $page_data['comments'][$k]['sub_comments'][$key]['image'] = $image;
                            else
                             $page_data['comments'][$k]['sub_comments'][$key]['image'] = '';   
                            $page_data['comments'][$k]['sub_comments'][$key]['user_type'] = 'admin';
                        }
                        else if($subcomment['user_type'] == 'student'){
                            $image =  $this->Student_model->get_student_image($subcomment['user_id']);
                            if($image!='' && file_exists('uploads/student_image/'.$image))
                            $page_data['comments'][$k]['sub_comments'][$key]['image'] = $image;
                            else 
                                $page_data['comments'][$k]['sub_comments'][$key]['image'] = '';
                            $page_data['comments'][$k]['sub_comments'][$key]['user_type'] = 'student';
                        }
                        else if($subcomment['user_type'] == 'parent'){
                            $image =  $this->Parent_model->get_parent_image($subcomment['user_id']);
                            if($image!='' && file_exists('uploads/parent_image/'.$image))
                            $page_data['comments'][$k]['sub_comments'][$key]['image'] = $image;
                            else 
                                $page_data['comments'][$k]['sub_comments'][$key]['image'] = '';
                            $page_data['comments'][$k]['sub_comments'][$key]['user_type'] = 'parent';
                        }
                    }
                }
            }
        }


        //echo '<pre>'; print_r($page_data['comments']); exit;
//        foreach($page_data['comments'] as $com){
//            $page_data['sub_comments']                  =   get_data_generic_fun('discussion_post','*', array('parent_comment_id'=>$com['comment_id']),'result_arr', array('date_add' => 'desc'));  
//            //echo '<pre>'; print_r($page_data['sub_comments']);            
//        }
        //exit;
        $details=$page_data['details'];
        if($details[0]['discussion_usertype'] == 'teacher'){

           // $page_data['image'] =  $this->Teacher_model->get_teacher_record(array('teacher_id' => $details[0]['discussion_userid']));

             $teacher_image1 = get_user_img_url('teacher', $details[0]['discussion_userid']);
            if($teacher_image1!='' && file_exists('uploads/teacher_image/'.$teacher_image1))
                    $page_data['discussion_user_image'] =  'uploads/teacher_image/'.$teacher_image1;
            else 
                $page_data['discussion_user_image'] =  '';
        }elseif($details[0]['discussion_usertype'] == 'school_admin'){
            $user_id = $details[0]['discussion_userid'];
            $image =  $this->School_Admin_model->get_school_admin_image($user_id);
            if($image->profile_pic!='' && file_exists('uploads/sc_admin_images/'.$image->profile_pic))
            $page_data['discussion_user_image'] = 'uploads/sc_admin_images/'.$image->profile_pic;
            else
                 $page_data['discussion_user_image'] = '';
            //$page_data['image'] =  $this->Admin_model->get_admin_image($details[0]['discussion_userid']);

            //$page_data['image']  = get_user_img_url('admin', $details[0]['discussion_userid']);
        }elseif($details[0]['discussion_usertype'] == 'parent'){

             $parent_image1 =  $this->Parent_model->get_parent_image($details[0]['discussion_userid']);
            if($parent_image1!='' && file_exists('uploads/parent_image/'.$parent_image1))
                    $page_data['discussion_user_image'] = 'uploads/parent_image/'.$parent_image1;
            else 
                $page_data['discussion_user_image'] = '';
            //$page_data['image']  = get_user_img_url('parent', $details[0]['discussion_userid']);
        }elseif($details[0]['discussion_usertype'] == 'student'){
            
            $student_image1 =  $this->Student_model->get_student_image($details[0]['discussion_userid']);
            if($student_image1!='' && file_exists('uploads/student_image/'.$student_image1))
                    $page_data['discussion_user_image'] = 'uploads/student_image/'.$student_image1;
            else
                 $page_data['discussion_user_image'] = '';
            //$page_data['image']  = get_user_img_url('student', $details[0]['discussion_userid']);
        }
        $image =  $this->School_Admin_model->get_school_admin_image($this->session->userdata('school_admin_id'));
        $page_data['admin_image'] =  @$image->profile_pic;

        $page_data['count']                             =   $count[0]['count'];
        $page_data['page_title']                        =   get_phrase('view_in_detail');
        $page_data['page_name']                         =   'view_discussion_details';
        $this->load->view('backend/index', $page_data);
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
    
    public function view_category_wise($category_id) {
        $page_data= $this->get_page_data_var();
        $page_data['threads_by_category']                          =   $this->Discussion_category_model->get_all_thread_by_category($category_id);
        if(!empty($page_data['threads_by_category'])){
            foreach($page_data['threads_by_category'] as $name){
                $categroy_name          =       $name['name'];
            }
        }
        $page_data['page_title']                        =   get_phrase('view_category_wise')." : ".$categroy_name;
        $page_data['page_name']                         =   'view_category_wise';
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