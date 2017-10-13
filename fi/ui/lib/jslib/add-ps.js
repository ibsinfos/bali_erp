$(document).ready(function () {
    $(".progress,#emsg").hide();

    $('#fee_type').change(function(){
        if(this.value=='1'){
            $('.mand-opt').show();
            $('.scholar-div').hide();
        }else{
            $('.mand-opt').hide();
            $('.scholar-div').show();
        }    
    });

    $("#submit").click(function (e) {
        e.preventDefault();
        $('#ibox_form').block({ message: null });
        var _url        =   $("#_url").val(); 
        var group_id    =   $('#group_id').val();
        
        var group_id    =   []; 
        $('#group_id :selected').each(function(i, selected){
            group_id[i] = $(selected).val(); 
        });
        
        $.post(_url + 'ps/add-post/', {

            academic_year   :   $('#academic_year').val(),
            fee_type        :   $('#fee_type').val(),
            name            :   $('#name').val(),
            group_id        :   group_id,
            sales_price     :   $('#sales_price').val(),
            item_number     :   $('#item_number').val(),
            description     :   $('#description').val(),
            fee_start_date  :   $('#fee_start_date').val(),
            fee_due_date    :   $('#fee_due_date').val(),
            type            :   $('#type').val(),
            scholarship_active            :   $('#scholarship_active').val(),
            optional_for_enquery            :   $('#optional_for_enquery').val()
        })
            .done(function (data) {
                setTimeout(function () {
                    var sbutton = $("#submit");
                    var _url = $("#_url").val();
                    if ($.isNumeric(data)) {
                        //location.reload();
                        window.location.href = '?ng=ps/p-list/'+$('#fee_type').val();
                    }
                    else {
                        $('#ibox_form').unblock();

                        $("#emsg").html(data);
                        $("#emsg").show("slow");
                    }
                }, 2000);
            });
    });

    $(document).on('click','#fetch_insta',function (e) {
        $('#ibox_form').block({ message: null });
        var _url        =   $("#_url").val(); 
        var academic_year    =   $('#academic_year').val();
        var group_id    =   $('#group_id').val();
        /* var fee_type_id    =   $('#fee_type_id').val(); */
        var installment_id    =   $('#installment_id').val();

        $("#emsg").hide("slow");
        var msg = '';
        if($.trim(academic_year)==''){
            msg = 'Please select academic year!';
        } else if($.trim(group_id)==''){
            msg = 'Please select group!';
        } else if($.trim(installment_id)==''){
            msg = 'Please select instalment!';
        }     
        if(msg!=''){
            $("#emsg").removeClass('alert-success').addClass('alert-danger');
            $("#emsg").html(msg);
            $("#emsg").show("slow");
            $('#ibox_form').unblock();
            return false;
        } 
        
        $.ajax({type:'post',  
                url: _url + 'ps/get-fee-insta/', 
                data:{academic_year   :   academic_year,
                      group_id        :   group_id,
                      installment_id  :   installment_id},
                dataType:'json',
                success:function (data) {
                    $('#item-data').find('tbody').html(data.item_summary_tbody); 
                    $('#item-data').find('tfoot').html(data.item_summary_tfoot); 
                    $('#insta-data').html(data.html);
                    $('#sys-items').html(data.sys_items);
                    $('.save-insta,#sys-item-box').show();
                    $('.dtp').datepicker({autoclose:true,
                                        format: 'yyyy-mm-dd',
                                        clearBtn: true});
                    $('#ibox_form').unblock();
                }
            });
    });

    $(document).on('click','.add-to-insta',function (e) {
        $("#emsg").hide("slow");
        table = $(this).closest('table');
        last_row = table.find('.total-row');
        opt = table.find('#sys-item option:selected');
        if(opt.val()==''){
            $("#emsg").removeClass('alert-success').addClass('alert-danger');
            $("#emsg").html('Please select an item!');
            $("#emsg").show("slow");
        }else{
            if($('#item-data').find('.item-rw[data-id='+opt.val()+']').length==0){
                itemHtml = '<tr class="item-rw" data-id="'+opt.val()+'" data-amt="'+opt.data('amt')+'"><td>'+opt.data('title')+'</td> <td>'+parseFloat(opt.data('amt'))+'</td></tr>';
                $('#item-data').find('tbody').append(itemHtml); 
            }
            totalAmt = 0;
            $.each($('#item-data').find('.item-rw'),function(i,o){
                totalAmt += parseFloat($(o).data('amt'));        
            });
            
            if($('#item-data').find('tfoot').find('.total-item-amt').length>0){
                $('#item-data').find('tfoot').find('.total-item-amt').data('amt',totalAmt);
                $('#item-data').find('tfoot').find('.total-item-amt .tot-amt').text(totalAmt);
            }else{    
                itemHtml = '<tr class="total-item-amt" data-amt="'+opt.data('amt')+'"><th>Total</th><th class="tot-amt">'+totalAmt+'</th></tr>';
                $('#item-data').find('tfoot').append(itemHtml); 
            }   

            if(table.find('.row-item[data-item-id='+opt.val()+']').length>0)
                return false; 
            html ='<tr>\
                        <td>'+opt.data('title')+'</td>\
                        <td>\
                            <input type="number" class="form-control row-item" placeholder="Amount" name="insta['+table.data('insta-num')+'][items]['+opt.val()+']"\
                            data-item-id="'+opt.val()+'"/>\
                        </td>\
                    </tr>';
            last_row.before(html);
        }
    });

    $(document).on('keyup change','.row-item',function (e) {
        $("#emsg").hide("slow");
        table = $(this).closest('.insta-table');
        totalAmt = 0;
        $.each(table.find('.row-item'),function(i,o){
            totalAmt += o.value?parseInt(o.value):0;        
        });
        table.find('.insta-total').val(totalAmt);

        netAmt = 0;    
        $.each($('.insta-table'),function(i,o){
            netAmt += $(o).find('.insta-total').val()?parseInt($(o).find('.insta-total').val()):0;        
        });    
        $('.net-payable').text(netAmt);
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
        /* var academic_year    =   $('#academic_year').val();
        var group_id    =   $('#group_id').val();
        var fee_type_id    =   $('#fee_type_id').val();
        var installment_id    =   $('#installment_id').val();
        var insta_amounts = $("input[name='amounts\\[\\]']")
              .map(function(){return $(this).val();}).get(); */
        var id    =   $('#fee_set_id').val();
        
        $.ajax({type:'post',  
                url: _url + 'ps/save-fee-insta/', 
                data:$("#insta-form").serialize(),
                   /* { academic_year   :   academic_year,
                      group_id        :   group_id,
                      fee_type_id     :   fee_type_id,
                      installment_id  :   installment_id,
                      insta_amounts   :   insta_amounts,
                      id              :   id, 
                    value:value},*/
                dataType:'json',
                success:function (data) {
                    $('#ibox_form').unblock();
                    $("#emsg").removeClass('alert-danger').addClass('alert-success');
                    $("#emsg").html(data.msg);
                    $("#emsg").show("slow");
                }
            });
    });
});