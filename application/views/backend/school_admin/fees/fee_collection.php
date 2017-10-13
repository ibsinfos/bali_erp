<link rel="stylesheet" href="<?php echo base_url('assets/bower_components/select2/dist/css/select2.min.css')?>"/>
<style type="text/css">
    #ex tr td div{bacfdkground-color: lightgray; padding: 15px 15px; colfdor: #000;}
    thead th {font-weight:bold;}
    .pay-box{padding:10px;border:1px solid #ccc;}
</style>
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title);?></h4> </div>

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
    <!-- /.page title -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-md-12 white-box">
        <div class="row"> 
            <form method="post" id="collection-form">
                <input type="hidden" name="fee_type"/>
                <div class="col-md-8 col-md-offset-2">
                    <div class="pay-box">
                        <div class="row">
                            <div class="col-md-3 pull-right">
                                <label for="field-1"><?php echo get_phrase('date'); ?></label>
                                <input class="form-control input-sm" type="text" name="date" value="<?php echo date('Y/m/d') ?>" readonly/>
                            </div>    
                            <div class="col-md-3 pull-right">
                                <label for="field-1"><?php echo get_phrase('academic_year'); ?></label>
                                <input class="form-control input-sm" type="text" name="runnin_year" value="<?php echo fetch_parl_key_rec(false,'running_year')?>"
                                readonly/>
                            </div>    
                        </div>
                        <div class="row mt10">
                            <div class="col-md-2">
                                <label for="field-1"><?php echo get_phrase("student_status");?></label><br/>
                                <label><input type="radio" name="student_status" value="1" checked="checked"/> Enroll</label>
                                <label><input type="radio" name="student_status" value="2"/> Enquired</label>           
                            </div>  

                            <div class="col-md-3 class-select-box">
                                <label><?php echo get_phrase('class')?></label>        
                                <select name="class_id" class="selectpicker" data-style="form-control input-sm" data-live-search="true" data-title="<?php echo get_phrase('select_class')?>">
                                    <?php foreach($classes as $cls){?>        
                                        <option value="<?php echo $cls->class_id?>"><?php echo $cls->name?></option>
                                    <?php }?>    
                                </select>
                            </div> 

                            <div class="col-md-3">
                                <label><?php echo get_phrase('student')?></label>        
                                <select name="student_id" class="selectpicker" data-style="form-control input-sm" data-live-search="true" data-title="<?php echo get_phrase('select_student')?>"> 
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label><?php echo get_phrase('Fees')?></label>        
                                <select name="fee" class="selectpicker" data-style="form-control input-sm" data-live-search="true" data-title="<?php echo get_phrase('select_fee')?>"> 
                                </select>
                            </div>      
                        </div>                

                        <div class="row mt10 dis-none show-detail-box">
                            <div class="col-md-12">
                                <h3 class="bg-primary text-center"><?php echo get_phrase('Student Detail')?></h3>       
                                <table class="table no-padding stu-detail">
                                    <thead>
                                        <tr>
                                            <th><?php echo get_phrase('enroll_code'); ?></th>
                                            <th><?php echo get_phrase('student_name'); ?></th>
                                            <th><?php echo get_phrase('class'); ?></th>
                                            <th class="text-right"><?php echo get_phrase('date_of_joining'); ?></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    </tbody>
                                </table>
                                
                                <div class="row fee-detail-box dis-none">
                                    <div class="col-md-12">
                                        <h3 class="bg-primary text-center"><?php echo get_phrase('Fee Detail')?></h3>  
                                        <div class="fee-detail">
                                        </div>
                                    </div>
                                </div>

                                <div id="pay-detail" class="dis-none">
                                         
                                </div>     
                            </div>
                        </div> 
                            
                        <div id="payment-trans" class="dis-none">
                            <div class="row mt5">
                                <div class="col-md-12">
                                    <h3>Payment Transactions</h3>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <th>Receipt No.</th>  
                                            <th>Payment Date</th> 
                                            <th>Payment Mode</th>
                                            <th>Payment Notes</th>
                                            <th>Cashier</th>    
                                            <th>Amount</th>               
                                        </thead>
                                        <tbody>             
                                        </tbody>
                                    </table>
                                </div>                    
                            </div>                 
                        </div>               
                    </div>                
                </div>
            </form>    
        </div>
    </div>
