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
            <li><a href="<?php echo base_url(); ?>index.php?admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase('manage_vehicle_details'); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<!----TABLE LISTING STARTS-->
<div class="row">
<div class="col-sm-12">
    <div class="white-box" data-step="5" data-intro="<?php echo get_phrase('Here you can view the Vehicle Details.');?>" data-position="top"> 
        <table id="manage_vehicle_details" class="new_tabulation table display nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><?php echo get_phrase('no'); ?></th>
                    <th><?php echo get_phrase('bus_name'); ?></th>
                    <th><?php echo get_phrase('route_name'); ?></th>            
                    <th><?php echo get_phrase('driver_name'); ?></th>
                    <th><?php echo get_phrase('purchase_date'); ?></th>
                    <th><?php echo get_phrase('vehicle_cost'); ?></th>
                    <th><?php echo get_phrase('vehicle_service_date'); ?></th>
                    <th><?php echo get_phrase('vendor_company_name'); ?></th>
                    <th><?php echo get_phrase('vendor_name'); ?></th>
                    <th><?php echo get_phrase('vendor_phone_no'); ?></th>
                    <th><?php echo get_phrase('credit_facility_from_vendor'); ?></th>
                    <th><?php echo get_phrase('insurance_expiry_date'); ?></th>
                    <th><?php echo get_phrase('status'); ?></th>
                    <th><?php echo get_phrase('options'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1;
                foreach ($details as $row):
                    ?>
                    <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row['bus_name']; ?></td>
                        <td><?php echo $row['route_name']; ?></td>
                        <td><?php echo $row['driver_name']; ?></td>
                        <td><?php echo $row['purchase_date']; ?></td>
                        <td><?php echo $row['vehicle_cost']; ?></td>
                        <td><?php echo $row['service_date']; ?></td>
                        <td><?php echo $row['vendor_company']; ?></td>
                        <td><?php echo $row['vendor_name']; ?></td>
                        <td><?php echo $row['vendor_contact']; ?></td>
                        <td><?php echo $row['credit_facility_from_vendor']; ?></td>
                        <td><?php echo $row['insurance_expiry_date']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>

                            <div class="btn-group">
                                <button type="button" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right pos-static" role="menu">                    

                                    <!--  service LINK -->
    <?php if ($row['status'] == "service") { ?>
                                        <li>
                                            <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_vehicle_return_from_service/<?php echo $row['vehicle_details_id']; ?>');">
                                                <i class="fa fa-cog"></i>
        <?php echo get_phrase('return_from_service'); ?>
                                            </a>
                                        </li>

    <?php } else { ?>
                                        <li>
                                            <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_vehicle_service/<?php echo $row['vehicle_details_id']; ?>');">
                                                <i class="fa fa-cog"></i>
        <?php echo get_phrase('service'); ?>
                                            </a>
                                        </li>

    <?php } ?>
                                    <!--<li class="divider"></li>-->

                                    <!-- EDITING LINK -->
                                    <!--                                    <li>
                                                                            <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_bus_details_edit/<?php echo $row['vehicle_details_id']; ?>');">
                                                                                <i class="entypo-pencil"></i>
    <?php echo get_phrase('edit'); ?>
                                                                            </a>
                                                                        </li>
                                                                        <li class="divider"></li>                            
                                    
                                                                          DELETION LINK 
                                                                        <li>
                                                                            <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/manage_vehicle_details/delete/<?php echo $row['vehicle_details_id']; ?>');">
                                                                                <i class="entypo-trash"></i>
    <?php echo get_phrase('delete'); ?>
                                                                            </a>
                                                                        </li>
                                    -->
                                    <!--  service details LINK -->
                                    <li>
                                        <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/manage_vehicle_service_maintenance/<?php echo $row['vehicle_details_id']; ?>');">
                                            <i class="fa fa-cogs"></i>
    <?php echo get_phrase('service_details'); ?>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </td>
                    </tr>
<?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>
</div>