<?php echo form_open();?>
<table id="example23" class="table table-bordered">
        <thead>
            <tr>
                <th>Select</th>
                <th>Name</th>
                <th>E-mail</th>
                <th>Address</th>
                <th>Id </th>             
            </tr>
        </thead>
       
        <tbody>           
            <?php 
           
            $count = 1; foreach ($parents as $row): ?>
            <tr>
                <td><input id="parent_id" class= "radio" type="radio" name="parent_id" onclick="return check(this);" value="<?php echo $row['email'] ?>"></td>
                <td><?php echo "Mr. ".$row['father_name']; ?></td>
                <td><?php echo $row['email']; ?></td>                
                <td><?php echo $row['address'].", ".$row['city'].", ".$row['state'].", ".$row['country'].", ".$row['zip_code']; ?></td>                
                <td><?php echo $row['father_icard_no'];?></td>                
            </tr>            
            <?php endforeach; ?>    
        </tbody>    
</table>

<?php echo form_close();?>

<script type="text/javascript">  
$('#example23').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
            'excel', 'pdf', 'print'
        ]
    });       
function check(){    
    var parent_email = $("input[name='parent_id']:checked").val();    
    $("#parent").val(parent_email);
    $("#parent_email").val(parent_email);
    $.ajax({
        type: "POST",
        //url: "index.php?school_admin/student_add",
        data: { parent_email : 'parent_email'},            
        dataType: "html",
        success: function(data){         
            $("#parent").val(parent_email);
            $("#modal_ajax").modal('hide');            
        },
        error: function(data){
            console.log('error');
        }
    });        
}
</script>

