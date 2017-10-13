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
$file_build = '4500';
$documentRoot=$_SERVER['DOCUMENT_ROOT'];
$share_constant_path='/application/config/shared_constant.php';
$url_arr=explode('/', $_SERVER['PHP_SELF']);

if($_SERVER['HTTP_HOST']=='52.29.203.220' || $_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='localhost:8080'){
    $share_constant_full_path=$documentRoot.'/'.$url_arr[1].$share_constant_path;
}else{
    $share_constant_full_path=$documentRoot.$share_constant_path;
}
//die($share_constant_full_path);
//require dirname(__FILE__).'/../../application/config/shared_constant.php';
require $share_constant_full_path;
require 'vendor/autoload.php';

if($_SERVER['HTTP_HOST']=='52.29.203.220' || $_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='localhost:8080'){
    $url = CURRENT_HTTP_PROTOCOL.$_SERVER['HTTP_HOST'].'/'.SH_CURRENT_INSTANCE."/index.php?school_admin/dashboard";
} else {
    $url = CURRENT_HTTP_PROTOCOL.$_SERVER['HTTP_HOST']."/index.php?school_admin/dashboard";
}
@session_start();

function r2($to, $ntype = 'e', $msg = '')
{
    if ($msg == '') {
        header("location: $to");
        exit;
    }
    $_SESSION['ntype'] = $ntype;
    $_SESSION['notify'] = $msg;
    header("location: $to");
    exit;
}

if (file_exists('sysfrm/config.php')) {
    require('sysfrm/config.php');
} else {

    r2('sysfrm/install');

}
if ($_app_stage == 'Dev') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(-1);
} else {
    error_reporting(0);
}


function safedata($value)
{
    $value = trim($value);
    return $value;
}

//Extend
function _post($param, $defvalue = '')
{
    if (!isset($_POST[$param])) {
        return $defvalue;
    } else {
        return safedata($_POST[$param]);
    }
}

function _get($param, $defvalue = '')
{
    if (!isset($_GET[$param])) {
        return $defvalue;
    } else {
        return safedata($_GET[$param]);
    }
}

function _raid($l = '6')
{
    $r = substr(str_shuffle(str_repeat('0123456789', $l)), 0, $l);
    return $r;

}

require('sysfrm/orm.php');
ORM::configure("mysql:host=$db_host;dbname=$db_name");
ORM::configure('username', $db_user);
ORM::configure('password', $db_password);
ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
ORM::configure('return_result_sets', true); // returns result sets
ORM::configure('logging', true);

if(!isset($_COOKIE['username']) || !isset($_COOKIE['password'])){
    header('Location: '.$url);
}
$username               =   $_COOKIE['username'];
$password               =   $_COOKIE['password'];
if( $username== '' || $password == '') {
    header('location: '.$url);die();
} 
$uData = ORM::for_table('sys_users')->where('username',$username)->find_one();
$_SESSION['school_id'] = $uData['school_id'];
$result = ORM::for_table('sys_appconfig')->where('school_id',$_SESSION['school_id'])->find_many();


foreach ($result as $value) {
    $config[$value['setting']] = $value['value'];
}
//echo '<pre>';print_r( $config);exit;
date_default_timezone_set($config['timezone']);
function _notify($msg, $type = 'e')
{
    $_SESSION['ntype'] = $type;
    $_SESSION['notify'] = $msg;
}

$_c = $config;
//require_once('sysfrm/lib/smarty/libs/Smarty.class.php');
$_theme = APP_URL . '/ui/theme/' . $config['theme'];
// language
$lan_file = 'sysfrm/lan/' . $config['language'] . '/common.lan.php';
require($lan_file);
// css naming
if (isset($config['design'])) {
    $design = $config['design'];
} else {

    $design = 'default';

}
//require('sysfrm/util/design_' . $design . '.php');
$ui = new Smarty();
$ui->setTemplateDir('ui/theme/' . $config['theme'] . '/');
$ui->setCompileDir('ui/compiled/');
$ui->setConfigDir('ui/conf/');
$ui->setCacheDir('ui/cache/');
$ui->assign('app_url', APP_URL . '/');
if (($config['url_rewrite']) == '1') {
    define('U', APP_URL . '/');
    $ui->assign('_url', APP_URL . '/');
    $ui->assign('base_url', APP_URL . '/');
} else {
    define('U', APP_URL . '/?ng=');
    $ui->assign('_url', APP_URL . '/?ng=');
    $ui->assign('base_url', APP_URL . '/?ng=');
}

