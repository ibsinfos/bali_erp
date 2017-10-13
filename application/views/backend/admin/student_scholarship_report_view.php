<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('view_student_scholarship_report'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?student_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase('view_student_scholarship_report'); ?></li>
        </ol>
    </div>
</div>

<div class="col-md-12 white-box">
    <?php echo form_open(base_url() . 'index.php?admin/student_scholarship_report_selector/'); ?>
     <div class="col-sm-4 form-group">
        <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('All_School');?></label>
        
        <?php //echo $schools_id." Jesus"; exit;?><select  class="selectpicker" data-style="form-control" data-live-search="true" name="school_id"  onchange="select_class(this.value)">
            <option value=" "><?php echo get_phrase('All_school'); ?></option>            
            <?php foreach($schools as $row1):?>
            <option value="<?php echo $row1['school_id'];?>" <?php if($schools_id == $row1['school_id']){ echo "selected";} ?> ><?php echo get_phrase('school'); ?>&nbsp;<?php echo $row1['name'];?></option>
            <?php endforeach;?>
        </select> 
        <label style="color:red;"> <?php echo form_error('school_id'); ?></label>
    </div>
    <div class="col-sm-4 form-group">
        <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('Select_Class');?></label>
        <select  class="selectpicker" data-style="form-control" data-live-search="true" name="class_id"  onchange="select_section(this.value)">
            <option value=" "><?php echo get_phrase('select_class'); ?></option>            
            <?php foreach($classes as $row1):?>
            <option value="<?php echo $row1['class_id'];?>" <?php if($class_id == $row1['class_id']){ echo "selected";} ?> ><?php echo get_phrase('class'); ?>&nbsp;<?php echo $row1['name'];?></option>
            <?php endforeach;?>
        </select> 
        <label style="color:red;"> <?php echo form_error('class_id'); ?></label>
    </div>
    <div class="col-sm-4 form-group">
        <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_section');?></label>        
        <select name="section_id" class="selectpicker" data-style="form-control" data-live-search="true" id="section_holder">
            <option value=" "><?php echo get_phrase('select_section'); ?></option> 
            <?php 
                $selected               =   '';
                foreach($sections as $key=>$section) {
                $selected              =   ($section_id == $section['section_id'] ? 'selected' : '' ); ?>
                <option <?php echo $selected ?> value="<?php echo $section['section_id']; ?>"><?php echo $section['name']; ?></option>
            <?php  } ?>
        </select> 
        <label style="color:red;"> <?php echo form_error('section_id'); ?></label>
    </div>
     
    <input type="hidden" name="year" value="<?php echo $running_year;?>">
    <div class="text-right col-xs-12" >
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="5" data-intro="Click here to view the report" data-position='left'><?php echo get_phrase('VIEW REPORT');?></button>
    </div>
    <?php echo form_close(); ?>
</div>          
  
<div class="row">
<div class="col-sm-12 white-box">    
         
<table id="example23" class="display nowrap" cellspacing="0" width="100%">
    <thead>
        <tr>
                            <th><div><?php echo get_phrase('sl_no.');?></div></th>
                            <th><div><?php echo get_phrase('Name'); ?></div></th>                            
                            <th><div><?php echo get_phrase('Scholarship Name'); ?></div></th>                            
                            <th><div><?php echo get_phrase("Deduction Type"); ?></div></th>                            
                            <th><div><?php echo get_phrase('Deduction Value'); ?></div></th>
                        </tr>
                    </thead>
                    <tbody><?php
                    //pre($all_students);die;
                    $n = 1;
                    //$AllMale = 0;
                    //$AllFemale = 0;
                    // print_r($sholarship_records);
                    if(count($sholarship_records)>0){
                    foreach ($sholarship_records as $row){ 
                        //pre($row);
                        ?>
                        <tr>
                            <td><?php echo $n++;?></td>
                            <td><?php echo $row->account; ?></td>
                            <td><?php echo $row->scholarship_name;?></td>
                            <td><?php if($row->deduction_type == "1")echo "Amount"; else if($row->deduction_type == "2") echo "Percentage";?></td>
                            <td><?php echo ($row->deduction_type);?></td>
                    </tr><?php }
                    } else {?> 
                        <tr><td colspan="5" align="center">No data Available</td>
                    <?php }?>
                    </tbody>
                    
                </table>
</div>                     
</div>



<script type="text/javascript">
    function select_section(class_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_sections_by_class/' + class_id,
            success:function (response){
                jQuery('#section_holder').html(response).selectpicker('refresh');
            }
        });
    }


    $(function () {
         $("[data-toggle='tooltip']").tooltip();
    });
</script>

