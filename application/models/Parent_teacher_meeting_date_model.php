<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Parent_teacher_meeting_date_model extends CI_Model {
    private $_table="parrent_teacher_meeting_date";
    
    var $column_order = array(null, 'std.name', 'cls.name', 'sec.name', 'par_tea_mtg.time'); //set column field database for datatable orderable
    var $column_search = array('std.name', 'cls.name', 'sec.name', 'par_tea_mtg.time'); //set column field database for datatable searchable 
    var $order = array('std.student_id' => 'asc'); // default order 
    
    function __construct() {
        parent::__construct();
    }

    public function save_ptm($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
        
        $this->db->insert('parrent_teacher_meeting_date', $dataArray);
        $ptm_id = $this->db->insert_id();
        return $ptm_id;
    }

    public function get_count($dataArray) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $query = $this->db->get_where('parrent_teacher_meeting_date', array('class_id' => $dataArray['class_id'], 'section_id' => $dataArray['section_id'], 'meeting_date' => $dataArray['meeting_date'], 'isActive' => '1'))->row();
        return count($query);
    }

    public function view_ptm_settings($condition) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        $this->db->order_by('meeting_date', 'DESC');
        $this->db->where($condition);
        $settings_records = $this->db->get('parrent_teacher_meeting_date')->result_array();
        return $settings_records;
    }

    public function delete_ptm($condition) {
        $this->db->where($condition);
        $this->db->update('parrent_teacher_meeting_date', array('isActive' => '0'));
        return true;
    }

    public function update_ptm($dataArray, $condition) {
        $this->db->where($condition);
        $this->db->update('parrent_teacher_meeting_date', $dataArray);
        return true;
    }

    public function get_student_details_for_ptm($class_id = '', $section_id = '', $running_year = '') {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('std.school_id',$school_id);
            } 
        }
        $this->db->select('std.name as student_name, std.student_id as stud_id, par_tea_mtg.parrent_accepted,par_tea_mtg.time, en.class_id,cls.name as class_name,sec.name as section_name, en.section_id'); 
        $this->db->from('student as std');
        $this->db->join('enroll as en', 'std.student_id = en.student_id');
        $this->db->join('class as cls', 'cls.class_id  = en.class_id');
        $this->db->join('section as sec', 'sec.section_id = en.section_id');
        $this->db->join('parrent_teacher_meeting as par_tea_mtg', 'par_tea_mtg.student_id = std.student_id', 'LEFT');
        $this->db->where('en.class_id', $class_id);
        $this->db->where('en.section_id', $section_id);
        $this->db->where('en.year', $running_year);
        $this->db->order_by('std.name', "ASC");
        $res = $this->db->get()->result_array();
        return $res;
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

     private function _get_datatables_query($class_id,$section_id,$running_year) {  
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('std.school_id',$school_id);
            } 
        }
        
        $this->db->select('std.name as student_name, std.student_id as stud_id, par_tea_mtg.parrent_accepted,par_tea_mtg.time, en.class_id,cls.name as class_name,sec.name as section_name, en.section_id'); // Select field
        $this->db->from('student as std');
        $this->db->join('enroll as en', 'std.student_id = en.student_id');
        $this->db->join('class as cls', 'cls.class_id  = en.class_id');
        $this->db->join('section as sec', 'sec.section_id = en.section_id');
        $this->db->join('parrent_teacher_meeting as par_tea_mtg', 'par_tea_mtg.student_id = std.student_id', 'LEFT');
        $this->db->where('en.class_id', $class_id);
        $this->db->where('en.section_id', $section_id);
        $this->db->where('en.year', $running_year);
        $this->db->where('std.isActive', '1');
        $this->db->where('std.student_status', '1');
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
    
    
     function get_datatables($class_id,$section_id,$running_year) {
        $list = $this->_get_datatables_query($class_id,$section_id,$running_year);
        if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
   
    function count_filtered($class_id,$section_id,$running_year) {
        $this->_get_datatables_query($class_id,$section_id,$running_year);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function count_all($class_id,$section_id,$running_year) 
    {   
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('std.school_id',$school_id);
            } 
        }
        $this->db->select('std.name as student_name, std.student_id as stud_id, par_tea_mtg.parrent_accepted,par_tea_mtg.time, en.class_id,cls.name as class_name,sec.name as section_name, en.section_id'); // Select field
        $this->db->from('student as std');
        $this->db->join('enroll as en', 'std.student_id = en.student_id');
        $this->db->join('class as cls', 'cls.class_id  = en.class_id');
        $this->db->join('section as sec', 'sec.section_id = en.section_id');
        $this->db->join('parrent_teacher_meeting as par_tea_mtg', 'par_tea_mtg.student_id = std.student_id', 'LEFT');
        $this->db->where('en.class_id', $class_id);
        $this->db->where('en.section_id', $section_id);
        $this->db->where('en.year', $running_year);
        $this->db->order_by('std.name', "ASC");
        return $this->db->count_all_results();
    }

    
}
