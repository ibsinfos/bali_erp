<?php
if (!empty($edit_data)) { ?>
<div class="row">
    <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                    <?php echo form_open_multipart(base_url() . 'index.php?school_admin/certificate_authorities/edit/' . $edit_data->certificate_authorities_id, array('class' => 'form-material form-groups-bordered validate', 'target' => '_top')); ?>
                        <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                            <label for="field-1" class="field-size"><?php echo get_phrase("authorities_name"); ?><span class="error error-color"> *</span></label>
                            <input type="text" class="form-control" name="name" value="<?php echo $edit_data->authorities_name; ?>" required="required">
                        </div>
                <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                            <label for="field-1" class="field-size"><?php echo get_phrase("designaiton"); ?><span class="error error-color"> *</span></label>
                            <input type="text" class="form-control" name="designation" value="<?php echo $edit_data->designaiton; ?>" required="required">
                        </div>
                <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                            <label for="field-1" class="field-size"><?php echo get_phrase("Authorities_sign"); ?></label>
                            <input type="file" class="form-control" name="authorities_sign" value="<?php echo $edit_data->signature; ?>">
                        </div>
                <div class="col-xs-12">
                        <div class="text-right">
                            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('update_certificate_authorities'); ?></button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
    </div>
</div>
<?php } ?>