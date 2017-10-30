<!--Tabs style-->
<div>
    <?php
    $students = $all_participent['student'];
    $parents = $all_participent['parent'];
    $teachers = $all_participent['teacher'];
    ?>
    <div class="white-box">
        <div class="box-title"><?php echo get_phrase('new_message'); ?></div>
        <section>
            <div class="sttabs tabs-style-flip">
                <nav>
                    <ul>
                        <li><a href="#student" class="sticon fa fa-user-circle"><span><?php echo get_phrase('student'); ?></span></a></li>
                        <li><a href="#teacher" class="sticon fa fa-user-circle"><span><?php echo get_phrase('teacher'); ?></span></a></li>
                        <li><a href="#parent" class="sticon fa fa-user-circle"><span><?php echo get_phrase('parent'); ?></span></a></li>
                    </ul>
                </nav>
                <div class="content-wrap">
                    <section id="section-flip-1">
                        <?php echo form_open(base_url() . 'index.php?school_admin/message/send_new/', array('class' => 'form', 'enctype' => 'multipart/form-data')); ?>

                        <div class="form-group">
                            <label><?php echo get_phrase('recipient'); ?>:</label>
                            <input type="hidden" name="reciever[]" id="reciever" value="">
                <select class="selectpicker" data-style="form-control" multiple data-actions-box="true" data-live-search="true" onchange="get_value_student()" id="student_reciever" name="student_reciever[]" required="required">
                                <?php foreach ($students as $value) { ?>
                                    <option value="student-<?php echo $value['student_id']; ?>"><?php echo ucwords($value['name']." ".$value['mname']." ".$value['lname']); ?></option>
                                <?php } ?>
                            </select>
                        </div>


                        <div class="form-group">
<textarea class="form-control" rows="20" placeholder="Type your message" name="message" placeholder="<?php echo get_phrase('write_your_message'); ?>" id="sample_wysiwyg" required="required"></textarea>
                        </div>    
                        <div class="custom-send m-t-20 text-right">
                            <button class="fcbtn btn btn-danger btn-outline btn-1d" type="submit"> <?php echo get_phrase('send'); ?></button>
                        </div>
                        <?php echo form_close(); ?>
                    </section>

                    <section id="section-flip-3">
                        <?php echo form_open(base_url() . 'index.php?school_admin/message/send_new/', array('class' => 'form', 'enctype' => 'multipart/form-data')); ?>
                        <div class="form-group">
                            <label><?php echo get_phrase('recipient'); ?>:</label>
                            <input type="hidden" name="reciever[]" id="reciever1" value="">
                <select class="selectpicker" data-style="form-control" multiple data-actions-box="true" data-live-search="true" onchange="get_value_teacher()" id="teacher_reciever" name="teacher_reciever[]" required="required">
                                <?php foreach ($teachers as $value) { ?>
                                    <option value="teacher-<?php echo $value['teacher_id']; ?>"><?php echo ucwords($value['name']." ".$value['middle_name']." ".$value['last_name']); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
<textarea class="form-control" rows="20" placeholder="Type your message" name="message" placeholder="<?php echo get_phrase('write_your_message'); ?>" id="sample_wysiwyg" required="required"></textarea>
                        </div>
                        <div class="custom-send m-t-20 text-right">
                            <button class="fcbtn btn btn-danger btn-outline btn-1d" type="submit"> <?php echo get_phrase('send'); ?></button>
                        </div>
                        <?php echo form_close(); ?>    
                    </section>

                    <section id="section-flip-2">
                        <?php echo form_open(base_url() . 'index.php?school_admin/message/send_new/', array('class' => 'form', 'enctype' => 'multipart/form-data')); ?>
                        <div class="form-group">
                            <label><?php echo get_phrase('recipient'); ?>:</label>
                            <input type="hidden" name="reciever[]" id="reciever2" value="">
<select class="selectpicker" data-style="form-control" multiple data-actions-box="true" data-live-search="true" onchange="get_value_parent()" id="parent_reciever" name="parent_reciever[]" required="required">
                                <?php foreach ($parents as $value) { ?>
                                    <option value="parent-<?php echo $value['parent_id']; ?>"><?php echo ucwords($value['father_name']." ".$value['father_mname']." ".$value['father_lname']); ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
<textarea class="form-control" rows="20" placeholder="Type your message" name="message" placeholder="<?php echo get_phrase('write_your_message'); ?>" id="sample_wysiwyg" required="required"></textarea>
                        </div>
                        <div class="custom-send m-t-20 text-right">
                            <button class="fcbtn btn btn-danger btn-outline btn-1d" type="submit"> <?php echo get_phrase('send'); ?></button>
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

