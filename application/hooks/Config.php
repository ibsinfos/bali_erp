<?php
class Config{
    function create(){
        $CI = &get_instance();
        //SET TimeZone
        $timezone_rec = $CI->db->get_where('settings',array('type'=>'timezone'))->row();
        
        $timezone = $timezone_rec?$timezone_rec->description:'ASIA/KOLKATA';
        date_default_timezone_set($timezone);


        //Set Language Config
        $current_language = $CI->db->get_where('settings', array('type' => 'language'))->row();
        $current_language = ($current_language)?$current_language->description:'english';
		$CI->session->set_userdata('current_language' , $current_language);
        
        //Get All Language Phrases
        // array('UPPER (phrase)=' => strtoupper($phrase)
        $phrases = $CI->db->get('language')->result();
        foreach($phrases as $phr){
            $CI->config->set_item('lang_'.strtoupper($phr->phrase),$phr->$current_language);
        }
    }
}
?>