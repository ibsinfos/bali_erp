<div><?php if (!isset($data_not_found)) { ?>
    <header class="row">
        <?php 
        
        if($stud_image != "" && file_exists('uploads/student_image/'.$stud_image)) {
            $student_image  =   $stud_image;
        } else {
            $student_image  =   '';
        }
        
        ?>
        <div class="col-xs-3 stud-image-icon" ><img  style="width: 150px !important; height: 200px !important;" src="<?php echo ($student_image != "" ? 'uploads/student_image/' . $student_image : 'uploads/user.jpg'); ?>" /></div>

        <div class="col-sm-7">
            <ul class="list-unstyled">
                <li>
                    <div>
                        <h3><?php echo $student_name; ?></h3>
                        <p><?php echo get_phrase('Class') . ' : ' . $class . '<br>' . get_phrase('Section') . ' : ' . $section; ?></p>
                    </div>
                </li>
            </ul>
        </div>
        <div class="col-sm-2 text-right">
            <a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url() . 'index.php?modal/view_all_medical_record/' . $student_id; ?>');"><button class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Back"><i class="fa fa-reply"></i></button></a>
        </div>
    </header>

    <div class="row white-box">
        
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-hover manage-u-table">
                    <tr>
                        <td><?php echo get_phrase('student_name'); ?></td>
                        <td><b><?php echo $student_name; ?></b></td>
                    </tr><?php if ($blood_group != ''): ?>
                    <tr>
                        <td><?php echo get_phrase('Blood_Group'); ?></td>
                        <td><b><?php echo $blood_group; ?></b></td>
                    </tr><?php endif; ?>
                    <tr>
                        <td><?php echo get_phrase('Emergency_phone'); ?></td>
                        <td><b><?php echo $emergency_contact; ?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('consult_type'); ?></td>
                        <td><b><?php echo $consult_type; ?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('consulted_date'); ?></td>
                        <td><b><?php echo $consult_date; ?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('Disease'); ?></td>
                        <td><b><?php echo $desease; ?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('Description'); ?></td>
                        <td><b><?php echo $description; ?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('Diagnosis'); ?></td>
                        <td><b><?php echo $diagnosis; ?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('Prescriptions'); ?></td>
                        <td><b><?php echo $prescriptions; ?></b></td>
                    </tr>
                </table>
            </div>
        </div>
    </div><?php } else { ?>
    <header class="row">
        <div class="col-xs-3">
                <?php echo $data_not_found; ?>
            </div>
        </header><?php } ?>
</div>
<style type="text/css">
    .stud-image-icon {
        width: 150px !important;
        height: 200px !important;
    }
</style>
