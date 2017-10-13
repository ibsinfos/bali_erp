<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/print_merit_certificate.css" type="text/css" />
<style>
    .main_div{
        /*border-radius: 25px;*/
        background: url('assets/images/teacher_certificate4.png');
        width: 1074px;
        height: 720px; 
        background-repeat: no-repeat;
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
            <li><a href="<?php echo base_url(); ?>index.php?teacher/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?teacher/certificates"><?php echo get_phrase('ceritificate'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<?php if (!empty($certificate_detail)) { ?>
    <div class="row m-0">
        <div class="col-md-12 white-box">
            <div id="print_div">
                <center>
                    <div class="main_div">
                        <span class="m-t-20" id="title-name"><br><br><b><?php echo $system_name; ?></b></span>
                        <br/><br/>
                        <span class="m-t-20" id="sub-title"><?php echo ucfirst($certificate_detail->certificate_title); ?></span>
                        <br>
                        <span id="title-name">for</span>
                        <br>
                        <div id="for_merit_val" class="input_style"><?php echo ucfirst($certificate_detail->sub_title); ?>&nbsp;</div>
                        <br>
                        <!--<img src="<?php echo base_url(); ?>assets/images/horizntal_image.png" />-->
                        <br/>       <span id="title-name">Awarded to</span> <br/><br/>
                        <span class="name_style"><?php echo ucfirst($certificate_detail->name) . " " . ($certificate_detail->middle_name != '' ? $certificate_detail->middle_name : '') . " " . ucfirst($certificate_detail->last_name); ?></span>
                        <br/>       
                        <!--<img src="<?php echo base_url(); ?>assets/images/horizntal_image.png" />-->
                        <br/>
                        <br><br>
                        <div id="div11">
                            <span class="date_content"><?php echo date("d M Y"); ?></span>
                            <!--<img src="<?php echo base_url(); ?>assets/images/horizntal_image.png" /><br/>-->
                            <span class="sub_title11s"> Date </span>
                        </div>
                        <div id="div33">
                            <span> </span><br>
                            <!--<img src="<?php echo base_url(); ?>assets/images/horizntal_image.png" /><br/>-->
                            <span class="sub_title11s"> Signature </span>
                        </div>
                        <input type="hidden" name="student_id" id="student_id" value="<?php // echo $student_id;  ?>">  
                    </div>
                </center>
            </div>
        </div>
    </div><?php } elseif ($certificate_design != '') { ?>
    <div class="row m-0">
        <div class="col-md-12 white-box">
            <center>
                <div class="main_div">
                    <span class="m-t-20" id="title-name1"><br><br>&nbsp;<b><?php echo $system_name; ?></b></span>
                    <br/><br/>
                    <span class="m-t-20" id="sub-title">Certificate Title</span>
                    <br>
                    <span id="title-name">for</span>

                    <div id="for_merit_val" class="input_style">Sub Title&nbsp;</div>

    <!--<img src="<?php echo base_url(); ?>assets/images/horizntal_image.png" />-->

                    <span id="title-name">Awarded to</span> <br/><br/>
                    <span class="name_style">Teacher Name</span>
                    <br/>       
                    <!--<img src="<?php echo base_url(); ?>assets/images/horizntal_image.png" />-->
                    <br/>
                    <br><br><br><br><br>
                    <div id="div11">
                        <span class="date_content"><?php echo date("d M Y"); ?></span><br>
    <!--                        <img src="<?php echo base_url(); ?>assets/images/horizntal_image.png" /><br/>-->
                        <span class="sub_title11s"> Date </span>
                    </div>
                    <div id="div33">
                        <span> </span><br>
                        <!--<img src="<?php echo base_url(); ?>assets/images/horizntal_image.png" /><br/>-->
                        <span class="sub_title11s"> Signature </span>
                    </div>
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
    jQuery(document).bind("keyup keydown", function (e) {
        if (e.ctrlKey && e.keyCode == 80) {
            alert('You are not able to print');
            return false;

        }
    })
</script>