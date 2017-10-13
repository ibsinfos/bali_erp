<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            
     <?php     
    if($this->session->flashdata('flash_message_error')) {?>        
    <div class="alert alert-danger">
    <?php echo $this->session->flashdata('flash_message_error'); ?>
    </div>
    <?php }  ?>
    <?php foreach($details as $value){?>
      
                <?php echo form_open(base_url() . 'index.php?school_admin/edit_manage_hostel/'.$param2 , array('class' => 'form-material validate','target'=>'_top')); ?> 
              
                <div class="form-group">
                     <div class="col-md-12 m-b-20">  
                         <label>Warden Name</label><span class="error mandatory"> *</span>
                    <select class="selectpicker" data-style="form-control" data-actions-box="true" id="warden_name" name="warden_name[]" required="required" data-max-options="2" data-live-search="true">
                        <?php 
                        foreach($warden as $k=>$v) {
                            $selected = '';
                            foreach ($value['warden'] as $ward_key => $ward_value) {
                                if($v['warden_id'] == $ward_value['warden_id']) {
                                    $selected ="selected";
                                }
                            }
                        ?>
                        <option value="<?php echo $v['warden_id'];?>" <?php echo $selected; ?>> <?php 
                            echo $v['name'];
                        ?> </option>
                        <?php } ?>
                    </select>
                         <span class="mandatory"> <?php echo form_error('warden_name'); ?></span>
                     </div>
                </div>            
             <div class="form-group">
                <div class="col-md-12 m-b-20">
                    <label>Name</label>
                    <span class="error mandatory" > *</span>
                    <span class="mandatory"> <?php echo form_error('hostel_name'); ?></span>
                    <input type="text" class="form-control" id="hostel_name" name="hostel_name" value="<?php echo $value['name']; ?>" placeholder="Hostel Name"  required="required">
                </div>
             </div>
             <div class="form-group">
                <div class="col-md-12 m-b-20">
                    <label>Hostel Type</label>
                    <span class="error mandatory"> *</span>
                    <span class="mandatory"> <?php echo form_error('hostel_type'); ?></span>
                    <select class="selectpicker1" data-style="form-control" data-live-search="true" id="hostel_type" name="hostel_type" required="required">
                        <option>Select Hostel Type</option>
                        <option value="girls" <?php if ($value['type'] == 'Girls'){ echo "selected";} ?>><?php echo get_phrase('girls'); ?></option>
                        <option value="boys" <?php if ($value['type'] == 'Boys'){ echo "selected";} ?>><?php echo get_phrase('boys'); ?></option>                
                    </select>
                </div>
             </div>
                
             <div class="form-group">
                <div class="col-md-12 m-b-20">
                    <label>Phone No.</label>
                   <span class="error mandatory" > *</span>
                     <span class="mandatory"> <?php echo form_error('hostel_phone_number'); ?></span>
                    <input type="tel" class="form-control numeric" id="hostel_phone_number" name="hostel_phone_number" value="<?php echo $value['phone'];?>" placeholder="Phone Number"  required="required" maxlength="10">   
                </div>
             </div>
                 <div class="form-group">
                <div class="col-md-12 m-b-20">
                    <label>Hostel Address</label>
                <span class="mandatory"> *</span>
                    <span class="error mandatory"> <?php echo form_error('hostel_address'); ?></span>
                    <textarea class="form-control" id="hostel_address" name="hostel_address" rows="2" placeholder="Hostel Address"  required="required"><?php echo $value['address'];?></textarea>
                </div>
                 </div>
               <div class="form-group">
                            <div class="col-xs-12 text-right">
                                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><?php echo get_phrase('update'); ?></button>
                           
                            </div>
                </div>
            
    <?php } echo form_close(); ?>
        </div>
                </div>
            </div>

   

<script type="text/javascript">
    
$(document).ready(function(){
       $(".numeric").numeric(); 
    });

//$('#warden_name').multiselect({
//    placeholder: 'Select Name',
//    search: true,
//    selectAll: true
//});
</script>
