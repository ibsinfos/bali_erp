<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');
    
    class Link_model extends CI_Model{
        private $_table = "links";
        
        function __construct(){
            parent::__construct();
        }
        
        public function add($dataArr){
            $this->db->insert($this->_table, $dataArr);
            return $this->db->insert_id();
        }
        
        public function get_link_array($dataArray = ""){
            $this->db->select("*");
            $this->db->from($this->_table);
            $this->db->order_by("id", "desc");
            if(!empty($dataArray)){
                $this->db->where($dataArray);
            }
            return $this->db->get()->result_array();
        }
        
        public function delete_link($dataArray){
            $this->db->where($dataArray);
            $this->db->delete($this->_table);
        }
        
        public function update_link($dataArray, $condition) {
            $this->db->where($condition);
            $this->db->update($this->_table, $dataArray);
            return true;
        }
    }
?>