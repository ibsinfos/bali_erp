<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Donation_model extends CI_Model {

    private $_table_donation = "donation";

    public function __construct() {
        parent::__construct();
    }

    public function add($data) {
        $this->db->insert($this->_table_donation, $data);
        return $this->db->insert_id();
    }

    function get_donation_data(){
        $this->db->select('don.donation_id, don.donator_name, don.amount, don.donation_date, don.description');
        $this->db->from($this->_table_donation.' don');
        $this->db->where('don.donation_status', '1');
        $this->db->order_by('don.donation_id', 'desc');
        return $this->db->get()->result_array();
    }

    public function udpate($data, $id) {         
        $this->db->where('donation_id',$id);
        $this->db->update($this->_table_donation,$data);
    }
    
}
