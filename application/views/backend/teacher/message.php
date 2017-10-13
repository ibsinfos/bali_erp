<div id="PrivateMsgOuter">
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
            <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('dashboard'); ?></a></li>

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

<?php 
$SelectedUserType = $SelectedUserId = '';
if(count($current_user_threads)){
    foreach($current_user_threads as $datum){
        if($datum['message_thread_code'] == $current_thread){
            $CurrentReciever = $datum['reciever'];
            $ExpCurrentReciever = explode('-', $CurrentReciever);
            $SelectedUserType = $ExpCurrentReciever[0];
            $SelectedUserId = $ExpCurrentReciever[1];
        }
    }
}?>

<div class="row">

    <div class="col-xs-12 col-md-4 hidden-xs">
        <div class="white-box">
        <div class="mail-sidebar-row" data-step="5" data-intro="<?php echo get_phrase('On click of new message,write new message page will appear');?>" data-position='top'>
            <a href="<?php echo base_url(); ?>index.php?teacher/message/message_new" class="btn btn-danger btn-icon btn-block">
                <i class="sticon fa fa-pencil-square-o"></i>
                <?php echo get_phrase('new_message'); ?>

            </a>
        </div>
        <section>
            <div class="sttabs tabs-style-flip" data-step="6" data-intro="<?php echo get_phrase('When you select tab, displays the list of message contacts');?>" data-position='top'>
                <nav>
                    <ul>
                        <li id="student"><a href="#section-flip-1" class="sticon fa fa-user"><span><?php echo get_phrase('student'); ?></span></a></li>
                        <li id="teacher"><a href="#section-flip-2" class="sticon fa fa-user"><span><?php echo get_phrase('teacher'); ?></span></a></li>
                        <li id="parent"><a href="#section-flip-3" class="sticon fa fa-user"><span><?php echo get_phrase('parent'); ?></span></a></li>
                        <li id="school_admin"><a href="#section-flip-4" class="sticon fa fa-user"><span><?php echo get_phrase('admin'); ?></span></a></li>
                    </ul>
                </nav>
                <div class="content-wrap" data-step="7" data-intro="<?php echo get_phrase('When you select particular contact, displays the list of conversation which you have made by that particular person');?>" data-position='right'>
                    <section id="section-flip-1">     
                        <!-- .chat-left-panel -->
                        <div class="chat-left-inner">

                            <ul class="chatonline style-none list-unstyled">
                                <?php //pre($current_user_threads);
                                foreach ($current_user_threads as $row):
                                    $user_to_show = array();
                                    // defining the user to show
                                    if ($row['sender'] == $current_user) {
                                    $user_to_show = explode('-', $row['reciever']); }
                                    elseif ($row['reciever'] == $current_user){
                                    $user_to_show = explode('-', $row['sender']);}
                                    if(!empty($user_to_show)) {
                                        $user_to_show_type = $user_to_show[0];
                                        $user_to_show_id = $user_to_show[1];
                                    } else {
                                        $user_to_show_type = '';
                                        $user_to_show_id = '';
                                    }
                                    if ($user_to_show_type == "student") {
                                        $unread_message_number = $row['unread_msg'];
                                        ?>
                                        <li>
<a href="<?php echo base_url(); ?>index.php?teacher/message/message_read/<?php echo $row['message_thread_code']; ?>" style="padding:12px;" class="<?php if(($SelectedUserType == 'student') && ($SelectedUserId == $row['student_id'])){ echo 'SelectedUser'; }?>">
                                                <?php
                                                if (array_key_exists('name',$row)) {
                                                        echo "<span class='label label-rouded label-purple text-white'>" . $row['name'] . "</span>";
                                                    } else {
                                                        echo "<span class='label label-rouded label-purple text-white'>" . $row['father_name'] . "</span>";
                                                    }
//                                                
                                                ?>

                                                <?php if ($unread_message_number > 0): ?>
                                                    <span class="badge badge-secondary pull-right">
                                                        <?php echo $unread_message_number; ?>
                                                    </span>
                                                <?php endif; ?>
                                            </a>
                                        </li>
                                    <?php } endforeach; ?>


                            </ul>
                        </div>
                    </section>
                    <section id="section-flip-2">
                        <!-- .chat-left-panel -->
                        <div class="chat-left-inner">

                            <ul class="chatonline style-none list-unstyled">
                                <?php
                                $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');

                                foreach ($current_user_threads as $row):
                                    $user_to_show = array();
                                    // defining the user to show
                                    if ($row['sender'] == $current_user) {
                                    $user_to_show = explode('-', $row['reciever']); }
                                    elseif ($row['reciever'] == $current_user){
                                    $user_to_show = explode('-', $row['sender']);}
                                    if(!empty($user_to_show)) {
                                        $user_to_show_type = $user_to_show[0];
                                        $user_to_show_id = $user_to_show[1];
                                    } else {
                                        $user_to_show_type = '';
                                        $user_to_show_id = '';
                                    }
                                    if ($user_to_show_type == "teacher") {
                                        $unread_message_number = $row['unread_msg'];
                                        ?>
                                        <li>
<a href="<?php echo base_url(); ?>index.php?teacher/message/message_read/<?php echo $row['message_thread_code']; ?>" style="padding:12px;" class="<?php if(($SelectedUserType == 'teacher') && ($SelectedUserId == $row['teacher_id'])){ echo 'SelectedUser'; }?>">
                                                <?php
                                                if (array_key_exists('name',$row)) {
                                                        echo "<span class='label label-rouded label-purple text-white'>" . $row['name'] . "</span>";
                                                    } else {
                                                        echo "<span class='label label-rouded label-purple text-white'>" . $row['father_name'] . "</span>";
                                                    }
//                                                
                                                ?>

                                                <?php if ($unread_message_number > 0): ?>
                                                    <span class="badge badge-secondary pull-right">
                                                        <?php echo $unread_message_number; ?>
                                                    </span>
                                                <?php endif; ?>
                                            </a>
                                        </li>
                                    <?php } endforeach; ?>


                            </ul>
                        </div>
                    </section>
                    <section id="section-flip-3">
                        <!-- .chat-left-panel -->
                        <div class="chat-left-inner">

                            <ul class="chatonline style-none list-unstyled">
                                <?php
                                $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');

                                foreach ($current_user_threads as $row):
                                    $user_to_show = array();
                                    // defining the user to show
                                    if ($row['sender'] == $current_user) {
                                    $user_to_show = explode('-', $row['reciever']); }
                                    elseif ($row['reciever'] == $current_user){
                                    $user_to_show = explode('-', $row['sender']);}
                                    if(!empty($user_to_show)) {
                                        $user_to_show_type = $user_to_show[0];
                                        $user_to_show_id = $user_to_show[1];
                                    } else {
                                        $user_to_show_type = '';
                                        $user_to_show_id = '';
                                    }
                                    if ($user_to_show_type == "parent") {
                                        $unread_message_number = $row['unread_msg'];
                                        ?>
                                        <li>
<a href="<?php echo base_url(); ?>index.php?teacher/message/message_read/<?php echo $row['message_thread_code']; ?>" style="padding:12px;" class="<?php if(($SelectedUserType == 'parent') && ($SelectedUserId == $row['parent_id'])){ echo 'SelectedUser'; }?>">
<?php
                                                if (array_key_exists('name',$row)) {
                                                        echo "<span class='label label-rouded label-purple text-white'>" . $row['name'] . "</span>";
                                                    } else {
                                                        echo "<span class='label label-rouded label-purple text-white'>" . $row['father_name'] . "</span>";
                                                    }
                                                ?>
                                                

                                                <?php if ($unread_message_number > 0): ?>
                                                    <span class="badge badge-secondary pull-right">
                                                        <?php echo $unread_message_number; ?>
                                                    </span>
                                                <?php endif; ?>
                                            </a>
                                        </li>
                                    <?php } endforeach; ?>


                            </ul>
                        </div>
                    </section>
                    
                    <section id="section-flip-4">
                        <!-- .chat-left-panel -->
                        <div class="chat-left-inner">

                            <ul class="chatonline style-none list-unstyled">
                                <?php
                                $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
                                
                                foreach ($current_user_threads as $row):

                                    $type = '' ;                                  
                                    // defining the user to show
                                    if ($row['sender'] == $current_user) {
                                        $type = explode('-', $row['reciever']); 
                                    }else if($row['reciever'] == $current_user){
                                        $type = explode('-', $row['sender']);
                                    }

                                    if(isset($type[0])) {
                                        $user_to_show_type = $type[0];
                                        $user_to_show_id = $type[1];
                                    } else {
                                        $user_to_show_type = '';
                                        $user_to_show_id = '';
                                    }

                                    if ($user_to_show_type == "school_admin") {
                                        $unread_message_number = $row['unread_msg'];
                                        ?>
                                        <li>
<a href="<?php echo base_url(); ?>index.php?teacher/message/message_read/<?php echo $row['message_thread_code']; ?>" style="padding:12px;" class="<?php if(($SelectedUserType == 'school_admin') && ($SelectedUserId == $row['school_admin_id'])){ echo 'SelectedUser'; }?>" >
<?php
                                               if (array_key_exists('name',$row)) {
                                                        echo "<span class='label label-rouded label-purple text-white'>" . ucfirst($row['name']) . "</span>";
                                                    } else {
                                                        echo "<span class='label label-rouded label-purple text-white'>" . ucfirst(@$row['father_name']) . "</span>";
                                                    }
//                                                
                                                ?>
                                                <?php if ($unread_message_number > 0): ?>
                                                    <span class="badge badge-secondary pull-right">
                                                        <?php echo $unread_message_number; ?>
                                                    </span>
                                                <?php endif; ?>
                                            </a>
                                        </li>
                                    <?php } endforeach; ?>


                            </ul>
                        </div>
                    </section>
                </div>
                <!-- /content -->
            </div>
            <!-- /tabs -->
        </section>

    </div>
