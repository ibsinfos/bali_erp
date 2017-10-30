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

<?php $BRC = get_bread_crumb(); if (strpos($BRC, '^') !== false) { $ExpBrd = explode('^', $BRC); ?>
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

<div class="panel panel-danger block6" data-step="5" data-intro="For Information" data-position='bottom' id="error" style="display: none;">
    <div class="panel-heading"> 
        You need to add exam routine first.
        <div class="pull-right"><a href="#" data-perform="panel-collapse">
            <i class="ti-minus"></i>
            <a href="#" data-perform="panel-dismiss">
                <i class="ti-close"></i>
            </a> 
        </div>
    </div>
</div>

<div class="panel panel-danger block6" data-step="5" data-intro="For Information" data-position='bottom'>
    <div class="panel-heading"> Manage Exam Marks Note
        <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
    </div>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
            <p> You can manage marks here. Please set exam routine first before add marks, otherwise marks will not be shown.</p>
        </div>
    </div>
</div>

<?php echo form_open(base_url() . 'index.php?school_admin/marks_selector',array('id'=>'marks_form','name'=>'marks_form')); ?>

        <div class="col-md-12 white-box">
            <div class="col-sm-3 form-group">
		<div class="form-group col-sm-12 p-0" data-step="5" data-intro=" <?php echo get_phrase('Select a exam, for which you want to manage marks.');?>" data-position='right'>
                <label class="control-label"><?php echo get_phrase('exam'); ?></label>
                <span class="error" style="color: red;"> *</span>
                <select name="exam_id" id="exam_id" class="selectpicker" data-style="form-control" data-live-search="true" required onchange="return select_classes_for_exam(this.value);">
                    <option value=" "><?php echo get_phrase('select_exam'); ?></option>
                    <?php if(count($exams)){ foreach ($exams as $row):?>
                    <option value="<?php echo $row['exam_id']; ?>"><?php echo $row['name']; ?></option><?php endforeach; }?>
                </select>
            </div> 
	    </div>

            <div class="col-sm-3 form-group">
		<div class="form-group col-sm-12 p-0" data-step="6" data-intro=" <?php echo get_phrase('Select a class, for which you want to manage marks.');?>" data-position='right'>
                <label class="control-label"><?php echo get_phrase('class'); ?></label>
                <span class="error" style="color: red;"> *</span> 
                <select name="class_id" id="class_id" class="selectpicker" data-style="form-control" data-live-search="true" onchange="return onclasschange(this.value);">
                    <option value=""><?php echo get_phrase('select_class'); ?></option>
                    
                </select>
		</div></div>

            <!--<div id="subject_holder">-->
                <div class="col-sm-3 form-group">
		    <div class="form-group col-sm-12 p-0" data-step="7" data-intro="<?php echo get_phrase(' Select a section, for which you want to manage marks.');?>" data-position='right'>
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
            <div class="text-right col-xs-12" >
                <button data-step="9" data-intro=" <?php echo get_phrase('Click here to manage marks.');?>" data-position='left' type="button" class="fcbtn btn btn-danger btn-outline btn-1d" onclick="validateMarks();"><?php echo get_phrase('manage_marks');?></button>
            </div>
        </div>

<?php echo form_close(); ?>

<script type="text/javascript">

    function onclasschange(class_id){
        $.ajax({
            url: '<?php echo base_url();?>index.php?school_admin/get_class_section/' + class_id,
            success: function (response)
            {
                jQuery('#section_holder').html(response).selectpicker('refresh');
            }
        });
           $('#section_holder').trigger("chosen:updated");
    }    

    function get_class_subject(section_id) {
        var class_id = $('#class_id').val();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?ajax_controller/marks_get_subject/' + class_id + '/' +section_id,
            success: function (response)
            {
                jQuery('#subject_holder').html(response).selectpicker('refresh');
            },
            error: function (err) {
                console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
            }
        });
    }

    function select_classes_for_exam(exam_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_class_by_exams/' + exam_id,
            success:function (response){//alert(response);
                jQuery('#class_id').html(response).selectpicker('refresh');
            }
        });
    }

    function validateMarks(){
        var exam_id,class_id,section_id,subject_id;
        var flag = 0;
        exam_id = $('#exam_id').val();
        class_id = $('#class_id').val();
        section_id = $('#section_holder').val();
        subject_id = $('#subject_holder').val();
        
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/check_exam_routine_set/' + exam_id+'/'+class_id+'/'+section_id+'/'+subject_id,
            async: false,
            success:function (response){ 
                if(response == 1){
                    flag = 1;
                }
                if(flag == 0) {
                    message_modal('You need to add exam routine first.');
                } else {
                    document.marks_form.submit();
                }
            }
        });

        
    }

</script>