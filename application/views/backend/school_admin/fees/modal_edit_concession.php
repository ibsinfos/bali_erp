<?php if($record) {?>
<div class="row m-0">
    <div class="col-md-12"> 
    <?php echo form_open(base_url('index.php?fees/main/concession_edit/'.$record->id), array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data','target' => '_top')); ?>
    <div class="form-horizontal form-material">
        <div class="row">
            <div class="col-xs-12">
                <label for="running_session"><?php echo get_phrase('current_session'); ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                    <input type="text" class="form-control" name="running_year" value="<?php echo $record->running_year?>" readonly/> 
                </div>
            </div>
        </div>
        <br/>

        <div class="row">          
            <div class="col-xs-12">
                <label for="field-1"><?php echo get_phrase('concession_type'); ?><span class="error mandatory">*</span></label>
                <select name="type" class="selectpicker1" data-style="form-control" data-live-search="true">
                    <option value=""><?php echo get_phrase('select_concession_type');?></option>
                    <option value="1" <?php echo set_value('type',$record->type)==1?'selected':'';?>><?php echo get_phrase('fee_groups');?></option>
                    <option value="2" <?php echo set_value('type',$record->type)==2?'selected':'';?>><?php echo get_phrase('classes');?></option>
                    <option value="3" <?php echo set_value('type',$record->type)==3?'selected':'';?>><?php echo get_phrase('students');?></option>
                </select>
            </div> 
        </div>
        <br/>

        <div class="row">          
            <div class="col-xs-12">
                <label for="field-1"><?php echo get_phrase('concession_name'); ?><span class="error mandatory">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-road"></i></div>
                    <input type="text" class="form-control" name="name" value="<?php echo $record->name?>" required="required"/> 
                </div>
            </div> 
        </div>
        <br/>

        <!-- <div class="row">          
            <div class="col-xs-12">
                <label for="field-1"><?php echo get_phrase('concession_description'); ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-book"></i></div>
                    <input type="text" class="form-control" name="description" value="<?php echo $record->description?>"/>
                </div> 
            </div>
        </div>
        <br>-->
        
        <div class="row">          
            <div class="col-xs-12">
                <label for="field-1"><?php echo get_phrase('amount_type'); ?><span class="error mandatory">*</span></label>
                <div>
                    <label class="radio-inline">
                        <input type="radio" name="amt_type" value="1" <?php echo $record->amt_type==1?'checked':''?>><?php echo get_phrase('fix');?>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="amt_type" value="2" <?php echo $record->amt_type==2?'checked':''?>><?php echo get_phrase('percentage');?>
                    </label>
                </div>
            </div> 
        </div>
        <br/>

        <div class="row">          
            <div class="col-xs-12">
                <label for="field-1"><?php echo get_phrase('amount'); ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-book"></i></div>
                    <input type="text" class="form-control" name="amount" value="<?php echo $record->amount?>"/>
                </div> 
            </div>
        </div>
        <br>

        <div class="row">          
            <div class="col-xs-12">
                <label for="field-1"><?php echo get_phrase('discount_on')?><span class="error mandatory">*</span></label>
                <select name="discount_on" class="selectpicker" data-style="form-control">
                    <option value=""><?php echo get_phrase('select_discount_on');?></option>
                    <option value="1" <?php echo $record->discount_on==1?'selected':'';?>><?php echo get_phrase('school_fee');?></option>
                    <option value="2" <?php echo $record->discount_on==2?'selected':'';?>><?php echo get_phrase('hostel');?></option>
                    <option value="3" <?php echo $record->discount_on==3?'selected':'';?>><?php echo get_phrase('transport');?></option>
                </select>
            </div> 
        </div>
        <br/>

        <div class="row fee-heads" style="display:<?php echo $record->discount_on==1?'':'none'?>">          
            <div class="col-xs-12">
                <label for="field-1"><?php echo get_phrase('on_fee_head')?><span class="error mandatory">*</span></label>
                <select name="fee_head_id" class="selectpicker" data-style="form-control">
                    <option value=""><?php echo get_phrase('select_fee_head');?></option>
                    <?php foreach($fee_heads as $fhead){?>
                        <option value="1" <?php echo $record->fee_head_id==$fhead->id?'selected':'';?>><?php echo $fhead->name;?></option>
                    <?php }?>
                </select>
            </div> 
        </div>
        <br/>

        <div class="form-group">
            <div class="text-right">
                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('update'); ?></button>
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
</script>




