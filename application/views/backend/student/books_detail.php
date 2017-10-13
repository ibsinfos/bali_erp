<link rel="stylesheet" type="text/css" href="assets/new_assets/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="assets/new_assets/css/datatable.css"/>
<script type="text/javascript" src="assets/new_assets/js/datatable.js"></script>
<div class="row">
    <div class="col-md-12">

        <!------CONTROL TABS END------>
        <div class="tab-content">
            <br>            
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">

                <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th><div><?php echo get_phrase('book_title'); ?></div></th>
                    <th><div><?php echo get_phrase('author_name'); ?></div></th>
                    <th><div><?php echo get_phrase('isbn_number'); ?></div></th>
                    <th><div><?php echo get_phrase('note'); ?></div></th>
                    <th><div><?php echo get_phrase('total_books'); ?></div></th>
                    <th><div><?php echo get_phrase('available_books'); ?></div></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            $count = 1;
                            foreach ($books as $row):
                                ?>
                                <tr>
                                    <td><?php echo $row['book_title']; ?></td>
                                    <td><?php echo $row['book_author']; ?></td>
                                    <td><?php echo $row['isbn_number']; ?></td>
                                    <td><?php echo $row['book_note']; ?></td>
                                    <td><?php echo $row['total_books']; ?></td>
                                    <td><?php echo $row['available_books']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!----TABLE LISTING ENDS--->
        </div>
    </div>
</div>

<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">
jQuery(document).ready(function ($)
    {
   var datatable = $("#table_export").dataTable({
     rowReorder: {
            selector: 'td:nth-child(2)'
   },
   responsive: true,
            "sPaginationType": "bootstrap",
                dom: 'Bfrtip',
                        buttons: [
                            'pageLength',
                            {
                                extend: 'excel',
                                exportOptions: {
                                      columns: [0,1,2,3,4,5]
                                }
                            },
                            {
                                extend: 'pdf',
                                exportOptions: {
                                    columns: [0,1,2,3,4,5]
                                }
                            },
                            {
                                extend: 'print',
                                exportOptions: {
                                    columns: [0,1,2,3,4,5]
                                }
                            },
                        ]
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });
    });  
</script>

