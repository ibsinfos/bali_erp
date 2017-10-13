<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?admin/student_leave_report"><?php echo get_phrase('Student Leave Report'); ?></a></li>
            <li class="active"><?php echo get_phrase('view_student_leave_report'); ?></li>
        </ol>
    </div>
</div>


<div class="col-md-12 white-box">
<?php echo form_open(base_url() . 'index.php?admin/student_leave_report_selector/'); ?>
<div class="col-sm-4 form-group" data-step="5" data-intro="Select a school want to see leave report" data-position='right'>
    <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('All_School');?><span class="error" style="color: red;"> *</span></label>
    <select  name="school_id" class="selectpicker" data-style="form-control" data-live-search="true" required onchange="select_class(this.value)">
        <option value=""><?php echo get_phrase('All_school'); ?></option>            
        <?php foreach($schools as $row1):?>
        <option value="<?php echo $row1['school_id'];?>"><?php echo get_phrase('school'); ?>&nbsp;<?php echo $row1['name'];?></option>
        <?php endforeach;?>
    </select> 
    <label style="color:red;"> <?php echo form_error('school_id'); ?></label>
</div>
<div class="col-sm-4 form-group" data-step="6" data-intro="Select a class you want to see leave report" data-position='top'>
    <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_class');?><span class="error" style="color: red;"> *</span></label>       
    <select name="class_id"  class="selectpicker" data-style="form-control" data-live-search="true" id="class_holder" required  onchange="select_section(this.value)">
        <option value=""><?php echo get_phrase('select_class'); ?></option>
    </select> 
    <label style="color:red;"> <?php echo form_error('class_id'); ?></label>
</div> 
<div class="col-sm-4 form-group" data-step="6" data-intro="Select a section you want to see leave report" data-position='top'>
    <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_section');?><span class="error" style="color: red;"> *</span></label>       
    <select name="section_id"   class="selectpicker" data-style="form-control" data-live-search="true" id="section_holder" required>
        <option value=""><?php echo get_phrase('select_section'); ?></option>
    </select> 
    <label style="color:red;"> <?php echo form_error('section_id'); ?></label>
</div>   

<div class="col-sm-4 form-group" data-step="7" data-intro="Select a month you want to see leave report" data-position='top'>
    <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_month');?><span class="error" style="color: red;"> *</span></label>
    <select  class="selectpicker" data-style="form-control" data-live-search="true" name="month" required >
        <option value=""><?php echo get_phrase('select_month'); ?></option>
        <option value="1"><?php echo get_phrase('January'); ?></option>
        <option value="2"><?php echo get_phrase('February'); ?></option>
        <option value="3"><?php echo get_phrase('March'); ?></option>
        <option value="4"><?php echo get_phrase('April'); ?></option>
        <option value="5"><?php echo get_phrase('May'); ?></option>
        <option value="6"><?php echo get_phrase('June'); ?></option>
        <option value="7"><?php echo get_phrase('July'); ?></option>
        <option value="8"><?php echo get_phrase('August'); ?></option>
        <option value="9"><?php echo get_phrase('September'); ?></option>
        <option value="10"><?php echo get_phrase('October'); ?></option>
        <option value="11"><?php echo get_phrase('November'); ?></option>
        <option value="12"><?php echo get_phrase('December'); ?></option>            
    </select> 
    <label style="color:red;"> <?php echo form_error('month'); ?></label>
</div>    

<input type="hidden" name="year" value="<?php echo $running_year;?>">
<div class="text-right col-xs-12" >
    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="8" data-intro="Click to view report" data-position='left'><?php echo get_phrase('VIEW REPORT');?></button>
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
    }
    function select_class(school_id) { 
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_class_by_school/' + school_id,
            success:function (response){//alert(response);
                jQuery('#class_holder').html(response).selectpicker('refresh');
            }
        });
    }
</script>