<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title);?></h4> </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript:void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="#" class="active">Dashboard</a></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-md-12">
        <div class=" white-box col-lg-4 col-sm-6 row-in-br">
            <ul class="col-in">
                <li>
                    <span class="circle circle-md bg-danger"><i class="fa fa-plus-square-o"></i></span>
                </li>
                <li class="col-last" style="padding:0;">
                    <h3 class="counter text-right m-t-15">599</h3>
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
                    <h3 class="counter text-right m-t-15">2200</h3>
                </li>
                <li class="">
                    <h4>Total Students</h4>
                   
                </li>
            </ul>
        </div>
        <div class="white-box col-lg-4 col-sm-6 row-in-br">
            <ul class="col-in">
                <li>
                    <span class="circle circle-md bg-success"><i class="fa fa-users"></i></span>
                </li>
                <li class="col-last" style="padding:0;">
                    <h3 class="counter text-right m-t-15">59</h3>
                </li>
                <li class="">
                    <h4>Total TCs</h4>
                   
                </li>
            </ul>
        </div>    
        <div class="white-box">
            <div id="chart1">
                <div class="row">
                    <div class="col-md-1 col-sm-1 col-xs-1 text-center">
                        Hi
                    </div>
                    <div class="col-md-10 col-sm-10 col-xs-10">
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-1 text-center">
                        Hello
                    </div>
                </div>
            </div>
            <div class="clearfix">&nbsp;</div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div id="chart2"></div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div id="chart3"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 panel panel-default">
                    <div class="panel-heading">Recent Invoices</div>
                    <div class="panel-body">    
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Account</th>
                                        <th>Amount</th>
                                        <th>Invoice Date</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Bank of India</td>
                                        <td>AED 9,259,259.33</td>
                                        <td>Jul 01 2017</td>
                                        <td>Jul 11 2017</td>
                                        <td>Unpaid</td>
                                        <td><input type="button" class="btn btn-primary btn-xs" value="View" /></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 panel panel-default">
                    <div class="panel-heading">Latest Payment</div>
                    <div class="panel-body">    
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Account</th>
                                        <th>Amount</th>
                                        <th>Invoice Date</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Bank of India</td>
                                        <td>AED 9,259,259.33</td>
                                        <td>Jul 01 2017</td>
                                        <td>Jul 11 2017</td>
                                        <td>Unpaid</td>
                                        <td><input type="button" class="btn btn-primary btn-xs" value="View" /></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 panel panel-default">
                    <div class="panel-heading">Outstanding Fee summery</div>
                    <div class="panel-body">    
                        <div class="table-responsive">
                            <table class="table table-condensed table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Class</th>
                                        <th>No. of Students</th>
                                        <th>Amount</th>
                                        <th>Invoice Date</th>
                                        <th>Due Date</th>
                                        <th>Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Nursery</td>
                                        <th>2</th>
                                        <td>AED 3,259.33</td>
                                        <td>Jul 01 2017</td>
                                        <td>Jul 11 2017</td>
                                        <td><input type="button" class="btn btn-primary btn-xs" value="View" /></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--script for chart-->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<script type="text/javascript">
var chart = Highcharts.chart('chart2', {
    title: {
        text: 'Total Fee Collection / Total Fee Charged'
    },    

    xAxis: {
        categories: ['Total Fee Collection', 'Total Fee Charged']
    },

    series: [{
        name: 'Amount',
        type: 'column',
        colorByPoint: true,
        data: [20000, 50000],
        showInLegend: false
    }]

});

$('#plain').click(function () {
    chart.update({
        chart: {
            inverted: false,
            polar: false
        },
        subtitle: {
            text: 'Plain'
        }
    });
});

$('#inverted').click(function () {
    chart.update({
        chart: {
            inverted: true,
            polar: false
        },
        subtitle: {
            text: 'Inverted'
        }
    });
});

$('#polar').click(function () {
    chart.update({
        chart: {
            inverted: false,
            polar: true
        },
        subtitle: {
            text: 'Polar'
        }
    });
});

var chart = Highcharts.chart('chart1', {
    title: {
        text: 'Fee Collection'
    },    

    xAxis: {
        categories: ['Registration Fee', 'Tuition Fee', 'Caution Fee', 'Dormitory Fee', 'Transport Fee']
    },

    series: [{
        name: 'Amount',
        type: 'column',
        colorByPoint: true,
        data: [20000, 50000, 55000, 35000, 45000],
        showInLegend: false
    }]

});

$('#plain').click(function () {
    chart.update({
        chart: {
            inverted: false,
            polar: false
        },
        subtitle: {
            text: 'Plain'
        }
    });
});

$('#inverted').click(function () {
    chart.update({
        chart: {
            inverted: true,
            polar: false
        },
        subtitle: {
            text: 'Inverted'
        }
    });
});

$('#polar').click(function () {
    chart.update({
        chart: {
            inverted: false,
            polar: true
        },
        subtitle: {
            text: 'Polar'
        }
    });
});

Highcharts.chart('chart3', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Last 6 months revenue'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y:1f}</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y:1f}',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Revenue',
        colorByPoint: true,
        data: [{
            name: 'March',
            y: 620000
        }, {
            name: 'April',
            y: 520000,
            sliced: true,
            selected: true
        }, {
            name: 'May',
            y: 620000
        }, {
            name: 'June',
            y: 615000
        }, {
            name: 'July',
            y: 450000
        }, {
            name: 'August',
            y: 260000
        }]
    }]
});

</script>
