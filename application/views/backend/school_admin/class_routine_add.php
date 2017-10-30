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
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/class_routine_views/"><?php echo get_phrase('class_routine'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<?php if ($this->session->flashdata('flash_message_error')) { ?>        
    <div class="alert alert-danger">
        <?php echo $this->session->flashdata('flash_message_error'); ?>
    </div>
<?php } ?>


<div class="col-md-12 white-box" data-step="5" data-intro="<?php echo get_phrase('Here you can add the class timetable.');?>" data-position='top'>

    <?php echo form_open(base_url() . 'index.php?school_admin/class_routine/create', array('class' => 'form-groups validate', 'target' => '_top')); ?>
    <div class="col-md-6 form-group">
        <label class="control-label"><?php echo get_phrase('class'); ?><span class="error mandatory"> *</span></label>

        <select name="class_id" class="selectpicker" data-style="form-control" data-live-search="true" id="class_id" required="required">
            <option value=" "><?php echo get_phrase('select_class'); ?> </option>
            <?php
            foreach ($classes as $row):
                ?>
                <option value="<?php echo $row['class_id']; ?>"><?php echo $row['name']; ?></option>
                <?php
            endforeach;
            ?>
        </select>

    </div>

    <div id="section_subject_selection_holder"> </div>

    <div class="col-md-6 form-group">
        <label class="control-label">
            <?php echo get_phrase('day'); ?><span class="error mandatory"> *</span>
        </label>

        <select name="day" class="selectpicker" data-style="form-control" data-live-search="true" required="required">
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

    <div class="form-group col-md-6">
        <label class="control-label">
            <?php echo get_phrase('starting_time'); ?> <span class="error mandatory"> *</span>
        </label>
        <div>
            <div class="col-md-4 go_start p-l-0">
                <select name="time_start" class="selectpicker" data-style="form-control" data-live-search="true" required="required">
                    <option value=""><?php echo get_phrase('hour'); ?></option>                            
                    <?php for ($i = 1; $i <= 9; $i++): ?>
                        <option value="<?php echo $i; ?>"><?php echo "0" . $i; ?></option>                                                              
                    <?php endfor; ?>
                    <?php for ($i = 10; $i <= 12; $i++): ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>                                                              
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-4 go_start">
                <select name="time_start_min" class="selectpicker" data-style="form-control" data-live-search="true" required="required">
                    <option value=""><?php echo get_phrase('minutes'); ?></option>
                    <?php for ($i = 0; $i <= 1; $i++): ?>
                        <option value="<?php echo $i * 5; ?>"><?php echo "0" . $i * 5; ?></option>
                    <?php endfor; ?>
                    <?php for ($i = 2; $i <= 11; $i++): ?>
                        <option value="<?php echo $i * 5; ?>"><?php echo $i * 5; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-4 go_start p-r-0">
                <select name="starting_ampm" class="selectpicker" data-style="form-control" data-live-search="true" required="required">
                    <option value="1">am</option>
                    <option value="2">pm</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group col-md-6">
        <label class="control-label"><?php echo get_phrase('ending_time'); ?><span class="error mandatory"> *</span></label>
        <div>
            <div class="col-md-4 go_start p-l-0">
                <select name="time_end" class="selectpicker" data-style="form-control" data-live-search="true" required="required">
                    <option value=""><?php echo get_phrase('hour'); ?></option>
                    <?php for ($i = 1; $i <= 9; $i++): ?>
                        <option value="<?php echo $i; ?>"><?php echo "0" . $i; ?></option>                                                              
                    <?php endfor; ?>
                    <?php for ($i = 10; $i <= 12; $i++): ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>                                                              
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-4 go_start">
                <select name="time_end_min" class="selectpicker" data-style="form-control" required="required">
                    <option value=""><?php echo get_phrase('minutes'); ?></option>  
                    <?php for ($i = 0; $i <= 1; $i++): ?>
                        <option value="<?php echo $i * 5; ?>"><?php echo "0" . $i * 5; ?></option>
                    <?php endfor; ?>
                    <?php for ($i = 2; $i <= 11; $i++): ?>
                        <option value="<?php echo $i * 5; ?>"><?php echo $i * 5; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-4 go_start p-r-0">
                <select name="ending_ampm" class="selectpicker" data-style="form-control" data-live-search="true" required="required">
                    <option value="1">am</option>
                    <option value="2">pm</option>
                </select>
            </div>
        </div>
    </div>

    <div class="text-right col-xs-12">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d m-t-10" data-step="7" data-intro="<?php echo get_phrase('On the click of this button, timetable for particular class will be added.');?>" data-position='left'>
            <?php echo get_phrase('add_class_timetable'); ?></button>
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
                jQuery('#section_subject_selection_holder').html(response);
            }
        });
    }
</script>