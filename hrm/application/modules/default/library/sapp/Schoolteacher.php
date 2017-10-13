<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class sapp_Schoolteacher{
    private function __construct() {
        
    }
    
    public static function _add_school_employee($postData){
        error_reporting(E_ALL);
        ini_set('display_errors',1);
        sapp_Schoolteacher::_generate_log("inside cURL function");
        if($_SERVER['HTTP_HOST']=='52.29.203.220' || $_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='localhost:8080'){
            $url = CURRENT_HTTP_PROTOCOL.$_SERVER['HTTP_HOST'].'/'.SH_CURRENT_INSTANCE."/index.php?ajax_controller/add_employee_from_hrm";
        } else {
            $url = CURRENT_HTTP_PROTOCOL.$_SERVER['HTTP_HOST']."/index.php?ajax_controller/add_employee_from_hrm";
        }
//        $url_arr=explode('/', $_SERVER['PHP_SELF']);
//        $url="http://".$_SERVER['HTTP_HOST']."/".$url_arr[1].'/index.php/?ajax_controller/add_employee_from_hrm';
        sapp_Schoolteacher::_generate_log(" init URL = ".$url);
        $ch = curl_init($url);
        sapp_Schoolteacher::_generate_log("init curl");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        sapp_Schoolteacher::_generate_log('starting curl execute '.PHP_EOL);
        // execute!
        $response = curl_exec($ch);
        sapp_Schoolteacher::_generate_log("get curl response from remote shcool == ".  json_decode($response));
        sapp_Schoolteacher::_generate_log('getting cURL '.$url.' response '.$response.PHP_EOL);
       // print_r($response); die;
        curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    }
    
    public static function _generate_log($message){
        $dir=$_SERVER['DOCUMENT_ROOT'];
        //die($dir);
        if($_SERVER['HTTP_HOST']=='52.29.203.220' || $_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='localhost:8080'){
                $dir .= '/'.CURRENT_INSTANCE.'/uploads/';
        }else{
                $dir .= '/uploads/';
        }
                $log_file_path=$dir.'demo_school_'.date('Y-m-d').'.log';
//        $url_arr=explode('/', $_SERVER['PHP_SELF']);
//        $dir=$_SERVER['DOCUMENT_ROOT'].'/'.$url_arr[1].'/uploads/';
        $log_file_path=$dir.'demo_school_'.date('Y-m-d').'.log';
        //echo $log_file_path;die;
        if(file_exists($log_file_path)) {
            if (!$handle = fopen($log_file_path, 'a+')) {
                return false;
            }else{
                $message.=PHP_EOL;
                if (fwrite($handle, $message) === FALSE) {
                    return false;
                }else{
                    fclose($handle);
                }
            }
        }
    }
    
    public static function _create_passcode($type=''){
        if(!empty($type)){
            if($type==='teacher'){
                $passcode = "sta" . mt_rand(10000000, 99999999);
                return $passcode;
            }else if($type==='bus_driver'){
                $passcode = "dri" . mt_rand(10000000, 99999999);
                return $passcode;
            }else if($type==='librarian'){
                $passcode = "sli" . mt_rand(10000000, 99999999);
                return $passcode;
            }else if($type==='accountant'){
                $passcode = "sac" . mt_rand(10000000, 99999999);
                return $passcode;
            }else{
                return 'invalid';
            }            
        }else{
            return 'invalid';
        }
    }
    
    
}

