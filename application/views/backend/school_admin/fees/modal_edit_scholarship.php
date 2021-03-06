<?php if($record) {?>
    <div class="row m-0">
        <div class="col-md-12"> 
        <?php echo form_open(base_url('index.php?fees/main/scholarship_edit/'.$record->id), array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data','target' => '_top')); ?>
        <div class="form-horizontal form-material">
            <div class="row">
                <div class="col-xs-12">
                    <label for="running_session"><?php echo get_phrase('current_session'); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                        <select name="running_year" class="selectpicker1" data-style="form-control" data-live-search="true">
                                <option value=""><?php echo get_phrase('select_current_session');?></option>
                                <?php $last_year = date('Y',strtotime('-1 year'));
                                    for($i = 0; $i < 10; $i++){
                                        $grp_year = ($last_year+$i).'-'.($last_year+($i+1));?>
                                    <option value="<?php echo $grp_year?>" <?php echo $grp_year==$record->running_year?'selected':'';?>>
                                        <?php echo $grp_year?>
                                    </option>
                                <?php }?>
                        </select>
                    </div>
                </div>
            </div>
            <br/>
			
            <!-- <div class="row">          
                <div class="col-xs-12">
                    <label for="field-1"><?php echo get_phrase('concession_type'); ?><span class="error mandatory">*</span></label>
                    <div>
                        <label class="radio-inline">
                            <input type="radio" name="type" value="1" <?php echo $record->type==1?'checked':''?>><?php echo get_phrase('class');?>
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="type" value="2" <?php echo $record->type==2?'checked':''?>><?php echo get_phrase('student');?>
                        </label>
                    </div>
                </div> 
            </div>
            <br/> -->

            <div class="row">          
                <div class="col-xs-12">
                    <label for="field-1"><?php echo get_phrase('scholarshp_name'); ?><span class="error mandatory">*</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-road"></i></div>
                        <input type="text" class="form-control" name="name" value="<?php echo $record->name?>" required="required" 
                        data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"/> 
                    </div>
                </div> 
            </div>
            <br/>

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




