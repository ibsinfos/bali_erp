<?php 

$room_detail = json_decode(json_encode($room_detail), True);
$size = count($room_detail);
			$cols = ceil(sqrt($size));
			$rows = ceil($size/$cols); ?>
<div class="col-xs-12 col-md-3 form-group"></div>
                <div class="col-xs-12 col-md-6 form-group">
                <table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th colspan="<?=$cols?>"><?php echo get_phrase('Available_Rooms'); ?></th>
							</tr>
						</thead>
						<tbody>
						<?php for ($t=0, $i=0; $t<$rows; ++$t) { ?>
							<tr>
								<?php for($j=0; $j<$cols && $i<$size; ++$i, ++$j) { ?>
								<td class="td-actions">
								<button type="button" onclick="return room_detail_pass('<?php echo base_url();?>index.php?modal/popup/modal_hostel_room_allocate/','<?=$room_detail[$i]['hostel_room_id'];?>')" name="room_id" value="<?=$room_detail[$i]['available_beds'];?>"  class="btn btn-small btn-primary">Room No:<?=$room_detail[$i]['room_number']?><br><i class="btn-icon-only icon-edit"> </i></button>
								
								<button type="button" name="room_id" value="<?=$room_detail[$i]['available_beds'];?>" class="btn btn-small btn-success"><?=$room_detail[$i]['available_beds']?><br><i class="btn-icon-only icon-edit"> </i></button>
								
								
								<button type="button" name="room_id" value="<?=$room_detail[$i]['occupied_beds'];?>" onclick="return confirm('Are you sure ?')" class="btn btn-small btn-danger"><?=$room_detail[$i]['occupied_beds'];?><br><i class="btn-icon-only icon-edit"> </i></button>
								
								</td>
							<?php } ?>
							</tr>
						<?php } ?>
						</tbody>
					</table> 
                </div>
                <div class="col-xs-12 col-md-3 form-group"></div>
<script>
function room_detail_pass(url,room_no)
{
	
	var data = $('#hostel_registration').serialize();
	data=data+"&room_no="+room_no;
	showAjaxModal(url + btoa(data));
		
}
</script>				
				