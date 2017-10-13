<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Assets_model extends CI_Model {

    private $_table_assets = "fi_assets";

    public function __construct() {
        parent::__construct();
    }

    public function add($data) {
        $this->db->insert($this->_table_assets, $data);
        return $this->db->insert_id();
    }

    function get_assets(){
        $this->db->select('ast.fi_assets_id, ast.title, ast.amount, ast.created_at, ast.description');
        $this->db->from($this->_table_assets.' ast');
        $this->db->where('ast.fi_assets_status', '1');
        $this->db->order_by('ast.fi_assets_id', 'desc');
        return $this->db->get()->result_array();
    }

    public function do_update($data, $id) {         
        $this->db->where('fi_assets_id',$id);
        $this->db->update($this->_table_assets,$data);
    }
    
}
