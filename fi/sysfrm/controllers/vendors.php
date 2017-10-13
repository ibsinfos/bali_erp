<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

_auth();
$ui->assign('_sysfrm_menu', 'fee-deductions');
$ui->assign('_title', 'Vendors'.'- '. $config['CompanyName']);
$ui->assign('_st', 'Vendors' );
$action = $routes['1'];
$user = User::_info();
$ui->assign('user', $user);
switch ($action) {
    case 'list':
        Event::trigger('vendors/list/');

        $paginator = array();
        $mode_css = '';
        $mode_js = '';
        $view_type = 'default';
    
        $mode_css = Asset::css('datatable/css/jquery.dataTables.min');
        $mode_js = Asset::js(array('numeric','datatable/js/jquery.dataTables.min'));
        $paginator = Paginator::bootstrap('sys_vendors');
        $vendors = ORM::for_table('sys_vendors')->where('school_id',$_SESSION['school_id'])->order_by_asc('name')->find_many();
        //echo '<pre>';print_r($scholarships);exit;
        $ui->assign('_st', 'Scholarship');
        $ui->assign('xheader', $mode_css);
        $ui->assign('xfooter', $mode_js);
        $ui->assign('view_type', $view_type);
        $ui->assign('vendors', $vendors);
        $ui->assign('count',1);
        $ui->assign('paginator', $paginator);
        $ui->display('vendors.tpl');
        break;
    
    case 'add':

        Event::trigger('vendors/add/');
        $paginator = array();
        $mode_css = '';
        $mode_js = '';
        $view_type = 'default';

        if(isset($_POST) && !empty($_POST)){
            //echo '<pre>';print_r($_POST);exit;
            $_id                   =   _post('vendor_id');
            $name                   =   _post('name');
            $description          =   _post('description');
            $school_id              =   $_SESSION['school_id'];
            
            $msg                    =   '';
            if($name == '') {
                $msg .= 'Vendor Name ia required <br>';
            }

            if($msg == '') {
                if($_id != '') {
                    $d = ORM::for_table('sys_vendors')->find_one($_id);
                    $d->updated    =   date('Y-m-d H:i:s');
                    _msglog('s','Vendor Updated Successfully!');
                } else {
                    $d = ORM::for_table('sys_vendors')->create();
                    $d->created    =   date('Y-m-d H:i:s');
                    _msglog('s','Vendor Added Successfully!');
                }
                $d->name = $name;
                $d->description   =   $description;
                $d->school_id      =   $school_id;
                $d->save();

                echo $d->id();exit;
            }else{
                echo $msg;exit;
            }
        }

        $vendor        =   array('id'=>'','name'=>'','description'=>'');
        $ui->assign('vendor',$vendor);
        
        $mode_js = Asset::js(array('jslib/vendor'));
        //$ui->assign('_st', 'vendor');

        $ui->assign('xheader', $mode_css);
        $ui->assign('xfooter', $mode_js);
        $ui->assign('view_type', $view_type);

        //echo $config['currency_code'];exit;
        $ui->display('add-vendor.tpl');
        break;

    case 'edit':
        
        Event::trigger('vendors/edit/');

        $paginator = array();
        $id         =   $routes['2'];
        $mode_css = '';
        $mode_js = '';
        $view_type = 'default';
        
        $vendor = ORM::for_table('sys_vendors')->find_one($id);
        $ui->assign('vendor',$vendor);
        $mode_js = Asset::js(array('jslib/vendor'));
        $ui->assign('_st', 'Vendor');

        $ui->assign('xheader', $mode_css);
        $ui->assign('xfooter', $mode_js);
        $ui->assign('view_type', $view_type);
        $ui->display('add-vendor.tpl');
    break;

    case 'delete': 
        $vendor_id           =   _post('vendor_id');  
        if($vendor_id != '') {
            //$d = ORM::for_table('sys_vendors')->where('id',$vendor_id)->delete(); 
            $d = ORM::for_table('sys_vendors')->find_one($vendor_id);
            $d->delete();
            //_msglog('s',"Item Canceled Successfully.");
            echo 'Vendor Deleted Successfully!.';exit;
        }
        break;
    default :
        die("at default");
        break;
}