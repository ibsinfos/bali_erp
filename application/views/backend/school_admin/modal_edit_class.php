<?php if (!empty($edit_data)) {?>
    <div class="row m-0">
        <div class="col-md-12"> 
        <?php echo form_open(base_url() . 'index.php?school_admin/classes/do_update/'. $edit_data->class_id, array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data','target' => '_top')); ?>
        <div class="form-horizontal form-material">
            <div class="form-group">
                <div class="col-md-12 m-b-20">
                <label>Name</label>
                <input type="text" class="form-control" name="name" required="required" value="<?php echo $row['name']; ?>">
                <label class="mandatory"> <?php echo form_error('name'); ?></label>
                </div>

                <div class="col-md-12 m-b-20">
                <label>Name Numeric</label>
                <input type="text" class="form-control numeric" required="required" name="name_numeric" value="<?php echo $row['name_numeric']; ?>">
                </div>

<!--                <div class="col-md-12 m-b-20">
                    <label>Select Teacher</label>

                    <select class="form-control" name ="teacher_id" disabled="disabled">
                            <option value=""><?php echo get_phrase('select_teacher'); ?></option>
                                <?php foreach ($teachers as $row2): ?>
                                    <option value="<?php echo $row2['teacher_id']; ?>" <?php if($row2['teacher_id'] == $row['teacher_id']){echo 'selected';} ?>>
                                        <?php echo $row2['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                        </select>

                </div>                      -->
                <div class="col-md-12 text-right">
                    <button type="submit" class="fcbtn btn btn-danger btn-outline" id="sa-success" name="save_details"><?php echo get_phrase('edit_class');?></button>
                </div>
            </div> 
        </div>            
        <?php echo form_close(); ?>	   
        </div>    
    </div> 
<?php } ?>             
<script type="text/javascript">
    jQuery(document).ready(function () {
        $(".numeric").numeric();
    });
</script>




