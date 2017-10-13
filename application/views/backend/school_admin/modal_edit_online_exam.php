<?php foreach ($edit_data as $row):
    ?>     
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title" >
                        <i class="entypo-plus-circled"></i>
    <?php echo get_phrase('edit_online_exam'); ?>
                    </div>
                </div>
                <div class="panel-body">

    <?php echo form_open(base_url() . 'index.php?school_admin/online_exam/edit/do_update/' . $row['id'], array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                    <div class="padded">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('name'); ?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" required="required" name="name" value="<?php echo $row['exam_name']; ?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" autofocus=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('comment'); ?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control"  name="comment" value="<?php echo $row['comment']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('passing_percent'); ?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" required="required" name="passing_percent" value="<?php echo $row['passing_percent']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('exam_instruction'); ?></label>
                            <div class="col-sm-5">
                                <textarea name="exam_instruction" id="froala-editor"  rows="8" class="form-control" ><?php echo $row['instruction']; ?></textarea>                         
                            </div>
                        </div>
<!--                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('Attempt Count'); ?></label>
                            <div class="col-sm-5">
                                <input type="number" class="form-control" id="attempt_count" name="attempt_count" value="<?php echo $row['attempt_count']; ?>" />
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('exam_duration(Min.)'); ?></label>
                            <div class="col-sm-5">
                                <input type="number" class="form-control" required="required" id="exam_duration" name="exam_duration" value="<?php echo $row['duration']; ?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"/>
                            </div>
                        </div> 

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('start_date'); ?></label>
                            <div class="col-sm-5">
                                <input type="text" class="datepicker form-control" required="required" id="start_date" name="start_date"  value="<?php echo $row['start_date']; ?>" />
                            </div>
                        </div> 

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('end_date'); ?></label>
                            <div class="col-sm-5">
                                <input type="text" class="datepicker form-control" required="required" id="end_date" name="end_date" value="<?php echo $row['end_date']; ?>"/>
                            </div>
                        </div>  
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('select_class'); ?></label>
                            <div class="col-sm-5">
                                <select class="selectpicker1" data-style="form-control" data-live-search="true" required="required" name="class_id" >
                                    <option value="">Select Class</option>
                                    <?php
                                    foreach ($classes as $rows):                                        
                                    if($rows['class_id']==$row['class_id']){ ?>
                                    <option value="<?php
                                        echo $rows['class_id']; ?>" selected="selected">
                                        <?php echo get_phrase('class'); ?>&nbsp;<?php echo $rows['name']; }else{ ?>
                                          <option value="<?php echo $rows['class_id']; ?>">
                                        <?php echo get_phrase('class'); ?>&nbsp;<?php echo $rows['name']; ?>
                                        </option>                                              
                                      <?php  } ?>
                                        
                                        
    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('declare_result'); ?></label>
                            <div class="col-sm-5">
                                <label class="form-check-label">
                                    <?php 
                                    $checked1_dr='';
                                    $checked2_dr='';
                                    if($row['declare_result']=='Yes')
                                    $checked1_dr='checked';
                                          else
                                    $checked2_dr='checked'; 
                                     ?>
                                    <input class="form-check-input" type="radio" name="declare_result" value="Yes" <?php  echo $checked1_dr; ?> >
    <?php echo get_phrase('yes'); ?>
                                </label> 
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="declare_result" value="No" <?php  echo  $checked2_dr; ?> >
    <?php echo get_phrase('no'); ?>
                                </label> 
                            </div>
                        </div>

                        <div class="form-group">
                             <?php 
                                    $checked1_nm='';
                                    $checked2_nm='';
                                    if($row['negative_marking']=='Yes')
                                    $checked1_nm='checked';
                                          else
                                    $checked2_nm='checked'; 
                             ?>
                            <label class="col-sm-3 control-label"><?php echo get_phrase('negative_marking'); ?></label>
                            <div class="col-sm-5">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="negative_marking" value="Yes" <?php echo $checked1_nm; ?> >
    <?php echo get_phrase('yes'); ?>
                                </label>
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="negative_marking" value="No" <?php echo $checked2_nm; ?>>
    <?php echo get_phrase('no'); ?>
                                </label> 
                            </div>
                        </div>

                        <div class="form-group">
                            <?php
                                    $checked1_rq='';
                                    $checked2_rq='';
                                    if($row['ques_random']==1)
                                    $checked1_rq='checked';
                                          else
                                    $checked2_rq='checked'; 
                                     ?>
                            <label class="col-sm-3 control-label"><?php echo get_phrase('random_question'); ?></label>
                            <div class="col-sm-5">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="random_question" value="1" <?php echo $checked1_rq; ?> >
    <?php echo get_phrase('yes'); ?>
                                </label> 
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="random_question" value="0"  <?php echo $checked2_rq; ?>>
    <?php echo get_phrase('no'); ?>
                                </label> 
                            </div>
                        </div> 

                        <div class="form-group">
                               <?php 
                         
                                    $checked1_fr='';
                                    $checked2_fr='';
                                    if($row['finish_result']==1)
                                    $checked1_fr='checked';
                                          else
                                    $checked2_fr='checked'; 
                                     ?>
                            
                            <label class="col-sm-3 control-label"><?php echo get_phrase('result_after_finish'); ?></label>
                            <div class="col-sm-5">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="result_after_finish" value="1" <?php echo $checked1_fr; ?> >
    <?php echo get_phrase('yes'); ?>
                                </label> 
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="result_after_finish" value="0" <?php echo $checked2_fr; ?>>
    <?php echo get_phrase('no'); ?>
                                </label> 
                            </div>
                        </div> 
<!-- 
                        <div class="form-group">
                            <?php 
                            $checked1_pe='';
                                    $checked2_pe='';
                                    if($row['paid_exam']==1)
                                    $checked1_pe='checked';
                                          else
                                    $checked2_pe='checked'; 
                                     ?>
                        <label class="col-sm-3 control-label"><?php echo get_phrase('paid_exam'); ?></label>
                            <div class="col-sm-5">
                                
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="paid_exam" value="1" <?php echo $checked1_pe; ?>>
    <?php echo get_phrase('yes'); ?>
                                </label> 
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="paid_exam" value="0" <?php echo $checked2_pe; ?>>
    <?php echo get_phrase('no'); ?>
                                </label> 
                            </div>
                        </div> -->

<!--                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('amount'); ?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="amount" name="amount" onkeypress='return valid_only_numeric(event)' value="<?php echo $row['amount']; ?>"/>
                            </div>
                        </div> -->

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <button type="submit" class="btn btn-info"><?php echo get_phrase('edit_exam'); ?></button>
                            </div>
                        </div>
    <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
endforeach;
?>

<script type="text/javascript">

    $(function() {
        $(".datepicker").datepicker({
            dateFormat: "dd/mm/yy",
            changeMonth: true,
            changeYear: true,
            //endDate: '+1d',
            autoclose: true
        });
    });


</script>

