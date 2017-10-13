<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(!function_exists('fi_non_enroll_receipt')){
    function fi_non_enroll_receipt($non_enroll_user_data,$is_advance_taken=0){
        $class_id = $non_enroll_user_data['class_id'];
        unset($non_enroll_user_data['class_id']);
        //pre($non_enroll_user_data);die;
        $CI=&get_instance();
        /* if($is_advance_taken==0)
            $sqlFiFees="SELECT * FROM `".CURRENT_FI_DB."`.`sys_items` WHERE `type`='OneTimeFeeBeforeAdmission' AND `optional_for_enquery`='1'";
        else if($is_advance_taken==1) */
        $sqlFiFees="SELECT * FROM `".CURRENT_FI_DB."`.`sys_items` WHERE `fee_type`='1' AND `group_id`='0'";
        $rs= $CI->db->query($sqlFiFees)->result();

        $sqlFiFees="SELECT * FROM `".CURRENT_FI_DB."`.`sys_items` WHERE `fee_type`='1' AND `group_id`='".$class_id."'";
        $group_rs= $CI->db->query($sqlFiFees)->result();

        $rs = $group_rs?$group_rs:$rs;
        generate_log("generate feesData for non-enroll user with ::  ".json_encode($rs));
        $sqlFiUser="SELECT * FROM `".CURRENT_FI_DB."`.`crm_accounts1` WHERE `email`='".$non_enroll_user_data['email']."'";
        $rsFiUser= $CI->db->query($sqlFiUser)->result();
        if(empty($rsFiUser)):
            $CI->db->insert(CURRENT_FI_DB.".crm_accounts1",$non_enroll_user_data);
            $crm_customer_id=$CI->db->insert_id();
        else:
            $crm_customer_id=$rsFiUser[0]->customer_id;
        endif;
        
        //$crm_customer_id=1;
        //pre($crm_customer_id);
        $total=0;
        foreach($rs AS $k){
            $total+=$k->sales_price;
        }
        
        $dataNonEnrollInvoice=array('userid'=>$crm_customer_id,'account'=>$non_enroll_user_data['account'],'date'=>date('Y-m-d'),'duedate'=>date('Y-m-d'),
            'datepaid'=>date('Y-m-d H:i:s'),'subtotal'=>$total,'credit'=>$total,'total'=>$total,'status'=>'Paid','vtoken'=>mt_rand(1000000000, mt_getrandmax()),
            'ptoken'=>mt_rand(1000000000, mt_getrandmax()),'nd'=>date('Y-m-d'),'r'=>0);
        
        //if($is_advance_taken==0){
            $dataNonEnrollInvoice['notes']="Enquery receipt without advance fees";
        /*     $dataNonEnrollInvoice['is_advance_fees_taken']=0;
        }else{
            $dataNonEnrollInvoice['notes']="Enquery receipt with advance fees";
            $dataNonEnrollInvoice['is_advance_fees_taken']=1;
        } */
        generate_log("generate invoice for non-enroll user with ::  ".json_encode($dataNonEnrollInvoice));
        $CI->db->insert(CURRENT_FI_DB.'.sys_invoices1',$dataNonEnrollInvoice);
        $invoice_id=$CI->db->insert_id();
        
        foreach ($rs as $k){
            $dataNonEnrollInvoiceItemArr=array('invoiceid'=>$invoice_id,'userid'=>$crm_customer_id,'description'=>$k->name,'taxed'=>0,
                'amount'=>$k->sales_price,'total'=>$k->sales_price,'type'=>'OneTimeFeeBeforeAdmission','relid'=>0,'itemcode'=>'',
                'taxamount'=>'0.00','duedate'=>date("Y-m-d"),'paymentmethod'=>'','notes'=>'');
            $CI->db->insert(CURRENT_FI_DB.'.sys_invoiceitems1',$dataNonEnrollInvoiceItemArr);
        }
        
    }
}