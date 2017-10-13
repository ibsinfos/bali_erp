<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Subject_model extends CI_Model {

    private $_table = "subject";

    function __construct() {
        parent::__construct();
    }

    public function get_subject_array($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $return = array();
        $this->db->select("*");
        $this->db->from("subject");
        if (!empty($dataArray)) {
            $this->db->where($dataArray);
        }
        $return = $this->db->get()->result_array();
        return $return;
    }

   

    public function get_subject_name($subject_id, $class_id, $section_id)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $subjectSQL="SELECT * FROM `subject` WHERE `name` LIKE '%".trim($subject_id)."%' AND `class_id`='".$class_id."' AND `section_id`= '".$subject_id."' AND school_id = '".$school_id."'";
            } 
        } else {
            $subjectSQL="SELECT * FROM `subject` WHERE `name` LIKE '%".trim($subject_id)."%' AND `class_id`='".$class_id."' AND `section_id`= '$subject_id'";
        }
        
        return $this->db->query($subjectSQL)->result();
    }
    
    public function get_subjects_class_section1($class_id, $section_id) {
        //$sql = "select * from subject where class_id=$class_id and section_id = $section_id";
        $sql="";
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql = "select * from subject where class_id='".$class_id."' and section_id = '".$section_id."' and school_id = '".$school_id."'";
            } 
        } else {
            $sql = "select * from subject where class_id=$class_id and section_id = $section_id";
        }
        if($sql!="")
            $rs = $this->db->query($sql)->result_array();
        else
            return array();
        return $rs;
    }

    public function get_subject_record($dataArray, $column = "") {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $return = "";
        $subject_record = $this->db->get_where('subject', $dataArray)->row();
        if (!empty($column) && isset($subject_record->$column)) {
            $return = $subject_record->$column;
        } else {
            $return = $subject_record;
        }
        return $return;
    }

    public function save_subject($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('subject', $dataArray);
        $subject_id = $this->db->insert_id();
        return $subject_id;
    }

    public function update_subject($dataArray, $condition) {
        $this->db->where($condition);
        $this->db->update('subject', $dataArray);
        return true;
    }

    public function delete_subject($dataArray) {
        $this->db->where($dataArray);
        $this->db->delete('subject');
        return true;
    }

    public function get_all_subject() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        
        $return = array();
        $this->db->select("*");
        $this->db->from("subject");
        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_subjects($class_id, $teacher_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql = "SELECT distinct section.name,section.section_id FROM subject s join section section on(s.section_id=section.section_id) where s.teacher_id='".$teacher_id."' and s.class_id='".$class_id."' and s.school_id = '".$school_id."' order by section.name";
            } 
    } else {
        $sql = "SELECT distinct section.name,section.section_id FROM subject s join section section on(s.section_id=section.section_id) where s.teacher_id=$teacher_id and s.class_id=$class_id order by section.name";
    }
        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }

    public function get_all_subjects($conditionArr) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('sub.school_id',$school_id);
            } 
        }
        $return = array();
        $this->db->select(' sub.*,tea.name as teacher_name, tea.last_name as lastname, tea.email, tea.cell_phone,class.name as class_name,section.name as section_name ');
        $this->db->from('subject as sub');
        $this->db->join('teacher as tea', 'tea.teacher_id = sub.teacher_id');
        $this->db->join('class as class', 'class.class_id = sub.class_id');
        $this->db->join('section as section', 'section.section_id = sub.section_id');
        if (!empty($conditionArr)) {
            $this->db->where($conditionArr);
        }
        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_all_subjects_by_teacher($teacher_id) {
        $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                    $this->db->where('sub.school_id',$school_id);
                } 
            }
        $return = array();
        $this->db->select('sub.*,te.name as teacher_name ,cls.class_id, cls.name as class_name, sec.section_id, sec.name as section_name ');
        $this->db->from('subject as sub');
        $this->db->join('class as cls', ' cls.class_id = sub.class_id ');
        $this->db->join('section as sec', ' sec.section_id = sub.section_id');
        $this->db->join('teacher as te', ' te.teacher_id = sub.teacher_id');
        $this->db->where('sub.teacher_id', $teacher_id);
        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_subjects_class_section($class_id, $section_id) {
        $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                    $sql = "SELECT s.*,c.name as class_name,se.name as section_name,t.name as teacher_name,t.middle_name,t.last_name, t.email, t.cell_phone FROM subject s join class c on(c.class_id=s.class_id) join section se on(s.section_id=se.section_id) join teacher t on(s.teacher_id=t.teacher_id) where s.class_id='".$class_id."' and s.section_id='".$section_id."' and s.school_id = '".$school_id."'";
                } 
            } else {
        $sql = "SELECT s.*,c.name as class_name,se.name as section_name,t.name as teacher_name,t.middle_name,t.last_name, t.email, t.cell_phone FROM subject s join class c on(c.class_id=s.class_id) join section se on(s.section_id=se.section_id) join teacher t on(s.teacher_id=t.teacher_id) where s.class_id='".$class_id."' and s.section_id='".$section_id."'";
            }
        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }

    public function get_classes_by_teacher($teacher_id = '') {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('sub.school_id',$school_id);
            } 
        }
        $this->db->select('DISTINCT(sub.class_id), cls.name as class_name');
        $this->db->from('subject as sub');
        $this->db->join('class as cls', ' cls.class_id = sub.class_id ');
        $this->db->where('sub.teacher_id', $teacher_id);
        
        $return = $this->db->get()->result_array();
        
        return $return;
    }

    public function get_subject_by_class_teacher_api($class_id, $subjectId) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('sub.school_id',$school_id);
            } 
        }
        $this->db->select('sub.subject_id,sub.name as subject_name, cls.name as class_name,t.name as teacher_name');
        $this->db->from('subject as sub');
        $this->db->join('class as cls', ' cls.class_id = sub.class_id ');
        $this->db->join('teacher as t', ' t.teacher_id = sub.teacher_id ');
        $this->db->where('sub.class_id', $class_id, 'sub.subjectId', $subjectId);
        $return = $this->db->get()->result_array();
        return $return;
    }

    function get_batch_subject_details($class_id = "", $student_running_year = "") {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql = "select subject.name as subject_name,teacher.name as teacher_name,count(class_routine.day) as periods from subject left join teacher on(subject.teacher_id=teacher.teacher_id) left join class_routine on(subject.subject_id=class_routine.subject_id) where subject.class_id='".$class_id."' and subject.year='".$student_running_year."' and subject.school_id = '".$school_id."' group by subject.subject_id";
            } 
        } else {
            $sql = "select subject.name as subject_name,teacher.name as teacher_name,count(class_routine.day) as periods from subject left join teacher on(subject.teacher_id=teacher.teacher_id) left join class_routine on(subject.subject_id=class_routine.subject_id) where subject.class_id=$class_id and subject.year='$student_running_year' group by subject.subject_id";
        }
        $rsStudent = $this->db->query($sql)->result_array();
        return $rsStudent;
    }

    function get_batch_subject_teacher_count($class_id = "", $student_running_year = "") {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql = "select count(subject.subject_id) as count_subject,count(teacher.teacher_id) as count_teacher from subject join teacher on(subject.teacher_id=teacher.teacher_id) where subject.class_id='".$class_id."' and subject.year='".$student_running_year."' and subject.school_id = '".$school_id."'";
            } 
        } else {
            $sql = "select count(subject.subject_id) as count_subject,count(teacher.teacher_id) as count_teacher from subject join teacher on(subject.teacher_id=teacher.teacher_id) where subject.class_id=$class_id and subject.year='$student_running_year'";
        }
        $rsStudent = $this->db->query($sql)->result_array();
        return $rsStudent;
    }

    function get_subject_dashboard($class_id, $section_id, $running_year) {
        $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                    $sql = "SELECT subject.subject_id,subject.name as subject_name, teacher.name as teacher_name,count(class_routine.class_routine_id) as period from subject as subject left join teacher as teacher on(subject.teacher_id=teacher.teacher_id) left join class_routine as class_routine on(subject.subject_id=class_routine.subject_id and subject.class_id=class_routine.class_id and subject.section_id=class_routine.section_id) where subject.class_id='".$class_id."' and subject.section_id='".$section_id."' and subject.year='".$running_year."' and subject.school_id = '".$school_id."' GROUP by subject.subject_id";
                } 
            } else {
                $sql = "SELECT subject.subject_id,subject.name as subject_name, teacher.name as teacher_name,count(class_routine.class_routine_id) as period from subject as subject left join teacher as teacher on(subject.teacher_id=teacher.teacher_id) left join class_routine as class_routine on(subject.subject_id=class_routine.subject_id and subject.class_id=class_routine.class_id and subject.section_id=class_routine.section_id) where subject.class_id=$class_id and subject.section_id=$section_id and subject.year='$running_year' GROUP by subject.subject_id";
            }
        
        $rsStudent = $this->db->query($sql)->result_array();
        return $rsStudent;
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    function get_data_by_id($id, $returnColsStr = "") {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        if ($returnColsStr == "") {
            return $this->db->get_where($this->_table, array($this->_primary=>$id))->result();
        } else {
            return $this->db->select($returnColsStr)->from($this->_table)->where($this->_primary, $id)->get()->result();
        }
    }

    /**
     * 
     * @param type $columnName
     * @param type $conditionArr
     * @param type $return_type="result"
     * @return type
     * example it will use in controlelr
     * 
     * =====bellow is for * data without conditions======
     * get_data_generic_fun('parent','*');
     *  =====bellow is for * data witht conditions======
     * get_data_generic_fun('parent','*',array('column1'=>$column1Value,'column2'=>$column2Value));
     * 
     * =====bellow is for 1 or more column data without conditions======
     * get_data_generic_fun('parent','column1,column2,column3');
     *  =====bellow is for 1 or more column data with conditions======
     * get_data_generic_fun('parent','column1,column2,column3',array('column1'=>$column1Value,'column2'=>$column2Value));
     *  =====bellow is for 1 or more column data with conditions and return as result all======
     * get_data_generic_fun('parent','column1,column2,column3',array('column1'=>$column1Value,'column2'=>$column2Value),'result_arr');
     * 
     * ==== modification for  adding sortby and limit and add conditionArr for AND -- OR -- IN ---
     * get_data_generic_fun('parent','parent_id,passcode',array('passcode'=>$passcoad,'device_token'=>$deviceToken,'condition_type'=>'or'),array('parrent_id'=>'asc','date_time'=>'desc'),1);
     */

    function single_name($subject_id)
    {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
       return $this->db->get_where($this->_table, array('subject_id' => $subject_id))->row()->name;
    }

    function get_data_by_cols($columnName = "*", $conditionArr = array(), $return_type = "result", $sortByArr = array(), $limit = "") {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        
        $this->db->select($columnName);
        $condition_type = 'and';
        if (array_key_exists('condition_type', $conditionArr)) {
            if ($conditionArr['condition_type'] != "") {
                $condition_type = $conditionArr['condition_type'];
            }
        }
        unset($conditionArr['condition_type']);
        $condition_in_data_arr = array();
        $startCounter = 0;
        $condition_in_column = "";
        foreach ($conditionArr AS $k => $v) {
            if ($condition_type == 'in') {
                if (array_key_exists('condition_in_data', $conditionArr)) {
                    $condition_in_data_arr = explode(',', $conditionArr['condition_in_data']);
                    $condition_in_column = $conditionArr['condition_in_col'];
                }
            } elseif ($condition_type == 'or') {
                if ($startCounter == 0) {
                    $this->db->where($k, $v);
                } else {
                    $this->db->or_where($k, $v);
                }
            } elseif ($condition_type == 'and') {
                $this->db->where($k, $v);
            }
            $startCounter++;
        }

        if ($condition_type == 'in') {
            if (!empty($condition_in_data_arr))
                $this->db->where_in($condition_in_column, $condition_in_data_arr);
        }

        if ($limit != "") {
            $this->db->limit($limit);
        }

        foreach ($sortByArr AS $key => $val) {
            $this->db->order_by($key, $val);
        }

        if ($return_type == 'result') {
            $rs = $this->db->get($this->_table)->result();
        } else {
            $rs = $this->db->get($this->_table)->result_array();
        }
        //echo $this->db->last_query(); die();
        return $rs;
    }
    
    function get_c_year_details_by_class($class_id,$year){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->get_where($this->_table , array('class_id' => $class_id , 'year' => $year))->result_array();
    }
    
    function get_c_year_total_subject_by_class($class_id,$year){
        
        $rs= $this->get_c_year_details_by_class($class_id, $year);
        return count($rs);
    }

    function get_average_grade_point($class_id, $running_year){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->where('class_id' , $class_id);
        $this->db->where('year' , $running_year);
        $this->db->from($this->_table);
        return $this->db->count_all_results();
    }
    
    function get_subject_list_online_exam($class_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('sub.school_id',$school_id);
            } 
        }
        $this->db->select('sub.subject_id,sub.name as subject_name, cls.name as class_name,sec.name as section_name,sec.section_id,cls.class_id');
        $this->db->from('subject as sub');
        $this->db->join('class as cls', ' cls.class_id = sub.class_id ');
        $this->db->join('section as sec', 'sec.section_id = sub.section_id ');
        $this->db->where('sub.class_id', $class_id);
        $return = $this->db->get()->result_array();
        return $return;
   
    } 
    
        function get_all_exam_subject_marks($class_id, $student_id,$running_year) {
            $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                    $this->db->where('school_id',$school_id);
                } 
            }
           $exam =  $this->crud_model->get_exams();
           $subject = $this->db->get_where('subject' , array('class_id' => $class_id , 'year' => $running_year))->result_array();
           
           $marks = array();
           $list = array();
           
           foreach($exam as $exam_key => $exam):
                $total_grade_point = 0;
                $list[$exam_key]['exam_name'] = $exam['name']; 
                $list[$exam_key]['exam_id'] = $exam['exam_id']; 
            foreach($subject as $sub_key => $sub):
                $list[$exam_key]['subject'][$sub_key]['subject_name'] = $sub['name'];               
                $obtained_mark_query = $this->db->get_where("mark" , array('subject_id' => $sub['subject_id'],'exam_id' => $exam['exam_id'],'class_id' => $class_id,'student_id' => $student_id ,'year' => $running_year))->row();
