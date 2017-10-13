$(document).ready(function () {
    $(".progress").hide();
    $("#emsg").hide();
    $("#submit").click(function (e) {
        e.preventDefault();
        $('#ibox_form').block({ message: null });
        if($(this).attr('action')=='add') {
            ded_id     =   '';
        } else {
            ded_id     =   $('#ded_id').val();
        }
        var _url = $("#_url").val();
        $.post(_url + 'fee-deductions/add-post', {
            name: $('#name').val(),
            academic_year: $('#academic_year').val(),
            discount_value: $('#discount_value').val(),
            discount_type : $('#discount_type').val(),
            deduction_id:ded_id
        })
            .done(function (data) {
                setTimeout(function () {
                    var sbutton = $("#submit");
                    var _url = $("#_url").val();
                    if ($.isNumeric(data)) {
                        window.location = _url + 'fee-deductions/view-list';
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