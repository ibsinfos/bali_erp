<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login | Pretty S3 Files Manager</title>

    <!-- Bootstrap core CSS -->
<!--    https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css-->
    <link rel="icon" href="<?php echo $this->baseUrl;  ?>/favicon.ico" type="image/x-icon"/>
    <link href="<?php echo $this->assetsUrl ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $this->assetsUrl ?>/fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo $this->assetsUrl ?>/css/animate.min.css" rel="stylesheet">
    <!-- Custom styling plus plugins -->
    <link href="<?php echo $this->assetsUrl ?>/css/custom.css" rel="stylesheet">
    <link href="<?php echo $this->assetsUrl ?>/css/icheck/flat/green.css" rel="stylesheet">
    <script src="<?php echo $this->assetsUrl ?>/js/jquery.min.js"></script>
</head>

<body>

<div id="login" class="container">
	<section class="doc-login">
		<form method="post"  id="login" data-parsley-validate class="form-label-left" style="padding:20px;">
			<h1>Login Form</h1>
                         
			<div>
				<input  required="required" type="text" placeholder="Username" id="username" />
			</div>
			<div>
				<input  required="required" type="password" placeholder="Password" id="password" />
			</div>
			<div>
				<input class="btn" type="submit" style="margin-bottom:15px;margin-top:15px;" value="Log in" />
				
			</div>
                        <?php if (!empty($message)): ?>
                            <div >
                                <strong><?php echo $message['status'] ?>!</strong> <?php echo $message['mgs'] ?>
                            </div>
                        <?php endif; ?>
		</form>
	</section>
</div>

<!--    
    
    <div class="">
        <a class="hiddenanchor" id="toregister"></a>
        <a class="hiddenanchor" id="tologin"></a>

        <div id="wrapper">
            <div id="login" class="animate form">
                <section class="login_content">
                    <form method="post"  id="login" data-parsley-validate class="form-horizontal form-label-left">
                        <h1>Welcome You Back</h1>
                        <p class="small">
                            <i class="fa fa-lock"> </i>
                            Please login to continue
                        </p>
                        <?php if (!empty($message)): ?>
                            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
                                </button>
                                <strong><?php echo $message['status'] ?>!</strong> <?php echo $message['mgs'] ?>
                            </div>
                        <?php endif; ?>
                        <div>
                            <input required="required" type="text" name="username" class="form-control" placeholder="Username" required="" />
                        </div>
                        <div>
                            <input required="required" name="password" type="password" class="form-control" placeholder="Password" required="" />
                        </div>
                        <div>
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-forward"> </i>
                                Login me in
                            </button>
                        </div>
                        <div class="clearfix"></div>
                        <div class="separator">
                            <div class="clearfix"></div>
                            <br />
                            <div>
                                <p>2016 All Rights Reserved. <b>Pretty S3 Files Manager</b> script. For more supports, feel free to contact us at <a href="mailto:support@phprocket.com">tranit1209@gmail.com</a></p>
                            </div>
                        </div>
                    </form>
                     form 
                </section>
                 content 
            </div>
        </div>
    </div>-->


<script>
    $(document).ready(function () {
        $.listen('parsley:field:validate', function () {
            validateFront();
        });
        $('#login .btn').on('click', function () {
            $('#login').parsley().validate();
            validateFront();
        });
        var validateFront = function () {
            if (true === $('#login').parsley().isValid()) {
                $('.bs-callout-info').removeClass('hidden');
                $('.bs-callout-warning').addClass('hidden');
            } else {
                $('.bs-callout-info').addClass('hidden');
                $('.bs-callout-warning').removeClass('hidden');
            }
        };
    });
