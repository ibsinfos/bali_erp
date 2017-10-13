
<table class="table table-bordered datatable" id="table_export">
 
    <thead>
        <tr>
            <th>No.</th>
            <th><div><?php echo get_phrase('name'); ?></div></th>
            <th><div><?php echo get_phrase('gender'); ?></div></th>
            <th><div><?php echo get_phrase('phone'); ?></div></th>
            <th><div><?php echo get_phrase('bus no'); ?></div></th>
        </tr>
    </thead>
    <tbody>
           <a href="javascript:;" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_driver_add/');" 
   class="btn btn-primary pull-right">
    <i class="entypo-plus-circled"></i>
    <?php echo get_phrase('add_new_driver'); ?>
</a> 
<br><br>
        <?php $count = 1; foreach ($list_drivers as $list_driver): ?>
            <tr>
                <td><?php echo $count++; ?></td>
                <td><?php echo $list_driver['name']; ?></td>
                <td><?php echo $list_driver['sex']; ?></td>
                <td><?php echo $list_driver['phone']; ?></td>
                <td><?php echo $list_driver['bus_id']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
                   
<script type="text/javascript">
    jQuery(document).ready(function ($) {
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
                        }
                    }
                ]
            }
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });
    });
    
    function myNavFunc(a,b) {
        if((navigator.platform.indexOf("iPhone") != -1) || (navigator.platform.indexOf("iPod") != -1) || (navigator.platform.indexOf("iPad") != -1))
            window.open("maps://maps.google.com/maps?daddr="+a+","+b+"&amp;ll=");
        else
            window.open("http://maps.google.com/maps?daddr="+a+","+b+"&amp;ll=");
    }
</script>

