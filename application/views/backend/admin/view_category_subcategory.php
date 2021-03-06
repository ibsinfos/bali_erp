<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('add_category/subcategory'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>index.php?school_admin/dashboard">
                    <?php echo get_phrase('Dashboard'); ?>
                </a>
            </li>
            <li class="active">
                <?php echo get_phrase('add_category/subcategory'); ?>
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 m-b-20">
        <a href="<?php echo base_url(); ?>index.php?blogs/addcategory" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add Category/Subcategory" data-step="5" data-intro="<?php echo get_phrase('You_can_add_a_new_category_here!!');?>" data-position='bottom'><i class="fa fa-plus"></i>
        </a>
    </div>
</div>

<div class="col-md-12 white-box" data-step="6" data-intro="<?php echo get_phrase('Views_the_category_&_subcategory_list');?>" data-position='top'>
    <section>
        <div class="sttabs tabs-style-flip">
            <nav>
                <ul>
                    <li><a href="#section-flip-1" class="sticon fa fa-bars"><span><?php echo get_phrase('list_category');?></span></a></li>
                    <li><a href="#section-flip-2" class="sticon fa fa-bars"><span><?php echo get_phrase('list_subcategory');?></span></a></li>

                </ul>
            </nav>
            <div class="content-wrap">
                <section id="section-flip-1">
                    <?php if(!empty($blog_categories )){?>

                        <table class="custom_table table display datatable" id="example">
                            <thead>
                                <tr>
                                    <th>
                                        <div>
                                            <?php echo get_phrase('no'); ?>
                                        </div>
                                    </th>
                                    <th>
                                        <div>
                                            <?php echo get_phrase('name'); ?>
                                        </div>
                                    </th>
                                    <th>
                                        <div>
                                            <?php echo get_phrase('edit'); ?>
                                        </div>
                                    </th>
                                    <th>
                                        <div>
                                            <?php echo get_phrase('delete'); ?>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $count = 1; foreach ($blog_categories as $row): ?>
                                    <tr>
                                        <td>
                                            <?php echo $count++; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['blog_category_name'];?>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_blog_category_edit/<?php echo $row['blog_category_id']; ?>');">
                                               <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></button>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" onclick="confirm_modal('<?php echo base_url(); ?>index.php?blogs/view_category_subcategory/delete/<?php echo $row['blog_category_id']; ?>');">
                                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php } ?>
                </section>
                <section id="section-flip-2">
                    <?php if(!empty($blog_categories )){?>

                        <table class="custom_table table display" id="example">
                            <thead>
                                <tr>
                                    <th>
                                        <?php echo get_phrase('no:'); ?>
                                    </th>
                                    <th>
                                        <div>
                                            <?php echo get_phrase('name'); ?>
                                        </div>
                                    </th>
                                    <th>
                                        <div>
                                            <?php echo get_phrase('edit'); ?>
                                        </div>
                                    </th>
                                    <th>
                                        <div>
                                            <?php echo get_phrase('delete'); ?>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $count = 1; foreach ($blog_subcategories as $row): ?>
                                    <tr>
                                        <td>
                                            <?php echo $count++; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['blog_category_name'];?>
                                        </td>
                                        <td>
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_blog_subcategory_edit/<?php echo $row['blog_category_id']; ?>');">
                                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></button>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?blogs/view_category_subcategory/delete_sub/<?php echo $row['blog_category_id']; ?>');">
                                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-odelete"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php } ?>
                </section>
            </div>
            <!-- /content -->
        </div>
        <!-- /tabs -->
    </section>
</div>
