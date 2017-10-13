<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?></h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/student_information"><?php echo get_phrase('product'); ?></a></li>
            <li class="active">
                <?php echo get_phrase($page_title); ?>
            </li>
        </ol>
    </div>
</div>

<div class="row m-0">
    <div class="col-md-12  white-box">
       <div class="col-md-3 form-group" data-step="8" data-intro="<?php echo get_phrase('Upload Documents from here.');?>" data-position='left'>
            <button type="button" class="fcbtn btn btn-danger btn-outline btn-1d" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_upload_receipt/<?php echo $product_id ?>');"><i class="ti-plus m-r-5"></i><?php echo get_phrase('upload_files'); ?></button>
        </div>
    </div>
</div>
<?php // echo "product_id".$product_id; die; ?>
<div class="row m-0">   
    <div class="col-md-12 white-box" data-step="9" data-intro="<?php echo get_phrase('Download or Delete Documents');?>" data-position='top'>

        <table id="example23" class="table-responsive display nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th><div><?php echo get_phrase('name'); ?></div></th>                                
                                <th><div><?php echo get_phrase('date'); ?></div></th>
                                <th><div><?php echo get_phrase('product_name'); ?></div></th>
                                <th><div><?php echo get_phrase('teacher_name'); ?></div></th>
                                <th><div><?php echo get_phrase('action'); ?></div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allot_product_list as $row): ?>
                            <tr><td><?php echo $row['upload_file_name'] ?></td>
                                <td><?php echo $row['date'] ?></td>
                                <td><?php echo $row['product_name'] ?></td>
                                <td><?php echo $row['name'] ." ". ($row['middle_name']!=''?$row['middle_name']:'') ." ". $row['last_name'];?></td>
                                <td><a href="<?php echo base_url(); ?>uploads/allot_product_receipt/<?php echo $row['upload_file_name'] ?>"><i class="fa fa-downlaod"></i><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Download"><i class="fa fa-download"></i></button></a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
