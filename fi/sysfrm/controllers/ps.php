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
$ui->assign('_sysfrm_menu', 'ps');
$ui->assign('_title', 'Fees & Charges'.'- '. $config['CompanyName']);
$ui->assign('_st', 'Fees & Charges' );
$action = $routes['1'];
$user = User::_info();
$ui->assign('user', $user);
switch ($action) {

    case 'modal-list':
        /* Modification for fms*/
        if($routes['2'] != '') {
            $group_id      =    $routes['2'];
        }
        if($group_id) {
            $d1 = ORM::for_table('sys_items')
            ->_add_join_source( 'left' , 'crm_groups' , array( 'sys_items.group_id' , '=' , 'crm_groups.id' ) )
            ->where( 'sys_items.group_id' , $group_id )->where_not_equal('fee_type',4)->order_by_asc('name')->find_many();
            $d2 = ORM::for_table('sys_items')
            ->_add_join_source( 'left' , 'crm_groups' , array( 'sys_items.group_id' , '=' , 'crm_groups.id' ) )
            ->where( 'sys_items.type' , 'service' )->order_by_asc('name')->find_many();
            
        } else {
            $d = ORM::for_table('sys_items')
                ->_add_join_source( 'left' , 'crm_groups' , array( 'sys_items.group_id' , '=' , 'crm_groups.id' ) )
                ->order_by_asc('name')->find_many();
        } //$_L['Fee n Charges']
                echo '
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>Fee n Charges</h3>
        </div>
        <div class="modal-body">

        <table class="table table-striped" id="items_table">
              <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="15%">'.$_L['Item Code'].'</th>
                    <th width="55%">'.$_L['Item Name'].'</th>
                    <th width="15%">'.$_L['Price'].'</th>
                    <th width="10%">Class</th>
                </tr>
              </thead>
              <tbody>
               ';

                if($group_id) {
                        foreach($d1 as $ds){
                           $price = number_format($ds['sales_price'],2,$config['dec_point'],$config['thousands_sep']);
                            echo ' <tr>
                            <td><input type="checkbox" class="si"></td>
                            <td>'.$ds['item_number'].'</td>
                            <td>'.$ds['name'].'</td>
                            <td class="price">'.$price.'</td>
                            <td>'.$ds['gname'].'</td>
                        </tr>';
                        }
                        foreach($d2 as $ds){
                           $price = number_format($ds['sales_price'],2,$config['dec_point'],$config['thousands_sep']);
                            echo ' <tr>
                            <td><input type="checkbox" class="si"></td>
                            <td>'.$ds['item_number'].'</td>
                            <td>'.$ds['name'].'</td>
                            <td class="price">'.$price.'</td>
                            <td>'.$ds['gname'].'</td>
                        </tr>';
                        }
                } else {
                    foreach($d as $ds){
                           $price = number_format($ds['sales_price'],2,$config['dec_point'],$config['thousands_sep']);
                            echo ' <tr>
                            <td><input type="checkbox" class="si"></td>
                            <td>'.$ds['item_number'].'</td>
                            <td>'.$ds['name'].'</td>
                            <td class="price">'.$price.'</td>
                            <td>'.$ds['gname'].'</td>
                        </tr>';
                        }
                }

                        echo '

                      </tbody>
                    </table>

                </div>
                <div class="modal-footer">

                        <button type="button" data-dismiss="modal" class="btn">'.$_L['Close'].'</button>
                        <button class="btn btn-primary update">'.$_L['Select'].'</button>
                </div>';
        

        break;


    case 'p-new':
        $groups             =   ORM::for_table('crm_groups')->select('id')->select('gname')->where('school_id',$_SESSION['school_id'])->order_by_asc('sorder')->find_many();
        $ui->assign('groups', $groups);
        $ftypes             =   ORM::for_table('fee_types')->where('status',1)->find_many();
        $ui->assign('ftypes', $ftypes);      
        $running_year       =   $_SESSION['running_year'];
        if($running_year == '') {
            $running_year       =   date('Y')-1;
            $running_year       =   $running_year."-".date('Y');
        }
        $running_year       =   explode('-', $running_year);
        $ry                 =   array();
        for( $y = $running_year[0]; $y<$running_year[1]+3; $y++ ) {
            $ry[]                 =   $y;
        }
        $ui->assign('ry', $ry);
        $ui->assign('type','Product');
        $css_arr = array('s2/css/select2.min','modal','dp/dist/datepicker.min','redactor/redactor');
        $js_arr = array('redactor/redactor.min','numeric','jslib/add-ps','s2/js/select2.min','s2/js/i18n/'.lan(),'dp/dist/datepicker.min','dp/i18n/'.$config['language'],'numeric','modal',$js_file);

        $ui->assign('xheader', Asset::css($css_arr));
        $ui->assign('xfooter', Asset::js($js_arr));

        $ui->assign('xjq', '
 $(\'.amount\').autoNumeric(\'init\');
 ');
        $max = ORM::for_table('sys_items')->max('id');
        $nxt = $max+1;
        $ui->assign('nxt',$nxt);
        $ui->display('add-ps.tpl');
    break;

    case 's-new':
        $ui->assign('type','Service');
        $ui->assign('xfooter', Asset::js(array('numeric','jslib/add-ps')));

        $ui->assign('xjq', '
 $(\'.amount\').autoNumeric(\'init\');
 ');

        $max = ORM::for_table('sys_items')->max('id');
        $nxt = $max+1;
        $ftypes             =   ORM::for_table('fee_types')->where('status',1)->find_many();
        $ui->assign('ftypes', $ftypes);      
        $running_year       =   $_SESSION['running_year'];
        if($running_year == '') {
            $running_year       =   date('Y')-1;
            $running_year       =   $running_year."-".date('Y');
        }
        $running_year       =   explode('-', $running_year);
        $ry                 =   array();
        for( $y = $running_year[0]; $y<$running_year[1]+3; $y++ ) {
            $ry[]                 =   $y;
        }
        $ui->assign('ry', $ry);
        $ui->assign('type','Service');
        
        $ui->assign('nxt',$nxt);
        $ui->display('add-ps.tpl');
        break;


    case 'add-post':
        $name                   =   _post('name');
        $sales_price            =   _post('sales_price');
        
        
        $academic_year          =   _post('academic_year');
        $fee_start_date         =   _post('fee_start_date');
        $fee_due_date           =   _post('fee_due_date');
        $fee_type               =   _post('fee_type');
        
        $item_number            =   _post('item_number');
        $description            =   _post('description');
        $optional_for_enquery   =   _post('optional_for_enquery');
        $scholarship_active     =   _post('scholarship_active');
        $school_id              =   $_SESSION['school_id'];
        
        $type                   =   _post('type');
        if($type=="Product"){
            $group_id               =   $_POST['group_id'];//_post('group_id');
            $group_id               =   implode(',', $group_id);
            //echo '<pre>';print_r($group_id);die;
            //$group_id               =   $_REQUEST['group_id'];
            $scholarship_active     =   $scholarship_active;
        }else{
            $group_id                   =   0;
            $scholarship_active         =   0;
        }
        
        if($optional_for_enquery==""){
            $optional_for_enquery=0;
        }
        $msg='';
        if($name == ''){
            $msg .= 'Item Name is required <br>';
        }
        if($sales_price =='') {
            $msg .= 'Fee Amount is required <br>';
        }
        
        if( $type == 'Product') {
            //echo '<pre>';print_r($group_id);die;
            if(empty($group_id) && $group_id!='0')
                $msg .= 'Class is required <br>';
        }
        
//        if( $type == 'Product') {
//            $running_year           =   $_SESSION['running_year'];
//            $school_perfomance      =   ORM::for_table('sys_perfomancesettings')->where( 'running_year' , $running_year )->where( 'active' , '1' )->find_one();
//            if(!$school_perfomance) {
//                $msg                .=  'Set school perfomance for year '.$running_year;
//            } else {
//                if($school_perfomance->value != '') {
//                    $sales_price        =   $sales_price * $school_perfomance->value;
//                } else {
//                    $sales_price        =   $sales_price;
//                }
//            }
//            
//        } else {
//            $sales_price            =   $sales_price;
//        }
        
        
        $sales_price            =   Finance::amount_fix($sales_price);
        if(!is_numeric($sales_price)){
            $sales_price = '0.00';
        }
        
        $has_rec = ORM::for_table('sys_items')->where('group_id',$group_id)->where('fee_type',$fee_type)->where('academic_year',$academic_year)->where('school_id',$school_id)->count();
        if($has_rec){
            $msg .= 'Fee already added <br>';
        }
        if($msg == ''){
            //echo "here";die();
            //echo '$type : '.$type;
            $d = ORM::for_table('sys_items')->create();
            $d->name            =   $name;
            $d->sales_price     =   $sales_price;
            $d->item_number     =   $item_number;
            $d->description     =   $description;
            $d->type            =   $type;
            $d->group_id        =   $group_id;
            $d->scholarship_active  =   $scholarship_active;
//new
            $d->academic_year   =   $academic_year;
            $d->fee_starting_date  = $fee_start_date;
            $d->fee_due_date    =   $fee_due_date;
            $d->fee_type        =   $fee_type;
//others
            $d->unit = '5';
            $d->optional_for_enquery = $optional_for_enquery;
            $d->e = '';
            $d->school_id = $school_id;
            //echo '<pre>';print_r($d);die;
            $d->save();
            //echo '<pre>';print_r($d);die;
            //_msglog('s',$_L['Item Added Successfully']);
            if($type=='Product' && $fee_type!=1)
                _msglog('s','Fee Added Successfully');
            else if($type == 'Service') 
                _msglog('s','Charges Added Successfully');
            else
                _msglog('s','One time Enqeury Fees Added Successfully');
            
            echo $d->id();
        }else{
            echo $msg;
        }
        break;

    case 'view':
//        $id  = $routes['2'];
//        $d = ORM::for_table('sys_items')->find_one($id);
//        if($d){
//
//            //find all activity for this user
//            $ac = ORM::for_table('sys_activity')->where('cid',$id)->limit(20)->order_by_desc('id')->find_many();
//            $ui->assign('ac',$ac);
//            $ui->assign('countries',Countries::all($d['country']));
//
//            $ui->assign('xheader', '
//<link rel="stylesheet" type="text/css" href="' . $_theme . '/lib/select2/select2.css"/>
//
//');
//            $ui->assign('xfooter', '
//<script type="text/javascript" src="' . $_theme . '/lib/select2/select2.min.js"></script>
//<script type="text/javascript" src="' . $_theme . '/lib/profile.js"></script>
//
//');
//
//            $ui->assign('xjq', '
// $("#country").select2();
//
// ');
//            $ui->assign('d',$d);
//            $ui->display('ps-view.tpl');
//
//        }
//        else{
//         //   r2(U . 'customers/list', 'e', $_L['Account_Not_Found']);
//
//        }

        break;

    case 'p-list':  
        $selected_fee_type        =   $routes['2'];
        $fee_types = ORM::for_table('fee_types')->where('status',1)->order_by_asc('id')->find_many();
        if( $selected_fee_type == '') {
            $selected_fee_type      =   $fee_types[0]->id;
        }
        $ui->assign('selected_fee_type',$selected_fee_type);
        $ui->assign('fee_types',$fee_types);
        $paginator = Paginator::bootstrap('sys_items','type','Product');
        $d = ORM::for_table('sys_items')->select('sys_items.*')->select('fee_types.name','type_name')->where('sys_items.school_id',$_SESSION['school_id'])->_add_join_source('left','fee_types',array('sys_items.fee_type','=','fee_types.id'))->
                where('sys_items.type',$type)
                ->where_equal('fee_types.id',"$selected_fee_type")->order_by_asc('sys_items.name')->find_many();
        
        //$d = ORM::for_table('sys_items')->where('type','Product')->order_by_desc('id')->find_many();
        $ui->assign('d',$d);
        $ui->assign('type','Product');
   
        $ui->assign('xheader', '
<link rel="stylesheet" type="text/css" href="' . $_theme . '/css/modal.css"/>
    <link rel="stylesheet" type="text/css" href="' . APP_URL.'/ui/lib/datatable/css/jquery.dataTables.min.css"/>');
        $ui->assign('xfooter', '
        <script type="text/javascript" src="' . $_theme . '/lib/modal.js"></script>
<script type="text/javascript" src="' . $_theme . '/lib/ps-list.js"></script>
    <script type="text/javascript" src="' . APP_URL . '/ui/lib/datatable/js/jquery.dataTables.min.js"></script>

');
       
        $ui->display('ps-list.tpl');
        break;

    case 's-list':

        $paginator = Paginator::bootstrap('sys_items','type','Service');
        $d = ORM::for_table('sys_items')->where('type','Service')->where('school_id',$_SESSION['school_id'])->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_many();
        //echo '<pre>';print_r($d);die;
        $ui->assign('d',$d);
        $ui->assign('type','Service');
        $ui->assign('paginator',$paginator);
        $ui->assign('xheader', '
<link rel="stylesheet" type="text/css" href="' . $_theme . '/css/modal.css"/>

');
        $ui->assign('xfooter', '
                <script type="text/javascript" src="' . $_theme . '/lib/modal.js"></script>
<script type="text/javascript" src="' . $_theme . '/lib/ps-list.js"></script>
');
        $ui->display('ps-list.tpl');
        break;

    case 'edit-post':
        $msg = '';
        $id = _post('id');
        $price = _post('price');
        $price = Finance::amount_fix($price);
        $name = _post('name');
        $item_number = _post('item_number');
        $description = _post('description');
        $group_id       =   _post('group_id');
        $type           =   _post('ps_type');
        $optional_for_enquery           =   _post('optional_for_enquery');
        //echo '<pre>';print_r($optional_for_enquery);
        if($name == ''){
            $msg .= 'Name is Required <br>';
        }
        if( $type == 'Product' && $group_id == '' ) {
            $msg .= 'Class is required <br>';
        }
        if(!is_numeric($price)){
            $msg .= 'Invalid Sales Price <br>';
        }


        if($msg == ''){
            $d = ORM::for_table('sys_items')->find_one($id);
            if($d){
                $d->name = $name;
                $d->group_id = $group_id;
                $d->item_number = $item_number;
                $d->sales_price = $price;
                $d->description = $description;
                if($d->fee_type==1){//$type=='OneTimeFeeBeforeAdmission'){
                    $d->optional_for_enquery=$optional_for_enquery;
                }
                $d->save();
                echo $d->id();
            }
            else{
                echo 'Not Found';
            }


        }
        else{
            echo $msg;
        }


        break;
    case 'delete':
        $id = $routes['2'];
        if($_app_stage == 'Demo'){
            r2(U . 'accounts/list', 'e', 'Sorry! Deleting Account is disabled in the demo mode.');
        }
        $d = ORM::for_table('sys_accounts')->where('school_id',$_SESSION['school_id'])->find_one($id);
        if($d){
            $d->delete();
            r2(U . 'accounts/list', 's', $_L['account_delete_successful']);
        }

        break;

    case 'edit-form':

        $groups = ORM::for_table('crm_groups')->select('id')->select('gname')->where('school_id',$_SESSION['school_id'])->order_by_desc('id')->find_many();
        
        $id = $routes['2'];
        $d = ORM::for_table('sys_items')->find_one($id);
        if($d){
            if($d['type'] == 'Product') {
                $group_option_html  =       '';
                foreach ($groups as $group) {
                    $selected           =   ($group['id'] ==$d['group_id']?'selected':'');
                    $group_option_html  .= '<option '.$selected.' value="'.$group['id'].'" >
                        '.$group['gname'].
                    '</option>';
                }
                
                $selected = ($d['group_id']=='0'?'selected':'');
                $select_group   =   '<div class="form-group"><input type="hidden" value="'.$d['type'].'" id="ps_type" name="ps_type">
                            <label for="name" class="col-sm-2 control-label">Class</label>
                            <div class="col-sm-10">
                              <select id="group_id" name="group_id" class="form-control">
                                    <option value="">Select Group</option>
                                    <option value="0" '.$selected.'>All Class</option>
                                    '.$group_option_html.'
                              </select>
                            </div>
                      </div>';
                
            } else {
                $select_group   =   '';
            }
            
            if($d['fee_type']==1){//$d['type'] == 'OneTimeFeeBeforeAdmission') {
                $j_html='<div class="form-group"><label class="col-lg-2 control-label" >Mandatory fees for enquery</label>
                            <div class="col-lg-10">
                                <label class="radio-inline">
                                    <input type="radio" name="optional_for_enquery" value="0" '.($d['optional_for_enquery']==0?'checked':'').'>Optional
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="optional_for_enquery" value="1" '.($d['optional_for_enquery']==1?'checked':'').'>Mandatory
                                </label>
                            </div>
                        </div>';
               /* if($d['optional_for_enquery']==0){
                   $j_html='<div class="form-group"><label class="col-lg-2 control-label" >Mandatory fees for enquery</label>
                            <div class="col-lg-10">
                                <label class="radio-inline">
                                    <input type="radio" name="optional_for_enquery" value="0" checked>Optional
                                  </label>
                                  <label class="radio-inline">
                                      <input type="radio" name="optional_for_enquery" value="1">Mandatory
                                  </label>
                            </div></div>';
               }else{
                   $j_html='<div class="form-group"><label class="col-lg-2 control-label" >Mandatory fees for enquery</label>
                            <div class="col-lg-10">
                                <label class="radio-inline">
                                    <input type="radio" name="optional_for_enquery" value="0">Optional
                                  </label>
                                  <label class="radio-inline">
                                      <input type="radio" name="optional_for_enquery" value="1" checked>Mandatory
                                  </label>
                            </div></div>';
               } */
            }else{
                $j_html='';
            }
            
            $price = number_format(($d['sales_price']),2,$config['dec_point'],$config['thousands_sep']);
            
            echo '
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h3>'.$_L['Edit'].'</h3>
</div>
<div class="modal-body">

<form class="form-horizontal" role="form" id="edit_form" method="post">
  '.$select_group.'
  <div class="form-group">
    <label for="name" class="col-sm-2 control-label">'.$_L['Name'].'</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$d['name'].'" name="name" id="name">
    </div>
  </div>
  <div class="form-group">
    <label for="rate" class="col-sm-2 control-label">'./*$_L['Item Number']*/''.'</label>
    <div class="col-sm-2">
      <input type="hidden" class="form-control" name="item_number" value="'.$d['item_number'].'" id="item_number">
      <input type="hidden" name="id" value="'.$d['id'].'">
    </div>
  </div>'.$j_html.'
  <div class="form-group">
    <label for="rate" class="col-sm-2 control-label">'.$_L['Price'].'</label>
    <div class="col-sm-2">
      <input type="text" class="form-control" name="price" value="'.$price.'" id="price">
      <input type="hidden" name="id" value="'.$d['id'].'">
      <input type="hidden" name="ps_type" value="'.$d['type'].'">
    </div>
  </div>
    <div class="form-group">
    <label for="name" class="col-sm-2 control-label">'.$_L['Description'].'</label>
    <div class="col-sm-10">
      <textarea id="description" name="description" class="form-control" rows="3">'.$d['description'].'</textarea>
    </div>
  </div>
</form>

</div>
<div class="modal-footer">

	<button type="button" data-dismiss="modal" class="btn">'.$_L['Close'].'</button>
	<button id="update" class="btn btn-primary">'.$_L['Update'].'</button>
</div>';
        }
        else{
            echo 'not found';
        }



        break;

    case 'post':

        break;
    
    case 'fee-type':
        
            $fee_types = ORM::for_table('fee_types')->order_by_asc('id')->find_many();
            $ui->assign('ft', $fee_types);
            $ui->assign('xfooter', Asset::js(array('numeric','jslib/add-ft')));
            $ui->assign('xjq', '
     $(\'.amount\').autoNumeric(\'init\');
     ');

            $type   =   array('id'=>'','pay_type'=>'','name'=>'');
            $ui->assign( 'ftype' , $type );
            $max = ORM::for_table('fee_types')->max('id');
            $nxt = $max+1;
            $ui->assign('nxt',$nxt);
            $ui->display('add-ft.tpl');

        break;
    case 'edit-ft' :
        $id  = $routes['2'];
        
        $type   =   ORM::for_table('fee_types')->where('id',$id)->find_one();
        $ui->assign( 'ftype' , $type );
        
        $fee_types = ORM::for_table('fee_types')->order_by_asc('id')->find_many();
        $ui->assign('ft', $fee_types);
        $ui->assign('xfooter', Asset::js(array('numeric','jslib/add-ft')));
        $ui->assign('xjq', '
     $(\'.amount\').autoNumeric(\'init\');
     ');

        $max = ORM::for_table('fee_types')->max('id');
        $nxt = $max+1;
        $ui->assign('nxt',$nxt);
        $ui->display('add-ft.tpl');
        break;
    case 'add-fee-type':
        $name                   =   _post('name');
        $fee_mode               =   _post('fee_mod');
        $type_id                =   _post('type_id');

        $msg                    =   '';

        if($name == ''){
            $msg .= 'Item Name is required <br>';
        }
        
        if($type_id != '') {
            $type   =   ORM::for_table('fee_types')->where('name',$name)->where_not_equal('id',$type_id)->find_many();
        } else {
            $type   =   ORM::for_table('fee_types')->where('name',$name)->find_many();
        }
        if(count($type)>=1) {
                $msg .= 'Item Name is Already Exist <br>';
        }
        
        if($msg == '') {
            if($type_id != '') {
                $d = ORM::for_table('fee_types')->find_one($type_id);
                $d->name        =   $name;
                $d->pay_type    =   $fee_mode;
                $d->save();
                _msglog('s','Item Updated Successfully');

                echo $d->id();
            } else {
                $d = ORM::for_table('fee_types')->create();
                $d->name        =   $name;
                $d->pay_type    =   $fee_mode;
                $d->created_date =   date('Y-m-d');
                $d->status      =   1;
                $d->created_by  =   '0';
                $d->save();
                _msglog('s',$_L['Item Added Successfully']);

                echo $d->id();
            }
        } else {
            echo $msg;
        }
        
        break;
    case 'one-time-fee-before-admission-list':
        $paginator = Paginator::bootstrap('sys_items','type','OneTimeFeeBeforeAdmission');
        $d = ORM::for_table('sys_items')->where('type','OneTimeFeeBeforeAdmission')->where('school_id',$_SESSION['school_id'])->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_many();
        $ui->assign('d',$d);
        $ui->assign('type','OneTimeFeeBeforeAdmission');
        $ui->assign('paginator',$paginator);
        $ui->assign('xheader', '
<link rel="stylesheet" type="text/css" href="' . $_theme . '/css/modal.css"/>

');
        $ui->assign('xfooter', '
        <script type="text/javascript" src="' . $_theme . '/lib/modal.js"></script>
<script type="text/javascript" src="' . $_theme . '/lib/ps-list.js"></script>

');
        $ui->display('ps-list.tpl');
        break;
    case 'one-time-fee-before-admission-add':
        $ui->assign('type','OneTimeFeeBeforeAdmission');
        $ui->assign('xfooter', Asset::js(array('numeric','jslib/add-ps')));

        $ui->assign('xjq', '
 $(\'.amount\').autoNumeric(\'init\');
 ');

        $max = ORM::for_table('sys_items')->max('id');
        $nxt = $max+1;
        $ftypes             =   ORM::for_table('fee_types')->where('status',1)->find_many();
        $ui->assign('ftypes', $ftypes);      
        $running_year       =   $_SESSION['running_year'];
        if($running_year == '') {
            $running_year       =   date('Y')-1;
            $running_year       =   $running_year."-".date('Y');
        }
        $running_year       =   explode('-', $running_year);
        $ry                 =   array();
        for( $y = $running_year[0]; $y<$running_year[1]+3; $y++ ) {
            $ry[]                 =   $y;
        }
        $ui->assign('ry', $ry);
        $ui->assign('type','OneTimeFeeBeforeAdmission');
        
        $ui->assign('nxt',$nxt); 
        $ui->display('add-ps.tpl');
        
        break;

    case 'fee-insta-setting':  
        //$selected_fee_type        =   $routes['2'];
        //$ui->assign('selected_fee_type',$selected_fee_type);
        $running_year       =   $_SESSION['running_year'];
        $r_year = $_SESSION['running_year'];
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

        
        $school_settings = ORM::for_table('sys_settings')->where('school_id',$_SESSION['school_id'])->where('academic_year',$r_year)->find_many();
        //echo ORM::get_last_query();exit;
        //echo '<pre>';print_r($school_settings);die($r_year);
        $tut_fee_list = array();
        if(count($school_settings)>=1) {
            foreach($school_settings as $val) {
                $tut_fee_list           = explode(",", $val['schoolfee_inst_types']);        
            }
        }


        $ui->assign('ry', $ry);
        $gs = ORM::for_table('crm_groups')->where('school_id',$_SESSION['school_id'])->order_by_asc('sorder')->find_array();
        $ui->assign('gs',$gs);
        $fee_types = ORM::for_table('fee_types')->where('status',1)->order_by_asc('id')->find_many();
        $ui->assign('fee_types',$fee_types);
        $installments = ORM::for_table('sys_installments')->where_id_in($tut_fee_list)->where('school_id',$_SESSION['school_id'])->find_many();
        $ui->assign('installments',$installments);
        //echo '<pre>';print_r($ry);exit;
        $paginator = Paginator::bootstrap('sys_items','type','Product');
        $ui->assign('paginator',$paginator);
        
        $css_arr = array('bdp/css/bootstrap-datepicker.min');
        $ui->assign('xheader', Asset::css($css_arr));
        $js_arr = array('bdp/js/bootstrap-datepicker.min','jslib/add-ps');
        $ui->assign('xfooter', Asset::js($js_arr));

        $ui->display('ps-fee-installment-setting.tpl');
    break;

    case 'get-fee-insta':  
        $academic_year = _post('academic_year');
        $class_id = _post('group_id');
        $installment_id = _post('installment_id');
        $insta_record =   ORM::for_table('sys_installments')->where('school_id',$_SESSION['school_id'])->where('id',$installment_id)->find_one();
        $insta_no = $insta_record?$insta_record->no_of_installment:0;
        
        $group_record =   ORM::for_table('crm_groups')->where('school_id',$_SESSION['school_id'])->where('id',$class_id)->find_one();
        $group_id = $group_record->group_id;

        $sys_items = ORM::for_table('sys_items')->where('academic_year',$academic_year)->where('school_id',$_SESSION['school_id'])->where('group_id',$group_id)->order_by_asc('name')->find_many();
        //echo ORM::get_last_query();exit;                            

        $fee_insta_records =   ORM::for_table('fee_installments')->where('academic_year',$academic_year)->where('group_id',$group_id)
                                    ->where('installment_id',$installment_id)->where('school_id',$_SESSION['school_id'])->find_many();
        //$fee_insta_amts = $fee_insta_record?explode(',',$fee_insta_record->amounts):array();
        //echo '<pre>';print_r($fee_insta_amts);exit;


        $return = array('html'=>'','sys_items'=>'','item_summary_tbody'=>'','item_summary_tfoot'=>'');
        $return['sys_items'] .= '<option value="">Add Item</option>';
        foreach($sys_items as $syitem){
            $return['sys_items'] .= '<option value="'.$syitem['id'].'" data-title="'.$syitem['name'].'"
                                        data-amt="'.$syitem['sales_price'].'">'.$syitem['name'].' -- '.$syitem['sales_price'].'</option>';
        }

        /* $return['html'] = '<table class="table datatable table-bordered table-hover" style="width:100%">
                           <thead>
                                <tr>
                                    <th>Installment No.</th>
                                    <th>Add</th>
                                </tr>
                           </thead>
                           <tbody>'; */

        $net_payable = 0;    
        $total_summary_amt = 0; 
        $item_keep_rec = array();              
        for($i=0;$i<$insta_no;$i++){
            $insta_id = isset($fee_insta_records[$i])?$fee_insta_records[$i]['id']:0;
            if($insta_id){
                $insta_item_records = ORM::for_table('fee_insta_items')->where('insta_id',$insta_id)->where('school_id',$_SESSION['school_id'])->find_many();
            }else{
                $insta_item_records = array();
            }

            $return['html'] .= '<table class="table datatable table-bordered table-hover insta-table" style="width:100%" data-insta-num="'.$i.'"
                                data-insta-id="'.$insta_id.'">
                                <input type="hidden" name="insta['.$i.'][id]" value="'.$insta_id.'">
                                <thead>
                                    <tr>
                                        <th width="30%">'.($i+1).' installment</th>
                                        <th width="70%">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="first-row">
                                        <td width="30%"></td>
                                        <td width="70%">
                                            <div class="input-group">
                                                <select id="sys-item" class="form-control">
                                                    '. $return['sys_items'].'
                                                </select> 
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-primary add-to-insta">Add</button>
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="30%"><strong>Installment Name</strong></td>
                                        <td width="70%">
                                            <input type="text" class="form-control" placeholder="Installment Name" name="insta['.$i.'][installment_name]" 
                                            value="'.(isset($fee_insta_records[$i])?$fee_insta_records[$i]['installment_name']:'').'"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="30%"><strong>Due Date</strong></td>
                                        <td width="70%">
                                            <input type="text" class="form-control dtp" name="insta['.$i.'][due_date]" placeholder="Select Due Date"
                                            value="'.(isset($fee_insta_records[$i])?$fee_insta_records[$i]['due_date']:'').'"/>
                                        </td>
                                    </tr>';
                                    $insta_tot_amt = 0;
                                    foreach($insta_item_records as $item_rec){  
                                        $sys_item_record =   ORM::for_table('sys_items')->where('school_id',$_SESSION['school_id'])->where('id',$item_rec->item_id)->find_one();

                                        if($sys_item_record){
                                            if(!in_array($sys_item_record['id'], $item_keep_rec)){
                                                $item_keep_rec[] = $sys_item_record['id'];
                                                $total_summary_amt += $sys_item_record['sales_price'];
                                                $return['item_summary_tbody'] .= '<tr class="item-rw" data-id="'.$sys_item_record['id'].'" 
                                                                                    data-amt="'.$sys_item_record['sales_price'].'">
                                                                                    <td>'.$sys_item_record['name'].'</td> <td>'.$sys_item_record['sales_price'].'</td>
                                                                                  </tr>';  
                                            }                                              
                                        }

                                        $insta_tot_amt += $item_rec->amount;
                                        $return['html'] .= '<tr>
                                                                <td>'.@$sys_item_record['name'].'</td>
                                                                <td>
                                                                    <input type="number" class="form-control row-item" placeholder="Amount" 
                                                                    name="insta['.$i.'][items]['.$item_rec->item_id.']" data-item-id="'.$item_rec->item_id.'" 
                                                                    value="'.$item_rec->amount.'"/>
                                                                </td>
                                                            </tr>';
                                    }    
                                    $net_payable += $insta_tot_amt;          
                $return['html'] .= '<tr class="total-row">
                                        <td width="30%"><strong>Total</strong></td>
                                        <td width="70%">
                                            <input type="number" class="form-control insta-total" placeholder="Total Amount" name="insta['.$i.'][amount]" 
                                            readonly value="'.$insta_tot_amt.'"/>
                                        </td>
                                    </tr>
                                </tbody>
                                </table>';
        }
        $return['html'] .= '<table class="table datatable table-bordered table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="30%">Net Amount </th>
                                    <th width="70%"><strong class="net-payable">'.$net_payable.'</strong></th>
                                </tr>
                            </thead>
                            </table>';
        $return['item_summary_tfoot'] = '<tr class="total-item-amt" data-amt="'.$total_summary_amt.'">
                                            <th>Total</th><th class="tot-amt">'.$total_summary_amt.'</th>
                                         </tr>';                   
        echo json_encode($return);exit;        
    break;

    case 'save-fee-insta':  
        //echo '<pre>';print_r($_POST);exit;  
        $academic_year = _post('academic_year');
        $class_id = _post('group_id');
        $installment_id = _post('installment_id');
        $instas = $_POST['insta'];
        $group_record =   ORM::for_table('crm_groups')->where('school_id',$_SESSION['school_id'])->where('id',$class_id)->find_one();
        $group_id = $group_record->group_id;
        //$id = _post('id');

        foreach($instas as $insta){
            $id = $insta['id'];
            if($id)
                $d = ORM::for_table('fee_installments')->where('school_id',$_SESSION['school_id'])->find_one($id);
            else
                $d = ORM::for_table('fee_installments')->where('school_id',$_SESSION['school_id'])->create();

            $d->academic_year   =   $academic_year;
            $d->group_id        =   $group_id;
            $d->installment_id  =   $installment_id;
            $d->installment_name  =   $insta['installment_name'];
            $d->amount          =   $insta['amount'];
            $d->due_date        =   $insta['due_date'];
            $d->created         =   date('Y-m-d H:i:s');
            $d->updated         =   date('Y-m-d H:i:s');
            $d->save();
            $last_id = $d->get('id');

            foreach($insta['items'] as $item_id=>$item_amt){
                $fee_item = ORM::for_table('fee_insta_items')->where('school_id',$_SESSION['school_id'])->where('insta_id',$last_id)->where('item_id',$item_id)->find_one();
                
                if($fee_item)
                    $d = ORM::for_table('fee_insta_items')->where('school_id',$_SESSION['school_id'])->find_one($fee_item['id']);
                else
                    $d = ORM::for_table('fee_insta_items')->create();

                $d->insta_id        =   $last_id;
                $d->item_id         =   $item_id;
                $d->amount          =   $item_amt;
                $d->created         =   date('Y-m-d H:i:s');
                $d->updated         =   date('Y-m-d H:i:s');
                $d->save();
            }
            
        }
        
        $return = array('status'=>'success','msg'=>'Successfully submitted!');
        echo json_encode($return);exit; 
    break;
    default:
        echo 'action not defined';
}