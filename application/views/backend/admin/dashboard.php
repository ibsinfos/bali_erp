<?php $currentMonth = date('F'); ?>
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo $page_title; ?></h4> </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript:void(0);" onclick="javascript:introJs().start();" id="take-tour"  class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
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
                    <h3 class="counter text-right m-t-15"><?php echo $new_admissions; ?></h3>
                </li>
                <li class="">
                    <h4>New Admissions</h4>
                    <div class="progress">
                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                            <span class="sr-only">40% Complete (success)</span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class=" white-box col-lg-4 col-sm-6 row-in-br  b-r-none">
            <ul class="col-in">
                <li>
                    <span class="circle circle-md bg-info"><i class="fa fa-bar-chart"></i></span>
                </li>
                <li class="col-last" style="padding:0;">
                    <h3 class="counter text-right m-t-15"><?php echo $total_students; ?></h3>
                </li>
                <li class="">
                    <h4>Total Students</h4>
                    <div class="progress">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                            <span class="sr-only">40% Complete (success)</span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="white-box col-lg-4 col-sm-6 row-in-br">
            <ul class="col-in">
                <li>
                    <span class="circle circle-md bg-success"><i class="fa fa-users"></i></span>
                </li>
                <li class="col-last" style="padding:0;">
                    <h3 class="counter text-right m-t-15"><?php echo $total_present_students; ?></h3>
                </li>
                <li class="">
                    <h4>Present Students</h4>
                    <div class="progress">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                            <span class="sr-only">40% Complete (success)</span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="white-box col-lg-4 col-sm-6 row-in-br">
            <ul class="col-in">
                <li>
                    <span class="circle circle-md bg-success"><i class="fa fa-user-circle"></i></span>
                </li>
                <li class="col-last" style="padding:0;"> 
                    <h3 class="counter text-right m-t-15"><?php echo $total_absent_students; ?></h3>
                </li>
                <li class="">
                    <h4>Absent Students</h4>
                    <div class="progress">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                            <span class="sr-only">40% Complete (success)</span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="white-box col-lg-4 col-sm-6 row-in-br">
            <ul class="col-in">
                <li>
                    <span class="circle circle-md bg-warning"><i class="fa fa-user-circle"></i></span>
                </li>
                <li class="col-last" style="padding:0;">
                    <h3 class="counter text-right m-t-15"><?php echo $total_scholarship_students;
; ?></h3>
                </li>
                <li class="">
                    <h4>Total Scholarship Students</h4>
                    <div class="progress">
                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                            <span class="sr-only">40% Complete (success)</span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="white-box col-lg-4 col-sm-6 row-in-br">
            <ul class="col-in">
                <li>
                    <span class="circle circle-md bg-inverse"><i class="fa fa-users"></i></span>
                </li>
                <li class="col-last" style="padding:0;">
                    <h3 class="counter text-right m-t-15"><?php echo $total_teachers; ?></h3>
                </li>
                <li class="">
                    <h4>Total Teachers</h4>
                    <div class="progress">
                        <div class="progress-bar progress-bar-inverse" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                            <span class="sr-only">40% Complete (success)</span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>



<!-- /.row -->
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="white-box">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <select id="school_list" class="selectpicker" data-style="form-control" onchange="changeGraph(this.value);">
                    <?php foreach ($school_data as
                            $key =>
                            $school) { ?>
                        <option value="<?php echo $school['school_id']; ?>"><?php echo $school['name']; ?></option>
<?php } ?>
                </select>
            </div>
            <div class="clearfix">&nbsp;</div>
            <div class="" id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
    </div>
</div>


<!-- row -->
<div class="row hide">
    <div class="col-md-8 col-sm-8">
        <div class="white-box">
            <div id="container_result" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div></div>
    <div class="col-md-4 col-lg-4 col-sm-12">
        <div class="white-box real-time-widgets">
            <h3 class="m-b-30">No. Of Parents Using App</h3>
            <div data-label="" class="css-bar m-t-30 css-bar-50 css-bar-xxl css-bar-success m-b-40"></div>
            <div class="data-text m-t-40">
                <h1 class="m-t-40">50</h1>
                <h5></h5><span>Parents</span></div>
        </div>
    </div>
</div>
<!--row holiday list-->

