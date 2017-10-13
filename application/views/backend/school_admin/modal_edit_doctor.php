<?php
if (!empty($doctor_profile)) {
    ?>
<div class="row">
    <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                    <?php echo form_open(base_url() . 'index.php?school_admin/doctors/edit/' . $doctor_profile->doctor_id, array('class' => 'form-material form-groups-bordered validate', 'target' => '_top')); ?>

                    <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                        <label for="field-1" class="field-size"><?php echo get_phrase("name"); ?><span class="error error-color"> *</span></label>
                        <input type="text" class="form-control" name="name" value="<?php echo $doctor_profile->name; ?>" required="required">
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                        <label for="field-1" class="field-size"><?php echo get_phrase('email'); ?><span class="error error-color"> *</span></label>
                        <input type="text" class="form-control" name="email" value="<?php echo $doctor_profile->email; ?>">
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                        <label for="field-1" class="field-size"><?php echo get_phrase('phone_number'); ?><span class="error error-color"> *</span></label>
                        <input type="text" class="form-control" name="phone_number" maxlength="10" value="<?php echo $doctor_profile->phone_no; ?>" required="required" onkeypress="return valid_only_numeric(event);" >
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                        <label for="field-1" class="field-size"><?php echo get_phrase("address"); ?><span class="error error-color"> *</span></label>
                        <input type="text" class="form-control" name="address" value="<?php echo $doctor_profile->address; ?>" required="required">
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                        <label for="field-1" class="field-size"><?php echo get_phrase('year_of_experience'); ?><span class="error error-color"> *</span></label>
                        <input type="text" class="form-control" name="year_of_exp"  value="<?php echo $doctor_profile->year_of_exp; ?>" onkeypress="return valid_only_numeric(event);">
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                        <label for="field-1" class="field-size"><?php echo get_phrase('specialization'); ?><span class="error error-color"> *</span></label>
                        <textarea class="form-control" name="specialization" required="required"><?php echo $doctor_profile->specialization; ?></textarea>
                    </div>


                    <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                        <label for="field-1"><?php echo get_phrase("department"); ?><span class="error error-color"> *</span></label>
                        <textarea class="form-control" name="department" required="required"><?php echo $doctor_profile->department; ?></textarea>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                        <label for="field-1"><?php echo get_phrase("qualification"); ?></label>
                        <input type="text" class="form-control" name="qualification" value="<?php echo $doctor_profile->qualification; ?>" >
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                        <label for="field-1"><?php echo get_phrase("education_background"); ?></label>
                        <textarea class="form-control" name="education_background" ><?php echo $doctor_profile->education_background; ?></textarea>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                        <label for="field-1"><?php echo get_phrase("before_place_work"); ?></label>
                        <input type="text" class="form-control" name="before_place_work" value="<?php echo $doctor_profile->before_place_work; ?>">
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                        <label for="field-1"><?php echo get_phrase("achivement_award"); ?></label>
                        <textarea class="form-control" name="achivement_award" ><?php echo $doctor_profile->achivement_award; ?></textarea>
                    </div>


                    <div class="col-xs-12">
                        <div class="text-right">
                            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('update'); ?></button>
                        </div>
                    </div>

                    <?php echo form_close(); ?>
                </div>
    </div>
</div>
<?php } else {
    echo get_phrase('no_data_available');
} ?>

<script type="text/javascript">
    function valid_only_numeric(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

</script>