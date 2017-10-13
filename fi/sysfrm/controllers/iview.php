<?php
// *************************************************************************
// *                                                                       *
// * iBilling -  Accounting, Billing Software                              *
// * Copyright (c) Sadia Sharmin. All Rights Reserved                      *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * Email: sadiasharmin3139@gmail.com                                                *
// * Website: http://www.sadiasharmin.com                                  *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * This software is furnished under a license and may be used and copied *
// * only  in  accordance  with  the  terms  of such  license and with the *
// * inclusion of the above copyright notice.                              *
// * If you Purchased from Codecanyon, Please read the full License from   *
// * here- http://codecanyon.net/licenses/standard                         *
// *                                                                       *
// *************************************************************************
$ui->assign('_sysfrm_menu', 'invoices');
$ui->assign('_st', $_L['Invoice']);
$ui->assign('_title', $_L['Accounts'].'- '. $config['CompanyName']);
$action = $routes['1'];
$id  = $routes['2'];
$token  = $routes['3'];
$d = ORM::for_table('sys_invoices')->find_one($id);
//echo '<pre>';
switch ($action) {
    case 'print':
        /* if($d){
            $token = $routes['3'];
            $token = str_replace('token_','',$token);
            $vtoken = $d['vtoken'];
            if($token != $vtoken){
                echo 'Sorry Token does not match!';
                exit;
            }
            //find all activity for this user
            $items = ORM::for_table('sys_invoiceitems')->where('invoiceid',$id)->order_by_asc('id')->find_many();
            $trs_c = ORM::for_table('sys_transactions')->where('iid', $id)->count();
            $trs = ORM::for_table('sys_transactions')->where('iid', $id)->order_by_desc('id')->find_many();
            //find the user
            $a = ORM::for_table('crm_accounts')->find_one($d['userid']);

            include_once 'sysfrm/school_data_connection.php';
            $parent_data_sql        =   'SELECT stud.address,par.father_name,par.father_mname,par.father_lname FROM student AS stud JOIN parent AS par ON(par.parent_id = stud.parent_id) WHERE student_id = '.$d["userid"];    

            $parent_data_res        =   get_result_data($parent_data_sql);
            $i_credit = $d['credit'];
            $i_due = '0.00';
            $i_total = $d['total'];
            if($d['credit'] != '0.00'){
                $i_due = $i_total - $i_credit;
            }
            else{
                $i_due =  $d['total'];
            }
            $i_due = number_format($i_due,2,$config['dec_point'],$config['thousands_sep']);
            $cf = ORM::for_table('crm_customfields')->where('showinvoice','Yes')->order_by_asc('id')->find_many();

            require 'sysfrm/lib/invoices/render.php';
        } */
         if($d){
            $token = $routes['3'];
            $token = str_replace('token_','',$token);
            $vtoken = $d['vtoken'];
            $currSymbol = '<i class="fa fa-inr"></i>';///$config['currency_code']
            if($token != $vtoken){
                echo 'Sorry Token does not match!';
                exit;
            }

            //find all activity for this user
            $total_invoices = ORM::for_table('sys_invoices')->where('userid',$d['userid'])->find_many();
            $stu_config = ORM::for_table('sys_stud_feeconfig')->where('student_id',$d['userid'])->find_one();
            //echo $stu_config->tutionfee_inst_type;exit;
            $inst_rec = false;
            if($stu_config){
                $inst_rec = ORM::for_table('sys_installments')->where('id',$stu_config->tutionfee_inst_type)->find_one();
            }
            $total_intallments = $inst_rec?$inst_rec->no_of_installment:0;
            $items = ORM::for_table('sys_invoiceitems')->where('invoiceid',$id)->order_by_asc('id')->find_many();
            $trs_c = ORM::for_table('sys_transactions')->where('iid', $id)->count();
            $trs = ORM::for_table('sys_transactions')->select('sys_transactions.*')->select('A.account','account_name')
            ->join('sys_accounts','A.id=sys_transactions.account','A')->where('iid', $id)->order_by_desc('sys_transactions.id')->find_many();

            //find the user
            $a = ORM::for_table('crm_accounts')->find_one($d['userid']);
            $i_credit = $d['credit'];
            $i_due = '0.00';
            $i_total = $d['total'];
            if($d['credit'] != '0.00'){
                $i_due = $i_total - $i_credit;
            }
            else{
                $i_due =  $d['total'];
            }
            $i_due = number_format($i_due,2,$config['dec_point'],$config['thousands_sep']);
            $cf = ORM::for_table('crm_customfields')->where('showinvoice','Yes')->order_by_asc('id')->find_many();
            $invoice_terms_data = ORM::for_table('sys_appconfig')->where('setting','invoice_terms')->find_one();
            $invoice_terms= strip_tags($invoice_terms_data->value);
            
            $customSysName = $config['CompanyName'];
            include_once 'sysfrm/school_data_connection.php';
            //die($db_host.' = '.$db_user.'  == '.$db_password.' == '.$db_name);
            // Create connection
            
            //echo '<pre>';print_r($a);exit;
            $customSql="SELECT e.`enroll_code`,e.`class_id`,s.`admission_no` FROM `enroll` AS e JOIN `student` AS s ON(e.student_id=s.student_id) WHERE s.email='".$a["email"]."'";
            $customRowEnrollCode=get_single_result($customSql);
            $studentEnroleCode=$customRowEnrollCode[0];
            
            //echo '<pre>';print_r($customRowEnrollCode);exit;
            
            $customSqlRunningYear="SELECT `description` FROM `settings` WHERE type='running_year'";
            $customRowRunningYear=get_single_result($customSqlRunningYear);
            $running_year_arr= explode('-',$customRowRunningYear[0]);
            $invoiceRunningYear= substr($running_year_arr[0],2).'-'.substr($running_year_arr[1],2);
            
            $cla_rec = ORM::for_table('class')->where('class_id',$customRowEnrollCode[1])->find_one();
            $className = $cla_rec?$cla_rec['name']:'';
            $admission_no = $studentEnroleCode;//$customRowEnrollCode[2];
            $print_type = 'Invoice';
            require 'sysfrm/lib/invoices/render_receipt.php';

        }
        break;
    case 'recipt_print':
        if($d){
            $token = $routes['3'];
            $token = str_replace('token_','',$token);
            $vtoken = $d['vtoken'];
            $currSymbol = '<i class="fa fa-inr"></i>';///$config['currency_code']
            if($token != $vtoken){
                echo 'Sorry Token does not match!';
                exit;
            }

            //find all activity for this user
            $total_invoices = ORM::for_table('sys_invoices')->where('userid',$d['userid'])->find_many();
            $stu_config = ORM::for_table('sys_stud_feeconfig')->where('student_id',$d['userid'])->find_one();
            //echo $stu_config->tutionfee_inst_type;exit;
            $inst_rec = ORM::for_table('sys_installments')->where('id',$stu_config->tutionfee_inst_type)->find_one();
            $total_intallments = $inst_rec?$inst_rec->no_of_installment:0;
            $items = ORM::for_table('sys_invoiceitems')->where('invoiceid',$id)->order_by_asc('id')->find_many();
            $trs_c = ORM::for_table('sys_transactions')->where('iid', $id)->count();
            $trs = ORM::for_table('sys_transactions')->select('sys_transactions.*')->select('A.account','account_name')
            ->join('sys_accounts','A.id=sys_transactions.account','A')->where('iid', $id)->order_by_desc('sys_transactions.id')->find_many();

            //find the user
            $a = ORM::for_table('crm_accounts')->find_one($d['userid']);
            $i_credit = $d['credit'];
            $i_due = '0.00';
            $i_total = $d['total'];
            if($d['credit'] != '0.00'){
                $i_due = $i_total - $i_credit;
            }
            else{
                $i_due =  $d['total'];
            }
            $i_due = number_format($i_due,2,$config['dec_point'],$config['thousands_sep']);
            $cf = ORM::for_table('crm_customfields')->where('showinvoice','Yes')->order_by_asc('id')->find_many();
            $invoice_terms_data = ORM::for_table('sys_appconfig')->where('setting','invoice_terms')->find_one();
            $invoice_terms= strip_tags($invoice_terms_data->value);
            
            $customSysName = $config['CompanyName'];
            include_once 'sysfrm/school_data_connection.php';
            //die($db_host.' = '.$db_user.'  == '.$db_password.' == '.$db_name);
            // Create connection
            
            //echo '<pre>';print_r($a);exit;
            $customSql="SELECT e.`enroll_code`,e.`class_id`,s.`admission_no` FROM `enroll` AS e JOIN `student` AS s ON(e.student_id=s.student_id) WHERE s.email='".$a["email"]."'";
            $customRowEnrollCode=get_single_result($customSql);
            $studentEnroleCode=$customRowEnrollCode[0];
            //echo '<pre>';print_r($customRowEnrollCode);exit;
            
            $customSqlRunningYear="SELECT `description` FROM `settings` WHERE type='running_year'";
            $customRowRunningYear=get_single_result($customSqlRunningYear);
            $running_year_arr= explode('-',$customRowRunningYear[0]);
            $invoiceRunningYear= substr($running_year_arr[0],2).'-'.substr($running_year_arr[1],2);
            
            $cla_rec = ORM::for_table('class')->where('class_id',$customRowEnrollCode[1])->find_one();
            $className = $cla_rec?$cla_rec['name']:'';
            $admission_no = $studentEnroleCode;//$customRowEnrollCode[2];
            $print_type = 'Receipt';
            require 'sysfrm/lib/invoices/render_receipt.php';
        }
        break;
    case 'receipt-non-enroll':
        $d = ORM::for_table('sys_invoices1')->find_one($id);
        if($d['vtoken']!=$token){
            r2(U . 'non-enroll-receipt/view-list/', 'e', "Invalid index seleted to view the receipt.");
        }
        
        //find all activity for this user
        $items = ORM::for_table('sys_invoiceitems1')->where('invoiceid',$id)->order_by_asc('id')->find_many();
        //$trs_c = ORM::for_table('sys_transactions')->where('iid', $id)->count();
        //$trs = ORM::for_table('sys_transactions')->where('iid', $id)->order_by_desc('id')->find_many();
        //find the user
        $a = ORM::for_table('crm_accounts')->find_one($d['userid']);
        $i_credit = $d['credit'];
        $i_due = '0.00';
        $i_total = $d['total'];
        if($d['credit'] != '0.00'){
            $i_due = $i_total - $i_credit;
        }else{
            $i_due =  $d['total'];
        }
        $i_due = number_format($i_due,2,$config['dec_point'],$config['thousands_sep']);
        $cf = ORM::for_table('crm_customfields')->where('showinvoice','Yes')->order_by_asc('id')->find_many();
        $invoice_terms_data = ORM::for_table('sys_appconfig')->where('setting','invoice_terms')->find_one();
        $invoice_terms= strip_tags($invoice_terms_data->value);

        include_once 'sysfrm/school_data_connection.php';
        //die($db_host.' = '.$db_user.'  == '.$db_password.' == '.$db_name);
        // Create connection
        $customSql="SELECT e.`enroll_code` FROM `enroll` AS e JOIN `student` AS s ON(e.student_id=s.student_id) WHERE s.email='".$a["email"]."'";
        $customRowEnrollCode=get_single_result($customSql);
        $studentEnroleCode=$customRowEnrollCode[0];

        $customSqlRunningYear="SELECT `description` FROM `settings` WHERE type='running_year'";
        $customRowRunningYear=get_single_result($customSqlRunningYear);
        $running_year_arr= explode('-',$customRowRunningYear[0]);
        $invoiceRunningYear= substr($running_year_arr[0],2).'-'.substr($running_year_arr[1],2);
        
        $customSqlEngRegNo="SELECT `description` FROM `settings` WHERE type='school_registration_no_english'";
        $customRowEngRegNo=get_single_result($customSqlEngRegNo);
        
        $customSqlHindiRegNo="SELECT `description` FROM `settings` WHERE type='school_registration_no_hindi'";
        $customRowHindiRegNo=get_single_result($customSqlHindiRegNo);
        
        require 'sysfrm/lib/invoices/render_receipt_non_enroll.php';
        
        /*print_r($d);
        print_r($token);*/
        break;
    default :
        r2(U . 'customers/list', 'e', $_L['Account_Not_Found']);
}
