<style>
.term-item{border:1px solid #ccc;padding:10px 20px;}
.mt5{margin-top:5px;}
</style>
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('fee_collection_group_edit'); ?> </h4>
    </div>
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
        <?php echo form_open(base_url('index.php?fees/main/charge_setup_edit/'.$record->id), array('class'=>'form-horizontal form-groups-bordered validate', 
        'target' => '_top','id'=>'form')); ?>
            <div class="row">
                <div class="col-xs-12 col-md-offset-1 col-md-5">
                    <div class="row">
                        <div class="col-xs-12">
                            <label for="running_session"><?php echo get_phrase("current_session"); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                                <input type="text" class="form-control" name="name" value="<?php echo $running_year?>" readonly/>
                            </div>
                        </div>
                    </div>
                    <br/>

                    <div class="row">          
                        <div class="col-xs-12">
                            <label for="field-1"><?php echo get_phrase('setup_name'); ?><span class="error mandatory">*</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-road"></i></div>
                                <input type="text" class="form-control" name="name" value="<?php echo set_value('name',$record->name)?>" required="required"/> 
                            </div>
                        </div> 
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-xs-12">
                            <label><?php echo get_phrase('fee_group'); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                                <select class="form-control" data-live-search="true" disabled>
                                    <option value=""><?php echo get_phrase('select_fee_group');?></option>
                                    <?php foreach($fee_groups as $grp){?>
                                        <option value="<?php echo $grp->id?>" <?php echo $grp->id==$record->fee_group_id?'selected':'';?>>
                                            <?php echo $grp->name?>
                                        </option>
                                    <?php }?>
                                </select>
                                <input type="hidden" name="fee_group_id" value="<?php echo $record->fee_group_id?>"/>
                            </div>
                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-xs-12">
                            <label><?php echo get_phrase('term'); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                                <select class="form-control" data-style="form-control" data-live-search="true" disabled>
                                    <option value=""><?php echo get_phrase('select_term');?></option>
                                    <?php foreach($fee_terms as $fterm){
                                            if(in_array($fterm->id,$school_term_setting)){?>
                                        <option value="<?php echo $fterm->id?>" <?php echo $fterm->id==$record->fee_term_id?'selected':'';?>>
                                            <?php echo $fterm->name?>
                                        </option>
                                    <?php }}?>
                                </select>
                                <input type="hidden" name="fee_term_id" value="<?php echo $record->fee_term_id?>"/>
                            </div>
                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="total-head-amt">
                                <div class="row">
                                    <div class="col-md-6"><strong>Fees Summary</strong></div>
                                </div>
                                <?php  $head_total = 0;
                                foreach($fee_grp_heads as $gr_head){
                                    $head_total += $gr_head->head_amount;
                                    echo '<div class="row">
                                            <div class="col-md-6"><strong>'.$gr_head->name.'</strong></div>
                                            <div class="col-md-6">'.$gr_head->head_amount.'</div>
                                          </div>';
                                }?>                       
                                <div class="row">
                                    <div class="col-md-6"><strong>Total</strong></div>
                                    <div class="col-md-6 summary-total"><?php echo $head_total?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <!-- <div class="row">          
                        <div class="col-xs-12">
                            <a class="btn btn-success add-collection"><i class="fa fa-plus"></i> <?php //echo get_phrase('Add Collection')?></a>
                        </div>
                    </div>c
                    <br/> -->
                </div>
                <div class="col-xs-12 col-md-offset-1 col-md-5">
                    <div class="row">          
                        <div class="col-xs-12">
                            <div class="fee-terms">
                                <?php foreach($terms as $ci=>$term){?>
                                    <div class="term-item" data-term-num="<?php echo $ci?>">
                                        <input type="hidden" name="terms[<?php echo $ci?>][id]" value="<?php echo $term->id?>"/>
                                        <div class="row">
                                            <div class="col-md-6"><h3>Term <?php echo $ci+1?></h3></div>
                                            <!-- <div class="col-md-6">
                                                <a class="btn btn-danger btn-sm pull-right remove-term"
                                                    onclick="confirm_act('<?php //echo base_url('index.php?fees/main/setup_term_delete/'.$term->id)?>',false,false,this,'.term-item')">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div> -->
                                        </div>
                                        <div class="row mt5">
                                            <div class="col-md-3"><label><strong>Name</strong></label></div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control input-sm" name="terms[<?php echo $ci?>][name]" placeholder="Collection Name" 
                                                required value="<?php echo $term->name?>"/>
                                            </div>
                                        </div>
                                        <div class="row mt5">
                                            <div class="col-md-3"><label><strong>Start Date</strong></label></div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control input-sm dtp" name="terms[<?php echo $ci?>][start_date]" 
                                                placeholder="Start Date" required value="<?php echo date('Y-m-d',strtotime($term->start_date))?>" />
                                            </div>
                                        </div>
                                        <div class="row mt5">
                                            <div class="col-md-3"><label><strong>End Date</strong></label></div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control input-sm dtp" name="terms[<?php echo $ci?>][end_date]" 
                                                placeholder="End Date" required value="<?php echo date('Y-m-d',strtotime($term->end_date))?>"/>
                                            </div>
                                        </div>
                                        <div class="row mt5">
                                            <div class="col-md-3"><label><strong>Fine</strong></label></div>
                                            <div class="col-md-9">
                                                <select class="form-control input-sm" data-live-search="true" name="terms[<?php echo $ci?>][fine_id]">
                                                    <option value="">Select Fine</option>
                                                    <?php foreach($fines as $fine){?>
                                                        <option value="<?php echo $fine->id?>" <?php echo $term->fine_id==$fine->id?'selected':''?>>
                                                            <?php echo $fine->name.' -- '.$fine->value.($fine->value_type==2?'%':'')?>
                                                        </option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                        <?php  $term_total = 0;
                                            //echo '<pre>';print_r($term->heads);
                                            foreach($term->heads as $trm_head){
                                                $term_total += $trm_head->amount;?>
                                            <div class="row mt5 head-row">
                                                <div class="col-md-3"><strong><?php echo $trm_head->name?></strong></div>
                                                <div class="col-md-9">
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" class="form-control input-sm head-amt" 
                                                        name="terms[<?php echo $ci?>][heads][<?php echo $trm_head->head_id?>]" 
                                                        placeholder="Head Amount" value="<?php echo $trm_head->amount?>"/>
                                                        <span class="input-group-btn input-group-sm">
                                                            <a class="btn btn-danger btn-xs remove-term"
                                                                onclick="confirm_act(false,false,true,this,'.head-row',termUP)">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }?>
                                        <div class="row mt5 total-row">
                                            <div class="col-md-3"><label><strong>Total</strong></label></div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control input-sm total-term-amt" name="terms[<?php echo $ci?>][amount]" 
                                                placeholder="Total Amount" value="<?php echo $term->amount?>" readonly/>
                                            </div>
                                        </div>
                                    </div><br/>
                                <?php }?>
                            </div>

                            <div class="row setup-total">
                                <div class="col-md-3"><label><strong>Net Amount</strong></label></div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control input-sm total-setup-amt" name="amount" value="<?php echo $record->amount?>"
                                    placeholder="Total Fee Amount" readonly/>
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
    </div>
</div>
<script>
$(function(){
    $('.dtp').datepicker({autoclose:true,format: 'yyyy-mm-dd',clearBtn: true});  
})

$(document).on('change','select[name=fee_group_id],select[name=fee_term_id]',function (e) {
    var fee_group_id    =  $('select[name=fee_group_id]').val();
    var fee_term_id    =  $('select[name=fee_term_id]').val();
    
    $.ajax({type:'post',  
            url: '<?php echo base_url('index.php?fees/main/ajax_get_fee_group_detail')?>', 
            data:{fee_group_id        :   fee_group_id,
                fee_term_id        :   fee_term_id},
            dataType:'json',
            success:function (res) {
                if(res.status=='success'){
                    $('.total-head-amt').html(res.head_total);
                    $('.fee-terms').html(res.html);
                    $('.dtp').datepicker({autoclose:true, format: 'yyyy-mm-dd',clearBtn: true});  
                    //$('.add-collection').show(); 
                }else{
                    swal('Error',res.msg,'error');
                }
            }
        });
});

function termUP(obj){
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
    //console.log(summaryTotal,netAmt);return false;
    if(summaryTotal!=netAmt){
        event.preventDefault();
        swal('Error','Summary amount should match net amount','error');
        //$.toast({text: 'Summary amount should match net amount', heading: 'Error', icon: 'error'});
    }
});


var ci = 0;
$(document).on('click','.add-collection',function (e) {
    // swal(msg,'', message_type_str);
    table = $(this).closest('table');
    html = '<div class="collection-item" data-coll-num="'+ci+'">\
                <input type="hidden" name="collections['+ci+'][id]" value=""/>\
                <div class="row">\
                    <div class="col-md-6"><label><strong>Installment '+(ci+1)+'</strong></label></div>\
                    <div class="col-md-6">\
                        <a class="btn btn-danger btn-xs pull-right remove-collection"\
                            onclick="confirm_act(false,false,true,this,\'.collection-item\')">\
                            <i class="fa fa-trash"></i>\
                        </a>\
                    </div>\
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
                        <select class="selectpicker input-sm" data-style="form-control" data-live-search="true">\
                            <option value="">Select Fine</option>\
                            <?php foreach($fines as $fine){?>
                                <option value="<?php echo $fine->id?>"><?php echo $fine->name?></option>\
                            <?php }?>
                        </select>\
                    </div>\
                </div>\
                <div class="row mt5 total-row">\
                    <div class="col-md-3">\
                        <label><strong>Total</strong></label>\
                    </div>\
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
    /* var insta_amounts = $("input[name='amounts\\[\\]']")
            .map(function(){return $(this).val();}).get(); */
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
});
</script>