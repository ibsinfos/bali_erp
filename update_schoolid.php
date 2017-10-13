<?php
error_reporting(E_ALL);

//$host = 'localhost';
//$uname = 'agilemte_soft';
//$pass = '#5hArA9*';
//$dbName = 'multischool_solution_fi';
$host = 'localhost';
$uname = 'root';
$pass = '';
$dbName = 'beta_merge';
$colName = "school_id";

$conn = mysqli_connect($host,$uname,$pass,'information_schema');
$conn1 = mysqli_connect($host,$uname,$pass,$dbName);

$getTables = mysqli_query($conn,"select TABLE_NAME from TABLES where TABLE_SCHEMA = '".$dbName."'");
$sel = "";
ini_set('max_execution_time', 0);
while($tables = mysqli_fetch_assoc($getTables)) {
    if($tables['TABLE_NAME']!='schools' && $tables['TABLE_NAME']!='school_admin') {
	$sel= "UPDATE ".$tables['TABLE_NAME']." SET school_id = '1'"; //die;
        mysqli_query($conn1,$sel);
    }
}
?>