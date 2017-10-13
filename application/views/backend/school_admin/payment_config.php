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
            <li><?php echo get_phrase('setting'); ?>
                <ul>                    
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/system_settings"><?php echo get_phrase('General Settings'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/sms_settings"><?php echo get_phrase('sms_settings'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/manage_language"><?php echo get_phrase('language_settings'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/bulk_upload"><?php echo get_phrase('bulk_upload'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/manage_profile"><?php echo get_phrase('profile'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/manage_device"><?php echo get_phrase('devices'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/notification_dashboard"><?php echo get_phrase('notification_dashboard'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/view_payment_details"><?php echo get_phrase('payment_gateway'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/login_history"><?php echo get_phrase('login_history'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/database_data_backup_list"><?php echo get_phrase('view_backup_list'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/home_works"><?php echo get_phrase('configure_home_work'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/setting_feedback"><?php echo get_phrase('feedback'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?fees/main/print_setting"><?php echo get_phrase('invoice_print_setting'); ?></a></li>
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
<div class="col-md-12 white-box">
  
    <?php echo form_open(base_url().'index.php?school_admin/payment_config', array('class' =>'form-horizontal','id'=>'addPaymentOptionsId', 'method' => 'POST'));?>
    
    <?php if ($this->session->flashdata('flash_message_error')) { ?>        
        <div class="alert alert-danger">
            <?php echo $this->session->flashdata('flash_message_error'); ?>
        </div>
    <?php } ?>
    
    <div class="form-group">
        <label class="control-label col-sm-2" for="payment_option"><?php echo get_phrase('gateway_names').":";?><span class="error" style="color: red;"> *</span></label>
        <div class="col-sm-5">
            <select class="selectpicker" data-style="form-control" data-live-search="true" name="payment_gateway" id="payment_gateway" required>
                <option value=""><?php echo get_phrase('select_payment_gateway');?></option>
                <?php foreach ($payment_options as $vals){ ?>
                <option value="<?php echo $vals;?>"><?php echo $vals;?></option> 
                <?php } ?>
            </select>
      </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-sm-2" for="type_of_gateway"><?php echo get_phrase('type_of_gateway').":";?><span class="error" style="color: red;"> *</span></label>
        <div class="col-sm-5">          
            <label class="radio-inline">
                <input type="radio" name="type_of_gateway" value="0" required ><?php echo get_phrase('sandbox'); ?>
            </label>
            <label class="radio-inline">
                <input type="radio" name="type_of_gateway" value="1" required ><?php echo get_phrase('live'); ?>
            </label>    
        </div>
    </div>
    
    
    <div class="form-group">
        <label class="control-label col-sm-2" for="endpoints"><?php echo get_phrase('endpoints');?>:<span class="error" style="color: red;"> *</span></label>
        <div class="col-sm-5">
            <input type="text" class="form-control" id="endpoints" placeholder=" " name="endpoints" required >
        </div>
    </div>
      
    <div class="form-group">
        <label class="control-label col-sm-2" for="username"><?php echo get_phrase('user_name');?>:<span class="error" style="color: red;"> *</span></label>
        <div class="col-sm-5">
            <input type="text" class="form-control" id="username" placeholder="" name="username" required >
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-sm-2" for="password"><?php echo get_phrase('password');?>:</label>
        <div class="col-sm-5">
            <input type="password" class="form-control" id="password" placeholder="" name="password" >
        </div>
    </div>     
      
    <div class="form-group">
        <label class="control-label col-sm-2" for="hostname"><?php echo get_phrase('host_name');?>:</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" id="hostname" placeholder="" name="hostname" >
        </div>
    </div>         
    
    
    <div class="form-group">        
        <label class="control-label col-sm-2" for="signature"><?php echo get_phrase('signature');?>:</label>
        <div class="col-sm-5">          
            <textarea class="form-control" rows="3" id="signature" name="signature"></textarea>
        </div>
    </div>
    
    
    
    
    
   
    <div class="col-md-12 text-center"> 
        <button type="submit" class="btn btn-success" id="insert" name="save_details" value="save_details"><i class="fa fa-save"></i><?php echo get_phrase('save_details'); ?></button>
    </div>      
    <?php echo form_close();?>
</div>
</div>
