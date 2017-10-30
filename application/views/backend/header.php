<style>
  a .default_theme{
    display: inline;
    width: 4px;
    height: 1px;
    padding: 0 6px;
    cursor: pointer;
    border: solid 1px;
    background: #707cd2;
}
a .diffrent_theme{
    display: inline;
    width: 4px;
    height: 1px;
    padding: 0 6px;
    cursor: pointer;
    border: solid 1px;
    background: #a28cc1
}

.heartbit{font-size: 30px;}
</style>
<?php
//$filename = $this->crud_model->get_image_url('admin', $this->session->userdata('admin_id'));
// $date_last_modif = date('Y-m-d', @filemtime($filename));
$lastModified = @filemtime($filename);
//if($lastModified == NULL)
$lastModified = @filemtime(utf8_decode($filename));
if ($this->session->userdata('student_login') == 1) {
    $student_id = $this->session->userdata('student_id');
    $filename = $this->crud_model->get_records('student', array('student_id' => $student_id), 'stud_image');
    $filename = $filename[0]['stud_image'];
    $file_name = base_url().'uploads/student_image/' . $filename;
} else if ($this->session->userdata('admin_login') == 1) {
    $admin_id = $this->session->userdata('admin_id');

    //$filename = $this->crud_model->getSpecificRecord($this->session->userdata('table'),$admin_id);

    if (isset($filename['type']) && $filename['type'] == "A")
        $file_name = 'uploads/admin_image/' . $filename['image'];
    if (isset($filename['type']) && $filename['type'] == "T")
        $file_name = 'uploads/teacher_image/' . $filename['image'];
} else if ($this->session->userdata('teacher_login') == 1) {
    $teacher_id = $this->session->userdata('teacher_id');
    $filename = $this->crud_model->get_records('teacher', array('teacher_id' => $teacher_id), 'teacher_image');
    $filename = $filename[0]['teacher_image'];
    $file_name = 'uploads/teacher_image/' . $filename;
} else if ($this->session->userdata('parent_login') == 1) { 
    $parent_id = $this->session->userdata('parent_id');
    $filename = $this->crud_model->get_records('parent', array('parent_id' => $parent_id), 'parent_image');
    $filename = $filename[0]['parent_image'];
    $file_name = "";
    $file_name = 'uploads/parent_image/' . $filename;
} else if ($this->session->userdata('hostel_login') == 1) {
    $hostel_admin_id = $this->session->userdata('hostel_admin_id');
    $filename = $this->crud_model->get_records('hostel_admin', array('hostel_admin_id' => $hostel_admin_id), 'image');
    $filename = $filename[0]['image'];
    $file_name = 'uploads/hostel_admin_image/' . $filename;
} else {
    $file_name = 'uploads/user.jpg';
}
if (!isset($file_name)) {
    $file_name = 'uploads/user.jpg';
}
$account_type1 = $account_type;
if($account_type == 'parent') {
    $account_type1 = 'parents';
}

