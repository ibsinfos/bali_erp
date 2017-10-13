<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Fees_model extends CI_Model {

    private $_table_fee_collections = "fee_collections";
    private $_table_fi_category = "fi_category";
    private $shcool_id;

    public function __construct() {
        parent::__construct();        
        $this->school_id = $this->session->userdata('school_id');
    }
   
    /********************Fee Category functions***************/
    public function get_fee_categories($running_year=false,$school_id=false) {
        $running_year = $running_year?$running_year:$this->session->userdata('running_year');
        $school_id = $school_id?$school_id:$this->session->userdata('school_id');
        //_school_cond();
        $this->db->select('FC.*,(SELECT COUNT(*) FROM fee_particulars WHERE fee_category_id=FC.cat_id) trans');
        $this->db->from('fee_categories FC');
        $this->db->where(array('FC.running_year'=>$running_year,'FC.school_id'=>$school_id));
        return $this->db->get()->result(); 
    }

    public function save_fee_category($data) {
        $flag = false;
        if(isset($data['cat_id']) && $data['cat_id']){
            $this->db->update('fee_categories', $data, array('cat_id'=>$data['cat_id']));
            $flag = $data['cat_id'];
        }else{
            $this->db->insert('fee_categories', $data);
            $flag = $this->db->insert_id();
        }
        return $flag;
    }

    function get_category_record($id){
        return $this->db->get_where('fee_categories',array('cat_id'=>$id))->row();
    }

    function category_delete($whr=array()){
        return $this->db->delete('fee_categories',$whr);
    }
    
    /********************Fee Terms functions***************/
    public function get_fee_terms($running_year=false) {
        _school_cond('FT.school_id');
        _year_cond('FT.running_year',$running_year);
        $this->db->select('FT.*,(SELECT count(*) FROM fee_charge_setups WHERE fee_term_id=FT.id) in_fee_setup,
        (SELECT count(*) FROM fee_hostel_charge_setups WHERE fee_term_id=FT.id) in_hostel_setup,
        (SELECT count(*) FROM fee_transport_charge_setups WHERE fee_term_id=FT.id) in_transport_setup');
        $this->db->from('fee_terms FT');
        return $this->db->get()->result(); 
    }

    public function save_fee_term($data) {
        $flag = false;
        if(isset($data['id']) && $data['id']){
            $this->db->update('fee_terms', $data, array('id'=>$data['id']));
            $flag = $data['id'];
        }else{
            $this->db->insert('fee_terms', $data);
            $flag = $this->db->insert_id();
        }
        return $flag;
    }

    function get_term_record($id){
        $this->db->select('FT.*,(SELECT count(*) FROM fee_charge_setups WHERE fee_term_id=FT.id) in_fee_setup,
        (SELECT count(*) FROM fee_hostel_charge_setups WHERE fee_term_id=FT.id) in_hostel_setup,
        (SELECT count(*) FROM fee_transport_charge_setups WHERE fee_term_id=FT.id) in_transport_setup');
        $this->db->from('fee_terms FT');
        $this->db->where(array('id'=>$id));
        return $this->db->get()->row(); 
    }

    function term_delete($whr=array()){
        _school_cond();
        return $this->db->delete('fee_terms',$whr);
    }

    function get_term_setting(){
        _school_cond();
        _year_cond();
        return $this->db->get_where('fee_term_settings')->row();    
    }

    function save_term_setting($data){
        $flag = false;
        $term_setting = $this->get_term_setting();
        if($term_setting){
            $flag = $term_setting->id;
            return $this->db->update('fee_term_settings',$data,array('id'=>$term_setting->id));
        }else{
            $this->db->insert('fee_term_settings',$data);
            $flag = $this->db->insert_id();
        }
        return $flag;
    }
    /********************Fee Particular functions***************/
    public function get_fee_heads($whr=array()) {
        _school_cond('FH.school_id');
        _year_cond('FH.running_year');
        $this->db->select('FH.*,(SELECT count(*) FROM fee_rel_group_heads WHERE head_id=FH.id) in_grps,
        (SELECT count(*) FROM fee_pay_item_transactions WHERE item_type=1 AND item_id=FH.id) in_paytrans,
        (SELECT count(*) FROM fee_invoice_items WHERE item_type=1 AND item_id=FH.id) in_invitem');
        $this->db->from('fee_heads FH');
        $this->db->where($whr);
        return $this->db->get()->result(); 
    }

    public function save_fee_head($data) {
        $flag = false;
        if(isset($data['id']) && $data['id']){
            $this->db->update('fee_heads', $data, array('id'=>$data['id']));
            $flag = $data['id'];
        }else{
            $this->db->insert('fee_heads', $data);
            $flag = $this->db->insert_id();
        }
        return $flag;
    }

    function get_head_record($id){
        $this->db->select('FH.*,(SELECT count(*) FROM fee_rel_group_heads WHERE head_id=FH.id) in_grps,
        (SELECT count(*) FROM fee_pay_item_transactions WHERE item_type=1 AND item_id=FH.id) in_paytrans,
        (SELECT count(*) FROM fee_invoice_items WHERE item_type=1 AND item_id=FH.id) in_invitem');
        $this->db->from('fee_heads FH');
        $this->db->where(array('id'=>$id));
        return $this->db->get()->row(); 
    }

    function head_delete($whr=array()){
        return $this->db->delete('fee_heads',$whr);
    }

    /********************Fee Group functions***************/
    public function get_fee_groups($running_year=false,$school_id=false) {
        _school_cond('FG.school_id',$school_id);
        _year_cond('FG.running_year',$running_year);
        $this->db->select('FG.*,(SELECT count(*) FROM fee_charge_setups WHERE fee_group_id=FG.id) in_setups');
        $this->db->from('fee_groups FG');
        return $this->db->get()->result(); 
    }

    public function save_fee_group($data) {
        $flag = false;
        if(isset($data['id']) && $data['id']){
            $this->db->update('fee_groups', $data, array('id'=>$data['id']));
            $flag = $data['id'];
        }else{
            $this->db->insert('fee_groups', $data);
            $flag = $this->db->insert_id();
        }
        return $flag;
    }

    function save_group_relation($group_id,$post=array()){
        //save heads
        //echo '<pre>';print_r($post);exit;
        $heads = isset($post['heads'])?$post['heads']:array();
        $head_amts = isset($post['head_amount'])?$post['head_amount']:array();
        $head_taxes = isset($post['head_tax'])?$post['head_tax']:array();
        $classes = isset($post['classes'])?$post['classes']:array();
        $this->db->delete('fee_rel_group_heads',array('group_id'=>$group_id));
        $save_array = array();
        if($heads){
            foreach($heads as $h_id){
                $save_array[] = array('group_id'=>$group_id,
                                      'head_id'=>$h_id,
                                      'head_amount'=>(isset($head_amts[$h_id])?$head_amts[$h_id]:0),
                                      'head_tax'=>(isset($head_taxes[$h_id])?$head_taxes[$h_id]:0));
            }
            $this->db->insert_batch('fee_rel_group_heads', $save_array); 
        }

        //save classes
        $this->db->delete('fee_rel_group_class',array('group_id'=>$group_id));
        $save_array = array();
        if($classes){
            foreach($classes as $c_id){
                $save_array[] = array('group_id'=>$group_id,
                                      'class_id'=>$c_id,
                                      'running_year'=>_getYear(),
                                      'school_id'=>_getSchoolid());
            }
            $this->db->insert_batch('fee_rel_group_class', $save_array);
        }
        return true;
    }
 
    function get_group_record($id){
        $this->db->select('FG.*,(SELECT count(*) FROM fee_charge_setups WHERE fee_group_id=FG.id) in_setups');
        $this->db->from('fee_groups FG');
        $this->db->where(array('FG.id'=>$id));
        return $this->db->get()->row(); 
    }

    function group_delete($whr=array()){
        $this->db->delete('fee_rel_group_heads',array('group_id'=>$whr['id']));
        $this->db->delete('fee_rel_group_class',array('group_id'=>$whr['id']));
        return $this->db->delete('fee_groups',$whr);
    }
    
    function get_group_rel($group_id=false){
        $data['rel_heads'] = $this->db->get_where('fee_rel_group_heads',array('group_id'=>$group_id))->result();
        $data['rel_classes'] = $this->db->get_where('fee_rel_group_class',array('group_id'=>$group_id))->result();
        return $data;
    }

    function get_group_heads($group_id=false){
        $this->db->select('FH.*,FRGH.head_amount,FRGH.head_tax');
        $this->db->from('fee_heads FH');
        $this->db->join('fee_rel_group_heads FRGH','FRGH.head_id=FH.id','LEFT');
        $this->db->where('FRGH.group_id',$group_id);
        return $this->db->get()->result();
    }   
    
    function get_group_classes($group_id=false){
        $this->db->select('C.*');
        $this->db->from('class C');
        $this->db->join('fee_rel_group_class FRGC','FRGC.class_id=C.class_id','LEFT');
        $this->db->where('FRGC.group_id',$group_id);
        return $this->db->get()->result();
    }  

    /********************Fee Concessions functions***************/
    public function get_fee_concessions($running_year=false) {
        _school_cond();
        _year_cond('running_year',$running_year);
        return $this->db->get('fee_concessions')->result(); 
    }

    public function save_fee_concession($data) {
        $flag = false;
        if(isset($data['id']) && $data['id']){
            $this->db->update('fee_concessions', $data, array('id'=>$data['id']));
            return $data['id'];
        }else{
            $this->db->insert('fee_concessions', $data);
            $flag = $this->db->insert_id();
        }
        return $flag;
    }

    function get_concession_record($id){
        return $this->db->get_where('fee_concessions',array('id'=>$id))->row();
    }
    
    function concession_delete($whr=array()){
        $this->db->delete('fee_rel_concession_trans',array('concession_id'=>$whr['id']));
        return $this->db->delete('fee_concessions',$whr);
    }
    
    //Get fee setup relation
    function save_concession_rel($concession_id,$items=array()){
        //$this->db->delete('fee_rel_concession_trans',array('concession_id'=>$concession_id));
        $save_data = array();
        foreach($items as $itm){
            $save_data[] = array('concession_id'=>$concession_id,'rel_id'=>$itm);
        }
        return $this->db->insert_batch('fee_rel_concession_trans', $save_data);
    }

    function get_concess_rel_fee_groups($concess_id=false,$sel=1,$whr=array()){
        $rel_arr = array();
        if($sel && $concess_id){
           $rel_rec = $this->db->select('GROUP_CONCAT(rel_id) ids')->get_where('fee_rel_concession_trans',array('concession_id'=>$concess_id))->row(); 
           $rel_arr = $rel_rec?explode(',',$rel_rec->ids):array();          
        }

        _school_cond('FG.school_id');
        _year_cond('FG.running_year');
        $this->db->select('FG.*,(0) trans');
        $this->db->from('fee_groups FG');
        if($sel==1){
            $this->db->where_in('FG.id',$rel_arr);
        }else if($sel==2){
            $this->db->where_not_in('FG.id',$rel_arr);
        }
        $this->db->where($whr);
        $this->db->order_by('FG.name','ASC');
        return $this->db->get()->result(); 
    }

    function get_concess_rel_classes($concess_id=false,$sel=1,$whr=array()){
        $rel_arr = array();
        if($sel && $concess_id){
           $rel_rec = $this->db->select('GROUP_CONCAT(rel_id) ids')->get_where('fee_rel_concession_trans',array('concession_id'=>$concess_id))->row(); 
           $rel_arr = $rel_rec?explode(',',$rel_rec->ids):array();          
        }

        _school_cond('C.school_id');
        //_year_cond('FG.running_year');
        $this->db->select('C.*,(0) trans');
        $this->db->from('class C');
        if($sel==1){
            $this->db->where_in('C.class_id',$rel_arr);
        }else if($sel==2){
            $this->db->where_not_in('C.class_id',$rel_arr);
        }
        $this->db->where($whr);
        $this->db->order_by('C.name_numeric','ASC');
        return $this->db->get()->result(); 
    }

    function get_concess_rel_students($concess_id=false,$sel=1,$whr=array()){
        $rel_arr = array();
        if($sel && $concess_id){
           $rel_rec = $this->db->select('GROUP_CONCAT(rel_id) ids')->get_where('fee_rel_concession_trans',array('concession_id'=>$concess_id))->row(); 
           $rel_arr = $rel_rec?explode(',',$rel_rec->ids):array();          
        }

        _school_cond('S.school_id');
        _year_cond('E.year');
        $this->db->select('S.*,C.name class_name,SC.name section_name');  
        $this->db->from('student S');
        $this->db->join('enroll E','E.student_id=S.student_id','LEFT');
        $this->db->join('class C','C.class_id=E.class_id','LEFT');  
        $this->db->join('section SC','SC.section_id=E.section_id','LEFT');  
        if($sel==1){
            $this->db->where_in('S.student_id',$rel_arr);
        }else if($sel==2){
            $this->db->where_not_in('S.student_id',$rel_arr);
        }
        $this->db->where($whr);
        $this->db->order_by('S.name','ASC'); 
        $this->db->order_by('S.lname','ASC');
        return $this->db->get()->result();
    }    

    function del_concess_rel($whr=array()){
        return $this->db->delete('fee_rel_concession_trans',$whr);
    }

    /********************Fee Scholarship functions***************/
    public function get_fee_scholarships($running_year=false) {
        _school_cond();
        _year_cond('running_year',$running_year);
        return $this->db->get('fee_scholarships')->result(); 
    }

    public function save_fee_scholarhship($data) {
        $flag = false;
        if(isset($data['id']) && $data['id']){
            $this->db->update('fee_scholarships', $data, array('id'=>$data['id']));
            return $data['id'];
        }else{
            $this->db->insert('fee_scholarships', $data);
            $flag = $this->db->insert_id();
        }
        return $flag;
    }

    function get_scholarship_record($id){
        return $this->db->get_where('fee_scholarships',array('id'=>$id))->row();
    }

    function scholarship_delete($whr=array()){
        return $this->db->delete('fee_scholarships',$whr);
    }

    /********************Fee Collection_Group functions***************/
    function get_charge_setups($running_year=false,$school_id=false) {
        _school_cond('FCS.school_id',$school_id);
        _year_cond('FCS.running_year',$running_year);
        $this->db->select('FCS.*,FG.name fee_group_name,FT.name fee_term_name,(0) trans,');
        $this->db->from('fee_charge_setups FCS');
        $this->db->join('fee_groups FG','FG.id=FCS.fee_group_id','LEFT');
        $this->db->join('fee_terms FT','FT.id=FCS.fee_term_id','LEFT');
        return $this->db->get()->result(); 
    }

    function save_charge_setup($data) {
        $flag = false;
        if(isset($data['id']) && $data['id']){
            $this->db->update('fee_charge_setups', $data, array('id'=>$data['id']));
            $flag = $data['id'];
        }else{
            $this->db->insert('fee_charge_setups', $data);
            $flag = $this->db->insert_id();
        }
        return $flag;
    }

    function get_charge_setup_record($whr=array()){
        _school_cond();
        _year_cond();
        return $this->db->get_where('fee_charge_setups',$whr)->row();
    }

    function charge_setup_delete($whr=array()){
        $this->db->delete('fee_setup_terms',array('charge_setup_id'=>$whr['id']));
        $this->db->delete('fee_setup_term_heads',array('charge_setup_id'=>$whr['id']));
        return $this->db->delete('fee_charge_setups',$whr);
    }

    function save_charge_setup_terms($charge_setup_id=false,$setup_terms=array()) {
        $flag = false;
        //$this->db->delete('fee_collections',array('collectin_group_id'=>$group_id));
        ///$this->db->delete('fee_collection_particulars',array('collectin_group_id'=>$group_id));
        $save_data = array();
        if($setup_terms){
            foreach($setup_terms as $tk=>$sterm){
                $save_array = array('charge_setup_id'=>$charge_setup_id,
                                    'name'=>$sterm['name'],
                                    'start_date'=>$sterm['start_date'],
                                    'end_date'=>$sterm['end_date'],
                                    'fine_id'=>$sterm['fine_id'],
                                    'amount'=>$sterm['amount'],
                                    'order'=>$tk,
                                    'created'=>date('Y-m-d H:i:s'));
                if(isset($sterm['id']) && $sterm['id']!=''){
                    $this->db->update('fee_setup_terms', $save_array, array('id'=>$sterm['id']));
                    $flag = $sterm['id'];
                }else{
                    $this->db->insert('fee_setup_terms', $save_array);
                    $flag = $this->db->insert_id();
                }

                $this->save_charge_setup_heads($charge_setup_id,$flag,$sterm['heads']);
            }
        }
        
        return $flag;
    }

    function save_charge_setup_heads($charge_setup_id=false,$setup_term_id=false,$heads=array()) {
        $flag = false;
        $this->db->delete('fee_setup_term_heads',array('setup_term_id'=>$setup_term_id));
        $save_data = array();
        if($heads){
            foreach($heads as $id=>$amt){
                $save_array = array('charge_setup_id'=>$charge_setup_id,
                                    'setup_term_id'=>$setup_term_id,
                                    'head_id'=>$id,
                                    'amount'=>$amt,
                                    'created'=>date('Y-m-d H:i:s'));
               /*  if(isset($collect['id']) && $collect['id']){
                    $this->db->update('fee_collection_groups', $save_array, array('id'=>$data['id']));
                    $flag = $collect['id'];
                }else{ */
                    $this->db->insert('fee_setup_term_heads', $save_array);
                    $flag = $this->db->insert_id();
                //}
            }
        }
        
        return $flag;
    }

    function get_charge_setup_rel($charge_setup_id=false){
        $return = array();
        $setup_terms = $this->db->get_where('fee_setup_terms',array('charge_setup_id'=>$charge_setup_id))->result();
        foreach($setup_terms as $st){
            $this->db->select('FSTH.*,FH.name');
            $this->db->from('fee_heads FH');
            $this->db->join('fee_setup_term_heads FSTH','FSTH.head_id=FH.id','LEFT');
            $this->db->where('FSTH.setup_term_id',$st->id);
            $st->heads = $this->db->get()->result();
            $return[] = $st;
        }
        //$data['collection_particulars'] = $this->db->get_where('fee_collection_particulars',array('collection_group_id'=>$collection_group_id))->result();

        return $return;
    }

    function setup_term_delete($whr=array()){
        $this->db->delete('fee_setup_term_heads',array('setup_term_id'=>$whr['id']));
        return $this->db->delete('fee_setup_terms',$whr);
    }

    //Hostel Fee Setup Functions
    function get_hostel_fee_setup($whr=array()) {
        _school_cond('HCS.school_id');
        _year_cond('HCS.running_year');
        $this->db->select('HCS.*,FT.name fee_term_name');
        $this->db->from('fee_hostel_charge_setups HCS');
        $this->db->join('fee_terms FT','FT.id=HCS.fee_term_id','LEFT');
        $this->db->where($whr);
        return $this->db->get()->row(); 
    }
    
    function save_hostel_fee_setup($data) {
        $whr = array('HCS.fee_term_id'=>$data['fee_term_id']);
        $record = $this->get_hostel_fee_setup($whr);

        $flag = false;
        if($record){
            $this->db->update('fee_hostel_charge_setups', $data, array('id'=>$record->id));
            $flag = $record->id;
        }else{
            $data['running_year'] = $this->session->userdata('running_year');
            $data['school_id'] = $this->session->userdata('school_id');
            $this->db->insert('fee_hostel_charge_setups', $data);
            $flag = $this->db->insert_id();
        }
        return $flag;
    }

    function save_hostel_setup_terms($setup_id=false,$setup_terms=array()) {
        $flag = false;
        //$this->db->delete('fee_collections',array('collectin_group_id'=>$group_id));
        ///$this->db->delete('fee_collection_particulars',array('collectin_group_id'=>$group_id));
        $save_data = array();
        if($setup_terms){
            foreach($setup_terms as $tk=>$sterm){
                $save_array = array('setup_id'=>$setup_id,
                                    'name'=>$sterm['name'],
                                    'start_date'=>$sterm['start_date'],
                                    'end_date'=>$sterm['end_date'],
                                    'fine_id'=>$sterm['fine_id'],
                                    'amt_type'=>$sterm['amt_type'],
                                    'amount'=>$sterm['amount'],
                                    'order'=>$tk,
                                    'created'=>date('Y-m-d H:i:s'));
                if(isset($sterm['id']) && $sterm['id']!=''){
                    $this->db->update('fee_hotel_setup_terms', $save_array, array('id'=>$sterm['id']));
                    $flag = $sterm['id'];
                }else{
                    $this->db->insert('fee_hotel_setup_terms', $save_array);
                    $flag = $this->db->insert_id();
                }
            }
        }
        
        return $flag;
    }

    function get_hotel_setup_rel($setup_id=false){
        return $this->db->get_where('fee_hotel_setup_terms',array('setup_id'=>$setup_id))->result();
    }

    //Transport Fee Setup Functions
    function get_transport_fee_setup($running_year=false,$school_id=false,$whr=array()) {
        _school_cond('TCS.school_id',$school_id);
        _year_cond('TCS.running_year',$running_year);
        $this->db->select('TCS.*,FT.name fee_term_name');
        $this->db->from('fee_transport_charge_setups TCS');
        $this->db->join('fee_terms FT','FT.id=TCS.fee_term_id','LEFT');
        $this->db->where($whr);
        return $this->db->get()->row(); 
    }
    
    function save_transport_fee_setup($data) {
        $whr = array('TCS.fee_term_id'=>$data['fee_term_id']);
        $record = $this->get_transport_fee_setup(false,false,$whr);

        $flag = false;
        if($record){
            $this->db->update('fee_transport_charge_setups', $data, array('id'=>$record->id));
            $flag = $record->id;
        }else{
            $data['running_year'] = $this->session->userdata('running_year');
            $data['school_id'] = $this->session->userdata('school_id');
            $this->db->insert('fee_transport_charge_setups', $data);
            $flag = $this->db->insert_id();
        }
        return $flag;
    }

    function save_transport_setup_terms($setup_id=false,$setup_terms=array()) {
        $flag = false;
        //$this->db->delete('fee_collections',array('collectin_group_id'=>$group_id));
        ///$this->db->delete('fee_collection_particulars',array('collectin_group_id'=>$group_id));
        $save_data = array();
        if($setup_terms){
            foreach($setup_terms as $tk=>$sterm){
                $save_array = array('setup_id'=>$setup_id,
                                    'name'=>$sterm['name'],
                                    'start_date'=>$sterm['start_date'],
                                    'end_date'=>$sterm['end_date'],
                                    'fine_id'=>$sterm['fine_id'],
                                    'amt_type'=>$sterm['amt_type'],
                                    'amount'=>$sterm['amount'],
                                    'order'=>$tk,
                                    'created'=>date('Y-m-d H:i:s'));
                if(isset($sterm['id']) && $sterm['id']!=''){
                    $this->db->update('fee_transport_setup_terms', $save_array, array('id'=>$sterm['id']));
                    $flag = $sterm['id'];
                }else{
                    $this->db->insert('fee_transport_setup_terms', $save_array);
                    $flag = $this->db->insert_id();
                }
            }
        }
        
        return $flag;
    }

    function get_transport_setup_rel($setup_id=false){
        return $this->db->get_where('fee_transport_setup_terms',array('setup_id'=>$setup_id))->result();
    }



    //Transport Fee Setup Functions
    /* function get_transport_fee_setup($running_year=false,$school_id=false,$whr=array()) {
        _school_cond('TCS.school_id',$school_id);
        _year_cond('TCS.running_year',$running_year);
        $this->db->select('HCS.*,FT.name fee_term_name');
        $this->db->from('fee_transport_charge_setups TCS');
        $this->db->join('fee_terms FT','FT.id=TCS.fee_term_id','LEFT');
        $this->db->where($whr);
        return $this->db->get()->row(); 
    }
    
    function save_transport_fee_setup($data) {
        $whr = array('fee_term_id'=>$data['fee_term_id']);
        $record = $this->get_hotel_fee_setup(false,false,$whr);

        $flag = false;
        if($record){
            $this->db->update('fee_transport_charge_setups', $data, array('id'=>$record->id));
            $flag = $data['id'];
        }else{
            $this->db->insert('fee_transport_charge_setups', $data);
            $flag = $this->db->insert_id();
        }
        return $flag;
    }

    function save_transport_setup_terms($setup_id=false,$setup_terms=array()) {
        $flag = false;
        //$this->db->delete('fee_collections',array('collectin_group_id'=>$group_id));
        ///$this->db->delete('fee_collection_particulars',array('collectin_group_id'=>$group_id));
        $save_data = array();
        if($setup_terms){
            foreach($setup_terms as $tk=>$sterm){
                $save_array = array('setup_id'=>$setup_id,
                                    'name'=>$sterm['name'],
                                    'start_date'=>$sterm['start_date'],
                                    'end_date'=>$sterm['end_date'],
                                    'fine_id'=>$sterm['fine_id'],
                                    'order'=>$tk,
                                    'created'=>date('Y-m-d H:i:s'));
                if(isset($sterm['id']) && $sterm['id']!=''){
                    $this->db->update('fee_transport_setup_terms', $save_array, array('id'=>$sterm['id']));
                    $flag = $sterm['id'];
                }else{
                    $this->db->insert('fee_transport_setup_terms', $save_array);
                    $flag = $this->db->insert_id();
                }
            }
        }
        
        return $flag;
    } */

    /********************Fee Fines functions***************/
    public function get_fee_fines($running_year=false) {
        _school_cond();
        _year_cond();
        return $this->db->get_where('fee_fines')->result(); 
    }

    public function save_fine($data) {
        $flag = false;
        if(isset($data['id']) && $data['id']){
            $this->db->update('fee_fines', $data, array('id'=>$data['id']));
            $flag = $data['id'];
        }else{
            $this->db->insert('fee_fines', $data);
            $flag = $this->db->insert_id();
        }
        return $flag;
    }

    function get_fine_record($id){
        return $this->db->get_where('fee_fines',array('id'=>$id))->row();
    }

    function fine_delete($whr=array()){
        return $this->db->delete('fee_fines',$whr);
    }

    /********************Other functions***************/
    function get_classes(){
        _school_cond();
        return $this->db->order_by('name_numeric','ASC')->get('class')->result(); 
    }

    function get_students($whr=array(),$having=array()){
        _school_cond('S.school_id');
        _year_cond('E.year');
        $this->db->select('S.*,C.name class_name,SC.name section_name,E.enroll_code,
        (SELECT count(*) FROM fee_stu_config 
        WHERE student_id=S.student_id AND school_id='._getSchoolid().' AND running_year="'._getYear().'") has_config',false);  
        $this->db->from('student S');
        $this->db->join('enroll E','E.student_id=S.student_id','LEFT');
        $this->db->join('class C','C.class_id=E.class_id','LEFT');  
        $this->db->join('section SC','SC.section_id=E.section_id','LEFT'); 
        $this->db->order_by('S.name','ASC'); 
        $this->db->order_by('S.lname','ASC');
        foreach($whr as $wk=>$wval){
            if($wval)
                $this->db->where($wk,$wval);
            else    
                $this->db->where($wk);
        }
        $this->db->having($having); 
        return $this->db->get()->result();
    }

    function save_stu_config($config=array()){
        return $this->db->insert('fee_stu_config',$config);
    }

    function get_collection_data(){        
        $this->db->select('fc.id, fc.name collection_name');
        $this->db->from($this->_table_fee_collections.' fc');
        $this->db->order_by('fc.name', 'asc');
        return $this->db->get()->result_array();
    }

    function add_fi_category($data){
        $this->db->insert($this->_table_fi_category, $data);
        return $this->db->insert_id();
    }

    function get_all_fi_category(){
        $school_id = $this->session->userdata('school_id');
        $where = array('school_id'=>$school_id, 'fi_category_status'=>'1');
        return $this->db->get_where($this->_table_fi_category,$where)->result_array();
    }

    public function update_fi_category($data, $param2) {       
        $this->db->update($this->_table_fi_category, $data, array('fi_category_id'=>$param2));
    }

    function delete_fi_category($id){
        return $this->db->delete($this->_table_fi_category, array('fi_category_id'=>$id));
    }

    function get_fi_category($category_type){
        $school_id = $this->session->userdata('school_id');
        $where = array('fc.school_id'=>$school_id, 'fc.fi_category_status'=>'1', 'fc.category_type'=>$category_type);
        $this->db->select('fc.fi_category_id, fc.category_name');
        $this->db->from($this->_table_fi_category.' fc');
        $this->db->order_by('fc.category_name', 'asc');
        $this->db->where($where);
        return $this->db->get()->result_array();
    }

    //Employee Slip Management
    function generated_employe_payslips($month,$whr=array()){
        _school_cond('ES.school_id');
        //_year_cond('ES.school_id');
        $subquery = ",(SELECT is_paid FROM payroll_payslip WHERE emp_id=ES.user_id 
         AND MONTH(generate_date)='".date('m',strtotime('01-'.$month))."'
         AND YEAR(generate_date)='".date('Y',strtotime('01-'.$month))."' LIMIT 1) is_paid,
        
        (SELECT id FROM payroll_payslip WHERE emp_id=ES.user_id 
         AND MONTH(generate_date)='".date('m',strtotime('01-'.$month))."'
         AND YEAR(generate_date)='".date('Y',strtotime('01-'.$month))."' LIMIT 1) payslip_id,
         
         (SELECT generate_date FROM payroll_payslip WHERE emp_id=ES.user_id 
         AND MONTH(generate_date)='".date('m',strtotime('01-'.$month))."'
         AND YEAR(generate_date)='".date('Y',strtotime('01-'.$month))."' LIMIT 1) generate_date,
         
         (SELECT net_pay FROM payroll_payslip WHERE emp_id=ES.user_id 
         AND MONTH(generate_date)='".date('m',strtotime('01-'.$month))."'
         AND YEAR(generate_date)='".date('Y',strtotime('01-'.$month))."' LIMIT 1) net_pay";
        $this->db->select('ES.*,ESD.*'.$subquery);
        $this->db->from('main_employees_summary ES');
        $this->db->join('main_empsalarydetails ESD','ESD.user_id =ES.user_id','LEFT');
        //$this->db->join('payroll_payslip PP',' PP.emp_id=ES.user_id','LEFT');
        $this->db->where($whr);
        //$this->db->where('PP.id IS NOT NULL');
        $this->db->having('payslip_id IS NOT NULL');
        $this->db->order_by('ES.firstname','DESC');
        return $this->db->get()->result();
    }
    
    function get_employee_roles(){
        return $this->db->order_by('rolename','ASC')->get_where('main_roles',array('isactive'=>1))->result();
    }

    //Get Enquired Student Amount Collected
    function get_enquired_collected_amount(){

    }
}