</div>

<!-- Modal -->
<div id="head-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Head</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-3">Name</div>
            <div class="col-md-9">
                <input type="text" class="form-control input-sm" id="name"/>                            
            </div>                                
        </div>
        <div class="row mt5">
            <div class="col-md-3">Amount</div>
            <div class="col-md-9">
                <input type="number" class="form-control input-sm" id="amount" autocomplete="off"/>                            
            </div>                                
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-defaultn save-head">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Concession Modal -->
<div id="concess-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Concesion</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-3">Name</div>
            <div class="col-md-9">
                <input type="text" class="form-control input-sm" id="name"/>                            
            </div>                                
        </div>
        
        <div class="row mt10">
            <div class="col-md-3">Type</div>
            <div class="col-md-9">
                <label><input type="radio" name="type" value="1" checked/> Fix <label>
                <label><input type="radio" name="type" value="2"/> Percentage <label>
            </div>                                
        </div>
        <div class="row">
            <div class="col-md-3">Amount</div>
            <div class="col-md-9">
                <input type="number" class="form-control input-sm" id="amount"/>                            
            </div>                                
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-defaultn save-concess">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div id="fine-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Fine</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-3">Name</div>
            <div class="col-md-9">
                <input type="text" class="form-control input-sm" id="name"/>                            
            </div>                                
        </div>
        <div class="row mt5">
            <div class="col-md-3">Amount</div>
            <div class="col-md-9">
                <input type="number" class="form-control input-sm" id="amount"/>                            
            </div>                                
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-defaultn save-fine">Save</button>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url('assets/bower_components/select2/dist/js/select2.full.min.js')?>"></script>
<script>
$(function(){
    <?php if(fi_collection_closed()){?>
        $('input[name=student_status]').attr('disabled','disabled');
        $('select[name=class_id]').attr('disabled','disabled');
        $('select[name=student_id]').attr('disabled','disabled');
        $('select[name=fee]').attr('disabled','disabled');
        swal('Error','Fee Collection Closed for today!','error');
    <?php }?>
});
function resetFeeDetail(){
    $('select[name=fee]').val('');
    $('.fee-detail-box').find('.fee-detail').html('');
    $('.fee-detail-box').hide();
    $('#payment-trans').hide();
    $('#payment-trans').find('tbody').html('');
}
function resetStuDetail(){
    $('select[name=fee],.stu-detail tbody').html('');
    $('.fee-detail-box').find('.fee-detail').html('');
    $('.fee-detail-box').hide();
    $('#payment-trans').hide();
    $('#payment-trans').find('tbody').html('');
}
function resetPayDetail(){
    $('#pay-detail').show();
    $('#pay-detail').find('input,select,textarea').val('');
    $('#payment-trans').hide();
    $('#payment-trans').find('tbody').html('');
}
function activateDatepicker(){
    $('.dtp').datepicker({
        autoClose:true,
        format:'yyyy-mm-dd'
    });
}

$('input[name=student_status]').change(function(event){
    $('.show-detail-box').hide();
    if(this.value==1){
        $('.class-select-box').show();
        $('select[name=student_id]').html('');
        $('select[name=fee]').html('');
        $('select[name=student_id],select[name=fee]').selectpicker('refresh');
        resetStuDetail();
    }else{
        $('.class-select-box').hide();
        $('body').loading('start');

        stuSts = this.value;
        $.ajax({
            type:'post',
            url: '<?php echo base_url('index.php?fees/ajax/get_students')?>',
            data: {student_status:stuSts},
            dataType: 'json',
            success:function(res){
                //console.log(res);
                $('body').loading('stop');
                $('select[name=student_id]').html('');
                resetStuDetail();
                resetPayDetail();
                $('#pay-detail').hide();
                if(res.status=='success'){
                    $('select[name=student_id]').html(res.html);
                    $('select[name=fee]').html(res.fees_html);
                    $('select[name=student_id] option:eq(0)').remove();
                    $('select[name=student_id],select[name=fee]').selectpicker('refresh');
                }    
            }    
        });    
    }
});

