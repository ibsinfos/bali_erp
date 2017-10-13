<?php
    $edit_data = (array) $this->db->get_where('books_list', array('book_unique_id' => $param2))->row();
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title" >
                    <i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('change_book_status'); ?>
                </div>
            </div>
            <div class="panel-body">
                <?php echo form_open(base_url() . 'index.php?librarian/books_list/change_status/' . $edit_data['book_id'], array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('change_status'); ?></label>
                    <div class="col-sm-5">
                        <input type="hidden" name="book_unique_id" value="<?php echo $param2 ?>" />
                        <select name="book_status" id="category_id"  class="selectpicker1" data-style="form-control" data-live-search="true" data-validate="required">
                            <option value="Active" <?php
                                if ($edit_data['book_status'] == "Active")
                                {
                                    echo "selected='selected'";
                                }
                            ?>>
                                        <?php echo get_phrase("active"); ?>
                            </option>
                            <option value="Damage" <?php
                                if ($edit_data['book_status'] == "Damage")
                                {
                                    echo "selected='selected'";
                                }
                            ?>>
                                        <?php echo get_phrase("damage"); ?>
                            </option>
                            <option value="Lost" <?php
                                if ($edit_data['book_status'] == "Lost")
                                {
                                    echo "selected='selected'";
                                }
                            ?>>
                                        <?php echo get_phrase("lost"); ?>
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-info"><?php echo get_phrase('change_status'); ?></button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>



