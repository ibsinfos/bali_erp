    <?php echo form_open(base_url() . 'index.php?school_admin/camp_assign_to_student/edit/'.$camp_assign_id, array('class' => 'form-horizontal form-material form-groups-bordered validate', 'enctype' => 'multipart/form-data')); ?>
    <div class="form-group">
                    <div class="col-md-6 m-b-20">
                        <label for="field-1"><?php echo get_phrase('class');?><span class="error mandatory"> *</span></label>
                        <select name="class_id" class="selectpicker1" data-style="form-control" data-live-search="true" required="required" onchange="return onclasschange(this);" id="class_holder">
                    <option value="">Select Class</option>
                      <?php
                    foreach ($classes as $row): 
                        if($camp_assign_edit->class_id == $row['class_id']){
                            $select = "selected";
                        }else{
                            $select = '';
                        }
                        ?>
                    <option value="<?php echo $row['class_id']; ?>" <?php echo $select; ?>><?php echo $row['name']; ?></option>
                    <?php endforeach; ?>
                        </select>
                    </div>
          <div class="col-md-6 m-b-20">
                        <label for="field-1"><?php echo get_phrase('section');?><span class="error mandatory"> *</span></label>
                        <select name="section_id" class="selectpicker1" data-style="form-control" data-live-search="true" required="required" id="section" onchange="return onsectionchange(this.value);">
                        <option value=""> Select Section </option>
                        <?php foreach($sections as $row):  
                        if($camp_assign_edit->section_id == $row['section_id']){
                            $select = "selected";
                        }else{
                            $select = '';
                        }
                        ?>
                        <option value="<?php echo $row['section_id']; ?>" <?php echo $select; ?>> <?php echo $row['name'];  ?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>
          <div class="col-md-6 m-b-20">
                        <label for="field-1"><?php echo get_phrase('student');?><span class="error mandatory"> *</span></label>
                        <select name="student_id" class="selectpicker1" required="required" data-style="form-control" data-live-search="true" id="student_holder_div" onchange="return student_val(this.value);">
                        <option value=""> Select Student </option>      
                        <?php foreach($students as $row): 
                        if($camp_assign_edit->student_id == $row['student_id']){
                            $select = "selected";
                        }else{
                            $select = '';
                        }
                        ?>
                        <option value="<?php echo $row['student_id']; ?>" <?php echo $select; ?>><?php echo $row['name']; ?></option>    
                        <?php endforeach;  ?>
                        </select>
                    </div>
                    <div class="col-md-6 m-b-20">
                        <label><?php echo get_phrase('camp_type'); ?></label>
                        <select name="camp_type" class="selectpicker1" id="camp_type_holder" data-style="form-control" data-live-search="true" required="required"> 
                            <option value="">Select Camp</option> 
                            <?php foreach($camp as $row):
                            if($camp_assign_edit->medical_camp_id == $row['medical_camp_id']){
                                $select = "selected";
                            }else{
                                $select = '';
                            }
                            ?>
                            <option value="<?php echo $row['medical_camp_id']; ?>" <?php echo $select; ?>><?php echo $row['camp_name']; ?></option>
                            <?php endforeach; ?>
                    </select>
                    </div>
        <div class="col-md-12 m-b-20 text-right">
            <button class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('update_assign_camp'); ?>
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
        jQuery('#student_holder_div').html('<option value="">Select Student</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>/index.php?school_admin/get_student/' + section_id + '/' + class_id,
            success: function (response)
            { alert(response);
                jQuery('#student_holder_div').append(response).selectpicker('refresh');
            }
        });
//        $('#student_holder').trigger("chosen:updated");
    }    
</script>