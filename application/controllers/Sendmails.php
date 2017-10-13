<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sendmails extends CI_Controller {
     function __construct()
    {
        parent::__construct();
	$this->load->database();
        $this->load->library('session');
        /*cache control*/
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        //$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        //$this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    }
    /**************************Ajax func sending notification******************/

    function sendExamNotification(){
      /*********************loading models*************************************/
        $this->load->model("Notification_model");
        $this->load->model("Parent_model");
        $this->load->helper("email_helper");
       
        $exam_name                  =   $this->input->post('exam_name');
        $exam_date                  =   $this->input->post('exam_date');
        $comment                    =   $this->input->post('comment');
        $event_name                 =   $this->input->post('event');
        $records                    =   $this->Notification_model->get_data_generic_fun('sms,email,push_notify',array('activity'=>$event_name),'result_arr');
      
        /*************************if email set*********************************/
        $parents_details             =   $this->Parent_model->get_data_generic_fun('email,cell_phone',array('isActive'=>'1'),'result_arr');     
        foreach($records as $record){
            if($record['email']==1){
                $data                   =   array();
                $data['exam_name']      =   $exam_name;
                $data['exam_date']      =   $exam_date;
                $data['comment']        =   $comment;
                $system_name            =   $this->db->get_where('settings' , array('type' => 'system_name'))->row()->description;
                $from                   =   $this->db->get_where('settings' , array('type' => 'system_email'))->row()->description;
                $sub                    =   "Exam date declared";
                
                
                $body =$this->load->view('backend/school_admin/emails/exam_mail',$data,TRUE);

                foreach ($parents_details as $name => $address){
                   
                   send_common_mail($address['email'],$from,$system_name,$sub,$body,'backend/school_admin/emails/exam_mail',$data);
                }
                
               

            }
            /*****************************if sms set***************************/
            if($record['sms']==1){
                
                $location           =   '';
                $sms_array          =   array();
                foreach ($parents_details as $name => $address){
                    $sms_array[]    =   $address['cell_phone'];
                }
                $message            =   "Your childs exam date has been declared";
                //print_r($sms_array);
                $receiver_phone =   implode(',',$sms_array);  
                $url            =  "http://".SMS_IP_ADDR."/School/index.php/?admin/send_common_sms/";
                $post=[
                    'location'  =>$location,
                    'cell_phone'=>$receiver_phone,
                    'message'   =>$message
                ];
                $response=fire_api_by_curl($url, $post);
                
            }
        }//end of foreach
            
    }
    
   
}