<form action="<?php echo base_url();?>index.php?school_admin/gpa_settings/gpa_preference" method="POST">    
    <div class="radio radio-success">
        <input type="radio" name="pref" value="gpa_average" checked="">
        <label for="pref"><?php echo get_phrase('gpa_average');?></label>
    </div>
    
    <div class="radio radio-success">
        <input type="radio" name="pref" value="credit_hours">
        <label for="pref"><?php echo get_phrase('credit_hours');?></label>
    </div>    
    
    <div class="text-right">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit'); ?></button>
    </div>
</form> 