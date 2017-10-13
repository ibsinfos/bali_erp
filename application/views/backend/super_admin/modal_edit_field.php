<script src="<?php echo base_url();?>assets/bower_components/dropify/dist/js/dropify.min.js"></script>
<script>
    $(document).ready(function() {
        $('.dropify').dropify();
    });
</script>
<?php // pre($edit_data); die; ?>
<div class="row">
    <div class="col-md-12">
        <h2>Edit Filed</h2>
        <div class="panel-body">
            <?php echo form_open(base_url() . 'index.php?super_admin/dynamic_fields/update/' .$edit_data->id, array('class' => 'form-horizontal form-material form-groups-bordered validate', 'target' => '_top')); ?>
               <div class="form-group">      
                <div class="col-md-6  form-group"> 
            <label for="field-1"><?php echo get_phrase('label'); ?><span class="error mandatory"> *</span></label>
            <input type="text" class="form-control" name="lable_name" value="<?php echo $edit_data->label; ?>">  
                </div>
         <div class="col-md-6 form-group">
            <label><?php echo get_phrase('DataBase_field'); ?></label>
            <input type="text" class="form-control" name="db_field" value="<?php echo $edit_data->db_field; ?>" required="">
         </div> 
        <div class="col-md-6 form-group">
            <label><?php echo get_phrase('validation'); ?></label>
            <select  data-style="form-control" data-live-search="true" class="selectpicker" name="validation">
                <option value="">Please Select</option>              
                <option value="o" <?php if($edit_data->validation == 'o'){   ?>selected="" <?php }?>>Optional</option>             
                <option value="m" <?php if($edit_data->validation == 'm'){   ?>selected="" <?php }?>>Mandantory</option>
            </select>
        </div> 
        <div class="col-md-6 form-group">
            <label><?php echo get_phrase('validation_type'); ?></label>        
           <select data-style="form-control" data-live-search="true" class="selectpicker" name="validation_type">           
                <option>Please Select</option> 
                <option value="numeric" <?php if($edit_data->validation_type == 'numeric'){ ?> selected="" <?php } ?>>Numeric</option>
                <option value="alphabetic" <?php if($edit_data->validation_type == 'alphabetic'){ ?> selected="" <?php } ?>>Alphabetic</option>
                <option value="date" <?php if($edit_data->validation_type == 'date'){ ?> selected="" <?php } ?>>Date</option>
                <option value="email" <?php if($edit_data->validation_type == 'email'){ ?> selected="" <?php } ?>>Email</option>
                <option value="size" <?php if($edit_data->validation_type == 'size'){ ?> selected="" <?php } ?>>Size</option>
                <option value="required" <?php if($edit_data->validation_type == 'required'){ ?> selected="" <?php } ?>>Required</option>
           </select>
        </div> 
        <div class="col-md-6 form-group">
            <label><?php echo get_phrase('min_length'); ?></label>
           <input type="text" class="form-control" name="min_length" value="<?php echo $edit_data->min_length; ?>">
        </div> 
        <div class="col-md-6 form-group">
            <label><?php echo get_phrase('max_length'); ?></label>
           <input type="text" class="form-control" name="max_length" value="<?php echo $edit_data->max_length; ?>">
        </div>
        <div class="col-md-6 form-group">
            <label><?php echo get_phrase('field_type'); ?></label>
            <input type="text" class="form-control" name="field_type" value="<?php echo $edit_data->field_type; ?>">
        </div>
        
        <div class="col-md-6 form-group">
            <label><?php echo get_phrase('field_values'); ?></label><span class="error mandatory" > *</span>
             <input id= "register_date" type="text" class="form-control datepicker" value="<?php echo $edit_data->field_values; ?>"  name="field_values" placeholder="Field Values" data-validate="required" data-message-required ="Please field value">
        </div>
        <div class="col-md-6 form-group">
            <label><?php echo get_phrase('field_table'); ?></label><span class="error mandatory" > *</span>
             <input id= "vacating_date" type="text" class="form-control datepicker"  name="field_table" value="<?php echo $edit_data->field_table; ?>" placeholder="Field Table" data-validate="required" data-message-required ="Please field table">
        </div>
        <div class="col-md-6 form-group">
            <label><?php echo get_phrase('group_name'); ?></label><span class="error mandatory" > *</span>
            <select class="form-control" name="group_name">           
                <option>Please Select</option> 
                <?php foreach ($group_name as $row):?>
                <option value="<?php echo $row['id']; ?>" <?php if($edit_data->group_id == $row['id']){ ?> selected="" <?php } ?>><?php echo $row['name'];?></option>
    <?php endforeach; ?>
           </select>
             
        </div>
        <div class="col-md-6 form-group">
            <label><?php echo get_phrase('order_ID'); ?></label><span class="error mandatory" > *</span>
             <input id= "vacating_date" type="text" class="form-control datepicker"  name="order_id" value="<?php echo $edit_data->order_id; ?>" placeholder="Field Table" data-validate="required" data-message-required ="Please field table">
        </div>
       <div class="col-md-6 form-group">
            <label><?php echo get_phrase('field_select'); ?></label><span class="error mandatory" > *</span>
             <input id= "vacating_date" type="text" class="form-control datepicker"  name="field_select" value="<?php echo $edit_data->field_select; ?>" placeholder="Field Select" data-validate="required" data-message-required ="Please Field Select">
        </div>
        <div class="col-md-6 form-group">
            <label><?php echo get_phrase('field_where'); ?></label><span class="error mandatory" > *</span>
             <input id= "vacating_date" type="text" class="form-control datepicker"  name="field_where" value="<?php echo $edit_data->field_where; ?>" placeholder="Field Where" data-validate="required" data-message-required ="Please Field Where">
        </div>
        <div class="col-md-6 form-group">
            <label><?php echo get_phrase('image'); ?></label><span class="error mandatory" > *</span>
             <input id= "vacating_date" type="text" class="form-control datepicker"  name="image" value="<?php echo $edit_data->image; ?>" placeholder="Field Select" data-validate="required" data-message-required ="Please Field Select">
        </div>
        <div class="col-md-6 form-group">
            <label><?php echo get_phrase('placeholder'); ?></label><span class="error mandatory" > *</span>
             <input id= "vacating_date" type="text" class="form-control datepicker"  name="place_holder" value="<?php echo $edit_data->place_holder; ?>" placeholder="Please Enter Placeholder" data-validate="required" data-message-required ="Please Placeholder">
        </div>
        <div class="col-md-6 form-group">
            <label><?php echo get_phrase('form_name'); ?></label><span class="error mandatory" > *</span>
            <select name="form_name" data-style="form-control" data-live-search="true" class="selectpicker" id="validation_select" required="required">
                <option value=""><?php echo get_phrase('select_form_name'); ?></option>
                <?php foreach($dynamic_form_list as $row1):  ?>            
                <option value="<?php echo $row1['id'];  ?>" <?php if($edit_data->form_id == $row1['id'] ) echo "selected"; ?>><?php echo get_phrase($row1['name']); ?></option>
                <?php endforeach;  ?>
            </select>
             
        </div>
        </div>
                <div class="form-group">
                    <div class="col-md-12 text-right">
                          <button type="submit"  class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><?php echo get_phrase('update'); ?></button>
                    </div>
                </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>