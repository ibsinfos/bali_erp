<div id="print">
<?php
    $class_name    =   $student_details[0]['class_name'];
    $section_name  =   $student_details[0]['section_name'];
?>

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
            <?php echo get_phrase('class') . ' ' . @$class_name;?> : <?php echo get_phrase('section');?> <?php echo $section_name;?><br>
    </center>
    <br>
    <table style="width:100%; border-collapse:collapse;border: 1px solid #eee; margin-top: 10px;" border="1">
        <tbody>
            <?php 
                foreach($class_routine_data AS $k =>$routin_details):?>
                <tr>
                    <td width="100"><?php echo strtoupper($k); ?></td>
                    
                            <td align="left">
                        <?php
                        if(!empty($routin_details)){
                        foreach ($routin_details as $row=>$val):
                        ?>
                            <div style="float:left; padding:8px; margin:5px; background-color:#ccc;">
                                <?php echo $val['subject_name'];?>
                                <?php
                                    if ($val['time_start_min'] == 0 && $val['time_end_min'] == 0) 
                                        echo '('.$val['time_start'].'-'.$val['time_end'].')';
                                    if ($val['time_start_min'] != 0 || $val['time_end_min'] != 0)
                                        echo '('.$val['time_start'].':'.$val['time_start_min'].'-'.$val['time_end'].':'.$val['time_end_min'].')';
                                ?>
                            </div>
                        <?php endforeach;
                        }else{echo '&nbsp;';}?>
                            </td>

                    
                </tr>
                <?php endforeach;?>
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
