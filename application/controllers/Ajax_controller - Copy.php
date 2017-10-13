<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ajax_controller extends CI_Controller {
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
        $this->session->set_userdata(array(
            'running_year'       => $this->globalSettingsRunningYear,
        ));
        
        $this->load->helper("email_helper");
        $this->load->helper("send_notifications");
        $this->load->model("Librarian_model");
        $this->load->model("Admin_model");
    }
    
    function get_latest_parrent_details_for_student_inquiry() {
        $mobile_number = $this->input->post('mobile_number', TRUE);
        $rs = get_data_generic_fun('enquired_students', '*', array('mobile_number' => $mobile_number));
        $retArr = array();
        if (count($rs) == 0) {
            $retArr = array('exist' => 'no');
            echo json_encode($retArr);
            die;
        } else {
            $retArr = array('exist' => 'yes', 'data' => $rs[count($rs) - 1]);
            echo json_encode($retArr);
            die;
        }
    }

    
    //Ajax login function 
    function ajax_login() {
        $response = array();
        $remember_me = $_POST["remember_me"];

        //Recieving post input of email, password from ajax request
        $email = $_POST["email"];
        if(preg_match('/^\d{10}$/',$email)) // phone number is valid
        {
            $email = $email."@".$this->db->database.".com";
            // your other code here
        }
        
        $password = sha1($_POST["password"]);
        $response['submitted_data'] = $_POST;
        $md5password=  md5($_POST["password"]);
        //Validating login
        $login_status = $this->validate_login($email, $password,$md5password,$_POST["password"]);
        //echo "$login_status";//exit;
        $response['login_status'] = $login_status;
        $response['login_failed'] = 0;

        if ($login_status == 'success') {
            if(($this->session->userdata('school_id')))
            $school_id = $this->session->userdata('school_id');
//For Store Login history starts
            $ip_address = get_ip_address();
            $LoginHistoryData['user_name'] = $email; 
            $LoginHistoryData['ip_address'] = $ip_address;           
            $HistoryId = $this->Admin_model->save_login_history_data($LoginHistoryData);
            $this->session->set_userdata('login_history_id', $HistoryId);
//For Store Login history ends            

            $this->session->unset_userdata('login_failed');
            $this->session->unset_userdata('captcha_word');
            $_SESSION["username"]=$email;
            $_SESSION["password"]=$_POST["password"];
            setcookie("username", $email, time() + (60 * 20)); 
            setcookie("password", $_POST["password"], time() + (60 * 20)); 
            
            if(isset($school_id) && $school_id > 0){
              setcookie("school_id", $school_id, time() + (60 * 20)); 
              $_SESSION['school_id'] = $school_id;
            }
            
            if($remember_me=='1'){
                setcookie("user_email", $email, time() + (86400 * 30), "/");
                setcookie("user_password", $_POST["password"], time() + (86400 * 30), "/");
            }

            //echo '<pre>112';print_r($this->session->all_userdata());exit;
            $sessionArr = json_encode($_SESSION);
            setcookie('logged_in_data',$sessionArr);
            $response['user_type'] = $this->session->userdata('login_type');
            if ($this->session->userdata('logged_in') == 1 && $this->session->userdata('user_type') == 'Admin') {
                $response['redirect_url'] = base_url().'lms/admin/index';
            }
            else if ($this->session->userdata('logged_in') == 1 && $this->session->userdata('user_type') == 'Member') {
                $response['redirect_url'] = base_url().'lms/member/index';
            } else if ($this->session->userdata('logged_in') == 1 && $this->session->userdata('login_type') == 'librarian') {
                $response['redirect_url'] = base_url().'lms/member/index';
            } else if($this->session->userdata('login_type')=='hrm') {
                $response['redirect_url'] = base_url().'hrm/index.php?index/loginpopupsave';
            } else{
                $response['redirect_url'] = '';
            }
            
        }else{
            $failed = $this->session->userdata('login_failed') ? $this->session->userdata('login_failed') : 0 ;
            $failed+=1;
            $this->session->set_userdata('login_failed', $failed);
            $response['login_failed'] = $failed;
        }

        //Replying ajax request with validation response
        echo json_encode($response);
    }

    //Validating login from ajax request
    function validate_login($email = '', $password = '',$md5password='',$org_password) 
    {
        $credential = array('email' => $email, 'password' => $password);
        $md5credential='';
        if($md5password!='')
        $md5credential= array('email' => $email, 'password' => $md5password);

        
        // Checking login credential for super admin

        $query = $this->db->get_where('master_users', $credential);
        if ($query->num_rows() > 0) {
            $row = $query->row();

            $this->session->set_userdata('super_admin_login', '1');
            $this->session->set_userdata('super_admin_id', $row->id);
            $this->session->set_userdata('login_user_id', $row->id);
            $this->session->set_userdata('name', 'Super Admin');
            $this->session->set_userdata('login_type', 'super_admin');
            return 'success';
        }

        $row= $this->db->get_where('admin', $credential)->row();
        if (count($row) > 0) {
            //$this->session->set_userdata('teacher_login', '1');

            //$this->session->set_userdata('teacher_id', $row->teacher_id);

            $this->session->set_userdata('admin_login', '1');
            $this->session->set_userdata('login_user_id', $row->admin_id);
            $this->session->set_userdata('name', $row->name);
            $this->session->set_userdata('login_type', 'admin');

            $this->setSessionLinks('A');
                return 'success';
            }

        $row = $this->db->order_by('parent_id', 'DESC')->limit(1)->where(array('parent_status'=>"1"))->get_where('parent', $credential)->row();
        if (count($row) > 0) {
            
            $this->session->set_userdata('parent_id', $row->parent_id);
            $this->session->set_userdata('login_user_id', $row->parent_id);
            $this->session->set_userdata('name', $row->father_name);
            if(isset($row->school_id))
            $this->session->set_userdata('school_id',$row->school_id);
            $this->session->set_userdata('login_type', 'parent');
            $this->setSessionLinks('P');
            return 'success';
        } 
        
        $row= $this->db->get_where('teacher', $md5credential)->row();
        if (count($row) > 0) {
        //$this->session->set_userdata('teacher_login', '1');
            
            $this->session->set_userdata('teacher_id', $row->teacher_id);
            $this->session->set_userdata('login_user_id', $row->teacher_id);
            $this->session->set_userdata('name', $row->name);
            if(isset($row->school_id))
            $this->session->set_userdata('school_id',$row->school_id);
            $this->session->set_userdata('login_type', 'teacher');
            $this->setSessionLinks('T');
            return 'success';
        }
        $row = $this->db->get_where('student', $credential)->row();
        if (count($row) > 0) {
            if($row->student_status == 1) {
                $this->session->set_userdata('student_login', '1');
                $this->session->set_userdata('student_id', $row->student_id);
                $this->session->set_userdata('login_user_id', $row->student_id);
                $this->session->set_userdata('name', $row->name);
                $this->session->set_userdata('login_type', 'student');
                if(isset($row->school_id))
                $this->session->set_userdata('school_id',$row->school_id);
                return 'success';
            } else {
                return 'invalid';
            }
        }

        // Checking login credential for accountant

        $row = $this->db->get_where('accountant', $credential)->row();
        if (count($row) > 0) {
            if(($row->accountant_status == 1) &&($row->acc_type == 1)) {
                $this->session->set_userdata('accountant_login', '1');
                $this->session->set_userdata('accountant_id', $row->accountant_id);
                $this->session->set_userdata('login_user_id', $row->accountant_id);
                $this->session->set_userdata('name', $row->name);
                $this->session->set_userdata('login_type', 'accountant');
                if(isset($row->school_id))
                    $this->session->set_userdata('school_id',$row->school_id);

                $this->setSessionLinks('ACCT');
                return 'success';
            }
// Checking login credential for cashier
            else if(($row->accountant_status == 1) &&($row->acc_type == 2)) {
                $this->session->set_userdata('cashier_login', '1');
                $this->session->set_userdata('cashier_id', $row->accountant_id);
                $this->session->set_userdata('login_user_id', $row->accountant_id);
                $this->session->set_userdata('name', $row->name);
                $this->session->set_userdata('login_type', 'cashier');
                if(isset($row->school_id))
                    $this->session->set_userdata('school_id',$row->school_id);
                $this->setSessionLinks('CASH');
                return 'success';
            }else{
                return 'invalid';
            }
        }        
            
        // $user_type = $this->session->userdata("u_type");

        //return 'success';
            
        $query = $this->db->get_where('bus_driver', $credential);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->session->set_userdata('bus_driver_login', '1');
            $this->session->set_userdata('bus_driver_id', $row->bus_driver_id);
            $this->session->set_userdata('login_user_id', $row->bus_driver_id);
            $this->session->set_userdata('name', $row->name);
            $this->session->set_userdata('login_type', 'bus_driver');
            if(isset($row->school_id))
            $this->session->set_userdata('school_id',$row->school_id);
            return 'success';
        }
        unset($credential['bus_driver_status']);
        
        $query = $this->db->get_where('bus_administrator', $credential);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->session->set_userdata('bus_admin_login', '1');
            $this->session->set_userdata('bus_admin_id', $row->bus_administrator_id);
            $this->session->set_userdata('login_user_id', $row->bus_administrator_id);
            $this->session->set_userdata('name', $row->name);
            $this->session->set_userdata('login_type', 'bus_admin');
            if(isset($row->school_id))
            $this->session->set_userdata('school_id',$row->school_id);
            return 'success';
        }
         // Checking login credential for hostel_admin
        $query = $this->db->get_where('hostel_admin', $credential);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->session->set_userdata('user_type', 'T');
            $this->session->set_userdata('hostel_login', '1');
            $this->session->set_userdata('hostel_admin_id', $row->hostel_admin_id);
            $this->session->set_userdata('login_user_id', $row->hostel_admin_id);
            $this->session->set_userdata('name', $row->name);
            $this->session->set_userdata('login_type', 'hostel_admin');
            if(isset($row->school_id))
            $this->session->set_userdata('school_id',$row->school_id);
            return 'success';
        }
        
        if($credential!=''){

            $row = $this->db->get_where('school_admin', $credential)->row();

            $this->load->model("School_Admin_model");
            if (count($row) > 0) {
                $adminId=$row->school_admin_id;
                $schoolRow=$this->db->select()->from('admin_school_mapping')->where("admin_id='".$adminId."'")->get()->result_array();

                if(count($schoolRow)>0) {
                    $this->session->set_userdata('school_id', $schoolRow[0]['school_id']);
                }

                $this->session->set_userdata('school_admin_login', '1');
                $this->session->set_userdata('login_user_id', $row->school_admin_id);
                $this->session->set_userdata('name', $row->first_name." ".$row->last_name);
                $this->session->set_userdata('login_type', 'school_admin');
                $this->setSessionLinks('SA');
                return 'success';
            }
        }
 
        // check hrm user
        if($md5credential!=''){
            $hrmCredentials = array('emailaddress' => $email, 'emppassword' => md5($org_password));
            $url_arr=explode('/', $_SERVER['PHP_SELF']);
            $instance = $url_arr[1];
            
            $row= $this->db->get_where('main_users', $hrmCredentials)->row();

            if (count($row) > 0) {
                $this->session->set_userdata('hrm_login', '1');
                $this->session->set_userdata('hrm_id', $row->id);
                $this->session->set_userdata('login_user_id', $row->id);
                $this->session->set_userdata('name', $row->firstname);
                $this->session->set_userdata('login_type', 'hrm');                
                
                return 'success';
            }
        }
        
        if($credential!=''){
            $username = $email;
            
            $rs=$this->db->select('type_id')->get_where('member',array('email'=>$username))->row();            
            
            if(isset($rs->type_id)){
                if($rs->type_id==0 || $rs->type_id==1){
                    $password = $password;                    
                }else if($rs->type_id==2){
                    $password = md5($org_password);
                }
            }else{
                $this->session->set_flashdata('login_msg', $this->lang->line("Incorrect Email Id"));
                return 'invalid';
            }
            
            $table = 'member';
            $password = sha1($org_password);
            $where['where'] = array('email' => $username, 'password' => $password);
            
            $info = $this->Librarian_model->get_data($table, $where, $select = '', $join = '', $limit = '', $start = '', $order_by = '', $group_by = '', $num_rows = 1);
            $count = $info['extra_index']['num_rows'];

            if ($count == 0) {
                $info = $this->Librarian_model->get_data('student', $where, $select = '', $join = '', $limit = '', $start = '', $order_by = '', $group_by = '', $num_rows = 1);

                $count = $info['extra_index']['num_rows'];
                $this->session->set_flashdata('login_msg', $this->lang->line("invalid email or password"));

                $failed = $this->session->userdata('login_failed') ? $this->session->userdata('login_failed') : 0 ;
                $failed+=1;
                $this->session->set_userdata('login_failed', $failed);
                return 'invalid';
                //redirect(uri_string());
            } else {
                $username = $info[0]['name'];
                $user_type = $info[0]['type'];
                $member_id = $info[0]['id'];

                $this->session->unset_userdata('login_failed');

                $this->session->set_userdata('logged_in', 1);
                $this->session->set_userdata('librarian_login', 1);
                $this->session->set_userdata('username', $username);
                $this->session->set_userdata('user_type', $user_type);
                $this->session->set_userdata('member_id', $member_id);

                if($user_type=='Admin'){
                    $table = 'lib_id';
                    $where['where'] = array('id' => $member_id);
                    $select = array('memid');
                    $librarian_id = $this->Librarian_model->get_data($table, $where, $select);

                    if($librarian_id[0]['memid']){
                        $table = 'librarian';
                        $where['where'] = array(
                            'librarian_id' => $librarian_id[0]['memid'],
                        );
                        $select = array('*');

                        $data = $this->Librarian_model->get_data($table, $where, $select); 
                        if(!empty($data[0]['profile_image']) && @$data[0]['profile_image']!='') {
                            $this->session->set_userdata('profile_image', $data[0]['profile_image']);
                        }
                    }
                }
                
                return 'success';
            }
            
        }
        
       return 'invalid';
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
            $user_type = $arr['user_type'];
            $this->setSessionLinkAdmin($user_type, $role_id);
            return;
        }

        $user_type = $arr['user_type'];
        $this->session->set_userdata('role_id', $role_id);
        $links =  $this->Crud_model->getModuleLinks($role_id);
       
        $subLinks = array();
        $arrAllLinks = array();
        $parent_login = $this->session->userdata('parent_login');
        
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
                        if(isset($arr2[$key]))
                            $arrAllLinks[$link_name][$value][$arr3[$key]] = $arr2[$key];
                    }    
                }    
            }    
            
        }
        
        $this->session->set_userdata('arrAllLinks', $arrAllLinks);
    }
    /*
     * fun for checking the existance of email already
     */
    
    function setSessionLinkAdmin($user_type, $role_id)
    {
        $user_type = $user_type;
        $this->session->set_userdata('role_id', $role_id);
        $links =  $this->Crud_model->getModuleLinks($role_id);
       
        $subLinks = array();
        $arrAllLinks = array();
        
       
        if(count($links))
        {
            foreach($links as $link)
            {
                $link_id = $link['link_id'];
                $link_name = $link['name'];
                $image1 = $link['image1'];
                $val_array =  $this->Crud_model->getSubLinksAdmin($link_id, $user_type); 
               
                pre($val_array); die;
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
                   
                    foreach($val_array['data'] as $values)
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
                        if(isset($arr2[$key]))
                            $arrAllLinks[$link_name][$value][$arr3[$key]] = $arr2[$key];
                    }    
                }    
            }    
      
    }
    }  
    function validate_student_email(){
        $email=urldecode($this->input->post('email'));
        $result = get_data_generic_fun('student','email',array('email'=>$email),'result_arr');
        echo count($result);
    }
    
    public function update_rfid() {
        $this->load->model("Student_model");
        $student_id         =       $this->input->post('student_id');
        $rfid               =       $this->input->post('rfid');
        
        if( $student_id != "" && $rfid != "" ) {
            $data                   =   array( 'card_id' => trim($rfid));
            $condition              =   array( 'student_id' => (int)(trim($student_id)));
            $update_rfid            =   $this->Student_model->update_student( $data , $condition );
            if( $update_rfid ) {
                $response_array         =   array('status' => "success" , 'message' => "RFID Updated Success");
            } else {
                $response_array         =   array('status' => "failed" , 'message' => "Error in Updation");
            }
        } else {
            $response_array         =   array('status' => "failed" , 'message' => "Error In Student or RFID");
        }
        print_r(json_encode($response_array));exit;
    }

    /****Ajax function for getting class and section baased on logged teacher*******/
    function get_class_sections_by_teachers($teacher_id, $class_id) {          
        $this->load->model("Section_model");
        $sections = $this->Section_model->get_data_generic_fun('*',array('teacher_id'=>$teacher_id, 'class_id'=> $class_id),'result_arr');
        echo '<option value=" ">' . "Select Section" . '</option>';
        foreach ($sections as $row) {
            echo '<option value="' . $row['section_id'] . '">' . $row['name'] . '</option>';
        }
    }
    
    function get_class_subjects_by_teachers($teacher_id, $class_id, $section_id) {          
        $this->load->model("Subject_model");
        $subjects = $this->Subject_model->get_data_by_cols('*',array('teacher_id'=>$teacher_id, 'class_id'=> $class_id, 'section_id'=> $section_id),'result_array');
        echo '<option value=" ">' . "Select Subject" . '</option>';
        foreach ($subjects as $row) {
            echo '<option value="' . $row['subject_id'] . '">' . $row['name'] . '</option>';
        }
    }
   
   
    function get_class_routine_by_teacher($teacher_id = '', $class_id = '', $section_id = ''){
       $this->load->model("Class_routine_model");      
       $routine_details = $this->Class_routine_model->get_class_routine_details($teacher_id, $class_id, $section_id); 

       if(!empty($routine_details)){
       ?>
        <div class="row">	
            <div class="col-md-12">
                <div class="panel panel-default" data-collapsed="0" data-step="7" data-intro="Here you can see the class detail." data-position='top'>
                    <div class="p-20">
                            <b><?php echo get_phrase('class'); ?>&nbsp;
                            <?php echo $routine_details[0]['class_name'];?>&nbsp;<?php echo " : ".get_phrase('section'); ?>&nbsp;<?php echo $routine_details[0]['section_name'];?></b>
                     <a href="<?php echo base_url();?>index.php?teacher/class_routine_print_view/<?php echo $class_id;?>/<?php echo $section_id;?>" 
                                class="fcbtn btn btn-danger btn-outline btn-1d pull-right" target="_blank" data-step="6" data-intro="From here you can take print." data-position='left'>
                                    <i class="entypo-print"></i> <?php echo get_phrase('print');?>
                            </a>
                    </div>
                 
                    <div class="panel-body panel-body-over">                
                    <table cellpadding="0" cellspacing="0" border="0"  class="table table-bordered">
                    <tbody>
                        <?php 
                        $year                           =   $this->globalSettingsRunningYear;
                        for($d=1;$d<=7;$d++):                        
                        if($d==1)$day='sunday';
                        else if($d==2)$day='monday';
                        else if($d==3)$day='tuesday';
                        else if($d==4)$day='wednesday';
                        else if($d==5)$day='thursday';
                        else if($d==6)$day='friday';
                        else if($d==7)$day='saturday';
                        ?>
                        <tr class="gradeA">
                            <td width="100"><?php echo strtoupper($day);?></td>
                            <td>
                                <?php
                                $routines = get_data_generic_fun('class_routine','*',array('day' => $day, 'class_id' => $routine_details[0]['class_id'], 'section_id' => $routine_details[0]['section_id'],'year'=>$year),'result_arr', array('time_start'=>'asc'));
                                foreach($routines as $row2):
                                ?>
                                <div class="btn-group btn-bottom">
                                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                        <?php echo $this->crud_model->get_subject_name_by_id($row2['subject_id'])."(".$this->crud_model->get_teacher_name_by_subject_id($row2['subject_id']).")";?>
                                        
                                        <?php
                                            if ($row2['time_start_min'] == 0 && $row2['time_end_min'] == 0) 
                                                echo '('.$row2['time_start'].'-'.$row2['time_end'].')';
                                            if ($row2['time_start_min'] != 0 || $row2['time_end_min'] != 0)
                                                echo '('.$row2['time_start'].':'.$row2['time_start_min'].'-'.$row2['time_end'].':'.$row2['time_end_min'].')';
                                        ?>
                                        
                                    </button>
                                </div>
                                <?php endforeach;?>
                            </td>
                        </tr>
                        <?php endfor;?>                        
                    </tbody>
                    </table>                
                    </div>                     
                </div>
            </div>
        </div>
       <?php } else{ ?>
           <table class="table table-bordered datatable white-box" id="norecord">
            <thead>
                <tr>
                    <th><div></div></th> 
                <tr>
            </thead>
            <tbody>
                <tr>
                    <td><div><label><?php echo get_phrase('no_records_found!!'); ?></label></div></td>
                </tr>
            </tbody>
        </table>
           
       <?php } 
    }
    

     

    /*
     * Total number of notification for today
     * 
     */
    public function get_no_of_notication_today() {
        $this->load->model("Notification_model");
        $user_notif_user        =   $this->Notification_model->get_notifications( 'push_notifications' , $user_type );
        $user_notif_common      =   $this->Notification_model->get_notifications( 'push_notifications' );
        $total_count            =   count($user_notif_user)+count($user_notif_common);
        return $total_count;
    }
    
    /*
     * Get all notifications
     */
    public function getNotifications( $count = '' ) {
        $this->load->model("Notification_model");

        if( $this->session->userdata('school_admin_login') == 1 ) {
            $notif_link_url     =   base_url()."index.php?school_admin/";
            $user_type          =   'admin';
        } else if( $this->session->userdata('student_login') == 1 ) {
            $notif_link_url     =   base_url()."index.php?student/";
            $user_type          =   'student';
        } else if( $this->session->userdata('teacher_login') == 1 ) { 
            $notif_link_url     =   base_url()."index.php?teacher/";
            $user_type          =   'teacher';
        } else if($this->session->userdata('parent_login') == 1 ) {
            $notif_link_url     =   base_url()."index.php?parents/";
            $user_type          =   'parent';
        } 
        
        $user_id                =   $this->session->userdata('login_user_id');

        if($user_type   ==  'student') {
            $running_year                   =       $this->globalSettingsRunningYear;
            $student_information_arr        =       $this->db->get_where( 'enroll' , array('student_id'=>$user_id , 'year'=>$running_year ) )->result();
            if(!empty($student_information_arr)){
                $class_id       =   $student_information_arr[0]->class_id;
            }
        }
        
        if(isset($class_id) && $user_type   ==  'student') {
            $user_notif_class   =   $this->Notification_model->get_notifications( 'push_notifications' , $user_type , $user_id, $class_id );
        } else {
            $user_notif_class   =   array();
        }

        $user_notif_user        =   $this->Notification_model->get_notifications( 'push_notifications' , $user_type , $user_id );

        $user_notif_user_type   =   $this->Notification_model->get_notifications( 'push_notifications' , $user_type );

        $user_notif_common      =   $this->Notification_model->get_notifications( 'push_notifications' );

        $notifications          =   array_merge($user_notif_user,$user_notif_class,$user_notif_common,$user_notif_user_type);
        $total_count            =   count($notifications);
        
        if($count == 'count') {
            return $total_count;
        }
        
        $notifi_date = array();
        foreach ($notifications as $key => $row)
        {
            $notifi_date[$key] = $row['created_date'];
        }
        array_multisort($notifi_date, SORT_DESC, $notifications);
        $push_notification_html         =   '<li>
                        <div class="drop-title">Notifications</div>
                    </li>'.'<li>';
        if(!empty($notifications)) {
            
            foreach( $notifications as $notific_val ) {
                $string_length                  =       (int)strlen($notific_val['notification']);
                if($string_length > 100) {
                    $notification_string        =       substr($notific_val['notification'],0,99).'...' . '<span class="read-more">Readmore</span>';
                } else {
                    $notification_string        =       $notific_val['notification'];
                }
                $notification_link              =       ($notific_val["notification_link"]!=''?$notif_link_url.$notific_val["notification_link"]:'javascript:void(0)');
                $list_notification              =       ' <li class="notify_row">
                        <div class="message-center">
                            <div class="mail-contnet overme">
                                <a href="'.$notification_link.'"><span class="mail-desc">'
                                .$notification_string.'</span></a>
                                <span class="time">'.$notific_val['created_date'].'</span> </div>
                        </div>';
                $push_notification_html         .=      $list_notification;
            }

            $push_notification_html             .=      '</li>';
        } else {
            $push_notification_html             .=   '<li>No Notifications</li>';
        }
            print_r(json_encode(array( 'total_count' => $total_count , 'notifications' => $push_notification_html))); die();
    }
        
    
    function class_get_subject($class_id){
        $rs=get_data_generic_fun("subject","*",array("class_id"=>$class_id));
        ob_start();
        ?>
        <label class="control-label"><?php echo get_phrase('subject');?></label>
        <select name="subject_id" id="subject_id" class="form-control" onchange="UpdateTeacherFilter(this.value);">
        <option value=""><?php echo get_phrase('select_subject');?></option>
        <?php foreach($rs AS $k):?>
        <option value="<?php echo $k->subject_id;?>"><?php echo $k->name;?></option>
        <?php endforeach;?>
        </select>
        <?php
        $content=ob_get_contents();
        ob_end_clean();
        echo $content;die;
    }
    
    public function blog_available($blog_id){  
        $this->load->model("Blog_model");
        if($this->Blog_model->make_available($blog_id)) {
            $this->session->set_flashdata('flash_message', get_phrase('Blog is now public'));
        }else{
            $this->session->set_flashdata('flash_message', get_phrase('Error Occured'));
        } 
        exit;
    }
    
    /****Ajax function for getting section based class*******/
    function get_sections_by_class($class_id,$teacher_id="") {          
        $this->load->model("Section_model");
        if($teacher_id==""){
            $sections = $this->Section_model->get_data_generic_fun('*',array('class_id'=>$class_id),'result_arr');
        }else{
            $sections = $this->Section_model->get_section($class_id,$teacher_id);
            //$sections = $this->Section_model->get_data_generic_fun('*',array('class_id'=>$class_id,$teacher_id),'result_arr');
        }
        echo '<option value=" ">' . "Select Section" . '</option>';
        foreach ($sections as $row) {
            echo '<option value="' . $row['section_id'] . '">' . $row['name'] . '</option>';
        }
    }
  
  /****Ajax function for getting Coscholastic Activity based class*******/
    function cs_activities_class($class_id){
        $this->load->model("Cce_model");
        $cs_activities = $this->Cce_model->cce_coscholastic_activities('class_id', $class_id);
        echo '<option value=" ">' . "Select Activity" . '</option>';
        foreach ($cs_activities as $row) {
            echo '<option value="' . $row['csa_id'] . '">' . $row['csa_name'] . '</option>';
        }
    }
    
    /****Ajax function for getting blog subcategories*******/
    function get_blog_subcategories($category_id) { 
        $subcategories = get_data_generic_fun('blog_category','*',array('blog_category_parent_id'=>$category_id),'result_arr');
        echo '<option value=" ">' . "Select Subcategory" . '</option>';
        foreach ($subcategories as $row) {
            echo '<option value="' . $row['blog_category_parent_id'] . '">' . $row['blog_category_name'] . '</option>';
        }
    }
    
    function add_clinical_record() {
        if ($this->session->userdata('school_admin_login') != 1)
            redirect(base_url(), 'refresh');
        
        $this->load->helper("send_notifications");
        $medical_rec                    =   $this->input->post();
        $this->load->model("Medical_events_model"); 
        $this->load->model("Student_model"); 
        $response                       =   array();
        if ($medical_rec) {            
            $student_id                 =   $medical_rec['student_id'];
            $clinic['desease_title']    =   $medical_rec['disease'];
            $clinic['description']      =   $medical_rec['discription'];
            $clinic['diagnosis']        =   $medical_rec['diagnosis'];
            $clinic['consult_date']     =   date('Y-m-d', strtotime($medical_rec['cunsolt_date']));
            $clinic['consult_time']     =   date('h:m:s');//$medical_rec['cunsolt_time'];
            $clinic['prescriptions']    =   $medical_rec['prescriptions'];
            $clinic['message_status']   =   0;
            $clinic['status']           =   1;
            $student_det                =   $this->Student_model->get_student_details($student_id);
            if(!empty($student_det)) {
                $clinic['user_id']      =   $student_id;                                
                $record_id              =   $this->Medical_events_model->save_record($clinic);
                if($record_id) {
                    $emergency_contact  =   $student_det->emergency_contact_number;
                    $message            =   array();

                    $message_body       =   'Hello Dear '. $student_det->father_name .' , '.
                            $student_det->name. ' '.($student_det->mname!=""?$student_det->mname." ":" ").$student_det->lname.' Feel '.$medical_rec['disease']."<br>";
                    $message_body      .=   '<br><br>Discription :'.$medical_rec['discription'];

                    $message['sms_message'] =   'Hello Dear '. $student_det->father_name .', '.
                            $student_det->name. ' '.($student_det->mname!=""?$student_det->mname." ":" ").$student_det->lname.' Feel '.$medical_rec['disease'];

                    $message['subject']             =      'Your Child Feel '.$medical_rec['disease'];
                    $message['messagge_body']       =      $message_body;
                    $message['to_name']             =      $student_det->father_name;
                    $user_details                   =   array();
                    $user_details['user_type']      =   'parent';
                    $user_details['user_id']        =   $student_det->parent_id;
                    send_school_notification( 'all_notification' , $message , array( $emergency_contact ) , array($student_det->par_email) , $user_details);
                    $response['status'] =   'success';
                    $response['message']=   get_phrase('medical_record_has_been_added');
                    $response['record'] =   $record_id;

                    $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
                } else {
                    $response['status'] =   'fail';
                    $response['message']=   get_phrase('medical_record_not_added');
                }
            } else {
                $response['status'] =   'fail';
                $response['message']=   get_phrase('no_student_exists');
            }
        } else {
            $response['status'] =   'fail';
            $response['message']=   get_phrase('invalid_input');
        }
        print_r(json_encode($response));exit;
    }
    
    /*
     * Delete / Disable Clinical Record
     * 
     */
    public function delete_medical_record($record_id,$class_id,$section_id) {
        $record_id                  =   $record_id; //$this->input->post('record_id');
        $this->load->model("Medical_events_model"); 
        $medical_record             =   $this->Medical_events_model->get_medical_records( $record_id );
        $data                       =   array('status'=>5);
        $condition                  =   array('id'=>(int)$record_id);
        $delete_record              =   $this->Medical_events_model->update_record($data,$condition);
        $response_array             =   array();
        $page_data['class_id'] = $class_id;
        $page_data['section_id'] = $section_id;
        if($delete_record) {
            $this->session->set_flashdata('flash_message', get_phrase('data_deleted_successfully'));
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('error_in_deletion!'));
        }
        redirect(base_url() . 'index.php?school_admin/clinical_records', 'refresh');
    }

    
    function questions($exam_id,$ques_id)
    {
        $answer= $this->input->post('answer[]');
        echo $answer;
     
       // echo $exam_id;
       // $all_question  =  $this->db->get_where('questions', array('exam_id' =>$exam_id))->result_array();
       // pre($all_question);
    }


    
   
    function get_route_name($bus_id=''){
        $response_html  =   '';
        $this->load->model('transport_model');
        $route_id       =   $this->transport_model->get_ajax_route_name($bus_id);
        foreach ($route_id as $row) {
            
            $response_html .= "<div class='col-md-6 form-group'>".
                    "<label for='field-1'>". get_phrase('route')."</label>
                    <div class='input-group'><span class='input-group-addon'><i class='fa fa-map-marker'></i></span><input type='text'class='form-control' id='route_name' name='route_name' value=".$row['route_name']." disabled > </div>
                    <div class='input-group'><input type='hidden' class='form-control' id='route_id' name='route_id' value=".$row['transport_id']." > </div>
                </div>";
        }
        $route_id       =   $this->transport_model->get_ajax_bus_driver_name($bus_id);
        foreach ($route_id as $row) {
           $response_html         .= "<div class='col-md-6 form-group'>
                    <label>". get_phrase('bus_driver')."</label>
                    <div class='input-group'><span class='input-group-addon'><i class='icon-user'></i></span><input type='text' class='form-control' id='driver_name' name='driver_name' value=".$row['name']." disabled > </div>
                         <div class='input-group'><input type='hidden' id='bus_driver_id' name='driver_id' value=".$row['bus_driver_id']." > </div>
                </div>";
        }
        echo $response_html;
    }
    function get_section($class_id,$teacher_id){
        $this->load->model('class_model');
        $sections = $this->class_model->get_section_by_subject($class_id,$teacher_id);
        echo '<option value=" ">' . "Select Section" . '</option>';
        foreach ($sections as $row) {
            echo '<option value="' . $row['section_id'] . '">' . $row['name'] . '</option>';
        }
    }
    
    /*
     * Check Email Existance for all users admin,student,parent,teacher
     */
    public function check_email_exist_allusers() {
        $email=urldecode($this->input->post('email'));
        $result_stud    =   get_data_generic_fun('student','email',array('email'=>$email),'result_arr');
        $result_par     =   get_data_generic_fun('parent','email',array('email'=>$email),'result_arr');
//        $result_tea     =   get_data_generic_fun('teacher','email',array('email'=>$email),'result_arr');
        $result_adm     =   get_data_generic_fun('admin','email',array('email'=>$email),'result_arr');
        $result_bus_admin =   get_data_generic_fun('bus_administrator','email',array('email'=>$email),'result_arr');
        
        $response_arr   =   array();
        if(count($result_stud)>=1) {
            $response_arr['email_exist']        =   "1";
            $response_arr['message']            =   get_phrase('one_student_used_').$email;
        } else if(count($result_par)>=1) {
            $response_arr['email_exist']        =   "1";
            $response_arr['message']            =   get_phrase('one_parent_used_').$email;
        } 
//        else if(count($result_tea)>=1) {
//            $response_arr['email_exist']        =   "1";
//            $response_arr['message']            =   get_phrase('one_teacher_used_').$email;
//        } 
        else if(count($result_adm)>=1) {
            $response_arr['email_exist']        =   "1";
            $response_arr['message']            =   get_phrase('email_already_used');            
        }else if(count($result_bus_admin)>=1) {
            $response_arr['email_exist']        =   "1";
            $response_arr['message']            =   get_phrase('email_already_used');            
        } else {
            $response_arr['email_exist']        =   "0";
            $response_arr['message']            =   $email;            
        }
        print_r(json_encode($response_arr));exit;

    }
    
    
    function post_parent_comment(){ 
        $this->load->model("Discussion_category_model");
        $comment_body                                =     $this->input->post('comment_body');
        $thread_id                                   =     $this->input->post('thread_id');
        $comment_id                                  =      $this->input->post('parent_comment_id');
        $user_data                                    =    $this->Discussion_category_model->get_user_type_id();         
        $comment['comment_body']                      =    trim(nl2br($comment_body)); 
        $comment['thread_id']                         =    $thread_id;
        $comment['parent_comment_id']                 =    $comment_id;         
        $comment['user_id']                           =    $user_data['user_id'];
        $comment['user_type']                         =    $user_data['user_type'];
        $comment['user_name']                         =    $user_data['user_name'];  
        if(!empty($comment)){
            $this->Discussion_category_model->save_replies($comment);            
            $this->session->set_flashdata('flash_message', get_phrase('your_comment_is_posted'));                
        }else{
            $this->session->set_flashdata('flash_message_error', get_phrase('error_in_posting'));

        }
        redirect(base_url(). 'index.php?discussion_forum/view_discussion_details/' . $thread_id, 'refresh');
    } 

    public function get_submit_assignment(){
        $this->load->model('Student_assignments_model');
        $page_data                              =       array();
        $classId                                =       $this->input->post('classId');
        $subject_id                             =       $this->input->post('subjectId');
        $topic_id                               =       $this->input->post('topicId');
        $page_data['assignment_details']        =       $this->Student_assignments_model->get_student_submit_Assignments($classId, $subject_id, $topic_id);
        $page_name                              =       'ajax_view_submit_assignments';  
        $this->load->view('backend/teacher'. '/' . $page_name . '.php', $page_data);
        
    }
    public function get_subject_wise_assignment(){
        $this->load->model('Student_assignments_model');
        $page_data                              =       array();
        $student_id                             =       $this->input->post('student_id');
        $subject_id                             =       $this->input->post('subject_id');
        $page_data['assignment_details']        =       $this->Student_assignments_model->get_Assignments($subject_id, $student_id);
        
        $page_name                              =       'ajax_view_assignments';        
        $this->load->view('backend/student'. '/' . $page_name . '.php', $page_data); 
    }

    function get_hostel_room($floor_name="",$hostel_id=""){
        $name                       =       get_data_generic_fun('hostel_room','room_number',array('floor_name'=>$floor_name,'hostel_id'=>$hostel_id));
        $response_html              =       '<option value="">Select Room</option>';
        foreach ($name as $row) {
            $response_html         .=       '<option value="' . $row->room_number . '">' . $row->room_number  . '</option>';
        }
        echo $response_html;
    }
    
    function get_hostel_students($type="",$floor_name="",$hostel_id="",$room_no=""){
        $this->load->model("hostel_registration_model");
        $name                       =       $this->hostel_registration_model->get_hostel_students($type,$floor_name,$hostel_id,$room_no);
        $response_html              =       '<option value="">Select Student</option>';
        foreach ($name as $row) {
            $response_html         .=       '<option value="' . $row['student_id'] . '">' . $row['name']  . '</option>';
        }
        echo $response_html;
    }
    
    function get_student_information($student_id=''){
        $this->load->model("student_model");
        $response_html              =   '';
        $student_information        =   $this->student_model->get_student_information($student_id);
        foreach($student_information as $row){
            $response_html         .= get_phrase("student_information")."<br>".get_phrase("name:").$row['name'].$row['mname'].$row['lname'].
                    "<br>".get_phrase("address:").$row['student_address']."<br>".get_phrase("phone_number:").$row['phone']."<br>".get_phrase("emergenry_number:").$row['emergency_contact_number'].
                    "<br>".get_phrase("email_id:").$row['student_email']."<br>".get_phrase("gender:").$row['sex']."<br>".
                    get_phrase("parent_information:")."<br>".get_phrase("father_name:").$row['father_name'].$row['father_mname'].$row['father_lname'].
                   get_phrase("mother_name:").$row['mother_name'].$row['mother_mname'].$row['mother_lname']. 
                    "<br>".get_phrase("address:").$row['address']."<br>".get_phrase("phone_numer:").$row['cell_phone'].
                    "<br>".get_phrase("email_id:").$row['email']."<br>";
        }    
        $this->load->model("hostel_registration_model");
        $student_hostel_information =   get_data_generic_fun("hostel_registration",'*',array('student_id'=>$student_id),'result_array');
      
          foreach($student_hostel_information as $hostels){
                  $i=0;
                  $newArray                         =       array();
                  $hostel_name                      =       get_data_generic_fun('dormitory','name',array('dormitory_id' => $hostels['hostel_id']),'result_arr');
                  $newArray                         =       array_merge($hostels,$hostel_name[$i]);
                  $i++;
                  $students_name[]                  =       $newArray;
              } 
            foreach($students_name as $value){
           $response_html          .= "<br>".get_phrase("student_hostel_information")."<br>".get_phrase("hostel_type:").$value['hostel_type'].
                    "<br>".get_phrase("hostel_name:").$value['name']."<br>".get_phrase("floor_name:").$value['floor_name']."<br>".get_phrase("room_no:").$value['room_no'].
                    "<br>".get_phrase("food:").$value['food']."<br>".get_phrase("register_date:").$value['register_date']."<br>".
                 get_phrase("vacating_date:").$value['vacating_date']."<br>".
                   get_phrase("transfer_date:").$value['transfer_date']. "<br>".
                  get_phrase("status:").$value['status']."<br>";
      }
        echo $response_html;
    }
    
    function get_teacher_ajax($class_id,$section_id){
        $this->load->model('teacher_model');
        $sections = $this->teacher_model->get_teacher_ajax($class_id,$section_id);
        echo '<option value=" ">' . "Select Teacher" . '</option>';
        foreach ($sections as $row) {
            echo '<option value="' . $row['teacher_id'] . '">' . $row['teacher_name'] . '</option>';
        }
    }
       
    function get_teacher_details(){        
        $this->load->model('Subject_model'); 
        $page_data                              =   array();
        $page_data['teacher_id']                =   $this->input->post('teacher_id');        
        $page_data['get_details']               =   $this->Subject_model->get_all_subjects_by_teacher($page_data['teacher_id']);
        if(!empty($page_data['get_details'])){
            $page_data['teacher_name']          =   get_data_generic_fun('teacher', 'name',array('teacher_id' => $page_data['teacher_id']), 'result_arr'); 
            $page_data['name']                  =   $page_data['teacher_name'][0]['name'];            
        }
        //$page_data['feed_back']                 =   get_data_generic_fun('faculty_feedback','*',array('teacher_id'=>$page_data['teacher_id']), 'result_arr', array('date_created' => 'ORDER BY', 'date_created' => 'DESC'));
        $page_name                              =   'ajax_view_feedback';        
        $this->load->view('backend/school_admin'. '/' . $page_name . '.php', $page_data);
    }
    
    function get_free_hostel_room($hostel_id="") {
        $hostel_room            =       get_data_generic_fun('hostel_room','room_number,hostel_room_id',array('hostel_id'=>$hostel_id,'available_beds >'=>0));
        $response_html          =       '';
        if(count($hostel_room)>=1) { 
            $response_html          .=      '<option value="">Select Room</option>';
            foreach ($hostel_room as $row) { 
                $response_html      .=      '<option value="' . $row->hostel_room_id . '">' . $row->room_number . '</option>';
            }
        } else {
            $response_html          .=      '<option value="">No Room Available</option>';
        }
        echo $response_html;
    }
    
    function check_availability(){
        $this->load->model("Section_model");
        $this->load->model("Enroll_model");
        $classId                        =       $this->input->post('class_id');
        $sectionId                      =       $this->input->post('section_id');
        $year                           =       '2017-2018';
        if(is_section_available_for_admission($classId, $sectionId, $year)==0){
            $responseArr        =       array('allowed' => 'no');
            echo json_encode($responseArr); die;
        }else if(is_section_available_for_admission($classId, $sectionId, $year)==1){
            $responseArr        =       array('allowed' => 'yes');
            echo json_encode($responseArr); die;
        }else if(is_section_available_for_admission($classId, $sectionId, $year)==2){
            $responseArr        =       array('allowed' => 'not_defined');
            echo json_encode($responseArr); die;
        }
    }
    
    
    public function get_exams($section_id= '', $class_id=''){
        $this->load->model('Exam_model');
        $exam               =       get_data_generic_fun('parrent_teacher_meeting_date', 'exam_id',array('section_id'=>$section_id, 'class_id'=>$class_id), 'result_arr');
        if(!empty($exam)){
            $exam_name      = $this->Exam_model->get_exam_name_for_ptm($exam);
            echo '<option value=" ">' . "Select Exam" . '</option>';
            foreach ($exam_name as $row) {
                echo '<option value="' . $row['exam_id'] . '">' . $row['name'] . '</option>';
            }
        }else{
            echo '<option value=" ">' . "No Exam Asigned" . '</option>';            
        }
        
    }
    
    function check_availability_for_class($class_id=''){
        $this->load->model("Enroll_model");
        $classId                        =       $this->input->post('class_id');
        $year                           =       $this->globalSettingsSMSDataArr[0]->description;
        if(is_class_available_for_admission($classId, $year)==0){
            $responseArr        =       array('allowed' => 'no');
            echo json_encode($responseArr); die;
        }else if(is_class_available_for_admission($classId, $year)==1){
            $responseArr        =       array('allowed' => 'yes');
            echo json_encode($responseArr); die;
        }else if(is_class_available_for_admission($classId, $year)==2){
            $responseArr        =       array('allowed' => 'not_defined');
            echo json_encode($responseArr); die;
        }
    }
    function get_bus_stop($route_id=''){
        $this->load->model('class_model');
        $sections = get_data_generic_fun('route_bus_stop','*',array('route_id'=>$route_id),'result_array');
        if(count($sections)>=1) {
                echo '<option value="">Select Stop</option>';
            foreach ($sections as $row) {
                echo '<option value="' . $row['route_bus_stop_id'] . '">' . $row['route_from'] .'----'. $row['route_to'].'</option>';
            }
        } else {
            echo '<option value="">No Stops</option>';
        }
    }
    
    
    function get_topics_by_date(){
        $this->load->model('Enroll_model');
        $this->load->model('Crud_model');
        $date                                       =       date('Y-m-d', strtotime($this->input->post('date')));
        $student_id                                 =       $this->input->post('student_id');
        $year                                       =       $this->globalSettingsRunningYear;
        $class_det                                  =       $this->Enroll_model->get_class_section_by_student($student_id, $year);
        $topic_details=array();
        if(!empty($class_det))
        $topic_details                              =       $this->Crud_model->get_topics_by_date($class_det->class_id, $class_det->section_id, $date);
        if(!empty($topic_details)){ 
            $count = 0; 
            foreach ($topic_details as $row): 
            $count++;
            echo " <tr>            
                    <td> $count</td>                
                    <td>".$row['title']."</td>
                    <td>".$row['description']."</td> 
                    <td>".$row['teacher_name']."</td> 
                    <td>".$row['name']."</td> 
                    <td>".$row['created_date']."</td>
                <tr>"; 
            endforeach;
        } die();
    }
    
     function get_subjectby_class_section($class_id,$section_id,$teacher_id="") {
        $this->load->model("Subject_model");
        if($teacher_id==""){
           $subject=$this->Subject_model->get_subjects_class_section1($class_id,$section_id);
        }else{
            $subject=$this->Subject_model->get_data_by_cols('subject_id,name',array('class_id'=>$class_id,'section_id'=>$section_id,'teacher_id'=>$teacher_id),'result_arr');
        }
//        echo '<option value=" ">'. get_phrase('select_subject').'</option>';
        foreach ($subject as $row){
            echo '<option value="' . $row['subject_id'] . '">' . $row['name'] . '</option>';
        }
     }
     
    function get_bus_stops($route_id=''){
        $this->load->model("Route_bus_stop_model");
        $bustops = $this->Route_bus_stop_model->get_busstop_by_route($route_id);
        echo '<option value="">'."Select Stops" .'</option>' ;
        foreach ($bustops as $row){
            echo '<option value="' . $row['route_bus_stop_id'] . '">' . $row['route_from'] ." - ". $row['route_to']. '</option>';
        }
    } 
    
    function get_route_fare($route=""){
        $name                                              =    get_data_generic_fun('route_bus_stop','route_fare',array('route_bus_stop_id'=>$route));
        foreach ($name as $row) {
        echo '<span>' .'Amount for this route is : ' .$row->route_fare  . '</span>';
        }
    }
    
     function update_teacher_status(){
        generate_log(" calling update_teacher_status from HRM.");
        $EmpId=trim($this->input->post('emp_id'));
        $status=trim($this->input->post('status'));
        generate_log(' teacher $EmpId : '.$EmpId.' ==== $status : '.$status);
        if(($EmpId!='') && ($status==0 || $status==1)){
            generate_log("comming for update with all condition");
           $this->load->model('Teacher_model');
           $this->Teacher_model->update_teacher_status($EmpId, $status);
           die('Teacher Status update done.') ;
        }else{
            generate_log("Sorry, something went wrong");
            die('Sorry, something went wrong') ;
        }
    }
    
    /*
     * get transport fee
     * @param $route_id
     */
    function get_transportfee($route_id) {
        $route_fee      =       get_data_generic_fun('fees_fi','*',array('route_id'=>$route_id),'result_array');
        if(count($route_fee)>=1) { 
            print_r(json_encode(array('status'=>'success','transport_fee'=>$route_fee[0]['fi_id'])));
        } else {
            print_r(json_encode(array('status'=>'failed','message'=>'Fee Not allocated for Route')));
        }
    }
    
    /*
     * get Dormitory fee
     * @param @hostel id
     */
    function get_dormitoryfee($room_id) {
        $room_fee      =       get_data_generic_fun('fees_fi','*',array('room_id'=>$room_id),'result_array');
        if(count($room_fee)>=1) {
            print_r(json_encode(array('status'=>'success','hostel_fee'=>$room_fee[0]['fi_id'])));
        } else {
            print_r(json_encode(array('status'=>'failed','message'=>'Fee Not allocated for Room')));
        }
    }

    function add_employee_from_hrm() {
        generate_log("calling url through CURL");
        //generate_log(json_encode($_POST));
        //generate_log(json_encode($this->input->post()));
        $table = $this->input->post("table", TRUE);
        $dataError = array();
        $dataArr = array();
        $isError=FALSE;
        if ($table == "") {
            $dataError[] = "table name is required";
            $isError = TRUE;
        } else {
            $dataArr['table'] = $table;
        }

        $name = $this->input->post("name", TRUE);
        if ($name == "") {
            $dataError[] = "'name' index is required";
            $isError = TRUE;
        } else {
            $dataArr['name'] = $name;
        }

        $last_name = $this->input->post("last_name", TRUE);
        if ($last_name == "") {
            $dataError[] = "'last name' index is required";
            $isError = TRUE;
        } else {
            $dataArr['last_name'] = $last_name;
        }

        $experience = $this->input->post("experience", TRUE);
        if ($experience == "") {
            //$dataError[]="'experience' index is required";
            //$isError=TRUE;
            $dataArr['experience'] = 1;
        } else {
            $dataArr['experience'] = $experience;
        }

        $specialisation = $this->input->post("specialisation", TRUE);
        if ($specialisation == "") {
            $dataError[] = "'specialisation' index is required";
            $isError = TRUE;
        } else {
            $dataArr['specialisation'] = $specialisation;
        }

        $email = $this->input->post("email", TRUE);
        if ($email == "") {
            $dataError[] = "'email' index is required";
            $isError = TRUE;
        } else {
            $dataArr['email'] = $email;
        }

        $password = $this->input->post("password", TRUE);
        if ($password == "") {
            $dataError[] = "'password' index is required";
            $isError = TRUE;
        } else {
            $dataArr['password'] = md5($password);
            $dataArr['passcode'] = $password;
        }

        $cell_phone = $this->input->post("cell_phone", TRUE);
        if ($cell_phone == "") {
            $dataError[] = "'cell_phone' index is required";
            $isError = TRUE;
        } else {
            $dataArr['cell_phone'] = $cell_phone;
        }

        $job_title = $this->input->post("job_title", TRUE);
        if ($job_title == "") {
            $dataError[] = "'job_title' index is required";
            $isError = TRUE;
        } else {
            $dataArr['job_title'] = $job_title;
        }

        $emp_id = $this->input->post("emp_id", TRUE);
        if ($emp_id == "") {
            $dataError[] = "'emp_id' index is required";
            $isError = TRUE;
        } else {
            $dataArr['emp_id'] = $emp_id;
        }

        $card_id = $this->input->post("card_id", TRUE);
        if ($card_id == "") {
            $dataError[] = "'card_id' index is required";
            $isError = TRUE;
        } else {
            $dataArr['card_id'] = $card_id;
        }

        $school_id = $this->input->post("school_id", TRUE);
        if ($school_id == "") {
            $dataError[] = "'card_id' index is required";
            $isError = TRUE;
        } else {
            $dataArr['school_id'] = $school_id;
        }
        
        if ($isError == FALSE) {
            $dataArr['isActive'] = "1";
            $dataArr['date_time'] = date('Y-m-d H:i:s');            
            
            generate_log("No Error DATAs = " . json_encode($dataArr));
            generate_log("$\dataArr\[table\] = " . $dataArr['table']);
            if ($dataArr['table'] == 'teacher') {
                generate_log("table is teacher");
                $this->load->model('Teacher_model');
                unset($dataArr['table']);
                generate_log("before teacher email checking checking");
                if ($this->Teacher_model->is_new_teacher_exists($dataArr['email'], $dataArr['cell_phone']) == FALSE) {
                    generate_log("email is valid and going to add teachr");
                    generate_log("final data arr : " . json_encode($dataArr));
                    $this->Teacher_model->add_from_hrm($dataArr);
                    /// Notification
                    $msg        =   "Welcome to ". CURRENT_INSTANCE ." School Mr. " .$dataArr['name'] ." your passcode for app is  " . $dataArr['passcode'] . "   download app here https://play.google.com/store/apps/details?id=".$this->globalSettingsAppPackageName."&hl=en";
                    $message                        =      array();
                    $message_body                   =      $msg."<br><br>";
                    $message['sms_message']         =      $msg;
                    $message['subject']             =      $this->globalSettingsSystemName." Created Account for You.";
                    $message['messagge_body']       =      $message_body;
                    $message['to_name']             =      $dataArr['name'];

                    $email      =   array($dataArr['email']);
                    $phone      =   array($dataArr['cell_phone']);
                    send_school_notification( 'new_user' , $message , $phone , $email );

                    generate_log("Teacher added successfully");
                    die("Teacher added successfully");
                } else {
                    generate_log("Teacher already exists");
                    die("Teacher already exists");
                }
            } else if ($dataArr['table'] == 'librarian') {
                $this->load->model('Librarian_model');
                unset($dataArr['table']);
                if ($this->Librarian_model->is_new_librarian_exists($dataArr['email']) == FALSE) {
                    $this->Librarian_model->add($dataArr);
                    generate_log("Librarian added successfully");
                    die("Librarian added successfully");
                } else {
                    generate_log("Librarian already exists");
                    die("Librarian already exists");
                }
            }
        } else {
            generate_log(" All ERROS = " . json_encode($dataArr));
            echo json_encode($dataError);
            die;
        }
    }
    
    function event_type(){
        if($this->input->method('REQUEST_METHOD')=='POST'){
            $this->form_validation->set_rules('categoryName', 'Category Name', 'required|is_unique[type.title]');
            //$this->form_validation->set_rules('categoryColor', 'Category Color', 'required');
            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run() == TRUE) {
                $this->load->model('Event_model');
                $data['title'] = $this->input->post('categoryName');
                //$data['event_color'] = $this->input->post('categoryColor');
                //echo '<pre>';print_r($_POST);exit;
                $this->Event_model->add_type($data);
                //$this->session->set_flashdata('flash_message', get_phrase('event_type_added_successfully'));
                $return = array('type'=>'success','msg'=>get_phrase('event_category_added_successfully'));
            }else{
                $return = array('type'=>'error','msg'=>validation_errors());
            }   
            echo json_encode($return);exit;
        }
    }
  
    public function check_category_name($str)
    {
        if ($str == 'test')
        {
            $this->form_validation->set_message('check_category_name', 'The {field} field can not be the word "test"');
            return FALSE;
        }
        else
        {
                return TRUE;
        }
    }

    public function enquired_students_by_class() {
        $class_id = $this->input->post("class_id");
        $appliedStudentsList = get_data_generic_fun("enquired_students", "*", array('class_id' => $class_id, 'form_submitted' => "1", 'counselling' => "0"), "result_array");
        if(count($appliedStudentsList)>=1) {
            echo '<option value="">Select Student</option>';      
            foreach( $appliedStudentsList as $student ) {
                echo '<option value="'.$student['student_id'].'">'.$student['student_fname']." ".$student['student_lname'].'</option>';
            }
        } else {
            echo '<option value="">No Student</option>';      
        }
        die();
    }
    
    public function get_student_det_for_admission() {
        $class_id               =   $this->input->post("class_id");
        $student_id             =   $this->input->post("student_id");
        //$student                =   get_data_generic_fun("student", "*", array('student_id'=>$student_id), "result_array");
        $appliedStudentsList    =   get_data_generic_fun("enquired_students", "*", array('class_id' => $class_id, 'student_id'=>$student_id), "result_array");
        
        //echo '<pre>';print_r($appliedStudentsList);exit;
        $this->load->model("Dormitory_model");
        $this->load->model("Transport_model");

        $dormitory_array = $this->Dormitory_model->get_dormitory_array(array("status"=> "Active"));
        $transport_array = $this->Transport_model->get_transport_array();
        $this->load->library('Fi_functions');
        $running_year = $this->globalSettingsRunningYear;
        $scholarships = $this->fi_functions->getScholarships($running_year);
        if ($scholarships) {
            $page_data['scholarships'] = $scholarships;
        }
        $active_installments = $this->fi_functions->getActiveInstallments($running_year);

        $school_fee_inst = array();
        $transp_fee_inst = array();
        $hostel_fee_inst = array();
        if ($active_installments) {
            $val = $active_installments[0];
            $school_fee_installment_ids = explode(',', $val['schoolfee_inst_types']);
            $transp_fee_installment_ids = explode(',', $val['transfee_inst_types']);
            $hostel_fee_installment_ids = explode(',', $val['hostelfee_inst_types']);

            foreach ($school_fee_installment_ids as $school_fee_inst_id) {
                $result = $this->fi_functions->get_installments($school_fee_inst_id);
                $school_fee_inst[] = $result[0];
            }

            foreach ($transp_fee_installment_ids as $transp_fee_inst_id) {
                $result = $this->fi_functions->get_installments($transp_fee_inst_id);
                $transp_fee_inst[] = $result[0];
            }

            foreach ($hostel_fee_installment_ids as $hostel_fee_inst_id) {
                $result = $this->fi_functions->get_installments($hostel_fee_inst_id);
                $hostel_fee_inst[] = $result[0];
            }
        }
        $fee_installment = array('school_fee_inst' => $school_fee_inst, 'transp_fee_inst' => $transp_fee_inst, 'hostel_fee_inst' => $hostel_fee_inst);
        $page_data['fee_installment'] = $fee_installment;
        
        $classDataArr = get_data_generic_fun("class", "*", array('class_id' => $class_id));
        $allClassDataArr = get_data_generic_fun("class", "*", array(), "arr");
        $page_data["class_name"] = $classDataArr[0]->name;
        $page_data['class_id'] = $class_id;
        $page_data['sections'] = get_data_generic_fun("section", "*", array('class_id' => $class_id), "arr");
        $page_data["classes_list"] = $allClassDataArr;
        $page_data['dormitories'] = $dormitory_array;
        $page_data['transports']  = $transport_array;
        $page_data['need_transport'] = isset($appliedStudentsList[0]) && isset($appliedStudentsList[0]['transport'])?$appliedStudentsList[0]['transport']:'';
        $this->load->view('backend/school_admin/admission_enq_allocation', $page_data);
    }

    public function get_section_by_class_id(){
        $class_id =   $this->input->post("class_id");
        $sections = get_data_generic_fun("section", "*", array('class_id' => $class_id), "arr");
        if(count($sections)){
            $sec='<option value="">Select Section</option>';
            if(count($sections)){ foreach($sections as $section){
               $sec .='<option value="'.$section['section_id'].'">'.$section['name'].'</option>';
            } }
            echo $sec;
        }else{
            echo false;
        }
    }    
    
    function delete_event_type(){
        $this->load->model('Event_model');
        $data['id'] = $this->input->post('categoryId');
        $event_type = $this->Event_model->get_event_type(array('id'=>$data['id']));
        $events = $this->Event_model->get_events_by_type($event_type->title);
        if($events){
            $return = array('type'=>'error','msg'=>'There are '.count($events).' events in this category. In order to remove this category the events must be deleted first!');
        }else{
            $this->Event_model->delete_type($data);
            //$this->session->set_flashdata('flash_message', get_phrase('event_type_deleted_successfully!!'));
            $return = array('type'=>'success','msg'=>get_phrase('event_type_deleted_successfully!!'));
        }
        echo json_encode($return);exit;
    }

    function delete_event(){
        $this->load->model('Event_model');
        $eventid = $this->input->post('eventId');
        $this->Event_model->delete_event(array('id'=>$eventid));
        //$this->session->set_flashdata('flash_message', get_phrase('event_type_deleted_successfully!!'));
        $return = array('type'=>'success','msg'=>get_phrase('event_deleted_successfully!!'));
        echo json_encode($return);exit;
    }
    
