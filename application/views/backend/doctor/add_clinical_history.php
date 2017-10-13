<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"><h4 class="page-title"><?php echo $page_title; ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>

        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?doctor/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?doctor/clinical_history"><?php echo get_phrase('clinical_history'); ?></a></li>                          <li class="active"><?php echo $page_title; ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<div class="row">
    <div class="col-md-12">
        <div class="white-box" data-step="5" data-intro="<?php echo get_phrase('To fill this form you can add warden.'); ?>" data-position='top'>
            <?php echo form_open(base_url() . 'index.php?doctor/add_clinical_history/create'); ?> 
            <div class="row">          
                <div class="col-xs-12 col-md-6 form-group">
                    <label for="field-2"><?php echo get_phrase('class'); ?><span class="error mandatory"> *</span></label>
                    <select id="class_id_holder" name="class_id" class="selectpicker" data-style="form-control" data-live-search="true" onchange="select_section(this.value)" required="required" >
                        <option value=""><?php echo get_phrase('select_class'); ?></option>
                        <?php foreach ($classes as $row): ?>
                            <option value="<?php echo $row['class_id']; ?>">          
                                <?php echo $row['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <span></span>
                </div> 

                <div class="col-xs-12 col-md-6 form-group">
                    <label class="control-label"><?php echo get_phrase('select_section'); ?><span class="error mandatory"> *</span></label>
                    <select id="section_holder" name="section_id" class="selectpicker" data-style="form-control" onchange="onsectionchange(this);" data-step="7" data-intro="<?php echo get_phrase('Here select you section for which you want to progress detail'); ?> " data-position='top' required="">
                        <option value="">Select Section</option>
                        </select>
                    <span></span>
                </div>

                <div class="col-xs-12 col-md-6 form-group">
                    <label class="control-label"><?php echo get_phrase('student'); ?><span class="error mandatory"> *</span></label>
                    <?php //pre($students); die;?>
                    <select id="student_holder" name="student_id" class="selectpicker" data-style="form-control" data-step="10" data-intro="<?php echo get_phrase('Here select you student for which you want to progress detail '); ?>" data-position='top' required="">  <option value="">Select Student</option>
                        <?php foreach ($students as $data) { ?>
                            <option value="<?php echo $data['student_id']; ?>" <?php if ($student_id == $data['student_id']) echo "selected"; ?>><?php echo $data['name']; ?></option>
                        <?php } ?>
                    </select>
                    <span></span>
                </div>
                <div class="col-xs-12 col-md-6 form-group">
                    <label for="field-1"><?php echo get_phrase('symptoms'); ?><span class="mandatory"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-user"></i></div>
                        <input type="text" class="form-control" data-validate="required"  name="symptoms" placeholder="Symptoms" required=""> 
                    </div>
                    <label class="mandatory"> <?php echo form_error('symptoms'); ?></label>
                </div>                 
                <div class="col-xs-12 col-md-6 form-group">
                    <label for="field-1"><?php echo get_phrase('prescription'); ?><span class="mandatory"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                        <input type="text" class="form-control" name="precription" placeholder="Prescription" required=""> 
                    </div>
                    <label class="mandatory"> <?php echo form_error('precription'); ?></label>
                </div>
                <div class="col-xs-12 col-md-6 form-group">
                    <label for="field-1"><?php echo get_phrase('Diagnosis'); ?><span class="mandatory"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-envelope-o"></i></div>
                        <input type="text" class="form-control" name="diagnosis" placeholder="Diagnosis" required=""> 
                    </div>
                    <label class="mandatory"> <?php echo form_error('diagnosis'); ?></label>
                </div>
                <div class="col-xs-12 col-md-6 form-group">
                    <label for="field-1"><?php echo get_phrase('start_date'); ?><span class="mandatory"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="icon-calender"></i></div>
                        <input type="text" class="form-control mydatepicker" name="start_date" placeholder="mm/dd/yyyy" required=""> 
                    </div>
                    <label class="mandatory"> <?php echo form_error('start_date'); ?></label>
                </div>
                <div class="col-xs-12 col-md-6 form-group">
                    <label for="field-1"><?php echo get_phrase('end_date'); ?><span class="mandatory"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="icon-calender"></i></div>
                        <input type="text" class="form-control mydatepicker" name="end_date" placeholder="mm/dd/yyyy" required=""> 
                    </div>
                    <label class="mandatory"> <?php echo form_error('end_date'); ?></label>
                </div>

            </div>

            <!--           
            <!----CREATION FORM ENDS-->
            <div class="text-right">
                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit'); ?></button>
            </div> 

            <?php echo form_close(); ?>

        </div>
    </div></div>

<script type="text/javascript">
    function select_section(class_id) {
        
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_sections_by_class/' + class_id,
            success: function (response) {
                jQuery('#section_holder').html(response).selectpicker('refresh');
            }
        });
    }

    function onsectionchange(section_id)
    {
        var class_id = $('#class_id_holder').val();
        jQuery('#student_holder').html('<option value="">Select Student</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>/index.php?doctor/get_student_by_section_class/' + section_id.value + '/' + class_id,
            success: function (response)
            {
                jQuery('#student_holder').append(response).selectpicker('refresh');
            }
        });
        $('#student_holder').trigger("chosen:updated");
    }

</script>

