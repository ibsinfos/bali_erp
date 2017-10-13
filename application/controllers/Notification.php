<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    /* 	
     * 	@author : Joyonto Roy
     * 	date	: 20 August, 2013
     * 	University Of Dhaka, Bangladesh
     * 	Ekattor School & College Management System
     * 	http://codecanyon.net/user/joyontaroy
     */

    class Notification extends CI_Controller
    {

        function __construct()
        {
            parent::__construct();
            $this->load->database();
            $this->load->library('session');
            /* cache control */
            $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
            //$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
            //$this->output->set_header('Pragma: no-cache');
            $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        }

        public function savetoken()
        {
            $response = false;
            $arr = array();
            $email = $this->input->post("email");
            $token = $this->input->post("token");
            if (!empty($email) && !empty($token))
            {
                $dataValues = array(
                    "email" => $email,
                    "api_token" => $token
                );
                $this->load->model("Api_model");
                $return = $this->Api_model->save_parents_token($dataValues);
            }
            if (!empty($return))
            {
                $response = [
                    'status' => "success",
                    'message' => 'Token Added Successfully'
                ];
            }
            else
            {
                $response = [
                    'status' => "error",
                    'message' => 'Error Occoured'
                ];
            }
            $arr['response'] = $response;
            echo json_encode($arr);
        }

        public function sendpushnotification()
        {
            $arr = array();
            $parent_id = $this->input->post("parent_id");
            $message = $this->input->post("message");
            $this->load->model("Api_model");
            $parent_token = $this->Api_model->get_parents_token($parent_id);
            if (!empty($parent_token))
            {
//                p($parent_token);
                $this->load->library("Android_Pushnotification");
                $return = $this->android_pushnotification->sendNotification(array($parent_token), $message);
            }

            if (!empty($return))
            {
                $response = [
                    'status' => "success",
                    'message' => 'Notification Send Successfully'
                ];
            }
            else
            {
                $response = [
                    'status' => "error",
                    'message' => 'Error Occoured'
                ];
            }
            $arr['response'] = $response;
            echo json_encode($arr);
        }

    }
    