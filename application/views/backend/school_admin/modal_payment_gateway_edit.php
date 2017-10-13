<?php 
foreach ( $payment_details as $row):
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
        <div class="panel-heading">
            <div class="panel-title" >
                    <i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('edit_payment_details');?>
            </div>
        </div>
        <div class="panel-body">
        <?php echo form_open(base_url() . 'index.php?school_admin/view_payment_details/edit/'.$row['gateway_id'] , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
        
            <div class="form-group">
                <label class="control-label col-sm-5" for="gateway_names"><?php echo get_phrase('gateway_names').":";?><span class="error" style="color: red;"> *</span></label>
                <div class="col-sm-5">
                    <select class="selectpicker1" data-style="form-control" data-live-search="true" name="gateway_names" id="gateway_names" required >
                        <option value=" "><?php echo get_phrase('select_payment_gateway');?></option>
                        <?php foreach ($payment_options as $vals){ ?>
                        <option value="<?php echo $vals;?>" <?php if($vals == $row['name']) echo 'selected';?> ><?php echo $vals;?></option> 
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="type_of_gateway"><?php echo get_phrase('type_of_gateway').":";?><span class="error" style="color: red;"> *</span></label>
                <div class="col-sm-5">          
                    <label class="radio-inline">
                        <input type="radio" name="type_of_gateway" value= "0" <?php if ($row['type'] == "0" ) echo 'checked="true"'; ?> required ><?php echo get_phrase('sandbox'); ?>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="type_of_gateway" value="1" <?php if ($row['type'] == "1" ) echo 'checked="true"'; ?> required><?php echo get_phrase('live'); ?>
                    </label>    
                </div>
            </div>
    
            <div class="form-group">
                <label class="control-label col-sm-5" for="endpoints"><?php echo get_phrase('endpoints');?>:<span class="error" style="color: red;"> *</span></label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="endpoints" placeholder=" " name="endpoints" required value = <?php echo $row['endpoints']; ?> >
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-5" for="username"><?php echo get_phrase('user_name');?>:<span class="error" style="color: red;"> *</span></label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="username" placeholder="" name="username" required value = <?php echo $row['username']; ?> >
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-5" for="password"><?php echo get_phrase('password');?>:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="password" placeholder="" name="password" value = <?php echo $row['password']; ?> >
                </div>
            </div>     
      
            <div class="form-group">
                <label class="control-label col-sm-5" for="hostname"><?php echo get_phrase('host_name');?>:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="hostname" placeholder="" name="hostname" value = <?php echo $row['hostname']; ?> >
                </div>
            </div>         

            <div class="form-group">        
                <label class="control-label col-sm-5" for="signature"><?php echo get_phrase('signature');?>:</label>
                <div class="col-sm-5">          
                    <input type="text" class="form-control" id="signature" placeholder="" name="signature" value = <?php echo $row['signature']; ?> >
                </div>
            </div>
            
            <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                            <button type="submit" class="btn btn-info"><?php echo get_phrase('edit_payment_details');?></button>
                    </div>
            </div>
        <?php echo form_close();?>
        
        </div>
        </div>
    </div>
</div>
<?php endforeach; ?>



