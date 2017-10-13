<div class="row bg-title"> 
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>


<?php echo form_open(base_url() . 'index.php?school_admin/parent_add/create/', array('class' => 'validate', 'id' => 'add_parent_form', 'enctype' => 'multipart/form-data')); ?>
<?php //if (isset($msg)) { ?>        
<!--    <div class="alert alert-danger">
        <?php //echo $msg; ?>
    </div>-->
<?php //} ?>
<div class="row white-box">
    <div class="form-group col-sm-12 p-0 white-box" data-step="5" data-intro="<?php echo get_phrase('Here you fill parent \'s information.');?>" data-position='top'>
        <div class="row">
            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="fname"><?php echo get_phrase("father's_name"); ?><span class="error" style="color: red;"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="ti-user"></i></div>
                        <input type="text" class="form-control" id="fname" name="fname" placeholder="Father's First Name" value="<?php echo set_value('fname'); ?>"    >
                    </div>
                </div>
                <span class="mandatory"> <?php echo form_error('fname'); ?></span>
            </div>

            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="fmname"><?php echo get_phrase("middle_name"); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="ti-user"></i></div>
                        <input type="text" class="form-control" id="fmname" name="fmname" placeholder="Father's Middle Name" value="<?php echo set_value('fmname'); ?>" >
                    </div>
                </div>
            </div>

            <div class="col-sm-4 form-group">
                <div class="form-group">
                    <label for="flname"><?php echo get_phrase("last_name"); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="ti-user"></i></div>
                        <input type="text" class="form-control" id="flname" name ="flname" placeholder="Father's Last Name" value="<?php echo set_value('flname'); ?>"   > 
                    </div>
                </div>
                <span class="mandatory"> <?php echo form_error('flname'); ?></span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="mname"><?php echo get_phrase("mother's_name"); ?><span class="error" style="color: red;"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-female"></i></div>
                        <input type="text" class="form-control" id="mname" name="mname" placeholder="Mother's First Name" value="<?php echo set_value('mname'); ?>"  >       
                    </div>
                </div>
                <span class="mandatory"> <?php echo form_error('mname'); ?></span>
            </div>

            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="mmname"><?php echo get_phrase("middle_name"); ?></label><div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-female"></i></div>
                        <input type="text" class="form-control" id="mmname" name="mmname" placeholder="Mother's Middle Name" value="<?php echo set_value('mmname'); ?>" >
                    </div></div></div>

            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="mlname"><?php echo get_phrase("last_name"); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-female"></i></div>

                        <input type="text" class="form-control" id="mlname" name= "mlname" placeholder="Mother's Last Name" value="<?php echo set_value('mlname'); ?>"  > 
                    </div>
                </div>
                <span class="mandatory"> <?php echo form_error('mlname'); ?></span>
            </div>
        </div>

        <div class="row">

            <div class="col-sm-4 form-group">
                <div class="form-group">
                    <label for="email"><?php echo get_phrase("user_email"); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter a valid email" value="<?php echo set_value('email'); ?>"  >       
                        <span id="parent_email_error" style="color: red;" ></span>
                        <span class="mandatory"> <?php echo form_error('email'); ?></span>
                    </div></div>
            </div>

  <!--<label for="usrPswd" class="col-sm-1 col-form-label"><?php //echo get_phrase("password");     ?><span class="error" style="color: red;"> *</span></label>
  <div class="col-sm-3">
      <input type="password" class="form-control" id="password" name="password" placeholder="Enter a password"   >
  </div>
  
  <label for="conmPswd" class="col-sm-1 col-form-label"><?php //echo get_phrase("password_retype");     ?><span class="error" style="color: red;"> *</span></label>
  <div class="col-sm-3">
      <input type="password" class="form-control" id="re_password" name="re_password" placeholder="Re-enter Password"  > 
      <div class="col-sm-12" id="divCheckPasswordMatch"> </div>
  </div>
  !-->

            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="fqual"><?php echo get_phrase("father's_qualification"); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-graduation-cap"></i></div>

                        <input type="text" class="form-control" id="fqual" name="fqual" placeholder="Father's Qualification" value="<?php echo set_value('fqual'); ?>"  >       
                    </div>
                </div>
                <span class="mandatory"> <?php echo form_error('fqual'); ?></span>
            </div>

            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="fprof"><?php echo get_phrase("father's_profession"); ?><span class="error" style="color: red;"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-briefcase"></i></div>
                        <input type="text" class="form-control" id="fprof" name="fprof" placeholder="Father's Profession" value="<?php echo set_value('fprof'); ?>"   >
                    </div></div>
                <span class="mandatory"> <?php echo form_error('fprof'); ?></span>
            </div>
        </div>

        <div class="row">

            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="fpass_no"><?php echo get_phrase("father's_passport"); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-id-card"></i></div>
                        <input type="text" class="form-control" id="fpass_no" name= "fpass_no" placeholder="Father's Passport No" value="<?php echo set_value('fpass_no'); ?>" > 
                    </div></div></div>


            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="mqual"><?php echo get_phrase("mother's_qualification"); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-graduation-cap"></i></div>
                        <input type="text" class="form-control" id="mqual" name="mqual" placeholder="Mother's Qualification" value="<?php echo set_value('mqual'); ?>"  >       
                    </div>
                </div>
                <span class="mandatory"> <?php echo form_error('mqual'); ?></span>
            </div>

            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="mprof"><?php echo get_phrase("mother's_profession"); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-briefcase"></i></div>
                        <input type="text" class="form-control" id="mprof" name="mprof" placeholder="Mother's Profession" value="<?php echo set_value('mprof'); ?>" >
                    </div></div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="mpass_no"><?php echo get_phrase("mother's_passport"); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-id-card"></i></div>
                        <input type="text" class="form-control" id="mpass_no" name= "mpass_no" placeholder="Mother's Passport No" value="<?php echo set_value('mpass_no'); ?>" > 
                    </div></div>
            </div>


            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="ficard_no"><?php echo get_phrase("father's_id"); ?><span class="error" style="color: red;">*</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-id-card"></i></div>
                        <input type="text" class="form-control" id="ficard_no" name="ficard_no" placeholder="Father's Identity Card No" value="<?php echo set_value('ficard_no'); ?>"  =" ">       
                    </div></div></div>

            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="ficard_type"><?php echo get_phrase("father's_id_type"); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-id-badge"></i></div>
                        <input type="text" class="form-control" id="ficard_type" name="ficard_type" placeholder="Card Type"value="<?php echo set_value('ficard_type'); ?>" >
                    </div></div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="micard_no"><?php echo get_phrase("mother's_id"); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-id-card"></i></div>
                        <input type="text" class="form-control" id="micard_no" name= "micard_no" placeholder="Mother's Identity Card No" value="<?php echo set_value('fname'); ?>" > 
                    </div></div></div>

            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="micard_type" class="col-form-label"><?php echo get_phrase("mother's_icard_type"); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-id-badge"></i></div>
                        <input type="text" class="form-control" id="micard_type" name= "micard_type" placeholder="Card Type" value="<?php echo set_value('micard_type'); ?>" > 
                    </div></div></div>

            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="address"><?php echo get_phrase("address"); ?><span class="error" style="color: red;"> *</span></label>
                    <textarea class="form-control" rows="1" cols="23" name="address" value="<?php echo set_value('address'); ?>"  ></textarea>   
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="country" class="col-form-label"><?php echo get_phrase("country"); ?><span class="error" style="color: red;"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-globe"></i></div>
                        <select class="selectpicker" data-style="form-control" data-live-search="true" id="country" name= "country" onchange="get_state()">
                            <option value="">Select Country</option>
                            <?php if (count($CountryList)) {
                                foreach ($CountryList as $country) { ?>
                                    <option value="<?php echo $country['location_id']; ?>"><?php echo ucwords($country['name']); ?></option><?php }
                            } ?>
                        </select>
                    </div>
                </div>
                <span class="mandatory"> <?php echo form_error('country'); ?></span>
            </div>

            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="state"><?php echo get_phrase("state"); ?><span class="error" style="color: red;"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-globe"></i></div>
                        <select class="selectpicker" data-style="form-control" data-live-search="true" name='state' id ='state'  >
                            <option value="">Select State</option>
                        </select>

                    </div>
                </div>
            </div>

            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="city"><?php echo get_phrase("city"); ?><span class="error" style="color: red;"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-globe"></i></div>
                        <input type="text" class="form-control" id="city" name="city" placeholder="Current City" value="<?php echo set_value('city'); ?>"  >       
                    </div>
                </div>
                <span class="mandatory"> <?php echo form_error('city'); ?></span>
            </div>    
        </div>

        <div class="row">

            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="zip_code" class="col-form-label"><?php echo get_phrase("zip_code"); ?><span class="error" style="color: red;"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-codepen"></i></div>
                        <input type="number" class="form-control numeric" id="zip_code" name= "zip_code" placeholder="Zip code" value="<?php echo set_value('zip_code'); ?>"   maxlength="10"> 
                    </div>
                </div>
                <span class="mandatory"> <?php echo form_error('zip_code'); ?></span>
            </div>

            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="phone"><?php echo get_phrase("mobile_#"); ?><span class="error" style="color: red;"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-mobile"></i></div>
                        <input type="tel" class="form-control numeric" onkeypress="return isNumberKey(event)" id="phone" name="phone" placeholder="Mobile Number" value="<?php echo set_value('phone'); ?>" maxlength="10"  >       
                    </div></div>
                <span class="mandatory"> <?php echo form_error('phone'); ?></span>
            </div>

            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="home_phone"><?php echo get_phrase("home_#"); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-phone" ></i></div>
                        <input type="tel" class="form-control numeric" onkeypress="return isNumberKey(event)" id="home_phone" name="home_phone" placeholder="Landline Number" value="<?php echo set_value('home_phone'); ?>" >
                    </div></div></div>
        </div>

        <div class="row">
            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="work_phone"><?php echo get_phrase("office_#"); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-phone" ></i></div>

                        <input type="tel" class="form-control numeric" onkeypress="return isNumberKey(event)" id="work_phone" name= "work_phone" placeholder="Office Number" value="<?php echo set_value('work_phone'); ?>"> 
                    </div></div></div>


            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="guardian_first_name" class="col-form-label"><?php echo get_phrase("guardian_first_name"); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="ti-user"></i></div>
                        <input type="text" class="form-control" id="guardian_first_name" name="guardian_first_name" placeholder="First Name" value="<?php echo set_value('guardian_first_name'); ?>" >       
                    </div></div></div>

            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="guardian_last_name" class="col-form-label"><?php echo get_phrase("guardian_last_name"); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="ti-user"></i></div>
                        <input type="text" class="form-control" id="guardian_last_name" name="guardian_last_name" placeholder="Last Name" value="<?php echo set_value('guardian_last_name'); ?>" >
                    </div></div></div>
        </div>

        <div class="row">
            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="guradian_profession" class="col-form-label"><?php echo get_phrase("guardian_profession"); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-briefcase"></i></div>
                        <input type="text" class="form-control" id="guradian_profession" name= "guradian_profession" placeholder="Profession" value="<?php echo set_value('guradian_profession'); ?>" > 
                    </div></div></div>

            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="guardian_address" class="col-form-label"><?php echo get_phrase("guardian_address"); ?></label>      

                    <textarea class="form-control" rows="1"  name="guardian_address" value="<?php echo set_value('guardian_address'); ?>" ></textarea>    
                </div></div>

            <div class="col-md-4 form-group">
                <div class="form-group">
                    <label for="guradian_email"><?php echo get_phrase("guradian_email"); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                        <input type="email" class="form-control" id="guradian_email" name="guradian_email" placeholder="Email" value="<?php echo set_value('guradian_email'); ?>" >
                    </div></div></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 form-group">
            <div class="form-group">
                <label for="emergency_contact"><?php echo get_phrase("emergency_contact"); ?><span class="error" style="color: red;"> *</span> </label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-volume-control-phone"></i></div>
                    <input type="tel" class="form-control numeric" onkeypress="return isNumberKey(event)" id="emergency_contact" name= "emergency_contact"   title="Please enter any mobile number for emergency contact" placeholder="Emergency Contact Number" value="<?php echo set_value('emergency_contact'); ?>" maxlength="10"> 
                </div></div>
        <span class="mandatory"> <?php echo form_error('emergency_contact'); ?></span>
        </div>

        <div class="text-right col-xs-12 p-t-20" >
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d">Add Parent</button>
        </div>

    </div>




