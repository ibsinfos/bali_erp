<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(!function_exists('generate_roll_no')){
    function generate_roll_no($class_id,$section_id){
        if($section_id=="" || $section_id == ""){
            return FALSE;
        }else{
            $CI=&get_instance();
            $sqlRoll="SELECT MAX(roll) latest_roll FROM enroll WHERE class_id='".$class_id."' AND section_id='".$section_id."'";
            generate_log($sqlRoll);
            $rsRoll=$CI->db->query($sqlRoll)->result_array();
            generate_log(serialize($rsRoll));
            generate_log("==".$rsRoll[0]['latest_roll']."==");
            if(count($rsRoll)>0 || $rsRoll[0]['latest_roll']!=NULL || $rsRoll[0]['latest_roll']!=""){
                return (int)$rsRoll[0]['latest_roll']+1;
            }else{
                return 1;
            }
        }
    }
}

if(!function_exists('get_user_img_url')){
    function get_user_img_url($type,$id){
        //echo $type.$id; exit;
        if (file_exists('uploads/' . $type . '_image/' . $id . '.jpg')){
            $image_url = base_url() . 'uploads/' . $type . '_image/' . $id . '.jpg';
            //echo $image_url; exit;
        }else{
            $image_url = base_url() . 'uploads/user.jpg';
        //echo $image_url. "fgfg"; exit; http://localhost/beta_ag/uploads/admin_image/1.jpg
        }
        return $image_url;
    }
}

if(!function_exists('create_school_data_backup')){
    function create_school_data_backup($backupFilename,$backup_drive){
        generate_log("calling create_mysql_manual_back_up_current_db.log()","create_mysql_manual_back_up_current_db.log");
        date_default_timezone_set('Asia/Calcutta');
        
        $CI=&get_instance();
        $CI->load->dbutil();
        $tables         =       $CI->db->list_tables(); 
        $statement_values   =   '';
        $statement_values   .=   'SET @TRIGGER_BEFORE_INSERT_CHECKS = FALSE;'.PHP_EOL;
        $statement_values   .=   'SET @TRIGGER_AFTER_INSERT_CHECKS = FALSE;'.PHP_EOL;
        $statement_values   .=   'SET @TRIGGER_BEFORE_UPDATE_CHECKS = FALSE;'.PHP_EOL;
        $statement_values   .=   'SET @TRIGGER_AFTER_UPDATE_CHECKS = FALSE;'.PHP_EOL;
        $statement_values   .=   'SET @TRIGGER_BEFORE_DELETE_CHECKS = FALSE;'.PHP_EOL;
        $statement_values   .=   'SET @TRIGGER_AFTER_DELETE_CHECKS = FALSE;'.PHP_EOL;
        $statement_values   .=   'SET FOREIGN_KEY_CHECKS=0;'.PHP_EOL;
        $statement_query    =   '';
        $prev_table_name="";
        $skipTableBackupArr=array('member','member1');
        $skipTableArr=array();
        foreach ($tables as $table_names){
            generate_log("start for ".$table_names,"database_data_backup_log_".CURRENT_INSTANCE.".log");
            if(in_array($table_names, $skipTableBackupArr)){
                continue;
            }
            if(!in_array($table_names, $skipTableArr)){
                if($table_names=='main_currency'){
                    $statement_values.=PHP_EOL."TRUNCATE TABLE `tm_emp_timesheets`;".PHP_EOL;
                    $statement_values.=PHP_EOL."TRUNCATE TABLE `tm_projects`;".PHP_EOL;
                }
                $statement_values.=PHP_EOL."TRUNCATE TABLE `".$table_names."`;".PHP_EOL;
            }
            generate_log("just before taking data from table get_data_generic_fun(): ".$table_names,"database_data_backup_log_".CURRENT_INSTANCE.".log");
            $statement =  get_data_generic_fun($table_names,'*',array(),'result_arr');
            if(!empty($statement)){
                foreach ($statement as $key => $post) {
                    if(isset($statement_values)) {
                        $statement_values .= "\n";
                    }
                    $values = array_values($post);
                    foreach($values as $index => $value) {
                        $quoted = str_replace("'","\'",str_replace('"','\"', $value));
                        $values[$index] = (!isset($value) ? 'NULL' : "'" . $quoted."'") ;
                    }
                $statement_values .="insert into ".$table_names." values "."(".implode(',',$values).");";
                }
                generate_log("get_data_generic_fun() return data for : ".$table_names." ==== ".$statement_values,"database_data_backup_log_".CURRENT_INSTANCE.".log");
            }else{
                generate_log("get_data_generic_fun() return no data : ".$table_names,"database_data_backup_log_".CURRENT_INSTANCE.".log");
            }
            $statement = $statement_values . ";";     
        }
        $statement_values   .=   PHP_EOL.'SET @TRIGGER_BEFORE_INSERT_CHECKS = TRUE;'.PHP_EOL;
        $statement_values   .=   'SET @TRIGGER_AFTER_INSERT_CHECKS = TRUE;'.PHP_EOL;
        $statement_values   .=   'SET @TRIGGER_BEFORE_UPDATE_CHECKS = TRUE;'.PHP_EOL;
        $statement_values   .=   'SET @TRIGGER_AFTER_UPDATE_CHECKS = TRUE;'.PHP_EOL;
        $statement_values   .=   'SET @TRIGGER_BEFORE_DELETE_CHECKS = TRUE;'.PHP_EOL;
        $statement_values   .=   'SET @TRIGGER_AFTER_DELETE_CHECKS = TRUE;'.PHP_EOL;
        $statement_values   .=   'SET FOREIGN_KEY_CHECKS=1;'.PHP_EOL;
        $backup         =   $statement_values;
        //echo $backup;die;
        generate_log("helper init for save the backup data to SQL : ","create_mysql_manual_back_up_current_db.log");
        $CI->load->helper('file'); 
        generate_log("back_up_file_full_path : ".$backup_drive.$backupFilename,"create_mysql_manual_back_up_current_db.log");
        write_file($backup_drive.$backupFilename, $backup);
        //die("write done");
        generate_log("going back to main function : ","create_mysql_manual_back_up_current_db.log");
        return $backupFilename;
    }
}


