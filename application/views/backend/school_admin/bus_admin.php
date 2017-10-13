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
    <div class="col-md-12 hidden-xs">
         <div class="form-group col-sm-12 p-0">      
        <a href="javascript:;" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_bus_admin_add/');" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add New Bus Admin" data-step="5" data-intro="<?php echo get_phrase('From here you can add a new Bus Admin.');?>" data-position="left">
           <i class="fa fa-plus"></i>
            </a>      
         </div>
    </div>
</div>

<div class="row m-0">
<div class="col-sm-12 white-box" data-step="6" data-intro="<?php echo get_phrase('Here you can view a list of Bus Admin.');?>" data-position="top">      
<table id="example23" class="display nowrap" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th><div><?php echo get_phrase('s._no.'); ?></div></th>
            <th><div><?php echo get_phrase('name'); ?></div></th>
            <th><div><?php echo get_phrase('email'); ?></div></th>
            <th><div><?php echo get_phrase('phone'); ?></div></th>
            <th><div><?php echo get_phrase('gender'); ?></div></th>
            <th data-step="7" data-intro="<?php echo get_phrase('From here you can edit or remove a Bus Admin by clicking on a specific icon.'); ?>" data-position="left">
                <div>
                <?php echo get_phrase('options'); ?>
                </div>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php $count = 1; foreach ($bus_admins as $admin): ?>
            <tr>
                <td><?php echo $count++; ?></td>
                <td><?php echo $admin['name']; ?></td>
                <td><?php echo $admin['email']; ?></td>
                <td><?php echo $admin['phone']; ?></td>
                <td><?php echo $admin['sex']; ?></td>
                <td>
                    <div class="btn-group">
                    <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_bus_admin_edit/<?php echo $admin['bus_administrator_id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit Profile" title="Edit"><i class="fa fa-pencil-square-o"></i></button></a>
                                                    <!--delete-->
                    <a href="javascript: void(0);" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/bus_admin/delete/<?php echo $admin['bus_administrator_id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete Profile" title="Delete"><i class="fa fa-trash-o"></i></button></a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
</div>
 