<?php echo form_close(); ?>
</div>


<script type="text/javascript">
    function checkPasswordMatch() {
        var password = $("#password").val();
        var confirmPassword = $("#re_password").val();

        if (password != confirmPassword)
            $("#divCheckPasswordMatch").html('<font color="error">Passwords do not match!</span>');
        else
            $("#divCheckPasswordMatch").html('<font color="success">Passwords match!</span>');
    }



    function validate_email(email) {
        $('#parent_email_error').hide();
        email = encodeURIComponent(email);
        mycontent = $.ajax({
            async: false,
            dataType: 'json',
            type: 'POST',
            url: "<?php echo base_url(); ?>index.php?Ajax_controller/check_email_exist_allusers/",
            data: {email: email},
            success: function (response) {
                if (response.email_exist == "1") {
                    $('#parent_email_error').html(response.message).show();
                    $('#email').val('');
                    $('#email').focus();
                    return false;
                } else {
                    return true;
                }
            },
            error: function (error_param, error_status) {

            }
        });


    }

    $(document).ready(function () {
        $('#email').change(function () {
            email = $(this).val();
            validate_email(email);
        });

    });

</script>
<script type="text/javascript">
    jQuery(document).ready(function () {
        $(".numeric").numeric();
    });

    function get_state() {
        var CountryId = $('#country').val();
        if (CountryId != '') {
            var state = '<option value="">Select State</option>';
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?ajax_controller/get_state',
                type: 'POST',
                data: {CountryId: CountryId},
                success: function (response) {
                    if (response) {
                        data = JSON.parse(response);
                        if (data.length) {
                            for (k in data) {
                                state += '<option value="' + data[k]['location_id'] + '">' + data[k]['name'] + '</option>';
                            }
                        } else {
                            alert('State not found');
                        }
                    } else {
                        alert('State not found');
                    }
                    $('#state').empty();
                    $('#state').html(state);
                },
                error: function () {
                    alert('State not found');
                    $('#state').empty();
                    $('#state').html(state);
                }
            });
        }
    }
</script>
<SCRIPT language=Javascript>
    <!--
      function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
    //-->
   </SCRIPT>