/* $('select[name=class_id]')
.select2({placeholder: 'Select Class'})
.on('select2:select', function (evt) {
    $('body').loading('start');

    stuSts = $('input[name=student_status]:checked').val();
    class_id = $('select[name=class_id]').val();

    $.ajax({
        type:'post',
        url: '<?php //echo base_url('index.php?fees/ajax/get_students')?>',
        data: {student_status:stuSts,class_id:class_id},
        dataType: 'json',
        success:function(res){
           $('body').loading('stop');

            //console.log(res);
            $('select[name=student_id]').html('');
            resetStuDetail();
            resetPayDetail();
            if(res.status=='success'){
                $('select[name=student_id]').html(res.html);
            }    
        }    
    });    
}); */

$(document).on('change','select[name=class_id]',function(){
    $('body').loading('start');

    $('.show-detail-box').hide();
    stuSts = $('input[name=student_status]:checked').val();
    class_id = $('select[name=class_id]').val();
    $.ajax({
        type:'post',
        url: '<?php echo base_url('index.php?fees/ajax/get_students')?>',
        data: {student_status:stuSts,class_id:class_id},
        dataType: 'json',
        success:function(res){
            $('body').loading('stop');
            $('select[name=student_id]').html('');
            resetStuDetail();
            resetPayDetail();
            $('#pay-detail').hide();
            if(res.status=='success'){
                $('select[name=student_id]').html(res.html);
                $('select[name=student_id] option:eq(0)').remove();
            }    
            $('select[name=student_id]').selectpicker('refresh');
        }    
    });    
});

$(document).on('change','select[name=student_id]',function(){
    resetFeeDetail();
    $('body').loading('start');

    stuSts = $('input[name=student_status]:checked').val();
    student_id = $('select[name=student_id] option:selected').val();

    $.ajax({
        type:'post',
        url: '<?php echo base_url('index.php?fees/ajax/get_student_fees')?>',
        data: {student_status:stuSts,student_id:student_id},
        dataType: 'json',
        success:function(res){
            $('body').loading('stop');
            //console.log(res);
            $('.show-detail-box').show();
            $('select[name=fee]').html(res.html);
            $('select[name=fee] option:eq(0)').remove();
            $('select[name=fee]').selectpicker('refresh');
            $('.stu-detail').find('tbody').html(res.stu_detail_html);
            resetPayDetail();
            $('#pay-detail').hide();
            if(res.status=='success'){
            }else if(res.status=='error'){
                swal('Error',res.msg,'error');
            }   
        }    
    });   
});

