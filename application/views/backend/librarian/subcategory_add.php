<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title" >
                    <i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('add_new_subcategory'); ?>
                </div>
            </div>
            <div class="panel-body">

                <?php echo form_open(base_url() . 'index.php?librarian/subcategories/create/', array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data')); ?>
                <input type="hidden" name="category_id" value="<?php echo empty($param2) ? "" : $param2; ?>">
                       <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('subcategory_name'); ?></label>

                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="subcategory_name" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" value="" autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3"><?php echo get_phrase('status'); ?></label>
                    <div class="col-sm-5">
                        <select name="subcategory_status"  class="selectpicker" data-style="form-control" data-live-search="true" style="width:100%;">
                            <option value="">Select</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-info"><?php echo get_phrase('add_subcategory'); ?></button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>