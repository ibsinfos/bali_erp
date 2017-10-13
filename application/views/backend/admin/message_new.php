<div>
    <?php
    $school_admin = $all_participent['school_admin'];
    ?>
    <div class="white-box">
        <div class="box-title"><?php echo get_phrase('new_message'); ?></div>
        <section>
            <div class="sttabs tabs-style-flip">
                <nav>
                    <ul>
                        <li><a href="#student" class="sticon fa fa-user-circle"><span><?php echo get_phrase('admin'); ?></span></a></li>
                    </ul>
                </nav>
                <div class="content-wrap">
                    <section id="section-flip-1">
                        <?php echo form_open(base_url() . 'index.php?admin/message/send_new/', array('class' => 'form', 'enctype' => 'multipart/form-data')); ?>

                        <div class="form-group">
                            <label><?php echo get_phrase('recipient'); ?>:</label>
                            <input type="hidden" name="reciever[]" id="reciever" value="">
                            <select class="selectpicker" multiple data-actions-box="true" data-live-search="true" onchange="get_value_student()" id="student_reciever" name="student_reciever[]" >
                                <?php foreach ($school_admin as $value) { ?>
                                    <option value="school_admin-<?php echo $value['school_admin_id']; ?>"><?php echo $value['first_name'].' '.$value['last_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>


                        <div class="form-group">
                            <textarea class="form-control" rows="20" placeholder="Type your message" name="message" placeholder="<?php echo get_phrase('write_your_message'); ?>"id="sample_wysiwyg"></textarea>
                        </div>    
                        <div class="custom-send m-t-20 text-right">
                            <button class="btn btn-danger btn-rounded" type="submit"> <?php echo get_phrase('send'); ?></button>
                        </div>
                        <?php echo form_close(); ?>
                    </section>
                    
                </div>
                <!-- /content -->
            </div>
            <!-- /tabs -->
        </section>
    </div>
</div>


<script type="text/javascript">
    function get_value_student() {
        var student_id = [];
        $('#student_reciever :selected').each(function (i, selected) {
            student_id[i] = $(selected).val();
        });
        $('#reciever').val(student_id);
    }
    function get_value_parent() {
        var parent_id = [];
        $('#parent_reciever :selected').each(function (i, selected) {
            parent_id[i] = $(selected).val();
        });
        $('#reciever2').val(parent_id);
    }
    function get_value_teacher() {
        var teacher_id = [];
        $('#teacher_reciever :selected').each(function (i, selected) {
            teacher_id[i] = $(selected).val();
        });
        $('#reciever1').val(teacher_id);
    }
</script>

