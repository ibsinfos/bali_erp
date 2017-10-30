<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Hostel_room_model extends CI_Model {

    private $_table = "hostel_room";

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
        $this->db->insert($this->_table, $data);
        generate_log($this->db->last_query());
        $hostel_room_id = $this->db->insert_id();
        return $hostel_room_id;
    }

    public function update_available($data) {
        $this->db->where($data);
        $this->db->set('available_beds', 'available_beds-1', FALSE);
        $this->db->set('occupied_beds', 'occupied_beds+1', FALSE);
        $this->db->update($this->_table);
    }

    public function update_occupied($room_no) {
        $this->db->where('room_number', $room_no);
        $this->db->set('available_beds', 'available_beds+1', FALSE);
        $this->db->set('occupied_beds', 'occupied_beds-1', FALSE);
        $this->db->update($this->_table);
    }

    public function get_occupied_beds($dormitory_id) {
        $school_id = ''; $where = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $where = " and hr.school_id = '".$school_id."'";
            } 
        }
        $sql = "select count(hr.occupied_beds)as occupied  from hostel_room hr JOIN dormitory d on(hr.hostel_id=d.dormitory_id) where hr.occupied_beds = hr.no_of_beds and d.dormitory_id='".$dormitory_id."'".$where;
        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }

    public function get_available_beds($dormitory_id) {
        $school_id = ''; $where = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $where = " and hr.school_id = '".$school_id."'";
            } 
        }
        $sql = "select count(hr.occupied_beds)as available  from hostel_room hr JOIN dormitory d on(hr.hostel_id=d.dormitory_id) where hr.occupied_beds != hr.no_of_beds and d.dormitory_id= $dormitory_id".$where;
        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }

    public function get_no_of_rooms($dormitory_id) {
        $school_id = ''; $where = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $where = " and hr.school_id = '".$school_id."'";
            } 
        }
        $sql = "select count(hr.room_number)as no_of_rooms  from hostel_room hr JOIN dormitory d on(hr.hostel_id=d.dormitory_id) where d.dormitory_id= $dormitory_id".$where;
        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }

    public function update_hostel_room($hostel_room_id, $dataArray) {
        $this->db->where(array('hostel_room_id' => $hostel_room_id));
        $this->db->update($this->_table, $dataArray);
        return true;
    }

    public function delete($data) {
        $this->db->where('hostel_room_id', $data);
        $this->db->delete($this->_table);
        return true;
    }
	
    public function get_count_of_students($dormitory_id = '') {
        $school_id = ''; $where = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $where = " AND school_id = '".$school_id."'";
            } 
        }
        $sql = "select SUM(occupied_beds)as occupied from hostel_room where hostel_id='".$dormitory_id."'".$where;
        $rs = $this->db->query($sql)->result_array();
       // echo $this->db->last_query();
        return $rs;
    }
    
    public function get_count_of_students_room($dormitory_id = '', $room_no = '') {
        $school_id = ''; $where = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $where = " AND school_id = '".$school_id."'";
            } 
        }
        $sql = "select SUM(occupied_beds)as occupied from hostel_room where hostel_id='$dormitory_id' "
                . "and room_number = '$room_no'".$where;
        return $this->db->query($sql)->row()->occupied;
       //echo $this->db->last_query();
       
        //return $rs;
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    function get_data_by_id($id, $returnColsStr = "") {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        if ($returnColsStr == "") {
            return $this->db->get_where($this->_table, array($this->_primary, $id))->result();
        } else {
            return $this->db->select($returnColsStr)->from($this->_table)->where($this->_primary, $id)->get()->result();
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
    function get_data_by_cols($columnName = "*", $conditionArr = array(), $return_type = "result", $sortByArr = array(), $limit = "") {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->select($columnName);
        $condition_type = 'and';
        if (array_key_exists('condition_type', $conditionArr)) {
            if ($conditionArr['condition_type'] != "") {
                $condition_type = $conditionArr['condition_type'];
            }
        }
        unset($conditionArr['condition_type']);
        $condition_in_data_arr = array();
        $startCounter = 0;
        $condition_in_column = "";
        foreach ($conditionArr AS $k => $v) {
            if ($condition_type == 'in') {
                if (array_key_exists('condition_in_data', $conditionArr)) {
                    $condition_in_data_arr = explode(',', $conditionArr['condition_in_data']);
                    $condition_in_column = $conditionArr['condition_in_col'];
                }
            } elseif ($condition_type == 'or') {
                if ($startCounter == 0) {
                    $this->db->where($k, $v);
                } else {
                    $this->db->or_where($k, $v);
                }
            } elseif ($condition_type == 'and') {
                $this->db->where($k, $v);
            }
            $startCounter++;
        }

        if ($condition_type == 'in') {
            if (!empty($condition_in_data_arr))
                $this->db->where_in($condition_in_column, $condition_in_data_arr);
        }

        if ($limit != "") {
            $this->db->limit($limit);
        }

        foreach ($sortByArr AS $key => $val) {
            $this->db->order_by($key, $val);
        }

        if ($return_type == 'result') {
            $rs = $this->db->get($this->_table)->result();
        } else {
            $rs = $this->db->get($this->_table)->result_array();
        }

        return $rs;
    }

}
