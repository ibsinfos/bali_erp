$(document).ready(function () {

    var _url = $("#_url").val();
    $('.amount').autoNumeric('init');
    $('#notes').redactor(
        {
            minHeight: 200, // pixels
            plugins: ['fontcolor']
        }
    );

    var $invoice_items = $('#invoice_items');

    $('.item_name').redactor({paragraphize: false,
        replaceDivs: false,
        linebreaks: true});







    $invoice_items.on('change', 'select', function(){
        //   $('#taxtotal').html('dd');
        var taxrate = $('#stax').val().replace(',', '.');
        // $(this).val(taxrate);

    });

    var item_remove = $('#item-remove');
    item_remove.hide();




    function update_address(){
        var _url = $("#_url").val();
        var cid = $('#cid').val();
        if(cid != ''){
            $.post(_url + 'contacts/render-address/', {
                cid: cid

            })
                .done(function (data) {
                    var adrs = $("#address");


                    adrs.html(data);

                });
        }

    }
    update_address();
    $('#cid').select2({
        theme: "bootstrap",
        language: {
            noResults: function () {
                return $("#_lan_no_results_found").val();
            }
        }
    })
        .on("change", function(e) {
            // mostly used event, fired to the original element when the value changes
            // log("change val=" + e.val);
            //  alert(e.val);

            update_address();
        });






    item_remove.on('click', function(){
        $("#invoice_items tr.info").fadeOut(300, function(){
            $(this).remove();

        });

    });

    var $modal = $('#ajax-modal');



    $('#item-add').on('click', function(){
        var group_id    =   $('#group_id').val();
        
        // create the backdrop and wait for next modal to be triggered
        if(group_id == '') {
            $('#emsg').html('Please Select Class');
            $('#emsg').show();
            scrollTop: $("#emsg").offset().top;
            return false;
        } else {
            $('#emsg').html('');
            $('#emsg').hide();
            $('body').modalmanager('loading');

            var _url = $("#_url").val();


            $modal.load( _url + 'ps/modal-list/'+group_id,'', function(){
                $modal.modal();
            });
        }
    });

    /*
     / @since v 2.0
     */

    $('#contact_add').on('click', function(e){
        e.preventDefault();
        // create the backdrop and wait for next modal to be triggered
        $('body').modalmanager('loading');

        $modal.load( _url + 'contacts/modal_add/', '', function(){
            $modal.modal();
            $("#ajax-modal .country").select2({
                theme: "bootstrap"
            });
        });
    });

    var rowNum = 0;

    $('#blank-add').on('click', function(){
        rowNum++;
        $invoice_items.find('tbody')
            .append(
            //'<tr> <td></td> <td><textarea class="form-control item_name" name="desc[]" rows="3" id="i_' + rowNum + '"></textarea></td> <td><input type="text" class="form-control qty" value="" name="qty[]"></td> <td><input type="text" class="form-control item_price" name="amount[]" value=""></td> <td class="ltotal"><input type="text" class="form-control lvtotal" readonly value=""></td> <td> <select class="form-control taxed" name="taxed[]"> <option value="Yes">Yes</option> <option value="No" selected>No</option></select></td></tr>'
            '<tr> <td>'+rowNum+'</td> <td> </td> <td><input type="text" class="form-control item_price" name="amount[]" value=""></td> <td class="ltotal"><input type="text" class="form-control lvtotal" readonly value=""></td> </tr>'
        );


        $('#i_' + rowNum).redactor({paragraphize: false,
            replaceDivs: false,
            linebreaks: true});


    });

    $invoice_items.on('click', '.redactor-editor', function(){
        $("tr").removeClass("info");
        $(this).closest('tr').addClass("info");

        item_remove.show();
    });

    $modal.on('click', '.update', function(){
        var tableControl= document.getElementById('items_table');
        $modal.modal('loading');
        $modal.modal('loading');
        //$modal
        //    .modal('loading')
        //    .find('.modal-body')
        //    .prepend('<div class="alert alert-info fade in">' +
        //    'Updated!<button type="button" class="close" data-dismiss="alert">&times;</button>' +
        //    '</div>');


        //  input type="text" class="form-control item_name" name="desc[]" value="' + item_name + '">
        // var obj = new Array();
        total_price_for_invoice=0;
        total_discount=0;
        curr_tot        =   $('#sub_total').text();
        curr_tot        =   parseInt(curr_tot);

        $('input:checkbox:checked', tableControl).each(function() {
            rowNum++; 
            var item_code = $(this).closest('tr').find('td:eq(1)').text();
            var item_name = $(this).closest('tr').find('td:eq(2)').text();
            var item_price = $(this).closest('tr').find('td:eq(3)').text();
            total_price_for_invoice=parseInt(total_price_for_invoice) +parseInt(item_price.replace(/\,/g,""));
            $invoice_items.find('tbody')
                .append(
                ///'<tr> <td>' + rowNum + '</td> <td><textarea class="form-control item_name" name="desc[]" rows="3" id="i_' + rowNum + '">' + item_name + '</textarea></td> <td><input type="text" class="form-control qty" value="1" name="qty[]"></td> <td><input type="text" class="form-control item_price" name="amount[]" value="' + item_price + '"></td> <td class="ltotal"><input type="text" class="form-control lvtotal" readonly value=""></td> <td> <select class="form-control taxed" name="taxed[]"> <option value="Yes">Yes</option> <option value="No" selected>No</option></select></td></tr>'
                '<tr> <td>' + rowNum + '<input type="hidden" class="item_code" value="'+ item_code +'" name="item_code[]" rows="3" id="ic_' + rowNum + '"><input type="hidden" class="" value="'+ item_name +'" name="desc[]" rows="3" id="desc_' + rowNum + '"></td> <td>' + item_name + '</td> <td><input type="text" class="form-control item_price" name="amount[]" value="' + item_price + '"></td>  </tr>'
            );
            
            $('#i_' + rowNum).redactor({paragraphize: false,
                replaceDivs: false,
                linebreaks: true});
            
            var discount_type=$('#discount_type').val();
            
            
        });
            var raw_discount=$('#discount_amount').val();
            $('#discount_amount').val();
            total_price_for_invoice     =   total_price_for_invoice+curr_tot;
            $('#sub_total').text(total_price_for_invoice+".00");

            if(discount_type== "p"){
                discount=total_price_for_invoice*raw_discount/100;
                $('#discount_amount_total').text(discount+".00");
            }else{
                discount=raw_discount;
                $('#discount_amount_total').text(discount+".00");
            }
            $('#total').text((total_price_for_invoice-discount)+".00");
                    

        //  console.debug(obj); // Write it to the console
        //  calculateTotal();
        $modal.modal('hide');
    });


    $modal.on('click', '.contact_submit', function(e){
        e.preventDefault();
        //  var tableControl= document.getElementById('items_table');
        $modal.modal('loading');
        var _url = $("#_url").val();
        $.post(_url + 'contacts/add-post/', {
            account: $('#account').val(),
            company: $('#company').val(),
            address: $('#m_address').val(),
            city: $('#city').val(),
            state: $('#state').val(),
            zip: $('#zip').val(),
            country: $('#country').val(),
            phone: $('#phone').val(),
            email: $('#email').val()
        })
            .done(function (data) {
                var _url = $("#_url").val();
                if ($.isNumeric(data)) {
                    // location.reload();
                    var is_recurring = $('#is_recurring').val();
                    if(is_recurring == 'yes'){
                        window.location = _url + 'invoices/add/recurring/' + data + '/';
                    }else{
                        window.location = _url + 'invoices/add/1/' + data + '/';
                    }
                }
                else {
                    $modal
                        .modal('loading')
                        .find('.modal-body')
                        .prepend('<div class="alert alert-danger fade in">' + data +
                        '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                        '</div>');
                    $("#cid").select2('data', {id: newID, text: newText});
                }
            });
    });

    $("#add_discount").click(function (e) {
        e.preventDefault();
        var s_discount_amount = $('#discount_amount');
        var c_discount = s_discount_amount.val();
        var c_discount_type = $('#discount_type').val();
        var p_checked = "";
        var f_checked = "";
        if( c_discount_type == "p" ){
            p_checked = 'checked="checked"';
        }else{
            f_checked = 'checked="checked"';
        }
        bootbox.dialog({
                title: "Give Scholarship",
                message: '<div class="row">  ' +
                '<div class="col-md-12"> ' +
                '<form class="form-horizontal"> ' +
                '<div class="form-group"> ' +
                '<label class="col-md-4 control-label" for="set_discount">Scholarship Amount</label> ' +
                '<div class="col-md-4"> ' +
                '<input id="set_discount" name="set_discount" type="text" class="form-control input-md" value="' + c_discount + '"> ' +
                '</div> ' +
                '</div> <input type="hidden" name="set_discount_type" id="set_discount_type-1" value="f">' +
                '</form> </div>  </div>',
                buttons: {
                    success: {
                        label: $("#_lan_btn_save").val(),
                        className: "btn-success",
                        callback: function () {
                            var discount_amount = $('#set_discount').val();
                            var discount_type = $("input[name='set_discount_type']:checked").val();
                            $('#discount_amount').val(discount_amount);
                            $('#discount_type').val(discount_type);
                            //calculateTotal();
                            //updateTax();
                            //updateTotal();
                        }
                    }
                }
            }
        );
    });


    //var callbacks = $.Callbacks();
    //callbacks.add( updateTotal );
    //callbacks.fire(  alert('done') );


    $(".progress").hide();
    $("#emsg").hide();
    $("#submit").click(function (e) {
        e.preventDefault();
        $('#ibox_form').block({ message: null });
        var _url = $("#_url").val();
        $.post(_url + 'invoices/add-post/', $('#invform').serialize(), function(data){

            var _url = $("#_url").val();
            if ($.isNumeric(data)) {

                window.location = _url + 'invoices/list/';
            }
            else {
                $('#ibox_form').unblock();
                var body = $("html, body");
                body.animate({scrollTop:0}, '1000', 'swing');
                $("#emsg").html(data);
                $("#emsg").show("slow");
            }
        });
    });


    $("#save_n_close").click(function (e) {
        e.preventDefault();
        $('#ibox_form').block({ message: null });
        var _url = $("#_url").val();
        $.post(_url + 'invoices/add-post/', $('#invform').serialize(), function(data){

            var _url = $("#_url").val();
            if ($.isNumeric(data)) {
                window.location = _url + 'invoices/view/' + data + '/';
            }
            else {
                $('#ibox_form').unblock();
                var body = $("html, body");
                body.animate({scrollTop:0}, '1000', 'swing');
                $("#emsg").html(data);
                $("#emsg").show("slow");
            }
        });
    });

    //function doStuff() {
    //    $('.amount').autoNumeric('init');
    //   // alert('dd');
    //}
    //setInterval(doStuff, 5000);
    $('#group_id').change(function() {
        var _url = $("#_url").val();
        $.post(_url + 'invoices/section-by-class/', {

            group_id    :   $(this).val(),

        })

            .done(function (data) { 

                    var result =  $("#section_id");
                    result.html(data);
            });
    });
    
    $('#section_id').change(function() { 
        var _url = $("#_url").val();
        $.post(_url + 'invoices/accounts-by-section/', {

            section_id    :   $(this).val(),

        })
            .done(function (data) { 
                    var result =  $("#cid");
                    result.html(data);
            });
    });
    
    $('.create_mode').click( function() { 
        if($(this).val() == 'single') { 
            $('.single-invoice-student').show();
            $('#cidStar').show();
           // $('#gidStar').hide();
        } else {
            $('.single-invoice-student').hide();
            $('#cidStar').hide();
            $('#gidStar').show();
        }
    });
    
    $('.create_mode_type').click( function() {
        if($(this).val() == 'recurring') { 
            $('.single-invoice-student-repeat').show();
        } else {
            $('.single-invoice-student-repeat').hide();
        }
    });
    
});