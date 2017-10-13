<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dynamic_report_model extends CI_Model {

    private $_table = "dynamic_report_name";
    private $_table_dynamic_reports = "dynamic_reports";
 
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
    
    function runDynamicQuery($query)
    {
        
         return $this->db->query($query)->result_array();
        // echo $this->db->last_query();
        
        
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
        $this->db->select("*");
        $this->db->from($this->_table);
        $this->db->order_by("id", "desc");

        if (!empty($dataArray)) {
            $this->db->where($dataArray);
        }       
        return $this->db->get()->result_array();
    } 
      function get_report($report_name_id='') {
        $return = array();
        $this->db->select("*");
        $this->db->from($this->_table_dynamic_reports);
        $this->db->where('report_id', $report_name_id);
        $this->db->order_by("id", "asc");
        if (!empty($dataArray)) {
            $this->db->where($dataArray);
        }       
        return $this->db->get()->result_array();
//    echo $this->db->last_query(); die;
        
        } 
    
     function delete_report_name($where){
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
    function update_report_name($dataArray, $condition){
        $this->db->where($condition);
        $this->db->update($this->_table, $dataArray);
    }
    function get_groupname_array()
    {
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
    
    function saveReport($dataArr)
    {
        $this->db->insert("dynamic_report_save", $dataArr);
        return $this->db->insert_id();
        
    }
    
    function getCustomReportLink($section_id)
    {
        
        $this->db->select("id,report_caption");
        $this->db->where('section_id',$section_id);
        $this->db->from("custom_reports");
        return $this->db->get()->result_array();
         
            
    }
    
    
    function checkCaptionExist($name)
    {
        if(isset($_SESSION['school_id']))
        {
            $this->db->where('school_id',  $_SESSION['school_id']);
        }    
        $this->db->select("*");
        $this->db->where('name',$name);
        $this->db->from("link_modules");
        return $this->db->get()->result_array();
    }
    function dynamicLinkSave($dataArr,$role_id, $type)
    {
        if(isset($_SESSION['school_id']))
        {
            $dataArr['school_id'] = $_SESSION['school_id'];
        }    
        $this->db->insert("link_modules", $dataArr);
        $insert_id =  $this->db->insert_id();
        $arrRole['role_id'] = $role_id;
        $arrRole['user_type'] = $type;
        $arrRole['link_id'] = $insert_id;
        $this->db->insert("role_link_transaction", $arrRole);
    }
    function getReportLink($name, $user_type)
    {
        $name = strtolower($name);
        $this->db->select("*");
        $this->db->where('name',$name);
        $this->db->where('user_type',$user_type);
        $this->db->from("link_modules");
        return $this->db->get()->result_array();
       
        
    }
    
    function getJoinField($dbArr = array())
    {
      
        $this->db->select('*');
        $this->db->from('dynamic_reports');
        
        $this->db->where_in('dynamic_reports.field', $dbArr);

        $result = $this->db->get()->result_array();
        $arrJoinTable = array();
        $arrJoinField = array();
        $arrJoinType = array();
        $arrComplexFields = array();
        $arrAll = array();
       
        if(count($result));
        {
            foreach($result as $row)
            {
               $field = $row['field'];
                foreach($row as $key => $value)
               {
                   if($key == "join_table")
                   {    
                       if(!empty($value))
                            $arrJoinTable[$field] = $value;
                   }
                   if($key == "join_field")
                   {    
                       if(!empty($value))
                            $arrJoinField[$field] = $value;
                   }
                   if($key == "join_type")
                   {    
                       if(!empty($value))
                            $arrJoinType[$field] = $value;
                   }
                   if($key == "complex_fields")
                   {    
                       if(!empty($value))
                            $arrComplexFields[$field] = $value;
                   }
                   
               }    
                
            }    
            //if(count($arrJoinTable))
            $arrAll['arrJoinTable'] = array_unique($arrJoinTable);
            $arrAll['arrJoinField'] = $arrJoinField;
            $arrAll['arrJoinType'] = $arrJoinType;
            $arrAll['arrComplexFields'] = $arrComplexFields;
        }
        return $arrAll;
        //echo $this->db->last_query();
        
    }
    
    function getFields($report_id)
    {
       
       $fields =  $this->db->get_where("custom_report_select", array("report_id" => $report_id))->result_array();
       return $fields; 
    }
    
    function getReport($id)
    {
       
        $row = $this->db->get_where("custom_reports", array("id" => $id))->row();
        return $row;
        
    }
    
    function getJoinType()
    {
        
        
    }
    
    
    
    function getForeignType($report_id = null)
    {
        if($school_id > 0){
               $this->db->where('school_id',$school_id);
            } 
        $this->db->select("join_table, join_field, join_type, complex_fields");
        $this->db->where('report_id',$report_id);
        $this->db->from($this->_table);
        return $this->db->get()->result_array();     
    }
    function getHiddenType($report_id = null)
    {
        
    }
}