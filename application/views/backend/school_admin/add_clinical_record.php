<!DOCTYPE html>
<html lang="en">
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid">
  <h3>Enter Patient's Details</h3>
  
      <?php echo form_open(base_url().'index.php?school_admin/add_clinical_record', array('class' =>'form-horizontal','id'=>'studentClinicalForm'));?>
     
    <div class="form-group">
      <label class="control-label col-sm-2" for="first_name">First Name:<span class="error" style="color: red;"> *</span></label>
      <div class="col-sm-5">
        <input type="text" class="form-control" id="first_name" name = "first_name" placeholder="Enter First Name" required >
      </div>
    </div>
      
      
      
    <div class="form-group">
      <label class="control-label col-sm-2" for="last_name">Last Name:<span class="error" style="color: red;"> *</span></label>
      <div class="col-sm-5">          
        <input type="text" class="form-control" id="last_name" name= "last_name_done" placeholder="Enter Last Name"  required>
      </div>
    </div>
  
    <div class="form-group">
      <label class="control-label col-sm-2" for="gender">Gender:<span class="error" style="color: red;"> *</span></label>
      <div class="col-sm-5">
        <select  class="selectpicker" data-style="form-control" data-live-search="true" name="gender" id="gender" required>
	<option value="Male" >Male</option>
	<option value="Female" >Female</option>	
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="birthday">Birthday:<span class="error" style="color: red;"> *</span></label>
      <div class="col-sm-5">
        <input type="text" class="form-control date-picker" id="datepicker" placeholder="" name="birthday" required>
      </div>
    </div>
      
      
       <div class="form-group">
           <label class="control-label col-sm-2" for="age">Age:</label>
      <div class="col-sm-2">
        <input type="tel" class="form-control" id="age" name = "age" placeholder="Present Age">
      </div>
      <label class="control-label col-sm-1" for="mobile">Mobile:</label>
      <div class="col-sm-2">
        <input type="tel" class="form-control" id="mobile" placeholder="Enter Mobile" name="mobile" required>
      </div>
    </div>

 <div class="form-group">
      <label class="control-label col-sm-2" for="history">History:</label>
      <div class="col-sm-5">
        <select  class="selectpicker" data-style="form-control" data-live-search="true" name="history" id="history">
	<option value="Unkown" >Unkown</option>
	<option value="Asthma" >Asthma</option>
	<option value="Diabetes" >Diabetes</option>
	<option value="Blood pressure" >Blood pressure</option>
	<option value="Medication allergies" >Medication allergies</option>
	<option value="Food allergies" >Food allergies</option>
	<option value="None" >None</option></select>
      </div>
    </div>     
      
             
    <div class="form-group">        
      <label class="control-label col-sm-2" for="surgical_history">Surgical History:</label>
        <div class="col-sm-5">          
        <textarea class="form-control" rows="5" id="surgical_history" name="surgical_history"></textarea>
        </div>
    </div>
      
    <div class="form-group">        
      <label class="control-label col-sm-2" for="obstetric_history">Obstetric History:</label>
        <div class="col-sm-5">          
        <textarea class="form-control" rows="5" id="obstetric_history"  name="obstetric_history"></textarea>
        </div>
    </div>
      
    <div class="form-group">        
      <label class="control-label col-sm-2" for="genetic_diseases">Genetic diseases:</label>
        <div class="col-sm-5">          
        <textarea class="form-control" rows="5" id="genetic_diseases" name="genetic_diseases"></textarea>
        </div>
    </div>
      
      
    <div class="form-group">        
      <label class="control-label col-sm-2" for="other_details">Other details:</label>
        <div class="col-sm-5">          
        <textarea class="form-control" rows="5" id="other_details" name="other_details"></textarea>
        </div>
    </div>  
   
  <div class="col-md-12 text-center"> 
         <button type="submit" class="btn btn-primary" id="insert" name="save_details" value="save_details"><i class="fa fa-save"> </i> Add Clinical Record</button>
 
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
