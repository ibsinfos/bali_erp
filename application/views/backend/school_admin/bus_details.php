<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?></h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><?php echo get_phrase('transport'); ?>
                <ul>                    
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/transport"><?php echo get_phrase('manage_route'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/route_bus_stop"><?php echo get_phrase('manage_bus_stop'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/bus"><?php echo get_phrase('manage_bus'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/livetrack"><?php echo get_phrase('track_buses'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/bus_admin"><?php echo get_phrase('bus_administrator'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/bus_driver"><?php echo get_phrase('bus_driver'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/manage_student_bus"><?php echo get_phrase('manage_student_bus'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/manage_vehicle_details"><?php echo get_phrase('vehicle_service_maintenance'); ?></a></li>
                </ul>
            </li>
            <li class="active">
                <?php echo $page_title; ?>
            </li>
        </ol>
    </div>
</div>

    <?php if ($this->session->flashdata('flash_validation_error')) { ?>        
        <div class="alert alert-danger">
            <?php echo $this->session->flashdata('flash_validation_error'); ?>
        </div>
    <?php } ?>

    <div class="col-md-12 white-box" data-step="5" data-intro="<?php echo get_phrase('Here you can add the vehicle service and maintainenance details.');?>" data-position="top">
        <?php echo form_open(base_url() . 'index.php?school_admin/bus_details/create', array('class' => 'form-groups-bordered validate', 'target' => '_top')); ?>   
            <div class="col-md-6 form-group">
                <label for="field-1"><?php echo get_phrase('bus'); ?><span class="mandatory"> *</span></label>
                <select name="bus" class="selectpicker" data-style="form-control" data-live-search="true" onclick="get_bus()" id="bus"
                        required="required" data-validate="required" data-message-required ="<?php echo get_phrase('please_select_bus'); ?>">
                    <option><?php echo get_phrase('select_bus'); ?></option>
                    <?php foreach ($bus as $row) { ?>
                        <option value="<?php echo $row['bus_id']; ?>">
                            <?php echo $row['name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <span id="route_name"></span>
            <div class="col-md-6 form-group">
                <label for="field-1"><?php echo get_phrase("purchase_date"); ?><span class="mandatory"> *</span></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="icon-calender"></i></span>             
                    <input id= "purchase_date" class="form-control mydatepicker" required="required" name="purchase_date" placeholder="Pick a date" data-validate="required" data-message-required ="Please pick a date">
                    <span class="mandantory"> <?php echo form_error('purchase_date'); ?></span>
                </div> 
            </div>
        
        
            <div class="col-md-6 form-group">
                <label for="field-1"><?php echo get_phrase("service_date"); ?><span class="mandatory"> *</span></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="icon-calender"></i></span>             
                    <input id= "service_date" class="form-control mydatepicker" required="required" name="service_date" placeholder="Pick a date" data-validate="required" data-message-required ="Please pick a date">
                    <span class="mandantory"> <?php echo form_error('service_date'); ?></span>
                </div> 
            </div>
        
        
            <div class="col-md-6 form-group">
                <label for="field-1"><?php echo get_phrase("vendor_company_name"); ?><span class="mandatory"> *</span></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-home"></i></div>                  
                    <input id= "vendor_company" type="text" class="form-control"  name="vendor_company" required="required" placeholder="<?php echo get_phrase('vendor_company_name'); ?>" data-validate="required" data-message-required ="<?php echo get_phrase('please_enter_vendor_company_name'); ?>">

                </div> 
            </div>
        
        
            <div class="col-md-6 form-group">
                <label for="field-1"><?php echo get_phrase("vendor_name"); ?><span class="mandatory"> *</span></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-user"></i></div>                  
                    <input id= "vendor_name" type="text" class="form-control"  name="vendor_name" placeholder="<?php echo get_phrase('vendor_name'); ?>" required="required" data-validate="required" data-message-required ="<?php echo get_phrase('please_enter_vendor_name'); ?>">
                </div> 
            </div>
        
        
            <div class="col-md-6 form-group">
                <label for="field-1"><?php echo get_phrase("vendor_contact_number"); ?><span class="mandatory"> *</span></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-phone"></i></div>                  
                    <input id= "vendor_contact" type="tel" class="form-control numeric"  name="vendor_contact" placeholder="<?php echo get_phrase('vendor_phone_number'); ?>" required="required" data-validate="required" data-message-required ="<?php echo get_phrase('please_enter_vendor_phone_number'); ?>" maxlength="10">
                </div> 
            </div>
        
        
            <div class="col-md-6 form-group">
                <label for="field-1"><?php echo get_phrase("cost_of_vehicle"); ?><span class="mandatory"> *</span></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-money"></i></div>                  
                    <input id= "cost" type="tel" class="form-control numeric"  name="cost" placeholder="<?php echo get_phrase('cost_of_vehicle'); ?>" required="required" data-validate="required" data-message-required ="<?php echo get_phrase('please_enter_cost_of_vehicle'); ?>">
                </div> 
            </div>
        
        <div class="col-md-6 form-group">
                <label for="field-1"><?php echo get_phrase("insurance_expiry_date"); ?><span class="mandatory"> *</span></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="icon-calender"></i></span>             
                    <input id= "insurance_expiry_date" class="form-control mydatepicker" required="required" name="insurance_expiry_date" placeholder="Pick a date" data-validate="required" data-message-required ="Please pick a date">
                    <span class="mandantory"> <?php echo form_error('insurance_expiry_date'); ?></span>
                </div> 
            </div>
        
            <div class="col-md-6 form-group">
                <label for="field-1"><?php echo get_phrase("credit_facility"); ?><span class="mandatory"> *</span></label>
                <div>
                    <input type="radio" name="credit_facility" value="yes" required>
                    <label class="p-l-10 p-r-10" for="radio14"><?php echo get_phrase('yes'); ?></label>
                    <input type="radio" name="credit_facility" value="no" required >
                    <label class="p-l-10 p-r-10" for="radio14"><?php echo get_phrase('no'); ?></label> 
                    </div>  
            </div>
    
        <div class="col-xs-12 text-center">
            <input type="submit" data-step="6" data-intro="<?php echo get_phrase('On click of submit, details will get added and if any error is their then it will display in the page');?>" data-position='left'class="fcbtn btn btn-danger btn-outline btn-1d" value="Submit"/>
            
        </div>
        <?php echo form_close(); ?>
    </div>
 
<script type="text/javascript">
    function get_bus() {
        var bus_id = $("#bus option:selected").val();

        $.ajax({
            url: '<?php echo base_url(); ?>index.php?ajax_controller/get_route_name/' + bus_id,
            success: function (response)
            {
                jQuery('#route_name').html(response).selectpicker('refresh');
            }
        });
    }

    jQuery(document).ready(function () {
        $(".numeric").numeric();
    });
</script>





