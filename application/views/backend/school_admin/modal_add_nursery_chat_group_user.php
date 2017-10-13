<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title" >
                    <i class="entypo-plus-circled"></i>
                    <?php echo 'Connct user to chart group'; ?>[<strong><?php echo $group_name;?></strong>]
                </div>
            </div>
            <div class="panel-body">
                <?php echo form_open(base_url() . 'index.php?school_admin/connect_user_to_chat_group/'.$param2.'/create', array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                <div class="form-group">
                    <label for="categoriesName" class="col-sm-4 control-label">Select User to Chat Group:  </label>
                    <label class="col-sm-1 control-label">: </label>
                    <div class="col-sm-7">
                        <select class="selectpicker1 select2" data-style="form-control" data-live-search="true" name="user_id" required>
                            <option value=""><?php echo get_phrase('select_a_user'); ?></option>
                            <optgroup label="<?php echo get_phrase('teacher'); ?>">
                                <?php
                                foreach ($datteacherArr as $row):
                                    ?>

                                    <option value="1-<?php echo $row->teacher_id; ?>">
                                        - <?php echo $row->name; ?></option>

                                <?php endforeach; ?>
                            </optgroup>
                            <optgroup label="<?php echo get_phrase('parent'); ?>">
                                <?php
                                foreach ($parrentDataArr as $row): 
                                    ?>
                                    <option value="2-<?php echo $row->parent_id; ?>">
                                        - <?php echo $row->father_name; ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        </select>
                    </div>
                </div> 
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-info"><?php echo get_phrase('add_group_user'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




