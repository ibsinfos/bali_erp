<a href="<?php echo base_url(); ?>index.php?school_admin/message/message_new" class="btn btn-danger btn-icon btn-block">
    <i class="sticon fa fa-pencil-square-o"></i>
    <?php echo get_phrase('new_message'); ?>

</a>
</div>
<section>
    <div class="sttabs tabs-style-flip">
        <nav>
            <ul>
                <li><a href="#section-flip-5" class="sticon fa fa-user"><span><?php echo get_phrase('student'); ?></span></a></li>
                <li><a href="#section-flip-4" class="sticon fa fa-user"><span><?php echo get_phrase('teacher'); ?></span></a></li>
                <li><a href="#section-flip-2" class="sticon fa fa-user"><span><?php echo get_phrase('parent'); ?></span></a></li>

            </ul>
        </nav>
        <div class="content-wrap">
            <section id="section-flip-1">     
                <!-- .chat-left-panel -->
                <div class="chat-left-inner">

                    <ul class="chatonline style-none list-unstyled">
                        <?php
                       $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
//
//                        $this->db->where('sender', $current_user);
//                        $this->db->or_where('reciever', $current_user);
//                        $message_threads = $this->db->get('message_thread')->result_array();
                        foreach ($message_threads as $row):

                            // defining the user to show
                            if ($row['sender'] == $current_user)
                                $user_to_show = explode('-', $row['reciever']);
                            if ($row['reciever'] == $current_user)
                                $user_to_show = explode('-', $row['sender']);

                            $user_to_show_type = $user_to_show[0];
                            $user_to_show_id = $user_to_show[1];
                            if ($user_to_show_type == "student") {
                                //$unread_message_number = $this->crud_model->count_unread_message_of_thread($row['message_thread_code']);
                                ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php?school_admin/message/message_read/<?php echo $row['message_thread_code']; ?>" style="padding:12px;">


                                        <?php
                                        //$nameDataArr = $this->db->get_where($user_to_show_type, array($user_to_show_type . '_id' => $user_to_show_id))->row();
                                        if (!empty($row['nameDataArr'])) {
                                            if (property_exists($row['nameDataArr'], 'name')) {
                                                echo "<span>" . $row['nameDataArr']->name . "</span>";
                                            } else {
                                                echo "<span>" . $row['nameDataArr']->father_name . "</span>";
                                            }
                                        }
                                        ?>

                                        <span class="label label-rouded label-warning pull-right text-white"><?php echo ucfirst($user_to_show_type); ?></span>

                                        <?php if (isset($row['unread_message_number']) && $row['unread_message_number'] > 0): ?>
                                            <span class="badge badge-secondary pull-right">
                                                <?php echo $row['unread_message_number']; ?>
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
//
//                        $this->db->where('sender', $current_user);
//                        $this->db->or_where('reciever', $current_user);
//                        $message_threads = $this->db->get('message_thread')->result_array();
                         
                        foreach ($message_threads as $row):
                           // defining the user to show
                            if ($row['sender'] == $current_user)
                                $user_to_show = explode('-', $row['reciever']);
                            if ($row['reciever'] == $current_user)
                                $user_to_show = explode('-', $row['sender']);

                            $user_to_show_type = $user_to_show[0];
                            $user_to_show_id = $user_to_show[1];
                            if ($user_to_show_type == "teacher") { 
                                //$unread_message_number = $this->crud_model->count_unread_message_of_thread($row['message_thread_code']);
                                ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php?school_admin/message/message_read/<?php echo $row['message_thread_code']; ?>" style="padding:12px;">


                                        <?php
                                       // $nameDataArr = $this->db->get_where($user_to_show_type, array($user_to_show_type . '_id' => $user_to_show_id))->row();
                                        if (!empty($row['nameDataArr'])) {
                                            if (property_exists($row['nameDataArr'], 'name')) {
                                                echo "<span>" . $row['nameDataArr']->name . "</span>";
                                            } else {
                                                echo "<span>" . $row['nameDataArr']->father_name . "</span>";
                                            }
                                        }
                                        ?>

                                        <span class="label label-rouded label-info pull-right text-white"><?php echo ucfirst($user_to_show_type); ?></span>

                                        <?php if (isset($row['unread_message_number']) && ($row['unread_message_number'] > 0)): ?>
                                            <span class="badge badge-secondary pull-right">
                                                <?php echo $row['unread_message_number']; ?>
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

                        //$this->db->where('sender', $current_user);
                        //$this->db->or_where('reciever', $current_user);
                       // $message_threads = $this->db->get('message_thread')->result_array();
                        foreach ($message_threads as $row):

                            // defining the user to show
                            if ($row['sender'] == $current_user)
                                $user_to_show = explode('-', $row['reciever']);
                            if ($row['reciever'] == $current_user)
                                $user_to_show = explode('-', $row['sender']);

                            $user_to_show_type = $user_to_show[0];
                            $user_to_show_id = $user_to_show[1];
                            if ($user_to_show_type == "parent") {
                                //$unread_message_number = $this->crud_model->count_unread_message_of_thread($row['message_thread_code']);
                                ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php?school_admin/message/message_read/<?php echo $row['message_thread_code']; ?>" style="padding:12px;">


                                        <?php
                                        //$nameDataArr = $this->db->get_where($user_to_show_type, array($user_to_show_type . '_id' => $user_to_show_id))->row();
                                        if (!empty($row['nameDataArr'])) {
                                            if (property_exists($row['nameDataArr'], 'name')) {
                                                echo "<span>" . $row['nameDataArr']->name . "</span>";
                                            } else {
                                                echo "<span>" . $row['nameDataArr']->father_name . "</span>";
                                            }
                                        }
                                        ?>

                                        <span class="label label-rouded label-success pull-right text-white"><?php echo ucfirst($user_to_show_type); ?></span>

                                        <?php if (isset($row['unread_message_number']) && $row['unread_message_number'] > 0): ?>
                                            <span class="badge badge-secondary pull-right">
                                                <?php echo $row['unread_message_number']; ?>
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

