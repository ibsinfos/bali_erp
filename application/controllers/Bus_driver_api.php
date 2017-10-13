<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Bus_driver_api extends REST_Controller{
    function __construct($config = 'rest1') {
        parent::__construct($config);
        $this->load->model("Bus_driver_api_model");
    }
    
    public function manage_bus_attendence(){        
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
    
}

