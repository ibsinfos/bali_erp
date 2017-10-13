{include file="sections/header.tpl"}

<div class="row">
{*    <div class="col-md-12" id="ib_graph"></div>*}
    <div class="col-md-12">
        <div class="ibox float-e-margins">

            <div class="ibox-content">
                <div class="row" id="d_ajax_summary">

                    <div class="col-md-4">
                        <div class="chart-statistic-box">
                            <div class="chart-txt">
                                <div class="chart-txt-top">
                                    <p><span class="amount number">{$net_worth}</span></p>
                                    <hr>
                                    <p class="caption">{$_L['Net Worth']}</p>
                                </div>
                                <table class="tbl-data">
                                    <tr>
                                        <td class="amount">{$ti}</td>
                                        <td>{'Payment Today'}</td>
                                    </tr>
                                    <tr>
                                        <td class="amount">{$te}</td>
                                        <td>{'Invoice Today'}</td>
                                    </tr>
                                    <tr>
                                        <td class="amount">{$mi}</td>
                                        <td>{'Total Payment'}</td>
                                    </tr>
                                    <tr>
                                        <td class="amount">{$me}</td>
                                        <td>{'Total Invoice'}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>    
                    
                    <div class="col-md-8">


                        <div class="chart-container">
                            <div class="" style="height:350px" id="inc_vs_exp_t"></div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div id="d_chart" style="height: 350px;"></div>
            </div>
        </div>

    </div>
</div>


<div class="row" id="sort_2">
    <div class="col-md-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <a href="#" id="set_goal" class="btn btn-primary btn-xs pull-right"><i class="fa fa-bullseye"></i> {$_L['Set Goal']}</a>
                <h5>{$_L['Net Worth n Account Balances']}</h5>
            </div>
            <div class="ibox-content" style="min-height: 365px;">
                <div>
                    <h3 class="text-center amount">{$net_worth}</h3>
                    <div>
                        <span class="amount">{$net_worth}</span> {$_L['of']} <span class="amount">{$_c['networth_goal']}</span>
                        <small class="pull-right"><span class="amount">{$pg}</span>%</small>
                    </div>
                    <div class="progress progress-small">
                        <div style="width: {$pgb}%;" class="progress-bar progress-bar-{$pgc}"></div>
                    </div>
                </div>
                <table class="table table-striped table-bordered" style="margin-top: 26px;">
                    <th>{$_L['Account']}</th>
                    <th class="text-right">{$_L['Balance']}</th>
                    {foreach $d as $ds}
                        <tr>
                            <td>{$ds['account']}</td>
                            <td class="text-right"><span class="amount{if $ds['balance'] < 0} text-red{/if}">{$ds['balance']}</span></td>
                        </tr>
                    {/foreach}
                </table>
            </div>
        </div>
    </div>


    <div class="col-md-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">

                <h5>{'Payment vs Invoice'} - {ib_lan_get_line(date('F'))} {date('Y')}</h5>
            </div>
            <div class="ibox-content">
                <div id="inc_exp_pie" style="height: 330px;">
                </div>
            </div>
        </div>

    </div>

</div>

<div class="row" id="sort_4">
    <div class="col-md-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <a href="{$_url}invoices/list/" class="btn btn-primary btn-xs pull-right"><i class="fa fa-list"></i> {$_L['Invoices']}</a>
                <h5>{$_L['Recent Invoices']}</h5>
            </div>
            <div class="ibox-content">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{$_L['Account']}</th>
                        <th>{$_L['Amount']}</th>
                        <th>{$_L['Invoice Date']}</th>
                        <th>{$_L['Due Date']}</th>
                        <th>{$_L['Status']}</th>
                        {*<th>{$_L['Type']}</th>*}
                        <th class="text-right">{$_L['Manage']}</th>
                    </tr>
                    </thead>
                    <tbody>

                    {foreach $invoices as $ds}
                        <tr>
                            <td><a href="{$_url}invoices/view/{$ds['id']}/">{$ds['invoicenum']}{if $ds['cn'] neq ''} {$ds['cn']} {else} {$ds['id']} {/if}</a> </td>
                            <td><a href="{$_url}contacts/view/{$ds['userid']}/">{$ds['account']}</a> </td>
                            <td class="amount">{$ds['total']}</td>
                            <td>{date( $_c['df'], strtotime($ds['date']))}</td>
                            <td>{date( $_c['df'], strtotime($ds['duedate']))}</td>
                            <td>
                                {ib_lan_get_line($ds['status'])}

                            </td>
                            {*<td>
                                {if $ds['r'] eq '0'}
                                    <span class="label label-success"><i class="fa fa-dot-circle-o"></i> {$_L['Onetime']}</span>
                                {else}
                                    <span class="label label-success"><i class="fa fa-repeat"></i> {$_L['Recurring']}</span>
                                {/if}
                            </td>*}
                            <td class="text-right">
                                <a href="{$_url}invoices/view/{$ds['id']}/" class="btn btn-primary btn-xs"><i class="fa fa-check"></i> {$_L['View']}</a>
                                {*<a href="{$_url}invoices/edit/{$ds['id']}/" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> {$_L['Edit']}</a>*}
                            </td>
                        </tr>
                    {/foreach}

                    </tbody>
                </table>
            </div>
        </div>

    </div>


</div>

<div class="row" id="sort_3">
    <div class="col-md-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">

                <h5>{'Latest Payment'}</h5>
            </div>
            <div class="ibox-content">
                <table class="table table-striped table-bordered">
                    <th>{$_L['Date']}</th>
                    <th>{$_L['Description']}</th>
                    <th class="text-right">{$_L['Amount']}</th>
                    {foreach $inc as $incs}
                        <tr>
                            <td>{date( $_c['df'], strtotime($incs['date']))}</td>
                            <td><a href="{$_url}transactions/manage/{$incs['id']}/">{$incs['description']}</a> </td>
                            <td class="text-right amount">{$incs['amount']}</td>
                        </tr>
                    {/foreach}



                </table>
            </div>
        </div>

    </div>


    <div class="col-md-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">

                <h5>{'Latest Invoice'}</h5>
            </div>
            <div class="ibox-content">
                <table class="table table-striped table-bordered">
                    <th>{$_L['Date']}</th>
                    <th>{$_L['Description']}</th>
                    <th class="text-right">{$_L['Amount']}</th>
                    {foreach $exp as $exps}
                        <tr>
                            <td>{date( $_c['df'], strtotime($exps['date']))}</td>
                            <td><a href="{$_url}transactions/manage/{$exps['id']}/">{$exps['description']}</a> </td>
                            <td class="text-right amount">{$exps['amount']}</td>
                        </tr>
                    {/foreach}



                </table>
            </div>
        </div>

    </div>


</div>

{include file="sections/footer.tpl"}