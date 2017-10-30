<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('parent_wallets'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" 
        class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>

        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php?'.$this->session->userdata('login_type').'/dashboard');?>">
                    <?php echo get_phrase('Dashboard');?>
                </a>
            </li>

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
                    <li class="active" data-step="5" data-intro="<?php echo get_phrase('From here you can view the list of fee head');?>" data-position='right'>
                        <a href="#list" class="sticon fa fa-list"><span class="hidden-xs"><?php echo get_phrase('wallet_list'); ?></span></a>
                    </li>
                    <li data-step="6" data-intro="<?php echo get_phrase('From here you can add new fee head');?>" data-position='left'>
                        <a href="#add" class="sticon fa fa-plus-circle">
                            <span class="hidden-xs"><?php echo get_phrase('add_wallet'); ?></span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="content-wrap">     	
                <section id="list">  
                    <!--TABLE LISTING STARTS-->           
                    <table class= "custom_table table display" cellspacing="0" width="100%" id="dt_table">
                        <thead>
                            <tr>
                                <th><div><?php echo get_phrase('no'); ?></div></th>
                                <th><div><?php echo get_phrase('parent_name'); ?></div></th>
                                <th><div><?php echo get_phrase('wallet_amount'); ?></div></th>
                                <th><div><?php echo get_phrase('add_amount'); ?></div></th>
                                <th><div><?php echo get_phrase('adjust_amount'); ?></div></th>
                                <th><div><?php echo get_phrase('action'); ?></div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1;
                            foreach ($records as $rec): ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo $rec->parent_name; ?></td>
                                    <td><?php echo $rec->amount; ?></td>
                                    <td>
                                        <a href="javascript: void(0);" 
                                        onclick="showAjaxModal('<?php echo base_url('index.php?fees/main/wallet_add_amount/'.$rec->id);?>')">
                                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" 
                                                data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('add_amount')?>">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </a>
                                    </td>   
                                    <td>
                                        <a href="javascript: void(0);" 
                                        onclick="confirm_act('<?php echo base_url('index.php?fees/ajax/adjust_wallet_amount/'.$rec->id);?>')">
                                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" 
                                                data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('adjust_amount')?>">
                                                <i class="fa fa-money"></i>
                                            </button>
                                        </a>
                                    </td>  
                                    <td>
                                        <!-- <a href="javascript: void(0);" 
                                        onclick="showAjaxModal('<?php //echo base_url('index.php?fees/main/wallet_edit/'.$rec->id);?>')">
                                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" 
                                                data-toggle="tooltip" data-placement="top" data-original-title="<?php //echo get_phrase('edit')?>">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </button>
                                        </a> -->

                                        <a href="javascript: void(0);" 
                                        onclick="showAjaxModal('<?php echo base_url('index.php?fees/main/wallet_transactions/'.$rec->id);?>')">
                                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" 
                                                data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('wallet_transactions')?>">
                                                <i class="fa fa-bars"></i>
                                            </button>
                                         </a>
                                         <?php if($rec->in_trans>0 || $rec->in_trans_rec>0){?>
                                            <a href="#">
                                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" disabled
                                                    data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('disabled')?>">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </a>
                                         <?php }else{?>
                                            <a href="javascript:void(0)" onclick="confirm_act('<?php echo base_url('index.php?fees/main/wallet_delete/'.$rec->id);?>')">
                                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger"
                                                data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
                                            </a>
                                         <?php }?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </section>
                <!--TABLE LISTING ENDS-->

                <!--CREATION FORM STARTS-->
                <section id="add">  
                    <?php echo form_open(base_url('index.php?fees/main/wallets#add'), array('class' => 'form-horizontal form-groups-bordered validate', 
                    'target' => '_top')); ?>
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="running_session"><?php echo get_phrase('current_session'); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                                <select name="user_id" class="selectpicker" data-style="form-control" data-live-search="true">
                                    <option value=""><?php echo get_phrase('select_parent');?></option>
                                    <?php foreach($parents as $par){?>
                                        <option value="<?php echo $par->parent_id?>" <?php echo $par->parent_id==set_value('parent_id')?'selected':'';?>>
                                            <?php echo $par->father_name.' '.$par->father_lname?>
                                        </option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br/>

                    <!-- <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php //echo get_phrase('wallet_amount'); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-book"></i></div>
                                <input type="number" class="form-control" name="amount" value="<?php //echo set_value('amount')?>"/>
                            </div> 
                        </div>
                    </div>
                    <br> -->

                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('wallet_description'); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-book"></i></div>
                                <input type="text" class="form-control" name="description" value="<?php echo set_value('description')?>"/>
                            </div> 
                        </div>
                    </div>
                    <br>

                    <div class="form-group">
                        <div class="text-right">
                            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit');?></button>
                        </div>
                    </div>
                   <?php echo form_close()?>   
                </section>                
            </div>
        </div>
    </div>
</div>
<script>
$(function(){
    $('#dt_table').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2]
                }
            },
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2]
                },
                customize: function (doc) {
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                }
            }
        ],
        columnDefs: [{ orderable: false, targets:-1 }],
        order: [[ 0, 'asc' ]]
    });
});
</script>