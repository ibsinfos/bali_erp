<div class="profile-env"><?php if (!isset($data_not_found)) { ?>
    <header class="row">
        <?php 
            if($student_details->stud_image != "" && file_exists('uploads/student_image/'.$student_details->stud_image)) {
                $student_image  =   $student_details->stud_image;
            } else {
                $student_image  =   '';
            }
        ?>
        <div class="col-xs-3"><a href="#" class="profile-picture"><img src="<?php echo ($student_image != "" ? 'uploads/student_image/' . $student_image : 'uploads/user.jpg') ?>" class="img-responsive" /></a></div>

        <div class="col-sm-9"><ul class="profile-info-sections list-unstyled"><li style="padding:0px; margin:0px;"><div class="profile-name"><h3><?php echo $student_details->name . " " . $student_details->lname; ?></h3><p class="student-info"><?php echo get_phrase('Class') . ' : ' . $student_details->class_name . '<br>';
    echo get_phrase('Section') . ' : ' . $student_details->section_name; ?><br>
      <?php  echo get_phrase('blood_group') . ' : ' . $student_details->blood_group; ?><br>
      <?php echo get_phrase('allergies') . ' : ' . $student_details->allergies; ?> </p></div></li></ul></div>
    </header>

    <div class="row">
        <span id="delete_error" class="pull-right" style="color: red; size: 12px; margin-right: 20px; display: none;" ></span>
        <div class="col-sm-12">
            <table class= "custom_table table display" cellspacing="0" width="100%" id="example">
                <thead>
                <th><div>No.</div></th>
                <th><div>Medical Condition </div></th>
                <th><div>Date</div></th>
                <th><div>Description</div></th>
                <th><div>Options</div></th>
                </thead>
    <?php $c = 1;
    foreach ($medical_records as $med_rec): ?>
                        <tbody>
                        <td class="text-center"><?php echo $c++; ?></td>
                        <td><?php echo $med_rec->desease_title; ?></td>
                        <td><?php echo $med_rec->consult_date; ?></td>
                        <td><?php echo $med_rec->description; ?></td>
                        <td>
                            <div class="btn-group">
                                <a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url() . 'index.php?modal/view_medical_record/' . $med_rec->id; ?>');"><button type="button" title="View More" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View More"><i class="fa fa-eye"></i></button></a></li>
                                <!-- STUDENT DELETE LINK -->   
                                <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?Ajax_controller/delete_medical_record/<?php echo $med_rec->id; ?>/<?php echo $class_id; ?>/<?php echo $section_id; ?>');">
                                <!--<a href="javascript:void(0);" onclick="delete_medical_rec('<?php echo $med_rec->id; ?>');">--><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete" title="Delete" aria-describedby="tooltip526373"><i class="fa fa-trash-o"></i></button><div class="tooltip fade top" role="tooltip" id="tooltip526373" style="top: 80px; left: 1007.72px; display: block;"><div class="tooltip-arrow" style="left: 50%;"></div><div class="tooltip-inner">Delete</div></div></a>
                            </div>
                        </td>
                        </tbody>
    <?php endforeach; ?>
                </table>
            </div>
        </div><?php } else { ?>
        <header class="row"><div class="col-xs-3"><?php echo $data_not_found; ?></div></header><?php } ?>
</div>
<script type="text/javascript">
    function delete_medical_rec(record_id) {
        base_url = $("#base_url").val();
        if (confirm("Are you sure want to delete the record")) {
            $.ajax({
                url: base_url + "index.php?Ajax_controller/delete_medical_record/",
                data: {
                    record_id: record_id,
                },
                type: 'post',
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $("#modal_ajax").hide();
                        $(".modal-backdrop").hide();
                            var class_id    =   $("#class_id").val();
                            var section_id  =   $("#from_section_selector_holder").val();
                            var get_list    =   'get_list';
                            window.location.href = '<?php echo base_url(); ?>index.php?school_admin/clinical_records/deleted/'+class_id+'/'+section_id+'/'+get_list;                    } else {
                        $('#delete_error').html(response.message);
                        $('#delete_error').show();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    if (textStatus == "error") {
                        $('#delete_error').html(response.message);
                        $('#delete_error').show();
                    }
                }
            });
        } else {
            return false;
        }
    }
</script>
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