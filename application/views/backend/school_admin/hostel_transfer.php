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
        <div class="white-box"  data-step="5" data-intro="<?php echo get_phrase('Fill this form to manage and transfer hostel.');?>" data-position='top'>
            <?php echo form_open(base_url() . 'index.php?school_admin/hostel_transfer/' . $student_id . "/" . $exsiting_room_no . "/" . $hostel_reg_id, array('class' => 'form-groups-bordered validate', 'target' => '_top')); ?> 
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="field-1"><?php echo get_phrase("user_type"); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="ti-user"></i></div>                  
                        <input type="text" class="form-control" name="user_type" value="<?php echo get_phrase('student'); ?>" disabled="disabled">
                    </div> 
                </div>

                <div class="col-md-6 form-group">
                    <label for="field-1"><?php echo get_phrase("student"); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="ti-user"></i></div>                  
                        <input type="text" class="form-control" name="student_name" value="<?php
                        foreach ($student_name as $row) {
                            echo $row['name'];
                        }
                        ?>" disabled="disabled">
                    </div> 
                </div>
            </div>
            <div class="row">
<!--                <div class="col-md-6 form-group">
                    <label for="field-1"><?php echo get_phrase("hostel_type"); ?><span class="error mandatory"> *</span></label>
                    <select name="type"  class="selectpicker" data-style="form-control" data-live-search="true" id="type"
                            required="required" data-validate="required">
                        <option value="">Select</option>
                        <option value="Girls">Girls</option>
                        <option value="Boys">Boys</option>
                    </select> 
                </div>-->
<?php // pre($hostel_list);?>
 <?php // foreach($hostel_list as $row): 
//pre($row); echo "sucess"; die;
// endforeach; ?>
<input type="hidden" name="type" value="<?php if(!empty($hostel_list)) echo $hostel_list[0]['hostel_type']; ?>">
                <div class="col-md-6 form-group">
                    <label for="field-1"><?php echo get_phrase("hostel_name"); ?><span class="error mandatory"> *</span></label>
                    <select name="hostel_name" class="selectpicker" data-style="form-control" data-live-search="true" id="hostel_name"
                            required="required" data-validate="required" data-message-required ="<?php echo get_phrase('please_select_type'); ?>">
                        <option value=""><?php echo get_phrase('select_hostel_type_first'); ?></option>
                        <?php foreach($hostel_list as $row): ?>
                        <option value="<?php echo $row['dormitory_id']; ?>"><?php echo $row['name']; ?></option>
                       <?php endforeach; ?>
                    </select>
                </div>
            
                <div class="col-md-6 form-group">
                    <label for="field-1"><?php echo get_phrase("floor_name"); ?><span class="error mandatory"> *</span></label>
                    <select name="floor" class="selectpicker" data-style="form-control" data-live-search="true" id="floor"
                            required="required" data-validate="required" data-message-required ="<?php echo get_phrase('please_select_hostel_name'); ?>">
                        <option value=""><?php echo get_phrase('select_hostel_name_first'); ?></option>
                    </select>
                </div>
                </div>
            <div class="row">
                <div class="col-xs-12 col-md-12 form-group">  
                    <div id="details"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="field-1"><?php echo get_phrase("room_no"); ?><span class="error mandatory"> *</span></label>
                    <select name="hostel_room" class="selectpicker" data-style="form-control" data-live-search="true"  id="hostel_room"
                            required="required" data-validate="required" data-message-required ="<?php echo get_phrase('please_select_floor'); ?>">
                        <option value=""><?php echo get_phrase('select_floor_first'); ?></option>
                    </select>
                </div>
            <div class="col-md-6 form-group">
                    <label for="field-1"><?php echo get_phrase("transfer_date"); ?><span class="error mandatory"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>                  
                        <input id= "transfer_date" type="text" class="form-control datepicker"  name="transfer_date" placeholder="Pick a date" data-validate="required" data-message-required ="Please pick a date">
                    </div> 
                </div>
               
                <div class="">
                <div class="col-md-6 form-group">
                    <label for="field-1"><?php echo get_phrase("vacating_date"); ?><span class="error mandatory"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>                  
                        <input id= "vacating_date" type="text" class="form-control datepicker"  name="vacating_date" placeholder="Pick a date" data-validate="required" data-message-required ="Please pick a date">
                    </div> 
                </div>
                <div class="col-md-6 form-group m-t-20">
                    <label for="field-1"><?php echo get_phrase("food"); ?><span class="error mandatory"> *</span></label>
                    <label class="radio-inline">
                        <input type="radio" name="food" value="yes" required ><?php echo get_phrase('yes'); ?>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="food" value="no" required ><?php echo get_phrase('no'); ?>
                    </label> 
                </div>
            </div>
                 
            <div class="text-right">
                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="6" data-intro="<?php echo get_phrase('On the click of this button you can submit the form.');?>" data-position='left'><?php echo get_phrase('Submit'); ?></button>

            </div>

            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#transfer_date').datepicker({
            format: "dd-mm-yyyy"
        });

        $('#vacating_date').datepicker({
            format: "dd-mm-yyyy"
        });

    });

//    $('#type').change(get_hostel_name);
//    function get_hostel_name() {
//        var type = $("#type option:selected").val();
//        $.ajax({
//            url: '<?php echo base_url(); ?>index.php?school_admin/get_hostel_name/' + type,
//            success: function (response)
//            {
//
//                jQuery('#hostel_name').html(response).selectpicker('refresh');
//            } 
//        });
//    }

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
        var floor = $("#floor option:selected").val();
        var hostel_id = $("#hostel_name option:selected").val();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_hostel_room/' + floor + '/' + hostel_id,
            success: function (response)
            {

                jQuery('#hostel_room').html(response).selectpicker('refresh');
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
</script>




