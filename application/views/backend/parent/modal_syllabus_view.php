<?php
$row = array_shift($edit_data);
if(!empty($row)){?>
<div class="modal-body">
    <?php echo form_open(base_url() . 'index.php?school_admin/edit_academic_syllabus/' . $row['academic_syllabus_code'], array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
    <div class="form-horizontal form-material">
        <div class="form-group">
            <div class="col-md-12 m-b-20">
                <label>Syllabus Title</label><span class="mandatory"> *</span>
                <input type="text" class="form-control" name="title" value="<?php echo $row['title']; ?>" readonly="readonly">
                <label class="mandatory"> <?php echo form_error('name'); ?></label>
            </div>
            
            <div class="col-md-12 m-b-20">
                <label>Description</label><span class="mandatory"> *</span>
                <input type="text" class="form-control" name="description" value="<?php echo $row['description']; ?>" readonly="readonly">
            </div>
            
            <div class="col-md-12 m-b-20">
                <label>Select Class</label><span class="mandatory"> *</span>
                <div class="col-sm-12">
                    <select  class="selectpicker" data-style="form-control" data-live-search="true" name ="class_id" disabled="disabled">
                        <option value=""><?php echo get_phrase('select_class'); ?></option>
                            <?php foreach ($classes as $row2): ?>
                                <option value="<?php echo $row2['class_id']; ?>" <?php  if ($row['class_id'] == $row2['class_id']) echo 'selected'; ?> > 
                                    <?php echo $row2['name']; ?>
                                </option>
                            <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
           
        </div> 
    <?php echo form_close(); ?>
    </div>
</div>
<?php } ?>


