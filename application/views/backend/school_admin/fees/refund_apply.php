    <style type="text/css">
    #ex tr td div{bacfdkground-color: lightgray; padding: 15px 15px; colfdor: #000;}
    thead th {font-weight:bold;}
    .pay-box{padding:10px;border:1px solid #ccc;}
</style>
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title);?></h4> </div>
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
                        <div class="row mt10">
                            <div class="col-md-4 class-select-box">
                                <label><strong><?php echo get_phrase('class')?></strong></label>        
                                <select name="class_id" class="selectpicker" data-style="form-control input-sm" data-live-search="true" 
                                        data-title="<?php echo get_phrase('select_class')?>">
                                    <?php foreach($classes as $cls){?>        
                                        <option value="<?php echo $cls->class_id?>"><?php echo $cls->name?></option>
                                    <?php }?>    
                                </select>
                            </div> 

                            <div class="col-md-4">
                                <label><strong><?php echo get_phrase('student')?></strong></label>        
                                <select name="student_id" class="selectpicker" data-style="form-control input-sm" data-live-search="true" 
                                        data-title="<?php echo get_phrase('select_student')?>"> 
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label><strong><?php echo get_phrase('Fees')?></strong></label>        
                                <select name="fee" class="selectpicker" data-style="form-control input-sm" data-live-search="true" 
                                        data-title="<?php echo get_phrase('select_fee')?>"> 
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
                                            <th class="text-right"><?php echo get_phrase('date_of_joining');?></th>
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

                                <div id="ajax-html">      
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
<div id="refund-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Refund Notes</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-3">Note</div>
            <div class="col-md-9">
                <textarea name="refund_note" class="form-control" rows="3"></textarea>                           
            </div>                                
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-defaultn submit-refund">Apply</button>
      </div>
    </div>
  </div>
</div>

<script>
function resetFeeDetail(){
    $('#print-detail').hide();
    $('select[name=fee]').val('');
    $('.fee-detail-box').find('.fee-detail').html('');
    $('.fee-detail-box').hide();
    $('#payment-trans').hide();
    $('#payment-trans').find('tbody').html('');
}
function resetStuDetail(){
    $('#print-detail').hide();
    $('select[name=fee],.stu-detail tbody').html('');
    $('.fee-detail-box').find('.fee-detail').html('');
    $('.fee-detail-box').hide();
    $('#payment-trans').hide();
    $('#payment-trans').find('tbody').html('');
}
function resetPayDetail(){
    $('#print-detail').hide();
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

$(document).on('change','select[name=class_id]',function(){
    $('body').loading('start');

    $('.show-detail-box').hide();
    class_id = $('select[name=class_id]').val();
    $.ajax({
        type:'post',
        url: '<?php echo base_url('index.php?fees/ajax/get_students')?>',
        data: {student_status:1,class_id:class_id},
        dataType: 'json',
        success:function(res){
            $('body').loading('stop');
            $('select[name=student_id]').html('');
            resetStuDetail();
            resetPayDetail();
            $('#ajax-html').html('');
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

    student_id = $('select[name=student_id] option:selected').val();
    $.ajax({
        type:'post',
        url: '<?php echo base_url('index.php?fees/refund/get_student_fees')?>',
        data: {student_status:1,student_id:student_id},
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
            $('#ajax-html').html('');
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
    stuId = $('select[name=student_id] option:selected').val();
    stuId = $('select[name=student_id] option:selected').val();
    
    $('body').loading('start');
    $.ajax({
        type:'post',
        url: '<?php echo base_url('index.php?fees/refund/get_paid_fee_detail')?>',
        data: {stu_status:1,student_id:stuId,fee_type:feeType,fee_id:feeId,ajax_request:1},
        dataType: 'json',
        success:function(res){
            //console.log(res);
            $('body').loading('stop');
            $('.add-cust-head').closest('tr').remove();
            $('.fee-detail').html(res.html); 
            resetPayDetail();
            if(res.paid==1){
                //$('#pay-detail').hide();
                $('.fee-detail-box').show();
                $('#ajax-html').html(res.ajax_html);
            }
            if(res.status=='error'){
                $('.fee-detail-box').hide();
                $('#ajax-html').html('');
                swal('Error',res.msg,'error');
            }
        }    
    });
});

$(document).on('click','.submit-refund',function(){
    $modal = $(this).closest('.modal');
    feeId = $('select[name=fee] option:selected').val();
    feeType = $('select[name=fee] option:selected').data('type');
    stuId = $('select[name=student_id] option:selected').val();
    refundId = $('input[name=refund_rule_id]').val();
    refundNote = $('textarea[name=refund_note]').val();
    
    $('body').loading('start');
    $modal.modal('hide');
    $.ajax({
        type:'post',
        url: '<?php echo base_url('index.php?fees/refund/apply_refund')?>',
        data: {student_id:stuId,fee_type:feeType,fee_id:feeId,ajax_request:1,refundId,refund_id:refundId,refund_note:refundNote},
        dataType: 'json',
        success:function(res){
            $('body').loading('stop');
           
            if(res.status=='error'){
                swal('Error',res.msg,'error');
            }else{
                swal('Success',res.msg,'success');
                window.location.reload();
            }
        }    
    });
});
</script>