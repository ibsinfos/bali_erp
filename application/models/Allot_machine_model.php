<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Allot_machine_model extends CI_Model {

    private $_table = "master_device_for_all_schools";
    

    function __construct() {
        parent::__construct();
    }
    
    function save_machine_info($dataArray){
        $school_id = $this->session->userdata('school_id');
        if($school_id > 0){
            $dataArray['school_id'] = $school_id;
        } 
       $schoolinfo_id = $this->db->insert('master_device_for_all_schools', $dataArray);
       return $schoolinfo_id;
   }

    public function get_school_deatail(){
        $school_id = $this->session->userdata('school_id');
        if($school_id > 0){
            $this->db->where("school_id",$school_id);
        } 
         $detail = $this->db->select('school_db_id,school_name')->from('school_db')->order_by('school_db_id','desc')->get()->result_array();
         return $detail;
    }
   function get_machine_info(){
       $school_id = $this->session->userdata('school_id');
        if($school_id > 0){
            $this->db->where("school_id",$school_id);
        } 
       $detail = $this->db->select('*')->from('master_device_for_all_schools')->order_by('device_id','desc')->get()->result_array();
    return $detail;
   }
}