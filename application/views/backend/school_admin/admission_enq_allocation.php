<div class="col-sm-12 white-box">
    <div class="text-center p-b-20">
        <h3><b><?php echo get_phrase('allocate_student_to_class'); ?> <?php echo $class_name; ?></b></h3>
    </div>


    <div class="row">
        <div class="col-sm-4 form-group">
            <span id="set_fee_link2"></span>
            <label for="field-2" class="control-label">
                <?php echo get_phrase('class'); ?><span class="error mandatory"> *</span>
            </label>

            <select class="selectpicker" data-style="form-control" data-live-search="true" name="enroll_class" id="enroll_student" required="required" onclick="get_section_by_class_id(this.value)">
                <option value="">Select Class</option>
                <?php foreach($classes_list as $enroll):?>
                <option value="<?php echo $enroll['class_id'];?>" <?php if($enroll['class_id']==$class_id){ echo "selected";}?>><?php echo get_phrase('enroll_to_class') . " - " . $enroll['name']; ?>
                </option> 
                <?php endforeach;?>
            </select>
        </div>

        <div class="col-sm-4 form-group">
            <label for="field-2" class="control-label">
                <?php echo get_phrase('section'); ?><span class="error mandatory"> *</span>
            </label>

            <select  class="selectpicker" data-style="form-control" data-live-search="true" name="section_id" id="section_id" required="required">
            <option value="">Select Section</option>
            <?php if(count($sections)){ foreach($sections as $section):?>
            <option value="<?php echo $section['section_id'];?>"><?php echo $section['name']; ?>
            </option><?php endforeach; }?>
            </select>
        </div>

        <div class="col-sm-4 form-group dis-none sch-fee-insta">
            <label for="field-2" class="control-label"><?php echo get_phrase('school_fee_installment'); ?><span class="error mandatory"> *</span></label>
            <select name="tutionfee_inst_type" id="tutionfee_inst_type"  class="selectpicker" data-style="form-control" data-live-search="true" required="required">
                <?php if($fee_installment['school_fee_inst']) { ?>
                <option value=""><?php echo get_phrase('select'); ?></option>
                <?php foreach ($fee_installment['school_fee_inst'] as $row): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['installment_name']."(".$row['no_of_installment'].")"; ?></option>
                <?php endforeach; } else { ?>
                <option value=""><?php echo get_phrase('school_fee_instalment_not_set');?></option>
                <?php }?>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4 form-group">
            <label for="field-2" class="control-label">
            <?php echo get_phrase('dormitory'); ?>
            </label>

            <select name="dormitory_id" id="dormitory_id"  class="selectpicker" data-style="form-control" data-live-search="true">
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
            <span id="dormitory_fee_idError" class="error mandatory"></span>
        </div>

        <div class="col-sm-4 form-group dis-none host-room-div">
            <label for="field-2" class="control-label">
                <?php echo get_phrase('hostel_room'); ?>
            </label>
            <select name="room_id" id="room_id"  class="selectpicker" data-style="form-control" data-live-search="true">
                <option value="">
                <?php echo get_phrase('no_hostel_selected'); ?>
                </option>
            </select>
            <span id="room_idError" class="error mandatory"></span>
            <input type="hidden" value="" id="dormitory_fee_id" name="dormitory_fee_id">
        </div>

        <div class="col-sm-4 form-group dis-none host-insta-div">
            <label for="field-2" class="control-label"><?php echo get_phrase('hostel_fee_installment'); ?><span class="error mandatory"> *</span></label>
            <select name="hostfee_inst_type" id="hostfee_inst_type"  class="selectpicker" data-style="form-control" data-live-search="true">
                <?php if($fee_installment['hostel_fee_inst']) { ?>
                <option value=""><?php echo get_phrase('select'); ?></option>
                <?php foreach ($fee_installment['hostel_fee_inst'] as $row): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['installment_name']."(".$row['no_of_installment'].")"; ?></option>
                <?php endforeach; } else { ?>
                <option value=""><?php echo get_phrase('hostel_fee_instalment_not_set');?></option>
                <?php }  ?>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4 form-group">
            <label for="field-2" class="control-label">
                <?php echo get_phrase('transport_route'); ?>
            </label>

            <?php if($need_transport=='no'){?>
                <input type="hidden" name="route_id" value="">
            <?php }?>
            <select name="route_id" id="route_id"  class="selectpicker" data-style="form-control" data-live-search="true" <?php echo $need_transport=='no'?'disabled':''?>>
                <option value=""><?php echo get_phrase('no_transport_service'); ?></option>
                <?php foreach ($transports as $row):?>
                    <option value="<?php echo $row['transport_id']; ?>">
                    <?php echo $row['route_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <span id="rout_idError" class="error mandatory"></span>
        </div>

        <div class="col-sm-4 form-group dis-none bus-stop-div">
            <label for="field-2" class="control-label">
                <?php echo get_phrase('bus_stop'); ?>
            </label>
            <select name="transport_id" id="transport_id"  class="selectpicker" data-style="form-control" data-live-search="true">
            <option value=""><?php echo get_phrase('select_route'); ?></option>
            </select>
            <span id="transport_fee_idError" class="error mandatory"></span>
            <input type="hidden" value="" id="transport_fee_id" name="transport_fee_id">
        </div>

        <div class="col-sm-4 form-group dis-none trans-insta-div">
            <label for="field-2" class="control-label"><?php echo get_phrase('transport_fee_installment'); ?><span class="error mandatory"> *</span></label>
            <select name="transpfee_inst_type" id="transpfee_inst_type" class="form-control selectboxit">
            <?php if($fee_installment['transp_fee_inst']) { ?>
            <option value=""><?php echo get_phrase('select'); ?></option>
            <?php foreach ($fee_installment['transp_fee_inst'] as $row): ?>
            <option value="<?php echo $row['id']; ?>"><?php echo $row['installment_name']."(".$row['no_of_installment'].")"; ?></option>
            <?php endforeach; } else { ?>
            <option value=""><?php echo get_phrase('transport_fee_instalment_not_set');?></option>
            <?php }  ?>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4 form-group">
            <label for="field-2" class="control-label"><?php echo get_phrase('grade'); ?> <span class="error mandatory"> *</span></label>
            <select name="grade" id="grade" class="selectpicker" data-style="form-control" data-live-search="true" required="required">
                <option value="">Grade</option>
                <option value="A+">A+</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
            </select>
        </div>

        <div class="col-sm-4 form-group">
            <label for="field-2" class="control-label"><?php echo get_phrase('scholarship'); ?></label>
            <select name="scholarship_id" id="scholarship_id"  class="selectpicker" data-style="form-control" data-live-search="true">
            <?php if($scholarships) { ?>
            <option value=""><?php echo get_phrase('select'); ?></option>
            <?php foreach ($scholarships as $row): ?>
            <option value="<?php echo $row['id']; ?>"><?php echo $row['scholarship_name']; ?></option>
            <?php endforeach; } else { ?>
            <option value=""><?php echo get_phrase('no_scholarship_set');?></option>
            <?php }  ?>
            </select>
        </div>
		 <div class="col-sm-4 form-group">
            <label for="field-2" class="control-label"><?php echo get_phrase('mess'); ?></label>
            <select name="mess_id" id="mess_id"  class="selectpicker" data-style="form-control" data-live-search="true">
            <?php if($mess) { ?>
            <option value=""><?php echo get_phrase('select'); ?></option>
            <?php  foreach ($mess as $row): ?>
            <option value="<?php echo $row['mess_management_id']; ?>"><?php echo $row['name']; ?></option>
            <?php endforeach; } else { ?>
            <option value=""><?php echo get_phrase('no_mess_set');?></option>
            <?php }  ?>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 height_adjust">
            <label for="field-2" class="control-label"><?php echo get_phrase('upload_photo');?></label>
            <input type="file" id="input-file-now" class="dropify" name="userfile" accept="image/x-png,image/gif,image/jpeg"/> </div>
            <span id="error_input-file-now" class="mandatory"></span>
        </div>
        <div class="text-right col-xs-12 p-t-20">
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d">
                <?php echo get_phrase('enroll_student'); ?>
            </button>
        </div>
    </div>

    
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $('.selectpicker').selectpicker({dropupAuto: false});
        $('#section_id').on('change',function(){
            if(this.value!=''){
                $('.sch-fee-insta').show();
            }else{
                $('.sch-fee-insta').hide();
            }
        });

        $('#dormitory_id').on('change',function(){
            if(this.value!=''){
                $('.host-room-div').show();
            }else{
                $('.host-room-div,.host-insta-div').hide();
            }
        });

        $('#room_id').on('change',function(){
            if(this.value!=''){
                $('.host-insta-div').show();
            }else{
                $('.host-insta-div').hide();
            }
        });

        //Transport
        $('#route_id').on('change',function(){
            if(this.value!=''){
                $('.bus-stop-div').show();
            }else{
                $('.bus-stop-div,.trans-insta-div').hide();
            }
        });

        $('#transport_id').on('change',function(){
            if(this.value!=''){
                $('.trans-insta-div').show();
            }else{
                $('.trans-insta-div').hide();
            }
        });

        $('#transport_id').change(function () {
            $('#transport_fee_idError').html('');
            var transport_id = $(this).val();
            $.ajax({
                dataType: 'json',
                url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_transportfee/' +
                    transport_id,
                success: function (response) {
                    if (response.status == "success") {
                        $('#transport_fee_id').val(response.transport_fee);
                    } else {
                        $('#transport_fee_idError').html(response.message);
                    }
                }
            });
        });

        $("#route_id").change(function () {
            var route_id = $(this).val();
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?ajax_controller/get_bus_stop/' +
                    route_id,
                success: function (response) {
                    jQuery('#transport_id').html(response).selectpicker('refresh');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        });

        $('#dormitory_id').change(function () {
            var dormitory_id = $(this).val();
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_free_hostel_room/' +
                    dormitory_id,
                success: function (response) {
                    $('#room_id').html(response).selectpicker('refresh');
                }
            });
        });

        $('#room_id').change(function () {
            var room_id = $(this).val();
            $('#room_idError').html('');
            $.ajax({
                dataType: 'json',
                url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_dormitoryfee/' +
                    room_id,
                success: function (response) {
                    if (response.status == "success") {
                        $('#dormitory_fee_id').val(response.hostel_fee);
                    } else {
                        $('#room_idError').html(response.message);
                    }
                }
            });
        });

    });

    (function () {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
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