//                pre($obtained_mark_query); die;
                if(!empty($obtained_mark_query)){ 
                    $list[$exam_key]['subject'][$sub_key]['highest_mark'] = $this->crud_model->get_highest_marks( $exam['exam_id'] , $class_id , $sub['subject_id'] );
                    if ($obtained_mark_query->mark_obtained >= 0 || $obtained_mark_query->mark_obtained != '') {
                        $grade = $this->crud_model->get_grade($obtained_mark_query->mark_obtained);
                        $list[$exam_key]['subject'][$sub_key]['grade_name'] = $grade?$grade['name']:'';
                        $total_grade_point += $grade['grade_point'];
                    }
                    
                    $list[$exam_key]['subject'][$sub_key]['mark_obtained'] = $obtained_mark_query->mark_obtained;
                    $list[$exam_key]['subject'][$sub_key]['mark_total'] = $obtained_mark_query->mark_total;
                    $list[$exam_key]['subject'][$sub_key]['comment'] = $obtained_mark_query->comment;
                }else{
                    $list[$exam_key]['subject'][$sub_key]['highest_mark'] = "";
                    $list[$exam_key]['subject'][$sub_key]['mark_obtained'] = "";
                    $list[$exam_key]['subject'][$sub_key]['mark_total'] = "";
                    $list[$exam_key]['subject'][$sub_key]['comment'] = "";
                    $list[$exam_key]['subject'][$sub_key]['grade_name'] = "";
                }       
                
            endforeach;
