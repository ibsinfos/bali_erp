<?php    
    if(count($sections) > 0):
           // $sections = $section->result_array();
?>
<input type="hidden" id="class_id" value="<?php echo $class_id; ?>">
<div class="form-group col-md-6">
    <label class="control-label"><?php echo get_phrase('section');?>
	<span class="error mandatory"> *</span>
    </label>
    
        <select name="section_id" class="selectpicker" data-style="form-control" data-live-search="true"  id="section_id" required="required" onchange="onsectionchange(this.value);">
            <option value=""><?php echo get_phrase('select_section');?></option>
        <?php
         foreach($sections as $row):
        ?>
     <option value="<?php echo $row['section_id'];?>"><?php echo $row['name'];?></option>
     <?php endforeach;?>
        </select>
    
</div>
 
<?php endif;?>

<div class="form-group col-md-6">
    <label class="col-sm-3 control-label"><?php echo get_phrase('subject');?>
	<span class="error mandatory" style="color: red;"> *</span>
    </label>
   
        <select name="subject_id" class="selectpicker" data-style="form-control" data-live-search="true"  required="required" id="subject_holder">
            <option value=""><?php echo get_phrase('select_subject');?></option>
        <?php

        ?>
        </select>
    
</div>


<script type="text/javascript">
    $(document).ready(function() {
        jQuery('.selectpicker').selectpicker({dropupAuto: false});
        if($.isFunction($.fn.select2))
        {
            $("select.select2").each(function(i, el)
            {
                var $this = $(el),
                    opts = {
                        showFirstOption: attrDefault($this, 'first-option', true),
                        'native': attrDefault($this, 'native', false),
                        defaultText: attrDefault($this, 'text', ''),
                    };
                    
                $this.addClass('visible');
                $this.select2(opts);
            });
        }
    });
    
    function onsectionchange(section_id)
    {
        var class_id = $('#class_id').val();

//        jQuery('#subject_holder').html('<option value="">Select Subject</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>/index.php?ajax_controller/get_subjectby_class_section/' + class_id + '/' + section_id,
            success: function (response)
            {
                jQuery('#subject_holder').append(response).selectpicker('refresh');
            }
        });
         //$('#subject_holder').trigger("chosen:updated");
    }       
    
</script>