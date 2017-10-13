<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('edit_admission_form'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase('edit_admission_form'); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<?php if ($this->session->flashdata('flash_message')) { ?>        
    <div class="alert alert-danger">
        <?php echo $this->session->flashdata('flash_message'); ?>
    </div>
<?php } ?>
<?php // pre($student_data); die;?>
<div class="row m-0">
    <div class="col-sm-12 white-box" data-step="5" data-intro="<?php echo get_phrase('Here you can edit the student information.');?>" data-position='top'>   
        <?php echo form_open(base_url() . 'index.php?school_admin/view_admission_form/' . $inquery_student_id, array('class' => 'form-group validate', 'id' => 'studentEnquiryForm', 'enctype' => "multipart/form-data")); ?>

        <div class="panel panel-success" data-collapsed="0" >
            <div class="panel panel-default view-panel view-top">

                <fieldset class="scheduler-border">
                    <legend class="scheduler-border"><h2>Student Information</h2></legend>
                    <div class="panel-body panel-padd-off">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("student's_first_name"); ?><span class="error" style="color: red;"> *</span></label>
                                <?php echo form_error('student_fname'); ?>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="ti-user"></i></div>
                                    <input class="form-control" type="text" placeholder="First Name" name = "student_fname" required="required" value="<?php echo $student_data->student_fname; ?>"/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("student's_last_name"); ?></label>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="ti-user"></i></div>
                                    <input class="form-control" type="text" placeholder="Last Name" name="student_lname" value="<?php echo $student_data->student_lname; ?>" />
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("class_you_want_to_apply_for"); ?><span class="error" style="color: red;"> *</span></label>
                                <select class="selectpicker" data-style="form-control" data-live-search="true" required="required" name="class" required onchange="checkavailability_byclass(this.value);">                            
                                    <option value=""><?php echo get_phrase('select_class'); ?></option>
                                    <?php foreach ($classes as $class): ?>
                                        <option value="<?php echo $class['class_id']; ?>"<?php if ($class['class_id'] == $student_data->class_id) echo 'selected'; ?>><?php echo get_phrase('class'); ?><?php echo " " . $class['name']; ?></option> 
                                    <?php endforeach; ?> 
                                </select>
                                <span id="availability" style="color:#cc2424"></span>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("previous_class"); ?><span class="error" style="color: red;"> *</span></label>                               

                                <select  class="selectpicker" data-style="form-control" data-live-search="true" name="previous_class" required="required" id="previous_class">                            
                                    <option value=""><?php echo get_phrase('select_class'); ?></option>
                                    <option value="-10" <?php if (-10 == $student_data->previous_class) echo 'selected'; ?>>N/A</option>
                                    <?php foreach ($classes as $class): ?>
                                        <option value="<?php echo $class['class_id']; ?>" <?php if ($class['class_id'] == $student_data->previous_class) echo 'selected'; ?>><?php echo get_phrase('class'); ?><?php echo " " . $class['name']; ?></option> 
                                    <?php endforeach; ?> 
                                </select>
                            </div>   


                            <div class="col-xs-12 col-sm-6 col-md-4 form-group previous_class" style="display:<?php echo($student_data->previous_class > 0) ? '' : 'none' ?>">

                                <label><?php echo get_phrase("previous_school"); ?><span class="error" style="color: red;">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-university"></i></div>
                                    <input class="form-control" <?php echo($student_data->previous_class > 0) ? 'required' : '' ?> 
                                       type="text" placeholder="Previous School" name="previous_school" value="<?php echo $student_data->previous_school; ?>" />
                                </div>
                            </div>  

                            <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                                <label><?php echo get_phrase("category"); ?><span class="error" style="color: red;"> *</span></label>                        
                                <select  class="selectpicker" data-style="form-control" data-live-search="true" name='category' required="required" id ='category' required>
                                    <option value=''>Select Category</option>
                                    <option value='GENERAL' <?php if ($student_data->caste_category == 'GENERAL') echo 'selected'; ?>>GENERAL</option>
                                    <option value='OBC' <?php if ($student_data->caste_category == 'OBC') echo 'selected'; ?>>OBC</option>
                                    <option value='ST' <?php if ($student_data->caste_category == 'ST') echo 'selected'; ?>>ST</option>
                                    <option value='SC' <?php if ($student_data->caste_category == 'SC') echo 'selected'; ?>>SC</option>
                                </select>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                                <label><?php echo get_phrase("date_of_birth"); ?><span class="error" style="color: red;"> *</span></label>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-birthday-cake"></i></div>
                                    <input class="form-control datepicker" type="text" required="required" placeholder="Date of birth" name="birthday" value="<?php echo $student_data->birthday; ?>" />
                                </div>
                            </div>   

                            <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                                <label><?php echo get_phrase("gender"); ?><span class="error" style="color: red;"> *</span></label>
                                <select  class="selectpicker" data-style="form-control" data-live-search="true" name='gender' id ='category' required>

                                    <option value='Male'<?php if ($student_data->gender == 'Male') echo 'selected'; ?>>Male</option>
                                    <option value='Female'<?php if ($student_data->gender == 'Female') echo 'selected'; ?>>Female</option>                          
                                </select>
                            </div>   
                            
                            <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                                <label><?php echo get_phrase("Current_address"); ?><span class="error" style="color: red;"> *</span></label>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-birthday-cake"></i></div>
                                    <input class="form-control" type="text" required="required" placeholder="Current Address" name="address" value="<?php echo $student_data->address; ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>    
            </div>
        </div>
    </div>
</div>


<div class="row m-0">
    <div class="col-sm-12 white-box" data-step="6" data-intro="<?php echo get_phrase('Here you can edit general information.');?>" data-position="top">  

        <div class="panel panel-default view-panel">
            <fieldset class="scheduler-border">
                <legend class="scheduler-border"><h2>General Information</h2></legend>
                <div class="panel-body panel-padd-off">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label for="field-2" class="col-sm-0"><?php echo get_phrase("father_first_name"); ?><span class="error" style="color: red;"> *</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="ti-user"></i></div>
                                <input class="form-control" type="text" placeholder="Father First Name" name="father_fname" required="required" value="<?php echo $student_data->parent_fname; ?>" />
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label for="field-2" class="col-sm-0"><?php echo get_phrase("father_last_name"); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="ti-user"></i></div>
                                <input class="form-control" type="text" placeholder="Father Last Name" name="father_lname" value="<?php echo $student_data->parent_lname; ?>" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label for="field-2" class="col-sm-0"><?php echo get_phrase("education"); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-graduation-cap"></i></div>
                                <input class="form-control" type="text" placeholder="Qualification" name="education" value="<?php echo (array_key_exists('father_qualification', $parrentDetailsArr)) ? $parrentDetailsArr['father_qualification'] : ""; ?>"/>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label for="field-2" class="col-sm-0"><?php echo get_phrase("school/college"); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-university"></i></div>
                                <input class="form-control" type="text" placeholder="Enter your College Name" name="school" value="<?php echo (array_key_exists('father_school', $parrentDetailsArr)) ? $parrentDetailsArr['father_school'] : ""; ?>"/>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label for="field-2" class="col-sm-0"><?php echo get_phrase("occupation"); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-briefcase"></i></div>
                                <input class="form-control" type="text" placeholder="Occupation" name="occupation" value="<?php echo (array_key_exists('father_profession', $parrentDetailsArr)) ? $parrentDetailsArr['father_profession'] : ""; ?>" />
                            </div>
                        </div> 
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label for="field-2" class="col-sm-0"><?php echo get_phrase("department/industry"); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-id-badge"></i></div>
                                <input class="form-control" type="text" placeholder="Department" name="department" value="<?php echo (array_key_exists('father_department', $parrentDetailsArr)) ? $parrentDetailsArr['father_department'] : ""; ?>"/>
                            </div>
                        </div> 

                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label for="field-2" class="col-sm-0"><?php echo get_phrase("designation"); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-id-badge"></i></div>
                                <input class="form-control" type="text" placeholder="Designation" name="designation" value="<?php echo (array_key_exists('father_designation', $parrentDetailsArr)) ? $parrentDetailsArr['father_designation'] : ""; ?>"/>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label for="field-2" class="col-sm-0"><?php echo get_phrase("annual_income"); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-money" ></i></div>
                                <input class="form-control numeric" type="tel" placeholder="Annual Income" name="annual_income" value="<?php echo $student_data->annual_salary; ?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label for="field-2" class="col-sm-0"><?php echo get_phrase("email_id"); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                                <input class="form-control" type="email" placeholder="User Email" name="email_id" value="<?php echo $student_data->user_email; ?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label for="field-2" class="col-sm-0"><?php echo get_phrase("mobile_number"); ?><span class="error" style="color: red;"> *</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-mobile"></i></div>
                                <input class="form-control numeric" maxlength="10" type="tel" placeholder="Mobile Number" required="required" name="user_mobile" value="<?php echo $student_data->mobile_number; ?>" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label for="field-2" class="col-sm-0"><?php echo get_phrase("emergency_contact_number"); ?><span class="error" style="color: red;"> *</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-volume-control-phone"></i></div>
                                <input class="form-control numeric" maxlength="10" type="tel" placeholder="Emergency Contact Number" required="required" name="emergency_contact_number" value="<?php echo $student_data->mobile_number; ?>" /> 
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label for="field-2" class="col-sm-0"><?php echo get_phrase("city"); ?><span class="error" style="color: red;"> *</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-globe"></i></div>
                                <input class="form-control" maxlength="50" type="text" placeholder="Please enter a city" name="city" required="required" value="<?php echo $student_data->city; ?>" /> 
                            </div>
                        </div>

                    </div>    

                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label for="field-2" class="col-sm-0"><?php echo get_phrase("Mother_first_name"); ?><span class="error" style="color: red;"> *</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-female"></i></div>
                                <input class="form-control" type="text" placeholder="Mother First Name" name="mother_fname" required="required" value="<?php echo $student_data->mother_fname; ?>" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label for="field-2" class="col-sm-0"><?php echo get_phrase("mother_last_name"); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-female"></i></div>
                                <input class="form-control" type="text" placeholder="Mother Last Name" name="mother_lname" value="<?php echo $student_data->mother_lname; ?>"  />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label for="field-2" class="col-sm-0"><?php echo get_phrase("education"); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-graduation-cap"></i></div>
                                <input class="form-control" type="text" placeholder="Qualification" name="mother_education" value="<?php echo (array_key_exists('mother_quaification', $parrentDetailsArr)) ? $parrentDetailsArr['mother_quaification'] : ""; ?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label for="field-2" class="col-sm-0"><?php echo get_phrase("school/college"); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-university"></i></div>
                                <input class="form-control" type="text" placeholder="Enter your College Name" name="mother_school" value="<?php echo (array_key_exists('mother_school', $parrentDetailsArr)) ? $parrentDetailsArr['mother_school'] : ""; ?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label for="field-2" class="col-sm-0"><?php echo get_phrase("occupation"); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-briefcase"></i></div>
                                <input class="form-control" type="text" placeholder="Occupation" name="mother_occupation" value="<?php echo (array_key_exists('mother_profession', $parrentDetailsArr)) ? $parrentDetailsArr['mother_profession'] : ""; ?>"/>
                            </div>
                        </div> 
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label for="field-2" class="col-sm-0"><?php echo get_phrase("department/_industry"); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-id-badge"></i></div>
                                <input class="form-control" type="text" placeholder="Department" name="mother_department" value="<?php echo (array_key_exists('mother_department', $parrentDetailsArr)) ? $parrentDetailsArr['mother_department'] : ""; ?>" />
                            </div>
                        </div> 
                    </div>
                    <div class="row"> 
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label for="field-2" class="col-sm-0"><?php echo get_phrase("mother_designation"); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-id-badge"></i></div>
                                <input class="form-control" type="text" placeholder="Designation" name="mother_designation" value="<?php echo (array_key_exists('mother_designation', $parrentDetailsArr)) ? $parrentDetailsArr['mother_designation'] : ""; ?>" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label for="field-2" class="col-sm-0"><?php echo get_phrase("annual_income"); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-money" ></i></div>
                                <input class="form-control numeric" type="tel" placeholder="Annual Income" name="mother_annual_income" value="<?php echo (array_key_exists('mother_income', $parrentDetailsArr)) ? $parrentDetailsArr['mother_income'] : ""; ?>" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label for="field-2" class="col-sm-0"><?php echo get_phrase("Mother_email_id"); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                                <input class="form-control" type="email" placeholder="User Email" name="mother_email_id" value="<?php echo (array_key_exists('mother_email', $parrentDetailsArr)) ? $parrentDetailsArr['mother_email'] : ""; ?>" />
                            </div>
                        </div>
                    </div>

                    <!--Guardian Details-->
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label for="field-2" class="col-sm-0"><?php echo get_phrase("guardian_first_name"); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="ti-user"></i></div>
                                <input class="form-control" type="text" placeholder="Guardian First Name" name="guardian_fname" value="<?php echo $guardian_details['guardian_fname']; ?>" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label for="field-2" class="col-sm-0"><?php echo get_phrase("guardian_last_name"); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="ti-user"></i></div>
                                <input class="form-control" type="text" placeholder="Guardian Last Name" name="guardian_lname" value="<?php echo $guardian_details['guardian_lname']; ?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label for="field-2" class="col-sm-0"><?php echo get_phrase("guardian_email"); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                                <input class="form-control" type="email" placeholder="Guardian Email" name="guardian_email"  value="<?php echo $guardian_details['guardian_email']; ?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label for="field-2" class="col-sm-0"><?php echo get_phrase("guardian_relation"); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-retweet"></i></div>
                                <input class="form-control" type="text" placeholder="Guardian Relation" name="guardian_relation"  value="<?php echo $guardian_details['guardian_relation']; ?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label for="field-2" class="col-sm-0"><?php echo get_phrase("guardian_address"); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-address-card"></i></div>                            
                                <input class="form-control" type="text" placeholder="Guardian Address" name="guardian_address" value="<?php echo $guardian_details['guardian_address']; ?>" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label for="field-2" class="col-sm-0"><?php echo get_phrase("guardian_emergency_contact"); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-volume-control-phone"></i></div>
                                <input class="form-control numeric" maxlength="10" type="tel" placeholder="Guardian Emergency Contact" name="guardian_emergency_number" value="<?php echo $guardian_details['guardian_emergency_number']; ?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label><?php echo get_phrase("mother_tounge"); ?></label> 

                            <select  class="selectpicker" data-style="form-control" data-live-search="true" name='language' id ='language'>


                                <?php
                                foreach ($language as $lang) {
                                    $selected = '';
                                    if ($language1 == $lang['column_name']) {
                                        $selected = 'selected';
                                    }
                                    ?> 

                                    <option value="<?php echo $lang['column_name']; ?>"<?php echo $selected; ?> ><?php echo ucfirst($lang['column_name']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <!--Guardian Details-->
                    <div class="row">


                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label><?php echo get_phrase("type_of_family"); ?></label>
                            <div class="form-check inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="family" id="nuclear" value="nuclear" <?php
                                    if (array_key_exists('family_type', $studentDetailsArr)) {
                                        if ($studentDetailsArr['family_type'] == "nuclear") {
                                            echo 'checked';
                                        }
                                    }
                                    ?>>
                                    NUCLEAR
                                </label>                      
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="family" id="joint" value="joint" <?php
                                    if (array_key_exists('family_type', $studentDetailsArr)) {
                                        if ($studentDetailsArr['family_type'] == "joint") {
                                            echo 'checked';
                                        }
                                    }
                                    ?>
                                           checked>
                                    JOINT
                                </label>
                            </div>                     
                        </div>                         
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label><?php echo get_phrase("need_transportation"); ?></label>
                            <div class="form-check inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="transport" id="transport" value="yes" <?php
                                    if (array_key_exists('transport', $studentDetailsArr)) {
                                        if ($studentDetailsArr['transport'] == "yes") {
                                            echo 'checked';
                                        }
                                    }
                                    ?>>
                                    YES
                                </label>                      
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="transport" id="transport" value="no" <?php
                                    if (array_key_exists('transport', $studentDetailsArr)) {
                                        if ($studentDetailsArr['transport'] == "no") {
                                            echo 'checked';
                                        }
                                    }
                                    ?> checked>
                                    NO
                                </label>
                            </div>                     
                        </div>
                    </div>
                </div></fieldset></div></div></div>

<div class="row m-0">
    <div class="col-sm-12 white-box" data-step="7" data-intro="<?php echo get_phrase('Here you can enter the details of siblings!');?>" data-position="top">  

        <input class="form-control" type="hidden"  name="address" value="<?php echo $student_data->address; ?>"/>

        <div class="row clearfix">
            <div class="col-md-12 column view-table-scroll">
                <legend class="scheduler-border"><h2><?php echo get_phrase("details_of_siblings");?></h2></legend>
                <table class="table table-bordered table-hover" id="tab_logic">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Age</th>
                            <th class="text-center">Name of the School</th>
                            <th class="text-center">Class</th>
                            <th class="text-center">Relationship</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($siblingsDetailsArr) > 0) { //pre($siblingsDetailsArr);die;
                            foreach ($siblingsDetailsArr AS $sibglingsKey => $sibglingsVal) { ?>
                                <tr id='addr0'>
                                    <td>
                                        <?php echo $sibglingsKey + 1; ?>
                                    </td>
                                    <td>
                                        <input type="text" name='siblings_name[]'  placeholder='Name' class="form-control" value="<?php echo $sibglingsVal['name']; ?>"/>
                                    </td>
                                    <td>
                                        <input type="text" name='siblings_age[]' placeholder='Age' class="form-control numeric" value="<?php echo $sibglingsVal['age']; ?>"/>
                                    </td>
                                    <td>
                                        <input type="text" name='siblings_school_name[]' placeholder='Name of the School/College' class="form-control" value="<?php echo $sibglingsVal['school']; ?>"/>
                                    </td>
                                    <td>
                                        <input type="text" name='siblings_class[]' placeholder='Class' class="form-control" value="<?php echo $sibglingsVal['class']; ?>"/>
                                    </td>
                                    <td>
                                        <input type="text" name='siblings_realtion[]' placeholder='Relation' class="form-control" value="<?php echo $sibglingsVal['relation_ship']; ?>"/>
                                    </td>
                                </tr>
                                <tr id='addr1'></tr>
                            <?php }
                        } else { ?>
                            <?php for ($s = 0; $s < 2; $s++){?>        
                                <tr id='addr0'>
                                    <td>
                                        <?php echo $s + 1; ?>
                                    </td>
                                    <td>
                                        <input type="text" name='siblings_name[]'  placeholder='Name' class="form-control" value=""/>
                                    </td>
                                    <td>
                                        <input type="text" name='siblings_age[]' placeholder='Age' class="form-control numeric" value=""/>
                                    </td>
                                    <td>
                                        <input type="text" name='siblings_school_name[]' placeholder='Name of the School/College' class="form-control" value=""/>
                                    </td>
                                    <td>
                                        <input type="text" name='siblings_class[]' placeholder='Class' class="form-control" value=""/>
                                    </td>
                                    <td>
                                        <input type="text" name='siblings_realtion[]' placeholder='Relation' class="form-control" value=""/>
                                    </td>
                                </tr>
                                <tr id='addr1'></tr>
                            <?php }?>
                        <?php } ?>
                    </tbody>
                </table>                                
            </div>
        </div>    
        <br>

        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                <label><?php echo get_phrase("child's_interest"); ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-codepen"></i></div>
                    <input class="form-control" type="text" placeholder="Interest" name="interest_one" value="<?php echo (array_key_exists('interest_one', $studentDetailsArr)) ? $studentDetailsArr['interest_one'] : ""; ?>">
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                <label><?php echo get_phrase("child's_interest"); ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-codepen"></i></div>
                    <input class="form-control" type="text" placeholder="Interest" name="interest_two" value="<?php echo (array_key_exists('interest_two', $studentDetailsArr)) ? $studentDetailsArr['interest_two'] : ""; ?>">
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                <label><?php echo get_phrase("child's_interest"); ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-codepen"></i></div>
                    <input class="form-control" type="text" placeholder="Interest" name="interest_three" value="<?php echo (array_key_exists('interest_three', $studentDetailsArr)) ? $studentDetailsArr['interest_three'] : ""; ?>">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <div class="form-check inline">                  
                        <label class="p-r-50">  
                            <?php echo get_phrase("does_your_child_has_medical_problem:"); ?>
                        </label>
                        <label class="form-check-label">  
                            <input class="form-check-input" type="radio" name="medical" id="medical1" value="1" <?php
                            echo (array_key_exists('medical_pblm', $studentDetailsArr) && $studentDetailsArr['medical_pblm'] == 'yes')?'checked':''?>>
                            YES
                        </label>
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="medical" id="medical2" value="0" 
                            <?php echo(array_key_exists('medical_pblm', $studentDetailsArr) && $studentDetailsArr['medical_pblm'] == 'no')?'checked':'';?> 
                            <?php echo(array_key_exists('medical_pblm', $studentDetailsArr) && $studentDetailsArr['medical_pblm'] == '')?'checked':'';?>/>
                            NO
                        </label>
                    </div>
                </div>                     
            </div>
        </div>    
        
        <div class="row" id="medical-div">
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <label for="history"><?php echo get_phrase('disease');?>: <span class="error mandatory"> *</span></label>
                    <select class="selectpicker" data-style="form-control" data-live-search="true" name="disease" id="disease">
                        <option value="">Select Disease</option>
                        <option value="Asthma" >Asthma</option>
                        <option value="Diabetes" >Diabetes</option>
                        <option value="Blood pressure" >Blood pressure</option>
                        <option value="Medication allergies" >Medication allergies</option>
                        <option value="Food allergies" >Food allergies</option>
                        <option value="Other" >Other</option>
                    </select>
                </div>
            </div>
            
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <label><?php echo get_phrase("if_yes_please_specify");?><span class="error mandatory med-res-req"> *</span></label>
                    <input type="text" class="form-control" name="reason" id="text1" maxlength="30" value="<?php echo (array_key_exists('medical_pblm_reason', $studentDetailsArr)) ? $studentDetailsArr['medical_pblm_reason']:''; ?>" >                                
                </div>
            </div>
        </div>

        <div class="row">
            <div class="text-right col-md-12">
                <div class="form-group">
                    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" id="admission" name="admit_student" value= "admit_student1" data-step="8" data-intro="<?php echo get_phrase('On the click of this button you can edit.');?>" data-position='left'><?php echo get_phrase("update"); ?></button>
                </div>
            </div> 
        </div>
    </div>

    <div class="row">  
      
    </div>
    <?php echo form_close(); ?>
</div>

<script>
$(document).ready(function () {
    var i = 1;
    $("#add_row").click(function () {
        $('#addr' + i).html("<td>" + (i + 1) + "</td><td><input name='siblings_name" + i + "' type='text' placeholder='Name' class='form-control input-md'  /> </td><td><input  name='siblings_age" + i + "' type='text' placeholder='Age'  class='form-control input-md'></td><td><input  name='siblings_school_name" + i + "' type='text' placeholder='Name of the School/College'  class='form-control input-md'></td><td><input  name='siblings_class" + i + "' type='text' placeholder='Class'  class='form-control input-md'></td><td><input  name='siblings_relation" + i + "' type='text' placeholder='Relationship'  class='form-control input-md'></td>");

        $('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');
        i++;
    });
    $("#delete_row").click(function () {
        if (i > 1) {
            $("#addr" + (i - 1)).html('');
            i--;
        }
    });

    $("#previous_class").on("change", function () {
        if ($(this).val() == '-10') {
            $('.previous_class').hide();
        } else {
            $('.previous_class').show();
        }
    });

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        endDate: '-365d',
        autoclose: true
    });

    $("#medical-div").hide();
    $('.med-res-req').hide();
    $('input[name=medical]').change(function(){
        if(this.value==1){
            $("#medical-div").show();
        }else{
            $("#medical-div").hide();
        }
    });

    $('#disease').change(function(){
        if(this.value=='Other'){
            $('.med-res-req').show();    
        }else{
            $('.med-res-req').hide();
        }
    });
});

function checkavailability_byclass(class_id) {
    $.ajax({
        url: '<?php echo base_url(); ?>index.php?ajax_controller/check_availability_for_class',
        type: 'POST',
        data: {class_id: class_id},
        success: function (response) {
            count = JSON.parse(response);
            if (count.allowed === 'no') {
                $('#availability').html('No seats available');
            } else {
                $('#availability').html('');
            }
        },
        error: function () {
            alert('error');
        }
    });
}
</script>