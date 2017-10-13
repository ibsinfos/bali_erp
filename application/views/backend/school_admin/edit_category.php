<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('edit_category'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);"  onclick="javascript:introJs().start();" id="take-tour"  class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>index.php?school_admin/dashboard">
                    <?php echo get_phrase('Dashboard'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>index.php?discussion_forum/create_category">
                    <?php echo get_phrase('Create_category'); ?>
                </a>
            </li>
            <li class="active">
                <?php echo get_phrase('edit_category'); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>



<div class="row">
    <div class="col-md-12">
        <div class="white-box" data-step="5" data-intro="<?php echo get_phrase('Here you can edit the category details.');?>" data-position="top">
            <?php $row = array_shift($edit_data); ?>
            <?php echo form_open(base_url() . 'index.php?discussion_forum/edit_category/edit/' . $row['category_id'], array('class' => 'form-groups-bordered validate', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>


            <div class="row">
                <div class="col-md-8 form-group">
                    <label>
                        <?php echo get_phrase('category_name'); ?><span class="error mandatory"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-pencil-square"></i></div>
                        <input type="text" class="form-control" name="category_name" id="category_name" value="<?php echo $row['name']; ?>" data-validate="required" data-message-required="Please enter a category" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    <div class="text-right m-t-20">
                        <button data-step="6" data-intro="<?php echo get_phrase('Click on the Edit Category button to save the category.');?>" data-position="left" type="submit" name="submit_cat" value="submit_cat" class="fcbtn btn btn-danger btn-outline btn-1d">
                            <?php echo get_phrase('edit_category'); ?>
                        </button>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>

        </div>

    </div>
</div>

<script>
    $(function () {
        $('#category_name').change(function () {
            var name = $('#category_name').val().toLowerCase().replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
            $('#tags').val(name);
        });
    });
</script>