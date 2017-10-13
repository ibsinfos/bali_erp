<div class="modal-body">

    <?php
    echo form_open(base_url() . 'index.php?teacher/upload_academic_syllabus', array(
        'class' => 'form-groups-bordered validate', 'target' => '_top', 'enctype' => 'multipart/form-data'
    ));
    ?>

    <div class="form-horizontal form-material">
        <div class="form-group">
            <div class="col-md-12 m-b-20">
                <label>Title</label><span class="mandatory"> *</span>
                <input type="text" class="form-control" name="title" required="required">
                <label class="mandatory"> <?php echo form_error('title'); ?></label>
            </div>

            <div class="col-md-12 m-b-20">
                <label>Description</label><span class="mandatory"> *</span>
                <input type="text" class="form-control" name="description" required="required">
            </div>

            <div class="col-md-12 m-b-20">
                <label>Select Class</label><span class="mandatory"> *</span>

                <select data-style="form-control" data-live-search="true" class="form-control" name ="class_id" required="required">
                    <option value=""><?php echo get_phrase('select_class'); ?></option>
                    <?php foreach ($class as $row): ?>
                        <option value="<?php echo $row['class_id']; ?>"> <?php echo $row['name']; ?></option>
<?php endforeach; ?>
                </select>

            </div>

            <div class="col-md-12 m-b-20">
                <label class="m-b-20">File upload </label> <span class="p-l-10"><?php echo get_phrase('(supported_types_:_.doc_.xls_.pdf_.img)'); ?></span>

                <div class="fileinput fileinput-new input-group col-md-12" data-provides="fileinput">

                    <input type="file" name="file_name" class="input-group btn btn-default col-md-12" data-validate="required" data-message-required="<?php echo get_phrase('required'); ?>" required="required"/>
                </div>

            </div>

            <div class="col-md-12 text-right">
                <button type="submit" class="fcbtn btn btn-danger btn-outline" id="sa-success" ><?php echo get_phrase('add_syllabus'); ?></button>
            </div>
        </div> 
<?php echo form_close(); ?>
    </div>
</div>