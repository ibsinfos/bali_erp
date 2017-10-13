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
            <li><a href="<?php echo base_url(); ?>index.php?student/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<div class="row">
    <div class="col-md-12 hidden-xs">
        <div class="form-group col-sm-12 p-0">
<?php foreach ($student_name as $name) { ?>
                <div class="label label-primary pull-right badge-stu-name">
                    <i class="fa fa-user"></i><?php echo " ".$name['name'];
}
?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">    
        <div class="white-box preview_outer" data-step="5" data-intro="<?php echo get_phrase('List of academic syllabus, which is uploaded by admin and teachers');?>" data-position='top'>
            <!----TABLE LISTING STARTS-->
             <div class="text-center m-b-20">
             <h3><?php echo get_phrase('academic_syllabus_for_class_');
             if(!empty($class_name)){
             foreach($class_name as $value){
             echo $value['class_name']; }
             }?></h3>
            </div>
            <table id="example23" class="custom_table display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th><div><?php echo get_phrase('s._no.');?></div></th>
                        <th><div><?php echo get_phrase('title'); ?></div></th>
                        <th><div><?php echo get_phrase('description'); ?></div></th>
                        <th><div><?php echo get_phrase('uploader'); ?></div></th>
                        <th><div><?php echo get_phrase('date'); ?></div></th>
                        <th><div><?php echo get_phrase('file'); ?></div></th>
                        <th><div><?php echo get_phrase('action'); ?></div></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    if (!empty($syllabus)) {
                        foreach ($syllabus as $row):
                            if (!empty($row)) {
                                foreach ($row as $value):
                                    ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $value['title']; ?></td>
                                        <td><?php echo $value['description']; ?></td>
                                        <td>
                                            <?php
                                            echo $value['name'] . ' ( ' . $value['uploader_type'] . ' )';
                                            ?>
                                        </td>
                                        <td><?php echo date("d/m/Y", $value['timestamp']); ?></td>
                                        <td><?php echo substr($value['file_name'], 0, 20); ?><?php if (strlen($value['file_name']) > 20) echo '...'; ?></td>
                                        <td>

            <a href="javascript: void(0);" onclick="showDocumentPreview('<?php echo base_url(); ?>index.php?modal/popup/academic_syllabus_preview/<?php echo $value['academic_syllabus_code']; ?>');">
            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('view') ?>" title="<?php echo get_phrase('view') ?>"><i class="fa fa-eye"></i></button>
                                            </a>
                                            
                                <a href="<?php echo base_url(); ?>index.php?parents/download_academic_syllabus/<?php echo $value['academic_syllabus_code']; ?>">
        <button type="button" class="btn btn-default  btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('download') ?>" title="<?php echo get_phrase('download') ?>"><i class="fa fa-download"></i></button>
                                            </a>

                                        </td>
                                    </tr>
                                <?php
                                endforeach;
                            }endforeach;
                    }
                    ?>

                </tbody>
            </table>

        </div>
    </div>
</div>

