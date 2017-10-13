<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dynamic_group_model extends CI_Model {

    private $_table = "dynamic_group";
    private $_table_dynamic_form = "dynamic_form";
 
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
    function get_group_array($dataArray = "") {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        }
        $return = array();
        $this->db->select("g.*,f.name as form_name,f.id as form_id");
        $this->db->from($this->_table.' as g');
        $this->db->join($this->_table_dynamic_form.' as f','f.id=g.form_id','left');
        $this->db->order_by("g.id", "asc");

        if (!empty($dataArray)) {
            $this->db->where($dataArray);
        }       
        return $this->db->get()->result_array();
    }    
     function delete_group($where){
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
    function update_group($dataArray, $condition){
        $this->db->where($condition);
        $this->db->update($this->_table, $dataArray);
    }
     function update_status($dataArray, $condition){
        $this->db->where($condition);
        $this->db->update($this->_table, $dataArray);
    }
    function get_groupname_array(){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        }
        $return = array();
        $this->db->select("id,name");
        $this->db->from($this->_table);
        $this->db->order_by("name", "asc");
         if (!empty($dataArray)) {
            $this->db->where($dataArray);
        }       
        return $this->db->get()->result_array();
    }
    
}