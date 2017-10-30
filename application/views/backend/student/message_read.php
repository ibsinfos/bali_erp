<?php
$user_id = $_SESSION["student_id"];
$user_type = $_SESSION["login_type"];
$user = $user_type . "-" . $user_id;
?> 
<!-- .chat-row -->
<div class="chat-main-box">
    <!-- .chat-right-panel -->
    <div class="chat-aside">
        <div class="chat-main-header">
            <div class="p-20 b-b">
                <h3 class="box-title"><b>Chat Message</b></h3> </div>
        </div>

        <div class="chat-box">
                <?php foreach ($message as $row): ?> 
                <ul class="chat-list slimscroll p-t-30">
    <?php if ($row['sender'] == $user) { ?>
                        <li class="odd">
                            <div class="chat-image">
                                <img src="<?php echo base_url()."uploads/".$row['image'];?>" class="img-circle" width="50px" height="50px"> 
                            </div>
                            <div class="chat-body">
                                <div class="chat-text">
                                    <strong><?php echo ucwords($row['name']); ?></strong>
                                    <p> <?php echo $row['message']; ?></p> 
                                    <b><?php echo date("d M, Y", $row['timestamp']); ?></b>

<a href="javascript: void(0);" class="img-circle pull-left ChatDel" onclick="confirm_modal('<?php echo base_url(); ?>index.php?student/message/delete/<?php echo $row['message_id'];?>/<?php echo $row['message_thread_code'];?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="right" data-original-title="Delete" title="Delete"><i class="fa fa-trash-o"></i></button></a>                                    
                                </div>
                            </div>
                        </li>
    <?php } else { ?>
                        <li>
                            <div class="chat-image"> 
                                <img src="<?php echo base_url()."uploads/".$row['image'];?>" class="img-circle" width="50px" height="50px"> 
                            </div>
                            <div class="chat-body">
                                <div class="chat-text">
                                    <strong><?php echo ucwords($row['name']); ?></strong>
                                    <p> <?php echo $row['message']; ?> </p> 
                                    <b><?php echo date("d M, Y", $row['timestamp']); ?></b>

                                </div>
                            </div>
                        </li>
                <?php } ?>
                </ul>
<?php endforeach; ?>
            <div class="chat-right-aside">
                <div class="row send-chat-box">
<?php echo form_open(base_url() . 'index.php?student/message/send_reply/' . $current_message_thread_code, array('enctype' => 'multipart/form-data')); ?>
                    <div class="col-sm-12">
                        <textarea class="form-control" placeholder="Type your message" name="message" id="sample_wysiwyg"></textarea>
                        <div class="custom-send">
                            <button class="fcbtn btn btn-danger btn-outline btn-1d" type="submit">Send</button>
                        </div>
                    </div>
<?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- .chat-right-panel -->
</div>
