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

if(!isset($myCtrl)){
    $myCtrl = 'contacts';
}
_auth();
$ui->assign('_sysfrm_menu', 'contacts');
$ui->assign('_title', $_L['Contacts'].' - '. $config['CompanyName']);
$ui->assign('_st', $_L['Contacts']);
$ui->assign('content_inner',inner_contents($config['c_cache']));
$action = $routes['1'];
$user = User::_info();
$ui->assign('user', $user);

$ui->assign('jsvar', '
_L[\'Working\'] = \''.$_L['Working'].'\';
_L[\'Submit\'] = \''.$_L['Submit'].'\';
 ');

// print_r($ui);die();
switch ($action) {
    case 'add':

        Event::trigger('contacts/add/');

        $ui->assign('countries',Countries::all($config['country'])); // may add this $config['country_code']

        $fs = ORM::for_table('crm_customfields')->where('ctype','crm')->order_by_asc('id')->find_many();
        $ui->assign('fs',$fs);

        // find all groups

        $gs = ORM::for_table('crm_groups')->order_by_asc('sorder')->find_array();
        //echo $gs;exit();

        $ui->assign('gs',$gs);

        $g_selected_id = route(2);
         
        if($g_selected_id){
            $ui->assign('g_selected_id',$g_selected_id);
        }
        else{
            $ui->assign('g_selected_id','');
        }




//        $ui->assign('xheader', '
//<link rel="stylesheet" type="text/css" href="ui/lib/s2/css/select2.min.css"/>
//');
        $ui->assign('xheader', Asset::css('s2/css/select2.min'));
        $ui->assign('xfooter', Asset::js(array('s2/js/select2.min','s2/js/i18n/'.lan(),'add-contact')));
        $tags = Tags::get_all('Contacts');
        $ui->assign('tags',$tags);
        $ui->assign('xjq', '
                        $("#country").select2({
                        theme: "bootstrap"
                        });');

        $ui->assign('jsvar', '
            _L[\'Working\'] = \''.$_L['Working'].'\';
            ');
        $ui->display('add-contact.tpl');
        break;

    case 'summary':
        Event::trigger('contacts/summary/');

        $cid = _post('cid');
        $d = ORM::for_table('crm_accounts')->select('crm_accounts.gname')->select('crm_accounts.*')->select('crm_groups.gname')
        ->_add_join_source( 'left' , 'crm_groups' , array( 'crm_accounts.gid' , '=' , 'crm_groups.id' ) )->find_one($cid);
        if($d){
            $ti = ORM::for_table('sys_transactions')->where('payerid',$cid)->sum('cr');
            if($ti == ''){
                $ti = '0';
            }
            $ui->assign('ti',$ti);
            $te = ORM::for_table('sys_transactions')
                ->where('payeeid',$cid)
                ->sum('dr');
            if($te == ''){
                $te = '0';
            }

            $ui->assign('te',$te);
            $ui->assign('d',$d);

            $cf = ORM::for_table('crm_customfields')->where('ctype','crm')->order_by_asc('id')->find_many();
            $ui->assign('cf',$cf);

            $ui->display('ajax.contact-summary.tpl');
        }else{

        }

        break;

    case 'activity':

        Event::trigger('contacts/activity/');
        $cid = _post('cid');
        $d = ORM::for_table('crm_accounts')->find_one($cid);
        if($d){
            $ac = ORM::for_table('sys_activity')->where('cid',$cid)->limit(20)->order_by_desc('id')->find_many();
            $ui->assign('ac',$ac);
            $ui->display('ajax.contact-activity.tpl');
        }
        else{

        }

        break;


    case 'invoices':

        Event::trigger('contacts/invoices/');

        $cid = _post('cid');
        $d = ORM::for_table('crm_accounts')->find_one($cid);
        if($d){
$i = ORM::for_table('sys_invoices')->where('userid',$cid)->find_many();
            $ui->assign('i',$i);
            $ui->display('ajax.contact-invoices.tpl');
        }
        else{

        }


        break;
        
    case 'scholarship':

        Event::trigger('contacts/scholarship/');

        $cid = _post('cid');  
        $d = ORM::for_table('crm_accounts')->find_one($cid);
        if($d){
            $tr = ORM::for_table('sys_scholarship')->select('sys_scholarship.*')->distinct()->select('sys_invoices.userid')
                ->_add_join_source("","sys_invoices",array('sys_invoices.scholarship_id','=','sys_scholarship.id'))
                ->where_equal('sys_invoices.userid',$cid)
                ->order_by_desc('userid')->find_many();
            $ui->assign('tr',$tr);
            $ui->display('ajax.contact-scholarship.tpl');
        }
        else{
           
        }


        break;    

    case 'transactions':

        Event::trigger('contacts/transactions/');

        $cid = _post('cid');
        $d = ORM::for_table('crm_accounts')->find_one($cid);
        if($d){
            $tr = ORM::for_table('sys_transactions')
                ->where_raw('(`payerid` = ? OR `payeeid` = ?)', array($cid, $cid))
                ->order_by_desc('id')->find_many();
            $ui->assign('tr',$tr);
            $ui->display('ajax.contact-transactions.tpl');
        }
        else{

        }


        break;

    case 'email':

        Event::trigger('contacts/email/');

        $cid = _post('cid');
        $d = ORM::for_table('crm_accounts')->find_one($cid);
        if($d){
            $e = ORM::for_table('sys_email_logs')
                ->where('userid',$cid)
                ->order_by_desc('id')->find_many();
            $ui->assign('d',$d);
            $ui->assign('e',$e);
            $ui->display('ajax.contact-emails.tpl');
        }
        else{

        }


        break;


    case 'edit':

        Event::trigger('contacts/edit/');

        $cid = _post('cid');
        $d = ORM::for_table('crm_accounts')->find_one($cid);
        if($d){
            $fs = ORM::for_table('crm_customfields')->where('ctype','crm')->order_by_asc('id')->find_many();
            $ui->assign('fs',$fs);
            $ui->assign('countries',Countries::all($d['country']));
            $ui->assign('d',$d);
            $tags = Tags::get_all('Contacts');
            $ui->assign('tags',$tags);
            $dtags = explode(',',$d['tags']);
            $ui->assign('dtags',$dtags);

            // find all groups

            $gs = ORM::for_table('crm_groups')->order_by_asc('sorder')->find_array();

            $ui->assign('gs',$gs);

            $g_selected_id = route(4);

            if($g_selected_id){
                $ui->assign('g_selected_id',$g_selected_id);
            }
            else{
                $ui->assign('g_selected_id','');
            }


            $ui->display('ajax.contact-edit.tpl');
        }
        else{

        }


        break;



    case 'add-activity-post':

        Event::trigger('contacts/add-activity-post/');

        $cid = _post('cid');
        $msg = $_POST['msg'];
        $icon = $_POST['icon'];
        $icon = trim($icon);
        //<a href="#"><i class="fa fa-camera"></i></a>

        $icon = str_replace('<a href="#"><i class="','',$icon);
        $icon = str_replace('"></i></a>','',$icon);
        if($icon == ''){
            $icon = 'fa fa-check';
        }

        if(Validator::Length($msg,1000,5) == false){
            echo $_L['Message Should be between 5 to 1000 characters'];
        }
        else{
            $d = ORM::for_table('sys_activity')->create();
            $d->cid = $cid;
            $d->msg = $msg;
            $d->icon = $icon;
            $d->stime = time();
            $d->sdate = date('Y-m-d');
            $d->o = $user['id'];
            $d->oname = $user['fullname'];
            $d->save();

            echo $cid;
        }

        break;


    case 'activity-delete':

        Event::trigger('contacts/activity-delete/');

        $id = $routes['3'];
        $d = ORM::for_table('sys_activity')->find_one($id);
        $d->delete();
        $cid = $routes['2'];
        r2(U.$myCtrl.'/view/'.$cid.'/','s',$_L['Deleted Successfully']);
        break;

    case 'view':
        Event::trigger('contacts/view/');

        $id  = $routes['2'];
        $d = ORM::for_table('crm_accounts')->find_one($id);
        //echo '<pre>';print_r($d);exit;
        if($d){
            $extra_tab = '';
            $extra_jq = '';
            $tab = route(3);
            if(!$tab){
                $tab = 'summary';
            }
            $ui->assign('tab',$tab);
            Event::trigger('contacts/view/_on_start');
            $ui->assign('extra_tab', $extra_tab);
            //Invoice count
            $inv_count = ORM::for_table('sys_invoices')->where('userid',$id)->count();
            if($inv_count == ''){
                $inv_count = 0;
            }
            $ui->assign('inv_count',$inv_count);

            //find all activity for this user
            //$ac = ORM::for_table('sys_activity')->where('cid',$id)->limit(20)->order_by_desc('id')->find_many();
            //$ui->assign('ac',$ac);
            $ui->assign('xheader', Asset::css(array('s2/css/select2.min','sn/summernote','sn/summernote-bs3','sn/summernote-sysfrm','imgcrop/assets/css/croppic')));
            $ui->assign('xfooter', Asset::js(array('s2/js/select2.min','s2/js/i18n/'.lan(),'sn/summernote.min','imgcrop/croppic','numeric','profile')));
            $ui->assign('xjq', '
                            var cid = $(\'#cid\').val();
                            var _url = $("#_url").val();
                            var cb = function cb (){
                        };'.$extra_jq);

            $ui->assign('d',$d);

            Event::trigger('contacts/view/_on_display');
            $ui->display('account-profile-alt.tpl');
        }
        else{
            r2(U . 'customers/list/', 'e', $_L['Account_Not_Found']);
        }

        break;

    case 'add-post':

        Event::trigger('contacts/add-post/');

        Event::trigger('contacts/add-post/_on_start');

        $account = _post('account');
        $company = _post('company');
        $email = _post('email');
        $phone = _post('phone');
        

        if(isset($_POST['tags']) AND ($_POST['tags']) != ''){
            $tags = $_POST['tags'];
        }
        else{
            $tags = '';
        }

        $address = _post('address');
        $city = _post('city');
        $state = _post('state');
        $zip = _post('zip');
        $country = _post('country');
        $msg = '';

//check if tag is already exisit



        if($account == ''){
            $msg .= $_L['Account Name is required'].' <br>';
        }

//check account is already exist
//        $chk = ORM::for_table('crm_accounts')->where('account',$account)->find_one();
//        if($chk){
//            $msg .= 'Account already exist <br>';
//        }

        if($email != ''){
            if(Validator::Email($email) == false){
                $msg .= $_L['Invalid Email'].' <br>';
            }
            $f = ORM::for_table('crm_accounts')->where('email',$email)->find_one();

            if($f){
                $msg .= $_L['Email already exist'].' <br>';
            }
        }


        $gid = _post('group');

        if($gid != ''){
            $g = db_find_one('crm_groups',$gid);
            $gname = $g['gname'];
        }
        else{
            $gid = 0;
            $gname = '';
        }

        $password = _post('password');
        $cpassword = _post('cpassword');

        $u_password = '';


        if($password != ''){

            if(!Validator::Length($password,15,5)){
                $msg .= 'Password should be between 6 to 15 characters'. '<br>';

            }

            if($password != $cpassword){
                $msg .= 'Passwords does not match'. '<br>';
            }


            $u_password = $password;
            $password = Password::_crypt($password);


        }






        if($msg == ''){

            Tags::save($tags,'Contacts');

            $d = ORM::for_table('crm_accounts')->create();

            $d->account = $account;
            $d->email = $email;
            $d->phone = $phone;
            $d->address = $address;
            $d->city = $city;
            $d->zip = $zip;
            $d->state = $state;
            $d->country = $country;
            $d->tags = Arr::arr_to_str($tags);

            //others
            $d->fname = '';
            $d->lname = '';
            $d->company = $company;
            $d->jobtitle = '';
            $d->cid = '0';
            $d->o = '0';
            $d->balance = '0.00';
            $d->status = 'Active';
            $d->notes = '';
            $d->password = $password;
            $d->token = '';
            $d->ts = '';
            $d->img = '';
            $d->web = '';
            $d->facebook = '';
            $d->google = '';
            $d->linkedin = '';

            // v 4.2

            $d->gname = $gname;
            $d->gid = $gid;

            //echo "<pre>"; print_r($d);die();
            //
            $d->save();
            $cid = $d->id();
            _log($_L['New Contact Added'].' '.$account.' [CID: '.$cid.']','Admin',$user['id']);

            //now add custom fields
            $fs = ORM::for_table('crm_customfields')->where('ctype','crm')->order_by_asc('id')->find_many();
            foreach($fs as $f){
                $fvalue = _post('cf'.$f['id']);
               // echo $fvalue;exit();
                $fc = ORM::for_table('crm_customfieldsvalues')->create();
                $fc->fieldid = $f['id'];
                $fc->relid = $cid;
                $fc->fvalue = $fvalue;
                $fc->save();
            }
            //

            Event::trigger('contacts/add-post/_on_finished');

            // send welcome email if needed

            $send_client_signup_email = _post('send_client_signup_email');


            if(($email != '') && ($send_client_signup_email == 'Yes') && ($u_password != '')){

                $email_data = array();
                $email_data['account'] = $account;
                $email_data['company'] = $company;
                $email_data['password'] = $u_password;
                $email_data['email'] = $email;

                $send_email = Ib_Email::send_client_welcome_email($email_data);



            }



            echo $cid;



        }
        else{
            echo $msg;
        }
        break;

    case 'list':
        Event::trigger('contacts/list/');

        $name = _post('name');
        //find all tags
        $t = ORM::for_table('sys_tags')->where('type','contacts')->find_many();
        $ui->assign('t',$t);

        $mode_css = '';
        $mode_js = '';

        
// Header search starts

        $param2 = route(2);
        $param3 = route(3);

        if(($param2=='search')&&($param3!='')){
            $d = ORM::for_table('crm_accounts')->where_like('account','%'.$param3.'%')->order_by_desc('id')->find_many();
        }

// Header search ends

        else if($config['contact_set_view_mode'] == 'search'){

            // Foo Table

            $mode_css = Asset::css('footable/css/footable.core.min','datatable/css/jquery.dataTables.min');

            $mode_js = Asset::js(array('footable/js/footable.all.min','contacts/mode_search','datatable/js/jquery.dataTables.min'));

            $d = ORM::for_table('crm_accounts')->where('school_id',$_SESSION['school_id'])->order_by_desc('id')->find_many();

    


        }

        elseif($name != ''){
    
            $d = ORM::for_table('crm_accounts')->where_like('account','%'.$name.'%')->order_by_desc('id')->find_many();
        }
        elseif(isset($routes[2]) AND ($routes[2]) != '' AND (!is_numeric($routes[2]))){
        $tags = $routes[2];
            $paginator['contents'] = '';
            $d = ORM::for_table('crm_accounts')->where_like('tags','%'.$tags.'%')->order_by_desc('id')->find_many();
        }
        else{
            $paginator = Paginator::bootstrap('crm_accounts');
            $d = ORM::for_table('crm_accounts')->where('school_id',$_SESSION['school_id'])->order_by_desc('id')->find_many();
        }
        $mode_css = Asset::css('datatable/css/jquery.dataTables.min');
        $mode_js = Asset::js(array('datatable/js/jquery.dataTables.min'));
        $ui->assign('d',$d);
        
                $ui->assign('xheader', $mode_css);


        $ui->assign('xfooter', $mode_js.
            '
<script type="text/javascript" src="' . $_theme . '/lib/list-contacts.js"></script>

');
        $ui->assign('jsvar', '
_L[\'are_you_sure\'] = \''.$_L['are_you_sure'].'\';
 ');
        $ui->display('list-contacts.tpl');

        break;


    case 'edit-post':

        Event::trigger('contacts/edit-post/');


        $id = _post('fcid');
        $d = ORM::for_table('crm_accounts')->find_one($id);
        if($d){

            $old_account = $d->account;

            $account = _post('account');
            $company = _post('company');

            $email = _post('edit_email');

            if(isset($_POST['tags'])){
                $tags = $_POST['tags'];
            }
            else{
                $tags = '';
            }


            $phone = _post('phone');
            $address = _post('address');
            $city = _post('city');
            $state = _post('state');
            $zip = _post('zip');
            $country = _post('country');
            $msg = '';

            if($account == ''){
                $msg .= $_L['Account Name is required']. ' <br>';
            }
//            if($tags != ''){
//                $pieces = explode(',', $tags);
//                foreach($pieces as $element)
//                {
//                    $tg = ORM::for_table('sys_tags')->where('text',$element)->where('type','Contacts')->find_one();
//                    if(!$tg){
//                        $tc = ORM::for_table('sys_tags')->create();
//                        $tc->text = $element;
//                        $tc->type = 'Contacts';
//                        $tc->save();
//                    }
//                }
//            }

            // Sadia ================= From V 2.4

            Tags::save($tags,'Contacts');


            //check email already exist




//            if($address == ''){
//                $msg .= 'Address is required <br>';
//            }
//            if($city == ''){
//                $msg .= 'City is required <br>';
//            }
//            if($state == ''){
//                $msg .= 'State is required <br>';
//            }
//            if($zip == ''){
//                $msg .= 'ZIP is required <br>';
//            }
//            if($country == ''){
//                $msg .= 'Country is required <br>';
//            }
                if($email != ''){

                if($email != ($d['email'])){
                    $f = ORM::for_table('crm_accounts')->where('email',$email)->find_one();

                    if($f){
                        $msg .= $_L['Email already exist'].' <br>';
                    }
                }
                if(Validator::Email($email) == false){
                    $msg .= $_L['Invalid Email'].' <br>';
                }
            }
//            if($phone != ''){
//                if(!is_numeric($phone)){
//                    $msg .= $_L['Invalid Phone'].' <br>';
//                }
//            }

            $gid = _post('group');

            if($gid != ''){
                $g = db_find_one('crm_groups',$gid);
                $gname = $g['gname'];
            }
            else{
                $gid = 0;
                $gname = '';
            }

            $password = _post('password');




            if($msg == ''){


                $d = ORM::for_table('crm_accounts')->find_one($id);
                $d->account = $account;
                $d->company = $company;


                $d->email = $email;
                $d->tags = Arr::arr_to_str($tags);
                $d->phone = $phone;
                $d->address = $address;
                $d->city = $city;
                $d->zip = $zip;
                $d->state = $state;
                $d->country = $country;

                // v 4.2

                $d->gname = $gname;
                $d->gid = $gid;

                if($password != ''){

                    $d->password = Password::_crypt($password);

                }

                $d->save();


                //delete existing records
                $exf = ORM::for_table('crm_customfieldsvalues')->where('relid',$id)->delete_many();
                $fs = ORM::for_table('crm_customfields')->order_by_asc('id')->find_many();
                foreach($fs as $f){
                    $fvalue = _post('cf'.$f['id']);
                    $fc = ORM::for_table('crm_customfieldsvalues')->create();
                    $fc->fieldid = $f['id'];
                    $fc->relid = $id;
                    $fc->fvalue = $fvalue;
                    $fc->save();
                }

                // check account name changed

                if($account != $old_account){

                    // change invoice account

//                    $inv = ORM::for_table('sys_invoices')->where('account',$old_account);
//                    $inv->account = $account;
//                    $inv->save();

                    $sql = "update sys_invoices set account='$account' where account='$old_account'";

                    ORM::execute($sql);



                }

                _msglog('s',$_L['account_updated_successfully']);

                echo $id;
            }
            else{
                echo $msg;
            }

        }
        else{
            r2(U.$myCtrl.'/list', 'e', $_L['Account_Not_Found']);
        }

        break;
    case 'delete':

        Event::trigger('contacts/delete/');


        $id = $routes['2'];
        if($_app_stage == 'Demo'){
            r2(U.$myCtrl.'/list/', 'e', 'Sorry! Deleting Account is disabled in the demo mode.');
        }
        $d = ORM::for_table('crm_accounts')->find_one($id);
        if($d){
            $d->delete();
            r2(U.$myCtrl.'/list/', 's', $_L['account_delete_successful']);
        }

        break;


    case 'more':

        Event::trigger('contacts/more/');

        $cid = _post('cid');
        $d = ORM::for_table('crm_accounts')->find_one($cid);
        if($d){
            $ui->assign('countries',Countries::all($d['country']));
            $ui->assign('d',$d);
            $ui->display('ajax.contact-more.tpl');
        }
        else{

        }


        break;

    case 'edit-more':

        Event::trigger('contacts/edit-more/');

        $id = _post('cid');
        $d = ORM::for_table('crm_accounts')->find_one($id);
        if($d){
            $img = _post('picture');
            $facebook = _post('facebook');
            $google = _post('google');
            $linkedin = _post('linkedin');

            $msg = '';



            //check email already exist





            if($msg == ''){


                $d = ORM::for_table('crm_accounts')->find_one($id);

                $d->img = $img;
                $d->facebook = $facebook;
                $d->google = $google;
                $d->linkedin = $linkedin;
                $d->save();
                echo $d->id();
            }
            else{
                echo $msg;
            }

        }
        else{
            r2(U.$myCtrl.'/list/', 'e', $_L['Account_Not_Found']);
        }


        break;


    case 'edit-notes':

        Event::trigger('contacts/edit-notes/');

        $id = _post('cid');
        $d = ORM::for_table('crm_accounts')->find_one($id);
        if($d){

            $notes = _post('notes');

            $msg = '';



            //check email already exist





            if($msg == ''){


                $d = ORM::for_table('crm_accounts')->find_one($id);


                $d->notes = $notes;
                $d->save();
                echo $d->id();
            }
            else{
                echo $msg;
            }

        }
        else{
            r2(U.$myCtrl.'/list/', 'e', $_L['Account_Not_Found']);
        }


        break;

    case 'render-address':

        Event::trigger('contacts/render-address/');

        $cid = _post('cid');
        $d = ORM::for_table('crm_accounts')->find_one($cid);
        $address = $d['address'];
        $city = $d['city'];
        $state = $d['state'];
        $zip = $d['zip'];
        $country = $d['country'];
        echo "$address
$city
$state $zip
$country
";
        break;


    case 'send_email':

        Event::trigger('contacts/send_email/');

        $msg = '';
        $cid = _post('cid');
        $d = ORM::for_table('crm_accounts')->find_one($cid);
        $email = $d['email'];
        $toname = $d['account'];
$subject = _post('subject');
        if($subject == ''){
            $msg .= $_L['Subject is Empty'].' <br>';
        }
        $message = $_POST['message'];
if($message == ''){
    $msg .= $_L['Message is Empty'].' <br>';
}
        if($msg == ''){
            //send email
            Notify_Email::_send($toname,$email,$subject,$message,$cid);
            echo $cid;

        }
        else{
            echo $msg;
        }
        break;


    case 'modal_add':

        Event::trigger('contacts/modal_add/');

        $ui->assign('countries',Countries::all($config['country'])); // may add this $config['country_code']
        $ui->display('modal_add_contact.tpl');


        break;


    case 'set_view_mode':

        Event::trigger('contacts/set_view_mode/');

//        if(isset($routes['2']) AND ($routes['2'] != 'tbl')){
//            $mode = 'card';
//        }
//        else{
//            $mode = 'tbl';
//        }

        if(isset($routes[2]) AND ($routes[2] != '')){
            $mode = $routes['2'];
        }

        else{
            $mode = 'tbl';
        }

        $available_mode = array("tbl", "card", "search");
        if (in_array($mode, $available_mode)) {

            update_option('contact_set_view_mode',$mode);

        }

        r2(U.'contacts/list/');

        break;



    case 'export_csv':


        $fileName = 'contacts_'.time().'.csv';

        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-Description: File Transfer');
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename={$fileName}");
        header("Expires: 0");
        header("Pragma: public");

        $fh = @fopen( 'php://output', 'w' );

        $headerDisplayed = false;

       // $results = ORM::for_table('crm_Accounts')->find_array();
        $results = db_find_array('crm_accounts',array('id','account','company','phone','email','address','city','state','zip','country','balance','tags'));

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



    case 'dev_demo_data':


        // this only work with dev mode
        is_dev();





        break;

    case 'import_csv':


        $ui->assign('xheader', Asset::css(array('dropzone/dropzone')));


        $ui->assign('xfooter', Asset::js(array('dropzone/dropzone','contacts/import')));



        $ui->display('contacts_import.tpl');



        break;

    case 'csv_upload':

        $uploader   =   new Uploader();
        $uploader->setDir('sysfrm/uploads/_sysfrm_tmp_/');
       // $uploader->sameName(true);
        $uploader->setExtensions(array('csv'));  //allowed extensions list//
        if($uploader->uploadFile('file')){   //txtFile is the filebrowse element name //
            $uploaded  =   $uploader->getUploadName(); //get uploaded file name, renames on upload//

            $_SESSION['uploaded'] = $uploaded;

        }else{//upload failed
            _msglog('e',$uploader->getMessage()); //get upload error message
        }


        break;

    case 'csv_uploaded':


        if(isset($_SESSION['uploaded'])){

            $uploaded = $_SESSION['uploaded'];

          // _msglog('s',$uploaded);

//            $csvData = file_get_contents('sysfrm/uploads/_sysfrm_tmp_/'.$uploaded);
//            $lines = explode(PHP_EOL, $csvData);
//            $contacts = array();
//            foreach ($lines as $line) {
//                $contacts[] = str_getcsv($line);
//            }




            $csv = new parseCSV();
            $csv->auto('sysfrm/uploads/_sysfrm_tmp_/'.$uploaded);

            $contacts = $csv->data;



            $cn = 0;

            foreach($contacts as $contact){

                $data = array();
                $data['account'] = $contact['Full Name'];
                $data['email'] = $contact['Email'];
                $data['phone'] = $contact['Phone'];
                $data['address'] = $contact['Address'];
                $data['city'] = $contact['City'];
                $data['zip'] = $contact['Zip'];
                $data['state'] = $contact['State'];
                $data['country'] = $contact['Country'];
                $data['company'] = $contact['Company'];



                $save = Contacts::add($data);

                if(is_numeric($save)){

                    $cn++;

                }


            }


            _msglog('s',$cn.' Contacts Imported');

//            ob_start();
//            var_dump($contacts);
//            $result = ob_get_clean();
//
//            _msglog('s',$result);



        }
        else{

            _msglog('e','An Error Occurred while uploading the files');

        }


        break;


    case 'groups':

        // find all groups

        $gs = ORM::for_table('crm_groups')->where('school_id',$_SESSION['school_id'])->order_by_asc('sorder')->find_array();
        $tot_inv        =   0;
        $tot_pay        =   0;
        $tot_due        =   0;
        foreach($gs as $key=>$gn) {
            $total_invice_amount        =   0;
            $total_payed_amount         =   0;
            $students_by_group          =   ORM::for_table('crm_accounts')->where('gid',$gn['id'])->find_many();
            foreach($students_by_group as $student) { 
                $stud_invoice           =   ORM::for_table('sys_transactions')->where('payeeid',$student['id'])->sum('dr');
                $stud_payment           =   ORM::for_table('sys_transactions')->where('payerid',$student['id'])->sum('cr');
                if($stud_invoice)
                    $total_invice_amount            =   $total_invice_amount+$stud_invoice;
                if($stud_payment)
                    $total_payed_amount             =   $total_payed_amount+$stud_payment;
            }
            $gs[$key]['total_invoice']    =   $total_invice_amount;
            $gs[$key]['total_payment']    =   $total_payed_amount;
            $total_due_amount             =     $total_invice_amount-$total_payed_amount;
            $gs[$key]['total_due']        =   $total_due_amount;
            
            $tot_inv                            =   $tot_inv+$total_invice_amount;
            $tot_pay                            =   $tot_pay+$total_payed_amount;
            $tot_due                            =   $tot_due+$total_due_amount;

        }
        $ui->assign('tot_inv',$tot_inv);
        $ui->assign('tot_pay',$tot_pay);
        $ui->assign('tot_due',$tot_due);
        
        $ui->assign('gs',$gs);
        $mode_css = Asset::css('datatable/css/jquery.dataTables.min');
        $ui->assign('xheader', $mode_css);
        $ui->assign('xfooter',Asset::js(array('contacts/groups','datatable/js/jquery.dataTables.min')));
        
        $ui->assign('jsvar', '
_L[\'are_you_sure\'] = \''.$_L['are_you_sure'].'\';
 ');

        $ui->display('crm_groups.tpl');



        break;


    case 'add_group':

        $group_name = _post('group_name');

        if($group_name != ''){

            //check same group already exist

            $c = ORM::for_table('crm_groups')->where('gname',$group_name)->find_one();

            if($c){

                ib_die('A Group with same name already exist');

            }

            $d = ORM::for_table('crm_groups')->create();
            $d->gname = $group_name;
            $d->color = '';
            $d->discount = '';
            $d->parent = '';
            $d->pid = 0;
            $d->exempt = '';
            $d->description = '';
            $d->separateinvoices = '';
            $d->sorder = 0;
            $d->c1 = '';
            $d->c2 = '';
            $d->c3 = '';
            $d->c4 = '';
            $d->c5 = '';
           $d->save();

            echo $d->id();



        }
        else{

            echo 'Group Name is required';

        }



        break;


    case 'find_by_group':

        $gid = route(2);

        if($gid){

            $g = ORM::for_table('crm_groups')->find_one($gid);

            if($g){

                $d = ORM::for_table('crm_accounts')->where('gid',$gid)->order_by_desc('id')->find_array();
                $tot_inv        =   0;
                $tot_pay        =   0;
                $tot_due        =   0;
                foreach($d as $key=>$stud) {
                    $total_invice_amount        =   0;
                    $total_payed_amount         =   0;
                    $stud_invoice           =   ORM::for_table('sys_transactions')->where('payeeid',$stud['id'])->sum('dr');
                    $stud_payment           =   ORM::for_table('sys_transactions')->where('payerid',$stud['id'])->sum('cr');
                    if($stud_invoice)
                        $total_invice_amount            =   $total_invice_amount+$stud_invoice;
                    if($stud_payment)
                        $total_payed_amount             =   $total_payed_amount+$stud_payment;
                    
                    $d[$key]['total_invoice']           =   $total_invice_amount;
                    $d[$key]['total_payment']           =   $total_payed_amount;
                    $total_due_amount                   =   $total_invice_amount-$total_payed_amount;
                    $d[$key]['total_pending']           =   $total_due_amount;
                    $tot_inv                            =   $tot_inv+$total_invice_amount;
                    $tot_pay                            =   $tot_pay+$total_payed_amount;
                    $tot_due                            =   $tot_due+$total_due_amount;
                    
                }
                $mode_css = Asset::css('datatable/css/jquery.dataTables.min');
                $mode_js = Asset::js(array('datatable/js/jquery.dataTables.min'));
                
                $ui->assign('xheader', $mode_css);
                $ui->assign('xfooter', $mode_js);
                $ui->assign('tot_inv',$tot_inv);
                $ui->assign('tot_pay',$tot_pay);
                $ui->assign('tot_due',$tot_due);
                $ui->assign('d',$d);
                $ui->assign('gid',$gid);

                $ui->assign('xjq',' $(".cdelete").click(function (e) {
        e.preventDefault();
        var id = this.id;
        bootbox.confirm("'.$_L['are_you_sure'].'", function(result) {
           if(result){
               var _url = $("#_url").val();
               window.location.href = _url + "delete/crm-user/" + id + "/'.$gid.'/";
           }
        });
    });
');

                $ui->display('contacts_find_by_group.tpl');


            }

        }




        break;

    case 'group_edit':


        $id = _post('id');
        $id = str_replace('e','',$id);
        $gname = _post('gname');

        $d = ORM::for_table('crm_groups')->find_one($id);

        if($d){

            // update all gname in contacts

            $o_gname = $d->gname;

            ORM::execute("update crm_accounts set gname='$gname' where gname='$o_gname'");

            $d->gname = $gname;

            $d->save();

            echo $d->id;



        }





        break;

    case 'group_email':

        $gid = route(2);

        if($gid){

            // find group


            $ds = ORM::for_table('crm_accounts')->where('gid',$gid)->where_not_equal('parent_email','')->select('account')->select('parent_email')->order_by_desc('id')->find_array();

            $ui->assign('ds',$ds);

            $ui->assign('xheader', Asset::css(array('s2/css/select2.min','sn/summernote','sn/summernote-bs3','sn/summernote-sysfrm')));




            $ui->assign('xfooter', Asset::js(array('s2/js/select2.min','s2/js/i18n/'.lan(),'sn/summernote.min','contacts/group_email')));
            $ui->display('contacts_group_email.tpl');

        }


        break;


    case 'group_email_post':


//        $recipients = array(
//            'person1@domain.com' => 'Person One',
//            'person2@domain.com' => 'Person Two',
//            // ..
//        );
//        foreach($recipients as $email => $name)
//        {
//            $mail->AddAddress($email, $name);
//        }



        $emails = $_POST['emails'];
        $subject = $_POST['subject'];
        $msg = $_POST['msg'];


        Ib_Email::bulk_email($emails,$subject,$msg,$user->username);

        echo 'Mail Sent!';


//       if(Ib_Email::bulk_email($emails,$subject,$msg,$user->username)){
//
//           echo 'Mail Sent!';
//
//       }
//
//        else{
//
//            echo 'An Error Occurred while sending email.';
//
//        }




        break;

    case 'scholarship_students' :
        $gid = route(2);

            if(!$gid || $gid == ''){
                $g = ORM::for_table('crm_groups')->find_many();
                
                $gid    =   $g[0]->id; 
            }
                $g = ORM::for_table('crm_groups')->find_one($gid);
                if($gid){
                    
                    $d = ORM::for_table('crm_accounts')->select('crm_accounts.*,sys_scholarship.*')->_add_join_source( 'left' , 'sys_stud_feeconfig' , array( 'crm_accounts.id' , '=' , 'sys_stud_feeconfig.student_id' ))->where('crm_accounts.gid',$gid)->where_not_equal('sys_stud_feeconfig.scholarship_id','0')->order_by_desc('id')->find_many();

                    $tot_inv        =   0;
                    $tot_pay        =   0;
                    $tot_due        =   0;
                    
                    foreach($d as $key=>$stud) {
                        $total_invice_amount        =   0;
                        $total_payed_amount         =   0;
                        $stud_invoice           =   ORM::for_table('sys_transactions')->where('payeeid',$stud['id'])->sum('dr');
                        $stud_payment           =   ORM::for_table('sys_transactions')->where('payerid',$stud['id'])->sum('cr');
                        if($stud_invoice)
                            $total_invice_amount            =   $total_invice_amount+$stud_invoice;
                        if($stud_payment)
                            $total_payed_amount             =   $total_payed_amount+$stud_payment;

                        $d[$key]['total_invoice']           =   $total_invice_amount;
                        $d[$key]['total_payment']           =   $total_payed_amount;
                        $total_due_amount                   =   $total_invice_amount-$total_payed_amount;
                        $d[$key]['total_pending']           =   $total_due_amount;
                        $tot_inv                            =   $tot_inv+$total_invice_amount;
                        $tot_pay                            =   $tot_pay+$total_payed_amount;
                        $tot_due                            =   $tot_due+$total_due_amount;

                    }
                    $ui->assign('tot_inv',$tot_inv);
                    $ui->assign('tot_pay',$tot_pay);
                    $ui->assign('tot_due',$tot_due);
                    $ui->assign('d',$d);
                    $ui->assign('gid',$gid);

                    $ui->assign('xjq',' $(".cdelete").click(function (e) {
            e.preventDefault();
            var id = this.id;
            bootbox.confirm("'.$_L['are_you_sure'].'", function(result) {
               if(result){
                   var _url = $("#_url").val();
                   window.location.href = _url + "delete/crm-user/" + id + "/'.$gid.'/";
               }
            });
        });
    ');

                $ui->display('contacts-by-scholarship.tpl');


            }

        break;

    default:
        echo 'action not defined';
}