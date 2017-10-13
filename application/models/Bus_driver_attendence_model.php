<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bus_driver_attendence_model extends CI_Model {
    private $_table="bus_driver_attendence";    
//    var $column_order = array(null, 'b.name', 'bd.email', 'bd.phone', 'bd.sex', 'b.name', 't.route_name'); //set column field database for datatable orderable
//    var $column_search = array('b.name', 'bd.email', 'bd.phone', 'bd.sex', 'b.name', 't.route_name'); //set column field database for datatable searchable 
//    var $order = array('bd.bus_driver_id' => 'asc'); // default order 
//    
    public function __construct() {
        parent::__construct();
    }
    
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
    // GET DATATABLE QUERY
    private function _get_datatables_query() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('bd.school_id',$school_id);
            } 
        }
        $this->db->select('*, b.name bus_name, bd.name bus_driver_name');
        $this->db->from('bus_driver bd');
        $this->db->join('bus b', 'b.bus_id = bd.bus_id', 'left');
        $this->db->join('transport t', 't.transport_id = b.route_id', 'left');
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
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->from('bus_driver');
        return $this->db->count_all_results();
    }
    
    function attendence_add($dataArr){    
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
    
    public function getstudents_attendence($bus_id, $running_year, $timestamp) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('attn.school_id',$school_id);
            } 
        }
        $this->db->select('attn.bus_attendence_id as bus_attn_id, attn.student_id, attn.attendance_status, stu.student_id, '
                . 'stu.name AS student_name, stu.lname as lname, b.bus_id, b.name as bus_name,'
                . 'cls.name as class_name, cls.class_id, sec.name as section_name, sec.section_id');
        $this->db->from('bus_driver_attendence as attn');
        $this->db->join('enroll as en', 'attn.student_id = en.student_id');
        $this->db->join('student as stu',  'en.student_id  =   stu.student_id');
        $this->db->join('bus as b',  'b.bus_id  =   attn.bus_id');
        $this->db->join('class as cls', 'cls.class_id = attn.class_id');
        $this->db->join('section as sec', 'sec.section_id = attn.section_id');
        $this->db->where('attn.bus_id',$bus_id)->where('en.year', $running_year)->where('stu.isActive', '1')->where('stu.student_status', '1');
        $rs     =       $this->db->where("attn.timestamp",$timestamp)->get()->result_array();
        return $rs;        
    }
    
    function attendence_update($id, $dataArr){
        $this->db->where('bus_attendence_id', $id);
        $this->db->update($this->_table, $dataArr);
    }
   
}

