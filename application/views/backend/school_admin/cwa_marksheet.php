<table class="table table-hover manage-u-table">
    <thead>
        <tr>
            <th><?php echo get_phrase('subject');?></th>
            <th><?php echo get_phrase('marks');?></th>
            <th><?php echo get_phrase('credit');?></th>
            <!-- <th><?php echo get_phrase('grade');?></th> -->
            <th><?php echo get_phrase('weighted_marks');?></th>
        </tr>
    </thead>
<?php //pre($marks); die(); ?>
<?php if(count($marks)){
        $total_credit=0; 
        $total_weightage=0; 
        //$grade=0; 
        foreach ($marks as $row): 
            $total_credit=$total_credit+$row['credit_hours']; 
            $weightage= $row['mark_obtained']*$row['credit_hours']; 
            $total_weightage=$total_weightage+$weightage; 
            //$grade=$row['mark_obtained']/$weightage; 
?>
    <tbody>
        <tr>
            <td><?php echo $row['subject_name'];?></td>
            <td><?php echo $row['mark_obtained'];?></td>
            <td><?php echo $row['credit_hours'];?></td>
              <!-- <td><?php echo $grade;?></td> -->
            <td><?php echo $weightage?></td>
        </tr><?php endforeach; }?>
        <tr>
            <td></td>
            <td><?php echo get_phrase('total_credit');?></td>
            <td><?php echo $total_credit;?></td>
            <td><?php echo get_phrase('total_weightage');?></td>
            <td><?php echo $total_weightage;?></td>
        </tr>
    </tbody>
</table>
<?php if($total_credit!=0){ echo get_phrase("Weighted_average"). "=". ($total_weightage/$total_credit);
 }?>
