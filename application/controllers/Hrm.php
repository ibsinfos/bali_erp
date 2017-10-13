<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 	
 * 
 *  Module : HRM
 *  Details : Controller for HRM module
 * 
 */

class Hrm extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        /* cache control */
        //$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        //$this->output->set_header('Pragma: no-cache');
       
        date_default_timezone_set('Asia/Dubai');
    }

   
    public function welcome() {
        
    if (isset($_COOKIE['PHPSESSID'])) {
        $username= $_SESSION['username'];
        $password= $_SESSION['password'];
        setcookie("username", $username , time() + (60 * 20)); 
        setcookie("password", $password , time() + (60 * 20)); 
    }
    redirect(base_url().'hrm/index.php/welcome', 'refresh');
    }

    
}
