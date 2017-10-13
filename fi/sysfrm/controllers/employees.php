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

function decrypt_salary($string)
{
    $key = "chitgoks_hrms";
    $result = '';
    $string = base64_decode($string);

    for($i=0; $i<strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key))-1, 1);
        $char = chr(ord($char)-ord($keychar));
        $result.=$char;
    }

    return $result;
}

if(!isset($myCtrl)){
    $myCtrl = 'employees';
}
_auth();
$ui->assign('_sysfrm_menu', 'employees');
$ui->assign('_title', $_L['Employees'].' - '. $config['CompanyName']);
$ui->assign('_st', $_L['Employees']);
$ui->assign('content_inner',inner_contents($config['c_cache']));
$action = $routes['1'];
$school_id = isset($_SESSION['school_id'])?$_SESSION['school_id']:1;
$user = User::_info();
$ui->assign('user', $user);

$ui->assign('jsvar', '
_L[\'Working\'] = \''.$_L['Working'].'\';
_L[\'Submit\'] = \''.$_L['Submit'].'\';
 ');

// print_r($ui);die();
switch ($action) {
    case 'list':
        $role = _post('role');
        $month = _post('month')?_post('month'):date('m-Y');
        $ui->assign('role', $role);
        $ui->assign('month', $month);

        // find all employees
        //$es = O'RM::for_table('main_employees_summary')->order_by_asc('firstname')->find_array();
        $query = "SELECT ES.*,ESD.*, 
                    (SELECT is_paid FROM payroll_payslip WHERE emp_id=ES.user_id 
                     AND MONTH(PP.generate_date)='".date('m',strtotime('01-'.$month))."'
                     AND YEAR(PP.generate_date)='".date('Y',strtotime('01-'.$month))."' LIMIT 1) is_paid,
                    
                    (SELECT id FROM payroll_payslip WHERE emp_id=ES.user_id 
                     AND MONTH(PP.generate_date)='".date('m',strtotime('01-'.$month))."'
                     AND YEAR(PP.generate_date)='".date('Y',strtotime('01-'.$month))."' LIMIT 1) payslip_id

                  FROM main_employees_summary ES 
                  LEFT JOIN main_empsalarydetails AS ESD ON ESD.user_id =ES.user_id 
                  LEFT JOIN payroll_payslip AS PP ON PP.emp_id=ES.user_id
                  WHERE ES.school_id = '".$school_id."' AND 1=1 ".($role!=''?' AND ES.emprole='.$role:'')."
                  ORDER BY ES.firstname DESC";
                  //echo $query;exit;
        $es = ORM::for_table('sys_invoices')->raw_query($query)->find_many();
        //echo '<pre>';print_r($es);exit;
        $ui->assign('es',$es);


        $query = "SELECT MR.* FROM main_roles MR 
                  WHERE MR.isactive=1
                  ORDER BY rolename ASC";
        $mrols = ORM::for_table('sys_invoices')->raw_query($query)->find_many();
        $ui->assign('mrols',$mrols);

        $query = "SELECT * FROM sys_accounts where school_id = '".$school_id."' ORDER BY account ASC";
        $accts = ORM::for_table('sys_invoices')->raw_query($query)->find_many();
        $ui->assign('accts',$accts);

        $css_arr = array('s2/css/select2.min','bdp/css/bootstrap-datepicker.min','datatable/css/jquery.dataTables.min');
        $js_arr = array('s2/js/select2.min','s2/js/i18n/'.lan(),'bdp/js/bootstrap-datepicker.min',
            'datatable/js/jquery.dataTables.min');
        $ui->assign('xheader', Asset::css($css_arr));
        $ui->assign('xfooter', Asset::js($js_arr));
        $ui->assign('jsvar', '_L[\'are_you_sure\'] = \''.$_L['are_you_sure'].'\';');
        $ui->display('employees-list.tpl');
    break;

    case 'payslips':
        $ui->assign('_title', $_L['Payslips'].' - '. $config['CompanyName']);
        $ui->assign('_st', $_L['Payslips']);

        $role = _post('role');
        $month = _post('month')?_post('month'):date('m-Y');
        $ui->assign('role', $role);
        $ui->assign('month', $month);
        //echo  $role.'-'. $month;exit;

        $query = "SELECT ES.*,ESD.*,PP.id payslip_id,PP.generate_date,PP.net_pay FROM main_employees_summary ES 
                  LEFT JOIN main_empsalarydetails AS ESD ON ESD.user_id = ES.user_id 
                  LEFT JOIN payroll_payslip AS PP ON PP.emp_id=ES.user_id
                  WHERE ES.school_id = '".$school_id."' AND PP.id IS NOT NULL ".($role!=''?' AND ES.emprole='.$role:'')."
                  ".($month!=''?' AND MONTH(PP.generate_date)='.date('m',strtotime('01-'.$month)):'')."
                  ".($month!=''?' AND YEAR(PP.generate_date)='.date('Y',strtotime('01-'.$month)):'')."
                  ORDER BY ES.firstname DESC";
                  //echo $query;exit;
        $ps = ORM::for_table('sys_invoices')->raw_query($query)->find_many();
        $ui->assign('ps',$ps);
        
        $query = "SELECT MR.* FROM main_roles MR 
                  WHERE MR.isactive=1
                  ORDER BY rolename ASC";
        $mrols = ORM::for_table('sys_invoices')->raw_query($query)->find_many();
        $ui->assign('mrols',$mrols);

        $css_arr = array('s2/css/select2.min','bdp/css/bootstrap-datepicker.min','datatable/css/jquery.dataTables.min');
        $js_arr = array('s2/js/select2.min','s2/js/i18n/'.lan(),'bdp/js/bootstrap-datepicker.min',
            'datatable/js/jquery.dataTables.min');
        $ui->assign('xheader', Asset::css($css_arr));
        $ui->assign('xfooter', Asset::js($js_arr));
        $ui->assign('jsvar', '_L[\'are_you_sure\'] = \''.$_L['are_you_sure'].'\';');
        $ui->display('payslip-list.tpl');
    break;

    case 'payslip-view':
        $ui->assign('_title', $_L['View_payslip'].' - '. $config['CompanyName']);
        $ui->assign('_st', $_L['View_payslip']);
        $id  = $routes['2'];

        //$d = ORM::for_table('sys_invoices')->find_one($id);
        $query = "SELECT ES.*,ESD.*,PP.id payslip_id,PP.generate_date,PP.net_pay FROM main_employees_summary ES 
                  LEFT JOIN main_empsalarydetails AS ESD ON ESD.user_id = ES.user_id 
                  LEFT JOIN payroll_payslip AS PP ON PP.emp_id=ES.user_id
                  WHERE ES.school_id = '".$school_id."' AND PP.id IS NOT NULL AND PP.id = $id";
        $psrec = ORM::for_table('sys_invoices')->raw_query($query)->find_one();
        $ui->assign('psrec',$psrec);
        
        $query = "SELECT PPD.*,PC.name FROM payroll_payslip_details PPD 
                  LEFT JOIN payroll_category AS PC ON PC.payroll_category_id = PPD.payroll_category_id 
                  WHERE PPD.school_id = '".$school_id."' AND PC.type=0 AND PPD.payroll_payslip_id=".$psrec['payslip_id'];
        $earngs = ORM::for_table('sys_invoices')->raw_query($query)->find_many();
        $ui->assign('earngs',$earngs);
        
        $query = "SELECT PPD.*,PC.name FROM payroll_payslip_details PPD 
                  LEFT JOIN payroll_category AS PC ON PC.payroll_category_id = PPD.payroll_category_id 
                  WHERE PPD.school_id = '".$school_id."' AND PC.type=1 AND PPD.payroll_payslip_id=".$psrec['payslip_id'];
        $dedcs = ORM::for_table('sys_invoices')->raw_query($query)->find_many();
        $ui->assign('dedcs',$dedcs);
        
        $query = "SELECT EL.emp_leave_limit,EL.used_leaves,EL.alloted_year FROM main_employeeleaves EL 
                  WHERE EL.user_id ='".$psrec['user_id']."' AND EL.school_id = '".$school_id."'";
        $empleave = ORM::for_table('sys_invoices')->raw_query($query)->find_one();
        $ui->assign('empleave',$empleave);
        //echo '<pre>';print_r($empleave);exit;
        
        if($empleave['emp_leave_limit']>=$empleave['used_leaves']) { 
            $lop=0;
        }else{
            $lop=$empleave['used_leaves']-$empleave['emp_leave_limit'];
        }
        $ui->assign('lop_days',$lop);

        $salaryPerDay=number_format(decrypt_salary($psrec['salary'])/30,2);
        //echo $salaryPerDay;exit;
        $lop_amt = $salaryPerDay*$lop;
        $ui->assign('lop_amt',$lop_amt);
        
        $ui->assign('jsvar', '_L[\'are_you_sure\'] = \''.$_L['are_you_sure'].'\';');
        $ui->display('payslip-view.tpl');
    break;
        
    case 'paynow':
            $payslip_id = _post('payslip_id');
            $account_id = _post('acc_id');

            $a = ORM::for_table('sys_accounts')->where('account',$account_id)->find_one();
            $cbal = $a['balance'];

            $query = "SELECT ES.*,ESD.*,PP.id payslip_id,PP.generate_date,PP.net_pay FROM main_employees_summary ES 
                        LEFT JOIN main_empsalarydetails AS ESD ON ESD.user_id = ES.user_id 
                        LEFT JOIN payroll_payslip AS PP ON PP.emp_id=ES.user_id
                        WHERE ES.school_id = '".$school_id."' AND PP.id IS NOT NULL AND PP.id = $payslip_id";
            $psrec = ORM::for_table('sys_invoices')->raw_query($query)->find_one();
            $amount = $psrec['net_pay']; 
            $nbal = $cbal-$amount;
            $a->balance = $nbal;
            $a->save();

            $d = ORM::for_table('sys_transactions')->create();
            $d->account = $account_id;
            $d->type = 'Expense';
            $d->payeeid =  $psrec['user_id'];
            $d->payee_balance = $amount;//(-1 * abs($amount));
            $d->tags =  'Payslip';
            $d->amount = $amount;
            $d->category = 'Payslip';
            $d->method = 'Payslip';
            $d->ref = $payslip_id;

            $d->description = 'Payslip on '.$payslip_id;
            $d->date = $psrec['generate_date'];
            $d->dr = $amount;
            $d->cr = '0.00';
            $d->bal = $nbal;
            //others
            $d->payer = '';
            $d->payee = '';
            $d->payerid = '0';
            $d->status = 'Cleared';
            $d->tax = '0.00';
            $d->iid = 0;
            $d->user_type = 'employee';
            $d->save();

            //Update Payslip
            $sql = "UPDATE payroll_payslip SET is_paid='1' WHERE id='$payslip_id'";
            ORM::execute($sql);
            echo 'success';exit;
    break;
    default:
        echo 'action not defined';
}