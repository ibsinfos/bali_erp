<div class="row bg-title"> 
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/inventory_category"><?php echo get_phrase('inventory'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<?php if ($this->session->flashdata('flash_validation_error')) { ?>        
    <div class="alert alert-danger">
        <?php echo $this->session->flashdata('flash_validation_error'); ?>
    </div>
<?php } ?>
<div class="row m-0">
    <div class="col-md-12 white-box" data-step="5" data-intro="<?php echo get_phrase('From here you can enter the product details.'); ?>" data-position="top">
        <div class=" "> 
            <?php echo form_open(base_url() . 'index.php?school_admin/product/create', array('class' => 'form-groups-bordered validate', 'target' => '_top')); ?>

            <div class="col-md-12">
                <div class="col-xs-12 col-md-6">
                    <label for="field-1"><?php echo get_phrase("product_name"); ?><span class="mandatory"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-product-hunt"></i></div>                  
                        <input type="text" class="form-control" id="productName" placeholder="Product Name" name="productName" autocomplete="off" required="required" value="<?php echo set_value('productName'); ?>">
                        <label class="mandantory"> <?php echo form_error('productName'); ?></label>
                    </div> 
                </div>

                <div class="col-xs-12 col-md-6">
                    <label for="field-1"><?php echo get_phrase("product_id"); ?><span class=" mandatory"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-key"></i></div>                  
                        <input type="text" class="form-control" id="productUniqueId" placeholder="Product Id" name="productUniqueId" autocomplete="off" required="required" value="<?php echo set_value('productUniqueId'); ?>">
                    </div> 
                    <label class="mandantory"><?php echo form_error('productUniqueId'); ?></label>

                </div>
            </div>

            <div class="col-md-12  m-b-20">
                <div class="col-xs-12 col-md-6">
                    <label for="field-1"><?php echo get_phrase("rate"); ?><span class=" mandatory"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-rupee"></i></div>                  
                        <input type="text" class="form-control" id="rate" placeholder="Rate" name="rate" autocomplete="off" onkeypress="return valid_only_numeric(event);" required="required" value="<?php echo set_value('rate'); ?>">
                        <span class="mandantory"><?php echo form_error('rate'); ?></span>
                    </div> 
                </div>


                <?php
                $categories_id = $this->uri->segment(3);
                if (empty($categories_id)) {
                    ?>

                    <div class="col-xs-12 col-md-6">
                        <label for="field-1">
                            <?php echo get_phrase('category'); ?><span class=" mandatory"> *</span>
                        </label>
                        <select class="selectpicker" data-style="form-control" data-live-search="true" id="category" name="category" required="required">
                            <option value="">Select</option>
                            <?php foreach ($categories as $row) { ?>	
                                <option value="<?php echo $row['categories_id']; ?>"><?php echo $row['categories_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                <?php } else { ?>
                    <input type="hidden" name="category" value="<?php echo $categories_id; ?>">
                <?php } ?> </div>

            <div class="col-md-12  m-b-20">
                <div class="col-xs-12 col-md-6">
                    <label for="field-1">
                        <?php echo get_phrase('seller'); ?><span class=" mandatory"> *</span>
                    </label>

                    <select class="selectpicker" data-style="form-control" data-live-search="true" id="seller" name="seller">
                        <option value="">Select</option>
                        <?php foreach ($seller as $row) { ?>
                            <option value="<?php echo $row['seller_id']; ?>"><?php echo $row['seller_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-xs-12 col-md-6">
                    <label for="field-1"><?php echo get_phrase("no_of_products"); ?><span class=" mandatory"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="ti-bolt"></i></div>                  
                        <input type="text" class="form-control" id="no_of_products" placeholder="No of Product" name="no_of_products" autocomplete="off" onkeypress="return valid_only_numeric(event);" required="required" value="<?php echo set_value('no_of_products'); ?>">
                        <span class="mandantory"><?php echo form_error('no_of_products'); ?></span>
                    </div> 
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group col-xs-12 col-md-6">
                    <label><?php echo get_phrase("purchase_date"); ?><span class="error" style="color: red;"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div><input type="text" class="form-control mydatepicker" placeholder="<?php echo get_phrase("purchase_date"); ?>" required="required" name="purchase_date" type="text" value="<?php echo set_value('purchase_date'); ?>" >
                    </div>
                </div>

                <div class="form-group col-xs-12 col-md-6">
                    <label><?php echo get_phrase("bill_number"); ?><span class="error" style="color: red;"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="ti-bolt"></i></div><input type="text" class="form-control" placeholder="<?php echo get_phrase("bill_number"); ?>" required="required" name="bill_number" type="text" value="<?php echo set_value('bill_number'); ?>" onkeypress="return valid_only_numeric(event);">
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group col-xs-12 col-md-6">
                    <label><?php echo get_phrase("bill_date"); ?><span class="error" style="color: red;"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div><input type="text" class="form-control mydatepicker" placeholder="<?php echo get_phrase("bill_date"); ?>" required="required" name="bill_date" type="text" value="<?php echo set_value('bill_date'); ?>" >
                    </div>
                </div>
                <div class="form-group col-xs-12 col-md-6">
                    <label for="field-1">
                        <?php echo get_phrase('purchase_mode'); ?><span class=" mandatory"> *</span>
                    </label>
                    <select class="selectpicker" data-style="form-control" data-live-search="true" id="purchase_mode" name="purchase_mode" >
                        <option value="cash">Cash</option>
                        <option value="credit">Credit</option>                        
                    </select>
                </div>
            </div>


            <div class="col-md-12 text-right">
                <button  data-step="6" data-intro="<?php echo get_phrase('Click on Add button to add the product details.'); ?>" data-position="left" type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('add_product'); ?></button>
                <a href="<?php echo base_url(); ?>index.php?school_admin/manage_product/">
                </a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function valid_only_numeric(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

</script>