<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('refund_list'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" 
        class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
    </div>
    <!-- /.breadcrumb -->
</div>
<div class="row m-0">
    <div class="col-md-12 white-box">
        <div class="sttabs tabs-style-flip">
            <nav>
                <ul>
                    <li class="active" data-step="5" data-intro="<?php echo get_phrase('From here you can view the list of fee head');?>" data-position='right'>
                        <a href="#list" class="sticon fa fa-list"><span class="hidden-xs"><?php echo get_phrase('refund_list'); ?></span></a>
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
                                <th><div><?php echo get_phrase('on_term'); ?></div></th>
                                <th><div><?php echo get_phrase('student'); ?></div></th>
                                <th><div><?php echo get_phrase('amount'); ?></div></th>
                                <th><div><?php echo get_phrase('date'); ?></div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($records as $i=>$rec): ?>
                                <tr>
                                    <td><?php echo ($i+1); ?></td>
                                    <td><?php echo $rec->term_name; ?></td>
                                    <td><?php echo $rec->student_name; ?></td>
                                    <td><?php echo $rec->refund_amount; ?></td>
                                    <td><?php echo date('d/m/Y',strtotime($rec->approve_date)); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </section>
                <!--TABLE LISTING ENDS-->
             
            </div>
        </div>
    </div>
</div>