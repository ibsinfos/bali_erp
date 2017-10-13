<!-- INVOICE Category -->
<?php echo form_open(base_url() . 'index.php?school_admin/invoice_category', array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-7">
        <div class="panel panel-default panel-shadow" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title"><?php echo get_phrase('invoice_category'); ?></div>
            </div>
            <div class="panel-body">

                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo get_phrase('class'); ?></label>
                    <div class="col-sm-8">
                        <select name="class_id" id="class_id" class="selectpicker" data-style="form-control" data-live-search="true"  onchange=" select_section(this.value)" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>">
                            <option value=""><?php echo get_phrase('select_class'); ?></option>
                            <?php
                            foreach ($classes as $row):
                                ?>
                                <option value="<?php echo $row['class_id']; ?>"><?php echo $row['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label" for="description"><?php echo get_phrase('description'); ?></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" placeholder="<?php echo get_phrase('type_of_payment'); ?>" value="<?php echo set_value('description')?>" id="description" name="description"/>
                         <label style="color:red;"> <?php echo form_error('description'); ?></label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-4 control-label" for="category_code"><?php echo get_phrase('category_code'); ?></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" placeholder="<?php echo get_phrase('category_code'); ?>" value="<?php echo set_value('category_code')?>" id="category_code" name="category_code"/>
                         <label style="color:red;"> <?php echo form_error('category_code'); ?></label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-4 control-label" for="amount"><?php echo get_phrase('amount'); ?></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" placeholder="<?php echo get_phrase('amount_to_pay'); ?>" value="<?php echo set_value('amount')?>" id="amount" name="amount"/>
                         <label style="color:red;"> <?php echo form_error('amount'); ?></label>
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-6">
        <div class="form-group">
            <button type="submit" class="btn btn-info"><?php echo get_phrase('submit'); ?></button>
        </div>
    </div>
</div>
<?php echo form_close(); ?>
