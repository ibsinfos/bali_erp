<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
class Attendance extends REST_Controller{
    function __construct($config = 'rest1') {
        parent::__construct($config);
        $this->load->database();
        //$this->load->model('Master_data_model');
    }

    function machince_attendance_post(){
        //@mail('jsahoo@du.sharadtechnologies.com','calling at machince_attendance_post ','calling at machince_attendance_post');
        //$this->send_test_sms('calling at machince_attendance_post');
        $IMEI=  $this->post("IMEI");
        $Date=  $this->post("Date");
        $dt=  $this->post("dt");
        $d=  $this->post("d");
        $RFID=  $this->post("RFID");
        $timestrap=  $this->post("timestamp");
        $a = $this->db;
        set_machin_active_log('$RFID = ' . $RFID." = Attendance/machince_attendance_post");
        set_machin_active_log('now default time zone is Asia/Kolkata'." = Attendance/machince_attendance_post");
        @date_default_timezone_set('Asia/Kolkata');
        if ($RFID!="") {
            //@mail('jsahoo@du.sharadtechnologies.com','calling at machince_attendance_post with $RFID '.$RFID,'calling at machince_attendance_post wiith - $RFID : '.$RFID);
            //$this->send_test_sms('calling at machince_attendance_post with $RFID = '.$RFID);
            $sqlSettings="SELECT * FROM `settings` WHERE `type`='running_year'";
            $rsSettings=$a->query($sqlSettings)->result();
            $objSettings=$rsSettings[0];
            $sqlTeacher="SELECT * FROM `teacher` WHERE `card_id`=$RFID";
            $rsTeacher=$a->query($sqlTeacher)->result();
            if(!empty($rsTeacher)){
                $obj=$rsTeacher[0];
                $insertAttendanceSQL = "INSERT INTO `attendance_teacher`(`status`, `teacher_id`, `timestamp`,`year`,`school_id`) 
                                VALUES ('1','$obj->teacher_id','$timestrap','$objSettings->description','$objSettings->school_id') ON DUPLICATE KEY UPDATE status=1 ";
                set_machin_active_log('$insertAttendanceSQL : '.$insertAttendanceSQL);
                $a->query($insertAttendanceSQL);
                $dateTime = new DateTime('now', new DateTimeZone('Asia/Kolkata')); 
                $timeAMPM=$dateTime->format("H:i A");
                $sqlSettings="SELECT * FROM `settings` WHERE `type`='phone'";
                $rsSettings=$a->query($sqlSettings)->result();
                $objSettings=$rsSettings[0];
                set_machin_active_log("Phone no for teacher attendance : ".json_encode($objSettings));
                $post = [
                'location' => 'india',
                'cell_phone' => $objSettings->description,
                'message' => "Dear sir, Attendance For $obj->name has been marked present on $timeAMPM" ,
                ];
                set_machin_active_log(json_encode($post));
                //echo print_r($post);exit;
                $url = "http://".SMS_IP_ADDR."/School/index.php/?admin/send_common_sms/";
                fire_api_by_curl($url,$post);
            }else{ 
                //$this->send_test_sms('calling at machince_attendance_post as student');
                //@mail('jsahoo@du.sharadtechnologies.com','calling at machince_attendance_post as student ','calling at machince_attendance_post as student');
                $sql = "SELECT `enroll`.`school_id`,`enroll`.`student_id`, `student`.`name` ,`parent`.`cell_phone`, `parent`.`gender`,`parent`.`email`,`parent`.`parent_id`,`class_id`, `section_id`, `year`,`parent`.`device_token`
                        FROM `student` ,`parent`,`enroll` WHERE `student`.`parent_id`=`parent`.`parent_id` AND `enroll`.`student_id`=`student`.`student_id` AND `card_id`=$RFID";
                set_machin_active_log('$sql for student and parrent details :'.$sql." = Attendance/machince_attendance_post");
                $result = $a->query($sql)->result();
                if (!empty($result)) {
                    $obj = $result[0];
                    /*$sqlCheckTimming="SELECT `description` FROM `settings` WHERE `type` IN ('startfrom','startto','endfrom','endto')";
                    $rsCheckTimming = $this->db->query($sqlCheckTimming)->result();
                    foreach ($rsCheckTimming as $rowCheckTimming){
                        $resultsCheckTimming[] = $rowCheckTimming->description;
                    }
                    $startfrom=$resultsCheckTimming[0];
                    $startto=$resultsCheckTimming[1];
                    $endfrom=$resultsCheckTimming[2];
                    $endto=$resultsCheckTimming[3];
                    $st_time    =   strtotime($startfrom);
                    $end_time   =   strtotime($startto);
                    $st_timeo    =   strtotime($endfrom);
                    $end_timeo   =   strtotime($endto);
                    $time = date("G:i");
                    set_machin_active_log('$time : '.$time);
                    $cur_time   =   strtotime($time);
                     * 
                     */
                    $sqlCheckTimming="SELECT `description` FROM `settings` WHERE `type` IN ('startfrom','startto','endfrom','endto')";
        
                    set_machin_active_log($sqlCheckTimming);
                    set_machin_active_log('selected db name '.$this->db->database);
                    $rsCheckTimming = $this->db->query($sqlCheckTimming)->result();
                    set_machin_active_log(json_encode($rsCheckTimming));
                    if(count($rsCheckTimming)==0){
                        return FALSE;
                    }else{
                        $resultsCheckTimming=array();
                        foreach ($rsCheckTimming as $rowCheckTimming){
                            $resultsCheckTimming[] = $rowCheckTimming->description;
                        }
                        $startfrom=$resultsCheckTimming[0];
                        $startto=$resultsCheckTimming[1];
                        $endfrom=$resultsCheckTimming[2];
                        $endto=$resultsCheckTimming[3];
                                    $now = new Datetime("NOW");
                        $st_time    =  new Datetime($startfrom);
                        $end_time   =   new Datetime($startto);
                        $st_timeo    =   new Datetime($endfrom);
                        $end_timeo   =   new Datetime($endto);

                        set_machin_active_log('$st_time : '.serialize($st_time).' == $end_time : '.serialize($end_time).' == $st_timeo : '.serialize($st_timeo).' == $end_timeo : '.serialize($end_timeo).'current_time:'.serialize($now));

                        $time = date("G:i");
                        set_machin_active_log('$time : '.$time);
                        $cur_time   =   strtotime($time);
                        set_machin_active_log('$cur_time : '.$cur_time);
                        
                        $activity='';
                        if($now > $st_time && $now < $end_time){
                                $activity = "has entered into";
                        }elseif($now > $st_timeo && $now < $end_timeo){
                                $activity = " has exit out";
                        }
                        //$this->send_test_sms('calling at machince_attendance_post as student $activity : '.$activity);
                        if($activity!=''){
                            set_machin_active_log('$activity : '.$activity ."  == data at attendance conroller ");
                            $obj = $result[0];
                            $insertAttendanceSQL = "INSERT INTO `attendance`(`status`, `student_id`, `timestamp`,`year`, `class_id`, `section_id`,`school_id`) 
                            VALUES ('1','$obj->student_id','$timestrap','$obj->year','$obj->class_id','$obj->section_id','$obj->school_id') ON DUPLICATE KEY UPDATE    
                                    status=1 ";
                            //$this->send_test_sms('attendance insert = '.$insertAttendanceSQL);
                            set_machin_active_log('$sql for student attendance :'.$insertAttendanceSQL." = Attendance/machince_attendance_post");
                            $a->query($insertAttendanceSQL);
                        }else{
                            set_machin_active_log('$activity is blank'." = Attendance/machince_attendance_post");
                            set_machin_active_log("No attendance mark for student due to wrong timing.");
                        }
                    }
                    
                    /*if(($st_time > $cur_time && $st_timeo > $cur_time)|| ($end_time > $cur_time && $end_timeo>$cur_time)){
                        $insertAttendanceSQL = "INSERT INTO `attendance`(`status`, `student_id`, `timestamp`,`year`, `class_id`, `section_id`) 
                            VALUES ('1','$obj->student_id','$timestrap','$obj->year','$obj->class_id','$obj->section_id') ON DUPLICATE KEY UPDATE    
                                    status=1 ";
                        set_machin_active_log('$sql for student attendance :'.$insertAttendanceSQL);
                        $a->query($insertAttendanceSQL);
                    }elseif($st_timeo < $cur_time || $end_timeo > $cur_time){
                        if($cur_time < $st_timeo){
                            return FALSE;
                        }else{
                            $insertAttendanceSQL = "INSERT INTO `attendance`(`status`, `student_id`, `timestamp`,`year`, `class_id`, `section_id`) 
                                VALUES ('1','$obj->student_id','$timestrap','$obj->year','$obj->class_id','$obj->section_id') ON DUPLICATE KEY UPDATE    
                                        status=1 ";
                        set_machin_active_log('$sql for student attendance :'.$insertAttendanceSQL);
                        $a->query($insertAttendanceSQL);
                        }
                    }*/
                    

                    $deviceQuery = $a->query("SELECT `Location` FROM `device` WHERE `Imei`=" . $IMEI)->result();
                    set_machin_active_log('$sql for $deviceQuery :'."SELECT `Location` FROM `device` WHERE `Imei`=" . $IMEI);
                    foreach ($deviceQuery as $deviceRow) {
                        $deviceLocation = $deviceRow->Location;
                    }
                    $sql_server_key="SELECT `description` FROM `settings` WHERE `type`='fcm_server_key'";
                    $server_key_arr=$a->query($sql_server_key)->result();
                    set_machin_active_log('all notification data : $deviceLocation : '.$deviceLocation.',cell_phone : '.$obj->cell_phone.',$dt : '.$dt.',gender : '.$obj->gender.',email : '.$obj->email.',parent_id : '.$obj->parent_id.",device_token :".$obj->device_token.",fcm_servver key : ".$server_key_arr[0]->description);
                    $this->send_all_notification_by_global_server($deviceLocation, $obj->cell_phone, $dt, $obj->gender, $obj->name, $obj->email, $obj->parent_id,$obj->device_token,$server_key_arr[0]->description);
                    echo json_encode(array('type' => 'ok', 'message' => 'attendance added successfully'));
                } else {
                    set_machin_active_log('RFID received blank');
                    echo json_encode(array('type' => 'fail', 'message' => "no student found " . PHP_EOL . "SELECT `enroll`.`student_id`, `student`.`name` ,`parent`.`cell_phone`, `parent`.`gender`,`parent`.`email`,`parent`.`parent_id`,`class_id`, `section_id`, `year`
                        FROM `student` ,`parent`,`enroll` WHERE `student`.`parent_id`=`parent`.`parent_id` AND `enroll`.`student_id`=`student`.`student_id` AND `card_id`=$RFID"));
                }
            }
        } else {
            
            //@mail('jsahoo@du.sharadtechnologies.com','calling at machince_attendance_post at error part','calling at machince_attendance_post at error part');
            set_machin_active_log('No RFID data from machine '." = Attendance/machince_attendance_post");
            echo json_encode(array('type' => 'fail', 'message' => 'RFID received blank'));
        }
    }
    
    function send_all_notification_by_global_server($deviceLocation,$cell_phone,$dt,$gender,$name,$email,$parent_id,$device_token,$fcm_server_key){
        $post = [
                    'deviceLocation' => $deviceLocation,
                    'cell_phone' => $cell_phone,
                    'dt'   => $dt,
                    'gender' => $gender,
                    'name'    => $name,
                    'email' =>$email,
                    'parent_id'=>$parent_id,
                    'device_token'=>$device_token,
                    'fcm_server_key'=>$fcm_server_key,
                    'instance'=>CURRENT_INSTANCE,
                    'sender_id'=>'madaan',
                    ];
        $url="http://".SMS_IP_ADDR."/School/index.php/?admin/send_all_notification_to_parrent_about_student/";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        set_machin_active_log('starting curl execute '.PHP_EOL);
        // execute!
        $response = curl_exec($ch);
        set_machin_active_log('getting cURL '.$url.' response '.$response.PHP_EOL);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    }
    
    
}