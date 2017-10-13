<link rel="stylesheet" type="text/css" href="assets/new_assets/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="assets/new_assets/css/datatable.css"/>
<script type="text/javascript" src="assets/new_assets/js/datatable.js"></script>

<div class="label label-primary pull-right label_for_chidren">
    <i class="entypo-user"></i> <?php echo $row['name'];?>
</div>

<div class="row">
	<div class="col-md-12">
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
                    <li class="active">
                        <a href="#list" data-toggle="tab">
                            <span class="hidden-xs"><i class="entypo-menu"></i> <?php echo get_phrase('invoice/payment_list');?></span>
                            <span class="visible-xs"><i class="entypo-menu"></i></span>
                    	</a>
                    </li>
		</ul>
    	<!------CONTROL TABS END------>
		<div class="tab-content">
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
				
                <table  class="table table-bordered datatable" id="table_export">
                	<thead>
                		<tr>
                    		<th><div><?php echo get_phrase('student');?></div></th>
                    		<th><div><?php echo get_phrase('title');?></div></th>
                    		<th><div><?php echo get_phrase('description');?></div></th>
                    		<th><div><?php echo get_phrase('amount');?></div></th>
                    		<th><div><?php echo get_phrase('status');?></div></th>
                    		<th><div><?php echo get_phrase('date');?></div></th>
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                        
                    	<?php 
                    foreach($invoices as $row):
                        ?>
                        <tr>
							<td><?php echo $row['stud_name']; ?></td>
							<td><?php echo $row['title'];?></td>
							<td><?php echo $row['discription'];?></td>
							<td><?php echo $row['amount'];?></td>
							<td>
                                                            <span class="label label-<?php if($row['status']=='paid')echo 'success';else echo 'danger';?>"><?php echo $row['status'];?></span>
							</td>
							<td><?php echo $row['date'];?></td>
							<td>
                            <?php echo form_open(base_url() . 'index.php?parents/invoice/' . $student_id . '/make_payment');?>
                                	<input type="hidden" name="invoice_id" value="<?php echo $row['inv_id'];?>" />
                                		<button type="submit" class="btn btn-info" <?php if($row['status'] == 'paid'):?> disabled="disabled"<?php endif;?>>
                                            <i class="entypo-paypal"></i> Pay with paypal
                                        </button>
                                </form>
                                
                            
        					</td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
			</div>
            <!----TABLE LISTING ENDS-->
            
            
			
            
		</div>
	</div>
</div>
<?php //endforeach;?>
<!-----  DATA TABLE EXPORT CONFIGURATIONS ----->                      
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

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });
    });  	
</script>