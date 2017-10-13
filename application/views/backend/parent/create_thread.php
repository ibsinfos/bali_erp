<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('Create_thread'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
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
                <a href="<?php echo base_url(); ?>index.php?discussion_forum/view_all_threads">
                    <?php echo get_phrase('view_all_threads'); ?>
                </a>
            </li>
            <li class="active">
                <?php echo get_phrase('Create_thread'); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<div class="row">
    <div class="col-md-12" data-step="5" data-intro="<?php echo get_phrase('Fill the title, category and description and click on Create Thread button.');?>" data-position="top">   
            <?php     
            if($this->session->flashdata('flash_message_error')) {?>        
            <div class="alert alert-danger">
            <?php echo $this->session->flashdata('flash_message_error'); ?>
            </div>
            <?php } ?>

            <?php echo form_open(base_url().'index.php?discussion_forum/create_thread/create', array('class'=>'well'));?>
            
            <div class="form-group col-md-6">
                <label for="title"><?php echo get_phrase('title');?>:<span class="error mandatory"> *</span></label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="form-group col-md-6">
                <label for="category"><?php echo get_phrase('category');?>:<span class="error mandatory"> *</span></label>
                <select name="category" id="category"  class="selectpicker" data-style="form-control" data-live-search="true" required>
                    <option value=""><?php echo get_phrase('select_category');?></option>
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat['category_id']; ?>"><?php echo $cat['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-md-12">
                 <label><?php echo get_phrase('Description');?>:<span class="error mandatory"> *</span></label>
                 <textarea class='summernote' name='description' required ></textarea>
            </div>

            <div class="text-right p-l-15 p-r-15">
                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('create_thread');?></button>
            </div>

            <?php echo form_close();?>
    </div>
</div>
