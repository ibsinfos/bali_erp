<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    /**
     * Common library function goes here
     */
    class Fi_functions
    {
        private $_CI;    // CodeIgniter instance
        private $school_id;    
        public function __construct()
        {
            $this->_CI = & get_instance();
            if(isset($this->_CI->session->userdata['school_id']))
                $this->school_id = $this->_CI->session->userdata['school_id'];
            else{
                $this->school_id = 0;
            }    
        }

        function get_charges()
        {
            $db=$this->connect_db();
            $charges=$db->get_where('sys_items',array('type'=>'service','school_id'=>$this->school_id))->result_array();
            return $charges;
        }
        function save_invoice($student_id='')
        {
            $this->_CI->load->model('Student_model');
            $total=0;
           
            $student=get_data_generic_fun('student',"*",array('student_id'=>$student_id))[0];
            if($student->transport_id!=0)
            {
            $transport=  get_data_generic_fun('fees_fi','*',array('route_id'=>$student->transport_id));
            if($transport){
            $transport=$transport[0];
            $total=$total +$transport->amount;
           
            }
            
            }
            if($student->dormitory_room_number!='')
            {
            $dormitory=get_data_generic_fun('fees_fi','*',array('room_id'=>$student->dormitory_room_number));
            if($dormitory){
             $dormitory=       $dormitory[0];
            $total= $total+ $dormitory->amount;
            }
            }
            
            
            $db=$this->connect_db();
            $data['userid']=$student_id;
            $data['account']=$student->name;
            $data['date']=date('Y-m-d');
            $data['duedate']=date('Y-m-d');
            $data['datepaid']=date('Y-m-d H:i:s');
            $data['subtotal']=$total;
            $data['credit']=$total;
            $data['total']=$total;
            $data['status']='Paid';
            $data['vtoken']=    substr(rand(0, 1000000), 0, 9);
            $data['ptoken']=    substr(rand(0, 1000000), 0, 9);
            $data['r']=0;
            $data['nd']=date('Y-m-d');
            $data['notes']=" ";
            $data['school_id'] = $this->school_id;
            $db->insert('sys_invoices',$data);
            //echo($db->last_query());
            $invoice_id=$db->insert_id();
            if(!empty($transport)){
            $this->add_items_in_invoice($invoice_id, $transport->fi_id,$student_id);
            }
            if(!empty($dormitory))
            {
            $this->add_items_in_invoice($invoice_id, $dormitory->fi_id,$student_id);
            }
            $account=$db->get_where('sys_accounts')->row()->id;
            $current_bal=$db->get_where('crm_accounts',array('id'=>$student_id))->row();
            if($current_bal)
            {
                $current_bal=$current_bal ->balance;
                $payee_bal=$current_bal-$total;
            }
            else{
                $payee_bal=-$total;
            }
            $data3['account'] = $account;
            $data3['type'] = 'Expense';
            $data3['payeeid'] =  $student_id;
            $data3['payee_balance'] = $payee_bal;
            $data3['tags'] =  'Invoice';
            $data3['amount'] = $total;
            $data3['category'] = 'Invoice';
            $data3['method'] = 'StudInvoice';
            $data3['ref'] = $invoice_id;
            
            $data3['description'] = 'invoice on '.$invoice_id;
            $data3['date'] = date('Y-m-d');
            $data3['dr'] = $total;
            $data3['cr'] = '0.00';
            $data3['bal'] = -$total;
            //others
            $data3['payer'] = '';
            $data3['payee'] = '';
            $data3['payerid'] = '0';
            $data3['status'] = 'Cleared';
            $data3['tax'] = '0.00';
            $data3['iid'] = $invoice_id;
            $data3['school_id'] = $this->school_id;
            $db->insert('sys_transactions',$data3);
            
        }

        function connect_db()
        {
            $ci = & get_instance();
            $database = $ci->db->database;
            $usename=$ci->db->username;
            $password=$ci->db->password;
            $dsn1 = 'mysqli://'.$usename.':'.$password.'@localhost/'.CURRENT_FI_DB;
            //set_machin_active_log('$dsn1 :'.$dsn1);
            $a = $ci->load->database($dsn1, true);
            return $a; 
        }
        
        /*
         * Scholarship details list by running year
         * @param $running_year Academic Year
         * @param $scholarships Scholarship list according to Running Year.
         * 
         */
        
        
        function getScholarships($running_year = '') {
            $db=$this->connect_db();
            if($running_year !== '') {
                $scholarships       =   $db->get_where('sys_scholarship',array('academic_year'=>$running_year,'school_id'=>$this->school_id));
                if($scholarships!=''){
                    $scholarships = $scholarships->result_array();
                }
            } else {
                $scholarships       =   $db->get('sys_scholarship')->where(array('school_id'=>$this->school_id))->result_array();
            }
            if(count($scholarships)>0) 
                return $scholarships;
            else 
                return FALSE;
        }
        
        /*
         * Active installment by year
         * @param $running_year Academic year
         * @return $active_installments Active installments
         */
        function getActiveInstallments( $running_year ) {
            $db=$this->connect_db();
            $active_installments       =   $db->get_where('sys_settings',array('academic_year'=>$running_year,'school_id'=>$this->school_id));
            if($active_installments!='')
                $active_installments = $active_installments->result_array();
            if($active_installments)
                return $active_installments;
            else 
                return FALSE;
        }
        
        /*
         * Active installment by year
         * @param $running_year Academic year
         * @return $active_installments Active installments
         */
        function get_installments( $installment_id ) {
            $db     =   $this->connect_db();
            $installments       =   $db->get_where('sys_installments',array('id'=>$installment_id,'school_id'=>$this->school_id))->result_array();
            if($installments)
                return $installments;
            else 
                return FALSE;
        }
        
        function add_items_in_invoice($invoice_id,$item_id,$student_id)
        {
            $data2['invoiceid']=$invoice_id;
            $db=$this->connect_db();
            $charges=$db->get_where('sys_items',array('id'=>$item_id,'school_id'=>$this->school_id))->row();
            $data2['userid']=$student_id;
            $data2['description']=$charges->description;
            $data2['amount']=$charges->sales_price;
            $data2['taxed']=0;
            $data2['total']=$charges->sales_price;
            $data2['type'] = '';
            $data2['relid'] = '0';
            $data2['itemcode'] = '';
            $data2['taxamount'] = '0.00';
            $data2['duedate'] = date('Y-m-d');
            $data2['paymentmethod'] = '';
            $data2['notes'] = '';
            $db->insert('sys_invoiceitems',$data2);
            //echo ($db->last_query());       
        }
        
        /*
         * get fee by class id
         * @param $group_id
         * @return fee details of the class
         */
        
        function get_fee_due_list($data,$running_year = '', $class_id = '', $section_id = ''){
        $db=$this->connect_db();
        $curr_date      =   date('Y-m-d');
        pre($data);
        $db->select("sys_invoices.account, duedate, crm.*");
        $db->from("sys_invoices");
        $db->join("crm_accounts crm", "sys_invoices.userid = crm.id", "left");
        $db->where("sys_invoices.duedate<='".$curr_date."'");
        if($class_id != ""){
            $db->where("sys_invoices.gid = ".$data['e.class_id']);
        } if($section_id != ""){
            $db->where("sys_invoices.section_id = ".$data['sec.section_id']);
        }//echo "Jesus"; exit;
        $query = $db->get();
        echo $this->db->last_query();
        return $query->result_array();
    }
        function get_fee_detailsbygroup($group_id) {
            $db             =   $this->connect_db();
            $fee_det        =   $db->get_where('sys_items',array('group_id'=>$group_id,'fee_type'=>4,'school_id'=>$this->school_id))->result_array();
            if($fee_det) 
                return $fee_det[0];
            else 
                return FALSE;
        }
        
        /* get route charges
         * @return return all transport fee in the fi module
         */
        function get_routecharges($academic_year) {
            $db=$this->connect_db();
            $charges=$db->get_where('sys_items',array('fee_type'=>'6','academic_year'=>$academic_year,'school_id'=>$this->school_id))->result_array();
            if($charges) {
                return $charges;
            } else {
                return FALSE;
            }
            
        }
        
        
        /* get hostel charges
         * @return return all hostel fee in the fi module
         */
        function get_hostelcharges($academic_year) {
            $db=$this->connect_db();
            $charges        =   $db->get_where('sys_items',array('fee_type'=>'5','academic_year'=>$academic_year,'school_id'=>$this->school_id))->result_array();
            if($charges) {
                return $charges;
            } else {
                return FALSE;
            }
            
        }
        
        /*
         * Create invoice
         * @param $student_id
         * @param $academic_year
         */
        function create_admission_invoice( $student_id , $academic_year ) {
            $db         =   $this->connect_db();
            //echo '<pre>';print_r($student_id);exit;
            $charges    =   $db->get_where('sys_stud_feeconfig',array('student_id'=>$student_id,'academic_year'=>$academic_year,'school_id'=>$this->school_id))->result_array();
            //echo '<pre>';print_r($charges);exit;

            if(count($charges)>=1) { 
                $stud_fee_setting       =   $charges[0];
                //echo '<pre>';print_r( $stud_fee_setting );exit;
                if($stud_fee_setting['tutionfee_inst_type'] == $stud_fee_setting['transpfee_inst_type'] && $stud_fee_setting['transpfee_inst_type'] == $stud_fee_setting['hostfee_inst_type']) {
                    $create_invoice         =   $this->create_all_fee_invoice( $student_id , $academic_year ); 
                } elseif( $stud_fee_setting['tutionfee_inst_type'] == $stud_fee_setting['transpfee_inst_type'] && $stud_fee_setting['tutionfee_inst_type'] != $stud_fee_setting['hostfee_inst_type']) {
                    $create_invoice         =   $this->create_tution_transport_feeinvoice( $student_id , $academic_year );
                    $create_invoice         =   $this->create_hostel_feeinvoice( $student_id , $academic_year );
                } elseif( $stud_fee_setting['tutionfee_inst_type'] == $stud_fee_setting['hostfee_inst_type'] && $stud_fee_setting['tutionfee_inst_type'] != $stud_fee_setting['transpfee_inst_type']) {                    
                    $create_invoice         =   $this->create_tution_hostel_feeinvoice( $student_id , $academic_year );
                    $create_invoice         =   $this->create_transp_feeinvoice( $student_id , $academic_year );
                } elseif( $stud_fee_setting['transpfee_inst_type'] == $stud_fee_setting['hostfee_inst_type'] && $stud_fee_setting['tutionfee_inst_type'] != $stud_fee_setting['transpfee_inst_type']) {                                        
                    $create_invoice         =   $this->create_transp_hostel_feeinvoice( $student_id , $academic_year );
                    $create_invoice         =   $this->create_tution_feeinvoice( $student_id , $academic_year );
                } else {
                    $create_tution_invoice =   $this->create_tution_feeinvoice( $student_id , $academic_year );
                    $create_transp_invoice =   $this->create_transp_feeinvoice( $student_id , $academic_year );
                    $create_hostel_invoice =   $this->create_hostel_feeinvoice( $student_id , $academic_year );
                }
            }
            return TRUE;
        }
        
        /*
         * create single invoice for all fee
         */
        function create_all_fee_invoice( $student_id , $academic_year ) {
            $db         =   $this->connect_db();
            $charges    =   $db->get_where('sys_stud_feeconfig',array('student_id'=>$student_id,'academic_year'=>$academic_year,'school_id'=>$this->school_id))->result_array();
            if(count($charges)>=1) {
                $stud_fee_setting           =   $charges[0];
                $instalment_type            =   $stud_fee_setting['tutionfee_inst_type'];
                $fee_det                    =   array();
                if($stud_fee_setting['trans_fee_id']!=0 && $stud_fee_setting['hostel_fee_id']!=0) {
                    $tution_fee_det         =   $db->get_where('sys_items',array('id'=>$stud_fee_setting['tution_fee_id'],'school_id'=>$this->school_id))->result_array();
                    $transp_fee_det         =   $db->get_where('sys_items',array('id'=>$stud_fee_setting['trans_fee_id'],'school_id'=>$this->school_id))->result_array();
                    $hostel_fee_det         =   $db->get_where('sys_items',array('id'=>$stud_fee_setting['hostel_fee_id'],'school_id'=>$this->school_id))->result_array();
                    
                    //echo '<pre>';print_r($tution_fee_det);print_r($transp_fee_det);print_r($hostel_fee_det);exit;
                    $fee_det        =   array_merge($fee_det,$tution_fee_det);
                    $fee_det        =   array_merge($fee_det,$transp_fee_det);
                    $fee_det        =   array_merge($fee_det,$hostel_fee_det);
                } elseif($stud_fee_setting['trans_fee_id']==0 && $stud_fee_setting['hostel_fee_id']!=0) {
                    $tution_fee_det         =   $db->get_where('sys_items',array('id'=>$stud_fee_setting['tution_fee_id'],'school_id'=>$this->school_id))->result_array();
                    $hostel_fee_det         =   $db->get_where('sys_items',array('id'=>$stud_fee_setting['hostel_fee_id'],'school_id'=>$this->school_id))->result_array();
                    
                    $fee_det        =   array_merge($fee_det,$tution_fee_det);
                    $fee_det        =   array_merge($fee_det,$hostel_fee_det);
                } elseif($stud_fee_setting['trans_fee_id']!=0 && $stud_fee_setting['hostel_fee_id']==0) {
                    $tution_fee_det         =   $db->get_where('sys_items',array('id'=>$stud_fee_setting['tution_fee_id'],'school_id'=>$this->school_id))->result_array();
                    $transp_fee_det         =   $db->get_where('sys_items',array('id'=>$stud_fee_setting['trans_fee_id'],'school_id'=>$this->school_id))->result_array();
                    
                    $fee_det        =   array_merge($fee_det,$tution_fee_det);
                    $fee_det        =   array_merge($fee_det,$transp_fee_det);
                } else {
                    $tution_fee_det         =   $db->get_where('sys_items',array('id'=>$stud_fee_setting['tution_fee_id'],'school_id'=>$this->school_id))->result_array();
                    
                    $fee_det        =   array_merge($fee_det,$tution_fee_det);
                }
                
                return $this->prepare_invoice( $student_id , $academic_year , $fee_det , $instalment_type);
            }
        }
        
        
        function create_tution_transport_feeinvoice( $student_id , $academic_year ) {
            $db         =   $this->connect_db();
            $charges    =   $db->get_where('sys_stud_feeconfig',array('student_id'=>$student_id,'academic_year'=>$academic_year,'school_id'=>$this->school_id))->result_array();
            if( count($charges)>=1 ) {
                $stud_fee_setting           =   $charges[0];
                $instalment_type            =   $stud_fee_setting['tutionfee_inst_type'];
                $fee_det                    =   array();
                if( $stud_fee_setting['trans_fee_id']!=0 && $stud_fee_setting['tution_fee_id']!=0 ) {
                    $tution_fee_det         =   $db->get_where('sys_items',array('id'=>$stud_fee_setting['tution_fee_id'],'school_id'=>$this->school_id))->result_array();
                    $transp_fee_det         =   $db->get_where('sys_items',array('id'=>$stud_fee_setting['trans_fee_id'],'school_id'=>$this->school_id))->result_array();
                    
                    $fee_det        =   array_merge($fee_det,$tution_fee_det);
                    $fee_det        =   array_merge($fee_det,$transp_fee_det);
                } elseif($stud_fee_setting['trans_fee_id']==0 && $stud_fee_setting['tution_fee_id']!=0) {
                    $tution_fee_det         =   $db->get_where('sys_items',array('id'=>$stud_fee_setting['tution_fee_id'],'school_id'=>$this->school_id))->result_array();
                    
                    $fee_det        =   array_merge($fee_det,$tution_fee_det);
                }  else {
                    return "Fee not configured";
                } 
                return $this->prepare_invoice( $student_id , $academic_year , $fee_det , $instalment_type);
            }
        }
        
        function create_tution_hostel_feeinvoice( $student_id , $academic_year ) {
            $db         =   $this->connect_db();
            $charges    =   $db->get_where('sys_stud_feeconfig',array('student_id'=>$student_id,'academic_year'=>$academic_year,'school_id'=>$this->school_id))->result_array();
          
            if( count($charges)>=1 ) {
                $stud_fee_setting           =   $charges[0];
                $instalment_type            =   $stud_fee_setting['tutionfee_inst_type'];
                $fee_det                    =   array();
                if( $stud_fee_setting['hostel_fee_id']!=0 && $stud_fee_setting['tution_fee_id']!=0 ) {
                    $tution_fee_det         =   $db->get_where('sys_items',array('id'=>$stud_fee_setting['tution_fee_id'],'school_id'=>$this->school_id))->result_array();
                    $hostel_fee_det         =   $db->get_where('sys_items',array('id'=>$stud_fee_setting['hostel_fee_id'],'school_id'=>$this->school_id))->result_array();
                    
                    $fee_det        =   array_merge($fee_det,$tution_fee_det);
                    $fee_det        =   array_merge($fee_det,$hostel_fee_det);
                } elseif($stud_fee_setting['hostel_fee_id']==0 && $stud_fee_setting['tution_fee_id']!=0) {
                    $tution_fee_det =   $db->get_where('sys_items',array('id'=>$stud_fee_setting['tution_fee_id'],'school_id'=>$this->school_id))->result_array();
                    $fee_det        =   array_merge($fee_det,$tution_fee_det);
                } else {
                    return "Fee not configured";
                }
                return $this->prepare_invoice( $student_id , $academic_year , $fee_det , $instalment_type);
            }
        }
        
        function create_transp_hostel_feeinvoice( $student_id , $academic_year ) {
            $db         =   $this->connect_db();
            $charges    =   $db->get_where('sys_stud_feeconfig',array('student_id'=>$student_id,'academic_year'=>$academic_year,'school_id'=>$this->school_id))->result_array();
            if( count($charges)>=1 ) {
                $stud_fee_setting           =   $charges[0];
                $instalment_type            =   $stud_fee_setting['transpfee_inst_type'];
                //echo '<pre>';print_r( $stud_fee_setting );exit;
                $fee_det                    =   array();
                if( $stud_fee_setting['hostel_fee_id']!=0 && $stud_fee_setting['trans_fee_id']!=0 ) {
                    //echo '<pre>1';print_r( $stud_fee_setting );exit;
                    $hostel_fee_det         =   $db->get_where('sys_items',array('id'=>$stud_fee_setting['hostel_fee_id'],'school_id'=>$this->school_id))->result_array();
                    $transp_fee_det         =   $db->get_where('sys_items',array('id'=>$stud_fee_setting['trans_fee_id'],'school_id'=>$this->school_id))->result_array();
                    
                    $fee_det        =   array_merge($fee_det,$hostel_fee_det);
                    $fee_det        =   array_merge($fee_det,$transp_fee_det);
                } elseif($stud_fee_setting['hostel_fee_id']==0 && $stud_fee_setting['trans_fee_id']!=0) {
                    //echo '<pre>2';print_r( $stud_fee_setting );exit;
                    $transp_fee_det         =   $db->get_where('sys_items',array('id'=>$stud_fee_setting['trans_fee_id'],'school_id'=>$this->school_id))->result_array();
                    $fee_det        =   array_merge($fee_det,$transp_fee_det);
                } elseif($stud_fee_setting['hostel_fee_id']!=0 && $stud_fee_setting['trans_fee_id'] == 0 ) {
                    //echo '<pre>3';print_r( $stud_fee_setting );exit;
                    $hostel_fee_det         =   $db->get_where('sys_items',array('id'=>$stud_fee_setting['hostel_fee_id'],'school_id'=>$this->school_id))->result_array();
                    $fee_det        =   array_merge($fee_det,$hostel_fee_det);
                } else {
                    //echo '<pre>4';print_r( $stud_fee_setting );exit;
                    return "Fee not configured";
                }
                return $this->prepare_invoice( $student_id , $academic_year , $fee_det , $instalment_type);
            }
        }
        
        function create_tution_feeinvoice( $student_id , $academic_year ) {
            $db         =   $this->connect_db();
            $charges    =   $db->get_where('sys_stud_feeconfig',array('student_id'=>$student_id,'academic_year'=>$academic_year,'school_id'=>$this->school_id))->result_array();
            if( count($charges)>=1 ) {
                $stud_fee_setting           =   $charges[0];
                $fee_det                    =   array();
                if($stud_fee_setting['tution_fee_id']!=0) {
                    $tution_fee_det         =   $db->get_where('sys_items',array('id'=>$stud_fee_setting['tution_fee_id'],'school_id'=>$this->school_id))->result_array();
                    $instalment_type        =   $stud_fee_setting['tutionfee_inst_type'];
                    $fee_det        =   array_merge($fee_det,$tution_fee_det);
                }  else {
                    return "Fee not configured";
                }
                return $this->prepare_invoice( $student_id , $academic_year , $fee_det , $instalment_type);
            }
        }
        
        function create_transp_feeinvoice( $student_id , $academic_year ) {
            $db         =   $this->connect_db();
            $charges    =   $db->get_where('sys_stud_feeconfig',array('student_id'=>$student_id,'academic_year'=>$academic_year,'school_id'=>$this->school_id))->result_array();
            if( count($charges)>=1 ) {
                $stud_fee_setting           =   $charges[0];
                $fee_det                    =   array();
                if($stud_fee_setting['trans_fee_id']!=0) {
                    $transp_fee_det         =   $db->get_where('sys_items',array('id'=>$stud_fee_setting['trans_fee_id'],'school_id'=>$this->school_id))->result_array();
                    $instalment_type        =   $stud_fee_setting['transpfee_inst_type'];
                    $fee_det        =   array_merge($fee_det,$transp_fee_det);
                }  else {
                    return "Fee not configured";
                }
                return $this->prepare_invoice( $student_id , $academic_year , $fee_det , $instalment_type);
            }            
        }
        
        /*
         * Create hostel fee invoice
         */
        function create_hostel_feeinvoice( $student_id , $academic_year ) {
            $db         =   $this->connect_db();
            $charges    =   $db->get_where('sys_stud_feeconfig',array('student_id'=>$student_id,'academic_year'=>$academic_year,'school_id'=>$this->school_id))->result_array();
            if( count($charges)>=1 ) {
                $stud_fee_setting           =   $charges[0];
                $fee_det                    =   array();
                if($stud_fee_setting['hostel_fee_id']!=0) {
                    $hostel_fee_det         =   $db->get_where('sys_items',array('id'=>$stud_fee_setting['hostel_fee_id'],'school_id'=>$this->school_id))->result_array();
                    $instalment_type        =   $stud_fee_setting['hostfee_inst_type'];
                    $fee_det                =   array_merge($fee_det,$hostel_fee_det);
                }  else {
                    return "Fee not configured";
                }
                return $this->prepare_invoice( $student_id , $academic_year , $fee_det , $instalment_type);
            }
        }
        
        /*
         * Get student details by id
         * @param $student_id int
         * @return $student_det array
         */
        function getStudentDetails($student_id) {
            $CI =& get_instance();
            $CI->load->model('Student_model');
            return $CI->Student_model->get_student_details($student_id);
        }
        /*
         * prepare invoice with fee details
         */
        function prepare_invoice( $student_id , $academic_year , $fee_det , $instalment_type ) {   
            if(empty($fee_det))
                return FALSE;
            $db         =   $this->connect_db();
            $charges    =   $db->get_where('sys_stud_feeconfig',array('student_id'=>$student_id,'academic_year'=>$academic_year,'school_id'=>$this->school_id))->result_array();

            $fi_setting     =   $db->get('sys_appconfig')->row_array();
            $new_accouting = isset($fi_setting['new_accounting'])?$fi_setting['new_accounting']:0;
            if(count($charges)>=1) {
                //echo '<pre>';print_r($charges[0]);print_r($fee_det);exit;
                $stud_fee_setting       =   $charges[0];
                $student_det            =   $this->getStudentDetails($student_id);
                $invoice_amount         =   0;
                $scholarship            =   0;
                $fee_amount             =   0;
                $scholarship_amount     =   0;
                $installment_det        =   $db->get_where('sys_installments',array('id'=>(int)$instalment_type,'school_id'=>$this->school_id))->result_array();
                //echo '<pre>-';print_r($fee_det);exit;
                $no_of_inst             =   $installment_det[0]['no_of_installment'];

                $fee_instas = array();
                foreach($fee_det as $fee) {
                    if($new_accouting && $fee['fee_type']==4){
                        $insta_type = $charges[0]['tutionfee_inst_type'];
                        $fee_instas = $db->get_where('fee_installments',array('academic_year'=>$academic_year,'group_id'=>$student_det->class_id,
                                        'installment_id'=>$charges[0]['tutionfee_inst_type'],'school_id'=>$this->school_id))->result();
                    }else{
                        $fee_amount             =   $fee['sales_price']/$no_of_inst;
                        //echo $fee_amount            ;exit;
                        $invoice_amount         =   $invoice_amount+$fee_amount;
                        if($stud_fee_setting['scholarship_id'] != 0 && $fee['scholarship_active'] == 1 ) {
                            $db                     =   $this->connect_db();
                            $scholarship_det        =   $db->get_where('sys_scholarship',array('id'=>(int)$stud_fee_setting['scholarship_id'],'school_id'=>$this->school_id))->result_array();
                            $discount_value         =       $scholarship_det[0]['deduction_value'];
                            if($scholarship_det[0]['deduction_type'] == 1) { //amount
                                $scholarship_amount     =       $scholarship_amount+ round(($scholarship_det[0]['deduction_value']/$no_of_inst));
                                $discount_type          =       'f';
                            } else { //percentage
                                $scholarship_amount     =       $scholarship_amount+($invoice_amount * $scholarship_det[0]['deduction_value']) / 100;
                                $discount_type          =       'p';
                            }
                        }
                    }
                   
                }
                //echo $scholarship_amount;exit;

                $instalment_id          =       $instalment_type;
                $scholarship_id         =       $stud_fee_setting['scholarship_id'];
                
                $sub_total              =       $invoice_amount;
                $grand_total            =       $invoice_amount - $scholarship_amount; 
                    
                $discount_type          =       (isset($discount_type)?$discount_type:'');
                $discount_value         =       (isset($discount_value)?$discount_value:'');
                $discount_amount        =       (isset($scholarship_amount)?$scholarship_amount:'');
                
                $start_month            =       $installment_det[0]['start_month'];
                $start_date             =       $installment_det[0]['start_date'];
                $grace_period           =       $installment_det[0]['grace_period'];

                $month_diff             =       12/(int)$no_of_inst;
                $invoice_year           =       explode( "-" , $academic_year );
                $init_invoice_date      =       $invoice_year[0].'-'.$start_month.'-'.$start_date;  
                $init_invoice_date      =       strtotime($init_invoice_date);
                $init_invoice_date      =       date('Y-m-d',$init_invoice_date);

                $next_invoice_date      =       $init_invoice_date;
                //echo $no_of_inst;exit;
                for($c=1;$c<=$no_of_inst;$c++) {
                    $fee_insta =isset($fee_instas[($c-1)])?$fee_instas[($c-1)]:false;

                    if($c==1) {
                        $invoice_date   =       $next_invoice_date;
                    } else {
                        $next_invoice_date  =       date('Y-m-d', strtotime(date("Y-m-d", strtotime($next_invoice_date)) . " +".(int)$month_diff." month"));
                    }

                    $invoice_date           =   $next_invoice_date;
                    $invoice_due_date       =   date('Y-m-d', strtotime(date("Y-m-d", strtotime($next_invoice_date)) . " +".(int)$grace_period." day"));

                    $data                   =   array();
                    $data['userid']         =   $student_id;
                    $data['account']        =   $student_det->name.' '.$student_det->lname;
                    $data['date']           =   $invoice_date;
                    $data['bank_acc_id']    =   1;
                    $data['duedate']        =   $invoice_due_date;
                    $data['subtotal']       =   ($fee_insta?$fee_insta->amount+$sub_total:$sub_total);
                    $data['discount_type']  =   $discount_type;
                    $data['discount_value'] =   $discount_value;
                    $data['discount']       =   $discount_amount;
                    $data['total']          =   ($fee_insta?$fee_insta->amount+$grand_total:$grand_total);
                    $data['instalment_id']  =   $instalment_id;
                    $data['scholarship_id'] =   $scholarship_id;
                    $data['vtoken']         =   substr(rand(0, 1000000000), 0, 9);
                    $data['ptoken']         =   substr(rand(0, 1000000000), 0, 9);
                    $data['status']         =   'Unpaid';
                    $data['school_id']      =   $this->school_id;
                    $invoice_id             =   $this->createInvoice($data);
                    $transaction_id         =   $this->updateTransaction($invoice_id);

                    $items                  =   array();
                    foreach($fee_det as $fdkey=>$fee){
                        if($new_accouting && $fee['fee_type']==4 && $fee_insta){
                            $db->select('FII.*,SI.name item_name');    
                            $db->from('fee_insta_items FII');
                            $db->join('sys_items SI','SI.id=FII.item_id','LEFT');
                            $db->where(array('FII.insta_id'=>$fee_insta->id,'school_id'=>$this->school_id));
                            $fee_insta_items = $db->get()->result();

                            foreach($fee_insta_items as $fik=>$fii){
                                $items[] = array('userid'=>$student_id,
                                                 'invoiceid'=>$invoice_id,
                                                 'description'=> $fii->item_name,
                                                 'qty'=>1,
                                                 'amount'=>$fii->amount,
                                                 'taxed'=>0,
                                                 'total'=>$fii->amount,
                                                 'type'=>'',
                                                 'relid'=>'0',
                                                 'itemcode'=>($fik+1),
                                                 'duedate'=>'',
                                                 'paymentmethod'=>'',
                                                 'notes'=>'',
                                                 'school_id'=>$this->school_id);
                            }                        
                        }else{
                            $items[]        =   array('userid'=>$student_id,
                                                    'invoiceid'=>$invoice_id,
                                                    'description'=>$fee['name'],
                                                    'qty'=>1,
                                                    'amount'=>($fee['sales_price']/$no_of_inst),
                                                    'taxed'=>0,
                                                    'total'=>($fee['sales_price']/$no_of_inst),
                                                    'type'=>'',
                                                    'relid'=>'0',
                                                    'itemcode'=>$fee['item_number'],
                                                    'duedate'=>'',
                                                    'paymentmethod'=>'',
                                                    'notes'=>'',
                                                    'school_id'=>$this->school_id);
                        }                                
                    }
                    //echo '<pre>';print_r( $items);exit;
                    $insert_items           =   $this->insert_invoice_items($items);
                }
                return $c;
            }
        }


        /*
         * Create Invoice
         * @param $data array 
         */
        function createInvoice($data) {
            $db         =       $this->connect_db();
            if($db->insert('sys_invoices',$data))
                return $invoice_id     =   $db->insert_id();
            else 
                return FALSE;
        }
        
        /*
         * Insert Invoice items
         * @param $items invoice items
         * @return
         */
        function insert_invoice_items($items) {
            $db         =       $this->connect_db();
            $count      =       0;
            foreach($items as $item) {
                if($db->insert('sys_invoiceitems',$item)) 
                    $count++;
            }
            
            return $count;
        }
        
        /*
         * Transactions
         */
        function updateTransaction($invoice_id) {
            $db         =   $this->connect_db();
            $invoice    =   $db->get_where('sys_invoices',array('id'=>(int)$invoice_id,'school_id'=>$this->school_id))->result_array();
            $invoice    =   $invoice[0];
            $amount     =   $invoice['total'];
            $user_id    =   $invoice['userid'];
            $bank_acc_id=   $invoice['bank_acc_id'];
            
            $account    =   $db->get_where('sys_accounts',array('id'=>(int)$bank_acc_id,'school_id'=>$this->school_id))->result_array();
            $account    =   isset($account[0])?$account[0]:false;
            $cbal       =   $account?$account['balance']:0;
            $nbal       =   $cbal + $amount;

            $b1         =   $db->get_where('sys_transactions',array('payeeid'=>(int)$user_id,'school_id'=>$this->school_id))->result_array();
            $b2         =   $db->get_where('sys_transactions',array('payerid'=>(int)$user_id,'school_id'=>$this->school_id))->result_array();
            
            if(count($b1) > 0) {
                foreach($b1 as $trans) {
                    $payee_bal1      =   $trans['payee_balance'] - $amount;
                    $payee_trans1    =   $trans['id'];
                }
            } else {
                $payee_bal1      =   0-$amount;
//                    $payee_trans1    =   $trans['id'];
            }

            if(!empty($b1[0])) {
                foreach($b1 as $trans) {
                    $payee_bal1      =   $trans['payee_balance'] - $amount;
                    $payee_trans1    =   $trans['id'];
                }
            } else {
                $payee_bal1      =   0-$amount;
            }

            if(!empty($b2[0])) {
                foreach($b2 as $trans) {
                    $payee_bal2      =   $trans['payee_balance'] - $amount;
                    $payee_trans2    =   $trans['id'];
                }
            } else {
                $payee_bal2      =   0-$amount;
            }

            if(!empty($b2[0]) && !empty($b1[0])) {
                $payee_bal      =   ($payee_trans1 > $payee_trans2?$payee_bal1:$payee_bal2);
            } else if(!empty($b2[0])) {
                $payee_bal      =   $payee_bal2;
            } else if(!empty($b1[0])) {
                $payee_bal      =   $payee_bal1;
            } else {
                $payee_bal      =   0-$amount;
            }
            
            $trans_data         =   array(
                'account'       =>  $bank_acc_id,
                'type'          =>  'Expense',
                'payeeid'       =>  $user_id,
                'payee_balance' =>  $payee_bal,
                'tags'          =>  'Invoice',
                'amount'        =>  $amount,
                'category'      =>  'Invoice',
                'method'        =>  'StudInvoice',
                'ref'           =>  $invoice_id,
                'description'   =>  'invoice on '.$invoice_id,
                'date'          =>  $invoice['date'],
                'dr'            =>  $amount,
                'cr'            =>  '0.00',
                'bal'           =>  $nbal,
                'payer'         =>  '',
                'payee'         =>  '',
                'payerid'       =>  '0',
                'status'        =>  'Cleared',
                'tax'           =>  '0.00',
                'iid'           =>  0,
                'school_id'     =>  $this->school_id,
            );
            
            if($db->insert('sys_transactions',$trans_data))
                return $trans_id     =   $db->insert_id();
            else 
                return FALSE;
        }
        
    public function updateStudent_inFinance( $student_id , $student_data ) {
            $db         =       $this->connect_db();
            $db->where(array('id'=>$student_id));
            $result     =       $db->update('crm_accounts',$student_data);
            if($result) 
                return TRUE;
            else
                return FALSE;
    }
    
    function getStudentFeeSettings($student_id,$academic_year){
        $db         =       $this->connect_db();
        $charges    =       $db->get_where('sys_stud_feeconfig',array('student_id'=>$student_id,'academic_year'=>$academic_year,'school_id'=>$this->school_id))->result_array();
        if($charges)
            return $charges;
        else
            return FALSE;
    }
    
    function delete_group($class_id) {
        $db         =       $this->connect_db();
        $result     =       $db->where('id',(int)$class_id)->delete('crm_groups');
        if($result)
            return TRUE;
        else
            return FALSE;
    }
    
    function get_feeconfigured_studentlist($section_id,$running_year) {
        $db             =       $this->connect_db();
        $db->select('crm_accounts.account,crm_accounts.lname,crm_accounts.id,sys_stud_feeconfig.student_id');
        $db->from('crm_accounts');
        $db->join('sys_stud_feeconfig', 'sys_stud_feeconfig.student_id = crm_accounts.id'); 
        $db->where('crm_accounts.section_id',$section_id);
        $db->where('crm_accounts.school_id',$this->school_id);
        $db->where('sys_stud_feeconfig.academic_year',$running_year);
        $query          =   $db->get();
        $res            =   $query->result();
        return $res;
    }
    
    function run_fee_penalty($academic_year = '2017-2018') { 
        $db                 =   $this->connect_db();
        $fee_penalty        =   $db->get_where('sys_fee_penalty',array('status'=>'1','academic_year'=>$academic_year,'school_id'=>$this->school_id))->result_array();
        $fee_penalty        =   array_shift($fee_penalty);
        $penalty_perday     =   $fee_penalty['amount_per_day'];
        $curr_date          =   date('Y-m-d');
        $due_invoices           =   $this->get_dued_invoices($curr_date);
        foreach($due_invoices as $invoice) { 
            $date_diff          =       strtotime($curr_date) - strtotime($invoice->duedate);
            $total_diff         =       floor($date_diff/3600/24);
            $total_penalty      =       number_format($total_diff*$penalty_perday,2);
            if($total_penalty != $invoice->penalty_amount) {
                $total_amount       =   $invoice->total+$total_penalty;
                $this->update_fee_penalty($invoice->id,$fee_penalty['id'],$total_penalty,$total_amount);
            } else {
                continue;
            }
        }
    }
    
    function get_dued_invoices($curr_date) {
        
        $db                 =   $this->connect_db();
        $db->select('*');
        $db->from('sys_invoices');
        $db->where('duedate < ',$curr_date);
        $db->where('status','Unpaid');
        $db->where('school_id',$this->school_id);
        $query              =   $db->get();
        $res                =   $query->result();
        if(!empty($res)) {
            return $res;
        } else {
            return FALSE;
        }
    }
    
    function update_fee_penalty($invoice_id,$penalty_id,$total_penalty,$total_amount) {
        $db                 =   $this->connect_db();
        $db->where('id',$invoice_id);
        $db->update('sys_invoices',array('penalty_id'=>$penalty_id,'penalty_amount'=>$total_penalty,'total'=>$total_amount,'school_id'=>$this->school_id));
        return TRUE;
    }
    
    
    /*
     * run_fee_reminder
     */
    function run_fee_reminder() {
        $db                         =   $this->connect_db();
        $date_diff                  =   3;
        $curr_date                  =   strtotime( date('Y-m-d') );
        $due_cond_date              =   strtotime( "+".$date_diff."day" , $curr_date );
        $due_cond_date              =   date( 'Y-m-d' , $due_cond_date );
        $upcoming_due_invoices      =   $db->get_where( 'sys_invoices' , array('duedate = '=>$due_cond_date , 'status'=>'Unpaid','school_id'=>$this->school_id) )->result_array();  
        foreach($upcoming_due_invoices as $invoice) {
            $this->send_reminder($invoice['id'],$invoice['userid']);
        }
    }
    
    /*
     * Send message by curl
     */
    
    function send_reminder($invoice_id,$user_id) {
        $db                     =   $this->connect_db();
        $user_details           =   $db->get_where( 'crm_accounts' , array('id'=>$user_id,'school_id'=>$this->school_id) )->result_array();
        $user_details           =   array_shift($user_details);
        $user_details['parent_email'];
        $message                =    "Greetings,<br>
        This is a billing reminder that your invoice no. ".$invoice_id." 
If you have any questions or need assistance, please don't hesitate to contact us.
Best Regards,";
        $email_credentials      =   array(
                        'toemail'   =>$user_details['parent_email'],
                        'ccemail'   =>'',
                        'bccemail'  =>'sharadtechnologies@gmail.com',
                        'subject'   =>'Fee Reminder Notification',
                        'message'   =>$message,
                        'toname'    =>$user_details['company'],
                        'i_cid'     =>$user_id,
                        'i_iid'     =>$invoice_id
        );
        
                            $post = $email_credentials;
                              //echo print_r($post);exit;
                              $url = "http://".CURRENT_IP_ADDR."/beta_ag/fi/?ng=finance_automata";
                              fire_api_by_curl($url,$post);
    }
    
    /*
     * $condition array()
     */
    public function update_student_fee_det( $condition , $data ) {
        $db                     =   $this->connect_db();
        $db->where('school_id',$this->school_id);
        foreach($condition as $key=>$val) {
            $db->db->where($key,$val);
        }
        $db->db->update("sys_stud_feeconfig", $data);
        return TRUE;
    }
    
    /*
     * check_transport_fee_set or not for student
    */
    function update_transport_fee( $student_id , $fee_id , $academic_year ) {
        $db                     =   $this->connect_db();
        $student_fee_det        =   $this->getStudentFeeSettings($student_id,$academic_year);
        if( $student_fee_det ) {
            $student_fee_det    =   $student_fee_det[0];
            if($student_fee_det->trans_fee_id != 0 && $student_fee_det->trans_fee_id != $fee_id) {
                $update_transport_fee_id        =   '';
            } else {
                
            }
        }
    }
    
    function update_transport_invoice( $student_id , $old_fee_id , $fee_id ) {
        $db                     =   $this->connect_db();
        $item_to_add            =   $db->get_where('sys_items',array('id'=>$fee_id,'school_id'=>$this->school_id))->result_array();
        $item_to_add            =   $item_to_add[0];
        $transport_fee_det      =   $db->get_where('sys_invoiceitems',array('user_id'=>$student_id,'itemcode'=>$old_fee_id,'school_id'=>$this->school_id))->result_array();;
        if($transport_fee_det) {
            foreach($transport_fee_det as $transp_items) {
                $invoice_id         =   $transp_items->invoiceid;
                $item_amount        =   $transp_items->amount;
                $current_date       =   date('Y-m-d');
                $invoice            =   $db->get_where('sys_invoices',array('id'=>$invoice_id,'date >'=>$current_date,'school_id'=>$this->school_id))->result_array();
                $sub_total          =   $invoice[0]['sub_total'] - $item_amount + $item_to_add['sales_price'];
                $total              =   $invoice[0]['total'] - $item_amount + $item_to_add['sales_price'];
                $db->where('id',$invoice_id);
                $db->where('school_id',$this->school_id);
                $db->update('sys_invoices',array('sub_total'=>$sub_total,'total'=>$total));
                
                $db->delete('sys_invoiceitems',array('id'=>$transp_items->id));
            }
        }
    }
    
    /*
     * add transport fee
     */
    function add_transport_fee( $student_id , $fee_id , $academic_year ) {
        $db=$this->connect_db();
        $fee_det                =   array();
        $transpfee_det          =   $db->get_where('sys_items',array('id'=>$fee_id,'school_id'=>$this->school_id))->result_array();
        $fee_det                =   array_merge($fee_det, $transpfee_det);
        $instalment_type        =   $db->get_where('sys_stud_feeconfig',array('student_id'=>$student_id,'academic_year'=>$academic_year,'school_id'=>$this->school_id))->result_array();
        $instalment_type        =   $instalment_type[0]->transpfee_inst_type;
        $this->prepare_invoice( $student_id , $academic_year , $fee_det , $instalment_type );
    }
    
    function update_hostel_invoice( $student_id , $old_fee_id , $fee_id ) {
        $db                     =   $this->connect_db();
        $item_to_add            =   $db->get_where('sys_items',array('id'=>$fee_id,'school_id'=>$this->school_id))->result_array();
        $item_to_add            =   $item_to_add[0];
        $hostel_fee_det      =   $db->get_where('sys_invoiceitems',array('user_id'=>$student_id,'itemcode'=>$old_fee_id,'school_id'=>$this->school_id))->result_array();;
        if($hostel_fee_det) {
            foreach($hostel_fee_det as $hostel_items) {
                $invoice_id         =   $hostel_items->invoiceid;
                $item_amount        =   $hostel_items->amount;
                $current_date       =   date('Y-m-d');
                $invoice            =   $db->get_where('sys_invoices',array('id'=>$invoice_id,'date >'=>$current_date,'school_id'=>$this->school_id))->result_array();
                $sub_total          =   $invoice[0]['sub_total'] - $item_amount + $item_to_add['sales_price'];
                $total              =   $invoice[0]['total'] - $item_amount + $item_to_add['sales_price'];
                $db->where('id',$invoice_id);
                $db->where('school_id',$this->school_id);
                $db->update('sys_invoices',array('sub_total'=>$sub_total,'total'=>$total));
                
                $db->delete('sys_invoiceitems',array('id'=>$hostel_items->id));
            }
        }
    }
    
    /*
     * add transport fee
     */
    function add_hostel_fee( $student_id , $fee_id , $academic_year ) {
        $fee_det                =   array();
        $transpfee_det          =   $db->get_where('sys_items',array('id'=>$fee_id,'school_id'=>$this->school_id))->result_array();
        $fee_det                =   array_merge($fee_det, $transpfee_det);
        $instalment_type        =   $db->get_where('sys_stud_feeconfig',array('student_id'=>$student_id,'academic_year'=>$academic_year,'school_id'=>$this->school_id))->result_array();
        $instalment_type        =   $instalment_type[0]->hostfee_inst_type;
        $this->prepare_invoice( $student_id , $academic_year , $fee_det , $instalment_type );
    }
    function get_expense_report($data=array()){  
        $rs = array();
        $data['school_id'] = $this->school_id;
        $db=$this->connect_db();
        $db->select("sum(dr) dr, account"); 
        $db->from("sys_transactions");
        $db->where($data);
        $db->group_by("account");
        $query = $db->get();
        if($query){
            $rs = $query->result_array();
        } 
        return $rs;
    }
    
    /*function get_expense_report($data=array()){  
        $rs = array();
        $db=$this->connect_db();
        $db->select("sum(dr) dr, account"); 
        $db->from("sys_transactions");
        $db->where($data);
        $db->group_by("account");
        $query = $db->get();
        if($query){
            $rs = $query->result_array();
        } 
        return $rs;
    }
    */
    function get_school_income_report($data=array()){  
        //ini_set('display_errors', 1);
        //ini_set('display_startup_errors', 1);
        //error_reporting(E_ALL);
        $type = array("type"=>"Expense");
        $db = $this->connect_db();
        $rs = array();
        $db->select("sum(dr) dr, account, schools.name as school"); 
        $db->from("sys_transactions");
        $db->join("schools", "schools.school_id = sys_transactions.school_id","left");
        $db->where($type);
        $db->where('school_id',$this->school_id);
        $arrFromDate =  array();
        $arrToDate =    array();
        
        if(isset($data['from_date']))
        {    
            $arrFromDate = array("date >=" => $date['from_date']);
            $db->where($arrFromDate);
            
        }
        
        if(isset($data['to_date']))
        {    
            $arrToDate = array("date <=" => $date['to_date']);
            $db->where($arrToDate);
            
        }
        
        if(isset($data['school_id']))
        {
            $arrSchool = array("school_id" => $data['school_id']);
            $db->where($arrSchool);
            
            
        }
        
        $db->group_by("type");
        $db->group_by("sys_transactions.school_id");
        $query = $db->get();

//        echo $db->last_query();
//                echo "<br>we are here";
        if($query){
            $rs = $query->result_array();
        } 
        return $rs;
    }
}
    