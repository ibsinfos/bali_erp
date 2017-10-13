<div class="row">
<div class="col-md-12">
    <div class="white-box">    
        <?php
if (!empty($assignment_Details)){ ?>
                     <?php echo form_open(base_url().'index.php?student/view_assignments/update/'.$assignment_Details[0]['assignment_id'], array('class' =>'form-material validate','id'=>'editCampusUpdateId', 'enctype' => 'multipart/form-data'));?>
                    <div class="form-group">
                        <div class="col-md-6 m-b-20"> 
			<label for="field-1"><?php echo get_phrase('title');?></label>
                          <input type="text"  class="form-control" value="<?php echo $assignment_Details[0]['assignment_topic']; ?>" readonly="">
                        </div>
                 
                    <div class="col-md-6 m-b-20">
			<label for="field-1"><?php echo get_phrase('description');?></label>
                    <input type="text"  class="form-control" value="<?php echo $assignment_Details[0]['assignment_description']; ?>" readonly="">
                      </div>
                   
                    <div class="col-md-6 m-b-20">
			<label for="field-1"><?php echo get_phrase('date_of_assigned');?></label>
                    <input type="text"  class="form-control" value="<?php echo $assignment_Details[0]['assigned_date']; ?>" readonly="">
                      </div>
                    
                    <div class="col-md-6 m-b-20">
			<label for="field-1"><?php echo get_phrase('date_of_submission');?></label>
                        <input type="text"  class="form-control" value="<?php echo $assignment_Details[0]['submission_date'];?>" readonly="">
                      </div>
                    <div class="col-md-6 m-b-20">
			<label for="field-1"><?php echo get_phrase('answer');?><span class="error mandatory"> *</span></label>      
                       <textarea  class="form-control" id="answer" placeholder="Type your answer here " name="answer" required></textarea>
                      </div>
                   <div class="col-md-6 m-b-20">
			<label for="field-1"><?php echo get_phrase('comments');?><span class="error mandatory"> *</span></label>
                     <textarea  class="form-control" id="comments" placeholder="Type your comment here " name="comments" required></textarea>
                      </div>
                        <div class="col-md-6 m-b-20">
                   <label for="field-1"><?php echo get_phrase('file_to_upload');?><span class="error mandatory"> *</span></label>
                   <input type="file" name="userfile" required="" class="form-control" data-label="<i class='entypo-upload'></i> Browse"/>
                        <span class="mandatory"><?php echo get_phrase('supported_types_:_.doc_.xls_.pdf_.img');?></span></b>
                      </div>
                 <div class="col-md-12 m-b-20 text-right">
                        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" id="insert" name="save_details" value="save_details"><?php echo get_phrase('submit'); ?></button>
                        </div>
		      </div>
                        <?php echo form_close();?>
                    </div>
     
<?php } ?>
</div>
</div>