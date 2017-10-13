<div class="row bg-title">  
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?student/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase('teacher'); ?></li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="text-right col-xs-12 m-b-20">	
        <button type="button" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="My Teachers" data-step="5" data-intro="Here you can view your teacher's list." data-position='left' onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_my_teacher_info');">
            <i class="fa fa-users"></i>
        </button> 
    </div>

</div>
<div class="row m-0">
    <div class=" col-sm-12 white-box" data-step="6" data-intro="<?php echo get_phrase('Here you can view list of teachers.');?>" data-position='top'>
        <table id="table" class="table display" cellspacing="0" width="100%">

            <thead>
                <tr>
                    <th><div><?php echo get_phrase('s_no.'); ?></div></th>
                    <th><div><?php echo get_phrase('photo'); ?></div></th>
                    <th><div><?php echo get_phrase('name'); ?></div></th>
                    <th><div><?php echo get_phrase('email'); ?></div></th>
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
                "url": "<?php echo base_url().'index.php?ajax_controller/all_teacher_student_login/';?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                { "targets": [0,1], "orderable": false },                 
            ],

        });
        table.$('tr').tooltip( {selector: '[data-toggle="tooltip"]'});

        if(SearchName!=''){            
            table.search(SearchName).draw();
        }
    });
    
</script>
