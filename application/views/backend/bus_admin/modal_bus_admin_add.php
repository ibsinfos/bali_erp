<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('add_bus_admin'); ?>
                </div>
            </div>
            <div class="panel-body">
                <?php echo form_open(base_url() . 'index.php?school_admin/bus_admin/create', array('class' => 'form-horizontal form-groups-bordered validate')); ?>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name'); ?></label>

                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"  autofocus value="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email'); ?></label>
                    <div class="col-sm-5">
                        <input onblur="validateemail(this.value)" data-validate="required" id="bus_admin_email" type="text" class="form-control" name="email" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('password'); ?></label>

                    <div class="col-sm-5">
                        <input data-validate="required" type="password" class="form-control" name="password" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('phone'); ?></label>

                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="phone" value="">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('gender'); ?></label>

                    <div class="col-sm-5">
                        <select name="gender"  class="selectpicker1" data-style="form-control" data-live-search="true">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-default"><?php echo get_phrase('add_bus_admin'); ?></button>
                    </div>
                </div>
                
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>