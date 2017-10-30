<div class="row m-0">
    <div class="col-md-12 white-box">
        <?php echo form_open(base_url('index.php?fees/main/fine_edit/'.$record->id), array('class'=>'form-horizontal form-groups-bordered validate', 
        'target' => '_top')); ?>
            <div class="row">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <label for="running_session"><?php echo get_phrase('current_session');?></label>
                            <input type="text" class="form-control" name="name" value="<?php echo $running_year?>" readonly/> 
                        </div>
                    </div>
                    <br/>

                    <div class="row">          
                        <div class="col-xs-12 col-md-12">
                            <label for="field-1"><?php echo get_phrase('fine_name');?><span class="error mandatory">*</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-road"></i></div>
                                <input type="text" class="form-control" name="name" required="required" value="<?php echo set_value('name',$record->name)?>"/> 
                            </div>
                        </div> 
                    </div>
                    <br/>
                    
                    <div class="row">          
                        <div class="col-xs-12 col-md-12">
                            <label for="field-1"><?php echo get_phrase('grace_period')?><span class="error mandatory">*</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-road"></i></div>
                                <input type="text" class="form-control" name="grace_period" required="required" 
                                value="<?php echo set_value('grace_period',$record->grace_period)?>"/> 
                            </div>
                        </div> 
                    </div>
                    <br/>

                    <div class="row">          
                        <div class="col-xs-12 col-md-12">
                            <label for="field-1"><?php echo get_phrase('value_type')?><span class="error mandatory">*</span></label>
                            <div>
                                <label class="radio-inline">
                                    <input type="radio" name="value_type" value="1" <?php echo $record->value_type==1?'checked':''?>><?php echo get_phrase('fix');?>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="value_type" value="2" <?php echo $record->value_type==2?'checked':''?>><?php echo get_phrase('percentage');?>
                                </label>
                            </div>
                        </div> 
                    </div>
                    <br/>

                    <div class="row">          
                        <div class="col-xs-12 col-md-12">
                            <label for="field-1"><?php echo get_phrase('fine_value');?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-book"></i></div>
                                <input type="number" class="form-control" name="value" value="<?php echo set_value('value',$record->value)?>"/>
                            </div> 
                        </div>
                    </div>
                    <br>

                    <div class="row">          
                        <div class="col-xs-12 col-md-12">
                            <label for="field-1"><?php echo get_phrase('fine_description');?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-book"></i></div>
                                <input type="text" class="form-control" name="description" 
                                value="<?php echo set_value('description',$record->description)?>"/>
                            </div> 
                        </div>
                    </div>
                    <br/>
                </div>
            </div>

            <div class="form-group">
                <div class="text-right">
                    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('update'); ?></button>
                </div>
            </div> 
        <?php echo form_close()?>   
    </div>
</script>