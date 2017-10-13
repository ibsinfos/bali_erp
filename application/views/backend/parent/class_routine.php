<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('class_timetable'); ?></h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?parents/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active">
                <?php echo get_phrase($page_title); ?>
            </li>
        </ol>
    </div>
</div>
<?php
if (!empty($student_details)) {
    foreach ($student_details as $row):
        ?>

        <div class="badge badge-danger badge-stu-name pull-right m-b-20">
            <i class="fa fa-user"></i> <?php echo $row['student_name']; ?>
        </div>

        <div class="row m-0">
            <div class="col-md-12 no-padding">

                <div class="panel panel-default" data-collapsed="0" data-step="5" data-intro="<?php echo get_phrase('Child\'s Class TImetable');?>" data-position='top'>
                    <div class="panel-heading panel_none_border">
                        <div class="panel-title">
                            <?php echo $row['class_name'] ?> : 
                            <?php echo $row['section_name']; ?>
                            <a href="<?php echo base_url(); ?>index.php?parents/class_routine_print_view/<?php echo $student_id; ?>" 
                               class="fcbtn btn btn-danger btn-outline btn-1d pull-right" target="_blank">
                                 <?php echo get_phrase('print'); ?>
                            </a>
                        </div>
                    </div>
                    <div class="panel-body panel_for_child">

                        <table cellpadding="0" cellspacing="0" border="0"  class="table table-bordered">
                            <tbody>
                                <?php
                                foreach ($class_routine_data AS $k => $routin_details):
                                    ?>
                                    <tr class="gradeA">
                                        <td width="100"><?php echo strtoupper($k); ?></td>
                                        <td>
            <?php
            if (!empty($routin_details)) {

                foreach ($routin_details as $row => $val):
                    ?>
                                                    <div class="btn-group">
                                                        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                            <?php echo $val['subject_name']; ?>
                                                            <?php
                                                            echo $val['teacher_name'];
                                                            ?>
                                                            <?php
                                                            if ($val['time_start_min'] == 0 && $val['time_end_min'] == 0)
                                                                echo '(' . $val['time_start'] . '-' . $val['time_end'] . ')';
                                                            if ($val['time_start_min'] != 0 || $val['time_end_min'] != 0)
                                                                echo '(' . $val['time_start'] . ':' . $val['time_start_min'] . '-' . $val['time_end'] . ':' . $val['time_end_min'] . ')';
                                                            ?>

                                                        </button>
                                                    </div>
                <?php endforeach; ?>
                                            <?php } else {
                                                echo '&nbsp;';
                                            } ?>
                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>
                        </table>

                    </div>
                </div>

            </div>

        </div>
    <?php endforeach;
} else {
    ?>
    <div class="panel panel-heading" data-collapsed="0" >
        <div class="panel-heading">
            <div class="panel-title" >
                <i class="entypo-info"></i>
    <?php echo get_phrase("No information available!!!"); ?>
            </div>
        </div> 
    </div>
<?php } ?>

