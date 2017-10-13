<div class="col-md-12 white-box">
<div class="text-center">
   <h3><b> <?php echo get_phrase('students_of_class_'.$class_name); ?></b></h3>
</div>
    <table class="display nowrap" cellspacing="0" width="100%" id="example">
        <thead>
            <tr>
<!--                <th class="text-center">
                    <div>
                    <input type="checkbox" class="js-switch selected_student_checkbox" id="checkAll" name="select_all" />
                    </div>
                </th>-->
                <th class="text-center">
                </th>
                <th class="text-center">
                     <div>
                    <?php echo get_phrase('name'); ?>
                          </div>
                </th>
                <th class="text-center">
                     <div>
                    <?php echo get_phrase('roll'); ?>
                          </div>
                </th>
                <th>
                    <div>
                        <?php echo get_phrase('Hostel'); ?>
                    </div>
                </th>
                <th>
                    <div>
                        <?php echo get_phrase('Transport'); ?>
                    </div>
                </th>
                <th class="text-center">
                     <div>
                    <?php echo get_phrase('options'); ?>
                          </div>
                </th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach ($students as $row):
                if(!in_array( $row['student_id'] , $configured_stud_list) && $row['isActive'] != 0) {
                    /*$query = $this->db->get_where('enroll', array(
                            'student_id' => $row['student_id'],
                            'year' => $running_year
                        ));*/
                    ?>
                <tr>
                    <td class="text-center">
                       
                        <input type="checkbox" name="student_ids[]" value="<?php echo $row['student_id']; ?>">
                        <input type="hidden" name="transp_fee_id[<?php echo $row['student_id'];?>]" id="transp_fee_id_<?php echo $row['student_id'];?>" value="">
                        <input type="hidden" name="hostel_fee_id[<?php echo $row['student_id'];?>]" id="hostel_fee_id_<?php echo $row['student_id'];?>" value="">
                    </td>

                    <td class="text-center">
                        <?php 
                        echo $row['name']; ?>
                    </td>
                    <td class="text-center">
                        <?php echo $row['enroll_code']; ?>
                    </td>
                    <td>
                        <select name="dormitory_id[]" id="dormitory_id_<?php echo $row['student_id']; ?>" student_id="<?php echo $row['student_id']; ?>" class="dormitory_select selectpicker" data-style="form-control" data-live-search="true">
                            <option value="">
                                <?php echo get_phrase('no_dormitory'); ?>
                            </option>
                            <?php
                            foreach ($dormitories as $host):
                                ?>
                                <option value="<?php echo $host['dormitory_id']; ?>">
                                    <?php echo $host['name']; ?>
                                </option>

                                <?php endforeach; ?>
                        </select>
                        <br>
                        <select name="room_id[]" id="room_id_<?php echo $row['student_id']; ?>" student_id="<?php echo $row['student_id']; ?>" class="room_select selectpicker" data-style="form-control" data-live-search="true">
                            <option value="">
                                <?php echo get_phrase('no_hostel_selected'); ?>
                            </option>
                        </select>
                        <br>
                        <select name="hostel_fee_inst[<?php echo $row['student_id'];?>]" id="hostel_fee_inst_<?php echo $row['student_id'];?>" class="selectpicker" data-style="form-control" data-live-search="true">
                            <?php if($fee_installment['hostel_fee_inst']) { ?>
                                <option value=""><?php echo get_phrase('select_hostel_fee_instalment'); ?></option>
                            <?php foreach ($fee_installment['hostel_fee_inst'] as $fee_inst): ?>
                                <option value="<?php echo $fee_inst['id']; ?>"><?php echo $fee_inst['installment_name']."(".$fee_inst['no_of_installment'].")"; ?></option>
                            <?php endforeach; } else { ?>
                                <option value=""><?php echo get_phrase('hostel_fee_instalment_not_set');?></option>
                            <?php }  ?>
                        </select>
                    </td>
                    <td>
                        <select name="route_id[]" id="route_id_<?php echo $row['student_id']; ?>" student_id="<?php echo $row['student_id']; ?>" class="transport_select selectpicker" data-style="form-control" data-live-search="true">
                            <option value="">
                                <?php echo get_phrase('no_transport_service'); ?>
                            </option>
                            <?php
                            foreach ($transports as $trans):
                                ?>
                                <option value="<?php echo $trans['transport_id']; ?>">
                                    <?php echo $trans['route_name']; ?>
                                </option>
                                <?php endforeach; ?>
                        </select>
                        <br>
                        <select name="transport_id[]" id="transport_id_<?php echo $row['student_id']; ?>" student_id="<?php echo $row['student_id']; ?>" class="route_select selectpicker" data-style="form-control" data-live-search="true">
                            <option value="">
                                <?php echo get_phrase('select_route'); ?>
                            </option>
                        </select>
                        <br>
                        <select name="transp_fee_inst[<?php echo $row['student_id'];?>]" id="transp_fee_inst_<?php echo $row['student_id'];?>"  class="selectpicker" data-style="form-control" data-live-search="true">
                            <?php if($fee_installment['transp_fee_inst']) { ?>
                                <option value=""><?php echo get_phrase('select_transport_fee_instalment'); ?></option>
                            <?php foreach ($fee_installment['transp_fee_inst'] as $fee_inst): ?>
                                <option value="<?php echo $fee_inst['id']; ?>"><?php echo $fee_inst['installment_name']."(".$fee_inst['no_of_installment'].")"; ?></option>
                            <?php endforeach; } else { ?>
                                <option value=""><?php echo get_phrase('transport_fee_instalment_not_set');?></option>
                            <?php }  ?>
                        </select>
                    </td>
                    <td class="text-center">
                        <select name="school_fee_inst[<?php echo $row['student_id'];?>]" id="school_fee_inst_<?php echo $row['student_id'];?>"  class="selectpicker" data-style="form-control" data-live-search="true">
                            <?php if($fee_installment['school_fee_inst']) { ?>
                                <option value=""><?php echo get_phrase('select_school_fee_instalment'); ?></option>
                            <?php foreach ($fee_installment['school_fee_inst'] as $fee_inst): ?>
                                <option value="<?php echo $fee_inst['id']; ?>"><?php echo $fee_inst['installment_name']."(".$fee_inst['no_of_installment'].")"; ?></option>
                            <?php endforeach; } else { ?>
                                <option value=""><?php echo get_phrase('school_fee_instalment_not_set');?></option>
                            <?php }  ?>
                        </select>
                        <br>
                        <select name="scholarship_id[<?php echo $row['student_id'];?>]" id="scholarship_id_<?php echo $row['student_id'];?>" class="selectpicker" data-style="form-control" data-live-search="true">
                            <?php if($scholarships) { ?>
                                <option value=""><?php echo get_phrase('select_scholarship'); ?></option>
                            <?php foreach ($scholarships as $scholarship): ?>
                                <option value="<?php echo $scholarship['id']; ?>"><?php echo $scholarship['scholarship_name']; ?></option>
                            <?php endforeach; } else { ?>
                                <option value=""><?php echo get_phrase('no_scholarship_set');?></option>
                            <?php }  ?>
                        </select>
                        <br>

                    </td>
                </tr>
                <?php } endforeach; ?>
        </tbody>
    </table>

    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-t-20">
        <?php echo get_phrase('update_selected_students'); ?>
    </button>

