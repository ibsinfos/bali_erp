<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Student extends CI_Controller {

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
        $this->load->library('session');
        $this->load->model('Setting_model');
        $this->load->model('Student_model');
        $this->load->model('Parent_model');
        $this->load->model('Enroll_model');
        $this->load->model('Teacher_model');
        $this->load->model('Class_model');
        $this->load->model('Section_model');
        $this->load->model('Subject_model');
        $this->load->model('Section_model');
        $this->load->model('Exam_model');
        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        //$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        //$this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
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
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($this->session->userdata('student_login') == 1)
            redirect(base_url() . 'index.php?student/dashboard', 'refresh');
    }

    /*     * *ADMIN DASHBOARD** */

    function dashboard() {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model('Attendance_model');
        $this->load->model('Subject_model');
        $this->load->model('Mark_model');
        $this->load->model('Notification_model');
        $page_data['page_name'] = 'dashboard';
        $page_data['page_title'] = get_phrase('student_dashboard');
        $page_data['account_type'] = $this->session->userdata('login_type');
        $page_data['system_name'] = $this->globalSettingsSystemName;
        $page_data['system_title'] = $this->globalSettingsSystemTitle;
        $page_data['text_align'] = $this->globalSettingsTextAlign;
        $page_data['skin_colour'] = $this->globalSettingsSkinColour;
        $page_data['active_sms_service'] = $this->globalSettingsActiveSmsService;
        $page_data['running_year'] = $this->globalSettingsRunningYear;
        $student_id = $this->session->userdata('student_id');
        $page_data['attendance'] = $this->Attendance_model->get_attendence_student_month($student_id);
        foreach ($page_data['attendance'] as $value) {
            $page_data['percentage'] = $value['percent'];
        }
        $page_data['student_details'] = $this->Student_model->get_student_details($student_id);
        $class_id = $this->Student_model->get_class_id_by_student($student_id);
        $cls_id = '';
        $sec_id = '';
        if (!empty($class_id)) {
            $cls_id = $class_id[0]['class_id'];
        }
        $section_id = $this->Student_model->get_section_id_by_student($student_id);
        if (!empty($section_id)) {
            $sec_id = $section_id[0]['section_id'];
        }
        $page_data['student_subject_details'] = $this->Subject_model->get_subject_dashboard($cls_id, $sec_id, $page_data['running_year']);
        $page_data['notifications'] = $this->Notification_model->get_last_threedays_notifcations('push_notifications');
        $student_details = $this->Student_model->get_data_by_cols('*', array('student_id' => $this->session->userdata('student_id')), 'result_array');
        $page_data['edit_data'] = array_shift($student_details);
        $this->load->view('backend/index', $page_data);
    }

    /*     * **MANAGE TEACHERS**** */

    function teacher_list($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();

        $page_data['search_text'] = '';

        if ($param1 == 'personal_profile') {
            $page_data['personal_profile'] = true;
            $page_data['current_teacher_id'] = $param2;
        } else if (($param1 == 'search') && ($param2 != '')) {
            $page_data['search_text'] = $param2;
        }
        $page_data['teachers'] = $this->Teacher_model->get_data_by_cols('*', array(), 'result_array');
        $page_data['page_name'] = 'teacher';
        $page_data['page_title'] = get_phrase('view_teachers_details');
        $this->load->view('backend/index', $page_data);
    }

    /*     * ******************************************************************************************************** */
    /*     * **MANAGE SUBJECTS**** */

    function subject($param1 = '', $param2 = '') {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model('Subject_model');
        $student_id = $this->session->userdata('student_id');
        $student_profile = $this->Student_model->get_student_details($student_id);
        $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
        $subject_condition = array(
            'sub.class_id' => $student_profile->class_id,
            'sub.section_id' => $student_profile->section_id,
            'year' => $running_year
        );
        $page_data['subjects'] = $this->Subject_model->get_all_subjects($subject_condition);
        $page_data['page_name'] = 'subject';
        $page_data['page_title'] = get_phrase('subject_list');
        $this->load->view('backend/index', $page_data);
    }

    function event_calender($param1 = '') {
        $page_data = $this->get_page_data_var();
        $this->load->model('Subject_model');
        $this->load->model('Student_model');
        $this->load->model('Exam_model');
        $this->load->model('Event_model');
        $children_of_parent = array();
        $children_of_parent = $this->Student_model->get_data_by_cols('*', array('student_id' => $this->session->userdata('student_id')), 'result_array');
        $novotipo = $this->input->post("novotipo");
        if ($novotipo != "") {
            $title = $this->input->post('title');
            if (trim($title) != "") {
                $this->load->model("Type_model");
                $this->Type_model->add(array('title' => $title));
                $this->session->set_flashdata('flash_message', "New Type Created!");
                redirect('student/event_calender', 'refresh');
            }
        }
        foreach ($children_of_parent as $child) {
            $class_id = $this->Student_model->get_class_id_by_student($child['student_id'])[0]['class_id'];
            $section_id = $this->Student_model->get_section_id_by_student($child['student_id'])[0]['section_id'];
            $exams = $this->Exam_model->get_exam_routine(array('class_id' => $class_id, 'section_id' => $section_id));
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
        $page_data['events'] = $events;
        $page_data['types'] = $this->Event_model->getEventTypes();
        $page_data['page_name'] = 'event_calender';
        $page_data['page_title'] = get_phrase('event_calender');
        $this->load->view('backend/index', $page_data);
    }

    function student_marksheet($student_id = '') {
        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();
        if ($student_id == "") {
            $student_id = $this->session->userdata('login_user_id');
        }
        $this->load->model("Mark_model");
        //$page_data = array();
        $runningYr = $this->globalSettingsRunningYear;
        $classData = $this->Enroll_model->get_data_by_cols('', array('student_id' => $student_id, 'year' => $runningYr));

        $class_id = @$classData[0]->class_id;
        $studentData = $this->Student_model->get_data_by_id($student_id, 'name');
        $student_name = @$studentData[0]->name;

        $classData1 = $this->Class_model->get_data_by_id($class_id, 'name');
        $class_name = @$classData1[0]->name;

        $exams = $this->Crud_model->get_exams();
        $marks = '';
        $m = 0;
        $marksData = array();
        foreach ($exams as $row2) {
            $marksData[$m]['marks'] = $row2;
            $subjects = $this->Subject_model->get_data_by_cols('', array('class_id' => $class_id, 'year' => $runningYr), 'result_array');
            $exam_types = array("FA1", "FA2", "SA1", "FA3", "FA4", "SA2");
            $k = 0;
            foreach ($subjects as $row3) {
                if (!in_array(strtoupper($row2['name']), $exam_types)) {
                    $obtained_mark_query = $this->Mark_model->get_c_year_mark_obtained_by_subject_exam_class($row3['subject_id'], $row2['exam_id'], $class_id, $student_id, $runningYr);

                    $marksData[$m]['marks']['subject'][$k] = $row3;
                    $s = 0;
                    if ($obtained_mark_query > 0) {
                        foreach ($obtained_mark_query as $row4) {
                            $marksData[$m]['marks']['subject'][$k]['obtained'][$s] = $row4;

                            if ($row4['mark_obtained'] >= 0 || $row4['mark_obtained'] != '') {
                                $marksData[$m]['marks']['subject'][$k]['obtained'][$s]['grade'] = $this->Crud_model->get_grade($row4['mark_obtained']);
                            }
                            $s++;
                        }
                    }

                    $highestMark = $this->Crud_model->get_highest_marks($row2['exam_id'], $class_id, $row3['subject_id']);
                    $marksData[$m]['marks']['subject'][$k]['highest_mark'] = $highestMark;

                    $tot_subjects_data = $this->Subject_model->get_data_by_cols('', array('class_id' => $class_id, 'year' => $runningYr), 'result_array');
                    $marksData[$m]['marks']['subject'][$k]['tot_subjects'] = count($tot_subjects_data);
                }

                if (in_array(strtoupper($row2['name']), $exam_types)) {
                    $examData = $this->Exam_model->get_data_by_cols('', array('UPPER(name)' => "FA1"), 'result_array');
                    if (count($examData) > 0) {
                        $exam_id = $examData->row()->exam_id;
                        $obtained_mark_query = $this->Mark_model->get_c_year_mark_obtained_by_subject_exam_class($row3['subject_id'], $exam_id, $class_id, $student_id, $runningYr);

                        $marksData[$m]['marks']['subject'][$k] = $row3;
                        $s = 0;
                        if ($obtained_mark_query > 0) {
                            foreach ($obtained_mark_query as $row4) {
                                $marksData[$m]['marks']['subject'][$k]['obtained'][$s] = $row4;

                                if ($row4['mark_obtained'] >= 0 || $row4['mark_obtained'] != '') {
                                    $marksData[$m]['marks']['subject'][$k]['obtained'][$s]['grade'] = $this->Crud_model->get_grade($row4['mark_obtained']);
                                }
                                $s++;
                            }
                        }

                        $highestMark = $this->Crud_model->get_highest_marks($row2['exam_id'], $class_id, $row3['subject_id']);
                        $marksData[$m]['marks']['subject'][$k]['highest_mark'] = $highestMark;

                        $tot_subjects_data = $this->Subject_model->get_data_by_cols('', array('class_id' => $class_id, 'year' => $runningYr), 'result_array');
                        $marksData[$m]['marks']['subject'][$k]['tot_subjects'] = count($tot_subjects_data);
                    }
                }

                $k++;
            }
            $m++;
        }

        //pre($marksData); die;
        $page_data['marks_data'] = $marksData;
        $page_data['student_info'] = $this->Crud_model->get_student_info($student_id);

        $page_data['page_name'] = 'student_marksheet';
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['page_title'] = get_phrase('marksheet_for') . ' ' . $student_name . ' (' . get_phrase('class') . ' ' . $class_name . ')';
        $page_data['student_id'] = $student_id;
        $page_data['class_id'] = $class_id;
        $this->load->view('backend/index', $page_data);
    }

    function my_exam($student_id = '') {
        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();
        if ($student_id == "") {
            $student_id = $this->session->userdata('login_user_id');
        }
        $enrollData = $this->Enroll_model->get_data_by_cols('*', array('student_id' => $student_id, 'year' => $this->globalSettingsRunningYear), 'result_arr');
        $class_id = "";
        if(!empty($enrollData))
            $class_id = $enrollData[0]['class_id'];
        $this->load->model('Online_exam_model');
        $this->load->model('Online_exam_answers_model');
        $online_exam = $this->Online_exam_model->get_exam_data_class_id_student_login($class_id);
        foreach($online_exam as $exam){
            $attempts = $this->Online_exam_answers_model->get_data_by_cols('*', array('student_id' => $student_id,'exam_id'=>$exam['id']), 'result_arr');    
//            $attempts= $attemptss[0]['exam_id'];
            if(!empty($attempts)){
            $attempt[]['attempt'] =   "cannot attempt";
            }
            else{
                $attempt[]['attempt'] =   "can attempt";

            }
        }
        $i=0;
        $newArray=array();
        foreach($online_exam as $value){
           $newArray[$i] = array_merge($value, $attempt[$i]);
            $i++;
        }
//        pre($newArray);exit;
        $page_data['online_exam'] = $newArray;
        $page_data['page_name'] = 'my_exam';
        $page_data['page_title'] = get_phrase('my_exam');
        $page_data['student_id'] = $student_id;
        $page_data['class_id'] = $class_id;
        $this->load->view('backend/index', $page_data);
    }
    
    function homework() {
       // pre($this->session->userdata());
        $this->load->model("Enroll_model");
        
        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();
        if (empty($student_id)) {
            $student_id = $this->session->userdata('student_id');
        }
        
        $enrollData = $this->Enroll_model->get_data_by_cols('*', array('student_id' => $student_id, 'year' => $this->globalSettingsRunningYear), 'result_arr');
        
        $section_id = "";
        if(!empty($enrollData))
            $section_id = $enrollData[0]['section_id'];
        $this->load->model('Homeworks_model');
        
        $homeworks = $this->Homeworks_model->get_homework_class_id_student_login($section_id);
       
        foreach($homeworks as $homework){
            $homework_id = $homework['home_work_id'];
            $submitted = $this->Homeworks_model->get_homework_submitted($student_id, $homework_id);    
//            $attempts= $attemptss[0]['exam_id'];
            if(!empty($submitted)){
            $submitted_value[]['status'] =   "cannot attempt";
            }
            else{
                $submitted_value[]['status'] =   "can attempt";

            }
        }
        $i=0;
        $newArray=array();
        foreach($homeworks as $value){
           $newArray[$i] = array_merge($value, $submitted_value[$i]);
            $i++;
        }
        if($_POST)
        {    
            
            if($_POST['action'] == 'create') {
                $input_data             =   $this->input->post();
                $data    =   array(
                    
                        'hw_id'             =>      $input_data['hw_id'],
                        'hw_type'           =>      $input_data['hw_type'],
                        'class_id'          =>      $input_data['class_id'],
                        'section_id'        =>      $input_data['section_id'],
                        'subject_id'        =>      $input_data['subject_id'],
                        'student_id'        =>      $input_data['student_id'],
                        'submission_disc'   =>      $input_data['hw_description'],
                        'parent_id'         =>      $input_data['parent_id']
                    
                );

                $insert                 =   $this->Homeworks_model->student_homework_add($data);
                if($insert) {
                    $this->session->set_flashdata('flash_message', get_phrase('New home work added successfully.'));
                    redirect(base_url() . 'index.php?student/homework/', 'refresh');
                } else {
                    $this->session->set_flashdata('flash_message_error', validation_errors());
                    redirect(base_url() . 'index.php?student/homework/' ,'refresh');
                }
            }
        }    
        $page_data['online_exam'] = $newArray;
        $page_data['page_name'] = 'my_homework';
        $page_data['page_title'] = get_phrase('my_homework');
        $page_data['student_id'] = $student_id;
        //$page_data['class_id'] = class_id;
        $page_data['section_id'] = $section_id;
        $this->load->view('backend/index', $page_data);
    }

    function question($exam_id = '') {

        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model("Question_model");
        $question = $this->Question_model->get_data_by_cols('*', array('exam_id' => $exam_id), 'result_array');

        $page_data['question'] = $question;
        $page_data['page_name'] = 'question';
        $page_data['page_title'] = get_phrase('question');
        $this->load->view('backend/index', $page_data);
    }

    function student_marksheet_print_view($student_id, $exam_id) {
        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();

        if ($student_id == "") {
            $student_id = $this->session->userdata('login_user_id');
        }
        $page_data['student_name'] = $this->Student_model->get_student_name($student_id);
        $this->load->model("Mark_model");
        $runningYr = $this->globalSettingsRunningYear;
        $classData = $this->Enroll_model->get_data_by_cols('', array('student_id' => $student_id, 'year' => $runningYr));
        $class_id = $classData[0]->class_id;

        $classData1 = $this->Class_model->get_data_by_id($class_id, 'name');
        $class_name = $classData1;
        $page_data['class_name'] = $class_name;
         
        $exams = $this->Exam_model->get_name_by_id($exam_id);
        $page_data['exam_name'] = $exams;
        $page_data['subjects'] = $this->Subject_model->get_subject_array(array(
            'class_id' => $class_id, 'year' => $runningYr));
        $marks = '';
        $m = 0;
       /* $marksData = array();*/
        if (count($page_data['subjects'])) {
            foreach ($page_data['subjects'] as $k => $subject):
                $marks = $this->Mark_model->get_c_year_mark_obtained_by_subject_exam_class($subject['subject_id'], $exam_id, $class_id, $student_id, $page_data['running_year']);
                if (count($marks)) {
                    $page_data['subjects'][$k]['marks'] = $marks;
                    //pre($marks); 
                    foreach ($marks as $mark) {
                        $grade = $this->Crud_model->get_grade($mark['mark_obtained']);
                        //pre($grade); //die();
                        $page_data['subjects'][$k]['marks'] = $marks;

                        $page_data['subjects'][$k]['grade_name'] = $grade['name'];
                        $total_grade_point = $grade['grade_point'];
                        if ($mark['comment'] == '') {
                            $page_data['subjects'][$k]['comment'] = 'No Comment';
                        } else {
                            $page_data['subjects'][$k]['comment'] = $mark['comment'];
                        }
                        /* $page_data['subjects'][$k]['comment'] = $mark['comment']; */
                    }
                }

                $page_data['subjects'][$k]['highest_mark'] = $this->Crud_model->get_highest_marks($exam_id, $class_id, $subject['subject_id']);

            endforeach; 
        }

        $number_of_subjects = $this->Subject_model->get_average_grade_point($class_id, $page_data['running_year']);

        $page_data['average_grade_point'] = ($total_grade_point / $number_of_subjects);

        /*$page_data['marks_data'] = $marksData;*/
        $page_data['student_info'] = $this->Crud_model->get_student_info($student_id);

        $page_data['student_id'] = $student_id;
        $page_data['class_id'] = $class_id;
        $page_data['exam_id'] = $exam_id;
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        pre($page_data);
        $this->load->view('backend/student/student_marksheet_print_view', $page_data);
    }

    /*     * ********MANAGING CLASS ROUTINE******** */
    /*
     * List class routines for students
     * @return array Student class routine
     */

    function class_routine() {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();

        $this->load->model('Class_routine_model');
        $student_id = $this->session->userdata('student_id');
        $student_profile = $this->Student_model->get_student_details($student_id);
        $page_data['student_details'] = $student_profile;
        $year = $this->globalSettingsRunningYear;
        $running_year = $year;

        $page_data['student_id'] = $student_id;
        $student_details = $this->Class_routine_model->get_c_year_studnet_details_by_student_id($student_id, $this->globalSettingsRunningYear);
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
        $page_data['page_title'] = get_phrase('class_routine');
        $this->load->view('backend/index', $page_data);
    }

    function class_routine_print_view($class_id) {
        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model("Class_routine_model");
        $student_details = $this->Class_routine_model->get_c_year_studnet_details_by_student_id($class_id, $this->globalSettingsRunningYear);
        if (empty($student_details)) {
            redirect('login', 'refresh');
        }
        $daysArr = array("sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday");
        $main_class_routin_data_arr = array();
        foreach ($daysArr AS $k) {
            $class_routin_data = $this->Class_routine_model->get_c_year_details_by_day_section($k, $student_details[0]['class_id'], $student_details[0]['section_id'], $this->globalSettingsRunningYear);
            $main_class_routin_data_arr[$k] = $class_routin_data;
        }

        $page_data['student_details'] = $student_details;
        $page_data['class_routine_data'] = $main_class_routin_data_arr;
        $page_data['class_id'] = $student_details[0]['class_id'];
        $page_data['section_id'] = $student_details[0]['section_id'];
        $page_data['system_name'] = $this->globalSettingsSystemName;
        $this->load->view('backend/student/class_routine_print_view', $page_data);
    }

    // ACADEMIC SYLLABUS
    function academic_syllabus($student_id = '') {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();


        $page_data['page_name'] = 'academic_syllabus';
        $page_data['page_title'] = get_phrase('academic_syllabus');
        $page_data['student_id'] = $student_id;
        $year = $this->globalSettingsRunningYear;
        $page_data['student_name'] = $this->Student_model->get_data_by_cols('name', array('student_id' => $student_id), 'result_array');
        $class_id = $this->Enroll_model->get_data_by_cols('class_id', array('student_id' => $student_id, 'year' => $year), 'result_array');
        foreach ($class_id as $row) {
            $this->load->model('Academic_syllabus_model');
            $this->load->model('Class_model');
            $syllabus = $this->Academic_syllabus_model->get_data_by_cols('*', array('class_id' => $row['class_id'], 'year' => $year), 'result_array');
            $page_data['class_name'] = $this->Class_model->get_data_by_cols('name as class_name', array('class_id' => $row['class_id']), 'result_array');
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
        $page_data = $this->get_page_data_var();
        $this->load->model('Academic_syllabus_model');
        $Academic_syllabus_data = $this->Academic_syllabus_model->get_data_by_cols('*', array('academic_syllabus_code' => $academic_syllabus_code), 'result_array');
        $file_name = $Academic_syllabus_data[0]['file_name'];
        $this->load->helper('download');
        $data = file_get_contents("uploads/syllabus/" . $file_name);
        $name = $file_name;

        force_download($name, $data);
    }

    function transport($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model('Student_bus_allocation_model');
        $this->load->model('Student_model');
        $this->load->model('Route_bus_stop_model');
        $this->load->model('Bus_model');
        $this->load->model('Transport_model');
        $newArray = array();
        $param1 = $this->session->userdata('student_id');
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
        $page_data['page_title'] = get_phrase('transport_details');
        $this->load->view('backend/index', $page_data);
    }

    /*     * ********MANAGE DORMITORY / HOSTELS / ROOMS ******************* */

    function dormitory($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model('Dormitory_model');
        $page_data['dormitories'] = $this->Dormitory_model->get_data_by_cols('*', array(), 'result_array');
        ;
        $page_data['page_name'] = 'dormitory';
        $page_data['page_title'] = get_phrase('manage_dormitory');
        $this->load->view('backend/index', $page_data);
    }

    /*     * ********WATCH NOTICEBOARD AND EVENT ******************* */

    function noticeboard() {
        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model("Notification_model");
        $student_id = $this->session->userdata('student_id');
        $class_id = $this->Student_model->get_class_id_by_student($student_id);
        if (!empty($class_id)) {
            $page_data['notices'] = $this->Notification_model->getNoticesbyclass($class_id[0]['class_id']);
        }
        $page_data['page_name'] = 'noticeboard';
        $page_data['page_title'] = get_phrase('noticeboard');
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['page_name'] = 'noticeboard';
        $page_data['page_title'] = get_phrase('noticeboard');
        $this->load->view('backend/index', $page_data);
    }

    /*     * ********MANAGE DOCUMENT / home work FOR A SPECIFIC CLASS or ALL****************** */

    function document($do = '', $document_id = '') {
        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();

        $page_data['page_name'] = 'manage_document';
        $page_data['page_title'] = get_phrase('manage_documents');
        $this->load->model('Document_model');
        $documents = $this->Document_model->get_data_by_cols('*', array(), 'result_array');
        $page_data['documents'] = $documents;
        $this->load->view('backend/index', $page_data);
    }

    /* private messaging */

    function message($param1 = 'message_home', $param2 = '', $param3 = '') {
        if ($this->session->userdata('student_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $page_data = $this->get_page_data_var();
        $this->load->model('Message_model');
        $this->load->model('School_Admin_model');

        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
        }

        if ($param1 == 'send_new') {
            $message_thread_code = $this->Crud_model->send_new_private_message_admin();
            //$this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?student/message/message_read/' . $message_thread_code, 'refresh');
        }

        if ($param1 == 'send_reply') {
            $this->Crud_model->send_reply_message($param2);  //$param2 = message_thread_code
            //$this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?student/message/message_read/' . $param2, 'refresh');
        }
        if ($param1 == 'message_new') {
            //$page_data['admins'] = $this->School_Admin_model->get_data_by_cols('*', array('status' => '1', 'school_id' => $school_id), 'result_array', array('name'=>'asc'));

            $this->load->model('School_Admin_model');
            $page_data['admins'] = $this->School_Admin_model->get_school_admin();
            
            $page_data['teachers'] = $this->Teacher_model->get_data_by_cols( '*', array('isActive' => '1', 'teacher_status' => '1', 'school_id' => $school_id), 'result_array', array('name'=>'asc'));
           /* $page_data['students'] = $this->Student_model->get_data_by_cols('*', array(), 'result_array');
            $page_data['parents'] = $this->Parent_model->get_data_by_cols('*', array(), 'result_array');*/
        }

        if ($param1 == 'message_read') {

            $page_data['current_message_thread_code'] = $param2;  // $param2 = message_thread_code
            $this->Crud_model->mark_thread_messages_read($param2, $school_id);
            $page_data['messages'] = get_data_generic_fun('message', '*', array('message_thread_code' => $param2, 'message_status' => 'All', 'school_id' => $school_id), 'result_array');
            $parent = array();
            $parent_all = array();
            $i = 0;
            $NewArray = array();
            $img_user = array();
            foreach ($page_data['messages'] as $message) {
                $sender = explode('-', $message['sender']);
                $sender_account_type = $sender[0];
                $sender_id = $sender[1];
                //        $img_user[]['image']=$this->crud_model->get_image_url($sender_account_type, $sender_id);

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
                } else if ($sender_account_type == 'student') {

                    $parent = get_data_generic_fun($sender_account_type, "name,stud_image", array($sender_account_type . '_id' => $sender_id), 'result_array');
                    if (!empty($parent)) {
                        $user_all[]['name'] = $parent[0]['name'];

                        if($parent[0]["stud_image"]!=''){
                            $image[]['image'] = "student_image/" . $parent[0]["stud_image"];
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
            $student_deleted  =   "student_deleted";
            $delete_message = $this->Message_model->delete_msg_thread($param2,$student_deleted);
            $thread_code = $this->Message_model->get_data_by_cols("*", array('message_id'=>$param2), "res_arr");
            if(!empty($thread_code)){
                $thread_code    =   $thread_code[0]['message_thread_code'];
            }
            else{
                $thread_code    =   "";
            }
            if ($delete_message) {
                //$this->session->set_flashdata('flash_message', get_phrase('message_deleted!'));
                redirect(base_url() . 'index.php?student/message/message_read/' . $thread_code, 'refresh');
            } else {
                //$this->session->set_flashdata('flash_message_error', get_phrase('could_not_delete!'));
                redirect(base_url() . 'index.php?student/message/message_read/' . $thread_code, 'refresh');
            }
        }
        $i=0;
        $page_data['current_user'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $current_user_threads = $this->Message_model->get_message_threads($page_data['current_user']);
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
        $page_data['current_thread'] = $param2;
        $page_data['message_inner_page_name'] = $param1;
        $page_data['page_name'] = 'message';
        $page_data['page_title'] = get_phrase('message_board');
        $page_data['total_notif_num'] = $this->get_no_of_notication();

        if(($param1=='message_read') && ($param2!='') && ($param3=='ajax')){
            $this->load->view('backend/student/message_ajax', $page_data);
        }else{
            $this->load->view('backend/index', $page_data);    
        }        
    }

    /*     * ****MANAGE OWN PROFILE AND CHANGE PASSWORD** */
    /*
     * @param $param1 action to do on student profile
     * @return array $page_data student details
     */

    function manage_profile($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        $page_data = $this->get_page_data_var();
        $student_id = $this->session->userdata('student_id');
        if ($param1 == 'update_profile_info') {

            $data['name'] = $this->input->post('name');
            $data['email'] = $this->input->post('email');
            $file_name = $_FILES['userfile']['name'];
            $types = array('image/jpeg', 'image/gif', 'image/png');
            if ($file_name != '') {
                if (in_array($_FILES['userfile']['type'], $types)) {
                    $ext = explode(".", $file_name);
                    $data['stud_image'] = $student_id . "." . end($ext);

                    if (move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $data['stud_image'])) {
                        $this->Student_model->update_student($data, array('student_id' => $student_id));
                        $this->session->set_flashdata('flash_message', get_phrase('account_updated'));
                    }
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('It may be the wrong filetype. We only allow JPG, GIF, and PNG filetypes!!'));
                    // redirect(base_url() . 'index.php?student/manage_profile/', 'refresh');
                }
            } else {
                $this->Student_model->update_student($data, array('student_id' => $student_id));
                //echo $data['image']; exit;
            }
            redirect(base_url() . 'index.php?student/manage_profile/', 'refresh');
        }

        if ($param1 == 'change_password') {
            if (substr($this->input->post('new_password'), 0, 3) == "stu") {
                $data['new_password'] = sha1($this->input->post('new_password'));
                $data['passcode'] = $this->input->post('new_password');
            } else {
                $data['new_password'] = sha1("stu" . $this->input->post('new_password'));
                $data['passcode'] = $this->input->post('new_password');
            }


            $data['confirm_new_password'] = sha1($this->input->post('confirm_new_password'));
            $current_password = $this->Student_model->get_student_record(
                    array('student_id' => $student_id), 'password');
            if ($current_password == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {
                $this->Student_model->update_student(array('password' => $data['new_password'], 'passcode' => $data['passcode']), array('student_id' => $student_id));

                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('password_mismatch'));
            }
            redirect(base_url() . 'index.php?student/manage_profile/', 'refresh');
        }

        $page_data['page_name'] = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $student_details = $this->Student_model->get_data_by_cols('*', array('student_id' => $this->session->userdata('student_id')), 'result_array');
        $page_data['edit_data'] = array_shift($student_details);
        $this->load->view('backend/index', $page_data);
    }

    /*     * ***************SHOW STUDY MATERIAL / for students of a specific class****************** */

    function study_material($task = "", $document_id = "") {
        if ($this->session->userdata('student_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $page_data = $this->get_page_data_var();
        $data = $page_data;
        $this->load->model("Crud_model");
        $this->load->model('Enroll_model');
        $year = $this->globalSettingsRunningYear;
        $class_id = $this->Enroll_model->get_class_id_bystudent_id($this->session->userdata('student_id'), $year);
        $data['study_material_info'] = $this->Crud_model->get_study_material($class_id);
        $data['page_name'] = 'study_material';
        $data['page_title'] = get_phrase('study_material');
        $this->load->view('backend/index', $data);
    }

    function ajax_check_unread_message() {
        $page_data = $this->get_page_data_var();
        $cUserId = $this->input->post('cUserId', TRUE);
        $content = get_unread_message($cUserId, 'student');
        echo $content;
        die;
    }

    public function view_assignments($param1 = '', $param2 = '') {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $student_id = $this->session->userdata('student_id');
        $this->load->model("Student_assignments_model");
        $year = $this->globalSettingsRunningYear;
        $this->load->model('enroll_model');
        $class_id = $this->enroll_model->get_class_id_bystudent_id($student_id, $year);
        $section_id = $this->enroll_model->get_section_id_bystudent_id($student_id, $year);
        if ((!empty($class_id)) && (!empty($section_id))) {
                $this->load->model('Subject_model');
                $page_data['subjects'] = $this->Subject_model->get_subjects_class_section($class_id, $section_id);
            } else {
                $page_data['subjects'] = '';
            }
        $page_data['student_id'] = $this->session->userdata('student_id');
        if ($param1 == 'update') {
            $assignment_answer['assignment_id'] = $param2;
            $assignment_answer['answer'] = trim($this->input->post('answer'));
            $assignment_answer['comments'] = trim($this->input->post('comments'));
            $assignment_answer['file_desc'] = str_replace(' ', '_', trim(addslashes($_FILES['userfile']['name'])));
//            pre($assignment_answer); die;
//            echo "fbsdhfbjsd=".$assignment_answer['file_desc'];exit;
            if (!empty($assignment_answer['file_desc'])) {
                $allowed_types = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.ms-excel',
                    'image/jpeg',
                    'image/png',
                    'image/jpg',
                    'image/jpeg',
                    'text/plain',
                    'application/pdf',
                    'application/msword');
//                echo $_FILES['userfile']['type'];exit;
                if (in_array($_FILES['userfile']['type'], $allowed_types)) {
                    $assignment_answer['file_type'] = $_FILES["userfile"]["type"];
                } else {
                    $this->session->set_flashdata('flash_message_error', 'Sorry, File extension is not supported');
                    redirect(base_url() . 'index.php?student/view_assignments');
                }
            }
//            print_r($assignment_answer); exit;
            if ($this->Student_assignments_model->submit_assignments($assignment_answer)) {

                $dataArray = array('isSubmitted' => '1');
                $condition = array('assignment_id' => $param2);
                if ($this->Student_assignments_model->update_submit($dataArray, $condition)) {
                    move_uploaded_file($_FILES["userfile"]["tmp_name"], "uploads/assignments_answers/" . $assignment_answer['file_desc']);

                    $this->session->set_flashdata('flash_message', get_phrase('assignment_added'));
                }
                $this->session->set_flashdata('flash_message', get_phrase('assignment_submitted_sucessfully'));
                redirect(base_url() . 'index.php?student/view_assignments', 'refresh');
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('assignment_not_succesfull'));
                redirect(base_url() . 'index.php?student/view_assignments', 'refresh');
            }
        }
        $page_data['first_subject'] = $page_data['subjects'];
        $page_data['page_name'] = 'view_assignment';
        $page_data['page_title'] = get_phrase('view_assignment');
        $this->load->view('backend/index', $page_data);
    }

    /*
     * Total number of notification for today
     * 
     */

    public function get_no_of_notication() {
        $page_data = $this->get_page_data_var();
        $this->load->model("Notification_model");
        $user_id = $this->session->userdata('login_user_id');
        $user_notif_user = $this->Notification_model->get_notifications('push_notifications', 'parent', $user_id);
        $user_notif_user_type = $this->Notification_model->get_notifications('push_notifications', 'parent');
        $user_notif_common = $this->Notification_model->get_notifications('push_notifications');
        $total_count = count($user_notif_user) + count($user_notif_user_type) + count($user_notif_common);
        return $total_count;
    }

    /*     * *****Parent feedback function********* */

    function faculty_feedback($param1 = '') {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model('Faculty_feedback_model');
        $this->load->model('Enroll_model');
        $this->load->model('Section_model');
        $this->load->model('Subject_model');
        $student_id = $this->session->userdata('login_user_id');
        $year = $this->globalSettingsSMSDataArr[1]->description;
        $class_det = $this->Enroll_model->get_class_section_by_student($student_id, $year);
        $get_teachers_by_section = array();
        $get_teachers_by_subject = array();
        if (!empty($class_det)) {
            $get_teachers_by_section = $this->Section_model->get_teachername_by_class_section($class_det->class_id, $class_det->section_id);
            $get_teachers_by_subject = $this->Subject_model->get_subjects_class_section($class_det->class_id, $class_det->section_id);
        }
        $page_data['array'] = array_merge($get_teachers_by_section, $get_teachers_by_subject);
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
                redirect(base_url() . 'index.php?student/faculty_feedback');
            } else {
                $this->session->set_flashdata('flash_message_error', validation_errors());
                redirect(base_url() . 'index.php?student/faculty_feedback');
            }
        }
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['teacher_list'] = $teacher_list;
        $page_data['page_name'] = 'faculty_feedback';
        $page_data['page_title'] = get_phrase('faculty_feedback');
        $this->load->view('backend/index', $page_data);
    }

    public function view_topics() {
        $page_data = $this->get_page_data_var();
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        $this->load->model('Enroll_model');
        $this->load->model('Crud_model');
        $student_id = $this->session->userdata('login_user_id');
        $year = $this->globalSettingsRunningYear;
        $class_det = $this->Enroll_model->get_class_section_by_student($student_id, $year);
        $topic_details = array();
        if (!empty($class_det))
            $topic_details = $this->Crud_model->get_topics($class_det->class_id, $class_det->section_id);
        $page_data['topic_details'] = $topic_details;
        $page_data['page_name'] = 'view_topics';
        $page_data['page_title'] = get_phrase('subject_updates');
        $this->load->view('backend/index', $page_data);
    }

    function my_profile() {
        $page_data = $this->get_page_data_var();
        $page_data['page_title'] = get_phrase('my_profile');
        $page_data['page_name'] = 'my_profile';
        $this->load->view('backend/index', $page_data);
    }

    //This is for help menu/page in navigation
    function help() {
        $page_data = $this->get_page_data_var();
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data['page_title'] = get_phrase('help');
        $page_data['page_name'] = 'help';
        $this->load->view('backend/index', $page_data);
    }

    //student documents by beant kaur
    function documents($param1 = '') {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();

        $this->load->model('Crud_model');
        $id = $this->uri->segment(3);
        $this->load->model('S3_model');
        $page_data['files'] = $this->S3_model->get_all_files();

        $instance = $this->Crud_model->get_instance_name();
        $page_data['subfiles'] = $this->S3_model->get_file($page_data['files'][1], $instance . '/student/' . $param1 . '/');
        $page_data['instance'] = $instance . '/student/' . $param1 . '/';
        $page_data['student_id'] = $param1;
//    echo $page_data['student_id'];die;
        $page_data['page_title'] = get_phrase('student_documents');
        $page_data['page_name'] = 'student_documents';
        $this->load->view('backend/index', $page_data);
    }

// print transfer certificate
    function print_transfer_certificate($param1 = '', $param2 = '') {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();

        $this->load->model("Class_model");
        $this->load->model("Parent_model");
        $this->load->model("Enroll_model");
        $this->load->model("Transfer_certificate_model");
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['student'] = $this->Student_model->get_student_record(array('student_id' => $param1));
        $classes = $this->Student_model->get_class_id_by_student($param1);
        //$classes=$classes[0];
        $class_admitted = reset($classes);
        $present_class = end($classes);
        $page_data['class_admitted'] = $this->Class_model->get_class_record(array('class_id' => ($class_admitted['class_id'])), 'class_name');
        $page_data['present_class'] = $this->Class_model->get_class_record(array('class_id' => ($present_class['class_id'])), 'class_name');
//        $page_data['running_year']=$this->globalSettingsRunningYear;
        $page_data['running_year'] = $this->globalSettingsRunningYear;

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
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();

        $this->load->model("Class_model");
        $this->load->model("Transfer_certificate_model");
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

    function upload_document($param1 = '') {
        $page_data = $this->get_page_data_var();

        $this->load->model('S3_model');
        $this->load->model('Crud_model');
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'pdf|docx|doc|txt|jpg|jpeg|png';
        $config['max_size'] = 100000;


        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile')) {
            $this->session->set_flashdata('flash_message_error', $this->upload->display_errors());
            redirect(base_url() . 'index.php?student/documents/' . $param1, 'refresh');
        } else {
            $data = $this->upload->data();
            $instance = $this->Crud_model->get_instance_name();
            $filepath = $instance . '/student/' . $param1 . '/' . $data['file_name'];
            $this->S3_model->upload($this->upload->data()['full_path'], $filepath);
            unlink($this->upload->data()['full_path']);
            //exit;
            $this->session->set_flashdata('flash_message', get_phrase('document_uploaded_successfully'));
            redirect(base_url() . 'index.php?student/documents/' . $param1, 'refresh');
        }
    }

    function download_document($param1 = '', $param2 = '', $param3 = '', $param4 = '') {
        $page_data = $this->get_page_data_var();
        $this->load->helper('download');
        $param4 = str_replace('%20', ' ', $param4);
        $file_path = implode('/', array($param1, $param2, $param3, $param4));
        if ($this->session->userdata('student_login') != 1)
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

    function get_page_data_var() {
        $this->load->model('Crud_model');
        $page_data = array();
        $page_data['system_name'] = $this->globalSettingsSystemName;
        $page_data['system_title'] = $this->globalSettingsSystemTitle;
        $page_data['text_align'] = $this->globalSettingsTextAlign;
        $page_data['skin_colour'] = $this->globalSettingsSkinColour;
        $page_data['active_sms_service'] = $this->globalSettingsActiveSmsService;
        $page_data['running_year'] = $this->globalSettingsRunningYear;
        $page_data['location'] = $this->globalSettingsLocation;
        $page_data['app_package_name'] = $this->globalSettingsAppPackageName;
        $page_data['system_email'] = $this->globalSettingsSystemEamil;
        $page_data['system_fcm_server_key'] = $this->globalSettingsSystemFCMServerrKey;
        $page_data['account_type'] = $this->session->userdata('login_type');
        $user_type = $this->session->userdata('login_type');
        $page_data['filename'] = $this->Crud_model->getSpecificRecord($this->session->userdata('table'), $this->session->userdata($user_type . '_id'));
        return $page_data;
    }
    
    
    function homework_submit($homework_id)
    {
        
       
        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();
        if (empty($student_id)) {
            $student_id = $this->session->userdata('student_id');
        }
        
        $this->load->model('Homeworks_model');
        $this->load->model("Student_model");
        $parent_id = $this->Student_model->get_data_by_cols('parent_id', array("student_id"=>$student_id ), "result_arr");
        $homeworks = $this->Homeworks_model->get_data_by_cols('*', array("home_work_id"=>$homework_id ), "result_arr");
        
        $page_data['homeworks'] = $homeworks;
        $page_data['student_id'] = $student_id;
        $page_data['parent_id'] = $parent_id[0]['parent_id'];
        $page_data['total']    = $total =   0;    
        if(!empty($homeworks[0]['duration'])){
            $page_data['total']  = $total   =   ($homeworks[0]['duration']*60); //time in seconds 
        }
        
        
        //echo $this->session->userdata('time_stamp');exit;
        if(!$this->session->userdata('time_stamp')){
            $this->session->set_userdata('time_stamp',time());
        }
        
        if($this->session->userdata('time_stamp')){
            $diff = time() - $this->session->userdata('time_stamp');
            $page_data['total']  = $total = ($total-$diff);
        }
        
        
        $page_data['page_title']    =   get_phrase('homework_submit');
        $page_data['page_name']     =   'homework_submit';
        $this->load->view('backend/index', $page_data);
    }
    function attempt_exam($exam_id = ''){
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');
        $this->load->library('pagination');
        $this->load->model('Online_exam_model');
        $this->load->model('Question_model');
        $this->load->helper('form');
        $this->load->helper('url');
        $page_data                  =   $this->get_page_data_var();
        $config                     =   array();
        $config["base_url"]         =   base_url()."index.php?student/attempt_exam/".$exam_id;
        $total_row                  =   $this->Question_model->record_count();
        $config["total_rows"]       =   $total_row;
        $config["per_page"]         =   1;
        $config['use_page_numbers'] =   TRUE;
        $config['num_links']        =   $total_row;
        $config['cur_tag_open']     =   '&nbsp;<a class="current">';
        $config['cur_tag_close']    =   '</a>';
        $config['next_link']        =   'Next';
        $config['prev_link']        =   'Previous';       
        $this->pagination->initialize($config);
        ///this for your question id 
        $page_data['page'] = $page = 1;
        if($this->uri->segment(4)){
           $page_data['page'] = $page = ($this->uri->segment(4)) ;
        }


        $exm_ended = $this->db->get_where('student_online_exam_attempt',array('exam_id'=>$exam_id,
                                            'student_id'=>$this->session->userdata('student_id'),'ended'=>1))->row();   
        if($exm_ended){
            redirect('index.php?student/my_online_result/');
        }
        // below for answer optiion value
        // if($this->uri->segment(5)){
        //     $answere_option_value = ($this->uri->segment(5)) ;
        // }
        // else{
        //        $answere_option_value = "";
        // }
        $duration =  $this->Online_exam_model->get_data_by_cols('duration',array('id'=>$exam_id),'result_array');
        $page_data['total']    = $total =   0;    
        if(!empty($duration)){
            $page_data['total']  = $total   =   ($duration[0]['duration']*60); //time in seconds 
        }
        // pre($page_data);
        // die;
        $this->load->model('Online_exam_answers_model');
        //$page_data['answere_option_value']=$answere_option_value;
        // $page_data['homequestions']     =   $this->Question_model->get_data_by_cols('*',array('exam_id'=>$exam_id),'result_array');

        $page_data['question'] = $this->db->get_where('questions',array('exam_id'=>$exam_id,'order'=>$page))->row();
        //echo '<pre>';print_r($page_data['question']);exit;

        $page_data['subjects']      =   $this->Subject_model->get_subject_online_exam($exam_id);
        $page_data['exam_id']       =   $exam_id;
        // $page_data["results"]       =   $this->Question_model->get_data_by_cols('*',array('exam_id'=>$exam_id,'order'=>$page),'result_array',array(),$limit = $config["per_page"]);
        //pre($page_data["results"] );exit;
        $page_data['answer'] = false;
        if($page_data['question']){
            if($page==1){
               $atmpt = $this->db->get_where('student_online_exam_attempt',array('exam_id'=>$exam_id,
                                                'student_id'=>$this->session->userdata('student_id')))->row(); 
               if(!$atmpt){
                    $save_array = array('student_id'=>$this->session->userdata('student_id'),   
                                        'exam_id'=>$exam_id,
                                        'start_time'=>date('Y-m-d H:i:s'), 
                                        'started' =>1, 
                                        'progress' =>$page,
                                        //'status' =>'', 
                                        'school_id' =>$this->session->userdata('school_id'));
                    $flag = $this->db->insert('student_online_exam_attempt',$save_array); 
               }
            }
            $atmpt = $this->db->get_where('student_online_exam_attempt',array('exam_id'=>$exam_id,
                                                'student_id'=>$this->session->userdata('student_id')))->row();  
            // $flag = $this->db->update('student_online_exam_attempt',array('progress_time'=>date('Y-m-d H:i:s')),
            //                                         array('id'=>$atmpt->id)); 
            // $atmpt = $this->db->get_where('student_online_exam_attempt',array('id'=>$atmpt->id))->row();   

            $to_time = date('Y-m-d H:i:s');
            // if($page==1){
            //     $from_time = $atmpt->start_time;
            // }else{
            //     $prev_ques = $this->db->get_where('questions',array('exam_id'=>$exam_id,'order'=>($page-1)))->row();
            //     $prev_ans   =  $this->db->get_where('online_exam_answers',array('exam_id'=>$exam_id,
            //                                     'question_id'=>$prev_ques->id,
            //                                     'student_id'=>$this->session->userdata('student_id')))->row(); 
            //     $from_time = $prev_ans->created_date;
            // }
            $from_time = $atmpt->start_time;
            $sec_diff = strtotime($to_time) - strtotime($from_time);   

            if($sec_diff<$total){
                $page_data['total']  = $total = ($total- $sec_diff);  
            }else{
                $flag = $this->db->updated('student_online_exam_attempt',array('end_time'=>date('Y-m-d H:i:s'),'ended'=>1),array('id'=>$atmpt->id)); 
                redirect('index.php?student/my_online_result/');
            }
            //echo $page_data['total'] ;exit;

            $page_data['answer']   =  $this->db->get_where('online_exam_answers',array('exam_id'=>$exam_id,
                                                'question_id'=>$page_data['question']->id,
                                                'student_id'=>$this->session->userdata('student_id')))->row(); 
            //echo '<pre>';print_r( $page_data['answer']);exit;  
            //$str_links                  =   $this->pagination->create_links();
            //$page_data["links"]         =   explode('&nbsp;',$str_links);
            $page_data['page_title']    =   get_phrase('attempt_exam');
            $page_data['page_name']     =   'attempt_exam';
            $this->load->view('backend/index', $page_data);
        }
        else{
            redirect(base_url() . 'index.php?student/my_online_result/', 'refresh');
        }
    }
    
    public function online_polls( $action = '' , $poll_id = '') {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data                  =   $this->get_page_data_var();
        $this->load->model("Onlinepoll_model");
        $this->load->model("Class_model");

        
        $page_data['page_name']             =   'online_polls';
        $page_data['page_title']            =   get_phrase('online_polls');
        $student_id                         =   $this->session->userdata('student_id');
        
        
        $student_det                        =   $this->Student_model->get_student_details((int)$student_id);
        $class_id                           =   $student_det->class_id;
        $section_id                         =   $student_det->section_id;
        
        $online_polls                       =   $this->Onlinepoll_model->getOninePolls( );
        $online_poll_list                   =   $online_polls;
        foreach($online_polls as $key=>$poll) {
            //check parent already polled and unset
            $polled_students                         =   explode(",",$poll['student_ids']);
            if(in_array($student_id,$polled_students)) {
                unset($online_poll_list[$key]);
                continue;
            }
            
            
            if($poll['classes'] != 0){
                $class_ids                  =   explode(',',$poll['classes']);
                $class_found                =   0;
                if(in_array($class_id, $class_ids)) {
                    $class_found        =   1;
                }
                if($class_found == 0) {
                    unset($online_poll_list[$key]);
                }
            }
            
            $answer                                 =   $this->Onlinepoll_model->getOnlinpollAnswer(array('poll_id'=>$poll['poll_id']));
            if(!$answer)
                $answer                             =   array();
            
            $online_poll_list[$key]['answer_det']       =   $answer;
            $total_poll                             =   $this->Onlinepoll_model->getPollCount($poll['poll_id']);
            $online_poll_list[$key]['total_poll']       =   $total_poll[0]->total_poll;
            
        }
        if($action == 'polled') {
            $this->session->set_flashdata('flash_message', get_phrase('poll_updated_successfully'));
            redirect(base_url() . 'index.php?student/online_polls/' , 'refresh');
        }
        
        $page_data['online_polls']          =   $online_poll_list;
        $this->load->view('backend/index', $page_data);
    }
    function submit_online_exam(){
        //$this->load->model('Online_exam_answers_model');
        //$this->load->model('Question_model');
        $order = $this->input->post('order');
        $last_quest = $this->db->order_by('order','DESC')->get_where('questions', array('exam_id'=>$this->input->post('exam_id')))->row();
        $question = $this->db->get_where('questions',array('id'=>$this->input->post('question_id')))->row();    

        if($question->qtype_id ==  1){
            if($question->answer ==  1){
                 $real_answer =   $question->option1;       
            }if($question->answer ==  2){
                 $real_answer =   $question->option2;       
            }if($question->answer ==  3){
                 $real_answer =   $question->option3;       
            }if($question->answer ==  4){
                 $real_answer =   $question->option4;       
            }if($question->answer ==  5){
                 $real_answer =   $question->option5;       
            }if($question->answer ==  6){
                 $real_answer =   $question->option6;       
            }    
           
        } else if($question->qtype_id ==  2){
            $real_answer = $question->true_false;     
        }
        else if($question->qtype_id   ==  3){
            $real_answer = $question->fill_blank;
        }
        else if($question->qtype_id   ==  4){
            $real_answer = $question->explanation;            
        }   

        if($this->input->post('answer')==$real_answer){
            $marks = $question->marks;
        }else{
            $marks = '-'.$question->negative_marks;
        }

        $save_array = array('exam_id'=>$this->input->post('exam_id'),   
                            'question_id'=>$this->input->post('question_id'),
                            'answer'=>$this->input->post('answer'), 
                            'student_id' =>$this->session->userdata('student_id'), 
                            'marks'=>$marks,
                            'school_id' =>$this->session->userdata('school_id'));
        $flag = $this->db->insert('online_exam_answers',$save_array); 

        if($last_quest->order==$order){
            $atmpt = $this->db->get_where('student_online_exam_attempt',array('exam_id'=>$this->input->post('exam_id'),
                                                'student_id'=>$this->session->userdata('student_id')))->row(); 
            $flag = $this->db->update('student_online_exam_attempt',array('end_time'=>date('Y-m-d H:i:s'),'ended'=>1),array('id'=>$atmpt->id)); 
            redirect('index.php?student/my_online_result/');
        }


        //echo '<pre>';print_r($_POST);exit;
        // //echo '<pre>';print_r($_POST);exit;
        // $qtype  =   $this->input->post('qtype');
        // if($qtype   ==  1){
        //     $option =   $this->Question_model->get_data_by_cols('answer',array('exam_id'=>$this->input->post('exam_id'),
        //                                     'id'=>$this->input->post('question_id')),'result_array');
        //     if(!empty($option)){
        //         if($option[0]['answer'] ==  1){
        //             $result =   $this->Question_model->get_data_by_cols('option1 as question_answer,marks,negative_marks',array('exam_id'=>$this->input->post('exam_id'),
        //                                             'id'=>$this->input->post('question_id')),'result_array');
        //             }
        //             else if($option[0]['answer'] ==  2){
        //             $result =   $this->Question_model->get_data_by_cols('option2 as question_answer,marks,negative_marks',array('exam_id'=>$this->input->post('exam_id'),
        //                                             'id'=>$this->input->post('question_id')),'result_array');
        //             }
        //             else if($option[0]['answer'] ==  3){
        //             $result =   $this->Question_model->get_data_by_cols('option3 as question_answer,marks,negative_marks',array('exam_id'=>$this->input->post('exam_id'),
        //                                             'id'=>$this->input->post('question_id')),'result_array');
        //             }
        //             else if($option[0]['answer'] ==  4){
        //             $result =   $this->Question_model->get_data_by_cols('option4 as question_answer,marks,negative_marks',array('exam_id'=>$this->input->post('exam_id'),
        //                                             'id'=>$this->input->post('question_id')),'result_array');
        //             }
        //             else if($option[0]['answer'] ==  5){
        //             $result =   $this->Question_model->get_data_by_cols('option5 as question_answer,marks,negative_marks',array('exam_id'=>$this->input->post('exam_id'),
        //                                             'id'=>$this->input->post('question_id')),'result_array');
        //             }
        //             else if($option[0]['answer'] ==  6){
        //             $result =   $this->Question_model->get_data_by_cols('option6 as question_answer,marks,negative_marks',array('exam_id'=>$this->input->post('exam_id'),
        //                                             'id'=>$this->input->post('question_id')),'result_array');
        //             }
        //     }
        // }
        // else if($qtype   ==  2){
        //     $result =   $this->Question_model->get_data_by_cols('true_false as question_answer,marks,negative_marks',array('exam_id'=>$this->input->post('exam_id'),
        //                                     'id'=>$this->input->post('question_id')),'result_array');
        // }
        // else if($qtype   ==  3){
        //     $result =   $this->Question_model->get_data_by_cols('fill_blank as question_answer,marks,negative_marks',array('exam_id'=>$this->input->post('exam_id'),
        //                                     'id'=>$this->input->post('question_id')),'result_array');
        // }
        // else if($qtype   ==  4){
        //     $result =   $this->Question_model->get_data_by_cols('explanation as question_answer,marks,negative_marks',array('exam_id'=>$this->input->post('exam_id'),
        //                                     'id'=>$this->input->post('question_id')),'result_array');
        // }
        // $answer=$this->input->post('answer');
        // if(!empty($result)){
        //     if($result[0]['question_answer']    ==  $answer){
        //         $marks          =   $result[0]['marks'];
        //     }
        //     else{
        //         $marks          =   "-".$result[0]['negative_marks'];
        //     }
        // }
        // $order  =   $this->input->post('order');
        // $save_data              =   array('exam_id'=>$this->input->post('exam_id'),
        //                                 'question_id'=>$this->input->post('question_id'),
        //                                 'answer'=>$this->input->post('answer'),
        //                                 'student_id'=>$this->session->userdata('student_id'),'marks'=>$marks);
        // $record                 =    $this->Online_exam_answers_model->get_data_by_cols('*',array('exam_id'=>$this->input->post('exam_id'),
        //                                                     'question_id'=>$this->input->post('question_id'),
        //                                                     'student_id'=>$this->session->userdata('student_id')),'result_array');
        // if($record){ //echo '<pre>';print_r($record);exit;
        //     $id_condition       =   array('online_exam_answers_id'=>$record[0]['online_exam_answers_id']);
        //     $flag               =   $this->Online_exam_answers_model->update_data($save_data,$id_condition);
        // }
        // else{
        //     $flag               =   $this->Online_exam_answers_model->add_data($save_data);
                    
        // }
        if($flag){
          //$qrecord  =   $this->db->get_where('questions',array('id'=>$this->input->post('question_id')))->row();  
          
          redirect(base_url().'index.php?student/attempt_exam/'.$this->input->post('exam_id').'/'.($order+1));
        }
        
    }
    public function incident() {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');
        $this->load->model('Incident_model');
        $page_data                  =   array();
        $page_data                  =   $this->get_page_data_var();
        $student_id                 =   $this->session->userdata('student_id');
        $page_data['details']       =   $this->Incident_model->get_details_student_id($student_id);
        $page_data['page_name']     =   'incident';
        $page_data['page_title']    =   get_phrase('incident');
        $page_data['total_notif_num']=  $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }
    public function my_online_result() {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');
        $this->load->model('Online_exam_model');
        $this->load->model('Online_exam_answers_model');
        $this->load->model('Question_model');
        $page_data                  =   array();
        $page_data                  =   $this->get_page_data_var();
        $student_id                 =   $this->session->userdata('student_id');
        $enrollData = $this->Enroll_model->get_data_by_cols('*', array('student_id' => $student_id, 'year' => $this->globalSettingsRunningYear), 'result_arr');
        if(!empty($enrollData)){
            $class_id = $enrollData[0]['class_id'];
        }
        else{
            $class_id="";
        }
        $this->load->model('Online_exam_model');
        $online_exam = $this->Online_exam_model->get_exam_data_class_id_student_login($class_id);
        foreach($online_exam as $exam){
             $student_total   =   $this->Online_exam_answers_model->get_total($exam['id'],$student_id);
             if(!empty($student_total[0]['result'])){
             $percent[]['result']           =   $student_total[0]['result'];
             }
             else if($student_total[0]['result']    ==  "0"){
                 $percent[]['result']       =   "0";
             }
             else{
                 $percent[]['result']       =   "Exam_not_attempted";
             }
        }
        $i=0;
        $newArray=array();
        foreach($online_exam as $value){
           $newArray[$i] = array_merge($value, $percent[$i]);
            $i++;
        }
        $page_data['details']       =   $newArray;
        $page_data['page_name']     =   'my_online_result';
        $page_data['page_title']    =   get_phrase('my_result');
        $page_data['total_notif_num']=  $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }
    
    function certificates(){
        $page_data = $this->get_page_data_var();
         if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');
       $this->load->model('Student_certificate_model');
        $page_data                  =   array();
        $page_data                  =   $this->get_page_data_var();
        $student_id                 =   $this->session->userdata('student_id');
        $page_data['page_name'] = 'view_certificate';
        $page_data['page_title'] = get_phrase('student_certificate_list');
        $condition = array('student_id' => $student_id);
        $sortArr = array('certificate_id' => 'desc');
        $page_data['certificate_list'] = $this->Student_certificate_model->get_data_by_cols('*', $condition, 'result_type', $sortArr);
        $this->load->view('backend/index', $page_data);
    }
    
    function template1($param1='',$param2='',$param3=''){
    if ($this->session->userdata('student_login') != 1)
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
    if ($this->session->userdata('student_login') != 1)
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
     if ($this->session->userdata('student_login') != 1)
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
        if ($this->session->userdata('student_login') != 1)
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

   function online_polls_result(){
       if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data                  =   $this->get_page_data_var();
        $this->load->model("Onlinepoll_model");
        $this->load->model("Class_model");

        
        $page_data['page_name']             =   'online_polls_result';
        $page_data['page_title']            =   get_phrase('online_polls_result');
        $student_id                         =   $this->session->userdata('student_id');
        
        
        $student_det                        =   $this->Student_model->get_student_details((int)$student_id);
        $class_id                           =   $student_det->class_id;
        $section_id                         =   $student_det->section_id;
        
        $online_polls                       =   $this->Onlinepoll_model->get_closed_online_polls( );
        $online_poll_list                   =   $online_polls;
        foreach($online_polls as $key=>$poll) {
            //check parent already polled and unset
            $polled_students                         =   explode(",",$poll['student_ids']);
            if(!in_array($student_id,$polled_students)) {
                unset($online_poll_list[$key]);
                continue;
            }
            
            
            if($poll['classes'] != 0){
                $class_ids                  =   explode(',',$poll['classes']);
                $class_found                =   0;
                if(in_array($class_id, $class_ids)) {
                    $class_found        =   1;
                }
                if($class_found == 0) {
                    unset($online_poll_list[$key]);
                }
            }
            
            $answer                                 =   $this->Onlinepoll_model->getOnlinpollAnswer(array('poll_id'=>$poll['poll_id']));
            if(!$answer)
                $answer                             =   array();
            
            $online_poll_list[$key]['answer_det']       =   $answer;
            $total_poll                             =   $this->Onlinepoll_model->getPollCount($poll['poll_id']);
            $online_poll_list[$key]['total_poll']       =   $total_poll[0]->total_poll;
            
        }
        
        $page_data['online_polls']          =   $online_poll_list;
        $this->load->view('backend/index', $page_data);
   }
}