$ui->assign('_theme', $_theme);
$ui->assign('_sysfrm_menu', 'dashboard');
$ui->assign('_title', $config['CompanyName']);
$ui->assign('_st', 'Sysfrm');
$ui->assign('_topic', 'dashboard');
$ui->assign('content_inner', '');
$ui->assign('jsvar', '');
$ui->assign('tpl_footer', true);
$ui->assign('_pls', ORM::for_table('sys_pl')->where('school_id',$_SESSION['school_id'])->where('status', '1')->find_many());

// supports custom sub template from iBilling V 3.0.0

$ui->assign('tplheader', 'sections/header_default');
$ui->assign('tplfooter', 'sections/footer_default');

$ui->assign('client_tplheader', 'sections/header_client_default');
$ui->assign('client_tplfooter', 'sections/footer_client_default');


//

function _msglog($type, $msg)
{
    $_SESSION['ntype'] = $type;
    $_SESSION['notify'] = $msg;
}


if (isset($_SESSION['notify'])) {
    $notify = $_SESSION['notify'];
    $ntype = $_SESSION['ntype'];
    if ($ntype == 's') {
        $ui->assign('notify', '<div class="alert alert-success fade in">
								<button class="close" data-dismiss="alert">
									×
								</button>
								<i class="fa-fw fa fa-check"></i>
								' . $notify . '
							</div>');

    } else {

        $ui->assign('notify', '<div class="alert alert-danger fade in">
								<button class="close" data-dismiss="alert">
									×
								</button>
								<i class="fa-fw fa fa-times"></i>
								' . $notify . '
							</div>');
    }
    unset($_SESSION['notify']);
    unset($_SESSION['ntype']);
}


//function _autoloader($class) {
//
//    if (strpos($class, '_') !== false) {
//        // $c_dir = explode($class,'_');
//        $class = str_replace('_','/',$class);
//        include 'autoload/' . $class . '.php';
//
//    }
//    else{
//        include 'autoload/' . $class . '.php';
//    }
//
//
//}
//
//spl_autoload_register('_autoloader');

function _auth()
{
    if (isset($_SESSION['uid'])) {
        return true;
    } else {

        $after = _get('ng');

        $after = str_replace('/', '*', $after);

        $after = rtrim($after, '*');

        r2(U . 'login/after/' . $after);

    }

}


// additional function

function _admin()
{
    if (isset($_SESSION['uid'])) {
        $d = ORM::for_table('user')->where('school_id',$_SESSION['school_id'])->find_one($_SESSION['uid']);
        if ($d['user_type'] == 'Admin') {
            return true;
        } else {
            r2(U . 'login/');
        }
    } else {
        r2(U . 'login/');
    }
}

require('sysfrm/functions.php');

$req = _get('ng');
$routes = explode('/', $req);
$handler = $routes['0'];
if ($handler == '') {
    $handler = 'default';
}


$plugin_ui_header_admin = array();
$plugin_ui_header_client = array();

//plugin support
$PluginManager = new Plugins();
$ps = ORM::for_table('sys_pl')->where('school_id',$_SESSION['school_id'])->where('status', '1')->order_by_asc('sorder')->find_many();

foreach ($ps as $p) {
    $PluginManager->loadPlugins($p['c']);
}

$hooks = glob('sysfrm/hooks/*{.php}', GLOB_BRACE);

if (count($hooks) != 0) {
    foreach ($hooks as $hook) {
        require_once($hook);
    }
}

require('sysfrm/plugged.php');

// routing started

Event::trigger('routing_started');
//echo '<pre>';print_r($_L);exit;

$ui->assign('_c', $config);
$ui->assign('_L', $_L);

$pl_path = '';
//

$sys_render = 'sysfrm/controllers/' . $handler . '.php';
if (file_exists($sys_render)) {
    include($sys_render);

} else {
    // exit ("$sys_render");
    //@Since v 2.4 supports routing to plugin

    $p1 = false;
    $p2 = false;

    if (isset($routes['0']) AND ($routes['0']) != '') {
        $p1 = true;
    }

    if (isset($routes['1']) AND ($routes['1']) != '') {
        $p2 = true;
    }
    if ($p1 AND $p2) {

        $dir = $routes['0'];
        $cont = $routes['1'];
        $path = 'sysfrm/plugins/' . $dir . '/' . $cont . '.php';
        $pl_path = 'sysfrm/plugins/' . $dir . '/';
        if (file_exists($path)) {
            $_pd = 'sysfrm/plugins/' . $dir;
            $ui->assign('_pd', 'sysfrm/plugins/' . $dir);
            require($path);

        }

    } else {

        r2(U . 'dashboard/', 'e', $_L['Plugin Not Found']);
    }
}
