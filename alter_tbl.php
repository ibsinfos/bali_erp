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
	
	// GET Columns
	$columnSel = mysqli_query($conn,"select COLUMN_NAME from COLUMNS where TABLE_NAME = '".$tables['TABLE_NAME']."' AND TABLE_SCHEMA = '".$dbName."'");
	
	$exp = array();
	while($columns = mysqli_fetch_assoc($columnSel)) {
		$exp[]=$columns['COLUMN_NAME'];
	}
	
	// IF COLUMN DOES NOT EXIST
	if(!in_array($colName,$exp)) {
		$sel= "ALTER TABLE ".$tables['TABLE_NAME']." ADD COLUMN $colName INT(11)";
		mysqli_query($conn1,$sel);
	}
}
?>