<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">            
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?php echo get_phrase('add_bus_admin'); ?></h4>
            </div>
            <div class="panel-body" id="tabs">
                <?php echo form_open(base_url() . 'index.php?school_admin/bus_admin/create', array('class' => 'form-horizontal form-material form-groups-bordered validate', 'enctype' => 'multipart/form-data', 'id' => 'addBusAdmin')); ?>
               <div class="form-group">
                    <div class="col-md-12 m-b-20">
                        <label><?php echo get_phrase('name'); ?><span class="mandatory"> *</span></label>
                        <input type="text" class="form-control" placeholder="Please Enter Name" name="name" id="bus_admin_name" data-validate="required" data-message-required ="<?php echo get_phrase('value_required'); ?>" required="required">
                        <span id="error_bus_admin_name" class="mandatory"></span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12 m-b-20">
                        <label><?php echo get_phrase('email'); ?><span class="mandatory"> *</span></label>
                        <input data-validate="required" id="bus_admin_email" placeholder="Please Enter Email" type="text" class="form-control" name="email" value=""  data-validate="required" data-message-required ="<?php echo get_phrase('value_required'); ?>" required="required">
                        <span id="error_bus_admin_email" class="mandatory"></span>
                    </div>
                </div>

                <div class="form-group">
                    
                    <div class="col-md-12 m-b-20">
                        <label><?php echo get_phrase('password'); ?><span class="mandatory"> *</span></label>
                        <input data-validate="required" type="password" placeholder="Please Enter Password" class="form-control" name="password" value="" id="bus_admin_password"  data-validate="required" data-message-required ="<?php echo get_phrase('value_required'); ?>" required="required">
                        <span id="bus_admin_password" class="mandatory"></span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12 m-b-20">
                        <label><?php echo get_phrase('phone'); ?><span class="mandatory"> *</span></label>
                        <input type="text" class="form-control" name="phone" value="" placeholder="Please Enter Phone" maxlength="10" onkeypress='return valid_only_numeric(event);' data-validate="required" data-message-required ="<?php echo get_phrase('value_required'); ?>" required="required" >
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-12 m-b-20">
                        <label><?php echo get_phrase('gender'); ?><span class="mandatory"> *</span></label>
                        <select name="gender" class="selectpicker1" data-style="form-control" data-live-search="true" required="required">
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                </div>
                 <div class="form-group">
                    <div class="col-sm-12 text-right">
                        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" onclick='$("#tabs").tabs("select", "tabs-2")'><?php echo get_phrase('add_bus_admin'); ?></button>
                    </div>
                </div>           
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
function valid_only_numeric(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>
<script>
    $('#submit').on('click', function() {
    var email = document.getElementById('bus_admin_email').value;
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
   
   if (!filter.test(email)) {
    $('#error_bus_admin_email').html('Please provide a valid email address').show();
    return false;
    }  
   
       var email = document.getElementById('bus_admin_email').value;
       validate_email(encodeURIComponent(email));        
   function validate_email(email) {
       $('#error_bus_admin_email').hide();
       
        mycontent = $.ajax({
            async       :   false,
            dataType    :   'json',
            type        :   'POST',
            url         :   "<?php echo base_url(); ?>index.php?Ajax_controller/check_email_exist_allusers/",
            data        :   { email:email },
            success     : function(response){ 
                if (response.email_exist == "1") { 
                    $('#error_bus_admin_email').html(response.message).show();
                    return false;
                }
                else{
                    $('#error_bus_admin_email').html("").show();
                
             }
            },
         });
        }
       var chk_value = document.getElementById('error_bus_admin_email').innerHTML;
    if(chk_value==''){
    return true;
    }
        else{
        return false;
        }

    } 
    );
    
</script>