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



$do = route(1);

    if($_SERVER['HTTP_HOST']=='52.29.203.220' || $_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='localhost:8080'){
        $url = CURRENT_HTTP_PROTOCOL.$_SERVER['HTTP_HOST'].'/'.SH_CURRENT_INSTANCE."/index.php?school_admin/dashboard";
    } else {
        $url = CURRENT_HTTP_PROTOCOL.$_SERVER['HTTP_HOST']."/index.php?school_admin/dashboard";
    }
        
//        if (isset($_COOKIE['PHPSESSID'])) {
//            unset($_COOKIE['PHPSESSID']);
//            unset($_COOKIE['PHPSESSID']);
//            setcookie('PHPSESSID', null, -1, '/');
//            setcookie('PHPSESSID', null, -1, '/');
//        }

if($do == ''){
    
    $do     =   'post';
    
}
switch($do){
    case 'post':
        
        $username               =   $_COOKIE['username'];
        $password               =   $_COOKIE['password'];
        $running_year           =   $_COOKIE['running_year'];
        
        if( $username== '' || $password == '') {
            
            header('location: '.$url);die();
        } 
        $username = filter_var($username, FILTER_SANITIZE_STRING);
        $username = addslashes($username);
        $password = addslashes($password);

        $after = route(2);
        $rd = U.$config['redirect_url'].'/';

        if($after != ''){
            $after = str_replace('*','/',$after);
            $rd = U.$after.'/';
        }
        
        if($username != '' AND $password != ''){
            $d = ORM::for_table('sys_users')->where('username',$username)->find_one();
            if($d){
                $d_pass = $d['password'];
                if(Password::_verify($password,$d_pass) == true){
                    //Now check if OTP is enabled
                    if($d['otp'] == 'Yes'){
//                Otp::make($d['id']);
//                $_SESSION['tuid'] = $d['id'];
//
//                r2(U.'otp');
                    }
                    else{
                        $_SESSION['running_year']       =   $running_year;
                        $_SESSION['uid']                =   $d['id'];
                        $_SESSION['school_id']          =   $d['school_id'];
                        $d->last_login                  =   date('Y-m-d H:i:s');
                        $d->save();
                        //login log

                        _log($_L['Login Successful'].' '.$username,'Admin',$d['id']);

                        setcookie("tplsub", 'default', time()+15552000);

                        if(!isset($config['build']) OR ($config['build'] < $file_build)){
                            r2(U.'update/');
                        }




//                if ((isset($routes['2'])) AND (($routes['2'] != ''))){
//                    $rd =  $routes['2'];
//                    exit($rd);
//                }

                        r2($rd);
                    }

                }
                else{
                    header('location: '.$url);die();
                    _msglog('e',$_L['Invalid Username or Password']);
                    _log($_L['Failed Login'].' '.$username,'Admin');
                    r2(U.'login');
                }
            }
            else {
                header('location: '.$url);
                _msglog('e',$_L['Invalid Username or Password']);

                r2(U.'login/');
            }
        }

        else{
            header('location: '.$url);
            _msglog('e',$_L['Invalid Username or Password']);

            r2(U.'login/');
        }


        break;

    case 'login-display':
        header('location: '.$url);
        // added param after

        $ui->display('login.tpl');

        break;

    case 'forgot-pw':
        header('location: '.$url);
        $ui->display('forgot-pw.tpl');
        break;

    case 'forgot-pw-post':
        header('location: '.$url);
        $username = _post('username');
        $d = ORM::for_table('sys_users')->where('username', $username)->find_one();
        if ($d) {

            $xkey = _raid('10');
            $d->pwresetkey = $xkey;
            $d->keyexpire = time() + 3600;

            $d->save();

            $e = ORM::for_table('sys_email_templates')->where('tplname','Admin:Password Change Request')->find_one();

            $subject = new Template($e['subject']);
            $subject->set('business_name', $config['CompanyName']);
            $subj = $subject->output();
            $message = new Template($e['message']);
            $message->set('name', $d['fullname']);
            $message->set('business_name', $config['CompanyName']);
            $message->set('password_reset_link', U.'login/pwreset-validate/'.$d['id'].'/token_'.$xkey);
            $message->set('username', $d['username']);
            $message->set('ip_address', $_SERVER["REMOTE_ADDR"]);
            $message_o = $message->output();
            Notify_Email::_send($d['fullname'],$d['username'],$subj,$message_o);

            _msglog('s',$_L['Check your email to reset Password']);

            r2(U.'login/');

        } else {
            header('location: '.$url);
            _msglog('e',$_L['User Not Found'].'!');

            r2(U.'login/forgot-pw/');
        }

        break;

    case 'pwreset-validate':
        header('location: '.$url);
        $v_uid = $routes['2'];
        $v_token = $routes['3'];
        $v_token = str_replace('token_','',$v_token);

        $d = ORM::for_table('sys_users')->find_one($v_uid);

        if($d){

            $d_token = $d['pwresetkey'];
            if($v_token != $d_token){
                r2(U.'login/','e',$_L['Invalid Password Reset Key'].'!');
            }
            $keyexpire = $d['keyexpire'];
            $ctime = time();
            if ($ctime > $keyexpire) {
                r2(U.'login/','e',$_L['Password Reset Key Expired']);
            }
            $password = _raid('6');
            $npassword = Password::_crypt($password);

            $d->password = $npassword;
            $d->pwresetkey = '';
            $d->keyexpire = '0';
            $d->save();

            $e = ORM::for_table('sys_email_templates')->where('tplname','Admin:New Password')->find_one();

            $subject = new Template($e['subject']);
            $subject->set('business_name', $config['CompanyName']);
            $subj = $subject->output();
            $message = new Template($e['message']);
            $message->set('name', $d['fullname']);
            $message->set('business_name', $config['CompanyName']);
            $message->set('login_url', U.'login/');
            $message->set('username', $d['username']);
            $message->set('password', $password);
            $message_o = $message->output();
            Notify_Email::_send($d['fullname'],$d['username'],$subj,$message_o);

            _msglog('s',$_L['Check your email to reset Password'].'.');

            r2(U.'login/');

        }

        break;

    case 'where':
        
        r2(U.'login');


        break;

    case 'after':
        header('location: '.$url);
        $after = route(2);

        $ui->assign('after',$after);

        $ui->display('login.tpl');

        break;




    default:
        
        $ui->display('login.tpl');
        break;
}
