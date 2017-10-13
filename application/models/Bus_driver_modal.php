<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bus_driver_modal extends CI_Model {
    private $_table="bus_driver";
    
      var $column_order = array(null, 'b.name', 'bd.email', 'bd.phone', 'bd.sex', 'b.name', 't.route_name'); //set column field database for datatable orderable
    var $column_search = array('b.name', 'bd.email', 'bd.phone', 'bd.sex', 'b.name', 't.route_name'); //set column field database for datatable searchable 
    var $order = array('bd.bus_driver_id' => 'desc'); // default order 
    
    public function __construct() {
        parent::__construct();
    }
    
    /* BUS */
    public function get_bus_with_route() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('b.school_id',$school_id);
            } 
        }
        $this->db->select('*');
        $this->db->from('bus b'); 
        $this->db->join('transport t', 't.transport_id = b.route_id', 'left');    
        return $this->db->get()->result_array();
    }
    
    public function get_route() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->select('*');
        $this->db->from('transport');
        $this->db->where('transport_id NOT IN (select route_id from bus)');
        return $this->db->get()->result_array();
    }
    
    function get_all_routes(){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->get('transport')->result_array(); 
    }


    public function save_bus($data) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
            } 
        }
        $this->db->insert('bus', $data);
        return $this->db->insert_id();
    }
    
    public function get_bus($id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->get_where('bus', array('bus_id' => $id))->row();
    }
    
    public function update_bus($data, $param2) {
        $this->db->where('bus_id', $param2);
        $this->db->update('bus', $data); 

    }
    
    public function delete_bus($data) {
        $this->db->where($data);
        $this->db->delete('bus');
    }
    
    /* BUS ADMINISTRATOR */
    public function get_bus_admins() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return  $this->db->order_by('bus_administrator_id','desc')->get('bus_administrator')->result_array();
    }
    
    public function save_bus_admin($data) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
            } 
        }
        $this->db->insert('bus_administrator', $data);
    }
    
    public function update_bus_admin($data, $param2) {
        $this->db->where('bus_administrator_id', $param2);
        $this->db->update('bus_administrator', $data); 
    }
    
    public function delete_bus_admin($data) {
        $this->db->where($data);
        $this->db->delete('bus_administrator');
    }
    
    public function list_drivers() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $list = $this->db->get_where('bus_administrator', array('bus_administrator_id' => $this->session->userdata('login_user_id')))->row()->bus_driver_list;
        $this->db->select('*');
        $this->db->from('bus_driver');
        $this->db->where("bus_driver_id IN ($list)");
        return $this->db->get()->result_array();
    }
    
    public function get_num_of_groups($driver_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $bus_id = $this->db->get_where('bus_driver', array('bus_driver_id' => $driver_id))->row()->bus_id;
        $route_id = $this->db->get_where('bus', array('bus_id' => $bus_id))->row()->route_id;
        return $this->db->get_where('transport', array('transport_id' => $route_id))->row()->number_of_groups;
    }
    
    public function get_driver_attendence_morning($driver_id, $date) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->where(array('driver_id' => $driver_id, 'session' => 0));
        $this->db->like('date', $date, 'both'); 
        return $this->db->get('bus_driver_attendence')->result_array();
    }
    
    public function get_driver_attendence_evening($driver_id, $date) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->where(array('driver_id' => $driver_id, 'session' => 1));
        $this->db->like('date', $date, 'both');  
        return $this->db->get('bus_driver_attendence')->result_array();
    }
    
    /* BUS DRIVER */
    public function get_bus_for_driver($driver_id='') {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('bd.school_id',$school_id);
            } 
        }
        $this->db->select('bd.bus_driver_id, b.bus_id, b.name as bus_name' );
        $this->db->from('bus_driver as bd');
        $this->db->join('bus as b', 'bd.bus_id = b.bus_id');
        $this->db->where('bd.bus_driver_id', $driver_id);
        $rs = $this->db->get()->result_array(); 
        return $rs;
    }
      public function get_bus_for_add_driver() {
          $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->select('*');
        $this->db->from('bus');
        $this->db->where('bus_id NOT IN (select bus_id from bus_driver)');
        return $this->db->get()->result_array();
    }
    
    public function get_bus_drivers() {
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
        return $this->db->get()->result_array();
    }
    
    public function get_bus_driver($id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->get_where('bus_driver', array('bus_driver_id' => $id))->row();
    }
    
    public function save_bus_driver($data) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
            } 
        }
        $this->db->insert('bus_driver', $data);
    }
    
    public function update_bus_driver($data, $param2) {
        $this->db->where('bus_driver_id',$param2);
        $this->db->update('bus_driver', $data);
    }
    
    public function delete_bus_driver($data) {
        $this->db->where($data);
        $this->db->delete('bus_driver');
    }
    
    public function get_driver_bus_and_route($id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('b.school_id',$school_id);
            } 
        }
        $this->db->select('*');
        $this->db->from('bus b'); 
        $this->db->join('transport t', 't.transport_id = b.route_id', 'left');
        $this->db->where('b.bus_id', $id);
        return $this->db->get()->row();
    }
    
    public function get_student_route_num($id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->get_where('student', array('transport_id' => $id))->num_rows();
    }
  
    public function get_students_under_route($id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('s.school_id',$school_id);
            } 
        }
        $this->db->select('*, s.name name_student, p.father_name name_parent, p.cell_phone phone_parent, s.location location_student');
        $this->db->from('student s'); 
        $this->db->join('parent p', 'p.parent_id = s.parent_id', 'left');
        $this->db->join('transport t', 't.transport_id = s.transport_id', 'left');
        $this->db->where(array('s.transport_id' => $id));       
        return $this->db->get()->result_array();
    }
    
    public function get_student_under_route($id, $grp_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('s.school_id',$school_id);
            } 
        }
        $this->db->select('*, s.name name_student, p.father_name name_parent, p.cell_phone phone_parent, s.location location_student');
        $this->db->from('student s'); 
        $this->db->join('parent p', 'p.parent_id = s.parent_id', 'left');
        $this->db->join('transport t', 't.transport_id = s.transport_id', 'left');
        $this->db->where(array('s.transport_id' => $id, 'transport_group' => $grp_id));       
        return $this->db->get()->result_array();
    }
    
