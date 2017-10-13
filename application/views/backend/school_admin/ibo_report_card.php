<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('report_card'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase('report_card'); ?></li>
        </ol>
    </div>
</div>


<div class="col-md-12 white-box">
<?php echo form_open(base_url() . 'index.php?school_admin/ibo_marksheet_selector/'); ?>
<div class="col-sm-4 form-group" data-step="5" data-intro="<?php echo get_phrase('Select a class.');?>" data-position='right'>
    <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('Select_Class');?><span class="error" style="color: red;"> *</span></label>
    <select class="selectpicker" data-style="form-control" data-live-search="true"   name="class_id"  onchange="select_section(this.value)" required>
        <option value=""><?php echo get_phrase('select_class'); ?></option>            
        <?php foreach($classes as $row1):?>
        <option value="<?php echo $row1['class_id'];?>"><?php echo get_phrase('class'); ?>&nbsp;<?php echo $row1['name'];?></option>
        <?php endforeach;?>
    </select> 
    <label style="color:red;"> <?php echo form_error('class_id'); ?></label>
</div>

<div class="col-sm-4 form-group" data-step="6" data-intro="<?php echo get_phrase('Select a section.');?>" data-position='top'>
    <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_section');?><span class="error" style="color: red;"> *</span></label>       
    <select name="section_id" class="selectpicker" data-style="form-control" data-live-search="true" id="section_holder" required>
        <option value=""><?php echo get_phrase('select_section'); ?></option>
    </select> 
    <label style="color:red;"> <?php echo form_error('section_id'); ?></label>
</div>   

<div class="col-sm-4 form-group" data-step="7" data-intro="<?php echo get_phrase('Select Student whose report card you want to see.');?>" data-position='top'>
    <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_student');?><span class="error" style="color: red;"> *</span></label>
    <select name="student_id" class="selectpicker" data-style="form-control" data-live-search="true" id="student_holder" required>
        <option value=""><?php echo get_phrase('select_student'); ?></option>
    </select> 
    <label style="color:red;"> <?php echo form_error('student_id'); ?></label>
</div>      

<input type="hidden" name="year" value="<?php echo $running_year;?>">
<div class="text-right col-xs-12" >
    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="8" data-intro="<?php echo get_phrase('Click to view report.');?>" data-position='left'><?php echo get_phrase('view_marksheet');?></button>
</div>
<?php echo form_close(); ?>
</div>

<script type="text/javascript">
    function select_section(class_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_sections_by_class/' + class_id,
            success:function (response){//alert(response);
                jQuery('#section_holder').html(response).selectpicker('refresh');
            }
        });

        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_class_students/' + class_id,
            success:function (response){//alert(response););

                jQuery('#student_holder').html(response).selectpicker('refresh');
            }
        });
    }
</script>