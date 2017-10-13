<div class="modal-body">
    <?php foreach($details as $row){?>
    <?php echo form_open(base_url() . 'index.php?disciplinary/edit_violation_types/'.$row['violation_type_id'], array('class' => 'form-groups-bordered validate', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
    <div class="form-horizontal form-material">
        
        <div class="form-group">
            <div class="col-md-12 m-b-20">
                <label><?php echo get_phrase("type"); ?></label><span class="mandatory"> *</span>
                <input type="text" class="form-control" name="type" value="<?php echo $row['type']?>" required="required">
                <label class="mandatory"> <?php echo form_error('type'); ?></label>
            </div>

            <div class="col-md-12 m-b-20">
                <label><?php echo get_phrase("description"); ?></label><span class="mandatory"> *</span>
                <input type="text" class="form-control" name="description" value="<?php echo $row['description']?>" required="required">
            </div>

            <div class="col-md-12 text-right">
                <button type="submit" class="fcbtn btn btn-danger btn-outline"><?php echo get_phrase('submit'); ?></button>
            </div>
        </div> 
        
    </div>
    <?php echo form_close(); ?>
    <?php } ?>
</div>


