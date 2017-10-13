<?php echo form_open(base_url() . 'index.php?school_admin/get_exam_subject/save_subjects', array('class' => 'form-groups-bordered validate', 'id' => 'exam_subjects_form')); ?>
<input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>" />
<input type="hidden" name="class_id" value="<?php
if (!empty($class_id)) {
    echo $class_id;
}
?>" />
<input type="hidden" name="section_id" value="<?php
if (!empty($section_id)) {
    echo $section_id;
}
?>" />
<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <table id="example23" class="display nowrap table_edjust" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>
                            <div>
                                <?php echo get_phrase('No'); ?>
                            </div>
                        </th>

                        <th>
                            <div>
                                <?php echo get_phrase('subject_name'); ?>
                            </div>
                        </th>
                        <th>
                            <div>
                                <?php echo get_phrase('invigilator'); ?>
                            </div>
                        </th>
                        <th>
                            <div>
                                <?php echo get_phrase('start_time'); ?>
                            </div>
                        </th>
                        <th>
                            <div>
                                <?php echo get_phrase('duration_(_in_minutes)'); ?>
                            </div>
                        </th>

                        <th>
                            <div>
                                <?php echo get_phrase('room_no'); ?>
                            </div>
                        </th>

                    </tr>
                </thead>

                <tbody>
                    <?php
                    $count = 1;
                    foreach ($subjects as $row):
                        ?>
                        <tr>
                            <td>
                                <?php echo $count++; ?>
                            </td>

                            <td>
                                <?php echo $row['name']; ?>
                                <input type="hidden" name="subject_id[]" value="<?php echo $row['subject_id']; ?>" />
                            </td>

                            <td>

                                <select name='teacher[]' required="required" class="form-control input-md selectpicker" data-sytle="form-control" id="title"  data-live-search="true" data-container="body">
                                    <?php
                                    echo "<option value='No teacher Selected' required>Select teacher</option>";

                                    foreach ($teachers as $teacher) {

                                        if ($exam_routine && $teacher['teacher_id'] == $exam_routine[$count - 2]['invigilator']) {
                                            echo "<option selected='selected' value='" . $teacher['teacher_id'] . "'>" . $teacher['name'] . "</option>";
                                        } else {
                                            echo "<option value='" . $teacher['teacher_id'] . "'>" . $teacher['name'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </td>


                            <td>
                                <div>
                                    <div class='input-group date'>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                        <input type='text' name="start_time[]" required="required" class="form-control datetimepicker1" value="<?php if(count($exam_routine)){
                                            echo $exam_routine[$count - 2]['start_datetime']; }?>"/>
                                    </div>
                                </div>
                            </td>

                            <td>

                                <input class="form-control" required="required" type="text" onkeypress="return isNumber(event)" value="<?php
                                if (!empty($exam_routine[$count - 2]['duration'])) {
                                    echo $exam_routine[$count - 2]['duration'];
                                }
                                ?>" name="duration[]" />
                            </td>

                            <td>
                                <input class="form-control" required="required" type="text" value="<?php
                                if (!empty($exam_routine[$count - 2]['room_no'])) {
                                    echo $exam_routine[$count - 2]['room_no'];
                                }
                                ?>" name="room_no[]" />
                            </td>


                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="text-right">
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d">Submit</button>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(function () {
        $('.datetimepicker1').datetimepicker({
            startDate:new Date(),
            format: 'yyyy-mm-dd hh:ii'
        });
    });

    $('#example23').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
            'copy', 'excel', 'pdf', 'print'
        ],
        "drawCallback": function () {
            $('.selectpicker').selectpicker({dropupAuto: false});
        }
    });

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>

