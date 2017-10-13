<!DOCTYPE html>
<html lang="en">
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="dist/bootstrap-clockpicker.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
</head>
<body>
  <?php $id = $this->uri->segment(3);?>  
<?php //echo $param2;$student_personal_info = $this->Student_model->get_student_record(array('student_id' => $param2));?>
<div class="container">
  <h3>Schedule Appointment</h3>
  
      <?php echo form_open(base_url().'index.php?school_admin/fix_clinical_appointment/'.$id, array('class' =>'form-horizontal','id'=>'studentappointmentForm'));?>
     
    <div class="form-group">
      <label class="control-label col-sm-2" for="appointment_type">Appointment Type:<span class="error" style="color: red;"> *</span></label>
      <div class="col-sm-5">
        <input type="text" class="form-control" id="appointment_type" name = "appointment_type" placeholder="" required >
      </div>
    </div>
      <div class="form-group">
      <label class="control-label col-sm-2" for="date">Date:<span class="error" style="color: red;"> *</span></label>
      <div class="col-sm-5">
        <input type="text" class="form-control date-picker" id="datepicker" placeholder="" name="date" required>
      </div>
    </div> 
  
   <div class="form-group">
      <label class="control-label col-sm-2" for="date">Time:<span class="error" style="color: red;"> *</span></label>
      <div class="col-sm-5">          
        <input type="text" class="form-control" id="basicExample" name= "time" placeholder=""  required>
      </div>
    </div>
  
     <div class="form-group">
      <label class="control-label col-sm-2" for="status">Status:<span class="error" style="color: red;"> *</span></label>
      <div class="col-sm-5">          
          <label class="radio-inline">
      <input type="radio" name="status">Active
    </label>
    <label class="radio-inline">
      <input type="radio" name="status">Cancelled
    </label>    
      </div>
    </div>
  
    <div class="form-group">        
      <label class="control-label col-sm-2" for="prescription">Prescription:</label>
        <div class="col-sm-5">          
        <textarea class="form-control" rows="5" id="prescription" name="prescription"></textarea>
        </div>
    </div>
      
    <div class="form-group">        
      <label class="control-label col-sm-2" for="diagnosis">Diagnosis</label>
        <div class="col-sm-5">          
        <textarea class="form-control" rows="5" id="diagnosis"  name="diagnosis"></textarea>
        </div>
    </div>
      
    <div class="form-group">        
      <label class="control-label col-sm-2" for="comments">Comments:</label>
        <div class="col-sm-5">          
        <textarea class="form-control" rows="5" id="comments" name="comments"></textarea>
        </div>
    </div>
   
   
  
     <div class="col-md-12 text-center ">
         <button type="submit" class="btn btn-primary" id="insert" name="save_details" value="save_details"><i class="fa fa-calendar"></i> Confirm Appointment</button>
    </div> 
  
       <?php echo form_close();?>
</div>  
</body>
</html>

<script>
      $( function() {
    $( "#datepicker" ).datepicker();
  } );
  </script>

  
  
 
        <script type="text/javascript">
            $(function () {
                $('#basicExample').timepicker();
            });
        </script>
 