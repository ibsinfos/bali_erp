<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Student_bus_allocation_model extends CI_Model {

    private $_table = "student_bus_allocation";

    function __construct() {
        parent::__construct();
    }

    public function get_details($id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql="SELECT sb.*,s.name,t.route_name,b.name FROM student_bus_allocation sb join transport t on(sb.route_id=t.transport_id)='".$id."' WHERE sb.school_id = '".$school_id."'";
            } 
        } else {
            $sql="SELECT sb.*,s.name,t.route_name,b.name FROM student_bus_allocation sb join transport t on(sb.route_id=t.transport_id)=$id";
        }
        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }
    public function updatebyId($dataArray, $student_bus_id){
        $this->db->where('student_bus_id',$student_bus_id);
        $this->db->update($this->_table, $dataArray);
        return true;
    }
    public function delete($student_bus_id){
        $this->db->where('student_bus_id',$student_bus_id);
        $this->db->delete($this->_table);
        return true;
    }
    
    /**
     * 
     * @param type $id
     * @return type
     */
    function get_data_by_id($id,$returnColsStr=""){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        if($returnColsStr==""){
            return $this->db->get_where($this->_table,array($this->_primary=>$id))->result();
        }else{
            return $this->db->select($returnColsStr)->from($this->_table)->where($this->_primary,$id)->get()->result();
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
    function get_data_by_cols($columnName="*",$conditionArr=array(),$return_type="result",$sortByArr=array(),$limit=""){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
            
        $this->db->select($columnName);
        $condition_type='and';
        if(array_key_exists('condition_type', $conditionArr)){
            if($conditionArr['condition_type']!=""){
                $condition_type=$conditionArr['condition_type'];
            }
        }
        unset($conditionArr['condition_type']);
        $condition_in_data_arr=array();
        $startCounter=0;
        $condition_in_column="";
        foreach($conditionArr AS $k=>$v){
            if($condition_type=='in'){
                if(array_key_exists('condition_in_data', $conditionArr)){
                    $condition_in_data_arr=  explode(',', $conditionArr['condition_in_data']);
                    $condition_in_column=$conditionArr['condition_in_col'];
                }

            }elseif($condition_type=='or'){
                if($startCounter==0){
                    $this->db->where($k,$v);
                }else{
                    $this->db->or_where($k,$v);
                }
            }elseif($condition_type=='and'){
                $this->db->where($k,$v);
            }
            $startCounter++;
        }

         if($condition_type=='in'){
             if(!empty($condition_in_data_arr))
                 $this->db->where_in($condition_in_column,$condition_in_data_arr);
        }

        if($limit!=""){
            $this->db->limit($limit);
        }

        foreach($sortByArr AS $key=>$val){
            $this->db->order_by($key,$val);
        }

        if($return_type=='result'){
            $rs=$this->db->get($this->_table)->result();
        }else{
            $rs=$this->db->get($this->_table)->result_array();
        }

        return $rs;
    }
    
    public function get_students_by_bus($bus_id=''){
        $this->load->model('Setting_model');
        $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('sba.school_id',$school_id);
            } 
        }
        $this->db->select("sba.* , sec.name as section_name, sec.section_id , cls.name as class_name , cls.class_id, "
                . "sec.teacher_id , enr.enroll_id , enr.class_id, enr.section_id, enr.enroll_code , "
                . "enr.year as academic_year, b.name as bus_name, stu.name, stu.lname");
        $this->db->from("student_bus_allocation as sba");
        $this->db->join('enroll AS enr', 'sba.student_id = enr.student_id');
        $this->db->join('class AS cls', 'enr.class_id = cls.class_id');
        $this->db->join('bus AS b', 'b.bus_id = sba.bus_id');
        $this->db->join('student AS stu', 'stu.student_id = sba.student_id');
        $this->db->join('section AS sec', 'enr.section_id = sec.section_id', 'left');
        $this->db->where(array('enr.year' => $running_year,'sba.bus_id' => $bus_id)); 
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    public function student_attendance($bus_id='', $year='', $timestamp=''){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->query("SELECT * FROM `student_bus_allocation` WHERE `bus_id`= " . $bus_id . "  AND `student_id` not in (SELECT `student_id` FROM `bus_driver_attendence` WHERE bus_id='".$bus_id."' AND `attendance_status`='1' OR `attendance_status`='0' AND school_id = '".$school_id."' AND `timestamp`=?)", $timestamp)->result_array();
            } 
        } else {
            $this->db->query("SELECT * FROM `student_bus_allocation` WHERE `bus_id`= " . $bus_id . "  AND `student_id` not in (SELECT `student_id` FROM `bus_driver_attendence` WHERE bus_id=$bus_id AND `attendance_status`=1 OR `attendance_status`=0 AND `timestamp`=?)", $timestamp)->result_array();
        }
    }

    function get_data4_fill_student_bus_allocation_table(){
        $this->db->select("ssf.student_id, ssf.trans_fee_id bus_stop_id, enr.enroll_code, rbs.route_id, b.bus_id");
        $this->db->from("sys_stud_feeconfig ssf");

        $this->db->join('enroll enr', 'ssf.student_id = enr.student_id');
        $this->db->join('route_bus_stop rbs', 'rbs.route_bus_stop_id = ssf.trans_fee_id');
        $this->db->join('bus AS b', 'b.route_id = rbs.route_id');
        $result = $this->db->get()->result_array();
        if(count($result)){
            foreach($result as $datum){
                $this->db->insert('student_bus_allocation', $datum);
            }
        }   
    }
    
    
    
}