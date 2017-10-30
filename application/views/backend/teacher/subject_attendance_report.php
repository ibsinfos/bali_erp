<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('attendance_report'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" target="_blank" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
    </div>
</div>

<?php echo form_open(base_url('index.php?teacher/subject_attendance_report/')); ?>
<div class="col-md-12 white-box">
    <div class="row">
        <div class="col-sm-3 form-group" data-step="5" data-intro="<?php echo get_phrase('Select a Class from here!');?>" data-position='top'>
            <label for="field-1"><?php echo get_phrase('Select_Class');?><span class="error mandatory"> *</span></label>
            <select class="selectpicker" data-style="form-control" name="class_id" id="class_id" data-live-search="true" 
                onchange="get_class_sections_by_teacher(<?php echo $this->session->userdata('teacher_id');?>);">
                <option value=""><?php echo get_phrase('select_class'); ?></option>
                <?php foreach($classes as $cls){?>
                    <option value="<?php echo $cls->class_id;?>" <?php echo $cls->class_id==@$class_id?'selected':''?>>
                        <?php echo get_phrase('class').' '.$cls->name;?>
                    </option>
                <?php };?>
            </select> 
            <label class="mandatory"> <?php echo form_error('class_id'); ?></label>
        </div>    

        <div class="col-sm-3 form-group" data-step="6" data-intro="<?php echo get_phrase('Select a section from here!');?>" data-position='top'>
            <label for="field-1"><?php echo get_phrase('select_section');?><span class="error mandatory"> *</span></label>       
            <select name="section_id" data-style="form-control" data-live-search="true" class="selectpicker" id="section_selector_holder"
                onchange="get_class_subjects_by_teachers(<?php echo $this->session->userdata('teacher_id');?>);">
                <option value=""><?php echo get_phrase('select_section'); ?></option>
                
                <?php foreach($sections as $sec){?>
                    <option value="<?php echo $sec->section_id;?>" <?php echo $sec->section_id==@$section_id?'selected':''?>><?php echo get_phrase('section').' '.$sec->name;?></option>
                <?php };?>
            </select> 
            <label class="mandatory"> <?php echo form_error('section_id'); ?></label>
        </div>

        <div class="col-sm-3 form-group" data-step="6" data-intro="<?php echo get_phrase('Select a section from here!');?>" data-position='top'>
            <label for="field-1"><?php echo get_phrase('select_subject');?><span class="error mandatory"> *</span></label>       
            <select name="subject_id" class="selectpicker" data-style="form-control" data-live-search="true" id="subject_holder">
                <option value=""><?php echo get_phrase('select_subject');?></option>
                <?php foreach($subjects as $sub){?>
                    <option value="<?php echo $sub->subject_id?>" <?php echo $sub->subject_id==@$subject_id?'selected':''?>><?php echo $sub->name?></option>    
                <?php }?>
            </select> 
            <label class="mandatory"><?php echo form_error('subject_id'); ?></label>
        </div>

        <div class="col-sm-3 form-group">
            <label for="field-1"><?php echo get_phrase('select_month');?><span class="error" style="color: red;"> *</span></label>
            <select data-style="form-control" data-live-search="true" class="selectpicker" name="month" data-live-search="true">
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
    </div>            
  
    <div class="row">  
        <input type="hidden" name="year" value="<?php echo $running_year;?>">
        <div class="text-right col-xs-12">
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('VIEW REPORT');?></button>
        </div>
    </div>
</div>
<?php echo form_close();?>

<script type="text/javascript">
function get_class_sections_by_teacher(teacher_id) {        
    var class_id = $('#class_id').val();
    $.ajax({
        url: '<?php echo base_url(); ?>index.php?ajax_controller/get_class_sections_by_teachers/' + teacher_id +'/'+class_id,
        success: function (response) {
            jQuery('#section_selector_holder').html(response)
            $('.selectpicker').selectpicker('refresh');
        }     
    });
}

function get_class_subjects_by_teachers(teacher_id) {        
    var class_id = $('#class_id').val(); 
    var section_id = $('select[name=section_id]').val();
    $.ajax({
        url: '<?php echo base_url('index.php?ajax_controller/get_class_subjects_by_teachers/');?>/'+teacher_id+'/'+class_id+'/'+section_id,
        success: function (response) {
            $('#subject_holder').html(response)
            $('.selectpicker').selectpicker('refresh');
        }     
    });
}
</script>
