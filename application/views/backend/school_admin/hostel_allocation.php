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
<?php if ($this->session->flashdata('flash_validation_error')) { ?>        
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('flash_validation_error'); ?>
            </div>
        <?php } ?>
<div class="row">
    <div class="col-md-12">
        <div class="white-box" data-step="5" data-intro="<?php echo get_phrase('This is the form of hostel registration.');?>" data-position='top'>

            <?php echo form_open(base_url() . 'index.php?school_admin/hostel_registration/create', array('class' => 'form-groups-bordered  validate', 'target' => '_top','id'=>'hostel_registration')); ?> 

            <div class="row">
                 <div class="col-xs-12 col-md-6 form-group">
                    <label for="field-1">
                        <?php echo get_phrase('class'); ?><span class="error mandatory"> *</span>
                    </label>
                    <select name="class_id" id="class_id" class="selectpicker" data-style="form-control" data-live-search="true"
                            required="required" data-validate="required" data-message-required ="Please select a class">
                        <option value=""><?php echo get_phrase('select_class'); ?></option>
                        <?php
                        foreach ($classes as $row):
                            ?>
                            <option value="<?php echo $row['class_id']; ?>"><?php echo $row['name']; ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>
                <div class="col-xs-12 col-md-6 form-group">
                    <label for="field-1">
                        <?php echo get_phrase('section'); ?><span class="error mandatory"> *</span>
                    </label>
                    <select name="section" class="selectpicker" data-style="form-control" data-live-search="true" id="section"  required="required" data-validate="required" data-message-required ="<?php echo get_phrase('please_select_section'); ?>">
                        <option value=""><?php echo get_phrase('select_section'); ?></option>
                    </select> 
                </div>
            </div>

            <div class="row">         
                

                <div class="col-xs-12 col-md-6 form-group">
                    <label for="field-1"> <?php echo get_phrase('student'); ?><span class="error mandatory"> *</span>
                    </label>
                    <select name="student_id" class="selectpicker" data-style="form-control" data-live-search="true" id="student_selection_holder"
                            required="required" data-validate="required" data-message-required ="<?php echo get_phrase('please_select_name'); ?>" onchange="get_student_dormatory(this.value)">
                        <option value=""><?php echo get_phrase('select_class_and_section_first'); ?></option>
                    </select>
                </div>
                <div class="col-xs-12 col-md-6 form-group">
                    <label for="field-1"> <?php echo get_phrase('hostel_name'); ?><span class="error mandatory"> *</span>
                    </label> 
                    <select name="hostel_name" class="selectpicker" data-style="form-control" data-live-search="true"  id="hostel_name"
                            required="required" data-validate="required" data-message-required ="<?php echo get_phrase('please_select_type'); ?>">
                        <option value=""><?php echo get_phrase('select_student_first'); ?></option>
                    </select>
                </div>
            </div> 

            <div class="row">   
                <input type="hidden" name="type" id="type" />
                <!--                <div class="col-xs-12 col-md-6 form-group">
                                    <label for="field-1"> <?php echo get_phrase('hostel_type'); ?><span class="error mandatory"> *</span>
                                    </label>
                                    <select name="type" class="selectpicker" data-style="form-control"  id="type"
                                            required="required" data-validate="required">
                                        <option value="">Select</option>
                                        <option value="Girls">Girls</option>
                                        <option value="Boys">Boys</option>
                                    </select>                 
                                </div>-->

                
                <div class="col-xs-12 col-md-6 form-group">
                    <label for="field-1"> <?php echo get_phrase('floor_name'); ?><span class="error mandatory"> *</span>
                    </label> 
                    <select name="floor" class="selectpicker" data-style="form-control" data-live-search="true" id="floor"
                             data-validate="required" data-message-required ="<?php echo get_phrase('please_select_hostel_name'); ?>">
                        <option value=""><?php echo get_phrase('select_hostel_name_first'); ?></option>
                    </select>
                </div>
                <div class="col-xs-12 col-md-6 form-group form-group">
                <label for="field-1"> <?php echo get_phrase('food'); ?><span class="error mandatory"> *</span>
                    <div class="">
                        <input type="radio" name="food" value="yes">
                        <label for="radio14" class="m-r-10"><?php echo get_phrase('yes'); ?> </label>

                        <input type="radio" name="food" value="no"  >
                        <label for="radio14"><?php echo get_phrase('no'); ?> </label>
                    </div>
            </div>
            </div>
            <div id="ajax_hostel_room_view" class="row">
                
                </div>
            
           


            <div class="text-right">
                <input  type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" value="Submit" data-step="6" data-intro="<?php echo get_phrase('On the click of submit button you can submit your form.');?>" data-position='left'/>                                
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
   
    $('#section').change(get_class_students);
    function get_class_students() {
        var section_id = $(this).val();
        var class_id = $("#class_id option:selected").val();

        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_available_students_for_hostel/' + class_id + '/' + section_id,
            success: function (response)
            {
                jQuery('#student_selection_holder').html(response).selectpicker('refresh');
            }
        });
    }
    $('#class_id').change(select_section);
    function select_section() {
        var class_id = $(this).val();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_class_section/' + class_id,
            success: function (response)
            {

                jQuery('#section').html(response).selectpicker('refresh');
            }
        });
    }

    $('#student_selection_holder').change(get_hostel_name);
    function get_hostel_name() {
        //var type = $("#type option:selected").val();
        var student = $("#student_selection_holder option:selected").val();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_hostel_name_by_student/' + student,
            success: function (response)
            {
                var arr = response.split("||||");
                $('#type').val(arr[0]);
                jQuery('#hostel_name').html(arr[1]).selectpicker('refresh');
            }
        });
    }

    $('#hostel_name').change(get_floor_name);
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

    $('#floor').change(get_hostel_room);
    function get_hostel_room() {
        var hostel_id = $("#hostel_name option:selected").val();
        var floor = $("#floor option:selected").val();
		$('body').loading('start');
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_hostel_room_with_beds/' + floor + '/' + hostel_id,
            success: function (response)
            {
               
                jQuery('#ajax_hostel_room_view').html(response)
                $('body').loading('stop');
				/*var splitArr = response.split('||**||');
                jQuery('#hostel_room').html(splitArr[1]).selectpicker('refresh');
                if(splitArr[0] == 1){
                    $('#no_bed_error').removeClass('hide');
                } else {
                    $('#no_bed_error').addClass('hide');
                }*/
            }
        });
    }

    $('#hostel_room').change(display_details);
    function display_details() {
        var room_no = $("#hostel_room option:selected").val();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_details/' + room_no,
            success: function (response)
            {
                jQuery('#details').html(response).selectpicker('refresh');
            }
        });
    }


    function get_student_dormatory(StudentId) {
        if (StudentId) {
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?school_admin/get_student_dormatory/' + StudentId,
                success: function (response) {
                    var hostel = '<option value="">Select Hostel</option>';
                    if (response != 'no') {
                        var data = JSON.parse(response);
                        if (data.hostel_type_data.length) {
                            var hostel_type = data.hostel_type_data[0].hostel_type;
                            for (k in data.hostel_type_data) {
                                hostel += '<option value="' + data.hostel_type_data[k].dormitory_id + '">' + data.hostel_type_data[k].name + '</option>';
                            }
                            jQuery('#hostel_name').html(hostel).selectpicker('refresh');
                            $("#hostel_name").val(data.dormitory_id);
                            $("#type").val(hostel_type);
                        }
                    }
                }
            });
        }
    }
</script>


