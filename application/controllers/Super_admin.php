<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Super_admin extends CI_Controller {

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

        $this->load->model('Role_model');
        $this->load->model("Module_model");
        $this->load->model("Link_model");
        $this->load->model("Linkmodule_model");

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

        if ($this->session->userdata('super_admin_login') != 1) {
            redirect(base_url(), 'refresh');
        }
    }

    public function index() {
        if ($this->session->userdata('super_admin_login') == 1)
            $this->dashboard();
    }

    public function dashboard() {
        $page_data = $this->get_page_data_var();
        //pre($page_data);die;
        $page_data['page_name'] = 'dashboard';
        $page_data['page_title'] = get_phrase('super_admin_dashboard');
        $this->load->view('backend/index', $page_data);
    }

    function manage_profile($param1 = '', $param2 = '', $param3 = '') {

        $this->load->model('Admin_model');
        $page_data = $this->get_page_data_var();
        if ($param1 == 'update_profile_info') {
            $data['name'] = $this->input->post('name');
            $data['email'] = $this->input->post('email');
            $file_name = $_FILES['userfile']['name'];

            $types = array('image/jpeg', 'image/gif', 'image/png');
            if ($file_name != '') {

                if (in_array($_FILES['userfile']['type'], $types)) {

                    $ext = explode(".", $file_name);
                    $user_id = $this->session->userdata('school_admin_id');
                    $data['image'] = $user_id . "." . end($ext);
                    if ($this->Admin_model->update_super_admin_profile($data, $user_id)) {
                        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/admin_image/' . $data['image']);
                        $this->session->set_flashdata('flash_message', get_phrase('account_details_updated'));
                    }
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('It may be the wrong filetype. We only allow JPG, GIF, and PNG filetypes!!'));
                    redirect(base_url() . 'index.php?super_admin/manage_profile/', 'refresh');
                }
            } else {
                $data['image'] = $this->input->post('image');
                $user_id = $this->session->userdata('school_admin_id');
                $this->Admin_model->update_profile($data, $user_id);
                redirect(base_url() . 'index.php?super_admin/manage_profile/', 'refresh');
            }
        }

        if ($param1 == 'change_password') {
            $data['password'] = sha1($this->input->post('password'));
            $data['new_password'] = sha1($this->input->post('new_password'));
            $data['confirm_new_password'] = sha1($this->input->post('confirm_new_password'));
            $current_password = $this->Admin_model->get_data_by_cols1('password', array('id' => $this->session->userdata('super_admin_id')), 'result_array');
            $curr_pwsd = $current_password[0]['password'];

            if ($curr_pwsd == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {
                $dataArray = array('password' => $data['new_password'], 'passcode' => 'sad' . $this->input->post('new_password'));
                $this->Admin_model->update_super_admin_password($dataArray, $this->session->userdata('super_admin_id'));
                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('password_mismatch'));
            }
            redirect(base_url() . 'index.php?super_admin/manage_profile/', 'refresh');
        }

        //$page_data['total_notif_num'] = $this->get_no_of_notication();
        $page_data['page_name'] = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data'] = $this->Admin_model->get_data_by_cols1('*', array('id' => $this->session->userdata('super_admin_id')), 'result_array');
        $this->load->view('backend/index', $page_data);
    }

    public function role($param1 = '', $param2 = '') {
        $page_data = $this->get_page_data_var();
        if ($param1 == 'add') {
            $this->load->model('School_model');

            $page_data['page_name'] = 'add_role';
            $page_data['page_title'] = get_phrase('add_role');

            $page_data['school'] = $this->School_model->get_school_array();

            $this->load->view('backend/index', $page_data);

        }else if($param1=='create'){
            $this->form_validation->set_rules('name', 'Role Name', 'trim|required');
            $this->form_validation->set_rules('school_id', 'School Name', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('flash_message_error', validation_errors());
                redirect(base_url() . 'index.php?super_admin/role/add', 'refresh');
            } else {
                $data['name'] = $this->input->post('name');
                $data['school_id'] = $this->input->post('school_id');
                //pre($data);die;
                $id = $this->Role_model->add($data);
                if ($id) {
                    $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
                    redirect(base_url() . 'index.php?super_admin/role', 'refresh');
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('something_missing_wrong'));
                    redirect(base_url() . 'index.php?super_admin/role/add', 'refresh');
                }
            }
        } else if ($param1 == 'update') {
            $this->form_validation->set_rules('school_id', 'School Name', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('flash_message_error', validation_errors());
                redirect(base_url() . 'index.php?super_admin/role', 'refresh');
            } else {
                $data['school_id'] = $this->input->post('school_id');
                if ($param2 != '') {
                    $this->Role_model->update_role($data, array("id" => $param2));
                    $this->session->set_flashdata('flash_message', get_phrase('data_updated_successfully'));
                }
                redirect(base_url() . 'index.php?super_admin/role', 'refresh');
            }
        } else if (($param1 == "delete") && ($param2 != '')) {
            $this->Role_model->delete_role(array("id" => $param2));
            $this->session->set_flashdata("flash_message", get_phrase("data_deleted_successfully"));
            redirect(base_url() . 'index.php?super_admin/role', 'refresh');
        } else {
            $page_data['roles'] = $this->Role_model->get_role_array();
            $page_data['page_name'] = 'role';
            $page_data['page_title'] = get_phrase('manage_role');
            $this->load->view('backend/index', $page_data);
        }
    }

    public function assign_role($param1 = '', $school_id = '') {
        $page_data = $this->get_page_data_var();

        if (($param1 != '') && ($param1 != 'create') && ($school_id != '')) {
            $RlName = $this->Role_model->get_role_name($param1, $school_id);
            $RoleName = strtolower($RlName);
         
            if ($RoleName == 'admin') {
                $this->load->model('Admin_model');
                $page_data['data'] = $this->Admin_model->get_admin_list();
            } else if ($RoleName == 'teacher') {
                $this->load->model('Teacher_model');
                $page_data['data'] = $this->Teacher_model->get_teacher_list($school_id);
            }else if (strtolower($RoleName) == 'bus_driver') {
                $this->load->model('Bus_driver_modal');
                $page_data['data'] = $this->Bus_driver_modal->get_driver_list($school_id);
            } 
            else if ($RoleName == 'parent') {
                $this->load->model('Parent_model');
                $page_data['data'] = $this->Parent_model->get_parent_list($school_id);
            } else if ($RoleName == 'school_admin') {
                $this->load->model('School_Admin_model');
                $page_data['data'] = $this->School_Admin_model->get_school_admin_list($school_id);
            } else if ($RoleName == 'accountant') {
                $this->load->model('fees/Accountant_model');
                $page_data['data'] = $this->Accountant_model->get_school_accountant_list($school_id);
            } else if ($RoleName == 'cashier') {
                $this->load->model('fees/Cashier_model');
                $page_data['data'] = $this->Cashier_model->get_school_cashier_list($school_id);
            }
            else if ($RoleName == 'bus_admin') {
                $this->load->model('Bus_administrator_model');
                $page_data['data'] = $this->Bus_administrator_model->get_admin_list($school_id);
            }
        } else if ($param1 == 'create') {
            $data = $this->input->post();
            $where = array('r.school_id' => $data['school_id']);
            $roles = $this->Role_model->get_role_array($where);

            $RoleKey = array();
            if (count($roles)) {
                foreach ($roles as $role) {
                    $RoleKey[$role['id']] = $role['role_name'];
                }
            }
           
            //        pre($data);
            $chk = 1;
            if (count($data['assigned_user'])) {
                foreach ($data['assigned_user'] as $datum) {
                    if (($datum != '') && ($data['assign_role'][$datum] != '')) {
                        if (strtolower($RoleKey[$data['assign_role'][$datum]]) == 'admin') {
                            $user_type = 'A';
                        } else if (strtolower($RoleKey[$data['assign_role'][$datum]]) == 'teacher') {
                            $user_type = 'T';
                            //echo "<br>here user type is $user_type and role is".$data['assign_role'][$datum];
                        } else if (strtolower($RoleKey[$data['assign_role'][$datum]]) == 'parent') {
                            $user_type = 'P';
                        } else if (strtolower($RoleKey[$data['assign_role'][$datum]]) == 'student') {
                            $user_type = 'S';
                        } else if (strtolower($RoleKey[$data['assign_role'][$datum]]) == 'librarian') {
                            $user_type = 'L';
                        } else if (strtolower($RoleKey[$data['assign_role'][$datum]]) == 'warden') {
                            $user_type = 'HA';
                        } else if (strtolower($RoleKey[$data['assign_role'][$datum]]) == 'bus_driver') {
                            $user_type = 'BD';
                        } else if (strtolower($RoleKey[$data['assign_role'][$datum]]) == 'bus_admin') {
                            $user_type = 'BA';
                        } else if (strtolower($RoleKey[$data['assign_role'][$datum]]) == 'school_admin') {
                            $user_type = 'SA';
                        } else if (strtolower($RoleKey[$data['assign_role'][$datum]]) == 'accountant') {
                            $user_type = 'ACCT';
                        } else if (strtolower($RoleKey[$data['assign_role'][$datum]]) == 'cashier') {
                            $user_type = 'CASH';
                        } else
                            $user_type = 'T';

                        $original_user_type = explode('assign_role/', $data['original_user_type']);
 
                        $original_user_type = explode("/", $original_user_type[1]);
                        $OUT = $original_user_type[0];
                        
                        if (strtolower($RoleKey[$OUT]) == 'admin') {
                            $OUTkEY = 'A';
                        } else if (strtolower($RoleKey[$OUT]) == 'teacher') {
                            $OUTkEY = 'T';
                        } else if (strtolower($RoleKey[$OUT]) == 'parent') {
                            $OUTkEY = 'P';
                        } else if (strtolower($RoleKey[$OUT]) == 'student') {
                            $OUTkEY = 'S';
                        } else if (strtolower($RoleKey[$OUT]) == 'librarian') {
                            $OUTkEY = 'L';
                        } else if (strtolower($RoleKey[$OUT]) == 'warden') {
                            $OUTkEY = 'HA';
                        } else if (strtolower($RoleKey[$OUT]) == 'bus_driver') {
                            $OUTkEY = 'BD';
                        } else if (strtolower($RoleKey[$OUT]) == 'bus_admin') {
                            $OUTkEY = 'BA';
                        } else if (strtolower($RoleKey[$OUT]) == 'school_admin') {
                            $OUTkEY = 'SA';
                        } else if (strtolower($RoleKey[$OUT]) == 'accountant') {
                            $OUTkEY = 'ACCT';
                        } else if (strtolower($RoleKey[$OUT]) == 'cashier') {
                            $OUTkEY = 'CASH';
                        }
                        
                        $this->Role_model->delete_exist_user_role_data(array('main_user_id' => $datum, 'original_user_type' => $OUTkEY, 'school_id' => $data['school_id']));
                        //echo "<br>here user type is:".$user_type;
                        $save_data['main_user_id'] = $datum;
                        $save_data['role_id'] = $data['assign_role'][$datum];
                        $save_data['user_type'] = $user_type;
                        $save_data['original_user_type'] = $OUTkEY;


                        if($OUTkEY == 'A')
                            $save_data['school_id'] = '';
                        else {
                            $save_data['school_id'] = $data['school_id'];
                        }
                        

                        $id = $this->Role_model->assign_role($save_data);
                        if (!$id) {
                            $chk = 0;
                        }
                    }
                }
            }
            //           die;
            if ($chk == 1) {
                $this->session->set_flashdata('flash_message', get_phrase('Successfully_asssigned_the_roles'));

                redirect(base_url() . 'index.php?super_admin/assign_role', 'refresh');
            } else if ($chk == 0) {
                $this->session->set_flashdata('flash_message_error', get_phrase('something_missing_wrong'));
                redirect(base_url() . 'index.php?super_admin/assign_role', 'refresh');
            }
        }

        $page_data['roles'] = array();
        if ($school_id != '') {
            $where = array('r.school_id' => $school_id);
            $page_data['roles'] = $this->Role_model->get_role_array($where);
        }

        $this->load->model('School_model');

        $page_data['school'] = $this->School_model->get_school_array();

        $page_data['UserType'] = $param1;
        $page_data['page_name'] = 'assign_role';
        $page_data['page_title'] = get_phrase('manage_role');
        $this->load->view('backend/index', $page_data);
    }

    public function link_module($param1 = '', $param2 = '') {
        $page_data = $this->get_page_data_var();
        if ($param1 == "add") {
            $page_data['page_name'] = 'add_link_module';
            $page_data['page_title'] = get_phrase('add_link_module');
            $page_data['parent_links'] = $this->Linkmodule_model->get_link_module_array(array("link" => 0, "parent_id" => 0));
            $this->load->view('backend/index', $page_data);
        } else if ($param1 == "create") {

            $this->form_validation->set_rules('name', 'Link Name', 'trim|required|is_unique[link_modules.name]');
            $this->form_validation->set_rules('user_type', 'User Type', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata("flash_message_error", validation_errors());
                redirect(base_url() . 'index.php?super_admin/link_module/add', 'refresh');
            } else {
                $data['name'] = $this->input->post('name');
                $data['link'] = trim($this->input->post('link')) == "" ? "0" : trim($this->input->post('link'));
                $data['user_type'] = $this->input->post('user_type');
                $data['image'] = $_FILES['linkmodulefile']['name'];
                $data['orders'] = $this->input->post('order');
                $data['parent_id'] = $this->input->post('parent_id');

                if ($data['image'] != "") {
                    $types = array('image/jpeg', 'image/gif', 'image/png');
                    if (in_array($_FILES['linkmodulefile']['type'], $types)) {
                        /*                         * *******************Uploads module image and add into table************************** */
                        if (move_uploaded_file($_FILES['linkmodulefile']['tmp_name'], 'uploads/link_module_images/' . $data['image'])) {
                            //Inserts data to table
                        } else {
                            $this->session->set_flashdata("flash_message_error", get_phrase('module_image_upload_error'));
                            redirect_url(base_url() . "index.php?super_admin/link_module/add", 'refresh');
                        }
                    }
                }

                $id = $this->Linkmodule_model->add($data);
                if ($id) {
                    $this->session->set_flashdata("flash_message", get_phrase('link_module_added_successfully'));
                    redirect(base_url() . "index.php?super_admin/link_module", 'refresh');
                } else {
                    $this->session->set_flashdata("flash_message_error", get_phrase("something_missing_wrong"));
                    redirect(base_url() . 'index.php?super_admin/link_module/add', 'refresh');
                }
            }
        }/* else if($param1 == "edit"){
          $page_data['page_name'] = 'link_module';
          $page_data['page_title'] = get_phrase('edit_link_module');
          $page_data['link_modules'] = $this->Linkmodule_model->get_link_module_array();
          $this->load->view('backend/index', $page_data);
          } */ else if ($param1 == "update") {
            $data['name'] = $this->input->post('name');
            $data['link'] = trim($this->input->post('link')) == "" ? "0" : trim($this->input->post('link'));
            //$data['image']      = $_FILES['modulefile']['name'];
            $data['user_type'] = $this->input->post('user_type');
            if ($_FILES['linkmodulefile']['name'] != "") {
                $data['image'] = $_FILES['linkmodulefile']['name'];
            } else {
                $data['image'] = $this->input->post('image');
            }
            $data['orders'] = $this->input->post('order');
            $data['parent_id'] = $this->input->post('parent_id');
            $data['user_type'] = $this->input->post('user_type');
            if ($data['image'] != "") {
                $types = array('image/jpeg', 'image/gif', 'image/png');
                if (in_array($_FILES['linkmodulefile']['type'], $types)) {
                    $path_to_file = "uploads/link_module_images/" . $this->input->post('image');
                    //chmod("uploads/link_module_images/".$this->input->post('image'),0777);
                    unlink($path_to_file);
                    /*                     * *******************Uploads link image and add into table************************** */
                    if (move_uploaded_file($_FILES['linkmodulefile']['tmp_name'], 'uploads/link_module_images/' . $data['image'])) {
                        //Inserts data to table
                    } else {
                        $this->session->set_flashdata("flash_message_error", get_phrase('module_image_upload_error'));
                        redirect_url(base_url() . "index.php?super_admin/link_module/add", 'refresh');
                    }
                }
            }
            $module_id = $this->Linkmodule_model->update_link_module($data, array("id" => $param2));
            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
            redirect(base_url() . 'index.php?super_admin/link_module/', 'refresh');
        } else if ($param1 == "delete") {
            $link_module_arr = $this->Linkmodule_model->get_link_module_array(array("id" => $param2));
            $path_to_file = "uploads/link_module_images/" . $link_module_arr[0]['image'];
            unlink($path_to_file);
            $this->Linkmodule_model->delete_link_module(array("id" => $param2));
            $this->session->set_flashdata("flash_message", get_phrase("data_deleted"));
            redirect(base_url() . 'index.php?super_admin/link_module', 'refresh');
        } else {
            $page_data['link_modules'] = $this->Linkmodule_model->get_link_module_array();

            $page_data['page_name'] = 'link_module';
            $page_data['page_title'] = get_phrase('manage_link_module');
            $this->load->view('backend/index', $page_data);
        }
    }

    public function permission($param1 = '', $param2 = '', $school_id = '') {
        $page_data = $this->get_page_data_var();
        $page_data['UserType'] = '';

        if ($param1 == 'create') {
            $data = $this->input->post();

            if (count($data['link_id']) && $data['role_id'] != '' && $data['user_type'] != '' && ($data['school_id'] != '')) {
                $this->Role_model->delete_old_permission_data(array('role_id' => $data['role_id'], 'school_id' => $data['school_id']));
                foreach ($data['link_id'] as $datum) {
                    if ($datum != '') {
                        $save_data['role_id'] = $data['role_id'];
                        $save_data['user_type'] = $data['user_type'];
                        $save_data['link_id'] = $datum;

                        if($save_data['user_type']!='A'){
                            $save_data['school_id'] = $data['school_id'];
                        }
                        
                        $id = $this->Role_model->save_update_permission($save_data);
                    }
                }
            }

            $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?super_admin/permission', 'refresh');
        } else if (($param1 != 'create') && ($param1 != '') && ($param2 != '') && ($school_id != '')) {
            $exist_role_link_data = $this->Role_model->get_exist_role_link_data(array('role_id' => $param1, 'user_type' => $param2, 'school_id' => $school_id));

            if (count($exist_role_link_data)) {
                foreach ($exist_role_link_data as $datum) {
                    $result[] = $datum['link_id'];
                }
                $page_data['exist_role_link_data'] = $result;
            }

            $page_data['UserType'] = $param2;
            $page_data['data'] = $this->Role_model->get_permission_data(array('user_type' => $param2, 'parent_id' => 0));
        }
        //echo '<pre>';print_r( $page_data['data']);exit;

        $page_data['roles'] = array();
        if ($school_id != '') {
            $where = array('r.school_id' => $school_id);
            $page_data['roles'] = $this->Role_model->get_role_array($where);
        }

        $page_data['page_name'] = 'role_permission';
        $page_data['page_title'] = get_phrase('role_permission');
        $this->load->model('School_model');
        $page_data['school'] = $this->School_model->get_school_array();
        $this->load->view('backend/index', $page_data);
    }

    // Dynamic Group
    public function dynamic_group($param1 = '', $param2 = '', $param3 = '') {
        $page_data = $this->get_page_data_var();
        $this->load->model('Dynamic_group_model');
        $this->load->model('Dynamic_form_model');
        $page_data['UserType'] = '';
        if ($param1 == 'create') {
            $data['name'] = $this->input->post('group_name');
            $data['image'] = $this->input->post('image');
            $data['form_id'] = $this->input->post('form_name');
            $data['intro'] = $this->input->post('intro');
            $data['section_name'] = $this->input->post('section_name');
            $this->Dynamic_group_model->add($data);
            $this->session->set_flashdata("flash_message", get_phrase("data_added_successfully"));
            redirect(base_url() . 'index.php?super_admin/dynamic_group', 'refresh');
        }
        if ($param1 == 'update') {
            $data['name'] = $this->input->post('group_name');
            $data['image'] = $this->input->post('image');
            $data['form_id'] = $this->input->post('form_name');
            $data['intro'] = $this->input->post('intro');
            $data['section_name'] = $this->input->post('section_name');
            if ($param2 != '') {
                $this->Dynamic_group_model->update_group($data, array("id" => $param2));
                $this->session->set_flashdata("flash_message", get_phrase("data_updated"));
                redirect(base_url() . 'index.php?super_admin/dynamic_group', 'refresh');
            }
        }
        if ($param1 == 'delete') {
            $this->Dynamic_group_model->delete_group($param2);
            $this->session->set_flashdata("flash_message", get_phrase("data_deleted"));
            redirect(base_url() . 'index.php?super_admin/dynamic_group', 'refresh');
        }
        if ($param1 == 'status_change') {
            if ($param3 == 'N') {
                $data['is_active'] = "Y";
                $messge = "data_enable_successfully";
            } else {
                $data['is_active'] = "N";
                $messge = "data_disable_successfully";
            }
            $this->Dynamic_group_model->update_status($data, array("id" => $param2));
            $this->session->set_flashdata("flash_message", get_phrase($messge));
            redirect(base_url() . 'index.php?super_admin/dynamic_group', 'refresh');
        }

        $page_data['fileds_data'] = $this->Dynamic_group_model->get_group_array();
        $page_data['dynamic_form_list'] = $this->Dynamic_form_model->get_formname_array();
        $page_data['page_name'] = 'dynamic_group';
        $page_data['page_title'] = get_phrase('dynamic_filed');
        $this->load->view('backend/index', $page_data);
    }

    //Dynamic Fields
    function dynamic_fields($param1 = '', $param2 = '', $param3 = '') {
        $page_data = $this->get_page_data_var();
        $this->load->model('Dynamic_filed_model');
        $page_data['UserType'] = '';
        if ($param1 == 'create') {
            $data['label'] = $this->input->post('lable_name');
            $data['db_field'] = $this->input->post('db_field');
            $data['validation'] = $this->input->post('validation');
            $data['validation_type'] = $this->input->post('validation_type');
            $data['min_length'] = $this->input->post('min_length');
            $data['max_length'] = $this->input->post('max_length');
            $data['field_type'] = $this->input->post('field_type');
            $data['field_values'] = $this->input->post('field_values');
            $data['field_table'] = $this->input->post('field_table');
            $data['enable'] = $this->input->post('enable');
            $data['group_id'] = $this->input->post('group_id');
            $data['order_id'] = $this->input->post('order_id');
            $data['field_select'] = $this->input->post('field_select');
            $data['field_where'] = $this->input->post('field_where');
            $data['image'] = $this->input->post('image');
            $data['place_holder'] = $this->input->post('place_holder');
            $data['form_id'] = $this->input->post('form_name');
            $val = $this->Dynamic_filed_model->add($data);
            $this->session->set_flashdata("flash_message", get_phrase("dynamic_field_added_successfully"));
            redirect(base_url() . 'index.php?super_admin/dynamic_fields', 'refresh');
        }
        if ($param1 == 'update') {
            $data['label'] = $this->input->post('lable_name');
            $data['db_field'] = $this->input->post('db_field');
            $data['validation_type'] = $this->input->post('validation_type');
            $data['validation'] = $this->input->post('validation');
            $data['min_length'] = $this->input->post('min_length');
            $data['max_length'] = $this->input->post('max_length');
            $data['field_type'] = $this->input->post('field_type');
            $data['field_values'] = $this->input->post('field_values');
            $data['field_table'] = $this->input->post('field_table');
            $data['group_id'] = $this->input->post('group_name');
            $data['order_id'] = $this->input->post('order_id');
            $data['field_select'] = $this->input->post('field_select');
            $data['field_where'] = $this->input->post('field_where');
            $data['image'] = $this->input->post('image');
            $data['place_holder'] = $this->input->post('place_holder');
            $data['form_id'] = $this->input->post('form_name');
            if ($param2 != '') {
                $this->Dynamic_filed_model->update_field($data, array("id" => $param2));
                $this->session->set_flashdata("flash_message", get_phrase("dynamic_field_updated"));
                redirect(base_url() . 'index.php?super_admin/dynamic_fields', 'refresh');
            }
        }
        if ($param1 == 'delete') {
            $this->Dynamic_filed_model->delete_field($param2);
            $this->session->set_flashdata("flash_message", get_phrase("dynamic_field_deleted"));
            redirect(base_url() . 'index.php?super_admin/dynamic_fields', 'refresh');
        }
        //         if (($param1 == 'ToggleEnable') && ($param3!= '')) {
        //             if($param3 == "Disable"){
        //                 $status = "N";
        //                 $message = "data_disable_sucessfully" ;
        //             }else{
        //                 $status = "Y";
        //                  $message = "data_enable_sucessfully" ;
        //             }
        //            $data['enable'] = $status;
        //              if ($this->Dynamic_filed_model->update_staus($data, array("id" => $param2))) {
        //                if ($param3 == "Enable") {
        //                    $this->session->set_flashdata('flash_message', get_phrase('data_disabled_successfully'));
        //                    echo 'Disabled';
        //                } else {
        //                    $this->session->set_flashdata('flash_message', get_phrase('data_enabled_successfully'));
        //                    echo 'Enabled';
        //                }
        //            }  
        //           }
        if ($param1 == 'status_change') {
            if ($param3 == 'N') {
                $data['enable'] = "Y";
                $messge = "dynamic_field_enable_successfully";
            } else {
                $data['enable'] = "N";
                $messge = "dynamic_field_disable_successfully";
            }
            //            pre($data); die;
            $this->Dynamic_filed_model->update_staus($data, array("id" => $param2));
            $this->session->set_flashdata("flash_message", get_phrase($messge));
            redirect(base_url() . 'index.php?super_admin/dynamic_fields', 'refresh');
        }

        $page_data['fields_data'] = $this->Dynamic_filed_model->get_fields_array();
        $page_data['page_name'] = 'dynamic_fields';
        $page_data['page_title'] = get_phrase('manage_fields');
        $this->load->view('backend/index', $page_data);
    }

    function add_field($param1 = '', $param2 = '') {
        $page_data = $this->get_page_data_var();
        $this->load->model('Dynamic_group_model');
        $this->load->model('Dynamic_form_model');
		
        $page_data['dynamic_form_list'] = $this->Dynamic_form_model->get_formname_array();
        $page_data['group_name'] = $this->Dynamic_group_model->get_groupname_array();
        $page_data['page_name'] = 'add_field';
        $page_data['page_title'] = get_phrase('add_fields');
        $this->load->view('backend/index', $page_data);
    }
	function ajax_get_columns($param1='')
	{
		$this->load->model('Dynamic_field_model');
		//$table='student';
		if (strpos(strtolower($param1), 'student') !== false) {
    $table="student";
		}
		if (strpos(strtolower($param1), 'parent') !== false) {
    $table="parent";
		}
		$columns = $this->Dynamic_field_model->get_column_of_table($table);
		
		$response_html = '<option value="">Select Field</option>';
    foreach ($columns as $column) {
        $response_html .= '<option value="' . $column['COLUMN_NAME'] . '">' . $column['COLUMN_NAME'] . '</option>';
    }
	$response_html .= '<option value="9999">Add new field</option>';
    echo $response_html;
	}
    function dynamic_form($param1 = '', $param2 = '', $param3 = '') {
        $page_data = $this->get_page_data_var();
        $this->load->model('Dynamic_form_model');
        $this->load->model("Dynamic_filed_model");
        $page_data['UserType'] = '';
        if ($param1 == 'create') {
            $data['name'] = $this->input->post('form_name');
            $this->Dynamic_form_model->add($data);
            $this->session->set_flashdata("flash_message", get_phrase("data_added_successfully"));
            redirect(base_url() . 'index.php?super_admin/dynamic_form', 'refresh');
        }
        if ($param1 == 'update') {
            $data['name'] = $this->input->post('form_name');
            if ($param2 != '') {
                $this->Dynamic_form_model->update_group($data, array("id" => $param2));
                $this->session->set_flashdata("flash_message", get_phrase("data_updated"));
                redirect(base_url() . 'index.php?super_admin/dynamic_form', 'refresh');
            }
        }
        if ($param1 == 'delete') {
            $this->Dynamic_form_model->delete_group($param2);
            $this->session->set_flashdata("flash_message", get_phrase("data_deleted"));
            redirect(base_url() . 'index.php?super_admin/dynamic_form', 'refresh');
        }
        if ($param1 == 'status_change') {
            if ($param3 == 'NO') {
                $data['is_enable'] = "YES";
                $messge = "data_enable_successfully";
            } else {
                $data['is_enable'] = "NO";
                $messge = "data_disable_successfully";
            }
            //            pre($data); die;
            $this->Dynamic_form_model->update_status($data, array("id" => $param2));
            $this->session->set_flashdata("flash_message", get_phrase($messge));
            redirect(base_url() . 'index.php?super_admin/dynamic_form', 'refresh');
        }
        $page_data['table_field'] = $this->Dynamic_filed_model->get_table_field_array();
        $page_data['fileds_data'] = $this->Dynamic_form_model->get_form_array();
        $page_data['page_name'] = 'dynamic_form';
        $page_data['page_title'] = get_phrase('dynamic_form');
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

    function edit_link_module($param1 = '') {
        $page_data = $this->get_page_data_var();
        $page_data['edit_data'] = $this->Linkmodule_model->get_link_module_array(array("id" => $param1));
        $page_data['parent_links'] = $this->Linkmodule_model->get_link_module_array(array("link" => 0, "parent_id" => 0));
        $page_data['page_title'] = "Edit Link Module";
        $page_data['page_name'] = "modal_edit_link_module";
        $this->load->view('backend/index', $page_data);
    }
    
    public function add_feature($param1 = '', $param2 = '') {
        $page_data = $this->get_page_data_var();
        $this->load->model('Feature_model');
        $page_data['feature_data'] = array();
        $page_data['page_title'] = get_phrase('Add New Feature');
        if($param1=='create'){
            $this->form_validation->set_rules('title', 'Feature Title', 'trim|required');
            $this->form_validation->set_rules('unique_string', 'Unique String', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('flash_message_error', validation_errors());
            } else {
                $data['title'] = $this->input->post('title');
                $data['unique_string'] = $this->input->post('unique_string');
                if($this->input->post('is_on')==1) {
                    $data['is_on'] = 1; 
                } else {
                    $data['is_on'] = 0; 
                }
                $data['date_updated'] = date('Y-m-d H:i:s');

                $id = $this->Feature_model->add($data);
                if ($id) {
                    $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
                    redirect(base_url() . 'index.php?super_admin/add_feature', 'refresh');
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('something_is_missing'));
                    redirect(base_url() . 'index.php?super_admin/add_feature/create', 'refresh');
                }
            }
        } else if ($param1 == 'update' && $param2 > 0) {
            $page_data['page_title'] = get_phrase('Update Feature');
            $page_data['feature_id'] = $param2;
            $page_data['feature_data'] = $this->Feature_model->get_feature_by_id($param2);
            
            $this->form_validation->set_rules('title', 'Feature Title', 'trim|required');
            $this->form_validation->set_rules('unique_string', 'Unique String', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('flash_message_error', validation_errors());
            } else {
                $data['title'] = $this->input->post('title');
                $data['unique_string'] = $this->input->post('unique_string');
                $data['is_on'] = $this->input->post('is_on');
                $data['date_updated'] = date('Y-m-d H:i:s');
                
                $id = $this->Feature_model->update($data,$param2);
                if ($id) {
                    $this->session->set_flashdata('flash_message', get_phrase('data_updated_successfully'));
                    redirect(base_url() . 'index.php?super_admin/manage_features', 'refresh');
                } else {
                    $this->session->set_flashdata('flash_message_error', get_phrase('something_is_missing'));
                    redirect(base_url() . 'index.php?super_admin/add_feature/update/'.$param2, 'refresh');
                }
            }
        }
        $page_data['page_name'] = 'add_feature';
        $this->load->view('backend/index', $page_data);
    }
    
    public function manage_features($param1='',$param2='') {
        $page_data = $this->get_page_data_var();
        $this->load->model('Feature_model');
        
        if ($param1 == 'delete' && $param2 > 0) {
            $this->Feature_model->delete(array('id'=>$param2));
            $this->session->set_flashdata("flash_message", get_phrase("data_deleted_successfully."));
            
            redirect(base_url() . 'index.php?super_admin/manage_features', 'refresh');
        }
        
        $page_data['feature_data'] = $this->Feature_model->get_all_features();
        $page_data['page_name'] = 'manage_features';
        $page_data['page_title'] = get_phrase('Manage Feature');
        $this->load->view('backend/index', $page_data);
    }
    
    public function link_module_features($param1 = '',$param2 = '') {
        $page_data = $this->get_page_data_var();
        $this->load->model('Feature_model');
        $page_data['data'] = $this->Role_model->get_permission_data(array('parent_id' => 0));
        
        if($param1 == 'create') {
            $data = $this->input->post();
            $this->Feature_model->delete_old_feature_link_data(array('feature_id' => $param2));
            foreach ($data['link_id'] as $datum) {
                if ($datum != '') {                    
                    $save_data['feature_id'] = $param2;
                    $save_data['link_id'] = $datum;

                    $id = $this->Feature_model->save_update_feature_link($save_data);
                }
            }
            $this->session->set_flashdata("flash_message", get_phrase("data_updated_successfully."));
            redirect(base_url() . 'index.php?super_admin/link_module_features/'.$param2, 'refresh');
        }
        
        $exist_feature_link_data = $this->Feature_model->get_exist_feature_link_data(array('feature_id'=>$param1));
        if (count($exist_feature_link_data)) {
            foreach ($exist_feature_link_data as $datum) {
                $result[] = $datum['link_id'];
            }
            $page_data['exist_feature_link_data'] = $result;
        }

        $page_data['feature_id'] = $param1;
        $page_data['page_name'] = 'link_module_features';
        $page_data['page_title'] = get_phrase('link_module_features');
        $this->load->view('backend/index', $page_data);
    }
    
    public function edit_field($param1 = '') {
        $page_data = $this->get_page_data_var();
        $this->load->model('Dynamic_group_model');
                $this->load->model('Dynamic_filed_model');
                $this->load->model('Dynamic_form_model');
                $page_data['page_title'] = "Edit Field";
				
                $page_data['dynamic_form_list'] = $this->Dynamic_form_model->get_formname_array();
                $page_data['group_name'] = $this->Dynamic_group_model->get_groupname_array();
                $page_data['edit_data'] = $this->Dynamic_filed_model->get_data_by_id(urldecode($param1));
        $page_data['page_name'] = 'modal_edit_field';
        $page_data['page_title'] = get_phrase('Edit_Field');
        $this->load->view('backend/index', $page_data);
    }
}