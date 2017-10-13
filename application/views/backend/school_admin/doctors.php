<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('doctors'); ?></h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour"  class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/doctors"><?php echo get_phrase('doctor'); ?></a></li>
        </ol>
    </div>
</div>

    <?php
    $msg = $this->session->flashdata('flash_validation_error');
    if ($msg) {
        ?>        
    <div class="alert alert-danger">
    <?php echo $msg; ?>
    </div>
<?php } ?>
<div class="white-box">        
    <section>
        <div class="sttabs tabs-style-flip">
            <nav>
                <ul>
                    <li id="section1">
                        <a href="#section-flip-1" class="sticon fa fa-list "data-step="5" data-intro="<?php echo get_phrase('Here you can see doctor list.'); ?>" data-position='right'><span>
<?php echo get_phrase('doctor_list'); ?></span></a>
                    </li>
                    <li id="section2">
                        <a href="#section-flip-2" class="sticon fa fa-plus" data-step="6" data-intro="<?php echo get_phrase('From here you can add a doctor.'); ?>" data-position='left'><span>
<?php echo get_phrase('add_doctor'); ?></span></a>
                    </li>                
                </ul>
            </nav>                                    
            <div class="content-wrap">
                <section id="section-flip-1">
                    <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
                        <thead>
                            <tr>
                                <th><div><?php echo get_phrase('s._no.'); ?></div></th>
                                <th><div><?php echo get_phrase('name'); ?></div></th>
                                <th><div><?php echo get_phrase('email'); ?></div></th>
                                <th><div><?php echo get_phrase('phone'); ?></div></th>
                                <th><div><?php echo get_phrase('status'); ?></div></th>
                                <th><div data-step="8" data-intro="<?php echo get_phrase('You can edit or delete a doctor from here.'); ?>" data-position='left'><?php echo get_phrase('option'); ?></div></th>
                                <th><div data-step="8" data-intro="<?php echo get_phrase('You can edit or delete a doctor from here.'); ?>" data-position='left'><?php echo get_phrase('action'); ?></div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($doctor_list)) {
                                $count = 1;
                                foreach ($doctor_list as $row):
                                    if ($row['status'] == '1') {
                                        $lable = "disable";
                                        $status = "Enabled";
                                    } else {
                                        $lable = "Enable";
                                        $status = "Disabled";
                                    }
                                    ?>
                                    <tr><td><?php echo $count++; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['phone_no']; ?></td>
                                        <td><?php echo $status; ?></td>
                                        <td><div class="btn-group">
                                                <button type="button" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light">
                                                    View Details <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-default pull-right pos-static" role="menu">
                                                    <li>
                                                        <a href="javascript: void(0);" onclick="confirm_print('<?php echo base_url(); ?>index.php?school_admin/doctors/status_change/<?php echo $row['doctor_id']; ?>/<?php echo $row['status']; ?>', 'Are you sure to execute this action ?');"><?php echo $lable; ?></a></li>
                                                    <li>
                                                </ul>
                                            </div></td>
                                        <td>
                                            <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_view_doctor/<?php echo $row['doctor_id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View Profile" title=""><i class="fa fa-eye"></i></button></a>
                                            <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_doctor/<?php echo $row['doctor_id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></button></a>
                                            <a href="javascript: void(0);" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/doctors/delete/<?php echo $row['doctor_id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button></a>
                                        </td> 
                                    </tr>
    <?php endforeach; ?>

                    <?php } ?>
                        </tbody>
                    </table>
                </section>

                <section id="section-flip-2">
<?php echo form_open(base_url() . 'index.php?school_admin/doctors/create', array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('name'); ?><span class="mandatory"> *</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                <input type="text" class="form-control" data-validate="required"  name="name" placeholder="Doctor Name" required=""> 
                            </div>
                            <label class="mandatory"> <?php echo form_error('name'); ?></label>
                        </div> 
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('email'); ?><span class="mandatory"> *</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-envelope-o"></i></div>
                                <input type="text" class="form-control" name="email" placeholder="Email Address" required=""> 
                            </div>
                            <label class="mandatory"> <?php echo form_error('email'); ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('Phone_Number'); ?><span class="mandatory"> *</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                <input type="text" class="form-control" name="phone_no" placeholder="Contact Number" maxlength="10" required="" onkeypress="return valid_only_numeric(event);"> 
                            </div>
                            <label class="mandatory"> <?php echo form_error('phone_no'); ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('Address'); ?><span class="mandatory"> *</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-address-card"></i></div>
                                <input type="text" class="form-control" name="address" placeholder="Address" required=""> 
                            </div>
                            <label class="mandatory"> <?php echo form_error('address'); ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('year_of_experience'); ?><span class="mandatory"> *</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar-check-o"></i></div>
                                <input type="text" class="form-control" name="year_of_exp" placeholder="Year of Experience" required="" onkeypress="return valid_only_numeric(event);"> 
                            </div>
                            <label class="mandatory"> <?php echo form_error('year_of_exp'); ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('specialization'); ?><span class="mandatory"> *</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar-plus-o"></i></div>
                                <textarea class="form-control" name="specialization" placeholder="Specialization" required=""></textarea>
                            </div>
                            <label class="mandatory"> <?php echo form_error('specialization'); ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('department'); ?><span class="mandatory"> *</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-dashcube"></i></div>
                                <textarea class="form-control" name="department" placeholder="Department" required=""></textarea>
                            </div>
                            <label class="mandatory"> <?php echo form_error('department'); ?></label>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('qualification'); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-quote-right"></i></div>
                                <input type="text" class="form-control" name="qualification" placeholder="Qualification">
                            </div>
                            <label class="mandatory"> <?php echo form_error('qualification'); ?></label>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('education_background'); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-graduation-cap"></i></div>
                                <textarea class="form-control" name="education_background" placeholder="Education Background"></textarea>
                            </div>
                            <label class="mandatory"> <?php echo form_error('education_background'); ?></label>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('before_place_work'); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
                                <input type="text" class="form-control" name="before_place_work" placeholder="Before Place Work">
                            </div>
                            <label class="mandatory"> <?php echo form_error('before_place_work'); ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('achivement_award'); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-trophy"></i></div>
                                <textarea class="form-control" name="achivement_award" placeholder="Achivement Awards"></textarea>
                            </div>
                            <label class="mandatory"> <?php echo form_error('achivement_award'); ?></label>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit'); ?></button>
                    </div>
<?php echo form_close(); ?> 
                </section>             
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    function valid_only_numeric(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

</script>