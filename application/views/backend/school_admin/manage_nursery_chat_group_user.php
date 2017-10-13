<link rel="stylesheet" type="text/css" href="assets/new_assets/css/bootstrap1.min.css">
        <link rel="stylesheet" type="text/css" href="assets/new_assets/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="assets/new_assets/css/datatable.css"/>
        <script type="text/javascript" src="assets/new_assets/js/datatable.js"></script>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="entypo-menu"></i> Manage Nursery chat group user</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

				

				<div class="div-action pull pull-right" style="padding-bottom:15px;">
<a href="#" class="btn btn-success button1" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_add_nursery_chat_group_user/<?php echo $group_id; ?>');"> <i class="entypo-plus-circled"></i> Connect user to nursery chat group </a>
				</div> <!-- /div-action -->				
				
                                            
				<table class="table" id="table_export">
					<thead>
						<tr>							
                                                    <th>User Name</th>
                                                    <th>User Type</th>
                                                    <th style="width:15%;">Options</th>
						</tr>
                                        </thead>
                                        <tbody>
                                                <?php foreach ($nursery_chat_group_user as $row){ ?><tr>
                                                    <td>
                                                        <?php echo ($row->user_type=='1')?$row->name : $row->father_name; ?>
                                                    </td>
                                                  
                                                    <td> <?php echo ($row->user_type=='1')? 'Teacher' : 'Parent';?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                            Action <span class="caret"></span>
                                        </button>
                                                         <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                                            <li>
                                                                <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/connect_user_to_chat_group/<?php echo $group_id;?>/delete/<?php echo $row->group_user_id;?>');">
                                                                    <i class="entypo-trash"></i>
                                                                    <?php echo get_phrase('delete'); ?>
                                                                </a>
                                                            </li>
                                                         </ul>
                                                        </div>
                                                    </td>
                                                </tr><?php  } ?>
                                        </tbody>
				</table>
				<!-- /table -->

			</div> <!-- /panel-body -->
		</div> <!-- /panel -->		
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->

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
                                      columns: [0, 1]
                                }
                            },
                            {
                                extend: 'pdf',
                                exportOptions: {
                                    columns: [0, 1]
                                }
                            },
                            {
                                extend: 'print',
                                exportOptions: {
                                    columns: [0, 1]
                                }
                            },
                        ]
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });
    });  
</script>
