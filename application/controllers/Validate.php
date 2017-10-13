<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Validate extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->library('form_validation');
        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        //$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        //$this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        $this->load->model("Subject_model");
        $this->load->model("Class_model");
        $this->load->model("Setting_model");
        $this->load->model("Student_model");
        $this->load->model("Teacher_model");
        $this->load->model("Parent_model");
    }

    function validateemail($email = '') {
        $account_type = $this->session->userdata('login_type');
        $this->form_validation->set_rules('email', 'Email', 'valid_email|is_unique[student.email]|is_unique[parent.email]|is_unique[bus_administrator.email]|is_unique[teacher.email]|is_unique[admin.email]');
        if ($this->form_validation->run() == FALSE) {
            echo "invalid";
        } else {
            echo "valid";
        }
    }
    
    function validate_parrent_email(){
        $email=$this->input->post('email');
        if($this->Parent_model->is_email_exists($email)==TRUE){
            echo 'invalid';die;
        }else{
            echo 'valid';die;
        }
    }

    function validate_parrent_email_phone(){
        $email=$this->input->post('email',TRUE);
        $phone=$this->input->post('phone',TRUE);
        if($this->Parent_model->is_email_phone_exists($email,$phone)==TRUE){
            echo 'email_phone_exists';die;
        }else{
            if($this->Parent_model->is_phone_exists($phone)==TRUE){
                echo 'phone_exists';die;
            }else{
                echo 'gowell';die;
            }
        }
    }
}
