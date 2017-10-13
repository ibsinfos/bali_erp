{include file="sections/header.tpl"}

<div class="wrapper wrapper-content">
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{'Vendors'}</h5>
                {*<div class="ibox-tools">
                       <a href="{$_url}ps/p-list" class="btn btn-primary btn-xs">{'List Fees'}</a>
                </div>*}
            </div>
            <div class="ibox-content" id="ibox_form">
                <div class="alert alert-danger" id="emsg">
                    <span id="emsgbody"></span>
                </div>

                <form class="form-horizontal" id="rform">
                    <input type="hidden" name="vendor_id" id="vendor_id" value="{$vendor['id']}" >

                    <div class="form-group">
                        <label class="col-lg-2 control-label" for="name">{'Vendor Name'}<span class="mandatory">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" id="name" name="name" value="{$vendor['name']}" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label" for="name">{'Description'}<span class="mandatory">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" id="description" name="description" value="{$vendor['description']}" class="form-control" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button class="btn btn-sm btn-primary" {if $vendor['id'] neq ''}action='edit'{else}action='add'{/if} type="submit" 
                                id="submit">{$_L['Submit']}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
{include file="sections/footer.tpl"}      
<script type="text/javascript">
$( "#cancel" ).click(function() {
    
    _url  =   $('#_url').val(); 
    ded_id=$('#ded_id').val();
        
    $.post(_url + 'fee-deductions/cancel_deduction', {
        ded_id: ded_id,
        b_url    : _url
    })
    .done(function (data) {
        window.location.href = _url + 'fee-deductions/view-list';
            

    });
});
</script> 