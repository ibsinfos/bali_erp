<div class="row bg-title"> 
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo ucfirst($page_title);?></h4> </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript:void(0);" onclick="javascript:introJs().start();" id="take-tour" target="_blank" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="#" class="active"> Dashboard</a></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="white-box">
             <div class="p-30">
                <div class="row">
                    <div class="col-xs-4">
                        <?php if ($doctor_list->profile_pic != "" && file_exists('uploads/doctor_image/' . $doctor_list->profile_pic)) {
                                $doctor_image = $doctor_list->profile_pic;
                                } else {
                                    $doctor_image = '';
                                } ?>
                                <img src="<?php echo ($doctor_image!=""?"uploads/doctor_image/".$doctor_image:"uploads/user.png");?>" width="200px" height="200px"/>
                        
                        <?php // if($doctor_list->profile_pic!= ''){
//                            $img = base_url()."uploads/doctor_image/".$doctor_list->profile_pic;
//                        }else{
//                            $img = base_url()."uploads/doctor_image/doctor.png";
//                        } ?>
                        <!--<img src="<?php // echo $img; ?>" width="200px" height="200px">-->
                    </div>
                <div class="col-xs-8">
                    <h2 class="m-b-0"><?php echo $doctor_list->name; ?></h2>
                    <h4><?php echo $doctor_list->email; ?></h4>
                </div>
                </div>
                <div class="row text-center m-t-30">
                    <div class="col-xs-4 b-r">
                        <h2><?php echo get_phrase('Contact'); ?></h2>
                        <h4><?php echo $doctor_list->phone_no; ?></h4></div>
                    <div class="col-xs-4 b-r">
                        <h2><?php echo get_phrase('specialization'); ?></h2>
                        <h4><?php echo $doctor_list->specialization; ?></h4></div>
                    <div class="col-xs-4">
                        <h2><?php echo get_phrase('department'); ?></h2>
                        <h4><?php echo $doctor_list->department; ?></h4></div>
                </div>
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
</script>

<script>
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
</script>
<script>
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
</script>