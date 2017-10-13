<div class="row bg-title"> 
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('student_marksheet'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?teacher/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase('exam_marks'); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<?php
    foreach ($student_info as $row1):
       foreach ($marks_data as $row2):
        $row2 = $row2['marks'];
            ?>
        
               <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-danger block6" data-collapsed="0">
                                            <div class="panel-heading">
                                                <?php echo $row2['name']; ?>
                                            </div>
                                            <?php
                         $exam_types = array("FA1", "FA2", "SA1", "FA3","FA4", "SA2");
                         if(!in_array(strtoupper ($row2['name']),$exam_types)){?>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table-bordered table">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Subject</th>
                                                    <th class="text-center">Obtained marks</th>
                                                    <th class="text-center">Maximum marks</th>
                                                    <th class="text-center">Grade</th>
                                                    <th class="text-center">Comment</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                        $total_marks = 0;
                        $total_grade_point = 0;

                        foreach ($row2['subject'] as $row3):
                            ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo $row3['name']; ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    if(isset($row3['obtained'])){     
                                        if (count($row3['obtained']) > 0)
                                        {
                                            foreach ($row3['obtained'] as $row4)
                                            {
                                                echo $row4['mark_obtained'];
                                                $total_marks += $row4['mark_obtained'];
                                            }
                                        }
                                    }
                                    ?>
                                </td>
                                <!-- <td class="text-center">
                                    <?php
                                   if(isset($row3['highest_mark'])) {
            $highest_mark = $row3['highest_mark'];
                                   echo $highest_mark; }
            ?>
                                </td> -->
                                <td class="text-center">
                                    <?php
                                    if(isset($row3['obtained'])){     
                                        if (count($row3['obtained']) > 0)
                                        {
                                            foreach ($row3['obtained'] as $row4)
                                            {
                                                echo $row4['mark_total'];
                                            }
                                        }
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    if(isset($row4['grade'])){     
            if (count($row4['grade']) > 0)
            {
                if ($row4['grade'] >= 0 || $row4['grade'] != '')
                {
                    
                    $grade = $row4['grade'];
                    echo $grade['name'];
                    $total_grade_point += $grade['grade_point'];
                }
            }
                                    }
            ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    if(isset($row3['obtained'])){  
            if (count($row3['obtained']) > 0)
                echo $grade['comment'];
                                    }
            ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="col-md-12 p-0">

                <b><?php echo get_phrase('total_marks'); ?></b> :
                <?php echo $total_marks; ?>
                    <br/>
                    <b><?php echo get_phrase('average_grade_point'); ?></b> :
                    <?php

echo ($total_grade_point / $row3['tot_subjects']);
?>

            </div>
            <div class="text-right">
                <a href="<?php echo base_url(); ?>index.php?student/student_marksheet_print_view/<?php echo $student_id; ?>/<?php echo $row2['exam_id']; ?>" class="fcbtn btn btn-danger btn-outline btn-1d" target="_blank">
                    <?php echo get_phrase('print_marksheet'); ?>
                </a>
            </div>
        </div>
        <?php }?>
</div>


<!--2nd table-->


    </div>
</div>

<?php
endforeach;
endforeach;
?>