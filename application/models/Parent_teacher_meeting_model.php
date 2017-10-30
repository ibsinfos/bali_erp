<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Parent_teacher_meeting_model extends CI_Model {
    private $_table="parrent_teacher_meeting";
    function __construct() {
        parent::__construct();
    }

    function get_parent_teacher_meeting_schedule() {
        
    }

    function set_parent_teacher_meeting_schedule($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('parrent_teacher_meeting', $dataArray);
        $id = $this->db->insert_id();
        return $id;
    }

    function edit_parent_teacher_meeting_schedule($dataArray, $condition) {
        $this->db->where($condition);
        $this->db->update('parrent_teacher_meeting', $dataArray);
        return true;
    }

    public function get_ptm_details($student_id = '') {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('par_tea_mtg.school_id',$school_id);
            } 
        }
        $this->db->select('std.name as student_name, std.student_id as stud_id,par_tea_mtg.exam_id, par_tea_mtg. parrent_teacher_meeting_date,par_tea_mtg.time,cls.class_id,cls.name as class_name,sec.name as section_name, sec.section_id, par_tea_mtg.exam_id,e.name AS exam_name'); // Select field
        $this->db->from('parrent_teacher_meeting as par_tea_mtg');
        $this->db->join('student as std', 'par_tea_mtg.student_id = std.student_id');
        $this->db->join('class as cls', 'par_tea_mtg.class_id  = cls.class_id');
        $this->db->join('section as sec', 'par_tea_mtg.section_id = sec.section_id');
        $this->db->join('exam as e', 'par_tea_mtg.exam_id = e.exam_id','left');
        $this->db->where('par_tea_mtg.student_id', $student_id);
        $this->db->order_by('par_tea_mtg.parrent_teacher_meeting_date', "DESC");
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
    
    function get_current_month_ptm(){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $where = " AND ptm.school_id='".$school_id."'";
            } 
        }
        $month = date('m');
        $query = "select CONCAT(t.name,' ',t.last_name) as teacher_name,ptm.parrent_teacher_meeting_date as ptm_date,ptm.time,c.name as class_name from parrent_teacher_meeting ptm LEFT JOIN class c ON c.class_id=ptm.class_id LEFT JOIN teacher t ON ptm.teacher_id=t.teacher_id WHERE MONTH(ptm.parrent_teacher_meeting_date)='".$month."'".$where." LIMIT 0,3";
        $result = $this->db->query($query)->result_array();
        return $result;
    }

}
