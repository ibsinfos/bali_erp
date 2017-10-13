<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title" >
                    <i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('add_new_incident'); ?>
                </div>
            </div>
            <div class="panel-body">

                <?php echo form_open(base_url() . 'index.php?school_admin/disipline/create/', array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data','target' => '_top')); ?>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('student_involved'); ?></label>

                    <div class="col-sm-5">
                        <select name="class_id" class="selectpicker select2" data-style="form-control" data-live-search="true" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>">
                            <option value=""><?php echo get_phrase('select'); ?></option>
                            <?php foreach ($classes as $row): ?>
                                <option value="<?php echo $row['class_id']; ?>">
                                    <?php echo $row['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div> 
                </div>
                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('reported_by'); ?></label>

                    <div class="col-sm-5">
                        <select class="selectpicker" data-style="form-control" data-live-search="true">
                            <option>Teacher</option>
                            <option>Staff</option>
                            <option>Student</option>
                            <option>Other</option>
                        </select>
                    </div> 
                     <div class="col-sm-4">
                        <input type="text" class="form-control" name="nick_name" data-validate="required" value="" placeholder="Name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('Date_of_incident'); ?></label>

                    <div class="col-sm-5">
                        <input id= "person" type="text" class="form-control datepicker"  name="date_select" placeholder="Pick a date" data-validate="required" data-message-required ="Please pick a date">
                    </div> 
                </div>
                
                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('time'); ?></label>

                    <div class="col-sm-5">
                        
                        <input type="text" class="form-control" name="room_no"  data-validate="required" value="" >
                        
                    </div> 
                    <div class="col-sm-3">
                        <select name="class_id" class="selectpicker" data-style="form-control" data-live-search="true" data-validate="required">
                            <option>Select</option>
                            <option>AM</option>
                            <option>PM</option>
                        </select></div>
                    
                </div>
                
                 <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('location'); ?></label>

                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="max_capacity"  data-validate="required" value="" >
                    </div> 
                </div>

                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('Severity'); ?></label>
                    <div class="col-sm-5">
                        <select name="class_id" class="selectpicker" data-style="form-control" data-live-search="true" data-validate="required">
                            <option>Select</option>
                            <option value="Low">Low</option>
                            <option>Medium</option>
                            <option>High</option>
                        </select>
                    </div> 
                </div>
                
                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('Reason'); ?></label>
                    <div class="col-sm-5"><textarea></textarea></div>
           
                </div>

                
                
                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('Impact'); ?></label>
                    <div class="col-sm-5"><textarea></textarea></div>
           
                </div>

                
               
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-info"><?php echo get_phrase('add_incident'); ?></button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>