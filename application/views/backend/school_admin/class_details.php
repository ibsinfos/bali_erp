<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('view_overall_class_details'); ?> </h4></div>
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
<div class="col-md-12">       
    <div class="form-group">
        <div class="form-group col-sm-5 p-0" data-step="5" data-intro="<?php echo get_phrase('Select a class, for which you want to get the details.');?>" data-position='right'>
        <label class="control-label">Select Class</label>
        <select class="selectpicker" data-style="form-control" data-live-search="true" onchange="window.location = this.options[this.selectedIndex].value">
            <option value="">Select Class</option>
                <?php  foreach ($classes as $row):   ?>
                    <option <?php if ($class_id == $row['class_id']) { echo 'selected';  } ?> value="<?php echo base_url(); ?>index.php?school_admin/overall_class_details/<?php echo $row['class_id']; ?>">
                        <?php echo $row['name']; ?>
                    </option>
                <?php endforeach; ?>
        </select>
        </div>
    </div>
</div>
</div>

<div class="col-md-12 white-box preview_outer"> 
<div class="sttabs tabs-style-flip">
    <nav data-step="6" data-intro="<?php echo get_phrase('These are all resources of the class.');?>" data-position='top'>
        <ul>
            <li class="active">
            <a href="#section-flip-1" class="sticon fa fa-list"><span><?php echo get_phrase('teachers'); ?></span>  </a> </li>
            <li><a href="#section-flip-2" class="sticon fa fa-book"><span><?php echo get_phrase(' academic_syllabus'); ?></span></a></li>
            <li><a href="#section-flip-3" class="sticon fa fa-folder-open"><span><?php echo get_phrase(' study_materials'); ?></span></a></li>
        </ul>
    </nav>
    <div class="content-wrap">
        <section id="section-flip-1">       
        <?php  if(!empty($teachers)){?>                
            <table class="custom_table table display" id="example23">
                <thead>
                    <tr>
                        <th><div><?php echo get_phrase('No'); ?></div></th>                            
                        <th><div><?php echo get_phrase('teacher_name'); ?></div></th>
                        <th><div><?php echo get_phrase('class'); ?></div></th>
                        <th><div><?php echo get_phrase('section'); ?></div></th>
                        <th><div><?php echo get_phrase("contact"); ?></div></th>
                        <th><div><?php echo get_phrase("email"); ?></div></th>
                    </tr>
                </thead>
                <tbody>
                <?php $count = 0; foreach ($teachers as $teach): 
                    $count++;
                    ?>
                    <tr>                                        
                        <td><?php echo $count; ?></td>
                        <td><?php echo $teach['teacher']; ?></td>
                        <td><?php echo $teach['class']; ?></td>
                        <td><?php echo $teach['section']; ?></td>
                        <td><?php echo $teach['cell_phone']; ?></td>
                        <td><?php echo $teach['email']; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody> 
            </table>                   
            <?php } else { ?>                       
            <table  class="custom_table table" id="example23">
                <thead>
                    <tr>
                       <th><div></div></th> 
                    <tr>
                </thead>
                <tbody>
                    <tr>
                       <td><div><label><?php echo get_phrase('no_records_available'); ?></label></div></td>
                    </tr>
                </tbody>
            </table>
            <?php } ?>
        </section>
        <section id="section-flip-2">       
        <?php if(!empty($syllabus)){?>
            <table class="custom_table table display" id="example24">
            <thead>
            <tr>
                <th><div><?php echo get_phrase('No'); ?></div></th>                            
                <th><div><?php echo get_phrase('title'); ?></div></th>     
                <th><div><?php echo get_phrase("code"); ?></div></th>
                <th><div><?php echo get_phrase("description"); ?></div></th>
                <th><div><?php echo get_phrase("uploaded_date"); ?></div></th>   
                <th><div><?php echo get_phrase("action"); ?></div></th>
            </tr>
            </thead>                        
            <tbody>
            <?php $count = 0; foreach ($syllabus as $syb): 
                $count++;
                ?>
            <tr>
                <td><?php echo $count; ?></td>
                <td><?php echo $syb->title; ?></td>
                <td><?php echo $syb->academic_syllabus_code; ?></td>
                <td><?php echo $syb->description; ?></td>
                <td><?php echo date('M,d Y', strtotime($syb->date_time)); ?></td>
                <td>

                <a href="javascript: void(0);" onclick="showDocumentPreview('<?php echo base_url(); ?>index.php?modal/popup/academic_syllabus_preview/<?php echo $syb->academic_syllabus_code; ?>');">
                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('view') ?>" title="<?php echo get_phrase('view') ?>"><i class="fa fa-eye"></i>
                            </button>
                        </a>

		    <a href="<?php echo base_url(); ?>index.php?school_admin/download_academic_syllabus/<?php echo $syb->academic_syllabus_code; ?>">
                                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Download"><i class="fa fa-download"></i></button>
                                    </a> 
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
            </table>
            <?php } else { ?>
            <table  class="custom_table table" id="example24">
            <thead>
                <tr><th><div></div></th><tr>
            </thead>
            <tbody>
                <tr><td><div><label><?php echo get_phrase('no_records_available'); ?></label></div></td></tr>
            </tbody>
            </table>
            <?php } ?>
        </section>
        <section id="section-flip-3">   
        <?php   if(!empty($study_info)){?>
            <table  class="custom_table table display" id="example25">
            <thead>
               <tr>
                <th><div><?php echo get_phrase('No'); ?></div></th>                            
                <th><div><?php echo get_phrase('title'); ?></div></th>     
                <th><div><?php echo get_phrase("description"); ?></div></th>
                <th><div><?php echo get_phrase("filename"); ?></div></th>
                <th><div><?php echo get_phrase("uploaded_date"); ?></div></th>
                <th><div><?php echo get_phrase("action"); ?></div></th>
            </tr>
            </thead>
            <tbody>
                <?php $count = 0; foreach ($study_info as $info): 
                    $count++;
                    ?>
                    <tr>                                        
                        <td><?php echo $count; ?></td>
                        <td><?php echo $info->title; ?></td>
                        <td><?php echo $info->description; ?></td>
                        <td><?php echo $info->file_name; ?></td>                                        
                        <td><?php echo date('M,d Y', strtotime($info->timestamp)); ?></td>
                        <td>
                            <a href="javascript: void(0);" onclick="showDocumentPreview('<?php echo base_url(); ?>index.php?modal/popup/study_material_preview/<?php echo $info->file_name; ?>');">
                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('view') ?>" title="<?php echo get_phrase('view') ?>"><i class="fa fa-eye"></i></button>
                            </a>

                            <a href="<?php echo base_url().'index.php?school_admin/download_study_material/'.$info->file_name; ?>">
                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Download"><i class="fa fa-download"></i></button>
                            </a> 
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody> 
            </table>
            <?php } else { ?>
            <table  class="custom_table table" id="example25">
               <thead>
                   <tr><th><div></div></th><tr>
               </thead>
               <tbody>
                   <tr><td><div><label><?php echo get_phrase('no_records_available'); ?></label></div></td></tr>
               </tbody>
            </table>
            <?php } ?>               
        </section>
    </div>
</div>
</div>
<div id="result_holder" ></div>

<script type="text/javascript">
    (function() {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
            new CBPFWTabs(el);
        });
    })();
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
    $('#example23').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
            'copy', 'excel', 'pdf', 'print'
        ]
    });
    $('#example24').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
            'copy', 'excel', 'pdf', 'print'
        ]
    });
   
    $('#example25').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
            'copy', 'excel', 'pdf', 'print'
        ]
    }); 
 
    </script>

  



