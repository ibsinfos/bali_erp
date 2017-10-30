<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $system_name . " Login" ?></title>
        <!--newone-->
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/images/logo_ag.png">
        <!-- Bootstrap Core CSS -->
        <link href="<?php echo base_url(); ?>assets/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- animation CSS -->
        <link href="<?php echo base_url(); ?>assets/css/animate.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
        <!-- Custom style CSS -->
        <link href="<?php echo base_url(); ?>assets/css/custom-style.css" rel="stylesheet">
        <!-- color CSS -->
        <link href="<?php echo base_url(); ?>assets/css/colors/blue.css" id="theme"  rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/sweetalert/sweetalert.css">
        <?php $system_name = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;
              $system_title = $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;?>
        <!--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">-->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    </head>

    <script type="text/javascript">
    $(document).ready(function () {
        var remember_email = '<?php echo isset($_COOKIE['user_email']) ? $_COOKIE['user_email'] : ''; ?>';
        var remember_pass = '<?php echo isset($_COOKIE['user_password']) ? $_COOKIE['user_password'] : ''; ?>';
        //console.log(remember_pass);return false;

        if ((remember_email != '') && (remember_pass != '')) {
            //return false;
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>index.php?ajax_controller/ajax_login/',
                data: {email: remember_email, password: remember_pass, remember_me: '0'},
                success: function (response) {
                    debugger;
                    var result = JSON.parse(response);
                    debugger;

                    var redirect_url = '';
                    var user_type = result.user_type;
                    if (user_type == 'admin') {
                        redirect_url = '<?php echo base_url(); ?>index.php?admin/dashboard/';
                    } else if (user_type == 'librarian') {
                        redirect_url = '<?php echo base_url(); ?>index.php?librarian/dashboard/';
                    } else if (user_type == 'student') {
                        redirect_url = '<?php echo base_url(); ?>index.php?student/dashboard/';
                    } else if (user_type == 'parent') {
                        redirect_url = '<?php echo base_url(); ?>index.php?parents/dashboard/';
                    } else if (user_type == 'bus_driver') {
                        redirect_url = '<?php echo base_url(); ?>index.php?bus_driver/dashboard/';
                    } else if (user_type == 'bus_administrator') {
                        redirect_url = '<?php echo base_url(); ?>index.php?bus_admin/dashboard/';
                    } else if (user_type == 'hostel_admin') {
                        redirect_url = '<?php echo base_url(); ?>index.php?hostel_admin/dashboard/';
                    } else if (user_type == 'teacher') {
                        redirect_url = '<?php echo base_url(); ?>index.php?teacher/dashboard/';
                    }

                    //console.log(redirect_url,result.user_type);return false;
                    if (redirect_url != '') {
                        window.location.href = redirect_url;
                    } 
                    debugger;  
                }
            });
        }
    });
    </script>

    <script type="text/javascript">
        //<![CDATA[
        var baseurl = '<?php echo base_url(); ?>';
        // URL for access ajax data
        myJsMain = window.myJsMain || {};
        myJsMain.baseURL = '<?php echo base_url(); ?>';
        myJsMain.securityCode = '<?php echo $this->session->userdata("secret");?>';
        <?php if ($this->session->userdata('login_type') == ''): ?>
            myJsMain.isLogedIn = false;
        <?php else: ?>
            myJsMain.isLogedIn = true;
        <?php endif; ?>

        myJsMain.SecretTextSetAjaxURL = '<?php echo base_url() . 'ajax/reset_secret/' ?>';
        myJsMain.CaptchaCookeName = '<?php echo $this->config->item('CAPTCHA_COOKIE_NAME'); ?>';
        //]]>
        manualClick = false;
        var dialog = null;
    </script>

    <body>
        <style type="text/css">
            .capt_error{display: none; color: red;}
            #CaptchaImg{margin-top: 22px; margin-left: 16px;}
            #reload_img{width: 35px; height: 35px; cursor: pointer;}
            #form_login > h3 > a{color:blue !important;}
            .bootbox-body{color: red;}
            .succed{color: green !important;}
        </style>

        <section id="wrapper" class="login-register">

            <div class="login-box login-sidebar">
                <div class="white-box">
                    <a href="javascript:void(0)" class="text-center db m-b-20"><img src="<?php echo base_url(); ?>assets/images/logo_ag.png" alt="Home" style="width: 170px; height: 35px;"/></a>  

                    <form method="post" id="form_login" novalidate="novalidate" class="form-horizontal form-material loginform1">


                        <div class="form-group m-t-40">
                            <div class="col-xs-12">
                                <input type="text" class="form-control"  name="email" id="email" placeholder="Email address" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input type="password"  name="password" id="password" placeholder="Password" autocomplete="off" style="cursor: auto;" class="form-control">
                            </div>
                        </div>
                        <?php //if($this->session->userdata('login_failed') > 3 ){?>
                        <div class="captcha_outer">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input type="text" class="form-control" id="captcha" placeholder="Enter below captcha text here" name="captcha">
                                </div>
                            </div>
                            <p class="capt_error">Captcha doesn't match.</p>
                            <div class="form-group">
                                <span id="CaptchaImg"><?php echo $captcha['image']; ?></span>
                                <span id="RefreshCaptcha">&nbsp;&nbsp;<img src="<?php echo base_url(); ?>assets/images/reload.png" id="reload_img"></span>
                            </div>
                        </div><?php //}      ?>

                        <input type="hidden" id="CaptWord" value="<?php echo $captcha['word']; ?>" />

                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="checkbox checkbox-primary pull-left p-t-0">
                                    <input id="remember_me" type="checkbox" value="1" name="remember_me">
                                    <label for="remember_me"> Remember me </label>
                                </div>
                <!--                <a onclick="forgotpassword()" href="#" id="to-recover" class="text-dark pull-right"><i class="ti ti-lock m-r-5"></i> Forgot password?</a> -->
                                <a href="#" id="to-recover" class="text-dark pull-right"><i class="ti ti-lock m-r-5"></i> Forgot password?</a>
                            </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <div class="submit">
                                    <button id="submit" name="submit" class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                                </div>
                            </div>
                        </div>
                    <!--<h3 class="text-center lb_login"> <a data-toggle="modal" data-target="#myModal1">Register For Alumni</a> </h3>-->
                        <!-- <h3 class="text-center lb_login"> <a href="<?php echo base_url() . 'lms/home/login'; ?> ">Librarian Login</a></h3> -->
                    </form> 

                    <form class="form-horizontal" id="recoverform">
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <h3>Recover Password</h3>
                                <p class="text-muted">Enter your email for resetting password</p>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" required="" placeholder="Email" id="forgot_email">
                            </div>
                        </div>
                        <h4 class="mandatory success"></h4>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit" id="reset_password">Reset</button>
                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="button" onclick="window.location='<?php echo base_url(); ?>';">Back to Login</button>
                            </div>
                        </div>
                    </form> 
                </div>
            </div>
        </section>

        <input type="hidden" id="baseurl" name="baseurl" value="<?php echo base_url(); ?>" />        
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                Modal content
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modal Header</h4>
                    </div>
                    <div class="modal-body">
                        <p>Some text in the modal.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Model For Alumni Register -->
  <div class="modal fade" id="myModal1" role="dialog">
            <div class="modal-dialog">                
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Alumni Registration</h4>
                    </div>
                    <div class="modal-body">
                        <?php echo form_open(base_url() . 'index.php?alumni/register/create/', array('class' => 'form-horizontal form-material form-groups-bordered validate','target'=>'_top'));?> 
                        <div class="form-group">
                            <div class="col-md-12 m-b-20">
                                <label><?php echo get_phrase('email'); ?><span class="error" style="color: red;"> *</span></label>
                                <input type="text" class="form-control" name="email" placeholder="Email" value="" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" required="required"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 m-b-20">
                                <label><?php echo get_phrase('Password'); ?><span class="error" style="color: red;"> *</span></label>
                                <input type="password" class="form-control" name="password" placeholder="Password" value="" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" required="required"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 m-b-20">
                                <label><?php echo get_phrase('name'); ?><span class="error" style="color: red;"> *</span></label>
                                <input type="text" class="form-control" name="name" placeholder="First Name" value="" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" required="required"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 m-b-20">
                                <label><?php echo get_phrase('middle_name'); ?></label>
                                <input type="text" class="form-control" name="mname" placeholder="Middle Name" value="" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 m-b-20">
                                <label><?php echo get_phrase('last_name'); ?></label>
                                <input type="text" class="form-control" name="lname" placeholder="Last Name" value="" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 m-b-20">
                                <label><?php echo get_phrase('gender'); ?><span class="error" style="color: red;"> *</span></label>
                                <input type="radio" name="gender" value="M" checked=""/>Male &nbsp;&nbsp;
                                <input type="radio" name="gender" value="F"/>Female
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 m-b-20">
                                <label><?php echo get_phrase('date_of_birth'); ?><span class="error" style="color: red;"> *</span></label>
                                <input type="text" class="form-control datepicker" name="dob" placeholder="Date Of Birth" data-message-required="<?php echo get_phrase('value_required'); ?>" required="required"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 m-b-20">
                                <label><?php echo get_phrase('Enroll_number'); ?><span class="error" style="color: red;"> *</span></label>
                                <input type="text" class="form-control" name="enroll_no" placeholder="Enroll Number" value="" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" required="required"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 m-b-20">
                                <label><?php echo get_phrase('class_name'); ?><span class="error" style="color: red;"> *</span></label>
