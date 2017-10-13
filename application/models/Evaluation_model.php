<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Evaluation_model extends CI_Model {
    private $_table="evaluation_method";
    private $_grade = "grade";
            function __construct() {
        parent::__construct();
    }

//Input student_id,exam_id

    public function get_name($param)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->from('evaluation_method')->like('name', trim($param))->get()->result();
        
    }
    public function get_cwa_marks($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('exam.school_id',$school_id);
            } 
        }
        $evaluation_id = $this->db->get_where('evaluation_method', array('name' => 'CWA'))->row()->evaluation_id;
        $dataArray['grading'] = $evaluation_id;
        $this->db->select('*')
                ->from('exam')
                ->where($dataArray)
                ->join('mark', 'mark.exam_id = exam.exam_id')
                ->join('cwa_subjects', 'cwa_subjects.subject_id = mark.subject_id');
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_gpa_marks($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('exam.school_id',$school_id);
            } 
        }
        $evaluation_id = $this->db->get_where('evaluation_method', array('name' => 'GPA'))->row()->evaluation_id;
        $dataArray['grading'] = $evaluation_id;
        $this->db->select('*')
                ->from('exam')
                ->where($dataArray)
                ->join('mark', 'mark.exam_id = exam.exam_id')
                ->join('gpa_subjects', 'gpa_subjects.subject_id = mark.subject_id');
        $result = $this->db->get()->result_array();

        return $result;
    }

    function get_exams($evaluation) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $evaluation_id = $this->db->get_where('evaluation_method', array('name' => $evaluation))->row()->evaluation_id;
        
        $result = $this->db->get_where('exam', array('grading' => $evaluation_id))->result_array();

        return $result;
    }
    function get_all_grade($param2)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->get_where('grade', array('grade_id' => $param2))->result_array();
    }
    function get_grade_value(){
        $this->db->select('grade.*, evaluation_method.name as evaluation_method');
        $this->db->from('grade');
        $this->db->join('evaluation_method', 'evaluation_method.evaluation_id=grade.evaluation_id');
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('evaluation_method.school_id',$school_id);
            } 
        }
        
        $this->db->order_by('grade.grade_id','DESC');
        $query = $this->db->get();
        //echo $this->db->last_query(); die();
        
        /*$this->db->join('grading_evaluation b', 'b.grade_id=a.grade_id', 'left');*/
        
        
        return $query->result_array();
        
        /*return $this->db->get('grade')->result_array();*/
    }
    function get_grade($mark_obtained, $evaluation_method) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('a.school_id',$school_id);
            } 
        }
        $evaluation_id = $this->db->get_where('evaluation_method', array('name' => strtoupper($evaluation_method)))->row()->evaluation_id;
        $this->db->select('*');
        $this->db->from('grade a');
        $this->db->join('grading_evaluation b', 'b.grade_id=a.grade_id', 'left');
        $this->db->where(array('a.mark_from <=' => $mark_obtained, 'a.mark_upto >' => $mark_obtained, 'b.evaluation_id' => $evaluation_id));

        $query = $this->db->get();

        if ($query->num_rows() != 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function delete_ranking($id, $evaluation_method) {
        $table_name = strtolower($evaluation_method) . '_ranking';
        $this->db->where(array('ranking_id' => $id));
        $this->db->delete($table_name);
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
    
    function get_data_by_cols_table($table,$columnName="*",$conditionArr=array(),$return_type="result",$sortByArr=array(),$limit=""){
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
            $rs=$this->db->get($table)->result();
        }else{
            $rs=$this->db->get($table)->result_array();
        }

        return $rs;
    }
    
    public function get_name_bulk_upload($param){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->from('evaluation_method')->where('LOWER(name)', strtolower(trim($param)))->get()->result();
        
    }
}
