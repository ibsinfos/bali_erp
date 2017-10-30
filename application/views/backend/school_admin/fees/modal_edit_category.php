<?php if($cat_record) {?>
    <div class="row m-0">
        <div class="col-md-12"> 
        <?php echo form_open(base_url('index.php?fees/fees/category_edit/'. $cat_record->cat_id), array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data','target' => '_top')); ?>
        <div class="form-horizontal form-material">
            <div class="row">
                <div class="col-xs-12">
                    <label for="running_session"><?php echo get_phrase("current_session"); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                        <select name="running_year" class="selectpicker1" data-style="form-control" data-live-search="true">
                            <option value=""><?php echo get_phrase('select_current_session');?></option>
                            <?php $last_year = date('Y',strtotime('-1 year'));
                                for($i = 0; $i < 10; $i++){
                                    $grp_year = ($last_year+$i).'-'.($last_year+($i+1));?>
                                    <option value="<?php echo $grp_year?>" 
                                            <?php echo $grp_year==set_value('running_year',$cat_record->running_year)?'selected':'';?>>
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
                    <label for="field-1"><?php echo get_phrase('category_name'); ?><span class="error" style="color: red;">*</span></label>
                    <input type="text" class="form-control" name="cat_name" value="<?php echo $cat_record->cat_name?>" data-validate="required" 
                    data-message-required="<?php echo get_phrase('value_required'); ?>" required="required"/> 
                </div> 
            </div>
            <br/>

            <div class="row">          
                <div class="col-xs-12">
                    <label for="field-1"><?php echo get_phrase('description'); ?></label>
                    <input type="text" class="form-control" name="cat_desc" value="<?php echo $cat_record->cat_desc?>"/>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-xs-12">
                    <div class="text-center">
                        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit'); ?></button>
                    </div>
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




