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
    <?php echo form_open(base_url() . 'index.php?super_admin/dynamic_fields/create', array('class' => ' form-groups-bordered validate', 'target' => '_top')); ?>
	<div class="row">
        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('form_id'); ?></label>
           <select onchange="ajax_get_data(this.options[this.selectedIndex].innerHTML)" name="form_name" data-style="form-control" data-live-search="true" class="selectpicker" id="validation_select" required="required">
                <option value=""><?php echo get_phrase('select_form_name'); ?></option>
                <?php foreach($dynamic_form_list as $row1):  ?>            
                <option value="<?php echo $row1['id'];  ?>"><?php echo get_phrase($row1['name']); ?></option>
                <?php endforeach;  ?>
            </select>
            <span></span>
        </div>      
    </div>
    <div class="row">          
        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('label'); ?><span class="error mandatory"> *</span></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-tag"></i></div>
               <input type="text" class="form-control" data-validate="required" required="required" id="exampleInputuname" placeholder="Label Name" name="lable_name" data-message-required="<?php echo get_phrase('please_enter_required_value'); ?>"> 
            </div>                                        
        </div> 
        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-2"><?php echo get_phrase('database_field'); ?><span class="error mandatory"> *</span></label>
              <?php /*<div class="input-group">
                <div class="input-group-addon"><i class="fa fa-database"></i></div>
               <input type="text" class="form-control" data-validate="required" required="required" id="exampleInputuname" placeholder="Database Field" name="db_field" data-message-required="<?php echo get_phrase('please_enter_required_value'); ?>"> 
            </div>        
            <span></span>
        </div> */ ?>
		<select  name="db_field" data-style="form-control" data-live-search="true" class="selectpicker" id="dbfield" required="required">
                <option value=""><?php echo get_phrase('select_form_first'); ?></option>
                
            </select>
</div>
        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('validation'); ?><span class="error mandatory"> *</span></label>
            <select name="validation" data-style="form-control" data-live-search="true" class="selectpicker" id="validation_select" required="required">
                <option value=""><?php echo get_phrase('select_validation'); ?></option>
                <option value="m"><?php echo get_phrase('mandantory'); ?></option>
                <option value="o"><?php echo get_phrase('optional'); ?></option>
            </select>
            <span></span>
        </div>

        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('validation_type'); ?><span class="error mandatory"> *</span></label>
            <select name="validation_type" data-style="form-control" data-live-search="true" class="selectpicker" required="required">     
                <option value="">Select Validation Type</option>
                <option value="numeric">Numeric</option>
                <option value="alphabetic">Alphabetic</option>
                <option value="date">Date</option>
                <option value="email">Email</option>
                <option value="size">Size</option>
                <option value="required">Required</option>
            </select>
            <span></span>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('min_length'); ?></label>
           <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-long-arrow-down"></i></div>
                <input type="text" class="form-control" data-validate="required"  id="min_length" placeholder="Min Length" name="min_length" data-message-required="<?php echo get_phrase('please_enter_required_value'); ?>"> 
            </div>
            <span></span>
        </div>

        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('max_length'); ?></label>
           <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-long-arrow-up"></i></div>
                <input type="text" class="form-control" data-validate="required"  id="max_length" placeholder="Max Length" name="max_length" data-message-required="<?php echo get_phrase('please_enter_required_value'); ?>"> 
            </div>
            <span></span>
        </div>
    </div>
     <div class="row">
        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('field_type'); ?><span class="error mandatory"> *</span></label>
          <select name="field_type" data-style="form-control" data-live-search="true" class="selectpicker" required="required">    
                <option value="">Select Field Type</option>
                <option value="text">Text</option>
                <option value="email">Email</option>
                <option value="date">Date</option>
                <option value="drop">Drop</option>
            </select>
            <span></span>
        </div>

        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('field_values'); ?></label>
           <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-tag"></i></div>
                <input type="text" class="form-control" data-validate="required" id="field_values" placeholder="Field Values" name="field_values" data-message-required="<?php echo get_phrase('please_enter_required_value'); ?>" onkeyup="check_value(this.value);"> 
            </div>
            <span></span>
        </div>
    </div>
      
<div class="row">
     <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('field_table'); ?><span class="error mandatory"> *</span></label>
           <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-table"></i></div>
                <input type="text" class="form-control" data-validate="required" disabled='disabled' required="required" id="field_table" placeholder="Field Table" name="field_table" data-message-required="<?php echo get_phrase('please_enter_required_value'); ?>"> 
            </div>
            <span></span>
        </div>
        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('enable'); ?><span class="error mandatory"> *</span></label>
          <select name="enable" data-style="form-control" data-live-search="true" class="selectpicker" required="required">
                <option value="">Please Select</option>
                <option value="Y">Yes</option>
                <option value="N">No</option>
          </select>
            <span></span>
        </div>
    </div>
    <div class="row">     
        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('group_name'); ?><span class="error mandatory"> *</span></label>
          <select name="group_id" data-style="form-control" data-live-search="true" class="selectpicker" required="required">     
              <option value="">Please Select Group</option> 
<?php foreach($group_name as $row):  ?>
              <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
<?php endforeach; ?>              
          </select>
            <span></span>
        </div>
        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('order_id'); ?></label>
           <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></div>
                <input type="text" class="form-control" data-validate="required" required="required" id="order_id" placeholder="Order ID" name="order_id" data-message-required="<?php echo get_phrase('please_enter_required_value'); ?>"> 
            </div>
            <span></span>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('field_select'); ?></label>
           <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-tag"></i></div>
                <input type="text" class="form-control" data-validate="required" disabled='disabled' id="field_select" name="field_select" placeholder="Field Select" data-message-required="<?php echo get_phrase('please_enter_required_value'); ?>"> 
            </div>
            <span></span>
        </div>
        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('field_where'); ?></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-tags"></i></div>
                <input type="text" class="form-control" data-validate="required" disabled='disabled' id="field_where" placeholder="Field Where" name="field_where" data-message-required="<?php echo get_phrase('please_enter_required_value'); ?>"> 
            </div>
            <span></span>
        </div>
    </div>
      <div class="row">
        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('class'); ?></label>
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
                <input type="text" class="form-control" data-validate="required" id="place_holder" placeholder="Please Enter Placeholder of Field" name="place_holder" data-message-required="<?php echo get_phrase('please_enter_required_value'); ?>"> 
            </div>
            <span></span>
        </div>
    </div>
    
    <!--           
    <!----CREATION FORM ENDS-->
    <div class="text-right">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit'); ?></button>
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
	//$('#validation_select').change(ajax_get_data);
	function ajax_get_data(tab)
	{
		alert(tab);
		//var tab = $(this).val();
       
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?super_admin/ajax_get_columns/' + tab,
            success: function (response)
            {
                jQuery('#dbfield').html(response).selectpicker('refresh');
            }
        });
		
	}
</script>