$(document).on('change','select[name=fee]',function(){
    $opt = $(this);
    feeTotD = $('#fee-total');
    feeId = $opt.val();
    feeType = $('select[name=fee] option:selected').data('type');
    $('input[name=fee_type]').val(feeType);
    stuStatus = $('input[name=student_status]:checked').val();
    stuId = $('select[name=student_id] option:selected').val();
    
    $('body').loading('start');
    $.ajax({
        type:'post',
        url: '<?php echo base_url('index.php?fees/ajax/get_fee_detail')?>',
        data: {stu_status:stuStatus,student_id:stuId,fee_type:feeType,fee_id:feeId,ajax_request:1},
        dataType: 'json',
        success:function(res){
            $('body').loading('stop');
            //console.log(res);
            $('.fee-detail-box').show();
            $('.fee-detail').html(res.html);
            resetPayDetail();
            feeTotD.find('.net-paid').text(res.total_paid);
            feeTotD.find('.net-due').text(res.net_due);
            $('#pay-detail').html(res.pay_detail_html);
            if(res.paid==1){
                feeTotD.find('.net-due').closest('tr').hide();
                $('.add-cust-head').closest('tr').remove();
            }
            $('#payment-trans').show();
            $('#payment-trans').find('tbody').html(res.payment_trans_html);
            $('.selectpicker').selectpicker('refresh');
            activateDatepicker();    
            if(res.status=='error'){
                swal('Error',res.msg,'error');
            }   
        }    
    });
});

    
$(document).on('click','.save-head',function () {
    var $modal = $(this).closest('.modal'); 
    var name = $modal.find('#name').val();
    var amt = $modal.find('#amount').val();
    var headTotalIn = $('#head-total');
    var feeSummD = $('#fee-summary');
    var feeTotD = $('#fee-total');
    var block = $('#head-fees');
    var rows = block.find('tbody tr');
    var lastRow = rows.last();
    var newNum = parseInt(lastRow.data('num'))+1;

    html = '<tr data-num="'+newNum+'">\
                <td class="slabel"></td>\
                <td>'+name+' <strong>[Custom]</strong><a class="btn btn-danger btn-xs rmChead"\
                    onclick="confirm_act(false,false,true,this,\'tr\',rmChead)"><i class="fa fa-times"></i></a></td>\
                <td class="text-right amt-ele" data-amt="'+(parseFloat(amt).toFixed(2))+'">'
                    +(parseFloat(amt).toFixed(2))+'\
                    <input type="hidden" name="heads['+newNum+'][id]" value="custom"/>\
                    <input type="hidden" name="heads['+newNum+'][name]" value="'+name+'"/>\
                    <input type="hidden" name="heads['+newNum+'][amt]" value="'+amt+'"/>\
                </td>\
            </tr>';
    $('#head-fees').find('tbody').append(html);   

    //Calculating Total Amt
    calcTotal();
    /* var rows = block.find('tbody tr');
    totalHeadAmt = 0;
    $.each(rows,function(i,o){
        $(o).find('.slabel').text((i+1));
        totalHeadAmt += parseFloat($(o).find('.amt-ele').data('amt'));
    });
    headTotalIn.val(totalHeadAmt);
    feeSummD.find('.total-amt').text(totalHeadAmt);
    
    var concessTotal = parseFloat($('#concession-total').val());
    var fineTotal = parseFloat($('#fine-total').val());
    feeTotD.find('.net-amt').text((totalHeadAmt+fineTotal)-concessTotal);
    feeTotD.find('.net-due').text((totalHeadAmt+fineTotal)-concessTotal); */

    //Modal Delete
    $modal.modal('hide'); 
    $modal.find('input').val('');   
});

