<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Student_certificate_model extends CI_Model {

    private $_table = "student_certificates";
    private $_table_certificate_type = "certificate_types";
                function __construct() {
        parent::__construct();
    }
    
    function save_certificate($ceritificate_title,$sub_title,$main_cantent,$student_id){
        $timstamp = date('Y-m-d H:i:s'); 
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
             $school_id = $this->session->userdata('school_id');
             if($school_id > 0){
                 $this->db->query("INSERT INTO student_certificates (`certificate_id`, `student_id`, `certificate_title`, `sub_title`,`main_cantent`,`date`, `school_id`) VALUES (NULL, '".$student_id."', '".$ceritificate_title."', '".$sub_title."','".$main_cantent."','".$timstamp."','".$school_id."');");
             } 
        } else {
            $this->db->query("INSERT INTO student_certificates (`certificate_id`, `student_id`, `certificate_title`, `sub_title`,`main_cantent`,`date`) VALUES (NULL, '".$student_id."', '".$ceritificate_title."', '".$sub_title."','".$main_cantent."','".$timstamp."');");
        }     
       
       $id = $this->db->insert_id();
    }
    
    /**
     * 
     * @param type $id
     * @return type
     */
    function get_data_by_id($id,$returnColsStr=""){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        if($returnColsStr==""){
            return $this->db->get_where($this->_table,array('certificate_id'=>$id))->result();
        }else{
            return $this->db->select($returnColsStr)->from($this->_table)->where('certificate_id',$id)->get()->result();
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
    function get_data_by_cols($columnName="*",$conditionArr=array(),$return_type="result",$sortByArr=array(),$limit=""){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
        
        $this->db->select($columnName);
        $condition_type='and';
        if(array_key_exists('condition_type', $conditionArr)){
            if($conditionArr['condition_type']!=""){
                $condition_type=$conditionArr['condition_type'];
            }
        }
        unset($conditionArr['condition_type']);
        $condition_in_data_arr=array();
        $startCounter=0;
        $condition_in_column="";
        foreach($conditionArr AS $k=>$v){
            if($condition_type=='in'){
                if(array_key_exists('condition_in_data', $conditionArr)){
                    $condition_in_data_arr=  explode(',', $conditionArr['condition_in_data']);
                    $condition_in_column=$conditionArr['condition_in_col'];
                }

            }elseif($condition_type=='or'){
                if($startCounter==0){
                    $this->db->where($k,$v);
                }else{
                    $this->db->or_where($k,$v);
                }
            }elseif($condition_type=='and'){
                $this->db->where($k,$v);
            }
            $startCounter++;
        }

         if($condition_type=='in'){
             if(!empty($condition_in_data_arr))
                 $this->db->where_in($condition_in_column,$condition_in_data_arr);
        }

        if($limit!=""){
            $this->db->limit($limit);
        }

        foreach($sortByArr AS $key=>$val){
            $this->db->order_by($key,$val);
        }

        if($return_type=='result'){
            $rs=$this->db->get($this->_table)->result();
        }else{
            $rs=$this->db->get($this->_table)->result_array();
        }

        return $rs;
    }
    
        function add($dataArr){
//            pre($dataArr); die;
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $dataArr['school_id'] = $school_id;
            } 
        }
        $this->db->insert($this->_table, $dataArr);
        return $this->db->insert_id();
    }
    
    function get_certificate_record($student_id,$certificate_id){
     $this->db->select('st.*, student.name,student.name,student.mname,student.lname,certificate_types.certificate_type'); // Select field
            $this->db->from($this->_table.' as st'); // from Table1
            $this->db->join('student', 'student.student_id = st.student_id');
            $this->db->join('certificate_types', 'certificate_types.certificate_type_id = st.certificate_type','left');
            $this->db->where('st.student_id', $student_id);
            $this->db->where('st.certificate_id', $certificate_id);
            return $this->db->get()->row();
    }

    function add_certificate_type($dataArr){
//            pre($dataArr); die;
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
               $dataArr['school_id'] = $school_id;
            } 
        }
        $this->db->insert($this->_table_certificate_type, $dataArr);
        return $this->db->insert_id();
    }
    
    function get_certificate_type_list($dataArray = ""){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
//       return $this->db->select('*')->from($this->_table_certificate_type)->order_by('certificate_type_id','desc')->get()->result_array();
    $return = array();
        $this->db->select("*");
        $this->db->from($this->_table_certificate_type);
        $this->db->order_by("certificate_type_id", "desc");
        
        if (!empty($dataArray)) {
            $this->db->where($dataArray);
        }       
        return $this->db->get()->result_array();
       
     }
    
    function get_data_by_id_certificate_type($id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
            return $this->db->select('*')->from($this->_table_certificate_type)->where('certificate_type_id',$id)->get()->row();
        
    }
    
    function update_cretificate_type($dataArray, $condition){
        $this->db->where($condition);
        $this->db->update($this->_table_certificate_type, $dataArray);
//        echo $this->db->last_query(); die;
        return;
    }
    
    function update_cretificate($dataArray, $condition){
        $this->db->where($condition);
        $this->db->update($this->_table, $dataArray);
//        echo $this->db->last_query(); die;
        return;
    }
    
    function delete_certificate_type($where){
            $this->db->where('certificate_type_id',$where);
            $this->db->delete($this->_table_certificate_type);
    }  
    
    function get_template_size(){
         $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('school_id',$school_id);
            } 
        }
//       return $this->db->select('*')->from($this->_table_certificate_type)->order_by('certificate_type_id','desc')->get()->result_array();
        $return = array();
        $this->db->select("*");
        $this->db->from('template_size');
        
        if (!empty($dataArray)) {
            $this->db->where($dataArray);
        }       
        return $this->db->get()->result_array();

    }
    
    
}