//For public search from header starts
    function public_search(){
        $user_type = $this->session->userdata('login_type');
        //echo $user_type;die;
        $search = $_POST['search'];
        if($search!=''){
            $where= array('user_type' => $user_type, 'search_status' => '1');

            $this->db->select('search.search_label, search.url'); 
            $this->db->from('search'); 
            $this->db->like('search_label', $search); 
            $this->db->where($where);
            $this->db->limit(5, 0);
            $data = $this->db->get()->result_array();
            //print_r($data);die;
            $rs='';
            if(count($data)){
                //$rs='<select class="form-control" onchange="window.location = this.options[this.selectedIndex].value">';
                $result=array();
                $i=0;
                foreach($data as $datum){
                    //$rs.='<option value="'.base_url().'index.php?'.$datum['url'].'">'.ucwords($datum['search_label']).'</option>';
                    $result[$i]['name']=ucwords($datum['search_label']);
                    $result[$i]['link']=base_url().'index.php?'.$datum['url'];
                    $i++;
                }
                //$rs.='</select>';
                //echo $rs;
                echo json_encode($result);
            }else{
                echo 'empty';
            }
        }else{
            echo 'empty';
        }
    }

//For public search from header ends
    function marks_get_subject($class_id='', $section_id='') { 
        $this->load->model('Subject_model');
        $data['class_id']= $class_id;
        $data['section_id']= $section_id;
        $page_data['subjects'] = $this->Subject_model->marks_get_subject($class_id, $section_id);
        echo '<option value=" ">' . "Select Subject" . '</option>';
        foreach ($page_data['subjects'] as $row) {
            echo '<option value="' . $row['subject_id'] . '">' . $row['name'] . '</option>';
        }
    }

    function marks_get_cwa_subject($class_id='', $section_id='') { 
        $this->load->model('Subject_model');
        $data['class_id']= $class_id;
        $data['section_id']= $section_id;
        $page_data['subjects'] = $this->Subject_model->marks_get_cwa_subject($class_id, $section_id);
        echo '<option value=" ">' . "Select Subject" . '</option>';
        foreach ($page_data['subjects'] as $row) {
            echo '<option value="' . $row['subject_id'] . '">' . $row['name'] . '</option>';
        }
    }

    function marks_get_gpa_subject($class_id='', $section_id='') { 
        $this->load->model('Subject_model');
        $data['class_id']= $class_id;
        $data['section_id']= $section_id;
        $page_data['subjects'] = $this->Subject_model->marks_get_gpa_subject($class_id, $section_id);
        echo '<option value=" ">' . "Select Subject" . '</option>';
        foreach ($page_data['subjects'] as $row) {
            echo '<option value="' . $row['subject_id'] . '">' . $row['name'] . '</option>';
        }
    }
    
    /* ALL PARENTS LIST Through ajax*/
 function all_parents(){
    $this->load->model('Parent_model');
    $list = $this->Parent_model->get_datatables();  
//    pre($list); die;
    
 
    $data = array();
        $no = $_POST['start'];
        foreach ($list as $parent) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $parent->father_icard_no;
            $row[] = ucwords($parent->father_name ." ". ($parent->father_mname!=''?$parent->father_mname:'') ." ". $parent->father_lname);
            $row[] = $parent->father_profession;
            $row[] = $parent->father_icard_type;
            $row[] =  ucwords($parent->mother_name ." ". ($parent->mother_mname!=''?$parent->mother_mname:'') ." ". $parent->mother_lname);
            $row[] = $parent->mother_profession;
            $row[] = $parent->mother_icard_type;
            
            $row[] = $parent->cell_phone;
            $row[] = $parent->email;
            
               if($parent->parent_status=='1'){
                                      $button_show =  '<button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" rel="tooltip" data-toggle="tooltip" data-placement="top" data-original-title="Enable"  title="Enable"><i class="fa fa-toggle-on"></i></button>';
        } else {
                                      $button_show =  '<button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" rel="tooltip" data-toggle="tooltip" data-placement="top" data-original-title="Disable"  title="Disable"><i class="fa fa-toggle-off"></i></button>';
                                     }
            
            
             if($parent->parent_status=='1'){ $row[] = 'Enabled';  }else{  $row[] = 'Disabled'; }
            
                      
            $row[] = '<div class="btn-group">
                                        <button type="button" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light">'.get_phrase('Option ').' <span class="caret"> </span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-default pull-right pos-static" role="menu">
                                            <!-- STUDENT AVERAGE LINK -->
                                            <li>
                                                <a href="'.base_url().'index.php?school_admin/regenerate_passcode_parent/'.					$parent->parent_id.'">
                                                    <i class="fa fa-upload"></i>'.get_phrase('update_passcode').'</a>
                                            </li>					     
                                        </ul>
                                    </div>';
          
            $row[] = '<a href="javascript: void(0);" onclick="showAjaxModal(\''.base_url().'index.php?modal/popup/modal_parent_view/'.$parent->parent_id.'\');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="'.get_phrase('view_profile').'" title="'. get_phrase('view_profile').'">
				   <i class="fa fa-eye"></i>
				  </button></a>
				    <a href="javascript: void(0);" onclick="showAjaxModal(\''.base_url().'index.php?modal/popup/modal_parent_edit/'.$parent->parent_id.'\');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="'.get_phrase('edit').'" title="'.get_phrase('edit').'" title="'.get_phrase('edit').'"> <i class="fa fa-pencil-square-o"></i></button></a><a href="javascript: void(0);" onclick="ConfirmParentToggleEnable(\''.base_url().'index.php?school_admin/parent/enable_disable/'.$parent->parent_id.'/'.$parent->parent_status.'\');">'.$button_show.'</a>';
            
//echo $row; die;
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Parent_model->count_all(),
                        "recordsFiltered" => $this->Parent_model->count_filtered(),
                        "data" => $data,
                );
        
        //output to json format
        echo json_encode($output);
} 
    
