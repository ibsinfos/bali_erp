<table class="table table-bordered datatable" id="table_export">
     <thead>
    <tr>
        <th><?php echo get_phrase('subject');?></th>
        <th><?php echo get_phrase('marks');?></th>
        <th><?php echo get_phrase('credit');?></th>
        <th><?php echo get_phrase('grade_points');?></th>
        <th><?php echo get_phrase('GPA');?></th>
    </tr>
     </thead>
    <?php
    $total_credit=0;
    $total_weightage=0;
    foreach ($marks as $row): 
    ?>
    <tr>
        <td><?php echo $row['subject_name'];?></td>
        <td><?php echo $row['mark_obtained'];?></td>
        <td><?php echo $row['credit_hours'];?></td>
        <td><?php echo $gpa['name']; ?></td>
        <td><?php echo $row['weightage'];?></td>
     
    </tr>
    <?php endforeach;?>
    <tr>
        <td></td>
        <td><?php echo get_phrase('total_credit');?></td>
        <td><?php echo $total_credit;?></td>
        <td><?php echo get_phrase('total_weightage');?></td>
        <td><?php echo $total_weightage;?></td>
    </tr>
    
   
        
</table>
 <?php 
 if($total_credit!=0)
 {
 echo get_phrase("GPA"). "=". ($total_weightage/$total_credit);
 }?>