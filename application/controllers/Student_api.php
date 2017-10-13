<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Student_api extends REST_Controller {

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

    function student_noticeboard_post() {
        $this->load->model("Notification_model");
        $data['noticeDataArr'] = $this->Notification_model->getNotices();
        success_response_after_post_get($data);
        //}
    }

    function enroll_info_student_post() {
        $studentId = $this->post("student_id");
        if ($studentId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide student id";
            success_response_after_post_get($data);
        } else {
            $data['enrollDataArr'] = get_data_generic_fun("enroll", "*", array("student_id" => $studentId), 'array');
            success_response_after_post_get($data);
        }
    }

    function study_material_post() {
        $this->load->model("Crud_model");
        $studentId = $this->post("student_id");
        if ($studentId == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide student id";
            success_response_after_post_get($data);
        } else {
            $data['materialDataArr'] = $this->Crud_model->select_study_material_info_for_student_api($studentId);
            success_response_after_post_get($data);
        }
    }

    function view_discussion_forum_post() {
        $this->load->model("Discussion_category_model");
        $data['viewdiscussDataArr'] = $this->Discussion_category_model->get_all_thread();
        success_response_after_post_get($data);
    }

    function create_thread_post() {
        $title = $this->post("title");
        if ($title == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide title";
            success_response_after_post_get($data);
        } else {
            $discussion_topic = $this->post("discussion_topic");
            if ($discussion_topic == "") {
                $data['action'] = "fail";
                $data['message'] = "Please provide discussion topic";
                success_response_after_post_get($data);
            } else {

                $category_id = $this->post("category_id");
                if ($category_id == "") {
                    $data['action'] = "fail";
                    $data['message'] = "Please provide category id";
                    success_response_after_post_get($data);
                } else {
                    $discussion_userid = $this->post("discussion_userid");
                    if ($discussion_userid == "") {
                        $data['action'] = "fail";
                        $data['message'] = "Please provide discussion user id";
                        success_response_after_post_get($data);
                    } else {
                        $discussion_usertype = $this->post("discussion_usertype");
                        if ($discussion_usertype == "") {
                            $data['action'] = "fail";
                            $data['message'] = "Please provide discussion user type";
                            success_response_after_post_get($data);
                        } else {
                            $discussion_username = $this->post("discussion_username");
                            if ($discussion_username == "") {
                                $data['action'] = "fail";
                                $data['message'] = "Please provide discussion user name";
                                success_response_after_post_get($data);
                            } else {
                                //$this->load->model('Progress_model');

                                $data['title'] = $title;
                                $data['discussion_topic'] = $discussion_topic;
                                $data['category_id'] = $category_id;
                                $data['discussion_userid'] = $discussion_userid;
                                $data['discussion_usertype'] = $discussion_usertype;
                                $data['discussion_username'] = $discussion_username;
                                $query1 = "INSERT INTO discussion_thread
                (title,discussion_topic,category_id,discussion_userid,discussion_usertype,discussion_username)
                VALUES
                ('$title','$discussion_topic','$category_id','$discussion_userid','$discussion_usertype','$discussion_username')";
                                //echo $query."<br>";

                                $this->db->query($query1);
                            }
//                            pre($data);
//                            exit;
                            success_response_after_post_get($data);
                        }
                    }
                }
            }
        }
    }

    function view_published_blogs_post() {
        $blog_category_id = $this->post("blog_category_id");

        if ($blog_category_id == "") {
            $data['blogsDataArr'] = get_data_generic_fun("blog", "*", array(), 'arr');
            success_response_after_post_get($data);
        } else {
            $data['blogsDataArr'] = get_data_generic_fun("blog", "*", array("blog_category_id" => $blog_category_id), 'array');
            success_response_after_post_get($data);
        }
    }

    function view_my_blog_post() {

        $this->load->model("Blog_model");


        $blog_author_id = $this->post("blog_author_id");
        if ($blog_author_id == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide blog id";
            success_response_after_post_get($data);
        } else {
            $data['blogsDataArr'] = get_data_generic_fun("blog", "*", array("blog_author_id" => $blog_author_id), 'array');
            success_response_after_post_get($data);
        }
    }

    function create_blogs_post() {
        // $this->load->model("Discussion_category_model");
        $blog_title = $this->post("blog_title");
        if ($blog_title == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide blog title";
            success_response_after_post_get($data);
        } else {
            $blog_information = $this->post("blog_information");
            if ($blog_information == "") {
                $data['action'] = "fail";
                $data['message'] = "Please provide blog information";
                success_response_after_post_get($data);
            } else {

                $blog_author_id = $this->post("blog_author_id");
                if ($blog_author_id == "") {
                    $data['action'] = "fail";
                    $data['message'] = "Please provide blog author id";
                    success_response_after_post_get($data);
                } else {
                    $blog_user_type = $this->post("blog_user_type");
                    if ($blog_user_type == "") {
                        $data['action'] = "fail";
                        $data['message'] = "Please provide blog user type";
                        success_response_after_post_get($data);
                    } else {
                        $blog_user_name = $this->post("blog_user_name");
                        if ($blog_user_name == "") {
                            $data['action'] = "fail";
                            $data['message'] = "Please provide blog user name";
                            success_response_after_post_get($data);
                        } else {
                            $blog_resend_comment = $this->post("blog_resend_comment");
                            if ($blog_resend_comment == "") {
                                $data['action'] = "fail";
                                $data['message'] = "Please provide blog resend comment";
                                success_response_after_post_get($data);
                            } else {
                                $blog_created_time = $this->post("blog_created_time");
                                if ($blog_created_time == "") {
                                    $data['action'] = "fail";
                                    $data['message'] = "Please provide blog created time";
                                    success_response_after_post_get($data);
                                } else {
                                    $blog_category_id = $this->post("blog_category_id");
                                    if ($blog_category_id == "") {
                                        $data['action'] = "fail";
                                        $data['message'] = "Please provide blog category id";
                                        success_response_after_post_get($data);
                                    } else {

                                        $data['blog_title'] = $blog_title;
                                        $data['blog_information'] = $blog_information;
                                        $data['blog_author_id'] = $blog_author_id;
                                        $data['blog_user_type'] = $blog_user_type;
                                        $data['blog_user_name'] = $blog_user_name;
                                        $data['blog_resend_comment'] = $blog_resend_comment;
                                        $data['blog_created_time'] = $blog_created_time;
                                        $data['blog_category_id'] = $blog_category_id;
                                        $query = "INSERT INTO blog
                (blog_title,blog_information,blog_author_id,blog_user_type,blog_user_name,blog_resend_comment,blog_created_time,blog_category_id)
                VALUES
                ('$blog_title','$blog_information','$blog_author_id','$blog_user_type','$blog_user_name','$blog_resend_comment','$blog_created_time','$blog_category_id')";
                                        //echo $query."<br>";

                                        $this->db->query($query);
                                    }
                                    //pre($data);
                                    //exit;
                                    success_response_after_post_get($data);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    function send_new_message_post() {

        $sender = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');

        $message_thread_code = $this->post("message_thread_code");
        if ($message_thread_code == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide message_thread code";
            success_response_after_post_get($data);
        } else {
            $message = $this->post("message");
            if ($message == "") {
                $data['action'] = "fail";
                $data['message'] = "Please provide message";
                success_response_after_post_get($data);
            } else {
                $sender = $this->post("sender");
                if ($sender == "") {
                    $data['action'] = "fail";
                    $data['message'] = "Please provide sender";
                    success_response_after_post_get($data);
                } else {


                    $timestamp = $this->post("timestamp");
                    if ($timestamp == "") {
                        $data['action'] = "fail";
                        $data['message'] = "Please provide timestamp";
                        success_response_after_post_get($data);
                    } else {
                        $data['message_thread_code'] = $message_thread_code;
                        $data['message'] = $message;

                        $data['sender'] = $sender;
                        $data['timestamp'] = $timestamp;
                        $query = "INSERT INTO message
                (message_thread_code,message,sender,timestamp)
                VALUES
                ('$message_thread_code','$message','$sender','$timestamp')";
                        //echo $query."<br>";

                        $this->db->query($query);
                    }
                    //pre($data);
                    //exit;
                    success_response_after_post_get($data);
                }
            }
        }
    }

    function edit_profile_post() {
        // $this->load->model("Student_model");
        $student_id = $this->post("student_id");
        $name = $this->post("name");
        $sex = $this->post("sex");
        $address = $this->post("address");
        $birthday = $this->post("birthday");
        $stud_image = $this->post("stud_image");

        if ($student_id == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide student id";
            success_response_after_post_get($data);
        }

        if ($name == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide name";
            success_response_after_post_get($data);
        }

        if ($birthday == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide birth date";
            success_response_after_post_get($data);
        }

        if ($sex == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide sex";
            success_response_after_post_get($data);
        }

        if ($address == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide address";
            success_response_after_post_get($data);
        }

        if ($stud_image == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide an image";
            success_response_after_post_get($data);
        }

        if ($student_id != "") {
            $data['student_id'] = $student_id;
            $data['name'] = $name;

            $data['birthday'] = $birthday;
            $data['sex'] = $sex;
            $data['address'] = $address;
            $data['stud_image'] = $stud_image;
            $data['status'] = "sucessful";
            $data = array('student_id' => $student_id, 'name' => $name, 'birthday' => $birthday, 'sex' => $sex, 'address' => $address, 'stud_image' => $stud_image);
            $this->db->where('student_id', $student_id);
            $this->db->update('student', $data);
            $data1['status'] = "success";
            // $this->session->set_flashdata('flash_message', get_phrase('sucessfully_updated'));
            //echo "success update"; die;
            success_response_after_post_get($data1);
        } else {
            $data['status'] = "unsucessful";
        }
//          
    }
	
	function edit_profile_picture_post()
	{
		$files = $_FILES['stud_image'];
            
            $this->load->library('upload');
            $config['upload_path']              =   'uploads/student_image/';
            $config['allowed_types']            =   'jpg|png|jpeg';
            $config['remove_spaces']            =   FALSE;            
            $config['file_name'] = $files['name'];
            
            $_FILES['file_name']['name']        =   $files['name'];
            $_FILES['file_name']['type']        =   $files['type'];
            $_FILES['file_name']['tmp_name']    =   $files['tmp_name'];
            $_FILES['file_name']['size']        =   $files['size'];
            $this->upload->initialize($config);
            if($this->upload->do_upload('stud_image')){
                $data['action'] = "success";
				success_response_after_post_get($data);
            }
            else{
                $data['action'] = "fail";
            $data['message'] = "Please send correct image";
            success_response_after_post_get($data);
            }
	}
    
    function change_passcode_post() {
        // $this->load->model("Student_model");
        $student_id = $this->post("student_id");
        if ($student_id == "") {
            $data['action'] = "fail";
            $data['message'] = "Please provide student id";
            success_response_after_post_get($data);
        } else {
            $oldpasscode = $this->post("old_passcode");
            if ($oldpasscode == "") {

                //$this->db->update('student', $data);
                $data['action'] = "fail";
                $data['message'] = "Please provide old passcode";
                success_response_after_post_get($data);
            } else {
                $data['password'] = sha1($password);
                $data = array('password' => sha1($password));
                $this->db->where('student_id', $student_id);
                $this->db->update('student', $data);
                $newpasscode = $this->post("new_passcode");
                if ($newpasscode == "") {

                    //$this->db->update('student', $data);
                    $data['action'] = "fail";
                    $data['message'] = "Please provide new passcode";
                    success_response_after_post_get($data);
                } else {
                    //if('old_passcode'=='passcode')
                    $data['passcode'] = stu.($newpasscode);
                    $data = array('passcode' => stu.($newpasscode));
                    $this->db->where('student_id', $student_id);
                    $this->db->update('student', $data);
                }
                success_response_after_post_get($data);
            }
        }
    }

}
