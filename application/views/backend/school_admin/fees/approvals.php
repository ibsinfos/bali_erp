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
        <h4 class="page-title"><?php echo get_phrase('approvals'); ?> </h4></div>
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

<div class="row">
    <div class="col-md-12">
        <div class="white-box" data-step="5">
            <div class="row">
                <table id="table" class="table table-bordered display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><div><?php echo get_phrase('Date'); ?></div></th>
                            <th><div><?php echo get_phrase('description'); ?></div></th>
                            <th><div><?php echo get_phrase('report_id'); ?></div></th>
                            <th><div><?php echo get_phrase('employee_id'); ?></div></th>
                            <th><div><?php echo get_phrase('department'); ?></div></th>
                            <th><div><?php echo get_phrase('sent_to'); ?></div></th>
                            <th><div><?php echo get_phrase('status'); ?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

