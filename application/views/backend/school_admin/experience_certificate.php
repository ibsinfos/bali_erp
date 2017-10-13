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
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><?php echo get_phrase('certificate'); ?>
                <ul>                    
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/student_certificates"><?php echo get_phrase('student'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/teacher_certificates"><?php echo get_phrase('teacher'); ?></a></li>
                </ul>
            </li>
            <li class="active">
                <?php echo $page_title; ?>
            </li>
        </ol>
        
    </div>
</div>
 <?php
if (!empty($certificate_detail)) {
        $is_approve = $certificate_detail->is_approve;
        $job_title = $certificate_detail->job_title;
        $from_data = $certificate_detail->from_data;
        $to_date = $certificate_detail->to_date;
        $designation = $certificate_detail->designation;
    }
 else{
        $is_approve = "";
        $job_title = "";
        $from_data = "";
        $to_date = "";
        $designation = "";
     }
?>
 <?php if ($is_approve == '1') { ?>
    <div class="col-md-12 m-b-20 text-right no-padding">
        <input type="button" value="Approved" id="tc_confm" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="5" data-intro="Click on confirm button , then you will get a print button for print certificate." data-position='right' disabled="">
        <button value="Print"  onclick="PrintElem('#print_div');" class="fcbtn btn btn-danger btn-outline btn-1d"> Print </button>
    </div>
<?php } else { ?>
<form method="post" action="<?php echo base_url(); ?>index.php?school_admin/experience_certificate/<?php echo $teacher_id; ?>/create">
<div class="col-md-12 m-b-20 text-right no-padding">
       <button value="submit" class="fcbtn btn btn-danger btn-outline btn-1d"> Approve </button>
    <?php } ?>
</div>
<div id="row">
<div class="col-md-12 white-box">
        <div id="print_div">
        <center>
<div class="main_div">
<div id="div2">
       <div class="certificate_type">Certificate of Experience</div>
        <div class="font_size2">This is to certify that</div>
        <div class="font_size2"> <b><?php echo ucwords($teacher_data->name.' '.$teacher_data->middle_name.' '.$teacher_data->last_name); ?></b></div>
        <div class="font_size3"><i>has completed Work Experience in the</i></div>
        <div class="font_size2"><i><input type="text" value="<?php echo $job_title;  ?>" id="job_title" name="job_title" class="input_val" data-step="5" data-intro="Write work experience title" data-position='right' >
                <span id="class_name_val" class="print_text"><?php echo $job_title;  ?></span></i></div>
       <div class="font_size2" >At</div>
       <div class="font_size2"><i><?php echo $system_name; ?></i></div>
       <div class="col-md-12">&nbsp;</div>
       <div class="col-md-12 font_size3" id="div_name">Name: <?php echo ucwords($teacher_data->name.' '.$teacher_data->middle_name.' '.$teacher_data->last_name); ?></div>
       <div class="col-md-12 font_size3" id="join_info">Join from &nbsp;<input type="text" class="input_val" name="join_date" date="join_date" id="join_date" data-step="6" data-intro="Please write join date" data-position='right' value="<?php echo $from_data; ?>"><span id="join_date_val" class="print_text"><?php echo $from_data; ?></span> &nbsp;to &nbsp; <input type="text" class="input_val" id="end_date" name="end_date" data-step="7" data-intro="Please write end date" data-position='right' value="<?php echo $to_date; ?>"><span id="end_date_val" class="print_text"><?php echo $to_date; ?></span> &nbsp;</div>
   <div class="col-md-12 text-left font_size3">Designation: &nbsp;<input type="text" class="input_val" id="designation" name="designation" data-step="8" data-intro="Please write designation " data-position='right' value="<?php echo $designation; ?>"><span id="designation_val" class="print_text"><?php echo $designation; ?></span>&nbsp;</div>
   <div class="col-md-12">&nbsp;</div>
   <div class="col-md-12 "><img src="<?php echo base_url(); ?>uploads/logo.png" alt="home" class="dark-logo" width="40"></div>
   <div class="col-md-12">&nbsp;</div>
   <div class="col-md-4 text-left font-size4">Teacher Signature</div>
     <div class="col-md-4"></div>
       <div class="col-md-4 font-size4">Administrator Signature</div>
       <input type="hidden" name="teacher_id" id="teacher_id" value="<?php echo $teacher_id;  ?>">
</div>
</div>
</center>
        </div>
</div>
</div>
 </form>
<script type="text/javascript">
    var input_disable = "<?php echo $certificate_detail->is_approve; ?>"
    if(input_disable=="1"){
        $("input").prop('readonly', true);
    }
 $('span[class="print_text"]').hide();
  $( 'input[type="text"]' ).change(function() {
   var elem=this.id+'_val';
   thisId=this.id;
   setVal(elem,this.value);
  });
   function setVal(elem,value){
  document.getElementById(elem).innerHTML=value;
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

            myWindow.onload=function(){ // necessary if the div contain images
      
$('input[class="input_val"]').show();   
$('span[class="print_text"]').hide();   
                myWindow.focus(); // necessary for IE >= 10
                myWindow.print();
                myWindow.close();
            };
        }
</script>