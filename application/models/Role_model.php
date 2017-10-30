<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Role_model extends CI_Model {

    private $_table = "roles";
    private $_table_user_role_transaction = "user_role_transaction";
    private $_table_role_link_transaction = "role_link_transaction";
    private $_table_link_modules = "link_modules";

    function __construct() {
        parent::__construct();
    }

    function add($dataArr){
        $this->db->insert($this->_table, $dataArr);
        return $this->db->insert_id();
    }

    function get_role_array($dataArray = "") {
        $return = array();
        $this->db->select("*,sc.name as school_name,r.name as role_name");
        $this->db->from($this->_table.' r');
		$this->db->join( 'schools as sc' , "sc.school_id = r.school_id", 'left' );
        $this->db->order_by("r.name", "asc");

        if (!empty($dataArray)) 
            {
            $this->db->where($dataArray);
        }
        
        $result = $this->db->get()->result_array();
        
        //echo $this->db->last_query();die;
        return $result;
    }

    function get_role_name($id, $school_id){
       return  $this->db->get_where($this->_table, array('id' => $id))->row()->name;
    }

    function assign_role($dataArr){
        $this->db->insert($this->_table_user_role_transaction, $dataArr);
        //echo $this->db->last_query()."<br>";
        return $this->db->insert_id();
    }

    function get_permission_data($where) {
        //$this->db->where("(link_modules.is_paid_addon = 0 or (link_modules.is_paid_addon = 1 and link_modules.is_paid = 1))");
        $module_data = $this->db->get_where($this->_table_link_modules, $where)->result_array();

        if(count($module_data)){
            //$this->db->where("(link_modules.is_paid_addon = 0 or (link_modules.is_paid_addon = 1 and link_modules.is_paid = 1))");
            foreach($module_data as $k => $datum){
                $link_data = $this->db->get_where($this->_table_link_modules, array('parent_id' => $datum['id']))->result_array();
                foreach($link_data as $j => $third_level){
                    $link_data[$j]['link_data'] = $this->db->get_where($this->_table_link_modules, array('parent_id' => $third_level['id']))->result_array();
                }

                $module_data[$k]['link_data'] = $link_data;
            }
        }
        return $module_data;
    }

    function delete_old_permission_data($where){
      //  $exists = $this->db->get_where($this->_table_role_link_transaction, $where)->num_rows();

        //if($exists){
            $this->db->where($where);
            $this->db->delete($this->_table_role_link_transaction);
        //}       
    }

    function delete_exist_user_role_data($where){
        $exists = $this->db->get_where($this->_table_user_role_transaction, $where)->num_rows();

        //if($exists){
            $this->db->where($where);
            $this->db->delete($this->_table_user_role_transaction);
        //}       
           // echo $this->db->last_query();
    }

    function save_update_permission($dataArr){
        $this->db->insert($this->_table_role_link_transaction, $dataArr);
        return $this->db->insert_id();        
    }

    function get_exist_role_link_data($where) {
        return $this->db->select('link_id')->from($this->_table_role_link_transaction)->where($where)->get()->result_array();
    }

    public function update_role($dataArray, $condition) {
        $this->db->where($condition);
        $this->db->update($this->_table, $dataArray);
    }

    function delete_role($where){
        $this->db->where($where);
        $this->db->delete($this->_table);
    }
}