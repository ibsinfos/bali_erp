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
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

    <div class="white-box"> 
<!-- Include JS file. -->
     <div class="sttabs tabs-style-flip">
            <nav>
                <ul>
                    <li id="section1">
                        <a href="#section-flip-1" class="sticon fa fa-list " data-step="5" data-intro="<?php echo get_phrase('You can see online exam list here.');?>"position='right'><span><?php echo get_phrase('online_exam_list'); ?></span></a></li>
                    <li id="section2">
                        <a href="#section-flip-2" class="sticon fa fa-plus" data-step="6" data-intro="<?php echo get_phrase('From here you can add new online exam.');?>" data-position='left'><span><?php echo get_phrase('add_online_exam'); ?></span></a></li>

                </ul>
            </nav>                                    
            <div class="content-wrap">
                <section id="section-flip-1">   
                <table class="table display" id="example23">
                    <thead>
                        <tr>
                            <th><div><?php echo get_phrase('exam_name'); ?></div></th>
                            <th><div><?php echo get_phrase('date'); ?></div></th>
                            <th><div><?php echo get_phrase('class'); ?></div></th>
<!--                            <th><div><?php //echo get_phrase('Notification'); ?></div></th>-->
                            <th><div><?php echo get_phrase('status'); ?></div></th>
                            <th><div><?php echo get_phrase('options'); ?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($exams as $row): ?>
                            <tr>
                                <td><?php echo $row['exam_name']; ?></td>
                                <td><?php echo $row['start_date'] . " to " . $row['end_date']; ?></td>
                                <td><?php echo "Class " .$row['class_name'];?></td>
    <!--                                                        <td><input type="button" value="Send Notification" class="btn btn-success"
                                           onclick="send_notification('<?php //echo isset($row['name'])?$row['name']:''  ?>','<?php //echo isset($row['date'])?$row['date']:''  ?>','<?php //echo isset($row['comment'])?$row['comment']:''  ?>')">
                                </td>-->   
                                <td>
                                    <a href="<?php echo base_url(); ?>index.php?school_admin/online_exam/status/<?php echo $row['status']; ?>/<?php echo $row['id']; ?>"> 
                                        <button type="button" class="btn btn-primary btn"><?php echo get_phrase($row['status']); ?></button>
                                    </a>
                                </td>
                                <td>
                                    <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_online_exam/<?php echo $row['id']; ?>');">
                                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('edit');?>" title="<?php echo get_phrase('edit');?>">
                                        <i class="fa fa-pencil-square-o"></i>
                                        </button> 
                                    </a>
                                    <?php if($row['status'] != "active"){?>
                                    <a href="<?php echo base_url(); ?>index.php?school_admin/add_subject_online_exam/<?php echo $row['class_id']; ?>/<?php echo $row['id']; ?>">
                                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('add_question');?>" title="<?php echo get_phrase('add_question');?>">
                                        <i class="fa fa-plus-circle"></i>
                                        </button> 
                                    </a>
                                    <?php } ?>
<!--                                     <a href="javascript: void(0);" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/online_exam/delete/<?php echo $row['id']; ?>');">
                                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('delete');?>" title="<?php echo get_phrase('delete');?>">
                                        <i class="fa fa-trash"></i>
                                        </button> 
                                    </a>-->
                                </td>
                                
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

               
                </section>
                
                <section id="section-flip-2">
                                <div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
                    <form class="form-horizontal form-groups-bordered validate" name='add_exam_form' id="add_exam_form" method="post" action="<?php echo base_url(); ?>index.php?school_admin/online_exam/create">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('exam_name'); ?><span class="error mandatory">*</span></label>
                            <div class="col-md-5 input-group">
                                <div class="input-group-addon"><i class="fa fa-info"></i></div>   
                                <input type="text" class="form-control" id="name" name="name" required="required" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('comment'); ?><span class="error mandatory">*</span></label>
                            <div class="col-md-5 input-group">
                                <div class="input-group-addon"><i class="fa fa-comment"></i></div>  
                                <input type="text" class="form-control" id="comment" required="required" name="comment"/>
                            </div>
                        </div>                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase
                                ('passing_percent');
                        ?><span class="error mandatory">*</span></label>
                            <div class="col-md-5 input-group">
                                <div class="input-group-addon"><i class="fa fa-percent"></i></div>  
                                <input type="number" class="form-control" id="passing_percent" name="passing_percent" required="required" data-validate="required" data- message-required="<?php echo get_phrase('value_required'); ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase
                                        ('exam_instruction');
                        ?></label>
                            <div class="col-md-5 input-group">
                                <div class="input-group-addon"><i class="fa fa-list"></i></div> 
                                <textarea name="exam_instruction" id="froala-editor" rows="8" class="form-control" ></textarea>                         
                            </div>
                        </div>
