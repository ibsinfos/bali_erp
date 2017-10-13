<div class="row bg-title"> 
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?super_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?super_admin/link_module"><?php echo get_phrase('manage_link_module'); ?></a></li>
            <li class="active"> <span><?php echo get_phrase($page_title); ?></span></li>
            
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>   
<?php foreach ($edit_data as $data): ?>
    <div class="row">
        <div class="col-md-12 white-box">
            <div class="panel-body">
                <?php echo form_open(base_url() . 'index.php?super_admin/link_module/update/' . $data['id'], array('class' => 'form-groups-bordered validate', 'target' => '_top', 'enctype'=>'multipart/form-data')); ?>

            <div class="row">
            <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                         <label for="field-1"><?php echo get_phrase('link_name');?><span class="error mandatory"> *</span></label>
                        <input type="text" class="form-control" placeholder="Link Name" name="name" value="<?php echo $data['name']; ?>" data-validate="required" data-message-required="<?php echo get_phrase('please_enter_required_value'); ?>" required="required"/>
                    </div>
            </div>
            <div class="row">
            <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                        <label for="field-1"><?php echo get_phrase('path');?></label>
                        <input type="text" class="form-control" placeholder="Link" name="link" value="<?php echo $data['link']; ?>" data-validate="required" data-message-required="<?php echo get_phrase('please_enter_required_value'); ?>" required="required"/>
            </div>
            </div>
            <div class="row">
            <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                        <label for="field-1"><?php echo get_phrase('Select_user_Type');?><span class="error mandatory"> *</span></label>
                        <select name="user_type" data-style="form-control" data-live-search="true" class="selectpicker1" required="required">
                            <option value="">Select User Type</option>
                            <option value="T" <?php if($data['user_type']=="T")echo "selected";?>>Teacher</option>
                            <option value="P" <?php if($data['user_type']=="P")echo "selected";?>>Parent</option>
                            <option value="S" <?php if($data['user_type']=="S")echo "selected";?>>Student</option>
                            <option value="A" <?php if($data['user_type']=="U")echo "selected";?>>Admin</option>
                        </select>
            </div>
            </div>
            <div class="row">
            <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                        <label for="field-1"><?php echo get_phrase('order');?></label>
                        <input type="text" class="form-control" name="order"  value="<?php echo $data['orders']; ?>">                                                </div>
            </div>
            <div class="row">
            <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                        <label for="field-1"><?php echo get_phrase('parent_link');?><span class="error mandatory"> *</span></label>
                        <select data-style="form-control" data-live-search="true" class="selectpicker" name="parent_id" id="parent_id">                                       
                            <option value="">Select Parent Link</option>
                            <?php foreach($parent_links as $key => $value){?>
                                <option value="<?php echo $value['id'];?>" <?php if($value['id'] == $data['parent_id'])echo "selected";?>>
                                    <?php echo $value['name']?>
                               </option>
                            <?php }?>
                        </select>
            </div>
            </div>
            <div class="row">
            <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                        <label for="field-1"><?php echo get_phrase('Module_image');?></label>
                        <div class="col-sm-12 no-padding">
                           <input type="file" id="input-file-now" class="dropify" name="linkmodulefile" /> 
                        </div><br><br>
                        <input  type="text" name="image" value="<?php echo $data['image'];?>" readonly="readonly">
                    </div>    
                </div>
            </div>
                <div class="form-group">
                    <div class="col-md-12 text-right">
                          <button type="submit"  class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><?php echo get_phrase('update'); ?></button>
                    </div>
                </div>
                    <?php echo form_close();?>
                </div>

        </div>
    </div>
        <?php
    endforeach;
?>