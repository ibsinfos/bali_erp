<?php foreach ($edit_data as $row): ?>    
    <div class="row">
        <div class="col-md-12">
            <div class="panel-body">
                <?php echo form_open(base_url() . 'index.php?school_admin/exam/edit/do_update/' . $row['exam_id'], array('class' => 'form-horizontal form-material form-groups-bordered validate', 'target' => '_top')); ?>
                <div class="form-group">
                    <div class="col-md-12 m-b-20">
                        <label><?php echo get_phrase('name'); ?></label>
                        <input type="text" class="form-control" name="name" value="<?php echo $row['name']; ?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" autofocus=""/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12 m-b-20">
                        <label><?php echo get_phrase('date'); ?></label>
                        <input type="text" class="datepicker form-control" name="date" value="<?php echo $row['date']; ?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12 m-b-20">
                        <label><?php echo get_phrase('comment'); ?></label>
                        <input type="text" class="form-control" name="comment" value="<?php echo $row['comment']; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12 text-right">
                        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('update'); ?></button>
                    </div>                        
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div><?php endforeach; ?>