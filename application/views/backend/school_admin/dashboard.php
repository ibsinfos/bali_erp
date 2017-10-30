<style type="text/css">
    .date_font {
        font-size: 18px !important;
    }
</style>
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">Admin Dashboard</h4> </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript:void(0);" onclick="javascript:introJs().start();" id="take-tour"  target="" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="#" class="active"> Dashboard</a></li>
        </ol>
    </div>
</div>
<input type="hidden" id="attendance" value='[]'/>

<div class="row">
    <div class="col-sm-12">
        <div class=" white-box col-lg-4 col-sm-6 row-in-br">
            <ul class="col-in">
                <li>
                    <span class="circle circle-md bg-danger"><i class="fa fa-plus-square-o"></i></span>
                </li>
                <li class="col-last" style="padding:0;">
                    <h3 class="counter text-right m-t-15"><?php echo $tot_admission; ?></h3>
                </li>
                <li class="">
                    <h4>New Admissions</h4>
                    
                </li>
            </ul>
        </div>

        <div class="white-box col-lg-4 col-sm-6 row-in-br">
            <ul class="col-in">
                <li>
                    <span class="circle circle-md bg-success"><i class="fa fa-area-chart"></i></span>
                </li>
                <li class="col-last" style="padding:0;">
                    <h3 class="counter text-right m-t-15"><?php echo $tot_student_present; ?></h3>
                </li>
                <li class="">
                    <h4>Present Students</h4>
                   
                </li>
            </ul>
        </div>
          <div class="white-box col-lg-4 col-sm-6 row-in-br">
            <ul class="col-in">
                <li>
                    <span class="circle circle-md bg-success"><i class="fa fa-area-chart"></i></span>
                </li>
                <li class="col-last" style="padding:0;">
                    <h3 class="counter text-right m-t-15"><?php echo $absent_student = $tot_student - $tot_student_present; ?></h3>
                </li>
                <li class="">
                    <h4>Absent Students</h4>
                </li>
            </ul>
        </div>
    </div>
</div>



<!-- /.row -->

