<?php foreach ($edit_data as $data): ?>
    <div class="row">
        <div class="col-md-12">
            <div><a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_add_subjects/cce');">
                    <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 pull-right"><i class="fa fa-reply"></i></button></a>
            </div>
            <div class="panel-body">
                <?php echo form_open(base_url() . 'index.php?school_admin/cce_subjects/do_update/' . $data['id'], array('id' => 'subject_add', 'class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                <table class="table table-hover manage-u-table">
                    <thead>
                        <tr>
                            <th><div>No</div></th>
                            <th><div><?php echo get_phrase('subject_name'); ?></div></th>
                            <th><div><?php echo get_phrase('weekly_classes'); ?></div></th>
                            <th><div><?php echo get_phrase('sixth_subject'); ?></div></th>
                            <th><div><?php echo get_phrase('asl'); ?></div></th>
                            <th><div><?php echo get_phrase('no_exam_subject'); ?></div></th>                                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <div class="col-sm-5">
                                        <div class="checkbox-danger">
                                            <input type="checkbox"  name="selected_subject" id="subject_check<?php echo $data['subject_id']; ?>" checked disabled="disabled" value="<?php echo $data['subject_id']; ?>">
                                            <input type="hidden"  name="selected_subject" id="subject_check<?php echo $data['subject_id']; ?>" value="<?php echo $data['subject_id']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo $data['name']; ?></td>
                            <td><input type="text"  name="selected_weekly_classes" id="weekly<?php echo $data['subject_id']; ?>" value="<?php echo $data['weekly_classes']; ?>" class="form-control" onkeypress="return isNumber(event)" required/></td>
                            <td>
                                <div class="checkbox-danger"><input type="checkbox" <?php if ($data['sixth_subject'] == 1) { ?> checked="checked" <?php } ?> id="sixth<?php echo $data['subject_id']; ?>"  name="selected_sixth_subject" value="1"></div>
                            </td>
                            <td>
                                <div class="checkbox-danger"><input type="checkbox" <?php if ($data['asl'] == 1) { ?> checked="checked" <?php } ?>  id="asl<?php echo $data['subject_id']; ?>"  name="selected_asl" value="1"></div>    
                            <td>                                            
                                <div class="checkbox-danger"><input type="checkbox" <?php if ($data['no_exam'] == 1) { ?> checked="checked" <?php } ?> id="no<?php echo $data['subject_id']; ?>"  name="selected_no_exam" value="1"></div>                                
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="text-right">
                    <button type="submit" onclick="handleClick();" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('update'); ?></button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<script type="text/javascript">
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>