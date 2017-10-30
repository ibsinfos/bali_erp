<?php
if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class Discussion_category_model extends CI_Model {
        private $_table = "discussion_category";

        function __construct(){
            parent::__construct();
        }
        
        public function add_category($dataArray){
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $dataArray['school_id'] = $school_id;
                } 
            }
            $this->db->insert('discussion_category', $dataArray);
            generate_log($this->db->last_query());
            $category_id = $this->db->insert_id();            
            return $category_id;  
        }
        
        public function get_count_category($category) {   
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $query = $this->db->get_where('discussion_category',array('name' => $category['name'],'isActive'=>'1'))->row();                   
            return count($query);                       
        }
        
        public function get_count_slug($category) {   
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $query = $this->db->get_where('discussion_category',array('name' => $category['slug'],'isActive'=>'1'))->row();                   
            return count($query);                       
        }
    
        public function category_get_children($id, $separator, $counter){
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $this->db->order_by('name', 'asc');
            $query = $this->db->get_where('discussion_category', array('parent_id' => $id, 'isActive'=>'1'));
            if ($query->num_rows() == 0){
                    return FALSE;
            }
            else {
            foreach($query->result() as $row){
                $counter++;
                $this->data[$counter]['category_id'] = $row->category_id;
                $this->data[$counter]['parent_id'] = $row->parent_id;
                $this->data[$counter]['name'] = $separator.$row->name;
                $this->data[$counter]['slug'] = $row->slug;
                $this->data[$counter]['real_name'] = $row->name;
                $children = $this->category_get_children($row->category_id, $separator.' - ', $counter);

                if ($children != FALSE)
                {
                        $counter = $counter + $children;
                }
            }
            return $counter;
            }
        }
        
        public function save_thread($thread_save){
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $thread_save['school_id'] = $school_id;
                } 
            }
            $this->db->insert('discussion_thread', $thread_save);          
            $thread_id = $this->db->insert_id();            
            return $thread_id;            
        }
        
        public function save_posts($post_save){
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $this->db->insert('discussion_post', $post_save);           
            $post_id = $this->db->insert_id();            
            return $post_id;            
        }
        
        public function get_all_thread(){
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('dt.school_id',$school_id);
                } 
            }
            $this->db->select('dc.*, dt.*');
            $this->db->from('discussion_thread as dt');
            $this->db->join('discussion_category as dc','dt.category_id = dc.category_id');             
            $this->db->order_by('dt.date_created', 'DESC');
            $res = $this->db->get()->result_array();
            return $res;
        }
              
        public function get_count($id) {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $this->db->select('count(*) as count');
            $this->db->from('discussion_post');
            $this->db->where(array('thread_id'=>$id));
            $res = $this->db->get()->result_array();
            return $res;
        }
        
        public function get_posts($thread_id) {          
            $school_id = ''; $where = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $where = " AND a.school_id = '".$school_id."'";
                } 
            }
            $sql = "SELECT a.* FROM discussion_post as a WHERE a.thread_id = '".$thread_id."' ".$where." ORDER BY a.date_add ASC";
            return $this->db->query($sql)->result();
        }
        
        public function save_replies($post_replied){
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $post_replied['school_id'] = $school_id;
                } 
            }
            $this->db->insert('discussion_post', $post_replied);          
            $reply_id = $this->db->insert_id();            
            return $reply_id;   
        }
        
        public function delete_category($category_id){            
            $this->db->where(array('category_id' => $category_id));
            $this->db->update('discussion_category', array('isActive' =>'0'));            
            return true;
        }
        
        
        public function update_category($dataArray, $condition) {
            $this->db->where($condition);
            $this->db->update('discussion_category', $dataArray);            
            return true;
        }
        
        public function category_get_all_parent($id, $counter) {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('school_id',$school_id);
                } 
            }
            $row = $this->db->get_where('discussion_category', array('category_id' => $id))->row_array();    
            $this->data[$counter]['category_id'] = $row;
            if ($row['parent_id'] != 0) {
                $counter++;
                $this->category_get_all_parent($row['parent_id'], $counter);
            }
            return array_reverse($this->data);
        }
        
        public function get_thread_in_detail($param){
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                   $this->db->where('dt.school_id',$school_id);
                } 
            }
            $this->db->select('dc.*, dt.*, dp.*');
            $this->db->from('discussion_thread as dt');
            $this->db->join('discussion_category as dc','dt.category_id = dc.category_id'); 
            $this->db->join('discussion_post as dp', 'dt.thread_id = dp.thread_id');
            $this->db->order_by('dt.date_created', 'DESC');
            $this->db->where(array('dt.thread_id' => $param));
            $res = $this->db->get()->result_array();
            return $res;
        }
      
        public function get_user_type_id(){      
            $data                                                        =   array();
            if($this->session->userdata('school_admin_login') == 1 ) {
                $data['user_type']                                       =    'school_admin';
                $data['user_id']                                         =    $this->session->userdata('school_admin_id');
                $data['user_name']                                       =    $this->session->userdata('name');
            }
            else if($this->session->userdata('teacher_login') == 1 ) {
                $data['user_type']                                       =    'teacher';
                $data['user_id']                                         =    $this->session->userdata('teacher_id');
                $data['user_name']                                       =    $this->session->userdata('name');
            }
            else if($this->session->userdata('parent_login') == 1 ) {
                $data['user_type']                                       =    'parent';
                $data['user_id']                                         =    $this->session->userdata('parent_id');
                $data['user_name']                                       =    $this->session->userdata('name');
            }
            else if($this->session->userdata('student_login') == 1 ) {
                $data['user_type']                                       =    'student';
                $data['user_id']                                         =    $this->session->userdata('student_id');
                $data['user_name']                                       =    $this->session->userdata('name');
            }
            return $data;
        }
    
    public function get_all_thread_by_category($category_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('dt.school_id',$school_id);
            } 
        }
        $this->db->select('dc.*, dt.*');
        $this->db->from('discussion_thread as dt');
        $this->db->join('discussion_category as dc','dt.category_id = dc.category_id'); 
        $this->db->where(array('dt.category_id' => $category_id));
        $this->db->order_by('dt.date_created', 'DESC');
        $res = $this->db->get()->result_array();
        return $res;
        
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
//echo $this->db->last_query(); die;
        return $rs;
    }
    
}