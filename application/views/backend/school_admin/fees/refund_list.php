<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
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
                    <li id="listing" class="active">
                        <a href="#list" class="sticon fa fa-list"><span class="hidden-xs"><?php echo get_phrase('new_list'); ?></span></a>
                    </li>
                    <li id="create">
                        <a href="#add" class="sticon fa fa-plus-circle">
                            <span class="hidden-xs"><?php echo get_phrase('approved_list'); ?></span>
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
                                <th><div><?php echo get_phrase('collection_name'); ?></div></th>
                                <th><div><?php echo get_phrase('refund_rule'); ?></div></th>
                                <th><div><?php echo get_phrase('enroll_code'); ?></div></th>
                                <th><div><?php echo get_phrase('refund_amount'); ?></div></th>
                                <th><div><?php echo get_phrase('cashier_name'); ?></div></th>
                                <th><div><?php echo get_phrase('action'); ?></div></th>
                            </tr>
                        </thead>
                        <tbody>
<?php if(count($NotApproveData)){ $n = 1; foreach($NotApproveData as $datum): ?>
                            <tr>
                                <td><?php echo $n++; ?></td>
                                <td><?php echo $datum['collection_name']; ?></td>
                                <td><?php echo $datum['refund_rule_name']; ?></td>
                                <td><?php echo $datum['enroll_code']; ?></td>
                                <td><?php echo $datum['refund_amount']; ?></td>
                                <td><?php echo $datum['requester_name']; ?></td>
                                <td><a href="#"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View" title="View"><i class="fa fa-eye"></i></button></a> <a href="#" onclick="ConfirmAction('<?php echo base_url('index.php?fees/refund/approve/').$datum['refund_request_id'];?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Approve" title="Approve"><i class="fa fa-check-circle-o"></i></button></a> <a href="#" onclick="ConfirmAction('<?php echo base_url('index.php?fees/refund/reject/').$datum['refund_request_id'];?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Reject" title="Reject"><i class="fa fa-ban"></i></button></a></td>
                            </tr>
                            <?php endforeach; }?>
                        </tbody>
                    </table>
                </section>
                <!--TABLE LISTING ENDS-->
                <section id="add">  
                    <table class= "custom_table table display" cellspacing="0" width="100%" id="example_asc_time">
                        <thead>
                            <tr>
                                <th><div><?php echo get_phrase('no'); ?></div></th>
                                <th><div><?php echo get_phrase('collection_name'); ?></div></th>
                                <th><div><?php echo get_phrase('refund_rule'); ?></div></th>
                                <th><div><?php echo get_phrase('enroll_code'); ?></div></th>
                                <th><div><?php echo get_phrase('refund_amount'); ?></div></th>
                                <th><div><?php echo get_phrase('cashier_name'); ?></div></th>
                                <th><div><?php echo get_phrase('action'); ?></div></th>
                            </tr>
                        </thead>
                        <tbody>
<?php if(count($ApproveData)){ $n = 1; foreach($ApproveData as $datum): ?>
                            <tr>
                                <td><?php echo $n++; ?></td>
                                <td><?php echo $datum['collection_name']; ?></td>
                                <td><?php echo $datum['refund_rule_name']; ?></td>
                                <td><?php echo $datum['enroll_code']; ?></td>
                                <td><?php echo $datum['refund_amount']; ?></td>
                                <td><?php echo $datum['requester_name']; ?></td>
                                <td><a href="#"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View" title="View"><i class="fa fa-eye"></i></button></a> <a href="#" onclick="ConfirmAction('<?php echo base_url('index.php?fees/refund/reject/').$datum['refund_request_id'];?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Reject" title="Reject"><i class="fa fa-ban"></i></button></a></td>
                            </tr>
                            <?php endforeach; }?>
                        </tbody>
                    </table>        
                </section>                
            </div>
        </div>
    </div>
</div>  