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
            <li><?php echo get_phrase('disciplinary'); ?>
                <ul>                    
                    <li><a href="<?php echo base_url(); ?>index.php?disciplinary/manage_violation_types"><?php echo get_phrase('Violation Type'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?disciplinary/manage_incident"><?php echo get_phrase('All Incidents'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?disciplinary/my_incident"><?php echo get_phrase('My Incidents'); ?></a></li>
                </ul>
            </li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<?php     
if($this->session->flashdata('flash_message_error')) {?>        
<div class="alert alert-danger">
<?php echo $this->session->flashdata('flash_message_error'); ?>
</div>
<?php } ?>

<div class="row">
    <div class="col-md-12">
        <div class="white-box" data-step="5" data-intro="<?php echo get_phrase('You can add a new incident from here.');?>" data-position='top'>
            <?php echo form_open(base_url() . 'index.php?disciplinary/add_incident/create', array('class' => 'form-groups-bordered  validate', 'target' => '_top')); ?> 
            <div class="row">
                <div class="col-md-6 form-group">
                 <label for="field-1">
                        <?php echo get_phrase('violation_type'); ?><span class="error mandatory"> *</span>
                    </label>
                    <select name="violation_type" id="violation_type"  class="selectpicker" data-style="form-control" data-live-search="true" required="required" data-validate="required" data-message-required ="Please select a class">
                        <option value=""><?php echo get_phrase('select_violation_type'); ?></option>
                        <?php
                        foreach ($violation as $value):
                            ?>
                            <option value="<?php echo $value['violation_type_id']; ?>"><?php echo $value['type']; ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>
                <div class="col-md-6 form-group">
                   <label for="field-1">
                        <?php echo get_phrase('class'); ?><span class="error mandatory"> *</span>
                    </label>
                    <select name="class_id" id="class_id"  class="selectpicker" data-style="form-control" data-live-search="true"
                            required="required" data-validate="required" data-message-required ="Please select a class">
                        <option value=""><?php echo get_phrase('select_class'); ?></option>
                        <?php
                        foreach ($classes as $row):
                            ?>
                            <option value="<?php echo $row['class_id']; ?>"><?php echo $row['name']; ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>
                <div class="col-md-6 form-group">
                    <label for="field-1">
                        <?php echo get_phrase('section'); ?><span class="error mandatory"> *</span>
                    </label>
                    <select name="section"  class="selectpicker" data-style="form-control" data-live-search="true" id="section"  required="required" data-validate="required" data-message-required ="<?php echo get_phrase('please_select_section'); ?>">
                        <option value=""><?php echo get_phrase('select_section'); ?></option>
                    </select> 
                </div>
                 <div class="col-md-6 form-group">
                    <label for="field-1"> <?php echo get_phrase('student'); ?><span class="error mandatory"> *</span>
                    </label>
                    <select name="student_id"  class="selectpicker" data-style="form-control" data-live-search="true" id="student_selection_holder"
                            required="required" data-validate="required" data-message-required ="<?php echo get_phrase('please_select_name'); ?>" onchange="get_student_dormatory(this.value)">
                        <option value=""><?php echo get_phrase('select_class_and_section_first'); ?></option>
                    </select>
                </div>
                <div class="col-md-6 form-group">
                    <label for="field-1"> <?php echo get_phrase('parent_appeal'); ?><span class="error mandatory"> *</span></label><br>
                    <label class="form-check-label"><input class="form-check-input" type="radio" id="parent_appeal_yes" name="parent_appeal" required="required" value="yes"><?php echo "Yes"; ?></label>
                    <label class="form-check-label"><input class="form-check-input" type="radio" id="parent_appeal_no" name="parent_appeal" required="required" value="no"><?php echo "No"; ?></label>
                </div>
                <div class="col-md-6 form-group" id="parent_statement_display">
                    <label for="field-1"><?php echo get_phrase("parent_statement"); ?><span class="mandatory"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-sliders"></i></div>                  
                        <input type="text" class="form-control" id="parent_statement" name="parent_statement" value="<?php echo set_value('parent_statement') ?>" placeholder="Parent Statement" data-validate="required" data-message-required ="<?php echo get_phrase('plesae_enter_the_parent_statement'); ?>">
                        <span class="mandantory"> <?php echo form_error('parent_statement'); ?></span>
                    </div> 
                </div>
                <div class="col-md-6 form-group">
                    <label for="field-1"><?php echo get_phrase("verdict"); ?><span class="mandatory"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-sliders"></i></div>                  
                        <input type="text" class="form-control" id="verdict" required="required" name="verdict" value="<?php echo set_value('verdict') ?>" placeholder="Verdict" data-validate="required" data-message-required ="<?php echo get_phrase('plesae_enter_the_verdict'); ?>">
                        <span class="mandantory"> <?php echo form_error('verdict'); ?></span>
                    </div> 
                </div>
                <div class="col-md-6 form-group">
                    <label for="field-1">
                        <?php echo get_phrase('reporting_teacher'); ?><span class="error mandatory"> *</span>
                    </label>
                    <select name="reporting_teacher" id="reporting_teacher"  class="selectpicker" data-style="form-control" data-live-search="true"
                            required="required" data-validate="required" data-message-required ="Please select a reporting_teacher">
                        <option value=""><?php echo get_phrase('select_reporting_teacher'); ?></option>
                        <?php
                        foreach ($teachers as $row):
                            ?>
                            <option value="<?php echo $row['teacher_id']; ?>"><?php echo $row['name']; ?></option>
                        <?php endforeach; ?>

                    </select> 
                </div>
                <div class="col-md-6 form-group">
                    <label for="field-1"><?php echo get_phrase("corrective_action"); ?><span class="mandatory"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-sliders"></i></div>                  
                        <input type="text" class="form-control" id="corrective_action" required="required" name="corrective_action" value="<?php echo set_value('corrective_action') ?>" placeholder="Corrective Action" data-validate="required" data-message-required ="<?php echo get_phrase('plesae_enter_the_corrective_action'); ?>">
                        <span class="mandantory"> <?php echo form_error('corrective_action'); ?></span>
                    </div> 
                </div>
                <div class="col-md-6 form-group">
                     <label for="field-1"><?php echo get_phrase("date_of_occurrence"); ?><span class="mandatory"> *</span></label>
                   
                     <div class="input-group">
                        <div class="input-group-addon"><i class="icon-calender"></i></div>
                        <input id="date_of_occurrence" type="text" class="form-control mydatepicker"  name="date_of_occurrence" placeholder="Pick a date" required="required" data-validate="required" data-message-required ="Please pick a date">
                    </div>
                </div>
                <div class="col-md-6 form-group">
                     <label for="field-1"><?php echo get_phrase("expiry_date"); ?><span class="mandatory"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="icon-calender"></i></div>
                        <input id="expiry_date" type="text" class="form-control mydatepicker"  name="expiry_date" placeholder="Pick a date" required="required" data-validate="required" data-message-required ="Please pick a date">
                    </div> 
                </div>
                
                <div class="col-md-12 form-group text-right">
                <input type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" value="Add Incident" data-step="6" data-intro="<?php echo get_phrase('You can submit from here.');?>" data-position='left'/>
            </div>
            </div>
              
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<script>
    $('#section').change(get_class_students);
    function get_class_students() {
        var section_id = $(this).val();
        var class_id = $("#class_id option:selected").val();

        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_students/' + class_id + '/' + section_id,
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
       $(document).ready(function () {

        $('#date_of_occurrence').datepicker({
            format: "dd-mm-yyyy"
        }).on('change', function () {
            $('.datepicker').hide();
        });

        $('#expiry_date').datepicker({
            format: "dd-mm-yyyy"
        }).on('change', function () {
            $('.datepicker').hide();
        });
        $("#parent_statement_display").hide();
	$("#parent_appeal_yes").click(function () {
		$("#parent_statement_display").show();
	});
	$("#parent_appeal_no").click(function () {
		$("#parent_statement_display").hide();
	});
    });
</script>