function calcTotal(){
    //Calculating Total Amt
    var headTotalIn = $('#head-total');
    var concessTotalIn = $('#concession-total');
    var fineTotalIn = $('#fine-total');
    var feeSummD = $('#fee-summary');
    var feeTotD = $('#fee-total');
    var block = $('#head-fees');
    var rows = block.find('tbody tr');
    var concess_block = $('#fee-concessions');
    var fine_block = $('#fee-fines');
    totalHeadAmt = 0;
    $.each(rows,function(i,o){
        $(o).find('.slabel').text((i+1));
        totalHeadAmt += parseFloat($(o).find('.amt-ele').data('amt'));
    });
    headTotalIn.val(totalHeadAmt);
    feeSummD.find('.total-amt').text(totalHeadAmt);
    
    //Concess Calc  
    totalConcessAmt = 0;
    $.each(concess_block.find('tbody tr'),function(i,o){
        num = $(this).data('num');
        type = $(this).data('type');
        val = parseFloat($(this).data('val'));
        amt = type==1?val:parseFloat((totalHeadAmt*val)/100).toFixed(2);
        amt = parseFloat(amt);
        totalConcessAmt += parseFloat(amt);
        /* console.log(num);
        console.log( $(o).find('.amt-ele').find('span').html());
        console.log( $(o).find('.amt-ele').find('concessions['+num+'][amt]').val()); */
        $(o).find('.amt-ele').find('span').text(amt);
        $(o).find('.amt-ele').find('.item-amt').val(amt);
    });
    //console.log('12'+concessTotalIn.val())
    concessTotalIn.val(totalConcessAmt);
    feeSummD.find('.total-concession').text(totalConcessAmt);
    
    //Fine Calc  
    totalFineAmt = 0;
    $.each(fine_block.find('tbody tr'),function(i,o){
        num = $(this).data('num');
        type = $(this).data('type');
        val = parseFloat($(this).data('val'));
        amt = type==1?val:parseFloat((totalHeadAmt*val)/100).toFixed(2);
        amt = parseFloat(amt);
        totalFineAmt += amt;
        /* console.log(totalFineAmt);
        console.log( $(o).find('.amt-ele').html());
        console.log( $(o).find('.amt-ele').find('span').html()); */
        $(o).find('.amt-ele').find('span').text(amt);
        $(o).find('.amt-ele').find('.item-amt').val(amt);
    });
    fineTotalIn.val(totalFineAmt);
    feeSummD.find('.total-fine').text(totalFineAmt);

    var concessTotal = parseFloat(concessTotalIn.val());
    var fineTotal = parseFloat(fineTotalIn.val());
    netAmt = (totalHeadAmt+fineTotal)-concessTotal;
    feeTotD.find('.net-amt').text(netAmt);
    feeTotD.find('.net-due').text(netAmt);
}

function rmChead(obj){
    calcTotal();
}


/* $(document).on('click','.save-concess',function () {
    var $modal = $(this).closest('.modal'); 
    var headTotal = parseFloat($('#head-total').val());

    var name = $modal.find('#name').val();
    var type = $modal.find('input[name=type]:checked').val();
    var amt = $modal.find('#amount').val();
    var prsAmt = parseFloat(amt).toFixed(2);
    var actAmt = type==1?prsAmt:Math.round((headTotal*prsAmt)/100,2);
    
    var block = $('#fee-concessions');
    var rows = block.find('tbody tr');
    var lastRow = rows.last();
    console.log(lastRow.data('num'));
    var newNum = parseInt(lastRow.data('num'))+1;

    html = '<tr data-num="'+newNum+'">\
                <td></td>\
                <td>'+name+(type==2?('['+prsAmt+'%]'):'')+' <strong>[Custom]</strong></td>\
                <td class="text-right amt-ele" data-amt="'+actAmt+'">'
                    +actAmt+'\
                    <input type="hidden" name="concessions['+newNum+'][id]" value="custom"/>\
                    <input type="hidden" name="concessions['+newNum+'][amt]" value="'+actAmt+'"/>\
                </td>\
            </tr>';
    block.find('tbody').append(html);   

    //Calculating Total Amt
    var rows = block.find('tbody tr');
    totalAmt = 0;
    $.each(rows,function(i,o){
        //console.log($(o).find('.amt-ele').html());
        totalAmt += parseFloat($(o).find('.amt-ele').data('amt'));
    });
    $('#concession-total').val(totalAmt);
    $modal.modal('hide');    
    $modal.find('input').val('');
});

$(document).on('click','.save-fine',function () {
    var $modal = $(this).closest('.modal'); 
    var name = $modal.find('#name').val();
    var amt = $modal.find('#amount').val();
    var block = $('#fee-fines');
    var rows = block.find('tbody tr');
    var lastRow = rows.last();
    var newNum = parseInt(lastRow.data('num'))+1;

    html = '<tr data-num="'+newNum+'">\
                <td></td>\
                <td>'+name+' <strong>[Custom]</strong></td>\
                <td class="text-right amt-ele" data-amt="'+(parseFloat(amt).toFixed(2))+'">'
                    +(parseFloat(amt).toFixed(2))+'\
                    <input type="hidden" name="fines['+newNum+'][id]" value="custom"/>\
                    <input type="hidden" name="fines['+newNum+'][amt]" value="'+amt+'"/>\
                </td>\
            </tr>';
    block.find('tbody').append(html);   

    //Calculating Total Amt
    var rows = block.find('tbody tr');
    totalHeadAmt = 0;
    $.each(rows,function(i,o){
        //console.log($(o).find('.amt-ele').html());
        totalHeadAmt += parseFloat($(o).find('.amt-ele').data('amt'));
    });
    $('#fine-total').val(totalHeadAmt);
    $modal.modal('hide');    
}); */

