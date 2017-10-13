<a href="<?php echo base_url(); ?>index.php?student/message/message_new" class="btn btn-danger btn-icon btn-block">
            <i class="sticon fa fa-pencil-square-o"></i>
            <?php echo get_phrase('new_message'); ?>

        </a>
<section>
    <div class="sttabs tabs-style-flip" data-step="6" data-intro="<?php echo get_phrase('When you select tab, displays the list of message contacts.');?>" data-position='top'>
        <nav>
            <ul>
                <li><a href="#section-flip-1" class="sticon fa fa-user-circle"><span><?php echo get_phrase('teacher'); ?></span></a></li> 
                <li><a href="#section-flip-2" class="sticon fa fa-user-circle"><span><?php echo get_phrase('admin'); ?></span></a></li>

            </ul>
        </nav>
        <div class="content-wrap">

            <section id="section-flip-1">
                <!-- .chat-left-panel -->
                <div class="chat-left-inner" data-step="7" data-intro="<?php echo get_phrase('When you select particular contact, displays the list of conversation which you have made.');?>" data-position='top'>

                    <ul class="chatonline style-none list-unstyled">
                        <?php
                        $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
                        foreach ($message_threads as $row):

                            // defining the user to show
                            if ($row['sender'] == $current_user)
                                $user_to_show = explode('-', $row['reciever']);
                            if ($row['reciever'] == $current_user)
                                $user_to_show = explode('-', $row['sender']);

                            $user_to_show_type = $user_to_show[0];
                            $user_to_show_id = $user_to_show[1];
                            if ($user_to_show_type == "teacher") {
                                $unread_message_number = $this->crud_model->count_unread_message_of_thread($row['message_thread_code']);
                                ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php?student/message/message_read/<?php echo $row['message_thread_code']; ?>" style="padding:12px;">
                                        <?php
                                        $nameDataArr= get_data_generic_fun($user_to_show_type,'*',array($user_to_show_type . '_id' => $user_to_show_id));
                                        if (!empty($nameDataArr)) {
                                            $nameDataArr=$nameDataArr[0];
                                            if (property_exists($nameDataArr, 'name')) {
                                                echo "<span>" . $nameDataArr->name . "</span>";
                                            } else {
                                                echo "<span>" . $nameDataArr->father_name . "</span>";
                                            }
                                        }
                                        ?>

                                        <span class="label label-rouded label-info pull-right text-white"><?php echo ucfirst($user_to_show_type); ?></span>

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
                        foreach ($message_threads as $row):

                            // defining the user to show
                            if ($row['sender'] == $current_user)
                                $user_to_show = explode('-', $row['reciever']);
                            if ($row['reciever'] == $current_user)
                                $user_to_show = explode('-', $row['sender']);

                            $user_to_show_type = $user_to_show[0];
                            $user_to_show_id = $user_to_show[1];
                            if ($user_to_show_type == "admin") {
                                $unread_message_number = $this->crud_model->count_unread_message_of_thread($row['message_thread_code']);
                                ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php?student/message/message_read/<?php echo $row['message_thread_code']; ?>" style="padding:12px;">


                                        <?php
                                        $nameDataArr= get_data_generic_fun($user_to_show_type,'*',array($user_to_show_type . '_id' => $user_to_show_id));
                                        if (!empty($nameDataArr)) {
                                            $nameDataArr=$nameDataArr[0];
                                            if (property_exists($nameDataArr, 'name')) {
                                                echo "<span>" . $nameDataArr->name . "</span>";
                                            } else {
                                                echo "<span>" . $nameDataArr->father_name . "</span>";
                                            }
                                        }
                                        ?>

                                        <span class="label label-rouded label-purple pull-right text-white"><?php echo ucfirst($user_to_show_type); ?></span>

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
<!--For tabs -->
<script src="<?php echo base_url(); ?>assets/js/cbpFWTabs.js"></script>
<script type="text/javascript">
    (function () {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
            new CBPFWTabs(el);
        });
    })();

</script>
