<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('edit_seller'); ?></h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/seller_master"><?php echo get_phrase('inventory'); ?></a></li>
            <li class="active"><?php echo get_phrase('edit_seller'); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<?php if ($this->session->flashdata('flash_message_error')) { ?>        
    <div class="alert alert-danger">
        <?php echo $this->session->flashdata('flash_message_error'); ?>
    </div>
<?php } ?>

<div class="row m-0">
    <div class="col-md-12 white-box" data-step="5" data-intro="<?php echo get_phrase('From here you can edit the details of the seller.');?>" data-position="top">
        <?php extract($data_by_id); ?>
        <!-- <form action="<?php //echo base_url(); ?>index.php?school_admin/seller_master/do_update/<?php //echo $seller_id; ?>" method="post" enctype=" multipart/form-data"> -->

<?php echo form_open(base_url() . 'index.php?school_admin/seller_master/do_update/'.$seller_id, array('class' => 'validate', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>        

            <div class="row">
                <div class="col-xs-12 col-md-6 form-group">
                    <label class="control-label"><?php echo get_phrase('seller_name'); ?><span class="error mandatory"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-user"></i></div>
                        <input type="text" class="form-control" id="sellerName" value="<?php echo $seller_name; ?>" placeholder="Seller Name" name="sellerName" autocomplete="off" required="required">
                    </div>
                    <span class="mandatory"> <?php echo form_error('sellerName'); ?></span>
                </div>
          
                <div class="col-xs-12 col-md-6 form-group">
                    <label class="control-label" ><?php echo get_phrase('seller_phone_number'); ?><span class="error mandatory"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                        <input type="text" class="form-control numeric" id="sellerPhoneNo" value="<?php echo $seller_phone_number; ?>" placeholder="Seller PhoneNo" name="sellerPhoneNo"  autocomplete="off" required="required" maxlength="10">
                    </div>
                    <span class="mandatory"> <?php echo form_error('sellerPhoneNo'); ?></span>
                </div>        
            </div>  
            <div class="row">    
                <div class="col-xs-12 col-md-6 form-group">
                    <label class="control-label" ><?php echo get_phrase('seller_email'); ?><span class="error mandatory"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-mail-forward"></i></div>
                        <input type="email" class="form-control" id="sellerEmail" value="<?php echo $seller_email_id; ?>"  placeholder="Seller Email" name="sellerEmail" autocomplete="off" required="required">
                    </div>
                    <span class="mandatory"> <?php echo form_error('sellerEmail'); ?></span>
                </div>
                 
                <div class="col-xs-12 col-md-6 form-group">
                    <label class="control-label"><?php echo get_phrase('contact_person'); ?><span class="error mandatory"> *</span></label> 
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-user-plus"></i></div>
                        <input type="text" class="form-control" id="contactName" value="<?php echo $seller_contact_person; ?>"  placeholder="Contact Name" name="contactName" autocomplete="off" required="required">
                    </div>
                    <span class="mandatory"> <?php echo form_error('contactName'); ?></span>
                </div>  
            </div>

            <div class="row">    
                <div class="col-xs-12 col-md-6 form-group">
                    <label class="control-label"><?php echo get_phrase('seller_address'); ?><span class="error mandatory"> *</span></label> 
                    <input type="text" class="form-control" id="sellerAddress" value="<?php echo $seller_address; ?>"  placeholder="Seller Address" name="sellerAddress" autocomplete="off" required="required">
                    <span class="mandatory"> <?php echo form_error('sellerAddress'); ?></span>
                </div>

                <div class="col-xs-12 col-md-4 form-group ">
                    <label for="sellerAddress">
                        <?php echo get_phrase('change_business_card:'); ?>
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-address-book"></i></div>
                        <input type="file" id="input-file-now" class="dropify" name="attached_document" />
                    </div>
                </div>

                <div class="col-xs-2 col-md-1">
                    <?php if($attached_document!=" ") {?>
                    <input type="hidden" name="old_doc" value="<?php echo $attached_document;?>">
                    <img src="<?php echo "uploads/inventory_seller_document/".$attached_document;?>" class="attached_document"/> <?php }else {?>

                        <img src="<?php echo "uploads/inventory_seller_document/document.jpg";?>" class="attached_document"/>

                        <?php }?>
                </div>
            </div>

            <div class=" text-right">

                <button data-step="6" data-intro="<?php echo get_phrase('Click onn the edit button to save the details of the seller.');?>" data-position="left" type="submit" class="fcbtn btn btn-danger btn-outline btn-1d">
                    <?php echo get_phrase('update'); ?>
                </button>
            </div>
        </form>

    </div>
</div>


<script type="text/javascript">
    jQuery(document).ready(function () {
        $(".numeric").numeric();
    });
</script>


