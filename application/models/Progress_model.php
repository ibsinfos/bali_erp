<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    
class Progress_model extends CI_Model {


    private $_heading_table = "progress_report_heading";
    
    private $_table="progress_report";
    private $_table_class="class";
    private $_table_section="section";
    private $_table_subject="subject";
    private $_table_teacher="teacher";
    private $_table_student="student";
    private $_table_enroll="enroll";
    
    private $_primary="progress_id";
    
     var $column_order = array(null,null, 'student.name'); //set column field database for datatable orderable
    var $column_search = array('student.name'); //set column field database for datatable searchable 
    var $order = array('student.student_id' => 'asc'); // default order 

    function __construct() {
        parent::__construct();
    }

    public function save_progress($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('progress_report', $dataArray);
        $progress_id = $this->db->insert_id();
        return $progress_id;
    }

    public function save_progress_report($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('student_progress_report', $dataArray);
        $id = $this->db->insert_id();
        return $id;
    }

    public function save_progress_deatil_api($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('student_progress_report', $dataArray);
        $progress_id = $this->db->insert_id();
        return $progress_id;
    }

    public function get_rating($student_id, $subject_id, $section_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $data['student_id'] = $student_id;
        $data['subject_id'] = $subject_id;
        $ret = array();
        $this->db->select('*');
        $this->db->from('progress_report');
        $this->db->where($data);
        $this->db->order_by("progress_id", "desc");
        $query = $this->db->get();
        if ($query->num_rows() >= 1)
            $ret = $query->row();
        else
            $ret = array('rate' => "-1");
        return $ret;
    }

    public function get_rating_history($student_id, $subject_id, $section_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $data['student_id'] = $student_id;
        $data['subject_id'] = $subject_id;
        $ret = array();
        $this->db->select('*');
        $this->db->from('progress_report');
        $this->db->where($data);
        $this->db->order_by("progress_id", "desc");
        $history = $this->db->get()->result_array();
        return $history;
    }

