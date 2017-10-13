<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Cli_controller extends CI_Controller{
    
    
    function __construct() {
        parent::__construct();
        // If cronjob ! 
        //is_cli() OR show_404();
        
        ini_set('max_execution_time', 0); 
        ini_set('memory_limit', '-1');      
        // Expand the array displays
        ini_set('xdebug.var_display_max_depth', 5);
        ini_set('xdebug.var_display_max_children', 256);
        ini_set('xdebug.var_display_max_data', 1024);
    }
    
    function make_empty_google_drive(){
        error_reporting(E_ALL);
        @ini_set("display_errors", 1);
        
        $this->load->library("Google_drive_backup_machine");
        $this->google_drive_backup_machine->init(GOOGLE_DRIVE_CLIENT_ID,GOOGLE_DRIVE_SERVICE_ACCOUNT_NAME,CERTIFICA_PATH.GOOGLE_DRIVE_PRIVATE_KEY_PATH);
        $folerName=date('d-m-Y').'_back_up';
        //die($folerName);
        //shared-with-me
        $folderId=$this->google_drive_backup_machine->getFileIdByName($folerName);
        //echo '$folderId : '.$folderId;die;
        if( ! $folderId ) {
            //generate_log("creating a foler ","create_back_up_google_drive_".CURRENT_INSTANCE.".log");
            //echo "Creating folder...\n";
            $folderId = $this->google_drive_backup_machine->createFolder( GOOGLE_DRIVE_BACKUP_FOLDER );
            $this->google_drive_backup_machine->setPermissions( $folderId, GOOGLE_DRIVE_SHARE_WITH_GOOGLE_EMAIL );
            //generate_log("Folder created in google drive ".GOOGLE_DRIVE_SHARE_WITH_GOOGLE_EMAIL,"create_back_up_google_drive_".CURRENT_INSTANCE.".log");
        }else{
            //$folderId = $this->google_drive_backup_machine->createFolder( GOOGLE_DRIVE_BACKUP_FOLDER."1" );
            //$this->google_drive_backup_machine->setPermissions( $folderId, GOOGLE_DRIVE_SHARE_WITH_GOOGLE_EMAIL );
            //generate_log("working with existing folder in google drive in elsee part ".GOOGLE_DRIVE_SHARE_WITH_GOOGLE_EMAIL." at google drivev ".GOOGLE_DRIVE_BACKUP_FOLDER."2","create_back_up_google_drive_".CURRENT_INSTANCE.".log");
        }
        
    }
    
    function create_back_up_google_drive(){
        error_reporting(E_ALL);
        @ini_set("display_errors", 1);
        //@mail("sharatechnologes.in@mail.com","mail set ".date("d-m-Y H:i:s"),"action start at ".date("d-m-Y H:i:s"));
        $backupFile= $this->create_mysql_back_up_current_db();
        //echo $backupFile;die;
        $path=MY_SQLI_DB_BACKUP_FOLDER.$backupFile;
        //echo $path;die;
        generate_log("creating the path : ".$path,"create_back_up_google_drive_".CURRENT_INSTANCE.".log");
        $folerName=date('d-m-Y').'_back_up';
        $folderId=$this->google_drive_backup_machine->getFileIdByName($folerName);
        
        if(file_exists($path)){
            /// sending file to google drive
            $this->load->library("Google_drive_backup_machine");
                    
            /*$service = new DriveServiceHelper( CLIENT_ID, SERVICE_ACCOUNT_NAME, KEY_PATH );

            $folderId = $service->getFileIdByName( BACKUP_FOLDER );

            if( ! $folderId ) {
                    echo "Creating folder...\n";
                    $folderId = $service->createFolder( BACKUP_FOLDER );
                    $service->setPermissions( $folderId, SHARE_WITH_GOOGLE_EMAIL );
            }

            $fileParent = new Google_ParentReference();
            $fileParent->setId( $folderId );

            $fileId = $service->createFileFromPath( $path, $path, $fileParent );

            printf( "File: %s created\n", $fileId );

            $service->setPermissions( $fileId, SHARE_WITH_GOOGLE_EMAIL );*/
            generate_log("init google drive library","create_back_up_google_drive_".CURRENT_INSTANCE.".log");
            $this->google_drive_backup_machine->init(GOOGLE_DRIVE_CLIENT_ID,GOOGLE_DRIVE_SERVICE_ACCOUNT_NAME,CERTIFICA_PATH.GOOGLE_DRIVE_PRIVATE_KEY_PATH);
            generate_log("collecting folderId","create_back_up_google_drive_".CURRENT_INSTANCE.".log");
            generate_log("searching Folder in google drive as : ".GOOGLE_DRIVE_BACKUP_FOLDER,"create_back_up_google_drive_".CURRENT_INSTANCE.".log");
            //$folderId=$this->google_drive_backup_machine->getFileIdByName(GOOGLE_DRIVE_BACKUP_FOLDER."2" );
            $folderId=$this->google_drive_backup_machine->getFileIdByName("test" );
            generate_log("collecting $folderId done.","create_back_up_google_drive_".CURRENT_INSTANCE.".log");
            //$getParent= $this->getParent($folderId);
            if( ! $folderId ) {
                generate_log("creating a foler ","create_back_up_google_drive_".CURRENT_INSTANCE.".log");
                //echo "Creating folder...\n";
                $folderId = $this->google_drive_backup_machine->createFolder( GOOGLE_DRIVE_BACKUP_FOLDER );
                $this->google_drive_backup_machine->setPermissions( $folderId, GOOGLE_DRIVE_SHARE_WITH_GOOGLE_EMAIL );
                generate_log("Folder created in google drive ".GOOGLE_DRIVE_SHARE_WITH_GOOGLE_EMAIL,"create_back_up_google_drive_".CURRENT_INSTANCE.".log");
            }else{
                //$folderId = $this->google_drive_backup_machine->createFolder( GOOGLE_DRIVE_BACKUP_FOLDER."1" );
                //$this->google_drive_backup_machine->setPermissions( $folderId, GOOGLE_DRIVE_SHARE_WITH_GOOGLE_EMAIL );
                generate_log("working with existing folder in google drive in elsee part ".GOOGLE_DRIVE_SHARE_WITH_GOOGLE_EMAIL." at google drivev ".GOOGLE_DRIVE_BACKUP_FOLDER."2","create_back_up_google_drive_".CURRENT_INSTANCE.".log");
            }
            
            generate_log("collecting file id withgoogle drive.","create_back_up_google_drive_".CURRENT_INSTANCE.".log");
            $fileParent=$this->google_drive_backup_machine->fileParent($folderId);
            //pre($fileParent);die;
            generate_log("collecting fileParent withgoogle drive.","create_back_up_google_drive_".CURRENT_INSTANCE.".log");
            $fileId = $this->google_drive_backup_machine->createFileFromPath( $path, $path, $fileParent );
            generate_log("collecting fileId withgoogle drive.".$fileId,"create_back_up_google_drive_".CURRENT_INSTANCE.".log");
            $this->google_drive_backup_machine->setPermissions( $fileId, GOOGLE_DRIVE_SHARE_WITH_GOOGLE_EMAIL );
            generate_log("Google drive backup done.","create_back_up_google_drive_".CURRENT_INSTANCE.".log");
        }
    }
    
    function create_mysql_back_up_current_db(){
        generate_log("calling create_mysql_back_up_current_db.log()","create_mysql_back_up_current_db_".CURRENT_INSTANCE.".log");
        date_default_timezone_set('Asia/Calcutta');
        $backupFilename='backup_'.date('d_m_Y').'.sql';
        // Load the DB utility class 
        /*        $this->load->dbutil(); 
        
        generate_log("file name : ".$backupFilename,"create_mysql_back_up_current_db.log");
        $prefs = array( 'format' => 'txt', // gzip, zip, txt 
                                 'filename' =>$backupFilename , 
                                                        // File name - NEEDED ONLY WITH ZIP FILES 
                                  'add_drop' => TRUE,
                                                       // Whether to add DROP TABLE statements to backup file
                                 'add_insert'=> TRUE,
                                                      // Whether to add INSERT data to backup file 
                                 'newline' => "\n"
                                                     // Newline character used in backup file 
                                ); 
        generate_log("setting init for backup for mysql db : ","create_mysql_back_up_current_db.log");
         // Backup your entire database and assign it to a variable 
         $backup =$this->dbutil->backup($prefs); */
        $backup =   $this->sharadtechnologies_db_backup_system();
         // Load the file helper and write the file to your server 
         generate_log("helper init for save the backup data to SQL : ","create_mysql_back_up_current_db_".CURRENT_INSTANCE.".log");
         $this->load->helper('file'); 
         generate_log("back_up_file_full_path : ".MY_SQLI_DB_BACKUP_FOLDER.$backupFilename,"create_mysql_back_up_current_db_".CURRENT_INSTANCE.".log");
         write_file(MY_SQLI_DB_BACKUP_FOLDER.$backupFilename, $backup);
         generate_log("going back to main function : ","create_mysql_back_up_current_db_".CURRENT_INSTANCE.".log");
         return $backupFilename;
    }
    
    function sharadtechnologies_db_backup_system(){
        $this->load->dbutil();
        $tables         =       $this->db->list_tables(); 
        $statement_values   =   '';
        $statement_values   .=   'SET @TRIGGER_BEFORE_INSERT_CHECKS = FALSE;'.PHP_EOL;
        $statement_values   .=   'SET @TRIGGER_AFTER_INSERT_CHECKS = FALSE;'.PHP_EOL;
        $statement_values   .=   'SET @TRIGGER_BEFORE_UPDATE_CHECKS = FALSE;'.PHP_EOL;
        $statement_values   .=   'SET @TRIGGER_AFTER_UPDATE_CHECKS = FALSE;'.PHP_EOL;
        $statement_values   .=   'SET @TRIGGER_BEFORE_DELETE_CHECKS = FALSE;'.PHP_EOL;
        $statement_values   .=   'SET @TRIGGER_AFTER_DELETE_CHECKS = FALSE;'.PHP_EOL;
        $statement_values   .=   'SET FOREIGN_KEY_CHECKS=0;'.PHP_EOL;
        $statement_query    =   '';
        $prev_table_name="";
        $skipTableBackupArr=array('member','member1');
        $skipTableArr=array();
        foreach ($tables as $table_names){
            generate_log("start for ".$table_names,"database_data_backup_log_".CURRENT_INSTANCE.".log");
            if(in_array($table_names, $skipTableBackupArr)){
                continue;
            }
            if(!in_array($table_names, $skipTableArr)){
                if($table_names=='main_currency'){
                    $statement_values.=PHP_EOL."TRUNCATE TABLE `tm_projects`;".PHP_EOL;
                    $statement_values.=PHP_EOL."TRUNCATE TABLE `tm_emp_timesheets`;".PHP_EOL;
                }
                $statement_values.=PHP_EOL."TRUNCATE TABLE `".$table_names."`;".PHP_EOL;
            }
            generate_log("just before taking data from table get_data_generic_fun(): ".$table_names,"database_data_backup_log_".CURRENT_INSTANCE.".log");
            $statement =  get_data_generic_fun($table_names,'*',array(),'result_arr');
            if(!empty($statement)){
                foreach ($statement as $key => $post) {
                    if(isset($statement_values)) {
                        $statement_values .= "\n";
                    }
                    $values = array_values($post);
                    foreach($values as $index => $value) {
                        $quoted = str_replace("'","\'",str_replace('"','\"', $value));
                        $values[$index] = (!isset($value) ? 'NULL' : "'" . $quoted."'") ;
                    }
                $statement_values .="insert into ".$table_names." values "."(".implode(',',$values).");";
                }
                generate_log("get_data_generic_fun() return data for : ".$table_names." ==== ".$statement_values,"database_data_backup_log_".CURRENT_INSTANCE.".log");
            }else{
                generate_log("get_data_generic_fun() return no data : ".$table_names,"database_data_backup_log_".CURRENT_INSTANCE.".log");
            }
            $statement = $statement_values . ";";     
        }
        $statement_values   .=   PHP_EOL.'SET @TRIGGER_BEFORE_INSERT_CHECKS = TRUE;'.PHP_EOL;
        $statement_values   .=   'SET @TRIGGER_AFTER_INSERT_CHECKS = TRUE;'.PHP_EOL;
        $statement_values   .=   'SET @TRIGGER_BEFORE_UPDATE_CHECKS = TRUE;'.PHP_EOL;
        $statement_values   .=   'SET @TRIGGER_AFTER_UPDATE_CHECKS = TRUE;'.PHP_EOL;
        $statement_values   .=   'SET @TRIGGER_BEFORE_DELETE_CHECKS = TRUE;'.PHP_EOL;
        $statement_values   .=   'SET @TRIGGER_AFTER_DELETE_CHECKS = TRUE;'.PHP_EOL;
        $statement_values   .=   'SET FOREIGN_KEY_CHECKS=1;'.PHP_EOL;
        $backup         =   $statement_values;
        
        return $backup;
        
        /*$date = date('d-m-Y-H-i-s', time());
        $this->load->helper('file');
        write_file('mysql_backup/mybackup-'.$date.'.sql', $backup);
        // Load the download helper and send the file to your desktop
        $this->load->helper('download');*/
    }
    
    /**
     * 
     */
    function sending_mail(){
        $this->load->library('email');
        
        $config                 =   array();
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "ssl://smtp.gmail.com";
        $config['smtp_port'] = "465";
        $config['smtp_user'] = "sharadtechnologies.in@gmail.com"; 
        $config['smtp_pass'] = "Sharad1!";
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $config['crlf']    = "\n"; 
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
    
    /*
     * Send notification in queue
     */
    public function send_notification_inqueue() {
        $notification_queue         =   get_data_generic_fun('notification_queue','*',array('status' => 1),'result_array');
        if(count($notification_queue)>=1) {
            foreach($notification_queue as $notification) {

                $notif_type                     =   $notification['notification_type'];
                $message['sms_message']         =   $notification['message'];
                $message['subject']             =   $notification['message_subject'];
                $message['messagge_body']       =   $notification['message_body'];

                $this->send_notification_toall( $notif_type , $message );

                $this->load->model("Notification_model");
                $data                   =       array('status' => 5);
                $condition              =       array( 'queue_id' => $notification['queue_id']);
                $update_status          =       $this->Notification_model->update_notification_queue( $data , $condition );
            }
        }
        $json_response              =   array('status'=>"success");
//        print_r(json_encode($json_response));
        exit;
    }

    /*
    * Send notification to all users (parents,students,teachers)
    * @param $notification type
    * @param $message array()
    */
    public function send_notification_toall( $notifi_type , $message ) {
        // notification sending configurations
        $this->load->helper("send_notifications");

        $parents        =   $this->db->get('parent')->result_array();
        $students       =   $this->db->get('student')->result_array();
        $teachers       =   $this->db->get('teacher')->result_array();
        
        foreach ($parents as $row) {
            $message['to_name']             =       $row['father_name']." ".$row['father_lname'];
            $reciever_phone                 =       $row['cell_phone'];
            $phone                          =       array($reciever_phone);
            $email                          =       array($row['email']);

            send_school_notification( $notifi_type , $message ,  $phone , $email );
        }

        foreach ($students as $row) {
            $message['to_name']             =       $row['name']." ".$row['lname'];
            $reciever_phone                 =       $row['phone'];
            $phone                          =       array($reciever_phone);
            $email                          =       array($row['email']);
            send_school_notification( $notifi_type , $message ,  $phone , $email );
        }

        foreach ($teachers as $row) {
            $message['to_name']             =       $row['name']." ".$row['last_name'];
            $reciever_phone                 =       $row['cell_phone'];
            $phone                          =       array($reciever_phone);
            $email                          =       array($row['email']);

            send_school_notification( $notifi_type , $message ,  $phone , $email );
        }
        
        return true;
    }
    
    /**
     * @url : http://52.29.203.220/beta/index.php?cli_controller/clear_log
     * @time : at mid night of  7th,14th,21st,28th of every month
     * 
     */
    function clear_log(){
        $date=date("d");
        if(in_array($date, array("07","14","21","28"))){
            echo 'in_array '.PHP_EOL;
            for($i=$date-8;$i>$date-15;$i--){
                echo '$date inside for loop '.$date.PHP_EOL;
                if($i<10){
                    $cDate="0".$i;
                }else{
                    $cDate=$i;
                }
                echo '$cDate = '.$cDate.PHP_EOL;
                $fileName0="generate_log_".date("Y")."-".date('m')."-".$cDate."_log.log";
                $filePath0="/var/www/html/".$fileName0;
                echo '$filePath0 = '.$filePath0.PHP_EOL;
                if(file_exists($filePath0)){
                    echo '$filePath0 exist going to delete '.PHP_EOL;
                    if(@unlink($filePath0))
                        echo '$filePath0 deleted success '.PHP_EOL;
                    else
                        echo '$filePath0 unable too delete '.PHP_EOL;
                }
                
                $fileName00="machichine_activity_".date("Y")."-".date('m')."-".$cDate."_log.log";;
                $filePath00="/var/www/html/".$fileName00;
                echo '$filePath00 = '.$filePath00.PHP_EOL;
                if(file_exists($filePath00)){
                    echo '$filePath00 exist going to delete '.PHP_EOL;
                    if(@unlink($filePath00))
                        echo '$filePath00 deleted success '.PHP_EOL;
                    else
                        echo '$filePath0 unable too delete '.PHP_EOL;
                }
                
                $fileName1="machichine_activity_".date("Y")."-".date('m')."-".$cDate."_log.log";
                $filePath1="/var/www/html/School/".$fileName1;
                echo '$filePath1 = '.$filePath1.PHP_EOL;
                if(file_exists($filePath1)){
                    echo '$filePath1 exist going to delete '.PHP_EOL;
                    if(@unlink($filePath1))
                        echo '$filePath1 deleted success '.PHP_EOL;
                    else
                        echo '$filePath1 unable too delete '.PHP_EOL;
                }
                
                $fileName1="machichine_activity_".date("Y")."-".date('m')."-".$cDate."_log.log";
                $filePath1="/var/www/html/School/".$fileName1;
                echo '$filePath1 = '.$filePath1.PHP_EOL;
                if(file_exists($filePath1)){
                    echo '$filePath1 exist going to delete '.PHP_EOL;
                    if(@unlink($filePath1))
                        echo '$filePath1 deleted success '.PHP_EOL;
                    else
                        echo '$filePath1 unable too delete '.PHP_EOL;
                }
                
                $fileName2="get_data_generic_fun_".date("Y")."-".date('m')."-".$cDate."_log.log";
                $filePath2="/var/www/html/".CURRENT_INSTANCE."/uploads/".$fileName2;
                echo '$filePath2 = '.$filePath2.PHP_EOL;
                if(file_exists($filePath2)){
                    echo '$filePath2 exist going to delete '.PHP_EOL;
                    if(@unlink($filePath2))
                        echo '$filePath2 deleted success '.PHP_EOL;
                    else
                        echo '$filePath2 unable too delete '.PHP_EOL;
                }
                $sql="DELETE FROM `notification` WHERE `created_date` <= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
                $this->db->query($sql);
            }
            $this->db->truncate('ci_sessions');
        }else{
            echo 'not in_arr'.PHP_EOL;
        }
    }
    
    function exam_reminder(){
        $sql="SELECT ex.name AS exam_name,s.name AS subject_name,e.start_datetime,"
                . " st.name AS student_name,st.email AS student_email,st.phone AS student_phone,st.student_id,"
                . " t.name AS teacher_name,t.email AS teacher_email,t.cell_phone AS teacher_phone,t.teacher_id,"
                . " p.father_name AS parent_name,p.email AS parent_email,p.cell_phone AS parent_phone,p.parent_id  "
                . " FROM `exam_routine` AS e JOIN `enroll` AS en ON(e.section_id=en.section_id)"
                . " JOIN `student` AS st ON(st.student_id=en.student_id)"
                . " JOIN `subject` AS s ON(e.subject_id=s.subject_id) "
                . " JOIN `teacher` AS t ON(s.teacher_id=t.teacher_id) "
                . " JOIN `parent` AS p ON(p.parent_id=st.parent_id)"
                . " JOIN `exam` AS ex ON(e.exam_id=ex.exam_id) WHERE e.start_datetime < DATE_SUB(CURRENT_DATE(),INTERVAL 7 day) AND e.start_datetime !='0000-00-00 00:00:00'";
        $rsExamDetails=  $this->db->query($sql)->result();
        //pre($rsExamDetails);die;
        $teacherArr=array();
        $parentArr=array();
        $studentArr=array();
        foreach($rsExamDetails As $k){
            if(array_search($k->student_phone,  array_column($studentArr, 'phone')) === FALSE){
                $tmpStudentArr=array('exam_name'=>$k->exam_name,'subject_name'=>$k->subject_name,
                    'name'=>$k->student_name,'email'=>$k->student_email,'phone'=>$k->student_phone,'id'=>$k->student_id);
                $studentArr[]=$tmpStudentArr;
            }
            
            if(array_search($k->parent_phone,  array_column($parentArr, 'phone')) === FALSE){
                $tmpParentArr=array('exam_name'=>$k->exam_name,'subject_name'=>$k->subject_name,
                    'name'=>$k->parent_name,'email'=>$k->parent_email,'phone'=>$k->parent_phone,'id'=>$k->parent_id);
                $parentArr[]=$tmpParentArr;
            }
            
            if(array_search($k->teacher_phone,  array_column($teacherArr, 'phone')) === FALSE){
                $tmpTeacherArr=array('exam_name'=>$k->exam_name,'subject_name'=>$k->subject_name,
                    'name'=>$k->teacher_name,'email'=>$k->teacher_email,'phone'=>$k->teacher_phone,'id'=>$k->teacher_id);
                $teacherArr[]=$tmpTeacherArr;
            }
        }
        
        $msg="";
        $this->load->helper("send_notifications");
        foreach($studentArr AS $stud){
            $msg="Hi ".$stud['name'].", Your exam[".$stud['exam_name']."] for subject[".$stud['subject_name']."] will held on ".date('d-m-Y H:i:s').".";
            $message = array();
            $message_body = $msg;
            $message['sms_message'] = $msg;
            $message['subject'] = $this->globalSettingsSystemName . " Exam reminder";
            $message['messagge_body'] = $message_body;
            $message['to_name'] = $stud['name'];
            $user_details = array('user_id' => $stud['id'], 'user_type' => 'student');
            $activity="exam_reminder";
            $phone=$stud['phone'];
            $email=$stud['email'];
            send_school_notification($activity, $message, $phone, $email, $user_details);
        }
        
        foreach($parentArr AS $parent){
            $msg="Hi ".$parent['name'].", Your exam[".$parent['exam_name']."] for subject[".$parent['subject_name']."] will held on ".date('d-m-Y H:i:s').".";
            $message = array();
            $message_body = $msg;
            $message['sms_message'] = $msg;
            $message['subject'] = $this->globalSettingsSystemName . " Exam reminder";
            $message['messagge_body'] = $message_body;
            $message['to_name'] = $parent['name'];
            $user_details = array('user_id' => $parent['id'], 'user_type' => 'parent');
            $activity="exam_reminder";
            $phone=$parent['phone'];
            $email=$parent['email'];
            send_school_notification($activity, $message, $phone, $email, $user_details);
        }
        
        foreach($teacherArr AS $teacher){
            $msg="Hi ".$teacher['name'].", Your exam[".$teacher['exam_name']."] for subject[".$teacher['subject_name']."] will held on ".date('d-m-Y H:i:s').".";
            $message = array();
            $message_body = $msg;
            $message['sms_message'] = $msg;
            $message['subject'] = $this->globalSettingsSystemName . " Exam reminder";
            $message['messagge_body'] = $message_body;
            $message['to_name'] = $teacher['name'];
            $user_details = array('user_id' => $teacher['id'], 'user_type' => 'teacher');
            $activity="exam_reminder";
            $phone=$teacher['phone'];
            $email=$teacher['email'];
            send_school_notification($activity, $message, $phone, $email, $user_details);
        }
    }
    
    function fee_due_reminder(){
        $this->db->db_select(CURRENT_FI_DB);
        //$sql="SELECT GROUP_CONCAT(si.userid SEPARATOR ',') AS studentIds FROM `sys_invoices` AS si WHERE si.duedate < DATE_SUB(CURRENT_DATE(),INTERVAL 7 day) AND si.duedate !='0000-00-00 00:00:00' AND si.`status`!='paid'";
        $sql="SELECT si.userid,si.amount,si.duedate AS pendingAmount FROM `sys_invoices` AS si WHERE si.duedate < DATE_SUB(CURRENT_DATE(),INTERVAL 7 day) AND si.duedate !='0000-00-00 00:00:00' AND si.`status`!='paid'";
        //echo $sql;die;
        $rsAllCRMStudentInvoices=  $this->db->query($sql)->result();
        //pre($rsAllCRMStudentInvoices);
        $this->db->db_select(CURRENT_SCHOOL_DB);
        if(!empty($rsAllCRMStudentInvoices)){
            //$idArr=  explode(',', $rsAllCRMStudentInvoices[0]->studentIds);
            //$sql="SELECT p.father_name,p.cell_phone,p.email";
            $studentIds="";
            foreach ($rsAllCRMStudentInvoices AS $k){
                if($studentIds==""){
                    $studentIds= $k->userid;
                }else{
                    $studentIds.= ",'".$k->userid."'";
                }
            }
            $sql="SELECT p.parent_id,p.father_name,p.cell_phone,p.email,s.student_id FROM `student` AS s LEFT JOIN `parent` AS p ON(s.parent_id=p.parent_id) WHERE s.student_id IN (".$studentIds.")";
            $rsStudentData=  $this->db->query($sql)->result();
            foreach($rsStudentData AS $parent){
                $pendingAmount=0;
                $dueDate="";
                foreach($rsAllCRMStudentInvoices AS $inv){
                    if($inv->userid==$parent->student_id){
                        $pendingAmount=$inv->student_id;
                        $dueDate=$ing->duedate;
                        break;
                    }
                }
                if($pendingAmount>0){
                    $msg="Hi ".$parent->father_name.", Your pending fee $pendingAmount will overduew after ".date('d-m-Y',  strtotime($dueDate)).".Please pay your fees to avoid late charges.";
                    $message = array();
                    $message_body = $msg;
                    $message['sms_message'] = $msg;
                    $message['subject'] = $this->globalSettingsSystemName . " Fees Dues reminder";
                    $message['messagge_body'] = $message_body;
                    $message['to_name'] = $parent->father_name;
                    $user_details = array('user_id' => $parent->parent_id, 'user_type' => 'parent');
                    $activity="fees_dues_reminder";
                    $phone=$parent->cell_phont;
                    $email=$parent->email;
                    send_school_notification($activity, $message, $phone, $email, $user_details);
                }
            }
        }else{
            ///
        }
    }
    
    /* Fee Penalty calculation */
     function runFeePenalty() {
        $this->load->library('Fi_functions');
        $academic_year      =   $this->globalSettingsRunningYear;
        $this->fi_functions->run_fee_penalty();   
    }

    //Fee Penalty apply
    function fee_penalty_apply(){
        $penalty = $this->db->get_where('sys_fee_penalty',array('status'=>1))->row();
        if(!$penalty){
            return false;
        }

        $invoices = $this->db->get_where('sys_invoices',array('duedate <'=>date('Y-m-d'),'LOWER(status)'=>'unpaid'))->result();
        foreach($invoices as $ik=>$inv){
            $inv_items = $this->db->get_where('sys_invoiceitems',array('invoiceid'=>$inv->id))->result();
            $has_penalty = false;
            //$has_penalty = $this->db->get_where('sys_invoiceidtems',array('invoiceid'=>$inv->id,'type'=>'fee_penalty'))->result();
            $has_penalty = $this->db->get_where('sys_invoiceitems',array('invoiceid'=>$inv->id,'type'=>'fee_penalty'))->result();

            if(!$has_penalty){
                $penalty_amt = false;
                $datediff = time() - strtotime($inv->duedate);
                $days_diff = floor($datediff / (60 * 60 * 24));
                $penalty_amt = $penalty->penalty_type==1?$penalty->amount:($penalty->amount*$days_diff);
                
                $save_arr = array('invoiceid'=>$inv->id,
                                  'userid'=>$inv->userid,
                                  'type'=>'fee_penalty',
                                  'itemcode'=>(count($inv_items)+1),
                                  'description'=>'Fee Penalty',
                                  'qty'=>1,
                                  'amount'=>$penalty_amt,
                                  'total'=>$penalty_amt);
                $this->db->insert('sys_invoiceitems',$save_arr);

                //$save_arr = array('penalty_id'=>$penalty->id,'penalty_amount'=>$penalty_amt);
                $save_arr = array('subtotal'=>($penalty_amt+$inv->subtotal),'total'=>($penalty_amt+$inv->total));
                $this->db->update('sys_invoices',$save_arr,array('id'=>$inv->id));
                //echo '<pre>';print_r($inv);exit;
            }
        }
        echo 'done';exit;
    }
    
    function get_all_db_backup_in_remote_server(){
        $remote_server_ftp_host="52.14.91.109";
        $remote_server_ftp_port="22";
        $remote_server_ftp_user="sftp";
        $remote_server_ftp_pass="2jWPai9YoDBYSVXbelpxRgVgUoXgsbdM";
        $this->load->library('ftp');
        //FTP configuration
        $ftp_config['hostname'] = $remote_server_ftp_host; 
        $ftp_config['username'] = $remote_server_ftp_user;
        $ftp_config['password'] = $remote_server_ftp_pass;
        $ftp_config['port']     = $remote_server_ftp_port;
        $ftp_config['passive']  = FALSE;
        $ftp_config['debug']    = TRUE;
        
        //Connect to the remote server
        //$this->ftp->connect($ftp_config);
        
        //upload path of remote server
        $destination_dir = '/var/www/html/db_back_up';
        
        $this->load->dbutil();
        //$dbs = $this->dbutil->list_databases();
        $dataBaseArr=array('beta_merge');
        foreach ($dataBaseArr AS $k =>$v){
            $dbName=$v;
            //$this->db->db_select($dbName);
            $this->myutil=$this->load->dbutil($dbName, TRUE);
            
            $backupFilename="back_up_".$dbName.'_'.date('d_m_y').'.log';
            $prefs = array( 'format' => 'txt', // gzip, zip, txt 
                                 'filename' =>$backupFilename , 
                                                        // File name - NEEDED ONLY WITH ZIP FILES 
                                  'add_drop' => TRUE,
                                                       // Whether to add DROP TABLE statements to backup file
                                 'add_insert'=> TRUE,
                                                      // Whether to add INSERT data to backup file 
                                 'newline' => "\n"
                                                     // Newline character used in backup file 
                                ); 
            //$backup =$this->dbutil->backup($prefs);
            $backup =$this->myutil->backup($prefs);
            
            $this->load->helper('file'); 
            generate_log("back_up_file_full_path : ".MY_SQLI_DB_BACKUP_FOLDER.$backupFilename,"create_mysql_back_up_current_db_".$dbName.".log");
            
            //File path at local server
            $source=MY_SQLI_DB_BACKUP_FOLDER.$backupFilename;
            echo $source;die;
            write_file($source, $backup);  
            
            ////File path at local server
            $destination = $destination_dir.$backupFilename;
            //$this->ftp->upload($source, ".".$destination);
            //$this->ftp->upload($source, $destination, 'ascii', 0775);
        }        
        
        
        //File path at local server
        //$source = 'uploads/'.$fileName;
        
        /******
         * 
         * 
         * 0 0 0 0 0 php /myscript/ftp 2>&1 | curlSend.sh
        #curlSend.sh
        #!/bin/bash
        myvar=`cat /dev/stdin`
        curl -d"test=$myvar" http://127.0.0.1/ci/index.php/ftp/log


        ftp/log

        function log(){
           $entry = $_POST['test'];//insert into db
         * 
         * 
         * 
         */
        
    }
    
    function full_instance_database_for_remote_server(){
        $shell_exec_command='/var/www/html/backup_db_file.sh 2>&1 | tee -a /tmp/instance_create_log 2>/dev/null >/dev/null &';
        generate_log('Going to fire command for shell :::'.$shell_exec_command,"schell_script_log.log");
        $error_msg= shell_exec('sudo /var/www/html/backup_db_file.sh 2>&1 | tee -a /tmp/instance_create_log 2>/dev/null >/dev/null &');
        generate_log('getting output from shell_exec() ::: '+$error_msg,"schell_script_log.log");
    }
    
    function update_permision_current_backup(){
        
    }
    
    function remote_transfer_the_file(){
        $shell_exec_command='/var/www/html/file_transfer.sh 2>&1 | tee -a /tmp/instance_create_log 2>/dev/null >/dev/null &';
        generate_log('Going to fire command for shell :::'.$shell_exec_command,"schell_script_log.log");
        $error_msg= shell_exec('sh /var/www/html/file_transfer.sh 2>&1 | tee -a /tmp/instance_create_log 2>/dev/null >/dev/null &');
        generate_log('getting output from shell_exec() ::: '+$error_msg,"schell_script_log.log");
    }
    
    /*function full_instance_backup_at_remote_server(){
        error_reporting(E_ALL);
        @ini_set("display_errors", 1);
        
        $back_up_file_path="/var/www/html/all_instance_master_backup/";
        $back_up_file_full_name=$back_up_file_path.date('d_m_Y_').CURRENT_INSTANCE.'.zip';
        $current_instance_path='/var/www/html/'.CURRENT_INSTANCE;
        $shell_exec_command='/var/www/html/current_instance_backup.sh '.$back_up_file_full_name.' '.$current_instance_path.'';
        //echo 'Going to fire command for shell :::'.$shell_exec_command;die;
        generate_log('Going to fire command for shell :::'.$shell_exec_command,"schell_script_log.log");
        $error_msg= shell_exec('sudo '.$shell_exec_command .' 2>&1 | tee -a /tmp/schell_script_log 2>/dev/null >/dev/null &');
        //echo $error_msg;die;
        generate_log('getting output from shell_exec() ::: '+$error_msg,"schell_script_log.log");
    }
    
    function full_database_backup_at_remote_server(){
        $back_up_file_path="/var/www/html/all_instance_master_backup/";
        $back_up_file_full_name=$back_up_file_path.date('d_m_Y_').CURRENT_INSTANCE.'.sql';
        //$current_instance_path='/var/www/html/'.CURRENT_INSTANCE;
        $DbUser=DB_USER;
        $UserPassword=DB_PASS;
        
        $shell_exec_command='/var/www/html/database_full_backup.sh '.$DbUser.' '.$UserPassword.' '.CURRENT_INSTANCE.' '.$back_up_file_full_name.' '.' 2>&1 | tee -a /tmp/instance_backup_log 2>/dev/null >/dev/null &';
        generate_log('Going to fire command for shell :::'.$shell_exec_command,"schell_script_log.log");
        //$error_msg= shell_exec('mysqldump -uroot -p6syDmECEyqLneAULy2NYtbSLpCqy727M beta_ag >  /var/www/html/all_instance_master_backup/26_09_2017_beta_ag.sql');
        $error_msg= shell_exec('sudo '.$shell_exec_command .' 2>&1 | tee -a /tmp/schell_script_log 2>/dev/null >/dev/null &');
        generate_log('getting output from shell_exec() ::: '+$error_msg,"schell_script_log.log");
    }*/
    
    function remote_file_transfer(){
        //$fileNamame="";
        //rsync -avzP /var/www/html/all_instance_master_backup/26_09_2017_beta_ag.zip -e ssh sftp@52.14.91.109:/var/www/html
        
        $shell_exec_command='rsync -avzP /var/www/html/transfered_syllabus.zip -e ssh sftp@52.14.91.109:/var/www/html ';
        //echo 'Going to fire command for shell :::'.$shell_exec_command;die;
        generate_log('Going to fire command for shell :::'.$shell_exec_command,"schell_script_log.log");
        $error_msg= shell_exec($shell_exec_command .' 2>&1 | tee -a /tmp/file_transfer 2>/dev/null >/dev/null &');
    }
    
    function backup($tables = false) {
        //$this->load->dbutil();
        //echo $this->db->database;exit;
        set_time_limit(3000); 
        $mysqli = new mysqli($this->db->hostname,$this->db->username,$this->db->password,$this->db->database); 
        $mysqli->select_db($this->db->database); 
        $mysqli->query("SET NAMES 'utf8'");
        $queryTables = $mysqli->query('SHOW TABLES'); 
        while($row = $queryTables->fetch_row()) 
        { $target_tables[] = $row[0]; }	
        //echo '<pre>';print_r($target_tables);exit;

        if($tables !== false) 
        { $target_tables = array_intersect( $target_tables, $tables); } 
        $content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";
        \r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
        \r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
        \r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
        \r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `".$name."`\r\n--\r\n\r\n\r\n";
        foreach($target_tables as $table){
            if (empty($table)){ continue; } 
            $result	= $mysqli->query('SELECT * FROM `'.$table.'`');  	
            $fields_amount=$result->field_count;  
            $rows_num=$mysqli->affected_rows; 	
            $res = $mysqli->query('SHOW CREATE TABLE '.$table);	
            $TableMLine=$res->fetch_row(); 
            $content .= "\n\n".$TableMLine[1].";\n\n";   
            $TableMLine[1]=str_ireplace('CREATE TABLE `','CREATE TABLE IF NOT EXISTS `',$TableMLine[1]);
            for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) {
                while($row = $result->fetch_row())	{ //when started (and every after 100 command cycle):
                    if ($st_counter%100 == 0 || $st_counter == 0 )	
                        {$content .= "\nINSERT INTO ".$table." VALUES";}
                        $content .= "\n(";    
                        
                        for($j=0; $j<$fields_amount; $j++)
                        { $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); 
                            if (isset($row[$j])){$content .= '"'.$row[$j].'"' ;}  
                            else{$content .= '""';}	   if ($j<($fields_amount-1)){$content.= ',';}   
                        }       
                         $content .=")";
                    //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                    if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) 
                        {$content .= ";";} 
                    else {$content .= ",";}	
                        $st_counter=$st_counter+1;
                }
            } $content .="\n\n\n";
        }
        $content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
        $backup_name = $backup_name ? $backup_name : $name.'___('.date('H-i-s').'_'.date('d-m-Y').').sql';
        ob_get_clean(); header('Content-Type: application/octet-stream');  header("Content-Transfer-Encoding: Binary");  header('Content-Length: '. (function_exists('mb_strlen') ? mb_strlen($content, '8bit'): strlen($content)) );    header("Content-disposition: attachment; filename=\"".$backup_name."\""); 
        echo $content; exit;
    }
    
    function temp_google_drive_backup(){
        $fileName= $this->create_mysql_back_up_current_db();
        echo MY_SQLI_DB_BACKUP_FOLDER.$fileName;
    }
    
    function temp_google_drive_restore($dbName){
        $backupFilename='backup_'.date('d_m_Y').'.sql';
        $fullPath=MY_SQLI_DB_BACKUP_FOLDER.$backupFilename;
        $shell_exec_command='/var/www/html/google_drive_backup_restore.sh '.DB_PASS.' '.$dbName.' '.$fullPath.' 2>&1 | tee -a /tmp/google_drive_backup_restore_log 2>/dev/null >/dev/null &';
        generate_log('Going to fire command for shell :::'.$shell_exec_command,'google_drive_restore_log_'.date('Y_m_d').'.log');
        $error_msg= shell_exec('sudo '.$shell_exec_command);
        generate_log('getting output from shell_exec() ::: '+$error_msg,'google_drive_restore_log_'.date('Y_m_d').'.log');
        sleep(200);
        $content= preg_replace('/\s+/','',trim(file_get_contents('/tmp/google_drive_backup_restore_log')));
        $content= preg_replace('/\t/','',$content);
        $content = preg_replace('~[\r\n]+~', '', $content);
        if($content=='Warning:Usingapasswordonthecommandlineinterfacecanbeinsecure.Warning:Usingapasswordonthecommandlineinterfacecanbeinsecure.'){
            echo 'ok';
        }else{
            echo 'wrong';
        }
    }
    
    function test_shell_exec_function(){ 
        $shell_exec_command='pwd 2>&1 | tee -a /tmp/test_shell_exec 2>/dev/null >/dev/null &';
        generate_log('Going to fire command for shell :::'.$shell_exec_command,'test_shell_exec_log_'.date('Y_m_d').'.log');
        $error_msg= shell_exec($shell_exec_command);
        generate_log('getting output from shell_exec() ::: '+$error_msg,'test_shell_exec_log_'.date('Y_m_d').'.log');
    }
}