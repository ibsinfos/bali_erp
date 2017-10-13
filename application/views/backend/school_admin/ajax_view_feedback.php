<div class="row m-0">
<div class="col-md-12 white-box">
<?php if(!empty($get_details)){?>
<div class="col-sm-11 col-xs-12 text-center">
    <h4 class="page-title"><?php echo get_phrase('class_&_subject_details_of_').$name;?></h4> 
</div>

<div class="col-xs-12 col-sm-1 text-right no-padding">
    <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_feed_back/<?php echo $teacher_id;?>');">
        <button type="button" data-step="7" data-position="left" data-intro="Click on this button to view the feedback and overall ratings given to the teacher." class=" m-b-20 btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-target="#add-contact" data-toggle="tooltip" data-placement="left" data-original-title="View Feedback">
         <i class="fa fa-star-o"></i>    
        </button>                 
    </a>
</div>

<div  data-step="6" data-intro="Here you can view the class and subject details of the teacher." data-position='top'> 
    <table id="example23" class="display nowrap new_datatable_sort new_sort_top">
	<thead>
	    <tr>
		<th>No.</th>
		<th><?php echo get_phrase('class'); ?></th>
		 <th><?php echo get_phrase('section'); ?></th>
		<th><?php echo get_phrase('subjects'); ?></th>
	    </tr>
	</thead>
	<tbody>
	<?php $count = 1;
	    foreach ($get_details as $row) { ?>   
	    <tr>               
		<td><?php echo $count++; ?></td>               
		<td><?php echo $row['class_name']?></td>           
		<td><?php echo $row['section_name']?></td> 
		<td><?php echo $row['name']?></td> 
	    </tr>
	<?php }  ?>
	</tbody>
    </table>
</div>
   
<?php } else {
 echo get_phrase('no_class_assigned!!'); ?>
<?php } ?>
</div>
</div>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
        
    $('#example23').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
            'copy', 'excel', 'pdf', 'print'
        ]
    });    
</script>
