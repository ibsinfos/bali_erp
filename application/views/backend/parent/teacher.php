<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('teacher'); ?></h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?parents/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active">
                <?php echo get_phrase('teacher'); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<?php $student_id = $this->uri->segment(3); ?>
<div class="row m-b-20">
    <div class="text-right col-xs-12">	
        <button type="button" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="My Teachers" data-step="5" data-intro="<?php echo get_phrase('List teachers of your child.');?>" data-position='left' onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_show_my_class/<?php echo $student_id; ?>');" >
            <i class="fa fa-users"></i>
        </button> 
    </div>
</div>
<div class="row m-0">
    <div class="white-box" data-step="6" data-intro="<?php echo get_phrase('List the details of all teachers');?>" data-position='top'>
        <table id="table" class="display nowrap">
            <thead>
                <tr>
                    <th><div><?php echo get_phrase('no'); ?></div></th>
                    <th><div><?php echo get_phrase('photo'); ?></div></th>
                    <th><div><?php echo get_phrase('name'); ?> </div></th>
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
                "url": "<?php echo base_url().'index.php?ajax_controller/all_teachers_parent_login/';?>",
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