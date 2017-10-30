<style type="text/css">
    .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th{
        padding: 3px;
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
            <li class="active"><?php echo get_phrase('view_attendance_report'); ?></li>
        </ol>
    </div>
</div>

<div class="col-md-12 white-box">
    <?php echo form_open(base_url('index.php?school_admin/teacher_attendance_report/')); ?>
    <div class="row">
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
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="5" data-intro="<?php echo get_phrase('Click_here_to_view_the_report.');?>" data-position='left'><?php echo get_phrase('VIEW_REPORT');?></button>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>          
  

<div class="col-md-12 white-box" data-step="6" data-intro="<?php echo get_phrase('Shows_the_report_for_a_month.');?>" data-position='top'>
    <?php if ($month != ''): ?>
        <div class="text-center" >
            <h3><b><?php echo get_phrase('attendance'); ?> <?php echo " for the month of "?><?php echo $month_arr[$month];?></b></h3>
        </div>
        
        <div class="m-scroll">
            <table class="table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <td class="text-center">
                            <?php echo get_phrase('teaher'); ?> <i class="fa fa-arrow-down"></i> | <?php echo get_phrase('date'); ?> <i class="fa fa-arrow-right"></i>
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
                        <td class="text-center"><?php echo get_phrase("percent");?></td>
                        <td class="text-center"><?php echo get_phrase("notification");?></td>
                    </tr>
                    
                </thead>
                <tbody>
                    <?php    
                //pre($students); die();
                    //foreach ($students as $row):
                    foreach ($teachers as $row): //pre($row);die;
                        $present=0;
                    $tot_holi = 0;
                    $min_per = 75;
                        if(empty($teachers)) continue; ?>
                        <tr>
                            <td class="text-center"><?php echo  $row['name'];//$row['name'].' '.$row['lname']; ?></td>
                            <?php
                            $holidays=array();
                                    $status = 0;
                            for ($i = 1; $i <= $days; $i++) {
                                $timestamp      =   strtotime($i . '-' . $month . '-' . $year[0]);
                                $status         =   "";
                                if (date('w', $timestamp)==0){
                                $sunday=TRUE;
                                }else {
                                $sunday=FALSE;     
                                }if(in_array(date("Y-m-d",$timestamp), $holidays)){
                                    $sunday=TRUE;
                                }
                                    if(isset($row['atten'])){
                                        foreach ($row['atten'] as $row1):
                                            $month_dummy = date('j', $row1['timestamp']);
                                            if ($i == $month_dummy){
                                                $status = $row1['status'];
                                            }   
                                        endforeach;
                                    }
                                ?>
                                    
                                    <td class="text-center" style="font-weight: bold;">
                                        <?php  if ($sunday) { $tot_holi++;?>
                                        <i style="color: #c3833b;">H</i>
                                            
                                            <?php } else {
                                                if ($status == 1) { ?>
                                                <i style="color: #00a651;">P</i>
                                    <?php } if ($status == 2) { ?>
                                                <i style="color: #ee4749;">A</i>
                                    <?php }
                                    else { ?>
                                                &nbsp;
                                    <?php } ?>            
                                        </td>
                            
                            <!-- <td class="text-center" style="font-weight: bold;">
                                <?php if ($status == 1) { 
                                    $present=$present+1;
                                    ?><i style="color: #00a651;">P</i>
                                <?php } else if ($status == 2) { ?><i style="color: #ee4749;">A</i>
                                <?php }else{ ?> &nbsp; <?php } ?>            
                            </td> -->
                            <?php } }?>
                            <?php 
                            $work_days = $days-$tot_holi;
                            $percentage= ($present/$work_days)*100; 
                            ?>
                            <td <?php if($percentage < $min_per){?> style="color:red;" <?php }?>>
                            <?php //echo $present.'<br/>'.$days.'<br/>'.$tot_holi.'<br/>'.$work_days;
                            echo round($percentage, 2)."%";?></td>
                            <td> &nbsp;<?php /*<button onclick='send_notification("<?php echo $row['student_id'];?>","<?php echo round($percentage, 2);?>")' class="btn-red"><?php echo get_phrase("send"); ?></button> */?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php ?>
                </tbody>
            </table>
            <div class="clearfix">&nbsp;</div>
        </div>

        <div class="text-right">
            <a href="<?php echo base_url(); ?>index.php?school_admin/teacher_attendance_report_print_view/<?php echo $month; ?>" 
            class="fcbtn btn btn-danger btn-outline btn-1d" target="_blank" ><?php echo get_phrase('print_teacher_attendance_sheet'); ?>
            </a>
        </div>
    <?php endif; ?>
</div>             

<script src="<?php echo base_url('assets/bower_components/malihu-custom-scrollbar/jquery.mCustomScrollbar.js')?>"></script>
<script type="text/javascript">
function select_section(class_id) {
    $.ajax({
        url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_sections_by_class/' + class_id,
        success:function (response){
            jQuery('#section_holder').html(response);
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
