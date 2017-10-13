<div class="row bg-title"> 
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?blogs/view_my_blogs"><?php echo get_phrase('view_my_blogs'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
</div>

    <?php foreach($blog_data as $data){ ?>
    <div class="col-md-12">
        <div class="white-box">
            <div class="row">
                <label class="col-xs-12 col-sm-2" for="blog_title">
                    <h4 class="m-0"><b><?php echo get_phrase('comments_from_author_ ');?> :</b></h4></label>
                <div class="col-xs-12 col-sm-10">
                    <p class="text-font">
                        <?php echo $data['blog_resend_comment'];?>
                    </p>
                </div>
            </div>
        </div>
    </div>
       <div class="col-md-12">
        <div class="white-box">
            <?php echo form_open(base_url().'index.php?blogs/blog_edit/edit/'.$data['blog_id'], array());
            if($this->session->flashdata('flash_message_error')) {?>        
            <div class="alert alert-danger">
            <?php echo $this->session->flashdata('flash_message_error'); ?>
            </div>
            <?php } ?>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="blog_category">
                        <?php echo get_phrase('blog_category');?>:<span class="error mandatory"> *</span></label>

                    <select name='blog_category' data-style="form-control" data-live-search="true" class="selectpicker" onchange="return get_blog_subcategory(this.value);">
                        <option value=""><?php echo get_phrase('select_category');?> </option>
                        <?php foreach($blog_category as $cats){ ?>

                        <option value="<?php echo $cats['blog_category_id'];?>"
                                <?php if($data['blog_category_id'] == $cats['blog_category_id']) echo 'selected';?>
                                ><?php echo $cats['blog_category_name'];?></option>
                        <?php } ?>
                    </select>

                </div>

                <div class="form-group col-md-6">
                    <label for="blog_subcategory">
                        <?php echo get_phrase('blog_subcategory');?>:</label>

                    <select name='subcategory' id ='section__holder' data-style="form-control" data-live-search="true" class="selectpicker">
              <option value=" " ><?php echo get_phrase('select_section'); ?></option>
          </select>

                </div>


                <div class="form-group col-md-12">
                    <label for="blog_title">
                        <?php echo get_phrase('blog_title');?>:<span class="error mandatory"> *</span></label>

                    <input type="text" class="form-control" id="last_name" name= "blog_title" placeholder="Blog Title" required value="<?php echo $data['blog_title'];?>">

                </div>



                <div class="form-group col-md-12">
                    <label for="blog_content">
                        <?php echo get_phrase('blog_information');?>:<span class="error mandatory"> *</span></label>
                       <textarea class='summernote'  id="blog_info" name="blog_info"  required><?php echo $data['blog_information'];?></textarea> 
                </div>



                <div class="col-xs-12 text-right btn-center-in-sm">
                    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"  name="resent_to_author" value="resent_to_author">

                        <?php echo get_phrase('resend');?>
                    </button>
                </div>
            </div>
            <?php echo form_close();?>
        </div>
    </div>
  <?php } ?>




 





<script>
    function get_blog_subcategory(category_id) {
        $.ajax({
            url: '<?php echo base_url();?>index.php?ajax_controller/get_blog_subcategories/' + category_id,
            success: function(response) {
                jQuery('#section__holder').html(response).selectpicker('refresh');
            }
        });
    }
</script>
