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
$ui->assign('_sysfrm_menu', 'contacts');
$ui->assign('_st', $_L['Search']);
$ui->assign('_title', $_L['Accounts'].'- '. $config['CompanyName']);
$action = $routes['1'];
$user = User::_info();
$ui->assign('user', $user);
switch ($action) {

    case 'ps': 
        $type = _post('stype');
        $name = _post('txtsearch');
        $fee_type = _post('fee_type');
        if($fee_type == ""){
            $fee_types = ORM::for_table('fee_types')->where('status',1)->order_by_desc('id')->find_many();
            $fee_type      =   $fee_types[0]->id;
        }
        if($type == 'Product'){
            $d = ORM::for_table('sys_items')->select('sys_items.*')->select('fee_types.name','type_name')->_add_join_source('left','fee_types',array('sys_items.fee_type','=','fee_types.id'))->where('sys_items.school_id',$_SESSION['school_id'])->
                where('sys_items.type',$type)
                ->where_equal('fee_types.id',"$fee_type")    
                ->where_like('sys_items.name',"%$name%")->order_by_asc('sys_items.name')->find_many();
        } else {
            $d = ORM::for_table('sys_items')->select('sys_items.*')->select('fee_types.name','type_name')->_add_join_source('left','fee_types',array('sys_items.fee_type','=','fee_types.id'))->where('sys_items.school_id',$_SESSION['school_id'])->
                where('sys_items.type',$type)
                ->where_equal('fee_types.id',"$fee_type") 
                ->where_like('sys_items.name',"%$name%")->order_by_asc('sys_items.name')->find_many();
        } 
        
if($d){ 
    if($type == 'Product'){
        foreach($d as $key=>$val) {
            $group_ids          =   explode(',', $val['group_id']);
            $g_names            =   '';
            foreach($group_ids as $gid) {
                $group          =   ORM::for_table('crm_groups')->select('*')->where('school_id',$_SESSION['school_id'])->where('id',$gid)->find_one();
                $g_names        .=   $group['gname'].",";
            }
            $g_names            =   rtrim($g_names,',');
            $d[$key]['g_name']        =   $g_names;
        }
    }
    
    
    $header= '<table id="dt_table" class="table datatable table-bordered table-hover sys_table footable">
        <thead>
        <tr>
            <th>Fee Label</th>
            '.($type == 'Product'?'<th>Class</th>':'').'
            <th>Amount</th><th>Academic Year</th>';
    if($type=='OneTimeFeeBeforeAdmission')
        $header.='<th>Enquery Fees Options</th>';
    $header.='<th>Action</th>
        </tr></thead><tbody>
        ';
    echo $header;

    foreach ($d as $ds){ 
        $price = number_format($ds['sales_price'],2,$config['dec_point'],$config['thousands_sep']);
        $tr=' <tr>

                <td class="project-title">
                    <a href="#" class="cedit"  id="t'.$ds['id'].'">'.$ds['name'].'</a>
                    
                </td>
                '.($type == 'Product'?'<td>'.($ds['g_name']?$ds['g_name']:'All Class').'</td>':'').'
                <td>'.$price.'

                </td><td class="project-title">'.$ds['academic_year'].'</td>';
         if($type == 'OneTimeFeeBeforeAdmission'){
             echo $ds['optional_for_enquery'];
             if($ds['optional_for_enquery']==0)
                $tr.=' <td class="project-actions">Optional</td>';
             else
                 $tr.=' <td class="project-actions">Mandatory</td>';
         }       
        
         $tr.=' <td class="project-actions">

                    <a href="#" class="btn btn-primary btn-sm cedit" mypagechange="aa" id="e'.$ds['id'].'"><i class="fa fa-pencil"></i> '.$_L['Edit'].' </a>
                    <a href="#" class="btn btn-danger btn-sm cdelete" id="pid'.$ds['id'].'"><i class="fa fa-trash"></i> '.$_L['Delete'].' </a>
                </td>
            </tr>';
         echo $tr;
    }


    echo '
        </tbody>
    </table>';
}
else{
    echo '<h4>Data Not Found</h4>';
}

        break;


    case 'users':
echo '<table class="table table-bordered table-hover trclickable">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Access Level</th>
                    <th>Active</th>
                </tr>
                </thead>
                <tbody>
                <tr id="_tr120">
                    <td>1</td>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td><div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" class="onoffswitch-checkbox" data-on-text="Yes">
                                <label class="onoffswitch-label" for="fixednavbar">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div></td>
                </tr>

                </tbody>
            </table>';
        break;

    default:
        echo 'action not defined';
}