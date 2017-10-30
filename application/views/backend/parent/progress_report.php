<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"><h4 class="page-title"><?php echo get_phrase($page_title . " " . '_subject_wise'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?parents/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title . " " . '_subject_wise'); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<div class="panel panel-danger block6" data-step="5" data-intro="<?php echo get_phrase('For Information');?>" data-position='bottom'>
    <div class="panel-heading"> Progress Report Notes
        <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
    </div>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
            <p>You can view the grades and observations that has been awarded. </p>
        </div>
    </div>
</div>

<?php
$row = $student_details;
?>
<div class="form-group col-sm-12 p-0">
<div class="badge badge-danger badge-stu-name pull-right m-b-20">
            <i class="fa fa-user"></i> <?php echo $student_name; ?>
</div>
</div>
<div class="row m-0">
    <div class="col-md-12 white-box">
        <div class="sttabs tabs-style-flip">
            <nav>
                <ul>
                    <?php $datatable  =       "";
                    foreach ($subjects as $row2):
                    $datatable = $datatable."#datatable_".$row2['subject_id'].",";
                        ?>
                        <li>
                            <a href="#data_table_<?php echo $row2['subject_id']; ?>" class="sticon fa fa-book">
                                <span><?php echo $row2['name']; ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
            <div class="content-wrap">
                <?php
                $count_row = count($subjects);
                $count_tab = 0;
                foreach ($subjects as $subject):
                    
                    ?>
                
                    <section id="data_table_<?php echo $subject['subject_id']; ?>">
                        <input type="hidden" id="section_ids" value="<?php echo rtrim($datatable," , "); ?>">
                        <table class="custom_table table datatable display" id="datatable_<?php echo $subject['subject_id'];?>">
                            <thead>
                                <tr>
                                    <th><div><?php echo get_phrase('teacher'); ?></div></th>
                                    <th><div><?php echo get_phrase('rating'); ?></div></th>
                                    <th><div><?php echo get_phrase('comments'); ?></div></th>
                                    <th><div><?php echo get_phrase('date'); ?></div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (array_key_exists('progress_report', $subject)):
                                    $reports = $subject['progress_report'];
                                    //pre($reports);die;
                                    foreach ($reports as $report):
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $report['name']; ?>
                                            </td>
                                            <td>
                                                <?php
                                                for ($i = 0; $i <= $report['rate']; $i++) {
                                                    echo '
                            <img onclick="javascript:rating(' . $i . ',\'student' . $row['student_id'] . '\')" name="student' . $row['student_id'] . '-' . $i . '" src=" ' . base_url() . 'uploads/rate' . $i . '.png"  >
                                ';
                                                }
                                                ?>
                                                <?php
                                                for ($i = $report['rate'] + 1; $i < 5; $i++) {
                                                    echo '
                            <img onclick="javascript:rating(' . $i . ',\'student' . $row['student_id'] . '\')" name="student' . $row['student_id'] . '-' . $i . '" src=" ' . base_url() . 'assets/images/Blank_star.png">
                            ';
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $report['comment']; ?></td>
                                            <td><?php echo $report['timestamp']; ?></td>
                                        </tr>
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                            </tbody>
                        </table>
                    </section>
                <?php endforeach; ?>
            </div>
        </div>
    </div>  
</div>

    <script>
     $('#example23').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
            'copy', 'excel', 'pdf', 'print'
        ]
    });
    </script>