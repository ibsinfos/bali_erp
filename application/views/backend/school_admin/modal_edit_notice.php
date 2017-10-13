<div class="modal-body">  
    <?php echo form_open(base_url(). 'index.php?school_admin/noticeboard/do_update/'.$edit_data[0]['notice_id'] , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
    <from class="form-horizontal form-material">
        <div class="form-group">            
            <div class="col-md-12 m-b-20">
                <label>Notice Title<span class="error mandatory"> *</span></label>
                <input type="text" class="form-control" placeholder="Enter a title" name="notice_title" value="<?php echo $edit_data[0]['notice_title'];?>" required>
            </div>             
            <?php $date = date('Y-m-d H:i:s');?>
            <input type="hidden"  name="create_timestamp" value="<?php echo $date;?>"/>            
            <div class="col-sm-12 m-b-20">
                <label>Select Class<span class="error mandatory"> *</span></label>
                <select class="selectpicker1" data-style="form-control" data-live-search="true" required>
                    <option value=""><?php echo get_phrase('select_class'); ?></option>
                    <option value=" "><?php echo get_phrase('all'); ?></option>                   
                        <?php foreach ($classes as $row): 
                        if(!empty($edit_data[0]['class_id'])){?>
                        <option value="<?php echo $row['class_id']; ?>"<?php if ($edit_data[0]['class_id'] == $row['class_id']){echo 'selected';}?>><?php echo $row['name']; ?></option>
                        <?php } else{ ?>
                        <option value="<?php echo $row['class_id']; ?>"><?php echo $row['name']; ?></option>
                        <?php } endforeach; ?>
                </select>
            </div>
            
            <div class="col-md-12 m-b-20">
                <label>Description<span class="error mandatory"> *</span></label>
                <textarea class="form-control" rows="2" name="notice" placeholder="Enter Description" required ><?php echo $edit_data[0]['notice'];?></textarea>
            </div>
        </div>
        <div class="text-right">
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" name="save_details"><?php echo get_phrase('update');?></button>
        </div>
        
    </from>
    <?php echo form_close();?>
</div>