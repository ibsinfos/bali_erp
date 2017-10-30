<div class="modal-body">
    <?php echo form_open(base_url() . 'index.php?school_admin/product/service/' . $param2, array('class' => 'form-material  form-groups-bordered validate', 'enctype' => 'multipart/form-data')); ?>
    <from class="form-horizontal form-material">
        <div class="form-group">
            <label class="col-md-12">Select Vendor<span class="error mandatory"> *</span></label>
            <div class="col-md-12 m-b-20">
                <select name="vendor" class="selectpicker1 select2" data-style="form-control" data-live-search="true" required="required" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>">
                    <option value=""><?php echo get_phrase('select_vendor'); ?></option>
                    <?php foreach ($vendor as $row) { ?>
                        <option value="<?php echo $row['seller_id']; ?>">
                            <?php echo $row['seller_name']; ?>
                        </option>
                    <?php } ?>                            
                </select>
            </div>                       
        </div>
        <div class="form-group">
            <label class="col-md-12">Sending_to_service_on</label>
            <div class="col-md-12 m-b-20">
                <?php  
                if(function_exists('date_default_timezone_set'))
                {
                    date_default_timezone_set("Asia/Kolkata");
                }                
                ?>
                <input type="text" class="form-control" name="service_date" value="<?php echo date('d/m/Y H:i:s'); ?>" disabled="disabled">
            </div>                       
        </div>
        <div class="form-group">
            <label class="col-md-12">Reason for Service<span class="error mandatory"> *</span></label>
            <div class="col-md-12 m-b-20">
                <input id= "reason" type="text" class="form-control" required="required" name="reason"  placeholder="Enter reason" data-validate="required" data-message-required ="Please enter a reason">
            </div>                       
        </div>        
        <div class="text-right">
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" name="save_details"><?php echo get_phrase('send_for_service'); ?></button>
        </div>
    </from>
    <?php echo form_close(); ?>
</div>
