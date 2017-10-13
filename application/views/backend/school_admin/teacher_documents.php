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
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/teacher"><?php echo get_phrase('teacher_list'); ?></a></li>
            <li class="active">
                <?php echo get_phrase($page_title); ?>
            </li>
        </ol>
    </div>
</div>

<div class="row m-0">
    <div class="col-md-12  white-box">
        <div class="col-md-3 form-group" data-step="8" data-intro="<?php echo get_phrase('Upload Documents from here.');?>" data-position='left'>
            <button type="button" class="fcbtn btn btn-danger btn-outline btn-1d" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_upload_file/teacher/<?php echo $teacher_id; ?>');"><i class="ti-plus m-r-5"></i><?php echo get_phrase('upload_files'); ?></button>
        </div>
    </div>
</div>
<div class="row m-0">   
    <div class="col-md-12 white-box" data-step="9" data-intro="<?php echo get_phrase('Download or Delete Documents');?>" data-position='top'>

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
                                    <a onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/teacher_delete_document/<?php echo $row->Key; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button></a>
                                </td>
                            </tr>
                                <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
