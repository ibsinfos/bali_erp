<div class="row white-box">
    <?php echo form_open(base_url() . 'index.php?alumni/register', array('class' => 'form-horizontal form-groups-bordered', 'enctype' => 'multipart/form-data', 'id' => 'addAlumniform')); ?>
    <div class="col-md-12">        
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title" >
                    <i class="entypo-plus-circled"></i>
                    <font style="color: #FFF;"><?php echo get_phrase('alumni_registration_form'); ?></font>
                </div>
            </div>
            
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="advance1">                    
                        <div class="form-group" >
                            <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('email_id'); ?></label>
                            <div class="col-sm-3">                                   
                                <input type="text" class="form-control" id="email" name="email_id" required value="">
                            </div>
                            <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('first_name'); ?></label> 
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="first_name" name="first_name" value="">
                            </div>
                            <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('last_name'); ?></label> 
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="last_name" name="last_name" value="">
                            </div>
                        </div>      
                    
                        <div class="form-group">
                            <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('gender'); ?></label>
                            <div class="col-sm-3">
                                <select name="gender" class="selectpicker" data-style="form-control" data-live-search="true" data-validate="required" >
                                    <option value=""><?php echo get_phrase('select'); ?></option>
                                    <option value="Male"><?php echo get_phrase('male'); ?></option>
                                    <option value="Female"><?php echo get_phrase('female'); ?></option>
                                </select>
                            </div>                 
                            <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('date_of_birth'); ?></label>
                            <div class="col-sm-3">
                                <input type="password" class="form-control" id="txtNewPassword" name="password" value="" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" data-start-view="2">
                            </div>
                            <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('enroll_no'); ?></label>
                            <div class="col-sm-3">
                                <input type="password" class="form-control" id="txtConfirmPassword" name="re_password"   value="" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" data-start-view="2">
                                <div class="col-sm-4" id="divCheckPasswordMatch"> </div>
                            </div> 

                        </div>
                    
                        <div class="form-group">
                            <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('date_of_birth'); ?></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control datepicker" name="birthday" onchange="return agecalculate();" value="" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>">
                            </div>                     
                            <label for="field-2" class="col-sm-1 control-label"><?php echo get_phrase('gender'); ?></label>
                            <div class="col-sm-3">
                                <select name="gender" class="selectpicker" data-style="form-control" data-live-search="true" data-validate="required" >
                                    <option value=""><?php echo get_phrase('select'); ?></option>
                                    <option value="Male"><?php echo get_phrase('male'); ?></option>
                                    <option value="Female"><?php echo get_phrase('female'); ?></option>
                                </select>
                            </div> 
                            <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('Religion'); ?></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="religion"   value="" data-start-view="2">
                            </div>                         
                        </div>
                    
                        <div class="form-group">
                            <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('nationality'); ?></label>
                            <div class="col-sm-6">
                                <select id="" name ="nationality" class="selectpicker bfh-countries" data-style="form-control" data-live-search="true" data-country="US"></select>
                            </div>

                            <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('blood_group'); ?></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="blood_group" value="" >
                            </div>
                        </div>
                </div>
                <div class="tab-pane" id="advance6">
                    <div class="form-group">
                    <label for="field-2" class="col-sm-1 control-label"><?php echo get_phrase('upload_photo'); ?></label>

                    <div class="col-md-3">
                    <div class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title" >
                                <i class="entypo-picture"></i>
                                <?php echo get_phrase('photo'); ?>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="fileinput fileinput-new" data-provides="fileinput" style="width: 100%;display: block;">
                                        <div class="fileinput-new thumbnail" data-trigger="fileinput">
                                            <img src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg" alt="..." style="width: 250px;">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="width: 100%;"></div>
                                        <div>
                                            <span class="btn btn-white btn-file">
                                                <span class="fileinput-new">Select Image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="userfile" accept="image/*">
                                            </span>
                                            <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 50px;">
                    <div class="col-sm-offset-5 col-sm-7">
                        <button type="submit" class="btn btn-primary"><?php echo get_phrase('add_teacher'); ?></button>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>

<?php //echo form_close(); ?>
    
<?php echo form_close(); ?>
</div>
<script type="text/javascript">
    
    function checkPasswordMatch() { //alert('hello');
    var password = $("#txtNewPassword").val();
    var confirmPassword = $("#txtConfirmPassword").val();

    if (password != confirmPassword)
        $("#divCheckPasswordMatch").html('<font color="error">Passwords do not match!</span>');            
    else
        $("#divCheckPasswordMatch").html('<font color="error">Passwords match!</span>');
    }

    $(document).ready(function () {
       $("#txtConfirmPassword").keyup(checkPasswordMatch);
    });

    
    $(function(){
        $(".datepicker").datepicker({ dateFormat: "dd/mm/yy",
            changeMonth: true,
            changeYear: true,
            endDate: '+0d',
            autoclose: true
        });
    });
    function agecalculate(){    
            var dob = $(".datepicker").val();
            var now = new Date();
            var d = new Date();
            var year = d.getFullYear() - 18;
            d.setFullYear(year);
            var birthdate = dob.split("/");
            var born = new Date(birthdate[2], birthdate[1]-1, birthdate[0]);
            age=get_age(born,now);
            if (age<=18)
            {
                alert("Age should be greater than or equal to 18");
                return false;
            }
    }
    function get_age(born, now) {
        var birthday = new Date(now.getFullYear(), born.getMonth(), born.getDate());
        if (now >= birthday) 
          return now.getFullYear() - born.getFullYear();
        else
          return now.getFullYear() - born.getFullYear() - 1;
    }
     
    function get_class_sections(class_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_class_section/' + class_id,
            success: function (response)
            {
                jQuery('#section_selector_holder').html(response);
            }
        });
    }

    
</script>


<script type="text/javascript">
    $( function(event, ui){
    $("#tabs").tabs({
        beforeActivate: function(event, ui) {
            var $content = ui.oldTab;
            var $input = $content.find('input.i');
            if (!$input.length)
            return true;
            if ($input.val()) {
            return true
            } else {
            console.log('not allowed')
            return false
            }
        }
    });
    });
</script>
