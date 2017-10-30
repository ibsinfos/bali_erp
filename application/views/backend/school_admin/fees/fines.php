<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('fee_fines');?></h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>

        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?<?php echo $this->session->userdata('login_type');?>/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>

            <?php $BRC = get_bread_crumb(); if (strpos($BRC, '^') !== false) { $ExpBrd = explode('^', $BRC);?>
            <li>
                <?php echo get_phrase(@$ExpBrd[0]); ?>
                <?php echo @$ExpBrd[1]; ?>
            </li> <?php }else{ $ExpBrd[2] = $BRC;}?>
            <li class="active">
                <?php echo get_phrase(@$ExpBrd[2]); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<div class="row m-0">
    <div class="col-md-12 white-box">
        <div class="sttabs tabs-style-flip">
            <nav>
                <ul>
                    <li class="active" data-step="5" data-intro="<?php echo get_phrase('from here You can see the lists of fine');?>" data-position='right'>
                        <a href="#list" class="sticon fa fa-list"><span class="hidden-xs"><?php echo get_phrase('fines_list'); ?></span></a>
                    </li>
                    <li data-step="6" data-intro="<?php echo get_phrase('from here You can add new fine');?>" data-position='left'>
                        <a href="#add" class="sticon fa fa-plus-circle">
                            <span class="hidden-xs"><?php echo get_phrase('add_fines'); ?></span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="content-wrap">     	
                <section id="list">  
                    <!--TABLE LISTING STARTS-->           
                    <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
                        <thead>
                            <tr>
                                <th><div><?php echo get_phrase('no'); ?></div></th>
                                <th><div><?php echo get_phrase('fine_name'); ?></div></th>
                                <th><div><?php echo get_phrase('grace_period'); ?></div></th>
                                <th><div><?php echo get_phrase('amount'); ?></div></th>
                                <th><div><?php echo get_phrase('action'); ?></div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1;
                            foreach ($records as $rec): ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo $rec->name; ?></td>
                                    <td><?php echo $rec->grace_period.' days';?></td>
                                    <td><?php echo $rec->value.($rec->value_type==2?'%':''); ?></td>
                                    <td>
                                        <a href="javascript: void(0);" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                                            onclick="showAjaxModal('<?php echo base_url('index.php?fees/main/fine_edit/'.$rec->id)?>')"
                                            data-placement="top" data-original-title="Edit">
                                            <i class="fa fa-pencil-square-o"></i>
                                         </a>
                                         <a href="javascript:void(0)" onclick="confirm_act('<?php echo base_url('index.php?fees/main/fine_delete/'.$rec->id);?>')">
                                             <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
                                         </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </section>
                <!--TABLE LISTING ENDS-->

                <!--CREATION FORM STARTS-->
                <section id="add">  
                    <?php echo form_open(base_url('index.php?fees/main/fines'), array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="running_session"><strong><?php echo get_phrase('current_session');?></strong></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                                <input type="text" class="form-control" name="name" value="<?php echo $running_year?>" readonly/> 
                            </div>
                        </div>
                    </div>
                    <br/>

                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><strong><?php echo get_phrase('fine_name');?></strong><span class="error mandatory">*</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-road"></i></div>
                                <input type="text" class="form-control" name="name" required="required" data-validate="required" 
                                data-message-required="<?php echo get_phrase('value_required'); ?>" value="<?php echo set_value('name')?>"/> 
                            </div>
                        </div> 
                    </div>
                    <br/>
                    
                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><strong><?php echo get_phrase('grace_period');?></strong><span class="error mandatory">*</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-road"></i></div>
                                <input type="text" class="form-control" name="grace_period" required="required" data-validate="required" 
                                data-message-required="<?php echo get_phrase('value_required'); ?>" value="<?php echo set_value('grace_period')?>"/> 
                            </div>
                        </div> 
                    </div>
                    <br/>

                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><strong><?php echo get_phrase('value_type'); ?></strong><span class="error mandatory">*</span></label>
                            <div>
                                <label class="radio-inline">
                                    <input type="radio" name="value_type" value="1" 
                                    <?php echo set_value('value_type')==1 && !set_value('value_type')?'checked':''?>><?php echo get_phrase('fix');?>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="value_type" value="2" <?php echo set_value('value_type')==2?'checked':''?>><?php echo get_phrase('percentage');?>
                                </label>
                            </div>
                        </div> 
                    </div>
                    <br/>

                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><strong><?php echo get_phrase('fine_value'); ?></strong></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-book"></i></div>
                                <input type="number" class="form-control" name="value" value="<?php echo set_value('value')?>"/>
                            </div> 
                        </div>
                    </div>
                    <br>

                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><strong><?php echo get_phrase('fine_description'); ?></strong></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-book"></i></div>
                                <input type="text" class="form-control" name="description" value="<?php echo set_value('description')?>"/>
                            </div> 
                        </div>
                    </div>
                    <br/>

                    <div class="form-group">
                        <div class="text-right">
                            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('add'); ?></button>
                        </div>
                    </div>
                   <?php echo form_close()?>   
                </section>                
            </div>
        </div>
    </div>
</div>
<script>
</script>