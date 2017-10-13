$(document).ready(function () {
    $(".progress").hide();
    $("#emsg").hide();
    $("#start_month").change(function() {
        var start_month     =   $("#start_month").val();
        if(start_month == '02') {
            $('#start_date_28').show();
            $('#start_date_31').hide();
            $('#start_date_30').hide();
        } else if(start_month == '01' || start_month == '03' || start_month == '05' || start_month == '07' || start_month == '08' || start_month == '10' || start_month == '12') {
            $('#start_date_28').hide();
            $('#start_date_31').show();
            $('#start_date_30').hide();
        } else {
            $('#start_date_28').hide();
            $('#start_date_31').hide();
            $('#start_date_30').show();
        }
    });
    $("#submit").click(function (e) {
        e.preventDefault();
        var start_month     =   $('#start_month').val();
        
        if(start_month == '02') {
            var start_date      =   $('#start_date_28').val();
        } else if(start_month == '01' || start_month == '03' || start_month == '05' || start_month == '07' || start_month == '08' || start_month == '10' || start_month == '12') {
            var start_date      =   $('#start_date_31').val();
        } else {
            var start_date      =   $('#start_date_30').val();
        }
//        $('#installment_form').block({ message: null });
        if($(this).attr('action')=='add') {
            inst_id     =   '';
        } else {
            inst_id     =   $('#installment_id').val();
        }
        var _url = $("#_url").val();
        $.post(_url + 'installments/add_newinstallment/'+inst_id, {
            academic_year: $('#academic_year').val(),
            instalment_name : $('#instalment_name').val(),
            no_of_installment : $('#no_of_installment').val(),
            start_month : start_month,
            start_date  : start_date,
            grace_period : $('#grace_period').val()
        })
            .done(function (data) {

                setTimeout(function () {
                    var sbutton = $("#submit");
                    var _url = $("#_url").val();
                    if ($.isNumeric(data)) {
                        window.location = _url + 'installments/installment_settings';
                    } else {
//                        $('#installment_form').unblock();
                        $("#emsgbody").html(data);
                        $("#emsg").show("slow");
                    }
                }, 2000);
            });
    });
    
    $('.installment_stat').click(function() {
        var inst_id             =   $(this).attr('inst_id');
        var status              =   $(this).attr('status');
        var _url = $("#_url").val();
        $.post(_url + 'installments/installment_status/'+inst_id, {
            status: status,
        })
            .done(function (data) {
                setTimeout(function () {
                    var _url = $("#_url").val();
                    if ($.isNumeric(data)) {
                        window.location = _url + 'installments/installment_settings';
                    } else {
                        $("#emsgbody").html(data);
                        $("#emsg").show("slow");
                    }
                }, 2000);
            });
    });
});