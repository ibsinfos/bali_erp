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


<div class="row">
    <div class="col-md-12">
        <div class="white-box" data-step="7" data-intro<?php echo get_phrase('Select.');?>" data-position='top'>

            <section>
                <div class="sttabs tabs-style-flip">
                    <nav>
                        <ul>

                            <li id="section1" data-step="5" data-intro="<?php echo get_phrase('From here you can view and edit the exams.');?>" data-position="top"><a href="#section-flip-1" class="sticon fa fa-list"><span><?php echo get_phrase('exam_list'); ?></span></a></li>
                            <li id="section2" data-step="6" data-intro="<?php echo get_phrase('From here you can add a new exam.');?>" data-position="top"><a href="#section-flip-2" class="sticon fa fa-plus"><span><?php echo get_phrase('add_exam'); ?></span></a></li>
                        </ul>
                    </nav>

                    <div class="content-wrap">
                        <section id="section-flip-1">

                            <!----TABLE LISTING STARTS-->
                            <div class="tab-pane box active for-table-top" id="list">
                                <table class= "custom_table table display"  id="example23">
                                    <thead>
                                        <tr>
                                            <th><div><?php echo get_phrase('no'); ?></div></th>
                                            <th><div><?php echo get_phrase('exam_name'); ?></div></th>
                                            <th><div><?php echo get_phrase('grading_method'); ?></div></th>
                                            <th><div><?php echo get_phrase('date'); ?></div></th>
                                            <th><div><?php echo get_phrase('comment'); ?></div></th>
                                            <th><div><?php echo get_phrase('options'); ?></div></th>
                                        </tr>
                                    </thead>
                                    <tbody><?php
                                        if (count($exams)) {$k= 1;
                                            foreach ($exams as $row):
                                                 ?>
                                                <tr>
                                                    <td><?php echo $k; ?></td>
                                                    <td><?php echo $row['name']; ?></td>
                                                    <td><?php
                                                        foreach($gradings as $grade){
                                                            $grade_id = $grade['evaluation_id'];
                                                            if($grade_id == $row['grading']){
                                                                echo $grade['name'];
                                                            }
                                                        }
                                                     ?></td>
                                                    <td><?php echo $row['date']; ?></td>
                                                    <td><?php echo $row['comment']; ?></td>
                                                    <td>
                                                        <!--Exam Routine link -->
                                                        <a href="<?php echo base_url(); ?>index.php?school_admin/exam_routine/<?php echo $row['exam_id']; ?>"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('add_exam_routine'); ?>"><i class="fa fa-eye"></i></button></a>
                                                        <!--edit-->
                                                        <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_exam/<?php echo $row['exam_id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('edit'); ?>" title="<?php echo get_phrase('edit'); ?>" title="<?php echo get_phrase('edit'); ?>"><i class="fa fa-pencil-square-o"></i></button></a>
                                                        <!--delete-->


                                                        <?php
                                                        $transaction = $row['transaction'];
                                                        if ($transaction) {
                                                            ?>
                                                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 disabled" ><i class="fa fa-trash-o"></i></button>
                                                        <?php } else {
                                                            ?>                                                
                                                            <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/exam/delete/<?php echo $row['exam_id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete" title="Delete"><i class="fa fa-trash-o"></i></button></a>
                                                        <?php } ?> 

                                                    </td>
                                                </tr><?php
                                                $k++;
                                            endforeach;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <!----TABLE LISTING ENDS--->   
                        </section>

                        <section id="section-flip-2">
                            <!----CREATION FORM STARTS---->

                            <form class="form-horizontal form-groups-bordered validate" name='add_exam_form' id="add_exam_form" method="post" action="<?php echo base_url(); ?>index.php?school_admin/exam/create">

                                <div class="row">          
                                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                                        <label>
                                            <?php echo get_phrase('exam_name'); ?>
                                            <span class="mandatory"> *</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-book"></i></div>
                                            <input type="text" class="form-control" data-validate="required"  name="name" placeholder="Exam Name"> 
                                        </div>
                                        <label class="mandatory"> <?php echo form_error('name'); ?></label>
                                    </div> 
                                </div>

                                <div class="row">          
                                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                                        <label>
                                            <?php echo get_phrase('date'); ?>
                                            <span class="error" style="color: red;"> *</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon" id="exam_date"><i class="fa fa-calendar"></i></div>
                                            <input type="text" required="required" class="form-control" id="datepicker" name="date" data-validate="required" >
                                        </div>
                                        <label class="mandatory"> <?php echo form_error('date'); ?></label>
                                    </div>
                                </div>


                                <div class="row">          
                                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                                        <label>
                                            <?php echo get_phrase('comment'); ?>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-comment"></i></div>
                                            <input type="text" class="form-control" id="comment" name="comment"/>
                                        </div>
                                    </div>
                                </div>
                                <br>

                                <div class="row">          
                                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                                        <label>
                                            <?php echo get_phrase('evaluation_method'); ?>
                                            <span class="error" style="color: red;"> *</span>
                                        </label>
                                        <div class="input-group col-md-12" id="evaluation_method">
                                            <select id="grade_id" name="grade_id" onchange="evaluation_change(this)" class="selectpicker" data-style="form-control" data-container="body" data-live-search="true">
                                                <?php
                                                if (count($gradings)) {
                                                    foreach ($gradings as $row2):
                                                        ?>
                                                        <option value="<?php echo $row2['evaluation_id']; ?>" >
                                                            <?php echo $row2['name']; ?>
                                                        </option>
                                                        <?php
                                                    endforeach;
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">          
                                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                                        <div hidden="true" id="exam_category" >
                                            <label>
                                                <?php echo get_phrase('exam_category'); ?>
                                            </label>
                                            <div class="input-group col-md-12">
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
                                    </div>
                                </div>

                                <div class="row">          
                                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                                        <div hidden="true" id="cce_exam_category" >
                                            <label>
                                                <?php echo get_phrase('exam_category'); ?>
                                            </label>
                                            <div class="input-group col-md-12">
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
                                    </div>
                                </div>
                                <br>
                                <div class="row">          
                                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                                        <div hidden="true" id="cce_exam_internal_category" >
                                            <label>
                                                <?php echo get_phrase('internal_exam_category'); ?>
                                            </label>
                                            <div class="input-group col-md-12">
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
                                    </div>
                                </div>

                                <div class="row">          
                                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                                         <div hidden="true" id="icse_exam_assessment" >
                                            <label>
                                                <?php echo get_phrase('internal_exam_category'); ?>
                                            </label>
                                            <div class="input-group col-md-12">
                                                <select name="icse_exam_assessment" class="selectpicker" data-style="form-control" data-container="body" data-live-search="true">
                                                    <option value="">Select Assessment</option>
                                    <option value="IA">Internal Assessment</option>
                                    <option value="EA">External Assessment</option>
                                                   
                                                </select>
                                            </div>                 
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d">
                                        <?php echo get_phrase('add_exam'); ?>
                                    </button>
                                </div>

                            </form>

                            <!----CREATION FORM ENDS-->   
                        </section>
                    </div>

                </div>

            </section>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#dt_table').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
            {
                'copy', 'excel', 'pdf', 'print'}
        ],
        order: [[0, "desc"]]
    });

    function valid_only_numeric(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    /************ajax fun for notification******************************/
    function send_notification(exam_name, date, comment) {
        $.ajax({
            type: 'post',
            url: '<?php echo base_url(); ?>index.php?school_admin/send_exam_notification/',
            data: {exam_name: exam_name, exam_date: date, comment: comment, event: 'exam_date'},
            success: function (response) {
                if (response == "OK") {
                    toastr.success('Sent Successfully');
                } else {
                    return false;
                }
            }
        });
    }

</script>
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

</script>

