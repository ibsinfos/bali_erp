<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gpslocation_model extends CI_Model {

    private $_table = "gpslocations";

    function __construct() {
        parent::__construct();
    }

    public function add($data) {
        $sql = $this->db->insert($this->_table, $data);
        return $sql;
    }
    public function delete_2days_record_gpslocation() {
        $sql = "delete from gpslocations where datediff(now(), gpslocations.lastUpdate) > 2";
        $rs = $this->db->query($sql);
        return $rs;
    }
}