</div>



<script type="text/javascript">

$(document).ready(function() {
    $('#example').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength"
        ]
    });

    $("#scholarship_id").change(function(){
        var scholarship_id      =   $(this).val();
        var student_id          =   $("#student_id").val();
        $('#scholarship_id_'+student_id).val(scholarship_id);
    });

    $("#tutionfee_inst_type").change(function(){
        var tutionfee_inst_type     =   $(this).val();
        var student_id              =   $("#student_id").val();
        $('#school_fee_inst_'+student_id).val(tutionfee_inst_type);
    });

    $("#transpfee_inst_type").change(function(){
        var transpfee_inst_type     =   $(this).val();
        var student_id              =   $("#student_id").val();
        $('#transp_fee_inst_'+student_id).val(transpfee_inst_type);
    });

    $("#hostfee_inst_type").change(function(){
        var hostfee_inst_type       =   $(this).val();
        var student_id              =   $("#student_id").val();
        $('#hostel_fee_inst_'+student_id).val(hostfee_inst_type);
    });

    $(document).on('change',".transport_select",function(){ 
        var route_id = $(this).val(); 
        var student_id =   $(this).attr('student_id');
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?ajax_controller/get_bus_stop/' + route_id,
            success: function (response)
            {
                jQuery('#transport_id_'+student_id).html(response).selectpicker('refresh');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    });

    $(document).on('change','.route_select',function() {  
        var transport_id        =   $(this).val();
        var student_id          =   $(this).attr('student_id');
        $('#transport_fee_idError').html('');
        $.ajax({
            dataType    : 'json',
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_transportfee/' +transport_id ,
            success: function(response) {
                if(response.status == "success") {
                    $('#transp_fee_id_'+student_id).val(response.transport_fee);
                } else {
                    $('#transport_fee_idError').html(response.message);
                }
            }
        });
    });
    
    
    $(document).on('change','.dormitory_select',function() { 
        var dormitory_id        =   $(this).val();
        var student_id          =   $(this).attr('student_id');
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_free_hostel_room/' +dormitory_id ,
            success: function(response) {
                $('#room_id_'+student_id).html(response);
                $('#room_id_'+student_id).selectpicker('refresh');
            }
        });
    });

    $(document).on('change','.room_select',function() {
        var room_id        =   $(this).val();
        var student_id          =   $(this).attr('student_id');
        $.ajax({
            dataType    : 'json',
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_dormitoryfee/' +room_id ,
            success: function(response) {
                if(response.status == "success") {
                    $('#hostel_fee_id_'+student_id).val(response.hostel_fee);
                } else {
                    $('#room_idError').html(response.message);
                }
            }
        });
    });
    
    $('.selectpicker').selectpicker('refresh');
    
});
</script>