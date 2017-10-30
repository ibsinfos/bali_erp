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
        $running_year = $this->session->userdata('running_year');
        $start_month = sett('start_month');
        $end_month = sett('end_month');
        $first_year = date('Y',strtotime($start_month));
        $second_year = date('Y',strtotime($end_month));
        $start_date = date('Y-m-d',strtotime($start_month));
        $end_date = date('Y-m-t',strtotime($end_month));
        
        _school_cond();
        $whr = array("running_year"=>$running_year,'date_start >='=>$start_date,'date_start <='=>$end_date,'is_active'=>1);
        return $this->db->order_by('date_start ASC')->get_where('holiday',$whr)->result_array(); 
    }
	   
    function get_holiday_list()
    {
        $running_year = $this->session->userdata('running_year');
        $start_month = sett('start_month');
        $end_month = sett('end_month');
        $first_year = date('Y',strtotime($start_month));
        $second_year = date('Y',strtotime($end_month));
        $start_date = date('Y-m-d',strtotime($start_month));
        $end_date = date('Y-m-t',strtotime($end_month));

        _school_cond();
        $whr = array("running_year"=>$running_year,'date_start >='=>$start_date,'date_start <='=>$end_date);
        return $this->db->order_by('date_start ASC')->get_where('holiday',$whr)->result(); 		
    }

    function get_holiday_active_list()
    {
        $running_year = $this->session->userdata('running_year');
        $start_month = sett('start_month');
        $end_month = sett('end_month');
        $first_year = date('Y',strtotime($start_month));
        $second_year = date('Y',strtotime($end_month));
        $start_date = date('Y-m-d',strtotime($start_month));
        $end_date = date('Y-m-t',strtotime($end_month));

        _school_cond();
        $whr = array("running_year"=>$running_year,'date_start >='=>$start_date,'date_start <='=>$end_date);
        return $this->db->order_by('date_start ASC')->get_where('holiday',$whr)->result_array(); 	
    }
	   
    function deactivate_holiday($id)
    { 
        
        _school_cond();
        $this->db->where('id',$id);
        return $this->db->update('holiday',array('is_active'=>0));
    }

    function activate_holiday($id)
    {
        _school_cond();
        $this->db->where('id',$id);
        return $this->db->update('holiday',array('is_active'=>1));
    }

    function delete_holiday($id)
    {
        _school_cond();
        $this->db->where('id',$id);
        return $this->db->delete('holiday');
    }

    function get_holiday_by_id($id){
    
        _school_cond();
        $this->db->where('id',$id);
        return $this->db->get('holiday')->result_array();
    }

    function update_holiday($dataArray, $id)
    {
        _school_cond();
        $this->db->where('id',$id);
        $update = $this->db->update('holiday', $dataArray);
        return $update;
    }
      
    function get_all_holidays($school_id='') {

        $running_year = $this->session->userdata('running_year');
        $start_month = sett('start_month');
        $end_month = sett('end_month');
        $first_year = date('Y',strtotime($start_month));
        $second_year = date('Y',strtotime($end_month));
        $start_date = date('Y-m-d',strtotime($start_month));
        $end_date = date('Y-m-t',strtotime($end_month));

        _school_cond();
        $whr = array("running_year"=>$running_year,'date_start >='=>$start_date,'date_start <='=>$end_date,'is_active'=>'1');
        return $this->db->limit(6)->order_by('date_start ASC')->get_where('holiday',$whr)->result_array();    
    }
      
    function getHolidaysByMonth($month='',$school_id='') {
        
        $running_year = $this->session->userdata('running_year');
        $start_month = sett('start_month');
        $end_month = sett('end_month');
        $first_year = date('Y',strtotime($start_month));
        $second_year = date('Y',strtotime($end_month));
        $start_date = date('Y-m-d',strtotime($start_month));
        $end_date = date('Y-m-t',strtotime($end_month));

        _school_cond();
        $whr = array("running_year"=>$running_year,'date_start >='=>$start_date,"MONTH(date_start)" => $month,'date_start <='=>$end_date,'is_active'=>'1');
        return $this->db->order_by('date_start ASC')->get_where('holiday',$whr)->result_array();     
    }
      
    function getstudent_dashboardHolidays($month=''){
        
        $running_year = $this->session->userdata('running_year');
        $start_month = sett('start_month');
        $end_month = sett('end_month');
        $first_year = date('Y',strtotime($start_month));
        $second_year = date('Y',strtotime($end_month));
        $start_date = date('Y-m-d',strtotime($start_month));
        $end_date = date('Y-m-t',strtotime($end_month));

        _school_cond();
        $whr = array("running_year"=>$running_year,'date_start >='=>$start_date,"MONTH(date_start)" => $month,'date_start <='=>$end_date,'is_active'=>'1');
        return $this->db->limit('6')->order_by('date_start ASC')->get_where('holiday',$whr)->result_array();   
    }
      
    function get_teacher_holiday_active_list()
    {
        $running_year=  $this->session->userdata('running_year');
        $first_year=explode("-",$running_year)[0];
        $second_year=explode("-",$running_year)[1];
        $startdate=$first_year.'-'.date('m-d');
        $enddate=$second_year."-07-01";
        $this->db->order_by("holidaydate",'ASC');

        _school_cond();
        $this->db->where("(holidayyear = '".$first_year."' OR holidayyear='".$second_year."') AND holidaydate >= '".date('Y-m-d')."'");
        return $this->db->get_where("main_holidaydates",array('isactive'=>'1'))->result_array();    
    }
}

