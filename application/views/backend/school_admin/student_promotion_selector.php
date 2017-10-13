<div class="col-md-12 white-box">
<div class="text-center">
   <h3>
    <b> <?php echo get_phrase('students_of_class'); ?> <?php //echo $this->db->get_where('class', array('class_id' => $class_id_from))->row()->name; 
            echo $from_class_name;?></b>
   </h3>
</div>
    <table class="display nowrap" cellspacing="0" width="100%" id="example">
        <thead>
            <tr>
                <th class="text-center">
                    <div>
                    <input type="checkbox" class="js-switch selected_student_checkbox" id="checkAll" name="select_all" />
                    </div>
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
                <th class="text-center">
                     <div>
                    <?php echo get_phrase('option'); ?>
                          </div>
                </th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach ($students as $row):
            /*$query = $this->db->get_where('enroll', array(
            'student_id' => $row['student_id'],
            'year' => $promotion_year
            ));*/?>
            <tr>
                <td class="text-center">
                    <input type="checkbox" class="stu-check" name="student_ids[]" value="<?php echo $row['student_id']; ?>">
                    <input type="hidden" name="transp_fee_id[<?php echo $row['student_id'];?>]" id="transp_fee_id_<?php echo $row['student_id'];?>" value="">
                    <input type="hidden" name="hostel_fee_id[<?php echo $row['student_id'];?>]" id="hostel_fee_id_<?php echo $row['student_id'];?>" value="">
                </td>

                <td class="text-center">
                    <?php echo $row['name']; ?>
                </td>
                <td class="text-center">
                    <?php echo $row['roll']; ?>
                </td>
                <td>
                    <select name="dormitory_id[]" id="dormitory_id_<?php echo $row['student_id']; ?>" student_id="<?php echo $row['student_id']; ?>" class="dormitory_select selectpicker" data-style="form-control" data-live-search="true">
                        <option value="">
                            <?php echo get_phrase('no_dormitory'); ?>
                        </option>
                        <?php foreach ($dormitories as $host): ?>
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
                        <?php foreach ($transports as $trans):?>
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
                    <select name="school_fee_inst[<?php echo $row['student_id'];?>]" id="school_fee_inst_<?php echo $row['student_id'];?>" 
                        class="selectpicker sch-fee-div" data-style="form-control" data-live-search="true">
                        <?php if($fee_installment['school_fee_inst']) { ?>
                            <option value=""><?php echo get_phrase('select_school_fee_instalment'); ?></option>
                        <?php foreach ($fee_installment['school_fee_inst'] as $fee_inst): ?>
                            <option value="<?php echo $fee_inst['id']; ?>"><?php echo $fee_inst['installment_name']."(".$fee_inst['no_of_installment'].")"; ?></option>
                        <?php endforeach; } else { ?>
                            <option value=""><?php echo get_phrase('school_fee_instalment_not_set');?></option>
                        <?php }  ?>
                    </select>
                    <br>
                    <select name="scholarship_id[<?php echo $row['student_id'];?>]" id="scholarship_id_<?php echo $row['student_id'];?>" 
                        class="selectpicker" data-style="form-control" data-live-search="true">
                        <?php if($scholarships) { ?>
                            <option value=""><?php echo get_phrase('select_scholarship'); ?></option>
                        <?php foreach ($scholarships as $scholarship): ?>
                            <option value="<?php echo $scholarship['id']; ?>"><?php echo $scholarship['scholarship_name']; ?></option>
                        <?php endforeach; } else { ?>
                            <option value=""><?php echo get_phrase('no_scholarship_set');?></option>
                        <?php }  ?>
                    </select>
                    <br>
                    <?php //if ($query->num_rows() < 1): 
                    //echo $row['class_name'];
                    if($row['enroll_status'] == ''){?>
                    <select class="selectpicker" data-style="form-control" data-live-search="true" name="promotion_status_<?php echo $row['student_id']; ?>" id="promotion_status">
                        <option value="<?php echo $class_id_to; ?>">
                            <?php echo get_phrase('enroll_to_class') . " - " . $to_class_name. "- " .$row['section_name']; ?>
                        </option>
                        <option value="<?php echo $class_id_from; ?>">
                            <?php echo get_phrase('enroll_to_class') . " : " . $from_class_name. "- " .$row['section_name'];?>
                    </select>
                    <?php } else { ?>
                            <span class="badge badge-success btn-outline form-control">
                                <i class="fa fa-check"></i>
                                <?php echo get_phrase('student_already_enrolled'); ?>
                            </span>
                    <?php } ?>
                </td>
                <td class="text-center">
                    <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/student_promotion_performance/<?php echo $row['student_id']; ?>/<?php echo $class_id_from; ?>');">
                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View Academic Performance"><i class="fa fa-eye"></i></button>
                    </a>
                </td>       
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-t-20">
        <?php echo get_phrase('promote_selected_students'); ?>
    </button>
</div>

<script type="text/javascript">
$('#example').DataTable({
    dom: 'Bfrtip',
    responsive: true,
    buttons: [
        "pageLength"
    ]
});

$(document).ready(function() {
    $('.selectpicker').selectpicker('refresh');
    if ($.isFunction($.fn.selectBoxIt)) {
        $("select.selectboxit").each(function(i, el) {
            var $this = $(el),
                opts = {
                    showFirstOption: attrDefault($this, 'first-option', true),
                    'native': attrDefault($this, 'native', false),
                    defaultText: attrDefault($this, 'text', ''),
                };
            $this.addClass('visible');
            $this.selectBoxIt(opts);
        });
    }
    $('#checkAll').change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));

        $.each($('.stu-check'),function(i,o){
            if($(o).prop('checked')){
                $(o).closest('tr').find('.sch-fee-div').attr('required','required');
            }else{
                $(o).closest('tr').find('.sch-fee-div').removeAttr('required');
            }
        });
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

    $(".transport_select").change(function(){ 
        var route_id = $(this).val(); 
        var student_id          =   $(this).attr('student_id');
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?ajax_controller/get_bus_stop/' + route_id,
                success: function (response)
                {
                    jQuery('#transport_id_'+student_id).html(response);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
    });

    $('.route_select').change(function() {  
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

    $('.dormitory_select').change(function() { 
        var dormitory_id        =   $(this).val();
        var student_id          =   $(this).attr('student_id');
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_free_hostel_room/' +dormitory_id ,
            success: function(response) {
                $('#room_id_'+student_id).html(response);
            }
        });
    });

    $('.room_select').change(function() {
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

    $(document).on('change','.stu-check',function(){
        //console.log($(this).prop('checked'));
        if($(this).prop('checked')){
            $(this).closest('tr').find('.sch-fee-div').attr('required','required');
        }else{
            $(this).closest('tr').find('.sch-fee-div').removeAttr('required');
        }
    });
});   
</script>