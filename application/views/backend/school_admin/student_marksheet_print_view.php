<div id="print" onload="Popup(print);">

	<script src="assets/js/jquery-1.11.0.min.js"></script>
	<style type="text/css">
		td {
			padding: 5px;
		}
	</style>

	<center>
		<img src="uploads/<?php echo $system_logo;  ?>" style="max-height : 60px;"><br>
		<h3 style="font-weight: 100;"><?php echo $system_name;?></h3>
		<?php echo get_phrase('student_marksheet');?><br>
		<?php echo $student_name;?><br>
		<?php echo get_phrase('class') . ' ' . $class_name[0]->name;?><br>
                <?php echo get_phrase('section') . ' ' . $section_name;?><br>                
		<?php echo $exam_name;?>
	</center>
	<table style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;" border="1">
       <thead>
        <tr>
            <td style="text-align: center;">Subject</td>
            <td style="text-align: center;">Obtained marks</td>
            <td style="text-align: center;">Highest mark</td>
            <td style="text-align: center;">Grade</td>
            <td style="text-align: center;">Comment</td>
        </tr>
       </thead>
    <tbody>
        <?php 
            $total_marks = 0;
            $total_grade_point = 0;
            //pre($subjects);
            foreach ($subjects as $row3):
        ?>
            <tr>
                <td style="text-align: center;"><?php echo $row3['name'];?></td>
                <td style="text-align: center;">
                    <?php
                        if(isset($row3['marks'])){
                            foreach ($row3['marks'] as $row4) {
                                echo $row4['mark_obtained'];
                                $total_marks += $row4['mark_obtained'];
                            }
                        }
                    ?>
                </td>
                <td style="text-align: center;">
                    <?php
                        if(isset($row3['marks'])){
                            foreach ($row3['marks'] as $row4) {
                                echo $row4['mark_total'];
                               
                            }
                        }
                    ?>
                </td>
                <td style="text-align: center;">
                    <?php echo @$row3['grade_name']; ?>
                </td>
                <td style="text-align: center;">
                    <?php echo @$row3['comment'];?>
                </td>
            </tr>
        <?php endforeach;?>
    </tbody>
   </table>

<br>

    <center>
	   <?php echo get_phrase('total_marks');?> : <?php echo $total_marks;?>
	   <br>
	   <?php echo get_phrase('average_grade_point');?> : 
	        <?php echo $average_grade_point;
	        ?>
	</center>

</div>


<script type="text/javascript">

	window.onload = printDiv();
	
    function printDiv() {
	
    var w = window.open();
w.document.write($('#print').html()); //only part of the page to print, using jquery
w.document.close(); //this seems to be the thing doing the trick
w.focus();
w.print();
w.close();
window.close();
window.history.back();  
    }
</script>