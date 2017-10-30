<div class="row bg-title"> 
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('manage_allocation'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
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
    <!-- /.breadcrumb -->
</div>
  
<div class="row">
    <div class="col-xs-12 m-b-20">
        <a href="<?php echo base_url(); ?>index.php?school_admin/hostel_registration/"  class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add Hostel Allocation" data-step="5" data-intro="From here you can add Hostel Allocation." data-position='left'>
            <i class="fa fa-plus"></i>
        </a>
    </div>
</div>

<div class="row m-0">
<div class="col-sm-12 white-box" data-step="7" data-intro="<?php echo get_phrase('This is the list of hostel allocation.');?>" data-position='top'>     
<table id="table" class="table display">
    <thead>
        <tr>
            <th><div><?php echo get_phrase('No.'); ?></div></th>
            <th><div><?php echo get_phrase('hostel_name'); ?></div></th>
            <th><div><?php echo get_phrase('student_name'); ?></div></th>
            <th><div><?php echo get_phrase('class_name'); ?></div></th>
            <th><div><?php echo get_phrase('section_name'); ?></div></th>
            <th><div><?php echo get_phrase('hostel_type'); ?></div></th>
            <th><div><?php echo get_phrase('floor'); ?></div></th>
            <th><div><?php echo get_phrase('room_no.'); ?></div></th>
            <th><div><?php echo get_phrase('food'); ?></div></th>
            <th><div><?php echo get_phrase('registered_date'); ?></div></th>
            <th><div><?php echo get_phrase('vacate_date'); ?></div></th>
            <th><div><?php echo get_phrase('transfer_date'); ?></div></th>
            <th><div><?php echo get_phrase('status'); ?></div></th>
            <th data-step="6" data-intro="<?php echo get_phrase('From here you can get actions like edit, vacant and transfer.');?>" data-position='left'><div><?php echo get_phrase('options'); ?></div></th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>
</div>
</div>

<script>
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
                "url": "<?php echo base_url('index.php?ajax_controller/all_dormitory_manage_allocation_list/');?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                { "targets": [0,13], "orderable": false },                 
            ],

        });
        table.$('tr').tooltip( {selector: '[data-toggle="tooltip"]'});

        if(SearchName!=''){            
            table.search(SearchName).draw();
        }
    });
    
</script>


