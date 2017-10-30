<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 	
 * 
 *  Module : Bus Driver
 *  Details : Controller for Bus Driver
 * 
 */

class Bus_driver extends CI_Controller {

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

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->library('form_validation');
        /* cache control */
        //$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        //$this->output->set_header('Pragma: no-cache');
        $this->load->model('Bus_driver_modal');

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

        if ($this->session->userdata('bus_driver_login') != 1) {
            redirect(base_url(), 'refresh');
        }
        date_default_timezone_set('Asia/Dubai');
    }

    public function dashboard() {
        $page_data= $this->get_page_data_var();
        $page_data['page_name'] = 'dashboard';
        $page_data['page_title'] = get_phrase('bus_driver_dashboard');
        $page_data['driver'] = $this->Bus_driver_modal->get_bus_driver($this->session->userdata('login_user_id'));
        $page_data['bnr'] = $this->Bus_driver_modal->get_driver_bus_and_route($page_data['driver']->bus_id);
        if(!empty($page_data['bnr'])){
            $page_data['num_students'] = $this->Bus_driver_modal->get_student_route_num($page_data['bnr']->transport_id);
        }        
       // $this->session->set_userdata('route_id', $page_data['bnr']->transport_id);
        $this->session->set_userdata('bus_id', $page_data['driver']->bus_id);
        //$page_data['groups'] = $this->Bus_driver_modal->get_route_group($this->session->userdata('route_id'));
        $page_data['driver_detail'] = $this->Bus_driver_modal->get_bus_driver_with_bus($this->session->userdata('login_user_id'));
//        pre($page_data['driver_detail']); die;
        $this->load->view('backend/index', $page_data);
    }

