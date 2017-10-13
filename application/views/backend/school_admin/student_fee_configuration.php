<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('student_fee_configuration'); ?></h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
         <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php?school_admin/dashboard');?>"><?php echo get_phrase('Dashboard'); ?></a></li>

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
<div class="panel panel-danger block6" data-step="5" data-intro="<?php echo get_phrase('For Information');?>" data-position='bottom'>
    <div class="panel-heading"> Student Fee Configuration
        <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
    </div>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
            <p> Updating student fee details,finance will create an invoice for student. Make sure to select correct class options from the select menu before submit.If you don't want to set fee for a student to the next class.</p>
        </div>
    </div>
</div>
</div>
</div>
<?php echo form_open(base_url() . 'index.php?school_admin/student_fee_configuration/add_student_det'); ?>

    <div class="col-md-12 white-box" data-step="6" data-intro="<?php echo get_phrase('From here by filling information you can manage the promotion. After filling the mandatory fields click on manage promotion button. Then you will get a list of students.');?>" data-position='top'>

        <?php    
//        $running_year_array = explode("-", $running_year);
//        $next_year_first_index = $running_year_array[1];
//        $next_year_second_index = $running_year_array[1] + 1;
//        $next_year = $next_year_first_index . "-" . $next_year_second_index;
        ?>
            <div class="col-md-12" id="set_fee_link" class='mandantory'></div>
            <div class="col-sm-4 form-group">
                <label>
                    <?php echo get_phrase('select_class'); ?>
                </label>
                <select name="class_id" id="from_class_id" onchange="return get_from_class_sections(this.value)" class="selectpicker" data-style="form-control" data-live-search="true">
                    <option value="">
                        <?php echo get_phrase('select'); ?>
                    </option>
                    <?php
                    foreach ($classes as $row):
                    ?>
                        <option value="<?php echo $row['class_id']; ?>">
                            <?php echo get_phrase('class'); ?>&nbsp;
                                <?php echo $row['name']; ?>
                        </option>
                        <?php endforeach; ?>
                </select>
            </div>

            <div class="col-sm-4 form-group">
                <label>
                    <?php echo get_phrase('select_section'); ?>
                </label>
                <select name="section_id" id="from_section_selector_holder" class="selectpicker" data-style="form-control" data-live-search="true">
                    <option value="">
                        <?php echo get_phrase('select_class_first'); ?>
                    </option>
                </select>
            </div>
            <div class="col-sm-12 text-right">
                <button class="fcbtn btn btn-danger btn-outline btn-1d" type="button" onclick="get_students_to_setfee('<?php echo $running_year; ?>')">
                    <?php echo get_phrase('MANAGE_FEE'); ?>
                </button>
            </div>
    </div>
  
 <div id="students_fee_config"></div>
<?php echo form_close(); ?>




<script type="text/javascript">
    function get_students_to_setfee(running_year) {
        var class_id = $("#from_class_id").val();
        var section_id = $("#from_section_selector_holder").val();

        <?php if(!$new_fi){?>
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?school_admin/get_students_setfee/' + class_id + '/' + section_id + '/'  + running_year,
                success: function(response) {
                    jQuery('#students_fee_config').html(response).selectpicker('refresh');
                }
            });
        <?php }else{?>
            $.ajax({
                url: '<?php echo base_url('index.php?school_admin/fi_get_setudent_new_setfee'); ?>/' + class_id + '/' + section_id + '/'  + running_year,
                success: function(response) {
                    $('#students_fee_config').html(response)
                    $('.selectpicker').selectpicker('refresh');
                }
            });
        <?php }?>
        return false;
    }


    function get_from_class_sections(class_id) {
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
            jQuery.ajax({
                url: '<?php echo base_url(); ?>index.php?school_admin/get_class_section/' + class_id,
                success: function(response) {
                    jQuery("#from_section_selector_holder").html(response);
                    jQuery("#from_section_selector_holder").selectpicker('refresh');
                }
            });
        } else {
            var def_section = '<option value="">Select Class First</option>';
            jQuery("#from_section_selector_holder").html(def_section);
            jQuery("#from_section_selector_holder").selectpicker('refresh');
        }
    }

    function get_to_class_sections(class_id) {

        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_class_section/' + class_id,
            success: function(response) {
                jQuery('#to_section_selector_holder').html(response).selectpicker('refresh');
            }
        });

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
</script>