function all_teachers(){
    $this->load->model('Teacher_model','teachers');
    $list = $this->teachers->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $teachers) {
            if($teachers->teacher_status==0){
            $docStr = '<li>
                <a href="'.base_url().'index.php?school_admin/experience_certificate/'.$teachers->teacher_id.'"><i class="fa fa-folder-open-o"></i>  '.get_phrase("experience_certificate").'</a></li><li>
                <a href="'.base_url().'index.php?school_admin/internship_certificate/'.$teachers->teacher_id.'"><i class="fa fa-folder-open-o"></i> '.get_phrase("internship_certificate").'</a></li>';
            }else{
            $docStr = '<li><a href="'.base_url().'index.php?school_admin/internship_certificate/'.$teachers->teacher_id.'"><i class="fa fa-folder-open-o"></i> '.get_phrase("internship_certificate").'</a></li>';

           }
        
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $teachers->name ." ". ($teachers->middle_name!=''?$teachers->middle_name:'') ." ". $teachers->last_name;
            $row[] = $teachers->email;
            $row[] = $teachers->cell_phone;
            $row[] = '<div class="btn-group">
                                        <button type="button" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light">'.get_phrase("View_Details").'<span class="caret"></span></button>
                                        <ul class="dropdown-menu dropdown-default pull-right pos-static" role="menu">
                                            <!-- STUDENT Documents LINK -->
                                            '.$docStr.'
                                        </ul>
                                    </div>';
            
            $row[] = '<a href="#" onclick="showAjaxModal(\''.base_url().'index.php?modal/popup/modal_teacher_view/'.$teachers->teacher_id.'\');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="'.get_phrase('View Profile').'" title="'.get_phrase('View Profile').'"><i class="fa fa-eye"></i></button></a>'.'<a href="'.base_url().'index.php?school_admin/teacher/update_passcode/'.$teachers->teacher_id.'"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="'.get_phrase('Update Passcode').'" title="'.get_phrase('Update Passcode').'"><i class="fa fa-key"></i></button></a>';

            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->teachers->count_all(),
                        "recordsFiltered" => $this->teachers->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
}

