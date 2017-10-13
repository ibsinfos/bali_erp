{include file="sections/header.tpl"}
<div class="ibox float-e-margins">
    <div class="ibox-title">
        {if $view_type == 'filter'}
<h5>{$_L['Total']} : {$total_invoice}</h5>
            
        {/if}
        {*<div class="ibox-tools">
            {if $view_type neq 'filter'}
                <a href="{$_url}non-enroll-receipt/view-list/filter/" class="btn btn-primary btn-xs"><i class="fa fa-search"></i> {$_L['Filter']}</a>
                {else}
                <a href="{$_url}non-enroll-receipt/view-list/" class="btn btn-primary btn-xs"><i class="fa fa-arrow-left"></i> {$_L['Back']}</a>
            {/if}
        </div>*}
    </div>
    <div class="ibox-content">

        {*if $view_type == 'filter'}
            <form class="form-horizontal" method="post" action="{$_url}customers/list/">
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="fa fa-search"></span>
                            </div>
                            <input type="text" name="name" id="foo_filter" class="form-control" placeholder="{$_L['Search']}..."/>

                        </div>
                    </div>

                </div>
            </form>
        {/if*}

        <table  id="dt_table" class="table table-bordered table-hover sys_table footable" {if $view_type == 'filter'} data-filter="#foo_filter" data-page-size="50" {/if}>
            <thead>
            <tr>
                <th>#</th>
                <th>{$_L['Account']}</th>
                <th>{$_L['Amount']}</th>
                <th>{'Payment Date'}</th>
                <th class="text-right">{'Action'}</th>
            </tr>
            </thead>
            <tbody>
            {if count($d) eq "0"}
                <tr><td colspan="6">No data available</td></tr>
            {else}
                {foreach $d as $ds}
                    <tr>
                        <td><a href="{$_url}non-enroll-receipt/receipt-view/{$ds['id']}/">{$ds['invoicenum']}{if $ds['cn'] neq ''} {$ds['cn']} {else} {$ds['id']} {/if}</a> </td>
                        {*<td><a href="{$_url}contacts/view/{$ds['userid']}/">{$ds['account']}</a> </td>*}
                        <td>{$ds['account']}</td>
                        <td class="amount">{$ds['total']}</td>
                        <td>{date( $_c['df'], strtotime($ds['date']))}</td>
                        {*<td>{date( $_c['df'], strtotime($ds['duedate']))}</td>
                        <td>

                            {if $ds['status'] eq 'Unpaid'}
                                <span class="label label-danger">{ib_lan_get_line($ds['status'])}</span>
                                {elseif $ds['status'] eq 'Paid'}
                                <span class="label label-success">{ib_lan_get_line($ds['status'])}</span>
                            {elseif $ds['status'] eq 'Partially Paid'}
                                <span class="label label-info">{ib_lan_get_line($ds['status'])}</span>
                            {elseif $ds['status'] eq 'Cancelled'}
                                <span class="label">{ib_lan_get_line($ds['status'])}</span>
                            {else}
                                {ib_lan_get_line($ds['status'])}
                            {/if}



                        </td>
                        <td>
                            {if $ds['r'] eq '0'}
                                <span class="label label-success"><i class="fa fa-dot-circle-o"></i> {$_L['Onetime']}</span>
                              {else}
                                <span class="label label-success"><i class="fa fa-repeat"></i> {$_L['Recurring']}</span>
                        {/if}
                        </td>*}
                        <td class="text-right">
                            <a href="{$_url}iview/receipt-non-enroll/{$ds['id']}/{$ds['vtoken']}" class="btn btn-primary btn-xs" target="_blank"><i class="fa fa-check"></i> {$_L['View']} {' Payment Receipt'}</a>
                            <!--<a {*if $ds['status'] eq 'Unpaid'}  href="{$_url}invoices/edit/{$ds['id']}/" {else} disabled='true' href="javascript:void(0);" title="Can't Edit"  {/if} class="btn btn-info btn-xs">
                                {if $ds['status'] eq 'Unpaid'} <i class="fa fa-pencil"></i> {$_L['Edit']} {else}  &nbsp;&nbsp;&nbsp;{'Paid'} {/if*}</a>  -->
                            {*<a href="#" class="btn btn-danger btn-xs cdelete" id="iid{$ds['id']}"><i class="fa fa-trash"></i> {$_L['Delete']}</a>*}
                        </td>
                    </tr>
                {/foreach}
            {/if}
        </tbody>

            

        </table>

    </div>
</div>
{include file="sections/footer.tpl"}