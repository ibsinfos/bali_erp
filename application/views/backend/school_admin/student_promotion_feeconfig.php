<div class="text-right">
    <span class="badge badge-success">
        <i class="fa fa-user"></i>
    </span>
</div>
<div class="row">
    <div class="col-md-12">
        <div>
            <div class="panel-heading"><b><?php echo get_phrase('set_fee_setting_for')." ".$student_det->name." ".$student_det->lname;?></b></div>
            <div class="panel-body">
                <table>
                    <tr>
                        <td>
                            <?php echo get_phrase('select_dormitory'); ?>
                            <input type="hidden" id="student_id" value="<?php echo $student_det->student_id;?>"
                        </td>
                        <td>
                            <select name="dormitory_id" id="dormitory_id" class="selectpicker" data-style="form-control" data-live-search="true">
                                <option value="">
                                    <?php echo get_phrase('no_dormitory'); ?>
                                </option>
                                <?php
                                foreach ($dormitories as $row):
                                    ?>
                                    <option value="<?php echo $row['dormitory_id']; ?>">
                                        <?php echo $row['name']; ?>
                                    </option>

                                    <?php endforeach; ?>
                            </select>
                            <span id="dormitory_fee_idError" class="error"></span>
                        </td>
                        <td>
                            <select name="room_id" id="room_id" class="selectpicker" data-style="form-control" data-live-search="true">
                                <option value="">
                                    <?php echo get_phrase('no_hostel_selected'); ?>
                                </option>
                            </select>
                            <span id="room_idError" class="error mandatory"></span>
                            <input type="hidden" value="" id="dormitory_fee_id" name="dormitory_fee_id">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo get_phrase('select_bus_route'); ?>
                        </td>
                        <td><select name="route_id" id="route_id" class="selectpicker" data-style="form-control" data-live-search="true">
                                <option value="">
                                    <?php echo get_phrase('no_transport_service'); ?>
                                </option>
                                <?php
                                foreach ($transports as $row):
                                    ?>
                                    <option value="<?php echo $row['transport_id']; ?>">
                                        <?php echo $row['route_name']; ?>
                                    </option>
                                    <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <select name="transport_id" id="transport_id" class="selectpicker" data-style="form-control" data-live-search="true">
                                <option value="">
                                    <?php echo get_phrase('select_route'); ?>
                                </option>

                            </select>
                            <span id="transport_fee_idError" class="error mandatory"></span>
                            <input type="hidden" value="" id="transport_fee_id" name="transport_fee_id">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo get_phrase('select_school_fee_instalment_scholarship'); ?>
                        </td>
                        <td>
                            <select name="scholarship_id" id="scholarship_id" class="selectpicker" data-style="form-control" data-live-search="true">
                                <?php if($scholarships) { ?>
                                    <option value=""><?php echo get_phrase('select_scholarship'); ?></option>
                                <?php foreach ($scholarships as $row): ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['scholarship_name']; ?></option>
                                <?php endforeach; } else { ?>
                                    <option value=""><?php echo get_phrase('no_scholarship_set');?></option>
                                <?php }  ?>
                            </select>
                        </td>
                        <td>
                            <select name="tutionfee_inst_type" id="tutionfee_inst_type" class="selectpicker" data-style="form-control" data-live-search="true">
                                <?php if($fee_installment['school_fee_inst']) { ?>
                                    <option value=""><?php echo get_phrase('select_school_fee_instalment'); ?></option>
                                <?php foreach ($fee_installment['school_fee_inst'] as $row): ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['installment_name']."(".$row['no_of_installment'].")"; ?></option>
                                <?php endforeach; } else { ?>
                                    <option value=""><?php echo get_phrase('school_fee_instalment_not_set');?></option>
                                <?php }  ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo get_phrase('select_hostel_transport_fee_instalment'); ?>
                        </td>
                        <td>
                            <select name="transpfee_inst_type" id="transpfee_inst_type" class="selectpicker" data-style="form-control" data-live-search="true">
                                <?php if($fee_installment['transp_fee_inst']) { ?>
                                    <option value=""><?php echo get_phrase('select_transport_fee_instalment'); ?></option>
                                <?php foreach ($fee_installment['transp_fee_inst'] as $row): ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['installment_name']."(".$row['no_of_installment'].")"; ?></option>
                                <?php endforeach; } else { ?>
                                    <option value=""><?php echo get_phrase('transport_fee_instalment_not_set');?></option>
                                <?php }  ?>
                            </select>
                        </td>
                        <td>
                            <select name="hostfee_inst_type" id="hostfee_inst_type" class="selectpicker" data-style="form-control" data-live-search="true">
                                <?php if($fee_installment['hostel_fee_inst']) { ?>
                                    <option value=""><?php echo get_phrase('select_hostel_fee_instalment'); ?></option>
                                <?php foreach ($fee_installment['hostel_fee_inst'] as $row): ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['installment_name']."(".$row['no_of_installment'].")"; ?></option>
                                <?php endforeach; } else { ?>
                                    <option value=""><?php echo get_phrase('hostel_fee_instalment_not_set');?></option>
                                <?php }  ?>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
        </div>  
    </div>
</div>
<hr>
<script>
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
    
    
    $('#transport_id').change(function() { 
        var transport_id        =   $(this).val();
        var student_id          =   $("#student_id").val();
        $('#transport_fee_idError').html('');
        $.ajax({
            dataType    : 'json',
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_transportfee/' +transport_id ,
            success: function(response) {
                if(response.status == "success") {
                    $('#transport_fee_id').val(response.transport_fee);
                    $('#transp_fee_id_'+student_id).val(response.transport_fee);
                } else {
                    $('#transport_fee_idError').html(response.message);
                }
            }
        });
    });

    $("#route_id").change(function(){ 
        var route_id = $(this).val(); 
        
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?ajax_controller/get_bus_stop/' + route_id,
                success: function (response)
                {
                    jQuery('#transport_id').html(response);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
    });

    $('#dormitory_id').change(function() {
        var dormitory_id        =   $(this).val();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_free_hostel_room/' +dormitory_id ,
            success: function(response) {
                $('#room_id').html(response);
            }
        });
    });

    $('#room_id').change(function() {
        var room_id        =   $(this).val();
        var student_id      =   $("#student_id").val();
        $('#room_idError').html('');
        $.ajax({
            dataType    : 'json',
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_dormitoryfee/' +room_id ,
            success: function(response) {
                if(response.status == "success") {
                    $('#dormitory_fee_id').val(response.hostel_fee);
                    $('#hostel_fee_id_'+student_id).val(response.hostel_fee);
                } else {
                    $('#room_idError').html(response.message);
                }
            }
        });
    });   
</script>
