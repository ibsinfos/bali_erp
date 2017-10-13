<hr />
<div class="row">
    <div class="col-md-12">

        <!------CONTROL TABS START------>
        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#list" data-toggle="tab"><i class="entypo-book"></i> 
                    <?php echo get_phrase('books_list'); ?>
                </a></li>
            <li>
                <a href="#add" data-toggle="tab"><i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('add_book'); ?>
                </a></li>
        </ul>
        <!------CONTROL TABS END------>
        <div class="tab-content">
            <br>            
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">

                <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            
                            <th><div><?php echo get_phrase('#'); ?></div></th>
                            <th><div><?php echo get_phrase('Book_Title'); ?></div></th>
                            <th><div><?php echo get_phrase('Author'); ?></div></th>
                            <th><div><?php echo get_phrase('isbn_#'); ?></div></th>
                            <th><div><?php echo get_phrase('Description'); ?></div></th>
                            <th><div><?php echo get_phrase('No of_books'); ?></div></th>
                            <th><div><?php echo get_phrase('available_books'); ?></div></th>
                            <th><div><?php echo get_phrase('books_list'); ?></div></th>
                            <th><div><?php echo get_phrase('stock_record'); ?></div></th>
                            <th><div><?php echo get_phrase('options'); ?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $count = 1;
                            foreach ($books as $row):
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $row['book_title']; ?></td>
                                    <td><?php echo $row['book_author']; ?></td>
                                    <td><?php echo $row['isbn_number']; ?></td>
                                    <td><?php echo $row['book_note']; ?></td>
                                    <td><?php echo $row['total_books']; ?></td>
                                    <td><?php echo $row['available_books']; ?></td>
                                    
                                    <td><a href="<?php echo base_url(); ?>index.php?librarian/books_list/<?php echo $row['book_id']; ?>">
                                            <i class="entypo-book-open"></i>
                                        </a></td>
                                    <td><a href="<?php echo base_url(); ?>index.php?librarian/stock_history/<?php echo $row['book_id']; ?>">
                                            <i class="entypo-basket"></i>
                                        </a></td>
                                    
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                                Action <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                                <!-- Add Stock LINK -->
                                                <li>
                                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_add_book_stock/<?php echo $row['book_id']; ?>');">
                                                        <i class="entypo-pencil"></i>
                                                        <?php echo get_phrase('add_stock'); ?>
                                                    </a>
                                                </li>
                                                <!-- EDITING LINK -->
                                                <li>
                                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_book/<?php echo $row['book_id']; ?>');">
                                                        <i class="entypo-pencil"></i>
                                                        <?php echo get_phrase('edit'); ?>
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                                <?php
                                                if (empty($row['total_books']))
                                                {
                                                    ?>
                                                    <li>
                                                        <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?librarian/books/delete/<?php echo $row['book_id']; ?>');">
                                                            <i class="entypo-trash"></i>
                                                            <?php echo get_phrase('delete'); ?>
                                                        </a>
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                                <!-- DELETION LINK -->

                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php $count++; endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!----TABLE LISTING ENDS--->


            <!----CREATION FORM STARTS---->
            <div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
                    <?php echo form_open(base_url() . 'index.php?librarian/books/create', array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                    <div class="padded">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('book_title'); ?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="book_title" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('author_name'); ?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="book_author" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('isbn_number'); ?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="isbn_number" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('book_note'); ?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="book_note"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('category'); ?></label>
                            <div class="col-sm-5">
                                <select name="category_id" id="category_id"  class="selectpicker" data-style="form-control" data-live-search="true" data-validate="required">
                                    <option value=""><?php echo get_phrase('select_category'); ?></option>
                                    <?php
                                        $category = $this->db->get('book_category')->result_array();
                                        foreach ($category as $row1):
                                            ?>
                                            <option value="<?php echo $row1['category_id']; ?>">
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
                                <select name="subcategory_id" id="subcategory_selector_holder"  class="selectpicker" data-style="form-control" data-live-search="true" data-validate="required">
                                    <option value=""><?php echo get_phrase('select_subcategory'); ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('no_of_books'); ?></label>
                            <div class="col-sm-5">
                                <input type="number" min="0" class="form-control" name="no_of_books" data-validate="required"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('supplier_name'); ?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="supplier_name" data-validate="required"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('bill_number'); ?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="bill_number" data-validate="required"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('total_price'); ?></label>
                            <div class="col-sm-2">
                                <input type="number"  min="0" step="0.5" class="form-control" name="total_price" data-validate="required"/>
                            </div> 
                        
                            <label class="col-sm-1 control-label"><?php echo get_phrase('currency'); ?></label>
                            <div class="col-sm-2">
                                <select name="currency" id="currency"  class="selectpicker" data-style="form-control" data-live-search="true" data-validate="required">                                    
                                    <option value='USD'><?php echo get_phrase('USD'); ?></option>
                                    <option value='AED'><?php echo get_phrase('AED'); ?></option>
                                    <option value='EUR'><?php echo get_phrase('EUR'); ?></option>
                                    <option value='INR'><?php echo get_phrase('INR'); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-5">
                            <button type="submit" class="btn btn-info"><?php echo get_phrase('add_book'); ?></button>
                        </div>
                    </div>
                    </form>                
                </div>                
            </div>
            <!----CREATION FORM ENDS--->

        </div>
    </div>
</div>


<!-----  DATA TABLE EXPORT CONFIGURATIONS ----->                      
<script type="text/javascript">

    jQuery(document).ready(function ($)
    {
        $(document).on("change", "#category_id", function () {
            var category_id = $(this).val();
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?librarian/get_subcategory/' + category_id,
                success: function (response)
                {
                    jQuery('#subcategory_selector_holder').html(response).selectpicker('refresh');
                }
            });
        });
    });

</script>