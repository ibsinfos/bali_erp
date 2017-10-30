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
            <li><?php echo get_phrase('disciplinary'); ?>
                <ul>                    
                    <li><a href="<?php echo base_url(); ?>index.php?disciplinary/manage_violation_types"><?php echo get_phrase('Violation Type'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?disciplinary/manage_incident"><?php echo get_phrase('All Incidents'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?disciplinary/my_incident"><?php echo get_phrase('My Incidents'); ?></a></li>
                </ul>
            </li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<?php     
if($this->session->flashdata('flash_message_error')) {?>        
<div class="alert alert-danger">
<?php echo $this->session->flashdata('flash_message_error'); ?>
</div>
<?php } ?>
<div class="row">
    <div class="col-md-12">
        <div class="white-box" data-step="5" data-intro="<?php echo get_phrase('You_can_create_a_new_violation_type_from_here.');?>" data-position='top'>
            <?php echo form_open(base_url() . 'index.php?disciplinary/add_violation_types/create', array('class' => 'validate', 'target' => '_top')); ?> 
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="field-1"><?php echo get_phrase("violation_type"); ?><span class="mandatory"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-database"></i></div>                  
                        <input type="text" class="form-control" id="type" name="type" value="<?php echo set_value('type') ?>" placeholder="Violation Type" data-validate="required" data-message-required ="<?php echo get_phrase('plesae_enter_the_type'); ?>">
                        <span class="mandantory"> <?php echo form_error('type'); ?></span>
                    </div> 
                </div>
                <div class="col-md-6 form-group">
                    <label for="field-1"><?php echo get_phrase("description"); ?><span class="mandatory"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-text-height"></i></div>                  
                        <input type="text" class="form-control" id="description" name="description" value="<?php echo set_value('description') ?>" placeholder="Description" data-validate="required" data-message-required ="<?php echo get_phrase('plesae_enter_the_description'); ?>">
                        <span class="mandantory"> <?php echo form_error('description'); ?></span>
                    </div> 
                </div>
            </div>
            <div class="text-center">
                <input type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" value="Create Violation Type" data-step="6" data-intro="<?php echo get_phrase('You_can_create_violation_type_from_here.');?>" data-position='left'/>
            </div>  
            <?php echo form_close(); ?>
        </div>
    </div>
</div>



