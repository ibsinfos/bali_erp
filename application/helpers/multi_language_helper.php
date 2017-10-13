<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */


if ( ! function_exists('get_phrase'))
{
	function get_phrase($phrase = '') {
		$CI	=&	get_instance();
		$CI->load->database();
        $current_language	=	$CI->db->get_where('settings' , array('type' => 'language'))->row();
        $current_language = ($current_language)?$current_language->description:'';
		
		if ( $current_language	==	'') {
			$current_language	=	'english';
			$CI->session->set_userdata('current_language' , $current_language);
		}

		/** insert blank phrases initially and populating the language db ***/
		$check_phrase_arr	=	$CI->db->get_where('language' , array('UPPER (phrase)=' => strtoupper($phrase)))->row();
                
                if(count($check_phrase_arr)>0)
                {
                    $check_phrase=  strtoupper($check_phrase_arr->phrase);
                }
                else
                {
                    $check_phrase="";
                }
		if ( $check_phrase	!= strtoupper($phrase))
			$CI->db->insert('language' , array('phrase' => $phrase));
			
		
		// query for finding the phrase from `language` table
		$query	=	$CI->db->get_where('language' , array('phrase' => $phrase));
		$row   	=	$query->row();	
		
		// return the current sessioned language field of according phrase, else return uppercase spaced word
		if (isset($row->$current_language) && $row->$current_language !="")
			return $row->$current_language;
		else 
			return ucwords(str_replace('_',' ',$phrase));
	}
}


if ( ! function_exists('pre')){
    function pre($var){ //die('rrr');
        echo '<pre>';//print_r($var);
        if(is_array($var) || is_object($var)) {
          print_r($var);
        } else {
          var_dump($var);
        }
        echo '</pre>';
    }
}

    function generate_log($message,$log_file_name="",$isOverwritting=FALSE){
        $dir=$_SERVER['DOCUMENT_ROOT'];
        //die($dir);
        if($_SERVER['HTTP_HOST']==CURRENT_IP_ADDR || $_SERVER['HTTP_HOST']==SMS_IP_ADDR || $_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='localhost:8080'){
            $dir .= '/'.CURRENT_INSTANCE.'/uploads/';
        }else{
                $dir .= '/uploads/';
        }
        if($log_file_name==""){
            $log_file_path=$dir.'demo_school_curl_'.date('Y-m-d').'.log';
        }else{
            $log_file_path=$dir.$log_file_name;
        }
        //echo $log_file_path;die;
        if($isOverwritting == FALSE){
            $fileOpenType = 'a+';
        }else{
            $fileOpenType = 'w+';
        }   
        if (!$handle = fopen($log_file_path, $fileOpenType)) {
            return false;
        }else{
            $message.=PHP_EOL;
            if (fwrite($handle, $message) === FALSE) {
                return false;
            }else{
                fclose($handle);
            }
        }
    }
    
 if ( ! function_exists('set_machin_active_log')){
    function set_machin_active_log($msg,$heading=""){
        $dir='/var/www/html/';
        $log_file_path=$dir.'machichine_activity_'.date('Y-m-d').'_log.log';
        if (!$handle = fopen($log_file_path, 'a+')) {
            return false;
        }else{
            if($heading==""):
                $message="\n".$msg.PHP_EOL;
            else:
                $message=PHP_EOL.'Content for the for now ===='.date('Y-m-d H:i:s').'==== '.PHP_EOL;
                $message.=$msg.PHP_EOL;
            endif;
            if (fwrite($handle, $message) === FALSE) {
                return false;
            }else{
                fclose($handle);
                return TRUE;
            }
        }
    }
}
 
