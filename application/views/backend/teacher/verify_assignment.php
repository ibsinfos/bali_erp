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
            <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('dashboard'); ?></a></li>

<?php $BRC = get_bread_crumb_old(); if (strpos($BRC, '^') !== false) { $ExpBrd = explode('^', $BRC);?>
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
<div class="col-md-12 white-box">
    <div class="form-group col-md-2" data-step="5" data-intro="<?php echo get_phrase('From here you select the class for which you wish to verify assignment.');?>" data-position='bottom'>
        <label class="control-label"><?php echo get_phrase('select_class');?></label>
        <select id="class_holder" name="class_id" data-style="form-control" data-live-search="true" class="selectpicker" onchange="return onclasschange(this.value);">
            <option value="">Select Class</option>
            <?php foreach ($classes as $row): ?>
            <option  value="<?php echo $row['class_id']; ?>">
            <?php echo get_phrase('class'); ?>&nbsp;<?php echo $row['class_name'] ;?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group col-md-2" data-step="6" data-intro="<?php echo get_phrase('From here you select the section for which you wish to verify assignment.');?>" data-position='bottom'>
        <label class="control-label"><?php echo get_phrase('select_section');?></label>
        <select id="section_holder" name="section_id" data-style="form-control" data-live-search="true" class="selectpicker" onchange="onsectionchange(this.value);">
            <option value="">Select Section</option>
        </select>
    </div>
    <div class="col-sm-3 form-group">
            <label class="control-label"><?php echo get_phrase('student'); ?></label>
                <?php //pre($students); die;?>
            <select id="student_holder" name="student_id" class="selectpicker" data-style="form-control" data-live-search="true">
                <option value="">Select Student</option>
            </select>
    </div>
    <div class="col-xs-12 col-md-2" data-step="7" data-intro="<?php echo get_phrase('From here you select the subject for which you wish to verify assignment.');?>" data-position='bottom'>
        <div class="form-group">
        <label class="control-label"><?php echo get_phrase('subject');?></label>
            <select id="subject_holder" name="subject_id" data-style="form-control" data-live-search="true" class="selectpicker" onchange="onsubjectchange(this.value);">
              <option value="">Select subject</option>
            </select>
        </div>
    </div>  
    <div class="col-xs-12 col-md-3" data-step="8" data-intro="<?php echo get_phrase('From here you select the topic for which you wish to verify assignment.');?>" data-position='bottom'>
        <div class="form-group">
        <label class="control-label"><?php echo get_phrase('topic');?></label>
            <select id="assignment_topic_holder" name="assignment_topic_id" data-style="form-control" data-live-search="true" class="selectpicker" onchange="get_students_assignments();">
              <option value="">Select topic</option>
            </select>
        </div>
    </div>
</div>

    
<div class="tab-content">
            <!----TABLE LISTING STARTS-->
<div class="tab-pane box active" id="list">
    
<div id="assignment_display">

</div>
</div>
   
<!--    <button id="submit_button" class="btn btn-success btn-center-in-sm pull-right top-for-btn" type="submit">
        <i class="entypo-install"></i>Manage Assignments   
    </button>  -->
    <?php echo form_close();?>
</div>
</div>
        
<script>        
    function onclasschange(class_id){
        jQuery('#section_holder').html('<option value="">Select Section</option>');
        $.ajax({
            url: '<?php echo base_url();?>index.php?teacher/get_teacher_section/' + class_id,
            success: function (response)
            {
                jQuery('#section_holder').append(response).selectpicker('refresh');
            }
        });
        $('#section_holder').trigger("chosen:updated");
    }
    
    function onsectionchange(section_id){
     
        var class_id = $('#class_holder').val();
        jQuery('#student_holder').html('<option value="">Select Student</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>/index.php?teacher/get_teacher_student/' + section_id + '/' + class_id,
            success: function (response)
            { 
                jQuery('#student_holder').append(response).selectpicker('refresh');
            }
        });
        $('#student_holder').trigger("chosen:updated");
 
        jQuery('#subject_holder').html('<option value="">Select Subject</option>');
        $.ajax({
            url: '<?php echo base_url();?>/index.php?teacher/get_teacher_subject/' + section_id,
            success: function (response){
                jQuery('#subject_holder').append(response).selectpicker('refresh');
            }
        });
        $('#subject_holder').trigger("chosen:updated");
    }
    
    function onsubjectchange(){
        var class_id    =   $('#class_holder').val(); 
        var subject_id    =   $('#subject_holder').val();
        $.ajax({
            url: '<?php echo base_url();?>/index.php?teacher/get_assignment_topic/',
            type : 'POST',
            data : {class_id:class_id, subject_id:subject_id },
            success: function (response){
                jQuery('#assignment_topic_holder').html(response).selectpicker('refresh');
            }
        });
        $('#assignment_topic_holder').trigger("chosen:updated");
    }

 
    function get_students_assignments(){
        var classId         =   $('#class_holder').val(); 
        var subjectId       =   $('#subject_holder').val();
        var topicid         =   $('#assignment_topic_holder').val();
        var student_id      =   $('#student_holder').val();
        $.ajax({
            type   : 'POST',
            url     :    '<?php echo base_url(); ?>index.php?ajax_controller/get_submit_assignment/',
            data    :    {classId:classId, subjectId:subjectId, topicId:topicid, student_id:student_id },
            
            success: function (response){
//                alert(response);
                if(response)
                    jQuery('#assignment_display').html(response).selectpicker('refresh'); 
            },
            error:function(xhr,status,error){
                alert('not');
            }
        });    
    }
</script>