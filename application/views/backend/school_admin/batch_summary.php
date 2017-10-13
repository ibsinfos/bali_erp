<?php $cYear = date('Y') + 1; ?>
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?></h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" target="_blank" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active">
                <?php echo get_phrase($page_title); ?>
            </li>
        </ol>
    </div>
</div>

<div class="row">


    <div class="col-md-12 white-box">
        <div class="col-sm-4 form-group">
            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('running_session'); ?></label>
            <span class="error" style="color: red;"> </span>

            <select class="selectpicker" data-style="form-control" data-live-search="true" name="running_year" id="running_year">
                <option value=""><?php echo get_phrase('select_running_session'); ?></option>
                <?php for ($i = 0; $i < 10; $i++): ?>
                    <option value="<?php echo $cYear - $i - 1; ?>-<?php echo ($cYear - $i); ?>"
                            <?php if ($student_running_year == ($cYear - $i - 1) . '-' . ($cYear - $i)) echo 'selected'; ?>>
                        <?php echo ($cYear - $i - 1); ?>-<?php echo ($cYear - $i); ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>

        <div class="col-sm-4 form-group">
            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('class'); ?></label>
            <span class="error" style="color: red;"> </span>
            <select class="selectpicker" data-style="form-control" data-live-search="true" name="class_id" id="class_id">
                <option value=""><?php echo get_phrase('select_class'); ?></option>
                <?php foreach ($classes as $row): ?>
                    <option <?php
                    if ($class_id == $row['class_id']) {
                        echo 'selected';
                    }
                    ?> value="<?php echo $row['class_id']; ?>">
                        <?php echo get_phrase('class') . " " . $row['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-sm-4 form-group">
            <button class="fcbtn btn btn-danger btn-outline btn-1d" type="button" onclick="get_batch_summary()">
                <?php echo get_phrase('submit'); ?>
            </button>
        </div>
    </div>
</div>
<!--Tabs style-->
<div class="col-md-12">
    <div class="white-box">
        <section class="m-t-40">
            <div class="sttabs tabs-style-flip">
                <nav>
                    <ul>
                        <li><a href="javascript: void(0);" class="sticon ti-home"><span><?php echo get_phrase('students'); ?></span></a></li>
                        <li><a href="javascript: void(0);" class="sticon ti-trash"><span><?php echo get_phrase('attendance'); ?></span></a></li>
                        <li><a href="javascript: void(0);" class="sticon ti-gift"><span><?php echo get_phrase('subject_and_teachers_allocation'); ?></span></a></li>
<!--                        <li><a href="javascript: void(0);" class="sticon ti-gift"><span><?php //echo get_phrase('examination'); ?></span></a></li>-->

                    </ul>
                </nav>
                <div class="content-wrap">
                    <section id="section-flip-1">
                        <h2><?php echo($student_count) . " " . get_phrase('students'); ?></h2>
                        <div class="col-md-12 white-box">
                            <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr> 
                                        <th class="text-center">
                                            <?php echo get_phrase('student_name'); ?>
                                        </th>
                                        <th class="text-center">
                                            <?php echo get_phrase('enroll_code'); ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($student_details as $row) { ?>
                                        <tr>

                                            <td class="text-center">
                                                <?php echo $row['name'] ?>
                                            </td>

                                            <td class="text-center">
                                                <?php echo $row['enroll_code']; ?>
                                            </td> 

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                    <section id="section-flip-2">
                        <div class="col-md-12 white-box">
                            <div class="col-sm-4 form-group"> 
                                <span class="input-group-addon"><i class="icon-calender"></i></span>
                                <input type="text" class="form-control mydatepicker"  name="timestamp" id="timestamp" data-format="m-d-Y" onchange="return onchange_date()" value="<?php echo $date; ?>"> 
                            </div>
                            <div class="col-sm-8 form-group"> 
                                <h2><?php
                                    echo get_phrase('present') . "-" . $count_present . "," .
                                    get_phrase('absentees') . "-" . $count_absent . "," .
                                    get_phrase('undefinied') . "-" . $count_undefinied . "," .
                                    get_phrase('total_students') . "-" . $count_attendance
                                    ?></h2>
                            </div>
                        </div>
                        <?php if ($count_absent != "0") { ?>

                            <div class="col-md-12 white-box">
                                <table id="example23" class="custom-table display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr> 
                                            <th class="text-center">
                                                <?php echo get_phrase('student_name'); ?>
                                            </th>
                                            <th class="text-center">
                                                <?php echo get_phrase('enroll_code'); ?>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($absent as $row) { ?>
                                            <tr>

                                                <td class="text-center">
                                                    <?php echo $row['name'] ?>
                                                </td>

                                                <td class="text-center">
                                                    <?php echo $row['enroll_code']; ?>
                                                </td> 

                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else { ?>
                            <div class="col-md-12 white-box">
                                <div class="col-sm-8 form-group"> 
                                    <h2><?php echo get_phrase('no_absentees'); ?></h2>
                                </div>
                            </div>
                        <?php } ?>
                    </section>
                    <section id="section-flip-3">
                        <h2><?php
                            foreach ($subject_teacher_count as $count) {
                                echo '<div class="col-sm-4">' . get_phrase('subjects') . "-" . $count['count_subject'] . '</div>';
                                echo '<div class="col-sm-4">' . get_phrase('teachers') . "-" . $count['count_teacher'] . '</div>';
                            }
                            ?></h2>
                        <div class="col-md-12 white-box">
                            <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr> 
                                        <th class="text-center">
                                            <?php echo get_phrase('subjects'); ?>
                                        </th>
                                        <th class="text-center">
                                            <?php echo get_phrase('teachers'); ?>
                                        </th>
                                        <th class="text-center">
                                            <?php echo get_phrase('periods/week'); ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($subject_details as $row) { ?>
                                        <tr>

                                            <td class="text-center">
                                                <?php echo $row['subject_name'] ?>
                                            </td>

                                            <td class="text-center">
                                                <?php echo $row['teacher_name']; ?>
                                            </td> 
                                            <td class="text-center">
                                                <?php echo $row['periods']; ?>
                                            </td> 

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
<!--                    <section id="section-flip-4">
                        <h2>Tabbing 4</h2></section>-->

                </div>
                <!-- /content -->
            </div>
            <!-- /tabs -->
        </section>
    </div>
</div>



<script type="text/javascript">


    function validateSubmition() {
        console.log("submiting");
        return false;
    }

    function get_batch_summary() {
        var class_id = $("#class_id").val();
        var running_year = $('#running_year').val();
        if (running_year == "undefined" || running_year == "") {
            return false;
        }
        if (class_id == "undefined" || class_id == "") {
            return false;
        }
        var url = "<?php echo base_url() . "index.php?school_admin/batch_summary/"; ?>" + class_id + "/" + running_year;
        location.href = url;
    }
    function onchange_date() {
        var class_id = $("#class_id").val();
        var running_year = $('#running_year').val();
        var date = $('#timestamp').val();
        var url = "<?php echo base_url() . "index.php?school_admin/batch_summary/"; ?>" + class_id + "/" + running_year + "/" + date;
        location.href = url;
    }
    $('#example24').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
            'copy', 'excel', 'pdf', 'print'
        ]
    });
    $('#example25').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
            'copy', 'excel', 'pdf', 'print'
        ]
    });
</script>