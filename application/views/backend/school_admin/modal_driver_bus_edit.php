<div class="tab-pane box active" id="edit">
<div class="panel-body">
        <?php echo form_open(base_url() . 'index.php?school_admin/bus_driver/edit/'.$edit_data->bus_driver_id , array('class' => 'form-horizontal form-material form-groups-bordered validate','target'=>'_top'));?>
                <div class="form-group">
                    <div class="col-md-12 m-b-20">
                         <label><?php echo get_phrase('name'); ?><span class="mandatory"> *</span></label>
                        <input type="text" class="form-control" name="name" placeholder="Please Enter Name" value="<?php echo $edit_data->name; ?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" required="required"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12 m-b-20">
                         <label><?php echo get_phrase('email'); ?><span class="mandatory"> *</span></label>
                        <input type="text" class="form-control" name="email" placeholder="Please Enter Email" value="<?php echo $edit_data->email; ?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" required="required"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12 m-b-20">
                         <label><?php echo get_phrase('phone'); ?><span class="mandatory"> *</span></label>
                        <input type="text" class="form-control numeric" name="phone" placeholder="Please Enter Phone" value="<?php echo $edit_data->phone; ?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" maxlength="10" required="required"/>

                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12 m-b-20">
                         <label><?php echo get_phrase('gender'); ?><span class="mandatory"> *</span></label>
                         <select name="gender" class="selectpicker1" data-style="form-control" data-live-search="true" required="">
                            <option>Select Gender</option>
                            <option <?php if($edit_data->sex == 'male') echo 'selected'; ?> value="male">Male</option>
                            <option <?php if($edit_data->sex == 'female') echo 'selected'; ?> value="female">Female</option>
                        </select>
                    </div>
                </div>
        
                <div class="form-group">
                  <div class="col-sm-offset-3 text-right">
                      <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('update');?></button>
                         
                  </div>
                </div>
        <?php echo form_close(); ?>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
       $(".numeric").numeric(); 
    });
</script>