<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mark_model extends CI_Model {

    private $_table = "mark";
    private $_table_ibo = "ibo_marks";
    private $_table_exam = "exam";
    private $_table_student = "student";
    private $_table_class = "class";
    private $_table_subject = "subject";

    function __construct() {
        parent::__construct();
    }

    function get_average($id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql = "SELECT e.name as Exam_type,avg(m.mark_obtained) as marks,s.name as subject_name FROM exam e, mark m,subject s where e.exam_id=m.exam_id and s.subject_id=m.subject_id and m.student_id='".$id."' and m.school_id = '".$school_id."' group by e.name ORDER by e.name";
            } 
        } else {
            $sql = "SELECT e.name as Exam_type,avg(m.mark_obtained) as marks,s.name as subject_name FROM exam e, mark m,subject s where e.exam_id=m.exam_id and s.subject_id=m.subject_id and m.student_id='".$id."' group by e.name ORDER by e.name";
        }
        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }

    function get_manage_mark($examId, $classId, $sectionId, $subjectId) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('mark.school_id',$school_id);
            } 
        }
        $this->db->select('exam_id,mark_obtained,mark_total,comment,student.name AS student_name,enroll.roll AS rollnumber');
        $this->db->from('mark');
        $this->db->where(array('mark.exam_id' => $examId, 'mark.class_id' => $classId, 'mark.section_id' => $sectionId, 'mark.subject_id' => $subjectId));
        $this->db->join('subject', 'subject.subject_id = mark.subject_id');
        $this->db->join('student', 'student.student_id = mark.student_id');
        $this->db->join('enroll', 'enroll.student_id = mark.student_id');
        $result = $this->db->get()->result_array();

        return $result;
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

    public function update_mark($dataArray, $conditionArray) {
        $this->db->where($conditionArray);
        $this->db->update('mark', $dataArray);
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
            return $this->db->get_where($this->_table, array($this->_primary=>$id))->result();
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

    public function save($data)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
            } 
        }
        $this->db->insert($this->_table, $data);
    }

    public function update_marks($id, $data)
    {   
        $this->db->where('mark_id', $id);
        $this->db->update($this->_table, $data);

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

   

    function get_current_year_mark_with_exam_id_student_id($exam_id,$student_id,$cYear){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('m.school_id',$school_id);
            } 
        }
        $this->db->select('m.*,c.name AS class_name,s.name AS subject_name');
        $this->db->from($this->_table." AS m")->join($this->_table_class." AS c",'m.class_id=c.class_id','left');
        $this->db->join($this->_table_subject." AS s",'s.subject_id=m.subject_id','left');
        $this->db->where('m.exam_id',$exam_id)->where('m.student_id',$student_id)->where('m.year',$cYear);
        $rs=$this->db->get()->result_array();
        return $rs;
    }

    function get_c_year_mark_obtained_by_subject_exam_class($subject_id,$exam_id,$class_id,$student_id,$year){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
    $obtained_mark_query = $this->db->get_where($this->_table , array('subject_id' => $subject_id,'exam_id' => $exam_id,'class_id' => $class_id,'student_id' => $student_id ,'year' => $year))->result_array();

        return $obtained_mark_query;
    }

    function get_data_by_cols_ibo($columnName = "*", $conditionArr = array(), $return_type = "result", $sortByArr = array(), $limit = "") {
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
            $rs = $this->db->get($this->_table_ibo)->result();
        } else {
            $rs = $this->db->get($this->_table_ibo)->result_array();
        }

        return $rs;
    }

    public function save_ibo($data){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
            } 
        }
        $this->db->insert($this->_table_ibo, $data);
        return TRUE;
    }

    public function ibo_update_marks($where, $data)
    {   
        $this->db->where($where);
        $this->db->update($this->_table_ibo, $data);
        return 1;
    }
    
    function add_mark_by_bulk_upload($dataArr){
        $school_id = '';
        $school_id = $this->session->userdata('school_id');
        $dataArrNew=array();
        foreach($dataArr AS $k => $v){
            $v['school_id'] = $school_id;
            $rs=$this->db->from($this->_table)->where('student_id',$v['student_id'])->where('subject_id',$v['subject_id'])->where('year',$v['year'])->where('school_id',$v['school_id'])->get()->result();
            if(!empty($rs)){
                $this->db->where('student_id',$v['student_id'])->where('subject_id',$v['subject_id'])->where('year',$v['year'])->where('school_id',$v['school_id']);
                $this->db->delete($this->_table);
            }
            $this->db->insert($this->_table,$v);
            //$dataArrNew[]=$v;
        }
        //$this->db->insert_batch($this->_table,$dataArrNew);
        return TRUE;
    }
}
