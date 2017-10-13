<div class="white-box">
    <div class="box-title"><?php echo get_phrase('new_message'); ?></div>
    <?php echo form_open(base_url() . 'index.php?parents/message/send_new/', array('class' => 'form', 'enctype' => 'multipart/form-data')); ?>
    <div class="form-group">
        <label for="subject"><?php echo get_phrase('recipient'); ?>:</label>
        <select class="selectpicker" multiple data-actions-box="true" data-live-search="true" name="reciever[]" required="required">
            <optgroup label="<?php echo get_phrase('admin'); ?>">
                <?php
                foreach ($admins as $row):
                    ?>

                    <option value="school_admin-<?php echo $row['school_admin_id']; ?>">
                        - <?php echo $row['name']; ?></option>

                <?php endforeach; ?>
            </optgroup>
            <optgroup label="<?php echo get_phrase('teacher'); ?>">
                <?php
                foreach ($teachers as $row):
                    ?>

                    <option value="teacher-<?php echo $row['teacher_id']; ?>">
                        - <?php echo $row['name']; ?></option>

                <?php endforeach; ?>
            </optgroup>
        </select>
    </div>


    <div class="form-group">
    <textarea class="form-control" rows="20" placeholder="Type your message" name="message" placeholder="<?php echo get_phrase('write_your_message'); ?>" id="sample_wysiwyg" required="required"></textarea>
    </div>    
    <div class="custom-send m-t-20 text-right">
        <button class="btn btn-danger btn-rounded" type="submit"> <?php echo get_phrase('send'); ?></button>
    </div>
    <?php echo form_close(); ?>
</div>