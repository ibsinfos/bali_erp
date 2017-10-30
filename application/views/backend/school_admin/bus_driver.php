<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('bus_drivers'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
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
<div class="col-md-12">
    <div class="form-group col-sm-12 p-0">
        <a href="javascript:;" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_driver_bus_add/');" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add New Driver" data-step="5" data-intro="From here you can add a new Bus Driver." data-position="left">
            <i class="fa fa-plus"></i>
        </a> 
    </div>
</div>
</div>


<?php if ($this->session->flashdata('flash_validation_error')) { ?>        
    <div class="alert alert-danger">
        <?php echo $this->session->flashdata('flash_validation_error'); ?>
    </div>
<?php } ?>
<div class="col-sm-12 white-box" data-step="6" data-intro="<?php echo get_phrase('Here you can view list of Bus Driver.');?>" data-position="top">
    <table id="table" class="table display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th><div><?php echo get_phrase('s._no.'); ?></div></th>
                <th><div><?php echo get_phrase('name'); ?></div></th>
                <th><div><?php echo get_phrase('email'); ?></div></th>
                <th><div><?php echo get_phrase('phone'); ?></div></th>
                <th><div><?php echo get_phrase('gender'); ?></div></th>
                <th><div><?php echo get_phrase('bus'); ?></div></th>
                <th><div><?php echo get_phrase('route'); ?></div></th>
                <th><div data-step="7" data-intro="<?php echo get_phrase('You can do edit or delete driver details  from here');?>" data-position='left'><?php echo get_phrase('action'); ?></div></th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

</div>

<script type="text/javascript">
    var table;

    $(document).ready(function () {

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
                "url": "<?php echo base_url() . 'index.php?ajax_controller/all_bus_drivres/'; ?>",
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
                {"targets": [0, 3, 7], "orderable": false},
            ],

        });
          if (SearchName != '') {
            table.search(SearchName).draw();
        }
    });

</script>

<script type="text/javascript">

    function validateemail(email) {
        $.post("<?php echo base_url(); ?>index.php?Validate/validateemail/", {email: email}, function (response) {
            if (response == 'invalid') {
                toastr.error('<?php echo get_phrase('email_already_taken') ?>');
                document.getElementById('bus_driver_email').value = '';
            }
        });
    }
</script>
