<div class="row bg-title">
    
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>

        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><?php echo get_phrase('student'); ?>
                <ul>                    
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/student_information"><?php echo get_phrase('student_information'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/student_promotion"><?php echo get_phrase('student_promotion'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/map_students_id"><?php echo get_phrase('map_students_id'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/student_fee_configuration"><?php echo get_phrase('student_fee_setting'); ?></a></li>
                </ul>
            </li>
            <li class="active">
                <?php echo $page_title; ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<div class="row">
    <div class="col-md-12">  
        <?php if (!empty($average)) { ?>
            <div class="col-md-6 col-xs-12" id="piechart"></div>
            <div class="col-md-6 col-xs-12 chart_in_mobile" id="columnchart"></div>
            <?php
        } else {
            echo "<label class='label label-danger'>No Data Avaiable</label>";
        }
        ?>

    </div>
</div>       

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/old_js/google_chart.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/new_assets/js/google_chart.js"></script>-->
<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Year', 'Average'],
<?php
$i=1;
foreach ($average as $row1) {
    echo "[" . "'" . $row1['Exam_type'] . "'" . "," . $row1['marks'] . "]";
    if($i<count($average)) { echo ","; }
    $i++;
}
?>
        ]);

        var options = {
            title: 'Average Percent of each Exam',
            width: 600,
            height: 400,
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }
</script>
<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Year', 'Average'],
<?php
$i=1;
foreach ($average as $row1) {
    echo "[" . "'" . $row1['Exam_type'] . "'" . "," . $row1['marks'] . "]";
    if($i<count($average)) { echo ","; }
    $i++;
}
?>
        ]);

        var options = {
            title: 'Average of each Exam',
            width: 600,
            height: 400,
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('columnchart'));

        chart.draw(data, options);
    }
</script>