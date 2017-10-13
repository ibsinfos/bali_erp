{include file="sections/header.tpl"}
<div class="ibox float-e-margins">
    
    <div class="ibox-content">

         
        <form class="form-horizontal" method="post" action="{$_url}">
            {if $classes }
                <select name="class_id" id="class_id">
                    <option value="" >All Class</option>
                    {foreach $classes as $class}
                        <option  value="{$class["id"]}" >{$class["gname"]}</option>
                    {/foreach}
                </select>
            {/if}
            <div class="form-group" style="float: right; margin-right:70%">
                <input type="checkbox" class="create_mode_type" id="show_scholarship_invoice" name="show_scholarship_invoice">
                Show Scholarship Invoice
            </div>
            <br><br>
                    <a href="javascript:void(0);" onclick="filter_search();" class="btn btn-primary btn-xs"><i class="fa fa-search"></i> {$_L['Filter']}</a>
            <br><br> 
        </form>
                <table id="dt_table" class="table datatable table-bordered table-hover sys_table footable" {if $view_type == 'filter'} data-filter="#foo_filter" data-page-size="50" {/if}>
            <thead>
            <tr>
                <th>#</th>
                <th>{$_L['Account']}</th>
                <th>{$_L['Amount']}</th>
                <th>{$_L['Invoice Date']}</th>
                <th>{$_L['Due Date']}</th>
                <th>
                    {$_L['Status']}
                </th>
                <th class="text-right">{$_L['Manage']}</th>
            </tr>
            </thead>
            <tbody id="invoice_list_by_class">

            {foreach $d as $ds}
                <tr>
                    <td><a href="{$_url}invoices/view/{$ds['id']}/">{$ds['invoicenum']}{if $ds['cn'] neq ''} {$ds['cn']} {else} {$ds['id']} {/if}</a> </td>
                    <td><a href="{$_url}contacts/view/{$ds['userid']}/">{$ds['account']}</a> </td>
                    <td class="amount">{$ds['total']}</td>
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
                    
                    <td class="text-right">
                        <a href="{$_url}invoices/view/{$ds['id']}/" class="btn btn-primary btn-xs"><i class="fa fa-check"></i> {$_L['View']}</a>
                        <a href="#" class="btn btn-danger btn-xs cdelete" id="iid{$ds['id']}"><i class="fa fa-trash"></i> {'Cancel'}</a>
                         <input type="hidden" name="hdPage" id="hdPage" value="previous">
                        <!--<a {*if $ds['status'] eq 'Unpaid'}  href="{$_url}invoices/edit/{$ds['id']}/" {else} disabled='true' href="javascript:void(0);" title="Can't Edit"  {/if} class="btn btn-info btn-xs">
                            {if $ds['status'] eq 'Unpaid'} <i class="fa fa-pencil"></i> {$_L['Edit']} {else}  &nbsp;&nbsp;&nbsp;{'Paid'} {/if*}</a>  -->
                        {*<a href="#" class="btn btn-danger btn-xs cdelete" id="iid{$ds['id']}"><i class="fa fa-trash"></i> {$_L['Delete']}</a>*}
                    </td>
                </tr>
            {/foreach}

            </tbody>

            

        </table>
    </div>
</div>
{include file="sections/footer.tpl"}
<script type="text/javascript">
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

            {$amtNumeric}

            window.table.on('page.dt', function () {
                {$amtNumeric}
            });

            window.table.on('search.dt', function () {
                {$amtNumeric}
            });

}   
refreshTable();  

  function filter_search(){
      _url  =   $('#_url').val();
      if($('#show_scholarship_invoice').prop("checked")){
          var show_scholarship = 1;
      }else{
          var show_scholarship = 0;
      }
        $.post(_url + 'invoices/future-list/filter', {
            class_id: $('#class_id').val(),
            show_scholarship: show_scholarship,
            b_url    : _url
        })
        .done(function (data) {
            window.table.destroy();
            var adrs = $("#invoice_list_by_class");
            adrs.html(data);
            refreshTable(); 
        });
  }  
</script>