<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?></h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?student/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?student/my_exam"><?php echo get_phrase('my_exam'); ?></a></li>
            <li class="active">
                <?php echo get_phrase($page_title); ?>
            </li>
        </ol>
    </div>
</div>
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro|Open+Sans+Condensed:300|Raleway' rel='stylesheet' type='text/css'>
<div class="white-box">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6">
                <?php foreach ($subjects as $row) { ?>
                    <button class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo $row['subject_name']; ?></button>
                <?php } ?>
            </div>
            <div class="col-md-6 text-right">
                <button class="fcbtn btn btn-danger btn-outline btn-1d">
                    <span id="demo"></span>
                </button>
            </div>
        </div>
    </div>
</div>
<?php $answer_data; ?>
<div class="white-box">
    <?php echo form_open(base_url() . 'index.php?student/submit_online_exam', array('class' => 'validate', 'target' => '_top', 'id'=>'online_exam')); ?>
    <div class="row">
        <input type="hidden" name="exam_id" value="<?php echo $exam_id ?>">
        <input type="hidden" name="question_id" value="<?php echo $question->id; ?>">
        <input type="hidden" name="order" value="<?php echo $question->order; ?>">
        <div class="col-md-6">
            <!-- <?php
            //$count = 1;
            //foreach ($results as $question) {
                ?> -->

                <?php echo "Question" . $page ?>
                <hr>
                <input type="hidden" name="qtype" value="<?php echo $question->qtype_id; ?>">
                <?php if ($question->qtype_id== 1) { ?>
                    <?php echo $question->question; ?><br>
                    <?php if (!empty($question->option1)) { ?>
                        <label class="form-check-label"><input class="form-check-input" 
                        <?php echo $answer && ($answer->answer == $question->option1) ? 'checked' : '' ?> type="radio" 
                        name="answer"  value="<?php echo $question->option1?>"><?php echo $question->option1; ?></label><br>
                    <?php } ?>
                    <?php if (!empty($question->option2)) { ?>
                        <label class="form-check-label"><input class="form-check-input" 
                        <?php echo $answer && ($answer->answer == $question->option2) ? 'checked' : '' ?> type="radio" 
                        name="answer"  value="<?php echo $question->option2 ?>"><?php echo $question->option2; ?></label><br>
                    <?php } ?>
                    <?php if (!empty($question->option3)) { ?>
                        <label class="form-check-label"><input class="form-check-input" <?php echo $answer && ($answer->answer == $question->option3) ? 'checked' : '' ?> type="radio" name="answer"  value="<?php echo $question->option3 ?>"><?php echo $question->option3; ?></label><br>
                    <?php } ?>
                    <?php if (!empty($question->option4)) { ?>
                        <label class="form-check-label"><input class="form-check-input" <?php echo $answer && ($answer->answer == $question->option4) ? 'checked' : '' ?> type="radio" name="answer"  value="<?php echo $question->option4 ?>"><?php echo $question->option4; ?></label><br>
                    <?php } ?>
                    <?php if (!empty($question->option5)) { ?>
                        <label class="form-check-label"><input class="form-check-input" <?php echo $answer && ($answer->answer == $question->option5) ? 'checked' : '' ?> type="radio" name="answer"  value="<?php echo $question->option5 ?>"><?php echo $question->option5; ?></label><br>
                    <?php } ?>
                    <?php if (!empty($question->option6)) { ?>
                        <label class="form-check-label"><input class="form-check-input" <?php echo $answer && ($answer->answer == $question->option6) ? 'checked' : '' ?> type="radio" name="answer"  value="<?php echo $question->option6 ?>"><?php echo $question->option6; ?></label><br>
                    <?php } ?>                   
                <?php } else if ($question->qtype_id == 2) { ?>
                        <?php echo $question->question; ?><br>
                    <label class="form-check-label"><input class="form-check-input" <?php echo $answer && ($answer->answer == "True") ? 'checked' : '' ?>  type="radio" name="answer"  value="<?php echo "True"; ?>"><?php echo "True"; ?></label><br>
                    <label class="form-check-label"><input class="form-check-input" <?php echo $answer && ($answer->answer == "False") ? 'checked' : '' ?>  type="radio" name="answer"  value="<?php echo "False"; ?>"><?php echo "False"; ?></label><br>
                
                <?php } else if ($question->qtype_id == 3) { ?>
                        <?php echo $question->question; ?><br>
                    <label><?php echo "Fill the blank here"; ?></label><br>
                    <input class="form-group" type="text" name="answer"  value="<?php echo $answer?$answer->answer:'';?>"><br>

                <?php } else if ($question->qtype_id == 4) { ?>
                    <?php echo $question->question . "?"; ?><br>
                    <label><?php echo "Your Answer"; ?></label><br>
                    <textarea class="form-control" rows="2" name="answer"> <?php echo $answer?$answer->answer:'';?></textarea><br>
<?php } ?>

        </div>
        <div class="row">
            <div class="text-left col-md-12 p-t-10">
                <a href="<?php echo base_url() . 'index.php?student/attempt_exam/'.$exam_id.'/'.($question->order-1); ?>" 
                class="fcbtn btn btn-danger btn-outline btn-1d">
<?php echo get_phrase('previous'); ?>
                </a>
            </div>
        </div>
    </div>
    <!--    <div class="col-md-6 text-right">
    <?php //echo $this->pagination->create_links();  ?>
        </div>-->
    <div class="row">
        <div class="text-right col-md-12 p-t-10">
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d">
                <?php echo get_phrase('submit'); ?>
            </button>
        </div>
    </div>  
<?php echo form_close(); ?>
</div>		


<script>
// Set the date we\'re counting down to
var t = new Date();
t.setSeconds(t.getSeconds() + <?php echo $total?>);
//twentyMinutesLater.setMinutes(twentyMinutesLater.getMinutes() + <?php //echo $total?>);
var countDownDate = t.getTime();
// countDownDate = new Date("Jan 5, 2018 15:37:25").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

    // Get todays date and time
    var now = new Date().getTime();
    
    // Find the distance between now an the count down date
    var distance = countDownDate - now;
    
    // Time calculations for days, hours, minutes and seconds
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    // Output the result in an element with id="demo"
    document.getElementById("demo").innerHTML = hours + ":"
    + minutes + ":" + seconds;
    
    // If the count down is over, write some text 
    if (distance < 0) {
        clearInterval(x);
        submit_exam_online() ;
        document.getElementById("demo").innerHTML = "EXPIRED";
    }
}, 500);

function submit_exam_online() {
    document.getElementById("online_exam").submit();
}
</script>