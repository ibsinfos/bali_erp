<style>
    .res_enq{
        float:right;
        padding:10px;
        background:#FF9009;
        border-color:#FF9009;
        margin-bottom:10px;
        margin-top:10px;
    }
</style>

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

<?php $BRC = get_bread_crumb(); if (strpos($BRC, '^') !== false) { $ExpBrd = explode('^', $BRC);?>
            <li>
                <?php echo get_phrase(@$ExpBrd[0]); ?>
                <?php echo @$ExpBrd[1]; ?>
            </li> <?php }else{ $ExpBrd[2] = $BRC;}?>
            <li class="active">
                <?php echo get_phrase(@$ExpBrd[2]); ?>
            </li>
        </ol>
    </div>
</div>
  
<div class="panel panel-danger block6" data-step="5" data-intro="<?php echo get_phrase('For Information');?>" data-position='bottom'>
    <div class="panel-heading"> Instructions to be followed:
        <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
    </div>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
            <p><strong>Dear Parent/Guardian,</strong></p>
            <p>
                 Welcome to our school's Admission Center. Please use this form to apply for your child's admission to our school. We need complete and accurate
                information about the student, so make sure you fill out all fields. School Admission Forms are processed within 48 hours. You will receive an 
                email confirmation when we process your application.
            </p>
        </div>
    </div>
</div>


<?php echo form_open(base_url().'index.php?school_admin/admission_enquiry', array('id'=>'studentEnquiryForm'));?> 
<?php if($this->session->flashdata('flash_message_error')) {?>        
	<div class="alert alert-danger">
		<?php echo $this->session->flashdata('flash_message_error'); ?>
	</div>
<?php } ?>

