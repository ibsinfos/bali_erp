<div class="row">
    <div class="col-md-12">
        <?php echo form_open(base_url() . 'index.php?school_admin/bus/edit/' . $param2, array('class' => 'form-material form-groups-bordered validate')); ?>

        <div class="form-group">                    
            <div class="col-md-12 m-b-20"><label><?php echo get_phrase('bus_name'); ?><span class="mandatory">*</span></label>
                <input type="text" class="form-control" placeholder="Bus Name" name="name" required="required" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"  autofocus value="<?= $bus->name; ?>">
            </div>
            <span class="mandatory"> <?php echo form_error('name'); ?></span>
        </div>

        <div class="form-group">
            <div class="col-md-12 m-b-20"><label><?php echo get_phrase('unique_key'); ?><span class="mandatory">*</span></label>
                <input data-validate="required" type="text" placeholder="Please Enter Key" required="required" class="form-control" name="key" value="<?= $bus->bus_unique_key; ?>">

            </div>
            <label class="mandatory"> <?php echo form_error('key'); ?></label>
        </div>

        <div class="form-group">
            <div class="col-md-12 m-b-20"><label><?php echo get_phrase('description'); ?><span class="mandatory">*</span></label>
                <textarea data-validate="required" placeholder="Enter Please Description" required="required" name="description" class="form-control"><?= $bus->description; ?></textarea>
            </div>
            <label class="mandatory"> <?php echo form_error('description'); ?></label>
        </div>



        <div class="form-group">
            <div class="col-md-12 m-b-20"><label><?php echo get_phrase('no_of_seats'); ?><span class="mandatory">*</span></label>
                <input data-validate="required" type="text" placeholder="Enter No of Seats" required="required" class="form-control" name="no_of_seats" value="<?= $bus->number_of_seat; ?>">

            </div>
            <label class="mandatory"> <?php echo form_error('no_of_seat'); ?></label>
        </div>

        <div class="form-group">
            <div class="col-md-12 m-b-20"><label><?php echo get_phrase('route'); ?><span class="mandatory">*</span></label>
                <select data-validate="required" name="route" class="selectpicker1" data-style="form-control" data-live-search="true">
                    <option value="">Select a route</option>
                    <?php foreach ($routes as $route) : ?>
                        <option value="<?php echo $route['transport_id']; ?>" <?php if ($route['transport_id'] == $bus->route_id) {
                        echo 'selected';
                    } ?> ><?php echo $route['route_name']; ?></option>
<?php endforeach; ?>
                </select>
                <label class="mandatory"> <?php echo form_error('route'); ?></label>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12 text-right">
                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('update'); ?></button>
           </div>
        </div>                
<?php echo form_close(); ?>
    </div>
</div>
