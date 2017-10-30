<div class="row bg-title"> 

    <!-- .page title -->   
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('Fee_collection'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();"  class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
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
    <!-- /.breadcrumb -->
</div>

<div class="row m-0">
    <div class="col-sm-12 white-box" data-step="5" data-intro="<?php echo get_phrase('Here_you_can_see_Enquired_students,_Enroll_students_etc.');?>" data-position='top'>
        <table class="table display new_table">
            <thead>
                <tr>							
                    <th>Total Number Of Enquired Students</th>
                    <th>Total Number of Enroll Students</th>
                    <th>Total Amount Collected form Students</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><b ><?php echo $count_enquire_students; ?></b></td>
                    <td><b ><?php echo(!empty($count_enroll_students)) ? $count_enroll_students : ''; ?></b></td>
                    <td><b ><?php $amt=0;foreach ($count_amount_collected as $row)
                                    $amt+= $row['count'];
                    if($amt==0) { echo $amt; }else{echo 'No collection';}
                    ?></b></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row m-0">
    <div class="col-sm-12 white-box" data-step="6" data-intro="<?php echo get_phrase('This_is_the_list_of_enquired_students.');?>" data-position='top'> 

        <table class="new_tab table display" id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Enquired Students</th>
                    <th>Total Amount to Be Paid</th>
                    <th>Total Amount Paid</th>
                    <th>Remaining Amount</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
  var table;

    $(document).ready(function() {

        var SearchName = $('#PublicSearch').val();

        //datatables
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
                "url": "<?php echo base_url().'index.php?ajax_controller/student_overview_admin_login/';?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                { "targets": [0], "orderable": false },                 
            ],

        });
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
                        columns: [0, 1, 2, 3]
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
            ]
        });
        table.$('tr').tooltip( {selector: '[data-toggle="tooltip"]'});

        if(SearchName!=''){            
            table.search(SearchName).draw();
        }

    });
</script>