<!--                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase
                                        ('Attempt Count');
                        ?></label>
                            <div class="col-sm-5">
                                <input type="number" class="form-control" 
                                       id="attempt_count" name="attempt_count" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"/>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase
                                        ('exam_duration(Min.)');
                        ?><span class="error mandatory">*</span></label>
                            <div class="col-md-5 input-group">
                                <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>  
                                <input type="number" class="form-control" 
                                       id="exam_duration" name="exam_duration" required="required" data-validate="required" data-message-
                                       required="<?php echo get_phrase('value_required'); ?>"/>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase
                                        ('start_date');
                        ?><span class="error mandatory">*</span></label>
                            <div class="col-md-5 input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>  
                              <input type="text" class="datepicker form-control" 
                                     id="datepicker" required="required" name="start_date" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"/>
                            </div>
                        </div> 
                        <div class="form-group">
                           <label class="col-sm-3 control-label"><?php echo get_phrase
                                        ('end_date');
                        ?><span class="error mandatory">*</span></label>
                            <div class="col-md-5 input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>  
                                <input type="text" class="datepicker form-control" 
                                       id="datepicker" required="required" name="end_date" id="datepicker" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"/>
                            </div>
                        </div> 

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase
                                        ('select_class');
                        ?><span class="error mandatory">*</span></label>
                            <div class="col-md-5 input-group">
                                <div class="input-group-addon"><i class="fa fa-list"></i></div>  
                                <select class="selectpicker" data-style="form-control" data-live-search="true" required="required" name="class_id" >
                                    <option value="">Select Class</option>
                                    <?php
                                    foreach ($classes as $row):
                                        ?>
                                        <option value="<?php echo $row['class_id']; ?>" >
    <?php echo get_phrase('class'); ?>&nbsp;<?php echo
    $row['name'];
    ?>
                                        </option>
<?php endforeach; ?>
                                </select>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase
        ('declare_result');
?><span class="error mandatory">*</span></label>
                            <div class="col-sm-5">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" 
                                           name="declare_result" value="Yes"   checked="checked" >
<?php echo get_phrase('yes'); ?>
                                </label> 
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" 
                                           name="declare_result" value="No">
<?php echo get_phrase('no'); ?>
                                </label> 
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase
        ('negative_marking');
?><span class="error mandatory">*</span></label>
                            <div class="col-sm-5">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" 
                                           name="negative_marking" value="Yes"   checked="checked" >
<?php echo get_phrase('yes'); ?>
                                </label> 
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" 
                                           name="negative_marking" value="No">
<?php echo get_phrase('no'); ?>
                                </label> 
                            </div>
                        </div> 

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase
        ('random_question');
?><span class="error mandatory">*</span></label>
                            <div class="col-sm-5">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" 
                                           name="random_question" value="1" >
                                <?php echo get_phrase('yes'); ?>
                                </label> 
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" 
                                           name="random_question" value="0" checked="checked">
                                           <?php echo get_phrase('no'); ?>
                                </label> 
                            </div>
                        </div> 
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase
                                                   ('result_after_finish');
                                           ?><span class="error mandatory">*</span></label>
                            <div class="col-sm-5">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" 
                                           name="result_after_finish" value="1" >
<?php echo get_phrase('yes'); ?>
                                </label> 
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" 
                                           name="result_after_finish" value="0" checked="checked">
<?php echo get_phrase('no'); ?>
                                </label> 
                            </div>
                        </div> 
<!--                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase
        ('paid_exam');
?></label>
                            <div class="col-sm-5">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" 
                                           name="paid_exam" value="1" >
<?php echo get_phrase('yes'); ?>
                                </label> 
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" 
                                           name="paid_exam" value="0" checked="checked">
