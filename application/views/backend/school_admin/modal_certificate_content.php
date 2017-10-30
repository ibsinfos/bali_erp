<?php if($user_type == "t"){
    $method = "teacher_certificates";
}else{
    $method = "student_certificates"; 
} ?>

<from class="form-horizontal form-material">
      <?php echo form_open(base_url() . 'index.php?school_admin/'.$method.'/create', array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data')); ?>
    <div class="form-group">
        <div class="col-md-6 m-b-20"> 
            <label><?php echo get_phrase('ceritificate_title'); ?><span class="error mandatory"> *</span></label>
            <input type="text" class="form-control" placeholder="Enter certificate title" name="ceritificate_title" data-validate="required" required="required"  value=""></div>        
        <div class="col-md-6 m-b-20">
            <label><?php echo get_phrase('sub_title'); ?><span class="error mandatory"> *</span></label>
            <input type="text" class="form-control" name="sub_title" placeholder="Enter certificate title " value="" required="required"></div>
        
        <div class="col-md-6 m-b-20">
            <label><?php echo get_phrase('main_content'); ?></label>
            <input type="text" class="form-control" name="main_cantent" placeholder="Enter main catent" data-validate="required"  value="">
        </div>
        <div class="col-md-6 m-b-20">
            <label><?php echo get_phrase('certificate_type'); ?><span class="error mandatory"> *</span></label>
            <select name="certificate_type" class="selectpicker1" data-style="form-control" data-live-search="true" required="required" data-live-search="true" onchange="return oncertificate_typechange(this.value);"> 
            <option value="">Select Template</option>
            <?php foreach($certificate_type_list as $row): ?>
            <option value="<?php echo $row['certificate_type_id']; ?>"><?php echo $row['certificate_type']; ?></option>    
            <?php endforeach;  ?>
            </select>
        </div>
         <div class="col-md-6 m-b-20">
            <label><?php echo get_phrase('template_type'); ?><span class="error mandatory"> *</span></label>
            <select name="template_type" id="template_holder" class="selectpicker1" data-style="form-control" data-live-search="true" required="required" data-live-search="true"> 
            <option value="">Select Template</option>
            </select>
        </div>
        <div class="col-md-6 m-b-20"><input type="hidden" name="certificate_authority" id="show_aothorities" value="">
            <label><?php echo get_phrase('select_authorities'); ?></label>
            <select name="certificate_authorities" class="selectpicker1" multiple data-style="form-control" data-live-search="true" data-actions-box="true" onchange="get_authorities();" id="authorities"> 
            <?php foreach($authorities_list as $row): ?>
            <option value="<?php echo $row['certificate_authorities_id']; ?>"><?php echo $row['authorities_name']." (".$row['designaiton'].")" ?></option>
            <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6 m-b-20">
            <label><?php echo get_phrase('page_size'); ?></label>
            <select name="page_size" class="selectpicker1" data-style="form-control" data-live-search="true">
            <option value=""> Select Page Size  </option>
            <?php foreach($size_list as $row): ?>
            <option value="<?php echo $row['size']; ?>"><?php echo $row['size']; ?></option>
            <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6 m-b-20">
            <label><?php echo get_phrase('page_orientation'); ?></label>
            <select name="page_orientation" class="selectpicker1" data-style="form-control" data-live-search="true"> 
                <option value=""> Select Page Orientation  </option>
                <option value="Landscape"> Landscape </option>
                <option value="Portrait"> Portrait </option>
            </select>
        </div>
       <?php if($user_type == "s") { ?>
        <div class="col-md-6 m-b-20">
            <label for="field-1"><?php echo get_phrase('class');?><span class="error mandatory"> *</span></label>
            <select name="user_type" class="selectpicker1" data-style="form-control" data-live-search="true" required="required" onchange="return onclasschange(this);" id="class_holder" >
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
                        <select name="student_name[]" id="student_holder" onchange="return student_val(this.value);" class="selectpicker1" multiple data-style="form-control" data-live-search="true" data-actions-box="true" required="">             
                        </select>
                    </div>
       <?php }else{ ?>
            <div class="col-md-6 m-b-20">
                        <label for="field-1"><?php echo get_phrase('teacher_name');?><span class="error mandatory"> *</span></label>
                        <select name="teacher_name[]" class="selectpicker1" data-style="form-control" data-live-search="true" required="required" multiple data-style="form-control" data-live-search="true" data-actions-box="true" >
                            <?php
                      foreach ($teacher_list as $row): ?>
                    <option value="<?php echo $row['teacher_id']; ?>"><?php echo $row['emp_id']." ".$row['name']." ".$row['last_name']; ?></option>
                    <?php endforeach; ?>
                        </select>
            </div>
       <?php } ?>
        <input type="hidden" name="student_id" id="student_id" value="">
         <div class="col-md-12 m-b-20 text-right">
            <button class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('create_certificate'); ?>
            </button>
         </div>
    </div>
     <?php echo form_close(); ?>
</from> 
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
//        jQuery('#student_holder').html('<option value="">Select Student</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>/index.php?school_admin/get_student/' + section_id + '/' + class_id,
            success: function (response)
            { 
                jQuery('#student_holder').append(response).selectpicker('refresh');
            }
        });
//        $('#student_holder').trigger("chosen:updated");
    }
    
    function oncertificate_typechange(certificate_type)
    {
        jQuery('#template_holder').html('<option value="">Select Template</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>/index.php?school_admin/get_template_type/' + certificate_type,
            success: function (response)
            {  
                jQuery('#template_holder').append(response).selectpicker('refresh');
            }
        });
//        $('#student_holder').trigger("chosen:updated");
    }
    
    
    function student_val(student_id){
   $('#student_id').val(student_id);
    }

function get_authorities(){
        var authorities_id = []; 
        $('#authorities :selected').each(function(i, selected){ 
            authorities_id[i] = $(selected).val(); 
        }); 
        $('#show_aothorities').val(authorities_id);           
    }
</script>