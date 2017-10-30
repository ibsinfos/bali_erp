<div class="col-md-12 white-box">
    <table class="display nowrap" cellspacing="0" width="100%" id="example">
        <thead>
            <tr>
                <th class="text-center"><div><?php echo get_phrase('s._no.'); ?></div></th>
                <th class="text-center"><div><?php echo get_phrase('name'); ?></div></th>
                <th class="text-center"><div><?php echo get_phrase('roll'); ?></div></th>
                <th class="text-center"><div><?php echo get_phrase('options'); ?></div></th>
            </tr>
        </thead>
        <tbody>
        <?php  $count = 1;
            foreach ($students as $row): ?>
            <tr>
                <td><?php echo  $count++; ?></td>
                <td class="text-center"><?php echo ucfirst($row['student_name']." ".$row['lname']); ?></td>
                <td class="text-center"><input type="checkbox" class="stu-check" name="student_ids[]" value="<?php echo $row['student_id']; ?>">
                    <input type="hidden" name="class_to" id="class_to" value="<?php echo $class_id_to;?>">
                    <input type="hidden" name="section_id_to"  value="<?php echo $section_id_to; ?>"></td>
                <td class="text-center"><?php echo $row['roll']; ?></td>
                <td><input type="checkbox" id="allChecked" name="student_transfer[]" value="<?php echo $row['student_id']; ?>></td>
                   
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div align="center">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d m-t-20">
            <?php echo get_phrase('promote_selected_students'); ?>
        </button>
    </div>
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