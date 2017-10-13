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
_auth();
$ui->assign('_sysfrm_menu', 'invoices');
$ui->assign('_st', $_L['Invoices']);
$ui->assign('_title', $_L['Sales'].'- ' . $config['CompanyName']);
$action = $routes['1'];
$user = User::_info();
$ui->assign('user', $user);

function return_recno($inid)
{
    //echo $run_year;exit;ten_year);
    //$invoiceRunningYear= substr($running_year_arr[0],2).'-'.substr($running_year_arr[1],2);
    return date('y').'-'.date('y',strtotime('+1 year')).'/'.$inid;
}

Event::trigger('invoices');

switch ($action) {
    case 'add':
        //find all clients.
        Event::trigger('invoices/add/');
        $extra_fields = '';
        $extra_jq = '';
        Event::trigger('add_invoice');
        $ui->assign('extra_fields', $extra_fields);

        if (isset($routes['2']) AND ($routes['2'] == 'recurring')) {
            $recurring = true;
        } else {
            $recurring = false;
        }
        $ui->assign('recurring', $recurring);

        if (isset($routes['3']) AND ($routes['3'] != '')) {
            $p_cid = $routes['3'];
            $p_d = ORM::for_table('crm_accounts')->find_one($p_cid);
            if ($p_d) {
                $ui->assign('p_cid', $p_cid);
            }
        } else {
            $ui->assign('p_cid', '');
        }

        $ui->assign('_st', 'Create Invoice' );
        $c = ORM::for_table('crm_accounts')->select('id')->select('account')->select('company')->select('email')->where('school_id', $_SESSION['school_id'])->order_by_desc('id')->find_many();
        $ui->assign('c', $c);

        $t = ORM::for_table('sys_tax')->where('school_id', $_SESSION['school_id'])->find_many();
        $ui->assign('t', $t);

        $ui->assign('idate', date('Y-m-d'));
        $accounts = ORM::for_table('sys_accounts')->where('school_id', $_SESSION['school_id'])->find_many();
        $ui->assign('accounts', $accounts);
        $groups = ORM::for_table('crm_groups')->select('id')->select('gname')->where('school_id', $_SESSION['school_id'])->order_by_asc('group_id')->find_many();
        $ui->assign('groups', $groups);
        
        if($config['i_driver'] == 'default'){
            $js_file = 'invoice';
            $tpl_file = 'add-invoice.tpl';
        }
        elseif($config['i_driver'] == 'v2'){
            $js_file = 'invoice_add_v2';
            $tpl_file = 'add_invoice_v2.tpl';
        }
        else{
            $js_file = 'invoice';
            $tpl_file = 'add-invoice.tpl';
        }
        
        $css_arr = array('s2/css/select2.min','modal','dp/dist/datepicker.min','redactor/redactor');
        $js_arr = array('redactor/redactor.min','s2/js/select2.min','s2/js/i18n/'.lan(),'dp/dist/datepicker.min','dp/i18n/'.$config['language'],'numeric','modal',$js_file);

        Event::trigger('add_invoice_rendering_form');

        $ui->assign('xheader', Asset::css($css_arr));
        $ui->assign('xfooter', Asset::js($js_arr));

        $ui->assign('xjq', '

 $(\'.amount\').autoNumeric(\'init\', {

    aSign: \''.$config['currency_code'].' \',
    dGroup: '.$config['thousand_separator_placement'].',
    aPad: '.$config['currency_decimal_digits'].',
    pSign: \''.$config['currency_symbol_position'].'\',
    aDec: \''.$config['dec_point'].'\',
    aSep: \''.$config['thousands_sep'].'\'

    });


 '.$extra_jq);

        $ui->display($tpl_file);
        break;


    case 'edit':

        Event::trigger('invoices/edit/');

        $id = $routes['2'];
        $d = ORM::for_table('sys_invoices')->where('school_id', $_SESSION['school_id'])->find_one($id);
        if ($d) {

            $ui->assign('i', $d);
            $items = ORM::for_table('sys_invoiceitems')->where('school_id', $_SESSION['school_id'])->where('invoiceid', $id)->order_by_asc('id')->find_many();
            $ui->assign('items', $items);
            //check paid or not
            $invoicepaid    =   ORM::for_table('sys_transactions')->where('school_id', $_SESSION['school_id'])->where('iid', $id)->find_many();
            if(!count($invoicepaid)>=1) { 
                        //find the transactions,account of invoice
                        $trans = ORM::for_table('sys_transactions')->where('school_id', $_SESSION['school_id'])->where('ref', $id)->find_many();
                        $ui->assign('trans',$trans);
                        
                        $accounts = ORM::for_table('sys_accounts')->where('school_id', $_SESSION['school_id'])->find_many();
                        $ui->assign('accounts', $accounts);
                        
                        //find the user
                        $a = ORM::for_table('crm_accounts')->where('school_id', $_SESSION['school_id'])->find_one($d['userid']);
                        $ui->assign('a', $a);
                        $ui->assign('d', $d);
                        $ui->assign('_st', $_L['Add Invoice']);
                        $c = ORM::for_table('crm_accounts')->select('id')->select('account')->select('company')->where('school_id', $_SESSION['school_id'])->find_many();
                        $ui->assign('c', $c);

                        $t = ORM::for_table('sys_tax')->where('school_id', $_SESSION['school_id'])->find_many();
                        $ui->assign('t', $t);

                        $groups = ORM::for_table('crm_groups')->select('id')->select('gname')->where('school_id', $_SESSION['school_id'])->order_by_desc('id')->find_many();
                        $ui->assign('groups', $groups);
                        //default idate ddate
                        $ui->assign('idate', date('Y-m-d'));

                        if($config['i_driver'] == 'default'){
                            $js_file = 'edit-invoice-v2';
                            $tpl_file = 'edit-invoice.tpl';
                        }
                        elseif($config['i_driver'] == 'v2'){
                            $js_file = 'edit_invoice_v2n';
                            $tpl_file = 'edit_invoice_v2.tpl';
                        }
                        else{
                            $js_file = 'edit-invoice-v2';
                            $tpl_file = 'edit-invoice.tpl';
                        }

                        $ui->assign('xheader', Asset::css(array('s2/css/select2.min','modal','dp/dist/datepicker.min','redactor/redactor')));
                        $ui->assign('xfooter', Asset::js(array('redactor/redactor.min','s2/js/select2.min','s2/js/i18n/'.lan(),'dp/dist/datepicker.min','dp/i18n/'.$config['language'],'numeric','modal',$js_file)));

                        $ui->assign('xjq', '

             $(\'.amount\').autoNumeric(\'init\', {

                aSign: \''.$config['currency_code'].' \',
                dGroup: '.$config['thousand_separator_placement'].',
                aPad: '.$config['currency_decimal_digits'].',
                pSign: \''.$config['currency_symbol_position'].'\',
                aDec: \''.$config['dec_point'].'\',
                aSep: \''.$config['thousands_sep'].'\'

                });

             ');

                        $ui->display($tpl_file);
            } else {
                echo 'Can not edit paid invoice';
            }    
        } else {
            echo 'Invoice Not Found';
        }
//find all clients.


        break;


    case 'view':

        Event::trigger('invoices/view/');
        $id = $routes['2'];
        $d = ORM::for_table('sys_invoices')->where('school_id', $_SESSION['school_id'])->find_one($id);
        if ($d) {

            //find all activity for this user
            $items = ORM::for_table('sys_invoiceitems')->where('invoiceid', $id)->where('school_id', $_SESSION['school_id'])->order_by_asc('id')->find_many();
            $ui->assign('items', $items);
            //find related transactions
            $trs_c = ORM::for_table('sys_transactions')->where('iid', $id)->where('school_id', $_SESSION['school_id'])->count();
            $trs = ORM::for_table('sys_transactions')->where('iid', $id)->where('school_id', $_SESSION['school_id'])->order_by_desc('id')->find_many();


            $ui->assign('trs', $trs);
            $ui->assign('trs_c', $trs_c);
            $emls_c = ORM::for_table('sys_email_logs')->where('iid', $id)->where('school_id', $_SESSION['school_id'])->count();
            $emls = ORM::for_table('sys_email_logs')->where('iid', $id)->where('school_id', $_SESSION['school_id'])->order_by_desc('id')->find_many();


            $ui->assign('emls', $emls);
            $ui->assign('emls_c', $emls_c);
            //find the user
            $a = ORM::for_table('crm_accounts')->where('school_id', $_SESSION['school_id'])->find_one($d['userid']);
            $ui->assign('a', $a);
            $ui->assign('d', $d);

            $i_credit = $d['credit'];
            $i_due = '0.00';
            $i_total = $d['total'];
            if($d['credit'] != '0.00'){
                $i_due = $i_total - $i_credit;
            }else{
                $i_due =  $d['total'];
            }

            $i_due = number_format($i_due,2,$config['dec_point'],$config['thousands_sep']);
            $ui->assign('i_due', $i_due);


            //find all custom fields

            $cf = ORM::for_table('crm_customfields')->where('showinvoice','Yes')->where('school_id', $_SESSION['school_id'])->order_by_asc('id')->find_many();
            $ui->assign('cf',$cf);

            //            $ui->assign('xheader', '
            //            <link rel="stylesheet" type="text/css" href="' . $_theme . '/lib/select2/select2.css"/>
            //<link rel="stylesheet" type="text/css" href="' . $_theme . '/lib/dp/dist/datepicker.min.css"/>
            //
            //<link rel="stylesheet" type="text/css" href="ui/lib/sn/summernote.css"/>
            //<link rel="stylesheet" type="text/css" href="ui/lib/sn/summernote-bs3.css"/>
            //<link rel="stylesheet" type="text/css" href="' . $_theme . '/css/modal.css"/>
            //<link rel="stylesheet" type="text/css" href="ui/lib/sn/summernote-sysfrm.css"/>
            //');

            $ui->assign('xheader', Asset::css(array('s2/css/select2.min','dp/dist/datepicker.min','sn/summernote','sn/summernote-bs3','modal','sn/summernote-sysfrm')));

            //            $ui->assign('xfooter', '
            //            <script type="text/javascript" src="' . $_theme . '/lib/select2/select2.min.js"></script>
            //<script type="text/javascript" src="' . $_theme . '/lib/dp/dist/datepicker.min.js"></script>
            //<script type="text/javascript" src="' . $_theme . '/lib/numeric.js"></script>
            // <script type="text/javascript" src="' . $_theme . '/lib/modal.js"></script>
            // <script type="text/javascript" src="ui/lib/sn/summernote.min.js"></script>
            //<script type="text/javascript" src="ui/lib/jslib/invoice-view.js"></script>
            //');

            $ui->assign('xfooter', Asset::js(array('s2/js/select2.min','s2/js/i18n/'.lan(),'dp/dist/datepicker.min','dp/i18n/'.$config['language'],'numeric','modal','sn/summernote.min','jslib/invoice-view')));
            $x_html = '';

            Event::trigger('view_invoice');
            $ui->assign('x_html',$x_html);

            $ui->assign('xjq',' /*$(\'.admount\').autoNumeric(\'init\', {
                                aSign: \''.$config['currency_code'].' \',
                                dGroup: '.$config['thousand_separator_placement'].',
                                aPad: '.$config['currency_decimal_digits'].',
                                pSign: \''.$config['currency_symbol_position'].'\',
                                aDec: \''.$config['dec_point'].'\',
                                aSep: \''.$config['thousands_sep'].'\'
                                });*/

                                $(\'.amount\').curren({symbol:\''.$config['currency_code'].'\'});
             ');

            $ui->display('invoice-view.tpl');
            

        } else {
            r2(U . 'customers/list', 'e', $_L['Account_Not_Found']);
        }

        break;

    case 'add-post':
        Event::trigger('invoices/add-post/');
    
        $create_mode        =       _post('create_mode');
        $msg                =       '';
        if($create_mode == 'multiple') {
            $group_id           =       _post('group_id');
            $section_id         =       _post('section_id');
            if ($group_id == '') {
                $msg .= 'Select a group <br> ';
            }
            
            if($section_id != '')
                $student_group      =       ORM::for_table('crm_accounts')->where('school_id', $_SESSION['school_id'])->where( 'section_id' , $section_id )->find_many();
            else 
                $student_group      =       ORM::for_table('crm_accounts')->where('school_id', $_SESSION['school_id'])->where( 'gid' , $group_id )->find_many();
           
        } else {
            $cid                =       _post('cid');
            //find user with cid
            $u                  =       ORM::for_table('crm_accounts')->where('school_id', $_SESSION['school_id'])->find_one($cid);
            $student_account    =       $u['account'];
            
            if ($cid == '') {
                $msg .= 'Select a Student <br> ';
            }
        }
        
        $hostel_fee     =   _post('hostel_fee');
        $transport_fee  =   _post('transport_fee');
        $account        =   _post('account');
        $school_id        =  $_SESSION['school_id']; 
        if($account == '')  {
            $msg .= 'Select Account <br> ';
        }
        $notes = '';//_post('notes');

        if (isset($_POST['amount'])) {
            $amount = $_POST['amount'];
        } else {
            $msg .= $_L['at_least_one_item_required'].' <br> ';
        }
        $idate = _post('idate');
        $its = strtotime($idate);
        $duedate = _post('duedate');
        $dd = '';
        if ($duedate == 'due_on_receipt') {
            $dd = $idate;
        } elseif ($duedate == 'days3') {
            $dd = date('Y-m-d', strtotime('+3 days', $its));
        } elseif ($duedate == 'days5') {
            $dd = date('Y-m-d', strtotime('+5 days', $its));
        } elseif ($duedate == 'days7') {
            $dd = date('Y-m-d', strtotime('+7 days', $its));
        } elseif ($duedate == 'days10') {
            $dd = date('Y-m-d', strtotime('+10 days', $its));
        } elseif ($duedate == 'days15') {
            $dd = date('Y-m-d', strtotime('+15 days', $its));
        } elseif ($duedate == 'days30') {
            $dd = date('Y-m-d', strtotime('+30 days', $its));
        } elseif ($duedate == 'days45') {
            $dd = date('Y-m-d', strtotime('+45 days', $its));
        } elseif ($duedate == 'days60') {
            $dd = date('Y-m-d', strtotime('+60 days', $its));
        } else {
            $msg .= 'Invalid Date <br> ';
        }
        if (!$dd) {
            $msg .= 'Date Parsing Error <br> ';
        }

        $repeat = _post('repeat');
        $nd = $idate;
        if ($repeat == '0' || $repeat=="") {
            $r = '0';
        } elseif ($repeat == 'week1') {
            $r = '+1 week';
            $nd = date('Y-m-d', strtotime('+1 week', $its));
        } elseif ($repeat == 'weeks2') {
            $r = '+2 weeks';
            $nd = date('Y-m-d', strtotime('+2 weeks', $its));
        } elseif ($repeat == 'month1') {
            $r = '+1 month';
            $nd = date('Y-m-d', strtotime('+1 month', $its));
        } elseif ($repeat == 'months2') {
            $r = '+2 months';
            $nd = date('Y-m-d', strtotime('+2 months', $its));
        } elseif ($repeat == 'months3') {
            $r = '+3 months';
            $nd = date('Y-m-d', strtotime('+3 months', $its));
        } elseif ($repeat == 'months6') {
            $r = '+6 months';
            $nd = date('Y-m-d', strtotime('+6 months', $its));
        } elseif ($repeat == 'year1') {
            $r = '+1 year';
            $nd = date('Y-m-d', strtotime('+1 year', $its));
        } elseif ($repeat == 'years2') {
            $r = '+2 years';
            $nd = date('Y-m-d', strtotime('+2 years', $its));
        } elseif ($repeat == 'years3') {
            $r = '+3 years';
            $nd = date('Y-m-d', strtotime('+3 years', $its));
        } else {
            $msg .= 'Date Parsing Error <br> ';
        }
        if ($msg == '') {
            $taxed = false;
            /*if(isset($_POST['taxed'])){
                $taxed = $_POST['taxed'];
            }
            else{
                $taxed = false;
            }*/

            $sTotal = '0';
            $taxTotal = '0';
            $i = '0';
            $am = array();

            $taxval = '0.00';
            $taxname = '';
            $taxrate = '0.00';
            $tax = "";//_post('tid');
            $taxed_type = _post('taxed_type');
            if ($tax != '') {
                $dt = ORM::for_table('sys_tax')->where('school_id', $_SESSION['school_id'])->find_one($tax);
                $taxrate = $dt['rate'];
                $taxname = $dt['name'];
                $taxtype = $dt['type'];
            }

            $taxed_amount = 0.00;
            $lamount = 0.00;

            foreach ($amount as $samount) {
                $samount = Finance::amount_fix($samount);
                $am[$i] = $samount;
                /* @since v 2.0 */
                $sqty = 1;// $qty[$i];

               // $sqty = Finance::amount_fix($sqty);
//                if (($config['dec_point']) == ',') {
//                    $samount = str_replace(',', '.', $samount);
//                    $sqty = str_replace(',', '.', $sqty);
//
//                }

                $sTotal += $samount * ($sqty);
                $lamount = $samount * ($sqty);

                if($taxed){
                    $c_tax = $taxed[$i];
                }
                else{
                    $c_tax = 'No';
                }

                if($c_tax == 'Yes'){
                   // $a_tax = ($samount * $taxrate) / 100;
                    $taxed_amount += $lamount;
                }
                else{
                    $a_tax = 0.00;
                }
                //$taxval += $a_tax;
                $i++;
            }
            //print_r($sTotal);
           // die("Total");

            $invoicenum = _post('invoicenum');
            $cn = _post('cn');
            $fTotal = $sTotal;
            // calculate discount

            $discount_amount = _post('discount_amount');
            $discount_type = 'f';//_post('discount_type');
            $discount_value = '0.00';

            if($discount_amount == '0' OR $discount_amount == ''){
                $actual_discount = '0.00';
            }else{
                if($discount_type == 'f'){
                    $actual_discount = $discount_amount;
                    $discount_value = $discount_amount;
                }else{
                    $discount_type = 'p';
                    $actual_discount = ($sTotal * $discount_amount) / 100;
                    $discount_value = $discount_amount;
                }
            }
            //die('$discount_type : '.$discount_type.' == $actual_discount : '.$actual_discount.' == $discount_value : '.$discount_value);
            $actual_discount = number_format((float)$actual_discount, 2, '.', '');

            $fTotal = $fTotal - $actual_discount;
            $actual_taxed_amount = $taxed_amount - $actual_discount;

            if($actual_taxed_amount > 0){
                $taxval = ($actual_taxed_amount * $taxrate) / 100;
            }

            if (($taxed_type != 'individual') AND ($tax != '')) {
                $taxval = ($fTotal * $taxrate) / 100;
            }
            $fTotal = $fTotal + $taxval;
            //die('$taxval : '.$taxval.' == $fTotal : '.$fTotal);
            //
            $datetime = date("Y-m-d H:i:s");

            $vtoken = _raid(10);
            $ptoken = _raid(10);
            $description    =   $_POST['desc'];
            $item_code      =   $_POST['item_code'];
        if($create_mode == 'multiple') {
            foreach( $student_group as $student ) {
                $cid                    =   $student->id;
                $student_account        =   $student->account;
                $d                      =   ORM::for_table('sys_invoices')->create();
                $d->userid              =   $cid;
                $d->account             =   $student_account;
                $d->date = $idate;
                $d->duedate = $dd;
                $d->datepaid = $datetime;
                $d->subtotal = $sTotal;
                $d->discount_type = $discount_type;
                $d->discount_value = $discount_value;
                $d->discount = $actual_discount;
                $d->total = $fTotal;
                $d->bank_acc_id    =   $account;
                $d->tax = $taxval;
                $d->taxname = $taxname;
                $d->taxrate = $taxrate;
                $d->vtoken = $vtoken;
                $d->ptoken = $ptoken;
                $d->status = 'Unpaid';
                $d->notes = $notes;
                $d->r = $r;
                $d->nd = $nd;
                $d->school_id = $_SESSION['school_id'];
                //others
                $d->invoicenum = $invoicenum;
                $d->cn = $cn;
                $d->tax2 = '0.00';
                $d->taxrate2 = '0.00';
                $d->paymentmethod = '';
                $d->school_id = $_SESSION['school_id'];
                //echo '<pre>';print_r($d);die;
                $d->save();
                $invoiceid = $d->id(); 

                //////////////////////////////* create expense while add invoice starts here*////////////////////////////

                //find the current balance for this account
                $a = ORM::for_table('sys_accounts')->where('account',$account)->where('school_id', $_SESSION['school_id'])->find_one();
                $cbal = $a['balance'];
                $amount = $fTotal; 
                $nbal = $cbal-$amount;
    //            $a->balance = $nbal;
    //            $a->save();

                $b1 = ORM::for_table('sys_transactions')->where('payeeid',$cid)->where('school_id', $_SESSION['school_id'])->find_many();
                $b2 = ORM::for_table('sys_transactions')->where('payerid',$cid)->where('school_id', $_SESSION['school_id'])->find_many();
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
                    //$payee_trans1    =   $trans['id'];
                }

                if(!empty($b2[0])) {
                    foreach($b2 as $trans) {
                        $payee_bal2      =   $trans['payee_balance'] - $amount;
                        $payee_trans2    =   $trans['id'];
                    }
                } else {
                    $payee_bal2      =   0-$amount;
//                    $payee_trans2    =   $trans['id'];
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

                $d = ORM::for_table('sys_transactions')->create();
                $d->account = $account;
                $d->type = 'Expense';
                $d->payeeid =  $cid;
                $d->payee_balance = $payee_bal;
                $d->tags =  'Invoice';
                $d->amount = $amount;
                $d->category = 'Invoice';
                $d->method = 'StudInvoice';
                $d->ref = $invoiceid;

                $d->description = 'invoice on '.$invoiceid;
                $d->date = $idate;
                $d->dr = $amount;
                $d->cr = '0.00';
                $d->bal = $nbal;
                //others
                $d->payer = '';
                $d->payee = '';
                $d->payerid = '0';
                $d->status = 'Cleared';
                $d->tax = '0.00';
                $d->iid = $invoiceid;
                $d->school_id = $_SESSION['school_id'];
                $d->save();
                $tid = $d->id();

                /////////////////////* create expense ends here *//////////////////
                //  $qty = $_POST['qty'];
                //  $taxed = $_POST['taxed'];
                $i = '0';
                $stud_det                   =   ORM::for_table('crm_accounts')->where('school_id', $_SESSION['school_id'])->find_one($cid);


                if($hostel_fee) {
                    if($stud_det['dormitory_fee_id']!=0) {
                        $dormitory_fee_id       =   $stud_det['dormitory_fee_id'];
                        $fee_det                =   ORM::for_table('sys_items')->where('id',$dormitory_fee_id)->where('school_id', $_SESSION['school_id'])->find_one();

                        $student_hostel_fee                 =   $fee_det['sales_price'];
                        $hostel_fee_discription             =   $fee_det['description'];
                        $item_code                          =   $fee_det['item_number'];

                        $description['hostel_fee']          =   $hostel_fee_discription; // description of hostel fee
                        $am['hostel_fee']                   =   $student_hostel_fee; // item price from hostel fee
                        $item_code['hostel_fee']            =   $item_code; // item code of fee item
                    }
                }
                //                    else {
                //                        $description['hostel_fee']          =   ''; // description of hostel fee
                //                        $am['hostel_fee']                   =   ''; // item price from hostel fee
                //                        $item_code['hostel_fee']            =   ''; // item code of fee item
                //
                //                    }
                if($transport_fee) {
                    if($stud_det['trans_fee_id']!=0) {
                        $trans_fee_id           =   $stud_det['trans_fee_id'];
                        $fee_det                =   ORM::for_table('sys_items')->where('school_id', $_SESSION['school_id'])->where('id',$trans_fee_id)->find_one();

                        $student_transport_fee                  =   $fee_det['sales_price'];
                        $transport_fee_discription              =   $fee_det['description'];
                        $item_code                              =   $fee_det['item_number'];

                        $description['transp_fee']          =   $transport_fee_discription; // description of transport fee
                        $am['trnasp_fee']                   =   $student_transport_fee; // item price from hostel fee
                        $item_code['trnasp_fee']            =   $item_code; // item code of fee item
                    }
                }
                //                    else {
                //                        $description['transp_fee']          =   ''; // description of transport fee
                //                        $am['trnasp_fee']                   =   ''; // item price from hostel fee
                //                        $item_code['trnasp_fee']            =   ''; // item code of fee item
                //                    }
                foreach ($description as $key=>$item) {
                        if($key === 'transp_fee') {
                            $samount    =   $am['transp_fee'];
                            $icode      =   $item_code['transp_fee'];
                        } else if($key === 'hostel_fee') {
                            $samount    =   $am['hostel_fee'];
                            $icode      =   $item_code['hostel_fee'];
                        } else {
                            $samount    =   $am[$key];
                            $icode      =   $item_code[$key];
                        }

                        /* @since v 2.0 */
                        $sqty = 1;//$qty[$i];
                        //$sqty = Finance::amount_fix($sqty);
                        $samount = Finance::amount_fix($samount);
                        //                exit;
                        //                if (($config['dec_point']) == ',') {
                        //                    $samount = str_replace(',', '.', $samount);
                        //                    $sqty = str_replace(',', '.', $sqty);
                        //
                        //                }
                        $ltotal = ($samount) * ($sqty);
                        $d = ORM::for_table('sys_invoiceitems')->create();
                        $d->invoiceid = $invoiceid;
                        $d->userid = $cid;
                        $d->description = $item;
                        $d->qty = $sqty;
                        $d->amount = $samount;
                        $d->total = $ltotal;
                        $d->school_id = $_SESSION['school_id'];    


                        if($taxed){
                            if (($taxed[$key]) == 'Yes') {
                                $d->taxed = '1';
                            } else {
                                $d->taxed = '0';
                            }
                        }else{
                            $d->taxed = '0';
                        }

                        //others
                        $d->type = '';
                        $d->relid = '0';
                        $d->itemcode = $icode;
                        $d->taxamount = '0.00';
                        $d->duedate = date('Y-m-d');
                        $d->paymentmethod = '';
                        $d->notes = '';
                        $d->school_id = $_SESSION['school_id'] ;
                        $d->save();
                }
            }
        } else {

            $stud_det                   =   ORM::for_table('crm_accounts')->where('school_id', $_SESSION['school_id'])->find_one($cid);
            if($hostel_fee) {
                if($stud_det['dormitory_fee_id']!=0) {
                    $dormitory_fee_id       =   $stud_det['dormitory_fee_id'];
                    $fee_det                =   ORM::for_table('sys_items')->where('id',$dormitory_fee_id)->where('school_id', $_SESSION['school_id'])->find_one();
                    $student_hostel_fee     =   $fee_det['sales_price'];
                    $sTotal                 =   $sTotal+$student_hostel_fee;
                }
            }
            if($transport_fee) {
                if($stud_det['trans_fee_id']!=0){
                    $trans_fee_det          =   ORM::for_table('sys_items')->where('id',$stud_det['trans_fee_id'])->where('school_id', $_SESSION['school_id'])->find_one();
                    $trans_fee_id           =   
                    $student_transp_fee     =   $trans_fee_det['sales_price'];
                    $sTotal                 =   $sTotal+$student_transp_fee;
                }
            }
            $d = ORM::for_table('sys_invoices')->create();
            $d->userid = $cid;
            $d->account = $student_account;
            $d->date = $idate;
            $d->duedate = $dd;
            $d->datepaid = $datetime;
            $d->subtotal = $sTotal;
            $d->discount_type = $discount_type;
            $d->discount_value = $discount_value;
            $d->discount = $actual_discount;
            $d->total = $fTotal;
            $d->bank_acc_id    =   $account;
            $d->tax = $taxval;
            $d->taxname = $taxname;
            $d->taxrate = $taxrate;
            $d->vtoken = $vtoken;
            $d->ptoken = $ptoken;
            $d->status = 'Unpaid';
            $d->notes = $notes;
            $d->r = $r;
            $d->nd = $nd;
            //others
            $d->invoicenum = $invoicenum;
            $d->cn = $cn;
            $d->tax2 = '0.00';
            $d->taxrate2 = '0.00';
            $d->paymentmethod = '';
            $d->school_id = $_SESSION['school_id'];
            //echo '<pre> else part <br>';print_r($d);die;
            $d->save();
            $invoiceid = $d->id(); 
            //////////////////////////////* create expense while add invoice starts here*////////////////////////////

            //find the current balance for this account
            $a = ORM::for_table('sys_accounts')->where('account',$account)->where('school_id', $_SESSION['school_id'])->find_one();
            $cbal = $a['balance'];
            $amount = $fTotal; 
            $nbal = $cbal-$amount;
//            $a->balance = $nbal;
//            $a->save();
            
            $b1 = ORM::for_table('sys_transactions')->where('payeeid',$cid)->where('school_id', $_SESSION['school_id'])->find_many();
            $b2 = ORM::for_table('sys_transactions')->where('payerid',$cid)->where('school_id', $_SESSION['school_id'])->find_many();
            if(!empty($b1[0])) {
                foreach($b1 as $trans) {
                    $payee_bal1      =   $trans['payee_balance'] - $amount;
                    $payee_trans1    =   $trans['id'];
                }
            } else {
                $payee_bal1      =   0-$amount;
//                $payee_trans1    =   $trans['id'];
            }

            if(!empty($b2[0])) {
                foreach($b2 as $trans) {
                    $payee_bal2      =   $trans['payee_balance'] - $amount;
                    $payee_trans2    =   $trans['id'];
                }
            } else {
                $payee_bal2      =   0-$amount;
//                $payee_trans2    =   $trans['id'];
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
                
            $d = ORM::for_table('sys_transactions')->create();
            $d->account = $account;
            $d->type = 'Expense';
            $d->payeeid =  $cid;
            $d->payee_balance = $payee_bal;
            $d->tags =  'Invoice';
            $d->amount = $amount;
            $d->category = 'Invoice';
            $d->method = 'StudInvoice';
            $d->ref = $invoiceid;
            $d->school_id = $_SESSION['school_id'];
            $d->description = 'invoice on '.$invoiceid;
            $d->date = $idate;
            $d->dr = $amount;
            $d->cr = '0.00';
            $d->bal = $nbal;
            //others
            $d->payer = '';
            $d->payee = '';
            $d->payerid = '0';
            $d->status = 'Cleared';
            $d->tax = '0.00';
            $d->iid = $invoiceid;
            $d->school_id = $_SESSION['school_id'];
            //echo '<pre>';print_r($d);die;
            $d->save();
            $tid = $d->id();

            /////////////////////* create expense ends here *//////////////////
            //  $qty = $_POST['qty'];
            //  $taxed = $_POST['taxed'];
            $i = '0';
            $count                          =   count($description);
            $stud_det                   =   ORM::for_table('crm_accounts')->where('school_id', $_SESSION['school_id'])->find_one($cid);
            if($hostel_fee) {
                if($stud_det['dormitory_fee_id']!=0) {
                    $dormitory_fee_id       =   $stud_det['dormitory_fee_id'];
                    $fee_det                =   ORM::for_table('sys_items')->where('id',$dormitory_fee_id)->where('school_id', $_SESSION['school_id'])->find_one();
                    
                    $student_hostel_fee                 =   $fee_det['sales_price'];
                    $hostel_fee_discription             =   $fee_det['description'];
                    $item_code                          =   $fee_det['item_number'];
                    
                    $count1                          =   $count+1;
                    $description[$count1]            =   $hostel_fee_discription; // description of hostel fee
                    $am[$count1]                     =   $student_hostel_fee; // item price from hostel fee
                    $item_code[$count1]              =   $item_code; // item code of fee item
                }
            }                    

            if($transport_fee) {
                if($count1)
                    $count2                             =   $count1+1;
                else
                    $count2                             =   $count+1;
                if($stud_det['trans_fee_id']!=0){
                    $trans_fee_id                           =   $stud_det['trans_fee_id'];
                    $fee_det                =   ORM::for_table('sys_items')->where('id',$trans_fee_id)->where('school_id', $_SESSION['school_id'])->find_one();

                    $student_trans_fee                  =   $fee_det['sales_price'];
                    $transport_fee_discription          =   $fee_det['description'];
                    $item_code                          =   $fee_det['item_number'];

                    $description[$count2]          =   $transport_fee_discription; // description of transport fee
                    $am[$count2]                   =   $student_trans_fee; // item price from hostel fee
                    $item_code[$count2]            =   $item_code; // item code of fee item
                }
            }
            foreach ($description as $item) {
                $samount = $am[$i];
                /* @since v 2.0 */
                $sqty = 1;//$qty[$i];
                //$sqty = Finance::amount_fix($sqty);
                $samount = Finance::amount_fix($samount);
                //                echo $samount;
                //                echo 'dd';
                //                exit;
                //                if (($config['dec_point']) == ',') {
                //                    $samount = str_replace(',', '.', $samount);
                //                    $sqty = str_replace(',', '.', $sqty);
                //
                //                }
                $ltotal = ($samount) * ($sqty);
                $d = ORM::for_table('sys_invoiceitems')->create();
                $d->invoiceid = $invoiceid;
                $d->userid = $cid;
                $d->description = $item;
                $d->qty = $sqty;
                $d->amount = $samount;
                $d->total = $ltotal;
                $d->school_id = $_SESSION['school_id'];
                if($taxed){
                    if (($taxed[$i]) == 'Yes') {
                        $d->taxed = '1';
                    } else {
                        $d->taxed = '0';
                    }
                }
                else{
                    $d->taxed = '0';
                }
                //others
                $d->type = '';
                $d->relid = '0';
                $d->itemcode = $item_code[$i];
                $d->taxamount = '0.00';
                $d->duedate = date('Y-m-d');
                $d->paymentmethod = '';
                $d->notes = '';
                $d->school_id = $_SESSION['school_id'];
                $d->save();
                $i++;
            }
            Event::trigger('add_invoice_posted');
            
        }
        echo $invoiceid;

        } else {
            echo $msg;
        }


        break;

    case 'list':

        Event::trigger('invoices/list/');
        $paginator                  =   array();
        $mode_css                   =   '';
        $mode_js                    =   '';
        $view_type                  =   'default';
        $to_date                    =   date('Y-m-d');
        if(route(2) == 'filter'){

            $view_type = 'filter';

            $mode_css = Asset::css('datatable/css/jquery.dataTables.min');

            $mode_js = Asset::js(array('numeric','footable/js/footable.all.min','contacts/mode_search','datatable/js/jquery.dataTables.min'));

            $total_invoice = ORM::for_table('sys_invoices')->where('school_id', $_SESSION['school_id'])->count();

            $ui->assign('total_invoice',$total_invoice);
            
            $d = ORM::for_table('sys_invoices')->where("school_id", $_SESSION['school_id'])->having_lte('date',$to_date)->order_by_desc('id')->find_many();
            //echo '<pre>';print_r($d);die;
            $paginator['contents'] = '';

        }
        else{

            $mode_css = Asset::css('footable/css/footable.core.min','datatable/css/jquery.dataTables.min');
            $mode_js = Asset::js(array('numeric','datatable/js/jquery.dataTables.min'));
            //
            $d = ORM::for_table('sys_invoices')->where("school_id", $_SESSION['school_id'])->order_by_desc('id')->find_many();
        }
        //echo '<pre>';print_r( $d);exit;
        
        $base_url       =   APP_URL;
        $ui->assign('b_url', $base_url);
        $ui->assign('xheader', $mode_css);
        $ui->assign('xfooter', $mode_js);
        $ui->assign('view_type', $view_type);

        $ui->assign('d', $d);
        //$ui->assign('paginator', $paginator);

        $ui->assign('xjq', '
         /*$(\'.amount\').autoNumeric(\'init\', {
            aSign: \''.$config['currency_code'].' \',
            dGroup: '.$config['thousand_separator_placement'].',
            aPad: '.$config['currency_decimal_digits'].',
            pSign: \''.$config['currency_symbol_position'].'\',
            aDec: \''.$config['dec_point'].'\',
            aSep: \''.$config['thousands_sep'].'\'
        });*/
        
        $(\'.amount\').curren({symbol:\''.$config['currency_code'].'\'});
        $(".cdelete").click(function (e) {
            e.preventDefault();
            var id = this.id;
            bootbox.confirm("'.$_L['are_you_sure'].'", function(result) {
            if(result){
                var _url = $("#_url").val();
                window.location.href = _url + "delete/invoice/" + id;
            }
            });
        });
        ');

        $ui->assign('amtNumeric', '
            /*$(\'.amount\').autoNumeric(\'init\', {

            aSign: \''.$config['currency_code'].' \',
            dGroup: '.$config['thousand_separator_placement'].',
            aPad: '.$config['currency_decimal_digits'].',
            pSign: \''.$config['currency_symbol_position'].'\',
            aDec: \''.$config['dec_point'].'\',
            aSep: \''.$config['thousands_sep'].'\'

            });*/');

        $ui->display('list-invoices.tpl');
        break;
        
    case 'future-list': 
            Event::trigger('invoices/list/');
            $paginator = array();
            $mode_css = '';
            $mode_js = '';
            $view_type = 'default';
            $classes    =   ORM::for_table('crm_groups')->select('id')->select('gname')->where('school_id',$_SESSION['school_id'])->order_by_asc('id')->find_many();
            $group_id = $classes[0]['id'];  
            $ui->assign( 'classes' , $classes );
            $curr_date      =   date('Y-m-d');
    
            if(route(2) == 'filter'){ 
                $class_id       =   _post('class_id');
                $show_scholarship = _post('show_scholarship');
                $b_url          =   _post('b_url');
                
    
                if($class_id)
                    $group_id   =   $class_id;
                if($show_scholarship == 1){
                    $d = ORM::for_table('sys_invoices')->select('sys_invoices.*')
                        ->having_gt('sys_invoices.date',$curr_date)
                        ->_add_join_source('left', 'crm_accounts',array('sys_invoices.userid','=','crm_accounts.id'))
                        ->where_equal('crm_accounts.gid',$group_id)
                        ->where_not_equal('scholarship_id',0)
                        ->where_equal('school_id',$_SESSION['school_id'])  
                        ->where_in ('sys_invoices.status',array('Unpaid','Paid Partially'))
                        ->order_by_desc('id')->find_many();
                } else{
                    $d = ORM::for_table('sys_invoices')->select('sys_invoices.*')
                            ->having_gt('sys_invoices.date',$curr_date)
                            ->_add_join_source('left', 'crm_accounts',array('sys_invoices.userid','=','crm_accounts.id'))
                            ->where(array('crm_accounts.gid'=>$group_id))
                            ->where_equal('school_id',$_SESSION['school_id'])  
                             ->where_in ('sys_invoices.status',array('Unpaid','Paid Partially'))
                            ->order_by_desc('id')->find_many();
                }
              // echo ORM::get_last_query();//exit;
               ////////////////////invoice list for ajax call start///////////////////////////
                $result_html    =   '';
                $count= 0;
                if(count($d)>0) {
                    foreach($d as $ds) {
                        $payment_status = '';    
                        if($ds['status'] == 'Unpaid') {
                            $payment_status         .=  '<span class="label label-danger">'.ib_lan_get_line($ds['status']).'</span>';
                        }elseif ($ds['status'] == 'Partially Paid'){
                            $payment_status         .=  '<span class="label label-success">'.ib_lan_get_line($ds['status']).'</span>';
                        }
                        $_url = $b_url;
                        $_c['df'] = 'M d Y';
                        echo $result_html = '<tr>
                                <td><a href="'.$_url.'invoices/view/'.$ds['id'].'/">'.$count++.'</a></td>
                                <td><a href="'.$_url.'contacts/view/'.$ds['userid'].'">'.$ds['account'].'</a> </td>
                                <td class="amount">'.$ds['total'].'</td>
                                <td>'.date( $_c['df'], strtotime($ds['date'])).'</td>
                                <td>'.date( $_c['df'], strtotime($ds['duedate'])).'</td>
                                <td>'.$payment_status.'</td>
                                <td class="text-right">
                                    <a href="'.$_url.'invoices/view/'.$ds["id"].'/" class="btn btn-primary btn-xs"><i class="fa fa-check"></i> '.$_L["View"].'</a>
                                </td>
                            </tr>';
                    } die();
                } else {
                    echo $result_html    =   '<tr><td colspan="6">No Data Available</td></tr>';die();
                }
                    ////////////////////invoice list for ajax call ends///////////////////////////

                    $total_invoice = ORM::for_table('sys_invoices')->where('school_id', $_SESSION['school_id'])->count();

                    $ui->assign('total_invoice',$total_invoice);

                    $d = ORM::for_table('sys_invoices')->where('school_id', $_SESSION['school_id'])->order_by_desc('id')->find_many();
                    //echo '<pre>';print_r($d);die;
                    $paginator['contents'] = '';

            } else {
                $mode_js = Asset::js(array('numeric','datatable/js/jquery.dataTables.min'));
                $d = ORM::for_table('sys_invoices')->select('sys_invoices.*')->having_gt('date',$curr_date)->where_in('status',array('Unpaid','Paid Partially'))->where('school_id', $_SESSION['school_id'])->order_by_desc('id')->find_many();;
            }


            $ui->assign('_st', $_L['Invoices']);/*.'<div class="btn-group pull-right" style="padding-right: 10px;">
                            <a class="btn btn-success btn-xs" href="'.U.'invoices/add/'.'" style="box-shadow: none;"><i class="fa fa-plus"></i></a>
                            <a class="btn btn-primary btn-xs" href="'.U.'invoices/add/'.'" style="box-shadow: none;"><i class="fa fa-repeat"></i></a>
                            <a class="btn btn-success btn-xs" href="'.U.'invoices/export_csv/'.'" style="box-shadow: none;"><i class="fa fa-download"></i></a>
                          </div>');*/

            $js_file = 'invoice';
            $css_arr = array('s2/css/select2.min','modal','dp/dist/datepicker.min','redactor/redactor','datatable/css/jquery.dataTables.min');
            $js_arr = array('redactor/redactor.min','s2/js/select2.min','s2/js/i18n/'.lan(),'dp/dist/datepicker.min','dp/i18n/'.$config['language'],'numeric','modal','datatable/js/jquery.dataTables.min',$js_file);

            Event::trigger('add_invoice_rendering_form');

            $ui->assign('xheader', Asset::css($css_arr));
            $ui->assign('xfooter', Asset::js($js_arr));
            $ui->assign('view_type', $view_type);

            $ui->assign('d', $d);
            //$ui->assign('paginator', $paginator);
            $ui->assign('xjq', '
                $(\'.amount\').autoNumeric(\'init\', {

                    aSign: \''.$config['currency_code'].' \',
                    dGroup: '.$config['thousand_separator_placement'].',
                    aPad: '.$config['currency_decimal_digits'].',
                    pSign: \''.$config['currency_symbol_position'].'\',
                    aDec: \''.$config['dec_point'].'\',
                    aSep: \''.$config['thousands_sep'].'\'

                });
        $(".cdelete").click(function (e) {
            e.preventDefault();
            var id = this.id;
            bootbox.confirm("'.$_L['are_you_sure'].'", function(result) {
               if(result){
                   var _url = $("#_url").val();
                   window.location.href = _url + "delete/invoice/future-list/" + id;
               }
            });
        });
     ');

     
     $ui->assign('amtNumeric', '
     $(\'.amount\').autoNumeric(\'init\', {

     aSign: \''.$config['currency_code'].' \',
     dGroup: '.$config['thousand_separator_placement'].',
     aPad: '.$config['currency_decimal_digits'].',
     pSign: \''.$config['currency_symbol_position'].'\',
     aDec: \''.$config['dec_point'].'\',
     aSep: \''.$config['thousands_sep'].'\'

     }); ');
        $ui->display('future-invoices.tpl');
        break;
        
    case 'previous-list': 
            Event::trigger('invoices/list/');
            $paginator = array();
            $mode_css = '';
            $mode_js = '';
            $view_type = 'default';
            $classes    =   ORM::for_table('crm_groups')->select('id')->select('gname')->where('school_id', $_SESSION['school_id'])->order_by_asc('id')->find_many();
            $group_id = $classes[0]['id'];  
            $ui->assign( 'classes' , $classes );
            $curr_date      =   date('Y-m-d');
    
            if(route(2) == 'filter'){ 
                $class_id       =   _post('class_id');
                $show_scholarship = _post('show_scholarship');
                $b_url          =   _post('b_url');
                if($class_id)
                    $group_id   =   $class_id;
                if($show_scholarship == 1){
                    $d = ORM::for_table('sys_invoices')->select('sys_invoices.*')
                            ->having_lte('sys_invoices.date',$curr_date)
                            ->_add_join_source('left', 'crm_accounts',array('sys_invoices.userid','=','crm_accounts.id'))
                            ->where_equal('crm_accounts.gid',$group_id)
                            ->where_equal('school_id',$_SESSION['school_id'])
                            ->where_not_equal('scholarship_id',0)
                            ->where_in ('sys_invoices.status',array('Unpaid','Paid Partially'))
                            ->order_by_desc('id')->find_many();
                } else {
                    $d = ORM::for_table('sys_invoices')->select('sys_invoices.*')
                            ->having_lte('sys_invoices.date',$curr_date)
                            ->_add_join_source('left', 'crm_accounts',array('sys_invoices.userid','=','crm_accounts.id'))
                            ->where_equal('crm_accounts.gid',$group_id)
                            ->where_equal('school_id',$_SESSION['school_id'])
                            ->where_in ('sys_invoices.status',array('Unpaid','Paid Partially'))
                            ->order_by_desc('id')->find_many();
                }
               // echo ORM::get_last_query();exit;
               ////////////////////invoice list for ajax call start///////////////////////////
                $result_html    =   '';
                if(count($d)>0) {
                    foreach($d as $ds) {
                        $payment_status = '';    
                        if($ds['status'] == 'Unpaid') {
                            $payment_status         .=  '<span class="label label-danger">'.ib_lan_get_line($ds['status']).'</span>';
                        }elseif ($ds['status'] == 'Partially Paid'){
                            $payment_status         .=  '<span class="label label-success">'.ib_lan_get_line($ds['status']).'</span>';
                        }
                        $_url = $b_url;
                        $_c['df'] = 'M d Y';
                        echo $result_html = '<tr>
                                <td><a href="'.$_url.'invoices/view/'.$ds['id'].'/">'.$ds['invoicenum'].($ds['cn'] != ''?$ds['cn']:$ds['id']).'</a></td>
                                <td><a href="'.$_url.'contacts/view/'.$ds['userid'].'">'.$ds['account'].'</a> </td>
                                <td class="amount">'.$ds['total'].'</td>
                                <td>'.date( $_c['df'], strtotime($ds['date'])).'</td>
                                <td>'.date( $_c['df'], strtotime($ds['duedate'])).'</td>
                                <td>'.$payment_status.'</td>
                                <td class="text-right">
                                    <a href="'.$_url.'invoices/view/'.$ds["id"].'/" class="btn btn-primary btn-xs"><i class="fa fa-check"></i> '.$_L["View"].'</a>
                                </td>
                            </tr>';
                    } die();
                } else {
                    echo $result_html    =   '<tr><td colspan="6">No Data Available</td></tr>';die();
                }
                    ////////////////////invoice list for ajax call ends///////////////////////////

                    $total_invoice = ORM::for_table('sys_invoices')->where_equal('school_id',$_SESSION['school_id'])->count();

                    $ui->assign('total_invoice',$total_invoice);

                    $d = ORM::for_table('sys_invoices')->where_equal('school_id',$_SESSION['school_id'])->order_by_desc('id')->find_many();
                    //echo '<pre>';print_r($d);die;
                    $paginator['contents'] = '';

            } else {
                $mode_js = Asset::js(array('numeric','datatable/js/jquery.dataTables.min'));
                $d = ORM::for_table('sys_invoices')->select('sys_invoices.*')->having_lte('date',$curr_date)->where_in('status',array('Unpaid','Paid Partially'))->where_equal('school_id',$_SESSION['school_id'])->order_by_desc('id')->find_many();
                //echo ORM::get_last_query();exit;
            }


            $ui->assign('_st', $_L['Invoices']);/*.'<div class="btn-group pull-right" style="padding-right: 10px;">
                            <a class="btn btn-success btn-xs" href="'.U.'invoices/add/'.'" style="box-shadow: none;"><i class="fa fa-plus"></i></a>
                            <a class="btn btn-primary btn-xs" href="'.U.'invoices/add/'.'" style="box-shadow: none;"><i class="fa fa-repeat"></i></a>
                            <a class="btn btn-success btn-xs" href="'.U.'invoices/export_csv/'.'" style="box-shadow: none;"><i class="fa fa-download"></i></a>
                          </div>');*/

            $js_file = 'invoice';
            $css_arr = array('s2/css/select2.min','modal','dp/dist/datepicker.min','redactor/redactor','datatable/css/jquery.dataTables.min');
            $js_arr = array('redactor/redactor.min','s2/js/select2.min','s2/js/i18n/'.lan(),'dp/dist/datepicker.min','dp/i18n/'.$config['language'],'numeric','modal','datatable/js/jquery.dataTables.min',$js_file);

            Event::trigger('add_invoice_rendering_form');

            $ui->assign('xheader', Asset::css($css_arr));
            $ui->assign('xfooter', Asset::js($js_arr));
            $ui->assign('view_type', $view_type);

            $ui->assign('d', $d);
            //$ui->assign('paginator', $paginator);
            $ui->assign('xjq', '
                $(\'.amount\').autoNumeric(\'init\', {

                    aSign: \''.$config['currency_code'].' \',
                    dGroup: '.$config['thousand_separator_placement'].',
                    aPad: '.$config['currency_decimal_digits'].',
                    pSign: \''.$config['currency_symbol_position'].'\',
                    aDec: \''.$config['dec_point'].'\',
                    aSep: \''.$config['thousands_sep'].'\'

                });
        $(".cdelete").click(function (e) {
            e.preventDefault();
            var id = this.id;
            bootbox.confirm("'.$_L['are_you_sure'].'", function(result) {
               if(result){
                   var _url = $("#_url").val();
                   window.location.href = _url + "delete/invoice/previous-list/" + id;
               }
            });
        });
     ');
        $ui->display('previous-invoices.tpl');
        break;
    case 'list_students_ss':  
        Event::trigger('invoices/list/');

        $paginator = array();

        $mode_css = '';
        $mode_js = '';
        $view_type = 'default';
        $classes    =   ORM::for_table('crm_groups')->select('id')->select('gname')->where('school_id', $_SESSION['school_id'])->order_by_asc('id')->find_many();
        $group_id = $classes[0]['id']; 
        $ui->assign( 'classes' , $classes );
        break;
    case 'ls-by-class' : 
        Event::trigger('invoices/list/');

        //$paginator = array();

        $mode_css = '';
        $mode_js = '';
        $view_type = 'default';
        $classes    =   ORM::for_table('crm_groups')->select('id')->select('gname')->where_equal('school_id',$_SESSION['school_id'])->order_by_asc('id')->find_many();
        $group_id = $classes[0]['id']; 
        $ui->assign( 'classes' , $classes);
        
        
        if(route(2) == 'filter'){
            $class_id       =   _post('class_id');
            $b_url          =   _post('b_url');
            $from_date      =   _post('from_date');
            $to_date        =   _post('to_date');

            if($class_id)
                $group_id   =   $class_id;
            //$mode_css = Asset::css('footable/css/footable.core.min');

            //$mode_js = Asset::js(array('numeric','footable/js/footable.all.min','contacts/mode_search'));
            if((!empty($to_date)) || (!empty($from_date))){
            $d = ORM::for_table('sys_invoices')->select('sys_invoices.*')->having_lte('sys_invoices.date',$to_date)->having_gte('sys_invoices.date',$from_date)->_add_join_source( 'left' , 'crm_accounts' , array( 'sys_invoices.userid' , '=' , 'crm_accounts.id' ))->where('crm_accounts.gid',$group_id)->where('sys_invoices.school_id', $_SESSION['school_id'])->order_by_asc('sys_invoices.date')->find_many();
            }
            else{
                $d = ORM::for_table('sys_invoices')->select('sys_invoices.*')->_add_join_source( 'left' , 'crm_accounts' , array( 'sys_invoices.userid' , '=' , 'crm_accounts.id' ))->where('crm_accounts.gid',$group_id)->where('sys_invoices.school_id', $_SESSION['school_id'])->order_by_asc('sys_invoices.date')->find_many(); 
            }
            ////////////////////invoice list for ajax call start///////////////////////////
            $result_html    =   '';
            if(count($d)>0) {
                foreach($d as $ds) {

                    $payment_status         =   '';
                    if($ds['status'] == 'Unpaid') {
                        $payment_status         .=  '<span class="label label-danger">'.ib_lan_get_line($ds['status']).'</span>';
                    }elseif ($ds['status'] == 'Paid'){
                        $payment_status         .=  '<span class="label label-success">'.ib_lan_get_line($ds['status']).'</span>';
                    }elseif ($ds['status'] == 'Partially Paid') {
                        $payment_status         .=  '<span class="label label-info">'.ib_lan_get_line($ds['status']).'</span>';
                    }elseif ($ds['status'] == 'Cancelled') {
                        $payment_status         .=  '<span class="label label-info">'.ib_lan_get_line($ds['status']).'</span>';
                    } else {
                        $payment_status         .=  ib_lan_get_line($ds['status']);
                    } //echo $payment_status;die();
                    $_url = $b_url;
                    $_c['df'] = 'M d Y';
                    echo $result_html = '<tr>
                            <td><a href="'.$_url.'invoices/view/'.$ds['id'].'/">'.$ds['invoicenum'].($ds['cn'] != ''?$ds['cn']:$ds['id']).'</a> </td>
                            <td><a href="'.$_url.'contacts/view/'.$ds['userid'].'">'.$ds['account'].'</a> </td>
                            <td class="amount">'.$ds['total'].'</td>
                            <td>'.date( $_c['df'], strtotime($ds['date'])).'</td>
                            <td>'.date( $_c['df'], strtotime($ds['duedate'])).'</td>
                            <td>'.$payment_status.'</td>
                            <td class="text-right">
                                <a href="'.$_url.'invoices/view/'.$ds["id"].'/" class="btn btn-primary btn-xs"><i class="fa fa-check"></i> '.$_L["View"].'</a>
                            </td>
                        </tr>';
                } die();
            } else {
                //echo $result_html    =   '<tr><td colspan="7">No Data Available</td></tr>';die();
                echo '';exit;
            }
                ////////////////////invoice list for ajax call ends///////////////////////////

                $total_invoice = ORM::for_table('sys_invoices')->where('school_id', $_SESSION['school_id'])->count();

                $ui->assign('total_invoice',$total_invoice);

                $d = ORM::for_table('sys_invoices')->where('school_id', $_SESSION['school_id'])->order_by_desc('id')->find_many();
                //echo '<pre>';print_r($d);die;
                //$paginator['contents'] = '';

        }
        else{

            //$paginator = Paginator::bootstrap('sys_invoices');
            $d = ORM::for_table('sys_invoices')->select('sys_invoices.*')->_add_join_source( 'left' , 'crm_accounts' , array( 'sys_invoices.userid' , '=' , 'crm_accounts.id' ))->where('crm_accounts.gid',$group_id)->where('school_id', $_SESSION['school_id'])->order_by_asc('sys_invoices.date')->find_many();

        }

//echo ORM::get_last_query();exit;
       $ui->assign('_st', $_L['Invoices']); /*.'<div class="btn-group pull-right" style="padding-right: 10px;">
  <a class="btn btn-success btn-xs" href="'.U.'invoices/add/'.'" style="box-shadow: none;"><i class="fa fa-plus"></i></a>
  <a class="btn btn-primary btn-xs" href="'.U.'invoices/add/'.'" style="box-shadow: none;"><i class="fa fa-repeat"></i></a>
  <a class="btn btn-success btn-xs" href="'.U.'invoices/export_csv/'.'" style="box-shadow: none;"><i class="fa fa-download"></i></a>
</div>');*/
        
        $js_file = 'invoice';
        $css_arr = array('s2/css/select2.min','modal','dp/dist/datepicker.min','redactor/redactor','datatable/css/jquery.dataTables.min');
        $js_arr = array('redactor/redactor.min','s2/js/select2.min','s2/js/i18n/'.lan(),'dp/dist/datepicker.min','dp/i18n/'.$config['language'],'numeric','modal','datatable/js/jquery.dataTables.min',$js_file);

        Event::trigger('add_invoice_rendering_form');

        $ui->assign('xheader', Asset::css($css_arr));
        $ui->assign('xfooter', Asset::js($js_arr));
        $ui->assign('view_type', $view_type);

        $ui->assign('d', $d);
        //$ui->assign('paginator', $paginator);
        $ui->assign('xjq', '
            $(\'.amount\').autoNumeric(\'init\', {

                aSign: \''.$config['currency_code'].' \',
                dGroup: '.$config['thousand_separator_placement'].',
                aPad: '.$config['currency_decimal_digits'].',
                pSign: \''.$config['currency_symbol_position'].'\',
                aDec: \''.$config['dec_point'].'\',
                aSep: \''.$config['thousands_sep'].'\'

                });
            $(".cdelete").click(function (e) {
                    e.preventDefault();
                    var id = this.id;
                    bootbox.confirm("'.$_L['are_you_sure'].'", function(result) {
                    if(result){
                        var _url = $("#_url").val();
                        window.location.href = _url + "delete/invoice/" + id;
                    }
                    });
                });
            ');
        
        $ui->assign('amtNumeric', '
            $(\'.amount\').autoNumeric(\'init\', {

            aSign: \''.$config['currency_code'].' \',
            dGroup: '.$config['thousand_separator_placement'].',
            aPad: '.$config['currency_decimal_digits'].',
            pSign: \''.$config['currency_symbol_position'].'\',
            aDec: \''.$config['dec_point'].'\',
            aSep: \''.$config['thousands_sep'].'\'

            }); ');

        $ui->display('list-invoice-by-class.tpl');
        break;

    case 'due-list' : 
        Event::trigger('invoices/list/');

        $paginator = array();

        $mode_css = '';
        $mode_js = '';
        $view_type = 'default';
        $classes    =   ORM::for_table('crm_groups')->select('id')->select('gname')->where('school_id', $_SESSION['school_id'])->order_by_asc('id')->find_many();
        $group_id = $classes[0]['id']; 
        $ui->assign( 'classes' , $classes );
        $curr_date      =   date('Y-m-d');
        $from_date          =   0;
        $to_date            =   0;
        if(route(2) == 'filter'){
            $class_id           =   route(3);//_post('class_id');
            $from_date          =   route(4);//_post('b_url');
            $to_date            =   route(5);//_post('from_date');
            //$b_url        =   _post('to_date');

//            $ui->assign('from_date', $from_date);
//            $ui->assign('to_date', $to_date);

            if($class_id)
                $group_id   =   $class_id;
            
            if($from_date !='' && $to_date !='') {
                $d = ORM::for_table('sys_invoices')->select('sys_invoices.*')->having_gte('sys_invoices.duedate',$from_date)->having_lte('sys_invoices.duedate',$to_date)->where_not_equal('sys_invoices.status','paid')->_add_join_source( 'left' , 'crm_accounts' , array( 'sys_invoices.userid' , '=' , 'crm_accounts.id' ))->where('crm_accounts.gid',$group_id)->where('sys_invoices.school_id', $_SESSION['school_id'])->order_by_desc('sys_invoices.duedate')->find_many();
            } else if($from_date !='') {
                $d = ORM::for_table('sys_invoices')->select('sys_invoices.*')->having_gte('sys_invoices.duedate',$from_date)->where_not_equal('sys_invoices.status','paid')->_add_join_source( 'left' , 'crm_accounts' , array( 'sys_invoices.userid' , '=' , 'crm_accounts.id' ))->where('crm_accounts.gid',$group_id)->order_by_desc('sys_invoices.duedate')->where('sys_invoices.school_id', $_SESSION['school_id'])->find_many();                
            } else if($to_date !='') {
                $d = ORM::for_table('sys_invoices')->select('sys_invoices.*')->having_lte('sys_invoices.duedate',$to_date)->where_not_equal('sys_invoices.status','paid')->_add_join_source( 'left' , 'crm_accounts' , array( 'sys_invoices.userid' , '=' , 'crm_accounts.id' ))->where('crm_accounts.gid',$group_id)->where('sys_invoices.school_id', $_SESSION['school_id'])->order_by_desc('sys_invoices.duedate')->find_many();                
            } else {
                $d = ORM::for_table('sys_invoices')->select('sys_invoices.*')->having_lte('sys_invoices.duedate',$curr_date)->where_not_equal('sys_invoices.status','paid')->_add_join_source( 'left' , 'crm_accounts' , array( 'sys_invoices.userid' , '=' , 'crm_accounts.id' ))->where('crm_accounts.gid',$group_id)->where('sys_invoices.school_id', $_SESSION['school_id'])->order_by_desc('sys_invoices.duedate')->find_many();
            }

            ////echo ORM::get_last_query();exit;
            ////////////////////invoice list for ajax call start///////////////////////////
//            $result_html    =   '';
//            if(count($d)>0) {
//                foreach($d as $ds) {
//
//                    $payment_status         =   '';
//                    if($ds['status'] == 'Unpaid') {
//                        $payment_status         .=  '<span class="label label-danger">'.ib_lan_get_line($ds['status']).'</span>';
//                    }elseif ($ds['status'] == 'Paid'){
//                        $payment_status         .=  '<span class="label label-success">'.ib_lan_get_line($ds['status']).'</span>';
//                    }elseif ($ds['status'] == 'Partially Paid') {
//                        $payment_status         .=  '<span class="label label-info">'.ib_lan_get_line($ds['status']).'</span>';
//                    }elseif ($ds['status'] == 'Cancelled') {
//                        $payment_status         .=  '<span class="label label-info">'.ib_lan_get_line($ds['status']).'</span>';
//                    } else {
//                        $payment_status         .=  ib_lan_get_line($ds['status']);
//                    } //echo $payment_status;die();
//                    $_url = $b_url;
//                    $_c['df'] = 'M d Y';
//                    echo $result_html = '<tr>
//                            <td><a href="'.$_url.'invoices/view/'.$ds['id'].'/">'.$ds['invoicenum'].($ds['cn'] != ''?$ds['cn']:$ds['id']).'</a> </td>
//                            <td><a href="'.$_url.'contacts/view/'.$ds['userid'].'">'.$ds['account'].'</a> </td>
//                            <td class="amount">'.$ds['total'].'</td>
//                            <td>'.date( $_c['df'], strtotime($ds['date'])).'</td>
//                            <td>'.date( $_c['df'], strtotime($ds['duedate'])).'</td>
//                            <td>'.$payment_status.'</td>
//                            <td class="text-right">
//                                <a href="'.$_url.'invoices/view/'.$ds["id"].'/" class="btn btn-primary btn-xs"><i class="fa fa-check"></i> '.$_L["View"].'</a>
//                            </td>
//                        </tr>';
//                } die();
//            } else {
//                echo $result_html    =   '<tr><td colspan="7">No Data Available</td></tr>';die();
//            }
                ////////////////////invoice list for ajax call ends///////////////////////////

                $total_invoice = ORM::for_table('sys_invoices')->where('school_id', $_SESSION['school_id'])->count();

                $ui->assign('total_invoice',$total_invoice);

                //$d = ORM::for_table('sys_invoices')->order_by_desc('id')->find_many();
                //echo '<pre>';print_r($d);die;
                $paginator['contents'] = '';
//                print_r($d);die();

        } else {

//            $ui->assign('xfooter', Asset::js(array('numeric')));
            
            $mode_js = Asset::js(array('numeric','datatable/js/jquery.dataTables.min'));
            //$paginator = Paginator::bootstrap('sys_invoices');
            
            
            $d = ORM::for_table('sys_invoices')->select('sys_invoices.*')->having_lte('sys_invoices.duedate',$curr_date)->where_not_equal('sys_invoices.status','paid')->_add_join_source( 'left' , 'crm_accounts' , array( 'sys_invoices.userid' , '=' , 'crm_accounts.id' ))->where('crm_accounts.gid',$group_id)->where('sys_invoices.school_id', $_SESSION['school_id'])->order_by_desc('sys_invoices.duedate')->find_many();
            //echo ORM::get_last_query();exit;
        }
            //echo ORM::get_last_query();exit;
        $ui->assign('from_date', $from_date);
        $ui->assign('to_date', $to_date);
        $ui->assign('class_id',$group_id);
        $ui->assign('_st', $_L['Invoices']);
        $js_file = 'invoice';
        $css_arr = array('s2/css/select2.min','modal','dp/dist/datepicker.min','redactor/redactor','datatable/css/jquery.dataTables.min');
        $js_arr = array('redactor/redactor.min','s2/js/select2.min','s2/js/i18n/'.lan(),'dp/dist/datepicker.min','dp/i18n/'.$config['language'],'numeric','modal','datatable/js/jquery.dataTables.min',$js_file);

        Event::trigger('add_invoice_rendering_form');

        $ui->assign('xheader', Asset::css($css_arr));
        $ui->assign('xfooter', Asset::js($js_arr));
        $ui->assign('view_type', $view_type);

        $ui->assign('d', $d);
        $ui->assign('xjq', '
         $(\'.amount\').autoNumeric(\'init\', {

    aSign: \''.$config['currency_code'].' \',
    dGroup: '.$config['thousand_separator_placement'].',
    aPad: '.$config['currency_decimal_digits'].',
    pSign: \''.$config['currency_symbol_position'].'\',
    aDec: \''.$config['dec_point'].'\',
    aSep: \''.$config['thousands_sep'].'\'

    });
$(".cdelete").click(function (e) {
        e.preventDefault();
        var id = this.id;
        bootbox.confirm("'.$_L['are_you_sure'].'", function(result) {
           if(result){
               var _url = $("#_url").val();
               window.location.href = _url + "delete/invoice/" + id;
           }
        });
    });
 ');
        $ui->display('list-due-invoice.tpl');
        break;
        
    case 'list-recurring':

        $d = ORM::for_table('sys_invoices')->where('sys_invoices.school_id', $_SESSION['school_id'])->where_not_equal('r', '0')->order_by_desc('id')->find_many();
        $ui->assign('d', $d);
        $ui->assign('xjq', '
$(".cdelete").click(function (e) {
        e.preventDefault();
        var id = this.id;
        bootbox.confirm("'.$_L['are_you_sure'].'", function(result) {
           if(result){
               var _url = $("#_url").val();
               window.location.href = _url + "delete/invoice/" + id;
           }
        });
    });

     $(".cstop").click(function (e) {
        e.preventDefault();
        var id = this.id;
        bootbox.confirm("Are you sure? This will prevent future invoice generation from this invoice.", function(result) {
           if(result){
               var _url = $("#_url").val();
               window.location.href = _url + "invoices/stop_recurring/" + id;
           }
        });
    });

 ');
        $ui->display('list-recurring-invoices.tpl');
        break;

    case 'edit-post':

        Event::trigger('invoices/edit-post/');

        $cid = _post('cid');
        $iid = _post('iid');
        //find user with cid
        $u = ORM::for_table('crm_accounts')->where('school_id', $_SESSION['school_id'])->find_one($cid);

        $msg = '';
        if ($cid == '') {
            $msg .= $_L['select_a_contact'].' <br> ';
        }

        $notes = _post('notes');


        if (isset($_POST['amount'])) {
            $amount = $_POST['amount'];
        } else {
            $msg .= $_L['at_least_one_item_required'].' <br> ';
        }



        $idate = _post('idate');
        $its = strtotime($idate);
        $duedate = _post('ddate');
        $repeat = _post('repeat');
        $nd = $idate;
        if ($repeat == '0') {
            $r = '0';
        } elseif ($repeat == 'week1') {
            $r = '+1 week';
            $nd = date('Y-m-d', strtotime('+1 week', $its));
        } elseif ($repeat == 'weeks2') {
            $r = '+2 weeks';
            $nd = date('Y-m-d', strtotime('+2 weeks', $its));
        } elseif ($repeat == 'month1') {


            $r = '+1 month';
            $nd = date('Y-m-d', strtotime('+1 month', $its));

        } elseif ($repeat == 'months2') {
            $r = '+2 months';
            $nd = date('Y-m-d', strtotime('+2 months', $its));
        } elseif ($repeat == 'months3') {
            $r = '+3 months';
            $nd = date('Y-m-d', strtotime('+3 months', $its));
        } elseif ($repeat == 'months6') {
            $r = '+6 months';
            $nd = date('Y-m-d', strtotime('+6 months', $its));
        } elseif ($repeat == 'year1') {
            $r = '+1 year';
            $nd = date('Y-m-d', strtotime('+1 year', $its));
        } elseif ($repeat == 'years2') {
            $r = '+2 years';
            $nd = date('Y-m-d', strtotime('+2 years', $its));
        } elseif ($repeat == 'years3') {
            $r = '+3 years';
            $nd = date('Y-m-d', strtotime('+3 years', $its));
        } else {
            $msg .= 'Date Parsing Error <br> ';
        }


        if ($msg == '') {


            $qty = $_POST['qty'];


            if(isset($_POST['taxed'])){
                $taxed = $_POST['taxed'];

            }
            else{
                $taxed = false;
            }

            $sTotal = '0';
            $taxTotal = '0';
            $i = '0';
            $a = array();

            $taxval = '0.00';
            $taxname = '';
            $taxrate = '0.00';
            $tax = _post('tid');
            $taxed_type = _post('taxed_type');
            if ($tax != '') {
                $dt = ORM::for_table('sys_tax')->where('school_id', $_SESSION['school_id'])->find_one($tax);
                $taxrate = $dt['rate'];
                $taxname = $dt['name'];
                $taxtype = $dt['type'];
                //


            }


            $taxed_amount = 0.00;

            $lamount = 0.00;

            foreach ($amount as $samount) {
                $samount = Finance::amount_fix($samount);
                $a[$i] = $samount;
                /* @since v 2.0 */
                $sqty = $qty[$i];

                $sqty = Finance::amount_fix($sqty);
//                if (($config['dec_point']) == ',') {
//                    $samount = str_replace(',', '.', $samount);
//                    $sqty = str_replace(',', '.', $sqty);
//
//                }

                $sTotal += $samount * ($sqty);
                $lamount = $samount * ($sqty);

                if($taxed){
                    $c_tax = $taxed[$i];
                }
                else{
                    $c_tax = 'No';
                }


                if($c_tax == 'Yes'){
                   // $a_tax = ($samount * $taxrate) / 100;
                    $taxed_amount += $lamount;
                }
                else{
                    $a_tax = 0.00;
                }



                $i++;
            }


            $invoicenum = _post('invoicenum');
            $cn = _post('cn');


            $fTotal = $sTotal;



            // calculate discount

            $discount_amount = _post('discount_amount');
            $discount_type = _post('discount_type');
            $discount_value = '0.00';


            if($discount_amount == '0' OR $discount_amount == ''){
                $actual_discount = '0.00';
            }
            else{
                if($discount_type == 'f'){

                    $actual_discount = $discount_amount;
                    $discount_value = $discount_amount;

                }

                else{

                    $discount_type = 'p';
                    $actual_discount = ($sTotal * $discount_amount) / 100;
                    $discount_value = $discount_amount;

                }
            }


            $actual_discount = number_format((float)$actual_discount, 2, '.', '');



            $fTotal = $fTotal - $actual_discount;

            if($taxed_amount != 0.00){
                $taxval = ($taxed_amount * $taxrate) / 100;
            }




            if (($taxed_type != 'individual') AND ($tax != '')) {

                $taxval = ($fTotal * $taxrate) / 100;




            }




            $fTotal = $fTotal + $taxval;



            //

            // $vtoken = _raid(10);
            // $ptoken = _raid(10);
            $d = ORM::for_table('sys_invoices')->where('school_id', $_SESSION['school_id'])->find_one($iid);
            if ($d) {
                $d->userid = $cid;
                $d->account = $u['account'];
                $d->date = $idate;
                $d->duedate = $duedate;
                $d->discount_type = $discount_type;
                $d->discount_value = $discount_value;
                $d->discount = $actual_discount;
                $d->subtotal = $sTotal;
                $d->total = $fTotal;
                $d->tax = $taxval;
                $d->taxname = $taxname;
                $d->taxrate = $taxrate;
                $d->notes = $notes;
                $d->r = $r;
                $d->nd = $nd;
                $d->invoicenum = $invoicenum;
                $d->cn = $cn;
                $d->school_id = $_SESSION['school_id'];
                /*
                 * $d->userid = $cid;
            $d->account = $u['account'];
            $d->date = $idate;
            $d->duedate = $dd;
            $d->subtotal = $sTotal;
            $d->total = $fTotal;
            $d->tax = $taxval;
            $d->taxname = $taxname;
            $d->taxrate = $taxrate;
            $d->vtoken = $vtoken;
            $d->ptoken = $ptoken;
            $d->status = 'Unpaid';
            $d->notes = $notes;
            $d->r = $r;
            $d->nd = $nd;
                 */

                //  $d->status = 'Unpaid';
                $d->save();
                $invoiceid = $iid;
                $description = $_POST['desc'];

                // $taxed = $_POST['taxed'];
             //   $taxed = '0';
                $i = '0';
// first delete all related items
                $x = ORM::for_table('sys_invoiceitems')->where('invoiceid', $iid)->where('school_id', $_SESSION['school_id'])->delete_many();
                foreach ($description as $item) {

                    $samount = $a[$i];
                    /* @since v 2.0 */
                    $sqty = $qty[$i];
                    $sqty = Finance::amount_fix($sqty);
                    $samount = Finance::amount_fix($samount);
                    $ltotal = ($samount) * ($sqty);
                    $d = ORM::for_table('sys_invoiceitems')->create();
                    $d->invoiceid = $invoiceid;
                    $d->userid = $cid;
                    $d->description = $item;
                    $d->qty = $sqty;
                    $d->amount = $samount;
                    $d->total = $ltotal;

//                    if (($taxed[$i]) == 'Yes') {
//                        $d->taxed = '1';
//                    } else {
//                        $d->taxed = '0';
//                    }


                    if($taxed){

                        if (($taxed[$i]) == 'Yes') {
                            $d->taxed = '1';
                        } else {
                            $d->taxed = '0';
                        }

                    }
                    else{
                        $d->taxed = '0';
                    }

                    //others
                    $d->type = '';
                    $d->relid = '0';
                    $d->itemcode = '';
                    $d->taxamount = '0.00';
                    $d->duedate = date('Y-m-d');
                    $d->paymentmethod = '';
                    $d->notes = '';
                    $d->school_id = $_SESSION['school_id'];
                    $d->save();
                    $i++;
                }

                echo $invoiceid;
            } else {

                // invoice not found
            }

        } else {
            echo $msg;
        }

        break;

    case 'delete':

        Event::trigger('invoices/delete/');

        $id = $routes['2'];
        if ($_app_stage == 'Demo') {
            r2(U . 'accounts/list', 'e', 'Sorry! Deleting Account is disabled in the demo mode.');
        }
        $d = ORM::for_table('crm_accounts')->where('school_id', $_SESSION['school_id'])->find_one($id);
        if ($d) {
            $d->delete();
            r2(U . 'accounts/list', 's', $_L['account_delete_successful']);
        }

        break;


    case 'print':

        Event::trigger('invoices/print/');

        $id = $routes['2'];
        $d = ORM::for_table('sys_invoices')->where('school_id', $_SESSION['school_id'])->find_one($id);
        if ($d) {

            //find all activity for this user
            $items = ORM::for_table('sys_invoiceitems')->where('invoiceid', $id)->where('school_id', $_SESSION['school_id'])->order_by_asc('id')->find_many();

//find the user
            $a = ORM::for_table('crm_accounts')->where('school_id', $_SESSION['school_id'])->find_one($d['userid']);

            require 'sysfrm/lib/invoices/render.php';

        } else {
            r2(U . 'customers/list', 'e', $_L['Account_Not_Found']);
        }

        break;

    case 'pdf':

        Event::trigger('invoices/pdf/');


        $id = $routes['2'];


        $d = ORM::for_table('sys_invoices')->where('school_id', $_SESSION['school_id'])->find_one($id);
        if ($d) {

            //find all activity for this user
            $items = ORM::for_table('sys_invoiceitems')->where('invoiceid', $id)->where('school_id', $_SESSION['school_id'])->order_by_asc('id')->find_many();

            $trs_c = ORM::for_table('sys_transactions')->where('iid', $id)->where('school_id', $_SESSION['school_id'])->count();

            $trs = ORM::for_table('sys_transactions')->where('iid', $id)->where('school_id', $_SESSION['school_id'])->order_by_desc('id')->find_many();

//find the user
            $a = ORM::for_table('crm_accounts')->where('school_id', $_SESSION['school_id'])->find_one($d['userid']);
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
            $cf = ORM::for_table('crm_customfields')->where('showinvoice', 'Yes')->where('school_id', $_SESSION['school_id'])->order_by_asc('id')->find_many();
//            ob_start();
//            require 'sysfrm/lib/invoices/pdf-default.php';
//            $html = ob_get_contents();
//            ob_end_clean();
//            echo $html;
//            exit;
//            require('sysfrm/lib/tcpdf/config/lang/eng.php');
//            require('sysfrm/lib/tcpdf/tcpdf.php');
//            // create new PDF document
//            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//
//// set document information
//            $pdf->SetCreator('SysFrm');
//            $pdf->SetAuthor('sysfrm.com');
//            $pdf->SetTitle('invoice titla');
//            $pdf->SetSubject('invoice subject');
//
//            $pdf->SetPrintHeader(false);
//// set default header data
//            //   $pdf->SetHeaderData('', '', $title, "Generated on ".date('d/m/Y')." \nby ".$aadmin);
//
//// set header and footer fonts
//            //   $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//            //   $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
////$pdf->SetFont('freesans', '', 10);
//// set default monospaced font
//            //   $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//
////set margins
////            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
////        //    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
////         //   $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
////
//////set auto page breaks
////            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
////
//////set image scale factor
////            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
//
////set some language-dependent strings
//            //  $pdf->setLanguageArray();
//
//// ---------------------------------------------------------
//
//// set font
//            $pdf->AddPage();
//            require 'sysfrm/lib/invoices/pdf-x1.php';
//
//            // $pdf->writeHTML($html, true, false, true, false, '');
//
//// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
//
//// reset pointer to the last page
//            //   $pdf->lastPage();
//
//// ---------------------------------------------------------
//
////Close and output PDF document
//            if (isset($routes['3']) AND ($routes['3'] == 'dl')) {
//                $pdf->Output(date('Y-m-d') . _raid(4) . '.pdf', 'D'); # D
//            } else {
//                $pdf->Output(date('Y-m-d') . _raid(4) . '.pdf', 'I'); # D
//            }
//
//        } else {
//            r2(U . 'customers/list', 'e', $_L['Account_Not_Found']);
//        }


            if($d['cn'] != ''){
                $dispid = $d['cn'];
            }
            else{
                $dispid = $d['id'];
            }

            $in = $d['invoicenum'].$dispid;

            define('_MPDF_PATH','sysfrm/lib/mpdf/');

            require('sysfrm/lib/mpdf/mpdf.php');

            $pdf_c = '';
            $ib_w_font = 'dejavusanscondensed';
            if($config['pdf_font'] == 'default'){
                $pdf_c = 'c';
                $ib_w_font = 'Helvetica';
            }

            $mpdf=new mPDF($pdf_c,'A4','','',20,15,15,25,10,10);
            $mpdf->SetProtection(array('print'));
            $mpdf->SetTitle($config['CompanyName'].' Invoice');
            $mpdf->SetAuthor($config['CompanyName']);
            $mpdf->SetWatermarkText(ib_lan_get_line($d['status']));
            $mpdf->showWatermarkText = true;
            $mpdf->watermark_font = $ib_w_font;
            $mpdf->watermarkTextAlpha = 0.1;
            $mpdf->SetDisplayMode('fullpage');

            if($config['pdf_font'] == 'AdobeCJK'){
                $mpdf->useAdobeCJK = true;
                $mpdf->autoScriptToLang = true;
                $mpdf->autoLangToFont = true;
            }

            Event::trigger('invoices/before_pdf_render/');

            ob_start();

            require 'sysfrm/lib/invoices/pdf-x2.php';

            $html = ob_get_contents();


            ob_end_clean();

            $mpdf->WriteHTML($html);

            $pdf_return = 'inline';

            if (isset($routes[3])) {

                $r_type = $routes[3];


            }
            else{
                $r_type = 'inline';
            }

            if ($r_type == 'dl') {
                $mpdf->Output(date('Y-m-d') . _raid(4) . '.pdf', 'D'); # D
            }

            elseif ($r_type == 'inline') {
                $mpdf->Output(date('Y-m-d') . _raid(4) . '.pdf', 'I'); # D
            }

            elseif ($r_type == 'store') {

                $mpdf->Output('sysfrm/uploads/_sysfrm_tmp_/Invoice_'.$in.'.pdf', 'F'); # D

            }

            else {
                $mpdf->Output(date('Y-m-d') . _raid(4) . '.pdf', 'I'); # D
            }




        }



        break;

    case 'markpaid':



        $iid = _post('iid');
        $d = ORM::for_table('sys_invoices')->where('school_id', $_SESSION['school_id'])->find_one($iid);
        if ($d) {
            $d->status = 'Paid';
            $d->save();
            Event::trigger('invoices/markpaid/',$invoice=$d);
            _msglog('s', 'Invoice marked as Paid');
        } else {
            _msglog('e', 'Invoice not found');
        }
        break;

    case 'markunpaid':

        Event::trigger('invoices/markunpaid/');

        $iid = _post('iid');
        $d = ORM::for_table('sys_invoices')->where('school_id', $_SESSION['school_id'])->find_one($iid);
        if ($d) {
            $d->status = 'Unpaid';
            $d->save();
            _msglog('s', 'Invoice marked as Un Paid');
        } else {
            _msglog('e', 'Invoice not found');
        }
        break;

    case 'markcancelled':

        Event::trigger('invoices/markcancelled/');


        $iid = _post('iid');
        $d = ORM::for_table('sys_invoices')->where('school_id', $_SESSION['school_id'])->find_one($iid);
        if ($d) {
            $d->status = 'Cancelled';
            $d->save();
            _msglog('s', 'Invoice marked as Cancelled');
        } else {
            _msglog('e', 'Invoice not found');
        }
        break;

    case 'markpartiallypaid':

        Event::trigger('invoices/markpartiallypaid/');


        $iid = _post('iid');
        $d = ORM::for_table('sys_invoices')->where('school_id', $_SESSION['school_id'])->find_one($iid);
        if ($d) {
            $d->status = 'Partially Paid';
            $d->save();
            _msglog('s', 'Invoice marked as Partially Paid');
        } else {
            _msglog('e', 'Invoice not found');
        }
        break;


    case 'add-payment':

        Event::trigger('invoices/add-payment/');
        $sid = $routes['2'];
        $d = ORM::for_table('sys_invoices')->where('school_id', $_SESSION['school_id'])->find_one($sid);

        if ($d) {
            $bank_acc_id    =   $d['bank_acc_id'];
            $itotal         =   $d['total'];
            $ic             =   $d['credit'];
            $np             =   $itotal - $ic;
            $a_opt = '';
            // <option value="{$ds['account']}">{$ds['account']}</option>
            $a = ORM::for_table('sys_accounts')->where('school_id', $_SESSION['school_id'])->find_many();
            foreach ($a as $acs) {
                if($acs['id'] == $bank_acc_id)
                    $selected       =   'selected';
                else
                    $selected       =   '';
                $a_opt .= '<option '.$selected.' value="' . $acs['id'] . '">' . $acs['account'] . '</option>';
            }

            $pms_opt = '';
            // <option value="{$pm['name']}">{$pm['name']}</option>
            $pms = ORM::for_table('sys_pmethods')->where('school_id', $_SESSION['school_id'])->find_many();
            foreach ($pms as $pm) {
                $pms_opt .= '<option value="' . $pm['name'] . '">' . $pm['name'] . '</option>';
            }
            
              $scoler_opt = '';
            if($_SESSION['running_year']){
                 $scoler = ORM::for_table('sys_scholarship')->where('academic_year', $_SESSION['running_year'])
                         ->where('school_id', $_SESSION['school_id'])
                         ->where('deduction_type', '1')
                         ->where_not_equal('status',3)->find_many();
            }else{
                $scoler = ORM::for_table('sys_scholarship')->where('school_id', $_SESSION['school_id'])->find_many();
            }      
            // <option value="{$pm['name']}">{$pm['name']}</option>
            foreach ($scoler as $scolr) {
                $scoler_opt .= '<option value="' . $scolr['id'] . '">' . $scolr['scholarship_name'] . '</option>';
            }

            $cats_opt = '';

            $cats = ORM::for_table('sys_cats')->where('type', 'Income')->where('school_id', $_SESSION['school_id'])->order_by_asc('sorder')->find_many();
            foreach ($cats as $cat) {
                $cats_opt .= '<option value="' . $cat['name'] . '">' . $cat['name'] . '</option>';
            }


            echo '
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3>'.$_L['Invoice'].' #' . $d['id'] . '</h3>
                </div>
                <div class="modal-body">

                <form class="form-horizontal" role="form" id="form_add_payment" method="post">
                    <div class="form-group">
                        <label for="subject" class="col-sm-2 control-label">'.$_L['Account'].'<span class="mandatory">*</span></label>
                        <div class="col-sm-3">
                            <select class="form-control" id="account" name="account">
                                <option value="">'.$_L['Choose an Account'].'</option>
                                ' . $a_opt . '
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="date" class="col-sm-2 control-label">'.$_L['Date'].'<span class="mandatory">*</span></label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control datepicker"  value="' . date('Y-m-d') . '" name="date" id="date" datepicker data-date-format="yyyy-mm-dd" data-auto-close="true">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-sm-2 control-label">'.$_L['Description'].'</label>
                        <div class="col-sm-10">
                        <input type="text" id="description" name="description" class="form-control" value="'.$_L['Invoice'].' ' . $d['id'] . ' '.$_L['Payment'].'">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="amount" class="col-sm-2 control-label">'.$_L['Amount'].'<span class="mandatory">*</span></label>
                        <div class="col-sm-10">
                        <input type="text" id="amount" name="amount" class="form-control amount" data-a-sign="'.$config['currency_code'].'" 
                        data-a-dec="' . $config['dec_point'] . '" data-a-sep="' . $config['thousands_sep'].'" data-d-group="2" value="' . $np . '">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cats" class="col-sm-2 control-label">'.$_L['Category'].'</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="cats" name="cats">
                                <option value="Uncategorized">'.$_L['Uncategorized'].'</option>
                                ' . $cats_opt . '
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="payer_name" class="col-sm-2 control-label">'.$_L['Payer'].'</label>
                        <div class="col-sm-10">
                        <input type="text" id="payer_name" name="payer_name" class="form-control" value="' . $d['account'] . '" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="subject" class="col-sm-2 control-label">'.$_L['Method'].'<span class="mandatory">*</span></label>
                        <div class="col-sm-3">
                            <select class="form-control" id="pmethod" name="pmethod">
                            <option value="">'.$_L['Select Payment Method'].'</option>
                            ' . $pms_opt . '
                            </select>
                        </div>
                        <label for="subject" class="col-sm-2 control-label">Ref. No.</label>
                        <div class="col-sm-3">
                            <input type="text" id="pmrefno" name="ref_no" class="form-control" value="">
                        </div>
                    </div>
                    <!--<div class="form-group">
                        <label for="subject" class="col-sm-2 control-label">'.$_L['Scholership'].'<span class="mandatory">*</span></label>
                        <div class="col-sm-3">
                            <select class="form-control" id="pmethod" name="pmethod">
                            <option value="">'.$_L['Select Scolership'].'</option>
                            ' . $scoler_opt . '
                            </select>
                        </div>
                    </div>-->
                     
                    <div class="form-group">
                        <label for="amount" class="col-sm-2 control-label">'.$_L['Discount'].'<span class="mandatory">*</span></label>
                        <div class="col-sm-3">
                        <input type="text" id="discount" name="discount" class="form-control discount" data-a-sign="' . $config['currency_code'].'" 
                        data-a-dec="'.$config['dec_point'].'" data-a-sep="'.$config['thousands_sep'].'" data-d-group="2" value="">
                        </div>
                    </div>
                </form>

                </div>
                <div class="modal-footer">
                <input type="hidden" id="payer" name="payer" value="' . $d['userid'] . '">
                    <button id="save_payment" class="btn btn-primary">'.$_L['Save'].'</button>
                    <button type="button" data-dismiss="modal" class="btn">'.$_L['Close'].'</button>
                </div>';
        } else {
            exit('Invoice Not Found');
        }


        break;


    case 'mail_invoice_':

        Event::trigger('invoices/mail_invoice_/');

        $sid = $routes['2'];
        $etpl = $routes['3'];

        $d = ORM::for_table('sys_invoices')->where('school_id', $_SESSION['school_id'])->find_one($sid);


        if ($d) {

            $a = ORM::for_table('crm_accounts')->where('school_id', $_SESSION['school_id'])->find_one($d['userid']);

            $msg = Invoice::gen_email($sid,$etpl);



            if($msg){
                $subj = $msg['subject'];
                $message_o = $msg['body'];
                $email = $msg['email'];
                $name = $msg['name'];
            }
            else{
                $subj = '';
                $message_o = '';
                $email = '';
                $name = '';
            }



            if($d['cn'] != ''){
                $dispid = $d['cn'];
            }
            else{
                $dispid = $d['id'];
            }

            $in = $d['invoicenum'].$dispid;

            echo '
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>Invoice #' . $d['id'] . '</h3>
            </div>
            <div class="modal-body">

            <form class="form-horizontal" role="form" id="email_form" method="post">


            <div class="form-group">
                <label for="toemail" class="col-sm-2 control-label">'.$_L['To'].'</label>
                <div class="col-sm-10">
                <input type="email" id="toemail" name="toemail" class="form-control" value="' . $email . '">
                </div>
            </div>

            <div class="form-group">
                <label for="ccemail" class="col-sm-2 control-label">'.$_L['Cc'].'</label>
                <div class="col-sm-10">
                <input type="email" id="ccemail" name="ccemail" class="form-control" value="">
                </div>
            </div>

            <div class="form-group">
                <label for="bccemail" class="col-sm-2 control-label">'.$_L['Bcc'].'</label>
                <div class="col-sm-10">
                <input type="email" id="bccemail" name="bccemail" class="form-control" value="">
                <span class="help-block"><a href="#" id="send_bcc_to_admin">'.$_L['Send Bcc to Admin'].'</a></span>
                </div>
            </div>

                <div class="form-group">
                <label for="subject" class="col-sm-2 control-label">'.$_L['Subject'].'</label>
                <div class="col-sm-10">
                <input type="text" id="subject" name="subject" class="form-control" value="' . $subj . '">
                </div>
            </div>

            <div class="form-group">
                <label for="subject" class="col-sm-2 control-label">'.$_L['Message Body'].'</label>
                <div class="col-sm-10">
                <textarea class="form-control sysedit" rows="3" name="message" id="message">' . $message_o . '</textarea>
                <input type="hidden" id="toname" name="toname" value="' . $name . '">
                <input type="hidden" id="i_cid" name="i_cid" value="' . $a['id'] . '">
                <input type="hidden" id="i_iid" name="i_iid" value="' . $d['id'] . '">
                </div>
            </div>


            <div class="form-group">
                <label for="attach_pdf" class="col-sm-2 control-label">'.$_L['Attach PDF'].'</label>
                <div class="col-sm-10">
                <div class="checkbox c-checkbox">
                        <label>
                        <input type="checkbox" name="attach_pdf" id="attach_pdf" value="Yes" checked><span class="fa fa-check"></span>  <i class="fa fa-paperclip"></i> Invoice_'.$in.'.pdf
                        </label>
                    </div>
                </div>
            </div>


            </form>

            </div>
            <div class="modal-footer">
                <button id="send" class="btn btn-primary">'.$_L['Send'].'</button>

                    <button type="button" data-dismiss="modal" class="btn">'.$_L['Close'].'</button>
            </div>';
        } else {
            exit('Invoice Not Found');
        }


        break;


    case 'send_email':

        Event::trigger('invoices/send_email/');

        $msg = '';
        $email = _post('toemail');
        $cc = _post('ccemail');
        $bcc = _post('bccemail');
        $subject = _post('subject');
        $toname = _post('toname');
        $cid = _post('i_cid');
        $iid = _post('i_iid');

        $d = ORM::for_table('sys_invoices')->where('school_id', $_SESSION['school_id'])->find_one($iid);

        if($d['cn'] != ''){
            $dispid = $d['cn'];
        }
        else{
            $dispid = $d['id'];
        }

        $in = $d['invoicenum'].$dispid;

        $message = $_POST['message'];

        $attach_pdf = _post('attach_pdf');

        $attachment_path = '';
        $attachment_file = '';

        if($attach_pdf == 'Yes'){

            Invoice::pdf($iid,'store');

            $attachment_path = 'sysfrm/uploads/_sysfrm_tmp_/Invoice_'.$in.'.pdf';
            $attachment_file = 'Invoice_'.$in.'.pdf';




        }

        if (!Validator::Email($email)) {
            $msg .= 'Invalid Email <br>';
        }

        if (!Validator::Email($cc)) {
            $cc = '';
        }

        if (!Validator::Email($bcc)) {
            $bcc = '';
        }


        if ($subject == '') {
            $msg .= 'Subject is Required <br>';
        }

        if ($message == '') {
            $msg .= 'Message is Required <br>';
        }

        if ($msg == '') {

            //now send email

            Notify_Email::_send($toname, $email, $subject, $message, $cid, $iid, $cc, $bcc, $attachment_path, $attachment_file);

            // Now check for

            echo '<div class="alert alert-success fade in">Mail Sent!</div>';
        } else {
            echo '<div class="alert alert-danger fade in">' . $msg . '</div>';
        }


        break;

    case 'stop_recurring':

        Event::trigger('invoices/stop_recurring/');


        $id = $routes['2'];
        $id = str_replace('sid', '', $id);
        $d = ORM::for_table('sys_invoices')->where('school_id', $_SESSION['school_id'])->find_one($id);
        if ($d) {

            $d->r = '0';
            $d->save();
            r2(U . 'invoices/list-recurring', 's', 'Recurring Disabled for Invoice: ' . $id);

        } else {
            echo 'Invoice not found';
        }
        break;


    case 'add-payment-post':

        Event::trigger('invoices/add-payment-post/');

        $msg = '';
        $account = _post('account');
        $date = _post('date');
        $amount = _post('amount');
        $amount = Finance::amount_fix($amount);
        $payerid = _post('payer');
        $pmethod = _post('pmethod');
        $pmrefno = _post('pmrefno');
        $discount = _post('discount');
        $ref = _post('ref');
        $school_id = $_SESSION['school_id'];
        if($payerid == ''){
            $payerid = '0';
        }
        /* $amount = str_replace($config['currency_code'], '', $amount);
        $amount = str_replace(',', '', $amount); */
        if (!is_numeric($amount)) {
            $msg .= 'Invalid Amount' . '<br>';
        }
        $cat = _post('cats');
        $iid = _post('iid');


        if ($payerid == '') {
            $msg .= 'Payer Not Found' . '<br>';
        }
        $description = _post('description');
        $msg = '';
        if ($description == '') {
            $msg .= $_L['description_error'] . '<br>';
        }

        //        if (Validator::Length($account, 100, 1) == false) {
        //            $msg .= 'Please choose an Account' . '<br>';
        //        }
        if ($account == '') {
            $msg .= 'Please choose an Account' . '<br>';
        }

        if ($pmethod == '') {
            $msg .= 'Please choose payment method' . '<br>';
        }

        if (is_numeric($amount) == false) {
            $msg .= $_L['amount_error'] . '<br>';
        }
        
        if ($msg == '') {
            
            //find the current balance for this account
            $a = ORM::for_table('sys_accounts')->where('id', $account)->where('school_id', $_SESSION['school_id'])->find_one();
            $cbal = $a['balance'];
            $nbal = $cbal + $amount;
            $a->balance = $nbal;
            $a->save();


            /* payee balance calculate start */
            $b1 = ORM::for_table('sys_transactions')->where('payeeid',$payerid)->where('school_id', $_SESSION['school_id'])->find_many();
            $b2 = ORM::for_table('sys_transactions')->where('payerid',$payerid)->where('school_id', $_SESSION['school_id'])->find_many();

            if(count($b1) > 0) {
                foreach($b1 as $trans) {
                    $payee_bal1      =   $trans['payee_balance'] + $amount;
                    $payee_trans1    =   $trans['id'];
                }
            } else {
                $payee_bal1      =   0+$amount;
            //                $payee_trans1    =   $trans['id'];
            }

            if(!empty($b1[0])) {
                foreach($b1 as $trans) {
                    $payee_bal1      =   $trans['payee_balance'] + $amount;
                    $payee_trans1    =   $trans['id'];
                }
            } else {
                $payee_bal1      =   0+$amount;
            //                $payee_trans1    =   $trans['id'];
            }

            if(!empty($b2[0])) {
                foreach($b2 as $trans) {
                    $payee_bal2      =   $trans['payee_balance'] + $amount;
                    $payee_trans2    =   $trans['id'];
                }
            } else {
                $payee_bal2      =   0+$amount;
            //                $payee_trans2    =   $trans['id'];
            }

            if(!empty($b2[0]) && !empty($b1[0])) {
                $payee_bal      =   ($payee_trans1 > $payee_trans2?$payee_bal1:$payee_bal2);
            } else if(!empty($b2[0])) {
                $payee_bal      =   $payee_bal2;
            } else if(!empty($b1[0])) {
                $payee_bal      =   $payee_bal1;
            } else {
                $payee_bal      =   0+$amount;
            }
                        
            if($discount>0){
                $d = ORM::for_table('sys_invoiceitems')->create();
                $d->invoiceid = $iid;
                $d->userid = $payerid;
                $d->description = 'Discount';
                $d->qty = 1;
                $d->amount = '-'.$discount;
                $d->total = '-'.$discount; 
                $d->taxed = 0;
                $d->type = '';
                $d->relid = '0';
                $d->itemcode = 0;
                $d->taxamount = '0.00';
                $d->duedate = date('Y-m-d');
                $d->paymentmethod = '';
                $d->notes = '';
                $d->school_id = $_SESSION['school_id'] ;
                $d->save();    
            }

            /* payee balance calculate end*/
            $d = ORM::for_table('sys_transactions')->create();
            $d->account = $account;
            $d->type = 'Income';
            $d->payerid = $payerid;

            $d->amount = $amount;
            $d->category = $cat;
            $d->method = $pmethod;
            $d->ref = $ref;
            $d->tags = '';
            $d->payee_balance = $payee_bal;

            $d->description = $description;
            $d->date = $date;
            $d->dr = '0.00';
            $d->cr = $amount;
            $d->bal = $nbal;
            $d->iid = $iid;
            $d->school_id = $school_id;
            
            //others
            $d->payer = '';
            $d->payee = '';
            $d->payeeid = '0';
            $d->status = 'Cleared';
            $d->tax = '0.00';
            $d->save();
            $tid = $d->id();
            _log('New Deposit: ' . $description . ' [TrID: ' . $tid . ' | Amount: ' . $amount . ']', 'Admin', $user['id']);
            _msglog('s', 'Transaction Added Successfully');
            //now work with invoice
            $i = ORM::for_table('sys_invoices')->where('school_id', $_SESSION['school_id'])->find_one($iid);
            if ($i) {
                
                $i->subtotal = $i['subtotal']-$discount;
                $i->total = $i['total']-$discount;
                $i->save();

                $i = ORM::for_table('sys_invoices')->where('school_id', $_SESSION['school_id'])->find_one($iid);
                $pc = $i['credit'];
                $it = $i['total'];
                $dp = $it - $pc;
                if (($dp == $amount) OR (($dp < $amount))) {
                    $i->status = 'Paid';
                } else {
                    $i->status = 'Partially Paid';
                }
                $i->credit = $pc + $amount;
                $i->paymentmethod = $pmethod;
                $i->ref_no = $pmrefno;
                $i->save();
            }
            echo $tid;
        } else {
            echo '<div class="alert alert-danger fade in">' . $msg . '</div>';
        }

        break;

    case 'export_csv':

        $fileName = 'transactions_'.time().'.csv';

        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-Description: File Transfer');
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename={$fileName}");
        header("Expires: 0");
        header("Pragma: public");

        $fh = @fopen( 'php://output', 'w' );

        $headerDisplayed = false;

        // $results = ORM::for_table('crm_Accounts')->find_array();
        $results = db_find_array('sys_invoices');

        foreach ( $results as $data ) {
            // Add a header row if it hasn't been added yet
            if ( !$headerDisplayed ) {
                // Use the keys from $data as the titles
                fputcsv($fh, array_keys($data));
                $headerDisplayed = true;
            }

            // Put the data into the stream
            fputcsv($fh, $data);
        }
// Close the file
        fclose($fh);



        break;
        
case 'section-by-class':
    $group_id       =   _post('group_id');
    include_once 'sysfrm/school_data_connection.php';
    $customSql      =   "SELECT * FROM `section` WHERE `class_id` = $group_id ";
    $sections       =   get_result_data($customSql);
    $option_value       =   '<option value="">Select Section</option>';
        foreach( $sections as $val ) {
            $option_value       .=  '<option value="'.$val['section_id'].'">'.($val['name'] !=''?$val['name']:'').'</option>';
        }
        echo $option_value;exit;
    break;       

case 'accounts-by-section':
    $section_id       =   _post('section_id');     
    $c = ORM::for_table('crm_accounts')->select('id')->select('account')->where( 'section_id' , $section_id )->order_by_desc('id')->find_many();
    
    if(count($c)>=1) {
        $option_value       =   '<option value="">Select Student...</option>';
        foreach( $c as $key => $val ) {
            $option_value       .=  '<option value="'.$val['id'].'">'.$val['account'].($val['lname'] !=''?$val['lname']:'').'</option>';
        }
    } else {
        $option_value       =   '<option value="">No Students</option>';
    }
        echo $option_value;exit;
    break;

case 'scholarship-reports' :
    
    break;

    default:
        echo 'action not defined';
}
?>