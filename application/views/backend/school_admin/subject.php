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
<div class="row">
    <div class="col-md-10 form-group">
        <div class="form-group col-sm-6 p-0" data-step="5" data-intro="<?php echo get_phrase('Select class from here and then list of subject will open here.')?>" data-position='bottom'>

        <label class="control-label">Select Class</label>            
        <select class="selectpicker" data-style="form-control" data-live-search="true"  onchange="window.location = this.options[this.selectedIndex].value">
            <option value="">Select Class</option>
            <?php foreach ($classes as $row): ?>
                <option <?php if ($class_id == $row['class_id']) {
                    echo 'selected';
                } ?> value="<?php echo base_url(); ?>index.php?school_admin/subject/<?php echo $row['class_id']; ?>">
                    <?php echo get_phrase('class'); ?>&nbsp;<?php echo $row['name']; ?>
                </option>
            <?php endforeach;?>
        </select>
    </div>
        </div>

  <div class="col-md-2 hidden-xs">
<a href="<?php echo base_url(); ?>index.php?school_admin/add_subject/" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add Subject" data-step="6" data-intro="<?php echo get_phrase('From here you can add new subject in a class.');?>" data-position='left'>
<i class="fa fa-plus"></i>
</a>
  </div>
</div>
<?php if ($class_id != ''): ?>
    <!------CONTROL TABS START------>

<div class="col-md-12 white-box" data-step="7" data-intro="<?php echo get_phrase('This shows list of subject details.');?>" data-position='top'>
        
                                <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
                                    <thead>
                                        <tr>
                                            <th><div><?php echo get_phrase('class'); ?></div></th>
                                            <th><div><?php echo get_phrase('section'); ?></div></th>
                                            <th><div><?php echo get_phrase('subject_name'); ?></div></th>
                                            <th><div><?php echo get_phrase('teacher'); ?></div></th>
                                            <th  data-step="8" data-intro="<?php echo get_phrase('From here you can edit and delete the subject.')?>" data-position='top'><div><?php echo get_phrase('options'); ?></div></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $count = 1;
                                        
                                        foreach ($subjects as $row):
                                            
                                            ?>
                                            <tr>
                                                <td><?php echo ucfirst($row['class_name']); ?></td>
                                                <td><?php
                                                    echo ucfirst($row['section_name']);
                                                    ?>
                                                </td>
                                                <td><?php echo ucfirst($row['name']); ?></td>
                                                <td><?php echo ucfirst($row['teacher_name']." ".$row['lastname']); ?></td>
                                                <td>
                                                           <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_subject/<?php echo $row['subject_id']; ?>');">
                                                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></button></a>
                                                    <!--delete-->
                                                    <?php
                                                    $transaction = $row['transaction'];
                                                    if($transaction){ ?>
                                                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5" disabled><i class="fa fa-trash-o"></i></button>
                                                    <?php } else {   ?>
                                                    
                                                    <a href="javascript: void(0);" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/subject/delete/<?php echo $row['subject_id']; ?>/<?php echo $class_id; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button></a>
                                                    <?php }  ?>
                                                </td>
                                            </tr>
                                <?php endforeach; ?>
                                    </tbody>
                                </table>
                    
        </div>    
   
<?php endif; ?>



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
