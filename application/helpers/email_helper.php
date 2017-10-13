<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

function send_common_mail($toEmail='',$subject='',$message='',$toName=""){
    if($toEmail=="" || $subject=="" || $message=="")
        return FALSE;
    
    $ci                     =   & get_instance();
    /******************loading models and controllers**************************/
    $ci->load->library('email');
    
    $settingsDataArr=get_data_generic_fun('settings','description',array('condition_type'=>'in','condition_in_col'=>'type','condition_in_data'=>'system_name,system_email'));
    $system_name =  $settingsDataArr[0]->description;
    //$from = $settingsDataArr[0]->description;
    $from = $settingsDataArr[1]->description;
    
    $config                 =   array();
    $config['protocol'] = "smtp";
    $config['smtp_host'] = "ssl://smtp.gmail.com";
    $config['smtp_port'] = "465";
    $config['smtp_user'] = "sharadtechnologies.in@gmail.com"; 
    $config['smtp_pass'] = "Sharad1!";
    $config['charset'] = "utf-8";
    $config['mailtype'] = "html";
    $config['newline'] = "\r\n";
    $config['crlf']    = "\n"; 
    $config['wordwrap'] = TRUE;
  
    $ci->email->initialize($config);
    //$ci->email->set_newline="\r\n";
    //$ci->email->crlf = "\n";
    //$ci->email->set_header('MIME-Version', '1.0; charset=utf-8'); //must add this line
    //$ci->email->set_header('Content-type', 'text/html'); //must add this line
    $ci->email->from($from, $system_name);        
    $ci->email->subject($subject);
    
    $ci->email->to($toEmail,$toName);
  //  $ci->email->reply_to('no-reply@sharadtechnologies.com','No Reply');
   // $body =$ci->load->view($view_name,$data,TRUE);
    $ci->email->message($message);        
    $r=$ci->email->send();
    if(!$r)        {
         return $rr=$ci->email->print_debugger();
    }else{
        return 1;
    }
}

// ------------------------------------------------------------------------
/* End of file email_helper.php */
/* Location: ./application/helpers/email_helper.php */