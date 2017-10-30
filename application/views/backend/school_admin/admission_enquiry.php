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
  
<div class="panel panel-danger block6" data-step="5" data-intro="<?php echo get_phrase('For_Information');?>" data-position='bottom'>
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
<?php if($this->session->flashdata('flash_validation_error')) {?>        
	<div class="alert alert-danger">
		<?php echo $this->session->flashdata('flash_validation_error'); ?>
	</div>
<?php } ?>

<div class="white-box" data-step="6" data-intro="<?php echo get_phrase('Fill_the_required_fields_and_then_click_on_Admit_Student_for_admission.');?>" data-position='top'>
<?php
    create_dynamic_form($arrDynamic,$arrGroups, $arrLabel, $arrAjaxEvent, $arrValidation, $arrFieldValue, $arrFieldQuery,
            $arrDbField, $arrClass, $arrPlaceHolder, $arrMin,$arrMax, $arrPost);
 
                            


                           echo "<div class='col-md-12 text-center'>
                            <button type='submit' class='fcbtn btn btn-danger btn-outline btn-1d'>Submit</button>
                        </div>";

 echo form_close(); ?>
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
	 
	

	$(document).on('change','#mobile_number',function(){
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
				$('#region').empty();
				$('#region').html(state);
                                $('#region').selectpicker('refresh');
			},
			error: function(){
				alert('State not found');
				$('#region').empty();
				$('#region').html(state).selectpicker('refresh');
			}
		});       
	}
}
</script>
    
