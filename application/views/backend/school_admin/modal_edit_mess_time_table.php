<?php foreach ($data as $value) { ?>  
<?php echo form_open(base_url() . 'index.php?school_admin/add_mess_time_table/edit/'.$value['mess_time_table_id'], array('class' => 'form-material form-groups-bordered validate', 'target' => '_top')); ?>
<div class="form-group"> 
    <input type="hidden" class="form-control" name="mess_id"  value="<?php echo $value['mess_management_id'] ?>" >
    <div class="col-md-12 m-b-20">
        <label class="control-label"><?php echo get_phrase('name'); ?><span class="error mandatory"> *</span></label>
        <input type="text" class="form-control" required="required" name="name" placeholder="<?php echo get_phrase('mess_name'); ?>" value="<?php echo $value['name'] ?>" disabled="disabled"> 
    </div>
    <div class="col-md-12 m-b-20">
        <label class="control-label">
            <?php echo get_phrase('day'); ?><span class="error mandatory"> *</span>
        </label>
        <input type="text" class="form-control" required="required" name="day" placeholder="<?php echo get_phrase('day'); ?>" value="<?php echo $value['day'] ?>" disabled="disabled">
    </div>

    <div class="col-md-12 m-b-20">
        <label class="control-label">
            <?php echo get_phrase('type'); ?><span class="error mandatory"> *</span>
        </label>
        <input type="text" class="form-control" required="required" name="type" placeholder="<?php echo get_phrase('type'); ?>" value="<?php echo $value['type'] ?>" disabled="disabled"> 

    </div>
    <div class="col-md-12 m-b-20">
        <label class="control-label">
            <?php echo get_phrase('food'); ?><span class="error mandatory"> *</span>
        </label>
        <input type="text" class="form-control" required="required" name="food" placeholder="<?php echo get_phrase('name_of_food'); ?>" value="<?php echo $value['food'] ?>"> 
    </div>

    <div class="col-md-12 m-b-20 text-right">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d m-t-10" data-step="7" data-intro="On the click of this button, timetable for particular class will be added." data-position='left'>
            <?php echo get_phrase('submit'); ?></button>
    </div>
</div>
<?php echo form_close(); ?>
<?php } ?>