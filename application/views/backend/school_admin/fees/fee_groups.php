<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('fee_groups'); ?> </h4></div>
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
                    <li class="active"  data-step="5" data-intro="<?php echo get_phrase('from here You can seee the list of fees made');?>" data-position='roght'>
                        <a href="#list" class="sticon fa fa-list"><span class="hidden-xs"><?php echo get_phrase('group_list'); ?></span></a>
                    </li>
                    <li  data-step="6" data-intro="<?php echo get_phrase('from here You can add new fee group');?>" data-position='left'>
                        <a href="#add" class="sticon fa fa-plus-circle">
                            <span class="hidden-xs"><?php echo get_phrase('add_fee_group'); ?></span>
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
                                <th><div><?php echo get_phrase('group_name'); ?></div></th>
                                <th><div><?php echo get_phrase('description'); ?></div></th>
                                <th><div><?php echo get_phrase('action'); ?></div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1;
                            foreach ($records as $rec): ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo $rec->name; ?></td>
                                    <td><?php echo $rec->description; ?></td>
                                    <td>
                                        <a href="<?php echo base_url('index.php?fees/main/group_edit/'.$rec->id);?>">
                                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" 
                                                data-toggle="tooltip" data-placement="top" data-original-title="Edit">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </button>
                                         </a>
                                         <?php if($rec->in_setups > 0){?>
                                            <a class="disabled">
                                                <button disabled type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger"disabled
                                                data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('disabled')?>">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </a>
                                         <?php }else{ ?>
                                            <a href="javascript:void(0)" onclick="confirm_act('<?php echo base_url('index.php?fees/main/group_delete/'.$rec->id);?>')">
                                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
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
                    <?php echo form_open(base_url('index.php?fees/main/groups#add'), array('class' => 'form-horizontal form-groups-bordered validate', 
                    'target' => '_top','id'=>'add-form')); ?>
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="running_session"><?php echo get_phrase("running_session"); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                                <input type="text" class="form-control" name="name" value="<?php echo $running_year?>" readonly/> 
                            </div>
                        </div>
                    </div>
                    <br/>

                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('group_name');?><span class="error mandatory">*</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-road"></i></div>
                                <input type="text" class="form-control" name="name" value="<?php echo set_value('name')?>" data-validate="required" 
                                data-message-required="<?php echo get_phrase('value_required');?>" required="required"/> 
                            </div>
                        </div> 
                    </div>
                    <br/>

                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><strong><?php echo get_phrase('select_heads');?></strong> <span class="error mandatory">*</span></label><br/>
                            <div class="row">
                                <div class="col-md-4"><strong><?php echo get_phrase('heads');?></strong></div>
                                <div class="col-md-4"><strong><?php echo get_phrase('head_amount');?></strong></div>
                                <div class="col-md-4 dis-none"><strong><?php echo get_phrase('head_tax');?></strong></div>
                            </div>
                            <?php foreach($heads as $head){?>
                            <div class="row fee-heads">  
                                <div class="col-xs-12 col-md-4">
                                    <label>
                                        <input type="checkbox" name="heads[]" class="chkbox" value="<?php echo $head->id?>"/>
                                        <span><?php echo $head->name?></span>
                                    </label>
                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <label>
                                        <input type="number" class="form-control input-sm head-amt" name="head_amount[<?php echo $head->id?>]" 
                                        placeholder="Head Amount" min="0" disabled/> 
                                    </label>
                                </div>
                                <div class="col-xs-12 col-md-4 dis-none">
                                    <label>
                                        <input type="text" class="form-control input-sm head-tax" name="head_tax[<?php echo $head->id?>]" 
                                        placeholder="Tax Percentage" disabled/> 
                                    </label>
                                </div>
                            </div>
                            <?php }?>
                        </div> 
                    </div>
                    <br/>

                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><strong><?php echo get_phrase('select_classes');?></strong> <span class="error mandatory">*</span></label><br/>
                            <div class="row">  
                                <?php foreach($classes as $cls){?>
                                    <div class="col-xs-12 col-md-4">
                                        <label>
                                            <input type="checkbox" name="classes[]" value="<?php echo $cls->class_id?>"/>
                                            <span><?php echo $cls->name?></span>
                                        </label><br/>
                                    </div>
                                <?php }?>
                            </div>
                        </div> 
                    </div>
                    <br/>

                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('description'); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-book"></i></div>
                                <input type="text" class="form-control" name="description" value="<?php echo set_value('description')?>"/>
                            </div> 
                        </div>
                    </div>
                    <br>

                    <div class="form-group">
                        <div class="text-right">
                            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit'); ?></button>
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

$('#add-form').submit(function(event){
    $.each($('.fee-heads'),function(){
        chkbox = $(this).find('.chkbox');
        headAmtField = $(this).find('.head-amt');
        if(chkbox.prop('checked') && parseFloat(headAmtField.val())<=0){
            headAmtField.focus();
            headName = chkbox.closest('label').find('span').text();
            swal('Error','Fill amount for '+headName,'error');
            event.preventDefault();
        }
    });
});

$('.chkbox').on('change',function(){
    row = $(this).closest('.row');
    if(this.checked){
        row.find('.head-amt').val('');
        row.find('.head-amt').removeAttr('disabled');
        row.find('.head-amt').attr('required','required');
    }else{
        row.find('.head-amt').val('');
        row.find('.head-amt').attr('disabled','disabled');
        row.find('.head-amt').removeAttr('required');
    }
});
</script>