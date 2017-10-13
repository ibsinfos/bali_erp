<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title" >
                    <i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('update_book_stock'); ?>
                </div>
            </div>
            <div class="panel-body">
                <?php echo form_open(base_url() . 'index.php?librarian/books/update_stock/' . $param2, array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
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
                    <div class="col-sm-5">
                        <input type="number"  min="0" step="0.5" class="form-control" name="total_price"data-validate="required" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-info"><?php echo get_phrase('add_stock'); ?></button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>



