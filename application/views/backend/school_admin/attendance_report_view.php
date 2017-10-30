<style type="text/css">
    .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th{
        padding: 5px;
    }
    
    .table-bordered{
        min-width: 100%;
    }
</style>
<link href="<?php echo base_url('assets/bower_components/malihu-custom-scrollbar/jquery.mCustomScrollbar.min.css')?>" rel="stylesheet">

<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('view_attendance_report'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><?php echo get_phrase('attendance'); ?>
                <ul>                    
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/manage_attendance"><?php echo get_phrase('daily_attendance'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/attendance_report"><?php echo get_phrase('attendance_report'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/holiday_settings"><?php echo get_phrase('holiday_settings'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/teacher_attendance_report"><?php echo get_phrase('teacher_attendance'); ?></a></li>
                </ul>
            </li>
            <li class="active">
                <?php echo get_phrase('attendance_report_view'); ?>
            </li>
        </ol>
    </div>
</div>

<div class="col-md-12 white-box">
    <?php echo form_open(base_url() . 'index.php?school_admin/attendance_report_selector/'); ?>
    <div class="row">
        <div class="col-sm-4 form-group">
            <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('Select_Class');?><span class="error" style="color: red;"> *</span></label>
            <select class="selectpicker" data-style="form-control" data-live-search="true" name="class_id"  onchange="select_section(this.value)">
                <option value=" "><?php echo get_phrase('select_class'); ?>12221</option>            
                <?php foreach($classes as $row1):?>
                <option value="<?php echo $row1['class_id'];?>" <?php if($class_id == $row1['class_id']){ echo "selected";} ?> ><?php echo get_phrase('class'); ?>&nbsp;<?php echo $row1['name'];?></option>
                <?php endforeach;?>
            </select> 
            <label style="color:red;"> <?php echo form_error('class_id'); ?></label>
        </div>
        <div class="col-sm-4 form-group">
            <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_section');?><span class="error" style="color: red;"> *</span></label>        
            <select name="section_id" class="selectpicker" data-style="form-control" data-live-search="true" id="section_holder">
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
    </div>
    
    <div class="row">
        <input type="hidden" name="year" value="<?php echo $running_year;?>">
        <div class="text-right col-xs-12" >
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="5" data-intro="Click here to view the report" data-position='left'><?php echo get_phrase('VIEW REPORT');?></button>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>          
  

<div class="col-md-12 white-box" data-step="6" data-intro="Shows the report for a month" data-position='top'>
    <div id="print">
        <?php if ($class_id != '' && $section_id != '' && $month != ''): ?>
        <div class="text-center" >
            <h3><b><?php echo get_phrase('attendance_for_class'); ?> <?php echo $class_name; ?> <?php echo get_phrase('section'); ?> <?php echo $section_name . " for the month of "?><?php echo $month_arr[$month];?></b></h3>
        </div>
        <?php endif; ?>
        
        <div class="m-scroll">
            <table class="table-bordered">
                <thead>
                    <tr>
                        <td class="text-center">
                            <?php echo get_phrase('students'); ?> <i class="fa fa-arrow-down"></i> | <?php echo get_phrase('date'); ?> <i class="fa fa-arrow-right"></i>
                        </td>
                        <?php 
                            $year = explode('-', $running_year);
                            $days = cal_days_in_month(CAL_GREGORIAN, $month, $year[0]); 
                            for ($i = 1; $i <= $days; $i++) { 
                                $timestamp = strtotime($i . '-' . $month . '-' . $year[0]);
                                $day_short=date('D', $timestamp);
                            ?>
                            <td class="text-center"><?php echo $i."<br/>".substr($day_short,0,2); ?></td>
                        <?php } ?>
                        <td class="text-center"><?php echo get_phrase("Percent");?></td>
                        <td class="text-center notification"><?php echo get_phrase("notification");?></td>
                    </tr>
                    
                </thead>
                <tbody>
                    <?php    
                    //pre($students); die();
                    foreach ($students as $row){
                        $present=0;
                        $tot_holi = 0;
                        $min_per = $minimum_attendance; ?>
                        <tr>
                            <td class="text-center"><?php echo $row->name.' '.$row->lname; ?></td>
                            <?php
                            $status = 0;
                            for ($i = 1; $i <= $days; $i++) {
                                //$timestamp      =   strtotime($i . '-' . $month . '-' . $year[0]);
                                //$timestamp      =   $year[0].'-'.$month.'-'.$i;
                                $date      =   $year[0].'-'.$month.'-'.($i<10?'0'.$i:$i);
                                $status         =   '';
                                if (date('w', strtotime($date))==0){
                                    $sunday=TRUE;
                                }else {
                                    $sunday=FALSE;     
                                }
                                if(in_array($date, $holidays)){
                                    $sunday=TRUE;
                                }
                                if(isset($row->atten)){
                                    foreach ($row->atten as $row1){
                                        /* if($i==10){
                                            echo $row->name.'-'.$row1['date'].'-'.$row1['tmdate'].'<br/>';
                                        } */
                                        
                                        $month_dummy = date('j', strtotime($row1['date']));
                                        $timestamp_date = date('j', strtotime($row1['tmdate']));
                                        if (($row1['date']!='0000-00-00' && $i == $month_dummy) || $i==$timestamp_date){
                                            $status = $row1['status'];
                                        }  
                                    }
                                }
                                ?>
                                    
                                <td class="text-center" style="font-weight: bold;">
                                    <?php if($sunday){ 
                                            $tot_holi++;
                                            echo '<i style="color: #c3833b;">H</i>';
                                        } else {
                                            if ($status == 1){ 
                                                $present += 1;
                                                echo '<i style="color: #00a651;">P</i>';
                                            }else if ($status == 2) {
                                                echo '<i style="color: #ee4749;">A</i>';
                                            }else { 
                                                echo '&nbsp;';
                                            }
                                        }?>            
                                </td>
                            
                                <?php /*<td class="text-center" style="font-weight: bold;">
                                    <?php //if ($status == 1) { 
                                        // $present=$present+1;
                                        ?><i style="color: #00a651;">P</i>
                                    <?php //} else if ($status == 2) { ?><i style="color: #ee4749;">A</i>
                                    <?php //}else{ ?> &nbsp; <?php } ?>            
                                </td>*/?>
                            <?php }?>
                            <?php $work_days = $days-$tot_holi;
                                $percentage = 0;
                                if($work_days > 0 && $present > 0)
                                    $percentage= ($present/$work_days)*100; 
                            ?>
                            <td <?php echo ($percentage < $min_per)?'style="color:red;"':'';?>>
                            <?php //echo $present.'<br/>'.$days.'<br/>'.$tot_holi.'<br/>'.$work_days;
                                echo round($percentage, 2)."%";?></td>
                            <td class="notification">
                                <button onclick='send_notification("<?php echo $row->student_id;?>","<?php echo round($percentage, 2);?>")' class="btn-red">
                                    <?php echo get_phrase("send");?>
                                </button>
                            </td>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
        
        <!--<div class="text-right">
            <a href="<?php // echo base_url(); ?>index.php?school_admin/attendance_report_print_view/<?php // echo $class_id; ?>/<?php // echo $section_id; ?>/<?php // echo $month; ?>" 
            class="fcbtn btn btn-danger btn-outline btn-1d" target="_blank" ><?php // echo get_phrase('print_attendance_sheet'); ?>
            </a>
        </div>-->
    </div>             
    <div class="clearfix">&nbsp;</div>
    <div class="row">
        <div class="col-md-offset-8 col-md-4 text-right">
           <a href="#" onclick="PrintElem('#print');" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('print_attendance_sheet'); ?></a>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/bower_components/malihu-custom-scrollbar/jquery.mCustomScrollbar.js')?>"></script>
<script type="text/javascript">
    function PrintElem(elem) {
        Popup($(elem).html());
    }   
    
    function Popup(data) {
        var myWindow = window.open('', 'my div', 'height=400,width=600');
        myWindow.document.write('<html><head><title></title>');
        myWindow.document.write('<style type="text/css">.notification{display:none;} table, th, td { border: 1px solid black; border-collapse: collapse;  padding: 5px; text-align: left;}</style>');
        myWindow.document.write('</head><body><center><img src="<?php echo base_url() ?>assets/images/logo_ag.png" width="50" height="50"><h3><?php echo $system_name; ?></h3></center><h2><center><b>Attendance Report</b></center></h2>');
        myWindow.document.write(data);
        myWindow.document.write('</body></html>');
        myWindow.document.close(); // necessary for IE >= 10

        myWindow.onload = function () { // necessary if the div contain images
            myWindow.focus(); // necessary for IE >= 10
            myWindow.print();
            myWindow.close();
        };
        window.location.reload();
    }
    
    function select_section(class_id) {
        $('body').loading('start');
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_sections_by_class/' + class_id,
            success:function (response){
                $('body').loading('stop');
                $('#section_holder').html(response)
                $('.selectpicker').selectpicker('refresh');
            }
        });
    }

/*for table view in mobile*/
$(function () {
    switchRowsAndCols("table", 1100);
    $('.m-scroll').mCustomScrollbar({axis:'x'});
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
        $('body').loading('start');
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/send_sms_for_low_attendance/' + student_id +'/'+percentage,
            success: function (response) {
                $('body').loading('stop');
                alert('Message Sent Successfully');
            }     
        });
    }

    $(function () {
         $("[data-toggle='tooltip']").tooltip();
    });
</script>
