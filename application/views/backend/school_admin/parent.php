<div class="row bg-title"> 
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
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
<?php if ($this->session->flashdata('flash_validation_error')) { ?>        
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('flash_validation_error') . get_phrase('so_could_not_update_/_edit_profile'); ?>
            </div>
        <?php } ?>
        
	
    
        <div class="text-right m-b-20" >
        <a href="<?php echo base_url(); ?>index.php?school_admin/parent_add/" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger m-b-20" data-step="5" data-intro="<?php echo get_phrase('From here you can add the Parent.');?>" data-position='top' data-toggle="tooltip" data-placement="left" title="" data-original-title="Add New Parent">
           <i class="fa fa-plus"></i>
        </a>
        </div>

<div class="col-sm-12 white-box" data-step="6" data-intro="<?php echo get_phrase('Here you can see the list of parents.');?>" data-position='top'>
    <div class="tab-pane box active for-table-top" id="list" >
         <table id="table" class="table display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><div><?php echo get_phrase('no'); ?></div></th>
                            <th><div><?php echo get_phrase('id'); ?></div></th>
                            <th><div><?php echo get_phrase('father_name'); ?></div></th>
                            <th><div><?php echo get_phrase('mother_name'); ?></div></th>
                            <th><div><?php echo get_phrase('phone'); ?></div></th>
                            <th><div><?php echo get_phrase('email'); ?></div></th>
                            <th><div><?php echo get_phrase('status'); ?></div></th>
                            <th><div><?php echo get_phrase('options'); ?></div></th>
                            <th data-step="7" data-intro="<?php echo get_phrase('From here you can view, edit and delete the profile of parent.');?>" data-position='left'>
                                <div>   <?php echo get_phrase('Action'); ?></div></th>
                        </tr>
                    </thead>
   
                    <tbody>
                      
                    </tbody>
                </table>
    </div>       
</div>

                     
<script type="text/javascript">

    function validateemail(email) {
        $.post("<?php echo base_url(); ?>index.php?Validate/validateemail/", {email: email}, function (response) {
            if (response == 'invalid') {
                toastr.error('<?php echo get_phrase('email_already_taken') ?>');
                document.getElementById('parent_email').value = '';
            }
        });
    }
    
    

</script>

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
                "url": "<?php echo base_url().'index.php?ajax_controller/all_parents/';?>",
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
                { "targets": [0,7,8], "orderable": false },                 
            ],

        });
        if(SearchName!=''){            
            table.search(SearchName).draw();
        }
    });
</script>

