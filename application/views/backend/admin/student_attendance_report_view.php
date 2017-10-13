<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('view_student_attendance_report'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?student_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase('view_student_attendance_report'); ?></li>
        </ol>
    </div>
</div>

<div class="col-md-12 white-box">
    <?php echo form_open(base_url() . 'index.php?admin/student_attendance_report_selector/'); ?>
     <div class="col-sm-4 form-group">
        <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('Select_School');?><span class="error" style="color: red;"> *</span></label>
        <select  class="selectpicker" data-style="form-control" data-live-search="true" name="class_id"  onchange="select_class(this.value)">
            <option value=" "><?php echo get_phrase('select_school'); ?></option>            
            <?php foreach($schools as $row1):?>
            <option value="<?php echo $row1['school_id'];?>" <?php if($school_id == $row1['school_id']){ echo "selected";} ?> ><?php echo get_phrase('school'); ?>&nbsp;<?php echo $row1['name'];?></option>
            <?php endforeach;?>
        </select> 
        <label style="color:red;"> <?php echo form_error('school_id'); ?></label>
    </div>
    <div class="col-sm-4 form-group"> 
        <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('Select_Class');?><span class="error" style="color: red;"> *</span></label>
        <select  class="selectpicker" data-style="form-control" data-live-search="true" name="class_id"  onchange="select_section(this.value)">
            <option value=" "><?php echo get_phrase('select_class'); ?></option>            
            <?php foreach($classes as $row1):?>
            <option value="<?php echo $row1['class_id'];?>" <?php if($class_id == $row1['class_id']){ echo "selected";} ?> ><?php echo get_phrase('class'); ?>&nbsp;<?php echo $row1['name'];?></option>
            <?php endforeach;?>
        </select> 
        <label style="color:red;"> <?php echo form_error('class_id'); ?></label>
    </div>
    <div class="col-sm-4 form-group">
        <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_section');?><span class="error" style="color: red;"> *</span></label>        
        <select name="section_id" data-style="form-control" class="selectpicker" id="section_holder">
            <?php 
                $selected               =   '';
                foreach($sections as $key=>$section) {
                $selected              =   ($section_id == $section['section_id'] ? 'selected' : '' ); ?>
                <option <?php echo $selected ?> value="<?php echo $section['section_id']; ?>"><?php echo $section['name']; ?></option>
            <?php  } ?>
        </select> 
        <label style="color:red;"> <?php echo form_error('section_id'); ?></label>
    </div>
    <div class="col-sm-4 form-group">
        <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_month');?><span class="error" style="color: red;"> *</span></label>
        <select class="selectpicker" data-style="form-control" data-live-search="true" name="month">
            <?php $month_arr    =   array('1' => 'January', '2'=>'February', '3'=>'March', '4'=>'April', '5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December'); ?>          
            <?php foreach($month_arr AS $key =>$val): ?>
            <option value="<?php echo $key; ?>" <?php if ($month == $key) echo 'selected'; ?> > <?php echo $val; ?></option>
            <?php endforeach;?>
        </select>
        <label style="color:red;"> <?php echo form_error('month'); ?></label>
    </div>
    <input type="hidden" name="year" value="<?php echo $running_year;?>">
    <div class="text-right col-xs-12" >
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="5" data-intro="Click here to view the report" data-position='left'><?php echo get_phrase('VIEW REPORT');?></button>
    </div>
    <?php echo form_close(); ?>
</div>          
  

<div class="col-md-12 white-box" data-step="6" data-intro="Shows the report for a month" data-position='top'>
    <?php if ($class_id != '' && $section_id != '' && $month != ''): ?>
    <div class="text-center" >
        <h3><b><?php echo get_phrase('attendance_for_school'); ?><?php echo get_phrase('attendance_for_class'); ?> <?php echo $class_name; ?> <?php echo get_phrase('section'); ?> <?php echo $section_name . " for the month of "?><?php echo $month_arr[$month];?></b></h3>
    </div>
    <?php endif; ?>

    <table class="table table-bordered hidden-sm hidden-xs hidden-md">
        <thead>
            <tr>
                <td class="text-center">
                    <?php echo get_phrase('students'); ?> <i class="fa fa-arrow-down"></i> | <?php echo get_phrase('date'); ?> <i class="fa fa-arrow-right"></i>
                </td>
                <?php                    
                    for ($i = 1; $i <= $days; $i++) { ?>
                    <td class="text-center"><?php echo $i; ?></td>
                <?php } ?>
                <td class="text-center"><?php echo get_phrase("percent");?></td>
<!--                <td class="text-center"><?php echo get_phrase("notification");?></td>-->
            </tr>
            
        </thead>
        <tbody>
            <?php    
           
            foreach ($students as $row):
                $present=0;
                if(empty($students)) continue; ?>
                <tr>
                    <td class="text-center"><?php echo $row['name']; ?></td>
                    <?php
                    $status = 0;
                    for ($i = 1; $i <= $days; $i++) {
                        $timestamp      =   strtotime($i . '-' . $month . '-' . $year[0]);
                        $attendance     =   $this->db->get_where('attendance', array('section_id' => $section_id, 'class_id' => $class_id, 'year' => $running_year, 'timestamp' => $timestamp, 'student_id' => $row['student_id']))->result_array();
 
                        //$status         =   "";

                        foreach ($attendance as $row1):
                            $month_dummy = date('j', $row1['timestamp']);
                            if ($i == $month_dummy){
                                $status = $row1['status'];
                            }   endforeach;
                        ?>
                    <td class="text-center" style="font-weight: bold;">
                        <?php if ($status == 1) { 
                            $present=$present+1;
                            ?><i style="color: #00a651;">P</i>
                        <?php } else if ($status == 2) { ?><i style="color: #ee4749;">A</i>
                        <?php }else{ ?> &nbsp; <?php } ?>            
                    </td>
                    <?php } ?>
                    <?php $percentage= ($present/$days)*100; ?>
                    <td><?php echo round($percentage, 2)."%";?></td>
<!--                    <td><button onclick='send_notification("<?php echo $row['student_id'];?>","<?php echo round($percentage, 2);?>")' class="btn-red"><?php echo get_phrase("send"); ?></button></td>-->
                    <?php endforeach; ?>
                </tr>
            <?php ?>
        </tbody>
    </table>
    
    <div class="text-right">
        <a href="<?php echo base_url(); ?>index.php?admin/attendance_report_print_view/<?php echo $class_id; ?>/<?php echo $section_id; ?>/<?php echo $month; ?>" 
           class="fcbtn btn btn-danger btn-outline btn-1d" target="_blank" ><?php echo get_phrase('print_attendance_sheet'); ?>
         </a>
    </div>
</div>             




<script type="text/javascript">
    function select_section(class_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_sections_by_class/' + class_id,
            success:function (response){
                jQuery('#section_holder').html(response).selectpicker('refresh');
            }
        });
    }

