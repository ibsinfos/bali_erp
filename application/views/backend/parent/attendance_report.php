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
    <div class="col-sm-5 form-group" data-step="5" data-intro="<?php echo get_phrase('Select a Month from here!');?>" sition='top'>
        <label for="field-1"><?php echo get_phrase('Select_Month');?><span class="error" style="color: red;"> *</span></label>
        <select name="month" class="selectpicker" id="month" data-style="form-control" data-live-search="true">
            <?php
            for ($i = 1; $i <= 12; $i++):
                if ($i == 1)
                    $m = 'January';
                else if ($i == 2)
                    $m = 'February';
                else if ($i == 3)
                    $m = 'March';
                else if ($i == 4)
                    $m = 'April';
                else if ($i == 5)
                    $m = 'May';
                else if ($i == 6)
                    $m = 'June';
                else if ($i == 7)
                    $m = 'July';
                else if ($i == 8)
                    $m = 'August';
                else if ($i == 9)
                    $m = 'September';
                else if ($i == 10)
                    $m = 'October';
                else if ($i == 11)
                    $m = 'November';
                else if ($i == 12)
                    $m = 'December';
                ?>
                <option value="<?php echo $i; ?>"
                      <?php if($month == $i) echo 'selected'; ?>  >
                            <?php echo $m; ?>
                </option>
                <?php
            endfor;
            ?>
        </select> 
        <label class="mandatory"> <?php echo form_error('month'); ?></label>
    </div>
    <div class="text-right col-sm-7" >
	<button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-t-20" data-step="6" data-intro="On the click of this button you will see the Report of selecting month!" data-position='left'><?php echo get_phrase('show_report');?></button>
    </div>
    <?php echo form_close();?>
</div>





