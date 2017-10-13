<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"><h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
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
        <a href="<?php echo base_url(); ?>index.php?school_admin/add_warden/"  class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add New Warden" data-step="5" data-intro="You can add New Warden from here" data-position='left'>
            <i class="fa fa-plus"></i>
        </a>
    </div>
</div>
<div class="row m-0">
    <div class="col-md-12 white-box" data-step="7" data-intro="<?php echo get_phrase('You can see the list of warden.');?>" data-position='top'>
    <!----TABLE LISTING STARTS-->
        <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
            <thead>
                <tr>

                    <th><div><?php echo get_phrase('No.'); ?></div></th>
                    <th><div><?php echo get_phrase('name'); ?></div></th>
                    <th><div><?php echo get_phrase('phone_number'); ?></div></th>
                    <th><div><?php echo get_phrase('email_id'); ?></div></th>
                    <th data-step="6" data-intro="<?php echo get_phrase('You can edit and delete warden profile from here.');?>" data-position='top'><div><?php echo get_phrase('options'); ?></div></th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1;
                foreach ($warden_details as $value):
                    ?>
                    <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $value['name']; ?></td>
                        <td><?php echo $value['phone_number']; ?></td>
                        <td><?php echo $value['email']; ?></td>
                        <td>
                            <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_hostel_warden/<?php echo $value['warden_id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit Warden Profile" title="Edit"><i class="fa fa-pencil-square-o"></i></button></a>
                            <!--delete-->
                      <?php
                        if($value['transaction']<=0)
                        {
                            ?>
                            <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/manage_hostel_warden/delete/<?php echo $value['warden_id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete Warden" title="Delete"><i class="fa fa-trash-o"></i></button></a>
                        <?php
                            }
                        else
                           echo '<button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 disabled"  data-placement="top" data-original-title="'.get_phrase('delete_class').'" title="'.get_phrase('delete_class').'"><i class="fa fa-trash-o"></i> </button>';
                        ?>
                            

                        </td>
                    </tr>
<?php endforeach; ?>
            </tbody>
        </table>

        <!----TABLE LISTING ENDS--->
    </div>
</div>                  
