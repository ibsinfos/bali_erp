<?php

if (!defined('BASEPATH'))
    exit ('No direct script access allowed');


class Student_assignments_model extends CI_Model {
    private $_table = "student_assignments";
    function __construct() {
        parent::__construct();
    }

    public function save_assignments($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('student_assignments', $dataArray);
        generate_log($this->db->last_query());
        $assignment_id = $this->db->insert_id();
        return $assignment_id;
    }

    public function get_Assignments($subject_id, $student_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('sa.school_id',$school_id);
            } 
        }
        
        $this->db->select("sa.*, tea.teacher_id, tea.name as teacher_name");
        $this->db->from('student_assignments as sa');
        $this->db->join('teacher as tea', 'tea.teacher_id = sa.teacher_id');
        $this->db->where('tea.teacher_id = sa.teacher_id');
        $this->db->where('sa.subject_id', $subject_id);
        $this->db->where('sa.student_id', $student_id);
        $this->db->order_by("sa.assignment_id", "desc");
        $res = $this->db->get()->result_array();
        return $res;
    }

    public function get_student_submit_Assignments($class_id, $subject_id, $topic_id, $student_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('sa.school_id',$school_id);
            } 
        }
        $this->db->select("an.*, sa.student_id,sa.assigned_date,sa.submission_date,sa.is_Verified,sa.isSubmitted,s.name,s.mname,s.lname");
        $this->db->from('student_assignments as sa');
        $this->db->join('assignment_answers as an', 'an.assignment_id = sa.assignment_id', 'left');
        $this->db->join('student as s', 's.student_id = sa.student_id', 'right');
        $this->db->where('sa.class_id', $class_id);
        $this->db->where('sa.subject_id', $subject_id);
        $this->db->where('sa.assignment_id', $topic_id);
        $this->db->where('sa.student_id', $student_id);
//        $this->db->where('sa.assignment_id', 'desc');

        $res = $this->db->get()->result_array();
        return $res;
    }

    public function submit_assignments($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('assignment_answers', $dataArray);
        generate_log($this->db->last_query());
        $assignment_answer_id = $this->db->insert_id();
        return $assignment_answer_id;
    }

    public function update_submit($dataArray, $condition) {
        $this->db->where($condition);
        $this->db->update('student_assignments', $dataArray);
        return true;
    }

    public function assignment_topic($class_id, $subject_id, $teacher_id) {
        echo $class_id . $subject_id . $teacher_id;
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
    
    function getAssignmentTopic($where){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        
        $this->db->select("*");
        $this->db->from($this->_table);
        $this->db->where($where);
        $this->db->group_by("assignment_topic");        
        return $result = $this->db->get()->result_array();
    }

}