<?php echo get_phrase('no'); ?>
                                </label> 
                            </div>
                        </div> -->

<!--                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase
        ('amount');
?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="amount" 
                                       name="amount" onkeypress='return valid_only_numeric(event)'/>
                            </div>
                        </div> -->

                        <div class="form-group text-right">
                            <div class="col-sm-offset-5 col-sm-7 btn-center-in-sm">
                                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('add_exam'); ?></button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
         </section>
    </div>
<!--<div class="row">
    <div class="col-md-12">

        ----CONTROL TABS START----
        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#list" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-menu"></i></span> 
                    <span class="hidden-xs"><i class="entypo-menu"></i><?php echo get_phrase('exam_list'); ?></span>
                </a>
            </li>
            <li>
                <a href="#add" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-plus-circled"></i></span>
                    <span class="hidden-xs"><i class="entypo-plus-circled"></i><?php echo get_phrase('add_exam'); ?></span>
                </a>
            </li>
        </ul>
        ----CONTROL TABS END----
        <div class="tab-content">

            --TABLE LISTING STARTS
            <div class="tab-pane box active for-table-top" id="list">
                <table class="table table-bordered datatable" id="example23">
                    <thead>
                        <tr>
                            <th><div><?php echo get_phrase('exam_name'); ?></div></th>
                            <th><div><?php echo get_phrase('date'); ?></div></th>
                            <th><div><?php echo get_phrase('class'); ?></div></th>
                            <th><div><?php echo get_phrase('Notification'); ?></div></th>
                            <th><div><?php echo get_phrase('options'); ?></div></th>
                            <th><div><?php echo get_phrase('status'); ?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($exams as $row): ?>
                            <tr>
                                <td><?php echo $row['exam_name']; ?></td>
                                <td><?php echo $row['start_date'] . " to " . $row['end_date']; ?></td>
                                <td><?php echo "Class " . $this->crud_model->get_type_name_by_id('class', $row['class_id']); ?></td>
                                                            <td><input type="button" value="Send Notification" class="btn btn-success"
                                           onclick="send_notification('<?php //echo isset($row['name'])?$row['name']:''  ?>','<?php //echo isset($row['date'])?$row['date']:''  ?>','<?php //echo isset($row['comment'])?$row['comment']:''  ?>')">
                                </td>   
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                            Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-default pull-right pos-static" role="menu">

                                             EDITING LINK 
                                            <li>
                                                <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_online_exam/<?php echo $row['id']; ?>');">
                                                    <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('edit'); ?>
                                                </a>
                                            </li>

                                            <li class="divider"></li>

                                            <li>
                                                <a href="<?php echo base_url(); ?>index.php?school_admin/add_subject_online_exam/<?php echo $row['class_id']; ?>/<?php echo $row['id']; ?>">
                                                    <i class="entypo-plus-circled"></i>
                                                    <?php echo get_phrase('add_question'); ?>
                                                </a>
                                            </li>

                                             DELETION LINK 
                                            <li>
                                                <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/online_exam/delete/<?php echo $row['id']; ?>');">
                                                    <i class="entypo-trash"></i>
                                                    <?php echo get_phrase('delete'); ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <a href="<?php echo base_url(); ?>index.php?school_admin/online_exam/status/<?php echo $row['status']; ?>/<?php echo $row['id']; ?>"> 
                                        <button><?php echo get_phrase($row['status']); ?></button>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            --TABLE LISTING ENDS-

            --CREATION FORM STARTS--
            <div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
                    <form class="form-horizontal form-groups-bordered validate" name='add_exam_form' id="add_exam_form" method="post" action="<?php echo base_url(); ?>index.php?school_admin/online_exam/create">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('exam_name'); ?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="name" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('comment'); ?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="comment" name="comment"/>
                            </div>
                        </div>                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase
                                ('passing_percent');
                        ?></label>
                            <div class="col-sm-5">
                                <input type="number" class="form-control" 
                                       id="passing_percent" name="passing_percent" data-validate="required" data-
                                       message-required="<?php echo get_phrase('value_required'); ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase
                                        ('exam_instruction');
                        ?></label>
                            <div class="col-sm-5">
                                <textarea name="exam_instruction" id="froala-editor"  
                                          rows="8" class="form-control" ></textarea>                         
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase
                                        ('Attempt Count');
                        ?></label>
                            <div class="col-sm-5">
                                <input type="number" class="form-control" 
                                       id="attempt_count" name="attempt_count" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"/>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase
                                        ('exam_duration(Min.)');
                        ?></label>
                            <div class="col-sm-5">
                                <input type="number" class="form-control" 
                                       id="exam_duration" name="exam_duration" data-validate="required" data-message-
                                       required="<?php echo get_phrase('value_required'); ?>"/>
                            </div>
                        </div> 

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase
                                        ('start_date');
                        ?></label>
                            <div class="col-sm-5">
                                <input type="text" class="datepicker form-control" 
                                       id="start_date" name="start_date" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"/>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase
                                        ('end_date');
                        ?></label>
                            <div class="col-sm-5">
                                <input type="text" class="datepicker form-control" 
                                       id="end_date" name="end_date" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"/>
                            </div>
                        </div> 

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase
                                        ('select_class');
                        ?></label>
                            <div class="col-sm-5">
                                <select class="form-control selectboxit" name="class_id" >
                                    <option value="">Select Class</option>
                                    <?php
                                    foreach ($classes as $row):
                                        ?>
                                        <option value="<?php echo $row['class_id']; ?>" >
    <?php echo get_phrase('class'); ?>&nbsp;<?php echo
    $row['name'];
    ?>
                                        </option>
