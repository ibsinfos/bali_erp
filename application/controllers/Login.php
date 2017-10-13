<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->library('session');
        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        //$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        //$this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2010 05:00:00 GMT");
        $this->load->helper("send_notifications");

        $this->load->helper('captcha');
        $this->load->model("Admin_model");
    }

    //Default function, redirects to logged in user area
    public function index() {
//For Store Login history starts
        /*$LoginHistoryData['user_name'] = $this->session->userdata('username'); 
        $LoginHistoryData['ip_address'] = $get_ip_address;           
        $HistoryId = $this->Admin_model->save_login_history_data($LoginHistoryData);
        $this->session->set_userdata('login_history_id', $HistoryId);*/
//For Store Login history ends


        if ($this->session->userdata('super_admin_login') == 1)
            redirect(base_url() . 'index.php?super_admin/dashboard', 'refresh');
        
        if ($this->session->userdata('doctor_login') == 1)
            redirect(base_url() . 'index.php?doctor/dashboard', 'refresh');
        
        if ($this->session->userdata('admin_login') == 1)
            redirect(base_url() . 'index.php?admin/dashboard', 'refresh');

        if ($this->session->userdata('teacher_login') == 1)
            redirect(base_url() . 'index.php?teacher/dashboard', 'refresh');
		
	    if ($this->session->userdata('librarian_login') == 1)
           // redirect(base_url() . 'index.php?librarian/dashboard', 'refresh');
            redirect(base_url().'lms/admin/index','refresh');

        if ($this->session->userdata('student_login') == 1)
            redirect(base_url() . 'index.php?student/dashboard', 'refresh');

        if ($this->session->userdata('parent_login') == 1)
            redirect(base_url() . 'index.php?parents/dashboard', 'refresh');
        
        if ($this->session->userdata('bus_driver_login') == 1)
            redirect(base_url() . 'index.php?bus_driver/dashboard', 'refresh');
        
        if ($this->session->userdata('bus_admin_login') == 1)
            redirect(base_url() . 'index.php?bus_admin/dashboard', 'refresh');
        
        if ($this->session->userdata('hostel_login') == 1)
            redirect(base_url() . 'index.php?hostel_admin/dashboard', 'refresh');
        
        if ($this->session->userdata('school_admin_login') == 1)
            redirect(base_url() . 'index.php?school_admin/dashboard', 'refresh');
        if ($this->session->userdata('accountant_login') == 1)
            redirect(base_url() . 'index.php?fees/accountant/dashboard', 'refresh');

        if ($this->session->userdata('cashier_login') == 1)
            redirect(base_url() . 'index.php?fees/cashier/dashboard', 'refresh');
        
        //pre($this->session->userdata());die;
        $system_name  = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;
        $system_title = $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;
        $page_data['title']         =   $system_title;
        $page_data['system_name']   =   $system_name;
        $this->load->model('Class_model');
        $page_data['classArr'] = $this->Class_model->get_class_array();
//        pre($page_data['classArr']); die;

         //Captcha starts
        $CaptchaConfig = array('img_path'=> FCPATH.'uploads/captcha/', 'img_url'=>base_url().'uploads/captcha/', 'img_width'=>150, 'img_height'=>40, 'expiration'=>600);
        $captcha = create_captcha($CaptchaConfig);

        //pre($captcha);

        $this->session->set_userdata('captcha_word', $captcha['word']);
        $page_data['captcha'] = $captcha;        
        //Captcha ends

        $this->load->view('backend/login',$page_data);
    }

    //refresh captcha
    function refresh_captcha(){
        $CaptchaConfig = array('img_path'=> FCPATH.'uploads/captcha/', 'img_url'=>base_url().'uploads/captcha/', 'img_width'=>150, 'img_height'=>40, 'expiration'=>600);
        $captcha = create_captcha($CaptchaConfig);
        echo json_encode($captcha);
    }

    /*     * *DEFAULT NOR FOUND PAGE**** */

    function four_zero_four() {
        $this->load->view('four_zero_four');
    }

    // PASSWORD RESET BY EMAIL
    function forgot_password()
    {
        $this->load->view('backend/forgot_password');
    }

    /*
     * Reset password and send to user email
     * @param $_post['email'] Post email by ajax
     * @return $response array()
     */
    function ajax_forgot_password()
    {
        $response               =   array();
        $resp['status']         =   'false';
        $email                  =   $_POST["email"];

        $reset_account_type     =   '';
        //resetting user password here
        //$new_password           =   substr( md5( rand(100000000,20000000000) ) , 0,7);
        $email = strtolower($email);
        // Checking credential for admin
        $query_admin            =   $this->db->get_where('admin' , array('LOWER(email)' => $email));
        // Checking credential for student
        $query_student          =   $this->db->get_where('student' , array('LOWER(email)' => $email));
        // Checking credential for teacher
        $query_teacher          =   $this->db->get_where('teacher' , array('LOWER(email)' => $email));
        // Checking credential for parent
        $query_parent           =   $this->db->get_where('parent' , array('LOWER(email)' => $email));
        // Checking credential for school_admin
        $query_school_admin           =   $this->db->get_where('school_admin' , array('LOWER(email)' => $email));

        // Checking credential for bus driver
        $query_bus_driver           =   $this->db->get_where('bus_driver' , array('LOWER(email)' => $email));
        
        if ($query_admin->num_rows() > 0) {
            $reset_account_type     =   'admin';

            $new_password = create_passcode('admin');
            $password = ($new_password != 'invalid') ? sha1($new_password) : '';
            $passcode = ($new_password != 'invalid') ? $new_password : '';

            $this->db->where('email' , $email);
            $this->db->update('admin' , array('password' => $password, 'passcode' => $passcode));
            $response['status']     = 'true';
        } else if ($query_student->num_rows() > 0) {
            $reset_account_type     =   'student';

            $new_password = create_passcode('student');
            $password = ($new_password != 'invalid') ? sha1($new_password) : '';
            $passcode = ($new_password != 'invalid') ? $new_password : '';

            $this->db->where('email' , $email);
            $this->db->update('student' , array('password' => $password, 'passcode' => $passcode));
            $response['status']         = 'true';
        } else if ($query_teacher->num_rows() > 0) {
            $reset_account_type     =   'teacher';

            $new_password = create_passcode('teacher');
            $password = ($new_password != 'invalid') ? md5($new_password) : '';
            $passcode = ($new_password != 'invalid') ? $new_password : '';

            $this->db->where('email' , $email);
            $this->db->update('teacher' , array('password' => $password, 'passcode' => $passcode));
            $response['status']         = 'true';
        } else if ($query_parent->num_rows() > 0) {
            $reset_account_type         =   'parent';

            $new_password = create_passcode('parent');
            $password = ($new_password != 'invalid') ? sha1($new_password) : '';
            $passcode = ($new_password != 'invalid') ? $new_password : '';

            $this->db->where('email' , $email);
            $this->db->update('parent' , array('password' => $password, 'passcode' => $passcode));
            $response['status']         =   'true';
        }else if ($query_bus_driver->num_rows() > 0) {
            $reset_account_type         =   'bus driver';

            $new_password = create_passcode('bus_driver');
            $password = ($new_password != 'invalid') ? sha1($new_password) : '';
            $passcode = ($new_password != 'invalid') ? $new_password : '';

            $this->db->where('email' , $email);
            $this->db->update('bus_driver' , array('password' => $password, 'passcode' => $passcode));
            $response['status']         =   'true';
        } else if ($query_school_admin->num_rows() > 0) {
            $reset_account_type     =   'school_admin';

            $new_password = create_passcode('school_admin');
            $password = ($new_password != 'invalid') ? sha1($new_password) : '';
            $passcode = ($new_password != 'invalid') ? $new_password : '';

            $this->db->where('LOWER(email)' , $email);
            $this->db->update('school_admin' , array('password' => $password, 'original_pass' => $passcode));
            $this->db->where('LOWER(emailaddress)' , $email);
            $this->db->update('main_users' , array('emppassword' => md5($passcode)));
            $this->db->where('LOWER(username)' , $email);
            $this->db->update('sys_users' , array('password' => crypt($passcode,'ib_salt')));
            $response['status']     = 'true';
        } else {
            $response['status']         =   'false';
            $response['message']        =   $email." id is not registered";
        }
        
        if( $response['status'] == 'true' ) {
            // send new password to user email 
            $email_msg      =       "Your account type is : ".$reset_account_type."<br/>";
            $email_msg      .=      "Your new passcode is : ".$passcode."<br/>";

            $email_sub      =       "Password reset request";
            $email_to       =       $email;
            
//            send_school_notification( 'update_passcode' , $message , '' , $rsTeacherData[0]->email );
            //send_custom_email($email_to,$email_sub ,$email_msg , $email_to);

            if( send_custom_email($email_to,$email_sub ,$email_msg , $email_to) ) {
                $response['status']     =   'true';
                $response['message']    =   'Password has been send to '.$email;
                //$response['email_msg'] = $email_msg;
                $this->session->set_flashdata('flash_message', 'password_changed_successfully');
            } else {
                $response['status']     =   'false';
                $response['message']    =   'Password reset error , Try again.';
            }
        } else {
            $response['message']        =   $email." id is not registered";
        }

        print_r(json_encode($response));exit;
    }

    /*     * *****LOGOUT FUNCTION ****** */

    function logout() {
//For Store Logout history starts
            $HistoryId = $this->session->userdata('login_history_id');
            //$LoginHistoryData['logout_at'] = date("d/m/Y H:i:s");
            $LoginHistoryData['login_history_status'] = '0';

            $this->Admin_model->update_login_history_data($HistoryId, $LoginHistoryData);
//For Store Logout history ends

        $this->session->sess_destroy();
        $this->session->set_flashdata('logout_notification', 'logged_out');
        
        setcookie("username", "", time() - (60 * 20),"/"); 
        setcookie("password","", time() - (60 * 20),"/"); 

        setcookie("user_email", "", time() - 3600, "/");
        setcookie("user_password", "", time() - 3600, "/");
        setcookie("logged_in_data", "", time() - 3600, "/");
        
        redirect(base_url(), 'refresh');
    }



    function admin_login_by_android_device($id,$user_type){
        $col=$user_type.'_id';
        $rs=get_data_generic_fun($user_type,'*',array($col=>$id));
        $row=$rs[0];
        $this->session->set_userdata($user_type.'_login', '1');
        $this->session->set_userdata($col, $row->$col);
        $this->session->set_userdata('login_user_id', $row->$col);
        $this->session->set_userdata('login_type', $user_type);
        
        if($user_type=='parent'){
            $this->session->set_userdata('name', $row->father_name);
        }else{
            if($user_type=='school_admin'){
                $adminId=$id;
                $schoolRow=$this->db->select()->from('admin_school_mapping')->where("admin_id='".$adminId."'")->get()->result_array();

                if(count($schoolRow)>0) {
                    $this->session->set_userdata('school_id', $schoolRow[0]['school_id']);
                }
            }
            $this->session->set_userdata('name', $row->name);
        }
        $setSessionUserType=array('school_admin'=>'SA','admin'=>'a','parent'=>'p','teacher'=>'T','student'=>'S','accountant'=>'ACCT');
        $this->setSessionLinks($setSessionUserType[$user_type]);
        
        if($user_type=='parent')
            redirect(base_url() . 'index.php?'.$user_type.'s/index/');
        else
            redirect(base_url() . 'index.php?'.$user_type.'/index/');
    }
    
    function admin_login_by_ios_device($id,$user_type){
        $col=$user_type.'_id';
        $rs=get_data_generic_fun($user_type,'*',array($col=>$id));
        $row=$rs[0];
        
        $this->session->set_userdata($user_type.'_login', '1');
        $this->session->set_userdata($col, $row->$col);
        $this->session->set_userdata('login_user_id', $row->$col);
        $this->session->set_userdata('login_type', $user_type);
        
        if($user_type=='parent'){
            $this->session->set_userdata('name', $row->father_name);
        }else{
            if($user_type=='school_admin'){
                $adminId=$id;
                $schoolRow=$this->db->select()->from('admin_school_mapping')->where("admin_id='".$adminId."'")->get()->result_array();

                if(count($schoolRow)>0) {
                    $this->session->set_userdata('school_id', $schoolRow[0]['school_id']);
                }
            }
            $this->session->set_userdata('name', $row->name);
        }
        $setSessionUserType=array('school_admin'=>'SA','admin'=>'a','parent'=>'p','teacher'=>'T','student'=>'S','accountant'=>'ACCT');
        $this->setSessionLinks($setSessionUserType[$user_type]);
        
        if($user_type=='parent')
            redirect(base_url() . 'index.php?'.$user_type.'s/index/');
        else
            redirect(base_url() . 'index.php?'.$user_type.'/index/');
    }
    
    function setSessionLinks($user_type)
    {
        $this->load->model("Crud_model");
        $user_id = $this->session->userdata('login_user_id');
        $arr = $this->Crud_model->getUserRole($user_id, $user_type);
        
        $role_id = $arr['role_id'];
        
        $this->session->set_userdata('u_type', $arr['user_type']);
      //  echo "<br>here user type is".$arr['user_type']." and original user type is:".$arr['original_user_type'];
        if($arr['user_type'] == "A")
        {
            $this->session->set_userdata('admin_login', '1');
            $this->session->set_userdata('admin_id', $arr['user_id']);
            $this->session->set_userdata('table', "teacher||admin");
            $this->session->set_userdata('login_type', 'admin');
        }
        if($arr['user_type'] == "T")
        {
            $this->session->set_userdata('teacher_login', '1');
            $this->session->set_userdata('teacher_id', $arr['user_id']);
            $this->session->set_userdata('table', "teacher");
            $this->session->set_userdata('login_type', 'teacher');
        }
        if($arr['user_type'] == "P")
        {
            
            $this->session->set_userdata('parent_login', '1');
            $this->session->set_userdata('parent_id', $arr['user_id']);
            $this->session->set_userdata('table', "parent");
            $this->session->set_userdata('login_type', 'parent');
            
        }
         if($arr['user_type'] == "SA")
        {
            
            $this->session->set_userdata('school_admin_login', '1');
            $this->session->set_userdata('school_admin_id', $arr['user_id']);
            $this->session->set_userdata('login_type', 'school_admin');
            
        }

        $user_type = $arr['user_type'];
        $this->session->set_userdata('role_id', $role_id);
        $links =  $this->Crud_model->getModuleLinks($role_id);
        $subLinks = array();
        $arrAllLinks = array();
        $parent_login = $this->session->userdata('parent_login');


        if($user_type=='SA'){
            $all_links = $this->Crud_model->get_all_links($role_id);
            $arrAllLinks = buildTree($all_links);
            $this->db->insert('session_links',array('links'=>json_encode($arrAllLinks)));
            $this->session->set_userdata('session_link_id', $this->db->insert_id());
            //echo '<pre>';print_r($tree);exit;
        }else{
            if(count($links))
            {
                foreach($links as $link)
                {
                    $link_id = $link['link_id'];
                    $link_name = $link['name'];
                    $image1 = $link['image1'];
                    $val_array =  $this->Crud_model->getSubLinks($link_id, $user_type); 
                // pre($val_array);
                    if($parent_login == 0)
                    {
                        $link_name = $link_name.'?'.$image1;
                    }
                    if($val_array['flag'] == 0)
                    {
                        foreach($val_array['query'] as $values)
                        {
            
                            $inner_link_name = $values['name'];
                            $inner_link_value = $values['link'];
                            $image = $values['image'];
                            $arrAllLinks[$link_name][$inner_link_name][$image] = $inner_link_value;
                        }    
                    }
                    else
                    {
                        foreach($val_array['query'] as $values)
                        {
                        
                            $inner_link_name = $values['link_name'];
                            $inner_link_value = $values['links'];
                            $inner_image = $values['image'];
                            $arr3 = array();
                            $arr = array();
                            if(strstr($inner_link_name, ","))
                            {
                                $arr = explode(",", $inner_link_name);
                            }
                            else
                            {
                                $arr[0] = $inner_link_name;
                            }
                            
                            if(strstr($inner_link_value, ","))
                            {
                                $arr2 = explode(",", $inner_link_value);
                            }
                            else
                            {
                                $arr2[0] = $inner_link_value;
                            }    
                            
                            if(strstr($inner_image, ","))
                            {
                                $arr3 = explode(",", $inner_image);
                            }
                            else
                            {
                                $arr3[0] = $inner_image;
                            }   
                            
                            //$allLinks[$link_name][$inner_link_name] = $inner_link_value;
                        }
                    
                        foreach($arr as $key=>$value)
                        {
                            $arrAllLinks[$link_name][$value][$arr3[$key]] = $arr2[$key];
                        }    
                    }    
                }    
                
            }
        }    
        //pre($arrAllLinks);
        $this->session->set_userdata('arrAllLinks', $arrAllLinks);
    }
}

