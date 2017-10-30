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

<div class="row">
<div class="col-md-12">
    <div class="white-box">

    <?php echo form_open(base_url().'index.php?teacher/assignment_selector', array('id'=>'manage_assignments', 'method'=>'POST'));?>
<div class="row">

    <div class="form-group col-md-4" data-step="5" data-intro="<?php echo get_phrase('From here you select the class for which you wish to manage assignment.');?>" data-position='bottom'>
        <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_class');?></label>
        <select id="class_holder" name="class_id" data-style="form-control" data-live-search="true" class="selectpicker" onchange="return onclasschange(this);">
            <option value="">Select Class</option>
            <?php foreach ($classes as $row): ?>
            <option  value="<?php echo $row['class_id']; ?>">
            <?php echo get_phrase('class'); ?>&nbsp;<?php echo $row['class_name']; ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group col-md-4" style="padding: 10" data-step="6" data-intro="<?php echo get_phrase('From here you select the section for which you wish to manage assignment.');?>" data-position='bottom'>
        <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_section');?></label>
        <select id="section_holder" name="section_id" data-style="form-control" data-live-search="true" class="selectpicker" onchange="onsectionchange(this.value);">
            <option value="">Select Section</option>
        </select>
    </div>

    <div class="col-xs-12 col-md-4" data-step="7" data-intro="<?php echo get_phrase('From here you select the subject for which you wish to manage assignment.');?>" data-position='bottom'>
        <div class="form-group">
        <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('subject');?></label>
            <select id="subject_holder" name="subject_id" data-style="form-control" data-live-search="true" class="selectpicker">
              <option value="">Select Subject</option>
            </select>
        </div>
    </div>

</div>

<!--    <button id="submit_button" class="btn btn-success btn-center-in-sm pull-right top-for-btn" type="submit">
        <i class="entypo-install"></i>Manage Assignments   
    </button>  -->
    <?php echo form_close();?>

</div>
</div>
</div>
<script>        
    function onclasschange(class_id){
        jQuery('#section_holder').html('<option value="">Select Section</option>');
        $.ajax({
            url: '<?php echo base_url();?>index.php?teacher/get_teacher_section/' + class_id.value,
            success: function (response)
            {
                jQuery('#section_holder').append(response).selectpicker('refresh');
            }
        });
        $('#section_holder').trigger("chosen:updated");
    }
    
    function onsectionchange(section_id){
        jQuery('#subject_holder').html('<option value="">Select Subject</option>');
        $.ajax({
            url: '<?php echo base_url();?>/index.php?teacher/get_teacher_subject/' + section_id,
            success: function (response){
                jQuery('#subject_holder').append(response).selectpicker('refresh');
            }
        });
        $('#subject_holder').trigger("chosen:updated");
    }
    
    jQuery("#subject_holder").change(function () {
        var section=$("#section_holder option:selected").val();
        var subject=$("#subject_holder option:selected").val();
        var classname=$("#class_holder option:selected").val();
        location.href = "<?php echo base_url(); ?>index.php?teacher/manage_assignment_view/"+classname+"/"+section+"/"+subject;
    });
</script>