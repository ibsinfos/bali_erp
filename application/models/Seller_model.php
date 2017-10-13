<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class Seller_model extends CI_Model
    {

        function __construct()
        {
            parent::__construct();
        }

    public function get_category($categories_name)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->get_where('categories', array('categories_name' => $categories_name))->row()->categories_id;
    }     
    
    public function add($data){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
            } 
        }
       $this->db->insert('seller_master', $data);
       return $this->db->insert_id();
    }
    
    public function get_seller_name($seller_name)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
       return $this->db->get_where('seller_master', array('seller_name' => $seller_name))->row()->seller_id;
    }
    
    public function get_By_Id($id){    
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $query = $this->db->get_where('seller_master',array('seller_id'=>$id));
        return $query->row_array();
    }
    
    public function get_all(){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->order_by("seller_id", "desc"); 
        $query = $this->db->get('seller_master');
        
        return $query->result_array();
    }
    
    public function deletebyId($dataArray){
        $this->db->where($dataArray);
        $this->db->delete('seller_master');
        return true;
    }
    public function updatebyId($dataArray, $seller_id){
        $this->db->where($seller_id);
        $this->db->update('seller_master', $dataArray);
        return true;
    }
    
    public function get_count_product($seller_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql="SELECT count(*)as count,s.seller_id as seller FROM `product`p join seller_master s on(p.seller_id=s.seller_id) where s.seller_id='".$seller_id."' AND s.school_id = '".$school_id."'";
            } 
        } else {
            $sql="SELECT count(*)as count,s.seller_id as seller FROM `product`p join seller_master s on(p.seller_id=s.seller_id) where s.seller_id=$seller_id";
        }
        $rs = $this->db->query($sql)->result_array();
        return $rs;
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
            $rs = $this->db->get('seller_master')->result();
        } else {
            $rs = $this->db->get('seller_master')->result_array();
        }

        return $rs;
    }
}