</script>
<style>
    /*start from here for login page */
        .doc-login { margin: 0 20px; position: relative }
        .doc-login input[type="text"],
        .doc-login input[type="password"] {
	border-radius: 3px;
	border: 1px solid #c8c8c8;
	margin: 0 0 10px;
	padding: 15px 10px 15px 40px;
	width: 80%;
}
        /* Reset CSS */
        .clearfix:after,
        form:after {
	content: ".";
	display: block;
	height: 0;
	clear: both;
	visibility: hidden;
}
.doc-login {
	background: #f9f9f9;
	background: -moz-linear-gradient(top,  rgba(248,248,248,1) 0%, rgba(249,249,249,1) 100%);
	background: -webkit-linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
	background: -o-linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
	background: -ms-linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
	background: linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
	border: 1px solid #c4c6ca;
	position: relative;
	text-align: center;	
}

.doc-login:after,
.doc-login:before {
	background: #f9f9f9;
	background: -moz-linear-gradient(top,  rgba(248,248,248,1) 0%, rgba(249,249,249,1) 100%);
	background: -webkit-linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
	background: -o-linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
	background: -ms-linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
	background: linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f8f8f8', endColorstr='#f9f9f9',GradientType=0 );
	border: 1px solid #c4c6ca;
	content: "";
	display: block;
	height: 100%;
	left: -1px;
	position: absolute;
	width: 100%;
}
.doc-login:after {
	-webkit-transform: rotate(2deg);
	-moz-transform: rotate(2deg);
	-ms-transform: rotate(2deg);
	-o-transform: rotate(2deg);
	transform: rotate(2deg);
	top: 0;
	z-index: -1;
}
.doc-login:before {
	-webkit-transform: rotate(-3deg);
	-moz-transform: rotate(-3deg);
	-ms-transform: rotate(-3deg);
	-o-transform: rotate(-3deg);
	transform: rotate(-3deg);
	top: 0;
	z-index: -2;
}


.doc-login form input[type="submit"] {
	background: rgb(254,231,154);
	background: -moz-linear-gradient(top,  rgba(254,231,154,1) 0%, rgba(254,193,81,1) 100%);
	background: -webkit-linear-gradient(top,  rgba(254,231,154,1) 0%,rgba(254,193,81,1) 100%);
	background: -o-linear-gradient(top,  rgba(254,231,154,1) 0%,rgba(254,193,81,1) 100%);
	background: -ms-linear-gradient(top,  rgba(254,231,154,1) 0%,rgba(254,193,81,1) 100%);
	background: linear-gradient(top,  rgba(254,231,154,1) 0%,rgba(254,193,81,1) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fee79a', endColorstr='#fec151',GradientType=0 );
	-webkit-border-radius: 30px;
	-moz-border-radius: 30px;
	-ms-border-radius: 30px;
	-o-border-radius: 30px;
	border-radius: 30px;
	-webkit-box-shadow: 0 1px 0 rgba(255,255,255,0.8) inset;
	-moz-box-shadow: 0 1px 0 rgba(255,255,255,0.8) inset;
	-ms-box-shadow: 0 1px 0 rgba(255,255,255,0.8) inset;
	-o-box-shadow: 0 1px 0 rgba(255,255,255,0.8) inset;
	box-shadow: 0 1px 0 rgba(255,255,255,0.8) inset;
	border: 1px solid #D69E31;
	color: #85592e;
	cursor: pointer;
	height: 35px;
        width: 120px;
	
}
.doc-login form input[type="submit"]:hover {
	background: rgb(254,193,81);
	background: -moz-linear-gradient(top,  rgba(254,193,81,1) 0%, rgba(254,231,154,1) 100%);
	background: -webkit-linear-gradient(top,  rgba(254,193,81,1) 0%,rgba(254,231,154,1) 100%);
	background: -o-linear-gradient(top,  rgba(254,193,81,1) 0%,rgba(254,231,154,1) 100%);
	background: -ms-linear-gradient(top,  rgba(254,193,81,1) 0%,rgba(254,231,154,1) 100%);
	background: linear-gradient(top,  rgba(254,193,81,1) 0%,rgba(254,231,154,1) 100%);
	
}

 /*end here for login page*/

</style>
</body>
</html>