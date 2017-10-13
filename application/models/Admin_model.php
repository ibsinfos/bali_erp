<?php

if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class Admin_model extends CI_Model{
        
        private  $_table="admin";
        private $_primary="admin_id";
        private $_table_user_role_transaction = 'user_role_transaction';
        private $_table_login_history="login_history";

        var $column_order = array(null, 'user_name', 'login_at', 'logout_at', 'ip_address'); //set column field database for datatable orderable
        var $column_search = array('user_name', 'login_at', 'logout_at', 'ip_address'); //set column field database for datatable searchable 
        var $order = array('login_history_id' => 'desc'); // default order 
        
                function __construct(){
            parent::__construct();
        }
        
        function add($dataArr){
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $dataArr['school_id'] = $school_id;
            } 
            $this->db->insert($this->_table,$dataArr);
            return $this->db->insert_id();
        }
        
        function edit($dataArr,$conditionArr){
            foreach ($conditionArr AS $k=>$v){
                $this->db->where($k, $v);
            }
            $this->db->update($this->_table, $dataArr);
        }
        
        public function update_profile($dataArray, $admin_id){
            $this->db->where('admin_id', $admin_id);
            $this->db->update('admin', $dataArray);
            
            $oldEmail = $this->input->post('email_old');
            $hrmData = array('emailaddress'=> $dataArray['email']);
            $this->db->where('emailaddress', $oldEmail);
            $this->db->update('main_users', $hrmData);
            
            $fiData = array('username'=> $dataArray['email']);
            $this->db->where('username', $oldEmail);
            $this->db->update('sys_users', $fiData);
            
            return true; 
        }
        
        public function updateadmin_password($dataArray, $admin_id) {
            $this->db->where('admin_id', $admin_id);
            $this->db->update('admin',$dataArray);
            return true;
        }
        
        public function update_super_admin_profile($dataArray, $admin_id){
            $this->db->where('super_admin_id', $admin_id);
            $this->db->update('super_admin', $dataArray);
            return true; 
        }
        
        public function update_super_admin_password($dataArray, $admin_id) {
            $this->db->where('school_admin_id', $admin_id);
            $this->db->update('school_admin',$dataArray);
            return true;
        }
        
        public function upload_fee_structure($data) {
            $this->db->insert('fee_structure', $data);
            return $this->db->insert_id();
        }
        
        public function do_delete_fee_structure($fee_structure_id){
            $this->db->where('fee_structure_id', $fee_structure_id);
            $this->db->delete('fee_structure');
        }
        
        public function do_toggle_enable_fee_structure($dataArray){
            if($dataArray['status']==1){
                $UpdateData = array('fee_structure_status'=> '0');
            }else{
                $UpdateData = array('fee_structure_status'=> '1', 'enabled_at' =>date('Y-m-d H:i:s'));
            }
            $this->db->update('fee_structure',array('fee_structure_status'=> '0'));
            
            $this->db->where('fee_structure_id', $dataArray['fee_structure_id']);
            $this->db->update('fee_structure',$UpdateData);
            return true;
        }
        
        
    /**
     * 
     * @param type $id
     * @return type
     */
    function get_data_by_id($id,$returnColsStr=""){
        $school_id = $this->session->userdata('school_id');
        if($school_id > 0){
            $this->db->where("school_id",$school_id);
        } 
        if($returnColsStr==""){
            return $this->db->get_where($this->_table,array($this->_primary=>$id))->result();
        }else{
            return $this->db->select($returnColsStr)->from($this->_table)->where($this->_primary,$id)->get()->result();
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
        $school_id = $this->session->userdata('school_id');
        if($school_id > 0){
            $this->db->where("school_id",$school_id);
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
    
    function get_data_by_cols1($columnName="*",$conditionArr=array(),$return_type="result",$sortByArr=array(),$limit=""){
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
            $rs=$this->db->get("master_users")->result();
        }else{
            $rs=$this->db->get("master_users")->result_array();
        }

        return $rs;
    }

    function get_admin_image($id){
        return $this->db->get_where('admin', array('admin_id' => $id))->row()->image;
    }

    public function get_admin_list($school_id) {
        $this->db->select('admin_id id, name fname, email');
        $this->db->where('school_id', $school_id);

        $data = $this->db->get($this->_table)->result_array();

        if(count($data)){
            foreach($data as $k => $datum){
                $where = array('original_user_type' => 'A', 'main_user_id' => $datum['id'], 'school_id'=>$school_id);
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

    function save_login_history_data($dataArr){
        $this->db->insert($this->_table_login_history, $dataArr);
        return $this->db->insert_id();
    }

    function update_login_history_data($id, $data){
        $this->db->where('login_history_id', $id)->update($this->_table_login_history, $data);
    }

    
    private function _get_login_history_datatables_query() {
        $this->db->from($this->_table_login_history);
        $this->db->where('school_id', $this->session->userdata('school_id'));
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

    function get_login_history_datatables(){
        $this->_get_login_history_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_all_login_history() {
        $this->db->from($this->_table_login_history);
        return $this->db->count_all_results();
    }

    function count_filtered_login_history() {
        $this->_get_login_history_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

}
