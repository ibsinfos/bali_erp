<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('Certificates'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?doctor/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?doctor/clinical_history"><?php echo get_phrase('clinical_history'); ?></a></li>
            <li class="active">
                <?php echo get_phrase($page_title); ?>
            </li>
        </ol>
    </div>
</div>

<div class="col-md-12 white-box" data-step="5" data-intro="<?php echo get_phrase('Here select the class,section and date.'); ?>" data-position='top'>
    <div class="col-sm-4 form-group">
        <label for="field-1"><?php echo get_phrase('Select_Class'); ?><span class="error" style="color: red;"> *</span></label>
        <select class="selectpicker" data-style="form-control" id="classs_id" name="class_id" data-live-search="true" onchange="select_section(this.value)">
            <option value=""><?php echo get_phrase('select_class'); ?></option>
            <?php foreach ($classes as $row): ?>
                <option value="<?php echo $row['class_id']; ?>" <?php if ($class_id == $row['class_id']) echo "selected"; ?>><?php echo get_phrase('class'); ?>&nbsp;<?php echo $row['name']; ?></option>
            <?php endforeach; ?>
        </select> 
        <label style="color:red;"> <?php echo form_error('class_id'); ?></label>
    </div>

    <div class="col-sm-4 form-group">
        <label class="control-label"><?php echo get_phrase('select_section'); ?></label>
        <select id="section_holder" name="section_id" class="selectpicker" data-style="form-control" onchange="onsectionchange(this);" data-step="7" data-intro="<?php echo get_phrase('Here select you section for which you want to progress detail'); ?> " data-position='top'><option value="">Select Section</option>
            <?php foreach ($sections as $section) { ?>
                <option value="<?php echo $section['section_id'] ?>" <?php if ($section_id == $section['section_id']) echo "selected"; ?>><?php echo $section['name']; ?></option>';

            <?php } ?>
        </select>
    </div>
    <div class="col-sm-4 form-group">
        <label class="control-label"><?php echo get_phrase('student'); ?></label>
        <?php //pre($students); die;?>
        <select id="student_holder" name="student_id" class="selectpicker" data-style="form-control" onchange="onstudentchange(this);" data-step="10" data-intro="<?php echo get_phrase('Here select you student for which you want to progress detail '); ?>" data-position='top'>  <option value="">Select Student</option>
            <?php foreach ($students as $data) { ?>
                <option value="<?php echo $data['student_id']; ?>" <?php if ($student_id == $data['student_id']) echo "selected"; ?>><?php echo $data['name']; ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="row m-b-20">
    <div class="col-md-12">
                    <a href="<?php echo base_url(); ?>index.php?doctor/add_clinical_history/" data-step="5" data-intro="From Here You Can Add A New Clinical History." data-position="left" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add Clinical History">
                <i class="fa fa-plus"></i>
            </a>
            </div>
</div>
<div class="col-md-12 white-box" data-step="7" data-intro="<?php echo get_phrase('This shows list of subject details.'); ?>" data-position='top'>

    <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
        <thead>
            <tr>
                <th><div><?php echo get_phrase('s._no.'); ?></div></th>
                <th><div><?php echo get_phrase('symptoms'); ?></div></th>
                <th><div><?php echo get_phrase('diagnosis'); ?></div></th>
                <th><div><?php echo get_phrase('prescription'); ?></div></th>
                <th><div><?php echo get_phrase('given_by'); ?></div></th>
                <th><div><?php echo get_phrase('start_date'); ?></div></th>
                <th><div><?php echo get_phrase('end_date'); ?></div></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($clinical_history_list)):
                $count = 1;
                foreach ($clinical_history_list as $row):
                    ?>
                    <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo ucfirst($row['symptoms']); ?></td>
                        <td><?php
                            echo ucfirst($row['diagnosis']);
                            ?>
                        </td>
                        <td><?php echo $row['prescription']; ?></td>
                        <td><?php echo $row['given_by']; ?></td>
                        <td><?php echo $row['start_date']; ?></td>
                        <td>
                        <?php echo $row['end_date']; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>    





<script type="text/javascript">
    function select_section(class_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_sections_by_class/' + class_id,
            success: function (response) {
                jQuery('#section_holder').html(response).selectpicker('refresh');
            }
        });
    }

    function onsectionchange(section_id)
    {
        var class_id = $('#classs_id').val();
        jQuery('#student_holder').html('<option value="">Select Student</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>/index.php?doctor/get_student_by_section_class/' + section_id.value + '/' + class_id,
            success: function (response)
            {
                jQuery('#student_holder').append(response).selectpicker('refresh');
            }
        });
        $('#student_holder').trigger("chosen:updated");
    }

    function onstudentchange(student_id)
    {  // remove the below comment in case you need chnage on document ready
        var section = $("#section_holder option:selected").val();
        var student = student_id.value;
        var classname = $("#classs_id option:selected").val();
        location.href = "<?php echo base_url(); ?>index.php?doctor/clinical_history/" + classname + "/" + section + "/" + student;
    }
</script>