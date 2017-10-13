<style type="text/css">
    .table-condensed>tbody>tr>td, .table-condensed>tbody>tr>th {
        padding: 5px !important;
    }
</style>
<div class="row bg-title"> 
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
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


<div class="col-sm-12 white-box" data-step="5" data-intro="Here you can view the list of cancellations." data-position='top'>
    <?php if ($this->session->flashdata('flash_message_error')) { ?>        
        <div class="alert alert-danger">
        <?php echo $this->session->flashdata('flash_message_error') . get_phrase('error'); ?>
        </div>
    <?php } ?>
    
    <?php echo form_open(base_url('index.php?fees/fees/cancellation'), array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label for="field-1"><?php echo get_phrase("name"); ?><span class="mandatory"> *</span></label>
                <div class="input-group">
                    <div class="input-group-addon input-sm"><i class="fa fa-sort-numeric-desc"></i></div>    
                    <input type="text" class="form-control input-sm" id="name" name="name" placeholder="Student Name" required="required" />
                    <span class="mandantory"> <?php echo form_error('name'); ?></span>
                </div> 
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label for="field-1"><?php echo get_phrase("payment_date"); ?><span class="mandatory"> *</span></label>
                <div class="input-group">
                    <div class="input-group-addon input-sm"><i class="fa fa-sort-numeric-desc"></i></div>    
                    <input type="text" class="form-control input-sm" id="payment_date" name="payment_date" placeholder="Date of Payment" required="required">
                    <span class="mandantory"> <?php echo form_error('payment_date'); ?></span>
                </div> 
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label for="field-1"><?php echo get_phrase("registration_no"); ?><span class="mandatory"> *</span></label>
                <div class="input-group">
                    <div class="input-group-addon input-sm"><i class="fa fa-sort-numeric-desc"></i></div>    
                    <input type="text" class="form-control input-sm" id="registration_number" name="registration_number" placeholder="Registration Number" required="required" />
                    <span class="mandantory"> <?php echo form_error('registration_number'); ?></span>
                </div> 
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label for="field-1"><?php echo get_phrase("program_/_course"); ?><span class="mandatory"> *</span></label>
                <div class="input-group">
                    <div class="input-group-addon input-sm"><i class="fa fa-sort-numeric-desc"></i></div>    
                    <input type="text" class="form-control input-sm" id="course_name" name="course_name" placeholder="Course Name" required="required" />
                    <span class="mandantory"> <?php echo form_error('course_name'); ?></span>
                </div> 
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label for="field-1"><?php echo get_phrase("address"); ?><span class="mandatory"> *</span></label>
                <div class="input-group">
                    <div class="input-group-addon input-sm"><i class="fa fa-sort-numeric-desc"></i></div>    
                    <input type="text" class="form-control input-sm" id="address" name="address" placeholder="Address" required="required" />
                    <span class="mandantory"> <?php echo form_error('address'); ?></span>
                </div> 
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label for="field-1"><?php echo get_phrase("contact_no"); ?><span class="mandatory"> *</span></label>
                <div class="input-group">
                    <div class="input-group-addon input-sm"><i class="fa fa-sort-numeric-desc"></i></div>    
                    <input type="text" class="form-control input-sm" id="contact_number" name="contact_number" placeholder="Contact Number" required="required" />
                    <span class="mandantory"> <?php echo form_error('contact_number'); ?></span>
                </div> 
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label for="field-1"><?php echo get_phrase("email_id"); ?><span class="mandatory"> *</span></label>
                <div class="input-group">
                    <div class="input-group-addon input-sm"><i class="fa fa-sort-numeric-desc"></i></div>    
                    <input type="text" class="form-control input-sm" id="email_id" name="email_id" placeholder="Email Id" required="required" />
                    <span class="mandantory"> <?php echo form_error('email_id'); ?></span>
                </div> 
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label for="field-1"><?php echo get_phrase("date"); ?><span class="mandatory"> *</span></label>
                <div class="input-group">
                    <div class="input-group-addon input-sm"><i class="fa fa-sort-numeric-desc"></i></div>    
                    <input type="text" class="form-control input-sm" id="date" name="date" placeholder="Date" required="required" />
                    <span class="mandantory"> <?php echo form_error('date'); ?></span>
                </div>             
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label for="field-1"><?php echo get_phrase("reason"); ?><span class="mandatory"> *</span></label>
                <div class="input-group">
                    <div class="input-group-addon input-sm"><i class="fa fa-sort-numeric-desc"></i></div>    
                    <textarea class="form-control input-sm" id="reason" name="reason" placeholder="Reason for cancellation" required="required"></textarea>
                    <span class="mandantory"> <?php echo form_error('reason'); ?></span>
                </div> 
            </div>
        </div>
        <div class="clearfix">&nbsp;</div>
        <div class="row">
            <div class="col-md-6 col-md-offset-5 col-sm-3 col-sm-offset-5 col-xs-12">
                <input type="button" class="btn btn-primary btn-sm" value="Submit" />
            </div>
        </div>
    <?php echo form_close(); ?>  
</div>

<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
jQuery('#date,#payment_date').datepicker({
   endDate:'-2y',
   autoclose: true
 });  
</script>