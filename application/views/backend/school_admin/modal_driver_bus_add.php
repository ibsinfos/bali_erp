<div class="row">
    <div class="col-md-12">
        <?php echo form_open(base_url() . 'index.php?school_admin/bus_driver/create', array('class' => 'form-horizontal form-material form-groups-bordered validate')); ?>

        <div class="form-group">
            <div class="col-md-12 m-b-20">
                <label><?php echo get_phrase('name'); ?><span class="mandatory"> *</span></label>
                <input type="text" class="form-control" name="name" data-validate="required" placeholder="Please Enter Name" data-message-required="<?php echo get_phrase('value_required'); ?>"  autofocus value="" required="required">
            </div>
        </div>

        <div class="form-group">

            <div class="col-md-12 m-b-20">
                <label><?php echo get_phrase('email'); ?><span class="mandatory"> *</span></label>
                <input onblur="checkEmail(this.value)" data-validate="required" placeholder="Please Enter Email" id="bus_driver_email" type="text" class="form-control" name="email" value="" required="required">
                <span id="error_email" style="color:red;"></span>

            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12 m-b-20">
                <label><?php echo get_phrase('phone'); ?><span class="mandatory"> *</span></label>
                <input type="text" class="form-control" name="phone" placeholder="Please Enter Phone" maxlength="10" onkeypress='return valid_only_numeric(event);' value="" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" required="required">
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12 m-b-20">
                <label><?php echo get_phrase('gender'); ?><span class="mandatory"> *</span></label>
                <select name="gender" class="selectpicker1" data-style="form-control" data-live-search="true">
                    <option>Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
        </div>                
        <div class="form-group">
            <div class="col-md-12 m-b-20">
                <label><?php echo get_phrase('bus_unique_key'); ?><span class="mandatory"> *</span></label>
                <select name="bus_id" class="selectpicker1" data-style="form-control" data-live-search="true" data-validate="required" required="required">
                    <option value="">Select a Bus</option>
                    <?php foreach ($buses as $bus) : ?>
                        <option value="<?php echo $bus['bus_id']; ?>"><?php echo $bus['bus_unique_key']."-". $bus['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>                
        <div class="form-group">
            <div class="col-sm-12 text-right">
                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('add_bus_driver'); ?></button>
            </div>
        </div>                
        <?php echo form_close(); ?>
    </div>
</div>
<script>
    function valid_only_numeric(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }</script>

<script language="javascript">
    function checkEmail() {
        var email = document.getElementById('bus_driver_email');
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        if (!filter.test(email.value)) {
            document.getElementById("error_email").innerHTML = "Please Enter Correct Email";
            email.focus;
            return false;
        }
    }</script>