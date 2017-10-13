<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Message_model extends CI_Model {

    private $_table = "message";
    private $_table_thread = "message_thread";
    private $_table_custom_messsage = "custom_messsage";

    function __construct() {
        parent::__construct();
    }

    function add($dataArr) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArr['school_id'] = $school_id;
            } 
        }
        $this->db->insert($this->_table, $dataArr);
        return $this->db->insert_id();
    }

    function update($dataArr, $whereArr) {
        foreach ($whereArr AS $k => $v) {
            $this->db->where($k, $v);
        }
        $this->db->update($this->_table, $dataArr);
        return TRUE;
    }

    function delete($id) {
        $this->db->where('group_user_id', $id);
        $this->db->delete($this->_table);
        return TRUE;
    }

    function get_all_participent() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql = "SELECT t.teacher_id,t.name,'teacher' FROM `teacher` AS t WHERE t.isActive = 1 AND t.school_id = '".$school_id."'
            UNION
            SELECT p.parent_id,p.father_name,'parent' FROM `parent` AS p WHERE p.isActive = 1 AND p.school_id = '".$school_id."'
            UNION
            SELECT s.name,s.student_id,'student' FROM `student` AS s WHERE s.isActive = 1 AND s.school_id = '".$school_id."'";
            } 
        } else {
            $sql = "SELECT t.teacher_id,t.name,'teacher' FROM `teacher` AS t WHERE t.isActive = 1
            UNION
            SELECT p.parent_id,p.father_name,'parent' FROM `parent` AS p WHERE p.isActive = 1
            UNION
            SELECT s.name,s.student_id,'student' FROM `student` AS s WHERE s.isActive = 1";
        }
        $rs = $this->db->query($sql)->result();
        return $rs;
    }

    function delete_msg_thread($param2,$user_deleted) {

        $this->db->where(array('message_id' => $param2));
        $this->db->update('message', array('message_status' => $user_deleted));

        return true;
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
    function get_message_threads_parent($user){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('tr.school_id',$school_id);
            } 
        }
        $this->db->order_by('tr.message_thread_id', 'desc');
        $user_to_show = explode('-', $user);
        $user_to_show_type = $user_to_show[0];
        $user_to_show_id = $user_to_show[1];
        
        $this->db->select("*");
        $this->db->where('tr.sender', $user);
        $this->db->or_where('tr.reciever', $user);

        $this->db->from($this->_table_thread." AS tr");

        $this->db->order_by('tr.message_thread_id', 'desc');

        $data = $this->db->get()->result_array();
        //echo $this->db->last_query();die;
        return $data;
    }

    function get_message_threads($user){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('tr.school_id',$school_id);
            } 
        }
        $this->db->order_by('tr.message_thread_id', 'desc');
        $user_to_show = explode('-', $user);
        $user_to_show_type = $user_to_show[0];
        $user_to_show_id = $user_to_show[1];
        
        $this->db->select("*");
        $this->db->where('tr.sender', $user);
        $this->db->or_where('tr.reciever', $user);
        $this->db->join($user_to_show_type,$user_to_show_type.'_id ='.$user_to_show_id,'left');
        
        $this->db->from($this->_table_thread." AS tr");
        $data = $this->db->get()->result_array();
        return $data;
    }

     function add_custom_messsage_schudule($dataArr) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArr['school_id'] = $school_id;
            } 
        }
        $this->db->insert($this->_table_custom_messsage, $dataArr);
        return $this->db->insert_id();
    }
    
    function get_custom_message(){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
       echo $ScheduleTime = date('Y-m-d H:i');
       echo $sql= "SELECT * FROM `custom_messsage` WHERE `message_schedule_status` = '0' AND CAST(`later_schedule_time` AS Datetime) <= '".$ScheduleTime."'";
        return $rs = $this->db->query($sql)->result();
   }
    
}

