<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><?php echo get_phrase('fee_setup'); ?>
                <ul>                    
                    <li><a href="<?php echo base_url(); ?>index.php?fees/main/heads"><?php echo get_phrase('fee_heads'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?fees/main/groups"><?php echo get_phrase('fee_groups'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?fees/main/terms"><?php echo get_phrase('fee_terms'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?fees/main/term_setting"><?php echo get_phrase('fee_term_setting'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?fees/main/charge_setup"><?php echo get_phrase('fee_charge_setup'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?fees/main/transport_fee_setup"><?php echo get_phrase('transport_fee_setup'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?fees/main/hostel_fee_setup"><?php echo get_phrase('hostel_fee_setup'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?fees/main/concessions"><?php echo get_phrase('fee_concessions'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?fees/main/fines"><?php echo get_phrase('fee_fines'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?fees/main/fee_scholarships"><?php echo get_phrase('fee_scholarships'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?fees/refund/refund_rules"><?php echo get_phrase('refund_rules'); ?></a></li>                                       
                </ul>
            </li>
            <li class="active">
                <?php echo $page_title; ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<div class="row m-0">
    <div class="col-md-12 white-box">
        <?php echo form_open(base_url('index.php?fees/main/group_edit/'.$record->id), array('class' => 'form-horizontal form-groups-bordered validate', 
        'target' => '_top','id'=>'add-form')); ?>
        <div class="row">
            <div class="col-xs-12 col-md-offset-3 col-md-6">
                <label for="running_session"><?php echo get_phrase("current_session"); ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                    <input type="text" class="form-control" name="name" value="<?php echo $running_year?>" readonly/> 
                </div>
            </div>
        </div>
        <br/>

        <div class="row">          
            <div class="col-xs-12 col-md-offset-3 col-md-6">
                <label for="field-1"><?php echo get_phrase('group_name'); ?><span class="error mandatory">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-road"></i></div>
                    <input type="text" class="form-control" name="name" value="<?php echo set_value('name',$record->name)?>" data-validate="required" 
                    data-message-required="<?php echo get_phrase('value_required');?>" required="required"/> 
                </div>
            </div> 
        </div>
        <br/>

        <div class="row">          
            <div class="col-xs-12 col-md-offset-3 col-md-6">
                <label for="field-1"><strong><?php echo get_phrase('select_heads');?></strong> <span class="error mandatory">*</span></label><br/>
                
                <div class="row">
                    <div class="col-md-4"><strong><?php echo get_phrase('heads');?></strong></div>
                    <div class="col-md-4"><strong><?php echo get_phrase('head_amount');?></strong></div>
                    <div class="col-md-4 dis-none"><strong><?php echo get_phrase('head_tax');?></strong></div>
                </div>
                <?php foreach($heads as $head){
                        $sel_head = false;
                        foreach($rel_heads as $rel_hd){
                            if($head->id==$rel_hd->id){
                                $sel_head = $rel_hd;
                            }
                        }
                    ?>
                    <div class="row">  
                        <?php if(in_array($head->id,$rel_hs) && $record->in_setups){?>
                            <input type="hidden" name="heads[]" value="<?php echo $head->id?>"/>
                            <input type="hidden" name="head_amount[<?php echo $head->id?>]" value="<?php echo $sel_head?$sel_head->head_amount:''?>"/>
                        <?php }?>
                        <div class="col-xs-12 col-md-4">
                            <label>
                                <input type="checkbox" name="heads[]" class="chkbox" value="<?php echo $head->id?>"
                                    <?php echo in_array($head->id,$rel_hs)?'checked':''?> <?php echo $record->in_setups?'disabled':''?>/>
                                <span><?php echo $head->name?></span>
                            </label>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <label>
                                <input type="text" class="form-control input-sm head-amt" name="head_amount[<?php echo $head->id?>]" 
                                placeholder="Head Amount" value="<?php echo $sel_head?$sel_head->head_amount:''?>"
                                <?php echo in_array($head->id,$rel_hs)?'':'disabled'?> <?php echo $record->in_setups?'disabled':''?>/> 
                            </label>
                        </div>
                        <div class="col-xs-12 col-md-4 dis-none">
                            <label>
                                <input type="text" class="form-control input-sm head-tax" name="head_tax[<?php echo $head->id?>]" 
                                placeholder="Tax Percentage" value="<?php echo $sel_head?$sel_head->head_tax:''?>"
                                <?php echo in_array($head->id,$rel_hs)?'':'disabled'?> <?php echo $record->in_setups?'disabled':''?>/> 
                            </label>
                        </div>
                    </div>    
                <?php }?>
            </div> 
        </div>
        <br/>

        <div class="row">          
            <div class="col-xs-12 col-md-offset-3 col-md-6">
                <label for="field-1"><strong><?php echo get_phrase('select_classes');?></strong> <span class="error mandatory">*</span></label><br/>
                <div class="row">  
                    <?php foreach($classes as $cls){?>
                        <?php if(in_array($cls->class_id,$rel_cls) && $record->in_setups){?>
                            <input type="hidden" name="classes[]" value="<?php echo $cls->class_id?>"/>
                        <?php }?>
                        <div class="col-xs-12 col-md-4">
                            <label>
                                <input type="checkbox" name="classes[]" value="<?php echo $cls->class_id?>" 
                                    <?php echo in_array($cls->class_id,$rel_cls)?'checked':''?> <?php echo $record->in_setups?'disabled':''?>/>
                                <span><?php echo $cls->name?></span>
                            </label><br/>
                        </div>
                    <?php }?>
                </div>
            </div> 
        </div>
        <br/>

        <div class="row">          
            <div class="col-xs-12 col-md-offset-3 col-md-6">
                <label for="field-1"><?php echo get_phrase('description'); ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-book"></i></div>
                    <input type="text" class="form-control" name="description" value="<?php echo set_value('description',$record->description)?>"/>
                </div> 
            </div>
        </div>
        <br>

        <div class="form-group">
            <div class="text-center">
                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('update'); ?></button>
            </div>
        </div>
        <?php echo form_close()?>   
    </div>
</div>

<script>
    
$('#add-form').submit(function(event){
    $.each($('.fee-heads'),function(){
        chkbox = $(this).find('.chkbox');
        headAmtField = $(this).find('.head-amt');
        if(chkbox.prop('checked') && parseFloat(headAmtField.val())<=0){
            headAmtField.focus();
            headName = chkbox.closest('label').find('span').text();
            swal('Error','Fill amount for '+headName,'error');
            event.preventDefault();
        }
    });
});
$('.chkbox').on('change',function(){
    row = $(this).closest('.row');
    if(this.checked){
        row.find('.head-amt').val('');
        row.find('.head-amt').removeAttr('disabled');
        row.find('.head-amt').attr('required','required');
    }else{
        row.find('.head-amt').val('');
        row.find('.head-amt').attr('disabled','disabled');
        row.find('.head-amt').removeAttr('required');
    }
});
</script>