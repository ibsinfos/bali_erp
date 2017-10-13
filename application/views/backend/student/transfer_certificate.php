<style type="text/css">
    .print_text {
        float:left !important;
    height: 31px !important;
    padding: 6px 12px !important;
    font-size: 12px !important;
    line-height: 1.42857143 !important;
    color: #555555 !important;
    background-color: #ffffff;
    background-image: none;   
    display:none;
    }
    .main-content{
            min-height: 1244px;
    height: auto;
    margin-bottom: 30px;
    }
</style>

<?php // pre($certificate_detail); ?>
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>index.php?student/Dashboard">   <?php echo get_phrase('Dashboard'); ?> </a></li>
            <li> <a href="<?php echo base_url(); ?>index.php?student/documents/<?php echo $student->student_id; ?>">
                    <?php echo get_phrase('documents'); ?>
                </a>
            </li>
            <li class="active">
                <?php echo get_phrase($page_title); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<?php if(!empty($certificate_detail)){ 
    if($certificate_detail->is_approve == '1'){
    ?>
 <input type="hidden" name="action" id="action" value="<?php echo $print;?>">
<div class="m-b-20 col-md-12 text-right no-padding">
        <button value="Print" id="print_button" onclick="PrintElem('#print');" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="5" data-intro="Click on confirm button , then you will get a print button for print certificate." data-position='right'> Print </button>
</div>
<div id="print">
    <div class="col-md-12 white-box">
        <center>
            <img src="<?php echo base_url().'assets/images/logo_ag.png'; ?>" width="50" height="50">
            <h3><?php echo $system_name;?></h3>
        </center>
        <h2><center><b>Transfer Certificate</b></center></h2>
        <form method="post">
            <div class="form-group col-md-6">
                <label class="control-label">TC Number:</label>
                <div>
                    <input type="text" name="certificate_no" id="certificate_no11" placeholder="" value=" <?php $tc_no = $tc_number->tc_id; $tc_no = $tc_no+1; echo "DA/TC/".$tc_no; ?>" class="form-control" required readonly="">
        <input type="hidden" id="certificate_no" name="certificate_no" value="<?php echo $tc_no; ?>" >
        <div id="certificate_no11_val" class="print_text"><?php $tc_no = $tc_number->tc_id; $tc_no = $tc_no+1; echo "DA/TC/".$tc_no; ?></div>

                </div>
            </div>

            <div class="form-group col-md-6">
                <label class="control-label">Admission Number:</label>
                <div>
                  <input type="text" name="enroll_code" id="enroll_code" placeholder="" value="<?php if($enroll_no!='') echo $enroll_no->enroll_code; ?>" class="form-control" required readonly="">
        <div id="enroll_code_val" class="print_text"><?php echo $enroll_no->enroll_code; ?></div>
  </div>
            </div>
            <div class="form-group col-md-6">
                <label class="control-label">Name of Student:</label>
                <div>
                    <input type="text" name="student_name" id="student_name" placeholder="" value="<?php echo $student->name.' '.$student->mname.' '.$student->lname;?>"class="form-control"required readonly="">
        <input type="hidden" name="student_id" id="student_id" value="<?php echo $student->student_id; ?>">
        <div id="student_name_val" class="print_text"><?php echo $student->name.' '.$student->mname.' '.$student->lname;?></div>

                </div>
            </div>
<?php foreach($parent_name as $rslt): ?>
            <div class="form-group col-md-6">
                <label class="control-label">Father's Name:</label>
                <div>
                   <input type="text" name="father_name" id="father_name" placeholder="" value="<?php echo $rslt['father_name'].' '.$rslt['father_lname']; ?>" class="form-control" required readonly="">
        <div id="father_name_val" class="print_text"><?php echo $rslt['father_name'].' '.$rslt['father_lname']; ?></div>       
                </div>
            </div>

            <div class="form-group col-md-6">
                <label class="control-label">Mother's:</label>
                <div>
                    <input type="text" name="mother_name" id="mother_name" placeholder="" value="<?php echo $rslt['mother_name'].' '.$rslt['mother_lname']; ?>" class="form-control" required readonly="">
        <div id="mother_name_val" class="print_text"><?php echo $rslt['mother_name'].' '.$rslt['mother_lname']; ?></div>
       
            </div>
            </div>
            
<?php endforeach; ?>
            <div class="form-group col-md-6">
                <label class="control-label">Nationality:</label>
                <div><input type="text" name="nationality" id="nationality"  value="<?php echo $student->nationality; ?>" placeholder="" class="form-control" required readonly="">  <div id="nationality_val" class="print_text"><?php echo $student->nationality; ?> </div>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label class="control-label">Date of Birth:(dd/mm/yy):</label>
                <div>
                    <input type="text" name="dob" id="birhtday" value="<?php echo $student->birthday; ?>" placeholder="" class="form-control" required readonly="">
     <div id="birhtday_val" class="print_text"> <?php echo $student->birthday; ?></div>
     </div>
            </div>
           
            <div class="form-group col-md-6">
                <label class="control-label">Class to which he/she was admitted</label>
                <div>   
                    <input type="text" name="class" id="class" value="<?php  if($class_admitted!=''){echo $class_admitted->name;}else{ echo "";} ?>" placeholder="" class="form-control" readonly="">
        <div id="class_val" class="print_text"><?php  if($class_admitted!=''){echo $class_admitted->name;}else{ echo "";} ?></div>
    </div>
            </div>
            <div class="form-group col-md-6">
                <label class="control-label">Academic Year</label>
                <div>
                    <input type="text" onchange="show_value();" name="academic_year1" id="academic_year1" value="<?php if(!empty($certificate_detail))echo $certificate_detail->addmitted_class_year; ?>" placeholder="" class="form-control" onkeypress="return isNumberKey(event)" readonly="">
    <div id="academic_year1_val" class="print_text"><?php if(!empty($certificate_detail))echo $certificate_detail->addmitted_class_year; ?>"</div>
                </div>
            </div>

            <br>

            <div class="form-group col-md-6">
                <label class="control-label">The Present Class:</label>
                <div>
                    <input type="text" name="present_class" id="present_class" value="<?php echo $present_class->name; ?>" placeholder="" class="form-control" readonly="">
    <div id="present_class_val" class="print_text"><?php echo $present_class->name; ?></div></div>
            </div>

            <div class="form-group col-md-6">
                <label class="control-label">Academic Year</label>
                <div>
                     <input type="text" name="academic_year1" id="academic_year1" value="<?php echo $running_year; ?>" placeholder="" class="form-control" onkeypress="return isNumberKey(event)" readonly="">
    <div id="academic_year1_val" class="print_text"><?php echo $running_year; ?></div>
                </div>
            </div>
            
            <div class="form-group col-md-6">&nbsp;</div>
            <label class="control-label col-sm-12 m-b-20" >Result at the end of academic year, or upon departure:</label>


            <div class="form-group col-md-6">
                <label class="control-label"> a) Passed and Promoted to class</label>
                <div>
                   <input type="text" name="p1_class" id="p1_class" placeholder=""class="form-control" value="<?php if($certificate_detail!='') echo $certificate_detail->promote_class;  ?>" readonly="">
                   <div id="p1_class_val" class="print_text"><?php if($certificate_detail!='') echo $certificate_detail->promote_class;  ?></div>
            </div>
            </div>
            <div class="form-group col-md-6">
                <label class="control-label">For Academic Year</label>
                <div>
                    <input type="text" name="academic_year3" id="academic_year3" placeholder="" value="<?php if(!empty($certificate_detail))echo $certificate_detail->promote_class_year; ?>" class="form-control" onkeypress="return isNumberKey(event)" readonly="">
    <div id="academic_year3_val" class="print_text"><?php if(!empty($certificate_detail))echo $certificate_detail->promote_class_year; ?></div>
                </div>
            </div>

            <div class="form-group col-md-6">
                <label class="control-label">b) Detained in class</label>
                <div>
                    <input type="text" name="p1_class11" id="p1_class11" placeholder="" class="form-control" value="<?php if(!empty($certificate_detail)) echo $certificate_detail->detained_class; ?>" readonly="">
                 <div id="p1_class11_val" class="print_text"><?php if(!empty($certificate_detail)) echo $certificate_detail->detained_class; ?></div>
                </div>
            </div>

            <div class="form-group col-md-6">
                <label class="control-label">For Academic Year</label>
                <div>
                     <input type="text" name="academic_year33" id="academic_year33" placeholder="" value="<?php if(!empty($certificate_detail))echo $certificate_detail->detained_class_year; ?>" class="form-control" onkeypress="return isNumberKey(event)" readonly="">
                     <div id="academic_year33_val" class="print_text"><?php if(!empty($certificate_detail))echo $certificate_detail->detained_class_year; ?></div>
                </div>
            </div>
            
            <div class="form-group col-md-6">
                <label class="control-label">Observation if any: </label>
                <div>
                    <input type="text" name="observation" id="observation" placeholder="" value="<?php if(!empty($certificate_detail)) echo $certificate_detail->observation;?>" class="form-control" readonly="">
    <div id="observation_val" class="print_text"><?php if(!empty($certificate_detail)) echo $certificate_detail->observation;?></div>
                </div>
            </div>
            
            <div class="form-group col-md-6">
                <label class="control-label">Date of application for certificate: </label>
                <div>
                    <input type="text" name="app_certificate" id="app_certificate" placeholder="" class="form-control" value="<?php if(!empty($certificate_detail)) echo $certificate_detail->certificate_date;?>" readonly="">
    <div id="app_certificate_val" class="print_text"><?php if(!empty($certificate_detail)) echo $certificate_detail->certificate_date;?></div>
                </div>
            </div>


            <div class="form-group col-md-6">
                <label class="control-label">Date of issue of certificate: </label>
                <div>
                <input type="text" name="dat_of_issue" id="dat_of_issue" placeholder="" value="<?php echo $crnt_date; ?>" class="form-control" readonly="">
        <div id="dat_of_issue_val" class="print_text"><?php echo $crnt_date; ?></div>
                </div>
            </div>

            <label class="control-label col-sm-12 m-b-20">Headmaster/ Principal/ Director of school: </label>
         
            <div class="form-group col-md-4">
                <label class="control-label">Name: </label>
                <div>
                    <input type="text" name="headmaster_name" id="headmaster_name" placeholder="" class="form-control" value="<?php if(!empty($certificate_detail)) echo $certificate_detail->headmaster_name; ?>" readonly="">
    <div id="headmaster_name_val" class="print_text"><?php if(!empty($certificate_detail)) echo $certificate_detail->headmaster_name; ?></div>
                </div>
            </div>
            <div class="col-md-12">&nbsp;</div>
            <div class="col-md-12">&nbsp;</div>
            <div class="col-xs-12 col-md-offset-8 col-md-6"> </div>
            <div class="form-group col-md-4">
                <label class="control-label">Signature: </label>
               
            </div>
             <div class="col-xs-12 col-md-offset-8 col-md-6"> </div>

            <div class="col-md-12 text-right m-t-30">
                <label class="control-label">School Stamp</label>
            </div>

        </form>
    </div>
