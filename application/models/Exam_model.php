<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Exam_model extends CI_Model {

    private $_table = "exam";
     private $_primary="exam_id";
     public $_online = "online_exam";
     public $_enroll = "enroll";
     public $_mark = "mark";
     public $_ibo_marks = "ibo_marks";
     public $_student = "student";
      var $column_order = array(null, 'e.enroll_code', 's.name', 'm.mark_obtained', 'm.comment'); //set column field database for datatable orderable
    var $column_search = array('e.enroll_code', 's.name', 'm.mark_obtained', 'm.comment'); //set column field database for datatable searchable 
    var $order = array('m.mark_id' => 'asc'); // default order 

     
    function __construct() {
        parent::__construct();
    }
    
    function get_all_exam($running_year) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->get_where('exam' , array('year' => $running_year))->result_array();
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
    
    function get_exam_by_id($param2){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->get_where('exam', array('exam_id' => $param2))->result_array();
    }

    public function get_name_by_id($exam_id)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
       $query = $this->db->get_where('exam' , array('exam_id' => $exam_id))->row()->name;
       return $query;
    }
    
    public function remove_exam($id)
    {

        $this->db->where('exam_id', $id);
        $this->db->delete($this->_table);
    }

    public function online_exam_status($id,$data)
    {
        $this->db->where('id', $id);
        $this->db->update($this->_online, $data);
    }
    public function online_exam_save($data)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
                // pre($data);
                // die;
            } 
        }
         $this->db->insert($this->_online, $data);
    }
    public function get_online_data($param)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
       return $this->db->get_where($this->_online, array(
                    'id' => $param
                ))->result_array();
    }
    
    public function get_online_exam_data($conditionArr)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('online_exam.school_id',$school_id);
            } 
        }
        $this->db->select('online_exam.*,c.name AS class_name');
        $this->db->from($this->_online." AS online_exam");
        $this->db->join('class AS c','online_exam.class_id = c.class_id','left');
        $this->db->where($conditionArr);
        return $this->db->get()->result_array();
    }
    public function get_online_exam_data_teacher_login()
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('online_exam.school_id',$school_id);
            } 
        }
        $this->db->select('online_exam.*,c.name AS class_name');
        $this->db->from($this->_online." AS online_exam");
        $this->db->join('class AS c','online_exam.class_id = c.class_id','left');
        return $this->db->get()->result_array();
    }

    public function get_single_name($exam_id)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->get_where($this->_table, array('exam_id' => $exam_id))->row()->name;
    }

    public function get_all_online_data()
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('online_exam.school_id',$school_id);
            } 
        }
        $this->db->select('online_exam.*,c.name AS class_name');
        $this->db->from($this->_online." AS online_exam");
        $this->db->join('class AS c','online_exam.class_id = c.class_id','left');
        return $this->db->get()->result_array();
    }

    public function online_exam_delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->_online);
    }
    public function update_online_exam($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($this->_online, $data);
    }
    public function get_name($param)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
         return $this->db->from('exam')->like('name', trim($param))->get()->result();
    }

    //Grade
    function get_grade($grade_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->get_where('grade' , array('grade_id' => $grade_id) )->result_array();
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

    /*     * ****************************updating table************************* */

    public function update_data($dataArray, $conditionArray) {
        $this->db->where($conditionArray);
        $this->db->update($this->_table, $dataArray);
        return true;
    }

    function save_exam_routine($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $result = $this->db->get_where('exam_routine', array('exam_id' => $dataArray['exam_id'], 'class_id' => $dataArray['class_id']
                    , 'section_id' => $dataArray['section_id'], 'subject_id' => $dataArray['subject_id']))->row();
        if (!$result) { 
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                    $dataArray['school_id'] = $school_id;
                } 
            }
            $this->db->insert('exam_routine', $dataArray);
            $id = $this->db->insert_id();
            return $id;
        } else {
            $this->db->where('exam_routine_id', $result->exam_routine_id);
            $this->db->update('exam_routine', $dataArray);
        }
    }

    function get_exam_routine($condition) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $return = $this->db->get_where('exam_routine', $condition)->result_array();
        return $return;
    }

    function get_exam_name($exam_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $exam = $this->db->get_where('exam', array('exam_id' => $exam_id))->row();
        if ($exam) {
            $exam_name = $exam->name;
        } else {
            $exam_name = " ";
        }
        return $exam_name;
    }

    public function get_exam_name_for_ptm($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->select('*');
        $this->db->from('exam');
        foreach ($dataArray as $value) {
            $ids = $value['exam_id'];
            $this->db->or_where('exam_id', $ids);
        }
        $res = $this->db->get()->result_array();
        return $res;
    }

    function get_exam_name_for_ptm_teacher_api($sectionId,$classId) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('e.school_id',$school_id);
            } 
        }
        $this->db->select('e.name');
        $this->db->from('exam AS e');
        $this->db->join('parrent_teacher_meeting_date AS ptm','ptm.exam_id=e.exam_id');

        $this->db->where('ptm.class_id', $classId);
        $this->db->where('ptm.section_id', $sectionId);

        $result = $this->db->get()->result_array();
        return $result;
    }
    
    function create_exam($data){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
                $data_cce['school_id'] = $school_id;
                $save_data['school_id'] = $school_id;
                $data_icse['school_id'] = $school_id;
            } 
        }
        
        $this->db->insert($this->_table, $data);
        $last_id = $this->db->insert_id();
        /*Create CCE Exam*/
       if($data['grading']==2){
            $last_id = $this->db->insert_id();

            $data_cce['exam_id']=$last_id;
            $data_cce['exam_type']=$this->input->post('exam_category_cce');
            $data_cce['internal_subcat']=$this->input->post('exam_internal_category');
            if(empty($data_cce['internal_subcat'])){
                $data_cce['internal_subcat'] = 0;
            }

           $insert_cce = $this->db->insert('cce_exam', $data_cce);
        }
        /*Create CCE Exam*/

        /*Create IBO Exam*/
        if($data['grading']==6){
            $save_data['exam_id']=$last_id;
            $save_data['exam_category']=$this->input->post('Exam_category');
            $this->db->insert('ibo_exam', $save_data);
        }
        /*Create IBO Exam*/
       

        /*Create ICSE Exam*/
        if($data['grading']==5){
            $data_icse['exam_id']=$last_id;
            $data_icse['icse_exam_assessment']=$this->input->post('icse_exam_assessment');
            $data_icse['year'] = $this->session->userdata('running_year');
            $this->db->insert('icse_exam', $data_icse);
        }
        /*Create ICSE Exam*/
        return $this->db->insert_id();
    }
    
    function get_modal_cwa_exams_connect_data($evaluation_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('e.school_id',$school_id);
            } 
        }
        $this->db->select('e.*, cew.percent');
        $this->db->from('exam e');
        $this->db->join('cwa_exam_weightage cew','cew.exam_id=e.exam_id');
        $this->db->where(array('e.grading'=> $evaluation_id, 'e.year' => $this->session->userdata('running_year')));
        $data = $this->db->get()->result_array();
        return $data;
    }
    
    function get_modal_gpa_exams_connect_data($evaluation_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('e.school_id',$school_id);
            } 
        }
        $this->db->select('e.*, gew.percent');
        $this->db->from('exam e');
        $this->db->join('gpa_exam_weightage gew','gew.exam_id=e.exam_id');
        $this->db->where(array('e.grading'=> $evaluation_id, 'e.year' => $this->session->userdata('running_year')));
        $data = $this->db->get()->result_array();
        return $data;
    }

    function get_marks_of_students($exam_id, $class_id, $section_id, $subject_id, $running_year){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('m.school_id',$school_id);
            } 
        }
        $this->db->select('DISTINCT(e.student_id),m.*, e.enroll_code, e.roll, s.name, s.lname');
        $this->db->from('mark m');
        $this->db->join('enroll e', 'e.student_id = m.student_id', 'INNER');
        $this->db->join('student s', 's.student_id = m.student_id', 'INNER');
        $this->db->where(array('m.class_id'=> $class_id, 'm.section_id' => $section_id, 'm.year'=> $running_year, 'm.subject_id'=> $subject_id, 'm.exam_id'=> $exam_id, 's.isActive'=> '1', 's.student_status'=> '1'));
        $this->db->group_by('s.student_id');
        $data = $this->db->get()->result_array();
        return $data;
    }
    
    /*IBO Exam*/
    function ibo_exam(){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('ibo_exam.school_id',$school_id);
            } 
        }
        $year=$this->session->userdata('running_year');
        $this->db->select('*');
        $this->db->from('ibo_exam');
        $this->db->join('exam', 'ibo_exam.exam_id = exam.exam_id');
        $this->db->where('exam.year', $year);
        
        $ibo_exam = $this->db->get()->result_array();
        return $ibo_exam;
    }

    function ibo_exam_connect($data){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
            } 
        }
        $this->db->insert('ibo_exam_connect', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    function connected_ibo_exam(){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('ibo_exam.school_id',$school_id);
            } 
        }
        $year=$this->session->userdata('running_year');
        $this->db->select('ibo_exam_connect.ibo_exam_id, ibo_exam_connect.ibo_connect_id, ibo_exam_connect.ibo_connect_status, ibo_exam.exam_category, ibo_exam.exam_id, exam.name, exam.date, exam.year, exam.grading');
        $this->db->from('ibo_exam');
        $this->db->join('exam', 'ibo_exam.exam_id = exam.exam_id');
        $this->db->join('ibo_exam_connect', 'ibo_exam.ibo_exam_id = ibo_exam_connect.ibo_exam_id');
        $this->db->where('exam.year', $year);
        
        $ibo_exam = $this->db->get()->result_array();
        return $ibo_exam;
    }

    function delete_ibo_connect_exam($id){
        $this->db->where('ibo_exam_id', $id);
        $this->db->delete('ibo_exam_connect');
        return true;
    }

    function ibo_get_marks_of_students($exam_id, $class_id, $section_id, $subject_id, $running_year){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('m.school_id',$school_id);
            } 
        }
        $this->db->select('DISTINCT(e.student_id),m.*, e.enroll_code, e.roll, s.name, s.lname');
        $this->db->from('ibo_marks m');
        $this->db->join('enroll e', 'e.student_id = m.student_uid', 'INNER');
        $this->db->join('student s', 's.student_id = m.student_uid', 'INNER');
        $this->db->where(array('m.class_id'=> $class_id, 'm.section_id' => $section_id, 'm.year'=> $running_year, 'm.subject_id'=> $subject_id, 'm.exam_id'=> $exam_id, /*'s.isActive'=> '1', 's.student_status'=> '1'*/));
        $this->db->group_by('s.student_id');
        $this->db->order_by('e.roll');
        $data = $this->db->get()->result_array();
        return $data;
    }
    /*IBO Exam*/

    /*CCE Exam*/
    function cce_exam(){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('cce_exam.school_id',$school_id);
            } 
        }
        $year=$this->session->userdata('running_year');
        $this->db->select('*');
        $this->db->from('cce_exam');
        $this->db->join('exam', 'cce_exam.exam_id = exam.exam_id');
        $this->db->join('cce_exam_category', 'cce_exam.exam_type = cce_exam_category.id');
        $this->db->where('exam.year', $year);
        
        $cce_exam = $this->db->get()->result_array();
        return $cce_exam;
    }

    function cce_exam_category(){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $cce_exam_category = $this->db->get('cce_exam_category')->result_array();
        return $cce_exam_category;
    }
    
    function cce_internal_assessments(){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $internal_category = $this->db->get('cce_internal_assessments')->result_array();
        return $internal_category;
    }

    function cce_exam_connect($data){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
            } 
        }
        $this->db->insert('cce_exam_connect', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    function group_add($data){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
            } 
        }
        $this->db->insert('groups', $data);
        $id = $this->db->insert_id();
        return $id;
    }
    
    function get_groups($data = array()){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        if(!empty($data)){
            $this->db->where($data);
        }
        $res = $this->db->get("groups")->result_array();
        return $res;
    }
    
    function group_delete($data=array()){
        if(!empty($data)){
            $this->db->where($data);
        }
        $this->db->delete("groups");
        return true;
    }
    function connected_cce_exam(){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('cce_exam.school_id',$school_id);
            } 
        }
        $year=$this->session->userdata('running_year');
        $this->db->select('cce_exam_connect.cce_connect_id, cce_exam_connect.cce_exam_id, cce_exam_connect.cce_connect_status, cce_exam_connect.term, cce_exam.exam_type, cce_exam_category.cce_cat_name, cce_exam.exam_id, exam.name, exam.date, exam.year, exam.grading');
        $this->db->from('cce_exam');
        $this->db->join('exam', 'cce_exam.exam_id = exam.exam_id');
        $this->db->join('cce_exam_connect', 'cce_exam.cce_id = cce_exam_connect.cce_exam_id');
        $this->db->join('cce_exam_category', 'cce_exam_category.id = cce_exam.exam_type');
        $this->db->where('exam.year', $year);
        
        $ibo_exam = $this->db->get()->result_array();
        return $ibo_exam;
    }

    function delete_cce_connect_exam($id){
        $this->db->where('cce_connect_id', $id);
        $this->db->delete('cce_exam_connect');
        return true;
    }
    /*CCE Exam*/
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
//GET EXAM MANAGE DATATABLE LIST
       private function _get_datatables_query($exam_id,$class_id,$section_id,$subject_id,$running_year) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('m.school_id',$school_id);
            } 
        }
        $this->db->select('DISTINCT(e.student_id),m.*, e.enroll_code, e.roll, s.name, s.lname');
        $this->db->from($this->_mark.' as m');
        $this->db->join($this->_enroll.' as e', 'e.student_id = m.student_id');
        $this->db->join($this->_student.' as s', 's.student_id = m.student_id');
        $this->db->where(array('m.class_id'=> $class_id, 'm.section_id' => $section_id, 'm.year'=> $running_year, 'm.subject_id'=> $subject_id, 'm.exam_id'=> $exam_id, 's.isActive'=> '1', 's.student_status'=> '1'));
        $this->db->group_by('e.student_id');
        
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
    
    function get_datatables($exam_id,$class_id,$section_id,$subject_id,$running_year) {
        $list = $this->_get_datatables_query($exam_id,$class_id,$section_id,$subject_id,$running_year);
        if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
   
    function count_filtered($exam_id,$class_id,$section_id,$subject_id,$running_year) {
        $this->_get_datatables_query($exam_id,$class_id,$section_id,$subject_id,$running_year);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function count_all($exam_id,$class_id,$section_id,$subject_id,$running_year) 
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('m.school_id',$school_id);
            } 
        }
        $this->db->select('DISTINCT(e.student_id),m.*, e.enroll_code, e.roll, s.name');
        $this->db->from($this->_mark.' as m');
        $this->db->join($this->_enroll.' as e', 'e.student_id = m.student_id');
        $this->db->join($this->_student.' as s', 's.student_id = m.student_id');
        $this->db->where(array('m.class_id'=> $class_id, 'm.section_id' => $section_id, 'm.year'=> $running_year, 'm.subject_id'=> $subject_id, 'm.exam_id'=> $exam_id, 's.isActive'=> '1', 's.student_status'=> '1'));
        
        return $this->db->count_all_results();
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

    function get_exam_grading($exam_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $exam = $this->db->get_where('exam', array('exam_id' => $exam_id))->row();
        if ($exam) {
            $exam_grade = $exam->grading;
        } else {
            $exam_grade = " ";
        }
        return $exam_grade;
    }

    function get_datatables_ibo($exam_id,$class_id,$section_id,$subject_id,$running_year) {
        $list = $this->_get_datatables_query_ibo($exam_id,$class_id,$section_id,$subject_id,$running_year);
        if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    private function _get_datatables_query_ibo($exam_id,$class_id,$section_id,$subject_id,$running_year) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('m.school_id',$school_id);
            } 
        }
        $this->db->select('DISTINCT(e.student_id),m.*, e.enroll_code, e.roll, s.name, s.lname');
        $this->db->from($this->_ibo_marks.' as m');
        $this->db->join($this->_enroll.' as e', 'e.student_id = m.student_uid');
        $this->db->join($this->_student.' as s', 's.student_id = m.student_uid');
        $this->db->where(array('m.class_id'=> $class_id, 'm.section_id' => $section_id, 'm.year'=> $running_year, 'm.subject_id'=> $subject_id, 'm.exam_id'=> $exam_id, /*'s.isActive'=> '1', 's.student_status'=> '1'*/));
        $this->db->group_by('e.student_id');
        $this->db->order_by('e.roll');
        
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
        } else if (isset($this->order)) {
            $order = $this->order;
        }
    }

    /*CWA EXAM*/
    function cwa_exam(){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $year=$this->session->userdata('running_year');
        $this->db->select('*');
        $this->db->from('exam');
        $this->db->where('year', $year);
        $this->db->where('grading', 3);
        
        $cwa_exam = $this->db->get()->result_array();
        return $cwa_exam;
    }

    function delete_cwa_connect_exam($id){
        $this->db->where('exam_id', $id);
        $this->db->delete('cwa_exam_weightage');
        return true;
    }
    /*CWA EXAM*/

    /*GPA EXAM*/
    function gpa_exam(){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $year=$this->session->userdata('running_year');
        $this->db->select('*');
        $this->db->from('exam');
        $this->db->where('year', $year);
        $this->db->where('grading', 4);
        
        $gpa_exam = $this->db->get()->result_array();
        return $gpa_exam;
    }

    function delete_gpa_connect_exam($id){
        $this->db->where('exam_id', $id);
        $this->db->delete('gpa_exam_weightage');
        return true;
    }
    /*GPA EXAM*/
    
    function create_exam_by_bulk_upload($data){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
                $data_cce['school_id'] = $school_id;
                $save_data['school_id'] = $school_id;
            } 
        }
        //pre($data);die;
        $ccData['exam_type']=$data['exam_type'];
        unset($data['exam_type']);
        $ccData['internal_subcat']=$data['internal_subcat'];
        unset($data['internal_subcat']);
        $save_data['exam_category']=$data['exam_category'];
        unset($data['exam_category']);
        
        
        $this->db->insert($this->_table, $data);
        $last_id = $this->db->insert_id();

        /*Create CCE Exam*/
       if($data['grading']==2){
            $last_id = $this->db->insert_id();

            $data_cce['exam_id']=$last_id;
            $data_cce['exam_type']=$ccData['exam_type'];
            $data_cce['internal_subcat']=$ccData['internal_subcat'];
            if(empty($data_cce['internal_subcat'])){
                $data_cce['internal_subcat'] = 0;
            }

           $insert_cce = $this->db->insert('cce_exam', $data_cce);
        }
        /*Create CCE Exam*/

        /*Create IBO Exam*/
        if($data['grading']==6){
            $save_data['exam_id']=$last_id;
            //$save_data['exam_category']=$this->input->post('Exam_category');
            $this->db->insert('ibo_exam', $save_data);
        }
        /*CreateIBO Exam*/
        return $last_id;
    }
    
    public function get_name_bulk_upload($param){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $rs=$this->db->from('exam')->where('LOWER(name)', strtolower(trim($param)))->get()->result();
        //echo $this->db->last_query();
        return $rs;
    }

    /*ICSE EXAM*/
    function icse_exam(){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('icse_exam.school_id',$school_id);
            } 
        }
        $year=$this->session->userdata('running_year');
        $this->db->select('*');
        $this->db->from('icse_exam');
        $this->db->join('exam', 'icse_exam.exam_id = exam.exam_id');
        $this->db->where('exam.year', $year);
        
        $icse_exam = $this->db->get()->result_array();
        return $icse_exam;
    }

    function connected_icse_exam(){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('icse_exam.school_id',$school_id);
            } 
        }
        $year=$this->session->userdata('running_year');
        $this->db->select('icse_exam_connect.icse_exam_id, icse_exam_connect.icse_connect_id, icse_exam_connect.term, icse_exam_connect.icse_connect_status,icse_exam.exam_id, exam.name, exam.date, exam.year, exam.grading');
        $this->db->from('icse_exam');
        $this->db->join('exam', 'icse_exam.exam_id = exam.exam_id');
        $this->db->join('icse_exam_connect', 'icse_exam.icse_exam_id = icse_exam_connect.icse_exam_id');
        $this->db->where('exam.year', $year);
        
        $icse_exam = $this->db->get()->result_array();
        return $icse_exam;
    }

    function icse_exam_connect($data){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
            } 
        }
        $this->db->insert('icse_exam_connect', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    function delete_icse_connect_exam($id){
        $this->db->where('icse_connect_id', $id);
        $this->db->delete('icse_exam_connect');
        return true;
    }
    /*ICSE EXAM*/

    function get_exam_classes($exam_id){
        
    }
}