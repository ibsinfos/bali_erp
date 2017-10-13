<button  onclick="window.print()" id = "with_print">Take a Print</button>
<style>
@media print {
    #with_print {
        display: none;
    }
}
</style>
<div id="with_or_without_print">
	<script src="assets/js/jquery-1.11.0.min.js"></script>
	<style type="text/css">
		td {
			padding: 5px;
		}
	</style>

	<center>
		<img src="uploads/logo.png" style="max-height : 60px;"><br>
		<h3 style="font-weight: 100;"><?php echo $system_name;?></h3>
		<?php echo get_phrase('tabulation_sheet');?><br>
		<?php echo get_phrase('class') . ' ' . $class_name;?><br>
		<?php echo $exam_name;?>
	</center>
	<table style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;" border="1">
            <thead>
                <tr>
                    <td style="text-align: center;">
                            <?php echo get_phrase('students');?> <i class="entypo-down-thin"></i> | <?php echo get_phrase('subjects');?> <i class="entypo-right-thin"></i>
                    </td>
                    <?php 
                          foreach($subjects as $row):
                    ?>
                            <td style="text-align: center;"><?php echo $row['name'];?></td>
                    <?php endforeach;?>
                    <td style="text-align: center;"><?php echo get_phrase('total');?></td>
                    <td style="text-align: center;"><?php echo get_phrase('average_grade_point');?></td>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach($students as $row):
            ?>
                <tr>
                    <td style="text-align: center;">
                            <?php echo $row['student_name'];?>
                    </td>
                    <?php
                    $total_marks = 0;
                    $total_grade_point = 0;  
                    foreach($subjects as $row2):
                    ?>
                        <td style="text-align: center;">
                                <?php 
                                       $obtained_mark_query = 	$row['obtained_mark_query'];
                                ?>
                        </td>
                    <?php endforeach;?>
                    <td style="text-align: center;"><?php echo $row['total_marks'];?></td>
                    <td style="text-align: center;">
                            <?php 
                             echo ($total_grade_point / $number_of_subjects);
                            ?>
                    </td>
                </tr>
           <?php endforeach;?>
        </tbody>
    </table>
</div>