//  all bus driver list
function all_bus_drivres(){
    $this->load->model('Bus_driver_modal');
    $list = $this->Bus_driver_modal->get_datatables();
//    pre($list); die;
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $bus_driver) {
              
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $bus_driver->bus_driver_name;
            $row[] = $bus_driver->email;
            $row[] = $bus_driver->phone;
            $row[] = $bus_driver->sex;
            $row[] = $bus_driver->bus_name;
            $row[] = $bus_driver->route_name;
            $row[] = '<div class="btn-group">
                    <a href="javascript: void(0);" onclick="showAjaxModal(\''.base_url().'index.php?modal/popup/modal_driver_bus_edit/'.$bus_driver->bus_driver_id.'\');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit Driver" title="Edit Driver"><i class="fa fa-pencil-square-o"></i></button></a>
                                                    <!--delete-->
                    <a href="javascript: void(0);" onclick="confirm_modal(\''.base_url().'index.php?school_admin/bus_driver/delete/'.$bus_driver->bus_driver_id.'\');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete Driver" title="Delete Driver"><i class="fa fa-trash-o"></i></button></a>
                    </div>';
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Bus_driver_modal->count_all(),
                        "recordsFiltered" => $this->Bus_driver_modal->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
}

//ALL STUDENT MISC REPORT LISTING

    function all_students_misc_report($class_id,$running_year){
        $this->load->model('Student_model');
        $this->load->model('Class_model');
        if($class_id==0 && $running_year==""){
                $class_id='all';
                $running_year=($cYear-1).'-'. ($cYear);            
            }
        $class_array                        = array('class_id' => $class_id);
        $i=0;
        
        $list = $this->Student_model->get_datatables($class_id,$running_year);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $student_info) {              
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $student_info->roll;
            $row[] = ucwords($student_info->stdent_fname." ". ($student_info->mname!=''?$student_info->mname:'') ." ". $student_info->lname);
            if($class_id == 'all'){
            $row[] = ucfirst($student_info->class_name);
            $row[] = ucfirst($student_info->section_name);             
            }
            $row[] = ucwords($student_info->father_name ." ". ($student_info->father_mname!=''?$student_info->father_mname:'') ." ". $student_info->father_lname);
            $row[] = ucfirst($student_info->sex);
            $row[] = $student_info->birthday;
$row[] = '<div class="btn-group"><button type="button" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light">'.get_phrase('view_details').'<span class="caret"></span></button><ul class="dropdown-menu dropdown-default pull-right pos-static" role="menu"><li><a href="'.base_url().'index.php?school_admin/student_marksheet/'.$student_info->student_id.'"><i class="fa fa-folder-open-o"></i>'.get_phrase('marks_obtained_in_percentage').'</a></li><li><a href="'.base_url().'index.php?admin_report/selected_student_profile_details/'.$student_info->student_id.'"><i class="fa fa-folder-open-o"></i>'.get_phrase('profile_details').'</a></li><li><a href="'.base_url().'index.php?school_admin/average/'.$student_info->student_id.'"><i class="fa fa-folder-open-o"></i>'. get_phrase('academic_average').'</a></li></ul></div>';

            $data[] = $row;
        }

    $output = array("draw" => $_POST['draw'], "recordsTotal" => $this->Student_model->count_all($class_id,$running_year), "recordsFiltered" => $this->Student_model->count_filtered_all($class_id,$running_year), "data" => $data);
            //output to json format
        echo json_encode($output);
    }

    function section_students_misc_report($class_id,$running_year,$section){
        $this->load->model('Student_model');
        $list   =  $this->Student_model->get_datatables($class_id,$running_year,$section);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $row){
            $no++;
            $row1 = array();
            $row1[] =  $no;
            $row1[] =  $row->roll;
            $row1[] =  ucwords($row->stdent_fname." ". ($row->mname!=''?$row->mname:'') ." ". $row->lname);
            $row1[] =  ucwords($row->father_name ." ". ($row->father_mname!=''?$row->father_mname:'') ." ". $row->father_lname);
            $row1[] =  $row->sex;
            $row1[] =  $row->birthday;
    $row1[] =  '<div class="btn-group"><button type="button" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light">'.get_phrase('view_details ').'<span class="caret"></span></button><ul class="dropdown-menu dropdown-default pull-right pos-static" role="menu"><li><a href="'.base_url().'index.php?school_admin/student_marksheet/'.$row->student_id.'"><i class="fa fa-folder-open-o"></i>'.get_phrase('marks_obtained_in_percentage').'</a></li><li><a href="'.base_url().'index.php?admin_report/selected_student_profile_details/'.$row->student_id.'"><i class="fa fa-folder-open-o"></i>'.get_phrase('profile details').'</a></li><li><a href="'.base_url().'index.php?school_admin/average/'.$row->student_id.'>"><i class="fa fa-folder-open-o"></i>'.get_phrase('academic_average').'</a></li></ul></div>'; 
    
            $data[] = $row1;
        }
