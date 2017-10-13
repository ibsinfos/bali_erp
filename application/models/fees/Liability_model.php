<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Liability_model extends CI_Model {

    private $_table_liability = "fi_liability";

    public function __construct() {
        parent::__construct();
    }

    public function add($data) {
        $this->db->insert($this->_table_liability, $data);
        return $this->db->insert_id();
    }

    function get_liability(){
        $this->db->select('lbl.fi_liability_id, lbl.title, lbl.amount, lbl.created_at, lbl.description');
        $this->db->from($this->_table_liability.' lbl');
        $this->db->where('lbl.fi_liability_status', '1');
        $this->db->order_by('lbl.fi_liability_id', 'desc');
        return $this->db->get()->result_array();
    }

    public function do_update($data, $id) {         
        $this->db->where('fi_liability_id',$id);
        $this->db->update($this->_table_liability,$data);
    }
    
}
