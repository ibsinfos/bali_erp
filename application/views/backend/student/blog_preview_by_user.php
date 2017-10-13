<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('preview_your_blog'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>index.php?student/dashboard">
                    <?php echo get_phrase('Dashboard'); ?>
                </a>
            </li>   
            <li>
                <a href="<?php echo base_url(); ?>index.php?blogs/view_my_blogs">
                    <?php echo get_phrase('view_my_blogs'); ?>
                </a>
            </li> 
            <li class="active">
                <?php echo get_phrase('preview_blog'); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<div class="row">
    <div class="col-md-12">
    <?php 
    if (!empty($blog_preview)){
        foreach($blog_preview as $row){
    ?>
    <?php echo form_open(base_url().'index.php?blogs/blog_preview/'. $row['blog_id'], array('class' =>'form-horizontal','id'=>'blogIdForm'));?>
        <div class="col-md-12">
            <div class="white-box">
                <div class="row">
                    <label class="col-xs-12 col-sm-2" for="blog_title">
                        <h4 class="m-0"><b><?php echo get_phrase('blog_title ');?> :</b></h4></label>
                    <div class="col-xs-12 col-sm-10">
                        <p class="text-font">
                            <?php echo $row['blog_title'];?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="white-box">
                <div class="row form-group" data-step="5" data-intro="<?php echo get_phrase('Helps to preview the blog content');?>" data-position='top'>
                    <label class="control-label col-xs-12 col-sm-2" for="blog_info">
                        <h4 class="m-0"><b><?php echo get_phrase('blog_information ');?> :</b></h4></label>
                    <div class="col-xs-12 col-sm-10 text-font">
                        <?php echo " ".$row['blog_information'];?>
                    </div>
                </div>
            </div>
        </div>
    <?php echo form_close();?>
    <?php } }?>
    </div>
</div>

