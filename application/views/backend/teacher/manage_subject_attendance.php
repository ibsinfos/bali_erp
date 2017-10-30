<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('manage_daily_attendance'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
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
<?php echo form_open(base_url('index.php?teacher/subjectwise_attendance'));?>
<div class="col-md-12 white-box">
    <div class="col-sm-3 form-group" data-step="5" data-intro="<?php echo get_phrase('Select a Class from here!');?>" data-position='top'>
        <label for="field-1"><?php echo get_phrase('Select_Class');?><span class="error mandatory"> *</span></label>
        <select class="selectpicker" data-style="form-control" name="class_id" id="class_id" data-live-search="true" 
            onchange="get_class_sections_by_teacher(<?php echo $this->session->userdata('teacher_id');?>);">
            <option value=""><?php echo get_phrase('select_class'); ?></option>
            <?php foreach($classes as $cls){?>
                <option value="<?php echo $cls->class_id;?>"><?php echo get_phrase('class').' '.$cls->name;?></option>
            <?php };?>
        </select> 
        <label class="mandatory"> <?php echo form_error('class_id'); ?></label>
    </div>    

    <div class="col-sm-3 form-group" data-step="6" data-intro="<?php echo get_phrase('Select a section from here!');?>" data-position='top'>
        <label for="field-1"><?php echo get_phrase('select_section');?><span class="error mandatory"> *</span></label>       
        <select name="section_id" data-style="form-control" data-live-search="true" class="selectpicker" id="section_selector_holder"
            onchange="get_class_subjects_by_teachers(<?php echo $this->session->userdata('teacher_id');?>);">
            <option value=""><?php echo get_phrase('select_section'); ?></option>
        </select> 
        <label class="mandatory"> <?php echo form_error('section_id'); ?></label>
    </div>

    <div class="col-sm-3 form-group" data-step="6" data-intro="<?php echo get_phrase('Select a section from here!');?>" data-position='top'>
        <label for="field-1"><?php echo get_phrase('select_subject');?><span class="error mandatory"> *</span></label>       
        <select name="subject_id" class="selectpicker" data-style="form-control" data-live-search="true" id="subject_holder">
            <option value=""><?php echo get_phrase('select_subject'); ?></option>
        </select> 
        <label class="mandatory"><?php echo form_error('subject_id'); ?></label>
    </div>
    
    <div class="col-sm-3 form-group" data-step="7" data-intro="<?php echo get_phrase('Select a section from here!');?>" data-position='top'>               
        <label for="field-1"><?php echo get_phrase('select_date');?><span class="error mandatory"> *</span></label>
        <div class="input-group">
            <span class="input-group-addon"><i class="icon-calender"></i></span>
          <input type="text" id="mydatepicker_holiday_disable" class="form-control" name="date" value="<?php echo date('m/d/Y')?>" 
          placeholder="<?php echo get_phrase('select_date');?>">             
        </div>  
        <label class="mandatory"> <?php echo form_error('timestamp'); ?></label>
    </div> 
   
    <input type="hidden" name="year" value="<?php echo $running_year;?>">
    <div class="text-right col-xs-12">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="8" data-intro="<?php echo get_phrase('On the click of button, you will get a list of attendance.');?>" data-position='top'><?php echo get_phrase('MANAGE ATTENDANCE');?></button>
    </div> 
</div>
<?php echo form_close();?>

<?php 
$harr = array();
foreach($holidays as $key=>$holiday){
    $harr[] = date('m/d/Y',strtotime($holiday));
}
$hstring = implode("','",$harr);
$hstring = "'".$hstring."'";
?>

<script>
var hstring = "<?php echo $hstring; ?>";

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
    