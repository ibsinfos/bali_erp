$(document).ready(function () {
    $(".progress").hide();
    $("#emsg").hide();
    $("#submit").click(function (e) {
        e.preventDefault();
        $('#ibox_form').block({ message: null });
        if($(this).attr('action')=='add') {
            vendor_id     =   '';
        } else {
            vendor_id     =   $('#vendor_id').val();
        }
        var _url = $("#_url").val();
        $.post(_url + 'vendors/add', {
            name: $('#name').val(),
            description: $('#description').val(),
            vendor_id:vendor_id
        })
        .done(function (data) {
            setTimeout(function () {
                var sbutton = $("#submit");
                var _url = $("#_url").val();
                if ($.isNumeric(data)) {
                    window.location = _url + 'vendors/list';
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