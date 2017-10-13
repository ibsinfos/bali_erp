<?php
$row = array_shift($edit_data);
if(!empty($row)){?>
<div class="modal-body">
    <?php echo form_open(base_url() . 'index.php?school_admin/edit_academic_syllabus/' . $row['academic_syllabus_code'], array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
    <div class="form-horizontal form-material">
        <div class="form-group">
            <div class="col-md-12 m-b-20">
                <label>Syllabus Title</label><span class="mandatory"> *</span>
                <input type="text" class="form-control" name="title" value="<?php echo $row['title']; ?>" >
                <label class="mandatory"> <?php echo form_error('name'); ?></label>
            </div>
            
            <div class="col-md-12 m-b-20">
                <label>Description</label><span class="mandatory"> *</span>
                <input type="text" class="form-control" name="description" value="<?php echo $row['description']; ?>">
            </div>
            
            <div class="col-md-12 m-b-20">
                <label>Select Class</label><span class="mandatory"> *</span>
   
                    <select class="selectpicker1" data-style="form-control" data-live-search="true" name ="class_id">
                        <option value=""><?php echo get_phrase('select_class'); ?></option>
                            <?php foreach ($classes as $row2): ?>
                                <option value="<?php echo $row2['class_id']; ?>" <?php  if ($row['class_id'] == $row2['class_id']) echo 'selected'; ?> > 
                                    <?php echo $row2['name']; ?>
                                </option>
                            <?php endforeach; ?>
                    </select>
             
            </div>
            
            <div class="col-md-12 m-b-20">
                <label class="m-b-20 custom-file-upload">File upload </label> <span class="p-l-10"><?php echo get_phrase('(supported_types_:_.doc_.xls_.pdf_.img)');?></span>
                    <div class="col-md-12 fileinput fileinput-new input-group" data-provides="fileinput">
                        <input type="text" class="form-control" value="<?php echo $row['file_name']; ?>" disabled="disabled">
                        <input type="file" name="file_name" class="col-md-12 input-group btn btn-default" />
                    </div>
            </div>
            
            <div class="col-md-12 text-right">
                <button type="submit" class="fcbtn btn btn-danger btn-outline"  ><?php echo get_phrase('Update');?></button>
            </div>
        </div> 
    <?php echo form_close(); ?>
    </div>
</div>
<?php } ?>


