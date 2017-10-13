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

<div class="col-md-12 white-box">
    <div class="col-md-3">
        <h4><?php echo get_phrase('academic_year : ').$running_year; ?></h4>
    </div>

    <div class="col-md-3">
        <h4><?php echo get_phrase('date : ').date('d-m-Y'); ?></h4>
    </div>
</div>

<?php echo form_open(base_url() . 'index.php?school_admin/student/create/', array('class' => 'form-groups-bordered validate', 'enctype' => 'multipart/form-data', 'id' => 'addStudentForm')); ?>

<div class="col-sm-12 white-box">
    <div class="row">
        <div class="col-md-4 form-group">
            <label for="field-1"><?php echo get_phrase('caption'); ?></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="ti-user"></i></div>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('caption');?>" placeholder="Enter caption" data-validate="required" data-message-required="Please enter your first name "> </div>
                <span id="error_name" class="mandatory"></span>
        </div>

        <div class="col-sm-4 form-group">
            <label for="field-1">
                <?php echo get_phrase('date'); ?>
            </label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-calendar"></i></div><input type="text" class="form-control mydatepicker" placeholder="<?php echo get_phrase("select_date");?>" required="required" name="purchase_date" type="text" value="<?php echo set_value('purchase_date'); ?>" >
            </div>

        </div>
        <div class="col-sm-4 form-group">
            <label for="field-1"><?php echo get_phrase('business_unit'); ?></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="ti-user"></i></div>
                <input type="text" class="form-control" id="lname" name="lname" value="<?=set_value('lname')?>" placeholder="<?php echo get_phrase("enter_business_unit");?>">
            </div>
             <span id="error_lname" class="mandatory"></span>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 form-group">
            <label for="field-1">
                <?php echo get_phrase('academic_year'); ?></label>
            <div class="input-group">
                <select class="selectpicker" data-style="form-control" data-live-search="true" name="running_year" id="running_year">
                    <option value=""><?php echo get_phrase('select_academic_year'); ?></option><?php $cYear = date('Y') + 1; for ($i = 0; $i < 10; $i++): ?>
                    <option value="<?php echo $cYear - $i - 1; ?>-<?php echo ($cYear - $i); ?>"><?php echo ($cYear - $i - 1); ?>-<?php echo ($cYear - $i); ?></option><?php endfor; ?>
                </select>
            </div><span id="error_name" class="mandatory"></span>
        </div>

        <div class="col-sm-4 form-group">
            <label for="field-1">
                <?php echo get_phrase('receipt_no'); ?>
            </label>
            <div class="input-group">
                <div class="input-group-addon"><i class="ti-user"></i></div>
                <input type="text" class="form-control" id="mname" name="mname" value="<?=set_value('mname')?>" placeholder="<?php echo get_phrase("enter_receipt_no");?>">
            </div>

        </div>
        <div class="col-sm-4 form-group">
            <label for="field-1"><?php echo get_phrase('total_amount'); ?></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="ti-user"></i></div>
                <input type="text" class="form-control" id="lname" name="lname" value="<?=set_value('lname')?>" placeholder="<?php echo get_phrase("enter_amount");?>">
            </div><span id="error_lname" class="mandatory"></span>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 form-group">
            <label for="media_consent"><?php echo get_phrase("service_invoice");?></label>
            <div class="input-group">
                <input type="radio" name="media_consent" value="NO" checked="checked" > NO &nbsp;
                <input type="radio" name="media_consent" value="YES"> YES
            </div>
        </div>

        <div class="col-sm-4 form-group">
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase("submit");?></button> 
        </div>
    </div>

</div><?php echo form_close(); ?>