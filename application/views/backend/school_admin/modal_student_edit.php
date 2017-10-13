<?php
if (!empty($student_personal_info)) {
    ?>
    <from class="form-horizontal form-material">

    <?php echo form_open(base_url() . 'index.php?school_admin/student/do_update/' . $student_personal_info->student_id . '/' . $student_personal_info->class_id, array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data')); ?>

        <div class="form-group">
            <div class="col-md-offset-4 col-md-4">                
                <?php
                $image_url = ($student_personal_info->stud_image != '' ? base_url() . 'uploads/student_image/' . $student_personal_info->stud_image : base_url() . 'uploads/user.jpg');
                if ($student_personal_info->stud_image == '') {
                    $image_url = base_url() . 'uploads/student_image/user.jpg';
                    ?>
                    <div class="el-overlay-1">
                        <img src="<?php echo $image_url; ?>" id="blah" alt="image" width="150" height="150" onmouseover="$('#profile_overlay').show();" onmouseout="$('#profile_overlay').show();">

                        <span class="select-wrapper-file"><input class="image-src-file" type='file' name ="userfile" onchange="readURL(this);" /></span> 
                    </div>

                <?php
                } else {
                    $path = FCPATH . "uploads/student_image/";
                    $filename = $student_personal_info->stud_image;
                    $full_path = $path . $filename;
                    if (file_exists($full_path)) {
                        $image_url = base_url() . 'uploads/student_image/' . $student_personal_info->stud_image;
                        ?>
                        <div class="el-overlay-1" >
                            <img src="<?php echo $image_url; ?>" id="blah" alt="image" width="150" height="150" onmouseover="$('#profile_overlay').show();" onmouseout="$('#profile_overlay').show();">
                            <div id="profile_overlay" class="el-overlay1" style="position: absolute;left: 0px;bottom: 0px;top: 0px;width: 100%;height: 100%;color: rgb(255, 255, 255);background-color: rgb(0, 0, 0);opacity: 0.5;text-align: center; display: none;">
                                <a href="#" onclick="remove_profile(<?php echo $student_personal_info->student_id; ?>);" title="Remove Photo"><i class="fa fa-trash" style="margin-top:70px; font-size: 30px;"></i></a>
                            </div>
                            <span class="select-wrapper-file"><input class="image-src-file" type='file' name ="userfile" onchange="readURL(this);" /></span> 
                        </div>
        <?php } else {
            $image_url = base_url() . 'uploads/student_image/user.jpg';
            ?>
                        <div class="el-overlay-1">
                            <img src="<?php echo $image_url; ?>" id="blah" alt="image" width="150" height="150" onmouseover="$('#profile_overlay').show();" onmouseout="$('#profile_overlay').show();">                   
                            <span class="select-wrapper-file"><input class="image-src-file" type='file' name ="userfile" onchange="readURL(this);" /></span> 
                        </div>
        <?php
        }
    }
    ?>

            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6 m-b-20"> 
                <label><?php echo get_phrase('First_Name'); ?><span class="error mandatory"> *</span></label>
                <input type="text" class="form-control" placeholder="Enter First Name" name="name" data-validate="required" required="required"  value="<?php echo $student_personal_info->name; ?>"></div>

            <div class="col-md-6 m-b-20">
                <label><?php echo get_phrase('Middle_Name'); ?></label>
                <input type="text" class="form-control" name="mname" placeholder="Enter Middle Name" value="<?php echo ($student_personal_info->mname != '' ? $student_personal_info->mname : ''); ?>"></div>

            <div class="col-md-6 m-b-20">
                <label><?php echo get_phrase('Last_Name'); ?></label>
                <input type="text" class="form-control" name="lname" placeholder="Enter Last Name" data-validate="required" value="<?php echo $student_personal_info->lname; ?>"></div>

            <div class="col-md-6 m-b-20">
                <label><?php echo get_phrase('birthdate'); ?><span class="error mandatory"> *</span></label>
                <input type="text" id="datepicker" class="form-control" name="birthday"  placeholder="Enter Birthday" required="required" value="<?php echo $student_personal_info->birthday; ?>" data-start-view="2" data-validate="required"></div>

            <?php if ($student_personal_info->class_name != 'Nursery') { ?>
                <div class="col-sm-6">
                    <label><?php echo get_phrase('Previous_school'); ?></label>
                    <input type="text" class="form-control" placeholder="previous school" name="previous_school" value="<?php echo $student_personal_info->previous_school; ?>"  >
                </div> 
            <?php } else { ?>

                <div class="col-sm-6">
                    <label><?php echo get_phrase('previous_school'); ?></label>
                    <input type="text" class="form-control" placeholder="previous school" name="previous_school" value="NA" disabled="disabled">  
                </div> 
    <?php } ?>

            <div class="col-md-6 m-b-20">
                <label><?php echo get_phrase('Course'); ?></label>
                <input type="text" class="form-control" name="course" placeholder="Enter Cousre" value="<?php echo $student_personal_info->course; ?>" data-validate="required" > </div>

            <div class="col-md-6 m-b-20">
                <label><?php echo get_phrase('Class'); ?><span class="error mandatory"> *</span></label>
                <input type="text" class="form-control" name="class" placeholder="Enter Class" disabled value="<?php echo $student_personal_info->class_name; ?>" 
                       data-validate="required" required="required">
            </div>

            <div class="col-md-6 m-b-20">
                <label><?php echo get_phrase('Section'); ?><span class="error mandatory"> *</span></label>
                <select name="section_id" class="selectpicker1" data-style="form-control" data-live-search="true" data-validate="required" required="required" placeholder="Enter Section">
                    <option value=""><?php echo get_phrase('select_section'); ?></option>
                            <?php
                            foreach ($sections as $section):
                                ?>
                        <option value="<?php echo $section->section_id; ?>"
        <?php if ($student_personal_info->section_id == $section->section_id) echo 'selected'; ?>><?php echo $section->name; ?></option>
    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6 m-b-20">
                <label><?php echo get_phrase('admission_no'); ?><span class="error mandatory"> *</span></label>
                <input type="text" class="form-control" name="admission_no" placeholder="Enter Admission No." 
                       value="<?php echo $student_personal_info->admission_no ?>">
                <input type="hidden" name="old_admission_no" value="<?php echo $student_personal_info->admission_no ?>">
            </div>

            <div class="col-md-6 m-b-20">
                <label><?php echo get_phrase('Gender'); ?><span class="error mandatory"> *</span></label>
                <select name="sex" class="selectpicker1" data-style="form-control" data-live-search="true" data-validate="required" required="required" placeholder="Enter Gender">
    <?php
    $gender = $student_personal_info->sex;
    ?>
                    <option value="Male" <?php if ($gender == 'Male') echo 'selected'; ?>><?php echo get_phrase('male'); ?></option>
                    <option value="Female"<?php if ($gender == 'Female') echo 'selected'; ?>><?php echo get_phrase('female'); ?></option>
                </select>
            </div>

            <div class="col-md-6 m-b-20">
                <label><?php echo get_phrase('Passport_no'); ?></label>
                <input placeholder="Enter Passport No" type="text" class="form-control" name="passport_no" value="<?php echo $student_personal_info->passport_no; ?>" ></div>


            <div class="col-md-6 m-b-20">
                <label><?php echo get_phrase('Icard_no'); ?></label>
                <input placeholder="Enter Icard No" type="text" class="form-control" name="icard_no" data-validate="required" value="<?php echo $student_personal_info->icard_no; ?>"></div>

            <div class="col-md-6 m-b-20">
                <label><?php echo get_phrase('icard_type'); ?></label>
                <input type="text" class="form-control" name="type" data-validate="required" placeholder="Enter Icard type" value="<?php echo $student_personal_info->type; ?>"></div>

            <div class="col-md-6 m-b-20">
                <label><?php echo get_phrase('Select_parent_name'); ?><span class="error mandatory"> *</span></label>
                <select name="parent_id" class="selectpicker1" data-style="form-control" data-live-search="true" data-validate="required" required="required" placeholder="Select Parent Name">
                    <option value=""><?php echo get_phrase('select'); ?></option>
                            <?php
                                $parent_id = $student_personal_info->parent_id;
                                foreach ($parents as $parent):
                                    ?>
                        <option value="<?php echo $parent['parent_id']; ?>"
                        <?php if ($parent['parent_id'] == $parent_id) echo 'selected'; ?>>
        <?php echo $parent['father_name']; ?>
                        </option>
        <?php
    endforeach;
    ?>
                </select>
            </div>

            <div class="col-md-6 m-b-20">
                <label><?php echo get_phrase('nationality'); ?><span class="error mandatory"> *</span></label>
                <select id="nationality" name ="nationality" class="selectpicker1" data-style="form-control" data-live-search="true" data-validate="required" placeholder="Select Nationality" data-message-required ="Please select your country of residence" required="required" >
                    <option value="">--Select Nationality--</option>
                    <?php
                    $selected = '';
                    $existing_value = $student_personal_info->nationality;
                    ?>
                    <?php
                    foreach ($nationalities as $row) {
                        if ($row['name'] == $existing_value) {
                            $selected = 'selected';
                        } else {
                            $selected = '';
                        }
                        ?>
                        <option value="<?php echo $row['name']; ?>" <?php echo $selected; ?>><?php echo $row['name']; ?></option>
        <?php
    }
    ?>
                </select></div>

            <div class="col-md-12 m-b-20">
                <label><?php echo get_phrase('Address'); ?><span class="error mandatory"> *</span></label>
                <textarea class="form-control" rows="2" name="address" placeholder="Enter Address" data-validate="required" required="required"><?php echo $student_personal_info->address; ?></textarea></div>

            <div class="col-md-6 m-b-20">
                <label><?php echo get_phrase('Country'); ?><span class="error mandatory"> *</span></label>
                <select id="country" name ="country" placeholder="Select Country"  class="selectpicker1" data-style="form-control" data-live-search="true" data-validate="required" data-message-required ="Please select your country of residence" required="required">
                    <option value=""></option>
                    <?php
                    $selected = '';
                    $existing_value = $student_personal_info->country;
                    ?>
                    <?php
                    foreach ($countries as $key => $country) {
                        if ($country == $existing_value) {
                            $selected = 'selected';
                        } else {
                            $selected = '';
                        }
                        ?>
                        <option value="<?php echo $country; ?>" <?php echo $selected; ?>><?php echo $country; ?></option>
        <?php
    }
    ?>
                </select></div>

            <div class="col-md-6 m-b-20">
                <label><?php echo get_phrase('Place_of_birth'); ?></label>
                <input type="text" class="form-control" name="place_of_birth" placeholder="Enter Place of Borth" value="<?php echo $student_personal_info->place_of_birth; ?>" ></div>

            <div class="col-md-6 m-b-20">
                <label><?php echo get_phrase('Phone_no'); ?><span class="error mandatory"> *</span></label>
                <input type="tel" class="form-control" name="phone" placeholder="Enter Phone No" value="<?php echo $student_personal_info->phone; ?>" title=""  required="required"></div>

            <div class="col-md-6 m-b-20">
                <label><?php echo get_phrase('Card_id'); ?><span class="error mandatory"> *</span></label>
                <input type="text" class="form-control" name="card_id" placeholder="Enter Card Id" value="<?php echo $student_personal_info->card_id; ?>" data-validate="required" required="required"></div>

            <div class="col-md-6 m-b-20">
                <label><?php echo get_phrase('Dormitory'); ?></label>
                <select name="dormitory_id" class="selectpicker1" data-style="form-control" data-live-search="true" placeholder="Select Dormitory">
                    <option value=""><?php echo get_phrase('select'); ?></option>
    <?php
    foreach ($dormitories as $row2):
        ?>
                        <option value="<?php echo $row2['dormitory_id']; ?>"
                        <?php if ($student_personal_info->dormitory_id == $row2['dormitory_id']) echo 'selected'; ?>><?php echo $row2['name']; ?></option>
                    <?php endforeach; ?>
                </select></div>

            <div class="col-md-6 m-b-20">
                <label><?php echo get_phrase('Transport'); ?></label>
                <select name="transport_id" class="selectpicker1" data-style="form-control" data-live-search="true">
                    <option value=""><?php echo get_phrase('select'); ?></option>
    <?php
    $trans_id = $student_personal_info->transport_id;
    foreach ($transports as $row2):
        ?>
                        <option value="<?php echo $row2['transport_id']; ?>"
                    <?php if ($trans_id == $row2['transport_id']) echo 'selected'; ?>><?php echo $row2['route_name']; ?></option>
                <?php endforeach; ?>
                </select>            
                <input type="hidden" name="image" value="<?php echo $student_personal_info->stud_image; ?>" ></div>

            <div class="col-md-6 m-b-20">
                <?php
                $media_consent = $student_personal_info->media_consent;
                if ($media_consent == 'NO') {
                    $select1 = "checked='checked'";
                    $select2 = '';
                } else {
                    $select2 = "checked='checked'";
                    $select1 = '';
                }
                ?>
                <label for="media_consent"><?php echo get_phrase("media_consent"); ?><span class="error mandatory"> *</span></label>
                <input type="radio" name="media_consent" value="NO" <?php echo $select1; ?> >NO &nbsp;
                <input type="radio" name="media_consent" value="YES" <?php echo $select2; ?> >YES
            </div>
            <div class="col-md-6 m-b-20">
                <label><?php echo get_phrase('emirates_id'); ?><span class="error mandatory"> *</span></label>
                <input type="text" class="form-control" name="emirates_id" placeholder="Enter Emirates Id" value="<?php echo $student_personal_info->emirates_id; ?>" data-validate="required" required="required"></div>
            <div class="col-md-6 m-b-20">
                <label><?php echo get_phrase('visa_no'); ?><span class="error mandatory"> *</span></label>
                <input type="text" class="form-control" name="visa_no" placeholder="Enter Visa Number" value="<?php echo $student_personal_info->visa_no; ?>" data-validate="required" required="required"></div>
            <div class="col-md-6 m-b-20">
                <label><?php echo get_phrase('visa_expiry_date'); ?><span class="error mandatory"> *</span></label>
                <input type="text" class="form-control" name="visa_expiry_date" placeholder="Enter Visa Expiry Date" value="<?php echo $student_personal_info->visa_expiry_date; ?>" data-validate="required" required="required"></div>
            <div class="col-md-6 m-b-20">
                <label><?php echo get_phrase('passport_expiry_date'); ?><span class="error mandatory"> *</span></label>
                <input type="text" class="form-control" name="passport_expiry_date" placeholder="Enter Passport Expiry Date" value="<?php echo $student_personal_info->passport_expiry_date; ?>" data-validate="required" required="required"></div>
            <div class="col-md-6 m-b-20">
                <label><?php echo get_phrase('allergies'); ?><span class="error mandatory"> *</span></label>
                <input type="text" class="form-control" name="allergies" placeholder="Enter Allergies" value="<?php echo $student_personal_info->allergies; ?>" data-validate="required" required="required"></div>
            <div class="col-md-12 m-b-20 text-right">
                <button class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('Update'); ?>
                </button></div>
        </div>
    <?php echo form_close(); ?>
    </from> 
    <?php
}
?>
<script type="text/javascript">
    $(function () {
        $('#datepicker').datepicker();
    });

    function remove_profile(student_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?ajax_controller/remove_student_image/',
            type: "POST",
            data: {student_id: student_id},
            success: function (response) {
            }
        });
        window.location.reload();
    }

</script>