//         pre($list); die;
//            pre($list); die;
           $list[$exam_key]['grade_point']  = $total_grade_point;
          
        endforeach;
//        pre($list); die;
        return $list;
    }
    
    public function get_exam_subject_array($dataArray, $grading) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('subject.school_id',$school_id);
            } 
        }
         $grading_method = $grading['grading_method'];

         if($grading_method == 3){
            $class_id = $dataArray['class_id'];
            $section_id = $dataArray['section_id'];
            $return = array();
            $this->db->select("*");
            $this->db->from("subject");
            $this->db->join("cwa_subjects", 'cwa_subjects.subject_id = subject.subject_id');
            $this->db->where('cwa_subjects.no_exam',0);
            if (!empty($dataArray)) {
                $this->db->where($dataArray);
            }
            $return = $this->db->get()->result_array();

            return $return;
         }else if($grading_method == 4){
            $class_id = $dataArray['class_id'];
            $section_id = $dataArray['section_id'];
            $return = array();
            $this->db->select("*");
            $this->db->from("subject");
            $this->db->join("gpa_subjects", 'gpa_subjects.subject_id = subject.subject_id');
            $this->db->where('gpa_subjects.no_exam',0);
            if (!empty($dataArray)) {
                $this->db->where($dataArray);
            }
            $return = $this->db->get()->result_array();
            //echo $this->db->last_query(); exit;
            return $return;
         }else if($grading_method == 5){
            $class_id = $dataArray['class_id'];
            $section_id = $dataArray['section_id'];
            $return = array();
            $this->db->select("*");
            $this->db->from("subject");
            $this->db->join("icse_subjects", 'icse_subjects.subject_id = subject.subject_id');
            if (!empty($dataArray)) {
                $this->db->where($dataArray);
            }
            $return = $this->db->get()->result_array();
            //echo $this->db->last_query(); exit;
            return $return;
         }else if($grading_method == 7){
            $class_id = $dataArray['class_id'];
            $section_id = $dataArray['section_id'];
            $return = array();
            $this->db->select("*");
            $this->db->from("subject");
            $this->db->join("igcse_subjects", 'igcse_subjects.subject_id = subject.subject_id');
            if (!empty($dataArray)) {
                $this->db->where($dataArray);
            }
            $return = $this->db->get()->result_array();
            echo $this->db->last_query(); exit;
            return $return;
         }else{
            $class_id = $dataArray['class_id'];
            $section_id = $dataArray['section_id'];
            $return = array();
            $this->db->select("*");
            $this->db->from("subject");
            $this->db->join("cce_subjects", 'cce_subjects.subject_id = subject.subject_id');
            $this->db->where('cce_subjects.no_exam',0);
            if (!empty($dataArray)) {
                $this->db->where($dataArray);
            }
            $return = $this->db->get()->result_array();
            //echo $this->db->last_query(); exit;
            return $return;
         }
        
    }

    public function marks_get_subject($class_id='', $section_id=''){
        $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                    $this->db->where('subject.school_id',$school_id);
                } 
            }
        $year = $this->globalSettingsRunningYear; 
        
        $this->db->select('*');
        $this->db->from('subject');
        $this->db->join('cce_subjects', 'subject.subject_id = cce_subjects.subject_id');
        if(!empty($class_id)){
            $this->db->where('subject.class_id',$class_id);
        }
        if(!empty($section_id)){
            $this->db->where('subject.section_id',$section_id);
        }
        $this->db->where('subject.year',$year);
        $this->db->where('cce_subjects.no_exam',0);
        $subjects =  $this->db->get()->result_array();

        if(count($subjects) == ''){
            
            $this->db->select('*');
            $this->db->from('subject');
            if(!empty($class_id)){
                $this->db->where('subject.class_id',$class_id);
            }
            if(!empty($section_id)){
                $this->db->where('subject.section_id',$section_id);
            }
            $this->db->where('subject.year',$year);
            $subjects_normal =  $this->db->get()->result_array();
              
            return $subjects_normal;
        }else{
            
            return $subjects;
        }
    }

    public function marks_get_cwa_subject($class_id='', $section_id=''){
        $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                    $this->db->where('subject.school_id',$school_id);
                } 
            }
        $year = $this->globalSettingsRunningYear; 
        $this->db->select('*');
        $this->db->from('subject');
        $this->db->join('cwa_subjects', 'subject.subject_id = cwa_subjects.subject_id');
        if(!empty($class_id)){
            $this->db->where('subject.class_id',$class_id);
        }
        if(!empty($section_id)){
            $this->db->where('subject.section_id',$section_id);
        }
        $this->db->where('subject.year',$year);
        $this->db->where('cwa_subjects.no_exam',0);
        return $this->db->get()->result_array();
    }
    
    public function get_grading_subject($grading_table){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('s.school_id',$school_id);
            } 
        }
        $rs=$this->db->select('s.name,s.subject_id')->from($grading_table.' AS gt')->join($this->_table.' AS s','gt.subject_id=s.subject_id')->where('gt.no_exam',0)->get()->result_array();
        return $rs;
    }
    function get_subject_online_exam($exam_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql="SELECT subject.name as subject_name FROM questions as questions JOIN subject as subject on(questions.subject_id=subject.subject_id) where questions.exam_id='".$exam_id."' and questions.school_id = '".$school_id."' GROUP BY subject.subject_id";
            } 
        } else {
            $sql="SELECT subject.name as subject_name FROM questions as questions JOIN subject as subject on(questions.subject_id=subject.subject_id) where questions.exam_id=$exam_id GROUP BY subject.subject_id";
        }
        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }

    public function marks_get_gpa_subject($class_id='', $section_id=''){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('subject.school_id',$school_id);
            } 
        }
        $year = $this->globalSettingsRunningYear; 
        $this->db->select('*');
        $this->db->from('subject');
        $this->db->join('gpa_subjects', 'subject.subject_id = gpa_subjects.subject_id');
        if(!empty($class_id)){
            $this->db->where('subject.class_id',$class_id);
        }
        if(!empty($section_id)){
            $this->db->where('subject.section_id',$section_id);
        }
        $this->db->where('subject.year',$year);
        $this->db->where('gpa_subjects.no_exam',0);
        return $this->db->get()->result_array();
    }
    
    public function automatic_timetable_get_all_subjecs(){
        $year=$this->globalSettingsRunningYear;
        $sql = "SELECT s.subject_id subject_id,c.name class_name, sc.name section_name, s.name subject_name, s.section_id section_id, s.class_id class_id FROM subject s, section sc, class c WHERE c.class_id = s.class_id AND sc.section_id = s.section_id AND s.subject_id in (SELECT subject_id FROM schedule_restriction_info WHERE year='$year')";
        $rs= $this->db->query($sql)->result_array();
        return $rs;
    }

    public function marks_get_icse_subject($class_id='', $section_id=''){
        $school_id = '';
            if(($this->session->userdata('school_id'))) {
                $school_id = $this->session->userdata('school_id');
                if($school_id > 0){
                    $this->db->where('subject.school_id',$school_id);
                } 
            }
        $year = $this->globalSettingsRunningYear; 
        $this->db->select('*');
        $this->db->from('subject');
        $this->db->join('icse_subjects', 'subject.subject_id = icse_subjects.subject_id');
        if(!empty($class_id)){
            $this->db->where('subject.class_id',$class_id);
        }
        if(!empty($section_id)){
            $this->db->where('subject.section_id',$section_id);
        }
        $this->db->where('subject.year',$year);
        return $this->db->get()->result_array();
    }
}

