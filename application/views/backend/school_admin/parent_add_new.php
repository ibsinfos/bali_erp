<?php
   // $this->load->helper('dynamic_form_function_helper');
 ?>   
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
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>


<?php echo form_open(base_url() . 'index.php?school_admin/parent_add/create/', array('class' => 'validate', 'id' => 'add_parent_form', 'enctype' => 'multipart/form-data')); ?>
<?php if (isset($msg)) { ?>        
    <div class="alert alert-danger">
        <?php echo $msg; ?>
    </div>
<?php } ?>
<div class="row white-box">
 <?php
    create_dynamic_form($arrDynamic,$arrGroups, $arrLabel, $arrAjaxEvent, $arrValidation, $arrFieldValue, $arrFieldQuery,
            $arrDbField, $arrClass, $arrPlaceHolder, $arrMin, $arrMax, $arrPost);
 
    echo "<div class='col-md-12 text-center'>
            <button type='submit' class='fcbtn btn btn-danger btn-outline btn-1d'>Add Parent</button>
          </div>";

 echo form_close(); ?>
</div>


<script type="text/javascript">
    function checkPasswordMatch() {
        var password = $("#password").val();
        var confirmPassword = $("#re_password").val();

        if (password != confirmPassword)
            $("#divCheckPasswordMatch").html('<font color="error">Passwords do not match!</span>');
        else
            $("#divCheckPasswordMatch").html('<font color="success">Passwords match!</span>');
    }


    /*function validate_email(email) {
        $('#parent_email_error').hide();
        email = encodeURIComponent(email);
        mycontent = $.ajax({
            async: false,
            dataType: 'json',
            type: 'POST',
            url: "<?php echo base_url(); ?>index.php?Ajax_controller/check_email_exist_allusers/",
            data: {email: email},
            success: function (response) {
                if (response.email_exist == "1") {
                    $('#parent_email_error').html(response.message).show();
                    $('#email').val('');
                    $('#email').focus();
                    return false;
                } else {
                    return true;
                }
            },
            error: function (error_param, error_status) {

            }
        });


    }*/

    $(document).ready(function () {
        $(".datepicker").datepicker({
            dateFormat: "dd/mm/yy",
            changeMonth: true,
            changeYear: true,
            autoclose: true
        });

       /* $('#email').change(function () {
            email = $(this).val();
            validate_email(email);
        });*/

    });

</script>
<script type="text/javascript">
    jQuery(document).ready(function () {
        
    });

      $('#country').change(function () {
        var CountryId = $('#country').val();
        if (CountryId != '') {
            var state = '<option value="">Select State</option>';
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?ajax_controller/get_state',
                type: 'POST',
                data: {CountryId: CountryId},
                success: function (response) {
                    if (response) {
                        data = JSON.parse(response);
                        if (data.length) {
                            for (k in data) {
                                state += '<option value="' + data[k]['location_id'] + '">' + data[k]['name'] + '</option>';
                            }
                        } else {
                            alert('State not found');
                        }
                    } else {
                        alert('State not found');
                    }
                    $('#state').empty();
//                    $('#state').html(state);
                      jQuery('#state').html(state).selectpicker('refresh');
                },
                error: function () {
                    alert('State not found');
                    $('#state').empty();
                    $('#state').html(state);
                }
            });
        }
    });
</script>
<SCRIPT language=Javascript>
   
   </SCRIPT>