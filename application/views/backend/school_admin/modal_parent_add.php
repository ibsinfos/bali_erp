<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('add_parent'); ?>
                </div>
            </div>
            <div class="panel-body">

                <?php echo form_open(base_url() . 'index.php?school_admin/parent/create/', array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data')); ?>

            
                <div class="form-group">
                    <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase("father's_name"); ?></label>
                    <div class="col-sm-3" >
                        
                        <input type="text" class="form-control" name="fname" value="" required>
                    </div>
                    
                    <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('middle_name'); ?></label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="fmname" value="">
                    </div>
                    
                    <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('last_name'); ?></label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="flname" value="" required >
                    </div>
                </div>
                
                
                <div class="form-group">
                    <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase("mother's_name"); ?></label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="mname" value="" required>
                    </div>
                    
                    <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('middle_name'); ?></label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="mmname"  value="">
                    </div>
                    
                    <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('last_name'); ?></label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="mlname" value="" required>
                    </div>
                </div>
                                
                
                <div class="form-group">
                    <label for="field-1" class="col-sm-2 control-label"><?php echo get_phrase('email'); ?></label>
                        <div class="col-sm-10">
                            <input id="parentemail" type="email" class="form-control" name="email" value="" required >
                        </div>
                </div>
                
                 <div class="form-group">
                    <label for="field-1" class="col-sm-2 control-label"><?php echo get_phrase('password'); ?></label>
                        <div class="col-sm-4">
                            <input type="password" data-minlength="6" id="txtNewPassword" name = 'password' class="form-control" required>
                        
                        </div>
                    <label for="field-1" class="col-sm-2 control-label"><?php echo get_phrase('confirm_password'); ?></label>
                        <div class="col-sm-4">
                        <input type="password" class="form-control" id="txtConfirmPassword"  name = 'password' required>                                        
                        </div>
                        <div class="col-sm-4" id="divCheckPasswordMatch"> </div>
                </div>
                
                <div class="form-group">
                    <label for="field-1" class="col-sm-2 control-label"><?php echo get_phrase("father's_profession"); ?></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="fprof" value="" required>
                    </div>
                    <label for="field-1" class="col-sm-2 control-label"><?php echo get_phrase("mother's_profession"); ?></label>
                    <div class="col-sm-4">
                        <input  type="text" class="form-control" name="mprof" value="" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="field-1" class="col-sm-2 control-label"><?php echo get_phrase("father's_qualification"); ?></label>
                    <div class="col-sm-4">
                        <input id="" type="text" class="form-control" name="fqual" value="" required>
                    </div>
                    <label for="field-1" class="col-sm-2 control-label"><?php echo get_phrase("mother's_qualification"); ?></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="mqual" value="" required>
                    </div>
                </div>
                                             
                
                <div class="form-group">
                    <label for="field-1" class="col-sm-2 control-label"><?php echo get_phrase("father's_passport#"); ?></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="fpass_no" value="" required>
                    </div>
                    <label for="field-1" class="col-sm-2 control-label"><?php echo get_phrase("mother's_passport#"); ?></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="mpass_no" value="" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="field-1" class="col-sm-2 control-label"><?php echo get_phrase("father's_ID_card_#"); ?></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="ficard_no" value="" required>
                    </div>
                    <label for="field-1" class="col-sm-2 control-label"><?php echo get_phrase('id_card_type'); ?></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="ficard_type" value="" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="field-1" class="col-sm-2 control-label"><?php echo get_phrase("mother's_ID_card_#"); ?></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="micard_no" value="" required>
                    </div>
                    <label for="field-1" class="col-sm-2 control-label"><?php echo get_phrase('id_card_type'); ?></label>
                    <div class="col-sm-4">
                        <input type="text"  class="form-control" name="micard_type" value="" required>
                    </div>
                </div>
                
                                               
                <div class="form-group">
                    <label for="field-1" class="col-sm-2 control-label"><?php echo get_phrase('street_address'); ?></label>
                    <div class="col-sm-4">
                        <textarea class="form-control" rows="1" cols="23" name="address" required></textarea>
                    </div>                
                    <label for="field-1" class="col-sm-2 control-label"><?php echo get_phrase('city'); ?></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="city" value="" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('state'); ?></label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="state" value="" required>
                    </div>
                    <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('country'); ?></label>
                    <div class="col-sm-3">
                        <input type="text"  class="form-control" name="country" value="" required>
                    </div>
                    <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('zip_code'); ?></label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" name="zip_code" value="" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="field-1" data-validate="required" class="col-sm-1 control-label"><?php echo get_phrase('mobile_#'); ?></label>

                    <div class="col-sm-3">
                        <input type="tel" class="form-control" name="phone" id="phone" value="" required maxlength="12">
                        
                    </div>
                    <label for="field-1" data-validate="required" class="col-sm-1 control-label"><?php echo get_phrase('home_#'); ?></label>

                    <div class="col-sm-3">
                        <input type="tel"class="form-control" name="home_phone" value="" pattern="[\+]\d{3}[\-]\d{5-9}" title="Phone Number (Format: +999-999999)" required >
                    </div>
                    <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('work_#'); ?></label>

                    <div class="col-sm-3">
                        <input type="tel"  class="form-control" name="work_phone" value="" pattern="[\+]\d{3}[\-]\d{5-9}" title="Phone Number (Format: +999-999999)" required> 
                    </div>
                </div>
                           
                <div class="form-group">
                    <div class="col-sm-offset-5 col-sm-5">
                        <button type="submit" class="btn btn-primary"><?php echo get_phrase('add_parent'); ?></button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
function checkPasswordMatch() { //alert('hello');
    $("#divCheckPasswordMatch").html('');            
    var password = $("#txtNewPassword").val();
    var confirmPassword = $("#txtConfirmPassword").val();

    if (password != confirmPassword)
        $("#divCheckPasswordMatch").html('<font color="error">Passwords do not match!</span>');            
    /*else
        $("#divCheckPasswordMatch").html('<font color="error">Passwords match!</span>');*/
}

$(document).ready(function () {
   $("#txtConfirmPassword").keyup(checkPasswordMatch);
   $('#parentemail').on('blur',function(){
       validateemail($(this).val());
   });
   
   $("#phone").on("blur",function(){ 
       validatePhoneWithEmail($("#parentemail").val(),$(this).val());
   });
});

function validateemail(email) { //alert('hfkdf');
    $.post("<?php echo base_url(); ?>index.php?Validate/validate_parrent_email/", {email: email}, function (response) {
        if (response == 'invalid') {
            
            toastr.error(' Please delete parent entry for email address : '+email+' first and then create new one');
            jQuery('#parentemail').val('');
        }
    });
}

function validatePhoneWithEmail(email,phone){
    $.post("<?php echo base_url(); ?>index.php?Validate/validate_parrent_email_phone/", {email: email,phone: phone}, function (response) {
        if (response == 'email_phone_exists') {
            toastr.error(phone+' is elready exists,Please provide a new phone number');<?php //echo get_phrase('curent_phone_number_is_alredy_used,_please_provide_new_phone_number') ?>
            jQuery('#phone').val('');
        }else if (response == 'phone_exists') {
            toastr.error(phone+' is elready exists,Please provide a new phone number');<?php //echo get_phrase('curent_phone_number_is_alredy_used,_please_provide_new_phone_number') ?>
            jQuery('#phone').val('');
        }
    });
}

</script>