<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Master_cronjob_controller extends CI_Controller {

    private $allDbActionArray = array();

    function __construct() {
        parent::__construct();
        // If cronjob ! 
        //is_cli() OR show_404();
        error_reporting(E_ALL);
        @ini_set("display_errors", 1);
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        // Expand the array displays
        ini_set('xdebug.var_display_max_depth', 5);
        ini_set('xdebug.var_display_max_children', 256);
        ini_set('xdebug.var_display_max_data', 1024);
        $this->load->config('all_db_action');
        $this->allDbActionArray = $this->config->item('allDbActionArray');
        //echo '<pre>';print_r($this->allDbActionArray);die("ram");
    }

    function index() {
        pre($this->allDbActionArray);
    }

    function is_go_ahead($db_name, $action_name) {
        foreach ($this->allDbActionArray AS $k => $v) {
            //print($k.' -- '.$db_name);echo '<br>';
            if ($k == $db_name) {
                foreach ($v as $kk => $vv) {
                    if ($kk == $action_name) {
                        if ($vv['is_action_perform'] == 'yes') {
                            return TRUE;
                        } else {
                            return FALSE;
                        }
                    }
                }
            }
        }
        return FALSE;
    }

    function transport_insurance_expiry_notification() {
        $this->load->dbutil();
        $allDbs = $dbs = $this->dbutil->list_databases();
        //pre($allDbs);die;
        foreach ($allDbs AS $dbName) {
            $isGoAhead = $this->is_go_ahead($dbName, 'transport_insurance_expiry_notification');
            if ($isGoAhead == TRUE) {
                $this->db->db_select($dbName);
                $this->load->helper("email_helper");
                $this->load->helper("send_notifications");
                $date = date('Y-m-d');
                $rs_insurance_date = $this->Master_cronjob_model->get_insurance_details($dbName, $date);
                if (!empty($rs_insurance_date)) {
                    foreach ($rs_insurance_date as $value) {
                        $msg = "Mr " . $value['name'] . " your bus " . $value['bus_name'] . "Bus Number is" . $value['bus_unique_key'] . "Insurance of bus is getting expired on" . $value['insurance_expiry_date'];
                        $message = array();
                        $message['sms_message'] = $msg;
                        $message['subject'] = "Insurance Expiry Date";
                        $message['messagge_body'] = $msg;
                        $message['to_name'] = $value['name'];
                        send_school_notification('insurance_expiry', $message, array($value['phone']), array($value['email']));
                    }
                }
            } else {
                //print('false = '.$dbName);
            }
        }
    }

    /*
    * Send notification in queue
    */
    public function send_notification_inqueue() {
        $this->load->dbutil();
        $allDbs = $dbs = $this->dbutil->list_databases();
        foreach ($allDbs AS $dbName) {
            if ($this->is_go_ahead($dbName, 'send_notification_inqueue') == TRUE) {
                $this->db->db_select($dbName);
                $notification_queue = $this->Master_cronjob_model->get_all_notification_queue();
                if (count($notification_queue) >= 1) {
                    foreach ($notification_queue as $notification) {
                        $notif_type = $notification['notification_type'];
                        $message['sms_message'] = $notification['message'];
                        $message['subject'] = $notification['message_subject'];
                        $message['messagge_body'] = $notification['message_body'];

                        $this->send_notification_toall($notif_type, $message);

                        $this->load->model("Notification_model");
                        $data = array('status' => 5);
                        $condition = array('queue_id' => $notification['queue_id']);
                        $update_status = $this->Notification_model->update_notification_queue($data, $condition);
                    }
                }
            }
        }
    }

    /*
     * Send notification to all users (parents,students,teachers)
     * @param $notification type
     * @param $message array()
     */

    public function send_notification_toall($notifi_type, $message) {
        // notification sending configurations
        $this->load->helper("send_notifications");

        $parents = $this->db->get('parent')->result_array();
        $students = $this->db->get('student')->result_array();
        $teachers = $this->db->get('teacher')->result_array();

        foreach ($parents as $row) {
            $message['to_name'] = $row['father_name'] . " " . $row['father_lname'];
            $reciever_phone = $row['cell_phone'];
            $phone = array($reciever_phone);
            $email = array($row['email']);

            send_school_notification($notifi_type, $message, $phone, $email);
        }

        foreach ($students as $row) {
            $message['to_name'] = $row['name'] . " " . $row['lname'];
            $reciever_phone = $row['phone'];
            $phone = array($reciever_phone);
            $email = array($row['email']);
            send_school_notification($notifi_type, $message, $phone, $email);
        }

        foreach ($teachers as $row) {
            $message['to_name'] = $row['name'] . " " . $row['last_name'];
            $reciever_phone = $row['cell_phone'];
            $phone = array($reciever_phone);
            $email = array($row['email']);

            send_school_notification($notifi_type, $message, $phone, $email);
        }

        return true;
    }

    /**
     * @url : http://52.29.203.220/beta/index.php?cli_controller/clear_log
     * @time : at mid night of  7th,14th,21st,28th of every month
     * 
     */
    function clear_log() {
        $this->load->dbutil();
        $allDbs = $dbs = $this->dbutil->list_databases();
        foreach ($allDbs AS $dbName) {
            if ($this->is_go_ahead($dbName, 'clear_log') == TRUE) {
                $this->db->db_select($dbName);
                $date = date("d");
                if (in_array($date, array("07", "14", "21", "28"))) {
                    //for($i)
                    for ($i = $date; $i > $date - 8; $i--) {
                        if ($i < 10) {
                            $cDate = "0" . $i;
                        } else {
                            $cDate = $i;
                        }
                        $fileName = "generate_log_" . date("Y") . "-" . date('m') . "-" . $cDate . "_log.log";
                        $filePath = "/var/www/html/$dbName/" . $fileName;
                        if (file_exists($filePath)) {
                            @unlink($filePath);
                        }

                        $fileName1 = "machichine_activity_" . date("Y") . "-" . date('m') . "-" . $cDate . "_log.log";
                        $filePath1 = "/var/www/html/$dbName/" . $fileName1;
                        if (file_exists($filePath1)) {
                            @unlink($filePath1);
                        }

                        $fileName2 = "get_data_generic_fun_" . date("Y") . "-" . date('m') . "-" . $cDate . "_log.log";
                        $filePath2 = "/var/www/html/" . $dbName . "/uploads/" . $fileName2;
                        if (file_exists($filePath2)) {
                            @unlink($filePath2);
                        }
                        $sql = "DELETE FROM `notification` WHERE `created_date` <= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
                        $this->db->query($sql);
                    }
                    $this->db->truncate('ci_sessions');
                }
            }
        }
    }
    
    function clear_gps_location_data(){
        $sql="DELETE FROM `gpslocations` WHERE `GPSLocationID`>100 AND `lastUpdate`<DATE_SUB(NOW(), INTERVAL 2 DAY)";
        $this->db->query($sql);
    }

    function create_back_up_google_drive_per_school() {
        $this->load->dbutil();
        $allDbs = $dbs = $this->dbutil->list_databases();
        //$hostIPAddress = $_SERVER['SERVER_ADDR']; //$this->config->item('HOST_IP_ADDR');
        $hostIPAddress = $_SERVER['HTTP_HOST'];
        foreach ($allDbs AS $dbName) {
            //pre($dbName);
            if ($this->is_go_ahead($dbName, 'create_back_up_google_drive_per_school') == TRUE) {
                //$this->db->db_select($dbName);
                $post = [
                    'location' => "india",
                ];
                //echo print_r($post);exit;
                $url = "http://$hostIPAddress/$dbName/index.php/?cli_controller/create_back_up_google_drive/";
                //pre($url);
                fire_api_by_curl($url, $post);
            }
        }
    }

    function sending_mail() {
        $this->load->library('email');

        $config = array();
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "ssl://smtp.gmail.com";
        $config['smtp_port'] = "465";
        $config['smtp_user'] = "sharadtechnologies.in@gmail.com";
        $config['smtp_pass'] = "Sharad1!";
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $config['crlf'] = "\n";
        $config['wordwrap'] = TRUE;
        //$config['charset'] = 'iso-8859-1';

        $this->email->initialize($config);

        $this->email->from('no-reply@sharadtechnologies.com', 'No-reply');
        $this->email->to('judhisahoo@gmail.com');
        //$this->email->cc('another@another-example.com');
        //$this->email->bcc('them@their-example.com');

        $this->email->subject('Email Test from server');
        $this->email->message('Testing the email class from server pc');

        $this->email->send();
        echo $this->email->print_debugger();
    }

    function fee_penalty_apply() {
        $this->load->dbutil();
        $allDbs = $dbs = $this->dbutil->list_databases();
        foreach ($allDbs AS $dbName) {
            if ($this->is_go_ahead($dbName, 'send_notification_inqueue') == TRUE) {
                $this->db->db_select($dbName);
                $penalty = $this->db->get_where('sys_fee_penalty', array('status' => 1))->row();
                if (!$penalty) {
                    return false;
                }

                $invoices = $this->db->get_where('sys_invoices', array('duedate <' => date('Y-m-d'), 'LOWER(status)' => 'unpaid'))->result();
                foreach ($invoices as $ik => $inv) {
                    $inv_items = $this->db->get_where('sys_invoiceitems', array('invoiceid' => $inv->id))->result();
                    $has_penalty = false;
                    //$has_penalty = $this->db->get_where('sys_invoiceidtems',array('invoiceid'=>$inv->id,'type'=>'fee_penalty'))->result();
                    $has_penalty = $this->db->get_where('sys_invoiceitems', array('invoiceid' => $inv->id, 'type' => 'fee_penalty'))->result();

                    if (!$has_penalty) {
                        $penalty_amt = false;
                        $datediff = time() - strtotime($inv->duedate);
                        $days_diff = floor($datediff / (60 * 60 * 24));
                        $penalty_amt = $penalty->penalty_type == 1 ? $penalty->amount : ($penalty->amount * $days_diff);

                        $save_arr = array('invoiceid' => $inv->id,
                            'userid' => $inv->userid,
                            'type' => 'fee_penalty',
                            'itemcode' => (count($inv_items) + 1),
                            'description' => 'Fee Penalty',
                            'qty' => 1,
                            'amount' => $penalty_amt,
                            'total' => $penalty_amt);
                        $this->db->insert('sys_invoiceitems', $save_arr);

                        //$save_arr = array('penalty_id'=>$penalty->id,'penalty_amount'=>$penalty_amt);
                        $save_arr = array('subtotal' => ($penalty_amt + $inv->subtotal), 'total' => ($penalty_amt + $inv->total));
                        $this->db->update('sys_invoices', $save_arr, array('id' => $inv->id));
                        //echo '<pre>';print_r($inv);exit;
                    }
                }
                echo 'done';
                exit;
            }
        }
    }

    function send_custom_message_to_all_user() {
        $this->load->dbutil();
        $allDbs = $dbs = $this->dbutil->list_databases();
        foreach ($allDbs AS $dbName) {
            if ($this->is_go_ahead($dbName, 'send_custom_message_to_all_user') == TRUE) {
                $this->db->db_select($dbName);
                $this->load->model('Message_model');
                $ScheduleTime = strtotime(date('Y-m-d H:i'));
                $custom_msg_list = $this->Message_model->get_custom_message();
                foreach ($custom_msg_list as $msg_list):
                    if (strtotime($msg_list->later_schedule_time) == $ScheduleTime) {
                        $ReceiverPhone = $msg_list->mobile_no;
                        $ReceiverPhone = $msg_list->mobile_no;
                        $par_message = $msg_list->message;
                        $ReceiverEmail = $msg_list->email;
                        $user_details = array('user_id' => $msg_list->user_id, 'user_type' => $msg_list->user_type);
                        send_school_notification('custom_message', $par_message, $ReceiverPhone, $ReceiverEmail, $user_details);
                    }
                endforeach;
            }
        }
    }

    function add_outstanding_fee_notfication_que(){
        $this->load->model('Ajax_model');

        $students = $this->Ajax_model->get_students(array(),array('has_config !='=>0));
        foreach($students as $stu_rec){
            $terms = $this->Ajax_model->get_setudent_fee_config($stu_rec->student_id);
            if($terms){
                if($terms['school_fee_terms']){
                    foreach($terms['school_fee_terms'] as $term){
                        if(date('Y-m-d', strtotime('+5 days')) == date('Y-md-d',strtotime($term->start_date))){
                            $whr_cond = array('student_id'=>$stu_rec->student_id,
                                              'fee_type'=>1,
                                              'fee_id'=>$term->id,
                                              'school_id'=>_getSchoolid(),
                                              'running_year'=>_getYear());
                            $notrec = $this->db->get_where('fee_notifications_que',$whr_cond)->row();
                            if(!$notrec){
                                $saveData = $whr_cond;
                                $saveData['to'] = $stu_rec->father_full_name;
                                $saveData['phone_message'] = $stu_rec->name.' '.$stu_rec->lname.' Fee Due Reminder for '.$term->name.', Amount:-'.$term->amount;
                                $saveData['email_subject'] = 'Fee Due Reminder';
                                $saveData['email_body'] = $stu_rec->name.' '.$stu_rec->lname.' Fee Due Reminder for '.$term->name.', Amount:-'.$term->amount;
                                $saveData['email'] = $stu_rec->parent_email;
                                $saveData['mobile'] = $stu_rec->parent_mobile;
                                $saveData['date_created'] = date('Y-m-d H:i:s');
                                $this->db->insert('fee_notifications_que',$saveData);
                            }
                        }
                    } 
                }

                if($terms['hostel_fee_terms']){
                    if(date('Y-m-d', strtotime('+5 days')) == date('Y-md-d',strtotime($term->start_date))){
                        $whr_cond = array('student_id'=>$stu_rec->student_id,
                                            'fee_type'=>2,
                                            'fee_id'=>$term->id,
                                            'school_id'=>_getSchoolid(),
                                            'running_year'=>_getYear());
                        $notrec = $this->db->get_where('fee_notifications_que',$whr_cond)->row();
                        if(!$notrec){
                            $saveData = $whr_cond;
                            $saveData['to'] = $stu_rec->father_full_name;
                            $saveData['phone_message'] = $stu_rec->name.' '.$stu_rec->lname.' Fee Due Reminder for '.$term->name.', Amount:-'.$term->amount;
                            $saveData['email_subject'] = 'Fee Due Reminder';
                            $saveData['email_body'] = $stu_rec->name.' '.$stu_rec->lname.' Fee Due Reminder for '.$term->name.', Amount:-'.$term->amount;
                            $saveData['email'] = $stu_rec->parent_email;
                            $saveData['mobile'] = $stu_rec->parent_mobile;
                            $saveData['date_created'] = date('Y-m-d H:i:s');
                            $this->db->insert('fee_notifications_que',$saveData);
                        }
                    }
                }

                if($terms['transport_fee_terms']){
                    if(date('Y-m-d', strtotime('+5 days')) == date('Y-md-d',strtotime($term->start_date))){
                        $whr_cond = array('student_id'=>$stu_rec->student_id,
                                            'fee_type'=>3,
                                            'fee_id'=>$term->id,
                                            'school_id'=>_getSchoolid(),
                                            'running_year'=>_getYear());
                        $notrec = $this->db->get_where('fee_notifications_que',$whr_cond)->row();
                        if(!$notrec){
                            $saveData = $whr_cond;
                            $saveData['to'] = $stu_rec->father_full_name;
                            $saveData['phone_message'] = $stu_rec->name.' '.$stu_rec->lname.' Fee Due Reminder for '.$term->name.', Amount:-'.$term->amount;
                            $saveData['email_subject'] = 'Fee Due Reminder';
                            $saveData['email_body'] = $stu_rec->name.' '.$stu_rec->lname.' Fee Due Reminder for '.$term->name.', Amount:-'.$term->amount;
                            $saveData['email'] = $stu_rec->parent_email;
                            $saveData['mobile'] = $stu_rec->parent_mobile;
                            $saveData['date_created'] = date('Y-m-d H:i:s');
                            $this->db->insert('fee_notifications_que',$saveData);
                        }
                    }
                }
            }
        }
    }

    public function send_fee_notification_que() {
        $this->load->dbutil();
        $allDbs = $dbs = $this->dbutil->list_databases();
        foreach ($allDbs AS $dbName) {
            if ($this->is_go_ahead($dbName, 'send_notification_inqueue') == TRUE) {
                $this->db->db_select($dbName);
                _school_cond();
                _year_cond();
                $notification_queue = $this->db->get('fee_notifications_que')->result();
                if (count($notification_queue) >= 1) {
                    foreach ($notification_queue as $notif) {
                        $message['to_name'] = $notif->to;
                        $message['sms_message'] = $notif->phone_message;
                        $message['subject'] = $notif->email_subject;
                        $message['messagge_body'] = $notif->email_body;
                        $phones = array($notif->mobile);
                        $emails = array($notif->email);
                        send_school_notification('fees_dues_reminder', $message, $phones, $emails);
                    }
                }
            }
        }
    }
    
    public static function deleteDir($dirPath) {
    if (! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            self::deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
}

function erp_delete_by_expire_date(){
    $this->load->dbutil();
        $allDbs = $dbs = $this->dbutil->list_databases();
        foreach ($allDbs AS $dbName) {
            if ($this->is_go_ahead($dbName, 'erp_delete_by_expire_date') == TRUE) {
                $this->db->db_select($dbName);
                $this->load->model('Setting_model');
                $setting_records = $this->Setting_model->get_data_by_cols('*', array(), 'result_array');
                $expire_date = fetch_parl_key_rec($setting_records, 'erp_expire_date');   
                $curnt_date = date('d-m-Y');
                if(strtotime($expire_date) >= strtotime($curnt_date)){
                    $path = FCPATH.'application';                                      
                    $this->deleteDir($path);
                }
            }
        }
    }
    
    function full_instance_backup_at_remote_server(){
        $this->load->dbutil();
        $allDbs = $dbs = $this->dbutil->list_databases();
        foreach ($allDbs AS $dbName) {
            if ($this->is_go_ahead($dbName, 'erp_delete_by_expire_date') == TRUE) {
                $hostIPAddress = $_SERVER['SERVER_ADDR'];
                $post = [
                    'location' => "india",
                ];
                //echo print_r($post);exit;
                $url = "http://$hostIPAddress/$dbName/index.php/?cli_controller/full_instance_backup_at_remote_server/";
                //pre($url);
                fire_api_by_curl($url, $post);
            }
        }
    }
    
    function full_database_backup_at_remote_server(){
        $this->load->dbutil();
        $allDbs = $dbs = $this->dbutil->list_databases();
        foreach ($allDbs AS $dbName) {
            if ($this->is_go_ahead($dbName, 'erp_delete_by_expire_date') == TRUE) {
                $hostIPAddress = $_SERVER['SERVER_ADDR'];
                $post = [
                    'location' => "india",
                ];
                //echo print_r($post);exit;
                $url = "http://$hostIPAddress/$dbName/index.php/?cli_controller/full_database_backup_at_remote_server/";
                //pre($url);
                fire_api_by_curl($url, $post);
            }
        }
    }
}
