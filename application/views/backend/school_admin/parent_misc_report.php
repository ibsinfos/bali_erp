<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('parents_report_overview'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);"  onclick="javascript:introJs().start();" id="take-tour"  class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
         <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>

<?php $BRC = get_bread_crumb(); if (strpos($BRC, '^') !== false) { $ExpBrd = explode('^', $BRC);?>
            <li>
                <?php echo get_phrase(@$ExpBrd[0]); ?>
                <?php echo @$ExpBrd[1]; ?>
            </li> <?php }else{ $ExpBrd[2] = $BRC;}?>
            <li class="active">
                <?php echo get_phrase(@$ExpBrd[2]); ?>
            </li>
        </ol>
    </div>
</div>
<?php $cYear = date('Y') + 1; ?>
    <div class="col-md-12 white-box" data-step="5" data-intro="<?php echo get_phrase('Here you can select the running session and the class for searching parent.');?>" data-position="top">
        <div class="col-sm-4 form-group">
            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('running_session'); ?></label>
            <span class="error" style="color: red;"> </span>

            <select class="selectpicker" data-style="form-control" data-live-search="true" name="running_year" id="running_year" onchange="updateStudentFilter();">
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
            <select class="selectpicker" data-style="form-control" data-live-search="true" name="class_id" id="class_id" onchange="updateStudentFilter();">
                <option value=""><?php echo get_phrase('select_class'); ?></option><?php foreach ($classes as $row): ?>
                    <option <?php if ($class_id == $row['class_id']) {
                        echo 'selected';
                    } ?> value="<?php echo $row['class_id']; ?>"><?php echo get_phrase('class'); ?>&nbsp;<?php echo $row['name']; ?></option>
<?php endforeach; ?>
            </select>
        </div>

        <div class="text-right">
            <div class="white-box">
                <input type="button" class="fcbtn btn btn-danger btn-outline btn-1d" value="Advance Filter" id="FilterStudentData" value="Advance Filter"
                       name="FilterStudentData" onclick="window.open('<?php echo base_url() . "index.php?admin_report/parent_misc_report_advance_filter/"; ?>');">
            </div>
        </div>
    </div>

<?php if ($class_id != '') { ?>
    <div class="col-md-12 white-box">

        <div class="sttabs tabs-style-flip">

<?php if ($class_id != '') { ?>
                <nav>                  <ul>
                        <li class="active">
                            <a href="" class="sticon fa fa-list">
                                <span><?php echo get_phrase('all_students'); ?> </span>
                            </a>  
                        </li>

                        <?php
                        if (!empty($sections)) {
                            foreach ($sections as $row):
                                ?>
                                <li>
                                    <a href="#table_export_<?php echo $row['section_id']; ?>" class="sticon fa fa-list">
                                        <span><?php echo get_phrase('section'); ?> <?php echo $row['name']; ?> </span>
                                    </a>
                                </li>
                                <?php
                            endforeach;
                            ?>
                        <?php }
                    } ?>


                </ul>  
            </nav>
            <div class="content-wrap">
                <section id="home">
                    <table id="table" class="table display" cellspacing="0" width="100%">
                        <thead>
                            <tr>     
                                <th><?php echo get_phrase('no'); ?></th>
                                <th><div><?php echo get_phrase('student_enroll_code'); ?></div></th>
                                <th><div><?php echo get_phrase('parent_name'); ?></div></th>
                                <th><div><?php echo get_phrase('profession'); ?></div></th>            
                                <th><div><?php echo get_phrase('phone'); ?></div></th>
                                <th><div><?php echo get_phrase('email'); ?></div></th>
                                <th><div><?php echo get_phrase('status'); ?></div></th>
                                <th><div><?php echo get_phrase('options'); ?></div></th>
                            </tr>
                        </thead>

                        <tbody>
                        </tbody>

                    </table>
                </section>
                <?php
                if ($class_id != '') {
                    $datatable = "";
                    foreach ($sections as $section) {
                        $datatable = $datatable . "#table_" . $section['section_id'] . ",";
                    }
                    foreach ($sections as $section) {
                        ?>

                        <section id="table_export_<?php echo $section['section_id']; ?>">
                            <input type="hidden" id="section_ids_info" value="<?php echo rtrim($datatable, ","); ?>" >
                            <table id="table_section_<?php echo $section['section_id']; ?>" class="table display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>     
                                        <th><?php echo get_phrase('no'); ?></th>
                                       <th><div><?php echo get_phrase('student_enroll_code'); ?></div></th>
                                        <th><div><?php echo get_phrase('parent_name'); ?></div></th>
                                        <th><div><?php echo get_phrase('profession'); ?></div></th>            
                                        <th><div><?php echo get_phrase('phone'); ?></div></th>
                                        <th><div><?php echo get_phrase('email'); ?></div></th>
                                        <th><div><?php echo get_phrase('status'); ?></div></th>
                                        <th><div><?php echo get_phrase('options'); ?></div></th>
                                    </tr>
                                </thead>

                                <tbody>
                                </tbody>

                            </table>

                        </section>

                    <?php }
                }
                ?>
            </div>
        </div>
    </div>
<?php } ?>

<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

    $(document).ready(function () {

        var table;
        var SearchName = $('#PublicSearch').val();

        table = $('#table').DataTable({

            "dom": 'Bfrtip',
            "responsive": true,
            "buttons": [
                "pageLength",
                'copy', 'excel', 'pdf', 'print'
            ],

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source

            "ajax": {
                "url": "<?php echo base_url() . 'index.php?ajax_controller/parent_misc_report_all/' . $class_id . '/' . $student_running_year; ?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                {"targets": [0, 7], "orderable": false},
            ],

        });

        //datatables for sections start here
        var sections = $('#section_ids_info').val();
        sections = sections.split(",");
        var table_section = {};
        $.each(sections, function (index, value) {
            var section_id = value.split("_");
            section_id = section_id[1];
            table_section[ 'section_' + section_id ] = $('#table_section_' + section_id).DataTable({

                "dom": 'Bfrtip',
                "responsive": true,
                "buttons": [
                    "pageLength",
                    'copy', 'excel', 'pdf', 'print'
                ],

                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.

                // Load data for the table's content from an Ajax source

                "ajax": {
                    "url": "<?php echo base_url() . 'index.php?ajax_controller/parent_misc_report_section/' . $class_id . '/' . $student_running_year . '/'; ?>" + section_id,
                    "type": "POST"
                },

                //Set column definition initialisation properties.
                "columnDefs": [
                    {"targets": [0,7], "orderable": false},
                ],

            });

        });

        //datatables for sections ends here

        table.$('tr').tooltip({selector: '[data-toggle="tooltip"]'});

        if (SearchName != '') {
            table.search(SearchName).draw();
        }

    });

    function validateSubmition() {
        console.log("submiting");
        return false;
    }

    function updateStudentFilter() {
        var class_id = $("#class_id").val();
        var running_year = $('#running_year').val();
        if (running_year == "undefined" || running_year == "") {
            return false;
        }
        if (class_id == "undefined" || class_id == "") {
            return false;
        }
        var url = "<?php echo base_url() . "index.php?admin_report/parent_misc_report/"; ?>" + class_id + "/" + running_year;
        location.href = url;
    }

</script>