if ( ! function_exists('set_machine_data_test_log')){
    function set_machine_data_test_log($msg,$heading=""){
        $dir='/var/www/html/';
        $log_file_path=$dir.'machichine_data_test'.date('Y-m-d').'_log.log';
        if (!$handle = fopen($log_file_path, 'a+')) {
            return false;
        }else{
            if($heading==""):
                $message="\n".$msg.PHP_EOL;
            else:
                $message=PHP_EOL.'Content for the for now ===='.date('Y-m-d H:i:s').'==== '.PHP_EOL;
                $message.=$msg.PHP_EOL;
            endif;
            if (fwrite($handle, $message) === FALSE) {
                return false;
            }else{
                fclose($handle);
                return TRUE;
            }
        }
    }
}
if ( ! function_exists('str_putcsv')){
function str_putcsv($data) {
        # Generate CSV data from array
        $fh = fopen('php://temp', 'rw'); # don't create a file, attempt
                                         # to use memory instead

        # write out the headers
        fputcsv($fh, array_keys(current($data)));

        # write out the data
        foreach ( $data as $row ) {
                fputcsv($fh, $row);
        }
        rewind($fh);
        $csv = stream_get_contents($fh);
        fclose($fh);

        return $csv;
}
}
if ( ! function_exists('success_response_after_post_get')){
    function success_response_after_post_get($parram){
        $result=array();
        if(!array_key_exists('ajaxType', $parram)):
            if(array_key_exists('master_ip', $parram)){
                $result=  get_default_urls($parram['master_ip']);    
            }else{
                $result=  get_default_urls();    
            }
        endif;
        //$result['message']="Shipping address data updated successfully.";
        $result['timestamp'] = time();
        if(!empty($parram)):
            foreach ($parram as $k => $v){
                $result[$k]=$v;
            }
        endif;
        
        header('Content-type: application/json');
        echo json_encode($result);
    }
}

if ( ! function_exists('get_default_urls')){
    function get_default_urls($ip=SMS_IP_ADDR){
        $result=array();
        $result['site_logo_image_url']='http://'.$ip.'/upload/';
        $result['site_image_url']='http://'.$ip.'/assets/images/';
        $result['site_image_url']='http://'.$ip.'/assets/images/';
        return $result;
    }
}

if(!function_exists('get_data_generic_fun')){
    /**
    * 
    * @param type $columnName
    * @param type $conditionArr
    * @param type $return_type="result"
    * @return type
    * example it will use in controlelr
    * 
    * =====bellow is for * data without conditions======
    * get_data_generic_fun('parent','*');
    *  =====bellow is for * data witht conditions======
    * get_data_generic_fun('parent','*',array('column1'=>$column1Value,'column2'=>$column2Value));
    * 
    * =====bellow is for 1 or more column data without conditions======
    * get_data_generic_fun('parent','column1,column2,column3');
    *  =====bellow is for 1 or more column data with conditions======
    * get_data_generic_fun('parent','column1,column2,column3',array('column1'=>$column1Value,'column2'=>$column2Value));
    *  =====bellow is for 1 or more column data with conditions and return as result all======
    * get_data_generic_fun('parent','column1,column2,column3',array('column1'=>$column1Value,'column2'=>$column2Value),'result_arr');
    * 
    * ==== modification for  adding sortby and limit and add conditionArr for AND -- OR -- IN ---
    * get_data_generic_fun('parent','parent_id,passcode',array('passcode'=>$passcoad,'device_token'=>$deviceToken,'condition_type'=>'or'),array('parrent_id'=>'asc','date_time'=>'desc'),1);
    */
   function get_data_generic_fun($table_name,$columnName="*",$conditionArr=array(),$return_type="result",$sortByArr=array(),$limit=""){
       $CI= & get_instance();
       $CI->db->select($columnName);
       $condition_type='and';
       if(array_key_exists('condition_type', $conditionArr)){
           if($conditionArr['condition_type']!=""){
               $condition_type=$conditionArr['condition_type'];
           }
       }
       unset($conditionArr['condition_type']);
       $condition_in_data_arr=array();
       $startCounter=0;
       $condition_in_column="";
       foreach($conditionArr AS $k=>$v){
           if($condition_type=='in'){
               if(array_key_exists('condition_in_data', $conditionArr)){
                   $condition_in_data_arr=  explode(',', $conditionArr['condition_in_data']);
                   $condition_in_column=$conditionArr['condition_in_col'];
               }
               
           }elseif($condition_type=='or'){
               if($startCounter==0){
                   $CI->db->where($k,$v);
               }else{
                   $CI->db->or_where($k,$v);
               }
           }elseif($condition_type=='and'){
               $CI->db->where($k,$v);
           }
           $startCounter++;
       }
        
        if($condition_type=='in'){
            if(!empty($condition_in_data_arr))
                $CI->db->where_in($condition_in_column,$condition_in_data_arr);
       }

       if($limit!=""){
           $CI->db->limit($limit);
       }

       foreach($sortByArr AS $key=>$val){
           $CI->db->order_by($key,$val);
       }

       if($return_type=='result'){
           $rs=$CI->db->get($table_name)->result();
       }else{
           $rs=$CI->db->get($table_name)->result_array();
       }
       
       if($table_name!="settings")
            generate_log($CI->db->last_query(),'get_data_generic_fun_'.date('d-m-Y-H').'.log');
       
       return $rs;
   } 
} 

