<?php $row = 1; if (!empty($row)){ ?>
<div class="row">
    <div class="col-md-12">
        
                <?php echo form_open(base_url() . 'index.php?school_admin/cce_settings/pt_max' ); ?>
                    <div class="form-group">
                        <label for="maxmarks" class="control-label"><?php echo get_phrase("maximum_marks"); ?></label>
                        <div><input type="text" class="form-control" name="maxmarks" value="<?php echo $param2;?>" required></div>
                    </div>

                    <div class="text-right">
                            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d m-t-10"><?php echo get_phrase('save'); ?></button>                
                    </div>
                <?php echo form_close(); ?>
            </div>
</div><?php } ?>