<div class="row">
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="white-box">
            <div id="container_finance" style="min-width: 310px; height: 400px; margin: 0 auto">
                
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="panel">
            <div class="p-10">
                <div class="row">
                    <div class="col-xs-12">
                        <h3 class="m-b-0 m-t-0 text-center">Exams to be held this month</h3>  
                    </div>
                </div>
            </div>
            <div class="panel-footer bg-extralight">
                <?php if(count($current_month_exam_data)){ ?>
                <ul class="earning-box">
                    <?php $n =1; foreach($current_month_exam_data as $exams){ if($n<=6){?>
                    <li>
                        <div class="er-row">
                            <div class="er-text"><h3><?php echo ucfirst($exams['name']); ?></h3>
                                <span class="text-info">Class <?php echo $exams['class_name'];?></span>
                            </div>
                            <div class="er-count date_font">
                                <span class="text-info"><?php echo date('j M, Y', strtotime($exams['start_datetime']));?><br/></span>
                                <span class="text-muted" style="font-size:12px;"><?php echo date('l', strtotime($exams['start_datetime']));?></span>
                            </div>
                        </div>
                    </li><?php $n++; } }?>
                </ul>
                <?php }?>
            </div>
        </div>
        <div class="panel">
            <div class="p-10">
                <div class="row">
                    <div class="col-xs-12">
                        <h3 class="m-b-0 m-t-0 text-center">Upcoming PTM Events</h3>  
                    </div>
                </div>
            </div>
            <div class="panel-footer bg-extralight">
                <?php if(count($current_month_ptm_data)){ ?>
                <ul class="earning-box">
                    <?php $n =1; foreach($current_month_ptm_data as $ptm){ if($n<=6){?>
                    <li>
                        <div class="er-row">
                            <div class="er-text"><h3><?php echo ucfirst($ptm['teacher_name']); ?></h3>
                                <span class="text-info">Class <?php echo $ptm['class_name'];?></span>
                            </div>
                            <div class="er-count date_font">
                                <span class="text-info"><?php echo date('j M, Y H:i A', strtotime($ptm['ptm_date']));?><br/></span>
                                <span class="text-muted" style="font-size:12px;"><?php echo date('l', strtotime($ptm['ptm_date']));?></span>
                            </div>
                        </div>
                    </li><?php $n++; } }?>
                </ul>
                <?php } else { ?>
                <div class="row"><p>No PTM Events!</p></div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="panel">
            <div class="p-10">
                <div class="row">
                    <div class="col-xs-12">
                        <h3 class="m-b-0 m-t-0 text-center">Quotes of the day</h3>  
                    </div>
                </div>
            </div>
            <div class="panel-footer bg-extralight">
                <ul class="earning-box bxslider">
                    <li>
                        <img src="assets/images/quotes/alberteinstein1-2x.jpg" class="img-responsive" />
                    </li>
                    <li>
                        <img src="assets/images/quotes/anthonyjdangelo1-2x.jpg" class="img-responsive" />
                    </li>
                    <li>
                        <img src="assets/images/quotes/benjaminfranklin1-2x.jpg" class="img-responsive" />
                    </li>
                    <li>
                        <img src="assets/images/quotes/johndewey1-2x.jpg" class="img-responsive" />
                    </li>
                    <li>
                        <img src="assets/images/quotes/malcolmx1-2x.jpg" class="img-responsive" />
                    </li>
                    <li>
                        <img src="assets/images/quotes/nelsonmandela1-2x.jpg" class="img-responsive" />
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
     <div class="col-lg-6 col-sm-6 col-md-6">
        <div class="panel">
            <div class="p-10">
                <div class="row">
                    <div class="col-xs-12">
                        <h3 class="m-b-0 m-t-0 text-center">Student's Holidays List</h3>  
                    </div>
                </div>
            </div>
            <div class="panel-footer bg-extralight">
<?php if(count($holidays)){ ?>
                <ul class="earning-box">
<?php $n =1; foreach($holidays as $holiday){ if($n<=6){?>
                    <li>
                        <div class="er-row">
                            <div class="er-text"><h3><?php echo ucfirst($holiday['title']); ?></h3><span class="text-muted"><?php echo date('l', strtotime($holiday['date_start']));?></span></div>
                            <div class="er-count date_font">
                                <?php echo date('j M, Y', strtotime($holiday['date_start']));?> - 
                                <?php echo date('j M, Y', strtotime($holiday['date_end']));?><br/>
                            </div>
                        </div>
                    </li><?php $n++; } }?>
                </ul><?php }?>
            </div>
        </div>
    </div>
     <div class="col-lg-6 col-sm-6 col-md-6">
        <div class="panel">
            <div class="p-10">
                <div class="row">
                    <div class="col-xs-12">
                        <h3 class="m-b-0 m-t-0 text-center">Teacher's Holidays List</h3>  
                    </div>
                </div>
            </div>
            <div class="panel-footer bg-extralight">
<?php if(count($teacher_holidays)){ ?>
                <ul class="earning-box">
<?php $n =1; foreach($teacher_holidays as $teacher_holiday){ if($n<=6){?>
                    <li>
                        <div class="er-row">
                            <div class="er-text"><h3><?php echo ucfirst($teacher_holiday['holidayname']); ?></h3>
                                <span class="text-muted"><?php echo date('l', strtotime($teacher_holiday['holidaydate']));?></span>
                            </div>
                            <div class="er-count date_font">
                                <?php echo date('j M, Y', strtotime($teacher_holiday['holidaydate']));?>
                            </div>
                        </div>
                    </li><?php $n++; } }?>
                </ul><?php }?>
            </div>
        </div>
    </div>
              
          
</div>

<!--Line chart  for Attendance analysis-->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<!--pie chart for fee analysis-->
<script src="https://code.highcharts.com/modules/exporting.js"></script> 
<!--result analysis-->
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<!--App and web analysis-->
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script>
// Create the chart


Highcharts.chart('container_finance', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45,
            beta: 0
        }
    },
    title: {
        text: 'Financial Statistics for <?php echo date('M Y'); ?>'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point:.1f}</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            depth: 25,
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            }
        }
    },
    series: [{
        type: 'pie',
        name: 'Collection & Dues',
        data: [
            ['Collection', <?php echo $this_month_collection; ?>],
            ['Fees Due', 26.8],
            {
                name: 'Transactions',
                y: 12.8,
                sliced: true,
                selected: true
            },
            ['Invoices', 8.5]
        ]
    }]
});

</script>

<script src="assets/js/jquery.bxslider.min.js"></script>
<!-- bxSlider CSS file -->
<link href="assets/css/jquery.bxslider.min.css" rel="stylesheet" />
<script type="text/javascript">
$(document).ready(function(){
  $('.bxslider').bxSlider({
      randomStart: true,
      pager: false,
      auto: true,
      autoHover: true
  });
});
</script>