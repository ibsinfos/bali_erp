
<div class="modal-body">
    <?php echo form_open(base_url() . 'index.php?school_admin/upload_academic_syllabus', array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top', 'enctype' => 'multipart/form-data'));?>
    <div class="form-horizontal form-material">
        <div class="form-group">
            <div class="col-md-12">
                <label class="control-label"><?php echo get_phrase('title'); ?></label><span class="mandatory"> *</span>
            <input type="text" class="form-control" name="title" required="required">
            <label class="mandatory"> <?php echo form_error('title'); ?></label>
            </div>
            
            <div class="col-md-12">
            <label class="control-label"><?php echo get_phrase('Description'); ?></label><span class="mandatory"> *</span>
            <input type="text" class="form-control" name="description" required="required">
            </div>
                                 
            <div class="col-md-12 m-b-20">
                <label class="control-label"><?php echo get_phrase('Select_Class'); ?></label><span class="mandatory"> *</span>
                    <select class="selectpicker1" data-style="form-control" name ="class_id" required="required">
                        <option value=""><?php echo get_phrase('select_class'); ?></option>
                            <?php foreach ($classes as $row): ?>
                                <option value="<?php echo $row['class_id']; ?>"> <?php echo $row['name']; ?></option>
                            <?php endforeach; ?>
                    </select>
            </div>
                              
            <div class="col-md-12">
                <label class="m-b-20 custom-file-upload"><?php echo get_phrase('File_upload'); ?> </label> <span class="p-l-10"><?php echo get_phrase('(supported_types_:_.doc_.xls_.pdf_.img)');?></span>
                    <div class="col-md-12 fileinput fileinput-new input-group" data-provides="fileinput">
                       <input type="file" name="file_name" class="col-md-12 input-group btn btn-default" data-validate="required" data-message-required="<?php echo get_phrase('required'); ?>" required="required"/>
                    </div>
            </div>
                        
            <div class="col-md-12 text-right">
                <button type="submit" class="fcbtn btn btn-danger btn-outline" id="sa-success" ><?php echo get_phrase('add_syllabus');?></button>
            </div>
        </div> 
    <?php echo form_close(); ?>
    </div>
</div>


