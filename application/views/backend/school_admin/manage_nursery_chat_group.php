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
<div class="col-md-12 white-box">        
        
<div class="row">
    
          
       <a  href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_add_nursery_chat_group/');"  class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger par-add-btn" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add nursery chat group"> 
	   <i class="fa fa-plus"></i>
       </a>        
  
</div>				
				
<div class="row">                            
<table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
	<thead>
		<tr>							
		    <th>Nursery chat group Name</th>
		    <!--<th>Status</th>-->

		    <th style="width:15%;">Options</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($nursery_chat_group as $row){ ?><tr>
		    <td>
			<?php echo $row->group_name; ?>
		    </td>
		  <!-- <td> 
			<?php //echo $row->status;?>
		    </td>
		  -->

		    <td>
			<div class="btn-group">
			<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
	    Action <span class="caret"></span>
	</button>
			 <ul class="dropdown-menu dropdown-default pull-right" role="menu">
			<li>
	       <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_nursery_chat_group/<?php echo $row->group_id;?>');">
<i class="entypo-pencil"></i>
					<?php echo get_phrase('edit');?>
</a>
	    </li>
	    <li class="divider"></li>
	    <!-- DELETION LINK -->
	    <li>
		<a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/manage_nursery_chat_group/delete/<?php echo $row->group_id;?>');">
		    <i class="entypo-trash"></i>
		    <?php echo get_phrase('delete'); ?>
		</a>
	    </li>
	    <li class="divider"></li>
	    <!-- DELETION LINK -->
	    <li>
		<a href="<?php echo base_url(); ?>index.php?school_admin/connect_user_to_chat_group/<?php echo $row->group_id;?>">
		    <i class="fa fa-plug" aria-hidden="true"></i>
		    <?php echo 'Connect User to '.$row->group_name; ?>
		</a>
	    </li>
			 </ul>
			</div>
		    </td>
		</tr><?php  } ?>
	</tbody>
</table>
</div>
    
</div>
</div>

<script type="text/javascript">
$(document).ready(function($) {
    var datatable = $("#table_export").dataTable({
		 rowReorder: {
            selector: 'td:nth-child(1)'
   },
   responsive: true,
          "sPaginationType": "bootstrap",
        dom: 'Bfrtip',
        buttons: [
            'pageLength',
            {
                extend: 'excel',
                exportOptions: {
                      columns: [  0 ]
                }

            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [  0 ]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 0 ]
                }
            },
        ]
       
    } );
     
} );
</script>