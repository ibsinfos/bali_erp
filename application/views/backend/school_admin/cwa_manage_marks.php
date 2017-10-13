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
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<?php echo form_open(base_url() . 'index.php?school_admin/marks_selector'); ?>

        <div class="col-md-12 white-box">
            <div class="col-sm-3 form-group">
        <div class="form-group col-sm-12 p-0" data-step="5" data-intro="<?php echo get_phrase(' Select a exam, for which you want to manage marks.');?>" data-position='right'>
                <label class="control-label"><?php echo get_phrase('exam'); ?></label>
                <span class="error" style="color: red;"> *</span>
                <select name="exam_id" class="selectpicker" data-style="form-control" data-live-search="true" required>
                    <option value=" "><?php echo get_phrase('select_exam'); ?></option>
                    <?php if(count($exams)){ foreach ($exams as $row):?>
                    <option value="<?php echo $row['exam_id']; ?>"><?php echo $row['name']; ?></option><?php endforeach; }?>
                </select>
            </div> 
        </div>

            <div class="col-sm-3 form-group">
        <div class="form-group col-sm-12 p-0" data-step="6" data-intro="<?php echo get_phrase(' Select a class, for which you want to manage marks.');?>" data-position='right'>
                <label class="control-label"><?php echo get_phrase('class'); ?></label>
                <span class="error" style="color: red;"> *</span> 
                <select name="class_id" id="class_id" class="selectpicker" data-style="form-control" data-live-search="true" onchange="return onclasschange(this.value);">
                    <option value=""><?php echo get_phrase('select_class'); ?></option>
                    <?php if(count($classes)){ foreach ($classes as $row): ?>
                    <option value="<?php echo $row['class_id']; ?>"><?php echo $row['name']; ?></option><?php endforeach; }?>
                </select>
        </div></div>

            <!--<div id="subject_holder">-->
                <div class="col-sm-3 form-group">
            <div class="form-group col-sm-12 p-0" data-step="7" data-intro=" <?php echo get_phrase('Select a section, for which you want to manage marks.');?>" data-position='right'>
                    <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('section'); ?></label>
                    <span class="error" style="color: red;"> *</span> 
                    <select name="section_id" id="section_holder" class="selectpicker" data-style="form-control" data-live-search="true" onchange="return get_class_subject(this.value);">
                        <option value=""><?php echo get_phrase('select_class_first'); ?></option>
                    </select>
            </div></div>

                <div class="col-sm-3 form-group">
            <div class="form-group col-sm-12 p-0" data-step="8" data-intro="<?php echo get_phrase(' Select a subject, for which you want to manage marks.');?>" data-position='bottom'>
                    <label class="control-label"><?php echo get_phrase('subject'); ?></label><span class="error" style="color: red;"> *</span>

                    <select name="subject_id" id = "subject_holder" class="selectpicker" data-style="form-control" data-live-search="true">
                        <option value=" "><?php echo get_phrase('select_section_first'); ?></option>
                    </select>
            </div></div>
            <!--</div>-->
            <div class="text-right col-xs-12">
                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('manage_marks');?></button>
            </div>
        </div>

<?php echo form_close(); ?>

<script type="text/javascript">

    function onclasschange(class_id){
        jQuery('#section_holder').html('');
        $.ajax({
                url: '<?php echo base_url();?>index.php?school_admin/get_class_section/' + class_id,
                success: function (response)
                {
                    jQuery('#section_holder').append(response).selectpicker('refresh');
                }
        });
           $('#section_holder').trigger("chosen:updated");
    }    

    function get_class_subject(section_id) {
        var class_id = $('#class_id').val();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?ajax_controller/marks_get_cwa_subject/' + class_id + '/' +section_id,
            success: function (response)
            {
                jQuery('#subject_holder').html(response).selectpicker('refresh');
            },
            error: function (err) {
                console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
            }
        });
    }
</script>