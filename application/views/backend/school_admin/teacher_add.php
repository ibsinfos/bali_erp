<div class="row">
    <?php echo form_open(base_url() . 'index.php?school_admin/teacher/create/', array('class' => 'form-horizontal form-groups-bordered', 'enctype' => 'multipart/form-data', 'id' => 'addTeacherform')); ?>
    <div class="col-md-12">        
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title" >
                    <i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('add_new_teacher'); ?>
                </div>
            </div>
            
            <div class="panel-body" id="tabs">
                <ul class="nav nav-tabs bordered" style="margin: 0px 0px 15px 0px;">
                    <li class="active">
                        <a href="#advance1" data-toggle="tab" >
                            <span class="visible-xs"><i class="entypo-users"></i></span>
                            <span class="hidden-xs"><?php echo get_phrase('personal_information'); ?></span>
                        </a>
                    </li>
                    <li class="">
                        <a href="#advance2" data-toggle="tab" >
                            <span class="visible-xs"><i class="entypo-user"></i></span>
                            <span class="hidden-xs"><?php echo get_phrase('contact_information'); ?></span>
                        </a>
                    </li>
                    <li class="">
                        <a href="#advance3" data-toggle="tab">
                            <span class="visible-xs"><i class="entypo-user"></i></span>
                            <span class="hidden-xs"><?php echo get_phrase('qualification_&_experience'); ?></span>
                        </a>
                    </li>
                    
                    <li class="">
                        <a href="#advance4" data-toggle="tab">
                            <span class="visible-xs"><i class="entypo-user"></i></span>
                            <span class="hidden-xs"><?php echo get_phrase('ID_information'); ?></span>
                        </a>
                    </li>
                    
                    <li class="">
                        <a href="#advance6" data-toggle="tab">
                            <span class="visible-xs"><i class="entypo-users"></i></span>
                            <span class="hidden-xs"><?php echo get_phrase('photo'); ?></span>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                <div class="tab-pane active" id="advance1">
                    
                    <div class="form-group">
                        
                        <label for="field-2" class="col-sm-1 control-label"><?php echo get_phrase("Emp_id"); ?></label>
                        <div class="col-sm-11">
                            <input type="text" class="form-control" name="emp_id" value="<?php echo substr(md5(rand(0, 1000000)), 0, 3);?>" readonly>
                        </div>
                    </div>
                    
                    
                    <div class="form-group" >
                        <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('first_name'); ?></label>
                        <div class="col-sm-3">                                   
                            <input type="text" class="form-control" id="name" name="first_name" required value="">
                        </div>
                        <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('middle_name'); ?></label> 
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id = "middle_name"  name="middle_name" value="" autofocus>
                        </div>
                        <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('last_name'); ?></label> 
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="last_name" name="last_name"  value="" autofocus>
                        </div>
                    </div>      
                    
                    <div class="form-group">
                        <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('email'); ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id= 'email' name="email" value="" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" data-start-view="2">
                        </div>                     
                        <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('password'); ?></label>
                        <div class="col-sm-3">
                            <input type="password" class="form-control" id="txtNewPassword" name="password" value="" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" data-start-view="2">
                        </div>
                        <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('verify_password'); ?></label>
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
                   
                    <!--p>
                        <input type="submit" value="NEXT" onclick="location.href='#advance3';" /> 
                    </p-->
                              
                </div>
                  
                <div class="tab-pane" id="advance2"> 
                    <div class="form-group">
                        <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('present_address'); ?></label>
                        <div class="col-sm-11">
                            <textarea class="form-control" rows="1" cols="23" name="present_address"  value="" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>">  </textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">                        
                        <label for="field-2" class="col-sm-1 control-label"><?php echo get_phrase('country'); ?></label>
                        <div class="col-sm-5">
                            <select id="countries_states1" name ="country" class="selectpicker bfh-countries" data-style="form-control" data-live-search="true" data-country="US"></select>
                        </div> 
                        <label for="field-2" class="col-sm-1 control-label"><?php echo get_phrase('state'); ?></label>
                        <div class="col-sm-5">
                            <select  name ="state" class="selectpicker bfh-states" data-style="form-control" data-live-search="true"data-country="countries_states1" data-state="Select State"></select>
                            
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="field-2" class="col-sm-1 control-label"><?php echo get_phrase('city'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="city" value="" >
                        </div>
                        
                        <label for="field-2" class="col-sm-1 control-label"><?php echo get_phrase('zip_code'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="zip_code" value="" >
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="field-2" class="col-sm-1 control-label"><?php echo get_phrase('Mobile_#'); ?></label>
                        <div class="col-sm-3">
                            <input type="tel" class="form-control" name="mobile_phone" data-validate="required" value="" required maxlength="12" >
                        </div> 
                        <label for="field-2" class="col-sm-1 control-label"><?php echo get_phrase('Residence_#'); ?></label>
                        <div class="col-sm-3">
                            <input type="tel" class="form-control" name="home_phone"  value="" pattern="[\+]\d{3}[\-]\d{5-9}" title="Phone Number (Format: +999-999999)" >
                        </div><label for="field-2" class="col-sm-1 control-label"><?php echo get_phrase('Work_#'); ?></label>
                        <div class="col-sm-3">
                            <input type="tel" class="form-control" name="work_phone" value=""  pattern="[\+]\d{3}[\-]\d{5-9}" title="Phone Number (Format: +999-999999)" >
                        </div>
                        
                    </div>
                </div>    
                    
                <div class="tab-pane" id="advance3">
                    <div class="form-group">
                        <label for="field-2" class="col-sm-1 control-label"><?php echo get_phrase('job_title'); ?></label>
                        <div class="col-sm-11">
                            <input type="text" class="form-control" name="job_title" value="" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-2" class="col-sm-1 control-label"><?php echo get_phrase('Specialization'); ?></label>
                        <div class="col-sm-3">
                            <select name="stream" class="selectpicker" data-style="form-control" data-live-search="true" data-validate="required">
                                <option value="">Select Subject</option>
                                <?php
                                $subjects = $this->db->get('subject')->result_array();
                                foreach ($subjects as $row): ?>
                                <option value ="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <label for="field-2" class="col-sm-1 control-label"><?php echo get_phrase('Highest_degree'); ?></label>
                        <div class="col-sm-3">
                            <select name="qualification" class="selectpicker" data-style="form-control" data-live-search="true" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>">
                                <option value=""><?php echo get_phrase('-Select--'); ?></option>
                                <option value="Phd"><?php echo get_phrase('Phd'); ?></option>
                                <option value="MCA"><?php echo get_phrase('MCA'); ?></option>
                                <option value="M.A"><?php echo get_phrase('M A'); ?></option>
                                <option value="MBA"><?php echo get_phrase('MBA'); ?></option>
                                <option value="B.Tech"><?php echo get_phrase('B.Tech'); ?></option>
                                <option value="M.Sc"><?php echo get_phrase('M.Sc'); ?></option>
                                <option value="M.Tech"><?php echo get_phrase('M.Tech'); ?></option>
                                <option value="M.Phill"><?php echo get_phrase('M.Phill'); ?></option>
                                <option value="B.Sc"><?php echo get_phrase('B.Sc'); ?></option>                                
                            </select>
                        </div> 
                   
                        <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('Total_expereince'); ?></label>
                        <div class="col-sm-3">
                            <select name="expereince" class="selectpicker" data-style="form-control" data-live-search="true"  data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>">
                                <option value=""><?php echo get_phrase('select'); ?></option>
                                <option value="0-2"><?php echo get_phrase('0-2 years'); ?></option>
                                <option value="2-4"><?php echo get_phrase('2-4 years'); ?></option>
                                <option value="4-6"><?php echo get_phrase('4-6 years'); ?></option>
                                <option value="6+"><?php echo get_phrase('6+ years'); ?></option>
                            </select>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('employment_history'); ?></label>
                        <div class="col-sm-11">
                            <textarea class="form-control" rows="1" cols="23" name="summary" required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('Hours_&_awards'); ?></label>
                        <div class="col-sm-11">
                            <textarea class="form-control" rows="1" cols="23" name="awards" required></textarea>
                        </div>
                    </div>
                  
                </div>           

                <div class="tab-pane" id="advance4"> 
                    <div class="form-group">
                        <label for="field-2" class="col-sm-1 control-label"><?php echo get_phrase('Card_ID'); ?></label>
                        <div class="col-sm-11">
                            <input type="text" class="form-control" name="card_id" value="" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>">
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('passport_number'); ?></label>
                        <div class="col-sm-11">
                            <input type="text" class="form-control" name="passport_no" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" value="" autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('icard_no'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="icard_no" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" value="" autofocus>
                        </div>
                        <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase('icard_type'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="type" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" value="" autofocus>
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


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMYxg14UXa4Hw27bLPNJkPF9_ntDrDLJA&libraries=places"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="assets/new_assets/js/bootstrap-formhelpers.min.js"></script>
<script src="assets/new_assets/css/bootstrap-formhelpers.min.css"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>


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
