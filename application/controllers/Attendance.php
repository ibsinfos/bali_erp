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
        //@date_default_timezone_set('Asia/Kolkata');
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


    //New Functions for machine
    function get_timing_status($timing=array(),$in=false,$out=false){
        $log_name = 'machine_activity_'.date('Y-m-d').'.log';
        generate_log("\n".'--Timing Check = '.json_encode($timing),$log_name);
        generate_log("\n".'--in = '.$in.', out = '.$out,$log_name); 
        generate_log("\n".'--in check = '.($in?'1':'0'),$log_name); 

        
        $in = $in?date('Y-m-d H:i',strtotime($in)):$in;
        $out = $out?date('Y-m-d H:i',strtotime($out)):$out;
        $in_fr = $timing['date'].' '.$timing['start_from'];
        $in_to = $timing['date'].' '.$timing['start_to'];
        $out_fr = $timing['date'].' '.$timing['end_from'];
        $out_to = $timing['date'].' '.$timing['end_to'];

        $status = 9;
        if($in && $out){
            if(($in>=$in_fr && $in<=$in_to) && ($out>=$out_fr && $out<=$out_to)){
                generate_log("\n".'--timing st = 1',$log_name); 
                $status = 1;    
            } else if(($in>=$in_fr && $in<=$in_to) && $out<$out_fr){
                generate_log("\n".'--timing st = 2',$log_name); 
                $status = 2;    
            }else if(($in>=$in_fr && $in<=$in_to) && $out>$out_to){
                generate_log("\n".'--timing st = 3',$log_name); 
                $status = 3;    
            }else if($in > $in_to && ($out>=$out_fr && $out<=$out_to)){
                generate_log("\n".'--timing st = 4',$log_name); 
                $status = 4;    
            }else if($in > $in_to && $out < $out_fr){
                generate_log("\n".'--timing st = 5',$log_name); 
                $status = 5;    
            }else if($in > $in_to && $out > $out_fr){
                generate_log("\n".'--timing st = 6',$log_name); 
                $status = 6;    
            }
        }else if($in && $out==false){
            generate_log("\n".'--timing st = 8',$log_name); 
            $status = 8;
        }else if($in==false && $out){
            generate_log("\n".'--timing st = 7',$log_name); 
            $status = 7;
        }
        return $status;
    }

    function time_match($timing=array(),$time=false,$start=true){
        $flag = false;
        $in_fr = $timing['date'].' '.$timing['start_from'];
        $in_to = $timing['date'].' '.$timing['start_to'];
        $out_fr = $timing['date'].' '.$timing['end_from'];
        $out_to = $timing['date'].' '.$timing['end_to'];
        if($start){
            if($time >= $in_fr && $time <=$in_to){
                $flag = true;
            }
        }else{
            if($time >= $out_fr && $time <=$out_to){
                $flag = true;
            }
        }
        return $flag;
    }

    function machine_data_post(){
        $log_name = 'machine_activity_'.date('Y-m-d').'.log';
        generate_log("\n\n\n ------------------------------------------------------------------------------------------------------------",$log_name);
        generate_log(date('Y-m-d H:i:s').': Request Started',$log_name);
        $IMEI = $this->post('IMEI');
        $Date = $this->post('Date');
        $dt = $this->post('dt');
        $d = $this->post('d');
        $RFID = $this->post('RFID');
        $RFID = str_replace(';','',ltrim($RFID, '0'));
        $timestrap = $this->post('timestamp');
        generate_log("\n".'--$RFID = ' . $RFID.' = Attendance/machine_data_post',$log_name);
        if (!empty($RFID)) {  
            $tRec = $this->db->get_where('teacher',array('card_id'=>$RFID))->row();
            generate_log("\n".'--Teacher Query = '.$this->db->last_query(),$log_name);
            generate_log("\n".'--Teacher Data = '.json_encode($tRec),$log_name);
            if($tRec){
                $this->session->set_userdata('school_id',$tRec->school_id);
                /* $curYr = $this->db->get_where('settings',array('type'=>'running_year'))->row();
                $curYear = $curYr?$curYr->description:date('Y').'-'.date('Y',strtotime('+1 Year')); */
                $curYear    =   sett('running_year');  
                $timing['date']       = date('Y-m-d');
                $timing['start_from'] = $start_from =   sett('startfrom');
                $timing['start_to']   = $start_to   =   sett('startto');
                $timing['end_from']   = $end_from   =   sett('endfrom');
                $timing['end_to']     = $end_to     =   sett('endto');
                $hasrec = $this->db->get_where('attendance_teacher',array('date'=>date('Y-m-d'),'teacher_id'=>$tRec->teacher_id))->row();
                generate_log("\n".'--Get attendance = '.$this->db->last_query(),$log_name);

                if($hasrec && $hasrec->has_in && $hasrec->has_out){
                    generate_log("\n".'--Attendance already recorded = '.$hasrec->in_time.','.$hasrec->out_time,$log_name);
                }

                $save_teacher_att = array('timezone'=>date_default_timezone_get(),
                                          'timestamp'=>time(),
                                          'date'=>date('Y-m-d'),
                                          'year'=>$curYear,
                                          'teacher_id'=>$tRec->teacher_id,
                                          'status'=>1,
                                          'school_id'=>$tRec->school_id);
                if(!$hasrec){//&& $this->time_match($timing,date('Y-m-d H:i'))){
                    $save_teacher_att['has_in'] = 1;  
                    $save_teacher_att['in_time'] = date('Y-m-d H:i:s');  

                    $timing_status = $this->get_timing_status($timing,$save_teacher_att['in_time']);
                    generate_log("\n".'--get timing st = '.$timing_status,$log_name);

                    $save_teacher_att['timing_status'] = $timing_status;  
                }else{
                    $buffer_time = sett('rfid_attendance_buffer_time');
                    $mintue =  round(abs(time() - strtotime($hasrec->in_time)) / 60,2);
                    if($mintue < $buffer_time){
                        echo json_encode(array('type' => 'fail', 'message' => ('in buffer time '.$buffer_time)));exit;
                    }
                
                    $save_teacher_att['has_out'] = 1;  
                    $save_teacher_att['out_time'] = date('Y-m-d H:i:s');
                    
                    $timing_status = $this->get_timing_status($timing,($hasrec?$hasrec->in_time:false),$save_teacher_att['out_time']);
                    generate_log("\n".'--get timing st = '.$timing_status,$log_name);
                    $save_teacher_att['timing_status'] = $timing_status;  
                }                          

                if(!$hasrec){
                    $flag = $this->db->insert('attendance_teacher',$save_teacher_att);
                }else{
                    $flag = $this->db->update('attendance_teacher',$save_teacher_att,array('attendance_id'=>$hasrec->attendance_id));
                }
                generate_log("\n".'--$insertAttendanceSQL : '.$this->db->last_query(),$log_name);
                
                $sch_phone = sett('phone');
                generate_log("\n".'--Phone no for teacher attendance: '.$sch_phone,$log_name);
                $post = [
                    'location' => 'india',
                    'cell_phone' => $sch_phone,
                    'message' => 'Dear sir, Attendance For '.$tRec->name.' has been marked present on '.date('H:i A')
                ];
                generate_log("\n --".json_encode($post),$log_name);
                $url = 'http://'.SMS_IP_ADDR.'/School/index.php/?admin/send_common_sms/';
                fire_api_by_curl($url,$post);
                echo json_encode(array('type' => 'ok', 'message' => 'attendance added successfully'));
            }else{ 
                $sRec = $this->db->get_where('student',array('card_id'=>$RFID))->row();
                generate_log("\n".'--Student Query = '.$this->db->last_query(),$log_name);
                generate_log("\n".'--Student Data = '.json_encode($sRec),$log_name);

                if($sRec){
                    $this->session->set_userdata('school_id',$sRec->school_id);
                    $curYear    =   sett('running_year');  
                    $timing['date']       = $date       = date('Y-m-d');
                    $timing['start_from'] = $start_from =   sett('startfrom');
                    $timing['start_to']   = $start_to   =   sett('startto');
                    $timing['end_from']   = $end_from   =   sett('endfrom');
                    $timing['end_to']     = $end_to     =   sett('endto');
                    $hasrec = $this->db->get_where('attendance',array('date'=>date('Y-m-d'),'student_id'=>$sRec->student_id))->row();
                    generate_log("\n".'--Get Attendance = '.json_encode($hasrec),$log_name);
                    if($hasrec && $hasrec->has_in && $hasrec->has_out){
                        generate_log("\n".'--Attendance already recorded = '.$hasrec->in_time.','.$hasrec->out_time,$log_name);
                    }
    
                    generate_log("\n".'--$st_time : '.$start_from.' == $end_time : '.$start_to.' == $st_timeo : '.$end_from.' == $end_timeo : '.
                                $end_from.' current_time:'.$end_to,$log_name);

                    _school_cond('S.school_id',$sRec->school_id);
                    _year_cond('E.year',$curYear);
                    $this->db->select('S.*,E.class_id,E.section_id,C.name class_name,SC.name section_name,E.enroll_code,E.date_added,
                                      P.father_name,P.father_lname,P.mother_name,P.mother_lname,P.email parent_email,P.cell_phone parent_phone,
                                      P.device_token',false);  
                    $this->db->from('student S');
                    $this->db->join('enroll E','E.student_id=S.student_id','LEFT'); 
                    $this->db->join('class C','C.class_id=E.class_id','LEFT');  
                    $this->db->join('section SC','SC.section_id=E.section_id','LEFT');  
                    $this->db->join('parent P','P.parent_id=S.parent_id','LEFT');
                    $this->db->where('S.student_id',$sRec->student_id);
                    $sRecord = $this->db->get()->row(); 
                    generate_log("\n".'--Stu Record Query = '.$this->db->last_query(),$log_name);
                    generate_log("\n".'--Stu Record Data = '.json_encode($sRecord),$log_name);
                    
                    $save_att = array('timezone'=>date_default_timezone_get(),
                                      'timestamp'=>time(),
                                      'date'=>$date,
                                      'year'=>$curYear,
                                      'class_id'=>$sRecord->class_id,
                                      'section_id'=>$sRecord->section_id,
                                      'student_id'=>$sRecord->student_id,
                                      'status'=>1,
                                      'school_id'=>$sRecord->school_id);
                    if(!$hasrec){ //&& $this->time_match($timing,date('Y-m-d H:i'))){
                        $save_att['has_in'] = 1;  
                        $save_att['in_time'] = date('Y-m-d H:i:s');  

                        $timing_status = $this->get_timing_status($timing,$save_att['in_time']);
                        generate_log("\n".'--get timing st = '.$timing_status,$log_name);

                        $save_att['timing_status'] = $timing_status;  
                    }else{
                        $buffer_time = sett('rfid_attendance_buffer_time');
                        $mintue =  round(abs(time() - strtotime($hasrec->in_time)) / 60,2);
                        if($mintue < $buffer_time){
                            echo json_encode(array('type' => 'fail', 'message' => ('in buffer time '.$buffer_time)));exit;
                        }    

                        $save_att['has_out'] = 1;  
                        $save_att['out_time'] = date('Y-m-d H:i:s');  
                        
                        $timing_status = $this->get_timing_status($timing,($hasrec?$hasrec->in_time:false),$save_att['out_time']);
                        generate_log("\n".'--get timing st = '.$timing_status,$log_name);

                        $save_att['timing_status'] = $timing_status;  
                    }                          

                    if(!$hasrec){
                        $flag = $this->db->insert('attendance',$save_att);
                    }else{
                        $flag = $this->db->update('attendance',$save_att,array('attendance_id'=>$hasrec->attendance_id));
                    }
                    generate_log("\n".'--$insertAttendanceSQL : '.$this->db->last_query(),$log_name);

                    //Get Device
                    $deviceRec = $this->db->get_where('device',array('Imei'=>$IMEI))->row();
                    generate_log("\n".'--$sql for $deviceQuery :'.$this->db->last_query(),$log_name);
                   
                    $serverKey = sett('fcm_server_key');
                    generate_log("\n".'--all notification data : $deviceLocation : '.$deviceRec->Location.',
                                            cell_phone : '.$sRecord->parent_phone.',$dt : '.$date.',gender : '.$sRecord->gender.',
                                            email : '.$sRecord->parent_email.',parent_id : '.$sRecord->parent_id.",
                                            device_token :".$sRecord->device_token.",fcm_servver key : ".$serverKey,$log_name);
                    $this->send_all_notification_by_global_server($deviceRec->Location, $sRecord->parent_phone, $date, $sRecord->gender, $sRecord->name, 
                                    $sRecord->parent_email, $sRecord->parent_id, $sRecord->device_token,$serverKey);
                    echo json_encode(array('type' => 'ok', 'message' => 'attendance added successfully'));
                } else {
                    set_machin_active_log('RFID received blank');
                    echo json_encode(array('type' => 'fail', 'message' => 'no student found '.$this->db->last_query()));
                }
            }
        } else {
            set_machin_active_log('No RFID data from machine '." = Attendance/machince_data_post");
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