<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('view_attendance_report'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?parents/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase('view_attendance_report'); ?></li>
        </ol>
    </div>
</div>

<div class="col-md-12 white-box">
    <?php echo form_open(base_url() . 'index.php?parents/attendance_report_selector/'); ?>
    <input type="hidden" name="student_id" value="<?php echo $student_id;?>">
    <input type="hidden" name="class_id" value="<?php echo $class_id;?>">
    <input type="hidden" name="section_id" value="<?php echo $section_id;?>">
    <div class="col-sm-5 form-group"  data-step="5" data-intro="<?php echo get_phrase('Select month from here.');?>" data-position='top'>
        <label for="field-1"><?php echo get_phrase('Select_month');?><span class="error" style="color: red;"> *</span></label>
        <select name="month" class="selectpicker" id="month" class="selectpicker" data-style="form-control" data-live-search="true">
            <?php $month_arr    =   array('1' => 'January', '2'=>'February', '3'=>'March', '4'=>'April', '5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December'); ?>          
            <?php foreach($month_arr AS $key =>$val): ?>
            <option value="<?php echo $key; ?>" <?php if ($month == $key) echo 'selected'; ?> > <?php echo $val; ?></option>
            <?php endforeach;?>
        </select> 
        <label style="color:red;"> <?php echo form_error('month'); ?></label>
    </div>
    <input type="hidden" name="year" value="<?php echo $running_year; ?>">
    <div class="text-right col-sm-7">
	<button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d m-t-5" data-step="6" data-intro="<?php echo get_phrase('On the click of this button you will see the Report of selecting month!');?>" data-position='left'><?php echo get_phrase('show_report');?></button>
    </div>
    <?php echo form_close();?>
</div>

<div class="col-md-12 white-box">
    <?php if ($class_id != '' && $section_id != '' && $month != ''): ?>
    <div class="text-center">
        <h3><b><?php echo get_phrase('attendance_sheet_of_')." ".$student_name; ?> <?php echo " for the month of "?>
        <?php foreach($month_arr AS $key =>$val){
            if ($month == $key)
             echo $val;
        }
        ?></b></h3>
        <h4><?php echo 'Class '.$class_name; ?> <?php echo get_phrase('section'); ?> <?php echo $section_name;?></h4>
    </div>
    <?php endif; ?>


    <table class="table table-bordered hidden-sm hidden-xs hidden-md" data-step="7" data-intro="<?php echo get_phrase('This is a report of attendance');?>" data-position='top'>
        <thead>
            <tr>
                <td class="text-center">
                    <?php echo get_phrase('students'); ?> <i class="fa fa-arrow-down"></i> | <?php echo get_phrase('date'); ?> <i class="fa fa-arrow-right"></i>
                </td>
                <?php                    
                    for ($i = 1; $i <= $days; $i++) { ?>
                    <td class="text-center"><?php echo $i; ?></td>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
        <?php  $data = array(); ?>
        <tr>
            <td style="text-align: center;">
            <?php echo $student_name; ?>
            </td>
            <?php
                //$status = 0;
                for ($i = 1; $i <= $days; $i++) {?>
            <td style="text-align: center;font-weight: bold;">
                <?php echo $studentAttendanceArr[$i];?>
            </td>
            <?php } ?>
        </tr>
        </tbody>
        </table>
</div>