//    public function students() {
//        $page_data['page_name'] = 'students';
//        $page_data['students'] = $this->Bus_driver_modal->get_students_under_route($this->session->userdata('route_id'));
//        $page_data['page_title'] = get_phrase('students');
//        $this->load->view('backend/index', $page_data);
//    }

    public function trip($grp_id = '') {
        $page_data= $this->get_page_data_var();
        echo $this->session->userdata('route_id');
        $page_data['page_name'] = 'trip';
        $page_data['page_title'] = get_phrase('trip');
        $page_data['grp_id'] = $grp_id;
        //$page_data['groups'] = $this->Bus_driver_modal->get_route_group($this->session->userdata('route_id'));
        if ($this->Bus_driver_modal->check_do_upload() == 1 || $this->Bus_driver_modal->check_admin_approve() == 1) {
            redirect(base_url() . 'index.php?bus_driver/stop_trip', 'refresh');
        }
        if ($grp_id == '' && $this->session->userdata('grp_set') != '') {
            redirect(base_url() . 'index.php?bus_driver/trip/' . $this->session->userdata('grp_set'), 'refresh');
        }
        if ($grp_id != '') {
            $page_data['students'] = $this->Bus_driver_modal->get_student_under_route($this->session->userdata('route_id'), $grp_id);
            $this->session->set_userdata('grp_set', $grp_id);
            $page_data['check_trip_session'] = $this->Bus_driver_modal->check_driver_trip_session($this->session->userdata('login_user_id'), $grp_id);
        }
        $page_data['check_attendence'] = $this->Bus_driver_modal->check_student_attendence();
        $page_data['session'] = (date('A') == 'AM') ? '0' : '1';
        $page_data['buttons_in'] = $this->Bus_driver_modal->get_attendence_in();
        
        $page_data['buttons_out'] = $this->Bus_driver_modal->get_attendence_out();
        $this->load->view('backend/index', $page_data);
    }

    public function start_trip() {
        $page_data= $this->get_page_data_var();
        $this->session->set_userdata('trip_started', 1);
        $grp_id = $this->input->post('grp_id');
        $route_id = $this->session->userdata('route_id');
        $bus_id = $this->session->userdata('bus_id');
        /* Notify bus admin */
        /* Change the year when adding */
        if ($this->Bus_driver_modal->start_trip($this->session->userdata('login_user_id'), $grp_id, $route_id, $bus_id)) {
            echo 'success';
        }
    }

    public function stop_trip($param = '') {
        $page_data= $this->get_page_data_var();
        if ($this->Bus_driver_modal->check_do_upload() == 0 && $this->session->userdata('trip_started') != 1) {
            redirect(base_url() . 'index.php?bus_driver/trip', 'refresh');
        }
        $this->session->unset_userdata('trip_started');
        $this->Bus_driver_modal->update_do_upload();
        if ($param == 'upload') {
            $file_ary = $this->reArrayFiles($_FILES['file_name']);
            $tmp_file_ary = array();
            $num = 0;
            foreach ($file_ary as $file) {
                $num++;
                $date = date("ymd");
                $timenow = time();
                $tmp = explode('.', $file['name']);
                $ext = end($tmp);
                $pic = $date . ($timenow + $num) . '.' . $ext;
                $tmp_file_ary[] = $pic;
                $upload_path = 'uploads/bus_image/' . $pic;
                move_uploaded_file($file['tmp_name'], $upload_path);
            }
            $file_str = implode(',', $tmp_file_ary);
            $id = $this->session->userdata('login_user_id');
            $route_id = $this->session->userdata('route_id');
            $grp_id = $this->session->userdata('grp_set');
            $bus_id = $this->session->userdata('bus_id');
            $this->Bus_driver_modal->upload_images($id, $route_id, $grp_id, $bus_id, $file_str);
            $this->Bus_driver_modal->update_admin_approve();
            redirect(base_url() . 'index.php?bus_driver/stop_trip/', 'refresh');
        }
        /* Notify bus admin */
        $page_data['check_approve'] = $this->Bus_driver_modal->check_admin_approve();
        $page_data['page_name'] = 'upload';
        $page_data['page_title'] = get_phrase('upload');
        $this->load->view('backend/index', $page_data);
    }

    public function check_trip_status() {
        $page_data= $this->get_page_data_var();
        $status = $this->Bus_driver_modal->check_admin_approve();
        if ($status == 0) {
            echo 'go';
        } else {
            echo 'no';
        }
    }

    public function trip_complete() {
        $page_data= $this->get_page_data_var();
        $this->Bus_driver_modal->trip_complete();
        redirect(base_url() . 'index.php?bus_driver/trip', 'refresh');
    }

    public function reArrayFiles($file_post) {
        $page_data= $this->get_page_data_var();
        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);
        for ($i = 0; $i < $file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }
        return $file_ary;
    }

    public function register_student_attendence() {
        $page_data= $this->get_page_data_var();
        $student_id = $this->input->post('student_id');
        $entry = $this->input->post('entry');
        $grp_id = $this->input->post('grp_id');
        $route_id = $this->session->userdata('route_id');
        $bus_id = $this->session->userdata('bus_id');
        // get class id from somewer later when u fix the database
        if ($this->Bus_driver_modal->register_student_attendence($student_id, $entry, $grp_id, $route_id, $bus_id)) {
            echo 'success';
        }
    }

    public function manage_profile($param1 = '') {
        $page_data= $this->get_page_data_var();
        if ($param1 == 'change_password') {
            $data['password'] = sha1($this->input->post('password'));
            $data['new_password'] = sha1($this->input->post('new_password'));
            $data['confirm_new_password'] = sha1($this->input->post('confirm_new_password'));
            $current_password = $this->Bus_driver_modal->get_bus_driver($this->session->userdata('login_user_id'))->password;
            if ($current_password == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {
                $this->Bus_driver_modal->update_driver_password($this->session->userdata('login_user_id'), array('password' => $data['new_password']));
                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
            } else {
                $this->session->set_flashdata('flash_message', get_phrase('password_mismatch'));
            }
            redirect(base_url() . 'index.php?bus_driver/manage_profile/', 'refresh');
        }
        if($param1 == 'update_profile_info'){
            $data['name'] = $this->input->post('name');
            $data['email'] = $this->input->post('email');
            $file_name = $_FILES['userfile']['name'];
            $types = array('image/jpeg', 'image/gif', 'image/png');
            if ($file_name != '') {
                if (in_array($_FILES['userfile']['type'], $types)) {
                    $ext = explode(".", $file_name);
                    $user_id = $this->session->userdata('login_user_id');
                    $data['driver_image'] = $user_id . "." . end($ext);
                    $this->Bus_driver_modal->update_profile_info($user_id, $data);
                    move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/bus_driver_image/' . $data['driver_image']);
                    $this->session->set_flashdata('flash_message', get_phrase('account_details_updated'));
                 
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('It may be the wrong filetype. We only allow JPG, GIF, and PNG filetypes!!'));
                    redirect(base_url() . 'index.php?bus_driver/manage_profile/', 'refresh');
                }
            } else {
                $data['image'] = $this->input->post('image');
                $user_id = $this->session->userdata('admin_id');
                $this->Bus_driver_modal->update_profile_info($data, $user_id);
                redirect(base_url() . 'index.php?bus_driver/manage_profile/', 'refresh');
            }
        }
        
        $page_data['page_name'] = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data'] = $this->Bus_driver_modal->get_bus_driver($this->session->userdata('login_user_id'));
        $this->load->view('backend/index', $page_data);
    }
    
    public function manage_students() {
        $page_data= $this->get_page_data_var();
//        $students = get_data_generic_fun('student_bus_allocation', '*', array(), 'result_array',array('student_bus_id'=>'desc'));
        //        pre($students); die;
//        foreach ($students as $value) {
//            $student_name = get_data_generic_fun('student', 'name', array('student_id' => $value['student_id']), 'result_array');
//
//            if (!empty($student_name)) {
//                $students_name[]['student_name'] = $student_name[0]['name'];
//            } else {
//                $students_name[]['student_name'] = '';
//            }
//            $route_name = get_data_generic_fun('transport', 'route_name', array('transport_id' => $value['route_id']), 'result_array');
//            if (!empty($route_name)) {
//                $routes_name[]['route_name'] = $route_name[0]['route_name'];
//            } else {
//                $routes_name[]['route_name'] = '';
//            }
//            $bus = get_data_generic_fun('bus', 'name', array('route_id' => $value['route_id'],'bus_id' => $bus_id->bus_id), 'result_array');
////            echo $this->db->last_query(); die;
//            if (!empty($bus)) {
//                $bus_name[]['bus_name'] = $bus[0]['name'];
//            } else {
//                $bus_name[]['bus_name'] = '';
//            }
//        }
//        $i = 0;
//        $newArray = array();
//        foreach ($students as $row) {
//            $newArray[$i] = array_merge($row, $students_name[$i], $routes_name[$i], $bus_name[$i]);
//            $i++;
//        }
//        
//        $page_data['student_details'] = $newArray;
//        pre($page_data['student_details']);die;
//        
        $bus_driver_id = $this->session->userdata('login_user_id');        
        $bus_id = $this->Bus_driver_modal->get_bus_id($bus_driver_id);
        $page_data['student_details'] = $this->Bus_driver_modal->get_student_by_bus_id($bus_id->bus_id);
//        
        $page_data['page_title'] = get_phrase('manage_student');
        $page_data['page_name'] = 'manage_student_bus';
        $this->load->view('backend/index', $page_data);
    }
    
    public function bus_details() {
        $page_data= $this->get_page_data_var();
        $bus_driver_id = $this->session->userdata('login_user_id');        
        $bus_id = $this->Bus_driver_modal->get_bus_id($bus_driver_id);
        $page_data['buses'] = $this->Bus_driver_modal->get_bus_with_route1($bus_id->bus_id);
        $page_data['page_title'] = get_phrase('manage_bus');
        $page_data['page_name'] = 'bus_manage';
        $this->load->view('backend/index', $page_data);
    }
    
    public function bus_admin(){  
        $page_data= $this->get_page_data_var();      
        $page_data['bus_admins'] = $this->Bus_driver_modal->get_bus_admins();
        $page_data['page_title'] = get_phrase('Bus_Administrator');
        $page_data['page_name'] = 'bus_admin';
        $this->load->view('backend/index', $page_data);
    }
    
    /* public function manage_attendance(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->form_validation->set_rules('bus_id', 'Bus', 'required');
            $this->form_validation->set_rules('timestamp', 'Date', 'required');
            if ($this->form_validation->run() == TRUE) {
                $bus_id = $this->input->post('bus_id');
                $date = $this->input->post('timestamp');
                $date = date('Y-m-d',strtotime($date));
                redirect(base_url() . 'index.php?bus_driver/manage_attendance_view/'.$bus_id.'/'.$date,'refresh');
            }    
        }

        $page_data= $this->get_page_data_var();    
        $driver_id       =    $this->session->userdata('bus_driver_id');
        $page_data['busses'] = $this->Bus_driver_modal->get_bus_for_driver($driver_id);
        $page_data['page_title'] = get_phrase('manage_attendance');
        $page_data['page_name'] = 'manage_attendance';
        $this->load->view('backend/index', $page_data);
    } */

    public function attendance_selector(){
        $page_data= $this->get_page_data_var();
        $this->load->model('Bus_driver_attendence_model');
        $this->load->model('Attendance_model');
        $this->load->model('Student_bus_allocation_model');
        $this->form_validation->set_rules('bus_id', 'Bus', 'required');
        $this->form_validation->set_rules('timestamp', 'Date', 'required');
        $driver_id       =    $this->session->userdata('bus_driver_id');
        if ($this->form_validation->run() == TRUE) {
            $page_data['bus_id'] = $this->input->post('bus_id');
            $page_data['year'] = $this->input->post('year');
            $page_data['timestamp'] = $this->input->post('timestamp');
            /* $page_data['query'] = $this->Bus_driver_attendence_model->get_data_by_cols("*", array('bus_id' => $page_data['bus_id'], 'year' => $page_data['year'], 'timestamp' => $page_data['timestamp']), "result_array");
            if (count($page_data['query']) < 1) {
                $page_data['students'] = $this->Student_bus_allocation_model->get_students_by_bus($page_data['bus_id']);                
            } 
            else {
                $page_data['students'] = $this->Student_bus_allocation_model->student_attendance($page_data['bus_id'], $page_data['year'], $page_data['timestamp']);
                if (empty($page_data['students'])) {
                    redirect(base_url() . 'index.php?bus_driver/manage_attendance_view/' . $page_data['bus_id'] . '/' . $page_data['year'] . '/' . $page_data['timestamp'], 'refresh');
                }
            }
            
            $attn_data = array();
            
            foreach ($page_data['students'] as $row) {
                $attn_data['bus_driver_id'] = $driver_id;
                $attn_data['bus_id'] = $row['bus_id'];
                $attn_data['class_id'] = $row['class_id'];
                $attn_data['year'] = $page_data['year'];
                $attn_data['timestamp'] = $page_data['timestamp'];
                $attn_data['section_id'] = $row['section_id'];
                $attn_data['student_id'] = $row['student_id'];
                //echo '<pre>'; print_r($attn_data);     
               // echo $attn_data['year']."<br>".$attn_data['timestamp']."<br>".$attn_data['bus_id']."<br>";
                $rs = $this->Bus_driver_attendence_model->get_data_by_cols("*",array("year"=> $attn_data['year'],"timestamp"=> $attn_data['timestamp'],"bus_id"=> $attn_data['bus_id'], "student_id"=> $attn_data['student_id']), 'result_type');
                //echo $this->db->last_query(); echo '<br>';
                if (empty($rs)) {
                   //echo "Jesus<br>"; 
                    //echo '<pre>'; print_r($attn_data);echo "<hr>"; 
                    $this->Bus_driver_attendence_model->attendence_add($attn_data);
                   // echo $this->db->last_query(); echo "<br>";
                } 
            } 
            $page_data['attendance_of_students'] = $this->Bus_driver_attendence_model->get_data_by_cols('*', array('bus_id' => $attn_data['bus_id'], 'student_id' => $attn_data['student_id'], 'year' => $attn_data['year'], 'timestamp' => $attn_data['timestamp']), 'result_type');
             */
            redirect(base_url() . 'index.php?bus_driver/manage_attendance_view/' . $page_data['bus_id'].'/'.$page_data['timestamp'], 'refresh');
        } else {
            
            $page_data['busses'] = $this->Bus_driver_modal->get_bus_for_driver($driver_id);
            $page_data['page_name'] = 'manage_attendance';
            $this->load->view('backend/index', $page_data);
        }
    }

    /* function manage_attendance_view($bus_id='',$date='',$mark_today=false) {
        $driver_id = $this->session->userdata('bus_driver_id');
        $page_data= $this->get_page_data_var();
        $this->load->model('Bus_driver_attendence_model');
        $this->load->model("Section_model");
        $this->load->model("Class_model");
        $page_data['date'] = $date;
        $date = date('Y-m-d',strtotime($date));
        $page_data['page_title'] = get_phrase('manage_attendance_of_class');
        //$page_data['att_of_students'] = $this->Bus_driver_attendence_model->getstudents_attendence($bus_id, $year,$timestamp);
        $page_data['stu_attendance'] = $this->Bus_driver_attendence_model->get_student_bus_attendance(array('SBA.bus_id'=>$bus_id),$date);   
        //echo '<pre>';print_r( $page_data['stu_attendance']);exit; 
        $page_data['bus_id'] = $bus_id; 
        $page_data['mark_today'] = $mark_today;
        $page_data['buses'] = $this->Bus_driver_modal->get_bus_for_driver($driver_id);
        $page_data['page_name'] = 'manage_attendance_view';
        $this->load->view('backend/index', $page_data);
    } */

    function manage_pick_up_attendance(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            //echo 124;exit;
            $this->form_validation->set_rules('bus_id', 'Bus', 'required');
            //$this->form_validation->set_rules('timestamp', 'Date', 'required');
            if ($this->form_validation->run() == TRUE) {
                $bus_id = $this->input->post('bus_id');
                $date = date('Y-m-d');
                redirect(base_url() . 'index.php?bus_driver/manage_pick_up_attendance_view/'.$bus_id.'/'.$date.'/1','refresh');
            }    
        }

        $page_data= $this->get_page_data_var();    
        $page_data['mark_today'] = true;
        $driver_id       =    $this->session->userdata('bus_driver_id');
        $page_data['busses'] = $this->Bus_driver_modal->get_bus_for_driver($driver_id);
        $page_data['page_title'] = get_phrase('manage_pick_up_attendance');
        $page_data['page_name'] = 'manage_pick_up_attendance';
        $this->load->view('backend/index', $page_data);
    }

    function manage_pick_up_attendance_view($bus_id='',$date='',$mark_today=false) {
        $driver_id = $this->session->userdata('bus_driver_id');
        $page_data= $this->get_page_data_var();
        $this->load->model('Bus_driver_attendence_model');
        $page_data['date'] = $date;
        $date = date('Y-m-d',strtotime($date));
        $page_data['page_title'] = get_phrase('manage_attendance_of_class');
        //$page_data['att_of_students'] = $this->Bus_driver_attendence_model->getstudents_attendence($bus_id, $year,$timestamp);
        $page_data['stu_attendance'] = $this->Bus_driver_attendence_model->get_student_bus_attendance(array('SBA.bus_id'=>$bus_id),$date);   
        //echo '<pre>';print_r( $page_data['stu_attendance']);exit; 
        $page_data['bus_id'] = $bus_id; 
        $page_data['mark_today'] = $mark_today;
        $page_data['buses'] = $this->Bus_driver_modal->get_bus_for_driver($driver_id);
        $page_data['page_name'] = 'manage_pick_up_attendance_view';
        $this->load->view('backend/index', $page_data);
    }

    function manage_drop_attendance(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            //echo 124;exit;
            $this->form_validation->set_rules('bus_id', 'Bus', 'required');
            //$this->form_validation->set_rules('timestamp', 'Date', 'required');
            if ($this->form_validation->run() == TRUE) {
                $bus_id = $this->input->post('bus_id');
                $date = date('Y-m-d');
                redirect(base_url() . 'index.php?bus_driver/manage_drop_attendance_view/'.$bus_id.'/'.$date.'/1','refresh');
            }    
        }

        $page_data= $this->get_page_data_var();    
        $page_data['mark_today'] = true;
        $driver_id       =    $this->session->userdata('bus_driver_id');
        $page_data['busses'] = $this->Bus_driver_modal->get_bus_for_driver($driver_id);
        $page_data['page_title'] = get_phrase('manage_drop_attendance');
        $page_data['page_name'] = 'manage_drop_attendance';
        $this->load->view('backend/index', $page_data);
    }

    function manage_drop_attendance_view($bus_id='',$date='',$mark_today=false) {
        $driver_id = $this->session->userdata('bus_driver_id');
        $page_data= $this->get_page_data_var();
        $this->load->model('Bus_driver_attendence_model');
        $page_data['date'] = $date;
        $date = date('Y-m-d',strtotime($date));
        $page_data['page_title'] = get_phrase('manage_attendance_of_class');
        //$page_data['att_of_students'] = $this->Bus_driver_attendence_model->getstudents_attendence($bus_id, $year,$timestamp);
        $page_data['stu_attendance'] = $this->Bus_driver_attendence_model->get_student_bus_attendance(array('SBA.bus_id'=>$bus_id),$date);   
        //echo '<pre>';print_r( $page_data['stu_attendance']);exit; 
        $page_data['bus_id'] = $bus_id; 
        $page_data['mark_today'] = $mark_today;
        $page_data['buses'] = $this->Bus_driver_modal->get_bus_for_driver($driver_id);
        $page_data['page_name'] = 'manage_drop_attendance_view';
        $this->load->view('backend/index', $page_data);
    }

    function attendance_report() {
        if($this->input->server('REQUEST_METHOD')=='POST'){    
            $this->form_validation->set_rules('bus_id', 'Bus', 'required');
            $this->form_validation->set_rules('month', 'Month', 'required');
            if ($this->form_validation->run() == TRUE) {
                redirect(base_url() . 'index.php?bus_driver/attendance_report_view/'.$this->input->post('bus_id').'/'.$this->input->post('month'), 'refresh');
            }       
        }
    
        $page_data = $this->get_page_data_var();
        $page_data['month'] = date('m');
        $page_data['page_name'] = 'attendance_report';
        $page_data['page_title'] = get_phrase('attendance_report');
        $driver_id = $this->session->userdata('bus_driver_id');
        $page_data['busses'] = $this->Bus_driver_modal->get_bus_for_driver($driver_id);
        $this->load->view('backend/index', $page_data);
    }

    function attendance_report_view($bus_id=false,$month = '') {
        
        $this->load->model('Holiday_model');
        $this->load->model('Bus_driver_attendence_model');
        //$this->load->model('Student_model');
        $page_data = $this->get_page_data_var();
            
        $holidays = $this->Holiday_model->get_holiday_list_attendance();
        $holiday_dates = array();
        foreach ($holidays as $holiday) {
            $holiday_dates[] = $holiday['date_start'];
            for ($i = 0; $i < ($holiday['number_of_days'] - 1); $i++) {
                $holiday_dates[] = date('Y-m-d', strtotime($holiday['date_start'] . ' + ' . $i . ' days'));
            }
        }
        $page_data['holidays'] = $holiday_dates;

        $running_year = $this->globalSettingsRunningYear;
        $years = explode('-', $running_year);
        $page_data['year'] = $year = date('m')>4?$years[0]:$years[1];
        $page_data['days'] = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        
        $page_data['students'] = array();
        $students = $this->Bus_driver_attendence_model->get_student_bus_attendance(array('SBA.bus_id'=>$bus_id));   
        foreach ($students as $k => $row){
            $p = 0;
            for ($i = 1; $i <= $page_data['days']; $i++) {
                $date = $year.'-'.$month.'-'.$i;
                $whr = array('year' => $running_year, 'DATE(date)' => $date, 'student_id' => $row->student_id,'bus_id'=>$row->bus_id); 
                //$atten = 
                $page_data['students'][$k] = $row;
                $page_data['students'][$k]->atten[$i] = $this->db->get_where('bus_attendence',$whr)->row();
            }
        }
        //echo '<pre>';print_r($page_data['students']);exit;
        $page_data['bus_id'] = $bus_id;
        $page_data['month'] = $month;
        $page_data['page_title'] = get_phrase('bus_attendance_report_of_student');
        $page_data['page_name'] = 'attendance_report_view';
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
    
    /* function attendance_update($bus_id = '', $year = '', $timestamp = '') {
        $this->load->model('Bus_driver_attendence_model');
        $page_data['year'] = $this->globalSettingsRunningYear;
        $attendance_of_students = $this->Bus_driver_attendence_model->get_data_by_cols("*",array("bus_id"=> $bus_id,"year"=> $year, "timestamp"=> $timestamp), 'result_type');
        //echo '<pre>'; print_r($attendance_of_students); exit;
        //$attendance_of_students = $this->Attendance_model->get_data_by_cols('*', array('class_id' => $class_id, 'section_id' => $section_id, 'year' => $running_year, 'timestamp' => $timestamp), 'result_type');
        foreach ($attendance_of_students as $row) {
            $attendance_status = $this->input->post('status_' . $row['bus_attendence_id']);
            if ($attendance_status != '') {
                $this->Bus_driver_attendence_model->attendence_update($row['bus_attendence_id'], array('attendance_status' => $attendance_status));
            }
        }
        $this->session->set_flashdata('flash_message', get_phrase('attendance_updated'));
        redirect(base_url() . 'index.php?bus_driver/manage_attendance_view/' . $bus_id . '/' . $year . '/' . $timestamp, 'refresh');
    } */
    
    
  function manage_vehicle_details($param1 = '', $param2 = '', $param3 = '') {
    $page_data = $this->get_page_data_var();
        $this->load->model('Vehicle_details');
        $bus_driver_id = $this->session->userdata('login_user_id');        
        $bus_id = $this->Bus_driver_modal->get_bus_id($bus_driver_id);
        $page_data['details'] = $this->Vehicle_details->get_all_details_by_busDriver($bus_driver_id,$bus_id->bus_id);
        $page_data['page_title'] = get_phrase('manage_vehicle_details');
        $page_data['page_name'] = 'manage_vehicle_details';
        $this->load->view('backend/index', $page_data);
  }
  
}
