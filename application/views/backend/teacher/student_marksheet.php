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
            <li class="active"><?php echo get_phrase('student_marksheet'); ?></li>
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
                         if(!in_array(strtoupper ($row2['name']),$exam_types)){ ?>
                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                        <table class="table-bordered table">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">Subject</th>
                                                                    <th class="text-center">Obtained marks</th>
                                                                    <th class="text-center">Highest mark</th>
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
//                                                    
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
                                                                        <td class="text-center">
                                                                            <?php
                                                                           if(isset($row3['highest_mark'])) {
                                                    $highest_mark = $row3['highest_mark'];
                                                                           echo $highest_mark; }
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
                                                        <a href="<?php echo base_url(); ?>index.php?teacher/student_marksheet_print_view/<?php echo $student_id; ?>/<?php echo $row2['exam_id']; ?>" class="fcbtn btn btn-danger btn-outline btn-1d" target="_blank">
                                                            <?php echo get_phrase('print_marksheet'); ?>
                                                        </a>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div id="chartdiv<?php echo $row2['exam_id']; ?>" class="exam_chart">
                                                        </div>
                                                        <script type="text/javascript">
                                                            var chart <?php echo $row2['exam_id']; ?> = AmCharts.makeChart("chartdiv<?php echo $row2['exam_id']; ?>", {
                                                                "theme": "none",
                                                                "type": "serial",
                                                                "dataProvider": [
                                                                    <?php
            foreach ($subjects as $subject) :
                ?> {
                                                                        "subject": "<?php echo $subject['name']; ?>",
                                                                        "mark_obtained": <?php
                $obtained_mark = $this->crud_model->get_obtained_marks($row2['exam_id'], $class_id, $subject['subject_id'], $row1['student_id']);
                echo $obtained_mark;
                ?>,
                                                                        "mark_highest": <?php
                $highest_mark = $this->crud_model->get_highest_marks($row2['exam_id'], $class_id, $subject['subject_id']);
                echo $highest_mark;
                ?>
                                                                    },
                                                                    <?php
            endforeach;
            ?>

                                                                ],
                                                                "valueAxes": [{
                                                                    "stackType": "3d",
                                                                    "unit": "%",
                                                                    "position": "left",
                                                                    "title": "Obtained Mark vs Highest Mark"
                                                                }],
                                                                "startDuration": 1,
                                                                "graphs": [{
                                                                    "balloonText": "Obtained Mark in [[category]]: <b>[[value]]</b>",
                                                                    "fillAlphas": 0.9,
                                                                    "lineAlpha": 0.2,
                                                                    "title": "2004",
                                                                    "type": "column",
                                                                    "fillColors": "#7f8c8d",
                                                                    "valueField": "mark_obtained"
                                                                }, {
                                                                    "balloonText": "Highest Mark in [[category]]: <b>[[value]]</b>",
                                                                    "fillAlphas": 0.9,
                                                                    "lineAlpha": 0.2,
                                                                    "title": "2005",
                                                                    "type": "column",
                                                                    "fillColors": "#34495e",
                                                                    "valueField": "mark_highest"
                                                                }],
                                                                "plotAreaFillAlphas": 0.1,
                                                                "depth3D": 20,
                                                                "angle": 45,
                                                                "categoryField": "subject",
                                                                "categoryAxis": {
                                                                    "gridPosition": "start"
                                                                },
                                                                "exportConfig": {
                                                                    "menuTop": "20px",
                                                                    "menuRight": "20px",
                                                                    "menuItems": [{
                                                                        "format": 'png'
                                                                    }]
                                                                }
                                                            });
                                                        </script>
                                                    </div>

                                                </div>
                                                <?php }?>
                                        </div>

                                            </div>
                                    </div>

<?php
endforeach;
endforeach;
?>