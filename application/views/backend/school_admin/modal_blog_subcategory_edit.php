
<div class="panel panel-primary" data-collapsed="0">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-plus-circled"></i>
            <?php echo get_phrase('edit_subcategory'); ?>
        </div>
    </div>    
    <div class="panel-body">  
        <?php 
        $row        =       array_shift($catname); //echo $row['blog_category_parent_id'];
        ?>
        <?php echo form_open(base_url().'index.php?blogs/view_category_subcategory/subedit/'.$row['blog_category_id'], array('class' =>'form-horizontal validate','id'=>'addCategorySubcategoryId', 'method' => 'POST'));?>
        <div class="form-group">
            <label class="control-label col-sm-5" for="create_update"><?php echo get_phrase('sub_category');?>:<span class="error" style="color: red;"> *</span></label>
            <div class="col-sm-5">
            <input type="text" class="form-control" name="subcategory_name" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"  value="<?php echo $row['blog_category_name'];?>">
            </div>  
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5" for="create_update"><?php echo get_phrase('select_category');?>:<span class="error" style="color: red;"> *</span></label>
            <div class="col-sm-5">
            <select name="blog_category_parent_id" class="selectpicker1" data-style="form-control" data-live-search="true" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>">
                <option value=""><?php echo get_phrase('select_category'); ?></option>
                <?php
                //pre($blog_categories); exit;
                foreach($blog_categories as $cat){?>
                    <option value="<?php echo $cat['blog_category_id'];?>"<?php if($cat['blog_category_id'] == $row['blog_category_parent_id']) echo 'selected'; ?> ><?php echo $cat['blog_category_name'];?></option>
                <?php } ?>
            </select>
            </div>
        </div>
        <div class="col-md-12 text-center"> 
            <button type="submit" class="btn btn-success" id="insert" name="add_new" value="add_new"><?php echo get_phrase('submit'); ?></button>
        </div>      
        <?php echo form_close();?>
    </div>
</div>
