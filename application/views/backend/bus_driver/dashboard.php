<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"><h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

  <div class="row">
    <div class="col-lg-5 col-sm-12 col-xs-12">
        <div class="panel">
            <div class="p-30">
                <div class="row">
                    <div class="col-xs-4">
                        <!--<img src="" alt="profile_image" width="100px" height="100px">-->
                        <?php if ($driver_detail->driver_image != "" && file_exists('uploads/bus_driver_image/' . $driver_detail->driver_image)) {
                                $driver_image = $driver_detail->parent_image;
                                } else {
                                    $driver_image = '';
                                } ?>
                                <img src="<?php echo ($driver_image!=""?"uploads/bus_driver_image/".$driver_image:"uploads/user.png");?>" width="100px" height="100px"/>
                    </div>
                <div class="col-xs-8">
                    <h2 class="m-b-0"><?php echo ucfirst($driver_detail->name);  ?></h2>
                    <h4><?php echo $driver_detail->email; ?></h4>
                </div>
                </div>
                <div class="row text-center m-t-30">
                    <div class="col-xs-4 b-r">
                        <h2><?php echo get_phrase('Contact'); ?></h2>
                        <h4><?php echo $driver_detail->phone; ?></h4></div>
                    <div class="col-xs-4 b-r">
                        <h2><?php echo get_phrase('Gender'); ?></h2>
                        <h4><?php echo ucfirst($driver_detail->sex); ?></h4></div>
                    <div class="col-xs-4">
                        <h2><?php echo get_phrase('Bus'); ?></h2>
                        <h4><?php echo get_phrase($driver_detail->bus_name); ?></h4></div>
                </div>
            </div>


            <hr>
            <ul class="dp-table profile-social-icons">
                <li><a href="javascript:void(0)" class="tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('View Profile'); ?>"><i class="fa fa-globe"></i></a></li>
                <li><a href="javascript:void(0)" class="tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('Twitter'); ?>"><i class="fa fa-twitter"></i></a></li>
                <li><a href="javascript:void(0)" class="tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('Facebook'); ?>"><i class="fa fa-facebook"></i></a></li>
                <li><a href="javascript:void(0)" class="tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('Youtube'); ?>"><i class="fa fa-youtube"></i></a></li>
                <li><a href="javascript:void(0)" class="tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('LinkedIn'); ?>"><i class="fa fa-linkedin"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="col-lg-5 col-sm-12 col-xs-12">
        Google map 
    </div>
</div>

<script>
$(function(){
    if(window.innerWidth<700){
        sidebar = $('.sidebar');
        sideMenu = $('#side-menu'); 
        $('.fix-sidebar').addClass('overflow-toggle');
        sidebar.addClass('side_menu1');
        sideMenu.show();
        act = sideMenu.find('li.active');
        if(act.length==0){
            act = sideMenu.find('li:eq(0)');
            act.addClass('active');  
        } 
        scrollInView(act);   
    }
});    
</script>