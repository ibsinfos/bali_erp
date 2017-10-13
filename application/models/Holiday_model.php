<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    
class Holiday_model extends CI_Model {

    private $_table = "holiday";
   

    function __construct() {
        parent::__construct();
    }

    public function save_holiday_list($dataArray) {
      $school_id = '';
      if(($this->session->userdata('school_id'))) {
          $school_id = $this->session->userdata('school_id');
          if($school_id > 0){
              $dataArray['school_id'] = $school_id;
          } 
      }
        $count = $this->db->get_where("holiday",array("school_id"=>$school_id, "title"=>$dataArray['title'], "date_start"=>$dataArray['date_start'], 'running_year'=>$dataArray['running_year']))->num_rows();

        if($count == 0){
            $this->db->insert("holiday",$dataArray); 

        }
      //$this->db->insert("holiday",$dataArray);
    }
    function get_holiday_list_attendance(){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $running_year=  $this->session->userdata('running_year');
        $first_year=explode("-",$running_year)[0];
        $second_year=explode("-",$running_year)[1];
        $startdate=$first_year."-07-01";
        $enddate=$second_year."-07-01";
        $this->db->order_by("date_start",'ASC');
        return $this->db->get_where("holiday",array("running_year"=>$running_year,"date_start <"=>$enddate,"date_start >"=>$startdate,"is_active"=>"1"))->result_array();
	}
	   
	   function get_holiday_list()
      {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $running_year=  $this->session->userdata('running_year');
        $first_year=explode("-",$running_year)[0];
        $second_year=explode("-",$running_year)[1];
        //$startdate=$first_year."-07-01";
        $startdate=$first_year.'-'.date('m-d');
        $enddate=$second_year."-07-01";
        $this->db->order_by("date_start",'ASC');
        return $this->db->get_where("holiday",array("running_year"=>$running_year,"date_start <"=>$enddate,"date_start >"=>$startdate))->result_array(); 		
       }

       function get_holiday_active_list()
      {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
       //pre($this->session->userdata()); DIE;
        $running_year=  $this->session->userdata('running_year');
        $first_year=explode("-",$running_year)[0];
        $second_year=explode("-",$running_year)[1];
        $startdate=$first_year.'-'.date('m-d');
        $enddate=$second_year."-07-01";
        $this->db->order_by("date_start",'ASC');
        return $this->db->get_where("holiday",array("running_year"=>$running_year,"date_start <"=>$enddate,"date_start >"=>$startdate, 'is_active'=>'1'))->result_array();    
       }
	   
      function deactivate_holiday($id)
      { 
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
		      $this->db->where('id',$id);
          $update = $this->db->update('holiday',array("is_active"=>"0"));
          return $update;
		  
      }
      function activate_holiday($id)
      {
          $school_id = '';
          if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
          }
          $this->db->where('id',$id);
          $update = $this->db->update('holiday',array("is_active"=>"1"));
          return $update;
      }

      function delete_holiday($id)
      {
          $school_id = '';
          if(($this->session->userdata('school_id'))) {
              $school_id = $this->session->userdata('school_id');
              if($school_id > 0){
                  $this->db->where('school_id',$school_id);
              } 
          }
          $this->db->where('id',$id);
          $delete = $this->db->delete('holiday');
          return $delete;
      }

      function get_holiday_by_id($id){
        $school_id = '';
          if(($this->session->userdata('school_id'))) {
              $school_id = $this->session->userdata('school_id');
              if($school_id > 0){
                  $this->db->where('school_id',$school_id);
              } 
          }
          $this->db->where('id',$id);
          $select = $this->db->get('holiday')->result_array();
          return $select;
      }

      function update_holiday($dataArray, $id)
      {
          $school_id = '';
          if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
          }
          $this->db->where('id',$id);
          $update = $this->db->update('holiday', $dataArray);
          return $update;
      }
      
      function get_all_holidays($school_id) {
        $running_year=  $this->session->userdata('running_year');
        $first_year=explode("-",$running_year)[0];
        $second_year=explode("-",$running_year)[1];
        $startdate=$first_year.'-'.date('m-d');
        $enddate=$second_year."-07-01";
        $current_month = date('m');
        $this->db->order_by("date_start",'ASC');
        $this->db->limit("6");
        return $this->db->get_where($this->_table,array("running_year"=>$running_year,"date_start <"=>$enddate,"date_start >"=>$startdate,'school_id' => $school_id,'is_active'=>'1'))->result_array();       
      }
      
      function getHolidaysByMonth($month,$school_id) {
        $running_year=  $this->session->userdata('running_year');
        $first_year=explode("-",$running_year)[0];
        $second_year=explode("-",$running_year)[1];
        $startdate=$first_year.'-'.date('m-d');
        $enddate=$second_year."-07-01";
        $current_month = date('m');
        $this->db->order_by("date_start",'ASC');
        $this->db->limit("6");
        return $this->db->get_where($this->_table,array("running_year"=>$running_year,"MONTH(date_start)" => $month,"date_start <"=>$enddate,"date_start >"=>$startdate,'school_id' => $school_id, 'is_active'=>'1'))->result_array();    
      }
}

