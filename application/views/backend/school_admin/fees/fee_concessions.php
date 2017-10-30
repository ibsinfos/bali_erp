<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('fee_concessions'); ?> </h4></div>
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
                    <li class="active" data-step="5" data-intro="<?php echo get_phrase('From here you can view list of concessions');?>" data-position='right'>
                        <a href="#list" class="sticon fa fa-list"><span class="hidden-xs"><?php echo get_phrase('concessions_list'); ?></span></a>
                    </li>
                    <li data-step="6" data-intro="<?php echo get_phrase('From here you can add new concession type');?>" data-position='right'>
                        <a href="#add" class="sticon fa fa-plus-circle">
                            <span class="hidden-xs"><?php echo get_phrase('add_concession'); ?></span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="content-wrap">     	
                <section id="list">  
                    <!--TABLE LISTING STARTS-->           
                    <table class="custom_table table display" cellspacing="0" width="100%" id="dt_table">
                        <thead>
                            <tr>
                                <th><div><?php echo get_phrase('no');?></div></th>
                                <th><div><?php echo get_phrase('concession_type');?></div></th>
                                <th><div><?php echo get_phrase('concession_name');?></div></th>
                                <th><div><?php echo get_phrase('amount');?></div></th>
                                <th><div><?php echo get_phrase('discount_on');?></div></th>
                                <th><div><?php echo get_phrase('action');?></div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1;
                            foreach ($records as $rec):?>
                            <tr>
                                <td><?php echo $count++;?></td>
                                <td><?php 
                                    if($rec->type==1)
                                        echo get_phrase('fee_groups');
                                    else if($rec->type==2)
                                        echo get_phrase('classes');
                                    else if($rec->type==3)
                                        echo get_phrase('students');?>
                                </td>
                                <td><?php echo $rec->name;?></td>
                                <td><?php echo $rec->amount.($rec->amt_type==2?'%':'');?></td>
                                <td><?php 
                                    if($rec->discount_on==1)
                                        echo get_phrase('school_fee');
                                    else if($rec->discount_on==2)
                                        echo get_phrase('hostel_fee');
                                    else if($rec->discount_on==3)
                                        echo get_phrase('transport_fee');?>
                                </td>
                                <td>
                                    <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url('index.php?fees/main/concession_assign/'.$rec->id);?>')">
                                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" 
                                            data-toggle="tooltip" data-placement="top" data-original-title="Assign Concession">
                                            <i class="fa fa-bars"></i>
                                        </button>
                                    </a>
                                    <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url('index.php?fees/main/concession_edit/'.$rec->id);?>')">
                                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" 
                                            data-toggle="tooltip" data-placement="top" data-original-title="Edit">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </button>
                                    </a>
                                    <a href="javascript:void(0)" onclick="confirm_act('<?php echo base_url('index.php?fees/main/concession_delete/'.$rec->id);?>')">
                                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" 
                                            data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </section>
                <!--TABLE LISTING ENDS-->

                <!--CREATION FORM STARTS-->
                <section id="add">  
                    <?php echo form_open(base_url('index.php?fees/main/concessions#add'), 
                        array('class'=>'form-horizontal form-groups-bordered validate', 'target'=>'_top')); ?>
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="running_session"><?php echo get_phrase('current_session'); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                                <input type="text" class="form-control" name="name" value="<?php echo $running_year?>" readonly/> 
                            </div>
                        </div>
                    </div>
                    <br/>

                    <!-- <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="running_session"><?php //echo get_phrase('fee_category'); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                                <select name="fee_category_id" class="form-control">
                                      <option value=""><?php //echo get_phrase('select_fee_category');?></option>
                                      <?php /*foreach($fee_categories as $fee_cat){?>
                                            <option value="<?php echo $fee_cat->cat_id?>" <?php echo $fee_cat->cat_id==set_value('fee_category_id')?'selected':'';?>>
                                                <?php echo $fee_cat->cat_name?>
                                            </option>
                                      <?php } */?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br/> -->

                    <!-- <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php //echo get_phrase('concession_type'); ?><span class="error mandatory">*</span></label>
                            <div>
                                <label class="radio-inline">
                                    <input type="radio" name="type" value="1" checked><?php //echo get_phrase('class');?>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="type" value="2"><?php //echo get_phrase('student');?>
                                </label>
                            </div>
                        </div> 
                    </div>
                    <br/> -->

                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('concession_type'); ?><span class="error mandatory">*</span></label>
                            <select name="type" class="selectpicker" data-style="form-control">
                                <option value=""><?php echo get_phrase('select_concession_type');?></option>
                                <option value="1" <?php echo set_value('type')==1?'selected':'';?>><?php echo get_phrase('fee_groups');?></option>
                                <option value="2" <?php echo set_value('type')==2?'selected':'';?>><?php echo get_phrase('classes');?></option>
                                <option value="3" <?php echo set_value('type')==3?'selected':'';?>><?php echo get_phrase('students');?></option>
                            </select>
                        </div> 
                    </div>
                    <br/>

                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('concession_name'); ?><span class="error mandatory">*</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-road"></i></div>
                                <input type="text" class="form-control" name="name" required="required" data-validate="required" 
                                data-message-required="<?php echo get_phrase('value_required'); ?>" value="<?php echo set_value('name')?>"/> 
                            </div>
                        </div> 
                    </div>
                    <br/>

                    <!-- <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php //echo get_phrase('concession_description'); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-book"></i></div>
                                <input type="text" class="form-control" name="description" value="<?php //echo set_value('description')?>"/>
                            </div> 
                        </div>
                    </div>
                    <br> -->

                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('amount_type')?><span class="error mandatory">*</span></label>
                            <div>
                                <label class="radio-inline">
                                    <input type="radio" name="amt_type" value="1" checked><?php echo get_phrase('fix');?>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="amt_type" value="2"><?php echo get_phrase('percentage');?>
                                </label>
                            </div>
                        </div> 
                    </div>
                    <br/>

                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('amount')?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-book"></i></div>
                                <input type="text" class="form-control" name="amount" value="<?php echo set_value('amount')?>"/>
                            </div> 
                        </div>
                    </div>
                    <br>
                    
                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('discount_on')?><span class="error mandatory">*</span></label>
                            <select name="discount_on" class="selectpicker" data-style="form-control" data-container="body">
                                <option value=""><?php echo get_phrase('select_discount_on');?></option>
                                <option value="1" <?php echo set_value('type')==1?'selected':'';?>><?php echo get_phrase('school_fee');?></option>
                                <option value="2" <?php echo set_value('type')==2?'selected':'';?>><?php echo get_phrase('hostel');?></option>
                                <option value="3" <?php echo set_value('type')==3?'selected':'';?>><?php echo get_phrase('transport');?></option>
                            </select>
                        </div> 
                    </div>
                    <br/>

                    <div class="row fee-heads" style="display:<?php echo set_value('type')==1?'':'none'?>">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('on_fee_head')?><span class="error mandatory">*</span></label>
                            <select name="fee_head_id" class="selectpicker" data-style="form-control" data-container="body">
                                <option value=""><?php echo get_phrase('select_fee_head');?></option>
                                <?php foreach($fee_heads as $fhead){?>
                                    <option value="1" <?php echo set_value('fee_head_id')==$fhead->id?'selected':'';?>><?php echo $fhead->name;?></option>
                                <?php }?>
                            </select>
                        </div> 
                    </div>
                    <br/>
                    
                    <div class="form-group">
                        <div class="text-right">
                            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('add_concession'); ?></button>
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
                    columns: [ 0, 1, 2, 4, 5]
                }
            },
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 4, 5]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 4, 5]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 4, 5]
                },
                customize: function (doc) {
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                }
            }
        ],
        columnDefs: [{ orderable: false, targets:-1 }],
        order: [[ 0, 'asc' ]]
    });

    $(document).on('change','select[name=discount_on]',function(){
        if(this.value==1){
            $('.fee-heads').show();
        }else{
            $('.fee-heads').hide();
            $('select[name=fee_head_id]').val('');
            $('select[name=fee_head_id]').selectpicker('refresh');
        }   
    });
});
</script>