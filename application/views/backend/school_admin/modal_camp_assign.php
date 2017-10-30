    <?php echo form_open(base_url() . 'index.php?school_admin/camp_assign_to_student/create', array('class' => 'form-horizontal form-material form-groups-bordered validate', 'enctype' => 'multipart/form-data')); ?>
    <div class="form-group">
                    <div class="col-md-6 m-b-20">
                        <label for="field-1"><?php echo get_phrase('class');?><span class="error mandatory"> *</span></label>
                        <select name="class_id" class="selectpicker1" data-style="form-control" data-live-search="true" required="required" onchange="return onclasschange(this);" id="class_holder">
                    <option value="">Select Class</option>
                      <?php
                    foreach ($classes as $row): ?>
                    <option value="<?php echo $row['class_id']; ?>"><?php echo $row['name']; ?></option>
                    <?php endforeach; ?>
                        </select>
                    </div>
          <div class="col-md-6 m-b-20">
                        <label for="field-1"><?php echo get_phrase('section');?><span class="error mandatory"> *</span></label>
                        <select name="section_id" class="selectpicker1" data-style="form-control" data-live-search="true" required="required" id="section" onchange="return onsectionchange(this.value);">
                            <option value="">Select Section</option>
                        </select>
                    </div>
          <div class="col-md-6 m-b-20">
                        <label for="field-1"><?php echo get_phrase('student');?><span class="error mandatory"> *</span></label>
                        <select name="student_id[]" class="selectpicker1" required="required" multiple data-style="form-control" data-live-search="true" data-actions-box="true" id="student_holder">
                            <option value=""> Select Student </option>                            
                        </select>
                    </div>
            <div class="col-md-6 m-b-20">
            <label><?php echo get_phrase('camp_type'); ?></label>
            <select name="camp_type" class="selectpicker1" id="camp_type_holder" data-style="form-control" data-live-search="true" required="required" required="required"> 
            <option value="">Select Camp</option>                      
            </select>
        </div>
        <div class="col-md-12 m-b-20 text-right">
            <button class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('assign'); ?>
            </button>
         </div>
    </div>

     <?php echo form_close(); ?>
</from> 
<script type="text/javascript">
    $(function () {
        $('#datepicker').datepicker();
    });
 
    function onclasschange(class_id){        
    jQuery('#section').html('<option value="">Select Section</option>');
    $.ajax({
            url: '<?php echo base_url();?>index.php?school_admin/get_section_by_class/' + class_id.value,
            success: function (response)
            {
                jQuery('#section').append(response).selectpicker('refresh');                
                //$('#section').trigger("chosen:updated");
            }
        });           
        jQuery('#camp_type_holder').html('<option value="">Select Camp</option>');
    $.ajax({
            url: '<?php echo base_url();?>index.php?school_admin/get_camp_byclass/' + class_id.value,
            success: function (response)
            { 
                jQuery('#camp_type_holder').append(response).selectpicker('refresh');                
                //$('#section').trigger("chosen:updated");
            }
        });           
    }
    
  function onsectionchange(section_id){
        var class_id = $('#class_holder').val();
//        jQuery('#student_holder').html('<option value="">Select Student</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>/index.php?school_admin/get_student/' + section_id + '/' + class_id,
            success: function (response)
            { 
                jQuery('#student_holder').append(response).selectpicker('refresh');
            }
        });
        $('#student_holder').trigger("chosen:updated");
    }
    
</script>