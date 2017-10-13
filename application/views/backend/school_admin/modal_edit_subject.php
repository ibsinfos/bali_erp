<?php foreach ($edit_data as $data): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel-body">
                <?php echo form_open(base_url() . 'index.php?school_admin/subject/do_update/' . $data['subject_id'], array('class' => 'form-horizontal form-material form-groups-bordered validate', 'target' => '_top')); ?>

                <div class="form-group">
                    <div class="col-md-12 m-b-20">
                        <label>Subject</label>
                        <input type="text" class="form-control" placeholder="Subject Name" name="name" value="<?php echo $data['name']; ?>" data-validate="required" data-message-required="<?php echo get_phrase('please_enter_required_value'); ?>" required="required"/>
                    </div>
                    <div class="col-md-12 m-b-20">
                         <label>Select Class</label>
                        <select name="class_id" class="selectpicker1" data-style="form-control" data-live-search="true" required="required">
                            <?php                                
                            foreach ($classes as $row2):
                                ?>
                                <option value="<?php echo $row2['class_id']; ?>"
                                    <?php if ($row2['class_id'] == $data['class_id']) echo 'selected'; ?> >
                                    <?php echo $row2['name']; ?>
                                </option>
                                <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                        <div class="col-md-12 m-b-20">
                             <label>Select Section</label>
                            <select name="section_id" class="selectpicker1" data-style="form-control" data-live-search="true" required="required">
                                <option value=""><?php echo get_phrase("select_section");?></option>
                                <?php                                   
                                foreach ($sections as $row2):
                                    ?>
                                    <option value="<?php echo $row2['section_id']; ?>"
                                        <?php if ($row2['section_id'] == $data['section_id']) echo 'selected'; ?> >
                                        <?php echo $row2['name']; ?>
                                    </option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                        </div>


                        <div class="col-md-12 m-b-20">
                             <label>Select Teacher</label>
                            <select name="teacher_id" class="selectpicker1" data-style="form-control" data-live-search="true" required="required">                                   
                                <?php

                                foreach ($teachers as $row2):
                                    ?>
                                    <option value="<?php echo $row2['teacher_id']; ?>"
                                            <?php if ($data['teacher_id'] == $row2['teacher_id']) echo 'selected'; ?>>
                                                <?php echo $row2['name'] ." ". ($row2['middle_name']!=''?$row2['middle_name']:'') ." ". $row2['last_name']; ?>
                                    </option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 text-right">
                            <!--<button type="submit" class="btn btn-info waves-effect" data-dismiss="modal">Save</button>-->
                            <button type="submit"  class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><?php echo get_phrase('update'); ?></button>
                            <!--<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>-->
                        </div>
                    </div>
                    <?php echo form_close();?>
                </div>

        </div>
    </div>
        <?php
    endforeach;
?>


