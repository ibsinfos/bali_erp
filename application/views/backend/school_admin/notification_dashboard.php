<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('Notification_dashboard'); ?></h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" target="_blank" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
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
    <!-- /.breadcrumb -->
</div>

<?php echo form_open(base_url().'index.php?school_admin/notification_dashboard', array('class' =>'form-group','id'=>'dashboard_form'));?>

<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <section>
                <div class="sttabs tabs-style-flip">
                    <nav>
                        <ul>
                            <li><a href="#section-flip-5" class="sticon fa fa-user"><span>Admin</span></a></li>
                            <li><a href="#section-flip-4" class="sticon fa fa-users"><span>Employees</span></a></li>
                            <li><a href="#section-flip-2" class="sticon fa fa-book"><span>Teachers</span></a></li>
                            <li><a href="#section-flip-3" class="sticon fa fa-child"><span>Parents</span></a></li>

                        </ul>
                    </nav>
                    <div class="content-wrap">
                        <section id="section-flip-1">
                            <div class="table-responsive">
                                <table class="table-bordered table white-box">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                <b><?php echo get_phrase('Choose'); ?></b>
                                            </th>
                                            <th class="text-center">
                                                <b><?php echo get_phrase('SMS'); ?></b>
                                            </th>
                                            <th class="text-center">
                                                <b><?php echo get_phrase('Email'); ?></b>
                                            </th>
                                            <th class="text-center">
                                                <b><?php echo get_phrase('Push'); ?></b>
                                            </th>
                                            <th class="text-center">
                                                <b><?php echo get_phrase('NotificationLink'); ?></b>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        foreach ($records as $record) { 
                                            if($record['user_type'] == 1) { //admin ?>
                                                    <tr>
                                                        <td><b><?php echo $record['activity_label'];?></b></td>
                                                        <td class="text-center">
                                                            <input type="checkbox" name="<?php echo 'sms_'.$record['activity'];?>" value="1" <?php echo ($record[ 'sms']==1 ? "checked" : "") ?>/>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="checkbox" name="<?php echo 'email_'.$record['activity'];?>" value="1" <?php echo ($record[ 'email']==1 ? "checked" : ""); ?>/>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="checkbox" name="<?php echo 'push_'.$record['activity'];?>" value="1" <?php echo ($record[ 'push_notify']==1 ? "checked" : ""); ?>/>
                                                        </td>
                                                        <td align="center">
                                                            <input type="text" value="<?php echo $record[ 'notification_link'];?>" name="<?php echo 'link_'.$record['activity'];?>" >
                                                        </td>
                                                    </tr>
                                            <?php
                                            } 
                                        } ?>
                                    </tbody>
                                </table>
                            </div>


                        </section>
                        <section id="section-flip-2">
                            <div class="table-responsive">
                                <table class="table-bordered table white-box">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                <b><?php echo get_phrase('Choose'); ?></b>
                                            </th>
                                            <th class="text-center">
                                                <b><?php echo get_phrase('SMS'); ?></b>
                                            </th>
                                            <th class="text-center">
                                                <b><?php echo get_phrase('Email'); ?></b>
                                            </th>
                                            <th class="text-center">
                                                <b><?php echo get_phrase('Push'); ?></b>
                                            </th>
                                            <th class="text-center">
                                                <b><?php echo get_phrase('NotificationLink'); ?></b>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        foreach ($records as $record) { 
                                            if($record['user_type'] == 2) { //employees?>
                                                    <tr>
                                                        <td><b><?php echo $record['activity_label'];?></b></td>
                                                        <td class="text-center">
                                                            <input type="checkbox" name="<?php echo 'sms_'.$record['activity'];?>" value="1" <?php echo ($record[ 'sms']==1 ? "checked" : "") ?>/>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="checkbox" name="<?php echo 'email_'.$record['activity'];?>" value="1" <?php echo ($record[ 'email']==1 ? "checked" : ""); ?>/>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="checkbox" name="<?php echo 'push_'.$record['activity'];?>" value="1" <?php echo ($record[ 'push_notify']==1 ? "checked" : ""); ?>/>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="text" value="<?php echo $record[ 'notification_link'];?>" name="<?php echo 'link_'.$record['activity'];?>" >
                                                        </td>
                                                    </tr>
                                            <?php
                                            } 
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                        <section id="section-flip-3">
                            <div class="table-responsive">
                                <table class="table-bordered table white-box">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                <b><?php echo get_phrase('Choose'); ?></b>
                                            </th>
                                            <th class="text-center">
                                                <b><?php echo get_phrase('SMS'); ?></b>
                                            </th>
                                            <th class="text-center">
                                                <b><?php echo get_phrase('Email'); ?></b>
                                            </th>
                                            <th class="text-center">
                                                <b><?php echo get_phrase('Push'); ?></b>
                                            </th>
                                            <th class="text-center">
                                                <b><?php echo get_phrase('NotificationLink'); ?></b>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        foreach ($records as $record) { 
                                            if($record['user_type'] == 3) { //teacher ?>
                                                    <tr>
                                                        <td><b><?php echo $record['activity_label'];?></b></td>
                                                        <td class="text-center">
                                                            <input type="checkbox" name="<?php echo 'sms_'.$record['activity'];?>" value="1" <?php echo ($record[ 'sms']==1 ? "checked" : "") ?>/>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="checkbox" name="<?php echo 'email_'.$record['activity'];?>" value="1" <?php echo ($record[ 'email']==1 ? "checked" : ""); ?>/>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="checkbox" name="<?php echo 'push_'.$record['activity'];?>" value="1" <?php echo ($record[ 'push_notify']==1 ? "checked" : ""); ?>/>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="text" value="<?php echo $record[ 'notification_link'];?>" name="<?php echo 'link_'.$record['activity'];?>" >
                                                        </td>
                                                    </tr>
                                            <?php
                                            } 
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                        <section id="section-flip-4">
                            <div class="table-responsive">
                                <table class="table-bordered table white-box">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                <b><?php echo get_phrase('Choose'); ?></b>
                                            </th>
                                            <th class="text-center">
                                                <b><?php echo get_phrase('SMS'); ?></b>
                                            </th>
                                            <th class="text-center">
                                                <b><?php echo get_phrase('Email'); ?></b>
                                            </th>
                                            <th class="text-center">
                                                <b><?php echo get_phrase('Push'); ?></b>
                                            </th>
                                            <th class="text-center">
                                                <b><?php echo get_phrase('NotificationLink'); ?></b>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        foreach ($records as $record) { 
                                            if($record['user_type'] == 4) { //parents?>
                                                    <tr>
                                                        <td><b><?php echo $record['activity_label'];?></b></td>
                                                        <td class="text-center">
                                                            <input type="checkbox" name="<?php echo 'sms_'.$record['activity'];?>" value="1" <?php echo ($record[ 'sms']==1 ? "checked" : "") ?>/>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="checkbox" name="<?php echo 'email_'.$record['activity'];?>" value="1" <?php echo ($record[ 'email']==1 ? "checked" : ""); ?>/>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="checkbox" name="<?php echo 'push_'.$record['activity'];?>" value="1" <?php echo ($record[ 'push_notify']==1 ? "checked" : ""); ?>/>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="text" value="<?php echo $record[ 'notification_link'];?>" name="<?php echo 'link_'.$record['activity'];?>" >
                                                        </td>
                                                    </tr>
                                            <?php
                                            } 
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </section>

                    </div>
                    <!-- /content -->

                    <div class="row">
                        <div class="col-md-12 form-group text-center m-t-20">
                            <input type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" id="submit_notification" name="submit" value="Submit">
                        </div>
                    </div>
                </div>
                <!-- /tabs -->
            </section>
        </div>
    </div>
</div>

