<?php foreach($admin_data as $edit_data){ ?>
<div class="row">
    <div class="col-md-12">
        <?php echo form_open(base_url() . 'index.php?school_admin/bus_admin/edit/'.$edit_data['bus_administrator_id'] , array('class' => 'form-horizontal form-material form-groups-bordered validate','target'=>'_top'));?>
                <div class="form-group">
                    <div class="col-md-12 m-b-20">
                        <label><?php echo get_phrase('name'); ?></label>
                        <input type="text" class="form-control" name="name" placeholder="Please Enter Name" value="<?php echo $edit_data['name']; ?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" required="required"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12 m-b-20">
                        <label><?php echo get_phrase('email'); ?></label>
                        <input type="text" class="form-control" name="email" placeholder="Please Enter Email" value="<?php echo $edit_data['email']; ?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" required="required"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12 m-b-20">
                        <label><?php echo get_phrase('phone'); ?></label>
                        <input type="text" class="form-control" placeholder="Please Enter phone" name="phone" value="<?php echo $edit_data['phone']; ?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" required="required"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12 m-b-20">
                        <label><?php echo get_phrase('gender'); ?></label>
                        <select name="gender" class="selectpicker1" data-style="form-control" data-live-search="true" required="required">
                            <option>Select Gender</option>
                            <option <?php if($edit_data['sex'] == 'male') echo 'selected'; ?> value="male">Male</option>
                            <option <?php if($edit_data['sex'] == 'female') echo 'selected'; ?> value="female">Female</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                  <div class="col-md-12 m-b-20 text-right">
                      <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('update');?></button>                         
                      
                  </div>
                </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php } ?>