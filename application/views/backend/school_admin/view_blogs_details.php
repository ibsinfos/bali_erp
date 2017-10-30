<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('view_blog_details'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>index.php?school_admin/dashboard">
                    <?php echo get_phrase('Dashboard'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>index.php?blogs/view_all_blogs">
                    <?php echo get_phrase('view_all_blogs'); ?>
                </a>
            </li>
            
            
            <li class="active">
                <?php echo get_phrase('view_blog_details'); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<div class="text-right m-b-20" >    
    <a  href="<?php echo base_url(); ?>index.php?blogs/view_all_blogs " 
       class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger par-add-btn" data-toggle="tooltip" 
       data-placement="left" title="" data-original-title="Go Back">
       <i class="fa fa-reply"></i>
    </a>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            
            <?php if(!empty($view_blogs)){ $i = 0; ?>
                <div class="row m-b-10">
                    <h3 class="col-md-12 m-t-0 box-title"><?php echo $view_blogs[$i]['blog_title']; ?></h3>
                </div>

                <div class="row well p-l-0 p-r-0 blog_box" data-step="5" data-intro="<?php echo get_phrase('View_blog_content');?>" data-position='top'>
                    <div class="col-md-12">
                        <div class="pull-left col-md-1">
                            <img src="uploads/user.jpg" class="img-circle" width="60" height="60" alt="user profile image">
                        </div>
                        <div class="col-md-11">
                            <div>
                                <b><?php echo $view_blogs[$i]['blog_user_name']; ?></b> made a post.
                            </div>
                            <h6 class="text-muted time"><?php echo date('d, M Y H:i:s', strtotime($view_blogs[$i]['blog_created_time']));?></h6>
                        </div>
                    </div>
                    <div class="col-md-12 m-t-10">
                        
                        <p class="p-10 text-font">
                            <?php  echo $view_blogs[$i]['blog_information']; ?>
                        </p>
                    </div>
                </div>
                <?php } ?>

                    <div class="post-footer">

                        <?php echo form_open(base_url() . 'index.php?blogs/view_blogs_details/'.$view_blogs[$i]['blog_id'],array('class' =>'well', 'method'=>'post'));?>
                            <input type="hidden" name="blog_id" value="<?php echo $view_blogs[$i]['blog_id']; ?>" />
                            <input type="hidden" name="date_add" value="<?php echo date('Y-m-d H:i:s'); ?>" />
                            <div class="row">

                                <div class="col-md-12 p-r-0" >
                                    <textarea name="post_body" class="col-md-10" id="textpost" placeholder=" Add a comment" required></textarea>
                                    <span class="col-md-2 text-right">
                                <button type="submit" name="reply_post" value="reply_post" class="fcbtn btn btn-danger btn-outline btn-1d" /></span>
                                    <?php echo get_phrase('post_comments');?>
                                </div>
                            </div>
                            <?php echo form_close();?>

                                <!-- .row -->
                                <div class="row">
                                    <?php if(!empty($view_blogs_comments)){?>
                                        <div class="col-md-12">
                                            <h3 class="box-title">View Comments</h3>
                                            <?php foreach ($view_blogs_comments as $view){?>
                                                <div class="media">
                                                    <div class="media-left">
                                                        <a href="javascript:void(0)"> <img src="uploads/user.jpg" width="40" height="40" alt="user-img"> </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="media-heading"><span class="comment-name"><?php echo $view->blog_username; ?></span>
                                                        <span><?php echo date('d, M Y H:i:s', strtotime($view->date_created));?></span></h6>
                                                        <p>
                                                            <?php echo $view->blog_comments; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <?php } } ?>
                                        </div>

                                </div>
                                <!-- /.row -->
                    </div>
        </div>
    </div>
</div>