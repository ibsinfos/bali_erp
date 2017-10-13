<?php
	if(count($sections)>0): 
?>
	
	<div class="form-group">
		<label class="col-sm-3 control-label"><?php echo get_phrase('section');?></label>
		<div class="col-sm-5">
                    <select name="section_id" class="selectpicker" data-style="form-control" data-live-search="true" required id="section_id" onchange="onsectionchange(this.value);">
				<option value=""><?php echo get_phrase('select_section');?></option>
				<?php foreach($sections as $section):?>
				<option value="<?php echo $section['section_id'];?>"
					<?php if($section['section_id'] == $section_id) echo 'selected';?>>
						<?php echo $section['name'];?>
					</option>
				<?php endforeach;?>
			</select>
		</div>
	</div>

<?php endif;?>


<div class="form-group">
		<label class="col-sm-3 control-label"><?php echo get_phrase('subject');?></label>
		<div class="col-sm-5">
			<select name="subject_id" class="form-control" required id="subject_holder">
				<option value=""><?php echo get_phrase('select_subject');?></option>
				<?php 
					
					foreach($subjects as $subject):
				?>
				<option value="<?php echo $subject['subject_id'];?>"
					<?php if($subject['subject_id'] == $subject_id) echo 'selected';?>>
						<?php echo $subject['name'];?>
		                </option>
				<?php endforeach;?>
			</select>
		</div>
	</div>


	<script type="text/javascript">
	$(document).ready(function() {
        if($.isFunction($.fn.selectBoxIt))
		{
			$("select.selectboxit").each(function(i, el)
			{
				var $this = $(el),
					opts = {
						showFirstOption: attrDefault($this, 'first-option', true),
						'native': attrDefault($this, 'native', false),
						defaultText: attrDefault($this, 'text', ''),
					};
					
				$this.addClass('visible');
				$this.selectBoxIt(opts);
			});
		}
    });
	
        
     function onsectionchange(section_id)
    {
//        alert(section_id);
//        die();
        //alert(section_id);
        var class_id = $('#class_id').val();
        //var section_id = $('#section_id').val();
        //$('#subject_holder').empty();
//        alert(class_id);
//        alert(section_id);die();
        
        jQuery('#subject_holder').html('<option value="">Select Subject</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>/index.php?ajax_controller/get_subjectby_class_section/' + class_id + '/' + section_id,
            
            success: function (response)
            {
                jQuery('#subject_holder').append(response).selectpicker('refresh');
            }
        });
         $('#subject_holder').trigger("chosen:updated");
    }           
        
</script>