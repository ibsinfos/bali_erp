$(document).ready(function () {
    $(".progress").hide();
    $("#emsg").hide();
    $("#submit").click(function (e) {
        e.preventDefault();
        $('#ibox_form').block({ message: null });
        if($(this).attr('action')=='add') {
            type_id     =   '';
        } else {
            type_id     =   $('#type_id').val();
        }
        var _url = $("#_url").val();
        $.post(_url + 'ps/add-fee-type/', {
            name: $('#name').val(),
            fee_mod: $('#fee_mod').val(),
            type_id : type_id,
        })
            .done(function (data) {

                setTimeout(function () {
                    var sbutton = $("#submit");
                    var _url = $("#_url").val();
                    if ($.isNumeric(data)) {
                        if(type_id =='') {
                            location.reload();
                        } else {
                            window.location = _url + 'ps/fee-type';
                        }
                    }
                    else {
                        $('#ibox_form').unblock();

                        $("#emsgbody").html(data);
                        $("#emsg").show("slow");
                    }
                }, 2000);
            });
    });
});