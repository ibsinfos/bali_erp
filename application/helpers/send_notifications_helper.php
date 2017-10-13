<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		Shafeeque Sharad technologies
 * @copyright	
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

/*
 * Send School notifications It's 
 * This handles all school notification in School ERP
 * @param $activity string Event which is going to be notifie about ( predefined codes for each event eg:  'exam_date')
 * @param $message Message Content array('subject'=>"subject",'message_body'=>"Message_body",'sms_message'=>"Sms message");
 * @param $phone Phone number array or comma seperated phone number
 * @param $email Email Id array of email
 * @param $userdetails array 
 * @param $class_id class_id in case of classid
 */

    function send_school_notification_new($activity, $message, $phones = array(), $emails = array(), $user_details = array(), $class_id=''){
        $CI=&get_instance();
        $notification_settings = get_push_notification_settings($activity );
        $notification = array_shift($notification_settings);

        if(count($notification)){
            $user_details['sms'] = $notification['sms'];
            $user_details['push_notify'] = $notification['push_notify'];
            $user_details['email'] = $notification['email'];
            $user_details['notification_link'] = $notification['notification_link'];

            if(($notification['sms']=='0') && ($notification['push_notify']=='0') && ($notification['email']=='0')){
                $data['message_schedule_status'] = '0';
            }
        }

        if( $activity == '' || empty($message) )
            return FALSE;

        $notification_link  =  $notification['notification_link'];

        if($user_details['later_schedule_time']==''){
            if($notification['push_notify'] == 1 && !empty($user_details) ) {
                //send_push_notification($user_details,$message,$class_id,$notification_link);
            }
        }

        unset($user_details['device_token']);

        $CI = & get_instance();

        $CI->db->insert( 'custom_message_noticeboard' , $user_details);
        
        if($user_details['later_schedule_time']==''){
            if($notification['sms'] == 1 && !empty($phones)) {
                $sqlSettings="SELECT * FROM `settings` WHERE `type`='sms_sender_id'";
                $rsSettings=$CI->db->query($sqlSettings)->result();
                if(empty($rsSettings)){
                    $senderId="sharad";
                }else{
                    $senderId=$rsSettings[0]->description;
                }
                if(is_array($message)) {
                    if(array_key_exists('sms_message', $message)){
                        $sms_message        =   $message['sms_message'];
                        //send_sms( $phones , $sms_message );
                    }else if(array_key_exists('messagge_body', $message)){
                        $sms_message        =   $message['messagge_body'];
                        //send_sms( $phones , $sms_message );
                    }    
                } else {
                    $sms_message        =   $message;
                    //send_sms( $phones , $sms_message );
                }
            }
            
            if($notification['email'] == 1 && !empty($emails)) {
                $CI->load->helper('email_helper');

                $email_config       =   create_email_params( $emails , $activity , $message);
                //send_common_mail( $email_config['to_address'] , $email_config['subject'] , $email_config['message_body'] , ''); 

                if(!empty($email_config)){
                    if(is_array($email_config['email'])) {
                        foreach( $email_config['email'] as $key=>$to_email ) {
                            //send_common_mail( $to_email , $email_config['subject'] , $email_config['message_body'] , $email_config['to_name'] ); 
                        }
                    } else {
                        //send_common_mail( $email_config['email'] , $email_config['subject'] , $email_config['message_body'] , $email_config['to_name']); 
                    }
                }
            }
        }
    }

    function send_school_notification( $activity , $message , $phones = array() , $emails = array() , $user_details = array(),$class_id='') {
        $CI=&get_instance();
        $notification_settings  =       get_push_notification_settings( $activity );
        $notification           =       array_shift($notification_settings);
        if( $activity == '' || empty($message) )
            return FALSE;

        $notification_link              =   $notification['notification_link'];
        if($notification['push_notify'] == 1 && !empty($user_details) ) {
            send_push_notification($user_details,$message,$class_id,$notification_link);
        }
 
        if($notification['sms'] == 1 && !empty($phones)) {
            $sqlSettings="SELECT * FROM `settings` WHERE `type`='sms_sender_id'";
            $rsSettings=$CI->db->query($sqlSettings)->result();
            if(empty($rsSettings)){
                $senderId="sharad";
            }else{
                $senderId=$rsSettings[0]->description;
            }
            if(is_array($message)) {
                if(array_key_exists('sms_message', $message)){
                    $sms_message        =   $message['sms_message'];
                    send_sms( $phones , $sms_message );
                }else if(array_key_exists('messagge_body', $message)){
                    $sms_message        =   $message['messagge_body'];
                    send_sms( $phones , $sms_message );
                }    
            } else {
                $sms_message        =   $message;
                send_sms( $phones , $sms_message );
            }
        }
        
        if($notification['email'] == 1 && !empty($emails)) {
            $CI->load->helper('email_helper');

            $email_config       =   create_email_params( $emails , $activity , $message);
            //send_common_mail( $email_config['to_address'] , $email_config['subject'] , $email_config['message_body'] , ''); 

            if(!empty($email_config)){
                if(is_array($email_config['email'])) {
                    foreach( $email_config['email'] as $key=>$to_email ) {
                        send_common_mail( $to_email , $email_config['subject'] , $email_config['message_body'] , $email_config['to_name'] ); 
                    }
                } else {
                    send_common_mail( $email_config['email'] , $email_config['subject'] , $email_config['message_body'] , $email_config['to_name']); 
                }
            }
        }
    }
    
    /*
     * Get push notification settings which configured in notification dashboard
     * @param $activity Message type going to send
     * @return Array (sms = 1/0 , email = 1/0 push_notify = 1/0)
     */
    function get_push_notification_settings( $activity = '') {
        $CI	=&	get_instance();
        $CI->load->database();
        $dashbord_notification = $CI->db->get_where('dashbord_notification', array('activity' => $activity))->result_array();
        return $dashbord_notification;
    }
    
    
    /*
     * Send sms from the School ERP System
     * @param $phone_number array() array of phone number or comma seperated string
     * @param string $message  Message to be sent
     */
    function send_sms( $phone_number , $message ,$senderId="sharad") {
        if(is_array($phone_number)) {
            $phone_number               =       implode( "," , $phone_number);
        }
        $globalSettingsSMSDataArr       =       get_data_generic_fun('settings','description',array('condition_type'=>'in','condition_in_col'=>'type','condition_in_data'=>'location,app_package_name,running_year,system_name,system_email'));
        if(strlen($senderId)>6){
            $senderId= substr($string, 0,5);
        }else{
            $senderId= str_pad($senderId,6,'_');
        }
        $post = [
            'location'                  =>      $globalSettingsSMSDataArr[3]->description,
            'cell_phone'                =>      $phone_number,
            'message'                   =>      $message,
            'sender_id'                  =>      $senderId
        ];

        $url = "http://".SMS_IP_ADDR."/School/index.php/?admin/send_common_sms/"; // url for sms configured
        
        if(fire_api_by_curl($url,$post))
            return TRUE;
        else 
            return FALSE;
    }
    
    
    
    /*
     * Generate mail params
     * @param $email
     * @param $activity
     * @param $message
     * @return array of mail to be sent
     */
    function create_email_params( $emails , $activity , $message ) {
		
        $email_contents         =   array();
        if($activity == 'exam_date') {
            $subject        =   "Exam Date Published";
            $message_body   =   "";
        } else if( $activity == 'event_notice' ) {
            $subject        =   "New Event Published";
            $message_body   =   "";
        } else if( $activity == 'annual_fun' ) {
            $subject        =   "Annual Function";
            $message_body   =   "";
        } else if( $activity == 'receipt_print') {
            $subject        =   "Reciept Print";
            $message_body   =   "";
        } else if( $activity == 'child_out') {
            $subject        =   "Child Punched Out From School";
            $message_body   =   "";
        } else if( $activity == 'child_in' ) {
            $subject        =   "Child Punched In To the School";
            $message_body   =   "";
        }
        
        if(is_array($message)) {	
            $subject            =   $message['subject'];
            $message_body       =   $message['messagge_body'];
            $to_name            =   (isset($message['to_name'])? $message['to_name']:'');
        } else {
            $subject            =   $message;
            $message_body       =   $message;
            $to_name            =   '';
        }
        
            $email_contents['email']                =   $emails;
            $email_contents['subject']              =   $subject;
            $email_contents['message_body']         =   $message_body;
            $email_contents['to_name']              =   $to_name;
        if($email_contents)
            return $email_contents;
        else 
            return FALSE;
        
    }
    
    /*
     * Send push notification from the School ERP System
     * @param $phone_number array() array of phone number or comma seperated string
     * @param $user_details array() array of userdetails 
     * @param string $message  Message to be sent
     */
    function send_push_notification( $user_details , $message ,$class_id='' , $notification_link = '') {
        if(is_array($message)) {
            $message        =   $message['sms_message'];
        } else {
            $message        =   $message;
        }

        if(isset($user_details['device_details'])) {
            send_mobile_pushnotification($message , $user_details['device_details']);
            return TRUE;
        }else{
            return FALSE;
        }

        /*$CI                     =   &	get_instance();
        $user_type              =       (!empty($user_details['user_type'])?$user_details['user_type']:'');
        $user_id                =       (isset($user_details['user_id']) && $user_details['user_id'] != ''?$user_details['user_id']:'') ;
       
        if(is_array($user_type)) {
            foreach($user_type as $key=>$val) {    
                $insert_pushnotification    =   array(
                    'notification_type'         =>   'push_notifications',
                    'user_type'                 =>   $val,
                    'user_id'                   =>   '',
                    'notification'              =>   $message,
                    'notification_link'         =>   $notification_link,
                    'class_id'                  =>   $class_id,
                    'school_id' => $CI->session->userdata('school_id')?$CI->session->userdata('school_id'):0
                );
                
            $rs         =   $CI->db->insert( 'notification' , $insert_pushnotification );
            }
        } else {
            $insert_pushnotification    =   array(
                'notification_type'         =>   'push_notifications',
                'user_type'                 =>   $user_type,
                'user_id'                   =>   $user_id,
                'notification'              =>   $message,
                'notification_link'         =>   $notification_link,
                'class_id'                  =>   $class_id,
                'school_id' => $CI->session->userdata('school_id')?$CI->session->userdata('school_id'):0
            );
            $rs         =   $CI->db->insert( 'notification' , $insert_pushnotification );
            
            if(isset($user_details['device_details'])) {
                send_mobile_pushnotification($message , $user_details['device_details']);
            }
        }
        
        if($rs)
            return TRUE;
        else
            return FALSE;*/
    }
    
    /*
     * Send mobile push notifications
     */
    function send_mobile_pushnotification( $message , $device_details ) {
        $url="http://".SMS_IP_ADDR."/School/index.php/?admin/send_push_notification_api/";
        if($device_details['device_token'] !='' && $device_details['server_key'] !='' && $device_details['instance'] !=''){
            $post=[
                'token'             =>  $device_details['device_token'] ,
                'server_key'        =>  $device_details['server_key'],
                'message'           =>  $message,
                'instance'          =>  $device_details['instance']
            ];
            fire_api_by_curl($url, $post);
            return TRUE;
        } else {
            return false;
        }
    }
    

    function create_passcode($type=''){
        if(!empty($type)){
            if($type==='parent'){
                $passcode = "spa" . mt_rand(10000000, 99999999);
                return $passcode;
            }else if($type==='admin'){
                $passcode = "sad" . mt_rand(10000000, 99999999);
                return $passcode;
            }else if($type==='teacher'){
                $passcode = "sta" . mt_rand(10000000, 99999999);
                return $passcode;
            }else if($type==='bus_driver'){
                $passcode = "dri" . mt_rand(10000000, 99999999);
                return $passcode;
            }else if($type==='student'){
                $passcode = "stu" . mt_rand(10000000, 99999999);
                return $passcode;
            }else if($type==='school_admin'){
                $passcode = "sch" . mt_rand(10000000, 99999999);
                return $passcode;
            }else if($type==='accountant'){
                $passcode = "sac" . mt_rand(10000000, 99999999);
                return $passcode;
            }else if($type==='cashier'){
                $passcode = "sca" . mt_rand(10000000, 99999999);
                return $passcode;
            }else if($type==='doctor'){
                $passcode = "dr" . mt_rand(10000000, 99999999);
                return $passcode;
            }
            else{
                return 'invalid';
            }            
        }else{
            return 'invalid';
        }
    }

    function send_custom_email($toEmail='',$subject='',$message='',$toName=""){

        if($toEmail=="" || $subject=="" || $message=="")
            return FALSE;
        
        $ci                     =   & get_instance();
        /******************loading models and controllers**************************/
        $ci->load->library('email');
        
        $settingsDataArr=get_data_generic_fun('settings','description',array('condition_type'=>'in','condition_in_col'=>'type','condition_in_data'=>'system_name,system_email'));

        $system_name            =  $settingsDataArr[0]->description;

        $from                   =  $settingsDataArr[0]->description;

        $from                   =   $settingsDataArr[1]->description;

        
        $config                 =   array();
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "ssl://smtp.gmail.com";
        $config['smtp_port'] = "465";
        $config['smtp_user'] = "sharadtechnologies.in@gmail.com"; 
        $config['smtp_pass'] = "Sharad10!";
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $config['crlf']    = "\n"; 
        $config['wordwrap'] = TRUE;
      
        $ci->email->initialize($config);
        //$ci->email->set_newline="\r\n";
        //$ci->email->crlf = "\n";
        //$ci->email->set_header('MIME-Version', '1.0; charset=utf-8'); //must add this line
        //$ci->email->set_header('Content-type', 'text/html'); //must add this line
        $ci->email->from($from, $system_name);        
        $ci->email->subject($subject);
        
        $ci->email->to($toEmail,$toName);
      //  $ci->email->reply_to('no-reply@sharadtechnologies.com','No Reply');
       // $body =$ci->load->view($view_name,$data,TRUE);
        $ci->email->message($message);        
        $r=$ci->email->send();
        if(!$r)        {
             return $rr=$ci->email->print_debugger();
        }else{
            return 1;
        }
    }

    function get_country_list(){
        $CI =&  get_instance();
        $CI->load->database();
        $CountryList  =  $CI->db->order_by('name', 'ASC')->get_where('country' , array('location_type' => 0))->result_array();        
        return $CountryList;
    }

    function get_ip_address(){
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }