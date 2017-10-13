{include file="sections/header.tpl"}
<div class="wrapper wrapper-content">
    <div class="row">

        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>
                        {if $type eq 'Product'}
                            {'Add Fee'}
                        {else if type eq 'Service'}
                            {'Add Charge'}
                        {else}
                            {'Add One Time Fee For Enquery'}
                        {/if}
                    </h5>
                    <div class="ibox-tools">
                        {if $type eq 'Product'}
                            <a href="{$_url}ps/p-list" class="btn btn-primary btn-xs">{'List Fees'}</a>
                        {/if}
                        {if $type eq 'Service'}
                            <a href="{$_url}ps/s-list" class="btn btn-primary btn-xs">{'List Charges'}</a>
                        {/if}
                        {if $type eq 'OneTimeFeeBeforeAdmission'}
                            <a href="{$_url}ps/one-time-fee-before-admission-list" class="btn btn-primary btn-xs">{'List of one time fees taken before admission'}</a>
                        {/if}
                    </div>
                </div>
                <div class="ibox-content" id="ibox_form">
                    <div class="alert alert-danger" id="emsg">
                        <span id="emsgbody"></span>
                    </div>

                    <form class="form-horizontal" id="rform">
                        <div class="form-group">
                            <label class="col-lg-2 control-label" >{'Academic Year'}<span class="mandatory">*</span></label>
                            <div class="col-lg-10">
                                <select id="academic_year" name="academic_year" class="form-control">
                                    <option value="">{'Academic Year'}</option>
                                    {foreach $ry as $y}
                                        <option value="{$y}{'-'}{$y+1}" >
                                            {$y}{'-'}{$y+1}
                                        </option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label" >{'Fee Type'} <span class="mandatory">*</span></label>
                            <div class="col-lg-10">
                                <select id="fee_type" name="fee_type" class="form-control">
                                    <option value="">{'Select Fee Type'}</option>
                                    {foreach $ftypes as $ftype}
                                        <option value="{$ftype['id']}" >
                                            {$ftype['name']}
                                        </option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        {if $type eq 'Product'}
                        <div class="form-group"><label class="col-lg-2 control-label" >{'Class'}<span class="mandatory">*</span></label>
                            <div class="col-lg-10">
                                <select id="group_id" name="group_id" class="form-control">
                                    <option value="{'0'}">{'All Class'}</option>
                                    {foreach $groups as $group}
                                        <option value="{$group['id']}" >
                                            {$group['gname']}
                                        </option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        {/if}
                        
                        <div class="form-group">
                            <label class="col-lg-2 control-label" for="name">{$_L['Name']}<span class="mandatory">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" id="name" name="name" class="form-control" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label" for="sales_price">{'Fee'} <span class="mandatory">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" id="sales_price" name="sales_price" class="form-control amount" autocomplete="off" data-a-sign="{$_c['currency_code']} "  data-a-dec="{$_c['dec_point']}" data-a-sep="{$_c['thousands_sep']}" data-d-group="2">
                            </div>
                        </div>
                            
                        <div class="form-group mand-opt dis-none">
                            <label class="col-lg-2 control-label" >Mandatory fees for enquery</label>
                            <div class="col-lg-10">
                                <label class="radio-inline">
                                    <input type="radio" name="optional_for_enquery" value="0">Mandatory
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="optional_for_enquery" value="1" checked>Optional
                                </label>
                            </div>
                        </div>

                        {if $type eq 'Product'}
                            {*<div class="form-group"><label class="col-lg-2 control-label" >Is one time admission fees</label>
                                <div class="col-lg-10">
                                    <select id="one_time_admission_fees" name="one_time_admission_fees" class="form-control">
                                        <option value="0" selected>No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>*}
                            <div class="form-group scholar-div">
                                <label class="col-lg-2 control-label">Scholarship Enable</label>
                                <div class="col-lg-10">
                                    <select id="scholarship_active" name="scholarship_active" class="form-control">
                                        <option value="0" selected>No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                        {/if}
                        
                        <!--<div class="form-group"><label class="col-lg-2 control-label" for="name">{*'Fee Start Date'*}</label>
                            <div class="col-lg-10">
                                <input type="text" datepicker data-date-format="yyyy-mm-dd" data-auto-close="true" id="fee_start_date" name="fee_start_date" class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group"><label class="col-lg-2 control-label" for="name">{*'Due Date'*}</label>
                            <div class="col-lg-10">
                                <input type="text" datepicker data-date-format="yyyy-mm-dd" data-auto-close="true" id="fee_due_date" name="fee_due_date" class="form-control" autocomplete="off">
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label class="col-lg-2 control-label" for="item_number">{*$_L['Item Number']*}</label>
                            <div class="col-lg-10">
                                <input type="hidden" id="item_number" value="{$nxt}" name="item_number" class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label" for="description">{$_L['Description']}</label>
                            <div class="col-lg-10"><textarea id="description" class="form-control" rows="3"></textarea></div>
                        </div>
                        <input type="hidden" id="type" name="type" value="{$type}">
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-sm btn-primary" type="submit" id="submit">{$_L['Submit']}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{include file="sections/footer.tpl"}