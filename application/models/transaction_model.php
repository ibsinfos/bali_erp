<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class Transaction_model extends CI_Model
    {

        function __construct()
        {
            parent::__construct();
        }

        function clear_cache()
        {
            $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
            $this->output->set_header('Pragma: no-cache');
        }

        function check_student_exist($student_id)
        {
            $transaction_check = 0;
            if(empty($student_id))
                return false;

            //check on book issue
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                    $book_issue = $this->db->get_where('book_issue', array(
                        'user_id' => $student_id,
                        'user_type' => 'Student',
                        'status' => 'Issued',
                        'school_id' => $school_id
                        ))->result_array();
                } 
            } else {
                $book_issue = $this->db->get_where('book_issue', array(
                        'user_id' => $student_id,
                        'user_type' => 'Student',
                        'status' => 'Issued'
                        ))->result_array();
            }
            if(count($book_issue))
            {
                $transaction_check  = 1;
                return $transaction_check;
            }


        }
   }     
