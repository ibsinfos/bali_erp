<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('Student_Promotion'); ?></h4>
    </div>
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

<div class="row">
<div class="col-md-12">

<div class="panel panel-danger block6" data-step="5" data-intro="<?php echo get_phrase('For Information'); ?>" data-position='bottom'>

    <div class="panel-heading"> Student Promotion Notes
        <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
    </div>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
            <p> Promoting student from the present class to the next class will create an enrollment of that student to the next session. Make sure to select correct class options from the select menu before promoting.If you don't want to promote a student to the next class, please select that option. That will not promote the student to the next class but it will create an enrollment to the next session but in the same class.</p>
        </div>
    </div>
</div>
</div>
</div>
<?php echo form_open(base_url() . 'index.php?school_admin/student_promotion/promote',array('id'=>'promotion-form')); ?>
    <div class="col-md-12 white-box" data-step="6" data-intro="<?php echo get_phrase('From here by filling information you can manage the promotion. After filling the mandatory fields click on manage promotion button. Then you will get a list of students.');?>" data-position='top'>
       <div class="col-sm-4 form-group">
            <label><?php echo get_phrase('from_class'); ?><span class="error mandatory"> *</span></label>
            <select name="promotion_from_class_id" id="from_class_id" class="selectpicker" data-style="form-control" data-live-search="true">
                <option value=""><?php echo get_phrase('select'); ?></option>
                <?php foreach ($class_array as $row):?>
                <option value="<?php echo $row['class_id']; ?>">
                    <?php echo get_phrase('class'); ?>&nbsp;
                        <?php echo $row['name']; ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-sm-4 form-group">
            <label><?php echo get_phrase('from_section'); ?><span class="error mandatory"> *</span></label>
            <select name="from_section_id" id="from_section_selector_holder" class="selectpicker" data-style="form-control" data-live-search="true">
                <option value="">
                    <?php echo get_phrase('select_class_first'); ?>
                </option>
            </select>
        </div>

        <div class="col-sm-4 form-group">
            <label><?php echo get_phrase('to_class'); ?><span class="error mandatory"> *</span></label>
            <select name="promotion_to_class_id" id="to_class_id" class="selectpicker" data-style="form-control" data-live-search="true">
                <option value="">
                    <?php echo get_phrase('select_promote_from_section_first'); ?>
                </option>
            </select>
        </div>

        <div class="col-sm-4 form-group">
            <label><?php echo get_phrase('to_section'); ?><span class="error mandatory"> *</span></label>
            <select name="to_section_id" class="selectpicker" data-style="form-control" data-live-search="true" id="to_section_selector_holder">
                <option value="">
                    <?php echo get_phrase('select_class_first'); ?>
                </option>
            </select>
        </div>

        <div class="col-sm-12 text-right">
            <button class="fcbtn btn btn-danger btn-outline btn-1d" type="button" onclick="get_students_to_trasnfer()">
                <?php echo get_phrase('student_transfer'); ?>
            </button>
        </div>
    </div>
  
 <div id="students_for_promotion_holder"></div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function(){
        $('.selectpicker').selectpicker('refresh');
    });
    
    $('#from_class_id').change(get_from_class_sections);
    $('#from_section_selector_holder').change(get_promote_to_class);
    $('#to_class_id').change(get_to_class_sections);

    function get_students_to_trasnfer() {
        alert("success"); 
        var from_class_id = $("#from_class_id").val();
        var from_section_id = $("#from_section_selector_holder").val();
        var to_section_id = $("#to_section_selector_holder").val();
        var to_class_id = $("#to_class_id").val();
        var promotion_year = $("#promotion_year").val();

        if (from_class_id == "" || to_class_id == "") {
            toastr.error("<?php echo get_phrase('select_proper_class_and_section'); ?>")
            return false;
        }

        if (from_class_id == to_class_id) {
            toastr.error("<?php echo get_phrase('select_valid_promote_class'); ?>")
            document.getElementById("to_class_id").selected = "";
            return false;
        }

        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_students_to_transfer/' + from_class_id + '/' + from_section_id + '/' + to_class_id + '/' + to_section_id,
            success: function(response) {
                backendLoginFinance();
                jQuery('#students_for_promotion_holder').html(response);
            }
        });
        return false;
    }
    function get_from_class_sections() {
        var class_id =  $(this).val();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_class_section/' + class_id,
            success: function(response) {
                jQuery('#from_section_selector_holder').html(response).selectpicker('refresh');
            }
        });
    }

    function get_to_class_sections() {
        var class_id =  $(this).val();
        var class_fee_status        =   0;
        jQuery.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/check_fee_set_forclass/' + class_id,
            type:'POST',
            dataType: 'json',
            async: false,
            success: function(response) {
                if(response.status == 'success'){
                    class_fee_status    =   1;
                    jQuery("#set_fee_link").html('').selectpicker('refresh');;
                } else {
                    backendLoginFinance();
                    jQuery("#set_fee_link").html(response.message).selectpicker('refresh');
                }
            }
        });

        if(class_fee_status != 0) {
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?school_admin/get_class_section/' + class_id,
                success: function(response) {
                    jQuery('#to_section_selector_holder').html(response).selectpicker('refresh');
                }
            });
        } else {
            var def_section = '<option value="">Select Class First</option>';
            jQuery("#to_section_selector_holder").html(def_section).selectpicker('refresh');
        }
    }

    function get_promote_to_class() {
        var class_id = $("#from_class_id option:selected").val();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_promote_to_class/' + class_id,
            success: function(response) {
                jQuery('#to_class_id').html(response).selectpicker('refresh');
            }
        });
    }


    $(document).submit('#promotion-form',function( event ) {
        if($('.stu-check:checked').length==0){
            swal('<?php echo get_phrase('please_select_atleast_one_student')?>','','error');
            event.preventDefault();
            return false;
        }
    });
</script>