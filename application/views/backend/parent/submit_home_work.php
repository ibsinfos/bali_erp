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
    <div class="form-group">
        <h3>Submit <?php echo $hw_details['hw_name']; ?></h3>
    </div>
      <?php echo form_open(base_url().'index.php?parents/submit_home_work/create/'.$hw_details['home_work_id'].'/'.$student_id, array('class' =>'form-horizontal','id'=>'homework_submit_form'));?>
     
    <div class="form-group">
        <label class="control-label col-md-4" for="first_name">Home Work :</label>
        <div class="col-sm-5">
            <?php echo $hw_details['hw_name']; ?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-4" for="start date">Start Date:</label>
        <div class="col-sm-5">          
            <?php echo $hw_details['start_date']; ?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-4" for="end date">End Date:</label>
        <div class="col-sm-5">
            <?php echo $hw_details['end_date']; ?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-4" for="comment">Comment:<span class="error" style="color: red;"> *</span></label>
        <div class="col-sm-5">
              <input type="text" class="form-control"  id='home_work_comment'  name='home_work_comment' required >
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-4" for="age">Descriptions:</label>
        <div class="col-sm-2">
          <textarea class='summernote'  name="hw_description" id="hw_description" required ></textarea>
        </div>
    </div>
    OR
    <div class="form-group">        
      <label class="control-label col-md-4" for="other_details">Attachments:</label>
        <div class="col-sm-5">          
        <input type="file" class="form-control" name="home_work_file" id="home_work_file">
        </div>
    </div>  
    <div class="col-md-12 text-center"> 
           <button type="submit" class="btn btn-primary" id="insert" name="save_details" value="save_details"><i class="fa fa-save"> </i> Save Details</button>

    </div>
    <?php echo form_close();?>
</div> 
</body>
</html>

