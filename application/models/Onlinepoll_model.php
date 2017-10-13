 <?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Onlinepoll_model extends CI_Model {

    private $_table = "online_polls";
    private $_primary = "poll_id";
    
    function __construct() {
        parent::__construct();
    }

    public function addPoll($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        //pre($dataArray);die;
        $this->db->insert($this->_table , $dataArray);
        $blog_id = $this->db->insert_id();
        return $blog_id;
    }
    
    public function updatePoll($condition, $dataArray) {
        if($condition && is_array($condition)) {
            foreach($condition as $key=>$val) {
               $this->db->where(array($key => $val));
            }
        } else {
            return false;
        }
        $this->db->update($this->_table , $dataArray);
        return true;
    }
    
    public function addAnswer($dataArray) {
        $school_id = '';
        $school_id = $this->session->userdata('school_id');
        if($school_id > 0){
            $dataArray['school_id'] = $school_id;
        }else{
            $dataArray['school_id'] = 1;
        }
        $this->db->insert('poll_answers' , $dataArray );
        $blog_id = $this->db->insert_id();
        return $blog_id;
    }
    
    public function getParentPolls( $class_ids , $parent_id ) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql  = "SELECT poll.*, answ.no_of_votes, cls.name FROM online_polls poll LEFT JOIN poll_answers answ ON answ.poll_id = poll.poll_id LEFT JOIN class cls ON FIND_IN_SET(cls.class_id,poll.classes) where poll.school_id = '".$school_id."' GROUP BY poll_id";
            } 
        } else {
            $sql  = 'SELECT poll.*, answ.no_of_votes, cls.name FROM online_polls poll LEFT JOIN poll_answers answ ON answ.poll_id = poll.poll_id LEFT JOIN class cls ON FIND_IN_SET(cls.class_id,poll.classes) GROUP BY poll_id';
        }
            
        $result     = $this->db->query($sql)->result_array();
    }

    public function getOninePolls($condition = array()) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                //$this->db->where('poll.school_id',$school_id);
            } 
        }
        $this->db->select('poll.*');
        $this->db->select('answ.no_of_votes,poll.parent_ids,poll.student_ids');
        $this->db->from($this->_table.' poll');
        $this->db->join('poll_answers answ','answ.poll_id = poll.poll_id','left');
        if ($this->session->userdata('school_admin_login') != 1)
            $this->db->where('status','1');
        else    
            $this->db->where('status !=','3');
        if(!empty($condition) && is_array($condition)) {
            foreach($condition as $key=>$val) {
               $this->db->where(array('poll.'.$key => $val));
            }
        } else {

        }
        $this->db->group_by('poll.poll_id'); 

        $result     =   $this->db->get()->result_array();
        //echo $this->db->last_query();die;
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
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql = "SELECT SUM(no_of_votes) as total_poll FROM poll_answers WHERE poll_id = '".(int)$poll_id."' AND school_id = '".$school_id."'";
            } 
        } else {
            $sql = "SELECT SUM(no_of_votes) as total_poll FROM poll_answers WHERE poll_id = ".(int)$poll_id;
        }
        //echo $sql;die;
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
        $school_id = $this->session->userdata('school_id');
        $this->db->select('no_of_votes');
        $this->db->from('poll_answers');
        $this->db->where('poll_answer_id',$answer_id);
        if($school_id > 0){
            $this->db->where('school_id',$school_id);
        }
        $result             =       $this->db->get()->result_array();
        $no_of_vote         =       $result[0]['no_of_votes']+1;
        
        $this->db->select('student_ids');
        $this->db->from($this->_table);
        $this->db->where('poll_id',$poll_id);
        if($school_id > 0){
            $this->db->where('school_id',$school_id);
        }
        $result     =   $this->db->get()->result_array();
        $student_ids         =       ($result[0]['student_ids'] == '' ?$student_id:$result[0]['student_ids'].",$student_id");

        
        $this->db->where(array('poll_answer_id' => $answer_id));
        $this->db->update('poll_answers', array('no_of_votes'=>$no_of_vote));
        
        $this->db->where(array('poll_id' => $poll_id));
        $this->db->update($this->_table, array('student_ids' => $student_ids));

        return true;
    }
    
    public function poll_by_teacher($poll_id,$answer_id,$teacher_id) {
        $school_id = '';
        $teacher_ids="";
        $school_id = $this->session->userdata('school_id');
        $this->db->select('no_of_votes');
        $this->db->from('poll_answers');
        $this->db->where('poll_answer_id',$answer_id);
        if($school_id > 0){
            $this->db->where('school_id',$school_id);
        }
        $result             =       $this->db->get()->result_array();
        $no_of_vote         =       $result[0]['no_of_votes']+1;
        
        $this->db->select('teacher_ids');
        $this->db->from($this->_table);
        $this->db->where('poll_id',$poll_id);
        if($school_id > 0){
            $this->db->where('school_id',$school_id);
        }
        $result     =   $this->db->get()->result_array();
        //echo $this->db->last_query();
        //pre($result);die;
        $teacher_ids         =       ($result[0]['teacher_ids'] == '' ?$teacher_id:$result[0]['teacher_ids'].",$teacher_id");

        
        $this->db->where(array('poll_answer_id' => $answer_id));
        $this->db->update('poll_answers', array('no_of_votes'=>$no_of_vote));
        
        $this->db->where(array('poll_id' => $poll_id));
        $this->db->update($this->_table, array('teacher_ids' => $teacher_ids));
        
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
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql = "select a.*, b.* from blog as a JOIN blog_comments as b ON a.blog_id = b.blog_id WHERE a.blog_id = $blog_id AND a.blog_available = '1' AND a.school_id = '".$school_id."' ORDER BY b. date_created DESC";
            } 
        } else {
            $sql = "select a.*, b.* from blog as a JOIN blog_comments as b ON a.blog_id = b.blog_id WHERE a.blog_id = $blog_id AND a.blog_available = '1' ORDER BY b. date_created DESC";
        }
        
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
 
    function get_closed_online_polls(){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                //$this->db->where('poll.school_id',$school_id);
            } 
        }
        $this->db->select('poll.*');
        $this->db->select('answ.no_of_votes,poll.parent_ids,poll.student_ids');
        $this->db->from($this->_table.' poll');
        $this->db->join('poll_answers answ','answ.poll_id = poll.poll_id','left');
           
            $this->db->where('status','2');
        if(!empty($condition) && is_array($condition)) {
            foreach($condition as $key=>$val) {
               $this->db->where(array('poll.'.$key => $val));
            }
        } else {

        }
        $this->db->group_by('poll.poll_id'); 

        $result     =   $this->db->get()->result_array();
        //echo $this->db->last_query();die;
        return $result;
    }
}