//        pre($data);exit;
    $output = array("draw" => $_POST['draw'], "recordsTotal" => $this->Student_model->count_all($class_id,$running_year), "recordsFiltered" => $this->Student_model->count_filtered($class_id,$running_year,$section), "data" => $data);
        //output to json format
        echo json_encode($output);
    }
//ALL DORMITORY MANAGE ALLOCATION LIST
function all_dormitory_manage_allocation_list(){
    $this->load->model('Hostel_registration_model');
    $list = $this->Hostel_registration_model->get_datatables();
//    pre($list); die;
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $hostel) {
              
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $hostel->hostel_name;
            $row[] = $hostel->student_name;
            $row[] = $hostel->hostel_type;
            $row[] = $hostel->floor_name;
            $row[] = $hostel->room_no;
            $row[] = $hostel->food;
            $row[] = $hostel->register_date;
            $row[] = $hostel->vacating_date;
        
             if($hostel->status == "transfer"){ 
            $row[]  =  $hostel->transfer_date;             
             }else{
            $row[] = get_phrase('not_transfered');  
                  }
            $row[] = $hostel->status;
            
            if($hostel->status == "present"){
                   $row[] = '<div class="btn-group">
                                <button type="button"  class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light" data-toggle="dropdown"> Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right pos-static" role="menu">
                                <!-- EDITING LINK -->
                              <li>
                              <a href="#" onclick="showAjaxModal(\''.base_url().'index.php?modal/popup/modal_edit_hostel_allocation/'.$hostel->hostel_reg_id.'\');"><i class="entypo-pencil"></i>'.get_phrase('edit').'</a></li> 
                                  <!-- vacate LINK -->
                              <li>
                                        <a href="#" onclick="vacate_confirm_modal(\''.base_url().'index.php?school_admin/manage_allocation/vacate/'.$hostel->hostel_reg_id.'/'.$hostel->room_no.'\',\'Are you sure !, you want to vacate?\');">
                                            <i class="entypo-shuffle"></i>'.get_phrase('vacate').'</a></li>
                                                <!-- Transfer LINK --><li>
                                      <a href="'.base_url().'index.php?school_admin/hostel_transfer/'.$hostel->student_id."/".$hostel->room_no."/".$hostel->hostel_reg_id.'\'"><i class="entypo-shuffle"></i>'.get_phrase('transfer').'</a></li>   
                   
                                          </ul>
                            </div>';
                   
            } 
            else { 
                $row[] = '<div class="btn-group">
                                <button type="button"  class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right pos-static" role="menu">
                                <!-- EDITING LINK -->
                               <li><i class="entypo-shuffle"></i>'.get_phrase('already_'.$hostel->status).'</li>   </ul>
                            </div>';
                   
            }  

            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Hostel_registration_model->count_all(),
                        "recordsFiltered" => $this->Hostel_registration_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
}

//LIBRARIEN LISTING 
    function get_students_library(){
    $this->load->model('Librarian_model');
    $list = $this->Librarian_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $library) {              
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $library->student_name;
            $row[] = $library->email.' '.$library->lname;
            $row[] = $library->title;
            $row[] = $library->issue_date;
            $row[] = $library->return_date;
            $row[] = $library->fine_amount;
              
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Librarian_model->count_all(),
                        "recordsFiltered" => $this->Librarian_model->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
}

    //class list
    function get_class_list(){
        $this->load->model('Class_model');
        $this->load->model('Crud_model');
        
        $list = $this->Class_model->get_datatables();
        foreach($list  as $k => $v){
            $list[$k]->transaction =  $this->Crud_model->getClassTransaction($v->class_id);
        } 
        //pre($list); die;
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $ik=>$class) {              
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $class->name;
//            $row[] = $class->teacher_name;
            if($class ->transaction == 0)
                $row[] = '<a href="javascript: void(0);" onclick="showAjaxModal(\''.base_url().'index.php?modal/popup/modal_edit_class/'.$class->class_id.'\');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="'.get_phrase('edit_class').'" title="'.get_phrase('edit_class').'"><i class="fa fa-pencil-square-o"></i></button> </a><a href="javascript: void(0);" onclick="confirm_modal(\''.base_url().'index.php?school_admin/classes/delete/'.$class->class_id.'\');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="'.get_phrase('delete_class').'" title="'.get_phrase('delete_class').'"><i class="fa fa-trash-o"></i> </button></a>';
            elseif($class ->transaction == 1)
                $row[] = '<a href="javascript: void(0);" onclick="showAjaxModal(\''.base_url().'index.php?modal/popup/modal_edit_class/'.$class->class_id.'\');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="'.get_phrase('edit_class').'" title="'.get_phrase('edit_class').'"><i class="fa fa-pencil-square-o"></i></button> </a>'
                    .'<button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 disabled"  data-placement="top" data-original-title="'.get_phrase('delete_class').'" title="'.get_phrase('delete_class').'"><i class="fa fa-trash-o"></i> </button>';
            $data[$ik] = $row;
        }
        //pre($data); die;

        if(isset($_POST['order']) && $_POST['order']['0']['column']=='0'){
            if($_POST['order']['0']['dir']=='desc')    
                krsort($data);
            else   
                ksort($data);
        }
        $new_data = array();
        foreach ($data as $dk=>$val) {
            $val[0] = $dk+1;
            $new_data[] = $val;
        } 
        $data = $new_data;

        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->Class_model->count_all(),
                    "recordsFiltered" => $this->Class_model->count_filtered(),
                    "data" => $data,
                ); 
        //output to json format
        echo json_encode($output);
    }
    
    function teacher_list_teacher_login(){
        $this->load->model('Teacher_model','teachers');
        $list = $this->teachers->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $teachers) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $teachers->name.' '.$teachers->last_name;
                $row[] = $teachers->email;
                $row[] = $teachers->cell_phone;
                $row[] = '<a href="javascript: void(0);" onclick="showAjaxModal(\''.base_url().'index.php?modal/popup/modal_teacher_view/'.$teachers->teacher_id.'\');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="'.get_phrase('View Profile').'" title="'.get_phrase('View Profile').'"><i class="fa fa-eye"></i></button></a>';

                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->teachers->count_all(),
                            "recordsFiltered" => $this->teachers->count_filtered(),
                            "data" => $data,
                    );
            //output to json format
            echo json_encode($output);
    }

    function check_parent_details_by_phone(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $parent_detail = $this->db->get_where('parent',array('cell_phone'=>$this->input->post('phone')))->row();
            $return = array('status'=>0);
            if($parent_detail){
                $return = array('status'=>1,
                                'father_name'=>$parent_detail->father_name,
                                'father_lname'=>$parent_detail->father_lname,
                                'mother_name'=>$parent_detail->mother_name,
                                'mother_lname'=>$parent_detail->mother_lname,
                                'email'=>$parent_detail->email);
            }
            echo json_encode($return);exit;
        }        
    }


//view all blogs
function get_all_view_blogs(){
    $this->load->model('Blog_model');
    $list = $this->Blog_model->get_datatables();
    $data = array();
    $no = $_POST['start'];
    //echo '<pre>'; print_r($list); exit;
    foreach ($list as $blog) { 
        if ($blog->blog_available == "1"){
            $button = '<label> "Published" </label>';
        }else if ($blog->blog_available == "2"){
            $button = '<label> Not Published </label>';
        }else if($blog->blog_available == "3"){
            $button = '<label>Resent to author</label>';
        }

        $no++;
        $row = array();
        $row[] = $no;
        $row[] = $blog->blog_title;
        $row[] = $blog->blog_user_name;
        $row[] = date('d, M Y', strtotime($blog->blog_created_time));
        $row[] = '<div class="btn-group">'.$button.'</div>';
        $row[] = '<a href="'.base_url().'index.php?blogs/blog_preview/'.$blog->blog_id.'">
                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View"><i class="fa fa-eye"></i></button>
                            </a>';
        $data[] = $row;
    }
    $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Blog_model->count_all(),
                "recordsFiltered" => $this->Blog_model->count_filtered(),
                "data" => $data,
            );
    echo json_encode($output);
}
    function get_bus_list(){
    $this->load->model('Bus_model');
    $this->load->model('Crud_model');
    $list = $this->Bus_model->get_datatables();
//     pre($list);die;
    foreach($list  as $k => $v){ 
        $list[$k]->transaction =  $this->Crud_model->getBusTransaction($v->bus_id);
    }
     
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $bus) {              
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $bus->name;
            $row[] = $bus->bus_unique_key;
            $row[] = $bus->description;
            $row[] = $bus->route_name;
            $row[] = $bus->device_imei;
            $row[] = $bus->number_of_seat;
            if($bus->transaction == 1)
                $row[] = '<a href="javascript: void(0);" onclick="showAjaxModal(\''.base_url().'index.php?modal/popup/modal_bus_edit/'.$bus->bus_id.'\');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit Bus" title="Edit Bus"><i class="fa fa-pencil-square-o"></i></button></a><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 disabled"><i class="fa fa-trash-o"></i></button>';
            else if($bus->transaction == 0)
                $row[] = '<a href="javascript: void(0);" onclick="showAjaxModal(\''.base_url().'index.php?modal/popup/modal_bus_edit/'.$bus->bus_id.'\');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit Bus" title="Edit Bus"><i class="fa fa-pencil-square-o"></i></button></a>
                    <a href="javascript: void(0);" onclick="confirm_modal(\''.base_url().'index.php?school_admin/bus/delete/'.$bus->bus_id.'\');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete Bus" title="Delete Bus"><i class="fa fa-trash-o"></i></button></a>';
          
              
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Bus_model->count_all(),
                        "recordsFiltered" => $this->Bus_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);

    }
        function manage_product_admin_login($categories_id){
        $this->load->model('Inventory_product_model');
        $list = $this->Inventory_product_model->get_datatables($categories_id);
        $data = array();
            $no = $_POST['start'];
            foreach ($list as $products) {
                $no++;
                $row = array();
                $row[]  =   $no;
                $row[]  =   $products->product_name;
                $row[]  =   $products->product_unique_id;
                $row[]  =   $products->rate;
                $row[]  =   $products->quantity;
                $row[]  =   $products->categories_name;
                $row[]  =   $products->seller_name;
                if ($products->status == 'Service') {
                    $row[]  = "<label class='label label-warning'>Service</label>";
                } else if ($products->status == 'Alloted') {
                    $row[]  = "<label class='label label-danger'>Alloted</label>";
                } else if ($products->status == 'Available') {
                    $row[]  = "<label class='label label-success'>Available</label>";
                } else {
                    $row[]  = "<label class='label label-danger'>Not Available</label>";
                }
                
                  
                            if ($products->status == 'Service') {
                $row[]  =   '<div class="btn-group">
                            <button type="button" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light" data-toggle="dropdown">'.
                            get_phrase('View_Details ').'<span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-default pull-right pos-static" role="menu">
                                    <li>
                                <a href="javascript: void(0);" onclick="showAjaxModal(\''.base_url().'index.php?modal/popup/modal_product_return_service/'. $products->product_id.'\');">
                                <i class="entypo-alert"></i>'.get_phrase('return_from_service').'</a>
                                </li></ul></div>';
                            } else { 
                                if ($products->status == 'Alloted') {               
                    $row[]  =  '<div class="btn-group">
                                <button type="button" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light" data-toggle="dropdown">'.
                                get_phrase('View_Details ').'<span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right pos-static" role="menu">
                                    <li>
                                    <a href="javascript: void(0);">'.get_phrase('already_alloted').'</a>
                                    </li>
                                      <li>
<a href="javascript: void(0);" onclick="showAjaxModal(\''.base_url().'index.php?modal/popup/modal_allot_product_print/'. $products->product_id.'\');">
                                <i class="entypo-shuffle"></i>'.get_phrase('Download').'</a>
                                    </li>
                                    <li>
                                     <a href="'.base_url().'index.php?school_admin/product_upload_receipt/'.$products->product_id.'">'.get_phrase('upload').'</a>
                                    </li>
                                    <li>
                                <a href="javascript: void(0);" onclick="showAjaxModal(\''.base_url().'index.php?modal/popup/modal_test_service/'. $products->product_id.'\');">
                                <i class="entypo-shuffle"></i>'.get_phrase('service').'</a>
                                </li></ul>
                            </div>';
                                } else {
                    $row[]  =   '<div class="btn-group">
                                <button type="button" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light" data-toggle="dropdown">'.
                                get_phrase('View_Details ').'<span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right pos-static" role="menu">
                                    <li>
                                    <a href="'.base_url().'index.php?school_admin/inventory_add_allotment/'.$products->product_id.'">
                                    <i class="entypo-alert"></i>'.get_phrase('allot').'</a>
                                    </li>
                                    <li>
                                <a href="javascript: void(0);" onclick="showAjaxModal(\''.base_url().'index.php?modal/popup/modal_test_service/'. $products->product_id.'\');">
                                <i class="entypo-shuffle"></i>'.get_phrase('service').'</a>
                                </li></ul>
                            </div>';
                                } 
                            }
                            
$row[]  = '<a href="'.base_url().'index.php?school_admin/inventory_edit_product/'.$products->product_id.'"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit Product"><i class="fa fa-pencil-square-o"></i></button></a><a href="javascript: void(0);" onclick="confirm_modal(\''.base_url().'index.php?school_admin/product/delete/'.$products->product_id.'\');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete Product"><i class="fa fa-trash-o"></i></button></a><a href="javascript: void(0);" onclick="generate_barcode('.$products->product_id.')"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Generate Barcode"><i class="fa fa-print"></i></button></a>';

                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->Inventory_product_model->count_all($categories_id),
                            "recordsFiltered" => $this->Inventory_product_model->count_filtered($categories_id),
                            "data" => $data,
                    );
            //output to json format
            echo json_encode($output);
    }

    function ajax_datatable_student_enquired_view(){
        $this->load->model('Enquired_students_model');
        $this->load->model('Class_model');
        $list = $this->Enquired_students_model->get_datatables();
       
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $applicants) {
                $no++;
                $row = array();
                $row[]  =   $no;
                $row[]  =   $applicants->student_fname.' '.$applicants->student_lname;
                $row[]  =   $applicants->parent_fname.' '.$applicants->parent_lname;
                $row[]  =   $this->Class_model->get_class_record(array('class_id' =>$applicants->class_id), "name");
                $row[]  =   str_replace("-", "/", $applicants->birthday);
                $row[]  =   $applicants->user_email;
                $row[]  =   $applicants->mobile_number;
                /* if ($applicants->form_genreated == 1) {
                    $row[]  =   '<a href="javascript: void(0);" onclick="showAjaxModal(\''.base_url().'index.php?modal/popup/modal_view_invoice/'. $applicants->invoice_id.'\');"class="btn btn-default" value="Receipt">View Receipt</a>';
                } 
                else {
                    if ($applicants->advance == 'yes') {
                        $row[]  =   '<button type="button" class="btn btn-success btn-sm" value="paid">Paid</button>';
                    } 
                    
                    else {
                        $row[]  =   '<button type="button" class="btn btn-danger btn-sm" value="not_paid">Not Paid</button>';
                    }
                } */
                if ($applicants->form_genreated == 0) {
                    $row[] = '<span class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Fill Form No."><input type="checkbox" onclick="handleClick(this);" name="generate_admision[]" id="admission_'. $no.'" value="'.$applicants->enquired_student_id.'"></span>';
                } else { 
                    if ($applicants->form_submitted == 0) { 
                        $row[]  =   '<a href="'.base_url().'index.php?school_admin/view_admission_form/'. $applicants->enquired_student_id.'">'
                                . '<button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" value="form" data-toggle="tooltip" data-placement="top" data-original-title="Edit Form"><i class="fa fa-pencil-square-o"></i></button>'
                                . '</a>'; 
                    } 
                    else {
                        $row[]  =   '<button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" value="form" data-toggle="tooltip" data-placement="top" data-original-title="Submitted" disabled><i class="fa fa-check-square-o"></i></button>'; 
                    } 
                }
                $row[]  = '<input class="form-control" type="text" placeholder="Form Number" id="Form_no'.$applicants->enquired_student_id.'" name="form_no_'. $applicants->enquired_student_id.'" value="'. $applicants->form_no.'"
                            '.($applicants->form_genreated==1?'disabled':'').' readonly>';
                
                $row[]  =   $applicants->admission_form_id;
                if ($applicants->form_submitted == 1) {
                    if ($applicants->counselling == 0) {
                        $row[]  =   '<a href="javascript: void(0);" onclick="showAjaxModal(\'' .base_url().'index.php?modal/popup/model_counselling_set/'. $applicants->student_id.'\');">
                                       <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" value="form" data-toggle="tooltip" data-placement="top" data-original-title="Call For Counselling"><i class="fa fa-phone"></i></button>
                            </a>';
                    } 
                    else { 
                        $row[]  =   '<button type="button"  class="btn btn-success btn-sm" value="form">Admitted</button>'; 
                    }    
                }
                else{
                    $row[]  =   '';
                }
                
                $data[] = $row;
            }
            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->Enquired_students_model->count_all(),
                            "recordsFiltered" => $this->Enquired_students_model->count_filtered(),
                            "data" => $data,
                    );
            //output to json format
            echo json_encode($output);
    }

