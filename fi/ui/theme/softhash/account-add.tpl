
{include file="sections/header.tpl"}
<div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger" id="emsg">
                <span id="emsgbody"></span>
            </div>
        </div>
    <div class="col-md-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{$_L['Add_New_Account']}</h5>

            </div>
            <div class="ibox-content">

                <form role="form" id="accadd" name="accadd" method="post" action="{$_url}accounts/add-post">
                    <div class="form-group">
                        <label for="account">{$_L['Account Title']}<span class="mandatory">*</span></label>
                        <input type="text" class="form-control" id="account" name="account">

                    </div>
                    <div class="form-group">
                        <label for="description">{$_L['Description']}</label>
                        <input type="text" class="form-control" id="description" name="description">
                    </div>
                    <div class="form-group">
                        <label for="balance">{$_L['Initial Balance']}</label>
                        <input type="text" class="form-control amount" id="balance" name="balance" data-a-sign="{$_c['currency_code']} "  data-a-dec="{$_c['dec_point']}" data-a-sep="{$_c['thousands_sep']}" data-d-group="2">
                    </div>


                    <div class="form-group">
                        <label for="account_number">{$_L['Account Number']}<span class="mandatory">*</span></label>
                        <input type="text" class="form-control" id="account_number" name="account_number">
                    </div>

                    <div class="form-group">
                        <label for="contact_person">{$_L['Contact Person']}</label>
                        <input type="text" class="form-control" id="contact_person" name="contact_person">
                    </div>

                    <div class="form-group">
                        <label for="contact_phone">{$_L['Phone']}</label>
                        <input type="text" class="form-control" id="contact_phone" name="contact_phone">
                    </div>

                    <div class="form-group">
                        <label for="ib_url">{$_L['Internet Banking URL']}</label>
                        <input type="text" class="form-control" id="ib_url" name="ib_url">
                    </div>



                        <button type="submit" class="btn btn-primary" id="submit"><i class="fa fa-check"></i> {$_L['Submit']}</button>
                </form>

            </div>
        </div>



    </div>



</div>




{include file="sections/footer.tpl"}

<script>
    $(document).ready(function () {
    $(".progress").hide();
    $("#emsg").hide();
    $("#submit").click(function (e) {
        e.preventDefault();
        //$('#ibox_form').block({ message: null });
        var _url = $("#_url").val();
        $.post(_url + 'accounts/add-post/', $('#accadd').serialize(), function(data){

            var _url = $("#_url").val();
            if ($.isNumeric(data)) {
                window.location = _url + 'accounts/list/';
            }
            else {
                $('#ibox-content').unblock();
                var body = $("html, body");
                $("#emsg").html(data);
                $("#emsg").show("slow");
            }
        });
    });
    });
</script>