<div class="tab-pane box" id="add" style="padding: 5px">
    <div class="box-content">
    <?php echo form_open(base_url() . 'index.php?school_admin/event_management/create' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
    <div class="form-group">
        <label class="col-sm-3 control-label"><?php echo get_phrase('title');?><span class="error" style="color: red;"> *</span></label>
        <div class="col-sm-5">
            <input type="text" class="form-control" name="notice_title" maxlength="20" required data-message-required="<?php echo get_phrase('value_required');?>"/>
            <label style="color:red;"> <?php echo form_error('notice_title'); ?></label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label"><?php echo get_phrase('notice');?><span class="error" style="color: red;"> *</span></label>
        <div class="col-sm-5">
            <div class="box closable-chat-box">
                <div class="box-content padded">
                        <div class="chat-message-box">
                        <textarea name="notice" id="ttt" rows="3" placeholder="<?php echo get_phrase('add_event');?>" class="form-control" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"></textarea>
                        <label style="color:red;"> <?php echo form_error('notice'); ?></label>
                        </div>
                </div>
            </div>
        </div>
    </div>     
        
    <div class="form-group">
        <label class="col-sm-3 control-label"><?php echo get_phrase('event_date');?><span class="error" style="color: red;"> *</span></label>
        <div class="col-sm-5">
            <input type="text" class="datepicker form-control" name="create_timestamp" value="" required/>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-5">
            <button type="submit" class="btn btn-info"><?php echo get_phrase('add_notice');?></button>
        </div>
    </div>
        <?php echo form_open();?>             
    </div>                
</div>
             