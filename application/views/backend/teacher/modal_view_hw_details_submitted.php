<div><?php 



if (!isset($data_not_found)) { ?>
    <header class="row">
        
    </header>


<?php

?>
    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-hover manage-u-table">
                    <tr>
                        <td><?php echo get_phrase('home_work_description'); ?></td>
                        <td><b><?php echo $home_work_det['homework']; ?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('start_date'); ?></td>
                        <td><b><?php echo $home_work_det['start_date']; ?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('end_date'); ?></td>
                        <td><b><?php echo $home_work_det['end_date']; ?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('solution_submitted'); ?></td>
                        <td><b><?php echo $home_work_det['submission_disc']; ?></b></td>
                    </tr>
                     <tr>
                        <td><?php echo get_phrase('submitted_on'); ?></td>
                        <td><b><?php echo $home_work_det['updated_date']; ?></b></td>
                    </tr>
                   
                    
                </table>
                      
            </div>
             <?php echo form_open(base_url() . 'index.php?teacher/update_homework/' . $home_work_det['home_work_id'], array('class' => 'form-material form-groups-bordered validate','target'=>'_top')); ?>

                     
                            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                                <label for="field-1" class="field-size"><?php echo get_phrase("enter_marks"); ?><span class="error error-color"> *</span></label>
                                <input type="text" class="form-control" name="marks" value="<?php echo $home_work_det['marks'];?>" required="required">
                            </div>
                       <div class="col-xs-12 col-sm-6 col-md-6 form-group m-t-20">
                            <div class="text-right">
                                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('save');?></button>
                            </div>
                        </div>
                     
                        <?php echo form_close(); ?>
        </div>
    </div><?php } else { ?>
    <header class="row">
        <div class="col-xs-3">
                <?php echo $data_not_found; ?>
            </div>
        </header><?php } ?>
</div>
<style type="text/css">
    .stud-image-icon {
        width: 150px !important;
        height: 200px !important;
    }
    
    .myProgress {
    width: 100%;
    background-color: silver;
    }
    <?php foreach($online_polls['answer_det'] as $answer) {
        $answer_poll_percent        =   ($answer['no_of_votes']/$online_polls['total_poll'])*100;
        ?>
    <?php echo '#my_bar_'.$answer['poll_answer_id'];?> {
        width: <?php echo $answer_poll_percent."%";?>;
        height: 30px;
        background-color: #707CD2;
    }
    
    <?php } ?>   
/*    .my_bar {
        width : 30%;
        height: 30px;
        background-color: green;
    }*/
</style>