<?php endforeach; ?>
                                </select>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase
        ('declare_result');
?></label>
                            <div class="col-sm-5">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" 
                                           name="declare_result" value="Yes"   checked="checked" >
<?php echo get_phrase('yes'); ?>
                                </label> 
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" 
                                           name="declare_result" value="No">
<?php echo get_phrase('no'); ?>
                                </label> 
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase
        ('negative_marking');
?></label>
                            <div class="col-sm-5">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" 
                                           name="negative_marking" value="Yes"   checked="checked" >
<?php echo get_phrase('yes'); ?>
                                </label> 
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" 
                                           name="negative_marking" value="No">
<?php echo get_phrase('no'); ?>
                                </label> 
                            </div>
                        </div> 

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase
        ('random_question');
?></label>
                            <div class="col-sm-5">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" 
                                           name="random_question" value="1" >
                                <?php echo get_phrase('yes'); ?>
                                </label> 
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" 
                                           name="random_question" value="0" checked="checked">
                                           <?php echo get_phrase('no'); ?>
                                </label> 
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase
                                                   ('result_after_finish');
                                           ?></label>
                            <div class="col-sm-5">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" 
                                           name="result_after_finish" value="1" >
<?php echo get_phrase('yes'); ?>
                                </label> 
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" 
                                           name="result_after_finish" value="0" checked="checked">
<?php echo get_phrase('no'); ?>
                                </label> 
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase
        ('paid_exam');
?></label>
                            <div class="col-sm-5">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" 
                                           name="paid_exam" value="1" >
<?php echo get_phrase('yes'); ?>
                                </label> 
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" 
                                           name="paid_exam" value="0" checked="checked">
<?php echo get_phrase('no'); ?>
                                </label> 
                            </div>
                        </div> 

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase
        ('amount');
?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="amount" 
                                       name="amount" onkeypress='return valid_only_numeric(event)'/>
                            </div>
                        </div> 

                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-7 btn-center-in-sm">
                                <button type="submit" class="btn btn-success"><?php echo get_phrase('add_exam'); ?></button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            --CREATION FORM ENDS
        </div>
    </div>
</div>-->


<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->  

<script type="text/javascript">

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
    function evaluation_change(type)

    {
        if ((type.options[type.selectedIndex].innerHTML).trim() == "CCE")
        {
            $('#exam_category').prop('hidden', false);
        } else
        {
            $('#exam_category').prop('hidden', true);
        }

    }

</script>

<script>

    $(function () {
        $('#froala-editor').froalaEditor({
            heightMin: 100,
            heightMax: 200
        });
    });



//$("#start_date, #end_date").datepicker();
    $("#end_date").change(function () {
        var startDate = document.getElementById("start_date").value;
        var endDate = document.getElementById("end_date").value;

        if ((Date.parse(endDate) <= Date.parse(startDate))) {
            alert("End date should be greater than Start date");
            document.getElementById("end_date").value = "";
        }
    });
</script>



