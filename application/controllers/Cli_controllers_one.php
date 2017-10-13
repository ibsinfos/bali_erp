<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Cli_controllers_one extends CI_Controller {

    function __construct() {
        parent::__construct();
        // If cronjob ! 
        //is_cli() OR show_404();

        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        // Expand the array displays
        ini_set('xdebug.var_display_max_depth', 5);
        ini_set('xdebug.var_display_max_children', 256);
        ini_set('xdebug.var_display_max_data', 1024);
    }
    
    function full_database_backup_at_remote_server(){
        $back_up_file_path="/var/www/html/all_instance_master_backup/";
        $back_up_file_full_name=$back_up_file_path.date('d_m_Y_').CURRENT_INSTANCE.'.sql';
        //$current_instance_path='/var/www/html/'.CURRENT_INSTANCE;
        $DbUser=DB_USER;
        $UserPassword=DB_PASS;
        
        $shell_exec_command='/var/www/html/database_full_backup.sh '.$DbUser.' '.$UserPassword.' '.CURRENT_INSTANCE.' '.$back_up_file_full_name.' '.' 2>&1 | tee -a /tmp/instance_backup_log 2>/dev/null >/dev/null &';
        generate_log('Going to fire command for shell :::'.$shell_exec_command,"schell_script_log.log");
        //$error_msg= shell_exec('mysqldump -uroot -p6syDmECEyqLneAULy2NYtbSLpCqy727M beta_ag >  /var/www/html/all_instance_master_backup/26_09_2017_beta_ag.sql');
        $error_msg= shell_exec('sudo '.$shell_exec_command .' 2>&1 | tee -a /tmp/schell_script_log 2>/dev/null >/dev/null &');
        generate_log('getting output from shell_exec() ::: '+$error_msg,"schell_script_log.log");
    }
    
    function remote_file_transfer_test(){
        
    }
    
    function full_database_instance_backup(){
        $shell_exec_command='/var/www/html/backup_db_file.sh';
        generate_log('Going to fire command to shell for db and file backup :::'.$shell_exec_command,"schell_script_log.log");
        $error_msg= shell_exec('sudo /var/www/html/backup_db_file.sh 2>&1 | tee -a /tmp/instance_create_log 2>/dev/null >/dev/null &');
    }
}