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
        <a href="<?php echo base_url(); ?>index.php?disciplinary/add_incident" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add New Incident" data-step="5" data-intro="From here you can create a new incident" data-position='left'>
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

   <div class="col-md-12 white-box" data-step="6" data-intro="<?php echo get_phrase('Here you can see the list of incidents reported by you.');?>" data-position='top'> 
       
<table class= "custom_table table display" cellspacing="0" width="100%" id="ex">
    <thead>
        <tr>
            <th width="5%"><div><?php echo get_phrase('s._no.'); ?></div></th>                               
            <th><div><?php echo get_phrase('violation_type'); ?></div></th>
            <!--<th><div><?php // echo get_phrase('section_teacher'); ?></div></th>-->
            <th><div><?php echo get_phrase('violation_description'); ?></div></th>
            <th><div><?php echo get_phrase('class'); ?></div></th>
            <th width="8%"><div><?php echo get_phrase('section'); ?></div></th>
            <th><div><?php echo get_phrase('parent_appeal'); ?></div></th>
            <th><div><?php echo get_phrase('student_name'); ?></div></th>
            <th width="8%"><div><?php echo get_phrase('parent_statement'); ?></div></th>
            <th><div><?php echo get_phrase('verdict'); ?></div></th>
            <th><div><?php echo get_phrase('reporting_teacher'); ?></div></th>
            <th><div><?php echo get_phrase('corrective_action'); ?></div></th>
            <th width="10%"><div><?php echo get_phrase('date_of_occurrence'); ?></div></th>
            <th><div><?php echo get_phrase('expiry_date'); ?></div></th>
            <th width="6%"><div><?php echo get_phrase('action'); ?></div></th>
        </tr>
    </thead>
    <tbody>
    <?php $count = 1; foreach ($details as $row):  ?>
        <tr>
            <td><?php echo $count++; ?></td>
            <td><?php echo $row['type']; ?></td>
            <!--<td><?php // echo $row['raised_by']; ?></td>-->
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['class_name']; ?></td>
            <td><?php echo $row['section_name']; ?></td>
            <td><?php echo $row['parent_appeal']; ?></td>
            <td><?php echo $row['student_name']; ?></td>
            <td><?php echo $row['parent_statement']; ?></td>
            <td><?php echo $row['verdict']; ?></td>
            <td><?php echo $row['reporting_teacher']; ?></td>
            <td><?php echo $row['corrective_action']; ?></td>
            <td><?php echo date('d/m/Y',strtotime($row['date_of_occurrence'])); ?></td>
            <td><?php echo date('d/m/Y',strtotime($row['expiry_date'])); ?></td>
            <td>
                <div class="btn-group">
                <a href="<?php echo base_url(); ?>index.php?disciplinary/edit_incident/<?php echo $row['incident_id']; ?>">
                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                   data-placement="top" data-original-title="<?php echo get_phrase('edit'); ?>" >
                    <i class="fa fa-pencil-square-o"></i>
                </button>
                </a>
                <a href="javascript: void(0);" onclick="confirm_modal('<?php echo base_url(); ?>index.php?disciplinary/add_incident/delete/<?php echo $row['incident_id']; ?>');">
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