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

<div class="col-sm-12 white-box" data-step="5" data-intro="Here you can view the list of invoices." data-position='top'>
    <?php if ($this->session->flashdata('flash_message_error')) { ?>        
        <div class="alert alert-danger">
        <?php echo $this->session->flashdata('flash_message_error') . get_phrase('error'); ?>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-4">
            Academic Year: <input type="text" readonly="readonly" value="<?php echo date('Y').'-'.date('Y',strtotime('+1 year')); ?>" />
        </div>
    </div>
    <div class="clearfix">&nbsp;</div>
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="radio" name="invoice_filter" value="1" checked="checked" /> All
            <input type="radio" name="invoice_filter" value="2" /> Emailed
            <input type="radio" name="invoice_filter" value="3" /> Not Emailed
            <input type="radio" name="invoice_filter" value="4" /> Failed
        </div>
    </div>
    <div class="clearfix">&nbsp;</div>
    <table id="table" class="table table-bordered table-condensed display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th><input type="checkbox" name="check_all" value="1" /></th>
                <th><div><?php echo get_phrase('No'); ?></div></th>
                <th width="15%"><div><?php echo get_phrase('Date'); ?></div></th>
                <th><div><?php echo get_phrase('invoice_no.'); ?></div></th>
                <th><div><?php echo get_phrase('student_id'); ?></div></th>
                <th><div><?php echo get_phrase('name'); ?></div></th>
                <th><div><?php echo get_phrase('email_id'); ?></div></th>
                <th><div><?php echo get_phrase('class'); ?></div></th>
                <th><div><?php echo get_phrase('action'); ?></div></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="checkbox" name="check[]" value="1" /></td>
                <td>1</td>
                <td><?php echo date('Y-m-d'); ?></td>
                <td>1234</td>
                <td>306</td>
                <td>abc abc</td>
                <td>abc@gmail.com</td>
                <td>Nursery</td>
                <td>
                    <input type="button" class="btn btn-success btn-xs" value="View"> &nbsp;
                    <input type="button" class="btn btn-success btn-xs" value="Print">
                </td>
            </tr>
        </tbody>
    </table>
    <div class="clearfix">&nbsp;</div>
    <div class="row text-center">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <input type="button" class="btn btn-primary btn-sm" value="Send Invoice" />
        </div>
    </div>
</div>