<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Other extends CI_Controller {

    function __construct() {
        parent::__construct();
    }
	
    function db_error() {
        $page_data['page_name'] = '../error/db_error_page';
        $page_data['error_type'] = 'db_error';
        $page_data['page_title'] = get_phrase('your_are_lost');
        $this->load->view('backend/index', $page_data);
    }

    function error() {
        $page_data['page_name'] = '../error/php_error';
        $page_data['error_type'] = 'php_error';
        $page_data['page_title'] = get_phrase('your_are_lost');
        $this->load->view('backend/index', $page_data);
    }

    function error_404() {
        //Catch Page
        $error_log = "---------------------------------------------\n";
        $error_log .= ENVIRONMENT.': AT '.date('Y-m-d H:i:s')."\n";
        $error_log .= "Page not found:-".current_url()."\n";
        generate_log($error_log,'php_errors_'.date('Y-m-d').'.log');

        
        //Show View
        $page_data['page_name'] = '../error/error_404';
        $page_data['error_type'] = '404';
        $page_data['page_title'] = get_phrase('your_are_lost');
        $this->load->view('backend/index', $page_data);
    }
}	