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
    <!-- /.breadcrumb -->
</div>



<?php if ($this->session->flashdata('flash_message_error')) { ?>        
<div class="alert alert-danger">
    <?php echo $this->session->flashdata('flash_message_error'); ?>
</div>
<?php } ?>
<div class="text-right m-b-20">
<!--    <a href="#"  data-step="5" data-intro="From Here You Can Assign The Camp to Student." data-position="top" data-toggle="tooltip" data-placement="left" title="" data-original-title="Assign to Camp">
    <i class="fa fa-plus"></i>
    </a>-->
    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_camp_assign/');" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger m-b-20" data-step="5" data-intro="From Here You Can Add The Camp." data-position="top" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add New Camp">
    <i class="fa fa-plus"></i>
    </a>
</div>
<div class="col-md-12 white-box" data-step="7" data-intro="<?php echo get_phrase('This shows list of camp assign details.');?>" data-position='top'>       
                                <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
                                    <thead>
                                        <tr>
                                            <th><div><?php echo get_phrase('S._no.'); ?></div></th>
                                            <th><div><?php echo get_phrase('camp_name'); ?></div></th>
                                            <th><div><?php echo get_phrase('class'); ?></div></th>
                                            <th><div><?php echo get_phrase('section'); ?></div></th>
                                            <th><div><?php echo get_phrase('student_name'); ?></div></th>
                                            <th  data-step="8" data-intro="<?php echo get_phrase('From here you can edit and delete the camp.')?>" data-position='top'><div><?php echo get_phrase('options'); ?></div></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $count = 1 ;
                                        foreach($camp_assign_list as $row): ?>
                                         <tr> 
                                            <td><?php echo $count++; ?></td>
                                            <td><?php echo $row['camp_name']; ?></td>
                                            <td><?php echo $row['class_name'] ?></td>
                                            <td><?php echo $row['section_name'] ?></td>
                                            <td><?php echo $row['student_name'] ?></td>
                                            <td><a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_camp_assign_edit/<?php echo $row['assign_camp_id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></button></a><a href="javascript: void(0);" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/camp_assign_to_student/delete/<?php echo $row['assign_camp_id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button></a></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>                    
        </div>



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
