<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('edit_category'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/inventory_category"><?php echo get_phrase('inventory'); ?></a></li>
            <li class="active"><?php echo get_phrase('edit_category'); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div> 
<?php extract($data); ?>
<div class="row">
    <div class="col-md-12 white-box">
        <form action="<?php echo base_url(); ?>index.php?school_admin/inventory_category/do_update/<?php echo $categories_id; ?>" method="post">
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <label for="field-1"><?php echo get_phrase("categories_name"); ?><span class="mandatory"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="ti-user"></i></div>                  
                        <input type="text" class="form-control" id="categoriesName" value="<?php echo $categories_name; ?>" placeholder="Categories Name" name="categoriesName" autocomplete="off" required="required">
                    </div> 
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <label for="field-1"><?php echo get_phrase("status"); ?><span class="mandatory"> *</span></label>
                    <select class="form-control" id="categoriesStatus" data-style="form-control" name="categoriesStatus" required="required" data-live-search="true">
                        <option value="Available" <?php if($categories_status == "Available"){ echo "selected"; }?>>Available</option>
                        <option value="Alloted" <?php if($categories_status == "Alloted"){ echo "selected"; }?>>Not Available</option>
                    </select>
                </div>
            </div>
            <div class="clearfix">&nbsp;</div>
            <!-- /form-group-->
            <div class="text-right">
                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('update'); ?></button>
<!--                <a href="<?php // echo base_url(); ?>index.php?school_admin/inventory_category/">
                    <button  type="button" class="fcbtn btn btn-danger btn-outline btn-1d"><?php // echo get_phrase('cancel'); ?>
                    </button></a>-->
            </div>

        </form>
    </div>
</div>






