<div class="row">
    <div class="col-md-12 white-box">
        <table class= "custom_table table display" cellspacing="0" width="100%" id="example">
            <thead>
                <tr>
                    <td><div>S. No.</div></td>
                    <td><div><?php echo get_phrase('name');?></div></td>
                    <td><div><?php echo get_phrase('class');?></div></td>
                    <td><div><?php echo get_phrase('section');?></div></td>
                    <td><div><?php echo get_phrase('contact_#');?></div></td>
                </tr>
            </thead>
            <tbody>
            <?php if(!empty($students)){ 
                $count = 1;
                
                foreach($students as $row):
            ?>
                <tr>
                    <td><?php echo $count++;?></td>
                    <td><?php echo $row['student_name'];?></td>
                    <td><?php echo $row['cls_name'];?></td>
                    <td><?php echo $row['section'];?></td>
                    <td><?php echo $row['phone'];?></td>
                </tr>
                <?php endforeach;?>
                
            </tbody>
        </table>
    </div>
</div>
<?php } ?>
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