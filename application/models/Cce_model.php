<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cce_model extends CI_Model {
    
    private $_table="cce_classes";
    private $_cce_setting = "cce_settings";
    private $_table_ibo_class_program = "ibo_class_program";
    private $_table_ibo_programs = "ibo_programs";
    function __construct() {
        parent::__construct();
    }

    public function update($data)
    {
         $this->db->update($this->_cce_setting, $data);
    }

    public function get_cce_classes($dataArray='') {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $return = array();
        $dataArray['evaluation_id'] = $this->db->get_where('evaluation_method', array('name' => 'CCE'))->row()->evaluation_id;
        $this->db->select("*");
        $this->db->from('cce_classes AS A');
        $this->db->join('class AS B', 'A.class_id = B.class_id', 'INNER');
        if (!empty($dataArray)) {
            $this->db->where($dataArray);
        }
        $return = $this->db->get()->result_array();
        return $return;
    }


    public function get_cce_subjects($dataArray)
    {
        _school_cond('A.school_id');
        $this->db->select("*");
        $this->db->from('cce_subjects AS A');
        $this->db->join('subject AS B', 'A.subject_id = B.subject_id', 'INNER');
        $this->db->order_by('B.name','ASC');
        if (!empty($dataArray))
        {
            $this->db->where($dataArray);
        }
        $return = $this->db->get()->result_array();

        return $return;
    }

    public function cce_coscholastic_activities($dataArray, $condition){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->select("*");
        $this->db->from('cce_coscholatic_activities');
        if (!empty($dataArray))
        {
            $this->db->where($dataArray, $condition);
        }
        $cs_activity =$this->db->get()->result_array();
        return $cs_activity;
    }
    

    public function add_cs_activities($dataArray){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('cce_coscholatic_activities', $dataArray);
        $id = $this->db->insert_id();
        return $id;
    }

     public function update_cs_activities($data, $condition){
        $this->db->where('csa_id', $condition);
        $this->db->update('cce_coscholatic_activities', $data);
        return true;
    }

    public function delete_cs_activities($csa_id){
        $this->db->where(array('csa_id' => $csa_id));
        $this->db->delete('cce_coscholatic_activities');
        return true;
    }

    public function csa_marks_of_students($dataArray){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $csa_marks = $this->db->get_where('cce_coscholatic_grades', $dataArray)->result_array();
        return $csa_marks;
    }
	
    public function get_cwa_subjects($dataArray) {
        /*$school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('cwa_subjects.school_id',$school_id);
            } 
        }*/
        _school_cond('A.school_id');
        $this->db->select("*");
        $this->db->from('cwa_subjects AS A');
        $this->db->join('subject AS B', 'A.subject_id = B.subject_id', 'INNER');
        if (!empty($dataArray)) {
            $this->db->where($dataArray);
        }
        $return = $this->db->get()->result_array();

        return $return;
    }

    public function connect_cwa_exam($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('cwa_exam_weightage', $dataArray);
        $id = $this->db->insert_id();
        return $id;
    }

    public function connect_gpa_exam($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('gpa_exam_weightage', $dataArray);
        $id = $this->db->insert_id();
        return $id;
    }

    public function save_cwa_subject($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('cwa_subjects', $dataArray);
        $id = $this->db->insert_id();
        return $id;
    }

    public function save_gpa_subject($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('gpa_subjects', $dataArray);
        $id = $this->db->insert_id();
        return $id;
    }

    public function get_gpa_subjects($dataArray) {
        /*$school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('gpa_subjects.school_id',$school_id);
            } 
        }*/
        _school_cond('A.school_id');
        $this->db->select("*");
        $this->db->from('gpa_subjects AS A');
        $this->db->join('subject AS B', 'A.subject_id = B.subject_id', 'INNER');
        if (!empty($dataArray)) {
            $this->db->where($dataArray);
        }
        $return = $this->db->get()->result_array();

        return $return;
    }

    public function save_cce_subject($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('cce_subjects', $dataArray);
        $id = $this->db->insert_id();
        return $id;
    }

    public function ibo_add_assessments($dataArray){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('ibo_subject_assessments', $dataArray);
        $id = $this->db->insert_id();
        return $id;
    }

    public function is_program_connect_to_class($program_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
       $rs=$this->db->get_where($this->_table_ibo_class_program, array('program_id' => $program_id))->result();
       return $rs;
    }

    public function delete_ibo_program($program_id) {
       $this->db->where(array('program_id' => $program_id));
       $this->db->delete('ibo_programs');
       return true;
    }

    public function get_ibo_assessment($class_id='', $subject_id=''){
        /*$school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('isa.school_id',$school_id);
            } 
        }*/
        _school_cond('isa.school_id');
        $this->db->select("isa.*,c.name As class_name, s.name As subject_name ");
        $this->db->from('ibo_subject_assessments AS isa');
        $this->db->join('class AS c', 'isa.class_id = c.class_id', 'INNER');
        $this->db->join('subject AS s', 'isa.subject_id = s.subject_id', 'INNER');
        if ($class_id!="") {
            $this->db->where('isa.class_id', $class_id);
        }
        if ($subject_id!="") {
            $this->db->where('isa.subject_id', $subject_id);
        }
        $result = $this->db->get()->result_array();
        //echo $this->db->last_query();
        return $result;
    }

    public function update_ibo_program($data, $condition) {
        $this->db->where('program_id', $condition);
        $this->db->update($this->_table_ibo_programs, $data);
        return true;
    }

    public function update_cce_subject($dataArray, $condition) {
        $this->db->where($condition);
        $this->db->update('cce_subjects', $dataArray);
        return true;
    }

    public function update_gpa_subject($dataArray, $condition) {
        $this->db->where($condition);
        $this->db->update('gpa_subjects', $dataArray);
        return true;
    }

    public function delete_gpa_subject($subject_id) {
        $this->db->where(array('subject_id' => $subject_id));
        $this->db->delete('gpa_subjects');
    }

    public function save_cce_grade($dataArray = '', $condition = '') {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('grading_evaluation', $dataArray);
        $id = $this->db->insert_id();
        return $id;
    }

    public function delete_class($class_id) {
        $cce_evaluation_id = $this->db->get_where('evaluation_method', array('name' => "CCE"))->row()->evaluation_id;
        $this->db->where(array('class_id' => $class_id));
        $this->db->delete('cce_classes');
    }

    public function delete_subject($subject_id) {
        $cce_evaluation_id = $this->db->get_where('evaluation_method', array('name' => "CCE"))->row()->evaluation_id;
        $this->db->where(array('subject_id' => $subject_id));
        $this->db->delete('cce_subjects');
    }

    public function get_cce_setting($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->select($dataArray);
        $result = $this->db->get('cce_settings');
        return $result->row()->$dataArray;
    }

    public function update_cce_setting($data){

        $this->db->update('cce_settings', $data);
        echo $this->db->last_query();
        return true;
    }

    public function get_all_subject() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $return = array();
        $this->db->select("*");
        $this->db->from("subject");
        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_subjects($class_id, $teacher_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $return = array();
        $return = $this->db->get_where("subject", array('class_id' => $class_id, 'teacher_id' => $teacher_id))->result_array();
        return $return;
    }

    public function update_data($condition, $UpdateData) {
        $this->db->where($condition);
        $this->db->update('grade', $UpdateData);
        return true;
    }

    function save_grade($data) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
            } 
        }
        $this->db->insert('grade', $data);
        return $this->db->insert_id();
    }

    function delete_grade($grade_id) {
        $this->db->where('grade_id', $grade_id);
        $this->db->delete('grade');
        /*$this->db->where('grade_id', $grade_id);
        $this->db->delete('grading_evaluation');*/
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
    
    function get_class_by_evaluation_id($id){
        //if normal grading method then $id=1
        if($id == 1){
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                    $this->db->where('c.school_id',$school_id);
                } 
            }
            $this->db->select('c.name,c.class_id')->from('class AS c')->where('c.class_id NOT IN (select cc.class_id from cce_classes as cc)',NULL,FALSE);
             $rs= $this->db->get()->result_array();
        }else{
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                    $this->db->where('cc.school_id',$school_id);
                } 
            }
            $this->db->select('c.name,c.class_id')->from('cce_classes AS cc')->join('class AS c','c.class_id=cc.class_id')->where('cc.evaluation_id',$id);
            $rs= $this->db->get()->result_array();
        }
        //echo $this->db->last_query(); die();
        return $rs;
    }

    public function delete_cwa_subject($subject_id) {
        $cce_evaluation_id = $this->db->get_where('evaluation_method', array('name' => "CWA"))->row()->evaluation_id;
        $this->db->where(array('subject_id' => $subject_id));
        $this->db->delete('cwa_subjects');
    }

    public function update_cwa_subject($dataArray, $condition) {
        $this->db->where($condition);
        $this->db->update('cwa_subjects', $dataArray);
        return true;
    }

    /*ICSE Grading Method*/
    public function save_icse_subject($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('icse_subjects', $dataArray);
        $id = $this->db->insert_id();
        return $id;
    }

    public function get_icse_subjects($dataArray)
    {
        /*$school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('icse_subjects.school_id',$school_id);
            } 
        }*/

        $this->db->select("*");
        $this->db->from('icse_subjects AS A');
        $this->db->join('subject AS B', 'A.subject_id = B.subject_id', 'INNER');
        $this->db->order_by('B.name','ASC');
        if (!empty($dataArray))
        {
            $this->db->where($dataArray);
        }
        $return = $this->db->get()->result_array();

        return $return;
    }

    public function delete_icse_subject($subject_id) {
        $icse_evaluation_id = $this->db->get_where('evaluation_method', array('name' => "ICSE"))->row()->evaluation_id;
        $this->db->where(array('subject_id' => $subject_id));
        $this->db->delete('icse_subjects');
    }

    public function update_icse_subjects($UpdateData, $condition) {
        $this->db->where($condition);
        $this->db->update('icse_subjects', $UpdateData);
        return true;
    }

    public function get_icse_classes($dataArray='') {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $return = array();
        $dataArray['evaluation_id'] = $this->db->get_where('evaluation_method', array('name' => 'ICSE'))->row()->evaluation_id;
        $this->db->select("*");
        $this->db->from('cce_classes AS A');
        $this->db->join('class AS B', 'A.class_id = B.class_id', 'INNER');
        if (!empty($dataArray)) {
            $this->db->where($dataArray);
        }
        $return = $this->db->get()->result_array();
        return $return;
    }

    /*ICSE Grading Method*/

    /*Igcse Grading Method*/
    public function save_igcse_subject($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('igcse_subjects', $dataArray);
        $id = $this->db->insert_id();
        return $id;
    }

    public function get_igcse_subjects($dataArray)
    {
       /*_school_cond('A.school_id');*/
        $this->db->select("*");
        $this->db->from('igcse_subjects AS A');
        $this->db->join('subject AS B', 'A.subject_id = B.subject_id', 'INNER');
        $this->db->order_by('B.name','ASC');
        if (!empty($dataArray))
        {
            $this->db->where($dataArray);
        }
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('A.school_id',$school_id);
            } 
        }
        $return = $this->db->get()->result_array();

        return $return;
    }

    public function delete_igcse_subject($subject_id) {
        $icse_evaluation_id = $this->db->get_where('evaluation_method', array('name' => "IGCSE"))->row()->evaluation_id;
        $this->db->where(array('subject_id' => $subject_id));
        $this->db->delete('igcse_subjects');
    }

    public function update_igcse_subjects($UpdateData, $condition) {
        $this->db->where($condition);
        $this->db->update('igcse_subjects', $UpdateData);
        return true;
    }

    public function get_igcse_classes($dataArray='') {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $return = array();
        $dataArray['evaluation_id'] = $this->db->get_where('evaluation_method', array('name' => 'IGCSE'))->row()->evaluation_id;
        $this->db->select("*");
        $this->db->from('cce_classes AS A');
        $this->db->join('class AS B', 'A.class_id = B.class_id', 'INNER');
        if (!empty($dataArray)) {
            $this->db->where($dataArray);
        }
        $return = $this->db->get()->result_array();
        return $return;
    }

    /*Igcse Grading Method*/

    /*Ibo Marksheet*/
    function get_ibo_assessment_marks($student_id){
        $this->db->select('*');
        $this->db->from('ibo_marks');
        $this->db->join('ibo_exam', 'ibo_marks.exam_id = ibo_exam.exam_id');
        $this->db->join('subject', 'ibo_marks.subject_id = subject.subject_id');
        $this->db->join('ibo_subject_assessments', 'ibo_marks.assessment_id = ibo_subject_assessments.assessment_id');
        $this->db->join('ibo_exam_connect', 'ibo_exam_connect.ibo_exam_id = ibo_exam.ibo_exam_id');
        $this->db->where('ibo_marks.student_uid', $student_id);
        //$this->db->where('ibo_marks.subject_id', $sub_id);
        $this->db->where('ibo_exam_connect.ibo_connect_status', 1);
        $this->db->group_by('ibo_marks_id');
        
        $all_marks = $this->db->get()->result_array();
        return $all_marks;
    }
    /*Ibo Marksheet*/

    /*CCE marksheet*/
    function get_cce_assessment(){
        $this->db->select('*');
        $this->db->from('cce_internal_assessments');
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $assessment = $this->db->get()->result_array();
        /*echo $this->db->last_query(); 
        die();*/
        return $assessment;
    }
    function get_cce_marks($student_id){
        $this->db->select('*');
        $this->db->from('mark');
        $this->db->join('cce_exam', 'mark.exam_id = cce_exam.exam_id');
        $this->db->join('subject', 'mark.subject_id = subject.subject_id');
        $this->db->join('cce_exam_connect', 'cce_exam_connect.cce_exam_id = cce_exam.cce_id');
        $this->db->where('mark.student_id', $student_id);
        /*$this->db->where('mark.subject_id', $sub_id);*/
        $this->db->where('cce_exam_connect.cce_connect_status', 1);
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('mark.school_id',$school_id);
            } 
        }
        $this->db->group_by('mark_id');

        $all_marks = $this->db->get()->result_array();
        /*echo $this->db->last_query(); 
        die();*/
        return $all_marks;
    }
    /*CCE marksheet*/

    /*is student exixts for coscholastic grading*/
    function is_student_exixts($dataArray){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }

        $chkExist = $this->db->get_where('cce_coscholatic_grades', $dataArray)->result_array();

        return $chkExist;
    }
    /*is student exixts for coscholastic grading*/

    /*add_sudents_for_coscholastic_grading*/
    function add_sudents_to_csa($dataArray){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $add_students = $this->db->insert('cce_coscholatic_grades', $dataArray);
    }
    /*add_sudents_for_coscholastic_grading*/
}
