
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-icons/entypo/css/entypo.css">
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.css">

<script src="<?php echo base_url();?>assets/js/jquery-1.11.0.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery-numeric.js"></script>



        <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-icons/font-awesome/css/font-awesome.min.css">
<!--<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>-->
<!--date:13.02 for table responsiveness-->

<!--end-->
        <form method="post" action="<?php echo base_url()?>index.php?global_access/enquiry_submitted"> 
               <div class="panel panel-success" data-collapsed="0" style="border-color:#ddd;">
    <div class="row">
        <div class="col-md-12">        
            <div class="panel panel-success" data-collapsed="0" style="margin-bottom:0px; border-color:#ddd;">
                <div class="panel-heading">
                    <div class="panel-title" >
                        <i class="entypo-info"></i>
                        <?php echo get_phrase('enquiry_form'); ?>
                    </div>
                </div> 
                <div class="col-md-12" style="margin-top:30px;">
              
                <div class="row">
                    <div class="col-md-4 col-sm-6 form-group">
                        <label><?php echo get_phrase("mobile_number");?><span class="error" style="color: red;"> *</span></label>
                        <input class="form-control numeric" type="tel" placeholder="Mobile Number" name="mobile_number" value="<?php echo set_value('mobile_number'); ?>" required id="mobile_number" maxlength="10"/>
                    </div>
                    <!--<div class="col-md-6 form-group">
                        &nbsp;
                    </div>
                    <div style="clear: both;"></div>-->
                    <div class="col-md-4 col-sm-6 form-group">
                        <label for="field-2" class="col-sm-0"><?php echo get_phrase("student's_first_name");?><span class="error" style="color: red;"> *</span></label>
                        
                        <input class="form-control" type="text" placeholder="First Name" name = "student_fname" value="<?php echo set_value('student_fname'); ?>" required />
                    </div>
                    <div class="col-md-4 col-sm-6 form-group">
                        <label for="field-2" class="col-sm-0"><?php echo get_phrase("student's_last_name");?><span class="error" style="color: red;"> *</span></label>
                        <input class="form-control" type="text" placeholder="Last Name" name="student_lname" value="<?php echo set_value('student_lname'); ?>" required/>
                    </div>
                    
                    <div class="col-md-4 col-sm-6 form-group">
                        <label for="field-2" class="col-sm-0"><?php echo get_phrase("father_first_name");?><span class="error" style="color: red;"> *</span></label>
                        <input class="form-control" type="text" placeholder="Father First Name" name="parent_fname" value="<?php echo set_value('parent_fname'); ?>" required/>
                    </div>
                    <div class="col-md-4 col-sm-6 form-group">
                        <label for="field-2" class="col-sm-0"><?php echo get_phrase("father_last_name");?><span class="error" style="color: red;"> *</span></label>
                        <input class="form-control" type="text" placeholder="Father Last Name" name="parent_lname" value="<?php echo set_value('parent_lname'); ?>" required/>
                    </div>
                    
                    <div class="col-md-4 col-sm-6 form-group">
                        <label for="field-2" class="col-sm-0"><?php echo get_phrase("mother_first_name");?><span class="error" style="color: red;"> *</span></label>
                        <input class="form-control" type="text" placeholder="Mother First Name" name="mother_fname" value="<?php echo set_value('mother_fname'); ?>" required/>
                    </div>
                    <div class="col-md-4 col-sm-6 form-group">
                        <label for="field-2" class="col-sm-0"> <?php echo get_phrase("mother_last_name");?> <span class="error" style="color: red;"> *</span></label>
                        <input class="form-control" type="text" placeholder="Mother Last Name" name="mother_lname" value="<?php echo set_value('mother_lname'); ?>" required/>
                    </div>
                      <div class="col-md-4 col-sm-6 form-group">
                        <label><?php echo get_phrase("class_you_want_to_apply_for");?><span class="error" style="color: red;"> *</span></label>                       
                        <select name="class" class="selectpicker" data-style="form-control" data-live-search="true" required>                            
                            <option value="<?php echo set_value('class'); ?>"><?php echo get_phrase('select_class');?></option>
                            <?php foreach($classes as $class):?>
                            <option value="<?php echo $class['class_id'];?>"><?php echo get_phrase('class');?><?php echo " ".$class['name'];?></option> 
                            <?php endforeach; ?> 
                        </select>                       
                        
                    </div>
                       <div class="col-md-4 col-sm-6 form-group">
                        <label><?php echo get_phrase("previous_class");?><span class="error" style="color: red;"> *</span></label>                       
                        <select  class="selectpicker" data-style="form-control" data-live-search="true" name="previous_class" id="previous_class" onchange="show_previous_school(this)" required>                            
                            <option value="<?php echo set_value('previous_class'); ?>"><?php echo get_phrase('select_class');?></option>
                            <option value="-10">N/A</option>
                            <?php foreach($classes as $class):?>
                            <option value="<?php echo $class['class_id'];?>"><?php echo get_phrase('class');?><?php echo " ".$class['name'];?></option> 
                            <?php endforeach; ?> 
                        </select>
                    </div>
                    
                    
                    <div class="col-md-4 col-sm-6 form-group previous_class">
                        <label id="previous_school_label"><?php echo get_phrase("previous_school");?><span class="error" style="color: red;"> *</span></label>
                        <input class="form-control" id="previous_school_input" type="text" placeholder="Previous School" name="previous_school" value="<?php echo set_value('previous_school'); ?>"/>
                    </div>
                    
                    
