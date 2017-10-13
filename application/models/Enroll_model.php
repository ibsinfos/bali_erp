<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Enroll_model extends CI_Model {

    private $_table = "enroll";

    function __construct() {
        parent::__construct();
    }
    
    public function add($data) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
            } 
        }
        $sql = $this->db->insert($this->_table, $data);
        return $sql;
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
        return $rs;
    }

    function get_student($class_id, $section_id,$year) {
        $school_id = ''; $where = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $where = " and s.school_id = '".$school_id."'";
            } 
        }
        $sql = 'select s.name,s.student_id from student s , enroll e where e.class_id="' . $class_id . '" and e.section_id="' . $section_id . '"and e.year="' . $year . '" and s.student_id=e.student_id'.$where;
        $rs = $this->db->query($sql)->result();
        return $rs;
    }

    function get_student_list_teacher_api($classId) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('enroll.school_id',$school_id);
            } 
        }
        $this->db->select('enroll.student_id,student.*')
                ->from('enroll')
                ->where(array('class_id' => $classId))
                ->join('student', 'student.student_id = enroll.student_id');
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_student_array($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $return = array();
        $this->db->select("*");
        $this->db->from("enroll");
        if (!empty($dataArray)) {
            $this->db->where($dataArray);
        }
        $return = $this->db->get()->result_array();
        return $return;
    }

    function get_all_enroll_student_report() {
        $school_id = ''; $where = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $where = " WHERE e.school_id = '".$school_id."'";
            } 
        }
        $sql = "SELECT DISTINCT count(student_id) AS TotalStudent,e.class_id,c.name FROM `enroll` AS e LEFT JOIN class AS c ON(e.class_id=c.class_id) ".$where." GROUP BY class_id ORDER by class_id ASC";
        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }

    function get_class_id_bystudent_id($student_id, $year) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $rs = $this->db->get_where('enroll', array('student_id' => $student_id, 'year' => $year))->row()->class_id;
        return $rs;
    }

    function get_section_id_bystudent_id($student_id, $year) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $rs = $this->db->get_where('enroll', array('student_id' => $student_id, 'year' => $year))->row()->section_id;
        return $rs;
    }

    public function get_alloted_students_count($class_id, $year) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('enroll.school_id',$school_id);
            } 
        }
        $return = array();
        $this->db->select("count(enroll.student_id) as count");
        $this->db->from("enroll");
        $this->db->join("student", 'student.student_id=enroll.student_id');
        $this->db->where('enroll.class_id', $class_id);
        $this->db->where('enroll.year', $year);
        $this->db->where('student.isActive', '1');
        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_alloted_students_count_by_section($class_id, $section_id, $year) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('enroll.school_id',$school_id);
            } 
        }
        $return = array();
        $this->db->select("count(student_id) as count");
        $this->db->from("enroll");
        $this->db->where('class_id', $class_id);
        $this->db->where('section_id', $section_id);
        $this->db->where('year', $year);
        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_alloted_students_count_by_class($class_id, $year) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('enroll.school_id',$school_id);
            } 
        }
        $return = array();
        $this->db->select("count(student_id) as count");
        $this->db->from("enroll");
        $this->db->where('class_id', $class_id);
        $this->db->where('year', $year);
        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_class_section_by_student($student_id = '', $year = '') {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('enr.school_id',$school_id);
            } 
        }
        $this->db->select('cls.name as class_name, sec.name as section_name, enr.student_id, enr.class_id as class_id, enr.section_id as section_id');
        $this->db->from('enroll as enr');
        $this->db->join('class as cls', 'cls.class_id = enr.class_id');
        $this->db->join('section as sec', 'sec.section_id = enr.section_id');
        $this->db->where('enr.student_id', $student_id);
        $this->db->where('enr.year', $year);
        $return = $this->db->get()->row();
        return $return;
    }

    public function enroll_update($dataArray, $condition) {
        $this->db->where($condition);
        $this->db->update($this->_table, $dataArray);
        return true;
    }

    function get_latest_roll_no($class_id, $section_id) {
        $school_id = ''; $where = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $where = "AND school_id = '".$school_id."'";
            } 
        }
        $sql = "SELECT `roll` FROM `" . $this->_table . "` WHERE `class_id`='" . $class_id . "' AND `section_id`='" . $section_id . "' ".$where." ORDER BY roll DESC LIMIT 0,1";
        $rs = $this->db->query($sql)->result();
        $latestNo = $rs[0]->roll;
        return $latestNo;
    }

    function check_student_before_delete_section($section_id, $class_id, $year) {
        $school_id = ''; $where = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $where = "AND enroll.school_id = '".$school_id."'";
            } 
        }
        $sql = "select enroll.student_id from enroll as enroll JOIN student as student on(enroll.student_id=student.student_id) where enroll.section_id='$section_id' and enroll.class_id='$class_id' and enroll.year='$year' and student.isActive='1'".$where;
        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }

    function check_student_before_delete_class($class_id, $year) {
        $school_id = ''; $where = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $where = "AND enroll.school_id = '".$school_id."'";
            } 
        }
        $sql = "select enroll.student_id from enroll as enroll JOIN student as student on(enroll.student_id=student.student_id) where enroll.class_id='".$class_id."' and enroll.year='".$year."' and student.isActive='1'".$where;
        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }

    public function get_enrollid_by_student($student_id = '', $year = '') {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        }
        $enroll_id = $this->db->select('enroll_code')->from('enroll')->where(array('student_id' => $student_id, 'year' => $year))->get()->row();
        return $enroll_id;
    }

    function get_students($class_id, $section_id, $year) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('enroll.school_id',$school_id);
            } 
        }
        $return = array();
        $this->db->select("enroll.student_id,student.name,student.lname");
        $this->db->from("enroll");
        $this->db->join('student', 'student.student_id = enroll.student_id');
        $this->db->where("class_id", $class_id);
        $this->db->where("section_id", $section_id);
        $this->db->where("year", $year);
        $this->db->where('isActive', '1');
        $this->db->where('student_status', '1');
        $return = $this->db->get()->result_array();
        //echo $this->db->last_query();
        return $return;
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
          /*echo 'Enroll_model'.'<br/>';
          echo $this->db->last_query(); die();*/
        return $rs;
    }
    
    function update_data($data,$condition){
        $this->db->where($condition);
        $this->db->update($this->_table, $data);
        return true;
    }
    
    function runQuery($query){
       return $this->db->query($query)->result_array();
    }
    
    function get_all_enroll_student_by_section($section_id,$running_year){
        $school_id = ''; $where = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $where = "AND e.school_id = '".$school_id."'";
            } 
        }
        $sql="SELECT s.name AS StudentName,s.student_id,e.section_id,se.name AS SectionName,c.name AS ClassName "
                . " FROM ".$this->_table." AS e,student AS s,section AS se,class AS c "
                . " WHERE e.student_id=s.student_id AND e.section_id=se.section_id AND  e.class_id=c.class_id AND s.student_status='1' AND "
                . " e.year='".$running_year."' AND e.section_id='".$section_id."' ".$where." ORDER BY se.section_id ASC";
        return $this->db->query($sql)->result();
    }
}
