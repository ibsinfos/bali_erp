<div>
    <?php
    $admin = $all_participent['admin'];
    ?>
    <div class="white-box">
        <div class="box-title"><?php echo get_phrase('new_message'); ?></div>
        <section>
            <div class="sttabs tabs-style-flip">
                <nav>
                    <ul>
                        <li><a href="#admin" class="sticon fa fa-user-circle"><span><?php echo get_phrase('admin'); ?></span></a></li>
                    </ul>
                </nav>
                <div class="content-wrap">
                    <section id="section-flip-1">
                        <?php echo form_open(base_url() . 'index.php?school_admin/school_admin_message/send_new/', array('class' => 'form', 'enctype' => 'multipart/form-data')); ?>

                        <div class="form-group">
                            <label><?php echo get_phrase('recipient'); ?>:</label>
                            <input type="hidden" name="reciever[]" id="reciever" value="">
                            <select class="selectpicker" multiple data-actions-box="true" data-live-search="true" onchange="get_value_student()" id="student_reciever" name="student_reciever[]" >
                                <?php foreach ($admin as $value) { ?>
                                    <option value="admin-<?php echo $value['admin_id']; ?>"><?php echo $value['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>


                        <div class="form-group">
                            <textarea class="form-control" rows="20" placeholder="Type your message" name="message" placeholder="<?php echo get_phrase('write_your_message'); ?>"id="sample_wysiwyg"></textarea>
                        </div>    
                        <div class="custom-send m-t-20 text-center">
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
    
</script>
