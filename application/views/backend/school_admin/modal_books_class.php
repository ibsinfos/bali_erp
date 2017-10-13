<table id="example" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
    <?php echo form_open(base_url() . 'index.php?school_admin/book/create' .$row['c'], array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data')); ?>
        <thead>
            <tr>
                <th>Sl. #</th>
                <th>Name</th>
                <th>E-mail</th>
                <th>Id Card #</th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 1; foreach ($parents as $row): ?>
            <tr>
                <td><?php echo $count++; ?></td>
                <td ><a href="" onclick="return check();"><?php echo "Mr. ".$row['father_name']; ?></a></td>
                <td><?php echo $row['email']; ?></td>              
                <td><?php echo $row['father_icard_no'];?></td>                
            </tr>            
        <?php endforeach; ?>    
        </tbody>
    <?php echo form_close(); ?>
</table>


<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable( {
        responsive: {
            details: false
        }
        } );
    }); 
</script>