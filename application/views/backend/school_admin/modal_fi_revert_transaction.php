<div class="tab-pane box" id="add" style="padding: 5px">
    <div class="box-content">
    <?php echo form_open(base_url() . 'index.php?fees/transaction/delete/'.$TransactionType.'/'.$id , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
    <div class="form-group">
        <label class="col-sm-3 control-label"><?php echo get_phrase('comment');?><span class="error" style="color: red;"> *</span></label>
        <div class="col-sm-8">
            <div class="box closable-chat-box">
                <div class="box-content padded">
                    <div class="chat-message-box">
                        <textarea name="delete_reason" id="delete_reason" rows="7" placeholder="<?php echo get_phrase('Type delete reason here');?>" class="form-control" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"></textarea>
                        <label style="color:red;"> <?php echo form_error('delete_reason'); ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-5">
            <button type="submit" class="btn btn-info"><?php echo get_phrase('save');?></button>
        </div>
    </div>
        <?php echo form_open();?>             
    </div>                
</div>
             