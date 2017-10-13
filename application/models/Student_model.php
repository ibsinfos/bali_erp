<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Student_model extends CI_Model {

    private $_table         =   "student";
    private $_primary       =   "student_id";
    private $_table_enroll  =   "enroll";
    private $_table_class   =   "class";
    private $_table_section =   "section";
    private $_table_parent  =   "parent";
    public $_fms_dbname     =   '';
    public $_finance_db     =   CURRENT_FI_DB;
    public $_table_nationality = "nationality";

    private $_table_refund_request = "refund_request";
    private $_table_refund_rules = "refund_rules";    
    private $_table_fee_collections = "fee_collections";

    var $column_order = array(null, 'enroll.roll', 'student.name', 'parent.father_name', 'student.sex', 'student.birthday'); //set column field database for datatable orderable
    var $column_search = array('enroll.roll', 'student.name', 'parent.father_name', 'student.sex', 'student.birthday'); //set column field database for datatable searchable 

    var $column_search_all = array('enroll.roll', 'student.name', 'c.name', 's.name', 'parent.father_name', 'student.sex', 'student.birthday');
    var $column_order_all = array(null, 'enroll.roll', 'student.name', 'c.name', 's.name', 'parent.father_name', 'student.sex', 'student.birthday');

    var $order = array('enroll.roll' => 'asc'); // default order 
    var $order_all = array('c.name' => 'asc');

    var $column_order_student_information = array(null, 'enroll.enroll_code','student.sex', 'student.name','student.lname', 'parent.father_name','parent.father_lname', 'parent.mother_name','parent.mother_lname', 'student.sex', 'student.birthday','medical_events.desease_title','student.media_consent','student.emergency_contact_number'); //set column field database for datatable orderable
    var $column_search_student_information = array('student.student_id','enroll.enroll_code','student.sex', 'student.name','student.lname', 'parent.father_name','parent.father_lname', 'parent.mother_name','parent.mother_lname', 'student.sex', 'student.birthday','medical_events.desease_title','student.media_consent','student.emergency_contact_number'); //set column field database for datatable searchable 
    var $order_student_information = array('student.name' => 'asc'); // default order 
    
    var $column_order_assignment = array(null, 'enroll.enroll_code', 'student.name'); //set column field database for datatable orderable
    var $column_search_student_assignment = array( 'enroll.enroll_code', 'student.name'); //set column field database for datatable searchable 
    var $order_student_assignment = array('student.student_id' => 'asc'); // default order 
       
//private $_table_enroll="enroll";

    function __construct() {
        parent::__construct();
    }
    
    function get_scholarship_students($running_year = "",$school_id="",$class_id="",$section_id="")
        {
            //$db=$this->connect_db();

            $this->db->select("DISTINCT(sys_invoices.userid),sys_invoices.`discount_type`, sys_invoices.`discount_value` ,sys_scholarship.*,crm_accounts.*");
            $this->db->from("sys_invoices");
            $this->db->join('sys_stud_feeconfig', 'sys_stud_feeconfig.student_id = sys_invoices.userid', 'left');
            $this->db->join('crm_accounts', 'sys_stud_feeconfig.student_id=crm_accounts.id', 'left');
            $this->db->join('class', 'class.class_id=crm_accounts.gid', 'left');
            $this->db->join('section', 'section.section_id=crm_accounts.section_id', 'left');
            $this->db->join('sys_scholarship', 'sys_scholarship.id = sys_invoices.scholarship_id');
            $this->db->where("sys_invoices.scholarship_id != ", 0);
            if($running_year != ""){
               $this->db->where('sys_stud_feeconfig.academic_year = ',"$running_year");
            }
            if($school_id != ""){
                $this->db->where('class.school_id = ',"$school_id");
            }
            if($class_id != ""){
                $this->db->where('crm_accounts.gid = ',"$class_id");

            }
            if($section_id != ""){
               $this->db->where('crm_accounts.section_id = ',"$section_id");
            }
            $res = array();
            $query = $this->db->get(); 
            
            // pre($query);
            $res = $query->result();
            
            return $res;
        }

    public function getRFID($RFID)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql = "SELECT `enroll`.`student_id`, `student`.`name` ,`parent`.`cell_phone`, `parent`.`gender`,`parent`.`email`,`parent`.`parent_id`,`class_id`, `section_id`, `year`
                        FROM `student` ,`parent`,`enroll` WHERE `student`.`parent_id`=`parent`.`parent_id` AND `enroll`.`student_id`=`student`.`student_id` AND `card_id`='".$RFID."' AND school_id = '".$school_id."'";
            } 
        } else {
            $sql = "SELECT `enroll`.`student_id`, `student`.`name` ,`parent`.`cell_phone`, `parent`.`gender`,`parent`.`email`,`parent`.`parent_id`,`class_id`, `section_id`, `year`
                        FROM `student` ,`parent`,`enroll` WHERE `student`.`parent_id`=`parent`.`parent_id` AND `enroll`.`student_id`=`student`.`student_id` AND `card_id`=$RFID";
        }
            return $this->db->query($sql)->result();
    }

    public function student_attendance($class_id, $year, $timestamp)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                /*$this->db->query("SELECT * FROM `enroll` WHERE `class_id`= '" . $class_id . "' AND `year`='" . $year . "' AND `student_id` not in (SELECT `student_id` FROM `attendance` WHERE class_id='".$class_id."' AND `status`=1 OR `status`='0' AND school_id = '".$school_id."' AND `timestamp`=?)", $timestamp)->result_array();*/
               /*$query=  $this->db->query("SELECT * FROM `enroll` WHERE `class_id`= '" . $class_id . "' AND `year`='" . $year."' AND school_id = '".$school_id."'")->result_array();*/
            $this->db->select('e.student_id, e.enroll_code, e.enroll_id, a.status, a.timestamp');
            $this->db->from('enroll e');
            $this->db->join('attendance a', 'e.student_id = a.student_id');
            $this->db->where('a.class_id = ',"$class_id");
            $this->db->where('a.school_id =', "$school_id");
            /*$this->db->where('a.timestamp =', "$timestamp");*/
            $this->db->group_by('a.student_id');
            $query = $this->db->get()->result_array();

            } 
        } else {
           $query = $this->db->query("SELECT * FROM `enroll` WHERE `class_id`= " . $class_id . " AND `year`='" . $year . "' AND `student_id` not in (SELECT `student_id` FROM `attendance` WHERE class_id=$class_id AND `status`=1 OR `status`=0 AND `timestamp`=?)", $timestamp)->result_array();
        }
        /*echo 'Student_model'.'<br/>';
          echo $this->db->last_query(); die();*/
          //pre($query); 
          return $query;
    }

    

    public function get_data_not_in_attendance($class_id, $year, $timestamp){
        $query = $this->db->query("SELECT * FROM `enroll` WHERE `class_id`= " . $class_id . " AND `year`='" . $year . "' AND `student_id` not in (SELECT `student_id` FROM `attendance` WHERE class_id=$class_id AND `timestamp`=?)", $timestamp)->result_array();
        //echo $this->db->last_query();
        return $query;
    }

    public function update_applied_student($stud_id, $data)
    {
        $this->db->where('student_id', $stud_id);
        $this->db->update('applied_students', $data);
    }

    public function get_students_records($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $student_array = $this->db->get_where('student', $dataArray)->result_array();
        return $student_array;
    }

    public function get_enroll_records($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $enroll_records = $this->db->get_where('enroll', $dataArray)->result_array();
        return $enroll_records;
    }

    public function get_student_name($student_id)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
       $n = "";
       $res =  $this->db->get_where($this->_table, array('student_id' => $student_id));
       if($res->num_rows()){
            $n = $res->row()->name;
       }
       return $n; 
       
    }
    public function get_parent_id($student_id)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return   $this->db->get_where($this->_table, array('student_id' => $student_id))->row()->parent_id;
    }
    public function get_parent_phone($student_id)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return   $this->db->get_where($this->_table, array('student_id' => $student_id))->row()->phone;
    }

    public function get_student_record($dataArray, $column = "") {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $return = "";
        $student_record = $this->db->get_where('student', $dataArray)->row();
        if (!empty($column) && !empty($student_record->$column)) {
            $return = $student_record->$column;
        } else {
            $return = $student_record;
        }
        return $return;
    }

    public function get_enroll_record($dataArray, $column = "") {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $return = "";
        $enroll_record = $this->db->get_where('enroll', $dataArray)->row();
        if (!empty($column) && !empty($enroll_record->$column)) {
            $return = $enroll_record->$column;
        } else {
            $return = $enroll_record;
        }
        return $return;
    }

    public function save_student($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('student', $dataArray);
        generate_log($this->db->last_query());
        $student_id = $this->db->insert_id();
        return $student_id;
    }

    public function enroll_student($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('enroll', $dataArray);
        generate_log($this->db->last_query());
        $enroll_id = $this->db->insert_id();
        return $enroll_id;
    }

    //Add Medical Record
    function add_clinical_record($data){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
            } 
        }
        return $this->db->insert('medical_events',$data);
    }
    
    // Delete Record from Table
    public function delete_student_record($student_id) {
        $this->db->where('student_id', $student_id);
        $this->db->delete($this->_table);
        
        return true;
    }
    // Update Record in Table
    public function delete_student($dataArray) {

        $this->db->update('student', array('isActive' => '0', 'change_time' => date('Y-m-d H:i:s')), $dataArray);
        return true;
    }

    function get_attendance($data){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                //$this->db->where('school_id',$school_id);
            } 
        }
        $attendance = $this->db->get_where('attendance', $data)->result_array();
        return $attendance;
        
    }
    
    public function update_student($dataArray, $condition) {
        $this->db->where($condition);
        $this->db->update('student', $dataArray);
        return true;
    }

    public function update_enroll($dataArray, $condition) {
        $this->db->where($condition);
        $this->db->update('enroll', $dataArray);
        //echo $this->db->last_query();
        //exit;
        return true;
    }

    public function get_class_id_by_student($student_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $rs = $this->db->select('class_id')->from('enroll')->where('student_id', $student_id)->get()->result_array();
        return $rs;
    }

    public function get_section_id_by_student($student_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $rs = $this->db->select('section_id')->from('enroll')->where('student_id', $student_id)->get()->result_array();
        return $rs;
    }

    public function get_parent_id_by_student($student_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $rs = $this->db->select('parent_id')->from('student')->where('student_id', $student_id)->get()->result_array();
        return $rs;
    }
    
    public function getstudents_by_gender($data = array(), $all = ""){
             
            if($this->session->userdata('school_id') > 0){
                $this->db->where('s.school_id',$this->session->userdata('school_id'));
                $this->db->where('c.school_id',$this->session->userdata('school_id'));
            }
            $this->db->select('sch.school_id, sch.name as school_name, c.class_id, c.name class_name, sec.name section_name, count(case when sex="Male" then 1 end) as male_count, count(case when sex="Female" then 1 end) as female_count');
            $this->db->from('student s');
            $this->db->join('enroll e', 'e.student_id = s.student_id');
            $this->db->join('class c', 'c.class_id = e.class_id');
            $this->db->join('section sec', 'sec.section_id = e.section_id');
            $this->db->join('schools sch', 'sch.school_id = s.school_id');
            if($all != ""){
                $this->db->group_by('s.school_id');
                $this->db->order_by('s.school_id', 'asc');
            } else {
                $this->db->group_by('e.section_id');
                $this->db->order_by('e.class_id', 'asc');
            }
            if(!empty($data)){
                $this->db->where($data);
            }
            $result = $this->db->get()->result_array();
           //echo $this->db->last_query();
           //exit; 
            return $result;
        }
        public function get_all_students()
        {
            $data = array("isActive"=>"1", "student_status"=>"1");
            $this->db->select("student_id");
            $this->db->from('student');
            $this->db->where($data);
            $result = $this->db->get()->result_array(); 
            return $result;
        }
        public function get_students_common_report($group_by, $data=array()){
            
            $this->db->select("GROUP_CONCAT(DISTINCT s.student_id ), sch.name as school_name, c.name as class_name, sec.name as section_name, $group_by, count(DISTINCT s.student_id) as total");
             
            $this->db->from('student s');
            $this->db->join('enroll e', 'e.student_id = s.student_id');
            $this->db->join('class c', 'c.class_id = e.class_id');
            $this->db->join('section sec', 'sec.section_id = e.section_id');
            $this->db->join('schools sch', 'sch.school_id = s.school_id');
            $this->db->group_by("$group_by");
            $this->db->order_by('c.class_id', 'asc');
            if(!empty($data)){
                $this->db->where($data);
            }
            $result = $this->db->get()->result_array();
            //echo $this->db->last_query()."<br>"; exit;
            return $result;
        }
         public function get_rte_students($data=array(), $group_by = ''){
             $this->db->join('class', "class.class_id = es.class_id");
            $this->db->join('schools sch', 'sch.school_id = class.school_id');
            if($group_by != "")
                $this->db->select("sch.name as school_name, count(es.student_id) as total");
            else 
                $this->db->select("es.student_fname,es.student_lname, es.parent_fname,es.parent_lname,es.user_email,es.phone,es.govt_admission_code");
            $this->db->group_by("$group_by");
            $this->db->from("enquired_students es");
            if(!empty($data)){
              $this->db->where($data);
            }
            $result = $this->db->get()->result_array();
            //echo $this->db->last_query();exit;
            return $result;
         }
         
         public function get_students_category_report($data=array()){
           
            $this->db->select("count(DISTINCT(s.student_id)) as total, sch.name as school_name, s.caste_category");
            $this->db->join('enroll e', 'e.student_id = s.student_id');
            $this->db->join('class c', 'c.class_id = e.class_id');
            $this->db->join('section sec', 'sec.section_id = e.section_id');
            $this->db->join('schools sch', 'sch.school_id = s.school_id');
            $this->db->group_by("s.caste_category, s.school_id");
            $this->db->order_by('s.school_id', 'desc');
            if(!empty($data)){
                $this->db->where($data);
            }
            $this->db->from('student s'); 
            $result = $this->db->get()->result_array();//echo $this->db->last_query();exit;

            return $result;
         }
         public function get_students_attendance_report($data){
             $this->db->select("count(st.student_id) as student_attendance_total");
             if(!empty($data)){
                 $this->db->where($data);
             }
              
             $this->db->from('schools s');
             $this->db->join('class c', 'c.school_id = s.school_id',"left");
             $this->db->join('section sec', 'sec.class_id = c.class_id',"left");
             $this->db->join('enroll e', "e.class_id = c.class_id","left");
             $this->db->join('student st', "st.student_id = e.student_id","left");
             $this->db->join('attendance a', "a.student_id = e.student_id","left");
             $result = $this->db->get()->result_array();//echo $this->db->last_query();exit;

            return $result;
             
         }
        public function get_teacher_records($data)
        {
             $this->db->select("department_name,user_name,reason,approver_comments,leavetype_name,no_of_days,from_date,to_date");
            $this->db->from("main_leaverequest_summary");
            if(!empty($data)){
              $this->db->where($data);
            }
            $result = $this->db->get()->result_array();
            //echo $this->db->last_query();exit;
            return $result;
        }
        
        public function get_all_sections(){
            // pre($data);
        $rs = array();
        $this->db->select("s.name as school_name, c.class_id, c.name as class_name, count(DISTINCT(sec.section_id)) as section_total,count(DISTINCT(student.student_id)) as student_total, sec.name section_name");
        if(isset($data['school_id'])){
            $this->db->select('count(DISTINCT(c.class_id)) as class_total');
        }
        $this->db->from("class c" );
        $this->db->join("schools s", "s.school_id=c.school_id",'left');
        $this->db->join("section sec", "c.class_id=sec.class_id",'left');
        $this->db->join("enroll e", "e.class_id = c.class_id",'left');
        $this->db->join("student", "student.student_id = e.student_id",'left');
        if(!empty($data)){
            $this->db->where($data);
        }
        $this->db->group_by("c.class_id");
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if($query){
            $rs = $query->result_array();
        }
        return $rs;
        }
        
        public function get_student_categories(){
            $this->db->from('student');
             
            $this->db->select('DISTINCT(caste_category)');
            $rs = $this->db->get()->result_array(); 
            return $rs;
        }

        /*
         * Student details
         * @param $student_id int student id
         * @param $section_id int section id
         * @return array student details with parent,enroll,teacher details
         */

        
        

    public function get_advance_invoice($student_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $rs = $this->db->select('invoice_id')->from('invoice')->where(array('student_id' => $student_id, 'title' => "Advance"))->get()->row()->invoice_id;
        return $rs;
    }

    public function get_list_of_applied_student($condition) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $student_array = $this->db->get_where('student', $condition)->result_array();
        return $student_array;
    }

    public function get_count_enroll() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->where('class_id !=','99999');
        $num_rows = $this->db->count_all_results('enroll');
        return $num_rows;
    }

    public function get_count_amount() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $query = $this->db->query("SELECT sum(amount_paid)as count FROM (invoice) where school_id = '".$school_id."' ");
            } 
        } else {
            $query = $this->db->query('SELECT sum(amount_paid)as count FROM (invoice)');
        }
        return $query->result_array();
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

    function get_student_class_section($student_id,$year="") {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('e.school_id',$school_id);
            } 
        }
        $this->db->select('s.name AS student_name,c.class_id,c.name AS class_name,se.section_id,se.name AS section_name');
        $this->db->from($this->_table_enroll.' AS e')->join($this->_table.' AS s', 'e.student_id=s.student_id')->join($this->_table_class.' AS c', 'e.class_id=c.class_id');
        $this->db->join($this->_table_section.' AS se', 'e.section_id=se.section_id')->where('e.student_id', $student_id);
        if($year!=""){
            $this->db->where('e.year',$year);
        }
        $rs = $this->db->get()->row_array();
        return $rs;
    }

    function get_student_details_for_ptm($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('e.school_id',$school_id);
            } 
        }
        $this->db->select('s.*,e.*,sec.*')->from($this->_table_enroll . ' AS e')->join($this->_table . ' AS s', 'e.student_id = s.student_id AND e.section_id=' . $dataArray['section_id'] . ' AND e.class_id = ' . $dataArray['class_id']);
        
        $this->db->group_by('s.student_id');
        $rs = $this->db->get()->result_array();

        return $rs;
    }

    function get_parrent_detais($student_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('s.school_id',$school_id);
            } 
        }
        $this->db->select('p.*')->from($this->_table . " AS s")->join($this->_table_parent . " AS p", "s.parent_id=p.parent_id");
        $rs = $this->db->where("s.student_id", $student_id)->get()->result_array();
        return $rs;
    }

    /*
     * Get all students
     * @param class id
     * @param running year
     * @return result array of students details currespond to class id
     */

    function getallstudents($class_id, $running_year) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('student.school_id',$school_id);
            } 
        }
        if ($class_id == 'all') {
            $this->db->select('*, student.name stdent_fname'); // Select field
            $this->db->from('student'); // from Table1
            $this->db->join('enroll', 'student.student_id = enroll.student_id');
            $this->db->join('parent', 'parent.parent_id = student.parent_id');
            $this->db->join('section', 'section.section_id = enroll.section_id');
            $this->db->where('enroll.year', $running_year); /// Join table1 with table2 based on the foreign key
            $this->db->where('student.isActive', '1'); // Set Filter
            $res = $this->db->get()->result_array();
            return $res;
        } else {
            $this->db->select('*, student.name stdent_fname'); // Select field
            $this->db->from('student'); // from Table1
            $this->db->join('enroll', 'student.student_id = enroll.student_id');
            $this->db->join('parent', 'parent.parent_id = student.parent_id');
            $this->db->where('enroll.class_id', $class_id);
            $this->db->where('enroll.year', $running_year); /// Join table1 with table2 based on the foreign key
            $this->db->where('student.isActive', '1'); // Set Filter
            $res = $this->db->get()->result_array();
            return $res;
        }
    }

    function getall_active_students($class_id, $running_year) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('student.school_id',$school_id);
            } 
        }
        if ($class_id == 'all') {
            $this->db->select('*, student.name stdent_fname'); // Select field
            $this->db->from('student'); // from Table1
            $this->db->join('enroll', 'student.student_id = enroll.student_id');
            $this->db->join('parent', 'parent.parent_id = student.parent_id');
            $this->db->join('section', 'section.section_id = enroll.section_id');
            $this->db->where('enroll.year', $running_year); /// Join table1 with table2 based on the foreign key
            $this->db->where('student.isActive', '1'); // Set Filter
            $this->db->where('student.student_status', '1');

            $res = $this->db->get()->result_array();
            return $res;
        } else {
            $this->db->select('*, student.name stdent_fname'); // Select field
            $this->db->from('student'); // from Table1
            $this->db->join('enroll', 'student.student_id = enroll.student_id');
            $this->db->join('parent', 'parent.parent_id = student.parent_id');
            $this->db->where('enroll.class_id', $class_id);
            $this->db->where('enroll.year', $running_year); /// Join table1 with table2 based on the foreign key
            $this->db->where('student.isActive', '1'); // Set Filter
            $this->db->where('student.student_status', '1');
            $res = $this->db->get()->result_array();
            return $res;
        }
    }

    function getstudents_section($class_id, $running_year, $section_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('student.school_id',$school_id);
            } 
        }
        if ($class_id == 'all') {
            $this->db->select('*, student.name stdent_fname');
            $this->db->from('student');
            $this->db->join('enroll', 'student.student_id = enroll.student_id');
            $this->db->join('parent', 'parent.parent_id = student.parent_id');
            $this->db->join('section', 'section.section_id = enroll.section_id');
            $this->db->where('enroll.section_id', $section_id);
            $this->db->where('enroll.year', $running_year);
            $this->db->where('student.isActive', '1');
            $res = $this->db->get()->result_array();
            return $res;
        } else {
            $this->db->select('*, student.name stdent_fname');
            $this->db->from('student');
            $this->db->join('enroll', 'student.student_id = enroll.student_id');
            $this->db->join('parent', 'parent.parent_id = student.parent_id');
            $this->db->where('enroll.class_id', $class_id);
            $this->db->where('enroll.section_id', $section_id);
            $this->db->where('enroll.year', $running_year);
            $this->db->where('student.isActive', '1');
            $res = $this->db->get()->result_array();
            return $res;
        }
    }

    function getstudents_section_for_report($class_id, $running_year, $section_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('student.school_id',$school_id);
            } 
        }
        if ($class_id == 'all') {
            $this->db->select('*, student.name stdent_fname');
            $this->db->from('student');
            $this->db->join('enroll', 'student.student_id = enroll.student_id');
            $this->db->join('parent', 'parent.parent_id = student.parent_id');
            $this->db->join('section', 'section.section_id = enroll.section_id');
            $this->db->where('enroll.section_id', $section_id);
            $this->db->where('enroll.year', $running_year);
            $this->db->where('student.isActive', '1');
            $this->db->where('student.student_status', '1');
            $this->db->limit(200, 0);
            $res = $this->db->get()->result_array();
            return $res;
        } else {
            $this->db->select('*, student.name stdent_fname');
            $this->db->from('student');
            $this->db->join('enroll', 'student.student_id = enroll.student_id');
            $this->db->join('parent', 'parent.parent_id = student.parent_id');
            $this->db->where('enroll.class_id', $class_id);
            $this->db->where('enroll.section_id', $section_id);
            $this->db->where('enroll.year', $running_year);
            $this->db->where('student.isActive', '1');
            $this->db->where('student.student_status', '1');
            $this->db->limit(200, 0);
            $res = $this->db->get()->result_array();
            return $res;
        }
    }

    

    

    /*
     * Student details
     * @param $student_id int student id
     * @param $section_id int section id
     * @return array student details with parent,enroll,teacher details
     */

    public function get_student_details($student_id = '', $section_id = '') {
        $running_year = $this->get_setting_record(array('type' => 'running_year'), 'description');
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('std.school_id',$school_id);
            } 
        }
        $this->db->select("std.* , par.email as par_email , par.father_name, par.father_mname, par.father_profession, par.father_qualification, 
                           par.father_passport_number, par.mother_name, par.mother_mname, par.mother_lname, par.mother_profession, par.mother_quaification, 
                           par.mother_passport_number, par.father_icard_no, par.father_icard_type, par.mother_icard_no, par.mother_icard_type, 
                           par.father_school, par.father_department, par.father_income, par.father_designation, par.mother_school, par.mother_department, 
                           par.mother_income, par.mother_designation, par.home_phone, par.work_phone, par.mother_email, par.mother_mobile, par.zip_code, 
                           par.cell_phone, par.father_lname, par.state, std.password as student_pass , sec.name as section_name , sec.section_id ,
                        cls.name as class_name , cls.class_id , sec.teacher_id , enr.enroll_id , enr.enroll_code , enr.roll, enr.year as academic_year, g.guardian_fname,g.guardian_lname,g.guardian_relation");
        $this->db->from("student AS std");
        $this->db->join('enroll AS enr', 'std.student_id = enr.student_id');
        $this->db->join('guardian AS g', 'g.student_id = enr.student_id','left');
        $this->db->join('parent AS par', 'std.parent_id = par.parent_id');
        $this->db->join('class AS cls', 'enr.class_id = cls.class_id');
        $this->db->join('section AS sec', 'enr.section_id = sec.section_id', 'left');
        $this->db->where('enr.year', $running_year);

        if ($student_id)
            $this->db->where('std.student_id', (int) $student_id);
        if ($section_id) {
            $this->db->where('enr.section_id', (int) $section_id);
            $this->db->group_by('std.student_id');
            $result = $this->db->get()->result_array();
        } else {
            $result = $this->db->get()->row();
        }
//        echo $this->db->last_query(); die;
        //echo '<pre>';print_r($result);exit;
        return $result;
    }

    public function get_setting_record($dataArray, $column = "") {
        $return = "";
        $setting_record = $this->db->get_where('settings', $dataArray)->row();
        if (!empty($column) && !empty($setting_record->$column)) {
            $return = $setting_record->$column;
        } else {
            $return = $setting_record;
        }
        return $return;
    }

    function get_student_by_parent($parent_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('std.school_id',$school_id);
            } 
        }
        $this->db->select("std.* , sec.name as section_name , sec.section_id , cls.name as class_name , cls.class_id , sec.teacher_id , tea.name as teacher_name , tea.last_name as teacher_lastname , enr.enroll_id , enr.enroll_code , enr.year as academic_year");
        $this->db->from("student AS std");
        $this->db->join('enroll AS enr', 'std.student_id = enr.student_id');
        $this->db->join('parent AS par', 'std.parent_id = par.parent_id');
        $this->db->join('class AS cls', 'enr.class_id = cls.class_id');
        $this->db->join('section AS sec', 'enr.section_id = sec.section_id');
        $this->db->join('teacher AS tea', 'sec.teacher_id = tea.teacher_id', 'LEFT');

        if ($parent_id)
            $this->db->where('std.parent_id', (int) $parent_id);

        $result = $this->db->get()->result_array();

        return $result;
    }

    /*
     * Get Current Instance
     */

    function get_instance_name() {
        $url_arr = explode('/', $_SERVER['PHP_SELF']);
        $dir = $url_arr[1];
        return $dir;
    }

    /*
     * check account exist student at finance module
     * 
     */

    public function check_finance_customer_account($student_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $instance       =   $this->get_instance_name();
        $finance_db     =   strtolower($this->_finance_db);
        $this->db->select('account');
        $this->db->from("$finance_db.crm_accounts");
        $this->db->where('id', $student_id);
        $result = $this->db->get()->row();
        if ($result)
            return $result;
        else
            return FALSE;
    }

    /*
     * create account for student at finance module
     * 
     */

    public function create_finance_customer_account($data) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $instance = $this->get_instance_name();
        $finance_db = strtolower($this->_finance_db);
        $this->db->insert("$finance_db.crm_accounts", $data);
        $lastid = $this->db->insert_id();
        return $lastid;
    }

    /*
     * Update student details in finance module
     * 
     */

    public function update_finance_customer_account($data, $condition) {
        $instance = $this->get_instance_name();
        $finance_db = strtolower($this->_finance_db);
        $this->db->where($condition);
        $this->db->update("$finance_db.crm_accounts", $data);
        return true;
    }

    function student_list_with_advance_filter($whereCondition) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $whereCondition .= "AND s.school_id = '".$school_id."'";
            } 
        }
        $sql = "SELECT s.*,p.father_name,p.mother_name,e.enroll_code, e.roll FROM `student` AS s JOIN `enroll` AS e ON(e.student_id=s.student_id) JOIN `parent` AS p ON(s.parent_id=p.parent_id) " . $whereCondition . " GROUP BY p.parent_id";
        $dataArr = $this->db->query($sql)->result_array();
        return $dataArr;
    }

    public function get_count_curent_year($runningyear) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->select('COUNT(*) as cnt');
        $this->db->from('enroll');
        $this->db->where(array('year' => $runningyear));
        $return = $this->db->get()->row();
        return $return;
    }

    function getstudents_assignments($class_id, $section_id, $running_year) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('student.school_id',$school_id);
            } 
        }
        $this->db->select('*');
        $this->db->from('student');
        $this->db->join('enroll', 'student.student_id = enroll.student_id');
        $this->db->where('enroll.class_id', $class_id);
        $this->db->where('enroll.section_id', $section_id);
        $this->db->where('enroll.year', $running_year);
        $this->db->where('student.isActive', '1');
        $this->db->where('student.student_status', '1');
        $res = $this->db->get()->result_array();
        return $res;
    }

    public function get_student_information($student_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql = "SELECT s.*,s.address as student_address,s.email as student_email,p.* FROM student s JOIN parent p on(s.parent_id=p.parent_id) WHERE s.student_id='".$student_id."'";
            } 
        } else {
            $sql = "SELECT s.*,s.address as student_address,s.email as student_email,p.* FROM student s JOIN parent p on(s.parent_id=p.parent_id) WHERE s.student_id=$student_id";
        }
        
        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }

    public function exam_question($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        } 
        $this->db->insert('enroll', $dataArray);
        $enroll_id = $this->db->insert_id();
        return $enroll_id;
    }

    public function get_student_id_by_parent($parent_id) {
        $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                    $this->db->where('school_id',$school_id);
                } 
            }
        $rs = $this->db->select('student_id')->from('student')->where('parent_id', $parent_id)->get()->result_array();
        return $rs;
    }

    public function get_all_fields() {
        $AllFields = $this->db->list_fields('student');
        return $AllFields;
    }

    public function get_custom_report_data($filter) {
        $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                    $this->db->where('school_id',$school_id);
                } 
            }
        $fields = array_values($filter);
        $rs = $this->db->select($fields)->from('student')->get()->result_array();
        return $rs;
    }

    public function add_student_fee_det($data) {
        $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                    $data['school_id'] = $school_id;
                } 
            }
        $instance = $this->get_instance_name();
        $finance_db = strtolower($this->_finance_db);
        $this->db->insert("$finance_db.sys_stud_feeconfig", $data);
        $stud_fee_config_id = $this->db->insert_id();
        return $stud_fee_config_id;
    }

    function get_all_student_for_roll_no_set($running_year) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql = "SELECT s.name,s.student_id,s.isActive,s.name,c.name AS class_name,se.name AS section_name,se.section_id,e.roll FROM `student` AS s JOIN `enroll` AS e ON(s.student_id=e.student_id) JOIN `class` AS c ON(e.class_id=c.class_id) JOIN `section` AS se ON(e.section_id=se.section_id) WHERE e.year='" . $running_year . "' AND s.school_id = '".$school_id."' AND s.isActive='1' ORDER BY e.class_id DESC,e.section_id DESC,s.name";
            } 
        } else {
                $sql = "SELECT s.name,s.student_id,s.isActive,s.name,c.name AS class_name,se.name AS section_name,se.section_id,e.roll FROM `student` AS s JOIN `enroll` AS e ON(s.student_id=e.student_id) JOIN `class` AS c ON(e.class_id=c.class_id) JOIN `section` AS se ON(e.section_id=se.section_id) WHERE e.year='" . $running_year . "' AND s.isActive='1' ORDER BY e.class_id DESC,e.section_id DESC,s.name";
        }
        $rsStudent = $this->db->query($sql)->result();
        return $rsStudent;
    }

    function get_batch_details($class_id = "", $student_running_year = "") {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql = "SELECT e.roll,e.enroll_code,s.name,s.student_id FROM enroll e join student s on(e.student_id=s.student_id) where class_id='".$class_id."' and year='".$student_running_year."' and e.school_id = '".$school_id."'";
            } 
        } else {
            $sql = "SELECT e.roll,e.enroll_code,s.name,s.student_id FROM enroll e join student s on(e.student_id=s.student_id) where class_id=$class_id and year='$student_running_year'";
        }
        $rsStudent = $this->db->query($sql)->result_array();
        return $rsStudent;
    }

    public function do_toggle_enable_student($dataArray) {
        if ($dataArray['status'] == 1) {
            $UpdateData = array('student_status' => '0', 'change_time' => date('Y-m-d H:i:s'));
        } else {
            $UpdateData = array('student_status' => '1', 'change_time' => date('Y-m-d H:i:s'));
        }
        $this->db->where('student_id', $dataArray['student_id']);
        $this->db->update('student', $UpdateData);
        return true;
    }

    function get_students_attendance($class_id, $section_id, $running_year) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('en.school_id',$school_id);
            } 
        }
        $this->db->select('en.roll, stu.student_id, stu.name, stu.lname as lname');
        $this->db->from('enroll as en');
        $this->db->join('student as stu', 'en.student_id  =   stu.student_id');
        $rs = $this->db->where('en.class_id', $class_id)->where('en.section_id', $section_id)->where('en.year', $running_year)->where('stu.isActive', '1')->where('stu.student_status', '1')->get()->result_array();

        return $rs;
    }

    function parent_login_child_dashboard($parent_id, $running_year) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql = "SELECT stud.student_id,stud.name,stud.phone,stud.email,enroll.enroll_code,enroll.class_id,enroll.section_id,class.name as class_name,section.name as section_name from student as stud join enroll as enroll on(stud.student_id=enroll.student_id) join class as class on(enroll.class_id=class.class_id) join section as section on(enroll.section_id=section.section_id) where stud.parent_id='".$parent_id."' and enroll.year='".$running_year."' and stud.school_id = '".$school_id."'";
            } 
        } else {
            $sql = "SELECT stud.student_id,stud.name,stud.phone,stud.email,enroll.enroll_code,enroll.class_id,enroll.section_id,class.name as class_name,section.name as section_name from student as stud join enroll as enroll on(stud.student_id=enroll.student_id) join class as class on(enroll.class_id=class.class_id) join section as section on(enroll.section_id=section.section_id) where stud.parent_id='$parent_id' and enroll.year='$running_year'";
        }
        $rsStudent = $this->db->query($sql)->result_array();
        return $rsStudent;
    }

   /* function get_parent_id($student_id) {
        $query = $this->db->query('SELECT parent_id from student where student_id =' . $student_id);
        return $query->result_array();

        return $rs;
    }*/

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
            return $this->db->get_where($this->_table, array($this->_primary=> $id))->result();
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
    

    function getParentOfStudent($student_id){
        $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                    $this->db->where('s.school_id',$school_id);
                } 
            }
       return $this->db->select('s.name,p.parent_id,p.device_token,p.cell_phone,p.father_name,p.father_lname,p.email as parent_email,s.student_id')->from('student AS s')->join('parent AS p', 's.parent_id=p.parent_id')->where('s.student_id', $student_id)->get()->result_array();
    }
        // GET DATATABLE OF Student
    private function _get_datatables_query($class_id = '', $running_year = '', $section_id = '') {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('student.school_id',$school_id);
            } 
        }
        if(($class_id == 'all') && ($section_id == '') && ($running_year != '')){
            
            $this->db->select('*, student.name stdent_fname, c.name class_name, s.name section_name');
            $this->db->from('student as student');
            $this->db->join('enroll as enroll', 'student.student_id = enroll.student_id');
            $this->db->join('parent as parent', 'parent.parent_id = student.parent_id');

            $this->db->join('class as c', 'c.class_id = enroll.class_id');
            $this->db->join('section as s', 's.section_id = enroll.section_id');
            
            $this->db->where('enroll.year', $running_year);
            $this->db->where('student.isActive', '1');
            //$this->db->where('student.student_status', '1');
        }else if(($class_id != 'all') && ($section_id == '') && ($running_year != '')){
            $this->db->select('*, student.name stdent_fname');
            $this->db->from('student');
            $this->db->join('enroll', 'student.student_id = enroll.student_id');
            $this->db->join('parent', 'parent.parent_id = student.parent_id');
            $this->db->where('enroll.class_id', $class_id);
            $this->db->where('enroll.year', $running_year);
            $this->db->where('student.isActive', '1');
            //$this->db->where('student.student_status', '1');
        }else {
            $this->db->select('*, student.name stdent_fname');
            $this->db->from('student');
            $this->db->join('enroll', 'student.student_id = enroll.student_id');
            $this->db->join('parent', 'parent.parent_id = student.parent_id');
            $this->db->where('enroll.class_id', $class_id);
            $this->db->where('enroll.section_id', $section_id);
            $this->db->where('enroll.year', $running_year);
            $this->db->where('student.isActive', '1');
            //$this->db->where('student.student_status', '1');
        }
        $i = 0;

        if(($class_id == 'all') && ($section_id == '') && ($running_year != '')){
            foreach ($this->column_search_all as $item) { // loop column 
                if ($_POST['search']['value']) { // if datatable send POST for search

                    if ($i === 0) { // first loop
                        $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                        $this->db->like($item, $_POST['search']['value']);
                    } else {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }

                    if (count($this->column_search_all) - 1 == $i) //last loop
                        $this->db->group_end(); //close bracket
                }
                $i++;
            }
        }else{
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
        }

        if (isset($_POST['order'])) { 
        // here order processing
            if(($class_id == 'all') && ($section_id == '') && ($running_year != '')){
                $this->db->order_by($this->column_order_all[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);    
            }else{
                $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            }
        } else if (isset($this->order)) {
            if(($class_id == 'all') && ($section_id == '') && ($running_year != '')){
                $order = $this->order_all;
                $this->db->order_by(key($order), $order[key($order)]);
            }else{
                $order = $this->order;
                $this->db->order_by(key($order), $order[key($order)]);
            }
        }
    }

    private function _get_datatables_query_all($class_id,$running_year) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('student.school_id',$school_id);
            } 
        }
       if ($class_id == 'all') {
            $this->db->select('*, student.name stdent_fname');
            $this->db->from('student as student');
            $this->db->join('enroll as enroll', 'student.student_id = enroll.student_id');
            $this->db->join('parent as parent', 'parent.parent_id = student.parent_id');
            $this->db->join('section as section', 'section.section_id = enroll.section_id');
            $this->db->where('enroll.year', $running_year);
            $this->db->where('student.isActive', '1');
            $this->db->where('student.student_status', '1');
            $this->db->limit(200, 0);

        } else {
            $this->db->select('*, student.name stdent_fname');
            $this->db->from('student');
            $this->db->join('enroll', 'student.student_id = enroll.student_id');
            $this->db->join('parent', 'parent.parent_id = student.parent_id');
            $this->db->where('enroll.class_id', $class_id);
            $this->db->where('enroll.year', $running_year);
            $this->db->where('student.isActive', '1');
            $this->db->where('student.student_status', '1');
            $this->db->limit(200, 0);

        }
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
    

    function get_datatables($class_id = '', $running_year = '', $section_id = '') {
        if($section_id!= ''){
            $this->_get_datatables_query($class_id, $running_year, $section_id);
        }else{
            $this->_get_datatables_query($class_id, $running_year);
        }
        if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    

   function count_filtered($class_id,$running_year,$section_id){
        $this->_get_datatables_query($class_id, $running_year, $section_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_filtered_all($class_id,$running_year){
        $this->_get_datatables_query($class_id, $running_year);
        $query = $this->db->get();
        return $query->num_rows();
    }
  public function count_all($class_id,$running_year) {
      $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('student.school_id',$school_id);
            } 
        }
      if ($class_id == 'all') {
        $this->db->from('student as student');
        $this->db->join('enroll as enroll', 'student.student_id = enroll.student_id');
        $this->db->where('enroll.year', $running_year);
        $this->db->where('student.isActive', '1');
        $this->db->where('student.student_status', '1');
        return $this->db->count_all_results();
      }
        $this->db->from('student as student');
        $this->db->join('enroll as enroll', 'student.student_id = enroll.student_id');
        $this->db->where('enroll.class_id', $class_id);
        $this->db->where('enroll.year', $running_year);
        $this->db->where('student.isActive', '1');
        $this->db->where('student.student_status', '1');
        return $this->db->count_all_results();
    }

    //STUDENT DATATABLE LIST IN TEACHER LOGIN
     private function _get_datatables_query_of_student($running_year) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('student.school_id',$school_id);
            } 
        }
       $this->db->select('*, student.name');
            $this->db->from('student');
            $this->db->join('enroll', 'student.student_id = enroll.student_id');
            $this->db->join('parent', 'parent.parent_id = student.parent_id');
            $this->db->where('enroll.year', $running_year);
            $this->db->where('student.isActive', '1');
            $this->db->where('student.student_status', '1');
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
    
    function get_datatables_teacher_login_students() {
        $student_running_year = $this->globalSettingsRunningYear;
        $this->_get_datatables_query_of_student($student_running_year);
        if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
     function count_filtered_teacher_login() {
        $student_running_year = $this->globalSettingsRunningYear;
        $this->_get_datatables_query_of_student($student_running_year);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function count_all_teacher_login() {
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
    
    private function _get_datatables_query_student_information_all_class($class_id,$running_year) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('student.school_id',$school_id);
            } 
        }
        $this->db->select('enroll.*,student.*, student.name stdent_fname,parent.*,medical_events.desease_title'); // Select field
        $this->db->from('student'); // from Table1
        $this->db->join('enroll', 'student.student_id = enroll.student_id');
        $this->db->join('parent', 'parent.parent_id = student.parent_id');
        $this->db->join('medical_events', 'medical_events.user_id = student.student_id','left');
        $this->db->where('enroll.class_id', $class_id);
        $this->db->where('enroll.year', $running_year); /// Join table1 with table2 based on the foreign key
        $this->db->where('student.isActive', '1'); // Set Filter
        $this->db->group_by('student.student_id');
        //$this->db->where('student.student_status', '1');

        $i = 0;
        foreach ($this->column_search_student_information as $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search

                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_order_student_information) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order_student_information[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order_student_information)) {
            $order = $this->order_student_information;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_datatables_student_information_all_class($class_id,$running_year) {
        $list = $this->_get_datatables_query_student_information_all_class($class_id,$running_year);
        if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
//        echo $this->db->last_query(); die;
        return $query->result();
    }
    
    function count_filtered_student_information_all_class($class_id,$running_year){
        $this->_get_datatables_query_student_information_all_class($class_id,$running_year);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_parent_student_information_all_class($class_id,$running_year) {
        $this->_get_datatables_query_student_information_all_class($class_id,$running_year);
        return $this->db->count_all_results();
    }
    private function _get_datatables_query_student_information_section($class_id,$section_id,$running_year) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('student.school_id',$school_id);
            } 
        }
        
        $this->db->select('enroll.*,student.*, student.name stdent_fname,parent.*,medical_events.desease_title'); // Select field
        $this->db->from('student');
        $this->db->join('enroll', 'student.student_id = enroll.student_id');
        $this->db->join('parent', 'parent.parent_id = student.parent_id');
        $this->db->join('medical_events', 'medical_events.user_id = student.student_id','left');
        $this->db->where('enroll.class_id', $class_id);
        $this->db->where('enroll.section_id', $section_id);
        $this->db->where('enroll.year', $running_year);
        $this->db->where('student.isActive', '1');
        $this->db->group_by('student.student_id');
        //$this->db->where('student.student_status', '1');

            $i = 0;
        foreach ($this->column_search_student_information as $item) { // loop column 
            if (@$_POST['search']['value']) { // if datatable send POST for search

                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_order_student_information) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order_student_information[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order_student_information)) {
            $order = $this->order_student_information;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_datatables_student_information_section($class_id,$section_id,$running_year) {
        $list = $this->_get_datatables_query_student_information_section($class_id,$section_id,$running_year);
        if (@$_POST['length'] != -1)
        $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
//        echo $this->db->last_query(); die;
        return $query->result();
    }
    

    function count_filtered_student_information_section($class_id,$section_id,$running_year){
        $this->_get_datatables_query_student_information_section($class_id,$section_id,$running_year);
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('student.school_id',$school_id);
            } 
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_parent_student_information_section($class_id,$section_id,$running_year) {
        $this->_get_datatables_query_student_information_section($class_id,$section_id,$running_year);
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('student.school_id',$school_id);
            } 
        }
        return $this->db->count_all_results();
    }

    //Data Table for Student Assignment
     private function _get_datatables_query_student_assignment($class_id,$section_id,$running_year) {
         $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('student.school_id',$school_id);
            } 
        }
        $this->db->select('*');
        $this->db->from('student');
        $this->db->join('enroll', 'student.student_id = enroll.student_id');
        $this->db->where('enroll.class_id', $class_id);
        $this->db->where('enroll.section_id', $section_id);
        $this->db->where('enroll.year', $running_year);
        $this->db->where('student.isActive', '1');
        $this->db->where('student.student_status', '1');
        $i = 0;
       
        $i = 0;
        foreach ($this->column_search_student_assignment as $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search_student_assignment) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order_assignment[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_datatables_student_Assignment($class_id,$section_id,$running_year) {
        $list = $this->_get_datatables_query_student_assignment($class_id,$section_id,$running_year);
        if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    
    function count_filtered_student_assignment($class_id,$section_id,$running_year){
        $this->_get_datatables_query_student_assignment($class_id,$section_id,$running_year);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_student_assignment($class_id,$section_id,$running_year){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('student.school_id',$school_id);
            } 
        }
        $this->db->select('*');
        $this->db->from('student');
        $this->db->join('enroll', 'student.student_id = enroll.student_id');
        $this->db->where('enroll.class_id', $class_id);
        $this->db->where('enroll.section_id', $section_id);
        $this->db->where('enroll.year', $running_year);
        $this->db->where('student.isActive', '1');
        $this->db->where('student.student_status', '1');
        return $this->db->count_all_results();
    }

    function get_data_by_cols_table($table,$columnName = "*", $conditionArr = array(), $return_type = "result", $sortByArr = array(), $limit = "") {
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
            $rs = $this->db->get($table)->result();
        } else {
            $rs = $this->db->get($table)->result_array();
        }

        return $rs;
    }


    function get_student_image($id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->get_where('student', array('student_id' => $id))->row()->stud_image;
    }
    
    function getallstudentsbyclass($class_id, $running_year) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('student.school_id',$school_id);
            } 
        }
        if ($class_id == 'all') {
            $this->db->select('*, student.name stdent_fname'); // Select field
            $this->db->from('student'); // from Table1
            $this->db->join('enroll', 'student.student_id = enroll.student_id');
            $this->db->join('parent', 'parent.parent_id = student.parent_id');
            $this->db->join('section', 'section.section_id = enroll.section_id');
            $this->db->where('enroll.year', $running_year); /// Join table1 with table2 based on the foreign key
            $this->db->where('student.isActive', '1'); // Set Filter
            $res = $this->db->get()->result_array();
            return $res;
        } else {
            $this->db->select('*, student.name stdent_fname'); // Select field
            $this->db->from('student'); // from Table1
            $this->db->join('enroll', 'student.student_id = enroll.student_id');
            $this->db->join('parent', 'parent.parent_id = student.parent_id');
            $this->db->where('enroll.class_id', $class_id);
            $this->db->where('enroll.year', $running_year); /// Join table1 with table2 based on the foreign key
            $this->db->where('student.isActive', '1'); // Set Filter
            $res = $this->db->get()->result_array();
            return $res;
        }
    }

    public function get_student4_fi($SearchText) {
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $where['e.school_id'] = $school_id;
                $where2['e.school_id'] = $school_id;
            } 
        }

        $running_year = $this->get_setting_record(array('type' => 'running_year'), 'description');

        $where['e.enroll_code'] = $SearchText;
        $where['e.year'] = $running_year;
        $where['stu.isActive'] = '1';
        $where['stu.student_status'] = '1';

        $this->db->select('stu.name stu_fname, stu.mname stu_mname, stu.lname stu_lname, stu.birthday, stu.sex, stu.phone, stu.email, stu.caste_category, e.enroll_id, e.enroll_code, e.roll, e.date_added, c.name class_name, s.name section_name');
        $this->db->from('student as stu');
        $this->db->join('enroll as e', 'e.student_id = stu.student_id');
        $this->db->join('class as c', 'c.class_id = e.class_id');
        $this->db->join('section as s', 's.section_id = e.section_id');
        $this->db->where($where);
        $data = $this->db->get()->result_array();

        if(count($data)){
           // return $data;
        }else{
            $where2['e.year'] = $running_year;
            $where2['stu.isActive'] = '1';
            $where2['stu.student_status'] = '1';

            $this->db->select('stu.name stu_fname, stu.mname stu_mname, stu.lname stu_lname, stu.birthday, stu.sex, stu.phone, stu.email, stu.caste_category, e.enroll_id, e.enroll_code, e.roll, e.date_added, c.name class_name, s.name section_name');
            $this->db->from('student as stu');
            $this->db->join('enroll as e', 'e.student_id = stu.student_id');
            $this->db->join('class as c', 'c.class_id = e.class_id');
            $this->db->join('section as s', 's.section_id = e.section_id');
            $this->db->where($where2);

            $this->db->like('stu.name', $SearchText);

            $data = $this->db->get()->result_array();
            //return $data;
        }

        if(count($data)){
            foreach($data as $k => $datum){
                $data[$k]['request_data'] = array();
                $this->db->select('req.refund_amount, req.request_comment, req.replied_comment, req.running_year, req.request_status, req.request_date, req.approve_date, req.reject_date, fc.name collection_name, rr.name refund_rule_name');
                $this->db->from($this->_table_refund_request.' req');
                $this->db->join($this->_table_fee_collections.' fc', 'fc.id = req.collection_id');
                $this->db->join($this->_table_refund_rules.' rr', 'rr.id = req.refund_rule_id');       
                $this->db->where(array('req.enroll_id'=>$datum['enroll_id'], 'req.school_id'=>$this->session->userdata('school_id')));

                $this->db->order_by('req.refund_request_id', 'desc');

                $rs = $this->db->get()->result_array(); 

                $data[$k]['request_data'] = $rs;
            }
        }

        return $data;
    }
    
     function get_nationality_array(){
        $return = array();
        $this->db->select("id,name");
        $this->db->from($this->_table_nationality);
        $this->db->order_by("name", "asc");
         if (!empty($dataArray)) {
            $this->db->where($dataArray);
        }       
        return $this->db->get()->result_array();
    }
    
    function remove_profile_photo($student_id){
        $this->db->set('stud_image', '');
        $this->db->where('student_id',$student_id);
        $this->db->update($this->_table);
//        echo $this->last_query(); 
    }


    public function get_enrolled_student_for_fi($SearchText, $session) {
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $where['e.school_id'] = $school_id;
                $where2['e.school_id'] = $school_id;
            } 
        }

        $where['e.enroll_code'] = $SearchText;
        $where['e.year'] = $session;
        $where['stu.isActive'] = '1';
        $where['stu.student_status'] = '1';

        $this->db->select('stu.name stu_fname, stu.mname stu_mname, stu.lname stu_lname, stu.birthday, stu.sex, stu.phone, stu.email, stu.caste_category, e.enroll_id, e.enroll_code, e.roll, e.date_added, c.name class_name, s.name section_name');
        $this->db->from('student as stu');
        $this->db->join('enroll as e', 'e.student_id = stu.student_id');
        $this->db->join('class as c', 'c.class_id = e.class_id');
        $this->db->join('section as s', 's.section_id = e.section_id');
        $this->db->where($where);
        $data = $this->db->get()->result_array();

        if(count($data)){
            return $data;
        }else{
            $where2['e.year'] = $session;
            $where2['stu.isActive'] = '1';
            $where2['stu.student_status'] = '1';

            $this->db->select('stu.name stu_fname, stu.mname stu_mname, stu.lname stu_lname, stu.birthday, stu.sex, stu.phone, stu.email, stu.caste_category, e.enroll_id, e.enroll_code, e.roll, e.date_added, c.name class_name, s.name section_name');
            $this->db->from('student as stu');
            $this->db->join('enroll as e', 'e.student_id = stu.student_id');
            $this->db->join('class as c', 'c.class_id = e.class_id');
            $this->db->join('section as s', 's.section_id = e.section_id');
            $this->db->where($where2);

            $this->db->like('stu.name', $SearchText);

            $data = $this->db->get()->result_array();
            return $data;
        }
    }

    public function get_enquired_student_for_fi($SearchText, $session) {
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $where['e.school_id'] = $school_id;
                $where2['e.school_id'] = $school_id;
            } 
        }

        $where['e.enroll_code'] = $SearchText;
        $where['e.year'] = $session;
        $where['stu.isActive'] = '1';
        $where['stu.student_status'] = '1';

        $this->db->select('stu.name stu_fname, stu.mname stu_mname, stu.lname stu_lname, stu.birthday, stu.sex, stu.phone, stu.email, stu.caste_category, e.enroll_id, e.enroll_code, e.roll, e.date_added, c.name class_name, s.name section_name');
        $this->db->from('student as stu');
        $this->db->join('enroll as e', 'e.student_id = stu.student_id');
        $this->db->join('class as c', 'c.class_id = e.class_id');
        $this->db->join('section as s', 's.section_id = e.section_id');
        $this->db->where($where);
        $data = $this->db->get()->result_array();

        if(count($data)){
            return $data;
        }else{
            $where2['e.year'] = $session;
            $where2['stu.isActive'] = '1';
            $where2['stu.student_status'] = '1';

            $this->db->select('stu.name stu_fname, stu.mname stu_mname, stu.lname stu_lname, stu.birthday, stu.sex, stu.phone, stu.email, stu.caste_category, e.enroll_id, e.enroll_code, e.roll, e.date_added, c.name class_name, s.name section_name');
            $this->db->from('student as stu');
            $this->db->join('enroll as e', 'e.student_id = stu.student_id');
            $this->db->join('class as c', 'c.class_id = e.class_id');
            $this->db->join('section as s', 's.section_id = e.section_id');
            $this->db->where($where2);

            $this->db->like('stu.name', $SearchText);

            $data = $this->db->get()->result_array();
            return $data;
        }
    }

    
    function get_student_infoBYparentID($parent_id){
        $this->db->select('student.name,student.mname,student.lname,enroll.class_id,class.name as class_name'); // Select field
        $this->db->from('student'); // from Table1
        $this->db->join('enroll', 'student.student_id = enroll.student_id');
        $this->db->join('class', 'class.class_id = enroll.class_id');
        $this->db->where('student.parent_id', $parent_id);
        //$this->db->where('enroll.year', $running_year); /// Join table1 with table2 based on the foreign key
        $this->db->where('student.isActive', '1'); // Set Filter
        $this->db->where('student.student_status','1');
        return $this->db->get()->result_array();
    }

    function get_student_details_by_id($student_id=array()){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
        }

        $this->db->select('s.student_id, s.name, s.mname, s.lname, s.phone, s.email, s.device_token, e.class_id');
        $this->db->from('student s');
        $this->db->join('enroll e', 'e.student_id = s.student_id');
        $this->db->where_in('s.student_id',$student_id);
        $this->db->where('s.isActive','1');
        $this->db->where('s.student_status','1');
        $this->db->where('s.school_id', $school_id);
        return $this->db->get()->result_array();
    }

    function get_active_students($class_id, $section_id, $running_year) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('student.school_id',$school_id);
            } 
        }
        if ($class_id == 'all') {
            $this->db->select('*, student.name stdent_fname');
            $this->db->from('student');
            $this->db->join('enroll', 'student.student_id = enroll.student_id');
            $this->db->join('parent', 'parent.parent_id = student.parent_id');
            $this->db->join('section', 'section.section_id = enroll.section_id');
            $this->db->where('enroll.section_id', $section_id);
            $this->db->where('enroll.year', $running_year);
            $this->db->where('student.isActive', '1');
            $res = $this->db->get()->result_array();
            return $res;
        } else {
            $this->db->select('*, student.name stdent_fname');
            $this->db->from('student');
            $this->db->join('enroll', 'student.student_id = enroll.student_id');
            $this->db->join('parent', 'parent.parent_id = student.parent_id');
            $this->db->where('enroll.class_id', $class_id);
            $this->db->where('enroll.section_id', $section_id);
            $this->db->where('enroll.year', $running_year);
            $this->db->where('student.isActive', '1');
            $res = $this->db->get()->result_array();
            return $res;
        }
    }
    
    public function count_new_admissions($running_year) {
        $yearArr = explode("-",$running_year);
        $this->db->from('student as student');
        $this->db->where("(YEAR(student.date_time) = '".$yearArr[0]."' OR YEAR(student.date_time) = '".$yearArr[1]."') AND YEAR(student.date_time)!=''");
        return $this->db->count_all_results();
    }
    
    public function count_total_students() {
        $this->db->from('student');
        $this->db->where("YEAR(student.date_time)!=''");
        return $this->db->count_all_results();
    }
    
    public function update_student_info($id,$dataArray) {
        $this->db->where(array('student_id'=>$id));
        $this->db->update('student', $dataArray);
        return true;
    }
    
    function get_all_student_data_for_photo_update($year){ //stud_image
        $school_id = '';
        $school_id = $this->session->userdata('school_id');
        $this->db->select('s.student_id,s.name AS student_fname,s.lname AS student_lname,c.name AS class_name,se.name AS section_name')->from($this->_table_enroll." AS e");
        $this->db->join($this->_table." AS s",'e.student_id=s.student_id');
        $this->db->join('class AS c','e.class_id=c.class_id')->join('section AS se','e.section_id=se.section_id');
        $this->db->where('s.isActive','1')->where('s.student_status','1')->where('s.stud_image',NULL)->where('e.year', $year);
        $rs = $this->db->where('e.school_id',$school_id)->get()->result_array();
        //echo $this->db->last_query();
        return $rs;
    }
    
    function passport_expiry_reminder($year){
        $this->db->select('name, mname, lname, phone, email, passport_no, passport_expiry_date')->from($this->_table);
        $this->db->join($this->_table_enroll." AS e",'e.student_id=student.student_id');
        $this->db->where('student.isActive','1')->where('student.student_status','1')->where('student.passport_expiry_date >= "'.date('d/m/Y', strtotime('+30 days')).'"')->where('e.year', $year);
        $rs = $this->db->get()->result_array();
//        echo $this->db->last_query(); die;
        return $rs;
     }
     
     function visa_expiry_reminder($year){
        $this->db->select('name, mname, lname, phone, email, visa_no, visa_expiry_date')->from($this->_table);
        $this->db->join($this->_table_enroll." AS e",'e.student_id=student.student_id');
        $this->db->where('student.isActive','1')->where('student.student_status','1')->where('student.visa_expiry_date >= "'.date('d/m/Y', strtotime('+30 days')).'"')->where('e.year', $year);
        $rs = $this->db->get()->result_array();
//        echo $this->db->last_query(); die;
        return $rs; 
     }
}
