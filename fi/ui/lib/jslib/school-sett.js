$(document).ready(function () {
    $(".progress").hide();
    $("#emsg").hide();
    $("#academic_year").change(function () {
        var _url        =   $("#_url").val();
        var ac_year     =   $(this).val();
        window.location = _url + 'installments/school_settings/'+ac_year;
    });
    
    $("#submit").click(function (e) {
        e.preventDefault();
////        $('#installment_form').block({ message: null });
        if($(this).attr('action')=='add') {
            settings_id     =   '';
        } else {
            settings_id     =   $('#settings_id').val();
        }
        var _url = $("#_url").val();
        $.post(_url + 'installments/add_school_settings/'+settings_id, {
            academic_year           :   $('#academic_year').val(),
            tutionfee_installments  :   $('#tutionfee_installments').val(),
            transpfee_installments  :   $('#transpfee_installments').val(),
            hostelfee_installments  :   $('#hostelfee_installments').val()
        })
            .done(function (data) {
                setTimeout(function () {
                    var sbutton = $("#submit");
                    var _url = $("#_url").val();
                    if ($.isNumeric(data)) {
                        window.location = _url + 'installments/school_settings';
                    } else {
                        $("#emsgbody").html(data);
                        $("#emsg").show("slow");
                    }
                }, 2000);
            });
    });
    

});