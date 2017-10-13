<?php 

    // These variables define the connection information for your MySQL database 
    $username = "root"; 
    $password = ""; 
    $host = "localhost"; 
    $dbname = "beta"; 	
	
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 
    try { $db = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password, $options); } 
    catch(PDOException $ex){ echo header('Location: index.php'); die;} //redirect to install page if no database connection created
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
    header('Content-Type: text/html; charset=utf-8'); 
	
	$conection=mysqli_connect($host,$username,$password);
	//echo $conection;
	//die('Could not connect: ');
	if(!$conection)
	{
	    die('Could not connect: ' . mysql_error());
	}
	
	$db_selected = mysqli_select_db($conection,$dbname);
	if (!$db_selected) {
	    die ('Can\'t use foo : ' . mysql_error());
	}
    //session_start(); 
?>