<div class="white-box" data-step="6" data-intro="<?php echo get_phrase('Fill the required fields and then click on Admit Student for admission.');?>" data-position='top'>
	<div class="row" > 
	    <div class="col-md-4">
			<div class="form-group">
			    <label for="phone"><?php echo get_phrase("mobile_#"); ?><span class="error" style="color: red;"> *</span></label>
			    <div class="input-group">
					<div class="input-group-addon"><i class="fa fa-mobile"></i></div>
				    <input type="tel" class="form-control numeric" id="phone"  placeholder="Mobile Number" name="mobile_number"  value="<?php echo set_value('mobile_number'); ?>" maxlength="10" required>       
			    </div>
			</div>
		</div>
	    	
	    <div class="col-md-4">
			<div class="form-group">
			    <label for="name"><?php echo get_phrase("Student's First Name"); ?><span class="error" style="color: red;"> *</span></label>
			    <div class="input-group">
				<div class="input-group-addon"><i class="ti-user"></i></div>
				    <input type="text" class="form-control"  name = "student_fname" value="<?php echo set_value('student_fname'); ?>" required placeholder="Student's First Name"  >
				</div>
			</div>
	    </div>
	    
	    <div class="col-sm-4">
			<div class="form-group">
			    <label for="flname"><?php echo get_phrase("last_name"); ?></label>
			    <div class="input-group">
					<div class="input-group-addon"><i class="ti-user"></i></div>
				    <input type="text" class="form-control" name="student_lname" value="<?php echo set_value('student_lname'); ?>" placeholder="Student's Last Name"> 
				</div>
			</div>
	    </div>
	</div>

	<div class="row">
    	<div class="col-md-4">
			<div class="form-group">
	    		<label for="mname"><?php echo get_phrase("Father's First Name"); ?><span class="error" style="color: red;"> *</span></label>
	    		<div class="input-group">
					<div class="input-group-addon"><i class="fa fa-male"></i></div>
	    			<input type="text" class="form-control" name="parent_fname" value="<?php echo set_value('parent_fname'); ?>" required placeholder="Father's First Name"  required>       
	    		</div>
	    	</div>
	    </div>

	    <div class="col-md-4">
			<div class="form-group">
			    <label for="mmname"><?php echo get_phrase("last Name"); ?></label></label>
			    <div class="input-group">
					<div class="input-group-addon"><i class="fa fa-male"></i></div>
			        <input type="text" class="form-control" id="mmname"  name="parent_lname" value="<?php echo set_value('parent_lname'); ?>" placeholder="Father's last Name" >
				</div>
			</div>
		</div>
    
	    <div class="col-md-4">
			<div class="form-group">
			    <label for="mlname"><?php echo get_phrase("Mother's First Name"); ?><span class="error" style="color: red;"> *</span></label>
			    <div class="input-group">
					<div class="input-group-addon"><i class="fa fa-female"></i></div>

				    <input type="text" class="form-control" id="mlname"  placeholder="Mother's First Name" name="mother_fname" value="<?php echo set_value('mother_fname'); ?>" required> 
				</div>
			</div>
		</div>
	</div>

	<div class="row">
	    
	    <div class="col-md-4">
			<div class="form-group">
			    <label for="mlname"><?php echo get_phrase("Last Name"); ?></label>
			    <div class="input-group">
					<div class="input-group-addon"><i class="fa fa-female"></i></div>

		                <input type="text" class="form-control" placeholder="Mother's Last Name" name="mother_lname" value="<?php echo set_value('mother_lname'); ?>"> 
				</div>
			</div>
	    </div>
	        
	    <div class="col-md-4">
	        <div class="form-group">
	            <label><?php echo get_phrase("you_want_to_apply_for");?><span class="error" style="color: red;"> *</span></label>                       
	            <select name="class" class="selectpicker" data-style="form-control" data-live-search="true" required="required" onchange="checkavailability_byclass(this.value);" >                            
	                <option value="<?php echo set_value('class'); ?>"><?php echo get_phrase('select_class');?></option>
	                <?php foreach($classes as $class):?>
	                <option value="<?php echo $class['class_id'];?>" <?php echo set_value('class')==$class['class_id']?'selected':''?>><?php echo get_phrase('class');?><?php echo " ".$class['name'];?></option> 
	                <?php endforeach; ?> 
	            </select>  
	        </div>
	    </div>
	    
	        
	    <div class="col-md-4">
	        <div class="form-group">
				<label><?php echo get_phrase("previous_class");?><span class="error" style="color: red;"> *</span></label>   
				<!-- onchange="show_previous_school(this)" -->                    
				<select  class="selectpicker" data-style="form-control" data-live-search="true" required name="previous_class" id="previous_class" required>                            
	                <option value=""><?php echo get_phrase('select_class');?></option>
	                <option value="-10" <?php echo set_value('previous_class')=='-10'?'selected':''?>>N/A</option>
	                <?php foreach($classes as $class):?>
	                <option value="<?php echo $class['class_id'];?>" <?php echo set_value('previous_class')==$class['class_id']?'selected':''?>><?php echo get_phrase('class');?><?php echo " ".$class['name'];?></option> 
	                <?php endforeach; ?> 
	            </select>
	        </div>         
	    </div>
	</div>


	<div class="row">
	    
	    <div class="col-md-4 <?php echo set_value('previous_class')=='-10' || !set_value('previous_class')?'dis-none':''?> previous_class">
		    <div class="form-group">
	            <label for="privious school"><?php echo get_phrase("Previous School"); ?><span class="error" style="color: red;"> *</span></label>
	            <div class="input-group">
	                <div class="input-group-addon"><i class="fa fa-id-card"></i></div>
	                <input type="text" class="form-control" id="previous_school_input" placeholder="Previous School" name="previous_school" value="<?php echo set_value('previous_school'); ?>" > 
	            </div>
	        </div>
	    </div>

	    <div class="col-md-4">
			<div class="form-group">
		    	<label><?php echo get_phrase("Category "); ?><span class="error" style="color: red;"> *</span></label>
			    <select class="selectpicker" data-style="form-control"  data-live-search="true"  name='category' id ='category' required="required">
		            <option value='<?php echo set_value('category'); ?>'>Select Category</option>
		            <option value='GENERAL' <?php echo set_value('category')=='GENERAL'?'selected':''?>>GENERAL</option>
		            <option value='OBC' <?php echo set_value('category')=='OBC'?'selected':''?>>OBC</option>
		            <option value='ST' <?php echo set_value('category')=='ST'?'selected':''?>>ST</option>
		            <option value='SC' <?php echo set_value('category')=='SC'?'selected':''?>>SC</option>
		        </select>
	   		</div>
	    </div>

	    <div class="col-md-4">
			<div class="form-group">
			    <label><?php echo get_phrase("Date Of Birth"); ?><span class="error" style="color: red;"> *</span></label>
			    <div class="input-group">
				<div class="input-group-addon"><i class="fa fa-birthday-cake"></i></div>
		                <input type="text" class="form-control" placeholder="Date Of Birth" required="required" name="birthday" id="birthday" type="text" value="<?php echo set_value('birthday'); ?>" >
				</div>
			</div>
		</div>
	</div>

