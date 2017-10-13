{include file="sections/header.tpl"}
<div class="row">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>{$account} {$_L['Statement']} [{date( $_c['df'], strtotime($fdate))} - {date( $_c['df'], strtotime($tdate))}]</h5>

        </div>
        <div class="ibox-content">

            <table class="table table-bordered sys_table" id="dt_table">
                <thead>
                    <tr>
                        <th>{$_L['Date']}</th>
                        <th>{$_L['Description']}</th>
                        <th class="text-right">{$_L['Dr']}</th>
                        <th class="text-right">{$_L['Cr']}</th>
                        <th class="text-right">{$_L['Balance']}</th>
                    </tr>
                </thead>

                <tbody>
                    {foreach $d as $ds}
                    <tr>
                        <td>{date( $_c['df'], strtotime($ds['date']))}</td>
                        <td>{$ds['description']}</td>
                        <td class="text-right">{$_c['currency_code']} {number_format($ds['dr'],2,$_c['dec_point'],$_c['thousands_sep'])}</td>
                        <td class="text-right">{$_c['currency_code']} {number_format($ds['cr'],2,$_c['dec_point'],$_c['thousands_sep'])}</td>
                        <td class="text-right"><span {if $ds['bal'] < 0}class="text-red"{/if}>{$_c['currency_code']} {number_format($ds['bal'],2,$_c['dec_point'],$_c['thousands_sep'])}</span></td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
            {* <div class="row">
                <div class="col-md-8">
                    &nbsp;
                </div>
                <div class="col-md-2" style="text-align: right"> 
                    <form class="form-horizontal" method="post" action="{$_url}export/printable" target="_blank">
                        <input type="hidden" name="fdate" value="{$fdate}">
                        <input type="hidden" name="tdate" value="{$tdate}">
                        <input type="hidden" name="stype" value="{$stype}">
                        <input type="hidden" name="account" value="{$account}">
                        <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-print"></i> {$_L['Export for Print']}</button>
                    </form>
                </div>
                <div class="col-md-2" style="text-align: right"> 
                    <form class="form-horizontal" method="post" action="{$_url}export/pdf">
                        <input type="hidden" name="fdate" value="{$fdate}">
                        <input type="hidden" name="tdate" value="{$tdate}">
                        <input type="hidden" name="stype" value="{$stype}">
                        <input type="hidden" name="account" value="{$account}">
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-file-pdf-o"></i> {$_L['Export to PDF']}</button>
                    </form>
                </div>
            </div> *}
        </div>
    </div>

    <!-- Widget-2 end-->
</div>
 <!-- Row end-->

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
                    columns: [ 0, 1, 2, 3, 4]
                }
            },
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4 ]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4 ]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4 ]
                },
                customize: function (doc) {
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                }
            }
        ]
    }); 
 </script>