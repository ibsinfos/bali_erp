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
</div>

<?php 
$SelectedUserType = $SelectedUserId = '';

if(count($message_threads)){
    foreach($message_threads as $datum){
        if($datum['message_thread_code'] == $current_thread){
            $SelectedUserType = $datum['user_to_show_type'];
            $SelectedUserId = $datum['user_to_show_id'];
        }
    }
}?>


<div class="row">
   
    <div class=" col-xs-12 col-md-4 hidden-xs p-l-20">
         <div class="white-box">
        <div class="mail-sidebar-row" data-step="5" data-intro="<?php echo get_phrase('Once you click on new message, write new message page will appear.');?>" data-position='top'>
            <a href="<?php echo base_url(); ?>index.php?school_admin/message/message_new" class="btn btn-danger btn-icon btn-block">
                 <i class="sticon fa fa-pencil-square-o"></i>
                <?php echo get_phrase('new_message'); ?>
               
            </a>
        </div>
        <section>
            <div class="sttabs tabs-style-flip" data-step="6" data-intro="<?php echo get_phrase('When you select tab, displays the list of message contacts.');?>" data-position='top'>
                <nav>
                    <ul>
                        <li id="student"><a href="#section-flip-5" class="sticon fa fa-user"><span><?php echo get_phrase('student'); ?></span></a></li>
                        <li id="teacher"><a href="#section-flip-4" class="sticon fa fa-user"><span><?php echo get_phrase('teacher'); ?></span></a></li>
                        <li id="parent"><a href="#section-flip-2" class="sticon fa fa-user"><span><?php echo get_phrase('parent'); ?></span></a></li>
                    </ul>
                </nav>
                <div class="content-wrap" data-step="7" data-intro="<?php echo get_phrase('When you select particular contact, displays the list of conversation which you have made by that particular person.');?>" data-position='right'>
                    <section id="section-flip-1">     
                        <!-- .chat-left-panel -->
                        <div class="chat-left-inner">
                           <ul class="chatonline style-none list-unstyled">
                                <?php   
                                 foreach ($message_threads as $row): 
                                    if ($row['user_to_show_type'] == "student") {
                                        $unread_message_number = $row['unread_message_number_student'];//$this->crud_model->count_unread_message_of_thread($row['message_thread_code']);
                                        ?>
                                        <li>
<a href="<?php echo base_url(); ?>index.php?school_admin/message/message_read/<?php echo $row['message_thread_code']; ?>" style="padding:12px;" class="<?php if(($SelectedUserType == 'student') && ($SelectedUserId == $row['nameDataArr_student']->student_id)){ echo 'SelectedUser'; }?>">
                                                <?php
                                                $nameDataArr = $row['nameDataArr_student'];
                                                if (!empty($nameDataArr)) {
                                                    if (property_exists($nameDataArr, 'name')) {
                                                        echo "<span class='label label-rouded label-purple text-white'>" . $nameDataArr->name . "</span>";
                                                    } else {
                                                        echo "<span class='label label-rouded label-purple text-white'>" . $nameDataArr->father_name . "</span>";
                                                    }
                                                }
                                                ?>
                                                       <?php if ($unread_message_number > 0): ?>
                                                        <span class="badge badge-secondary pull-right">
                                                        <?php echo $unread_message_number; ?>
                                                    </span>
                                                <?php endif; ?>
                                            </a>
                                        </li>
                                    <?php } 
                                endforeach; ?>
                            </ul>
                        </div>
                    </section>
                    <section id="section-flip-2">
                        <!-- .chat-left-panel -->
                        <div class="chat-left-inner">

                            <ul class="chatonline style-none list-unstyled">
                                <?php //echo "Jesus";  pre($message_threads);
                                
                                foreach ($message_threads as $row):

                                   
                                    if ($row['user_to_show_type'] == "teacher") {
                                        $unread_message_number = $row['unread_message_number_teacher'];//$this->crud_model->count_unread_message_of_thread($row['message_thread_code']);
                                        ?>
                                        <li>
<a href="<?php echo base_url(); ?>index.php?school_admin/message/message_read/<?php echo $row['message_thread_code']; ?>" style="padding:12px;" class="<?php if(($SelectedUserType == 'teacher') && ($SelectedUserId == $row['nameDataArr_teacher']->teacher_id)){ echo 'SelectedUser'; }?>">


                                                <?php
                                                $nameDataArr = $row['nameDataArr_teacher'];//$this->db->get_where($user_to_show_type, array($user_to_show_type . '_id' => $user_to_show_id))->row();
                                                if (!empty($nameDataArr)) {
                                                    if (property_exists($nameDataArr, 'name')) {
                                                        echo "<span class='label label-rouded label-purple text-white'>" . $nameDataArr->name . "</span>";
                                                    } else {
                                                        echo "<span class='label label-rouded label-purple text-white'>" . $nameDataArr->father_name . "</span>";
                                                    }
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
                    <section id="section-flip-3">
                        <!-- .chat-left-panel -->
                        <div class="chat-left-inner">

                            <ul class="chatonline style-none list-unstyled">
                                <?php 
                                foreach ($message_threads as $row):
                                    if ($row['user_to_show_type'] == "parent") {
                                        $unread_message_number = $row['unread_message_number_parent'];//$this->crud_model->count_unread_message_of_thread($row['message_thread_code']);
                                        ?>
                                        <li>
<a href="<?php echo base_url(); ?>index.php?school_admin/message/message_read/<?php echo $row['message_thread_code']; ?>" style="padding:12px;" class="<?php if(($SelectedUserType == 'parent') && ($SelectedUserId == $row['nameDataArr_parent']->parent_id)){ echo 'SelectedUser'; }?>">


                                                <?php
                                                $nameDataArr = $row['nameDataArr_parent'];//$this->db->get_where($user_to_show_type, array($user_to_show_type . '_id' => $user_to_show_id))->row();
                                                if (!empty($nameDataArr)) {
                                                    if (property_exists($nameDataArr, 'name')) {
                                                        echo "<span class='label label-rouded label-purple text-white'>" . $nameDataArr->name . "</span>";
                                                    } else {
                                                        echo "<span class='label label-rouded label-purple text-white'>" . $nameDataArr->father_name . "</span>";
                                                    }
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

                </div>
                <!-- /content -->
            </div>
            <!-- /tabs -->
        </section>

    </div>
    </div>

<div class=" col-md-12 visible-xs">
  <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_message_list/');">
            <button class="tst1 btn btn-info m-b-20">
                <?php echo get_phrase('contact_list'); ?>
            </button>
        </a> 
</div>
<!-- Mail Body -->
<div class="col-xs-12 col-md-8 m-b-30">
        <!-- message page body -->
<?php include $message_inner_page_name . '.php'; ?>
    </div>

</div>