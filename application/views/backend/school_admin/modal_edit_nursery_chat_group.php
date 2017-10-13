<?php foreach ($edit_data as $row): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title" >
                        <i class="entypo-plus-circled"></i>
                        <?php echo get_phrase('edit_kindergarden_nursery_chat_group'); ?>
                    </div>
                </div>
                <div class="panel-body">
                    <?php echo form_open(base_url() . 'index.php?school_admin/manage_nursery_chat_group/do_update/' . $param2, array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Chat Group Name</label>
                        <div class="col-sm-5 controls">
                            <input type="text" class="form-control" name="group_name" value="<?php echo $row->group_name; ?>"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-5">
                            <button type="submit" class="btn btn-info"><?php echo get_phrase('Update'); ?></button>
                        </div>
                    </div>
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>
<?php  endforeach; ?>