if(!function_exists('create_excel_file')){
    function create_excel_file($file_name_path,$data,$sheet_title="Student Upload Data"){
        include_once APPPATH.'third_party/PHPExcel.php';
        
        $objPHPExcel=new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0)->fromArray($data);
        $objPHPExcel->getActiveSheet()->setTitle($sheet_title);
        //$filename='just_some_random_name.xls'; 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); //- See more at: https://arjunphp.com/how-to-use-phpexcel-with-codeigniter/#sthash.0d4ttuQe.dpuf
        //$filePath=$_SERVER['DOCUMENT_ROOT'].'/rentbike/uploads/'.$filename;
        $objWriter->save($file_name_path);
    }
}

if(!function_exists('get_unread_message')){
    function get_unread_message($userId,$userType){
        $CI=&get_instance();
        $CI->load->model('crud_model');
        $CI->db->where('sender', $userId);
        $CI->db->or_where('reciever', $userId);
        $message_threads = $CI->db->get('message_thread')->result_array();
        ob_start();
        ?>
            <ul class="mail-menu"><?php
                foreach ($message_threads as $row):

                    // defining the user to show
                    if ($row['sender'] == $userId)
                        $user_to_show = explode('-', $row['reciever']);
                    if ($row['reciever'] == $userId)
                        $user_to_show = explode('-', $row['sender']);

                    $user_to_show_type = $user_to_show[0];
                    $user_to_show_id = $user_to_show[1];
                    $unread_message_number = $CI->crud_model->count_unread_message_of_thread($row['message_thread_code']);
                    ?>
                    <li class="<?php if (isset($current_message_thread_code) && $current_message_thread_code == $row['message_thread_code']) echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>index.php?<?php echo $userType;?>/message/message_read/<?php echo $row['message_thread_code']; ?>" style="padding:12px;">
                            <i class="entypo-dot"></i>

                            <?php $nameDataArr=$CI->db->get_where($user_to_show_type, array($user_to_show_type . '_id' => $user_to_show_id))->row();

                            //echo $CI->db->last_query();
                           if(!empty($nameDataArr)){
                               //pre($nameDataArr);
                              if(property_exists($nameDataArr, 'name')){
                                  echo $nameDataArr->name;
                              }else{
                                  echo $nameDataArr->father_name;
                              }
                           } ?>


                            <span class="badge badge-default pull-right" style="color:#FFF;"><?php echo ucfirst($user_to_show_type); ?></span>

                            <?php if ($unread_message_number > 0): ?>
                                <span class="badge badge-secondary pull-right">
                                    <?php echo $unread_message_number; ?>
                                </span>
                            <?php endif; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php
        $content = ob_get_clean();
        return $content;
    }
}

if(!function_exists('fire_api_by_curl')){
    function fire_api_by_curl($url,$post){
        generate_log($url.PHP_EOL);
        generate_log('starting curl execute with POST fields '.json_encode($post) . PHP_EOL);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        
        generate_log('starting curl execute ' . PHP_EOL);
        // execute!
        $response = curl_exec($ch);
        generate_log('getting cURL ' . $url . ' response ' . $response . PHP_EOL);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        generate_log('getting cURL status ' . $status . ' response ' . $response . PHP_EOL);
        if($response === false){
            generate_log('getting cURL error Details ' . curl_error($ch)  . PHP_EOL);
        }
        curl_close($ch);
        return $response;
    }
    
}

if(!function_exists('is_section_available_for_admission')){
    function is_section_available_for_admission($class_id, $section_id, $year){
        $CI                             =       &get_instance();
        $CI->load->model('Section_model');
        $CI->load->model('Enroll_model');
        $max_students                   =       $CI->Section_model->get_max_capacity_by_section($class_id, $section_id);
        $students_allotted              =       $CI->Enroll_model->get_alloted_students_count_by_section($class_id, $section_id, $year);
        $responseArr                    =       array();
        if(!empty($max_students)){
            $page_data['capacity']      =       $max_students[0]['capacity'];
            if(!empty($students_allotted)){
                $page_data['student_alloted']   =   $students_allotted[0]['count'];
                }else{
                    $page_data['student_alloted']   =    'No students allothed yet';
            }
            if($page_data['capacity'] <= $page_data['student_alloted'] ){
                return 0;
            }else {
                return 1;               
            }            
        }else{
            return 2;
        }
    }    
}

