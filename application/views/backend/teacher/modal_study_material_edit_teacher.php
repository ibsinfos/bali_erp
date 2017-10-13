<?php if (!empty($single_study_material_info)) {
    $row = array_shift($single_study_material_info);
    ?>
    <div class="modal-body">  
    <?php echo form_open(base_url() . 'index.php?teacher/study_material/update/' . $row['document_id'], array('class' => 'validate', 'enctype' => 'multipart/form-data')); ?>
        <from class="form-horizontal form-material">
            <div class="form-group">            
                <div class="col-md-12 m-b-20">
                    <label>Title</label>
                    <input type="text" class="form-control" placeholder="Enter a title" name="title" value="<?php echo $row['title']; ?>" required>
                </div>             

                <div class="col-md-12 m-b-20">
                    <label>Description</label>
                    <textarea class="form-control" rows="2" name="description" placeholder="Enter Description" required ><?php echo $row['description']; ?></textarea>
                </div>

                <div class="col-sm-12 m-b-20">
                    <label>Select Class</label>
                    <select data-style="form-control" data-live-search="true" class="selectpicker" name="class_id">
                        <option value=""><?php echo get_phrase('select_teacher'); ?></option>
                        <?php foreach ($classes as $row1): ?>                       
                            <option value="<?php echo $row1['class_id']; ?>"<?php if ($row['class_id'] == $row1['class_id']) {
                        echo 'selected';
                    } ?>><?php echo $row1['class_name']; ?></option>
    <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-12 m-b-20">
                    <label class="m-b-20 custom-file-upload">File upload </label> <span class="p-l-10"><?php echo get_phrase('(supported_types_:_.doc_.xls_.pdf_.img)'); ?></span>
                    <div class="col-md-6 fileinput fileinput-new input-group" data-provides="fileinput">

                        <input type="text" class="form-control" value="<?php echo $row['file_name']; ?>" disabled="disabled">
                       <input type="file" name="file_name" class="col-md-12 input-group btn btn-default" data-validate="required" data-message-required="<?php echo get_phrase('required'); ?>" required="required"/>

                    </div>
                </div>
                <div class="col-md-12 text-right">
                    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" name="submit_changes"><?php echo get_phrase('update'); ?></button>
                </div>

        </from>
    <?php echo form_close(); ?>
    </div>
<?php } ?>