if(!function_exists('get_bread_crumb')){
    function get_bread_crumb_old(){
        $CI=&get_instance();
        $AllLinks = $CI->session->all_userdata();
        $BreadCrumb = '';
        if(count($AllLinks) && isset($AllLinks['arrAllLinks']) && is_array($AllLinks['arrAllLinks'])){
            foreach($AllLinks['arrAllLinks'] as $k => $datum){
                if(count($datum)){                
                    foreach($datum as $k2 => $datum2){

                        if($CI->uri->segment(1)=='fees'){
                            $segment = $CI->uri->segment(1).'/'.$CI->uri->segment(2).'/'.$CI->uri->segment(3);
                        }else{
                            $segment = $CI->uri->segment(1).'/'.$CI->uri->segment(2);                            
                        }


                        if(is_array($datum2) && in_array($segment, $datum2)){
                            $ExpMainKey = explode('?', $k);
                            $BreadCrumb = $ExpMainKey[0];

                            if(count($datum)>1){
                                $BreadCrumb.='^<ul>';

                                foreach($datum as $k3 => $datum3){
                                    foreach($datum3 as $k4 => $datum4){
                                        if(!in_array($segment, $datum3)){
                                            $BreadCrumb .='<li><a href="'.base_url('index.php?').$datum4.'">'.get_phrase($k3).'</a></li>';
                                        }
                                    }
                                }
                                $BreadCrumb.='</ul>^'.' _'.$k2; 
                            }else{
                                $BreadCrumb = $k2;    
                            }
                        }
                    }
                }
            }
        }
        return $BreadCrumb;
    }

    function get_bread_crumb(){
        $CI=&get_instance();
        $CI->load->dbutil();

        $rec = $CI->db->get_where('session_links',array('id'=>$CI->session->userdata('session_link_id')))->row();

        $links = $rec?json_decode($rec->links,true):array();

        $BreadCrumb = '';

        if($CI->uri->segment(1)=='fees'){
            $segment = $CI->uri->segment(1).'/'.$CI->uri->segment(2).'/'.$CI->uri->segment(3);
        }else{
            $segment = $CI->uri->segment(1).'/'.$CI->uri->segment(2);
        }

        if((count($links)) && ($segment!='')){
            $seg = rtrim($segment, '/');
            $rs = get_current_url_nav($seg, $links);
            if(is_array($rs) && count($rs) > 0){
                $rs_key = key($rs);
                $BreadCrumb = $links[$rs_key]['name'];

                if(count($links[$rs_key]['children'])){
                    $BreadCrumb.= create_breadcrumb($links[$rs_key]['children'], $seg);
                }
            }
        }

        return $BreadCrumb;
    }
}

    if(!function_exists('get_current_url_nav')){
        function get_current_url_nav($child, $stack) {
            foreach ($stack as $k => $v) {
                if (is_array($v)) {            
                    $return = get_current_url_nav($child, $v);

                    if (is_array($return)) {
                        return array($k => $return);
                    }
                } else {
                    if ($v == $child) {
                        return array($k => $child);
                    }
                }
            }
            return false;
        }
    }


    if(!function_exists('create_breadcrumb')){
        function create_breadcrumb($links = array(), $segment=''){
            $BreadCrumb = '';
            $active = '';
            if(count($links)){
                $BreadCrumb.='^<ul>';
                foreach ($links as $datum) {
                    if($datum['link']!=$segment){
                        $url = $datum['name'] == 'lms' ? base_url($datum['link']):base_url('index.php?'.$datum['link']);

                        $BreadCrumb .='<li><a href="'.$url.'">'.get_phrase($datum['name']).'</a></li>';
                    }else{
                        $active = $datum['name'];
                    }                  
                }
                $BreadCrumb.='</ul>^'.' _'.$active;
            }
            return $BreadCrumb;
        }
    }    

    if(!function_exists('_unique_sch')){
        function _unique_sch($val=false,$field=false){
            $CI=&get_instance();
            $CI->load->dbutil();
            $first = $field?explode('.',$field):false;
            $tbl = $first?$first[0]:false;
            $fcol = $first?$first[1]:false;
            if(!$tbl || !$fcol)
                return FALSE;
            $whr = array($fcol=>$val,'school_id');
            if($CI->session->userdata('school_id'))
                $whr['school_id'] = $CI->session->userdata('school_id');

            $record = $CI->db->get_where($tbl, $whr)->row();

            if($record){
                $CI->form_validation->set_message('_unique_sch', 'The {field} is already in records!');
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }

    if(!function_exists('_unique_field')){
        //Unique Field Rules
        function _unique_field($val=false,$field=false){
            $CI=&get_instance();
            $CI->load->dbutil();

            $paras = explode('#',$field);
            $first = isset($paras[0])?explode('.',$paras[0]):array();
            $tbl = $first?$first[0]:false;
            $fcol = $first?$first[1]:false;
            if(!$tbl || !$fcol)
                return TRUE;

            $whr = array($fcol=>$val);
            foreach($paras as $i=>$par){
                $parv = false;
                if($i!=0)
                    $parv = $par?explode('.',$par):array();  
                if($parv)
                    $whr[$parv[0]] = $parv[1];
            }
            $record = $CI->db->get_where($tbl, $whr)->row();

            if($record){
                $CI->form_validation->set_message('_unique_field', 'The {field} is already in records!');
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }

    if(!function_exists('_unique_field_sch')){
        function _unique_field_sch($val=false,$field=false){
            $CI=&get_instance();
            $CI->load->dbutil();

            $paras = explode('#',$field);
            $first = isset($paras[0])?explode('.',$paras[0]):array();
            $tbl = $first?$first[0]:false;
            $fcol = $first?$first[1]:false;
            if(!$tbl || !$fcol)
                return TRUE;

            $whr = array($fcol=>$val);
            foreach($paras as $i=>$par){
                $parv = false;
                if($i!=0)
                    $parv = $par?explode('.',$par):array();  
                if($parv)
                    $whr[$parv[0]] = $parv[1];
            }
            if($CI->session->userdata('school_id'))
                $whr['school_id'] = $CI->session->userdata('school_id');
            $record = $CI->db->get_where($tbl, $whr)->row();

            if($record){
               $CI->form_validation->set_message('_unique_field_sch', 'The {field} is already in records!');
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }

    if(!function_exists('_school_cond')){
        function _school_cond($colmn=false,$param=false){
            $CI=&get_instance();
            $CI->load->dbutil();
            $colmn = $colmn?$colmn:'school_id';    
            $param = $param?$param:$CI->session->userdata('school_id');

            $whr = array();
            if($param)
                $whr[$colmn] = $param;
            $CI->db->where($whr);
        }
    }

    if(!function_exists('_year_cond')){
        function _year_cond($colmn=false,$param=false){
            $CI=&get_instance();
            $CI->load->dbutil();
            $colmn = $colmn?$colmn:'running_year';    
            $param = $param?$param:$CI->session->userdata('running_year');

            $whr = array();
            if($param)
                $whr[$colmn] = $param;
            $CI->db->where($whr);
        }
    }

    if(!function_exists('_form_array_check')){
        function _form_array_check(){
            $CI=&get_instance();
            $CI->load->dbutil();

            $whr = array();
            if($CI->session->userdata('school_id'))
                $whr['school_id'] = $CI->session->userdata('school_id');
            $CI->db->where($whr);
        }
    }

    function get_session_links($sess_link_id=false){
        
        $CI=&get_instance();
        $CI->load->dbutil();
        $rec = $CI->db->get_where('session_links',array('id'=>$sess_link_id))->row();
        $links = $rec?json_decode($rec->links,true):array();
        buildMenu($links);
    }

    
    function buildTree(array $elements, $parentId = 0) {
        $branch = array();
    
        foreach ($elements as $element) {
            if($parentId==0){
                $has_parent = 0;
                foreach($elements as $ele){
                    if($element['parent_id']==$ele['id']){
                        $has_parent += 1;
                    }
                }
                if($element['parent_id'] != 0 && $has_parent==0){
                    $childern = array();
                    foreach ($elements as $elem) {
                        if($elem['parent_id'] ==  $element['id']){
                            $childern[] = $elem;
                        }
                    }

                    $element['children'] = $childern;//buildTree($elements, $element['id']);
                    $branch[] = $element;  
                }
            }

            if ($element['parent_id'] == $parentId) {// || $parentId==0
                $childern = array();
                foreach ($elements as $elem) {
                    if($elem['parent_id'] == $element['id']){
                        $childern2 = array();
                        foreach ($elements as $elem3) {
                            if($elem3['parent_id'] == $elem['id']){
                                $childern2 [] = $elem3;
                            }
                        }
                        $elem['children'] = $childern2;
                        $childern[] = $elem;
                    }
                }
                $element['children'] = $childern;//buildTree($elements, $element['id']);
                $branch[] = $element;
            }
        }
    
        return $branch;
    }

    function buildMenu(array $elements, $parentId = 0) {
        foreach ($elements as $element) {
            if($element['parent_id']==$parentId || $parentId==0){
                $element['children'] = isset($element['children'])?$element['children']:array();
                $icon = explode(',',$element['image']);
                $url = ($element['name'] == 'lms' || strtolower($element['name']) == 'hrm') ? base_url().$element['link']:base_url('index.php?'.$element['link']);
                //echo $url;
                echo '<li class="p-0 menu-item-tile '.($element['children']?'has-submenu':'').'">
                        <a href="'.(!$element['children']?$url:'#').'" class="waves-effect active menu-items text-center">
                            <i class="'.$icon[0].'"></i>
                            '.(isset($icon[1])?'<i class="'.$icon[1].'"></i>':'').
                            '<span class="menu-text">'.get_phrase($element['name']).'</span>
                        </a>
                      </li>';
                if ($element['children']) {
                    echo '<ul class="nav p-r-0 list-inline">';
                    buildMenu($element['children'], $element['id']);
                    echo "</ul>";
                }
            }
        }
    }

    function unique_multidim_array($array, $key) { 
        $temp_array = array(); 
        $i = 0; 
        $key_array = array(); 
        
        foreach($array as $val) { 
            if (!in_array($val[$key], $key_array)) { 
                $key_array[$i] = $val[$key]; 
                $temp_array[$i] = $val; 
            } 
            $i++; 
        } 
        return $temp_array; 
    }

    /* $arrModule = $this->session->userdata('arrAllLinks');
    $arrModule = $arrModule?$arrModule:array();
    buildMenu($arrModule); */

    function create_passcode($type=''){
        if(!empty($type)){
            if($type==='parent'){
                $passcode = "spa" . mt_rand(10000000, 99999999);
                return $passcode;
            }else if($type==='admin'){
                $passcode = "sad" . mt_rand(10000000, 99999999);
                return $passcode;
            }else if($type==='teacher'){
                $passcode = "sta" . mt_rand(10000000, 99999999);
                return $passcode;
            }else if($type==='bus_driver'){
                $passcode = "dri" . mt_rand(10000000, 99999999);
                return $passcode;
            }else if($type==='student'){
                $passcode = "stu" . mt_rand(10000000, 99999999);
                return $passcode;
            }else if($type==='school_admin'){
                $passcode = "sch" . mt_rand(10000000, 99999999);
                return $passcode;
            }else if($type==='accountant'){
                $passcode = "sac" . mt_rand(10000000, 99999999);
                return $passcode;
            }else if($type==='cashier'){
                $passcode = "sca" . mt_rand(10000000, 99999999);
                return $passcode;
            }else if($type==='doctor'){
                $passcode = "sdr" . mt_rand(10000000, 99999999);
                return $passcode;
            }else if($type==='bus_admin'){
                $passcode = "sba" . mt_rand(10000000, 99999999);
                return $passcode;
            }else if($type==='super_admin'){
                $passcode = "sup" . mt_rand(10000000, 99999999);
                return $passcode;
            }else if($type==='hostel_admin'){
                $passcode = "sha" . mt_rand(10000000, 99999999);
                return $passcode;
            }else{
                return 'invalid';
            }            
        }else{
            return 'invalid';
        }
    }