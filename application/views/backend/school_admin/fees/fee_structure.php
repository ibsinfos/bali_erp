<link rel="stylesheet" href="<?php echo base_url('assets/bower_components/select2/dist/css/select2.min.css')?>"/>
<style type="text/css">
    #ex tr td div{bacfdkground-color: lightgray; padding: 15px 15px; colfdor: #000;}
    thead th {font-weight:bold;}
</style>
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title);?></h4> 
    </div>

    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" 
        class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>

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
                    <!-- <div class="row">
                        <div class="col-md-3 pull-right">
                            <label for="field-1"><?php //echo get_phrase('date'); ?></label>
                            <input class="form-control input-sm" type="text" name="date" value="<?php echo date('Y/m/d') ?>" readonly/>
                        </div>    
                    </div> -->

                    <div class="row mt10">
                        <div class="col-md-4 class-select-box">
                            <label><?php echo get_phrase('class')?></label>        
                            <select class="form-control input-sm" name="class_id">
                                <option value=""><?php echo get_phrase('select_class')?></option>
                                <option value="0"><?php echo get_phrase('all_class')?></option>
                                <?php foreach($classes as $cls){?>        
                                    <option value="<?php echo $cls->class_id?>"><?php echo $cls->name?></option>
                                <?php }?>    
                            </select>
                        </div> 

                        <div class="col-md-4">
                            <label><?php echo get_phrase('student')?></label>        
                            <select class="form-control input-sm" name="student_id"> 
                                <option value=""><?php echo get_phrase('select_student')?></option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label><?php echo get_phrase('Fees')?></label>        
                            <select class="form-control input-sm" name="fee"> 
                                <option value=""><?php echo get_phrase('Select Fees')?></option>
                            </select>
                        </div>      
                    </div>                

                    <div class="row mt10 dis-none show-detail-box">
                        <div class="col-md-12">
                            <div class="row fee-detail-box dis-none">
                                <div class="col-md-12">
                                    <h3 class="bg-primary text-center"><?php echo get_phrase('Fee Detail')?></h3>  
                                    <div class="fee-detail">
                                    </div>
                                </div>
                            </div>

                            <div id="print-detail" class="dis-none">
                                <div class="row">
                                    <div class="col-md-2 pull-right">
                                        <a class="fcbtn btn btn-danger btn-outline btn-1d pull-right"><?php echo get_phrase('print_receipt');?></a>
                                    </div>          
                                </div>        
                            </div>    
                        </div>
                    </div>        

                </div>
            </form>    
        </div>
    </div>
</div>


<script src="<?php echo base_url('assets/bower_components/select2/dist/js/select2.full.min.js')?>"></script>
<script>
function resetFeeDetail(){
    $('#print-detail').hide();
    $('select[name=fee]').val('');
    $('.fee-detail-box').find('.fee-detail').html('');
    $('.fee-detail-box').hide();
}
function resetStuDetail(){
    $('#print-detail').hide();
    $('select[name=fee],.stu-detail tbody').html('');
    $('.fee-detail-box').find('.fee-detail').html('');
    $('.fee-detail-box').hide();
}
function resetPayDetail(){
    $('#print-detail').hide();
}

$('select[name=class_id]')
.select2({placeholder: 'Select Class'})
.on('select2:select', function (evt) {
    $('body').loading('start');

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
            if(res.status=='success'){
                $('select[name=student_id]').html(res.html);
            }    
        }    
    });    
});

$('select[name=student_id]')
.select2({placeholder: 'Select Student'})
.on('select2:select', function (evt) {
    resetFeeDetail();
    $('body').loading('start');

    student_id = $('select[name=student_id]').val();
    $.ajax({
        type:'post',
        url: '<?php echo base_url('index.php?fees/ajax/get_student_fees')?>',
        data: {student_status:1,student_id:student_id},
        dataType: 'json',
        success:function(res){
            $('body').loading('stop');
            $('.show-detail-box').show();
            $('select[name=fee]').html(res.html);
            $('.stu-detail').find('tbody').html(res.stu_detail_html);
            if(res.status=='error'){
                swal('Error',res.msg,'error');
            }   
        }    
    });   
});

$('select[name=fee]')
.select2({placeholder: 'Select Term'})
.on('select2:select', function (evt) {
    feeId = this.value;
    feeType = $('select[name=fee] option:selected').data('type');
    $('input[name=fee_type]').val(feeType);
    stuId = $('select[name=student_id] option:selected').val();
    
    $('body').loading('start');
    $.ajax({
        type:'post',
        url: '<?php echo base_url('index.php?fees/ajax/get_fee_detail')?>',
        data: {stu_status:1,student_id:stuId,fee_type:feeType,fee_id:feeId,ajax_request:1},
        dataType: 'json',
        success:function(res){
            $('body').loading('stop');
            resetPayDetail(); 
            $('.fee-detail-box').show();
            $('.fee-detail').html(res.html);
            $('.add-cust-head').closest('.row').remove();
            $('#fee-total').find('.net-paid').closest('tr').remove();
            $('#fee-total').find('.net-due').closest('tr').remove();
            if(res.status=='error'){
                swal('Error',res.msg,'error');
            }   
        }    
    });   
});
 
</script>