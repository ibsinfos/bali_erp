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

<div class="text-right m-b-20" >    
    <a  href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_device_add');" 
       class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger par-add-btn" data-toggle="tooltip" 
       data-placement="left" title="" data-original-title="Add New Device">
       <i class="fa fa-plus"></i>
    </a>
</div>

<div class="col-md-12 white-box">
<table class= "custom_table table display" cellspacing="0" width="100%" id="table">
    <thead>
        <tr>
            <th><div>No:</div></th>
            <th><div>Device ID</div></th>
            <th><div><?php echo get_phrase('name');?></div></th>
            <th><div>SIM</div></th>
            <th><div>IMEI</div></th>
            <th><div>LOCATION</div></th>
            <th><div><?php echo get_phrase('edit');?></div></th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

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
                "url": "<?php echo base_url().'index.php?ajax_controller/manage_device_admin_login/';?>",
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
                { "targets": [0,6], "orderable": false },                 
            ],

        });
      

        if(SearchName!=''){            
            table.search(SearchName).draw();
        }

    });
    
</script>

