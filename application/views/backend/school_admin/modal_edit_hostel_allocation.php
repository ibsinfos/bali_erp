<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
           
    <div class="form-group">      
                 <?php foreach ($allocation_details as $value): ?>
                <?php echo form_open(base_url() . 'index.php?school_admin/edit_hostel_allocation/'.$param2, array('class' => 'form-material form-groups-bordered validate', 'target' => '_top')); ?> 
                <div class="col-md-6  form-group"> 
            <label><?php echo get_phrase('user_type'); ?></label>
            <input type="text" class="form-control" name="user_type" value="<?php echo get_phrase('student'); ?>" disabled="disabled">  
                </div>
         <div class="col-md-6 form-group">
            <label><?php echo get_phrase('hostel_name'); ?></label>
            <input type="text" class="form-control" name="hostel_name" value="<?php echo $value['hostel_name']; ?>" disabled="disabled">
         </div> 
        <div class="col-md-6 form-group">
            <label><?php echo get_phrase('student_name'); ?></label>
           <input type="text" class="form-control" name="student_name" value="<?php echo $value['student_name']; ?>" disabled="disabled">
        </div> 
        <div class="col-md-6 form-group">
            <label><?php echo get_phrase('hostel_type'); ?></label>
           <input type="text" class="form-control" name="hostel_type" value="<?php echo $value['hostel_type']; ?>" disabled="disabled">
        </div> 
        <div class="col-md-6 form-group">
            <label><?php echo get_phrase('floor'); ?></label>
           <input type="text" class="form-control" name="floor_name" value="<?php echo $value['floor_name']; ?>" disabled="disabled">
        </div> 
        <div class="col-md-6 form-group">
            <label><?php echo get_phrase('hostel_name'); ?></label>
           <input type="text" class="form-control" name="hostel_name" value="<?php echo $value['hostel_name']; ?>" disabled="disabled">
        </div>
        <div class="col-md-6 form-group">
            <label><?php echo get_phrase('room_no'); ?></label>
            <input type="text" class="form-control" name="room_no" value="<?php echo $value['room_no']; ?>" disabled="disabled">
        </div>
        
        <div class="col-md-6 form-group">
            <label><?php echo get_phrase('hostel_registration_date'); ?></label><span class="error mandatory" > *</span>
             <input id= "register_date" type="text" class="form-control datepicker" value="<?php echo $value['register_date']; ?>"  name="register_date" placeholder="Pick a date" data-validate="required" data-message-required ="Please pick a date">
        </div>
        <div class="col-md-6 form-group">
            <label><?php echo get_phrase('vacating_date'); ?></label><span class="error mandatory" > *</span>
             <input id= "vacating_date" type="text" class="form-control datepicker"  name="vacating_date" value="<?php echo $value['vacating_date']; ?>" placeholder="Pick a date" data-validate="required" data-message-required ="Please pick a date">
        </div>
        <div class="col-md-6 form-group m-t-20">
            <label><?php echo get_phrase('food'); ?></label><span class="error mandatory" > *</span>
             <input type="radio" name="food" value="yes" <?php if ($value['food'] == "yes") echo 'checked="true"'; ?> required ><?php echo get_phrase('yes'); ?>
             <input type="radio" name="food" value="no" <?php if ($value['food'] == "no") echo 'checked="true"'; ?> required ><?php echo get_phrase('no'); ?>
        </div>
        <div class="col-xs-12 form-group text-right "> 
            <button type="submit" class="fcbtn btn btn-danger btn-outline"><?php echo get_phrase('update'); ?></button>
        </div>
                <?php echo form_close(); ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        $('#register_date').datepicker({
           format: "yyyy/mm/dd"
        });

       $('#vacating_date').datepicker({
           format: "yyyy/mm/dd"
       });

    });
</script>


