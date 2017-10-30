<?php
    $row = (array) $edit_data;
    if (!empty($row)) { ?>
<div class="modal-body">
    <?php echo form_open(base_url() . 'index.php?school_admin/sections/edit/' . $row['section_id'].'/'.$row['class_id'], array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data')); ?>
    <div class="form-horizontal form-material">
        <div class="form-group">
            <div class="col-md-12 m-b-20">
                <label><?php echo get_phrase('section_name') ?></label><span class="mandatory"> *</span>
                <input type="text" required="required" class="form-control" name="name" value="<?php echo $row['name']; ?>" >
                <label class="mandatory"> <?php echo form_error('name'); ?></label>
            </div>
            
            <div class="col-md-12 m-b-20">
                <label><?php echo get_phrase('Description') ?></label><span class="mandatory"> *</span>
                <input type="text" required="required" class="form-control" name="nick_name" value="<?php echo $row['nick_name']; ?>">
            </div>
            
            <div class="col-md-12 m-b-20">
                <label><?php echo get_phrase('room_no') ?></label><span class="mandatory"> *</span> 
                <input type="text" required="required" class="form-control" name="room_no" value="<?php echo $row['room_no']; ?>">
            </div>
            
            <div class="col-md-12 m-b-20">
                <label><?php echo get_phrase('maximum_capacity') ?></label><span class="mandatory"> *</span>
                <input type="text" required="required" class="form-control" name="max_capacity" value="<?php echo $row['max_capacity']; ?>">
            </div>
                       
            <div class="col-md-12 m-b-20">
                <label><?php echo get_phrase('select_class') ?></label><span class="mandatory"> *</span>
              
                    <select class="selectpicker1" data-style="form-control" data-live-search="true"name ="class_id" disabled="disabled">
                        <option value=""><?php echo get_phrase('select_class'); ?></option>
                            <?php foreach ($classes as $row2): ?>
                                <option value="<?php echo $row2['class_id']; ?>" <?php  if ($row['class_id'] == $row2['class_id']) echo 'selected'; ?> > 
                                    <?php echo $row2['name']; ?>
                                </option>
                            <?php endforeach; ?>
                    </select>
               
            </div>
            
            <div class="col-md-12 m-b-20">
                <label><?php echo get_phrase('select_teacher') ?></label><span class="mandatory"> *</span>
               
                    <select class="selectpicker1 form-control outline_none" data-style="form-control"  data-live-search="true"   required="required" name="teacher_id">
                         <option value=""><?php echo get_phrase('select_teacher'); ?></option>
                        <?php foreach ($teachers as $row3): ?>
                    <option <?php
                    if ($row['teacher_id'] == $row3['teacher_id']) {
                        echo 'selected';
                    }
                    ?> value="<?php echo $row3['teacher_id']; ?>">
                        <?php echo $row3['name'] ." ". ($row3['middle_name']!=''?$row3['middle_name']:'') ." ". $row3['last_name']; ?></option>
                    <?php endforeach; ?>
                    </select>
            </div>            
            <div class="col-md-12 text-right">
                <button type="submit" class="fcbtn btn btn-danger btn-outline" id="sa-success" name="save_details"><?php echo get_phrase('edit_section');?></button>
            </div>
        </div> 
    <?php echo form_close(); ?>
    </div>
</div>
<?php } ?>

<script>

</script>








    