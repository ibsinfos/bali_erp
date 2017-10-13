<?php $this->load->view('admin/theme/message'); ?>
<section class="content-header">
   <section class="content">
        <div class="box box-info custom_box">
            <div class="box-header">
                <h3 class="box-title"><?php echo $this->lang->line('my Account');?></h3>
            </div><!-- /.box-header -->

<!------CONTROL TABS START------>
            <ul class="nav nav-tabs bordered">
                <li class="active" >
                    <a href="#list3" data-toggle="tab"><i class="entypo-lock"></i><?php echo 'My Profile';?></a>
                </li>
                <li >
                    <a href="#list1" data-toggle="tab"><i class="entypo-user"></i><?php echo 'Manage Profile';?></a>
                </li>
                <li >
                    <a href="#list2" data-toggle="tab"><i class="entypo-lock"></i><?php echo 'Change Password';?></a>
                </li>
                <li style="float: right;">
<?php if($this->session->flashdata('success_profile')){echo "<div class='alert alert-success text-center'><h6 style='margin:0;'><i class='fa fa-check-circle'></i> ".$this->session->flashdata('success_profile')."</h6></div>"; }else if($this->session->flashdata('flash_message_error')){ echo "<div class='alert alert-danger text-center'><h6 style='margin:0;'><i class='fa fa-remove'></i> ".$this->session->flashdata('flash_message_error')."</h6></div>";

    }?></li>
            </ul>

            <?php $pro_pic=base_url().'assets/images/profile_image/boy.png';
            if($edit_data[0]['profile_image']!=''){
                $pro_pic=base_url().'assets/images/profile_image/'.$edit_data[0]['profile_image'];}?>

            <div class="tab-content view-top">
                <div class="tab-pane box fade in active" id="list3">
                    <div class="box-content padded">
                        <div class="form-horizontal">
                            <div class="box-body">
                                <div class="form-group" style="float: right;">
                                    <div class="col-sm-8">
                                        <div class='text-center'><img class="img-responsive" src="<?php echo $pro_pic;?>" alt="Photo"/></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('name');?></label>
                                    <div class="col-sm-5">
                                        <span class="form-control"><?php echo $edit_data[0]['name'];?></span>
                                    </div>                                    
                                </div>
                            
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('email');?></label>
                                    <div class="col-sm-5">
                                        <span class="form-control"><?php echo $edit_data[0]['email'];?></span>
                                    </div>
                                </div>
                           
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('phone');?></label>
                                    <div class="col-sm-5">
                                        <span class="form-control"><?php echo $edit_data[0]['phone'];?></span>
                                    </div>
                                </div>
                            
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('birthday');?></label>
                                    <div class="col-sm-5">
                                        <span class="form-control"><?php echo $edit_data[0]['birthday'];?></span>
                                    </div>
                                </div>
                            
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('blood_group');?></label>
                                    <div class="col-sm-5">
                                        <span class="form-control"><?php echo $edit_data[0]['blood_group'];?></span>
                                    </div>
                                </div>
                            
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('religion');?></label>
                                    <div class="col-sm-5">
                                        <span class="form-control"><?php echo $edit_data[0]['religion'];?></span>
                                    </div>
                                </div>
                            
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('address');?></label>
                                    <div class="col-sm-5">
                                        <span class="form-control"><?php echo $edit_data[0]['address'];?></span>
                                    </div>
                                </div>   
                            </div> 
                        </div>     
                    </div><!-- /.box-info -->
                </div>

            <div class="tab-pane box " id="list1">
                <div class="box-content padded">
                    <form class="form-horizontal" enctype="multipart/form-data" action="<?php echo site_url().'admin/update_profile_info';?>" method="POST" >
                        <div class="box-body">
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo $this->lang->line('name');?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="name" value="<?php echo $edit_data[0]['name'];?>" required="required"/>
                                    <span class="red"><?php echo form_error('name'); ?></span>
                                </div>

                                <div class="col-sm-5">
                                    <div class='text-center'><img class="img-responsive" src="<?php echo $pro_pic;?>" alt="Photo"/></div>
                                    <?php echo $this->lang->line('allowed format');?> : png , jpeg, gif
                                    <input name="profile_image" type="file">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo $this->lang->line('phone');?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control numeric" name="phone" value="<?php echo $edit_data[0]['phone'];?>" required="required"/>
                                    <span class="red"><?php echo form_error('phone'); ?></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo $this->lang->line('date of birth');?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control datepicker" name="birthday" value="<?php echo $edit_data[0]['birthday'];?>" required="required"/><span class="red"><?php echo form_error('birthday'); ?></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo $this->lang->line('gender');?></label>
                                <div class="col-sm-4">
                                <select class="form-control" name="sex" required="required">
                                    <option value="Male" <?php if($edit_data[0]['sex']=='Male'){echo 'selected';}?>>Male</option>
                                    <option value="Female" <?php if($edit_data[0]['sex']=='Female'){echo 'selected';}?>>Female</option>
                                </select ><span class="red"><?php echo form_error('sex'); ?></span>                            
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo $this->lang->line('religion');?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="religion" value="<?php echo $edit_data[0]['religion'];?>" required="required"/><span class="red"><?php echo form_error('religion'); ?></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo $this->lang->line('blood group');?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="blood_group" value="<?php echo $edit_data[0]['blood_group'];?>" required="required"/><span class="red"><?php echo form_error('blood_group'); ?></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo $this->lang->line('address');?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="address" value="<?php echo $edit_data[0]['address'];?>" required="required"/><span class="red"><?php echo form_error('address'); ?></span>
                                </div>
                            </div>

                            <div class="form-group">
                              <div class="col-md-12 text-center">
                                  <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('update profile');?></button>
                              </div>
                            </div>       
                                           
                        </div> <!-- /.box-body --> 
                    </form>
                </div>                
            </div>


<div class="tab-pane box" id="list2">
                <div class="box-content padded">
        <?php foreach($edit_data as $row): ?>
                    <?php echo form_open(site_url('admin/reset_password_action') , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>

                        <div class="box-body">
                                
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo $this->lang->line('current password');?></label>
                            <div class="col-sm-5">
                                <input type="password" class="form-control" name="old_password" value="" required="required"/>
                                    <span class="red"><?php echo form_error('old_password'); ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo $this->lang->line('new password');?></label>
                            <div class="col-sm-5">
                                <input type="password" class="form-control numeric" name="new_password" value="" maxlength="8" required="required"/>
                                    <span class="red"><?php echo form_error('new_password'); ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo $this->lang->line('confirm new password');?></label>
                            <div class="col-sm-5">
                                <input type="password" class="form-control numeric" name="confirm_new_password" value="" maxlength="8" required="required"/>
                                    <span class="red"><?php echo form_error('confirm_new_password'); ?></span>
                            </div>                            
                        </div>
                        
                        <div class="form-group">
                          <div class="col-md-12 text-center">
                              <button type="submit" class="btn btn-primary"><?php echo 'Update Password';?></button>
                          </div>
                        </div>

                        </div>
                    <?php echo form_close();?>
        <?php endforeach; ?>
                </div>
        </div>




            </div>                 
        </div>
   </section>
</section>

<script type="text/javascript">
    jQuery(document).ready(function(){
       $(".numeric").numeric(); 
    });
    
    $j(function() {
        $( ".datepicker" ).datepicker();
    });
</script>