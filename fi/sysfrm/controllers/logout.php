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
//session_destroy();
    if (isset($_SERVER['SERVER_NAME'])) {
        $server = sprintf("%s://%s%s", isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http', $_SERVER['SERVER_NAME'], '/');
    } else {
        $server = sprintf("%s://%s%s", isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http', $_SERVER['SERVER_ADDR'], '/');
    }
    if($_SERVER['HTTP_HOST']=='52.29.203.220' || $_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='localhost:8080' || $_SERVER['HTTP_HOST']=='52.14.35.190'){
	$url = CURRENT_HTTP_PROTOCOL.$_SERVER['HTTP_HOST'].'/'.CURRENT_INSTANCE."/index.php?school_admin/dashboard";
}else{
	$url = CURRENT_HTTP_PROTOCOL.$_SERVER['HTTP_HOST']."/index.php?school_admin/dashboard";
}
    $server_self = $_SERVER['PHP_SELF'];//'http://ftk.rarome.com/fi/?ng=dashboard/';
    //echo  $server_self ;exit;
    $bf_fi = substr($server_self, 0, strpos($server_self, '/fi'));
    $url_arr=explode('/', $bf_fi);
    //echo '<pre>';print_r($url_arr);exit;
    //$url_arr=explode('/', $_SERVER['PHP_SELF']);
    $url=$server.$url_arr[1]."/index.php?school_admin/dashboard";
    //$url    =   APP_URL;
        if (isset($_COOKIE['PHPSESSID'])) {
            unset($_COOKIE['PHPSESSID']);
            setcookie('PHPSESSID', null, -1, '/');
        }
    header('location: '.$url);