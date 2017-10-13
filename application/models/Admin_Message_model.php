<?php

if (!defined('BASEPATH'))
        exit('No direct script access allowed');

class Admin_Message_model extends CI_Model{
    private  $_table="admin_message";
    function __construct(){
        parent::__construct();
    }
    
    function add($dataArr){
        $school_id = $this->session->userdata['school_id'];
        if($school_id > 0){
            $dataArr['school_id'] = $school_id;
        }
        $this->db->insert($this->_table,$dataArr);
        //echo $this->db->last_query();
        return $this->db->insert_id();
    }
    
    function update($dataArr,$whereArr){
        foreach ($whereArr AS $k =>$v){
            $this->db->where($k,$v);
        }
        $this->db->update($this->_table,$dataArr);
        return TRUE;
    }
    
    function delete($id){
        $this->db->where('group_user_id',$id);
        $this->db->delete($this->_table);
        return TRUE;
    }
    
    function get_all_participent(){
      $sql="Select school_admin_id, Concat(first_name,last_name) as name from school_admin where status=1";
      $rs=$this->db->query($sql)->result();
      return $rs;
    }
    function delete_msg_thread($param2){
        $this->db->where('message_id',$param2);
        $msg_del = $this->db->delete($this->_table);
        return true;
    }
    function get_data_by_cols($columnName="*",$conditionArr=array(),$return_type="result",$sortByArr=array(),$limit=""){
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
        
        if(!empty($sortByArr)) {
            foreach($sortByArr AS $key=>$val){
                $this->db->order_by($key,$val);
            }
        }

        if($return_type=='result'){
            $rs=$this->db->get($this->_table)->result();
        }else{
            $rs=$this->db->get($this->_table)->result_array();
        }

        return $rs;
    }
}

