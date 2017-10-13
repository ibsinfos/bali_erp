{include file="sections/header.tpl"}
<style type="text/css">
    #start_date_28, #start_date_30 {
        display: none;
    }
</style>
<div class="row">
    <div class="alert alert-danger" id="emsg">
        <span id="emsgbody"></span>
    </div>

    <div class="col-md-6">

        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{'Fee Installments'}</h5>
            </div>
            <form class="form-horizontal" id="installment_form">
            <div class="ibox-content">
                    <div class="form-group col-lg-12">
                        <label class="col-lg-4" for="header_scripts">{'Academic Year'}<span class="mandatory">*</span></label>
                        <span class="col-md-8">
                            <select id="academic_year" name="academic_year" class="form-control">
                                    {foreach $ry as $y}
                                        <option {if $y eq $inst['academic_year']} selected="selected" {/if} value="{$y}" >
                                            {$y}
                                        </option>
                                    {/foreach}
                            </select>
                        </span>
                    </div>
                    <div class="form-group  col-lg-12"><label class="col-lg-4" for="name">{$_L['Name']}<span class="mandatory">*</span></label>
                        <span class="col-lg-8">
                            <input type="hidden" id="installment_id" {if $inst['id'] neq '' } value="{$inst['id']}" {else} value="" {/if} name="instalment_name">
                            <input type="text" id="instalment_name" {if $inst['installment_name'] neq '' } value="{$inst['installment_name']}" {else} value="" {/if} name="instalment_name" class="form-control" autocomplete="off">
                        </span>
                    </div>
                    <div class="form-group  col-lg-12"><label class="col-lg-4 " for="name">{'Number of Installment'}<span class="mandatory">*</span></label>
                        <span class="col-md-8">
                            <input type="text" id="no_of_installment" {if $inst['no_of_installment'] neq '' } value="{$inst['no_of_installment']}" {else} value="" {/if} name="no_of_installment" class="form-control" autocomplete="off">
                        </span>
                    </div>
                    <div class="form-group col-lg-12">
                        <label class="col-lg-4" for="header_scripts">{'Starting Month'}<span class="mandatory">*</span></label>
                        <span class="col-md-8">
                            <select id="start_month" name="start_month" class="form-control">
                                {foreach $month as $k=>$v}
                                    <option value="{$k}" >{$v}</option>
                                {/foreach}
                            </select>
                        </span>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="col-md-4 " for="name">{'Start Date'}<span class="mandatory">*</span></label>
                        <span class="col-md-8">
                            {*<input class="form-control" type="text" id="start_date" {if $inst['start_date'] neq '' } value="{$inst['start_date']}" {else} value="" {/if} name="start_date" autocomplete="off">*}
                            <select id="start_date_28" name="start_date" class="form-control">
                                {for $var = 1 to 28}}
                                    <option {if $inst['start_date'] eq $var } selected {/if} value="{$var}" >{$var}</option>
                                {/for}
                            </select>
                            <select id="start_date_30" name="start_date" class="form-control">
                                {for $var = 1 to 30}}
                                    <option {if $inst['start_date'] eq $var } selected {/if} value="{$var}" >{$var}</option>
                                {/for}
                            </select>
                            <select id="start_date_31" name="start_date" class="form-control">
                                {for $var = 1 to 31}}
                                    <option {if $inst['start_date'] eq $var } selected {/if} value="{$var}" >{$var}</option>
                                {/for}
                            </select>
                        </span>
                    </div>  
                    <div class="form-group  col-lg-12"><label class="col-lg-4 " for="name">{'Grace Period'}<span class="mandatory">*</span> {'<br>(In Days)'}</label>
                        <span class="col-lg-8">
                            <input type="text" id="grace_period" name="grace_period" {if $inst['grace_period'] neq '' } value="{$inst['grace_period']}" {else} value="" {/if} class="form-control" autocomplete="off">
                        </span>
                    </div>
                    
                    <button type="submit" id="submit" {if $inst['id'] neq '' } action="edit" {else}action="add"{/if} class="btn btn-primary"> 
                        {if $inst['id'] neq '' } {'Update'} {else} {$_L['Submit']} {/if}</button>
                    
            </div>
            </form>
        </div>
    </div>
    <div class="col-md-6">
        <div class="ibox-content">
            <table class="table table-bordered table-hover sys_table footable" data-page-size="50">
                <tr>
                    <th >#</th>
                    <th>Installment Name</th>
                    <th>Running Year</th>
                    <th>No</th>
                    <th>Start Date</th>
                    <th>Grace Period</th>
                    <th>Status</th>
                </tr>
                {foreach $installments as $key => $value}
               
                <tr>
                    <td>{$count++}</td>
                    <td><a href="{$_url}installments/installment_settings/{$value->id}/" class="installment_edit" id="{$value->id}">{$value->installment_name}</a></td>
                    <td>{$value->academic_year}</td>
                    <td>{$value->no_of_installment}</td>
                    <td>{$month[$value->start_month]}-{$value->start_date}</td>
                    <td>{$value->grace_period}</td>
                    <td><a href="javascript:void(0);" class="installment_stat" inst_id="{$value->id}" status="{}">{if $value->status eq '1'} <i class="fa fa-check"></i> {else} <i class="fa fa-times"></i> {/if}</a></td>
                </tr>
                {/foreach}
            </table>
            
                
            
        </div>
    </div>

</div>


{include file="sections/footer.tpl"}
