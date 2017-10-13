<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">Parent Dashboard</h4> </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript:void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="#" class="active"> Dashboard</a></li>

        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <h3 class="text-center m-t-0"><?php echo get_phrase('monthly_attendance')?></h3>
            <?php if(!empty($attend_percentage)){?>
            <div id="container_attendance" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
            <?php }else{?>
            <div class="text-center">No attendance data</div>
            <?php }?>
        </div>
    </div>
</div>

<!--row-->
    <?php foreach($details as $value){?>
<div class="row">
    <div class="col-md-4 col-sm-12 col-lg-4">
        <div class="panel p-b-30">
            <div class="p-30">
                <div class="row">
                    <div class="col-xs-4"><img src="<?php echo base_url();?>uploads/user.jpg" alt="varun" class="img-circle img-responsive"></div>
                    <div class="col-xs-8">
                        <h2 class="m-b-0"><?php echo $value['name'];?></h2>
                        <h4><?php echo $value['phone'];?></h4>
                        <h4><?php echo $value['email'];?></h4></div>
                </div>
                <div class="row text-center m-t-30">
                    <div class="col-xs-4 b-r">
                        <h2><?php echo get_phrase('class');?></h2>
                        <h4><?php echo $value['class_name'];?></h4></div>
                    <div class="col-xs-4 b-r">
                        <h2><?php echo get_phrase('section');?></h2>
                        <h4><?php echo $value['section_name'];?></h4></div>
                    <div class="col-xs-4">
                        <h2><?php echo get_phrase('roll_no.');?></h2>
                        <h4><?php echo $value['enroll_code'];?></h4></div>
                </div>
            </div>


            <hr>
<!--            <ul class="dp-table profile-social-icons">
                <li><a href="javascript:void(0)" class="tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('View Profile'); ?>"><i class="fa fa-globe"></i></a></li>
                <li><a href="javascript:void(0)" class="tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('Twitter'); ?>"><i class="fa fa-twitter"></i></a></li>
                <li><a href="javascript:void(0)" class="tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('Facebook'); ?>"><i class="fa fa-facebook"></i></a></li>
                <li><a href="javascript:void(0)" class="tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('Youtube'); ?>"><i class="fa fa-youtube"></i></a></li>
                <li><a href="javascript:void(0)" class="tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('LinkedIn'); ?>"><i class="fa fa-linkedin"></i></a></li>
            </ul>-->
        </div>
    </div>
 
    <div class="col-lg-8 col-sm-12 col-xs-12">
    <div class="row">
<?php foreach($value['subject'] as $row){?>
           <div class="col-lg-4 col-sm-4  col-xs-12">
                <div class="white-box">
                    <h3 class="m-t-0 m-b-20"><i class="fa fa-book text-info"></i><?php echo " ".$row['subject_name'];?></h3>
                    <ul class="list-inline">
                        <li class="text-left"><h5><b>Teacher Name:</b></h5> </li>
                        <li class="text-left"><?php echo $row['teacher_name'];?></li><br>
                        <li class="text-left"><b>Period:</b></li>
                        <li class="text-left"><?php echo $row['period']."/week";?></li>
                    </ul>
                </div>
              
            </div>
<?php  }?>
        </div>
    </div>
</div>
<hr>
 <?php } ?>


<!--script for chart-->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<script>
    Highcharts.chart('container_attendance', {
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            max: 100,
            title: {
                text: 'Percentage(%)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.0f} %</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
                 dataLabels: {
                enabled: true,
                format: '{point.y:.0f}%'
            }
            }
        },
        series: [<?php foreach($attend_percentage as $key=>$value){echo "{name:"."'".$key."'".','."data:[";
            foreach($value as $row){echo $row.",";}echo "]},";}?>]
    });
</script>