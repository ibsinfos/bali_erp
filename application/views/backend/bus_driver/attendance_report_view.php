<style type="text/css">
    .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th{
        padding: 3px;
    }
</style>

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
    <?php echo form_open(base_url() . 'index.php?school_admin/attendance_report/');?>
    <div class="col-sm-6 form-group" data-step="5" data-intro="Select a Bus from here!" data-position='top'>
        <label for="field-1"><?php echo get_phrase('select_bus');?><span class="error mandatory"> *</span></label>
        <select  class="selectpicker" data-style="form-control" data-live-search="true" name="bus_id">
            <option value=""><?php echo get_phrase('select_bus'); ?></option>
            <?php foreach($busses as $row):?>
                <option value="<?php echo $row['bus_id'];?>" <?php echo $row['bus_id']==$bus_id?'selected':''?>><?php echo $row['bus_name'];?></option>
            <?php endforeach;?>
        </select> 
        <label class="mandatory"> <?php echo form_error('bus_id'); ?></label>
    </div>

    <div class="col-sm-6 form-group">
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
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="5" data-intro="<?php echo get_phrase('Click here to view the report.');?>" data-position='left'><?php echo get_phrase('VIEW REPORT');?></button>
    </div>
    <?php echo form_close(); ?>
</div>          
  

<div class="col-md-12 white-box" data-step="6" data-intro="<?php echo get_phrase('Shows the report for a month.');?>" data-position='top'>
    <?php if ($month != ''): ?>
    <div class="text-center" >
        <h3><b><?php echo get_phrase('bus_attendance').' for the month of '.$month_arr[$month];?></b></h3>
    </div>
    
    <table class="table-bordered hidden-sm hidden-xs hidden-md" style="width:100%">
        <thead>
            <tr>
                <td class="text-center">
                    <?php echo get_phrase('student'); ?> <i class="fa fa-arrow-down"></i> | <?php echo get_phrase('date'); ?> <i class="fa fa-arrow-right"></i>
                </td>
                <?php $days = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
                    for ($i = 1; $i <= $days; $i++) { 
                        $date = strtotime($year.'-'.$month.'-'.$i);
                        $day_short=date('D', $date);
                    ?>
                    <td class="text-center"><?php echo $i.'<br/>'.substr($day_short,0,2); ?></td>
                <?php } ?>
                <td class="text-center"><?php echo get_phrase('percent');?></td>
                <!-- <td class="text-center"><?php echo get_phrase('notification');?></td> -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $row){//pre($row);die;
                $present=0;
                $tot_holi = 0;
                $min_per = 75;?>
                <tr>
                    <td class="text-center"><?php echo $row->name.' '.$row->lname; ?></td>
                    <?php $status = 0;
                    for ($i = 1; $i <= $days; $i++) {
                        $timestamp      =   strtotime($year.'-'.$month.'-'.$i);
                        $status         =   '';
                        if (date('w', $timestamp)==0){
                          $sunday=TRUE;
                        }else {
                           $sunday=FALSE;     
                        }
                        if(!in_array(date('Y-m-d',$timestamp), $holidays)){
                             $sunday=TRUE;
                        }
                        $row1 = $row->atten[$i];
                        //foreach ($row->atten as $row1){
                        if($row1){//echo '<pre>'.$i;print_r($row1);exit;
                            $month_dummy = date('j', strtotime($row1->date));
                            if ($i == $month_dummy){
                                $status = $row1->status;
                            }   
                        }
                        //}
                        /* if($status){
                            echo in_array(date('Y-m-d',$timestamp), $holidays).'--'.$i.'-'.$sunday.'-'.$status;exit;
                        } */
                        ?>
                            
                            <td class="text-center" style="font-weight: bold;">
                            <?php  if ($sunday) { $tot_holi++;?>
                                <i style="color: #c3833b;">H</i>
                            <?php } else {
                                if ($status == 1) {
                                    $present += 1;?>
                                    <i style="color: #00a651;">P</i>
                                <?php } if ($status == 2) { ?>
                                    <i style="color: #ee4749;">A</i>
                                <?php }else { ?>
                                    &nbsp;
                                <?php } ?>
                            <?php }?>                 
                        </td>
                       
                
                    <?php }?>
                    <?php 
                        $work_days = $days-$tot_holi;
                        $percentage= ($present/$work_days)*100;?>
                    <td <?php echo ($percentage < $min_per)?'style="color:red;"':''?>>
                        <?php echo round($percentage, 2)."%";?>
                    </td>
                </tr>
            <?php }?>
        </tbody>
    </table>
    <div class="clearfix">&nbsp;</div>
    <?php /*<div class="text-right">
        <a href="<?php echo base_url(); ?>index.php?school_admin/teacher_attendance_report_print_view/<?php echo $month; ?>" 
           class="fcbtn btn btn-danger btn-outline btn-1d" target="_blank" ><?php echo get_phrase('print_teacher_attendance_sheet'); ?>
         </a>
    </div>*/?>
    <?php endif; ?>
</div>             


<script type="text/javascript">

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