// get marks manage list
function get_marks_manage_list(){
    $this->load->model('Setting_model');
    $this->load->model('Exam_model');
       $exam_id                               =     $this->input->post('exam_id');
       $class_id                                =     $this->input->post('class_id');
       $section_id                               =     $this->input->post('section_id');
       $subject_id                               =     $this->input->post('subject_id');
       $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
    $list = $this->Exam_model->get_datatables($exam_id,$class_id,$section_id,$subject_id,$running_year);
//    pre($list); die;
        $data = array();
        $no = $_POST['start'];
        $count_row = count($list);
 
        foreach ($list as $mark_manage) {              
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $mark_manage->roll;
            $row[] = ucwords($mark_manage->name.' '.$mark_manage->lname);
            $row[] = '<input type="text" class="form-control" name="marks_obtained_'.$mark_manage->mark_id.'" value="'.$mark_manage->mark_obtained.'"></td>';$row[] = '<input type="text" class="form-control" name="comment_'.$mark_manage->mark_id.'" value="'.$mark_manage->comment.'">';
                          
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" =>$count_row,
                        "recordsFiltered" => $this->Exam_model->count_filtered($exam_id,$class_id,$section_id,$subject_id,$running_year),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }  
    
    function transport_list_teacher_login(){
        $this->load->model('Transport_model');
        $list = $this->Transport_model->get_datatables();
//        pre($list); die;
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $transport) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $transport->route_name;
                $row[] = $transport->number_of_vehicle;
                $row[] = $transport->description;
                $row[] = $transport->route_fare;
                
                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->Transport_model->count_all(),
                            "recordsFiltered" => $this->Transport_model->count_filtered(),
                            "data" => $data,
                    );
            //output to json format
            echo json_encode($output);
    }

    //STUDENT LIST IN TEACHER LOGIN
    function student_list_teacher_login(){        
        $this->load->model('Student_model');
         $list = $this->Student_model->get_datatables_teacher_login_students();
//        pre($list); die;
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $student){
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $student->name.' '.$student->lname;
                $row[] = $student->father_name.' '.$student->father_lname;
                $row[] = $student->mother_name.' '.$student->mother_lname;
                $row[] = $student->sex;
                $row[] = $student->birthday;
                          
                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->Student_model->count_filtered_teacher_login(),
                            "recordsFiltered" => $this->Student_model->count_filtered_teacher_login(),
                            "data" => $data,
                    );
            //output to json format
            echo json_encode($output);
    }
    
    //ALL TEACHER LIST IN STUDENT LOGIN 
    function all_teacher_student_login(){
        $this->load->model('Teacher_model');
         $list = $this->Teacher_model->get_datatables();
//        pre($list); die;
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $teacher){
                $img_url = $this->crud_model->get_image_url('teacher',$teacher->teacher_id);
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = '<img src="'.$img_url.'" class="img-circle" width="30" />';
                $row[] = $teacher->name.' '.$teacher->last_name;
                $row[] = $teacher->email;                          
                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->Teacher_model->count_all(),
                            "recordsFiltered" => $this->Teacher_model->count_filtered(),
                            "data" => $data,
                    );
            //output to json format
            echo json_encode($output);
    }
    
    //TRNASPORT LIST OF STUDENT LOGIN
    function transport_list_student_login(){
        $this->load->model('Transport_model');
        $list = $this->Transport_model->get_datatables();
//        pre($list); die;
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $transport) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $transport->route_name;
                $row[] = $transport->number_of_vehicle;
                $row[] = $transport->description;
                $row[] = $transport->route_fare;
                
                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->Transport_model->count_all(),
                            "recordsFiltered" => $this->Transport_model->count_filtered(),
                            "data" => $data,
                    );
            //output to json format
            echo json_encode($output);
    }

    //For Bus Driver Login
    function get_bus_list_driver(){
        $this->load->model('Bus_driver_modal');
        $list = $this->Bus_driver_modal->get_datatables();        
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $bus) {              
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $bus->name;
            $row[] = $bus->bus_unique_key;
            $row[] = $bus->description;
            $row[] = $bus->route_name;
            $row[] = $bus->number_of_seat;
            
            $data[] = $row;
        }
        
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Bus_driver_modal->count_all(),
                        "recordsFiltered" => $this->Bus_driver_modal->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }
    
    

    //VIEW ALL BLOG IN STUDENT LOGIN 
    function view_all_blog_student_login($param1=''){
        $this->load->model('Blog_model');
        $category                                =     $this->input->post('category_id');
        $list = $this->Blog_model->get_datatables($category,$param1);  
        $filtered_record = count($list);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $blog) {            
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<a href="'.base_url().'index.php?blogs/view_blogs_details/'.$blog->blog_id.'"><h4>'.$blog->blog_title.'</h4></a><span class="view-all-blog-span"><a href="#"></a></span>'.get_phrase('posted_by')." ".$blog->blog_user_name.' @ '.date("d, M Y H:i:s", strtotime($blog->blog_created_time));
            $data[] = $row;
        }
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Blog_model->count_all($category,$param1),
                        "recordsFiltered" => $this->Blog_model->count_filtered($category,$param1),
                        "data" => $data,
                );
        echo json_encode($output);
}
 
    public function parent_misc_report_all($class_id=0,$running_year="") {
        $this->load->model("Parent_model");
        $class_array = array('class_id' => $class_id);
        $this->load->model("Class_model");
        $page_data['sections'] = $this->Class_model->get_section_array($class_array);
        if ($running_year == "")
            $running_year = $this->globalSettingsRunningYear;
        $parents = $this->Parent_model->get_datatables_parent_misc_report($class_id,$running_year);
        $list = $parents;
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $all_parents) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $all_parents->enroll_code;
            $row[] = "Mr. " . $all_parents->father_name . " " . $all_parents->father_mname . " " . $all_parents->father_lname;
            $row[] = $all_parents->father_profession;
            $row[] = $all_parents->cell_phone;
            $row[] = $all_parents->parent_email;
            $row[] = ($all_parents->isActive == 1) ? 'Active' : 'Deleted';
            $row[] = '<div class="btn-group">
                        <button type="button" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light">
                        ' . get_phrase('View_Details ') . ' <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-default pull-right pos-static" role="menu">
                        <li>
                        <a  href="#" onclick="showAjaxModal(\'' . base_url() . 'index.php?modal/popup/modal_parent_view/ ' . $all_parents->parent_id . '\');" >
                        <i class="fa fa-area-chart"></i>
                        ' . get_phrase('view') . '</a>
                        </li>
                        <li>
                        <a href="' . base_url() . 'index.php?school_admin/regenerate_passcode_parent/' . $all_parents->parent_id . '">
                        <i class="fa fa-folder-open-o"></i>
                        ' . get_phrase('regenerate_passcode') . '</a>
                        </li>
                        </ul>
                        </div>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Parent_model->count_all_parent_misc_report($class_id, $running_year),
            "recordsFiltered" => $this->Parent_model->count_filtered_parent_misc_report($class_id, $running_year),
            "data" => $data,
        );
        //echo '<pre>'; print_r($output); exit;
        echo json_encode($output);
    }
    public function parent_misc_report_section($class_id=0,$running_year="",$section_id) {
        $this->load->model("Parent_model");
        $class_array = array('class_id' => $class_id);
        $this->load->model("Class_model");
        if ($running_year == "")
            $running_year = $this->globalSettingsRunningYear;
            $parentss      = $this->Parent_model->get_datatables_parent_misc_report_sections($class_id,$running_year,$section_id);        
        $list = $parentss;
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $all_parents) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $all_parents->enroll_code;
            $row[] = "Mr. " . $all_parents->father_name . " " . $all_parents->father_mname . " " . $all_parents->father_lname;
            $row[] = $all_parents->father_profession;
            $row[] = $all_parents->cell_phone;
            $row[] = $all_parents->parent_email;
            $row[] = ($all_parents->isActive == 1) ? 'Active' : 'Deleted';
            $row[] = '<div class="btn-group">
                        <button type="button" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light">
                        ' . get_phrase('View_Details ') . ' <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-default pull-right pos-static" role="menu">
                        <li>
                        <a  href="javascript: void(0);" onclick="showAjaxModal(\'' . base_url() . 'index.php?modal/popup/modal_parent_view/ ' . $all_parents->parent_id . '\');" >
                        <i class="fa fa-area-chart"></i>
                        ' . get_phrase('view') . '</a>
                        </li>
                        <li>
                        <a href="' . base_url() . 'index.php?school_admin/regenerate_passcode_parent/' . $all_parents->parent_id . '">
                        <i class="fa fa-folder-open-o"></i>
                        ' . get_phrase('regenerate_passcode') . '</a>
                        </li>
                        </ul>
                        </div>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Parent_model->count_all_parent_misc_report_sections($class_id, $running_year,$section_id),
            "recordsFiltered" => $this->Parent_model->count_filtered_parent_misc_report_sections($class_id, $running_year,$section_id),
            "data" => $data,
        );
        //echo '<pre>'; print_r($output); exit;
        echo json_encode($output);
    }
    
    /*
     * Check class fee set or not for promotion,student fee set page
     * @param $class_id
     */
    function check_fee_set_forclass($class_id) {
        $this->load->library('Fi_functions');
        $tution_fee_det             =   $this->fi_functions->get_fee_detailsbygroup($class_id); 
        if($tution_fee_det) {
            $tution_fee_id      =   $tution_fee_det['id'];
            $response_array     =   array('status'=>"success",'message'=>'','class_fee'=>$tution_fee_det['sales_price']);
        } else {
            $link_to_set_fee    =   '<a href="'.base_url('fi/?ng=ps/p-new/').'" target="_blank">Set School Fee</a>';
            $response_array     =   array('status'=>"failed",'message'=>'No fee set for this class click here to '.$link_to_set_fee);
        }
        print_r(json_encode($response_array));
    }

    function student_information_ajax_list_all($class_id = ''){
        $this->load->model("Class_model");
        $this->load->model("Student_model");
        $this->load->model("Crud_model");
        if($class_id == ""){
           $class_id    =   $this->Class_model->get_first_class_id(); 
        }
        $class_array    =   array('class_id' => $class_id);
        $running_year   =   $this->globalSettingsRunningYear;
        $students       =   array(); 
        $students       =   $this->Student_model->get_datatables_student_information_all_class($class_id,$running_year);
        foreach($students as $key=>$row){
            $students[$key]->transaction = $this->Crud_model->getStudentTransaction($row->student_id);
        }
        $list = $students;
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $all_students) {
            $transaction = $all_students->transaction;
            $no++;
            $row = array();
            $row[] = $no;
//            $row[] = $all_students->roll;
            $row[] = ucwords($all_students->name ." ". ($all_students->mname!=''?$all_students->mname:'') ." ". $all_students->lname);
            $row[] = ucwords($all_students->father_name ." ". ($all_students->father_mname!=''?$all_students->father_mname:'') ." ". $all_students->father_lname);
            $row[] = ucwords($all_students->mother_name ." ". ($all_students->mother_mname!=''?$all_students->mother_mname:'') ." ". $all_students->mother_lname);
            $row[] = ucfirst($all_students->sex);
            $row[] = $all_students->emergency_contact_number;
            $row[] = $all_students->desease_title;
            $row[] = $all_students->media_consent;
            $row[] = ($all_students->student_status == 1) ? 'Enabled' : 'Disabled';
            $rows =    '<div class="btn-group">
                        <button type="button" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light">
                        '.get_phrase('View_Details ').'<span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-default pull-right pos-static" role="menu">
                        <li>
                        <a href="'.base_url().'index.php?school_admin/average/'.$all_students->student_id.'">
                        <i class="fa fa-bar-chart"></i>
                        '.get_phrase('academic_average').
                        '</a></li>
                        <li>
                        <a href="'.base_url().'index.php?school_admin/student_marksheet/'.$all_students->student_id.'">
                        <i class="fa fa-area-chart"></i>
                        '.get_phrase('mark_sheet').
                        '</a></li>
                        <li>
                        <a href="'. base_url().'index.php?school_admin/documents/'.$all_students->student_id.'">
                        <i class="fa fa-folder-open-o"></i>
                        '.get_phrase('documents').
                        '</a></li>  
                        <li>
                        <a href="javascript: void(0);" onclick="confirm_modal(\''.base_url().'index.php?school_admin/student/delete/'.$all_students->student_id.'/'. $all_students->class_id.'\')">
                        <i class="fa fa-trash"></i> Delete</a></li>
                        </ul>
                        </div>';
            $row1  =   '<a href="'.base_url().'index.php?school_admin/student_profile/'.$all_students->student_id.'">
                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View Profile"><i class="fa fa-eye"></i></button>
                        </a>
                        <a onclick="showAjaxModal(\''.base_url().'index.php?modal/modal_student_edit/'.$all_students->student_id .'\')">
                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit Profile"><i class="fa fa-pencil-square-o"></i></button>
                        </a>';
            if($transaction){
                $row2 = "-";
            }
            else{
                $status = ($all_students->student_status == 1) ? 'Disable' : 'Enable';
            $row2 =   '<a onclick="ConfirmStudentToggleEnable(\'' . base_url().'index.php?school_admin/student/ToggleEnable/'. $all_students->student_id.'/'.$all_students->student_status. '\')"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="'.$status.'"><i class="fa fa-ban"></i></button></a>';
            }
            $row[]  =   $rows;
            $row[]  =   $row1.$row2;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Student_model->count_all_parent_student_information_all_class($class_id, $running_year),
            "recordsFiltered" => $this->Student_model->count_filtered_student_information_all_class($class_id, $running_year),
            "data" => $data,
        );
        //echo '<pre>'; print_r($output); exit;
        echo json_encode($output);
    }
        function student_information_ajax_list_section($class_id = '',$section_id = ''){
        $this->load->model("Class_model");
        $this->load->model("Student_model");
        $this->load->model("Crud_model");
        if($class_id == ""){
           $class_id    =   $this->Class_model->get_first_class_id(); 
        }
        $class_array    =   array('class_id' => $class_id);
        $running_year   =   $this->globalSettingsRunningYear;
        $selected_section_student = $this->Student_model->get_datatables_student_information_section($class_id,$section_id,$running_year);
        foreach($selected_section_student as $key=>$row){
            $selected_section_student[$key]->transaction = $this->Crud_model->getStudentTransaction($row->student_id);
        }
        $list = $selected_section_student;
        $data = array();
        $no = $_POST['start'];
//        pre($list); die;
        foreach ($list as $all_students) {
            $transaction = $all_students->transaction;
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $all_students->roll;
            $row[] = ucwords($all_students->name ." ". ($all_students->mname!=''?$all_students->mname:'') ." ". $all_students->lname);
            $row[] = ucwords($all_students->father_name ." ". ($all_students->father_mname!=''?$all_students->father_mname:'') ." ". $all_students->father_lname);
            $row[] = ucwords($all_students->mother_name ." ". ($all_students->mother_mname!=''?$all_students->mother_mname:'') ." ". $all_students->mother_lname);
            $row[] = ucfirst($all_students->sex);
            $row[] = $all_students->emergency_contact_number;
            $row[] = $all_students->desease_title;
            $row[] = $all_students->media_consent;
            $row[] = ($all_students->student_status == 1) ? 'Enabled' : 'Disabled';
            $rows =    '<div class="btn-group">
                        <button type="button" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light">
                        '.get_phrase('View_Details ').'<span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-default pull-right pos-static" role="menu">
                        <li>
                        <a href="'.base_url().'index.php?school_admin/average/'.$all_students->student_id.'">
                        <i class="fa fa-bar-chart"></i>
                        '.get_phrase('academic_average').
                        '</a></li>
                        <li>
                        <a href="'.base_url().'index.php?school_admin/student_marksheet/'.$all_students->student_id.'">
                        <i class="fa fa-area-chart"></i>
                        '.get_phrase('mark_sheet').
                        '</a></li>
                        <li>
                        <a href="'. base_url().'index.php?school_admin/documents/'.$all_students->student_id.'">
                        <i class="fa fa-folder-open-o"></i>
                        '.get_phrase('documents').
                        '</a></li>  
                        <li>
                        <a href="javascript: void(0);" onclick="confirm_modal(\''.base_url().'index.php?school_admin/student/delete/'.$all_students->student_id.'/'. $all_students->class_id.'\')">
                        <i class="fa fa-trash"></i> Delete</a></li>
                        </ul>
                        </div>';
            $row1  =   '<a href="'.base_url().'index.php?school_admin/student_profile/'.$all_students->student_id.'">
                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View Profile"><i class="fa fa-eye"></i></button>
                        </a>
                        <a onclick="showAjaxModal(\''.base_url().'index.php?modal/modal_student_edit/'.$all_students->student_id .'\')">
                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit Profile"><i class="fa fa-pencil-square-o"></i></button>
                        </a>';
            if($transaction){
                $row2 = "-";
            }
            else{
            $row2 =   '<a onclick="confirm_modal(\''.base_url().'index.php?school_admin/student/delete/'.$all_students->student_id.'/'. $all_students->class_id.'\')">
                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete Profile"><i class="fa fa-trash-o"></i></button>
                        </a>';

                        $status = ($all_students->student_status == 1) ? 'Disable' : 'Enable';
            $row2 =   '<a onclick="ConfirmStudentToggleEnable(\'' . base_url().'index.php?school_admin/student/ToggleEnable/'. $all_students->student_id.'/'.$all_students->student_status. '\')"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="'.$status.'"><i class="fa fa-ban"></i></button></a>';
            }
            $row[]  =   $rows;
            $row[]  =   $row1.$row2;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Student_model->count_all_parent_student_information_section($class_id,$section_id,$running_year),
            "recordsFiltered" => $this->Student_model->count_filtered_student_information_section($class_id,$section_id,$running_year),
            "data" => $data,
        );
        //echo '<pre>'; print_r($output); exit;
        echo json_encode($output);
    }

    function map_students_id_all_students($class_id = ''){
        $this->load->model("Class_model");
        $this->load->model("Student_model");
        if($class_id == ""){
           $class_id    =   $this->Class_model->get_first_class_id(); 
        }
        $class_array    =   array('class_id' => $class_id);
        $running_year   =   $this->globalSettingsRunningYear;
        $students       =   array(); 
        $students       =   $this->Student_model->get_datatables_student_information_all_class($class_id,$running_year);
        $list = $students;
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $all_students) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $all_students->enroll_code;
            $row[] = ucwords($all_students->name ." ". ($all_students->mname!=''?$all_students->mname:'') ." ". $all_students->lname);
            $row[] = $all_students->card_id;           
            $row[] = $all_students->year; 
            $row[] =    '<a href="javascript: void(0);" onclick="showAjaxModal(\''. base_url().'index.php?modal/modifie_rfid/'.$all_students->student_id.'/'.$class_id. '\')">
                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View ID"><i class="fa fa-id-card-o"></i></button>
                        </a>';
           
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Student_model->count_all_parent_student_information_all_class($class_id, $running_year),
            "recordsFiltered" => $this->Student_model->count_filtered_student_information_all_class($class_id, $running_year),
            "data" => $data,
        );
        //echo '<pre>'; print_r($output); exit;
        echo json_encode($output);
    }
        function map_students_id_section($class_id = '',$section_id = ''){
        $this->load->model("Class_model");
        $this->load->model("Student_model");
        if($class_id == ""){
           $class_id    =   $this->Class_model->get_first_class_id(); 
        }
        $running_year   =   $this->globalSettingsRunningYear;
        $selected_section_student = $this->Student_model->get_datatables_student_information_section($class_id,$section_id,$running_year);
        $list = $selected_section_student;
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $all_students) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $all_students->enroll_code;
            $row[] = ucwords($all_students->name ." ". ($all_students->mname!=''?$all_students->mname:'') ." ". $all_students->lname);
            $row[] = $all_students->year; 
            $row[] =    '<a href="javascript: void(0);" onclick="showAjaxModal(\''. base_url().'index.php?modal/modifie_rfid/'.$all_students->student_id.'/'.$class_id. '\')">
                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View ID"><i class="fa fa-id-card-o"></i></button>
                        </a>';
           
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Student_model->count_all_parent_student_information_section($class_id,$section_id,$running_year),
            "recordsFiltered" => $this->Student_model->count_filtered_student_information_section($class_id,$section_id,$running_year),
            "data" => $data,
        );
        //echo '<pre>'; print_r($output); exit;
        echo json_encode($output);
    }
        function student_information_ajax_list_all_teacher_login($class_id = ''){
        $this->load->model("Class_model");
        $this->load->model("Student_model");
        $this->load->model("Crud_model");
        if($class_id == ""){
           $class_id    =   $this->Class_model->get_first_class_id($this->session->userdata('teacher_id')); 
        }
        $class_array    =   array('class_id' => $class_id);
        $running_year   =   $this->globalSettingsRunningYear;
        $students       =   array(); 
        $students       =   $this->Student_model->get_datatables_student_information_all_class($class_id,$running_year);
        $list = $students;
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $all_students) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $all_students->roll;
            $row[] = ucwords($all_students->name." ".$all_students->lname);
            $row[] = ucwords($all_students->father_name.' '.$all_students->father_lname);
            $row[] = ucwords($all_students->mother_name.' '.$all_students->mother_lname);
            $row[] = ucwords($all_students->sex);
            $row[] = $all_students->birthday;
            $row[] = ($all_students->student_status == 1) ? 'Enabled' : 'Disabled';
            $row[] =    '<a href="'.base_url().'index.php?teacher/student_marksheet/'.$all_students->student_id.'">
                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View Marksheet" title="View Marksheet"><i class="fa fa-bar-chart"></i></button>
                        </a>
                        <a href="'. base_url().'index.php?teacher/student_profile/'. $all_students->student_id.'">
                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View Profile"><i class="fa fa-eye"></i></button>
                        </a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Student_model->count_all_parent_student_information_all_class($class_id, $running_year),
            "recordsFiltered" => $this->Student_model->count_filtered_student_information_all_class($class_id, $running_year),
            "data" => $data,
        );
        //echo '<pre>'; print_r($output); exit;
        echo json_encode($output);
    }
        function student_information_ajax_list_section_teacher_login($class_id = '',$section_id = ''){
        $this->load->model("Class_model");
        $this->load->model("Student_model");
        $this->load->model("Crud_model");
        if($class_id == ""){
           $class_id    =   $this->Class_model->get_first_class_id(); 
        }
        $class_array    =   array('class_id' => $class_id);
        $running_year   =   $this->globalSettingsRunningYear;
        $selected_section_student = $this->Student_model->get_datatables_student_information_section($class_id,$section_id,$running_year);
        foreach($selected_section_student as $key=>$row){
            $selected_section_student[$key]->transaction = $this->Crud_model->getStudentTransaction($row->student_id);
        }
        $list = $selected_section_student;
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $all_students) {
            $transaction = $all_students->transaction;
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $all_students->roll;
            $row[] = ucwords($all_students->name." ".$all_students->lname);
            $row[] = ucwords($all_students->father_name.' '.$all_students->father_lname);
            $row[] = ucwords($all_students->mother_name.' '.$all_students->mother_lname);
            $row[] = ucwords($all_students->sex);
            $row[] = $all_students->birthday;
            $row[] = ($all_students->student_status == 1) ? 'Enabled' : 'Disabled';
            $row[] =    '<a href="'. base_url().'index.php?teacher/student_profile/'.$all_students->student_id.'">
                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View Profile"><i class="fa fa-eye"></i></button>
                        </a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Student_model->count_all_parent_student_information_section($class_id,$section_id,$running_year),
            "recordsFiltered" => $this->Student_model->count_filtered_student_information_section($class_id,$section_id,$running_year),
            "data" => $data,
        );
        //echo '<pre>'; print_r($output); exit;
        echo json_encode($output);
    }
    function all_teachers_parent_login(){
    $this->load->model('Teacher_model','teachers');
    $list = $this->teachers->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $teachers) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<img src="'.$this->crud_model->get_image_url('teacher', $teachers->teacher_id).'" class="img-circle" width="30" />';
            $row[] = $teachers->name ." ". ($teachers->middle_name!=''?$teachers->middle_name:'') ." ". $teachers->last_name;
            $row[] = $teachers->email;
            $data[] = $row;
        }

        
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->teachers->count_all(),
                        "recordsFiltered" => $this->teachers->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
    function student_overview_admin_login(){
        $this->load->model('Enquired_students_model');
        $this->load->model('Invoice_model');
        $page_data['enquired_students'] = $this->Enquired_students_model->get_datatables_student_overview();
        if(count($page_data['enquired_students'])){
            foreach($page_data['enquired_students'] as $k=> $enquired):
                if(!empty($enquired->student_id)){
                    $amountArr = $this->Invoice_model->get_student_invoice_details($enquired->student_id);

                    if(empty($amountArr)){
                        $page_data['enquired_students'][$k]->amount = 0;
                        $page_data['enquired_students'][$k]->amount_paid = 0;
                        $page_data['enquired_students'][$k]->diff_amount = 0;

                    }else{
                        $page_data['enquired_students'][$k]->amount = $amountArr->amount;
                        $page_data['enquired_students'][$k]->amount_paid = $amountArr->amount_paid;
                        $page_data['enquired_students'][$k]->diff_amount = ($amountArr->amount - $amountArr->amount_paid);
                    }
                }
            endforeach;
        }
        $list = $page_data['enquired_students'];
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $enquired) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = ucfirst($enquired->student_fname)." ".ucfirst($enquired->student_lname);
            $row[] = @$enquired->amount;
            $row[] = @$enquired->amount_paid;
            $row[] = @$enquired->diff_amount;
            $data[] = $row;
        }
