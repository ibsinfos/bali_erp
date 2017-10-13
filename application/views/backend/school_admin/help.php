<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>

<?php $BRC = get_bread_crumb(); if (strpos($BRC, '^') !== false) { $ExpBrd = explode('^', $BRC);?>
            <li>
                <?php echo get_phrase(@$ExpBrd[0]); ?>
                <?php echo @$ExpBrd[1]; ?>
            </li> <?php }else{ $ExpBrd[2] = $BRC;}?>
            <li class="active">
                <?php echo get_phrase(@$ExpBrd[2]); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<div class="row">

    <div class="col-lg-3 col-sm-4  col-xs-12">
        <div class="white-box" data-step="5" data-intro="<?php echo get_phrase('From Here you will get a specific module User guide!');?>" data-position='top'>
            <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('teacher_guide'); ?></b></h3>
            <ul class="list-inline text-center">
                <a href="<?php echo base_url();?>uploads/user_mannual.pdf" download>
                <button data-step="6" data-intro="<?php echo get_phrase('For getting a PDF file, click on button!');?>" data-position='top' type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('View Profile'); ?>" title="<?php echo get_phrase('download_pDF'); ?>"><i class="fa fa-download"></i></button>
                </a>
            </ul>
        </div>
    </div>
    <div class="col-lg-3 col-sm-4  col-xs-12">
        <div class="white-box">
            <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('parent_guide'); ?></b></h3>
            <ul class="list-inline text-center">
                <a href="<?php echo base_url();?>uploads/user_mannual.pdf" download>
                <button type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('View Profile'); ?>" title="<?php echo get_phrase('download_pDF'); ?>"><i class="fa fa-download"></i></button>
                </a>
            </ul>
        </div>
    </div>
    <div class="col-lg-3 col-sm-4  col-xs-12">
        <div class="white-box">
            <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('student_guide'); ?></b></h3>
            <ul class="list-inline text-center">
                <a href="<?php echo base_url();?>uploads/user_mannual.pdf" download>
                <button type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('View Profile'); ?>" title="<?php echo get_phrase('download_pDF'); ?>"><i class="fa fa-download"></i></button>
                </a>
            </ul>
        </div>
    </div>
    <div class="col-lg-3 col-sm-4  col-xs-12">
        <div class="white-box">
            <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('hostel_guide'); ?></b></h3>
            <ul class="list-inline text-center">
                <a href="<?php echo base_url();?>uploads/user_mannual.pdf" download>
                <button type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('View Profile'); ?>" title="<?php echo get_phrase('download_pDF'); ?>"><i class="fa fa-download"></i></button>
                </a>
            </ul>
        </div>
    </div>
    
</div>