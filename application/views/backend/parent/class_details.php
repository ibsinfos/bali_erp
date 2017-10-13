<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('overall_details_for_class_'. $class_name); ?></h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" target="_blank" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?parents/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active">
                <?php echo get_phrase($page_title); ?>
            </li>
        </ol>
    </div>
</div>

<div class="col-md-12 white-box preview_outer"> 
    <div class="sttabs tabs-style-flip">
        <nav data-step="6" data-intro="<?php echo get_phrase('These are all resources of the class.');?>" data-position='top'>        
            <ul>
                <li class="active">
                    <a href="#tabs-0" class="sticon fa fa-list"><span><?php echo get_phrase('teachers'); ?></span></a>
                </li>
                
                <li>
                    <a href="#tabs-1" class="sticon fa fa-list"><span><?php echo get_phrase('academic_syllabus'); ?></span></a>
                </li>
                            
                <li>
                    <a href="#tabs-2" class="sticon fa fa-list"><span><?php echo get_phrase('study_materials'); ?></span></a>
                </li>
                
                <li>
                    <a href="#tabs-3" class="sticon fa fa-list"><span><?php echo get_phrase('library_books'); ?></span></a>
                </li>
            </ul>
        </nav>
        
        <div class="content-wrap">            
            <section id="tabs-0"><?php  if(!empty($teachers)){?>
                <table  class="custom_table table" id="example23">
                    <thead>
                        <tr>
                            <th><div><?php echo get_phrase('#'); ?></div></th>
                            <th><div><?php echo get_phrase('name'); ?></div></th>
                            <th><div><?php echo get_phrase("class"); ?></div></th>
                            <th><div><?php echo get_phrase("section"); ?></div></th>
                            <th><div><?php echo get_phrase("contact"); ?></div></th>
                        </tr>
                    </thead>
                    <tbody>
        <?php $count = 1; if(count($teachers)){ foreach ($teachers as $teach): ?>
                        <tr>                                        
                            <td><?php echo $count++; ?></td>
                            <td><?php echo ucwords($teach['teacher'].' '.$teach['tea_middle_name'].' '.$teach['tea_last_name']); ?></td>
                            <td><?php echo $teach['class']; ?></td>
                            <td><?php echo $teach['section']; ?></td>
                            <td><?php echo $teach['cell_phone']; ?></td>

                        </tr><?php endforeach; }?>
                    </tbody> 
                </table>
                 <?php } else { ?>
                <table class="custom_table table" id="example23">
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
            
            <section id="tabs-1"><?php  if(!empty($syllabus)){?>
                <table class="custom_table table display" id="example24">
                    <thead>
                        <tr>
                            <th><div><?php echo get_phrase('#'); ?></div></th>
                            <th><div><?php echo get_phrase('title'); ?></div></th>
                            <th><div><?php echo get_phrase("code"); ?></div></th>
                            <th><div><?php echo get_phrase("description"); ?></div></th>
                            <th><div><?php echo get_phrase("uploaded_date"); ?></div></th>   
                            <th><div><?php echo get_phrase("action"); ?></div></th>
                        </tr>
                    </thead>
                    <tbody>
            <?php $count = 1; if(count($syllabus)){ foreach ($syllabus as $syb):?>
                        <tr>
                            <td><?php echo $count ++; ?></td>
                            <td><?php echo $syb->title; ?></td>
                            <td><?php echo $syb->academic_syllabus_code; ?></td>
                            <td><?php echo $syb->description; ?></td>
                            <td><?php echo date('M,d Y', strtotime($syb->date_time)); ?></td>
                            <td>
        <a href="javascript: void(0);" onclick="showDocumentPreview('<?php echo base_url(); ?>index.php?modal/popup/academic_syllabus_preview/<?php echo $syb->academic_syllabus_code; ?>');">
            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('view') ?>" title="<?php echo get_phrase('view') ?>"><i class="fa fa-eye"></i></button>
                                </a>

                                <a href="<?php echo base_url(); ?>index.php?school_admin/download_academic_syllabus/<?php echo $syb->academic_syllabus_code; ?>">
        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Download"><i class="fa fa-download"></i></button>
                                </a>
                            </td>
                        </tr><?php endforeach; }?>
                    </tbody>
                </table>
                <?php } else { ?>
                <table class="custom_table table display" id="example24">
                   <thead>
                       <tr><th><div></div></th><tr>
                   </thead>
                   <tbody>
                       <tr><td><div><label><?php echo get_phrase('no_records_available'); ?></label></div></td></tr>
                   </tbody>
               </table>
                <?php } ?>
            </section>
            
            <section id="tabs-2">
                <?php  if(!empty($study_info)){?>
                <table class="custom_table table display" id="example24">
                    <thead>
                        <tr>
                            <th><div><?php echo get_phrase('#'); ?></div></th>                            
                            <th><div><?php echo get_phrase('title'); ?></div></th>     
                            <th><div><?php echo get_phrase("description"); ?></div></th>
                            <!-- <th><div><?php echo get_phrase("filename"); ?></div></th> -->
                            <th><div><?php echo get_phrase("uploaded_date"); ?></div></th>
                            <th><div><?php echo get_phrase("action"); ?></div></th>
                        </tr>
                    </thead>
                    <tbody>
    <?php $count = 1; if(count($study_info)){ foreach ($study_info as $info): ?>
                            <tr>                                        
                                <td><?php echo $count++; ?></td>
                                <td><?php echo $info->title; ?></td>
                                <td><?php echo $info->description; ?></td>
                                <!-- <td><?php echo $info->file_name; ?></td> -->                                        
                                <td><?php echo date('M,d Y', strtotime($info->timestamp)); ?></td>
                                <td>
                <a href="javascript: void(0);" onclick="showDocumentPreview('<?php echo base_url(); ?>index.php?modal/popup/study_material_preview/<?php echo $info->file_name; ?>');">
            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('view') ?>" title="<?php echo get_phrase('view') ?>"><i class="fa fa-eye"></i></button>
                                    </a>

                                    <a href="<?php echo base_url().'index.php?teacher/download_study_material/'.$info->file_name; ?>">
        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Download"><i class="fa fa-download"></i></button>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; }?>
                    </tbody> 
                </table>
                <?php } else { ?>
                <table class="custom_table table display" id="example24">
                   <thead>
                       <tr><th><div></div></th><tr>
                   </thead>
                   <tbody>
                       <tr><td><div><label><?php echo get_phrase('no_records_available'); ?></label></div></td></tr>
                   </tbody>
               </table>
                <?php } ?>
            </section>
            
            
            <section id="tabs-3">
                <?php  if(!empty($books)){?>
                <table class="custom_table table display" id="example25">
                    <thead>
                        <tr>
                            <th><div><?php echo get_phrase('#'); ?></div></th>                            
                            <th><div><?php echo get_phrase('title'); ?></div></th>     
                            <th><div><?php echo get_phrase("author"); ?></div></th>
                            <th><div><?php echo get_phrase("description"); ?></div></th>
                            <th><div><?php echo get_phrase("status"); ?></div></th>   
                            <th><div><?php echo get_phrase("price"); ?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                <?php $count = 1; if(count($books)){ foreach ($books as $bk): ?>
                        <tr>                                        
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $bk->name; ?></td>
                            <td><?php echo $bk->author; ?></td>
                            <td><?php echo $bk->description; ?></td>
                            <td><span class="label label-<?php if($bk->status =='available')echo 'success';else echo 'danger';?>"><?php echo $bk->status;?></span></td>
                            <td><?php echo $bk->price." ".$bk->currency; ?></td>

                        </tr><?php endforeach; }?>
                    </tbody> 
                </table>
                 <?php } else { ?>
                <table class="custom_table table display" id="example25">
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
            
            
        </div>
    </div>
</div>

<script>
    $( function() {
      $( "#tabs" ).tabs();
    } );
</script>