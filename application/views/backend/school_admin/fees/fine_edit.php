<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('fee_collection_group_edit'); ?> </h4></div>
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
        <?php echo form_open(base_url('index.php?fees/main/fine_edit/'.$record->id), array('class'=>'form-horizontal form-groups-bordered validate', 
        'target' => '_top')); ?>
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <label for="running_session"><?php echo get_phrase('running_session'); ?></label>
                            <input type="text" class="form-control" name="name" value="<?php echo $running_year?>" readonly/> 
                        </div>
                    </div>
                    <br/>

                    <div class="row">          
                        <div class="col-xs-12 col-md-12">
                            <label for="field-1"><?php echo get_phrase('fine_name');?><span class="error mandatory">*</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-road"></i></div>
                                <input type="text" class="form-control" name="name" required="required" value="<?php echo set_value('name',$record->name)?>"/> 
                            </div>
                        </div> 
                    </div>
                    <br/>
                    
                    <div class="row">          
                        <div class="col-xs-12 col-md-12">
                            <label for="field-1"><?php echo get_phrase('grace_period'); ?><span class="error mandatory">*</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-road"></i></div>
                                <input type="text" class="form-control" name="grace_period" required="required" 
                                value="<?php echo set_value('grace_period',$record->grace_period)?>"/> 
                            </div>
                        </div> 
                    </div>
                    <br/>

                    <div class="row">          
                        <div class="col-xs-12 col-md-12">
                            <label for="field-1"><?php echo get_phrase('value_type'); ?><span class="error mandatory">*</span></label>
                            <div>
                                <label class="radio-inline">
                                    <input type="radio" name="value_type" value="1" <?php echo $record->value_type==1?'checked':''?>><?php echo get_phrase('fix');?>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="value_type" value="2" <?php echo $record->value_type==2?'checked':''?>><?php echo get_phrase('percentage');?>
                                </label>
                            </div>
                        </div> 
                    </div>
                    <br/>

                    <div class="row">          
                        <div class="col-xs-12 col-md-12">
                            <label for="field-1"><?php echo get_phrase('fine_value'); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-book"></i></div>
                                <input type="number" class="form-control" name="value" value="<?php echo set_value('value',$record->value)?>"/>
                            </div> 
                        </div>
                    </div>
                    <br>

                    <div class="row">          
                        <div class="col-xs-12 col-md-12">
                            <label for="field-1"><?php echo get_phrase('fine_description'); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-book"></i></div>
                                <input type="text" class="form-control" name="description" 
                                value="<?php echo set_value('description',$record->description)?>"/>
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
<div class="prtclrs" style="display:none">
<?php foreach($particulars as $parti){
    echo '<option value="'.$parti->id.'">'.$parti->name.'</option>';
}?>    
</div>
<style>
.collection-item{border:1px solid #ccc;padding:10px 20px;}
.mt5{margin-top:5px;}
</style>
<script>
$(function(){
    $('.dtp').datepicker({autoclose:true,format: 'yyyy-mm-dd',clearBtn: true});  
})

$(document).on('change','select[name=fee_group_id]',function (e) {
    var academic_year    =   $('select[name=running_year]').val();
    var fee_group_id    =  this.value;
    
    $.ajax({type:'post',  
            url: '<?php echo base_url('index.php?fees/fees/ajax_get_fee_group_detail')?>', 
            data:{academic_year   :   academic_year,
                  fee_group_id        :   fee_group_id},
            dataType:'json',
            success:function (res) {
                if(res.status=='success'){
                    $('.prtclrs').html(res.particulars_select);
                    $('.add-collection').show(); 
                }else{
                    $('.add-collection').hide(); 
                    $.toast({text: res.msg,heading: res.status,icon: res.status});
                }
            }
        });
});

var ci = <?php echo count($collections)?>;
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
                    <div class="col-md-3">\
                        <label><strong>Name</strong></label>\
                    </div>\
                    <div class="col-md-9">\
                        <input type="text" class="form-control" name="collections['+ci+'][name]" placeholder="Collection Name"/>\
                    </div>\
                </div>\
                <div class="row mt5">\
                    <div class="col-md-3">\
                        <label><strong>Start Date</strong></label>\
                    </div>\
                    <div class="col-md-9">\
                        <input type="text" class="form-control dtp" name="collections['+ci+'][start_date]" placeholder="Start Date"/>\
                    </div>\
                </div>\
                <div class="row mt5">\
                    <div class="col-md-3">\
                        <label><strong>End Date</strong></label>\
                    </div>\
                    <div class="col-md-9">\
                        <input type="text" class="form-control dtp" name="collections['+ci+'][end_date]" placeholder="End Date"/>\
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

$(document).on('keyup change','.parti-item',function (e) {
    citem = $(this).closest('.collection-item');
    totalAmt = 0;
    $.each(citem.find('.parti-item'),function(i,o){
        totalAmt += o.value?parseInt(o.value):0;        
    });
    citem.find('.total-collection-amt').val(totalAmt);

    /* netAmt = 0;    
    $.each($('.insta-table'),function(i,o){
        netAmt += $(o).find('.insta-total').val()?parseInt($(o).find('.insta-total').val()):0;        
    });    
    $('.net-payable').text(netAmt); */
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