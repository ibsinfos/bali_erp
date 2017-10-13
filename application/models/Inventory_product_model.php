<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inventory_product_model extends CI_Model {

    private $_table = "product";
    var $column_order = array(null, 'p.product_name','p.product_unique_id','p.rate','p.quantity','c.categories_name','s.seller_name','p.status'); //set column field database for datatable orderable
    var $column_search = array('p.product_name','p.product_unique_id','p.rate','p.quantity','c.categories_name','s.seller_name','p.status'); //set column field database for datatable searchable 
    var $order = array('p.create_date' => 'desc'); // default order 

    function __construct() {
        parent::__construct();
    }

    public function add($data) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
            } 
        }
        $sql = $this->db->insert('product', $data);
        return $sql;
    }

    public function get_By_Id($id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('product.school_id',$school_id);
            } 
        }
        $this->db->select('*');
        $this->db->join('categories', 'product.categories_id = categories.categories_id');
        $this->db->join('seller_master', 'product.seller_id = seller_master.seller_id');
        $query = $this->db->get_where('product', array('product_id' => $id));
        return $query->row_array();
    }

    public function get_all($categories_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('product.school_id',$school_id);
            } 
        }
        $this->db->select('*');
        $this->db->from('product');
        $this->db->join('categories', 'product.categories_id = categories.categories_id');
        $this->db->join('seller_master', 'product.seller_id = seller_master.seller_id');
        $this->db->order_by("product.create_date", "desc"); 
        if ($categories_id > 0)
            $this->db->where('product.categories_id', $categories_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function deletebyId($dataArray) {
        $this->db->where($dataArray);
        $this->db->delete('product');

        return true;
    }

    public function updatebyId($dataArray, $product_id) {
        $this->db->where($product_id);
        $this->db->update('product', $dataArray);
        return true;
    }

    function send_for_service($product_id) {
        $this->updatebyId(array('status' => 'Service'), $product_id);
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
    private function _get_datatables_query($categories_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('p.school_id',$school_id);
                $this->db->where('s.school_id',$school_id);
                $this->db->where('c.school_id',$school_id);
            } 
        }
       $this->db->select('p.*');
       $this->db->select('s.*');
       $this->db->select('c.*');
       $this->db->from($this->_table.' as p');
        $this->db->join('categories as c', 'p.categories_id = c.categories_id');
        $this->db->join('seller_master as s', 'p.seller_id = s.seller_id');
        if ($categories_id != 0)
            $this->db->where('p.categories_id', $categories_id);

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
    
    // GET DATATABLE 
    function get_datatables($categories_id) {
        $list = $this->_get_datatables_query($categories_id);
        if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    
     function count_filtered($categories_id) {
        $this->_get_datatables_query($categories_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
     public function count_all($categories_id) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $this->db->where('p.school_id',$school_id);
                $this->db->where('s.school_id',$school_id);
                $this->db->where('c.school_id',$school_id);
            } 
        }
        $this->db->select('p.*');
        $this->db->select('s.*');
        $this->db->select('c.*');
        $this->db->from($this->_table.' as p');
         $this->db->join('categories as c', 'p.categories_id = c.categories_id');
         $this->db->join('seller_master as s', 'p.seller_id = s.seller_id');
         if ($categories_id != 0)
             $this->db->where('p.categories_id', $categories_id);
         return $this->db->count_all_results();
    }

}
