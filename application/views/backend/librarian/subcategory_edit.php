<?php
    $edit_data = $this->db->get_where('book_subcategory', array(
                'subcategory_id' => $param2
            ))->result_array();
    foreach ($edit_data as $row):
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title" >
                            <i class="entypo-plus-circled"></i>
                            <?php echo get_phrase('edit_subcategory'); ?>
                        </div>
                    </div>
                    <div class="panel-body">

                        <?php echo form_open(base_url() . 'index.php?librarian/subcategories/edit/' . $row['subcategory_id'], array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data')); ?>
                        <input type="hidden" name="category_id" value="<?php echo $row['category_id']; ?>">
                        <div class="form-group">
                            <label for="subcategory_name" class="col-sm-3 control-label"><?php echo get_phrase('subcategory_name'); ?></label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="subcategory_name" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" 
                                       value="<?php echo $row['subcategory_name']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3"><?php echo get_phrase('subcategory_status'); ?></label>
                            <div class="col-sm-5">
                                <select name="subcategory_status"  class="selectpicker" data-style="form-control" data-live-search="true" style="width:100%;">
                                    <option value="Active" <?php echo $row['subcategory_status'] == "Active" ? "selected" : "" ?>>Active</option>
                                    <option value="Inactive" <?php echo $row['subcategory_status'] == "Inactive" ? "selected" : "" ?>>Inactive</option>
                                </select>
                            </div>
                        </div>



                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <button type="submit" class="btn btn-info"><?php echo get_phrase('update'); ?></button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>