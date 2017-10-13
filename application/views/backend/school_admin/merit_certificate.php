<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/print_merit_certificate.css" type="text/css" />
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
<?php
if (!empty($certificate_detail)) {
    if ($certificate_detail->is_approve == '1') {
        $is_approve = $certificate_detail->is_approve;
        $merit_certificate_for = $certificate_detail->merit_certificate_for;
    } else {
        $is_approve = "";
        $merit_certificate_for = "";
    }
} else {
    $is_approve = "";
    $merit_certificate_for = $merit_certificate_for;
}
?>

<?php if ($is_approve == '1') { ?>
    <div class="col-md-12 m-b-20 text-right">
        <input type="button" value="Approved" id="tc_confm" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="5" data-intro="Click on confirm button , then you will get a print button for print certificate." data-position='right' disabled="">
        <button value="Print"  onclick="PrintElem('#print_div');" class="fcbtn btn btn-danger btn-outline btn-1d"> Print </button>
    </div>
<?php } else { ?>
<form method="post" action="<?php echo base_url(); ?>index.php?school_admin/print_merit_certificate/create/<?php echo $student->student_id; ?>/<?php echo $student->parent_id; ?>">
<div class="col-md-12 m-b-20 text-right">
       <button value="submit" class="fcbtn btn btn-danger btn-outline btn-1d"> Approve </button>
    <?php } ?>
</div>
<input type="hidden" name="action" id="action" value="<?php echo $print; ?>">
<div class="row m-0">
    <div class="col-md-12" >
        <div class = "white-box">
        <div id="print_div">
            <center>
                <div class="wrapper">   
                    <span class="m-t-20" id="title-name"><b><?php echo $system_name; ?></b></span>
                    <br/><br/>
                    <span class="m-t-20" id="sub-title">Certificate of Merit</span>
                    <br>
                    <span id="title-name">for</span>
                    <br>
                    <input type="hidden" name="for_merit" value="<?php echo $merit_certificate_for; ?>">
                    <input type="text" class="input_style" id="for_merit" maxlength="100" onchange="show_value();" data-step="5" data-intro="Please feel in this value after click on print." data-position='right' value="<?php echo "Class ".$merit_certificate_for; ?>" readonly="" />
                    <div id="for_merit_val" class="print_text" style="display:none;"><?php echo "Class ".$merit_certificate_for; ?>&nbsp;</div>
                    <br>
                    <img src="<?php echo base_url(); ?>assets/images/horizntal_image.png" />
                    <br/>       <span id="title-name">Awarded to</span> <br/><br/>
                    <?php if (property_exists($student, "name") && property_exists($student, 'mname') && property_exists($student, 'lname')): ?>
                        <span class="name_style"> <?php echo $student->name . ' ' . $student->mname . ' ' . $student->lname; ?></span>
<?php endif; ?>
                    <br/>       
                    <img src="<?php echo base_url(); ?>assets/images/horizntal_image.png" />
                    <br/>
                    <br><br>
                    <div id="div1" >
                        <span class="date_content"><?php echo date("d M Y"); ?></span>
                        <img src="<?php echo base_url(); ?>assets/images/horizntal_image.png" /><br/>
                        <span class="sub_title11s"> Date </span>
                    </div>
                    <div id="div3">
                        <span> </span><br>
                        <img src="<?php echo base_url(); ?>assets/images/horizntal_image.png" /><br/>

                        <span class="sub_title11s"> Signature </span>

                    </div>
                    <input type="hidden" name="studentId" id="student_id" value="<?php echo $student_id; ?>">  
                </div>
            </center>
        </div>
    </div>
</div>
</div>
</form>
<script type="text/javascript">
    var print_val = $('#action').val();
    //  alert(print_val);
    if (print_val == '1') {
        document.getElementById("print_button").style.display = "inline-block";
    } else {
        document.getElementById("print_button").style.display = "none";
    }

    function show_value() {
//           alert("dsgfjsdf");
        var for_merit = $('#for_merit').val();
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

        var merit_certificate_for = $('#for_merit').val();
        var student_id = $('#student_id').val();
//         alert(student_id);
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?ajax_controller/merit_certificate/',
            type: "POST",
            data: {merit_certificate_for: merit_certificate_for, student_id: student_id},
            success: function (response) {
//                alert(response);                               
//                jQuery('#subject_holder').append(response);
            }
        });
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
        window.location.reload();
    }

</script>