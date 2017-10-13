<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">Student Dashboard</h4> </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript:void(0);" onclick="javascript:introJs().start();" id="take-tour" target="_blank" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="#" class="active"> Dashboard</a></li>

        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<!-- ============================================================== -->
<!-- Page Content -->
<!-- ============================================================== -->

<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
        <div class="row">
            <?php foreach ($student_subject_details as $sub) { ?>
                <div class="col-lg-4 col-sm-4 col-xs-12">
                    <div class="white-box m-b-10 p-20 height_box_stu_sub">
                        <h3 class="m-t-0 m-b-10"><i class="fa fa-book text-info"></i> <?php echo $sub['subject_name']; ?></h3>
                        <ul class="list-inline">
                            <li class="text-left"><h5 class="teacher-word-break"><b><?php echo get_phrase('Teacher: '); ?></b><?php echo $sub['teacher_name']; ?></h5></li><br>
                            <li class="text-left"><b><?php echo get_phrase('Period: '); ?></b><?php echo $sub['period'] . " / Week"; ?></li>

                        </ul>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="panel">
            <div class="p-30">
                <div class="row">
                    <div class="col-xs-4">
                        <img src="<?php echo ($edit_data['stud_image'] != " " ? "uploads/student_image/" . $edit_data['stud_image'] : "uploads/user.jpg"); ?>" alt="profile_image" width="100px" height="100px">

                    </div>
                    <div class="col-xs-8">
                        <h2 class="m-b-0"><?php echo $student_details->name . " " . $student_details->lname; ?></h2>
                        <h4><?php echo $student_details->email; ?></h4></div>
                </div>
                <div class="row text-center m-t-30">
                    <div class="col-xs-4 b-r">
                        <h2><?php echo get_phrase('class'); ?></h2>
                        <h4><?php echo $student_details->class_name; ?></h4></div>
                    <div class="col-xs-4 b-r">
                        <h2><?php echo get_phrase('section'); ?></h2>
                        <h4><?php echo $student_details->section_name; ?></h4></div>
                    <div class="col-xs-4">
                        <h2><?php echo get_phrase('enroll_code'); ?></h2>
                        <h4><?php echo $student_details->enroll_code; ?></h4></div>
                </div>
            </div>


            <hr>
            <!-- <ul class="dp-table profile-social-icons">
                <li><a href="javascript:void(0)" class="tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('View Profile'); ?>"><i class="fa fa-globe"></i></a></li>
                <li><a href="javascript:void(0)" class="tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('Twitter'); ?>"><i class="fa fa-twitter"></i></a></li>
                <li><a href="javascript:void(0)" class="tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('Facebook'); ?>"><i class="fa fa-facebook"></i></a></li>
                <li><a href="javascript:void(0)" class="tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('Youtube'); ?>"><i class="fa fa-youtube"></i></a></li>
                <li><a href="javascript:void(0)" class="tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('LinkedIn'); ?>"><i class="fa fa-linkedin"></i></a></li>
            </ul> -->
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- Sales, finance & Expance widgets -->
<!-- ============================================================== -->
<!-- .row -->
<div class="row">
    <div class="col-md-8 col-sm-8 col-xs-12">
        <div class="white-box">
            <h3 class="m-b-0">Yearly Attedance</h3>


            <ul class="dp-table m-t-20">
                <li>
                    <div class="progress progress-md progress-vertical-bottom m-0">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100" style="height:30%;"> <span class="sr-only">88% Complete</span> </div>
                    </div>
                    <br/> <b>Jul</b> </li>
                <li>
                    <div class="progress progress-md progress-vertical-bottom m-0">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100" style="height:60%;"> <span class="sr-only">88% Complete</span> </div>
                    </div>
                    <br/> <b>Aug</b> </li>
                <li>
                    <div class="progress progress-md progress-vertical-bottom m-0">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100" style="height:80%;"> <span class="sr-only">88% Complete</span> </div>
                    </div>
                    <br/> <b>Sep</b> </li>
                <li>
                    <div class="progress progress-md progress-vertical-bottom m-0">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100" style="height:30%;"> <span class="sr-only">88% Complete</span> </div>
                    </div>
                    <br/> <b>Oct</b> </li>
                <li>
                    <div class="progress progress-md progress-vertical-bottom m-0">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100" style="height:40%;"> <span class="sr-only">88% Complete</span> </div>
                    </div>
                    <br/> <b>Nov</b> </li>
                <li>
                    <div class="progress progress-md progress-vertical-bottom m-0">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100" style="height:20%;"> <span class="sr-only">88% Complete</span> </div>
                    </div>
                    <br/> <b>Dec</b> </li>
                <li>
                    <div class="progress progress-md progress-vertical-bottom m-0">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100" style="height:50%;"> <span class="sr-only">88% Complete</span> </div>
                    </div>
                    <br/> <b>Jan</b> </li>
                <li>
                    <div class="progress progress-md progress-vertical-bottom m-0">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100" style="height:50%;"> <span class="sr-only">88% Complete</span> </div>
                    </div>
                    <br/> <b>Feb</b> </li>
                <li>
                    <div class="progress progress-md progress-vertical-bottom m-0">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100" style="height:50%;"> <span class="sr-only">88% Complete</span> </div>
                    </div>
                    <br/> <b>Mar</b> </li>
            </ul>
        </div>
    </div>


    <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="white-box real-time-widgets">
            <h3 class="m-0">Attendence Percentage</h3>
            <div id="container" style="width: 300px; height: 300px; margin: 0 auto">
            </div>
        </div>
    </div>

    <!-- col-md-3 -->
</div>
<!-- /.row -->

<!-- To do list, & Feed widgets -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-lg-4 col-sm-12 col-md-4">
        <div class="panel">
            <div class="p-20">
                <div class="row">
                    <div class="col-xs-8">
                        <h3 class="m-b-0 m-t-0">Holidays List</h3>
                    </div>
                    <div class="col-xs-4">
                        <select class="selectpicker" data-style="form-control" data-live-search="true">
                            <option>JAN</option>
                            <option>FEB</option>
                            <option>MARCH</option>
                            <option>APRIL</option>
                            <option>MAY</option>
                            <option>JUNE</option>
                            <option>JULY</option>
                            <option>AUGUST</option>
                            <option>SEPTEMBER</option>
                            <option>OCTOBER</option>
                            <option>NOVEMNER</option>
                            <option>DEC</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="panel-footer bg-extralight scrollbar student_dash_scrollbar p-r-20">
                <ul class="earning-box">
                    <li>
                        <div class="er-row">
                            <div class="er-text">
                                <h3>Diwali Holiday</h3><span class="text-muted">wednesday</span></div>
                            <div class="er-count ">11-05-2016</div>
                        </div>
                    </li>
                    <li>
                        <div class="er-row">
                            <div class="er-text">
                                <h3>Eid Holiday</h3><span class="text-muted">sunday</span></div>
                            <div class="er-count ">11-05-2016</div>
                        </div>
                    </li>
                    <li>
                        <div class="er-row">
                            <div class="er-text">
                                <h3>Holi Holiday</h3><span class="text-muted">monday</span></div>
                            <div class="er-count ">11-05-2016</div>
                        </div>
                    </li>
                    <li>
                        <div class="er-row">
                            <div class="er-text">
                                <h3>friday</h3><span class="text-muted">saturday</span></div>
                            <div class="er-count ">11-05-2016</div>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-12 col-md-4">
        <div class="white-box">
            <h3 class="m-t-0"><?php echo get_phrase('Campus_Updates'); ?></h3>
            <div class="panel-footer bg-extralight scrollbar student_dash_scrollbar p-r-20">
                <ul class="feeds">
                    <?php if (!empty($notifications)) { ?>
                        <?php foreach ($notifications as $notify) { ?>
                            <li>
                                <div class="bg-info"><i class="fa fa-bell-o text-white"></i></div><?php echo $notify['notification']; ?><span class="text-muted"><?php echo $notify['created_date']; ?></span>
                            </li>
                            <?php
                        }
                    } else {
                        ?>
                        <li>
                            <div class="bg-info"><i class="fa fa-bell-o text-white"></i></div><?php echo get_phrase('No_latest_updates'); ?><span class="text-muted"><?php echo " "; ?></span>
                        </li>
                    <?php } ?>
                </ul>
            </div >
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
        <div class="white-box">
            <h3 class="m-t-0">Course Completion</h3>
            <div class="panel-footer bg-extralight scrollbar student_dash_scrollbar p-r-20">
                <ul class="country-state m-t-20">
                    <li>
                        <h2>Maths</h2> <small>From Mr. trump</small>
                        <div class="pull-right">48% </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:48%;"> <span class="sr-only">48% Complete</span></div>
                        </div>
                    </li>
                    <li>
                        <h2>English</h2> <small>Mr. Bread</small>
                        <div class="pull-right">98% </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-inverse" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:98%;"> <span class="sr-only">98% Complete</span></div>
                        </div>
                    </li>
                    <li>
                        <h2>Science</h2> <small>Mr. Jock</small>
                        <div class="pull-right">75% </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:75%;"> <span class="sr-only">75% Complete</span></div>
                        </div>
                    </li>
                    <li>
                        <h2>Language</h2> <small>Mr. Bred</small>
                        <div class="pull-right">48% </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:48%;"> <span class="sr-only">48% Complete</span></div>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>

<!-- row -->
<div class="row">
    <div class="col-md-3 col-xs-12 col-sm-6">
        <div class="white-box p-10 m-b-0 bg-danger">
            <h3 class="text-white box-title">Class <?php echo $student_details->class_name; ?> Result</h3>
            <div id="sparkline1dash"></div>
        </div>
        <div class="white-box">
            <div class="row">
                <div class="p-l-20 p-r-20 text-center">
                    <div data-label="60%" class="css-bar css-bar-60 css-bar-lg m-b-0 css-bar-danger"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- /#page-wrapper -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>

<script>
            if (!Highcharts.theme) {
                Highcharts.setOptions({
                    chart: {
                        backgroundColor: ''
                    },
                    colors: ['#ff7676'],
                    title: {
                        style: {
                            color: 'silver'
                        }
                    },
                    tooltip: {
                        style: {
                            color: 'silver'
                        }
                    }
                });
            }
            Highcharts.chart('container', {

                chart: {
                    type: 'solidgauge',
                    marginTop: 50
                },

                title: {
                    text: '',
                    style: {
                        fontSize: '24px'
                    }
                },

                tooltip: {
                    borderWidth: 0,
                    backgroundColor: 'none',
                    shadow: false,
                    style: {
                        fontSize: '16px'
                    },
                    pointFormat: '{series.name}<br><span style="font-size:2em; color: {point.color}; font-weight: bold">{point.y}%</span>',
                    positioner: function (labelWidth) {
                        return {
                            x: 150 - labelWidth / 2,
                            y: 130
                        };
                    }
                },

                pane: {
                    startAngle: 0,
                    endAngle: 360,
                    background: [{// Track for Move
                            outerRadius: '112%',
                            innerRadius: '88%',
                            backgroundColor: Highcharts.Color(Highcharts.getOptions().colors[0])
                                    .setOpacity(0.3)
                                    .get(),
                            borderWidth: 0
                        }]
                },

                yAxis: {
                    min: 0,
                    max: 100,
                    lineWidth: 0,
                    tickPositions: []
                },

                plotOptions: {
                    solidgauge: {
                        dataLabels: {
                            enabled: false
                        },
                        linecap: 'round',
                        stickyTracking: false,
                        rounded: true
                    }
                },

                series: [{
                        name: '<?php echo date('F'); ?>',
                        data: [{
                                color: Highcharts.getOptions().colors[0],
                                radius: '112%',
                                innerRadius: '88%',
                                y: <?php echo $percentage; ?>
                            }]

                    }]
            },
                    /**
                     * In the chart load callback, add icons on top of the circular shapes
                     */
                            function callback() {

                                // Move icon
                                this.renderer.path(['M', -8, 0, 'L', 8, 0, 'M', 0, -8, 'L', 8, 0, 0, 8])
                                        .attr({
                                            'stroke': '#303030',
                                            'stroke-linecap': 'round',
                                            'stroke-linejoin': 'round',
                                            'stroke-width': 2,
                                            'zIndex': 10
                                        })
                                        .translate(190, 26)
                                        .add(this.series[2].group);

                                // Exercise icon
                                this.renderer.path(['M', -8, 0, 'L', 8, 0, 'M', 0, -8, 'L', 8, 0, 0, 8,
                                    'M', 8, -8, 'L', 16, 0, 8, 8])
                                        .attr({
                                            'stroke': '#ffffff',
                                            'stroke-linecap': 'round',
                                            'stroke-linejoin': 'round',
                                            'stroke-width': 2,
                                            'zIndex': 10
                                        })
                                        .translate(190, 61)
                                        .add(this.series[2].group);

                                // Stand icon
                                this.renderer.path(['M', 0, 8, 'L', 0, -8, 'M', -8, 0, 'L', 0, -8, 8, 0])
                                        .attr({
                                            'stroke': '#303030',
                                            'stroke-linecap': 'round',
                                            'stroke-linejoin': 'round',
                                            'stroke-width': 2,
                                            'zIndex': 10
                                        })
                                        .translate(190, 96)
                                        .add(this.series[2].group);
                            });
</script>