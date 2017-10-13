<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class Master_cronjob_model extends CI_Model{
        function __construct() {
            parent::__construct();
        }
        
        function get_insurance_details($date){
            //print($this->db->database.' === ');
            $sql="SELECT vd.insurance_expiry_date,bd.*,b.name as bus_name,b.bus_unique_key FROM vehicle_details AS vd JOIN bus_driver AS bd ON(vd.driver_id=bd.bus_driver_id) JOIN bus AS b ON(vd.bus_id=b.bus_id) WHERE vd.insurance_expiry_date='$date'";
            $rs = $this->db->query($sql)->result_array();
            return $rs;
        }
        
        function get_all_notification_queue(){
            $sql="SELECT * FROM notification_queue WHERE status=1";
            $rs=$this->db->query($sql)->result();
            return $rs;
        }
    }