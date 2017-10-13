<?php
    
?>


<div id="print">

	<script src="assets/js/jquery-1.11.0.min.js"></script>
	<style type="text/css">
		td {
			padding: 5px;
		}
	</style>

	<center>
		<img src="uploads/logo.png" style="max-height : 60px;"><br>
		<h3 style="font-weight: 100;"><?php echo $system_name;?></h3>
		<?php echo get_phrase('class_routine');?><br>
		<?php echo get_phrase('class') . ' ' . $class_name;?> : <?php echo get_phrase('section');?> <?php echo $section_name;?><br>
	</center>
    <br>
	<table style="width:100%; border-collapse:collapse;border: 1px solid #eee; margin-top: 10px;" border="1">
        <tbody>
            <?php   
                for($d=1;$d<=7;$d++):
                ?>
                <tr>
                    <td width="100"><?php echo strtoupper($day_arr[$d]);?></td>
                    
                            <td align="left">
                        <?php      foreach($routines[$d] as $row):    ?>
                            <div style="float:left; padding:8px; margin:5px; background-color:#ccc;">
                                <?php echo $row['subject_name']; ?>
                                <?php
                                    if ($row['time_start_min'] == 0 && $row['time_end_min'] == 0) 
                                        echo '('.$row['time_start'].'-'.$row['time_end'].')';
                                    if ($row['time_start_min'] != 0 || $row['time_end_min'] != 0)
                                        echo '('.$row['time_start'].':'.$row['time_start_min'].'-'.$row['time_end'].':'.$row['time_end_min'].')';
                                ?>
                            </div>
                        <?php endforeach;?>
                            </td>

                    
                </tr>
                <?php endfor;?>
        </tbody>
   </table>
<br>
</div>
<button  onclick="window.print()" id = "with_print">Take a Print</button>
<style>
@media print {
    #with_print {
        display: none;
    }
}
</style>