//        pre($data);exit;
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Enquired_students_model->count_all_student_overview(),
                        "recordsFiltered" => $this->Enquired_students_model->count_filtered_student_overview(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
    function manage_device_admin_login(){
    $this->load->model('Device_model');
    $list = $this->Device_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $device) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $device->Device_ID;
            $row[] = $device->Name;
            $row[] = $device->SIM;
            $row[] = $device->Imei;
            $row[] = $device->Location;
            $row[] = '<a href="javascript: void(0);" onclick="showAjaxModal(\''. base_url().'index.php?modal/popup/modal_device_edit/'. $device->Device_ID.'\')">
                    <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="'. get_phrase('edit').'" title="'. get_phrase('edit').'">  
                    <i class="fa fa-pencil-square-o"></i>
                    </button>
                    </a>
                    <a href="javascript: void(0);" onclick="confirm_modal(\''.base_url().'index.php?school_admin/device/delete/'.$device->Device_ID.'\')">
                    <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                    data-placement="top" data-original-title="'. get_phrase('delete').'" title="'.get_phrase('delete').'">
                        <i class="fa fa-trash-o"></i>
                    </button>
                    </a>';
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Device_model->count_all(),
                        "recordsFiltered" => $this->Device_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
    
    //progress Report List 
     function progress_report_list(){
         $class_id = $this->input->post('class_id');
         $section_id = $this->input->post('section');
         $subject_id = $this->input->post('subject');
//         echo $class_id."dsf".$section_id."fdg".$subject_id; die;
         $this->load->model('Progress_model');
        $list = $this->Progress_model->get_datatables($class_id,$section_id,$subject_id);
//        pre($list); die;        
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $progress_report) {  
            $rateStr = '';            
            $no++;
            
            for($i=0;$i<5;$i++){ 
                $rateStr.='<img onclick="javascript:rating('.$i.',\''.$progress_report->student_id.'student\')" name="'.$progress_report->student_id.'student-'.$i.'" src=" '.base_url() . 'assets/images/Blank_star.png" alt="star View" >';
            }
            $row = array();
            $row[] = $no.'<input type="hidden" class="form-control" id="rate-'.$progress_report->student_id.'student" name="rate-student'.$progress_report->student_id.'" value="5"/><input type="hidden" class="form-control" id="changed'.$progress_report->student_id.'student" name="changedstudent'.$progress_report->student_id.'" value="0"/>';
            $row[] = '<img src="'.$progress_report->stud_image.'" class="profile-picture" width="30" />';
            $row[] = ucfirst($progress_report->name);
            $row[] = $rateStr;
            $row[] = '<textarea  class="form-control" id="comment-'.$progress_report->student_id.'" name="comment-'.$progress_report->student_id.'" rows="1" cols="30"></textarea>';
            $row[] = '<a href="javascript:void(0);" onclick="showAjaxModal(\''.base_url().'index.php?modal/get_progress_report_subject_wise/'.$progress_report->student_id.'/'.$subject_id.'/'.$section_id.'\');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View History"><i class="fa fa-eye"></i></button></a>';
           $data[] = $row;
        }
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Progress_model->count_all($class_id,$section_id,$subject_id),
                        "recordsFiltered" => $this->Progress_model->count_filtered($class_id,$section_id,$subject_id),
                        "data" => $data,
                );
        //echo '<pre>'; print_r($output); exit;
        echo json_encode($output);
    }
    
    //Manage Assignment View
    function manage_assignment_list(){   
        $this->load->model('Student_model');
        $this->load->model('Setting_model');
          $class_id = $this->input->post('class_id');
         $section_id = $this->input->post('section_id');
         $subject_id = $this->input->post('subject_id');
         $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');    
    $list = $this->Student_model->get_datatables_student_Assignment($class_id,$section_id,$running_year);
//    pre($list); die;
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $assignment) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $assignment->enroll_code;
            $row[] = $assignment->name." ".$assignment->lname;
            $row[] = '<input type="checkbox" id="allChecked" name="allot_assigment[]" value="'.$assignment->student_id.'">';
          
            $data[] = $row;
        }
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Student_model->count_all_student_assignment($class_id,$section_id,$running_year),
                        "recordsFiltered" => $this->Student_model->count_filtered_student_assignment($class_id,$section_id,$running_year),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
//SET PTM TIME LIST 

   function set_ptm_time_list(){
           $this->load->model('Parent_teacher_meeting_date_model');
        $this->load->model('Setting_model');
          $class_id = $this->input->post('class_id');
         $section_id = $this->input->post('section_id');
         $exam_id = $this->input->post('exam_id');
         $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');    
    $list = $this->Parent_teacher_meeting_date_model->get_datatables($class_id,$section_id,$running_year);
//    pre($list); die;  
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $row) {
            if($row->parrent_accepted == '1'){
              $ptm_time = '<input type="text" id="std_id'.$row->stud_id.'" placeholder="'.$row->time.'" onclick="triggerTimePicker();" class="clockpicker" name="ptm_time" value ="'.$row->time.'">';
              $button = '<button id="save_time'.$row->stud_id.'" onclick="save_time('.$row->stud_id.',10);" type="submit" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" rel="tooltip" data-toggle="tooltip" data-placement="top" data-original-title="Update" title="Update"><i class="fa fa-pencil-square-o"></i></button>';
              $prnt_accptd = '<span id = "status'.$row->stud_id.'" class="par-accepted" value=""></span><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" rel="tooltip" data-toggle="tooltip" data-placement="top" data-original-title="Disable"  title="Sent to Parent"><i class="fa fa-envelope-open-o"></i></button>';
                      } else {
              $ptm_time = '<input type="text" id="std_id'.$row->stud_id.'" class="clockpicker" placeholder="'.$row->time.'" name="ptm_time" onclick="triggerTimePicker();" value ="'.$row->time.'">';
              $button = '<button id="save_time'.$row->stud_id.'" onclick="save_time('.$row->stud_id.');" type="submit" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" rel="tooltip" data-toggle="tooltip" data-placement="top" data-original-title="Save" title="Save"><i class="fa fa-save"></i></button>';
              $prnt_accptd = '<button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" rel="tooltip" data-toggle="tooltip" data-placement="top" data-original-title="Enable"  title="Not sent"><i class="fa fa-envelope-o"></i></button>';    
                    }
            $no++;
            $row1 = array();
            $row1[] = $no;
            $row1[] = ucwords($row->student_name);
            $row1[] = ucwords($row->class_name." : ".$row->section_name).'<input type="hidden" value="'.$exam_id.'" id= "exam_id" name ="exam_id">';
            $row1[] = $ptm_time;
            $row1[] = $button;
            $row1[] = $prnt_accptd;
          
            $data[] = $row1;
        }
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Parent_teacher_meeting_date_model->count_all($class_id,$section_id,$running_year),
                        "recordsFiltered" => $this->Parent_teacher_meeting_date_model->count_filtered($class_id,$section_id,$running_year),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
   }
   
   function run_fee_reminder() {
       $this->load->library('Fi_functions');
       $this->fi_functions->run_fee_reminder();
   }

   //MARKS MANAGE LIST
