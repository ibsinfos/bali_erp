<hr />

<ul class="nav nav-tabs bordered">
    <li class="active">
        <a href="#bulktext" data-toggle="tab">
		<span class="visible-xs"><i class="entypo-users"></i></span>
            <span class="hidden-xs"><?php echo get_phrase('add_students'); ?></span>
        </a>
    </li>
    <li>
        <a href="#file" data-toggle="tab">
		<span class="visible-xs"><i class="entypo-users"></i></span>
            <span class="hidden-xs"><?php echo get_phrase('upload_file'); ?></span>
        </a>
    </li>

</ul>
<div class="tab-content">
   
    <div class="tab-pane active" id="bulktext">
        <?php echo form_open(base_url() . 'index.php?school_admin/student_bulk_add/add_bulk_student', array('class' => 'form-inline validate', 'style' => 'text-align:center;'));
        ?>
        <div class="row">
           
            <div class="col-md-6">
                <div class="form_group col-md-6">
                    <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('class'); ?></label>
					</div>
					 <div class="col-md-6">
                    <select name="class_id" id="class_id" class="selectpicker" data-style="form-control" data-live-search="true" required
                            onchange="get_sections(this.value)"  data-validate="required"  data-message-required="<?php echo get_phrase('value_required'); ?>">
                        <option value=""><?php echo get_phrase('select_class'); ?></option>
                        <?php
                            foreach ($classes as $row):
                                ?>
                                <option value="<?php echo $row['class_id']; ?>"><?php echo $row['name']; ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div id="section_holder"></div>
        
        </div>
        <br/><br/><br/>
        <div id="bulk_add_form">
            <div id="student_entry">
                <div class="row" style="margin-bottom:10px;">

                    <div class="form-group">
                        <input type="text" name="name[]" id="name" class="form-control" style="width: 160px; margin-left: 5px;"
                               placeholder="<?php echo get_phrase('name'); ?>" required>
                    </div>

                    <div class="form-group">
                        <input type="text" name="roll[]" id="roll" class="form-control" style="width: 60px; margin-left: 5px;"
                               placeholder="<?php echo get_phrase('roll'); ?>">
                    </div>

                    <div class="form-group">
                        <input type="email" name="email[]" id="email" class="form-control" style="width: 160px; margin-left: 5px;"
                               placeholder="<?php echo get_phrase('email'); ?>" required>
                    </div>

                    <div class="form-group">
                        <input type="password" name="password[]" id="password" class="form-control" style="width: 150px; margin-left: 5px;"
                               placeholder="<?php echo get_phrase('password'); ?>" required>
                    </div>

                    <div class="form-group">
                        <input type="tel" name="phone[]" id="phone" class="form-control" style="width: 140px; margin-left: 5px;"
                               placeholder="<?php echo get_phrase('phone'); ?>" data-validate="required,number">
                    </div>

                    <div class="form-group">
                        <input type="text" name="address[]" id="address" class="form-control" style="width: 140px; margin-left: 5px;"
                               placeholder="<?php echo get_phrase('address'); ?>">
                    </div>

                    <div class="form-group">
                        <select name="sex[]" id="sex" class="selectpicker" data-style="form-control" data-live-search="true" style="width: 100px; margin-left: 5px;">
                            <option value=""><?php echo get_phrase('gender'); ?></option>
                            <option value="male"><?php echo get_phrase('male'); ?></option>
                            <option value="female"><?php echo get_phrase('female'); ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="card_id[]" id="card_id" class="form-control" style="width: 100px; margin-left: 5px;"
                               placeholder="<?php echo get_phrase('Card Id'); ?>">
                    </div>

                    <div class="form-group">
                        <button type="button" class="btn btn-default " title="<?php echo get_phrase('remove'); ?>"
                                onclick="deleteParentElement(this)" style="margin-left: 10px;">
                            <i class="entypo-trash" ></i>
                        </button>
                    </div>


                </div>

            </div>


            <div id="student_entry_append"></div>
            <br>

            <div class="row">
                <center>
                    <button type="button" class="btn btn-default" onclick="append_student_entry()">
                        <i class="entypo-plus"></i> <?php echo get_phrase('add_a_row'); ?>
                    </button>
                </center>
            </div>

            <br>

            <div class="row">
                <center>
                    <button type="submit" class="btn btn-success" id="submit_button">
                        <i class="entypo-check"></i> <?php echo get_phrase('save_students'); ?>
                    </button>
                </center>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
    <div class="tab-pane" id="file">

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title" >
                            <i class="entypo-plus-circled"></i>
                            <?php echo get_phrase('student_bulk_add_form'); ?>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo form_open(base_url() . 'index.php?school_admin/student_bulk_add/import_excel/', array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data')); ?>

                        <div class="row">
                            
                            <div class="col-md-6">
                                <div class="form_group col-md-6">
                                    <label class=" col-md-6 control-label" style="margin-bottom: 5px;"><?php echo get_phrase('class'); ?></label>
				</div>
				<div class="col-md-6">
                                    <select name="class_id" id="class_id" class="form-control col-md-3 selectpicker" data-style="form-control" data-live-search="true" required onchange="get_sections_tab2(this.value)" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>">
                                        <option value=""><?php echo get_phrase('select_class'); ?></option>
                                        <?php
                                            foreach ($classes as $row):
                                                ?>
                                                <option value="<?php echo $row['class_id']; ?>"><?php echo $row['name']; ?></option>
                                            <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div id="section_holder_tab2"></div>
                            
                        </div>
                        <br/><br/><br/>

                        <div class="form-group">
                            <label for="field-1" class="col-md-3 control-label"><?php echo get_phrase('select_excel_file'); ?></label>

                            <div class="col-md-5">
                                <input type="file" name="userfile" class="form-control" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>">
                                <br>
                                <a href="<?php echo base_url(); ?>uploads/blank_excel_file.xlsx" target="_blank" 
                                   class="btn btn-info btn-sm"><i class="entypo-download"></i> Download blank excel file</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-5">
                                <input type="hidden" id="classid" name="classid" value="" />
                                <input type="hidden" id="" name="sectionid" value="" />
                            </div> 
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <button type="submit" class="btn btn-info"><?php echo get_phrase('upload_and_import'); ?></button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script type="text/javascript">

        var blank_student_entry = '';
        $(document).ready(function () {
            //$('#bulk_add_form').hide(); 
            blank_student_entry = $('#student_entry').html();

            for ($i = 0; $i < 7; $i++) {
                $("#student_entry").append(blank_student_entry);
            }

        });

        function get_sections(class_id) {
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?school_admin/get_sections/' + class_id,
                success: function (response)
                {
                    jQuery('#section_holder').html(response).selectpicker('refresh');
                    jQuery('#bulk_add_form').show();
                }
            });
        }
        function get_sections_tab2(class_id) {
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?school_admin/get_sections/' + class_id,
                success: function (response)
                {
                    jQuery('#section_holder_tab2').html(response).selectpicker('refresh');
                    jQuery('#classid').val(class_id);
                    jQuery('#sectionid').val(jQuery('#section_id').val());
                }
            });
        }


        function append_student_entry()
        {
            $("#student_entry_append").append(blank_student_entry);
        }

        // REMOVING INVOICE ENTRY
        function deleteParentElement(n)
        {
            n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
        }

    </script>
