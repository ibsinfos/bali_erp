<?php
if (!empty($edit_data)) {
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
    <?php echo form_open(base_url() . 'index.php?school_admin/manage_camp/edit/' . $edit_data->medical_camp_id, array('class' => 'form-material form-groups-bordered validate', 'target' => '_top')); ?>

                <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                    <label for="field-1" class="field-size"><?php echo get_phrase("camp_name"); ?><span class="error error-color"> *</span></label>
                    <input type="text" class="form-control" name="camp_name" value="<?php echo $edit_data->camp_name; ?>" required="required">
                </div>

                <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                    <label for="field-1" class="field-size"><?php echo get_phrase('Description'); ?></label>
                    <textarea class="form-control" name="description"><?php echo $edit_data->camp_dsecription; ?></textarea>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                    <label for="field-1" class="field-size"><?php echo get_phrase('camp_start_date'); ?><span class="error error-color"> *</span></label>
                    <input type="text" class="form-control mydatepicker" name="camp_start_date" value="<?php echo $edit_data->camp_start_date; ?>" required="required" placeholder="MM/DD/YYYY">
                </div>

                <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                    <label for="field-1" class="field-size"><?php echo get_phrase("camp_last_date"); ?><span class="error error-color"> *</span></label>
                    <input type="text" class="form-control mydatepicker" name="camp_end_date" value="<?php echo $edit_data->camp_end_date; ?>" required="required" placeholder="MM/DD/YYYY">
                </div>

                <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                    <label for="field-1" class="field-size"><?php echo get_phrase('class_name'); ?><span class="error error-color"> *</span></label>
                    <select id="class_name" name="class_name" class="selectpicker" data-style="form-control" data-live-search="true" required="required" >
                        <option value=""><?php echo get_phrase('select_class'); ?></option>
                        <?php foreach ($class_array as $row): ?>
                            <?php
                            if ($edit_data->class_id == $row['class_id']) {
                                $selected = "selected";
                            } else {
                                $selected = "";
                            }
                            ?>
                            <option value="<?php echo $row['class_id']; ?>" <?php echo $selected; ?>>          
        <?php echo $row['name']; ?>
                            </option>
    <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                    <label for="field-1" class="field-size"><?php echo get_phrase('doctor_name'); ?><span class="error error-color"> *</span></label>
                    <select id="doctor_name" name="doctor_name" class="selectpicker" data-style="form-control" data-live-search="true" required="required" >
                        <option value=""><?php echo get_phrase('select_doctor'); ?></option>
                        <?php foreach ($doctor_name_list as $row): ?>
                            <?php
                            if ($edit_data->doctor_id == $row['doctor_id']) {
                                $selected = "selected";
                            } else {
                                $selected = "";
                            }
                            ?>
                                <option value="<?php echo $row['doctor_id']; ?>" <?php echo $selected; ?>>          
                                    <?php echo $row['name']; ?>
                                </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-xs-12">
                    <div class="text-right">
                        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('edit_camp'); ?></button>
                    </div>
                </div>

    <?php echo form_close(); ?>
            </div>
        </div>
    </div>
<?php
} else {
    echo get_phrase('no_data_available');
}
?>