//     $page_data['marks_of_students'] = $this->Exam_model->get_marks_of_students($exam_id, $class_id, $section_id, $subject_id, $running_year);
    function marks_manage_list_teacher_login(){
         $this->load->model('Exam_model');
          $this->load->model('Setting_model');
         $class_id = $this->input->post('class_id');
         $section_id = $this->input->post('section_id');
         $exam_id = $this->input->post('exam_id');
         $subject_id = $this->input->post('subject_id');
//         echo "class_id=".$class_id;
//         echo "section_id".$section_id;
//         echo "exam_id".$exam_id;
//         echo "subject".$subject_id;
//         echo "year".$running_year;die;
         $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');    
        $list = $this->Exam_model->get_datatables($exam_id,$class_id,$section_id,$subject_id,$running_year);
//    pre($list); die;  
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $manage_marks) {
          
            $no++;
            $row1 = array();
            $row1[] = $no;
            $row1[] = $manage_marks->roll;
            $row1[] = ucfirst($manage_marks->name);
            $row1[] = '<input type="text" class="form-control" name="marks_obtained_'.$manage_marks->mark_id.'" value="'.$manage_marks->mark_obtained.'">';
            $row1[] = '<input type="text" class="form-control" name="comment_'.$manage_marks->mark_id.'" value="'.$manage_marks->comment.'">';
                    
            $data[] = $row1;
        }
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Exam_model->count_all($exam_id,$class_id,$section_id,$subject_id,$running_year),
                        "recordsFiltered" => $this->Exam_model->count_filtered($exam_id,$class_id,$section_id,$subject_id,$running_year),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);

    }
    function mess_details_admin_login(){
    $this->load->model('Mess_management_model');
    $list = $this->Mess_management_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $details) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $details->name;
            $row[] = $details->description;
            $row[] = $details->amount;
            $data[] = $row;
        }
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Mess_management_model->count_all(),
                        "recordsFiltered" => $this->Mess_management_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
    
    /*
     * Fee Penalty calculation
     * 
     */
     function runFeePenalty() {
        $this->load->library('Fi_functions');
        $academic_year      =   $this->globalSettingsRunningYear;
        $this->fi_functions->run_fee_penalty();
            
    }


    function get_state(){
        $CountryId= $_POST['CountryId'];
        if($CountryId){
            $where = array('location_type' => 1, 'parent_id' => $CountryId);
            $State_list = get_data_generic_fun('country', '*', $where, 'result_array', array('name'=>'asc'));
            if(count($State_list)){
                echo json_encode($State_list);
            }
        }
    }


   function get_class_by_exams(){
       $exam_id= $this->input->post('exam_id');
        $this->load->model('Exam_model');
        $this->load->model('Cce_model');
        $this->load->model('Subject_model');
        $rs= $this->Exam_model->get_data_by_cols('*',array('exam_id'=>$exam_id));
        //pre($rs);die;
        $this->load->model('Evaluation_model');
        $rsEvaluation= $this->Evaluation_model->get_data_by_cols();
        foreach ($rsEvaluation AS $k){
            $grading_table[$k->evaluation_id]= strtolower($k->name);
        }
        //pre($grading_table);die;
        $grading_table=$grading_table[$rs[0]->grading]."_subjects";
        //$grading_class=$grading_table[$rs[0]->grading]."_classes";
        
        $classArr= $this->Cce_model->get_class_by_evaluation_id($rs[0]->grading);
        //$subjectArr= $this->Subject_model->get_grading_subject($grading_table); //$this->db->from($grading_table)->where('no_exam',0)->result_array();
        
        $classOptionStr='<option value=" ">' . "Select Class" . '</option>';
        foreach ($classArr As $k){
            $classOptionStr.='<option value="'.$k["class_id"].'">'.$k['name'].'</option>';
        }
        
        /*$subjectOptionStr='';
        foreach ($subjectArr As $k){
            $subjectOptionStr.='<option value="'.$k["subject_id"].'">'.$k['name'].'</option>';
        }*/
       //$classOptionStr='<option value="1">Class 1</option><option value="2">Class 2</option>';
       //$subjectOptionStr='<option value="1">Math</option><option value="2">Science</option>';
       //$dataArr=array('classOption'=>$classOptionStr,'subjectOption'=>$subjectOptionStr);
       $dataArr=array('classOption'=>$classOptionStr);
        echo json_encode($dataArr);die;
   }
   
   function get_section_subject_by_class(){
        $class_id=$this->input->post('class_id',TRUE);
        $this->load->model("Section_model");
        $sections = $this->Section_model->get_data_generic_fun('*',array('class_id'=>$class_id),'result_arr');
        $sectionOptionStr='<option value=" ">' . "Select Section" . '</option>';
        foreach ($sections as $row) {
            $sectionOptionStr.= '<option value="' . $row['section_id'] . '">' . $row['name'] . '</option>';
        }
        $this->load->model('Subject_model');
        $subjectArr = $this->Subject_model->get_data_by_cols('*',array('class_id'=>$class_id),'result_arr');
        $subjectOptionStr='<option value=" ">' . "Select Subject" . '</option>';
        foreach ($subjectArr As $k){
            $subjectOptionStr.='<option value="'.$k["subject_id"].'">'.$k['name'].'</option>';
        }
        $dataArr=array('sectionOption'=>$sectionOptionStr,'subjectOption'=>$subjectOptionStr);
        echo json_encode($dataArr);die;
   }
   
   function get_marks_manage_list_ibo(){
    $this->load->model('Setting_model');
    $this->load->model('Exam_model');
       $exam_id                               =     $this->input->post('exam_id');
       $class_id                                =     $this->input->post('class_id');
       $section_id                               =     $this->input->post('section_id');
       $subject_id                               =     $this->input->post('subject_id');
       $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
    $list = $this->Exam_model->get_datatables_ibo($exam_id,$class_id,$section_id,$subject_id,$running_year);
    
    $subjAssessData = $this->db->select()->from('ibo_subject_assessments')->where(array('class_id'=>$class_id,'subject_id'=>$subject_id))->get()->result_array();
    $row_count = count($subjAssessData);
   
        $data = array();
        $no = $_POST['start'];
        $count_row = count($list);
        
        foreach ($list as $mark_manage) {              
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $mark_manage->roll;
            $row[] = ucwords($mark_manage->name.' '.$mark_manage->lname);
            foreach($subjAssessData as $key=>$assess) { 
                //pre($assess);
                $assessMarksData = $this->db->select('*')->from('ibo_marks')->join('student', 'ibo_marks.student_uid = student.student_id')->where(array('exam_id'=>$exam_id,'class_id'=>$class_id,'section_id'=>$section_id,'subject_id'=>$subject_id,'student_uid'=>$mark_manage->student_id,'assessment_id'=>$assess['assessment_id']))->get()->result_array();
                /*echo $this->db->last_query();
                pre($assessMarksData);
                echo '<br/>'.$assessMarksData[0]['mark_obtained'];*/
                if(isset($assessMarksData[0]['mark_obtained']) && $assessMarksData[0]['mark_obtained'] > 0) { 
                        $marks = $assessMarksData[0]['mark_obtained'];
                    } else { $marks = 0; }
                    $row[] = '<input type="text" class="form-control" name="marks_obtained_'.($no-1).'[]" value="'.$marks.'"><input type="hidden" class="form-control" name="assessment_id_'.($no-1).'[]" value="'.$assess['assessment_id'].'"><input type="hidden" class="form-control" name="student_id_'.($no-1).'[]" value="'.$mark_manage->student_id.'">';
            }
            $row[] = '<input type="text" class="form-control" name="comment_'.($no-1).'" value="'.$mark_manage->comment.'">';
                          
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" =>$count_row,
                        "recordsFiltered" => $this->Exam_model->count_filtered($exam_id,$class_id,$section_id,$subject_id,$running_year),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    
   function download_mark_bulk_upload_template($exam_id,$class_id,$section_id="",$subject_id=""){
        $this->load->model("Class_model");
        //$classArr = $this->Class_model->get_data_generic_fun('*',array('class_id'=>$class_id),'result_arr');
        $classArr = $this->db->get_where('class',array('class_id'=>$class_id))->result_array();
        generate_log($this->db->last_query(),"marksheet_bulk_upload_".date('d_m_Y').'.log');
        $this->load->model("Section_model");
        //$sectionsArr = $this->Section_model->get_data_generic_fun('*',array('class_id'=>$class_id),'result_arr');
        $sectionsArr = $this->db->get_where('section',array('class_id'=>$class_id))->result_array();
        generate_log($this->db->last_query(),"marksheet_bulk_upload_".date('d_m_Y').'.log');
        $this->load->model('Subject_model');
        $this->load->model('Enroll_model');
        
        //$subjectArr = $this->Subject_model->get_data_by_cols('*',array('class_id'=>$class_id),'result_arr');
        $subjectArr = $this->db->get_where('subject',array('class_id'=>$class_id))->result_array();
        generate_log($this->db->last_query(),"marksheet_bulk_upload_".date('d_m_Y').'.log');
        //pre($subjectArr);
        $this->load->helper('download');
        $file_name='Marks_Upload_Template_For_'.$exam_id.'_'.$class_id.'.xlsx';
        //pre($file_name);
        //$sheet_name='Marks_Upload_Template_For'.$exam_id.'_'.$class_id;
        $headerArr=$header=array('StudentName-roll_no=>'.$exam_id);
        $header1Arr=array('Maximum-Mark-For-Subjects');
        foreach ($subjectArr AS $k){
            $headerArr[]=$k['name'].'=>'.$k['subject_id'];
            $headerArr[]=$k['name']."-comment";
        }
        $data=array();
        
        foreach($sectionsArr AS $k){ //pre($k);
            $dataSheet=array();
            $dataSheet[]=$headerArr;
            $dataSheet[]=$header1Arr;
            //$allStudentDataBySection=$this->Enroll_model->get_all_enroll_student_by_section($k['section_id'], $this->globalSettingsRunningYear);
            $sql="SELECT s.name AS StudentName,s.student_id,e.section_id,se.name AS SectionName,c.name AS ClassName "
                . " FROM enroll AS e,student AS s,section AS se,class AS c "
                . " WHERE e.student_id=s.student_id AND e.section_id=se.section_id AND  e.class_id=c.class_id AND s.student_status='1' AND "
                . " e.year='".$this->globalSettingsRunningYear."' AND e.section_id='".$k['section_id']."' ORDER BY se.section_id ASC";
            $allStudentDataBySection=$this->db->query($sql)->result();
            generate_log($sql,"marksheet_bulk_upload_".date('d_m_Y').'.log');
            if(!empty($allStudentDataBySection)){
                //pre($allStudentDataBySection);
                foreach($allStudentDataBySection AS $j){ ///pre($j);
                    $dataSheet[]=array($j->StudentName."=>".$j->student_id);
                }
                //pre($dataSheet);die;
                $classSectionName=$j->ClassName.'-'.$j->SectionName.'=>'.$j->section_id;
                //pre($classSectionName);die;
                $data[]=array($classSectionName=>$dataSheet);
            }
        }
        //pre($data);die;
        
        $file_name_with_path="uploads/".$file_name;
        @unlink($file_name_with_path);
        //pre($file_name_with_path);
        create_excel_file_multiple_sheet($file_name_with_path, $data);
        //die;
        $contentData = file_get_contents($file_name_with_path);
        $name = $file_name;
        force_download($name, $contentData);
   }


    function login_history(){
        $this->load->model("Admin_model");
        $list = $this->Admin_model->get_login_history_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $datum) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $datum->user_name;
            $row[] = date('d/m/Y h:i A', strtotime($datum->login_at));
            $row[] = ($datum->logout_at!='') ? date('d/m/Y h:i A', strtotime($datum->logout_at)) : '<span class="mandatory">(not set)</span>';
            $row[] = $datum->ip_address;

            if($datum->login_history_status=='1'){
                $button_show = '<a href="javascript: void(0);"><button type="button" class="btn btn-default btn-circle btn-lg m-r-5 tooltip-danger success" data-toggle="tooltip" data-placement="top" data-original-title="'.get_phrase('login').'" title="'. get_phrase('login').'"><i class="fa fa-sign-in"></i></button></a>';
            }else{
                $button_show =  '<a href="javascript: void(0);"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="'.get_phrase('logout').'" title="'. get_phrase('logout').'"><i class="fa fa-sign-out mandatory"></i></button></a>';
            }

            $row[] = $button_show;
            
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Admin_model->count_all_login_history(),
                        "recordsFiltered" => $this->Admin_model->count_filtered_login_history(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
    
    public function poll_parent() {
        $poll_id            =   $this->input->post('poll_id');
        $answer_id          =   $this->input->post('answer_id');
        $parent_id          =   $this->session->userdata('parent_id');
        
        $this->load->model("Onlinepoll_model");
        $poll_parent        =   $this->Onlinepoll_model->poll_by_parent($poll_id,$answer_id,$parent_id);
        if($poll_parent) {
            $response_array     =   array('status'=>'success');
        }
        

        print_r(json_encode($response_array));
        die();
    }
    
    public function poll_student() {
        $poll_id            =   $this->input->post('poll_id');
        $answer_id          =   $this->input->post('answer_id');
        $student_id         =   $this->session->userdata('student_id');
        
        $this->load->model("Onlinepoll_model");
        $poll_parent        =   $this->Onlinepoll_model->poll_by_student($poll_id,$answer_id,$student_id);
        if($poll_parent) {
            $response_array     =   array('status'=>'success');
        } else {
            $response_array     =   array('status'=>'failed');
        }
        print_r(json_encode($response_array));
        die();
    }
    
    public function poll_teacher() {
        $poll_id            =   $this->input->post('poll_id');
        $answer_id          =   $this->input->post('answer_id');
        $teacher_id         =   $this->session->userdata('teacher_id');
        
        $this->load->model("Onlinepoll_model");
        $poll_teacher        =   $this->Onlinepoll_model->poll_by_teacher($poll_id,$answer_id,$teacher_id);
        if($poll_teacher) {
            $response_array     =   array('status'=>'success');
        } else {
            $response_array     =   array('status'=>'failed');
        }
        print_r(json_encode($response_array));
        die();
    }
    
    function get_class_by_teacher(){
        $teacher_id= $this->input->post("teacher_id",TRUE);
        $this->load->model("Section_model");
        $teacherArr= $this->Section_model->get_class_deatils_by_teacher($teacher_id);
        $option_str="<option value=''>".get_phrase('select')."</option>";
        foreach ($teacherArr AS $k){
            $option_str.='<option value="'.$k['class_id'].'">'.$k['class'].'</option>';
        }
        echo $option_str;die;
    }
    function get_class_by_school($school_id = ''){
        
        $this->load->model("Class_model");
        $teacherArr= $this->Class_model->get_class_array($teacher_id, $school_id);
        $option_str="<option value=''>".get_phrase('select')."</option>";
        
        foreach ($teacherArr AS $k){
            $option_str.='<option value="'.$k['class_id'].'">'.$k['name'].'</option>';
        }
        echo $option_str;die;
    }

    function get_refund_amount(){
        $CollectionId = $_POST['CollectionId'];
        $RuleId = $_POST['RuleId'];

        $this->load->model('fees/Refund_model');
        
        $data = $this->Refund_model->get_refund_amount($CollectionId, $RuleId);
        echo $data;
    }

    function find_student4_fi(){
        $SearchText = trim($_POST['SearchText']);
        if($SearchText!=''){
            $this->load->model("Student_model");
            $data= $this->Student_model->get_student4_fi(strtolower($SearchText));
            if($data=='no'){
                echo 'no';
            }else{
                echo json_encode($data);
            }
        }
    }
    
      function remove_student_image() {
        $student_id = $this->input->post('student_id');
        $this->load->model("Student_model");
        $data= $this->Student_model->remove_profile_photo($student_id);
        $this->session->set_flashdata('flash_message', get_phrase('image_remove_successfully'));
      }
          /*
     * Check order
     */
    public function check_order_online_exam($exam_id,$order_id) {
        $order= $order_id;
        $result    =   get_data_generic_fun('questions','order',array('order'=>$order,'exam_id'=>$exam_id),'result_arr');
        $response_arr   =   array();
        if(count($result)>=1) {
            $response_arr['order_exist']        =   "1";
            $response_arr['message']            =   get_phrase('this_order_is_already_used');
        } 
        else {
            $response_arr['order_exist']        =   "0";
            $response_arr['message']            =   $order;            
        }
        print_r(json_encode($response_arr));exit;

    }

    function live_trackupdate($vehicle_id = ''){
        
        
//        $vehile_id=array('1277','0019','9837','1109','9838','1169','1176');
        // set URL and other appropriate options
       if(($vehicle_id != '') && ($vehicle_id!= '0')){
           $this->track_bus($vehicle_id);
       } else {
           $vehicle_id=array('RJ31-PA-4160','RJ31-PA-4157','RJ31-PA-4159','RJ31-PA-4156','RJ31-PA-4158','RJ31-PA-4162','RJ31-PA-4163');
           foreach($vehicle_id as $value) {
               $this->track_bus($value);
           }
       }
       echo "ok";
    }
    
    function track_bus($vehicle_id) {
        $ch = curl_init();
        $value       =   $vehicle_id;

        $bus_unique_key = str_replace('-', ' ', $vehicle_id);
        $VechileData = get_data_generic_fun('bus', 'device_imei', array('bus_unique_key' => $bus_unique_key));
        $device_imei = $VechileData['0']->device_imei;

        curl_setopt($ch, CURLOPT_URL, "http://vtrackgps.com/vehicleLatestPositionService/?apiKey=8hd6l5rw6cX8i3A41BoG41z8D0u2oLE4&vehicleId=$device_imei");
 //        curl_setopt($ch, CURLOPT_HEADER, 0);

         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         // grab URL and pass it to the browser
        $output  = curl_exec($ch);
            //echo $output."<br>";die;
        $result      = json_decode($output);
//            echo $o->Date."<br>";
//                echo $o->Time."<br>";
//                echo $o->Latitude."<br>";
//                echo $o->Longitude."<br>";
//                echo $o->Speed."<br>";exit;
            $data["lastUpdate"]     =   date('Y-m-d h:i:sa');
            $data["latitude"]       =   $result->Latitude;
            $data["longitude"]      =   $result->Longitude;
            $data["userName"]       =   $value;
            $phone                  =   get_data_generic_fun('gpslocations','phoneNumber,sessionID',array('userName'=>$data["userName"]),'result_array');
            if(!empty($phone)){
                $session_id = substr($phone[0]['sessionID'], 8);
                $session_id= date("Ymd")."".$session_id;
                $data["phoneNumber"]=   $phone[0]['phoneNumber'];
                $data["sessionID"]  =   $phone[0]['sessionID']; 
            }
            $data["speed"]      =   $result->Speed;
            $data["direction"]  =   "0";
            $data["distance"]   =   "0.0";
            $data["gpstime"]    =   date("Y-m-d",strtotime($result->Date))." ".date("H:i:s", strtotime($result->Time));
            $data["locationMethod"] =   "fused";
            $data["accuracy"]   =   "80";
            $data["extraInfo"]  =   "0";
            $data["eventType"]  =   "android";
            $data['school_id'] = $this->session->userdata('school_id')?$this->session->userdata('school_id'):0;            
            $this->load->model('Gpslocation_model');
            $this->Gpslocation_model->add($data);
            return true;
    }


    public function generate_barcode(){
        $ProductId = $_POST['ProductId'];

        $this->load->model('Inventory_product_model');
        $data = $this->Inventory_product_model->get_By_Id($ProductId);
        
        extract($data);

        $src=base_url()."barcode.php?code=".$product_unique_id;
        $str = "";

$str.="<div class='row' style='margin-top:27px;margin-left:20px;margin-right:20px;'><div class='col-xs-12'><style>@media print {div.page_break {page-break-after: always;}}</style><link href='".base_url()."bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css'/><style>.btn{border-radius:0 !important;-moz-border-radius:0 !important;-webkit-border-radius:0 !important;}a{text-decoration:none !important;}</style>";

    $str .= "<div class='col-xs-6' style='padding:10px;'><div style='border:2px solid gray;min-height:230px;padding:10px;'><p><b>".get_phrase("product_id")." :</b>".$product_unique_id."</p><p><b>".get_phrase("product_name")." :</b>".ucwords($product_name)."</p><p><b>".get_phrase("category")." :</b>".ucwords($categories_name)."</p><p><b>".get_phrase("seller")." :</b>".ucwords($seller_name)."</p><p><b>".get_phrase("quantity")." :</b>".$quantity."</p><p><b>".get_phrase("rate")." :</b>".$rate."</p><p><b>".get_phrase("purchase_date")." :</b>".$purchase_date."</p><p><b>".get_phrase("bill_date")." :</b>".$bill_date."</p><p><b>".get_phrase("purchase_mode")." :</b>".ucwords($purchase_mode)."</p><p><b>".get_phrase("bill_number")." :</b>".$bill_number."</p><img src='".$src."' width='150px' height='35px' style='margin-top:0in;'/></div></div>";
    
        echo $str;
    }

    function marks_report_list_teacher_login(){
         $this->load->model('Exam_model');
          $this->load->model('Setting_model');
         $class_id = $this->input->post('class_id');
         $section_id = $this->input->post('section_id');
         $exam_id = $this->input->post('exam_id');
         $subject_id = $this->input->post('subject_id');
//         echo "class_id=".$class_id;
//         echo "section_id".$section_id;
//         echo "exam_id".$exam_id;
//         echo "subject".$subject_id;
//         echo "year".$running_year;die;
         $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');    
        $list = $this->Exam_model->get_datatables($exam_id,$class_id,$section_id,$subject_id,$running_year);
//    pre($list); die;  
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $manage_marks) {
          
            $no++;
            $row1 = array();
            $row1[] = $no;
            $row1[] = $manage_marks->roll;
            $row1[] = ucfirst($manage_marks->name);
            $row1[] = $manage_marks->mark_obtained;
            $row1[] = $manage_marks->comment;
                    
            $data[] = $row1;
        }
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Exam_model->count_all($exam_id,$class_id,$section_id,$subject_id,$running_year),
                        "recordsFiltered" => $this->Exam_model->count_filtered($exam_id,$class_id,$section_id,$subject_id,$running_year),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);

    }

    function marks_get_icse_subject($class_id='', $section_id='') { 
        $this->load->model('Subject_model');
        $data['class_id']= $class_id;
        $data['section_id']= $section_id;
        $page_data['subjects'] = $this->Subject_model->marks_get_icse_subject($class_id, $section_id);
        echo '<option value=" ">' . "Select Subject" . '</option>';
        foreach ($page_data['subjects'] as $row) {
            echo '<option value="' . $row['subject_id'] . '">' . $row['name'] . '</option>';
        }
    }    

    function get_fi_category(){
        $category_type = $_POST['category_type'];
        $this->load->model('fees/Fees_model');
        $data = $this->Fees_model->get_fi_category($category_type);
        echo json_encode($data);

    }
}
