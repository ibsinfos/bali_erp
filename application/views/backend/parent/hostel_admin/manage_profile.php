<div class="row">
    <div class="col-md-12">    
    <!------CONTROL TABS START------>
        <ul class="nav nav-tabs bordered">
            <li class="active">
            <a href="#list" data-toggle="tab"><i class="entypo-user"></i><?php echo get_phrase('manage_profile');?>
            </a></li>
        </ul>
    <!------CONTROL TABS END------>
        <div class="tab-content">
        <br>
        	<!----EDITING FORM STARTS---->
            <div class="tab-pane box active" id="list" style="padding: 5px">
                <div class="box-content">
                <?php //echo '<pre>'; print_r($edit_data);exit;?>
                <?php  foreach($edit_data as $row):?>
                    <?php echo form_open(base_url() . 'index.php?hostel_admin/manage_profile/update_profile_info' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top' , 'enctype' => 'multipart/form-data'));?>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="name" value="<?php echo $row['name'];?>" data-validate = "required"  data-message-required="Please enter a name"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('email');?></label>
                        <div class="col-sm-5">
                            <input type="email" class="form-control" name="email" data-validate = "required" data-message-required="Please enter a valid email"value="<?php echo $row['email'];?>"/>
                        </div>
                    </div>
               
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('photo');?></label>
                    <div class="col-sm-5">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">

                            <img src="<?php echo ($row['image']!=" "?"uploads/hostel_admin_image/".$row['image']:"uploads/user.jpg");?>" alt="...">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                            <div>
                                <span class="btn btn-white btn-file">
                                    <span class="fileinput-new">Select image</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" name="userfile" accept="image/*">
                                </span>
                                <a href="#" id= "remove" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                        </div>
                    </div>
                </div>
              
                <div class="form-group">
                  <div class="text-center">
                      <button type="submit" class="btn btn-primary"><?php echo get_phrase('update_profile');?></button>
                  </div>
                </div>
                <?php echo form_close();?>
                <?php endforeach;?>
            </div>
	</div>
    </div>
</div>

<br>

<!--password-->
<div class="row">
    <div class="col-md-12">    
    	<!------CONTROL TABS START------>
        <ul class="nav nav-tabs bordered">
            <li class="active">
            <a href="#list" data-toggle="tab"><i class="entypo-lock"></i> 
                                    <?php echo get_phrase('change_password');?>
            </a></li>
        </ul>
    	<!------CONTROL TABS END------>
        <div class="tab-content">
        <br>
        	<!----EDITING FORM STARTS---->
            <div class="tab-pane box active" id="list" style="padding: 5px">
                <div class="box-content padded">
		<?php foreach($edit_data as $row): ?>
                    <?php echo form_open(base_url() . 'index.php?hostel_admin/manage_profile/change_password' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('current_password');?></label>
                            <div class="col-sm-5">
                                <input type="password" class="form-control" name="password" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('new_password');?></label>
                            <div class="col-sm-5">
                                <input type="password" class="form-control" name="new_password" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('confirm_new_password');?></label>
                            <div class="col-sm-5">
                                <input type="password" class="form-control" name="confirm_new_password" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                          <div class="text-center">
                              <button type="submit" class="btn btn-primary"><?php echo get_phrase('update_password');?></button>
                          </div>
                        </div>
                    <?php echo form_close();?>
		<?php endforeach; ?>
                </div>
	    </div>
        </div>
    </div>
</div>
