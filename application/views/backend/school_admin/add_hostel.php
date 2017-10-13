<div class="row bg-title"> 
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo $page_title; ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><?php echo get_phrase('dormitory'); ?>
                <ul>                    
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/manage_hostel_warden"><?php echo get_phrase('manage_warden'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/manage_hostel"><?php echo get_phrase('manage_hostel'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/manage_hostel_room"><?php echo get_phrase('manage_room'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/manage_allocation"><?php echo get_phrase('manage_allocation'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/mess_management"><?php echo get_phrase('mess_details'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/mess_timetable"><?php echo get_phrase('mess_timetable'); ?></a></li>
                </ul>
            </li>
            <li class="active">
                <?php echo $page_title; ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<div class="row m-0">
<div class="col-md-12 white-box" data-step="5" data-intro="<?php echo get_phrase('To Fill this form, you can add a new hostel details from here.');?>" data-position='top'>
    
<?php     
if($this->session->flashdata('flash_message_error')) {?>        
<div class="alert alert-danger">
<?php echo $this->session->flashdata('flash_message_error'); ?>
</div>
<?php } ?>
   
    
 <?php echo form_open(base_url() . 'index.php?school_admin/add_hostel' , array('class' => 'validate','target'=>'_top')); ?> 
         
       
            <div class="form-group col-xs-12 col-md-6">
            <label for="field-1"><?php echo get_phrase("hostel_name"); ?><span class="mandatory"> *</span></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-bed"></i></div>                  
               <input type="text" class="form-control" id="hostel_name" name="hostel_name" value="<?php echo set_value('hostel_name')?>" placeholder="Hostel Name"  required="required">
               <span class="mandantory"> <?php echo form_error('hostel_name'); ?></span>
            </div> 
        </div>
       
           <div class="form-group col-xs-12 col-md-6">
            <label for="field-1"><?php echo get_phrase("hostel_type"); ?><span class="mandatory"> *</span></label>
           
                                  
              <select class="selectpicker" data-style="form-control" data-live-search="true" id="hostel_type" name="hostel_type" required="required">
                        <option value="">Select Hostel Type</option>
                        <option value="Girls">Girls</option>
                        <option value="Boys">Boys</option>
              </select>
           
        </div>
     
            <div class="form-group col-xs-12 col-md-6">
            <label for="field-1"><?php echo get_phrase("hostel_phone_number"); ?><span class="mandatory"> *</span></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-phone"></i></div>                  
               <input type="tel" class="form-control numeric" id="hostel_phone_number" name="hostel_phone_number" value="<?php echo set_value('hostel_phone_number')?>" placeholder="Phone Number"  required="required" maxlength="10">
                    <span class="mandantory"> <?php echo form_error('hostel_phone_number'); ?></span>
            </div> 
        </div>
      
        <?php if(!empty($warden)){?>
       
            <div class="form-group col-xs-12 col-md-6">
            <label for="field-1"><?php echo get_phrase("warden_name"); ?><span class="mandatory"> *</span></label>
                            
              <select class="selectpicker" data-style="form-control"  multiple="multiple" id="warden_name" name="warden_name[]" required="required" data-max-options="2" data-live-search="true">
                        <?php foreach ($warden as $value) {?>
                        <option value="<?php echo $value['warden_id'];?>"><?php echo $value['name'];?></option>
                        <?php } ?>
                    </select>
                <span class="mandatory"> <?php echo form_error('warden_name'); ?></span>
          
        </div>
      
        <?php } else {?>
        
      
            <div class="form-group col-xs-12 col-md-6">
            <label for="field-1"><?php echo get_phrase("warden_name"); ?><span class="mandatory"> *</span></label>
                        
            <select class="selectpicker" data-style="form-control" required="required" data-max-options="2" data-live-search="true">
                        <option value=""><?php echo get_phrase('select_name')?></option>
            </select>
                <span class="mandatory"> <?php echo form_error('warden_name'); ?></span>
       
        </div>
   
 <?php } ?>
     
            <div class="form-group col-xs-12 col-md-12">
                    <label for="hostel_address"><?php echo get_phrase("hostel_address"); ?><span class="error" style="color: red;"> *</span></label>
                    <textarea class="form-control" id="hostel_address" name="hostel_address" rows="2" placeholder="Hostel Address"  required="required"><?php echo set_value('hostel_address')?></textarea>
                 <label style="color:red;"> <?php echo form_error('hostel_address'); ?></label>
                </div>
                
    
        <div class="col-md-12 text-right">
        <input type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" value="Add Hostel"/>
        
        </div>
    <?php echo form_close(); ?>
</div>
</div>
           
    
<script type="text/javascript">  
$(document).ready(function(){
       $(".numeric").numeric(); 
    });

$('#warden_name').multiselect({
    placeholder: 'Select Name',
    search: true,
    selectAll: true
});
</script>
