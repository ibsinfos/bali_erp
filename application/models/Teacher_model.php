<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Teacher_model extends CI_Model {

    private $_table = 'teacher';
    private $_table_subject = 'subject';
    private $_table_class = 'class';
    private $_table_user_role_transaction = 'user_role_transaction';
    var $table = 'teacher';
    var $column_order = array(null, 'name', 'last_name', 'email', 'cell_phone'); //set column field database for datatable orderable
    var $column_search = array('name', 'last_name', 'email', 'cell_phone'); //set column field database for datatable searchable 
    var $order = array('teacher_id' => 'asc'); // default order 

    function __construct() {
        parent::__construct();
    }

    public function get_teacher_array() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->where(array('isActive' => '1'));
        $this->db->order_by("name", "asc");
        $teachers_array = $this->db->get('teacher')->result_array();
        return $teachers_array;
    }

    public function get_teacher_list($school_id) {
        $this->db->where('school_id',$school_id);
        $this->db->select('teacher_id id, name fname, middle_name mname, last_name lname, email, cell_phone');
        $this->db->where(array('isActive' => '1', 'teacher_status' => '1'));
        $this->db->order_by("name", "asc");
        $data = $this->db->get($this->_table)->result_array();

        if(count($data)){
            foreach($data as $k => $datum){
                $where = array('original_user_type' => 'T', 'main_user_id' => $datum['id'], 'school_id'=>$school_id);
                $this->db->from($this->_table_user_role_transaction);
                $this->db->where($where);
                $query = $this->db->get();
                $exist = $query->num_rows();
                if($exist){
                    $role_id = $query->row()->role_id;
                    $data[$k]['role_id'] = $role_id;
                }else{
                    $data[$k]['role_id'] = '';
                }
            }
        }
        return $data;
    }

    public function get_teacher_record($dataArray, $column = "") {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $return = "";
        $teacher_record = $this->db->get_where('teacher', $dataArray)->row();
        if (!empty($column) && !empty($teacher_record->$column)) {
            $return = $teacher_record->$column;
        } else {
            $return = $teacher_record;
        }
        return $return;
    }

    public function save_teacher($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->set(array('user_type'=>'t'));
        $this->db->insert('teacher', $dataArray);
        $teacher_id = $this->db->insert_id();
        return $teacher_id;
    }

    public function update_teacher($dataArray, $id) {
        $this->db->where('teacher_id', $id);
        $this->db->update('teacher', $dataArray);
        return true;
    }

    public function delete_teacher($dataArray) {
        $this->db->where($dataArray);
        $this->db->update('teacher', array('isActive' => '0', 'change_time' => date('Y-m-d H:i:s')));
    }

    public function add_from_hrm($dataArray) {
        //$school_id = '';
        /*if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }*/
        $this->db->insert('teacher', $dataArray);
        generate_log($this->db->last_query());
        $teacher_id = $this->db->insert_id();
        $arrLink = array();
        $arrLink['main_user_id'] = $teacher_id;
        $arrLink['role_id'] = 2;
        $arrLink['user_type'] = "T";
        $arrLink['original_user_type'] = "T";
        $arrLink['school_id'] = 1;
        
        $this->db->insert('user_role_transaction', $arrLink);
        return $teacher_id;
    }

    function is_new_teacher_exists($email, $cell_phone) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $rs = $this->get_data_generic_fun('*', array('email' => $email, 'cell_phone' => $cell_phone, 'isActive' => "1", 'condition_type' => 'and','school_id' => $school_id));
            } 
        } else {
            $rs = $this->get_data_generic_fun('*', array('email' => $email, 'cell_phone' => $cell_phone, 'isActive' => "1", 'condition_type' => 'and'));
        }
        if (count($rs) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function get_teacher_by_name($teacher_name)
    {


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
     * $this->Parent_model->get_data_generic_fun('*');
     *  =====bellow is for * data witht conditions======
     * $this->Parent_model->get_data_generic_fun('*',array('column1'=>$column1Value,'column2'=>$column2Value));
     * 
     * =====bellow is for 1 or more column data without conditions======
     * $this->Parent_model->get_data_generic_fun('column1,column2,column3');
     *  =====bellow is for 1 or more column data with conditions======
     * $this->Parent_model->get_data_generic_fun('column1,column2,column3',array('column1'=>$column1Value,'column2'=>$column2Value));
     *  =====bellow is for 1 or more column data with conditions and return as result all======
     * $this->Parent_model->get_data_generic_fun('column1,column2,column3',array('column1'=>$column1Value,'column2'=>$column2Value),'result_arr');
     * 
     * ==== modification for  adding sortby and limit and add conditionArr for AND -- OR -- IN ---
     * $this->Parent_model->get_data_generic_fun('parent_id,passcode',array('passcode'=>$passcoad,'device_token'=>$deviceToken,'condition_type'=>'or'),array('parrent_id'=>'asc','date_time'=>'desc'),1);
     */
    function get_data_generic_fun($columnName = "*", $conditionArr = array(), $return_type = "result", $sortByArr = array(), $limit = "") {
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
        $inConditionStr = "";
        $startCounter = 0;
        foreach ($conditionArr AS $k => $v) {
            if ($condition_type == 'in') {
                if ($inConditionStr == "") {
                    $inConditionStr = $v;
                } else {
                    $inConditionStr .= "," . $v;
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
            $this->db->where_in($inConditionStr);
        }

        if ($limit != "") {
            $this->db->limit($limit);
        }

        foreach ($sortByArr AS $key => $val) {
            $this->db->order_by($key, $val);
        }

        if ($return_type == 'result')
            $rs = $this->db->get($this->_table)->result();
        else
            $rs = $this->db->get($this->_table)->result_array();
        generate_log("comming here === " . $this->db->last_query());
        return $rs;
    }

    public function search_teachers($seacrh_term) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->like('name', $seacrh_term);
        $result = $this->db->select('teacher_id,name')->from('teacher')->get()->result_array();
        return $result;
    }

    function get_teacher_by_subject($subject_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('t.school_id',$school_id);
            } 
        }
        $this->db->select('t.*')->from($this->_table . " AS t")->join($this->_table_subject . " AS s", "t.teacher_id=s.teacher_id");
        $rs = $this->db->where("s.subject_id", $subject_id)->get()->result_array();
        return $rs;
    }

    function get_teacher_by_subject_class($subject_id, $class_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('t.school_id',$school_id);
            } 
        }
        $this->db->select('t.*')->from($this->_table . " AS t")->join($this->_table_subject . " AS s", "t.teacher_id=s.teacher_id");
        $rs = $this->db->where("s.subject_id", $subject_id)->where("s.class_id", $class_id)->get()->result_array();
        return $rs;
    }

    function get_teacher_by_class_for_report($subject_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('t.school_id',$school_id);
            } 
        }
        $rs = $this->db->select("t.*")->from("teacher AS t")->join("subject AS s", "s.teacher_id=t.teacher_id")->where("s.subject_id", $subject_id)->get()->result_array();
        return $rs;
    }

    public function get_list_teacher_by_subject() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('sub.school_id',$school_id);
            } 
        }
        $this->db->select("sub.name as subject, tea.teacher_id, tea.name as teacher_name, cls.name as class_name, sec.name as section_name");
        $this->db->from(' subject` as sub');
        $this->db->join('teacher as tea', 'tea.teacher_id = sub.teacher_id');
        $this->db->join('class as cls', ' cls.class_id = sub.class_id ');
        $this->db->join('section as sec', ' sec.section_id = sub.section_id');
        $this->db->where('tea.teacher_id = sub.teacher_id');
        $this->db->order_by("tea.name", "asc");
        $res = $this->db->get()->result_array();
        return $res;
    }

    function get_progress_report_by_teacher($section_id, $class_id, $subject_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->select("enroll.student_id,student.name,student.stud_image");
        $this->db->from('enroll');
        $this->db->join('student', 'student.student_id = enroll.student_id');
        $this->db->where("class_id", $class_id);
        $this->db->where("section_id", $section_id);
        $student_ids = $this->db->get()->result_array();
//           pre($student_ids);die;
        $students = array();
        $list = array();
        foreach ($student_ids as $student_id) {
            $list['student_name'] = $student_id['name'];
            $list['stud_image'] = $student_id['stud_image'];

            $this->db->select("*");
            $this->db->from("progress_report");
            $this->db->where('subject_id', $subject_id);
            $this->db->where('student_id', $student_id['student_id']);
            $this->db->order_by('progress_id', 'desc');
            $this->db->limit(1);
            $query = $this->db->get()->row();

            if (!empty($query)) {
                $list['rate'] = $query->rate;
                $list['comment'] = $query->comment;
            } else {
                $list['rate'] = 0;
                $list['comment'] = "";
            }
            $students[] = $list;
        }
//        pre($students);
//        die;

        return $students;
    }

    function get_progress_report_detail($section_id, $class_id, $headingId, $studentId) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        
        $categories = $this->db->get_where('progress_report_category', array(
                    'heading_id' => $headingId))->result_array();
        $list = array();
        $result = array();
        $data = array();
        $all_data = array();
        $k = 0;
        $c = 0;
        foreach ($categories as $row) {
            $all_data[$c]['category_id'] = $row['category_id'];
            $all_data[$c]['category_des'] = $row['description'];

            $this->db->select("sub_category_id,description");
            $this->db->from('progress_report_sub_category');
            $this->db->where("category_id", $row['category_id']);
            $sub_categories = $this->db->get()->result_array();
//                           pre($sub_categories);die;
            if (count($sub_categories) > 0) {
                foreach ($sub_categories as $subcat) {
                    $this->db->select("sub_category_id,exceeding_level,expected_level,emerging_level,time_stamp,comment");
                    $this->db->from("student_progress_report");
                    $this->db->where('sub_category_id', $subcat['sub_category_id']);
                    $this->db->where('student_id', $studentId);
                    $this->db->group_by('report_id', 'desc');

                    $show_data = $this->db->get()->row();
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
        return $all_data;
    }

    function get_teacher_ajax($class_id, $section_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $sql = "SELECT DISTINCT s.teacher_id,t.name as teacher_name,t.teacher_id FROM subject s join teacher t on(s.teacher_id=t.teacher_id) where s.class_id='".$class_id."' and s.section_id='".$section_id."' AND s.school_id = '".$school_id."'";
            } 
        } else {
            $sql = "SELECT DISTINCT s.teacher_id,t.name as teacher_name,t.teacher_id FROM subject s join teacher t on(s.teacher_id=t.teacher_id) where s.class_id=$class_id and s.section_id=$section_id";
        }
        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }

    public function save_heading($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('progress_report_heading', $dataArray);
    }

    public function save_ctegory($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('progress_report_category', $dataArray);
    }

    public function save_sub_ctegory($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        $this->db->insert('progress_report_sub_category', $dataArray);
    }

    public function get_heading($class_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $sql = "SELECT * FROM progress_report_heading where class_id='".$class_id."' AND school_id = '".$school_id."'";
            } 
        } else {
            $sql = "SELECT * FROM progress_report_heading  where class_id=$class_id";
        }
        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }

    /* public function get_total_teachers() {
      $total_teachers = $this->db->where('isActive', '1')->from("teacher")->count_all_results();
      return $total_teachers;
      }

      public function get_all_teachers($requestData) {
      $columns = array(
      // datatable column index  => database column name
      0 => 'sl_no',
      1 => 'name',
      2 => 'email',
      3 => 'cell_phone',
      4 => 'teacher_id'
      );

      $this->db->select('*');
      $this->db->from('teacher');
      if (!empty($requestData['search']['value'])) {
      $this->db->like('name', $requestData['search']['value']);
      $this->db->or_like('email', $requestData['search']['value']);
      $this->db->or_like('cell_phone', $requestData['search']['value']);
      }
      $this->db->limit($requestData['length'], $requestData['start']);
      $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);
      $this->db->where('isActive', '1');

      $teachers_array = $this->db->get()->result_array();
      return $teachers_array;
      } */

    private function _get_datatables_query() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->from($this->table);

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

    function get_datatables() {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all() {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->from($this->_table);
        return $this->db->count_all_results();
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
            $rs = $this->db->get($this->_table)->result();
        } else {
            $rs = $this->db->get($this->_table)->result_array();
        }

        return $rs;
    }
    
    function show_teacher_priority($year,$teacher_id=""){
        if($teacher_id==""){
            return array();
        }else{
            $sql = "SELECT teacher_preference_id, c.name class, s.name subject, tp.priority, c.class_id class_id, s.subject_id subject_id FROM teacher_preference tp,  class c, subject s WHERE  tp.class_id = c.class_id AND tp.subject_id = s.subject_id AND tp.teacher_id=$teacher_id AND tp.year='$year'";
            //die($sql);
            $rs = $this->db->query($sql)->result_array();
            return $rs;
        }
    }
    
    function show_missing_class_in_priority($year,$teacher_id=""){
        if($teacher_id==""){
            return array();
        }else{
            $sql = "SELECT class.class_id class_id,class.name class_name,subject.subject_id subject_id, subject.name subject_name "
                . " FROM ("
                . " SELECT distinct class_id,  subject_id "
                . " FROM class_routine WHERE class_routine_id NOT IN "
                . " (SELECT DISTINCT class_routine_id FROM class_routine c, teacher_preference tp "
                . " WHERE c.year='$year' AND tp.year='$year'AND c.class_id=tp.class_id AND "
                . " c.subject_id=tp.subject_id )) cr, class, subject WHERE cr.class_id=class.class_id "
                . " AND cr.subject_id=subject.subject_id "; //AND subject.teacher_id='".$teacher_id."'
            $rs = $this->db->query($sql)->result_array();
           return $rs;		
        }    
    }
    
    function delete_class_in_priority($teacher_preference_id){
        $sql = "DELETE FROM teacher_preference WHERE teacher_preference_id = $teacher_preference_id";
        $this->db->query($sql);
    }
    
    function get_teacher_preference_details($teacher_preference_id){
        $rs= $this->db->from('teacher_preference')->where('teacher_preference_id',$teacher_preference_id)->get()->result_array();
        //echo $this->db->last_query();
        return $rs;
    }
     function get_teacher(){
        $rs= $this->db->select('teacher_id,emp_id,name,middle_name,last_name')->from('teacher')->get()->result_array();
        //echo $this->db->last_query();
        return $rs;
    }
    function get_teacher_name($teacher_id){
        $result = $this->db->select('teacher_id,emp_id,name,middle_name,last_name')->from('teacher')->where('teacher_id',$teacher_id)->get()->row();
        return $result;
    }
    function update_feedback_status($dataArray, $condition){
        $this->db->where($condition);
        $this->db->update($this->_table, $dataArray);
    }
    function update_feedback_disableAll($dataArray){
       return $this->db->update($this->_table, $dataArray);        
    }
      function get_teacher_forFeedback(){
        $rs= $this->db->select('teacher_id,emp_id,name,middle_name,last_name')->from('teacher')->where('teacher_status','1')->where('feedback_status','Y')->get()->result_array();
        //echo $this->db->last_query();
        return $rs;
    }

    public function getallteachers($class_id){
        $this->db->select("t.teacher_id, t.name, t.middle_name, t.last_name, t.cell_phone, t.email" );
        $this->db->from('teacher as t');
        $this->db->join( 'subject as s', 's.teacher_id = t.teacher_id' );        
        $this->db->where('s.class_id', $class_id);
        $this->db->where('t.isActive', '1');
        $this->db->where('t.teacher_status', '1');
        return  $this->db->get()->result_array();
    }

    function get_teacher_details_by_id($teacher_id=array()){ 
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
        }

        $this->db->select('t.teacher_id, t.name, t.middle_name, t.last_name, t.cell_phone, t.home_phone, t.work_phone, t.email, t.device_token, s.class_id');
        $this->db->from('teacher t');
        $this->db->join( 'subject as s', 's.teacher_id = t.teacher_id' );
        $this->db->where_in('t.teacher_id',$teacher_id);
        $this->db->where('t.isActive','1');
        $this->db->where('t.teacher_status','1');
        $this->db->where('t.school_id', $school_id);

        return $this->db->get()->result_array();
    }
    
    function get_class_id_by_teacher($teacher_id){
        $rs=$this->db->select('class_id')->from('subject')->where('teacher_id',$teacher_id)->where('school_id',$this->session->userdata('school_id'))->get()->result_array();
        //echo $this->db->last_query();
        return $rs;
    }
    
    function get_section_id_by_teacher($teacher_id){
        //$rs=$this->db->select('section_id')->from('subject')->where('teacher_id',$teacher_id)->where('school_id',$this->session->userdata('school_id'))->get()->result_array();
        $rs=$this->db->select('section_id')->from('subject')->where('teacher_id',$teacher_id)->get()->result_array();
        //echo $this->db->last_query();
        return $rs;
    }
    
    public function count_all_teachers() {
        $this->db->from($this->_table.' as teacher');
        return $this->db->count_all_results();
    }
    
}
