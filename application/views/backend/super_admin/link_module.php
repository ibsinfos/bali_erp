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
            <li class="active"> <span><?php echo get_phrase($page_title); ?></span></li>
            
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<?php if ($this->session->flashdata('flash_message_error')) { ?>        
<div class="alert alert-danger">
    <?php echo $this->session->flashdata('flash_message_error'); ?>
</div>
<?php } ?>
<div class="row">

  <div class="col-xs-12 m-b-20">
<a href="<?php echo base_url(); ?>index.php?super_admin/link_module/add" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add Module" data-step="6" data-intro="From here you can add new link module" data-position='left'>
<i class="fa fa-plus"></i>
</a>
  </div>
</div>
    <!------CONTROL TABS START------>

<div class="col-md-12 white-box" data-step="8" data-intro="List of subject details." data-position='top'>
    <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
        <thead>
            <tr>
                <th><div><?php echo get_phrase('sl_no.'); ?></div></th>
                <th><div><?php echo get_phrase('link_name'); ?></div></th>
                <th><div><?php echo get_phrase('Path'); ?></div></th>
                <th><div><?php echo get_phrase('user_type'); ?></div></th>
                <th  data-step="7" data-intro="From here you can edit and delete the link module." data-position='top'><div><?php echo get_phrase('options'); ?></div></th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 1;
            $userTypes = array("T"=>"Teacher","S"=>"Student","A"=>"Admin","P"=>"Parent","SA"=>"School Admin","N"=>"");
            foreach ($link_modules as $row):
               ?>
                <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo ucfirst($row['name']); ?></td>
                    <td><?php echo ucfirst($row['link']); ?></td>
                    <td><?php echo ucfirst($userTypes[$row['user_type']]); ?></td>
                    <td>
                        <a href="<?php echo base_url(); ?>index.php?super_admin/edit_link_module/<?php echo $row['id']; ?>">
                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></button></a>
                        <!--delete-->            
                        <a href="javascript: void(0);" onclick="confirm_modal('<?php echo base_url(); ?>index.php?super_admin/link_module/delete/<?php echo $row['id']; ?>/');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
 </div>        

