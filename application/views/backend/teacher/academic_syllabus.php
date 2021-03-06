<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('manage_academic_syllabus'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('dashboard'); ?></a></li>

<?php $BRC = get_bread_crumb_old(); if (strpos($BRC, '^') !== false) { $ExpBrd = explode('^', $BRC);?>
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

    <div class="col-md-12 no-padding">
        <div class="form-group col-sm-5 no-padding" >
            <div class="form-group " data-step="5" data-intro="<?php echo get_phrase('Select a class, then you will get a list of all students with their all information.');?>" data-position='right'>
                <label class="control-label">Select Class</label>
                <select class="selectpicker" data-style="form-control" data-live-search="true" onchange="window.location = this.options[this.selectedIndex].value">
                    <option value=" ">Select Class</option>
                    <?php foreach ($classes as $row): ?>
                        <option <?php if ($class_id == $row['class_id']) {
                        echo 'selected';
                    } ?> value="<?php echo base_url(); ?>index.php?teacher/academic_syllabus/<?php echo $row['class_id']; ?>">
                        <?php echo get_phrase('class'); ?>&nbsp;<?php echo $row['name']; ?>
                        </option>
<?php endforeach; ?>
                </select>
            </div>  
        </div>  

        <div class="m-b-20" >
            <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/academic_syllabus_add/');" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger par-add-btn" data-step="6" data-intro="<?php echo get_phrase('From here you can add the Academic Syllabus.');?>" data-position='left' data-toggle="tooltip" data-placement="left" title="" data-original-title="Add Academic Syllabus">
                <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>





<div class="col-md-12 white-box preview_outer" data-step="7" data-intro="<?php echo get_phrase('Here you can see the list of acedemic syallabus for all classes.');?>" data-position='top'>
     <div class="text-center m-b-20">
             <h3><?php echo get_phrase('academic_syllabus_for_class_');
             foreach($class_name as $value){
                 echo $value['name']; 
             }?></h3>
            </div>
<?php if (!empty($syllabus)) { ?>

        <table class= "custom_table display nowrap" cellspacing="0" width="100%" id="example23">
            <thead>
                <tr>
                    <th><div><?php echo get_phrase('s._no'); ?></div></th>
                    <th><div><?php echo get_phrase('title'); ?></div></th>
                    <th><div><?php echo get_phrase('description'); ?></div></th>
                    <th><div><?php echo get_phrase('uploader'); ?></div></th>
                    <th><div><?php echo get_phrase('date'); ?></div></th>
                    <th><div><?php echo get_phrase('file'); ?></div></th>
                    <th><div data-step="8" data-intro="<?php echo get_phrase('Here you can download the file.');?>" data-position='left'><?php echo get_phrase('action'); ?></div></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                foreach ($syllabus as $row) {
                    ?>
                    <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td>
                            <?php
                            echo $row['uploader_name'];
                            ?>
                        </td>
                        <td><?php echo date("d/m/Y", $row['timestamp']); ?></td>
                        <td>
        <?php echo substr($row['file_name'], 0, 20); ?><?php if (strlen($row['file_name']) > 20) echo '...'; ?>
                        </td>
                        <td>
                            <a href="javascript: void(0);" onclick="showDocumentPreview('<?php echo base_url(); ?>index.php?modal/popup/academic_syllabus_preview/<?php echo $row['academic_syllabus_code']; ?>');">
                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('view') ?>" title="<?php echo get_phrase('view') ?>"><i class="fa fa-eye"></i></button>
                            </a>
                        
                            <a  href="<?php echo base_url(); ?>index.php?teacher/download_academic_syllabus/<?php echo $row['academic_syllabus_code']; ?>">
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
<?php } else { ?>                  
        <table class="table table-bordered responsive" id="norecord">
            <thead>
                <tr>
                    <th><div></div></th> 
                <tr>
            </thead>
            <tbody>
                <tr>
                    <td><div><label><?php echo get_phrase('no_records_found!!'); ?></label></div></td>
                </tr>
            </tbody>
        </table>
<?php } ?>

</div>    


