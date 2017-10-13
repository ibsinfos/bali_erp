<?php if (!empty($subjects)){ ?>
<div class="modal-body"> 
    <div class="text-center">
<!--    <h3><b><?php echo get_phrase('teacher_details'); ?></b></h3>-->
    <h4><b><?php echo get_phrase('class_teacher')." : ".$class_teacher_name; ?></b></h4>
    </div>
    
    <from class="form-horizontal form-material">       
        <div class="form-group">  
            <div class="text-center">
                <h3><b><?php echo get_phrase('subject_teacher_details'); ?></b></h3>
            </div>
            <table class="table table-bordered datatable" id="table_export_list">
            <thead>
                <tr>
                    <th width="50"><div><?php echo get_phrase('no'); ?></div></th>
                    <th><div><?php echo get_phrase('name'); ?></div></th>
                    <th><div><?php echo get_phrase('email'); ?></div></th>
                    <th><div><?php echo get_phrase('phone'); ?></div></th> 
                </tr>
            </thead>
            <tbody>
                <?php //echo '<pre>'; print_r($subjects); ?>
                <?php $count = 1; foreach ($subjects as $row): ?>
                    <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row['teacher_name'] ." ". ($row['middle_name']!=''?$row['middle_name']:'') ." ". $row['last_name'];?></td>
                        <td><?php echo $row['email'];?></td>
                        <td><?php echo $row['cell_phone']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>               
    </from>
</div>
<?php } else {  echo "No Data Available" ; }?>
