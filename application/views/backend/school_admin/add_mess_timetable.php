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

<?php if ($this->session->flashdata('flash_message_error')) { ?>        
    <div class="alert alert-danger">
        <?php echo $this->session->flashdata('flash_message_error'); ?>
    </div>
<?php } ?>


<div class="col-md-12 white-box" data-step="5" data-intro="<?php echo get_phrase('Here you can add the mess timetable.');?>" data-position='top'>

    <?php echo form_open(base_url() . 'index.php?school_admin/add_mess_time_table/create', array('class' => 'form-groups validate', 'target' => '_top')); ?>
    <div class="col-md-6 form-group">
        <label class="control-label"><?php echo get_phrase('mess_name'); ?><span class="error mandatory"> *</span></label>

        <select name="mess_id" class="form-control" data-style="form-control" data-live-search="true"  required="required">
            <option value=""><?php echo get_phrase('select_mess_name'); ?> </option>
            <?php
            foreach ($mess_name as $row):
                ?>
                <option value="<?php echo $row['mess_management_id']; ?>"><?php echo $row['name']; ?></option>
                <?php
            endforeach;
            ?>
        </select>

    </div>
    <div class="col-md-6 form-group">
        <label class="control-label">
            <?php echo get_phrase('day'); ?><span class="error mandatory"> *</span>
        </label>

        <select name="day"  class="selectpicker" data-style="form-control" data-live-search="true" required="required">
            <option value="">Choose a day</option>
            <option value="sunday">Sunday</option>
            <option value="monday">Monday</option>
            <option value="tuesday">Tuesday</option>
            <option value="wednesday">Wednesday</option>
            <option value="thursday">Thursday</option>
            <option value="friday">Friday</option>
            <option value="saturday">Saturday</option>
        </select>

    </div>

    <div class="col-md-6 form-group">
        <label class="control-label">
            <?php echo get_phrase('type'); ?><span class="error mandatory"> *</span>
        </label>

        <select name="type"  class="selectpicker" data-style="form-control" data-live-search="true" required="required">
            <option value=""><?php echo get_phrase("select_type");?></option>
            <option value="breakfast"><?php echo get_phrase("breakfast");?></option>
            <option value="lunch"><?php echo get_phrase("lunch");?></option>
            <option value="evening_snacks"><?php echo get_phrase("evening_snacks");?></option>
            <option value="dinner"><?php echo get_phrase("dinner");?></option>
        </select>

    </div>
     <div class="col-md-6 form-group">
        <label class="control-label">
            <?php echo get_phrase('food'); ?><span class="error mandatory"> *</span>
        </label>
         <input type="text" class="form-control" required="required" name="food" placeholder="<?php echo get_phrase('name_of_food'); ?>" > 
    </div>
   
    <div class="text-right col-xs-12">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d m-t-10" data-step="6" data-intro="<?php echo get_phrase('On the click of this button, timetable for particular class will be added.');?>" data-position='left'>
            <?php echo get_phrase('add_timetable'); ?></button>
    </div>

    <?php echo form_close(); ?>

</div>


<script type="text/javascript">
    $('#class_id').change(get_class_section_subject);   
    function get_class_section_subject() {
        var class_id = $(this).val();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_class_section_subject/' + class_id,
            success: function (response)
            {
                jQuery('#section_subject_selection_holder').html(response).selectpicker('refresh');
            }
        });
    }
</script>