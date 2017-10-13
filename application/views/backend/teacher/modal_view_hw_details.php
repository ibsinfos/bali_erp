<div><?php if (!isset($data_not_found)) { ?>
    <header class="row">
        <h3>
            &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $home_work_det['hw_name']; ?>
        </h3>
    </header>

   


    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-hover manage-u-table">
                    <tr>
                        <td><?php echo get_phrase('home_work_description'); ?></td>
                        <td><b><?php echo $home_work_det['hw_description']; ?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('start_date'); ?></td>
                        <td><b><?php echo $home_work_det['start_date']; ?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('end_date'); ?></td>
                        <td><b><?php echo $home_work_det['end_date']; ?></b></td>
                    </tr>
                </table>
            </div>
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