<!--
                    <div class="col-md-3 form-group">

                        <label><?php echo get_phrase("previous_result");?><span class="error" style="color: red;"> *</span></label>                        
                        <select name="previous_result" class="form-control" value="<?php echo set_value('previous_result'); ?>" required>                            
                            <option value=""><?php echo get_phrase('select_grade');?></option>
                            <?php foreach($grade as $new_grade):?>
                            <option value="<?php echo $new_grade['grade_id'];?>"><?php echo get_phrase('class');?><?php echo " ".$new_grade['name'];?></option> 
                            <?php endforeach; ?> 
                        </select> 

                    </div>-->
                   
                    <div class="col-md-4 col-sm-6 form-group">
                        <label><?php echo get_phrase("category");?><span class="error" style="color: red;"> *</span></label>                        
                        <select  class="selectpicker" data-style="form-control" data-live-search="true" name='category' id ='category' required>
                            <option value='<?php echo set_value('category'); ?>'>Select Category</option>
                            <option value='GENERAL'>GENERAL</option>
                            <option value='OBC'>OBC</option>
                            <option value='ST'>ST</option>
                            <option value='SC'>SC</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4 col-sm-6 form-group">
                        <label><?php echo get_phrase("date_of_birth");?><span class="error" style="color: red;"> *</span></label>
                        <input class="form-control datepicker" type="text" placeholder="Date of birth" name="birthday" value="<?php echo set_value('birthday'); ?>"/>
                        <!--p id="age"></p-->
                    </div>
                    
                    <div class="col-md-4 col-sm-6 form-group">
                        <label><?php echo get_phrase("gender");?><span class="error" style="color: red;"> *</span></label>                        
                        <select  class="selectpicker" data-style="form-control" data-live-search="true" name='gender' id ='gender' required>
                            <option value="<?php echo set_value('gender'); ?>">Select Gender</option>
                            <option value='Male'>Male</option>
                            <option value='Female'>Female</option>                          
                        </select>
                    </div>
                    
                    <div class="col-md-4 col-sm-6 form-group">
                        <label><?php echo get_phrase("current_address");?><span class="error" style="color: red;"> *</span></label>
                        <input class="form-control" type="text" placeholder="Street Address" name="address" value="<?php echo set_value('address'); ?>" required/>
                    </div>
                    
                    <div class="col-md-4 col-sm-6 form-group">
                        <label><?php echo get_phrase("address_line_2");?></label>
                        <input class="form-control" type="text" placeholder="Street Address Line 2" name="address2" value="<?php echo set_value('address2'); ?>"/>
                    </div>
                    
                    <div class="col-md-4 col-sm-6 form-group">
                        <label><?php echo get_phrase("city");?><span class="error" style="color: red;"> *</span></label>
                        <input class="form-control" type="text" placeholder="Current City" name="city" value="<?php echo set_value('city'); ?>" required/>
                    </div>
                    <div class="col-md-4 col-sm-6 form-group">
                        <label><?php echo get_phrase("state");?></label>
                        <input class="form-control" type="text" placeholder="State" name="region" value="<?php echo set_value('region'); ?>"/>
                    </div>
               
                
                    <div class="col-md-4 col-sm-6 form-group">
                        <label><?php echo get_phrase("postal_code");?></label>
                        <input class="form-control" type="text" placeholder="Postal Code" name="zip_code" value="<?php echo set_value('zip_code'); ?>"/>
                    </div>
                    <div class="col-md-4 col-sm-6 form-group">
                        <label><?php echo get_phrase("country");?></label>
                        <input class="form-control" type="text" placeholder="Country" name="country" value="<?php echo set_value('country'); ?>"/>
                    </div>


                    <div class="col-md-4 col-sm-6 form-group">
                        <label><?php echo get_phrase("user_email");?></label>
                        <input class="form-control" type="email" placeholder="User Email"  name="user_email" value="<?php echo set_value('user_email'); ?>"/>
                    </div>
                    


                    <div class="col-md-4 col-sm-6 form-group">
                        <label><?php echo get_phrase("landline_number");?></label>


                        <input class="form-control numeric"  ptype="tel" maxlength="10" laceholder="Landline Number" name="phone" value="<?php echo set_value('phone'); ?>"/>
                    </div>
                    <div class="col-md-4 col-sm-6 form-group">
                        <label><?php echo get_phrase("work_number");?></label>
                        <input class="form-control numeric" type="tel" maxlength="10" placeholder="Work Number" name="work_phone" value="<?php echo set_value('work_phone'); ?>"/>
                    </div>                    


                     <div class="col-md-4 col-sm-6 form-group">
                        <label><?php echo get_phrase("annual_salary");?><span class="error" style="color: red;"> *</span></label>
                        <input class="form-control numeric" type="tel" placeholder="Annual Salary" name="annual_salary" value="<?php echo set_value('annual_salary'); ?>" required/>
                    </div>
                 
                    
                    
                   
                    <div class="col-md-4 col-sm-6 form-group">
                        <label><?php echo get_phrase("guardian_first_name");?></label>

                        <input class="form-control" type="text" placeholder="First Name" name="guardian_first_name" value="<?php echo set_value('guardian_first_name'); ?>"/>
                    </div>
                    <div class="col-md-4 col-sm-6 form-group">
                        <label><?php echo get_phrase("guardian_last_name");?></label>
                        <input class="form-control" type="text" placeholder="First Name" name="guardian_last_name" value="<?php echo set_value('guardian_last_name'); ?>"/>
                    </div>  
                        
                      <div class="col-md-4 col-sm-6 form-group">
                        <label><?php echo get_phrase("guardian_profession");?></label>
                        <input class="form-control" type="text" placeholder="Profession" name="guardian_profession" value="<?php echo set_value('guardian_profession'); ?>"/>
                    </div>                    
                    
                    <div class="col-md-4 col-sm-6 form-group">
                        <label><?php echo get_phrase("guardian_address");?></label>

                        <input class="form-control" type="text" placeholder="Address" name="guardian_address" value="<?php echo set_value('guardian_address'); ?>"/>
                    </div>
                    <div class="col-md-4 col-sm-6 form-group">
                        <label><?php echo get_phrase("guardian_email");?></label>
                        <input class="form-control" type="email" placeholder="Email" name="guardian_email" value="<?php echo set_value('guardian_email'); ?>"/>
                    </div>  
                      
                      <div class="col-md-4 col-sm-6 form-group">
                        <label><?php echo get_phrase("emergency_number");?><span class="error" style="color: red;"> *</span></label>
                        <input class="form-control numeric" maxlength="10" type="tel" placeholder="Emergency Number" name="guardian_emergency_number" value="<?php echo set_value('guardian_emergency_number'); ?>" required/>
                    </div> 
                    
                    <div class="col-md-4 col-sm-6 form-group">
                        <label for="field-2" class="col-sm-0"><?php echo get_phrase("government_code_for_admission");?><span class="error" style="color: red;"> *</span></label>
                        <input class="form-control" type="text" placeholder="Government Code For Admission" name="govt_admission_code" value="<?php echo set_value('govt_admission_code'); ?>" required/>
                    </div>
                    </div>
                    
                <div class="row">                    
                    <!--div class="col-md-3 form-group">
                        <label><?php echo get_phrase("child's_interest");?><span class="error" style="color: red;"> *</span></label>                        
                        <select  class="form-control" name='interest' id ='interest' required>
                            <option value="">Select Interest</option>
                            <option value="Music">Music</option>
                            <option value="Dance">Dance</option>
                            <option value="Tennis">Tennis</option>
                            <option value="Cricket">Cricket</option>
                            <option value="Singing">Singing</option>
                            <option value="Swimming">Swimming</option>                          
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label><?php echo get_phrase("fitness");?><span class="error" style="color: red;"> *</span></label>                        
                        <select  class="form-control" name='fitness' id ='fitness' required>
                            <option value="Music">Music</option>
                            <option value="Dance">Dance</option>
                            <option value="Tennis">Tennis</option>
                            <option value="Cricket">Cricket</option>
                            <option value="Singing">Singing</option>
                            <option value="Swimming">Swimming</option>                        
                        </select>
                    </div-->
                    
                    <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                        <label><?php echo get_phrase("is_advance_paid ?");?><span class="error" style="color: red;"> *</span></label>
                        <div class="form-check inline">
                        <label class="form-check-label">
                         <input class="form-check-input" type="radio" name="advance" id="advance_yes" value="yes"  required>
                         YES
                        </label>                      
                        <label class="form-check-label">
                         <input class="form-check-input" type="radio" name="advance" id="advance_no" value="no">
                         NO
                        </label>
                        </div>                             
                    </div>
                                
                    <div class="col-sm-3" id="receipt_no">
                    <label ><?php echo get_phrase("receipt_number");?></label>
                        <input type="text" class="form-control" name="receipt_no" id="text1" maxlength="30">
                    </div> 
                    
                   
                    <div class="col-md-9 res_add btn-center-in-sm">
                    <button type="submit" class="btn btn-success res_enq btn_float_center pull-right" style="border-color:#ff9009; background:#ff9009;" id="admit" name="submit_application"><?php echo get_phrase("admit_student");?></button>
                    </div>
                    </div>
                </div>
                  
            </div>
        </div>
    </div>
