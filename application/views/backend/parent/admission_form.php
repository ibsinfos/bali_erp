<div class="row bg-title">

    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">  
        <h4 class="page-title"><?php echo get_phrase('Admission Form'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?parents/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase('Admission Form'); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<?php if (!empty($student_data)) {
    extract($student_data); ?>
    <?php

    function ageCalculator($dob) {
        if (!empty($dob)) {
            $birthdate = new DateTime($dob);
            $today = new DateTime('today');
            $age = $birthdate->diff($today)->y;
            return $age;
        } else {
            return 0;
        }
    }

    $dob = (!empty($birthday)) ? $birthday : '';
    ?>

    <div class="row"> 
    <?php echo form_open(base_url() . 'index.php?parents/admission_form/' . $student_id, array('class' => 'form-group validate', 'id' => 'studentEnquiryForm', 'enctype' => "multipart/form-data")); ?>

        <div class="col-md-12">        
            <div class="panel panel-danger" data-collapsed="0" >
                <div class="panel-heading">
                    <div class="panel-title" >
                        <i class="entypo-info"></i>
    <?php echo get_phrase("kindly_ensure_the_details_added_are_correct.__('*')_shows_mandatory_fields"); ?>
                    </div>
                </div> 
                <h2  style="margin-left:5px;">Student Information</h2>
                <div class="panel panel-default" style="margin-left:5px;margin-right:5px">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12"> 
                                <div class="col-md-6 form-group">
                                    <label for="field-2" class="col-sm-0"><?php echo get_phrase("student's_first_name"); ?><span class="error" style="color: red;"> *</span></label>
    <?php echo form_error('student_fname'); ?>
                                    <input class="form-control" type="text" placeholder="First Name" name = "student_fname" value="<?php echo (!empty($student_fname)) ? $student_fname : ''; ?>" readonly />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="field-2" class="col-sm-0"><?php echo get_phrase("student's_last_name"); ?><span class="error" style="color: red;"> *</span></label>
                                    <input class="form-control" type="text" placeholder="Last Name" name="student_lname" value="<?php echo (!empty($student_lname)) ? $student_lname : ''; ?>" readonly/>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="field-2" class="col-sm-0"><?php echo get_phrase("previous_class"); ?><span class="error" style="color: red;"> *</span></label>
                                    <input class="form-control" type="text" placeholder="Previous Class" name="class_name" value="<?php echo $prev_class_name;?>" readonly/>
                                </div>                    
                                <div class="col-md-3 form-group">
                                    <label><?php echo get_phrase("previous_school"); ?><span class="error" style="color: red;"> *</span></label>
                                    <input class="form-control" type="tel" placeholder="Previous School" name="previous_school" value="<?php echo (!empty($previous_school)) ? $previous_school : ''; ?>" readonly/>
                                </div>                  
                                <div class="col-md-3 form-group">
                                    <label><?php echo get_phrase("category"); ?></label>                        
                                    <input class="form-control" type="text" placeholder="Previous School" name="category" value="<?php echo (!empty($caste_category)) ? $caste_category : ''; ?>" readonly/>
                                </div>
                                <div class="col-md-3 form-group">

                                    <label for="field-2" class="col-sm-0"><?php echo get_phrase("class_you_want_to_apply_for"); ?><span class="error" style="color: red;"> *</span></label>
                                    <input class="form-control" type="text" placeholder="Last Name" name="class_name" value="<?php echo $class_name;?>" readonly/>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label><?php echo get_phrase("date_of_birth"); ?><span class="error" style="color: red;"> *</span></label>
                                    <input class="form-control" type="text" placeholder="Date of birth" name="birthday" value="<?php echo (!empty($birthday)) ? $birthday : ''; ?>" readonly/>
                                    <!--p id="age"></p-->
                                </div>  
                                <div class="col-md-3 form-group">
                                    <label><?php echo get_phrase("age"); ?><span class="error" style="color: red;"> *</span></label>
                                    <input class="form-control" type="text" placeholder="Age" name="age" value="<?php echo ageCalculator($dob); ?>" readonly/>
                                    <!--p id="age"></p-->
                                </div>  



                                <!--div class="col-md-3 form-group">
                                    <label><?php echo get_phrase("age_as_on(01.04.2017)"); ?></label>
                                    <input class="form-control" type="text" placeholder="Enter your current age" name="age" id="datepicker"/>
                                    <p id="age"></p>
                                </div-->    

                                <div class="col-md-3 form-group">
                                    <label><?php echo get_phrase("gender"); ?><span class="error" style="color: red;"> *</span></label>                        
                                    <input class="form-control" type="text" placeholder="" name="gender" value="<?php echo (!empty($gender)) ? $gender : ''; ?>" readonly/>
                                </div>   
                                <div class="col-md-3 form-group">
                                    <label><?php echo get_phrase("upload_student_photo"); ?></label>                        
                                    <!--input class="form-control" type="file" name="student_photo"/-->
                                    <input class="form-control" type="file" accept="image/*"  name="userfile" size="20" />
                                </div>    

                            </div> 
                        </div>
                    </div>
                </div>


                <h2 style="margin-left:5px;">General Information</h2>
                <div class="panel panel-default" style="margin-left:5px;margin-right:5px">
                    <div class="panel-body">
                        <div class="row">                                                            
                            <div class="col-md-6 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("father_first_name"); ?><span class="error" style="color: red;"> *</span></label>
                                <input class="form-control" type="text" placeholder="Father First Name" name="father_fname" value="<?php echo (!empty($parent_fname)) ? $parent_fname : ''; ?>" readonly/>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("father_last_name"); ?><span class="error" style="color: red;"> *</span></label>
                                <input class="form-control" type="text" placeholder="Father Last Name" name="father_lname" value="<?php echo (!empty($parent_lname)) ? $parent_lname : ''; ?>" readonly/>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("education"); ?></label>
                                <input class="form-control" type="text" placeholder="Qualification" name="education"/>
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("school/college"); ?></label>
                                <input class="form-control" type="text" placeholder="Enter your College Name" name="school"/>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("occupation"); ?></label>
                                <input class="form-control" type="text" placeholder="Occupation" name="occupation" />
                            </div> 
                            <div class="col-md-3 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("department/industry"); ?></label>
                                <input class="form-control" type="text" placeholder="Department" name="department" />
                            </div> 

                            <div class="col-md-3 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("designation"); ?></label>
                                <input class="form-control" type="text" placeholder="Father Designation" name="designation" />
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("annual_income"); ?></label>
                                <input class="form-control" type="text" placeholder="Annual Income" name="annual_income" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("email_id"); ?><span class="error" style="color: red;"> *</span></label>
                                <input class="form-control" type="text" placeholder="User Email" name="email_id" value="<?php echo (!empty($user_email)) ? $user_email : ''; ?>" readonly />
                            </div>








                            <div class="col-md-3 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("mobile_number"); ?><span class="error" style="color: red;"> *</span></label>
                                <input class="form-control" type="tel" placeholder="Mobile Number" name="user_mobile" value="<?php echo (!empty($mobile_number)) ? $mobile_number : ''; ?>" readonly/>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("emergency_contact_number"); ?><span class="error" style="color: red;"> *</span></label>
                                <input class="form-control" type="tel" placeholder="Emergency Contact Number" name="emergency" value="<?php echo (!empty($mobile_number)) ? $mobile_number : ''; ?>" readonly/>
                            </div>
                        </div>    

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("mother_first_name"); ?><span class="error" style="color: red;"> *</span></label>
                                <input class="form-control" type="text" placeholder="Mother First Name" name="mother_fname" value="<?php echo (!empty($mother_fname)) ? $mother_fname : ''; ?>" readonly/>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("mother_last_name"); ?><span class="error" style="color: red;"> *</span></label>
                                <input class="form-control" type="text" placeholder="Mother Last Name" name="mother_lname" value="<?php echo (!empty($mother_lname)) ? $mother_lname : ''; ?>" readonly/>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("education"); ?></label>
                                <input class="form-control" type="text" placeholder="Qualification" name="mother_education"/>
                            </div>


                            <div class="col-md-3 form-group">

                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("school/college"); ?></label>
                                <input class="form-control" type="text" placeholder="Enter your College Name" name="mother_school"/>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("occupation"); ?></label>
                                <input class="form-control" type="text" placeholder="Occupation" name="mother_occupation" />
                            </div> 
                            <div class="col-md-3 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("department/_industry"); ?></label>
                                <input class="form-control" type="text" placeholder="Department" name="mother_department" />
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("designation"); ?></label>
                                <input class="form-control" type="text" placeholder="Mother Designation" name="mother_designation" />
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("annual_income"); ?></label>
                                <input class="form-control" type="text" placeholder="Annual Income" name="mother_annual_income" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("email_id"); ?></label>
                                <input class="form-control" type="email" placeholder="User Email" name="mother_email_id"  />
                            </div>
                        </div>
                        <!--Guardian Details-->
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("guardian_details"); ?></label>
                                <input class="form-control" type="text" placeholder="Guardian First Name" name="guardian_fname" />
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("guardian_last_name"); ?></label>
                                <input class="form-control" type="text" placeholder="Guardian Last Name" name="guardian_lname" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("guardian_email"); ?></label>
                                <input class="form-control" type="email" placeholder="Guardian Email" name="guardian_email"  />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("guardian_address"); ?></label>
                                <input class="form-control" type="text" placeholder="Guardian Address" name="guardian_address" />
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("guardian_emergency_contact"); ?><span class="error" style="color: red;"> *</span></label>
                                <input class="form-control" type="text" placeholder="Guardian Emergency Contact" name="emergency_contact" required/>
                            </div>

                        </div>
                        <!--Guardian Details-->



                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("mobile_number"); ?></label>
                                <input class="form-control" type="tel" placeholder="Mobile Number" name="mother_user_mobile"/>
                            </div>


                            <div class="col-md-3 form-group">
                                <label><?php echo get_phrase("mother_tounge"); ?></label>                        
                                <select   class="selectpicker" data-style="form-control" data-live-search="true" name='language' id ='category'>
                                    <option value=''>Select Language</option>
                                    <option value='1'>English</option>
                                    <option value='2'>Malayalam</option>                          
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label><?php echo get_phrase("type_of_family"); ?></label>
                                <div class="form-check inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="family" id="nuclear" value="nuclear" >
                                        NUCLEAR
                                    </label>                      
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="family" id="joint" value="joint">
                                        JOINT
                                    </label>
                                </div>                     
                            </div>                         
                            <div class="col-md-3">
                                <label><?php echo get_phrase("need_transportation"); ?></label>
                                <div class="form-check inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="transport" id="transport" value="yes"  >
                                        YES
                                    </label>                      
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="transport" id="transport" value="no">
                                        NO
                                    </label>
                                </div>                     
                            </div>
                        </div>
                        <input class="form-control" type="hidden"  name="address" value="<?php echo (!empty($address)) ? $address : ''; ?>"readonly/>

                        <div class="row">
                            <div class="col-md-12">
                                <label><?php echo get_phrase("details_of_siblings"); ?></label>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="tab_logic">
                                        <thead>
                                            <tr >
                                                <th class="text-center">
                                                    #
                                                </th>
                                                <th class="text-center">
                                                    Name
                                                </th>
                                                <th class="text-center">
                                                    Age
                                                </th>
                                                <th class="text-center">
                                                    Name of the School
                                                </th>
                                                <th class="text-center">
                                                    Class
                                                </th>
                                                <th class="text-center">
                                                    Relationship
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="mybody">
                                            <tr id='addr0'>
                                                <td>
                                                    1
                                                </td>
                                                <td>
                                                    <input type="text" name='name_sibling'  placeholder='Name' class="col-md-3 form-control"/>
                                                </td>
                                                <td>	
                                                    <input type="text" name='age' placeholder='Age' class="form-control"/>
                                                </td>
                                                <td>
                                                    <input type="text" name='school_name' placeholder='Name of the School/College' class="col-md-3 form-control"/>
                                                </td>
                                                <td>
                                                    <input type="text" name='class' placeholder='Class' class="col-md-3 form-control"/>
                                                </td>
                                                <td>
                                                    <input type="text" name='relation' placeholder='Relationship' class="col-md-3 form-control"/>
                                                </td>
                                            </tr>
                                            <tr id='addr1'></tr>
                                        </tbody>
                                    </table>                                   

                                    <input type="hidden" name ="num_rows" id="myField" value="" />
                                </div>       
                                <a id="add_row" class="btn btn-default pull-left">Add Row</a><a id='delete_row' class="pull-right btn btn-default">Delete Row</a> 
                            </div>
                        </div>    
                        <br>
                        <br>

                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label><?php echo get_phrase("interest"); ?></label>                       
                                <select class="selectpicker" data-style="form-control" data-live-search="true" name="interest">                            
                                    <option><?php echo get_phrase('select_interest'); ?></option>
                                    <option value="Music">Music</option>
                                    <option value="Dance">Dance</option>
                                    <option value="Tennis">Tennis</option>
                                    <option value="Cricket">Cricket</option>
                                    <option value="Singing">Singing</option>
                                    <option value="Swimming">Swimming</option> 

                                </select>
                            </div>
                            <div class="col-md-3">
                                <label><?php echo get_phrase("does_your_child_has_medical_problem"); ?></label>
                                <div class="form-check inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="medical" id="medical1" value="yes"  >
                                        YES
                                    </label>                      
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="medical" id="medical2" value="no" >
                                        NO
                                    </label>
                                </div>                     
                            </div>

                            <div class="col-md-3" id="reason">
                                <label ><?php echo get_phrase("if_yes_please_specify"); ?></label>
                                <input type="text" class="form-control" name="reason" id="text1" maxlength="30">

                            </div>

                        </div> 
                        <button type="submit" class="btn btn-danger" id="admission" name="admit_student" value= "admit_student1" style="float:right; margin-top:-20px;"><?php echo get_phrase("admit_student"); ?></button>


                    </div>
                </div>


            </div>
        </div>

    <?php echo form_close(); ?>
    </div>


<?php } else { ?>

    <div class="panel panel-success" data-collapsed="0" >
        <div class="panel-heading">
            <div class="panel-title" >
                <i class="entypo-info"></i>
    <?php echo get_phrase("dear_parent_your_admission_form_is_already_submitted_to_school_administration_and_your_child_has_got_admitted_to_school_directly."); ?>
            </div>
        </div> 

    </div><?php } ?> 





<script>
    $(document).ready(function () {
        var i = 1;
        $("#add_row").click(function () {
            $('#addr' + i).html("<td>" + (i + 1) + "</td><td><input name='name_sibling'" + i + "' type='text' placeholder='Name' class='form-control input-md'  /> </td><td><input  name='age'" + i + "' type='text' placeholder='Age'  class='form-control input-md'></td><td><input  name='school_name'" + i + "' type='text' placeholder='Name of the School/College'  class='form-control input-md'></td><td><input  name='class'" + i + "' type='text' placeholder='Class'  class='form-control input-md'></td><td><input name='relation'" + i + "' type='text' placeholder='Relationship' class='form-control input-md'  /> </td>");

            $('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');
            i++;
            var count = $('#mybody tr').length;
            document.getElementById('myField').value = count;
        });
        $("#delete_row").click(function () {
            if (i > 1) {
                $("#addr" + (i - 1)).html('');
                i--;
            }
        });

    });


    $(document).ready(function () {
        $("#reason").hide();
        $("#medical1").click(function () {
            $("#reason").show();
        });
        $("#medical2").click(function () {
            $("#reason").hide();
        });

    });


</script>


