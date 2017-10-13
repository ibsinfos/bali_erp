
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('view_parent_teacher_meeting'); ?></h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" target="" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?parents/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active">
                <?php echo get_phrase('PTM'); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>



<div class="row m-0">
	<div class="white-box col-md-12" data-step="5" data-intro="<?php echo get_phrase('From here you can see the list of parent teacher meeting!');?>" data-position='top'> 
		<table id="example23" class="display nowrap new_tabulation" cellspacing="0" width="100%">   
                    <thead>
                        <tr>
                            <th>No</th>
                            <th><?php echo get_phrase('name');?></th>
                            <th><?php echo get_phrase('class/section');?></th>                            
                            <th><?php echo get_phrase('exam_type');?></th>
                            <th><?php echo get_phrase('date');?></th>
                            <th><?php echo get_phrase('time');?></th>
                        </tr>
                    </thead>
                    <tbody>                        
                    	<?php $count = 1;foreach($ptm_details as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
                            <td><?php echo $row['student_name'];?></td>
                            <td><?php echo $row['class_name'].":".$row['section_name'];?></td> 
                            <td><?php echo $row['exam_name'];?></td>
                            <td><?php echo date('d M,Y', strtotime($row['parrent_teacher_meeting_date']));?></td>	
                            <td><?php echo $row['time'];?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            
        </div>
    </div>

<!-----  DATA TABLE EXPORT CONFIGURATIONS ----->                      

<script type="text/javascript">
    
    $('#example23').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
            'copy', 'excel', 'pdf', 'print'
        ]
    });
</script>
