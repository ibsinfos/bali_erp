<?php
defined('BASEPATH')or exit('no direect script access allowed');

class Global_access extends CI_Controller{
  function __construct() {
      parent::__construct();
  }
  public function student_enquiry(){
        $data=array();
        $data['class_data_arr']=get_data_generic_fun('class','class_id',array('name'=>'LKG'),'result_arr');
        $data['class_id_nursery'] = get_data_generic_fun('class','class_id', array('name' => 'Nursery'),'result_array');
        $data['page_title'] = get_phrase('school_admission_form');
        $this->load->model('Class_model');
        $class_array = $this->Class_model->get_class_array();
        //$grade_array = $this->Class_model->get_grade_array();
        //$page_data['grade'] = $grade_array;
        $data['classes'] = $class_array;
        $this->load->view('backend/school_admin/school_enquiry', $data);
  }
    public function  enquiry_submitted(){
        $this->load->model("Enquired_students_model");
        $this->load->model("Guardian_model");
        $this->load->model("Class_model");

        $this->form_validation->set_rules('student_fname', 'Student First Name', 'required');
        $this->form_validation->set_rules('student_lname', 'Student  Last Name', 'required');
        $this->form_validation->set_rules('parent_fname', 'Father First Name', 'required');
        $this->form_validation->set_rules('parent_lname', 'Father Last Name', 'required');
        $this->form_validation->set_rules('mother_fname', 'Mother First Name', 'required');
        $this->form_validation->set_rules('mother_lname', 'Mother Last Name', 'required');
        $this->form_validation->set_rules('class', 'Class', 'required');
        $this->form_validation->set_rules('previous_class', 'Previous Class', 'required');
        //$this->form_validation->set_rules('previous_school', 'Previous School', 'required');
        /* if(($this->input->post('previous_class')!=$this->Class_model->get_class_id_LKG())||($this->input->post('previous_class')!=$this->db->get_where('class',array('name'=>'UKG'))->row()->class_id))
        {
        $this->form_validation->set_rules('previous_result', 'Previous Result','required');
        } */
        //$this->form_validation->set_rules('previous_result', 'Previous Result', 'required');
        $this->form_validation->set_rules('category', 'Category', 'required');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('birthday', 'Date of Birth', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('city', 'Current City', 'required');
        //$this->form_validation->set_rules('user_email', 'User Email', 'trim|required|valid_email|is_unique[enquired_students.user_email]');
        //$this->form_validation->set_rules('mobile_number', 'Phone Number', 'required|numeric|max_length[11]|is_unique[enquired_students.mobile_number]');
        $this->form_validation->set_rules('advance', 'Advance payed or not', 'required');
        $this->form_validation->set_rules('annual_salary', 'Annual_salary', 'required');
        $this->form_validation->set_rules('guardian_emergency_number', 'Emergency Contact Number', 'required|numeric|max_length[12]');
        if ($this->form_validation->run() == TRUE) {
            $admit_data['admission_form_id'] = substr(md5(rand(0, 1000000)), 0, 7);
            $admit_data['student_fname'] = $this->input->post('student_fname');
            $admit_data['student_lname'] = $this->input->post('student_lname');
            $admit_data['parent_fname'] = $this->input->post('parent_fname');
            $admit_data['parent_lname'] = $this->input->post('parent_lname');
            $admit_data['class_id'] = $this->input->post('class');
            $bday = $this->input->post('birthday');
            $admit_data['birthday'] = date('Y-m-d', strtotime($bday));
            $admit_data['address'] = $this->input->post('address');
            $admit_data['address_second'] = $this->input->post('address2');
            $admit_data['city'] = $this->input->post('city');
            $admit_data['region'] = $this->input->post('region');
            $admit_data['zip_code'] = $this->input->post('zip_code');
            $admit_data['country'] = $this->input->post('country');
            $admit_data['user_email'] = $this->input->post('user_email');
            $admit_data['mobile_number'] = $this->input->post('mobile_number');
            $admit_data['phone'] = $this->input->post('phone');
            $admit_data['work_phone'] = $this->input->post('work_phone');
            $admit_data['advance'] = $this->input->post('advance');
            //$admit_data['transport'] = $this->input->post('transport');           
            $admit_data['mother_fname'] = $this->input->post('mother_fname');
            $admit_data['mother_lname'] = $this->input->post('mother_lname');
            $admit_data['previous_class'] = $this->input->post('previous_class');
            $admit_data['previous_school'] = $this->input->post('previous_school');
            $admit_data['previous_result'] = $this->input->post('previous_result');
            $admit_data['caste_category'] = $this->input->post('category');
            $admit_data['gender'] = $this->input->post('gender');
            $admit_data['annual_salary'] = $this->input->post('annual_salary');
            $admit_data['receipt_no'] = $this->input->post('receipt_no');
            $admit_data['govt_admission_code'] = $this->input->post('govt_admission_code');

            //$admit_data['form_no'] = $this->input->post('form_no');
            $admit_data['create_date'] = date("Y-m-d H:i:s");

            //add Guardian details
            $data_guardian['guardian_fname'] = $this->input->post('guardian_first_name');
            $data_guardian['guardian_lname'] = $this->input->post('guardian_last_name');
            $data_guardian['guardian_profession'] = $this->input->post('guardian_profession');
            $data_guardian['guardian_address'] = $this->input->post('guardian_address');
            $data_guardian['guardian_email'] = $this->input->post('guardian_email');
            $data_guardian['guardian_emergency_number'] = $this->input->post('guardian_emergency_number');
            $data_guardian['guardian_date_created'] = date('Y-m-d H:i:s');
            $data_guardian['guardian_isActive'] = '1';

            $guardian_id  = $this->Guardian_model->insert_guardian($data_guardian);
            if($guardian_id){ 
                $admit_data['guardian_id'] = $guardian_id;
                $this->Enquired_students_model->save_enquired_student($admit_data);
                $this->session->set_flashdata('flash_message', get_phrase('enquiry_form_submitted_succesfully!!'));
                redirect(base_url() . 'index.php?global_access/student_enquiry_success/');
            } else {
                $this->session->set_flashdata('flash_message', get_phrase('some_error_ocured!!'));
                redirect(base_url()."index.php?global_access/student_enquiry");
            }
        } else {
            $this->session->set_flashdata('flash_message_error', validation_errors());
            redirect(base_url()."index.php?global_access/student_enquiry");
        }
     
    }
  
    public function student_enquiry_success(){
        $this->load->view("backend/school_admin/global_enquiry_submitted");
    }
  
}  
  