/* $(document).on('change','select[name=pay_mode]',function (e) {
    pval = parseInt(this.value);
    console.log(pval);
    if(pval==1){
        $('#cash_data').show();
        $('#card_options,#transcation_details,#cheque_data').hide();
    }else if(pval==2){
        $('#card_options').show();
        $('#transcation_details,#cheque_data,#cash_data').hide();
    }else if(pval==3){
        //console.log(112);
        $('#transcation_details').show();
        $('#card_options,#cheque_data,#cash_data').hide();
    }else if(pval==4){
        $('#cheque_data').show();
        $('#card_options,#transcation_details,#cash_data').hide();
    }
}); */

$(document).on('click','.paynow',function(event){
    stuStatus = $('input[name=student_status]:checked').val();
    stuId = $('select[name=student_id] option:selected').val();
    feeId = $('select[name=fee] option:selected').val();
    feeType = $('input[name=fee_type]').data('type');
    feeTotD = $('#fee-total');
    payMethod = $('select[name=pay_mode] option:selected').val();
    refNo = $('input[name=ref_no]').val();
    payAmt = parseFloat($('input[name=pay_amount]').val());
    payDate = $('input[name=pay_date]').val();
    note = $('textarea[name=note]').val();
    netDue = parseFloat($('#fee-total').find('.net-due').text()).toFixed(2);

    if(stuId==''){
        swal('Error','Please Select Student','error');
        return false;
    }
    if(feeId==''){
        swal('Error','Please Select Fee to pay','error');
        return false;
    }
    if(payMethod==''){
        swal('Error','Please Select Payment Method','error');
        return false;
    }
    if(0){
        swal('Error','Please fill reference no.','error');
        return false;
    }
    if(payDate==''){
        swal('Error','Please select payment date','error');
        return false;
    }
    if(payAmt<1){
        swal('Error','Please fill amount to pay','error');
        return false;
    }
    if(payAmt > netDue){
        swal('Error','Pay Amount cannot be greater than Net due','error');
        $('input[name=pay_amount]').val(netDue);
        return false;
    }

    $('body').loading('start');
    formData = $('form[id=collection-form]').serializeArray();
    formData.push({name:'ajax_request',value:1});
    $.ajax({
        type:'post',
        url: '<?php echo base_url('index.php?fees/ajax/pay_capture')?>',
        data: formData,
        dataType: 'json',
        success:function(res){
            $('body').loading('stop');
            if(res.status=='success'){
                resetPayDetail();
                $('#payment-trans').show();
                $('#payment-trans').find('tbody').html(res.payment_trans_html);
                feeTotD.find('.net-paid').text(res.total_paid);
                feeTotD.find('.net-due').text(res.net_due);
                if(res.paid==1){
                    $('#pay-detail').hide();
                    $('#print-detail').show();
                    feeTotD.find('.net-due').closest('tr').hide();
                    $('.add-cust-head').closest('tr').remove();
                }
                swal('Success',res.msg,'success');
            }else{
                swal('Error',res.msg,'error');
            }
        }    
    });    
});
</script>