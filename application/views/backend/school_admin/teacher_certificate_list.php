<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('Certificates'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/teacher_certificates"><?php echo get_phrase('certificate'); ?></a></li>
            <li class="active">
                <?php echo get_phrase($page_title); ?>
            </li>
        </ol>
    </div>
</div>
<div class="col-md-12 white-box" data-step="5" data-intro="<?php echo get_phrase('Here_select_the_class,_section_and_date.'); ?>" data-position='top'>
    <div class="col-sm-4 form-group">
        <label for="field-1"><?php echo get_phrase('Select_teacher'); ?><span class="error" style="color: red;"> *</span></label>
        <select class="selectpicker" data-style="form-control" id="teacher_id" name="teacher_id" data-live-search="true" onchange="onteacherchange(this)">
            <option value=""><?php echo get_phrase('select_teacher'); ?></option>
            <?php foreach ($teachers as $row): ?>
                <option value="<?php echo $row['teacher_id']; ?>" <?php if ($teacher_id == $row['teacher_id']) echo "selected"; ?>><?php echo $row['name'] . " " . ($row['middle_name'] != '' ? $row['middle_name'] : '') . " " . $row['last_name']; ?></option>
            <?php endforeach; ?>
        </select> 
        <label style="color:red;"> <?php echo form_error('class_id'); ?></label>
    </div>
</div>
<!------CONTROL TABS START------>

<div class="col-md-12 white-box" data-step="7" data-intro="<?php echo get_phrase('This_shows_list_of_subject_details.'); ?>" data-position='top'>
<?php // pre($certificate_list); ?>
    <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
        <thead>
            <tr>
                <th><div><?php echo get_phrase('s._no.'); ?></div></th>
                <th><div><?php echo get_phrase('certificate_title'); ?></div></th>
                <th><div><?php echo get_phrase('sub_title'); ?></div></th>
                <th><div><?php echo get_phrase('issue_date'); ?></div></th>
                <th><div><?php echo get_phrase('template_type'); ?></div></th>
                <th><div><?php echo get_phrase('options'); ?></div></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($certificate_list)):
                $count = 1;
                foreach ($certificate_list as $row1):
                    ?>
                    <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo ucfirst($row1['certificate_title']); ?></td>
                        <td><?php echo ucfirst($row1['sub_title']); ?></td>
                        <td><?php echo $row1['date']; ?></td>
                        <td><?php echo ucfirst($row1['template_type']); ?></td>
                        <td>
                            <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_certificate_content/t/<?php echo $row1['certificate_id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></button></a>
                            <a href="<?php echo base_url(); ?>index.php?certificate/<?php echo "teacher_".strtolower($row1['template_type']); ?>/download/<?php echo $row1['teacher_id']; ?>/<?php echo $row1['certificate_id']; ?>"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Print Certificate"><i class="fa fa-print"></i></button></a></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>    
<script type="text/javascript">
    function onteacherchange(teacher_id)
    {  // remove the below comment in case you need chnage on document ready
        var teacherId = teacher_id.value;
        location.href = "<?php echo base_url(); ?>index.php?school_admin/teacher_certificate_list/" + teacherId;
    }
</script>