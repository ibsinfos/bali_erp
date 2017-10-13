<script src="<?php echo base_url();?>assets/bower_components/dropify/dist/js/dropify.min.js"></script>
<script>
    $(document).ready(function() {
        $('.dropify').dropify();
    });
</script>

<?php //echo $edit_data[0]['school_id'];die;?>


<div class="row">
    <div class="col-md-12">
        <h2>Edit Role</h2>
        <div class="panel-body">
            <?php echo form_open(base_url() . 'index.php?super_admin/role/update/' . $edit_data[0]['id'], array('class' => 'form-horizontal form-material form-groups-bordered validate', 'target' => '_top')); ?>

                <div class="form-group">
                    <div class="col-md-12 m-b-20">
                        <label for="field-1"><?php echo get_phrase('school');?><span class="error mandatory"> *</span></label>

                        <select name="school_id" class="selectpicker" data-style="form-control" data-live-search="true" required="required" >
                            <option value=""><?php echo get_phrase('select_school'); ?></option>
<?php foreach ($school as $row): ?>
                            <option value="<?php echo $row['school_id']; ?>" <?php if($edit_data[0]['school_id']==$row['school_id']){echo 'selected';} ?> ><?php echo ucwords($row['name']); ?></option><?php endforeach; ?>
                        </select>
                    </div>   
                </div>

                <div class="form-group">
                    <div class="col-md-12 m-b-20">
                        <label for="field-1"><?php echo get_phrase('role_name');?><span class="error mandatory"> *</span></label>
                        <input type="text" class="form-control" placeholder="Role" name="name" value="<?php echo $edit_data[0]['name']; ?>" data-validate="required" data-message-required="<?php echo get_phrase('please_enter_role_name'); ?>" required="required" readonly/>
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