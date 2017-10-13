<?php $bus = $this->Bus_driver_modal->get_bus($param2); ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('add_bus'); ?>
                </div>
            </div>
            <div class="panel-body">
                <?php echo form_open(base_url() . 'index.php?school_admin/bus/edit/'.$param2, array('class' => 'form-horizontal form-groups-bordered validate')); ?>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name'); ?></label>

                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"  autofocus value="<?= $bus->name; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('unique_key'); ?></label>
                    <div class="col-sm-5">
                        <input data-validate="required" type="text" class="form-control" name="key" value="<?= $bus->bus_unique_key; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('description'); ?></label>

                    <div class="col-sm-5">
                        <textarea data-validate="required" name="description" class="form-control"><?= $bus->description; ?></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-default"><?php echo get_phrase('update_bus'); ?></button>
                    </div>
                </div>
                
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>