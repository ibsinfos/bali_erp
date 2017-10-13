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
    <div class="col-md-12">
        <a href="<?php echo base_url(); ?>index.php?disciplinary/add_violation_types" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add New Violation Type" data-step="5" data-intro="From here you can add a new violation type" data-position='left'>
            <i class="fa fa-plus"></i>
        </a> 
    </div>
</div>
<div class="clearfix">&nbsp;</div>
<?php     
if($this->session->flashdata('flash_message_error')) {?>        
<div class="alert alert-danger">
<?php echo $this->session->flashdata('flash_message_error'); ?>
</div>
<?php } ?>

   <div class="col-md-12 white-box" data-step="6" data-intro="<?php echo get_phrase('Here you can see the list of violation type.');?>" data-position='top'> 
        <div class="text-center m-b-20" >
             <h3><?php echo get_phrase('violation_type');?></h3>
        </div>
<table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
    <thead>
        <tr>
            <th><div><?php echo get_phrase('No'); ?></div></th>                               
            <th><div><?php echo get_phrase('type'); ?></div></th>
            <th><div><?php echo get_phrase('description'); ?></div></th>
            <th><div><?php echo get_phrase('action'); ?></div></th>
        </tr>
    </thead>
    <tbody>
    <?php $count = 1; foreach ($details as $row):  ?>
        <tr>
            <td><?php echo $count++; ?></td>
            <td><?php echo $row['type']; ?></td>                                    
            <td><?php echo $row['description']; ?></td>
            <td>
                <div class="btn-group">
                <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/edit_violation_type/<?php echo $row['violation_type_id']; ?>');">
                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                   data-placement="top" data-original-title="<?php echo get_phrase('edit'); ?>" >
                    <i class="fa fa-pencil-square-o"></i>
                </button>
                </a>
                <a href="javascript: void(0);" onclick="confirm_modal('<?php echo base_url(); ?>index.php?disciplinary/add_violation_types/delete/<?php echo $row['violation_type_id']; ?>');">
                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                   data-placement="top" data-original-title="<?php echo get_phrase('delete'); ?>" >
                    <i class="fa fa-trash"></i>
                </button>
                </a>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>