<div class="row">
    <div class="col-md-4">
	<div class="form-group">
	    <label><?php echo get_phrase("Gender"); ?><span class="error" style="color: red;">*</span></label>
	    
	    <select class="selectpicker" data-style="form-control"  data-live-search="true" name='gender' id ='gender' required="required">
            <option value="<?php echo set_value('gender'); ?>">Select Gender</option>
            <option value='Male' <?php echo set_value('gender')=='Male'?'selected':''?>>Male</option>
            <option value='Female' <?php echo set_value('gender')=='Female'?'selected':''?>>Female</option>                          
        </select> 
	</div>
    </div>


    <div class="col-md-4">
	<div class="form-group">
	    <label><?php echo get_phrase("Current Address"); ?><span class="error" style="color: red;">*</span></label>
<div class="input-group">
		<div class="input-group-addon"><i class="fa fa-address-card"></i></div>
	    <input type="text" class="form-control"  name="address" placeholder="Select Current Address" value="<?php echo set_value('address'); ?>" required>       
</div></div></div>
    
    <div class="col-md-4">
	<div class="form-group">
	    <label for="ficard_type"><?php echo get_phrase("Address Line 2"); ?></label>
	    <div class="input-group">
		<div class="input-group-addon"><i class="fa fa-address-card"></i></div>
	    <input type="text" class="form-control"  name="address2" placeholder="Select Address Line 2"value="<?php echo set_value('address2'); ?>" >
	</div></div>
    </div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="form-group">
	    	<label for="state"><?php echo get_phrase("Country"); ?><span class="error" style="color: red;"> *</span></label>
    		<div class="input-group">
				<div class="input-group-addon"><i class="fa fa-globe"></i></div>
				<select  class="selectpicker" data-style="form-control" id="country" name= "country" required onchange="get_state()" data-live-search="true">
                    <option value="">Select Country</option>
					<?php if(count($CountryList)){ foreach($CountryList as $country){ ?>
						<option value="<?php echo $country['location_id'];?>"><?php echo ucwords($country['name']);?></option>
					<?php }}?>
                </select>
        	</div>
        </div>
    </div>    
	
    <div class="col-md-4">
		<div class="form-group">
		    <label for="micard_type" class="col-form-label"><?php echo get_phrase("State"); ?><span class="error" style="color: red;">*</span></label>
		    <div class="input-group">
				<div class="input-group-addon"><i class="fa fa-id-badge"></i></div>
			    <select  class="selectpicker" data-style="form-control" name='region' id ='state' required data-live-search="true">
                    <option value="">Select State</option>
                </select>
		    </div>
	    </div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
	    	<label><?php echo get_phrase("City"); ?><span class="error" style="color: red;">*</span></label>
		    <div class="input-group">
				<div class="input-group-addon"><i class="fa fa-id-card"></i></div>
		    	<input type="text" class="form-control" placeholder="Current City" name="city" value="<?php echo set_value('city'); ?>" required > 
		    </div>
	    </div>
	</div>    
