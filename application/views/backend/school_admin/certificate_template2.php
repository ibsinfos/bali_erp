<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/print_merit_certificate.css" type="text/css" />
<style>
    .main_div{
        /*border-radius: 25px;*/
        background: url('assets/images/certificate8.png');
        background-repeat: no-repeat;
        width: 950px;
        height: 920px; 
    }
</style>
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
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/student_certificates"><?php echo get_phrase('ceritificate'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<?php if (!empty($certificate_detail)) { ?>
    <div class="col-md-12 m-b-20 text-right no-padding">   
        <button value="Print" id="print_button" onclick="PrintElem('#print_div');" class="fcbtn btn btn-danger btn-outline btn-1d"> Print </button>
    </div>

    <div class="row m-0">
        <div class="col-md-12 white-box">
            <div id="print_div">
                <center>
                    <div class="main_div">
                        <span class="m-t-20" id="title-name"><br><b><?php echo $system_name; ?></b></span><br>
                        <span class="m-t-20" id="sub-title"><?php echo ucfirst($certificate_detail->certificate_title); ?></span>
                        <br>
                        <span id="title-name">for</span>
                        <br>
                        <div id="for_merit_val" class="input_style"><?php echo ucfirst($certificate_detail->sub_title); ?>&nbsp;</div>
                        <br/>       <span id="title-name">Awarded to</span> 
                        <span class="name_style"><?php echo ucfirst($certificate_detail->name) . " " . ($certificate_detail->mname != '' ? $certificate_detail->mname : '') . " " . ucfirst($certificate_detail->lname); ?></span>
                        <br><br>
                        <!--<div id="div11">-->
                            <span class="date_content"><?php echo date("d M Y"); ?></span><br>
                            <span class="sub_title11s"> Date </span><br><br>
                        <!--</div>-->
                        <!--<div id="div33">-->
                            <span> </span><br>
                            <span class="sub_title11s"> Signature </span>
                        <!--</div>-->
                        <input type="hidden" name="student_id" id="student_id" value="<?php // echo $student_id;  ?>">  
                    </div>
                </center>
            </div>
        </div>
    </div>
<?php } elseif ($certificate_design != '') { ?>
    <div class="row m-0">
        <div class="col-md-12 white-box">
            <center>
                <div class="main_div"><br><br>
                    <span class="m-t-20" id="title-name1"><br>&nbsp;<b><?php echo $system_name; ?></b></span>
                    <br/>
                    <span class="m-t-20" id="sub-title">Certificate Title</span>
                    <br>
                    <span id="title-name">for</span>

                    <div id="for_merit_val" class="input_style">Sub Title&nbsp;</div>

                    <span id="title-name">Awarded to</span> <br/>
                    <span class="name_style">Student Name</span><br>
                    <br/>       
                        <span class="date_content"><?php echo date("d M Y"); ?></span><br>
                        <span class="sub_title11s"> Date </span><br><br>
                        <span> </span><br>
                        <span class="sub_title11s"> Signature </span>
                    <input type="hidden" name="student_id" id="student_id" value="<?php // echo $student_id;  ?>">  
                </div>
            </center>
        </div>
    </div>
<?php } else { ?>
    <div class='col-md-12 no-padding'> <div class='panel panel-danger'>
            <div class='panel-heading'>
                <div class='panel-title text-white'>No information available for Certificate!!!
                </div>
            </div> 
        </div></div>
<?php } ?>
<script type="text/javascript">
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
        myWindow.document.write('<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/print_merit_certificate.css" type="text/css" /><style type="text/css"> .main_div{ background: url("assets/images/certificate8.png"); width:950px; height:900px; background-size :100% 100%;}</style>');
        myWindow.document.write('</head><body >');
        myWindow.document.write(data);
        myWindow.document.write('</body></html>');

        myWindow.document.close(); // necessary for IE >= 10

        setTimeout(function () { // necessary for Chrome
            myWindow.focus();
            myWindow.print();
            myWindow.close();
        }, 1000);

        window.location.reload();
    }
</script>