</div>
<div class="col-md-1"></div>
<?php }
else{
     echo "<div class='col-md-12 no-padding'> <div class='panel panel-danger'>
                <div class='panel-heading'>
                    <div class='panel-title text-white'>No information available for Transfer Certificate!!!
                    </div>
                </div> 
            </div></div>";
}
}else{
     echo "<div class='col-md-12 no-padding'> <div class='panel panel-danger'>
                <div class='panel-heading'>
                    <div class='panel-title text-white'>No information available for Transfer Certificate!!!
                    </div>
                </div> 
            </div></div>";
}
?>
<script type="text/javascript"> 
  $( 'input[type="text"]' ).change(function() {
   var elem=this.id+'_val';
   thisId=this.id;
   setVal(elem,this.value);
});
   function setVal(elem,value){
  document.getElementById(elem).innerHTML=value;
 }
</script>
<script type="text/javascript">
    
function PrintElem(elem) {
    
    $('input[class="form-control"]').hide();    
       
        
         $('div[class="print_text"]').show();
          Popup($(elem).html());
        }
        
     function Popup(data) {   
             var myWindow = window.open('', 'my div', 'height=400,width=600');
            myWindow.document.write('<html><head><title></title>');
            myWindow.document.write('<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/transfer_certificate_print.css" type="text/css" /><style type="text/css">.print_text{color:#333 !important;float:left !important;width:100% !important; height: auto !important;padding: 5px !important;font-size: 1em !important;line-height: 1.42857143 !important; background-color: #ffffff;background-image: none; margin-top:-5px !important;border: 1px solid !important; border-radius: 5px;height: 25px !important;}.form-group{padding-bottom:10px !important;}</style>');
            myWindow.document.write('</head><body>');
            myWindow.document.write(data);
            myWindow.document.write('</body></html>');
            myWindow.document.close(); // necessary for IE >= 10

            myWindow.onload=function(){ // necessary if the div contain images
$('input[class="form-control"]').show();   
$('div[class="print_text"]').hide();   
                myWindow.focus(); // necessary for IE >= 10
                myWindow.print();
                myWindow.close();
            };
        }
 function isNumberKey(evt)
  {
     var charCode = (evt.which) ? evt.which : event.keyCode
     if (charCode != 45  && charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

     return true;
  }
</script>