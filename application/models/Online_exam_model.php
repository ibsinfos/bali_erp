<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    
class Online_exam_model extends CI_Model {
    private $_table="online_exam";
    private $_table_subject="subject";
    private $_table_class="class";
    private $_primary="report_id";
    function __construct() {
        parent::__construct();
    }
    
    function add($dataArray){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert($this->_table, $dataArray);
        $progress_id = $this->db->insert_id();
        return $progress_id;
    }
    
    function edit($dataArray,$id){
        $this->db->where($this->_primary, $id);
        $this->db->update($this->_table, $dataArray);
        return true;
    }
    
    function delete($id){
        $this->db->where($this->_primary, $id);
        $this->db->delete($this->_table);
        return TRUE;
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
    
    function nums_of_report_by_student($id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->where('student_id' , $id)->count_all_results($this->_table);
    }
    
    function get_exam_data_class_id($class_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('oe.school_id',$school_id);
            } 
        }
        $this->db->select('oe.*,c.name AS class_name,s.name AS subject_name');
        $this->db->from($this->_table." AS oe");
        $this->db->join("Questions AS q",'oe.id=q.exam_id','left');
        $this->db->join($this->_table_class." AS c",'oe.class_id=c.class_id','left');
        $this->db->join($this->_table_subject." AS s",'q.subject_id=s.subject_id','left');
        $this->db->where('oe.class_id',$class_id);
        $rs=$this->db->get()->result_array();
        return $rs;
    }
    function get_exam_data_class_id_student_login($class_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('oe.school_id',$school_id);
            } 
        }
        $this->db->select('oe.*,c.name AS class_name');
        $this->db->from($this->_table." AS oe");
        $this->db->join($this->_table_class." AS c",'oe.class_id=c.class_id','left');
        $this->db->where('oe.class_id',$class_id);
        $this->db->where('oe.status',"active");
        $rs=$this->db->get()->result_array();
        return $rs;
    }
}

