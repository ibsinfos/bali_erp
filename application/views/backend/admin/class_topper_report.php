<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('class_topper_report'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?admin/dashboard"><?php echo get_phrase('Class Topper Report'); ?></a></li>
            <li class="active"><?php echo get_phrase('view_class_topper_report'); ?></li>
        </ol>
    </div>
</div>


<div class="col-md-12 white-box">
<?php echo form_open(base_url() . 'index.php?admin/class_topper_report/'); ?>
<div class="col-sm-4 form-group" data-step="5" data-intro="Select a school want to see topper report" data-position='right'>
    <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('Select_School');?><span class="error" style="color: red;"> *</span></label>
    <select  id="school_id" name="school_id" data-style="form-control" class="selectpicker" required onchange="select_class(this.value)">
        <option value=""><?php echo get_phrase('select_school'); ?></option>            
        <?php foreach($schools as $row1):?>
            <option value="<?php echo $row1['school_id'];?>"<?php if($row1['school_id'] == $school_id)echo "selected";?>><?php echo get_phrase('school'); ?>&nbsp;<?php echo $row1['name'];?></option>
            <?php if($class_id !="")?>
        <?php endforeach;?>
    </select> 
    <label style="color:red;"> <?php echo form_error('school_id'); ?></label>
</div>
<div class="col-sm-4 form-group" data-step="6" data-intro="Select a class you want to see topper report" data-position='top'>
    <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_class');?><span class="error" style="color: red;"> *</span></label>       
    <select name="class_id" data-style="form-control" class="selectpicker" id="class_holder" required  onchange="select_section(this.value)">
       <?php if(!empty($classes)) {?>
           <?php foreach($classes as $row1):?>
            <option value="<?php echo $row1['class_id'];?>"<?php if($row1['class_id'] == $class_id)echo "selected";?>>&nbsp;<?php echo $row1['name'];?></option>
            
             <?php endforeach;?>

           <?php } else {?>
        <option value=""><?php echo get_phrase('select_class'); ?></option>
        <?php }?>
    </select> 
    <label style="color:red;"> <?php echo form_error('class_id'); ?></label>
</div> 
<div class="col-sm-4 form-group" data-step="6" data-intro="Select a section you want to see topper report" data-position='top'>
    <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_section');?><span class="error" style="color: red;"> *</span></label>       
    <select name="section_id" data-style="form-control" class="selectpicker" id="section_holder" required  onchange="select_exam(this.value)">
       <?php if(!empty($sections)) {?>
           <?php foreach($sections as $row1):?>
            <option value="<?php echo $row1['section_id'];?>"<?php if($row1['section_id'] == $section_id)echo "selected";?>>&nbsp;<?php echo $row1['name'];?></option>
            
             <?php endforeach;?>

           <?php } else {?>
        <option value=""><?php echo get_phrase('select_section'); ?></option>
        <?php }?>
    </select> 
    <label style="color:red;"> <?php echo form_error('section_id'); ?></label>
</div> 
<div class="col-sm-4 form-group" data-step="6" data-intro="Select a exam you want to see topper report" data-position='top'>
    <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_exam');?><span class="error" style="color: red;"> *</span></label>       
  <?=$exam_id;?>  <select name="exam_id" data-style="form-control" class="selectpicker" id="exam_holder" required  onchange="select_ranking(this.value)">
       <?php if(!empty($exams)) {?>
           <?php foreach($exams as $row1):?>
            <option value="<?php echo $row1['exam_id'];?>"<?php if($row1['exam_id'] == $exam_id)echo "selected";?>>&nbsp;<?php echo $row1['name'];?></option>
            
             <?php endforeach;?>

           <?php } else {?>
        <option value=""><?php echo get_phrase('select_exam'); ?></option>
        <?php }?>
    </select> 
    <label style="color:red;"> <?php echo form_error('exam_id'); ?></label>
</div>
<input type="hidden" name="year" value="<?php echo $running_year;?>">
<input type="hidden" id="clid" value="">
<div class="text-right col-xs-12" >
    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="8" data-intro="Click to view report" data-position='left'><?php echo get_phrase('VIEW REPORT');?></button>
</div>
<?php echo form_close(); ?>
</div>
<div class="row">
<div class="col-sm-12 white-box">    
          
<table id="example23" class="display nowrap" cellspacing="0" width="100%">
    <thead>
        <tr>
                            <th><div><?php echo get_phrase('sl_no.');?></div></th>
                            <th><div><?php echo get_phrase('student_name'); ?></div></th>                            
                            <th><div><?php echo get_phrase('email'); ?></div></th>                            
<!--                            <th><div><?php echo get_phrase("Male"); ?></div></th>                            
                            <th><div><?php echo get_phrase('Female'); ?></div></th>
                            <th><div><?php echo get_phrase('Total'); ?></div></th>-->
                        </tr>
                    </thead>
                    <tbody><?php
                    //pre($all_students);die;
                    $n = 1;
                    //$AllMale = 0;
                    //$AllFemale = 0;
                    // print_r($sholarship_records);
                    
                    if(count($rs)>0){
                    foreach ($rs as $row){   ?>
                        <tr>
                            <td><?php echo $n++;?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email'];?></td>
<!--                            <td><?php  echo $row['male_count'];?></td>
                            <td><?php echo ($row['female_count']);?></td>
                            <td><?php echo ($row['male_count']+$row['female_count']);?></td>-->
                    </tr><?php }
                    } else {?> 
                        <tr><td colspan="5" align="center">No data Available</td>
                    <?php }?>
                    </tbody>
                    
                </table>
</div>                     
</div>
<script type="text/javascript">
    
    function select_class(school_id) { 
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_class_by_school/' + school_id,
            success:function (response){//alert(response);
                jQuery('#class_holder').html(response).selectpicker('refresh');
            }
        });
    }
    function select_exam(section_id) { 
        var class_id = $("#clid").val();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_exam_by_section/' + section_id+'/'+class_id,
            success:function (response){//alert(response);
                jQuery('#exam_holder').html(response).selectpicker('refresh');
            }
        });
    }
    function select_section(class_id) { 
         
        $("#clid").val(class_id);
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_sections_by_class/' + class_id,
            success:function (response){//alert(response);
                jQuery('#section_holder').html(response).selectpicker('refresh');
            }
        });
    }
</script>