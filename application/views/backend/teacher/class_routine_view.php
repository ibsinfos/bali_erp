<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('Class_timetable'); ?></h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('dashboard'); ?></a></li>

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
</div>

<div class="row m-0">
<div class="col-md-12 white-box" data-step="5" data-intro="Here you can select class and section and can see the class details." data-position='top'>
<input type="hidden" id ="teacher_id_get" name ="teacher_id" value="<?php echo $this->session->userdata('teacher_id'); ?>" >
<div class="form-group col-md-6">
    <label class="control-label"><?php echo get_phrase('class'); ?></label>
    <select class="selectpicker" data-style="form-control" id="class_id" data-live-search="true" onchange="return get_class_sections_by_teacher(<?php echo $this->session->userdata('teacher_id'); ?>)">
        <option value=" "><?php echo get_phrase('select_class'); ?></option>
        <?php foreach ($classes as $row): ?>
            <option value="<?php echo $row['class_id']; ?>">
                <?php echo get_phrase('class'); ?>&nbsp;<?php echo $row['name']; ?>
            </option>
        <?php endforeach; ?>
    </select> 
</div>
<div class="form-group col-md-6">
    <label class="control-label"><?php echo get_phrase('section'); ?></label>    
    <select name="section_id" data-style="form-control" data-live-search="true" class="selectpicker" id="section_selector_holder">
        <option value=" "><?php echo get_phrase('select_section'); ?></option>
    </select>           

</div>


</div>
</div>

<div id="class_routine"></div>
<script type="text/javascript">
    function get_class_sections_by_teacher(teacher_id) {
        var class_id = $('#class_id').val(); 
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?ajax_controller/get_section/' + class_id + '/' + teacher_id,
            success: function (response) {
                jQuery('#section_selector_holder').html(response).selectpicker('refresh');
            }
        });
    }

    $('#section_selector_holder').change(function () {
        var teacher_id = $('#teacher_id_get').val();
        var class_id = $('#class_id').val();
        var section_id = $('#section_selector_holder').val();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?ajax_controller/get_class_routine_by_teacher/' + teacher_id + '/' + class_id + '/' + section_id,

            success: function (response) {
                jQuery('#class_routine').html(response).selectpicker('refresh');
            }
        });

    })

</script>