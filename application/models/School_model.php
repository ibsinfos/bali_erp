<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class School_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    private $_table = "schools";
    private $_setting_table = "settings";
    
    public function save_school($data,$edata) {
        $this->db->insert('schools', $data);
        $ins = $this->db->insert_id();
        
        $settingData['type'] = 'system_name';
        $settingData['description'] = $data['name'];
        $settingData['school_id'] = $ins;
        $this->db->insert($this->_setting_table, $settingData);
        
        $settingData['type'] = 'system_title';
        $settingData['description'] = $data['name'];
        $settingData['school_id'] = $ins;
        $this->db->insert($this->_setting_table, $settingData);
        
        $settingData['type'] = 'description';
        $settingData['description'] = $data['name'];
        $settingData['school_id'] = $ins;
        $this->db->insert($this->_setting_table, $settingData);
        
        $settingData['type'] = 'keywords';
        $settingData['description'] = $data['name'];
        $settingData['school_id'] = $ins;
        $this->db->insert($this->_setting_table, $settingData);
        
        $settingData['type'] = 'address';
        $settingData['description'] = $data['addr_line1'].' '.$data['addr_line2'];
        $settingData['school_id'] = $ins;
        $this->db->insert($this->_setting_table, $settingData);
        
        $settingData['type'] = 'phone';
        $settingData['description'] = $data['mobile'];
        $settingData['school_id'] = $ins;
        $this->db->insert($this->_setting_table, $settingData);
        
        $settingData['type'] = 'running_year';
        $settingData['description'] = date('Y').'-'.date('Y',strtotime('+1 year'));
        $settingData['school_id'] = $ins;
        $this->db->insert($this->_setting_table, $settingData);
        
        // Save Business Unit in HRM
        $buData = array(
            'unitname' => $data['name'],
            'unitcode' => $ins,
            'description' => $data['name'],
            'address1' => $data['addr_line1'],
            'address2' => $data['addr_line2'],
            'service_desk_flag' => '1',
            'isactive' => '1',
            'school_id' => $ins
        ); 

        $this->db->insert('main_businessunits', $buData); 
        $ins1 = $this->db->insert_id();
        
        // Save Employee in HRM
//        $empData = array(
//            'emprole' => '2',
//            'userstatus' => 'old',
//            'firstname' => $edata['firstname'],
//            'lastname' => $edata['lastname'],
//            'userfullname' => $edata['firstname']." ".$edata['lastname'],
//            'emailaddress' => $edata['emailaddress'],
//            'emppassword' => md5('1234'),
//            'isactive' => '1',
//            'modeofentry' => 'Direct',
//            'school_id' => $ins
//        ); 
//        
//        $this->db->insert('main_users', $empData); 
//        $ins2 = $this->db->insert_id();
//        
//        $emptabledata = 
//                array(  
//                    'user_id'=>$ins2,
//                    'reporting_manager'=>'',
//                    'emp_status_id'=>'1',
//                    'businessunit_id'=>$ins1,
//                    'department_id'=>'',
//                     'school_id' => $ins
//        );
//        
//        $this->db->insert('main_employees', $emptabledata); 
//        $ins2 = $this->db->insert_id();
        
        $fiSettingData = $this->db->get_where('sys_appconfig', array('school_id' => '1'))->result_array();
        if(count($fiSettingData) > 0) {
            $dataToInsert = array();
            foreach($fiSettingData as $key => $setting) {
                unset($dataToInsert);
                $dataToInsert['setting'] = $setting['setting'];
                $dataToInsert['value'] = $setting['value'];
                if($setting['setting'] == 'CompanyName') {
                    $dataToInsert['value'] = $data['name'];
                }
                if($setting['setting'] == 'caddress') {
                    $dataToInsert['value'] = $data['addr_line1'].' '.$data['addr_line2'];
                }
                if($setting['setting'] == 'networth_goal') {
                    $dataToInsert['value'] = '0';
                }
                $dataToInsert['school_id'] = $ins;
                $this->db->insert('sys_appconfig', $dataToInsert); 
            }
        }
        return $ins;
    }
    
    public function update_school($dataArray, $id) {
        $this->db->where('school_id', $id);
        $this->db->update('schools', $dataArray);
        return true;
    }
    
    public function get_school_array($school_id = "") {
        $this->db->where(array('status' => '1'));
        if($school_id != ""){
            $this->db->where(array('school_id' => $school_id));
        }
        $this->db->order_by("name", "asc");
        $schools_array = $this->db->get('schools')->result_array(); 
        return $schools_array;
    }
    
    function get_school_by_name($school_id){
        $rs= "";
        $query= $this->db->get_where('schools', array('school_id' => $school_id));
        if($query)
            $rs = $query->row()->name;
        return $rs;
    } 
    
    
    function get_school_report(){
        $rs = array();
        $this->db->select("s.school_id, s.name as school_name, s.telephone, count(DISTINCT(class.class_id)) as total_classes,count(DISTINCT(section.section_id)) as total_sections,count(DISTINCT(student.student_id)) as total_students");
        $this->db->from("schools as s");
        $this->db->join("class", "class.school_id=s.school_id",'left' );
        $this->db->join("section", "section.school_id=s.school_id",'left');
        $this->db->join("student", "student.school_id=s.school_id",'left');
        $this->db->group_by("s.school_id");
        $query = $this->db->get();
        if($query){
            $rs = $query->result_array();
        }
        return $rs;
    }
    
    public function getSingleSchoolData($schoolId) {
        $this->db->where(array('school_id' => $schoolId));
        $schoolArray = $this->db->get('schools')->result_array();
        return $schoolArray[0];
    }
     public function get_school_record($dataArray, $column = "") {
        $return = "";
       /* pre($this->session->userdata());
        pre($_SESSION);
        if($this->session->userdata('school_id') > 0){
            $this->db->where('schools.school_id',$this->session->userdata('school_id'));
        }*/
        $class_record = $this->db->get_where('schools', $dataArray)->row();
       
        if (!empty($column) && !empty($class_record->$column)) {
            $return = $class_record->$column;
        } else {
            $return = $class_record;
        }
        return $return;
     }
     
     public function getAllSchoolsData() {
        $this->db->select('school.school_id,school.name,COUNT(student_id) AS total_students');
        $this->db->from($this->_table.' as school');
        $this->db->join('student as student' , 'school.school_id = student.school_id','LEFT');
        $this->db->group_by('student.school_id');
        return $this->db->get()->result_array();
    }
      
    
}
