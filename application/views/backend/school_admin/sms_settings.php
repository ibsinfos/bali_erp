<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('manage_sms_settings'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>

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
</div>

    <div class="col-md-12 white-box">
        <section class="m-t-40">
            <div class="sttabs tabs-style-flip">
                <nav>
                    <ul>
                        <li class="active"><a href="#section-flip-1" class="sticon fa fa-list-ol"><span><?php echo get_phrase('select_sms_service'); ?></span></a></li>
                        <li><a href="#section-flip-2" class="sticon fa fa-server"><span><?php echo get_phrase('clickatell_settings'); ?></span><?php if ($active_sms_service == 'clickatell'):?>  
                            <span class="badge badge-success"><?php echo get_phrase('active');?></span>
                            <?php endif;?>
                            </a>
                        </li>
                        <li><a href="#section-flip-3" class="sticon fa fa-clipboard"><span><?php echo get_phrase('twilio_settings'); ?></span><?php if ($active_sms_service == 'twilio'):?>  
                            <span class="badge badge-success"><?php echo get_phrase('active');?></span>
                            <?php endif;?>
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="content-wrap">
                    <section id="section-flip-1">
                        <div class="tab-pane box active" id="section-flip-1" data-step="5" data-intro="<?php echo get_phrase('You can select SMS service from here');?>" data-position='top'>
                            <?php echo form_open(base_url() . 'index.php?school_admin/sms_settings/active_service' ,array('class' => 'form-groups-bordered validate','target'=>'_top'));?>
                                <div class="row">
                                    <div class="col-xs-12 col-md-offset-3 col-md-6 form-group form-group">
                                        <label for="field-2" class="control-label">
                                            <?php echo get_phrase('select_a_service'); ?>
                                        </label>
                                        <select name="active_sms_service" class="selectpicker" data-style="form-control" data-live-search="true" style="width:100%;">
                                            <option value=" ">
                                                <?php echo get_phrase('select_a_service'); ?>
                                            </option>
                                            <option value="" <?php if ($active_sms_service=='' ) echo 'selected';?>>
                                                <?php echo get_phrase('not_selected');?>
                                            </option>
                                            <option value="clickatell" <?php if ($active_sms_service=='clickatell' ) echo 'selected';?>>Clickatell </option>
                                            <option value="twilio" <?php if ($active_sms_service=='twilio' ) echo 'selected';?>> Twilio </option>
                                            <option value="disabled" <?php if ($active_sms_service=='disabled' ) echo 'selected';?>>
                                                <?php echo get_phrase('disabled');?>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d">
                                        <?php echo get_phrase('save'); ?>
                                    </button>
                                </div>
                                <?php echo form_close();?>
                        </div>
                    </section>
                    <section id="section-flip-2">
                        <?php echo form_open(base_url() . 'index.php?school_admin/sms_settings/clickatell' , array('class' => 'form-groups-bordered validate','target'=>'_top'));?>
                            <div class="row">
                                <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                                    <label for="field-1">
                                        <?php echo get_phrase('username');?>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-user-circle-o"></i></div>
                                        <input type="text" class="form-control" name="clickatell_user" value="<?php echo $clickatell_user_name;?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                                    <label for="field-1">
                                        <?php echo get_phrase('password');?>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-key"></i></div>
                                        <input type="text" class="form-control" name="clickatell_password" value="<?php echo $clickatell_user_pwd;?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                                    <label for="field-1">
                                        <?php echo get_phrase('API_ID');?><span class="error" style="color: red;"> *</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-id-badge"></i></div>
                                        <input type="text" class="form-control" name="clickatell_api_id" value="<?php echo $clickatell_api_id;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d">
                                    <?php echo get_phrase('save');?>
                                </button>
                            </div>
                            <?php echo form_close();?>
                    </section>
                    <section id="section-flip-3">
                        <?php echo form_open(base_url() . 'index.php?school_admin/sms_settings/twilio' , array('class' => 'form-groups-bordered validate','target'=>'_top'));?>
                            <div class="row">
                                <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                                    <label for="field-1">
                                        <?php echo get_phrase('account_sid');?>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-user-circle-o"></i></div>
                                        <input type="text" class="form-control" name="twilio_account_sid" value="<?php echo $twilio_account_sid;?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                                    <label for="field-1">
                                        <?php echo get_phrase('authentication_token');?>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-key"></i></div>
                                        <input type="text" class="form-control" name="twilio_auth_token" value="<?php echo $twilio_auth_token;?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                                    <label for="field-1">
                                        <?php echo get_phrase('registered_phone_number');?>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-id-badge"></i></div>
                                        <input type="text" class="form-control" name="twilio_sender_phone_number" value="<?php echo $twilio_sender_phone_number;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d">
                                    <?php echo get_phrase('save');?>
                                </button>
                            </div>
                            <?php echo form_close();?>
                    </section>
                </div>
            </div>
        </section>
    </div>