if($this->session->userdata('login_user_id') == ''){
    ?>
<style type="text/css">
.navbar-static-top {
    padding-left: 0;
}
</style>
<?php
}
?>
<nav class="navbar navbar-default navbar-static-top m-b-0">
    <input type="hidden" value="<?php echo base_url(); ?>" name="base_url" id="base_url">
    <div class="navbar-header">
        <!-- Toggle icon for mobile view -->
        <div class="top-left-part">
            <!-- Logo -->
            <?php if(!empty($account_type1)) { ?>
            <a class="logo" href="<?php echo base_url(); ?>index.php?<?php echo $account_type1; ?>/dashboard">
                <b>
                    <?php if (isset($system_logo) && file_exists('uploads/' . $system_logo)) { ?>
                        <img src="<?php echo base_url(); ?>uploads/<?php echo $system_logo; ?>" alt="home" class="dark-logo" width="40"/>
                    <?php } else { ?>
                        <img src="<?php echo base_url(); ?>uploads/logo.png" alt="home" class="dark-logo" width="40"/>
                    <?php } ?>
                </b>
                <span class="hidden-xs">
                   <?php echo $system_name;   ?>
                </span> 
            </a>
            <?php } else { ?>
            <a class="logo" href="<?php echo base_url(); ?>">
                <b>
                    <?php if (isset($system_logo) && file_exists('uploads/' . $system_logo)) { ?>
                        <img src="<?php echo base_url(); ?>uploads/<?php echo $system_logo; ?>" alt="home" class="dark-logo" width="40"/>
                    <?php } else { ?>
                        <img src="<?php echo base_url(); ?>uploads/logo.png" alt="home" class="dark-logo" width="40"/>
                    <?php } ?>
                </b>
                <span class="hidden-xs">
                   <?php echo $system_name;   ?>
                </span> 
            </a>
            <?php } ?>
        </div>
        <!-- /Logo -->
        <!-- Search input and Toggle icon -->
        <?php if($this->session->userdata('login_user_id') > 0) { ?>
        <ul class="nav navbar-top-links navbar-left">
            <li class="menu_in_mobile"><a href="javascript:void(0)" class="open-close waves-effect waves-light visible-xs"><i class="ti-close ti-menu"></i></a></li>
            <li data-step="2" data-intro="<?php echo get_phrase( 'You will get notifications from here!');?>" data-position='left' class="dropdown" onclick="ClickForNotification();">
                <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"> <i class="mdi mdi-bell-outline"></i>
                    <div class="notify"><span class="heartbit"></span><span class="point"></span></div>
                </a>
                <ul class="dropdown-menu mailbox scrollbar animated bounceInDown push_notification_content" id="style-1">

                </ul>
                <!-- /.dropdown-messages -->
            </li>
        </ul>
        <?php } ?>

        <!-- This is the message dropdown -->
        <ul class="nav navbar-top-links navbar-right pull-right">
            <!-- /.Task dropdown -->
            <!-- /.dropdown -->
            <li data-step="3" data-intro="<?php echo get_phrase('What you want you just search from here!');?>" data-position='left'>
<form role="search" class="form-group bs-example hidden-xs"> <!--  m-b-20 m-t-20 -->
<!--                <input type="text" placeholder="Search..." class="form-control typeahead tt-query" data-provide="typeahead" autocomplete="off" spellcheck="false" id="PublicSearch" value="<?php //echo @$search_text; ?>">-->
                    <input class="form-control typeahead tt-query button-on" placeholder="Search.." value="<?php echo @$search_text; ?>" id="PublicSearch"/>
                    <a href=""><i class=""></i></a>
                </form>
                <div class="serch-click-overlay">
                    <span class="serach-cross"><i class="fa fa-times"></i></span>
                    <input type="text" placeholder="Search..." id="searchString" value="<?php echo @$search_text; ?>"/>
                    <input id="submitSearch" type="hidden" value="" />
                    <span class="serach-fa-text"><i class="fa fa-search"></i></span>
                    <div class="col-xs-12 col-xs-offset-1 col-xs-10 no-padding top-tiles">
                        <div class="col-xs-12 col-sm-4"><h1 class="text-white">Student</h1>
