<?php 	
    if($month == 1) $m = 'January';
    else if($month == 2) $m='February';
    else if($month == 3) $m='March';
    else if($month == 4) $m='April';
    else if($month == 5) $m='May';
    else if($month == 6) $m='June';
    else if($month == 7) $m='July';
    else if($month == 8) $m='August';
    else if($month == 9) $m='Sepetember';
    else if($month == 10) $m='October';
    else if($month == 11) $m='November';
    else if($month == 12) $m='December';
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
        <h4><?php echo get_phrase('attendance_sheet_for_class_').$class_name.'Section '.$section_name.' for the month of '. $m ;?></h4>        
    </center>
        
    <table border="1" style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;">
        <thead>
            <tr>
                <td style="text-align: center;">
                <?php echo get_phrase('students'); ?> <i class="entypo-down-thin"></i> | <?php echo get_phrase('date'); ?> <i class="entypo-right-thin"></i>
                </td>
                <?php
                for ($i = 1; $i <= $days; $i++) { ?>
                <td style="text-align: center;"><?php echo $i; ?></td>
                 <?php } ?>
            </tr>
        </thead>
        <tbody>
           <?php echo $data; ?>
        </tbody>
    </table>
</div>
<br>
<br>
<button  onclick="window.print()" id = "with_print">Take a Print</button>
<style>
@media print {
    #with_print {
        display: none;
    }
}
</style>