    function get_progress_report($student_id, $subject_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('pr.school_id',$school_id);
            } 
        }
        $this->db->select('pr.subject_id,pr.student_id,pr.comment,pr.rate,pr.timestamp,su.name AS subjectname,t.name')
                ->from($this->_table." AS pr")
                ->where(array('pr.student_id' => $student_id, 'pr.subject_id' => $subject_id))                
                ->join($this->_table_subject.' AS su', 'su.subject_id = pr.subject_id')
                ->join($this->_table_teacher." AS t", 't.teacher_id = pr.teacher_id')
                ->order_by('pr.progress_id','desc');               
        $result = $this->db->get()->result_array();
        return $result;
    }

    function get_headings($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $return = array();
        $this->db->select("*");
        $this->db->from("progress_report_heading");
        if (!empty($dataArray)) {
            $this->db->where($dataArray);
        }
        $return = $this->db->get()->result_array();
        return $return;
    }

    function progress_report_detail($class_id, $student_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $headings = $this->db->get_where('progress_report_heading', array(
                    'class_id' => $class_id))->result_array();
        $all_data = array();
        foreach ($headings as $heading_key => $row_heading) {
            $all_data[$heading_key]['description'] = $row_heading['heading_description'];

            $categories1 = $this->db->get_where('progress_report_category', array('heading_id' => $row_heading['heading_id']))->result_array();

            foreach ($categories1 as $category_key => $row_category) {
                $all_data[$heading_key]['category'][$category_key]['cat_description'] = $row_category['description'];

                $this->db->select("sub_category_id,description");
                $this->db->from('progress_report_sub_category');
                $this->db->where("category_id", $row_category['category_id']);
                $sub_categories = $this->db->get()->result_array();

                if (count($sub_categories) > 0) {
                    foreach ($sub_categories as $subcategory_key => $subcat) {
                        $this->db->select("sub_category_id,exceeding_level,expected_level,emerging_level,time_stamp,comment");
                        $this->db->from("student_progress_report");
                        $this->db->where('sub_category_id', $subcat['sub_category_id']);
                        $this->db->where('student_id', $student_id);
                        $this->db->order_by('report_id', 'desc');
                        $this->db->limit('1');
                        
                        $categories = array();
                        $show_data = $this->db->get()->row();
                        if (!empty($show_data)) {
                            $categories[$subcategory_key]['sub_category_id'] = $subcat['sub_category_id'];
                            $categories[$subcategory_key]['sub_desc'] = $subcat['description'];
                            $categories[$subcategory_key]['ex'] = $show_data->exceeding_level;
                            $categories[$subcategory_key]['exp'] = $show_data->expected_level;
                            $categories[$subcategory_key]['em'] = $show_data->emerging_level;
                            $categories[$subcategory_key]['date'] = $show_data->time_stamp;
                            $categories[$subcategory_key]['comment'] = $show_data->comment;
                            $all_data[$heading_key]['category'][$category_key]['subcategory_desc'][$subcategory_key] = $categories[$subcategory_key];
                        } else {
                            $categories[$subcategory_key]['sub_category_id'] = $subcat['sub_category_id'];
                            $categories[$subcategory_key]['sub_desc'] = $subcat['description'];
                            $categories[$subcategory_key]['ex'] = "";
                            $categories[$subcategory_key]['exp'] = "";
                            $categories[$subcategory_key]['em'] = "";
                            $categories[$subcategory_key]['date'] = "";
                            $categories[$subcategory_key]['comment'] = "";
                            $all_data[$heading_key]['category'][$category_key]['subcategory_desc'][$subcategory_key] = $categories[$subcategory_key];
                        }
                    }
                }
            }
        }
        return $all_data;
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
            return $this->db->get_where($this->_table, array($this->_primary, $id))->result();
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
            $rs = $this->db->get($this->_heading_table)->result();
        } else {
            $rs = $this->db->get($this->_heading_table)->result_array();
        }

        return $rs;
    }
    
    function get_data_by_cols_groupby($table,$columnName = "*", $conditionArr = array(), $return_type = "result", $sortByArr = array(), $limit = "",$groupby='') {
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
        
        if(!empty($groupby)) {
            $this->db->group_by($groupby);
        } 

        if ($return_type == 'result') {
            $rs = $this->db->get($table)->result();
        } else {
            $rs = $this->db->get($table)->result_array();
        }

        return $rs;
    }
    

    public function update_progress_report_heading($dataArray, $conditionArray) {
        $this->db->where($conditionArray);
        $this->db->update($this->_heading_table, $dataArray);
        return true;
    }
    
    function getCategoryByHeading($table,$dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $return = array();
        $this->db->select("*");
        $this->db->from($table);
        if (!empty($dataArray)) {
            $this->db->where($dataArray);
        }
        $return = $this->db->get()->result_array();
        return $return;
    }

    function getSubcatByCategory($table,$dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $return = array();
        $this->db->select("*");
        $this->db->from($table);
        if (!empty($dataArray)) {
            $this->db->where($dataArray);
        }
        $return = $this->db->get()->result_array();
        return $return;
    }
    
    function deleteSubCat($id){
        $this->db->where('sub_category_id', $id);
        $this->db->delete('progress_report_sub_category');
    }
    
    function deleteCategory($id){
        $this->db->where('category_id', $id);
        $this->db->delete('progress_report_category');
    }
    
    function deleteHeading($id){
        $this->db->where('heading_id', $id);
        $this->db->delete('progress_report_heading');
    }
    
    public function update_progress_report_subcat($dataArray, $conditionArray) {
        $this->db->where($conditionArray);
        $this->db->update('progress_report_sub_category', $dataArray);
        return true;
    }
    
    public function update_progress_report_category($dataArray, $conditionArray) {
        $this->db->where($conditionArray);
        $this->db->update('progress_report_category', $dataArray);
        return true;
    }
    
    public function get_progress_report_data($conditionArray,$sort_by,$sort_dir){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->order_by($sort_by,$sort_dir);
        $this->db->where($conditionArray);
        $reports = $this->db->get('progress_report')->result_array();
        return $reports;
    }

    function get_progress_report_class($student_id, $class_id,$section_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('su.school_id',$school_id);
            } 
        }
        $this->db->select('pr.subject_id,pr.student_id,pr.comment,pr.rate,pr.timestamp,su.name AS subjectname,t.name')
                
                ->where(array('pr.student_id' => $student_id, 'cl.class_id' => $class_id,'se.section_id'=>$section_id))
                ->from($this->_table_subject.' AS su')
                ->join($this->_table_class.' AS cl', 'su.class_id = cl.class_id')
                ->join($this->_table_section.' AS se', 'su.section_id = se.section_id')
                ->join($this->_table_teacher." AS t", 't.teacher_id = su.teacher_id')
                ->join($this->_table." AS pr", 'su.subject_id = pr.subject_id','left');
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    function get_progress_detail_by_student_category($student_id,$sub_category_id,$term_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('student_progress_report.school_id',$school_id);
            } 
        }
        $this->db->select('student_progress_report.*,teacher.name,progress_report_sub_category.description')
            ->from('student_progress_report')
            ->where(array('student_progress_report.student_id'=>$student_id,'student_progress_report.sub_category_id'=>$sub_category_id,'student_progress_report.term_id'=>$term_id))
            ->join('progress_report_sub_category', 'progress_report_sub_category.sub_category_id = student_progress_report.sub_category_id')
            ->join('teacher', 'teacher.teacher_id = student_progress_report.teacher_id')
            ->order_by('report_id','desc');
            $progress_detail = $this->db->get()->result_array();
            return $progress_detail;
    }
    
    //Get Datatable list
     private function _get_datatables_query($class_id,$section_id,$subject_id) {      
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('enroll.school_id',$school_id);
            } 
        }
         $this->db->select("enroll.student_id,student.name,student.stud_image");
        $this->db->from('enroll');
        $this->db->join('student', 'student.student_id = enroll.student_id');
        $this->db->where("class_id", $class_id);
        $this->db->where("student.isActive", '1');
        $this->db->where("student.student_status", '1');
        $this->db->where("section_id", $section_id);
       
        $i = 0;
        foreach ($this->column_search as $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    
    
     function get_datatables($class_id,$section_id,$subject_id) {
        $list = $this->_get_datatables_query($class_id,$section_id,$subject_id);
        if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
   
    function count_filtered($class_id,$section_id,$subject_id) {
        $this->_get_datatables_query($class_id,$section_id,$subject_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function count_all($class_id,$section_id,$subject_id) 
    { 
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('enroll.school_id',$school_id);
            } 
        }
        $this->db->select("enroll.student_id,student.name,student.stud_image");
        $this->db->from('enroll');
        $this->db->join('student', 'student.student_id = enroll.student_id');
        $this->db->where("class_id", $class_id);
        $this->db->where("section_id", $section_id);
        return $this->db->count_all_results();
    }
}