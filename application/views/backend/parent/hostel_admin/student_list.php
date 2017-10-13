<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label><?php echo get_phrase('hostel_type'); ?><span class="error" style="color: red;"> *</span></label>
            <div class="col-sm-6">
                <select name="type"  class="selectpicker" data-style="form-control" data-live-search="true" style="width:100%;" onclick="get_hostel_name()" id="type" required="required" data-validate="required">
                    <option value="">Select</option>
                    <option value="Girls">Girls</option>
                    <option value="Boys">Boys</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label><?php echo get_phrase('hostel_name'); ?><span class="error" style="color: red;"> *</span></label>
            <div class="col-sm-6">
                <select name="hostel_name"   class="selectpicker" data-style="form-control" data-live-search="true" style="width:100%;" onclick="get_floor_name()" id="hostel_name" required="required" data-validate="required" data-message-required ="<?php echo get_phrase('please_select_type'); ?>">
                    <option value=""><?php echo get_phrase('select_hostel_type_first'); ?></option>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <label><?php echo get_phrase('floor_name'); ?><span class="error" style="color: red;"> *</span></label>
    <div class="col-sm-6">
        <select name="floor"  class="selectpicker" data-style="form-control" data-live-search="true" style="width:100%;" onclick="get_hostel_room()" id="floor" required="required" data-validate="required" data-message-required ="<?php echo get_phrase('please_select_hostel_name'); ?>">
            <option value=""><?php echo get_phrase('select_hostel_name_first'); ?></option>
        </select>
    </div>
</div>
<div class="form-group">
    <label><?php echo get_phrase('room_no.'); ?><span class="error" style="color: red;"> *</span></label>
    <div class="col-sm-6">
        <select name="hostel_room"  class="selectpicker" data-style="form-control" data-live-search="true" style="width:100%;" onclick="get_hostel_student()" id="hostel_room"  required="required" data-validate="required" data-message-required ="<?php echo get_phrase('please_select_floor'); ?>">
            <option value=""><?php echo get_phrase('select_floor_first'); ?></option>
        </select>
    </div>

</div>
<div class="form-group">
    <label><?php echo get_phrase('student'); ?><span class="error" style="color: red;"> *</span></label>
    <div class="col-sm-6">
        <select name="hostel_student"  class="selectpicker" data-style="form-control" data-live-search="true" style="width:100%;" onclick="get_student_information()" id="hostel_student"  required="required" data-validate="required" data-message-required ="<?php echo get_phrase('select_room_first'); ?>">            <option value=""><?php echo get_phrase('select_room_first'); ?></option>
        </select>
    </div>
</div>

<span id="student_information"></span>



<script type="text/javascript">
    function get_hostel_name() {
        var type = $("#type option:selected").val();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_hostel_name/' + type,
            success: function (response)
            {

                jQuery('#hostel_name').html(response).selectpicker('refresh');
            }
        });
    }
    function get_floor_name() {
        var hostel_id = $("#hostel_name option:selected").val();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_floor_name/' + hostel_id,
            success: function (response)
            {

                jQuery('#floor').html(response).selectpicker('refresh');
            }
        });
    }
    function get_hostel_room() {
        var hostel_id = $("#hostel_name option:selected").val();
            var floor = $("#floor option:selected").val();
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?ajax_controller/get_hostel_room/' + floor + '/' + hostel_id,
                success: function (response)
            {

                jQuery('#hostel_room').html(response).selectpicker('refresh');
            }
        });
    }
    function get_hostel_student() {
        var type        =   $("#type option:selected").val();
        var floor       =   $("#floor option:selected").val();
        var hostel_id   =   $("#hostel_name option:selected").val();       
        var hostel_room =   $("#hostel_room option:selected").val();
        
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?ajax_controller/get_hostel_students/' + type + '/' + floor + '/' + hostel_id + '/' + hostel_room,
                success: function (response)
            {

                jQuery('#hostel_student').html(response).selectpicker('refresh');
            }
        });
    }
    function get_student_information(){
        var student_id        =   $("#hostel_student option:selected").val();
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?ajax_controller/get_student_information/' + student_id ,
                success: function (response)
            {
                jQuery('#student_information').html(response).selectpicker('refresh');
            }
        });
    }
</script>