<!--                                <input type="text" class="form-control" name="class_name" placeholder="Class Name" value="" data-validate="required" data-message-required="<?php // echo get_phrase('value_required'); ?>" required="required"/>-->
                                <?php // pre($classArr); ?>
                                <select name="class_name" class="form-control" data-style="form-control" data-live-search="true">
                                    <option value="">Select Class</option>
                                    <?php  foreach($classArr as $row): ?>
                                    <option value="<?php echo $row['class_id'] ?>"><?php echo $row['name']; ?></option>
                                   <?php  endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 m-b-20">
                                <label><?php echo get_phrase('year'); ?><span class="error" style="color: red;"> *</span></label>
                                <input class="date-own form-control" name="year" type="text" placeholder="Year" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                       <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('register');?></button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                        
                        <?php echo form_close(); ?>
                    </div>                    
                </div>
        <!-- End Alumni Register -->
    </body> 

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <!---->
    <script src="<?php echo base_url(); ?>assets/js/old_js/jquery.validate.min.js" type="text/javascript"></script> 
    <script src="http://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/old_js/sharad-common.js"></script>   
    <script src="<?php echo base_url(); ?>assets/js/old_js/neon-login.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.2/TweenMax.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.2/TimelineMax.min.js'></script>    
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url(); ?>assets/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="<?php echo base_url(); ?>assets/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>

    <!--slimscroll JavaScript -->
    <script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="<?php echo base_url(); ?>assets/js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url(); ?>assets/js/custom.min.js"></script>
    <!--Style Switcher -->
    <script src="<?php echo base_url(); ?>assets/bower_components/styleswitcher/jQuery.style.switcher.js"></script>  
    <script src="<?php echo base_url();?>assets/sweetalert/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
      $('.date-own').datepicker({
         minViewMode: 2,
         format: 'yyyy'
       });
       
        $('.datepicker').datepicker({
        format: 'mm/dd/yyyy',
});

