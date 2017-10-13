<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"><h4 class="page-title"><?php echo $page_title; ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><?php echo get_phrase('dormitory'); ?>
                <ul>                    
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/manage_hostel_warden"><?php echo get_phrase('manage_warden'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/manage_hostel"><?php echo get_phrase('manage_hostel'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/manage_hostel_room"><?php echo get_phrase('manage_room'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/manage_allocation"><?php echo get_phrase('manage_allocation'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/mess_management"><?php echo get_phrase('mess_details'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/mess_timetable"><?php echo get_phrase('mess_timetable'); ?></a></li>
                </ul>
            </li>
            <li class="active">
                <?php echo $page_title; ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<div class="row">
    <div class="col-md-12">
        <div class="white-box" data-step="5" data-intro="<?php echo get_phrase('To fill this form you can add warden.');?>" data-position='top'>
            <?php echo form_open(base_url() . 'index.php?school_admin/add_warden'); ?> 
            <div class="row">
                <div class="col-xs-12 col-md-6 form-group">
                    <label for="field-1"><?php echo get_phrase("warden_name"); ?><span class="mandatory"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="ti-user"></i></div>
                        <input type="text" class="form-control" id="warden_name" name="warden_name" value="<?php echo set_value('warden_name') ?>" placeholder="Warden Name">
                    </div>
                    <span class="mandatory"> <?php echo form_error('warden_name'); ?></span>
                </div>
            
                <div class="col-xs-12 col-md-6 form-group">
                    <label for="warden_phone_number"><?php echo get_phrase("phone_number"); ?><span class="error mandatory"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                        <input type="text" class="form-control numeric" id="warden_phone_number" onkeypress="return isNumberKey(event);" name="warden_phone_number" value="<?php echo set_value('warden_phone_number') ?>" placeholder="Phone Number" maxlength="10">
                    </div>
                    <span class="mandatory"> <?php echo form_error('warden_phone_number'); ?></span>
                </div>
            </div>
        
            <div class="row">
                <div class="col-xs-12 col-md-6 form-group">
                    <label for="field-1"><?php echo get_phrase("Email_Id"); ?><span class="mandatory"> *</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-envelope-o"></i></div>
                        <input type="email" class="form-control" id="warden_email" name="warden_email" value="<?php echo set_value('warden_email') ?>" placeholder="Warden Email" required>
                    </div>
                    <span class="mandatory"> <?php echo form_error('warden_email'); ?></span>
                </div>
            </div>


            <div class="row">
                <div class="text-right col-xs-12 p-t-20">
                    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="6" data-intro="<?php echo get_phrase('On the click of this button you can submit the form.');?>" data-position='left'>
                        <?php echo get_phrase('add_warden'); ?>
                    </button>
                </div>
            </div>   

            <?php echo form_close(); ?>

        </div>
    </div></div>

<script type="text/javascript">

    $(document).ready(function () {
        $(".numeric").numeric();
    });
    
       function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
</script>

