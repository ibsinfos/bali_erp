<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Parent_model extends CI_Model {

    private $_table = "parent";
    private $_table_user_role_transaction = 'user_role_transaction';
    private $_table_country = "country";
    
    var $column_order = array(null, 'father_icard_no', 'father_name', 'father_profession','mother_profession','father_icard_type','mother_icard_no', 'cell_phone', 'email'); //set column field database for datatable orderable
    var $column_search = array('father_icard_no', 'father_name', 'father_profession','mother_profession','father_icard_type','mother_icard_no', 'cell_phone', 'email'); //set column field database for datatable searchable 
    var $order = array('parent.parent_id' => 'asc'); // default order 
    var $column_order_parent_report = array(null, 'enroll.enroll_code', 'parent.father_name','parent.father_profession', 'parent.cell_phone', 'parent.email','parent.isActive'); //set column field database for datatable orderable
    var $column_search_parent_report = array('enroll.enroll_code', 'parent.father_name','parent.father_mname','parent.father_lname', 'parent.father_profession', 'parent.cell_phone', 'parent.email','parent.isActive'); //set column field database for datatable searchable 
    var $order_parent_report = array('parent.father_name' => 'asc'); // default order 


    function __construct() {
        parent::__construct();
    }

    public function get_phone($parent_id)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return  $this->db->get_where('parent', array('parent_id' => $parent_id))->row()->cell_phone;
    }
    public function count_all() 
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->from($this->_table);
        return $this->db->count_all_results();
    }


    public function get_parents_array() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->order_by("father_name", "asc");
        $parents_array = $this->db->get('parent')->result_array();
        return $parents_array;
    }

    public function get_parent_list($school_id) {
        $this->db->where('school_id',$school_id);
        $this->db->select('parent_id id, father_name fname, father_mname mname, father_lname lname, email, cell_phone');
        $this->db->where(array('isActive' => '1', 'parent_status' => '1'));
        $this->db->order_by("father_name", "asc");
        $data = $this->db->get($this->_table)->result_array();

        if(count($data)){
            foreach($data as $k => $datum){
                $where = array('original_user_type' => 'P', 'main_user_id' => $datum['id'], 'school_id'=>$school_id);
                $this->db->from($this->_table_user_role_transaction);
                $this->db->where($where);
                $query = $this->db->get();
                $exist = $query->num_rows();
                if($exist){
                    $role_id = $query->row()->role_id;
                    $data[$k]['role_id'] = $role_id;
                }else{
                    $data[$k]['role_id'] = '';
                }
            }
        }
        return $data;
    }

    public function get_parent_record($dataArray, $column = "") {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $return = "";
        $parent_record = $this->db->get_where('parent', $dataArray)->row();
        if (!empty($column) && !empty($parent_record->$column)) {
            $return = $parent_record->$column;
        } else {
            $return = $parent_record;
        }
        return $return;
    }

    public function save_parent($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->set(array('user_type'=>'p'));
        $this->db->insert('parent', $dataArray);
        $parent_id = $this->db->insert_id();
         
        
        $link_data = array(
            'main_user_id' => $parent_id,
            'role_id' => 3,
            'user_type' => "P",
            'original_user_type' => "P"
            
        ); 
       
         $this->db->insert('user_role_transaction', $link_data);
        return $parent_id;
    }

    public function update_parent($dataArray, $condition) {
        $this->db->where($condition);
        $this->db->update('parent', $dataArray);
        return true;
    }

    public function delete_parent($dataArray) {
        $this->db->where($dataArray);
        $this->db->update('parent', array('isActive' => '0', 'change_time' => date('Y-m-d H:i:s')));
        return true;
    }

    function is_email_exists($email) {
        $return_val = $this->is_email_exists_inactive($email);
        return $return_val;
    }

    function is_email_exists_inactive($email) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $rs = $this->db->select('parent_id')->get_where('parent', array('email' => $email, 'isActive' => '1'))->result();
        if (count($rs) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function is_email_phone_exists($email, $phone) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $rs = $this->db->select('parent_id')->get_where('parent', array('email' => $email, 'cell_phone' => $phone, 'isActive' => 1))->result();
        if (count($rs) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function is_phone_exists($phone) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $rs = $this->db->select('parent_id')->get_where('parent', array('cell_phone' => $phone, 'isActive' => 1))->result();
        if (count($rs) > 0) {
            return TRUE;
        } else {
            return FALSE;
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

    function save_parent_of_students_enquired($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->set(array('user_type'=>'p'));
        $this->db->insert('parent', $dataArray);
        $parent_id = $this->db->insert_id();
        return $parent_id;
    }

    function update_parent_of_students_enquired($dataArray, $condition) {
        $this->db->where($condition);
        $this->db->update('parent', $dataArray);
        return true;
    }

    function get_all() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $query = $this->db->get('parent');
        return $query->result();
    }

    function get_parent_byId($parent_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $query = $this->db->get('parent');
        return $query->result();
    }

    function get_all_by_year($year1, $year2) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql = "SELECT * FROM parent WHERE (YEAR(date_time)='".$year1."' OR YEAR(date_time)='". $year2."') AND school_id = '".$school_id."'";
            } 
        } else {
            $sql = "SELECT * FROM parent WHERE YEAR(date_time)='" . $year1 . "' OR YEAR(date_time)='" . $year2 . "'";
        }
        return $this->db->query($sql)->result_array();
    }

    public function get_student_teacher_details($student_id, $year) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('std.school_id',$school_id);
            } 
        }
        $this->db->select("std.student_id , par.parent_id , sec.name as section_name , sec.section_id , cls.name as class_name , cls.class_id , cls.teacher_id , enr.enroll_id , enr.year as academic_year, t.name as teacher_name");
        $this->db->from("student AS std");
        $this->db->join('enroll AS enr', 'std.student_id = enr.student_id');
        $this->db->join('parent AS par', 'std.parent_id = par.parent_id');
        $this->db->join('class AS cls', 'enr.class_id = cls.class_id');
        $this->db->join('section AS sec', 'enr.section_id = sec.section_id');
        $this->db->join('teacher AS t', 't.teacher_id = cls.teacher_id');
        $this->db->where('std.student_id', (int) $student_id);
        $this->db->where('enr.year', $year);
        $result = $this->db->get()->result_array();
        return $result;
    }

    /*     * *****************parent_api********************** */

    function get_student_list($section_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->select('*')
                ->from('enroll')
                ->where(array('section_id' => $section_id))
                ->join('student', 'student.student_id = enroll.student_id');
        $result = $this->db->get()->result_array();
        return $result;
    }

    function get_manage_mark($student_id, $exam_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->select('mark.subject_id,mark_obtained,mark_total,comment,name')
                ->from('mark')
                ->where(array('mark.student_id' => $student_id, 'exam_id' => $exam_id))
                ->join('subject', 'subject.subject_id = mark.subject_id');
        $result = $this->db->get()->result_array();

        return $result;
    }

    function get_subject_list($student_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('student.school_id',$school_id);
            } 
        }
        $this->db->select('subject_id,subject.name As subjectname,teacher.name AS teacher_name,teacher.email As Teacher_email')
                ->from('student')
                ->where(array('student.student_id' => $student_id))
                ->join('enroll', 'enroll.student_id = student.student_id')
                ->join('subject', 'subject.section_id = enroll.section_id')
                ->join('teacher', 'subject.teacher_id=teacher.teacher_id');
        $result = $this->db->get()->result_array();

        return $result;
    }

    function get_progress_report($student_id, $subject_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('progress_report.school_id',$school_id);
            } 
        }
        $this->db->select('progress_report.subject_id,student_id,comment,rate,timestamp,subject.name AS subjectname,teacher.name')
                ->from('progress_report')
                ->where(array('progress_report.student_id' => $student_id, 'progress_report.subject_id' => $subject_id))
                ->join('subject', 'subject.subject_id = progress_report.subject_id')
                ->join('teacher', 'teacher.teacher_id = progress_report.teacher_id');
        $result = $this->db->get()->result_array();
        return $result;
    }

    function get_class_routine($student_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('enroll.school_id',$school_id);
            } 
        }
        $this->db->select('class_routine.class_routine_id,class_routine.class_id,class_routine.section_id,class_routine.subject_id,time_start,time_end,day,subject.name AS subjectname,teacher.name AS teachername')
                ->from('enroll')
                ->where(array('enroll.student_id' => $student_id))
                ->join('class_routine', 'class_routine.class_id = enroll.class_id')
                ->join('subject', 'subject.section_id = enroll.section_id')
                ->join('teacher', 'teacher.teacher_id = subject.teacher_id');
        $result = $this->db->get()->result_array();
        return $result;
    }

    /*     * *******************parent_api********************* */

    function getallparents($class_id, $running_year) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('parent.school_id',$school_id);
            } 
        }
        $this->db->select('*, parent.email as parent_email'); // Select field
        $this->db->from('parent'); // from Table1
        $this->db->join('student', 'parent.parent_id = student.parent_id');
        $this->db->join('enroll', 'student.student_id = enroll.student_id');
        $this->db->where('enroll.class_id', $class_id);
        $this->db->where('enroll.year', $running_year); /// Join table1 with table2 based on the foreign key
        $this->db->where('student.isActive', '1'); // Set Filter
        $this->db->order_by('parent.father_name', 'asc');
        $res = $this->db->get()->result_array();
        return $res;
    }

    function getall_active_parents($class_id, $running_year) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('parent.school_id',$school_id);
            } 
        }
        $this->db->select('*, parent.email as parent_email'); // Select field
        $this->db->from('parent'); // from Table1
        $this->db->join('student', 'parent.parent_id = student.parent_id');
        $this->db->join('enroll', 'student.student_id = enroll.student_id');
        $this->db->where('enroll.class_id', $class_id);
        $this->db->where('enroll.year', $running_year); /// Join table1 with table2 based on the foreign key
        $this->db->where('student.isActive', '1'); // Set Filter
        $this->db->where('student.student_status', '1');
        $this->db->order_by('parent.father_name', 'asc');
        $res = $this->db->get()->result_array();
        return $res;
    }

    function getstudents_section($class_id, $running_year, $section_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('parent.school_id',$school_id);
            } 
        }
        $this->db->select('*, parent.email as parent_email'); // Select field
        $this->db->from('parent'); // from Table1
        $this->db->join('student', 'parent.parent_id = student.parent_id');
        $this->db->join('enroll', 'student.student_id = enroll.student_id');
        $this->db->where('enroll.class_id', $class_id);
        $this->db->where('enroll.section_id', $section_id);
        $this->db->where('enroll.year', $running_year); /// Join table1 with table2 based on the foreign key
        $this->db->where('student.isActive', '1'); // Set Filter
        $this->db->order_by('parent.father_name', 'asc');
        $res = $this->db->get()->result_array();
        return $res;
    }

    function parent_list_with_advance_filter($whereCondition) {
        
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                if(empty($whereCondition)) { 
                    $whereCondition .= "WHERE p.school_id = '".$school_id."'"; 
                } else {
                    $whereCondition .= " AND p.school_id = '".$school_id."'";
                }
            } 
        }
        $sql = "SELECT p.*,p.email as parent_email,e.enroll_code FROM `parent` AS p JOIN `student` AS s ON(s.parent_id=p.parent_id) JOIN `enroll` AS e ON(e.student_id=s.student_id) " . $whereCondition . " GROUP BY p.parent_id";

        $dataArr = $this->db->query($sql)->result_array();
        return $dataArr;
    }

    public function enable_disable_parent($dataArray) {
        $status = $this->db->select('parent_status')->from('parent')->where($dataArray)->get()->row();
        $status_rs = $status->parent_status == '1' ? '0' : '1';

        $this->db->where($dataArray);
        $this->db->update('parent', array('parent_status' => $status_rs, 'change_time' => date('Y-m-d H:i:s')));

        $result = $this->db->select('student_id')->from('student')->where($dataArray)->get()->result_array();

        if (count($result)) {
            $this->db->update('student', array('student_status' => '0', 'change_time' => date('Y-m-d H:i:s')), $dataArray);
        }

        return $status_rs;
    }

    function get_parent_name($parent_id) {
        $sql = "select father_name,father_lname,mother_name,mother_lname from parent where parent_id = $parent_id";

        $dataArr = $this->db->query($sql)->result_array();
        return $dataArr;
    }

    function get_email_id($parent_id) {
        $sql = "select father_name,father_lname,email from parent where parent_id = $parent_id";
        $dataArr = $this->db->query($sql)->result_array();
        return $dataArr;
    }

    function get_parent_id($parent_email)
    {
       return $this->db->get_where($this->_table,array('email' => $parent_email))->row()->parent_id;
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
    // GET DATATABLE OF PARENT
    private function _get_datatables_query() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->from($this->_table);
        $this->db->where('isActive', '1');

        $i = 0;

        foreach ($this->column_search as $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search

                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    
    function get_datatables() {
        $list = $this->_get_datatables_query();
        if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
   
    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    function get_attedance_by($section_id,$class_id,$running_year,$timestamp,$student_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->group_by('timestamp');
        $attendance = $this->db->get_where('attendance', array('section_id' => $section_id, 'class_id' => $class_id, 'year' => $running_year, 'timestamp' => $timestamp, 'student_id' => $student_id))->result_array();
        return $attendance;         
    }
    private function _get_datatables_query_parent_misc_report_all($class_id,$running_year) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('parent.school_id',$school_id);
            } 
        }
        
        $this->db->select('*, parent.email as parent_email'); // Select field
        $this->db->from('parent as parent'); // from Table1
        $this->db->join('student as student', 'parent.parent_id = student.parent_id');
        $this->db->join('enroll as enroll', 'student.student_id = enroll.student_id');
        $this->db->where('enroll.class_id', $class_id);
        $this->db->where('enroll.year', $running_year); /// Join table1 with table2 based on the foreign key
        $this->db->where('student.isActive', '1'); // Set Filter

        $i = 0;
        foreach ($this->column_search_parent_report as $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search

                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search_parent_report) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order_parent_report[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order_parent_report)) {
            $order = $this->order_parent_report;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_datatables_parent_misc_report($class_id,$running_year) {
        $list = $this->_get_datatables_query_parent_misc_report_all($class_id,$running_year);
        if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    
   function count_filtered_parent_misc_report($class_id,$running_year){
        $this->_get_datatables_query_parent_misc_report_all($class_id,$running_year);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_parent_misc_report($class_id,$running_year) {
        $this->_get_datatables_query_parent_misc_report_all($class_id,$running_year);
        return $this->db->count_all_results();
    }
        private function _get_datatables_query_parent_misc_report_sections($class_id,$running_year,$section_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('parent.school_id',$school_id);
            } 
        }
        $this->db->select('*, parent.email as parent_email'); // Select field
        $this->db->from('parent as parent'); // from Table1
        $this->db->join('student as student', 'parent.parent_id = student.parent_id');
        $this->db->join('enroll as enroll', 'student.student_id = enroll.student_id');
        $this->db->where('enroll.class_id', $class_id);
        $this->db->where('enroll.section_id', $section_id);
        $this->db->where('enroll.year', $running_year); /// Join table1 with table2 based on the foreign key
        $this->db->where('student.isActive', '1'); // Set Filter
        $i = 0;
        foreach ($this->column_search_parent_report as $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search

                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_order_parent_report) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order_parent_report[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order_parent_report)) {
            $order = $this->order_parent_report;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_datatables_parent_misc_report_sections($class_id,$running_year,$section_id) {
        $list = $this->_get_datatables_query_parent_misc_report_sections($class_id,$running_year,$section_id);
        if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    

   function count_filtered_parent_misc_report_sections($class_id,$running_year,$section_id){
        $this->_get_datatables_query_parent_misc_report_sections($class_id,$running_year,$section_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_parent_misc_report_sections($class_id,$running_year,$section_id) {
        $this->_get_datatables_query_parent_misc_report_sections($class_id,$running_year,$section_id);
        return $this->db->count_all_results();
    }

    function get_parent_image($id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->get_where('parent', array('parent_id' => $id))->row()->parent_image;
    }

    function get_parent_details($parent_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('p.school_id',$school_id);
            } 
        }
        $this->db->select('p.*, c.name country_name, s.name state_name'); 
        $this->db->from($this->_table.' p');
        $this->db->join($this->_table_country.' c', 'c.location_id = p.country','LEFT');
        $this->db->join($this->_table_country.' s', 's.location_id = p.state','LEFT');
        //$this->db->where('p.parent_id', $parent_id);
        $this->db->where_in('p.parent_id',$parent_id);
        $this->db->where('p.isActive','1');
        $this->db->where('p.parent_status','1');
        $res = $this->db->get()->result_array();
        return $res;
    }

    function get_parent_details_by_id($parent_id='') {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('p.school_id',$school_id);
            } 
        }
        $this->db->select('p.*'); 
        $this->db->from($this->_table.' p');        
        $this->db->where('p.parent_id', $parent_id);
        $this->db->where('p.isActive', '1');
        $this->db->where('p.parent_status', '1');
        $res = $this->db->get()->row();
        return $res;
    }

}
