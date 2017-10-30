 <div class="row">
	<div class="col-md-12">    
        <!--<div class="">-->
        <?php echo form_open(base_url() . 'index.php?school_admin/manage_vehicle_details/service/'.$param2 ,  array('class' => ' form-material form-groups-bordered validate', 'enctype' => 'multipart/form-data')); ?>

                <div class="form-group">
                     <div class="col-md-12 m-b-20">
                         <label><?php echo get_phrase('vendor_name'); ?><span class="mandatory"> *</span></label>
                   <input id="vendor_name" type="text" class="form-control"  name="vendor_name" required="required"  placeholder="<?php echo get_phrase('enter_vendor_name')?>" data-validate="required" data-message-required ="<?php echo get_phrase('please_enter_vendor_name')?>"> 
                </div>
                </div>
                <div class="form-group">
                  <div class="col-md-12 m-b-20">
                      <label><?php echo get_phrase('phone_no.'); ?><span class="mandatory"> *</span></label>
                    <input id= "vendor_phone_no" type="text" class="form-control numeric" required="required"  name="vendor_phone_no"  placeholder="<?php echo get_phrase("enter_vendor_phone_no")?>" data-validate="required" data-message-required ="<?php echo get_phrase("please_enter_vendor_phone_no")?>" maxlength="10"> 
                </div>
                </div>
                <div class="form-group">
                     <div class="col-md-12 m-b-20">
                         <label><?php echo get_phrase('address'); ?><span class="mandatory"> *</span></label>
                    <input id= "vendor_address" type="text" class="form-control" required="required"  name="vendor_address"  placeholder="<?php echo get_phrase("enter_vendor_address")?>" data-validate="required" data-message-required ="<?php echo get_phrase("please_enter_vendor_address")?>"> 
                </div>
                </div>
                <div class="form-group">
                                    <div class="col-md-12 m-b-20">   
                                        <label><?php echo get_phrase('date'); ?><span class="mandatory"> *</span></label>
                        <input type="text" class="form-control mydatepicker" required="required" value="<?php echo date('d/m/Y H:i:s');?>" disabled="disabled">
                                    </div>
                </div>
                <div class="form-group">
                     <div class="col-md-12 m-b-20">
                         <label><?php echo get_phrase('reason'); ?><span class="mandatory"> *</span></label>
                         <input id= "reason" type="text" class="form-control" required="required"  name="reason"  placeholder="Enter reason" data-validate="required" data-message-required ="Please enter a reason">
                </div>
                </div>
                <div class="form-group">
                    <div class="text-center">
                        <input  type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" value="Send to Service"/>
                    </div>
                    </div>
            <?php echo form_close(); ?>
        </div>
    </div>

<script type="text/javascript">
    jQuery(document).ready(function(){
       $(".numeric").numeric(); 
    });
</script>

<!--For tabs -->
<script src="<?php echo base_url(); ?>assets/js/cbpFWTabs.js"></script>
<script type="text/javascript">
    (function () {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
            new CBPFWTabs(el);
        });
    })();

</script>
