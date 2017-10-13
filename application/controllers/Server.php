<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class server extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 10000; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
		
            $this->load->database();
            $this->load->model('Bus_driver_modal');
            $this->load->model('Student_model');
            $this->load->library('session');
            /* cache control */
            $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
            //$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
            //$this->output->set_header('Pragma: no-cache');
            $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    }

    public function reading_get()
    {
       
		
    }

    public function reading_post()
    {

        	$data['data']='';
			$this->load->helper('file');
			$data['imei']           = $this->input->post('MOB');
            $data['data']     		= $this->input->post('GPRMC');
			$data['CELLID']			=$this->input->post('CELLID');
			log_message('error',$data['data']);
			log_message('error',$data['CELLID']);
			$this->load->helper('file');

              // $this->some_model->update_user( ... );
		//$input=$this->post('message');
		
        

			//$data = 'Some file data';
			$CardNumber='';
			$strData = "MOB=860194030166854&GPRMC=185633.00,A,2301.72748,N,07234.15552,E,2.050,,100716,,,A,0,0,1,1,0.00,0.00,4.31,E19CD9@";
    		if ( ! write_file(APPPATH."/logs/log.txt", $strData))
   			 {
            		echo APPPATH."logs/log.txt". ' Unable to write the file';
   			 }
   			 else
    		{
     		       echo 'File written!';
   			 }
			
			$Invalid_strData = "CELLIDLC:13ED,CD:0000289A,0,0,1,1,0.00,0.00,4.31,0@";
			$result=array();

       		 $success =false;
			$IMEI =$data['imei'];// substr_replace($strContent[0], "", 0, 4);
			$GPRMC = $data['data'];//substr_replace($strContent[1], "", 0, 6);
			$CELLID= $data['CELLID'];
			$gprmc= $GPRMC;
			if ($data['data']!='')
			{
		    $strarray = explode(",", $gprmc);
			if (sizeof($strarray) >= 17) {

                    $Time = $strarray[0];
                    // 141524.000
					$AM= $strarray[1];
                    $Latitude = $strarray[2];
                    //2301.7072
                    $LatDirection = $strarray[3];
                    //N
					$Longitude = $strarray[4];
                    //07234.1865
                    $LongDirection = $strarray[5];
                    //E
                    $Speed = $strarray[6];
                    //10.57
                    $dat = $strarray[8];
                    //281013
                    $DI1 = $strarray[12];
                    $DI2 = $strarray[13];
                    $DI3 = $strarray[14];
                    $DI4 = $strarray[15];
                    $AI1 = $strarray[16];
                    $AI2 = $strarray[17];
                    $Odometer = $strarray[18];

                    //'converting RFID Card Number from Hex Value into Deciaml Value
                    $CardNumber = hexdec($strarray[19]);//int.Parse(, System.Globalization.NumberStyles.HexNumber);

                    //'For converting lat/long from degree minutes format to decimal degree format
                    $LatDegree = substr($Latitude, 0, 2);
                    //23
                    $LatMinute = substr($Latitude, 2, 7);
                    //01.7072
                    $LatMinute = $LatMinute / 60;
                    //0.0284533333333333
                    $Latitude = (double)$LatDegree + (double)$LatMinute;
                    //23.0284533333333
					
					 if ($LatDirection == "S") {
                        $Latitude = -$Latitude;
                    }
					$LongDegree = substr($Longitude, 0, 3);
                    //23
                    $LongMinute = substr($Longitude, 3, 7);
                    //01.7072
                    $LongMinute = $LongMinute / 60;
                    //0.0284533333333333
                    $Longitude = (double)$LongDegree + (double)$LongMinute;
                    //23.0284533333333
					
                    //'If longitude is of west pole then that must be of -ve
                    if ($LongDirection == "W") {
                        $Longitude = -$Longitude;
                    }

                    //'For converting speed from knots to km
                    $Speed = ($Speed * 1.852);
                    //1 knots = 1.852 km/h

                    //'If speed is between 0 to 3 then speed = 0
                    if ($Speed > 0 & $Speed < 3) {
                        $Speed = 0.0;
                    }

                    //'For converting time & date to proper format
                    $Time = substr_replace($Time, ":", 2, 0);
            		//14:1524.000
                    $Time = substr_replace($Time, ":", 5, 0);
            		//14:15:24.000
                    $dat = substr_replace($dat, "/", 2, 0);
                    //28/1013
                    $dat = substr_replace($dat, "/", 5, 0);
                    //28/10/13
					//echo $dat;
					//echo $Time;
					$dat = $dat . " " . $Time. " ". $AM;
                    $date = new DateTime();
					$originalDate = $dat;
					$dat = date("Y-m-d h:i:s", strtotime($originalDate));
					
					
					$date->setTimestamp($dat . " " . $Time);
					echo $date;
                    
                    //10/28/2013 2:15:24 PM
					echo $dat;
					//exit;
                    //'Get Hours' and Minutes' values from web.config and add it to dt
                    //$dt = date('m/d/Y h:i:s A', strtotime('+5 hour +30 minutes', strtotime($dat)));
					
                    $result = array(
                            "phoneNumber" => '37a1b4bd-c854-4e65-8b7b-ff4380dac7f9',
							"userName" => $IMEI,
							"sessionID" =>'84a2c416-17fd-4a46-bf2f-c564f124c9db',
							"locationMethod" => 'fused',
							"eventType" => 'android',
                            "gpsTime" => $dat,
                            "latitude" => $Latitude,
                            "longitude" => $Longitude,
                            "speed" => $Speed,
                            "DI1" => $DI1,
                            "DI2" => $DI2,
                            "DI3" => $DI3,
                            "DI4" => $DI4,
                            "Fuel" => $AI1,
                            "Temperature" => $AI2,
                            "OdoMeter" => $Odometer,
                            "RFIDCardNumber" => $CardNumber
                    );
			}
			
					
             }
			  else
			  
			{
					$cellarray = explode(",", $data['CELLID']);
					$LC = $cellarray[0];
					$CD = $cellarray[1];	
					$DI1 = $cellarray[2];
                    $DI2 = $cellarray[3];
                    $DI3 = $cellarray[4];
                    $DI4 = $cellarray[5];
                    $AI1 = $cellarray[6];
                    $AI2 = $cellarray[7];
                    $Odometer = $cellarray[8];

                    //'converting RFID Card Number from Hex Value into Deciaml Value
                    $CardNumber = hexdec($strarray[9]);//int.Parse(, System.Globalization.NumberStyles.HexNumber);

				$result = array(
                            "phoneNumber" => $IMEI,
							"DI1" => $DI1,
                            "DI2" => $DI2,
                            "DI3" => $DI3,
                            "DI4" => $DI4,
                            "Fuel" => $AI1,
                            "Temperature" => $AI2,
                            "OdoMeter" => $Odometer,
                            "RFIDCardNumber" => $CardNumber);
			}
				$this->db->insert('gpslocations', $result);		
                $success=true;
            //}
			if($CardNumber!='')
			{
                            $data1=
                                    array(
                           'bus_id'=>$this->Bus_driver_modal->get_bus_details(array('device_imei'=>$IMEI),'bus_id'),
                           'route_id'=>$this->Bus_driver_modal->get_bus_details(array('device_imei'=>$IMEI),'route_id'),
                           'student_id'=> $this->Student_model->get_student_record(array('card_id'=>$CardNumber),'student_id'),
                           'transport_group' => $this->Student_model->get_student_record(array('card_id'=>$CardNumber),'transport_group'),        
                           'session'=>(date('A') == 'AM')? 0 : 1,
                           'date'=> date('d/m/y')          
                                        );
                            $this->Bus_driver_modal->mark_attendence($data1);
                            
			}
        //}

        $this->set_response(['status'=>$success,'data'=>$result], REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code

       // $this->set_response(['status'=>TRUE,'imei'=>$message], REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function users_delete()
    {
        $id = (int) $this->get('id');

        // Validate the id.
        if ($id <= 0)
        {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // $this->some_model->delete_something($id);
        

        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }

}
