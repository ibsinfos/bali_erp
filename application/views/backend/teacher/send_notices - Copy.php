<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('MANAGE NEW NOTICES'); ?></h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?teacher/noticeboard"><?php echo get_phrase('noticeboard'); ?></a></li>
            <li class="active">
                <?php echo get_phrase('new_notice'); ?>
            </li>
        </ol>
    </div>
</div>
<div class="row">
<div class="col-sm-12">    
    <div class="white-box" data-step="5" data-intro="<?php echo get_phrase('From here you can manage new notices.');?>" data-position='top'> 
        <?php echo form_open(base_url() . 'index.php?teacher/send_notices/create' , array('class' => 'validate'));?>
        <div class ="row">
            <div class="col-sm-6 form-group">
            <label for="field-2" class="control-label"><?php echo get_phrase('class'); ?><span class="error" style="color: red;"> *</span></label>
                <select name="class_id" data-style="form-control" data-live-search="true" class="selectpicker" id = "class_id"  onchange="window.location = this.options[this.selectedIndex].value">
                    <option value=" "><?php echo get_phrase('select_class'); ?></option>
                    <?php if(empty($class_uri)){ foreach ($teacher_class as $row): ?>
                    <option <?php if($class_id == $row['class_id']) {  echo 'selected'; } ?> value="<?php echo base_url(); ?>index.php?teacher/send_notices/get_sections/<?php echo $row['class_id']; ?>"><?php echo $row['class']; ?></option>
                    <?php endforeach;} else{ foreach ($teacher_class as $row):?>
                        <option <?php if($class_uri == $row['class_id']) {  echo 'selected'; } ?> value="<?php echo base_url(); ?>index.php?teacher/send_notices/get_sections/<?php echo $row['class_id']; ?>"><?php echo $row['class']; ?></option>
                    <?php endforeach; }  ?>
                </select> 
            <input type ="hidden" name ="get_class_id" value ="<?php echo $row['class_id']; ?>">
            <label class="mandatory"> <?php echo form_error('class_id'); ?></label>
            </div>
            
            <div class="col-sm-6 form-group">
            <label for="field-2" class="control-label"><?php echo get_phrase('section'); ?><span class="error" style="color: red;"> *</span></label>
                <select name="section_id" data-style="form-control" data-live-search="true" class="selectpicker" onchange="window.location = this.options[this.selectedIndex].value" required>
                    <option value=""><?php echo get_phrase('select_section'); ?></option>
                    <?php  if(empty($section_uri)){ foreach ($sections as $sec): ?>
                    <option value="<?php echo base_url(); ?>index.php?teacher/send_notices/get_students/<?php echo $class_uri. '/'.$sec['section_id']; ?>"><?php echo $sec['name']; ?></option>
                    <?php endforeach; }else{  foreach ($section_all as $sec): ?>
                     <option <?php if($section_uri == $sec['section_id']) {  echo 'selected'; } ?> value="<?php echo base_url(); ?>index.php?teacher/send_notices/get_students/<?php echo $class_uri. '/'.$sec['section_id']; ?>"><?php echo $sec['name']; ?></option>
                    <?php endforeach; } ?>
                </select>  
            <label class="mandatory"> <?php echo form_error('section_id'); ?></label>
            </div>                                                                                  
        </div>
        
        <div class ="row" >
            <div class="col-sm-6 form-group">
                <label for="field-1"><?php echo get_phrase('students');?><span class="error" style="color: red;"> *</span></label>
                <select name="student_id[]" data-style="form-control" data-live-search="true" class="selectpicker" multiple data-actions-box="true" >
                    <?php  foreach ($students as $stud): ?>
                        <option value="<?php echo $stud['student_id']; ?>"><?php echo $stud['name']; ?></option>
                    <?php endforeach;  ?>
                </select>
            </div>

            <div class="col-sm-6 form-group">
            <label for="field-2" class="control-label"><?php echo get_phrase('parents'); ?></label>
                <select name="parent_id[]" data-style="form-control" data-live-search="true" class="selectpicker" multiple data-actions-box="true">
                    <?php  foreach ($students as $stud): ?>
                    <option value="<?php echo $stud['parent_id']; ?>"><?php echo $stud['father_name']; ?></option>
                    <?php endforeach;  ?>
                </select>                                
            </div>                                                                                  
        </div>
        
        <div class ="row" >
            <div class="col-sm-12 form-group">
                <label for="field-1"><?php echo get_phrase('title');?><span class="error" style="color: red;"> *</span></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-tags"></i></div>
                    <input type="text" class="form-control" name="notice_title" placeholder="Enter a title" required/>                                        
                </div>
                <label class="mandatory"> <?php echo form_error('notice_title'); ?></label>
            </div>
        </div>
        <?php $date = date('Y-m-d H:i:s');?>
        <input type="hidden"  name="create_timestamp" value="<?php echo $date;?>"/>
        <div class="row">
            <div class="col-sm-12 form-group">
                <label for="field-1"><?php echo get_phrase('description');?><span class="error" style="color: red;"> *</span></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-newspaper-o"></i></div>
                    <textarea name="notice" id="ttt" rows="3" placeholder=" " class="form-control" required></textarea>                                        
                </div>
                <label class="mandatory"> <?php echo form_error('notice'); ?></label>                                
            </div>
        </div>
        
        <div class="text-right">
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" ><?php echo get_phrase('send_notice');?></button>
        </div>
        <?php echo form_close();?>
    </div>
</div>
</div>

<script>
    function get_class_sections_by_teacher(teacher_id) {
        var class_id = $('#class_id').val(); 
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?ajax_controller/get_class_sections_by_teachers/' + teacher_id +'/'+class_id,
            success: function (response) {
                jQuery('#section_selector_holder').html(response).selectpicker('refresh');
            }     
        });
    }
</script>