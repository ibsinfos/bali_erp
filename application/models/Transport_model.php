<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transport_model extends CI_Model {
    private $_table="transport";
    
    var $column_order = array(null, 'route_name', 'number_of_vehicle', 'description', 'route_fare'); //set column field database for datatable orderable
    var $column_search = array('route_name', 'number_of_vehicle', 'description', 'route_fare'); //set column field database for datatable searchable 
    var $order = array('transport_id' => 'asc'); // default order 

    function __construct() {
        parent::__construct();
    }

    public function get_transport_array() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        }
        $transport_array = $this->db->get('transport')->result_array();
        return $transport_array;
    }

    public function add_student($data) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
            } 
        }
        $sql = $this->db->insert('student_bus_allocation', $data);
        return $sql;
    }

    public function delete($param2)
    {
        $this->db->where('transport_id', $param2);
        $this->db->delete($this->_table);
    }


    public function update($param2, $data)
    {
        $this->db->where('transport_id', $param2);
        $this->db->update('transport', $data);
    }

    public function get_name($param)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        }
       $rs=$this->db->from($this->_table)->like('route_name',trim($param))->get()->result();
       //echo $this->db->last_query().'<br>';
       return $rs;
    }

    public function get_list_of_students($transport_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $year=$this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
        $this->db->select('sta.*, en.*, cls.name as cls_name, sec.name as section, std.name as student_name,std.phone'); // Select field
        $this->db->from('student_bus_allocation as sta'); // from Table1
        $this->db->join('enroll as en', 'sta.student_id = en.student_id','left');
        $this->db->join('class AS cls', 'en.class_id = cls.class_id','left');
        $this->db->join('section AS sec', 'en.section_id = sec.section_id','left');
        $this->db->join('student AS std', 'std.student_id = sta.student_id','left');
        $this->db->where('en.year', $year);
        $this->db->where('sta.route_id', $transport_id);
        $res = $this->db->get()->result_array();
        return $res;
    }

    public function get_ajax_route_name($bus_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql = "SELECT t.* FROM transport t join bus b on(b.route_id=t.transport_id) where b.bus_id='".$bus_id."' AND b.school_id = '".$school_id."'";
            } 
        } else {
            $sql = "SELECT t.* FROM transport t join bus b on(b.route_id=t.transport_id) where b.bus_id=$bus_id";
        }
        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }

    public function get_ajax_bus_driver_name($bus_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql = "SELECT bd.* FROM bus_driver bd join bus b on(bd.bus_id=b.bus_id) where b.bus_id='".$bus_id."' AND b.school_id = '".$school_id."'";
            } 
        } else {
            $sql = "SELECT bd.* FROM bus_driver bd join bus b on(bd.bus_id=b.bus_id) where b.bus_id=$bus_id";
        }
        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }

    public function add($data) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
            } 
        }
        $this->db->insert('transport', $data);
        generate_log($this->db->last_query());
        $route_id = $this->db->insert_id();
        return $route_id;
    }

    public function get_transport_details($student_id = ''){
        if($student_id!=''){
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                    $this->db->where('sba.school_id',$school_id);
                } 
            }
            $this->db->select('rbs.route_from, rbs.route_to,b.name bus_name, b.bus_unique_key, bd.name bus_driver_name,bd.phone'); // Select field
            $this->db->from('student_bus_allocation sba'); // from Table1
            $this->db->where('sba.student_id',$student_id);
            $this->db->join('route_bus_stop rbs','rbs.route_bus_stop_id = sba.bus_stop_id','left'); 
            $this->db->join('bus b', 'b.bus_id = sba.bus_id','left');           
            $this->db->join('bus_driver bd', 'bd.bus_id = sba.bus_id','left');  
            return $this->db->get()->result_array();
//            echo $this->db->last_query(); die;
            }else{
            return array();
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
    
    //TRANSPORT DATATABLE LIST
    private function _get_datatables_query() {
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
    
     public function count_all(){
        $this->db->from($this->_table);
        return $this->db->count_all_results();
    }
    
    function get_route_fare($fee_type, $year, $name){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql="SELECT * FROM sys_items WHERE fee_type='".$fee_type."' AND academic_year='".$year."' AND name='".trim($name)."' AND school_id = '".$school_id."'";
            } 
        } else {
            $sql="SELECT * FROM sys_items WHERE fee_type='".$fee_type."' AND academic_year='".$year."' AND name='".trim($name)."'";
        }
        return $this->db->query($sql)->result();
    }

}
