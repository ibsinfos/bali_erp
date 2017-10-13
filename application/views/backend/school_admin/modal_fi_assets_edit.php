<div class="modal-body">

    <?php echo form_open(base_url() . 'index.php?fees/assets/update/'.$edit_data[0]['fi_assets_id'], array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>

        <div class="col-md-12 form-group">                       
            <div class="col-md-10 col-md-offset-1">
                <label for="title"><?php echo get_phrase("title"); ?><span class="error" style="color: red;">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-user"></i></div><input type="text" class="form-control" placeholder="<?php echo get_phrase("enter_title");?>" required="required" name="title" type="text" value="<?php echo $edit_data[0]['title']; ?>" >
                </div>
            </div>
        </div>

        <div class="col-md-12 form-group">                       
            <div class="col-md-10 col-md-offset-1">
                <label for="amount"><?php echo get_phrase("amount"); ?><span class="error" style="color: red;">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-user"></i></div><input type="text" class="form-control" placeholder="<?php echo get_phrase("enter_amount");?>" required="required" name="amount" type="text" value="<?php echo $edit_data[0]['amount']; ?>" >
                </div>
            </div>
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