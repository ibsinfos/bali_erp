<meta name="viewport" content="width=device-width, initial-scale=1">       
<div class="profile-env"><?php if(!isset($data_not_found)) { ?>
    <header class="row">
        <?php
            if(isset($student_details) && $student_details->stud_image != "" && file_exists('uploads/student_image/'.$student_details->stud_image)) {
                $student_image  =   $student_details->stud_image;
            } else {
                $student_image  =   '';
            }
        ?>
        <div class="col-xs-3"><a href="#" class="profile-picture"><img src="<?php echo ($student_image != "" ?'uploads/student_image/'.$student_image:'uploads/user.jpg')?>" class="img-responsive " /></a></div>

        <div class="col-sm-9"><ul class="p-l-20"><li class="list-unstyled">
                <div class="profile-name">
                    <h3><?php echo $student_name; ?></h3>
                    <p><?php echo get_phrase('Class').' : '.$class.'<br>'; ?><?php echo get_phrase('Section').' : '.$section; ?></p>
                </div></li></ul></div>
    </header><br>
    <section class="profile-info-tabs">

        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center"><b><?php echo get_phrase('enter_information'); ?></b></h3>

                <?php echo form_open(base_url().'index.php?parent/update_student_info/'.$student_id, array('class' =>'form-horizontal form-material p-10','id'=>'studentClinicalForm'));?>
                    
                    <div class="form-group col-xs-12 p-r-0">
                        <input type="hidden" id="student_id" name="student_id" value="<?php echo $student_id;?>">
                         <label for="blood_group"><?php echo get_phrase('blood_group'); ?>:</label>
                         <select name="blood_group" id="blood_group" class="selectpicker1" data-style="form-control" data-live-search="true">
                            <option value="">Select Blood Group</option>
                            <option value="a+" <?php if($student_details->blood_group=='a+') { ?> selected="selected" <?php } ?>>A+</option>
                            <option value="a-" <?php if($student_details->blood_group=='a-') { ?> selected="selected" <?php } ?>>A-</option>
                            <option value="b+" <?php if($student_details->blood_group=='b+') { ?> selected="selected" <?php } ?>>B+</option>
                            <option value="b-" <?php if($student_details->blood_group=='b-') { ?> selected="selected" <?php } ?>>B-</option>
                            <option value="ab+" <?php if($student_details->blood_group=='ab+') { ?> selected="selected" <?php } ?>>AB+</option>
                            <option value="ab-" <?php if($student_details->blood_group=='ab-') { ?> selected="selected" <?php } ?>>AB-</option>
                            <option value="o+" <?php if($student_details->blood_group=='o+') { ?> selected="selected" <?php } ?>>O+</option>
                            <option value="o-" <?php if($student_details->blood_group=='o-') { ?> selected="selected" <?php } ?>>O-</option>
                         </select>
                         <span id="bloodgroupError" class="error hide mandatory"><?php echo get_phrase('select_blood_group'); ?>:</span>
                    </div>     

                    <div class="form-group col-xs-12 p-r-0">
                        <label><?php echo get_phrase('emergency_contact'); ?>:</label>
                        <input type="text" class="form-control" placeholder="<?php echo get_phrase('emergency_contact_number'); ?>" required="required" name="emergency_contact" id="emergency_contact" value="<?php echo $student_details->emergency_contact_number; ?>">
                            <span id="emergency_contactError" class="error hide mandatory"><?php echo get_phrase('enter_emergency_contact.'); ?></span>
                    </div>

                    <div class="col-xs-12 text-right">
                        <button type="submit"class="fcbtn btn btn-danger btn-outline btn-1d" id="insert" name="save_details" value="add_medical_record"><?php echo get_phrase('save'); ?></button>
                    </div>


                <?php echo form_close();?>
            </div> 
        </div>		
    </section><?php } else { ?>
    <header class="row"><div class="col-xs-3"><?php echo $data_not_found; ?></div></header><?php } ?>
</div>

<script>    
    $( document ).ready(function() {
        $('#studentClinicalForm').submit(function(e) {
            
            e.preventDefault();
            student_id      =   $("#student_id").val();
            blood_group         =   $("#blood_group :selected").val();
            emergency_contact     =   $("#emergency_contact").val();
            
            var myData = $("#studentClinicalForm").serialize();
            var error       =   0;
            $('.error').hide();
            if(blood_group == '') { 
                $('#bloodgroupError').removeClass('hide');
                $('#bloodgroupError').addClass('show');
                error++;
            } if (emergency_contact == '') {
                $('#emergency_contactError').removeClass('hide');
                $('#emergency_contactError').addClass('show');
                error++;
            } 
            if (student_id == '') {
                alert("Error");
                error++;
            }
            if(error >=1) {
                return false;
            } else {
                    infoData     =   '<?php echo base_url(); ?>index.php?parents/update_student_info/';
                    $.ajax({
                        url         :   infoData,  
                        type        :   'POST',
                        data        :   myData,
                        success     :   function(response) {
                                window.location.href = window.location;
                        },
                        error       :   function(xhr) {
                        }
                    });
            }
        });
    });
</script>
