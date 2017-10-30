<style>
.term-item{border:1px solid #ccc;padding:10px 20px;}
.mt5{margin-top:5px;}
</style>
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('fee_charge_setups'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>

        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php?');?><?php echo $this->session->userdata('login_type');?>/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>

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
                    <li class="active" data-step="5" data-intro="<?php echo get_phrase('from here You can see the lists of charges made');?>" data-position='right'>
                        <a href="#list" class="sticon fa fa-list"><span class="hidden-xs"><?php echo get_phrase('fee_charge_setups'); ?></span></a>
                    </li>
                    <li data-step="6" data-intro="<?php echo get_phrase('from here You can add new charge');?>" data-position='right'>
                        <a href="#add" class="sticon fa fa-plus-circle">
                            <span class="hidden-xs"><?php echo get_phrase('add_charge_setup'); ?></span>
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
                                <th><div><?php echo get_phrase('setup_name'); ?></div></th>
                                <th><div><?php echo get_phrase('fee_group'); ?></div></th>
                                <th><div><?php echo get_phrase('terms'); ?></div></th>
                                <th><div><?php echo get_phrase('action'); ?></div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1;
                            foreach ($records as $rec): ?>
                                <tr>
                                    <td><?php echo $count++;?></td>
                                    <td><?php echo $rec->name;?></td>
                                    <td><?php echo $rec->fee_group_name;?></td>
                                    <td><?php echo $rec->fee_term_name;?></td>
                                    <td>
                                        <a href="<?php echo base_url('index.php?fees/main/charge_setup_edit/'.$rec->id);?>">
                                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" 
                                                data-toggle="tooltip" data-placement="top" data-original-title="Edit">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </button>
                                         </a>
                                         <?php if($rec->trans){?>
                                            <a class="disabled">
                                                <button disabled type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" 
                                                data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
                                            </a>
                                         <?php }else{ ?>
                                            <a href="javascript:void(0)" onclick="confirm_act('<?php echo base_url('index.php?fees/main/charge_setup_delete/'.$rec->id);?>')">
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
                    <?php echo form_open(base_url('index.php?fees/main/charge_setup'), array('class'=>'form-horizontal form-groups-bordered validate', 
                    'target' => '_top','id'=>'form')); ?>
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-1 col-md-5">
                            <div class="row">
                                <div class="col-xs-12">
                                    <label for="running_session"><?php echo get_phrase("current_session"); ?></label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                                        <input type="text" class="form-control" name="running_year" value="<?php echo $running_year?>" readonly/>
                                    </div>
                                </div>
                            </div>
                            <br/>

                            <div class="row">          
                                <div class="col-xs-12">
                                    <label for="field-1"><?php echo get_phrase('setup_name'); ?><span class="error mandatory">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-road"></i></div>
                                        <input type="text" class="form-control" name="name" value="<?php echo set_value('name')?>" required="required"/> 
                                    </div>
                                </div> 
                            </div>
                            <br/>

                            <!-- <div class="row">          
                                <div class="col-xs-12">
                                    <label for="field-1"><?php //echo get_phrase('description'); ?></label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-book"></i></div>
                                        <input type="text" class="form-control" name="description" value="<?php //echo set_value('description')?>"/>
                                    </div> 
                                </div>
                            </div>
                            <br/> -->

                            <div class="row">
                                <div class="col-xs-12">
                                    <label><?php echo get_phrase('fee_group'); ?></label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                                        <select name="fee_group_id" class="form-control" data-style="" data-live-search="true">
                                            <option value=""><?php echo get_phrase('select_fee_group');?></option>
                                            <?php foreach($fee_groups as $grp){?>
                                                <option value="<?php echo $grp->id?>" <?php echo $grp->id==set_value('fee_group_id')?'selected':'';?>>
                                                    <?php echo $grp->name?>
                                                </option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br/>

                            <div class="row">
                                <div class="col-xs-12">
                                    <label><?php echo get_phrase('term'); ?></label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                                        <select name="fee_term_id" class="form-control" data-style="" data-live-search="true">
                                            <option value=""><?php echo get_phrase('select_term');?></option>
                                            <?php foreach($fee_terms as $fterm){
                                                    if(in_array($fterm->id,$school_term_setting)){?>
                                                <option value="<?php echo $fterm->id?>" <?php echo $fterm->id==set_value('fee_term_id')?'selected':'';?>>
                                                    <?php echo $fterm->name?>
                                                </option>
                                            <?php }}?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br/>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="total-head-amt">
                                    </div>
                                </div>
                            </div>
                            <br/>

                            <div class="row">          
                                <div class="col-xs-12">
                                    <a class="btn btn-success dis-none add-collection"><i class="fa fa-plus"></i> <?php echo get_phrase('Save Setup')?></a>
                                </div>
                            </div>
                            <br/>
                        </div>
                        <div class="col-xs-12 col-md-offset-1 col-md-5">
                            <div class="row">          
                                <div class="col-xs-12">
                                    <div class="fee-terms">
                                    </div>
                                    <div class="row setup-total dis-none">
                                        <div class="col-md-3"><label><strong>Net Amount</strong></label></div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control input-sm total-setup-amt" name="amount" placeholder="Total Fee Amount" readonly/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                        </div>
                    </div>

                    <div class="row">          
                        <div class="col-xs-12">
                            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d pull-right"><?php echo get_phrase('submit'); ?></button>
                        </div>
                    </div>    
                    
                   <?php echo form_close()?>   
                </section>                
            </div>
        </div>
    </div>
</div>
<div class="prtclrs" style="display:none"></div>
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
                    columns: [ 0, 1, 2, 3]
                }
            },
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
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
    
$(document).on('change','select[name=fee_group_id],select[name=fee_term_id]',function (e) {
    var fee_group_id    =  $('select[name=fee_group_id]').val();
    var fee_term_id    =  $('select[name=fee_term_id]').val();
    
    $.ajax({type:'post',  
            url: '<?php echo base_url('index.php?fees/main/ajax_get_fee_group_detail')?>', 
            data:{fee_group_id:fee_group_id,fee_term_id:fee_term_id},
            dataType:'json',
            success:function (res) {
                if(res.status=='success'){
                    $('.total-head-amt').html(res.head_total);
                    $('.fee-terms').html(res.html);
                    $('.total-setup-amt').val(res.net_amt);
                    $('.setup-total').show();
                    $('.dtp').datepicker({autoclose:true,format: 'yyyy-mm-dd',clearBtn: true});  
                    //$('.add-collection').show(); 
                }else{
                    $('.total-head-amt').html('');
                    $('.fee-terms').html('');
                    $('.total-setup-amt').val(0);
                    $('.setup-total').hide();
                    swal('Error',res.msg,'error');
                    //$.toast({text: res.msg, heading: res.status, icon: res.status});
                }
            }
        });
});

function termUP($obj){
    $.each($('.term-item'),function(t,ob){
        citem = $(ob);
        totalAmt = 0;
        $.each(citem.find('.head-amt'),function(i,o){
            totalAmt += o.value?parseInt(o.value):0;        
        });
        citem.find('.total-term-amt').val(totalAmt);
    })
    matchAmt();
}

function matchAmt(){
    netAmt = 0;    
    $.each($('.total-term-amt'),function(i,o){
        netAmt += this.value?parseInt(this.value):0;        
    });    
    $('.total-setup-amt').val(netAmt);
}

$(document).on('keyup change','.head-amt',function (e) {
    termUP(this);
});

$('#form').on('submit',function(event){
    termUP();

    $.each($('.term-item'),function(t,ob){
        citem = $(ob);
        $.each(citem.find('.head-amt'),function(i,o){
            hdAmt = o.value?parseInt(o.value):0;        
            if(hdAmt<=0){
                event.preventDefault();
                $(o).closest('.input-group').addClass('has-error');
                $(o).focus();
                swal('Error','Head amount must be greater than 0','error');
                return false;
            }else{
                $(o).closest('.input-group').removeClass('has-error');
            }
        });
    });

    summaryTotal = parseInt($('.summary-total').text());
    netAmt = parseInt($('.total-setup-amt').val());
    if(summaryTotal!=netAmt){
        event.preventDefault();
        swal('Error','Summary amount should match net amount','error');
        //$.toast({text: 'Summary amount should match net amount', heading: 'Error', icon: 'error'});
    }
});


/* var ci = 0;
$(document).on('click','.add-collection',function (e) {
    // swal(msg,'', message_type_str);
    table = $(this).closest('table');
    html = '<div class="collection-item" data-coll-num="'+ci+'">\
                <input type="hidden" name="collections['+ci+'][id]" value=""/>\
                <div class="row">\
                    <div class="col-md-12"><label><strong>Installment '+(ci+1)+'</strong></label></div>\
                </div>\
                <div class="row mt5">\
                    <div class="col-md-9 pull-right">\
                        <div class="input-group">\
                            <select id="particulars" class="selectpicker" data-style="form-control" data-live-search="true">\
                                <option value="">Add Particular</option>'
                                +$('.prtclrs').html()+
                            '</select>\
                            <span class="input-group-btn">\
                                <button type="button" class="btn btn-primary add-to-collection">Add</button>\
                            </span>\
                        </div>\
                    </div>\
                </div>\
                <div class="row mt5">\
                    <div class="col-md-3"><label><strong>Name</strong></label></div>\
                    <div class="col-md-9">\
                        <input type="text" class="form-control" name="collections['+ci+'][name]" placeholder="Collection Name"/>\
                    </div>\
                </div>\
                <div class="row mt5">\
                    <div class="col-md-3"><label><strong>Start Date</strong></label></div>\
                    <div class="col-md-9">\
                        <input type="text" class="form-control dtp" name="collections['+ci+'][start_date]" placeholder="Start Date"/>\
                    </div>\
                </div>\
                <div class="row mt5">\
                    <div class="col-md-3"><label><strong>End Date</strong></label></div>\
                    <div class="col-md-9">\
                        <input type="text" class="form-control dtp" name="collections['+ci+'][end_date]" placeholder="End Date"/>\
                    </div>\
                </div>\
                <div class="row mt5">\
                    <div class="col-md-3"><label><strong>Fine</strong></label></div>\
                    <div class="col-md-9">\
                        <select  class="selectpicker" data-style="form-control" data-live-search="true">\
                            <option value="">Select Fine</option>\
                            <?php foreach($fines as $fine){?>
                                <option value="<?php echo $fine->id?>"><?php echo $fine->name?></option>\
                            <?php }?>
                        </select>\
                    </div>\
                </div>\
                <div class="row mt5 total-row">\
                    <div class="col-md-3"><label><strong>Total</strong></label></div>\
                    <div class="col-md-9">\
                        <input type="text" class="form-control total-collection-amt" name="collections['+ci+'][amount]" placeholder="Total Amount" readonly/>\
                    </div>\
                </div>\
            </div><br/>';
    $('.fee-collections').append(html); 
    $('.dtp').datepicker({autoclose:true,
                            format: 'yyyy-mm-dd',
                            clearBtn: true});  
    ci++;                        
});

$(document).on('click','.add-to-collection',function (e) {
    // swal(msg,'', message_type_str);

    citem = $(this).closest('.collection-item');
    last_row = citem.find('.total-row');
    sbox = citem.find('#particulars');
    opt =  sbox.find('option:selected'); 
    if(opt.val()==''){
        $.toast({
            text: 'Please select a particular', // Text that is to be shown in the toast
            heading: 'Error', // Optional heading to be shown on the toast
            icon: 'error', // Type of toast icon
        });
    }else{
        totalAmt = 0;
        $.each(citem.find('.parti-rw'),function(i,o){
            totalAmt += parseFloat($(o).find('.parti-item').val());        
        });
 
        if(citem.find('.parti-rw[data-id='+opt.val()+']').length>0)
            return false; 
        html ='<div class="row mt5 parti-rw" data-id="'+opt.val()+'">\
                    <div class="col-md-3">\
                        <label><strong>'+opt.text()+'</strong></label>\
                    </div>\
                    <div class="col-md-9">\
                        <input type="text" class="form-control parti-item" placeholder="Amount" \
                        name="collections['+citem.data('coll-num')+'][particulars]['+opt.val()+']"/>\
                    </div>\
                </div>';
        last_row.before(html);
        sbox.val('');
    }
});

$(document).on('click','#save_insta',function (e) {
    var totalAmt = 0;
    if($('.total-item-amt').length>0){
        var totalAmt = $('.total-item-amt').data('amt');    
    }
    netPayable = parseInt($('.net-payable').text());
    $("#emsg").hide("slow");
    if(totalAmt==0 || netPayable!=totalAmt){
        $("#emsg").removeClass('alert-success').addClass('alert-danger');
        $("#emsg").html('Amount not matched!');
        $("#emsg").show("slow");
        return false;
    }
    
    $('#ibox_form').block({ message: null });
    var _url        =   $("#_url").val(); 
    var insta_amounts = $("input[name='amounts\\[\\]']")
            .map(function(){return $(this).val();}).get();
    var id    =   $('#fee_set_id').val();
    
    $.ajax({type:'post',  
            url: _url + 'ps/save-fee-insta/', 
            data:$("#insta-form").serialize(),
            dataType:'json',
            success:function (data) {
                $('#ibox_form').unblock();
                $("#emsg").removeClass('alert-danger').addClass('alert-success');
                $("#emsg").html(data.msg);
                $("#emsg").show("slow");
            }
        });
});  */
</script>