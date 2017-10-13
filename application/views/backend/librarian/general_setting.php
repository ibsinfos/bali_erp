<script>
    $(document).ready(function () {
        $(document).on("change", "#setting_for", function () {
            var change_value = $(this).val();
            window.location.href = "<?php echo base_url() . 'index.php?librarian/general_setting/' ?>" + change_value;
        });
    });
</script>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" >

            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo get_phrase('general_library_settings'); ?>
                </div>
            </div>

            <div class="panel-body">
                <?php echo form_open(base_url() . 'index.php?librarian/general_setting/'.$setting_for, array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top'));
                ?>
                <div class="form-group">
                    <label  class="col-sm-3 control-label"><?php echo get_phrase('setting_for'); ?></label>
                    <div class="col-sm-5">
                        <select name="setting_for" id="setting_for" class="selectpicker" data-style="form-control" data-live-search="true">
                            <!--option value=""><?php //echo get_phrase('select');?></option-->
                            <option value="Student" <?php if ($setting_for == 'Student') echo 'selected'; ?>><?php echo get_phrase('student'); ?></option>
                            <option value="Teacher" <?php if ($setting_for == 'Teacher') echo 'selected'; ?>><?php echo get_phrase('teacher'); ?></option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label  class="col-sm-3 control-label"><?php echo get_phrase('max_issue_limit'); ?></label>
                    <div class="col-sm-5">
                        <input type="number" class="form-control" name="max_issue_limit"  value="<?php echo empty($record['max_issue_limit']) ? "" : $record['max_issue_limit'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label  class="col-sm-3 control-label"><?php echo get_phrase('max_days_limit'); ?></label>
                    <div class="col-sm-5">
                        <input type="number" class="form-control" name="max_days_limit"  value="<?php echo empty($record['max_days_limit']) ? "" : $record['max_days_limit'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label  class="col-sm-3 control-label"><?php echo get_phrase('fine_amount'); ?></label>
                    <div class="col-sm-5">
                        <input type="number" step="0.25" class="form-control" name="fine_amount"  value="<?php echo empty($record['fine_amount']) ? "" : $record['fine_amount'] ?>">
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <input type="submit" name="save_setting" class="btn btn-info" value="<?php echo get_phrase('save'); ?>">
                    </div>
                </div>
                <?php echo form_close(); ?>

            </div>

        </div>
    </div>
</div>