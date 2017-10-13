<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mess_timetable_model extends CI_Model {

    private $_table = 'mess_time_table';
    
    function __construct() {
        parent::__construct();
    }
    function save_mess_timetable_details($data){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
            } 
        }
        $this->db->insert($this->_table, $data);
        $id = $this->db->insert_id();
        return $id;
    }
    
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
    public function get_details_ById($id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql="SELECT mess_time_table.*,mess_management.name FROM mess_time_table as mess_time_table left join mess_management as mess_management on(mess_time_table.mess_management_id=mess_management.mess_management_id) WHERE mess_time_table.mess_time_table_id='".$id."' AND mess_time_table.school_id = '".$school_id."'";
            } 
        } else {
            $sql="SELECT mess_time_table.*,mess_management.name FROM mess_time_table as mess_time_table left join mess_management as mess_management on(mess_time_table.mess_management_id=mess_management.mess_management_id)  WHERE mess_time_table.mess_time_table_id='".$id."'";
        }
        
        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }
    public function update($dataArray, $id) {
        $this->db->where('mess_time_table_id',$id);
        $this->db->update($this->_table, $dataArray);
        return true;
    }
}
