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
                <?php echo form_open(base_url() . 'index.php?school_admin/bus/create', array('class' => 'form-horizontal form-groups-bordered validate')); ?>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name'); ?></label>

                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"  autofocus value="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('unique_key'); ?></label>
                    <div class="col-sm-5">
                        <input data-validate="required" type="text" class="form-control" name="key" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('description'); ?></label>

                    <div class="col-sm-5">
                        <textarea data-validate="required" name="description" class="form-control"></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('route'); ?></label>

                    <div class="col-sm-5">
                        <select data-validate="required" name="route"  class="selectpicker1" data-style="form-control" data-live-search="true">
                            <option value="">Select a route</option>
                            <?php $routes = $this->Bus_driver_modal->get_route(); foreach ($routes as $route) : ?>
                            <option value="<?= $route['transport_id']; ?>"><?= $route['route_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-default"><?php echo get_phrase('add_bus'); ?></button>
                    </div>
                </div>
                
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>