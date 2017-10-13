<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bus_driver_attendence_model extends CI_Model {
    private $_table="bus_driver_attendence"; 
    
    public function __construct() {
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
        $this->db->insert($this->_table,$dataArr);
        return $this->db->insert_id();
    }
}
