
    <div class="row">
        <div class="col-md-12 white-box">                              
                    <table class= "custom_table table display" cellspacing="0" width="100%" id="example">
                     <thead>
                             <tr>
                            <th><div>Rating</div></th>
                            <th><div>Comment</div></th>
                            <th><div>Date</div></th>
                             </tr>
                    </thead>
                    <?php
if (!empty($details)){ ?>
                        <?php foreach ($details as $row): ?>
                             <tbody>
                        <tr>                 
                            <td><?php
                                 for($i=0;$i<=$row['rate'];$i++){echo  '
                            <img onclick="javascript:rating('.$i.',\''.$row['student_id'].'student\')" name="'.$row['student_id'].'student-'.$i.'" src=" '.base_url() . 'assets/images/filled_star'.$i.'.png" alt="star View" >
                                ';
                                                              
                                }
                                for($i=$row['rate']+1;$i<5;$i++){echo '
                            <img onclick="javascript:rating('.$i.',\''.$row['student_id'].'student\')" name="'.$row['student_id'].'student-'.$i.'" src=" '.base_url() . 'assets/images/Blank_star.png" alt="star View" >
                            ';
                                 }
                                 ?>                                
                            </td>
                            <td><?php echo $row['comment'];  ?></td>
                            <td><?php echo $row['timestamp'];  ?></td>
                        </tr>
                            </tbody>
                        <?php endforeach; ?>
                            <?php } ?>
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