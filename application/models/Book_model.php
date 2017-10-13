<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Book_model extends CI_Model {
    
  //  private $_book_table="book";
    private $_issue_table="book_issue_table";

    private $_table = "expense_category";

    function __construct() {
        parent::__construct();
    }

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
    
    function update($param2, $data)
    {
        $this->db->where('payment_id', $param2);
        $this->db->update($this->_table, $data);
    }

    function delete($param2)
    {
        $this->db->where('payment_id', $param2);
        $this->db->delete($this->_table);
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
            return $this->db->get_where($this->_table,array($this->_primary,$id))->result();
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
    
     
        public function get_books_issue_records($conditionArr,$order_by,$order_dir){
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                    $this->db->where('school_id',$school_id);
                } 
            }
            $this->db->select('lib.name issue_by_name,lib1.name return_to_name,issue_date,return_date,books.book_title');
            $this->db->from($this->_issue_table);
            $this->db->join("books", 'books.book_id='.$this->_issue_table.'.book_unique_id', "left");
            $this->db->join("librarian as lib", 'lib.librarian_id = '.$this->_issue_table.'.issue_by', "left");
            $this->db->join("librarian as lib1", 'lib1.librarian_id = '.$this->_issue_table.'.return_to', "left");
            if (!empty($conditionArr))
            {
                $this->db->where($conditionArr);
            }
            if (!empty($order_by))
            {
                $this->db->order_by($order_by, $order_dir);
            }
            
            $result = $this->db->get()->result_array();
            return $result;
        }
        
        public function get_books_issue_records_from_circulation($table,$conditionArr){
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                    $this->db->where($table.'.school_id',$school_id);
                } 
            }
            $this->db->select('issue_date,return_date,fine_amount,is_returned,bi.title');
            $this->db->from($table);
            $this->db->join("book_info bi", 'bi.id='.$table.'.book_id', "left");
            
            if (!empty($conditionArr))
            {
                $this->db->where($conditionArr);
            }
            
            $result = $this->db->get()->result_array();

            return $result;
        }
}