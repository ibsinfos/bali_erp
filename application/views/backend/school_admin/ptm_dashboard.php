<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
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


<div class="row m-0">
    <div class="white-box col-md-12 select_container">
        <?php echo form_open(base_url() . 'index.php?school_admin/ptm_settings/', array('class' => 'validate',  'id' => 'ptmSettings')); ?>
        
        <div class="col-md-3 form-group" data-step="5" data-intro="<?php echo get_phrase('Here you select the class for which you want to schedule PTM..');?>" data-position='top'>

                <label>
                    <?php echo get_phrase('select_class'); ?><span class="error mandatory"> *</span></label>
                <select class="selectpicker" data-style="form-control" data-live-search="true" name="class_id" data-validate="required" required="required" id="class_id" data-message-required="">
                    <option value="">
                        <?php echo get_phrase('select_class'); ?>
                    </option>
                    <?php
                    foreach ($classes as $row):?>
                        <option value="<?php echo $row['class_id']; ?>">
                            
                                <?php echo $row['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

        </div>


        <div class="col-md-3 form-group" data-step="6" data-intro="<?php echo get_phrase('Here you select the section for which you want to schedule PTM..');?>" data-position='top'>
            <label>
                <?php echo get_phrase('select_section'); ?><span class="error mandatory"> *</span></label>

            <select name="section_id" class="selectpicker" id="section_selector_holder" required="required" data-style="form-control" data-validate="required" data-message-required="Please select a section">
                <option value="">
                    <?php echo get_phrase('select_section'); ?>
                </option>
            </select>

        </div>
    <div class="col-md-3 form-group" data-step="7" data-intro="<?php echo get_phrase('Here you select the exam for which you want to schedule PTM.');?>" data-position='top'>
            <label>
                <?php echo get_phrase('select_exam'); ?><span class="error mandatory"> *</span>
            </label>

            <select name="exam_id" class="selectpicker" data-style="form-control" id="exam_holder" data-validate="required" required="required" data-message-required="Please select an exam">
                <option value="">
                    <?php echo get_phrase('select_exam'); ?>
                </option>
                <?php foreach($exam as $values) { ?>
                    <option value="<?php  echo $values['exam_id'];?>">
                        <?php echo $values['name']?>
                    </option>
                    <?php }?>
            </select>

        </div>


        <div class="col-md-3 form-group" data-step="8" data-intro="<?php echo get_phrase('Here you select the date on which you want to schedule PTM.');?>" data-position='top'>
            <label>
                <?php echo get_phrase('select_date'); ?><span class="error mandatory"> *</span>
            </label>

            <div class="input-group" data-style="form-control">
                <span class="input-group-addon"><i class="icon-calender"></i></span>
                <input type="text" class="form-control datepicker" placeholder="mm/dd/yyyy" name="date_select" data-validate="required" data-message-required="Please pick a date" required="">
            </div>

        </div>


        <div class="col-sm-12 text-right">
            <button type="submit" name="submit" value="submit_date" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="9" data-intro="Here you can submit." data-position='left'>
                <?php echo get_phrase('submit'); ?>
            </button>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>


<div class="row m-0">
    <div class="white-box col-md-12" data-step="10" data-intro="<?php echo get_phrase('Here you can see the list of PTM made so far.');?>" data-position='top'>

        <div class="tab-pane box active" id="list">
            <table class="custom_table table datatable display" id="example23">

                <?php if(!empty($ptm_settings)){?>

                    <thead>
                        <tr>
                            <th width="80">
                                <div>
                                    <?php echo get_phrase('No'); ?>
                                </div>
                            </th>
                            <th>
                                <div>
                                    <?php echo get_phrase('class'); ?>
                                </div>
                            </th>
                            <th>
                                <div>
                                    <?php echo get_phrase('section'); ?>
                                </div>
                            </th>
                            <th>
                                <div>
                                    <?php echo get_phrase('exam_type'); ?>
                                </div>
                            </th>
                            <th>
                                <div>
                                    <?php echo get_phrase('appointment'); ?>
                                </div>
                            </th>
                            <th>
                                <div>
                                    <?php echo get_phrase('actions'); ?>
                                </div>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
            $count = 1;            
            foreach($ptm_settings as $ptm){            
            ?>
                            <tr>
                                <td>
                                    <div>
                                        <label>
                                            <?php echo $count++ ;?>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <label>
                                            <?php echo $ptm['class_name'];?>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <label>
                                            <?php echo $ptm['section_name'];?>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <label>
                                            <?php echo $ptm['exam_name'];?>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <label>
                                            <?php echo $ptm['meeting_date'] ;?>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                     <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_ptm/<?php echo $ptm['parrent_teacher_meeting_date_id'];?>');">
                                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit PTM"><i class="fa fa-pencil-square-o"></i></button>
                                    </a>
                                    
                                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/ptm_settings/delete/<?php echo $ptm['parrent_teacher_meeting_date_id']; ?>');">
                                    <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('delete'); ?>" title="<?php echo get_phrase('delete'); ?>"><i class="fa fa-trash-o"></i></button></a>
                                </td>
                            </tr>
                            <?php } ?>
                    </tbody>
            </table>
            <?php } ?>
        </div>

    </div>
</div>





<script>
    $('#class_id').change(get_class_sections);
    function get_class_sections(class_id) {
        var class_id =  $(this).val();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_class_section/' + class_id,
            success: function(response) {
                jQuery('#section_selector_holder').html(response).selectpicker('refresh');
            }
        });
    }

</script>
<script type="text/javascript"> 
jQuery(function() {
  var datepicker = $('input.datepicker');
  if (datepicker.length > 0) {
    datepicker.datepicker({
      format: "mm/dd/yyyy",
      startDate: new Date()
    });
  }
});
</script>