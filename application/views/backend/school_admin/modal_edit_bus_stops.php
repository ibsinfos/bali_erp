<?php 
echo form_open(base_url() . 'index.php?school_admin/route_bus_stop/edit/'.$row['route_bus_stop_id'], array('class' => 'form-horizontal form-material form-groups-bordered validate', 'target' => '_top')); ?>
<div class="form-group">
         <div class="col-md-12 m-b-20">
    <label><?php echo get_phrase('route_name'); ?><span class="error mandatory"> *</span></label>
    <select class="selectpicker1" data-style="form-control" data-live-search="true" id="route_id" name="route_id" required="required" disabled="">
            <option value=""><?php echo get_phrase('select_option'); ?></option>
                <?php foreach ($route as $value): ?>
                <option value="<?php echo $value['transport_id']; ?>" <?php  if ($row['route_id'] == $value['transport_id']) { echo "selected"; } ?>><?php echo $value['route_name']; ?>
                </option>
                <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-12 m-b-20">
    <label><?php echo get_phrase('bus_stop_from'); ?><span class="error mandatory"> *</span></label>
    <input type="text" class="form-control" name="route_from" required="required" value="<?php echo $row['route_from']; ?>">
    </div>

 <div class="col-md-12 m-b-20">
    <label><?php echo get_phrase('bus_stop_to'); ?><span class="error mandatory"> *</span></label>
    <input type="text" class="form-control" name="route_to" required="required" value="<?php echo $row['route_to']; ?>">
    </div>

<!--<div class="col-md-12 m-b-20">
    <label><?php echo get_phrase('number_of_stops'); ?><span class="error mandatory"> *</span></label>
  <input type="text" class="form-control numeric" name="number_of_stops" required="required" value="<?php echo $row['no_of_stops']; ?>">

</div>-->
<div class="col-md-12 m-b-20">
    <label><?php echo get_phrase('route_fare'); ?><span class="error mandatory"> *</span></label>
    <?php if(sett('new_fi')){?>
    <input type="number" min="1" class="form-control" name="route_fare" placeholder="<?php echo get_phrase('route_fare');?>" value="<?php echo $row['route_fare']?>" required disabled=""/>
    <?php }else{?>
        <select class="selectpicker" data-style="form-control" data-live-search="true" id="route_fare" name="route_fare" required="required" data-max-options="2" disabled="">
        <?php foreach ($charges as $charge): ?>
            <option <?php
            if ($row['route_fare'] == $charge['sales_price']) {
                echo 'selected';
            }?> value="<?php echo $charge['sales_price'] . '|' . $charge['id']; ?>">
                <?php echo $charge['sales_price'] . "---" . $charge['name']; ?></option>
            <option value=""><?php echo get_phrase('select_option'); ?></option>
        <?php endforeach; ?>
    </select>
    <?php }?>
</div>
<div class="col-md-12 m-b-20 text-right">
    <button class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('Update_bus_stop'); ?></button>
    </div>
</div>

<?php echo form_close(); ?>               
 
