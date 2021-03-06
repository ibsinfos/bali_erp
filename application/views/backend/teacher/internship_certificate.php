<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/experience_certificate.css" type="text/css" />
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?></h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?teacher/certificates"><?php echo get_phrase('certificate'); ?></a></li>
            <li class="active">
                <?php echo get_phrase($page_title); ?>
            </li>
        </ol>
    </div>
</div>
<?php 
if (!empty($certificate_detail)) {
    ?>
    <div class="col-md-12 m-b-20 text-right no-padding">
        <button value="Print"  onclick="PrintElem('#print_div');" class="fcbtn btn btn-danger btn-outline btn-1d"> Print </button>
    </div>

    <div id="row">
        <div class="col-md-12 white-box">
            <div id="print_div">
                <center>
                    <div class="main_div">
                        <div id="div2">
                            <div class="certificate_type">Certificate of Internship</div>
                            <div class="font_size2">We present this certificate to</div>
                            <div class="font_size2"> <b><?php echo ucwords($teacher_data->name . ' ' . $teacher_data->middle_name . ' ' . $teacher_data->last_name); ?></b></div>
                            <div class="font_size3"><i>in appreciation for your successful work as an intern</i></div>
                            <div class="font_size2" >At</div>
                            <div class="font_size2"><i><?php echo $system_name; ?></i></div>
                            <div class="col-md-12">&nbsp;</div>
                            <div class="font_size3"><i>The internship was conducted between</i> &nbsp;<span id="join_date_val" class="print_text"><?php echo $certificate_detail->from_Date; ?></span> &nbsp;to &nbsp;<span id="end_date_val" class="print_text"><?php echo $certificate_detail->to_date; ?></span> &nbsp;</div>
                            <div class="col-md-12">&nbsp;</div>
                            <div class="col-md-12 "><img src="<?php echo base_url(); ?>uploads/logo.png" alt="home" class="dark-logo" width="40"></div>
                            <div class="col-md-12">&nbsp;</div>
                            <div class="col-md-4 text-left font-size4">Date : <?php echo date('d/m/Y'); ?></div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4 font-size4">Administrator Signature</div>
                        </div>
                    </div>
                </center>
            </div>
        </div>
    </div>
<?php
} else {
    echo "<div class='col-md-12 no-padding'> <div class='panel panel-danger'>
                <div class='panel-heading'>
                    <div class='panel-title text-white'>No information available for Internship Certificate!!!
                    </div>
                </div> 
            </div></div>";
}
?>
<script type="text/javascript">
    var input_disable = "<?php echo $certificate_detail->is_approve; ?>"
    if (input_disable == "1") {
        $("input").prop('readonly', true);
    }

    $('span[class="print_text"]').hide();
    $('input[type="text"]').change(function () {
        var elem = this.id + '_val';
        thisId = this.id;
        setVal(elem, this.value);
    });
    function setVal(elem, value) {
        document.getElementById(elem).innerHTML = value;
    }
    function PrintElem(elem) {
        $('input[class="input_val"]').hide();
        $('span[class="print_text"]').show();
        Popup($(elem).html());
    }

    function Popup(data) {

        var myWindow = window.open('', 'my div', 'height=400,width=600');
        myWindow.document.write('<html><head><title></title>');
        myWindow.document.write('<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/experience_certificate.css" type="text/css" />\n\
                <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/transfer_certificate_print.css" type="text/css" />');
        myWindow.document.write(data);
        myWindow.document.write('</body></html>');
        myWindow.document.close(); // necessary for IE >= 10

        myWindow.onload = function () { // necessary if the div contain images

            $('input[class="input_val"]').show();
            $('span[class="print_text"]').hide();
            myWindow.focus(); // necessary for IE >= 10
            myWindow.print();
            myWindow.close();
        };
    }
</script>