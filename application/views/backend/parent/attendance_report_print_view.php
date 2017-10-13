<?php 
	$month_arr    =   array('1' => 'January', '2'=>'February', '3'=>'March', '4'=>'April', '5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December'); 
        
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
		<?php echo get_phrase('attendance_sheet');?><br>
		<?php echo get_phrase('class') . ' ' . $class_name;?><br>
		<?php echo get_phrase('section').' '.$section_name;?><br>
                <?php echo $month_arr[$month].' '.get_phrase('month');?>
		
	</center>
        
          <table border="1" style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;">
                <thead>
                    <tr>
                        <td style="text-align: center;">
    <?php echo get_phrase('students'); ?> <i class="entypo-down-thin"></i> | <?php echo get_phrase('date'); ?> <i class="entypo-right-thin"></i>
                        </td>
    <?php
    for ($i = 1; $i <= $days; $i++) {
        ?>
                            <td style="text-align: center;"><?php echo $i; ?></td>
                    <?php } ?>

                    </tr>
                </thead>

                <tbody>
                        <tr>
                            <td style="text-align: center;">
                            <?php echo $student_name; ?>
                            </td>
                            <?php
                            for ($i = 1; $i <= $days; $i++) {
                                
                                ?>
                                <td style="text-align: center;font-weight: bold;">
                            <?php 
                            echo $studentAttendanceArr[$i];?>

        <?php } ?>
    <?php //endforeach; ?>

                    </tr>

    <?php ?>

                </tbody>
            </table>
</div>



<script type="text/javascript">

	jQuery(document).ready(function($)
	{
		var elem = $('#print');
		PrintElem(elem);
		Popup(data);

	});

    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data) 
    {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title></title>');
        //mywindow.document.write('<link rel="stylesheet" href="assets/css/print.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        //mywindow.document.write('<style>.print{border : 1px;}</style>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();
        window.history.back(); 
        return true;
    }
</script>