</div>

<div class="row">
    <div class="col-md-4">
		<div class="form-group">
	    	<label for="city"><?php echo get_phrase("Postal Code"); ?><span class="error" style="color: red;"> *</span></label>
		    <div class="input-group">
				<div class="input-group-addon"><i class="fa fa-globe"></i></div>
	            <input type="text" class="form-control numeric" placeholder="Postal Code" name="zip_code" value="<?php echo set_value('zip_code'); ?>" required maxlength="10">       
		    </div>
	    </div>
	</div>

    <div class="col-md-4">
	<div class="form-group">
	    <label for="guradian_email"><?php echo get_phrase("User Email"); ?></label>
	    <div class="input-group">
		<div class="input-group-addon"><i class="fa fa-envelope"></i></div>
	    <input type="email" class="form-control" placeholder="User Email"name="user_email" value="<?php echo set_value('user_email'); ?>" >
	    </div></div></div>
    
    
    <div class="col-md-4">
	<div class="form-group">
	    <label for="home_phone"><?php echo get_phrase("Landline Number"); ?></label>
	    <div class="input-group">
		<div class="input-group-addon"><i class="fa fa-phone" ></i></div>
	    <input type="tel" class="form-control numeric" name="phone" placeholder="Landline Number" value="<?php echo set_value('phone'); ?>" >
	    </div></div></div>
</div>

<div class="row">
    
    <div class="col-md-4">
	<div class="form-group">
	    <label for="home_phone"><?php echo get_phrase("Work Number"); ?></label>
	    <div class="input-group">
		<div class="input-group-addon"><i class="fa fa-phone" ></i></div>
	    <input type="tel" class="form-control numeric" name="work_phone" placeholder="Work Number" value="<?php echo set_value('work_phone'); ?>" >
	    </div></div></div>
    
    <div class="col-md-4">
	<div class="form-group">
	    <label for="home_phone"><?php echo get_phrase("Annual Salary"); ?></label>
	    <div class="input-group">
		<div class="input-group-addon"><i class="fa fa-money" ></i></div>
	    <input type="tel" class="form-control numeric"  name="annual_salary" placeholder="Annual Salary" value="<?php echo set_value('annual_salary'); ?>" >
	    </div></div></div>
    
    <div class="col-md-4">
		<div class="form-group">
			<label for="guardian_first_name" class="col-form-label"><?php echo get_phrase("guardian_first_name"); ?></label>
			<div class="input-group">
			<div class="input-group-addon"><i class="ti-user"></i></div>
			<input type="text" class="form-control" id="guardian_first_name" name="guardian_first_name" placeholder="First Name" value="<?php echo set_value('guardian_first_name'); ?>" >       
			</div>
		</div>
	</div>
</div>

<div class="row">    
    <div class="col-md-4">
	<div class="form-group">
	    <label for="guardian_last_name" class="col-form-label"><?php echo get_phrase("guardian_last_name"); ?></label>
	    <div class="input-group">
		<div class="input-group-addon"><i class="ti-user"></i></div>
	    <input type="text" class="form-control" id="guardian_last_name" name="guardian_last_name" placeholder="Last Name" value="<?php echo set_value('guardian_last_name'); ?>" >
	    </div></div></div>
    
    <div class="col-md-4">
	<div class="form-group">
	    <label for="guradian_profession" class="col-form-label"><?php echo get_phrase("guardian_profession"); ?></label>
	    <div class="input-group">
		<div class="input-group-addon"><i class="fa fa-briefcase"></i></div>
	    <input type="text" class="form-control" id="guradian_profession" name= "guradian_profession" placeholder="Profession" value="<?php echo set_value('guradian_profession'); ?>" > 
	    </div></div></div>
    
    <div class="col-md-4">
        <div class="form-group">
            <label for="guardian_address" class="col-form-label"><?php echo get_phrase("guardian_address"); ?></label>    
            <textarea class="form-control" rows="1"  name="guardian_address" value="<?php echo set_value('guardian_address'); ?>" ></textarea>    
        </div>
    </div>
    
