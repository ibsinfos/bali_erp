<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('edit_fee_group'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <?php /* <?php $BRC = get_bread_crumb(); $ExpBrd = explode('^', $BRC);?>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li>
                <?php echo @get_phrase($ExpBrd[0]); ?>
                <?php echo @$ExpBrd[1]; ?>
            </li>
            <li class="active">
                <?php echo @get_phrase($ExpBrd[2]); ?>
            </li>
        </ol> */ ?>
    </div>
    <!-- /.breadcrumb -->
</div>
<div class="row m-0">
    <div class="col-md-12 white-box">
        <?php echo form_open(base_url('index.php?fees/fees/group_edit/'.$record->id), array('class' => 'form-horizontal form-groups-bordered validate', 
        'target' => '_top')); ?>
        <div class="row">
            <div class="col-xs-12 col-md-offset-3 col-md-12">
                <label for="running_session"><?php echo get_phrase("current_session"); ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                    <select name="running_year" class="selectpicker" data-style="form-control" data-live-search="true">
                            <option value=""><?php echo get_phrase('select_current_session');?></option>
                            <?php $last_year = date('Y',strtotime('-1 year'));
                                for($i = 0; $i < 10; $i++){
                                    $grp_year = ($last_year+$i).'-'.($last_year+($i+1));?>
                                <option value="<?php echo $grp_year?>" <?php echo $grp_year==set_value('running_year',$record->running_year)?'selected':'';?>>
                                    <?php echo $grp_year?>
                                </option>
                            <?php }?>
                    </select>
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
                <label for="field-1"><strong><?php echo get_phrase('select_articulars');?></strong></label><br/>
                <div class="row">  
                    <?php foreach($particulars as $parti){?>
                        <div class="col-xs-12 col-md-4">
                            <label>
                                <input type="checkbox" name="particulars[]" value="<?php echo $parti->id?>"
                                    <?php echo in_array($parti->id,$rel_pars)?'checked':''?>/>
                                <span><?php echo $parti->name?></span>
                            </label><br/>
                        </div>
                    <?php }?>
                </div>
            </div> 
        </div>
        <br/>

        <div class="row">          
            <div class="col-xs-12 col-md-offset-3 col-md-6">
                <label for="field-1"><strong><?php echo get_phrase('select_classes');?></strong></label><br/>
                <div class="row">  
                    <?php foreach($classes as $cls){?>
                        <div class="col-xs-12 col-md-4">
                            <label>
                                <input type="checkbox" name="classes[]" value="<?php echo $cls->class_id?>" 
                                    <?php echo in_array($cls->class_id,$rel_cls)?'checked':''?>/>
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
            <div class="text-right">
                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit'); ?></button>
            </div>
        </div>
        <?php echo form_close()?>   
    </div>
</div>
<script>
</script>