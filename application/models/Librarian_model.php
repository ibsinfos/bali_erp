<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Librarian_model extends CI_Model {
    private $_table="librarian";
    private $_table_circulation="circulation";
    private $_table_book_info="book_info";
    private $_table_student="student";
//    s.name student_name, s.email, s.lname, c.book_id, c.issue_date, c.return_date, c.fine_amount, b.title'
     var $column_order = array(null, 's.name', 's.email', 'b.title', 'c.issue_date', 'c.return_date', 'c.fine_amount'); //set column field database for datatable orderable
    var $column_search = array('s.name', 's.email', 'b.title', 'c.issue_date', 'c.return_date', 'c.fine_amount'); //set column field database for datatable searchable 
    var $order = array('c.id' => 'asc'); // default order 

    function __construct() {
        parent::__construct();
    }
    
    public function add($dataArray){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $dataArray;
            } 
        }
        $this->db->insert('librarian', $dataArray);
        $teacher_id = $this->db->insert_id();
        return $teacher_id;
    }
    
    function is_new_librarian_exists($email){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $rs=$this->db->get_where('librarian',array('email'=>$email))->result();
        generate_log($this->db->last_query());
        if(count($rs)==0){
            return FALSE;
        }else{
            return TRUE;
        }
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
    
     private function _get_datatables_query() {
         $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('c.school_id',$school_id);
            } 
        }
        $this->db->select('c.*,s.name AS student_name,s.email,s.lname,b.title'); 
        $this->db->from($this->_table_circulation.' AS c');
        $this->db->join($this->_table_student.' AS s','s.card_id=c.member_id','left');
        $this->db->join($this->_table_book_info.' AS b','b.id=c.book_id', 'left');
   
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
    
    function get_datatables() {
        $list = $this->_get_datatables_query();
        if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
   
    function count_filtered(){
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function count_all(){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->from($this->_table_circulation);
        return $this->db->count_all_results();
    }
    
    public function get_data($table, $where='', $select='', $join='', $limit='', $start=null, $order_by='', $group_by='', $num_rows=0, $csv='') 
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->select($select);
        $this->db->from($table);
        
        if ($join!='') {
            $this->generate_joining_clause($join);
        }
        if ($where!='') {
            $this->generate_where_clause($where);
        }

        if ($this->db->field_exists('deleted', $table)) {
            $deleted_str=$table.".deleted";
            $this->db->where($deleted_str, "0");
        }
        
        if ($order_by!='') {
            $this->db->order_by($order_by);
        }
        if ($group_by!='') {
            $this->db->group_by($group_by);
        }       
        

        if (is_numeric($start) || is_numeric($limit)) {
            $this->db->limit($limit, $start);
        }
                    
        $query=$this->db->get();
        
        if ($csv==1) {
			echo $query;
            return $query;
        } //csv generation requires resourse ID

        $result_array=$query->result_array(); //fetches the rows from database and forms an array[]

        if ($num_rows==1) {
            $num_rows=$query->num_rows(); //counts the affected number of rows
            $result_array['extra_index']=array('num_rows'=>$num_rows);    //addes the affected number of rows data in the array[]
        }
        
        return $result_array; //returns both fetched result as well as affected number of rows		
    }
    
    public function generate_where_clause($where) //generates the joining clauses as given array
    {
        $keys = array_keys($where);  // holds the clause types. Ex- array(0=>'where',1=>'where_in'......................) 

        for ($i=0;$i<count($keys);$i++) {
            if ($keys[$i]=='where') {
                $this->db->where($where['where']);
            }  // genereates the where clauses

            elseif ($keys[$i]=='where_in') {
                $keys_inner = array_keys($where['where_in']); // holds the field names. Ex- array(0=>'id',1=>'username'......................) 
                for ($j=0;$j<count($keys_inner);$j++) {
                    $field=$keys_inner[$j]; // grabs the field names
                    $value=$where['where_in'][$keys_inner[$j]];     // grabs the array values of the grabed field to be find in
                    $this->db->where_in($field, $value);    //genereates the where_in clause	s				
                } //end for
            } //end else if

            elseif ($keys[$i]=='where_not_in') {
                // works similar as where_in specified above

                $keys_inner = array_keys($where['where_not_in']);
                for ($j=0;$j<count($keys_inner);$j++) {
                    $field=$keys_inner[$j];
                    $value=$where['where_not_in'][$keys_inner[$j]];
                    $this->db->where_not_in($field, $value);    // genereates the where_not_in clauses					
                } // end for
            } // end else if

            elseif ($keys[$i]=='or_where') {
                $this->db->or_where($where['or_where']);
            } // genereates the or_where clauses

            elseif ($keys[$i]=='or_where_advance') {
                // works similar as where_in but the array indexes & values are in reverse format as given parameter 

                $keys_inner = array_keys($where['or_where_advance']);
                for ($j=0;$j<count($keys_inner);$j++) {
                    $field=$where['or_where_advance'][$keys_inner[$j]];
                    $value=$keys_inner[$j];
                    $this->db->or_where($field, $value);    // genereates the or_where clauses								
                } // end for
            } // end else if

            elseif ($keys[$i]=='or_where_in') {
                // works similar as where_in specified above

                $keys_inner = array_keys($where['or_where_in']);
                for ($j=0;$j<count($keys_inner);$j++) {
                    $field=$keys_inner[$j];
                    $value=$where['or_where_in'][$keys_inner[$j]];
                    $this->db->or_where_in($field, $value);    // genereates the or_where_in clauses					
                } // end for
            } // end else if

            elseif ($keys[$i]=='or_where_not_in') {
                // works similar as where_in specified above

                $keys_inner = array_keys($where['or_where_not_in']);
                for ($j=0;$j<count($keys_inner);$j++) {
                    $field=$keys_inner[$j];
                    $value=$where['or_where_not_in'][$keys_inner[$j]];
                    $this->db->or_where_not_in($field, $value);    // genereates the or_where_not_in clauses					
                } // end for
            } // end else if			
        } // end outer for	
    }
 }

