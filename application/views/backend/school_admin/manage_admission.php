<div class="row bg-title"> 
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>

            <?php $BRC = get_bread_crumb(); if (strpos($BRC, '^') !== false) { $ExpBrd = explode('^', $BRC);?>
            <li>
                <?php echo get_phrase(@$ExpBrd[0]); ?>
                <?php echo @$ExpBrd[1]; ?>
            </li> <?php }else{ $ExpBrd[2] = $BRC;}?>
            <li class="active">
                <?php echo get_phrase(@$ExpBrd[2]); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<?php echo form_open(base_url() . 'index.php?school_admin/manage_admission/enroll_students',array('enctype'=>"multipart/form-data"));
$running_year_array = explode("-", $running_year);?>

<div class="col-sm-12 white-box" data-step="5" data-intro="<?php echo get_phrase('Here you can manage admission for select options.');?>" data-position='bottom'>
    <div class="form-group col-sm-12 p-0">
        <div class="col-xs-12 col-sm-6 col-md-6">
            
            <label class="control-label"><?php echo get_phrase('select_class'); ?><span class="error mandatory"> *</span></label>
            <select name="promotion_from_class_id" id="from_class_id" class="selectpicker" data-style="form-control" data-live-search="true">
                <option value=""><?php echo get_phrase('select'); ?></option>
                <?php foreach ($class_array as $row):?>
                    <option value="<?php echo $row['class_id']; ?>"><?php echo $row['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <span id="set_fee_link" class="mandatory"></span>
        </div>
    
        <div class="col-xs-12 col-sm-6 col-md-6">
            <label class="control-label"><?php echo get_phrase('Select Student'); ?><span class="error mandatory"> *</span></label>
            <select name="student_id" id="student_id" class="selectpicker" data-style="form-control" data-live-search="true" data-title="Select Student">
                <option value=""><?php echo get_phrase('select_class');?></option>
            </select>
        </div>
    
    <div class="text-right col-xs-12 p-t-20">
        <button class="fcbtn btn btn-danger btn-outline btn-1d" type="button" onclick="get_list_of_applied_students('<?php echo $running_year; ?>')">
            <?php echo get_phrase('manage_admission')?>
        </button>
    </div>
    
</div>
</div>

<div id="students_for_promotion_holder">
    
</div>


<?php echo form_close();?>
<script type="text/javascript">
    <?php if(sett('new_fi')){?>
        $("#from_class_id").on('change',function(){
            var class_id = this.value;
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?Ajax_controller/fi_check_fee_set_forclass/',
                type:'POST',
                data : {class_id:class_id},
                dataType: 'json',
                //async: false,
                dataType: 'json',
                success: function(response) {
                    //console.log(response);
                    if(response.status == 'success'){
                        //class_fee_status    =   1;
                        $('#student_id').html(response.html);
                        $("#set_fee_link").html('');
                    } else {
                        swal('Error',response.msg,'error');
                        if(response.html){
                            $("#set_fee_link").html(response.html+'<br>');
                        }
                    }
                    $(".selectpicker").selectpicker('refresh');
                }
            });
        });

        function get_list_of_applied_students(running_year){
            var class_id    =   $("#from_class_id").val();
            var student_id  =   $("#student_id").val();
            
            if (from_class_id == "") {
                swal('Error',"<?php echo get_phrase('select_class_for_admission_process'); ?>",'error');
                return false;
            }

            if (student_id == "") {
                swal('Error',"<?php echo get_phrase('select_student_for_admission_process'); ?>",'error');
                return false;
            }

            $.ajax({
                type:'POST',
                url: '<?php echo base_url(); ?>index.php?Ajax_controller/fi_get_student_det_for_admimission/',
                data : { class_id:class_id , student_id: student_id},
                success: function (response){
                    jQuery('#students_for_promotion_holder').html(response);
                    $('.dropify').dropify();
                    $(".selectpicker").selectpicker('refresh');
                }
            });
            return false;
        }
    <?php }else{?>
        $("#from_class_id").change(list_students_byclass);

        function get_list_of_applied_students(running_year){
            var class_id    =   $("#from_class_id").val();
            var student_id  =   $("#student_id").val();// "";//$("#from_section_selector_holder").val();
            var to_section_id= "";//$("#to_section_selector_holder").val();
            var to_class_id = "";//$("#to_class_id").val();
            var promotion_year = "";//$("#promotion_year").val();

            //if (from_class_id == "" || to_class_id == "") {
            if (from_class_id == "") {
                toastr.error("<?php echo get_phrase('select_class_for_admission_process'); ?>")
                return false;
            }

            if (student_id == "") {
                toastr.error("<?php echo get_phrase('select_student_for_admission_process'); ?>")
                return false;
            }

            $.ajax({
                type:'POST',
                url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_student_det_for_admission/',
                data : { class_id:class_id , student_id: student_id
                },
                success: function (response){
                    jQuery('#students_for_promotion_holder').html(response);
                    $('.dropify').dropify();
                    $(".selectpicker").selectpicker('refresh');
                }
            });
            return false;
        }
    <?php }?>
    
    function list_students_byclass() {
        var class_id        =   $("#from_class_id").val();
        var class_fee_status        =   0;
        jQuery.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/check_fee_set_forclass/' + class_id,
            type:'POST',
            dataType: 'json',
            //async: false,
            success: function(response) {
                if(response.status === 'success'){
                    class_fee_status    =   1;
                    jQuery("#set_fee_link").html('').selectpicker('refresh');
                } else {
                    backendLoginFinance();
                    jQuery("#set_fee_link").html(response.message+'<br>').selectpicker('refresh');
                }
                    $(".selectpicker").selectpicker('refresh');
            }
        });
        if(class_fee_status != 0) {
            $.ajax({
                type        :   'POST',
                data        :   { class_id:class_id},
                url         :   '<?php echo base_url(); ?>index.php?Ajax_controller/enquired_students_by_class',
                success     :   function(response) {
                                    $("#student_id").html(response);
                                    $(".selectpicker").selectpicker('refresh');
                                },
            });
        } else {
            var def_section = '<option value="">Select Class</option>';
            jQuery("#student_id").html(def_section);
            $('.selectpicker').selectpicker('refresh');
        }
    }
        
    function get_section_by_class_id(class_id){
        if (class_id == "") {
            toastr.error("<?php echo get_phrase('select_class'); ?>")
            return false;
        }
        var class_fee_status        =   0;
        jQuery.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/check_fee_set_forclass/' + class_id,
            type:'POST',
            dataType: 'json',
            async: false,
            success: function(response) {
                if(response.status == 'success'){
                    class_fee_status    =   1;
                    jQuery("#set_fee_link2").html('');
                } else {
                    jQuery("#set_fee_link2").html(response.message+'<br>');
                }
            }
        });
        if(class_fee_status != 0) {
            $.ajax({
                type:'POST',
                url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_section_by_class_id/',
                data : { class_id:class_id},
                success: function (response){
                    jQuery('#section_id').empty();
                    if(response){
                        jQuery('#section_id').html(response);
                        $('.selectpicker').selectpicker('refresh');
                    }
                }
            });
        }  else {
            var def_section = '<option value="">Select Class</option>';
            jQuery("#section_id").html(def_section);
            $('.selectpicker').selectpicker('refresh');
        }
        return false;    
    }
</script>