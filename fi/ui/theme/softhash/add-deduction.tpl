{include file="sections/header.tpl"}

<div class="wrapper wrapper-content">
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>
                    {'Scholarship Type'}
                </h5>
                {*<div class="ibox-tools">
                       <a href="{$_url}ps/p-list" class="btn btn-primary btn-xs">{'List Fees'}</a>
                </div>*}
            </div>
            <div class="ibox-content" id="ibox_form">
                <div class="alert alert-danger" id="emsg">
                    <span id="emsgbody"></span>
                </div>

                <form class="form-horizontal" id="rform">
                    <input type="hidden" name="ded_id" id="ded_id" {if $ded['id'] neq ''}value="{$ded['id']}"{else}value=""{/if}>
                    <div class="form-group">
                        <label class="col-lg-2 control-label" for="name">{'Academic Year'}<span class="mandatory">*</span></label>
                        <div class="col-lg-10">
                            <select id="academic_year" name="academic_year" class="form-control">
                                <option value="">{'Academic Year'}</option>
                                {foreach $ry as $y}
                                    <option value="{$y}" {if $ded['academic_year'] eq $y}selected="selected"{/if}>
                                        {$y}
                                    </option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="form-group"><label class="col-lg-2 control-label" for="name">{'Scholarship Name'}<span class="mandatory">*</span></label>

                        <div class="col-lg-10"><input type="text" id="name" name="name" {if $ded['scholarship_name'] neq ''}value="{$ded['scholarship_name']}"{/if} class="form-control" autocomplete="off">

                        </div>
                    </div>
                    <div class="form-group"><label class="col-lg-2 control-label" for="name">{'Discount Type'}<span class="mandatory">*</span></label>
                        <div class="col-lg-10">
                            <select  id="discount_type" name="deduction_type" class="form-control">
                                <option value="2" {if $ded['deduction_type'] eq '2'}selected="selected"{/if}>Percentage</option>
                                <option value="1" {if $ded['deduction_type'] eq '1'}selected="selected"{/if}>Amount</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group"><label class="col-lg-2 control-label" for="name">{'Discount Value'}<span class="mandatory">*</span></label>

                        <div class="col-lg-4">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1" style="display:{if $ded['deduction_type'] eq '2' || $ded['deduction_type'] eq ''}none{/if}">
                                    {$config['currency_code']}</span>
                            
                                <input type="text" {if $ded['deduction_value'] neq ''} value="{$ded['deduction_value']}"{/if} id="discount_value" 
                                name="discount_value" class="form-control" autocomplete="off" data-a-dec="{$config['dec_point']}" 
                                data-a-sep="{$config['thousands_sep']}" data-d-group="2">
                             </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button class="btn btn-sm btn-primary" {if $ded['id'] neq ''}action='edit'{else}action='add'{/if} type="submit" 
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
$(function(){
     $('#discount_type').on('change',function(){
        if(this.value==2){
            $('#basic-addon1').hide();
            $('#discount_value').autoNumeric('destroy');
        }else{
            $('#basic-addon1').show();
            $('#discount_value').autoNumeric('init');
        }
     });
})

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