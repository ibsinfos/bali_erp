<div class="row bg-title">
    
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">  
        <h4 class="page-title"><?php echo get_phrase('Admission Form'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" target="_blank" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?parents/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase('Admission Form'); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<div class="panel panel-success" data-collapsed="0" >
    <div class="panel-heading">
        <div class="panel-title" >
            <i class="entypo-info"></i>
            <?php echo get_phrase("Dear parent your admission form is already submitted to school administration. You will recieve an SMS "
                    . "for counselling. Keep necessary documents ready with you."); ?>
        </div>
    </div> 
</div>