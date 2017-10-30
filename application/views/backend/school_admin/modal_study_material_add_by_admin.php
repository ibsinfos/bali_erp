<div class="modal-body">  
<?php if (!empty($classes)){ ?>
    <?php echo form_open(base_url().'index.php?school_admin/study_material/create' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
    <from class="form-horizontal form-material">
        <div class="form-group">            
            <div class="col-md-12 m-b-20">
                <label>Title<span class="error" style="color: red;"> *</span></label>
                <input type="text" name="title" class="form-control" required>
            </div>
            
            <div class="col-md-12 m-b-20">
                <label><?php echo get_phrase('description'); ?><span class="error" style="color: red;"> *</span></label>
                <textarea name="description" class="form-control" required></textarea>
            </div> 
            
            <div class="col-md-12 m-b-20">
                <label><?php echo get_phrase('class'); ?><span class="error" style="color: red;"> *</span></label>
                <select name="class_id" data-style="form-control" data-live-search="true" class="selectpicker">
                    <option value=" ">Select Class</option>
                    <?php foreach ($classes as $row) { ?>
                            <option value="<?php echo $row['class_id']; ?>"><?php echo $row['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
                    
            <div class="col-md-12 m-b-20">
                <label><?php echo get_phrase('file_to_upload'); ?></label><span class="p-l-10"><?php echo get_phrase('(supported_types_:_.doc_.xls_.pdf_.img)');?></span>
                <input type="file" name="file_name" class="form-control file2 inline btn"  required/>
                
            </div>

            <div class="text-right">
                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" name="save_details"><?php echo get_phrase('upload');?></button>
            </div>
            <?php echo form_close();?>           
        </div>  
        <?php } else {?>
        <div class="panel-body">
            <label>No any class found.</label>
        </div>
        <?php }?>
    </from>
</div>