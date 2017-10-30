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
        <div class="sttabs tabs-style-flip">
            <div class="content-wrap">     	
                <!--CREATION FORM STARTS-->
                <?php echo form_open(base_url('index.php?fees/refund/refund_rule_edit/'.$rule_id), array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                <div class="row">
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <label for="running_session"><?php echo get_phrase("current_session"); ?></label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                            <input name="running_year" class="form-control" value="<?php echo set_value('running_year',$refund_rule_data['running_year'])?>" 
                            readonly>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">          
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <label for="field-1"><?php echo get_phrase('fee_group'); ?><span class="error mandatory">*</span></label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                            <select name="fee_group_id" class="selectpicker" data-style="form-control" data-live-search="true" required="required"
                                data-title="Select Fee Group">
                                <?php foreach($fee_groups as $grp){?>
                                    <option value="<?php echo $grp->id?>" <?php echo($grp->id==$refund_rule_data['fee_group_id'])?'selected':''?>>
                                        <?php echo $grp->name?>
                                    </option>
                                <?php }?>                
                            </select>
                        </div>
                    </div> 
                </div>
                <br/>
            
                <div class="row">          
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <label for="field-1"><?php echo get_phrase('term_type'); ?><span class="error" style="color: red;">*</span></label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                            <select name="term_type_id" class="selectpicker" data-style="form-control" data-live-search="true" required="required" 
                                data-title="Select Term Type">
                                <?php foreach($term_types as $trm){?>
                                    <option value="<?php echo $trm->id?>"  <?php echo($trm->id==$refund_rule_data['term_type_id'])?'selected':''?>>
                                        <?php echo $trm->name?>
                                    </option>
                                <?php }?>                
                            </select>
                        </div>
                    </div> 
                </div>
                <br/>

                <div class="row">          
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <label for="field-1"><?php echo get_phrase('fee_term'); ?><span class="error" style="color: red;">*</span></label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                            <select name="setup_term_id" class="selectpicker" data-style="form-control" data-live-search="true" required="required">
                                <?php foreach($setup_terms as $sterm){?>
                                    <option value="<?php echo $sterm->id?>" <?php echo($sterm->id==$refund_rule_data['setup_term_id'])?'selected':''?>>
                                        <?php echo $sterm->name.' - '.$sterm->amount.' - '.date('d/m/Y',strtotime($sterm->start_date))?>
                                    </option>
                                <?php }?>         
                            </select>
                        </div>
                    </div> 
                </div>
                <br/>

                <div class="row">          
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <label for="field-1"><?php echo get_phrase('rule_name'); ?><span class="error" style="color: red;">*</span></label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-road"></i></div>
                            <input type="text" class="form-control" name="name" value="<?php echo $refund_rule_data['name']; ?>" required="required" /> 
                        </div>
                    </div> 
                </div>
                <br/>
                <div class="row">          
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <label for="field-1"><?php echo get_phrase("valid_from"); ?><span class="mandatory"> *</span></label>
                        <div class="input-group">
                            <div class="input-group-addon input-sm"><i class="fa fa-sort-numeric-desc"></i></div>    
                            <input type="text" class="form-control" id="valid_from" name="valid_from" placeholder="Valid From" value="<?php echo date('m/d/Y',strtotime($refund_rule_data['valid_from'])); ?>" required="required" />
                            <span class="mandantory"> <?php echo form_error('valid_from'); ?></span>
                        </div> 
                    </div>
                </div>
                <br/>
                <div class="row">          
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <label for="field-1"><?php echo get_phrase("valid_to"); ?><span class="mandatory"> *</span></label>
                        <div class="input-group">
                            <div class="input-group-addon input-sm"><i class="fa fa-sort-numeric-desc"></i></div>    
                            <input type="text" class="form-control" id="valid_to" name="valid_to" placeholder="Valid To" value="<?php echo date('m/d/Y',strtotime($refund_rule_data['valid_to'])); ?>" required="required">
                            <span class="mandantory"> <?php echo form_error('valid_to'); ?></span>
                        </div> 
                    </div>
                </div>
                <br/>
                <div class="row">          
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <div class="input-group">
                            <label for="field-1"><?php echo get_phrase("amount_type"); ?><span class="mandatory"> *</span></label><br/>
                            <input type="radio" name="amount_type" value="1" <?php echo 1==$refund_rule_data['amount_type']?'checked':'';?> /> Percentage
                            <input type="radio" name="amount_type" value="2" <?php echo 2==$refund_rule_data['amount_type']?'checked':'';?> /> Fixed
                            <label class="mandatory"> <?php echo form_error('amount_type'); ?></label>            
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">          
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <label for="field-1"><?php echo get_phrase("amount"); ?><span class="mandatory"> *</span></label>
                        <div class="input-group">
                            <div class="input-group-addon input-sm"><i class="fa fa-sort-numeric-desc"></i></div>    
                            <input type="text" class="form-control" id="amount" name="amount" placeholder="amount" value="<?php echo $refund_rule_data['amount']; ?>" required="required" />
                            <span class="mandantory"> <?php echo form_error('amount'); ?></span>
                        </div> 
                    </div>
                </div>
			
                <div class="row">   
					<div class="col-md-12">&nbsp;</div>
                    <div class="col-xs-12 col-md-12 text-center">
                        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('update'); ?></button>
                    </div>         
                                        <div class="col-md-12">&nbsp;</div>
                </div>     
                                    
                <?php echo form_close()?>            
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
    jQuery('#valid_from,#valid_to').datepicker({
       startDate: new Date(),
       autoclose: true
     });  
</script>