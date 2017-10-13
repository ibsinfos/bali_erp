<div class="col-md-12 white-box">
<?php if (!empty($details)) {
    $json_data = json_encode($student);
    ?>
    
    <?php echo form_open(base_url() . 'index.php?school_admin/exam_marks_sms/send_sms'); ?>
    <button type="button" class="selectall_href_123" style="display:none;">Select All</button>
        <input type="hidden" value="<?php echo $exam_id; ?>" name="exam_id" />
        <input type="hidden" value="<?php echo $class_id; ?>" name="class_id" />
        <input type="hidden" value="<?php echo $section_id; ?>" name="section_id" />
        <input type="hidden" value="<?php echo $user; ?>" name="receiver" />

        <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th><div>No.</div></th>
                        <th><div><?php echo get_phrase('name'); ?></div></th>
                        <th><div><?php echo get_phrase('phone_no.'); ?></div></th>
                        <th class="p-l-10">
                            <div><input type="checkbox" class="js-switch selected_student_checkbox" id="checkAll"/><?php echo get_phrase(''); ?></div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    foreach ($details as $row) {
                        ?>   
                        <tr>   

                            <td><?php echo $count++; ?></td>               
                            <td><?php
                                if ($user == 'student') {
                                    echo $row['name'].' '. $row['lname'];
                                } else {
                                    echo $row['father_name'].' '.$row['father_lname'];
                                }
                                ?></td>           
                            <td><?php
                                if ($user == 'parent') {
                                    echo $row['cell_phone'];
                                } else {
                                    echo $row['phone'];
                                }
                                ?></td> 
                            <td>
                                <div class="switchery-demo m-b-30 tooltip-danger" data-toggle="tooltip" data-placement="left" title="" >
                                   <input type="checkbox" name ="selected[]" class=" selected_student_checkbox" data-color="#6164c1"/> 
                                </div>
                            </td> 
                    </tr>
    <?php } ?>
                </tbody>
            </table>

    <?php } ?>
        
        
  
	<div class="text-right col-xs-12 p-t-20">
	    <button type="submit"  class="fcbtn btn btn-danger btn-outline btn-1d" id="sa-success"><?php echo get_phrase('submit'); ?></button>
	</div>
<?php echo form_close(); ?>          
</div>
    
    <script type="text/javascript">
    (function() {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
            new CBPFWTabs(el);
        });
    })();


$('#example23').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
            'copy', 'excel', 'pdf', 'print'
        ]
    });
    
    /*$('.selectall_href_123').toggle(
        function() {
            $('#example23 .selected_student_checkbox').prop('checked', true);
        },
        function() {
            $('#example23 .selected_student_checkbox').prop('checked', false);
        }
    );*/
    jQuery("body").delegate('#checkAll','change',function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });
    
    /*$("#checkAll").change('on','body',function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });*/

</script>


    
