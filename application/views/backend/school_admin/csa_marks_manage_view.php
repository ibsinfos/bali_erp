<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('manage_Co-Scholastic_marks'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase('manage_Co-Scholastic_marks'); ?></li>
        </ol>
    </div>
</div>

<?php//echo ($term); die(); ?>

<div class="col-md-12 white-box">
<?php echo form_open(base_url() . 'index.php?school_admin/csa_marks_selector/'); ?>
<div class="col-sm-4 form-group" data-step="5" data-intro="<?php echo get_phrase('Select a class want to see grade for.');?>" data-position='right'>
    <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('Select_Class');?><span class="error" style="color: red;"> *</span></label>
    <select class="selectpicker" data-style="form-control" data-live-search="true"   name="class_id"  onchange="select_section(this.value)" required>
        <option value=""><?php echo get_phrase('select_class');?></option>
                <?php
                    foreach($classes as $row):
                ?>
                <option value="<?php echo $row['class_id'];?>"
                    <?php if($class_id == $row['class_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                <?php endforeach;?>
        <?php //endforeach;?>
    </select> 
    <label style="color:red;"> <?php echo form_error('class_id'); ?></label>
</div>

 

<div class="col-sm-4 form-group" data-step="6" data-intro="<?php echo get_phrase('Select an Activity you want to grade for');?>" data-position='top'>
    <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_activity');?><span class="error" style="color: red;"> *</span></label>
    <select name="cs_activity" class="selectpicker" data-style="form-control" data-live-search="true" id="cs_activity_holder" required>
        <?php 
            foreach($cs_activities as $row):
        ?>
                    <option value="<?php echo $row['csa_id'];?>"
                        <?php if($csa_id == $row['csa_id']) echo 'selected';?>>
                            <?php echo $row['csa_name'];?>
                    </option>
                    <?php endforeach;?>
    </select> 
    <label style="color:red;"> <?php echo form_error('cs_activity'); ?></label>
</div> 

<div class="col-sm-4 form-group" data-step="7" data-intro="<?php echo get_phrase('Select a term you want to grade for');?>" data-position='top'>
    <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_term');?><span class="error" style="color: red;"> *</span></label>       
    <select name="term" class="selectpicker" data-style="form-control" data-live-search="true" required>
        <option value=""><?php echo get_phrase('select_term'); ?></option>
        <option value="1" <?php if($term == 1){ ?> selected = 'selected' <?php } ?>>Term 1</option>
        <option value="2" <?php if($term == 2){ ?> selected = 'selected' <?php } ?>>Term 2</option>
    </select> 
    <label style="color:red;"> <?php echo form_error('term'); ?></label>
</div>    

<input type="hidden" name="year" value="<?php echo $running_year;?>">
<div class="text-right col-xs-12" >
    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="8" data-intro="<?php echo get_phrase('Click to view report');?>" data-position='left'><?php echo get_phrase('MANAGE MARKS');?></button>
</div>
<?php echo form_close(); ?>
</div>

<div class="col-md-12 white-box" data-step="9" data-intro="<?php echo get_phrase('Here you cn see the list of section.');?>" data-position='top'> 
        <div class="text-center m-b-20">
             <h3><?php echo get_phrase('marks_for_co-Scholastic Activity');?></h3>
        </div>
<?php echo form_open(base_url() . 'index.php?school_admin/csa_marks_update/'.$class_id.'/'.$csa_id.'/'.$term);?>
<?php if(count($marks_of_students)){ ?>
<table class= "custom_table table display" cellspacing="0" width="100%" id="example23">

    <thead>
        <tr>
            <th><div><?php echo get_phrase('No');?></div></th>
            <th><div><?php echo get_phrase('roll');?></div></th>
            <th><div><?php echo get_phrase('name');?></div></th>
            <th><div><?php echo get_phrase('grade_obtained');?></div></th>
            <th><div><?php echo get_phrase('comment');?></div></th>
        </tr>
    </thead>
    <tbody>
    <?php 
        $count = 1; //pre($marks_of_students); die();
        foreach($marks_of_students as $row):
    ?>
        <tr>
            <td><?php echo $count++;?></td>
            <td>
                <?php 
                    $result=$row['result'][0];
                    //pre($result);
                    if ($result){
                        echo $result->enroll_id;
                    }
                    else
                    {
                        echo $row['student_id'];
                    }
                ?>
            </td>
            <td><?php echo ucwords(@$row['result1'][0]->name);?></td>
            <td>
                
                <select name="csa_grade_<?php echo $row['csa_grade_id'];?>" class="selectpicker" data-style="form-control" data-live-search="true">
                    <option <?php if($row['csa_grade'] =='A'){ ?> selected <?php } ?> value="<?php echo get_phrase('a'); ?>"    style="color: grey;">
                                <?php echo get_phrase('a'); ?>
                    </option>
                    <option <?php if($row['csa_grade'] =='B'){ ?> selected <?php  } ?>value="<?php echo get_phrase('b'); ?>"
                            style="color: grey">
                                <?php echo get_phrase('b'); ?>
                    </option>
                    <option <?php if($row['csa_grade'] =='C'){ ?> selected <?php  } ?> value="<?php echo get_phrase('c'); ?>"
                            style="color: grey">
                                <?php echo get_phrase('c'); ?>
                    </option>
                    <option <?php if($row['csa_grade'] =='D'){ ?> selected <?php  } ?> value="<?php echo get_phrase('d'); ?>"
                            style="color: grey">
                                <?php echo get_phrase('d'); ?>
                    </option>
                    <option <?php if($row['csa_grade'] =='E'){ ?> selected <?php  } ?> value="<?php echo get_phrase('e'); ?>"
                            style="color: grey">
                                <?php echo get_phrase('e'); ?>
                    </option>
                    
                </select>
            
            </td>
            <td>
                <input type="text" class="form-control" name="comment_<?php echo $row['csa_grade_id'];?>"
                    value="<?php echo $row['comment'];?>">
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div class="text-right col-xs-12 p-t-20">
    <button type="submit" onclick="handleClick();" class="fcbtn btn btn-danger btn-outline btn-1d">
        <?php echo get_phrase('update_marks'); ?>
    </button>
</div>
<?php } echo form_close(); ?>
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