//    public function get_route_group($route_id) {
//        return $this->db->get_where('transport', array('transport_id' => $route_id))->row()->number_of_groups;
//    }
    
    public function start_trip($id, $grp_id, $route_id, $bus_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
            } 
        }
        $session = (date('A') == 'AM')? '0' : '1';
        $data = array('driver_id' => $id, 'route_id' => $route_id, 'route_group' => $grp_id, 'bus_id' => $bus_id, 'timestamp' => time(), 'session' => $session, 'date' => date('d/m/y'));
        $this->db->insert('bus_driver_attendence', $data);
        return true;
    }
    public function get_bus_details($dataArray='',$col=''){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $return="";
        $row=$this->db->get_where('bus',$dataArray)->row();
        if($col!='')
        {
            $return =$row->$col;
        }
        else
            $return=$row;  
        return $return;
    }

    public function mark_attendence($dataArray)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $attendence=$this->db->get_where('bus_attendence',$dataArray)->row();
        $attendence_id=$attendence->bus_attendence_id;
        $bus_in=$attendence->bus_in;
        if($bus_in==0)
        {
            $dataArray['bus_in']=1;
            $dataArray['bus_out']=0;
            $dataArray['in_timestamp']= strtotime(date('Y-m-d H:i:s'));
            $this->db->insert('bus_attendence', $dataArray);
        }
        else
        {
            $dataArray['bus_out']=1;
            $dataArray['out_timestamp']= strtotime(date('Y-m-d H:i:s'));
            $this->db->where('bus_attendence_id', $attendence_id);
            $this->db->update('bus_attendence', $dataArray);
            
        }
    }
    
    public function get_attendence_details($dataArray,$col='')
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $return="";
        $row=$this->db->get_where('bus_attendence',$dataArray)->row();
        if($col!='')
        {
           $return= $row->$col;
        }
         else
        {
             $return=$row;
        }
        return $return;
    }

    public function register_student_attendence($student_id, $entry, $grp_id, $route_id, $bus_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
            } 
        }
        $session = (date('A') == 'AM')? '0' : '1';
        if($entry == 'in') {
            $data = array('student_id' => $student_id, 'bus_id' => $bus_id, 'route_id' => $route_id, 'transport_group' => $grp_id, 'timestamp' => time(), 'session' => $session, 'bus_in' => 1, 'date' => date('d/m/y'));
            $this->db->insert('bus_attendence', $data);
        } else {
            $this->db->where(array('student_id' => $student_id, 'date' => date('d/m/y'), 'session' => $session));
            $this->db->update('bus_attendence', array('bus_out' => 1)); 
        }
        return true;
    }
    
    public function get_attendence_in() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $session = (date('A') == 'AM')? '0' : '1'; 
        $data = $this->db->get_where('bus_attendence', array('bus_in' => 1, 'date' => date('d/m/y'), 'session' => $session))->result_array();
        foreach($data as $d) {
            $id[] = $d['student_id'];
        }
        return $id;
    }
    
    public function get_attendence_out() { 
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $session = (date('A') == 'AM')? '0' : '1';
        $data = $this->db->get_where('bus_attendence', array('bus_out' => 1, 'date' => date('d/m/y'), 'session' => $session))->result_array();
        foreach($data as $d) {
            $id[] = $d['student_id'];
        }
        return $id;
    }
    
    public function check_driver_trip_session($id, $grp_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $session = (date('A') == 'AM')? '0' : '1';
        return $this->db->get_where('bus_driver_attendence', array('driver_id' => $id, 'date' => date('d/m/y'), 'session' => $session, 'route_group' => $grp_id))->num_rows();
    }
    
    public function check_student_attendence() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $session = (date('A') == 'AM')? '0' : '1'; 
        if($session == 1) {
            $data = $this->db->get_where('bus_attendence', array('date' => date('d/m/y'), 'session' => 0))->result_array();
            foreach($data as $d) {
                $id[] = $d['student_id'];
            }
            return $id;
        } else {
            return array();
        }
    }
    
    public function update_do_upload() {
        $this->db->where('bus_driver_id', $this->session->userdata('login_user_id'));
        $this->db->update('bus_driver', array('do_upload' => 1));
    }
    
    public function check_do_upload() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->get_where('bus_driver', array('bus_driver_id' => $this->session->userdata('login_user_id')))->row()->do_upload;
    }
    
    public function update_admin_approve() {
        $this->db->where('bus_driver_id', $this->session->userdata('login_user_id'));
        $this->db->update('bus_driver', array('admin_approve' => 1));
    }
    
    public function check_admin_approve() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->get_where('bus_driver', array('bus_driver_id' => $this->session->userdata('login_user_id')))->row()->admin_approve;
    }
    
    public function upload_images($id, $route_id, $grp_id, $bus_id, $file_str) {
        $session = (date('A') == 'AM')? '0' : '1';
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->insert('bus_images', array('driver_id' => $id, 'route_id' => $route_id, 'route_group' => $grp_id, 'bus_id' => $bus_id, 'session' => $session, 'date' => date('d/m/y'), 'year' => '', 'timestamp' => time(), 'bus_admin_id' => '', 'images' => $file_str, 'school_id' => $school_id));
            } 
        } else {
            $this->db->insert('bus_images', array('driver_id' => $id, 'route_id' => $route_id, 'route_group' => $grp_id, 'bus_id' => $bus_id, 'session' => $session, 'date' => date('d/m/y'), 'year' => '', 'timestamp' => time(), 'bus_admin_id' => '', 'images' => $file_str));
        }
    }
    
    public function trip_complete() {
        $this->db->where('bus_driver_id', $this->session->userdata('login_user_id'));
        $this->db->update('bus_driver', array('admin_approve' => 0, 'do_upload' => 0));
    }
    
    public function update_profile_info($id, $data) {
        $this->db->where('bus_driver_id', $id);
        $this->db->update('bus_driver', $data);
    }
    
    public function update_driver_password($id, $new_pass) {
        $this->db->where('bus_driver_id', $id);
        $this->db->update('bus_driver', $new_pass);
    }
    
    public function update_no_of_buses($transport_id, $count) { 
        $this->db->where('transport_id', $transport_id);
        $this->db->update('transport', array('number_of_vehicle' => $count)); 
        return true; 
        
    }
    function get_student_list($id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('s.school_id',$school_id);
            } 
        }
      $this->db->select('t.transport_id ,s.student_id,s.name name_student, p.father_name name_parent, p.cell_phone phone_parent, s.location location_student');
        $this->db->from('student s'); 
        $this->db->join('parent p', 'p.parent_id = s.parent_id', 'left');
        $this->db->join('transport t', 't.transport_id = s.transport_id', 'left');
        $this->db->where(array('s.transport_id' => $id, 'transport_group' => $grp_id));       
        return $this->db->get()->result_array();  
    }
    
    public function get_bus_with_route1() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('b.school_id',$school_id);
            } 
        }
        $this->db->select('t.route_name,b.*');
        $this->db->from('bus b'); 
        $this->db->order_by('b.bus_id','desc'); 
        $this->db->join('transport t', 't.transport_id = b.route_id', 'left');    
        return $this->db->get()->result_array();
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
    
    // GET DATATABLE 
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
    
  
}
