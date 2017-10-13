<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$db_name            =   SH_CURRENT_FI_DB;
$customConn         =   mysqli_connect($db_host, $db_user, $db_password, $db_name);
if(!$customConn){
    die("Issue in connection,Check with proper information.");
}
function pre($var){
    echo '<pre>';//print_r($var);
        if(is_array($var) || is_object($var)) {
          print_r($var);
        } else {
          var_dump($var);
        }
        echo '</pre>';
}
function get_data_result($sql){
    global $customConn;
    return mysqli_query($customConn,$sql);
}
function get_result_data($sql) {
    global $customConn;
    $res = mysqli_query($customConn,$sql);
    $returnResult=array();
    // use fetch_assoc here
    while($row = $res->fetch_assoc()) {
        $returnResult[] = $row; // assign each value to array
    }
    //pre($returnResult);
    return $returnResult;//mysqli_fetch_all($res,MYSQLI_ASSOC);
}
function get_single_result($sql){
    global $customConn;
    $result=mysqli_query($customConn,$sql);
    return mysqli_fetch_row($result);
}