</div>

<div class="row">   
    <div class="col-md-4">
	<div class="form-group">
	    <label for="guradian_email"><?php echo get_phrase("guradian_email"); ?></label>
	    <div class="input-group">
		<div class="input-group-addon"><i class="fa fa-envelope"></i></div>
	    <input type="email" class="form-control" id="guradian_email" name="guradian_email" placeholder="Email" value="<?php echo set_value('guradian_email'); ?>" >
	    </div></div></div>
    <div class="col-md-4">
	<div class="form-group">
	    <label for="guradian_relation"><?php echo get_phrase("guradian_relation"); ?></label>
	    <div class="input-group">
		<div class="input-group-addon"><i class="fa fa-retweet"></i></div>
                <input type="text" class="form-control" id="guradian_relation" name="guradian_relation" placeholder="relation" value="<?php echo set_value('guradian_relation'); ?>" >
	    </div></div></div>
    
    <div class="col-md-4">
    <div class="form-group">
	<label for="emergency_contact"><?php echo get_phrase("guardian_emergency_contact");?></label>
	<div class="input-group">
		<div class="input-group-addon"><i class="fa fa-volume-control-phone"></i></div>
	<input type="tel" class="form-control numeric" name= "guardian_emergency_number" title="Please enter any mobile number for emergency contact" placeholder="Guardian Emergency Number" value="<?php echo set_value('emergency_contact'); ?>" maxlength="10"> 
	</div></div>
        </div>
     <div class="col-md-4">
    <div class="form-group">
	<label for="media_consent"><?php echo get_phrase("media_consent");?></label>
	<div class="input-group">
            <input type="radio" name="media_consent" value="NO" checked="">NO &nbsp;
                <input type="radio" name="media_consent" value="YES">YES
	</div></div>
        </div>
</div>
    
    
        <!-- <div class="col-md-12 col-sm-6 col-xs-12 form-group">
            <div class="col-md-4 col-sx-6 form-group no-padding">
                <label><?php echo get_phrase("is_advance_paid ?");?><span class="error" style="color: red;"> *</span></label>
                <div class="form-check inline" >
                    <label class="form-check-label"><input class="form-check-input" type="radio" name="advance" id="advance_yes" value="yes"  required>YES</label>                      
                    <label class="form-check-label"><input class="form-check-input" type="radio" name="advance" id="advance_no" value="no" checked>NO</label>
                </div>  
            </div>	 
        
            <div class="col-md-4 col-sx-6 form-group" >    
                <div class="col-sm-6" id="receipt_no">
                    <label><?php echo get_phrase("receipt_number");?></label>
                    <input type="text" class="form-control" name="receipt_no" id="text1" maxlength="30">
                </div> 
            </div>
        </div> -->
        
        <div class="row" >

        <div class="text-right col-xs-12 p-t-20 no-padding">


            <button type="submit"  class="fcbtn btn btn-danger btn-outline btn-1d" id="admit" name="submit_application"  ><?php echo get_phrase("admit_student");?></button>

        </div>
    </div>

 </div>   

    
<?php //echo form_close(); ?>


</div>
  
<?php echo form_close();?>

