<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_school_model extends CI_Model {

    private $_table = "school_db";
     private $_primary="school_db_id";
    function __construct() {
        parent::__construct();
    }
    
        function save_school_info($dataArray){
                   $schoolinfo_id = $this->db->insert('school_db', $dataArray);
           return $schoolinfo_id;
       }
        function get_schools(){
           $detail = $this->db->select('*')->from('school_db')->order_by('school_db_id','desc')->get()->result_array();
        return $detail;
       }
       function update_info($id,$data){
           $this->db->where('school_db_id', $id);
        $this->db->update('school_db', $data);
        return true;
       }
       function get_info_by_id($id){
//           echo $id;
           $detail = $this->db->get_where('school_db', array('school_db_id' => $id))->row();
           return $detail;
       }
        public function delete_info($condition){            
            $this->db->delete( 'school_db' , $condition );
            return true;
        }
        
           
     
    
}