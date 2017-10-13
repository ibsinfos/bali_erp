<?php if($record) {?>
    <div class="row m-0">
        <div class="col-md-12"> 
        <?php echo form_open(base_url('index.php?fees/main/head_edit/'.$record->id), array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data','target' => '_top')); ?>
        <div class="form-horizontal form-material">
            <div class="row">
                <div class="col-xs-12">
                    <label for="running_session"><?php echo get_phrase("running_session"); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                        <input type="text" class="form-control" name="name" value="<?php echo $record->running_year?>" readonly/> 
                    </div>
                </div>
            </div>
            <br/>

            <!-- <div class="row">
                <div class="col-xs-12">
                    <label for="running_session"><?php //echo get_phrase('fee_category'); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                        <select name="fee_category_id" class="form-control">
                                <option value=""><?php //echo get_phrase('select_fee_category');?></option>
                                <?php /* foreach($fee_categories as $fee_cat){?>
                                    <option value="<?php echo $fee_cat->cat_id?>" <?php echo $fee_cat->cat_id==$record->fee_category_id?'selected':'';?>>
                                        <?php echo $fee_cat->cat_name?>
                                    </option>
                                <?php } */?>
                        </select>
                    </div>
                </div>
            </div>
            <br/> -->

            <div class="row">          
                <div class="col-xs-12">
                    <label for="field-1"><?php echo get_phrase('name'); ?><span class="error mandatory">*</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-road"></i></div>
                        <input type="text" class="form-control" name="name" value="<?php echo $record->name?>" data-validate="required"  required="required"
                        data-message-required="<?php echo get_phrase('value_required'); ?>"/> 
                    </div>
                </div> 
            </div>
            <br/>
           
            <div class="row">          
                <div class="col-xs-12">
                    <label for="field-1"><?php echo get_phrase('for_non_enroll'); ?></label><br/>
                    <label>
                        <input type="checkbox" name="non_enroll" value="1" class="js-switch" <?php echo $record->non_enroll?'checked':''?>
                        <?php echo $record->in_grps||$record->in_paytrans||$record->in_invitem?'disabled':''?>/>
                        
                        <?php if($record->in_grps||$record->in_paytrans||$record->in_invitem){?>
                            <input type="hidden" name="non_enroll" value="<?php echo $record->non_enroll?>"/>
                        <?php }?>
                    </label>
                </div> 
            </div>
            <br/>

            <div class="row <?php echo(!$record->non_enroll)?'dis-none':''?> amt-box">          
                <div class="col-xs-12">
                    <label for="field-1"><?php echo get_phrase('amount');?> <span class="error mandatory">*</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-book"></i></div>
                        <input type="number" class="form-control" name="amount" value="<?php echo set_value('amount',$record->amount)?>"
                        <?php echo $record->in_grps||$record->in_paytrans||$record->in_invitem?'disabled':''?>/>
                        <?php if($record->in_grps||$record->in_paytrans||$record->in_invitem){?>
                            <input type="hidden" name="amount" value="<?php echo $record->amount?>"/>
                        <?php }?>
                    </div> 
                </div>
            </div>
            <br>

            <!-- <div class="row">          
                <div class="col-xs-12">
                    <label for="field-1"><?php //echo get_phrase('description'); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-book"></i></div>
                        <input type="text" class="form-control" name="description" value="<?php //echo $record->description?>" />
                    </div> 
                </div>
            </div>
            <br> -->
                    
            <div class="form-group">
                <div class="text-right">
                    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit'); ?></button>
                </div>
            </div>
        </div>            
        <?php echo form_close(); ?>	   
        </div>    
    </div> 
<?php } ?>             
<script type="text/javascript">
jQuery(document).ready(function () {
    $(".numeric").numeric();
});
$('input[name=non_enroll]').change(function(){
    if(this.checked){
        $('input[name=amount]').find('input').val('');
        $('.amt-box').show();            
    }else{
        $('input[name=amount]').find('input').val('');          
        $('.amt-box').hide();
    }
});
</script>




