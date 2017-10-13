<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('manage_category'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" target="_blank" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>

        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><?php echo get_phrase('blogs'); ?>
                <ul>                    
                    <li><a href="<?php echo base_url(); ?>index.php?blogs/view_category_subcategory"><?php echo get_phrase('Category / Subcategory'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?blogs/view_blogs"><?php echo get_phrase('view_all_blogs'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?blogs/view_all_blogs"><?php echo get_phrase('view_published_blogs'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?blogs/view_my_blogs"><?php echo get_phrase('view_my_blogs'); ?></a></li>                    
                </ul>
            </li>
            <li class="active">
                <?php echo $page_title; ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <section>
                <div class="sttabs tabs-style-flip">
                    <nav>
                        <ul>
                            <li><a href="#section-flip-1" class="sticon fa fa-plus-circle"><span><?php echo get_phrase('Create_Category'); ?></span></a></li>
                            <li><a href="#section-flip-2" class="sticon fa fa-plus-circle"><span><?php echo get_phrase('Create_Subcategory'); ?></span></a></li>

                        </ul>
                    </nav>
                    <div class="content-wrap">
                        <section id="section-flip-1">

                            <?php echo form_open(base_url().'index.php?blogs/addcategory/create', array('class' =>'validate','id'=>'addCategorySubcategoryId', 'method' => 'POST'));?>
                                <div class="row">
                                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                                        <label for="create_update">
                                            <?php echo get_phrase('category');?>:<span class="error" style="color: red;"> *</span></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-plus"></i></div>
                                            <input type="text" class="form-control" name="category_name" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" autofocus value=""> </div>
                                    </div>

                                    <div class="col-md-12 text-center m-t-20">
                                        <button type="submit" name="add_new" value="add_new" id="insert" class="fcbtn btn btn-danger btn-outline btn-1d">
                                            <?php echo get_phrase('add'); ?>
                                        </button>

                                    </div>
                                </div>
                                <?php echo form_close();?>


                        </section>

                        <section id="section-flip-2">
                            <?php echo form_open(base_url().'index.php?blogs/addcategory/subcreate', array('class' =>'validate','id'=>'addCategorySubcategoryId', 'method' => 'POST'));?>
                                <div class="row">
                                    <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                                        <label for="create_update">
                                            <?php echo get_phrase('select_category');?>:<span class="error" style="color: red;"> *</span></label>

                                        <select name="blog_category_parent_id" class="selectpicker" data-style="form-control" data-live-search="true" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>">
                                            <option value="">
                                                <?php echo get_phrase('select_category'); ?>
                                            </option>
                                            <?php if(!empty($blog_categories)){ 
                foreach($blog_categories as $cat){?>
                                                <option value="<?php echo $cat['blog_category_id'];?>">
                                                    <?php echo $cat['blog_category_name'];?>
                                                </option>
                                                <?php } }?>
                                        </select>
                                    </div>
                                    
                                    <div class="col-xs-12 col-md-offset-3 col-md-6 m-b-20">
                                        <label for="create_update">
                                            <?php echo get_phrase('sub_category');?>:<span class="error" style="color: red;"> *</span></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-plus"></i></div>
                                            <input type="text" class="form-control" name="subcategory_name" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" autofocus value=""> </div>
                                    </div>

                                    <div class="col-md-12 text-center m-t-20">
                                        <button type="submit" name="add_new" value="add_new" id="insert" class="fcbtn btn btn-danger btn-outline btn-1d">
                                            <?php echo get_phrase('add'); ?>
                                        </button>

                                    </div>
                                </div>

                                <?php echo form_close();?>

                        </section>

                    </div>
                    <!-- /content -->
                </div>
                <!-- /tabs -->
            </section>
        </div>
    </div>
</div>