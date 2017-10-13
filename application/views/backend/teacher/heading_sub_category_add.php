<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"><h4 class="page-title"><?php echo get_phrase('category_list'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?teacher/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?teacher/progress_report"><?php echo get_phrase('progress_report'); ?></a></li>
            <li ><a href="<?php echo base_url(); ?>index.php?teacher/progress_report_heading_setting"><?php echo get_phrase('progress_reports_settings'); ?></a></li>
            <li class="active"><?php echo get_phrase('add_category'); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<div class="panel panel-danger block6" data-step="5" data-intro="For Information" data-position='bottom'>
    <div class="panel-heading"> Teacher Notes
        <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
    </div>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
            <p> Dear Teacher, Please add sub categories for this category. </p>
        </div>
    </div>
</div>

<div class="form-group col-sm-5 p-0">
    <select data-style="form-control" data-live-search="true" class="selectpicker" data-style="form-control" onchange="window.location = this.options[this.selectedIndex].value">
        <option value="">Select Heading</option>
        <?php foreach ($heading_data as $row): ?>
            <option <?php
            if ($heading_id == $row['heading_id']) {
                echo 'selected';
            }
            ?> value="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/heading_sub_category_add/<?php echo $row['class_id']; ?>/<?php echo $row['heading_id']; ?>">
            <?php echo $row['heading_description']; ?>
            </option>
<?php endforeach; ?>
    </select>
</div>


<?php if ($class_id != '') :
    ?>
    <div class="row m-0">
        <div class="col-md-12 white-box">
            <div class="sttabs tabs-style-flip">
                <nav>
                    <ul>
                        <li class="active">
                            <a href="#home" class="sticon fa fa-list"><span><?php echo get_phrase('all_categories'); ?></span>
                            </a>
                        </li>
                        <li><a href="#add" class="sticon fa fa-plus-circle">
                                <span><?php echo get_phrase('add_categories'); ?></span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="content-wrap">
                    <section id="home">          
                        <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
                            <thead>
                                <tr>
                                    <th><div><?php echo get_phrase('s.no'); ?></div></th>
                                    <th width="70%"><div><?php echo get_phrase('assessment_category'); ?></div></th>
                                    <th><div><?php echo get_phrase('options'); ?></div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                foreach ($category_data as $row):
                                    ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $row['description']; ?></td>

                                        <td>
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_progress_report_category_edit/<?php echo $row['category_id']; ?>/<?php echo $class_id; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit Category"><i class="fa fa-pencil-square-o"></i></button></a>
                                            <!--delete-->
                                            <a href="<?php echo base_url(); ?>index.php?teacher/add_sub_category_inCategory/<?php echo $row['category_id']; ?>/<?php echo $row['heading_id']; ?>"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Add Subcategory"><i class="fa fa-outdent"></i></button></a>

                                            <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?teacher/progress_report_category_setting_function/delete/<?php echo $row['category_id']; ?>/<?php echo $class_id; ?>/<?php echo $row['heading_id']; ?>')"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete Category"><i class="fa fa-trash-o"></i></button></a>
                                        </td>
                                    </tr>
    <?php endforeach; ?>
                            </tbody>
                        </table>

                    </section>

                    <section id="add">
                        <form class="form-horizontal form-groups-bordered validate" name='add_heading' id="add_exam_form" method="post" action="<?php echo base_url(); ?>index.php?teacher/progress_report_category_setting_function/create/<?php echo $class_id; ?>">
                            <div class="row">          
                                <div class="col-xs-12 col-md-offset-3 col-md-6">
                                    <label><?php echo get_phrase('category'); ?></label>

                                    <input type="hidden" value="<?php echo $heading_id; ?>" name="heading_id">
                                    <textarea class="form-control" rows="5" id="category" name="category" data-validate="required" required="required" data-message-required="<?php echo get_phrase('value_required'); ?>" placeholder="Please enter category" required="required"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12 text-right m-t-10">
                                    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit'); ?></button>
                                </div>

                            </div>                             
                        </form>

                    </section>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
    
