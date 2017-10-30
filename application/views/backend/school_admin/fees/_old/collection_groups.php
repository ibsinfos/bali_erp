<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('fee_collection_groups'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
    </div>
    <!-- /.breadcrumb -->
</div>
<div class="row m-0">
    <div class="col-md-12 white-box">
        <div class="sttabs tabs-style-flip">
            <nav>
                <ul>
                    <li class="active">
                        <a href="#list" class="sticon fa fa-list"><span class="hidden-xs"><?php echo get_phrase('fee_collection_groups'); ?></span></a>
                    </li>
                    <li>
                        <a href="#add" class="sticon fa fa-plus-circle">
                            <span class="hidden-xs"><?php echo get_phrase('add_collection_group'); ?></span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="content-wrap">     	
                <section id="list">  
                    <!--TABLE LISTING STARTS-->           
                    <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
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
                                        <a href="<?php echo base_url('index.php?fees/fees/collection_group_edit/'.$rec->id);?>">
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
                                            <a href="javascript:void(0)" onclick="confirm_act('<?php echo base_url('index.php?fees/fees/collection_group_delete/'.$rec->id);?>')">
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
                    <?php echo form_open(base_url('index.php?fees/fees/collection_groups'), array('class'=>'form-horizontal form-groups-bordered validate', 
                    'target' => '_top')); ?>
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-1 col-md-5">
                            <div class="row">
                                <div class="col-xs-12">
                                    <label for="running_session"><?php echo get_phrase("current_session"); ?></label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                                        <select name="running_year" class="selectpicker" data-style="form-control" data-live-search="true">
                                            <option value=""><?php echo get_phrase('select_current_session');?></option>
                                            <?php $last_year = date('Y',strtotime('-1 year'));
                                                    for($i = 0; $i < 10; $i++){
                                                        $grp_year = ($last_year+$i).'-'.($last_year+($i+1));?>
                                                    <option value="<?php echo $grp_year?>" <?php echo $grp_year==set_value('running_year',$running_year)?'selected':'';?>>
                                                        <?php echo $grp_year?>
                                                    </option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br/>

                            <div class="row">          
                                <div class="col-xs-12">
                                    <label for="field-1"><?php echo get_phrase('collection_group_name'); ?><span class="error mandatory">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-road"></i></div>
                                        <input type="text" class="form-control" name="name" value="<?php echo set_value('name')?>" data-validate="required" 
                                        data-message-required="<?php echo get_phrase('value_required');?>" required="required"/> 
                                    </div>
                                </div> 
                            </div>
                            <br/>

                            <div class="row">          
                                <div class="col-xs-12">
                                    <label for="field-1"><?php echo get_phrase('description'); ?></label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-book"></i></div>
                                        <input type="text" class="form-control" name="description" value="<?php echo set_value('description')?>"/>
                                    </div> 
                                </div>
                            </div>
                            <br/>

                            <div class="row">
                                <div class="col-xs-12">
                                    <label><?php echo get_phrase('fee_group'); ?></label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                                        <select name="fee_group_id" class="selectpicker" data-style="form-control" data-live-search="true">
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
                                    <a class="btn btn-success add-collection" style="display:none"><i class="fa fa-plus"></i> <?php echo get_phrase('Add Collection')?></a>
                                </div>
                            </div>
                            <br/>
                        </div>
                        <div class="col-xs-12 col-md-offset-1 col-md-5">
                            <div class="row">          
                                <div class="col-xs-12">
                                    <div class="fee-collections">
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
                </section>                
            </div>
        </div>
    </div>
</div>
<div class="prtclrs" style="display:none"></div>
<style>
.collection-item{border:1px solid #ccc;padding:10px 20px;}
.mt5{margin-top:5px;}
</style>
<script>
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
                    $.toast({
                        text: res.msg, // Text that is to be shown in the toast
                        heading: res.status, // Optional heading to be shown on the toast
                        icon: res.status, // Type of toast icon
                    });
                }
            }
        });
});

var ci = 0;
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