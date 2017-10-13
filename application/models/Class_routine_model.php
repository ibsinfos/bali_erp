<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Class_routine_model extends CI_Model {

    private $_table = "class_routine";
    private $_table_student = "student";
    private $_table_class = "class";
    private $_table_section = "section";
    private $_table_subject = "subject";
    private $_table_teacher = "teacher";
    private $_table_enroll = "enroll";

    function __construct() {
        parent::__construct();
    }

    public function add($data)
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

    public function update($param2, $data)
    {
            $this->db->where('class_routine_id', $param2);
            $this->db->update('class_routine', $data);
    }

    public function get_class_row($param2)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->get_where($this->_table, array('class_routine_id' => $param2))->row()->class_id;
    }

    public function get_class_routine_details($teacher_id = '', $class_id = '', $section_id = '') {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('cr.school_id',$school_id);
            } 
        }
        $this->db->select("cr.*, sub.name, cls.name as class_name, sec.name as section_name, sub.name as subject_name");
        $this->db->from('class_routine as cr'); // from Table1
        $this->db->join('class as cls', 'cls.class_id = cr.class_id');
        $this->db->join('subject as sub', 'cr.subject_id = sub.subject_id');
        $this->db->join('section as sec', 'cr.section_id = sec.section_id');
        $this->db->where('cr.class_id', $class_id);
        $this->db->where('cr.section_id', $section_id);
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_class_routine($class_id = '', $section_id = '', $day = '', $year = '') {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('cr.school_id',$school_id);
            } 
        }
        $this->db->select("cr.*, sub.name, cls.name as class_name, sec.name as section_name, sub.name as subject_name, t.name as teacher_name");
        $this->db->from('class_routine as cr'); // from Table1
        $this->db->join('class as cls', 'cls.class_id = cr.class_id');
        $this->db->join('subject as sub', 'cr.subject_id = sub.subject_id');
        $this->db->join('teacher as t', 't.teacher_id=sub.teacher_id');
        $this->db->join('section as sec', 'cr.section_id = sec.section_id');
        $this->db->where('cr.day', $day);
        $this->db->where('cr.year', $year);
        $this->db->where('cr.class_id', $class_id);
        $this->db->where('cr.section_id', $section_id);
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function weekly_class_routine($class_id = '', $section_id = '') {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('cr.school_id',$school_id);
            } 
        }
        $this->db->select("cr.*, sub.name, cls.name as class_name, sec.name as section_name, sub.name as subject_name, t.name as teacher_name");
        $this->db->from('class_routine as cr'); // from Table1
        $this->db->join('class as cls', 'cls.class_id = cr.class_id');
        $this->db->join('subject as sub', 'cr.subject_id = sub.subject_id');
        $this->db->join('teacher as t', 't.teacher_id=sub.teacher_id');
        $this->db->join('section as sec', 'cr.section_id = sec.section_id');
        $this->db->where('cr.class_id', $class_id);
        $this->db->where('cr.section_id', $section_id);
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_class_resource($class_id = '') {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('cls.school_id',$school_id);
            } 
        }
        $this->db->select("cls.name as name,tr.name as teacher_name,tr.cell_phone as teacher_cell_phone,tr.email as teacher_email,AS.title as academic_syllabus_title,AS.academic_syllabus_code as academic_syllabus_code,AS.Description as academic_syllabus_Description,AS.date_time as uploaded date,AS.file_name as File name,D.title as Title,D.description as Description,D.file_name");
        $this->db->from('class as cls'); // from Table1
        $this->db->join('teacher as tr', 'tr.teacher_id=cls.teacher_id');
        $this->db->join('academic_syllabus as AS', 'AS.academic_syllabus_id = AS.academic_syllabus_id');
        $this->db->join('document as D', 'D.document_id = D.document_id');
        $this->db->where('cls.class_id', $class_id);
        $result = $this->db->get()->result_array();
        return $result;
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
    public function delete($param2)
    {
        $this->db->where('class_routine_id', $param2);
        $this->db->delete($this->_table);
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

    
    function get_c_year_studnet_details_by_student_id($student_id,$year){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('en.school_id',$school_id);
            } 
        }
        $this->db->select('s.name AS student_name,c.name AS class_name,se.name AS section_name,en.class_id,en.section_id');
        $this->db->from($this->_table_enroll." AS en")->join($this->_table_student." AS s","s.student_id=en.student_id");
        $this->db->join($this->_table_class." AS c","en.class_id=c.class_id");
        $this->db->join($this->_table_section." AS se","en.section_id=se.section_id");
        $rs=$this->db->where("en.year", $year)->where('en.student_id',$student_id)->get()->result_array();
        return $rs;
    }
    
    function get_c_year_details_by_day_section($day,$class_id,$section_id,$year){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('cr.school_id',$school_id);
            } 
        }
        $this->db->order_by("cr.time_start", "asc");
        $this->db->where('cr.day', $day);
        $this->db->where('cr.class_id', $class_id);
        $this->db->where('cr.section_id', $section_id);
        $this->db->where('cr.year', $year);
        $this->db->select('cr.*,su.name AS subject_name,t.name AS teacher_name');
        $this->db->from($this->_table." As cr");
        $this->db->join($this->_table_subject." AS su","cr.subject_id=su.subject_id");
        $this->db->join($this->_table_teacher." AS t","su.teacher_id=t.teacher_id");
        $routines = $this->db->get()->result_array();
        return $routines;
    }
    
    function get_subject_id($dataArr){ 
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->get_where('class_routine', $dataArr)->row()->subject_id;
         
    }
}
