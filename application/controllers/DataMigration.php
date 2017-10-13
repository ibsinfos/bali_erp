<?php
/*
 * DataMigration script from school system to finance
 */
class DataMigration extends CI_Controller
{
    function __construct() {
        parent::__construct();
        /* cache control */
        //$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        //$this->output->set_header('Pragma: no-cache');
        $this->load->model("Setting_model");
        $this->load->model("Student_model");
        $this->load->model("Class_model");
        
        $this->globalSettingsSMSDataArr=get_data_generic_fun('settings','description',array('condition_type'=>'in','condition_in_col'=>'type','condition_in_data'=>'location,app_package_name,running_year,system_name,system_email'));
    }
    /*
     * Migration of data from school system to finance module
     */
    public function migrateData() {
        $all_students               =   $this->Student_model->get_data_generic_fun();
        $count                      =   0;
        $already_exist              =   0;
        foreach( $all_students as $key => $val ) {
            $student_det            =   $this->Student_model->get_student_details( $val->student_id );
            $student_exist          =   $this->Student_model->check_finance_customer_account($val->student_id);
            if(!empty($student_det) && $student_exist == FALSE) {
                if($this->insertTocustomer($student_det)) 
                    $count++;
            } else {
                $already_exist++;
            }
        }
        $total_number_of_student    =   $count;

        $count                      =   0;
        $group_exist_count          =   0;
        $all_class                  =   $this->Class_model->get_data_generic_fun();
        foreach( $all_class as $key => $val ) {
            $group_exist            =   $this->Class_model->check_group_finance($val->class_id);
            if( $group_exist == FALSE ) {
                if($this->insertToGroup( $val ))
                    $count++;
            } else {
                $group_exist_count++;
            }
        }
        
        $total_number_of_class          =   $count;
        echo "totlStudent : ". $total_number_of_student."<br>Student already Exist : ".$already_exist."<br>Total Number of Class : ".$total_number_of_class."<br>Class Already Exist : ".$group_exist_count;
    }
    
    public function insertTocustomer( $data ) {
        $data3['id']                =  $data->student_id;
        $data3['account']           =  $data->name;
        $data3['fname']             =  '';
        $data3['company']           =  $data->father_name." ".$data->father_lname;
        $data3['parent_email']      =  $data->par_email;
        $data3['lname']             =  $data->lname;
        $data3['gid']               =  $data->class_id;
        $data3['section_id']        =  $data->section_id;
        $data3['email']             =  $data->email;
        $data3['address']           =  $data->address;
        $data3['phone']             =  $data->phone;
        $data3['city']              =  $data->location;
        $data3['password']          =  $data->student_pass;
        $data3['school_id']         =  $data->school_id;
        return $this->Student_model->create_finance_customer_account( $data3 );
    }
    
    public function insertToGroup( $data ) {
//        echo crypt( '1234' , 'ib_salt' );die();
        $group_data     =   array( 'id' => $data->class_id ,'gname' => $data->name , 'sorder' => $data->class_id );
        return  $this->Class_model->add_group_finance( $group_data );
    }
    
    public function updateStudent_inFinance() {
        $this->load->library('Fi_functions');
        $all_students               =   $this->Student_model->get_data_generic_fun();
        $count                      =   0;
        $already_exist              =   0;
        foreach( $all_students as $key => $val ) { 
            $student_det            =   $this->Student_model->get_student_details( $val->student_id );
            $student_id             =   $val->student_id;
            if($student_det->section_id != NULL) {
                $student_data           =   array('section_id'=>$student_det->section_id);
                if($this->fi_functions->updateStudent_inFinance( $student_id , $student_data ))
                    $count++;
            }
        }
    }
}


?>