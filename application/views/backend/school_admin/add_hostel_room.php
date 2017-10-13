<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo $page_title;; ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>

        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><?php echo get_phrase('dormitory'); ?>
                <ul>                    
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/manage_hostel_warden"><?php echo get_phrase('manage_warden'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/manage_hostel"><?php echo get_phrase('manage_hostel'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/manage_hostel_room"><?php echo get_phrase('manage_room'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/manage_allocation"><?php echo get_phrase('manage_allocation'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/mess_management"><?php echo get_phrase('mess_details'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/mess_timetable"><?php echo get_phrase('mess_timetable'); ?></a></li>
                </ul>
            </li>
            <li class="active">
                <?php echo $page_title; ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<div class="row">
<div class="col-md-12">
    <div class="white-box" data-step="5" data-intro="<?php echo get_phrase('You can add a new hostel from here.')?>" data-position='top'>
        <?php echo form_open(base_url() . 'index.php?school_admin/add_hostel_room', array('class' => 'validate', 'target' => '_top')); ?> 
        
         <div class="row">
            <div class="col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase("hostel_type"); ?><span class="mandatory"> *</span></label>
              <select  class="selectpicker" data-style="form-control" data-live-search="true" id="hostel_type" name="hostel_type" required="required">
                <option value="">Select</option>
                <option value="Girls">Girls</option>
                <option value="Boys">Boys</option>
              </select>
            <label class="mandatory"> <?php echo form_error('hostel_type'); ?></label>            
        </div>
             
        <div class="col-md-6 form-group">
        <label for="field-1"><?php echo get_phrase("hostel_name"); ?><span class="mandatory"> *</span></label>
           <select class="selectpicker" data-style="form-control" id="hostel_name" name="hostel_name" data-validate="required" data-message-required ="<?php echo get_phrase('please_select_type'); ?>">
                        <option value=""><?php echo get_phrase('select_hostel_type_first'); ?></option>
           </select>
         <label class="mandatory"> <?php echo form_error('hostel_name'); ?></label>
        </div>  
         </div>
        
        <div class="row">
            <div class="col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase("floor_name"); ?><span class="mandatory"> *</span></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-signal"></i></div>                  
                <input type="text" class="form-control" id="floor_name" name="floor_name" value="<?php echo set_value('floor_name')?>" placeholder="Floor Name" data-validate="required" data-message-required ="<?php echo get_phrase('plesae_enter_the_value'); ?>">
                <span class="mandantory"> <?php echo form_error('floor_name'); ?></span>
            </div> 
        </div>
             <div class="col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase("room_number"); ?><span class="mandatory"> *</span></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-sort-numeric-desc"></i></div>                  
                <input type="text" class="form-control" id="room_number" name="room_number" value="<?php echo set_value('room_number')?>" placeholder="Room Number" data-validate="required" data-message-required ="<?php echo get_phrase('plesae_enter_the_value'); ?>">
                <span class="mandantory"> <?php echo form_error('room_number'); ?></span>
            </div> 
        </div>
        </div>
        
        
        <div class="row">
            <div class="col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase("number_of_beds"); ?><span class="mandatory"> *</span></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-bed"></i></div>                  
               <input type="text" class="form-control numeric" id="number_of_beds" name="number_of_beds" value="<?php echo set_value('number_of_beds')?>" placeholder="Number of Beds" data-validate="required" data-message-required ="<?php echo get_phrase('plesae_enter_the_value'); ?>">
                    <span class="mandantory"> <?php echo form_error('number_of_beds'); ?></span>
            </div> 
        </div>
             <div class="col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase("room_description"); ?><span class="mandatory"> *</span></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-sort-desc"></i></div>                  
                    <input type="text" class="form-control" value="<?php echo set_value('room_description')?>" id="room_description" name="room_description" placeholder="Room Description" data-validate="required" data-message-required ="<?php echo get_phrase('plesae_enter_the_value'); ?>">
                 <span class="mandantory"> <?php echo form_error('room_description'); ?></span>
            </div> 
        </div>
        </div>
        
        <div class="row">
         <div class="col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase("room_fare"); ?><span class="mandatory"> *</span></label>
            <?php if(sett('new_fi')){?>
                <input type="number" min="1" class="form-control" name="room_fare" placeholder="<?php echo get_phrase('room_fare');?>" required/>
            <?php }else{?>
                <select  class="selectpicker" data-style="form-control" data-live-search="true" id="room_fare" name="room_fare" required="required" data-max-options="2">
                    <option value=""><?php echo get_phrase('select_option');?></option>                
                    <?php foreach ($charges as $charge):?>
                        <option value="<?php echo $charge['sales_price'].'|'.$charge['id'];?>"><?php echo $charge['sales_price']. "------".$charge['name'];?></option>
                    <?php endforeach;?>
                </select>
            <?php }?>
            <label class="mandatory"> <?php echo form_error('room_fare'); ?></label>
        </div>  
        </div>
               <div class="text-right">
                <input type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" value="Add Room" data-step="6" data-intro="<?php echo get_phrase('You can submit from here.');?>" data-position='left'/>
<!--                <a href="<?php echo base_url(); ?>index.php?school_admin/manage_hostel_room/">
                <button  type="button" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="7" data-intro="<?php echo get_phrase('You can cancel from here.');?>" data-position='left'><?php echo get_phrase('cancel'); ?>
                </button></a>-->
          </div>  
<?php echo form_close(); ?>
            </div>
        </div>
    </div>


<script type="text/javascript">
     $('#hostel_type').change(get_hostel_name);   
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
         
    jQuery(document).ready(function(){
       $(".numeric").numeric(); 
    });
</script>