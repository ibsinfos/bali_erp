<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $this->config->item('product_name')." | Login"; ?></title>    
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.png"> 
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url();?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url();?>css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="<?php echo base_url();?>plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />

    <style>    
        .capt_error{color:red; display: none;}
        #RefreshCaptcha{cursor: pointer;}
    </style>

    <?php 
    //if($this->config->item("language")=="arabic")
    if($this->is_rtl) 
    { ?>
  		<style>
  		input{text-align:right !important;}
  		</style>
    <?php }
    ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <center><a href="<?php echo site_url();?>"><img src="<?php echo base_url();?>assets/images/logo.png" alt="<?php echo $this->config->item('product_name');?>" class="img-responsive"></a></center>
       </div><!-- /.login-logo -->
      <div class="login-box-body">
        <?php 
          if($this->session->flashdata('login_msg')!='') 
          {
              echo "<div class='alert alert-danger text-center'>"; 
                  echo $this->session->flashdata('login_msg');
              echo "</div>"; 
          }   
          if($this->session->flashdata('reg_success') != ''){
            echo '<div class="alert alert-success text-center">'.$this->session->flashdata("reg_success").'</div>';
          }      
        ?>
        <p class="login-box-msg"><?php echo $this->lang->line("login"); ?></p>
        <form action="<?php site_url('home/login'); ?>" method="post">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" name="username" placeholder="<?php echo $this->lang->line("email"); ?>" />
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
            <span style="color:red"><?php echo form_error('username'); ?></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password" placeholder="<?php echo $this->lang->line("password"); ?>" />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <span style="color:red"><?php echo form_error('password'); ?></span>
          </div>

          <div class="captcha_outer">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Enter below captha text here" id="captcha"/>
            <span class="capt_error">Captcha doesn't match.</span>
          </div>  
         
          <div class="row">            
            <div class="col-xs-12"><center><span id="CaptchaImg"><?php echo $captcha['image'];?></span><span id="RefreshCaptcha">&nbsp;&nbsp;<i class="fa fa-refresh fa-lg" aria-hidden="true"></i></span></center></div>
          </div><br>
          </div> 

          <div class="row">            
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat submit"><?php echo $this->lang->line("login"); ?></button>
            </div><!-- /.col -->
          </div>
        </form>
       <br/><center><a href="<?php echo site_url();?>home/forgot_password"><?php echo $this->lang->line("forget password"); ?></a></center>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <input type="hidden" id="CaptWord" value="<?php echo $captcha['word']; ?>" />

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url();?>plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo base_url();?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url();?>plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });

        var login_failed = '<?php echo $this->session->userdata('login_failed');?>';

        if(login_failed >= 3){
            $('.captcha_outer').show();    
        }else{
            $('.captcha_outer').hide();
        }

      });

      $('.submit').click(function(){
            var login_failed = '<?php echo $this->session->userdata('login_failed');?>';

            if(login_failed >= 3){
                $('.captcha_outer').show();    
            }else{
                $('.captcha_outer').hide();
            }

            if(login_failed >=3){
                $('.capt_error').hide();
                $("#captcha").prop('required',true);
                var captcha = $('#captcha').val();
                var CapImg = $('#CaptWord').val();
                if(captcha===CapImg){
                    $('.capt_error').hide();
                    return true;    
                }else{
                    $('.capt_error').show();
                    return false;
                }
            }else{
                $("#captcha").prop('required',false);
                $('.capt_error').hide();
                return true;       
            }
      });

      $('#RefreshCaptcha').click(function(){
        $.ajax({
            url: '<?php echo base_url(); ?>home/refresh_captcha/',
            success: function (response){
                if(response){
                    var result = JSON.parse(response);
                    $('#CaptchaImg').empty();
                    $('#CaptchaImg').html(result['image']);
                    $('#CaptWord').val(result['word']);
                }
            }
        });
    });

    </script>
  </body>
</html>
