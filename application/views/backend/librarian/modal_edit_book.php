<?php
    $edit_data = $this->db->get_where('books', array('book_id' => $param2))->result_array();
    foreach ($edit_data as $row):
        $subcategory_detail = $this->crud_model->get_record("book_subcategory", array("subcategory_id" => $row['subcategory_id']));
        $subcategory = $this->db->get_where('book_subcategory', array('category_id' => $subcategory_detail['category_id'], 'subcategory_status' => "Active"))->result_array();
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title" >
                            <i class="entypo-plus-circled"></i>
                            <?php echo get_phrase('edit_Book'); ?>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo form_open(base_url() . 'index.php?librarian/books/do_update/' . $row['book_id'], array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('book_title'); ?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" value="<?php echo $row['book_title'] ?>" name="book_title" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('author_name'); ?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" value="<?php echo $row['book_author'] ?>" name="book_author" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('isbn_number'); ?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" value="<?php echo $row['isbn_number'] ?>" name="isbn_number" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('book_note'); ?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" value="<?php echo $row['book_note'] ?>" name="book_note"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('category'); ?></label>
                            <div class="col-sm-5">
                                <select name="category_id" id="edit_category_id"  class="selectpicker1" data-style="form-control" data-live-search="true" data-validate="required">
                                    <option value=""><?php echo get_phrase('select_category'); ?></option>
                                    <?php
                                    $category = $this->db->get('book_category')->result_array();
                                    foreach ($category as $row1):
                                        $selected = $subcategory_detail['category_id'] == $row1['category_id'] ? "selected='selected'" : "";
                                        ?>
                                        <option value="<?php echo $row1['category_id']; ?>" <?php echo $selected; ?>>
                                            <?php echo $row1['category_name']; ?>
                                        </option>
                                        <?php
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('subcategory'); ?></label>
                            <div class="col-sm-5">
                                <select name="subcategory_id" id="edit_subcategory_selector_holder"  class="selectpicker1" data-style="form-control" data-live-search="true" data-validate="required">
                                    <option value=""><?php echo get_phrase('select_subcategory'); ?></option>
                                    <?php
                                    foreach ($subcategory as $row2):
                                        $selected = $row['subcategory_id'] == $row2['subcategory_id'] ? "selected='selected'" : "";
                                        ?>
                                        <option value="<?php echo $row2['subcategory_id']; ?>" <?php echo $selected; ?>>
                                            <?php echo $row2['subcategory_name']; ?>
                                        </option>
                                        <?php
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <button type="submit" class="btn btn-info"><?php echo get_phrase('edit_book'); ?></button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php
    endforeach;
?>
<script type="text/javascript">

    jQuery(document).ready(function ($)
    {
        $(document).on("change", "#edit_category_id", function () {
            var category_id = $(this).val();
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?librarian/get_subcategory/' + category_id,
                success: function (response)
                {
                    jQuery('#edit_subcategory_selector_holder').html(response).selectpicker('refresh');
                }
            });
        });
    });

</script>



