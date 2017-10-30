<div class="profile-env">
    <?php if(!isset($data_not_found)) { 
        if($student_details->stud_image !='' and file_exists('uploads/student_image/'.$student_details->stud_image)){
            $image_url = base_url().'uploads/student_image/'.$student_details->stud_image;
        }else{
            $image_url = base_url().'uploads/user.png'; 
        }
        ?>
    
        <header class="row">
            <div class="col-xs-3 p-l-20">           
                <img src="<?php echo $image_url;?>" 
                    height="100px" /> 
            </div>
            <div class="col-sm-9 m-t-20">
                <h3><?php echo $name; ?></h3>
            </div>
        </header>

        <section class="profile-info-tabs">
            <div class="row p-20">
                <table class="table table-bordered table_row_hover">
                    <tr>
                        <td>
                            <?php echo get_phrase('Class'); ?>
                        </td>
                        <td><b><?php echo $class; ?></b></td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo get_phrase('Section'); ?>
                        </td>
                        <td><b><?php echo $section; ?></b></td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo get_phrase('Student_ID'); ?>
                        </td>
                        <td><b><?php echo $student_id;?></b></td>
                    </tr>
                    <?php if ($blood_group != ''): ?>
                        <tr>
                            <td>
                                <?php echo get_phrase('Blood_Group'); ?>
                            </td>
                            <td><b><?php echo $blood_group;?></b></td>
                        </tr>
                        <?php endif; ?>
                            <tr>
                                <td>
                                    <?php echo get_phrase('Emergency_phone'); ?>
                                </td>
                                <td><b><?php echo $emergency_contact; ?></b></td>
                            </tr>
                            <?php if ($academic_year != ''): ?>
                                <tr>
                                    <td>
                                        <?php echo get_phrase('Academic_year'); ?>
                                    </td>
                                    <td><b><?php echo $academic_year; ?></b></td>
                                </tr>
                                <?php endif; ?>
                                    <tr>
                                        <td>
                                            <?php echo get_phrase('Class'); ?>
                                        </td>
                                        <td><b><?php echo $class; ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo get_phrase('Section'); ?>
                                        </td>
                                        <td><b><?php echo $section; ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo get_phrase('Card_number'); ?>
                                        </td>
                                        <td>
                                            <input type="text" student_id="<?php echo $student_id;?>" name="rfid_card_number" id="rfid_card_number" class="form-control" size="6" value="<?php echo ($card_number !=" ")?$card_number:" "; ?>" placeholder="<?php echo get_phrase('r_f_i_d_card_number');?>" title="<?php echo get_phrase('r_f_i_d_card_number');?>">
                                            <span class="rfidError mandatory"></span>
                                        </td>
                                    </tr>
                </table>
                <span>
                    <center>
                    <input type="button" value="<?php echo ($card_number !="")?"Update":"Add"; ?>" name="update_rfid" id="update_rfid" class="fcbtn btn btn-danger btn-outline btn-1d">
                    </center>
                </span>
            </div>
        </section>
        <?php } else { ?>
            <header class="row">
                <div class="col-xs-3">
                    <?php echo $data_not_found; ?>
                </div>
            </header>
            <?php } ?>
</div>
<script type="text/javascript">
    $('#update_rfid').click(function() {
        base_url = $("#base_url").val();
        if ($("#rfid_card_number").val() != "") {
            student_id = $("#rfid_card_number").attr('student_id');
            rfid = $("#rfid_card_number").val();
 
            $.ajax({
                url: "<?php echo base_url(); ?>index.php?ajax_controller/update_rfid/",
                data: {
                    student_id: student_id,
                    rfid: rfid
                },
                type: 'post',
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
//                        $(".rfidError").html(response.message).css({
//                            color: 'green'
//                        });
                      window.location = "<?php echo base_url(); ?>index.php?school_admin/map_students_id_after_referesh/<?php echo $class_id; ?>" 
                    } else {
                        $(".rfidError").html(response.message).css({
                            color: 'red'
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (textStatus == "error") {
                        $(".rfidError").html("Error In Connection").css({
                            color: 'red'
                        });
                    }
                }
            });
        } else {
            $(".rfidError").html("Please Enter RFID").css({
                color: 'red'
            });
        }
    });
</script>