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
            <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active">
                <?php echo get_phrase('documents'); ?>
            </li>
        </ol>
    </div>
</div>

<div class="row m-0">
    <div class="col-md-12  white-box">
        <!--for transfer certificate -->
        <div class="col-md-2 form-group text-center" data-step="5" data-intro="<?php echo get_phrase('upload_documents');?>" data-position='right'>
<a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_upload_file/<?php echo $teacher_id; ?>');" class="fcbtn btn btn-danger btn-outline btn-1d"><i class="ti-plus m-r-5"></i><?php echo get_phrase('upload_documents'); ?></a>            
        </div>
    </div>
</div>
<!--<div class="row">
    <div class="col-md-12 p-0">
        <div class="col-lg-4 col-sm-4 col-xs-12">
            <div class="white-box" data-step="7" data-intro="<?php echo get_phrase('Upload Documents from here');?>" data-position='left'>
                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('upload_files'); ?></b></h3>
                <ul class="list-inline text-center">
                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_upload_file/<?php echo $teacher_id; ?>');">
                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-upload"></i></button>
                    </a>
                </ul>
            </div>
        </div>
    </div>
</div>-->

<div class="row">   
    <div class="col-md-12">
        <div class="white-box"  data-step="8" data-intro="<?php echo get_phrase('Download or Delete Documents');?>" data-position='top'>
            <table id="example23" class="table-responsive display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th><div><?php echo get_phrase('name'); ?></div></th>                                
                        <th><div><?php echo get_phrase('date'); ?></div></th>
                        <th><div><?php echo get_phrase('size'); ?></div></th>
                        <th><div><?php echo get_phrase('options'); ?></div></th>
                    </tr>
                </thead>
                <tbody><?php $count = 1;
                foreach ($subfiles as $row):
                    ?>
                        <tr>                                    
                            <td><?php echo str_replace($instance, "", $row->Key); ?></td>
                            <td><?php echo $row->LastModified; ?></td>
                            <td><?php echo $row->Size; ?></td>
                            <td>
                                <!--Download-->
                                <a href="<?php echo base_url(); ?>index.php?teacher/download_document/<?php echo $row->Key; ?>" ><i class="fa fa-downlaod"></i><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Download"><i class="fa fa-download"></i></button></a>

                            </td>
                        </tr>
<?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
