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
            <?php echo form_open(base_url() . 'index.php?super_admin/dynamic_group/update/' .$edit_data->id, array('class' => 'form-horizontal form-material form-groups-bordered validate', 'target' => '_top')); ?>
                <div class="form-group">
                    <div class="col-md-12 m-b-20">
                        <label for="field-1"><?php echo get_phrase('group_name');?><span class="error mandatory"> *</span></label>
                        <input type="text" class="form-control" placeholder="Group Name" name="group_name" value="<?php echo $edit_data->name; ?>" data-validate="required" data-message-required="<?php echo get_phrase('please_enter_group_name'); ?>" required="required"/>
                    </div>   
                </div>
            <div class="form-group">
                    <div class="col-md-12 m-b-20">
                        <label for="field-1"><?php echo get_phrase('image');?><span class="error mandatory"> *</span></label>
                        <input type="text" class="form-control" placeholder="Group Image" name="image" value="<?php echo $edit_data->image; ?>" data-validate="required" data-message-required="<?php echo get_phrase('please_enter_group_image'); ?>" required="required"/>
                    </div>   
                </div>
             <div class="form-group">
                    <div class="col-md-12 m-b-20">
                        <label for="field-1"><?php echo get_phrase('introduction');?><span class="error mandatory"> *</span></label>
                        <input type="text" class="form-control" placeholder="Field Intro" name="intro" value="<?php echo $edit_data->intro; ?>" data-validate="required" data-message-required="<?php echo get_phrase('please_enter_intro_of_field'); ?>" required="required"/>
                    </div>   
                </div>
             <div class="form-group">
                    <div class="col-md-12 m-b-20">
                        <label for="field-1"><?php echo get_phrase('section_name');?><span class="error mandatory"> *</span></label>
                        <input type="text" class="form-control" placeholder="Section Name" name="section_name" value="<?php echo $edit_data->section_name; ?>" data-validate="required" data-message-required="<?php echo get_phrase('please_enter_section_name'); ?>" required="required"/>
                    </div>   
                </div>
             <div class="form-group">
                    <div class="col-md-12 m-b-20">
                        <label for="field-1"><?php echo get_phrase('form_name'); ?><span class="error mandatory"> *</span></label>
            <select name="form_name" data-style="form-control" data-live-search="true" class="selectpicker1" id="validation_select" required="required">
                <option value=""><?php echo get_phrase('select_form_name'); ?></option>
                <?php foreach($dynamic_form_list as $row1):  ?>            
                <option value="<?php echo $row1['id'];  ?>" <?php if($edit_data->form_id == $row1['id']){ echo "selected";} ?>><?php echo get_phrase($row1['name']); ?></option>
                <?php endforeach;  ?>
            </select>                  </div>   
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