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
//it will handle all settings
_auth();
$ui->assign('_title', $_L['Settings'].'- '. $config['CompanyName']);
$ui->assign('_pagehead', '<i class="fa fa-cogs lblue"></i> Settings');
$ui->assign('_st', $_L['Settings']);
$ui->assign('_sysfrm_menu', 'installments');

$action = $routes['1'];
$user = User::_info();
$ui->assign('user', $user);
$ui->assign('_user', $user);

$update_server = 'http://dashboard.cloudonex.com/';
// $update_server = 'http://localhost/ibilling/ibilling/';


switch ($action) {
    case 'school_settings':
        $r_year             =   $routes[2];
        
        $running_year       =       date('Y')-1;
        $running_year       =       $running_year."-".date('Y');
        if( $r_year == '' ) {
            $r_year             =       '2017-2018';
        }

        $running_year       =   explode('-', $running_year);
        $ry                 =   array();
        for( $y = $running_year[0]; $y<$running_year[1]+3; $y++ ) {
            $year               =   $y;
            $n_year             =   $y+1;
            $a_y                =   $year."-".$n_year;
            $ry[]               =   $a_y;
        }
        $ui->assign('ry', $ry);
        
        $instalments                =   ORM::for_table('sys_installments')->where('school_id',$_SESSION['school_id'])->where('academic_year',$r_year)->find_many();
        $school_settings            =   ORM::for_table('sys_settings')->where('school_id',$_SESSION['school_id'])->where('academic_year',$r_year)->find_many();
//        print_r($school_settings);die($r_year);
        if(count($school_settings)>=1) {
            foreach($school_settings as $val) {
                $tut_fee_list           = explode(",", $val['schoolfee_inst_types']);
                $tra_fee_list           = explode(",", $val['transfee_inst_types']);
                $hos_fee_list           = explode(",", $val['hostelfee_inst_types']);            
            }
            $school_settings        =   array('id'=>$school_settings[0]['id'],'academic_year'=>$school_settings[0]['academic_year'],'locked'=>$school_settings[0]['locked'],'schoolfee_inst_types'=>$tut_fee_list,'transfee_inst_types'=>$tra_fee_list,'hostelfee_inst_types'=>$hos_fee_list);
        } else {
            $school_settings        =   array('id'=>'','academic_year'=>NULL,'locked'=>'','schoolfee_inst_types'=>array(),'transfee_inst_types'=>array(),'hostelfee_inst_types'=>array());
        }
        
        $ui->assign('installments',$instalments);
        $ui->assign('school_settings',$school_settings);
        $ui->assign('r_year',$r_year);
        $ui->assign('count',1);
        $ui->assign('xfooter', Asset::js(array('numeric','jslib/school-sett')));
        $ui->assign('content_inner',inner_contents($config['c_cache']));
        $ui->display('school-settings.tpl');
        break;
    
    case 'add_school_settings':
        $settings_id                =   $routes[2];
        $academic_year              =   _post('academic_year');
        $tutionfee_installments     =   $_REQUEST['tutionfee_installments'];
        $transpfee_installments     =   $_REQUEST['transpfee_installments'];
        $hostelfee_installments     =   $_REQUEST['hostelfee_installments'];

        $tutionfee_installments     =   (!empty($tutionfee_installments)?implode( "," , $tutionfee_installments ):'');
        $transpfee_installments     =   (!empty($transpfee_installments)?implode( "," , $transpfee_installments ):'');
        $hostelfee_installments     =   (!empty($hostelfee_installments)?implode( "," , $hostelfee_installments):'');

        if($settings_id !='') {
            $d                          =   ORM::for_table('sys_settings')->find_one($settings_id);
            $d->schoolfee_inst_types    =   $tutionfee_installments;
            $d->transfee_inst_types     =   $transpfee_installments;
            $d->hostelfee_inst_types    =   $hostelfee_installments;
			$d->school_id    =   $_SESSION['school_id'];											
            $d->save();
            echo $d->id();exit;
        } else {
            $d                      =   ORM::for_table('sys_settings')->create();
            $d->academic_year       =   $academic_year;
            $d->schoolfee_inst_types    =   $tutionfee_installments;
            $d->transfee_inst_types     =   $transpfee_installments;
            $d->hostelfee_inst_types    =   $hostelfee_installments;
			$d->school_id    =   $_SESSION['school_id'];											
            $d->save();
            echo $d->id();exit;
        }

    break;

    case 'installment_settings':
        
        $installments            =   ORM::for_table('sys_installments')->where('school_id',$_SESSION['school_id'])->find_many();
        $ui->assign('installments',$installments);
        
        $running_year       =   '';
        if($running_year == '') {
            $running_year       =   date('Y')-1;
            $running_year       =   $running_year."-".date('Y');
        }
        $running_year       =   explode('-', $running_year);
        $ry                 =   array();
        for( $y = $running_year[0]; $y<$running_year[1]+3; $y++ ) {
            $year               =   $y;
            $n_year             =   $y+1;
            $a_y                =   $year."-".$n_year;
            $ry[]               =   $a_y;
        }
        $ui->assign('ry', $ry);
        $month      =   array('01'=>'January',
            '02'=>'February',
            '03'=>'March',
            '04'=>'April',
            '05'=>'May',
            '06'=>'June',
            '07'=>'July',
            '08'=>'August',
            '09'=>'Septemper',
            '10'=>'October',
            '11'=>'November',
            '12'=>'December'
            );
        $ui->assign('month',$month);
        $inst =     array('id'=>'','academic_year'=>'','installment_name'=>'','no_of_installment'=>'','start_month'=>'','start_date'=>'','grace_period'=>'','status'=>'');
        $inst_id        =    $routes[2];
        if($inst_id) {
            $inst           =   ORM::for_table('sys_installments')->where('school_id',$_SESSION['school_id'])->where('id',$inst_id)->find_one();
        }

        $ui->assign('inst',$inst);
        $ui->assign('xfooter', Asset::js(array('numeric','jslib/add_inst')));
        $ui->assign('count',1);
        $ui->assign('content_inner',inner_contents($config['c_cache']));
        $ui->display('installments.tpl');
    break;
    
    case 'student_installment':
        if(isset($routes[3]) && $routes[3]!=""){
            $r_year = $routes[3];
        } else {
            $r_year = '';
        }
        $classes    =   ORM::for_table('crm_groups')->select('id')->select('gname')->where('school_id',$_SESSION['school_id'])->order_by_asc('id')->find_many();
        $class = "";        
        $ui->assign( 'classes' , $classes );
        $running_year       =       date('Y')-1;
        $running_year       =       $running_year."-".date('Y');
        if( $r_year == '' ) {
            $r_year             =       '2017-2018';
        }

        $running_year       =   explode('-', $running_year);
        $ry                 =   array();
        for( $y = $running_year[0]; $y<$running_year[1]+3; $y++ ) {
            $year               =   $y;
            $n_year             =   $y+1;
            $a_y                =   $year."-".$n_year;
            $ry[]               =   $a_y;
        }
        $ui->assign('ry', $ry);
        if($routes[2] != "filter"){ 
            $names = ORM::for_table('crm_accounts') ->select_expr("CONCAT_WS(' ', crm_accounts.account,crm_accounts.lname)","Student_name")
                                                ->select("sys_stud_feeconfig.student_id","Student_id")
                                                ->select("sys_items.sales_price","School_fees")
                                                ->_add_join_source('left','sys_stud_feeconfig',array('crm_accounts.id','=','sys_stud_feeconfig.student_id' ))
                                                ->_add_join_source('left','sys_items',array('sys_items.id','=','sys_stud_feeconfig.tution_fee_id' ))
                                                ->where_equal('sys_stud_feeconfig.academic_year',"$r_year")->where('crm_accounts.school_id',$_SESSION['school_id'])->find_many();                                  
            $ui->assign('class_id',""); 
       } else {  
            if($routes[4] != ""){
                $class = $routes[4];
                $names = ORM::for_table('crm_accounts') ->select_expr("CONCAT_WS(' ', crm_accounts.account,crm_accounts.lname)","Student_name")
                                                ->select("sys_stud_feeconfig.student_id","Student_id")
                                                ->select("sys_items.sales_price","School_fees")
                                                ->_add_join_source('left','sys_stud_feeconfig',array('crm_accounts.id','=','sys_stud_feeconfig.student_id' ))
                                                ->_add_join_source('left','sys_items',array('sys_items.id','=','sys_stud_feeconfig.tution_fee_id' ))
                                                ->where_equal('crm_accounts.gid',"$class")
                                                ->where_equal('sys_stud_feeconfig.academic_year',"$r_year")->where('crm_accounts.school_id',$_SESSION['school_id'])->find_many();
            }else{
                $names = ORM::for_table('crm_accounts') ->select_expr("CONCAT_WS(' ', crm_accounts.account,crm_accounts.lname)","Student_name")
                                                ->select("sys_stud_feeconfig.student_id","Student_id")
                                                ->select("sys_items.sales_price","School_fees")
                                                ->_add_join_source('left','sys_stud_feeconfig',array('crm_accounts.id','=','sys_stud_feeconfig.student_id' ))
                                                ->_add_join_source('left','sys_items',array('sys_items.id','=','sys_stud_feeconfig.tution_fee_id' ))
                                                ->where_equal('sys_stud_feeconfig.academic_year',"$r_year")->where('crm_accounts.school_id',$_SESSION['school_id'])->find_many();
            }
            $ui->assign('class_id',$class);  
        }
                
        //echo ORM::get_last_query();exit;
        $inst = array();
        foreach ($names as $k=>$v){
            $inst[$k]['Student_name']= $v->Student_name;
            $inst[$k]['School_fees']= $v->School_fees;
            $d = ORM::for_table('sys_stud_feeconfig') ->select('installment_name','school_inst_name')->select('no_of_installment','school_inst_num')
                            ->_add_join_source('left', 'sys_installments', array('sys_installments.id', '=', 'sys_stud_feeconfig.tutionfee_inst_type'))
                            ->where_equal('sys_stud_feeconfig.student_id',$v->Student_id)->find_one();
            //echo'<pre>';print_r($d);exit;
            //echo ORM::get_last_query();exit;
            $inst[$k]['schoolfee_name'] = $d->school_inst_name;
            $inst[$k]['schoolfee_inst_number'] = $d->school_inst_num;
            $d = ORM::for_table('sys_stud_feeconfig') ->select('installment_name','hostel_inst_name')->select('no_of_installment','hostel_inst_num')
                            ->_add_join_source('left', 'sys_installments', array('sys_installments.id', '=', 'sys_stud_feeconfig.hostfee_inst_type'))
                            ->where_equal('sys_stud_feeconfig.student_id',$v->Student_id)->find_one();
            $inst[$k]['hostelfee_name'] = $d->hostel_inst_name;
            $inst[$k]['hostelfee_inst_number'] = $d->hostel_inst_num;
            $d = ORM::for_table('sys_stud_feeconfig') ->select('installment_name','trans_inst_name')->select('no_of_installment','trans_inst_num')
                            ->_add_join_source('left', 'sys_installments', array('sys_installments.id', '=', 'sys_stud_feeconfig.transpfee_inst_type'))
                            ->where_equal('sys_stud_feeconfig.student_id',$v->Student_id)->find_one();
            $inst[$k]['transportfee_name'] = $d->trans_inst_name;
            $inst[$k]['transportfee_inst_number'] = $d->trans_inst_num;
        }
        //echo '<pre>';print_r($d);exit;
        $result_html    =   '';  
        //echo '<pre>';print_r($inst);exit;
        if($routes[2]=="filter") { 
            if($inst){
                $count = 1;
                foreach ($inst as $key => $value){  
                     $insta_num = $value['schoolfee_inst_number']?' ('.$value['schoolfee_inst_number'].')':'';  
                     $host_inst_num = $value['hostelfee_inst_number']?' ('.$value['hostelfee_inst_number'].')':'';  
                     $trans_inst_num = $value['transportfee_inst_number']?' ('.$value['transportfee_inst_number'].')':'';
                     echo $result_html = '<tr>
                        <td>'.$count++.'</td>
                        <td>'.$value['Student_name'].'</td>
                        <td>'.$value['schoolfee_name'].' '.$insta_num.'<br>'.$value['School_fees'].'</td>
                        <td>'.$value['hostelfee_name'].' '.$host_inst_num.'<br>'.$value['School_fees'].'</td>
                        <td>'.$value['transportfee_name'].' '.$trans_inst_num.'<br>'.$value['School_fees'].'</td>
                    </tr>';
                }die();
            }else{
                echo $result_html    =   '<tr><td colspan="5">No Data Available</td></tr>';die();
            }
        }
        $css_arr = array('datatable/css/jquery.dataTables.min');
        $js_arr = array('datatable/js/jquery.dataTables.min','numeric','jslib/add_inst');

        $ui->assign('xheader', Asset::css($css_arr));
        $ui->assign('xfooter', Asset::js($js_arr));
        $ui->assign('acad_year',$r_year);        
        $ui->assign('inst',$inst);
        //$ui->assign('xfooter', Asset::js(array()));
        $ui->assign('count',1);
        $ui->assign('content_inner',inner_contents($config['c_cache']));
        $ui->display('student_installments.tpl');
    break;
    
    case 'add_newinstallment':
        $academic_year          =   _post('academic_year');
        $instalment_name        =   _post('instalment_name');
        $no_of_installment      =   _post('no_of_installment');
        $start_month            =   _post('start_month');
        $start_date             =   _post('start_date');
        $grace_period           =   _post('grace_period');
        
        $msg                    =   '';
        
        if($instalment_name == '' || $no_of_installment == '' || $start_date == '' || $grace_period == '') {
            $msg                .=   'All Fields are Required<br>';
        } else if ( !is_numeric($start_date)) {
            $msg                .=   'Start Date is not valid<br>';
        } else if ( $start_date > 31 ) {  
            $msg                .=   'Start Date is not valid<br>';
        } else if ( !is_numeric($grace_period) || strlen($grace_period)>2) {
            $msg                .=   'Grace period is not valid,2 Digits Only Allowed.<br>';
        }
        
        if(!is_numeric($no_of_installment) || $no_of_installment>12) {
            $msg                .=   'No of Installment is not valid, Not greater than 12.<br>';
        }
        
        $inst_id        =    $routes[2];
        if($inst_id !='') {
            $inst           =   ORM::for_table('sys_installments')->where('academic_year',$academic_year)->where('school_id',$_SESSION['school_id'])->where('no_of_installment',$no_of_installment)->where_not_equal('id',$inst_id)->find_one();
        } else {
            $inst           =   ORM::for_table('sys_installments')->where('academic_year',$academic_year)->where('school_id',$_SESSION['school_id'])->where('no_of_installment',$no_of_installment)->find_one();
        }
        if($inst) { 
            $msg        .=   'Installment '.$no_of_installment.' Already Added for '.$academic_year.'<br>';
        }

        if($msg == '') {
            if($inst_id != '') {
                $e                      =   ORM::for_table('sys_installments')->where('school_id',$_SESSION['school_id'])->find_one($inst_id);
                $e->academic_year       =   $academic_year;
                $e->installment_name    =   $instalment_name;
                $e->no_of_installment   =   $no_of_installment;
                $e->start_month         =   $start_month;
                $e->start_date          =   $start_date;
                $e->grace_period        =   $grace_period;
                $e->created_by          =   '';
                $e->created_date        =   '';
                $e->ip_address          =   '';
                $e->save();
                echo $e->id();die();
            } else {
                $e                      =   ORM::for_table('sys_installments')->where('school_id',$_SESSION['school_id'])->create();
                $e->academic_year       =   $academic_year;
                $e->installment_name    =   $instalment_name;
                $e->no_of_installment   =   $no_of_installment;
                $e->start_month         =   $start_month;
                $e->start_date          =   $start_date;
                $e->grace_period        =   $grace_period;
                $e->created_by          =   '';
                $e->created_date        =   '';
                $e->status              =   '';
                $e->ip_address          =   '';
				$e->school_id          =   $_SESSION['school_id'];												  
                $e->save();
                echo $e->id();die();
            }
        } else {
            echo $msg;exit;
        }
    break;
    
    case 'installment_status' :
        $status             =       _post('status');
        if($status == '1')
            $status         =       '0';
        else 
            $status         =       '1';
        $inst_id            =       $routes[2];
        $e                  =       ORM::for_table('sys_installments')->where('school_id',$_SESSION['school_id'])->find_one($inst_id);
        $e->status          =       $status;
        $e->save();
        echo $e->id();die();
    break;
    
    default:
        echo 'action not defined';
}