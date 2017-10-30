<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Hostel_registration_model extends CI_Model {

    private $_table = "hostel_registration";

      var $column_order = array(null, 'd.name', 's.name', 'hr.hostel_type', 'hr.floor_name', 'hr.room_no', 'hr.food', 'hr.register_date', 'hr.vacating_date', 'hr.transfer_date', 'hr.status', 'c.name', 'sec.name' ); //set column field database for datatable orderable
    var $column_search = array('d.name', 's.name', 'hr.hostel_type', 'hr.floor_name', 'hr.room_no', 'hr.food', 'hr.register_date', 'hr.vacating_date', 'hr.transfer_date', 'hr.status', 'c.name', 'sec.name'); //set column field database for datatable searchable 
    var $order = array('hr.hostel_reg_id' => 'asc'); // default order 
    

    function __construct() {
        parent::__construct();
    }

    public function add($data) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
            } 
        }
		
        $sql = $this->db->insert($this->_table, $data);
		
        return $sql;
    }
    public function update($data, $hostel_reg_id){
    $this->db->where('hostel_reg_id',$hostel_reg_id);
    $this->db->update($this->_table, $data);
    return true;
    }
     public function update_status($hostel_reg_id,$data){
        $this->db->where('hostel_reg_id',$hostel_reg_id);
        $this->db->set($data);
        $this->db->update($this->_table);
    }
    public function get_hostel_students($type,$floor_name,$hostel_id,$room_no){
        $school_id = ''; $where = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $where = " and hr.school_id = '".$school_id."'";
            } 
        }
        $sql="SELECT DISTINCT(hr.student_id),s.name FROM hostel_registration hr join student s on(s.student_id=hr.student_id) WHERE hr.hostel_type='".$type."' and hr.hostel_id='".$hostel_id."' and hr.floor_name='".$floor_name."' and hr.room_no='".$room_no."'".$where;
        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }
	
	
	
    function get_available_students($class_id, $section_id,$year) {
        $school_id = ''; $where = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $where = " and s.school_id = '".$school_id."'";
            } 
        }
        $sql = 'select s.name,s.student_id, e.enroll_code from student s , enroll e LEFT JOIN hostel_registration t2 ON t2.student_id = e.student_id WHERE t2.student_id IS NULL and e.class_id="' . $class_id . '" and e.section_id="' . $section_id . '"and e.year="' . $year . '" and s.student_id=e.student_id'.$where;
		
		
        $rs = $this->db->query($sql)->result();
		
		
		return $rs;
	 }
	 
	 
    public function get_student_info_parents($student_id){
        $school_id = ''; $where = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $where = " and hr.school_id = '".$school_id."'";
            } 
        }
        $sql    =   "SELECT hr.*,s.*,d.name as hostel_name FROM hostel_registration hr join student s on(hr.student_id=s.student_id) join dormitory d on(d.dormitory_id=hr.hostel_id) where hr.student_id=$student_id ".$where." ORDER BY hr.create_date DESC" ;
        $rs     =   $this->db->query($sql)->result_array();
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
        
        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('hr.school_id',$school_id);
            } 
        }
        $this->db->select('*,hr.room_no room_detail, s.name student_name, d.name hostel_name, hr.status, c.name class_name, sec.name section_name');
        $this->db->from('hostel_registration hr');
        $this->db->join('student s', 's.student_id = hr.student_id', 'left');
        $this->db->join('enroll e', 'e.student_id = hr.student_id', 'left');
        $this->db->join('class c', 'c.class_id = e.class_id', 'left');
        $this->db->join('section sec', 'sec.section_id = e.section_id', 'left');
        $this->db->join('dormitory d', 'd.dormitory_id = hr.hostel_id', 'left');
        $this->db->where('e.year',$running_year );
        $this->db->where('s.student_status','1' );
        $this->db->order_by('hr.create_date','desc');
        
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
		
		//echo $this->db->last_query();
		
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
        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('hr.school_id',$school_id);
            } 
        }
        $this->db->select('*, s.name student_name, d.name hostel_name, hr.status, c.name class_name, sec.name section_name');
        $this->db->from('hostel_registration hr');
        $this->db->join('student s', 's.student_id = hr.student_id', 'left');
        $this->db->join('enroll e', 'e.student_id = hr.student_id', 'left');
        $this->db->join('class c', 'c.class_id = e.class_id', 'left');
        $this->db->join('section sec', 'sec.section_id = e.section_id', 'left');
        $this->db->join('dormitory d', 'd.dormitory_id = hr.hostel_id', 'left');
        $this->db->where('e.year',$running_year );
        $this->db->where('s.student_status','1' );
        $this->db->order_by('hr.create_date','desc');
        
        return $this->db->count_all_results();
    }
    
}