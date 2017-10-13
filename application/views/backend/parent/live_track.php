  	
<!--     <script src="libraries/gps/code.jquery.com/jquery-1.11.1.min.js"></script> -->
<!--     <script src="//maps.google.com/maps/api/js?v=3&sensor=false&libraries=adsense"></script> -->
  <!--   <script src="<?php echo base_url();?>assets/js/maps.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/js/leaflet-0.7.5/leaflet.js"></script>
    <script src="<?php echo base_url();?>assets/js/leaflet-plugins/google.js"></script>
    <script src="<?php echo base_url();?>assets/js/leaflet-plugins/bing.js"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/js/leaflet-0.7.5/leaflet.css">    -->
    <!-- 
        to change themes, select a theme here:  http://www.bootstrapcdn.com/#bootswatch_tab 
        and then change the word after 3.2.0 in the following link to the new theme name
    -->    
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.5/cerulean/bootstrap.min.css">
    <link rel="stylesheet" href="libraries/gps/css/styles.css">
<?php
//include "application/libraries/gps/displaymap.php";

$login_type = $this->session->userdata('login_type');

$parent_id = 0;

if($login_type=='parent'){
    $parent_id = $this->session->userdata('login_user_id');
}
    		
?>
<iframe src="http://<?php echo SMS_IP_ADDR; ?>/gps_madaan/displaymap.php?parent_id=<?php echo $parent_id;?>" class="col-sm-12" height="650px"></iframe>