<div class="modal-body">
    <?php echo form_open(base_url() . 'index.php?school_admin/sections/create/', array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data','target' => '_top')); ?>
    <div class="form-horizontal form-material">
        <div class="form-group">
            <div class="col-md-12 m-b-20">
            <label><?php echo get_phrase('section_name') ?></label><span class="mandatory"> *</span>
            <input type="text" required="required" class="form-control" name="name">
            <label class="mandatory"> <?php echo form_error('name'); ?></label>
            </div>
            
            <div class="col-md-12 m-b-20">
            <label><?php echo get_phrase('Description') ?></label><span class="mandatory"> *</span>
            <input type="text" required="required" class="form-control" name="nick_name">
            </div>
            
            <div class="col-md-12 m-b-20">
            <label><?php echo get_phrase('room_no') ?></label><span class="mandatory"> *</span> 
            <input type="text" required="required" class="form-control" name="room_no">
            </div>
            
            <div class="col-md-12 m-b-20">
            <label><?php echo get_phrase('maximum_capacity') ?></label><span class="mandatory"> *</span>
            <input type="text" required="required" class="form-control" name="max_capacity">
            </div>
                       
            <div class="col-md-12 m-b-20">
                <label><?php echo get_phrase('select_class') ?></label><span class="mandatory"> *</span>
                    <select class="selectpicker1" data-live-search="true" data-style="form-control" name="class_id" required="required">
                        <option value=""><?php echo get_phrase('select_class'); ?></option>
                            <?php foreach ($classes as $row): ?>
                                <option value="<?php echo $row['class_id']; ?>">
                                    <?php echo $row['name']; ?>
                                </option>
                            <?php endforeach; ?>
                    </select>
            </div>
            
            <div class="col-md-12 m-b-20">
                <label><?php echo get_phrase('select_teacher') ?></label><span class="mandatory"> *</span>
                    <select class="selectpicker1" data-style="form-control" data-live-search="true" required="required" name="teacher_id">
                        <option value=""><?php echo get_phrase('select'); ?></option>
                        <?php foreach ($teachers as $row): ?>
                            <option value="<?php echo $row['teacher_id']; ?>">
                                <?php echo $row['name'] ." ". ($row['middle_name']!=''?$row['middle_name']:'') ." ". $row['last_name'];; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
         
            </div>            
            <div class="col-md-12 text-right">
                <button type="submit" class="fcbtn btn btn-danger btn-outline"  name="save_details"><?php echo get_phrase('add_section');?></button>
            </div>
        </div> 
    <?php echo form_close(); ?>
    </div>
</div>
    
    
            