<?php if ($this->session->userdata('school_admin_login') == 1) { ?>
                            <div class="m-b-20 dummy-media-object" search-location="school_admin/bus_driver"><a class="text-white" href="#">
                                    <span class="text-font-tile"><i class="fa fa-user m-r-20"></i></span>
                                    <span class="text-font">Bus Driver</span>
                                </a>
                            </div>

                            <div class="m-b-20 dummy-media-object" search-location="admin_report/student_information_misc_report"><a class="text-white" href="#">
                                    <span class="text-font-tile"><i class="fa fa-user m-r-20"></i></span>
                                    <span class="text-font">Student List</span>
                                </a>
                            </div>

                            <div class="m-b-20 dummy-media-object" search-location="finance"><a class="text-white" href="#">
                                    <span class="text-font-tile"><i class="fa fa-user m-r-20"></i></span>
                                    <span class="text-font">Finance</span>
                                </a>
                            </div>

                            <div class="m-b-20 dummy-media-object" search-location="school_admin/manage_allocation"><a class="text-white" href="#">
                                    <span class="text-font-tile"><i class="fa fa-user m-r-20"></i></span>
                                    <span class="text-font">Dormitory</span>
                                </a>
                            </div>

                            <div class="m-b-20 dummy-media-object" search-location="school_admin/library"><a class="text-white" href="#">
                                    <span class="text-font-tile"><i class="fa fa-user m-r-20"></i></span>
                                    <span class="text-font">Library</span>
                                </a>
                            </div>
<?php } else if ($this->session->userdata('teacher_login') == 1) { ?>
                            <div class="m-b-20 dummy-media-object" search-location="teacher/transport"><a class="text-white" href="#">
                                    <span class="text-font-tile"><i class="fa fa-user m-r-20"></i></span>
                                    <span class="text-font">Transport</span>
                                </a>
                            </div>

                            <div class="m-b-20 dummy-media-object" search-location="teacher/all_student_list"><a class="text-white" href="#">
                                    <span class="text-font-tile"><i class="fa fa-user m-r-20"></i></span>
                                    <span class="text-font">Student List</span>
                                </a>
                            </div>                            
<?php } else if ($this->session->userdata('parent_login') == 1) { ?>


                                                
<?php } else if ($this->session->userdata('student_login') == 1) { ?>

                            <div class="m-b-20 dummy-media-object" search-location="student/transport"><a class="text-white" href="#">
                                    <span class="text-font-tile"><i class="fa fa-user m-r-20"></i></span>
                                    <span class="text-font">Transport</span>
                                </a>
                            </div><?php }?>

                        </div>

                        <div class="col-xs-12 col-sm-4"><h1 class="text-white">Parent</h1>
<?php if ($this->session->userdata('school_admin_login') == 1) { ?>
                            <div class="m-b-20 dummy-media-object" search-location="school_admin/parent"><a class="text-white" href="#">
                                    <span class="text-font-tile"><i class="fa fa-user m-r-20"></i></span>
                                    <span class="text-font">Parent List</span>
                                </a>
                            </div>
<?php } else if ($this->session->userdata('teacher_login') == 1) { ?>


<?php } else if ($this->session->userdata('parent_login') == 1) { ?>

                                                
<?php } else if ($this->session->userdata('student_login') == 1) { ?>

 <?php }?>                           
                        </div>
                        <div class="col-xs-12 col-sm-4"><h1 class="text-white">Teacher</h1>
