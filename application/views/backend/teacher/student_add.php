<!--to be deleted-->
 <?php     
    if($this->session->flashdata('flash_message_error')) {?>        
    <div class="alert alert-danger">
    <?php echo $this->session->flashdata('flash_message_error'); ?>
    </div>
    <?php } ?>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title" >
                    <i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('admission_form'); ?>
                </div>
            </div>
            <div class="panel-body">

                <?php echo form_open(base_url() . 'index.php?teacher/student/create/', array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data')); ?>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name'); ?><span class="error" style="color: red;"> *</span></label>

                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" value="" autofocus required='required'>
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('parent'); ?><span class="error" style="color: red;"> *</span></label>

                    <div class="col-sm-5">
                        <select required='required' name="parent_id" data-style="form-control" data-live-search="true" class="selectpicker">
                            <option value=""><?php echo get_phrase('select'); ?></option>
                            <?php
                            foreach ($parents as $row):
                                ?>
                                <option value="<?php echo $row['parent_id']; ?>">
                                    <?php echo (!empty($row['father_name'])) ? $row['father_name'] . " " : '';
                                    echo (!empty($row['father_mname'])) ? $row['father_mname'] . " " : '';
                                    echo (!empty($row['father_lname'])) ? $row['father_lname'] : ''; ?>
                                </option>
                                <?php
                            endforeach;
                            ?>
                        </select>
                    </div> 
                </div>

                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('class'); ?><span class="error" style="color: red;"> *</span></label>

                    <div class="col-sm-5">
                        <select name="class_id" data-style="form-control" data-live-search="true" class="selectpicker" required='required' data-validate="required" id="class_id" 
                                data-message-required="<?php echo get_phrase('value_required'); ?>"
                                onchange="return get_class_sections(this.value)">
                            <option value=""><?php echo get_phrase('select'); ?></option>
                            <?php
                            foreach ($classes as $row):
                                ?>
                                <option value="<?php echo $row['class_id']; ?>">
                                    <?php echo $row['name']; ?>
                                </option>
                                <?php
                            endforeach;
                            ?>
                        </select>
                    </div> 
                </div>

                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('section'); ?><span class="error" style="color: red;"> *</span></label>
                    <div class="col-sm-5">
                        <select name="section_id" required='required' data-style="form-control" data-live-search="true" class="selectpicker" id="section_selector_holder">
                            <option value=""><?php echo get_phrase('select_class_first'); ?></option>

                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('roll'); ?><span class="error" style="color: red;"> *</span></label>

                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="roll" value="" required='required' >
                    </div> 
                </div>

                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('birthday'); ?><span class="error" style="color: red;"> *</span></label>

                    <div class="col-sm-5">
                        <input type="text" class="form-control datepicker" name="birthday" value="" data-start-view="2" required='required'>
                    </div> 
                </div>

                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('gender'); ?><span class="error" style="color: red;"> *</span></label>

                    <div class="col-sm-5">
                        <select name="sex" data-style="form-control" data-live-search="true" class="selectpicker">
                            <option value=""><?php echo get_phrase('select'); ?></option>
                            <option value="male"><?php echo get_phrase('male'); ?></option>
                            <option value="female"><?php echo get_phrase('female'); ?></option>
                        </select>
                    </div> 
                </div>

                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address'); ?><span class="error" style="color: red;"> *</span></label>

                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="address" value="" required='required'>
                    </div> 
                </div>

                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('phone'); ?><span class="error" style="color: red;"> *</span></label>

                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="phone" value="" required='required'>
                    </div> 
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email'); ?><span class="error" style="color: red;"> *</span></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="email" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" value="" required='required'>
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('password'); ?><span class="error" style="color: red;"> *</span></label>

                    <div class="col-sm-5">
                        <input type="password" class="form-control" name="password" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" value="" required='required' >
                    </div> 
                </div>

                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('dormitory'); ?></label>

                    <div class="col-sm-5">
                        <select name="dormitory_id" data-style="form-control" data-live-search="true" class="selectpicker">
                            <option value=""><?php echo get_phrase('select'); ?></option>
                            <?php
                            $dormitories = $this->db->get('dormitory')->result_array();
                            foreach ($dormitories as $row):
                                ?>
                                <option value="<?php echo $row['dormitory_id']; ?>"><?php echo $row['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div> 
                </div>

                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('transport_route'); ?></label>

                    <div class="col-sm-5">
                        <select name="transport_id" data-style="form-control" data-live-search="true" class="selectpicker">
                            <option value=""><?php echo get_phrase('select'); ?></option>
                            <?php
                            $transports = $this->db->get('transport')->result_array();
                            foreach ($transports as $row):
                                ?>
                                <option value="<?php echo $row['transport_id']; ?>"><?php echo $row['route_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div> 
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('photo'); ?><span class="error" style="color: red;"> *</span></label>

                    <div class="col-sm-5">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
                                <img src="http://placehold.it/200x200" alt="...">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                            <div>
                                <span class="btn btn-white btn-file">
                                    <span class="fileinput-new">Select image</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" name="userfile" accept="image/*">
                                </span>
                                <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-info"><?php echo get_phrase('add_student'); ?></button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <blockquote class="blockquote-blue">
            <p>
                <strong>Student Admission Notes</strong>
            </p>
            <p>
                Admitting new students will automatically create an enrollment to the selected class in the running session.
                Please check and recheck the informations you have inserted because once you admit new student, you won't be able
                to edit his/her class,roll,section without promoting to the next session.
            </p>
        </blockquote>
    </div>

</div>

<script type="text/javascript">
$(function(){ 
        $(".datepicker").datepicker({ dateFormat: "dd/mm/yy",
            changeMonth: true,
            changeYear: true,
           
            autoclose: true
        });
    });
    function get_class_sections(class_id) {

        $.ajax({
            url: '<?php echo base_url(); ?>index.php?teacher/get_class_section/' + class_id,
            success: function (response)
            {
                jQuery('#section_selector_holder').html(response).selectpicker('refresh');
            }
        });

    }

</script>