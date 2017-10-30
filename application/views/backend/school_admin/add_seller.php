<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo $page_title; ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>

        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><?php echo get_phrase('inventory'); ?>
                <ul>                    
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/inventory_category"><?php echo get_phrase('category'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/seller_master"><?php echo get_phrase('seller'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/manage_product"><?php echo get_phrase('product'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/report_product_service"><?php echo get_phrase('report_product_service'); ?></a></li>
                </ul>
            </li>
            <li class="active">
                <?php echo $page_title; ?>
            </li>
        </ol>
    </div>
</div>

<div class="col-md-12 white-box">
    <?php echo form_open(base_url() . 'index.php?school_admin/seller_add', array('class' => 'validate', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
    <div class="row" data-step="6" data-intro="<?php echo get_phrase('You_can_add_the_particulars needed');?>" data-position='top'>
        <div class="col-xs-12 col-md-6 form-group ">
            <label for="categoriesName">
                <?php echo get_phrase('seller_name'); ?><span class="mandatory"> *</span>
            </label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-users"></i></div>
                <input type="text" class="form-control" id="sellerName" placeholder="Seller Name" name="sellerName" value="<?php echo set_value('sellerName') ?>" autocomplete="off" required="required">
            </div>
            <span class="mandatory"> <?php echo form_error('sellerName'); ?></span>
        </div>

        <div class="col-xs-12 col-md-6 form-group ">
            <label for="categoriesName">
                <?php echo get_phrase('seller_phone_number'); ?><span class="mandatory"> *</span>
            </label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                <input type="text" class="form-control" id="sellerPhoneNo" placeholder="Seller PhoneNo" name="sellerPhoneNo" value="<?php set_value('sellerPhoneNo') ?>" onkeypress="return valid_only_numeric(event);" autocomplete="off" required="required" maxlength="10">
            </div>
            <span class="mandatory"> <?php echo form_error('sellerPhoneNo'); ?></span>
        </div>

        <div class="col-xs-12 col-md-6 form-group ">
            <label for="sellerEmail">
                <?php echo get_phrase('seller_email'); ?><span class="mandatory"> *</span>
            </label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                <input type="email" class="form-control" id="sellerEmail" placeholder="Seller Email" name="sellerEmail" value="<?php echo set_value('sellerEmail') ?>" autocomplete="off" required="required">
            </div>
            <span class="mandatory"> <?php echo form_error('sellerEmail'); ?></span>
        </div>

        <div class="col-xs-12 col-md-6 form-group ">
            <label for="contactName">
                <?php echo get_phrase('contact_person'); ?><span class="mandatory"> *</span>
            </label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-user-plus"></i></div>
                <input type="text" class="form-control" id="contactName" placeholder="Contact Name" name="contactName" value="<?php echo set_value('contactName') ?>" autocomplete="off" required="required">
            </div>
            <span class="mandatory"> <?php echo form_error('contactName'); ?></span>
        </div>

        <div class="col-xs-12 col-md-6 form-group ">
            <label for="sellerAddress">
                <?php echo get_phrase('seller_address:'); ?><span class="mandatory"> *</span>
            </label>
            <!--<div class="input-group">-->
                <!--<div class="input-group-addon"><i class="fa fa-address-book"></i></div>-->
            <textarea class="form-control" id="sellerAddress" name="sellerAddress" value="<?php echo set_value('sellerAddress') ?>" rows="9" required placeholder="Please enter seller address"></textarea>
            <!--</div>-->
            <span class="mandatory"> <?php echo form_error('sellerAddress'); ?></span>
        </div>

        <div class="col-xs-12 col-md-6 form-group ">
            <label for="sellerAddress">
                <?php echo get_phrase('attach_business_card:'); ?>
            </label>
<!--            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-address-book"></i></div>-->
                <input type="file" id="input-file-now" class="dropify" name="attached_document" />
            <!--</div>-->
        </div>

        <div class="text-right col-xs-12 p-t-10">
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d">
                <?php echo get_phrase('add_seller'); ?>
            </button>

        </div>
    </div>
</div>
<script>
    function valid_only_numeric(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>