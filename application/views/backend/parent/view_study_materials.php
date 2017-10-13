<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?></h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?parents/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active">
                <?php echo get_phrase($page_title); ?>
            </li>
        </ol>
    </div>
</div>
<?php if (!empty($study_material_info)){ ?>
<div class="col-md-12 white-box preview_outer">
    <div class="text-center">
        <h3><b><?php echo get_phrase('study_materials_for_').$student_name; ?> <?php echo "Class : ".$class_name; ?></b></h3>
        
    </div>
    <table  id="data_table" class="display nowrap" data-step="5" data-intro="<?php echo get_phrase('View the study materials available.');?>" data-position='top'>
    <thead>
        <tr>        
            <th><div>No</div></th>           
            <th><div><?php echo get_phrase('title');?></div></th>
            <th><div><?php echo get_phrase('class');?></div></th>
            <th><div><?php echo get_phrase('uploaded_by');?></div></th>
            <th><div><?php echo get_phrase('file_name');?></div></th>
            <th><div><?php echo get_phrase('description');?></div></th> 
            <th><div><?php echo get_phrase('added_on');?></div></th>
            <th><div><?php echo get_phrase('download');?></div></th>
           
        </tr>
    </thead>

    <tbody>
        <?php    
        $count = 1;
        foreach ($study_material_info as $row) { ?>   
            <tr>               
                <td><?php echo $count++; ?></td>               
                <td><?php echo $row['title']?></td>
                <td><?php echo $row['classname']?></td>
                <td><?php echo $row['teacher_name']?></td>
                <td><?php echo $row['file_name']; ?></td>
                <td><?php echo $row['description']?></td> 
                <td><?php echo $row['timestamp']; ?></td>
                <td>                  
                    <a href="javascript: void(0);" onclick="showDocumentPreview('<?php echo base_url(); ?>index.php?modal/popup/study_material_preview/<?php echo $row['file_name']; ?>');">
                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('view') ?>" title="<?php echo get_phrase('view') ?>"><i class="fa fa-eye"></i></button>
                    </a>

                    <a href="<?php echo base_url().'index.php?school_admin/download_study_material/'.$row['file_name']; ?>" class="btn btn-blue btn-icon icon-left">
                        <button type="button" class="btn btn-default  btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                                data-placement="top" data-original-title="<?php echo get_phrase('download') ?>" title="<?php echo get_phrase('download') ?>">
                        <i class="fa fa-download"></i>
                          </button>
                    </a>                    
                </td>
                
            </tr>
        <?php } ?>
    </tbody>
</table>
</div>
<?php } else { 
echo "No Data Available";
 } ?>
