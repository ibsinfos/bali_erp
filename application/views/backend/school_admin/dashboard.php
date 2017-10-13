
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
        <div class=" white-box col-lg-4 col-sm-6 row-in-br  b-r-none">
            <ul class="col-in">
                <li>
                    <span class="circle circle-md bg-info"><i class="fa fa-bar-chart"></i></span>
                </li>
                <li class="col-last" style="padding:0;">
                    <h3 class="counter text-right m-t-15"><?php echo $tot_teacher;?></h3>
                </li>
                <li class="">
                    <h4>Total Teachers</h4>
                   
                </li>
            </ul>
        </div>
        <div class="white-box col-lg-4 col-sm-6 row-in-br">
            <ul class="col-in">
                <li>
                    <span class="circle circle-md bg-success"><i class="fa fa-users"></i></span>
                </li>
                <li class="col-last" style="padding:0;">
                    <h3 class="counter text-right m-t-15"><?php echo $tot_student; ?></h3>
                </li>
                <li class="">
                    <h4>Total Students</h4>
                   
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
        <div class="white-box col-lg-4 col-sm-6 row-in-br">
            <ul class="col-in">
                <li>
                    <span class="circle circle-md bg-warning"><i class="fa fa-user-circle"></i></span>
                </li>
                <li class="col-last" style="padding:0;">
                    <h3 class="counter text-right m-t-15"><?php echo $tot_parent; ?></h3>
                </li>
                <li class="">
                    <h4>Total Parents</h4>
<!--                    <div class="progress">
                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                            <span class="sr-only">40% Complete (success)</span>
                        </div>
                    </div>-->
                </li>
            </ul>
        </div><!-- 
        <div class="white-box col-lg-4 col-sm-6 row-in-br">
            <ul class="col-in">
                <li>
                    <span class="circle circle-md bg-inverse"><i class="fa fa-users"></i></span>
                </li>
                <li class="col-last" style="padding:0;">
                    <h3 class="counter text-right m-t-15">50</h3>
                </li>
                <li class="">
                    <h4>Nonteaching Staff</h4>
                    
                </li>
            </ul>
        </div> -->
    </div>
</div>



<!-- /.row -->
       
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="white-box">
            <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
    </div>
</div>


<!-- row -->
<!-- <div class="row">
 <div class="col-md-8 col-sm-8">
    <div class="white-box">
            <h3 class="m-b-0 m-t-0 text-center">Teaching and Non-teaching Staff Attendance during one week.</h3>
   <div id="container_result" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
     </div></div>
    <div class="col-md-4 col-lg-4 col-sm-12">
        <div class="white-box real-time-widgets">
            <h3 class="m-b-0 m-t-0">No. Of Parents Using App</h3>
         <div id="container_app"></div>
        </div>
    </div>
</div> -->
<!--row holiday list-->

<div class="row">
     <div class="col-lg-5 col-sm-12 col-md-5">
                        <div class="panel">
                            <div class="p-10">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h3 class="m-b-0 m-t-0 text-center">Holidays List</h3>  
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
                                            <div class="er-count "><?php echo date('d-m-Y', strtotime($holiday['date_start']));?></div>
                                        </div>
                                    </li><?php $n++; } }?>
                                </ul><?php }?>
                            </div>
                        </div>
                    </div>
              <!-- col-md-3 -->
                    <!-- <div class="col-md-4 col-lg-4">
                        <div class="white-box">
                            <h3 class="text-center m-t-0 m-b-0">Fees Analysis</h3>
                     <div id="container_pie" style="min-width: 310px; height: 435px; margin: 0 auto"></div>

                            
                          
                        </div>
                    </div> -->
             <!-- <div class="col-lg-3 col-md-3">
                        <div class="white-box">
                            <h3 class="m-b-40 m-t-0 text-center">Students in the countries</h3>
                            <ul class="country-state">
                                <li class="m-b-30">
                                    <h2>635</h2> <small>From India</small>
                                    <div class="pull-right">48% </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:48%;"> <span class="sr-only">48% Complete</span></div>
                                    </div>
                                </li>
                                <li class="m-b-30">
                                    <h2>325</h2> <small>From UAE</small>
                                    <div class="pull-right">98% </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-inverse" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:48%;"> <span class="sr-only">48% Complete</span></div>
                                    </div>
                                </li>
                                <li class="m-b-30">
                                    <h2>125</h2> <small>From Australia</small>
                                    <div class="pull-right">75% </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:75%;"> <span class="sr-only">75% Complete</span></div>
                                    </div>
                                </li>
                                <li class="m-b-30">
                                    <h2>135</h2> <small>From USA</small>
                                    <div class="pull-right">48% </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:48%;"> <span class="sr-only">48% Complete</span></div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div> -->
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
if($('#container').length>0){
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Monthly Attendance'
        },
        subtitle: {
            text: '<?php echo $currentMonth;?>'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
        min:0,
        max:100,
            title: {
                text: 'Attendance Percent'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}%'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
        },
                
        series: [{
            name: 'Attendance',
            colorByPoint: true,
            data: [ <?php foreach($attendance_percentage as $value){?> { name: '<?php echo $value["class_name"];?>',y:<?php echo $value["percent"];?> }, <?php }?> ]

        }]      
        
    


    });
}

// Make monochrome colors and set them as default for all pies
Highcharts.getOptions().plotOptions.pie.colors = (function () {
    var colors = [],
        base = Highcharts.getOptions().colors[0],
        i;

    for (i = 0; i < 10; i += 1) {
        // Start out with a darkened base color (negative brighten), and end
        // up with a much brighter color
        colors.push(Highcharts.Color(base).brighten((i - 3) / 7).get());
    }
    return colors;
}());

// Build the chart
if($('#container_pie').length>0){
    Highcharts.chart('container_pie', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Brands',
            data: [
                { name: 'Paid', y: 56.33 },
                { name: 'Overdue', y: 24.03 }
            
            ]
        }]
    });   
}

if($('#container_result').length>0){
    Highcharts.chart('container_result', {
        chart: {
            type: 'areaspline'
        },
        title: {
            text: ''
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            verticalAlign: 'top',
            x: 150,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
        },
        xAxis: {
            categories: [
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
                'Saturday',
                'Sunday'
            ],
            plotBands: [{ // visualize the weekend
                from: 4.5,
                to: 6.5,
                color: 'rgba(68, 170, 213, .2)'
            }]
        },
        yAxis: {
            min:0,
            max:80,
            title: {
                text: ''
            }
        },
        tooltip: {
            shared: true,
            valueSuffix: ' '
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            areaspline: {
                fillOpacity: 0.5
            }
        },
        series: [{
            name: 'Teaching Staff',
            data: [20, 40, 30, 40, 40, 10, 12]
        }, {
            name: 'Non-teaching Staff',
            data: [10, 30, 40, 30, 30, 30, 40]
        }]
    });
}

if($('#container_app').length>0){
    Highcharts.chart('container_app', {
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
        title: {
            text: ''
        },
        plotOptions: {
            pie: {
                innerSize: 100,
                depth: 45
            }
        },
        series: [{
            name: 'Delivered amount',
            data: [
            
                ['App', 5],
                ['Web', 9]
                
            ]
        }]
});
}
</script>