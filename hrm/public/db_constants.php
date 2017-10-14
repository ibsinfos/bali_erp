<?php
//require dirname(__FILE__).'/../../application/config/shared_constant.php';
$documentRoot=$_SERVER['DOCUMENT_ROOT'];
$share_constant_path='/application/config/shared_constant.php';
$url_arr=explode('/', $_SERVER['PHP_SELF']);

if($_SERVER['HTTP_HOST']=='52.14.35.190' || $_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='localhost:8080'){
    $share_constant_full_path=$documentRoot.'/'.$url_arr[1].$share_constant_path;
}else{
    $share_constant_full_path=$documentRoot.$share_constant_path;
}
//die($share_constant_full_path);
//require dirname(__FILE__).'/../../application/config/shared_constant.php';
require $share_constant_full_path;

defined('SENTRIFUGO_HOST') || define('SENTRIFUGO_HOST','localhost');
defined('SENTRIFUGO_USERNAME') || define('SENTRIFUGO_USERNAME',DB_USER);
defined('SENTRIFUGO_PASSWORD') || define('SENTRIFUGO_PASSWORD',DB_PASS);
defined('SENTRIFUGO_DBNAME') || define('SENTRIFUGO_DBNAME',SH_CURRENT_SCHOOL_DB); 
?>
