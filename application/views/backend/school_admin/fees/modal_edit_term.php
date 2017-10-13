<?php if($record) {?>
    <div class="row m-0">
        <div class="col-md-12"> 
        <?php echo form_open(base_url('index.php?fees/main/term_edit/'.$record->id), array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data','target' => '_top')); ?>
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

            <div class="row">          
                <div class="col-xs-12">
                    <label for="field-1"><?php echo get_phrase('name');?> <span class="error mandatory">*</span></label>
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
                    <label for="field-1"><?php echo get_phrase('number_of_terms');?> <span class="error mandatory">*</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-book"></i></div>
                        <input type="number" class="form-control" name="term_num" value="<?php echo $record->term_num?>"
                        <?php echo $record->in_fee_setup>0 || $record->in_hostel_setup>0 || $record->in_transport_setup>0?'disabled':''?>/>
                        <?php if($record->in_fee_setup>0 || $record->in_hostel_setup>0 || $record->in_transport_setup>0){?>
                            <input type="hidden" name="term_num" value="<?php echo $record->term_num?>"/>
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
</script>




