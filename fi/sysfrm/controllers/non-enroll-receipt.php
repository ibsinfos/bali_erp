<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

_auth();
$ui->assign('_sysfrm_menu', 'non-enroll-receipt');
$ui->assign('_title', 'Non Enroll Payment Information '.'- '. $config['CompanyName']);
$ui->assign('_st', 'Non Enroll Payment Information' );
$action = $routes['1'];
$user = User::_info();
$ui->assign('user', $user);
switch ($action) {
    case 'view-list':
        Event::trigger('non-enroll-receipt/view-list/');

        $paginator = array();
        $mode_css = '';
        $mode_js = '';
        $view_type = 'default';
        /*if(route(2) == 'filter'){
            $view_type = 'filter';
            $mode_css = Asset::css('footable/css/footable.core.min');
            $mode_js = Asset::js(array('numeric','footable/js/footable.all.min','contacts/mode_search'));
            $total_invoice = ORM::for_table('sys_invoices')->count();
            $ui->assign('total_invoice',$total_invoice);
            $d = ORM::for_table('sys_invoices')->order_by_desc('id')->find_many();
            //echo '<pre>';print_r($d);die;
            $paginator['contents'] = '';
        }
        else{
            //$ui->assign('xfooter', Asset::js(array('numeric')));
            $mode_js = Asset::js(array('numeric'));
            $paginator = Paginator::bootstrap('sys_invoices');
            $d = ORM::for_table('sys_invoices')->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_many();
        }*/
        //$ui->assign('xfooter', Asset::js(array('numeric')));
        $mode_css = Asset::css('datatable/css/jquery.dataTables.min');
        $mode_js = Asset::js(array('numeric','datatable/js/jquery.dataTables.min'));
        //$paginator = Paginator::bootstrap('sys_invoices1');
        $d = ORM::for_table('sys_invoices1')->where('school_id', $_SESSION['school_id'])->order_by_desc('id')->find_many();
        
        //echo '<pre>';print_r($d);die;
        $ui->assign('_st', 'Non Enroll Payment Information');

        $ui->assign('xheader', $mode_css);
        $ui->assign('xfooter', $mode_js);
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
        ');

        $ui->display('list-non-enroll-payments.tpl');
        break;
    default :
        die("at default");
        break;
}