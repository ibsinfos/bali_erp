<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('Student Details'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" target="_blank" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase('Student Details'); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>




<?php //pre($student_details); ?>
    <link rel="stylesheet" type="text/css" href="assets/new_assets/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/new_assets/css/datatable.css"/>
    <script type="text/javascript" src="assets/new_assets/js/datatable.js"></script>
    <style>
        .panel-heading .accordion-toggle:after {
            /* symbol for "opening" panels */
            font-family: 'Glyphicons Halflings';  /* essential for enabling glyphicon */
            content: "\e114";    /* adjust as needed, taken from bootstrap.css */
            float: right;        /* adjust as needed */
            color: grey;         /* adjust as needed */
        }
        .panel-heading .accordion-toggle.collapsed:after {
            /* symbol for "collapsed" panels */
            content: "\e080";    /* adjust as needed, taken from bootstrap.css */
        }
    </style>
        <?php
        if(empty($student_details)){
            echo "Wrong selection of user detail";   
        }else {
            ?>
        

<div class = "container">
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                      1. Student Personal Information
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in">
                <div class="panel-body">
                    <div class="container">
                        <div class="container">
                            <div class="col-md-3">
                                <label>Student Image:-</label>
                            </div>  
                            <div class="col-md-3">
                                <?php echo $student_details->stud_image;?>
                            </div>
                        </div> 
                        <div class="container">
                            <div class="col-md-3">    
                                <label>Student Name:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->name;?>
                            </div>
                             <div class="col-md-3">
                                <label>Student Middle Name:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->mname;?>
                            </div>
                        </div>
                         <div class="container">
                            <div class="col-md-3">
                                <label>Student Last Name:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->lname;?>
                            </div>
                             <div class="col-md-3">
                                <label>Card Type:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->type;?>
                            </div>
                        </div>

                        <div class="container">
                            <div class="col-md-3">
                                <label>Religion:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->religion;?>
                            </div>
                             <div class="col-md-3">
                                <label>Nationality:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->nationality;?>
                            </div>
                        </div>

                         <div class="container">
                            <div class="col-md-3">
                                <label>Phone Number:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->phone;?>
                            </div>
                             <div class="col-md-3">
                                <label>Previous School:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->previous_school;?>
                            </div>
                        </div>



                        <div class="container">
                            <div class="col-md-3">
                                <label>Sex:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->sex;?>
                            </div>
                             <div class="col-md-3">
                                <label>Place of Birth:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->place_of_birth;?>
                            </div>
                        </div> 


                        <div class="container">
                            <div class="col-md-3">
                                <label>Blood Group:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->blood_group;?>
                            </div>
                             <div class="col-md-3">
                                <label>Mother Tounge:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->mother_tounge;?>
                            </div>
                        </div>

                        <div class="container">
                            <div class="col-md-3">
                                <label>Medical Problem:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->medical_pblm;?>
                            </div>
                             <div class="col-md-3">
                                <label>Medical Problem Reason:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->medical_pblm_reason;?>
                            </div>
                        </div>  
                        <div class="container">
                            <div class="col-md-3">
                                <label>Student Interest:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->interest_one , $student_details->interest_two,$student_details->interest_three;?>
                            </div>
                             <div class="col-md-3">
                                <label>Email:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->email;?>
                            </div>
                        </div>  
                    </div>    
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                      2. Parents Information
                    </a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="container">
                        <div class="container">
                             <div class="col-md-3">
                                <label>Father Name:-</label>
                            </div>  
                            <div class="col-md-3">
                                <?php echo $student_details->father_name;?>
                            </div>
                        </div> 

                        <div class="container">
                            <div class="col-md-3">
                                <label>Father Middle Name:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->father_mname;?>
                            </div>
                             <div class="col-md-3">
                                <label>Father Last Name:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->father_lname;?>
                            </div>
                        </div>
                        <div class="container">
                            <div class="col-md-3">    
                                <label>Father Profession:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->father_profession;?>
                            </div>
                             <div class="col-md-3">
                                <label>father Qualification:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->father_qualification;?>
                            </div>
                        </div>

                        <div class="container">
                            <div class="col-md-3">    
                                <label>father Passport number:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->father_passport_number;?>
                            </div>
                             <div class="col-md-3">
                                <label>Father's Contact Number:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->cell_phone;?>
                            </div>
                        </div>


                        <div class="container">
                            <div class="col-md-3">
                                <label>Mother Name:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->mother_name;?>
                            </div>
                             <div class="col-md-3">
                                <label>Mother Middle Name:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->mother_mname;?>
                            </div>
                        </div>

                        <div class="container">
                            <div class="col-md-3">
                                <label>Mother Last Name:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->mother_lname;?>
                            </div>
                             <div class="col-md-3">
                                <label>Mother Profession:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->mother_profession;?>
                            </div>
                        </div>

                        <div class="container">
                            <div class="col-md-3">    
                                <label>Mother Qualification:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->mother_quaification;?>
                            </div>
                             <div class="col-md-3">
                                <label>Mother Passport Number:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->mother_passport_number;?>
                            </div>
                        </div>
                        <div class="container">
                            <div class="col-md-3">
                                <label>Father Icard Number:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->father_icard_no;?>
                            </div>
                             <div class="col-md-3">
                                <label>Father Icard Type:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->father_icard_type;?>
                            </div>
                        </div>
                           <div class="container">
                            <div class="col-md-3">
                                <label>Mother Icard Number:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->mother_icard_no;?>
                            </div>
                             <div class="col-md-3">
                                <label>Mother Icard Type:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->mother_icard_type;?>
                            </div>
                        </div>
                           <div class="container">
                            <div class="col-md-3">
                                <label>Father School:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->father_school;?>
                            </div>
                             <div class="col-md-3">
                                <label>Father Department:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->father_department;?>
                            </div>
                        </div>
                           <div class="container">
                            <div class="col-md-3">
                                <label>Father Income:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->father_income;?>
                            </div>
                             <div class="col-md-3">
                                <label>Father Designation:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->father_designation;?>
                            </div>
                        </div>

                                <div class="container">
                            <div class="col-md-3">
                                <label>Mother School:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->mother_school;?>
                            </div>
                             <div class="col-md-3">
                                <label>Mother Department:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->mother_department;?>
                            </div>
                        </div>
                           <div class="container">
                            <div class="col-md-3">
                                <label>Mother Income:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->mother_income;?>
                            </div>
                             <div class="col-md-3">
                                <label>Mother Designation:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->mother_designation;?>
                            </div>
                        </div>

                        <div class="container">
                            <div class="col-md-3">
                                <label>Home Phone No:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->home_phone;?>
                            </div>
                             <div class="col-md-3">
                                <label>Work Phone No:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->work_phone;?>
                            </div>
                        </div> 

                        <div class="container">
                            <div class="col-md-3">
                                <label>Mother Email:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->mother_email;?>
                            </div>
                             <div class="col-md-3">
                                <label>Mother Contact:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->mother_mobile;?>
                            </div>
                        </div>

                        <div class="container">
                            <div class="col-md-3">
                                <label>Passcode:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->passcode;?>
                            </div>
                             <div class="col-md-3">
                                <label>Zip Code:-</label>
                            </div>
                            <div class="col-md-3">
                                <?php echo $student_details->zip_code;?>
                            </div>
                        </div> 

                    </div>   
                </div>
            </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                3. School   Information
              </a>
            </h4>
          </div>
          <div id="collapseThree" class="panel-collapse collapse">
            <div class="panel-body">
              <div class="container">

                              <div class="container">
                                  <div class="col-md-3">
                                      <label>Section Name:-</label>
                                  </div>
                                  <div class="col-md-3">
                                      <?php echo $student_details->section_name;?>
                                  </div>
                                   <div class="col-md-3">
                                      <label>Class Name:-</label>
                                  </div>
                                  <div class="col-md-3">
                                      <?php echo $student_details->class_name;?>
                                  </div>
                              </div>

                              <div class="container">
                                  <div class="col-md-3">    
                                      <label>Teacher Name:-</label>
                                  </div>
                                  <div class="col-md-3">
                                      <?php echo $student_details->teacher_id;?>
                                  </div>
                                   <div class="col-md-3">
                                      <label>Enrollment Id:-</label>
                                  </div>
                                  <div class="col-md-3">
                                      <?php echo $student_details->enroll_id;?>
                                  </div>
                              </div>
                              <div class="container">
                                  <div class="col-md-3">
                                      <label>Academic Year:-</label>
                                  </div>
                                  <div class="col-md-3">
                                      <?php echo $student_details->academic_year;?>
                                  </div>
                                   <div class="col-md-3">
                                      <label>Parent Id:-</label>
                                  </div>
                                  <div class="col-md-3">
                                      <?php echo $student_details->parent_id;?>
                                  </div>
                              </div>

                               <div class="container">
                                  <div class="col-md-3">
                                      <label>Transport Id:-</label>
                                  </div>
                                  <div class="col-md-3">
                                      <?php echo $student_details->transport_id;?>
                                  </div>
                                   <div class="col-md-3">
                                      <label>Transport Group:-</label>
                                  </div>
                                  <div class="col-md-3">
                                      <?php echo $student_details->transport_group;?>
                                  </div>
                              </div>
                               <div class="container">

                                   <div class="col-md-3">
                                      <label>Dormitory Id:-</label>
                                  </div>
                                  <div class="col-md-3">
                                      <?php echo $student_details->dormitory_id;?>
                                  </div>
                              </div>




                          </div>  
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                4. Address Information
              </a>
            </h4>
          </div>
          <div id="collapseFour" class="panel-collapse collapse">
            <div class="panel-body">
              <div class="container">
                              <div class="container">
                                  <div class="col-md-3">
                                      <label>Address:-</label>
                                  </div>  
                                  <div class="col-md-3">
                                      <?php echo $student_details->address;?>
                                  </div> 
                                   <div class="col-md-3">
                                      <label>City:-</label>
                                  </div>  
                                  <div class="col-md-3">
                                      <?php echo $student_details->city;?>
                                  </div>
                              </div> 

                              <div class="container">
                                  <div class="col-md-3">
                                      <label>State:-</label>
                                  </div>
                                  <div class="col-md-3">
                                      <?php echo $student_details->state;?>
                                  </div>
                                   <div class="col-md-3">
                                      <label>Country:-</label>
                                  </div>
                                  <div class="col-md-3">
                                      <?php echo $student_details->country;?>
                                  </div>
                              </div>

                              <div class="container">
                                  <div class="col-md-3">    
                                      <label>Home Phone Number:-</label>
                                  </div>
                                  <div class="col-md-3">
                                      <?php echo $student_details->home_phone;?>
                                  </div>
                                   <div class="col-md-3">
                                      <label>Zip Code:-</label>
                                  </div>
                                  <div class="col-md-3">
                                      <?php echo $student_details->zip_code;?>
                                  </div>
                              </div>


                          </div>   
            </div>
          </div>
        </div>
    </div>
</div> <!-- end container -->
   <?php }?>    