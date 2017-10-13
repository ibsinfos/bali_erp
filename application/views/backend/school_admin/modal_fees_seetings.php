<?php echo form_open(base_url() . 'index.php?school_admin/save_fees_settings', array('class' => 'input_fields_wrap'));?>
<div class="row">
    <div class="col-md-6">  
        <label class="sr-only" for="inlineFormInput">Fees Type</label>
        <input type="text" class="form-control" id="inlineFormInput" name="fees_name" placeholder="Fees Type">
    </div>
    <div class="col-md-6">
        <label class="sr-only" for="inlineFormInputGroup">Fees Amount</label>
        <select class="selectpicker1" data-style="form-control" data-live-search="true" id="exampleSelect1" name="fees_amount">
            <option value="0"><?php echo get_phrase('select_fees');?></option>
            <?php foreach ($charges as $charge): ?>
            <option value="<?php echo $charge['id']."-".$charge['sales_price'];?>"><?php echo $charge['name']."-".$charge['sales_price'];?></option>
            <?php endforeach;?>
        </select>
    </div>
</div>

<div class="row">
    <div class="text-right col-xs-12 p-t-20">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('save');?></button>
    </div>
</div>
<?php echo form_close();?>





<script>
    $(document).ready(function() {
        var max_fields      = 10; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID

        var x = 1; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div><input type="text" class="form-control" name="fees_name[]"/><select class="selectpicker1" data-style="form-control" data-live-search="true" name="fees_amount[]"><option value="">wdwff</option></select><a href="#" class="remove_field">Remove</a></div>'); //add input box
                
            }
        });

        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').remove(); x--;
        })
    });
</script>