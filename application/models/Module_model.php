<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');
    
    class Module_model extends CI_Model{
        private $_table = "modules";
        
        function __construct(){
            parent::__construct();
        }
        
        public function add($dataArr){
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
        
        public function get_module_array($dataArray = ""){
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                    $this->db->where('school_id',$school_id);
                } 
            }
            $this->db->select("*");
            $this->db->from($this->_table);
            $this->db->order_by("id", "desc");
            if(!empty($dataArray)){
                $this->db->where($dataArray);
            }
            return $this->db->get()->result_array();
        }
        
        public function delete_module($dataArray){
            $this->db->where($dataArray);
            $this->db->delete($this->_table);
        }
        
        public function update_module($dataArray, $condition) {
        $this->db->where($condition);
        $this->db->update($this->_table, $dataArray);
        return true;
    }
    }
?>