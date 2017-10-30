<?php
    if (!empty($parent_record))
    {
        foreach($parent_record as $row){
    ?>
        <div class="profile-env">
            <header class="row popup_view_header">                
                <div class="col-sm-12">
                    <ul class="profile-info-sections popup_view_ul list-inline">
                        <li class="profile-name">
                        <?php foreach($student_name as $student)
    {echo '<span class="badge badge-purple badge-stu-name m-b-10 m-r-10">'.$student['name'] ." ". $student['mname'] ." ".$student['lname']." (".$student['class_name'].')</span>'.''; }?>                     
                        </li>
                    </ul>
                </div>
            </header>
            <section class="profile-info-tabs">
                <div class="row">
                    <div class="col-md-12">
        
                        <table class="table table-bordered">
                            <tr>
                                <td><?php echo get_phrase("father's_name"); ?></td>
                                <td><b><?php echo $row['father_name'] ." ". $row['father_mname'] ." ". $row['father_lname']; ?></b></td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase("mother's_name"); ?></td>
                                <td><b><?php echo $row['mother_name'] ." ". $row['mother_mname']." ". $row['mother_lname']; ?></b></td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase("father's_profession"); ?></td>
                                <td><b><?php echo $row['father_profession'];?></b></td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase("mother's_profession"); ?></td>
                                <td><b><?php echo $row['mother_profession'];?></b></td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase("father's_qualification"); ?></td>
                                <td><b><?php echo $row['father_qualification'];?></b></td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase("mother's_qualification"); ?></td>
                                <td><b><?php echo $row['mother_quaification'];?></b></td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase("father's_passport_#"); ?></td>
                                <td><b><?php echo $row['father_passport_number'];?></b></td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase("father's_passport_#"); ?></td>
                                <td><b><?php echo $row['mother_passport_number'];?></b></td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase("father_'s_id"); ?></td>
                                <td><b><?php echo $row['father_icard_type']." : ".$row['father_icard_no']; ?></b></td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase("mother_'s_id"); ?></td>
                                <td><b><?php echo $row['mother_icard_type']." : ".$row['mother_icard_no']; ?></b></td>
                            </tr>
                                                     
                             <tr>
                                <td><?php echo get_phrase('address'); ?></td>
                                <td><b><?php echo ucwords($row['address'].", ".$row['city'].", "
                                        .$row['state_name'].", ".$row['country_name']).", ".$row['zip_code']; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase('phone'); ?></td>
                                <td><b><?php echo $row['cell_phone'].", ".$row['home_phone'].", ".$row['work_phone'];?></b>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>		
            </section>
        </div>

    <?php } } ?>
        
    
<script type="text/javascript">
$('#modal_ajax').on('shown.bs.modal', function (e) {
    $('#modal_ajax #myModalLabel').html('<?php echo $page_title; ?>');
})
</script>