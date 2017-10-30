<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php // pre($certificate_detail); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>template3</title>
                <style>
                    @page {
                        size: A5;
                        margin: 0;
                    }
                </style>
		<link href="<?php echo base_url(); ?>assets/css/certificate/certificate_style.css" rel="stylesheet" type="text/css">
	</head>
	<body >
            <div id="print_div">
                  	<div id="background">
			<div id="VectorSmartObject"><img src="uploads/certificate_image/VectorSmartObject.png"></div>
			<div id="VectorSmartObject_0"><img src="uploads/certificate_image/VectorSmartObject_0.png"></div>
			<div id="Loremipsumdolorsitam"> <?php echo ucwords($certificate_detail->name ." ". ($certificate_detail->mname!=''?$certificate_detail->mname:'') ." ". $certificate_detail->lname); ?></div>
			<div id="Loremipsumdolorsitam_0"> <?php echo ucfirst($certificate_detail->main_cantent); ?> </div>
			<div id="Rectangle1"><img src="uploads/certificate_image/Rectangle1.png"></div>
			<div id="Rectangle1copy"><img src="uploads/certificate_image/Rectangle1copy.png"></div>
			<div id="date"><img src="uploads/certificate_image/date.png"></div>
			<div id="signature"><img src="uploads/certificate_image/signature.png"></div>
			<div id="thiscertificateispre"><?php echo $certificate_detail->certificate_type;  ?></div>
			<div id="certificate"><?php echo $system_name; ?></div>
			<!--<div id="ofappreciation"><img src="uploads/certificate_image/ofappreciation.png"></div>-->
			<div id="VmalooProject"><?php echo $certificate_detail->sub_title;  ?></div>
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
        myWindow.document.write('<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/certificate_style.css" type="text/css" />');
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