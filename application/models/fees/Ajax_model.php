<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_model extends CI_Model {

    public function __construct() {
        parent::__construct();        
    }
   
    function get_students($whr=array(),$having=array()){
        _school_cond('S.school_id');
        _year_cond('E.year');
        $this->db->select('S.*,C.name class_name,SC.name section_name,E.enroll_code,E.class_id,E.section_id,P.email parent_email,P.cell_phone parent_mobile,
        CONCAT(P.father_name," ",P.father_lname) father_full_name,
        (SELECT count(*) FROM fee_stu_config WHERE student_id=S.student_id AND school_id=E.school_id AND running_year=E.year) has_config',FALSE);  
        $this->db->from('student S');
        $this->db->join('enroll E','E.student_id=S.student_id','LEFT');
        $this->db->join('class C','C.class_id=E.class_id','LEFT');  
        $this->db->join('section SC','SC.section_id=E.section_id','LEFT'); 
        $this->db->join('parent P','P.parent_id=S.parent_id','LEFT');  
        foreach($whr as $wk=>$wval){
            if($wval)
                $this->db->where($wk,$wval);
            else    
                $this->db->where($wk);
        }
        foreach($having as $wk=>$wval){
            if($wval!==FALSE){
                $this->db->having($wk,$wval);
            }else{
                $this->db->having($wk);
            }    
        }
        $this->db->order_by('S.name ASC, S.lname ASC');
        return $this->db->get()->result();
    }

    function get_student($whr=array(),$having=array()){
        _school_cond('S.school_id');
        _year_cond('E.year');
        $this->db->select('S.*,E.class_id,E.section_id,C.name class_name,SC.name section_name,E.enroll_code,E.date_added,
                          P.father_name,P.father_lname,P.mother_name,P.mother_lname,P.email parent_email,P.cell_phone parent_phone,
                          P.city,P.state,P.zip_code,P.country,
                          (SELECT count(*) FROM fee_stu_config WHERE student_id=S.student_id AND school_id=E.school_id 
                          AND running_year=E.year) has_config',false);  
        $this->db->from('student S');
        $this->db->join('enroll E','E.student_id=S.student_id','LEFT'); 
        $this->db->join('class C','C.class_id=E.class_id','LEFT');  
        $this->db->join('section SC','SC.section_id=E.section_id','LEFT');  
        $this->db->join('parent P','P.parent_id=S.parent_id','LEFT'); 
        foreach($whr as $wk=>$wval){
            if($wval)
                $this->db->where($wk,$wval);
            else    
                $this->db->where($wk);
        }
        foreach($having as $wk=>$wval){
            if($wval!==FALSE){
                $this->db->having($wk,$wval);
            }else{
                $this->db->having($wk);
            }    
        }
        $this->db->order_by('S.name ASC, S.lname ASC');
        return $this->db->get()->row();
    }

    function get_non_enroll_students(){
        _school_cond();
        $this->db->order_by('student_fname','ASC');
        return $this->db->get_where('enquired_students',array('form_genreated'=>0))->result();
    }
    
    function get_non_enroll_student($whr=array()){
        _school_cond();
        $whr['form_genreated']=0;
        return $this->db->get_where('enquired_students',$whr)->row();
    }

    function get_non_enroll_heads($whr=array()){
        _school_cond();
        _year_cond();
        $this->db->order_by('name','ASC');
        $whr['non_enroll'] = 1;
        return $this->db->get_where('fee_heads',$whr)->result();
    }

    function get_student_term_fees($student_id){
        $return = array();
        $enroll = $this->db->get_where('enroll',array('student_id'=>$student_id))->row();
        
        _school_cond('FG.school_id');
        _year_cond('FG.running_year');
        $this->db->select('FG.*');  
        $this->db->from('fee_groups FG');
        $this->db->join('fee_rel_group_class FRGC','FRGC.group_id=FG.id','LEFT'); 
        $this->db->where(array('FRGC.class_id'=>$enroll->class_id));
        $group_rec = $this->db->get()->row();
        if(!$group_rec)
            return $return;

        
        _school_cond();
        _year_cond();
        $fee_setup = $this->db->get_where('fee_charge_setups',array('fee_group_id'=>$group_rec->id))->row();
        if(!$fee_setup)
            return $return;

        //Fee Setup Terms
        $setup_terms = $this->db->get_where('fee_setup_terms',array('charge_setup_id'=>$fee_setup->id))->result();
        foreach($setup_terms as $st){
            $this->db->select('FSTH.*,FH.name');
            $this->db->from('fee_heads FH');
            $this->db->join('fee_setup_term_heads FSTH','FSTH.head_id=FH.id','LEFT');
            $this->db->where('FSTH.setup_term_id',$st->id);
            $st->heads = $this->db->get()->result();
            $return[] = $st;
        }
        return $return;
    }

    function get_stu_fee_detail($fee_id=false){
        $term_rec = $this->db->get_where('fee_setup_terms',array('id'=>$fee_id))->row();
        
        $this->db->select('FSTH.*,FH.name');
        $this->db->from('fee_heads FH');
        $this->db->join('fee_setup_term_heads FSTH','FSTH.head_id=FH.id','LEFT');
        $this->db->where('FSTH.setup_term_id',$term_rec->id);
        return $this->db->get()->result();
    }

    function get_fee_group($whr=array()){
        _school_cond('FG.school_id');
        _year_cond('FG.running_year');
        $this->db->select('FG.*');  
        $this->db->from('fee_groups FG');
        $this->db->join('fee_rel_group_class FRGC','FRGC.group_id=FG.id','LEFT'); 
        $this->db->where($whr);
        return $this->db->get()->row();
    }

    function get_stu_config_rec($whr=array()){
        _school_cond();
        _year_cond();
        return $this->db->get_where('fee_stu_config',$whr)->row();
    }

    function get_rel_concession($whr=array()){
        _school_cond('FC.school_id');
        _year_cond('FC.running_year');
        $this->db->select('FC.*');
        $this->db->from('fee_concessions FC');
        $this->db->join('fee_rel_concession_trans FRCT','FRCT.concession_id=FC.id','LEFT');
        $this->db->where($whr);
        return $this->db->get()->result();
    }

    function get_student_fee_config($student_id){
        $return = array('school_fee_terms'=>array(),'hostel_fee_terms'=>array(),'transport_fee_terms'=>array());
        $stu_rec = $this->get_student(array('S.student_id'=>$student_id));
        _school_cond();
        _year_cond();
        $return['fee_config'] = $stu_config = $this->db->get_where('fee_stu_config',array('student_id'=>$student_id))->row();   
        
        if(!$stu_config){
            return $return;    
        }

        _school_cond('FG.school_id');
        _year_cond('FG.running_year');
        $this->db->select('FG.*');  
        $this->db->from('fee_groups FG');
        $this->db->join('fee_rel_group_class FRGC','FRGC.group_id=FG.id','LEFT'); 
        $this->db->where(array('FRGC.class_id'=>$stu_rec->class_id));
        $group_rec = $this->db->get()->row();

        if(!$group_rec){
            return $return;    
        }

        _school_cond();
        _year_cond();
        $school_fee_setup = $this->db->get_where('fee_charge_setups',array('fee_group_id'=>$group_rec->id,'fee_term_id'=>$stu_config->school_term_id))->row();
        
        _school_cond();
        _year_cond();
        $hostel_fee_setup = $this->db->get_where('fee_hostel_charge_setups',array('fee_term_id'=>$stu_config->hostel_term_id))->row();

        _school_cond();
        _year_cond();
        $transport_fee_setup = $this->db->get_where('fee_transport_charge_setups',array('fee_term_id'=>$stu_config->transport_term_id))->row();
        
        //School Setup Terms
        $return['school_fee_terms'] = array();
        if($school_fee_setup){
            $arr = array();
            $this->db->select('FST.*,
                (SELECT FCR.is_paid FROM fee_pay_collection_records FCR WHERE FCR.student_id="'.$student_id.'" AND FCR.class_id="'.$stu_rec->class_id.'" 
                AND FCR.fee_type=1 AND FCR.fee_id=FST.id AND FCR.running_year="'._getYear().'" AND FCR.school_id="'._getSchoolid().'") is_paid,
                (SELECT FCR.net_due FROM fee_pay_collection_records FCR WHERE FCR.student_id="'.$student_id.'" AND FCR.class_id="'.$stu_rec->class_id.'" 
                AND FCR.fee_type=1 AND FCR.fee_id=FST.id AND FCR.running_year="'._getYear().'" AND FCR.school_id="'._getSchoolid().'") net_due',FALSE);
            $this->db->from('fee_setup_terms FST');
            $this->db->where(array('FST.charge_setup_id'=>$school_fee_setup->id));
            $setup_terms = $this->db->get()->result();
            foreach($setup_terms as $st){
                $this->db->select('FSTH.*,FH.name');
                $this->db->from('fee_heads FH');
                $this->db->join('fee_setup_term_heads FSTH','FSTH.head_id=FH.id','LEFT');
                $this->db->where('FSTH.setup_term_id',$st->id);
                $st->heads = $this->db->get()->result();
                $arr[] = $st;
            }
            $return['school_fee_terms'] = $arr;
        }

        _school_cond();
        $return['hostel_room'] = $this->db->get_where('hostel_room',array('hostel_room_id'=>$stu_config->room_id))->row();
        $return['hostel_fee_terms'] = array();
        if($hostel_fee_setup){
            $this->db->select('FST.*,
                (SELECT FCR.is_paid FROM fee_pay_collection_records FCR WHERE FCR.student_id="'.$student_id.'" AND FCR.class_id="'.$stu_rec->class_id.'" 
                AND FCR.fee_type=2 AND FCR.fee_id=FST.id AND FCR.running_year="'._getYear().'" AND FCR.school_id="'._getSchoolid().'") is_paid,
                (SELECT FCR.net_due FROM fee_pay_collection_records FCR WHERE FCR.student_id="'.$student_id.'" AND FCR.class_id="'.$stu_rec->class_id.'" 
                AND FCR.fee_type=2 AND FCR.fee_id=FST.id AND FCR.running_year="'._getYear().'" AND FCR.school_id="'._getSchoolid().'") net_due',FALSE);
            $this->db->from('fee_hotel_setup_terms FST');
            $this->db->where(array('FST.setup_id'=>$hostel_fee_setup->id));
            $return['hostel_fee_terms'] = $this->db->get()->result();
            //$return['hostel_fee_terms'] = $this->db->get_where('fee_hotel_setup_terms',array('setup_id'=>$hostel_fee_setup->id))->result();
        }
        
        _school_cond();
        $return['route_stop'] = $this->db->get_where('route_bus_stop',array('route_bus_stop_id'=>$stu_config->route_stop_id))->row();
        $return['transport_fee_terms'] = array();
        if($transport_fee_setup){
            $this->db->select('FST.*,
                (SELECT FCR.is_paid FROM fee_pay_collection_records FCR WHERE FCR.student_id="'.$student_id.'" AND FCR.class_id="'.$stu_rec->class_id.'" 
                AND FCR.fee_type=3 AND FCR.fee_id=FST.id AND FCR.running_year="'._getYear().'" AND FCR.school_id="'._getSchoolid().'") is_paid,
                (SELECT FCR.net_due FROM fee_pay_collection_records FCR WHERE FCR.student_id="'.$student_id.'" AND FCR.class_id="'.$stu_rec->class_id.'" 
                AND FCR.fee_type=3 AND FCR.fee_id=FST.id AND FCR.running_year="'._getYear().'" AND FCR.school_id="'._getSchoolid().'") net_due',FALSE);
            $this->db->from('fee_transport_setup_terms FST');
            $this->db->where(array('FST.setup_id'=>$transport_fee_setup->id));
            $return['transport_fee_terms'] = $this->db->get()->result();
            //$return['transport_fee_terms'] = $this->db->get_where('fee_transport_setup_terms',array('setup_id'=>$transport_fee_setup->id))->result();  
        }
        return $return;
    }

    //At Pay
    function save_fee_collection_record($data=array()){
        if(isset($data['id'])){
            return $this->db->update('fee_pay_collection_records',$data,array('id'=>$data['id']));
        }else{
            $this->db->insert('fee_pay_collection_records',$data);
            return $this->db->insert_id();
        }
    }

    function get_fee_collection_record($whr=array()){
        _school_cond();
        _year_cond();
        $crecord = $this->db->get_where('fee_pay_collection_records',$whr)->row();
        if($crecord){
            /* $pay_trans = array();
            $pay_trns = $this->db->get_where('fee_pay_transactions',array('pay_collection_record_id'=>$crecord->id))->result();
            foreach($pay_trns as $ptrn){
                $ptrn->item_trans = $this->db->get_where('fee_pay_item_transactions',array('pay_trans_id'=>$ptrn->id))->result();
                $pay_trans[] = $ptrn;
            } */
            $crecord->pay_trans = $this->db->get_where('fee_pay_transactions',array('pay_collection_record_id'=>$crecord->id))->result();
            $crecord->item_trans = $this->db->get_where('fee_pay_item_transactions',array('pay_collection_record_id'=>$crecord->id))->result();
        }
        return $crecord;
    }
    
    function save_pay_trans($data=array()){
        if(isset($data['id'])){
            return $this->db->update('fee_pay_transactions',$data,array('id'=>$data['id']));
        }else{
            $this->db->insert('fee_pay_transactions',$data);
            return $this->db->insert_id();
        }
    }

    function get_pay_trans($whr=array(),$having=array()){
        
        _school_cond('PCR.school_id');
        _year_cond('PCR.running_year');
        $this->db->select('PT.*,PCR.student_status,PCR.student_id,PCR.class_id,PCR.fee_type,PCR.fee_id,PCR.is_paid,PCR.net_amount,PCR.net_due');
        $this->db->from('fee_pay_transactions PT');
        $this->db->join('fee_pay_collection_records PCR','PCR.id=PT.pay_collection_record_id','LEFT');
        $this->db->where($whr);
        if($having)
            $this->db->having($having);
        $record = $this->db->get()->row();
        $record->payment_trans = array();
        if($record){
            $record->payment_trans = $this->db->get_where('fee_payment_item_transactions',array('pay_trans_id'=>$record->id))->result();
        }
        return $record;
    }    

    function get_next_pay_trans_receipt_no($whr=array()){
        _school_cond();
        _year_cond();
        $last_rec = $this->db->order_by('receipt_no','DESC')->get_where('fee_pay_transactions',$whr)->row();
        return $last_rec?($last_rec->receipt_no+1):1;
    }

    function save_pay_item_trans($data=array()){
        if(isset($data['id'])){
            return $this->db->update('fee_pay_item_transactions',$data,array('id'=>$data['id']));
        }else{
            $this->db->insert('fee_pay_item_transactions',$data);
            return $this->db->insert_id();
        }
    }

    function get_pay_item_trans($whr=array()){
        return $this->db->get_where('fee_pay_item_transactions',$whr)->row();
    }

    function save_payment_item_trans($data=array()){
        if(isset($data['id'])){
            return $this->db->update('fee_payment_item_transactions',$data,array('id'=>$data['id']));
        }else{
            $this->db->insert('fee_payment_item_transactions',$data);
            return $this->db->insert_id();
        }
    }

    function get_payment_item_trans($whr=array()){
        return $this->db->get_where('fee_payment_item_transactions',$whr)->row();
    }

    //Get terms by class
    function get_terms_by_class($class_id=false){
        $return = array();
        _school_cond();_year_cond();
        $group_rec = $this->db->select('GROUP_CONCAT(group_id) ids')->get_where('fee_rel_group_class',array('class_id'=>$class_id))->row();
        $group_ids = $group_rec?explode(',',$group_rec->ids):array(); 
        if($group_ids){
            _school_cond('FCS.school_id');
            _year_cond('FCS.running_year');
            $this->db->select('FST.*');
            $this->db->from('fee_setup_terms FST');
            $this->db->join('fee_charge_setups FCS','FCS.id=FST.charge_setup_id','LEFT');
            $this->db->where_in('FCS.fee_group_id',$group_ids);
            $this->db->order_by('FST.start_date');
            $return = $this->db->get()->result();
        }
        return $return; 
    }

    function get_setup_terms($whr=array()){
        $return = array();
        _school_cond();
        _year_cond();
        $setup = $this->db->get_where('fee_charge_setups',$whr)->row();
        if($setup){
            $return = $this->db->order_by('start_date ASC')->get_where('fee_setup_terms',array('charge_setup_id'=>$setup->id))->result();    
        }
        return $return;
    }

    function get_due_fee_students($type=false,$class_id=false,$fee_id=false){
        $return = array();
        
        _school_cond('S.school_id');
        _year_cond('E.year');

        /* if(strtolower($type)=='school'){
            $sub_query = ',(SELECT COUNT(*) FROM fee_pay_collection_records WHERE student_status=1 AND student_id = S.student_id
                            AND class_id="'.$class_id.'" AND fee_type="school" AND fee_id="'.$fee_id.'" AND is_paid=1) paid_record';
        } */
        $sub_query = ',(SELECT COUNT(*) FROM fee_pay_collection_records WHERE student_status=1 AND student_id = S.student_id
        AND class_id="'.$class_id.'" AND fee_type="'.strtolower($type).'" AND fee_id="'.$fee_id.'" AND is_paid=1) paid_record';

        $this->db->select('S.*,E.enroll_code,C.name class_name,SC.name section_name'.$sub_query);  
        $this->db->from('student S');
        $this->db->join('enroll E','E.student_id=S.student_id','LEFT');
        $this->db->join('class C','C.class_id=E.class_id','LEFT');  
        $this->db->join('section SC','SC.section_id=E.section_id','LEFT');  
        $this->db->where(array('E.class_id'=>$class_id));
        $this->db->having('paid_record',0);
        $this->db->order_by('S.name','ASC'); 
        $this->db->order_by('S.lname','ASC');
        $return = $this->db->get()->result();

        return $return;
    }
    

}
