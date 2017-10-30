<?php
if (!empty($clinical_record)) {
    ?>
<div class="row">
    <div class="white-box">
            <div class="panel panel-primary" data-collapsed="0">
                    <?php echo form_open(base_url() . 'index.php?parents/clinical_history/'.$clinical_record->clinical_history_id.'/edit', array('class' => 'form-material form-groups-bordered validate', 'target' => '_top')); ?>

                    <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                        <label for="field-1" class="field-size"><?php echo get_phrase("symptoms"); ?><span class="error error-color"> *</span></label>
                        <input type="text" class="form-control" name="symptoms" value="<?php echo $clinical_record->symptoms; ?>" required="required">
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                        <label for="field-1" class="field-size"><?php echo get_phrase('diagnosis'); ?><span class="error error-color"> *</span></label>
                        <input type="text" class="form-control" name="diagnosis" value="<?php echo $clinical_record->diagnosis; ?>">
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                        <label for="field-1" class="field-size"><?php echo get_phrase('precription'); ?><span class="error error-color"> *</span></label>
                        <input type="text" class="form-control" name="precription" maxlength="10" value="<?php echo $clinical_record->prescription; ?>" required="required">
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                        <label for="field-1" class="field-size"><?php echo get_phrase("start_date"); ?><span class="error error-color"> *</span></label>
                        <input type="text" class="form-control mydatepicker" name="start_date" value="<?php echo $clinical_record->start_date; ?>" required="required">
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                        <label for="field-1" class="field-size"><?php echo get_phrase('end_date'); ?><span class="error error-color"> *</span></label>
                        <input type="text" class="form-control mydatepicker" name="end_date"  value="<?php echo $clinical_record->end_date; ?>" >
                    </div>

                    <div class="col-xs-12">
                        <div class="text-right">
                            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('update_record'); ?></button>
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
    jQuery('.mydatepicker').datepicker();
    </script>