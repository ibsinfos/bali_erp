<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?admin/dashboard"><?php echo get_phrase('Student Fee Due Report'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_name); ?></li>
        </ol>
    </div>
</div>
<?php

if(empty($sch_id))
    $sch_id = '';
?>

<div class="col-md-12 white-box">
<?php echo form_open(base_url() . "index.php?admin/$page_name/"); ?>
<div class="col-sm-4 form-group" data-step="5" data-intro="Select a school want to see gender report" data-position='right'>
    <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('All_School');?><span class="error" style="color: red;"> *</span></label>
     
    <select  id="school_id" name="school_id"  class="selectpicker" data-style="form-control" data-live-search="true" required onchange="select_class(this.value)">
        <option value=""><?php echo get_phrase('All_school'); ?></option>            
        <?php 
        
        
        foreach($schools as $row1):?>
            <option value="<?php echo $row1['school_id'];?>"<?php if($row1['school_id'] == $sch_id)echo "selected";?>><?php echo get_phrase('school'); ?>&nbsp;<?php echo $row1['name'];?></option>
            <?php if($class_id !="")?>
        <?php endforeach;?>
    </select> 
    <label style="color:red;"> <?php echo form_error('school_id'); ?></label>
</div>
<div class="col-sm-4 form-group" data-step="6" data-intro="Select a class you want to see gender report" data-position='top'>
    <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_class');?><span class="error" style="color: red;"> *</span></label>       
    <select name="class_id"  class="selectpicker" data-style="form-control" data-live-search="true" id="class_holder" required  onchange="select_section(this.value)">
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
<div class="col-sm-4 form-group" data-step="6" data-intro="Select a section you want to see attendance report" data-position='top'>
    <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_section');?><span class="error" style="color: red;"> *</span></label>       
    <select name="section_id"  class="selectpicker" data-style="form-control" data-live-search="true" id="section_holder" required>
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

<input type="hidden" name="year" value="<?php echo $running_year;?>">
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
            <th><div><?php echo get_phrase('Student Name'); ?></div></th> 
            <th><div><?php echo get_phrase('Account'); ?></div></th>
            <th><div><?php echo get_phrase('Parent Email'); ?></div></th>                            
            <th><div><?php echo get_phrase("Phone"); ?></div></th>                            

            <th><div><?php echo get_phrase('DueDate'); ?></div></th>
        </tr>
    </thead>
    <tbody><?php
    $n = 1;
    if(isset($fee_due_records))
    {    
    if(count($fee_due_records)>0){
    foreach ($fee_due_records as $row){   ?>
        <tr>
            <td><?php echo $n++;?></td>
            <td><?php echo $row['fname']." ".$row['lname']; ?></td>
            <td><?php echo $row['account'];?></td>
            <td><?php  echo $row['parent_email'];?></td>
            <td><?php echo $row['phone'];?></td>
            <td><?php echo $row['duedate'];?></td>
    </tr><?php }
    } else {?> 
        <tr><td colspan="5" align="center">No data Available</td>
    <?php }
    }
    ?>
    </tbody>
</table>
</div>                     
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