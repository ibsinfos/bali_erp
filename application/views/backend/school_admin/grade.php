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
<?php if ($this->session->flashdata('flash_validation_error')) { ?>        
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('flash_validation_error') ?>
            </div>
<?php } ?>
        
	
    
<div class="row"> 
    <div class="col-md-12">
        <div class="white-box">
            <div>
                <!--Tabs style-->
                <section>
                    <div class="sttabs tabs-style-flip">
                        <nav>
                            <ul>
                                <li  data-step="5" data-intro="<?php echo get_phrase('Here you can view list of grades and edit new grades.');?>" data-position='top'><a href="#section-flip-1" class="sticon fa fa-list"><span><?php echo get_phrase('grade_list'); ?></span></a></li>
                                <li  data-step="6" data-intro="<?php echo get_phrase('Here you can add new grades.');?>" data-position='top'><a href="#section-flip-2" class="sticon fa fa-plus-circle"><span><?php echo get_phrase('add_grade'); ?></span></a></li>
                            </ul>
                        </nav>
                        <div class="content-wrap">
                            <section id="section-flip-1">
                                <div class="tab-pane box active for-table-top" id="list" >
                                    <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
                                        <thead>
                                            <tr>
                                                <th><div><?php echo get_phrase('sr_no.'); ?></div></th>
                                                <th><div><?php echo get_phrase('evaluation_method'); ?></div></th>
                                                <th><div><?php echo get_phrase('grade_name'); ?></div></th>
                                                <th><div><?php echo get_phrase('grade_point'); ?></div></th>
                                                <th><div><?php echo get_phrase('mark_from'); ?></div></th>
                                                <th><div><?php echo get_phrase('mark_upto'); ?></div></th>
                                                <th><div><?php echo get_phrase('comment'); ?></div></th>
                                                <th><div><?php echo get_phrase('options'); ?></div></th>
                                            </tr>
                                        </thead>
                                        <tbody><?php $count = 1;
                                        if (count($grades)) {
                                            //pre($grades);
                                            foreach ($grades as $row): ?>
                                            <tr>
                                                <td><?php echo $count++; ?></td>
                                                <td><?php echo $row['evaluation_method']; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['grade_point']; ?></td>
                                                <td><?php echo $row['mark_from']; ?></td>
                                                <td><?php echo $row['mark_upto']; ?></td>
                                                <td><?php echo $row['comment']; ?></td>
                                                <td>

                                                    <a onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_grade/<?php echo $row['grade_id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('edit'); ?>" title="<?php echo get_phrase('edit'); ?>"><i class="fa fa-pencil-square-o"></i></button></a>

                                                            <?php if ($row['transaction'] == 0) { ?>
                                                                <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/grade/delete/<?php echo $row['grade_id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('delete'); ?>" title="<?php echo get_phrase('delete'); ?>"><i class="fa fa-trash-o"></i></button></a>
                                                            <?php } else { ?> 
                                                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 disabled"><i class="fa fa-trash-o"></i></button>
        <?php } ?>
                                                        </td>
                                                    </tr><?php endforeach;
} ?>
                                        </tbody>
                                    </table>
                                    <!----TABLE LISTING ENDS--->
                                </div>
                            </section>

                            <section id="section-flip-2">
                                <!----CREATION FORM STARTS---->
                                <div class="tab-pane box" id="add" style="padding: 5px">
                                    <div class="box-content">
<?php echo form_open(base_url() . 'index.php?school_admin/grade/create', array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top'));
if ($this->session->flashdata('flash_message_error')) { ?>        
                                            <div class="alert alert-danger"><?php echo $this->session->flashdata('flash_message_error'); ?></div><?php } ?>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><?php echo get_phrase('evaluation_method'); ?><span class="error" style="color: red;"> *</span></label>
                                            <div  class="col-sm-5 controls">
                                                <select name="grade_id" onchange="evaluation_change(this)" class="selectpicker" data-live-search="true" data-style="form-control"><?php if (count($gradings)) {
                                                foreach ($gradings as $row2): ?>
                                                            <option value="<?php echo $row2['evaluation_id']; ?>" style="color: grey"> <?php echo $row2['name']; ?></option><?php endforeach;
} ?>
                                                </select>
                                            </div>
                                        </div> 
                                <!-- <div class="form-group" hidden="true" id="exam_category" >
                                    <label class="col-sm-3 control-label">
                                        <?php echo get_phrase('exam_category'); ?>
                                    </label>
                                     <div  class="col-sm-5 controls">
                                        <select name="Exam_category" class="selectpicker" data-style="form-control" data-container="body" data-live-search="true">
                                            <option value="<?php echo get_phrase('fa'); ?>">
                                                <?php echo get_phrase('formative_assessment'); ?>
                                            </option>
                                            <option value="<?php echo get_phrase('sa'); ?>" >
                                                <?php echo get_phrase('summative_assessment'); ?>
                                            </option>
                                        </select>
                                    </div>                 
                                </div>

                                <div class="form-group"  hidden="true" id="cce_exam_category" >          
                                    
                                    <label class="col-sm-3 control-label">
                                        <?php echo get_phrase('exam_category'); ?>
                                    </label>
                                     <div  class="col-sm-5 controls">
                                        <select name="exam_category_cce" class="selectpicker" data-style="form-control" data-live-search="true" data-container="body" onchange="evaluation_change_internal(this)">
                                            <option value="">
                                                <?php echo get_phrase('Select Assessment'); ?>
                                            </option>
                                            <?php foreach ($cce_exam_category as $cat): ?>
                                                <option value="<?php echo $cat['id']; ?>">
                                                    <?php echo $cat['cce_cat_name']; ?>
                                                </option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>                 
                                </div>
                                <br>
                                <div class="form-group" hidden="true" id="cce_exam_internal_category" >          
                                    <label class="col-sm-3 control-label">
                                        <?php echo get_phrase('internal_exam_category'); ?>
                                    </label>
                                     <div  class="col-sm-5 controls">
                                        <select name="exam_internal_category" class="selectpicker" data-style="form-control" data-container="body" data-live-search="true">
                                            <option value="">
                                                <?php echo get_phrase('select_internal_assessment'); ?>
                                            </option>
                                            <?php foreach ($cce_internal_category as $int_cat): ?>
                                                <option value="<?php echo $int_cat['assessment_id']; ?>">
                                                    <?php echo $int_cat['assessment_name']; ?>
                                                </option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>                 
                                </div>

                                <div class="form-group" hidden="true" id="icse_exam_assessment">          
                                    
                                    <label class="col-sm-3 control-label">
                                        <?php echo get_phrase('internal_exam_category'); ?>
                                    </label>
                                     <div  class="col-sm-5 controls">
                                        <select name="icse_exam_assessment" class="selectpicker" data-style="form-control" data-container="body" data-live-search="true">
                                            <option value="">Select Assessment
                                            </option>
                                            <option value="IA">
                                            Internal Assessment
                                            </option>
                                            <option value="EA">
                                            External Assessment
                                            </option>
                                           
                                        </select>
                                    </div>                 
                                </div> -->
                                        <!-- <div class="form-group">
                                            <div hidden="true" id="exam_category">
                                                <label class="col-sm-3 control-label"><?php echo get_phrase('exam_category'); ?><span class="error" style="color: red;"> *</span></label>
                                                <div  class="col-sm-5 controls">
                                                    <select name="grade_group" class="selectpicker" data-style="form-control" data-live-search="true">
                                                        <option value="<?php echo get_phrase('FA'); ?>"  style="color: grey"><?php echo get_phrase('formative_assessment'); ?></option>
                                                        <option value="<?php echo get_phrase('SA'); ?>"  style="color: grey"><?php echo get_phrase('summative_assessment'); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div> -->

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><?php echo get_phrase('name'); ?><span class="error" style="color: red;"> *</span></label>
                                            <div class="col-sm-5"><input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"/></div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><?php echo get_phrase('grade_point'); ?><span class="error" style="color: red;"> *</span></label>   
                                            <div class="col-sm-5"><input type="text" class="form-control" name="grade_point"  data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"/></div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><?php echo get_phrase('mark_from'); ?><span class="error" style="color: red;"> *</span></label>
                                            <div class="col-sm-5"><input type="number" class="form-control" name="mark_from" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"/></div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><?php echo get_phrase('mark_upto'); ?><span class="error" style="color: red;"> *</span></label>
                                            <div class="col-sm-5"><input type="number" class="form-control" name="mark_upto" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"/></div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><?php echo get_phrase('comment'); ?><span class="error" style="color: red;"> *</span></label>
                                            <div class="col-sm-5"><input type="text" class="form-control" name="comment" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"/></div>
                                        </div>                                

                                        <div class="text-right"><button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('add_grade'); ?></button></div>

<?php echo form_close(); ?>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<!-- <script type="text/javascript">
    function evaluation_change(type) {
        if ((type.options[type.selectedIndex].innerHTML).trim() == "CCE") {
            $('#exam_category').prop('hidden', false);
        } else {
            $('#exam_category').prop('hidden', true);
        }
    }
</script> -->
<script type="text/javascript">
    function evaluation_change(type) {
        if ((type.options[type.selectedIndex].innerHTML).trim() == "IBO") {
            $('#exam_category').prop('hidden', false);
            $('#cce_exam_internal_category').prop('hidden', true);
        } else {
            $('#exam_category').prop('hidden', true);
            $('#cce_exam_internal_category').prop('hidden', true);
        }

        if ((type.options[type.selectedIndex].innerHTML).trim() == "CCE") {
            $('#cce_exam_category').prop('hidden', false);
        } else {
            $('#cce_exam_category').prop('hidden', true);
        }

        if ((type.options[type.selectedIndex].innerHTML).trim() == "ICSE")
        {
           $('#icse_exam_assessment').prop('hidden', false);
        }else
        {
            $('#icse_exam_assessment').prop('hidden', true);
        }
    }

    function evaluation_change_internal(type)
    {
        if ((type.options[type.selectedIndex].innerHTML).trim() == "Internal Exam")
        {
            $('#cce_exam_internal_category').prop('hidden', false);
        } else
        {
            $('#cce_exam_internal_category').prop('hidden', true);
        }
    }

    function valid_only_numeric(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

</script>