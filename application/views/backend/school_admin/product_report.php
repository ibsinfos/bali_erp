<div class="row bg-title">

    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('Product Service'); ?> </h4></div>  
    <!-- /.page title --> 
    <!-- .breadcrumb --> 
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <?php $BRC = get_bread_crumb(); $ExpBrd = explode('^', $BRC);?>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li>
                <?php echo get_phrase($ExpBrd[0]); ?>
                <?php echo $ExpBrd[1]; ?>
            </li>
            <li class="active">
                <?php echo get_phrase($ExpBrd[2]); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<div class="row">
    <div class="col-sm-12" data-step="5" data-intro="<?php echo get_phrase('Here you can see list of product service.');?>" data-position='top'>
        <div class="white-box">
            <table class= "table display nowrap" id="example_asc_time">
                <thead>
                    <tr>
                        <th><input type="hidden"></th>
                        <th><div><?php echo get_phrase('product_name'); ?></div></th>
                        <th><div><?php echo get_phrase('service_date'); ?></div></th>
                        <th><div><?php echo get_phrase('vendor_name'); ?></div></th>
                        <th><div><?php echo get_phrase('vendor_phone.No'); ?></div></th>
                        <th><div><?php echo get_phrase('vendor_address'); ?></div></th>
                        <th><div><?php echo get_phrase('reason_for_service'); ?></div></th>
                        <th><div><?php echo get_phrase('return_date_from_service'); ?></div></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    foreach ($service_details as $row):
                        ?>
                        <tr>
                            <td><input type="hidden" value="<?php echo $count; ?>"/></td>               
                            <td><?php echo $row['product_name']; ?></td>
                            <td><?php echo $row['send_for_service']; ?></td>
                            <td><?php echo (!empty($row['seller_name'])) ? $row['seller_name'] : ''; ?></td>
                            <td><?php echo (!empty($row['seller_phone_number'])) ? $row['seller_phone_number'] : ''; ?></td>
                            <td><?php echo (!empty($row['seller_address'])) ? $row['seller_address'] : ''; ?></td>
                            <td><?php echo $row['reason_for_service']; ?></td>
                            <td><?php echo $row['return_from_service']; ?></td>

                        </tr>
<?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
