<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"><h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?parents/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>


<?php
foreach ($child_of_parent as $child):
    ?>
    <div class="row">
        <div class="col-md-12" data-step="5" data-intro="<?php echo get_phrase('Here you just select exam type');?>" data-position='bottom'>
            <!-- <ul class="nav tabs-vertical">
            <?php
            if (!empty($exams)):
                $datatable = "";
                $count = 0;
                foreach ($exams as $row2):
                    $datatable = $datatable . "#datatable_" . $row2['exam_id'] . ",";
                    $count++;
                    ?>
                                                         <li class="<?php echo ($count == 1 ? "active" : ""); ?>">
                                                             <a href="#table_export_<?php echo $row2['exam_id']; ?>" data-toggle="tab">
                    <?php echo $row2['name']; ?>  <small>( <?php echo $row2['date']; ?> )</small>
                                                             </a>
                                                         </li>
                <?php endforeach; ?>
            <?php endif; ?>
             </ul>-->
            <div class="row">
                <div class="col-md-12">     

                    <div class="col-md-5 no-padding form-group" data-step="6" data-intro="<?php echo get_phrase('Select option which exam marks you need to see');?>" data-position='top'>
                        <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('exam'); ?></label>
                        <select name="exam_id"  class="selectpicker" data-style="form-control" data-live-search="true" onchange="get_exam_change(this.value,<?php echo $child['student_id']; ?>)">
                            <?php
                            foreach ($exams as $row):
                                ?>
                                <option <?php if ($row['exam_id'] == $exam_id) echo "selected"; ?> value="<?php echo $row['exam_id']; ?>"><?php echo $row['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="pull-right badge badge-danger badge-stu-name">
                        <?php echo $child['name']; ?>
                    </div>  

                </div>     
            </div>
        </div>

        <div class="row m-0">
            <div class="col-md-12">
                <div class="white-box tab-content m-0" data-step="7" data-intro="<?php echo get_phrase('Here you see student exam marks');?>" data-position='top'>
                    <?php
                    $count = 0;
                    foreach ($exams as $exam):
                        $count++;
                        ?>
                        <input type="hidden" id="exam_ids" value="<?php echo rtrim($datatable, ","); ?>" >
                        <div class="tab-pane <?php echo ($count == 1 ? "active" : ""); ?>" id="table_export_<?php echo $exam['exam_id']; ?>">

                            <table id="example23" id="datatable_<?php echo $exam['exam_id']; ?>" class="new_tabulation display nowrap table">

                                <thead>
                                    <tr>
                                        <th><?php echo get_phrase('class'); ?></th>
                                        <th><?php echo get_phrase('subject'); ?></th>
                                        <th><?php echo get_phrase('mark_obtained'); ?></th>
                                        <th><?php echo get_phrase('maximum_marks'); ?></th>
                                        <th><?php echo get_phrase('comment'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($marks as $mark): ?>
                                        <tr>
                                            <td>
                                                <?php
                                                echo $mark['class_name'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo $mark['subject_name'];
                                                ?>
                                            </td>
                                            <td><?php echo $mark['mark_obtained']; ?></td>
                                            <td><?php echo $mark['mark_total']; ?></td>
                                            <td><?php echo $mark['comment']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <div class="text-right p-t-20" data-step="6" data-intro="Onclick of print marksheet, you can take printout of marksheet" data-position='top'>
                                <a href="<?php echo base_url(); ?>index.php?parents/student_marksheet_print_view/<?php echo $student_id; ?>/<?php echo $exam_id; ?>" 
                                   class="fcbtn btn btn-danger btn-outline btn-1d" target="_blank">
                                    <?php echo get_phrase('print_marksheet'); ?>
                                </a>
                            </div> 
                        </div>
                    <?php endforeach; ?>

                </div>  

            </div>  
        </div>

    <?php endforeach; ?>

    <!-----  DATA TABLE EXPORT CONFIGURATIONS ----->                      
    <script type="text/javascript">

        function get_exam_change(exam_id, child_id) {

            var URL = "<?php echo base_url(); ?>index.php?parents/marks/" + child_id + "/" + exam_id;
            location.href = URL;
        }
    </script>