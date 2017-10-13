<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Teacher_api extends REST_Controller {

    function __construct($config = 'rest1') {
        parent::__construct($config);
        $this->globalSettingsSMSDataArr = get_data_generic_fun('settings', 'description', array('condition_type' => 'in', 'condition_in_col' => 'type', 'condition_in_data' => 'location,app_package_name,running_year,system_name,system_email'));
        //pre($this->globalSettingsSMSDataArr);
        $this->globalSettingsLocation = $this->globalSettingsSMSDataArr[3]->description;
        $this->globalSettingsAppPackageName = $this->globalSettingsSMSDataArr[4]->description;
        $this->globalSettingsRunningYear = $this->globalSettingsSMSDataArr[2]->description;
        $this->globalSettingsSystemName = $this->globalSettingsSMSDataArr[0]->description;
        $this->globalSettingsSystemEmail = $this->globalSettingsSMSDataArr[1]->description;
    }

    function teacher_list_post() {
        $teacherId = $this->post("teacher_id");
        if ($teacherId == "") {
            $data['teacherDataArr'] = get_data_generic_fun("teacher", "teacher_id,name,last_name,email,", array(), 'arr');
            success_response_after_post_get($data);
        } else {
            $data['teacherDataArr'] = get_data_generic_fun("teacher", "teacher_id,name,last_name,email,", array("teacher_id" => $teacherId), 'array');
            success_response_after_post_get($data);
        }
    }

    function class_list_post() {
        $classId = $this->post("class_id");
        if ($classId == "") {
            $data['classDataArr'] = get_data_generic_fun("class", "class_id,name", array(), 'arr');
            success_response_after_post_get($data);
        } else {
            $data['classDataArr'] = get_data_generic_fun("class", "class_id,name", array("class_id" => $classId), 'array');
            success_response_after_post_get($data);
        }
    }

    function section_list_post() {

        $classId = $this->post("class_id");
        if ($classId == "") {
            $data['action'] = "fail";
            $data['message'] = "please fill the class Id";
            success_response_after_post_get($data);
        } else {
            $data['sectionDataArr'] = get_data_generic_fun("section", "section_id,name,", array("class_id" => $classId), 'array');
            success_response_after_post_get($data);
        }
    }

    function get_subject_by_class_post() {
        $this->load->model("Subject_model");        
        $classId = $this->post("class_id");
        if ($classId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide class id";
            success_response_after_post_get($data);
        } else {
             $subjectId = $this->post("subject_id");
            if ($subjectId == "") {
                $data['action'] = "fail";
                $data['message'] = "Please provide subject id";
                success_response_after_post_get($data);
            } else {
                $data['subjectDataArr'] = $this->Subject_model->get_subject_by_class_teacher_api($classId,$subjectId);

                success_response_after_post_get($data);
            }
        }
    }
    
    /*------------------APIS for Manage MArks ------------*/
    function exam_list_post() {
        $data['examDataArr'] = get_data_generic_fun("exam", "*", array(), 'array');
        success_response_after_post_get($data);
    }
    
    function get_class_by_teacher_post() { 
        $this->load->model("Subject_model");
        $teacherId = $this->post("teacher_id");
        if ($teacherId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide teacher id";
            success_response_after_post_get($data);
        } else {
            $data['classDataArr'] = $this->Subject_model->get_classes_by_teacher($teacherId);
            success_response_after_post_get($data);
        }
    }
    
    function get_sections_by_teacher_post(){
        $this->load->model("Subject_model");
        $class_id = $this->post("class_id");
        $teacher_id = $this->post("teacher_id");
        if ($class_id == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide class id";
            success_response_after_post_get($data);
        } else if ($teacher_id == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide teacher id";
            success_response_after_post_get($data);
        }else {
            $data['sectionDataArr'] = $this->Subject_model->get_subjects($class_id,$teacher_id);
            success_response_after_post_get($data);
        }
    }
    
    function get_subject_array_post(){
        $this->load->model("Subject_model");
        $section_id = $this->post("section_id");
        $teacher_id = $this->post("teacher_id");
        if ($section_id == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide section id";
            success_response_after_post_get($data);
        }else if ($teacher_id == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide teacher id";
            success_response_after_post_get($data);
        }else {
            $data['subjectDataArr'] = $this->Subject_model->get_subject_array(array('section_id'=>$section_id,'teacher_id'=>$teacher_id));            
            success_response_after_post_get($data);
        }
    }
    
    function manage_mark_post() {
        $this->load->model("Exam_model");
        $examId = $this->post("exam_id");
        $classId = $this->post("class_id");
        $sectionId = $this->post("section_id");
        $subjectId = $this->post("subject_id");
        if ($examId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide exam id";
            success_response_after_post_get($data);
        } else if ($classId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide class id";
            success_response_after_post_get($data);
        } else if ($sectionId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide section id";
            success_response_after_post_get($data);
        } else if ($subjectId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide subject id";
            success_response_after_post_get($data);
        } else {
            $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            $data['marks_of_students'] = $this->Exam_model->get_marks_of_students($examId, $classId, $sectionId, $subjectId, $running_year);
            success_response_after_post_get($data);
        }
    }
    function marks_update_post() {
        $this->load->model("Mark_model");
        $mark_id = $this->post("mark_id");
        $mark_obtained = $this->post("mark_obtained");
        $comment = $this->post("comment");
        $maximum_marks = $this->post('maximum_marks');
        if ($mark_id == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide subject id";
            success_response_after_post_get($data);
        } else if ($mark_obtained == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide mark obtained";
            success_response_after_post_get($data);
        } else if ($comment == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide comment";
            success_response_after_post_get($data);
        } else if ($maximum_marks == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide maximum marks";
            success_response_after_post_get($data);
        }else{
                $obtained_marks = $mark_obtained;
                $comment = $comment; 
                $condition = array('mark_id'=>$mark_id);
                $dataArray = array('mark_obtained' => $obtained_marks, 'comment' => $comment, 'mark_total' => $maximum_marks);
                if($this->Mark_model->update_mark($dataArray, $condition)){
                    $data['message'] = "Marks Updated";
                    success_response_after_post_get($data);
                }
                else{
                    $data['action'] = "fail";
                    $data['message'] = "Couldn't update";
                    success_response_after_post_get($data);
                }
            }
        }
    
    /************************End*************************************/
    
    
    
    

    function student_list_post() {
        $this->load->model('Enroll_model');
        $classId = $this->post("class_id");

        if ($classId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide class id";
            success_response_after_post_get($data);
        } else {
            $data['list_of_students'] = $this->Enroll_model->get_student_list_teacher_api($classId);
            success_response_after_post_get($data);
        }
    }

    function attendance_report_post() {
        $this->load->model('Attendance_model');
        $this->load->model("Setting_model");
        $classId = $this->post("class_id");
        $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
        //echo $classId; exit;
        if ($classId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide class id";
            success_response_after_post_get($data);
        } else {
            $sectionId = $this->post("section_id");
            if ($sectionId == '') {
                $data['action'] = "fail";
                $data['message'] = "Please provide section id";
                success_response_after_post_get($data);
            } else {
                $given_time = $this->post("timestamp");
                //echo $given_time;exit;
                if ($given_time == '') {
                    $data['action'] = "fail";
                    $data['message'] = "Please select timestamp";
                    success_response_after_post_get($data);
                } else {
                    $timestamp = strtotime($given_time);
                    $data['attendancedataArr'] = $this->Attendance_model->get_data_for_attendance_view($classId, $sectionId, $running_year, $timestamp);
                    success_response_after_post_get($data);
                }
            }
        }
    }

    function update_status_attendance_post() {
        $this->load->model("Setting_model");
        $classId = $this->post("class_id");
        // $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
        if ($classId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide class id";
            success_response_after_post_get($data);
        } else {
            $attendance_id = $this->post("attendance_id");
            if ($attendance_id == '') {
                $data['action'] = "fail";
                $data['message'] = "Please select attendance_id";
                success_response_after_post_get($data);
            } else {
                $sectionId = $this->post("section_id");
                if ($sectionId == '') {
                    $data['action'] = "fail";
                    $data['message'] = "Please provide section id";
                    success_response_after_post_get($data);
                } else {
                    $given_time = $this->post("timestamp");
                    if ($given_time == '') {
                        $data['action'] = "fail";
                        $data['message'] = "Please select timestamp";
                        success_response_after_post_get($data);
                    } else {
                        $status = $this->post("status");
                        if ($status == '') {
                            $data['action'] = "fail";
                            $data['message'] = "Please select status";
                            success_response_after_post_get($data);
                        } else {
                            $timestamp = strtotime($given_time);
                            $data['attendance_id'] = $attendance_id;
                            $data['classId'] = $classId;

                            $data['sectionId'] = $sectionId;
                            $data['timestamp'] = $timestamp;

                            $data['status'] = $status;
                            $data = array('status' => $status);
                            $this->db->where('attendance_id', $attendance_id);
                            $this->db->update('attendance', $data);
                        }
                        success_response_after_post_get($data);
                    }
                }
            }
        }
    }

    function exam_report_post() {
        $examId = $this->post("exam_id");
        if ($examId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide exam id";
            success_response_after_post_get($data);
        } else {
            $data['examDataArr'] = get_data_generic_fun("exam", "*", array("exam_id" => $examId), 'array');
            success_response_after_post_get($data);
        }
    }

    function get_progress_report_detailwise_post() {
        $this->load->model("Teacher_model");
        $classId = $this->post("class_id");
        $sectionId = $this->post("section_id");
        $headingId = $this->post("heading_id");
        $studentId = $this->post("student_id");
       
        if ($classId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide class id";
            success_response_after_post_get($data);
        }
        if ($sectionId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide section id";
            success_response_after_post_get($data);
        }

        if ($headingId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide heading id";
            success_response_after_post_get($data);
        }

        if ($studentId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide student id";
            success_response_after_post_get($data);
        }
    else {  
        $data['ReportDataArr'] = $this->Teacher_model->get_progress_report_detail($classId, $sectionId, $headingId,$studentId);
                    success_response_after_post_get($data);
        }
    }
    
        function update_progress_report_detail_post() {
        $this->load->model("Progress_model");
        $teacherId = $this->post("teacher_id");
        $student_id = $this->post("student_id");
        $sub_category_id = $this->post("sub_category_id");
        $ex = $this->post("exceeding_level");
        $exp = $this->post("expected_level");
        $em = $this->post("emerging_level");
        $time_stamp = date('y-m-d');
        $comment = $this->post("comment");        

        if ($teacherId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide teacher id";
            success_response_after_post_get($data);
        }
        if ($student_id == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide student id";
            success_response_after_post_get($data);
        }

        if ($sub_category_id == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide sub category id";
            success_response_after_post_get($data);
        }

        if ($ex == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide exceeding value";
            success_response_after_post_get($data);
        }

        if ($exp == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide expected value";
            success_response_after_post_get($data);
        } 
        if ($em == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide emerging value";
            success_response_after_post_get($data);
        } 
    else {
            $data['teacher_id'] = $teacherId;
            $data['student_id'] = $student_id;
            $data['sub_category_id'] = $sub_category_id ;
            $data['exceeding_level'] = $ex;
            $data['expected_level'] = $exp;
            $data['emerging_level'] = $em;
            $data['time_stamp'] = $time_stamp ;
            $data['comment'] = $comment;
//            pre($data); die;
            $id = $this->Progress_model->save_progress_deatil_api($data);         
            if($id!=''){
            $data['message'] = "Successfully updated";
            }else{
            $data['message'] = "Not Updated";     
            }
                 success_response_after_post_get($data);
            
        }
        
    }
    
    
    function subjectwise_progress_report_post() {
        $this->load->model("Teacher_model");
        $classId = $this->post("class_id");
        if ($classId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide class id";
            success_response_after_post_get($data);
        } else {
            $sectionId = $this->post("section_id");
            if ($sectionId == "") {
                $data['action'] = "fail";
                $data['message'] = "Please provide section id";
                success_response_after_post_get($data);
            } else {

                $subjectId = $this->post("subject_id");
                if ($subjectId == "") {
                    $data['action'] = "fail";
                    $data['message'] = "Please provide subject id";
                    success_response_after_post_get($data);
                } else {
                    $data['ReportDataArr'] = $this->Teacher_model->get_progress_report_by_teacher($classId, $sectionId, $subjectId);
                    success_response_after_post_get($data);
                }
            }
        }
    }

    function update_progress_report_post() {
        //$this->load->model("Progress_model");
        $classId = $this->post("class_id");
        $sectionId = $this->post("section_id");
        $teacherId = $this->post("teacher_id");
        $subjectId = $this->post("subject_id");
       
        $rating = $this->post("rate");
        $com = $this->post("comment");
        
        $timestamp = date('y-m-d');
        $studentId = $this->post("student_id");
        if ($classId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide class id";
            success_response_after_post_get($data);
        }
        if ($sectionId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide section id";
            success_response_after_post_get($data);
        }

        if ($teacherId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide teacher id";
            success_response_after_post_get($data);
        }

        if ($subjectId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide subject id";
            success_response_after_post_get($data);
        }

        if ($rating == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide rating no.";
            success_response_after_post_get($data);
        }

        if ($com == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide comment";
            success_response_after_post_get($data);
        }

        if ($studentId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide student";
            success_response_after_post_get($data);
        }
    else {
            $data['teacher_id'] = $teacherId;
            $data['subject_id'] = $subjectId;
            $data['rate'] = $rating;
            $data['comment'] = $com;
            $data['student_id'] = $studentId;
            $data['timestamp'] = $timestamp;
            $query = "INSERT INTO progress_report
                (teacher_id, subject_id, student_id,rate,comment,timestamp)
                VALUES
                ('$teacherId', '$subjectId', '$studentId','$rating','$com','$timestamp')";
            // echo $query."<br>"; exit();
           if($this->db->query($query)){
               $data['message'] = "Successfully Updated";
           }else{
               $data['message'] = "Update failed";
           }
        }
        success_response_after_post_get($data);
    }

    function class_routine_post() {
        $this->load->model("Class_routine_model");

        $classId = $this->post("class_id");
        if ($classId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide class id";
            success_response_after_post_get($data);
        } else {
            $sectionId = $this->post("section_id");
            if ($sectionId == "") {
                $data['action'] = "fail";
                $data['message'] = "Please provide section id";
                success_response_after_post_get($data);
            } else {


                $data['RoutineDataArr'] = $this->Class_routine_model->weekly_class_routine($classId, $sectionId);
                success_response_after_post_get($data);
            }
        }
    }

    /*****************************API to get class resources**************************/
    function class_resource_teacher_list_post() {
        $this->load->model("Class_model");
        $classId = $this->post("class_id");
        if ($classId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide class id";
            success_response_after_post_get($data);
        } else {
            $data['teacherDataArr'] = $this->Class_model->get_teachers_by_class($classId);
            success_response_after_post_get($data);
        }
    }
    
    function class_syllabus_post() {
        $classId = $this->post("class_id");
        if ($classId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide class id";
            success_response_after_post_get($data);
        } else {
            $running_year            =       $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
            $data['syllabusDataArr'] =       get_data_generic_fun('academic_syllabus','*', array('class_id' => $classId, 'year' => $running_year));
            success_response_after_post_get($data);
        }
    }
    
    function class_study_info_post() {
        $classId = $this->post("class_id");
        if ($classId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide class id";
            success_response_after_post_get($data);
        } else {
            $running_year            =       $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
            $data['syllabusDataArr'] =       get_data_generic_fun('document','*', array('class_id' => $classId));
            success_response_after_post_get($data);
        }
    }
    /*****************************End****************************/
     
    function notifications_post() {
        $this->load->model("Notification_model");
        $notificationType = $this->post("notification_type");
        if ($notificationType == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide notification type";
            success_response_after_post_get($data);
        } else {
            $userType = $this->post("user_type");
            if ($userType == "") {
                $data['action'] = "fail";
                $data['message'] = "Please provide user type";
                success_response_after_post_get($data);
            } else {

                $user_id = $this->post("user_id");
                if ($user_id == "") {
                    $data['action'] = "fail";
                    $data['message'] = "Please provide user id";
                    success_response_after_post_get($data);
                } else {

                    $data['notificationDataArr'] = $this->Notification_model->get_notifications($notificationType, $userType, $user_id);
                    //pre($data);
                    //exit();
                    success_response_after_post_get($data);
                }
            }
        }
    }

    function edit_profile_post() {
        $teacher_id = $this->post("teacher_id");
        if ($teacher_id == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide teacher id";
            success_response_after_post_get($data);
        } else {
            $name = $this->post("name");
            if ($name == "") {
                $data['action'] = "fail";
                $data['message'] = "Please provide name";
                success_response_after_post_get($data);
            } else {

                $last_name = $this->post("last_name");
                if ($last_name == "") {
                    $data['action'] = "fail";
                    $data['message'] = "Please provide last name";
                    success_response_after_post_get($data);
                } else {

                    $teacher_image = $this->post("teacher_image");
                    if ($teacher_image == "") {
                        $data['action'] = "fail";
                        $data['message'] = "Please provide image";
                        success_response_after_post_get($data);
                    } else {

                        $data['teacher_id'] = $teacher_id;
                        $data['name'] = $name;

                        $data['last_name'] = $last_name;
                        // $data['email'] = $email;

                        $data['teacher_image'] = $teacher_image;
                        $data = array('teacher_id' => $teacher_id, 'name' => $name, 'last_name' => $last_name, 'teacher_image' => $teacher_image);
                        $this->db->where('teacher_id', $teacher_id);
                        $this->db->update('teacher', $data);

                        //echo $this->db->query($query);                                 die();
                    }
                    success_response_after_post_get($data);
                }
            }
        }
    }

    function change_passcode_post() {
        $oldpasscode = $this->post("old_passcode");
        $newpasscode = $this->post("new_passcode");
        $teacher_id = $this->post("teacher_id");
        if ($teacher_id == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide teacher id";
            success_response_after_post_get($data);
        }

        if ($oldpasscode == "") {

            //$this->db->update('student', $data);
            $data['action'] = "fail";
            $data['message'] = "Please provide old passcode";
            success_response_after_post_get($data);
        }

        if ($newpasscode == "") {

            //$this->db->update('student', $data);
            $data['action'] = "fail";
            $data['message'] = "Please provide new passcode";
            success_response_after_post_get($data);
        }
        if ($teacher_id != "") {
            //if('old_passcode'=='passcode')
            $data['passcode'] = sta . ($newpasscode);
            $data = array('passcode' => sta . ($newpasscode));
            $this->db->where('teacher_id', $teacher_id);
            $this->db->update('teacher', $data);
            $data1['status'] = "success";
            //echo $this->db->query($query);                 die();

            success_response_after_post_get($data);
        } else {
            $data['status'] = "unsucessful";
        }
    }
    
     function get_class_teacher_post(){
      $teacher_id = $this->post('teacher_id');
        if ($teacher_id == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide teacher id";
            success_response_after_post_get($data);
        } else {
            $data['section_a'] = get_data_generic_fun("class", "class_id,name, teacher_id", array("teacher_id" => $teacher_id), 'array');
            success_response_after_post_get($data);
        }  
    }
    
    
    
    /***********************************API for Parent Teacher Meeting**************************/
    function Ptm_section_list_post() {
        $this->load->model("Section_model");
        $teacherId = $this->post("teacher_id");
        if ($teacherId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide teacher id";
            success_response_after_post_get($data);
        } else {
            $data['sectionDataArr'] = $this->Section_model->get_class_deatils_by_teacher($teacherId);
            success_response_after_post_get($data);
        }
    }
    
    function ptm_exam_list_post() {
        $this->load->model('Exam_model');
        $section_id     =   $this->post("section_id");
        $class_id       =   $this->post("class_id");
        if ($section_id == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide section id";
            success_response_after_post_get($data);
        }else if ($class_id == ""){
            $data['action'] = "fail";
            $data['message'] = "Please provide class id";
            success_response_after_post_get($data);
        }else{
            $exam               =       get_data_generic_fun('parrent_teacher_meeting_date', 'exam_id',array('section_id'=>$section_id, 'class_id'=>$class_id), 'result_arr');
            if(!empty($exam)){
                $data['exam_name']      = $this->Exam_model->get_exam_name_for_ptm($exam);    
                success_response_after_post_get($data);
            }else{
                $data['message'] = "No Exam Assigned";            
            }
        }
    }
    
    function get_student_details_for_ptm_post(){
        $this->load->model("Parent_teacher_meeting_date_model");
        $class_id       =   $this->post('class_id');
        $section_id     =   $this->post('section_id');
        $exam_id        =   $this->post('exam_id');
        if ($class_id == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide class id";
            success_response_after_post_get($data);
        } else if($section_id == ""){
            $data['action'] = "fail";
            $data['message'] = "Please provide section id";
            success_response_after_post_get($data);
        }else if($exam_id == ""){
            $data['action'] = "fail";
            $data['message'] = "Please provide exam id";
            success_response_after_post_get($data);
        }else{
            $running_year       =       get_data_generic_fun('settings','description',array('type' => 'running_year'),'result_arr'); 
            $year               =       $running_year[0]['description']; 
            $data['date']       =       get_data_generic_fun('parrent_teacher_meeting_date','meeting_date',array('class_id' => $class_id, 'section_id' => $section_id, 'exam_id' => $exam_id),'result_arr');
            if(!empty($exam_id)){
                $exam_det                       =   get_data_generic_fun('exam','name',array('exam_id' => $exam_id),'result_arr');
                if(!empty($exam_det)){
                    $data['exam_name']          =   $exam_det[0]['name'];
                    $data['student_details']    =   $this->Parent_teacher_meeting_date_model->get_student_details_for_ptm($class_id, $section_id, $year);
                    success_response_after_post_get($data);
                }
            }
        }
    }
    
    function save_ptm_student_details_post(){
        $this->load->model("Student_model");
        $this->load->model("Parent_teacher_meeting_model");
        $student_id        =   $this->post('student_id');
        $exam_id           =   $this->post('exam_id');
        $time              =   $this->post('time');
        if ($student_id == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide student id";
            success_response_after_post_get($data);
        }else if ($exam_id == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide exam id";
            success_response_after_post_get($data);
        }else if ($time == "") {
            $data['action'] = "fail";
            $data['message'] = "Please select time";
            success_response_after_post_get($data); 
        }else{
            $student_details    =   $this->Student_model->get_student_details($student_id);
            if(!empty($student_details)){
                $class_id  = $student_details->class_id;
                $section_id  = $student_details->section_id; 
                $accepted_time                        =    date('Y-m-d H:i:s');
                $parrent_teacher_meeting_date_id      =    get_data_generic_fun('parrent_teacher_meeting_date','parrent_teacher_meeting_date_id', 
                                                           array('class_id'=>$class_id, 'section_id'=>$section_id), 'result_arr');
                
                if(empty($parrent_teacher_meeting_date_id)){
                    $data['message'] = "Meeting Id not present";
                    success_response_after_post_get($data);
                } else {
                    $meeting_date_id     =    $parrent_teacher_meeting_date_id[0]['parrent_teacher_meeting_date_id'];
                }
                
                $parrent_teacher_meeting_date         =    get_data_generic_fun('parrent_teacher_meeting_date','meeting_date', array('class_id'=>$class_id, 'section_id'=>$section_id), 'result_arr');
                if(!empty($parrent_teacher_meeting_date)){
                    $meeting_date         =    $parrent_teacher_meeting_date[0]['meeting_date'];
                }else{
                    $data['message'] = "Meeting date not assigned";
                    success_response_after_post_get($data);
                }
                
                $dataArray      =   array('student_id' => $student_details->student_id, 
                                          'parrent_id' => $student_details->parent_id, 
                                          'class_id' => $class_id,
                                          'section_id' => $section_id,
                                          'parrent_accepted' => '1',
                                          'accepted_time' =>$accepted_time,
                                          'parrent_teacher_meeting_date_id' => $meeting_date_id,
                                          'parrent_teacher_meeting_date' => $meeting_date,
                                          'exam_id' => $exam_id,
                                          'time' => $time);
                if($this->Parent_teacher_meeting_model->set_parent_teacher_meeting_schedule($dataArray)){
                    $data['message'] = "Sent to Parent";
                    success_response_after_post_get($data);
                }else{
                    $data['message'] = "Error in sending";
                    success_response_after_post_get($data);
                }
            }             
        }
    }
    
    // get class wise heading by beant kaur
    function get_heading_by_class_id_post(){
         $this->load->model("Teacher_model");
        $class_id        =   $this->post('class_id');
         if ($class_id == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide class id";
            success_response_after_post_get($data);
         }else{
                 $data['headingsDataArr'] = $this->Teacher_model->get_heading($class_id);
    success_response_after_post_get($data);
             
         }

    }
    
    function get_studentlist_post(){
        $this->load->model("Enroll_model");
        $class_id        =   $this->post('class_id');
        $section_id        =   $this->post('section_id');
         if ($class_id == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide class id";
            success_response_after_post_get($data);
         }
        else if ($section_id == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide section id";
            success_response_after_post_get($data);
         }
        else{
            $running_year       =       get_data_generic_fun('settings','description',array('type' => 'running_year'),'result_arr'); 
            $year               =       $running_year[0]['description']; 
            $data['studentsDataArr'] = $this->Enroll_model->get_students($class_id,$section_id,$year);
//            
//            pre($data['studentsDataArr']);die;
    success_response_after_post_get($data);
        }
        
    }
    
    /********************************************End*********************************************/

}
