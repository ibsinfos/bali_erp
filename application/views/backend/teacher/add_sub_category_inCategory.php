<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"><h4 class="page-title"><?php echo get_phrase('subcategory_list'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?teacher/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?teacher/progress_report"><?php echo get_phrase('progress_report'); ?></a></li>
            <li ><a href="<?php echo base_url(); ?>index.php?teacher/progress_report_heading_setting"><?php echo get_phrase('progress_reports_settings'); ?></a></li>
            <li class="active"><?php echo get_phrase('add_subcategory'); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<div class="row">
    <div class="col-md-12">

        <div class="form-group col-sm-6 p-0">
            <label class="control-label">Select Category</label>
            <select  data-style="form-control" data-live-search="true" class="selectpicker" onchange="window.location = this.options[this.selectedIndex].value">
                <option value="">Select Heading</option>
                <?php foreach ($heading as $row): ?>
                    <option <?php
                    if ($category_id == $row['category_id']) {
                        echo 'selected';
                    }
                    ?> value="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/add_sub_category_inCategory/<?php echo $row['category_id']; ?>/<?php echo $row['heading_id']; ?>">
                    <?php echo $row['description']; ?>
                    </option>
<?php endforeach; ?>
            </select>
        </div>
    </div>
</div>
<?php if ($heading_id != '') : ?>        
    <div class="row m-0">
        <div class="col-md-12 white-box">
            <div class="sttabs tabs-style-flip">
                <nav>
                    <ul>
                        <li class="active">
                            <a href="#home" class="sticon fa fa-list"><span><?php echo get_phrase('all_subcategories'); ?></span>
                            </a>
                        </li>
                        <li><a href="#add" class="sticon fa fa-plus-circle">
                                <span><?php echo get_phrase('add_subcategories'); ?></span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="content-wrap">
                    <section id="home">          
                        <table class= "custom_table table display" id="example23">
                            <thead>
                                <tr>
                                    <th><div><?php echo get_phrase('s._no.'); ?></div></th>
                                    <th width="70%"><div><?php echo get_phrase('sub_category'); ?></div></th>
                                    <th><div><?php echo get_phrase('options'); ?></div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                foreach ($heading2 as $row):
                                    ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $row['description']; ?></td>

                                        <td>
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/model_progress_report_subCategoryEdit/<?php echo $row['sub_category_id']; ?>/<?php echo $heading_id; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></button></a>
                                            <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?teacher/progress_report_sub_category/delete/<?php echo $row['sub_category_id']; ?>/<?php echo $category_id; ?>/<?php echo $heading_id; ?>')"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button></a>
                                        </td>
                                    </tr>
    <?php endforeach; ?>
                            </tbody>
                        </table>

                    </section>

                    <section id="add">
                        <form class="form-horizontal form-groups-bordered validate" name='add_heading' id="add_exam_form" method="post" action="<?php echo base_url(); ?>index.php?teacher/progress_report_sub_category/create/<?php echo $heading_id; ?>">
                            <div class="row">          
                                <div class="col-xs-12 col-md-offset-3 col-md-6">
                                    <label><?php echo get_phrase('sub_category'); ?></label>
                                    <input type="hidden" value="<?php echo $category_id; ?>" name="category_id">
                                    <textarea class="form-control" rows="5" id="category" name="sub_category" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" placeholder="Please Enter Sub Category" required="required"></textarea>
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
   


