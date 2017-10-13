<?php
foreach ($edit_data as $row):
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel-body">
                <?php echo form_open(base_url() . 'index.php?school_admin/grade/do_update/' . $row['grade_id'], array('class' => 'form-horizontal form-material form-groups-bordered validate', 'target' => '_top')); ?>

                <div class="form-group">
                    <label><?php echo get_phrase('grade_name'); ?></label>
                    <input data-validate="required" placeholder="NAME" data-message-required="<?php echo get_phrase('value_required'); ?>" type="text" class="form-control" name="name" value="<?php echo $row['name']; ?>"/>
                </div>

                <div class="form-group">
                    <label><?php echo get_phrase('grade_point'); ?></label>
                    <input data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" type="number" class="form-control" placeholder="GRADE POINT"name="grade_point" value="<?php echo $row['grade_point']; ?>"/>
                </div>

                <div class="form-group">
                    <label><?php echo get_phrase('mark_from'); ?></label>
                    <input data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" type="number" class="form-control" placeholder="MARK FROM"name="mark_from" value="<?php echo $row['mark_from']; ?>"/>
                </div>

                <div class="form-group">
                    <label><?php echo get_phrase('mark_upto'); ?></label>
                    <input data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" type="number" class="form-control" placeholder="MARK UPTO"name="mark_upto" value="<?php echo $row['mark_upto']; ?>"/>
                </div>

                <div class="form-group">
                    <label><?php echo get_phrase('comment'); ?></label>
                    <input type="text" class="form-control" name="comment" placeholder="COMMENT" value="<?php echo $row['comment']; ?>"/>
                </div>

                <div class="form-group m-b-0 m-t-10">
                    <div class="text-right">
                        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('update'); ?></button>                    
                    </div>                     
                </div>
                </form>            
            </div>

        </div>
    </div><?php endforeach; ?>