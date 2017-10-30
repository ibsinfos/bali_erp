<?php
if (!empty($certificate_type_data)) { ?>
<div class="row">
    <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                    <?php echo form_open(base_url() . 'index.php?school_admin/certificate_types/edit/' . $certificate_type_data->certificate_type_id, array('class' => 'form-material form-groups-bordered validate', 'target' => '_top')); ?>
                        <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                            <label for="field-1" class="field-size"><?php echo get_phrase("name"); ?><span class="error error-color"> *</span></label>
                            <input type="text" class="form-control" name="certificate_type" value="<?php echo $certificate_type_data->certificate_type; ?>" required="required">
                        </div>
                <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                    <label for="field-1" class="field-size"><?php echo get_phrase("certificate_for"); ?><span class="error error-color"> *</span></label>
                    <select type="text" class="form-control" name="certificate_for" placeholder="Certificate Type" required="">
                        <option> Select </option>
                        <option value="S" <?php if($certificate_type_data->certificate_for == 'S'){ echo "selected" ; } ?>>Student</option>
                        <option value="T" <?php if($certificate_type_data->certificate_for == 'T'){ echo "selected" ; } ?>>Teacher</option>
                    </select>
                </div>
                <div class="col-xs-12">
                        <div class="text-right">
                            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('update_certificate_type'); ?></button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
    </div>
</div>
<?php } ?>