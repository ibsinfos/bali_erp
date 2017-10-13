<div>
  
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12">
            <?php foreach ($service as $value) { ?>
                <?php echo form_open(base_url() . 'index.php?school_admin/product/return_product_service/' . $value['service_id'] . '/' . $value['product_id'], array('class' => 'form-material form-groups-bordered validate', 'target' => '_top')); ?> 
  
            <div class="form-group col-md-12">
                <label><?php echo get_phrase("product_name"); ?><span class="error mandatory"> *</span></label>
                <input type="text" class="form-control" value="<?php echo $value['product_name'];?>" disabled="disabled">
            </div>
            

            <div class="form-group col-md-12">
                <label><?php echo get_phrase('sent_for_service_on'); ?><span class="error mandatory"> *</span></label>
                        
                    <input type="text" class="form-control datepicker" value="<?php echo $value['send_for_service']; ?>" disabled="disabled">

                </div>
            <div class="form-group col-md-12">
                <label><?php echo get_phrase("vendor_name"); ?><span class="error mandatory"> *</span></label>
                <input type="text" class="form-control" value="<?php echo $value['vendor_name'];?>" disabled="disabled">
            </div>
                <div class="form-group col-md-12">
                    <label  class="control-label" for='reason'><?php echo get_phrase('what_is_the_reason_for_service?'); ?><span class="error" style="color: red;"> *</span></label>  
                    <input id= "reason" type="text" class="form-control" required="required" name="reason"  value="<?php echo $value['reason_for_service']; ?>" placeholder="enter reason" data-validate="required" data-message-required ="Please enter a reason">
                </div>
                        <?php } ?> 

            <div class="form-group col-md-12">
                <label  class="control-label" for='received'><?php echo get_phrase('date_received_product_from_service'); ?><span class="error" style="color: red;"> *</span></label>  
                <input id= "received" type="text" class="form-control datepicker" required="required" name="received"  value="<?php echo date('d-m-Y H:i:s'); ?>" placeholder="Pick a date" data-validate="required" data-message-required ="Please pick a date" disabled="disabled">
            </div>
    

            <div class="text-right">
                 <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('save_changes');?></button>
                    
                         
            </div>

            <?php echo form_close(); ?>
        </div>
    </div>
</div>
</div>

