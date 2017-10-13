<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"><h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" target="_blank" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?teacher/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<div class="row">
<div class="col-md-12">
    <div class="white-box">
<table id="table" class="table display" cellspacing="0" width="100%">
                	<thead>
                        <tr>
                            <th width="80"><div><?php echo get_phrase('No'); ?></div></th>
                            <th><div><?php echo get_phrase('name'); ?></div></th>
                            <th><div><?php echo get_phrase("father's_Name"); ?></div></th>
                            <th><div><?php echo get_phrase("mother's_Name"); ?></div></th>
                            <th><div><?php echo get_phrase('gender'); ?></div></th>
                            <th><div><?php echo get_phrase('date_of_birth'); ?></div></th>
                         </tr>
                    </thead>
                    <tbody>
                    	
                    </tbody>
                </table>
			</div>
            <!----TABLE LISTING ENDS-->
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
                "url": "<?php echo base_url().'index.php?ajax_controller/student_list_teacher_login/';?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                { "targets": [0], "orderable": false },                 
            ],

        });
        table.$('tr').tooltip( {selector: '[data-toggle="tooltip"]'});

       if(SearchName!=''){            
           table.search(SearchName).draw();
       }
    });
    
</script>



 