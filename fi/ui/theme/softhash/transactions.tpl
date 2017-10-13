{include file="sections/header.tpl"}

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="ibox float-e-margins">
            
            <div class="ibox-content">

                <table id="dt_table" class="table datatable table-bordered table-hover sys_table footable"  >
                    <thead>
                        <tr>
                            <th>{$_L['Date']}</th>
                            <th>{$_L['Account']}</th>
                            <th>{$_L['Type']}</th>

                            <th class="text-right">{$_L['Amount']}</th>

                            <th>{$_L['Description']}</th>
                            <th class="text-right">{$_L['Dr']}</th>
                            <th class="text-right">{$_L['Cr']}</th>
                            <th class="text-right">{$_L['Balance']}</th>
                        </tr>
                    </thead>
                    {*<th>{$_L['Manage']}</th>*}
                    {foreach $d as $ds}
                        <tr class="{if $ds['cr'] eq '0.00'}warning {else}info{/if}">
                            <td>{date( $_c['df'], strtotime($ds['date']))}</td>
                            <td>{$ds['accounts']}</td>
                            {*<td>{$ds['type']}</td>*}
                            {* From v 2.4 Sadia Sharmin *}

                            <td>
                                {if $ds['type'] eq 'Income'}
                                    {$_L['Income']}
                                {elseif $ds['type'] eq 'Expense'}
                                    {$_L['Expense']}
                                {elseif $ds['type'] eq 'Transfer'}
                                    {$_L['Transfer']}
                                {else}
                                    {$ds['type']}
                                {/if}
                            </td>

                            <td class="text-right amount">{$ds['amount']}</td>
                            <td>{$ds['description']}</td>
                            <td class="text-right amount">{$ds['dr']}</td>
                            <td class="text-right amount">{$ds['cr']}</td>
                            <td class="text-right"><span class="amount{if $ds['bal'] < 0} text-red{/if}" >{$ds['bal']}</span></td>
                            {*<td><a href="{$_url}transactions/manage/{$ds['id']}">{$_L['Manage']}</a></td>*}
                        </tr>
                    {/foreach}



                </table>

            </div>
        </div>
        {*$paginator['contents']*}
    </div>

</div> <!-- Row end-->

{include file="sections/footer.tpl"}

<script type="text/javascript">
    $('#dt_table').DataTable({
        dom: 'Bfrtp',
        paging:false,
        searching: false,
        ordering:false,
        buttons: [
            "pageLength",
            {
                extend: 'print',
                exportOptions: {
                }
            },
            {
                extend: 'copyHtml5',
                exportOptions: {
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                },
                customize: function (doc) {
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                }
            }
        ]
    }); 
 </script>