<script type="text/javascript">
$(document).ready(function () {
	$("#receipt_no").hide();
	$("#advance_yes").click(function () {
		$("#receipt_no").show();
	});
	$("#advance_no").click(function () {
		$("#receipt_no").hide();
	});

	$('#mobile_number').on('blur',function(){
		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>index.php/?ajax_controller/get_latest_parrent_details_for_student_inquiry',
			data:"mobile_number="+$(this).val(),
			success:function(retData){
				contact = JSON.parse(retData);
				if(contact.exist==='yes'){
					console.log("comming with exist data");
					console.log(contact.data);
					oldData=contact.data;

					$('input[name=parent_fname]').val(oldData.parent_fname);
					$('input[name=parent_lname]').val(oldData.parent_lname);
					$('input[name=address]').val(oldData.address);
					$('input[name=address_second]').val(oldData.address_second);
					$('input[name=city]').val(oldData.city);
					$('input[name=region]').val(oldData.region);
					$('input[name=zip_code]').val(oldData.zip_code);
					$('input[name=country]').val(oldData.country);
					$('input[name=user_email]').val(oldData.user_email);
					$('input[name=phone]').val(oldData.phone);
					$('input[name=work_phone]').val(oldData.work_phone);
					$('input[name=mother_fname]').val(oldData.mother_fname);
					$('input[name=mother_lname]').val(oldData.mother_lname);
					$('input[name=category]').val(oldData.caste_category);
					$('input[name=gender]').val(oldData.gender);
					$('input[name=annual_salary]').val(oldData.annual_salary);
				}else{
					console.log("comming with no data");
				}
			}
		});
	});

	$("#previous_class").on("change",function(){
		if($(this).val()=='-10' || $(this).val()==''){
			$('#previous_school_input').removeAttr('required');
			$('.previous_class').hide();
		}else{
			$('#previous_school_input').attr('required','required');
			$('.previous_class').show();
		}
	});

	jQuery('.datepicker').datepicker({
		endDate: '-365d',
		autoclose: true
	});
	
	$(".numeric").numeric(); 

	$(document).on('change','#phone',function(){
		var phone = this.value;
		$.ajax({
			url : '<?php echo base_url();?>index.php?ajax_controller/check_parent_details_by_phone',
			type: 'POST',
			data :{phone: phone},
			dataType:'json',
			success: function(response){
				if(response.status==1){
					$('input[name=parent_fname]').val(response.father_name);
					$('input[name=parent_lname]').val(response.father_lname);
					$('input[name=mother_fname]').val(response.mother_name);
					$('input[name=mother_lname]').val(response.mother_lname);
					$('input[name=user_email]').val(response.email);
				}
			},
			error: function(){
				alert('error');
			}
		});
	});
	
	$('input[name=student_fname],input[name=student_lname],input[name=parent_fname],input[name=parent_lname],input[name=mother_fname],input[name=mother_lname],input[name=guardian_first_name],input[name=guardian_last_name],input[name=guradian_profession],input[name=city]').on('keypress', function (event) {
		var regex = new RegExp("^[a-zA-Z]+$");
		var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
		if (!regex.test(key)) {
			event.preventDefault();
			return false;
		}
	});
});

function checkavailability_byclass(class_id){
	$.ajax({
		url : '<?php echo base_url();?>index.php?ajax_controller/check_availability_for_class',
		type: 'POST',
		data :{class_id: class_id},
		success: function(response){
			count = JSON.parse(response);
			if(count.allowed === 'no'){
				$('#availability').html('No seats available');
			}  else{
				$('#availability').html('');
			}  
		},
		error: function(){
			alert('error');
		}
	});
}

function get_state(){
	var CountryId = $('#country').val();
	if(CountryId!=''){
		var state = '<option value="">Select State</option>';
		$.ajax({
			url : '<?php echo base_url();?>index.php?ajax_controller/get_state',
			type: 'POST',
			data :{CountryId: CountryId},
			success: function(response){
				if(response){
					data = JSON.parse(response);
					if(data.length){
						for(k in data){
							state+='<option value="'+data[k]['location_id']+'">'+data[k]['name']+'</option>';
						}
					}else{
						alert('State not found');
					}                 
				}else{
					alert('State not found');
				}
				$('#state').empty();
				$('#state').html(state).selectpicker('refresh'); 
			},
			error: function(){
				alert('State not found');
				$('#state').empty();
				$('#state').html(state).selectpicker('refresh');
			}
		});       
	}
}
</script>
    
