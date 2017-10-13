<div><?php if(!isset($data_not_found)) { ?>
    <header class="row">
        <div class="col-xs-3">
                    <?php 
        if($stud_image != "" && file_exists('uploads/student_image/'.$stud_image)) {
            $student_image  =   $stud_image;
        } else {
            $student_image  =   '';
        }
        ?>
            <a href="#"><img style="width: 150px !important; height: 200px !important;" src="<?php echo ($student_image != "" ?'uploads/student_image/'.$student_image:'uploads/user.jpg')?>"/></a>
        </div>

        <div class="col-sm-9">
            <ul>
                <li>
                    <div>
                        <h3><?php echo $student_name; ?></h3>
                        <p><?php echo get_phrase('Class').' : '.$class.'<br>'.get_phrase('Section').' : '.$section; ?></p>
                    </div>
                </li>
            </ul>
        </div>
    </header>

    <div class="row">        
        <div class="col-sm-12">
            <div class="text-right"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url().'index.php?modal/view_all_medical_record/'.$student_id; ?>');" class="fcbtn btn btn-danger btn-outline btn-1d">Back</a></div>
            <div class="table-responsive">
                <table class="table table-hover manage-u-table">
                    <tr>
                        <td><?php echo get_phrase('student_name'); ?></td>
                        <td><b><?php echo $student_name;?></b></td>
                    </tr><?php if ($blood_group != ''): ?>

                    <tr>
                        <td><?php echo get_phrase('Blood_Group'); ?></td>
                        <td><b><?php echo $blood_group;?></b></td>
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
                        <td><?php echo get_phrase('Desease'); ?></td>
                        <td><b><?php echo $desease; ?></b></td>
                    </tr>

                    <tr>
                        <td><?php echo get_phrase('Discription'); ?></td>
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
    <header class="row"><div class="col-xs-3"><?php echo $data_not_found; ?></div></header><?php } ?>
</div>