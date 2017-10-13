<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Class_model extends CI_Model {

    private $_table = "class";
    private $_primary = "class_id";
    private $_table_section = "section";
    public $_fms_dbname     =   '';
    public $_table_teacher = 'teacher';
    
     var $column_order = array(null, 'class.name', 'teacher.name'); //set column field database for datatable orderable
    var $column_search = array( 'class.name', 'teacher.name'); //set column field database for datatable searchable 
    var $order = array('class.name_numeric' => 'asc'); // default order 
    
    function __construct() {
        parent::__construct();
    }

    public function get_first_class_id($teacher_id = 0) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        if(!empty($teacher_id) && $teacher_id > 0) {
            //return $this->db->where('teacher_id',$teacher_id)->get('class')->first_row()->class_id;
            $rs = $this->db->get_where('class',array('teacher_id'=>$teacher_id))->result_array();
            if(count($rs)){
                return $rs[0]['class_id'];
            }else{
                return '0';
            }
        } else 
        {
            $query = $this->db->get('class')->result_array();
            if(count($query))
            return $this->db->get('class')->first_row()->class_id;
        }
    }

    public function get_name($val)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $rs =  $this->db->from($this->_table)->like('name', trim($val))->get()->result();
        return $rs;
    }

    public function get_name_by_id($class_id)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->select("name");
        $this->db->from($this->_table);
        $this->db->where('class_id', $class_id);
        $class_name = $this->db->get()->result();
        return $class_name;
        
    }

    
