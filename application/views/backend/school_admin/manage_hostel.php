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
        <a href="<?php echo base_url(); ?>index.php?school_admin/add_hostel/" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add New Hostel" data-step="5" data-intro="<?php echo get_phrase('You can add a new hostel details from here.');?>" data-position='left'>
            <i class="fa fa-plus"></i>
        </a>
    </div>
</div>
<div class="row m-0">
    <div class="col-md-12 white-box" data-step="6" data-intro="<?php echo get_phrase('It will show details of all hostel.');?>" data-position='top'>
<?php //echo '<pre>'; print_r($details);exit;?>
        <!----TABLE LISTING STARTS-->
        <table class="custom_table table display" cellspacing="0" width="100%" id="example23">
            <thead>
                <tr>

                    <th>
                        <div>
                            <?php echo get_phrase('No.'); ?>
                        </div>
                    </th>
                    <th>
                        <div>
                            <?php echo get_phrase('name'); ?>
                        </div>
                    </th>
                    <th>
                        <div>
                            <?php echo get_phrase('hostel_type'); ?>
                        </div>
                    </th>
                    <th>
                        <div>
                            <?php echo get_phrase('hostel_address'); ?>
                        </div>
                    </th>
                    <th>
                        <div>
                            <?php echo get_phrase('phone_number'); ?>
                        </div>
                    </th>
                    <th>
                        <div>
                            <?php echo get_phrase('warden_name'); ?>
                        </div>
                    </th>
                    <th>
                        <div data-step="7" data-intro="<?php echo get_phrase('From here you can edit or delete hostel details .');?>" data-position='top'>
                            <?php echo get_phrase('options'); ?>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1;
            foreach ($details as $key => $value): 
               
                ?>
                    <tr>
                        <td>
                            <?php echo $count++; ?>
                        </td>
                        <td>
                            <?php echo $value['name']; ?>
                        </td>
                        <td>
                            <?php echo $value['type']; ?>
                        </td>
                        <td>
                            <?php echo $value['address']; ?>
                        </td>
                        <td>
                            <?php echo $value['phone']; ?>
                        </td>
                        <td>
                            <?php
                        foreach ($value['warden'] as $ward_key => $ward_value) {
                            echo $ward_value . " ";
                        }
                        ?>
                        </td>
                        <td>

                            <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_manage_hostel/<?php echo $value['id']; ?>');">
                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit Hostel" title="Edit Hostel"><i class="fa fa-pencil-square-o"></i></button>
                            </a>

                            <!--delete-->
                      
                      
                            <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/manage_hostel/delete/<?php echo $value['id']; ?>');">
                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete Hostel" title="Delete Hostel"><i class="fa fa-trash-o"></i></button>
                            </a>
                      
                        </td>
                    </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
        <!----TABLE LISTING ENDS--->
    </div>
</div>