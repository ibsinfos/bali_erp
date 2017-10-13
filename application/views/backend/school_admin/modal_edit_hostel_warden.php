<div class="modal-body">
    <?php $row    = array_shift($warden_details);?>
    <?php     
    if($this->session->flashdata('flash_message_error')) {?>        
    <div class="alert alert-danger">
    <?php echo $this->session->flashdata('flash_message_error'); ?>
    </div>
    <?php } ?>
    <?php echo form_open(base_url() . 'index.php?school_admin/edit_warden/'.$row['warden_id'], array('class' => 'validate')); ?> 
    <from class="form-horizontal form-material">
        <div class="form-group"> 
            <div class="col-md-12 m-b-20">
            <label>Warden Name</label><span class="error mandatory"> *</span>            
                <input type="text" class="form-control" id="warden_name" name="warden_name" value="<?php echo $row['name']; ?>" placeholder="Warden Name" required>
                <span class="mandatory"> <?php echo form_error('warden_name'); ?></span>
            </div>
            <div class="col-md-12 m-b-20">
            <label>Phone Number</label>  <span class="error mandatory"> *</span>            
                <input type="text" class="form-control numeric" id="warden_phone_number" name="warden_phone_number" value="<?php echo $row['phone_number']; ?>" placeholder="Phone Number" maxlength="10" required>
                <span class="mandatory"> <?php echo form_error('warden_phone_number'); ?></span>
            </div>
            <div class="col-md-12 m-b-20">
            <label>Email</label>  <span class="error mandatory"> *</span>            
            <input type="email" class="form-control" id="warden_email" name="warden_email" rows="2" required value="<?php echo $row['email']; ?>" >
                <span class="mandatory"> <?php echo form_error('warden_email'); ?></span>
            </div>
        </div>
        <div class="text-right">
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit_changes'); ?></button>   
        </div>
                
    </from>     
    <?php echo form_close();?>
</div> 
<script type="text/javascript">
    
$(document).ready(function(){
       $(".numeric").numeric(); 
    });
</script>