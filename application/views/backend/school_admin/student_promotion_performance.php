<div class="col-md-12 text-right">
	<span class="badge badge-success badge-stu-name">
		<i class="fa fa-user"></i> <?php echo $this->crud_model->get_type_name_by_id('student' , $param2);?>
	</span>
</div>
<div class="row">
    <div class="col-md-12">
        <div>
            <?php foreach ($subjects as $exam_key => $exam): ?>
            <div class="panel-heading"><h4><b><?php echo $exam['exam_name'];?></b></h4></div>         
            <div class="panel-body">               
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td class="text-center">Subject</td>
                            <td class="text-center">Obtained marks</td>
                            <td class="text-center">Maximum mark</td>
                            <td class="text-center">Grade</td>
                            <td class="text-center">Comment</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  $total_marks = 0;
                            $total_grade_point = 0;
                            foreach ($exam['subject'] as $sub_key => $sub):?>
                            <tr>
                                <td class="text-center"><?php echo $sub['subject_name'];?></td>
                                <td class="text-center">
                                    <?php $total_marks += $sub['mark_obtained'];?>
                                </td>
                                <td class="text-center">
                                    <?php echo $sub['highest_mark'];?>
                                </td>
                                <td class="text-center">
                                    <?php echo $sub['grade_name'];?>
                                </td>
                                <td class="text-center">
                                    <?php echo $sub['comment'];?>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>

                <?php echo get_phrase('total_marks');?> : <?php echo $total_marks;?>
                <br>
                <?php echo get_phrase('average_grade_point');?> : 
                <?php $number_of_subjects = count($sub);
                    $number_of_subjects = $this->db->count_all_results();
                    echo ($exam['grade_point'] / $number_of_subjects);?>
            </div>
            <?php endforeach;?>
        </div>  
    </div>
</div>
