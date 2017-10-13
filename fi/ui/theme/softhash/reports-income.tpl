{include file="sections/header.tpl"}
<div class="row">


    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{'Payment Reports'} </h5>

            </div>
            <div class="ibox-content">


                <h4>{'Payment Summary'}</h4>
                <hr>
                <h5>{'Total Payment'}: {$_c['currency_code']}  {number_format($a,2,$_c['dec_point'],$_c['thousands_sep'])}</h5>
                <h5>{'Total Payment This Month'}: {$_c['currency_code']} {number_format($m,2,$_c['dec_point'],$_c['thousands_sep'])}</h5>
                <h5>{'Total Payment This Week'}: {$_c['currency_code']}  {number_format($w,2,$_c['dec_point'],$_c['thousands_sep'])}</h5>
                <h5>{'Total Payment Last 30 days'}: {$_c['currency_code']} {number_format($m3,2,$_c['dec_point'],$_c['thousands_sep'])}</h5>


                <hr>
                <h4>{'Last 20 Payment'}</h4>
                <hr>
                <table class="table table-striped table-bordered" id="dt_table">
                    <thead>
                        <tr>
                            <th>{$_L['Date']}</th>
                            <th>{$_L['Account']}</th>
                            <th>{$_L['Type']}</th>
                            <th>{$_L['Category']}</th>
                            <th class="text-right">{$_L['Amount']}</th>
                            <th>{$_L['Payer']}</th>
                            <th>{$_L['Description']}</th>
                            <th class="text-right">{$_L['Cr']}</th>
                            <th class="text-right">{$_L['Balance']}</th>
                        </tr>    
                    </thead>
                    <tbody>
                    {foreach $d as $ds}
                        <tr>
                            <td>{date( $_c['df'], strtotime($ds['date']))}</td>
                            <td>{$ds['account']}</td>
                            <td>{ib_lan_get_line($ds['type'])}</td>
                            <td>{if $ds['category'] == 'Uncategorized'}{$_L['Uncategorized']} {else} {$ds['category']} {/if}</td>
                            <td class="text-right">{$_c['currency_code']} {number_format($ds['amount'],2,$_c['dec_point'],$_c['thousands_sep'])}</td>
                            <td>{$ds['payer_name']}</td>
                            <td>{$ds['description']}</td>
                            <td class="text-right">{$_c['currency_code']} {number_format($ds['cr'],2,$_c['dec_point'],$_c['thousands_sep'])}</td>
                            <td class="text-right"><span {if $ds['bal'] < 0}class="text-red"{/if}>{$_c['currency_code']} {number_format($ds['bal'],2,$_c['dec_point'],$_c['thousands_sep'])}</span></td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
                <hr>
                <h4>{'Monthly Payment Graph'}</h4>
                <hr>
                <div id="placeholder" class="flot-placeholder"></div>
                <hr>


            </div>
        </div>
    </div>



    <!-- Widget-2 end-->
</div>
{include file="sections/footer.tpl"}

<script type="text/javascript">
    $('#dt_table').DataTable({
        dom: 'Bfrtp',
        responsive: true,
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