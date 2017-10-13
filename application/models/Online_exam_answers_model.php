<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Online_exam_answers_model extends CI_Model {
    
     private $_table =   "online_exam_answers";

    function __construct() {
        parent::__construct();
    }
    
    public function add_data($data) {
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
    public function update_data($data, $id_condition) {
        $this->db->where($id_condition);
        $this->db->update($this->_table, $data);
        return true;
    }
    public function get_total($exam_id, $student_id) {
       $school_id = '';
        
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql="SELECT (sum(online_exam_answers.marks)/sum(questions.marks))*100 as result from online_exam_answers as online_exam_answers LEFT JOIN questions as questions on(online_exam_answers.exam_id=questions.exam_id) where online_exam_answers.exam_id='$exam_id' and online_exam_answers.student_id='$student_id' AND online_exam_answers.school_id = '".$school_id."'";
            } 
        } else {
            $sql="SELECT (sum(online_exam_answers.marks)/sum(questions.marks))*100 as result from online_exam_answers as online_exam_answers LEFT JOIN questions as questions on(online_exam_answers.exam_id=questions.exam_id) where online_exam_answers.exam_id='$exam_id' and online_exam_answers.student_id='$student_id'";
        }
        
        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }
    public function get_total_teacher_login($exam_id) {
       $school_id = '';
        
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql="SELECT (sum(online_exam_answers.marks)/sum(questions.marks))*100 as result from online_exam_answers as online_exam_answers LEFT JOIN questions as questions on(online_exam_answers.exam_id=questions.exam_id) where online_exam_answers.exam_id='$exam_id' AND online_exam_answers.school_id = '".$school_id."'";
            } 
        } else {
            $sql="SELECT (sum(online_exam_answers.marks)/sum(questions.marks))*100 as result from online_exam_answers as online_exam_answers LEFT JOIN questions as questions on(online_exam_answers.exam_id=questions.exam_id) where online_exam_answers.exam_id='$exam_id'";
        }
        
        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }
        /*
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
}


