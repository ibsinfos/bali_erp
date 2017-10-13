<style type="text/css">
    .white-box {
        font-size: 12px !important;
    }

    .form-group, .m-b-20 {
        margin-bottom: 0 !important;
    }
    
    .mt20 {
        margin-top: 20px;
    }
</style>

<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('day_end_process'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light btn-xs">Take a Tour</a>
        
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

    <?php if(!$closed){?>
        <div class="col-md-6 text-right">
            <a href="#" onclick="ConfirmAction('<?php echo base_url('index.php?fees/main/do_day_end')?>');">
                <button  type="button" class="btn btn-danger btn-outline btn-1d btn-sm"><?php echo get_phrase('hard_close'); ?></button>
            </a>
        </div>
    <?php }else{?>
        <div class="col-md-6 text-right">
            <h4>Collection Closed for today!</h4>
        </div>
    <?php }?>    
</div>

<div class="col-md-12 white-box">
    <h4><?php echo get_phrase("Today's_collection"); ?></h4>
    <table id="example23" class="table display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th><div><?php echo get_phrase('collection_type'); ?></div></th>
                <th><div><?php echo get_phrase('amount'); ?></div></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Cash</td>
                <td><?php echo sett('currency').' '.$collecs['cash']?></td>
            </tr>
            <tr>
                <td>Cheque</td>
                <td><?php echo sett('currency').' '.$collecs['cheque']?></td>
            </tr>
            <tr>
                <td>Credit</td>
                <td><?php echo sett('currency').' '.$collecs['card']?></td>
            </tr>
            <tr>
                <td>Online</td>
                <td><?php echo sett('currency').' '.$collecs['online']?></td>
            </tr>     
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right"><h4>Grand Total<h4></th>
                <td><h4><?php echo sett('currency').' '.$total_collection?><h4></td>
            </tr>
        </tfoot>
    </table>
</div>