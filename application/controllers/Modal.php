<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class Modal extends CI_Controller
    {

        function __construct()
        {
            parent::__construct();
            $this->load->database();
            $this->load->library('session');
            /* cache control */
            $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
            //$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
            //$this->output->set_header('Pragma: no-cache');
            $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            $this->load->model("Subject_model");
            $this->load->model("Class_model");
            $this->load->model("Cce_model");
            $this->load->model("Setting_model");
            $this->load->model("Student_model");
            $this->load->model("Teacher_model");
            $this->load->model("Parent_model");
            $this->load->model("Bus_driver_modal");
            $this->load->model('Faculty_feedback_model');
            $this->load->model('Device_model');
            $this->load->model('Dormitory_model');
            $this->load->model('Exam_model');
            $this->load->model('invoice_model');
            $this->load->model('Linkmodule_model');
            $this->load->model('Role_model');
            $this->globalSettingsSMSDataArr=get_data_generic_fun('settings','description',array('condition_type'=>'in','condition_in_col'=>'type','condition_in_data'=>'location,app_package_name,running_year,system_name,system_email'));

            $this->load->helper('send_notifications');

        }

        /** *default functin, redirects to login page if no admin logged in yet** */

        public function index()
        {
            
        }

        /*
         * 	$page_name		=	The name of page
         */

        function popup($page_name = '', $param2 = '', $param3 = '')
        {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                
            }
            $account_type = $this->session->userdata('login_type');
            $page_data['param2'] = $param2;
            $page_data['param3'] = $param3;

            /********************************modal_add_nursery_chat_group_user starts********************************/
            if($page_name=='modal_add_nursery_chat_group_user'){
                  $page_data['page_title'] = "Add Nursery";
                $page_data['chatGroupArr'] = get_data_generic_fun('nursery_chat_group','group_name',array('group_id'=>$param2));
                $page_data['group_name'] = $page_data['chatGroupArr'][0]->group_name;
                $sql="SELECT t.name,t.teacher_id FROM `teacher` AS t JOIN `class` AS c ON(c.teacher_id=t.teacher_id) WHERE LOWER(c.name)='nursery'";
                $page_data['datteacherArr'] = $this->db->query($sql)->result();
                $sql1="SELECT p.parent_id,p.father_name FROM `parent` AS p JOIN `student` AS s ON(p.parent_id=s.parent_id) JOIN `enroll` AS e ON(e.student_id=s.student_id) JOIN `class` AS c ON(e.class_id=c.class_id) WHERE LOWER(c.name)='nursery'";
                $page_data['parrentDataArr'] = $this->db->query($sql1)->result();
            }
            /********************************modal_add_nursery_chat_group_user ends********************************/ 

            /********************************modal_books_class starts********************************/
            if($page_name=='modal_books_class'){
                  $page_data['page_title'] = "Class Books";
                $page_data['parents'] = $this->Parent_model->get_parents_array();
            }
            /********************************modal_books_class ends********************************/ 

            /********************************modal_device_edit starts********************************/
            if($page_name=='modal_device_edit'){
                  $page_data['page_title'] = "Edit Device";
                $page_data['rs'] = $this->Device_model->get_device_by_id($param2);
            }
            /********************************modal_device_edit ends********************************/ 

            /********************************modal_driver_bus_edit starts********************************/
            if($page_name=='modal_driver_bus_edit'){
                  $page_data['page_title'] = "Edit Bus Driver";
                $page_data['edit_data'] = $this->Bus_driver_modal->get_bus_driver($param2); 
                $page_data['routes'] = $this->Bus_driver_modal->get_all_routes(); 
            }
            /********************************modal_driver_bus_edit ends********************************/ 

            if($page_name=="modal_transport_student"){ 
                  $page_data['page_title'] = "Student Transport";
                $this->load->model('Transport_model');
                $page_data['students'] = $this->Transport_model->get_list_of_students($param2);
            }
            
/********************************modal_add_classes starts********************************/  
              
            if($page_name=="modal_add_classes"){ 
  $page_data['page_title'] = "Add Class";                
                if($param2=='cce'){
                    $page_data['classes_record'] = $this->Class_model->get_cce_classes('id', 'desc');
                }else if($param2 =='cwa'){
                    $page_data['classes_record'] = $this->Class_model->get_cwa_classes();
                }else if($param2 =='gpa'){
                    $page_data['classes_record'] = $this->Class_model->get_gpa_classes();
                }else if($param2 =='ibo'){
                    $page_data['classes_record'] = $this->Class_model->get_ibo_classes('desc');
                }else if($param2 =='icse'){
                    $page_data['classes_record'] = $this->Class_model->get_icse_classes('desc');
                }else if($param2 =='igcse'){
                    $page_data['classes_record'] = $this->Class_model->get_igcse_classes('desc');
                }
                $page_data['evaluation_classes'] = $this->db->get('cce_classes')->result_array();
                $page_data['all_classes'] = $this->Class_model->get_class_array();
            }
            
/********************************modal_add_classes ends********************************/ 
            
/********************************modal_add_subjects starts********************************/            
            
            if($page_name=="modal_add_subjects"){  
                  $page_data['page_title'] = "Add Subject";
                if($param2=='cce'){
                    $page_data['classes'] = $this->Class_model->get_cce_classes('name', 'asc');
                }else if($param2 =='cwa'){
                    $page_data['classes'] = $this->Class_model->get_cwa_classes();
                }else if($param2 =='gpa'){
                    $page_data['classes'] = $this->Class_model->get_gpa_classes();
                }else if($param2 =='ibo'){
                    $page_data['classes'] = $this->Class_model->get_ibo_classes();
                }else if($param2 =='icse'){
                    $page_data['classes'] = $this->Class_model->get_icse_classes();
                }else if($param2 =='igcse'){
                    $page_data['classes'] = $this->Class_model->get_igcse_classes();
                }
            }

            if($page_name=="modal_add_subject_online_exam"){  
                  $page_data['page_title'] = "Add Subject";
                $page_data['show_data'] = $this->Class_model->get_subject_list_online_exam($param2);                    
               }
            
/********************************modal_add_subjects ends********************************/    
/********************************modal_add_groups starts********************************/ 
            if($page_name=="modal_add_groups"){  
                  $page_data['page_title'] = "Add Group";
                if($param2=='igcse'){
                    $page_data['group_records'] = $this->Exam_model->get_groups();
                }
            }
/********************************modal_add_groups ends********************************/ 
            
/********************************IBO grading pages starts********************************/            
            
            if($page_name=="modal_ibo_programs"){  
                  $page_data['page_title'] = "IBO Program";
                $page_data['classes'] = $this->Class_model->get_ibo_classes();
                $page_data['programs'] = $this->Class_model->get_ibo_programs();
                //$subjects = $this->Cce_model->get_cce_subjects(array('class_id' => $param1));
            }
            if($page_name=="modal_add_program"){                 
                  $page_data['page_title'] = "Add Program";
                $page_data['programs'] = $this->Class_model->get_ibo_programs();
                
            }
            if($page_name=="modal_edit_program"){                 
                $page_data['page_title'] = "Edit Program";
                $page_data['programs'] = $this->Class_model->get_ibo_programs($param2);
            }

            if($page_name=="modal_assign_ibo_program"){   
                  $page_data['page_title'] = "Assign IBO Program";
                $page_data['classes'] = $this->Class_model->get_ibo_classes();
                $page_data['programs'] = $this->Class_model->get_ibo_programs();
                $page_data['class_program'] = $this->Class_model->get_assign_ibo_program();
                //pre($page_data['class_program']); die();
            }
            
            if($page_name=="modal_ibo_exam"){  
                  $page_data['page_title'] = "IBO Exam";
                $page_data['ibo_exams'] = $this->Exam_model->ibo_exam();
                //pre($page_data['ibo_exams'] ); die();
                $page_data['connected_ibo_exam'] = $this->Exam_model->connected_ibo_exam();
            }
            
            if($page_name=="modal_ibo_add_assessments"){  
                  $page_data['page_title'] = "Add IBO Assesment";
                $class_id =  $param2;
                $subject_id =  $param3;
               
                $class = $this->Class_model->get_class_record(array("class_id" => $class_id));
                $subjects = $this->Cce_model->get_cce_subjects(array('A.subject_id' => $subject_id));
                
                $assessment=$this->Cce_model->get_ibo_assessment($class_id, $subject_id);
                
                $page_data['assessment'] = $assessment;
                $page_data['class'] = $class;
                $page_data['subjects'] = $subjects;
                /*
                pre($page_data); die();
                */
            }
            
/********************************IBO grading pages ends********************************/            
                     
/********************************modal_cwa_exams_connect starts********************************/ 
            
            if($page_name=="modal_cwa_exams_connect"){  
                  $page_data['page_title'] = "CWA Exams";
                $this->load->model("Exam_model");
                $evaluation_id=$this->db->get_where('evaluation_method',array('name'=>'CWA'))->row()->evaluation_id;
                // cwa exam from exam table
                $page_data['cwa_exams'] = $this->Exam_model->cwa_exam(); 
                $page_data['connected_cwa_exams'] = array(); // cwa connected exam from cwa_exam_weightage table
                if($evaluation_id){
                    $page_data['connected_cwa_exams'] = $this->Exam_model->get_modal_cwa_exams_connect_data($evaluation_id);
                }
                //echo $this->db->last_query(); die();
            }
            
/********************************modal_cwa_exams_connect ends********************************/

/********************************modal_edit_cwa_subject starts********************************/
             if($page_name=="modal_edit_cwa_subject"){
                  $page_data['page_title'] = "Edit CWA Subject";
                $page_data['edit_data']   =   $this->Cce_model->get_cwa_subjects(array("A.subject_id" => $param2));
            }
/********************************modal_edit_cwa_subject ends********************************/



            
/********************************modal_cce_exams_starts********************************/     
    if($page_name=="modal_add_cs_activities"){ 
          $page_data['page_title'] = "Add CS Activity";
       $page_data['class'] = $this->Class_model->get_cce_classes(); 
    }

    if($page_name=="modal_edit_co_Scholastic"){ 
          $page_data['page_title'] = "Edit Co Scholastic";
        $page_data['cs_activities'] = $this->Cce_model->cce_coscholastic_activities('csa_id', $param3);
    }

    if($page_name=="modal_cce_exams_connect"){   
          $page_data['page_title'] = "CCE Exam Connect";
        $page_data['cce_exams'] = $this->Exam_model->cce_exam();
        $page_data['connected_cce_exam'] = $this->Exam_model->connected_cce_exam();
    }   

    if($page_name=="modal_icse_exams_connect"){  
          $page_data['page_title'] = "ICSE Exam Connect";
        $page_data['icse_exams'] = $this->Exam_model->icse_exam();
        $page_data['connected_icse_exam'] = $this->Exam_model->connected_icse_exam();
    }         
/********************************modal_cce_exams_ends********************************/ 

    if($page_name=="modal_pt_settings"){  
          $page_data['page_title'] = "PT Setting";
        $page_data['pt_max']=$this->Cce_model->get_cce_setting('pt_max');
    }

    if($page_name=="modal_notebook_settings"){ 
          $page_data['page_title'] = "Notebook Setting";
        $page_data['notebook_max']=$this->Cce_model->get_cce_setting('notebook_max');
    }

    if($page_name=="modal_se_settings"){ 
          $page_data['page_title'] = " Setting";
        $page_data['se_max']=$this->Cce_model->get_cce_setting('se_max');
    }
/********************************modal_gpa_exam_connect starts********************************/             
            
            if($page_name=="modal_gpa_exam_connect"){  
                  $page_data['page_title'] = "GPA Exam Connect";
                $this->load->model("Exam_model");
                $evaluation_id=$this->db->get_where('evaluation_method',array('name'=>'GPA'))->row()->evaluation_id;
                // gpa exam from exam table
                $page_data['gpa_exams'] = $this->Exam_model->gpa_exam();
                $page_data['connected_gpa_exams'] = array();
                if($evaluation_id){
                    $page_data['connected_gpa_exams'] = $this->Exam_model->get_modal_gpa_exams_connect_data($evaluation_id);
                }
            }

/********************************modal_gpa_exam_connect ends********************************/

/********************************modal_edit_gpa_subject starts********************************/

             if($page_name=="modal_edit_gpa_subject"){
                  $page_data['page_title'] = "Edit GPA Subject";
                $page_data['edit_data']   =   $this->Cce_model->get_gpa_subjects(array("A.subject_id" => $param2));
            }
            
/********************************modal_edit_gpa_subject ends********************************/             
            
/********************************modal_edit_class starts********************************/            
            
            if($page_name=="modal_edit_class"){ 
                  $page_data['page_title'] = "Edit Class";
                $page_data['teachers'] = $this->Teacher_model->get_teacher_array();
                $page_data['edit_data'] = $this->Class_model->get_class_record(array("class_id" => $param2));
                $page_data['row'] = (array) $page_data['edit_data'];
            }
            
/********************************modal_edit_class ends********************************/

/********************************modal_edit_dormitory starts********************************/            
            
            if($page_name=="modal_edit_dormitory"){ 
                  
              //$page_data['edit_data'] = $this->Dormitory_model->get_dormitory_array(array('dormitory_id' => $param2));
            }
            
/********************************modal_edit_dormitory ends********************************/

/********************************modal_edit_exam starts********************************/            
            
            if($page_name=="modal_edit_exam"){
                  $page_data['page_title'] = "Edit Exam";
                $page_data['edit_data'] = $this->Exam_model->get_exam_by_id($param2);  
            }
            
/********************************modal_edit_exam ends********************************/


        /********************************modal_edit_grade starts********************************/            
                    
            if($page_name=="modal_edit_grade"){
                  $page_data['page_title'] = "Edit Grade";
                $page_data['edit_data'] = $this->Exam_model->get_grade($param2);  
            }
                    
        /********************************modal_edit_grade ends********************************/

        /********************************modal_edit_invoice starts********************************/            
                    
            if($page_name=="modal_edit_invoice"){
                  $page_data['page_title'] = "Edit Invoice";
                $page_data['edit_data'] = $this->invoice_model->get_invoice_by_id($param2);  
            }
                    
        /********************************modal_edit_invoice ends********************************/


/********************************modal_cwa_ranking starts********************************/            
            
            if($page_name=="modal_cwa_ranking"){  
                  $page_data['page_title'] = "CWA Ranking";
                $page_data['rankings'] = $this->db->get('cwa_ranking')->result_array();
            }
            
/********************************modal_cwa_ranking ends********************************/ 
            
/********************************modal_gpa_ranking starts********************************/            
            
            if($page_name=="modal_gpa_ranking"){  
                  $page_data['page_title'] = "GPA Ranking";
                $page_data['rankings'] = $this->db->get('gpa_ranking')->result_array();
            }
            
/********************************modal_gpa_ranking ends********************************/

/********************************cwa_consolidated_report starts********************************/            
            
            if($page_name=="cwa_consolidated_report"){ 
                  $page_data['page_title'] = "CWA Consolidated Report";
                $page_data['classes'] = $this->Class_model->get_cwa_classes();
            }
            
/********************************cwa_consolidated_report ends********************************/ 
            
/********************************gpa_consolidated_report starts********************************/            
            
            if($page_name=="gpa_consolidated_report"){  
                  $page_data['page_title'] = "GPA Consolidated Report";
                $page_data['classes'] = $this->Class_model->get_gpa_classes();
            }
            
/********************************gpa_consolidated_report ends********************************/             
              
              
              
              
            if($page_name=="modal_student_profile"){
                  $page_data['page_title'] = "Student Profile";
            $student                            =   get_data_generic_fun('student','*',array('student_id'=>$param2),'result_arr');
            $parent_names                       =   array();
            foreach ($student as $row){
                $name                             =     get_data_generic_fun('parent','*',array('parent_id'=>$row['parent_id']),'result_arr');
            }
                
            $i                                =     0;
            $NewArray                         =     array();
            foreach($student as $value) {
                $NewArray[$i]                 =     array_merge($value,$name[$i]);
                $i++;          
            }
            $page_data['student_details']     =     $NewArray;  
            $year                             =     get_data_generic_fun('settings','description',array('type' => 'running_year'),'result_arr');
            foreach($year as $row1){
            $page_data['student_info']        =     get_data_generic_fun('enroll','*',array('student_id' =>$param2,'year'=>$row1['description']),'result_arr');
            }
            $page_data['student_image']         =     $this->crud_model->get_image_url('student' , $param2);
            }

            if($page_name=="modal_bus_add"){
                  $page_data['page_title'] = "Add Bus";
                $routes                             =       get_data_generic_fun('transport','route_name,transport_id',array('school_id'=>$school_id),'result_arr'); 
                $page_data['routes']                =       $routes;
            }
            if($page_name=="modal_driver_bus_add"){
                  $page_data['page_title'] = "Add Bus Driver";

                $page_data['buses']                =       $this->Bus_driver_modal->get_bus_for_add_driver();
            }
            /***********************modal_dormitory_student*******************/
//            if($page_name=="modal_dormitory_student"){
//                
//                
//              $page_data['dormitory_students']   =      get_data_generic_fun('student','*',array('dormitory_id' => $param2),'result_arr'); 
//              $student_ids                       =      get_data_generic_fun('student','student_id',array('transport_id' => $param2),'result_arr'); 
//             
//              //$class_ids_all                     =      array();
//              $class_names                       =      array();
//              if(!empty($page_data['dormitory_students'])){
//                foreach($page_data['dormitory_students'] as $key=>$student_id){
//
//                    $class_ids_each                   =      get_data_generic_fun('enroll','class_id',array('student_id' => $student_id['student_id']),'result_arr');
//                    $class_ids[]                        =$class_ids_each[0]['class_id'];
//
//                  }
//                 
//                  foreach($class_ids as $class_id){
//
//                        $class_names                      =   get_data_generic_fun('class','name',array('class_id' => $class_id),'result_arr'); 
//                      if(isset($class_names[0]['name'])){
//                        $class_ids_all[]['class_name']    =    $class_names[0]['name']; 
//                      }
//
//                  }
//              }
//                
//                $i=0;
//                $NewArray                               =   array();
//                foreach($page_data['dormitory_students'] as $value) {
//                   /// if(isset($class_ids_all[$i])){
//                    $NewArray[$i]                       =   array_merge($value,$class_ids_all[$i]);
//                    $i++;
//                    //}
//                }
//                $page_data['dormitory_students_all']   =       $NewArray;
//                
//               
//            }
//            
            if($page_name=="modal_student_edit"){
                  $page_data['page_title'] = "Edit Student";
             $page_data['class_id_nursery'] = get_data_generic_fun('class','class_id', array('name' => 'Nursery'),'result_array');
            }

             /****************************Modal View Teacher Profile*******************************/
            if($page_name=="modal_teacher_view"){    
                  $page_data['page_title'] = "View Teacher";
                $page_data['teacher_info'] = get_data_generic_fun('teacher','*', array('teacher_id' => $param2),'result_array');                
            }
            
            if($page_name=="modal_teacher_edit"){
                  $page_data['page_title'] = "Edit Teacher";
                  $page_data['teacher_record'] = $this->Teacher_model->get_teacher_record(array("teacher_id" => $param2));
            }
      
            /*************************Ends Here**************************************************/
            /********************************model_parent********************************/
            
            if($page_name=="modal_parent"){
                 $page_data['page_title'] = "Parent"; 
              $page_data['parents'] = $this->Parent_model->get_parents_array();
            }
            
            /********************************model_parent*********************************/
            /********************************modal_message********************************/
            
            if($page_name=="modal_message_list"){
                  $page_data['page_title'] = "Message List";
                $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
                $this->load->modal('Message_thread_model');
                
                $this->db->where('sender', $current_user);
                $this->db->or_where('reciever', $current_user);
                $message_threads = $this->Message_thread_model->get_messages($current_user,$current_user);  //'message_thread')->result_array();
                
                foreach ($message_threads as $k => $v):
                    
                    // defining the user to show
                    if ($v['sender'] == $current_user)
                        $user_to_show = explode('-', $v['reciever']);
                    if ($v['reciever'] == $current_user)
                        $user_to_show = explode('-', $v['sender']);
                    
                    if ($user_to_show[0] == "parent") { 
                        $message_threads[$k]['unread_message_number'] = $this->crud_model->count_unread_message_of_thread($v['message_thread_code']);
                        $message_threads[$k]['nameDataArr'] = $this->db->get_where($user_to_show[0], array($user_to_show[0] . '_id' => $user_to_show[1]))->row();
                    }
                    if ($user_to_show[0] == "student") { 
                        $message_threads[$k]['unread_message_number'] = $this->crud_model->count_unread_message_of_thread($v['message_thread_code']);
                        $message_threads[$k]['nameDataArr'] = $this->db->get_where($user_to_show[0], array($user_to_show[0] . '_id' => $user_to_show[1]))->row();
                     }
                     if ($user_to_show[0] == "teacher") { 
                        $message_threads[$k]['unread_message_number'] = $this->crud_model->count_unread_message_of_thread($v['message_thread_code']);
                        
                        $message_threads[$k]['nameDataArr'] = $this->db->get_where($user_to_show[0], array($user_to_show[0] . '_id' => $user_to_show[1]))->row();
                     }
                endforeach;
                 $page_data['message_threads'] = $message_threads;
//                pre($page_data['message_threads']);exit;
            }  
             
            // echo "<hr>************************";
           // exit;
            /********************************model_parent*********************************/
            /********************************model_parent_view********************************/
            
            if($page_name=="modal_parent_view"){
                //$page_data['parent_record']   = get_data_generic_fun('parent','*', array('parent_id' => $param2),'result_array');
                $page_data['page_title'] = "View Parent";
                $page_data['parent_record']   = $this->Parent_model->get_parent_details($param2);
                $page_data['student_name']    = $this->Student_model->get_student_infoBYparentID($param2);
            }
            
            /********************************model_parent_view*********************************/
            
            /********************************model_parent_edit********************************/
            
            if($page_name=="modal_parent_edit"){
                $page_data['CountryList'] = get_country_list();
                  $page_data['page_title'] = "Edit Parent";
                $page_data['parent_record']   = get_data_generic_fun('parent','*', array('parent_id' => $param2),'result_array');

                $page_data['StateList'] = array();
                if($page_data['parent_record'][0]['country']!=''){
                    $where = array('location_type' => 1, 'parent_id' => $page_data['parent_record'][0]['country']);
                      $page_data['page_title'] = "StateList";
                    $page_data['StateList'] = get_data_generic_fun('country', '*', $where, 'result_array', array('name'=>'asc'));    
                }
            }
            if($page_name=="modal_student_edit"){
                $this->config->load('country_list', true);
                $country_name = $this->config->item('countries', 'country_list');
                  $page_data['page_title'] = "Edit Student";
                $page_data['countries'] = $country_name;
            }
            
            /********************************model_parent_edit*********************************/

             /************************** MODEL FOR UPLOAD DOCUMENT OF STUDENT ************************/
            if($page_name == 'modal_upload_file'){
                if($param2 == 'student'){
                    $page_data['student_id']   =   $param3;
                    $page_data['user_type']   =   "student";
                }
                if($param2 == 'teacher'){
                    $page_data['teacher_id']   =   $param3;
                    $page_data['user_type']   =   "teacher";
                } 
                  $page_data['page_title'] = "Upload File";
                           
            }

            /***************** model for upload receipt of product allocation ************/
            if($page_name == 'modal_upload_receipt'){
               $product_id = $param2; 
               $this->load->model('Inventory_allotment_model'); 
                $page_data['page_title'] = "Upload Receipt";
                $page_data['productArr'] = $this->Inventory_allotment_model->get_print_allot_product($product_id);
                           
            }            
            /********************************modal_study_material_add********************************/            
            if($page_name=="modal_study_material_add"){ 
                $this->load->model('Subject_model');
                  $page_data['page_title'] = "Add Study Material";
                $teacher_id = $this->session->userdata('teacher_id');
                $page_data['classes'] = $this->Subject_model->get_classes_by_teacher($teacher_id);               
            }

            /********************************modal_study_material_edit********************************/            
            if($page_name=="modal_study_material_edit_teacher"){ 
                $this->load->model('Subject_model');
                $teacher_id = $this->session->userdata('teacher_id');
                  $page_data['page_title'] = "Edit Study Material";
                $page_data['classes'] = $this->Subject_model->get_classes_by_teacher($teacher_id);                 
                $page_data['single_study_material_info'] = get_data_generic_fun('document','*',array('document_id' => $param2),'result_array');
                //echo '<pre>'; print_r($page_data['single_study_material_info']); exit;                
            }
            
            /********************************modal_add_event********************************/            
            if($page_name=="modal_add_event"){  
             $page_data['page_title'] = "Add Event";                
                //$page_data['classes'] =  get_data_generic_fun('class',"*",array(),"result_arr"); 
                //$page_data['single_study_material_info'] = get_data_generic_fun('document','*',array('document_id' => $param2),'result_array');
            }
            
            /*************************** modal_view_student_promotion_performance   ************/
            if($page_name=="student_promotion_performance"){ 
                $this->load->model('Mark_model');
                $marks_details = array();
                  $page_data['page_title'] = "Student Promotion Performance";
                $page_data['student_name'] = $this->crud_model->get_type_name_by_id('student' , $param2);
                $running_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
                $page_data['subjects'] = $this->Subject_model->get_all_exam_subject_marks($param3,$param2,$running_year);
            }            
            /************************  end the function  ******************/
            
            if($page_name == "modal_payment_gateway_edit"){
                $this->config->load('payment_config', true);
                $payment = $this->config->item('payment_options', 'payment_config');
                $page_data['payment_details'] = get_data_generic_fun('payment_gateway',"*",array('gateway_id' => $param2),"result_arr");
                $page_data['payment_options'] = $payment;
                  $page_data['page_title'] = "Edit Payment Gateway";
            } 
              /********************************modal_edit_hostel_allocation********************************/            
            if($page_name=="modal_edit_hostel_allocation"){                  

            $registration               =   get_data_generic_fun('hostel_registration','*',array('hostel_reg_id'=>$param2),'result_array');
            foreach($registration as $row){
//            $class_name                 =   get_data_generic_fun('class','name',array('class_id'=>$row['class_id']),'result_array');
//            $class[]['class_name']      =   $class_name[0]['name'];
//            $section_name               =   get_data_generic_fun('section','name',array('section_id'=>$row['section_id']),'result_array');
//            $section[]['section_name']  =   $section_name[0]['name'];
            $student_name               =   get_data_generic_fun('student','name',array('student_id'=>$row['student_id']),'result_array');
             if(!empty($student_name)){
                $student[]['student_name']  =   $student_name[0]['name']; 
            }
            else{
                $student[]['student_name']  =   '';
            }
                $hostel_name                =   get_data_generic_fun('dormitory','name',array('dormitory_id'=>$row['hostel_id']),'result_array');
                if(!empty($hostel_name)){
                $hostel[]['hostel_name']    =  $hostel_name[0]['name'];
            }
            else{
                $hostel[]['hostel_name']    =   '';
            }
        }
      
            $i=0;
            $new=array();
            foreach($registration as $value){
                $new[$i] = array_merge($value,/*$class[$i],$section[$i],*/$student[$i],$hostel[$i]);
                $i++;           
             }
             $page_data['allocation_details']    =   $new;
            }
            /********************************modal_edit_hostel_warden********************************/            
            if($page_name=="modal_edit_hostel_warden"){ 
                  $page_data['page_title'] = "Hostel Warden";
                $page_data['warden_details']    =   get_data_generic_fun('hostel_warden','*',array('warden_id'=>$param2,'status'=>'Active'),'result_array');
            }

            /********************************modal_edit_hostel_warden********************************/   
            
            if($page_name == "modal_edit_campus_update"){
                $page_data['updates'] = get_data_generic_fun('notification',"*",array('notification_id' => $param2),"result_arr");
                 $page_data['page_title'] = "campus_update";
                $page_data['row'] = array_shift($page_data['updates']);
            }
            

            if($page_name == "modal_product_return_service"){
                $service_id                 =   get_data_generic_fun('inventory_product_service',"MAX(service_id) as service_id",array('product_id' => $param2),"result_arr");
                foreach ($service_id as $value) {
                    $services   =   get_data_generic_fun('inventory_product_service','*',array('service_id'=>$value['service_id']),'result_array');        
                    
                }
                foreach ($services as $row){
                    $vendor                 =   get_data_generic_fun('seller_master','seller_name',array('seller_id'=>$row['vendor_id']),'result_array');   
                    if(!empty($vendor)){
                        $vendor_name[]['vendor_name']=  $vendor[0]['seller_name'];
                    }
                    else{
                        $vendor_name[]['vendor_name']   =   "";
                    }
                    
                }
                $product_name  =   get_data_generic_fun('product','product_name',array('product_id'=>$param2),'result_array');
                $i=0;
                $NewArray                   =   array();
                foreach ($services as $rows){
                    $NewArray[$i]           =   array_merge($rows,$vendor_name[$i],$product_name[$i]);
                    $i++;        
                }
                 $page_data['service']      =   $NewArray;
                  $page_data['page_title'] = "Product Return Service";
            }
            
            if($page_name == "modal_test_service"){
                 $page_data['page_title'] = "Test Service";
                $page_data['vendor'] = get_data_generic_fun('seller_master',"*",array(),"result_arr");
                //Feedback Popup
            }
            if($page_name == "modal_allot_product_print"){
                $this->load->model('Inventory_allotment_model'); 
                $product_id = $param2; 
                 $page_data['page_title'] = "Allot Product Print";
                $page_data['productArr'] = $this->Inventory_allotment_model->get_print_allot_product($product_id);
//pre($page_data['productArr']); die;                
//Feedback Popup
            }
            if($page_name == "modal_feed_back"){ 
                $feed_back                                         =   get_data_generic_fun('faculty_feedback','*',array('teacher_id'=>$param2), 'result_arr' , array('date_created' => 'ORDER BY', 'date_created' => 'DESC'));
                $page_data['teacher_name']                         =   get_data_generic_fun('teacher','name,middle_name,last_name',array('teacher_id'=>$param2), 'result_arr');
                 $page_data['page_title'] = "FeedBack";
                if(!empty($feed_back)){
                    $rating                                        =   $this->Faculty_feedback_model->get_overall_rating($param2);
                    $mark                                          =   $rating->over_all_rating;
                    $count                                         =   $rating->count; 
                    $page_data['over_all_rating']                  =   round(($mark/($count * 5)) * 100);
                }
                $page_data['feed_backs']                           =   $feed_back;

            }
            /********************************modal_edit_hostel_warden********************************/ 
            
           /********************************modal_edit_hostel_room********************************/            
            if($page_name=="modal_edit_hostel_room"){                
                $page_data['room_details'] =   get_data_generic_fun('hostel_room','*',array('hostel_room_id'=>$param2,'school_id'=>$school_id),'result_array');  
                $year = $this->globalSettingsSMSDataArr[2]->description; 
                $this->load->library("fi_functions");  
                $page_data['charges'] = $charges = $this->fi_functions->get_hostelcharges($year);
                 $page_data['page_title'] = "Edit Hostel Room";
                $page_data['hostel_charges'] = $charges;
                $page_data['row'] = array_shift( $page_data['room_details']);            
                //pre($charges);die;
                $page_data['hostel_name'] = array();
                if($page_data['row']['hostel_type']!=''){
                    $page_data['hostel_name']=get_data_generic_fun('dormitory','dormitory_id,name',array('hostel_type'=>$page_data['row']['hostel_type'],'school_id'=>$school_id,'status' => 'Active'));
                }  
            }
            
            /********************************* modal_edit_hostel_room********************************/            
            if($page_name=="modal_blog_resend"){                 
                $page_data['blog_id'] = get_data_generic_fun('blog','*',array('blog_id'=>$param2),'result_array');  
                 $page_data['page_title'] = "Blog Resend";
            }
            
            if($page_name=="modal_edit_manage_hostel"){                 
                $page_data['hostel_details']    =   get_data_generic_fun('dormitory','*',array('dormitory_id'=>$param2),'result_arr');
                $warden_id_arr                  =       array();
                foreach ($page_data['hostel_details'] as $key=>$value) {
                    $warden_ids             =       explode(',',$value['warden_id']);
                    $warden_id_arr[$value['dormitory_id']]['warden']            =   array();
                    $warden_id_arr[$value['dormitory_id']]['id']                =   $value['dormitory_id'];
                    $warden_id_arr[$value['dormitory_id']]['name']              =   $value['name'];
                    $warden_id_arr[$value['dormitory_id']]['phone']             =   $value['phone_number'];
                    $warden_id_arr[$value['dormitory_id']]['type']              =   $value['hostel_type'];
                    $warden_id_arr[$value['dormitory_id']]['address']           =   $value['hostel_address'];
                    foreach($warden_ids as $ward_key => $warden_id) {

                        $name           =       get_data_generic_fun('hostel_warden','name,warden_id',array('warden_id'=>$warden_id),'result_arr');            
                        $warden_id_arr[$value['dormitory_id']]['warden'][]       =   $name[0];
                    }
                }
                $page_data['details']   =   $warden_id_arr; 
                 $page_data['page_title'] = "Edit Manage Hostel";
                $page_data['warden']    =   get_data_generic_fun('hostel_warden','name,warden_id',array('status'=>'Active'),'result_arr');
            }
            if($page_name=="section_add"){
                $page_data['classes']   =   get_data_generic_fun('class','*',array(),'result_array',array('name_numeric'=>'asc')); 
                 $page_data['page_title'] = "Add Section";
                $page_data['teachers']  =   get_data_generic_fun('teacher','*',array(),'result_array',array('name'=>'asc'));              
            }
               
           if($page_name=="modal_edit_subject"){
                $page_data['edit_data']     =   $this->Subject_model->get_subject_array(array("subject_id" => $param2));
                $page_data['teachers']      =   get_data_generic_fun('teacher',"*",array(),"result_arr");
                $page_data['classes']       =   $this->Class_model->get_class_array();
                 $page_data['page_title'] = "Edit Subject";
                if(!empty($page_data['edit_data'][0]['class_id'])){
                    $page_data['sections']      =   get_data_generic_fun('section',"*",array('class_id'=>$page_data['edit_data'][0]['class_id']),"result_array");
                }
            }
			
			if($page_name=="modal_edit_cce_subject"){
				
                $page_data['edit_data']   =   $this->Cce_model->get_cce_subjects(array("A.subject_id" => $param2));
                 $page_data['page_title'] = "Edit CCE Subject";
			}

            if($page_name=="modal_edit_icse_subject"){
                
                $page_data['edit_data']   =   $this->Cce_model->get_icse_subjects(array("A.subject_id" => $param2));
                 $page_data['page_title'] = "Edit ICSE Subject";
            }
         
             /********************************academic_syllabus_add********************************/            
            if($page_name=="academic_syllabus_add"){    
                if($account_type    ==  "teacher"){
                $teacher_id         =   $this->session->userdata('teacher_id');
                $this->load->model('class_model');
                $class              =   $this->class_model->get_class_name_by_subject($teacher_id);
                 $page_data['page_title'] = "Add Academic Syllabus";
                $page_data['class']  =    $class;
                }
            }
             /********************************modal_vehicle_return_from_service********************************/   
            if($page_name           ==      "modal_vehicle_return_from_service"){
                $service_id         =       get_data_generic_fun("vehicle_service_maintenance","MAX(vehicle_service_maintenance_id) as vehicle_service_maintenance_id",array('vehicle_details_id' => $param2),"result_arr");
                foreach($service_id as $row){
                    $details        =       get_data_generic_fun('vehicle_service_maintenance','*',array('vehicle_service_maintenance_id'=>$row['vehicle_service_maintenance_id']),'result_array');
                    $detail[]       =       $details[0];
                }
                 $page_data['page_title'] = "Vehicle Return From Service";
                $page_data['service_details']   =   $detail;
            }

            
            /*******************************Modal View Assignments*************************************/
            if($page_name           ==      "assignment_preview"){
               $file_name = $param2;
                $page_data['page_title'] = "Assignment Preview";
                $page_data['file_type'] = 'file';
                if (strpos($file_name, '.') !== false) {
                    $FileType = explode('.', $file_name);
                    $ImageFile = array('PNG', 'JPEG', 'JPG', 'png', 'jpeg', 'jpg');
                    if(in_array($FileType[1], $ImageFile)){
                        $page_data['file_type'] = 'image';
                    }
                }        
//                 assignments_answers
                if($param3 == 'teacher'){
                    $folder_name = 'assignments_answers'; 
                }else{
                    $folder_name = 'assignments'; 
                }
//                echo $folder_name; die;
                $page_data['url'] = base_url("uploads/".$folder_name."/" . $file_name);
            }
            
            
            /*******************************Modal submit Assignments*************************************/
            if($page_name           ==      "modal_assignment_submit"){
                $assignment_Details  =       get_data_generic_fun("student_assignments","*",array('assignment_id' => $param2),"result_arr");
                 $page_data['page_title'] = "Submit Assignment";
                $page_data['assignment_Details']   =   $assignment_Details;
            }
            
             /*******************************Modal Student submit Assignments*************************************/
            if($page_name           ==      "modal_submit_assignment_view"){
                $assignment_Details  =       get_data_generic_fun(" assignment_answers","*",array('answer_id' => $param2),"result_arr");
                 $page_data['page_title'] = "View Submit Assignment";
                $page_data['assignment_Details']   =   $assignment_Details;
            }
            

            if($page_name           ==      "manage_vehicle_service_maintenance"){
                $this->load->model('vehicle_service_maintenance_model');
                 $page_data['page_title'] = "Vehicle Service Maintenance";
                $page_data['details']               =   $this->vehicle_service_maintenance_model->get_all_details($param2);    
            }
            
            if($page_name           ==  "modal_blog_category_edit"){
                 $page_data['page_title'] = "Edit Blog Category";
                $page_data['catname']   =  get_data_generic_fun("blog_category","*",array('blog_category_id' => $param2),"result_arr");
            }
            
            if($page_name           ==  "modal_blog_subcategory_edit"){
                $page_data['catname']                   =   get_data_generic_fun("blog_category","*",array('blog_category_id' => $param2),"result_arr");
                 $page_data['page_title'] = "Edit Blog Subcategory";
                $page_data['blog_categories']           =   get_data_generic_fun('blog_category','*',array('blog_category_parent_id'=>'0','blog_category_isActive'=>'1'), 'result_arr', array('blog_category_name' => 'ASC'));
//             
                
            }
            
            /***************Modal feescharges**********************/
            if($page_name           ==  "modal_fees_seetings"){                
                $this->load->library("fi_functions");
                $charges                 =  $this->fi_functions->get_charges();
                 $page_data['page_title'] = "Fees Settings";
                $page_data['charges']   =   $charges;
               //echo '<pre>'; print_r($page_data['charges']);exit;
            }
            if($page_name           ==  "modal_my_class_details"){ 
                $this->load->model('Section_model');
                $this->load->model('Subject_model');
                $teacher_id = $this->session->userdata('teacher_id'); 
                 $page_data['page_title'] = "Class Detail";
                $page_data['class_teacher'] = $this->Section_model->get_class_deatils_by_teacher($teacher_id);
                $page_data['subjects']  = $this->Subject_model->get_all_subjects_by_teacher($teacher_id);
                
            }
            if($page_name           ==  "modal_my_teacher_info"){ 
                $this->load->model('Section_model');
                $this->load->model('Enroll_model');
                $this->load->model('Subject_model');
                $student_id                               =     $this->session->userdata('login_user_id');
                $year                                     =     $this->globalSettingsSMSDataArr[2]->description;
                $class_det                                =     $this->Enroll_model->get_class_section_by_student($student_id, $year);
                 $page_data['page_title'] = "My Teacher Info";
                $page_data['teacher_name']                =     $this->Section_model->get_teachername_by_class_section($class_det->class_id, $class_det->section_id);
                $subject_condition                        =     array( 'sub.class_id'  =>  $class_det->class_id, 'sub.section_id' =>  $class_det->section_id,'sub.year' => $year);
                $page_data['subjects']                    =     $this->Subject_model->get_all_subjects($subject_condition);
            }
            
            if($page_name               ==      "modal_edit_bus_stops"){
                $this->load->library("fi_functions");
                //$this->load->model('Route_bus_stop_model');
                $page_data['bus_stops']         =      get_data_generic_fun("route_bus_stop","*",array('route_bus_stop_id' => $param2),"result_arr");
                $page_data['route']             =      get_data_generic_fun('transport','*',array(),'result_array');
                 $page_data['page_title'] = "Edit Bus Stops";
                $year                           =      $this->globalSettingsSMSDataArr[2]->description;
                $page_data['charges']           =      $this->fi_functions->get_routecharges($year);
                $page_data['row']               =      array_shift($page_data['bus_stops'] ); 
            }
	    /********************************modal_edit_student_bus********************************/            
            if($page_name=="modal_edit_student_bus"){  
                $this->load->model('Student_bus_allocation_model');
                $detail = get_data_generic_fun('student_bus_allocation','*',array('student_bus_id'=>$param2),'result_array');
                 $page_data['page_title'] = "Edit Student Bus";
                if(!empty($detail)){
                     $page_data['page_title'] = "Detail";
                    foreach($detail as $row){
                        $name   =   get_data_generic_fun('student','name',array('student_id'=>$row['student_id']),'result_array');
                        if(!empty($name)){
                            $student_name[]['student_name']   =   $name[0]['name'];
                             $page_data['page_title'] = "Name";
                        }
                        else{
                            $student_name[]['student_name']   =   "";
                        }

                        $route   =   get_data_generic_fun('route_bus_stop','route_from,route_to',array('route_bus_stop_id'=>$row['bus_stop_id']),'result_array');
                        if(!empty($route)){
                            
                            $route_from[]['route_from']   =     $route[0]['route_from'];
                            $route_to[]['route_to']     =     $route[0]['route_to'];
                             $page_data['page_title'] = "Route";
                        }
                        else{
                            $route_from[]['route_from']    =   "";
                            $route_to[]['route_to']     =   "";
                        }
                        $bus   =   get_data_generic_fun('bus','name as bus_name',array('bus_id'=>$row['bus_id']),'result_array');
                        if(!empty($bus)){
                            $bus_name[]['bus_name']   =     $bus[0]['bus_name'];
                             $page_data['page_title'] = "Bus";
                        }
                        else{
                            $bus_name[]['bus_name']   =   "";
                        }
                        $page_data['bus_stops']       =      get_data_generic_fun('route_bus_stop','route_bus_stop_id,route_from,route_to',array('route_id'=>$row['route_id']),'result_array');
                        $page_data['bus']             =      get_data_generic_fun('bus','*',array('route_id'=>$row['route_id']),'result_array');
                    }
                    $i=0;
                    $newArray                   =   array();
                    foreach($detail as $value){
                        $newArray[$i]           = array_merge($value,$student_name[$i],$route_from[$i],$route_to[$i],$bus_name[$i]);
                        $i++;
                    }   
                }
                $page_data['details']           =   $newArray;
                $page_data['route']             =      get_data_generic_fun('transport','*',array(),'result_array');
            }
            
            if($page_name=="modal_bus_edit"){
                $page_data['routes'] = get_data_generic_fun('transport','route_name,transport_id',array(),'result_arr'); 
                $page_data['bus'] = $this->Bus_driver_modal->get_bus($param2);
                 $page_data['page_title'] = "Edit Bus";
            }
            
            if($page_name   == 'modal_edit_notice'){
                $page_data['edit_data']		=	$this->db->get_where('noticeboard' , array('notice_id' => $param2) )->result_array();
                $page_data['classes']           =       $this->Class_model->get_class_array();
                 $page_data['page_title'] = "Edit Notice";
            }
            
            if($page_name   == 'modal_add_comment'){
                $page_data['comment_details']      =       $this->db->get_where('discussion_post' , array('comment_id' => $param2) )->result_array();
                 $page_data['page_title'] = "Add Comment";
            }
            
            if($page_name == 'section_edit'){
                $page_data['edit_data']             =       $this->Class_model->get_section_record(array('section_id' => $param2));
                 $page_data['page_title'] = "Edit Section";
                $page_data['classes']               =       $this->Class_model->get_class_array();
                $page_data['teachers']              =       $this->Teacher_model->get_teacher_array();
            }
            
            if($page_name == 'academic_syllabus_add'){                
                $page_data['classes']               =       $this->Class_model->get_class_array();
                 $page_data['page_title'] = "Add Academic Syllabus";
            }
            
            if($page_name == 'modal_syllabus_edit'){
                $year                               =     $this->globalSettingsSMSDataArr[2]->description;   
                 $page_data['page_title'] = "Edit Syllabus";
                $page_data['classes']               =       $this->Class_model->get_class_array();
                $page_data['edit_data']             =     get_data_generic_fun('academic_syllabus','*',array('academic_syllabus_code' => $param2, 'year'=>$year),'result_arr');
                             
            }

            if($page_name == 'modal_fi_category_edit'){
                 $page_data['page_title'] = "Edit FI Category";
                $page_data['edit_data'] = get_data_generic_fun('fi_category','*',array('fi_category_id' => $param2),'result_arr');
            }

            if($page_name == 'modal_fi_assets_edit'){
                $page_data['page_title'] = "Edit Assets";
                $page_data['edit_data'] = get_data_generic_fun('fi_assets','*',array('fi_assets_id' => $param2),'result_arr');
            }

            if($page_name == 'modal_fi_liability_edit'){
                $page_data['page_title'] = "Edit Liability";
                $page_data['edit_data'] = get_data_generic_fun('fi_liability','*',array('fi_liability_id' => $param2),'result_arr');
            }

// academic_syllabus_preview preview starts            

            if($page_name == 'academic_syllabus_preview'){
                $file_name = $this->Class_model->get_academic_syllabus_name($param2);
//                echo $file_name; die;
                $page_data['page_title'] = "Academic Syllabus Preview";
                $page_data['file_type'] = 'file';
                if (strpos($file_name, '.') !== false) {
                    $FileType = explode('.', $file_name);
                    $ImageFile = array('PNG', 'JPEG', 'JPG', 'png', 'jpeg', 'jpg');
                    if(in_array($FileType[1], $ImageFile)){
                        $page_data['file_type'] = 'image';
                    }
                }
                
                $page_data['url'] = base_url("uploads/syllabus/" . $file_name);
//pre($page_data); die;                
//$page_data['url'] = 'http://'.CURRENT_IP_ADDR.'/beta_ag/uploads/Class_Upload_Template.xlsx';
                //$page_data['url'] = 'http://'.CURRENT_IP_ADDR.'/beta_ag/uploads/fs-cat.docx';
            }

// academic_syllabus_preview preview ends

// study_material_preview preview starts            

            if($page_name == 'study_material_preview'){
                $file_name = $param2;
                $page_data['page_title'] = "Study Material Preview";
                $page_data['file_type'] = 'file';
                if (strpos($file_name, '.') !== false) {
                    $FileType = explode('.', $file_name);
                    $ImageFile = array('PNG', 'JPEG', 'JPG', 'png', 'jpeg', 'jpg');
                    if(in_array($FileType[1], $ImageFile)){
                        $page_data['file_type'] = 'image';
                    }
                }              
                $page_data['url'] = base_url("uploads/document/" . $file_name);
            }

// study_material_preview preview ends 


// seller_document_preview starts            

            if($page_name == 'seller_document_preview'){
                $file_name = $param2;
                 $page_data['page_title'] = "Seller Document Preview";
                $page_data['file_type'] = 'file';
                if (strpos($file_name, '.') !== false) {
                    $FileType = explode('.', $file_name);
                    $ImageFile = array('PNG', 'JPEG', 'JPG', 'png', 'jpeg', 'jpg');
                    if(in_array($FileType[1], $ImageFile)){
                        $page_data['file_type'] = 'image';
                    }
                }   
                $page_data['file_name'] = $param2;
                $page_data['filepath'] = "uploads/inventory_seller_document/" . $file_name;
                $page_data['url'] = base_url("uploads/inventory_seller_document/" . $file_name);
            }

// seller_document_preview ends  

// modal_fi_revert_transaction starts 

            if($page_name == 'modal_fi_revert_transaction'){
                $page_data['TransactionType'] =  $param2;
                $page_data['id'] =  $param3;
            }

// modal_fi_revert_transaction ends            


            if($page_name == 'modal_syllabus_view'){
                 $page_data['page_title'] = "Syllabus View";
                $year                               =     $this->globalSettingsSMSDataArr[2]->description;                
                $page_data['classes']               =     $this->Class_model->get_class_array();
                $page_data['edit_data']             =     get_data_generic_fun('academic_syllabus','*',array('academic_syllabus_code' => $param2, 'year'=>$year),'result_arr');
            }
            
            if($page_name == 'modal_show_my_class'){ 
                $this->load->model('Section_model'); 
                 $page_data['page_title'] = "Show My Class";
                $year               =   $this->globalSettingsSMSDataArr[2]->description;
                $child_of_parent    =   get_data_generic_fun('enroll','*',array('student_id' => $param2 , 'year' => $year,'result_arr'));
                if(!empty($child_of_parent)){       
                    foreach ($child_of_parent as $row){
                        $this->load->model('enroll_model');
                         $page_data['page_title'] = "Child Of Parent";
                        $class_id       =   $this->enroll_model->get_class_id_bystudent_id($param2,$year);
                        $section_id     =   $this->enroll_model->get_section_id_bystudent_id($param2,$year);
                    }
                    if((!empty($class_id)) && (!empty($section_id))){
                        $this->load->model('subject_model');
                         $page_data['page_title'] = "Subjects";
                        
                        $page_data['subjects']= $this->subject_model->get_subjects_class_section($class_id,$section_id);
                        //echo '<pre>'; print_r($page_data['subjects']);
                    }
                    $student_name                               =     get_data_generic_fun('student','name',array('student_id'=>$child_of_parent[0]->student_id));
                    $page_data['student_name']                  =     $student_name[0]->name;
                    $student_details                            =     $this->Student_model->get_student_class_section($child_of_parent[0]->student_id);
                    if(!empty($student_details )){
                        $page_data['page_title'] = "Student Details";
                        $page_data['class_name']                =     $student_details['class_name'];
                        $page_data['section_name']              =     $student_details['section_name'];
                    }
                    $class_teacher                              =     $this->Section_model->get_teachername_by_class_section($class_id, $section_id);
                    if(!empty($class_teacher )){
                        $page_data['page_title'] = "Class Teacher";
                        $page_data['class_teacher_name']        =     $class_teacher[0]['teacher_name'];
                        $page_data['class_teacher_email']       =     $class_teacher[0]['email'];
                    }

                }
            }
            
            if($page_name == 'modal_study_material_view' || $page_name == 'modal_study_material_edit'){
               $this->load->model('Crud_model');  
               $page_data['page_title'] = "View Study Material";
               $page_data['study_material_info']    =   $this->Crud_model->get_document_by_id($param2);
               $page_data['classes']                =   get_data_generic_fun('class','*',array(),'result_array',array('name_numeric'=>'asc'));                
               $page_data['teachers']               =   $this->Teacher_model->get_teacher_array();
               
            }
            
            if($page_name == 'view_notice_details'){
                $this->load->model('Notification_model'); 
                $page_data['notice_details']    =   $this->Notification_model->get_Notice_details($param2);
                //echo $page_data['notice_details'][0]['parent_id']; exit;
                //echo '<pre>'; print_r($page_data['notice_details']); exit;
                if($page_data['notice_details'][0]['student_id'] != ' '){
                    $page_data['page_title'] = "View Notice Details";
                    $page_data['stud_ids'] = explode(",", $page_data['notice_details'][0]['student_id']); 
                }
                if($page_data['notice_details'][0]['parent_id'] != ' '){
                    $page_data['page_title'] = "Notice Details";
                    $page_data['par_ids'] = explode(",", $page_data['notice_details'][0]['parent_id']);                                        
                }
            }
             if($page_name=="modal_route_bus_stops"){
                 $page_data['page_title'] = "Route Bus Stops";
             $page_data['bus_stops'] = get_data_generic_fun('route_bus_stop','*', array('route_id' => $param2),'result_array');
            }
            
            
            if($page_name == "modal_bus_admin_edit"){
                $page_data['page_title'] = "Edit Bus Admin";
                $page_data['admin_data'] = get_data_generic_fun('bus_administrator','*', array('bus_administrator_id' => $param2), 'result_array'); 
            }
            
            if($page_name == "modal_dormitory_rooms"){
                $page_data['page_title'] = "Dormitory Rooms";
                $page_data['rooms']  =  get_data_generic_fun('hostel_room','*',array('hostel_id'=>$param2),"arr");
            }
            
            if($page_name == "modal_edit_class_routine"){
                $page_data['page_title'] = "Edit Class Routine";
                $page_data['edit_data']  = get_data_generic_fun('class_routine', '*', array('class_routine_id' => $param2), 'result_array');
                $page_data['classes'] = get_data_generic_fun('class' , '*',array(), 'result_array');
                
            }
                
            if($page_name == "modal_edit_dormitory"){
                $page_data['page_title'] = "Edit Dormitory";
               $page_data['edit_data'] = get_data_generic_fun('dormitory','*', array('dormitory_id' => $param2), 'result_array');
            }
            
            if($page_name == "modal_edit_nursery_chat_group"){
                $page_data['page_title'] = "Edit Nursery Chat Group";
               $page_data['edit_data'] = get_data_generic_fun('nursery_chat_group','*',array("group_id" => $param2));
            }
            if($page_name == 'modal_edit_online_exam'){
                $page_data['page_title'] = "Edit Online Exam";
                $page_data['classes'] = $this->Class_model->get_class_array();
                $page_data['edit_data'] = get_data_generic_fun('online_exam', '*', array('id' => $param2),'result_array');
            }
            if($page_name == 'modal_edit_transport'){ 
                $page_data['page_title'] = "Edit Transport";
                $page_data['edit_data']   =	get_data_generic_fun('transport' , '*', array('transport_id' => $param2), 'result_array');
            }

            /**********************Edit Module*****************************************/
            if($page_name=="modal_edit_module"){
                $page_data['page_title'] = "Edit Module";
                $page_data['edit_data'] =   $this->Module_model->get_module_array(array("id" => $param2));
            }   
            /**********************Edit Link Module*****************************************/
            if($page_name=="modal_edit_link_module"){  
                $page_data['page_title'] = "Edit Link Module";
                $page_data['edit_data'] =   $this->Linkmodule_model->get_link_module_array(array("id" => $param2));
                 
                $page_data['parent_links'] = $this->Linkmodule_model->get_link_module_array(array("link"=>0, "parent_id"=>0));
                

            }


/*******************Edit Role Starts*************************************/
            if($page_name=="modal_edit_role"){
                $this->load->model('School_model');
                $page_data['page_title'] = "Edit Role";
                $page_data['edit_data'] =  $this->Role_model->get_role_array(array("id" => $param2));
                $page_data['school'] = $this->School_model->get_school_array();
            }

/*******************Edit Role Ends*************************************/ 

            if($page_name == 'modal_edit_mess_time_table'){    
                $this->load->model('Mess_timetable_model');
                $page_data['page_title'] = "Edit Mess TimeTable";
                $page_data['data']   =	$this->Mess_timetable_model->get_details_ById($param2); 
            } 
            if($page_name == 'modal_edit_mess_time_table'){    
                $this->load->model('Mess_timetable_model');
                $page_data['page_title'] = "Edit Mess TimeTable";
                $page_data['data']   =	$this->Mess_timetable_model->get_details_ById($param2); 
            } 
            if($page_name == 'modal_edit_ptm'){           
                $page_data['edit_data']   =	get_data_generic_fun('parrent_teacher_meeting_date' , '*', array('parrent_teacher_meeting_date_id' => $param2), 'result_array');
                $page_data['page_title'] = "Edit PTM";
                $page_data['classes'] = $this->Class_model->get_class_array();
                $page_data['sections'] = get_data_generic_fun('section', '*', array(), 'result_arr');
                $page_data['exams'] = get_data_generic_fun('exam', '*', array(), 'result_arr');
                
            }
            if($page_name == 'modal_view_online_exam_details'){    
                $this->load->model('Online_exam_model');
                $this->load->model('Question_model');
                $page_data['page_title'] = "Online Exam Details";
                $page_data['data']   =	$this->Online_exam_model->get_data_by_cols('*',array('id'=>$param2),'result_array'); 
                $page_data['subject_details']   =   $this->Question_model->view_details_student_login($param2);
            }
             if($page_name == 'modal_view_homework'){    
                $this->load->model('Homeworks_model');
                //$this->load->model('Question_model');
               // echo "<br>here account type is:".$account_type." and page name is:".$page_name;
//echo "<br>here
                $page_data['page_title'] = "View Homework";
                $page_data['data']   =	$this->Homeworks_model->get_data_by_cols('*',array('home_work_id'=>$param2),'result_array'); 
                
               // $this->load->view('backend/' . $account_type . '/' . $page_name . '.php', $page_data);
                // $page_data['subject_details']   =   $this->Question_model->view_details_student_login($param2);
            } 
            if($page_name=='modal_event_view'){
                $this->load->model('Event_model');
                $page_data['page_title'] = "Event View";
                $page_data['event'] = $this->Event_model->get_event(array('id'=>$param2));
            }

            if($page_name=="modal_event_types"){
                $this->load->model('Event_model');
                $page_data['page_title'] = "Event types";
                $page_data['event_types'] = $this->Event_model->getEventTypes();
            }
            if($page_name=="modal_events"){
                $this->load->model('Event_model');
                $page_data['page_title'] = "Events";
                $page_data['events'] = $this->Event_model->get_events_by_type(urldecode($param2));
            }
            if($page_name=="modal_edit_group"){
                $this->load->model('Dynamic_group_model');
                $this->load->model('Dynamic_form_model');
                $page_data['page_title'] = "Edit Group";
                $page_data['edit_data'] = $this->Dynamic_group_model->get_data_by_id(urldecode($param2));
                $page_data['dynamic_form_list'] = $this->Dynamic_form_model->get_formname_array();
            }
            if($page_name=="modal_edit_form"){
                $page_data['page_title'] = "Edit Form";
                $this->load->model('Dynamic_form_model');
                $page_data['edit_data'] = $this->Dynamic_form_model->get_data_by_id(urldecode($param2));
            }
            if($page_name=="modal_edit_field"){
                $this->load->model('Dynamic_group_model');
                $this->load->model('Dynamic_filed_model');
                $this->load->model('Dynamic_form_model');
                $page_data['page_title'] = "Edit Field";
                $page_data['dynamic_form_list'] = $this->Dynamic_form_model->get_formname_array();
                $page_data['group_name'] = $this->Dynamic_group_model->get_groupname_array();
                $page_data['edit_data'] = $this->Dynamic_filed_model->get_data_by_id(urldecode($param2));
            }
            
            if($page_name=="modal_school_view"){  
                $page_data['page_title'] = "School View";
                $page_data['school_info'] = get_data_generic_fun('schools','*', array('school_id' => $param2),'result_array');                
            } 
            
            if($page_name=="modal_school_admin_view"){  
                $page_data['page_title'] = "School Admin View";
                $page_data['page_title'] = "Edit Violation type";
                $page_data['school_admin_info'] = get_data_generic_fun('school_admin','*', array('school_admin_id' => $param2),'result_array');                
            }
            
            if($page_name=="modal_edit_report_name"){
                $this->load->model('Dynamic_report_model');
                $page_data['page_title'] = "Edit Report Name";
                $page_data['edit_data'] = $this->Dynamic_report_model->get_data_by_id(urldecode($param2));
            }
            
             if($page_name=="modal_certificate_content"){
                $this->load->model('Class_model');
                $page_data['page_title'] = "Certificate Content";
                $page_data['classes'] = $this->Class_model->get_data_by_cols('*', array(), 'result_array');
                $this->load->model('Teacher_model');
                $page_data['teacher_list'] = $this->Teacher_model->get_teacher(); 
                $page_data['user_type'] = $param2;
            } 
             if($page_name=="modal_get_student_nameforCertificate"){
                $this->load->model('Class_model');
                $page_data['page_title'] = "Student Name For Certificate";
                $page_data['classes'] = $this->Class_model->get_data_by_cols('*', array(), 'result_array');
                $page_data['certificate_type'] = $param2;
               
            } 
             if($page_name=="modal_get_teacher_nameforCertificate"){
                $this->load->model('Teacher_model');
                $page_data['page_title'] = "Teacher Name For Certificate";
                $page_data['teacher_list'] = $this->Teacher_model->get_teacher();       
                $page_data['certificate_type'] = $param2;
             } 
              /*********************************edit_violation_type********************************/            
            if($page_name   ==  "edit_violation_type"){  
                $page_data['page_title'] = "Edit Violation type";
                $this->load->model('Violation_types_model');
                $page_data['details']   =   $this->Violation_types_model->get_data_by_cols('*', array('violation_type_id'=>$param2), 'result_array');
            }

            if($page_name=="modal_edit_holiday"){
                $this->load->model('Holiday_model');
                $page_data['page_title'] = "Edit Holiday";
                $holiday = $this->Holiday_model->get_holiday_by_id($param2);
                $page_data['holiday'] = $holiday;
            }
         
            if($page_name=="modal_view_doctor"){
                $this->load->model('Doctor_model');
                $page_data['page_title'] = "View Profile";
                $doctor = $this->Doctor_model->get_data_by_id($param2);
//                pre($doctor); die;
                $page_data['doctor_profile'] = $doctor;
            }

            if($page_name=="modal_view_doctor_profile"){
                $this->load->model('Doctor_model');
                $page_data['page_title'] = "Doctor Profile";
                $doctor = $this->Doctor_model->get_data_by_id($param2);
                $page_data['doctor_profile'] = $doctor;
            }
            
            if($page_name=="modal_edit_doctor"){
                $this->load->model('Doctor_model');
                $page_data['page_title'] = "Edit Profile";
                $doctor = $this->Doctor_model->get_data_by_id($param2);
//                pre($doctor); die;
                $page_data['doctor_profile'] = $doctor;
            }
            
            if($page_name=="modal_edit_clinical_history"){
                $this->load->model('Clinical_history_model');
                $page_data['page_title'] = "Edit Profile";
                $clinical_record = $this->Clinical_history_model->get_data_by_id($param2);
//                pre($clinical_record); die;
                $page_data['clinical_record'] = $clinical_record;
            }
            
            //echo "<br>here account type is $account_type";die;
            $this->load->view('backend/' . $account_type . '/' . $page_name . '.php', $page_data);
            
        }   


        
        /*
         * Edit student information in popup
         * @param studentid
         * return student edit credentials to modal view page
         */
        public function modal_student_profile( $student_id ) {
            $this->load->model("Dormitory_model");
            $this->load->model("Transport_model");
            $this->load->model("Section_model");
            
            $page_data                              =   array();
            $page_data['student_personal_info']     =   $this->Student_model->get_student_details($student_id);
            $page_data['sections']                  =   $this->Section_model->get_data_generic_fun( '*' , array("class_id" => $page_data['student_personal_info']->class_id));
            $page_data['parents']                   =   $this->Parent_model->get_parents_array();
            
            $this->config->load('country_list', true);
            $country_name                           =   $this->config->item('countries', 'country_list');
            $page_data['countries']                 =   $country_name;
            $page_data['dormitories']               =   $this->Dormitory_model->get_dormitory_array();
            $page_data['transports']                =   $this->Transport_model->get_transport_array();

            $page_name                              =   'modal_student_profile';
            $account_type                           =   $this->session->userdata('login_type');

            $this->load->view('backend/' . $account_type . '/' . $page_name . '.php', $page_data);
//            echo '<script src="assets/js/neon-custom-ajax.js"></script>';    
        }
        
        /*
         * Edit student information in popup
         * @param studentid
         * return student edit credentials to modal view page
         */
        public function modal_student_edit($student_id) {
            $this->load->model("Dormitory_model");
            $this->load->model("Transport_model");
            $this->load->model("Section_model");
            
            $page_data                              =   array();
            $page_data['student_personal_info']     =   $this->Student_model->get_student_details($student_id);
            if(!empty($page_data['student_personal_info'])){
                $page_data['photo_url']                =   $this->crud_model->get_image_url( 'student' ,$page_data['student_personal_info']->student_id );
                $page_data['sections']                  =   $this->Section_model->get_data_generic_fun( '*' , array("class_id" => $page_data['student_personal_info']->class_id));
            }
            $page_data['parents']                   =   $this->Parent_model->get_parents_array();
            
            $this->config->load('country_list', true);
            $country_name                           =   $this->config->item('countries', 'country_list');
            $page_data['countries']                 =   $country_name;
            $page_data['dormitories']               =   $this->Dormitory_model->get_dormitory_array();
            $page_data['transports']                =   $this->Transport_model->get_transport_array();
            $page_data['nationalities']             =   $this->Student_model->get_nationality_array();
            $page_name                              =   'modal_student_edit';
            $account_type                           =   $this->session->userdata('login_type');
//            print_r($page_data);die();
            $this->load->view('backend/' . $account_type . '/' . $page_name . '.php', $page_data);
            //echo '<script src="assets/js/neon-custom-ajax.js"></script>';    
        }
        /*
         * Update rfid of student
         */
        public function modifie_rfid( $student_id,$class_id="" ) {
            $account_type           =   $this->session->userdata('login_type');
            $student_details        =   $this->Student_model->get_student_details($student_id);
            $page_name              =   'modal_modifie_student_rfid';
            if($student_details) {
                $page_data                  =   array(
                    'student_id'            =>      $student_details->student_id,    
                    'name'                  =>      $student_details->name." ".$student_details->lname,
                    'blood_group'           =>      $student_details->blood_group,
                    'emergency_contact'     =>      $student_details->emergency_contact_number,
                    'academic_year'         =>      $student_details->academic_year,
                    'class'                 =>      $student_details->class_name,
                    'section'               =>      $student_details->section_name,
                    'photo_url'             =>      $this->crud_model->get_image_url( 'student' , $student_details->student_id ),
                    'card_number'           =>      ($student_details->card_id != '')?$student_details->card_id:NULL,
                );
            } else {
                $page_data['data_not_found'] =  'Data Not Found';
            }
            $page_data['class_id']=$class_id;
            $this->load->view('backend/' . $account_type . '/' . $page_name . '.php', $page_data);
            //echo '<script src="assets/js/neon-custom-ajax.js"></script>';
        }
        
        /*
         * View all medical records by student
         */
        public function view_all_medical_record($student_id,$class_id,$section_id) {
            $page_data                  =   array();
            $this->load->model("Medical_events_model");   
            $account_type               =   $this->session->userdata('login_type');
            $page_name                  =   'modal_view_clinical_records';
            $page_data['class_id']      =   $class_id;
            $page_data['section_id']    =   $section_id;
            $student_medical_records    =   $this->Medical_events_model->get_data_generic_fun( '*' , array( 'user_id' => $student_id ));
            $student_details            =   $this->Student_model->get_student_details( $student_id ); 
            
            if($student_medical_records) {
                $page_data['medical_records']   =   $student_medical_records;
                $page_data['student_details']   =   $student_details;    
            } else {
                $page_data['data_not_found'] =  'Data Not Found';
            }
            $this->load->view('backend/' . $account_type . '/' . $page_name . '.php', $page_data);
            //echo '<script src="assets/js/neon-custom-ajax.js"></script>';
        }


        /*
         * View medical record
         */
        public function view_medical_record( $record_id ) {
            $this->load->model("Medical_events_model");   
            $account_type           =   $this->session->userdata('login_type');
            $page_name              =   'modal_view_single_record';
            $medical_record         =   $this->Medical_events_model->get_medical_records( $record_id );
            $page_data              =   array();
            if($medical_record) {
                $page_data['student_id']        =   $medical_record->user_id;
                $page_data['student_name']      =   $medical_record->name;
                $page_data['stud_image']        =   $medical_record->stud_image;
                $page_data['class']             =   $medical_record->class_name;
                $page_data['section']           =   $medical_record->section_name;
                $page_data['consult_type']      =   $medical_record->consulting_type;
                $page_data['consult_date']      =   $medical_record->consult_date;
                $page_data['consult_time']      =   $medical_record->consult_time;
                $page_data['desease']           =   $medical_record->desease_title;
                $page_data['description']       =   $medical_record->description;
                $page_data['diagnosis']         =   $medical_record->diagnosis;
                $page_data['prescriptions']     =   $medical_record->prescriptions;
                $page_data['blood_group']       =   $medical_record->blood_group;
                $page_data['emergency_contact'] =   $medical_record->emergency_contact_number;
            } else {
                $page_data['data_not_found'] =  'Data Not Found';
            }
            $this->load->view('backend/' . $account_type . '/' . $page_name . '.php', $page_data);
            //echo '<script src="assets/js/neon-custom-ajax.js"></script>';
//            print_r($medical_record);die();
        }
        
        /*
         * Add student medical record
         */
        public function add_medical_record($student_id) {
            $student_details            =       $this->Student_model->get_student_details($student_id);
            $account_type               =       $this->session->userdata('login_type');
            $page_name                  =       'modal_add_medical_record';
            $page_data              =   array();
            if($student_details) {
                $page_data['student_id']        =   $student_details->student_id;
                $page_data['student_name']      =   $student_details->name;
                $page_data['stud_image']        =   $student_details->stud_image;
                $page_data['class']             =   $student_details->class_name;
                $page_data['section']           =   $student_details->section_name;
                $page_data['gender']            =   $student_details->sex;
                $page_data['birthday']          =   $student_details->birthday;
                $page_data['age']               =   date('Y') - date('Y' , strtotime($student_details->birthday));
                
                $page_data['phone_number']    =   $student_details->emergency_contact_number;
            } else {
                $page_data['data_not_found'] =  'Data Not Found';
            }
            
            $this->load->view('backend/' . $account_type . '/' . $page_name . '.php', $page_data);
            //echo '<script src="assets/js/neon-custom-ajax.js"></script>';
        }
        
        public function update_student_info_by_parent($student_id) {
            $page_data                  =   array();
            $this->load->model("Medical_events_model");   
            $account_type               =   $this->session->userdata('login_type');
            $page_name                  =   'modal_update_student_info_by_parent';
            $page_data['student_id']      =   $student_id;
            $student_medical_records    =   $this->Medical_events_model->get_data_generic_fun( '*' , array( 'user_id' => $student_id ));
            $student_details            =   $this->Student_model->get_student_details( $student_id ); 
            $page_data['page_title']   =    "Update Student Information";    
            
            if($student_medical_records) {
                $page_data['student_name']      =   $student_details->name;
                $page_data['class']             =   $student_details->class_name;
                $page_data['section']           =   $student_details->section_name;
                $page_data['medical_records']   =   $student_medical_records;
                $page_data['student_details']   =   $student_details;    
            } else {
                $page_data['data_not_found'] =  'Data Not Found';
            }
            $this->load->view('backend/' . $account_type . '/' . $page_name . '.php', $page_data);
            //echo '<script src="assets/js/neon-custom-ajax.js"></script>';
        }
        
        
        public function get_progress_report($student_id,$sub_category_id,$term_id) {
            $this->load->model("Progress_model");
            $progress_detail = $this->Progress_model->get_progress_detail_by_student_category($student_id,$sub_category_id,$term_id);
            $account_type           =   $this->session->userdata('login_type');
            $page_name              =   'modal_view_history_progress_report';
            $page_data              =   array();
            $page_data['progress_report']        =   $progress_detail;
//            pre($progress_detail);die;
            $this->load->view('backend/' . $account_type . '/' . $page_name . '.php', $page_data);
            //echo '<script src="assets/js/neon-custom-ajax.js"></script>';
        }

        /*
         * Student fee config during promotion
         * 
         */
        public function student_promotion_feeconfig( $student_id , $promotion_year ) {
            $page_data              =   array();
            $this->load->library('Fi_functions');
            echo $running_year           =   $promotion_year;  die();
            $scholarships           =   $this->fi_functions->getScholarships($running_year);
            if ($scholarships) {
                $page_data['scholarships'] = $scholarships;
            }
            $active_installments = $this->fi_functions->getActiveInstallments($running_year);

            $this->load->model("Dormitory_model");
            $this->load->model("Transport_model");
            $this->load->model("Student_model");

            $dormitory_array    =   $this->Dormitory_model->get_dormitory_array();
            $transport_array    =   $this->Transport_model->get_transport_array();
            $student_det        =   $this->Student_model->get_student_details($student_id);
            
            $school_fee_inst = array();
            $transp_fee_inst = array();
            $hostel_fee_inst = array();
            if ($active_installments) {
                $val = $active_installments[0];
                $school_fee_installment_ids = explode(',', $val['schoolfee_inst_types']);
                $transp_fee_installment_ids = explode(',', $val['transfee_inst_types']);
                $hostel_fee_installment_ids = explode(',', $val['hostelfee_inst_types']);

                foreach ($school_fee_installment_ids as $school_fee_inst_id) {
                    $result = $this->fi_functions->get_installments($school_fee_inst_id);
                    $school_fee_inst[] = $result[0];
                }

                foreach ($transp_fee_installment_ids as $transp_fee_inst_id) {
                    $result = $this->fi_functions->get_installments($transp_fee_inst_id);
                    $transp_fee_inst[] = $result[0];
                }

                foreach ($hostel_fee_installment_ids as $hostel_fee_inst_id) {
                    $result = $this->fi_functions->get_installments($hostel_fee_inst_id);
                    $hostel_fee_inst[]          =   $result[0];
                }
            }
            
            //get student's current fee settings.
            $running_year           =   $this->globalSettingsSMSDataArr[2]->description;
            $student_fee_sett       =   $this->fi_functions->getStudentFeeSettings( $student_id , $running_year );
            
            $stud_fee_installment           =   array('school_fee_inst' => $school_fee_inst, 'transp_fee_inst' => $transp_fee_inst, 'hostel_fee_inst' => $hostel_fee_inst);
            $page_data['fee_installment']   =   $stud_fee_installment;
            
            $student_fee_sett               =   $student_fee_sett[0];
            $page_data['student_fee_sett']  =   $student_fee_sett;
            $page_data['dormitories']       =   $dormitory_array;
            $page_data['transports']        =   $transport_array;
            $page_data['student_det']       =   $student_det;
            $account_type                   =   $this->session->userdata('login_type');
            $page_name                      =   'student_promotion_feeconfig'; //modal_view_history_progress_report
            $this->load->view('backend/' . $account_type . '/' . $page_name . '.php', $page_data);
            //echo '<script src="assets/js/neon-custom-ajax.js"></script>';
        }
            
        public function get_progress_report_subject_wise($student_id,$subject_id,$section_id) {
            $this->load->model("Progress_model");   
            $account_type           =   $this->session->userdata('login_type');
            $page_data              =   array();
            $page_name              =   'modal_progress_report_history';
            $details         =   $this->Progress_model->get_rating_history($student_id,$subject_id,$section_id );            
            $page_data['details']        =   $details;
//            pre($progress_detail);die;
            $this->load->view('backend/' . $account_type . '/' . $page_name . '.php', $page_data);
            //echo '<script src="assets/js/neon-custom-ajax.js"></script>';
        }
        
        /********************************model_school_view********************************/
            public function get_shcool_info_edit($id) {
            $this->load->model("Add_school_model");   
            $account_type           =   $this->session->userdata('login_type');
            $page_data              =   array();
            $page_name              =   'modal_school_edit';
            $details         =   $this->Add_school_model->get_info_by_id($id);            
            $page_data['details']        =   $details;
//            pre($page_data['details']);
            $this->load->view('backend/' . $account_type . '/' . $page_name . '.php', $page_data);
            //echo '<script src="assets/js/neon-custom-ajax.js"></script>';
        }    
        public function modal_edit_term($id) {

           $this->load->model('Report_term_model');
           $account_type           =   $this->session->userdata('login_type');
           $page_data              =   array();
           $page_data['term_list'] = $this->Report_term_model->get_term_data($id);
           $page_name  = "modal_edit_term";
           $this->load->view('backend/' . $account_type . '/' . $page_name . '.php', $page_data);
        //echo '<script src="assets/js/neon-custom-ajax.js"></script>';
        }
            
        public function modal_online_poll_view($poll_id) {
            if ($this->session->userdata('school_admin_login') != 1)
                redirect(base_url(), 'refresh');
            $this->load->model("Onlinepoll_model");
            $this->load->model("Class_model");
            $page_name                          =   'modal_online_poll_view';
            $page_data['page_title']            =   get_phrase('online_polls');
            $online_polls                       =   $this->Onlinepoll_model->getOninePolls( array('poll_id'=>$poll_id) );
            if(!$online_polls)
                $page_data['data_not_found']    =   'online_poll';
            $online_poll_list                   =   $online_polls;
            foreach($online_polls as $key=>$poll) {
                if($poll['classes'] != 0) {
                    $class_ids                  =   explode(',',$poll['classes']);
                    $class_name                 =   '';
                    foreach($class_ids as $class_id) {
                        $class                          =   $this->Class_model->get_name_by_id((int)$class_id);
                        $class_name                     =   $class[0]->name.",".$class_name;
                    }
                    $class_name                         =   rtrim($class_name,',');
                    $online_polls[$key]['class_name']        =   $class_name;

                } else {
                    $online_polls[$key]['class_name']        =   '';
                }
                
                $answer                             =   $this->Onlinepoll_model->getOnlinpollAnswer(array('poll_id'=>$poll['poll_id']));
                if(!$answer)
                    $answer                             =   array();
                $online_polls[$key]['answer_det']       =   $answer;
                
                $total_poll                             =   $this->Onlinepoll_model->getPollCount($poll['poll_id']);
                $online_polls[$key]['total_poll']       =   $total_poll[0]->total_poll;
            }
            
            $account_type                               =   $this->session->userdata('login_type');
            $page_data['online_polls']                  =   $online_polls[0];
//            pre($page_data['online_polls']);die();
            $this->load->view('backend/' . $account_type . '/' . $page_name . '.php', $page_data);
            //echo '<script src="assets/js/neon-custom-ajax.js"></script>';
        }
        
        public function modal_view_hw_details($hw_id) {
            if ($this->session->userdata('teacher_login') != 1) {
                $teacher_id             =   $this->session->userdata('teacher_id');
                $parent_id              =   '';
            } else if($this->session->userdata('parent_login') != 1 ){
                $parent_id              =   $this->session->userdata('parent_id');
                $teacher_id             =   '';
            }


            $this->load->model('Homeworks_model');
            
            $page_name                          =   'modal_view_hw_details';
            $page_data['page_title']            =   get_phrase('home_work_details');
            
            
            $hw_details             =   $this->Homeworks_model->get_all_data( '' , array('home_work_id'=>$hw_id));
            if(!$hw_details)
                $page_data['data_not_found']    =   'home_work';
                        
            $account_type                               =   $this->session->userdata('login_type');
            $page_data['home_work_det']                 =   $hw_details[0];
            $this->load->view('backend/' . $account_type . '/' . $page_name . '.php', $page_data);
            //echo '<script src="assets/js/neon-custom-ajax.js"></script>';


        }
        public function modal_view_hw_details_submitted($hw_id) {
           
            if ($this->session->userdata('teacher_login') != 1) {
                $teacher_id             =   $this->session->userdata('teacher_id');
                $parent_id              =   '';
            } else if($this->session->userdata('parent_login') != 1 ){
                $parent_id              =   $this->session->userdata('parent_id');
                $teacher_id             =   '';
            }


            $this->load->model('Homeworks_model');
            
            $page_name                          =   'modal_view_hw_details_submitted';
            $page_data['page_title']            =   get_phrase('home_work_details');
            
            
            $hw_details             =   $this->Homeworks_model->get_student_homework_view($hw_id);
           
            if(!$hw_details)
                $page_data['data_not_found']    =   'home_work';
                        
            $account_type                               =   $this->session->userdata('login_type');
            $page_data['home_work_det']                 =   $hw_details[0];
            //pre($page_data['home_work_det']); die; 
            
            $this->load->view('backend/' . $account_type . '/' . $page_name . '.php', $page_data);
            //echo '<script src="assets/js/neon-custom-ajax.js"></script>';


        }
        
        public function submit_home_work( $hw_id , $student_id ) {
            $parent_id              =   $this->session->userdata('parent_id');
            $this->load->model('Homeworks_model');
            $hw_details                 =   $this->Homeworks_model->get_all_data( '' , array('home_work_id'=>$hw_id));
            $page_data['student_id']    =   $student_id;
            $page_data['hw_details']    =   $hw_details[0]; //pre($hw_details);die();
            $page_name                  =   'submit_home_work';
            $page_data['page_title']    =   get_phrase('home_work_submit');
            
            $account_type                               =   $this->session->userdata('login_type');
            $this->load->view('backend/' . $account_type . '/' . $page_name . '.php', $page_data);
            //echo '<script src="assets/js/neon-custom-ajax.js"></script>';

        }

    }
    
    
  
    