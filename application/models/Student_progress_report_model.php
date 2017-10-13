<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    
class Student_progress_report_model extends CI_Model {
    private $_table="student_progress_report";
    private $_table_teacher = "teacher";
    private $_primary="report_id";
    function __construct() {
        parent::__construct();
    }
    
    function add($dataArray){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArray['school_id'] = $school_id;
            } 
        }
            
        $this->db->insert($this->_table, $dataArray);
        $progress_id = $this->db->insert_id();
        return $progress_id;
    }
    
    function edit($dataArray,$id){
        $this->db->where($this->_primary, $id);
        $this->db->update($this->_table, $dataArray);
        return true;
    }
    
    function delete($id){
        $this->db->where($this->_primary, $id);
        $this->db->delete($this->_table);
        return TRUE;
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
    
    function nums_of_report_by_student($id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        return $this->db->where('student_id' , $id)->count_all_results($this->_table);
    }
    
    //GET PROGRESS REPORT DETAILS
     function progress_report_detail($class_id, $student_id,$selected_term,$selected_heading) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
            
        $headings = $this->db->get_where('progress_report_heading', array(
                    'heading_id' => $selected_heading))->result_array();
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
                        $this->db->select("sub_category_id,exceeding_level,expected_level,emerging_level,time_stamp,comment,t.name,t.last_name");
                        $this->db->from("student_progress_report");
                        $this->db->where('sub_category_id', $subcat['sub_category_id']);
                        $this->db->where('student_id', $student_id);
                        $this->db->where('term_id', $selected_term);
                        $this->db->join($this->_table_teacher." AS t", 't.teacher_id = student_progress_report.teacher_id');
                        $this->db->group_by('report_id', 'desc');
                        $categories = array();
                        // echo "l=" . $l . "<br>";
                        $show_data = $this->db->get()->row();
//                        echo $this->db->last_query(); die;
                        if (!empty($show_data)) {
                            $categories[$subcategory_key]['sub_category_id'] = $subcat['sub_category_id'];
                            $categories[$subcategory_key]['sub_desc'] = $subcat['description'];
                            $categories[$subcategory_key]['ex'] = $show_data->exceeding_level;
                            $categories[$subcategory_key]['exp'] = $show_data->expected_level;
                            $categories[$subcategory_key]['em'] = $show_data->emerging_level;
                            $categories[$subcategory_key]['date'] = $show_data->time_stamp;
                            $categories[$subcategory_key]['comment'] = $show_data->comment;
                            $categories[$subcategory_key]['teacher_name'] = $show_data->name." ".$show_data->last_name;
                            //pre($categories);
                            $all_data[$heading_key]['category'][$category_key]['subcategory_desc'][$subcategory_key] = $categories[$subcategory_key];
                        } else {
                            $categories[$subcategory_key]['sub_category_id'] = $subcat['sub_category_id'];
                            $categories[$subcategory_key]['sub_desc'] = $subcat['description'];
                            $categories[$subcategory_key]['ex'] = "";
                            $categories[$subcategory_key]['exp'] = "";
                            $categories[$subcategory_key]['em'] = "";
                            $categories[$subcategory_key]['date'] = "";
                            $categories[$subcategory_key]['comment'] = "";
                            $categories[$subcategory_key]['teacher_name'] = "";
                            //pre($categories);
                            $all_data[$heading_key]['category'][$category_key]['subcategory_desc'][$subcategory_key] = $categories[$subcategory_key];
                        }

//pre($all_data);
                        //                $result['sub_category'] = $row1['description'];
                    }
                }
            }
        }
        return $all_data;
//        pre($all_data);
    }
    
}

