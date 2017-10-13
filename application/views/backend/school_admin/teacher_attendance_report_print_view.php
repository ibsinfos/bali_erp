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
<div id ="with_or_without_print"><div style="height: 80px;"></div>
    <div>
        <div class="text-center">
            <img src="uploads/logo.png" style="max-height : 60px;"><br>
        </div>
        <div class="text-center">
            <h3 style="font-weight: 100;"><b><?php echo $system_name;?></b></h3>
        </div>
        <div class="text-center">
            <h4><?php echo get_phrase('attendance_sheet')." for ".$m;?></h4>
        </div>
    </div>
        
    <table border="1" style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;">
        <thead>
            <tr>
                <td style="text-align: center;">
                <?php echo get_phrase('teacher'); ?> <i class="entypo-down-thin"></i> | <?php echo get_phrase('date'); ?> <i class="entypo-right-thin"></i>
                                    </td>
                <?php
                $year = explode('-', $running_year);
                $days = cal_days_in_month(CAL_GREGORIAN, $month, $year[0]);
                for ($i = 1; $i <= $days; $i++) {
                    ?>
                <td style="text-align: center;"><?php echo $i; ?></td>
            <?php } ?>
                <td class="text-center"><?php echo get_phrase("percent");?></td>
            </tr>
        </thead>

        <tbody>
            <?php 
            //pre($students) ; die();          
            foreach ($teachers as $row): //pre($row);die;
                $present=0;
                if(empty($teachers)) continue; ?>
                <tr>
                    <td class="text-center"><?php echo $row['name']; ?></td>
                    <?php
                    $status = 0;
                    for ($i = 1; $i <= $days; $i++) {
                        $timestamp      =   strtotime($i . '-' . $month . '-' . $year[0]);
                       // $attendance     =   $this->db->get_where('attendance', array('section_id' => $section_id, 'class_id' => $class_id, 'year' => $running_year, 'timestamp' => $timestamp, 'student_id' => $row['student_id']))->result_array();
                        $status         =   "";
                        //pre($row['attendance']);
                        if(array_key_exists('atten', $row)){
                            foreach ($row['atten'] as $row1):
                                $month_dummy = date('j', $row1['timestamp']);
                                if ($i == $month_dummy){
                                    $status = $row1['status'];
                                }   
                            endforeach;
                        }?>
                    <td class="text-center" style="font-weight: bold;">
                        <?php if ($status == 1) {
                            $present=$present+1;
                        ?><i style="color: #00a651;">P</i>
                        <?php } else if ($status == 2) { ?><i style="color: #ee4749;">A</i>
                        <?php }else{ ?> &nbsp; <?php } ?>            
                    </td>
                    <?php } ?>
                    <?php $percentage= ($present/$days)*100; ?>
                    <td><?php echo round($percentage, 2)."%";?></td>
                    <?php endforeach; ?>
                </tr>
            <?php ?>
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


