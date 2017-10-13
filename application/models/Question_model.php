<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Question_model extends CI_Model {

    private $_table = "questions";

    function __construct() {
        parent::__construct();
    }

    public function question_save($data) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
            } 
        }
        $this->db->insert($this->_table, $data);
    }

    public function update_question($id, $data) {
        $this->db->where('id', $id);
        $this->db->update($this->_table, $data);
    }

    public function question_delete($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->_table);
    }
    public function get_details_ById($class_id,$exam_id,$subject_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('questions.school_id',$school_id);
            } 
        }
        $this->db->select('questions.*,c.name AS class_name');
        $this->db->from($this->_table." AS questions");
        $this->db->join('class AS c','questions.class_id = c.class_id','left');
        $this->db->join('online_exam AS oe','questions.exam_id = oe.id','left');
        $this->db->where('questions.class_id',$class_id);
        $this->db->where('questions.subject_id',$subject_id);
        $this->db->where('questions.exam_id',$exam_id);
        return $this->db->get()->result_array();
    }

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
    public function view_details_student_login($id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql="SELECT subject.name as subject_name,COUNT(questions.id) as total_question,SUM(questions.marks) as total_marks FROM questions as questions LEFT JOIN online_exam as online_exam on(questions.exam_id=online_exam.id) LEFT JOIN subject as subject on(questions.subject_id=subject.subject_id) where questions.exam_id='".$id."' and questions.school_id = '".$school_id."' GROUP BY questions.subject_id";
            } 
        } else {
            $sql="SELECT subject.name as subject_name,COUNT(questions.id) as total_question,SUM(questions.marks) as total_marks FROM questions as questions LEFT JOIN online_exam as online_exam on(questions.exam_id=online_exam.id) LEFT JOIN subject as subject on(questions.subject_id=subject.subject_id) where questions.exam_id='$id' GROUP BY questions.subject_id";
        }
        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }
    public function record_count() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->count_all($this->_table);
    }

}
