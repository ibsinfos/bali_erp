<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Parents extends CI_Controller {

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

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model("Setting_model");
        $this->load->model("Student_model");
        $this->load->model("Admin_model");
        $this->load->model("Parent_model");
        $this->load->model("Teacher_model");
        $this->load->library('session');
        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        //$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        //$this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        $this->load->model("Subject_model");
        $this->load->model("Crud_model");
        $this->load->model("Enroll_model");
        $this->load->model("Enquired_students_model");
        $this->load->helper("send_notifications");
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
        $this->session->set_userdata(array(
            'running_year' => $this->globalSettingsRunningYear,
        ));
    }

    /*     * *default functin, redirects to login page if no admin logged in yet** */

    public function index() {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($this->session->userdata('parent_login') == 1)
            redirect(base_url() . 'index.php?admin/dashboard', 'refresh');
    }

    /*     * *ADMIN DASHBOARD** */

    function dashboard() {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
        $this->load->model("Student_model");
        $this->load->model("Crud_model");
        $children_of_parent = array();
        $page_data= $this->get_page_data_var();
        $page_data['page_name'] = 'dashboard';
        $page_data['page_title'] = get_phrase('parent_dashboard');
        $page_data['account_type'] = $this->session->userdata('login_type');
        //Get Setting Records
       
        $fee_structure = $this->Crud_model->get_record('fee_structure', $condition = array('fee_structure_status' => '1'), $field = "fee_structure_id");

        $page_data['fee_structure_id'] = 0;
        if (count($fee_structure)) {
            $page_data['fee_structure_id'] = $fee_structure['fee_structure_id'];
        }
        //pre($children_of_parent);die;
        $parent_id = $this->session->userdata('parent_id');
        $running_year = $this->globalSettingsRunningYear;
        $childrens_of_parent = $this->Student_model->parent_login_child_dashboard($parent_id, $running_year);
        $month = 12;
        $this->load->model('Attendance_model');
        $child_sub = array();
        $attend = array();
        
        $page_data['arrAllLinks'] = $this->session->userdata('arrAllLinks');
        //$childrens_of_parent=$children_of_parent;
        //pre($childrens_of_parent);die;
        if (!empty($childrens_of_parent)) {
            foreach ($childrens_of_parent as $value) {
                $year = explode('-', $running_year);
                $total_days = 0;
                for ($k = 1; $k <= $month; $k++) {
                    //echo $year[0];die;
                    $days = cal_days_in_month(CAL_GREGORIAN, $k, $year[0]);
                    $total_days = $days;
                    $count = 0;
                    for ($i = 1; $i <= $days; $i++) {
                        $timestamp = strtotime($i . '-' . $k . '-' . $year[0]);
                        $attendance = $this->Attendance_model->get_student_attendance_dashboard($value['section_id'], $value['class_id'], $running_year, $timestamp, $value['student_id']);
                        if (!empty($attendance)) {
                            $count++;
                        }
                    }
                    $attendance_percentege = $count / $total_days * 100;
                    $attend[$value['name']][] = round($attendance_percentege, 2);
                }
                $childrens_subject = $this->Subject_model->get_subject_dashboard($value['class_id'], $value['section_id'], $running_year);
                //pre($childrens_subject);
                $child_sub[]['subject'] = $childrens_subject;
            }
        }
        //die;
        //pre($child_sub);die;
        $page_data['subject'] = $child_sub;
        $page_data['student_details'] = $childrens_of_parent;
        $i = 0;
        $NewArray = array();
        foreach ($page_data['student_details'] as $row) {
            $NewArray[$i] = array_merge($row, $page_data['subject'][$i]);
            $i++;
        }
        $page_data['details'] = $NewArray;
        $page_data['attend_percentage'] = $attend;
        $this->load->view('backend/index', $page_data);
    }

    /*     * **MANAGE TEACHERS**** */

    function teacher_list($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data= $this->get_page_data_var();
        if ($param1 == 'personal_profile') {
            $page_data['personal_profile'] = true;
            $page_data['current_teacher_id'] = $param2;
        }
        $this->load->model("Teacher_model");
        $year = $this->globalSettingsRunningYear;
        $teachers_list = $this->Teacher_model->get_data_by_cols('*', array(), 'result_array'); 
        $user_id = $this->session->userdata('parent_id');
        $child = $this->Student_model->get_student_by_parent($user_id);
        if(empty($child)){
            redirect('parent','refresh');
        }
        //$teachers_list;
        $page_data['child_det'] = $child; //pre($child);pre($teachers_list);die();
        $page_data['teachers'] = $teachers_list;
        $page_data['page_name'] = 'teacher';
        $page_data['page_title'] = get_phrase('manage_teacher');
        $this->load->view('backend/index', $page_data);
    }

    // ACADEMIC SYLLABUS
    function academic_syllabus($student_id = '') {
        $arrModule = $this->session->userdata('arrAllLinks');
        //pre($arrModule);die;



        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');

        $this->load->model('Student_model');
        $this->load->model('Enroll_model');
        $this->load->model('Academic_syllabus_model');
        $this->load->model('Class_model');
        $page_data= $this->get_page_data_var();
        $page_data['page_name'] = 'academic_syllabus';
        $page_data['page_title'] = get_phrase('academic_syllabus');
        $page_data['student_id'] = $student_id;
        $year = $this->globalSettingsRunningYear;
        $page_data['student_name'] = $this->Student_model->get_data_by_cols('*', array('student_id' => $student_id), 'result_array'); //get_data_generic_fun('student','name', array('student_id' => $student_id),'result_array');
        $class_id = $this->Enroll_model->get_data_by_cols('*', array('student_id' => $student_id, 'year' => $year), 'result_array'); //get_data_generic_fun('enroll','class_id', array('student_id' => $student_id,'year' => $year),'result_array');
        foreach ($class_id as $row) {
            $syllabus = $this->Academic_syllabus_model->get_data_by_cols('*', array('class_id' => $row['class_id'], 'year' => $year), 'result_array');
            get_data_generic_fun('academic_syllabus', '*', array('class_id' => $row['class_id'], 'year' => $year), 'result_array');
            $page_data['class_name'] = $this->Class_model->get_data_by_cols('name as class_name', array('class_id' => $row['class_id']), 'result_array'); //  get_data_generic_fun('class','name as class_name',array('class_id'=>$row['class_id']),'result_array');
        }
        if (!empty($syllabus)) {
            foreach ($syllabus as $syllabus) {
                $uploader_name = get_data_generic_fun($syllabus['uploader_type'], 'name', array($syllabus['uploader_type'] . '_id' => $syllabus['uploader_id']), 'result_array');
                $i = 0;
                $NewArray = array();
                $NewArray[$i] = array_merge($syllabus, $uploader_name[$i]);
                $i++;
                $page_data['syllabus'][] = $NewArray;
            }
        } else {
            $NewArray = "";
            $page_data['syllabus'][] = $NewArray;
        }
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    function download_academic_syllabus($academic_syllabus_code) {
        $this->load->model("Class_model");
        $file_name = $this->Class_model->get_academic_syllabus_name($academic_syllabus_code);
        $this->load->helper('download');
        $data = file_get_contents("uploads/syllabus/" . $file_name);
        $name = $file_name;
        force_download($name, $data);
    }

    /*     * **EVENT CALENDER**** */

    function event_calender($param1 = '') {
        $this->load->model('Student_model');
        $this->load->model('Exam_model');
         $this->load->model('Event_model');
        $page_data= $this->get_page_data_var();
        $children_of_parent = array();
        $children_of_parent = $this->Student_model->get_data_by_cols('*', array('parent_id' => $this->session->userdata('parent_id')), 'result_array');  //get_data_generic_fun('student','*',array('parent_id'=>$this->session->userdata('parent_id')),'result_array');
       
        foreach ($children_of_parent as $child) {
            $class_id = $this->Student_model->get_class_id_by_student($child['student_id']);
            if (!empty($class_id)) {
                $class_id = $class_id[0]['class_id'];
            }
            $section_id = $this->Student_model->get_section_id_by_student($child['student_id']);
            if (!empty($section_id)) {
                $section_id = $section_id[0]['section_id'];
            }
            //echo '<pre>';print_r($class_id);print_r($section_id);
            if($class_id && $section_id)
                $exams = $this->Exam_model->get_exam_routine(array('class_id' => $class_id, 'section_id' => $section_id));
            else 
                $exams = array();
            $events = array();
            $event = array();
            foreach ($exams as $exam) {
                $exam_name = $this->Exam_model->get_exam_name($exam['exam_id']);
                $subject_name = $this->Subject_model->get_subject_record(array('subject_id' => $exam['subject_id']), "name");
                
                $event['id'] = $exam['exam_routine_id'];
                $event['title'] = $exam_name . ":" . $child['name'] . ":" . $subject_name;
                $event['start'] = $exam['start_datetime'];
                $time = new DateTime($exam['start_datetime']);
                $time->add(new DateInterval('PT' . $exam['duration'] . 'M'));
                $stamp = $time->format('Y-m-d H:i');
                $event['end'] = $stamp;
                $event['description'] = "Room No: " . $exam['room_no'];
                array_push($events, $event);
            }
        }
        /* echo $class_id."</br>";
        //echo $section_id;
        pre($events);
        exit; */
        $this->load->helper("functions");
        $page_data['types'] = $this->Event_model->getEventTypes();
        $page_data['events'] = $events;
        $page_data['page_name'] = 'event_calender';
        $page_data['page_title'] = get_phrase('event_calender');
        $this->load->view('backend/index', $page_data);
    }

    /*     * **MANAGE SUBJECTS**** */

    function subject($param1 = '', $param2 = '') {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
        $this->load->model('Section_model');
        $this->load->model('Enroll_model');
        $page_data= $this->get_page_data_var();
        $year = $this->globalSettingsRunningYear;
        $child_of_parent = $this->Enroll_model->get_data_by_cols('*', array('student_id' => $param1, 'year' => $year, 'result_array'));  //get_data_generic_fun('enroll','*',array('student_id' => $param1 , 'year' => $year,'result_array'));
        if (!empty($child_of_parent)) {
            foreach ($child_of_parent as $row) {
                $this->load->model('enroll_model');
                $class_id = $this->enroll_model->get_class_id_bystudent_id($param1, $year);
                $section_id = $this->enroll_model->get_section_id_bystudent_id($param1, $year);
            }
            if ((!empty($class_id)) && (!empty($section_id))) {
                $this->load->model('Subject_model');
                $page_data['subjects'] = $this->Subject_model->get_subjects_class_section($class_id, $section_id);
            } else {
                $page_data['subjects'] = '';
            }
            //pre($child_of_parent);die;
            $student_name = $this->Student_model->get_data_by_cols('*', array('student_id' => $child_of_parent[0]->student_id)); //get_data_generic_fun('student','name',array('student_id'=>$child_of_parent[0]->student_id));
            //pre($student_name);die;
            $page_data['student_name'] = $student_name[0]->name;
            $student_details = $this->Student_model->get_student_class_section($child_of_parent[0]->student_id);
            if (!empty($student_details)) {
                $page_data['class_name'] = $student_details['class_name'];
                $page_data['section_name'] = $student_details['section_name'];
            }
            $class_teacher = $this->Section_model->get_teachername_by_class_section($class_id, $section_id);
            if (!empty($class_teacher)) {
                $page_data['class_teacher_name'] = $class_teacher[0]['teacher_name'];
                $page_data['class_teacher_email'] = $class_teacher[0]['email'];
            }
        } else {
            $page_data['subjects'] = '';
        }
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['page_name'] = 'subject';
        if (!empty($student_details) || !empty($class_teacher)) {
//            $page_data['page_title'] = get_phrase('manage_subject_for_').$page_data['student_name']."-".get_phrase('class_:_').$page_data['class_name']." ".get_phrase('section_:_').$page_data['section_name'];
            $page_data['page_title'] = get_phrase('manage_subjects-') . $page_data['student_name'];
        } else {
            $page_data['page_title'] = get_phrase('manage_subject');
        }
        $this->load->view('backend/index', $page_data);
    }

    /*     * **MANAGE EXAM MARKS**** */

    function marks($param1 = '', $param2 = '') {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data= $this->get_page_data_var();
        $page_data['student_id'] = $param1;
        $page_data['page_name'] = 'marks';
        $page_data['page_title'] = get_phrase('manage_marks');
        $year = $this->globalSettingsRunningYear;
        $this->load->model("Enroll_model");
        $this->load->model("Student_model");
        $this->load->model("Exam_model");
        $this->load->model("Mark_model");
        $this->load->model("Class_model");
        $child = $this->Enroll_model->get_data_by_cols('*', array('student_id' => $param1, 'year' => $year), 'result_arr'); //get_data_generic_fun('enroll','*',array('student_id'=>$param1,'year'=>$year),'result_arr');
        //echo '<pre>'; print_r($child); exit;
        $student_name = $this->Student_model->get_data_by_cols('*', array('student_id' => $param1), 'result_arr'); //get_data_generic_fun('student','name',array('student_id'=>$param1),'result_arr');
        $i = 0;
        $NewArray = array();
        foreach ($child as $value) {
            $NewArray[$i] = array_merge($value, $student_name[$i]);
            $i++;
        }

        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['child_of_parent'] = $NewArray;
        $page_data['exams'] = $this->Exam_model->get_data_by_cols('*', array('year' => $year), 'result_arr'); //get_data_generic_fun('exam','*',array('year'=>$year),'result_arr');
        $page_data['classes'] = $this->Class_model->get_data_by_cols('*', array(), 'result_arr');
        $page_data['marks'] = array();        
        if (!empty($page_data['exams']) && $param2 == '') {
            $param2 = $page_data['exams'][0]['exam_id'];
        }

        $page_data['marks'] = $this->Mark_model->get_current_year_mark_with_exam_id_student_id($param2, $param1, $year);  //get_data_generic_fun('mark','*',array('exam_id'=>$param2,'student_id'=>$param1,'year'=>$year),'result_arr');
        $page_data['exam_id'] = $param2;

        $this->load->view('backend/index', $page_data);
    }

    
    function student_marksheet_print_view($student_id, $exam_id) {
        if ($this->session->userdata('parent_login') != 1)
            redirect('login', 'refresh');
        $page_data= $this->get_page_data_var();
        $this->load->model("Student_model");
        $this->load->model("Subject_model");
        $this->load->model("Exam_model");
        $this->load->model("Mark_model");
        $studentDataArr = $this->Student_model->get_student_class_section($student_id);
        $subjectDataArr = $this->Subject_model->get_c_year_details_by_class($studentDataArr['class_id'], $this->globalSettingsRunningYear);
        $examDetails = $this->Exam_model->get_data_by_id($exam_id);
        if (empty($examDetails)) {
            $this->session->set_flashdata('flash_message_error', "invalid exam index.");
            redirect('parent/marks/' . $student_id, 'refresh');
        }
        $this->load->model('Mark_model');
        $this->load->model('Crud_model');
        $total_mark = 0;
        $newSubjectArr = array();
        $total_grade_point = 0;
        foreach ($subjectDataArr AS $k => $v) {
            $markObtainedArr = $this->Mark_model->get_c_year_mark_obtained_by_subject_exam_class($v['subject_id'], $exam_id, $studentDataArr['class_id'], $student_id, $this->globalSettingsRunningYear);
            //pre($markObtainedArr);die;
            if (!empty($markObtainedArr)) { //pre("mark here");
                $v['mark_obtained'] = $markObtainedArr[0]['mark_obtained'];
                $total_mark += (int) $v['mark_obtained'];
                $v['comment'] = $markObtainedArr[0]['comment'];
                //pre("totatl mark ".$total_mark);
            } else {
                $v['mark_obtained'] = 0;
                $v['comment'] = "";
            }
            //pre($v['mark_obtained']); 
            //pre($exam_id." == ".$studentDataArr['class_id']." == ".$v['subject_id']);die;
            $highest_mark = $this->Crud_model->get_highest_marks($exam_id, $studentDataArr['class_id'], $v['subject_id']);
            //pre($highest_mark);die;
            $v['heighest_mark'] = $highest_mark;
            if ($v['mark_obtained'] >= 0 || $v['mark_obtained'] != '') {
                $grade = $this->Crud_model->get_grade($v['mark_obtained']);
                $v['grade_name'] = $grade['name'];
                $total_grade_point += $grade['grade_point'];
            } else {
                $v['grade_name'] = "";
            }
            
            $newSubjectArr[] = $v;
        }
        //echo '=='.$total_mark;die;
        $number_of_subjects = $this->Subject_model->get_c_year_total_subject_by_class($studentDataArr['class_id'], $this->globalSettingsRunningYear);
        $page_data['number_of_subjects'] = $number_of_subjects;
        $page_data['total_grade_point'] = $total_grade_point;
        $page_data['total_marks'] = $total_mark;
        $page_data['examDetails'] = $examDetails;
        $page_data['studentDataArr'] = $studentDataArr;
        $page_data['system_name'] = $this->globalSettingsSystemName;
        $page_data['running_year'] = $this->globalSettingsRunningYear;
        $page_data['subjects'] = $newSubjectArr;
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['student_id'] = $student_id;
        $page_data['class_id'] = $studentDataArr['class_id'];
        $page_data['exam_id'] = $exam_id;
        $this->load->view('backend/parent/student_marksheet_print_view', $page_data);
    }

    /*     * ********MANAGING CLASS ROUTINE***************** */

    function class_routine($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data= $this->get_page_data_var();
        $this->load->model("Class_routine_model");
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['student_id'] = $param1;
        $student_details = $this->Class_routine_model->get_c_year_studnet_details_by_student_id($param1, $this->globalSettingsRunningYear);
        if (empty($student_details)) {
            redirect('parent', 'refresh');
        }
        //pre($student_details);die;
        $daysArr = array("sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday");
        $main_class_routin_data_arr = array();
        foreach ($daysArr AS $k) {
            $class_routin_data = $this->Class_routine_model->get_c_year_details_by_day_section($k, $student_details[0]['class_id'], $student_details[0]['section_id'], $this->globalSettingsRunningYear);
            $main_class_routin_data_arr[$k] = $class_routin_data;
        }
       
        $page_data['student_details'] = $student_details;
        $page_data['class_routine_data'] = $main_class_routin_data_arr;
        $page_data['page_name'] = 'class_routine';
        $page_data['page_title'] = get_phrase('manage_class_routine');
        $this->load->view('backend/index', $page_data);
    }

    function class_routine_print_view($param1) {
        if ($this->session->userdata('parent_login') != 1)
            redirect('login', 'refresh');
        $page_data= $this->get_page_data_var();
        $this->load->model("Class_routine_model");
        $student_details = $this->Class_routine_model->get_c_year_studnet_details_by_student_id($param1, $this->globalSettingsRunningYear);
        if (empty($student_details)) {
            redirect('parent', 'refresh');
        }

        //pre($student_details);die;
        $daysArr = array("sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday");
        $main_class_routin_data_arr = array();
        foreach ($daysArr AS $k) {
            $class_routin_data = $this->Class_routine_model->get_c_year_details_by_day_section($k, $student_details[0]['class_id'], $student_details[0]['section_id'], $this->globalSettingsRunningYear);
            $main_class_routin_data_arr[$k] = $class_routin_data;
        }
        //pre($main_class_routin_data_arr);
        //die;
        $page_data['student_details'] = $student_details;
        $page_data['class_routine_data'] = $main_class_routin_data_arr;
        $page_data['class_id'] = $student_details[0]['class_id'];
        $page_data['section_id'] = $student_details[0]['section_id'];
        $page_data['system_name'] = $this->globalSettingsSystemName;
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/parent/class_routine_print_view', $page_data);
    }

    /*     * **MANAGE PROGRESS REPORT**** */

    function progress_report($param1 = '') {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data= $this->get_page_data_var();
        $student_details = $this->Student_model->get_student_class_section($param1, $this->globalSettingsRunningYear);
        if (empty($student_details)) {
            redirect('parent', 'refresh');
        }
        $student_details['student_id'] = $param1;
        $this->load->model("Subject_model");
        $this->load->model("Progress_model");
        $year = $this->globalSettingsRunningYear;
        //pre($student_details);die;
        $section_id = $student_details['section_id'];
        $class_id = $student_details['class_id'];
        $subjectArr = $this->Subject_model->get_subject_array(array('class_id' => $class_id, 'section_id' => $section_id));
        $subjectwise_progress_report = array();
        foreach ($subjectArr AS $k => $v) {
            //pre($v);die;
            $progress_report = $this->Progress_model->get_progress_report($param1, $v['subject_id']);
            $v['progress_report'] = $progress_report;
            $subjectwise_progress_report[] = $v;
        }
        //pre($subjectwise_progress_report);die;
        $page_data['subjects'] = $subjectArr;
        //$subejctArr=$this->Progress_model->get_progress_report_class($param1, $class_id,$section_id);
        //pre($subejctArr);die;
        $page_data['subjects'] = $subjectwise_progress_report;

        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['student_details'] = $student_details;
        $page_data['student_id'] = $param1;
        $page_data['student_name'] = $student_details['student_name'];
        $page_data['page_name'] = 'progress_report';
        $page_data['page_title'] = get_phrase('progress_report');
        $this->load->view('backend/index', $page_data);
    }

    /*     * **MANAGE PROGRESS REPORT HEADING**** */

    function progress_report_heading_wise($param1 = '',$selected_heading='',$selected_term='') {

        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data= $this->get_page_data_var();
        $year = $this->globalSettingsRunningYear;
        $student_details = $this->Student_model->get_student_class_section($param1, $this->globalSettingsRunningYear);
        if (empty($student_details)){
            redirect('parent', 'refresh');
        }
        $this->load->model('Report_term_model');
        $this->load->model('Progress_report_heading_model');
        $this->load->model('Student_progress_report_model');
        $this->load->model('Progress_report_category_model');
        $this->load->model('Progress_report_sub_category_model');
        $student_details['student_id'] = $param1;
        $class_id = $student_details['class_id']; //get_data_generic_fun('enroll', 'class_id', array('student_id' => $param1, 'year' => $year), 'result_arr');
        $page_data['class_itotal_notif_numd'] = $class_id;
        $page_data['term_list'] = $this->Report_term_model->get_list();
        $heading = $this->Teacher_model->get_heading($class_id);
        $page_data['selected_term']  = $selected_term;
        $page_data['selected_heading']  = $selected_heading;
        $page_data['headings'] = $heading;
        $page_data['row_count'] = $this->Student_progress_report_model->nums_of_report_by_student($param1);
        $page_data['progress_report_detail'] = $this->Student_progress_report_model->progress_report_detail($class_id,$param1,$selected_term,$selected_heading);        
//        pre($page_data['progress_report_detail']); die;
        $student_name = $student_details['student_name'];
        $page_data['student_name'] = $student_name;
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['student_id'] = $param1;

        $page_data['class_id'] = $class_id;
        $page_data['page_name'] = 'progress_report_heading_wise';
        $page_data['system_name'] = $this->globalSettingsSystemName;
        $page_data['page_title'] = get_phrase('progress_report_detail');
        $this->load->view('backend/index', $page_data);
    }

    /*     * **MANAGE ADMISSION**** */

    function admission_form($param1 = '', $param2 = '') {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
         $page_data= $this->get_page_data_var();
        $this->load->model("Enquired_students_model");
        $this->load->model("Class_model");
        $this->load->library('upload');
        $this->load->helper(array('form', 'url'));
        $this->load->model("Guardian_model");

        $enquiry = $this->Enquired_students_model->get_student_details($param1);
        if ($enquiry['form_submitted'] == 1) {
            // $page_data['subjects']=$this->Subject_model->get_subject_array(array('section_id' =>$section_id));
            $page_data['student_id'] = $param1;
            $page_data['page_name'] = 'admission_form_notice';
            $page_data['page_title'] = get_phrase('admission_form');

            $page_data['total_notif_num'] = $this->get_no_of_notication();
            $this->load->view('backend/index', $page_data);
        } else {
            $form_name = $this->input->post('admit_student');
            if ($form_name == 'admit_student1') {
                $parent_details['father_qualification'] = $this->input->post('education');
                $parent_details['father_school'] = $this->input->post('school');
                $parent_details['father_profession'] = $this->input->post('occupation');
                $parent_details['father_department'] = $this->input->post('department');
                $parent_details['father_designation'] = $this->input->post('designation');
                $parent_details['father_income'] = $this->input->post('annual_income');

                $parent_details['mother_quaification'] = $this->input->post('mother_education');
                $parent_details['mother_school'] = $this->input->post('mother_school');
                $parent_details['mother_profession'] = $this->input->post('mother_occupation');
                $parent_details['mother_department'] = $this->input->post('mother_department');
                $parent_details['mother_designation'] = $this->input->post('mother_designation');
                $parent_details['mother_income'] = $this->input->post('mother_annual_income');
                $parent_details['mother_email'] = $this->input->post('mother_email_id');
                $parent_details['mother_mobile'] = $this->input->post('mother_user_mobile');

                $student_details['medical_pblm_reason'] = $this->input->post('reason');
                $parent_details['address'] = $this->input->post('address');

                $stud_img = $_FILES['userfile']['name'];
                $student_details['stud_image'] = $stud_img;
                $student_details['emergency_contact_number'] = $this->input->post('emergency');
                $student_details['family_type'] = $this->input->post('family');
                $student_details['medical_pblm'] = $this->input->post('medical');
                $student_details['change_time'] = date('Y-m-d H:i:s');

                //$num_rows = $this->input->post('num_rows');
                //echo $num_rows; exit;
                //$row = $num_rows - 1; echo $row;
                for ($i = 1; $i <= 3; $i++) {
                    $siblings_details['student_id'] = $param1;
                    $siblings_details['name'] = $this->input->post('name_sibling');
                    $siblings_details['age'] = $this->input->post('age');
                    $siblings_details['school'] = $this->input->post('school_name');
                    $siblings_details['class'] = $this->input->post('class');
                    $siblings_details['create_time'] = date('Y-m-d H:i:s');
                }

                //add Guardian details
                $data_guardian['guardian_fname'] = $this->input->post('guardian_fname');
                $data_guardian['guardian_lname'] = $this->input->post('guardian_lname');
                //$data_guardian['guardian_profession'] = $this->input->post('guardian_profession');
                $data_guardian['guardian_address'] = $this->input->post('guardian_address');
                $data_guardian['guardian_email'] = $this->input->post('guardian_email');
                $data_guardian['guardian_emergency_number'] = $this->input->post('emergency_contact');
                $data_guardian['guardian_isActive'] = '1';
                $data_guardian['student_id'] = $param1;
                $data_guardian['guardian_change_date'] = date('Y-m-d H:i:s');

                $this->Enquired_students_model->save_siblings($siblings_details);
                $condition = array('parent_id' => $this->session->userdata('parent_id'));

                if ($this->Parent_model->update_parent_of_students_enquired($parent_details, $condition)) {
                    $this->Enquired_students_model->update_enquiry(array('form_submitted' => '1'), array('student_id' => $param1));
                    $this->Guardian_model->update_guardian($data_guardian, $condition);
                    $this->Student_model->update_student($student_details, array("student_id" => $param1));
                    move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/admitted_students/' . $param1 . '.jpg');
                    $this->session->set_flashdata('flash_message', get_phrase('changes_saved_successfully'));
                    redirect(base_url() . 'index.php?parents/admission_form/' . $param1, 'refresh');
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('changes_are_not_saved'));
                }
            }
            //$page_data['subjects']=$this->Subject_model->get_subject_array(array('section_id' =>$section_id));
            $student_data = $this->Enquired_students_model->get_student_details($param1);
            if (!empty($student_data)) {
                if ($student_data['previous_class '] != "-10") {
                    $classData = $this->Class_model->get_data_by_id($student_data['previous_class ']);
                    $page_data['prev_class_name'] = $classData[0]->name;
                } else {
                    $page_data['prev_class_name'] = "N/A";
                }

                if ($student_data['class_id'] != "") {
                    $classData = $this->Class_model->get_data_by_id($student_data['previous_class ']);
                    $page_data['class_name'] = $classData[0]->name;
                } else {
                    $page_data['class_name'] = "";
                }
            } else {
                $page_data['prev_class_name'] = "N/A";
                $page_data['class_name'] = "";
            }
            $page_data['student_data'] = $student_data;
            $page_data['student_id'] = $param1;
            $page_data['page_name'] = 'admission_form';
            $page_data['page_title'] = get_phrase('admission_form');

            $page_data['total_notif_num'] = $this->get_no_of_notication();
            $this->load->view('backend/index', $page_data);
            /*
              $this->load->view('backend/index', $page_data);
              }else{
              $form_name = $this->input->post('admit_student');
              if($form_name == 'admit_student1'){
              $parent_details['father_qualification']=$this->input->post('education');
              $parent_details['father_school']=$this->input->post('school');
              $parent_details['father_profession']=$this->input->post('occupation');
              $parent_details['father_department']=$this->input->post('department');
              $parent_details['father_designation']=$this->input->post('designation');
              $parent_details['father_income']=$this->input->post('annual_income');

              $parent_details['mother_quaification']=$this->input->post('mother_education');
              $parent_details['motehr_school']=$this->input->post('mother_school');
              $parent_details['mother_profession']=$this->input->post('mother_occupation');
              $parent_details['mother_department']=$this->input->post('mother_department');
              $parent_details['mother_designation']=$this->input->post('mother_designation');
              $parent_details['mother_income']=$this->input->post('mother_annual_income');
              $parent_details['mother_email']=$this->input->post('mother_email_id');
              $parent_details['mother_mobile']=$this->input->post('mother_user_mobile');

              $student_details['medical_pblm_reason']=$this->input->post('reason');
              $parent_details['address']=$this->input->post('address');

              $stud_img = $_FILES['userfile']['name'];
              $student_details['stud_image'] = $stud_img;
              $student_details['emergency_contact_number']=$this->input->post('emergency');
              $student_details['family_type']=$this->input->post('family');
              $student_details['medical_pblm']=$this->input->post('medical');
              $student_details['change_time'] = date('Y-m-d H:i:s');

              //$num_rows = $this->input->post('num_rows');
              //echo $num_rows; exit;
              //$row = $num_rows - 1; echo $row;
              for ($i = 1; $i <= 3; $i++) {
              $siblings_details['student_id'] = $param1;
              $siblings_details['name'] = $this->input->post('name_sibling');
              $siblings_details['age'] = $this->input->post('age');
              $siblings_details['school'] = $this->input->post('school_name');
              $siblings_details['class']=$this->input->post('class');
              $siblings_details['create_time'] = date('Y-m-d H:i:s');

              }

              $this->Enquired_students_model->save_siblings($siblings_details);
              $condition = array('parent_id'=>$this->session->userdata('parent_id'));
              if($this->Parent_model->update_parent_of_students_enquired($parent_details,$condition)){
              $this->Enquired_students_model->update_enquiry(array('form_submitted'=>'1'),array('student_id'=>$param1));
              $this->Student_model->update_student($student_details, array("student_id"=>$param1));
              move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/admitted_students/' . $param1 . '.jpg');
              $this->session->set_flashdata('flash_message', get_phrase('changes_saved_successfully'));
              redirect(base_url() . 'index.php?parents/admission_form/'.$param1,'refresh');
              }else{
              $this->session->set_flashdata('flash_message_error', get_phrase('changes_are_not_saved'));
              }
              }
              $page_data['subjects']=$this->Subject_model->get_subject_array(array('section_id' =>$section_id));
              $page_data['student_data'] = $this->Enquired_students_model->get_student_details($param1);
              $page_data['student_id'] = $param1;
              $page_data['page_name']  = 'admission_form';
              $page_data['page_title'] = get_phrase('admission_form');
              $this->load->view('backend/index', $page_data); */
        }
    }
    
    /*     * ********MANAGE LIBRARY / BOOKS******************* */

    function book($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('parent_login') != 1)
            redirect('login', 'refresh');
         $page_data= $this->get_page_data_var();
        $books = $this->Book_model->get_data_by_cols('*', array(), 'result_array');
        $class_names = array();
        $class_ids_all = array();
        if (!empty($books)) {
            foreach ($books as $row) {
                if (!empty($row['class_id'])) {
                    $class_names = $this->Book_model->get_data_by_cols('name', array('class_id' => $row['class_id']), 'result_array');
                    if (!empty($class_names)) {
                        $class_ids_all[]['class_name'] = $class_names[0]['name'];
                    }
                } else {
                    $class_ids_all[]['class_name'] = "";
                }
                // print_r($class_ids_all);
            }
            $i = 0;
            $NewArray = array();
            foreach ($books as $value) {
                $NewArray[$i] = array_merge($value, $class_ids_all[$i]);
                $i++;
            }
            $page_data['books'] = $NewArray;
        } else {
            $page_data['books'] = "";
        }
        $page_data['page_name'] = 'book';
        $page_data['page_title'] = get_phrase('manage_library_books');

        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    /*     * ********MANAGE TRANSPORT / VEHICLES / ROUTES******************* */

    function transport($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('parent_login') != 1)
            redirect('login', 'refresh');
         $page_data= $this->get_page_data_var();
        if ($param1 == "") {
            redirect('parent', 'refresh');
        }
        $this->load->model('Student_bus_allocation_model');
        $this->load->model('Student_model');
        $this->load->model('Route_bus_stop_model');
        $this->load->model('Bus_model');
        $this->load->model('Transport_model');
        $newArray = array();
        $detail = $this->Student_bus_allocation_model->get_data_by_cols('*', array('student_id' => $param1), 'result_array');
        if (!empty($detail)) {
            foreach ($detail as $row) {
                $name = $this->Student_model->get_data_by_cols('name,stud_image', array('student_id' => $row['student_id']), 'result_array');
                if (!empty($name)) {
                    $student_name[]['student_name'] = $name[0]['name'];
                    $student_image[]['student_image'] = $this->Crud_model->get_image_url('student', $row['student_id']);
                } else {
                    $student_name[]['student_name'] = "";
                }
                if(!empty($row['bus_stop_id']))//Archana Done
                $route = $this->Route_bus_stop_model->get_data_by_cols('route_from,route_to,no_of_stops,route_fare', array('route_bus_stop_id' => $row['bus_stop_id']), 'result_array');
                if (!empty($route)) {
                    $route_from[]['route_from'] = $route[0]['route_from'];
                    $route_to[]['route_to'] = $route[0]['route_to'];
                    $no_of_stops[]['no_of_stops'] = $route[0]['no_of_stops'];
                    $route_fare[]['route_fare'] = $route[0]['route_fare'];
                } else {
                    $route_from[]['route_from'] = "";
                    $route_to[]['route_to'] = "";
                    $no_of_stops[]['no_of_stops'] = "";
                    $route_fare[]['route_fare'] = "";
                }
                $bus = $this->Bus_model->get_data_by_cols('name as bus_name', array('bus_id' => $row['bus_id']), 'result_array');
                if (!empty($bus)) {
                    $bus_name[]['bus_name'] = $bus[0]['bus_name'];
                } else {
                    $bus_name[]['bus_name'] = "";
                }
                $route_name = $this->Transport_model->get_data_by_cols('route_name', array('transport_id' => $row['route_id']), 'result_array');
                if (!empty($route_name)) {
                    $route_name[]['route_name'] = $route_name[0]['route_name'];
                } else {
                    $route_name[]['route_name'] = "";
                }
            }
            $i = 0;
            $newArray = array();
            foreach ($detail as $value) {
                $newArray[$i] = array_merge($value, $student_name[$i], $student_image[$i], $route_from[$i], $route_to[$i], $no_of_stops[$i], $route_fare[$i], $bus_name[$i], $route_name[$i]);
                $i++;
            }
        }
        $page_data['details'] = $newArray;
        $page_data['page_name'] = 'transport';
        $page_data['page_title'] = get_phrase('manage_transport');

        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    /*     * ********MANAGE DORMITORY / HOSTELS / ROOMS ******************* */

    function dormitory($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('parent_login') != 1)
            redirect('login', 'refresh');
         $page_data= $this->get_page_data_var();
        $this->load->model('Dormitory_model');
        $dormitories= $this->Dormitory_model->get_data_by_cols('*',array(),'result_array');
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['dormitories'] = $dormitories;
        $page_data['page_name'] = 'dormitory';
        $page_data['page_title'] = get_phrase('manage_dormitory');
        $this->load->view('backend/index', $page_data);
    }

    /*     * ********WATCH NOTICEBOARD AND EVENT ******************* */

    function noticeboard($param1 = '', $param2 = '') {
        if ($this->session->userdata('parent_login') != 1)
            redirect('login', 'refresh');
          $page_data= $this->get_page_data_var();
        $this->load->model("Notification_model");
        $parent_id = $this->session->userdata('parent_id');
        if($param1!=''){            
           $page_data['student_name'] = $this->Student_model->get_student_name($param1);
           $class_id = $this->Student_model->get_class_id_by_student($param1);
           $page_data['notices'] = $this->Notification_model->getNotices_for_parents($param1,$class_id[0]['class_id']);        
        }else{
            $children_of_parent = $this->Student_model->get_data_by_cols('*', array('parent_id' => $parent_id), 'result_array'); 
            $student_id                =   $children_of_parent[0]['student_id'];
            $page_data['student_name'] = $this->Student_model->get_student_name($student_id);
            $class_id = $this->Student_model->get_class_id_by_student($student_id);
            $page_data['notices'] = $this->Notification_model->getNotices_for_parents($student_id,$class_id[0]['class_id']);        
        }           
        
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['page_name'] = 'noticeboard';
        $page_data['page_title'] = get_phrase('noticeboard');
        $this->load->view('backend/index', $page_data);
    }

    /*     * ********MANAGE DOCUMENT / home work FOR A SPECIFIC CLASS or ALL****************** */

    function document($do = '', $document_id = '') {
        if ($this->session->userdata('parent_login') != 1)
            redirect('login', 'refresh');
         $page_data= $this->get_page_data_var();
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['page_name'] = 'manage_document';
        $page_data['page_title'] = get_phrase('manage_documents');
        $this->load->model('Document_model');
        $documents= $this->Document_model->get_data_by_cols('*',array(),'result_array');
        $page_data['documents'] = $documents;
        $this->load->view('backend/index', $page_data);
    }

    /* private messaging */

    function message($param1 = 'message_home', $param2 = '', $param3 = '') {
        $this->load->model('Message_model');
        $this->load->model('School_Admin_model');
        if ($this->session->userdata('parent_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
         $page_data= $this->get_page_data_var();

        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
        }

        if ($param1 == 'send_new') {
            $message_thread_code = $this->Crud_model->send_new_private_message_admin();
            //$this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?parents/message/message_read/' . $message_thread_code, 'refresh');
        }

        if ($param1 == 'send_reply') {
            $this->Crud_model->send_reply_message($param2);  //$param2 = message_thread_code
            //$this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?parents/message/message_read/' . $param2, 'refresh');
        }
        if ($param1 == 'message_new') {            
            //$page_data['admins'] = $this->School_Admin_model->get_data_by_cols('*', array('status' => '1', 'school_id' => $school_id), 'result_array', array('name'=>'asc'));

            $this->load->model('School_Admin_model');
            $page_data['admins'] = $this->School_Admin_model->get_school_admin();
            
            $page_data['teachers'] = $this->Teacher_model->get_data_by_cols( '*', array('isActive' => '1', 'teacher_status' => '1', 'school_id' => $school_id), 'result_array', array('name'=>'asc'));
            /*$page_data['students'] = $this->Student_model->get_data_by_cols( '*', array(), 'result_array');
            $page_data['parents'] = $this->Parent_model->get_data_by_cols( '*', array(), 'result_array');*/
        }

        if ($param1 == 'message_read') {
            
            $page_data['current_message_thread_code'] = $param2;  // $param2 = message_thread_code
            $this->Crud_model->mark_thread_messages_read($param2, $school_id);
            $page_data['messages'] = $this->Message_model->get_data_by_cols('*', array('message_thread_code' => $param2, 'message_status' => 'All', 'school_id' => $school_id), 'result_array');
            $parent = array();
            $parent_all = array();
            $i = 0;
            $NewArray = array();
            $img_user = array();
            foreach ($page_data['messages'] as $message) {
                $sender = explode('-', $message['sender']);
                $sender_account_type = $sender[0];
                $sender_id = $sender[1];
//                $img_user[]['image'] = $this->Crud_model->get_image_url($sender_account_type, $sender_id);

                $model_name = ucfirst($sender_account_type . '_model');

                if ($sender_account_type == 'teacher') {
                    $parent = get_data_generic_fun($sender_account_type, "name,teacher_image", array($sender_account_type . '_id' => $sender_id), 'result_array');
                    if (!empty($parent)) {
                        $user_all[]['name'] = $parent[0]['name'];

                        if($parent[0]["teacher_image"]!=''){
                            $image[]['image'] = "teacher_image/" . $parent[0]["teacher_image"];
                        }else{
                            $image[]['image'] = "user.png";
                        }
                    } else {
                        $user_all[]['name'] = "";
                        $image[]['image'] = "user.png";
                    }
                } else if ($sender_account_type == 'parent') {

                    $parent = get_data_generic_fun($sender_account_type, 'father_name,parent_image', array($sender_account_type . '_id' => $sender_id), 'result_array');
                    if (!empty($parent)) {
                        $user_all[]['name'] = $parent[0]['father_name'];

                        if($parent[0]["parent_image"]!=''){
                            $image[]['image'] = "parent_image/" . $parent[0]["parent_image"];
                        }else{
                            $image[]['image'] = "user.png";
                        }
                    } else {
                        $user_all[]['name'] = "";
                        $image[]['image'] = "user.png";
                    }
                } else {
                    $parent = get_data_generic_fun($sender_account_type, 'name,profile_pic', array($sender_account_type . '_id' => $sender_id), 'result_array');
                    if (!empty($parent)) {
                        $user_all[]['name'] = $parent[0]['name'];

                        if($parent[0]["profile_pic"]!=''){
                            $image[]['image'] = "sc_admin_images/" . $parent[0]["profile_pic"];
                        }else{
                            $image[]['image'] = "user.png";    
                        }
                    } else {
                        $user_all[]['name'] = "";
                        $image[]['image'] = "user.png";
                    }
                }
                $NewArray[$i] = array_merge($message, $user_all[$i], $image[$i]);
                $i++;
            }
            $page_data['message'] = $NewArray;
        }

        if ($param1 == 'delete') {
            $this->load->model('Message_model');
            $parent_deleted  =   "parent_deleted";
            $delete_message = $this->Message_model->delete_msg_thread($param2,$parent_deleted);
            $thread_code = $this->Message_model->get_data_by_cols("*", array('message_id'=>$param2), "res_arr");
            if(!empty($thread_code)){
                $thread_code    =   $thread_code[0]['message_thread_code'];
            }
            else{
                $thread_code    =   "";
            }
            if ($delete_message) {
                //$this->session->set_flashdata('flash_message', get_phrase('message_deleted!'));
                redirect(base_url() . 'index.php?parents/message/message_read/' . $thread_code, 'refresh');
            } else {
                //$this->session->set_flashdata('flash_message_error', get_phrase('could_not_delete!'));
                redirect(base_url() . 'index.php?parents/message/message_read/' . $thread_code, 'refresh');
            }
        }
        $i=0;
        $page_data['current_user'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $current_user_threads = $this->Message_model->get_message_threads_parent($page_data['current_user']);
        foreach($current_user_threads as $key => $row){
          if($row['reciever'] == $page_data['current_user']){
                $model=$row['sender'];
                $models = explode('-', $model);
                if(!empty($models[0])){
                    $table_name     =   $models[0];
                    $model_name = ucfirst($models[0] . "_model");

                    if($models[0] == 'school_admin'){
                        $model_name = 'School_Admin_model';
                    }

                    $receiver_id    =   $models[1];
                }
            }
            else{
                $model=$row['reciever'];
                $models = explode('-', $model);
                if(!empty($models[0])){
                    $table_name     =   $models[0];                    
                    $model_name = ucfirst($models[0] . "_model");

                    if($models[0] == 'school_admin'){
                        $model_name = 'School_Admin_model';
                    }

                    $receiver_id = $models[1];
                }
            }
            
            $this->load->model($model_name);
            $details    =   $this->$model_name->get_data_by_cols('*',array($table_name.'_id'=>$receiver_id),'result_array');   
            $current_user_threads[$key] = array_merge($row,$details[$i]);
        }
        foreach ($current_user_threads as $key => $thread) {
            $thread['msgCount'] = $this->Crud_model->count_unread_message_of_thread($thread['message_thread_code'], $school_id);
            $current_user_threads[$key]['unread_msg'] = $thread['msgCount'];
        }
        $page_data['current_user_threads'] = $current_user_threads;
        $page_data['message_inner_page_name'] = $param1;
        $page_data['page_name'] = 'message';
        $page_data['page_title'] = get_phrase('message_board');
        $page_data['total_notif_num'] = $this->get_no_of_notication();

        $page_data['current_thread'] = $param2;

        if(($param1=='message_read') && ($param2!='') && ($param3=='ajax')){
            $this->load->view('backend/parent/message_ajax', $page_data);
        }else{
            $this->load->view('backend/index', $page_data);
        } 
    }

    /*     * ****MANAGE OWN PROFILE AND CHANGE PASSWORD** */

    function manage_profile($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
         $page_data= $this->get_page_data_var();
        $parent_id = $this->session->userdata('parent_id');
        if ($param1 == 'update_profile_info') {
            $data['father_name'] = $this->input->post('name');
            $data['email'] = $this->input->post('email');
            $file_name = $_FILES['userfile']['name'];

            $types = array('image/jpeg', 'image/gif', 'image/png');
            if ($file_name != '') {
                if (in_array($_FILES['userfile']['type'], $types)) {
                    $ext = explode(".", $file_name);
                    $data['parent_image'] = "parent_" . $parent_id . "." . end($ext);

                    if ($this->Parent_model->update_parent($data, array('parent_id' => $parent_id))) {
                        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/parent_image/' . $data['parent_image']);
                        $this->session->set_flashdata('flash_message', get_phrase('account_updated'));
                    }
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('It may be the wrong filetype. We only allow JPG, GIF, and PNG filetypes!!'));
                    // redirect(base_url() . 'index.php?student/manage_profile/', 'refresh');
                }
            } else {
                $this->Parent_model->update_parent($data, array('parent_id' => $parent_id));
            }
            redirect(base_url() . 'index.php?parents/manage_profile/', 'refresh');
        }
        if ($param1 == 'change_password') {
            $data['password'] = sha1($this->input->post('password'));
//            $data['new_password']       = sha1($this->input->post('new_password'));
//            $data['confirm_new_password'] = sha1($this->input->post('confirm_new_password'));
            if (substr($this->input->post('new_password'), 0, 3) == "spa") {
                $data['new_password'] = sha1($this->input->post('new_password'));
                $data['confirm_new_password'] = sha1($this->input->post('confirm_new_password'));
                $data['passcode'] = $this->input->post('new_password');
            } else {
                $data['new_password'] = sha1("spa" . $this->input->post('new_password'));
                $data['confirm_new_password'] = sha1("spa" . $this->input->post('confirm_new_password'));
                $data['passcode'] = "spa" . $this->input->post('new_password');
            }
            $passwordArr= $this->Parent_model->get_data_by_cols("*",array('parent_id' => $this->session->userdata('parent_id')));
            $current_password = $passwordArr[0]->password; 
            $this->globalSettingsSystemName = $this->globalSettingsSystemName;

            if ($current_password == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {
                $this->Parent_model->update_parent(array('password' => $data['new_password'], 'passcode' => $data['passcode']),array('parent_id'=>$this->session->userdata('parent_id')));
                $parent_id = $this->session->userdata('parent_id');
                $parentDataArr = get_data_generic_fun('parent', 'cell_phone,father_name,passcode,email', array('parent_id' => $parent_id));
                $parent = $parentDataArr[0];
                $message = "Mr " . $parent->father_name . " your change of passcode is " . $parent->passcode;
                $phone_number = array($parent->cell_phone);
                if ($phone_number != "") {
                    send_school_notification('update_passcode', $message, $phone_number);
                }
                if ($parent->email != "") {
                    $subject = "Passcode Updated for " . $this->globalSettingsSystemName;
                    $body = $message;
                    $to_name = $parent->father_name . "(" . $parent->email . ")";

                    $message = array(
                        'subject' => $subject,
                        'messagge_body' => $body,
                        'to_name' => $to_name
                    );
                    $email = array($parent->email);
                    send_school_notification('update_passcode', $message, '', $email);
                }
                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('password_mismatch'));
            }
            redirect(base_url() . 'index.php?parents/manage_profile/', 'refresh');
        }

        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['page_name'] = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data'] = get_data_generic_fun('parent', '*', array('parent_id' => $parent_id), 'result_array');
        $this->load->view('backend/index', $page_data);
    }

    function ajax_check_unread_message() {
        $cUserId = $this->input->post('cUserId', TRUE);
        $content = get_unread_message($cUserId, 'parents');
        echo $content;
        die;
    }

    function attendance_report($student_id) {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($student_id == "")
            redirect(base_url(), 'refresh');
         $page_data= $this->get_page_data_var();
        $studentDataArr = $this->Student_model->get_student_class_section($student_id);
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['class_id'] = $studentDataArr['class_id'];
        $page_data['section_id'] = $studentDataArr['section_id'];
        $page_data['section_name'] = $studentDataArr['section_name'];
        $page_data['class_name'] = $studentDataArr['class_name'];
        $page_data['student_id'] = $student_id;
        $page_data['month'] = date('m');
        $page_data['page_name'] = 'attendance_report';
        $page_data['page_title'] = get_phrase('attendance_report');
        //$this->load->view('backend/index', $page_data);
        $this->attendance_report_view($student_id, $page_data['month']);
    }

    function attendance_report_selector() {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        
        $this->form_validation->set_rules('month', 'Month', 'required');
        if ($this->form_validation->run() == TRUE) {
            $data['student_id'] = $this->input->post('student_id');
            $data['month'] = $this->input->post('month');
            redirect(base_url() . 'index.php?parents/attendance_report_view/' . $data['student_id'] . '/' . $data['month']);
        } else {
            $this->session->set_flashdata('flash_message_error', validation_errors());
            redirect(base_url() . 'index.php?parents/attendance_report');
        }
    }

    function attendance_report_view($student_id = '', $month = '') {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
        if ($student_id == "") {
            redirect(base_url(), 'refresh');
        }
         $page_data= $this->get_page_data_var();
        $this->load->model("Class_model");
        $studentDataArr = $this->Student_model->get_student_class_section($student_id);
        //pre($studentDataArr);die;
        $page_data['student_id'] = $student_id;
        $page_data['page_name'] = 'attendance_report_view';
        $page_data['section_id'] = $studentDataArr['section_id'];
        $page_data['student_name'] = $studentDataArr['student_name'];
        $page_data['class_name'] = $studentDataArr['class_name'];
        $page_data['section_name'] = $studentDataArr['section_name'];
        $page_data['class_id'] = $studentDataArr['class_id'];
        $page_data['section_id'] = $studentDataArr['section_id'];
        $page_data['running_year'] = $this->globalSettingsRunningYear;
        $page_data['month'] = $month;
        $year=explode('-', $page_data['running_year']);
        $page_data['year'] = $year;
        $days=cal_days_in_month(CAL_GREGORIAN, $month, $page_data['year'][0]);
        $status = 0;
        $studentAttendanceArr=array();
        for ($i = 1; $i <= $days; $i++) {
            $timestamp = strtotime($i . '-' . $month . '-' . $year[0]);
            $attendance= $this->Parent_model->get_attedance_by($studentDataArr['section_id'],$studentDataArr['class_id'],$this->globalSettingsRunningYear,$timestamp,$student_id);
            //pre($timestamp);die;
            $status="";
            foreach ($attendance as $row1):
                $month_dummy = date('j', $row1['timestamp']);
                    if ($i == $month_dummy){
                        $status = $row1['status'];
                    }
            endforeach;
            if ($status == 1) {
                $studentAttendanceArr[$i]='<i style="color: #00a651;">P</i>';
            }else if ($status == 2) {
                $studentAttendanceArr[$i]='<i style="color: #ee4749;">A</i>';
            }else{
                $studentAttendanceArr[$i]='&nbsp;';
            }
        }
        $page_data['studentAttendanceArr'] = $studentAttendanceArr;
        $page_data['days'] = $days;
        $page_data['page_title'] = get_phrase('attendance_report_of_class') . ' ' . $page_data['class_name'] . ' : ' . get_phrase('section') . ' ' . $page_data['section_name'];
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        //pre($page_data); die()
        $this->load->view('backend/index', $page_data);
    }

    function attendance_report_print_view($student_id = "", $month = "") {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($student_id == "" || $month == "")
            redirect(base_url(), 'refresh');
         $page_data= $this->get_page_data_var();
        $studentDataArr = $this->Student_model->get_student_class_section($student_id);
        // pre($studentDataArr);
        $page_data['class_id'] = $studentDataArr['class_id'];
        $page_data['month'] = $month;
        $page_data['student_id'] = $student_id;
        
        $section_name = $studentDataArr['section_name'];
        $class_name = $studentDataArr['class_name'];
        $page_data['section_id'] = $studentDataArr['section_id'];
        $page_data['class_name'] = $class_name;
        $page_data['section_name'] = $section_name;
        $page_data['system_name'] = $this->globalSettingsSystemName;
        $page_data['running_year'] = $this->globalSettingsRunningYear;
        $page_data['student_name'] = $studentDataArr['student_name'];
        $page_data['page_title'] = get_phrase('attendance_report_of_class') . ' ' . $class_name . ' : ' . get_phrase('section') . ' ' . $section_name;
        $days=cal_days_in_month(CAL_GREGORIAN, $month, $page_data['year'][0]);
        $year=explode('-', $page_data['running_year']);
        $status = 0;
        $studentAttendanceArr=array();
        for ($i = 1; $i <= $days; $i++) {
            $timestamp = strtotime($i . '-' . $month . '-' . $year[0]);
            $attendance= $this->Parent_model->get_attedance_by($studentDataArr['section_id'],$studentDataArr['class_id'],$this->globalSettingsRunningYear,$timestamp,$student_id);
            //pre($timestamp);die;
            $status="";
            foreach ($attendance as $row1):
                $month_dummy = date('j', $row1['timestamp']);
                    if ($i == $month_dummy){
                        $status = $row1['status'];
                    }
            endforeach;
            if ($status == 1) {
                $studentAttendanceArr[$i]='<i style="color: #00a651;">P</i>';
            }else if ($status == 2) {
                $studentAttendanceArr[$i]='<i style="color: #ee4749;">A</i>';
            }else{
                $studentAttendanceArr[$i]='&nbsp;';
            }
        }
        $page_data['studentAttendanceArr'] = $studentAttendanceArr;
        $page_data['page_name'] = 'attendance_report_print_view';
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    /*     * *****Parent feedback function********* */

    function faculty_feedback($param1 = '') {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model('Faculty_feedback_model');
        $year = $this->globalSettingsRunningYear;
        $this->load->model("Teacher_model");
        $teacher_list = $this->Teacher_model->get_teacher_forFeedback();
        if ($param1 == 'create') {
            $this->form_validation->set_rules('teacher_id', 'Teacher', 'required');
            $this->form_validation->set_rules('rating', 'Rating', 'required');
            $this->form_validation->set_rules('feed_back', 'Feed Back', 'required');
            if ($this->form_validation->run() == TRUE) {
                $feed_back['teacher_id'] = $this->input->post('teacher_id');
                $feed_back['rating'] = $this->input->post('rating');
                $feed_back['feedback_content'] = $this->input->post('feed_back');
                if ($this->Faculty_feedback_model->save_feed_back($feed_back)) {
                    $this->session->set_flashdata('flash_message', get_phrase('feedback_added_successfully!!'));
                } else {
                    $this->session->set_flashdata('flash_message', get_phrase('feedback_not_added!!'));
                }
                redirect(base_url() . 'index.php?parents/faculty_feedback');
            } else {
                $this->session->set_flashdata('flash_message_error', validation_errors());
                redirect(base_url() . 'index.php?parents/faculty_feedback');
            }
        }
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        //$page_data['teacher_list']              =   $teacher_det;        
        //$page_data['children_of_parent']        =   $children_of_parent;
        $page_data['teacher_list'] = $teacher_list;
        $page_data['page_name'] = 'faculty_feedback';
        $page_data['page_title'] = get_phrase('faculty_feedback');
        $this->load->view('backend/index', $page_data);
    }

    /*
     * Total number of notification for today
     * 
     */

    public function get_no_of_notication() {
        $this->load->model("Notification_model");
        $user_id = $this->session->userdata('login_user_id');
        $user_notif_user = $this->Notification_model->get_notifications('push_notifications', 'parent', $user_id);
        $user_notif_user_type = $this->Notification_model->get_notifications('push_notifications', 'parent');
        $user_notif_common = $this->Notification_model->get_notifications('push_notifications');
        $total_count = count($user_notif_user) + count($user_notif_user_type) + count($user_notif_common);
        return $total_count;
    }

    /*
     * method for redirecting with auto sign in to finance module of particular student
     * @param integer $student_id
     * @return redirect to finance module of student
     */

    public function student_accounting($student_id) {
        $this->load->model('Student_model');
        $student_details = $this->Student_model->get_student_details($student_id);
        if (isset($_COOKIE['PHPSESSID'])) {
            $username = $student_details->email;
            $password = $student_details->student_pass;
            setcookie("username", $username, time() + (60 * 20));
            setcookie("password", $password, time() + (60 * 20));
//            setcookie("running_year", $running_year , time() + (60 * 20)); 
        }
        redirect(base_url() . 'fi/?ng=client', 'refresh');
    }

    public function overall_class_details($param1 = "") {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');

        if($param1!=''){
            $page_data= $this->get_page_data_var();

            $running_year = $this->Setting_model->get_year();

            $ClassID = $this->Enroll_model->get_class_id_bystudent_id($param1, $running_year);

            if($ClassID){
                $this->load->model('Class_model');

                $page_data['teachers'] = $this->Class_model->get_teachers_by_class($ClassID);
                $class_name = get_data_generic_fun('class', 'name', array('class_id' => $ClassID), 'result_arr'); 
                $page_data['class_name'] = $class_name[0]['name'];
                $page_data['syllabus'] = get_data_generic_fun('academic_syllabus', '*', array('class_id' => $ClassID, 'year' => $running_year));
                $page_data['books'] = get_data_generic_fun('book', '*', array('class_id' => $ClassID));
                $page_data['study_info'] = get_data_generic_fun('document', '*', array('class_id' => $ClassID));
                
                $page_data['page_title'] = get_phrase('overall_details');
                $page_data['page_name'] = 'class_details';
                $this->load->view('backend/index', $page_data);
            }else{
                redirect(base_url() . 'index.php?parents/dashboard', 'refresh');
            }

        }else{
            redirect(base_url() . 'index.php?parents/dashboard', 'refresh');
        }
        
    }

    public function dormitory_information($param1 = "") {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
        $this->load->model('Hostel_registration_model');
        $this->load->model('Dormitory_model');
        $this->load->model('Hostel_warden_model');
         $page_data= $this->get_page_data_var();
        $page_data['page_name'] = 'dormitory_information';
        $page_data['page_title'] = get_phrase('dormitory_information');
        $student_id = $param1;
        $page_data['student_info'] = $this->Hostel_registration_model->get_student_info_parents($student_id);
        $page_data['photo_url']             =     $this->Crud_model->get_image_url( 'student' , $student_id );
        if (!empty($page_data['student_info'])) {
            $hostel_id = $page_data['student_info'][0]['hostel_id'];
            $wardenDetails= $this->Dormitory_model->get_data_by_cols('*',array('dormitory_id' => $hostel_id));
            if(!empty($wardenDetails)){
                $page_data['warden_id']=$wardenDetails[0]->warden_id;
                $page_data['warden_details']=$this->Hostel_warden_model->get_data_by_cols('*', array('warden_id' => $page_data['warden_id']), 'result_array');
            }
            
            $this->load->model('Hostel_room_model');
            $hostel_room_details=$this->Hostel_room_model->get_data_by_cols('*', array('hostel_id' => $hostel_id));
            //room_fare
            if (!empty($hostel_room_details)) {
                $page_data['room_fare'] = $hostel_room_details[0]->room_fare;
            } else {
                $page_data['room_fare'] = '';
            }
        }
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    function clinical_records($student_id) {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
        $this->load->model("Medical_events_model");
        $student_details = $this->Student_model->get_student_details($student_id);
        $student_medical_history = $this->Medical_events_model->get_data_generic_fun('*', array('user_id' => $student_id), 'result_arr');
        $count_arr = count($student_medical_history);
         $page_data= $this->get_page_data_var();
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['count_arr'] = $count_arr;
        $page_data['medical_records'] = $student_medical_history;
        $page_data['student_details'] = $student_details;
        $page_data['page_title'] = get_phrase('clinical_histroy');
        $page_data['page_name'] = 'clinical_records';
        $this->load->view('backend/index', $page_data);
    }

    public function view_ptm_events($student_id='') {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
        $this->load->model('Parent_teacher_meeting_model');
        $parent_id = $this->session->userdata('parent_id');
         $page_data= $this->get_page_data_var();
        $page_data['ptm_details'] = $this->Parent_teacher_meeting_model->get_ptm_details($student_id);
        $page_data['page_title'] = get_phrase('ptm_events');
        $page_data['page_name'] = 'view_ptm_events';
        $this->load->view('backend/index', $page_data);
    }

    function download_fee_structure($fee_structure_id = '') {
        if ($fee_structure_id != '') {
            $file_name = $this->Crud_model->get_record('fee_structure', $condition = array('fee_structure_id' => $fee_structure_id), $field = "fee_structure");
            if (count($file_name)) {
                $fee_file_name = $file_name['fee_structure'];
                if (file_exists("uploads/FeeStructure/" . $fee_file_name)) {
                    $this->load->helper('download');
                    $data = file_get_contents("uploads/FeeStructure/" . $fee_file_name);
                    force_download($fee_file_name, $data);
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('Sorry, failed to download !'));
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('Sorry, failed to download !'));
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $this->session->set_flashdata('flash_message_error', get_phrase('Sorry, failed to download !'));
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function viewStudyMaterial($param1 = '') {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
        $this->load->model('Enroll_model');
         $page_data= $this->get_page_data_var();
        $year = $this->globalSettingsRunningYear;
        $child_of_parent = $this->Enroll_model->get_data_generic_fun('*', array('student_id' => $param1, 'year' => $year, 'result_arr'));
        if (!empty($child_of_parent)) {
            foreach ($child_of_parent as $row) {
                $class_id = $this->Enroll_model->get_class_id_bystudent_id($param1, $year);
                //echo '<pre>'; print_r($class_id);
                //$section_id     =   $this->enroll_model->get_section_id_bystudent_id($param1,$year);
            }
            if ((!empty($class_id))) {
                $this->load->model('Crud_model');
                $page_data['study_material_info'] = $this->Crud_model->get_study_material($class_id);
                //echo '<pre>'; print_r($page_data['study_material_info']);
            }
            $student_name = $this->Student_model->get_data_generic_fun( 'name', array('student_id' => $child_of_parent[0]->student_id));
            $page_data['student_name'] = $student_name[0]->name;
            $student_details = $this->Student_model->get_student_class_section($child_of_parent[0]->student_id);
            if (!empty($student_details)) {
                $page_data['class_name'] = $student_details['class_name'];
                $page_data['section_name'] = $student_details['section_name'];
            }
//            $class_teacher                              =     $this->Section_model->get_teachername_by_class_section($class_id, $section_id);
//            if(!empty($class_teacher )){
//                $page_data['class_teacher_name']        =     $class_teacher[0]['teacher_name'];
//                $page_data['class_teacher_email']       =     $class_teacher[0]['email'];
//            }
        }//die;
        $page_data['page_title'] = get_phrase('view_study_materials');
        $page_data['page_name'] = 'view_study_materials';
        $this->load->view('backend/index', $page_data);
    }

    //This is for help menu/page in navigation
    function help() {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
         $page_data= $this->get_page_data_var();
        $page_data['page_title'] = get_phrase('help');
        $page_data['page_name'] = 'help';
        $this->load->view('backend/index', $page_data);
    }

    //student documents by beant kaur

    function documents($param1 = '') {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');

         $id = $this->uri->segment(3);
    $this->load->model('S3_model');
    $page_data = $this->get_page_data_var();
    $page_data['files'] = $this->S3_model->get_all_files();

    $instance = $this->Crud_model->get_instance_name();
    $student_name = $this->Student_model->get_student_name($param1);
    $page_data['student_name'] = $student_name;
    $page_data['subfiles'] = $this->S3_model->get_file($page_data['files'][1], $instance . '/student/' . $param1 . '/');
    $page_data['instance'] = $instance . '/student/' . $param1 . '/';
    $page_data['student_id'] = $param1;
    $page_data['page_title'] = get_phrase('student_documents');
    $page_data['page_name'] = 'student_documents';
    $this->load->view('backend/index', $page_data);        
      
    }

    function download_document($param1 = '', $param2 = '', $param3 = '', $param4 = '') {
        $this->load->helper('download');
        //$data =  file_get_contents('uploads/parent_bulk_upload_error_details_for_excel_file.xlsx');
        //$name = 'parent_bulk_upload_error_details_for_excel_file.xlsx';
        //$name = 'parent_bulk_upload_error_details_for_excel_file.xlsx';
        $param4 = str_replace('%20', ' ', $param4);
        $file_path = implode('/', array($param1, $param2, $param3, $param4));
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
        $this->load->model('S3_model');
        $list = explode('/', $param1);
        //echo $file_path;
        //exit;
        $file_path = $this->S3_model->download($file_path);
        $data = file_get_contents($file_path);
        //echo $data;
        //exit;
        force_download($file_path, $data);
    }

// print transfer certificate
    function print_transfer_certificate($param1 = '', $param2 = '') {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');

        $this->load->model("Class_model");
        $this->load->model("Parent_model");
        $this->load->model("Enroll_model");
        $this->load->model("Transfer_certificate_model");
         $page_data= $this->get_page_data_var();
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['student'] = $this->Student_model->get_student_record(array('student_id' => $param1));
        $classes = $this->Student_model->get_class_id_by_student($param1);
        //$classes=$classes[0];
        $class_admitted = reset($classes);
        $present_class = end($classes);
        $page_data['class_admitted'] = $this->Class_model->get_class_record(array('class_id' => ($class_admitted['class_id'])), 'class_name');
        $page_data['present_class'] = $this->Class_model->get_class_record(array('class_id' => ($present_class['class_id'])), 'class_name');
//        $page_data['running_year']=$this->globalSettingsRunningYear;
        $page_data['running_year'] = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');

        $student = $this->Student_model->get_student_record(array('student_id' => $param1));
        $enroll_no = $this->Enroll_model->get_enrollid_by_student($param1, $page_data['running_year']);
        $tc_no = $this->Transfer_certificate_model->get_tc_no();
        $page_data['certificate_detail'] = $this->Transfer_certificate_model->get_details($param1);
        $page_data['parent_name'] = $this->Parent_model->get_parent_name($student->parent_id);

        $page_data['tc_number'] = $tc_no;
        $page_data['print'] = $param2;
        $page_data['enroll_no'] = $enroll_no;
        $page_data['crnt_date'] = date('d-m-Y');
        $page_data['student'] = $student;
        $page_data['page_title'] = get_phrase('transfer_certificate');
        $page_data['page_name'] = 'transfer_certificate';
        $this->load->view('backend/index', $page_data);
    }

    //print foer merit certificate
    function print_merit_certificate($param1) {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');

        $this->load->model("Class_model");
        $this->load->model("Transfer_certificate_model");
        $page_data= $this->get_page_data_var();
        $page_data['certificate_detail'] = $this->Transfer_certificate_model->get_merit_certificate($param1);        
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['student'] = $this->Student_model->get_student_record(array('student_id' => $param1));
        $classes = $this->Student_model->get_class_id_by_student($param1);

        //$classes=$classes[0];
        //exit;
        $class_admitted = reset($classes);
        $present_class = end($classes);
        $page_data['class_admitted'] = $this->Class_model->get_class_record(array('class_id' => ($class_admitted['class_id'])), 'class_name');
        $page_data['present_class'] = $this->Class_model->get_class_record(array('class_id' => ($present_class['class_id'])), 'class_name');
//    $page_data['running_year'] = $this->globalSettingsRunningYear;
        $page_data['running_year'] = $this->globalSettingsRunningYear;
        $page_data['student'] = $this->Student_model->get_student_record(array('student_id' => $param1));

        $page_data['student_id'] = $param1;
        $page_data['page_title'] = get_phrase('merit_certificate');
        $page_data['page_name'] = 'merit_certificate';

        $this->load->view('backend/index', $page_data);
    }

//UPLOAD FILE

    function upload_document($param1 = '') {

        $this->load->model('S3_model');
        $this->load->model('Crud_model');
        //$student_id=$param1;

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'pdf|docx|doc|txt|jpg|jpeg|png';
        $config['max_size'] = 100000;


        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile')) {

            $this->session->set_flashdata('flash_message_error', $this->upload->display_errors());
            redirect(base_url() . 'index.php?parents/documents/' . $param1, 'refresh');
        } else {
            $data = $this->upload->data();
            // $this->Crud_model->get_instance();

            $instance = $this->Crud_model->get_instance_name();
            $filepath = $instance . '/student/' . $param1 . '/' . $data['file_name'];
            //echo $filepath;
            // pre($this->upload->data());
            //exit;
            //$this->load->view('upload_success', $data);
            $this->S3_model->upload($this->upload->data()['full_path'], $filepath);
            unlink($this->upload->data()['full_path']);
            //exit;
            $this->session->set_flashdata('flash_message', get_phrase('document_uploaded_successfully'));
            redirect(base_url() . 'index.php?parents/documents/' . $param1, 'refresh');
        }
  
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
    
    public function online_polls( $action = '' , $poll_id = '') {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data                  =   $this->get_page_data_var();
        $this->load->model("Onlinepoll_model");
        $this->load->model("Class_model");

        $page_data['page_name']             =   'online_polls';
        $page_data['page_title']            =   get_phrase('online_polls');
        $parent_id                          =   $this->session->userdata('parent_id');
        
        
        $children_of_parent = $this->Student_model->get_data_by_cols('*', array('parent_id' => $parent_id), 'result_array'); 
        $allowed_class_ids                  =   '';
        $section_ids                        =   '';
        
        $i      =   0;
        if($action !='' && is_integer($action)) {
            $student_id         =   $action;
            $class_det      =   $this->Student_model->get_class_id_by_student((int)$student_id);
            if (!empty($class_det)) {
                $allowed_class_ids       =   ($allowed_class_ids!=''?$allowed_class_ids.",".$class_det[0]['class_id']:$class_det[0]['class_id']);
            }
            $section_id = $this->Student_model->get_section_id_by_student((int)$student_id);
            if (!empty($section_id)) {
                $section_ids       =   ($section_ids!=''?$section_ids.",".$section_id[0]['section_id']:$section_id[0]['section_id']);
            }  
        } else {
            foreach ($children_of_parent as $child) {
                $class_det      =   $this->Student_model->get_class_id_by_student($child['student_id']);
                if (!empty($class_det)) {
                    $allowed_class_ids       =   ($allowed_class_ids!=''?$allowed_class_ids.",".$class_det[0]['class_id']:$class_det[0]['class_id']);
                }
                $section_id = $this->Student_model->get_section_id_by_student($child['student_id']);
                if (!empty($section_id)) {
                    $section_ids       =   ($section_ids!=''?$section_ids.",".$section_id[0]['section_id']:$section_id[0]['section_id']);
                }
            }
        }
        
        $allowed_class_ids                  =   explode(',', $allowed_class_ids);

        $online_polls                       =   $this->Onlinepoll_model->getOninePolls();
        //pre($online_polls);die;
        $online_poll_list                   =   $online_polls;
        //echo '$action : '.$action;die;
        foreach($online_polls as $key=>$poll) {
            //echo '$action : '.$action;
            //pre($poll);
            //check parent already polled and unset
            $polled_parents                         =   explode(",",$poll['parent_ids']);
            //pre($polled_parents);
            if(in_array($parent_id,$polled_parents)) { //pre('unset parent poll');
                unset($online_poll_list[$key]);
                continue;
            }
            
            
            if($poll['classes'] != 0){
                $class_ids                  =   explode(',',$poll['classes']);
                $class_found                =   0;
                foreach($allowed_class_ids as $class_id) { 
                    if(in_array($class_id, $class_ids)) {
                        $class_found        =   1;
                    }
                }
                if($class_found == 0) {
                    unset($online_poll_list[$key]);
                }
            }
            
            $answer                                 =   $this->Onlinepoll_model->getOnlinpollAnswer(array('poll_id'=>$poll['poll_id']));
            //pre($answer); //die;
            if(!$answer)
                $answer                             =   array();
            
            $online_poll_list[$key]['answer_det']       =   $answer;
            $total_poll                             =   $this->Onlinepoll_model->getPollCount($poll['poll_id']);
            $online_poll_list[$key]['total_poll']       =   $total_poll[0]->total_poll;
            //pre($online_poll_list);//die;
            //pre("JJJJJ");
        }
        //pre($online_poll_list);
        //die($action);
        if($action == 'polled') {
            $this->session->set_flashdata('flash_message', get_phrase('poll_updated_successfully'));
            redirect(base_url() . 'index.php?parents/online_polls/' , 'refresh');
        }
        //pre($online_poll_list);die;
        $page_data['online_polls']          =   $online_poll_list;
        $this->load->view('backend/index', $page_data);
    }
    
    
    /*
     * home works
     */
    public function home_works( $student_id = '' ) {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data= $this->get_page_data_var();
        
        $this->load->model('Homeworks_model');
        $parent_id             =   $this->session->userdata('parent_id');
        
        $student_det            =   $this->Student_model->get_student_details($student_id);
        $class_id               =   $student_det->class_id;
        $section_id             =   $student_det->section_id;
//        echo $class_id;die('-'.$section_id);
        if($student_id && !empty($student_det)){
            $condition          =   array(
                'home_works.class_id'                  =>  $class_id,
                'home_works.section_id'                =>  $section_id,
                'home_work_submissions.student_id'    =>  $student_id,
                );
            
            $home_works         =   $this->Homeworks_model->get_all_data_homework('',$condition);
            $page_data['student_home_works']    =   $home_works;
        }
        
        $page_data['student_id']    =   $student_id;
        $page_data['page_name']  = 'home_work';
        $page_data['page_title'] = get_phrase('home_works');
        $page_data['total_notif_num']  =   $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }
    
    /*
     * 
     */
    public function submit_home_work( $action = '' , $home_work_id = '' , $student_id = '') {
        if($action == 'create') {
            $input_data             =   $this->input->post();
        }
        
        $this->load->model('Homeworks_model');
        $parent_id             =   $this->session->userdata('parent_id');
        $home_works                 =   $this->Homeworks_model->get_all_data('',array('home_work_id'=>$home_work_id));
        $home_works                 =   $home_works[0];
        
        $comment                    =   $input_data['home_work_comment'];
        $submission_disc            =   $input_data['hw_description'];
        $attachements               =   '';
        
        $data                       =   array(
            'hw_id'                 =>  $home_work_id,
            'hw_type'               =>  $home_works['type_id'],
            'class_id'              =>  $home_works['class_id'],
            'section_id'            =>  $home_works['section_id'],
            'subject_id'            =>  $home_works['type_id'],
            'student_id'            =>  $student_id,
            'parent_id'             =>  $parent_id,
            'comment'               =>  $comment,
            'submission_disc'       =>  $submission_disc,
            'status'                =>  1
        );
        
        $insert             =   $this->Homeworks_model->add_data($data,'home_work_submissions');
        if($insert) {
            $this->session->set_flashdata('flash_message', get_phrase('home_work_submitted_successfully'));
            redirect(base_url() . 'index.php?parents/home_works/'.$student_id , 'refresh');
        } else {
            $this->session->set_flashdata('flash_message', get_phrase('updation_failed'));
            redirect(base_url() . 'index.php?parents/home_works/'.$student_id , 'refresh');

        }
    }
    public function incident( $student_id = '' ) {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
        $this->load->model('Incident_model');
        $page_data                  =   array();
        $page_data                  =   $this->get_page_data_var();
        $page_data['page_title']    =   get_phrase('my_incident');
        $page_data['page_name']     =   'my_incident';
        $page_data['details']       =   $this->Incident_model->get_details_student_id($student_id);
        $page_data['total_notif_num']  =   $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }
    function online_exam_report($student_id = ''){
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
        $this->load->model('Online_exam_model');
        $this->load->model('Online_exam_answers_model');
        $this->load->model('Question_model');
        $page_data                  =   array();
        $page_data                  =   $this->get_page_data_var();
        $enrollData = $this->Enroll_model->get_data_by_cols('*', array('student_id' => $student_id, 'year' => $this->globalSettingsRunningYear), 'result_arr');
        if(!empty($enrollData)){
            $class_id = $enrollData[0]['class_id'];
        }
        else{
            $class_id="";
        }
        $this->load->model('Online_exam_model');
        $this->load->model('Student_online_exam_attempt_model');
        $online_exam = $this->Online_exam_model->get_exam_data_class_id_student_login($class_id);
        foreach($online_exam as $exam){
             $student_total     =   $this->Online_exam_answers_model->get_total($exam['id'],$student_id);
             $total_time        =   $this->Student_online_exam_attempt_model->get_total_time($exam['id'],$student_id);
             if(!empty($student_total[0]['result'])){
                $percent[]['result']           =   $student_total[0]['result'];
                $total_time_taken[]['time_taken']   = $total_time[0]['time_taken'];   
             }
             else if($student_total[0]['result']    ==  "0"){
                 $percent[]['result']       =   "0";
             }
             else{
                 $percent[]['result']       =   "Exam not attempted";
                  $total_time_taken[]['time_taken']   = "Exam not attempted";
             }
        }
        $i=0;
        $newArray=array();
        foreach($online_exam as $value){
           $newArray[$i] = array_merge($value, $percent[$i],$total_time_taken[$i]);
            $i++;
        }
//        pre($newArray);exit;
        $page_data['details']       =   $newArray;
        $page_data['page_title']    =   get_phrase('online_exam_report');
        $page_data['page_name']     =   'online_exam_report';
        $page_data['total_notif_num']  =   $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    /* * ***Track buses PAGE********* */
    function livetrack() {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        //$admin_id=$this->session->userdata('admin_id');
        $page_data['page_info'] = 'Track buses';
        $page_data['page_name'] = 'live_track';
        $page_data['page_title'] = 'Track Buses';
        //$page_data['edit_data']=$this->db->get('device');
        $this->load->view('backend/index', $page_data);
    }

        function certificats($student_id = ''){
        $page_data = $this->get_page_data_var();
         if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
       $this->load->model('Student_certificate_model');
        $page_data                  =   array();
        $page_data                  =   $this->get_page_data_var();
        $page_data['page_name'] = 'view_certificate';
        $page_data['page_title'] = get_phrase('student_certificate_list');
        $condition = array('student_id' => $student_id);
        $sortArr = array('certificate_id' => 'desc');
        $page_data['certificate_list'] = $this->Student_certificate_model->get_data_by_cols('*', $condition, 'result_type', $sortArr);
        $this->load->view('backend/index', $page_data);
    }
    
    function template1($param1='',$param2='',$param3=''){
    if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['certificate_design'] = "";
    if($param1=='download'){
    $this->load->model('Student_certificate_model');
    $page_data['certificate_detail'] = $this->Student_certificate_model->get_certificate_record($param2,$param3,'1');
//    pre($page_data['certificate_detail']); die;
    }else{
    $page_data['certificate_design'] = "true";    
    }
    $page_data['page_title'] = get_phrase('template1');
    $page_data['page_name'] = 'certificate_template1';
    $this->load->view('backend/index', $page_data);
}

function template2($param1='',$param2='',$param3=''){
    if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['certificate_design'] = "";
    if($param1=='download'){
       $this->load->model('Student_certificate_model');
    $page_data['certificate_detail'] = $this->Student_certificate_model->get_certificate_record($param2,$param3,'2');
//    pre($page_data['certificate_detail']); die;
    }else{
    $page_data['certificate_design'] = "true";    
    }
    $page_data['page_title'] = get_phrase('template2');
    $page_data['page_name'] = 'certificate_template2';
    $this->load->view('backend/index', $page_data);
}

function template3($param1='',$param2='',$param3=''){
if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['certificate_design'] = "";
    if($param1=='download'){
     $this->load->model('Student_certificate_model');
    $page_data['certificate_detail'] = $this->Student_certificate_model->get_certificate_record($param2,$param3,'3');
//    pre($page_data['certificate_detail']); die;
    }else{
    $page_data['certificate_design'] = "true";    
    }
    $page_data['page_title'] = get_phrase('template3');
    $page_data['page_name'] = 'certificate_template3';
    $this->load->view('backend/index', $page_data);
}
function template4($param1='',$param2='',$param3=''){
if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['certificate_design'] = "";
    if($param1=='download'){
     $this->load->model('Student_certificate_model');
    $page_data['certificate_detail'] = $this->Student_certificate_model->get_certificate_record($param2,$param3,'4');
//    pre($page_data['certificate_detail']); die;
    }else{
    $page_data['certificate_design'] = "true";    
    }
    $page_data['page_title'] = get_phrase('template4');
    $page_data['page_name'] = 'certificate_template4';
    $this->load->view('backend/index', $page_data);
}

    function student_fees($param1=''){
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data = $this->get_page_data_var();
        $page_data['student_id'] = $param1;
        $page_data['stu_details'] ='';
        $page_data['running_year'] = $this->globalSettingsRunningYear;
        if($param1!=''){
            $this->load->model('fees/Ajax_model');
            $page_data['stu_details'] = $this->Ajax_model->get_student(array('S.student_id'=>$param1));
            $page_data['terms'] = $this->Ajax_model->get_setudent_fee_config($param1);
        }
        
        $page_data['page_title'] = get_phrase('fees');
        $page_data['page_name'] = 'student_fees';
        $this->load->view('backend/index', $page_data);
    }

    public function update_student_info(){
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
        $this->load->model("Student_model"); 
        $student_id = $this->input->post('student_id');
        $data['blood_group'] = $this->input->post('blood_group');
        $data['emergency_contact_number'] = $this->input->post('emergency_contact');
        $student_details = $this->Student_model->update_student_info( $student_id, $data ); 
        
        if($student_details) {
            $this->session->set_flashdata('flash_message', get_phrase('Student information has been updated successfully.'));
        } else {
            $this->session->set_flashdata('flash_message', get_phrase('Some error occurred.'));
        }
        exit();
    }
    
    function online_polls_result(){
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data                  =   $this->get_page_data_var();
        $this->load->model("Onlinepoll_model");
        $this->load->model("Class_model");

        $page_data['page_name']             =   'online_polls_result';
        $page_data['page_title']            =   get_phrase('online_polls_result');
        $parent_id                          =   $this->session->userdata('parent_id');
        
        
        $children_of_parent = $this->Student_model->get_data_by_cols('*', array('parent_id' => $parent_id), 'result_array'); 
        $allowed_class_ids                  =   '';
        $section_ids                        =   '';
        $action="";
        $i      =   0;
        if($action !='' && is_integer($action)) {
            $student_id         =   $action;
            $class_det      =   $this->Student_model->get_class_id_by_student((int)$student_id);
            if (!empty($class_det)) {
                $allowed_class_ids       =   ($allowed_class_ids!=''?$allowed_class_ids.",".$class_det[0]['class_id']:$class_det[0]['class_id']);
            }
            $section_id = $this->Student_model->get_section_id_by_student((int)$student_id);
            if (!empty($section_id)) {
                $section_ids       =   ($section_ids!=''?$section_ids.",".$section_id[0]['section_id']:$section_id[0]['section_id']);
            }  
        } else {
            foreach ($children_of_parent as $child) {
                $class_det      =   $this->Student_model->get_class_id_by_student($child['student_id']);
                if (!empty($class_det)) {
                    $allowed_class_ids       =   ($allowed_class_ids!=''?$allowed_class_ids.",".$class_det[0]['class_id']:$class_det[0]['class_id']);
                }
                $section_id = $this->Student_model->get_section_id_by_student($child['student_id']);
                if (!empty($section_id)) {
                    $section_ids       =   ($section_ids!=''?$section_ids.",".$section_id[0]['section_id']:$section_id[0]['section_id']);
                }
            }
        }
        
        $allowed_class_ids                  =   explode(',', $allowed_class_ids);

        $online_polls                       =   $this->Onlinepoll_model->get_closed_online_polls();
        //pre($online_polls);die;
        $online_poll_list                   =   $online_polls;
        //echo '$action : '.$action;die;
        foreach($online_polls as $key=>$poll) {
            //echo '$action : '.$action;
            //pre($poll);
            //check parent already polled and unset
            $polled_parents                         =   explode(",",$poll['parent_ids']);
            //pre($polled_parents);
            if(!in_array($parent_id,$polled_parents)) { //pre('unset parent poll');
                unset($online_poll_list[$key]);
                continue;
            }
            
            
            if($poll['classes'] != 0){
                $class_ids                  =   explode(',',$poll['classes']);
                $class_found                =   0;
                foreach($allowed_class_ids as $class_id) { 
                    if(in_array($class_id, $class_ids)) {
                        $class_found        =   1;
                    }
                }
                if($class_found == 0) {
                    unset($online_poll_list[$key]);
                }
            }
            
            $answer                                 =   $this->Onlinepoll_model->getOnlinpollAnswer(array('poll_id'=>$poll['poll_id']));
            //pre($answer); //die;
            if(!$answer)
                $answer                             =   array();
            
            $online_poll_list[$key]['answer_det']       =   $answer;
            $total_poll                             =   $this->Onlinepoll_model->getPollCount($poll['poll_id']);
            //pre($total_poll);die;
            $online_poll_list[$key]['total_poll']       =   $total_poll[0]->total_poll;
            //pre($online_poll_list);die;
            //pre("JJJJJ");
        }
        
        //pre($online_poll_list);die;
        $page_data['online_polls']          =   $online_poll_list;
        $this->load->view('backend/index', $page_data);
    }
    
     public function clinical_history($param1 = '', $param2 = '') {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
        
        $page_data                  =   $this->get_page_data_var();
        $this->load->model('Clinical_history_model');
       
        if($param2 == 'create'){
         
            $this->form_validation->set_rules('symptoms', 'Symptoms', 'required');
            $this->form_validation->set_rules('diagnosis', 'Diagnosis', 'required');
            $this->form_validation->set_rules('precription', 'Precription', 'required');
            $this->form_validation->set_rules('start_date', 'Start Date', 'required');
//            pre($this->input->post()); die;
         if ($this->form_validation->run() == TRUE) {
                 $data['symptoms']  =   $this->input->post('symptoms');
                 $data['diagnosis']  =  $this->input->post('diagnosis');
                 $data['prescription'] = $this->input->post('precription');
                 $data['given_by'] =  "Parent";
                 $data['start_date'] =  $this->input->post('start_date');
                 $data['end_date'] =    $this->input->post('end_date');
                 $data['student_id'] =  $param1;
                 $data['parent_id'] =   $this->session->userdata('parent_id');
//                 pre($data); die;
                 $this->Clinical_history_model->add($data);
                 $this->session->set_flashdata("flash_message", get_phrase("data_added_successfully"));
                 redirect(base_url() . 'index.php?parents/clinical_history/'.$param1, 'refresh');
         } else{
                 $this->session->set_flashdata('flash_validation_error', validation_errors());
                 redirect(base_url() . 'index.php?parents/clinical_history/'.$param1, 'refresh');
         }
       }
 
        if($param2 == 'edit'){
                 $data['symptoms']  =   $this->input->post('symptoms');
                 $data['diagnosis']  =  $this->input->post('diagnosis');
                 $data['prescription'] = $this->input->post('precription');
                 $data['start_date'] =  $this->input->post('start_date');
                 $data['end_date'] =    $this->input->post('end_date');
      //                    pre($data); die;
                $this->Clinical_history_model->update_clinical($data, array("clinical_history_id" => $param1));
                $this->session->set_flashdata("flash_message", get_phrase("updated_successfully"));
                redirect(base_url() . 'index.php?parents/clinical_history/'.$param1, 'refresh');
        }
        if($param2 == 'delete'){
                $this->Clinical_history_model->delete_clinical($param1);
                $this->session->set_flashdata("flash_message", get_phrase("deleted_successfully"));
                redirect(base_url() . 'index.php?parents/clinical_history/'.$param1, 'refresh');
        }
        $page_data['page_title']    =   get_phrase('clinical_history');
        $page_data['page_name']     =   'clinical_history';
         if($param1!=''){            
           $page_data['student_name'] = $this->Student_model->get_student_name($param1);
         }
        $page_data['student_id'] = $param1;
        $condition = array($page_data['student_id'] => $param1);
        $page_data['clinical_details']       =   $this->Clinical_history_model->get_clinical_array($condition);
//        pre($page_data['clinical_details']); die;
        $page_data['total_notif_num']  =   $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }
}
