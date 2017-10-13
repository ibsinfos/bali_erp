<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><?php echo get_phrase('send_vehicle_to_service'); ?></h4>
            </div>

   <div class="panel-body">
             
                <?php foreach ($service_details as $row) { ?>
                <?php echo form_open(base_url() . 'index.php?school_admin/manage_vehicle_details/return_from_service/'.$row['vehicle_service_maintenance_id'] .'/'. $param2, array('class' => 'form-material form-groups-bordered validate', 'enctype' => 'multipart/form-data')); ?>
                <div class="form-group">                    
                    <div class="col-md-12 m-b-20">
                        <input id= "vendor_name" type="text" class="form-control" required="required"  name="vendor_name" value="<?php echo $row['vendor_name']?>"  placeholder="<?php echo get_phrase("enter_vendor_name") ?>" data-validate="required" data-message-required ="<?php echo get_phrase("please_enter_vendor_name") ?>"> 
                    </div>
                </div>

                 <div class="form-group">                    
                    <div class="col-md-12 m-b-20">
                        <input id= "vendor_phone_no" type="text" class="form-control numeric" required="required" value="<?php echo $row['vendor_phone_no']?>"  name="vendor_phone_no"  placeholder="<?php echo get_phrase("enter_vendor_phone_no") ?>" data-validate="required" data-message-required ="<?php echo get_phrase("please_enter_vendor_phone_no") ?>" maxlength="10"> 
                    </div>
                 </div>
                  <div class="form-group">                    
                    <div class="col-md-12 m-b-20">
                    <input id= "vendor_address" type="text" class="form-control" required="required" value="<?php echo $row['vendor_address']?>" name="vendor_address"  placeholder="<?php echo get_phrase("enter_vendor_address") ?>" data-validate="required" data-message-required ="<?php echo get_phrase("please_enter_vendor_address") ?>"> 
                    </div>
                  </div>
                 <div class="form-group">                    
                    <div class="col-md-12 m-b-20">
                        <input type="text" class="form-control datepicker" required="required" value="<?php echo $row['date_of_service']; ?>" disabled="disabled">
                    </div>
                    </div>
                     <div class="form-group">                    
                    <div class="col-md-12 m-b-20"></label>  
                        <input id= "reason" type="text" class="form-control" required="required"  name="reason" value="<?php echo $row['reason_for_service']; ?>"   placeholder="Enter Reason" data-validate="required" data-message-required ="Please enter a reason">
                    </div>
                     </div>
                     <div class="form-group">                    
                    <div class="col-md-12 m-b-20"></label>  
                        <input id="cost_for_service" type="text" required="required" class="form-control numeric"  name="cost_for_service"  placeholder="<?php echo get_phrase('cost_for_service');?>" data-validate="required" data-message-required ="<?php echo get_phrase('Please enter a cost for_service'); ?>">
                    </div>
                     </div>
<!--
        <div class="col-md-6 form-group">
                                            <label for="exampleInputuname">User Name</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="ti-user"></i></div>
                                                <input type="text" class="form-control" id="exampleInputuname" placeholder="Username"> </div>
                                        </div>-->
       
       
                     <div class="form-group"> <label for="exampleInputuname">Payment Type</label>                   
                    <span class="error mandatory"> *</span>
                  <div class="radio radio-success">
                    <input type="radio" name="payment_type" value="credit" required>
                    <label class="p-l-10 p-r-20" for="radio14"><?php echo get_phrase('credit'); ?></label>
                    <input type="radio" name="payment_type" value="cash" required >
                    <label class="p-l-10 p-r-15" for="radio14"><?php echo get_phrase('cash'); ?></label> 
                  </div>  
                    </div>
                     <div class="form-group">                    
                    <div class="col-md-12 m-b-20">
                        <input type="text" class="form-control mydatepicker" value="<?php echo date('d/m/Y H:i:s'); ?>" disabled="disabled" placeholder="Return Date From Service">
                    </div>
                     </div>
       <div class="form-group">
                    <div class="pull-right">
                        <!--<input  type="submit" class="btn btn-info waves-effect" value="Submit"/>-->
                        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit'); ?></button>
<!--                        <button type="button" class="fcbtn btn btn-default btn-outline btn-1d" data-dismiss="modal">Cancel</button>-->
                    </div>
       </div>                  
                <?php echo form_close(); } ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function () {
        $(".numeric").numeric();
    });
</script>
