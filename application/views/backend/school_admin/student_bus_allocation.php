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
    <!-- /.breadcrumb -->
</div>


<?php if ($this->session->flashdata('flash_validation_error')) { ?>        
    <div class="alert alert-danger">
        <?php echo $this->session->flashdata('flash_validation_error'); ?>
    </div>
<?php } ?>

<div class="row m-0">
<div class="col-md-12 white-box" data-step="5" data-intro="<?php echo get_phrase('From_here_you_can_manage_the_student_bus_allocation.');?>" data-position="top">


    <?php echo form_open(base_url() . 'index.php?school_admin/add_student_bus', array('class' => 'form-groups-bordered validate', 'target' => '_top')); ?> 

       <div class="row">             
        <div class="col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase("user_type"); ?></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="ti-user"></i></div>                  
                <input type="text" class="form-control" name="user_type" value="<?php echo get_phrase('student'); ?>" disabled="disabled">
            </div>
        </div>    
        <div class="col-md-6 form-group">
            <label for="field-1">
                <?php echo get_phrase('class'); ?>
                <span class="error mandatory" > *</span></label>
            <?php // pre($classes); exit;  ?>
            <select name="class_id" id="class_id" class="selectpicker" data-style="form-control" data-live-search="true" onchange=" select_section(this.value)" required="required" data-validate="required" data-message-required ="Please select a class">
                <option value=""><?php echo get_phrase('select_class'); ?></option>
                <?php
                foreach ($classes as $row):
                    ?>
                    <option value="<?php echo $row['class_id']; ?>"><?php echo $row['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
   
       </div>
    

    <div class="row">
    <div class="col-md-6 form-group">
                    <label for="field-2" ><?php echo get_phrase('section'); ?><span class="error mandatory"> *</span></label>                   
                        <select name="section" class="selectpicker" data-style="form-control" data-live-search="true" id="section" onchange="get_class_students(this.value)" required="required" data-validate="required" data-message-required ="<?php echo get_phrase('please_select_section'); ?>">
                            <option value=""><?php echo get_phrase('select_class_first'); ?></option>
                        </select>  
                    </div>
   
        <div class="col-md-6 form-group">
                    <label><?php echo get_phrase('student'); ?><span class="error mandatory"> *</span></label>
                    
                        <select name="student_id" class="selectpicker" data-style="form-control" data-live-search="true" id="student_selection_holder"
                                required="required" data-validate="required" data-message-required ="<?php echo get_phrase('please_select_name'); ?>">
                            <option value=""><?php echo get_phrase('select_class_and_section_first'); ?></option>
                        </select>
                    </div>
                </div>
   
    <div class="row">
        <div class="col-md-6 form-group">
            <label><?php echo get_phrase('route'); ?><span class="error mandatory"> *</span></label>                 
            <select name="route" class="selectpicker" data-style="form-control" data-live-search="true" id="route"
                    required="required" data-validate="required" data-message-required ="<?php echo get_phrase('please_select_route'); ?>" onchange="getbustops(this.value);">
                <option value=""><?php echo get_phrase('select'); ?></option>
                <?php foreach ($bus as $row) { ?>
                    <option value="<?php echo $row['transport_id']; ?>">
                        <?php echo $row['route_name']; ?>
                    </option>
                <?php } ?>

            </select>
        </div>
         <div class="col-md-6 form-group">
                    <label><?php echo get_phrase('bus_stops'); ?><span class="error" style="color: red;"> *</span></label>                    
                        <select name="bustop_id" class="selectpicker" data-style="form-control" data-live-search="true" style="width:100%;" id="bus_stops_holder" required="required" data-validate="required" data-message-required ="<?php echo get_phrase('please_select_bus_stop'); ?>" onchange="get_bus();">
                            <option value=""><?php echo get_phrase('select_bus_stop'); ?></option>
                        </select>
                    
                </div>
    </div>
    
<!--    <div>
	<span id = "route_fare" style="color: blue;">                       
	</span>
    </div>-->

    <div class="row">
        <div class="col-md-6 form-group">
            <label><?php echo get_phrase('bus'); ?><span class="error mandatory"> *</span></label>

            <select name="bus" class="selectpicker" data-style="form-control" data-live-search="true" onclick="get_route_fare()" id="bus" required="required" data-validate="required" data-message-required ="<?php echo get_phrase('please_select_route_first'); ?>">
                <option value=""><?php echo get_phrase('select_route_first'); ?></option>
            </select>
        </div>  
        <!-- <div class="col-md-6 form-group">
            <label for='start_date'><?php echo get_phrase('start_date'); ?></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="icon-calender"></i></div>
                <input id= "start_date" type="text" class="form-control mydatepicker"  name="start_date" placeholder="mm/dd/yyyy" data-validate="required" data-message-required ="Please pick a date">
            </div>
        </div> -->
    </div>

<!--<span  id="route_fare"></span>-->
    
    <!-- <div class="row">    
        <div class="col-md-6 form-group">
            <label for='end_date'><?php echo get_phrase('end_date'); ?></label>
            <div class="input-group"><div class="input-group-addon"><i class="icon-calender"></i></div>
                <input id= "end_date" type="text" class="form-control mydatepicker"  name="end_date" placeholder="mm/dd/yyyy" data-validate="required" data-message-required ="Please pick a date">
            </div>
        </div>
    
    </div> -->

    <div class="text-right">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d">
	    <?php echo get_phrase('assign_bus'); ?>
	</button>
    </div>
    <?php echo form_close(); ?>
</div>
</div>

<script type="text/javascript">
    function get_class_students(section_id) {
        var class_id = $("#class_id option:selected").val();

        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_students/' + class_id + '/' + section_id,
            success: function (response)
            {
                jQuery('#student_selection_holder').html(response).selectpicker('refresh');
            }
        });
    }
    function select_section(class_id) {

        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_class_section/' + class_id,
            success: function (response)
            {

                jQuery('#section').html(response).selectpicker('refresh');
            }
        });
    }

    function get_bus() {
        var route = $("#route option:selected").val();

        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_bus/' + route,
            success: function (response)
            {
                jQuery('#bus').html(response).selectpicker('refresh');
            }
        });
    }
    function get_route_fare() {
        var route = $("#route option:selected").val();

        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_route_fare/' + route,
            success: function (response)
            {
                jQuery('#route_fare').html(response).selectpicker('refresh');
            }
        });
    }
        function getbustops(route_id){
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?ajax_controller/get_bus_stops/' + route_id ,
                success: function (response)
                {
                    jQuery('#bus_stops_holder').html(response).selectpicker('refresh');
                }
            });
        }
 
</script>



