<link rel="stylesheet" type="text/css" href="assets/new_assets/css/bootstrap1.min.css">
<link rel="stylesheet" type="text/css" href="assets/new_assets/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="assets/new_assets/css/datatable.css"/>
<script type="text/javascript" src="assets/new_assets/js/datatable.js"></script>
<a href="<?php echo base_url();?>index.php?school_admin/expense"
    class="btn btn-primary pull-right">
        <i class="entypo-plus-circled"></i>
        <?php echo get_phrase('Add expense');?>
    </a> 
<br>

<div class="row"style="margin-top:12px;">
    <div class="col-md-12">
        
        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#home" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-doc-text-inv"></i></span>
                    <span class="hidden-xs"><i class="entypo-doc-text-inv "></i><?php echo get_phrase('all_transactions'); $class_id=1; ?></span>
                </a>
            </li>
      
            <li>
                <a href="#<?php echo get_phrase('income');?>" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-credit-card"></i></span>
                    <span class="hidden-xs"><i class="entypo-credit-card "></i><?php echo get_phrase('all_incomes');?> </span>
                </a>
            </li>
            
                        <li>
                <a href="#<?php echo get_phrase('expense');?>" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-ticket"></i></span>
                    <span class="hidden-xs"><i class="entypo-ticket "></i><?php echo get_phrase('all_expenses');?> </span>
                </a>
            </li>

        
        <?php  $count=1;?>
        </ul>
        
        <div class="tab-content">
            <div class="tab-pane active" id="home">
                
                <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th width="80"><div>#</div></th>
                            <th width="80"><div><?php echo get_phrase('title');?></div></th>
                            <th><div><?php echo get_phrase('type');?></div></th>
                            <th class="span3"><div><?php echo get_phrase('description');?></div></th>
                            <th><div><?php echo get_phrase('amount');?></div></th>
                            <th><div><?php echo get_phrase('date');?></div></th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                                foreach($payments as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
                            <td><?php echo $row['title'];?></td>
                            <td><?php echo $row['payment_type'];?></td>
                            <td><?php echo $row['description'];?></td>
                            <td><?php echo $row['amount'];?></td>
                            <td><?php echo date("d/m/Y",$row['timestamp']);?></td>
                           
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                    
            </div>
     
            <div class="tab-pane" id="<?php echo  get_phrase('income');?>">
                
                <table class="table table-bordered datatable" id="table_export1">
                    <thead>
                        <tr>
                          	<th width="80"><div>#</div></th>
                            <th width="80"><div><?php echo get_phrase('title');?></div></th>
                            <th><div><?php echo get_phrase('type');?></div></th>
                            <th class="span3"><div><?php echo get_phrase('description');?></div></th>
                            <th><div><?php echo get_phrase('amount');?></div></th>
                            <th><div><?php echo get_phrase('date');?></div></th>
                           
                        </tr>
                    </thead>
                    <tbody>
                    <?php  $count=1;?>
                        <?php 
				 $payments   =   $this->db->get_where('payment', array(
                                    'payment_type'=>"income" ))->result_array();
                                foreach($payments as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
                            <td><?php echo $row['title'];?></td>
                            <td><?php echo $row['payment_type'];?></td>
                            <td><?php echo $row['description'];?></td>
                            <td><?php echo $row['amount'];?></td>
                            <td><?php echo date("d/m/Y",$row['timestamp']);?></td>
                      
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                    
            </div>
            
             <div class="tab-pane" id="<?php echo  get_phrase('expense');?>">
                
                <table class="table table-bordered datatable" id="table_export2"">
                    <thead>
                        <tr>
                          	<th width="80"><div>#</div></th>
                            <th width="80"><div><?php echo get_phrase('title');?></div></th>
                            <th><div><?php echo get_phrase('type');?></div></th>
                            <th class="span3"><div><?php echo get_phrase('description');?></div></th>
                            <th><div><?php echo get_phrase('amount');?></div></th>
                            <th><div><?php echo get_phrase('date');?></div></th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    <?php  $count=1;?>
                        <?php 
								 $payments   =   $this->db->get_where('payment', array(
                                    'payment_type'=>"expense" ))->result_array();
                                foreach($payments as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
                            <td><?php echo $row['title'];?></td>
                            <td><?php echo $row['payment_type'];?></td>
                            <td><?php echo $row['description'];?></td>
                            <td><?php echo $row['amount'];?></td>
                            <td><?php echo date("d/m/Y",$row['timestamp']);?></td>
                            
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                    
            </div>
          </div>
        
        
    </div>
</div>



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

	jQuery(document).ready(function($)
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
                                      columns: [0, 1, 2,3,4, 5]
                                }
                            },
                            {
                                extend: 'pdf',
                                exportOptions: {
                                    columns: [0, 1, 2,3,4, 5]
                                }
                            },
                            {
                                extend: 'print',
                                exportOptions: {
                                    columns: [0, 1, 2,3,4, 5]
                                }
                            },
                        ]
			
		});
		var datatable = $("#table_export1").dataTable({
			"sPaginationType": "bootstrap",
			 dom: 'Bfrtip',
                        buttons: [
                            'pageLength',
                            {
                                extend: 'excel',
                                exportOptions: {
                                      columns: [0, 1, 2,3,4, 5]
                                }
                            },
                            {
                                extend: 'pdf',
                                exportOptions: {
                                    columns: [0, 1, 2,3,4, 5]
                                }
                            },
                            {
                                extend: 'print',
                                exportOptions: {
                                    columns: [0, 1, 2,3,4, 5]
                                }
                            },
                        ]
			
		});
        var datatable = $("#table_export2").dataTable({
			"sPaginationType": "bootstrap",
			 dom: 'Bfrtip',
                        buttons: [
                            'pageLength',
                            {
                                extend: 'excel',
                                exportOptions: {
                                      columns: [0, 1, 2,3,4, 5]
                                }
                            },
                            {
                                extend: 'pdf',
                                exportOptions: {
                                    columns: [0, 1, 2,3,4, 5]
                                }
                            },
                            {
                                extend: 'print',
                                exportOptions: {
                                    columns: [0, 1, 2,3,4, 5]
                                }
                            },
                        ]
			
		});
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});
		
</script>