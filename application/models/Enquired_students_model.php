<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Enquired_students_model extends CI_Model{
    
    private $_table="enquired_students";
    private $_table_siblings="siblings";
    private $_table_invoice="invoice";
    private $_table_parent="parent";
    private $_table_enroll="enroll";
    private $_table_student="student";
    private $_table_class="class";
    var $column_order = array(null, 'admission_form_id', 'student_fname','student_lname', 'parent_fname','parent_lname', 'class_id','birthday','user_email','mobile_number'); //set column field database for datatable orderable
    var $column_search = array('admission_form_id', 'student_fname','student_lname', 'parent_fname','parent_lname', 'class_id','birthday','user_email','mobile_number','advance','form_genreated','form_no','counselling'); //set column field database for datatable searchable 
    var $order = array('enquired_student_id' => 'desc'); // default order 

    function __construct() {
        parent::__construct();
    }

    public function save_enquired_student($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('enquired_students', $dataArray);
        generate_log($this->db->last_query());
        $applied_student_id = $this->db->insert_id();
        return $applied_student_id;
    }

    public function get_all_enquired_student($dataArray="") {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        }
        $return = array();
        $this->db->select("*");
        $this->db->from($this->_table);
        $this->db->order_by("student_fname", "asc");        
        if (!empty($dataArray)) {
            $this->db->where($dataArray);
        }
        $return = $this->db->get()->result_array(); 
        return $return;
    }

    function check_form_no_uniqueness($form_no=false){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->get_where('enquired_students',array('form_no'=>$form_no))->row();
    }    

    function genertate_random_admission_form_id(){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        }
        $rand_adm_form_id = substr(md5(rand(0, 1000000)), 0, 7);
        $k=1;
        for($i=0;$i<=$k;$i++){
            $has_record = $this->db->get_where('enquired_students',array('admission_form_id'=>$rand_adm_form_id))->row();
            if($has_record){
                $rand_adm_form_id = substr(md5(rand(0, 1000000)), 0, 7);
                $k++;
            }
        }
        return $rand_adm_form_id;
    }

    public function get_parent_details($students_id){     
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->select('user_email,mobile_number,parent_fname,parent_lname,advance');
        $this->db->from($this->_table);
        $this->db->where(array(`enquired_student_id`=> $students_id));
        $return = $this->db->get()->result_array();     
        return $return;
    }

    
    public function update_enquiry($dataArray,$conditionArray)
    {
        $this->db->where($conditionArray);
        $this->db->update($this->_table,$dataArray);
        return true;
    }
    public function get_student_details($param1)
    {   
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        }
        $query = $this->db->get_where($this->_table,array('student_id'=>$param1));
        return $query->row_array();
    }


    public function get_count(){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        }
        $num_rows = $this->db->count_all_results($this->_table);
        return $num_rows; 
    }
    
    public function get_all(){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        }
        $query = $this->db->get($this->_table);
        return $query->result();
    }

    public function save_siblings($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert($this->_table_siblings, $dataArray);
        $applied_student_id = $this->db->insert_id();
        return $applied_student_id;
    }
    
    function get_all_enquired_student_with_all_data(){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('es.school_id',$school_id);
            } 
        }
        $this->db->select('es.*,i.invoice_id, c.name AS class_name');
        $this->db->from($this->_table." AS es");
        $this->db->join('invoice AS i','es.student_id=i.student_id AND i.title="Advance"','left');
        $this->db->join($this->_table_class.' AS c','c.class_id = es.class_id','left');
        $this->db->order_by('enquired_student_id','desc');
        return $this->db->get()->result_array();
    }
    
    function save_siblings_batch($dataArr,$student_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $dataArr['school_id'] = $school_id;
            } 
        }
        $this->db->where("student_id",$student_id);
        $this->db->delete($this->_table_siblings);
        
        $this->db->insert_batch($this->_table_siblings,$dataArr);
        return TRUE;
    }
    
    function add_invoice($dataArr){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $dataArr['school_id'] = $school_id;
            } 
        }
        $this->db->insert($this->_table_invoice,$dataArr);
        return $this->db->insert_id();
    }
    
    function get_my_enquired_chield($parent_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('en.school_id',$school_id);
            } 
        }
        $this->db->select("s.student_id,s.name")->from($this->_table." en")->join($this->_table_enroll." e","en.student_id=e.student_id");
        $this->db->join($this->_table_student." s","e.student_id=s.student_id")->join($this->_table_parent." p","s.parent_id=p.parent_id");
        $rs=$this->db->where("p.parent_id",$parent_id)->where("e.class_id",99999)->get()->result_array();
        return $rs;
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
               $this->db->where('es.school_id',$school_id);
            } 
        }    
        $this->db->select('es.*');
        $this->db->select('i.invoice_id');
        $this->db->from($this->_table.' as es');
        $this->db->where('es.counselling','0');
        $this->db->join('invoice AS i','es.student_id=i.student_id AND i.title="Advance"','left');

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
        $this->_get_datatables_query();
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

    public function count_all() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('es.school_id',$school_id);
            } 
        }
        $this->db->select('es.*');
        $this->db->select('i.invoice_id');
        $this->db->from($this->_table.' as es');
        $this->db->where('es.counselling','0');
        $this->db->join('invoice AS i','es.student_id=i.student_id AND i.title="Advance"','left');
        return $this->db->count_all_results();
    }
      private function _get_datatables_query_student_overview() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->from($this->_table);
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

    function get_datatables_student_overview() {
        $this->_get_datatables_query_student_overview();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_student_overview() {
        $this->_get_datatables_query_student_overview();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_student_overview() {
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

}