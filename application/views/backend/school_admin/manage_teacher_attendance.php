<?php 
    $year           =   explode('-', $running_year);
    $timestamp      =   strtotime(date('j') . '-' . date('n') . '-' . $year[0]);
?>

<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('manage_daily_attendance'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
         <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>

            <?php $BRC = get_bread_crumb(); if (strpos($BRC, '^') !== false) { $ExpBrd = explode('^', $BRC);?>
            <li>
                <?php echo get_phrase(@$ExpBrd[0]); ?>
                <?php echo @$ExpBrd[1]; ?>
            </li> <?php }else{ $ExpBrd[2] = $BRC;}?>
            <li class="active">
                <?php echo get_phrase(@$ExpBrd[2]); ?>
            </li>
        </ol>
    </div>
</div>

<?php echo form_open(base_url() . 'index.php?school_admin/manage_teacher_attendance/', array('class' => 'validate','id'=>'manageAttendanceForm'));?>
<div class="col-md-12 white-box" data-step="5" data-intro="<?php echo get_phrase('Here select the class,section and date.');?>" data-position='top'>
    <div class="col-sm-4 form-group">               
        <label for="field-1"><?php echo get_phrase('select_date');?><span class="error" style="color: red;"> *</span></label>
        <div class="input-group">
            <span class="input-group-addon"><i class="icon-calender"></i></span>
            <input type="text" id="mydatepicker_holiday_disable" class="form-control" name="date" value="<?php echo date('d/m/Y')?>" 
            placeholder="<?php echo get_phrase('MM/DD/YYYY');?>">             
        </div>  
        <label style="color:red;"> <?php echo form_error('date'); ?></label>
    </div>       
    
    <input type="hidden" name="year" value="<?php echo $running_year;?>">
    <div class="text-right col-xs-12">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="6" 
        data-intro="<?php echo get_phrase('Click here to view the attendance details.');?>" data-position='top'><?php echo get_phrase('MANAGE ATTENDANCE');?></button>
    </div>
</div>
<?php echo form_close();?>