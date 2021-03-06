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
            <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('dashboard'); ?></a></li>
            <li><?php echo get_phrase('disciplinary'); ?>
                <ul>                    
                    <li><a href="<?php echo base_url(); ?>index.php?disciplinary/my_incident"><?php echo get_phrase('my_incident'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?disciplinary/manage_incident"><?php echo get_phrase('all_incident'); ?></a></li>
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
        <div class="white-box" data-step="5" data-intro="You can create a new incident from here." data-position='top'>
            <?php echo form_open(base_url() . 'index.php?disciplinary/add_incident/create', array('class' => 'validate', 'target' => '_top')); ?> 
            <div class="row">
                <div class="col-md-6 form-group">
                 <label for="field-1">
                        <?php echo get_phrase('violation_type'); ?><span class="error mandatory"> *</span>
                    </label>
                    <select name="violation_type" id="violation_type" data-style="form-control" data-live-search="true" class="selectpicker"
                            required="required" data-validate="required" data-message-required ="Please select a class">
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
                    <select name="class_id" id="class_id" data-style="form-control" data-live-search="true" class="selectpicker"
                            required="required" data-validate="required" data-message-required ="Please select a class" onchange="return onclasschange(this);">
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
                    <select name="section" data-style="form-control" data-live-search="true" class="selectpicker" id="section_holder"  required="required" data-validate="required" data-message-required ="<?php echo get_phrase('please_select_section'); ?>" onchange="return onsectionchange(this);">
                        <option value=""><?php echo get_phrase('select_section'); ?></option>
                    </select> 
                </div>
                 <div class="col-md-6 form-group">
                    <label for="field-1"> <?php echo get_phrase('student'); ?><span class="error mandatory"> *</span>
                    </label>
                    <select name="student_id" data-style="form-control" data-live-search="true" class="selectpicker" id="student_selection_holder"
                            required="required" data-validate="required" data-message-required ="<?php echo get_phrase('please_select_name'); ?>" >
                        <option value=""><?php echo get_phrase('select_class_and_section_first'); ?></option>
                    </select>
                </div>
                <div class="col-md-6 form-group">
                    <label for="field-1"> <?php echo get_phrase('parent_appeal'); ?><span class="error mandatory"> *</span></label><br>
                    <label class="form-check-label"><input class="form-check-input" type="radio" name="parent_appeal" id="parent_appeal_yes" required="required" value="yes"><?php echo "Yes"; ?></label>
                    <label class="form-check-label"><input class="form-check-input" type="radio" name="parent_appeal" id="parent_appeal_no" required="required" value="no"><?php echo "No"; ?></label>
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
                    <label for="field-1"><?php echo get_phrase("verdict"); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-sliders"></i></div>                  
                        <input type="text" class="form-control" id="verdict" name="verdict" value="<?php echo set_value('verdict') ?>" placeholder="Verdict">
                    </div> 
                </div>
                <div class="col-md-6 form-group">
                    <label for="field-1">
                        <?php echo get_phrase('reporting_teacher'); ?><span class="error mandatory"> *</span>
                    </label>
                    <select name="reporting_teacher" id="reporting_teacher" data-style="form-control" data-live-search="true" class="selectpicker"
                            required="required" data-validate="required" data-message-required ="Please select a reporting_teacher">
                        <option value=""><?php echo get_phrase('select_reporting_teacher'); ?></option>
                        <?php
                        foreach ($teachers as $row):
                            ?>
                            <option value="<?php echo $row['teacher_id']; ?>"><?php echo $row['name']." ".$row['last_name']; ?></option>
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
                        <input id= "date_of_occurrence" type="text" class="form-control mydatepicker"  name="date_of_occurrence" placeholder="Pick a date" required="required" data-validate="required" data-message-required ="Please pick a date">
                    </div> 
                </div>
                <div class="col-md-6 form-group">
                     <label for="field-1"><?php echo get_phrase("expiry_date"); ?><span class="mandatory"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="icon-calender"></i></div>
                        <input id= "expiry_date" type="text" class="form-control mydatepicker"  name="expiry_date" placeholder="Pick a date" required="required" data-validate="required" data-message-required ="Please pick a date">
                    </div> 
                </div>
                <div class="col-md-12 form-group text-center">
                <input type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" value="Create Incident" data-step="6" data-intro="You can create incident from here." data-position='left'/>
            </div>
            </div>              
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
   
    function onclasschange(class_id)
{
    jQuery('#section_holder').html('<option value="">Select Section</option>');
    $.ajax({
            url: '<?php echo base_url();?>index.php?teacher/get_teacher_section/' + class_id.value,
            success: function (response)
            {
                jQuery('#section_holder').append(response).selectpicker('refresh');
            }
        });
           $('#section_holder').trigger("chosen:updated");           
}

function onsectionchange(section_id)
    {        
        var class_id = $('#class_id').val();
        $.ajax({
            url: '<?php echo base_url(); ?>/index.php?teacher/get_teacher_student/' + section_id.value + '/' + class_id,
            success: function (response)
            { 
                jQuery('#student_selection_holder').append(response).selectpicker('refresh');
            }
        });
//        $('#student_selection_holder').trigger("chosen:updated");
    }
</script>

    <script type="text/javascript">
    $(document).ready(function () {
        $("#parent_statement_display").hide();
	$("#parent_appeal_yes").click(function () {
		$("#parent_statement_display").show();
	});
	$("#parent_appeal_no").click(function () {
		$("#parent_statement_display").hide();
	});
    });
    </script>