<?php if ($this->session->userdata('school_admin_login') == 1) { ?>
                            <div class="m-b-20 dummy-media-object" search-location="school_admin/teacher"><a class="text-white" href="#">
                                    <span class="text-font-tile"><i class="fa fa-user m-r-20"></i></span>
                                    <span class="text-font">Teacher List</span>
                                </a>
                            </div>

<?php } else if ($this->session->userdata('teacher_login') == 1) { ?>
                            <div class="m-b-20 dummy-media-object" search-location="teacher/teacher_list"><a class="text-white" href="#">
                                    <span class="text-font-tile"><i class="fa fa-user m-r-20"></i></span>
                                    <span class="text-font">Teacher</span>
                                </a>
                            </div>                            
<?php } else if ($this->session->userdata('parent_login') == 1) { ?>
                                                
<?php } else if ($this->session->userdata('student_login') == 1) { ?>
                            <div class="m-b-20 dummy-media-object" search-location="student/teacher_list"><a class="text-white" href="#">
                                    <span class="text-font-tile"><i class="fa fa-user m-r-20"></i></span>
                                    <span class="text-font">Teacher</span>
                                </a>
                            </div>
                <?php }?>                          
                        </div>
                    </div>

                </div>

                <!--<div class="header_action_search" id="SearchInOuter">
                    <ul class="list-unstyled search_ul_in_header" id="SearchIn">
                <?php if ($this->session->userdata('school_admin_login') == 1) { ?>               
                            <li><a search-location="admin/bus_driver">Bus Driver</a></li>
                            <li><a search-location="admin/parent">Parent</a></option>
                            <li><a search-location="admin_report/student_information_misc_report">Student</a></li>
                            <li><a search-location="admin/teacher">Teacher</a></li>
                            <li><a search-location="finance">Finance</a></li>
                            <li><a search-location="admin/manage_allocation">Dormitory</a></li>
                            <li><a search-location="admin/library">Library</a></li>
                <?php } else if ($this->session->userdata('teacher_login') == 1) { ?>                   
                            <li><a search-location="teacher/transport">Transport</a></li>
                            <li><a search-location="teacher/all_student_list">Student</a></li>
                            <li><a search-location="teacher/teacher_list">Teacher</a></li>
                <?php } else if ($this->session->userdata('parent_login') == 1) { ?>
                                                
                <?php } else if ($this->session->userdata('student_login') == 1) { ?>
                            <li><a search-location="student/transport">Transport</a><</li>
                            <li><a search-location="student/teacher_list">Teacher</a></li>
                <?php } ?>
                    </ul>
                </div>-->
            </li>

            <!--this one is -->
            <li data-step="4" data-intro="<?php echo get_phrase('You will get profile information from here!')?>" data-position='left' class="dropdown">

                <a href="#" class="dropdown-toggle profile-pic" data-toggle="dropdown">

                    <?php
                    $filename = $this->crud_model->get_image_url('admin', $this->session->userdata('admin_id'));
                    $file_name = '';
                    $lastModified = @filemtime($filename);
//if($lastModified == NULL)
                    $lastModified = @filemtime(utf8_decode($filename));
                    if ($this->session->userdata('student_login') == 1) {
                        $student_id = $this->session->userdata('student_id');
                        $filename = $this->crud_model->get_records('student', array('student_id' => $student_id), 'stud_image');
                        $filename = $filename[0]['stud_image'];
                        if(!empty($filename) && file_exists(FCPATH.'uploads/student_image/'.$filename)){
                        $file_name = 'uploads/student_image/' . $filename;
                        }                         
                    } else if ($this->session->userdata('admin_login') == 1) {
                        $admin_id = $this->session->userdata('admin_id');

                        $filename = $this->crud_model->getSpecificRecord($this->session->userdata('table'), $admin_id);

                        if (isset($filename['type']) && $filename['type'] == "A"){
                            if($filename['image']!=''){
                                $file_name = 'uploads/admin_image/' . $filename['image'];
                            }
                        }                                    
                        if (isset($filename['type']) && $filename['type'] == "T"){
                             if($filename['image']!=''){
                                $file_name = 'uploads/teacher_image/' . $filename['image'];
                            }      
                        }
                            
                    } else if ($this->session->userdata('teacher_login') == 1) {
                        $teacher_id = $this->session->userdata('teacher_id');
                        $filename = $this->crud_model->get_records('teacher', array('teacher_id' => $teacher_id), 'teacher_image');
                        $filename = $filename[0]['teacher_image'];
                        $file_name = 'uploads/teacher_image/' . $filename;
                    } else if ($this->session->userdata('parent_login') == 1) {
                        $parent_id = $this->session->userdata('parent_id');
                        $filename = $this->crud_model->get_records('parent', array('parent_id' => $parent_id), 'parent_image');
                        $filename = $filename[0]['parent_image'];
                        if(!empty($filename) && file_exists(FCPATH.'uploads/parent_image/'.$filename)){
                         $file_name = 'uploads/parent_image/' . $filename;   
                        }                        
                    } else if ($this->session->userdata('hostel_login') == 1) {
                        $hostel_admin_id = $this->session->userdata('hostel_admin_id');
                        $filename = $this->crud_model->get_records('hostel_admin', array('hostel_admin_id' => $hostel_admin_id), 'image');
                        $filename = $filename[0]['image'];
                        $file_name = 'uploads/hostel_admin_image/' . $filename;
                    } else if ($this->session->userdata('school_admin_login') == 1) {
                        $school_admin_id = $this->session->userdata('school_admin_id');
                        $teacher_id = '';
                        if(isset($_SESSION['teacher_id']))
                            $teacher_id = $_SESSION['teacher_id'];
                        $filename = $this->School_Admin_model->getSingleAdminData($school_admin_id, $teacher_id); 
                        if(!empty($filename['profile_pic']))
                        {    
                            $filename = $filename['profile_pic'];
                            $file_name = 'uploads/sc_admin_images/' . $filename;
                        }    
                    }else if($this->session->userdata('doctor_login') == 1){
                        $doctor_id = '';
                        $doctor_id = $this->session->userdata('doctor_id');
                        if(isset($_SESSION['doctor_id']))
                            $doctor_id = $_SESSION['doctor_id'];
                        $filename = $this->Doctor_model->get_data_by_id($doctor_id);
                        $file_name = $filename->profile_pic;
                        if(!empty($file_name) && file_exists(FCPATH.'uploads/doctor_image/'.$file_name))
                        {  
                         $file_name = 'uploads/doctor_image/' . $file_name; 
                        }
                    }else if($this->session->userdata('bus_driver_login') == 1){
                        $bus_driver_id = $this->session->userdata('bus_driver_id');
                        $bus_driver_id = '';
                        if(isset($_SESSION['bus_driver_id']))
                            $bus_driver_id = $_SESSION['bus_driver_id'];
                        $filename = $this->Bus_driver_modal->get_bus_driver($bus_driver_id);
                        $file_name = $filename->driver_image;
                        if(!empty($file_name) && file_exists(FCPATH.'uploads/bus_driver_image/'.$file_name))
                        {  
                         $file_name = 'uploads/bus_driver_image/' . $file_name; 
                        }
                    }
                    ?><?php  
                    if($file_name == ''){
//                        echo "sucess";
                        $file_name = base_url().'uploads/user.png';
                    }
