<?php
define("CURRENT_INSTANCE","beta_merge");
define("SH_CURRENT_INSTANCE",CURRENT_INSTANCE);

$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://';
define('CURRENT_HTTP_PROTOCOL',$protocol);
define("SH_CURRENT_SCHOOL_DB",SH_CURRENT_INSTANCE);
define("SH_CURRENT_FI_DB",SH_CURRENT_SCHOOL_DB);
define("SH_DOCUMENTS", serialize (array('Transfer Certificate','Marks Sheets','Birth Certificate')));
define('DB_USER', 'root');
if($_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='localhost:8080' || $_SERVER['HTTP_HOST']=='192.168.89.1'){
    define('DB_PASS', '');
}else{
    define('DB_PASS', '6syDmECEyqLneAULy2NYtbSLpCqy727M');
}

define('SMS_IP_ADDR', '52.29.203.220');
define('CURRENT_IP_ADDR', '52.14.91.109');

define('SECRET', 'sharademorar');