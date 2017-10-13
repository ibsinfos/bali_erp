<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ajax extends CI_Controller {

    public $globalSettingsSMSDataArr = array();
    public $globalSettingsLocation = "";
    public $globalSettingsAppPackageName = "";
    public $globalSettingsRunningYear = "";
    public $globalSettingsSystemName = "";
    public $globalSettingsSystemEamil = "";
    public $globalSettingsSystemFCMServerrKey = "";
    public $globalSettingsTextAlign = "";
    public $globalSettingsActiveSmsService = "";
    public $globalSettingsSkinColour = "";
    public $globalSettingsSystemTitle = "";
    public $school_id;
    public $running_year;
    
    function __construct() {
        parent::__construct();
        //pre($this->session->userdata); die;
        $this->load->model(array('Setting_model','Class_model','fees/Fees_model','fees/Refund_model','fees/Ajax_model'));
        $this->load->helper('functions');
        
        $setting_records = $this->Setting_model->get_data_by_cols('*', array(), 'result_array');      
        $this->globalSettingsRunningYear = fetch_parl_key_rec($setting_records,'running_year');
        $this->globalSettingsLocation = fetch_parl_key_rec($setting_records,'location');
        $this->globalSettingsAppPackageName = fetch_parl_key_rec($setting_records,'app_package_name');
        $this->globalSettingsSystemTitle = fetch_parl_key_rec($setting_records,'system_title');
        $this->globalSettingsSystemName = fetch_parl_key_rec($setting_records,'system_name');
        $this->globalSettingsSystemEmail = fetch_parl_key_rec($setting_records,'system_email');
        $this->globalSettingsSystemFCMServerrKey = fetch_parl_key_rec($setting_records,'fcm_server_key');
        $this->globalSettingsSkinColour = fetch_parl_key_rec($setting_records,'skin_colour');
        $this->globalSettingsTextAlign = fetch_parl_key_rec($setting_records,'text_align');
        $this->globalSettingsActiveSmsService = fetch_parl_key_rec($setting_records,'active_sms_service');
        $this->globalSettingsActiveSms = $this->globalSettingsActiveSmsService;
       
        $this->session->set_userdata(array(
            'running_year' => $this->globalSettingsRunningYear,
        ));
        $this->running_year = $this->session->userdata('running_year');
        $this->school_id = $this->session->userdata('school_id');
        
        if ($this->session->userdata('school_admin_login') != 1 && $this->session->userdata('accountant_login') != 1 && $this->session->userdata('parent_login') != 1){
           echo json_encode(array('status'=>'error','msg'=>'Invalid!'));exit;
        }   
    }

    function index() {
    
    }

    function get_students(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $return = array('status'=>'error','msg'=>'Error try again!');

            $stu_status = $this->input->post('student_status');    
            $class_id = $this->input->post('class_id');
            if($stu_status==1){
                $whr = array();
                if($class_id!=0)
                    $whr['E.class_id'] = $class_id;

                $students = $this->Ajax_model->get_students($whr);
                $return['status'] = 'success';
                $return['html'] = '<option value="">'.get_phrase('select_student').'</option>';
                foreach($students as $stu){
                    $return['html'] .= '<option value="'.$stu->student_id.'">'.$stu->name.' '.$stu->lname.'</option>';
                }   
            }else{
                $students = $this->Ajax_model->get_non_enroll_students();
                $return['status'] = 'success';
                $return['html'] = '<option value="">'.get_phrase('select_student').'</option>';
                foreach($students as $stu){
                    $return['html'] .= '<option value="'.$stu->enquired_student_id.'">'.$stu->student_fname.' '.$stu->student_lname.'</option>';
                }  
            }
            
                      
            echo json_encode($return);exit;
        }
    }

    function get_student_fees(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $return = array('status'=>'error','msg'=>'Error try again!');

            $stu_status = $this->input->post('student_status');    
            $student_id = $this->input->post('student_id');
            if($stu_status==1){
                $whr = array();
                $this->_get_regular_student_fees($student_id);
            }else{
                $this->_get_non_enroll_fees($student_id);
            }
                                 
            echo json_encode($return);exit;
        }
    }
    
    private function _get_regular_student_fees($student_id){
        $return = array('status'=>'error','msg'=>'Error try again!');
        $student_rec = $this->Ajax_model->get_student(array('S.student_id'=>$student_id));
        $return['stu_detail_html'] = '<tr>
                                        <td>'.$student_rec->enroll_code.'</td>
                                        <td>'.$student_rec->name.' '.$student_rec->lname.'</td>
                                        <td>'.$student_rec->class_name.'-'.$student_rec->section_name.'</td>
                                        <td class="text-right">'.date('d/m/Y',$student_rec->date_added).'</td>
                                      </tr>';
        
        $terms = $this->Ajax_model->get_setudent_fee_config($student_id);
        $return['html'] = '<option value="">'.get_phrase('select_fee').'</option>';
        if($terms){
            $return['status'] = 'success';
            if($terms['school_fee_terms']){
                $return['html'] .= '<optgroup label="School Fees">';
                foreach($terms['school_fee_terms'] as $term){
                    $return['html'] .= '<option data-type="1" value="'.$term->id.'">'.$term->name.' -- '.$term->amount.'</option>';
                }
                $return['html'] .= '</optgroup>';  
            }

            if($terms['hostel_fee_terms']){
                $return['html'] .= '<optgroup label="Hostel Fees">';
                foreach($terms['hostel_fee_terms'] as $term){
                    $return['html'] .= '<option data-type="2" value="'.$term->id.'">'.$term->name.'</option>';
                }
                $return['html'] .= '</optgroup>';  
            }

            if($terms['transport_fee_terms']){
                $return['html'] .= '<optgroup label="Transport Fees">';
                foreach($terms['transport_fee_terms'] as $term){
                    $return['html'] .= '<option data-type="3" value="'.$term->id.'">'.$term->name.'</option>';
                }
                $return['html'] .= '</optgroup>';  
            }
        }else{
            $return['msg'] = 'Fees not assigned!';
        }  
        echo json_encode($return);exit;
    }

    private function _get_non_enroll_fees($student_id){
        $return = array('status'=>'error','msg'=>'Error try again!');
        $student_rec = $this->Ajax_model->get_non_enroll_student(array('enquired_student_id'=>$student_id));
        $return['stu_detail_html'] = '<tr>
                                        <td> Not Enrolled </td>
                                        <td>'.$student_rec->student_fname.' '.$student_rec->student_lname.'</td>
                                        <td> - </td>
                                        <td class="text-right"> - </td>
                                      </tr>';
       
        $heads = $this->Ajax_model->get_non_enroll_heads(); 
        $return['html'] = '<option value="">'.get_phrase('select_fee').'</option>';
        if($heads){
            $return['status'] = 'success';
            if($heads){
                $return['html'] .= '<optgroup label="Non Enroll">';
                foreach($heads as $hd){
                    $return['html'] .= '<option data-type="4" value="'.$hd->id.'">'.$hd->name.' -- '.$hd->amount.'</option>';
                }
                $return['html'] .= '</optgroup>';  
            }
        }else{
            $return['msg'] = 'Fees not assigned!';
        }  
        echo json_encode($return);exit;
    }
    
    function get_fee_detail($fee_id=false){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            //echo '<pre>';print_r($_POST);exit;
            $return = array('status'=>'error','msg'=>'Error try again!');

            $stu_status = $this->input->post('stu_status');   
            $student_id = $this->input->post('student_id'); 
            $fee_type = $this->input->post('fee_type'); 
            $fee_id = $this->input->post('fee_id');     
            if($fee_type!=4){//Check if non_enroll
                $stu_rec = $this->Ajax_model->get_student(array('S.student_id'=>$student_id));
                $this->_get_regular_fee_detail($stu_status,$student_id,$stu_rec->class_id,$fee_type,$fee_id);  
            }else{
                $this->_get_non_enroll_fee_detail($stu_status,$student_id,0,$fee_type,$fee_id);  
            }        
        }   
    }

    private function _get_regular_fee_detail($stu_status,$student_id,$class_id,$fee_type,$fee_id){
        $return = array('status'=>'error','msg'=>'Error try again!','payment_trans_html'=>'');
        $stu_rec = $this->Ajax_model->get_student(array('S.student_id'=>$student_id));
        $group_rec = $this->Ajax_model->get_fee_group(array('FRGC.class_id'=>$stu_rec->class_id));
        $stu_config = $this->Ajax_model->get_stu_config_rec(array('student_id'=>$student_id));

        $cur_date = date('Y-m-d');
        $total_fees = 0;
        $total_concess = 0;
        $total_fine = 0;
        $net_amount = 0;
        $total_paid = 0;
        $total_due_amt = 0;
        $due_date = false;
        $fine_rec = false;
        $concessions_records = array();
        $payment_trans_html = '';

        //Getting Concessions Record
        $group_concessions = $this->Ajax_model->get_rel_concession(array('FC.type'=>1,'FRCT.rel_id'=>$group_rec->id));
        $class_concessions = $this->Ajax_model->get_rel_concession(array('FC.type'=>2,'FRCT.rel_id'=>$stu_rec->class_id));
        $stu_concessions = $this->Ajax_model->get_rel_concession(array('FC.type'=>3,'FRCT.rel_id'=>$stu_rec->student_id));
        foreach($group_concessions as $crec){
            $crec->type = 'group';
            $concessions_records[] = $crec;
        }
        foreach($class_concessions as $crec){
            $crec->type = 'class';
            $concessions_records[] = $crec;
        }
        foreach($stu_concessions as $crec){
            $crec->type = 'student';
            $concessions_records[] = $crec;
        }
        //Concession Part

        //Have Paid
        $whr_cond = array('student_status'=>$stu_status,
                          'student_id'=>$student_id,
                          'class_id'=>$class_id,
                          'fee_type'=>$fee_type,
                          'fee_id'=>$fee_id);
        $hv_collrec = $this->Ajax_model->get_fee_collection_record($whr_cond);
        //echo '<pre>--';print_r($hv_collrec);exit;
        
        $return['paid'] = 0; 
        $return['net_due'] = 0;  
        $trans_paid = 0;
        $paid_items = array('heads'=>array(),'concess'=>array(),'fines'=>array(),'terms'=>array(),
                            'head_ids'=>array(),'concess_ids'=>array(),'fine_ids'=>array(),'term_ids'=>array());
        
        $return['payment_trans_html'] = '<tr><td colspan="6" class="text-center"><strong>No Payments Yet</strong></td></tr>';
        if($hv_collrec){
            $return['payment_trans_html'] = '';
            foreach($hv_collrec->item_trans as $itmtrn){
                if($itmtrn->item_type==1){
                    $paid_items['heads'][] = $itmtrn; 
                    $paid_items['head_ids'][] = $itmtrn->item_id;   
                }else if($itmtrn->item_type==2){
                    $paid_items['concess'][] = $itmtrn; 
                    $paid_items['concess_ids'][] = $itmtrn->item_id; 
                }else if($itmtrn->item_type==3){
                    $paid_items['fines'][] = $itmtrn; 
                    $paid_items['fine_ids'][] = $itmtrn->item_id; 
                }else if($itmtrn->item_type==4){
                    $paid_items['terms'][] = $itmtrn; 
                    $paid_items['term_ids'][] = $itmtrn->item_id; 
                }
            }

            foreach($hv_collrec->pay_trans as $ptran){
                $trans_paid += $ptran->paid_amount;
                $return['payment_trans_html'] .= '<tr>
                                                    <td>'.$ptran->receipt_no.'</td>  
                                                    <td>'.date('d/m/Y',strtotime($ptran->pay_date)).'</td> 
                                                    <td>'.$ptran->pay_method.'</td>
                                                    <td>'.$ptran->note.'</td>  
                                                    <td>'.$ptran->paid_amount.'</td> 
                                                    <td>
                                                        <a href="'.base_url('index.php?fees/prints/pay_receipt/'.$ptran->id).'" target="_blank"><i class="fa fa-print"></i></a>
                                                    </td> 
                                                  </tr>';
            }
            
            $total_paid += $trans_paid; 
            $total_due_amt += $hv_collrec->net_due;
            $return['paid'] = $hv_collrec->is_paid; 
            $return['net_due'] = $hv_collrec->net_due;  
        }
        $return['total_paid'] = $total_paid; 
           
        //echo '<pre>--';print_r($hv_collrec);print_r($paid_items);exit;

        $fee_detail_body = '';
        if($fee_type==1){ 
            $recorded_heads = array();
            $head_not_in = array();
            $school_term = $this->db->get_where('fee_setup_terms',array('id'=>$fee_id))->row();
            $fee_heads = $this->Ajax_model->get_stu_fee_detail($fee_id);
            
            $h_count = 0;
            foreach($fee_heads as $ik=>$hd){
                $recorded_heads[] = $hd->head_id;

                $total_fees += $hd->amount;
                $fee_detail_body .= '<tr data-num="'.$ik.'">
                                        <td class="slabel">'.($ik+1).'</td>
                                        <td>'.$hd->name.'</td>
                                        <td class="text-right amt-ele" data-amt="'.$hd->amount.'">
                                            '.$hd->amount.'
                                            <input type="hidden" name="heads['.$ik.'][id]" value="'.$hd->head_id.'"/>
                                            <input type="hidden" name="heads['.$ik.'][name]" value="'.$hd->name.'"/>
                                            <input type="hidden" name="heads['.$ik.'][amt]" value="'.$hd->amount.'"/>
                                        </td>
                                    </tr>';
                $h_count = $ik;                  
            }
            //echo $h_count;exit;

            //echo '<pre>';print_r($recorded_heads);print_r($paid_items['heads']);exit;
            foreach($paid_items['heads'] as $p_hd){
                if(!in_array($p_hd->item_id,$recorded_heads)){
                    $h_count += 1;
                    $total_fees += $p_hd->item_amt;
                    $fee_detail_body .= '<tr data-num="'.$h_count.'">
                                            <td class="slabel">'.$h_count.'</td>
                                            <td>'.$p_hd->item_name.' <strong>[Custom]</strong></td>
                                            <td class="text-right amt-ele" data-amt="'.$p_hd->item_amt.'">
                                                <span>'.$p_hd->item_amt.'</span>
                                                <input type="hidden" name="heads['.$h_count.'][id]" value="'.($p_hd->is_custom?'custom':'').'"/>
                                                <input type="hidden" name="heads['.$h_count.'][name]" value="'.$p_hd->item_name.'"/>
                                                <input type="hidden" name="heads['.$h_count.'][amt]" value="'.$p_hd->item_amt.'"/>
                                            </td>
                                        </tr>';
                }
            }

            //Fine
            if($school_term->fine_id){
                $fine_rec = $this->db->get_where('fee_fines',array('id'=>$school_term->fine_id))->row(); 
                $last_date = date('Y-m-d', strtotime($school_term->start_date. ' + '.$fine_rec->grace_period.' days'));
                //echo '<pre>'.$last_date;print_r($fine_rec);exit;
                if($cur_date > $last_date){
                    $total_fine += $fine_rec->value_type==1?$fine_rec->value:round(($total_fees*$fine_rec->value)/100,2);
                }  
            }
            $total_fees = sprintf('%0.2f',$total_fees);
        }else if($fee_type==2){
            $recorded_terms = array();
            $hostel_terms = $this->db->get_where('fee_hotel_setup_terms',array('id'=>$fee_id))->result();
            $room_rec = $this->db->get_where('hostel_room',array('hostel_room_id'=>$stu_config->room_id))->row();
            foreach($hostel_terms as $ik=>$rec){
                $recorded_terms[] = $rec->id;
                $hostel_fee_setup = $this->db->get_where('fee_hostel_charge_setups',array('id'=>$rec->setup_id))->row();
                $sterm_rec = $this->db->get_where('fee_terms',array('id'=>$hostel_fee_setup->fee_term_id))->row();
                $fee_amt = $rec->amt_type==1?$rec->amount:round(($room_rec->room_fare*$rec->amount)/100,2);
                $total_fees += $fee_amt;
                
                //Fine
                if($rec->fine_id){
                    $fine_rec = $this->db->get_where('fee_fines',array('id'=>$rec->fine_id))->row(); 
                    $last_date = date('Y-m-d', strtotime($rec->start_date. ' + '.$fine_rec->grace_period.' days'));
                    if($cur_date > $last_date){
                        $total_fine += $fine_rec->value_type==1?$fine_rec->value:round(($fee_amt*$fine_rec->value)/100,2);
                    }   
                }

                $fee_detail_body .='<tr data-num="0">
                                        <td>'.($ik+1).'</td>
                                        <td>'.$rec->name.'</td>
                                        <td class="text-right amt-ele" data-amt="'.$fee_amt.'">
                                            '.$fee_amt.'
                                            <input type="hidden" name="terms['.$ik.'][id]" value="'.$rec->id.'"/>
                                            <input type="hidden" name="terms['.$ik.'][name]" value="'.$rec->name.'"/>
                                            <input type="hidden" name="terms['.$ik.'][amt]" value="'.$fee_amt.'"/>
                                        </td>
                                    </tr>';
            }                    

        }else if($fee_type==3){
            $transport_terms = $this->db->get_where('fee_transport_setup_terms',array('id'=>$fee_id))->result();
            $stop_rec = $this->db->get_where('route_bus_stop',array('route_bus_stop_id'=>$stu_config->route_stop_id))->row();
            foreach($transport_terms as $ik=>$rec){
                $transport_fee_setup = $this->db->get_where('fee_transport_charge_setups',array('fee_term_id'=>$rec->setup_id))->row();
                $sterm_rec = $this->db->get_where('fee_terms',array('id'=>$transport_fee_setup->fee_term_id))->row();
                $fee_amt = $rec->amt_type==1?$rec->amount:round(($stop_rec->route_fare*$rec->amount)/100,2);
                //$fee_amt = $stop_rec->route_fare?round($stop_rec->route_fare/$sterm_rec->term_num,2):0;
                $total_fees += $fee_amt;

                //Fine
                if($rec->fine_id){
                    $fine_rec = $this->db->get_where('fee_fines',array('id'=>$rec->fine_id))->row(); 
                    $last_date = date('Y-m-d', strtotime($rec->start_date. ' + '.$fine_rec->grace_period.' days'));
                    if($cur_date > $last_date){
                        $total_fine += $fine_rec->value_type==1?$fine_rec->value:round(($fee_amt*$fine_rec->value)/100,2);
                    }   
                }

                $fee_detail_body .='<tr data-num="'.$ik.'">
                                        <td>'.($ik+1).'</td>
                                        <td>'.$rec->name.'</td>
                                        <td class="text-right amt-ele" data-amt="'.$fee_amt.'">
                                            '.$fee_amt.'
                                            <input type="hidden" name="terms['.$ik.'][id]" value="'.$rec->id.'"/>
                                            <input type="hidden" name="terms['.$ik.'][name]" value="'.$rec->name.'"/>
                                            <input type="hidden" name="terms['.$ik.'][amt]" value="'.$fee_amt.'"/>
                                        </td>
                                    </tr>';
            }
        }

        //Concession Part
        $concess_div_html = false;
        foreach($concessions_records as $ck=>$conrec){
            $con_amt = $conrec->amt_type==1?$conrec->amount:round(($total_fees*$conrec->amount)/100,2);
            $total_concess += $con_amt;
            $con_amt = sprintf('%0.2f',$con_amt);
            $concess_div_html .= '<tr data-num="'.$ck.'" data-type="'.$conrec->amt_type.'" data-val="'.$conrec->amount.'">
                                    <td>'.($ck+1).'</td>
                                    <td>'.$conrec->name.($conrec->amt_type==2?' ['.$conrec->amount.'%]':'').'</td>
                                    <td class="text-right amt-ele">
                                        <span>'.$con_amt.'</span>
                                        <input type="hidden" class="item-id" name="concessions['.$ck.'][id]" value="'.$conrec->id.'"/>
                                        <input type="hidden" class="item-name" name="concessions['.$ck.'][name]" value="'.$conrec->name.'"/>
                                        <input type="hidden" class="item-amt" name="concessions['.$ck.'][amt]" value="'.$con_amt.'"/>
                                    </td>
                                </tr>';
        }
        $total_concess = sprintf('%0.2f',$total_concess);
        //----Concession Part

        //Fine Part
        $fine_div_html = false;
        if($total_fine>0){
            $total_fine = sprintf('%0.2f',$total_fine);
            $fine_div_html = '<tr data-num="0" data-type="'.$fine_rec->value_type.'" data-val="'.$fine_rec->value.'">
                                <td>1</td>
                                <td>'.$fine_rec->name.($fine_rec->value_type==2?' ['.$fine_rec->value.'%]':'').' </td>
                                <td class="text-right amt-ele">
                                    <span>'.$total_fine.'</span>
                                    <input type="hidden" class="item-id" name="fines[0][id]" value="'.$fine_rec->id.'"/>
                                    <input type="hidden" class="item-name" name="fines[0][name]" value="'.$fine_rec->name.'"/>
                                    <input type="hidden" class="item-amt" name="fines[0][amt]" value="'.$total_fine.'"/>
                                </td>
                              </tr>';
        }
        //----Fine Part

        //Net Caluculation
        $net_amount = ($total_fees+$total_fine)-$total_concess;
        $net_amount = sprintf('%0.2f',$net_amount);
        $total_paid = sprintf('%0.2f',$total_paid);
        $total_due_amt = $net_amount-$total_paid;
        $total_due_amt = sprintf('%0.2f',$total_due_amt);

        //Only View No Calculation
        $return['status'] = 'succcess';    
        $return['html'] = '<table class="table no-padding" id="head-fees">
                            <thead>
                                <tr>
                                    <th style="width:100px">'.get_phrase('no.').'</th>
                                    <th>'.get_phrase('Head').'</th>
                                    <th class="text-right">'.get_phrase('Amount').'</th>
                                </tr>
                            </thead>

                            <tbody>'.$fee_detail_body.'</tbody>
                            </table>
                            <input type="hidden" id="head-total" name="fee_totals[head_total]" value="'.$total_fees.'"/>        

                            '.($hv_collrec && $hv_collrec->is_paid
                                ?''
                                :'<div class="row mt5">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-primary btn-xs pull-right add-cust-head"
                                        data-toggle="modal" data-target="#head-modal">Add Head</button>
                                    </div>
                                  </div>'
                                ).

                            '<table class="table no-padding '.(!$concess_div_html?'dis-none':'').'" id="fee-concessions">        
                                <thead>
                                    <tr>
                                        <th style="width:100px"></th>
                                        <th>'.get_phrase('Concession').'</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    '.$concess_div_html.'
                                </tbody>
                            </table>
                            <input type="hidden" id="concession-total" name="fee_totals[concesion_total]" value="'.$total_concess.'"/>   

                            <div class="row mt5 dis-none">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary btn-xs pull-right add-cust-dis"
                                    data-toggle="modal" data-target="#concess-modal">Add Concession</button>
                                </div>
                            </div>
                            
                            <table class="table no-padding '.(!$fine_div_html?'dis-none':'').'" id="fee-fines">        
                                <thead>
                                    <tr>
                                        <th style="width:100px"></th>
                                        <th>'.get_phrase('Fine').'</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    '.$fine_div_html.'
                                </tbody>
                            </table>  
                            <input type="hidden" id="fine-total" name="fee_totals[fine_total]" value="'.$total_fine.'"/>   

                            <div class="row mt5 dis-none">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary btn-xs pull-right add-cust-fine"
                                    data-toggle="modal" data-target="#fine-modal">Add Fine</button>
                                </div>
                            </div>

                            <table class="table no-padding" id="fee-summary">        
                                <thead>
                                    <tr>
                                        <th style="width:100px"></th>
                                        <th>'.get_phrase('summary').'</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Total Fees</td>
                                        <td class="text-right total-amt">'.$total_fees.'</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Total Concession</td>
                                        <td class="text-right total-concession">'.$total_concess.'</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Total Fine</td>
                                        <td class="text-right total-fine">'.$total_fine.'</td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <table class="table no-padding" id="fee-total">        
                                <thead>
                                    <tr>
                                        <th class="text-right">'.get_phrase('net_amount').'</th>
                                        <th class="text-right net-amt">'.$net_amount.'</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right">'.get_phrase('total_paid').'</th>
                                        <th class="text-right net-paid">'.$total_paid.'</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right">'.get_phrase('total_due_amount').'</th>
                                        <th class="text-right net-due">'.$total_due_amt.'</th>
                                    </tr>
                                </thead>
                            </table>';

        $return['pay_detail_html'] = $this->_pay_detail_html($stu_status,$student_id,$fee_id,$fee_type,$return['paid']);   
        echo json_encode($return);exit;  
    }
    
    private function _get_non_enroll_fee_detail($stu_status,$student_id,$class_id,$fee_type,$fee_id){
        $return = array('status'=>'error','msg'=>'Error try again!','payment_trans_html'=>'');
        $return['payment_trans_html'] = '<tr><td colspan="6" class="text-center"><strong>No Payments Yet</strong></td></tr>';
        
        $stu_rec = $this->Ajax_model->get_non_enroll_student(array('enquired_student_id'=>$student_id));
        $cur_date = date('Y-m-d');
        $total_fees = 0;
        $total_concess = 0;
        $total_fine = 0;
        $net_amount = 0;
        $total_paid = 0;
        $total_due_amt = 0;
        $due_date = false;
        $fine_rec = false;
        $concessions_records = array();

        //Have Paid
        $whr_cond = array('student_status'=>$stu_status,
                            'student_id'=>$student_id,
                            'class_id'=>$class_id,
                            'fee_type'=>$fee_type,
                            'fee_id'=>$fee_id);
        $hv_collrec = $this->Ajax_model->get_fee_collection_record($whr_cond);
        //echo '<pre>--';print_r($hv_collrec);exit;    


        $return['paid'] = 0; 
        $return['net_due'] = 0;  
        $trans_paid = 0;
        $paid_items = array('heads'=>array(),'head_ids'=>array());
        
        $return['payment_trans_html'] = '<tr><td colspan="6" class="text-center"><strong>No Payments Yet</strong></td></tr>';
        if($hv_collrec){
            $return['payment_trans_html'] = '';
            foreach($hv_collrec->item_trans as $itmtrn){
                if($itmtrn->item_type==1){
                    $paid_items['heads'][] = $itmtrn; 
                    $paid_items['head_ids'][] = $itmtrn->item_id;   
                }
            }

            foreach($hv_collrec->pay_trans as $ptran){
                $trans_paid += $ptran->paid_amount;
                $return['payment_trans_html'] .= '<tr>
                                                    <td>'.$ptran->receipt_no.'</td>  
                                                    <td>'.date('d/m/Y',strtotime($ptran->pay_date)).'</td> 
                                                    <td>'.$ptran->pay_method.'</td>
                                                    <td>'.$ptran->note.'</td>  
                                                    <td>'.$ptran->paid_amount.'</td> 
                                                    <td>
                                                        <a href="'.base_url('index.php?fees/prints/pay_receipt/'.$ptran->id).'" target="_blank"><i class="fa fa-print"></i></a>
                                                    </td> 
                                                  </tr>';
            }
            
            $total_paid += $trans_paid; 
            $total_due_amt += $hv_collrec->net_due;
            $return['paid'] = $hv_collrec->is_paid; 
            $return['net_due'] = $hv_collrec->net_due;  
        }
        $return['total_paid'] = $total_paid; 

        $recorded_heads[] = array();
        $fee_detail_body = '';
        $fee_heads = $this->Ajax_model->get_non_enroll_heads(array('id'=>$fee_id)); 
        foreach($fee_heads as $ik=>$hd){
            $recorded_heads[] = $hd->id;
            $total_fees += $hd->amount;
            $fee_detail_body .= '<tr data-num="'.$ik.'">
                                    <td class="slabel">'.($ik+1).'</td>
                                    <td>'.$hd->name.'</td>
                                    <td class="text-right amt-ele" data-amt="'.$hd->amount.'">
                                    '.$hd->amount.'
                                    <input type="hidden" name="heads['.$ik.'][id]" value="'.$hd->id.'"/>
                                    <input type="hidden" name="heads['.$ik.'][name]" value="'.$hd->name.'"/>
                                    <input type="hidden" name="heads['.$ik.'][amt]" value="'.$hd->amount.'"/>
                                    </td>
                                </tr>';
        }

        //echo '<pre>';print_r($recorded_heads);print_r($paid_items['heads']);exit;
        foreach($paid_items['heads'] as $p_hd){
            if(!in_array($p_hd->item_id,$recorded_heads)){
                $h_count += 1;
                $total_fees += $p_hd->item_amt;
                $fee_detail_body .= '<tr data-num="'.$h_count.'">
                                        <td class="slabel">'.$h_count.'</td>
                                        <td>'.$p_hd->item_name.' <strong>[Custom]</strong></td>
                                        <td class="text-right amt-ele" data-amt="'.$p_hd->item_amt.'">
                                            <span>'.$p_hd->item_amt.'</span>
                                            <input type="hidden" name="heads['.$h_count.'][id]" value="'.($p_hd->is_custom?'custom':'').'"/>
                                            <input type="hidden" name="heads['.$h_count.'][name]" value="'.$p_hd->item_name.'"/>
                                            <input type="hidden" name="heads['.$h_count.'][amt]" value="'.$p_hd->item_amt.'"/>
                                        </td>
                                    </tr>';
            }
        }

        //Concession Part
        $concess_div_html = false;
        //----Concession Part

        //Fine Part
        $fine_div_html = false;
        //----Fine Part

        //Net Caluculation
        $net_amount = ($total_fees+$total_fine)-$total_concess;
        $net_amount = sprintf('%0.2f',$net_amount);
        $total_paid = sprintf('%0.2f',$total_paid);
        $total_due_amt = $net_amount-$total_paid;
        $total_due_amt = sprintf('%0.2f',$total_due_amt);

        //Only View No Calculation
        $return['status'] = 'succcess';    
        $return['html'] = '<table class="table no-padding" id="head-fees">
                            <thead>
                                <tr>
                                    <th style="width:100px">'.get_phrase('no.').'</th>
                                    <th>'.get_phrase('Head').'</th>
                                    <th class="text-right">'.get_phrase('Amount').'</th>
                                </tr>
                            </thead>

                            <tbody>'.$fee_detail_body.'</tbody>
                            </table>
                            <input type="hidden" id="head-total" name="fee_totals[head_total]" value="'.$total_fees.'"/>        

                            <div class="row mt5">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary btn-xs pull-right add-cust-head"
                                    data-toggle="modal" data-target="#head-modal">Add Head</button>
                                </div>
                            </div>

                            <table class="table no-padding '.(!$concess_div_html?'dis-none':'').'" id="fee-concessions">        
                                <thead>
                                    <tr>
                                        <th style="width:100px"></th>
                                        <th>'.get_phrase('Concession').'</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    '.$concess_div_html.'
                                </tbody>
                            </table>
                            <input type="hidden" id="concession-total" name="fee_totals[concesion_total]" value="'.$total_concess.'"/>   

                            <div class="row mt5 dis-none">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary btn-xs pull-right add-cust-dis"
                                    data-toggle="modal" data-target="#concess-modal">Add Concession</button>
                                </div>
                            </div>
                            
                            <table class="table no-padding '.(!$fine_div_html?'dis-none':'').'" id="fee-fines">        
                                <thead>
                                    <tr>
                                        <th style="width:100px"></th>
                                        <th>'.get_phrase('Fine').'</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    '.$fine_div_html.'
                                </tbody>
                            </table>  
                            <input type="hidden" id="fine-total" name="fee_totals[fine_total]" value="'.$total_fine.'"/>   

                            <div class="row mt5 dis-none">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary btn-xs pull-right add-cust-fine"
                                    data-toggle="modal" data-target="#fine-modal">Add Fine</button>
                                </div>
                            </div>

                            <table class="table no-padding" id="fee-summary">        
                                <thead>
                                    <tr>
                                        <th style="width:100px"></th>
                                        <th>'.get_phrase('summary').'</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Total Fees</td>
                                        <td class="text-right total-amt">'.$total_fees.'</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Total Concession</td>
                                        <td class="text-right total-concession">'.$total_concess.'</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Total Fine</td>
                                        <td class="text-right total-fine">'.$total_fine.'</td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <table class="table no-padding" id="fee-total">        
                                <thead>
                                    <tr>
                                        <th class="text-right">'.get_phrase('net_amount').'</th>
                                        <th class="text-right net-amt">'.$net_amount.'</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right">'.get_phrase('total_paid').'</th>
                                        <th class="text-right net-paid">'.$total_paid.'</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right">'.get_phrase('total_due_amount').'</th>
                                        <th class="text-right net-due">'.$total_due_amt.'</th>
                                    </tr>
                                </thead>
                            </table>';
                            
        $return['pay_detail_html'] = $this->_pay_detail_html($stu_status,$student_id,$fee_id,$fee_type,$return['paid']);           
        echo json_encode($return);exit;  
    }

    private function _pay_detail_html($stusts=false,$stuid=false,$fee_id=false,$fee_type=false,$pay_status=false){
        if($pay_status){
            if($stusts==2){
                return '';
            }
            $html = '<div class="row"> 
                        <div class="col-md-2 pull-right">
                            <a class="fcbtn btn btn-danger btn-outline btn-1d pull-right" target="_blank"
                                href="'.base_url('index.php?fees/main/generate_invoice/'._getYear().'/'.$stusts.'/'.$stuid.'/'.$fee_id.'/'.$fee_type).'">
                                '.get_phrase('generate_invoice').'
                            </a>
                        </div>        
                    </div>';
        }else{
            $html = '<div class="row">
                        <div class="col-md-3">
                            <select name="pay_mode" class="selectpicker" data-style="form-control input-sm" data-title="Select Payment Mode">
                                <option value="">Select</option>
                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                                <option value="online">Online</option>
                                <option value="cheque">Cheque</option>
                            </select>
                        </div>   
                        <div class="col-md-3">
                            <input type="number" class="form-control input-sm" name="ref_no" placeholder="'.get_phrase('reference_no').'"/>
                        </div>   
                        <div class="col-md-3 col-md-offset-3">
                            <input type="number" class="form-control input-sm" name="pay_amount" placeholder="'.get_phrase('pay_amount').'"/>
                        </div>             
                    </div>  
                    <br/>
                    
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" class="form-control input-sm dtp" name="pay_date" placeholder="'.get_phrase('pay_date').'"/> 
                        </div>   
                        <div class="col-md-4">
                            <textarea class="form-control" name="note" rows="2" placeholder="'.get_phrase('Notes').'"></textarea>
                        </div>  
                        <div class="col-md-2 pull-right">
                            <a class="fcbtn btn btn-danger btn-outline btn-1d pull-right paynow">'.get_phrase('pay_amount').'</a>
                        </div>'. 
                        ($stusts==1?'<div class="col-md-2 pull-right">
                            <a class="fcbtn btn btn-danger btn-outline btn-1d pull-right" target="_blank"
                                href="'.base_url('index.php?fees/main/generate_invoice/'._getYear().'/'.$stusts.'/'.$stuid.'/'.$fee_type.'/'.$fee_id).'">
                                '.get_phrase('generate_invoice').'
                            </a>
                        </div>':'')       
                    .'</div>';
        } 
        return $html;       
    }

    //Pay Capture
    function pay_capture(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            //echo '<pre>';print_r($_POST);exit;
            $return = array('status'=>'error','msg'=>'Error try again!');
            
            //Collection Record
            $whr_cond = array('student_status'=>$this->input->post('student_status'),
                              'student_id'=>$this->input->post('student_id'),
                              'class_id'=>($this->input->post('student_status')==1?$this->input->post('class_id'):0),
                              'fee_type'=>$this->input->post('fee_type'),
                              'fee_id'=>$this->input->post('fee'));
            $hv_collrec = $this->Ajax_model->get_fee_collection_record($whr_cond);
            
            $trans_paid = 0;
            if($hv_collrec){
                /* foreach($hv_collrec->item_trans as $itmtrn){
                    if($itmtrn->item_type==1){
                        $paid_items['heads'][] = $itmtrn; 
                        $paid_items['head_ids'][] = $itmtrn->item_id;   
                    }else if($itmtrn->item_type==2){
                        $paid_items['concess'][] = $itmtrn; 
                        $paid_items['concess_ids'][] = $itmtrn->item_id; 
                    }else if($itmtrn->item_type==3){
                        $paid_items['fines'][] = $itmtrn; 
                        $paid_items['fine_ids'][] = $itmtrn->item_id; 
                    }else if($itmtrn->item_type==4){
                        $paid_items['terms'][] = $itmtrn; 
                        $paid_items['term_ids'][] = $itmtrn->item_id; 
                    }
                } */
    
                foreach($hv_collrec->pay_trans as $ptran){
                    $trans_paid += $ptran->paid_amount;
                }
            }    

            $fee_total = $this->input->post('fee_totals');
            $school_fee_total = isset($fee_total['head_total'])?$fee_total['head_total']:0;
            $concesion_total = isset($fee_total['concesion_total'])?$fee_total['concesion_total']:0;
            $fine_total = isset($fee_total['fine_total'])?$fee_total['fine_total']:0;
            $net_amount = ($school_fee_total+$fine_total)-$concesion_total;
            $pay_amount = $this->input->post('pay_amount');
            $save_array = array('student_status'=>$this->input->post('student_status'),
                                'student_id'=>$this->input->post('student_id'),
                                'class_id'=>$this->input->post('class_id'),
                                'fee_type'=>$this->input->post('fee_type'),
                                'fee_id'=>$this->input->post('fee'),
                                'school_fee_total'=> $school_fee_total,
                                'concession_total'=>$concesion_total,
                                'fine_total'=>$fine_total,
                                'net_amount'=>$net_amount);
            if(!$hv_collrec){
                $save_array['net_due'] = ($net_amount-$pay_amount);
                $save_array['is_paid'] = $save_array['net_due']==0?1:0;
                $save_array['running_year'] = $this->running_year;
                $save_array['school_id'] = $this->school_id; 
                $save_array['created'] = date('Y-m-d H:i:S');
                $save_array['updated'] = date('Y-m-d H:i:S');
                $collrec_id = $this->Ajax_model->save_fee_collection_record($save_array);                
            }else{
                $save_array['net_due'] = ($net_amount-($pay_amount+$trans_paid));
                //echo $net_amount.'-'.$save_array['net_due'].'<pre>';print_r($save_array);exit;
                $save_array['is_paid'] = $save_array['net_due']==0?1:0;
                $save_array['id'] = $hv_collrec->id;
                $save_array['updated'] = date('Y-m-d H:i:S');
                $flag = $this->Ajax_model->save_fee_collection_record($save_array);  
                $collrec_id = $hv_collrec->id;
            }
            $return['paid'] = $save_array['is_paid']; 
            $return['total_paid'] = $pay_amount+$trans_paid; 
            $return['net_due'] = $save_array['net_due']; 
            
            $nxt_recp_no = $this->Ajax_model->get_next_pay_trans_receipt_no();
            $previous_pay = $this->db->order_by('id','DESC')->get_where('fee_pay_transactions',array('pay_collection_record_id'=>$collrec_id))->row();
            $save_pay_trans = array('pay_collection_record_id'=>$collrec_id,
                                    'receipt_no'=>$nxt_recp_no,
                                    'pay_method'=>$this->input->post('pay_mode'),
                                    'ref_no'=>$this->input->post('ref_no'),
                                    'paid_amount'=>$this->input->post('pay_amount'),
                                    'pay_date'=>$this->input->post('pay_date'),
                                    'previous_amount'=>($previous_pay?$previous_pay->paid_amount:0),
                                    'due_amount'=>$return['net_due'],
                                    'note'=> $this->input->post('note'),
                                    'user_type'=>$this->session->userdata('u_type'),
                                    'user_id'=>$this->session->userdata('login_user_id'),
                                    'running_year'=>$this->running_year,
                                    'school_id'=>$this->school_id,
                                    'created'=>date('Y-m-d H:i:s'));
            $pay_trans_id = $this->Ajax_model->save_pay_trans($save_pay_trans);     
            
            $head_trans = $this->input->post('heads')?$this->input->post('heads'):array();
            $concess_trans = $this->input->post('concessions')?$this->input->post('concessions'):array();
            $fine_trans = $this->input->post('fines')?$this->input->post('fines'):array();
            $term_trans = $this->input->post('terms')?$this->input->post('terms'):array();

            $this->db->delete('fee_pay_item_transactions',array('pay_collection_record_id'=>$collrec_id));  
            foreach($head_trans as $trns){
                $save_pay_item_trans = array('pay_collection_record_id'=>$collrec_id,
                                             'pay_trans_id'=>$pay_trans_id,
                                             'item_type'=>1,
                                             'is_custom'=>($trns['id']=='custom'?1:0),
                                             'item_id'=>($trns['id']!='custom'?$trns['id']:0),
                                             'item_name'=>$trns['name'],
                                             'item_amt'=>$trns['amt'],
                                             'added'=>date('Y-m-d H:i:s'));
                $this->Ajax_model->save_pay_item_trans($save_pay_item_trans);   
                $this->Ajax_model->save_payment_item_trans($save_pay_item_trans);
            }  
            foreach($concess_trans as $trns){
                $save_pay_item_trans = array('pay_collection_record_id'=>$collrec_id,
                                             'pay_trans_id'=>$pay_trans_id,
                                             'item_type'=>2,
                                             'is_custom'=>($trns['id']=='custom'?1:0),
                                             'item_id'=>($trns['id']!='custom'?$trns['id']:0),
                                             'item_name'=>$trns['name'],
                                             'item_amt'=>$trns['amt'],
                                             'added'=>date('Y-m-d H:i:s'));
                $this->Ajax_model->save_pay_item_trans($save_pay_item_trans); 
                $this->Ajax_model->save_payment_item_trans($save_pay_item_trans);  
            }
            foreach($fine_trans as $trns){
                $save_pay_item_trans = array('pay_collection_record_id'=>$collrec_id,
                                             'pay_trans_id'=>$pay_trans_id,
                                             'item_type'=>3,
                                             'is_custom'=>($trns['id']=='custom'?1:0),
                                             'item_id'=>($trns['id']!='custom'?$trns['id']:0),
                                             'item_name'=>$trns['name'],
                                             'item_amt'=>$trns['amt'],
                                             'added'=>date('Y-m-d H:i:s'));
                $this->Ajax_model->save_pay_item_trans($save_pay_item_trans);   
                $this->Ajax_model->save_payment_item_trans($save_pay_item_trans);
            }
            foreach($term_trans as $trns){
                $save_pay_item_trans = array('pay_collection_record_id'=>$collrec_id,
                                             'pay_trans_id'=>$pay_trans_id,
                                             'item_type'=>4,
                                             'is_custom'=>($trns['id']=='custom'?1:0),
                                             'item_id'=>($trns['id']!='custom'?$trns['id']:0),
                                             'item_name'=>$trns['name'],
                                             'item_amt'=>$trns['amt'],
                                             'added'=>date('Y-m-d H:i:s'));
                $this->Ajax_model->save_pay_item_trans($save_pay_item_trans); 
                $this->Ajax_model->save_payment_item_trans($save_pay_item_trans);  
            }

            //Get Payment Transactions
            $hv_collrec = $this->Ajax_model->get_fee_collection_record($whr_cond);
            $return['payment_trans_html'] = '';
            if($hv_collrec){
                foreach($hv_collrec->pay_trans as $ptran){
                    $return['payment_trans_html'] .= '<tr>
                                                        <td>'.$ptran->receipt_no.'</td>  
                                                        <td>'.date('d/m/Y',strtotime($ptran->pay_date)).'</td> 
                                                        <td>'.$ptran->pay_method.'</td>
                                                        <td>'.$ptran->note.'</td>
                                                        <td>'.$ptran->paid_amount.'</td> 
                                                        <td>
                                                            <a href="'.base_url('index.php?fees/prints/pay_receipt/'.$ptran->id).'" target="_blank"><i class="fa fa-print"></i></a>
                                                        </td> 
                                                    </tr>';
                }
            }

            $return['status'] = 'success';
            $return['msg'] = 'Fee Collected Successfully';
            echo json_encode($return);exit;
        }    
    }

    //Fees Dues Report
    function get_fees_by_class(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $return = array('status'=>'error','msg'=>'Error try again!');

            $class_id = $this->input->post('class_id');    
            $terms = $this->Ajax_model->get_terms_by_class($class_id);
            //echo '<pre>';print_r($terms);exit;
           
            $return['html'] = '<option value="">'.get_phrase('select_fee').'</option>';
            if($terms){
                $return['status'] = 'success';
                $return['html'] .= '<optgroup label="School Fees">';
                foreach($terms as $term){
                    $return['html'] .= '<option data-type="1" value="'.$term->id.'">'.$term->name.' -- '.$term->amount.'</option>';
                }
                $return['html'] .= '</optgroup>';  
                
    
                $return['html'] .= '<optgroup label="Other Fees">
                                        <option data-type="2" value="hostel">Hostel Fees</option>
                                        <option data-type="3" value="hostel">Transport Fees</option>
                                    </optgroup>'; 
            }else{
                $return['msg'] = 'Fees not assigned!';
            }  
            echo json_encode($return);exit;
        }
    }

    function get_due_fee_students(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $return = array('status'=>'error','msg'=>'Error try again!','html'=>'');

            $class_id = $this->input->post('class_id');    
            $fee_type = $this->input->post('fee_type');   
            $fee_id = $this->input->post('fee');   
            $students = $this->Ajax_model->get_due_fee_students($fee_type,$class_id,$fee_id);
            //echo '<pre>';print_r($students);exit;
            
            $return['html'] = '';
            if($students){
                $return['status'] = 'success';
                foreach($students as $i=>$stu){
                    $return['html'] .= '<tr>
                                            <td>'.($i+1).'</td>  
                                            <td>'.$stu->enroll_code.'</td> 
                                            <td>'.$stu->admission_no.'</td> 
                                            <td>'.$stu->name.' '.$stu->lname.'</td>
                                        </tr>';
                }
            }else{
                $return['msg'] = 'No students found!';
            }  
            echo json_encode($return);exit;
        }
    }

    function get_class_wise_due_report(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $return = array('status'=>'error','msg'=>'Error try again!');
            $class_id = $this->input->post('class_id');  
            $students = $this->Ajax_model->get_students(array('E.class_id'=>$class_id),array('has_config !='=>0));
            //echo '<pre>';print_r($has_config_students);exit;
            $html  = '';
            foreach($students as $i=>$stu){
                $terms = $this->Ajax_model->get_setudent_fee_config($stu->student_id);
                $fee_detail_html = '<table class="table table-bordered" width="100%" style="margin:0">';
                $total_amt = 0;
                $total_paid = 0;
                foreach($terms['school_fee_terms'] as $term){
                    $hd_html = '';
                    foreach($term->heads as $hd){
                        $hd_html .= '<div>'.$hd->name.' '.$hd->amount.'</div><br/>';        
                    }
                    $total_amt += $term->amount;

                    $whr_cond = array('student_status'=>1,
                                      'student_id'=>$stu->student_id,
                                      'class_id'=>$stu->class_id,
                                      'fee_type'=>1,
                                      'fee_id'=>$term->id);
                    $hv_collrec = $this->Ajax_model->get_fee_collection_record($whr_cond);
                    $paid_amt = $hv_collrec?($hv_collrec->net_amount-$hv_collrec->net_due):0;
                    $total_paid += $paid_amt;

                    $fee_detail_html .= '<tr>
                                            <td style="width:33.33%">'.$term->name.'</td>
                                            <td style="width:33.33%">'.$hd_html.'</td>
                                            <td style="width:17%">'.$term->amount.'</td>
                                            <td style="width:17%">'.$paid_amt.'</td>
                                         </tr>'; 
                }
                $fee_detail_html .= '</table>';

                //echo '<pre>';print_r($terms);exit;
                $html .= '<tr>
                            <td>'.($i+1).'</td>
                            <td>'.$stu->name.' '.$stu->lname.'</td>
                            <td>'.$stu->class_name.'</td>
                            <td colspan="4" style="padding:0">'.$fee_detail_html.'</td>
                         </tr>
                         <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><strong>Total</strong></td>
                            <td><strong>'.$total_amt.'</strong></td>
                            <td><strong>'.$total_paid.'</strong></td>
                        </tr>';

            }
            if(!$students){
               $html =' <tr>
                            <td colspan="7" class="text-center"><strong>No Records Found</strong></td>
                        </tr>';
            }
            $return['html'] = $html;

            echo json_encode($return);exit;
        }    
    }

    function get_fee_setup_terms_by_group(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $return = array('status'=>'error','msg'=>'Error try again!');
            $fee_group_id = $this->input->post('fee_group_id');  
            $term_type_id = $this->input->post('term_type_id');  
            $fee_terms = $this->Ajax_model->get_setup_terms(array('fee_group_id'=>$fee_group_id,'fee_term_id'=>$term_type_id));
            
            if(!$fee_terms){
                $return['msg'] = 'Setup not created for this group';
            }else{
                $return['status'] = 'success';
            }

            $return['html'] = '';
            foreach($fee_terms as $term){
                $return['html'] .= '<option value="'.$term->id.'">'.$term->name.' - '.$term->amount.' - '.date('d/m/Y',strtotime($term->start_date)).'</option>';
            }
            echo json_encode($return);exit;
        }
    } 

    function get_class_wise_terms(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $return = array('status'=>'error','msg'=>'Error try again!');
            $class_id = $this->input->post('class_id'); 
            $terms = $this->Ajax_model->get_terms_by_class($class_id); 
            //echo '<pre>';print_r($terms);exit;  
            $return['html'] = '';          
            foreach($terms as $term){
                $return['html'] .= '<option value="'.$term->id.'">'.$term->name.' - '.date('d/m/Y',strtotime($term->start_date)).'</option>';
            }

            echo json_encode($return);exit;
        }    
    }

    function get_term_wise_dues(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $return = array('status'=>'error','msg'=>'Error try again!');
            $class_id = $this->input->post('class_id');  
            $term_id = $this->input->post('term_id');  
            $students = $this->Ajax_model->get_students(array('E.class_id'=>$class_id),array('has_config !='=>0));
            //echo '<pre>';print_r($has_config_students);exit;
            $html  = '';
            foreach($students as $i=>$stu){
                $terms = $this->Ajax_model->get_setudent_fee_config($stu->student_id);
                $fee_detail_html = '<table class="table table-bordered" width="100%" style="margin:0">';
                $total_amt = 0;
                $total_paid = 0;
                foreach($terms['school_fee_terms'] as $term){
                    if($term_id==$term->id){
                        $hd_html = '';
                        foreach($term->heads as $hd){
                            $hd_html .= '<div>'.$hd->name.' '.$hd->amount.'</div><br/>';        
                        }
                        $total_amt += $term->amount;

                        $whr_cond = array('student_status'=>1,
                                          'student_id'=>$stu->student_id,
                                          'class_id'=>$stu->class_id,
                                          'fee_type'=>1,
                                          'fee_id'=>$term->id);
                        $hv_collrec = $this->Ajax_model->get_fee_collection_record($whr_cond);
                        $paid_amt = $hv_collrec?($hv_collrec->net_amount-$hv_collrec->net_due):0;
                        $total_paid += $paid_amt;

                        $fee_detail_html .= '<tr>
                                                <td style="width:40%">'.$hd_html.'</td>
                                                <td style="width:30%">'.$term->amount.'</td>
                                                <td style="width:30%">'.$paid_amt.'</td>
                                            </tr>'; 
                    }                     
                }
                $fee_detail_html .= '</table>';

                //echo '<pre>';print_r($terms);exit;
                $html .= '<tr>
                            <td>'.($i+1).'</td>
                            <td>'.$stu->name.' '.$stu->lname.'</td>
                            <td>'.$stu->class_name.'</td>
                            <td colspan="3" style="padding:0">'.$fee_detail_html.'</td>
                         </tr>';

            }
            if(!$students){
               $html =' <tr>
                            <td colspan="6" class="text-center"><strong>No Records Found</strong></td>
                        </tr>';
            }
            $return['html'] = $html;

            echo json_encode($return);exit;
        }    
    }

    function get_student_wise_dues(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $return = array('status'=>'error','msg'=>'Error try again!');
            $student_id = $this->input->post('student_id');  
            $stu = $this->Ajax_model->get_student(array('S.student_id'=>$student_id));
            //echo '<pre>';print_r($has_config_students);exit;
            $return['stu_detail_html'] = '<tr>
                                            <td>'.$stu->enroll_code.'</td>
                                            <td>'.$stu->name.' '.$stu->lname.'</td>
                                            <td>'.$stu->class_name.'-'.$stu->section_name.'</td>
                                            <td class="text-right">'.date('d/m/Y',$stu->date_added).'</td>
                                        </tr>';

            $total_amt = 0;
            $total_paid = 0;

            $terms = $this->Ajax_model->get_setudent_fee_config($stu->student_id);
            $html = '<tr>
                        <td colspan="4" class="text-left"><strong>School Fees</strong></td>
                     </tr>';
          
            foreach($terms['school_fee_terms'] as $term){
                    $whr_cond = array('student_status'=>1,
                                      'student_id'=>$stu->student_id,
                                      'class_id'=>$stu->class_id,
                                      'fee_type'=>1,
                                      'fee_id'=>$term->id);
                    $coll = $this->Ajax_model->get_fee_collection_record($whr_cond);

                    $html .= '<tr>
                                <td>'.$term->name.'</td>
                                <td>'.($coll && $coll->is_paid?'<label class="label label-success">Paid</label>':'<label class="label label-danger">Pending</label>').'</td>
                                <td>'.$term->amount.'</td>0
                                <td>'.date('d/m/Y',strtotime($term->start_date)).'</td>
                             </tr>'; 
            }
            if(!$terms['school_fee_terms']){
                $html .= '<tr>
                            <td colspan="4" class="text-center"><strong>No Fees Assigned</strong></td>
                          </tr>';
            }

            $html .= ' <tr>
                        <td colspan="4" class="text-left"><strong>Hostel Fees</strong></td>
                       </tr>';
            foreach($terms['hostel_fee_terms'] as $term){
                    $whr_cond = array('student_status'=>1,
                                    'student_id'=>$stu->student_id,
                                    'class_id'=>$stu->class_id,
                                    'fee_type'=>2,
                                    'fee_id'=>$term->id);
                    $coll = $this->Ajax_model->get_fee_collection_record($whr_cond);
                    $html .= '<tr>
                                <td>'.$term->name.'</td>
                                <td>'.($coll && $coll->is_paid?'<label class="label label-success">Paid</label>':'<label class="label label-danger">Pending</label>').'</td>
                                <td>'.($terms['hostel_room']?round($terms['hostel_room']->room_fare/count($terms['hostel_fee_terms'])):'Room Fare blank').'</td>
                                <td>'.date('d/m/Y',strtotime($term->start_date)).'</td>
                              </tr>'; 
            }
            if(!$terms['hostel_fee_terms']){
                $html .= '<tr>
                            <td colspan="4" class="text-center"><strong>No Fees Assigned</strong></td>
                          </tr>';
            }

            $html .= '<tr>
                        <td colspan="4" class="text-left"><strong>Transport Fees</strong></td>
                      </tr>';
            foreach($terms['transport_fee_terms'] as $term){
                    $whr_cond = array('student_status'=>1,
                                    'student_id'=>$stu->student_id,
                                    'class_id'=>$stu->class_id,
                                    'fee_type'=>3,
                                    'fee_id'=>$term->id);
                    $coll = $this->Ajax_model->get_fee_collection_record($whr_cond);
                    $html .= '<tr>
                                <td>'.$term->name.'</td>
                                <td>'.($coll && $coll->is_paid?'<label class="label label-success">Paid</label>':'<label class="label label-danger">Pending</label>').'</td>
                                <td>'.($terms['route_stop']?round($terms['route_stop']->route_fare/count($terms['transport_fee_terms'])):'Route Stop Fare blank').'</td>
                                <td>'.date('d/m/Y',strtotime($term->start_date)).'</td>
                             </tr>'; 
            }
            if(!$terms['transport_fee_terms']){
                $html .= '<tr>
                            <td colspan="4" class="text-center"><strong>No Fees Assigned</strong></td>
                          </tr>';
            }
            
            $return['html'] = $html;

            echo json_encode($return);exit;
        }    
    }
}

// --------------------------------------------------------------------------
/* End of file Admin.php */
/* Location: ./application/controllers/fees/Ajax.php */


    
