<?php 


$size = $room[0]->no_of_beds;
$cols = ceil(sqrt($size));
$rows = ceil($size/$cols);
$available=$room[0]->available_beds;
			?>
			
			  <?php echo form_open(base_url() . 'index.php?school_admin/hostel_registration/create', array('class' => 'form-groups-bordered  validate', 'target' => '_top','id'=>'model_hostel_registration')); ?> 
<div class="row">         


                <div class="col-xs-12 col-md-6 form-group">
                    <label for="field-1"> <?php echo get_phrase('room_no.'); ?><span class="error mandatory"> *</span>
                    </label> 
                    <input readonly id= "hostel_room" type="text" class="form-control"  name="hostel_room" placeholder="Room No" data-validate="required" value="<?php echo $room[0]->room_number; ?>">
                    <label class="mandatory hide" id="no_bed_error">Beds not available.</label>
                </div>
                
            </div>

            <div class="row">         
				<div class="col-xs-12 col-md-6 form-group form-group">
                    <label for="field-1"><?php echo get_phrase("hostel_registration_date"); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="icon-calender"></i></div>
                        <input id= "register_date" type="text" required=required class="form-control mydatepicker"  name="register_date" placeholder="Pick a date" data-validate="required" data-message-required ="Please pick a date">
                    </div>
                </div>

                <div class="col-xs-12 col-md-6 form-group form-group">
                    <label for="field-1"><?php echo get_phrase("vacating_date"); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="icon-calender"></i></div>
                        <input id= "vacating_date" required=required type="text" class="form-control mydatepicker"  name="vacating_date" placeholder="Pick a date" data-validate="required" data-message-required ="Please pick a date">
                    </div>
                </div>
                 
            </div>
			 <div class="row">  
			 <table class="table table-striped table-bordered">
			 
			 
						<thead>
							<tr>
								<th colspan="<?=$cols?>">Available Beds</th>
							</tr>
						</thead>
						<tbody>
						<?php for ($t=0, $i=0; $t<$rows; ++$t) { ?>
							<tr>
								<?php for($j=0; $j<$cols && $i<$size; ++$i, ++$j) { ?>
								<td class="td-actions">
								<?php if($i<$available)
								{?>
								<button  name="room_id" onclick="return confirm('Are you sure ?')" value="<?=$i+1?>" class="btn btn-small btn-success"><?=$i+1?><br><i class="btn-icon-only icon-edit"> </i></button>
								<?php
								}
								else
								{									
									?>
									
								
								<button type="button" name="room_id" value="<?=$i+1?>"  class="btn btn-small btn-danger"><?=$i+1?><br><i class="btn-icon-only icon-edit"> </i></button>
								<?php } ?>
								</td>
							<?php } ?>
							</tr>
						<?php } ?>
						</tbody>
					</table> 
				</div>
				<?php echo form_close(); ?>
					<script>
 $(document).ready(function () {

        $('#register_date').datepicker({
            format: "dd/mm/yyyy"
        }).on('change', function () {
            $('.datepicker').hide();
        });

        $('#vacating_date').datepicker({
            format: "dd/mm/yyyy"
        }).on('change', function () {
            $('.datepicker').hide();
        });
		$("#model_hostel_registration").submit(function(e){
			e.preventDefault();
	var formdata= $(this).serialize();
	
	formdata += '&<?php echo $formdata; ?>';
	submitForm(formdata);

  });

    });
	
function submitForm(formData){
        $.ajax({    
            type: 'POST',
            url: '<?php  echo base_url() . 'index.php?school_admin/hostel_registration/create';?>',
            data: formData,
            cache: false,
            
            success: function(response) {
                // display success message
               
            }
        });
		location.href = "<?php echo base_url() . 'index.php?school_admin/manage_allocation';?>"
    }	
	
</script>