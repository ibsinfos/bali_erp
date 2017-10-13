 <?php foreach($details as $row) {?>
<div class="modal-body">
     <?php echo form_open(base_url() . 'index.php?school_admin/student_bus/edit/'.$row['student_bus_id'], array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?> 
    <div class="form-horizontal form-material">
        <div class="form-group">
            <div class="col-md-12 m-b-20">
                <label><?php echo get_phrase("user_type"); ?></label><span class="mandatory"> *</span>
                <input type="text" class="form-control" name="user_type" value="<?php echo get_phrase('student'); ?>" disabled="disabled">
                <label class="mandatory"> <?php echo form_error('name'); ?></label>
            </div>
            
            
            <div class="col-md-12 m-b-20">
                <label><?php echo get_phrase('student'); ?></label><span class="mandatory"> *</span>
                <input type="text" class="form-control" name="student" value="<?php echo $row['student_name']; ?>" disabled="disabled">
            </div>
                       
            <div class="col-md-12 m-b-20">
                <label><?php echo get_phrase('route'); ?></label><span class="mandatory"> *</span>
                <select name="route" class="selectpicker1" data-style="form-control" data-live-search="true" style="width:100%;" onclick="get_bus()" id="route"
                                required="required" data-validate="required" data-message-required ="<?php echo get_phrase('please_select_route'); ?>" onchange="return getbustops(this.value);">
                            <option value=""><?php echo get_phrase('select_route'); ?></option>
                            <?php foreach ($route as $value) { ?>
                                <option value="<?php echo $value['transport_id']; ?>" <?php if($value['transport_id'] == $row['route_id']){echo 'selected'; } ?> >
                                    <?php echo $value['route_name']; ?>
                                </option>
                            <?php } ?>

                        </select>
            </div>  
            <div class="col-md-12 m-b-20">
                <label><?php echo get_phrase('bus_stops'); ?></label><span class="mandatory"> *</span>
                <select name="bustop_id" class="selectpicker1" data-style="form-control" data-live-search="true" style="width:100%;" id="bus_stops_holder"
                                required="required" data-validate="required" data-message-required ="<?php echo get_phrase('please_select_bus_stop'); ?>" onchange="get_route_fare(this.value)">
                            <option value=""><?php echo get_phrase("select_route_first");?></option>
                                    <?php foreach ($bus_stops as $value) {?>
                                <option value="<?php echo $value['route_bus_stop_id']; ?>" <?php if($value['route_bus_stop_id'] == $row['bus_stop_id']){echo 'selected'; } ?> >
                                    <?php echo $value['route_from']."-".$value['route_to']; ?>
                                </option>
                            <?php } ?>
                        </select>
            </div>  
            <div style="text-align: center;">
                    <span id = "route_fare" style="color: blue;">                       
                    </span>
                </div>
            <div class="col-md-12 m-b-20">
                <label><?php echo get_phrase('bus'); ?></label><span class="mandatory"> *</span>
               <select name="bus" class="selectpicker1" data-style="form-control" data-live-search="true" style="width:100%;"  id="bus"
                                required="required" data-validate="required" data-message-required ="<?php echo get_phrase('please_select_route_first'); ?>">
                            <option value=""><?php echo get_phrase("select_route_first");?></option>
                                    <?php foreach ($bus as $value) {?>
                                <option value="<?php echo $value['bus_id']; ?>" <?php if($value['bus_id'] == $row['bus_id']){echo 'selected'; } ?> >
                                    <?php echo $value['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
            </div>  
            <div class="col-md-12 m-b-20">
                <label><?php echo get_phrase('start_date'); ?></label><span class="mandatory"> *</span>
                <input id= "start_date" type="text" class="form-control mydatepicker" required="required" value="<?php echo $row['start_date']?>"  name="start_date" placeholder="Pick a date" data-validate="required" data-message-required ="Please pick a date">
                <label class="mandatory"> <?php echo form_error('name'); ?></label>
            </div>
            
            
            <div class="col-md-12 m-b-20">
                <label><?php echo get_phrase('end_date'); ?></label><span class="mandatory"> *</span>
                <input id= "end_date" type="text" class="form-control mydatepicker" value="<?php echo $row['end_date']?>" required="required" name="end_date" placeholder="Pick a date" data-validate="required" data-message-required ="Please pick a date">
            </div>
            <div class="col-md-12 text-right">
                <button type="submit" class="fcbtn btn btn-danger btn-outline" id="sa-success" name="save_details"><?php echo get_phrase('update');?></button>
            </div>
        </div> 
    <?php echo form_close(); ?>
    </div>
</div>
<?php } ?>

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
    function get_route_fare(route_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?ajax_controller/get_route_fare/' + route_id,
            success: function (response)
            {
                jQuery('#route_fare').html(response).selectpicker('refresh');
            }
        });
    }

    function getbustops(route_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?ajax_controller/get_bus_stops/' + route_id,
            success: function (response)
            {
                jQuery('#bus_stops_holder').html(response).selectpicker('refresh');
            }
        });
    }

</script>
<script type="text/javascript">
    $(document).ready(function () {

        $('#start_date').datepicker({
           format: "yyyy/mm/dd"
        });

       $('#end_date').datepicker({
           format: "yyyy/mm/dd"
       });

    });
</script>


