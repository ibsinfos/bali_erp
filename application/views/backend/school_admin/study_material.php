<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?></h4>
    </div>
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
</div>
<div class="row">
    <div class="col-md-10 form-group">
        <div class="form-group col-sm-6 p-0" data-step="5" data-intro="<?php echo get_phrase('Select a class, to get study materials available.');?>" data-position='right'>
            <label class="control-label">Select Class</label>
            <select class="selectpicker" data-style="form-control" name="class_id" data-live-search="true" onchange="window.location = this.options[this.selectedIndex].value">
                <option value="">Select Class</option>
                <?php  foreach ($classes as $row):   ?>
                    <option <?php if ($class_id == $row['class_id']) { echo 'selected';  } ?> value="<?php echo base_url(); ?>index.php?school_admin/study_material/<?php echo $row['class_id']; ?>">
                            <?php echo $row['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="col-md-2 hidden-xs">
        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_study_material_add_by_admin');" >
            <button type="button" class=" m-b-20 btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-target="#add-contact" data-toggle="tooltip" data-placement="left" data-original-title="Add New" data-step="6" data-intro="<?php echo get_phrase('Add new Study Material');?>" data-position='left' >
             <i class="fa fa-plus"></i>    
            </button>                 
        </a>
    </div>
 </div>

<div class="col-md-12 white-box preview_outer">
    <table  id="data_table" class="table table_edjust display nowrap" data-step="6" data-intro="<?php echo get_phrase('Here you can view the available study materials .');?>" data-position='top'>
    <thead>
        <tr>        
            <th><div>No</div></th>           
            <th><div><?php echo get_phrase('title');?></div></th>
            <th><div><?php echo get_phrase('class');?></div></th>
            <th><div><?php echo get_phrase('uploaded_by');?></div></th>
            <!-- <th><div><?php echo get_phrase('file_name');?></div></th> -->
            <th><div><?php echo get_phrase('description');?></div></th> 
            <th><div><?php echo get_phrase('added_on');?></div></th>
            <th data-step="7" data-intro="<?php echo get_phrase('Here are the options of edit, delete and download.');?>" data-position='top'><div><?php echo get_phrase('options');?></div></th>
           
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
                <td><?php echo $row['uploader_type']=='SA' ? 'School Admin':'Teacher'; ?></td>
                <!-- <td><?php echo $row['file_name']; ?></td> -->
                <td><?php echo $row['description']?></td> 
                <td><?php echo $row['timestamp']; ?></td>
                <td>
                    <a href="javascript: void(0);" onclick="showDocumentPreview('<?php echo base_url(); ?>index.php?modal/popup/study_material_preview/<?php echo $row['file_name']; ?>');">
                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('view') ?>" title="<?php echo get_phrase('view') ?>"><i class="fa fa-eye"></i></button>
                    </a>
<!--                    <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_study_material_edit/<?php echo $row['document_id']; ?>');">
                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                                data-placement="top" data-original-title="<?php echo get_phrase('edit') ?>" title="<?php echo get_phrase('edit') ?>">
                            <i class="fa fa-pencil-square-o"></i>
                        </button>
                    </a>                   -->
                    <a href="<?php echo base_url().'index.php?school_admin/download_study_material/'.$row['file_name']; ?>">
                        <button type="button" class="btn btn-default  btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                                data-placement="top" data-original-title="<?php echo get_phrase('download') ?>" title="<?php echo get_phrase('download') ?>">
                        <i class="fa fa-download"></i>
                          </button>
                    </a>

                    <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_study_material_edit_by_admin/<?php echo $row['document_id'];?>');" >
                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit" title="Edit" ><i class="fa fa-pencil-square-o"></i></button>
                    </a>

                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/study_material/delete/<?php echo $row['document_id'];?>');">
                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete" title="Delete"><i class="fa fa-trash-o"></i></button>
                    </a>                    
                </td>
                
            </tr>
        <?php } ?>
    </tbody>
</table>
</div>
