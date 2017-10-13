<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('manage_CO-Scholastic_marks'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase('manage_Co-Scholastic_marks'); ?></li>
        </ol>
    </div>
</div>

<div class="row text-right">
    <div class="col-md-12">
        <a href="<?php echo base_url().'index.php?school_admin/exam_settings'; ?>">
             <button type="button" class="btn btn-danger btn-outline btn-circle m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="back">
                <i class="fa fa-reply"></i>
            </button>
        </a>
    </div>
</div>

<div class="clearfix">&nbsp;</div>

<div class="col-md-12 white-box">
<?php echo form_open(base_url() . 'index.php?school_admin/csa_marks_selector/'); ?>
<div class="col-sm-4 form-group" data-step="5" data-intro="<?php echo get_phrase('Select a class want to see grade for.');?>" data-position='right'>
    <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('Select_Class');?><span class="error" style="color: red;"> *</span></label>
    <select class="selectpicker" data-style="form-control" data-live-search="true"   name="class_id"  onchange="select_section(this.value)" required>
        <option value=""><?php echo get_phrase('select_class'); ?></option>            
        <?php foreach($classes as $row1):?>
        <option value="<?php echo $row1['class_id'];?>"><?php echo get_phrase('class'); ?>&nbsp;<?php echo $row1['name'];?></option>
        <?php endforeach;?>
    </select> 
    <label style="color:red;"> <?php echo form_error('class_id'); ?></label>
</div>

<!-- <div class="col-sm-4 form-group" data-step="6" data-intro="Select a section you want to grade for" data-position='top'>
    <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_section');?><span class="error" style="color: red;"> *</span></label>       
    <select name="section_id" class="form-control" id="section_holder" required>
        <option value=""><?php echo get_phrase('select_section'); ?></option>
    </select> 
    <label style="color:red;"> <?php echo form_error('section_id'); ?></label>
</div>  -->  

<div class="col-sm-4 form-group" data-step="6" data-intro="<?php echo get_phrase('Select an Activity you want to grade for.');?>" data-position='top'>
    <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_activity');?><span class="error" style="color: red;"> *</span></label>
    <select name="cs_activity" class="selectpicker" data-style="form-control" data-live-search="true" id="cs_activity_holder" required>
        <option value=""><?php echo get_phrase('select_activity'); ?></option>
    </select> 
    <label style="color:red;"> <?php echo form_error('cs_activity'); ?></label>
</div>  

<div class="col-sm-4 form-group" data-step="7" data-intro="<?php echo get_phrase('Select a term you want to grade for.');?>" data-position='top'>
    <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_term');?><span class="error" style="color: red;"> *</span></label>       
    <select name="term" class="selectpicker" data-style="form-control" data-live-search="true" required>
        <option value=""><?php echo get_phrase('select_term'); ?></option>
        <option value="1">Term 1</option>
        <option value="2">Term 2</option>
    </select> 
    <label style="color:red;"> <?php echo form_error('term'); ?></label>
</div>     

<input type="hidden" name="year" value="<?php echo $running_year;?>">
<div class="text-right col-xs-12" >
    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="8" data-intro="<?php echo get_phrase('Click to view report.');?>" data-position='left'><?php echo get_phrase('MANAGE MARKS');?></button>
</div>
<?php echo form_close(); ?>
</div>

<script type="text/javascript">
    function select_section(class_id) {
        /*$.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_sections_by_class/' + class_id,
            success:function (response){//alert(response);
                jQuery('#section_holder').html(response);
            }
        });
*/
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/cs_activities_class/' + class_id,
            success:function (response){//alert(response);
                jQuery('#cs_activity_holder').html(response).selectpicker('refresh');
            }
        });
    }
</script>