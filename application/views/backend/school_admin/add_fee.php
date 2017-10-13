<div class="panel panel-default" style="margin:20px;">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo get_phrase('Add Fees For Classes'); ?></h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <?php echo form_open(base_url() . 'index.php?school_admin/add_fee_settings'); ?> 
                <div class="form-group col-md-6">
                    <label><?php echo get_phrase("select_class"); ?><span class="error" style="color: red;"> *</span></label>
                    <select class="selectpicker" data-style="form-control" data-live-search="true" name="class">
                        <option>-- Select Class--</option>
                        <?php
                            foreach($class_values as $value){
                        ?>
                            <option value="<?php echo $value['class_id'] ?>"><?php echo $value['name']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label><?php echo get_phrase("payment_for"); ?><span class="error" style="color: red;"> *</span></label>
                    <select  class="selectpicker" data-style="form-control" data-live-search="true" name="hostel_type">
                        <option>--Select payment term--</option>
                        <option value="monthly">Monthly</option>
                        <option value="quarterly">Quarterly</option>
                        <option value="half_yearly">Half yearly</option>
                        <option value="annual_fees">Annual fees</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label><?php echo get_phrase("enter_amount"); ?><span class="error" style="color: red;"> *</span></label>
                    
                    <input type="text" class="form-control" name="fee_amount" placeholder="Amount">
                </div>

                <div class="form-group col-md-6">
                    <label><?php echo get_phrase("hostel_address"); ?><span class="error" style="color: red;"> *</span></label>
                    <textarea class="form-control" name="hostel_address" rows="2" placeholder="Hostel Address"></textarea>
                </div>

                <div class="form-group col-md-6">
                    <label><?php echo get_phrase("warden_name"); ?><span class="error" style="color: red;"> *</span></label>
                    <input type="text" class="form-control" name="warden_name" placeholder="Warden Name">
                </div>

                <div class="form-group col-md-6">
                    <label><?php echo get_phrase("warden_phone_number"); ?><span class="error" style="color: red;"> *</span></label>
                    <input type="text" class="form-control" name="warden_phone_number" placeholder="Phone Number">
                </div>

                <div class="form-group col-md-6">
                    <label><?php echo get_phrase("warden_address"); ?><span class="error" style="color: red;"> *</span></label>
                    <textarea class="form-control" name="warden_address" rows="2" placeholder="Warden Address"></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-4"></div>
                <div class="col-md-6" >
                    <input  type="submit" class="btn btn-primary col-md-6" value="Add Fee"/>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