if(!function_exists('is_class_available_for_admission')){
    function is_class_available_for_admission($class_id, $year){
        $CI                             =       &get_instance();
        $CI->load->model('Enroll_model');
        $CI->load->model('Section_model');
        $max_students                   =       $CI->Section_model->get_max_capacity_by_class($class_id);
        $students_allotted              =       $CI->Enroll_model->get_alloted_students_count_by_class($class_id, $year);
        $responseArr                    =       array();
        if(!empty($max_students)){
            $page_data['capacity']      =       $max_students[0]['capacity'];
            if(!empty($students_allotted)){
                $page_data['student_alloted']   =   $students_allotted[0]['count'];
                }else{
                    $page_data['student_alloted']   =    'No students allothed yet';
            }
            if($page_data['capacity'] <= $page_data['student_alloted'] ){
                return 0;
            }else {
                return 1;               
            }            
        }else{
            return 2;
        }
    }    
}

if(!function_exists('admission_process_allow')){
    function admission_process_allow(){
        $CI                             =       &get_instance();
        $CI->load->model('Admission_settings_model');
        
        $cYear=date('Y')+1;
        $student_running_year=($cYear-1).'-'. ($cYear); 
        $rsCSetting=$CI->Admission_settings_model->get_admission_settings_by_running_year($student_running_year);
        if(count($rsCSetting)>=1 && $rsCSetting[count($rsCSetting)-1]->isActive==1){
            return 1;
        }else{
            return 0;
        }
    }
    
}

if(!function_exists('create_excel_file_multiple_sheet')){
    function create_excel_file_multiple_sheet($file_name_path,$data){
        include_once APPPATH.'third_party/PHPExcel.php';
        //pre($data);die;
        $objPHPExcel=new PHPExcel();
        foreach($data AS $k => $v){ 
            $key= array_keys($v);
            //pre($key);die;
            $cSheetData=array();
            $cSheetData=$v[$key[0]];
            //pre($key);
            //pre($cSheetData);die;
            if($key==0){
                $objPHPExcel->setActiveSheetIndex(0)->fromArray($cSheetData);
                $objPHPExcel->getActiveSheet()->setTitle($key[0]);
            }else{
                $objPHPExcel->createSheet();
                $sheet = $objPHPExcel->setActiveSheetIndex($k);
                $sheet->fromArray($cSheetData);
                $sheet->setTitle($key[0]);
            }
        }
        
        //$filename='just_some_random_name.xls'; 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); //- See more at: https://arjunphp.com/how-to-use-phpexcel-with-codeigniter/#sthash.0d4ttuQe.dpuf
        //$filePath=$_SERVER['DOCUMENT_ROOT'].'/rentbike/uploads/'.$filename;
        $objWriter->save($file_name_path);
    }
}

if(!function_exists('read_mark_data_from_excel_file')){
    function read_mark_data_from_excel_file($file_path){
        include_once APPPATH.'third_party/PHPExcel.php';
        //include  FCPATH.'application/third_party/PHPExcel/IOFactory.php';
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setReadDataOnly(true);

        $objPHPExcel = $objReader->load($file_path);
        $totalSheet= $objPHPExcel->getSheetCount();
        $i = 0;
        $data=array();
        while ($i<$totalSheet){
            $objPHPExcel->setActiveSheetIndex($i);
            $sheetTitle=$objPHPExcel->getActiveSheet()->getTitle();
            $activeSheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $data[$sheetTitle]=$activeSheetData;
            $i++;
        }
        return $data;
    }
}

if ( ! function_exists('set_machin_active_log')){
    function set_machin_active_log($msg,$heading=""){
        $dir='/var/www/html/School/'; 
        $log_file_path=$dir.'machichine_activity_'.date('Y-m-d').'_log.log';
        if (!$handle = fopen($log_file_path, 'a+')) {
            return false;
        }else{
            if($heading==""):
                $message="\n".$msg.PHP_EOL;
            else:
                $message=PHP_EOL.'Content for the for now ===='.date('Y-m-d H:i:s').'==== '.PHP_EOL;
                $message.=$msg.PHP_EOL;
            endif;
            if (fwrite($handle, $message) === FALSE) {
                return false;
            }else{
                fclose($handle);
                return TRUE;
            }
        }
    }
}


// ------------------------------------------------------------------------
/* End of file language_helper.php */
/* Location: ./system/helpers/language_helper.php */