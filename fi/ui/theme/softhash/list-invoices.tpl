{include file="sections/header.tpl"}
<div class="ibox float-e-margins">
    <div class="ibox-title">
        
        <div class="ibox-tools">
            
            {*<a href="{$_url}invoices/list-recurring/" class="btn btn-success btn-xs"><i class="fa fa-repeat"></i> {$_L['Manage Recurring Invoices']}</a>*}
            <a href="{$_url}invoices/add/" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> {$_L['Add Invoice']}</a>

        </div>
    </div>
    <div class="ibox-content">

        {if $view_type == 'filter'}
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
        {/if}

        <table id="dt_table" class="table table datatable table-bordered table-hover sys_table footable" {if $view_type == 'filter'} data-filter="#foo_filter" data-page-size="50" {/if}>
            <thead>
            <tr>
                <th>#</th>
                <th>{$_L['Account']}</th>
                <th>{'Receipt No.'}</th>
                <th>{$_L['Amount']}</th>
                <th>{$_L['Payment Method']}</th>
                <th>{$_L['Invoice Date']}</th>
                <th>{$_L['Due Date']}</th>
                <th>{$_L['Status']}</th>
                <th class="text-right">{$_L['Manage']}</th>
            </tr>
            </thead>
            <tbody>

            {foreach $d as $ds}
                <tr>
                    <td><a href="{$_url}invoices/view/{$ds['id']}/"> {$ds['id']}</a> </td>
                    <td><a href="{$_url}contacts/view/{$ds['userid']}/">{$ds['account']}</a> </td>
                    
                    <td>{if $ds['status'] eq 'Paid' || $ds['status'] eq 'Partially Paid'}{$ds['id']|return_recno}{/if}</td>
                    <td class="amount">{$ds['total']}</td>
                    <td>{$ds['paymentmethod']}</td>
                    <td>{date( $_c['df'], strtotime($ds['date']))}</td>
                    <td>{date( $_c['df'], strtotime($ds['duedate']))}</td>
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
                    {*<td>
                        {if $ds['r'] eq '0'}
                            <span class="label label-success"><i class="fa fa-dot-circle-o"></i> {$_L['Onetime']}</span>
                          {else}
                            <span class="label label-success"><i class="fa fa-repeat"></i> {$_L['Recurring']}</span>
                    {/if}
                    </td>*}
                    <td class="text-right">
                        <a href="{$_url}invoices/view/{$ds['id']}/" class="btn btn-primary btn-xs"><i class="fa fa-check"></i> {$_L['View']}</a>
                        <!--<a {*if $ds['status'] eq 'Unpaid'}  href="{$_url}invoices/edit/{$ds['id']}/" {else} disabled='true' href="javascript:void(0);" title="Can't Edit"  {/if} class="btn btn-info btn-xs">
                            {if $ds['status'] eq 'Unpaid'} <i class="fa fa-pencil"></i> {$_L['Edit']} {else}  &nbsp;&nbsp;&nbsp;{'Paid'} {/if*}</a>  -->
                        <a href="#" class="btn btn-danger btn-xs cdelete" id="{$ds['id']}"><i class="fa fa-trash"></i> {'Cancel'}</a>
                    </td>
                </tr>
            {/foreach}

            </tbody>


        </table>
    </div>
    
    
    
</div>
{include file="sections/footer.tpl"}

<link href="{$b_url}/ui/lib/datatable/css/jquery.dataTables.min.css" rel="stylesheet">
<script>
{$amtNumeric}

function refreshTable(){
    window.table = $('#dt_table').DataTable({
                dom: 'Bfrtip',
                responsive: true,
                buttons: [
                    "pageLength",
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5 ]
                        }
                    },
                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5 ]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5 ]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5 ]
                        },
                        customize: function (doc) {
                            doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        }
                    }
                ],
                order: [[ 0, "desc" ]]
            }); 

            window.table.on('page.dt', function () {
                {$amtNumeric}
            });

            window.table.on('search.dt', function () {
                {$amtNumeric}
            });

}   

setTimeout(function(){
    refreshTable();
},1000);
</script>
