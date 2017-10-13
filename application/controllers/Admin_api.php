<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Admin_api extends REST_Controller{
    function __construct($config = 'rest1') {
        parent::__construct($config);
        //$this->load->model('Master_data_model');
         $this->load->model("Admin_api_model");
    }
    
  

    function getAllPresentStudent_post()
    {
        $dateValue = $this->post("date_value");
        if (empty($dateValue)) 
        {
            $data['action']  = "fail";
            $data['message'] = "please fill the date";
            success_response_after_post_get($data);
        }
            $data['studentPresentArr'] =  $this->Admin_api_model->get_all_present_student($dateValue);
            success_response_after_post_get($data);

            

    }

    function getTeacherInfo_post()
    {
        
        $teacherId = $this->post("teacher_id");
        if (empty($teacherId)) 
        {
            $data['action']  = "fail";
            $data['message'] = "please fill the teacher Id";
            success_response_after_post_get($data);
        }
        else
        {
            $data['teacherDataArr'] =  $this->Admin_api_model->get_teacher_info($teacherId);
            success_response_after_post_get($data);

        }    

    }

    function getTeacherList_get()
    {

            $data['arrTeacherDataArr'] =  $this->Admin_api_model->get_teachers();
            success_response_after_post_get($data);
    }

    function getClassList_get()
    {
        $data['arrClassDataArr'] =  $this->Admin_api_model->get_classes();
        success_response_after_post_get($data);

    }
    
    function getFeeDetail_post()
    {

        
        $dateValue = $this->post("date_value");
        $classId = $this->post("class_id");
        if (empty($dateValue)) 
        {
            $data['action']  = "fail";
            $data['message'] = "please fill the Date";
            success_response_after_post_get($data);
        }
        if(empty($classId))
            $classId = '';
        else
        {
            $data['feeDataArr'] =  $this->Admin_api_model->get_student_detail($dateValue, $classId);
            success_response_after_post_get($data);

        }  

    }

    function getStudentDetail_post()
    {

        
        $studentId = $this->post("student_id");
        if (empty($studentId)) 
        {
            $data['action']  = "fail";
            $data['message'] = "please fill the student Id";
            success_response_after_post_get($data);
        }
        else
        {
            $data['studentDataArr'] =  $this->Admin_api_model->get_student_detail($studentId);
            success_response_after_post_get($data);

        }  

    }

    function getDriversList_get()
    {
        $this->load->model("Bus_driver_modal");
        $data['arrDriverDataArr'] =  $this->Bus_driver_modal->get_bus_drivers();
        success_response_after_post_get($data);

    }    

     function getDriver_post()
    {
         $this->load->model("Bus_driver_modal");
         $driverId = $this->post("driver_id");
        if (empty($driverId)) 
        {
            $data['action']  = "fail";
            $data['message'] = "please fill the Driver Id";
            success_response_after_post_get($data);
        }
        else
        {
            $data['driverDataArr'] =  $this->Bus_driver_modal->get_bus_driver($driverId);
            success_response_after_post_get($data);

        }  

    } 

    function getBusRoutes_get()
    {
        $this->load->model("Bus_driver_modal");
        $data['busRouteArr'] =  $this->Bus_driver_modal->get_bus_with_route();
        success_response_after_post_get($data);
    } 

    function getOtherStudent_post()
    {
        echo "<br>hre";
    }

    function getTopStudents_post()
    {

        $exam_id = $this->post('exam_id');
        $class_id = $this->post('class_id');
        $section_id = $this->post('section_id');
        $ranking_id = $this->post('ranking_id');
        $exam_id = $this->post('exam_id');
        if (empty($exam_id)) 
        {
            $data['action']  = "fail";
            $data['message'] = "please fill the Exam Id";
            success_response_after_post_get($data);
        }
         if (empty($class_id)) 
        {
            $data['action']  = "fail";
            $data['message'] = "please fill the Class Id";
            success_response_after_post_get($data);
        }
         if (empty($section_id)) 
        {
            $data['action']  = "fail";
            $data['message'] = "please fill the Section Id";
            success_response_after_post_get($data);
        }
         if (empty($ranking_id)) 
        {
            $data['action']  = "fail";
            $data['message'] = "please fill the Ranking Id";
            success_response_after_post_get($data);
        }
        
        $data['arrStudent'] =  $this->Admin_api_model->get_top_students($exam_id, $class_id, $section_id, $ranking_id); 
        success_response_after_post_get($data);  
    }

    function getAdminDetail()
    {


    }
    
    
   
}