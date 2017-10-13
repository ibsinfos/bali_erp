<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notification_model extends CI_Model {

    private $_table = "dashbord_notification";

    function __construct() {
        parent::__construct();
    }

    /**
     * 
     * @param type $columnName
     * @param type $conditionArr
     * @param type $return_type="result"
     * @return type
     * example it will use in controlelr
     * 
     * =====bellow is for * data without conditions======
     * $this->Parent_model->get_data_generic_fun('*');
     *  =====bellow is for * data witht conditions======
     * $this->Parent_model->get_data_generic_fun('*',array('column1'=>$column1Value,'column2'=>$column2Value));
     * 
     * =====bellow is for 1 or more column data without conditions======
     * $this->Parent_model->get_data_generic_fun('column1,column2,column3');
     *  =====bellow is for 1 or more column data with conditions======
     * $this->Parent_model->get_data_generic_fun('column1,column2,column3',array('column1'=>$column1Value,'column2'=>$column2Value));
     *  =====bellow is for 1 or more column data with conditions and return as result all======
     * $this->Parent_model->get_data_generic_fun('column1,column2,column3',array('column1'=>$column1Value,'column2'=>$column2Value),'result_arr');
     * 
     * ==== modification for  adding sortby and limit and add conditionArr for AND -- OR -- IN ---
     * $this->Parent_model->get_data_generic_fun('parent_id,passcode',array('passcode'=>$passcoad,'device_token'=>$deviceToken,'condition_type'=>'or'),array('parrent_id'=>'asc','date_time'=>'desc'),1);
     */
    function get_data_generic_fun($columnName = "*", $conditionArr = array(), $return_type = "result", $sortByArr = array(), $limit = "") {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->select($columnName);
        $condition_type = 'and';
        if (array_key_exists('condition_type', $conditionArr)) {
            if ($conditionArr['condition_type'] != "") {
                $condition_type = $conditionArr['condition_type'];
            }
        }
        unset($conditionArr['condition_type']);
        $inConditionStr = "";
        $startCounter = 0;
        foreach ($conditionArr AS $k => $v) {
            if ($condition_type == 'in') {
                if ($inConditionStr == "") {
                    $inConditionStr = $v;
                } else {
                    $inConditionStr .= "," . $v;
                }
            } elseif ($condition_type == 'or') {
                if ($startCounter == 0) {
                    $this->db->where($k, $v);
                } else {
                    $this->db->or_where($k, $v);
                }
            } elseif ($condition_type == 'and') {
                $this->db->where($k, $v);
            }
            $startCounter++;
        }

        if ($condition_type == 'in') {
            $this->db->where_in($inConditionStr);
        }

        if ($limit != "") {
            $this->db->limit($limit);
        }

        foreach ($sortByArr AS $key => $val) {
            $this->db->order_by($key, $val);
        }

        if ($return_type == 'result')
            $rs = $this->db->get($this->_table)->result();
        else
            $rs = $this->db->get($this->_table)->result_array();
        //echo $this->db->last_query(); //die;
        return $rs;
    }

    /*     * ****************************Inserting table************************* */

    public function save_data($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert($this->_table, $dataArray);
    }

    /*     * ****************************updating table************************* */

    public function update_data($dataArray, $conditionArray) {
        $this->db->where($conditionArray);
        $this->db->update($this->_table, $dataArray);
        return true;
    }

    /*     * ****************************Inserting campus/general notice************************* */

    public function save_notifications($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $notification_id = $this->db->insert('notification', $dataArray);
        return $notification_id;
    }

    public function edit_updates($dataArray, $condition) {
        $this->db->where($condition);
        $this->db->update('notification', $dataArray);
        return true;
    }

    public function delete_updates($condition) {
        $this->db->delete('notification', $condition);
        return true;
    }

    public function get_todays_notifcations($notificationType = '', $userType = '') {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->select('*');
        $this->db->from('notification');
        $today = date('Y-m-d');
        $this->db->where('DATE(created_date)', $today);
        if ($notificationType != '') {
            $this->db->where('notification_type', $notificationType);
        }
        if ($userType != '') {
            $this->db->where('user_type', $userType);
        }
        $this->db->order_by('notification_id','DESC');
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_notifications($notificationType = '', $userType = '', $user_id = '', $class_id = '') {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $whereArr               =   array();
        
        $this->db->select('*');
        $this->db->from('notification');
        
        if( $notificationType != '' ) {
            $this->db->where( 'notification_type' , $notificationType );
        }
        
        if( $class_id != '' ) {
            $this->db->where( 'class_id' , $class_id );
        } 

        if(  $userType != '' && $user_id != '' ) {
            $whereArr['user_type']      =   $userType;
            $whereArr['user_id']        =   $user_id;
            
            $this->db->where( 'user_type' , $userType );
            $this->db->where( 'user_id' , $user_id );
        } else if( $userType != '' ) {
            $whereArr['user_type']          =   $userType;
            $whereArr['user_id']            =   0;
            
            $this->db->where( 'user_type' , $userType );
            $this->db->where( 'user_id' , 0 );
        } else {
            $whereArr['user_type']          =   '';
            
            $this->db->where( 'user_type' , '' );
        }
        
        $this->db->order_by('created_date','DESC');

        $result = $this->db->get()->result_array();
        
        foreach ($whereArr AS $k => $v) {
            $this->db->where($k, $v);
        }
        $this->db->update('notification', array('isRead' => 1));
        
        return $result;
        
    }

    /*
     * Save notification queue
     */

    public function create_notification_queue($event, $message) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $dataArray['notification_type'] = $event;
        $dataArray['message'] = $message['sms_message'];
        $dataArray['message_subject'] = $message['subject'];
        $dataArray['message_body'] = $message['messagge_body'];
        $dataArray['date_created'] = date('Y-m-d');
        $dataArray['status'] = 1;
        $queue_id = $this->db->insert('notification_queue', $dataArray);
        return $queue_id;
    }

    /*
     * update notification queue
     */

    public function update_notification_queue($dataArray, $condition) {
        $this->db->where($condition);
        $this->db->update('notification_queue', $dataArray);
        return true;
    }

    public function getNotices() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('nb.school_id',$school_id);
            } 
        }
        $this->db->select('DISTINCT(nb.notice_title), nb.notice_id, nb.notice, nb.create_timestamp,nb.create_time,nb.sender_type, class.class_id, class.name');
        $this->db->from('noticeboard as nb');
        $this->db->join('class', 'class.class_id = nb.class_id', 'left');
        $this->db->order_by('nb.create_timestamp', 'DESC');
        $res = $this->db->get()->result_array();
        return $res;
    }

    public function getNoticesbyclass($class_id = '') {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('nb.school_id',$school_id);
            } 
        }
        $this->db->select('nb.notice_id, nb.notice_title, nb.notice, nb.class_id, nb.create_timestamp, nb.create_time,c.name');
        $this->db->from('noticeboard as nb');
        $this->db->join('class as c','nb.class_id=c.class_id','left');
        $this->db->where_in('nb.class_id', array($class_id, 0));
        $this->db->group_by('nb.notice_title');
        $this->db->order_by('nb.create_timestamp', 'DESC');
        $res = $this->db->get()->result_array();

        return $res;
    }

    public function get_last_threedays_notifcations($notificationType = '', $userType = '') {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->select('*');
        $this->db->from('notification');
        $today_date = date('Y-m-d');
        $last_date = date('Y-m-d', strtotime('-2 days', strtotime($today_date)));
        $this->db->where("created_date BETWEEN '$last_date' AND  '$today_date'");
        $this->db->order_by('created_date', 'DESC');
        if ($notificationType != '') {
            $this->db->where('notification_type', $notificationType);
        }
        if ($userType != '') {
            $this->db->where('user_type', $userType);
        }
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_Notice_details($notice_id = '') {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->select('*');
        $this->db->from('noticeboard');
        $this->db->where('notice_id', $notice_id);
        $res = $this->db->get()->result_array();
        return $res;
    }

    public function getNotices_for_teacher($teacher_id = '') {
        $class_id = $this->Section_model->get_class_deatils_by_teacher($teacher_id);        
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('nb.school_id',$school_id);
            } 
        }
        $this->db->select('nb.*, class.class_id, class.name');
        $this->db->from('noticeboard as nb');
        $this->db->join('class', 'class.class_id = nb.class_id', 'left');
        foreach ($class_id as $cls) {
            $class_id = $cls['class_id'];
            $this->db->or_where_in('nb.class_id', array($class_id, 0));
        }         
        $this->db->group_by('nb.notice_title');
        $this->db->order_by('nb.create_timestamp', 'DESC');
        $res = $this->db->get()->result_array();
        return $res;
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    function get_data_by_id($id, $returnColsStr = "") {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        if ($returnColsStr == "") {
            return $this->db->get_where($this->_table, array($this->_primary, $id))->result();
        } else {
            return $this->db->select($returnColsStr)->from($this->_table)->where($this->_primary, $id)->get()->result();
        }
    }

    /**
     * 
     * @param type $columnName
     * @param type $conditionArr
     * @param type $return_type="result"
     * @return type
     * example it will use in controlelr
     * 
     * =====bellow is for * data without conditions======
     * get_data_generic_fun('parent','*');
     *  =====bellow is for * data witht conditions======
     * get_data_generic_fun('parent','*',array('column1'=>$column1Value,'column2'=>$column2Value));
     * 
     * =====bellow is for 1 or more column data without conditions======
     * get_data_generic_fun('parent','column1,column2,column3');
     *  =====bellow is for 1 or more column data with conditions======
     * get_data_generic_fun('parent','column1,column2,column3',array('column1'=>$column1Value,'column2'=>$column2Value));
     *  =====bellow is for 1 or more column data with conditions and return as result all======
     * get_data_generic_fun('parent','column1,column2,column3',array('column1'=>$column1Value,'column2'=>$column2Value),'result_arr');
     * 
     * ==== modification for  adding sortby and limit and add conditionArr for AND -- OR -- IN ---
     * get_data_generic_fun('parent','parent_id,passcode',array('passcode'=>$passcoad,'device_token'=>$deviceToken,'condition_type'=>'or'),array('parrent_id'=>'asc','date_time'=>'desc'),1);
     */
    function get_data_by_cols($columnName = "*", $conditionArr = array(), $return_type = "result", $sortByArr = array(), $limit = "") {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->select($columnName);
        $condition_type = 'and';
        if (array_key_exists('condition_type', $conditionArr)) {
            if ($conditionArr['condition_type'] != "") {
                $condition_type = $conditionArr['condition_type'];
            }
        }
        unset($conditionArr['condition_type']);
        $condition_in_data_arr = array();
        $startCounter = 0;
        $condition_in_column = "";
        foreach ($conditionArr AS $k => $v) {
            if ($condition_type == 'in') {
                if (array_key_exists('condition_in_data', $conditionArr)) {
                    $condition_in_data_arr = explode(',', $conditionArr['condition_in_data']);
                    $condition_in_column = $conditionArr['condition_in_col'];
                }
            } elseif ($condition_type == 'or') {
                if ($startCounter == 0) {
                    $this->db->where($k, $v);
                } else {
                    $this->db->or_where($k, $v);
                }
            } elseif ($condition_type == 'and') {
                $this->db->where($k, $v);
            }
            $startCounter++;
        }

        if ($condition_type == 'in') {
            if (!empty($condition_in_data_arr))
                $this->db->where_in($condition_in_column, $condition_in_data_arr);
        }

        if ($limit != "") {
            $this->db->limit($limit);
        }

        foreach ($sortByArr AS $key => $val) {
            $this->db->order_by($key, $val);
        }

        if ($return_type == 'result') {
            $rs = $this->db->get($this->_table)->result();
        } else {
            $rs = $this->db->get($this->_table)->result_array();
        }
        return $rs;
    }
    
    
    public function getNotices_for_parents($student_id = '',$class_id = '') {      
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('nb.school_id',$school_id);
            } 
        }
        $this->db->select('nb.notice_title, nb.notice,c.class_id,c.name, nb.create_timestamp'); // Select field
        $this->db->from('noticeboard nb'); // from Table1
        $this->db->where('nb.class_id',$class_id);
        $this->db->or_where('nb.class_id','0');
        $this->db->join('class c','c.class_id = nb.class_id','left'); 
        $this->db->order_by('nb.create_timestamp', 'DESC'); 
        
        $res = $this->db->get()->result_array();
        return $res;
    }

}
