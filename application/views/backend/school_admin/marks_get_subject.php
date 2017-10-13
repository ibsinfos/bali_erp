<div class="col-sm-3 form-group">
    <label class="control-label"><?php echo get_phrase('section'); ?></label><span>*</span>
    <select name="section_id" id="section_id" class="selectpicker" data-style="form-control" data-live-search="true">
<?php if(count($sections)){ foreach($sections as $row): ?>
        <option value="<?php echo $row['section_id'];?>"><?php echo $row['name'];?></option>
<?php endforeach; }?>
    </select>
</div>

<div class="col-sm-3 form-group">
    <label class="control-label"><?php echo get_phrase('subject'); ?></label><span>*</span>
    <select name="subject_id" id="subject_id" class="selectpicker" data-style="form-control" data-live-search="true">
            <?php if(count($subjects)){                    
                    foreach($subjects as $row):
            ?>
            <option value="<?php echo $row['subject_id'];?>"><?php echo $row['name'];?></option>
            <?php endforeach; }?>
    </select>
</div>

<div class="text-right col-xs-12 p-t-20">           
    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('manage_marks'); ?></button>            
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
	
</script>