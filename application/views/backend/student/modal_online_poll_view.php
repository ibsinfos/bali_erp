<div>
hI
<?php if (!isset($data_not_found)) { ?>
    <header class="row">
        <div class="col-md-12">
        <h3>
            <?php echo $online_polls['poll_title']; ?>
        </h3>
        </div>
    </header>
    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-hover manage-u-table table-bordered">
                    <tr>
                        <td ><?php echo get_phrase('poll_description'); ?></td>
                        <td style ="white-space:normal"><b><?php echo $online_polls['poll_descreption']; ?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('post_date'); ?></td>
                        <td><b><?php echo $online_polls['post_date']; ?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('total_polls'); ?></td>
                        <td><b><?php echo $online_polls['total_poll']; ?></b></td>
                    </tr>
                    <?php if(!empty($online_polls['answer_det'])) { 
                        $answ_count         =   1;
                        foreach($online_polls['answer_det'] as $answer) {
                            if($online_polls['total_poll']==0){
                                $answer_poll_percent=0;
                            }else{
                                $answer_poll_percent        =   ($answer['no_of_votes']/$online_polls['total_poll'])*100;
                            }
                        ?>
                            <tr>
                                <td><?php echo "Answer ".$answ_count++;?></td>
                                <td>
                                    <?php echo $answer['answer']." : ".$answer_poll_percent."% <br>";?>
                                    <div class="myProgress" title="<?php echo $answer_poll_percent;?>%" id="<?php echo 'my_progress_'.$answer['poll_answer_id']; ?>" >
                                        <div class="my_bar" id="<?php echo 'my_bar_'.$answer['poll_answer_id']; ?>"></div>
                                    </div>
                                    <?php //echo $answer_poll_percent        =   ($online_polls['total_poll']/$answer['no_of_votes'])*100; ?>
                                </td>
                            </tr>
                        <?php } } ?>

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
