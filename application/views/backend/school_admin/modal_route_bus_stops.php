

<div class="row">
    <div class="col-md-12 white-box">
        <table class= "custom_table table display" cellspacing="0" width="100%" id="example">
            <thead>
                <tr>
                    <td><div>S. No.</div></td>
                    <td><div><?php echo get_phrase('bus_stop_from');?></div></td>
                    <td><div><?php echo get_phrase('bus_stop_to');?></div></td>
                    <!--<td><div><?php // echo get_phrase('no_of_stops');?></div></td>-->
                    <td><div><?php echo get_phrase('route_fare');?></div></td>
                </tr>
            </thead>
            <tbody>
            <?php  if(!empty($bus_stops)){
                $count = 1;
                
                foreach($bus_stops as $row):
            ?>
                <tr>
                    <td><?php echo $count++;?></td>
                    <td><?php echo $row['route_from'];?></td>
                    <td><?php echo $row['route_to'];?></td>
                    <!--<td><?php // echo $row['no_of_stops'];?></td>-->
                    <td><?php echo $row['route_fare'];?></td>
                </tr>
            <?php endforeach; }?>
                
            </tbody>
        </table>
    </div>
</div>
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