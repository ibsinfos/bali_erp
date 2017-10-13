<div class="row bg-title"> 
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?bus_driver/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
</div>

               
<div class="col-sm-12 white-box">            
<table id="table" class="table display">
    <thead>
        <tr>
            <th><div><?php echo get_phrase('s._no.'); ?></div></th>
            <th><div><?php echo get_phrase('name'); ?></div></th>
            <th><div><?php echo get_phrase('unique_key'); ?></div></th>
            <th><div><?php echo get_phrase('description'); ?></div></th>
            <th><div><?php echo get_phrase('route'); ?></div></th>
            <th><div><?php echo get_phrase('avaiable_seats'); ?></div></th>
            <!--<th><div><?php echo get_phrase('options'); ?></div></th>-->
        </tr>
    </thead>
    <tbody>
       
    </tbody>
</table>
</div>  
<script type="text/javascript">
    var table;

    $(document).ready(function() {
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
                "url": "<?php echo base_url().'index.php?ajax_controller/get_bus_list_driver/';?>",
                "type": "POST",
            },
            "success" : function(response){
                console.log(response.data);
                
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                { "targets": [0, 3], "orderable": false },                 
            ],

        });
        table.$('tr').tooltip( {selector: '[data-toggle="tooltip"]'});

    });
    
</script>


