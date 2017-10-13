<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Section_model extends CI_Model {

    private $_table = "section";
    private $_primary = "section_id";

    function __construct() {
        parent::__construct();
    }

    public function single_name($section_id)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
       return $this->db->get_where($this->_table, array('section_id' => $section_id))->row()->name;
    }
     public function get_name_by_id($section_id)
    {
         $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                    $this->db->where('school_id',$school_id);
                } 
            }
       return $this->db->get_where($this->_table , array('section_id' => $section_id))->row()->name;
    }

    public function get_name($class_id, $val)
    {
        $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                    $this->db->where('school_id',$school_id);
                } 
            }
       return $this->db->from($this->_table)->where('class_id', $class_id)->like('name', trim($val))->get()->result();
    }

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

    function get_section_id($class_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $rs = $this->db->get_where($this->_table, array('class_id' => $class_id))->row()->section_id;
        return $rs;
    }
    
    function get_teachername_by_class_section($class_id, $section_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('t.school_id',$school_id);
            } 
        }
        $return = array();
        $this->db->select("t.teacher_id, t.name as teacher_name, t.email, t.cell_phone");
        $this->db->from("teacher as t");
        $this->db->join("section as s", 's.teacher_id = t.teacher_id');
        $this->db->where(array('s.class_id' => (INT) $class_id, 's.section_id' => (INT) $section_id));
        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_max_capacity($class_id) {
        $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                    $this->db->where('s.school_id',$school_id);
                } 
            }
        $this->db->select('SUM(max_capacity) as capacity');
        $this->db->from("section as s");
        $this->db->where('class_id', $class_id);
        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_max_capacity_by_section($class_id, $section_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('s.school_id',$school_id);
            } 
        }
        $this->db->select('SUM(max_capacity) as capacity');
        $this->db->from("section as s");
        $this->db->where('s.class_id', $class_id);
        $this->db->where('s.section_id', $section_id);
        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_class_deatils_by_teacher($teacher_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('sec.school_id',$school_id);
            } 
        }
        $this->db->select('sec.section_id, sec.class_id, sec.name as section, cls.class_id, cls.name as class');
        $this->db->from("section as sec");
        $this->db->join("class as cls", 'cls.class_id  =  sec.class_id');
        $this->db->where('sec.teacher_id', $teacher_id);
        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_max_capacity_by_class($class_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->select('SUM(max_capacity) as capacity');
        $this->db->from("section");
        $this->db->where('class_id', $class_id);
        $return = $this->db->get()->result_array();
        return $return;
    }
     public function get_section_by_classid($class_id) {
        $this->db->select('section_id,name');
        $this->db->from("section");
        $this->db->where('class_id', $class_id);
        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_section($class_id, $teacher_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql = "SELECT distinct section.name,section.section_id FROM subject s join section section on(s.section_id=section.section_id) where s.teacher_id='".$teacher_id."' and s.class_id='".$class_id."' and s.school_id = '".$school_id."' order by section.name";
            } 
        } else {
            $sql = "SELECT distinct section.name,section.section_id FROM subject s join section section on(s.section_id=section.section_id) where s.teacher_id='".$teacher_id."' and s.class_id='".$class_id."' order by section.name";
        }
        
        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }
    
    public function get_section_by_class($class_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->get_where('section' , array('class_id' => $class_id));
    }
    
    public function get_section_by_class_teacher($class_id,$teacher_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->get_where('section' , array('class_id' => $class_id,'teacher_id' => $teacher_id));
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

    function check_section($class_id, $name, $section_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->where(array('class_id' => $class_id, 'name' => $name));
        $this->db->where_not_in('section_id', $section_id);
        $this->db->from($this->_table);
        $cnt = $this->db->count_all_results(); 
        return $cnt;      
    }

    function check_room_no($room_no, $section_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->where(array('room_no' => $room_no));
        $this->db->where_not_in('section_id', $section_id);
        $this->db->from($this->_table);
        $cnt = $this->db->count_all_results(); 
        return $cnt;      
    }
    
    function get_class_name_by_section_id($section_id){
        $school_id = '';
        $school_id_sql="";
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                //$this->db->where('school_id',$school_id);
                $school_id_sql=" AND s.school_id=".$school_id;
            } 
        }
        $sql="SELECT c.name,c.class_id FROM class as c,section as s WHERE c.class_id=s.class_id AND s.section_id=".$section_id.$school_id_sql;
        $rs= $this->db->query($sql)->result_array();
        return $rs;
    }
    
    function automatic_timetable_get_all_section(){
        $year=$this->globalSettingsRunningYear;
        $sql = "SELECT distinct(s.section_id) section_id,c.name class_name, sc.name section_name FROM subject s, section sc, class c  WHERE c.class_id = s.class_id AND sc.section_id = s.section_id AND s.subject_id in (SELECT subject_id FROM schedule_restriction_info WHERE year='$year')";
        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }
}