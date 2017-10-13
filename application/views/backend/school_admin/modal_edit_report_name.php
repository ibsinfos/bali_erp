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
            <?php echo form_open(base_url() . 'index.php?admin_report/dynamic_report_name/update/' .$edit_data->id, array('class' => 'form-horizontal form-material form-groups-bordered validate', 'target' => '_top')); ?>
                <div class="form-group">
                    <div class="col-md-12 m-b-20">
                        <label for="field-1"><?php echo get_phrase('report_caption');?><span class="error mandatory"> *</span></label>
                        <input type="text" class="form-control" placeholder="Report Name" name="report_name" value="<?php echo $edit_data->report_caption; ?>" data-validate="required" data-message-required="<?php echo get_phrase('please_enter_report_name'); ?>" required="required"/>
                    </div>   
                </div>
            <div class="form-group">
                    <div class="col-md-12 m-b-20">
                        <label for="field-1"><?php echo get_phrase('report_table');?><span class="error mandatory"> *</span></label>
                        <input type="text" class="form-control" placeholder="Report Table" name="report_table" value="<?php echo $edit_data->report_table; ?>" data-validate="required" data-message-required="<?php echo get_phrase('please_enter_report_table'); ?>" required="required"/>
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