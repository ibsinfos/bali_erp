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
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/online_exam"><?php echo get_phrase('online_exam'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<div class="row">
    <div class="col-xs-2 pull-right visible-xs add-stu-btn">
        <a href="<?php echo base_url(); ?>index.php?school_admin/add_question_online" class="btn btn-primary pull-right">
            <i class="entypo-plus-circled"></i>
            <?php echo get_phrase('add_new_question'); ?>
        </a>
    </div>

    <div class="col-md-10 no-padding">
        <div class="col-sm-6 p-b-20" data-step="5" data-intro="You can see subject wise question list here." data-position='right'>
            <label class="control-label">Select Subject</label>
            <select  class="selectpicker" data-style="form-control" data-live-search="true" onchange="window.location = this.options[this.selectedIndex].value">
                <option value="">Select Subject</option>
                <?php
                foreach ($subject as $row):
                    ?>
                    <option <?php
                    if ($subject_id == $row['subject_id']) {
                        echo 'selected';
                    }
                    ?> value="<?php echo base_url(); ?>index.php?school_admin/add_subject_online_exam/<?php echo $row['class_id']; ?>/<?php echo $exam_id ?>/<?php echo $row['subject_id']; ?>">
                            <?php echo $row['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">
        <a href="<?php echo base_url(); ?>index.php?school_admin/add_question_online/<?php echo $row['class_id']; ?>/<?php echo $exam_id; ?>" class="btn btn-primary pull-right btn_float_center" data-step="6" data-intro="You can add question for selected exam from here." data-position='left'>
            <i class="entypo-plus-circled"></i>
            <?php echo get_phrase('add_new_question'); ?>
        </a>

    </div>
</div>

<?php if ($subject_id != ''): ?>
    <div class="col-md-12 white-box" >

        <!--            <div class="tab-content">-->
        <table  class="table display" id="example23">
            <thead>
                <tr>
                    <th><div><?php echo get_phrase('no'); ?></div></th>                        
                    <th><div><?php echo get_phrase('question'); ?></div></th>                            
                    <th><div><?php echo get_phrase("class"); ?></div></th>
                    <th><div><?php echo get_phrase("expalnation"); ?></div></th>
                    <th><div><?php echo get_phrase("order"); ?></div></th>
                    <th><div><?php echo get_phrase('options'); ?></div></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                foreach ($question as $row):
                    ?>
                <td><?php echo $count++; ?></td>
                <td><?php echo $row['question']; ?></td>
                <td><?php echo "Class " . $row['class_name']; ?></td>                             
                <td><?php echo $row['explanation']; ?> </td>
                <td><?php echo $row['order']; ?> </td>
                <td>
                    <a href="<?php echo base_url(); ?>index.php?school_admin/edit_question/<?php echo $row['id']; ?>/<?php echo $row['class_id']; ?>/<?php echo $exam_id; ?>">
                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('edit'); ?>" title="<?php echo get_phrase('edit'); ?>">
                            <i class="fa fa-pencil-square-o"></i>
                        </button> 
                    </a>
                    <a href="javascript: void(0);" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/add_question_online/delete/<?php echo $row['id']; ?>/<?php echo $exam_id; ?>/<?php echo $row['class_id']; ?>/');">
                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('delete'); ?>" title="<?php echo get_phrase('delete'); ?>">
                            <i class="fa fa-trash"></i>
                        </button> 
                    </a>
                </td>

                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>

    </div>
<?php endif; ?>

<!--    </div>-->



