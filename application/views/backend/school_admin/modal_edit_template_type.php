<?php
if (!empty($edit_data)) { ?>
<div class="row">
    <div class="col-md-12">
            <div class="panel-body">
                    <?php echo form_open(base_url() . 'index.php?school_admin/certificate_template_types/edit/' . $edit_data->certificate_template_type_id, array('class' => 'form-material form-groups-bordered validate', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
                <div class="form-group">
                    <div class="col-md-12 m-b-20">
                                <label for="field-1" class="field-size"><?php echo get_phrase("template_name"); ?><span class="error error-color"> *</span></label>
                                <input type="text" class="form-control" name="template_name" value="<?php echo $edit_data->template_name; ?>" required="required">
                    </div>
   <div class="col-md-12 m-b-20">
                    <label for="field-1"><?php echo get_phrase('upload_template');?><span class="error mandatory"> *</span></label>
                       <input type="file" id="input-file-now" class="dropify" name="template_path" ata-default-file="<?php echo $edit_data->image_path; ?>" value="<?php echo $edit_data->image_path; ?>">
                     </div>
                <div class="col-xs-12">
                        <div class="text-right">
                            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('update_template_type'); ?></button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
    </div>
</div>
</div>
<?php } ?>
<script type='text/javascript'>

$('.dropify').dropify({
    messages: {
        'default': 'Drag and drop a file here or click',
        'replace': 'Drag and drop or click to replace',
        'remove':  'Remove',
        'error':   'Ooops, something wrong happended.'
    }
});
</script>