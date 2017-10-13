<?php
    $row = (array) $teacher_record;
    if (!empty($row))
    {
//         pre($teacher_record); die;
?>
        
<div class="row">
    <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                   <?php echo form_open(base_url() . 'index.php?school_admin/teacher/do_update/' . $row[ 'teacher_id'], array('class' => 'form-material form-groups-bordered validate', 'target' => '_top')); ?>

                    <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                        <label for="field-1" class="field-size"><?php echo get_phrase("name"); ?><span class="error error-color"> *</span></label>
                        <input type="text" class="form-control" name="name" value="<?php echo $teacher_record->name; ?>" required="required">
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                        <label for="field-1" class="field-size"><?php echo get_phrase("middle_name"); ?></label>
                        <input type="text" class="form-control" name="mname" value="<?php echo $teacher_record->middle_name; ?>">
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                        <label for="field-1" class="field-size"><?php echo get_phrase("last_name"); ?></label>
                        <input type="text" class="form-control" name="lname" value="<?php echo $teacher_record->last_name; ?>">
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                        <label for="field-1" class="field-size"><?php echo get_phrase('email'); ?><span class="error error-color"> *</span></label>
                        <input type="text" class="form-control" name="email" value="<?php echo $teacher_record->email; ?>">
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                        <label for="field-1" class="field-size"><?php echo get_phrase('phone_number'); ?><span class="error error-color"> *</span></label>
                        <input type="text" class="form-control" name="phone" value="<?php echo $teacher_record->cell_phone; ?>">
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                        <label for="field-1" class="field-size"><?php echo get_phrase('card_id'); ?></label>
                        <input type="text" class="form-control" name="card_id" value="<?php echo $teacher_record->card_id; ?>">
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

<?php
    }
?>