<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="row bg-title"> 
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('manage general settings'); ?> </h4></div>
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

<?php echo form_open(base_url('index.php?school_admin/system_settings/do_update'), array('class' => 'validate','target'=>'_top'));?>
<div class="col-md-12 white-box" data-step="5" data-intro="<?php echo get_phrase('you can configure system related settings from here!!');?>" data-position='top'>  
    <div class="row">
        <div class="col-sm-4 form-group">          
            <label for="field-1"><?php echo get_phrase("system_name"); ?></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-user-circle"></i></div>
                <input type="text" class="form-control" id="system_name" name="system_name" placeholder="System Name" 
                value="<?php echo fetch_parl_key_rec($settings,'system_name'); ?>" />
            </div>
        </div>
        <div class="col-sm-4 form-group">
            <div class="form-group">
                <label for="field-1"><?php echo get_phrase("system_title"); ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-life-ring"></i></div>
                    <input type="text" class="form-control" id="system_title" name="system_title" placeholder="Description" value="<?php echo fetch_parl_key_rec($settings,'system_title'); ?>">
                </div>
            </div>
        </div>
        <div class="col-sm-4 form-group">
            <div class="form-group">
                <label for="field-1"><?php echo get_phrase("address"); ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-address-card-o"></i></div>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Address" 
                    value="<?php echo fetch_parl_key_rec($settings,'address')?>" >
                </div>
            </div>
        </div>
    </div>

    <div class ="row">
        <div class="col-md-4 form-group">
            <div class="form-group">
                <label for="phone"><?php echo get_phrase("phone"); ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" onkeypress='return valid_only_numeric(event);' 
                    value="<?php echo fetch_parl_key_rec($settings,'phone')?>" >
                </div>
            </div>
        </div>
        <div class="col-md-4 form-group">
            <div class="form-group">
                <label for="paypal_email"><?php echo get_phrase("paypal_email"); ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-mail-forward"></i></div>
                    <input type="text" class="form-control" id="paypal_email" name="paypal_email" placeholder="Paypal Email" 
                    value="<?php echo fetch_parl_key_rec($settings,'paypal_email')?>" >
                </div>
            </div>
        </div>
        <div class="col-md-4 form-group">
            <div class="form-group">
                <label for="currency"><?php echo get_phrase("currency"); ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-money"></i></div>
                    <input type="text" class="form-control" id="currency" name="currency" placeholder="Currency" 
                    value="<?php echo fetch_parl_key_rec($settings,'currency')?>">
                </div>
            </div>
        </div>
    </div>

    <div class ="row">
        <div class="col-md-4 form-group">
            <div class="form-group">
                <label for="system_email"><?php echo get_phrase("system_email"); ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-mail-reply"></i></div>
                    <input type="text" class="form-control" id="system_email" name="system_email" placeholder="System Email" 
                    value="<?php echo fetch_parl_key_rec($settings,'system_email')?>" >
                </div>
            </div>
        </div>
        <div class="col-md-4 form-group">
            <div class="form-group">
                <label for="start_time"><?php echo get_phrase("Start time from"); ?></label>
            <div class="input-group clockpicker " data-placement="bottom" data-align="top" data-autoclose="true">
                            <span class="input-group-addon"> <span class="glyphicon glyphicon-time"></span> </span>
                    <input type="text" class="form-control" id="system_email" name="startfrom" placeholder="Start time" 
                    value="<?php echo fetch_parl_key_rec($settings,'startfrom')?>" >
                </div>
            </div>
        </div>
        <div class="col-md-4 form-group">
            <div class="form-group">
                <label for="start_time"><?php echo get_phrase("Start time till"); ?></label>
                <div class="input-group clockpicker " data-placement="bottom" data-align="top" data-autoclose="true">
                            <span class="input-group-addon"> <span class="glyphicon glyphicon-time"></span> </span>
                    <input type="text" class="form-control" id="system_email" name="startto" placeholder="Start time from" 
                    value="<?php echo fetch_parl_key_rec($settings,'startto')?>" >
                </div>
            </div>
        </div>
    </div>

    <div class ="row">       
        <div class="col-md-4 form-group">
            <div class="form-group">
                <label for="start_time_till"><?php echo get_phrase("End Time from"); ?></label>
                <div class="input-group clockpicker " data-placement="bottom" data-align="top" data-autoclose="true">
                    <span class="input-group-addon"> <span class="glyphicon glyphicon-time"></span> </span>
                    <input type="text" class="form-control" id="system_email" name="endfrom" placeholder="hrs:mins" 
                    value="<?php echo fetch_parl_key_rec($settings,'endfrom')?>" >
                </div>
            </div>
        </div>
        <div class="col-md-4 form-group">
            <div class="form-group">
                <label for="end_time_from"><?php echo get_phrase("School end till"); ?></label>
                <div class="input-group clockpicker " data-placement="bottom" data-align="top" data-autoclose="true">
                    <span class="input-group-addon"> <span class="glyphicon glyphicon-time"></span> </span>
                    <input type="text" class="form-control" id="system_email" name="endto" placeholder="hrs:mins" 
                    value="<?php echo fetch_parl_key_rec($settings,'endto')?>" >
                </div>
            </div>
        </div>

        <div class="col-md-4 form-group">
            <div class="form-group">
                <label for="running_session"><?php echo get_phrase('timezone'); ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                    <select name="timezone" class="selectpicker" data-style="form-control" data-live-search="true">
                          <option value=""><?php echo get_phrase('select_timezone');?></option>
                          <?php foreach(DateTimeZone::listIdentifiers() as $timezone){?>
                                <option value="<?php echo $timezone?>" <?php echo($timezone==fetch_parl_key_rec($settings,'timezone'))?'selected':'';?>>
                                    <?php echo $timezone?>
                                </option>
                          <?php }?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 form-group">
            <div class="form-group">
                <label for="running_session"><?php echo get_phrase("running_session"); ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                    <select name="running_year" class="selectpicker" data-style="form-control" data-live-search="true">
                          <option value=""><?php echo get_phrase('select_running_session');?></option>
                          <?php for($i = 0; $i < 10; $i++):?>
                                <option value="<?php echo (2016+$i);?>-<?php echo (2016+$i+1);?>"
                                    <?php if($running_year == (2016+$i).'-'.(2016+$i+1)) echo 'selected';?>>
                                    <?php echo (2016+$i);?>-<?php echo (2016+$i+1);?>
                                </option>
                          <?php endfor;?>
                    </select>
                </div>
            </div>
        </div>                    
    
        <div class="col-md-4 form-group">
            <div class="form-group">
                <label for="end_time_from"><?php echo get_phrase('start_month'); ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                    <input type="text" class="form-control mtp" id="start_month" name="start_month" placeholder="<?php echo get_phrase('start_month')?>" 
                    value="<?php echo fetch_parl_key_rec($settings,'start_month')?>"/>
                </div>
            </div>
        </div>

        <div class="col-md-4 form-group">
            <div class="form-group">
                <label  for="location"><?php echo get_phrase('end_month');?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-language"></i></div>
                    <input type="text" class="form-control mtp" id="end_month" name="end_month" placeholder="<?php echo get_phrase('end_month')?>" 
                    value="<?php echo fetch_parl_key_rec($settings,'end_month')?>"/>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row"> 
        <div class="col-md-4 form-group">
            <div class="form-group">
                <label for="end_time_from"><?php echo get_phrase("language"); ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-language"></i></div>
                    <select name="language" class="selectpicker" data-style="form-control" data-live-search="true">
                        <?php  foreach ($fields as $field) {
                            if ($field == 'phrase_id' || $field == 'phrase')continue; ?>
                            <option value="<?php echo $field;?>"
                                <?php echo($field == fetch_parl_key_rec($settings,'language'))?'selected':'';?>> <?php echo $field;?> 
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>

        <?php $location = fetch_parl_key_rec($settings,'location');?>
        <div class="col-md-4 form-group">
            <div class="form-group">
                <label  for="location"><?php echo get_phrase('location');?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-language"></i></div>
                    <select name="location" class="selectpicker" data-style="form-control" data-live-search="true">
                        <option value="india" <?php if($location=='india'){ echo 'selected'; }?> >India</option>
                        <option value="dubai" <?php if($location=='dubai'){ echo 'selected'; }?> >Dubai</option>
                        <option value="saudi" <?php if($location=='saudi'){ echo 'selected'; }?> >Saudi Arabia</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 form-group">
            <div class="form-group">
                <label for="text_align"><?php echo get_phrase('text_align');?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-align-justify"></i></div>
                    <select name="text_align" class="selectpicker" data-style="form-control" data-live-search="true">
                        <option value="left-to-right" <?php if ($text_align == 'left-to-right')echo 'selected';?>> left-to-right</option>
                        <option value="right-to-left" <?php if ($text_align == 'right-to-left')echo 'selected';?>> right-to-left</option>
                    </select>
                </div>
            </div>
        </div>         
    </div>    

    <div class="row">               
        <div class="col-md-4 form-group">
            <div class="form-group">
                <label for="end_time_from"><?php echo get_phrase("enroll_code_prefix"); ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-times-rectangle-o"></i></div>
                    <input type="text" class="form-control" id="enroll_code_prefix" name="enroll_code_prefix" placeholder="Enroll Prefix" 
                    value="<?php echo fetch_parl_key_rec($settings,'enroll_code_prefix')?>" >
                </div>
            </div>
        </div>

        <div class="col-md-4 form-group">
            <div class="form-group">
                <label for="end_time_from"><?php echo get_phrase("minimum_attendance_percentage"); ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-check-square"></i></div>
                    <input type="text" class="form-control" id="minimum_attendance" name="minimum_attendance" placeholder="Minimum Attendance Percentage" 
                    value="<?php echo fetch_parl_key_rec($settings,'minimum_attendance')?>" >
                </div>
            </div>
        </div>

        <div class="col-md-4 form-group">
            <div class="form-group">
                <label for="end_time_from"><?php echo get_phrase('bus_attendance_buffer_time');?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-check-square"></i></div>
                    <input type="text" class="form-control" id="bus_attendance_buffer_time" name="bus_attendance_buffer_time" 
                    placeholder="<?php echo get_phrase('bus_attendance_buffer_time')?>" 
                    value="<?php echo fetch_parl_key_rec($settings,'bus_attendance_buffer_time')?>"/>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 form-group">
            <div class="form-group">
                <label for="end_time_from"><?php echo get_phrase('RFID_attendance_buffer_time');?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-check-square"></i></div>
                    <input type="text" class="form-control" id="rfid_attendance_buffer_time" name="rfid_attendance_buffer_time" 
                    placeholder="<?php echo get_phrase('RFID_attendance_buffer_time')?>" 
                    value="<?php echo fetch_parl_key_rec($settings,'rfid_attendance_buffer_time')?>" >
                </div>
            </div>
        </div>                    

        <div class="col-md-4">
            <div class="form-group">
                <label for=""><?php echo get_phrase('fees_pay_priority');?></label>
                <ul id="sortable2" class="connectedSortable">
                    <li id="<?php echo sett('fees_priority_1')?sett('fees_priority_1'):'tuition'?>" class="ui-state-highlight" 
                        style="margin-left:0px;text-transform: capitalize;">
                        <i class="fa fa-bars"></i> <?php echo sett('fees_priority_1')?sett('fees_priority_1'):get_phrase('tuition')?>
                    </li>
                    <li id="<?php echo sett('fees_priority_2')?sett('fees_priority_2'):'transport'?>" class="ui-state-highlight" 
                        style="margin-left:0px;text-transform: capitalize;">
                        <i class="fa fa-bars"></i> <?php echo sett('fees_priority_2')?sett('fees_priority_2'):get_phrase('transport')?>
                    </li>
                    <li id="<?php echo sett('fees_priority_3')?sett('fees_priority_3'):'hostel'?>" class="ui-state-highlight" 
                        style="margin-left:0px;text-transform: capitalize;">
                        <i class="fa fa-bars"></i> <?php echo sett('fees_priority_3')?sett('fees_priority_3'):get_phrase('hostel')?>
                    </li>
                </ul>
                <input type="hidden" name="fees_priority_1" value="<?php echo fetch_parl_key_rec($settings,'fees_priority_1')?>"/>
                <input type="hidden" name="fees_priority_2" value="<?php echo fetch_parl_key_rec($settings,'fees_priority_2')?>"/>
                <input type="hidden" name="fees_priority_3" value="<?php echo fetch_parl_key_rec($settings,'fees_priority_3')?>"/>
            </div>
        </div>
    </div>

    <h2><?php echo get_phrase('social_settings')?></h2>
    <hr/>
    <div class="row"> 
        <div class="col-md-4 form-group">
            <div class="form-group">
                <label for="facebook_page"><?php echo get_phrase("facebook"); ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-facebook-official"></i></div>
                    <input type="text" class="form-control" id="facebook_page" name="facebook_page" placeholder="Facebook" 
                    value="<?php echo fetch_parl_key_rec($settings,'facebook_page')?>" >
                </div>
            </div>
        </div>
        <div class="col-md-4 form-group">
            <div class="form-group">
                <label for="linkedin_page"><?php echo get_phrase("linkedin"); ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-linkedin-square"></i></div>
                    <input type="text" class="form-control" id="linkedin_page" name="linkedin_page" placeholder="Linkedin" 
                    value="<?php echo fetch_parl_key_rec($settings,'linkedin')?>" >
                </div>
            </div>
        </div>
	    <div class="col-md-4 form-group">
            <div class="form-group">
                <label for="twitter_page"><?php echo get_phrase("twitter"); ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-twitter-square"></i></div>
                    <input type="text" class="form-control" id="twitter_page" name="twitter_page" placeholder="Twitter" 
                    value="<?php echo fetch_parl_key_rec($settings,'twitter_page')?>"  >
                </div>
            </div>
        </div>	  
    </div>

    <div class="row">
        <div class="col-md-4 form-group">
            <div class="form-group">
                <label for="pinterest"><?php echo get_phrase("pinterest"); ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-pinterest-p"></i></div>
                    <input type="text" class="form-control" id="pinterest" name="pinterest" placeholder="Pinterest" 
                    value="<?php echo fetch_parl_key_rec($settings,'pinterest')?>">
                </div>
            </div>
        </div>
        <div class="col-md-4 form-group">
            <div class="form-group">
                <label for="google_drive_mail_address"><?php echo get_phrase("google_drive_mail_address"); ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-google-plus-official"></i></div>
                    <input type="email" class="form-control" id="google_drive_mail_address" name="google_drive_mail_address" placeholder="Google Drive"
                    value="<?php echo fetch_parl_key_rec($settings,'google_drive_mail_id')?>"  >
                </div>
            </div>
        </div>
    </div>
    <div class="text-right col-xs-12 no-padding">
	    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d">Save Settings</button>
    </div>
<?php echo form_close(); ?>
</div>  

<?php echo form_open(base_url() . 'index.php?school_admin/system_settings/upload_logo' , array('class' => 'validate','target'=>'_top' , 'enctype' => 'multipart/form-data'));?>
<div class="col-md-12 white-box" >
    <?php
    //    $filename = base_url().'uploads/logo.png';
    //    $lastModified = @filemtime($filename);
    //    $lastModified = @filemtime(utf8_decode($filename));
    //    $date_last_modif = date('Y-m-d', @filemtime($filename));
    ?>
    <!--<img src="<?php //echo $filename."?".$lastModified ;?>">-->
    <label for="field-2"> <?php echo get_phrase('upload_logo'); ?> <span class="error mandatory"> *</span></label>
    <input type="file" id="input-file-now" name ="logo_image" class="dropify" required/>
        
    <div class="text-right col-xs-12 p-t-20 no-padding" >
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d">Upload Logo</button>
    </div>
</div>

<?php echo form_open(base_url().'index.php?updater/update' , array('class' => '', 'enctype' => 'multipart/form-data'));?>
<div class="col-md-12 white-box" data-step="7" data-intro="<?php echo get_phrase('you can add a phrase from here!!');?>" data-position='top'>                
    <div class="form-group">
        <div class="fileinput fileinput-new input-group input-group" data-provides="fileinput">
            <div class="form-control" data-trigger="fileinput"> 
                <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span>
            </div> 
            <span class="input-group-addon btn btn-default btn-file"> 
                <span class="fileinput-new">Select file</span> 
                <span class="fileinput-exists">Change</span>
                <input type="file" name="file_name"> 
            </span> 
            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>  
        </div>
    </div>

    <div class="text-right col-xs-12 no-padding">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d">Update Product</button>
    </div>
</div>                       
<?php echo form_close(); ?>

<?php echo form_close();?>


<script type="text/javascript">
$(function(){
    $('#sortable2').sortable({
        update: function(event, ui) {
            var newOrder = $(this).sortable('toArray');
            newOrder.forEach(function(o,i){
                console.log('fees_priority_'+(i+1));
                $('input[name=fees_priority_'+(i+1)+']').val(o);
            });
        }
    });

    $(".gallery-env").on('click', 'a', function () {
        skin = this.id;
        $.ajax({
            url: '<?php echo base_url();?>index.php?school_admin/system_settings/change_skin/'+ skin,
            success: window.location = '<?php echo base_url();?>index.php?school_admin/system_settings/'
        });
    });

    $('.mtp').datepicker({ 
        minViewMode:1,
        format:'MM-yyyy',
        autoclose:true
    });
})


function valid_only_numeric(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>   