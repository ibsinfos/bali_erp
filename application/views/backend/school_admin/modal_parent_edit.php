<?php
    if (!empty($parent_record))
    {
        foreach($parent_record as $row){
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function(){
           $(".numeric").numeric(); 
        });
    </script>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary" data-collapsed="0">
                    <div class="row">
                        <?php echo form_open(base_url() . 'index.php?school_admin/parent/edit/' . $row['parent_id'], array('class' => 'form-material form-groups-bordered validate','target'=>'_top')); ?>

                     
                            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                                <label for="field-1" class="field-size"><?php echo get_phrase("father's_name"); ?><span class="error error-color"> *</span></label>
                                <input type="text" class="form-control" name="fname" value="<?php echo $row['father_name'];?>" required="required">
                            </div>
                            
                            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                                <label for="field-1" class="field-size"><?php echo get_phrase('middle_name'); ?></label>
                                <input type="text" class="form-control" name="fmname" value="<?php echo $row['father_mname'];?>">
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                                <label for="field-1" class="field-size"><?php echo get_phrase('last_name'); ?></label>
                                <input type="text" class="form-control" name="flname" value="<?php echo $row['father_lname'];?>"  >
                            </div>
                    
                
                
                   
                            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                                <label for="field-1" class="field-size"><?php echo get_phrase("mother's_name"); ?><span class="error error-color"> *</span></label>
                                <input type="text" class="form-control" name="mname" value="<?php echo $row['mother_name'];?>" required="required">
                            </div>
                            
                            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                                <label for="field-1" class="field-size"><?php echo get_phrase('middle_name'); ?></label>
                                <input type="text" class="form-control" name="mmname"  value="<?php echo $row['mother_mname'];?>">
                            </div>
                            
                            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                                <label for="field-1" class="field-size"><?php echo get_phrase('last_name'); ?></label>
                                <input type="text" class="form-control" name="mlname" value="<?php echo $row['mother_lname'];?>" >
                            </div>
                   
                       
                            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                                <label for="field-1"><?php echo get_phrase("father's_profession"); ?></label>
                                <input type="text" class="form-control" name="fprof" value="<?php echo $row['father_profession'];?>">
                            </div>
                            
                            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                                <label for="field-1" class="field-size"><?php echo get_phrase("father's_qualification"); ?></label>
                                <input id="" type="text" class="form-control" name="fqual" value="<?php echo $row['father_qualification'];?>" >
                            </div>
                            
                            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                                <label for="field-1"><?php echo get_phrase("father's_passport#"); ?></label>
                                <input type="text" class="form-control" name="fpass_no" value="<?php echo $row['father_passport_number'];?>">
                            </div>
                      
                            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                                <label for="field-1"><?php echo get_phrase("father's_ID_card_#"); ?></label>
                                <input type="text" class="form-control" name="ficard_no" value="<?php echo $row['father_icard_no'];?>" >
                            </div>
                        
                            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                                <label for="field-1"><?php echo get_phrase('id_card_type'); ?></label>
                                <input type="text" class="form-control" name="ficard_type" value="<?php echo $row['father_icard_type'];?>"    >
                            </div>
                      
                            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                                <label for="field-1"><?php echo get_phrase("mother's_profession"); ?></label>
                                <input  type="text" class="form-control" name="mprof" value="<?php echo $row['mother_profession'];?>" >
                            </div>
                            
                            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                                <label for="field-1" class="field-size"><?php echo get_phrase("mother's_qualification"); ?></label>
                                <input type="text" class="form-control" name="mqual" value="<?php echo $row['mother_quaification'];?>" >
                            </div>
                            
                            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                                <label for="field-1"><?php echo get_phrase("mother's_passport#"); ?></label>
                                <input type="text" class="form-control" name="mpass_no" value="<?php echo $row['mother_passport_number'];?>" >
                            </div>
                        
                            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                                <label for="field-1" class="field-size"><?php echo get_phrase("mother's_ID_card_#"); ?></label>
                                <input type="text" class="form-control" name="micard_no" value="<?php echo $row['mother_icard_no'];?>">
                            </div>
                            
                            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                                <label for="field-1" class="field-size"><?php echo get_phrase('id_card_type'); ?></label>
                                <input type="text"  class="form-control" name="micard_type" value="<?php echo $row['mother_icard_type'];?>" >
                            </div>
                        
                            <div class="col-xs-12 col-sm-6 col-md-12 form-group">
                                <label for="field-1"><?php echo get_phrase('address'); ?><span class="error error-color"> *</span></label>
                                <textarea class="form-control" rows="3" cols="23" name="address" required="required"><?php echo $row['address'];?></textarea>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                                 <label for="field-1" class="field-size"><?php echo get_phrase('country'); ?><span class="error error-color"> *</span></label>
                                <select  class="selectpicker1" data-style="form-control" data-live-search="true" id="country" name= "country" required onchange="get_state()">
                                    <option value="">Select Country</option>
                <?php if(count($CountryList)){ foreach($CountryList as $country){ ?>
                                    <option value="<?php echo $country['location_id'];?>"  <?php if($row['country']==$country['location_id']){echo 'selected';}?> ><?php echo ucwords($country['name']);?></option><?php }}?>
                                </select>
                            </div>
                            
                            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                                <label for="field-1" class="field-size"><?php echo get_phrase('state'); ?><span class="error error-color"> *</span></label>
                                <select class="selectpicker1" data-style="form-control" data-live-search="true" id="state" name= "state" required>
                                    <option value="">Select State</option>
                <?php if(count($StateList)){ foreach($StateList as $state){ ?>
                                    <option value="<?php echo $state['location_id'];?>"  <?php if($row['state']==$state['location_id']){echo 'selected';}?> ><?php echo ucwords($state['name']);?></option><?php }}?>
                                </select>
                            </div>
                           
                            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                                <label for="field-1" class="field-size"><?php echo get_phrase('city'); ?><span class="error error-color"> *</span></label>
                                <input type="text" class="form-control" name="city" value="<?php echo $row['city'];?>" required="required">
                            </div>
                            
                            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                                <label for="field-1" class="field-size"><?php echo get_phrase('zip_code'); ?><span class="error error-color"> *</span></label>
                                <input type="number" class="form-control" name="zip_code" value="<?php echo $row['zip_code'];?>" required="required">
                            </div>
                        
                            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                                <label for="field-1" data-validate="required" class="field-size"><?php echo get_phrase('mobile_#'); ?><span class="error error-color"> *</span></label>
                                <input type="tel" class="form-control numeric"  placeholder="enter 10 digits only" name="phone" value="<?php echo $row['cell_phone'];?>" required maxlength="10" required="required">
                            </div>
                            
                            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                                <label for="field-1" data-validate="required" class="field-size"><?php echo get_phrase('home_#'); ?></label>
                                <input type="tel"class="form-control numeric" name="home_phone" value="<?php echo $row['home_phone'];?>">
                            </div>
                            

                            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                                <label for="field-1" class="field-size"><?php echo get_phrase('work_#'); ?></label>
                                <input type="tel"  class="form-control numeric" name="work_phone" value="<?php echo $row['work_phone'];?>"> 
                            </div>
                        
                           <div class="col-xs-12 col-sm-12 col-md-12 form-group m-t-20">
                            <div class="text-center">
                                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('Update');?></button>
                            </div>
                        </div>
                     
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
   <?php } } else { echo get_phrase('no_data_available');}?>

<script type="text/javascript">
    
$(document).ready(function(){
       $(".numeric").numeric(); 
    });

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
                $('#state').html(state);
            }
        });       
    }
}
    
</script>

<script type="text/javascript">
$('#modal_ajax').on('shown.bs.modal', function (e) {
    $('#modal_ajax #myModalLabel').html('Edit Parent Information');
})
</script>