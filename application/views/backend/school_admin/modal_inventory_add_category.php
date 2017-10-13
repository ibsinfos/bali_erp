<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?php echo get_phrase('add_category'); ?></h4>
            </div> 
            <div class="panel-body">
                <?php echo form_open(base_url() . 'index.php?school_admin/inventory_category/create', array('class' => 'form-horizontal form-material form-groups-bordered validate', 'target' => '_top')); ?>

                <div class="form-group">
                    <label for="maxmarks" class="control-label"><?php echo get_phrase("Category's_name"); ?><span class="mandatory"> *</span></label>
                    <div><input type="text" class="form-control" id="categoriesName" placeholder="Category's name" name="categoriesName" autocomplete="off" required="required"></div>
                </div>
                <div class="form-group">
                    <div class="col-md-12 m-b-20 text-right">
                        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('add_category'); ?></button>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>





