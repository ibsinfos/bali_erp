<div class="col-md-12 white-box">
<div class="text-center">
   <h3><b> <?php echo get_phrase('students_of_class_'.$class_name);?></b></h3>
</div>
    <table class="display nowrap" cellspacing="0" width="100%" id="example">
        <thead>
            <tr>
                <th class="text-center"></th>
                <th class="text-center"><?php echo get_phrase('name');?></th>
                <th class="text-center"><?php echo get_phrase('roll');?></th>
                <th><?php echo get_phrase('Hostel');?></th>
                <th><?php echo get_phrase('Transport');?></th>
                <th class="text-center"><?php echo get_phrase('options');?></div></th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach ($students as $stu):?>
                <tr>
                    <td class="text-center">
                        <input type="checkbox" name="student_ids[]" value="<?php echo $stu->student_id; ?>">
                    </td>

                    <td class="text-center"><?php echo $stu->name;?></td>
                    <td class="text-center"><?php echo $stu->enroll_code;?></td>
                    <td>
                        <select name="hostel_ids[<?php echo $stu->student_id;?>]" id="dormitory_id_<?php echo $stu->student_id;?>"
                        student_id="<?php echo $stu->student_id;?>" class="selectpicker dormitory_select" data-style="form-control" data-live-search="true">
                            <option value=""><?php echo get_phrase('no_dormitory');?></option>
                            <?php foreach ($dormitories as $host):?>
                                <option value="<?php echo $host['dormitory_id']; ?>">
                                    <?php echo $host['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <br>
                        <select name="room_ids[<?php echo $stu->student_id;?>]" id="room_id_<?php echo $stu->student_id; ?>" 
                            class="selectpicker" data-style="form-control room_select mt10" data-live-search="true">
                            <option value=""><?php echo get_phrase('no_hostel_selected');?></option>
                        </select>
                        <br>
                        <select name="hostel_term_selected[<?php echo $stu->student_id;?>]" id="hostel_fee_inst_<?php echo $stu->student_id;?>" 
                            class="selectpicker" data-style="form-control mt10" data-live-search="true">
                            <?php if($term_config['hostel_term_setting']) { ?>
                                <option value=""><?php echo get_phrase('select_hostel_fee_instalment');?></option>
                            <?php foreach ($fee_terms as $term):
                                    if(in_array($term->id,$term_config['hostel_term_setting'])){?>
                                <option value="<?php echo $term->id; ?>"><?php echo $term->name.'('.$term->term_num.')';?></option>
                            <?php } endforeach; 
                                } else { ?>
                                <option value=""><?php echo get_phrase('hostel_fee_instalment_not_set');?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select name="route_ids[<?php echo $stu->student_id;?>]" id="route_id_<?php echo $stu->student_id;?>" student_id="<?php echo $stu->student_id;?>" 
                            class="selectpicker transport_select" data-style="form-control" data-live-search="true">
                            <option value=""><?php echo get_phrase('no_transport_service');?></option>
                            <?php foreach ($transports as $trans):?>
                            <option value="<?php echo $trans['transport_id']; ?>">
                                <?php echo $trans['route_name']; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <br>
                        <select name="route_stop_ids[<?php echo $stu->student_id;?>]" id="transport_id_<?php echo $stu->student_id;?>" 
                            class="selectpicker" data-style="form-control route_select mt10" data-live-search="true">
                            <option value=""><?php echo get_phrase('select_route');?></option>
                        </select>
                        <br>
                        <select name="transport_term_selected[<?php echo $stu->student_id;?>]" id="transp_fee_inst_<?php echo $stu->student_id;?>" 
                            class="selectpicker" data-style="form-control mt10" data-live-search="true">
                            <?php if($term_config['transport_term_setting']){?>
                                <option value=""><?php echo get_phrase('select_transport_fee_instalment'); ?></option>
                                <?php foreach ($fee_terms as $term):
                                        if(in_array($term->id,$term_config['transport_term_setting'])){?>
                                    <option value="<?php echo $term->id; ?>"><?php echo $term->name.'('.$term->term_num.')';?></option>
                                <?php } endforeach; 
                                } else { ?>
                                <option value=""><?php echo get_phrase('transport_fee_instalment_not_set');?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td class="text-center">
                        <select name="school_term_selected[<?php echo $stu->student_id;?>]" id="school_fee_inst_<?php echo $stu->student_id;?>" 
                            class="selectpicker" data-style="form-control" data-live-search="true">
                            <?php if($term_config['school_term_setting']) { ?>
                                <option value=""><?php echo get_phrase('select_school_fee_instalment');?></option>
                                <?php foreach ($fee_terms as $term): 
                                        if(in_array($term->id,$term_config['school_term_setting'])){?>
                                    <option value="<?php echo $term->id;?>"><?php echo $term->name.'('.$term->term_num.')';?></option>
                                    <?php }
                                    endforeach; 
                                } else { ?>
                                <option value=""><?php echo get_phrase('school_fee_instalment_not_set');?></option>
                            <?php }?>
                        </select>
                        <br>
                        <select name="scholarship_ids[<?php echo $stu->student_id;?>]" id="scholarship_id_<?php echo $stu->student_id;?>" 
                            class="selectpicker" data-style="form-control mt10" data-live-search="true">
                            <?php if($scholarships){?>
                                <option value=""><?php echo get_phrase('select_scholarship');?></option>
                            <?php foreach ($scholarships as $schrec): ?>
                                <option value="<?php echo $schrec->id; ?>"><?php echo $schrec->name;?></option>
                            <?php endforeach; 
                                } else { ?>
                                <option value=""><?php echo get_phrase('no_scholarship_set');?></option>
                            <?php }  ?>
                        </select>
                        <br>

                    </td>
                </tr>
                <?php endforeach; ?>
        </tbody>
    </table>
    <div class="col-sm-12 text-center">
        <button class="fcbtn btn btn-danger btn-outline btn-1d" type="button">
            <?php echo get_phrase('update_selected_students'); ?>
        </button>
    </div>
    <!-- <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-t-20">
        <?php echo get_phrase('update_selected_students'); ?>
    </button> -->
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

    /* $("#scholarship_id").change(function(){
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
    }); */

    $(document).on('change','.dormitory_select',function() { 
        var dormitory_id        =   $(this).val();
        var student_id          =   $(this).attr('student_id');
        $.ajax({
            url: '<?php echo base_url('index.php?Ajax_controller/get_free_hostel_room');?>/'+dormitory_id,
            success: function(response) {
                $('#room_id_'+student_id).html(response);
                $('#room_id_'+student_id).selectpicker('refresh');
            }
        });    
    });

    $(document).on('change','.room_select',function() {
        var room_id        =   $(this).val();
        var student_id    =   $(this).attr('student_id');
        $.ajax({
            dataType    : 'json',
            url: '<?php echo base_url('index.php?Ajax_controller/get_dormitoryfee');?>/'+room_id ,
            success: function(response) {
                if(response.status == "success") {
                    $('#hostel_fee_id_'+student_id).val(response.hostel_fee);
                } else {
                    $('#room_idError').html(response.message);
                }
            }
        });
    });

    $(document).on('change',".transport_select",function(){ 
        var route_id = $(this).val(); 
        var student_id = $(this).attr('student_id');
        $.ajax({
            url: '<?php echo base_url('index.php?ajax_controller/get_bus_stop');?>/'+route_id,
            success: function (response){
                $('#transport_id_'+student_id).html(response);
                $('#transport_id_'+student_id).selectpicker('refresh');
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
    
});
</script>