</div>


    <div class="col-md-12 visible-xs">
        <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_message_list/');">
            <button class="tst1 btn btn-info m-b-20">
                <?php echo get_phrase('contact_list'); ?>
            </button>
        </a> 
    </div>
    <!-- Mail Body -->
    <div class="col-xs-12 col-md-8 mail-body m-b-30">
        <!-- message page body -->
        <?php include $message_inner_page_name . '.php'; ?>
    </div>

</div>

</div>

<script type="text/javascript">
    $(document).ready(function () {
        var SelectedUserType = "<?php echo $SelectedUserType; ?>";
        if(SelectedUserType != ''){
            $('#'+SelectedUserType).click();
        }

        var segment = "<?php echo $this->uri->segment(3);?>"; 
        var current_thread = "<?php echo $current_thread;?>";

        if((segment=='message_read') && (current_thread!='')){
            setInterval(ajaxCallUnreadMessage, 10000);
            
            function ajaxCallUnreadMessage() {
                if((segment=='message_read') && (current_thread!='')){
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url().'index.php?teacher/message/message_read/'.$current_thread.'/ajax' ?>",
                        success: function (msg) {        
                            if (msg != '') {
                                $('#PrivateMsgOuter').empty();                        
                                $('#PrivateMsgOuter').html(msg);
                                
                                
                                [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
                                    new CBPFWTabs(el);
                                });

                                $('.chatonline').slimScroll({
                                    height: '100%',
                                    position: 'right',
                                    size: "0px",
                                    color: '#dcdcdc'
                                });

                            }

                            if(SelectedUserType != ''){
                                $('#'+SelectedUserType).click();
                            }
                        }
                    });
                }
            }
        }
    });
</script>
