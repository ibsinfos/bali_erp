<?php if($record) {?>
    <div class="row m-0">
        <div class="col-md-12"> 
        <?php echo form_open(base_url('index.php?fees/fees/particular_edit/'.$record->id), array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data','target' => '_top')); ?>
        <div class="form-horizontal form-material">
            <div class="row">
                <div class="col-xs-12">
                    <label for="running_session"><?php echo get_phrase("running_session"); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                        <select name="running_year" class="selectpicker" data-style="form-control" data-live-search="true">
                            <option value=""><?php echo get_phrase('select_running_session');?></option>
                            <?php $last_year = date('Y',strtotime('-1 year'));
                                for($i = 0; $i < 10; $i++){
                                    $grp_year = ($last_year+$i).'-'.($last_year+($i+1));?>
                                    <option value="<?php echo $grp_year?>" 
                                            <?php echo $grp_year==set_value('running_year',$record->running_year)?'selected':'';?>>
                                        <?php echo $grp_year?>
                                    </option>
                            <?php }?>
                        </select>
                    </div>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-xs-12">
                    <label for="running_session"><?php echo get_phrase('fee_category'); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                        <select name="fee_category_id" class="selectpicker" data-style="form-control" data-live-search="true">
                                <option value=""><?php echo get_phrase('select_fee_category');?></option>
                                <?php foreach($fee_categories as $fee_cat){?>
                                    <option value="<?php echo $fee_cat->cat_id?>" <?php echo $fee_cat->cat_id==$record->fee_category_id?'selected':'';?>>
                                        <?php echo $fee_cat->cat_name?>
                                    </option>
                                <?php }?>
                        </select>
                    </div>
                </div>
            </div>
            <br/>

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
                    <label for="field-1"><?php echo get_phrase('description'); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-book"></i></div>
                        <input type="text" class="form-control" name="description" value="<?php echo $record->description?>" />
                    </div> 
                </div>
            </div>
            <br>

            <!-- <div class="row">          
                <div class="col-xs-12">
                    <label for="field-1"><?php echo get_phrase('amount'); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-book"></i></div>
                        <input type="text" class="form-control" name="amount" value="<?php echo $record->amount?>"/>
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
</script>




