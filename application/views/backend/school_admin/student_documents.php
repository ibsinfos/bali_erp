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
            <li><?php echo get_phrase('student'); ?>
                <ul>                    
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/student_information"><?php echo get_phrase('student_information'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/student_promotion"><?php echo get_phrase('student_promotion'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/map_students_id"><?php echo get_phrase('map_students_id'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/student_fee_configuration"><?php echo get_phrase('student_fee_setting'); ?></a></li>
                </ul>
            </li>
            <li class="active">
                <?php echo $page_title; ?>
            </li>
        </ol>
    </div>
</div>

<div class="row m-0">
    <div class="col-md-12  white-box">
        <!--for transfer certificate -->
        <div class="col-md-4 form-group text-center" data-step="5" data-intro="<?php echo get_phrase('Transfer_Certificate_Genereate');?>" data-position='right'>
            <a href="<?php echo base_url(); ?>index.php?school_admin/print_transfer_certificate/<?php echo $student_id; ?>" class="fcbtn btn btn-danger btn-outline btn-1d"><i class="ti-plus m-r-5"></i><?php echo get_phrase('transfer_certificate'); ?></a>
        </div>
        <!--for merit certificate -->    
        <div class="col-md-4 form-group text-center" data-step="6" data-intro="<?php echo get_phrase('Merit_Certificate_Generate');?>" data-position='right'>
            <a href="<?php echo base_url(); ?>index.php?school_admin/print_merit_certificate/<?php echo $student_id; ?>" class="fcbtn btn btn-danger btn-outline btn-1d"><i class="ti-plus m-r-5"></i><?php echo get_phrase('merit_certificate'); ?></a>
        </div>

<!--        <div class="col-md-3 form-group" data-step="7" data-intro="<?php // echo get_phrase('New Certificate create here.');?>" data-position='right'>
            <button type="button" class="fcbtn btn btn-danger btn-outline btn-1d" onclick="showAjaxModal('<?php // echo base_url(); ?>index.php?modal/popup/modal_print_new_certificate/<?php // echo $student_id; ?>');"><i class="ti-plus m-r-5"></i><?php // echo get_phrase('print_new_certificate'); ?></button>
        </div>-->

        <div class="col-md-4 form-group text-center" data-step="7" data-intro="<?php echo get_phrase('Upload_Documents_from_here.');?>" data-position='left'>
            <button type="button" class="fcbtn btn btn-danger btn-outline btn-1d" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_upload_file/student/<?php echo $student_id; ?>');"><i class="ti-plus m-r-5"></i><?php echo get_phrase('upload_files'); ?></button>
        </div>
    </div>
</div>
<div class="row m-0">   
    <div class="col-md-12 white-box" data-step="8" data-intro="<?php echo get_phrase('Download_or_Delete_Documents');?>" data-position='top'>

        <table id="example23" class="table-responsive display nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th><div><?php echo get_phrase('name'); ?></div></th>                                
                                <th><div><?php echo get_phrase('date'); ?></div></th>
                                <th><div><?php echo get_phrase('size'); ?></div></th>
                                <th><div><?php echo get_phrase('options'); ?></div></th>
                            </tr>
                        </thead>
                        
                        <tbody><?php $count = 1; foreach ($subfiles as $row): ?>
                                <tr>                                    
                                <td><?php echo str_replace($instance,"",$row->Key); ?></td>
                                <td><?php echo $row->LastModified; ?></td>
                                <td><?php echo $row->Size; ?></td>
                                <td>
                                <!--Download-->
                                    <a href="<?php echo base_url(); ?>index.php?school_admin/download_document/<?php echo $row->Key; ?>" ><i class="fa fa-downlaod"></i><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Download"><i class="fa fa-download"></i></button></a>
								<!--delete-->                                                                
                                    <a onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/delete_document/<?php echo $row->Key; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button></a>
                                </td>
                            </tr>
                                <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
