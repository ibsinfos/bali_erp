<div class="row">    
    <div class="form-group col-sm-12">
        <label class="control-label">Select Class</label>
        <select class="selectpicker1" data-style="form-control" data-live-search="true" onchange="return onclasschange(this);">
            <option value="">Select Class</option><?php  if(count($class)){ foreach ($class as $row): ?>
            <option  value="<?php echo $row['class_id'];?>"><?php echo get_phrase('class'); ?>&nbsp;<?php echo $row['name']; ?></option><?php endforeach; }?>
        </select>
    </div>
</div>

<div class="row"><div id="ajaxholder"></div></div>

<script type="text/javascript">
function onclasschange(class_id)
{
    $.ajax({
            url: '<?php echo base_url();?>index.php?school_admin/cs_activities/' + class_id.value,
            success: function (response)
            {
                jQuery('#ajaxholder').html(response).selectpicker('refresh');
            }
        });
           $('#ajaxholder').trigger("chosen:updated");
}
</script>