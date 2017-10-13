<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('manage_daily_attendance'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase('daily_attendance_report'); ?></li>
        </ol>
    </div>
</div>

<div class="col-md-12 white-box">
    <?php echo form_open(base_url() . 'index.php?school_admin/attendance_selector/'); ?>
    <div class="col-sm-4 form-group" data-step="5" data-intro="<?php echo get_phrase('Select a Class from here!');?>" data-position='bottom'>
        <label for="field-1"><?php echo get_phrase('Select_Class'); ?><span class="error mandatory"> *</span></label>
        <select class="selectpicker" data-style="form-control" data-live-search="true" name="class_id"  onchange="select_section(this.value)">
            <option value=" "><?php echo get_phrase('select_class'); ?></option>            
            <?php foreach ($classes as $row1): ?>
                <option value="<?php echo $row1['class_id']; ?>" <?php
                if ($class_id == $row1['class_id']) {
                    echo "selected";
                }
                ?>><?php echo get_phrase('class'); ?>&nbsp;<?php echo $row1['name']; ?></option>
                    <?php endforeach; ?>
        </select> 
        <label class="mandatory"> <?php echo form_error('class_id'); ?></label>
    </div>

    <div class="col-sm-4 form-group" data-step="6" data-intro="<?php echo get_phrase('Select Section from here!');?>" data-position='top'>
        <label for="field-1"><?php echo get_phrase('select_section'); ?><span class="error mandatory"> *</span></label>       
        <select name="section_id" class="selectpicker" data-style="form-control" data-live-search="true" id="section_holder">
            <?php
            $selected = '';
            foreach ($sections as $key => $section) {
                $selected = ($section_id == $section->section_id ? 'selected' : '' );
                ?>
                <option <?php echo $selected ?> value="<?php echo $section->section_id; ?>"><?php echo $section->name; ?></option>
            <?php } ?>
        </select> 
        <label class="mandatory"> <?php echo form_error('section_id'); ?></label>
    </div>  

    <div class="col-sm-4 form-group" data-step="7" data-intro="<?php echo get_phrase('Select date!');?>" data-position='top'>               
        <label for="field-1"><?php echo get_phrase('select_date'); ?><span class="error mandatory"> *</span></label>
        <div class="input-group">
            <span class="input-group-addon"><i class="icon-calender"></i></span>
            <input type="text" class="form-control" id="mydatepicker_holiday_disable" name="timestamp"  value="<?php echo date("m/d/Y", $timestamp); ?>">
            
            <label class="mandatory"> <?php echo form_error('date'); ?></label>
        </div>         
    </div>       

    <input type="hidden" name="year" value="<?php echo $running_year; ?>">
    <div class="text-right col-xs-12">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="8" data-intro="<?php echo get_phrase('On the click on button, you will get list of attendance!');?>" data-position='top'><?php echo get_phrase('MANAGE ATTENDANCE'); ?></button>
    </div>
    <?php echo form_close(); ?>
</div>
<div class="col-md-12 white-box" data-step="9" data-intro="<?php echo get_phrase('Shows the student details!!');?>" data-position='top'>
    <div class="text-center">
        <h3><?php echo get_phrase('attendance_for_class'); ?> <?php echo $class_name; ?> <?php echo get_phrase('section'); ?> <?php echo $section_name . " on "; ?><?php echo date("d M Y", $timestamp); ?></h3>
    </div>
    <?php echo form_open(base_url() . 'index.php?school_admin/attendance_update/' . $class_id . '/' . $section_id . '/' . $timestamp); ?>

    <table data-page-length='60' id="ex" class="display nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th><div><?php echo get_phrase('no:'); ?></div></th>
                <th><div><?php echo get_phrase('roll_no'); ?></div></th>
                <th><div><?php echo get_phrase('student_name'); ?></div></th>
                <th><div><?php echo get_phrase('status'); ?></div></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            //pre($att_of_students); die();
            foreach ($att_of_students as $row):
                /*if (!empty($row['roll']) && !empty($row['student_name'])):*/
                    ?>
                    <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row['roll']; ?></td>
                        <td><?php echo $row['student_name'] . " " . $row['lname']; ?></td>  
                        <td>
                            <select class="selectpicker pos-static AtdStatus" data-style="form-control" data-live-search="true" name="status_<?php echo $row['attendance_id']; ?>">
                                <option value="0" <?php if ($row['status'] == 0) echo 'selected'; ?>><?php echo get_phrase('undefined'); ?></option>
                                <option value="1" <?php if ($row['status'] == 1) echo 'selected'; ?>><?php echo get_phrase('present'); ?></option>
                                <option value="2" <?php if ($row['status'] == 2) echo 'selected'; ?>><?php echo get_phrase('absent'); ?></option>
                            </select>
                            <input type="hidden" name="update_attendance_<?php echo $row['attendance_id']; ?>">	
                        </td>
                    </tr>
                    <?php
                /*endif;*/
            endforeach;
            ?>
        </tbody>
    </table>
    <div class="text-right col-xs-12 p-t-20 p-r-0">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" ><?php echo get_phrase('UPDATE ATTENDANCE'); ?></button>
    </div>

    <?php echo form_close(); ?>
</div>
<?php 
if(count($holidays)){
foreach($holidays as $key=>$holiday){
    $harr[] = date('m/d/Y',strtotime($holiday));
}
$hstring = implode("','",$harr);
$hstring = "'".$hstring."'";
}
?>
<script type="text/javascript">

    function select_section(class_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_sections_by_class/' + class_id,
            success: function (response) {
                jQuery('#section_holder').html(response).selectpicker('refresh');
            }
        });
    }

    $(document).ready(function () {
        $('.AtdStatus').change(function () {
            var MyVal = $(this).val();
            if (MyVal != '0') {
                var MyName = $(this).attr('name');
                var AtdId = MyName.split('_');
                $("input[name$='update_attendance_" + AtdId[1] + "']").val(MyVal);
            }
        });
    });

</script>