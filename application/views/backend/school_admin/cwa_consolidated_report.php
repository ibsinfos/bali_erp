

<!------CONTROL TABS START------>

<!------CONTROL TABS END------>

<!----TABLE LISTING STARTS-->
<section id="exam">
    <div class="row">
        <div class="col-md-12 white-box">
            <div class="form-group">
                <label class="control-label"><?php echo get_phrase('class'); ?></label>
                <select class="selectpicker" data-style="form-control" data-live-search="true" onchange="return onclasschange(this);">
                    <option value="">Select Class</option>
                    <?php if (count($classes)) {
                        foreach ($classes as $row): ?>
                            <option  value="<?php echo $row['class_id']; ?>">
        <?php echo get_phrase('class'); ?>&nbsp;<?php echo $row['name']; ?></option><?php endforeach;
} ?>
                </select>
            </div>

            <div class="form-group">
                <label class="control-label"><?php echo get_phrase('students'); ?></label>
                <select name="student_id" class="selectpicker" data-style="form-control" data-live-search="true" id="student_holder" onchange="return onstudentchange();" data-validate="required" data-message-required ="Please select a student">
                    <option value=""><?php echo get_phrase('select_class_first'); ?></option>
                </select>
            </div>

            <div class="form-group">
                <label class="control-label"><?php echo get_phrase('exams'); ?></label>
                <select name="exam_id" class="selectpicker" data-style="form-control" data-live-search="true" id="exam_holder" onchange="return onexamchange(this);" data-validate="required" data-message-required ="Please select a exam">
                    <option value=""><?php echo get_phrase('select_student_first'); ?></option>
                </select>
            </div>

        </div>
    </div>

    <div id="cwa_marksheet"></div>
</section>


<script type="text/javascript">
    function onclasschange(class_id)
    {

        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_class_students/' + class_id.value,
            success: function (response)
            {
                jQuery('#student_holder').html(response).selectpicker('refresh');
            }
        });
        $('#student_holder').trigger("chosen:updated");
    }
    function onclasschange1(class_id)
    {

        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_class_students/' + class_id.value,
            success: function (response)
            {
                jQuery('#student_holder1').html(response).selectpicker('refresh');
            }
        });
        $('#student_holder').trigger("chosen:updated");
    }
    function onstudentchange()
    {

        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_exams/cwa',
            success: function (response)
            {
                jQuery('#exam_holder').html(response).selectpicker('refresh');
            }
        });
        $('#exam_holder').trigger("chosen:updated");
    }
    function onstudentchange1()
    {
        var student_id1 = $('#student_holder').val();
        alert(student_id1)
        var dataObj1 = {

            'student_id': student_id1
        };
        alert("here");
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/cwa_consolidated',
            type: POST,
            data: dataObj1,
            success: function (response)
            {
                jQuery('#cwa_consolidated').html(response).selectpicker('refresh');
            }
        });

    }
    function onexamchange(exam_id)
    {
        var student_id = $('#student_holder').val();

        var dataObj = {
            'exam_id': exam_id.value,
            'student_id': student_id
        };
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/cwa_marks',
            type: 'POST',
            data: dataObj,
            success: function (response)
            {
                jQuery('#cwa_marksheet').html(response).selectpicker('refresh');
            }
        });

    }
    (function () {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
            new CBPFWTabs(el);
            $('#cce').hide();
            $('#cce_outer').removeClass('tab-current');
        });
    })();
</script>