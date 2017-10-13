<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dynamic_filed_model extends CI_Model {

    private $_table = "dynamic_fields";
    private $_table_dynamic_group = "dynamic_group";
    
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
        $this->db->insert($this->_table, $dataArr);
        return $this->db->insert_id();
    }
    function get_fields_array() {    
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where($this->_table.'.school_id',$school_id);
            } 
        }
        $return = array();
        $this->db->select("dynamic_fields.*,dynamic_group.name");
        $this->db->from($this->_table);
        $this->db->join($this->_table_dynamic_group,'dynamic_fields.group_id = dynamic_group.id','left');
        return $this->db->get()->result_array();
    }    
     function delete_field($where){
            $this->db->where('id',$where);
            $this->db->delete($this->_table);
    }  
            
    function get_data_by_id($id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        }
       return $this->db->get_where($this->_table, array('id' => $id))->row();
    }
    function update_field($dataArray, $condition){
        $this->db->where($condition);
        $this->db->update($this->_table, $dataArray);
    } 
    function update_staus($dataArray, $condition){
        $this->db->where($condition);
        $this->db->update($this->_table, $dataArray);
    } 
    
    function get_table_field_array(){
        
    }
}