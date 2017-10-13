<?php //pre($cs_activities); die(); ?>
<div class="row">
    <div class="col-md-12">
        <?php foreach ($cs_activities as $csa): ?>
            <?php echo form_open(base_url() . 'index.php?school_admin/cs_activities/update/'.$csa['csa_id'] ); ?>
            
              <div class="form-group">
                    <label for="maxmarks" class="control-label"><?php echo get_phrase("co_scholastic_activity_name"); ?></label>
                    <div><input type="text" class="form-control" name="csa_name" value="<?php echo $csa['csa_name'];?>" required></div>
                </div>

                <div class="text-right">
                        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d m-t-10"><?php echo get_phrase('update'); ?></button>                
                </div>
            <?php echo form_close(); ?>
        <?php endforeach; ?>
    </div>
        
</div>