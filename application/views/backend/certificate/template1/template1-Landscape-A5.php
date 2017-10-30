<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('Certificates'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/student_certificates"><?php echo get_phrase('certificate'); ?></a></li>
            <li class="active">
                <?php echo get_phrase($page_title); ?>
            </li>
        </ol>
    </div>
</div>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
            <style>
                    @page {
                        size: A5;
                        margin: 0;
                    }
            </style>
            <link href="<?php echo base_url(); ?>assets/css/certificate/certificate_landscap_A5.css" rel="stylesheet" type="text/css">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>template1</title>
	</head>
	<body>
            <div id="print_div">
		<div id="background">
			<div id="BG"><img src="uploads/certificate_image/template1/landscapeA5/BG.png"></div>
			<div id="Shape6"><img src="uploads/certificate_image/template1/landscapeA5/Shape6.png"></div>
			<div id="Shape7"><img src="uploads/certificate_image/template1/landscapeA5/Shape7.png"></div>
			<div id="Ribbon"><img src="uploads/certificate_image/template1/landscapeA5/Ribbon.png"></div>
			<div id="Shape13"><img src="uploads/certificate_image/template1/landscapeA5/Shape13.png"></div>
			<div id="Shape14"><img src="uploads/certificate_image/template1/landscapeA5/Shape14.png"></div>
			<div id="Shape15"><img src="uploads/certificate_image/template1/landscapeA5/Shape15.png"></div>
                        <div id="THISCERTIFICATEISPRE"><?php echo strtoupper($certificate_detail->sub_title); ?></div>
                        <div id="CERTIFICATE"><?php echo ucfirst($certificate_detail->certificate_type);  ?></div>
			<div id="Shape18"><img src="uploads/logo.png" width="308px" height="280px"></div>
                        <span id="date_format"><?php echo date("F j, Y"); ?></span>
                        <div id="DATE"><img src="uploads/certificate_image/template1/landscapeA5/DATE.png"></div>
			<div id="Shape16copy"><img src="uploads/certificate_image/template1/landscapeA5/Shape16copy.png"></div>
			<div id="SIGNATURE"><img src="uploads/certificate_image/template1/landscapeA5/SIGNATURE.png"></div>
			<div id="Shape16"><img src="uploads/certificate_image/template1/landscapeA5/Shape16.png"></div>
			<div id="Loremipsumdolorsitam"><?php echo ucfirst($certificate_detail->main_cantent); ?></div>
			<div id="JOHNSMITH"><?php echo ucwords($certificate_detail->name ." ". ($certificate_detail->mname!=''?$certificate_detail->mname:'') ." ". $certificate_detail->lname); ?></div>
		</div>
            </div>
 </body>
 </html>

<script type="text/javascript">
    $(document).ready( function () {
        elem = "#print_div";
     Popup($(elem).html());
    });
    
    function Popup(data) {
        var myWindow = window.open('', 'my div', 'height=400,width=600');
        myWindow.document.write('<html><head><title></title>');
        myWindow.document.write('<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/certificate/certificate_landscap_A5.css" type="text/css" />');
        myWindow.document.write('</head><body >');
        myWindow.document.write(data);
        myWindow.document.write('</body></html>');

        myWindow.document.close(); // necessary for IE >= 10

        myWindow.onload = function () { 
            myWindow.focus(); // necessary for IE >= 10
            myWindow.print();
            myWindow.close();
        };
    }
</script>