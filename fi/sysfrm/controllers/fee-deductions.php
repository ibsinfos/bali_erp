<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

_auth();
$ui->assign('_sysfrm_menu', 'fee-deductions');
$ui->assign('_title', 'Scholarship'.'- '. $config['CompanyName']);
$ui->assign('_st', 'Scholarship' );
$action = $routes['1'];
$user = User::_info();
$ui->assign('user', $user);
switch ($action) {
    case 'view-list':
        Event::trigger('fee-deductions/view-list/');

        $paginator = array();

        $mode_css = '';
        $mode_js = '';
        $view_type = 'default';
    
        $mode_css = Asset::css('datatable/css/jquery.dataTables.min');
        $mode_js = Asset::js(array('numeric','datatable/js/jquery.dataTables.min'));
        $paginator = Paginator::bootstrap('sys_scholarship');
        $scholarships = ORM::for_table('sys_scholarship')->where('school_id',$_SESSION['school_id'])
                        ->where_not_equal('status','3')
                        ->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_asc('id')->find_many();
        //echo '<pre>';print_r($scholarships);exit;
        $ui->assign('_st', 'Scholarship');
        $ui->assign('xheader', $mode_css);
        $ui->assign('xfooter', $mode_js);
        $ui->assign('view_type', $view_type);
        $ui->assign('scholarship_types', $scholarships);
        $ui->assign('count',1);
        $ui->assign('paginator', $paginator);
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
        $ui->display('fee-deductions.tpl');
        break;
    
    case 'ss-students-list':
        
        Event::trigger('fee-deductions/ss-student-list/');
        $mode_css = '';
        $mode_js = '';

        $paginator = Paginator::bootstrap('crm_accounts');
        $classes    =   ORM::for_table('crm_groups')->select('id')->select('gname')->where('school_id',$_SESSION['school_id'])->order_by_asc('id')->find_many();
        $group_id = $classes[0]['id'];  
        $ui->assign( 'classes' , $classes );
        $scholarships    =   ORM::for_table('sys_scholarship')->select('id')->select('scholarship_name')->where('school_id',$_SESSION['school_id'])->order_by_asc('id')->find_many();
        //echo ORM::get_last_query();exit;
        $scholarship_id = $scholarships[0]['id'];  
        $ui->assign( 'scholarships' , $scholarships );
        $class_id       =   route(3);//_post('class_id');
        $scholarship_id =   route(4);//_post('scholarship_id');
        $b_url          =   _post('b_url');
        $count = 1;
//        echo $scholarship_id;die();
        $ui->assign( 'class_id' , $class_id );
        $ui->assign( 'scholarship_id' , $scholarship_id );
        
        $action         =   route(2);
        if($action == 'filter') {
            $load_page      =   'ajax';
        } else {
            $load_page      =   '';
        }
//        print_r($scholarships);die();
        if( $load_page == 'ajax' ){
            if(!$class_id && !$scholarship_id) {
                $d = ORM::for_table('crm_accounts')->select('sys_invoices.*')->select_many('sys_scholarship.scholarship_name','sys_scholarship.deduction_type','sys_scholarship.deduction_value')
                    ->_add_join_source('','sys_invoices',array('sys_invoices.userid','=','crm_accounts.id'))
                    ->_add_join_source('','sys_scholarship',array('sys_invoices.scholarship_id','=','sys_scholarship.id'))
                    ->where_not_equal('sys_invoices.scholarship_id',0)->where('crm_accounts.school_id',$_SESSION['school_id'])
                    ->order_by_desc('id')->group_by('crm_accounts.id')->find_many(); 
            }
            if($class_id) {
                $group_id   =   $class_id;
                $d = ORM::for_table('crm_accounts')->select('sys_invoices.*')->select_many('sys_scholarship.scholarship_name','sys_scholarship.deduction_type','sys_scholarship.deduction_value')
                        ->_add_join_source('','sys_invoices',array('sys_invoices.userid','=','crm_accounts.id'))
                        ->_add_join_source('','sys_scholarship',array('sys_invoices.scholarship_id','=','sys_scholarship.id'))
                        ->where_equal('crm_accounts.gid',$group_id)->where('crm_accounts.school_id',$_SESSION['school_id'])
                        ->where_not_equal('sys_invoices.scholarship_id',0)
                        ->order_by_desc('id')->group_by('crm_accounts.id')->find_many();
            }
            if($scholarship_id) {
                if($class_id != ""){
                    $d = ORM::for_table('crm_accounts')->select('sys_invoices.*')->select_many('sys_scholarship.scholarship_name','sys_scholarship.deduction_type','sys_scholarship.deduction_value')
                            ->_add_join_source('','sys_invoices',array('sys_invoices.userid','=','crm_accounts.id'))
                            ->_add_join_source('','sys_scholarship',array('sys_invoices.scholarship_id','=','sys_scholarship.id'))
                            ->where_equal('crm_accounts.gid',$group_id)->where('crm_accounts.school_id',$_SESSION['school_id'])
                            ->where_equal('sys_invoices.scholarship_id',$scholarship_id)
                            ->order_by_desc('id')->group_by('crm_accounts.id')->find_many();
                } else{
                    $d = ORM::for_table('crm_accounts')->select('sys_invoices.*')->select_many('sys_scholarship.scholarship_name','sys_scholarship.deduction_type','sys_scholarship.deduction_value')
                        ->_add_join_source('','sys_invoices',array('sys_invoices.userid','=','crm_accounts.id'))
                        ->_add_join_source('','sys_scholarship',array('sys_invoices.scholarship_id','=','sys_scholarship.id'))
                        ->where_equal('sys_invoices.scholarship_id',$scholarship_id)->where('crm_accounts.school_id',$_SESSION['school_id'])
                        ->order_by_desc('id')->group_by('crm_accounts.id')->find_many();
                }
            }
    
            ////////////////////Student list for ajax call start///////////////////////////
            $result_html    =   '';
  
//            if(count($d)>0){
//                foreach($d as $ds){
//                    if($ds['deduction_type'] == 2){
//                        $deduction_type = "Percentage";
//                    } else if($ds['deduction_type'] == 1) {
//                        $deduction_type = "Amount";
//                    }
//                    echo $result_html = '<tr>
//                                            <td><a href="'.$b_url.'contacts/view/'.$ds['id'].'/">'.$ds['id'].'</a></td>
//                                            <td><a href="'.$b_url.'contacts/view/'.$ds['id'].'/">'.$ds['account'].'</a> </td>
//                                            <td>'.$ds['scholarship_name'].'</td>
//                                            <td>'.$deduction_type .'</td>
//                                            <td>'.$ds['deduction_value'].'</td>
//                                            <td class="text-right">
//                                                <a href="'.$b_url.'contacts/view/'.$ds['id'].'/" class="btn btn-primary btn-xs"><i class="fa fa-search"></i>'. $_L['View'].'</a>
//                                            </td>
//                                    </tr>';
//                }
//                die();
//            } else {
//                echo $result_html    =   '<tr><td colspan="6">No Data Available</td></tr>';die();
//            }
        }else{
             $d = ORM::for_table('crm_accounts')->select('sys_invoices.*')->select_many('sys_scholarship.scholarship_name','sys_scholarship.deduction_type','sys_scholarship.deduction_value')
                    ->_add_join_source('','sys_invoices',array('sys_invoices.userid','=','crm_accounts.id'))
                    ->_add_join_source('','sys_scholarship',array('sys_invoices.scholarship_id','=','sys_scholarship.id'))
                    ->where_not_equal('sys_invoices.scholarship_id',0)->where('crm_accounts.school_id',$_SESSION['school_id'])
                    ->order_by_desc('id')->group_by('crm_accounts.id')->find_many();
        }
        $mode_css = Asset::css(array('datatable/css/jquery.dataTables.min'));
        $mode_js = Asset::js(array('datatable/js/jquery.dataTables.min',$_theme. '/lib/list-contacts'));
        
        $ui->assign('count',$count);
        $ui->assign('d',$d);
        $ui->assign('paginator',$paginator);
        $ui->assign('xheader', $mode_css);
        $ui->assign('xfooter', $mode_js.'<script type="text/javascript" src="' . $_theme . '/lib/list-contacts.js"></script>');
        $ui->assign('jsvar', '_L[\'are_you_sure\'] = \''.$_L['are_you_sure'].'\';');
        $ui->display('ss-students-list.tpl');
        break;
        
    case 'add-deduction':

        Event::trigger('fee-deductions/add-deduction/');

        $paginator = array();

        $mode_css = '';
        $mode_js = '';
        $view_type = 'default';
        
        $running_year       =   $_SESSION['running_year'];
        if($running_year == '') {
            $running_year       =   date('Y')-1;
            $running_year       =   $running_year."-".date('Y');
        }
        $running_year       =   explode('-', $running_year);
        $ry                 =   array();
        for( $y = $running_year[0]; $y<$running_year[1]+3; $y++ ) {
            $year       =   '';
            $n_year     =   '';
            $year       =   $y."-";
            $n_year     =   $y+1;
            $year       =   $year.$n_year;
            $ry[]       =   $year;
        }
        $ui->assign('ry', $ry);
        $ded        =   array('id'=>'','academic_year'=>'','scholarship_name'=>'','deduction_type'=>'','deduction_value'=>'');
        $ui->assign('ded',$ded);
        
        $mode_js = Asset::js(array('numeric','jslib/add-ded'));
            //echo '<pre>';print_r($d);die;
        $ui->assign('_st', 'Scholarship');

        $ui->assign('xheader', $mode_css);
        $ui->assign('xfooter', $mode_js);
        $ui->assign('view_type', $view_type);
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
        $ui->assign('config', array('currency_code'=>$config['currency_code'],'dec_point'=>$config['dec_point'],'thousands_sep'=>$config['thousands_sep']));
        //echo $config['currency_code'];exit;
        $ui->display('add-deduction.tpl');
        break;
    case 'edit':
        
        Event::trigger('fee-deductions/edit/');

        $paginator = array();
        $id         =   $routes['2'];
        $mode_css = '';
        $mode_js = '';
        $view_type = 'default';
        
        $running_year       =   $_SESSION['running_year'];
        if($running_year == '') {
            $running_year       =   date('Y')-1;
            $running_year       =   $running_year."-".date('Y');
        }
        $running_year       =   explode('-', $running_year);
        $ry                 =   array();
        
        for( $y = $running_year[0]; $y<$running_year[1]+3; $y++ ) {
            $year       =   '';
            $n_year     =   '';
            $year       =   $y."-";
            $n_year     =   $y+1;
            $year       =   $year.$n_year;
            $ry[]       =   $year;
        }
        $ui->assign('ry', $ry);
        $ded    =   ORM::for_table('sys_scholarship')->find_one($id);
        $ui->assign('ded',$ded);
        $mode_js = Asset::js(array('numeric','jslib/add-ded'));
            //echo '<pre>';print_r($d);die;
        $ui->assign('_st', 'Scholarship');

        $ui->assign('xheader', $mode_css);
        $ui->assign('xfooter', $mode_js);
        $ui->assign('view_type', $view_type);
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
        $ui->display('add-deduction.tpl');
    break;
    case 'add-post':
        $name                   =   _post('name');
        $discount_type          =   _post('discount_type');
        $discount_value         =   _post('discount_value');
        $academic_year          =   _post('academic_year');
        $deduction_id           =   _post('deduction_id');
        $msg                    =   '';
        $school_id              =   $_SESSION['school_id'];
        
        if($academic_year =='') {
            $msg .= 'Academic year is Required <br>';
        }
        if($name == ''){
            $msg .= 'Scholarship Name is Required <br>';
        }

        if($discount_value =='') {
            $msg .= 'Discount Value is Required <br>';
        } else {
            if(!is_numeric($discount_value) || strlen($discount_value) > 10) {
                if($discount_type == 2) {
                    $msg .= 'Discount Percentage Should Be Numeric,Discount percentage should not be more than 100%.<br>';
                } else {
                    $msg .= 'Discount Value Should Be Numeric,Less than 10 Digit <br>';
                }
            }
        }
        
        if($discount_type == 2) {
            if($discount_value > 100) {
                $msg .= 'Discount percentage should not be more than 100%.<br>';
            }
        }
        
        if($msg == '') {
            if($deduction_id != '') {
                $d = ORM::for_table('sys_scholarship')->find_one($deduction_id);
                $d->scholarship_name=   $name;
                $d->deduction_type   =   $discount_type;
                $d->deduction_value  =   $discount_value;
                $d->academic_year   =   $academic_year;
                $d->created_date    =   date('Y-m-d');
                $d->status          =   1;
                $d->created_by      =   '0';
                $d->save();
                _msglog('s','Item Updated Successfully');

                echo $d->id();
            } else {
                $d = ORM::for_table('sys_scholarship')->create();
                $d->scholarship_name=   $name;
                $d->deduction_type   =   $discount_type;
                $d->deduction_value  =   $discount_value;
                $d->academic_year   =   $academic_year;
                $d->created_date    =   date('Y-m-d');
                $d->status          =   1;
                $d->created_by      =   '0';
                $d->school_id      =   $school_id;
                $d->save();
                _msglog('s',$_L['Item Added Successfully']);

                echo $d->id();
            }
        } else {
            echo $msg;
        }
        
        break;
        
    case 'cancel_deduction': 
        $ded_id           =   _post('ded_id');  
        if($ded_id != '') {
            $d = ORM::for_table('sys_scholarship')->find_one($ded_id); 
            //echo ORM::get_last_query();exit;
            $d->status          =   3;
            $d->save();
            //_msglog('s',"Item Canceled Successfully.");
            echo 'Item Canceled Successfully.';exit;
        }
        break;
    default :
        die("at default");
        break;
}