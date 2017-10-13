

<div class="modal-body"> 
    <div class="text-center">
    <h3><b><?php echo get_phrase('class_teacher_details'); ?></b></h3>
    </div>
    <from class="form-horizontal form-material">       
        <div class="form-group">            
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
                <?php $count = 1; foreach ($teacher_name as $row): ?>
                    <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row['teacher_name'];?></td>
                        <td><?php echo $row['email'];?></td>
                        <td><?php echo $row['cell_phone']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>               
    </from>
    <div class="text-center">
    <h3><b><?php echo get_phrase('subject_wise_teacher_details'); ?></b></h3>
    </div>
    <from class="form-horizontal form-material">       
        <div class="form-group">            
            <table class="table table-bordered datatable" id="table_export_list">
            <thead>
                <tr>
                    <th width="50"><div><?php echo get_phrase('no'); ?></div></th>
                    <th><div><?php echo get_phrase('name'); ?></div></th>
                    <th><div><?php echo get_phrase('subject'); ?></div></th>
                    <th><div><?php echo get_phrase('email'); ?></div></th>
                    <th><div><?php echo get_phrase('phone'); ?></div></th> 
                </tr>
            </thead>
            <tbody>
                <?php $count = 1; foreach ($subjects as $row): ?>
                    <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row['teacher_name'];?></td>
                        <td><?php echo $row['name'];?></td>
                        <td><?php echo $row['email'];?></td>
                        <td><?php echo $row['cell_phone']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>               
    </from>
</div>

