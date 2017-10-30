<div class="row bg-title"> 
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?super_admin/dynamic_fields"><?php echo get_phrase('manage_fields'); ?></a></li>
            <li class="active"> <span><?php echo get_phrase($page_title); ?></span></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>            
<div class="col-md-12 white-box">
    <?php echo form_open(base_url() . 'index.php?super_admin/dynamic_fields/update/' .$edit_data->id, array('class' => ' form-groups-bordered validate', 'target' => '_top')); ?>
    <div class="row">          
        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('label'); ?><span class="error mandatory"> *</span></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-tag"></i></div>
               <input type="text" class="form-control" name="lable_name" value="<?php echo $edit_data->label; ?>"> 
            </div>                                        
        </div> 
        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-2"><?php echo get_phrase('database_field'); ?><span class="error mandatory"> *</span></label>
              <div class="input-group">
                <div  class="input-group-addon"><i class="fa fa-database"></i></div>
               <input  readonly type="text" class="form-control" name="db_field" value="<?php echo $edit_data->db_field; ?>" required=""> 
            </div>        
            <span></span>
        </div> 

        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('validation'); ?><span class="error mandatory"> *</span></label>
            <select  data-style="form-control" data-live-search="true" class="selectpicker" name="validation">
                <option value="">Please Select</option>              
                <option value="o" <?php if($edit_data->validation == 'o'){   ?>selected="" <?php }?>>Optional</option>             
                <option value="m" <?php if($edit_data->validation == 'm'){   ?>selected="" <?php }?>>Mandantory</option>
            </select>
            <span></span>
        </div>

        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('validation_type'); ?><span class="error mandatory"> *</span></label>
            <select data-style="form-control" data-live-search="true" class="selectpicker" name="validation_type">           
                <option>Please Select</option> 
                <option value="numeric" <?php if($edit_data->validation_type == 'numeric'){ ?> selected="" <?php } ?>>Numeric</option>
                <option value="alphabetic" <?php if($edit_data->validation_type == 'alphabetic'){ ?> selected="" <?php } ?>>Alphabetic</option>
                <option value="date" <?php if($edit_data->validation_type == 'date'){ ?> selected="" <?php } ?>>Date</option>
                <option value="email" <?php if($edit_data->validation_type == 'email'){ ?> selected="" <?php } ?>>Email</option>
                <option value="size" <?php if($edit_data->validation_type == 'size'){ ?> selected="" <?php } ?>>Size</option>
                <option value="required" <?php if($edit_data->validation_type == 'required'){ ?> selected="" <?php } ?>>Required</option>
           </select>
            <span></span>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('min_length'); ?></label>
           <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-long-arrow-down"></i></div>
                <input type="text" class="form-control" name="min_length" value="<?php echo $edit_data->min_length; ?>">
            </div>
            <span></span>
        </div>

        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('max_length'); ?></label>
           <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-long-arrow-up"></i></div>
                <input type="text" class="form-control" name="max_length" value="<?php echo $edit_data->max_length; ?>"> 
            </div>
            <span></span>
        </div>
    </div>
     <div class="row">
        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('field_type'); ?><span class="error mandatory"> *</span></label>
          <select data-style="form-control" data-live-search="true" class="selectpicker" name="field_type">           
                <option>Please Select</option> 
                <option value="text" <?php if($edit_data->field_type == 'text'){ ?> selected="" <?php } ?>>text</option>
                <option value="drop" <?php if($edit_data->field_type == 'drop'){ ?> selected="" <?php } ?>>drop</option>
                <option value="date" <?php if($edit_data->field_type == 'date'){ ?> selected="" <?php } ?>>date</option>
                <option value="email" <?php if($edit_data->field_type == 'email'){ ?> selected="" <?php } ?>>email</option>
                
           </select>
            <span></span>
        </div>

        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('field_values'); ?></label>
           <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-tag"></i></div>
                <input id= "register_date" type="text" class="form-control datepicker" value="<?php echo $edit_data->field_values; ?>"  name="field_values" placeholder="Field Values" data-validate="required" data-message-required ="Please field value">
            </div>
            <span></span>
        </div>
    </div>
    <div class="row">     
        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('group_name'); ?><span class="error mandatory"> *</span></label>
          <select class="form-control" name="group_name">           
                <option>Please Select</option> 
                <?php foreach ($group_name as $row):?>
                <option value="<?php echo $row['id']; ?>" <?php if($edit_data->group_id == $row['id']){ ?> selected="" <?php } ?>><?php echo $row['name'];?></option>
    <?php endforeach; ?>
           </select>
            <span></span>
        </div>
        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('order_id'); ?></label>
           <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></div>
                <input id= "vacating_date" type="text" class="form-control datepicker"  name="order_id" value="<?php echo $edit_data->order_id; ?>" placeholder="Field Table" data-validate="required" data-message-required ="Please field table">
            </div>
            <span></span>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('field_select'); ?></label>
           <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-tag"></i></div>
                <input id= "vacating_date" type="text" class="form-control datepicker"  name="field_select" value="<?php echo $edit_data->field_select; ?>" placeholder="Field Select" data-validate="required" data-message-required ="Please Field Select">
            </div>
            <span></span>
        </div>
        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('field_where'); ?></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-tags"></i></div>
                <input id= "vacating_date" type="text" class="form-control datepicker"  name="field_where" value="<?php echo $edit_data->field_where; ?>" placeholder="Field Where" data-validate="required" data-message-required ="Please Field Where"> 
            </div>
            <span></span>
        </div>
    </div>
      <div class="row">
        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('image'); ?></label>
           <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-file-image-o"></i></div>
                <input type="text" class="form-control" data-validate="required" id="image" name="image" placeholder="Please Enter image of field" data-message-required="<?php echo get_phrase('please_enter_required_value'); ?>"> 
            </div>
            <span></span>
        </div>
        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('place_holder'); ?></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-location-arrow"></i></div>
                <input id= "vacating_date" type="text" class="form-control datepicker"  name="place_holder" value="<?php echo $edit_data->place_holder; ?>" placeholder="Please Enter Placeholder" data-validate="required" data-message-required ="Please Placeholder"> 
            </div>
            <span></span>
        </div>
        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('form_name'); ?></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-location-arrow"></i></div>
                <select name="form_name" data-style="form-control" data-live-search="true" class="selectpicker" id="validation_select" required="required">
                <option value=""><?php echo get_phrase('select_form_name'); ?></option>
                <?php foreach($dynamic_form_list as $row1):  ?>            
                <option value="<?php echo $row1['id'];  ?>" <?php if($edit_data->form_id == $row1['id'] ) echo "selected"; ?>><?php echo get_phrase($row1['name']); ?></option>
                <?php endforeach;  ?>
               </select> 
            </div>
            <span></span>
        </div>  
    </div>
    
    <!--           
    <!----CREATION FORM ENDS-->
    <div class="text-right">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('update_field'); ?></button>
    </div>
    <?php echo form_close(); ?> 
</div>
<script type="text/javascript">
    function check_value(value){
        
        if(value == 'query'){
     
            document.getElementById("field_table").disabled = false;
     document.getElementById("field_select").disabled = false;
     document.getElementById("field_where").disabled = false;
 }
    }
</script>