<div class="modal-body">
    <?php echo form_open(base_url() . 'index.php?school_admin/device/create/', array('class' => 'validate', 'enctype' => 'multipart/form-data')); ?>
    <div class="form-horizontal form-material">
        <div class="form-group">
            <div class="col-md-12 m-b-20">
            <label>Add Device Name</label><span class="error" style="color: red;"> *</span>
            <input type="text" class="form-control" name="Name" required placeholder="Please Enter Device Name">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12 m-b-20">
            <label>Add IMEI Number</label><span class="error" style="color: red;"> *</span>
            <input type="text" class="form-control" name="Imei" required placeholder="Please Enter IMEI Number" onkeypress="return isNumber(event)">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12 m-b-20">
            <label>Add SIM Number</label><span class="error" style="color: red;"> *</span>
            <input type="text" class="form-control" name="SIM" required placeholder="Please Enter SIM Number" onkeypress="return isNumber(event)">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12 m-b-20">
                <label>Select Location</label><span class="error" style="color: red;"> *</span>
                <?php
                $deviceLocationData = array(
                    'india' => 'India',
                    'dubai' => 'Dubai',
                    'saudi_aribia' => 'Saudi Arabia'
                );  ?>
                <select class="selectpicker" data-style="form-control" data-live-search="true" name="Location" id="Location" >
                    <?php foreach ($deviceLocationData as $k => $v) { ?>
                    <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="text-right">
                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('add_device');?></button>
            </div>
        </div>
    </div>
    <?php echo form_close();?>
</div>

<script type="text/javascript">
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>