<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Doctor extends CI_Controller {
    public $globalSettingsSMSDataArr = array();
    public $globalSettingsLocation = "";
    public $globalSettingsAppPackageName = "";
    public $globalSettingsRunningYear = "";
    public $globalSettingsSystemName = "";
    public $globalSettingsSystemEamil = "";
    public $globalSettingsSystemFCMServerrKey = "";
    public $globalSettingsTextAlign = "";
    public $globalSettingsActiveSmsService = "";
    public $globalSettingsSkinColour = "";
    public $globalSettingsSystemTitle = "";
    public function __construct() {
        parent::__construct();

        $this->load->model("Enroll_model");
        $this->load->model('Setting_model');
        $this->load->model('Clinical_history_model');
        $this->load->model('Doctor_model');
        $this->load->model('Class_model');
        $this->load->model('Section_model');
        $this->load->model('Enroll_model');
        
        $this->globalSettingsSMSDataArr = get_data_generic_fun('settings', 'description', array('condition_type' => 'in', 'condition_in_col' => 'type', 'condition_in_data' => 'location,app_package_name,running_year,system_name,system_email,fcm_server_key,system_title,text_align,skin_colour,active_sms_service'));
        $this->globalSettingsLocation = $this->globalSettingsSMSDataArr[7]->description;
        $this->globalSettingsAppPackageName = $this->globalSettingsSMSDataArr[8]->description;
        $this->globalSettingsRunningYear = $this->globalSettingsSMSDataArr[6]->description;
        $this->globalSettingsSystemTitle = $this->globalSettingsSMSDataArr[1]->description;
        $this->globalSettingsSystemName = $this->globalSettingsSMSDataArr[0]->description;
        $this->globalSettingsSystemEmail = $this->globalSettingsSMSDataArr[2]->description;
        $this->globalSettingsSystemFCMServerrKey = $this->globalSettingsSMSDataArr[9]->description;
        $this->globalSettingsSkinColour = $this->globalSettingsSMSDataArr[5]->description;
        $this->globalSettingsTextAlign = $this->globalSettingsSMSDataArr[4]->description;
        $this->globalSettingsActiveSmsService = $this->globalSettingsSMSDataArr[3]->description;
        
        if ($this->session->userdata('doctor_login') != 1) {
            redirect(base_url(), 'refresh');
        }
    }

    public function index() {
        if($this->session->userdata('doctor_login') == 1)
            $this->dashboard();            
    }

    public function dashboard() {
        $page_data= $this->get_page_data_var();
        $this->load->model('Doctor_model');
        $doctor_id = $this->session->userdata('doctor_id');
        $doctor = $this->Doctor_model->get_data_by_id($doctor_id);
        $page_data['doctor_list'] = $doctor;
        $page_data['page_title'] = "View Profile";
        $page_data['page_name'] = 'dashboard';        
        $page_data['page_title'] = get_phrase('doctor_dashboard');
        $this->load->view('backend/index', $page_data);
    }
    
    function get_page_data_var(){
        $this->load->model('Crud_model');
        $page_data=array();
        $page_data['system_name']=$this->globalSettingsSystemName;
        $page_data['system_title']=$this->globalSettingsSystemTitle;
        $page_data['text_align']=$this->globalSettingsTextAlign;
        $page_data['skin_colour']=$this->globalSettingsSkinColour;
        $page_data['active_sms_service']=$this->globalSettingsActiveSmsService;
        $page_data['running_year']=$this->globalSettingsRunningYear;
        $page_data['location']=$this->globalSettingsLocation;
        $page_data['app_package_name']=$this->globalSettingsAppPackageName;
        $page_data['system_email']=$this->globalSettingsSystemEamil;
        $page_data['system_fcm_server_key']=$this->globalSettingsSystemFCMServerrKey;
        $page_data['account_type'] = $this->session->userdata('login_type');
        $user_type=$this->session->userdata('login_type');
        $page_data['filename'] = $this->Crud_model->getSpecificRecord($this->session->userdata('table'),$this->session->userdata($user_type.'_id'));
        return $page_data;
    }
    
    /* * ****MANAGE OWN PROFILE AND CHANGE PASSWORD** */

    function manage_profile($param1 = '', $param2 = '', $param3 = '') {
             if ($this->session->userdata('doctor_login') != 1)
            redirect(base_url(), 'refresh');
             
        $page_data = $this->get_page_data_var();                
        $doctor_id = $this->session->userdata('doctor_id');
         if ($param1 == 'update_profile_info') {
                $data['name'] = $this->input->post('name');
                $data['email'] = $this->input->post('email');
                $data['phone_no'] = $this->input->post('phone_no');
                $data['address'] = $this->input->post('address');
                $data['year_of_exp'] = $this->input->post('year_of_exp');
                $data['specialization'] = $this->input->post('specialization');
                $data['qualification'] = $this->input->post('qualification');
                $data['education_background'] = $this->input->post('education_background');
                $data['before_place_work'] = $this->input->post('before_place_work');
                $data['achivement_award'] = $this->input->post('achivement_award');
                $data['department'] = $this->input->post('department');
                $file_name = $_FILES['userfile']['name'];

                $types = array('image/jpeg', 'image/gif', 'image/png');
                if ($file_name != '') {
                    if (in_array($_FILES['userfile']['type'], $types)) {

                        $ext = explode(".", $file_name);
                        $data['profile_pic'] = $doctor_id . "." . end($ext);
                        $condition = array('doctor_id' => $doctor_id);
//                        pre($data); echo "success". $doctor_id; die;
                        if ($this->Doctor_model->update_doctor($data, $condition)) {
                            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/doctor_image/' . $data['profile_pic']);
                            $this->session->set_flashdata('flash_message', get_phrase('account_details_updated'));
                             redirect(base_url() . 'index.php?doctor/manage_profile/', 'refresh');
                        }
                    } else {
                        $this->session->set_flashdata('flash_message_error', get_phrase('It may be the wrong filetype. We only allow JPG, GIF, and PNG filetypes!!'));
                        redirect(base_url() . 'index.php?doctor/manage_profile/', 'refresh');
                    }
                } else {
                    $data['profile_pic'] = $this->input->post('image');
                    $condition = array('doctor_id' => $doctor_id);
                    $this->Doctor_model->update_doctor($data, $condition);
                    $this->session->set_flashdata('flash_message', get_phrase('account_details_updated'));
                    redirect(base_url() . 'index.php?doctor/manage_profile/', 'refresh');
                }
        }
        
         if ($param1 == 'change_password') {
                $condition = array('doctor_id' => $doctor_id);
                $data['password'] = sha1($this->input->post('password'));
                $data['new_password'] = sha1($this->input->post('new_password'));
                $data['confirm_new_password'] = sha1($this->input->post('confirm_new_password'));
                $current_password = $this->Doctor_model->get_data_by_id($doctor_id);
                $curr_pwsd = $current_password->password;

        if ($curr_pwsd == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {
                $dataArray = array('password' => $data['new_password'], 'passcode' => $this->input->post('new_password'));

                $this->Doctor_model->update_doctor($dataArray, $condition);
                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
        } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('password_mismatch'));
        }
            redirect(base_url() . 'index.php?doctor/manage_profile/', 'refresh');
    }
        $page_data['doctor_profile'] = $this->Doctor_model->get_data_by_id($doctor_id);
//        pre($page_data['doctor_profile']); die;
        $page_data['page_name'] = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $this->load->model('School_Admin_model');
        $this->load->view('backend/index', $page_data);
    }

    function clinical_history($class_id = '',$section_id = '',$student_id = ''){
         if ($this->session->userdata('doctor_login') != 1)
            redirect(base_url(), 'refresh');
         
        $page_data = $this->get_page_data_var();
        $year = $this->globalSettingsRunningYear;
        if ($class_id != '') {
             $sections = $this->Section_model->get_data_generic_fun('*',array('class_id'=>$class_id),'result_arr');
             $page_data['sections'] = $sections;
        }
        $data = array();
        if ($class_id != '' || $section_id != '') {
            $student_arr = $this->Enroll_model->get_student_array(array('section_id' => $section_id, 'class_id' => $class_id, 'year' => $year));
            foreach ($student_arr as $student):
                $stu_rs = get_data_generic_fun('student', 'student_id, name, lname', array('student_id' => $student['student_id'], 'isActive' => '1', 'student_status' => '1'), 'result_arr');

                if (isset($stu_rs[0])) {
                    $data[] = $stu_rs[0];
                }
            endforeach;
            $page_data['students'] = $data;
        }
      
        $page_data['class_id'] = $class_id;
        $page_data['section_id'] = $section_id;
        $page_data['student_id'] = $student_id;
        $page_data['classes'] = $this->Class_model->get_class_array();
        $page_data['page_name'] = 'clinical_history';
        $page_data['page_title'] = get_phrase('clinical_history');
        $condition = array('student_id' => $student_id);
        $sortArr = array('clinical_history_id' => 'desc');
        $page_data['clinical_history_list'] = $this->Clinical_history_model->get_data_by_cols('*', $condition, 'result_type', $sortArr);
//        pre($page_data['certificate_list']); die;
        $this->load->view('backend/index', $page_data);
    }
    
    function get_student_by_section_class($section_id, $class_id) {
        $running_year = $this->Setting_model->get_year();
        $student_arr = $this->Enroll_model->get_student_array(array('section_id' => $section_id, 'class_id' => $class_id, 'year' => $running_year));
        foreach ($student_arr as $student) {
            $data = get_data_generic_fun('student', 'student_id, name, lname', array('student_id' => $student['student_id'], 'isActive' => '1', 'student_status' => '1', 'result_arr'));
            foreach ($data as $row) {
                echo '<option value="' . $row->student_id . '">' . $row->name . '</option>';
            }
        }
    }
    
    function add_clinical_history($param1 = ''){   
        if ($this->session->userdata('doctor_login') != 1)
            redirect(base_url(), 'refresh');
        
        $doctor_id = $this->session->userdata('doctor_id');
        if($param1 == 'create'){         
            $this->form_validation->set_rules('symptoms', 'Symptoms', 'required');
            $this->form_validation->set_rules('diagnosis', 'Diagnosis', 'required');
            $this->form_validation->set_rules('precription', 'Precription', 'required');
            $this->form_validation->set_rules('start_date', 'Start Date', 'required');
//            pre($this->input->post()); die;
         if ($this->form_validation->run() == TRUE) {
             $class_id  =   $this->input->post('class_id');
             $section_id  =   $this->input->post('section_id');
             $student_id  =   $this->input->post('student_id');
                 $data['symptoms']  =   $this->input->post('symptoms');
                 $data['diagnosis']  =  $this->input->post('diagnosis');
                 $data['prescription'] = $this->input->post('precription');
                 $data['given_by'] =  "Doctor";
                 $data['start_date'] =  $this->input->post('start_date');
                 $data['end_date'] =    $this->input->post('end_date');
                 $data['student_id'] =  $student_id;
                 $data['doctor_id'] =   $doctor_id;
                 $this->Clinical_history_model->add($data);
                 $this->session->set_flashdata("flash_message", get_phrase("data_added_successfully"));
                 redirect(base_url() . 'index.php?doctor/clinical_history/'.$class_id.'/'.$section_id.'/'.$student_id, 'refresh');
         } else{
                 $this->session->set_flashdata('flash_validation_error', validation_errors());
                 redirect(base_url() . 'index.php?doctor/clinical_history/', 'refresh');
         }
       }
        $page_data['classes'] = $this->Class_model->get_class_array();
        $page_data['page_name'] = 'add_clinical_history';
        $page_data['page_title'] = get_phrase('clinical_history');
        $this->load->view('backend/index', $page_data);
    }
    
}
