<div class="modal-body">

    <?php echo form_open(base_url() . 'index.php?fees/main/fi_category/update/' . $edit_data[0]['fi_category_id'], array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>

        <div class="col-md-12 form-group">                       
            <div class="col-md-10 col-md-offset-1">
                <label for="category_name"><?php echo get_phrase("category_name"); ?><span class="error" style="color: red;">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-user"></i></div><input type="text" class="form-control" placeholder="<?php echo get_phrase("enter_category_name");?>" required="required" name="category_name" type="text" value="<?php echo $edit_data[0]['category_name']; ?>" >
                </div>
            </div>
        </div>

        <div class="col-md-10 col-md-offset-1"><label for="category_type"><?php echo get_phrase('type'); ?><span class="error mandatory">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;
            <label class="form-check-label"><input class="form-check-input" type="radio" name="category_type" required="required" value="1" <?php if($edit_data[0]['category_type']=='1'){ echo 'checked';}?> >&nbsp;<?php echo get_phrase('income'); ?></label>&nbsp;&nbsp;
            <label class="form-check-label"><input class="form-check-input" type="radio" name="category_type" required="required" value="2" <?php if($edit_data[0]['category_type']=='2'){ echo 'checked';}?> ><?php echo get_phrase('expenditure'); ?></label>
        </div>

        <div class="col-md-10 col-md-offset-1"><br>
            <label for="description"><?php echo get_phrase('description');?><span class="error" style="color: red;">*</span></label>
            <textarea class="form-control" rows="8" name="description" required="required"><?php echo $edit_data[0]['description']; ?></textarea>
        </div>

        <div class="row">
            <div class="col-sm-10 form-group text-right"><br>
                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase("update");?></button> 
            </div>
        </div>
    <?php echo form_close();?>
</div>