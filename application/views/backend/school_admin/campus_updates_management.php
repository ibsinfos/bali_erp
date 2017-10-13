<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('manage_campus_updates'); ?></h4>
    </div>
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
</div>
<div class="row">    
    <div class="col-md-12 text-right">
        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_add_campus_update');" >
            <button type="button" class=" m-b-20 btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-target="#add-contact" data-toggle="tooltip" data-placement="left" data-original-title="Add New Updates" data-step="5" data-intro="Add regular campus updates here!!" data-position='left' >
             <i class="fa fa-plus"></i>    
            </button>                 
        </a>
    </div>
</div>
<div class="row m-0">    
<div class="col-md-12 white-box"> 
<div class="white-box" data-step="6" data-intro="<?php echo get_phrase('Lists all regular campus updates');?>" data-position='top'> 
	<table id="example23" class="custom_table display nowrap" cellspacing="0" width="100%">
	    <thead>
		<tr>
		    <th><div><?php echo get_phrase('No'); ?></div></th>           
		    <th><div><?php echo get_phrase('notification'); ?></div></th>
		    <th><div><?php echo get_phrase('date_created'); ?></div></th>
		    <th><div><?php echo get_phrase('options'); ?></div></th>
		</tr>
	    </thead>
	    <tbody>        
	    <?php $count = 0; foreach ($get_updates as $row=>$val): 
		$count++;  ?>
		<tr>
		    <td><?php echo $count; ?></td>                
		    <td><?php echo $val['notification']; ?></td>
		    <td><?php echo $val['created_date']; ?></td>            
		    <td>
			<a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_campus_update/<?php echo $val['notification_id'];?>');" >
			    <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit updates" title="Edit updates"><i class="fa fa-pencil-square-o"></i></button>
			</a>
			<a href="javascript: void(0);" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/campus_updates_management/delete/<?php echo $val['notification_id']; ?>');">
			    <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete Updates" title="Delete Updates"><i class="fa fa-trash-o"></i></button>
			</a>                          
		    </td>
		</tr>
	    <?php endforeach; ?>
	    </tbody>
	</table>      
    </div>
</div>
</div>
                                        