<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blog_model extends CI_Model {

    private $_table = "blog";
    private $_blog_category = "blog_category";
    private $_primary = "blog_id";
    
     var $column_order = array(null, 'blog_title', 'blog_user_name', 'blog_created_time', 'blog_available'); //set column field database for datatable orderable
    var $column_search = array('blog_title', 'blog_user_name', 'blog_created_time', 'blog_available'); //set column field database for datatable searchable 
    var $order = array('blog_id' => 'asc'); // default order 
    

    function __construct() {
        parent::__construct();
    }

    public function save_blog($dataArray) {
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('blog', $dataArray);
        $blog_id = $this->db->insert_id();
        return $blog_id;
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
        }
        if($school_id > 0){
            $sql = "select a.*, b.* from blog as a JOIN blog_comments as b ON a.blog_id = b.blog_id WHERE a.blog_id = $blog_id AND a.blog_available = '1' AND a.school_id = '".$school_id."' ORDER BY b. date_created DESC";
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
                $query = $this->db->get_where('blog_category', array('blog_category_parent_id' => $dataArray['blog_category_parent_id'], 'blog_category_name' => $dataArray['blog_category_name'], 'blog_category_isActive' => '1','school_id' => $school_id))->row();
            } 
        } else {
            $query = $this->db->get_where('blog_category', array('blog_category_parent_id' => $dataArray['blog_category_parent_id'], 'blog_category_name' => $dataArray['blog_category_name'], 'blog_category_isActive' => '1'))->row();
        }
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
            //echo $blog_id; exit;
            $this->db->where(array('blog_id' => $blog_id));
            $this->db->delete('blog_comments');
            return true;
        }
        //return $blog_comment_id;
    }

    public function update_blog($blog_id, $dataArray) {
        $this->db->where(array('blog_id' => $blog_id));
        $this->db->update('blog', $dataArray);
        return true;
    }

    public function get_count_of_subcategory($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $query = $this->db->get_where('blog_category', array('blog_category_parent_id' => $dataArray['blog_category_parent_id'], 'blog_category_name' => $dataArray['blog_category_name'], 'blog_category_isActive' => '1', 'school_id' => $school_id))->row();
            } 
        } else {
            $query = $this->db->get_where('blog_category', array('blog_category_parent_id' => $dataArray['blog_category_parent_id'], 'blog_category_name' => $dataArray['blog_category_name'], 'blog_category_isActive' => '1'))->row();
        }   
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
        $this->db->order_by('blog_category_id', 'DESC');
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
    public function _get_datatables_query($category_id='',$author_id='') { 
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
        if($author_id!='' && $author_id > 0) {
            $this->db->where(array('blog_author_id' => $author_id));
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
    
    function get_datatables($category_id='',$author_id='') {
        $list = $this->_get_datatables_query($category_id,$author_id);
        if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
   
    function count_filtered($category_id='',$author_id='') {
        $this->_get_datatables_query($category_id,$author_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function count_all($category_id = '',$author_id='') {
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
  
}
