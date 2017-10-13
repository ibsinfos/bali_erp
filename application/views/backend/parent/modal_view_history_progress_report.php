<?php
if (!empty($progress_report)){ ?>
    <div class="row">
        <div class="col-md-12 white-box">                              
                    <table class= "custom_table table display" cellspacing="0" width="100%" id="example">
                     <thead>
                             <tr>
                            <th><div>Teacher Name</div></th>
                            <th><div>Sub Category</div></th>
                            <th><div>Ex</div></th>
                            <th><div>Exp</div></th>
                            <th><div>Em</div></th>
                            <th><div>Comment</div></th>
                            <th><div>Date</div></th>
                             </tr>
                    </thead>
                        <?php foreach ($progress_report as $row): ?>
                             <tbody>
                        <tr>
                   
                            <td><?php echo $row['name'];  ?></td>
                            <td><?php echo $row['description'];  ?></td>
                            <td><?php if($row['exceeding_level']==1){ ?><input type="checkbox" checked='checked' disabled>                            
                            <?php }else{ ?><input type="checkbox" disabled> <?php } ?>
                            </td>
                            <td><?php if($row['expected_level']==1){ ?><input type="checkbox" checked='checked' disabled>                            
                            <?php }else{ ?><input type="checkbox" disabled> <?php } ?></td>
                            <td><?php if($row['emerging_level']==1){ ?><input type="checkbox" checked='checked' disabled>                            
                            <?php }else{ ?><input type="checkbox" disabled> <?php } ?></td>
                            <td><?php echo $row['comment'];  ?></td>
                            <td><?php echo $row['time_stamp'];  ?></td>
                        </tr>
                            </tbody>
                        <?php endforeach; ?>
                    </table>
        </div>
    </div>
    
<?php } else{
    echo "No Data Available";
}
?>
<script>
$('#example').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
            'copy', 'excel', 'pdf', 'print'
        ]
    });
</script>