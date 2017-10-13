<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Incident_model extends CI_Model {

    private $_table = "incident";

    function __construct() {
        parent::__construct();
    }

    public function add_data($data) {
        $school_id = '';
        if (($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if ($school_id > 0) {
                $data['school_id'] = $school_id;
            }
        }
        $sql = $this->db->insert($this->_table, $data);
        return $sql;
    }

    public function update_data($data, $id) {
        $this->db->where('incident_id', $id);
        $this->db->update($this->_table, $data);
        return true;
    }

    public function delete($id) {
        $this->db->where('incident_id', $id);
        $this->db->update($this->_table, array('status' => 'Inactive'));
        return true;
    }

    /*
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
        if (($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if ($school_id > 0) {
                $this->db->where('school_id', $school_id);
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

    public function get_details() {
        $school_id = '';

        if (($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if ($school_id > 0) {
                $sql = "select incident.*,violation_type.*,teacher.name as raised_by,"
                        . "class.name as class_name,section.name as section_name,"
                        . "student.name as student_name,teacher1.name as reporting_teacher from incident as incident "
                        . "LEFT JOIN violation_type as violation_type on(incident.violation_type_id=violation_type.violation_type_id)"
                        . " LEFT JOIN teacher as teacher on(incident.raised_by_teacher_id = teacher.teacher_id)"
                        . "LEFT JOIN teacher as teacher1 on (incident.reporting_teacher_id=teacher1.teacher_id) "
                        . "LEFT JOIN class as class on(incident.class_id=class.class_id)"
                        . " LEFT JOIN section as section on(incident.section_id=section.section_id) "
                        . "LEFT JOIN student as student on(incident.student_id=student.student_id)"
                        . "WHERE incident.status='Active' and incident.school_id = '" . $school_id . "'";
            }
        } else {
            $sql = "select incident.*,violation_type.*,teacher.name as raised_by,"
                    . "class.name as class_name,section.name as section_name,"
                    . "student.name as student_name,teacher1.name as reporting_teacher from incident as incident "
                    . "LEFT JOIN violation_type as violation_type on(incident.violation_type_id=violation_type.violation_type_id)"
                    . " LEFT JOIN teacher as teacher on(incident.raised_by_teacher_id = teacher.teacher_id)"
                    . "LEFT JOIN teacher as teacher1 on (incident.reporting_teacher_id=teacher1.teacher_id) "
                    . "LEFT JOIN class as class on(incident.class_id=class.class_id)"
                    . " LEFT JOIN section as section on(incident.section_id=section.section_id) "
                    . "LEFT JOIN student as student on(incident.student_id=student.student_id) "
                    . "WHERE incident.status='Active'";
        }

        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }
    public function get_details_by_id($id) {
        $school_id = '';

        if (($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if ($school_id > 0) {
                $sql = "select incident.*,violation_type.*,teacher.name as raised_by,"
                        . "class.name as class_name,section.name as section_name,"
                        . "student.name as student_name,teacher1.name as reporting_teacher from incident as incident "
                        . "LEFT JOIN violation_type as violation_type on(incident.violation_type_id=violation_type.violation_type_id)"
                        . " LEFT JOIN teacher as teacher on(incident.raised_by_teacher_id = teacher.teacher_id)"
                        . "LEFT JOIN teacher as teacher1 on (incident.reporting_teacher_id=teacher1.teacher_id) "
                        . "LEFT JOIN class as class on(incident.class_id=class.class_id)"
                        . " LEFT JOIN section as section on(incident.section_id=section.section_id) "
                        . "LEFT JOIN student as student on(incident.student_id=student.student_id)"
                        . "WHERE incident.incident_id='$id' and incident.school_id = '" . $school_id . "'";
            }
        } else {
            $sql = "select incident.*,violation_type.*,teacher.name as raised_by,"
                    . "class.name as class_name,section.name as section_name,"
                    . "student.name as student_name,teacher1.name as reporting_teacher from incident as incident "
                    . "LEFT JOIN violation_type as violation_type on(incident.violation_type_id=violation_type.violation_type_id)"
                    . " LEFT JOIN teacher as teacher on(incident.raised_by_teacher_id = teacher.teacher_id)"
                    . "LEFT JOIN teacher as teacher1 on (incident.reporting_teacher_id=teacher1.teacher_id) "
                    . "LEFT JOIN class as class on(incident.class_id=class.class_id)"
                    . " LEFT JOIN section as section on(incident.section_id=section.section_id) "
                    . "LEFT JOIN student as student on(incident.student_id=student.student_id)"
                    ."WHERE incident.incident_id='$id'";
        }

        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }
    public function get_details_added_by($added_by) {
        $school_id = '';

        if (($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if ($school_id > 0) {
                $sql = "select incident.*,violation_type.*,teacher.name as raised_by,"
                        . "class.name as class_name,section.name as section_name,"
                        . "student.name as student_name,teacher1.name as reporting_teacher from incident as incident "
                        . "LEFT JOIN violation_type as violation_type on(incident.violation_type_id=violation_type.violation_type_id)"
                        . " LEFT JOIN teacher as teacher on(incident.raised_by_teacher_id = teacher.teacher_id)"
                        . "LEFT JOIN teacher as teacher1 on (incident.reporting_teacher_id=teacher1.teacher_id) "
                        . "LEFT JOIN class as class on(incident.class_id=class.class_id)"
                        . " LEFT JOIN section as section on(incident.section_id=section.section_id) "
                        . "LEFT JOIN student as student on(incident.student_id=student.student_id)"
                        . "WHERE incident.status='Active' and incident.added_by='$added_by' and incident.school_id = '" . $school_id . "'";
            }
        } else {
            $sql = "select incident.*,violation_type.*,teacher.name as raised_by,"
                    . "class.name as class_name,section.name as section_name,"
                    . "student.name as student_name,teacher1.name as reporting_teacher from incident as incident "
                    . "LEFT JOIN violation_type as violation_type on(incident.violation_type_id=violation_type.violation_type_id)"
                    . " LEFT JOIN teacher as teacher on(incident.raised_by_teacher_id = teacher.teacher_id)"
                    . "LEFT JOIN teacher as teacher1 on (incident.reporting_teacher_id=teacher1.teacher_id) "
                    . "LEFT JOIN class as class on(incident.class_id=class.class_id)"
                    . " LEFT JOIN section as section on(incident.section_id=section.section_id) "
                    . "LEFT JOIN student as student on(incident.student_id=student.student_id) "
                    . "WHERE incident.status='Active' and incident.added_by='$added_by'";
        }

        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }
    public function get_details_student_id($id) {
        $school_id = '';

        if (($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if ($school_id > 0) {
                $sql = "select incident.*,violation_type.*,teacher.name as raised_by,"
                        . "class.name as class_name,section.name as section_name,"
                        . "student.name as student_name,teacher1.name as reporting_teacher from incident as incident "
                        . "LEFT JOIN violation_type as violation_type on(incident.violation_type_id=violation_type.violation_type_id)"
                        . " LEFT JOIN teacher as teacher on(incident.raised_by_teacher_id = teacher.teacher_id)"
                        . "LEFT JOIN teacher as teacher1 on (incident.reporting_teacher_id=teacher1.teacher_id) "
                        . "LEFT JOIN class as class on(incident.class_id=class.class_id)"
                        . " LEFT JOIN section as section on(incident.section_id=section.section_id) "
                        . "LEFT JOIN student as student on(incident.student_id=student.student_id)"
                        . "WHERE incident.status='Active' and incident.student_id='$id' and incident.school_id = '" . $school_id . "'";
            }
        } else {
            $sql = "select incident.*,violation_type.*,teacher.name as raised_by,"
                    . "class.name as class_name,section.name as section_name,"
                    . "student.name as student_name,teacher1.name as reporting_teacher from incident as incident "
                    . "LEFT JOIN violation_type as violation_type on(incident.violation_type_id=violation_type.violation_type_id)"
                    . " LEFT JOIN teacher as teacher on(incident.raised_by_teacher_id = teacher.teacher_id)"
                    . "LEFT JOIN teacher as teacher1 on (incident.reporting_teacher_id=teacher1.teacher_id) "
                    . "LEFT JOIN class as class on(incident.class_id=class.class_id)"
                    . " LEFT JOIN section as section on(incident.section_id=section.section_id) "
                    . "LEFT JOIN student as student on(incident.student_id=student.student_id) "
                    . "WHERE incident.status='Active' and incident.student_id='$id'";
        }

        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }

}
