<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"><h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" target="_blank" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/Dashboard"><?php echo get_phrase('dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/manage_product"><?php echo get_phrase('manage_products'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<?php extract($product); ?>
<div class="row">
    <div class="col-md-12">
        <div class="white-box">

            <form action="<?php echo base_url(); ?>index.php?school_admin/product/do_update/<?php echo $product_id; ?>" method="post">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="field-1"><?php echo get_phrase("product_name"); ?></label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-product-hunt"></i></div>                  
                            <input type="text" class="form-control" value="<?php echo $product_name; ?>" id="productName" placeholder="Product Name" name="productName" autocomplete="off" required="required">
                            <label class="mandantory"> <?php echo form_error('productName'); ?></label></div>
                    </div> 
                    <div class="col-md-6 form-group">
                        <label for="field-1"><?php echo get_phrase("product_id"); ?></label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-key"></i></div>                  
                            <input type="text" class="form-control" value="<?php echo $product_unique_id; ?>" id="productUniqueId" placeholder="Product Id" name="productUniqueId" autocomplete="off" required="required">
                            <label class="mandantory"><?php echo form_error('productUniqueId'); ?></label>
                        </div> 
                    </div>
                </div>  
                <div class="row" >
                    <div class="col-md-6 form-group">
                        <label for="field-1"><?php echo get_phrase("rate"); ?></label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-rupee"></i></div>                  
                            <input type="text" class="form-control" value="<?php echo $rate; ?>"  id="rate" placeholder="Rate" name="rate" autocomplete="off" required="required">
                            <label style="color:red;"> <?php echo form_error('rate'); ?></label>
                        </div> 
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="field-1">
                            <?php echo get_phrase('status'); ?>
                            <span class="error mandatory" > *</span></label>
                        <?php // pre($classes); exit;  ?>
                        <select class="selectpicker" data-style="form-control" data-live-search="true" id="status" name="status" required="required">
                            <option value="Available" <?php if($status=='Available'){ echo 'selected';} ?>>Available</option>
                            <option value="Not Available" <?php if($status=='Not Available'){ echo 'selected';} ?>>Not Available</option>
                        </select>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-md-6 form-group">
                        <label for="field-1">
                            <?php echo get_phrase('category'); ?>
                        </label>
                        <select class="selectpicker" data-style="form-control" data-live-search="true" id="category" name="categories_id" required="required">
                            <?php foreach ($categories as $row) { ?>	
                                <option value='<?php echo $row['categories_id']; ?>' <?php if($categories_id == $row['categories_id']){ echo 'selected';} ?>><?php echo $row['categories_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="field-1">
                            <?php echo get_phrase('seller'); ?>
                        </label>
                        <select class="selectpicker" data-style="form-control" data-live-search="true" id="seller" name="seller" required="required">
                            <?php foreach ($seller as $row) { ?>
                                <option value="<?php echo $row['seller_id']; ?>" <?php if($seller == $row['seller_id']){ echo 'selected';} ?> ><?php echo $row['seller_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row" >
                    <div class="col-md-6 form-group">
                        <label><?php echo get_phrase("purchase_date"); ?><span class="error" style="color: red;"> *</span></label>
                        <div class="input-group">
        <div class="input-group-addon"><i class="fa fa-calendar"></i></div><input type="text" class="form-control mydatepicker" placeholder="<?php echo get_phrase("purchase_date"); ?>" required="required" name="purchase_date" type="text" value="<?php echo $purchase_date; ?>" > <label style="color:red;"> <?php echo form_error('purchase_date'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <label><?php echo get_phrase("bill_number"); ?><span class="error" style="color: red;"> *</span></label>
                        <div class="input-group">
        <div class="input-group-addon"><i class="ti-bolt"></i></div><input type="text" class="form-control" placeholder="<?php echo get_phrase("bill_number"); ?>" required="required" name="bill_number" type="text" value="<?php echo $bill_number; ?>" > <label style="color:red;"> <?php echo form_error('bill_number'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="row" >
                    <div class="col-md-6 form-group">
                        <label><?php echo get_phrase("bill_date"); ?><span class="error" style="color: red;"> *</span></label>
                        <div class="input-group">
        <div class="input-group-addon"><i class="fa fa-calendar"></i></div><input type="text" class="form-control mydatepicker" placeholder="<?php echo get_phrase("bill_date"); ?>" required="required" name="bill_date" type="text" value="<?php echo $bill_date; ?>" > <label style="color:red;"> <?php echo form_error('bill_date'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="field-1">
                            <?php echo get_phrase('purchase_mode'); ?><span class=" mandatory"> *</span>
                        </label>

                        <select class="selectpicker" data-style="form-control" data-live-search="true" id="purchase_mode" name="purchase_mode" required="required">
                            <option value="cash" <?php if($purchase_mode=='cash'){ echo 'selected';} ?>>Cash</option>
                            <option value="credit" <?php if($purchase_mode=='credit'){ echo 'selected';} ?>>Credit</option>                        
                        </select>
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('update'); ?></button>
                </div>
            </form>
        </div>
    </div>            
</div>






