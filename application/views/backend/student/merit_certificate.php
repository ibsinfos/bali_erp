<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/print_merit_certificate.css" type="text/css" />
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"><h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();"  class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb"><?php $student_name = $student->name; ?>
            <li>
                <a href="<?php echo base_url(); ?>index.php?student/Dashboard">   <?php echo get_phrase('Dashboard'); ?> </a></li>
            <li> <a href="<?php echo base_url(); ?>index.php?student/documents/<?php echo $student->student_id; ?>">
                    <?php echo get_phrase('documents'); ?>
                </a>
            </li>
            <li class="active">
                <?php echo get_phrase($page_title) ; ?>
            </li></ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<?php if (!empty($certificate_detail)) {
    if ($certificate_detail->is_approve == '1') {
        ?>
        <div class="row">    
            <div class="col-md-12 m-b-20 text-right">    
                <input type="button" value="Print" id="print_button" onclick="PrintElem('#print');" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="5" data-intro="Click on confirm button , then you will get a print button for print certificate." data-position='right'> 
            </div></div>
        <div class="col-md-12 white-box">

            <div id="print">
                <center>
                    <div class="wrapper">
                        <span style="font-size:50px; padding-top: 20px;"><b><?php echo $system_name; ?></b></span>
                        <br/><br/>
                        <span style="font-size:50px; padding-top: 20px;">Certificate of Merit</span>
                        <br><br>
                        <span style="font-size:40px">for</span>
                        <br><br/>
                        <input type="text" class="input_style" name="for_merit" id="for_merit" maxlength="200" value="<?php if (!empty($certificate_detail)) echo "Class ".$certificate_detail->merit_certificate_for; ?>"  readonly=""/>
                        <div id="for_merit_val" class="print_text" style="display:none;">&nbsp;</div>
                        <br>
                        <img src="<?php echo base_url(); ?>assets/images/horizntal_image.png" />
                        <br/><br/><br/>
                        <span style="font-size:45px">Awarded to</span> <br/><br/>
                        <?php if (property_exists($student, "name") && property_exists($student, 'mname') && property_exists($student, 'lname')): ?>
                            <span class="name_style"> <?php echo $student->name . ' ' . $student->mname . ' ' . $student->lname; ?></span>
        <?php endif; ?>
                        <br/>

                        <img src="<?php echo base_url(); ?>assets/images/horizntal_image.png" />
                        <br/><br><br>
                        <div id="div1" >
                            <span style=" font-size: 20px;"><?php echo date("d M Y"); ?></span>
                            <img src="<?php echo base_url(); ?>assets/images/horizntal_image.png" /><br/>
                            <span style="font-size:30px">Date </span>
                        </div>
                        <!--
                                        <div id="div2" >
                                            <img src="<?php echo base_url() . 'uploads/admin_image/1.png'; ?>" style="width:120px; height: 120px;"/> <br/><br/>
                                        </div>
                        -->
                        <div id="div3"  >
                            <span> </span><br>
                            <img src="<?php echo base_url(); ?>assets/images/horizntal_image.png" /><br/>

                            <span style="font-size:30px"> Signature </span>

                        </div>

                    </div>
                </center>
            </div>

        </div>
    <?php
    }else {
        echo "<div class='col-md-12 no-padding'> <div class='panel panel-danger'>
                <div class='panel-heading'>
                    <div class='panel-title text-white'>No information available for Merit Certificate!!!
                    </div>
                </div> 
            </div></div>";
    }
} else {
    echo "<div class='col-md-12 no-padding'> <div class='panel panel-danger'>
                <div class='panel-heading'>
                    <div class='panel-title text-white'>No information available for Merit Certificate!!!
                    </div>
                </div> 
            </div></div>";
}
?>
<script type="text/javascript">
    var for_merit = $('#for_merit').val();
    if (for_merit != '') {
        document.getElementById('for_merit_val').innerHTML = for_merit;
    }

    jQuery(document).bind("keyup keydown", function (e) {
        if (e.ctrlKey && e.keyCode == 80) {
            alert('Please Click on Print Button');
            document.getElementById("print_button").focus();
            return false;

        }
    })
    function PrintElem(elem) {
        $('input[id="for_merit"]').hide();
        $('div[class="print_text"]').show();
        Popup($(elem).html());
    }
    function Popup(data) {
        var myWindow = window.open('', 'my div', 'height=400,width=600');
        myWindow.document.write('<html><head><title></title>');
        myWindow.document.write('<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/print_merit_certificate.css" type="text/css" /><style type="text/css">.print_text{font-size: 45px; !important;}</style>');
        myWindow.document.write('</head><body >');
        myWindow.document.write(data);
        myWindow.document.write('</body></html>');

        myWindow.document.close(); // necessary for IE >= 10

        myWindow.onload = function () { // necessary if the div contain images
            $('input[id="for_merit"]').show();
            $('div[class="print_text"]').hide();
            myWindow.focus(); // necessary for IE >= 10
            myWindow.print();
            myWindow.close();
        };
    }

</script>
</html>