<div class="row">
    <div class="col-lg-5 col-sm-12 col-md-5">
        <div class="panel">
            <div class="p-20">
                <div class="row">
                    <div class="col-xs-3">
                        <h3 class="m-b-0">Holidays</h3>  
                    </div>
                    <div class="col-xs-5">
                        <select id="school_list1" class="selectpicker" data-style="form-control" onchange="changeHolidays(this.value);">
                            <?php foreach ($school_data as $key => $school) { ?>
                                <option value="<?php echo $school['school_id']; ?>"><?php echo $school['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-xs-4">
                        <select class="selectpicker" data-style="form-control" id="month_list" onchange="showHolidaysByMonth(this.value);">
<?php $monthStart =
        date('F',
        strtotime('Jan'));
for ($i =
1;
        $i <=
        12;
        $i++) { ?>
                                <option value="<?php echo date('m',
            strtotime($monthStart)) ?>" <?php if(date('m',
                    strtotime($monthStart)) == date('m')) { ?> selected="selected" <?php } ?>><?php echo $monthStart; ?></option>
    <?php $monthStart =
            date('F',
            strtotime($monthStart . '+1 month'));
} ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="panel-footer bg-extralight" id="holiday_div">
<?php if (count($holidays)) { ?>
                    <ul class="earning-box">
    <?php foreach ($holidays as
            $holiday) { ?>
                            <li>
                                <div class="er-row">
                                    <div class="er-text">
                                        <h3><?php echo ucfirst($holiday['title']); ?></h3>
                                        <span class="text-muted"><?php echo date('l',
                                                                strtotime($holiday['date_start'])); ?></span>
                                    </div>
                                    <div class="er-count "><?php echo date('d-m-Y',
                strtotime($holiday['date_start'])); ?></div>
                                </div>
                            </li>
                    <?php } ?>
                    </ul>
<?php } ?>
            </div>
        </div>
    </div>
    <!-- col-md-3 -->
    <div class="col-md-4 col-lg-4">
        <div class="white-box">
            <div id="container_pie" style="min-width: 310px; height: 450px; max-width: 600px; margin: 0 auto">
                
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3">
        <div class="white-box">
            <h3 class="box-title">Students in the schools</h3>
            <ul class="country-state">
<?php foreach ($school_data as
        $key =>
        $school) { ?>
                    <li class="m-b-30">
                        <h2><?php echo $school['total_students']; ?></h2> <small><?php echo $school['name']; ?></small>
                        <div class="pull-right"></div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:0;"> <span class="sr-only">48% Complete</span></div>
                        </div>
                    </li>
<?php } ?>
            </ul>
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
<script type="text/javascript">
var options = {
    chart: {
        renderTo: 'container',
        defaultSeriesType: 'column'
    },
    title: {
        text: 'Daily Attendance'
    },
    subtitle: {
        text: '<?php echo $currentMonth; ?>'
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        min: 0,
        max: 100,
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
    series: [{name: 'A', colorByPoint: true, data: [1, 2, 3, 2, 1]}]
};
var chart = new Highcharts.Chart(options);
</script>
<script>
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
    Highcharts.chart('container_pie', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '<h3 class="box-title">Fees Analysis</h3>'
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
                    {name: 'Paid', y: 56.33},
                    {name: 'Overdue', y: 24.03}

                ]
            }]
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        var school_id = "<?php echo $school_data[0]['school_id']; ?>";
        changeGraph(school_id);
    });

    function changeGraph(val) {
        var selVal = val;
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?admin/get_class_wise_school_attendance_data/' + selVal,
            dataType: 'json',
            success: function (response)
            {
                var options = {
                    chart: {
                        renderTo: 'container',
                        defaultSeriesType: 'column'
                    },
                    title: {
                        text: response.name
                    },
                    subtitle: {
                        text: '<?php echo $currentMonth; ?>'
                    },
                    xAxis: {
                        type: 'category'
                    },
                    yAxis: {
                        min: 0,
                        max: 100,
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
                    series: [{name: 'A', colorByPoint: true, data: []}]
                };

                $.each(response.data, function (itemNo, item) {
                    options.series[0].data.push({name: item.name, y: parseFloat(item.y)});
                });
                var chart = new Highcharts.Chart(options);
            }, error: function (message) {
                console.log(message);
            }
        });
    }

    function showHolidaysByMonth(monthValue) { 
        var school_id = $('#school_list1').val();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?admin/get_holidays_by_month/' + monthValue + '/' + school_id,
            success: function (response)
            {
                $('#holiday_div').html(response);
            }, error: function (xhr, status, error) {

            }
        });
    }
    
    function changeHolidays(school_id){
        var monthValue = $('#month_list').val();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?admin/get_holidays_by_month/' + monthValue + '/' + school_id,
            success: function (response)
            {
                $('#holiday_div').html(response);
            }, error: function (xhr, status, error) {

            }
        });
    }
</script>