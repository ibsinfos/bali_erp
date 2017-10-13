<div class="form-horizontal form-material">
    <div class="form-group">
        <?php 
        $row        =       array_shift($catname);        
        ?>
            <?php echo form_open(base_url().'index.php?blogs/view_category_subcategory/edit/'.$row['blog_category_id'], array('class' =>'form-horizontal validate','id'=>'addCategorySubcategoryId', 'method' => 'POST'));?>

                <div class="col-md-12 m-b-20">
                    <label for="create_update">
                    <?php echo get_phrase('category');?>:<span class="error" style="color: red;"> *</span></label>

                    <input type="text" class="form-control" name="category_name" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" autofocus value="<?php echo $row['blog_category_name'];?>">
                </div>

                <div class="col-md-12 text-right">
                    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" id="insert" name="add_new" value="add_new">
                        <?php echo get_phrase('Update'); ?>
                    </button>
                </div>
                <?php echo form_close();?>
    </div>
</div>