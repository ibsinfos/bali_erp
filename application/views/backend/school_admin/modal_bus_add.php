<div class="row">
    <div class="col-md-12">
        <?php echo form_open(base_url() . 'index.php?school_admin/bus/create', array('class' => 'form-material form-groups-bordered validate')); ?>


        <div class="form-group">                   
            <div class="col-md-12 m-b-20"><label><?php echo get_phrase('name'); ?><span class="mandatory">*</span></label>
                <input type="text" class="form-control" name="name" required="required" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" placeholder="Please Enter Bus Name" autofocus value="">
                <label class="mandatory"> <?php echo form_error('name'); ?></label>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12 m-b-20"><label><?php echo get_phrase('unique_key'); ?><span class="mandatory">*</span></label>
                <input data-validate="required" type="text" required="required" class="form-control" name="key" value="" placeholder="Please Enter Key">
                <label class="mandatory"> <?php echo form_error('key'); ?></label>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12 m-b-20"><label><?php echo get_phrase('description'); ?><span class="mandatory">*</span></label>
                <textarea data-validate="required" required="required" name="description" class="form-control" placeholder="Please Enter Description"></textarea>
                <label class="mandatory"> <?php echo form_error('description'); ?></label>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12 m-b-20"><label><?php echo get_phrase('imei'); ?><span class="mandatory">*</span></label>
                <input data-validate="required" required="required" type="text" class="form-control" name="imei"  placeholder="Please Enter IMEI">
                <label class="mandatory"><?php echo form_error('imei'); ?></label>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12 m-b-20"><label><?php echo get_phrase('route'); ?><span class="mandatory">*</span></label>
                <select required="required" name="route" class="selectpicker1" data-style="form-control" data-live-search="true">
                    <option value="">Select a route</option>
                    <?php foreach ($routes as $route) : ?>
                        <option value="<?= $route['transport_id']; ?>"><?= $route['route_name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <label class="mandatory"> <?php echo form_error('route'); ?></label>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12 m-b-20"><label><?php echo get_phrase('no_of_seats'); ?><span class="mandatory">*</span></label>
                <input type="text" required="required" data-validate="required" name="no_of_seat" class="form-control numeric" placeholder="<?php echo get_phrase('number of_seat'); ?>">
                <label  class="mandatory"> <?php echo form_error('no_of_seat'); ?></label>
            </div>
        </div>                
        <div class="form-group">
            <div class="col-sm-12 text-right">
                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('add_bus'); ?></button>
     
            </div>
        </div>                
        <?php echo form_close(); ?>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function () {
        $(".numeric").numeric();
    });
</script>