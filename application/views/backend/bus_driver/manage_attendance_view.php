<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('manage_daily_attendance'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?bus_driver/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase('manage_attendance'); ?></li>
        </ol>
    </div>
</div>

<div class="col-md-12 white-box">
    <?php echo form_open(base_url() . 'index.php?bus_driver/attendance_selector/'); ?>
    <div class="col-sm-4 form-group" data-step="5" data-intro="Select a Class from here!" data-position='bottom'>
        <label for="field-1"><?php echo get_phrase('Select_bus');?><span class="error mandatory"> *</span></label>
        <select class="selectpicker" data-style="form-control" data-live-search="true" name="bus_id" >
            <option value=" "><?php echo get_phrase('select_class'); ?></option>            
            <?php foreach($buses as $row1):?>
            <option value="<?php echo $row1['bus_id'];?>" <?php if($bus_id == $row1['bus_id']){ echo "selected";} ?>><?php echo $row1['bus_name'];?></option>
            <?php endforeach;?>
        </select> 
        <label class="mandatory"> <?php echo form_error('class_id'); ?></label>
    </div>
       
    <div class="col-sm-4 form-group" data-step="7" data-intro="Select date!" data-position='top'>               
        <label for="field-1"><?php echo get_phrase('select_date');?><span class="error mandatory"> *</span></label>
        <div class="input-group">
            <span class="input-group-addon"><i class="icon-calender"></i></span>
            <input type="text" class="form-control mydatepicker"  name="timestamp"  id ="today_date" value="<?php echo $timestamp;?>"> 
            <label class="mandatory"> <?php echo form_error('date'); ?></label>
        </div>         
    </div>       
    
    <input type="hidden" name="year" value="<?php echo $running_year;?>">
    <div class="text-right col-xs-12">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="8" data-intro="On the click on button, you will get list of attendance!" data-position='top'><?php echo get_phrase('MANAGE ATTENDANCE');?></button>
    </div>
    <?php echo form_close(); ?>
</div>
<div class="col-md-12 white-box" data-step="9" data-intro="Shows the student details!!" data-position='top'>
    <div class="text-center">
        <!--<h3><?php echo get_phrase('attendance_for_class'); ?> <?php echo $class_name; ?> <?php echo get_phrase('section'); ?> <?php echo $section_name . " on "; ?><?php echo date("d-m-Y", $timestamp); ?></h3>-->
    </div>
    <?php echo form_open(base_url() . 'index.php?bus_driver/attendance_update/' . $bus_id . '/' . $running_year.'/' . $timestamp); ?>
    
            <table id="ex" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th><div><?php echo get_phrase('no:'); ?></div></th>
                        <th><div><?php echo get_phrase('bus'); ?></div></th>
                        <th><div><?php echo get_phrase('student'); ?></div></th>
                        <th><div><?php echo get_phrase('class'); ?></div></th>
                        <th><div><?php echo get_phrase('section'); ?></div></th>                        
                        <th><div><?php echo get_phrase('status');?></div></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    foreach ($att_of_students as $row): ?>
                        <tr>
                            <td><div><?php echo $count++; ?></div></td>
                            <td><div><?php echo $row['bus_name'];?></div></td>
                            <td><div><?php echo $row['student_name']." ".$row['lname'];?></div></td>
                            <td><div><?php echo $row['class_name'];?></div></td>
                            <td><div><?php echo $row['section_name'];?></div></td>
                            <td>
                                <select class="selectpicker" data-style="form-control" data-live-search="true" name="status_<?php echo $row['bus_attn_id']; ?>">
                                    <option value="0" <?php if ($row['attendance_status'] == 0) echo 'selected'; ?>><?php echo get_phrase('undefined'); ?></option>
                                    <option value="1" <?php if ($row['attendance_status'] == 1) echo 'selected'; ?>><?php echo get_phrase('present'); ?></option>
                                    <option value="2" <?php if ($row['attendance_status'] == 2) echo 'selected'; ?>><?php echo get_phrase('absent'); ?></option>
                                </select>	
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-right col-xs-12 p-t-20">
                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" ><?php echo get_phrase('UPDATE ATTENDANCE');?></button>
            </div>
      
    <?php echo form_close(); ?>
</div>
<script>
    $(document).ready(function () {
        $('#today_date').datepicker({
            format: "dd-mm-yyyy"
        });
    });
</script>


