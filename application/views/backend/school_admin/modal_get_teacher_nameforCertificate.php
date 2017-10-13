<?php if($certificate_type == 'ex'){
    $method = "experience_certificate";
}elseif($certificate_type == 'download'){
    $method = "teacher_certificates/download";
}else{
    $method = "internship_certificate";
}  ?>
      <?php echo form_open(base_url() . 'index.php?school_admin/'.$method.'/', array('class' => 'form-horizontal form-material form-groups-bordered validate', 'enctype' => 'multipart/form-data')); ?>
    <div class="form-group">
                    <div class="col-md-6 m-b-20">
                        <label for="field-1"><?php echo get_phrase('teacher_name');?><span class="error mandatory"> *</span></label>
                        <select name="teacher_id" class="selectpicker1" data-style="form-control" data-live-search="true" required="required" onchange="teacher_val(this.value);">
                        <option value="">Select Teacher</option>
                            <?php
                      foreach ($teacher_list as $row): ?>
                    <option value="<?php echo $row['teacher_id']; ?>"><?php echo $row['emp_id']." ".$row['name']." ".$row['last_name']; ?></option>
                    <?php endforeach; ?>
                        </select>
                    </div>
        <?php if($certificate_type == 'download'){ ?>
        <div class="col-md-6 m-b-20">
            <label><?php echo get_phrase('template_type'); ?></label>
            <select name="template_type" class="form-control" data-style="form-control" data-live-search="true" required="required" > 
                <option value="">Select Template</option>
            <option value="1"><?php echo get_phrase('template1');?></option>
            <option value="2"><?php echo get_phrase('template2');?></option>
            <option value="3"><?php echo get_phrase('template3');?></option>
            <option value="4"><?php echo get_phrase('template4');?></option>
            </select>
        </div>
        <?php } ?>
        <input type="hidden" name="teacher_ids" id="teacher_ids" value="">
         <div class="col-md-12 m-b-20 text-right">
            <button class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit'); ?>
            </button>
         </div>
    </div>
     <?php echo form_close(); ?>
<script type="text/javascript">
    $(function () {
        $('#datepicker').datepicker();
    });
 
    function onclasschange(class_id)
{
    jQuery('#section').html('<option value="">Select Section</option>');
    $.ajax({
            url: '<?php echo base_url();?>index.php?school_admin/get_section_by_class/' + class_id.value,
            success: function (response)
            {
                jQuery('#section').append(response).selectpicker('refresh');                
                //$('#section').trigger("chosen:updated");
            }
        });           
}
function onsectionchange(section_id)
    {
        var class_id = $('#class_holder').val();
        jQuery('#student_holder').html('<option value="">Select Student</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>/index.php?school_admin/get_student/' + section_id + '/' + class_id,
            success: function (response)
            { 
                jQuery('#student_holder').append(response).selectpicker('refresh');
            }
        });
//        $('#student_holder').trigger("chosen:updated");
    }
    function teacher_val(teacher_id){
   $('#teacher_ids').val(teacher_id);
    }

</script>