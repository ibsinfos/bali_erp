<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('Student_admission_Form'); ?></h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
             <li><a href="<?php echo base_url(); ?>index.php?school_admin/student_information"><?php echo get_phrase('student_inforamtion'); ?></a></li>
            <li class="active">
                <?php echo get_phrase('Student_admission'); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>


<div class="panel panel-danger block6" data-step="5" data-intro="<?php echo get_phrase('For Information');?>" data-position='bottom'>
    <div class="panel-heading"> Student Admission Notes
        <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
    </div>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
            <p> Admitting new students will automatically create an enrollment to the selected class in the running session. Please check and recheck the informations you have inserted because once you admit new student, you won't be able to edit his/her class, roll, section without promoting to the next session.</p>
        </div>
    </div>
</div>


<div class="row">
    <?php echo form_open(base_url() . 'index.php?school_admin/student/create/', array('class' => 'form-groups-bordered validate', 'enctype' => 'multipart/form-data', 'id' => 'addStudentForm')); ?>
        <div class="col-md-12">
            <div class="white-box">
                <section>
                    <div class="sttabs tabs-style-flip">
                        <nav>
                            <ul>
                                <li class="active" data-step="6" data-intro="<?php echo get_phrase('Here you can fill student basic information');?>" data-position='top'><a href="#section-flip-5" class="sticon fa fa-info-circle"><span><?php echo get_phrase('information'); ?></span></a></li>
                                <li data-step="7" data-intro="<?php echo get_phrase('Here, you can fill information related to enrollment.');?>" data-position='top'><a href="#section-flip-4" class="sticon fa fa-university"><span><?php echo get_phrase('enroll'); ?></span></a></li>
                                <li data-step="8" data-intro="<?php echo get_phrase('Here, you can fill information related to contact details.');?>" data-position='top'><a href="#section-flip-2" class="sticon fa fa-phone-square"><span><?php echo get_phrase('contact'); ?></span></a></li>
                                <li data-step="9" data-intro="<?php echo get_phrase('Here, you can fill information related to ID card.');?>" data-position='top'><a href="#section-flip-3" class="sticon fa fa-id-card"><span><?php echo get_phrase('ID'); ?></span></a></li>
                                <li data-step="10" data-intro="<?php echo get_phrase('Here, you can fill information related to dormitory, hostel and fees installment.');?>" data-position='top'><a href="#section-flip-5" class="sticon fa fa-bed"><span><?php echo get_phrase('allocation'); ?></span></a></li>
                                <li data-step="11" data-intro="<?php echo get_phrase('Here, you can upload a photo of student.');?>" data-position='top'><a href="#section-flip-6" class="sticon fa fa-camera"><span><?php echo get_phrase('Photo'); ?></span></a></li>
                            </ul>
                        </nav>
                        <div class="content-wrap">

                            <section id="section-flip-1">

                                <div class="row">

                                    <div class="col-md-4 form-group">
                                        <label for="field-1">
                                            <?php echo get_phrase('name'); ?>
                                                <span class="error mandatory"> *</span></label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="ti-user"></i></div>
                                            <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name');?>" placeholder="Enter your First Name" data-validate="required" data-message-required="Please enter your first name "> </div>
                                    </div>

                                    <div class="col-sm-4 form-group">
                                        <label for="field-1">
                                            <?php echo get_phrase('middle_name'); ?>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="ti-user"></i></div>
                                            <input type="text" class="form-control" id="mname" name="mname" value="<?=set_value('mname')?>" placeholder="Enter your Middle Name">
                                        </div>

                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label for="field-1">
                                            <?php echo get_phrase('last_name'); ?>
                                                <span class="error mandatory"> *</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="ti-user"></i></div>
                                            <input type="text" class="form-control" name="lname" value="<?=set_value('lname')?>" placeholder="Enter your Last Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 form-group">
                                        <label for="field-2">
                                            <?php echo get_phrase('DOB'); ?><span class="error mandatory"> *</span></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="icon-calender"></i></div>
                                            <input type="text" class="form-control mydatepicker" name="birthday" placeholder="Date Of Birth" value="<?=set_value('birthday')?>" data-validate="required" data-start-view="2" data-message-required="Please enter your date of birth ">
                                        </div>
                                    </div>

                        
                                    <div class="col-sm-4 form-group">
                                        <label for="field-2">
                                            <?php echo get_phrase('gender'); ?><span class="error mandatory"> *</span></label>

                                        <select name="sex" class="form-control" data-style="form-control" data-validate="required" data-message-required="Please select your gender">
                                            <option value="">
                                                <?php echo get_phrase('select'); ?>
                                            </option>
                                            <option value="Male">
                                                <?php echo get_phrase('male'); ?>
                                            </option>
                                            <option value="Female">
                                                <?php echo get_phrase('female'); ?>
                                            </option>
                                        </select>

                                    </div>

                                    <div class="col-sm-4 form-group">
                                        <label for="field-2">
                                            <?php echo get_phrase('religion'); ?>
                                        </label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-th-large"></i></div>
                                            <input type="text" class="form-control" name="religin" placeholder="Religion" value="<?=set_value('religin')?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 form-group">
                                        <label for="field-1">
                                            <?php echo get_phrase('email'); ?><span class="error mandatory"> *</span></label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-envelope-o"></i></div>

                                            <input id="studentemail" type="email" class="form-control" name="email" placeholder="Enter a valid Email" data-validate="required" value="<?=set_value('email')?>" data-message-required="Please enter a valid Email Id">
                                        </div>
                                        <span id="error_studentemail mandatory"></span>

                                    </div>

                                    <div class="col-sm-4 form-group">
                                        <label for="field-2">
                                            <?php echo get_phrase("category");?><span class="error mandatory"> *</span></label>
                                        <select class="form-control" data-style="form-control" name='category' id='category' data-validate="required" data-message-required="Please select your category">
                                            <option value='<?php echo set_value(' category '); ?>'>Select Category</option>
                                            <option value='GENERAL'>GENERAL</option>
                                            <option value='OBC'>OBC</option>
                                            <option value='ST'>ST</option>
                                            <option value='SC'>SC</option>

                                        </select>
                                    </div>

                                </div>



                                <div class="row">
                                    <div class="col-sm-4 form-group">
                                        <label for="field-1">
                                            <?php echo get_phrase('parent'); ?><span class="error mandatory"> *</span></label>
                                        <div class="input-group">
                                            <input type="hidden" id="parent" class="form-control" name="parent" value="">
                                            <input type="text" id="parent_email" class="form-control" name="parent_email" value="<?=set_value('parent')?>" data-validate="required" data-message-required="Please select parent details from the popup window" disabled>

                                            <span class="input-group-btn" data-step="12" data-intro="From Here you can select parent" data-position='right'>
                                            <a href="#" class="btn fileinput-exists btn-block btn-danger" data-dismiss="fileinput" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_parent/');">Select Parent</a>                                                          
                                        </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right" href="#section-flip-4">
                                    <button type="button" id="btn0" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="13" data-intro="Fill more information please click on 'next' button!" data-position='left'>
                                        <?php echo get_phrase('next'); ?> <i class="fa fa-angle-right"></i>
                                    </button>
                                </div>
                            </section>

                            <section id="section-flip-2">

                                <div class="row">

                                    <div class="col-sm-4 form-group">

                                        <label for="field-1" class="control-label">
                                            <?php echo get_phrase('course'); ?> / Major</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-bars"></i></div>
                                            <input type="text" class="form-control" name="course" placeholder="Course Seeking" value="<?=set_value('course')?>" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 form-group">

                                        <label for="field-2" class="control-label">
                                            <?php echo get_phrase('class'); ?><span class="error mandatory"> *</span></label>

                                        <select name="class_id" class="form-control" data-validate="required" id="class_id" data-style="form-control" data-message-required="Please select a class" onchange="return get_class_sections(this.value)">
                                            <option value="">
                                                <?php echo get_phrase('select'); ?>
                                            </option>
                                            <?php
                                        $classes = $this->db->get('class')->result_array();
                                        foreach ($classes as $row):
                                            ?>
                                                <option value="<?php echo $row['class_id']; ?>">
                                                    <?php echo $row['name']; ?>
                                                </option>
                                                <?php endforeach; ?>
                                        </select>


                                    </div>
                                    <div class="col-sm-4 form-group">

                                        <label for="field-2" class="control-label">
                                            <?php echo get_phrase('section'); ?><span class="error mandatory"> *</span></label>
                                        <select name="section_id" class="form-control" id="section_selector_holder" data-validate="required" data-message-required="Please select a section" onchange="return checkavailability(this.value);">
                                            <option value="">
                                                <?php echo get_phrase('select_class_first'); ?>
                                            </option>
                                        </select>

                                        <span id="availability mandatory"></span>
                                    </div>
                                </div>
                                <div class="row">
                                
                                    <div class="col-sm-4 form-group">

                                        <label for="field-2" class="control-label">
                                            <?php echo get_phrase('previous_school'); ?>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-university"></i></div>
                                            <input type="text" class="form-control" name="previous_school" placeholder="Previous School" value="<?=set_value('previous_school')?>">

                                        </div>
                                    </div>


                                </div>


                                
                            </section>

                            <section id="section-flip-3">

                                <div class="row">
                                    
                                <div class="col-sm-4 form-group">

                                        <label for="field-2" class="control-label">
                                            <?php echo get_phrase('address'); ?><span class="error mandatory"> *</span></label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-map-signs"></i></div>
                                            <textarea class="form-control" rows="1" name="address" placeholder="Address" data-validate="required" data-message-required="Please enter an address for communication" autofocus><?=set_value('address')?></textarea>
                                        </div>

                                    </div>

                                    <div class="col-sm-4 form-group">

                                        <label for="field-1" class="control-label">
                                            <?php echo get_phrase('city'); ?><span class="error mandatory"> *</span></label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-map-o"></i></div>
                                            <input type="text" class="form-control" name="city" value="<?=set_value('city')?>" data-validate="required" title="" data-message-required="Please enter a city" maxlength="50">
                                            <span id="error_city mandatory"></span>
                                        </div>

                                    </div>

                                    <div class="col-sm-4 form-group">

                                        <label for="field-1" class="control-label">
                                            <?php echo get_phrase('country'); ?><span class="error mandatory"> *</span></label>
                                        <div>


                                            <select id="country" name="country" class="form-control" data-validate="required" data-message-required="Please select your country of residence">
                                                <option value="">--Select Country--</option>
                                                <?php foreach($countries as $key=>$country){ ?>
                                                    <option value="<?php echo $country;?>">
                                                        <?php echo $country;?>
                                                    </option>
                                                    <?php
                                        }
                                        ?>
                                            </select>

                                        </div>

                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-sm-4 form-group">

                                        <label for="field-1" class="control-label">
                                            <?php echo get_phrase('nationality'); ?><span class="error mandatory"> *</span></label>

                                        <select id="nationality" name="nationality" class="form-control" data-validate="required" data-message-required="Please enter your nationality">

                                            <option value="">--Select Nationality--</option>
                                            <?php foreach($countries as $key=>$country){ ?>
                                                <option value="<?php echo $country;?>">
                                                    <?php echo $country;?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>

                                    </div>

                                    <div class="col-sm-4 form-group">
                                        <div class="form-group">
                                            <label for="field-1" class="control-label">
                                                <?php echo get_phrase('place_of_birth'); ?><span class="error mandatory"> *</span></label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
                                                <input type="text" class="form-control" name="place_of_birth" value="<?=set_value('place_of_birth')?>" placeholder="Birth City" data-validate="required" value="" data-message-required="Please enter your place of birth">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <div class="form-group">
                                            <label for="field-1" class="control-label">
                                                <?php echo get_phrase('phone'); ?><span class="error mandatory"> *</span></label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                                <input type="tel" class="form-control numeric" name="phone" value="<?=set_value('phone')?>" data-validate="required" title="" data-message-required="Please enter a valid phone number" maxlength="10">
                                                <span id="error_phone mandatory"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="button" id="btn2" class="fcbtn btn btn-danger btn-outline btn-1d">Next <i class="fa fa-angle-right"></i></button>
                                </div>


                            </section>
                            <section id="section-flip-4">

                                <div class="row">
                                    <div class="col-sm-4 form-group">

                                        <label for="field-2" class="control-label">
                                            <?php echo get_phrase('Card ID'); ?><span class="error mandatory"> *</span></label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-id-badge"></i></div>
                                            <input type="text" class="form-control" name="card_id" value="<?=set_value('card_id')?>" placeholder="Enter RFID No" data-validate="required" data-message-required="Please enter your RFID number">
                                        </div>

                                    </div>

                                    <div class="col-sm-4 form-group">

                                        <label for="field-1" class="control-label">
                                            <?php echo get_phrase('passport_number'); ?>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-id-card-o"></i></div>
                                            <input type="text" class="form-control" name="passport_no" value="<?=set_value('passport_no')?>" placeholder="Enter Passsport No">
                                        </div>

                                    </div>
                                    <div class="col-sm-4 form-group">

                                        <label for="field-1" class="control-label">
                                            <?php echo get_phrase('icard_no'); ?><span class="error mandatory"> *</span></label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-address-card-o"></i></div>
                                            <input type="text" class="form-control" name="icard_no" placeholder="Enter any Identity Card No" data-validate="required" value="<?=set_value('icard_no')?>" data-message-required="Please enter any of your identity card number">
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 form-group">

                                        <label for="field-2" class="control-label">
                                            <?php echo get_phrase('icard_type'); ?><span class="error mandatory"> *</span></label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-server"></i></div>
                                            <input type="text" class="form-control" name="type" data-validate="required" placeholder="Identity Card Type" value="<?=set_value('type')?>" data-message-required="Please enter the type of your identity card">
                                        </div>

                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="button" id="btn3" href="" class="fcbtn btn btn-danger btn-outline btn-1d">Next <i class="fa fa-angle-right"></i></button>
                                </div>
                            </section>

                            <section id="section-flip-5">
                                <div class="row">

                                    <div class="col-sm-4 form-group">

                                        <label for="field-2" class="control-label">
                                            <?php echo get_phrase('dormitory'); ?>
                                        </label>

                                        <select name="dormitory_id" id="dormitory_id" class="form-control selectboxit">
                                            <option value="">
                                                <?php echo get_phrase('no_dormitory'); ?>
                                            </option>
                                            <?php
                                            foreach ($dormitories as $row):
                                                ?>
                                                <option value="<?php echo $row['dormitory_id']; ?>">
                                                    <?php echo $row['name']; ?>
                                                </option>

                                                <?php endforeach; ?>
                                        </select>
                                        <span id="dormitory_fee_idError" class="error"></span>

                                    </div>
                                    
                                    <div class="col-sm-4 form-group">
                                        <label for="field-2" class="control-label">
                                            <?php echo get_phrase('hostel_room'); ?>
                                        </label>
                                        <select name="room_id" id="room_id" class="form-control selectboxit">
                                            <option value="">
                                                <?php echo get_phrase('no_hostel_selected'); ?>
                                            </option>
                                        </select>
                                        <span id="room_idError" class="error"></span>
                                        <input type="hidden" value="" id="dormitory_fee_id" name="dormitory_fee_id">
                                    </div>

                                    <div class="col-sm-4 form-group">

                                        <label for="field-2" class="control-label">
                                            <?php echo get_phrase('transport_route'); ?>
                                            <span id="rout_idError" class="error mandatory"></span>
                                        </label>

                                        <select name="route_id" id="route_id" class="form-control selectboxit">
                                            <option value="">
                                                <?php echo get_phrase('no_transport_service'); ?>
                                            </option>
                                            <?php
                                            foreach ($transports as $row):
                                                ?>
                                                <option value="<?php echo $row['transport_id']; ?>">
                                                    <?php echo $row['route_name']; ?>
                                                </option>
                                                <?php endforeach; ?>
                                        </select>
                                        
                                    </div>
                                    
                                    <div class="col-sm-4 form-group">

                                        <label for="field-2" class="control-label">
                                            <?php echo get_phrase('bus_stop'); ?>
                                            <span id="transport_fee_idError" class="error mandatory"></span>
                                        </label>

                                        <select name="transport_id" id="transport_id" class="form-control selectboxit">
                                            <option value="">
                                                <?php echo get_phrase('select_route'); ?>
                                            </option>

                                        </select>
                                        
                                        <input type="hidden" value="" id="transport_fee_id" name="transport_fee_id">
                                    </div>

                                    <div class="col-sm-4 form-group">

                                        <label class="control-label">
                                            <?php echo get_phrase('location'); ?><span class="error mandatory"> *</span></label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
                                            <input id="searchLocation" type="text" class="form-control" name="searchLocation" value="<?=set_value('searchLocation')?>" data-validate="required" data-message-required="Please enter your location">

                                        </div>

                                    </div>
                                    
                                    <div class="col-sm-4 form-group">
                                        <label for="field-2" class="control-label"><?php echo get_phrase('scholarship'); ?></label>
                                        <select name="scholarship_id" id="scholarship_id" class="form-control selectboxit">
                                            <?php if($scholarships) { ?>
                                                <option value=""><?php echo get_phrase('select'); ?></option>
                                            <?php foreach ($scholarships as $row): ?>
                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['scholarship_name']; ?></option>
                                            <?php endforeach; } else { ?>
                                                <option value=""><?php echo get_phrase('no_scholarship_set');?></option>
                                            <?php }  ?>
                                        </select>

                                    </div>
                                    
                                    <div class="col-sm-4 form-group">
                                        <label for="field-2" class="control-label"><?php echo get_phrase('school_fee_instalment'); ?> <span class="error mandatory"> *</span></label>
                                        
                                        <select name="tutionfee_inst_type" id="tutionfee_inst_type" class="form-control selectboxit">
                                            <?php if($fee_installment['school_fee_inst']) { ?>
                                                <option value=""><?php echo get_phrase('select'); ?></option>
                                            <?php foreach ($fee_installment['school_fee_inst'] as $row): ?>
                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['installment_name']."(".$row['no_of_installment'].")"; ?></option>
                                            <?php endforeach; } else { ?>
                                                <option value=""><?php echo get_phrase('school_fee_instalment_not_set');?></option>
                                            <?php }  ?>
                                        </select>

                                    </div>
                                    
                                    <div class="col-sm-4 form-group">
                                        <label for="field-2" class="control-label"><?php echo get_phrase('transport_fee_instalment'); ?></label>
                                        <select name="transpfee_inst_type" id="transpfee_inst_type" class="form-control selectboxit">
                                            <?php if($fee_installment['transp_fee_inst']) { ?>
                                                <option value=""><?php echo get_phrase('select'); ?></option>
                                            <?php foreach ($fee_installment['transp_fee_inst'] as $row): ?>
                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['installment_name']."(".$row['no_of_installment'].")"; ?></option>
                                            <?php endforeach; } else { ?>
                                                <option value=""><?php echo get_phrase('transport_fee_instalment_not_set');?></option>
                                            <?php }  ?>
                                        </select>

                                    </div>
                                    
                                    <div class="col-sm-4 form-group">
                                        <label for="field-2" class="control-label"><?php echo get_phrase('hostel_fee_instalment'); ?></label>
                                        <select name="hostfee_inst_type" id="hostfee_inst_type" class="form-control selectboxit">
                                            <?php if($fee_installment['hostel_fee_inst']) { ?>
                                                <option value=""><?php echo get_phrase('select'); ?></option>
                                            <?php foreach ($fee_installment['hostel_fee_inst'] as $row): ?>
                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['installment_name']."(".$row['no_of_installment'].")"; ?></option>
                                            <?php endforeach; } else { ?>
                                                <option value=""><?php echo get_phrase('hostel_fee_instalment_not_set');?></option>
                                            <?php }  ?>
                                        </select>

                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="button" id="btn4" class="fcbtn btn btn-danger btn-outline btn-1d">Next <i class="fa fa-angle-right"></i></button>
                                </div>


                            </section>



                            <section id="section-flip-6">

                           
                                    <div class="white-box">
                                        <label for="field-2">
                                            <?php echo get_phrase('upload_photo'); ?>
                                                <span class="error mandatory"> *</span></label>

                                                <input type="file" name="userfile" id="input-file-now" class="dropify" /> </div>
                             


                                <div class="text-right">
                                    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d">Add Student</button>
                                </div>


                            </section>
                        </div>
                        <!-- /content -->
                    </div>
                    <!-- /tabs -->
                </section>
            </div>
        </div>
        <?php echo form_close(); ?>
</div>


<script type="text/javascript">
    
    $(document).ready(function() {
        $('#transport_id').change(function() { 
            var transport_id        =   $(this).val();
            $('#transport_fee_idError').html('');
            $.ajax({
                dataType    : 'json',
                url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_transportfee/' +transport_id ,
                success: function(response) {
                    if(response.status == "success") {
                        $('#transport_fee_id').val(response.transport_fee);
                    } else {
                        $('#transport_fee_idError').html(response.message);
                    }
                }
            });
        });
        
        $("#route_id").change(function(){ 
            var route_id = $(this).val(); 
                $.ajax({
                    url: '<?php echo base_url(); ?>index.php?ajax_controller/get_bus_stop/' + route_id,
                    success: function (response)
                    {
                        jQuery('#transport_id').html(response);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });
        });
        
        $('#dormitory_id').change(function() {
            var dormitory_id        =   $(this).val();
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_free_hostel_room/' +dormitory_id ,
                success: function(response) {
                    $('#room_id').html(response);
                }
            });
        });
        
        $('#room_id').change(function() {
            var room_id        =   $(this).val();
            $('#room_idError').html('');
            $.ajax({
                dataType    : 'json',
                url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_dormitoryfee/' +room_id ,
                success: function(response) {
                    if(response.status == "success") {
                        $('#dormitory_fee_id').val(response.hostel_fee);
                    } else {
                        $('#room_idError').html(response.message);
                    }
                }
            });
        });
        
    });

    $(function() {
        $(".datepicker").datepicker({
            dateFormat: "dd/mm/yy",
            changeMonth: true,
            changeYear: true,
            endDate: '+0d',
            autoclose: true
        });
    });

    function agecalculate() {
        var dob = $(".datepicker").val();
        var now = new Date();
        var d = new Date();
        var year = d.getFullYear() - 3;
        d.setFullYear(year);
        var birthdate = dob.split("/");
        var born = new Date(birthdate[2], birthdate[1] - 1, birthdate[0]);
        age = get_age(born, now);
        if (age <= 3) {
            alert("Age should be greater than or equal to 3");
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
            success: function(response) {
                jQuery('#section_selector_holder').html(response);
            }
        });
    }

    function checkemail() {
        var email = $("#studentemail").val();
        if (email) {
            $.ajax({
                type: 'post',
                url: '<?php echo base_url();?>index.php?school_admin/get_class_students_mass/',
                data: {
                    user_name: name
                },
                success: function(response) {
                    $('#name_status').html(response);
                    if (response == "OK") {
                        return true;
                    } else {
                        return false;
                    }
                }
            });
        } else {
            $('#name_status').html("");
            return false;
        }
    }


    $('#btn0').on('click', function() {

        var email = document.getElementById('studentemail').value;
        validate_email(encodeURIComponent(email));

        function validate_email(email) {
            $('#error_studentemail').hide();

            mycontent = $.ajax({
                async: false,
                dataType: 'json',
                type: 'POST',
                url: "<?php echo base_url(); ?>index.php?Ajax_controller/check_email_exist_allusers/",
                data: {
                    email: email
                },
                success: function(response) {
                    if (response.email_exist == "1") {
                        $('#error_studentemail').html(response.message).show();
                        return false;
                    } else {
                        if ($("#addStudentForm").valid()) {
                            $("#tabs").tabs({
                                active: 1
                            });
                            $("ul.nav li.active").removeClass("active");
                            $(this).addClass("active");
                            var current = $('#ui-id-2');
                            current.css('background-color', '#a02d2d');
                            current.css('color', '#ffffff');
                        }
                    }
                },
                error: function(error_param, error_status) {

                }
            });


        }
    });

    $('#btn1').on('click', function() {
        if ($("#addStudentForm").valid()) {

            $("#tabs").tabs({
                active: 2
            });

            var prev = $('#ui-id-2');
            prev.css('background-color', '#fff');
            prev.css('color', '#555555');
            var current = $('#ui-id-3');
            current.css('background-color', '#a02d2d');
            current.css('color', '#ffffff');
        }
    });

    $('#btn2').on('click', function() {
        if ($("#addStudentForm").valid()) {

            $("#tabs").tabs({
                active: 3
            });
            var prev = $('#ui-id-3');
            prev.css('background-color', '#fff');
            prev.css('color', '#555555');
            var current = $('#ui-id-4');
            current.css('background-color', '#a02d2d');
            current.css('color', '#ffffff');
        }
    });


    $('#btn3').on('click', function() {
        if ($("#addStudentForm").valid()) {

            $("#tabs").tabs({
                active: 4
            });

            var prev = $('#ui-id-4');
            prev.css('background-color', '#fff');
            prev.css('color', '#555555');
            var current = $('#ui-id-5');
            current.css('background-color', '#a02d2d');
            current.css('color', '#ffffff');
        }
    });
    $('#btn4').on('click', function() {
        if ($("#addStudentForm").valid()) {

            $("#tabs").tabs({
                active: 5
            });
            var prev = $('#ui-id-5');
            prev.css('background-color', '#fff');
            prev.css('color', '#555555');
            var current = $('#ui-id-6');
            current.css('background-color', '#a02d2d');
            current.css('color', '#ffffff');
        }
    });


    function allnumeric(inputtxt) {
        var numbers = /^[0-9]+$/;
        if (inputtxt.value.match(numbers)) {
            alert('Your Registration number has accepted....');
            document.form1.text1.focus();
            return true;
        } else {
            alert('Please input numeric characters only');
            document.form1.text1.focus();
            return false;
        }
    }

    function Validate() {
        var phone = $("#phone");
        if (phone.val().length > 10) {
            $('#error_phone').html('Maximum 10 digits are allowed');
            return false;

        } else if (phone.val().length < 7) {
            $('#error_phone').html('Invalid contact number');

            $("#hidden").val('1');
            return false;
        } else if (isNaN(phone.val())) {
            $('#error_phone').html('Enter a valid phone number');
            return false;

        } else {
            $('#error_phone').html('');
            return true;
        }
    }

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var phone = $("#phone");
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            $('#error_phone').html('Enter numeric value only');
            $("#phone").val('');

            $("#hidden").val('1');

            //return false;

        } else if (phone.val().length > 10) {
            $('#error_phone').html('Maximum 10 digits are allowed');
            //return false;
            $("#hidden").val('1');

        } else if (phone.val().length < 7) {
            $('#error_phone').html('Invalid contact number');
            // return false;
            $("#hidden").val('1');

        } else {
            $('#error_phone').html('');
            $("#hidden").val('0');
            return true;
        }
    }

    function checkavailability(section_id) {
        var class_id = $('#class_id').val();
        $.ajax({
            url: '<?php echo base_url();?>index.php?ajax_controller/check_availability',
            type: 'POST',
            data: {
                class_id: class_id,
                section_id: section_id
            },
            success: function(response) {
                count = JSON.parse(response);
                if (count.allowed === 'no') {
                    $('#availability').html('This section is already filled, try another section');
                } else {
                    $('#availability').html('');
                }
            },
            error: function() {
                alert('error');
            }
        });
    }

</script>