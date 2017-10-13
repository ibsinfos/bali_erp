<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"><h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/print_merit_certificate.css" type="text/css" />

<div class="col-md-12 white-box">
    <div id="print_div">
        <center>
            <div class="wrapper">
                <div id="school_name"><b><?php echo $system_name; ?></b></div>
                <div class="col-md-12">&nbsp;</div>
                <div class="certificate_title"><?php echo ucwords($ceritificate_title); ?></div>
                <div class="col-md-12">&nbsp;</div>
                <div class="sub_title11s"><?php echo ucfirst($sub_title); ?></div>
                <div class="col-md-12">&nbsp;</div>
                <?php if (property_exists($student, "name") && property_exists($student, 'mname') && property_exists($student, 'lname')): ?>
                    <div class="name_style"> <?php echo ucwords($student->name . ' ' . $student->mname . ' ' . $student->lname); ?></div>
                <?php endif; ?>
                <img src="<?php echo base_url(); ?>assets/images/horizntal_image.png" />
                <div class="col-md-12">&nbsp;</div>
                <div class="col-md-12">&nbsp;</div>
                <div class="col-md-12">&nbsp;</div>
                <div class="form-group">
                    <div class="col-md-2">&nbsp;</div>
                    <div class="main_content col-md-8 m-l-20 m-r-20 text-center"><?php echo ucfirst($main_cantent); ?></div>
                    <div class="col-md-2">&nbsp;</div>
                </div>
                <div class="col-md-12">&nbsp;</div>
                <div class="col-md-12">&nbsp;</div>
                <div class="col-md-12">&nbsp;</div>
                <div class="col-md-12">&nbsp;</div>
                <div id="div1">
                    <div class="date_content"><?php echo date("d M Y"); ?></div>
                    <img src="<?php echo base_url(); ?>assets/images/horizntal_image.png" />
                    <div class="date_content1">Date </div>
                </div>
                <div id="div3">
                    <img src="<?php echo base_url(); ?>assets/images/horizntal_image.png" />

                    <div class="date_content1"> Signature </div>

                </div>
            </div>
        </center>
    </div>

</div>
<div class="row">    
    <div class="col-md-12 m-b-10 text-right">    
        <input type="button" value="Print" id="print_button" onclick="PrintElem('#print_div');"  class="fcbtn btn btn-danger btn-outline btn-1d"  data-step="5" data-intro="<?php echo get_phrase('Please click on print button, then print certificate.');?>" data-position='right'> 
    </div>
</div>
<script type="text/javascript">
    jQuery(document).bind("keyup keydown", function (e) {
        if (e.ctrlKey && e.keyCode == 80) {
            alert('Please Click on Print Button');
            document.getElementById("print_button").focus();
            return false;

        }
    })
    function PrintElem(elem) {
        Popup($(elem).html());
    }
    function Popup(data) {
        var myWindow = window.open('', 'my div', 'height=400,width=600');
        myWindow.document.write('<html><head><title></title>');
        myWindow.document.write('<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/print_merit_certificate.css" type="text/css" />');
        myWindow.document.write('</head><body >');
        myWindow.document.write(data);
        myWindow.document.write('</body></html>');

        myWindow.document.close(); // necessary for IE >= 10

        myWindow.onload = function () { // necessary if the div contain images
            myWindow.focus(); // necessary for IE >= 10
            myWindow.print();
            myWindow.close();
        };
    }
</script>
