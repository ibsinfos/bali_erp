<style  type="text/css">
/*.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
    padding: 8px 0px;
}*/
</style>

<div class="row bg-title"> 
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
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
<div class="row">
    <div class="col-md-10 form-group">
        <div class="form-group col-sm-3 p-0" data-step="5" data-intro="<?php echo get_phrase('Select_a_class,_then_you_will_get_a_list_of_all_students_with_their_all_information.');?>" data-position='right'>
            <label class="control-label"><?php echo get_phrase('Select_Class'); ?></label>
            <select class="selectpicker" data-style="form-control" name="class_id" id="class_id" data-live-search="true" onchange="window.location = this.options[this.selectedIndex].value">
                <option value="">Select Class</option>
                <?php
                foreach ($classes as $row):
                    ?>
                    <option <?php
                    if ($class_id == $row['class_id']) {
                        echo 'selected';
                    }
                    ?> value="<?php echo base_url(); ?>index.php?school_admin/student_information/<?php echo $row['class_id']; ?>">
                            <?php echo $row['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="col-md-2 hidden-xs">
        <a href="<?php echo base_url(); ?>index.php?school_admin/student_add" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add New Student" data-step="6" data-intro="<?php echo get_phrase('From_here_you_can_add_a_new_student.');?>" data-position='left'>
            <i class="fa fa-plus"></i>
        </a> 
    </div>
</div> 
<!--<div class="row">
-->
<div class="col-md-12 white-box">
    <div class="sttabs tabs-style-flip">
        <?php if ($class_id != '') { ?>
            <nav data-step="7" data-intro="<?php echo get_phrase('Here,_students_of_all_sections_of_selected_class_will_be_displayed.');?>" data-position='top'>
                <ul>
                    <li>
                        <a href="#section-flip-1" class="sticon fa fa-users">
                            <span><?php echo get_phrase('all_students'); ?></span>
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
                    <?php } ?>
                </ul>
            </nav>

            <div class="content-wrap add-new-style">
                <section id="home">
                    <table id="table" class="table display" cellspacing="0" width="100%">
                        <thead>
                            <tr>   
                                <th width="5%"><div><?php echo get_phrase('no'); ?></div></th>
                                <!--<th><div><?php // echo get_phrase('roll_no'); ?></div></th>-->
                                <th width="10%"><div><?php echo get_phrase('name'); ?></div></th>
                                <th width="15%"><div><?php echo get_phrase("father's_Name"); ?></div></th>
                                <th width="15%"><div><?php echo get_phrase("mother's_Name"); ?></div></th>
                                <th width="8%"><div><?php echo get_phrase('gender'); ?></div></th>
                                <th width="10%"><div><?php echo get_phrase('emergency_contact'); ?></div></th>
                                <th width="10%"><div><?php echo get_phrase('medical_condition'); ?></div></th>
                                <!-- <th width="5%"><div><?php echo get_phrase('media_consent'); ?></div></th> -->
                                <th width="5%"><div><?php echo get_phrase('status'); ?></div></th>
            <th data-step="8" data-intro="<?php echo get_phrase('Here,_You_can_view_student_\'s_Academic_performance,Marksheet,Documents_and_Enable_or_Disable_the_student.');?>" data-position='top' width="5%"><div><?php echo get_phrase('options'); ?></div>
                                </th>
<th data-step="9" data-intro="<?php echo get_phrase('Here,_You_can_view_student_profile,_edit_and_delete_options_also_available.');?>" data-position='top' width="17%"><div><?php echo get_phrase('actions'); ?></div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </section>
                <?php
                if ($sections != '') {
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
                                        <th style="width: 5% !important;"><div><?php echo get_phrase('no'); ?></div></th>
                                        <th style="width: 5% !important;"><div><?php echo get_phrase('roll_no'); ?></div></th>
                                        <th style="width: 5% !important;"><div><?php echo get_phrase('name'); ?></div></th>
                                        <th style="width: 10% !important;"><div><?php echo get_phrase("father's_Name"); ?></div></th>
                                        <th style="width: 12% !important;"><div><?php echo get_phrase("mother's_Name"); ?></div></th>
                                        <th style="width: 8% !important;"><div><?php echo get_phrase('gender'); ?></div></th>
                                        <th style="width: 8% !important;"><div><?php echo get_phrase('emergency_contact'); ?></div></th>
<!--                                        <th width="10%" class="hide"><div><?php //echo get_phrase('medical_condition'); ?></div></th>-->
                                        <th style="width: 10% !important;"><div><?php echo get_phrase('media_consent'); ?></div></th>
                                        <th style="width: 10% !important;"><div><?php echo get_phrase('status'); ?></div></th>
                                        <th style="width: 10% !important;"><div><?php echo get_phrase('options'); ?></div></th>
                                        <th style="width: 15% !important;"><div><?php echo get_phrase('actions'); ?></div></th>
                                    </tr>
                                </thead>

                                <tbody>
                                </tbody>

                            </table>

                        </section>

                        <?php
                    }
                }
                ?>

            <?php } ?>

        </div>


    </div>
</div>
<!--</div>-->

<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">
    var table;
    $(document).ready(function () {
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
                "url": "<?php echo base_url() . 'index.php?ajax_controller/student_information_ajax_list_all/' . $class_id; ?>",
                "type": "POST",
                "dataSrc": function (data) {
                    setTimeout(function () {
                        $('[data-toggle="tooltip"]').tooltip();
                    }, 0);
                    return data.data;
                }
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                {"targets": [0, 8, 9], "orderable": false},
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
                    "url": "<?php echo base_url() . 'index.php?ajax_controller/student_information_ajax_list_section/' . $class_id . '/'; ?>" + section_id,
                    "type": "POST",
                    "dataSrc": function (data) {
                        setTimeout(function () {
                            $('[data-toggle="tooltip"]').tooltip();
                        }, 0);
                        return data.data;
                    }
                },

                //Set column definition initialisation properties.
                "columnDefs": [
                    {"targets": [0, 9, 10, 10], "orderable": false},
                ],

            });

        });


       
        /*table.columns().iterator( 'column', function (ctx, idx) {
            $( table.column(idx).header() ).append('<span class="sorting"/>');
            
          } );*/
        //datatables for sections ends here

        table.$('tr').tooltip({selector: '[data-toggle="tooltip"]'});

        if (SearchName != '') {
            table.search(SearchName).draw();
        }

    });
</script>
