<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Teacher extends CI_Controller {

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
        $this->load->library('form_validation');
        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        //$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        //$this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        $this->load->model("Teacher_model");
        $this->load->model('Class_model');
        $this->load->model('Parent_teacher_meeting_date_model');
        $this->load->model('Student_model');
        $this->load->model('Parent_model');
        $this->load->model('Parent_teacher_meeting_model');
        $this->load->model('Setting_model');
        $this->load->model('Enroll_model');
        $this->load->model('Section_model');
        $this->load->model('Student_assignments_model');
        $this->load->model('Subject_model');
        $this->load->model('Exam_model');
        $this->load->model('Question_model');
        $this->load->model('Mark_model');
        $this->load->model('Academic_syllabus_model');
        $this->load->model('Progress_model');
        $this->load->model('Attendance_model');
        $this->load->model('Book_model');
        $this->load->model('Document_model');
        $this->load->model('Notice_board_model');
        $this->load->model('Class_routine_model');
        $this->load->model("Transport_model");
        $this->load->helper("send_notifications");
        $this->load->model('Student_progress_report_model');

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
        $this->globalSettingsActiveSms = $this->globalSettingsActiveSmsService;
    }

    /*     * *default functin, redirects to login page if no teacher logged in yet** */

    public function index() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($this->session->userdata('teacher_login') == 1)
            redirect(base_url() . 'index.php?teacher/dashboard', 'refresh');
    }

    /*     * *TEACHER DASHBOARD** */

    function dashboard() {
        $this->load->helper('functions');
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model('Subject_model');
        $this->load->model('Student_model');
        $this->load->model('Exam_model');
        $this->load->model('Event_model');
        $this->load->model("Crud_model");
        $links = array();


        // Dynamic Links
        $teacher_id = $this->session->userdata('teacher_id');
        $exams = $this->Exam_model->get_exam_routine(array('invigilator' => $teacher_id));
        $page_data['teacher_count'] = $this->Teacher_model->count_all();
        $page_data['parent_count'] = $this->Parent_model->count_all();
        $page_data['present_today'] = $this->Attendance_model->get_today_attendance();

        $events = array();
        $event = array();
        foreach ($exams as $exam) {
            $exam_name = $this->Exam_model->get_exam_name($exam['exam_id']);
            $subject_name = $this->Subject_model->get_subject_record(array('subject_id' => $exam['subject_id']), "name");
            $event['id'] = $exam['exam_routine_id'];
            $event['title'] = $exam_name . ":" . $exam['room_no'] . ":" . $subject_name;
            $event['start'] = $exam['start_datetime'];
            $time = new DateTime($exam['start_datetime']);
            $time->add(new DateInterval('PT' . $exam['duration'] . 'M'));
            $stamp = $time->format('Y-m-d H:i');
            $event['end'] = $stamp;
            $event['description'] = "Exam Duty Room No: " . $exam['room_no'];
            array_push($events, $event);
        }

        $notices = $this->Notice_board_model->get_data_by_cols('', array(), 'result_array');

        foreach ($notices as $notice) {
            $event['id'] = $notice['notice_id'];
            $event['title'] = $notice['notice_title'];
            $event['start'] = date('Y-m-d H:i:s', strtotime($notice['create_timestamp']));
            $event['end'] = date('Y-m-d H:i:s', strtotime($notice['create_timestamp']));
            $event['description'] = $notice['notice'];
            array_push($events, $event);
        }
        $page_data['types'] = $this->Event_model->getEventTypes();
        $page_data['page_name'] = 'dashboard';
        $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
        $page_data['events'] = $events;
        $page_data['count'] = $this->Student_model->get_count_curent_year($running_year);
        $page_data['page_title'] = get_phrase('teacher_dashboard');
        $page_data['account_type'] = $this->session->userdata('login_type');
        $page_data['arrAllLinks'] = $this->session->userdata('arrAllLinks');
        //$arrModule
        //$page_data['arrModule'] =  $arrModule;   
        $this->load->view('backend/index', $page_data);
    }

    function event_calender($param1 = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data= $this->get_page_data_var();

        $school_id = '';
        if (($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
        }        
        $receiver_id = $this->session->userdata('login_user_id');
        $where2 = array('message_schedule_status'=>'1', 'push_notify'=>'1', 'receiver_id'=>$receiver_id, 'receiver_type'=>'T', 'school_id'=>$school_id);
        $this->db->where($where2);
        $this->db->update('custom_message_noticeboard', 
            array('is_read'=>'1'));
        redirect(base_url() . 'index.php?teacher/dashboard/');
    }

    /* ENTRY OF A NEW STUDENT */


    /*     * **MANAGE STUDENTS CLASSWISE**** */

    function student_add() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $page_data['parents'] = get_data_generic_fun('parent', 'parent_id,father_name,father_mname,father_lname', array(), 'result_arr');
        $page_data['classes'] = get_data_generic_fun('class', '*', array(), 'result_arr');
        $page_data['page_name'] = 'student_add';
        $page_data['page_title'] = get_phrase('add_student');
        $page_data['parents'] = get_data_generic_fun('parent', '*', array(), 'result_arr');
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    function student_information($class_id = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model("Class_model");
        if (empty($class_id)) {
            $class_id = $this->Class_model->get_first_class_id($this->session->userdata('teacher_id'));
        }
        //echo $class_id;die;
        $page_data['page_title'] = get_phrase('student_information');

        $page_data['page_name'] = 'student_information';
        $page_data['class_id'] = $class_id;
        $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');

        $page_data['classes'] = $this->Class_model->get_data_by_cols('*', array('teacher_id' => $this->session->userdata('teacher_id')), 'result_array');

        if($class_id > 0){
            $class_array = array('class_id' => $class_id);
            $this->load->model("Class_model");
            $page_data['sections'] = $this->Class_model->get_section_array($class_array);
            
            $page_data['page_title'] = get_phrase('student_information') . " - " . get_phrase('class') . " : " . $this->Crud_model->get_class_name($class_id);            
        } 
        /* $i = 0;
          $NewArray = array();
          $all_section_student_array = array();
          foreach ($page_data['sections'] as $section) {
          $selected_section_student = $this->Student_model->getstudents_section($class_id, $running_year, $section['section_id']);
          $studentss[]['student_all'] = $selected_section_student;
          foreach ($selected_section_student as $key => $value) {
          $all_section_student_array[] = $value;
          }
          // pre($all_section_student_array);
          $NewArray[$i] = array_merge($section, $studentss[$i]);
          $i++; //die;
          } */
        //pre($all_section_student_array);die;
        //$page_data['students'] = $all_section_student_array;
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        //$page_data['all_records'] = $NewArray;

        $this->load->view('backend/index', $page_data);
    }

    function student_marksheet($student_id = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();
        $page_data = array();
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

    function student_marksheet_print_view($student_id, $exam_id) {
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();
        $runningYr = $this->Setting_model->get_year();
        $classData = $this->Enroll_model->get_data_by_cols('', array('student_id' => $student_id, 'year' => $runningYr));
        $class_id = $classData[0]->class_id;

        $classData1 = $this->Class_model->get_data_by_id($class_id, 'name');
        $class_name = $classData1[0]->name;

        $exams = $this->Crud_model->get_exams();
        $marks = '';
        $m = 0;
        $marksData = array();

        $page_data['marks_data'] = $marksData;
        $page_data['student_info'] = $this->Crud_model->get_student_info($student_id);

        $examData = $this->Exam_model->get_data_by_cols('', array('exam_id' => $exam_id), 'result_array');
        $row2 = $examData[0];
        $subjects = $this->Subject_model->get_data_by_cols('', array('class_id' => $class_id), 'result_array');
        $k = 0;
        foreach ($subjects as $row3) {
            $row2['exam_id'] = $exam_id;
            $obtained_mark_query = $this->Mark_model->get_c_year_mark_obtained_by_subject_exam_class($row3['subject_id'], $row2['exam_id'], $class_id, $student_id, $runningYr);

            $marksData[$m]['subject'][$k] = $row3;
            $s = 0;
            if ($obtained_mark_query > 0) {
                foreach ($obtained_mark_query as $row4) {
                    $marksData[$m]['subject'][$k]['obtained'][$s] = $row4;

                    if ($row4['mark_obtained'] >= 0 || $row4['mark_obtained'] != '') {
                        $marksData[$m]['subject'][$k]['obtained'][$s]['grade'] = $this->Crud_model->get_grade($row4['mark_obtained']);
                    }
                    $s++;
                }
            }

            $highestMark = $this->Crud_model->get_highest_marks($row2['exam_id'], $class_id, $row3['subject_id']);
            $marksData[$m]['subject'][$k]['highest_mark'] = $highestMark;

            $tot_subjects_data = $this->Subject_model->get_data_by_cols('', array('class_id' => $class_id, 'year' => $runningYr), 'result_array');
            $marksData[$m]['subject'][$k]['tot_subjects'] = count($tot_subjects_data);

            $k++;
        }
        //pre($marksData);
        $page_data['marks_data'] = $marksData;
        $page_data['student_id'] = $student_id;
        $page_data['class_id'] = $class_id;
        $page_data['exam_id'] = $exam_id;
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/teacher/student_marksheet_print_view', $page_data);
    }

    function student($param1 = '', $param2 = '', $param3 = '') {
        $this->load->helper("email_helper");
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();
        if ($param1 == 'create') {
            $this->form_validation->set_rules('name', 'Student Name', 'trim|required');
            $this->form_validation->set_rules('parent_id', 'Parent', 'trim|required');
            $this->form_validation->set_rules('class_id', 'Class', 'trim|required');
            $this->form_validation->set_rules('roll', 'Roll No', 'trim|required');
            $this->form_validation->set_rules('birthday', 'Date of Birth', 'trim|required');
            $this->form_validation->set_rules('sex', 'Gender', 'trim|required');
            $this->form_validation->set_rules('address', 'Address', 'trim|required');

            $this->form_validation->set_rules('phone', 'Phone Number', 'required|numeric|min_length[10]|max_length[12]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[student.email]');
            $this->form_validation->set_rules('userfile', 'Student Photo', 'callback_validate_student_image');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('flash_message_error', validation_errors());
                redirect(base_url() . 'index.php?teacher/student_add/');
            } else {
                $data['name'] = $this->input->post('name');
                $data['birthday'] = $this->input->post('birthday');
                $data['sex'] = $this->input->post('sex');
                $data['address'] = $this->input->post('address');
                $data['phone'] = $this->input->post('phone');
                $data['email'] = $this->input->post('email');
                $data['password'] = sha1($this->input->post('password'));
                $data['parent_id'] = $this->input->post('parent_id');
                $data['dormitory_id'] = $this->input->post('dormitory_id');
                $data['transport_id'] = $this->input->post('transport_id');

                $student_id = $this->Student_model->save_student($data);


                $data2['student_id'] = $student_id;
                $data2['enroll_code'] = substr(md5(rand(0, 1000000)), 0, 7);
                $data2['class_id'] = $this->input->post('class_id');
                if ($this->input->post('section_id') != '') {
                    $data2['section_id'] = $this->input->post('section_id');
                }

                $data2['roll'] = $this->input->post('roll');
                $data2['date_added'] = date("Y-m-d H:i:s");
                $running_year = get_data_generic_fun('settings', 'description', array('type' => 'running_year'), 'result_arr');
                $data2['year'] = $running_year[0]['description'];

                $this->Enroll_model->add($data2);

                $password = $this->input->post('password');
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $student_id . '.jpg');
                $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
                // $this->load->model('Email_model');
                // $this->Email_model->account_opening_email('student', $data['email'],$this->input->post('password')); //SEND EMAIL ACCOUNT OPENING EMAIL
                send_common_mail($data['email'], 'Student Added', $password, '');
                redirect(base_url() . 'index.php?teacher/student_add/', 'refresh');
            }
        }
        if ($param1 == 'do_update') {
            $data['name'] = $this->input->post('name');
            $data['birthday'] = $this->input->post('birthday');
            $data['sex'] = $this->input->post('sex');
            $data['address'] = $this->input->post('address');
            $data['phone'] = $this->input->post('phone');
            $data['email'] = $this->input->post('email');
            $data['parent_id'] = $this->input->post('parent_id');
            $data['dormitory_id'] = $this->input->post('dormitory_id');
            $data['transport_id'] = $this->input->post('transport_id');

            $this->Student_model->update_student($data, array('student_id' => $param2));

            $data2['section_id'] = $this->input->post('section_id');
            $data2['roll'] = $this->input->post('roll');

            $running_year = $this->Setting_model->get_year();

            $this->Enroll_model->update_data(array('section_id' => $data2['section_id'], 'roll' => $data2['roll']), array('student_id' => $param2, 'year' => $running_year));

            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $param3 . '.jpg');
            //$this->crud_model->clear_cache();
            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
            redirect(base_url() . 'index.php?teacher/student_information/' . $param3, 'refresh');
        }

        if ($param1 == 'delete') {
            $this->Student_model->delete_student_record($param3);
            redirect(base_url() . 'index.php?teacher/student_information/' . $param1, 'refresh');
        }
    }

    function get_class_section($class_id) {
        $page_data = $this->get_page_data_var();
        $sections = $this->Section_model->get_data_by_cols('', array('class_id' => $class_id));
        foreach ($sections as $row) {
            echo '<option value="' . $row['section_id'] . '">' . $row['name'] . '</option>';
        }
    }

    /*     * ******** VERIFY ASSIGNMENT *********** */

    function verify_student_assignment($assignment_id, $verify) {
        $page_data = $this->get_page_data_var();
        if ($verify == 1) {
            $data = array('assignment_id' => $assignment_id);
            $this->Student_assignments_model->update_submit(array('is_Verified' => '0'), $data);
            $this->session->set_flashdata('flash_message', get_phrase('no_verify_assignment'));
        } else {
            $data = array('assignment_id' => $assignment_id);
            $this->Student_assignments_model->update_submit(array('is_Verified' => '1'), $data);
            $this->session->set_flashdata('flash_message', get_phrase('verify_assigment'));
        }
        redirect(base_url() . 'index.php?teacher/verify_assignment/', 'refresh');
    }

    /*     * **MANAGE TEACHERS**** */

    function teacher_list($param1 = '', $param2 = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $page_data['search_text'] = '';

        $teacher_id = $this->session->userdata('teacher_id');
        $this->load->model('Section_model');
        if ($param1 == 'personal_profile') {
            $page_data['personal_profile'] = true;
            $page_data['current_teacher_id'] = $param2;
        } else if (($param1 == 'search') && ($param2 != '')) {
            $page_data['search_text'] = $param2;
        }

        $page_data['teachers'] = $this->Teacher_model->get_teacher_array();
        $page_data['class_handled'] = $this->Section_model->get_class_deatils_by_teacher($teacher_id);
        $page_data['page_name'] = 'teacher';
        $page_data['page_title'] = get_phrase('teacher_list');
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    /*     * **MANAGE SUBJECTS**** */

    function subject($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model('Section_model');
        if ($param1 == 'create') {
            $data['class_id'] = $this->input->post('class_id');
            $this->form_validation->set_rules('name', 'Subject Name', 'trim|required');
            $this->form_validation->set_rules('class_id', 'Class', 'required');
            $this->form_validation->set_rules('teacher_id', 'Teacher', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('flash_message_error', validation_errors());
                redirect(base_url() . 'index.php?teacher/subject/' . $data['class_id'], 'refresh');
            } else {
                $data['name'] = $this->input->post('name');
                $data['teacher_id'] = $this->input->post('teacher_id');
                $data['year'] = $this->Setting_model->get_year();

                $this->load->model('section_model');
                $data['section_id'] = $this->section_model->get_section_id($data['class_id']);
                $this->Subject_model->save_subject($data);
                $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
                redirect(base_url() . 'index.php?teacher/subject/' . $data['class_id'], 'refresh');
            }
        }
        if ($param1 == 'do_update') {
            //form validation
            $data['class_id'] = $this->input->post('class_id');
            $this->form_validation->set_rules('name', 'Subject Name', 'trim|required');
            $this->form_validation->set_rules('class_id', 'Class', 'required');
            $this->form_validation->set_rules('teacher_id', 'Teacher', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('flash_message_error', validation_errors());
                redirect(base_url() . 'index.php?teacher/subject/' . $data['class_id'], 'refresh');
            } else {
                $data['name'] = $this->input->post('name');
                $data['teacher_id'] = $this->input->post('teacher_id');
                $data['year'] = $this->Setting_model->get_year();

                $this->Subject_model->update_subject($data, array('subject_id' => $param2));
                $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
                redirect(base_url() . 'index.php?teacher/subject/' . $data['class_id'], 'refresh');
            }
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->Subject_model->get_data_by_cols('', array('subject_id' => $param2));
        }
        if ($param1 == 'delete') {
            $this->Subject_model->delete_subject(array('subject_id', $param2));

            redirect(base_url() . 'index.php?teacher/subject/' . $param3, 'refresh');
        }

        $teacher_id = $this->session->userdata('teacher_id');
        $this->load->model('class_model');
        $class = $this->class_model->get_class_name_by_subject($teacher_id);
        $runningYr = $this->Setting_model->get_year();
        if ($param1 == '') {
            if (!empty($class)) {
                $page_data['class_id'] = $class[0]['class_id'];
            } else {
                $page_data['class_id'] = "";
            }
            $subjects = $this->Subject_model->get_data_by_cols('', array('class_id' => $page_data['class_id'], 'year' => $runningYr), 'result_array');
            foreach ($subjects as $key => $val) {
                $subjects[$key]['class_name'] = $this->Crud_model->get_type_name_by_id('class', $val['class_id']);
                $sectionData = $this->Section_model->get_data_by_cols('', array('section_id' => $val['section_id']), 'result_array');
                if (!empty($sectionData)) {
                    $subjects[$key]['section_name'] = $sectionData[0]['name'];
                }
                $subjects[$key]['teacher'] = $this->Crud_model->get_type_name_by_id('teacher', $val['teacher_id']);
            }
        } else {
            $page_data['class_id'] = $param1;
            $subjects = $this->Subject_model->get_data_by_cols('', array('class_id' => $page_data['class_id'], 'year' => $runningYr), 'result_array');
            foreach ($subjects as $key => $val) {
                $subjects[$key]['class_name'] = $this->Crud_model->get_type_name_by_id('class', $val['class_id']);
                $sectionData = $this->Section_model->get_data_by_cols('', array('section_id' => $val['section_id']), 'result_array');
                if (!empty($sectionData)) {
                    $subjects[$key]['section_name'] = $sectionData[0]['name'];
                }
                $subjects[$key]['teacher'] = $this->Crud_model->get_type_name_by_id('teacher', $val['teacher_id']);
            }
        }
        $page_data['subjects'] = $subjects; //echo '<pre>'; print_r($subjects); exit;
        $page_data['page_name'] = 'subject';
        $page_data['page_title'] = get_phrase('manage_subject');
        $this->load->model('class_model');
        $class = $this->class_model->get_class_name_by_subject($teacher_id);
        $page_data['classes'] = $class;
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    /*     * *****ONLINE EXAM ************* */

    function online_exam($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data = $this->get_page_data_var();
        if ($param1 == 'import_excel') {
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/exam_details.xlsx');
            // Importing excel sheet for exam uploads
            include 'Simplexlsx.class.php';
            $xlsx = new SimpleXLSX('uploads/exam_details.xlsx');
            list($num_cols, $num_rows) = $xlsx->dimension();
            $f = 0;
            foreach ($xlsx->rows() as $r) {
                // Ignore the inital name row of excel file
                if ($f == 0) {
                    $f++;
                    continue;
                }
                pre($r);
                for ($i = 0; $i < $num_cols; $i++) {
                    if ($i == 0)
                        $data['name'] = $r[$i];
                    else if ($i == 1) {
                        //die($r[$i]);
                        $data['date'] = date('Y-m-d', strtotime($r[$i]));
                    } else if ($i == 2)
                        $data['year'] = $r[$i];
                    else if ($i == 3)
                        $data['comment'] = $r[$i];
                }

                $result = $this->Exam_model->get_online_exam_data(array('status' => 'Active'));

                if (empty($result)) {
                    //$data['exam_id'] = $result->row()->exam_id;
                    $this->session->set_flashdata('flash_message_error', get_phrase('Exam_details_added'));
                    redirect(base_url() . 'index.php?teacher/bulk_upload', 'refresh');
                } else {
                    $this->Exam_model->online_exam_save($data);
                }
            }
            $this->session->set_flashdata('flash_message', get_phrase('Exam_details_added'));
            redirect(base_url() . 'index.php?teacher/bulk_upload', 'refresh');
        }
        $this->load->model("Class_model");
        $page_data['classes'] = $this->Class_model->get_class_array();

        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['online_exam'] = $this->Exam_model->get_online_exam_data_teacher_login();


        $page_data['page_name'] = 'online_exam';
        $page_data['page_title'] = get_phrase('manage_online_exam');
        $this->load->view('backend/index', $page_data);
    }

    /*     * ********************Question View ***************** */

    function view_question($param1 = '', $param2 = '', $param3 = '', $param4 = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $subject = $this->Subject_model->get_data_by_cols('*', array('class_id' => $param1), 'result_array');
//        $question = $this->Question_model->get_data_by_cols('*',array('class_id' => $param1,'subject_id' => $param2),'result_array');
        $question = $this->Question_model->get_details_ById($param1, $param2, $param3);
        $page_data['class_id'] = $param1;
        $page_data['exam_id'] = $param2;
        $page_data['subject_id'] = $param3;
        $page_data['question'] = $question;
        $page_data['subject'] = $subject;
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['page_name'] = 'view_question';
        $page_data['page_title'] = get_phrase('view_question');
        $this->load->view('backend/index', $page_data);
    }

    /*     * ******************** Edit Question ***************** */

    function edit_question($param1 = '', $param2 = '', $param3 = '', $param4 = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $subject = $this->Subject_model->get_data_by_cols('*', array('class_id' => $param2), 'result_array');
        $question = $this->Question_model->get_data_by_cols('*', array('id' => $param1), 'result_array');

        $page_data['question_id'] = $param1;
        $page_data['class_id'] = $param2;
        $page_data['subject_id'] = $param3;
        $page_data['question'] = $question;
        $page_data['exam_id'] = $param4;
        $page_data['subject'] = $subject;
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['page_name'] = 'edit_question';
        $page_data['page_title'] = get_phrase('add_question');
        $this->load->view('backend/index', $page_data);
    }

    /*     * ******************** Add Question ***************** */

    function add_question($param1 = '', $param2 = '', $param3 = '', $param4 = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        if (isset($param1) && $param1 == 'create') {
            $ques_type = $this->input->post('question_type');
            if ($ques_type == 1) {
                $correct_answer = array('type' => $this->input->post('correct_answer[]'));
                // pre();
                $valu = implode(",", $correct_answer['type']);
                $data['answer'] = $valu;
            }
            $param1 = $this->input->post('class_id');
            $param3 = $this->input->post('subject_id');
            $subject = $this->Subject_model->get_data_by_cols('*', array('class_id' => $param1, 'subject_id' => $param3), 'result_array');
            $section_id = $subject[0]['section_id'];
            $data['exam_id'] = $param2;
            $data['qtype_id'] = $this->input->post('question_type');
            if ($data['qtype_id'] == 1) {
                $this->form_validation->set_rules('answer1', 'Answer 1', 'trim|required');
                $this->form_validation->set_rules('answer2', 'Answer 2', 'trim|required');
                $this->form_validation->set_rules('answer3', 'Answer 3', 'trim|required');
                $this->form_validation->set_rules('answer4', 'Answer 4', 'trim|required');
                if ($this->form_validation->run() == FALSE) {
                    $this->session->set_flashdata('flash_message_error', validation_errors());
                    redirect(base_url() . 'index.php?school_admin/add_question/' . $param1 . '/' . $param2, 'refresh');
                } else {
                    $data['subject_id'] = $this->input->post('subject_id');
                    $data['class_id'] = $this->input->post('class_id');
                    $data['section_id'] = $section_id;
                    $data['question'] = $this->input->post('question');
                    $data['option1'] = $this->input->post('answer1');
                    $data['option2'] = $this->input->post('answer2');
                    $data['option3'] = $this->input->post('answer3');
                    $data['option4'] = $this->input->post('answer4');
                    $data['option5'] = $this->input->post('answer5');
                    $data['option6'] = $this->input->post('answer6');
                    $data['true_false'] = $this->input->post('true_false_ques');
                    $data['fill_blank'] = $this->input->post('blank_space');
                    $data['explanation'] = $this->input->post('explanation');
                    $data['hint'] = $this->input->post('hint');
                    $data['explanation'] = $this->input->post('explanation');
                    $data['hint'] = $this->input->post('hint');
                    if (!empty($this->input->post('negative_marks'))) {
                        $data['negative_marks'] = $this->input->post('negative_marks');
                    } else {
                        $data['negative_marks'] = 0;
                    }
                    $data['marks'] = $this->input->post('marks');
                    $data['diff_id'] = $this->input->post('difficulty_level');
                    $data['order'] = $this->input->post('order');
                    $this->Question_model->question_save($data);
                    $response_array = array('status' => "success", 'message' => "Question Has been Created");
                    $this->session->set_flashdata('flash_message', get_phrase('question_added'));
                    redirect(base_url() . 'index.php?teacher/view_question/' . $param1 . '/' . $param2 . '/' . $data['subject_id'], 'refresh');
                }
            } else if ($data['qtype_id'] == 3) {
                $this->form_validation->set_rules('blank_space', 'Blank space', 'trim|required');
                if ($this->form_validation->run() == FALSE) {
                    $this->session->set_flashdata('flash_message_error', "For Question Fill in the blank, Blank space cannot be empty please fill blank space");
                    redirect(base_url() . 'index.php?school_admin/add_question/' . $param1 . '/' . $param2, 'refresh');
                } else {
                    $data['subject_id'] = $this->input->post('subject_id');
                    $data['class_id'] = $this->input->post('class_id');
                    $data['section_id'] = $section_id;
                    $data['question'] = $this->input->post('question');
                    $data['option1'] = $this->input->post('answer1');
                    $data['option2'] = $this->input->post('answer2');
                    $data['option3'] = $this->input->post('answer3');
                    $data['option4'] = $this->input->post('answer4');
                    $data['option5'] = $this->input->post('answer5');
                    $data['option6'] = $this->input->post('answer6');
                    $data['true_false'] = $this->input->post('true_false_ques');
                    $data['fill_blank'] = $this->input->post('blank_space');
                    $data['explanation'] = $this->input->post('explanation');
                    $data['hint'] = $this->input->post('hint');
                    $data['explanation'] = $this->input->post('explanation');
                    $data['hint'] = $this->input->post('hint');
                    if (!empty($this->input->post('negative_marks'))) {
                        $data['negative_marks'] = $this->input->post('negative_marks');
                    } else {
                        $data['negative_marks'] = 0;
                    }
                    $data['marks'] = $this->input->post('marks');
                    $data['diff_id'] = $this->input->post('difficulty_level');
                    $data['order'] = $this->input->post('order');
                    $this->Question_model->question_save($data);
                    $response_array = array('status' => "success", 'message' => "Question Has been Created");
                    $this->session->set_flashdata('flash_message', get_phrase('question_added'));
                    redirect(base_url() . 'index.php?teacher/view_question/' . $param1 . '/' . $param2 . '/' . $data['subject_id'], 'refresh');
                }
            } else {
                $data['subject_id'] = $this->input->post('subject_id');
                $data['class_id'] = $this->input->post('class_id');
                $data['section_id'] = $section_id;
                $data['question'] = $this->input->post('question');
                $data['option1'] = $this->input->post('answer1');
                $data['option2'] = $this->input->post('answer2');
                $data['option3'] = $this->input->post('answer3');
                $data['option4'] = $this->input->post('answer4');
                $data['option5'] = $this->input->post('answer5');
                $data['option6'] = $this->input->post('answer6');
                $data['true_false'] = $this->input->post('true_false_ques');
                $data['fill_blank'] = $this->input->post('blank_space');
                $data['explanation'] = $this->input->post('explanation');
                $data['hint'] = $this->input->post('hint');
                $data['explanation'] = $this->input->post('explanation');
                $data['hint'] = $this->input->post('hint');
                if (!empty($this->input->post('negative_marks'))) {
                    $data['negative_marks'] = $this->input->post('negative_marks');
                } else {
                    $data['negative_marks'] = 0;
                }
                $data['marks'] = $this->input->post('marks');
                $data['diff_id'] = $this->input->post('difficulty_level');
                $data['order'] = $this->input->post('order');
                $this->Question_model->question_save($data);
                $response_array = array('status' => "success", 'message' => "Question Has been Created");
                $this->session->set_flashdata('flash_message', get_phrase('question_added'));
                redirect(base_url() . 'index.php?teacher/view_question/' . $param1 . '/' . $param2 . '/' . $data['subject_id'], 'refresh');
            }
        }
        if ($param1 == 'edit' && $param2 == 'do_update') {
            $ques_type = $this->input->post('question_type');
            if ($ques_type == 1) {
                $correct_answer = array('type' => $this->input->post('correct_answer[]'));
                // pre();
                $valu = implode(",", $correct_answer['type']);
                $data['answer'] = $valu;
            }

            $param1 = $this->input->post('class_id');
            $param2 = $this->input->post('subject_id');
            $subject = $this->Subject_model->get_data_by_cols('*', array('class_id' => $param1, 'subject_id' => $param2), 'reault_array');
            if (!empty($subject[0]['section_id'])) {
                $section_id = $subject[0]['section_id'];
            }
            $data['qtype_id'] = $this->input->post('question_type');
            $data['subject_id'] = $this->input->post('subject_id');
            $data['class_id'] = $this->input->post('class_id');
            $data['section_id'] = $section_id;
            $data['question'] = $this->input->post('question');
            $data['option1'] = $this->input->post('answer1');
            $data['option2'] = $this->input->post('answer2');
            $data['option3'] = $this->input->post('answer3');
            $data['option4'] = $this->input->post('answer4');
            $data['option5'] = $this->input->post('answer5');
            $data['option6'] = $this->input->post('answer6');
            $data['true_false'] = $this->input->post('true_false_ques');
            $data['fill_blank'] = $this->input->post('blank_space');
            $data['explanation'] = $this->input->post('explanation');
            $data['hint'] = $this->input->post('hint');
            $data['negative_marks'] = $this->input->post('negative_marks');
            $data['marks'] = $this->input->post('marks');
            $data['diff_id'] = $this->input->post('difficulty_level');
            $data['order'] = $this->input->post('order');
            $this->Question_model->update_question($param3, $data);
            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
            redirect(base_url() . 'index.php?teacher/view_question/' . $data['class_id'] . '/' . $param4 . '/' . $param2, 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->Question_model->get_data_by_cols('*', array('id' => $param2), 'reault_array');
        }

        if ($param1 == 'delete') {
            $this->Question_model->question_delete($param2);
            $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));

            redirect(base_url() . 'index.php?teacher/view_question/' . $param3 . '/' . $param4, 'refresh');
        }

        $subject = $this->Subject_model->get_data_by_cols('*', array('class_id' => $param1), 'reault_array');
        $question = $this->Question_model->get_data_by_cols('*', array('class_id' => $param1, 'subject_id' => $param2), 'reault_array');

        $page_data['class_id'] = $param1;
        $page_data['exam_id'] = $param2;
        $page_data['subject_id'] = $param2;
        $page_data['question'] = $question;

        $page_data['subject'] = $subject;
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['page_name'] = 'add_question';
        $page_data['page_title'] = get_phrase('add_question');
        $this->load->view('backend/index', $page_data);
    }

    /*     * **MANAGE EXAM MARKS**** */

    function marks_manage() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'marks_manage';
        $page_data['page_title'] = get_phrase('manage_exam_marks');
        $page_data['total_notif_num'] = $this->get_no_of_notication();

        $this->load->model('Exam_model');
         $page_data['exams'] = $this->Exam_model->get_data_by_cols('*', array('year' => $running_year), 'result_array');
        $page_data['classes'] = $this->Crud_model->get_classes_by_teacher($this->session->userdata('teacher_id'));
        $this->load->view('backend/index', $page_data);
    }

    function marks_manage_view($exam_id = '', $class_id = '', $section_id = '', $subject_id = '') {

        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $page_data['exam_id'] = $exam_id;
        $page_data['class_id'] = $class_id;
        $page_data['subject_id'] = $subject_id;
        $page_data['section_id'] = $section_id;
        $page_data['page_name'] = 'marks_manage_view';
        $page_data['page_title'] = get_phrase('manage_exam_marks');
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->model('Exam_model');

        $page_data['exams'] = $this->Exam_model->get_data_generic_fun('*', array(), 'result_array');
        $page_data['classes'] = get_data_generic_fun('class', '*', array(), 'result_array');
        $page_data['sections'] = $this->Section_model->get_data_by_cols('', array('class_id' => $class_id));
        $page_data['subjects'] = $this->Subject_model->get_data_by_cols('', array('class_id' => $class_id, 'year' => $running_year));

        $examData = array();
        $examData = $this->Exam_model->get_data_by_cols('', array('exam_id' => $exam_id));
        $page_data['exam_name'] = @$examData[0]->name;
        $classData = $this->Class_model->get_data_by_cols('', array('class_id' => $class_id));
        $page_data['class_name'] = @$classData[0]->name;
        $sectionData = $this->Section_model->get_data_by_cols('', array('section_id' => $section_id));
        $page_data['section_name'] = @$sectionData[0]->name;
        $subjectData = $this->Subject_model->get_data_by_cols('', array('subject_id' => $subject_id));
        $page_data['subject_name'] = @$subjectData[0]->name;

        $page_data['marks_of_students'] = $this->Exam_model->get_marks_of_students($exam_id, $class_id, $section_id, $subject_id, $running_year);

        $this->load->view('backend/index', $page_data);
    }

    function marks_selector() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $data['exam_id'] = $this->input->post('exam_id');
        $data['class_id'] = $this->input->post('class_id');
        $data['section_id'] = $this->input->post('section_id');
        $data['subject_id'] = $this->input->post('subject_id');
        $data['year'] = $this->Setting_model->get_year();

        $students = $this->Enroll_model->get_data_by_cols('', array('class_id' => $data['class_id'], 'section_id' => $data['section_id'], 'year' => $data['year']), 'result_array');

        foreach ($students as $row) {
            $rs = $this->Mark_model->get_data_by_cols('', array('student_id' => $row['student_id'], 'exam_id' => $data['exam_id'], 'subject_id' => $data['subject_id']), 'result_array');
            if (count($rs) == 0) {
                $data['student_id'] = $row['student_id'];
                $this->Mark_model->save($data);
            }
        }
        redirect(base_url() . 'index.php?teacher/marks_manage_view/' . $data['exam_id'] . '/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['subject_id'], 'refresh');
    }

    function marks_update($exam_id = '', $class_id = '', $section_id = '', $subject_id = '') {
        $page_data = $this->get_page_data_var();
        $runningYr = $this->Setting_model->get_year();
        $marks_of_students = $this->Mark_model->get_data_by_cols('', array('exam_id' => $exam_id, 'class_id' => $class_id, 'section_id' => $section_id, 'year' => $running_year, 'subject_id' => $subject_id));

        $maximum_marks = $this->input->post('maximum_marks');
        foreach ($marks_of_students as $row) {
            $obtained_marks = $this->input->post('marks_obtained_' . $row['mark_id']);
            $comment = $this->input->post('comment_' . $row['mark_id']);

            $this->Mark_model->update_marks($row['mark_id'], array('mark_obtained' => $obtained_marks, 'comment' => $comment, 'mark_total' => $maximum_marks));
        }
        $this->session->set_flashdata('flash_message', get_phrase('marks_updated'));
        redirect(base_url() . 'index.php?teacher/marks_manage_view/' . $exam_id . '/' . $class_id . '/' . $section_id . '/' . $subject_id, 'refresh');
    }

    function marks_get_subject($class_id) {
        $page_data = $this->get_page_data_var();
        $page_data['class_id'] = $class_id;
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/teacher/marks_get_subject', $page_data);
    }

    // ACADEMIC SYLLABUS
    function academic_syllabus($class_id = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $running_year = $this->Setting_model->get_year();
        $teacher_id = $this->session->userdata('teacher_id');
        $this->load->model('class_model');
        $class = $this->class_model->get_class_name_by_subject($teacher_id);
        if ($class_id == '') {
            if (!empty($class)) {
                $class_id = $class[0]['class_id'];
            }
        }
        $page_data['classes'] = $class;
        $syllabus = get_data_generic_fun('academic_syllabus', '*', array('class_id' => $class_id, 'year' => $running_year), 'result_arr');
//        pre($syllabus); die;
        $page_data['class_name'] = get_data_generic_fun('class', 'name', array('class_id' => $class_id), 'result_array');
        $page_data['page_name'] = 'academic_syllabus';
        $page_data['page_title'] = get_phrase('academic_syllabus');
        $page_data['class_id'] = $class_id;

        foreach ($syllabus as $key => $row) {
            $syllabus[$key]['uploader_name'] = $this->Academic_syllabus_model->get_uploader_name($row['uploader_type'], $row['uploader_id']);
        }

        $page_data['syllabus'] = $syllabus;
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    function upload_academic_syllabus() {
        $page_data = $this->get_page_data_var();
        $data['academic_syllabus_code'] = substr(md5(rand(0, 1000000)), 0, 7);
        $data['title'] = $this->input->post('title');
        $data['description'] = $this->input->post('description');
        $data['class_id'] = $this->input->post('class_id');
        $data['uploader_type'] = $this->session->userdata('login_type');
        $data['uploader_id'] = $this->session->userdata('login_user_id');
        $data['year'] = $this->Setting_model->get_year();
        $data['timestamp'] = strtotime(date("Y-m-d H:i:s"));
        //uploading file using codeigniter upload library
        $files = $_FILES['file_name'];
        $this->load->library('upload');
        $config['upload_path'] = 'uploads/syllabus/';
        $config['allowed_types'] = '*';
        $_FILES['file_name']['name'] = $files['name'];
        $_FILES['file_name']['type'] = $files['type'];
        $_FILES['file_name']['tmp_name'] = $files['tmp_name'];
        $_FILES['file_name']['size'] = $files['size'];
        $this->upload->initialize($config);
        $this->upload->do_upload('file_name');

        $data['file_name'] = $_FILES['file_name']['name'];
//        pre($data); die;
        $this->Academic_syllabus_model->save($data);

        $this->session->set_flashdata('flash_message', get_phrase('syllabus_uploaded'));
        redirect(base_url() . 'index.php?teacher/academic_syllabus/' . $data['class_id'], 'refresh');
    }

    function download_academic_syllabus($academic_syllabus_code) {
        $page_data = $this->get_page_data_var();
        $file_name_data = $this->Academic_syllabus_model->get_data_by_cols('*', array('academic_syllabus_code' => $academic_syllabus_code));
//        pre($file_name_data); die;
        $file_name = $file_name_data[0]->file_name;
        $this->load->helper('download');
        $data = file_get_contents("uploads/syllabus/" . $file_name);
        $name = $file_name;

        force_download($name, $data);
        redirect(base_url() . 'index.php?teacher/academic_syllabus/' . $data['class_id'], 'refresh');
    }

    /*     * ***BACKUP / RESTORE / DELETE DATA PAGE********* */

    function backup_restore($operation = '', $type = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        if ($operation == 'create') {
            $this->Crud_model->create_backup($type);
        }
        if ($operation == 'restore') {
            $this->Crud_model->restore_backup();
            $this->session->set_flashdata('backup_message', 'Backup Restored');
            redirect(base_url() . 'index.php?teacher/backup_restore/', 'refresh');
        }
        if ($operation == 'delete') {
            $this->Crud_model->truncate($type);
            $this->session->set_flashdata('backup_message', 'Data removed');
            redirect(base_url() . 'index.php?teacher/backup_restore/', 'refresh');
        }

        $page_data['page_info'] = 'Create backup / restore from backup';
        $page_data['page_name'] = 'backup_restore';
        $page_data['page_title'] = get_phrase('manage_backup_restore');
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    /*     * ****MANAGE OWN PROFILE AND CHANGE PASSWORD** */

    function manage_profile($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        $page_data = $this->get_page_data_var();
        $teacher_id = $this->session->userdata('teacher_id');
        if ($param1 == 'update_profile_info') {
            $data['name'] = $this->input->post('name');
            $data['last_name'] = $this->input->post('last_name');
            $data['email'] = $this->input->post('email');
            $file_name = $_FILES['userfile']['name'];

            $types = array('image/jpeg', 'image/gif', 'image/png');
            if ($file_name != '') {
                if (in_array($_FILES['userfile']['type'], $types)) {
                    $ext = explode(".", $file_name);
                    $data['teacher_image'] = $teacher_id . "." . end($ext);

                    if ($this->Teacher_model->update_teacher($data, $teacher_id)) {
                        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/teacher_image/' . $data['teacher_image']);
                        $this->session->set_flashdata('flash_message', get_phrase('account_details_updated'));
                    }
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('It may be the wrong filetype. We only allow JPG, GIF, and PNG filetypes!!'));
                    redirect(base_url() . 'index.php?teacher/manage_profile/', 'refresh');
                }
            } else {
                $this->Teacher_model->update_teacher($data, $teacher_id);
                $this->session->set_flashdata('flash_message', get_phrase('account_details_updated'));
            }
            redirect(base_url() . 'index.php?teacher/manage_profile/', 'refresh');
            //echo '<pre>'; print_r($data); exit;            
        }
        if ($param1 == 'change_password') {
            $old_password = md5($this->input->post('password'));
            $data['password'] = md5($this->input->post('new_password'));
            $confirm_new_password = md5($this->input->post('confirm_new_password'));
            $currentPassData = $this->Teacher_model->get_data_by_cols('', array('teacher_id' => $this->session->userdata('teacher_id')));
            $current_password = $currentPassData[0]->password;

            if ($current_password == $old_password && $data['password'] == $confirm_new_password) {
                if ($this->Teacher_model->update_teacher($data, $teacher_id)) {
                    $this->session->set_flashdata('flash_message', get_phrase('password_changed'));
                } else {
                    $this->session->set_flashdata('flash_message', get_phrase('password_not_changed'));
                }
            } else {
                $this->session->set_flashdata('flash_message', get_phrase('password_mismatch'));
            }
            redirect(base_url() . 'index.php?teacher/manage_profile/', 'refresh');
        }
        $page_data['page_name'] = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data'] = $this->Teacher_model->get_teacher_record(array('teacher_id' => $teacher_id));
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    /*     * ********MANAGING CLASS ROUTINE***************** */

    function class_routine_view() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $teacher_id = $this->session->userdata('teacher_id');
        $this->load->model('class_model');
        $class = $this->class_model->get_class_name_by_subject($teacher_id);
        $page_data['classes'] = $class;
        $page_data['page_name'] = 'class_routine_view';
        $page_data['page_title'] = get_phrase('class_routine');
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    function show_timetable() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $teacher_id = $this->session->userdata('teacher_id');
        $this->load->model('class_model');
        $class = $this->class_model->get_class_name_by_subject($teacher_id);
        $page_data['classes'] = $class;
        $page_data['page_name'] = 'class_routine_view';
        $page_data['page_title'] = get_phrase('class_routine');
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    function class_routine_print_view($class_id, $section_id) {
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();
        $page_data['class_id'] = $class_id;
        $page_data['section_id'] = $section_id;
        $page_data['total_notif_num'] = $this->get_no_of_notication();

        $class_name_data = $this->Class_model->get_data_by_id($page_data['class_id'], 'name');
        $class_name = $class_name_data[0]->name;

        $section_name_data = $this->Section_model->get_data_by_id($page_data['section_id'], 'name');
        $section_name = $section_name_data[0]->name;

        $section_name_data = $this->Section_model->get_data_by_id($page_data['section_id'], 'name');
        $section_name = $section_name_data[0]->name;
        $running_year = $this->Setting_model->get_year();
        $system_name_data = $this->Setting_model->get_setting_record(array('type' => 'system_name'), 'description');
        $system_name = $this->globalSettingsSystemName;

        $this->load->view('backend/teacher/class_routine_print_view', $page_data);
    }

    /*     * ********MANAGING PROGRESS REPORT***************** */

    function progress_report($class_id = '', $section_id = '', $subject_id = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();
        $classes = $this->Subject_model->get_classes_by_teacher($this->session->userdata('teacher_id'));
        $this->load->helper('form');
        $this->load->model('Progress_model');
        $this->load->model('Section_model');
        $this->load->model("Subject_model");
        $runningYr = $this->Setting_model->get_year();
        if ($class_id != '') {
            $heading = $this->Teacher_model->get_heading($class_id, $this->session->userdata('teacher_id'));
            $page_data['headings'] = $heading;
            $sections = $this->Section_model->get_section($class_id, $this->session->userdata('teacher_id'));
            $page_data['sections'] = $sections;
        }
        if ($section_id != '') {
            $page_data['subjects'] = $this->Subject_model->get_subject_array(array('section_id' => $section_id, 'teacher_id' => $this->session->userdata('teacher_id')));
        }

        $page_data['page_name'] = 'progress_report';
        $page_data['page_title'] = get_phrase('progress_report') . " - " . get_phrase('class') . " : " . $this->Crud_model->get_class_name($class_id);
        $page_data['selected_section'] = $section_id;
        $page_data['selected_class'] = $class_id;
        $page_data['selected_subject'] = $subject_id;
        $page_data['classes'] = $classes;
        $page_data['class_id'] = $class_id;
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    function progress_report_list($class_id = '', $section_id = '', $subject_id = '') {
//echo $class_id."gg".$section_id."ggg".$subject_id; die;
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();
        $classes = $this->Subject_model->get_classes_by_teacher($this->session->userdata('teacher_id'));
        $this->load->helper('form');
        $this->load->model('Progress_model');
        $this->load->model('Section_model');
        $this->load->model("Subject_model");
        $runningYr = $this->Setting_model->get_year();
        if ($class_id != '') {
            //$heading = $this->Teacher_model->get_heading($class_id,$this->session->userdata('teacher_id'));
            //$page_data['headings'] = $heading;
            $sections = $this->Section_model->get_section($class_id, $this->session->userdata('teacher_id'));
            $page_data['sections'] = $sections;
        }
        if ($section_id != '') {
            $page_data['subjects'] = $this->Subject_model->get_subject_array(array('section_id' => $section_id, 'teacher_id' => $this->session->userdata('teacher_id')));
        }
        $page_data['page_name'] = 'view_ajax_progress_report';
        $page_data['page_title'] = get_phrase('progress_report') . " - " . get_phrase('class') . " : " . $this->Crud_model->get_class_name($class_id);
        $page_data['selected_section'] = $section_id;
        $page_data['selected_class'] = $class_id;
        $page_data['selected_subject'] = $subject_id;
        $page_data['classes'] = $classes;
        $page_data['class_id'] = $class_id;
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    function progress_report_heading_wise($class_id = '', $section_id = '', $student_id = '', $heading_id = '', $term_id = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();
        $running_year = $this->Setting_model->get_year();

        $this->load->model("Subject_model");
        $this->load->model("Enroll_model");
        $this->load->model("Section_model");
        $classes = $this->Subject_model->get_classes_by_teacher($this->session->userdata('teacher_id'));
        $this->load->helper('form');
        $this->load->model('Progress_model');
        $this->load->model('Report_term_model');
        if ($class_id != '') {
            $heading = $this->Teacher_model->get_heading($class_id, $this->session->userdata('teacher_id'));
            $page_data['headings'] = $heading;
            $sections = $this->Section_model->get_section($class_id, $this->session->userdata('teacher_id'));
            $page_data['sections'] = $sections;
        }
        $data = array();
        if ($class_id != '' || $section_id != '') {
            $student_arr = $this->Enroll_model->get_student_array(array('section_id' => $section_id, 'class_id' => $class_id, 'year' => $running_year));
            foreach ($student_arr as $student):
                $stu_rs = get_data_generic_fun('student', 'student_id, name, lname', array('student_id' => $student['student_id'], 'isActive' => '1', 'student_status' => '1'), 'result_arr');

                if (isset($stu_rs[0])) {
                    $data[] = $stu_rs[0];
                }
            endforeach;
            $page_data['students'] = $data;
        }
        $page_data['term_list'] = $this->Report_term_model->get_list();

        foreach ($classes as $key => $row) {
            $classes[$key]['class_name'] = $this->Crud_model->get_class_name($row['class_id']);
        }

        $categories = $this->Progress_model->getCategoryByHeading('progress_report_category', array('heading_id' => $heading_id));
        $sortArr = array();
        $limitArr = array();
        $list = array();
        $result = array();
        $data = array();
        $all_data = array();
        $k = 0;
        $c = 0;
        foreach ($categories as $row) {
            $all_data[$c]['category_id'] = $row['category_id'];
            $all_data[$c]['category_des'] = $row['description'];

            $sub_categories = $this->Progress_model->getSubcatByCategory('progress_report_sub_category', array('category_id' => $row['category_id']));

            if (count($sub_categories) > 0) {
                foreach ($sub_categories as $subcat) {
                    unset($categories);
                    $sortArr = array('report_id' => 'desc');
                    $show_data1 = $this->Progress_model->get_data_by_cols_groupby('student_progress_report', 'sub_category_id,exceeding_level,expected_level,emerging_level,time_stamp,comment', array('sub_category_id' => $subcat['sub_category_id'], 'student_id' => $student_id), '', $sortArr);

                    $student_progress = $this->Student_progress_report_model->get_data_by_cols('', array('sub_category_id' => $subcat['sub_category_id'], 'student_id' => $student_id), 'result_array');

                    if (count($student_progress) > 0) {
                        $categories[$k]['view_report'] = '1';
                    } else {
                        $categories[$k]['view_report'] = '0';
                    }

                    if (!empty($show_data)) {
                        $categories[$k]['sub_category_id'] = $subcat['sub_category_id'];
                        $categories[$k]['sub_desc'] = $subcat['description'];
                        $categories[$k]['ex'] = $show_data->exceeding_level;
                        $categories[$k]['exp'] = $show_data->expected_level;
                        $categories[$k]['em'] = $show_data->emerging_level;
                        $categories[$k]['date'] = $show_data->time_stamp;
                        $categories[$k]['comment'] = $show_data->comment;

                        $all_data[$c]['subcat'][] = $categories[$k];
                    } else {
                        $categories[$k]['sub_category_id'] = $subcat['sub_category_id'];
                        $categories[$k]['sub_desc'] = $subcat['description'];
                        $categories[$k]['ex'] = "";
                        $categories[$k]['exp'] = "";
                        $categories[$k]['em'] = "";
                        $categories[$k]['date'] = "";
                        $categories[$k]['comment'] = "";
                        $all_data[$c]['subcat'][] = $categories[$k];
                    }
                    $k++;
                }
            }
            $c++;
        }

        $page_data['head_cate_data'] = $all_data;
        $page_data['page_name'] = 'progress_report_heading_wise';

        $page_data['page_title'] = get_phrase('progress_detail');
        $page_data['selected_section'] = $section_id;
        $page_data['selected_class'] = $class_id;
        $page_data['selected_student'] = $student_id;
        $page_data['selected_heading'] = $heading_id;
        $page_data['selected_term'] = $term_id;
        $page_data['classes'] = $classes;
        $page_data['class_id'] = $class_id;
        $page_data['student_id'] = $student_id;

        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    function progress_report_heading_setting_function($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');

        if ($param1 == 'create') {
            $page_data['heading_description'] = $this->input->post('heading');
            $page_data['class_id'] = $this->input->post('class_id');
            $page_data['heading_id'] = $this->Teacher_model->save_heading($page_data);
            $page_data['heading_data'] = $this->Progress_model->get_data_by_cols('', array('class_id' => $page_data['class_id']));
            $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?teacher/progress_report_heading_setting/' . $page_data['class_id'], 'refresh');
        }
        if ($param1 == 'do_update') {
            $page_data['heading_description'] = $this->input->post('heading');
            $this->Progress_model->update_progress_report_heading($page_data, array('heading_id' => $param2));

            $this->session->set_flashdata('flash_message', get_phrase('data_updated_successfully'));
            redirect(base_url() . 'index.php?teacher/progress_report_heading_setting/' . $param3, 'refresh');
        }
        if ($param1 == 'delete') {
            $query1 = $this->Progress_model->getCategoryByHeading('progress_report_category', array('heading_id' => $param2));

            if (!empty($query1)) {
                foreach ($query1 as $row1):

                    $query2 = $this->Progress_model->getSubcatByCategory('progress_report_sub_category', array('category_id' => $row1['category_id']));

                    if (!empty($query2)) {
                        foreach ($query2 as $row2):
                            $this->Progress_model->deleteSubCat($row2['sub_category_id']);
                        endforeach;
                    }

                    $this->Progress_model->deleteCategory($row1['category_id']);

                endforeach;
            }
            $this->Progress_model->deleteHeading($param2);

//            echo 1;
            $this->session->set_flashdata('flash_message', get_phrase('deleted_successfully'));
            redirect(base_url() . 'index.php?teacher/progress_report_heading_setting/' . $param3, 'refresh');
        }
    }

    function progress_report_heading_setting($param1 = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();
        $page_data['heading_data'] = $this->Progress_model->get_data_by_cols('', array('class_id' => $param1), 'result_array');
        $classes = $this->Subject_model->get_classes_by_teacher($this->session->userdata('teacher_id'));
        $this->load->helper('form');
        $this->load->model('Progress_model');
        $page_data['page_name'] = 'progress_report_heading_setting';
        $page_data['page_title'] = get_phrase('report') . " - " . get_phrase('class') . " : " . $this->Crud_model->get_class_name($param1);
        $page_data['selected_class'] = $param1;
        $page_data['classes'] = $classes;
        $page_data['class_id'] = $param1;
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    function heading_sub_category_add($param1 = '', $param2 = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();
        //$classes=$this->crud_model->get_classes_by_teacher($this->session->userdata('teacher_id'));
        $this->load->helper('form');
        $this->load->model('Progress_model');
        $page_data['page_name'] = 'heading_sub_category_add';
        $page_data['page_title'] = get_phrase('report') . " - " . get_phrase('class') . " : " . $this->Crud_model->get_class_name($param1);
        //$page_data['selected_class']=$param1;
        //$page_data['classes']=$classes;
        $page_data['class_id'] = $param1;
        $page_data['heading_id'] = $param2;
        $page_data['total_notif_num'] = $this->get_no_of_notication();

        $page_data['heading_data'] = $this->Progress_model->get_headings(array('class_id' => $param1));
        $page_data['category_data'] = $this->Progress_model->getCategoryByHeading('progress_report_category', array('heading_id' => $param2));

        $this->load->view('backend/index', $page_data);
    }

    function add_sub_category_inCategory($param1 = '', $param2 = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->helper('form');
        $this->load->model('Progress_model');
        $page_data['page_name'] = 'add_sub_category_inCategory';
        $page_data['page_title'] = get_phrase('category_list');

        $page_data['heading_id'] = $param2;
        $page_data['heading'] = $this->Progress_model->getCategoryByHeading('progress_report_category', array('heading_id' => $param2));
        $page_data['category_id'] = $param1;
        $page_data['heading2'] = $this->Progress_model->getSubcatByCategory('progress_report_sub_category', array('category_id' => $param1));
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    function progress_report_sub_category($param1 = '', $param2 = '', $param3 = '', $param4 = '') {

        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'create') {
            $page_data['description'] = $this->input->post('sub_category');
            $page_data['category_id'] = $this->input->post('category_id');
            $this->Teacher_model->save_sub_ctegory($page_data);
            $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?teacher/add_sub_category_inCategory/' . $page_data['category_id'] . '/' . $param2, 'refresh');
        }

        if ($param1 == 'do_update') {
            $page_data['description'] = $this->input->post('sub_category');
            $heading_id = $this->input->post('heading_id');

            $this->Progress_model->update_progress_report_subcat($page_data, array('sub_category_id' => $param2));

            $this->session->set_flashdata('flash_message', get_phrase('data_updated_successfully'));
            redirect(base_url() . 'index.php?teacher/add_sub_category_inCategory/' . $param3 . '/' . $heading_id, 'refresh');
        }
        if ($param1 == 'delete') {
            $this->Progress_model->deleteSubCat($param2);

            $this->session->set_flashdata('flash_message', get_phrase('deleted_successfully'));
            redirect(base_url() . 'index.php?teacher/add_sub_category_inCategory/' . $param3 . '/' . $param4, 'refresh');
        }
    }

    function progress_report_category_setting_function($param1 = '', $param2 = '', $param3 = '', $param4 = '') {

        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');

        if ($param1 == 'create') {
            $page_data['description'] = $this->input->post('category');
            $page_data['heading_id'] = $this->input->post('heading_id');
            $this->Teacher_model->save_ctegory($page_data);
            $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?teacher/heading_sub_category_add/' . $param2 . '/' . $page_data['heading_id'], 'refresh');
        }

        if ($param1 == 'do_update') {
            $page_data['description'] = $this->input->post('category');
            $class_id = $this->input->post('class_id');

            $this->Progress_model->update_progress_report_category($page_data, array('category_id' => $param2));

            $this->session->set_flashdata('flash_message', get_phrase('data_updated_successfully'));
            redirect(base_url() . 'index.php?teacher/heading_sub_category_add/' . $class_id . '/' . $param3, 'refresh');
        }
        if ($param1 == 'delete') {
            $this->Progress_model->deleteCategory($param2);

            $this->session->set_flashdata('flash_message', get_phrase('deleted_successfully'));
            redirect(base_url() . 'index.php?teacher/heading_sub_category_add/' . $param3 . '/' . $param4, 'refresh');
        }
    }

    function progress_report_selector() {
        $page_data = $this->get_page_data_var();
        $data['class_id'] = $this->input->post('class_id');
        $data['year'] = $this->input->post('year');
        $data['timestamp'] = strtotime($this->input->post('timestamp'));
        $data['section_id'] = $this->input->post('section_id');

        $query = $this->Attendance_model->get_data_by_cols('', array('class_id' => $data['class_id'], 'section_id' => $data['section_id'], 'year' => $data['year'], 'timestamp' => $data['timestamp']));

        if ($query->num_rows() < 1) {
            $students = $this->Enroll_model->get_data_by_cols('', array('class_id' => $data['class_id'], 'section_id' => $data['section_id'], 'year' => $data['year']));

            foreach ($students as $row) {
                $attn_data['class_id'] = $data['class_id'];
                $attn_data['year'] = $data['year'];
                $attn_data['timestamp'] = $data['timestamp'];
                $attn_data['section_id'] = $data['section_id'];
                $attn_data['student_id'] = $row['student_id'];
                $this->Attendance_model->add($attn_data);
            }
        }
        redirect(base_url() . 'index.php?teacher/manage_attendance_view/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['timestamp'], 'refresh');
    }

    function get_teacher_section($class_id) {
        $page_data = $this->get_page_data_var();
        $this->load->model("Subject_model");
        $sections = $this->Subject_model->get_subjects($class_id, $this->session->userdata('teacher_id'));
        foreach ($sections as $row) {
            echo '<option value="' . $row['section_id'] . '">' . $row['name'] . '</option>';
        }
    }

    function get_teacher_class_heading($class_id) {
        $page_data = $this->get_page_data_var();
        $this->load->model("Teacher_model");
        $heading = $this->Teacher_model->get_heading($class_id, $this->session->userdata('teacher_id'));
        foreach ($heading as $row) {
            echo '<option value="' . $row['heading_id'] . '">' . $row['heading_description'] . '</option>';
        }
    }

    function get_teacher_subject($section_id) {
        $page_data = $this->get_page_data_var();
        $this->load->model("Subject_model");
        $subjects = $this->Subject_model->get_subject_array(array('section_id' => $section_id, 'teacher_id' => $this->session->userdata('teacher_id')));
        foreach ($subjects as $subject) {
            echo '<option value="' . $subject['subject_id'] . '">' . $subject['name'] . '</option>';
        }
    }

    function get_teacher_student($section_id, $class_id) {
        $running_year = $this->Setting_model->get_year();

        $this->load->model("Enroll_model");
        $student_arr = $this->Enroll_model->get_student_array(array('section_id' => $section_id, 'class_id' => $class_id, 'year' => $running_year));
        foreach ($student_arr as $student) {
            $data = get_data_generic_fun('student', 'student_id, name, lname', array('student_id' => $student['student_id'], 'isActive' => '1', 'student_status' => '1', 'result_arr'));
            foreach ($data as $row) {
                echo '<option value="' . $row->student_id . '">' . $row->name . '</option>';
            }
        }
    }

    function save_progress_report_heading_wise($class_id = '', $section_id = '', $student_id = '', $heading_id = '', $term_id = '') {
        $page_data = $this->get_page_data_var();
        $this->load->model("Student_model");
        $this->load->model("Progress_model");
        $this->load->model("Email_model");
        $this->load->model("Parent_model");
        $parent_id = $this->Student_model->get_parent_id($student_id);
        $parent_info = $this->Parent_model->get_email_id($parent_id);
        $email = $parent_info[0]['email'];
        $categories = $this->Progress_model->getCategoryByHeading('progress_report_category', array('heading_id' => $heading_id));
        foreach ($categories as $row):
            $sub_categories = $this->Progress_model->getSubcatByCategory('progress_report_sub_category', array('category_id' => $row['category_id']));
            $i = 1;
            if (!empty($sub_categories)) {

                foreach ($sub_categories as $row1):
                    $changed = $this->input->post('changed' . $row['category_id'] . $i);
                    if ($changed == 1) {
                        $data['teacher_id'] = $this->session->userdata('teacher_id');
                        $data['student_id'] = $student_id;
                        $data['time_stamp'] = date('y-m-d');
                        $data['sub_category_id'] = $row1['sub_category_id'];
                        $data['term_id'] = $term_id;
                        $data['exceeding_level'] = $this->input->post('ex' . $row['category_id'] . $i);
                        $data['expected_level'] = $this->input->post('exp' . $row['category_id'] . $i);
                        $data['emerging_level'] = $this->input->post('em' . $row['category_id'] . $i);
                        $data['comment'] = $this->input->post('comment-' . $row['category_id'] . $i);
                        $this->Progress_model->save_progress_report($data);
                    }
                    $i = $i + 1;
                endforeach;
            }
        endforeach;
        $message = "";
        $detail = $this->Progress_model->progress_report_detail($class_id, $student_id);
//        pre($detail); die;
        $i = 1;
        foreach ($detail as $heading_key => $details):
            $message .= "<table border='1' cellspacing='0' cellpadding='5' style='' width='100%'><thead><tr><th>" . $i . "</th><th width='50%'>" . $details['description'] . "</th><th colspan=3>Rating</th><th>comment</th><th>Date</th></thead>";
            $j = 1;
            foreach ($details['category'] as $category_key => $cate):
                //pre($cate); die;
                $message .= "<tbody><tr><td>" . $i . "." . $j . "</td><td><b>" . $cate['cat_description'] . "</b></td><td>Ex</td><td>Exp</td><td>Em</td><td colspan='2'></td></tr>";
                $k = 1;
//        pre($detail[$heading_key]['category'][$category_key]);
                foreach ($detail[$heading_key]['category'][$category_key]['subcategory_desc'] as $sub_cat):
//                       pre($sub_cat);die;
                    $message .= "<tr><td>" . $j . "." . $k . "</td><td>" . $sub_cat['sub_desc'] . "</td>";
                    if ($sub_cat['ex'] == '') {
                        $message .= "<td><input type='checkbox' name='ex' disabled'></td>";
                    } else {
                        $message .= "<td><input type='checkbox' name='ex' checked='checked' disabled ></td>";
                    }
                    if ($sub_cat['exp'] == '') {
                        $message .= "<td><input type='checkbox' name='exp' disabled></td>";
                    } else {
                        $message .= "<td><input type='checkbox' name='exp' checked='checked' disabled></td>";
                    }
                    if ($sub_cat['em'] == '') {
                        $message .= "<td><input type='checkbox' name='em' disabled></td>";
                    } else {
                        $message .= "<td><input type='checkbox' name='em' checked='checked' disabled></td>";
                    }
                    if ($sub_cat['comment'] == '') {
                        $message .= "<td></td>";
                    } else {
                        $message .= "<td>" . $sub_cat['comment'] . "</td>";
                    }
                    if ($sub_cat['date'] == '') {
                        $message .= "<td></td>";
                    } else {
                        $message .= "<td>" . $sub_cat['date'] . "</td>";
                    }
                    $message .= "</tr>";

                    $k++;
                endforeach;
                $j++;
            endforeach;
            $i++;
            $message .= "</tbody></table>";
        endforeach;
        $this->Email_model->email_sendToParent($message, 'Progress Report', $email);

        $this->session->set_flashdata('flash_message', get_phrase('ratings_saved'));
        redirect(base_url() . 'index.php?teacher/progress_report_heading_wise/' . $class_id . '/' . $section_id . '/' . $student_id . "/" . $heading_id . "/" . $term_id, 'refresh');
    }

    function save_progress_report($class_id, $section_id, $subject_id) {
        $page_data = $this->get_page_data_var();
        //echo $class_id.$section_id.$subject_id; die;
        $this->load->model("Student_model");
        $this->load->model("Progress_model");
        $data['teacher_id'] = $this->session->userdata('teacher_id');
        $data['subject_id'] = $subject_id;
        $data['timestamp'] = date('y-m-d');
        $running_year = $this->Setting_model->get_year();

        $students = $this->Student_model->get_enroll_records(array('section_id' => $section_id, 'year' => $running_year));
        // var_dump($_POST);
        foreach ($students as $row) {
            $changed = $this->input->post('changedstudent' . $row['student_id']);
            if ($changed == "1") {
                $data['rate'] = $this->input->post('rate-student' . $row['student_id']);
                $data['comment'] = $this->input->post('comment-' . $row['student_id']);
                $data['student_id'] = $row['student_id'];
                $this->Progress_model->save_progress($data);
            }
        }
        $this->session->set_flashdata('flash_message', get_phrase('ratings_saved'));
        redirect(base_url() . 'index.php?teacher/progress_report_list/' . $class_id . '/' . $section_id . '/' . $subject_id, 'refresh');
    }

    /*     * **** DAILY ATTENDANCE **************** */

    /* function manage_attendance() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model('Section_model');
        $page_data['classes'] = $this->Class_model->get_class_by_teacher($this->session->userdata('login_user_id'));
        if (!empty($page_data['classes'])) {
            foreach ($page_data['classes'] as $val) {
                $page_data['class_id'] = $val['class_id'];
            }
        }
        $this->load->model("Holiday_model");
        $holidays = $this->Holiday_model->get_holiday_list_attendance();
        $holiday_dates = array();
        foreach ($holidays as $holiday) {
            $holiday_dates[] = $holiday['date_start'];
            for ($i = 0; $i < ($holiday['number_of_days'] - 1); $i++) {
                $holiday_dates[] = date('Y-m-d', strtotime($holiday['date_start'] . ' + ' . $i . ' days'));
            }
        }
        $page_data['holidays'] = $holiday_dates;
        $page_data['page_name'] = 'manage_attendance';
        $page_data['class_name'] = $this->Class_model->get_class_record(array('class_id' => $page_data['class_id']), "name");
        $page_data['page_title'] = get_phrase('manage_attendance_of_class') . ' ' . $page_data['class_name'];
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    } */

    function manage_attendance() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data = $this->get_page_data_var();
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->form_validation->set_rules('class_id', 'Class', 'required');
            $this->form_validation->set_rules('section_id', 'Section', 'required');
            $this->form_validation->set_rules('timestamp', 'Date', 'required');
            if ($this->form_validation->run() == TRUE) {
                $class_id = $this->input->post('class_id');
                $section_id = $this->input->post('section_id');
                $date = date('Y-m-d',strtotime($this->input->post('timestamp')));
                redirect(base_url('index.php?teacher/manage_attendance_view/'.$class_id.'/'.$section_id.'/'.$date),'refresh');
            } 
        }
        
        $classes = $this->db->get_where('class',array('teacher_id'=>$this->session->userdata('teacher_id')))->result();
        $page_data['class_ids'] = array();
        foreach($classes as $cls){
            $page_data['class_ids'][] = $cls->class_id;    
        }
        //echo '<pre>';print_r($page_data['class_ids']);exit;
        
        $this->load->model('Holiday_model');
        $holidays = $this->Holiday_model->get_holiday_list_attendance();
        $holiday_dates = array();
        foreach ($holidays as $holiday) {
            $holiday_dates[] = $holiday['date_start'];
            for ($i = 0; $i < ($holiday['number_of_days'] - 1); $i++) {
                $holiday_dates[] = date('Y-m-d', strtotime($holiday['date_start'] . ' + ' . $i . ' days'));
            }
        }
        $page_data['class_id'] = false;
        $page_data['section_id'] = false;
        $page_data['holidays'] = $holiday_dates;
        $page_data['page_name'] = 'manage_attendance';
        $page_data['page_title'] = get_phrase('manage_attendance_of_class');
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['classes'] = $this->Class_model->get_class_array();
        $this->load->view('backend/index', $page_data);
    }

    function manage_attendance_view($class_id = '', $section_id = '', $date = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');

        $this->load->model('Attendance_model');
        $this->load->model("Section_model");
        $page_data = $this->get_page_data_var();
        /* $page_data['classes'] = $this->Class_model->get_class_by_teacher($this->session->userdata('login_user_id'));
        if (!empty($page_data['classes'])) {
            foreach ($page_data['classes'] as $val) {
                $page_data['class_id'] = $val['class_id'];
            }
        } */

        $classes = $this->db->get_where('class',array('teacher_id'=>$this->session->userdata('teacher_id')))->result();
        $page_data['class_ids'] = array();
        foreach($classes as $cls){
            $page_data['class_ids'][] = $cls->class_id;    
        }
        $this->load->model("Holiday_model");
        $holidays = $this->Holiday_model->get_holiday_list_attendance();
        $holiday_dates = array();
        foreach ($holidays as $holiday) {
            $holiday_dates[] = $holiday['date_start'];
            for ($i = 0; $i < ($holiday['number_of_days'] - 1); $i++) {
                $holiday_dates[] = date('Y-m-d', strtotime($holiday['date_start'] . ' + ' . $i . ' days'));
            }
        }
        $page_data['holidays'] = $holiday_dates;
        $page_data['class_name'] = $this->Class_model->get_class_record(array('class_id' => $class_id), "name");
        $page_data['section_name'] = $this->Class_model->get_section_record(array('section_id' => $section_id), "name");
        $running_year = sett('running_year');
        $page_data['class_id'] = $class_id;
        $page_data['section_id'] = $section_id;
        $page_data['date'] = $date;
        $page_data['page_title'] = get_phrase('manage_attendance_of_class').' '.$page_data['class_name'].' : '.get_phrase('section').' '.$page_data['section_name'];
        //$page_data['att_of_students'] = $this->Attendance_model->getstudents_attendence($page_data['class_id'], $page_data['section_id'], $running_year, $page_data['timestamp']);
        
        $whr = array('E.class_id' => $class_id, 'E.section_id' => $section_id, 'E.year' => sett('running_year'));
        $page_data['attendance'] = $this->Attendance_model->get_student_attendance($whr,$date);

        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['sections'] = $this->Section_model->get_data_by_cols('*', array("class_id" => $class_id));
        $page_data['page_name'] = 'manage_attendance_view';
        $page_data['classes'] = $this->Class_model->get_class_array();
        //echo '<pre>'.$class_id;print_r($page_data['class_ids']);print_r($page_data['classes']);exit;
        $this->load->view('backend/index', $page_data);
    }

    function attendance_selector() {
        $this->form_validation->set_rules('class_id', 'Class', 'required');
        $this->form_validation->set_rules('section_id', 'Section', 'required');
        $this->form_validation->set_rules('timestamp', 'Date', 'required');
        $page_data = $this->get_page_data_var();
        if ($this->form_validation->run() == TRUE) {
            $data['class_id'] = $this->input->post('class_id');
            $data['year'] = $this->input->post('year');
            $data['timestamp'] = strtotime($this->input->post('timestamp'));
            $data['section_id'] = $this->input->post('section_id');
            $page_data['query'] = $this->Attendance_model->get_data_by_cols("*", array('class_id' => $data['class_id'], 'section_id' => $data['section_id'], 'year' => $data['year'], 'timestamp' => $data['timestamp']), "result_array");
            if (count($page_data['query']) < 1) {
                $students = $this->Enroll_model->get_data_by_cols("*", array('class_id' => $data['class_id'], 'section_id' => $data['section_id'], 'year' => $data['year']), "result_array");
            } else {
                $class_id = $data['class_id'];
                $students = $this->Student_model->student_attendance($data['class_id'], $data['year'], $data['timestamp']);
                if (empty($students)) {
                    redirect(base_url() . 'index.php?teacher/manage_attendance_view/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['timestamp'], 'refresh');
                }
            }
            foreach ($students as $row) {
                $attn_data['class_id'] = $data['class_id'];
                $attn_data['year'] = $data['year'];
                $attn_data['timestamp'] = $data['timestamp'];
                $attn_data['section_id'] = $data['section_id'];
                $attn_data['student_id'] = $row['student_id'];
                $rs = $this->Attendance_model->get_data_by_cols("*", array("year" => $data['year'], "timestamp" => $data['timestamp'], "student_id" => $row['student_id']), 'result_type');
                if (empty($rs)) {
                    $this->Attendance_model->add($attn_data);
                }
            }
            $page_data['attendance_of_students'] = $this->Attendance_model->get_data_by_cols('*', array('class_id' => $data['class_id'], 'section_id' => $data['section_id'], 'year' => $data['year'], 'timestamp' => $data['timestamp']), 'result_type');
            redirect(base_url() . 'index.php?teacher/manage_attendance_view/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['timestamp'], 'refresh');
        } else {
            $page_data['classes'] = $this->Class_model->get_class_array();
            $page_data['page_name'] = 'manage_attendance';
            $page_data['page_title'] = get_phrase('manage_attendance_of_class');
            $page_data['total_notif_num'] = $this->get_no_of_notication();
            $this->load->view('backend/index', $page_data);
        }
    }

    function attendance_update($class_id = '', $section_id = '', $date = '') {
        $page_data = $this->get_page_data_var();
        $running_year = $this->globalSettingsRunningYear;
        $active_sms_service1 = $this->Setting_model->get_setting_record(array('type' => 'active_sms_service'), 'description');
        $active_sms_service = @$active_sms_service1;
        $locationData = $this->globalSettingsLocation;

        if (empty($locationData)) {
            $this->session->set_flashdata('flash_message', "Set locataion country name in setting  for notification use.");
            rediect(base_url() . 'index.php?teacher/attendance_report');
        } else {
            $location = $this->globalSettingsLocation;
        }

        $stu_atten = $this->input->post('atten');
        $has_atten = $this->input->post('has_atten');

        foreach($stu_atten as $stu_id=>$status){
            $att_id = $has_atten[$stu_id]?$has_atten[$stu_id]:FALSE;
            if(!$att_id && $status!=0){
                $sturec = $this->Attendance_model->get_student(array('S.student_id'=>$stu_id));
                
                $whr = array('class_id'=>$class_id,'section_id'=>$section_id,'date'=>$date,'student_id'=>$stu_id);
                $record = $this->db->get_where('attendance',$whr)->row();
                
                if($record){
                    $flag = $this->db->update('attendance',array('status'=>$status),array('attendance_id'=>$record->attendance_id)); 
                }else{ 
                    $save_att = array('timezone'=>date_default_timezone_get(),
                                        'timestamp'=>time(),
                                        'date'=>$date,
                                        'year'=>_getYear(),
                                        'class_id'=>$sturec->class_id,
                                        'section_id'=>$sturec->section_id,
                                        'student_id'=>$stu_id,
                                        'status'=>$status,
                                        'custom_updated'=>1,
                                        'school_id'=>_getSchoolid());
                    $flag = $this->db->insert('attendance',$save_att);    
                }                   

                if($flag && !$record){    
                    $student_name = $sturec->name;
                    $receiver_phone = $sturec->parent_phone;
                    $device_token = $sturec->device_token;
                    $parent_email = $sturec->parent_email;
                    $parent_id = $sturec->parent_id;
                    $parent_name = $sturec->father_name.' '.$sturec->father_lname;
                    $fcm_server_key = $this->globalSettingsSystemFCMServerrKey;

                    if ($status == 2) {
                        $message = 'Your child' . ' ' . ucfirst($student_name) . ' is absent today. Your child either forgot to bring the rfid or was late today';
                        $activity = 'child_out';
                    } else {
                        $message = 'Your child' . ' ' . ucfirst($student_name) . ' is present today. Your child either forgot to bring the rfid or was late today';
                        $activity = 'child_in';
                    }

                    $msg = $message;
                    $message = array();
                    $message_body = $msg;
                    $message['sms_message'] = $msg;
                    $message['subject'] = $this->globalSettingsSystemName . " Student Attendance";
                    $message['messagge_body'] = $message_body;
                    $message['to_name'] = $parent_name;

                    $phone = array($receiver_phone);
                    $email = array($parent_email);

                    $user_details = array();
                    $user_details = array('user_id' => $parent_id, 'user_type' => 'parent');

                    if ($device_token != '') {
                        $user_details['device_details'] = array('token' => $device_token,'server_key' => $fcm_server_key,'instance' => CURRENT_INSTANCE);
                    }
                    //send_school_notification($activity, $message, $phone, $email, $user_details);
                }

                $this->session->set_flashdata('flash_message', get_phrase('attendance_updated'));
            }
        }

        redirect(base_url().'index.php?teacher/manage_attendance_view/'.$class_id.'/'.$section_id.'/'.$date, 'refresh');
    }

    function attendance_report() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model('Section_model');
        $page_data['classes'] = $this->Class_model->get_class_by_teacher($this->session->userdata('login_user_id'));
        if (!empty($page_data['classes'])) {
            foreach ($page_data['classes'] as $val) {
                $page_data['class_id'] = $val['class_id'];
            }
        }
        $page_data['month'] = date('m');
        $page_data['page_name'] = 'attendance_report';
        $page_data['page_title'] = get_phrase('attendance_report');
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    function attendance_report_view($class_id = '', $section_id = '', $month = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model('Section_model');
        if ($class_id == "" || $section_id == "") {
            redirect(base_url() . 'index.php?teacher/attendance_report', 'refresh');
        }
        $page_data['classes'] = $this->Class_model->get_class_by_teacher($this->session->userdata('login_user_id'));
        if (!empty($page_data['classes'])) {
            foreach ($page_data['classes'] as $val) {
                $page_data['class_id'] = $val['class_id'];
            }
        }
        $page_data['class_name'] = $this->Class_model->get_class_record(array('class_id' => $class_id), "name");
        $page_data['class_id'] = $class_id;
        $page_data['month'] = $month;
        $page_data['section_name'] = $this->Class_model->get_section_record(array('section_id' => $section_id), "name");
        $page_data['section_id'] = $section_id;
        $page_data['sections'] = $this->Class_model->get_section_array(array('class_id' => $class_id));
        $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
        $page_data['students'] = $this->Student_model->get_students_attendance($class_id, $section_id, $running_year);
        $page_data['year'] = explode('-', $running_year);
        $page_data['days'] = cal_days_in_month(CAL_GREGORIAN, $month, $page_data['year'][0]);
        $page_data['page_title'] = get_phrase('attendance_report_of_class') . ' ' . $page_data['class_name'] . ' : ' . get_phrase('section') . ' ' . $page_data['section_name'];
        $page_data['page_name'] = 'attendance_report_view';
        $page_data['total_notif_num'] = $this->get_no_of_notication();

        $page_data['data'] = '';
        $statusF = '';
        foreach ($page_data['students'] as $row):

            $page_data['data'] .= '<tr><td style="text-align: center;">' . $row['name'] . '</td>';

            for ($i = 1; $i <= $page_data['days']; $i++) {
                $timestamp = strtotime($i . '-' . $page_data['month'] . '-' . $page_data['year'][0]);
                $attendance = $this->db->get_where('attendance', array('section_id' => $page_data['section_id'], 'class_id' => $page_data['class_id'], 'year' => $running_year, 'MONTH(date)'=>$month,'student_id' => $row['student_id']))->result_array();
                $status = "";
                foreach ($attendance as $row1):
                    $month_dummy = date('j', $row1['timestamp']);
                    if ($i == $month_dummy)
                        $status = $row1['status'];
                endforeach;

                if ($status == 1) {
                    $statusF = '<i style="color: #00a651;">P</i>';
                } else if ($status == 2) {
                    $statusF = '<i style="color: #ee4749;">A</i>';
                } else {
                    $statusF = '&nbsp;';
                }

                $page_data['data'] .= '<td style="text-align: center;font-weight: bold;">' . $statusF . '</td>';
            }
        endforeach;
        $page_data['data'] .= '</tr>';

        $this->load->view('backend/index', $page_data);
    }

    function attendance_report_print_view($class_id = '', $section_id = '', $month = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $page_data['class_id'] = $class_id;
        $page_data['section_id'] = $section_id;
        $page_data['month'] = $month;
        $page_data['class_name'] = $this->Class_model->get_class_record(array('class_id' => $class_id), "name");
        $page_data['section_name'] = $this->Class_model->get_section_record(array('section_id' => $section_id), "name");
        $page_data['running_year'] = sett('running_year');
        $page_data['system_name'] = sett('system_name');
        $page_data['students'] = $this->Student_model->get_students_attendance($class_id, $section_id, $page_data['running_year']);
        $school_year = explode('-', $page_data['running_year']);
        $page_data['year'] = $year = date('m')>3?$school_year[0]:$school_year[1];
        $page_data['days'] = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $page_data['total_notif_num'] = $this->get_no_of_notication();

        $data = array();
        $page_data['data'] = '';
        $statusF = '';
        foreach ($page_data['students'] as $row):
            $page_data['data'] .= '<tr><td style="text-align: center;">' . $row['name'] . '</td>';
            for ($i = 1; $i <= $page_data['days']; $i++) {
                //$timestamp = strtotime($i . '-' . $page_data['month'] . '-' . $page_data['year'][0]);
                $date = $year.'-'.$month.'-'.($i<10?'0'.$i:$i);
                $whr = array( 'class_id' => $class_id,'section_id' => $section_id,'year' =>$page_data['running_year'],'date' => $date, 
                            'student_id' => $row['student_id']);
                $attendance = $this->db->get_where('attendance', $whr)->row();
                $status = $attendance?$attendance->status:'';
            
                if ($status == 1) {
                    $statusF = '<i style="color: #00a651;">P</i>';
                } else if ($status == 2) {
                    $statusF = '<i style="color: #ee4749;">A</i>';
                } else {
                    $statusF = '&nbsp;';
                }

                $page_data['data'] .= '<td style="text-align: center;font-weight: bold;">' . $statusF . '</td>';
            }
        endforeach;
        $page_data['data'] .= '</tr>';

        $this->load->view('backend/teacher/attendance_report_print_view', $page_data);
    }

    function attendance_report_selector() {
        $page_data = $this->get_page_data_var();
        $data['class_id'] = $this->input->post('class_id');
        $data['year'] = $this->input->post('year');
        $data['month'] = $this->input->post('month');
        $data['section_id'] = $this->input->post('section_id');
        redirect(base_url() . 'index.php?teacher/attendance_report_view/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['month'], 'refresh');
    }

    /********************** SUBJECT WISE ATTENDANCE *****************/
    function subjectwise_attendance() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model('Section_model');
        $this->load->model('Holiday_model');
        $teacher_id = $this->session->userdata('teacher_id');

        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->form_validation->set_rules('class_id', 'Class', 'required');
            $this->form_validation->set_rules('section_id', 'Section', 'required');
            $this->form_validation->set_rules('subject_id', get_phrase('subject'), 'required');
            $this->form_validation->set_rules('date', 'Date', 'required');
            if ($this->form_validation->run() == TRUE) {
                $class_id = $this->input->post('class_id');
                $section_id = $this->input->post('section_id');
                $subject_id = $this->input->post('subject_id');
                $date = date('Y-m-d',strtotime($this->input->post('date')));
                redirect(base_url('index.php?teacher/subjectwise_attendance_view/'.$class_id.'/'.$section_id.'/'.$subject_id.'/'.$date),'refresh');
            } 
        }

        $holidays = $this->Holiday_model->get_holiday_list_attendance();
        $holiday_dates = array();
        foreach ($holidays as $holiday) {
            $holiday_dates[] = $holiday['date_start'];
            for ($i = 1; $i <= ($holiday['number_of_days']-1); $i++) {
                $holiday_dates[] = date('Y-m-d', strtotime($holiday['date_start'] . ' + ' . $i . ' days'));
            }
        }
        $page_data['holidays'] = $holiday_dates;

        _school_cond();
        $page_data['subjects'] = $subjects = $this->db->get_where('subject',array('teacher_id'=>$teacher_id))->result();

        $page_data['class_ids'] = array();
        foreach($subjects as $sub){
            $page_data['class_ids'][] = $sub->class_id;    
        }
        
        $page_data['classes'] = array();
        if($page_data['class_ids']){
            _school_cond();
            $page_data['classes'] = $classes = $this->db->where_in('class_id',$page_data['class_ids'])->get('class')->result();
        }
        //echo '<pre>';print_r( $page_data['classes']);exit;

        $page_data['page_name'] = 'manage_subject_attendance';
        //$page_data['class_name'] = $this->Class_model->get_class_record(array('class_id' => $page_data['class_id']), "name");
        $page_data['page_title'] = get_phrase('manage_subject_attendance');
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    function subjectwise_attendance_view($class_id = '', $section_id = '', $subject_id='',$date = '') {
        //$this->load->model('Attendance_subjectwise_model');
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model('Attendance_model');
        $this->load->model("Section_model");
        $this->load->model('Holiday_model');
        $teacher_id = $this->session->userdata('teacher_id');

        $holidays = $this->Holiday_model->get_holiday_list_attendance();
        $holiday_dates = array();
        foreach ($holidays as $holiday) {
            $holiday_dates[] = $holiday['date_start'];
            for ($i = 1; $i <= ($holiday['number_of_days']-1); $i++) {
                $holiday_dates[] = date('Y-m-d', strtotime($holiday['date_start'] . ' + ' . $i . ' days'));
            }
        }
        $page_data['holidays'] = $holiday_dates;
        $page_data['teacher_id'] = $teacher_id;
        $page_data['class_id'] = $class_id;
        $page_data['section_id'] = $section_id;
        $page_data['subject_id'] = $subject_id;
        $page_data['date'] = $date;

        
        _school_cond();
        $page_data['subjects'] = $subjects = $this->db->get_where('subject',array('teacher_id'=>$teacher_id))->result();

        $page_data['class_ids'] = array();
        foreach($subjects as $sub){
            $page_data['class_ids'][] = $sub->class_id;    
        }
        
        $page_data['classes'] = array();
        if($page_data['class_ids']){
            _school_cond();
            $page_data['classes'] = $classes = $this->db->where_in('class_id',$page_data['class_ids'])->get('class')->result();
        }

        $page_data['class_name'] = $this->Class_model->get_class_record(array('class_id' => $class_id), "name");
        $page_data['section_name'] = $this->Class_model->get_section_record(array('section_id' => $section_id), "name");
        $running_year = sett('running_year');

        //$page_data['att_of_students'] = $this->Attendance_subjectwise_model->getstudents_attendence($page_data['class_id'], $page_data['section_id'], $running_year, $page_data['timestamp']);
        $page_data['sections'] = $this->Section_model->get_data_generic_fun('*', array("class_id" => $class_id));

        $page_data['subjects'] = $this->Subject_model->get_data_by_cols('*', array("class_id" => $class_id, "section_id" => $section_id, 'teacher_id' => $teacher_id));
        //echo '<pre>';print_r($page_data['subjects']);exit;
        $whr = array('E.class_id' => $class_id, 'E.section_id' => $section_id, 'E.year' => sett('running_year'));
        $page_data['attendance'] = $this->Attendance_model->get_student_subject_attendance($whr,$subject_id,$date);
        $page_data['page_title'] = get_phrase('manage_subject_attendance_of_class') . ' ' . $page_data['class_name'] . ' : ' . get_phrase('section') . ' ' . $page_data['section_name'];
        $page_data['page_name'] = 'manage_subject_attendance_view';
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    function subjectwise_attendance_update($class_id = '', $section_id = '', $subject_id='', $date = '') {
        $page_data = $this->get_page_data_var();
        $running_year = $this->globalSettingsRunningYear;
        $active_sms_service1 = $this->Setting_model->get_setting_record(array('type' => 'active_sms_service'), 'description');
        $active_sms_service = @$active_sms_service1;
        $locationData = $this->globalSettingsLocation;

        if (empty($locationData)) {
            $this->session->set_flashdata('flash_message', "Set locataion country name in setting for notification use.");
            rediect(base_url() . 'index.php?teacher/subjectwise_attendance');
        } else {
            $location = $this->globalSettingsLocation;
        }

        $stu_atten = $this->input->post('atten');
        $has_atten = $this->input->post('has_atten');

        _school_cond();
        $subject = $this->db->get_where('subject',array('subject_id'=>$subject_id))->row();
        foreach($stu_atten as $stu_id=>$status){
            $att_id = $has_atten[$stu_id]?$has_atten[$stu_id]:FALSE;
            if(!$att_id && $status!=0){
                $sturec = $this->Attendance_model->get_student(array('S.student_id'=>$stu_id));
                
                $whr = array('class_id'=>$class_id,'section_id'=>$section_id,'subject_id'=>$subject_id,'date'=>$date,'student_id'=>$stu_id);
                $record = $this->db->get_where('subject_attendance',$whr)->row();
                
                if($record){
                    $flag = $this->db->update('subject_attendance',array('status'=>$status),array('id'=>$record->id)); 
                }else{
                    $save_att = array('class_id'=>$class_id,
                                      'section_id'=>$section_id,
                                      'student_id'=>$stu_id,
                                      'subject_id'=>$subject_id,
                                      'status'=>$status,
                                      'date'=>$date,
                                      'time'=>date('Y-m-d H:i:s'),
                                      'year'=>_getYear(),
                                      'school_id'=>_getSchoolid());
                    $flag = $this->db->insert('subject_attendance',$save_att);  
                }            

                if($status == 1 || $status == 2){
                    $student_name = $sturec->name;
                    $receiver_phone = $sturec->parent_phone;
                    $device_token = $sturec->device_token;
                    $parent_email = $sturec->parent_email;
                    $parent_id = $sturec->parent_id;
                    $parent_name = $sturec->father_name.' '.$sturec->father_lname;
                    $fcm_server_key = $this->globalSettingsSystemFCMServerrKey;

                    if ($status == 2) {
                        $message = 'Your child' . ' ' . ucfirst($student_name) . ' is absent for '.$subject->name.'subject today.';
                        $activity = 'subject_att_absent';
                    } else {
                        $message = 'Your child' . ' ' . ucfirst($student_name) . ' is present for '.$subject->name.'subject today.';
                        $activity = 'subject_att_present';
                    }

                    $msg = $message;
                    $message = array();
                    $message_body = $msg;
                    $message['sms_message'] = $msg;
                    $message['subject'] = $this->globalSettingsSystemName . " Student Subject Attendance";
                    $message['messagge_body'] = $message_body;
                    $message['to_name'] = $parent_name;

                    $phone = array($receiver_phone);
                    $email = array($parent_email);

                    $user_details = array();
                    $user_details = array('user_id' => $parent_id, 'user_type' => 'parent');

                    if ($device_token != '') {
                        $user_details['device_details'] = array('token' => $device_token,'server_key' => $fcm_server_key,'instance' => CURRENT_INSTANCE);
                    }
                    send_school_notification($activity, $message, $phone, $email, $user_details);
                }    

                $this->session->set_flashdata('flash_message', get_phrase('attendance_updated'));
            }
        }

        redirect(base_url('index.php?teacher/subjectwise_attendance_view/'.$class_id.'/'.$section_id.'/'.$subject_id.'/'.$date), 'refresh');
    }

    function subject_attendance_report() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model('Section_model');
        $this->load->model('Holiday_model');
        $teacher_id = $this->session->userdata('teacher_id');

        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->form_validation->set_rules('class_id', 'Class', 'required');
            $this->form_validation->set_rules('section_id', 'Section', 'required');
            $this->form_validation->set_rules('subject_id', get_phrase('subject'), 'required');
            $this->form_validation->set_rules('month', 'Month', 'required');
            if ($this->form_validation->run() == TRUE) {
                $class_id = $this->input->post('class_id');
                $section_id = $this->input->post('section_id');
                $subject_id = $this->input->post('subject_id');
                $month = $this->input->post('month');
                redirect(base_url('index.php?teacher/subject_attendance_report_view/'.$class_id.'/'.$section_id.'/'.$subject_id.'/'.$month),'refresh');
            } 
        }

        $holidays = $this->Holiday_model->get_holiday_list_attendance();
        $holiday_dates = array();
        foreach ($holidays as $holiday) {
            $holiday_dates[] = $holiday['date_start'];
            for ($i = 1; $i <= ($holiday['number_of_days']-1); $i++) {
                $holiday_dates[] = date('Y-m-d', strtotime($holiday['date_start'] . ' + ' . $i . ' days'));
            }
        }
        $page_data['holidays'] = $holiday_dates;

        _school_cond();
        $page_data['subjects'] = $subjects = $this->db->get_where('subject',array('teacher_id'=>$teacher_id))->result();

        $page_data['class_ids'] = array();
        foreach($subjects as $sub){
            $page_data['class_ids'][] = $sub->class_id;    
        }

        $page_data['classes'] = array();
        if($page_data['class_ids']){
            _school_cond();
            $page_data['classes'] = $classes = $this->db->where_in('class_id',$page_data['class_ids'])->get('class')->result();
        }

        $page_data['month'] = date('m');
        $page_data['page_name'] = 'subject_attendance_report';
        $page_data['page_title'] = get_phrase('subject_attendance_report');
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    function subject_attendance_report_view($class_id='', $section_id='', $subject_id='', $month='') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        
        if ($class_id == '' || $section_id == '' || $subject_id=='') {
            redirect(base_url() . 'index.php?teacher/subject_attendance_report', 'refresh');
        }

        $page_data = $this->get_page_data_var();
        $this->load->model('Section_model');
        $this->load->model('Holiday_model');
        $teacher_id = $this->session->userdata('teacher_id');
        
        $page_data['class_id'] = $class_id;
        $page_data['section_id'] = $section_id;
        $page_data['subject_id'] = $subject_id;
        $page_data['month'] = $month;
        $page_data['running_year'] = $running_year = sett('running_year');
        
        $holidays = $this->Holiday_model->get_holiday_list_attendance();
        $holiday_dates = array();
        foreach ($holidays as $holiday) {
            $holiday_dates[] = $holiday['date_start'];
            for ($i = 1; $i <= ($holiday['number_of_days']-1); $i++) {
                $holiday_dates[] = date('Y-m-d', strtotime($holiday['date_start'] . ' + ' . $i . ' days'));
            }
        }
        $page_data['holidays'] = $holiday_dates;

        _school_cond();
        $page_data['subjects'] = $subjects = $this->db->get_where('subject',array('teacher_id'=>$teacher_id))->result();

        $page_data['class_ids'] = array();
        foreach($subjects as $sub){
            $page_data['class_ids'][] = $sub->class_id;    
        }
        
        $page_data['classes'] = array();
        if($page_data['class_ids']){
            _school_cond();
            $page_data['classes'] = $classes = $this->db->where_in('class_id',$page_data['class_ids'])->get('class')->result();
        }
      
        $page_data['class_name'] = $this->Class_model->get_class_record(array('class_id' => $class_id), "name");
        $page_data['section_name'] = $this->Class_model->get_section_record(array('section_id' => $section_id), "name");
        $page_data['sections'] = $this->Section_model->get_data_generic_fun('*', array("class_id" => $class_id));
        $page_data['students'] = $this->Student_model->get_students_attendance($class_id, $section_id, $running_year);
        
        $school_year = explode('-', $running_year);
        $page_data['year'] = $year = date('m')>3?$school_year[0]:$school_year[1];
        $page_data['days'] = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $page_data['total_notif_num'] = $this->get_no_of_notication();

        $page_data['page_title'] = get_phrase('subject_attendance_report_of_class') . ' ' . $page_data['class_name'] . ' : ' . get_phrase('section') . ' ' . $page_data['section_name'];
        $page_data['page_name'] = 'subject_attendance_report_view';

        $page_data['data'] = '';
        $statusF = '';
        foreach ($page_data['students'] as $row):
            $page_data['data'] .= '<tr><td style="text-align: center;">' . $row['name'] . '</td>';
            for ($i = 1; $i <= $page_data['days']; $i++) {
                $date = $year.'-'.$month.'-'.($i<10?'0'.$i:$i);
                $whr = array( 'class_id' => $class_id,'section_id' => $section_id,'subject_id'=>$subject_id,'year' =>$running_year,'date' => $date,
                    'student_id' => $row['student_id']);
                $attendance = $this->db->get_where('subject_attendance', $whr)->row();
                $status = $attendance?$attendance->status:'';
            
                if ($status == 1) {
                    $statusF = '<i style="color: #00a651;">P</i>';
                } else if ($status == 2) {
                    $statusF = '<i style="color: #ee4749;">A</i>';
                } else {
                    $statusF = '&nbsp;';
                }

                $page_data['data'] .= '<td style="text-align: center;font-weight: bold;">' . $statusF . '</td>';
            }
        endforeach;
        $page_data['data'] .= '</tr>';
        $this->load->view('backend/index', $page_data);
    }

    function subject_attendance_report_print_view($class_id = '', $section_id = '', $subject_id='', $month = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $page_data['class_id'] = $class_id;
        $page_data['section_id'] = $section_id;
        $page_data['month'] = $month;
        $page_data['class_name'] = $this->Class_model->get_class_record(array('class_id' => $class_id), "name");
        $page_data['section_name'] = $this->Class_model->get_section_record(array('section_id' => $section_id), "name");
        $page_data['running_year'] = $running_year = sett('running_year');
        $page_data['system_name'] = sett('system_name');
        $page_data['students'] = $this->Student_model->get_students_attendance($class_id, $section_id, $page_data['running_year']);
        $school_year = explode('-', $running_year);
        $page_data['year'] = $year = date('m')>3?$school_year[0]:$school_year[1];
        $page_data['days'] = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $page_data['total_notif_num'] = $this->get_no_of_notication();

        $data = array();
        $page_data['data'] = '';
        $statusF = '';
        foreach ($page_data['students'] as $row):
            $page_data['data'] .= '<tr><td style="text-align: center;">' . $row['name'] . '</td>';

            for ($i = 1; $i <= $page_data['days']; $i++) {
                $date = $year.'-'.$month.'-'.($i<10?'0'.$i:$i);
                $whr = array( 'class_id' => $class_id,'section_id' => $section_id,'subject_id'=>$subject_id,'year' =>$running_year,'date' => $date,
                    'student_id' => $row['student_id']);
                $attendance = $this->db->get_where('subject_attendance', $whr)->row();
                $status = $attendance?$attendance->status:'';
            
                if ($status == 1) {
                    $statusF = '<i style="color: #00a651;">P</i>';
                } else if ($status == 2) {
                    $statusF = '<i style="color: #ee4749;">A</i>';
                } else {
                    $statusF = '&nbsp;';
                }

                $page_data['data'] .= '<td style="text-align: center;font-weight: bold;">' . $statusF . '</td>';
            }
        endforeach;
        $page_data['data'] .= '</tr>';

        $this->load->view('backend/teacher/subject_attendance_report_print_view', $page_data);
    }

    /*     * ********MANAGE LIBRARY / BOOKS******************* */

    function book($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();
        $page_data['books'] = $this->Book_model->get_data_by_cols();
        $page_data['page_name'] = 'book';
        $page_data['page_title'] = get_phrase('manage_library_books');
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    /*     * ********MANAGE TRANSPORT / VEHICLES / ROUTES******************* */

    function transport($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();
        $page_data['search_text'] = '';

        if (($param1 == 'search') && ($param2 != '')) {
            $page_data['search_text'] = $param2;
        }

        $page_data['page_name'] = 'transport';
        $page_data['page_title'] = get_phrase('manage_transport');
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    /*     * *MANAGE EVENT / NOTICEBOARD, WILL BE SEEN BY ALL ACCOUNTS DASHBOARD* */

    function noticeboard() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model("Notification_model");
        $this->load->model("Section_model");
        $teacher_id = $this->session->userdata('login_user_id');
        $page_data['page_name'] = 'noticeboard';
        $page_data['page_title'] = get_phrase('manage_noticeboard');
        $teacher_id = $this->session->userdata('teacher_id');
        $page_data['teacher_class'] = $this->Section_model->get_class_deatils_by_teacher($teacher_id);
        $notices = $this->Notification_model->getNotices_for_teacher($teacher_id);
        $page_data['total_notif_num'] = $this->get_no_of_notication();

        //pre($notices);die;

        /*if(count($notices)){
            foreach ($notices as $key => $row) {
                $class_data = $this->Class_model->get_data_by_cols('', array('class_id' => $row['class_id']), 'result_array');
                $notices[$key]['class_name'] = @$class_data[0]['name'];
            }
        }*/

        $page_data['notices'] = $notices;
        $this->load->view('backend/index', $page_data);
    }

    /*     * ********MANAGE DOCUMENT / home work FOR A SPECIFIC CLASS or ALL****************** */

    function document($do = '', $document_id = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();
        if ($do == 'upload') {
            move_uploaded_file($_FILES["userfile"]["tmp_name"], "uploads/document/" . $_FILES["userfile"]["name"]);
            $data['document_name'] = $this->input->post('document_name');
            $data['file_name'] = $_FILES["userfile"]["name"];
            $data['file_size'] = $_FILES["userfile"]["size"];
            $this->Document_model->add($data);

            redirect(base_url() . 'teacher/manage_document', 'refresh');
        }
        if ($do == 'delete') {
            $this->Document_model->deleteDocument($document_id);

            redirect(base_url() . 'teacher/manage_document', 'refresh');
        }
        $page_data['page_name'] = 'manage_document';
        $page_data['page_title'] = get_phrase('manage_documents');
        $page_data['documents'] = $this->Document_model->get_data_by_cols();
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    /*     * *******MANAGE STUDY MATERIAL*********** */

    function study_material($task = "", $document_id = "") {
        if ($this->session->userdata('teacher_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $page_data = $this->get_page_data_var();
        $this->load->model("Crud_model");
        $this->load->model("Subject_model");
        $teacher_id = $this->session->userdata('teacher_id');
        $data = $page_data;
        $data['classes'] = $this->Subject_model->get_classes_by_teacher($teacher_id);
        if (!empty($data['classes'])) {
            if ($task == '') {
                $data['class_id'] = $data['classes'][0]['class_id'];
            } else {
                $data['class_id'] = $task;
            }
        }
        //exit;
        $data['study_material_info'] = $this->Crud_model->get_study_material($data['class_id']);
        if ($task == "create") {
            $this->form_validation->set_rules('title', 'File Title', 'trim|required');
            $this->form_validation->set_rules('class_id', 'Class Name', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            if (empty($_FILES['file_name']['name'])) {
                $this->form_validation->set_rules('file_name', 'Document', 'required');
            }
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('flash_message_error', validation_errors());
                redirect(base_url() . 'index.php?teacher/study_material');
            } else {
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
                if (in_array($_FILES['file_name']['type'], $allowed_types)) {
                    $this->Crud_model->save_study_material_info();
                    $class_id = $this->input->post('class_id');
                    $this->session->set_flashdata('flash_message', get_phrase('study_material_saved_successfuly'));
                    redirect(base_url() . 'index.php?teacher/study_material/' . $class_id, 'refresh');
                } else {
                    $this->session->set_flashdata('flash_message_error', 'Sorry, File extension is not supported');
                    redirect(base_url() . 'index.php?teacher/study_material');
                }
            }
        }

        if ($task == "update") {
            $file_uploaded = $_FILES['file_name']['name'];
            $allowed_types = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'image/png',
                'image/jpg',
                'image/jpeg',
                'text/plain',
                'application/pdf',
                'application/msword');

            if (in_array($_FILES['file_name']['type'], $allowed_types)) {
                $this->Crud_model->update_study_material_info($document_id);
                $class_id = $this->input->post('class_id');
                $this->session->set_flashdata('flash_message', get_phrase('study_material_info_updated_successfuly'));
                redirect(base_url() . 'index.php?teacher/study_material/' . $class_id, 'refresh');
            } else {
                $this->session->set_flashdata('flash_message_error', 'Sorry, File extension is not supported');
                redirect(base_url() . 'index.php?teacher/study_material', 'refresh');
            }
        }

        if ($task == "delete") {
            $this->Crud_model->delete_study_material_info($document_id);
            redirect(base_url() . 'index.php?teacher/study_material');
        }
        $data['page_name'] = 'study_material';
        $data['page_title'] = get_phrase('study_material');
        $this->load->view('backend/index', $data);
    }

    /* private messaging */

    function message($param1 = 'message_home', $param2 = '', $param3 = '') {
        $this->load->model('Message_model');
        if ($this->session->userdata('teacher_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $page_data = $this->get_page_data_var();

        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
        }

        if ($param1 == 'send_new') {
            $message_thread_code = $this->Crud_model->send_new_private_message_admin();
            //echo $message_thread_code;die;
            //$this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?teacher/message/message_read/' . $message_thread_code, 'refresh');
        }

        if ($param1 == 'send_reply') {
            $this->Crud_model->send_reply_message($param2);  //$param2 = message_thread_code
            //$this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?teacher/message/message_read/' . $param2, 'refresh');
        }
        if ($param1 == 'message_new') {
            $this->load->model('School_Admin_model');
            $page_data['admins'] = $this->School_Admin_model->get_school_admin();
            //$page_data['admins'] = get_data_generic_fun('school_admin', '*', array('status' => '1', 'school_id' => $school_id), 'result_array', array('name'=>'asc'));
            $page_data['teachers'] = get_data_generic_fun('teacher', '*', array('isActive' => '1', 'teacher_status' => '1', 'school_id' => $school_id), 'result_array', array('name'=>'asc'));
            $page_data['students'] = get_data_generic_fun('student', '*', array('isActive' => '1', 'student_status' => '1', 'school_id' => $school_id), 'result_array', array('name'=>'asc'));
            $page_data['parents'] = get_data_generic_fun('parent', '*', array('isActive' => '1', 'parent_status' => '1', 'school_id' => $school_id), 'result_array', array('father_name'=>'asc'));
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

                if ($sender_account_type == 'parent') {
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
                } else if ($sender_account_type == 'teacher') {
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
            $teacher_deleted = "teacher_deleted";
            $delete_message = $this->Message_model->delete_msg_thread($param2, $teacher_deleted);
            $thread_code = $this->Message_model->get_data_by_cols("*", array('message_id' => $param2), "res_arr");
            if (!empty($thread_code)) {
                $thread_code = $thread_code[0]['message_thread_code'];
            } else {
                $thread_code = "";
            }
            if ($delete_message) {
                //$this->session->set_flashdata('flash_message', get_phrase('message_deleted!'));
                redirect(base_url() . 'index.php?teacher/message/message_read/' . $thread_code, 'refresh');
            } else {
                //$this->session->set_flashdata('flash_message_error', get_phrase('could_not_delete!'));
                redirect(base_url() . 'index.php?teacher/message/message_read/' . $thread_code, 'refresh');
            }
        }
        $i = 0;
        $page_data['current_user'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $current_user_threads = $this->Message_model->get_message_threads_parent($page_data['current_user']);
        //pre($current_user_threads);die;
        foreach ($current_user_threads as $key => $row) {
            if ($row['reciever'] == $page_data['current_user']) {
                $model = $row['sender'];
                $models = explode('-', $model);
                if (!empty($models[0])) {
                    $table_name = $models[0];
                    $model_name = ucfirst($models[0] . "_model");

                    if($models[0] == 'school_admin'){
                        $model_name = 'School_Admin_model';
                    }

                    $receiver_id = $models[1];
                }
            } else {
                $model = $row['reciever'];
                $models = explode('-', $model);
                if (!empty($models[0])) {
                    $table_name = $models[0];
                    $model_name = ucfirst($models[0] . "_model");

                    if($models[0] == 'school_admin'){
                        $model_name = 'School_Admin_model';
                    }

                    $receiver_id = $models[1];
                }
            }

            $this->load->model($model_name);
            $details = $this->$model_name->get_data_by_cols('*', array($table_name . '_id' => $receiver_id), 'result_array');
            //echo '<br>'.$this->db->last_query();
            $current_user_threads[$key] = array_merge($row, $details[$i]);
//echo 'key='.$key.pre($row);
//echo 'key='.$key.'->'.pre($details);
            //$i++;
            //pre($current_user_threads);

        }


//pre($current_user_threads);
//die;

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
            $this->load->view('backend/teacher/message_ajax', $page_data);
        }else{
            $this->load->view('backend/index', $page_data);
        }
    }

    function books_detail() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $page_data['books'] = $this->Crud_model->get_books_list();
        $page_data['page_name'] = 'books_detail';
        $page_data['page_title'] = get_phrase('books_list');
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    function issued_books() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $teacher_id = $this->session->userdata('teacher_id');
        $page_data['user_type'] = "Teacher";
        $page_data['user_id'] = $teacher_id;

        $page_data['issue_log'] = $this->Book_model->get_books_issue_records($page_data, "issue_id", "desc");

        $page_data['page_name'] = 'issued_books';
        $page_data['page_title'] = get_phrase('issued_books');
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    function ajax_check_unread_message() {
        $page_data = $this->get_page_data_var();
        $cUserId = $this->input->post('cUserId', TRUE);
        $content = get_unread_message($cUserId, 'teacher');
        echo $content;
        die;
    }

    function set_ptm_time($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $page_data['class_id'] = "";
        $page_data['section_id'] = "";
        $page_data['exam_id'] = "";
        $class_id = $this->input->post('class_name');
        $this->load->model("Section_model");
        $student_details = array();
        $save_array = array();
        $teacher_id = $this->session->userdata('teacher_id');
        $teacher_class = $this->Section_model->get_class_deatils_by_teacher($teacher_id);
        $running_year = get_data_generic_fun('settings', 'description', array('type' => 'running_year'), 'result_arr');
        $year = $running_year[0]['description'];
        $form_submit = $this->input->post('view_details1');
        if ($form_submit == 'view_details') {
            $page_data['class_id'] = $this->input->post('class_name');
            $page_data['section_id'] = $this->input->post('section_id');
            $page_data['exam_id'] = $this->input->post('exam_holder');
            $meeting_date = get_data_generic_fun('parrent_teacher_meeting_date', 'meeting_date', array('class_id' => $page_data['class_id'], 'section_id' => $page_data['section_id'], 'exam_id' => $page_data['exam_id']), 'result_arr');
            if (!empty($meeting_date)) {
                $page_data['date'] = $meeting_date[0]['meeting_date'];
            } else {
                $page_data['date'] = '';
            }
            if (!empty($page_data['exam_id'])) {
                $exam_det = get_data_generic_fun('exam', 'name', array('exam_id' => $page_data['exam_id']), 'result_arr');
                if (!empty($exam_det)) {
                    $page_data['exam_name'] = $exam_det[0]['name'];
                    $student_details = $this->Parent_teacher_meeting_date_model->get_student_details_for_ptm($page_data['class_id'], $page_data['section_id'], $year);
                    $page_data['student_details'] = $student_details;
                }
            }
        }
        if ($param1 == 'save_time') {
            $save_array['exam_id'] = $this->input->post('exam_id');
            $save_array['student_id'] = $this->input->post('studentId');
            $class_id = get_data_generic_fun('enroll', 'class_id', array('student_id' => $save_array['student_id']), 'result_arr');
            $save_array['class_id'] = $class_id[0]['class_id'];
            $section_id = get_data_generic_fun('enroll', 'section_id', array('student_id' => $save_array['student_id']), 'result_arr');
            $save_array['section_id'] = $section_id[0]['section_id'];
            $save_array['teacher_id'] = $teacher_id;
            $parrent_id = get_data_generic_fun('student', 'parent_id', array('student_id' => $save_array['student_id']), 'result_arr');
            $save_array['parrent_id'] = $parrent_id[0]['parent_id'];
            $parrent_teacher_meeting_date_id = get_data_generic_fun('parrent_teacher_meeting_date', 'parrent_teacher_meeting_date_id', array('class_id' => $save_array['class_id'], 'section_id' => $save_array['section_id']), 'result_arr');
            $save_array['parrent_teacher_meeting_date_id'] = $parrent_teacher_meeting_date_id[0]['parrent_teacher_meeting_date_id'];
            $parrent_teacher_meeting_date = get_data_generic_fun('parrent_teacher_meeting_date', 'meeting_date', array('class_id' => $save_array['class_id'], 'section_id' => $save_array['section_id']), 'result_arr');
            $save_array['parrent_teacher_meeting_date'] = $parrent_teacher_meeting_date[0]['meeting_date'];
            $save_array['time'] = $this->input->post('time');
            $save_array['parrent_accepted'] = '1';
            $save_array['accepted_time'] = date('Y-m-d H:i:s');

            if ($this->Parent_teacher_meeting_model->set_parent_teacher_meeting_schedule($save_array)) {
                $this->session->set_flashdata('flash_message', get_phrase('Time slot has been sent to parent.'));
                $response_array = array('status' => "success", 'message' => "Sent To Parent");
                print_r(json_encode($response_array));
                exit;
            } else {
                $this->session->set_flashdata('flash_message', get_phrase('PTM time has been updated.'));
                $response_array = array('status' => "failed", 'message' => "Failed To Sent Parent");
                print_r(json_encode($response_array));
                exit;
            }
            $page_data['parrent_accepted'] = $save_array['parrent_accepted'];
        }

        if ($param1 == 'edit_time') {
            $save_array['student_id'] = $this->input->post('studentId');
            $save_array['time'] = $this->input->post('time');
            $save_array['accepted_time'] = date('Y-m-d H:i:s');
            $condition = array('student_id' => $save_array['student_id']);
            if ($this->Parent_teacher_meeting_model->edit_parent_teacher_meeting_schedule($save_array, $condition)) {
                $response_array = array('status' => "success", 'message' => "Sent To Parent");
                print_r(json_encode($response_array));
                exit;
            } else {
                $response_array = array('status' => "failed", 'message' => "Failed To Sent Parent");
                print_r(json_encode($response_array));
                exit;
            }
        }

        if ($class_id != '') {
            $sections = $this->Section_model->get_section($class_id, $this->session->userdata('teacher_id'));
            $page_data['sections'] = $sections;
        }
        $page_data['exam'] = get_data_generic_fun('exam', '*', array(), 'result_arr');
        $page_data['exam_id'] = $page_data['exam'][0]['exam_id'];
        $page_data['classes'] = $teacher_class;
        $page_data['page_name'] = 'set_ptm';
        $page_data['page_title'] = get_phrase('set_ptm_time');
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    function download_study_material() {
        $page_data = $this->get_page_data_var();
        $this->load->helper('download');
        if ($this->uri->segment(3)) {
            $data = file_get_contents('./uploads/document/' . $this->uri->segment(3));
        }
        $name = $this->uri->segment(3);
        force_download($name, $data);
    }

    function study_material_preview() {
        $page_data = $this->get_page_data_var();
        $page_data['title'] = get_phrase('study_material_preview');
        $page_data['preview_title'] = get_phrase('study_material_preview');
        $page_data['page_name'] = 'preview';
        $page_data['page_title'] = get_phrase('preview');

        $file_name = $this->uri->segment(3);

        $page_data['url'] = base_url("uploads/document/" . $file_name);
        //$page_data['url'] = 'http://'.CURRENT_IP_ADDR.'/beta_ag/uploads/Class_Upload_Template.xlsx';
        $this->load->view('backend/index', $page_data);
    }

    function validate_student_image() {
        $page_data = $this->get_page_data_var();
        $config['upload_path'] = './uploads/student_image';
        $config['allowed_types'] = 'gif|jpg|png';
        //$config['max_size']    = '100';
        //$config['max_width']  = '1024';
        // $config['max_height']  = '768';

        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile')) {
            $this->form_validation->set_message('validate_student_image', $this->upload->display_errors());
            return false;
        } else {
            return true;
        }
    }

    function get_class_sections_by_teachers($teacher_id, $class_id) {
        $page_data = $this->get_page_data_var();
        $this->load->model("Section_model");
        return $sections = $this->Section_model->get_data_generic_fun('*', array('teacher_id' => $teacher_id), 'result_arr');
    }

    /*
     * Total number of notification for today
     * 
     */

    public function get_no_of_notication() {
        /*$page_data = $this->get_page_data_var();
        $this->load->model("Notification_model");
        $user_notif_user = $this->Notification_model->get_notifications('push_notifications', 'teacher');
        $user_notif_common = $this->Notification_model->get_notifications('push_notifications');
        $total_count = count($user_notif_user) + count($user_notif_common);
        return $total_count;*/
        $user_id =   $this->session->userdata('login_user_id');
        $this->load->model("Notification_model");
        $data = $this->Notification_model->get_notifications_new('1', 'T', $user_id);
        $total_count = count($data);
        return $total_count;
    }

    public function overall_class_details($class_id = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        if ($class_id == '') {
            $page_data['class_id'] = $this->Class_model->get_first_class_id();
        } else {
            $page_data['class_id'] = $class_id;
        }
        $page_data['teachers'] = $this->Class_model->get_teachers_by_class($page_data['class_id']);
        $page_data['class_name'] = get_data_generic_fun('class', 'name', array('class_id' => $page_data['class_id']), 'result_arr');
        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $page_data['syllabus'] = get_data_generic_fun('academic_syllabus', '*', array('class_id' => $page_data['class_id'], 'year' => $running_year));
        $page_data['books'] = get_data_generic_fun('book', '*', array('class_id' => $page_data['class_id']));
        $page_data['study_info'] = get_data_generic_fun('document', '*', array('class_id' => $page_data['class_id']));
        $page_data['classes'] = $this->Class_model->get_data_by_cols('*', array(), 'result_array', array('name_numeric' => 'ORDER BY', 'name' => 'ASC'));
        $page_data['page_title'] = get_phrase('overall_details');
        $page_data['page_name'] = 'class_details';
        $this->load->view('backend/index', $page_data);
    }

    /*     * ********MANAGING ASSIGNMENTS***************** */

    public function manage_assignment($class_id = '', $section_id = '', $subject_id = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $classes = $this->Subject_model->get_classes_by_teacher($this->session->userdata('teacher_id'));
        $page_data['selected_subject'] = $subject_id;
        $page_data['selected_section'] = $section_id;
        $page_data['selected_class'] = $class_id;

        $page_data['classes'] = $classes;
        $page_data['page_title'] = get_phrase('manage_assignment');
        $page_data['page_name'] = 'manage_assignment';
        $this->load->view('backend/index', $page_data);
    }

    public function assignment_selector() {
        $page_data = $this->get_page_data_var();
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');
        $subject_id = $this->input->post('subject_id');
        $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
        $students = $this->Student_model->getstudents_assignments($class_id, $section_id, $running_year);
        redirect(base_url() . 'index.php?teacher/manage_assignment_view/' . $class_id . '/' . $section_id . '/' . $subject_id . '/' . $running_year, 'refresh');
    }

    public function manage_assignment_view($class_id = '', $section_id = '', $subject_id) {

        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $teacher_id = $this->session->userdata('teacher_id');
        $page_data['class_id'] = $class_id;
        $classes = $this->Subject_model->get_classes_by_teacher($this->session->userdata('teacher_id'));
        $page_data['class_name'] = $this->Class_model->get_class_record(array('class_id' => $class_id), "name");
        $page_data['class_name_cc'] = $page_data['class_name'];
        $page_data['section_name'] = $this->Class_model->get_section_record(array('section_id' => $section_id), "name");
        $page_data['subject_id'] = $subject_id;
        $page_data['subjects'] = $this->Subject_model->get_data_by_cols("*", array('class_id' => $page_data['class_id'], 'subject_id' => $page_data['subject_id']));
        $page_data['sub_name'] = $page_data['subjects'][0]->name;
        $page_data['sec_name'] = $page_data['section_name'];
        $page_data['page_name'] = 'manage_assignment_view';
        $page_data['section_id'] = $section_id;
        $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
        $page_data['students'] = $this->Student_model->getstudents_assignments($class_id, $section_id, $running_year);
        $page_data['page_title'] = get_phrase('manage_assignment_of_class') . ' ' . $page_data['class_name_cc'] . ' : ' . get_phrase('section') . ' ' . $page_data['sec_name'] . ' : ' . get_phrase('subject') . ' ' . $page_data['sub_name'];

        $page_data['classes'] = $classes;

        $this->load->view('backend/index', $page_data);
    }

    public function allot_assignment($create = '', $student_id = '', $subject_new_id = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $error = '';
        $sucess = '';
        $this->load->model("Student_assignments_model");
//        if(!empty($student_id)){
//            $page_data['student_name']          =       get_data_generic_fun('student','name, lname',array('student_id'=>$student_id, 'result_arr'));
//            $page_data['stu_name']              =       $page_data['student_name'][0]->name." ".$page_data['student_name'][0]->lname;  
//        }        
        $teacher_id = $this->session->userdata('login_user_id');
        $page_data['subject_id'] = $subject_new_id;
        if ($create == 'create') {
            $this->form_validation->set_rules('title', 'Title', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');
            $this->form_validation->set_rules('date_of_creation', 'Date Creation', 'required');
            $this->form_validation->set_rules('date_of_submission', 'Submission Date', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('flash_message_error', validation_errors());
                redirect(base_url() . 'index.php?teacher/allot_assignment/create');
            } else {
                $stu_id = $this->input->post('student_id');
                $array = explode(',', $stu_id);

                foreach ($array as $student_id) {
                    $classArr = $this->Student_model->get_class_id_by_student($student_id);
                    if (!empty($classArr)) {
                        $class_id = $classArr[0]['class_id'];
                    }
                    $assignment_data['student_id'] = $student_id;
                    $assignment_data['class_id'] = $class_id;
                    $assignment_data['teacher_id'] = $teacher_id;
                    $assignment_data['subject_id'] = $subject_new_id;
                    $assignment_data['assignment_topic'] = $this->input->post('title');
                    $assignment_data['assignment_description'] = $this->input->post('description');
                    $assignment_data['assigned_date'] = date('Y-m-d H:i', strtotime($this->input->post('date_of_creation')));
                    $assignment_data['submission_date'] = date('Y-m-d H:i', strtotime($this->input->post('date_of_submission')));
                    $assignment_data['file_name'] = str_replace(' ', '_', trim(addslashes($_FILES["file_name"]["name"])));
//                    pre($assignment_data); die;
                    if (!empty($assignment_data['file_name'])) {
                        $allowed_types = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'image/jpeg', 'image/png', 'image/jpg', 'image/jpeg', 'text/plain', 'application/pdf', 'application/msword');
                        if (in_array($_FILES['file_name']['type'], $allowed_types)) {
                            $assignment_data['file_name'] = str_replace(' ', '_', trim(addslashes($_FILES["file_name"]["name"])));
                            $assignment_data['file_type'] = $_FILES["file_name"]["type"];
                        } else {
                            $this->session->set_flashdata('flash_message_error', 'Sorry, File extension is not supported');
                            redirect(base_url() . 'index.php?teacher/manage_assignment', 'refresh');
                        }
                    }
                    //pre($assignment_data); die();
                    if ($this->Student_assignments_model->save_assignments($assignment_data)) {
                        move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/assignments/" . $assignment_data['file_name']);
                        $sucess = 1;
                    } else {
                        $this->session->set_flashdata('flash_message_error', get_phrase('assignment_not_succesfull'));
                        redirect(base_url() . 'index.php?teacher/manage_assignment', 'refresh');
                    }
                }
                if ($sucess == 1) {
//                    echo "assignment=".$assignment_data['file_name'] ;die;
                    $this->session->set_flashdata('flash_message', get_phrase('assignment_added'));
                    redirect(base_url() . 'index.php?teacher/manage_assignment', 'refresh');
                }
            }
        } else if ($create == 'add') {
            $subject_id = $student_id;
            $stu_id = array('assigment' => $this->input->post('allot_assigment[]'));
            if (!empty($stu_id)) {
                $valu = implode(",", $stu_id['assigment']);
            } else {
                $valu = '';
            }
            $page_data['subject_id'] = $subject_id;
            $page_data['student_id'] = $valu;
        }
        $page_data['page_title'] = get_phrase('manage_assignment');
        $page_data['page_name'] = 'allot_assignment';
        $this->load->view('backend/index', $page_data);
    }

    public function verify_assignment() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $classes = $this->Subject_model->get_classes_by_teacher($this->session->userdata('teacher_id'));
        $page_data['teacher_id'] = $this->session->userdata('login_user_id');
        //$page_data['assignment_details']        =       
        $page_data['page_title'] = get_phrase('check_&_verify_assignments');
        $page_data['page_name'] = 'verify_assignment';
        $page_data['classes'] = $classes;
        $this->load->view('backend/index', $page_data);
    }

    function get_assignment_topic() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $class_id = $this->input->post('class_id');
        $subject_id = $this->input->post('subject_id');
        $teacher_id = $this->session->userdata('login_user_id');

        $where = array('class_id' => $class_id, 'subject_id' => $subject_id, 'teacher_id' => $teacher_id);

        $result = $this->Student_assignments_model->getAssignmentTopic($where);

        echo '<option>Select Topic</option>';
        foreach ($result as $det) {
            echo '<option value="' . $det['assignment_id'] . '">' . $det['assignment_topic'] . '</option>';
        }
    }

    function review_feedback() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model("Faculty_feedback_model");
        $param2 = $this->session->userdata('teacher_id');
        $feed_back = get_data_generic_fun('faculty_feedback', '*', array('teacher_id' => $param2), 'result_arr', array('date_created' => 'DESC'));
        if (!empty($feed_back)) {
            $rating = $this->Faculty_feedback_model->get_overall_rating($param2);
            $mark = $rating->over_all_rating;
            $count = $rating->count;
            $page_data['over_all_rating'] = round(($mark / ($count * 5)) * 100);
        }
        $page_data['feed_backs'] = $feed_back;
        $page_data['page_title'] = get_phrase('feedback_review');
        $page_data['page_name'] = 'review_feedback';
        $this->load->view('backend/index', $page_data);
    }

    public function todays_topics($param1 = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model("Subject_model");
        $this->load->model("Crud_model");
        if ($param1 == 'create') {
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('class_id', 'Class', 'required');
            $this->form_validation->set_rules('section_id', 'Section', 'required');
            $this->form_validation->set_rules('subject_id', 'Subject', 'required');
            if ($this->form_validation->run() == TRUE) {
                $save_topic['title'] = $this->input->post('title');
                $save_topic['description'] = $this->input->post('description');
                $save_topic['class_id'] = $this->input->post('class_id');
                $save_topic['section_id'] = $this->input->post('section_id');
                $save_topic['subject_id'] = $this->input->post('subject_id');
                $save_topic['teacher_id'] = $this->session->userdata('teacher_id');
                $save_topic['created_date'] = date("Y-m-d");
                $this->Crud_model->add_todaytopic($save_topic);
                $this->session->set_flashdata('flash_message', get_phrase('details_added_successfully!!'));
                redirect(base_url() . 'index.php?teacher/todays_topics');
            } else {
                $this->session->set_flashdata('flash_message', validation_errors());
                redirect(base_url() . 'index.php?teacher/todays_topics', 'refresh');
            }
        }

        $page_data['classes_data'] = $this->Crud_model->get_classes_by_teacher($this->session->userdata('teacher_id'));

        $page_data['classes'] = $this->Subject_model->get_classes_by_teacher($this->session->userdata('teacher_id'));
        $page_data['page_name'] = 'todays_topics';
        $page_data['page_title'] = get_phrase('topics_covered_today');
        $this->load->view('backend/index', $page_data);
    }

    function my_profile() {
        $page_data = $this->get_page_data_var();
        $page_data['page_title'] = get_phrase('my_profile');
        $page_data['page_name'] = 'my_profile';
        $this->load->view('backend/index', $page_data);
    }

    public function send_notices($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model("Section_model");
        $this->load->model("Class_model");
        $this->load->model("Setting_model");
        $teacher_id = $this->session->userdata('teacher_id');
        $page_data['teacher_class'] = $this->Section_model->get_class_deatils_by_teacher($teacher_id);
        $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
        /*$page_data['classes'] = $this->Class_model->get_class_array();
        if (!empty($page_data['classes'])) {
            foreach ($page_data['classes'] as $val) {
                $page_data['class_id'] = $val['class_id'];
            }
        }

        if ($param1 == 'get_sections') {
            $page_data['sections'] = $this->Section_model->get_data_generic_fun('*', array('teacher_id' => $teacher_id, 'class_id' => $param2), 'result_arr');
        }

        if ($param1 == 'get_students') {
            $page_data['students'] = $this->Student_model->getstudents_section($param2, $running_year, $param3);
        }

        if ($param1 == 'create') {
            $data['sender_id'] = $teacher_id;
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $parent_id = $this->input->post('parent_id');
            $student_id = $this->input->post('student_id');
            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
            $data['notice_title'] = $this->input->post('notice_title');
            $data['notice'] = $this->input->post('notice');
            $data['sender_type'] = 'Teacher';
            $r = $class_id;
            $rs = explode('/', $r);
            $s = $section_id;
            $sec = explode('/', $s);
            if (!empty($parent_id) && (!empty($student_id))) {
                $data['class_id'] = $rs[7];
                $data['parent_id'] = implode(",", $parent_id);
                $data['student_id'] = implode(",", $student_id);
                $this->Notice_board_model->add($data);

                send_school_notification('event_notice', $data['notice'], '', '', array('user_type' => 'parent', 'user_id' => $data['parent_id']), $data['class_id']);

                send_school_notification('event_notice', $data['notice'], '', '', array('user_type' => 'student', 'user_id' => $data['student_id']), $data['class_id']);
            }
            if (empty($parent_id)) {
                $data['class_id'] = $rs[7];
                $data['parent_id'] = " ";
                $data['student_id'] = implode(",", $student_id);
                $this->Notice_board_model->add($data);

                send_school_notification('event_notice', $data['notice'], '', '', array('user_type' => 'student', 'user_id' => $data['student_id'], $data['class_id']));
            }
            if (empty($student_id)) {
                $data['class_id'] = $rs[7];
                $data['parent_id'] = implode(",", $parent_id);
                $data['student_id'] = " ";
                $this->Notice_board_model->add($data);

                send_school_notification('event_notice', $data['notice'], '', '', array('user_type' => 'parent', 'user_id' => $data['parent_id']), $data['class_id']);
            }

            $this->session->set_flashdata('flash_message', get_phrase('message_sent'));
            redirect(base_url() . 'index.php?teacher/noticeboard/', 'refresh');
        }
        $page_data['section_uri'] = $this->uri->segment('5');
        if (!empty($page_data['section_uri'])) {
            $page_data['section_all'] = get_data_generic_fun('section', '*', array('section_id' => $page_data['section_uri']), 'result_array');
        }
        $page_data['class_uri'] = $this->uri->segment('4');*/

        $school_id = '';
             if(($this->session->userdata('school_id'))) {
                 $school_id = $this->session->userdata('school_id');
             }

             if ($param1 == 'send') {
                 //pre($this->input->post());die;
                 $parent_reciever = $this->input->post('parent_reciever');
                 $student_reciever = $this->input->post('student_reciever');

                 $total_sms_send_user = (count($parent_reciever) + count($student_reciever));

                 /*if($_SERVER['HTTP_HOST']=='localhost'){
                     $DB2 = $this->load->database('sharad_db', TRUE);
                 }else{
                     $rootPass="6syDmECEyqLneAULy2NYtbSLpCqy727M";
                     $dsn1 = 'mysqli://root:'.$rootPass.'@0.0.0.0/sharad';
                     $DB2 = $this->load->database($dsn1, true);
                 }

                 $DB2->where(array('school_id'=>$school_id));
                 $available_sms = $DB2->get('allocate_sms')->row()->notification_sms;

                 if($available_sms < $total_sms_send_user){
                     echo 'no_sms_pack';die;
                 }*/                 

                 if (count($parent_reciever)) {
                     foreach ($parent_reciever as $parent) {
                         $exp_par = explode('_', $parent);
                         $ParentDetails = $this->Parent_model->get_parent_details_by_id($exp_par[0]);

                         $data = array();
                         $ParentName = ucfirst($ParentDetails->father_name) . ' ' . ucfirst($ParentDetails->father_mname) . ' ' . ucfirst($ParentDetails->father_lname);

                         $data['notice_title'] = $this->input->post('parent_notice_title');
                         $data['message'] = $this->input->post('parent_message');
                         $data['receiver_type'] = 'P';
                         $data['class_id'] = $exp_par[1];
                         $data['receiver_id'] = $exp_par[0];
                         $data['receiver_full_name'] = $ParentName;
                         $data['receiver_mobile_no'] = $ParentDetails->cell_phone;
                         $data['receiver_email'] = $ParentDetails->email;
                         $data['sender_type'] = $this->session->userdata('u_type');
                         $data['sender_id'] = $this->session->userdata('login_user_id');
                         $data['later_schedule_time'] = $this->input->post('set_date_time');
                         $data['device_token'] = $ParentDetails->device_token;
                         $data['school_id'] = $school_id;
                         $data['db_store'] = 'yes';

                         if($data['later_schedule_time']==''){
                             $data['message_schedule_status'] = '1'; 
                         }

                         $message = array();
                         $message['sms_message'] = $data['message'];
                         $message['subject'] = $data['notice_title'];
                         $message['messagge_body'] = $data['message'];
                         $message['to_name'] = ucwords($ParentName);
                         $ReceiverPhone = ($ParentDetails->cell_phone != '') ? $ParentDetails->cell_phone : (($ParentDetails->mother_mobile != '') ? $ParentDetails->mother_mobile : (($ParentDetails->home_phone != '') ? $ParentDetails->home_phone : $ParentDetails->work_phone));
                         $ReceiverEmail = ($ParentDetails->email != '') ? $ParentDetails->email : $ParentDetails->mother_email != '';

                         send_school_notification_new('custom_message_teacher', $message, $ReceiverPhone, $ReceiverEmail, $data, '', 'notification_sms');
                     }
                 }

                 if (count($student_reciever)) {
                    foreach ($student_reciever as $student) {
                        $exp_stu = explode('_', $student);
                        $StudentDetails = $this->Student_model->get_student_details_by_id($exp_stu[0]);

                        $data1 = array();
                        $StudentName = ucfirst($StudentDetails->name) . ' ' . ucfirst($StudentDetails->mname) . ' ' . ucfirst($StudentDetails->lname);

                        $data1['notice_title'] = $this->input->post('student_notice_title');
                        $data1['message'] = $this->input->post('student_message');
                        $data1['receiver_type'] = 'S';
                        $data1['class_id'] = $exp_stu[1];
                        $data1['receiver_id'] = $exp_stu[0];
                        $data1['receiver_full_name'] = $StudentName;
                        $data1['receiver_mobile_no'] = $StudentDetails->phone;
                        $data1['receiver_email'] = $StudentDetails->email;
                        $data1['sender_type'] = $this->session->userdata('u_type');
                        $data1['sender_id'] = $this->session->userdata('login_user_id');
                        $data1['later_schedule_time'] = $this->input->post('set_date_time1');
                        $data1['device_token'] = $StudentDetails->device_token;
                        $data1['school_id'] = $school_id;
                        $data1['db_store'] = 'yes';

                        if($data1['later_schedule_time']==''){
                            $data1['message_schedule_status'] = '1'; 
                        }

                        $message = array();
                        $message['sms_message'] = $data1['message'];
                        $message['subject'] = $data1['notice_title'];
                        $message['messagge_body'] = $data1['message'];
                        $message['to_name'] = ucwords($StudentName);
                        $ReceiverPhone = $StudentDetails->phone;
                        $ReceiverEmail = $StudentDetails->email;

                        send_school_notification_new('custom_message_teacher', $message, $ReceiverPhone, $ReceiverEmail, $data1, '', 'notification_sms');
                    }
                }                 
             }else{
                $page_data['page_title'] = get_phrase('send_notices');
                $page_data['page_name'] = 'send_notices';
                $this->load->view('backend/index', $page_data);
            }
    }

    function create_custom_message() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');

        $parents = array();
        $students = array();
        $i = $j = $k = 0;

        $receiver = $this->input->post('receiver_type');
        $class_id = $this->input->post('class_id');
        $page_data['receiver_type'] = $receiver;
        $page_data['class_id'] = $class_id;

        if (count($class_id) && count($receiver)) {
            $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
            foreach ($class_id as $class) {
                $cls_id = $class;

                foreach ($receiver as $recv) {
                    $ReceiverFlag = $recv;
                    if ($ReceiverFlag == '1') {
                        $ReceiverDetails = $this->Parent_model->getall_active_parents($cls_id, $running_year);

                        if (count($ReceiverDetails)) {
                            foreach ($ReceiverDetails as $ReceivePerson) {
                                $ReceiverPhone = $ReceivePerson['cell_phone'];
                                $ReceiverEmail = $ReceivePerson['parent_email'];
                                $ReceiverId = $ReceivePerson['parent_id'];

                                $ReceiverFullname = ucfirst($ReceivePerson['father_name']) . ' ' . ucfirst($ReceivePerson['father_mname']) . ' ' . ucfirst($ReceivePerson['father_lname']);
                                if (($ReceiverPhone != '') && ($ReceiverEmail != '')) {
                                    $parents[$i]['parent_phone'] = $ReceiverPhone;
                                    $parents[$i]['parent_email'] = $ReceiverEmail;
                                    $parents[$i]['parent_fullname'] = $ReceiverFullname;
                                    $parents[$i]['parent_id'] = $ReceiverId;
                                    $parents[$i]['class_id'] = $cls_id;
                                    $i++;
                                }
                            }
                        }
                    } else if ($ReceiverFlag == '2') {
                        $ReceiverDetails = $this->Student_model->getall_active_students($cls_id, $running_year);

                        if (count($ReceiverDetails)) {
                            foreach ($ReceiverDetails as $ReceivePerson) {
                                $ReceiverPhone = $ReceivePerson['phone'];
                                $ReceiverEmail = $ReceivePerson['email'];
                                $ReceiverId = $ReceivePerson['student_id'];

                                $ReceiverFullname = ucfirst($ReceivePerson['stdent_fname']) . ' ' . ucfirst($ReceivePerson['mname']) . ' ' . ucfirst($ReceivePerson['lname']);

                                if (($ReceiverPhone != '') && ($ReceiverEmail != '')) {
                                    $students[$j]['student_phone'] = $ReceiverPhone;
                                    $students[$j]['student_email'] = $ReceiverEmail;
                                    $students[$j]['student_fullname'] = $ReceiverFullname;
                                    $students[$j]['student_id'] = $ReceiverId;
                                    $students[$j]['class_id'] = $cls_id;
                                    $j++;
                                }
                            }
                        }
                    }
                }
            }
        }

        $page_data['parents'] = $parents;

        if(count($parents)){
            $AllParents = unique_multidim_array($parents,'parent_id');
            $page_data['parents'] = $AllParents;       
        }

        $page_data['students'] = $students;
        
        $page_data['page_title'] = get_phrase('custom_message');
        $page_data['page_name'] = 'create_mobile_message';
        $this->load->view('backend/teacher/create_mobile_message', $page_data);
        //$this->load->view('backend/index', $page_data);
    }

    //This is for help menu/page in navigation
    function help() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $page_data['page_title'] = get_phrase('help');
        $page_data['page_name'] = 'help';
        $this->load->view('backend/index', $page_data);
    }

    /*     * ************-------------COMPLETE STUDENT PROFILE ------------------***** */

    function student_profile($student_id = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model("Dormitory_model");
        $this->load->model("Transport_model");
        $this->load->model("Section_model");
        $this->load->model("Student_model");
        $page_data = $this->get_page_data_var();
        $section_id = '';
        $page_data['student_personal_info'] = $this->Student_model->get_student_details($student_id);
        $class_id = $page_data['student_personal_info']->class_id;
        $section_id = $page_data['student_personal_info']->section_id;

        $page_data['parents'] = $this->Parent_model->get_parents_array();

        $this->config->load('country_list', true);
        $country_name = $this->config->item('countries', 'country_list');
        $page_data['countries'] = $country_name;
        $page_data['dormitories'] = $this->Dormitory_model->get_dormitory_array();
        //*********** progress report ************
        $year = $this->globalSettingsSMSDataArr[1]->description;
        $runningYr = $this->Setting_model->get_year();
        if (!empty($section_id)) {
            $this->load->model("Subject_model");
            $page_data['subjects'] = $this->Subject_model->get_subject_array(array('section_id' => $section_id));
        } else {
            $page_data['subjects'] = "";
        }
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['student_id'] = $student_id;

        /*         * ******** MANAGE TRANSPORT / VEHICLES / ROUTES******************* */
        $page_data['transports'] = $this->Transport_model->get_transport_details($student_id);
        /*         * ********* VIEW Dormitory Information ********* */
        $this->load->model('hostel_registration_model');
        $page_data['student_infoh'] = $this->hostel_registration_model->get_student_info_parents($student_id);

        /*         * ******** MEDICAL RECORD ****** */
        $this->load->model("Medical_events_model");
        $student_medical_history = $this->Medical_events_model->get_data_generic_fun('*', array('user_id' => $student_id), 'result_arr');
        $count_arr = count($student_medical_history);
        $page_data['count_arr'] = $count_arr;
        $page_data['medical_records'] = $student_medical_history;

        /*         * ***** LIBARARY INFORMATION ************* */
        $this->load->model("Crud_model");
        //$data['user_type'] = "Student";
        $data['member_id'] = $page_data['student_personal_info']->card_id;
        $page_data['issue_log'] = $this->Book_model->get_books_issue_records_from_circulation("circulation", $data, "*");


        /*         * ************ATENDANCE RECORD INFORMATION ************ */


        $date = date('m');
        $month = explode("0", $date);
        $page_data['month'] = $month[1];
        $page_data['section_id'] = $page_data['student_personal_info']->section_id;
        $page_data['class_id'] = $page_data['student_personal_info']->class_id;
        $page_data['class_name'] = $page_data['student_personal_info']->class_name;
        $page_data['section_name'] = $page_data['student_personal_info']->section_name;

        /*         * ********************  STUDENT MARKSHEET **************** */
        /* $this->load->model("Class_model");
          $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
          $class_id = $this->Student_model->get_enroll_record(array('student_id' => $student_id, 'year' => $running_year), "class_id");
          $student_name = $this->Student_model->get_student_record(array('student_id' => $student_id), "name");
          $class_name = $this->Class_model->get_class_record(array('class_id' => $class_id), "name");
         */

        $class_name_data = $this->Class_model->get_data_by_id($page_data['class_id'], 'name');
        $page_data['class_name'] = $class_name_data[0]->name;

        $section_name_data = $this->Section_model->get_data_by_id($page_data['section_id'], 'name');
        $page_data['section_name'] = $section_name_data[0]->name;

        $rData = '';

        for ($d = 1; $d <= 7; $d++) {
            if ($d == 1)
                $day = 'sunday';
            else if ($d == 2)
                $day = 'monday';
            else if ($d == 3)
                $day = 'tuesday';
            else if ($d == 4)
                $day = 'wednesday';
            else if ($d == 5)
                $day = 'thursday';
            else if ($d == 6)
                $day = 'friday';
            else if ($d == 7)
                $day = 'saturday';

            $rData .= '<tr class="gradeA"><td width="100">' . strtoupper($day) . '</td><td>';

            $sortArr = array('time_start' => 'asc');
            $routines = $this->Class_routine_model->get_data_by_cols('', array('day' => $day, 'class_id' => $page_data['class_id'], 'section_id' => $page_data['section_id'], 'year' => $runningYr), 'result_array', $sortArr);
            foreach ($routines as $row2) {

                if ($row2['time_start_min'] == 0 && $row2['time_end_min'] == 0)
                    $timeStr = '(' . $row2['time_start'] . '-' . $row2['time_end'] . ')';
                if ($row2['time_start_min'] != 0 || $row2['time_end_min'] != 0)
                    $timeStr = '(' . $row2['time_start'] . ':' . $row2['time_start_min'] . '-' . $row2['time_end'] . ':' . $row2['time_end_min'] . ')';
                $subName = $this->Crud_model->get_subject_name_by_id($row2['subject_id']);
                $teacher = get_data_generic_fun('subject', 'teacher_id', array('subject_id' => $row2['subject_id']), 'result_array');

                $rData .= '<div class="btn-group"><button class="btn btn-default dropdown-toggle" data-toggle="dropdown">' . $subName . ' ';

                foreach ($teacher as $value) {
                    $teacher_name = get_data_generic_fun('teacher', 'name', array('teacher_id' => $value['teacher_id']), 'result_array');
                    $name = array_shift($teacher_name);
                    $rData .= array_shift($name);
                }

                $rData .= $timeStr;
                $rData .= '</button></div>';
            }
        }

        $reportData = '';
        foreach ($page_data['subjects'] as $subject) {
            $reports = $this->Progress_model->get_progress_report_data(array('subject_id' => $subject['subject_id'], 'student_id' => $student_id), 'progress_id', 'DESC');

            $reportData .= '<section id="subject_' . $subject['subject_id'] . '">';
            if (!empty($reports)) {
                $reportData .= '<table class="custom_table table display" cellspacing="0" width="100%" id="example23">
                           <thead>
                               <tr>
                                   <th width="15%"><div>' . get_phrase('teacher') . '</div></th>
                                   <th><div>' . get_phrase('rating') . '</div></th>
                                   <th><div>' . get_phrase('comments') . '</div></th>
                                   <th><div>' . get_phrase('date') . '</div></th>
                               </tr>
                           </thead>
                           <tbody>';
                foreach ($reports as $report):
                    $teacher_data = $this->Teacher_model->get_data_by_cols('name', array('teacher_id' => $report['teacher_id']), 'result_array');
                    $reportData .= '<tr><td>' . $teacher_data[0]['name'] . '</td><td>';
                    for ($i = 0; $i <= $report['rate']; $i++) {
                        $reportData .= '<img onclick="javascript:rating(' . $i . ',\'student' . $student_id . '\')" name="student' . $student_id . '-' . $i . '" src=" ' . base_url() . 'uploads/rate' . $i . '.png" alt="Mountain View" >';
                    }
                    for ($i = $report['rate'] + 1; $i < 5; $i++) {
                        $reportData .= '<img onclick="javascript:rating(' . $i . ',\'student' . $student_id . '\')" name="student' . $student_id . '-' . $i . '" src=" ' . base_url() . 'assets/images/Blank_star.png" alt="star View" >';
                    }
                    $reportData .= '</td>';
                    $reportData .= '<td>' . $report['comment'] . '</td><td>' . $report['timestamp'] . '</td></tr>';
                endforeach;
                $reportData .= '</tbody></table>';
            } else {
                $reportData .= '<table class="custom_table table display" cellspacing="0" width="100%">
                         <tbody>
                             <tr>No Data Available</tr>
                         </tbody>
                         </table>';
            }
            $reportData .= '</section>';
        }

        // Attendance Data
        $attData = '';
        $adata = array();
        $status = 0;
        $year1 = explode('-', $runningYr);

        $total_days = 0;
        for ($k = 1; $k <= $page_data['month']; $k++) {
            $present = 0;
            $days = cal_days_in_month(CAL_GREGORIAN, $k, $year1[0]);
            $total_days = $days;
            for ($i = 1; $i <= $days; $i++) {
                $timestamp = strtotime($i . '-' . $k . '-' . $year1[0]);
                $attendance = $this->Attendance_model->get_data_by_cols_groupby('', array('section_id' => $page_data['section_id'], 'class_id' => $page_data['class_id'], 'year' => $year, 'timestamp' => $timestamp, 'student_id' => $student_id), 'result_array', '', '', 'timestamp');

                $status = "";
                foreach ($attendance as $row1):
                    $month_dummy = date('j', $row1['timestamp']);
                    if ($i == $month_dummy) {
                        $status = $row1['status'];
                    }
                    if ($status == 1) {
                        $present = $present + 1;
                    } else if ($status == 2) {
                        
                    } else {
                        
                    }
                endforeach;
            }
            $attData .= '<tr>';
            $attendance_percentege = $present / $total_days * 100;
            $attData .= '<td><b>';
            $attData .= date("F", mktime(0, 0, 0, $k, 1)) . '</b></td><td>' . $total_days . '</td><td>' . round($attendance_percentege, 2) . '%</td></tr>';
        }

        $exams = $this->Crud_model->get_exams();
        $marks = '';
        $exam_types = array("FA1", "FA2", "SA1", "FA3", "FA4", "SA2");
        $m = 0;
        $marksData = array();
        foreach ($exams as $row2) {
            $marksData[$m]['marks'] = $row2;
            $subjects = $this->Subject_model->get_data_by_cols('', array('class_id' => $page_data['class_id'], 'year' => $runningYr), 'result_array');

            $k = 0;
            foreach ($subjects as $row3) {
                if (!in_array(strtoupper($row2['name']), $exam_types)) {
                    $obtained_mark_query = $this->Mark_model->get_c_year_mark_obtained_by_subject_exam_class($row3['subject_id'], $row2['exam_id'], $page_data['class_id'], $student_id, $runningYr);

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

                    $highestMark = $this->Crud_model->get_highest_marks($row2['exam_id'], $page_data['class_id'], $row3['subject_id']);
                    $marksData[$m]['marks']['subject'][$k]['highest_mark'] = $highestMark;

                    $tot_subjects_data = $this->Subject_model->get_data_by_cols('', array('class_id' => $page_data['class_id'], 'year' => $runningYr), 'result_array');
                    $marksData[$m]['marks']['subject'][$k]['tot_subjects'] = count($tot_subjects_data);
                }

                if (in_array(strtoupper($row2['name']), $exam_types)) {
                    foreach ($exam_types as $examType) {
                        if ($examType == 'FA1' || $examType == 'FA2' || $examType == 'FA3' || $examType == 'FA4') {
                            $examType1 = 'FA';
                        } else {
                            $examType1 = 'SA';
                        }
                        $examData = $this->Exam_model->get_data_by_cols('', array('UPPER(name)' => $examType), 'result_array');
                        if (count($examData) > 0) {
                            $exam_id = $examData->row()->exam_id;
                            $obtained_mark_query = $this->Mark_model->get_c_year_mark_obtained_by_subject_exam_class($row3['subject_id'], $exam_id, $page_data['class_id'], $student_id, $runningYr);

                            $marksData[$m]['marks']['subject'][$k] = $row3;
                            $s = 0;
                            if ($obtained_mark_query > 0) {
                                foreach ($obtained_mark_query as $row4) {
                                    $marksData[$m]['marks']['subject'][$k]['obtained'][$s] = $row4;

                                    if ($row4['mark_obtained'] >= 0 || $row4['mark_obtained'] != '') {
                                        $marksData[$m]['marks']['subject'][$k]['obtained'][$s]['grade'] = $this->Crud_model->get_grade_new($row5['mark_obtained'], $examType1);
                                    }
                                    $s++;
                                }
                            }

                            $highestMark = $this->Crud_model->get_highest_marks($row2['exam_id'], $page_data['class_id'], $row3['subject_id']);
                            $marksData[$m]['marks']['subject'][$k]['highest_mark'] = $highestMark;

                            $tot_subjects_data = $this->Subject_model->get_data_by_cols('', array('class_id' => $page_data['class_id'], 'year' => $runningYr), 'result_array');
                            $marksData[$m]['marks']['subject'][$k]['tot_subjects'] = count($tot_subjects_data);
                        }
                    }
                }

                $k++;
            }
            $m++;
        }

        $page_data['student_info'] = $this->Crud_model->get_student_info($student_id);

        $page_data['marks_data'] = $marksData;
        $page_data['attendance_report'] = $attData;
        $page_data['report_data'] = $reportData;
        $page_data['routine_data'] = $rData;
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['page_name'] = 'student_profile';
        $page_data['page_title'] = get_phrase('student_profile');
        $this->load->view('backend/index', $page_data);
    }

    function all_student_list($param1 = '', $param2 = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $page_data['search_text'] = '';

        if (($param1 == 'search') && ($param2 != '')) {
            $page_data['search_text'] = $param2;
        }

        $page_data['page_name'] = 'all_student';
        $page_data['page_title'] = get_phrase('teacher_list');
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
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

    function report_term($param1 = '', $param2 = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $this->load->model('Report_term_model');
//        $page_data= $this->get_page_data_var();
        if ($param1 == 'create') {
            $page_data['name'] = $this->input->post('term');
            $page_data['running_year'] = $this->globalSettingsRunningYear;
            $id = $this->Report_term_model->save_term($page_data);
            $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?teacher/report_term/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $page_data['name'] = $this->input->post('name');
            $this->Report_term_model->update_term($page_data, array('term_id' => $param2));
            $this->session->set_flashdata('flash_message', get_phrase('data_updated_successfully'));
            redirect(base_url() . 'index.php?teacher/report_term/', 'refresh');
        }
        if ($param1 == 'delete') {
            $this->Report_term_model->deleteterm($param2);
            $this->session->set_flashdata('flash_message', get_phrase('deleted_successfully'));
            redirect(base_url() . 'index.php?teacher/report_term/', 'refresh');
        }
        $page_data = $this->get_page_data_var();
        $page_data['term_list'] = $this->Report_term_model->get_list();
        $page_data['page_name'] = 'report_term';
        $page_data['page_title'] = get_phrase('report_term');
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    /*
     * home works
     */

    public function home_works($class_id = '', $section_id = '', $subject_id = '', $delete_id = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $homework_done = '';
        $this->load->model('Homeworks_model');
        $teacher_id = $this->session->userdata('teacher_id');
        if ($class_id && $section_id) {
            $condition = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'subject_id' => $subject_id,
                'teacher_id' => $teacher_id
            );
            $home_works = $this->Homeworks_model->get_all_data('', $condition);
            $homework_done = $this->Homeworks_model->get_student_homework_done($class_id, $section_id);

            $section_list = $this->Subject_model->get_subjects($class_id, $teacher_id);
            $subject_list = $this->Subject_model->get_subject_array(array('section_id' => $section_id, 'teacher_id' => $teacher_id));

            $page_data['section_list'] = $section_list;
            $page_data['subject_list'] = $subject_list;

            $page_data['teacher_home_works'] = $home_works;
            $page_data['sel_class_id'] = $class_id;
            $page_data['sel_section_id'] = $section_id;
            $page_data['sel_subject_id'] = $subject_id;
        }

        $tea_classes = $data['classes'] = $this->Subject_model->get_classes_by_teacher($teacher_id);


        $home_work_types = $this->Homeworks_model->get_all_data('home_work_types', array());
        $page_data['homework_types'] = $home_work_types;
        $page_data['homework_done'] = $homework_done;
        $page_data['classes'] = $tea_classes;

        $page_data['page_name'] = 'home_work';
        $page_data['page_title'] = get_phrase('homeworks');
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        if (!empty($delete_id)) {
            $delete = $this->Homeworks_model->delete_homework($delete_id);
            if (isset($delete)) {
                $this->session->set_flashdata('flash_message', get_phrase('homework_deleted_successfully'));
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('deletion_failed_try_again!!'));
            }
            redirect(base_url() . "index.php?teacher/home_works/$class_id/$section_id/$subject_id", 'refresh');
        }
        $this->load->view('backend/index', $page_data);
    }

    public function update_homework($homework_id) {
        $arr = array();
        $teacher_id = $this->session->userdata('teacher_id');
        $arr['marks'] = $this->input->post('marks');
        $this->load->model("Homeworks_model");
        $this->Homeworks_model->update_homework_marks($homework_id, $arr);
        $tea_classes = $data['classes'] = $this->Subject_model->get_classes_by_teacher($teacher_id);
        //$section_list                       =   $this->Subject_model->get_subjects($class_id,$teacher_id);
        //$subject_list                       =   $this->Subject_model->get_subject_array(array('section_id'=>$section_id , 'teacher_id'=>$teacher_id));
        $page_data['classes'] = $tea_classes;
        //$page_data['section_list']          =   $section_list;
        //$page_data['subject_list']          =   $subject_list;
        $page_data['page_name'] = 'home_work';
        $page_data['page_title'] = get_phrase('home_works');
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    public function home_works_actions($action = '', $home_work_id = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $this->load->model('Homeworks_model');
        $page_data = $this->get_page_data_var();

        $teacher_id = $this->session->userdata('teacher_id');

        if ($action == 'create') {
            $input_data = $this->input->post();

            $hw_class_id = $input_data['hw_class_id'];
            $hw_section_id = $input_data['hw_section_id'];
            $hw_subject_id = $input_data['hw_subject_id'];
            $homework_type = $input_data['homework_type'];
            $name = $input_data['name'];
            $hw_description = $input_data['hw_description'];
            $duration = $input_data['duration'];
            $attachments = '';
            $start_date = date('Y-m-d', strtotime($input_data['start_date']));
            $end_date = date('Y-m-d', strtotime($input_data['end_date']));
            //pre($_FILES['file_name']); die;
            if (!empty($input_data['file_name'])) {
                $allowed_types = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'image/jpeg', 'image/png', 'image/jpg', 'image/jpeg', 'text/plain', 'application/pdf', 'application/msword','image/*');
                if (in_array($_FILES['file_name']['type'], $allowed_types)) {
                    $data['hw_attachment'] = str_replace(' ', '_', trim(addslashes($_FILES["file_name"]["name"])));
                    //$data['file_type'] = $_FILES["file_name"]["type"];
                } else {
                    $this->session->set_flashdata('flash_message_error', 'Sorry, File extension is not supported');
                    redirect(base_url() . 'index.php?teacher/home_works/' . $hw_class_id . '/' . $hw_section_id . '/' . $hw_subject_id, 'refresh');
                }
            }
                   $data = array(
                        'hw_description' => $hw_description,
                        'hw_name' => $name,
                        'class_id' => $hw_class_id,
                        'section_id' => $hw_section_id,
                        'subject_id' => $hw_subject_id,
                        'teacher_id' => $teacher_id,
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'created_by' => $teacher_id,
                        'duration' => $duration,
                        'status' => 1
                    );
                    
            

            $insert = $this->Homeworks_model->add_data($data);
            if ($insert) 
            {
                move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/homework/" . $data['hw_attachment']);
                $this->session->set_flashdata('flash_message', get_phrase('New home work added successfully.'));
                redirect(base_url() . 'index.php?teacher/home_works/' . $hw_class_id . '/' . $hw_section_id . '/' . $hw_subject_id, 'refresh');
            } else 
              {
                $this->session->set_flashdata('flash_message_error', validation_errors());
                redirect(base_url() . 'index.php?teacher/home_works/' . $hw_class_id . '/' . $hw_section_id . '/' . $hw_subject_id, 'refresh');
              }
        }
        $tea_classes = $this->Subject_model->get_classes_by_teacher($teacher_id);
        $page_data['classes'] = $tea_classes;

        $page_data['page_name'] = 'home_work';
        $page_data['page_title'] = get_phrase('home_works');
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    function online_exam_report($class_id = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $this->load->model('Online_exam_model');
        $this->load->model('Online_exam_answers_model');
        $this->load->model('Question_model');
        $page_data = $this->get_page_data_var();
        $running_year = $this->Setting_model->get_year();
        $teacher_id = $this->session->userdata('teacher_id');
        $this->load->model('class_model');
        $class = $this->class_model->get_class_name_by_subject($teacher_id);
        if ($class_id == '') {
            if (!empty($class)) {
                $class_id = $class[0]['class_id'];
            }
        }
        $page_data['classes'] = $class;
        $this->load->model('Student_online_exam_attempt_model');
        $online_exam = $this->Online_exam_model->get_exam_data_class_id_student_login($class_id);
        foreach ($online_exam as $exam) {
            $student_total = $this->Online_exam_answers_model->get_total_teacher_login($exam['id']);
            $total_time = $this->Student_online_exam_attempt_model->get_total_time_teacher_login($exam['id']);
            if (!empty($student_total[0]['result'])) {
                $percent[]['result'] = $student_total[0]['result'];
            } else if ($student_total[0]['result'] == "0") {
                $percent[]['result'] = "0";
            } else {
                $percent[]['result'] = "Exam not attempted";
            }
            if (!empty($total_time[0]['time_taken'])) {
                $total_time_taken[]['time_taken'] = $total_time[0]['time_taken'];
            } else {
                $total_time_taken[]['time_taken'] = "Exam not attempted";
            }
        }
//        pre($total_time_taken);exit;
        $i = 0;
        $newArray = array();
        foreach ($online_exam as $value) {
            $newArray[$i] = array_merge($value, $percent[$i], $total_time_taken[$i]);
            $i++;
        }
        //pre($newArray);exit;
        $page_data['details'] = $newArray;
        $page_data['page_name'] = 'online_exam_report';
        $page_data['page_title'] = get_phrase('online_exam_report');
        $page_data['class_id'] = $class_id;
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->view('backend/index', $page_data);
    }

    function automatic_timetable_teacher_priority() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data = $this->get_page_data_var();
        $teacherId = $this->session->userdata('login_user_id');

        $this->load->model("Teacher_model");

        $teacher_priority_list = $this->Teacher_model->show_teacher_priority($this->globalSettingsRunningYear, $teacherId);
        $teacher_missing_class_priority_list = $this->Teacher_model->show_missing_class_in_priority($this->globalSettingsRunningYear, $teacherId);
        $page_data['running_year'] = $this->globalSettingsRunningYear;
        $page_data['teacher_priority_list'] = $teacher_priority_list;
        $page_data['teacher_missing_class_priority_list'] = $teacher_missing_class_priority_list;
        $page_data['page_name'] = 'automatic_timetable_teacher_priority';
        $page_data['page_title'] = get_phrase('teacher_priority_setting');
        $option_str = "<option value=''>" . get_phrase('select') . "</option>";
        $page_data['class_option'] = $option_str;
        if ($teacherId != "") {
            $this->load->model("Section_model");
            $teacherArr = $this->Section_model->get_class_deatils_by_teacher($teacherId);
            foreach ($teacherArr AS $k) {
                $option_str .= '<option value="' . $k['class_id'] . '">' . $k['class'] . '</option>';
            }
            $page_data['class_option'] = $option_str;
        }
        $page_data['teacherId'] = $teacherId;
        $this->load->view('backend/index', $page_data);
    }

    function automatic_timetable_add_teacher_priority() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $teacherId = $this->session->userdata('login_user_id');
        $year = $this->globalSettingsRunningYear;
        $class_id = $this->input->post('class_id', TRUE);
        $subject_id = $this->input->post('subject_id', TRUE);
        $priority = $this->input->post('subject_priority', TRUE);
        $sql = "SELECT COUNT(1) c FROM teacher_preference WHERE teacher_id=$teacherId AND class_id=$class_id and subject_id=$subject_id AND year='$year'";
        $query = $this->db->query($sql);

        $exists = $query->result_array()[0]['c'];
        if ($exists == '0') { // it doesn't exist
            $sql = "INSERT INTO teacher_preference(teacher_id, class_id, subject_id, priority, year) VALUES ($teacherId, $class_id, $subject_id, $priority, '$year')";
            $this->db->query($sql);
            //  echo "I";
        } else {
            //  echo $sql;
            $sql = "UPDATE teacher_preference SET priority = $priority WHERE teacher_id=$teacherId AND class_id=$class_id AND subject_id=$subject_id AND year='$year'";
            $this->db->query($sql);
            //  echo "U";
        }
        //$teacherId
        $this->session->set_flashdata('flash_message', get_phrase('teacher_priority_added_successfully'));
        redirect(base_url() . 'index.php?teacher/automatic_timetable_teacher_priority/' . $teacherId, 'refresh');
    }

    function delete_automatic_timetable_add_teacher_priority($teacher_preference_id) {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $this->load->model('Teacher_model');
        $teacher_preference_details = $this->Teacher_model->get_teacher_preference_details($teacher_preference_id);
        $this->Teacher_model->delete_class_in_priority($teacher_preference_id);
        $this->session->set_flashdata('flash_message', get_phrase('teacher_priority_deleted_successfully'));
        redirect(base_url() . 'index.php?teacher/automatic_timetable_teacher_priority/' . $teacher_preference_details[0]['teacher_id'], 'refresh');
    }

    /* Marks Report */

    function marks_report() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'marks_report';
        $page_data['page_title'] = get_phrase('exam_marks_report');
        $page_data['total_notif_num'] = $this->get_no_of_notication();

        $this->load->model('Exam_model');
        $page_data['exams'] = $this->Exam_model->get_data_generic_fun('*', array(), 'result_array');
        $page_data['classes'] = $this->Crud_model->get_classes_by_teacher($this->session->userdata('teacher_id'));
        $this->load->view('backend/index', $page_data);
    }

    function marks_report_selector() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $data['exam_id'] = $this->input->post('exam_id');
        $data['class_id'] = $this->input->post('class_id');
        $data['section_id'] = $this->input->post('section_id');
        $data['subject_id'] = $this->input->post('subject_id');
        $data['year'] = $this->Setting_model->get_year();

        $students = $this->Enroll_model->get_data_by_cols('', array('class_id' => $data['class_id'], 'section_id' => $data['section_id'], 'year' => $data['year']), 'result_array');

        foreach ($students as $row) {
            $rs = $this->Mark_model->get_data_by_cols('', array('student_id' => $row['student_id'], 'exam_id' => $data['exam_id'], 'subject_id' => $data['subject_id']), 'result_array');
            if (count($rs) == 0) {
                $data['student_id'] = $row['student_id'];
                $this->Mark_model->save($data);
            }
        }
        redirect(base_url() . 'index.php?teacher/marks_report_view/' . $data['exam_id'] . '/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['subject_id'], 'refresh');
    }

    function marks_report_view($exam_id = '', $class_id = '', $section_id = '', $subject_id = '') {

        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $page_data['exam_id'] = $exam_id;
        $page_data['class_id'] = $class_id;
        $page_data['subject_id'] = $subject_id;
        $page_data['section_id'] = $section_id;
        $page_data['page_name'] = 'marks_report_view';
        $page_data['page_title'] = get_phrase('manage_exam_marks');
        $page_data['total_notif_num'] = $this->get_no_of_notication();
        $this->load->model('Exam_model');

        $page_data['exams'] = $this->Exam_model->get_data_generic_fun('*', array(), 'result_array');
        $page_data['classes'] = get_data_generic_fun('class', '*', array(), 'result_array');
        $page_data['sections'] = $this->Section_model->get_data_by_cols('', array('class_id' => $class_id));
        $page_data['subjects'] = $this->Subject_model->get_data_by_cols('', array('class_id' => $class_id, 'year' => $running_year));

        $examData = array();
        $examData = $this->Exam_model->get_data_by_cols('', array('exam_id' => $exam_id));
        $page_data['exam_name'] = @$examData[0]->name;
        $classData = $this->Class_model->get_data_by_cols('', array('class_id' => $class_id));
        $page_data['class_name'] = @$classData[0]->name;
        $sectionData = $this->Section_model->get_data_by_cols('', array('section_id' => $section_id));
        $page_data['section_name'] = @$sectionData[0]->name;
        $subjectData = $this->Subject_model->get_data_by_cols('', array('subject_id' => $subject_id));
        $page_data['subject_name'] = @$subjectData[0]->name;

        $page_data['marks_of_students'] = $this->Exam_model->get_marks_of_students($exam_id, $class_id, $section_id, $subject_id, $running_year);

        $this->load->view('backend/index', $page_data);
    }

    /*     * ***************End***************** */

    public function online_polls($poll_id = '') { //die($poll_id);
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $this->load->model("Onlinepoll_model");
        $this->load->model("Class_model");

        $page_data['page_name'] = 'online_polls';
        $page_data['page_title'] = get_phrase('online_polls');
        $teacher_id = $this->session->userdata('teacher_id');

        //$children_of_parent = $this->Student_model->get_data_by_cols('*', array('teacher_id' => $teacher_id), 'result_array'); 
        $allowed_class_ids = '';
        $section_ids = '';
        //die("3644")
        $i = 0;
        if ($teacher_id != '') {
            //$student_id         =   $action;
            $class_det = $this->Teacher_model->get_class_id_by_teacher((int) $teacher_id);
            //pre($class_det);
            if (!empty($class_det)) {
                foreach ($class_det AS $k => $v) {
                    $allowed_class_ids = ($allowed_class_ids != '' ? $allowed_class_ids . "," . $v['class_id'] : $v['class_id']);
                }
            }
            //pre($allowed_class_ids);
            $section_id = $this->Teacher_model->get_section_id_by_teacher((int) $teacher_id);
            //pre($section_id);
            if (!empty($section_id)) {
                foreach ($section_id AS $k => $v) {
                    $section_ids = ($section_ids != '' ? $section_ids . "," . $v['section_id'] : $v['section_id']);
                }
            }
            //pre($section_ids);
        } else {
            die("redirect");
            //redirect(base_url());
        }
        //die("kk");
        /* else {
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
          } */

        $allowed_class_ids = explode(',', $allowed_class_ids);

        $online_polls = $this->Onlinepoll_model->getOninePolls();
        //pre($online_polls);die;
        $online_poll_list = $online_polls;
        //echo '$action : '.$action;die;
        foreach ($online_polls as $key => $poll) {
            //echo '$action : '.$action;
            //pre($poll);
            //check parent already polled and unset
            $polled_teachers = explode(",", $poll['teacher_ids']);
            //pre($polled_parents);
            if (in_array($teacher_id, $polled_teachers)) { //pre('unset parent poll');
                unset($online_poll_list[$key]);
                continue;
            }


            if ($poll['classes'] != 0) {
                $class_ids = explode(',', $poll['classes']);
                $class_found = 0;
                foreach ($allowed_class_ids as $class_id) {
                    if (in_array($class_id, $class_ids)) {
                        $class_found = 1;
                    }
                }
                if ($class_found == 0) {
                    unset($online_poll_list[$key]);
                }
            }

            $answer = $this->Onlinepoll_model->getOnlinpollAnswer(array('poll_id' => $poll['poll_id']));
            //pre($answer); //die;
            if (!$answer)
                $answer = array();

            $online_poll_list[$key]['answer_det'] = $answer;
            $total_poll = $this->Onlinepoll_model->getPollCount($poll['poll_id']);
            $online_poll_list[$key]['total_poll'] = $total_poll[0]->total_poll;
            //pre($online_poll_list);//die;
            //pre("JJJJJ");
        }
        //pre($online_poll_list);die;
        //die($action);
        if ($poll_id == 'polled') {
            $this->session->set_flashdata('flash_message', get_phrase('vote_submitted'));
            redirect(base_url() . 'index.php?teacher/online_polls/', 'refresh');
        }
        //pre($online_poll_list);die;
        $page_data['online_polls'] = $online_poll_list;
        $this->load->view('backend/index', $page_data);
    }

    function certificates(){
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
       $this->load->model('Teacher_certificate_model');
        $page_data                  =   array();
        $page_data                  =   $this->get_page_data_var();
        $teacher_id = $this->session->userdata('teacher_id');
        $page_data['teacher_id'] = $teacher_id;
        $page_data['page_name'] = 'view_certificate';
        $page_data['page_title'] = get_phrase('student_certificate_list');
        $condition = array('teacher_id' => $teacher_id);
        $sortArr = array('certificate_id' => 'desc');
        $page_data['certificate_list'] = $this->Teacher_certificate_model->get_data_by_cols('*', $condition, 'result_type', $sortArr);
        $this->load->view('backend/index', $page_data);
    }
    
  function teacher_template1($param1 = '', $param2 = '', $param3 = '') {
   if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['certificate_design'] = "";
    if ($param1 == 'download') {
        $this->load->model('Teacher_certificate_model');
        $page_data['certificate_detail'] = $this->Teacher_certificate_model->get_certificate_record($param2,$param3,'1');
    } else {
        $page_data['certificate_design'] = "true";
    }
    $page_data['page_title'] = get_phrase('template1');
    $page_data['page_name'] = 'teacher_template1';
    $this->load->view('backend/index', $page_data);
}

function teacher_template2($param1 = '', $param2 = '', $param3 = '') {
    if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['certificate_design'] = "";
    if ($param1 == 'download') {
        $this->load->model('Teacher_certificate_model');
        $page_data['certificate_detail'] = $this->Teacher_certificate_model->get_certificate_record($param2,$param3,'2');
    } else {
        $page_data['certificate_design'] = "true";
    }
    $page_data['page_title'] = get_phrase('template2');
    $page_data['page_name'] = 'teacher_template2';
    $this->load->view('backend/index', $page_data);
}

function teacher_template3($param1 = '', $param2 = '', $param3 = '') {
   if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['certificate_design'] = "";
    if ($param1 == 'download') {
        $this->load->model('Teacher_certificate_model');
        $page_data['certificate_detail'] = $this->Teacher_certificate_model->get_certificate_record($param2,$param3,'3');
    } else {
        $page_data['certificate_design'] = "true";
    }
    $page_data['page_title'] = get_phrase('template3');
    $page_data['page_name'] = 'teacher_template3';
    $this->load->view('backend/index', $page_data);
}

function teacher_template4($param1 = '', $param2 = '', $param3 = '') {
  if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
    $page_data = $this->get_page_data_var();
    $page_data['certificate_design'] = "";
    if ($param1 == 'download') {
        $this->load->model('Teacher_certificate_model');
        $page_data['certificate_detail'] = $this->Teacher_certificate_model->get_certificate_record($param2,$param3,'4');
    } else {
        $page_data['certificate_design'] = "true";
    }
    $page_data['page_title'] = get_phrase('template4');
    $page_data['page_name'] = 'teacher_template4';
    $this->load->view('backend/index', $page_data);
}

function experince_certificate(){
    if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
     $page_data = $this->get_page_data_var();
     $teacherId = $this->session->userdata('login_user_id');
     $this->load->model('Experience_certificate_model');
     $this->load->model('Teacher_model');
     $page_data['certificate_detail'] = $this->Experience_certificate_model->get_data_by_id($teacherId);
     $rsTeacherData = $this->Teacher_model->get_teacher_name($teacherId);
    $page_data['teacher_data'] = $rsTeacherData;
     $page_data['page_title'] = get_phrase('Experience_Certificate');
     $page_data['page_name'] = 'exprience_certificate';
     $this->load->view('backend/index', $page_data);
}

function internship_certificate(){
    if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
     $page_data = $this->get_page_data_var();
     $teacherId = $this->session->userdata('login_user_id');
     $this->load->model('Experience_certificate_model');
     $this->load->model('Teacher_model');
     $page_data['certificate_detail'] = $this->Experience_certificate_model->get_internship_certificate_by_id($teacherId);
     $rsTeacherData = $this->Teacher_model->get_teacher_name($teacherId);
     $page_data['teacher_data'] = $rsTeacherData;
     $page_data['page_title'] = get_phrase('internship_Certificate');
     $page_data['page_name'] = 'internship_certificate';
     $this->load->view('backend/index', $page_data);
}

 //student documents by beant kaur
    function documents($param1 = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data = $this->get_page_data_var();
        $param1    = $this->session->userdata('login_user_id');
        $this->load->model('Crud_model');
        $id = $this->uri->segment(3);
        $this->load->model('S3_model');
        $page_data['files'] = $this->S3_model->get_all_files();

        $instance = $this->Crud_model->get_instance_name();
        $page_data['subfiles'] = $this->S3_model->get_file($page_data['files'][1], $instance . '/teacher/' . $param1 . '/');
        $page_data['instance'] = $instance . '/teacher/' . $param1 . '/';
        $page_data['teacher_id'] = $this->session->userdata('login_user_id');
//    echo $page_data['student_id'];die;
        $page_data['page_title'] = get_phrase('teacher_documents');
        $page_data['page_name'] = 'teacher_documents';
//        $studentDetails = $this->Teacher_model->get_data_by_cols('*', array('teacher_id' => $param1), 'result_arr');
//        $pagestudentDetails = _data['student_name'] = $studentDetails[0]['name'];
        $this->load->view('backend/index', $page_data);
    }
    
        function upload_document($param1 = '') {
        $page_data = $this->get_page_data_var();

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
            redirect(base_url() . 'index.php?teacher/documents/' . $param1, 'refresh');
        } else {
            $data = $this->upload->data();
            $instance = $this->Crud_model->get_instance_name();
            $filepath = $instance . '/teacher/' . $param1 . '/' . $data['file_name'];
        
            $this->S3_model->upload($this->upload->data()['full_path'], $filepath);
            //exit;
            $this->session->set_flashdata('flash_message', get_phrase('document_uploaded_successfully'));
            redirect(base_url() . 'index.php?teacher/documents/' . $param1, 'refresh');
        }
            
    }
    
    function online_polls_result(){
        $page_data = $this->get_page_data_var();
        $this->load->model("Onlinepoll_model");
        $this->load->model("Class_model");

        $page_data['page_name'] = 'online_polls_result';
        $page_data['page_title'] = get_phrase('online_polls_result');
        $teacher_id = $this->session->userdata('teacher_id');

        //$children_of_parent = $this->Student_model->get_data_by_cols('*', array('teacher_id' => $teacher_id), 'result_array'); 
        $allowed_class_ids = '';
        $section_ids = '';
        //die("3644")
        $i = 0;
        if ($teacher_id != '') {
            //$student_id         =   $action;
            $class_det = $this->Teacher_model->get_class_id_by_teacher((int) $teacher_id);
            //pre($class_det);
            if (!empty($class_det)) {
                foreach ($class_det AS $k => $v) {
                    $allowed_class_ids = ($allowed_class_ids != '' ? $allowed_class_ids . "," . $v['class_id'] : $v['class_id']);
                }
            }
            //pre($allowed_class_ids);
            $section_id = $this->Teacher_model->get_section_id_by_teacher((int) $teacher_id);
            //pre($section_id);
            if (!empty($section_id)) {
                foreach ($section_id AS $k => $v) {
                    $section_ids = ($section_ids != '' ? $section_ids . "," . $v['section_id'] : $v['section_id']);
                }
            }
            //pre($section_ids);
        } else {
            die("redirect");
            //redirect(base_url());
        }
        
        $allowed_class_ids = explode(',', $allowed_class_ids);

        $online_polls = $this->Onlinepoll_model->get_closed_online_polls();
        //pre($online_polls);die;
        $online_poll_list = $online_polls;
        //echo '$action : '.$action;die;
        foreach ($online_polls as $key => $poll) {
            //echo '$action : '.$action;
            //pre($poll);
            //check parent already polled and unset
            $polled_teachers = explode(",", $poll['teacher_ids']);
            //pre($polled_parents);
            if (!in_array($teacher_id, $polled_teachers)) { //pre('unset parent poll');
                unset($online_poll_list[$key]);
                continue;
            }


            if ($poll['classes'] != 0) {
                $class_ids = explode(',', $poll['classes']);
                $class_found = 0;
                foreach ($allowed_class_ids as $class_id) {
                    if (in_array($class_id, $class_ids)) {
                        $class_found = 1;
                    }
                }
                if ($class_found == 0) {
                    unset($online_poll_list[$key]);
                }
            }

            $answer = $this->Onlinepoll_model->getOnlinpollAnswer(array('poll_id' => $poll['poll_id']));
            //pre($answer); //die;
            if (!$answer)
                $answer = array();

            $online_poll_list[$key]['answer_det'] = $answer;
            $total_poll = $this->Onlinepoll_model->getPollCount($poll['poll_id']);
            $online_poll_list[$key]['total_poll'] = $total_poll[0]->total_poll;
            //pre($online_poll_list);//die;
            //pre("JJJJJ");
        }
        //pre($online_poll_list);die;
        //die($action);
        
        //pre($online_poll_list);die;
        $page_data['online_polls'] = $online_poll_list;
        $this->load->view('backend/index', $page_data);
    }

    function big_blue(){
         if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'big_blue';
        $page_data['page_title'] = get_phrase('big_blue');
        $this->load->view('backend/index', $page_data);
    }

    /************************Photo Gallery*******************************/
    function photo_galleries(){
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');

       $this->load->model('Gallery_model');    
       $page_data = $this->get_page_data_var();
       if($this->input->server('REQUEST_METHOD')=='POST'){
           $this->form_validation->set_rules('title', 'Gallery Title', 'trim|required|_unique_field_sch[photo_galleries.title#running_year.'._getYear().']');
           $this->form_validation->set_rules('description', 'Gallery Description', 'trim');
           $this->form_validation->set_error_delimiters('', '');

           if ($this->form_validation->run() == TRUE) {
               $save_data['class_id'] = $this->input->post('class_id');
               $save_data['title'] = $this->input->post('title');
               $save_data['description'] = $this->input->post('description');
               $save_data['running_year'] = _getYear();
               $save_data['school_id'] = _getSchoolid();
               $save_data['created'] = date('Y-m-d H:i:s');
               $save_data['updated'] = date('Y-m-d H:i:s');
               $save_data['created_by_name'] = $this->session->userdata('name');
               $save_data['created_by_type'] = $this->session->userdata('login_type');
               $save_data['created_by_id'] = $this->session->userdata('login_user_id');
               $return = $this->Gallery_model->save_gallery($save_data);

               if($return){
                   $this->session->set_flashdata('flash_message', get_phrase('photo_gallery_successfully_created.'));
                   redirect(base_url() . 'index.php?'.$this->session->userdata('login_type').'/photo_galleries/', 'refresh');
               } else {
                   $this->session->set_flashdata('flash_message_error', get_phrase('invalid_details.'));
               }
           }else{
               $this->session->set_flashdata('flash_message_error', validation_errors());
           }
       } 

        $page_data['page_name'] = 'gallery/photo_galleries';
        $page_data['page_title'] = get_phrase('photo_galleries');
        $classes = $this->db->get_where('class',array('teacher_id'=>$this->session->userdata('login_user_id')))->result();
        //echo '<pre>';print_r( $classes);exit;
        $whr_in = array('PG.class_id'=>array(0));
        foreach( $classes as $cls){
            $whr_in['PG.class_id'][] = $cls->class_id;
        }
        $page_data['records'] = $this->Gallery_model->get_galleries(array(),'PG.id DESC',$whr_in);
        $page_data['classes'] = $this->Gallery_model->get_classes();
        //echo '<pre>';print_r($page_data['records'] );exit;
        $this->load->view('backend/index', $page_data);
    }
    

    function photo_gallery_edit($id=false){
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');

        $this->load->model('Gallery_model');    
        $page_data = $this->get_page_data_var();
        $page_data['record'] = $rec = $this->Gallery_model->get_gallery_record($id);
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $is_unique_title = strtolower($_POST['title'])==strtolower($rec->title)?'':'|_unique_field_sch[photo_galleries.title#running_year.'._getYear().']';
            $this->form_validation->set_rules('title', 'Gallery Title', 'trim|required'.$is_unique_title);
            $this->form_validation->set_rules('description', 'Gallery Description', 'trim');
            $this->form_validation->set_error_delimiters('', '');
            
            if ($this->form_validation->run() !== FALSE) {
                $save_data['id'] = $id;
                $save_data['class_id'] = $this->input->post('class_id');
                $save_data['title'] = $this->input->post('title');
                $save_data['description'] = $this->input->post('description');
                $save_data['updated'] = date('Y-m-d H:i:s');
                $return = $this->Gallery_model->save_gallery($save_data);
                    
                if($return){
                    $this->session->set_flashdata('flash_message', get_phrase('photo_gallery_successfully_updated.'));
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('invalid_details.'));
                }
            }else {
                $this->session->set_flashdata('flash_message_error', validation_errors());
            }
            redirect(base_url() . 'index.php?'.$this->session->userdata('login_type').'/photo_galleries/', 'refresh');
        } 
        $page_data['classes'] = $this->Gallery_model->get_classes();
        $this->load->view('backend/'.$this->session->userdata('login_type').'/gallery/modal_edit_gallery',$page_data);
    }

    function photo_gallery_delete($id=false){
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');

        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->load->model('Gallery_model','S3_model');    
            $flag = $this->Gallery_model->gallery_delete(array('id'=>$id));
            if($flag){
                $images = $this->Gallery_model->get_gallery_images(array('gallery_id'=>$id));
                foreach($images as $img){
                    $this->Gallery_model->delete_gallery_img($img->id);
                }
            }
            echo json_encode(array('status'=>'success','msg'=>'Photo Gallery Deleted!'));exit;
        }
    }

    //Gallery Images
    function photo_gallery_images($gallery_id=false){
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');

        $this->load->model(array('Gallery_model','S3_model'));
        $page_data = $this->get_page_data_var();
        $instance = $this->Crud_model->get_instance_name();
        $page_data['bucket'] = $bucket = 'https://'.S3_model::$bucket.'.s3.amazonaws.com/';
        $page_data['gallery'] = $rec = $this->Gallery_model->get_gallery_record($gallery_id);
        if($this->input->server('REQUEST_METHOD')=='POST'){
            //echo '<pre>';print_r($_FILES);exit; 
            $gallery_path = 'gallery/'.$instance.'/'.$gallery_id.'/';

            $post_images = $_FILES['images'];
            foreach($post_images['tmp_name'] as $i=>$img){
                $imgSize = getimagesize($img);
                $file = $post_images['name'][$i];
                $file_name = substr($file,0,strrpos($file, '.'));
                $img_ext = pathinfo($file, PATHINFO_EXTENSION);
                $img_nw = rand(1000,99999999999999999).time();
                
                //Original
                $m_img_path = $img_nw.'-M.'.$img_ext;
                $s3_m_path = $gallery_path.$m_img_path;
                $this->S3_model->upload($img,$s3_m_path);

                //Resized Image
                $s_img_path = $img_nw.'-S.'.$img_ext;
                $target_path = APPPATH.'../uploads/'.$s_img_path;
                //unlink($target_path);
                
                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = $img;
                $config['new_image'] = $target_path;
                //$config['create_thumb'] = TRUE;
                $config['maintain_ratio'] = TRUE;
                $config['width']         = 300;
                $config['height']       = 300;
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $s3_s_path = $gallery_path.$s_img_path;
                $this->S3_model->upload($target_path,$s3_s_path);
                unlink($target_path);

                $save_img = array('gallery_id'=>$gallery_id,
                                  'title'=>$file_name,
                                  'bucket'=>$bucket,
                                  'thumb'=>$s3_s_path,
                                  'main'=>$s3_m_path,
                                  'size'=>($imgSize[0].'x'.$imgSize[1]),
                                  'created'=>date('Y-m-d H:i:s'),
                                  'updated'=>date('Y-m-d H:i:s'),
                                  'created_by_name' => $this->session->userdata('name'),
                                  'created_by_type' => $this->session->userdata('login_type'),
                                  'created_by_id' => $this->session->userdata('login_user_id'),
                                  'running_year' => _getYear(),
                                  'school_id' => _getSchoolid());
                $this->Gallery_model->save_gallery_image($save_img);
            }

            $this->session->set_flashdata('flash_message', get_phrase('image_uploaded_successfully'));
            redirect('index.php?'.$this->session->userdata('login_type').'/photo_gallery_images/'.$gallery_id, 'refresh');
        }  
        $page_data['page_name'] = 'gallery/images';
        $page_data['page_title'] = get_phrase('photo_galleries_images');
        //$page_data['objects'] = $this->S3_model->get_objects('gallery/'.$instance.'/'.$gallery_id);
        $page_data['images'] = $this->Gallery_model->get_gallery_images(array('gallery_id'=>$gallery_id));  
        //echo '<pre>';print_r($page_data['objects']);exit;
        $this->load->view('backend/index', $page_data);
    }    

    function gallery_img_edit($img_id=false){
        if ($this->session->userdata('teacher_login') != 1)
        redirect(base_url(), 'refresh');

        $this->load->model(array('Gallery_model','S3_model'));
        $page_data = $this->get_page_data_var();
        $instance = $this->Crud_model->get_instance_name();
        $page_data['bucket'] = $bucket = 'https://'.S3_model::$bucket.'.s3.amazonaws.com/';
        $page_data['img'] = $this->Gallery_model->get_gallery_img(array('PI.id'=>$img_id)); 
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $save_data['id'] = $img_id;
            $save_data['title'] = $this->input->post('title');
            $save_data['brief'] = $this->input->post('brief');
            $save_data['updated'] = date('Y-m-d H:i:s');
            $flag = $this->Gallery_model->save_gallery_image($save_data);
            $tags = $this->input->post('tags');
            $this->Gallery_model->save_gallery_tags($tags,$img_id);


            $this->session->set_flashdata('flash_message', get_phrase('image_updated_successfully'));
            redirect('index.php?'.$this->session->userdata('login_type').'/photo_gallery_images/'.$page_data['img']->gallery_id, 'refresh');
        } 
        $page_data['page_name'] = 'gallery/gallery_img_edit';
        $page_data['page_title'] = get_phrase('photo_galleries_images'); 
        $whr = array();
        if($page_data['img']->class_id!=0){
            $whr['E.class_id'] = $page_data['img']->class_id;
        }
        $page_data['students'] = $this->Gallery_model->get_students($whr);
        $page_data['peoples'] = $this->db->get_where('photo_gallery_image_tags',array('image_id'=>$img_id))->result();
        $page_data['faces'] = $this->db->get_where('photo_gallery_image_face_tags',array('image_id'=>$img_id))->result();   
        //echo '<pre>';print_r($page_data['peoples']);exit;
        $this->load->view('backend/index', $page_data);
    }    

    function get_users_by_user_type(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->load->model(array('Gallery_model'));
            $return = array('status'=>'success','html'=>'');
            $type = $this->input->post('type');
            $class_id = $this->input->post('class_id');
            if($type==1){
                $whr = array();
                if($class_id!=0){
                    $whr['E.class_id'] = $class_id;
                }
                $records = $this->Gallery_model->get_students($whr);
                $return['html'] = '<option value="">Select Student</option>';
                foreach($records as $rec){
                    $return['html'] .= '<option value="'.$rec->student_id.'" data-type="S" data-gender="1">'.$rec->name.' '.$rec->lname.'</option>';
                }
            }else if($type==2){
                $records = $this->Gallery_model->get_teachers();
                $return['html'] = '<option value="">Select Teacher</option>';
                foreach($records as $rec){
                    $return['html'] .= '<option value="'.$rec->teacher_id.'" data-type="T" data-gender="1">'.$rec->name.' '.$rec->last_name.'</option>';
                }
            }else if($type==3){
                $whr = array();
                if($class_id!=0){
                    $whr['E.class_id'] = $class_id;
                }
                $records = $this->Gallery_model->get_parents($whr);
                $return['html'] = '<option value="">Select Parent</option>';
                foreach($records as $rec){
                    $return['html'] .= '<option value="'.$rec->parent_id.'" data-type="P" data-gender="1">'.$rec->father_name.' '.$rec->father_lname.'</option>';
                }
            }else if($type==4){
                $whr = array();
                if($class_id!=0){
                    $whr['E.class_id'] = $class_id;
                }
                $records = $this->Gallery_model->get_parents($whr,'P.mother_name ASC');
                $return['html'] = '<option value="">Select Parent</option>';
                foreach($records as $rec){
                    $return['html'] .= '<option value="'.$rec->parent_id.'" data-type="P" data-gender="2">'.$rec->mother_name.' '.$rec->mother_lname.'</option>';
                }
            }
            echo json_encode($return);exit;
        }
    }
    
    function gallery_img_delete($img_id=false){
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');

        $this->load->model(array('Gallery_model','S3_model')); 
        $img = $this->Gallery_model->delete_gallery_img($img_id);
        echo json_encode(array('status'=>'success','msg'=>get_phrase('image_deleted!')));exit;  
        //redirect(base_url('index.php?school_admin/photo_gallery_images/'.$img->gallery_id), 'refresh');
    }
    
     function moodle(){
       if ($this->session->userdata('teacher_login') != 1)
        redirect(base_url(), 'refresh');
       
        $teacher_record = $this->Teacher_model->get_teacher_passcode($this->session->userdata('teacher_id'));
        $passcode =  $teacher_record->passcode; 
        $email =  $teacher_record->email; 
        
        //set POST variables
        $url = "http://52.14.91.109/beta_ag/moodle/login/index.php";

        $fields = array(
            'username' => $email,
            'password' => $passcode
        );

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE );

        //execute post
        $result = curl_exec($ch);
        $page_data = $this->get_page_data_var();
          $page_data['username'] = $email;
          $page_data['password'] = $passcode;
                $page_data['page_name'] = 'moodle';
                $page_data['page_title'] = get_phrase('moodle');
                $this->load->view('backend/index', $page_data);
        curl_close($ch);

    }
    
    function online_ptm(){
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'online_ptm';
        $page_data['page_title'] = get_phrase('online_ptm');
        $this->load->view('backend/index', $page_data);
    }
    
    function e_learning(){
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data = $this->get_page_data_var();
        $page_data['page_name'] = 'e_learning';
        $page_data['page_title'] = get_phrase('e_learning');
        $this->load->view('backend/index', $page_data);
    }
}
