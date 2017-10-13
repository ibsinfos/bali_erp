<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?admin/dashboard"><?php echo get_phrase('Student common Report'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
</div>

<div class="col-md-12 white-box">
<?php echo form_open(base_url() . "index.php?admin/$fn_name/$params"); ?>

<div class="col-sm-4 form-group" data-step="5" data-intro="Select a school want to see the report" data-position='right'>
    <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('Select_School');?></label>
   
    <select  id="school_id" name="school_id"  data-style="form-control" class="selectpicker" onchange="select_class(this.value)">
        <option value=""><?php echo get_phrase('select_school'); ?></option>            
        <?php foreach($schools as $row1):?>
            <option value="<?php echo $row1['school_id'];?>"<?php if($row1['school_id'] == $schools_id)echo "selected";?>><?php echo get_phrase('school'); ?>&nbsp;<?php echo $row1['name'];?></option>
            <?php if($class_id !="")?>
        <?php endforeach;?>
    </select> 
    <label style="color:red;"> <?php echo form_error('school_id'); ?></label>
</div>
    
<div class="col-sm-4 form-group" data-step="5" data-intro="From Date" data-position='right'>
    <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('Select_From_Date');?></label>
   
    <div class="input-group">
            <span class="input-group-addon"><i class="icon-calender"></i></span>
            <input type="text" class="form-control mydatepicker"  name="date_from" data-format="Y-m-d" value="">             
        </div>  
    <label style="color:red;"> <?php echo form_error('date_from'); ?></label>
</div>

<div class="col-sm-4 form-group" data-step="5" data-intro="To Date" data-position='right'>
    <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('Select_To_Date');?></label>
   
    <div class="input-group">
            <span class="input-group-addon"><i class="icon-calender"></i></span>
            <input type="text" class="form-control mydatepicker"  name="date_to" data-format="Y-m-d" value="">             
        </div>  
    <label style="color:red;"> <?php echo form_error('date_to'); ?></label>
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
        <?php if($schools_id == ""){?>
            <th><div><?php echo get_phrase('school_name'); ?></div></th>
            <th><div><?php echo get_phrase('account'); ?></div></th> 
            <th><div><?php echo get_phrase('expenses'); ?></div></th> 
        <?php } if(($schools_id != "")) {?>
            <th><div><?php echo get_phrase('account'); ?></div></th> 
            <th><div><?php echo get_phrase('expenses'); ?></div></th>
        <?php } ?>
         
    </thead>
    <tbody> 
        <?php 
        $n = 1;  
        //pre($res);
        if(count($res)>0){
            foreach ($res as $row){   ?>
                <tr>
                    <td><div><?php echo $n++; ?></div></td>
                    <?php if($schools_id == ""){?>
                                <td><div><?php echo $row['school']; ?></div></td>
                                <td><div><?php echo $row['account']; ?></div></td> 
                                <td><div><?php echo $row['dr']; ?></div></td> 
                    <?php } 
                            if(($schools_id != "") && (trim($class_id) == "")){?>
                                <td><div><?php echo $row['account']; ?></div></td> 
                                <td><div><?php echo $row['dr']; ?></div></td>
                    <?php } ?>
                </tr>
            <?php }
        }?>
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
</script>