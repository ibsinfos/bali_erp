<style>
.term-item{border:1px solid #ccc;padding:10px 20px;}
.mt5{margin-top:5px;}
</style>
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('hostel_fee_setup'); ?> </h4></div>
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
        <?php echo form_open(base_url('index.php?fees/main/hostel_fee_setup/'), array('class'=>'form-horizontal form-groups-bordered validate', 
        'target' => '_top','id'=>'form')); ?>
            <div class="row">
                <div class="col-xs-12 col-md-offset-1 col-md-5">
                    <div class="row">
                        <div class="col-xs-12">
                            <label for="running_session"><?php echo get_phrase("current_session"); ?></label>
                            <input type="text" class="form-control" name="running_year" value="<?php echo $running_year?>" readonly />
                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-xs-12">
                            <label><?php echo get_phrase('term'); ?></label>
                            <select name="fee_term_id" class="selectpicker" data-style="form-control" data-live-search="true" data-title="<?php echo get_phrase('select_term');?>">
                                <?php foreach($fee_terms as $fterm){
                                        if(in_array($fterm->id,$hostel_term_setting)){?>
                                    <option value="<?php echo $fterm->id?>" <?php echo ($record && $record->fee_term_id==$fterm->id)?'selected':'';?>>
                                        <?php echo $fterm->name?>
                                    </option>
                                <?php }}?>
                            </select>
                        </div>
                    </div>
                    <br/>

                    <!-- <div class="row">          
                        <div class="col-xs-12">
                            <a class="btn btn-success add-collection"><i class="fa fa-plus"></i> <?php //echo get_phrase('Add Collection')?></a>
                        </div>
                    </div>
                    <br/> -->
                </div>
                <div class="col-xs-12 col-md-offset-1 col-md-5">
                    <div class="row">          
                        <div class="col-xs-12">
                            <div class="fee-terms">
                                <?php foreach($setup_terms as $ci=>$term){?>
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
                                            <div class="col-md-3"><label><strong>Term Name</strong></label></div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control input-sm" name="terms[<?php echo $ci?>][name]" 
                                                placeholder="Term Name" 
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
                                                <select class="selectpicker" data-style="form-control input-sm" data-live-search="true" name="terms[<?php echo $ci?>][fine_id]">
                                                    <option value="">Select Fine</option>
                                                    <?php foreach($fines as $fine){?>
                                                        <option value="<?php echo $fine->id?>" <?php echo $term->fine_id==$fine->id?'selected':''?>>
                                                            <?php echo $fine->name.' -- '.$fine->value.($fine->value_type==2?'%':'')?>
                                                        </option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="row mt5">
                                            <div class="col-md-3"><label><strong><?php echo get_phrase('Percentage')?></strong></label></div>
                                            <div class="col-md-9">
                                                <input type="hidden" name="terms[<?php echo $ci?>][amt_type]" value="<?php echo $term->amt_type?>"/>
                                                <input type="number" class="form-control input-sm no-neg percentage" name="terms[<?php echo $ci?>][amount]" 
                                                placeholder="Percentage" required value="<?php echo $term->amount?>" max="100" step="0.50"/>
                                            </div>
                                        </div>
                                    </div><br/>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    <br/>
                </div>
            </div>

            <div class="form-group">
                <div class="text-right">
                    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit'); ?></button>
                </div>
            </div> 
        <?php echo form_close()?>   
    </div>
</div>
<script>
$(function(){
    $('.dtp').datepicker({autoclose:true,format: 'yyyy-mm-dd',clearBtn: true});  
})

$(document).on('change','select[name=fee_term_id]',function (e) {
    var fee_term_id    =  $('select[name=fee_term_id]').val();
    if(fee_term_id=='')
        return false;

    $.ajax({type:'post',  
            url: '<?php echo base_url('index.php?fees/main/ajax_get_hostel_fee_detail')?>', 
            data:{fee_term_id        :   fee_term_id},
            dataType:'json',
            success:function (res) {
                if(res.status=='success'){
                    /* $('.total-head-amt').html(res.head_total); */
                    $('.fee-terms').html(res.html);
                    $('.dtp').datepicker({autoclose:true, format: 'yyyy-mm-dd',clearBtn: true});  
                    $('.selectpicker').selectpicker('refresh');
                    //$('.add-collection').show(); 
                }else{
                    $.toast({text: res.msg, heading: res.status, icon: res.status});
                }
            }
        });
});

function termUP(event){
    $.each($('.term-item'),function(t,ob){
        citem = $(ob);
        totalPrct = 0;
        $.each(citem.find('.percentage'),function(i,o){
            totalPrct += o.value?parseInt(o.value):0;        
        });
        //citem.find('.total-term-amt').val(totalAmt);
    });
    if(totalPrct!=100){
        event?event.preventDefault():false;
        $.toast({text: '<?php echo get_phrase('total_percentage_should_equal_to_100')?>', heading: 'Error', icon: 'error'});
    }
}

$(document).on('change keyup','.percentage',function(event){
    termUP();
})

$('#form').on('submit',function(event){
    termUP(event);
    //summaryTotal = parseInt($('.summary-total').text());
    //netAmt = parseInt($('.total-setup-amt').val());
    //console.log(summaryTotal,netAmt);return false;
    /* if(summaryTotal!=netAmt){
        event.preventDefault();
        swal('Error','Summary amount should match net amount','error');
        //$.toast({text: 'Summary amount should match net amount', heading: 'Error', icon: 'error'});
    } */
});
</script>