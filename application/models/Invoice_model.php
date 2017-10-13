<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Invoice_model extends CI_Model {

    private $_table = "invoice";
    public $_fms_dbname     =   '_fi';

    function __construct() {
        parent::__construct();
    }


    function get_invoice_by_id($id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->get_where('invoice' , array('invoice_id' => $id) )->result_array();
    }


    function add_fees_type($student_id, $fees_type) {
        $this->db->where($student_id);
        $sql = $this->db->update($this->_table, $fees_type);
        return $sql;
    }

    public function update_invoice_amount($param2, $amount_paid)
    {
        $this->db->where('invoice_id', $param2);
        $this->db->set('amount_paid', 'amount_paid + ' . $amount_paid, FALSE);
        $this->db->set('due', 'due - ' . $amount_paid, FALSE);
        $this->db->update($this->_table);
    }

    function get_typeById($student_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->select('fees_type');
        $query = $this->db->get_where($this->_table, $student_id)->row()->fees_type;
        return $query;
    }

    public function delete_invoice($id)
    {
        $this->db->where('invoice_id', $id);
        $this->db->delete($this->_table);
    }

    public function update_invoice($id, $data)
    {
        $this->db->where('invoice_id', $id);
        $this->db->update($this->_table, $data);   
    }
    public function update_status($id, $status)
    {
        $this->db->where('invoice_id', $param2);
        $this->db->update($this->_table, array('status' => $status));
    }

    public function add($data) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
            } 
        }
        $this->db->insert($this->_table, $data);
        $invoice_id = $this->db->insert_id();  
        return $invoice_id;
    }
    
    public function get_all_invoice() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('inv.school_id',$school_id);
            } 
        }
        $this->db->select( 'inv.* , std.name as student_name , std.mname as student_mname , std.lname as student_lname ');
        $this->db->from( $this->_table.' as inv' );
        $this->db->join( 'student as std' , 'inv.student_id = std.student_id' );
        $this->db->order_by('creation_timestamp', 'desc');
        return $result      =   $this->db->get()->result_array();
    }
    
    public function get_all_student_finance_transaction() {
        $instance       =   $this->get_instance_name();
        $finance_db     =   strtolower($instance.$this->_fms_dbname);
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql    =   "SELECT * FROM $finance_db.sys_transactions WHERE (payerid != 0 OR payeeid != 0) AND school_id = '".$school_id."' ";
            } 
        } else {
            $sql            =   "SELECT * FROM $finance_db.sys_transactions WHERE payerid != 0 OR payeeid != 0 ";
        }
        $query          =   $this->db->query($sql);
        return $result         =   $query->result_array();
    }
    
    /*
     * 
     */
    public function get_student_invoice( $student_id ) {
        $instance       =   $this->get_instance_name();
        $finance_db     =   strtolower($instance.$this->_fms_dbname);
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql            =   "SELECT * FROM $finance_db.sys_invoices WHERE userid = $student_id And school_id = '".$school_id."'";
            } 
        } else {
            $sql            =   "SELECT * FROM $finance_db.sys_invoices WHERE userid = $student_id ";
        }
        $query          =   $this->db->query($sql);
        return $result         =   $query->result_array();
    }
    
    public function get_finance_invoice_by_id( $invoice_id ) {
        $instance       =   $this->get_instance_name();
        $finance_db     =   strtolower($instance.$this->_fms_dbname);
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql  =   "SELECT * FROM $finance_db.sys_invoices WHERE id = '".$invoice_id."' AND school_id = '".$school_id."' ";
            } 
        } else {
            $sql =   "SELECT * FROM $finance_db.sys_invoices WHERE id = $invoice_id ";
        }
        
        $query          =   $this->db->query($sql);
        return $result         =   $query->result_array();
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

    public function get_student_invoice_details($student_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $result = $this->db->get_where('invoice', array('student_id'=>$student_id))->row();
        return $result;
    }
    
    public function count_scholarship_students() {
        $this->db->from('crm_accounts as account');
        $this->db->join( 'sys_invoices as invoice' , 'account.id = invoice.userid','LEFT');
        $this->db->join( 'sys_scholarship as scholarship' , 'invoice.scholarship_id = scholarship.id','LEFT');
        $this->db->where("invoice.scholarship_id!='0'");

        return $this->db->count_all_results();
    }
}
