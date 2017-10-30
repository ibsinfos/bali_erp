<?php
    $url = CURRENT_HTTP_PROTOCOL.$_SERVER['HTTP_HOST'].'/'.SH_CURRENT_INSTANCE;
    $db_host	    = 'localhost';
    $db_user        = DB_USER;
    $db_password    = DB_PASS;
    $db_name	    = SH_CURRENT_FI_DB;//$_COOKIE['CURRENT_FI_DB'];
    if($_SERVER['HTTP_HOST']=='52.29.203.220' || $_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='localhost:8080'){
        $url = CURRENT_HTTP_PROTOCOL.$_SERVER['HTTP_HOST'].'/'.SH_CURRENT_INSTANCE;
    } else {
        $url = CURRENT_HTTP_PROTOCOL.$_SERVER['HTTP_HOST'];
    }
    define('APP_URL', $url.'/fi');
    $APP_URL_ARR= explode('/', APP_URL);
    $school_url=$APP_URL_ARR[0]."//".$APP_URL_ARR[2].'/'.$APP_URL_ARR[3].'/';
    if($db_name==""){
        define("SCHOOL_URL",$school_url);
        header("location:".SCHOOL_URL);
    }
    $_app_stage = 'Live'; // You can set this variable Live to Dev to enable ibilling Debug

$now = time();
@session_start();
if($now > $_SESSION['expire']){ 
    session_destroy();
}