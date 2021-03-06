<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('Create_blog'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>index.php?school_admin/dashboard">
                    <?php echo get_phrase('Dashboard'); ?>
                </a>
            </li>
            <li class="active">
                <?php echo get_phrase('Create_blog'); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<div class="row">
    <div class="col-md-12">
        <div class="white-box" data-step="5" data-intro="<?php echo get_phrase('Here you can create a new blog');?>" data-position='top'>
            <?php echo form_open(base_url().'index.php?blogs/create_blog', array('class' =>'top-for-tabs','id'=>'blogIdForm'));
            if($this->session->flashdata('flash_message_error')) {?>
                <div class="alert alert-danger">
                    <?php echo $this->session->flashdata('flash_message_error'); ?>
                </div>
                <?php } ?>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="blog_category">
                                <?php echo get_phrase('blog_category');?>:<span class="error mandatory"> *</span></label>

                            <select name='blog_category' class="selectpicker" data-style="form-control" data-live-search="true" onchange="return get_blog_subcategory(this.value);">
                                <option value="">
                                    <?php echo get_phrase('select_category');?>
                                </option>
                                <?php foreach($blog_categories as $cats){ ?>
                                    <option value="<?php echo $cats['blog_category_id'];?>">
                                        <?php echo $cats['blog_category_name'];?>
                                    </option>
                                    <?php } ?>
                            </select>

                        </div>

                        <div class="form-group col-md-6">
                            <label for="blog_subcategory">
                                <?php echo get_phrase('blog_subcategory');?>:</label>

                            <select name='subcategory' id='section__holder' class="selectpicker" data-style="form-control" data-live-search="true">
                                <option value=" ">
                                    <?php echo get_phrase('select_sub_category'); ?>
                                </option>
                            </select>

                        </div>


                        <div class="form-group col-md-12">
                            <label for="blog_title">
                                <?php echo get_phrase('blog_title');?>:<span class="error mandatory"> *</span></label>

                            <input type="text" class="form-control" id="last_name" name="blog_title" placeholder="Blog Title" required>

                        </div>



                        <div class="form-group col-md-12">
                            <label for="blog_content">
                                <?php echo get_phrase('blog_information');?>:<span class="error mandatory"> *</span></label>
                                <textarea class='summernote'  name="blog_content" required > </textarea> 
                        </div>



                        <div class="col-xs-12 text-right btn-center-in-sm">
                            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" id="insert" name="save_details" value="save_blog">

                                <?php echo get_phrase('create_blog');?>
                            </button>
                        </div>
                    </div>
                    <?php echo form_close();?>
        </div>
    </div>
</div>

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