/*for table view in mobile*/
    $(function () {
           switchRowsAndCols("table", 1100);
       });

    function switchRowsAndCols(thisTable, resolution) {
        if ($(window).width() < resolution) {
            switchRowsAndColsInnerFun(thisTable);
        }
        $(window).resize(function () {
            if ($(window).width() < resolution) {
                switchRowsAndColsInnerFun(thisTable);
            }else{
                switchRowsAndColsRemove(thisTable);
            }
        });
    };

    function switchRowsAndColsRemove(thisTable) {
        $("tr > *", thisTable).css({
            height: 'auto'
        });
    };

    function switchRowsAndColsInnerFun(thisTable) {
        var maxRow = $("tr:first-child() > *", thisTable).length;

        for (var i = maxRow; i >= 0; i--) {

            $("tr > *:nth-child(" + i + ")", thisTable).css({
                height: 'auto'
            });

            var maxHeight = 0;

            $("tr > *:nth-child(" + i + ")", thisTable).each(function () {
                var h = $(this).height();
                maxHeight = h > maxHeight ? h : maxHeight;
            });

            $("tr > *:nth-child(" + i + ")", thisTable).each(function () {
                $(this).height(maxHeight);
            });
        };
    };
    function send_notification(student_id,percentage){
        $.ajax({
        url: '<?php echo base_url(); ?>index.php?school_admin/send_sms_for_low_attendance/' + student_id +'/'+percentage,
        success: function (response) {
            //alert(response);
        }     
        });
    }

    $(function () {
         $("[data-toggle='tooltip']").tooltip();
    });
</script>

