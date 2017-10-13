<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
    <?php if($this->session->flashdata('flash_message_error')) {?>        
    <div class="alert alert-danger">
    <?php echo $this->session->flashdata('flash_message_error'); ?>
    </div>
    <?php }?>
    <div class="panel-body">
            <?php echo form_open(base_url() . 'index.php?school_admin/edit_hostel_room/'.$row['hostel_room_id'], array('class' => 'form-material validate','target'=>'_top'));
                ?> 
                 <div class="form-group"> 
                <div class="col-md-6 m-b-20">
                     <label><?php echo get_phrase('hostel_type'); ?><span class="error mandatory"> *</span></label>
                  <select class="selectpicker" data-style="form-control" data-live-search="true" id="hostel_type" name="hostel_type" required="required" onclick="get_hostel_name();">
                        <option value="">Select Hostel Type</option>
                        <option value="Girls" <?php if($row['hostel_type'] == 'Girls'){ echo 'selected'; }?> >Girls</option>
                        <option value="Boys" <?php if($row['hostel_type'] == 'Boys'){ echo 'selected'; }?>>Boys</option>
                    </select>
                     <label class="mandatory"> <?php echo form_error('hostel_type'); ?></label>
                </div>  
                                   
                    <div class="col-md-6 m-b-20">
                    <label for="field-1"><?php echo get_phrase("hostel_name"); ?><span class="mandatory"> *</span></label>
                    <select class="selectpicker" data-style="form-control" data-live-search="true" id="hostel_name" name="hostel_name" data-validate="required" data-message-required ="<?php echo get_phrase('please_select_type'); ?>">
                            <option value=""><?php echo get_phrase('select_hostel_type_first'); ?></option>
                            <?php if(count($hostel_name)){
                                foreach($hostel_name as $hostel){?>
                                    <option value="<?php echo $hostel->dormitory_id;?>" <?php if($row['hostel_id'] == $hostel->dormitory_id){ echo 'selected'; }?> ><?php echo $hostel->name;?></option>
                            <?php  } }?>
                    </select>
                    <label class="mandatory"> <?php echo form_error('hostel_name'); ?></label>
                </div>
                 </div>
        <div class="form-group"> 
                  <div class="col-md-6 m-b-20">
                    <label for="field-1"><?php echo get_phrase("floor_name"); ?><span class="mandatory"> *</span></label>                
                    <input type="text" class="form-control" id="floor_name" name="floor_name" value="<?php echo $row['floor_name'];?>" placeholder="Floor Name" data-validate="required" data-message-required ="<?php echo get_phrase('plesae_enter_the_value'); ?>">
                <label class="mandatory" > <?php echo form_error('floor_name'); ?></label>
                  </div>
                                   
                    <div class="col-md-6 m-b-20">
               <label for="field-1"><?php echo get_phrase("room_number"); ?><span class="mandatory"> *</span></label>
                    <input type="text" class="form-control numeric" value="<?php echo $row['room_number'];?>" id="room_number" name="room_number" placeholder="Room Number" data-validate="required" data-message-required ="<?php echo get_phrase('plesae_enter_the_value'); ?>">
                 <label class="mandatory"> <?php echo form_error('room_number'); ?></label>
                </div>
        </div>
          <div class="form-group"> 
                <div class="col-md-6 m-b-20">
                    <label for="field-1"><?php echo get_phrase("number_of_beds"); ?><span class="mandatory"> *</span></label>
                    <input type="text" class="form-control numeric" id="number_of_beds" name="number_of_beds" value="<?php echo $row['no_of_beds'];?>" placeholder="Number of Beds" data-validate="required" data-message-required ="<?php echo get_phrase('plesae_enter_the_value'); ?>">
                     <label class="mandatory"> <?php echo form_error('number_of_beds'); ?></label>
                </div>
                                  
                    <div class="col-md-6 m-b-20">
                    <label for="field-1"><?php echo get_phrase("room_description"); ?><span class="mandatory"> *</span></label> 
                    <input type="text" class="form-control" value="<?php echo $row['room_description'];?>" id="room_description" name="room_description" placeholder="Room Description" data-validate="required" data-message-required ="<?php echo get_phrase('plesae_enter_the_value'); ?>">
                 <label class="error mandatory" > <?php echo form_error('room_description'); ?></label>
                </div>
         </div>
         <div class="form-group"> 
                 <div class="col-md-6 m-b-20">
                  <label for="field-1"><?php echo get_phrase("room_fare"); ?><span class="mandatory"> *</span></label> 
                  <?php if(sett('new_fi')){?>
                    <input type="number" min="1" class="form-control" name="room_fare" placeholder="<?php echo get_phrase('room_fare');?>" value="<?php echo $row['room_fare']?>" required/>
                  <?php }else{?>   
                    <!--<input type="text" class="form-control numeric" value="<?php echo set_value('room_fare')?>" id="room_fare" name="room_fare" placeholder="Room Fare" data-validate="required" data-message-required ="<?php echo get_phrase('plesae_enter_the_value'); ?>">-->
                    <select class="selectpicker" data-style="form-control" data-live-search="true" id="room_fare" name="room_fare" required="required" data-max-options="2">
                        <option value=""><?php echo get_phrase('select_option');?></option>                
                        <?php foreach ($charges as $charge):?>
                        <option value="<?php echo $charge['sales_price'].'|'.$charge['id'];?>" <?php if($row['room_fare'] == floor($charge['sales_price'])){ echo 'selected'; }?> ><?php echo $charge['sales_price']. "------".$charge['name'];?></option>
                        <?php endforeach;?>
                    </select>
                  <?php }?>
                <label class="error mandatory"> <?php echo form_error('room_fare'); ?></label>
            </div>
        </div>
         <div class="form-group">
                            <div class="col-xs-12 text-right">
                                <input type="submit" name="edit_hostel_room" id="edit_hostel_room" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light" value="Update"/>
                                
                            </div>
                </div>
 
            <?php echo form_close(); ?>
            </div>           
        </div>
    </div>
</div>

    <script type="text/javascript">
     function get_hostel_name() {
            var type = $("#hostel_type option:selected").val();
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?school_admin/get_hostel_name/' + type,
                success: function (response)
                {

                    jQuery('#hostel_name').html(response).selectpicker('refresh');
                }
            });
        }
            </script>
            <script type="text/javascript">
    jQuery(document).ready(function(){
       $(".numeric").numeric(); 
    });
</script>