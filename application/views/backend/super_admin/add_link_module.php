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
            <li><a href="<?php echo base_url(); ?>index.php?super_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?super_admin/link_module"><?php echo get_phrase('manage_link_module'); ?></a></li>
            <li class="active"> <span><?php echo get_phrase($page_title); ?></span></li>
            
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>            
 <?php
     $msg=$this->session->flashdata('flash_message_error');
     if ($msg) { ?>        
        <div class="alert alert-danger">
            <?php echo $msg; ?>
        </div>
<?php } ?>
<div class="col-md-12 white-box" data-step="5" data-intro="To fill the details, you can add a new module from here." data-position='top'>
    <?php echo form_open(base_url() . 'index.php?super_admin/link_module/create', array('class' => ' form-groups-bordered validate', 'target' => '_top','enctype' => 'multipart/form-data')); ?>
        <div class="row">
            <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                <label for="field-1"><?php echo get_phrase('link_name');?><span class="error mandatory"> *</span></label>                
                <input type="text" class="form-control" name="name" value="<?php echo set_value('name');?>" required>                                    
                </div>
            </div>

            <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                <label for="field-1"><?php echo get_phrase('link');?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-link"></i></div>
                    <input type="text" class="form-control" name="link"  value="<?php echo set_value('link');?>">                                       
                </div>
            </div>
            <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                <label for="field-1"><?php echo get_phrase('Select_user_Type');?><span class="error mandatory"> *</span></label>
                <select class="selectpicker" data-style="form-control" name="user_type" id="user_type" data-live-search="true" >                                       
                    <option value="0">Select User Type</option>
                    <option value="T">Teacher</option>
                    <option value="P">Parent</option>
                    <option value="S">Student</option>
                    <option value="A">Admin</option>
                </select>
            </div>
            <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                <label for="field-1"><?php echo get_phrase('order');?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-link"></i></div>
                    <input type="text" class="form-control" name="order"  value="<?php echo set_value('order');?>">                                       
                </div>
            </div>
            <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                <label for="field-1"><?php echo get_phrase('parent_link');?><span class="error mandatory"> *</span></label>
                <select class="selectpicker" data-style="form-control" name="parent_id" id="parent_id" data-live-search="true" >                                       
                    <option value="">Select Parent Link</option>
                    <?php foreach($parent_links as $key => $value){?>
                        <option value="<?php echo $value['id'];?>"><?php echo $value['name']?></option>
                    <?php }?>
                </select>
            </div>
            <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                <label for="field-1"><?php echo get_phrase(' Image');?></label>
                <div class="col-sm-12 no-padding">

                <input type="file" id="input-file-now" class="dropify" name="linkmodulefile" /> 
            </div>
            </div>    
    
        <div class="row">          
            <div class="col-xs-12 form-group text-right">
                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('add'); ?></button>                                        
            </div>                                    
        </div>
        </div>   

    
    <?php echo form_close(); ?> 
</div>
