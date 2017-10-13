<!-- <link href="<?php echo base_url(); ?>assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">	
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script> -->
<div class="row">
    <div class="col-md-12">
        <?php echo form_open(base_url() . 'index.php?school_admin/counselling/' . $param2); ?>
        <div class="form-group">
            <label class="control-label"><?php echo get_phrase('date'); ?></label>
            <input type="text" class="form-control " name="date"  value="" id="dtmpicker"
                   data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" required="required"/>
        </div>
        <div class="form-group">
            <div class="col-md-12 text-right no-padding">
                <button type="submit" class="fcbtn btn btn-danger btn-outline"><?php echo get_phrase('send_message'); ?></button>
            </div>
        </div>
        <?php echo form_close(); ?>

    </div>
</div>

<script>
    $(function () {
        $('#dtmpicker').datetimepicker({startDate:new Date()});
    });

    $("#type").click(function () {
        $("#fees_label").show();
    });
    $("#type").click(function () {
        $("#fees_paid_label").show();
    });
    $("#type").click(function () {
        $("#fees_paid").show();
    });
</script>


<script>
    /* $("#type").click(function () {
        var num1 = $("#type").val();
        $('#counter').html(num1);
        document.getElementById('myField').value = num1;
        var num2 =<?php //echo $amount_paid; ?>
        $('#counter3').html(num2);
        var difference = parseInt(num1) - parseInt(num2);
        if (difference > 0) {
            $('#counter1').html(difference);
            $('#counter4').hide();
            $('#counter1').show();
            $('#msg').show();
        } else {
            var message = "No balance amount to be paid, already has advance amount";
            $('#counter4').html(message);
            $('#counter1').hide();
            $('#msg').hide();
            $('#counter4').show();
        }
    }); */
</script>

