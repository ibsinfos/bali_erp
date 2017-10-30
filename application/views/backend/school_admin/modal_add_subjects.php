<div class="row">    
    <div class="form-group col-sm-6">
        <label class="control-label">Select Class</label>
        <select id="class" class="selectpicker1" data-style="form-control" data-live-search="true" onchange="return onclasschange(this.value);">
            <option value="">Select Class</option><?php  if(count($classes)){ foreach ($classes as $row): ?>
            <option  value="<?php echo $row['class_id'];?>"><?php echo get_phrase('class'); ?>&nbsp;<?php echo $row['name']; ?></option><?php endforeach; }?>
        </select>
    </div>
	<div class="form-group col-sm-6" id="section_list">
        <label class="control-label">Select Section</label>
        <select id="section" class="selectpicker1" data-style="form-control" data-live-search="true" onchange="return onsectionchange();">
            <option value="">Select Section</option><?php  if(count($classes)){ foreach ($classes as $row): ?>
            <option  value="<?php echo $row['class_id'];?>"><?php echo get_phrase('class'); ?>&nbsp;<?php echo $row['name']; ?></option><?php endforeach; }?>
        </select>
    </div>
</div>

<div class="row"><div id="ajaxholder"></div></div>

<script type="text/javascript">
  
function onclasschange(class_id)
{
    $.ajax({
            url: '<?php echo base_url(); ?>index.php?ajax_controller/get_sections_by_class/' + class_id,
            success: function (response)
            {
                jQuery('#section').html(response).selectpicker('refresh');
            }
        });
}
function onsectionchange()
{
	var class_id = $('#class').val();
	var section_id = $('#section').val();
    $.ajax({
		url: '<?php echo base_url();?>index.php?school_admin/<?php echo $param2;?>_subjects/' + class_id+'/'+section_id,
		success: function (response)
		{
			jQuery('#ajaxholder').html(response).selectpicker('refresh');
		}
	});
	   $('#ajaxholder').trigger("chosen:updated");
}
$('.selectpicker').selectpicker({dropupAuto: false});
</script>