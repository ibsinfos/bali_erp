<link rel="stylesheet" href="<?php echo base_url('assets/bower_components/select2/dist/css/select2.min.css')?>"/>
<style type="text/css">
    #ex tr td div{bacfdkground-color: lightgray; padding: 15px 15px; colfdor: #000;}
    thead th {font-weight:bold;}
    #page-wrapper .white-box.dis-none.fee-detail-box .mt5{display: none;}
    label{font-weight: bold;}
</style>
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title);?></h4>
    </div>
    <!-- /.page title -->
</div>

<div class="col-md-6">
    <div class="col-md-12 white-box">

        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-md-4">Student Name</label>
                <div class="col-md-8">: 
<?php echo ucwords($stu_details->name.' '.$stu_details->mname.' '.$stu_details->lname); ?></div>                
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-md-4">Class</label>
                <div class="col-md-8">:  
<?php echo $stu_details->class_name.' - '.$stu_details->section_name.' ('.$running_year.')'; ?></div>
             </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-md-4">Enroll</label>
                <div class="col-md-8">: <?php echo $stu_details->enroll_code; ?>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="col-md-6">
    <div class="col-md-12 white-box" style="padding-bottom: 37px;">
        <div class="row"> 
            <form method="post" id="collection-form">
                <div class="col-md-12">
                    <div class="row mt10">                        
                        <div class="col-md-12">
                            <label><?php echo get_phrase('Fees')?></label>        
                            <select class="form-control input-sm" name="fee">
                                    <?php if(isset($terms['school_fee_terms'])){ if(count($terms['school_fee_terms'])){ ?>
                                <optgroup label="School Fees">
<?php foreach($terms['school_fee_terms'] as $datum){?>
        <option data-type="school" value="<?php echo $datum->id?>"><?php echo ucwords($datum->name.' -- '.$datum->amount);?></option><?php }?>
                                </optgroup>

                                <?php }} if(isset($terms['hostel_fee_terms'])){ if(count($terms['hostel_fee_terms'])){?>

                                <optgroup label="Hostel Fees">
<?php foreach($terms['hostel_fee_terms'] as $datum){?>
                                    <option data-type="hostel" value="<?php echo $datum->id; ?>"> <?php echo ucwords($datum->name);?></option><?php }?>
                                </optgroup>

<?php }} if(isset($terms['hostel_fee_terms'])){ if(count($terms['hostel_fee_terms'])){?>
                                <optgroup label="Transport Fees">
<?php foreach($terms['hostel_fee_terms'] as $datum){?>
                                    <option data-type="transport" value="<?php echo $datum->id; ?>"> <?php echo ucwords($datum->name);?></option><?php }?>
                                </optgroup><?php }}?>

                            </select>
                        </div>      
                    </div>
                </div>
            </form>    
        </div>
    </div>
</div>


<div class="col-md-12 white-box dis-none fee-detail-box">
    <div class="row">
        <div class="fee-detail">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="bg-primary text-center"><?php echo get_phrase('Fee Detail')?></h3>  
                    <div class="fee-detail"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 text-right">
        <button type="button" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('Pay_now');?></button>
    </div>
</div>

<script src="<?php echo base_url('assets/bower_components/select2/dist/js/select2.full.min.js')?>"></script>
<script>

function get_fee_detail(){
    feeId = $('select[name=fee] option:selected').val();
    feeType = $('select[name=fee] option:selected').data('type');
    stuId = '<?php echo $student_id;?>';

    if((feeId!='') && (feeType!='') && (stuId!='')){

        $('body').loading('start');
        $.ajax({
            type:'post',
            url: '<?php echo base_url('index.php?fees/ajax/get_fee_detail')?>',
            data: {stu_status:1,student_id:stuId,fee_type:feeType,fee_id:feeId,ajax_request:1},
            dataType: 'json',
            success:function(res){
                $('body').loading('stop');
                $('.fee-detail').empty();

                if(res.status=='error'){
                    $('.fee-detail-box').hide(); 
                    swal('Error',res.msg,'error');
                }else{
                    $('.fee-detail').html(res.html);
                    $('.fee-detail-box').show();    
                } 
            }    
        });
    }
}

$(document).ready(function(){
    get_fee_detail();
});

$('select[name=fee]')
.select2({placeholder: 'Select Term'})
.on('select2:select', function (evt) {
    get_fee_detail();       
});
 
</script>