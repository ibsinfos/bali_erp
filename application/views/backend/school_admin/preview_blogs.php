<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('Preview_Blog'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour"  class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>index.php?school_admin/dashboard">
                    <?php echo get_phrase('Dashboard'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>index.php?blogs/view_blogs">
                    <?php echo get_phrase('View_Blogs'); ?>
                </a>
            </li>
            
            <li class="active">
                <?php echo get_phrase('Preview_Blog'); ?>
            </li>
        </ol>
    </div>
</div>


<div class="row">
    <div class="col-md-12">

        <?php 
            if (!empty($blog_preview)){
                foreach($blog_preview as $row){
            ?>
            <?php echo form_open(base_url().'index.php?blogs/blog_preview/'. $row['blog_id'], array('class' =>'','id'=>'blogIdForm'));?>

                <div class="row">
                    <div class="col-md-12 m-b-20">

                        <?php if($row['blog_available']=='3') { ?>
                            <div>
                                <label class="badge-stu-name badge text-left col-sm-4" for="blog_info">
                                    <?php echo get_phrase('info_:_sent_to_author_for_modifications');?>
                                </label>
                            </div>
                            <?php }else{ ?>
                            
                        <label class="badge-stu-name badge text-left col-xs-8 col-sm-2 <?php if($row['blog_available']=='1') { echo " curser-disable "; } ?>" id="publish<?php echo $row['blog_id'];?>" onclick="return publish_blog(<?php echo $row['blog_id'];?>);" style="cursor:pointer;">
                                    <?php echo ($row['blog_available']=='1'?"Info : Published":"Publish");?>
                                </label>

                                <?php if($row['blog_available']=='2' || $row['blog_available']=='3') {?>
                                    <a href="#" class="badge-stu-name badge text-left col-xs-8 col-sm-2 <?php if($row['blog_available']=='1') { echo " disabledlink "; }?>" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_blog_resend/<?php echo $row['blog_id'];?>');">
                                        <i class="entypo-plus-circled"></i>
                                        <?php echo ($row['blog_available']=='1'?"Published":"Resend");?>
                                    </a>
                                    <?php } ?>
                                        <?php } ?>

                                <div class="text-right">
                                    <a id="insert" name="save_details" value="" onclick="location.href = '<?php echo base_url(); ?>index.php?blogs/view_blogs';" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Back"><i class="fa fa-reply"></i>
                                    </a>
                                </div>
                    </div>
                </div>

                    <div class="col-md-12 no-padding">
                        <div class="white-box">
                            <div class="row m-b-20">
                                <label class="col-xs-12 col-sm-2" for="blog_title">
                                    <h4 class="m-0"><b><?php echo get_phrase('blog_title ');?> :</b></h4></label>
                                <div class="col-xs-12 col-sm-10">
                                    <p class="text-font">
                                        <?php echo $row['blog_title'];?>
                                    </p>
                                </div>
                            </div>
                
                            <div class="row form-group" data-step="5" data-intro="<?php echo get_phrase('Helps to preview the blog content.');?>" data-position='top'>
                                <label class="control-label col-xs-12 col-sm-2" for="blog_info">
                                    <h4 class="m-0"><b><?php echo get_phrase('blog_information ');?> :</b></h4></label>
                                <div class="col-xs-12 col-sm-10 text-font">
                                    <?php echo " ".$row['blog_information'];?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php echo form_close();?>
                    <?php }    
        } ?>
    </div>
</div>

<script>
    function publish_blog(blog_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?ajax_controller/blog_available/' + blog_id,
            success: function(response) {
                $("#publish" + blog_id).prop('disabled', true);
                //toastr.success('Blog is now public');
                window.location = window.location;
            },
            error: function(response) {
                alert("error");
            }
        });
    }
</script>