<a href="javascript:;" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_driver_bus_add/');" 
   class="btn btn-primary pull-right">
    <i class="entypo-plus-circled"></i>
    <?php echo get_phrase('add_new_bus_driver'); ?>
</a> 
<br><br>
<table class="table table-bordered datatable" id="table_export">
    <thead>
        <tr>
            <th>#</th>
            <th><div><?php echo get_phrase('name'); ?></div></th>
            <th><div><?php echo get_phrase('email'); ?></div></th>
            <th><div><?php echo get_phrase('phone'); ?></div></th>
            <th><div><?php echo get_phrase('gender'); ?></div></th>
            <th><div><?php echo get_phrase('bus'); ?></div></th>
            <th><div><?php echo get_phrase('route'); ?></div></th>
            <th><div><?php echo get_phrase('options'); ?></div></th>
        </tr>
    </thead>
    <tbody>
        <?php $count = 1; foreach ($bus_drivers as $driver): ?>
            <tr>
                <td><?php echo $count++; ?></td>
                <td><?php echo $driver['bus_driver_name']; ?></td>
                <td><?php echo $driver['email']; ?></td>
                <td><?php echo $driver['phone']; ?></td>
                <td><?php echo $driver['sex']; ?></td>
                <td><?php echo $driver['bus_name']; ?></td>
                <td><?php echo $driver['route_name']; ?></td>
                <td>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                            Action <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                            <li>
                                <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_driver_bus_edit/<?php echo $driver['bus_driver_id']; ?>');">
                                    <i class="entypo-pencil"></i>
                                    <?php echo get_phrase('edit'); ?>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/bus_driver/delete/<?php echo $driver['bus_driver_id']; ?>');">
                                    <i class="entypo-trash"></i>
                                    <?php echo get_phrase('delete'); ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
                   
<script type="text/javascript">

    jQuery(document).ready(function ($)
    {
        var datatable = $("#table_export").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "mColumns": [1, 2, 3, 4, 5, 6]
                    },
                    {
                        "sExtends": "pdf",
                        "mColumns": [1, 2, 3, 4, 5, 6]
                    },
                    {
                        "sExtends": "print",
                        "fnSetText": "Press 'esc' to return",
                        "fnClick": function (nButton, oConfig) {
                            datatable.fnSetColumnVis(6, false);

                            this.fnPrint(true, oConfig);

                            window.print();

                            $(window).keyup(function (e) {
                                if (e.which == 27) {
                                    datatable.fnSetColumnVis(6, true);
                                }
                            });
                        },
                    },
                ]
            },
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });
    });

    function validateemail(email) {
        $.post("<?php echo base_url(); ?>index.php?Validate/validateemail/", {email: email}, function (response) {
            if (response == 'invalid') {
                toastr.error('<?php echo get_phrase('email_already_taken') ?>');
                document.getElementById('bus_driver_email').value = '';
            }
        });
    }
</script>