$(document).ready(function () {
    $('#to-recover').on("click", function () {
        $(".loginform1").slideUp();
        $("#recoverform").fadeIn();
    });

    if ('<?php echo $this->session->userdata('login_failed'); ?>' >= 3) {
        $('.captcha_outer').show();
    } else {
        $('.captcha_outer').hide();
    }

    $('#submit').click(function () {
        var capt_failed = '<?php echo $this->session->userdata('login_failed'); ?>';
        var captcha = $('#captcha').val();
        var CapImg = $('#CaptWord').val();
        if (capt_failed >= 3) {
            if(captcha==''){
                $('.capt_error').html('Captcha is required.');
                $('.capt_error').show();
                return false;
            }else if (captcha === CapImg) {
                $('.capt_error').hide();
                return true;
            } else {
                $('.capt_error').html('Mismatched captcha.');
                $('.capt_error').show();
                return false;
            }
        }
    });

    $('#RefreshCaptcha').click(function () {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?login/refresh_captcha/',
            success: function (response) {
                if (response) {
                    var result = JSON.parse(response);
                    $('#CaptchaImg').empty();
                    $('#CaptchaImg').html(result['image']);
                    $('#CaptWord').val(result['word']);
                }
            }
        });
    });


    $('#reset_password').click(function () {
        var email = $.trim($('#forgot_email').val());
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

        if (email == '') {
            $('.success').html('<center class="error">Please enter your email id</center');
            return false;
        } else {
            $('.success').empty();
        }


        if (email != "" && emailReg.test(email)) {
            $('.success').html('<center class="error">Please wait while processing ...</center');

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>index.php?login/ajax_forgot_password/',
                data: {email: email},
                success: function (response) {
                    var data = JSON.parse(response);
                    $('.success').removeClass('mandatory');
                    $('.success').addClass('succed');
                    $('.success').empty();
                    $('.success').html(data.message);
                }
            });
            return false;
        } else {
            $('.success').html('<center class="error">Incorrect Email Id</center');
        }

        return false;
    });
});
</script>
<?php if ($this->session->flashdata('flash_message') != ""):?>
<script type="text/javascript">
var msg = '<?php echo json_encode($this->session->flashdata("flash_message"));?>';
EliminaTipo1(msg);
function EliminaTipo1(){
    //swal(msg);
    swal(msg,'','success')
}
</script>
<?php endif; ?>

<?php if($this->session->flashdata('flash_message_error') != ""):?>
<script type="text/javascript">
var msg = '<?php echo json_encode($this->session->flashdata("flash_message_error"));?>';
EliminaTipo5(msg);
function EliminaTipo5(){
//	swal(msg);
// alert(":shdgfjsgfhj");
    swal(
      msg,''
      ,
      'error'
    )
}
</script>
<?php endif;?>

</html>