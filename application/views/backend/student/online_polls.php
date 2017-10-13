<div class="row bg-title"> 
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?student/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
</div>

<?php $count = 0;  if(!empty($online_polls)){ $count = 0;  
    foreach ($online_polls as $row) { if(isset($row['poll_id'])){ $count++;?>

<div class="panel panel-danger block6" data-step="5" data-position="top" data-intro="<?php echo get_phrase('Select one of the given choice and click on the Submit Poll button to give your vote..');?>">
<div class="panel-heading">Polling Topic : <?php echo $row['poll_title'];?> : <?php echo $row['post_date'];?></div>
<div class="panel-wrapper collapse in" aria-expanded="true">
    <div class="panel-body col-md-offset-0">
        <p><strong><?php echo $row['poll_descreption']; ?></strong></p>
        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
<?php if(!empty($row['answer_det'])){ $answ_count = 1; foreach($row['answer_det'] as $answer){ ?>
            <div class="radio radio-primary col-md-offset-0">
                <input type="radio" onclick="enableButton(<?php echo $row['poll_id'];?>,<?php echo $answer['poll_answer_id'];?>)" name="answer_<?php echo $row['poll_id'];?>" id="answer_<?php echo $answer['poll_answer_id'];?>" value="<?php echo $answer['poll_answer_id'];?>" >
                <label for="radio3"><?php echo $answer['answer'];?></label>
            </div>

            <?php } } ?>
        </div>

        <div class="col-md-12 text-right no-padding">                    
            <button disabled="true" value="" onclick="submitPoll(<?php echo $row['poll_id'];?>)" class="poll_submit fcbtn btn btn-danger btn-outline btn-1d" id="pollsubmit_<?php echo $row['poll_id'];?>" >Submit Poll</button>
        </div>
    </div>
</div>
</div>

<?php  } } }
if($count == 0) {  ?>
<div class="panel panel-danger block6" data-step="5" data-position="top" data-intro="<?php echo get_phrase('Select one of the given choice and click on the Submit Poll button to give your vote..');?>">
    <div class="panel-heading">No polls available</div>
</div>            
<?php } ?>

<script>
    
    function enableButton (poll_id,answer_id) {
        $('#pollsubmit_'+poll_id).prop("disabled", false);
        $('#pollsubmit_'+poll_id).prop("value", answer_id);
    }
    
    function submitPoll(poll_id) {
        var answer_id           =   $('#pollsubmit_'+poll_id).val(); 
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?ajax_controller/poll_student/',
            dataType    : 'json',
            type        : 'POST',
            data        : {poll_id : poll_id,answer_id : answer_id},
            success: function(response) {
                window.location.href    =   '<?php echo base_url(); ?>index.php?student/online_polls/polled';
            },
            error: function(response) {
                //alert("error");
            }
        });
    }
</script>