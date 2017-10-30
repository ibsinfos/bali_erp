        <div class="panel-body">
        <?php foreach($edit_data as $row):?>
        <?php echo form_open(base_url() . 'index.php?school_admin/transport/do_update/'.$row['transport_id'] , array('class' => 'form-horizontal form-material form-groups-bordered validate','target'=>'_top'));?>
            <div class="padded">
                <div class="form-group"> 
                    <div class="col-md-12 m-b-20">
                         <label><?php echo get_phrase('route_name'); ?><span class="error mandatory"> *</span></label>
                        <input type="text" class="form-control" name="route_name" value="<?php echo $row['route_name'];?>"
                               data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" placeholder="Route Name" required="required"/>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12 m-b-20">
                        <label><?php echo get_phrase('description'); ?><span class="error mandatory"> *</span></label>
                        <input type="text" class="form-control" name="description" value="<?php echo $row['description'];?>" placeholder="Decription" required="required"/>
                    </div>
                </div>

            </div>
            <div class="form-group">
              <div class="col-md-12 text-right">
                  <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d m-l-20 hidden-xs hidden-sm waves-effect waves-light"><?php echo get_phrase('update');?></button>
              </div>
            </div>
        <?php echo form_close();?>
        <?php endforeach;?>
        </div>
        
  