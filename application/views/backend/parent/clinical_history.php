<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('view_noticeboard'); ?></h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);"  onclick="javascript:introJs().start();" id="take-tour"  onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?parents/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active">
                <?php echo get_phrase('clinical_history'); ?>
            </li>
        </ol>
    </div>
</div>
<div class="row">
<div class="badge badge-danger badge-stu-name pull-right m-b-20">
   <i class="fa fa-user"></i> <?php echo $student_name; ?>
</div>
</div>
<div class="row">
<div class="white-box">        
    <section>
        <div class="sttabs tabs-style-flip">
            <nav>
                <ul>
                    <li id="section1">
                        <a href="#section-flip-1" class="sticon fa fa-list "data-step="5" data-intro="<?php echo get_phrase('Here you can see clinical history.'); ?>" data-position='right'><span>
<?php echo get_phrase('clinical_history_list'); ?></span></a>
                    </li>
                    <li id="section2">
                        <a href="#section-flip-2" class="sticon fa fa-plus" data-step="6" data-intro="<?php echo get_phrase('From here you can add a clinical history.'); ?>" data-position='left'><span>
<?php echo get_phrase('add_clinical_history'); ?></span></a>
                    </li>                
                </ul>
            </nav>                                    
            <div class="content-wrap">
                <section id="section-flip-1">
                    <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
                        <thead>
                            <tr>
                                <th><div><?php echo get_phrase('s._no.'); ?></div></th>
                                <th><div><?php echo get_phrase('symptoms'); ?></div></th>
                                <th><div><?php echo get_phrase('diagnosis'); ?></div></th>
                                <th><div><?php echo get_phrase('prescription'); ?></div></th>
                                <th><div><?php echo get_phrase('given_by'); ?></div></th>
                                <th><div><?php echo get_phrase('start_date'); ?></div></th>
                                <th><div><?php echo get_phrase('end_date'); ?></div></th>
                                <th><div data-step="8" data-intro="<?php echo get_phrase('You can edit or delete a doctor from here.'); ?>" data-position='left'><?php echo get_phrase('action'); ?></div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($clinical_details)) {
                                $count = 1;
                                foreach ($clinical_details as $row):
                                    ?>
                                    <tr><td><?php echo $count++; ?></td>
                                        <td><?php echo $row['symptoms']; ?></td>
                                        <td><?php echo $row['diagnosis']; ?></td>
                                        <td><?php echo $row['prescription']; ?></td>                                       
                                        <td><?php echo $row['given_by']; ?></td>
                                        <td><?php echo $row['start_date']; ?></td>
                                        <td><?php echo $row['end_date']; ?></td>
                                        <td>
                                            <?php if($row['given_by'] == 'Doctor'){ ?>
                                            <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_view_doctor_profile/<?php echo $row['doctor_id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View Doctor Information"><i class="fa fa-eye"></i></button></a>
                                            <?php } ?>
                                            <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_clinical_history/<?php echo $row['clinical_history_id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></button></a>
                                            <a href="javascript: void(0);" onclick="confirm_modal('<?php echo base_url(); ?>index.php?parents/clinical_history/<?php echo $row['clinical_history_id']; ?>/delete');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button></a>
                                        </td> 
                                    </tr>
    <?php endforeach; ?>

                    <?php } ?>
                        </tbody>
                    </table>
                </section>

                <section id="section-flip-2">
<?php echo form_open(base_url() . 'index.php?parents/clinical_history/'.$student_id.'/create', array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('symptoms'); ?><span class="mandatory"> *</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                <input type="text" class="form-control" data-validate="required"  name="symptoms" placeholder="Symptoms" required=""> 
                            </div>
                            <label class="mandatory"> <?php echo form_error('symptoms'); ?></label>
                        </div> 
                    </div>
                    
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('prescription'); ?><span class="mandatory"> *</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                <input type="text" class="form-control" name="precription" placeholder="Prescription" maxlength="10" required=""> 
                            </div>
                            <label class="mandatory"> <?php echo form_error('precription'); ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('Diagnosis'); ?><span class="mandatory"> *</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-envelope-o"></i></div>
                                <input type="text" class="form-control" name="diagnosis" placeholder="Diagnosis" required=""> 
                            </div>
                            <label class="mandatory"> <?php echo form_error('diagnosis'); ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('start_date'); ?><span class="mandatory"> *</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="icon-calender"></i></div>
                                <input type="text" class="form-control mydatepicker" name="start_date" placeholder="mm/dd/yyyy" required=""> 
                            </div>
                            <label class="mandatory"> <?php echo form_error('start_date'); ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('end_date'); ?><span class="mandatory"> *</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="icon-calender"></i></div>
                                <input type="text" class="form-control mydatepicker" name="end_date" placeholder="mm/dd/yyyy" required=""> 
                            </div>
                            <label class="mandatory"> <?php echo form_error('end_date'); ?></label>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('add_record'); ?></button>
                    </div>
<?php echo form_close(); ?> 
                </section>             
            </div>
        </div>
    </section>
</div>  
</div>