//                    echo $file_name;
                    ?>
                    <img src="<?php echo $file_name; ?>" alt="user-img" width="36" height="36" class="img-circle">
                    <b class="hidden-xs"><?php echo $this->session->userdata('name'); ?></b><span class="caret"></span> </a>
                <ul class="dropdown-menu dropdown-user animated flipInY">
                    <li>
                        <div class="dw-user-box">
                            <div class="u-img">
                                <?php
                                $filename = $this->crud_model->get_image_url('admin', $this->session->userdata('admin_id'));
                                $lastModified = @filemtime($filename);
                                //if($lastModified == NULL)
                                $lastModified = @filemtime(utf8_decode($filename));
                                if ($this->session->userdata('student_login') == 1) {
                                    $student_id = $this->session->userdata('student_id');
                                    $filename = $this->crud_model->get_records('student', array('student_id' => $student_id), 'stud_image');
                                    $filename = $filename[0]['stud_image'];
                                    if($filename!=''){
                                    $file_name = 'uploads/student_image/' . $filename;
                                    }
                                } else if ($this->session->userdata('admin_login') == 1) {
                                    $admin_id = $this->session->userdata('admin_id');

                                    $filename = $this->crud_model->getSpecificRecord($this->session->userdata('table'), $admin_id);

                                    if (isset($filename['type']) && $filename['type'] == "A")
                                        $file_name = 'uploads/admin_image/' . $filename['image'];
                                    if (isset($filename['type']) && $filename['type'] == "T")
                                        $file_name = 'uploads/teacher_image/' . $filename['image'];
                                } else if ($this->session->userdata('teacher_login') == 1) {
                                    $teacher_id = $this->session->userdata('teacher_id');
                                    $filename = $this->crud_model->get_records('teacher', array('teacher_id' => $teacher_id), 'teacher_image');
                                    $filename = $filename[0]['teacher_image'];
                                    $file_name = 'uploads/teacher_image/' . $filename;
                                } else if ($this->session->userdata('parent_login') == 1) {
                                    $parent_id = $this->session->userdata('parent_id');
                                    $filename = $this->crud_model->get_records('parent', array('parent_id' => $parent_id), 'parent_image');
                                    $filename = $filename[0]['parent_image'];
                                    if(!empty($filename) && file_exists(FCPATH.'uploads/parent_image/'.$filename)){
                                    $file_name = 'uploads/parent_image/' . $filename;   
                                    }    
                                } else if ($this->session->userdata('hostel_login') == 1) {
                                    $hostel_admin_id = $this->session->userdata('hostel_admin_id');
                                    $filename = $this->crud_model->get_records('hostel_admin', array('hostel_admin_id' => $hostel_admin_id), 'image');
                                    $filename = $filename[0]['image'];
                                    $file_name = 'uploads/hostel_admin_image/' . $filename;
                                } else if ($this->session->userdata('school_admin_login') == 1) {
                                    $school_admin_id = $this->session->userdata('school_admin_id');
                                    $filename = $this->crud_model->get_records('school_admin', array('school_admin_id' => $school_admin_id), 'profile_pic');
                                    $filename = $filename[0]['profile_pic'];
                                    $file_name = 'uploads/sc_admin_images/' . $filename;
                                } 
                                ?>
                                <img src="<?php echo (file_exists(FCPATH.$file_name) ? $file_name : 'uploads/user.png'); ?>" alt="user-img" width="80" height="80" class="img-circle">

                            </div>

                            <div class="u-text">
                                <h4><?php echo $this->session->userdata('name'); ?></h4>
                                <p class="text-muted"><?php echo $this->session->userdata('username'); ?></p>
                            </div>
                        </div>
                    </li>
                    <?php if ($account_type == "parent") { ?>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>index.php?<?php echo "parents"; ?>/manage_profile"><i class="ti-user"></i> My Profile</a></li>

                    <?php } else { ?>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/manage_profile"><i class="ti-user"></i> My Profile</a></li>


                    <?php } ?>
                    <li role="separator" class="divider"></li>
                    <li class="hidden-xs"><a href="<?php echo base_url(); ?>index.php?login/logout"><i class="fa fa-power-off"></i> <?php echo get_phrase('Log_Out'); ?></a></li>
               
                    <li role="separator" class="divider hidden-xs"></li>
                    
                    <!--start-->
                   
                    <div id="demo-wrapper">
                        <li data-path="<?php echo base_url();?>assets/css/custom-style.css"><a href="#"><span class="default_theme">&nbsp;</span> Default Theme</a></li>
                     </div>   
                    <li role="separator" class="divider"></li>
                     <div id="demo-wrapper">
                         <li data-path="<?php echo base_url();?>assets/css/second-theme.css"><a href="#"><span class="diffrent_theme">&nbsp;</span> Dimmer Theme</a></li>
                     </div>
                    <!--end-->
                
                </ul>
                <!-- /.dropdown-user -->
            </li>
        </ul>
    </div>
</nav>
<div id="fl_menu">
	<div class="label"><i class="fa fa-bars"></i></div>
	<div class="menu">
    	<a href="#" class="menu_item">Menu 1</a>
    	<a href="#" class="menu_item">Menu 2</a>
    	<a href="#" class="menu_item">Menu 3</a>
    	<a href="#" class="menu_item">Menu 4</a>
    </div>
</div>
<script>
function ClickForNotification() {
    getPushNotification();
}

function getPushNotification() {

    var mycontent = "";
    base_url = $('#base_url').val();
    mycontent = $.ajax({
        async: false,
        dataType: 'json',
        url: base_url + 'index.php?Ajax_controller/getNotifications_new',
        success: function (response) {
        },
        error: function (error_param, error_status) {

        }
    });
    notific = $.parseJSON(mycontent.responseText);
    $('.push_notification_content').empty();
    $('.push_notification_content').html(notific.notifications);
}
</script>

