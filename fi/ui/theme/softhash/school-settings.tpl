{include file="sections/header.tpl"}
<div class="row">
    <div class="alert alert-danger" id="emsg">
        <span id="emsgbody"></span>
    </div>

    <div class="col-md-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{'Fee Installments'}</h5>
            </div>
            <div class="ibox-content">
                <div class="form-group col-lg-12">
                    <label class="col-lg-4" for="header_scripts">{'Academic Year'}</label>
                    <span class="col-md-8">
                        <select id="academic_year" name="academic_year" class="form-control">
                            {foreach $ry as $y}
                                <option {if $y eq $r_year} selected="selected" {/if} value="{$y}" >
                                    {$y}
                                </option>
                            {/foreach}
                        </select>
                    </span>
                </div>
                <br><br>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{'Set School Installment For Fee Type'}</h5>
            </div>
            <form class="form-horizontal" id="school-inst-setting">
                <div class="ibox-content">
                    {if count($installments) eq '0'}
                        <div class="form-group  col-lg-12">
                            <span class="col-md-12 alert-danger">
                                No Installment Added for {$r_year}
                            </span>
                        </div>
                    {/if}
                    {if $school_settings['academic_year']!=''}
                        <input type="hidden" value="{$school_settings['id']}" id="settings_id" name="settings_id">
                    {/if}
                    <div class="form-group col-lg-12">
                        <label class="col-lg-4" for="header_scripts">{'School Fee Installments'}</label>
                        <span class="col-md-8">
                            <select multiple="true" id="tutionfee_installments" name="tutionfee_installments" class="form-control">
                                {foreach $installments as $instalment}
                                    <option {if $instalment->id|in_array:$school_settings['schoolfee_inst_types']}selected="true"{/if} value="{$instalment->id}">{$instalment->installment_name}</option>
                                {/foreach}
                            </select>
                        </span>
                    </div>
                    <div class="form-group col-lg-12">
                        <label class="col-lg-4" for="header_scripts">{'Transport Fee Installments'}</label>
                        <span class="col-md-8">
                            <select multiple="true" id="transpfee_installments" name="transpfee_installments" class="form-control">
                                {foreach $installments as $instalment}
                                    <option {if $instalment->id|in_array:$school_settings['transfee_inst_types']}selected="true"{/if} value="{$instalment->id}">{$instalment->installment_name}</option>
                                {/foreach}
                            </select>
                        </span>
                    </div>
                    <div class="form-group col-lg-12">
                        <label class="col-lg-4" for="header_scripts">{'Hostel Fee Installments'}</label>
                        <span class="col-md-8">
                            <select multiple="true" id="hostelfee_installments" name="hostelfee_installments" class="form-control">
                                {foreach $installments as $instalment}
                                    <option {if $instalment->id|in_array:$school_settings['hostelfee_inst_types']}selected="true"{/if} value="{$instalment->id}">{$instalment->installment_name}</option>
                                {/foreach}
                            </select>
                        </span>
                    </div>
                    <button type="submit" id="submit"{if $school_settings['academic_year']==''} action="add"{else} action="update" {/if}{if $school_settings['locked'] == '1'}disabled="true"{/if} class="btn btn-primary">{if $school_settings['locked'] == '1'}Locked{else}Update{/if}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-6">
        <div class="ibox-title">
            <h5>{'Installments Available'}</h5>
        </div>
        <div class="ibox-content">
            <table class="table table-bordered table-hover sys_table footable" data-page-size="50">
                <tr>
                    <th >#</th>
                    <th>Installment Name</th>
                    <th>No</th>
                    <th>School Fee</th>
                    <th>Transport Fee</th>
                    <th>Hostel Fee</th>
                </tr>
                {if $school_settings['academic_year']==''}
                    <tr>
                        <td colspan="6">{$r_year} Settings Not Added</td>
                    </tr>
                {else}    
                    {foreach $installments as $key=>$value}
                    <tr>
                        <td>{$count++}</td>
                        <td>{$value->installment_name}</td>
                        <td>{$value->no_of_installment}</td>
                        <td>{if $value->id|in_array:$school_settings['schoolfee_inst_types']}<i class="fa fa-check"></i> {else} <i class="fa fa-times"></i> {/if}</td>
                        <td>{if $value->id|in_array:$school_settings['transfee_inst_types']}<i class="fa fa-check"></i> {else} <i class="fa fa-times"></i> {/if}</td>
                        <td>{if $value->id|in_array:$school_settings['hostelfee_inst_types']}<i class="fa fa-check"></i> {else} <i class="fa fa-times"></i> {/if}</td>
                    </tr>
                    {/foreach}
                {/if}
            </table>
        </div>
    </div>
</div>


{include file="sections/footer.tpl"}
