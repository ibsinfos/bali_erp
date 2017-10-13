<div class="row bg-title"> 
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>

<?php $BRC = get_bread_crumb(); if (strpos($BRC, '^') !== false) { $ExpBrd = explode('^', $BRC);?>
            <li>
                <?php echo get_phrase(@$ExpBrd[0]); ?>
                <?php echo @$ExpBrd[1]; ?>
            </li> <?php }else{ $ExpBrd[2] = $BRC;}?>
            <li class="active">
                <?php echo get_phrase(@$ExpBrd[2]); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
    
<div class="row">
    <div class="col-xs-12 m-b-20">
        <a href="<?php echo base_url(); ?>index.php?school_admin/add_hostel_room/" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add New Room" data-step="5" data-intro="You can add hostel from here." data-position='left'>
            <i class="fa fa-plus"></i>
        </a>
    </div>
</div>

<div class="row m-0">    
<div class="col-xs-12 white-box"> 

<!-----TABLE LISTING STARTS-->
	<div class="tab-pane box <?php if(!isset($edit_data))echo 'active';?>" id="list">
	    <table id="example23" class="table_edjust display nowrap" data-step="7" data-intro="<?php echo get_phrase('You can see the list of hostel from here.');?>" data-position='top'>
		    <thead>
			    <tr>
	    <th><div><?php echo get_phrase('No.'); ?></div></th>
	    <th><div><?php echo get_phrase('hostel_name'); ?></div></th>
	    <th><div><?php echo get_phrase('floor'); ?></div></th>
	    <th><div><?php echo get_phrase('room_number'); ?></div></th>
	    <th><div><?php echo get_phrase('no.of_beds'); ?></div></th>
	    <th><div><?php echo get_phrase('available_beds'); ?></div></th>
	    <th><div><?php echo get_phrase('occupied_beds'); ?></div></th>
	    <th><div><?php echo get_phrase('room_description'); ?></div></th>
	    <th><div><?php echo get_phrase('room_fare'); ?></div></th>
	    <th  data-step="6" data-intro="<?php echo get_phrase('From here you can edit and delete the particular hostel informations.');?>" data-position='left'><div><?php echo get_phrase('options'); ?></div></th>               
	</tr>
    </thead>
    <tbody>
	<?php $count = 1;
	foreach ($room_details as  $value): ?>
	    <tr>
		<td><?php echo $count++; ?></td>
		<td><?php echo $value['hostel_name']; ?></td>
		<td><?php echo $value['floor_name']; ?></td>
		<td><?php echo $value['room_number']; ?></td>
		<td><?php echo $value['no_of_beds']; ?></td>
		<td><?php echo $value['available_beds']; ?></td>
		<td><?php echo $value['occupied_beds']; ?></td>
		<td><?php echo $value['room_description']; ?></td>
		<td><?php echo $value['room_fare']; ?></td>
		<td>
		<a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_hostel_room/<?php echo $value['hostel_room_id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit" title="Edit Hostel Room"><i class="fa fa-pencil-square-o"></i></button></a>
					      <!--delete-->
                <?php
                    if($value['transaction'] >0)
                      echo 
                    '<button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 disabled"  data-placement="top" data-original-title="'.get_phrase('delete_class').'" title="'.get_phrase('delete_class').'"><i class="fa fa-trash-o"></i> </button>';
                  else
                  {
                      ?>
                  
		<a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/manage_hostel_room/delete/<?php echo $value['hostel_room_id'];?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete" title="Delete Hostel Room"><i class="fa fa-trash-o"></i></button></a>
                <?php
                  }
                ?>  
		</td>                
	    </tr>
<?php endforeach; ?>
    </tbody>
</table>
	</div>
<!-----TABLE LISTING ENDS-->
</div>
</div>