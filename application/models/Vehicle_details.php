<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vehicle_details extends CI_Model {

    private $_table = "vehicle_details";

    function __construct() {
        parent::__construct();
    }

    public function add_vehicel_details($data) {
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                $data['school_id'] = $school_id;
            } 
        }
        $sql = $this->db->insert($this->_table, $data);
        return $sql;
    }
    public function get_all_details(){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                 $sql="SELECT vd.*,t.route_name,bd.name as driver_name,b.name as bus_name FROM vehicle_details vd JOIN bus b on(vd.bus_id=b.bus_id) JOIN transport t on(vd.route_id=t.transport_id) JOIN bus_driver bd on(vd.driver_id=bd.bus_driver_id) WHERE vd.school_id = '".$school_id."' ORDER BY vd.vehicle_details_id DESC";
            } 
        } else {
            $sql="SELECT vd.*,t.route_name,bd.name as driver_name,b.name as bus_name FROM vehicle_details vd JOIN bus b on(vd.bus_id=b.bus_id) JOIN transport t on(vd.route_id=t.transport_id) JOIN bus_driver bd on(vd.driver_id=bd.bus_driver_id)  ORDER BY vd.vehicle_details_id DESC";
        }
        $rs = $this->db->query($sql)->result_array();
        return $rs;
    }
    
    public function get_all_details_by_busDriver($bus_driver_id = '', $bus_id = ''){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                  $sql="SELECT vd.*,t.route_name,bd.name as driver_name,b.name as bus_name FROM vehicle_details vd join bus_driver bd JOIN bus b on(vd.bus_id=b.bus_id) LEFT JOIN transport t on(vd.route_id=t.transport_id) WHERE bd.bus_driver_id = '".$bus_driver_id."' and b.bus_id = '".$bus_id."' and vd.school_id = '".$school_id."' ORDER BY vd.vehicle_details_id DESC limit 1";
            } 
        } else {
            $sql="SELECT vd.*,t.route_name,bd.name as driver_name,b.name as bus_name FROM vehicle_details vd LEFT JOIN bus b on(vd.bus_id=b.bus_id) LEFT JOIN transport t on(vd.route_id=t.transport_id) LEFT JOIN bus_driver bd on(vd.driver_id=bd.bus_driver_id) WHERE bd.bus_driver_id = '".$bus_driver_id."' and b.bus_id = '".$bus_id."' ORDER BY vd.vehicle_details_id DESC limit 1";
        }
        $rs = $this->db->query($sql)->result_array();
//        echo $this->db->last_query(); die;
        return $rs;
    }
    public function get_all_vehicle_details(){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
            if($school_id > 0){
                 $sql="SELECT vd.*,t.route_name,bd.name as driver_name,b.name as bus_name,b.bus_unique_key,a.name,a.email as admin_email FROM vehicle_details vd JOIN bus b on(vd.bus_id=b.bus_id) JOIN transport t on(vd.route_id=t.transport_id) JOIN bus_driver bd on(vd.driver_id = bd.bus_driver_id) JOIN admin as a WHERE vd.school_id = '".$school_id."' and a.school_id = '".$school_id."' ORDER BY vd.vehicle_details_id DESC";
                 
            } 
        }        
        $rs = $this->db->query($sql)->result_array();
//        echo $this->db->last_query(); die;
        return $rs;
    }
    
    public function updatebyId($vehicle_details_id,$dataArray){
        $this->db->where('vehicle_details_id',$vehicle_details_id);
        $this->db->update($this->_table, $dataArray);
        return true;
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

    function get_bus_driver_with_route_data($bus_id){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
        }

        $this->db->select('b.route_id, bd.bus_driver_id');
        $this->db->from('bus b');
        $this->db->join('bus_driver bd', 'b.bus_id = bd.bus_id', 'left');
        $this->db->where(array('b.bus_id'=>$bus_id, 'b.school_id'=>$school_id, 'bd.school_id'=>$school_id));
        $data=$this->db->get()->row();
        return $data;
    }
}