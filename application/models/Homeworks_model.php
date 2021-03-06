<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Homeworks_model extends CI_Model {

    private $_table = "home_works";
    private $_primary = "home_work_id";
    
    function __construct() {
        parent::__construct();
    }

    
    /*
     * Add data
     * $table name
     * $data
     * return insert id
     */
    public function add_data( $dataArray ,$table_name = '') {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $dataArray['school_id'] = $school_id;
            } 
        }
        if($table_name == '')
            $table              =      $this->_table;
        else {
            $table              =       $table_name;
        }
        $this->db->insert( $table , $dataArray);
        $insert_id = $this->db->insert_id();
        if($insert_id)
            return $insert_id;
        else 
            return FALSE;
    }
    
    /*
     * update data
     */
    public function update_data($condition, $dataArray , $table_name = '') {
        if($table_name == '')
            $table              =      $this->_table;
        else {
            $table              =       $table_name;
        }
        if($condition && is_array($condition)) {
            foreach($condition as $key=>$val) {
               $this->db->where(array($key => $val));
            }
        } else {
            return false;
        }
        $update = $this->db->update($table , $dataArray);
        if($update)
            return true;
        else 
            return FALSE;
    }
    
    public function get_all_data_homework($condition = array()) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('home_works.school_id',$school_id);
            } 
        }
        
        $this->db->select("home_work_id,subject.name as subject,hw_name,hw_description,start_date,end_date,updated_date,marks");
        $this->db->from("home_works");
        $this->db->join('home_work_submissions','home_work_submissions.hw_id = home_works.home_work_id','inner');
        $this->db->join('subject','home_work_submissions.subject_id = subject.subject_id','inner');
        
        if(!empty($condition) && is_array($condition)) {
            foreach($condition as $key=>$val) {
               $this->db->where($key , $val);
            }
        }
      // echo $this->db->last_query(); die;
        $result     =   $this->db->get()->result_array();
        return $result;
    }    
    public function get_all_data($table_name = '' , $condition = array()) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        if($table_name == '')
            $table              =      $this->_table;
        else {
            $table              =       $table_name;
        }
        $this->db->select("*");
        $this->db->from($table);
        
        if(!empty($condition) && is_array($condition)) {
            foreach($condition as $key=>$val) {
               $this->db->where($key , $val);
            }
        }
        $result     =   $this->db->get()->result_array();
        return $result;
    }    



    public function addAnswer($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert( 'poll_answers' , $dataArray );
        $blog_id = $this->db->insert_id();
        return $blog_id;
    }
    
    public function getParentPolls( $class_ids , $parent_id ) {
        $school_id = ''; $where = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $where = " where poll.school_id = '".$school_id."'";
            } 
        }
        $sql    = 'SELECT poll.*, answ.no_of_votes, cls.name FROM online_polls poll LEFT JOIN poll_answers answ ON answ.poll_id = poll.poll_id LEFT JOIN class cls ON FIND_IN_SET(cls.class_id,poll.classes) '.$where.' GROUP BY poll_id';
        $result     = $this->db->query($sql)->result_array();
    }

        public function getOninePolls($condition = array()) {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                    $this->db->where('poll.school_id',$school_id);
                } 
            }
            $this->db->select('poll.*');
            $this->db->select('answ.no_of_votes,poll.parent_ids,poll.student_ids');
            $this->db->from($this->_table.' poll');
            $this->db->join('poll_answers answ','answ.poll_id = poll.poll_id','left');
            $this->db->where('status !=','3');
            if(!empty($condition) && is_array($condition)) {
                foreach($condition as $key=>$val) {
                   $this->db->where(array('poll.'.$key => $val));
                }
            } else {

            }
            $this->db->group_by('poll.poll_id'); 

            $result     =   $this->db->get()->result_array();
            return $result;
        }
    
    public function getOnlinpollAnswer($condition) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->select('*');
        $this->db->from('poll_answers');
        if($condition && is_array($condition)) {
            foreach($condition as $key=>$val) {
               $this->db->where(array($key => $val));
            }
        } else {
            return FALSE;
        }
        $result     =   $this->db->get()->result_array();
        return $result;
    }
    
    public function getPollCount($poll_id) {
        $school_id = ''; $where='';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $where = " and school_id = '".$school_id."'";
            } 
        }
        $sql = "SELECT SUM(no_of_votes) as total_poll FROM poll_answers WHERE poll_id = '".(int)$poll_id."'".$where;
        return $this->db->query($sql)->result();
    }
    
    public function poll_by_parent($poll_id,$answer_id,$parent_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->select('no_of_votes');
        $this->db->from('poll_answers');
        $this->db->where('poll_answer_id',$answer_id);
        $result     =   $this->db->get()->result_array();
        $no_of_vote         =       $result[0]['no_of_votes']+1;
        
        $this->db->select('parent_ids');
        $this->db->from($this->_table);
        $this->db->where('poll_id',$poll_id);
        $result     =   $this->db->get()->result_array();
        $parent_ids         =       ($result[0]['parent_ids'] == '' ?$parent_id:$result[0]['parent_ids'].",$parent_id");

        
        $this->db->where(array('poll_answer_id' => $answer_id));
        $this->db->update('poll_answers', array('no_of_votes'=>$no_of_vote));
        
        $this->db->where(array('poll_id' => $poll_id));
        $this->db->update($this->_table, array('parent_ids' => $parent_ids));
        
        return true;
    }
    
    public function poll_by_student($poll_id,$answer_id,$student_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->select('no_of_votes');
        $this->db->from('poll_answers');
        $this->db->where('poll_answer_id',$answer_id);
        $result             =       $this->db->get()->result_array();
        $no_of_vote         =       $result[0]['no_of_votes']+1;
        
        $this->db->select('student_ids');
        $this->db->from($this->_table);
        $this->db->where('poll_id',$poll_id);
        $result     =   $this->db->get()->result_array();
        $student_ids         =       ($result[0]['student_ids'] == '' ?$student_id:$result[0]['student_ids'].",$student_id");

        
        $this->db->where(array('poll_answer_id' => $answer_id));
        $this->db->update('poll_answers', array('no_of_votes'=>$no_of_vote));
        
        $this->db->where(array('poll_id' => $poll_id));
        $this->db->update($this->_table, array('student_ids' => $student_ids));

        return true;
    }

    public function make_available($blog_id) {
        $time = date('Y-m-d H:i:s');
        $this->db->where(array('blog_id' => $blog_id));
        $this->db->update('blog', array('blog_available' => '1', 'blog_published_time'=> $time));
        return true;
    }

    public function resend_blogs($blog_id, $comment) {
        $this->db->where(array('blog_id' => $blog_id));
        $this->db->update('blog', array('blog_resend_comment' => $comment, 'blog_available' => '3'));
        return true;
    }

    public function save_blogs_comments($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('blog_comments', $dataArray);
        $blog_comments_id = $this->db->insert_id();
        return $blog_comments_id;
    }

    public function get_blogs_comments($blog_id) {
        $school_id = ''; $where = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $where = " AND a.school_id = '".$school_id."'";
            } 
        }
        $sql = "select a.*, b.* from blog as a JOIN blog_comments as b ON a.blog_id = b.blog_id WHERE a.blog_id = '".$blog_id."' AND a.blog_available = '1' ".$where." ORDER BY b. date_created DESC";
        return $this->db->query($sql)->result();
    }

    public function add_blog_category($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('blog_category', $dataArray);
        $blog_category_id = $this->db->insert_id();
        return $blog_category_id;
    }
    
    public function student_homework_add($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('home_work_submissions', $dataArray);
        $submission_id = $this->db->insert_id();
        return $submission_id;
    }
    
    public function get_count($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $query = $this->db->get_where('blog_category', array('blog_category_parent_id' => $dataArray['blog_category_parent_id'], 'blog_category_name' => $dataArray['blog_category_name'], 'blog_category_isActive' => '1'))->row();
        return count($query);
    }

    public function get_my_blogs($userData) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->select('*');
        $this->db->from("blog");
        if (!empty($userData)) {
            $this->db->where($userData);
            $this->db->or_where("('blog_available' IN (1,2,3))");
        }
        $this->db->order_by('blog_created_time', 'DESC');
        $return = $this->db->get()->result_array();
        return $return;
    }
    
    public function get_student_homework() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('home_works.school_id',$school_id);
            } 
        }
        $this->db->select("home_works.hw_name AS NAME, home_works.`start_date`, home_works.`end_date`,home_work_submissions.`updated_date`,
CONCAT('',student.`name`,student.`lname`)  AS student");
        $this->db->from("home_works");
        
        if (!empty($userData)) {
            $this->db->where($userData);
            $this->db->or_where("('blog_available' IN (1,2,3))");
        }
        $this->db->order_by('blog_created_time', 'DESC');
        $return = $this->db->get()->result_array();
        return $return;
    }

    function delete_homework($id)
    {
         $this->db->where(array('home_work_id' => $id));
        $id = $this->db->delete('home_works');
        return true;
    }
    
     public function homework_delete($homework_delete) {
        $this->db->where(array('homework_typeid' => $homework_delete));
        $id = $this->db->delete('home_work_types');
        return true;
    }
    public function blogdelete($blog_id) {
        $this->db->where(array('blog_id' => $blog_id));
        $id = $this->db->delete('blog');
        if ($id) {
            $this->db->where(array('blog_id' => $blog_id));
            $this->db->delete('blog_comments');
            return true;
        }
    }

    public function get_count_of_subcategory($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $query = $this->db->get_where('blog_category', array('blog_category_parent_id' => $dataArray['blog_category_parent_id'], 'blog_category_name' => $dataArray['blog_category_name'], 'blog_category_isActive' => '1'))->row();
        return count($query);
    }

    public function delete_category($category_id) {
        $this->db->where(array('blog_category_id' => $category_id));
        $this->db->update('blog_category', array('blog_category_isActive' => '0'));
        return true;
    }

    public function update_category($condition, $dataArray) {
        $this->db->where($condition);
        $this->db->update('blog_category', $dataArray);
        return true;
    }

    public function get_subcategories() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $id = array(0);
        $this->db->select('*');
        $this->db->from('blog_category');
        $this->db->where('blog_category_isActive', '1');
        $this->db->where_not_in('blog_category_parent_id', $id);
        $return = $this->db->get()->result_array();
        return $return;
    }

    public function getblog_status() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $isAvailable = array('2', '3');
        $this->db->select('*');
        $this->db->from('blog');
        $this->db->where_in('blog_available', $isAvailable);
        $this->db->order_by('blog_created_time', 'DESC');
        $return = $this->db->get()->result_array();
        return $return;
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
    
    // GET DATATABLE OF blogs
    public function _get_datatables_query($category_id='') { 
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        if($category_id == 'all' || $category_id =='0'){
            $this->db->select('*');            
            $this->db->from($this->_table);
            $this->db->where_in('blog_available', 1);
            $this->db->order_by('blog_created_time', 'DESC');
        } else if($category_id ==''){
            $isAvailable = array('2', '3');
            $this->db->select('*');
            $this->db->from($this->_table);
            $this->db->where_in('blog_available', $isAvailable);
            $this->db->order_by('blog_created_time', 'DESC');
        } else if($category_id){
            $this->db->select('*');            
            $this->db->from($this->_table);
            $this->db->where(array('blog_available'=>1, 'blog_category_id'=> $category_id));
            $this->db->order_by('blog_created_time', 'DESC');
        } 
        $i = 0;
        foreach ($this->column_search as $item) { 
            if ($_POST['search']['value']) { 
                if ($i === 0) { 
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }

        if (isset($_POST['order'])) { 
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    
    function get_datatables($category_id='') {
        $list = $this->_get_datatables_query($category_id);
        if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
   
    function count_filtered($category_id='') {
        $this->_get_datatables_query($category_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function count_all($category_id = '') {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        if($category_id == '1' || $category_id =='0' || $category_id ==''){
             $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->where_in('blog_available', 1);
        $this->db->order_by('blog_created_time', 'DESC');
        }elseif($category_id!='1'){
             $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->where_in('blog_category_id', $category_id);
        $this->db->where_in('blog_available','1');        
        $this->db->order_by('blog_created_time', 'DESC');
        }
        else{
        $isAvailable = array('2', '3');
        $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->where_in('blog_available', $isAvailable);
        $this->db->order_by('blog_created_time', 'DESC');
        }        
        return $this->db->count_all_results();
    }
    function get_homework_class_id_student_login($class_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('home_works.school_id',$school_id);
            } 
        }
        $this->db->select('home_works.*,section.name AS section_name');
        $this->db->from($this->_table." AS home_works");
        $this->db->join("section AS section",'section.section_id=home_works.section_id','left');
        $this->db->where('home_works.section_id',$class_id);
        //$this->db->where('oe.status',"active");
        $rs = $this->db->get()->result_array();
        
        return $rs;
    }
    function get_homework_submitted($student_id, $homework_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('home_works.school_id',$school_id);
            } 
        }
        $this->db->select('home_work_submissions.*,home_works.hw_name AS homework_name');
        $this->db->from("home_work_submissions");
        $this->db->join("home_works",'home_work_submissions.hw_id=home_works.home_work_id','left');
        $this->db->where('home_work_submissions.student_id',$student_id);
        $this->db->where('home_work_submissions.hw_id',$homework_id);
        //$this->db->where('oe.status',"active");
        $rs = $this->db->get()->result_array();
       
        return $rs;
    }
    
    public function get_student_homework_done($class_id = '', $section_id = '') {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('home_works.school_id',$school_id);
            } 
        }
        $this->db->select("home_work_id,home_works.hw_name AS homework,marks, home_works.start_date, home_works.end_date,home_work_submissions.updated_date,
student.name, student.lname");
        $this->db->from("home_works");
        $this->db->join("home_work_submissions",'home_work_submissions.hw_id=home_works.home_work_id','inner');
        $this->db->join("student",'home_work_submissions.student_id=student.student_id','inner');
        $this->db->where('home_work_submissions.class_id',$class_id);
        $this->db->where('home_work_submissions.section_id',$section_id);
        
        $this->db->order_by('home_work_submissions.updated_date', 'DESC');
        $return = $this->db->get()->result_array();
        
        return $return;
    }
  public function get_student_homework_view($homework_id = '') {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('home_works.school_id',$school_id);
            } 
        }
        $this->db->select("home_work_id,marks,home_works.hw_name AS homework, home_works.start_date, home_works.end_date,home_work_submissions.updated_date,
student.name, student.lname,submission_disc");
        $this->db->from("home_works");
        $this->db->join("home_work_submissions",'home_work_submissions.hw_id=home_works.home_work_id','inner');
        $this->db->join("student",'home_work_submissions.student_id=student.student_id','inner');
        $this->db->where('home_work_submissions.hw_id',$homework_id);

        
        $this->db->order_by('home_work_submissions.updated_date', 'DESC');
        $return = $this->db->get()->result_array();
        
        return $return;
    }
    public function update_homework_marks($homework_id, $dataArray) {
        $this->db->where("hw_id", $homework_id);
        $update = $this->db->update("home_work_submissions" , $dataArray);
        if($update)
            return true;
        else 
            return FALSE;
    }
}