</div>       
</form>
	<script src="<?php echo base_url();?>assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/bootstrap.js"></script>
	<script src="<?php echo base_url();?>assets/js/fullcalendar/fullcalendar.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.js"></script>

    
	<script src="assets/js/neon-calendar.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#receipt_no").hide();
        $("#advance_yes").click(function () {
            $("#receipt_no").show();
        });
        $("#advance_no").click(function () {
            $("#receipt_no").hide();
        });

        $('#mobile_number').on('blur',function(){
            $.ajax({
               type: "POST",
                url: '<?php echo base_url();?>index.php/?ajax_controller/get_latest_parrent_details_for_student_inquiry',
                data:"mobile_number="+$(this).val(),
                success:function(retData){
                    contact = JSON.parse(retData);
                    if(contact.exist==='yes'){
                        console.log("comming with exist data");
                        console.log(contact.data);
                        oldData=contact.data;

                        $('input[name=parent_fname]').val(oldData.parent_fname);
                        $('input[name=parent_lname]').val(oldData.parent_lname);
                        $('input[name=address]').val(oldData.address);
                        $('input[name=address_second]').val(oldData.address_second);
                        $('input[name=city]').val(oldData.city);
                        $('input[name=region]').val(oldData.region);
                        $('input[name=zip_code]').val(oldData.zip_code);
                        $('input[name=country]').val(oldData.country);
                        $('input[name=user_email]').val(oldData.user_email);
                        $('input[name=phone]').val(oldData.phone);
                        $('input[name=work_phone]').val(oldData.work_phone);
                        $('input[name=mother_fname]').val(oldData.mother_fname);
                        $('input[name=mother_lname]').val(oldData.mother_lname);
                        $('input[name=category]').val(oldData.caste_category);
                        $('input[name=gender]').val(oldData.gender);
                        $('input[name=annual_salary]').val(oldData.annual_salary);
                    }else{
                        console.log("comming with no data");
                    }
                }
            });
        });

        $("#previous_class").on("change",function(){
            if($(this).val()=='-10'){
                $('.previous_class').hide();
            }else{
                $('.previous_class').show();
            }
        });

        jQuery('.datepicker').datepicker({
            endDate: '-365d',
            autoclose: true
        });
});

</script>
