<link rel="stylesheet" type="text/css" href="assets/new_assets/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="assets/new_assets/css/datatable.css"/>
<script type="text/javascript" src="assets/new_assets/js/datatable.js"></script>
<div class="row">
	<div class="col-md-12">
    
    	<!------CONTROL TABS START------->
		<ul class="nav nav-tabs bordered">
                    <li class="active">
                        <a href="#list" data-toggle="tab">
                            <span class="hidden-xs"><i class="entypo-menu"></i> <?php echo get_phrase('book_list');?></span>
                            <span class="visible-xs"><i class="entypo-menu"></i> </span>
                    	</a>
                    </li>
		</ul>
    	<!------CONTROL TABS END------->
        
	
		<div class="tab-content">
            <!----TABLE LISTING STARTS--->
            <div class="tab-pane box active" id="list">
					
                <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered datatable" id="table_export">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>
                    		<th><div><?php echo get_phrase('book_name');?></div></th>
                    		<th><div><?php echo get_phrase('author');?></div></th>
                    		<th><div><?php echo get_phrase('description');?></div></th>
                    		<th><div><?php echo get_phrase('price');?></div></th>
                    		<th><div><?php echo get_phrase('class');?></div></th>
                    		<th><div><?php echo get_phrase('status');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;foreach($books as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
							<td><?php echo $row['name'];?></td>
							<td><?php echo $row['author'];?></td>
							<td><?php echo $row['description'];?></td>
							<td><?php echo $row['price'];?></td>
							<td><?php echo $row['class_name'];?></td>
							<td><span class="label label-<?php if($row['status']=='available')echo 'success';else echo 'secondary';?>"><?php echo $row['status'];?></span></td>
							
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
			</div>
            <!----TABLE LISTING ENDS--->
            
            
			
            
		</div>
	</div>
</div>
<script type="text/javascript">

    jQuery(document).ready(function ($)
    {
        loadDataTable();
        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });
        
    });
    
   
    function loadDataTable() {
        var section_ids         =   "#table_export ,"+$("#section_ids").val();
        
        var datatables = $(section_ids).dataTable({
			  rowReorder: {
            selector: 'td:nth-child(2)'
			},
                        destroy: true,
			responsive: true,
            "sPaginationType": "bootstrap",
             dom: 'Bfrtip',
                        buttons: [
                            'pageLength',
                            {
                                extend: 'excel',
                                exportOptions: {
                                      columns: [0,1,2,3,4,5]
                                }
                            },
                            {
                                extend: 'pdf',
                                exportOptions: {
                                    columns: [0,1,2,3,4,5]
                                }
                            },
                            {
                                extend: 'print',
                                exportOptions: {
                                    columns: [0,1,2,3,4,5]
                                }
                            },
                        ]
        });
    }
       
     
</script>
