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
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/manage_camp"><?php echo get_phrase('manage_camp'); ?></a></li>
            <li class="active"> <span><?php echo get_phrase($page_title); ?></span></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>            

<div class="col-md-12 white-box" data-step="5" data-intro="<?php echo get_phrase('To_fill_the_details, you_can_add_a_new_subject_from_here.');?>" data-position='top'>
    <?php echo form_open(base_url() . 'index.php?school_admin/manage_camp/create', array('class' => ' form-groups-bordered validate', 'target' => '_top')); ?>
    <div class="row">          
        <div class="col-xs-12 col-md-offset-3 col-md-6 m-b-20">
            <label for="field-1"><?php echo get_phrase('camp_name'); ?><span class="error mandatory"> *</span></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-cube"></i></div>
                <input type="text" class="form-control" data-validate="required" required="required" id="camp_name" placeholder="Camp Name" name="camp_name" data-message-required="<?php echo get_phrase('please_enter_required_value'); ?>"> 
            </div>                                        
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
    <div class="row">
        <div class="col-xs-12 col-md-offset-3 col-md-6 m-b-20">
            <label for="field-2"><?php echo get_phrase('doctor_name'); ?><span class="error mandatory"> *</span></label>
            <select id="doctor_name" name="doctor_name" class="selectpicker" data-style="form-control" data-live-search="true" required="required" >
                <option value=""><?php echo get_phrase('select_doctor'); ?></option>
                <?php foreach ($doctor_name_list as $row): ?>
                    <option value="<?php echo $row['doctor_id']; ?>">          
                        <?php echo $row['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <span></span>
        </div> 
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-offset-3 col-md-6 m-b-20">
            <label for="field-1"><?php echo get_phrase('description'); ?></label>
            <textarea name="description" data-style="form-control" data-live-search="true" id="description" class="form-control"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-offset-3 col-md-6 m-b-20">
            <label for="field-1"><?php echo get_phrase('camp_start_date'); ?><span class="error mandatory"> *</span></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="icon-calender"></i></div>
                <input type="text" class="form-control mydatepicker" data-validate="required" required="required" id="camp_start_date" placeholder="MM/DD/YYYY" name="camp_start_date" data-message-required="<?php echo get_phrase('please_enter_required_value'); ?>"> 
            </div>                                        
        </div> 
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-offset-3 col-md-6 m-b-20">
                <label for="field-1"><?php echo get_phrase('camp_last_date'); ?><span class="error mandatory"> *</span></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="icon-calender"></i></div>
                    <input type="text" class="form-control mydatepicker" data-validate="required" required="required" id="camp_last_date" placeholder="MM/DD/YYYY" name="camp_last_date" data-message-required="<?php echo get_phrase('please_enter_required_value'); ?>"> 
                </div>                                        
        </div> 
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-offset-3 col-md-6 m-b-20">
                <label for="field-1"><?php echo get_phrase('class_name'); ?><span class="error mandatory"> *</span></label>
                <select id="class_name" name="class_name" class="selectpicker" data-style="form-control" data-live-search="true" required="required" >
                <option value=""><?php echo get_phrase('select_class'); ?></option>
                <?php foreach ($class_array as $row): ?>
                    <option value="<?php echo $row['class_id']; ?>">          
                        <?php echo $row['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>                                       
        </div> 
    </div>

    <!--           
    <!----CREATION FORM ENDS-->
    <div class="text-right">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('add_camp'); ?></button>
    </div>
    <?php echo form_close(); ?> 
</div>