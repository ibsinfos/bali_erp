<?php $edit_data = $this->db->get_where('bus_driver' , array('bus_driver_id' => $param2) )->row(); 
$routes = $this->db->get('transport')->result_array(); ?>

<div class="tab-pane box active" id="edit" style="padding: 5px">
    <div class="box-content">
        <?php echo form_open(base_url() . 'index.php?school_admin/bus_driver/edit/'.$edit_data->bus_driver_id , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="name" value="<?php echo $edit_data->name; ?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('Email');?></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="email" value="<?php echo $edit_data->email; ?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('Phone');?></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="phone" value="<?php echo $edit_data->phone; ?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('gender');?></label>
                    <div class="col-sm-5">
                        <select name="gender"  class="selectpicker1" data-style="form-control" data-live-search="true">
                            <option <?php if($edit_data->sex == 'male') echo 'selected'; ?> value="male">Male</option>
                            <option <?php if($edit_data->sex == 'female') echo 'selected'; ?> value="female">Female</option>
                        </select>
                    </div>
                </div>
        
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-5">
                      <button type="submit" class="btn btn-info"><?php echo get_phrase('save_changes');?></button>
                  </div>
                </div>
        <?php echo form_close(); ?>
    </div>
</div>