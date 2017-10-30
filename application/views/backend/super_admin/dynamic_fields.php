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
            <li><a href="<?php echo base_url(); ?>index.php?super_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><?php echo get_phrase('manage_fields'); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<div class="row">
<div class="col-md-offset-10 col-md-2 hidden-xs">
<a href="<?php echo base_url(); ?>index.php?super_admin/add_field/" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add field">
<i class="fa fa-plus"></i>
</a>
  </div>
</div>
<div class="col-md-12 white-box" data-step="7" data-intro="This shows list of subject details." data-position='top'>        
                                <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
                                    <thead>
                                        <tr>
                                            <th><div><?php echo get_phrase('s._no.'); ?></div></th>
                                            <th><div><?php echo get_phrase('label'); ?></div></th>
                                            <th><div><?php echo get_phrase('db_field'); ?></div></th>
                                            <th><div><?php echo get_phrase('field_type'); ?></div></th>
                                            <th><div><?php echo get_phrase('validation'); ?></div></th>
                                            <th><div><?php echo get_phrase('order_id'); ?></div></th>
                                            <th><div><?php echo get_phrase('group_name'); ?></div></th>
                                            <th><div><?php echo get_phrase('status'); ?></div></th>
                                            <th><div><?php echo get_phrase('option'); ?></div></th>
                                            <th><div><?php echo get_phrase('action'); ?></div></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $count = 1; foreach ($fields_data as $row): 
                                            if($row['enable']=='Y'){ $status = "Enabled"; $action = "Disable";}else{ $status = " Disabled"; $action = "Enable";}  ?>
                                            <tr>
                                                <td><?php echo $count++; ?></td>
                                                <td><?php echo get_phrase($row['label']); ?></td>
                                                <td><?php echo $row['db_field'] ?></td>
                                                <td><?php echo $row['field_type'] ?></td>
                                                <td><?php if($row['validation'] == 'o'){ echo "Optional"; }else{ echo "Mandantory";} ?></td>
                                                <td><?php echo $row['order_id'] ?></td>
                                                <td><?php echo get_phrase($row['name']); ?></td>
                                                <td><?php echo $status;?></td>
                                                <td><div class="btn-group"><button type="button" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light"><?php echo get_phrase('view_details'); ?><span class="caret"></span></button><ul class="dropdown-menu dropdown-default pull-right pos-static" role="menu"><li> <a href="javascript: void(0);" onclick="confirm_print('<?php echo base_url(); ?>index.php?super_admin/dynamic_fields/status_change/<?php echo $row['id']; ?>/<?php echo $row['enable']; ?>', 'Are you sure to execute this action ?');"><i class="fa fa-trash-o"></i><?php echo " ".$action;?></a></li></ul></div></td>
                                                <td>
                                                    <a href="<?php echo base_url(); ?>/index.php?super_admin/edit_field/<?php echo $row['id']; ?>" ><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></button></a>
                                    <!--delete-->
                                   <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?super_admin/dynamic_fields/delete/<?php echo $row['id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button></a>
                                                 
                                                </td>
                                            </tr>                                        
                                        <?php endforeach; ?>                              
                                    </tbody>
                                </table>
                    
        </div>    
 