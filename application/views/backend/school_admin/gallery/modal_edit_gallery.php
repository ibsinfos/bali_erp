<?php if($record) {?>
    <div class="row m-0">
        <div class="col-md-12"> 
        <?php echo form_open(base_url('index.php?school_admin/photo_gallery_edit/'.$record->id), 
                    array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data','target' => '_top')); ?>
        <div class="form-horizontal form-material">
            <div class="row">
                <div class="col-xs-12">
                    <label for="running_session"><?php echo get_phrase("running_session"); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                        <input type="text" class="form-control" name="name" value="<?php echo $record->running_year?>" disabled/> 
                    </div>
                </div>
            </div>
            <br/>

            <div class="row">          
                <div class="col-xs-12">
                    <label for="field-1"><?php echo get_phrase('class'); ?><span class="error mandatory">*</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-road"></i></div>
                        <select class="selectpicker" data-style="form-control" data-live-search="true" name="class_id">
                            <option value="0"><?php echo get_phrase('common')?></option>
                            <?php foreach($classes as $cls){?>
                                <option value="<?php echo $cls->class_id?>"><?php echo $cls->name?></option>
                            <?php }?>
                        </select>
                    </div>
                </div> 
            </div>
            <br/>

            <div class="row">          
                <div class="col-xs-12">
                    <label for="field-1"><?php echo get_phrase('gallery_title'); ?><span class="error mandatory">*</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-road"></i></div>
                        <input type="text" class="form-control" name="title" value="<?php echo $record->title?>" data-validate="required"  required="required"
                        data-message-required="<?php echo get_phrase('title'); ?>"/> 
                    </div>
                </div> 
            </div>
            <br/>
            
            <div class="row">          
                <div class="col-xs-12">
                    <label for="field-1"><?php echo get_phrase('gallery_description');?></label>
                    <textarea class="form-control" name="description"><?php echo set_value('description',$record->description)?></textarea>
                </div>
            </div>
            <br>
                    
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




