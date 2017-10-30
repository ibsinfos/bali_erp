<link href="<?php echo base_url('assets/bower_components/malihu-custom-scrollbar/jquery.mCustomScrollbar.min.css')?>" rel="stylesheet">
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('view_attendance_report'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" target="_blank" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>

        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><?php echo get_phrase('daily_attendance'); ?>
                <ul>                    
                    <li><a href="<?php echo base_url(); ?>index.php?teacher/manage_attendance"><?php echo get_phrase('manage_attendance'); ?></a></li>
                </ul>
            </li>
            <li class="active">
                <?php echo get_phrase('attendance_report'); ?>
            </li>
        </ol>
    </div>
</div>

<?php echo form_open(base_url() . 'index.php?teacher/subject_attendance_report/'); ?>
<div class="col-md-12 white-box">
    <div class="row">
        <div class="col-sm-3 form-group" data-step="5" data-intro="<?php echo get_phrase('Select a Class from here!');?>" data-position='top'>
            <label for="field-1"><?php echo get_phrase('Select_Class');?><span class="error mandatory"> *</span></label>
            <select class="selectpicker" data-style="form-control" name="class_id" id="class_id" data-live-search="true" 
                onchange="get_class_sections_by_teacher(<?php echo $this->session->userdata('teacher_id');?>);">
                <option value=""><?php echo get_phrase('select_class'); ?></option>
                <?php foreach($classes as $cls){?>
                    <option value="<?php echo $cls->class_id;?>" <?php echo $cls->class_id==$class_id?'selected':''?>>
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
                    <option value="<?php echo $sec->section_id;?>" <?php echo $sec->section_id==$section_id?'selected':''?>><?php echo get_phrase('section').' '.$sec->name;?></option>
                <?php };?>
            </select> 
            <label class="mandatory"> <?php echo form_error('section_id'); ?></label>
        </div>

        <div class="col-sm-3 form-group" data-step="6" data-intro="<?php echo get_phrase('Select a section from here!');?>" data-position='top'>
            <label for="field-1"><?php echo get_phrase('select_subject');?><span class="error mandatory"> *</span></label>       
            <select name="subject_id" class="selectpicker" data-style="form-control" data-live-search="true" id="subject_holder">
                <option value=""><?php echo get_phrase('select_subject');?></option>
                <?php foreach($subjects as $sub){?>
                    <option value="<?php echo $sub->subject_id?>" <?php echo $sub->subject_id==$subject_id?'selected':''?>><?php echo $sub->name?></option>    
                <?php }?>
            </select> 
            <label class="mandatory"><?php echo form_error('subject_id'); ?></label>
        </div>

        <div class="col-sm-3 form-group">
            <label for="field-1"><?php echo get_phrase('select_month');?><span class="error" style="color: red;"> *</span></label>
            <select class="selectpicker" data-style="form-control" name="month" data-live-search="true">
                <?php $month_arr    =   array('1' => 'January', '2'=>'February', '3'=>'March', '4'=>'April', '5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December'); ?>          
                <?php foreach($month_arr as $key =>$val): ?>
                <option value="<?php echo $key; ?>" <?php if ($month == $key) echo 'selected'; ?> > <?php echo $val; ?></option>
                <?php endforeach;?>            
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
<?php echo form_open();?>
<div class="col-md-12 white-box">
    <?php if ($class_id != '' && $section_id != '' && $month != ''): ?>
    <div class="text-center" data-step="2" data-intro="<?php echo get_phrase('For Information');?>" data-position='bottom'>
        <h3><b><?php echo get_phrase('subject_attendance_for_class'); ?> <?php echo $class_name; ?> <?php echo get_phrase('section'); ?> <?php echo $section_name . " for the month of "?><?php echo $month_arr[$month];?></b></h3>
    </div>
    <?php endif; ?>

    <div class="m-scroll">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td class="text-center">
                        <?php echo get_phrase('students'); ?> <i class="fa fa-arrow-down"></i> | <?php echo get_phrase('date'); ?> <i class="fa fa-arrow-right"></i>
                    </td>
                    <?php                    
                        for ($i = 1; $i <= $days; $i++) { ?>
                        <td class="text-center"><?php echo $i; ?></td>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php echo $data; ?>
            </tbody>
        </table>
        <!--mobile view-->     
        <div class="view-table-scroll">
            <table class="table table-bordered table-in-mobile visible-sm visible-xs visible-md" id="my_table">
                <thead>
                    <tr>
                        <td class="text-center">
                            <?php echo get_phrase('students'); ?> <i class="fa fa-arrow-down"></i> | <?php echo get_phrase('date'); ?> <i class="fa fa-arrow-right"></i>
                        </td>
                        <?php                    
                            for ($i = 1; $i <= $days; $i++) { ?>
                            <td class="text-center"><?php echo $i; ?></td>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $data; ?>
                </tbody>
            </table>
        </div>   
        <!---End Of mobile View-->
    </div>
    
    <div class="text-right">
        <a href="<?php echo base_url('index.php?teacher/subject_attendance_report_print_view/'.$class_id.'/'.$section_id.'/'.$subject_id.'/'.$month);?>" 
           class="fcbtn btn btn-danger btn-outline btn-1d" target="_blank"><?php echo 'PRINT ATTENEDANCE REPORT';?>
        </a>
    </div>
</div>                

<script src="<?php echo base_url('assets/bower_components/malihu-custom-scrollbar/jquery.mCustomScrollbar.js')?>"></script>
<script type="text/javascript">
function select_section(class_id) {
        var teacher_id=<?php echo $this->session->userdata('teacher_id');?>;        
    $.ajax({
        url: '<?php echo base_url(); ?>index.php?ajax_controller/get_class_sections_by_teachers/'+ teacher_id +'/' + class_id,
        success: function (response) {
            jQuery('#section_holder').html(response).selectpicker('refresh');
        }
    });
}
$(function(){
    $('.m-scroll').mCustomScrollbar({axis:'x'});
})
</script>