<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('manage_dormitory'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" target="_blank" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase('manage_dormitory'); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

 <div class="row">
	<div class="col-sm-12">    
        <div class="white-box"> 
            <!--TABLE LISTING STARTS-->
            <div class="tab-pane box <?php if(!isset($edit_data))echo 'active';?>" id="list">
                <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                	<thead>
                		<tr>
                                <th><div><?php echo get_phrase('no.');?></div></th>
                    		<th><div><?php echo get_phrase('type');?></div></th>
                    		<th><div><?php echo get_phrase('name');?></div></th>
                    		<th><div><?php echo get_phrase('no.of_rooms');?></div></th>
                                <th><div><?php echo get_phrase('available_rooms');?></div></th>
                                <th><div><?php echo get_phrase('occupied_rooms');?></div></th>
                                <th><div><?php echo get_phrase('warden_name');?></div></th>
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;
                        foreach($details as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>                
                            <td><?php echo $row['type'];?></td>
                            <td><?php echo $row['name'];?></td>
                            <td><?php echo $row['no_of_rooms'];?></td>
                            <td><?php echo $row['available_beds'];?></td>
                            <td><?php echo $row['occupied_beds'];?></td>
                            <td>
                                <?php foreach ($row['warden'] as $ward_key => $ward_value){
                                echo $ward_value . ",";    
                                };?>
                            </td>
                           
                            <td>
<?php /*!--                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                     STUDENTS IN THE DORM 
                                    <li>
                                        <a href="<?php echo base_url();?>index.php?school_admin/dormitory_students/<?php echo $row['id'];?>">
                                            <i class="entypo-users"></i>
                                                <?php echo get_phrase('students');?>
                                            </a>
                                                    </li>
                                    <li class="divider"></li>
                                    
                                    
                                </ul>
                            </div>-- */?>

<div class="btn-group">
                                            <button type="button" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light">
                                                <?php echo get_phrase('View_Details '); ?> <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-default pull-right pos-static" role="menu">

                                                

                                                <!-- STUDENT AVERAGE LINK -->
                                                <li>
                                                    <a href="<?php echo base_url();?>index.php?school_admin/dormitory_students/<?php echo $row['id'];?>">
                                                        <i class="fa fa-area-chart"></i>
                                                        <?php echo get_phrase('students'); ?>
                                                    </a>
                                                </li>
                                                
                                            </ul>
                                        </div>
                                
                                
        					</td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
			</div>
            <!----TABLE LISTING ENDS--->
            
            
			
            
	
	</div>
</div>

<script>
$(document).ready(function () {
    
    var datatable = $("#table_export").dataTable(
                {
			  rowReorder: {
                        selector: 'td:nth-child(2)'
			},
		responsive: true,
                    dom: 'Bfrtip',
                        buttons: [
                            'pageLength',
                            {
                                extend: 'excel',
                                exportOptions: {
                                      columns: [0, 1, 2,3]
                                }
                            },
                            {
                                extend: 'pdf',
                                exportOptions: {
                                    columns: [0, 1, 2,3]
                                }
                            },
                            {
                                extend: 'print',
                                exportOptions: {
                                    columns: [0, 1, 2,3]
                                }
                            },
                        ]
          
                });
            });
 </script>           