//    public function get_class_details_with_name(){
//       $return = array();
//        $this->db->select("class.*,teacher.name as teacher_name,subject.name as subject_name,subject.section_id as section_id");
//        $this->db->from("class");
//        $this->db->join("teacher", 'teacher.teacher_id=class.teacher_id', 'left');
//        $this->db->join("subject", 'subject.teacher_id=class.teacher_id', 'left');
//        $this->db->join("section", 'section.teacher_id=class.teacher_id', 'left');
//        $this->db->order_by("name_numeric", "asc");
//        if (!empty($dataArray)) {
//            $this->db->where($dataArray);
//        }
//        $return = $this->db->get()->result_array();
//        return $return;
//    }
    public function get_class_array($dataArray = "", $school_id = '') {
        
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
       // echo "<br>here class id is $school_id";
        $return = array();
        $this->db->select("*");
        $this->db->from("class");
        if(!empty($school_id))
             $this->db->where('school_id',$school_id);
        $this->db->order_by("name_numeric", "asc");

      /*  if (!empty($dataArray)) {
            $this->db->where($dataArray);
        }*/
        $return = $this->db->get()->result_array(); 
        //echo $this->db->last_query();
        return $return;
    }

    public function get_class_teacher_detail_array($dataArray = array()) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('class.school_id',$school_id);
            } 
        }
        $return = array();
        $this->db->select("class.*,teacher.name as teacher_name, teacher.teacher_id,teacher.email,teacher.cell_phone");
        $this->db->from("class");
        $this->db->join("teacher", 'teacher.teacher_id=class.teacher_id', 'left');
        $this->db->order_by("name_numeric", "asc");
        if (!empty($dataArray)) {
            $this->db->where($dataArray);
        }
        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_section_teacher_detail_array($dataArray = array()) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('section.school_id',$school_id);
            } 
        }
        $return = array();
        $this->db->select("section.*,teacher.name as teacher_name,teacher.middle_name,teacher.last_name");
        $this->db->from("section");
        $this->db->join("teacher", 'teacher.teacher_id=section.teacher_id', 'left');
        if (!empty($dataArray)) {
            $this->db->where($dataArray);
        }
        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_section_array($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $return = array();                
        if($dataArray['class_id']=='all'){
            $return = $this->db->get('section')->result_array();            
        }else{     
            $query = $this->db->get_where('section', $dataArray);
            $return = $query->result_array();            
        }
        return $return;
    }

    public function get_class_record($dataArray, $column = "") {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $return = "";
        $class_record = $this->db->get_where('class', $dataArray)->row();
        if (!empty($column) && !empty($class_record->$column)) {
            $return = $class_record->$column;
        } else {
            $return = $class_record;
        }
        return $return;
    }

    public function get_section_record($dataArray, $column = "") {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $return = "";
        $section_record = $this->db->get_where('section', $dataArray)->row();
        if (!empty($column) && !empty($section_record->$column)) {
            $return = $section_record->$column;
        } else {
            $return = $section_record;
        }
        return $return;
    }

    public function save_class($dataArray, $name) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
                $dataArray['school_id'] = $school_id;
            } 
        }
        $sql = $this->db->select('name')->get_where('class', array('name' => $name))->result();
        if (count($sql) > 0) {
            return FALSE;
        } else
            $this->db->insert('class', $dataArray);
        $class_id = $this->db->insert_id();
        return $class_id;
    }

    public function save_class_in_order($class_ids)
    {
        $i=1;
        foreach ($class_ids as $class_id)
        {
            $this->db->where("class_id",$class_id);
            $this->db->update("class",array('name_numeric'=>$i));
            $i++;
                    
        }
    }

    public function update_class($dataArray, $condition) {
        $this->db->where($condition);
        $this->db->update('class', $dataArray);
        return true;
    }

    public function delete_class($dataArray) {
        $this->db->where($dataArray);
        $this->db->delete('class');
        return true;
    }

    public function save_section($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('section', $dataArray);
        $section_id = $this->db->insert_id();
        return $section_id;
    }

    public function update_section($dataArray, $condition) {
        $this->db->where($condition);
        $this->db->update('section', $dataArray);
        return true;
    }

    public function delete_section($dataArray) {
        $this->db->where($dataArray);
        $this->db->delete('section');
        return true;
    }

    /* Academic Syllabus */

    public function upload_academic_syllabus($data) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
            } 
        }
        $this->db->insert('academic_syllabus', $data);
    }

    public function get_academic_syllabus_name($academic_syllabus_code) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->get_where('academic_syllabus', array('academic_syllabus_code' => $academic_syllabus_code))->row()->file_name;
    }

    public function delete_academic_syllabus($academic_syllabus_code) {
        $this->db->where('academic_syllabus_code', $academic_syllabus_code);
        $this->db->delete('academic_syllabus');
    }

    public function get_year_academic_syllabus() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
    }

    public function update_academic_syllabus($data, $academic_syllabus_code) {
        $this->db->where('academic_syllabus_code', $academic_syllabus_code);
        $this->db->update('academic_syllabus', $data);
    }

    function get_class_by_teacher($teacher_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $rs = $this->db->select('name,class_id')->from('class')->where('teacher_id', $teacher_id)->get()->result_array(); 
        return $rs;
    }
    function get_class_name_by_subject($teacher_id){
        $school_id = ''; $where = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $where = " and s.school_id = '".$school_id."'";
            } 
        }
        $sql="select distinct c.name,s.class_id from subject s join class c on(c.class_id=s.class_id) where s.teacher_id='".$teacher_id."' ".$where." ORDER by c.name_numeric";
        $rs = $this->db->query($sql)->result_array();
        return $rs;
        
    }
     
    function get_section_by_subject($class_id,$teacher_id){
        $school_id = ''; $where = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $where = " and s.school_id = '".$school_id."'";
            } 
        }
        $sql="SELECT DISTINCT(section.name),section.section_id FROM subject s join section section on(s.section_id=section.section_id) where s.teacher_id='".$teacher_id."' and s.class_id='".$class_id."' ".$where." order by section.section_id";
        $rs = $this->db->query($sql)->result_array();
        return $rs;
        
    }        
    /**
     * 
     * @param type $dataArray
     * @return type
     */
    public function get_grade_array($dataArray = "") {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $return = array();
        $this->db->select("*");
        $this->db->from("grade");
        $this->db->order_by("name", "asc");
        if (!empty($dataArray)) {
            $this->db->where($dataArray);
        }
        $return = $this->db->get()->result_array();
        return $return;
    }

    /**
     * 
     * @return type
     */
    public function get_class_id_LKG() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->get_where('class', array('name' => 'LKG'))->row()->class_id;
    }
    

    public function get_cce_classes($field='', $order='') {
        $return = array();
         $dataArray['evaluation_id']=$this->db->get_where('evaluation_method',array('name'=>'CCE'))->row()->evaluation_id;
        $this->db->select("*");
        $this->db->from('cce_classes AS A');
        $this->db->join('class AS B', 'A.class_id = B.class_id', 'INNER');
        if($order!=''){
            $this->db->order_by($field, $order);   
        }else{
            $this->db->order_by($field, "asc");
        }
        if (!empty($dataArray)) {
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
    
    public function get_cwa_classes() {
        
        $return = array();
         $dataArray['evaluation_id']=$this->db->get_where('evaluation_method',array('name'=>'CWA'))->row()->evaluation_id;
        $this->db->select("*");
        $this->db->from('cce_classes AS A');
        $this->db->join('class AS B', 'A.class_id = B.class_id', 'INNER');
        if (!empty($dataArray)) {
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
    public function get_gpa_classes() {
        
        $return = array();
         $dataArray['evaluation_id']=$this->db->get_where('evaluation_method',array('name'=>'GPA'))->row()->evaluation_id;
        $this->db->select("*");
        $this->db->from('cce_classes AS A');
        $this->db->join('class AS B', 'A.class_id = B.class_id', 'INNER');
        if (!empty($dataArray)) {
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

    public function get_ibo_classes($order='') {
        
        $return = array();
         $dataArray['evaluation_id']=$this->db->get_where('evaluation_method',array('name'=>'IBO'))->row()->evaluation_id;
        $this->db->select("*");
        $this->db->from('cce_classes AS A');
        $this->db->join('class AS B', 'A.class_id = B.class_id', 'INNER');
        if($order!=''){
            $this->db->order_by("id", $order);   
        }else{
            $this->db->order_by("id", "asc");
        }
        if (!empty($dataArray)) {
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


    /*public function get_ibo_classes_for_assign_program(){
         $dataArray['evaluation_id']=$this->db->get_where('evaluation_method',array('name'=>'IBO'))->row()->evaluation_id;
        $this->db->select("A.class_id");
        $this->db->from('cce_classes AS A');
        $this->db->join('class AS B', 'A.class_id = B.class_id', 'INNER');
        $this->db->where($dataArray);
        $result = $this->db->get()->result_array();

        $this->db->select('*');
        $this->db->from('cce_classes');
        $this->db->where_not_in('ibo_class_program.class_id', $result);
        $this->db->where('cce_classes.evaluation_id','6');
        $result_ibo = $this->db->get()->result_array();
        pre($result_ibo);
        die();
        echo $this->db->last_query(); exit;
    }*/

    public function get_ibo_programs($program_id = ''){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->select("*");
        $this->db->from('ibo_programs');
        if ($program_id!="") {
            $this->db->where('program_id', $program_id);
        }
        $ibo_program = $this->db->get()->result_array();
        return $ibo_program;
        
    }

    public function ibo_add_program($dataArray){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('ibo_programs', $dataArray);
        $program_id = $this->db->insert_id();
        return $program_id;
    }

    public function ibo_program_assign_class($dataArray){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('ibo_class_program', $dataArray);
        $assign_id = $this->db->insert_id();
        return $assign_id;
    }

    function get_assign_ibo_program(){
        
        $return = array();
        $this->db->select("*");
        $this->db->from("ibo_class_program as A");
        $this->db->join("class as B", 'A.class_id=B.class_id');
        $this->db->join("ibo_programs as C", 'A.program_id=C.program_id');
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

    public function add_cce_classes($dataArray, $class_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
                $dataArray['school_id'] = $school_id;
            } 
        }
        $dataArray['evaluation_id']=$this->db->get_where('evaluation_method',array('name'=>'CCE'))->row()->evaluation_id;
        $sql = $this->db->select('class_id')->get_where('cce_classes', array('class_id' => $class_id))->result();
        if (count($sql) > 0) {
            return FALSE;
        } else
            $this->db->insert('cce_classes', $dataArray);
        $id = $this->db->insert_id();
        return $id;
    }
    
    public function add_cwa_classes($dataArray, $class_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
                $dataArray['school_id'] = $school_id;
            } 
        }
        $dataArray['evaluation_id']=$this->db->get_where('evaluation_method',array('name'=>'CWA'))->row()->evaluation_id;
        $sql = $this->db->select('class_id')->get_where('cce_classes', array('class_id' => $class_id))->result();
        if (count($sql) > 0) {
            return FALSE;
        } else
            $this->db->insert('cce_classes', $dataArray);
        $id = $this->db->insert_id();
        return $id;
    }
    
    public function add_gpa_classes($dataArray, $class_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
                $dataArray['school_id'] = $school_id;
            } 
        }
        $dataArray['evaluation_id']=$this->db->get_where('evaluation_method',array('name'=>'GPA'))->row()->evaluation_id;
        $sql = $this->db->select('class_id')->get_where('cce_classes', array('class_id' => $class_id))->result();
        if (count($sql) > 0) {
            return FALSE;
        } else
            $this->db->insert('cce_classes', $dataArray);
        $id = $this->db->insert_id();
        return $id;
    }

    public function add_ibo_classes($dataArray, $class_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
                $dataArray['school_id'] = $school_id;
            } 
        }
        $dataArray['evaluation_id']=$this->db->get_where('evaluation_method',array('name'=>'IBO'))->row()->evaluation_id;
        $sql = $this->db->select('class_id')->get_where('cce_classes', array('class_id' => $class_id))->result();
        if (count($sql) > 0) {
            return FALSE;
        } else
            $this->db->insert('cce_classes', $dataArray);
        $id = $this->db->insert_id();
        return $id;
    }
    /**
     * 
     * @param type $section_name
     * @param type $class_name
     */
    function check_section_exist_with_class($section_name,$class_name){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('s.school_id',$school_id);
            } 
        }
        $this->db->where('c.name',$class_name);
        $this->db->where('s.name',$section_name);
        $this->db->select('s.section_id')->from($this->_table_section." AS s")->join($this->_table." AS c",'s.class_id=c.class_id');
        $rs=$this->db->get()->result(); 
        return $rs;
    }
    
    /**
     * 
     * @param type $section_name
     * @param type $class_name
     * @param type $email
     */
    function check_section_exist_with_class_and_teacher($section_name,$class_name,$email){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('s.school_id',$school_id);
            } 
        }
        $this->db->where('c.name',$class_name);
        $this->db->where('s.name',$section_name);
        $this->db->where('t.email',$email);
        $this->db->select('s.section_id')->from($this->_table_section." AS s")->join($this->_table." AS c",'s.class_id=c.class_id');
        $this->db->join('teacher AS t','s.teacher_id=t.teacher_id');
        $rs=$this->db->get()->result();
        return $rs;
    }
    
    /**
     * 
     * @param type $dataArr
     */
    function add($dataArr){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArr['school_id'] = $school_id;
            } 
        }
        $this->db->insert($this->_table,$dataArr);
        return $this->db->insert_id();
    }
    
    public function get_count_students($dataArray, $year){
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
        $this->db->join("section", 'section.section_id=enroll.section_id');
        $this->db->join("student", 'student.student_id=enroll.student_id');
        $this->db->group_by("section.section_id");
        if (!empty($dataArray)) {
            $this->db->where('enroll.year', $year);
            $this->db->where('student.isActive', '1');
            $this->db->where($dataArray);
        }
        $return = $this->db->get()->result_array();
        return $return;
    }
    
    function get_class_section_by_teacher_id($teacher_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('c.school_id',$school_id);
            } 
        }
        $return = array();
        $this->db->select("s.*,c.name as class_name, c.class_id");
        $this->db->from("class as c");
        $this->db->join("section as s", 's.teacher_id = c.teacher_id AND c.class_id = s.class_id');        
        $this->db->where(array('c.teacher_id'=>(INT)$teacher_id));      
        $return = $this->db->get()->result_array();        
        return $return;

    }
    /*
     * Get Current Instance
     */
    function get_instance_name()
    {
        $url_arr=explode('/', $_SERVER['PHP_SELF']);
        $dir=$url_arr[1];
        return $dir;
    }
    /*
     * check Group exist in finance while add a class in school
     * @param array 
     */
    public function check_group_finance( $group_id ) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $instance               =   $this->get_instance_name();
        $finance_db             =   strtolower($instance.$this->_fms_dbname);
        $this->db->select('gname');
        $this->db->from("$finance_db.crm_groups");
        $this->db->where( 'id' , $group_id );
        $result         =   $this->db->get()->row();
        if($result)
            return $result;
        else 
            return FALSE;
    }
    
    /*
     * Add Group to finance while add a class in school
     * @param array 
     */
    public function add_group_finance( $data ) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
            } 
        }
        $instance               =   $this->get_instance_name();
        $finance_db             =    CURRENT_FI_DB;//strtolower($instance.$this->_fms_dbname);
        $this->db->insert("$finance_db.crm_groups",$data);
        $lastid=$this->db->insert_id();
        return $lastid;
    }
    
    public function get_teachers_by_class($class_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('sec.school_id',$school_id);
            } 
        }
        $this->db->select('sec.teacher_id, sec.class_id, sec.name as section, cls.name as class, tea.name as teacher, tea.middle_name as tea_middle_name, tea.last_name as tea_last_name, tea.email, tea.cell_phone'); 
        $this->db->from('section as sec'); 
        $this->db->join('class as cls','cls.class_id = sec.class_id');
        $this->db->join('teacher as tea','sec.teacher_id = tea.teacher_id');
        $this->db->where('sec.class_id',$class_id);
        $this->db->where(array('tea.isActive' => '1', 'tea.teacher_status' => '1'));        
        $res = $this->db->get()->result_array();
        return $res;
    }
    
   /**
     * 
     * @param type $id
     * @return type
     */
    public function get_data_by_id($id,$returnColsStr=""){
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

    function single_name($class_id)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $query = $this->db->get_where($this->_table, array('class_id' => $class_id))->result_array();
            if(count($query))
            return $this->db->get_where($this->_table, array('class_id' => $class_id))->row()->name;
    }    
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
    
    //Get Datatable list
     private function _get_datatables_query() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where($this->_table.'.school_id',$school_id);
            } 
        }
        $this->db->select("class.*,teacher.name as teacher_name, teacher.teacher_id,teacher.email,teacher.cell_phone");
        $this->db->from($this->_table);
        $this->db->join($this->_table_teacher, 'teacher.teacher_id=class.teacher_id', 'left');
        
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
            if($_POST['order']['0']['column']!='0'){
                $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            }
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

    /*icse grading method*/
    public function get_icse_classes($order='') {
        $return = array();
         $dataArray['evaluation_id']=$this->db->get_where('evaluation_method',array('name'=>'ICSE'))->row()->evaluation_id;
        $this->db->select("*");
        $this->db->from('cce_classes AS A');
        $this->db->join('class AS B', 'A.class_id = B.class_id', 'INNER');
        if($order!=''){
            $this->db->order_by("id", $order);   
        }else{
            $this->db->order_by("id", "asc");
        }
        if (!empty($dataArray)) {
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

    public function add_icse_classes($dataArray, $class_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
                $dataArray['school_id'] = $school_id;
            } 
        }
        $dataArray['evaluation_id']=$this->db->get_where('evaluation_method',array('name'=>'ICSE'))->row()->evaluation_id;
        $sql = $this->db->select('class_id')->get_where('cce_classes', array('class_id' => $class_id))->result();
        if (count($sql) > 0) {
            return FALSE;
        } else
            $this->db->insert('cce_classes', $dataArray);
        $id = $this->db->insert_id();
        return $id;
    }
    /*icse grading method*/

    /*IGCSE grading method start*/
    public function get_igcse_classes($order='') {
        $school_id = '';
        
        $return = array();
         $dataArray['evaluation_id']=$this->db->get_where('evaluation_method',array('name'=>'IGCSE'))->row()->evaluation_id;
        $this->db->select("*");
        $this->db->from('cce_classes AS A');
        $this->db->join('class AS B', 'A.class_id = B.class_id', 'INNER');
        if($order!=''){
            $this->db->order_by("id", $order);   
        }else{
            $this->db->order_by("id", "asc");
        }
        if (!empty($dataArray)) {
            $this->db->where($dataArray);
        }
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('A.school_id',$school_id);
            } 
        }
        $return = $this->db->get()->result_array();
        return $return;
    }

    public function add_igcse_classes($dataArray, $class_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
                $dataArray['school_id'] = $school_id;
            } 
        }
        $dataArray['evaluation_id']=$this->db->get_where('evaluation_method',array('name'=>'IGCSE'))->row()->evaluation_id;
        $sql = $this->db->select('class_id')->get_where('cce_classes', array('class_id' => $class_id))->result();
        if (count($sql) > 0) {
            return FALSE;
        } else
            $this->db->insert('cce_classes', $dataArray);
        $id = $this->db->insert_id();
        return $id;
    }
    /*IGCSE grading method end*/
  
}

